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
use Up\Ukan\Service\Configuration;

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
			$projectStage->setNumber(Configuration::getOption('independent_stage_number'))
						 ->setStatus(Configuration::getOption('project_stage_status')['independent']);

			$project->setTitle($title)
					->setDescription($description)
					->setClientId($clientId)
					->addToStages($projectStage);

			$project->save();

			LocalRedirect("/project/" . $project->getId() . "/edit/");
		}
	}

	public function editInfoAction(
		int $projectId,
		string $title,
		string $description,
	)
	{
		if (check_bitrix_sessid())
		{
			global $USER;
			$userId = $USER->GetID();

			$project = \Up\Ukan\Model\ProjectTable::query()
												  ->setSelect(['ID', 'TITLE', 'DESCRIPTION'])
												  ->where('ID', $projectId)
												  ->where('CLIENT_ID', $userId)
												  ->fetchObject();

			if (!$project)
			{
				LocalRedirect("/access/denied/");
			}

			$project->setTitle($title)
					->setDescription($description);

			$project->save();

			LocalRedirect("/project/" . $projectId . "/edit/");
		}
	}
	public function editStagesAction(
		int    $projectId,
		array  $tasks = [],
	)
	{
		if (check_bitrix_sessid())
		{
			// return $tasks;
			global $USER;
			$userId = (int)$USER->GetID();

			$project = \Up\Ukan\Model\ProjectTable::query()
												  ->setSelect(['*', 'STAGES', 'STAGES.TASKS'])
												  ->where('ID', $projectId)
												  ->where('CLIENT_ID', $userId)
												  ->fetchObject();

			if (!$project)
			{
				LocalRedirect("/access/denied/");
			}

			foreach ($tasks as $taskId => $taskOptions)
			{

				$task = $project->getStages()->getTasksCollection()->getByPrimary($taskId);

				if (isset($taskOptions["taskDelete"]))
				{
					$task->fillProjectStage();
					$projectStage = $task->getProjectStage();
					$projectStage->removeFromTasks($task);

					if ($task->getStatus() !== Configuration::getOption('task_status')['queue']
						&& $task->getStatus() !== Configuration::getOption('task_status')['waiting_to_start'])
					{
						$errors[] = 'Задачу "'.$task->getTitle().'"нельзя удалить';
						\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
						LocalRedirect("/project/" . $projectId . "/edit/");
					}

					continue;
				}

				if ($taskOptions["zoneId"])
				{
					$projectStage = ProjectStageTable::getById($taskOptions["zoneId"])->fetchObject();

					if ($projectStage->getStatus()===Configuration::getOption('project_stage_status')['active']
					|| $projectStage->getStatus()===Configuration::getOption('project_stage_status')['completed'])
					{
						$errors[] = "Этап {$projectStage->getNumber()} нельзя редактировать";
						\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
						LocalRedirect("/project/" . $projectId . "/edit/");
					}

					$project->getStages()->getByPrimary($taskOptions["zoneId"])->addToTasks($task);
					if ($task->getStatus() !== Configuration::getOption('task_status')['queue']
						&& $task->getStatus() !== Configuration::getOption('task_status')['waiting_to_start'])
					{
						$errors[] = 'Задачу "'.$task->getTitle().'"нельзя переместить в другой этап';
						\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
						LocalRedirect("/project/" . $projectId . "/edit/");
					}
				}

			}

			$project->save();

			LocalRedirect("/project/" . $projectId . "/edit/");
		}
	}

	public function deleteAction(int $projectId)
	{
		if (check_bitrix_sessid())
		{
			$errors = [];

			global $USER;
			$userId=(int)$USER->GetID();

			$project = \Up\Ukan\Model\ProjectTable::query()->setSelect(['*', 'STAGES'])
														   ->where('ID', $projectId)
														   ->where('CLIENT_ID', $userId)
														   ->fetchObject();
			if (!$project)
			{
				LocalRedirect("/access/denied/");
			}

			$taskIdList = $project->getStages()->fillTasks()->getIdList();

			if ($taskIdList)
			{
				$errors[] = "Проект нельзя удалить, пока в нем содержатся задачи.";
				\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
				LocalRedirect("/project/" . $projectId . "/edit/");
			}

			$projectStages = $project->getStages();

			foreach ($projectStages as $projectStage)
			{
				$projectStage->delete();
			}
			$project->save();
			ProjectTable::delete($projectId);

			LocalRedirect("/profile/" . $userId . "/projects/");
		}
	}

	public function addTasksAction(int $projectId, array $taskIds = [])
	{
		if (check_bitrix_sessid())
		{
			global $USER;
			$userId=(int)$USER->GetID();

			$project = \Up\Ukan\Model\ProjectTable::query()->setSelect(['ID', 'CLIENT_ID'])
														   ->where('ID', $projectId)
														   ->where('CLIENT_ID', $userId)
														   ->fetchObject();
			if (!$project)
			{
				LocalRedirect("/access/denied/");
			}

			$tasks = TaskTable::query()->setSelect(['ID'])->whereIn('ID', $taskIds)
														  ->where('CLIENT_ID', $userId)
														  ->fetchCollection();
			if (!$tasks || !$taskIds)
			{
				$errors[] = "Вы не выбрали задчи";
				\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
				LocalRedirect("/project/" . $projectId . "/edit/");
			}

			$projectStage = ProjectStageTable::query()->setSelect(['ID', 'PROJECT_ID', 'NUMBER', 'TASKS'])
													  ->where('PROJECT_ID',$projectId)
													  ->where('NUMBER', Configuration::getOption('independent_stage_number'))
													  ->fetchObject();
			foreach ($tasks as $task)
			{
				$projectStage->addToTasks($task);
			}
			$projectStage->save();
			LocalRedirect("/project/" . $projectId . "/edit/");
		}
	}
	public function addStageAction(int $projectId)
	{
		if (check_bitrix_sessid())
		{
			global $USER;
			$userId=(int)$USER->GetID();

			$project = \Up\Ukan\Model\ProjectTable::query()->setSelect(['ID', 'CLIENT_ID', 'STAGES'])
														   ->where('ID',$projectId)
														   ->where('CLIENT_ID', $userId)
														   ->addOrder('STAGES.NUMBER')
														   ->fetchObject();
			if (!$project)
			{
				LocalRedirect("/access/denied/");
			}

			$projectStagesIds = $project->getStages()->getIdList();
			$lastProjectStage = $project->getStages()->getByPrimary(end($projectStagesIds));

			$newProjectStageNumber = $lastProjectStage->getNumber() + 1;
			$newProjectStage = new EO_ProjectStage();

			$projectStatuses = Configuration::getOption('project_stage_status');
			if ($lastProjectStage->getStatus()===$projectStatuses['completed'] || $lastProjectStage->getStatus()===$projectStatuses['independent'])
			{
				$newProjectStage->setNumber($newProjectStageNumber)->setStatus($projectStatuses['waiting_to_start']);
			}
			else
			{
				$newProjectStage->setNumber($newProjectStageNumber)->setStatus($projectStatuses['queue']);
			}

			$project->addToStages($newProjectStage);
			$project->save();

			LocalRedirect("/project/" . $projectId . "/edit/");
		}
	}
	public function deleteStageAction(int $projectId)
	{
		if (check_bitrix_sessid())
		{
			global $USER;
			$userId=(int)$USER->GetID();

			$project = \Up\Ukan\Model\ProjectTable::query()->setSelect(['ID', 'CLIENT_ID', 'STAGES'])
														   ->where('ID',$projectId)
														   ->where('CLIENT_ID', $userId)
														   ->addOrder('STAGES.NUMBER')
														   ->fetchObject();
			if (!$project)
			{
				LocalRedirect("/access/denied/");
			}

			$projectStagesIds = $project->getStages()->getIdList();
			$lastProjectStage = $project->getStages()->getByPrimary(end($projectStagesIds));

			if ($lastProjectStage->getStatus()===Configuration::getOption('project_stage_status')['independent'])
			{
				$errors[] = "Этапов больше не осталось";
				\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
				LocalRedirect("/project/" . $projectId . "/edit/");
			}

			if ($lastProjectStage->fillTasks()->getIdList())
			{
				$errors[] = "Этап нельзя удалить, пока в нем содержатся задачи.";
				\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
				LocalRedirect("/project/" . $projectId . "/edit/");
			}

			$lastProjectStage->delete();

			$project->save();

			LocalRedirect("/project/" . $projectId . "/edit/");
		}
	}
}