CREATE TABLE IF NOT EXISTS `up_ukan_user`
(
	`ID`                    int              NOT NULL,
	`BIO`                   text,
	`SUBSCRIPTION_END_DATE` date,
	`UPDATED_AT`            datetime,
	`CONTACTS`              text             NOT NULL,
	`IS_BANNED`             char default 'N' not null,
	`PHONE_NUMBER`          VARCHAR(32)      null,
	PRIMARY KEY (`ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_feedback`
(
	`ID`           int AUTO_INCREMENT NOT NULL,
	`RATING`       int                NOT NULL,
	`FROM_USER_ID` int                NOT NULL,
	`TO_USER_ID`   int                NOT NULL,
	`TASK_ID`      int                NOT NULL,
	`COMMENT`     text,
	`CREATED_AT`   datetime,
	`IS_BANNED`    char default 'N'   not null,
	`TO_USER_ROLE` varchar(31)        not null,
	PRIMARY KEY (
	             `ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_tag`
(
	`ID`         int AUTO_INCREMENT NOT NULL,
	`TITLE`      varchar(255)       NOT NULL,
	`USER_ID`    INT                NOT NULL,
	`CREATED_AT` datetime           NOT NULL,
	`IS_BANNED`  char default 'N'   not null,
	PRIMARY KEY (
	             `ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_tag_task`
(
	`TASK_ID` int NOT NULL,
	`TAG_ID`  int NOT NULL,
	PRIMARY KEY (
	             `TASK_ID`, `TAG_ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_task`
(
	`ID`               int AUTO_INCREMENT NOT NULL,
	`TITLE`            varchar(255)       NOT NULL,
	`DESCRIPTION`      text               NOT NULL,
	`MAX_PRICE`        int,
	`CLIENT_ID`        int                NOT NULL,
	`CONTRACTOR_ID`    int,
	`STATUS`           varchar(255)       NOT NULL,
	`PROJECT_STAGE_ID` int,
	`CREATED_AT`       datetime,
	`UPDATED_AT`       datetime,
	DEADLINE           DATE               null,
	`CATEGORY_ID`      int,
	`IS_BANNED`        char default 'N'   not null,
	PRIMARY KEY (
	             `ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_response`
(
	`ID`            int AUTO_INCREMENT NOT NULL,
	`TASK_ID`       int                NOT NULL,
	`CONTRACTOR_ID` int                NOT NULL,
	`PRICE`         int                NOT NULL,
	`DESCRIPTION`   text,
	`CREATED_AT`    datetime,
	`UPDATED_AT`    datetime,
	`STATUS`        varchar(255)       not null,
	PRIMARY KEY (
	             `ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_project`
(
	`ID`          int AUTO_INCREMENT NOT NULL,
	`TITLE`       varchar(255)       NOT NULL,
	`DESCRIPTION` text               NOT NULL,
	`CLIENT_ID`   int                NOT NULL,
	`CREATED_AT`  datetime,
	`UPDATED_AT`  datetime,
	STATUS        varchar(255)       not null,
	PRIMARY KEY (
	             `ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_user_subscription`
(
	`ID`         int AUTO_INCREMENT NOT NULL,
	`USER_ID`    int                NOT NULL,
	`PAYMENT_AT` datetime           NOT NULL,
	`PRICE`      int                NOT NULL,
	`START_DATE` date               NOT NULL,
	`END_DATE`   date               NOT NULL,
	PRIMARY KEY (
	             `ID`
		)
);

CREATE TABLE IF NOT EXISTS up_ukan_notification
(
	`ID`           int          not null auto_increment,
	`MESSAGE`      varchar(255) not null,
	`FROM_USER_ID` int          not null,
	`TO_USER_ID`   int          not null,
	`TASK_ID`      int,
	`CREATED_AT`   datetime     not null,
	PRIMARY KEY (
	             `ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_categories`
(
	`ID`    int AUTO_INCREMENT NOT NULL,
	`TITLE` varchar(255)       NOT NULL,
	PRIMARY KEY (
	             `ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_reports`
(
	`ID`           int AUTO_INCREMENT NOT NULL,
	`TYPE`         varchar(255)       NOT NULL,
	`MESSAGE`      text,
	`FROM_USER_ID` int                not null,
	`TO_USER_ID`   int                not null,
	`TASK_ID`      int,
	`FEEDBACK_ID`  int,
	PRIMARY KEY (
	             `ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_project_stage`
(
	`ID`                       int auto_increment,
	`PROJECT_ID`             int          not null,
	`STATUS`                   varchar(255) not null,
	`NUMBER`                 int          not null,
	`EXPECTED_COMPLETION_DATE` date         null,
	PRIMARY KEY (
	             `ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_secret_option_site`
(
	`ID`    int          not null auto_increment,
	`NAME`  varchar(255) not null,
	`VALUE` varchar(255) not null,
	PRIMARY KEY (
	             `ID`
		)
);

-- Заполнение таблицы up_ukan_categories
INSERT INTO up_ukan_categories (TITLE)
VALUES ('Другое');