<?php

use Bitrix\Main\Engine\Controller;


class Subscription extends Controller
{
	public function createAction(

	)
	{
		if (check_bitrix_sessid())
		{
			global $USER;

			$clientId = $USER->GetID();


		}
	}

}