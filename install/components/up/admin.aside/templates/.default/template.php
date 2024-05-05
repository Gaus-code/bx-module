<?php
/**
 * @var CUser $USER
 * @var array $arResult
 */
?>
<aside class="aside">
	<?php $user = $arResult['USER']?>
	<div class="aside__profile">
		<p class="profile__name"><?=htmlspecialcharsbx($user->getBUser()->getName() . ' ' .$user->getBUser()->getLastName())?></p>
		<p class="profile__email"><?=$user->getBUser()->getEmail()?></p>
	</div>

	<div class="aside__header">
		<nav class="aside__nav">

			<a href="/admin/tasks/" id="taskToogle" type="button" class="aside__btn">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/task.svg" alt="task folder">
				Заявки
			</a>

			<a href="/admin/feedbacks/" class="aside__btn">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/comment.svg" alt="notification folder" class="commentImg">
				Отзывы
			</a>

			<a href="/admin/users/" class="aside__btn">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="notification folder" class="commentImg">
				Пользователи
			</a>

			<a href="/admin/categories/" class="aside__btn">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/dashboard.svg" alt="project folder" class="userImg">
				Категории
			</a>

			<a href="/admin/notifications/" class="aside__btn">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/email.svg" alt="notification folder">
				Уведомления
			</a>
			<a href="/admin/settings/" class="aside__btn">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/settings.svg" alt="setting folder" class="commentImg">
				Настройки сайта
			</a>
		</nav>
		<a href="/logout?sessid=<?= bitrix_sessid() ?>" class="profile__logOut">Выйти</a>

	</div>
</aside>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/asideAnchorLinks.js"></script>