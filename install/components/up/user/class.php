<?php

class UserComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->includeComponentTemplate();
		$this->fetchUser();
	}

	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['USER_ID']) || $arParams['USER_ID'] <= 0)
		{
			$arParams['USER_ID'] = null;
		}

		return $arParams;
	}
	protected function fetchUser()
	{
		//coming soon...
	}
}