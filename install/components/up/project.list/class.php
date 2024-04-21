<?php

class UserProjectsComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchAtWorkProjects();
		$this->fetchDoneProjects();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['USER_ID']) || $arParams['USER_ID'] <= 0)
		{
			$arParams['USER_ID'] = null;
		}

		if (!request()->get('PAGEN_1') || !is_numeric(request()->get('PAGEN_1')) || (int)request()->get('PAGEN_1') < 1)
		{
			$arParams['CURRENT_PAGE'] = 1;
		}
		else
		{
			$arParams['CURRENT_PAGE'] = (int)request()->get('PAGEN_1');
		}

		$arParams['EXIST_NEXT_PAGE'] = false;

		return $arParams;
	}

	private function fetchAtWorkProjects()
	{
		$nav = new \Bitrix\Main\UI\PageNavigation("project.list");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['projects_list']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);


		$query = \Up\Ukan\Model\ProjectTable::query();

		$query->setSelect(['*'])
			  ->where('CLIENT_ID', $this->arParams['USER_ID'])
			  ->where('STATUS', \Up\Ukan\Service\Configuration::getOption('project_status')['at_work'])
			  ->addOrder('CREATED_AT', 'DESC')
			  ->setLimit($nav->getLimit() + 1)
			  ->setOffset($nav->getOffset());

		$result = $query->fetchCollection();
		$nav->setRecordCount($nav->getOffset() + count($result));

		$arrayOfProjects = $result->getAll();
		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE'])
		{
			$this->arParams['EXIST_NEXT_PAGE'] = true;
			array_pop($arrayOfProjects);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE'] = false;
		}

		$this->arResult['AT_WORK_PROJECTS'] = $arrayOfProjects;
	}

	private function fetchDoneProjects()
	{
		$nav = new \Bitrix\Main\UI\PageNavigation("project.list");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['projects_list']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);


		$query = \Up\Ukan\Model\ProjectTable::query();

		$query->setSelect(['*'])
			  ->where('CLIENT_ID', $this->arParams['USER_ID'])
			  ->where('STATUS', \Up\Ukan\Service\Configuration::getOption('project_status')['done'])
			  ->addOrder('CREATED_AT', 'DESC')
			  ->setLimit($nav->getLimit() + 1)
			  ->setOffset($nav->getOffset());

		$result = $query->fetchCollection();
		$nav->setRecordCount($nav->getOffset() + count($result));

		$arrayOfProjects = $result->getAll();
		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE'])
		{
			$this->arParams['EXIST_NEXT_PAGE'] = true;
			array_pop($arrayOfProjects);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE'] = false;
		}

		$this->arResult['DONE_PROJECTS'] = $arrayOfProjects;

	}
}