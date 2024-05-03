<?php

class UserEditComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->checkUserBan();
		$this->fetchUser();
		$this->arResult['FILES'] = $this->prepareFileInput();
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

		$query->setSelect(['*', 'B_USER.NAME', 'B_USER.LAST_NAME', 'B_USER.LOGIN', 'B_USER.EMAIL', 'B_USER.PERSONAL_PHOTO'])->where('ID', $userId);

		$this->arResult['USER'] = $query->fetchObject();
	}

	protected function prepareFileInput()
	{
		return \Bitrix\Main\UI\FileInput::createInstance(
			[
				"name" => "files[#IND#]",
				"description" => true,
				"upload" => true,
				"allowUpload" => "A",
				"medialib" => true,
				"fileDialog" => true,
				"delete" => true,
				"maxCount" => 1,
				"maxSize" => 2 * 1024 * 1024
			]);
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