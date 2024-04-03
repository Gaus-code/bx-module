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
			unset($arParams['CLIENT_ID']);
		}

		if (!isset($arParams['TAG_ID']) || $arParams['TAG_ID'] === [] )
		{
			unset($arParams['TAG_ID']);
		}

		return $arParams;

	}

	protected function fetchTasks()
	{
		//TODO fetchTasks from db using filters (CLIENT_ID and TAG_ID)


		$this->arResult['TASKS'] = [
			[
				'ID' => 1,
				'TITLE' => 'Bugo Website About page 1',
				'DESCRIPTION' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.',
				'CLIENT' => 'Заказчик Заказчиков',
				'TAGS' => ['Website', 'Design', 'PHP'],
			],
			[
				'ID' => 2,
				'TITLE' => 'Bugo Website About page 2',
				'DESCRIPTION' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.',
				'CLIENT' => 'Заказчик Заказчиков',
				'TAGS' => ['Website', 'Design'],
			],
			[
				'ID' => 3,
				'TITLE' => 'Bugo Website About page 3',
				'DESCRIPTION' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.',
				'CLIENT' => 'Заказчик Заказчиков',
				'TAGS' => ['Website', 'Design'],
			],
			[
				'ID' => 4,
				'TITLE' => 'Bugo Website About page 4',
				'DESCRIPTION' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.',
				'CLIENT' => 'Заказчик Заказчиков',
				'TAGS' => ['Website', 'Design'],
			],
			[
				'ID' => 5,
				'TITLE' => 'Bugo Website About page 5',
				'DESCRIPTION' => 'Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.',
				'CLIENT' => 'Заказчик Заказчиков',
				'TAGS' => ['Website', 'Design'],
			],

		];
	}

}