<?php

class UserResponseComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchResponses();
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

	private function fetchResponses()
	{
		$nav = new \Bitrix\Main\UI\PageNavigation("user.response");
		$nav->allowAllRecords(true)
			->setPageSize(4); //TODO remove hardcode
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);

		global $USER;
		$contractorId = $USER->GetID();

		$query = \Up\Ukan\Model\ResponseTable::query();

		$query->setSelect(['*', 'TASK'])->where('CONTRACTOR_ID', $contractorId);


		$query->addOrder('CREATED_AT', 'DESC');
		$query->setLimit($nav->getLimit() + 1);
		$query->setOffset($nav->getOffset());

		$result = $query->fetchCollection();

		$nav->setRecordCount($nav->getOffset() + count($result));

		$arrayOfResponses = $result->getAll();
		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE'])
		{
			$this->arParams['EXIST_NEXT_PAGE'] = true;
			array_pop($arrayOfResponses);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE'] = false;
		}

		$this->arResult['RESPONSES'] = $arrayOfResponses;

	}
}