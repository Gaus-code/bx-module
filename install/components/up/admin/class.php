<?php

class AdminComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->getTaskList();
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

	protected function getTaskList()
	{
		global $USER;

		if ($USER->IsAdmin())
		{
			$query = \Up\Ukan\Model\ReportsTable::query()
				->setSelect(['*', 'TO_TASK'])
				->setFilter(['TYPE' => 'task'])
				->fetchCollection();
			$this->arResult['ADMIN_TASKS'] = $query;
		}
	}
}