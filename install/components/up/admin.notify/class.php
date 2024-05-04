<?php

class AdminNotifyComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchAdminNotification();
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

	protected function fetchAdminNotification()
	{
		global $USER;
		if (!$USER->IsAdmin())
		{
			LocalRedirect('/access/denied/');
		}

		$nav = new \Bitrix\Main\UI\PageNavigation("admin_tables");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['notification_list_admin']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);

		$query =  \Up\Ukan\Model\ReportsTable::query()
											 ->setSelect(['*', 'TO_USER', 'TASK', 'TO_FEEDBACK']);

		$query->setLimit($nav->getLimit() + 1);
		$query->setOffset($nav->getOffset());

		$result = $query->fetchCollection();
		$nav->setRecordCount($nav->getOffset() + count($result));

		$arrayOfNotify = $result->getAll();
		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE'])
		{
			$this->arParams['EXIST_NEXT_PAGE'] = true;
			array_pop($arrayOfNotify);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE'] = false;
		}

		$this->arResult['ADMIN_NOTIFY'] = $arrayOfNotify;


	}
}