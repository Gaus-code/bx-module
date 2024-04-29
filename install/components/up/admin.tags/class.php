<?php

class AdminTagsComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchTagList();
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

	protected function fetchTagList()
	{
		global $USER;
		if ($USER->IsAdmin())
		{
			$query = \Up\Ukan\Model\ReportsTable::query()
				->setSelect(['*', 'TO_TAG', 'TO_TASK'])
				->setFilter(['TYPE' => 'tag'])
				->fetchCollection();
			$this->arResult['ADMIN_TAGS'] = $query;
		}
	}
}