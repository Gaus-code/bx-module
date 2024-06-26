<?php

namespace Up\Ukan\AI\GPT;

interface GPT
{
	public static function getResponse(array $messages): array;
	public static function getMessageTextFromResponse(array $response): string;
}