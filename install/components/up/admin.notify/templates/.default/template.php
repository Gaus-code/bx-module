<?php
/**
 * @var array $arResult
 * @var array $arParams
 * @var CUser $USER
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

?>

<main class="profile__main">
	<?php
	$APPLICATION->IncludeComponent('up:admin.aside', '', [
		'USER_ID' => $USER->GetID(),
	]); ?>
	<!-- Вкладка уведомлений для админа !-->
	<section class="admin">
		<article class="content__header">
			<h1>Рабочая область</h1>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Уведомления</h2>
		</article>
		<article class="notify">
			<ul class="notify__list">
				<li class="notify__item">
					<div class="notify__profile">
						<p>Жалоба на заявку: </p>
					</div>
					<div class="notify__profile">
						<p>какой-то заголовок</p>
					</div>
					<div class="notify__profile">
						<p>Описание: какое-то описание</p>
					</div>
					<div class="notify__buttons">
						<a class="notify__accept" href="/task/1/">Посмотреть</a>
					</div>
				</li>
				<li class="notify__item">
					<div class="notify__profile">
						<p>Жалоба на описание профиля: </p>
					</div>
					<div class="notify__profile">
						<p>какое-то описание профиля</p>
					</div>
					<div class="notify__buttons">
						<a class="notify__accept" href="/task/1/">Посмотреть</a>
					</div>
				</li>
				<li class="notify__item">
					<div class="notify__profile">
						<p>Жалоба на комментарий: </p>
					</div>
					<div class="notify__profile">
						<p>какой-то комментарий</p>
					</div>
					<div class="notify__buttons">
						<a class="notify__accept" href="/task/1/">Посмотреть</a>
					</div>
				</li>
			</ul>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
