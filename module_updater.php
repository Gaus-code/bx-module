<?php

use Bitrix\Main\ModuleManager;
use Bitrix\Main\Config\Option;

function __ukanMigrate(int $nextVersion, callable $callback)
{
	global $DB;
	$moduleId = 'up.ukan';

	if (!ModuleManager::isModuleInstalled($moduleId))
	{
		return;
	}

	$currentVersion = intval(Option::get($moduleId, '~database_schema_version', 0));

	if ($currentVersion < $nextVersion)
	{
		include_once($_SERVER['DOCUMENT_ROOT'] . '/bitrix/modules/main/classes/general/update_class.php');
		$updater = new \CUpdater();
		$updater->Init('', 'mysql', '', '', $moduleId, 'DB');

		$callback($updater, $DB, 'mysql');
		Option::set($moduleId, '~database_schema_version', $nextVersion);
	}
}

__ukanMigrate(2, function($updater, $DB)
{
	if ($updater->CanUpdateDatabase() && !$updater->TableExists('up_ukan_user'))
	{
		$DB->query('CREATE TABLE IF NOT EXISTS up_ukan_user
		(
			`ID`         int          NOT NULL,
			`NAME`       varchar(100) NOT NULL,
			`ROLE_ID`     int          NOT NULL,
			`LOGIN`      varchar(100) NOT NULL,
			`HASH`       varchar(100) NOT NULL,
			`CREATED_AT` timestamp    NOT NULL,
			`UPDATED_AT` timestamp    NOT NULL,
			PRIMARY KEY (`ID`)
		);');
	}
});

__ukanMigrate(3, function($updater, $DB)
{
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_user'))
	{
//		$DB->query('ALTER TABLE up_ukan_user DROP COLUMN ROLE;');
//		$DB->query('ALTER TABLE up_ukan_user DROP CONSTRAINT uc_up_ukan_user_EMAIL;');
//		$DB->query('ALTER TABLE up_ukan_user ADD CONSTRAINT uc_up_ukan_user_LOGIN UNIQUE (LOGIN);');
	}
});

__ukanMigrate(4, function($updater, $DB)
{
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_user'))
	{
		$DB->query('drop table up_ukan_status;');
		$DB->query('alter table up_ukan_task
    change STATUS_ID STATUS varchar(255) not null;');
	}
});
