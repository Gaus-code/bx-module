<?php

class UserComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchUserActivity();
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
	protected function fetchUserActivity()
	{
		global $USER;
		$userId = (int)$USER->getId();


		if ($this->arParams['USER_ID'] === $userId)
		{
			$this->arResult['USER_ACTIVITY'] = 'owner';
		}
		else
		{
			$this->arResult['USER_ACTIVITY'] = 'other_user';
		}
	}
}