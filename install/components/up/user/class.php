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
		$this->arResult['USER'] = \Up\Ukan\Model\UserTable::query()->setSelect(['*', 'B_USER.NAME', 'B_USER.LAST_NAME', 'B_USER.DATE_REGISTER','SUBSCRIPTION_STATUS'])
										->where('ID', $this->arParams['USER_ID'])
										->fetchObject();

		$userRatingResult = \Up\Ukan\Model\UserTable::query()->setSelect(['ID', 'RATING', 'FEEDBACK_COUNT'])
															 ->where('ID', $this->arParams['USER_ID'])
															 ->fetch();

		$userRating['RATING']=round((float)$userRatingResult['RATING'],1);
		$userRating['FEEDBACK_COUNT']=(int)$userRatingResult['FEEDBACK_COUNT'];

		$this->arResult['USER_RATING'] = $userRating;

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