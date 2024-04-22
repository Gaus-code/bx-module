<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine\Controller;
use GeoIp2\Record\Location;
use Up\Ukan\AI\YandexGPT;
use Up\Ukan\Model\EO_Feedback;
use Up\Ukan\Model\EO_Feedback_Entity;
use Up\Ukan\Model\FeedbackTable;
use Up\Ukan\Model\TaskTable;
use Up\Ukan\Model\UserTable;

class Feedback extends Controller
{
	public function createAction(
		int $taskId,
		int $fromUserId,
		int $toUserId,
		int $rating,
		string $comment
	)
	{
		if (!$this->dataValidation($taskId, $fromUserId, $toUserId))
		{
			LocalRedirect("/task/" . $taskId . "/");
		}
		if (!YandexGPT::censorshipCheck($comment))
		{
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
		int $feedbackId,
		int $rating,
		string $comment
	)
	{
		global $USER;
		$userId = (int)$USER->GetID();

		$feedback=FeedbackTable::getById($feedbackId)->fetchObject();

		if ($feedback->getFromUserId()!==$userId)
		{
			LocalRedirect("/profile/".$userId."/feedbacks/");
		}
		if (!YandexGPT::censorshipCheck($comment))
		{
			LocalRedirect("/profile/".$userId."/feedbacks/");
		}

		$feedback->setRating($rating)
				 ->setComment($comment);

		$feedback->save();

		$this->updateUserRating($feedback->getToUserId(), $rating, 'editFeedback');

		LocalRedirect("/profile/".$userId."/feedbacks/");
	}

	public function deleteAction(
		int $feedbackId,
	)
	{
		global $USER;
		$userId = (int)$USER->GetID();

		$feedback=FeedbackTable::getById($feedbackId)->fetchObject();

		if ($feedback->getFromUserId()!==$userId)
		{
			LocalRedirect("/profile/".$userId."/feedbacks/");
		}

		$this->updateUserRating($feedback->getToUserId(), $feedback->getRating(), 'deleteFeedback');

		$feedback->delete();

		LocalRedirect("/profile/".$userId."/feedbacks/");
	}

	private function dataValidation(
		int $taskId,
		int $fromUserId,
		int $toUserId
	)
	{
		global $USER;
		$userId = $USER->GetID();
		if ($fromUserId !== $userId)
		{
			return false;
		}

		$task = TaskTable::query()->setSelect(['ID', 'CLIENT_ID', 'CONTRACTOR_ID'])
								  ->where('ID', $taskId)
								  ->whereIn('CLIENT_ID', [$fromUserId, $toUserId])
								  ->whereIn('CONTRACTOR_ID', [$fromUserId, $toUserId])
								  ->fetchObject();

		if (!isset($task))
		{
			return false;
		}

		$feedback = FeedbackTable::query()->setSelect(['ID'])
										  ->where('TO_USER_ID', $toUserId)
										  ->where('TASK_ID', $taskId)
										  ->fetchObject();

		if (isset($feedback))
		{
			return false;
		}

		return true;
	}

	private function updateUserRating(
		int $userId,
		int $rating,
		string $action
	)
	{
		$user = UserTable::getByPrimary($userId)->fetchObject();
		switch ($action){
			case 'addFeedback':
				$oldFeedbackCount=$user->getFeedbackCount();
				$oldRating=$user->getRating();
				$newFeedbackCount=$oldFeedbackCount+1;
				$newRating=($oldRating*$oldFeedbackCount+$rating)/$newFeedbackCount;
				$user->setRating($newRating)->setFeedbackCount($newFeedbackCount);
				break;
			case 'editFeedback':
				$feedbackCount=$user->GetFeedbackCount();
				$oldRating=$user->getRating();
				$newRating=($oldRating*$feedbackCount-$oldRating+$rating)/$feedbackCount;
				$user->setRating($newRating);
				break;
			case 'deleteFeedback':
				$oldFeedbackCount=$user->GetFeedbackCount();
				$oldRating=$user->getRating();
				$newFeedbackCount=$oldFeedbackCount-1;
				$newRating=($oldRating*$oldFeedbackCount-$rating)/$newFeedbackCount;
				$user->setRating($newRating)->setFeedbackCount($newFeedbackCount);
				break;
		}
		$user->save();
	}
}