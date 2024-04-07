<?php

use Bitrix\Main\Routing\Controllers\PublicPageController;
use Bitrix\Main\Routing\RoutingConfigurator;

return function (RoutingConfigurator $routes) {

	$routes->get('/', new PublicPageController('/local/modules/up.ukan/views/main.php'));
	$routes->get('/catalog/{page}/', new PublicPageController('/local/modules/up.ukan/views/catalog.php'));
	$routes->get('/task/{task_id}/', new PublicPageController('/local/modules/up.ukan/views/detail.php'));
	$routes->get('/client/{user_id}/', new PublicPageController('/local/modules/up.ukan/views/client.php'));
	$routes->get('/client/{user_id}/info/', new PublicPageController('/local/modules/up.ukan/views/client-info.php'));
	$routes->get('/create/task/{user_id}/', new PublicPageController('/local/modules/up.ukan/views/task-create.php'));
	$routes->get('/create/project/{user_id}/', new PublicPageController('/local/modules/up.ukan/views/project-create.php'));
	$routes->get('/contractor/{user_id}/', new PublicPageController('/local/modules/up.ukan/views/contractor.php'));
	$routes->get('/contractor/{user_id}/responses/', new PublicPageController('/local/modules/up.ukan/views/contractor-responses.php'));
	$routes->get('/contractor/{user_id}/notifications/', new PublicPageController('/local/modules/up.ukan/views/contractor-notifications.php'));
	$routes->get('/task/{id}/', new PublicPageController('/local/modules/up.ukan/views/detail.php'));
	$routes->get('/client/', new PublicPageController('/local/modules/up.ukan/views/client.php'));
	$routes->get('/create/task/', new PublicPageController('/local/modules/up.ukan/views/task-create.php'));
	$routes->get('/create/project/', new PublicPageController('/local/modules/up.ukan/views/project-create.php'));

	$routes->post('/create/task/', [\Up\Ukan\Controller\Task::class, 'create']);

	//auth&logOut
	$routes->get('/logout', [\Up\Ukan\Controller\Auth::class, 'logOut']);
	$routes->post('/login', [\Up\Ukan\Controller\Auth::class, 'signIn']);
	$routes->post('/reg', [\Up\Ukan\Controller\Auth::class, 'signUpUser']);
	$routes->get('/sign-up', new PublicPageController('/local/modules/up.ukan/views/sign-up.php'));
	$routes->get('/sign-in', new PublicPageController('/local/modules/up.ukan/views/sign-in.php'));
};