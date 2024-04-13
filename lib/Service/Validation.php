<?php

namespace Up\Ukan\Service;

use Up\Ukan\Repository\User;

class Validation
{
	public static function validateInputMinLength(
		string $userLogin,
		string $userName,
		string $userSurname,
		string $userEmail,
		string $userPassword
	): ?array
	{
		$error = [];
		if (empty(trim($userLogin)) || empty(trim($userName)) || empty(trim($userSurname)) || empty(trim($userEmail)) || empty(trim($userPassword)))
		{
			$error[] = 'Пожалуйста, заполните все необхожимые поля';
		}
		return $error;
	}

	public static function validateUserEmail(string $userEmail): ?array
	{
		$error = [];
		if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL))
		{
			$error[] =  'Почта указана в некорректном формате';
		}
		return $error;
	}
	public static function checkLoginExists( string $userLogin): ?array
	{
		$error = [];
		if (User::checkLoginExists($userLogin) === false)
		{
			$error[] = 'Пользователь с таким логином уже существует';
		}
		return $error;
	}

	public static function getValidationErrors(
		string $userLogin,
		string $userName,
		string $userSurname,
		string $userEmail,
		string $userPassword
	): ?array
	{
		$errors = [];

		$errors = array_merge($errors, self::checkLoginExists($userLogin));
		$errors = array_merge($errors, self::validateUserEmail($userEmail));
		$errors = array_merge($errors, self::validateInputMinLength($userLogin, $userName, $userSurname, $userEmail, $userPassword));

		if (!empty($errors))
		{
			return $errors;
		}

		return null;
	}
}