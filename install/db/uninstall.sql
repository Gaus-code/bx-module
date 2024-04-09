# alter table up_ukan_feedback
# 	drop foreign key fk_up_ukan_feedback_FROM_USER_ID;
#
# alter table up_ukan_feedback
# 	drop foreign key fk_up_ukan_feedback_TASK_ID;
#
# alter table up_ukan_feedback
# 	drop foreign key fk_up_ukan_feedback_TO_USER_ID;
#
# alter table up_ukan_project
# 	drop foreign key fk_up_ukan_project_CLIENT_ID;
#
# alter table up_ukan_response
# 	drop foreign key fk_up_ukan_response_CONTRACTOR_ID;
#
# alter table up_ukan_response
# 	drop foreign key fk_up_ukan_response_TASK_ID;
#
# alter table up_ukan_tag_task
# 	drop foreign key fk_up_ukan_tag_task_TAG_ID;
#
# alter table up_ukan_tag_task
# 	drop foreign key fk_up_ukan_tag_task_TASK_ID;
#
# alter table up_ukan_task
# 	drop foreign key fk_up_ukan_task_CLIENT_ID;
#
# alter table up_ukan_task
# 	drop foreign key fk_up_ukan_task_PROJECT_ID;
#
# alter table up_ukan_task
# 	drop foreign key fk_up_ukan_task_STATUS_ID;
#
# alter table up_ukan_task
# 	drop foreign key fk_up_ukan_task_CONTRACTOR_ID;

DROP TABLE `up_ukan_user`;

DROP TABLE `up_ukan_feedback` ;

DROP TABLE `up_ukan_tag`;

DROP TABLE `up_ukan_tag_task`;

DROP TABLE `up_ukan_task`;

DROP TABLE `up_ukan_status`;

DROP TABLE `up_ukan_response`;

DROP TABLE `up_ukan_project`;

DELETE FROM b_user where WORK_COMPANY = 'UKAN';