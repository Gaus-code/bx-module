<?php

namespace Up\Ukan\AI;

use Up\Ukan\AI\YandexGPT;
use Up\Ukan\Model\TagTable;

class AI extends YandexGPT
{
	public static function censorshipCheck(string $text)
	{
		$messages = [
			[
				"role" => "system",
				"text" => "Далее ты получишь текст. 
				Его нужно проверить на цензуру. 
				Если текст проходит цензуру напиши  \"true\", иначе напиши \"false\".",
			],
			[
				"role" => "user",
				"text" => "Текст: \"{$text}\"",
			],
		];

		$response = self::getResponse($messages);
		$responseMessageText = self::getMessageTextFromResponse($response);

		return $responseMessageText === 'true';
	}
	public static function getTagsByTaskDescription(string $taskDescription): ?\Up\Ukan\Model\EO_Tag_Collection
	{

		$tagsListString = self::getTagsListStringFromDataBase();

		$messages = [
			[
				"role" => "system",
				"text" => "Далее ты получишь описание задачи. 
				Выбери подходящие теги из списка:\n{$tagsListString}.
				Если ни одна из категорий не подходит пиши напиши только '0'.
				В ответ напиши только номера тегов через запятую и ничего более.",
			],
			[
				"role" => "user",
				"text" => "Описание задачи: \"{$taskDescription}\"",
			],
		];

		$response = self::getResponse($messages);
		$responseMessageText = self::getMessageTextFromResponse($response);
		$tagCollection = self::getTagsListFromResponseMessage($responseMessageText);

		return $tagCollection;
	}

	private static function getTagsListStringFromDataBase(): string
	{
		$tagCollection = TagTable::query()->setSelect(['*'])
								 ->fetchCollection();

		foreach ($tagCollection as $tagObject)
		{
			$tags[$tagObject->getId()] = "{$tagObject->getId()}. {$tagObject->getTitle()}";
		}

		return implode(",\n", $tags);
	}
	private static function getTagsListFromResponseMessage(string $responseMessageText): ?\Up\Ukan\Model\EO_Tag_Collection
	{
		$tagIdsList = preg_replace('/[^0-9]/', ' ', $responseMessageText);
		$tagIdsList = explode(" ",trim($tagIdsList));

		$tagCollection = TagTable::query()->setSelect(['*'])
								 ->whereIn('ID', $tagIdsList)
								 ->fetchCollection();

		return $tagCollection;
	}

}