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
<main class="profile__main">
	<?php $APPLICATION->IncludeComponent('up:user.aside', '', [
		'USER_ID' => $arParams['USER_ID'],
	]); ?>
	<section class="content">
		<article class="content__header">
			<h1>Создание Заявки</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner">+</span>
			</button>
			<div class="content__profileCreate">
				<a href="/project/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__create">
			<form class="create__form" action="/task/create/" method="post">
				<?=bitrix_sessid_post()?>
				<div class="create__text">
					<div class="create__container">
						<label class="create__textareaLabel" for="createTitle">Добавьте Название</label>
						<input name = "title" id="createTitle" type="text" class="create__title" placeholder="Название заявки">
					</div>
					<div class="create__container">
						<label class="create__textareaLabel" for="taskDescription">Добавьте Описание</label>
						<textarea name="description" id="taskDescription" class="create__description" cols="30" rows="10"></textarea>
					</div>
					<div class="create__container">
						<label class="create__textareaLabel" for="createMaxPrice">Добавьте максимальную стоимость</label>
						<input name = "maxPrice" id="createMaxPrice" type="number" class="create__title" placeholder="Максимальная стоимость">
					</div>
				</div>
				<li class="filter__item">
					<input class="filter__checkbox" name = "useGPT" type = "checkbox">
					<label class="filter__label">Автоматичемкое проставление тегов по описанию</label>
				</li>
				<div class="create__fieldsetContainer">
					<fieldset>
						<legend>Добавьте Теги</legend>
						<?php if (count($arResult['TAGS']) > 0): ?>
						<ul class="filter__list">
							<?php foreach ($arResult['TAGS'] as $tag): ?>
								<li class="filter__item">
									<input type="checkbox" class="filter__checkbox" name="tagIds[<?=$tag->getId()?>]" value="<?=$tag->getId()?>">
									<label class="filter__label"><?=htmlspecialcharsbx($tag->getTitle())?></label>
								</li>
							<?php endforeach; ?>
						</ul>
						<?php else: ?>
							<p class="empty">У вас пока нет тегов</p>
						<?php endif;?>
					</fieldset>
					<fieldset>
						<legend>Выберите Проект</legend>
						<?php if (count($arResult['PROJECTS']) > 0): ?>
						<ul class="filter__list">
							<?php foreach ($arResult['PROJECTS'] as $project): ?>
								<li class="filter__item">
									<input type="radio" class="filter__checkbox" name="projectId" value="<?=$project->getId()?>">
									<label class="filter__label"><?=htmlspecialcharsbx($project->getTitle())?></label>
								</li>
							<?php endforeach; ?>
						</ul>
						<?php else: ?>
							<div class="emptyContainer">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoProjects.svg" alt="no projects image">
								<p class="empty">У вас пока нет проектов</p>
							</div>
						<?php endif;?>
					</fieldset>
				</div>
				<button class="createBtn" type="submit">Создать заявку</button>
			</form>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>