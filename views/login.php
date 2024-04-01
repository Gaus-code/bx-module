<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");
?>
<div class="modal" id="authModal">
	<div class="modalCard" id="logInModalContainer">
		<ul class="modal__list">
			<li class="modal__item activeModalItem">
				<p class="modal__link activeModalLink">Войти</p>
			</li>
			<li class="modal__item">
				<p class="modal__link">Создать аккаунт</p>
			</li>
		</ul>
		<h2 class="modalCard__title">Войти в UKAN</h2>
		<div class="modalResponse"></div>
		<form class="modalCard__form" action="/login/" method="post">
			<div class="modalField">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/email.svg" alt="click and write your E-mail" class="modalField__img">
				<input class="modalCard__form_input" autocomplete="off" type="text" name="email" maxlength="100" placeholder="Почта">
				<div class="modalCard__error"></div>
			</div>
			<div class="modalField">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/key.svg" alt="click and write your Password" class="modalField__img">
				<input class="modalCard__form_input password" autocomplete="off" type="password"  maxlength="200" name="password" placeholder="Пароль">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/eye.svg" alt="show your password in the screen" class="modalField__eye">
				<div class="modalCard__error requiredError"></div>
			</div>
			<button id="logInButton" class="modalCard__btn" type="submit">Войти</button>
			<div class="modalCard__availability">
				<button class="modalCard__availability_btn">У меня нет аккаунта</button>
			</div>
			<div class="modalCard__availability">
				<a href="/" class="modalCard__link">Вернуться на главную</a>
			</div>
		</form>
	</div>
	<!--Sign up Form-->
	<div class="modalCard signUp">
		<ul class="modal__list">
			<li class="modal__item">
				<p class="modal__link">Войти</p>
			</li>
			<li class="modal__item activeModalItem">
				<p class="modal__link activeModalLink">Создать аккаунт</p>
			</li>
		</ul>
		<h2 class="modalCard__title">Создать аккаунт в UKAN</h2>
		<div class="modalResponse"></div>
		<form class="modalCard__form formForSignUp" action="/registration/" method="post">
			<div class="modalField__role">
				<input class="modalCard__radio" id="client-radio" type="radio" name="role">
				<label for="client-radio">Я заказчик</label>

				<input class="modalCard__role" id="executer-radio" type="radio" name="role">
				<label for="executer-radio">Я исполнитель</label>
				<div class="modalCard__error"></div>
			</div>
			<div class="modalField">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="click and write your name" class="modalField__img">
				<input class="modalCard__form_input" autocomplete="off" type="text" name="userName" maxlength="30" placeholder="Имя">
				<div class="modalCard__error"></div>
			</div>
			<div class="modalField">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="click and write your surname" class="modalField__img">
				<input class="modalCard__form_input" autocomplete="off" type="text" name="userSurname"  maxlength="30" placeholder="Фамилия">
				<div class="modalCard__error"></div>
			</div>
			<div class="modalField">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/email.svg" alt="click and write your E-mail" class="modalField__img">
				<input class="modalCard__form_input" autocomplete="off" type="text" name="email" maxlength="100" placeholder="Почта">
				<div class="modalCard__error"></div>
			</div>
			<div class="modalField">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/key.svg" alt="click and write your Password" class="modalField__img">
				<input class="modalCard__form_input password" autocomplete="off" type="password" maxlength="200" name="password" placeholder="Пароль">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/eye.svg" alt="show your password in the screen" class="modalField__eye">
				<div class="modalCard__error"></div>
			</div>
			<button class="modalCard__btn" type="submit">Создать Аккаунт</button>
		</form>
		<div class="modalCard__availability">
			<button class="modalCard__availability_btn">У меня уже есть аккаунт</button>
		</div>
		<div class="modalCard__availability">
			<a href="/" class="modalCard__link">Вернуться на главную</a>
		</div>
	</div>
</div>
<script type="module" src="<?= SITE_TEMPLATE_PATH ?>/assets/js/login.js"></script>