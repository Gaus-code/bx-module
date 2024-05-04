<?php

use Bitrix\Main\Config\Option;
use Bitrix\Main\ModuleManager;

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

__ukanMigrate(2, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && !$updater->TableExists('up_ukan_user'))
	{
		$DB->query(
			'CREATE TABLE IF NOT EXISTS up_ukan_user
		(
			`ID`         int          NOT NULL,
			`NAME`       varchar(100) NOT NULL,
			`ROLE_ID`     int          NOT NULL,
			`LOGIN`      varchar(100) NOT NULL,
			`HASH`       varchar(100) NOT NULL,
			`CREATED_AT` timestamp    NOT NULL,
			`UPDATED_AT` timestamp    NOT NULL,
			PRIMARY KEY (`ID`)
		);'
		);
	}
});

__ukanMigrate(3, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_user'))
	{
		$DB->query('ALTER TABLE up_ukan_user DROP COLUMN ROLE;');
		$DB->query('ALTER TABLE up_ukan_user DROP CONSTRAINT uc_up_ukan_user_EMAIL;');
		$DB->query('ALTER TABLE up_ukan_user ADD CONSTRAINT uc_up_ukan_user_LOGIN UNIQUE (LOGIN);');
	}
});

__ukanMigrate(4, function($updater, $DB) {
	if (
		$updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_task')
		&& $updater->TableExists(
			'up_ukan_status'
		)
	)
	{
		$DB->query('drop table up_ukan_status;');
		$DB->query(
			'alter table up_ukan_task
    change STATUS_ID STATUS varchar(255) not null;'
		);
	}
});

__ukanMigrate(5, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_user'))
	{
		$DB->query('ALTER TABLE up_ukan_user DROP COLUMN B_USER_ID;');
	}
});

__ukanMigrate(6, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && !$updater->TableExists('up_ukan_notification'))
	{
		$DB->query(
			'CREATE TABLE IF NOT EXISTS up_ukan_notification
					(
						ID           int          not null auto_increment,
						MESSAGE         varchar(255) not null,
						FROM_USER_ID int          not null,
						TO_USER_ID   int          not null,
						TASK_ID      int          not null,
						CREATED_AT   datetime     not null,
						PRIMARY KEY (
									 `ID`
							)
					);'
		);
	}
});

__ukanMigrate(7, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_response'))
	{
		$DB->query(
			'ALTER TABLE up_ukan_response
					ADD COLUMN STATUS varchar(255) not null;'
		);
	}
});

__ukanMigrate(8, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_user'))
	{
		$DB->query('ALTER TABLE up_ukan_user ADD COLUMN CONTACTS text not null;');
	}

});

__ukanMigrate(9, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_feedback'))
	{
		$DB->query(
			'alter table up_ukan_feedback
    change FEEDBACK COMMENT text null;'
		);
	};

});

__ukanMigrate(10, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_user'))
	{
		$DB->query(
			'alter table up_ukan_user
    add RATING FLOAT not null;'
		);

		$DB->query(
			'alter table up_ukan_user
    add FEEDBACK_COUNT int not null;'
		);
	};

});

__ukanMigrate(11, function($updater, $DB) {
	if (
		$updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_task')
		&& !$updater->TableExists(
			'up_ukan_project_stage'
		)
	)
	{
		$DB->query(
			'create table up_ukan_project_stage
(
	ID         int auto_increment,
    PROJECT_ID int          not null,
    STATUS     VARCHAR(255) not null,
    NUMBER     int          not null,
    constraint up_ukan_project_stage_pk
        primary key (ID)
);'
		);
		$DB->query(
			'alter table up_ukan_task
    change PROJECT_ID PROJECT_STAGE_ID int null;'
		);
	};
});

__ukanMigrate(12, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_task'))
	{
		$DB->query(
			'alter table up_ukan_task
    drop column PROJECT_PRIORITY;'
		);

		$DB->query(
			'alter table up_ukan_task
    add DEADLINE DATE null;'
		);
	};
});

__ukanMigrate(13, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_project_stage'))
	{
		$DB->query(
			'alter table up_ukan_project_stage
    add EXPECTED_COMPLETION_DATE DATE null;'
		);
	};

});

__ukanMigrate(14, function($updater, $DB) {
	if (
		$updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_tag')
		&& !$updater->TableExists(
			'up_ukan_categories'
		)
	)
	{
		$DB->query(
			'ALTER TABLE `up_ukan_tag`
	ADD COLUMN `USER_ID`    int      not null,
	ADD COLUMN `CREATED_AT` datetime not null;'
		);

		$DB->query(
			'CREATE TABLE IF NOT EXISTS `up_ukan_categories`
(
	`ID`    int AUTO_INCREMENT NOT NULL,
	`TITLE` varchar(255)       NOT NULL,
	PRIMARY KEY (
	             `ID`
		)
);'
		);

		$DB->query(
			'ALTER TABLE `up_ukan_task`
	ADD COLUMN `CATEGORY_ID`    int;'
		);

	};

});

__ukanMigrate(15, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && !$updater->TableExists('up_ukan_reports'))
	{
		$DB->query(
			'CREATE TABLE IF NOT EXISTS `up_ukan_reports`
			(
				`ID`             int AUTO_INCREMENT NOT NULL,
				`TYPE`           varchar(255)       NOT NULL,
				`MESSAGE`        text,
				`FROM_USER_ID`   int                not null,
				`TO_USER_ID`     int                not null,
				`TO_TASK_ID`     int,
				`TO_FEEDBACK_ID` int,
				PRIMARY KEY (
							 `ID`
					)
			);'
		);
	};

});

__ukanMigrate(16, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_reports'))
	{
		$DB->query(
			'ALTER TABLE `up_ukan_reports`
			CHANGE COLUMN `TO_TASK_ID` `TASK_ID` INT,
			CHANGE COLUMN `TO_FEEDBACK_ID` `FEEDBACK_ID` INT,
			ADD COLUMN `TAG_ID` INT,
			ADD COLUMN `IS_BANNED` BOOLEAN;'
		);
	}
});

__ukanMigrate(17, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && !$updater->TableExists('up_ukan_task'))
	{
		$DB->query(
			"UPDATE `up_ukan_task`
SET STATUS = 'Поиск исполнителя'
WHERE STATUS = 'Новая';"
		);
	};

});

__ukanMigrate(18, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_categories'))
	{
		$DB->query(
			"INSERT INTO up_ukan_categories (TITLE)
SELECT 'Без категории'
FROM dual
WHERE NOT EXISTS (
	SELECT 1
	FROM up_ukan_categories
	WHERE TITLE = 'Без категории'
);"
		);
	};

});

__ukanMigrate(19, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_reports'))
	{
		$DB->query(
			'ALTER TABLE `up_ukan_reports`
			DROP COLUMN `TAG_ID`,
			DROP COLUMN `IS_BANNED`;'
		);
	}
});

__ukanMigrate(20, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_task'))
	{
		$DB->query(
			"ALTER TABLE `up_ukan_task`
			ADD COLUMN `IS_BANNED` char default 'N' not null"
		);
	}
});

__ukanMigrate(21, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_user'))
	{
		$DB->query(
			"ALTER TABLE `up_ukan_user`
			ADD COLUMN `IS_BANNED` char default 'N' not null"
		);
	}
});

__ukanMigrate(22, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_tag'))
	{
		$DB->query(
			"ALTER TABLE `up_ukan_tag`
			ADD COLUMN `IS_BANNED` char default 'N' not null"
		);
	}
});

__ukanMigrate(23, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_feedback'))
	{
		$DB->query(
			"ALTER TABLE `up_ukan_feedback`
			ADD COLUMN `IS_BANNED` char default 'N' not null"
		);
	}
});

__ukanMigrate(24, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_notification'))
	{
		$DB->query(
			"ALTER TABLE `up_ukan_notification`
	MODIFY COLUMN `TASK_ID` int;"
		);
	}
});

__ukanMigrate(25, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_project'))
	{
		$DB->query(
			"alter table up_ukan_project
    add STATUS VARCHAR(255) not null;"
		);
	}
});

__ukanMigrate(26, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_categories'))
	{
		$DB->query(
			"UPDATE up_ukan_categories
SET TITLE = 'Другое'
WHERE TITLE = 'Без категории';"
		);
	}
});

__ukanMigrate(27, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && !$updater->TableExists('up_ukan_secret_option'))
	{
		$DB->query(
			"create table if not exists up_ukan_secret_option_site
(
	ID       int not null auto_increment,
	NAME    varchar(255) not null,
	VALUE    varchar(255) not null,
	PRIMARY KEY (
	             `ID`
		)
);"
		);
	}
});

__ukanMigrate(28, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_user'))
	{
		$DB->query(
			"alter table up_ukan_user
    drop column RATING;"
		);
	}
});

__ukanMigrate(29, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_user'))
	{
		$DB->query(
			"alter table up_ukan_user
    drop column FEEDBACK_COUNT;"
		);
	}
});

__ukanMigrate(30, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_user'))
	{
		$DB->query(
			"alter table up_ukan_user
    modify CONTACTS text null;"
		);
	}
});

__ukanMigrate(31, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_subscription'))
	{
		$DB->query(
			"drop table up_ukan_subscription;"
		);
	}
});

__ukanMigrate(32, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_user_subscription'))
	{
		$DB->query(
			"alter table up_ukan_user_subscription
    drop column SUBSCRIPTION_ID;"
		);
	}
});

__ukanMigrate(33, function($updater, $DB) {
	if ($updater->CanUpdateDatabase() && $updater->TableExists('up_ukan_feedback'))
	{
		$DB->query(
			"alter table up_ukan_feedback
    add TO_USER_ROLE VARCHAR(31) not null;"
		);
	}
});