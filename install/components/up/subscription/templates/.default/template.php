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
	<?php $APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
	<div class="subscription__container animate-border">
		<div class="subscription__main">
			<p class="subscription__description">Какое-то гениальное описание подписки и надпись "подписка доступна <span>30 дней</span> со дня оформления"</p>
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
					<p class="subscription__description">Неограниченное количество проектов</p>
				</li>
				<li class="subscription__item">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/crown.svg" alt="crown image">
					<p class="subscription__description">Автоматический подбор тегов для ваших заявок</p>
				</li>
			</ul>
		</div>
		<div class="subscription__footer">
			<form action="" method="post" class="subscription__form">
				<?=bitrix_sessid_post()?>
				<h4>Оформить подписку</h4>
				<p class="subscription__cost">
					Стоимость:
					<?=\Up\Ukan\Service\Configuration::getOption('subscription')['price']?>
					₽
				</p>
				<input id="requiredInput" type="checkbox" required>
				<label for="requiredInput">Я принимаю пользовательское соглашение бла-бла-бла</label>
				<button class="subscription__btn" type="submit">
					<a href="/subscription/haha/">Оформить подписку</a>
				</button>
			</form>
			<form action="/subscription/getTrialVersion" method="post" class="subscription__form">
				<?=bitrix_sessid_post()?>
				<h4>
					Оформить пробную версию на
					<?=\Up\Ukan\Service\Configuration::getOption('subscription')['trial_subscription_period_in_days']?>
					дней
				</h4>
				<button class="subscription__btn" type="submit">Оформить пробную версию</button>
			</form>
		</div>
	</div>
</main>

