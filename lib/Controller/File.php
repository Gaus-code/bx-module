<?php
namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;

class File extends Engine\Controller
{
	public static function deleteImageAction()
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}
		global $USER;
		$userId = $USER->GetID();
		$oldImageId = \Up\Ukan\Repository\User::getUserImageId($userId);
		if ($oldImageId)
		{
			\Up\Ukan\Repository\File::deleteFile($oldImageId);
			\Up\Ukan\Repository\User::deleteUserImage($userId);
		}
		LocalRedirect('/profile/' . $USER->GetID() . '/');
	}
	public static function changeImageAction(
		$files = null
	)
	{
		if (!check_bitrix_sessid())
		{
			LocalRedirect("/access/denied/");
		}

		global $USER;
		$userId = $USER->GetId();

		if (empty($files))
		{
			self::setErrorAndRedirect('Вы не выбрали файл', $userId);
		}

		$photo = $files[0];
		if (!$photo)
		{
			self::setErrorAndRedirect('Ошибка загрузки изображения', $userId);
		}

		$fileData = [
			"name" => $photo["name"],
			"size" => $photo["size"],
			"type" => $photo["type"],
			"tmp_name" => \Bitrix\Main\Application::getDocumentRoot() . '/upload/tmp' . $photo["tmp_name"],
			"MODULE_ID" => "up.ukan",
			"del" => "N"
		];

		$error = \CFile::CheckFile($fileData,
			\Up\Ukan\Repository\File::MAX_IMAGE_SIZE,
			\Up\Ukan\Repository\File::ACCEPTED_IMAGE_TYPES
		);
		if ($error)
		{
			self::setErrorAndRedirect('Некорректный тип изображения', $userId);

		}

		\CFile::ResizeImage(
			$fileData,
			[
				'width' => 300,
				'height' => 300
			],
			'BX_RESIZE_IMAGE_EXACT'
		);

		$fileId = \Up\Ukan\Repository\File::saveUserImage($userId, $fileData);
		if ($fileId)
		{
			self::updateUserImage($userId, $fileId);
		}
		LocalRedirect('/profile/' . $USER->GetID() . '/');
	}

	private static function setErrorAndRedirect(
		string $error,
		int $userId
	)
	{
		$errors = [$error];
		\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
		LocalRedirect('/profile/'. $userId. '/edit/');
	}

	private static function updateUserImage(
		int $userId,
		int $fileId
	)
	{
		$oldImageId = \Up\Ukan\Repository\User::getUserImageId($userId);
		if ($oldImageId)
		{
			\Up\Ukan\Repository\File::deleteFile($oldImageId);
			\Up\Ukan\Repository\User::deleteUserImage($userId);
		}
		\Up\Ukan\Repository\User::setUserImage($userId, $fileId);
	}
}