<?php
/**
 * @var CUser $USER
 * @var array $arResult
 */
?>
<aside class="aside">
	<?php $user = $arResult['USER']?>
	<div class="aside__profile">
		<p class="profile__name"><?=$user->getBUser()->getName() . ' ' .$user->getBUser()->getLastName()?></p>
		<p class="profile__email"><?=$user->getBUser()->getEmail()?></p>
	</div>

	<div class="aside__header">
		<nav class="aside__nav">
			<a href="/profile/<?= $user->getId()?>/" type="button" class="aside__btn" id="userLink">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="user profile link" >
				Профиль
			</a>

			<a href="/profile/<?=$user->getId()?>/tasks/" id="taskToogle" type="button" class="aside__btn">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/task.svg" alt="task folder">
				Заявки
			</a>

			<a href="/profile/<?=$user->getId()?>/projects/" id="projectToogle" class="aside__btn" >
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/folder.svg" alt="project folder">
				Проекты
			</a>
			<a href="/profile/<?=$user->getId()?>/responses/" class="aside__btn" id="responsesLink">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/dashboard.svg" alt="project folder" class="userImg">
				Отклики
			</a>

			<a href="/profile/<?=$user->getId()?>/notifications/" id="notificationLink" class="aside__btn">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/email.svg" alt="notification folder">
				Уведомления
				<span>2</span>
			</a>

			<a href="/profile/<?=$user->getId()?>/comments/" id="notificationLink" class="aside__btn">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/comment.svg" alt="notification folder" class="commentImg">
				Тут будут отзывы
			</a>
		</nav>
		<a href="/logout?sessid=<?= bitrix_sessid() ?>" class="profile__logOut">Выйти</a>
	</div>
</aside>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/asideAnchorLinks.js"></script>