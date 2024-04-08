<?php

namespace Up\Ukan\Repository;

use Up\Ukan\Model\BUserTable;

class User
{
	public static function registerUser($login, $name, $lastname, $password, $email)
	{
		global $USER;

		$resultMessage = $USER->Register($login, $name, $lastname, $password, $password, $email);
		if ($resultMessage['TYPE'] === 'OK')
		{
			$userId = $USER->GetID();
			$USER->Update($userId, [
				"WORK_COMPANY" => 'UKAN'
			]);
			return $USER->GetID();
		}

		return $resultMessage['MESSAGE'];
	}

	public static function updateUser($userId, $userLogin, $userName, $userLastName)
	{
		global $USER;
		$resultMessage = $USER->Update($userId, [
			'LOGIN' => $userLogin,
			'NAME' => $userName,
			'LAST_NAME' => $userLastName,
		]);
		if ($resultMessage['TYPE'] === 'OK')
		{
			$userId = $USER->GetID();
			$USER->Update($userId, [
				"WORK_COMPANY" => 'UKAN'
			]);
			return $USER->GetID();
		}
		return $resultMessage['MESSAGE'];
	}

	public static function changeInfo($userName, $userLastName, $newLogin, $userLogin)
	{
		return BUserTable::query()
			->setSelect(['*'])
			->setFilter(['LOGIN' => $userLogin])
			->fetchObject()
			->setName($userName)
			->setLastName($userLastName)
			->setLogin($newLogin)
			->save()->getErrorMessages();
	}

	public static function checkLoginExists($login)
	{
		$result = BUserTable::query()
			->setSelect(['ID'])
			->setFilter(['LOGIN' => $login])
			->fetch();
		if ($result)
		{
			return False;
		}
		return True;
	}
}