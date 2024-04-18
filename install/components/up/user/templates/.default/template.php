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
	$APPLICATION->IncludeComponent('up:user.aside', '', []); ?>
	<section class="content">
		<article class="content__header">
			<h1>Рабочая область</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner">+</span>
			</button>
			<div class="content__profileCreate">
				<a href="/project/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваш профиль</h2>
		</article>
	<?php $user=$arResult['USER']?>
			<article class="content__mainBio">
				<div class="content__mainBio_header">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/headerUser.svg" alt="user image" class="userImage">
					<div class="userInfo">

						<p class="userInfo__name"><?= htmlspecialchars($user->getBUser()->getName()) ?></p>
						<p class="userInfo__surname"><?= htmlspecialchars($user->getBUser()->getLastName()) ?></p>
					</div>
					<a href="/profile/<?= $user->getID() ?>/edit/" class="editProfile">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/editDots.svg" alt="edit user profile">
					</a>
				</div>
				<div class="content__mainBio_main">
					<h4>Ваше описание:</h4>
					<?php
					if (!empty($user->getBio())): ?>
						<p class="userInfo__bio"><?= htmlspecialchars($user->getBio()) ?></p>
					<?php
					else: ?>
						<p class="userInfo__bio">У вас пока нет описания. Давайте
							<a href="/profile/<?= $user->getID() ?>/edit/">добавим</a></p>
					<?php
					endif; ?>
				</div>
				<div class="content__mainBio_footer">
					<h4>Аккаунт создан:</h4>
					<p class="userInfo__createdAt"><?= $user->getBUser()->getDateRegister()->format('d.m.Y') ?></p>
				</div>
				<div class="content__mainBio_footer">
					<h4>Подписка активна до:</h4>
					<?php
					if ($user->get('SUBSCRIPTION_STATUS') === "Active")
					{
						?>
						<p class="userInfo__subscription"> <?= $user->get('SUBSCRIPTION_END_DATE') ?></p>
						<?php
					}
					else
					{
						?>
						<p class="userInfo__subscription">У вас пока нет премиум подписки. Хотите
							<a href="/subscription/" class="rainbow-border-link premium-link">завести?</a></p>
						<?php
					} ?>
				</div>
			</article>

	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
