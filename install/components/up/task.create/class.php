<?php

class TaskListComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchTags();
		$this->fetchProjects();
		$this->includeComponentTemplate();
	}

	protected function fetchProjects()
	{
		//TODO fetch projects from db (by CLIENT_ID)

		$this->arResult['PROJECTS'] = [
			[
				'ID' => 1,
				'TITLE' => 'Интернет-магазин',
			],
			[
				'ID' => 2,
				'TITLE' => 'Сервис UKAN',
			],
			[
				'ID' => 3,
				'TITLE' => 'Диплом',
			],
		];
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