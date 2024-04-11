<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Application;
use Bitrix\Main\Engine;
use Bitrix\Main\EO_User;
use Bitrix\Main\Type\DateTime;
use Up\Ukan\Model\UserTable;


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

		if (empty(trim($userName)) || empty(trim($userLogin)) || empty(trim($userEmail)))
		{
			$errors[] =  'Не заполнены обязателные поля';
			Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/edit/profile/'. $USER->GetID() .'/');
		}

		if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL))
		{
			$errors[] =  'Почта указана в некорректном формате';
			Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/edit/profile/'. $USER->GetID() .'/');
		}

		if ($USER->GetLogin() !== $userLogin && \CUser::GetByLogin($userLogin) && !\Up\Ukan\Repository\User::checkLoginExists($userLogin))
		{
			$errors[] = 'Логин занят';
			Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/edit/profile/'. $USER->GetID() .'/');
		}

		$errorMessage = \Up\Ukan\Repository\User::changeInfo($userName, $userLastName, $userEmail, $userLogin, $USER->GetLogin());
		if (!$errorMessage && !count($errors))
		{
			$userId = $USER->GetID();
			$result = \Up\Ukan\Repository\User::updateUser($userId, $userLogin, $userName, $userLastName, $userEmail);

			$user = UserTable::getById($userId)->fetchObject();
			$user->setName($userName)->setSurname($userLastName)->setEmail($userEmail)->setUpdatedAt(new DateTime());

			!empty($userBio) ? $user->setBio($userBio) : $user->setBio(null);
			
			$user->save();

			LocalRedirect('/profile/'. $USER->GetID() .'/');
		}
	}

	public function changePasswordAction(
		string $oldPassword,
		string $newPassword,
		string $confirmPassword
	)
	{
		global $USER;
		$errors = [];

		if (empty(trim($oldPassword)))
		{
			$errors[] = 'Введите старый пароль';
		}

		if (empty(trim($newPassword)))
		{
			$errors[] = 'Введите новый пароль';
		}

		if (empty(trim($confirmPassword)))
		{
			$errors[] = 'Повторите новый пароль';
		}

		if (!$errors)
		{
			$errorMessage = $USER->Login($USER->GetLogin(), $oldPassword);

			if (is_bool($errorMessage) && $errorMessage)
			{
				if ($newPassword === $confirmPassword)
				{
					$user = new \CUser();
					$result = $user->update($USER->GetID(), [
						'PASSWORD' => $newPassword,
						'CONFIRM_PASSWORD' => $confirmPassword
					]);

					$ukanUser = UserTable::getById($USER->GetID())->fetchObject();

					$ukanPassword = password_hash($newPassword, PASSWORD_DEFAULT);

					$ukanUser->setHash($ukanPassword)->setUpdatedAt(new DateTime());

					$ukanUser->save();

					if (!$result)
					{
						$errors[] = $user->LAST_ERROR;
					}
					LocalRedirect('/profile/'.$USER->GetID().'/');
				}
				else
				{
					$errors[] = 'Пароли не совпадают';
				}
			}
			else
			{
				$errors[] = 'Неверный старый пароль';
			}
		}
		Application::getInstance()->getSession()->set('errors', $errors);
		LocalRedirect('/edit/profile/'.$USER->GetID().'/');
	}
}