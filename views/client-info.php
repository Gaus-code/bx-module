<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");
?>

<main class="profile__main">
	<aside class="aside">
		<div class="aside__profile">
			<p class="profile__name">Заказчик Заказчиков</p>
			<p class="profile__email">zakazchikIsSuper007@gmail.com</p>
		</div>
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
			<button class="profile__logOut">Выйти</button>
		</div>
	</aside>
	<section class="content">
		<article class="content__header">
			<h1>Рабочая область</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner">+</span>
			</button>
			<div class="content__profileCreate">
				<a href="/create/project/" class="create__link">Создать проект</a>
				<a href="/create/task/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваш профиль</h2>
		</article>
		<article class="profileBio">
			<ul class="account__editData">
				<li class="editData__item">
					<h2 class="editData__title">Имя</h2>
					<div class="editData__form">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="edit name" class="editData__img">
						<p class="editData__input">Тут имя вывести</p>
						<button class="editData__btn" type="button" id="accountEditName">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="make your edits"
								 class="editData__btnImg">
						</button>
					</div>
				</li>
				<li class="editData__item">
					<h2 class="editData__title">Почта</h2>
					<div class="editData__form">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/email.svg" alt="edit e-mail address"
							 class="editData__img">
						<p class="editData__input">Тут почту вывести</p>
						<button class="editData__btn" type="button" id="accountEditEmail">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="make your edits"
								 class="editData__btnImg">
						</button>
					</div>
				</li>
				<li class="editData__item">
					<h2 class="editData__title">Фамилия</h2>
					<div class="editData__form">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="edit surname"
							 class="editData__img">
						<p class="editData__input">Тут фамилию вывести</p>
						<button class="editData__btn" type="button" id="accountEditSurname">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="make your edits"
								 class="editData__btnImg">
						</button>
					</div>
				</li>
				<li class="editData__item">
					<h2 class="editData__title">Пароль</h2>
					<div class="editData__form">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/key.svg" alt="edit Password"
							 class="editData__img">
						<p class="editData__input">password</p>
						<button class="editData__btn" type="button" id="accountEditPassword">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="make your edits"
								 class="editData__btnImg">
						</button>
					</div>
				</li>
			</ul>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>