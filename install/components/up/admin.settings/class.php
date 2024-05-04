<?php

use Up\Ukan\Model\EO_SecretOptionSite;
use Up\Ukan\Model\SecretOptionSiteTable;

class AdminSettingsComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchAdminUsers();
		$this->fetchIssetOptionsYandexGPT();
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

	protected function fetchAdminUsers()
	{
		global $USER;
		if (!$USER->IsAdmin())
		{
			LocalRedirect('/access/denied/');
		}
	}
	protected function fetchIssetOptionsYandexGPT()
	{
		$options = SecretOptionSiteTable::query()->setSelect(['ID', 'NAME', 'VALUE'])
										->whereIn('NAME', ['secret_key', 'directory_id'])
										->fetchCollection();

		$this->arResult['ISSET_OPTIONS_YANDEX_GPT'] = (count($options)===2);
	}
}