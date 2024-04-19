<?php

class CommentListComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->fetchUser();
		$this->includeComponentTemplate();
	}

	protected function fetchUser()
	{
		global $USER;
		$userId = $USER->GetID();

		$query = \Up\Ukan\Model\UserTable::query();

		$query->setSelect(['*', 'B_USER'])->where('ID', $userId);

		$this->arResult['USER'] = $query->fetchObject();
	}
}