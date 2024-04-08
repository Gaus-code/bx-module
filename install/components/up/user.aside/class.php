<?php

class UserAsideComponent extends CBitrixComponent
{
	public function executeComponent()
	{
		$this->includeComponentTemplate();
		$this->fetchUser();
	}

	protected function fetchUser()
	{
		//coming soon...
	}
}