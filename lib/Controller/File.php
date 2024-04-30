<?php
namespace Up\Ukan\Controller;

use Bitrix\Main\Engine;

class File extends Engine\Controller
{
	public static function deleteImageAction()
	{
		if (check_bitrix_sessid())
		{
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
	}

	public static function changeImageAction(
		$files = null
	)
	{
		if (check_bitrix_sessid())
		{

			global $USER;

			if (empty($files))
			{
				$error = ['Вы не выбрали файл'];
				\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $error);
				LocalRedirect('/profile/'. $USER->GetID(). '/edit/');
			}
			$userId = $USER->GetId();

			$photo = $files[0];
			if (!$photo)
			{
				$error = ['Некорректный тип изображения'];
				\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $error);
				LocalRedirect('/profile/' . $USER->GetID(). '/edit/');
			}
			$arrFile = [
				"name" => $photo["name"],
				"size" => $photo["size"],
				"type" => $photo["type"],
				"tmp_name" => \Bitrix\Main\Application::getDocumentRoot() . '/upload/tmp' . $photo["tmp_name"],
				"MODULE_ID" => "up.ukan",
				"del" => "N"
			];
			$error = \CFile::CheckFile($arrFile,
				10 * 1024 * 1024,
				\Up\Ukan\Repository\File::ACCEPTED_IMAGE_TYPES
			);
			if ($error)
			{
				$errors = ['Ошибка загрузки изображения'];
				\Bitrix\Main\Application::getInstance()->getSession()->set('errors', $errors);
				LocalRedirect('/profile/' . $USER->GetID(). '/edit/');
			}
			\CFile::ResizeImage(
				$arrFile,
				[
					'width' => 300,
					'height' => 300
				],
				'BX_RESIZE_IMAGE_EXACT'
			);


			$fileId = \Up\Ukan\Repository\File::saveUserImage($userId, $arrFile);
			if ($fileId)
			{
				$oldImageId = \Up\Ukan\Repository\User::getUserImageId($userId);

				if ($oldImageId)
				{
					\Up\Ukan\Repository\File::deleteFile($oldImageId);
					\Up\Ukan\Repository\User::deleteUserImage($userId);
				}
				\Up\Ukan\Repository\User::setUserImage($userId, $fileId);
			}
			LocalRedirect('/profile/' . $USER->GetID() . '/');
		}
	}
}