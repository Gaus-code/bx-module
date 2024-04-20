<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine\Controller;
use GeoIp2\Record\Location;
use Up\Ukan\Model\EO_Feedback;
use Up\Ukan\Model\EO_Feedback_Entity;
use Up\Ukan\Model\FeedbackTable;
use Up\Ukan\Model\TaskTable;

class Feedback extends Controller
{
	public function createAction(
		$taskId,
		$fromUserId,
		$toUserId,
		$rating,
		$comment
	)
	{
		if (!$this->dataValidation($taskId, $fromUserId, $toUserId))
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

		LocalRedirect("/task/" . $taskId . "/");
	}

	public function editAction(
		$feedbackId,
		$rating,
		$comment
	)
	{
		global $USER;
		$userId = (int)$USER->GetID();

		$feedback=FeedbackTable::getById($feedbackId)->fetchObject();

		if ($feedback->getFromUserId()!==$userId)
		{
			LocalRedirect("/profile/".$userId."/feedbacks/");
		}

		$feedback->setRating($rating)
				 ->setComment($comment);

		$feedback->save();

		LocalRedirect("/profile/".$userId."/feedbacks/");
	}

	public function deleteAction(
		$feedbackId,
	)
	{
		global $USER;
		$userId = (int)$USER->GetID();

		$feedback=FeedbackTable::getById($feedbackId)->fetchObject();

		if ($feedback->getFromUserId()!==$userId)
		{
			LocalRedirect("/profile/".$userId."/feedbacks/");
		}

		$feedback->delete();

		LocalRedirect("/profile/".$userId."/feedbacks/");
	}

	private function dataValidation(
		$taskId,
		$fromUserId,
		$toUserId
	)
	{
		global $USER;
		$userId = $USER->GetID();
		if ($fromUserId !== $userId)
		{
			return false;
		}

		$task = TaskTable::query()->setSelect(['ID', 'CLIENT_ID', 'CONTRACTOR_ID'])->where('ID', $taskId)->whereIn(
				'CLIENT_ID',
				[$fromUserId, $toUserId]
			)->whereIn('CONTRACTOR_ID', [$fromUserId, $toUserId])->fetchObject();

		if (!isset($task))
		{
			return false;
		}

		return true;
	}
}