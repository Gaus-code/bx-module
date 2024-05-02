<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine\Controller;
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
		?int    $rating = null,
		?string $comment = null,
	)
	{

		$errors = $this->validateDataCreateFeedback(
			$taskId,
			$fromUserId,
			$toUserId,
			$rating,
			$comment
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
				 ->setComment($comment);

		$feedback->save();

		$this->updateUserRating($toUserId, $rating, 'addFeedback');

		LocalRedirect("/task/" . $taskId . "/");
	}

	public function editAction(
		?int    $feedbackId,
		?int    $rating,
		?string $comment
	)
	{

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

		$this->updateUserRating($feedback->getToUserId(), $rating, 'editFeedback');

		LocalRedirect("/task/" . $feedback->getTaskId() . "/");
	}

	public function deleteAction(
		int $feedbackId,
	)
	{
		global $USER;
		$userId = (int)$USER->GetID();

		$feedback = FeedbackTable::getById($feedbackId)->fetchObject();

		if (!$feedback || $feedback->getFromUserId() !== $userId)
		{
			LocalRedirect("/access/denied/");
		}

		$this->updateUserRating($feedback->getToUserId(), $feedback->getRating(), 'deleteFeedback');

		$feedback->delete();

		LocalRedirect("/profile/" . $userId . "/feedbacks/");
	}

	private function validateDataCreateFeedback(
		?int    $taskId,
		?int    $fromUserId,
		?int    $toUserId,
		?int    $rating,
		?string $comment
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

		if (!YandexGPT::censorshipCheck($comment))
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

		if (!YandexGPT::censorshipCheck($comment))
		{
			$errors[] = 'Ваш отзыв не прошел цензуру от великого YandexGPT';
		}

		return [$errors, $feedback];
	}

	private function updateUserRating(
		int    $userId,
		int    $rating,
		string $action
	)
	{
		$user = UserTable::getByPrimary($userId)->fetchObject();
		switch ($action)
		{
			case 'addFeedback':
				$oldFeedbackCount = $user->getFeedbackCount();
				$oldRating = $user->getRating();
				$newFeedbackCount = $oldFeedbackCount + 1;
				$newRating = ($oldRating * $oldFeedbackCount + $rating) / $newFeedbackCount;
				$user->setRating($newRating)->setFeedbackCount($newFeedbackCount);
				break;
			case 'editFeedback':
				$feedbackCount = $user->getFeedbackCount();
				$oldRating = $user->getRating();
				$newRating = ($oldRating * $feedbackCount - $oldRating + $rating) / $feedbackCount;
				$user->setRating($newRating);
				break;
			case 'deleteFeedback':
				$oldFeedbackCount = $user->getFeedbackCount();
				$oldRating = $user->getRating();
				$newFeedbackCount = $oldFeedbackCount - 1;
				$newRating = ($oldRating * $oldFeedbackCount - $rating) / $newFeedbackCount;
				$user->setRating($newRating)->setFeedbackCount($newFeedbackCount);
				break;
		}
		$user->save();
	}
}