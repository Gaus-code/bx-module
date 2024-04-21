<?php

class UserComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchUserActivity();
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
		$query = \Up\Ukan\Model\UserTable::query();

		$this->arResult['USER'] = $query->setSelect(['*', 'B_USER', 'SUBSCRIPTION_STATUS'])->where('ID', $this->arParams['USER_ID'])->fetchObject();

		// $user = $query->setSelect(['*', 'B_USER','SUBSCRIPTION_END_DATE', 'SUBSCRIPTION_STATUS'])->where('ID', $userId)->fetchCollection();
		// echo $user->getByPrimary($userId)->get('SUBSCRIPTION_END_DATE'); die;

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