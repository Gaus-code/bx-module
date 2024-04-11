<?php

use Bitrix\Main\Routing\Controllers\PublicPageController;
use Bitrix\Main\Routing\RoutingConfigurator;

return function (RoutingConfigurator $routes)
{

	//common
	$routes->get('/', new PublicPageController('/local/modules/up.ukan/views/main.php'));
	$routes->get('/catalog/', new PublicPageController('/local/modules/up.ukan/views/catalog.php'));
	$routes->get('/task/{task_id}/', new PublicPageController('/local/modules/up.ukan/views/detail.php'));

	//profile
	$routes->get('/profile/{user_id}/', new PublicPageController('/local/modules/up.ukan/views/user.php'));
	$routes->get('/profile/{user_id}/tasks/', new PublicPageController('/local/modules/up.ukan/views/user-tasks.php'));
	$routes->get('/profile/{user_id}/task/', new PublicPageController('/local/modules/up.ukan/views/user-task.php'));
	$routes->get('/profile/{user_id}/projects/', new PublicPageController('/local/modules/up.ukan/views/user-projects.php'));
	$routes->get('/project/{project_id}/', new PublicPageController('/local/modules/up.ukan/views/user-project.php'));
	$routes->get('/profile/{user_id}/responses/', new PublicPageController('/local/modules/up.ukan/views/user-responses.php'));
	$routes->get('/profile/{user_id}/notifications/', new PublicPageController('/local/modules/up.ukan/views/user-notify.php'));
	$routes->get('/subscription/', new PublicPageController('/local/modules/up.ukan/views/subscription.php'));

	//profile actions(get)
	$routes->get('/edit/profile/{user_id}/', new PublicPageController('/local/modules/up.ukan/views/user-edit.php'));
	$routes->get('/create/task/{user_id}/', new PublicPageController('/local/modules/up.ukan/views/task-create.php'));
	$routes->get('/create/project/{user_id}/', new PublicPageController('/local/modules/up.ukan/views/project-create.php'));
	$routes->get('/task/{id}/', new PublicPageController('/local/modules/up.ukan/views/detail.php'));

	//profile actions(post)
	$routes->post('/create/task/', [\Up\Ukan\Controller\Task::class, 'create']);
	$routes->post('/update/task/', [\Up\Ukan\Controller\Task::class, 'update']);
	$routes->post('/delete/task/', [\Up\Ukan\Controller\Task::class, 'delete']);

	$routes->post('/create/project/', [\Up\Ukan\Controller\Project::class, 'create']);
	$routes->post('/update/task/', [\Up\Ukan\Controller\Project::class, 'update']);
	$routes->post('/delete/task/', [\Up\Ukan\Controller\Project::class, 'delete']);

	//auth&logOut
	$routes->get('/logout', [\Up\Ukan\Controller\Auth::class, 'logOut']);
	$routes->post('/login', [\Up\Ukan\Controller\Auth::class, 'signIn']);
	$routes->post('/reg', [\Up\Ukan\Controller\Auth::class, 'signUpUser']);
	$routes->get('/sign-up', new PublicPageController('/local/modules/up.ukan/views/sign-up.php'));
	$routes->get('/sign-in', new PublicPageController('/local/modules/up.ukan/views/sign-in.php'));

	//response area
	$routes->post('/create/response/', [\Up\Ukan\Controller\Response::class, 'create']);
	$routes->post('/delete/response/', [\Up\Ukan\Controller\Response::class, 'delete']);

	//edit profile
	$routes->post('/profile/changeBio', [\Up\Ukan\Controller\User::class, 'changeUserBio']);
	$routes->post('/profile/changePassword', [\Up\Ukan\Controller\Auth::class, 'changePassword']);
};