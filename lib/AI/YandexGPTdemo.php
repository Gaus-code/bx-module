<?php

namespace Up\Ukan\AI;

use Bitrix\Main\Web\HttpClient;

class YandexGPTdemo
{
	public static function getResponse($str = "")
	{
		$httpClient = new HttpClient();
		$httpClient->setHeader('Content-Type', 'application/json', true);
		$httpClient->setHeader('Authorization', 'Api-Key AQVNztg5AhOJG_qdivT_LWgRQADPQkfjCwyY2tbP', true);
		$url = "https://llm.api.cloud.yandex.net/foundationModels/v1/completion";

		$requestBody = [
			"modelUri" => "gpt://b1gjdsgd12d0ee2e41in/yandexgpt-lite",
			"completionOptions" => [
				"stream" => false,
				"temperature" => 0.6,
				"maxTokens" => "2000"
			],
			"messages" => [
				[
					"role" => "system",
					"text" => "Ты ассистент дроид, способный помочь в галактических приключениях."
				],
				[
					"role" => "user",
					"text" => "Привет, Дроид! Мне нужна твоя помощь, чтобы узнать больше о Силе. Как я могу научиться ее использовать?"
				],
				[
					"role" => "assistant",
					"text" => "Привет! Чтобы овладеть Силой, тебе нужно понять ее природу. Сила находится вокруг нас и соединяет всю галактику. Начнем с основ медитации."
				],
				[
					"role" => "user",
					"text" => "Хорошо, а как насчет строения светового меча? Это важная часть тренировки джедая. Как мне создать его?"
				]
			]
		];

		$response = $httpClient->post($url, json_encode($requestBody));

		return $response;
	}

}