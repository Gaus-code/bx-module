<?php

class UserEditTask extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchTask();
		$this->fetchTags();
		$this->fetchProjects();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['TASK_ID']) || $arParams['TASK_ID'] <= 0)
		{
			$arParams['TASK_ID'] = null;
		}
		if (!isset($arParams['USER_ID']) || $arParams['USER_ID'] <= 0)
		{
			$arParams['USER_ID'] = null;
		}

		return $arParams;

	}

	protected function fetchProjects()
	{

		if ($this->arParams['USER_ID'])
		{
			$this->arResult['PROJECTS'] = \Up\Ukan\Model\ProjectTable::query()->setSelect(['*'])->where('CLIENT_ID', $this->arParams['USER_ID'])->fetchCollection();
		}
		else
		{
			die('incorrect user id');
		}



	}
	protected function fetchTags()
	{

		$this->arResult['TAGS'] = \Up\Ukan\Model\TagTable::query()->setSelect(['*'])->fetchCollection();

	}

	protected function fetchTask()
	{

		if ($this->arParams['TASK_ID'])
		{
			$this->arResult['TASK'] =  \Up\Ukan\Model\TaskTable::query()->setSelect(['*', 'TAGS', 'CONTRACTOR', 'CONTRACTOR.B_USER'])
																		->where('ID', $this->arParams['TASK_ID'])
																		->fetchObject();
		}

	}
}