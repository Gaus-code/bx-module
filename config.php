<?php

return array(
	'task_status' => array(
		'queue' => 'В очереди',
		'done' => 'Выполнено',
		'at_work' => 'В работе',
		'search_contractor' => 'Поиск исполнителя',
		'waiting_to_start' => 'Ожидает начала поиска исполнителя',
	),
	'subscription' => array(
		'price' => 399,
		'trial_subscription_period_in_days'=>'30',
	),
	'yandexGPT' => array(
		'secret_key' => 'AQVNztg5AhOJG_qdivT_LWgRQADPQkfjCwyY2tbP',
		'directory_id' => 'b1gjdsgd12d0ee2e41in',
	),
	'notification_message' => array(
		'approve' => 'Ваш отклик одобрен',
		'reject' => 'Ваш отклик отклонен',
		'new_feedback' => 'Новый отзыв',
		'new_response' => 'Новый отклик',
		'task_finished' => 'Задача выполена',
		'task_block' => 'Задача заблокирована',
		'task_unblock' => 'Задача разблокирована',
		'feedback_block' => 'Отзыв заблокирован',
		'feedback_unblock' => 'Отзыв разблокирован',
		'user_block' => 'Ваш профиль заблокирован',
		'user_unblock' => 'Ваш профиль разблокирован',
	),
	'response_status' => array(
		'wait' => 'Ожидает',
		'approve' => 'Одобрен',
		'reject' => 'Отклонен',

	),
	'page_size' => array(
		'task_list_catalog' => 9,
		'task_list_personal' => 10,
		'responses_list' => 6,
		'notification_list' => 9,
		'feedback_list' => 7,
		'admin_tables' => 10,
		'project_list' => 7,
	),
	'independent_stage_number'=>0,
	'project_stage_status' => array(
		'waiting_to_start' => 'Ожидает начала выполнения',
		'queue'=>'В очереди',
		'active' => 'Активен',
		'completed' => 'Завершен',
		'independent' => 'Независимый этап',
	),
	'project_status' => array(
		'active' => 'Активен',
		'completed' => 'Завершен',
	),
	'maximum_number_of_projects_for_users_without_subscription' => 3,
);