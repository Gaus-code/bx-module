<?php

/**
 * @var array $arResult
 * @var array $arParams
 * @var CMain $APPLICATION
 */

use Bitrix\Main\Localization\Loc;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
?>

<div class="modalCard">

	<h2 class="modalCard__title">Создать аккаунт в UKAN</h2>

	<form action="/reg" method="post" class="modalCard__form">
		<?= bitrix_sessid_post(); ?>
		<div class="modalResponse">
			<?php $APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
		</div>

		<div class="modalField">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="click and write your name" class="modalField__img">
			<input class="modalCard__form_input" autocomplete="off" type="text" name="firstname" maxlength="30" placeholder="Имя">
		</div>

		<div class="modalField">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="click and write your surname" class="modalField__img">
			<input class="modalCard__form_input" autocomplete="off" type="text" name="lastname"  maxlength="30" placeholder="Фамилия">
		</div>

		<div class="modalField">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/email.svg" alt="click and write your E-mail" class="modalField__img">
			<input class="modalCard__form_input" autocomplete="off" type="text" name="email" maxlength="100" placeholder="Почта">
		</div>


		<div class="modalField">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="click and write your surname" class="modalField__img">
			<input class="modalCard__form_input" type="text" placeholder="Логин" name="login">
		</div>

		<div class="modalField">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/key.svg" alt="click and write your Password" class="modalField__img">
			<input class="modalCard__form_input password" autocomplete="off" type="password" maxlength="200" name="password" placeholder="Пароль">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/eye.svg" alt="show your password in the screen" class="modalField__eye">
		</div>

		<button class="modalCard__btn" type="submit">Создать Аккаунт</button>

		<div class="modalCard__availability">
			<a href="/sign-in" class="modalCard__availability_btn">У меня уже есть аккаунт</a>
		</div>
		<div class="modalCard__availability">
			<a href="/" class="modalCard__link">Вернуться на главную</a>
		</div>

	</form>
</div>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/login.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/signUp.js"></script>