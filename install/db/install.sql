CREATE TABLE IF NOT EXISTS `up_ukan_user`
(
	`ID`                    int AUTO_INCREMENT NOT NULL,
	`EMAIL`                 varchar(255)       NOT NULL,
	`LOGIN`                 varchar(255)       NOT NULL,
	`HASH`                  varchar(255)       NOT NULL,
	`NAME`                  varchar(255)       NOT NULL,
	`SURNAME`               varchar(255)       NOT NULL,
	`BIO`                   text,
	`SUBSCRIPTION_END_DATE` date,
	`CREATED_AT`            datetime,
	`UPDATED_AT`            datetime,
    PRIMARY KEY (
                 `ID`
        ),
    CONSTRAINT `uc_up_ukan_user_LOGIN` UNIQUE (
	                                           `LOGIN`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_feedback`
(
	`ID`           int AUTO_INCREMENT NOT NULL,
	`RATING`       int                NOT NULL,
	`FROM_USER_ID` int                NOT NULL,
	`TO_USER_ID`   int                NOT NULL,
	`TASK_ID`      int                NOT NULL,
	`FEEDBACK`     text,
	`CREATED_AT`   datetime,
	PRIMARY KEY (
	             `ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_tag`
(
	`ID`    int AUTO_INCREMENT NOT NULL,
	`TITLE` varchar(255)       NOT NULL,
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
	`ID`            int AUTO_INCREMENT NOT NULL,
	`TITLE`         varchar(255)       NOT NULL,
	`DESCRIPTION`   text               NOT NULL,
	`MAX_PRICE`     int,
	`PROJECT_PRIORITY`      int                NOT NULL,
	`CLIENT_ID`     int                NOT NULL,
	`CONTRACTOR_ID` int,
	`STATUS_ID`     int                NOT NULL,
	`PROJECT_ID`    int,
	`CREATED_AT`    datetime,
	`UPDATED_AT`    datetime,
	PRIMARY KEY (
	             `ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_status`
(
	`ID`    int AUTO_INCREMENT NOT NULL,
	`TITLE` varchar(255)       NOT NULL,
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
	PRIMARY KEY (
	             `ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_subscription`
(
	`ID`          int AUTO_INCREMENT NOT NULL,
	`TITLE`       varchar(255)       NOT NULL,
	`DESCRIPTION` text               NOT NULL,
	`PRICE`       int                NOT NULL,
	PRIMARY KEY (
	             `ID`
		)
);

CREATE TABLE IF NOT EXISTS `up_ukan_user_subscription`
(
	`ID`              int AUTO_INCREMENT NOT NULL,
	`USER_ID`         int                NOT NULL,
	`SUBSCRIPTION_ID` int                NOT NULL,
	`PAYMENT_AT`      datetime           NOT NULL,
	`PRICE`           int                NOT NULL,
	`START_DATE`      date               NOT NULL,
	`END_DATE`        date               NOT NULL,
	PRIMARY KEY (
	             `ID`
		)
);

INSERT INTO up_ukan_status (TITLE)
	VALUE ('Новая');