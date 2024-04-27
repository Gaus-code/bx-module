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
			$project = \Up\Ukan\Model\ProjectTable::query();

			$project->setSelect(['*'])
					->where('ID', $projectId);

			$this->arResult['PROJECT'] = $project->fetchCollection();
		}
	}

	protected function fetchActiveStage()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$projectId = $this->arParams['PROJECT_ID'];
			$stage = \Up\Ukan\Model\ProjectStageTable::query();
			$stage->setSelect(['*'])
				  ->where('PROJECT_ID', $projectId)
				  ->where('STATUS', Configuration::getOption('project_stage_status')['active']);

			$this->arResult['ACTIVE_STAGE'] = $stage->fetchCollection();
		}
	}

	protected function fetchIndependentStage()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$projectId = $this->arParams['PROJECT_ID'];
			$stage = \Up\Ukan\Model\ProjectStageTable::query();
			$stage->setSelect(['*'])
				  ->where('PROJECT_ID', $projectId)
				  ->where('STATUS', Configuration::getOption('project_stage_status')['independent']);

			$this->arResult['INDEPENDENT_STAGE'] = $stage->fetchCollection();
		}
	}

	protected function fetchFutureStage()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$projectId = $this->arParams['PROJECT_ID'];
			$stage = \Up\Ukan\Model\ProjectStageTable::query();
			$stage->setSelect(['*'])
				  ->where('PROJECT_ID', $projectId)
				  ->where('STATUS', Configuration::getOption('project_stage_status')['queue']);

			$this->arResult['FUTURE_STAGE'] = $stage->fetchCollection();
		}
	}

	protected function fetchCompletedStage()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$projectId = $this->arParams['PROJECT_ID'];
			$stage = \Up\Ukan\Model\ProjectStageTable::query();
			$stage->setSelect(['*'])
				  ->where('PROJECT_ID', $projectId)
				  ->where('STATUS', Configuration::getOption('project_stage_status')['completed']);

			$this->arResult['COMPLETED_STAGE'] = $stage->fetchCollection();
		}
	}
}