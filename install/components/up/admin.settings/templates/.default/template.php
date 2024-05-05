<?php
/**
 * @var array $arResult
 * @var array $arParams
 * @var CUser $USER
 * @var CMain $APPLICATION
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
			<h1>Администрирование</h1>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Настройки сайта</h2>
		</article>
		<article class="admin__settings">
			<h3>Настройка YandexGPT:</h3>
			<?php if ($arResult['ISSET_OPTIONS_YANDEX_GPT']):?>
			<p>YandexGPT уже подключен! Если хотите изменить настройки, введите данные:</p>
			<?php else:?>
				<p>YandexGPT еще не подключен! Внесите данные ниже для его подключения:</p>
			<?php endif;?>
			<form class="newOptionsYandexGPT__form" action="/admin/setting/newOptionsYandexGPT" method="post">
				<?= bitrix_sessid_post() ?>
				<div class="option__sites">
					<div class="option__site">
						<label>Секретный ключ:</label>
						<input type="text" name="secretKey" class="secret_key_input">
					</div>
					<div class="option__site">
						<label>Идентификатор каталога:</label>
						<input type="text" name="directoryId" class="directory_id_input">
					</div>
				</div>
			<button class="newOptionsYandexGPTBtn" type="submit">Задать новые настройки YandexGPT</button>
			</form>
		</article>
	</section>
</main>
