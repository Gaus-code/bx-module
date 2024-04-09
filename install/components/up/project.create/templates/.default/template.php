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
			<h1>Создание проекта</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner">+</span>
			</button>
			<div class="content__profileCreate">
				<a href="/create/project/<?=$USER->GetID()?>/" class="create__link">Создать проект</a>
				<a href="/create/task/<?=$USER->GetID()?>/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__create">
			<form class="create__form" action="" method="post">
				<?=bitrix_sessid_post()?>
				<input type="text" name="title" class="create__title" placeholder="Название проекта">
				<input type="text" name="description" class="create__description" placeholder="Описание проекта">
				<button class="createBtn" type="submit">Создать Проект</button>
	<!--			<fieldset>-->
	<!--				<legend>Добавьте Заявки К Проеку</legend>-->
	<!--				<ul class="filter__list">-->
	<!--					--><?php //for ($i=0; $i<9; $i++): ?>
	<!--						<li class="filter__item">-->
	<!--							<input type="checkbox" class="filter__checkbox">-->
	<!--							<label class="filter__label">Какая-то сущестующая заявка</label>-->
	<!--						</li>-->
	<!--					--><?php //endfor; ?>
	<!--				</ul>-->
	<!--			</fieldset>-->
			</form>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>