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
			<h2 class="content__tittle">Ваш профиль</h2>
		</article>
		<?php foreach ($arResult['USER'] as $user): ?>
		<article class="content__mainBio">
			<div class="content__mainBio_header">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/headerUser.svg" alt="user image" class="userImage">
				<div class="userInfo">
					<p class="userInfo__subscription">У вас пока нет премиум подписки. Хотите <a href="/subscription/" class="rainbow-border-link premium-link">завести?</a></p>
					<p class="userInfo__name"><?= htmlspecialchars($user->getName()) ?></p>
					<p class="userInfo__surname"><?= htmlspecialchars($user->getSurname()) ?></p>
				</div>
				<a href="/edit/profile/<?= $user->getID() ?>/" class="editProfile">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/editDots.svg" alt="edit user profile">
				</a>
			</div>
			<div class="content__mainBio_main">
				<h4>Ваше описание:</h4>
				<?php if (!empty($user->getBio())): ?>
					<p class="userInfo__bio"><?= htmlspecialchars($user->getBio()) ?></p>
				<?php else: ?>
					<p class="userInfo__bio">У вас пока нет описания. Давайте <a href="/edit/profile/<?= $user->getID() ?>/">добавим</a></p>
				<?php endif;?>
			</div>
			<div class="content__mainBio_footer">
				<h4>Аккаунт создан:</h4>
				<p class="userInfo__createdAt"><?= $user->getCreatedAt()->format('d.m.Y')?></p>
			</div>
			<div class="content__mainBio_footer">
				<h4>Подписка активна до:</h4>
				<p class="userInfo__createdAt">У вас нет премиум подписки</p>
			</div>
		</article>
		<?php endforeach; ?>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
