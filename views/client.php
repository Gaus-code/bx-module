<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");
?>

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
	<section class="content">
		<article class="content__header">
			<h1>Рабочая область</h1>
			<a class="plus-link" href="/create/project/">
				<span class="plus-link__inner">+</span>
			</a>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваши проекты</h2>
		</article>
		<article class="content__main">
			<a href="/task/1/" class="task">
				<div class="task__header">
					<p class="task__tag">Website</p>
					<p class="task__tag">Design</p>
				</div>
				<div class="task__main">
					<h3>Bugo Website About page Bugo Website About page Bugo Website About page</h3>
					<p class="task__description"> Amet minim mollit non deserunt ullamco est sit aliqua dolor do  Amet minim mollit non deserunt ullamco est sit aliqua dolor do  Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
				</div>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>12</p>
					</div>
					<div class="task__notify">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/notification.svg" alt="task notifications" class="task__notify">
						<p>11</p>
					</div>
					<div class="task__files">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/clip.svg" alt="task files" class="task__files">
						<p>2</p>
					</div>
				</div>
			</a>
			<a href="/task/1/" class="task">
				<div class="task__header">
					<p class="task__tag">Website</p>
					<p class="task__tag">Design</p>
				</div>
				<div class="task__main">
					<h3>Bugo Website About page</h3>
					<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
				</div>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>12</p>
					</div>
					<div class="task__notify">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/notification.svg" alt="task notifications" class="task__notify">
						<p>11</p>
					</div>
					<div class="task__files">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/clip.svg" alt="task files" class="task__files">
						<p>2</p>
					</div>
				</div>
			</a>
			<a href="/task/1/" class="task">
				<div class="task__header">
					<p class="task__tag">Website</p>
					<p class="task__tag">Design</p>
				</div>
				<div class="task__main">
					<h3>Bugo Website About page</h3>
					<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
				</div>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>12</p>
					</div>
					<div class="task__notify">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/notification.svg" alt="task notifications" class="task__notify">
						<p>11</p>
					</div>
					<div class="task__files">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/clip.svg" alt="task files" class="task__files">
						<p>2</p>
					</div>
				</div>
			</a>
			<a href="/task/1/" class="task">
				<div class="task__header">
					<p class="task__tag">Website</p>
					<p class="task__tag">Design</p>
				</div>
				<div class="task__main">
					<h3>Bugo Website About page</h3>
					<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
				</div>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>12</p>
					</div>
					<div class="task__notify">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/notification.svg" alt="task notifications" class="task__notify">
						<p>11</p>
					</div>
					<div class="task__files">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/clip.svg" alt="task files" class="task__files">
						<p>2</p>
					</div>
				</div>
			</a>
			<a href="/task/1/" class="task">
				<div class="task__header">
					<p class="task__tag">Website</p>
					<p class="task__tag">Design</p>
				</div>
				<div class="task__main">
					<h3>Bugo Website About page</h3>
					<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
				</div>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>12</p>
					</div>
					<div class="task__notify">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/notification.svg" alt="task notifications" class="task__notify">
						<p>11</p>
					</div>
					<div class="task__files">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/clip.svg" alt="task files" class="task__files">
						<p>2</p>
					</div>
				</div>
			</a>
			<a href="/task/1/" class="task">
				<div class="task__header">
					<p class="task__tag">Website</p>
					<p class="task__tag">Design</p>
				</div>
				<div class="task__main">
					<h3>Bugo Website About page</h3>
					<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
				</div>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>12</p>
					</div>
					<div class="task__notify">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/notification.svg" alt="task notifications" class="task__notify">
						<p>11</p>
					</div>
					<div class="task__files">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/clip.svg" alt="task files" class="task__files">
						<p>2</p>
					</div>
				</div>
			</a>
			<a href="/task/1/" class="task">
				<div class="task__header">
					<p class="task__tag">Website</p>
					<p class="task__tag">Design</p>
				</div>
				<div class="task__main">
					<h3>Bugo Website About page</h3>
					<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
				</div>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>12</p>
					</div>
					<div class="task__notify">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/notification.svg" alt="task notifications" class="task__notify">
						<p>11</p>
					</div>
					<div class="task__files">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/clip.svg" alt="task files" class="task__files">
						<p>2</p>
					</div>
				</div>
			</a>
			<a href="/task/1/" class="task">
				<div class="task__header">
					<p class="task__tag">Website</p>
					<p class="task__tag">Design</p>
				</div>
				<div class="task__main">
					<h3>Bugo Website About page</h3>
					<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
				</div>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>12</p>
					</div>
					<div class="task__notify">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/notification.svg" alt="task notifications" class="task__notify">
						<p>11</p>
					</div>
					<div class="task__files">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/clip.svg" alt="task files" class="task__files">
						<p>2</p>
					</div>
				</div>
			</a>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>