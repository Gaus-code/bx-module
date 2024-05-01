<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\ORM\Query\Query;
use Up\Ukan\Model\EO_Reports;
use Up\Ukan\Model\FeedbackTable;
use Up\Ukan\Model\TaskTable;
use Up\Ukan\Model\UserTable;

class Block extends Engine\Controller
{

	public function blockTaskAction(
		int    $taskId = null,
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

		$task = TaskTable::getById($taskId)->fetchObject();

		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}

		$task->setIsBanned('Y');
		$task->save();

		//TODO sent notification user about block task
		//TODO delete report if exist

		LocalRedirect("/task/$taskId/");

	}



}