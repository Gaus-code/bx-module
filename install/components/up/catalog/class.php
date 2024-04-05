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
		//TODO fetch Tags from db

		$this->arResult['TAGS'] = [
			[
				'ID' => 1,
				'TITLE' => 'Frontend-разработчик',
			],
			[
				'ID' => 2,
				'TITLE' => 'Backend-разработчик',
			],
			[
				'ID' => 3,
				'TITLE' => 'FullStack-разработчик',
			],
			[
				'ID' => 4,
				'TITLE' => 'Тестировщик',
			],
			[
				'ID' => 5,
				'TITLE' => 'Дизайнер',
			],
			[
				'ID' => 6,
				'TITLE' => 'Специалист по безопасности',
			],
			[
				'ID' => 7,
				'TITLE' => 'Менеджер',
			],
			[
				'ID' => 8,
				'TITLE' => 'Верстальщик',
			],
			[
				'ID' => 9,
				'TITLE' => 'DevOps-инженер',
			],
			[
				'ID' => 10,
				'TITLE' => 'Аналитик',
			],

		];
	}

}