<?php
namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\Context;
use Up\Ukan\Model\BUserTable;
use Up\Ukan\Model\EO_User;
use Up\Ukan\Repository\User;

class Auth extends Engine\Controller
{
	public function configureActions(): array
	{
		return [
			'signin' => [
				'-prefilters' => [
					Engine\ActionFilter\Authentication::class,
				],
			],
			'signupUser' => [
				'-prefilters' => [
					Engine\ActionFilter\Authentication::class,
				],
			],
		];
	}

	public function signInAction($login, $password)
	{
		$errors = [];

		if (empty($login))
		{
			$errors[] = 'Введите логин';
		}
		if (empty($password))
		{
			$errors[] = 'Введите пароль';
		}

		global $USER;
		if (!is_object($USER))
		{
			$USER = new \CUser();
		}

		if(!$errors)
		{
			$errorMessage = $USER->Login($login, $password, "Y");

			if (is_bool($errorMessage) && $errorMessage)
			{
				$userId = $USER->GetID();
				$role = User::getRole($userId);

				LocalRedirect('/'.$role.'/'.$USER->GetID().'/');
			}
			else
			{
				$errors[] = $errorMessage['MESSAGE'];
			}
		}
		\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
		LocalRedirect('/sign-in');
	}

	public function signUpUserAction($login, $password, $firstname, $lastname, $email, $role)
	{
		if (empty($role))
		{
			$errors[] = 'Укажите роль: заказчик или исполнитель';
		}
		if (strlen($firstname) > 20 || strlen($lastname) > 20)
		{
			$errors[] = 'Имя и фамилия не могут быть длиннее 20 символов.';
		}

		$result = User::registerUser($login, $firstname, $lastname, $password, $email, $role);
		if (is_numeric($result))
		{
			$userId = $result;
			$passwordHash = password_hash($password, PASSWORD_DEFAULT);

			$user = new EO_User();
			$user->setId($userId)
				 ->setEmail($email)
				 ->setHash($passwordHash)
				 ->setName($firstname)
				 ->setSurname($lastname)
				 ->setRole($role);
			$user->save();
		}
		else
		{
			foreach (explode('<br>', $result) as $error)
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
			LocalRedirect('/sign-up');
		}
		else
		{
			self::getRole($role, $userId);
		}

	}

	public static function getRole($role, $userId)
	{
		if ($role === 'client')
		{
			LocalRedirect('/client/'.$userId.'/');
		}
		if ($role === 'contractor')
		{
			LocalRedirect('/contractor/'.$userId.'/');
		}
	}

	public function changePasswordAction($oldPassword, $newPassword, $confirmPassword)
	{
		global $USER;
		$errors = [];
		if (empty($oldPassword))
		{
			$errors[] = 'Введите старый пароль';
		}
		if (empty($newPassword))
		{
			$errors[] = 'Введите новый пароль';
		}
		if (empty($confirmPassword))
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
					if (!$result)
					{
						$errors[] = $user->LAST_ERROR;
					}
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
		\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
		LocalRedirect('/client/'.$USER->GetID().'/');
	}

	public static function logOutAction()
	{
		global $USER;
		$USER->Logout();
		LocalRedirect('/sign-in');
	}
}