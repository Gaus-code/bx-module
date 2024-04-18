<?php

class ProjectCreateComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		if (!request()->get('PAGEN_1') || !is_numeric(request()->get('PAGEN_1')) || (int)request()->get('PAGEN_1') < 1)
		{
			$arParams['CURRENT_PAGE'] = 1;
		}
		else
		{
			$arParams['CURRENT_PAGE'] = (int)request()->get('PAGEN_1');
		}

		if (!isset($arParams['EXIST_NEXT_PAGE']))
		{
			$arParams['EXIST_NEXT_PAGE'] = false;
		}

		$currentUrl = request()->getRequestUri();
		$arParams['NEW_URI'] = $currentUrl . (!strpos($currentUrl, '?') ? '?' : '&') . 'PAGEN_1=';

		return $arParams;
	}

}
