<?php
/**
 * @var CMain $APPLICATION
 */
?>
<!doctype html>
<html lang="<?= LANGUAGE_ID; ?>">
<head>
	<meta charset="UTF-8">
	<meta name="viewport"
		  content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title><?php $APPLICATION->ShowTitle(); ?></title>
	<?php
	$APPLICATION->ShowHead();
	?>
</head>
<body>
<?php $APPLICATION->ShowPanel(); ?>
<main class="profile__main">
	<aside class="aside">
		<div class="aside__header">
			<div class="aside__logoContainer">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/logo.svg" alt="logo" class="logo">
				<a href="/" class="header__profileName">UKAN</a>
			</div>
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
						<li>
							<a href="/task/1/">
								<span></span>Task 1
							</a>
						</li>
						<li>
							<a href="/task/1/">
								<span></span>Task 1
							</a>
						</li>
						<li>
							<a href="/task/1/">
								<span></span>Task 1
							</a>
						</li>
						<li>
							<a href="/task/1/">
								<span></span>Task 1 Project 1 Project 1 Project 1 Project 1 Project 1
							</a>
						</li>
					</ul>
				</div>


				<div class="aside__navContainer">
					<button id="projectToogle" class="aside__btn">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/folder.svg" alt="project folder">
						Проекты
					</button>
					<ul id="projectList" class="aside__projectList">
						<li>
							<a class="project-link" href="/project/1/">
								<span></span>Project 1 Project 1 Project 1 Project 1 Project 1
							</a>
						</li>
						<li>
							<a class="project-link" href="/project/2/">
								<span></span>Project 1 I GET SOME SPECIAL PROJECT ITS AWESOME
							</a>
						</li>
						<li>
							<a class="project-link" href="/project/2/">
								<span></span>Project 1
							</a>
						</li>
						<li>
							<a href="/project/2/">
								<span></span>Project 1
							</a>
						</li>
					</ul>
				</div>

				<button class="aside__btn">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/email.svg" alt="notification folder">
					Уведомления
					<span>2</span>
				</button>
			</nav>
		</div>

		<div class="aside__profile">
			<p class="profile__name">Заказчик Заказчиков</p>
			<p class="profile__email">zakazchikIsSuper007@gmail.com</p>
			<button class="profile__logOut">Выйти</button>
		</div>
	</aside>