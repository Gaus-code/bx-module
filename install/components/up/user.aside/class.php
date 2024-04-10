<?php

class UserAsideComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchUser();
		$this->fetchTasks();
		$this->fetchProjects();
		$this->includeComponentTemplate();
	}

	protected function fetchUser()
	{
		global $USER;
		$userId = $USER->GetID();

		$query = \Up\Ukan\Model\UserTable::query();

		$query->setSelect(['*'])->where('ID', $userId);

		$this->arResult['USER'] = $query->fetchCollection();
	}

	protected function fetchTasks()
	{
		global $USER;
		$userId = $USER->GetID();

		$query = \Up\Ukan\Model\TaskTable::query();
		$query->setSelect(['ID', 'TITLE'])->where('CLIENT_ID', $userId);

		$this->arResult['TASKS'] = $query->fetchCollection();
	}

	protected function fetchProjects()
	{
		global $USER;
		$userId = $USER->GetID();

		$query = \Up\Ukan\Model\ProjectTable::query();
		$query->setSelect(['ID', 'TITLE'])->where('CLIENT_ID', $userId);

		$this->arResult['PROJECTS'] = $query->fetchCollection();
	}
}