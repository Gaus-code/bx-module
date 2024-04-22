<?php

class UserProjectComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchTags();
		$this->fetchAddTaskList();
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
			$project =  \Up\Ukan\Model\ProjectTable::query()->setSelect(['*', 'TASKS', 'TASKS.CONTRACTOR', 'TASKS.CONTRACTOR.B_USER'])
															->where('ID', $this->arParams['PROJECT_ID'])
															->addOrder('TASKS.PROJECT_PRIORITY')
															->fetchObject();

			if ($project->getClientId()===$this->arParams['USER_ID'])
			{
				$this->arParams['PROJECT']=$project;
			}
			else
			{
				LocalRedirect("/profile/".$this->arParams['USER_ID']."/projects/");
			}
		}
	}
	protected function fetchAddTaskList()
	{
		if ($this->arParams['PROJECT_ID'])
		{
			$this->arResult['ADD_TASK_LIST'] =  \Up\Ukan\Model\TaskTable::query()
																		->setSelect(['ID', 'TITLE', 'PROJECT_ID', 'STATUS'])
																		->whereNull('PROJECT_ID')
																		->where('STATUS', 'Новая')
																		->fetchCollection();
		}
	}
	protected function fetchTags()
	{

		$this->arResult['TAGS'] = \Up\Ukan\Model\TagTable::query()->setSelect(['*'])->fetchCollection();

	}
}