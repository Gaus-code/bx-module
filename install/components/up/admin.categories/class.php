<?php

class AdminFeedbackComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchCategories();
		$this->includeComponentTemplate();
	}
	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['USER_ID']) || $arParams['USER_ID'] <= 0)
		{
			$arParams['USER_ID'] = null;
		}

		if (!request()->get('PAGEN_1') || !is_numeric(request()->get('PAGEN_1')) || (int)request()->get('PAGEN_1') < 1)
		{
			$arParams['CURRENT_PAGE'] = 1;
		}
		else
		{
			$arParams['CURRENT_PAGE'] = (int)request()->get('PAGEN_1');
		}

		$arParams['EXIST_NEXT_PAGE'] = false;

		return $arParams;
	}

	protected function fetchCategories()
	{
		global $USER;
		if (!$USER->IsAdmin())
		{
			LocalRedirect('/access/denied/');
		}

		$nav = new \Bitrix\Main\UI\PageNavigation("admin_tables");
		$nav->allowAllRecords(true)
			->setPageSize(\Up\Ukan\Service\Configuration::getOption('page_size')['admin_tables']);
		$nav->setCurrentPage($this->arParams['CURRENT_PAGE']);

		$query = \Up\Ukan\Model\CategoriesTable::query()->setSelect(['*'])->whereNot('TITLE', 'Другое');

		$query->addOrder('TITLE');
		$query->setLimit($nav->getLimit() + 1);
		$query->setOffset($nav->getOffset());

		$result = $query->fetchCollection();
		$nav->setRecordCount($nav->getOffset() + count($result));

		$arrayOfCategories = $result->getAll();
		if ($nav->getPageCount() > $this->arParams['CURRENT_PAGE'])
		{
			$this->arParams['EXIST_NEXT_PAGE'] = true;
			array_pop($arrayOfCategories);
		}
		else
		{
			$this->arParams['EXIST_NEXT_PAGE'] = false;
		}

		$this->arResult['ADMIN_CATEGORIES'] = $arrayOfCategories;
	}
}