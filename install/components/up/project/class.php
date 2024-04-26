<?php

use Up\Ukan\Service\Configuration;

class UserEditProject extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchActiveStage();
		$this->fetchIndependentStage();
		$this->fetchFutureStage();
		$this->fetchCompletedStage();
		$this->fetchProject();
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
				->fetchCollection();

			$this->arResult['PROJECT'] = $project;
		}
	}

	protected function fetchActiveStage()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$projectId = $this->arParams['PROJECT_ID'];
			$stage = \Up\Ukan\Model\ProjectStageTable::query()->setSelect(['*'])
				->where('PROJECT_ID', $projectId)
				->where('STATUS', Configuration::getOption('project_stage_status')['waiting_to_start'])

				->fetchCollection();

			$this->arResult['ACTIVE_STAGE'] = $stage;
		}
	}

	protected function fetchIndependentStage()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$projectId = $this->arParams['PROJECT_ID'];
			$stage = \Up\Ukan\Model\ProjectStageTable::query()->setSelect(['*'])
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
				->where('STATUS', Configuration::getOption('project_stage_status')['queue'])
				->fetchCollection();

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
				->where('STATUS', Configuration::getOption('project_stage_status')['completed'])
				->fetchCollection();

			$this->arResult['COMPLETED_STAGE'] = $stage;
		}
	}
}