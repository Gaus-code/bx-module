<?php

class UserProjectsComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchActiveProjects();
		$this->fetchCompletedProjects();
		$this->fetchUserBan();
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

	private function fetchActiveProjects()
	{
		$nav = new \Bitrix\Main\UI\PageNavigation("project.list");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['project_list']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);

		global $USER;
		$clientId = $USER->GetID();

		$query = \Up\Ukan\Model\ProjectTable::query();

		$query->setSelect(['*', 'CLIENT']);

		$query->where('CLIENT_ID', $clientId)
			  ->where('STATUS', \Up\Ukan\Service\Configuration::getOption('project_status')['active']);

		$query->addOrder('CREATED_AT', 'DESC');
		$query->setLimit($nav->getLimit() + 1);
		$query->setOffset($nav->getOffset());

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

		$this->arResult['ACTIVE_PROJECTS'] = $arrayOfProjects;
	}
	private function fetchCompletedProjects()
	{
		$nav = new \Bitrix\Main\UI\PageNavigation("project.list");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['project_list']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);

		global $USER;
		$clientId = $USER->GetID();

		$query = \Up\Ukan\Model\ProjectTable::query();

		$query->setSelect(['*', 'CLIENT']);

		$query->where('CLIENT_ID', $clientId)
			  ->where('STATUS', \Up\Ukan\Service\Configuration::getOption('project_status')['completed']);

		$query->addOrder('CREATED_AT', 'DESC');
		$query->setLimit($nav->getLimit() + 1);
		$query->setOffset($nav->getOffset());

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

		$this->arResult['COMPLETED_PROJECTS'] = $arrayOfProjects;
	}

	private function fetchUserBan()
	{
		$user = \Up\Ukan\Model\UserTable::getById($this->arParams['USER_ID'])->fetchObject();
		$this->arResult['USER_IS_BANNED'] = $user->getIsBanned();
	}
}