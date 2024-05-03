<?php
namespace Up\Ukan\Repository;

use Bitrix\Main\FileTable;

class File
{
	public const ACCEPTED_IMAGE_TYPES = [
		'image/',
	];
	public const MAX_IMAGE_SIZE = 10 * 1024 * 1024;

	public static function saveUserImage(
		int $userId,
		$file
	)
	{
		return \CFile::SaveFile(
			$file,
			"user-photos/{$userId}",
			'',
			'',
			'',
			false
		);
	}

	public static function deleteFile($id)
	{
		$file = \CFile::GetByID($id);
		if ($file)
		{
			\Bitrix\Main\IO\Directory::deleteDirectory(\Bitrix\Main\Application::getDocumentRoot() . '/upload/' . $file->arResult[0]['SUBDIR']);
			\CFile::delete($id);
		}
	}
}