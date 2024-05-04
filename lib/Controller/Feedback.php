<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine\Controller;
use Up\Ukan\AI\AI;
use Up\Ukan\AI\YandexGPT;
use Up\Ukan\Model\EO_Feedback;
use Up\Ukan\Model\FeedbackTable;
use Up\Ukan\Model\TaskTable;
use Up\Ukan\Model\UserTable;

class Feedback extends Controller
{
	public function createAction(
		?int    $taskId = null,
		?int    $fromUserId = null,
		?int    $toUserId = null,
		?string    $toUserRole = null,
		?int    $rating = null,
		?string $comment = null,
	)
	{

		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		$errors = $this->validateDataCreateFeedback(
			$taskId,
			$fromUserId,
			$toUserId,
			$rating,
			$comment,
			$toUserRole
		);

		if ($errors !== [])
		{
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/task/" . $taskId . "/");
		}

		$feedback = new EO_Feedback();
		$feedback->setFromUserId($fromUserId)
				 ->setToUserId($toUserId)
				 ->setTaskId($taskId)
				 ->setRating($rating)
				 ->setComment($comment)
				 ->setToUserRole($toUserRole);

		$feedback->save();

		LocalRedirect("/task/" . $taskId . "/");
	}

	public function editAction(
		?int    $feedbackId,
		?int    $rating,
		?string $comment
	)
	{

		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		[$errors, $feedback] = $this->validateDataUpdateFeedback(
			$feedbackId,
			$rating,
			$comment
		);

		if ($errors !== [])
		{
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/feedback/$feedbackId/edit/");
		}

		$feedback->setRating($rating)->setComment($comment);

		$feedback->save();

		LocalRedirect("/task/" . $feedback->getTaskId() . "/");
	}

	public function deleteAction(
		int $feedbackId,
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		$userId = (int)$USER->GetID();

		$feedback = FeedbackTable::getById($feedbackId)->fetchObject();

		if (!$feedback || $feedback->getFromUserId() !== $userId)
		{
			LocalRedirect("/access/denied/");
		}

		$feedback->delete();

		LocalRedirect("/profile/" . $userId . "/feedbacks/");
	}

	private function validateDataCreateFeedback(
		?int    $taskId,
		?int    $fromUserId,
		?int    $toUserId,
		?int    $rating,
		?string $comment,
		?string $toUserRole
	): array
	{

		$errors = [];

		global $USER;
		$userId = (int)$USER->GetID();
		if ($fromUserId !== $userId)
		{
			LocalRedirect("/access/denied/");
		}

		$task = TaskTable::query()
						 ->setSelect(['ID', 'CLIENT_ID', 'CONTRACTOR_ID'])
						 ->where('ID', $taskId)
						 ->whereIn('CLIENT_ID', [$fromUserId, $toUserId])
						 ->whereIn('CONTRACTOR_ID', [$fromUserId, $toUserId])
						 ->fetchObject();

		if (!isset($task))
		{
			LocalRedirect("/access/denied/");
		}

		$feedback = FeedbackTable::query()
								 ->setSelect(['ID'])
								 ->where('TO_USER_ID', $toUserId)
								 ->where('TASK_ID', $taskId)
								 ->fetchObject();

		$user = UserTable::getById($fromUserId)->fetchObject();
		if ($user && $user->getIsBanned())
		{
			$errors[] = 'Вы заблокированы и не можете воспользоваться всем функционалом нашего сервиса';
			return $errors;
		}

		if (isset($feedback))
		{
			$errors[] = 'Похоже, вы уже оставили отзыв😑';
		}

		if (!$rating || !is_numeric($rating) || (int)$rating < 0)
		{
			$errors [] = 'Оцените пользователя';
		}

		if ($comment && !preg_match('/^[\p{L}\p{N}\s.,;:!?()\-_]+$/u', $comment))
		{
			$errors[] = 'Отзыв может содержать только буквы, цифры, знаки препинания и круглые скобки';
		}

		if ($toUserRole!=='Client' && $toUserRole!=='Contractor')
		{
			$errors[] = 'ToUserRole введена некоректно';
		}

		if ($errors)
		{
			return $errors;
		}

		if (!AI::censorshipCheck($comment))
		{
			$errors[] = 'Ваш отзыв не прошел цензуру от великого YandexGPT';
		}

		return $errors;
	}

	private function validateDataUpdateFeedback(
		?int    $feedbackId,
		?int    $rating,
		?string $comment
	): array
	{

		global $USER;
		$userId = (int)$USER->GetID();

		$errors = [];

		$feedback = FeedbackTable::getById($feedbackId)->fetchObject();
		if (!$feedback || $feedback->getFromUserId() !== $userId)
		{
			LocalRedirect("/access/denied/");
		}

		$user = $feedback->fillFromUser();
		if ($user && $user->getIsBanned())
		{
			$errors[] = 'Вы заблокированы и не можете воспользоваться всем функционалом нашего сервиса';
			return $errors;
		}

		if ($feedback->getIsBanned())
		{
			$errors [] = 'Отзыв заблокирован, Вы не можете его отредактировать!';
			return $errors;
		}

		if (!$rating || !is_numeric($rating) || (int)$rating < 0)
		{
			$errors [] = 'Оцените пользователя';
		}

		if ($comment)
		{
			if (!preg_match('/^[\p{L}\p{N}\s.,;:!?()\-_]+$/u', $comment))
			{
				$errors[] = 'Отзыв может содержать только буквы, цифры, знаки препинания и круглые скобки';
			}
		}
		if ($errors)
		{
			return $errors;
		}
		if (!AI::censorshipCheck($comment))
		{
			$errors[] = 'Ваш отзыв не прошел цензуру от великого YandexGPT';
		}

		return [$errors, $feedback];
	}

}