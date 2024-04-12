<?php

class TaskListComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchTasks();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['CLIENT_ID']) || $arParams['CLIENT_ID'] <= 0)
		{
			$arParams['CLIENT_ID'] = null;
		}

		if (!isset($arParams['TAG_ID']) || $arParams['TAG_ID'] === [] )
		{
			$arParams['TAG_ID'] = null;
		}

		if (!request()->get('PAGEN_1') || !is_numeric(request()->get('PAGEN_1')) || (int)request()->get('PAGEN_1') < 1)
		{
			$arParams['CURRENT_PAGE'] = 1;
		}
		else
		{
			$arParams['CURRENT_PAGE'] = (int)request()->get('PAGEN_1');
		}

		if (!isset($arParams['IS_PERSONAL_ACCOUNT_PAGE']))
		{
			$arParams['IS_PERSONAL_ACCOUNT_PAGE'] = false;
		}

		$arParams['EXIST_NEXT_PAGE'] = false;

		return $arParams;

	}

	protected function fetchTasks()
	{
		//TODO fetchTasks from db using filters TAG_ID

		$pageSize = 9; //TODO remove hardcode
		$currentPage = $this->arParams['CURRENT_PAGE'];
		$offset = ($currentPage - 1) * $pageSize;

		$query = \Up\Ukan\Model\TaskTable::query();

		$query->setSelect(['*']);

		if (!is_null($this->arParams['CLIENT_ID']))
		{
			$query->where('CLIENT_ID', $this->arParams['CLIENT_ID']);
		}

		if (!$this->arParams['IS_PERSONAL_ACCOUNT_PAGE'])
		{
			$query->addSelect('CLIENT');
			$query->addOrder('SEARCH_PRIORITY', 'DESC');
		}

		$query->addOrder('CREATED_AT', 'DESC');
		$query->setLimit($pageSize + 1);
		$query->setOffset($offset);

		$result = $query->fetchCollection();

		$arrayOfTask = $result->getAll();
		if (count($result) === $pageSize + 1)
		{
			$this->arParams['EXIST_NEXT_PAGE'] = true;
			array_pop($arrayOfTask);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE'] = false;
		}

		$result->fillTags();

		$this->arResult['TASKS'] = $arrayOfTask;

	}

}