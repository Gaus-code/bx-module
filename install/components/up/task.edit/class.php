<?php

class UserEditTask extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->checkUserBan();
		$this->fetchCategories();
		$this->fetchTask();
		$this->fetchTags();
		$this->fetchProjects();
		$this->checkUser();
		$this->fethUserSubscriptionStatus();
		$this->includeComponentTemplate();
	}

	public function onPrepareComponentParams($arParams)
	{
		if (!isset($arParams['TASK_ID']) || $arParams['TASK_ID'] <= 0)
		{
			$arParams['TASK_ID'] = null;
		}
		if (!isset($arParams['USER_ID']) || $arParams['USER_ID'] <= 0)
		{
			$arParams['USER_ID'] = null;
		}

		return $arParams;

	}

	protected function fetchProjects()
	{

		if ($this->arParams['USER_ID'])
		{
			$this->arResult['PROJECTS'] = \Up\Ukan\Model\ProjectTable::query()->setSelect(['*'])->where(
				'CLIENT_ID',
				$this->arParams['USER_ID']
			)->fetchCollection();
		}
		else
		{
			die('incorrect user id');
		}

	}

	protected function fetchTags()
	{
		$tags = \Up\Ukan\Model\TagTable::query()->setSelect(['*'])->where('TASKS.ID', $this->arParams['TASK_ID'])
									   ->fetchCollection();

		$tagString = '';
		foreach ($tags as $tag)
		{
			$tagString .= '#' . $tag->getTitle() . ' ';
		}
		$this->arResult['TAGS_STRING'] = $tagString;

	}

	protected function fetchCategories()
	{
		$this->arResult['CATEGORIES'] = \Up\Ukan\Model\CategoriesTable::query()->setSelect(['*'])->fetchCollection();
	}

	protected function fetchTask()
	{

		if ($this->arParams['TASK_ID'])
		{
			$this->arResult['TASK'] = \Up\Ukan\Model\TaskTable::query()->setSelect(
				['*', 'TAGS', 'CONTRACTOR', 'CONTRACTOR.B_USER', 'PROJECT']
			)->where('ID', $this->arParams['TASK_ID'])->fetchObject();
		}

	}

	private function checkUserBan()
	{
		$user = \Up\Ukan\Model\UserTable::getById($this->arParams['USER_ID'])->fetchObject();
		if ($user->getIsBanned())
		{
			LocalRedirect('/access/denied/');
		}
	}

	private function checkUser()
	{
		global $USER;
		$userId = (int)$USER->GetID();

		if ($this->arResult['TASK'] && ($userId !== $this->arResult['TASK']->getClientId()))
		{
			LocalRedirect('/access/denied/');
		}
	}

	private function fethUserSubscriptionStatus()
	{
		global $USER;
		$userId = (int)$USER->GetID();

		$user = \Up\Ukan\Model\UserTable::query()->setSelect(['ID', 'SUBSCRIPTION_STATUS'])
			->where('ID', $userId)
			->fetchObject();

		$this->arResult['USER_SUBSCRIPTION_STATUS'] = ($user->getSubscriptionStatus()==='Active');
	}
}