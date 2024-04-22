<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Application;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\ORM\Query\Query;
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

			LocalRedirect("/project/" . $project->getId() . "/");
		}
	}

	public function updateAction(
		int    $projectId,
		string $title,
		string $description,
		array  $withoutPriorityFlags = [],
		array  $priorityNumbers = [],
		array  $deleteTaskFlags = [],
	)
	{
		if (check_bitrix_sessid())
		{
			global $USER;
			$userId = (int)$USER->GetID();

			$project = \Up\Ukan\Model\ProjectTable::query()
												  ->setSelect(['*', 'TASKS'])
												  ->where('ID', $projectId)
												  ->fetchObject();

			if ($project->getClientId()!==$userId)
			{
				LocalRedirect("/profile/" . $userId . "/projects/");
			}

			$project->setTitle($title)->setDescription($description);

			foreach ($priorityNumbers as $taskId => $priorityNumber)
			{
				if ($priorityNumber > 0)
				{
					$project->getTasks()->getByPrimary($taskId)->setProjectPriority($priorityNumber);
				}
			}
			foreach ($withoutPriorityFlags as $taskId => $withoutPriorityFlag)
			{
				$project->getTasks()->getByPrimary($taskId)->setProjectPriority(0);
			}

			foreach ($deleteTaskFlags as $taskId => $deleteTaskFlag)
			{
				$project->removeFromTasks($project->getTasks()->getByPrimary($taskId));
			}

			$project->save();

			LocalRedirect("/project/" . $projectId . "/");
		}
	}

	public function deleteAction(int $projectId)
	{
		global $USER;
		if (check_bitrix_sessid())
		{
			$project = \Up\Ukan\Model\ProjectTable::query()->setSelect(['*', 'TASKS'])
														   ->where('ID', $projectId)
														   ->fetchObject();
			if ($project->getClientId()!==(int)$USER->GetID())
			{
				LocalRedirect("/profile/" . $USER->getId() . "/projects/");
			}
			$tasks = $project->getTasks();

			foreach ($tasks as $task)
			{
				$project->removeFromTasks($task);
			}
			$project->save();
			ProjectTable::delete($projectId);

			LocalRedirect("/profile/" . $USER->getId() . "/projects/");
		}
	}

	public function addTasksAction(int $projectId, array $taskIds)
	{
		global $USER;

		$project = \Up\Ukan\Model\ProjectTable::query()->setSelect(['ID', 'CLIENT_ID', 'TASKS.ID'])
											  ->where('ID', $projectId)
											  ->fetchObject();
		if ($project->getClientId()!==(int)$USER->GetID())
		{
			LocalRedirect("/profile/" . $USER->getId() . "/projects/");
		}
		$tasks = TaskTable::query()->setSelect(['ID'])->whereIn('ID', $taskIds)->fetchCollection();
		foreach ($tasks as $task)
		{
			$project->addToTasks($task);
		}
		$project->save();
		LocalRedirect("/project/" . $projectId . "/");
	}
}