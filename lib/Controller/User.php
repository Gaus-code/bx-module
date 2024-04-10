<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\EO_User;
use Bitrix\Main\Type\DateTime;

class User extends Engine\Controller
{
	public static function changeUserBioAction(
		string $userName,
		string $userLastName,
		string $userLogin,
		string $userEmail,
		string $userBio
	)
	{
		$errors = [];
		global $USER;

		if (!$userName || !$userLogin || !$userEmail)
		{
			$errors[] =  'Не заполнены обязателные поля';
		}

		if ($USER->GetLogin() !== $userLogin && \CUser::GetByLogin($userLogin) && !\Up\Ukan\Repository\User::checkLoginExists($userLogin))
		{
			$errors[] = 'Логин занят';
		}

		$errorMessage = \Up\Ukan\Repository\User::changeInfo($userName, $userLastName, $userEmail, $userLogin, $USER->GetLogin());
		if (!$errorMessage && !count($errors))
		{
			$userId = $USER->GetID();
			$result = \Up\Ukan\Repository\User::updateUser($userId, $userLogin, $userName, $userLastName, $userEmail);

			$user = \Up\Ukan\Model\UserTable::getById($userId)->fetchObject();
			$user->setName($userName)->setSurname($userLastName)->setEmail($userEmail)->setUpdatedAt(new DateTime());
			if (!empty($userBio))
			{
				$user->setBio($userBio);
			}
			$user->save();

			if (!is_numeric($result))
			{
				foreach (explode('<br>', $result) as $error)
				{
					if ($error)
					{
						$errors[] = $error;
					}
				}
			}
		}
		else
		{
			foreach (explode('<br>', $errorMessage) as $error)
			{
				if ($error)
				{
					$errors[] = $error;
				}
			}
		}

		if ($errors)
		{
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/profile/'. $USER->GetID() .'/');
		}
		else
		{
			LocalRedirect('/profile/'. $USER->GetID() .'/');
		}
	}
}