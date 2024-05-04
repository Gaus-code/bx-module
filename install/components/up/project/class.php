<?php

use Up\Ukan\Service\Configuration;

class UserEditProject extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchProject();
		$this->fetchUserActivity();
		$this->fetchActiveStage();
		$this->fetchIndependentStage();
		$this->fetchFutureStage();
		$this->fetchCompletedStage();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['USER_ID']) || $arParams['USER_ID'] <= 0)
		{
			$arParams['USER_ID'] = null;
		}

		if (!isset($arParams['PROJECT_ID']) || $arParams['PROJECT_ID'] <= 0)
		{
			$arParams['PROJECT_ID'] = null;
		}
		return $arParams;
	}

	protected function fetchProject()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$projectId = $this->arParams['PROJECT_ID'];
			$project = \Up\Ukan\Model\ProjectTable::query()->setSelect(['*'])
												  ->where('ID', $projectId)
												  ->fetchObject();;

			$this->arResult['PROJECT'] = $project;
		}
	}

	protected function fetchActiveStage()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$projectId = $this->arParams['PROJECT_ID'];
			$stageStatuses = [
				Configuration::getOption('project_stage_status')['waiting_to_start'],
				Configuration::getOption('project_stage_status')['active']
			];

			$stage = \Up\Ukan\Model\ProjectStageTable::query()->setSelect(['*', 'TASKS', 'TASKS.CONTRACTOR', 'TASKS.CONTRACTOR.B_USER'])
													 ->where('PROJECT_ID', $projectId)
													 ->whereIn('STATUS', $stageStatuses)
													 ->fetchCollection();

			$this->arResult['ACTIVE_STAGE'] = $stage;
		}
	}

	protected function fetchIndependentStage()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$projectId = $this->arParams['PROJECT_ID'];
			$stage = \Up\Ukan\Model\ProjectStageTable::query()
													 ->setSelect(['*', 'TASKS', 'TASKS.CONTRACTOR', 'TASKS.CONTRACTOR.B_USER'])
													 ->where('PROJECT_ID', $projectId)
													 ->where('STATUS', Configuration::getOption('project_stage_status')['independent'])
													 ->fetchCollection();

			$this->arResult['INDEPENDENT_STAGE'] = $stage;
		}
	}

	protected function fetchFutureStage()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$projectId = $this->arParams['PROJECT_ID'];
			$stage = \Up\Ukan\Model\ProjectStageTable::query()->setSelect(['*'])
				  ->where('PROJECT_ID', $projectId)
				  ->where('STATUS', Configuration::getOption('project_stage_status')['queue'])->fetchCollection();

			$this->arResult['FUTURE_STAGE'] = $stage;
		}
	}

	protected function fetchCompletedStage()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$projectId = $this->arParams['PROJECT_ID'];
			$stage = \Up\Ukan\Model\ProjectStageTable::query()->setSelect(['*'])
				  ->where('PROJECT_ID', $projectId)
				  ->where('STATUS', Configuration::getOption('project_stage_status')['completed'])->fetchCollection();

			$this->arResult['COMPLETED_STAGE'] = $stage;
		}
	}

	protected function fetchUserActivity()
	{
		global $USER;
		$userID = (int)$USER->GetID();

		if ($this->arResult['PROJECT']->getClientId()===$userID)
		{
			$this->arResult['USER_ACTIVITY'] = 'owner';
		}
		else
		{
			$this->arResult['USER_ACTIVITY'] = 'other_user';
		}
	}
}