<?php

namespace Up\Ukan\AI;

use Bitrix\Main\Web\HttpClient;
use Up\Ukan\Model\SecretOptionSiteTable;
use Up\Ukan\Model\TagTable;
use Up\Ukan\Service\Configuration;

class YandexGPT implements GPT
{
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

	public static function getMessageTextFromResponse(array $response): string
	{
		return $response['result']['alternatives'][0]['message']['text'];
	}
}