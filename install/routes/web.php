<?php

use Bitrix\Main\Routing\Controllers\PublicPageController;
use Bitrix\Main\Routing\RoutingConfigurator;

return function (RoutingConfigurator $routes) {

	$routes->get('/', new PublicPageController('/local/modules/up.ukan/views/main.php'));
	$routes->get('/catalog/{page}/', new PublicPageController('/local/modules/up.ukan/views/catalog.php'));
	$routes->get('/login/', new PublicPageController('/local/modules/up.ukan/views/login.php'));
	$routes->get('/registration/', new PublicPageController('/local/modules/up.ukan/views/login.php'));
	$routes->get('/task/{id}/', new PublicPageController('/local/modules/up.ukan/views/detail.php'));
	$routes->get('/client/{user_id}/', new PublicPageController('/local/modules/up.ukan/views/client.php'));
	$routes->get('/client/{user_id}/info/', new PublicPageController('/local/modules/up.ukan/views/client-info.php'));
	$routes->get('/create/task/', new PublicPageController('/local/modules/up.ukan/views/task-create.php'));
	$routes->get('/create/project/', new PublicPageController('/local/modules/up.ukan/views/project-create.php'));
};