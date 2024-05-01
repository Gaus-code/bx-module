<?php

class CatalogComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchCategories();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		$arParams['CATEGORIES_ID'] = request()->get('categories');
		return $arParams;
	}
	protected function fetchCategories()
	{
		$this->arResult['CATEGORIES'] = \Up\Ukan\Model\CategoriesTable::query()
																	  ->setSelect(['*'])
																	  ->addOrder('TITLE')
																	  ->fetchCollection();
	}

}