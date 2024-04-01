<?php

use Bitrix\Main\Routing\Controllers\PublicPageController;
use Bitrix\Main\Routing\RoutingConfigurator;

return function (RoutingConfigurator $routes) {

	$routes->get('/', new PublicPageController('/local/modules/up.ukan/views/main.php'));
	$routes->get('/catalog/{id}/', new PublicPageController('/local/modules/up.ukan/views/catalog.php'));
	$routes->get('/login/', new PublicPageController('/local/modules/up.ukan/views/login.php'));


};