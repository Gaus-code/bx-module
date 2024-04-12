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
		global $USER;
		$clientId = $USER->GetID();

		$pageSize = 7; //TODO remove hardcode
		$currentPage = $this->arParams['CURRENT_PAGE'];
		$offset = ($currentPage - 1) * $pageSize;

		$query = \Up\Ukan\Model\ProjectTable::query();

		$query->setSelect(['*', 'CLIENT']);

		$query->where('CLIENT_ID', $clientId);

		$query->addOrder('CREATED_AT', 'DESC');
		$query->setLimit($pageSize + 1);
		$query->setOffset($offset);

		$result = $query->fetchCollection();

		$arrayOfResponses = $result->getAll();
		if (count($result) === $pageSize + 1)
		{
			$this->arParams['EXIST_NEXT_PAGE'] = true;
			array_pop($arrayOfResponses);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE'] = false;
		}

		$this->arResult['PROJECTS'] = $arrayOfResponses;
	}
}