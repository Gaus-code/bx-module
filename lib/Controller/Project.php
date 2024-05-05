<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Application;
use Bitrix\Main\Engine\Controller;
use Bitrix\Main\ORM\Query\Query;
use Bitrix\Main\Type\Date;
use Bitrix\Main\Type\DateTime;
use Bitrix\Main\UserTable;
use Up\Ukan\Model\EO_Notification;
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

			if (!$title || !$description)
			{
				$errors[] = 'Заполните все поля.';
				\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
				LocalRedirect("/project/" . $clientId . "/create/");
			}

			$user = \Up\Ukan\Model\UserTable::query()
											->setSelect(['ID', 'PROJECTS.STATUS', 'PROJECTS_COUNT', 'SUBSCRIPTION_STATUS'])
											->where('ID', $clientId)
											->where('PROJECTS.STATUS', Configuration::getOption('project_status')['active'])
											->fetch();

			if ($user['SUBSCRIPTION_STATUS']!=="Active" &&
				(int)$user['PROJECTS_COUNT']>=Configuration::getOption('maximum_number_of_projects_for_users_without_subscription'))
			{
				$errors[] = 'Превышено ограничение по количеству проектов. Чтобы увеличить количество проектов приобретите нашу подписку.';
				\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
				LocalRedirect("/project/" . $clientId . "/create/");
			}

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

					if ($task->getStatus() === Configuration::getOption('task_status')['done']
						|| $task->getStatus() === Configuration::getOption('task_status')['at_work'])
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
					if ($task->getStatus() !== Configuration::getOption('task_status')['queue']
						&& $task->getStatus() !== Configuration::getOption('task_status')['waiting_to_start'])
					{
						$errors[] = 'Задачу "'.$task->getTitle().'"нельзя переместить в другой этап';
						\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
						LocalRedirect("/project/" . $projectId . "/edit/");
					}

					$project->getStages()->getByPrimary($taskOptions["zoneId"])->addToTasks($task);

					$projectStageStatuses = Configuration::getOption('project_stage_status');
					$taskStatuses = Configuration::getOption('task_status');
					if ($projectStage->getStatus() === $projectStageStatuses['queue'] || $projectStage->getStatus() === $projectStageStatuses['waiting_to_start'])
					{
						$task->setStatus($taskStatuses['queue']);
					}
					elseif ($projectStage->getStatus() === $projectStageStatuses['independent'])
					{
						$task->setStatus($taskStatuses['waiting_to_start']);
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
				$task->setStatus(Configuration::getOption('task_status')['waiting_to_start']);
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

	public function completeAction(
		int $projectId,
	)
	{
		$errors = [];

		global $USER;
		$userId=(int)$USER->GetID();

		$project = ProjectTable::query()->setSelect(['ID', 'STATUS', 'CLIENT_ID', 'STAGES.TASKS.ID','STAGES.TASKS.STATUS'])
								  ->where('ID', $projectId)
								  ->where('CLIENT_ID', $userId)
								  ->fetchObject();
		if (!$project)
		{
			LocalRedirect("/access/denied/");
		}
		if ($project->getStatus()===Configuration::getOption('project_stage_status')['completed'])
		{
			$errors[] = "Этот проект уже завершен.";
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/project/" . $project->getId() . "/");
		}

		foreach ($project->getStages()->getTasksCollection() as $task)
		{
			if ($task->getStatus() !== Configuration::getOption('task_status')['done'])
			{
				$errors[] = "Вы не можете завершить проект, пока все задачи не выполнены.";
				\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
				LocalRedirect("/project/" . $project->getId() . "/");
			}
		}

		$project->setStatus(Configuration::getOption('project_stage_status')['completed']);
		$project->save();
		LocalRedirect("/project/" . $project->getId() . "/");

	}

	public function stopSearchContractorAction(int $taskId)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}
		global $USER;
		$userId = (int)$USER->GetID();

		$task = TaskTable::query()
						 ->setSelect(['*', 'PROJECT.ID', 'RESPONSES', 'TAGS'])
						 ->where('ID', $taskId)
						 ->where('CLIENT_ID', $userId)
						 ->fetchObject();

		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}
		if ($task->getStatus()!==Configuration::getOption('task_status')['search_contractor'])
		{
			$errors = ['По заявке "'.$task->getTitle().'" нельзя прекратить поиск исполнителя'];
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/project/".$task->getProject()->getId()."/");
		}

		$task->setStatus(Configuration::getOption('task_status')['waiting_to_start']);
		$task->save();
		LocalRedirect("/project/".$task->getProject()->getId()."/");

	}
	public function startSearchContractorAction(int $taskId)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}
		global $USER;
		$userId = (int)$USER->GetID();

		$task = TaskTable::query()
						 ->setSelect(['*', 'PROJECT.ID','RESPONSES', 'TAGS'])
						 ->where('ID', $taskId)
						 ->where('CLIENT_ID', $userId)
						 ->fetchObject();

		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}
		if ($task->getStatus()!==Configuration::getOption('task_status')['waiting_to_start'])
		{
			$errors = ['По заявке "'.$task->getTitle().'" нельзя начать поиск исполнителя'];
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/project/".$task->getProject()->getId()."/");
		}

		$task->setStatus(Configuration::getOption('task_status')['search_contractor']);
		$task->save();

		LocalRedirect("/project/".$task->getProject()->getId()."/");

	}
	public function finishTaskAction(int $taskId)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		$clientId = (int)$USER->getId();

		$task = TaskTable::query()
						 ->setSelect(['*', 'PROJECT.ID'])
						 ->where('ID', $taskId)
						 ->where('CLIENT_ID', $clientId)
						 ->fetchObject();

		if (!$task)
		{
			LocalRedirect("/access/denied/");
		}

		if ($task->getStatus()!==Configuration::getOption('task_status')['at_work'])
		{
			$errors = ['Заявку "'.$task->getTitle().'" нельзя завершить'];
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/project/".$task->getProject()->getId()."/");
		}

		$task->setStatus(Configuration::getOption('task_status')['done']);
		$task->save();

		$notification = new EO_Notification();
		$notification->setMessage(Configuration::getOption('notification_message')['task_finished'])
					 ->setFromUserId($clientId)
					 ->setToUserId($task->getContractorId())
					 ->setTaskId($taskId)
					 ->setCreatedAt(new DateTime());
		$notification->save();

		LocalRedirect("/project/".$task->getProject()->getId()."/");

	}
}