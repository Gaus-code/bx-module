<?php
/**
 * @var CUser $USER
 * @var array $arResult
 */
?>
<aside class="aside">
	<?php foreach ($arResult['USER'] as $user):?>
	<div class="aside__profile">
		<p class="profile__name"><?=$user->getName() . ' ' .$user->getSurname()?></p>
		<p class="profile__email"><?=$user->getEmail()?></p>
	</div>
	<?php endforeach;?>
	<div class="aside__header">
		<nav class="aside__nav">
			<button type="button" class="aside__btn active-profile-btn">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/dashboard.svg" alt="task folder">
				Рабочая Область
			</button>
			<div class="aside__navContainer">
				<button id="taskToogle" type="button" class="aside__btn">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/task.svg" alt="task folder">
					Заявки
				</button>
				<ul id="taskList" class="aside__taskList">
					<?php foreach ($arResult['USER'] as $user):?>
					<li>
						<a href="/profile/<?=$user->getId()?>/tasks/">
							<span></span>Все заявки
						</a>
					</li>
					<?php endforeach;?>
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
					<?php foreach ($arResult['USER'] as $user):?>
					<li>
						<a class="project-link" href="/profile/<?=$user->getId()?>/projects/">
							<span></span>Все проекты
						</a>
					</li>
					<?php endforeach;?>
					<?php foreach ($arResult['PROJECTS'] as $project):?>
					<li>
						<a class="project-link" href="/project/<?=$project->getId()?>/">
							<span></span><?= $project->getTitle() ?>
						</a>
					</li>
					<?php endforeach;?>
				</ul>
			</div>
			<?php foreach ($arResult['USER'] as $user):?>
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
			<?php endforeach;?>
		</nav>
		<a href="/logout?sessid=<?= bitrix_sessid() ?>" class="profile__logOut">Выйти</a>
	</div>
</aside>