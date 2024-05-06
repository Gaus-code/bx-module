<?php

use Up\Ukan\Service\Configuration;

class UserComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$messages = [
			[
				"role" => "system",
				"text" => "Далее ты получишь описание задачи. 
				Выбери подходящие теги из списка.
				Если ни одна из категорий не подходит пиши напиши только '0'.
				В ответ напиши только номера тегов через запятую и ничего более.",
			],
			[
				"role" => "user",
				"text" => "Описание задачи:",
			],
		];
		echo '<pre>';
		return var_dump(\Up\Ukan\AI\GPT\YandexGPT::getResponse($messages)); die;
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
		$this->arResult['USER'] = \Up\Ukan\Model\UserTable::query()
			->setSelect([
					'*',
					'B_USER.NAME',
					'B_USER.LAST_NAME',
					'B_USER.DATE_REGISTER',
					'SUBSCRIPTION_STATUS'
						])
			->where('ID', $this->arParams['USER_ID'])
			->fetchObject();

		$userContractorRatingResult = \Up\Ukan\Model\UserTable::query()
				  ->setSelect(['ID', 'RATING', 'FEEDBACK_COUNT','FEEDBACKS_TO.TO_USER_ROLE'])
				  ->where('ID', $this->arParams['USER_ID'])
				  ->where('FEEDBACKS_TO.TO_USER_ROLE', Configuration::getOption('user_role')['contractor'])
				  ->fetch();

		$userContractorRating['RATING']=round((float)$userContractorRatingResult['RATING'],1);
		$userContractorRating['FEEDBACK_COUNT']=(int)$userContractorRatingResult['FEEDBACK_COUNT'];

		$userClientRatingResult = \Up\Ukan\Model\UserTable::query()
				  ->setSelect(['ID', 'RATING', 'FEEDBACK_COUNT','FEEDBACKS_TO.TO_USER_ROLE'])
				  ->where('ID', $this->arParams['USER_ID'])
				  ->where('FEEDBACKS_TO.TO_USER_ROLE', Configuration::getOption('user_role')['client'])
				  ->fetch();

		$userClientRating['RATING']=round((float)$userClientRatingResult['RATING'],1);
		$userClientRating['FEEDBACK_COUNT']=(int)$userClientRatingResult['FEEDBACK_COUNT'];

		$this->arResult['USER_CONTRACTOR_RATING'] = $userContractorRating;
		$this->arResult['USER_CLIENT_RATING'] = $userClientRating;

		$this->arResult['PROFILE_IMAGE'] = \Up\Ukan\Controller\User::getUserImage($this->arParams['USER_ID']);

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