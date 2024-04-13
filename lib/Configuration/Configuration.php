<?php

namespace Up\Ukan\Configuration;

class Configuration
{
	private static array $config = [];
	private static ?Configuration $instance = null;

	private function __construct()
	{
		if (!file_exists($_SERVER['DOCUMENT_ROOT'] . '/local/modules/up.ukan/config.php'))
		{
			throw new \RuntimeException("local config not found");
		}

		$config = require $_SERVER['DOCUMENT_ROOT'] . '/local/modules/up.ukan/config.php';

		self::$config = $config;
	}

	public function option(string $name, $defaultValue = null)
	{
		if (array_key_exists($name, static::$config))
		{
			return static::$config[$name];
		}

		if ($defaultValue !== null)
		{
			return $defaultValue;
		}

		throw new \RuntimeException("Configuration option {$name} not found");
	}

	public static function getInstance(): Configuration
	{
		if (static::$instance)
		{
			return static::$instance;
		}

		static::$instance = new self();

		return static::$instance;
	}
}