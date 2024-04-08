<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Application;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\UserTable;
use Up\Ukan\Model\EO_Project;
use Up\Ukan\Model\EO_Task;
use Up\Ukan\Model\ProjectTable;
use Up\Ukan\Model\TagTable;
use Up\Ukan\Model\TaskTable;

class Project extends Controller
{
	public function createAction(
		string $title,
		string $description,
	)
	{
		if (check_bitrix_sessid())
		{
			global $USER;

			$clientId = $USER->GetID();

			$project = new EO_Project();
			$project->setTitle($title)->setDescription($description)->setClientId($clientId);

			$project->save();

			LocalRedirect("/project/".$project->getId()."/");
		}
	}

	public function updateAction(
		int $projectId,
		string $title,
		string $description,
		array  $taskIds = [],

	)
	{
		if (check_bitrix_sessid())
		{
			$project = ProjectTable::getById($projectId)->fetchObject();

			$project->setTitle($title)->setDescription($description);

			foreach ($taskIds as $taskId)
			{
				$task = TaskTable::getById($taskId)->fetchObject();
				$project->addToTasks($task);
			}

			$project->save();

			LocalRedirect("/project/".$project->getId()."/");
		}
	}

	public function deleteAction(int $projectId)
	{
		if (check_bitrix_sessid())
		{
			ProjectTable::delete($projectId);

			LocalRedirect("/client/");
		}
	}
}