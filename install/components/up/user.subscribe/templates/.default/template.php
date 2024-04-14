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

<main class="subscription wrapper">
	<div class="subscription__container animate-border">
		<div class="subscription__main">
			<p class="subscription__title"><?=\Up\Ukan\Options\Subscription::getTitle()?></p>
			<p class="subscription__description"><?=\Up\Ukan\Options\Subscription::getDescription()?></p>
			<p class="subscription__title">С нашей подпиской вам доступно:</p>
			<ul class="subscription__list">
				<li class="subscription__item">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/crown.svg" alt="crown image">
					<p class="subscription__description">Продвижение вверх ваших заявок</p>
				</li>
				<li class="subscription__item">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/crown.svg" alt="crown image">
					<p class="subscription__description">Продвижение вверх вашего профиля в откликах</p>
				</li>
				<li class="subscription__item">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/crown.svg" alt="crown image">
					<p class="subscription__description">Чего-нибудь еще</p>
				</li>
				<li class="subscription__item">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/crown.svg" alt="crown image">
					<p class="subscription__description">Доступ к GPT без ограничений</p>
				</li>
			</ul>
		</div>
		<div class="subscription__footer">
			<form action="" method="post" class="subscription__form">
				<?=bitrix_sessid_post()?>
				<h4>Оформить подписку</h4>
				<p class="subscription__cost">Стоимость: 399.99 ₽</p>
				<input id="requiredInput" type="checkbox" required>
				<label for="requiredInput">Я принимаю пользовательское соглашение бла-бла-бла</label>
				<button class="subscription__btn" type="submit">Оформить подписку</button>
			</form>
			<form action="/subscription/getTrialVersion" method="post" class="subscription__form">
				<?=bitrix_sessid_post()?>
				<h4>Оформить пробную версию подписки на 7 дней</h4>
				<button class="subscription__btn" type="submit">Оформить подписку</button>
			</form>
		</div>
	</div>
</main>

