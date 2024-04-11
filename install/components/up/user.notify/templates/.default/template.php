<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

?>
<main class="profile__main">
	<?php $APPLICATION->IncludeComponent('up:user.aside', '', []); ?>
	<section class="content">
		<article class="content__header">
			<h1>Рабочая область</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner">+</span>
			</button>
			<div class="content__profileCreate">
				<a href="/create/project/<?=$arParams['USER_ID']?>/" class="create__link">Создать проект</a>
				<a href="/create/task/<?=$arParams['USER_ID']?>/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваши Уведомления</h2>
		</article>
		<article class="notify">
			<ul class="notify__list">
				<li class="notify__item">
					<div class="notify__profile">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/headerUser.svg" alt="user image">
						<div class="userInfo">
							<p class="userInfo__name">
								<a href="/">
									<?= htmlspecialchars('ДлинноеИмя ДлиннаяФамилия') ?>
								</a>
							</p>
							<p class="userInfo__surname">откликнулся</p>
						</div>
					</div>
					<div class="notify__title"><span>Заявка:</span> Заголовок 1 заявки для заголовочных заголовков заявок</div>
					<div class="notify__buttons">
						<a href="/task/1/accept/user/1/" class="notify__accept">Принять</a>
						<a href="/task/1/reject/user/1/" class="notify__reject">Отклонить</a>
					</div>
				</li>
				<li class="notify__item">
					<div class="notify__profile">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/headerUser.svg" alt="user image">
						<div class="userInfo">
							<p class="userInfo__name">
								<a href="/">
									<?= htmlspecialchars('Имя ОченьДлиннаяФамилия') ?>
								</a>
							</p>
							<p class="userInfo__surname">откликнулся</p>
						</div>
					</div>
					<div class="notify__title"><span>Заявка:</span> Заголовок 2 заявки для заголовочных заголовков заявок</div>
					<div class="notify__buttons">
						<a href="/task/2/accept/user/1/" class="notify__accept">Принять</a>
						<a href="/task/2/reject/user/1/" class="notify__reject">Отклонить</a>
					</div>
				</li>
				<li class="notify__item">
					<div class="notify__profile">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/headerUser.svg" alt="user image">
						<div class="userInfo">
							<p class="userInfo__name">
								<a href="/">
									<?= htmlspecialchars('Имя ОченьДлиннаяФамилия') ?>
								</a>
							</p>
							<p class="userInfo__surname">откликнулся</p>
						</div>
					</div>
					<div class="notify__title"><span>Заявка:</span> Заголовок 2 заявки для заголовочных заголовков заявок Заголовок 2 заявки для заголовочных заголовков заявок</div>
					<div class="notify__buttons">
						<a href="/task/2/accept/user/1/" class="notify__accept">Принять</a>
						<a href="/task/2/reject/user/1/" class="notify__reject">Отклонить</a>
					</div>
				</li>
				<li class="notify__item">
					<div class="notify__profile">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/headerUser.svg" alt="user image">
						<div class="userInfo">
							<p class="userInfo__name">
								<a href="/">
									<?= htmlspecialchars('Имя Очень') ?>
								</a>
							</p>
							<p class="userInfo__surname">откликнулся</p>
						</div>
					</div>
					<div class="notify__title"><span>Заявка:</span> Заголовок 2 заявки для заголовочных заголовков заявок</div>
					<div class="notify__buttons">
						<a href="/task/2/accept/user/1/" class="notify__accept">Принять</a>
						<a href="/task/2/reject/user/1/" class="notify__reject">Отклонить</a>
					</div>
				</li>
			</ul>
		</article>
		 <!--<div class="contractor__emptyContainer">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/EmptyInbox.svg" alt="empty inbox image">
			<p class="contractor__emptyLink">У нас пока нет уведомлений</p>
		</div>
		!-->
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
