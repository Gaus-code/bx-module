<?php

class UserNotifyComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchNotify();
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

	private function fetchNotify()
	{
		global $USER;
		$clientId = $USER->getID();

		$nav = new \Bitrix\Main\UI\PageNavigation("user.notify");
		$nav->allowAllRecords(true)
			->setPageSize(5); //TODO remove hardcode
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);

		$query = \Up\Ukan\Model\ResponseTable::query();

		$query->setSelect(['*', 'TASK', 'CONTRACTOR']);

		$query->where('TASK.CLIENT_ID', $clientId);

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