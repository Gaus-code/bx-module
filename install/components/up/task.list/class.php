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

		$arParams['TAGS_ID'] = request()->get('tags');
		$arParams['EXIST_NEXT_PAGE'] = false;

		return $arParams;

	}

	protected function fetchTasks()
	{
		$nav = new \Bitrix\Main\UI\PageNavigation("task.list");
		$nav->allowAllRecords(true)
			->setPageSize(9); //TODO remove hardcode
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);

		$query = \Up\Ukan\Model\TaskTable::query();
		$query->setSelect(['ID']);

		if (!is_null($this->arParams['CLIENT_ID']))
		{
			$query->where('CLIENT_ID', $this->arParams['CLIENT_ID']);
		}
		if (!is_null($this->arParams['TAGS_ID']))
		{
			$query->whereIn('TAGS.ID', $this->arParams['TAGS_ID']);
		}

		$query->setLimit($nav->getLimit() + 1);
		$query->setOffset($nav->getOffset());

		$result = $query->fetchCollection();
		$nav->setRecordCount($nav->getOffset() + count($result));
		$idList = $result->getIdList();

		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE'])
		{
			$this->arParams['EXIST_NEXT_PAGE'] = true;
			array_pop($idList);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE'] = false;
		}

		$query = \Up\Ukan\Model\TaskTable::query();
		$query->setSelect(['*', 'TAGS']);

		if (!$this->arParams['IS_PERSONAL_ACCOUNT_PAGE'])
		{
			$query->addSelect('CLIENT');
			$query->addOrder('SEARCH_PRIORITY', 'DESC');
		}

		$query->addOrder('CREATED_AT', 'DESC');
		$query->whereIn('ID', $idList);

		$result = $query->fetchCollection();

		$this->arResult['TASKS'] = $result;

	}

}