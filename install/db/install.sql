CREATE TABLE IF NOT EXISTS up_ukan_user
(
	`ID`         int          NOT NULL,
	`NAME`       varchar(100) NOT NULL,
	`ROLE_ID`     int          NOT NULL,
	`LOGIN`      varchar(100) NOT NULL,
	`HASH`       varchar(100) NOT NULL,
	`CREATED_AT` timestamp    NOT NULL,
	`UPDATED_AT` timestamp    NOT NULL,
	PRIMARY KEY (`ID`)
);