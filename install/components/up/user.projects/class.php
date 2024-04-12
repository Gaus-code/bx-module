<?php

class UserProjectsComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchProjects();
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

	private function fetchProjects()
	{
		$nav = new \Bitrix\Main\UI\PageNavigation("user.projects");
		$nav->allowAllRecords(true)
			->setPageSize(7); //TODO remove hardcode
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);

		global $USER;
		$clientId = $USER->GetID();

		$query = \Up\Ukan\Model\ProjectTable::query();

		$query->setSelect(['*', 'CLIENT']);

		$query->where('CLIENT_ID', $clientId);

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

		$this->arResult['PROJECTS'] = $arrayOfProjects;
	}
}