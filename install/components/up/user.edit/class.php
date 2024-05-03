<?php

class UserEditComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->checkUserBan();
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

		$query->setSelect(['*', 'B_USER.NAME', 'B_USER.LAST_NAME', 'B_USER.LOGIN', 'B_USER.EMAIL'])->where('ID', $userId);

		$this->arResult['USER'] = $query->fetchObject();
	}

	private function checkUserBan()
	{
		$user = \Up\Ukan\Model\UserTable::getById($this->arParams['USER_ID'])->fetchObject();
		if ($user->getIsBanned())
		{
			LocalRedirect('/access/denied/');
		}
	}
}