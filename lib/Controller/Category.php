<?php

namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;
use Bitrix\Main\ORM\Query\Query;
use Up\Ukan\Model\CategoriesTable;
use Up\Ukan\Model\EO_Categories;
use Up\Ukan\Model\EO_Reports;
use Up\Ukan\Model\FeedbackTable;
use Up\Ukan\Model\TaskTable;
use Up\Ukan\Model\UserTable;

class Category extends Engine\Controller
{

	public function createAction(
		string $title = null,
	)
	{
		if (check_bitrix_sessid())
		{
			global $USER;
			if (!$USER->IsAdmin())
			{
				LocalRedirect('/access/denied/');
			}

			$errors = $this->validateTitle($title);

			$category = CategoriesTable::query()->setSelect(['ID'])->where('TITLE', $title)->fetchObject();
			if ($category)
			{
				$errors[] = 'Такая категория уже существует!';
			}

			if ($errors !== [])
			{
				\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
				LocalRedirect("/admin/categories/");
			}

			$category = new EO_Categories();
			$category->setTitle($title);
			$category->save();

			LocalRedirect("/admin/categories/");
		}
	}

	public function deleteAction(int $categoryId)
	{
		if (check_bitrix_sessid())
		{
			global $USER;
			if (!$USER->IsAdmin())
			{
				LocalRedirect('/access/denied/');
			}

			$category = CategoriesTable::getById($categoryId)->fetchObject();

			if (!$category)
			{
				LocalRedirect('/access/denied/');
			}

			if ($category->getTitle() !== 'Без категории')
			{
				CategoriesTable::delete($categoryId);

				LocalRedirect("/admin/categories/");
			}

		}
		LocalRedirect('/access/denied/');
	}

	private function validateTitle(string $title):array
	{
		$errors = [] ;

		if (!$title)
		{
			$errors [] = 'Название категории не может быть пустым';
		}
		else
		{
			if (mb_strlen($title) < 3 || mb_strlen($title) > 255)
			{
				$errors[] = 'Название должно быть от 3 до 255 символов';
			}
			// Разрешаем буквы (русские и латинские), цифры и пробелы
			if (!preg_match('/^[a-zA-Zа-яА-Я0-9\s]+$/u', $title))
			{
				$errors[] = 'Название может содержать только буквы, цифры и пробелы';
			}
		}

		return $errors;
	}


}