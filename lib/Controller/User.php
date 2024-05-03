<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Application;
use Bitrix\Main\Engine;
use Bitrix\Main\EO_User;
use Bitrix\Main\Type\DateTime;
use Up\Ukan\Model\UserTable;
use Up\Ukan\Service\Validation;


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
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;

		$user = UserTable::getById($USER->GetID())->fetchObject();
		if ($user && $user->getIsBanned())
		{
			$errors[] = 'Вы заблокированы и не можете воспользоваться всем функционалом нашего сервиса';
			Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/profile/' . $USER->GetID() . '/edit/');
		}

		if (!empty(Validation::validateUserTextFields($userName, $userLastName, $userLogin, $userEmail)))
		{
			$errors = Validation::validateUserTextFields($userName, $userLastName, $userLogin, $userEmail);
			Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/profile/' . $USER->GetID() . '/edit/');
		}

		if (!empty(Validation::validateUserEmail($userEmail)) && $USER->GetEmail() !== $userEmail)
		{
			$errors = Validation::validateUserEmail($userEmail);
			Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/profile/' . $USER->GetID() . '/edit/');
		}

		if (!empty(Validation::checkLoginExists($userLogin)) && $USER->GetLogin() !== $userLogin && \CUser::GetByLogin($userLogin))
		{
			$errors = Validation::checkLoginExists($userLogin);
			Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/profile/' . $USER->GetID() . '/edit/');
		}

		$errorMessage = \Up\Ukan\Repository\User::changeInfo($userName, $userLastName, $userEmail, $userLogin, $USER->GetLogin());
		if (!$errorMessage)
		{
			$userId = $USER->GetID();
			\Up\Ukan\Repository\User::updateUser($userId, $userLogin, $userName, $userLastName, $userEmail);

			$user = UserTable::getById($userId)->fetchObject();
			$user->setUpdatedAt(new DateTime());

			!empty($userBio) ? $user->setBio($userBio) : $user->setBio(null);

			$user->save();

			LocalRedirect('/profile/' . $USER->GetID() . '/');
		}
	}

	public function changePasswordAction(
		string $oldPassword,
		string $newPassword,
		string $confirmPassword
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		$errors = [];
		$newPasswordErrors = Validation::validateUserPassword($newPassword);

		if (empty(trim($oldPassword)))
		{
			$errors[] = 'Введите старый пароль';
		}

		if ($newPasswordErrors)
		{
			$errors = array_merge($errors, $newPasswordErrors);
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
					$ukanUser->setUpdatedAt(new DateTime());
					$ukanUser->save();

					if (!$result)
					{
						$errors[] = $user->LAST_ERROR;
					}
					LocalRedirect('/profile/' . $USER->GetID() . '/');
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
		LocalRedirect('/profile/' . $USER->GetID() . '/edit/');
	}

	public static function changeContactsAction(
		string $contacts = null
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		$userId = $USER->GetID();

		$user = UserTable::getById($userId)->fetchObject();
		if ($user && $user->getIsBanned())
		{
			$errors[] = 'Вы заблокированы и не можете воспользоваться всем функционалом нашего сервиса';
			Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/profile/' . $USER->GetID() . '/edit/');
		}

		if (!empty($contacts))
		{
			$user = \Up\Ukan\Model\UserTable::getById($userId)->fetchObject();
			$user->setContacts($contacts);
			$user->save();
		}

		LocalRedirect('/profile/' . $USER->GetID() . '/');
	}

	public static function getUserImage($userId)
	{
		$fileId = \Up\Ukan\Repository\User::getUserImageId($userId);
		return $fileId;
	}
}