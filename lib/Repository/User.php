<?php

namespace Up\Ukan\Repository;

use Up\Ukan\Model\BUserTable;

class User
{
	public static function registerUser(
		string $login,
		string $name,
		string $lastname,
		string $password,
		string $email
	)
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

	public static function updateUser(
		$userId,
		string $userLogin,
		string $userName,
		string $userLastName,
		string $userEmail
	)
	{
		global $USER;
		$resultMessage = $USER->Update($userId, [
			'LOGIN' => $userLogin,
			'NAME' => $userName,
			'LAST_NAME' => $userLastName,
			'EMAIL' => $userEmail
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

	public static function changeInfo(
		string $userName,
		string $userLastName,
		string $userEmail,
		string $newLogin,
		string $userLogin
	)
	{
		return BUserTable::query()
			->setSelect(['*'])
			->setFilter(['LOGIN' => $userLogin])
			->fetchObject()
			->setName($userName)
			->setLastName($userLastName)
			->setEmail($userEmail)
			->setLogin($newLogin)
			->save()->getErrorMessages();
	}

	public static function checkUniqueFieldsExist(
		string $field,
		string $value
	)
	{
		$result = BUserTable::query()
			->setSelect(['ID'])
			->setFilter([$field => $value])
			->fetch();
		if ($result)
		{
			return False;
		}
		return True;
	}

	public static function getUserImageId($userId)
	{
		return BUserTable::query()
			->setSelect(['PERSONAL_PHOTO'])
			->setFilter(['ID'=>$userId])
			->fetch()['PERSONAL_PHOTO'];
	}

	public static function setUserImage($userId, $fileId)
	{
		$user = BUserTable::getById($userId)->fetchObject();
		$user->set('PERSONAL_PHOTO', $fileId);

		if (!$user->save()->isSuccess())
		{
			return False;
		}
	}

	public static function deleteUserImage($userId)
	{
		$photo = BUserTable::query()
			->setSelect(['PERSONAL_PHOTO'])
			->setFilter(['ID' => $userId])
			->fetchObject();

		if ($photo)
		{
			$photo->set('PERSONAL_PHOTO' , null)->save();
		}
	}
}