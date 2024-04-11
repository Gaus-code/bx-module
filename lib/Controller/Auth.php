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
			'signIn' => [
				'-prefilters' => [
					Engine\ActionFilter\Authentication::class,
				],
			],
			'signUpUser' => [
				'-prefilters' => [
					Engine\ActionFilter\Authentication::class,
				],
			],
		];
	}

	protected function setUserSession($userId)
	{
		$session = \Bitrix\Main\Application::getInstance()->getSession();
		if (!$session->has('USER_ID'))
		{
			$session->set('USER_ID', $userId);
		}
	}
	public function signInAction($login, $password)
	{
		$errors = [];

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
				$this->setUserSession($userId);

				LocalRedirect('/profile/'.$userId.'/');
			}
			else
			{
				$errors[] = $errorMessage['MESSAGE'];
			}
		}
		\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
		LocalRedirect('/sign-in');
	}

	public function signUpUserAction($login, $password, $firstname, $lastname, $email)
	{
		$errors = [];

		if (empty(trim($login)) || empty(trim($firstname)) || empty(trim($lastname)) || empty(trim($email)) || empty(trim($password)))
		{
			$errors[] = 'Пожалуйста, заполните все поля корректно';
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/sign-up');
		}

		$result = User::registerUser($login, $firstname, $lastname, $password, $email);
		if (is_numeric($result))
		{
			$userId = $result;
			$passwordHash = password_hash($password, PASSWORD_DEFAULT);
			$this->setUserSession($userId);

			$user = new EO_User();
			$user->setId($userId)
				 ->setEmail($email)
				 ->setHash($passwordHash)
				 ->setName($firstname)
				 ->setSurname($lastname)
				 ->setRole('user');
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
			global $USER;
			LocalRedirect('/profile/'.$USER->GetID().'/');
		}

	}

	public static function logOutAction()
	{
		global $USER;
		$USER->Logout();
		unset($_SESSION['USER_ID']);
		LocalRedirect('/sign-in');
	}
}