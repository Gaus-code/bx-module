<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\Type\Date;
use Up\Ukan\Model\ProjectStageTable;
use Up\Ukan\Service\Configuration;

class ProjectStage extends Engine\Controller
{
	public function completeAction(
		int $stageId,
	)
	{
		$errors = [];

		global $USER;
		$userId=(int)$USER->GetID();

		$stage = ProjectStageTable::query()->setSelect(['ID','NUMBER', 'PROJECT_ID', 'STATUS', 'PROJECT.CLIENT_ID', 'TASKS.ID','TASKS.STATUS'])
										   ->where('ID', $stageId)
										   ->where('PROJECT.CLIENT_ID', $userId)
										   ->fetchObject();
		if (!$stage)
		{
			LocalRedirect("/access/denied/");
		}
		if ($stage->getStatus()!==Configuration::getOption('project_stage_status')['active'])
		{
			$errors[] = "Завершить можно только активный этап.";
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/project/" . $stage->getProjectId() . "/");
		}

		foreach ($stage->getTasks() as $task)
		{
			if ($task->getStatus() !== Configuration::getOption('task_status')['done'])
			{
				$errors[] = "Вы не можете завершить этап, пока все задачи не выполнены.";
				\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
				LocalRedirect("/project/" . $stage->getProjectId() . "/");
			}
		}

		$nextStage = ProjectStageTable::query()->setSelect(['ID','PROJECT_ID', 'STATUS', 'PROJECT.CLIENT_ID', 'TASKS.ID','TASKS.STATUS'])
											   ->where('PROJECT_ID', $stage->getProjectId())
											   ->where('NUMBER', $stage->getNumber()+1 )
											   ->fetchObject();
		if ($nextStage)
		{
			$nextStage->setStatus(Configuration::getOption('project_stage_status')['waiting_to_start']);
			$nextStage->save();
		}

		$stage->setStatus(Configuration::getOption('project_stage_status')['completed']);
		$stage->save();
		LocalRedirect("/project/" . $stage->getProjectId() . "/");

	}
	public function startAction(
		int $stageId,
	)
	{
		$errors = [];

		global $USER;
		$userId=(int)$USER->GetID();

		$stage = ProjectStageTable::query()->setSelect(['ID','PROJECT_ID', 'STATUS', 'PROJECT.CLIENT_ID', 'TASKS.ID','TASKS.STATUS', 'TASKS.DEADLINE'])
								  ->where('ID', $stageId)
								  ->where('PROJECT.CLIENT_ID', $userId)
								  ->fetchObject();
		if (!$stage)
		{
			LocalRedirect("/access/denied/");
		}
		if ($stage->getStatus()!==Configuration::getOption('project_stage_status')['waiting_to_start'])
		{
			$errors[] = "Данный этап нельзя начать.";
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/project/" . $stage->getProjectId() . "/");
		}

		$now = new Date();
		if (count($stage->getTasks())===0)
		{
			$errors[] = "Вы не можете начать этап тк в нем нет задач.";
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect("/project/" . $stage->getProjectId() . "/");
		}

		foreach ($stage->getTasks() as $task)
		{
			if ($task->getDeadline() < $now)
			{
				$errors[] = "Вы не можете начать этап тк в нем имеются задачи с просроченным дедлайном.";
				\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
				LocalRedirect("/project/" . $stage->getProjectId() . "/");
			}
			$task->setStatus(Configuration::getOption('task_status')['search_contractor']);
		}

		$stage->setStatus(Configuration::getOption('project_stage_status')['active']);
		$stage->save();
		LocalRedirect("/project/" . $stage->getProjectId() . "/");
	}
}