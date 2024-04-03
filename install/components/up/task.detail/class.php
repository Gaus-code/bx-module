<?php

class TaskDetailComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchTask();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['TASK_ID']) || $arParams['TASK_ID'] <= 0)
		{
			unset($arParams['TASK_ID']);
		}

		return $arParams;
	}
	protected function fetchTask()
	{
		$task = [
			[
				'ID' => 1,
				'TITLE' => 'СУПЕР ЗАГОЛОВОК ДЛЯ СУПЕР ЗАДАЧИ',
				'DESCRIPTION' => 'СУПЕР ОПИСАНИЕ ДЛЯ СУПЕР ЗАДАЧИ РАССЧИТАННОЕ НА 400+ СИМВОЛОВ, НО НЕ СЕЙЧАС. СЕЙЧАС СИМВОЛОВ БУДЕТ 88 :)',
				'PRIORITY' => 'Высокий',
				'CLIENT' => 'Заказчик Заказчиков',
				'STATUS' => 'Новая',
				'TAGS' => ['Website', 'Design'],
			],
		];
		$this->arResult['TASK'] =  $task;
	}
}