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
			$query = \Up\Ukan\Model\ReportsTable::query()
				->setSelect(['*', 'TASK', 'TO_FEEDBACK'])
				->setFilter(['TYPE' => 'feedback'])
				->fetchCollection();

			$this->arResult['ADMIN_FEEDBACKS'] = $query;
		}
	}
}