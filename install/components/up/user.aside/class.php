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
//
//		$query = \Up\Ukan\Model\UserTable::query();
//
//		$query->setSelect(['*', 'B_USER'])->where('ID', $userId);
//
//		$this->arResult['USER'] = $query->fetchObject();

		$user = \Up\Ukan\Model\UserTable::query();
		$user->setSelect(['*', 'B_USER'])->where('ID', $userId)->fetchCollection();
		//$user->getBUser()->getLogin();
		//echo $user->getBio();
		$bUser = \Up\Ukan\Model\BUserTable::query();
		$bUser->setSelect(['*'])->where('ID', $userId)->fetchObject();
		echo $bUser->getName();
	}

	protected function fetchTasks()
	{
		global $USER;
		$userId = $USER->GetID();

		$query = \Up\Ukan\Model\TaskTable::query();
		$query->setSelect(['ID', 'TITLE', 'B_USER'])->where('CLIENT_ID', $userId);

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