<?php

class UserEditComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchUser();
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

	protected function fetchUser()
	{
		global $USER;
		$userId = $USER->GetID();

		$query = \Up\Ukan\Model\UserTable::query();

		$query->setSelect(['*', 'B_USER'])->where('ID', $userId);

		$this->arResult['USER'] = $query->fetchObject();
	}
}