<?php

namespace Up\Ukan\Service;

use Up\Ukan\Repository\User;

class Validation
{
	public static function validateUserTextFields(
		string $userName,
		string $userSurname,
		string $userLogin,
		string $userEmail
	): ?array
	{
		$error = [];
		if (empty(trim($userName)) || empty(trim($userSurname)) ||empty(trim($userLogin)) ||  empty(trim($userEmail)))
		{
			$error[] = 'Пожалуйста, заполните все необходимые поля';
		}
		if (preg_match('/[^\w_-]/u', $userLogin) || preg_match('/[^\w_-]/u', $userName) || preg_match('/[^\w_-]/u', $userSurname))
		{
			$error[] = 'Логин, Имя и Фамилия не могут содержать спец.символы и пробелы';
		}
		return $error;
	}

	public static function validateUserPassword(
		string $userPassword
	): ?array
	{
		$error = [];
		if (empty(trim($userPassword)) || strlen($userPassword) < 8 || !preg_match('/[0-9]/', $userPassword) || !preg_match('/[a-zA-Z]/', $userPassword))
		{
			$error[] = 'Пароль должен содержать минимум 8 символов, цифры и прописные латинские буквы';
		}
		return $error;
	}

	public static function validateUserEmail(
		string $userEmail
	): ?array
	{
		$error = [];
		if (!filter_var($userEmail, FILTER_VALIDATE_EMAIL))
		{
			$error[] =  'Почта указана в некорректном формате';
		}
		if (User::checkUniqueFieldsExist('EMAIL', $userEmail) === false)
		{
			$error[] = 'Пользователь с такой почтой уже существует';
		}
		return $error;
	}
	public static function checkLoginExists(
		string $userLogin
	): ?array
	{
		$error = [];
		if (mb_strlen ($userLogin) < 3)
		{
			$error[] = 'Логин должен быть длиннее 3х символов';
		}
		if (User::checkUniqueFieldsExist('LOGIN', $userLogin) === false)
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
		$errors = array_merge($errors, self::validateUserTextFields($userLogin, $userName, $userSurname, $userEmail));
		$errors = array_merge($errors, self::validateUserPassword($userPassword));

		if (!empty($errors))
		{
			return $errors;
		}

		return null;
	}
}