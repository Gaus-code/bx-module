<?php

class CatalogComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchCategories();
		$this->fetchSubscriber();
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

	protected function fetchSubscriber()
	{
		global $USER;
		$userId = $USER->GetID();
		$this->arResult['SUBSCRIBER'] = \Up\Ukan\Model\UserTable::query()->setSelect(['SUBSCRIPTION_STATUS'])
			->where('ID', $userId)
			->fetchObject();
	}
}