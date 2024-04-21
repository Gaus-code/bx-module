<?php
namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\Context;
use Bitrix\Main\Type\DateTime;
use Up\Ukan\Model\BUserTable;
use Up\Ukan\Model\EO_User;
use Up\Ukan\Repository\User;
use Up\Ukan\Service\Validation;

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

		global $USER;
		if (!is_object($USER))
		{
			$USER = new \CUser();
		}

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

		\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
		LocalRedirect('/sign-in');
	}

	/**
	 * @throws \Exception
	 */
	public function signUpUserAction($login, $password, $firstname, $lastname, $email)
	{
		$errors = Validation::getValidationErrors($login, $firstname, $lastname, $email, $password);

		if (!empty($errors))
		{
			\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
			LocalRedirect('/sign-up');
		}


		$result = User::registerUser($login, $firstname, $lastname, $password, $email);

		if (is_numeric($result))
		{
			$userId = $result;
			$this->setUserSession($userId);

			$user = new EO_User();

			$user->setId($userId)->setUpdatedAt(new \Bitrix\Main\Type\DateTime())->setContacts($email);

			$user->save();
		}
		else
		{
			LocalRedirect('/sign-up');
		}

		global $USER;
		LocalRedirect('/profile/'.$USER->GetID().'/');
	}

	public static function logOutAction()
	{
		global $USER;
		$USER->Logout();
		unset($_SESSION['USER_ID']);
		LocalRedirect('/sign-in');
	}
}