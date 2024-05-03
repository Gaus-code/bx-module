<?php

class UserAsideComponent extends CBitrixComponent
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

		$query->setSelect(['*', 'B_USER.NAME', 'B_USER.LAST_NAME', 'B_USER.EMAIL'])->where('ID', $this->arParams['USER_ID']);

		$this->arResult['USER'] = $query->fetchObject();
	}

	protected function fetchUserActivity()
	{
		global $USER;
		$userId = (int)$USER->getId();


		if ($this->arParams['USER_ID'] === $userId)
		{
			$this->arResult['USER_ACTIVITY'] = 'owner';
			$this->fetchNotifyCount();
		}
		else
		{
			$this->arResult['USER_ACTIVITY'] = 'other_user';
		}
	}

	private function fetchNotifyCount()
	{
		$notifications = \Up\Ukan\Model\NotificationTable::query()
														 ->addSelect('COUNT(*) as NOTIFICATION_COUNT')
														 ->where('TO_USER_ID', $this->arParams['USER_ID'])
														 ->exec()
														 ->fetchAll();

		$this->arResult['NOTIFICATION_COUNT'] = count($notifications);

	}
}