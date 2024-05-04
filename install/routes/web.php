<?php

use Bitrix\Main\Routing\Controllers\PublicPageController;
use Bitrix\Main\Routing\RoutingConfigurator;

return function (RoutingConfigurator $routes)
{

	//common
	$routes->get('/', new PublicPageController('/local/modules/up.ukan/views/main.php'));
	$routes->get('/catalog/', new PublicPageController('/local/modules/up.ukan/views/catalog.php'));
	$routes->get('/task/{task_id}/', new PublicPageController('/local/modules/up.ukan/views/detail.php'));
	$routes->get('/access/denied/', new PublicPageController('/local/modules/up.ukan/views/403.php'));

	//profile
	$routes->get('/profile/{user_id}/', new PublicPageController('/local/modules/up.ukan/views/user.php'));
	$routes->get('/profile/{user_id}/tasks/', new PublicPageController('/local/modules/up.ukan/views/task-list.php'));
	$routes->get('/profile/{user_id}/projects/', new PublicPageController('/local/modules/up.ukan/views/project-list.php'));
	$routes->get('/project/{project_id}/', new PublicPageController('/local/modules/up.ukan/views/project.php'));
	$routes->get('/profile/{user_id}/responses/', new PublicPageController('/local/modules/up.ukan/views/responses.php'));
	$routes->get('/profile/{user_id}/notifications/', new PublicPageController('/local/modules/up.ukan/views/notify.php'));
	$routes->get('/profile/{user_id}/feedbacks/', new PublicPageController('/local/modules/up.ukan/views/feedback-list.php'));
	$routes->get('/subscription/', new PublicPageController('/local/modules/up.ukan/views/subscription.php'));
	$routes->get('/subscription/haha/', new PublicPageController('/local/modules/up.ukan/views/payment-gateway.php'));
	//profile actions(get)
	$routes->get('/profile/{user_id}/edit/', new PublicPageController('/local/modules/up.ukan/views/user-edit.php'));
	$routes->get('/task/{user_id}/create/', new PublicPageController('/local/modules/up.ukan/views/task-create.php'));
	$routes->get('/project/{user_id}/create/', new PublicPageController('/local/modules/up.ukan/views/project-create.php'));
	$routes->get('/task/{task_id}/', new PublicPageController('/local/modules/up.ukan/views/detail.php'));
	$routes->get('/project/{project_id}/edit/', new PublicPageController('/local/modules/up.ukan/views/project-edit.php'));
	$routes->get('/task/{task_id}/edit/', new PublicPageController('/local/modules/up.ukan/views/task-edit.php'));
	$routes->get('/feedback/{feedback_id}/edit/', new PublicPageController('/local/modules/up.ukan/views/feedback-edit.php'));

	//task actions(post)
	$routes->post('/task/create/', [\Up\Ukan\Controller\Task::class, 'create']);
	$routes->post('/task/update/', [\Up\Ukan\Controller\Task::class, 'update']);
	$routes->post('/task/delete/', [\Up\Ukan\Controller\Task::class, 'delete']);
	$routes->post('/task/finish/', [\Up\Ukan\Controller\Task::class, 'finishTask']);
	$routes->post('/task/create/project/', [\Up\Ukan\Controller\Task::class, 'createAtProject']);
	$routes->post('/task/stop-search-contractor/', [\Up\Ukan\Controller\Task::class, 'stopSearchContractor']);
	$routes->post('/task/start-search-contractor/', [\Up\Ukan\Controller\Task::class, 'startSearchContractor']);
	$routes->post('/task/unassign/', [\Up\Ukan\Controller\Task::class, 'unassignContractor']);
	$routes->post('/task/withdraw/', [\Up\Ukan\Controller\Task::class, 'withdraw']);
	$routes->post('/task/gpt-tags/', [\Up\Ukan\Controller\Task::class, 'generateGptTags']);

	//project actions
	$routes->post('/project/create/', [\Up\Ukan\Controller\Project::class, 'create']);
	$routes->post('/project/edit-stages/', [\Up\Ukan\Controller\Project::class, 'editStages']);
	$routes->post('/project/delete/', [\Up\Ukan\Controller\Project::class, 'delete']);
	$routes->post('/project/add-tasks/', [\Up\Ukan\Controller\Project::class, 'addTasks']);
	$routes->post('/project/add-stage/', [\Up\Ukan\Controller\Project::class, 'addStage']);
	$routes->post('/project/delete-stage/', [\Up\Ukan\Controller\Project::class, 'deleteStage']);
	$routes->post('/project/edit-info/', [\Up\Ukan\Controller\Project::class, 'editInfo']);
	$routes->post('/project/edit-info/', [\Up\Ukan\Controller\Project::class, 'editInfo']);
	$routes->post('/project/complete/', [\Up\Ukan\Controller\Project::class, 'complete']);

	//stage actions
	$routes->post('/stage/start/', [\Up\Ukan\Controller\ProjectStage::class, 'start']);
	$routes->post('/stage/complete/', [\Up\Ukan\Controller\ProjectStage::class, 'complete']);

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
	$routes->post('/profile/changeContacts', [\Up\Ukan\Controller\User::class, 'changeContacts']);
	$routes->post('/profile/changeImage', [\Up\Ukan\Controller\File::class, 'changeImage']);
	$routes->post('/profile/deleteImage', [\Up\Ukan\Controller\File::class, 'deleteImage']);

	//subscription
	$routes->post('/subscription/getTrialVersion', [\Up\Ukan\Controller\Subscription::class, 'getTrialVersion']);

	//feedback
	$routes->post('/feedback/create/', [\Up\Ukan\Controller\Feedback::class, 'create']);
	$routes->post('/feedback/edit/', [\Up\Ukan\Controller\Feedback::class, 'edit']);
	$routes->post('/feedback/delete/', [\Up\Ukan\Controller\Feedback::class, 'delete']);

	//admin
	$routes->get('/admin/tasks/', new PublicPageController('/local/modules/up.ukan/views/admin.php'));
	$routes->get('/admin/notifications/', new PublicPageController('/local/modules/up.ukan/views/admin-notify.php'));
	$routes->get('/admin/feedbacks/', new PublicPageController('/local/modules/up.ukan/views/admin-feedback.php'));
	$routes->get('/admin/users/', new PublicPageController('/local/modules/up.ukan/views/admin-user.php'));
	$routes->get('/admin/categories/', new PublicPageController('/local/modules/up.ukan/views/admin-categories.php'));

	$routes->post('/category/create/', [\Up\Ukan\Controller\Category::class, 'create']);
	$routes->post('/category/delete/', [\Up\Ukan\Controller\Category::class, 'delete']);

	//reports
	$routes->post('/report/create/', [\Up\Ukan\Controller\Report::class, 'create']);
	$routes->post('/report/delete/', [\Up\Ukan\Controller\Report::class, 'delete']);
	$routes->post('/task/block/', [\Up\Ukan\Controller\Block::class, 'blockTask']);
	$routes->post('/task/unblock/', [\Up\Ukan\Controller\Block::class, 'unblockTask']);
	$routes->post('/tag/block/', [\Up\Ukan\Controller\Block::class, 'blockTag']);
	$routes->post('/feedback/block/', [\Up\Ukan\Controller\Block::class, 'blockFeedback']);
	$routes->post('/feedback/unblock/', [\Up\Ukan\Controller\Block::class, 'unblockFeedback']);
	$routes->post('/user/block/', [\Up\Ukan\Controller\Block::class, 'blockUser']);
	$routes->post('/user/unblock/', [\Up\Ukan\Controller\Block::class, 'unblockUser']);
};