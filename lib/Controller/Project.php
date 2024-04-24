<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Application;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\ORM\Query\Query;
use Bitrix\Main\Type\Date;
use Bitrix\Main\UserTable;
use Up\Ukan\Model\EO_Project;
use Up\Ukan\Model\EO_ProjectStage;
use Up\Ukan\Model\EO_Task;
use Up\Ukan\Model\ProjectStageTable;
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
			$projectStage = new EO_ProjectStage();
			$projectStage->setNumber(0)->setStatus(1);

			$project->setTitle($title)->setDescription($description)->setClientId($clientId)->addToStages($projectStage);


			$project->save();

			LocalRedirect("/project/" . $project->getId() . "/");
		}
	}

	public function updateAction(
		int    $projectId,
		// string $title,
		// string $description,
		// array $stages =[],
		array  $tasks = [],
	)
	{
		if (check_bitrix_sessid())
		{
			global $USER;
			$userId = (int)$USER->GetID();

			$project = \Up\Ukan\Model\ProjectTable::query()
												  ->setSelect(['*', 'STAGES', 'STAGES.TASKS'])
												  ->where('ID', $projectId)
												  ->fetchObject();

			if ($project->getClientId()!==$userId)
			{
				LocalRedirect("/profile/" . $userId . "/projects/");
			}
			// return $tasks;

			$arrayStages=[];
			foreach ($tasks as $taskId => $taskOptions)
			{
				$task = $project->getStages()->getTasksCollection()->getByPrimary($taskId);

				if (!isset($taskOptions["taskDelete"]))
				{
					$arrayStages[$taskOptions["zoneId"]][]=$taskId;
					$project->getStages()->getByPrimary($taskOptions["zoneId"])->addToTasks($task);
				}
				else
				{
					$task->fillProjectStage();
					$projectStage = $task->getProjectStage();
					$projectStage->removeFromTasks($task);
				}

			}

			foreach ($project->getStages() as $stage)
			{
				if (!isset($arrayStages[$stage->getId()]))
				{
					$stage->setExpectedCompletionDate(null);
					continue;
				}

				$taskList = TaskTable::query()->setSelect(['ID', 'DEADLINE'])
											  ->whereIn('ID', $arrayStages[$stage->getId()])
											  ->fetchCollection();
				$deadlineList = $taskList->getDeadlineList();

				$expectedCompletionDate= max($deadlineList);
				$stage->setExpectedCompletionDate($expectedCompletionDate);
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
			$projectStage = $project->getStages();
			foreach ($projectStage as $projectStage)
			{
				$projectStage->delete();
			}
			$project->save();
			ProjectTable::delete($projectId);

			LocalRedirect("/profile/" . $USER->getId() . "/projects/");
		}
	}

	public function addTasksAction(int $projectId, array $taskIds)
	{
		global $USER;

		$project = \Up\Ukan\Model\ProjectTable::query()->setSelect(['ID', 'CLIENT_ID'])
											  ->where('ID', $projectId)
											  ->fetchObject();
		if ($project->getClientId()!==(int)$USER->GetID())
		{
			LocalRedirect("/profile/" . $USER->getId() . "/projects/");
		}
		$tasks = TaskTable::query()->setSelect(['ID'])
								   ->whereIn('ID', $taskIds)
								   ->fetchCollection();

		$projectStage = ProjectStageTable::query()->setSelect(['ID', 'PROJECT_ID', 'NUMBER', 'TASKS'])
												  ->where('PROJECT_ID', $projectId)
												  ->where('NUMBER', 0)
												  ->fetchObject();
		foreach ($tasks as $task)
		{
			$projectStage->addToTasks($task);
		}
		$projectStage->save();
		LocalRedirect("/project/" . $projectId . "/");
	}
	public function addStageAction(int $projectId)
	{
		global $USER;

		$project = \Up\Ukan\Model\ProjectTable::query()->setSelect(['ID', 'CLIENT_ID', 'STAGES'])
											  ->where('ID', $projectId)
											  ->addOrder('STAGES.NUMBER')
											  ->fetchObject();
		if ($project->getClientId()!==(int)$USER->GetID())
		{
			LocalRedirect("/profile/" . $USER->getId() . "/projects/");
		}

		$projectStagesIds = $project->getStages()->getIdList();
		$lastProjectStage=$project->getStages()->getByPrimary(end($projectStagesIds));

		$newProjectStageNumber = $lastProjectStage->getNumber() + 1;
		$newProjectStage = new EO_ProjectStage();
		$newProjectStage->setNumber($newProjectStageNumber)->setStatus(1);

		$project->addToStages($newProjectStage);
		$project->save();

		LocalRedirect("/project/" . $projectId . "/");
	}
	public function deleteStageAction(int $projectId)
	{
		global $USER;

		$project = \Up\Ukan\Model\ProjectTable::query()->setSelect(['ID', 'CLIENT_ID', 'STAGES'])
											  ->where('ID', $projectId)
											  ->addOrder('STAGES.NUMBER')
											  ->fetchObject();
		if ($project->getClientId()!==(int)$USER->GetID())
		{
			LocalRedirect("/profile/" . $USER->getId() . "/projects/");
		}

		$projectStagesIds = $project->getStages()->getIdList();
		$lastProjectStage=$project->getStages()->getByPrimary(end($projectStagesIds));

		$lastProjectStage->delete();

		$project->save();

		LocalRedirect("/project/" . $projectId . "/");
	}
}