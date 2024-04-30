<?php

/**
 * @var array $arResult
 * @var array $arParams
 * @var CMain $APPLICATION
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>


<div class="modalCard" id="logInModalContainer">

	<h2 class="modalCard__title">Войти в UKAN</h2>

	<form action="/login" method="post" class="modalCard__form">
		<?= bitrix_sessid_post(); ?>

		<div class="modalResponse">
			<?php $APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
		</div>

		<div class="modalField">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="click and write your login" class="modalField__img">
			<input class="modalCard__form_input" autocomplete="off" type="text" name="login" maxlength="100" placeholder="Логин">
		</div>

		<div class="modalField">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/key.svg" alt="click and write your Password" class="modalField__img">
			<input class="modalCard__form_input password" autocomplete="off" type="password"  maxlength="200" name="password" placeholder="Пароль">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/eye.svg" alt="show your password in the screen" class="modalField__eye">
		</div>

		<button id="logInButton" class="modalCard__btn" type="submit">Войти</button>
		<div class="modalCard__availability">
			<a href="/sign-up" class="modalCard__availability_btn">У меня нет аккаунта</a>
		</div>
		<div class="modalCard__availability">
			<a href="/" class="modalCard__link">Вернуться на главную</a>
		</div>
	</form>
</div>
<?php
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/login.js");
?>