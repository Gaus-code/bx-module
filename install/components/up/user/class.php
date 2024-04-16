<?php

class UserComponent extends CBitrixComponent
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

		$this->arResult['USER'] = $query->setSelect(['*', 'B_USER', 'SUBSCRIPTION_STATUS'])->where('ID', $userId)->fetchObject();
		// echo $this->arResult['USER']->get('B_USER')->getName(); die;

	}

}