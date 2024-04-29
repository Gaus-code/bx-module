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
			//TODO get bans for users
		}
	}
}