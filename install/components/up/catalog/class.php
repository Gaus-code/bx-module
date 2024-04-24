<?php

class CatalogComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchTags();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		$arParams['CATEGORIES_ID'] = request()->get('categories');
		return $arParams;
	}
	protected function fetchTags()
	{
		$this->arResult['CATEGORIES'] = \Up\Ukan\Model\CategoriesTable::query()->setSelect(['*'])->fetchCollection();
	}

}