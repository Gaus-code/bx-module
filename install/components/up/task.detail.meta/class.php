<?php

class TaskDetailMetaComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		global $USER;
		$arParams['USER_ID'] = (int)$USER->getId();

		if (!$arParams['USER_ACTIVITY'] || !in_array($arParams['USER_ACTIVITY'], [
				'.default',
				'contractor_this_task',
				'another_contractor',
				'owner',
				'reject',
				'wait',
				'admin'
			], true))
		{
			$arParams['USER_ACTIVITY'] = '.default' ;
		}

		$arParams['TASK_STATUSES'] = \Up\Ukan\Service\Configuration::getOption('task_status');

		return $arParams;
	}

}