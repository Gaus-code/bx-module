DROP TABLE IF EXISTS `up_ukan_user`;

DROP TABLE IF EXISTS `up_ukan_feedback` ;

DROP TABLE IF EXISTS `up_ukan_tag`;

DROP TABLE IF EXISTS `up_ukan_tag_task`;

DROP TABLE IF EXISTS `up_ukan_task`;

DROP TABLE IF EXISTS `up_ukan_response`;

DROP TABLE IF EXISTS `up_ukan_project`;

DROP TABLE IF EXISTS `up_ukan_user_subscription`;

DROP TABLE IF EXISTS `up_ukan_notification`;

DROP TABLE IF EXISTS `up_ukan_categories`;

DROP TABLE IF EXISTS `up_ukan_reports`;

DROP TABLE IF EXISTS `up_ukan_project_stage`;

DROP TABLE IF EXISTS `up_ukan_secret_option_site`;

DELETE FROM b_user where WORK_COMPANY = 'UKAN';