<?php

class UserResponseComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchResponses();
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

	private function fetchResponses()
	{
		global $USER;
		$contractorId = $USER->GetID();

		$query = \Up\Ukan\Model\ResponseTable::query();

		$query->setSelect(['*', 'TASK'])->where('CONTRACTOR_ID', $contractorId);

		$this->arResult['RESPONSES'] = $query->fetchCollection();

	}
}