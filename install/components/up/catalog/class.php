<?php

class CatalogComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchTags();
		$this->includeComponentTemplate();
	}

	protected function fetchTags()
	{

		$this->arResult['TAGS'] = \Up\Ukan\Model\TagTable::query()->setSelect(['*'])->fetchCollection();

	}

}