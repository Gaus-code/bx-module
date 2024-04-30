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
		global $USER;
		$query = \Up\Ukan\Model\UserTable::query();

		$this->arResult['USER'] = $query->setSelect(['*', 'B_USER.NAME', 'B_USER.LAST_NAME', 'B_USER.DATE_REGISTER','SUBSCRIPTION_STATUS'])->where('ID', $this->arParams['USER_ID'])->fetchObject();
		$this->arResult['PROFILE_IMAGE'] = \Up\Ukan\Controller\User::getUserImage($USER->GetID());
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
			$this->fetchIssetReport();
		}
	}

	private function fetchIssetReport()
	{

		global $USER;
		$userId = (int)$USER->getId();
		$report = \Up\Ukan\Model\ReportsTable::query()
											 ->setSelect(['ID'])
											 ->where('FROM_USER_ID', $userId)
											 ->where('TO_USER_ID', $this->arParams['USER_ID'])
											 ->where('TYPE', 'user')
											 ->fetchObject();
		$this->arResult['ISSET_REPORT'] = (bool)$report;


	}
}