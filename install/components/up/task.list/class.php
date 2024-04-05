<?php

class TaskListComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchTasks();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['CLIENT_ID']) || $arParams['CLIENT_ID'] <= 0)
		{
			$arParams['CLIENT_ID'] = null;
		}

		if (!isset($arParams['TAG_ID']) || $arParams['TAG_ID'] === [] )
		{
			$arParams['TAG_ID'] = null;
		}

		if (!isset($arParams['IS_PERSONAL_ACCOUNT_PAGE']))
		{
			$arParams['IS_PERSONAL_ACCOUNT_PAGE'] = false;
		}

		return $arParams;

	}

	protected function fetchTasks()
	{
		//TODO fetchTasks from db using filters (CLIENT_ID and TAG_ID)


		if (is_null($this->arParams['CLIENT_ID']))
		{
			$this->arResult['TASKS'] = \Up\Ukan\Model\TaskTable::query()->setSelect(['*', 'CLIENT', 'TAGS'])->fetchCollection();
		}
		else
		{
			$this->arResult['TASKS'] = \Up\Ukan\Model\TaskTable::query()->setSelect(['*', 'TAGS'])->where('CLIENT_ID',$this->arParams['CLIENT_ID'])->fetchCollection();
		}

	}

}