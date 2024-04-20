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
	$routes->get('/profile/{user_id}/tasks/', new PublicPageController('/local/modules/up.ukan/views/task-list.php'));
	$routes->get('/profile/{user_id}/task/', new PublicPageController('/local/modules/up.ukan/views/task.php'));
	$routes->get('/profile/{user_id}/projects/', new PublicPageController('/local/modules/up.ukan/views/project-list.php'));
	$routes->get('/project/{project_id}/', new PublicPageController('/local/modules/up.ukan/views/project.php'));
	$routes->get('/profile/{user_id}/responses/', new PublicPageController('/local/modules/up.ukan/views/responses.php'));
	$routes->get('/profile/{user_id}/notifications/', new PublicPageController('/local/modules/up.ukan/views/notify.php'));
	$routes->get('/profile/{user_id}/comments/', new PublicPageController('/local/modules/up.ukan/views/comment-list.php'));
	$routes->get('/subscription/', new PublicPageController('/local/modules/up.ukan/views/subscription.php'));

	//profile actions(get)
	$routes->get('/profile/{user_id}/edit/', new PublicPageController('/local/modules/up.ukan/views/user-edit.php'));
	$routes->get('/task/{user_id}/create/', new PublicPageController('/local/modules/up.ukan/views/task-create.php'));
	$routes->get('/project/{user_id}/create/', new PublicPageController('/local/modules/up.ukan/views/project-create.php'));
	$routes->get('/task/{id}/', new PublicPageController('/local/modules/up.ukan/views/detail.php'));
	$routes->get('/project/{project_id}/edit/', new PublicPageController('/local/modules/up.ukan/views/project-edit.php'));
	$routes->get('/task/{task_id}/edit/', new PublicPageController('/local/modules/up.ukan/views/task-edit.php'));
	$routes->get('/comment/{comment_id}/edit/', new PublicPageController('/local/modules/up.ukan/views/comment-edit.php'));

	//profile actions(post)
	$routes->post('/task/create/', [\Up\Ukan\Controller\Task::class, 'create']);
	$routes->post('/task/update/', [\Up\Ukan\Controller\Task::class, 'update']);
	$routes->post('/task/delete/', [\Up\Ukan\Controller\Task::class, 'delete']);
	$routes->post('/task/finish/', [\Up\Ukan\Controller\Task::class, 'finishTask']);

	$routes->post('/project/create/', [\Up\Ukan\Controller\Project::class, 'create']);
	$routes->post('/project/update/', [\Up\Ukan\Controller\Project::class, 'update']);
	$routes->post('/project/delete/', [\Up\Ukan\Controller\Project::class, 'delete']);

	//auth&logOut
	$routes->get('/logout', [\Up\Ukan\Controller\Auth::class, 'logOut']);
	$routes->post('/login', [\Up\Ukan\Controller\Auth::class, 'signIn']);
	$routes->post('/reg', [\Up\Ukan\Controller\Auth::class, 'signUpUser']);
	$routes->get('/sign-up', new PublicPageController('/local/modules/up.ukan/views/sign-up.php'));
	$routes->get('/sign-in', new PublicPageController('/local/modules/up.ukan/views/sign-in.php'));

	//response and notifications area
	$routes->post('/response/create/', [\Up\Ukan\Controller\Response::class, 'create']);
	$routes->post('/response/delete/', [\Up\Ukan\Controller\Response::class, 'delete']);
	$routes->post('/response/approve/', [\Up\Ukan\Controller\Response::class, 'approve']);
	$routes->post('/response/reject/', [\Up\Ukan\Controller\Response::class, 'reject']);
	$routes->post('/notification/delete/', [\Up\Ukan\Controller\Notification::class, 'delete']);

	//edit profile
	$routes->post('/profile/changeBio', [\Up\Ukan\Controller\User::class, 'changeUserBio']);
	$routes->post('/profile/changePassword', [\Up\Ukan\Controller\User::class, 'changePassword']);
	$routes->post('/profile/changePassword', [\Up\Ukan\Controller\Auth::class, 'changePassword']);

	//subscription
	$routes->post('/subscription/getTrialVersion', [\Up\Ukan\Controller\Subscription::class, 'getTrialVersion']);
};