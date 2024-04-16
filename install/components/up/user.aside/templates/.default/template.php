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
			<a href="/profile/<?= $user->getId()?>/" type="button" class="aside__btn active-profile-btn">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/dashboard.svg" alt="task folder">
				Профиль
			</a>
			<div class="aside__navContainer">
				<button id="taskToogle" type="button" class="aside__btn">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/task.svg" alt="task folder">
					Заявки
				</button>
				<ul id="taskList" class="aside__taskList">
					<li>
						<a href="/profile/<?=$user->getId()?>/tasks/">
							<span></span>Все заявки
						</a>
					</li>
					<?php foreach ($arResult['TASKS'] as $task):?>
					<li>
						<a href="/task/<?= $task->getId() ?>/">
							<span></span><?= $task->getTitle() ?>
						</a>
					</li>
					<?php endforeach;?>
				</ul>
			</div>


			<div class="aside__navContainer">
				<button id="projectToogle" class="aside__btn">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/folder.svg" alt="project folder">
					Проекты
				</button>
				<ul id="projectList" class="aside__projectList">
					<li>
						<a class="project-link" href="/profile/<?=$user->getId()?>/projects/">
							<span></span>Все проекты
						</a>
					</li>
					<?php foreach ($arResult['PROJECTS'] as $project):?>
					<li>
						<a class="project-link" href="/project/<?=$project->getId()?>/">
							<span></span><?= $project->getTitle() ?>
						</a>
					</li>
					<?php endforeach;?>
				</ul>
			</div>
			<div class="aside__navContainer">
				<a href="/profile/<?=$user->getId()?>/responses/" class="aside__btn">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/folder.svg" alt="project folder">
					Отклики
				</a>
			</div>

			<a href="/profile/<?=$user->getId()?>/notifications/" class="aside__btn">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/email.svg" alt="notification folder">
				Уведомления
				<span>2</span>
			</a>
		</nav>
		<a href="/logout?sessid=<?= bitrix_sessid() ?>" class="profile__logOut">Выйти</a>
	</div>
</aside>