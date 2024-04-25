<?php

use Bitrix\Main\Type\DateTime;
use Up\Ukan\Service\Configuration;

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

		$nav = new \Bitrix\Main\UI\PageNavigation("notify");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['notification_list']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);


		$query = \Up\Ukan\Model\NotificationTable::query();

		$query->setSelect(['*', 'FROM_USER.B_USER.NAME', 'FROM_USER.B_USER.LAST_NAME', 'TASK']);

		$query->where('TO_USER_ID', $clientId);

		$query->addOrder('CREATED_AT', 'DESC');
		$query->setLimit($nav->getLimit() + 1);
		$query->setOffset($nav->getOffset());

		$result = $query->fetchCollection();

		$nav->setRecordCount($nav->getOffset() + count($result));

		$arrayOfNotifications = $result->getAll();
		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE'])
		{
			$this->arParams['EXIST_NEXT_PAGE'] = true;
			array_pop($arrayOfNotifications);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE'] = false;
		}

		$this->arResult['NOTIFICATIONS'] = $arrayOfNotifications;

		$notification = new Up\Ukan\Model\EO_Notification();


	}
}