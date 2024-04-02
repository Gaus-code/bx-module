CREATE TABLE IF NOT EXISTS `up_ukan_user`
(
	`ID`         int AUTO_INCREMENT NOT NULL,
	`EMAIL`      varchar(255)       NOT NULL,
	`HASH`       varchar(255)       NOT NULL,
	`NAME`       varchar(255)       NOT NULL,
	`SURNAME`    varchar(255)       NOT NULL,
	`ROLE`       varchar(255)       NOT NULL,
	`BIO`        text,
	`CREATED_AT` timestamp          NOT NULL,
	`UPDATED_AT` timestamp          NOT NULL,
	PRIMARY KEY (
	             `ID`
		),
	CONSTRAINT `uc_up_ukan_user_EMAIL` UNIQUE (
	                                           `EMAIL`
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
	`CREATED_AT`   timestamp          NOT NULL,
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
	`PRIORITY`      int                NOT NULL,
	`CLIENT_ID`     int                NOT NULL,
	`CONTRACTOR_ID` int,
	`STATUS_ID`     int                NOT NULL,
	`PROJECT_ID`    int,
	`CREATED_AT`    timestamp          NOT NULL,
	`UPDATED_AT`    timestamp          NOT NULL,
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
	`CREATED_AT`    timestamp          NOT NULL,
	`UPDATED_AT`    timestamp          NOT NULL,
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
	`CREATED_AT`  timestamp          NOT NULL,
	`UPDATED_AT`  timestamp          NOT NULL,
	PRIMARY KEY (
	             `ID`
		)
);

ALTER TABLE `up_ukan_feedback`
	ADD CONSTRAINT `fk_up_ukan_feedback_FROM_USER_ID` FOREIGN KEY (`FROM_USER_ID`)
		REFERENCES `up_ukan_user` (`ID`);

ALTER TABLE `up_ukan_feedback`
	ADD CONSTRAINT `fk_up_ukan_feedback_TO_USER_ID` FOREIGN KEY (`TO_USER_ID`)
		REFERENCES `up_ukan_user` (`ID`);

ALTER TABLE `up_ukan_feedback`
	ADD CONSTRAINT `fk_up_ukan_feedback_TASK_ID` FOREIGN KEY (`TASK_ID`)
		REFERENCES `up_ukan_task` (`ID`);

ALTER TABLE `up_ukan_tag_task`
	ADD CONSTRAINT `fk_up_ukan_tag_task_TASK_ID` FOREIGN KEY (`TASK_ID`)
		REFERENCES `up_ukan_task` (`ID`);

ALTER TABLE `up_ukan_tag_task`
	ADD CONSTRAINT `fk_up_ukan_tag_task_TAG_ID` FOREIGN KEY (`TAG_ID`)
		REFERENCES `up_ukan_tag` (`ID`);

ALTER TABLE `up_ukan_task`
	ADD CONSTRAINT `fk_up_ukan_task_CLIENT_ID` FOREIGN KEY (`CLIENT_ID`)
		REFERENCES `up_ukan_user` (`ID`);

ALTER TABLE `up_ukan_task`
	ADD CONSTRAINT `fk_up_ukan_task_STATUS_ID` FOREIGN KEY (`STATUS_ID`)
		REFERENCES `up_ukan_status` (`ID`);

ALTER TABLE `up_ukan_task`
	ADD CONSTRAINT `fk_up_ukan_task_PROJECT_ID` FOREIGN KEY (`PROJECT_ID`)
		REFERENCES `up_ukan_project` (`ID`);

ALTER TABLE `up_ukan_response`
	ADD CONSTRAINT `fk_up_ukan_response_TASK_ID` FOREIGN KEY (`TASK_ID`)
		REFERENCES `up_ukan_task` (`ID`);

ALTER TABLE `up_ukan_response`
	ADD CONSTRAINT `fk_up_ukan_response_CONTRACTOR_ID` FOREIGN KEY (`CONTRACTOR_ID`)
		REFERENCES `up_ukan_user` (`ID`);

ALTER TABLE `up_ukan_project`
	ADD CONSTRAINT `fk_up_ukan_project_CLIENT_ID` FOREIGN KEY (`CLIENT_ID`)
		REFERENCES `up_ukan_user` (`ID`);

ALTER TABLE `up_ukan_task`
	ADD CONSTRAINT `fk_up_ukan_task_CONTRACTOR_ID` FOREIGN KEY (`CONTRACTOR_ID`)
		REFERENCES `up_ukan_user` (`ID`);
