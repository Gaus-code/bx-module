<?php

namespace Up\Ukan\AI;

use Bitrix\Main\Web\HttpClient;
use Up\Ukan\Model\SecretOptionSiteTable;
use Up\Ukan\Model\TagTable;
use Up\Ukan\Service\Configuration;

class YandexGPT
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
	public static function getTagsByTaskDescription(string $taskDescription)
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

	public static function getResponse(array $messages): array
	{
		$optionsResult = SecretOptionSiteTable::query()->setSelect(['ID', 'NAME', 'VALUE'])
										->whereIn('NAME', ['secret_key', 'directory_id'])
										->fetchAll();
		foreach ($optionsResult as $row)
		{
			$options[$row['NAME']]=$row['VALUE'];
		}
		var_dump($options);

		$httpClient = new HttpClient();
		$httpClient->setHeader('Content-Type', 'application/json', true);
		$httpClient->setHeader('Authorization', 'Api-Key ' . $options['secret_key'], true);
		$url = "https://llm.api.cloud.yandex.net/foundationModels/v1/completion";

		$requestBody = [
			"modelUri" => "gpt://" . $options['directory_id'] . "/yandexgpt",
			"completionOptions" => [
				"stream" => false,
				"temperature" => 0,
				"maxTokens" => "2000",
			],
			"messages" => $messages,
		];

		return json_decode($httpClient->post($url, json_encode($requestBody)), true);
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

	private static function getMessageTextFromResponse(array $response): string
	{
		return $response['result']['alternatives'][0]['message']['text'];
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