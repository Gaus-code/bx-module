<?php

class TaskListComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchUserActivity();
		$this->fetchTasks();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{

		if (!request()->get('PAGEN_1') || !is_numeric(request()->get('PAGEN_1')) || (int)request()->get('PAGEN_1') < 1)
		{
			$arParams['CURRENT_PAGE'] = 1;
		}
		else
		{
			$arParams['CURRENT_PAGE'] = (int)request()->get('PAGEN_1');
		}
		if (!isset($arParams['USER_ID']) || $arParams['USER_ID'] <= 0)
		{
			$arParams['USER_ID'] = null;
		}

		if (!isset($arParams['IS_PERSONAL_ACCOUNT_PAGE']))
		{
			$arParams['IS_PERSONAL_ACCOUNT_PAGE'] = false;
		}


		$arParams['TAGS_ID'] = request()->get('tags');
		$arParams['SEARCH'] = request()->get('q');
		$arParams['EXIST_NEXT_PAGE'] = false;

		return $arParams;

	}

	protected function fetchTasks()
	{
		if (!$this->arParams['IS_PERSONAL_ACCOUNT_PAGE'])
		{
			$this->fetchTasksForCatalog();
		}
		else
		{
			$this->fetchOpenTasksForPersonalPage();
			$this->fetchAtWorkTasksForPersonalPage();
			$this->fetchDoneTasksForPersonalPage();
		}

	}

	private function fetchTasksForCatalog()
	{
		//настройка пагинации
		$nav = new \Bitrix\Main\UI\PageNavigation("task.list");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['task_list_catalog']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);

		//настройка выборки и добавление условий (со статусом 'new'  и при необходимости фильтры по тэгам + поиск по нахванию/описанию)
		$query = \Up\Ukan\Model\TaskTable::query();
		$query->setSelect(['ID'])
			  ->where('STATUS', \Up\Ukan\Service\Configuration::getOption('task_status')['new']);

		if (!is_null($this->arParams['TAGS_ID']))
		{
			$query->whereIn('TAGS.ID', $this->arParams['TAGS_ID']);
		}

		if (!is_null($this->arParams['SEARCH']))
		{
			$query->where(\Bitrix\Main\ORM\Query\Query::filter()
				->logic('or')
				->whereLike('TITLE', '%' . $this->arParams['SEARCH'] . '%')
				->whereLike('DESCRIPTION', '%' . $this->arParams['SEARCH'] . '%')
			);
		}

		$query->addGroup('ID') //группировка по айди (необходима при фильтрах по тэгам, без нее некорректно работает пагинация)
			  ->setLimit($nav->getLimit() + 1) //пагинация
			  ->setOffset($nav->getOffset()) //пагинация
			  ->addOrder('SEARCH_PRIORITY', 'DESC') //сортировка по подписке
			  ->addOrder('CREATED_AT', 'DESC'); //сортировка по дате

		$idList = [];
		$result = $query->exec(); //при фильтрах нам сначала надо достать айдишники (далле весь блок - пагинация)
		while ($row = $result->fetch())
		{
			$idList[] = $row['ID'];
		}
		$nav->setRecordCount($nav->getOffset() + count($idList));

		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE'])
		{
			$this->arParams['EXIST_NEXT_PAGE'] = true;
			array_pop($idList);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE'] = false;
		}

		if ($idList === [])
		{
			$this->arResult['TASKS'] = [];
			return;
		}

		//делаем второй запрос
		$query = \Up\Ukan\Model\TaskTable::query();
		$query->setSelect(['*', 'TAGS', 'CLIENT', 'CLIENT.B_USER.NAME', 'CLIENT.B_USER.LAST_NAME'])
			  ->whereIn('ID', $idList)
			  ->addOrder('SEARCH_PRIORITY', 'DESC');

		$this->arResult['TASKS'] = $query->fetchCollection();

	}

	private function fetchOpenTasksForPersonalPage()
	{
		$nav = new \Bitrix\Main\UI\PageNavigation("task.list");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['task_list_personal']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);

		$query = \Up\Ukan\Model\TaskTable::query();
		$query->setSelect(['*', 'CONTRACTOR.B_USER.NAME', 'CONTRACTOR.B_USER.LAST_NAME'])
			  ->where('CLIENT_ID', $this->arParams['USER_ID'])
			  ->addOrder('SEARCH_PRIORITY', 'DESC')
			  ->addOrder('CREATED_AT', 'DESC')
			  ->setLimit($nav->getLimit() + 1)
			  ->setOffset($nav->getOffset())
			  ->where('STATUS', \Up\Ukan\Service\Configuration::getOption('task_status')['new']);

		$openTasks = $query->fetchCollection()->getAll();

		$nav->setRecordCount($nav->getOffset() + count($openTasks));
		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE'])
		{
			$this->arParams['EXIST_NEXT_PAGE'] = true;
			array_pop($openTasks);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE'] = false;
		}

		$this->arResult['OPEN_TASKS'] = $openTasks;

	}

	private function fetchAtWorkTasksForPersonalPage()
	{
		$nav = new \Bitrix\Main\UI\PageNavigation("task.list");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['task_list_personal']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);

		$query = \Up\Ukan\Model\TaskTable::query();
		$query->setSelect(['*', 'CONTRACTOR.B_USER.NAME', 'CONTRACTOR.B_USER.LAST_NAME'])
			  ->where('CLIENT_ID', $this->arParams['USER_ID'])
			  ->addOrder('SEARCH_PRIORITY', 'DESC')
			  ->addOrder('CREATED_AT', 'DESC')
			  ->setLimit($nav->getLimit() + 1)
			  ->setOffset($nav->getOffset())
			  ->where('STATUS', \Up\Ukan\Service\Configuration::getOption('task_status')['at_work']);

		$atWorkTasks = $query->fetchCollection()->getAll();

		$nav->setRecordCount($nav->getOffset() + count($atWorkTasks));
		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE'])
		{
			$this->arParams['EXIST_NEXT_PAGE'] = true;
			array_pop($atWorkTasks);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE'] = false;
		}

		$this->arResult['AT_WORK_TASKS'] = $atWorkTasks;

	}

	private function fetchDoneTasksForPersonalPage()
	{
		$nav = new \Bitrix\Main\UI\PageNavigation("task.list");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['task_list_personal']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);

		$query = \Up\Ukan\Model\TaskTable::query();
		$query->setSelect(['*', 'CONTRACTOR.B_USER.NAME', 'CONTRACTOR.B_USER.LAST_NAME'])
			  ->where('CLIENT_ID', $this->arParams['USER_ID'])
			  ->addOrder('SEARCH_PRIORITY', 'DESC')
			  ->addOrder('CREATED_AT', 'DESC')
			  ->setLimit($nav->getLimit() + 1)
			  ->setOffset($nav->getOffset())
			  ->where('STATUS', \Up\Ukan\Service\Configuration::getOption('task_status')['done']);

		$doneTasks = $query->fetchCollection()->getAll();

		$nav->setRecordCount($nav->getOffset() + count($doneTasks));
		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE'])
		{
			$this->arParams['EXIST_NEXT_PAGE'] = true;
			array_pop($doneTasks);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE'] = false;
		}

		$this->arResult['DONE_TASKS'] = $doneTasks;
	}

	protected function fetchUserActivity()
	{
		global $USER;
		$userId = (int)$USER->getId();


		if ($this->arParams['USER_ID'] === $userId)
		{
			$this->arResult['USER_ACTIVITY'] = 'owner';
		}
		else
		{
			$this->arResult['USER_ACTIVITY'] = 'other_user';
		}
	}

}