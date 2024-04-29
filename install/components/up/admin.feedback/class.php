<?php

class AdminFeedbackComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchAdminFeedbacks();
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

	protected function fetchAdminFeedbacks()
	{
		global $USER;
		if ($USER->IsAdmin())
		{
			$query = \Up\Ukan\Model\ReportsTable::query()->setSelect(['*', 'TO_TASK', 'TO_FEEDBACK'])->fetchCollection();

			$this->arResult['ADMIN_FEEDBACKS'] = $query;
		}
	}
}