<?php

class AdminFeedbackComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchAdminUsers();
		$this->includeComponentTemplate();
	}
	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['USER_ID']) || $arParams['USER_ID'] <= 0)
		{
			$arParams['USER_ID'] = null;
		}

		return $arParams;
	}

	protected function fetchAdminUsers()
	{
		global $USER;
		if ($USER->IsAdmin())
		{
			$query = \Up\Ukan\Model\ReportsTable::query()
					->setSelect(['*', 'TO_USER.B_USER.NAME'])
					->setFilter(['TYPE' => 'user'])
					->fetchCollection();

			$this->arResult['ADMIN_USERS'] = $query;
		}
	}
}