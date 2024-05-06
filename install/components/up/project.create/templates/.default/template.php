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
	<?php $APPLICATION->IncludeComponent('up:user.aside', '', [
		'USER_ID' => $arParams['USER_ID'],
	]); ?>
	<section class="content">
		<article class="content__header header-border">
			<h1 id="quickCreate">Быстрое создание</h1>
			<div class="content__profileCreate">
				<a href="/project/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<?php $APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
		<article class="content__create">
			<h2>Создание проекта</h2>
			<div class="groupContainer">
				<form class="create__form" action="/project/create/" method="post">
					<?=bitrix_sessid_post()?>
					<input type="text" name="title" class="create__title" placeholder="Название проекта" style="margin-left: 60px" >
					<input type="text" name="description" class="create__description" placeholder="Описание проекта" style="margin-left: 60px" >
					<button class="createBtn" type="submit">Создать Проект</button>
				</form>
			</div>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>