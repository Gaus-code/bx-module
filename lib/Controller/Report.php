<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;
use Up\Ukan\Model\EO_Reports;
use Up\Ukan\Model\TaskTable;
use Up\Ukan\Model\UserTable;

class Report extends Engine\Controller
{

	public function createAction(
		string $complaintType = null,
		string $complaintMessage = null,
		int    $toUserId = null,
		int    $toTaskId = null,
	)
	{
		if (check_bitrix_sessid())
		{
			switch ($complaintType)
			{
				case 'task':
					$this->createReportOnTask($complaintMessage, $toTaskId);
					break;
				case 'user':
					// $toUser = UserTable::getById($toUserId)->fetchObject();
					// if (!$toUser)
					// {
					// 	LocalRedirect("/access/denied/");
					// }
					// break;
				default:
					LocalRedirect("/access/denied/");
			}

		}
	}

	private function createReportOnTask(string $complaintMessage, int $toTaskId)
	{
		$task = TaskTable::getById($toTaskId)->fetchObject();
		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}
		global $USER;
		$fromUserId = (int)$USER->getId();
		$toUserId = $task->getClientId();

		$report = new EO_Reports();
		$report->setType('task')->setToTaskId($toTaskId)->setFromUserId($fromUserId)->setToUserId($toUserId);

		if ($complaintMessage)
		{
			$report->setMessage($complaintMessage);
		}
		$report->save();

		LocalRedirect("/catalog/");
	}

}