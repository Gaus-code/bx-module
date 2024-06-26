<?php

class CommentEditComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->checkUserBan();
		$this->fetchFeedback();
		$this->checkUser();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['FEEDBACK_ID']) || $arParams['FEEDBACK_ID'] <= 0)
		{
			$arParams['FEEDBACK_ID'] = null;

		}
		if (!isset($arParams['USER_ID']) || $arParams['USER_ID'] <= 0)
		{
			$arParams['USER_ID'] = null;
		}

		return $arParams;
	}

	protected function fetchFeedback()
	{
		$query = \Up\Ukan\Model\FeedbackTable::query();

		$query->setSelect(['*', 'TASK'])->where('ID', $this->arParams['FEEDBACK_ID']);

		$this->arResult['FEEDBACK'] = $query->fetchObject();
	}

	private function checkUserBan()
	{
		$user = \Up\Ukan\Model\UserTable::getById($this->arParams['USER_ID'])->fetchObject();
		if ($user->getIsBanned())
		{
			LocalRedirect('/access/denied/');
		}
	}

	private function checkUser()
	{
		global $USER;
		$userId = (int)$USER->GetID();

		if ($this->arResult['FEEDBACK'] && ($userId !== $this->arResult['FEEDBACK']->getFromUserId()))
		{
			LocalRedirect('/access/denied/');
		}
	}

}