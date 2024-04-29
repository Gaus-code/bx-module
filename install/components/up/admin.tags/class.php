<?php

class AdminTagsComponent extends CBitrixComponent
{
	public function executeComponent()
	{
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

	protected function getTagList()
	{
		global $USER;
		if ($USER->IsAdmin())
		{
			$query = \Up\Ukan\Model\ReportsTable::query()->setSelect(['*'])->fetchCollection();
			//TODO implement method, add tagList to reports
		}
	}
}