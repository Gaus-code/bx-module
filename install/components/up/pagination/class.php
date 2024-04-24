<?php

class ProjectCreateComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchURL();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{

		if (
			!request()->get('PAGEN_1' . $arParams['NAME_OF_PAGE'])
			|| !is_numeric(
				request()->get('PAGEN_1' . $arParams['NAME_OF_PAGE'])
			)
			|| (int)request()->get('PAGEN_1' . $arParams['NAME_OF_PAGE']) < 1
		)
		{
			$arParams['CURRENT_PAGE'] = 1;
		}
		else
		{
			$arParams['CURRENT_PAGE'] = (int)request()->get('PAGEN_1' . $arParams['NAME_OF_PAGE']);
		}

		if (!isset($arParams['EXIST_NEXT_PAGE']))
		{
			$arParams['EXIST_NEXT_PAGE'] = false;
		}

		return $arParams;
	}

	private function fetchURL()
	{
		$currentUrl = request()->getRequestUri();

		$pattern = 'PAGEN_1' . $this->arParams['NAME_OF_PAGE'];

		[$urlPart, $queryString] = array_pad(explode("?", $currentUrl), 2, "");
		parse_str($queryString, $queryParameters);

		unset($queryParameters[$pattern]);
		$newUrl = $urlPart . '?';
		if (!empty($queryParameters))
		{
			$newUrl .=  http_build_query($queryParameters) . '&';
		}

		$newUrl .= $pattern . '=';

		$this->arParams['NEW_URI'] = $newUrl;
	}

}
