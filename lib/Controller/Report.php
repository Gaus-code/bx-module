<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;
use Up\Ukan\Model\EO_Reports;
use Up\Ukan\Model\FeedbackTable;
use Up\Ukan\Model\ReportsTable;
use Up\Ukan\Model\TaskTable;
use Up\Ukan\Model\UserTable;

class Report extends Engine\Controller
{

	public function createAction(
		string $complaintType = null,
		string $complaintMessage = null,
		int    $toUserId = null,
		int    $taskId = null,
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		$fromUserId = (int)$USER->getId();
		switch ($complaintType)
		{
			case 'task':
				$this->createReportOnTask($fromUserId, $complaintMessage, $taskId);
				break;
			case 'user':
				$this->createReportOnUser($fromUserId, $complaintMessage, $toUserId);
				break;
			case 'feedback':
				$this->createReportOnFeedback($fromUserId, $complaintMessage, $taskId);
				break;
			default:
				LocalRedirect("/access/denied/");
		}
	}

	public function deleteAction(
		int $reportId = null
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		if (!$USER->IsAdmin())
		{
			LocalRedirect("/access/denied/");
		}

		$report = ReportsTable::getById($reportId)->fetchObject();
		if (!$report)
		{
			LocalRedirect("/access/denied/");
		}

		ReportsTable::delete($reportId);

		LocalRedirect("/admin/");

	}

	private function createReportOnTask(int $fromUserId, string $complaintMessage, int $taskId)
	{
		$task = TaskTable::getById($taskId)->fetchObject();
		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}

		$toUserId = $task->getClientId();

		$report = \Up\Ukan\Model\ReportsTable::query()
											 ->setSelect(['ID'])
											 ->where('FROM_USER_ID', $fromUserId)
											 ->where('TASK_ID', $taskId)
											 ->where('TYPE', 'task')
											 ->fetchObject();

		if ($report)
		{
			LocalRedirect("/access/denied/");
		}

		$report = new EO_Reports();
		$report->setType('task')
			   ->setTaskId($taskId)
			   ->setFromUserId($fromUserId)
			   ->setToUserId($toUserId);

		if ($complaintMessage)
		{
			$report->setMessage($complaintMessage);
		}
		$report->save();

		LocalRedirect("/task/$taskId/");
	}

	private function createReportOnUser(int $fromUserId, string $complaintMessage, int $toUserId)
	{
		$toUser = UserTable::getById($toUserId)->fetchObject();
		if (!$toUser)
		{
			LocalRedirect("/access/denied/");
		}
		$report = \Up\Ukan\Model\ReportsTable::query()
											 ->setSelect(['ID'])
											 ->where('FROM_USER_ID', $fromUserId)
											 ->where('TO_USER_ID', $toUserId)
											 ->where('TYPE', 'user')
											 ->fetchObject();

		if ($report)
		{
			LocalRedirect("/access/denied/");
		}

		$report = new EO_Reports();
		$report->setType('user')
			   ->setFromUserId($fromUserId)
			   ->setToUserId($toUserId);

		if ($complaintMessage)
		{
			$report->setMessage($complaintMessage);
		}
		$report->save();

		LocalRedirect("/profile/$toUserId/");

	}

	private function createReportOnFeedback(int $fromUserId, string $complaintMessage, int $taskId)
	{
		$task = TaskTable::getById($taskId)->fetchObject();
		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}

		$report = \Up\Ukan\Model\ReportsTable::query()
											 ->setSelect(['ID'])
											 ->where('FROM_USER_ID', $fromUserId)
											 ->where('TASK_ID', $taskId)
											 ->where('TYPE', 'feedback')
											 ->fetchObject();

		if ($report)
		{
			LocalRedirect("/access/denied/");
		}

		$feedback = FeedbackTable::query()->setSelect(['*'])
										  ->where('TO_USER_ID', $fromUserId)
										  ->where('TASK_ID', $taskId)
										  ->fetchObject();


		if (!$feedback)
		{
			LocalRedirect("/access/denied/");
		}

		$toUserId = $feedback->getFromUserId();

		$report = new EO_Reports();
		$report->setType('feedback')
			   ->setFeedbackId($feedback->getId())
			   ->setTaskId($taskId)
			   ->setFromUserId($fromUserId)
			   ->setToUserId($toUserId);

		if ($complaintMessage)
		{
			$report->setMessage($complaintMessage);
		}
		$report->save();

		LocalRedirect("/task/$taskId/");
	}

}