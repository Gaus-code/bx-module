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
			<h1>Рабочая область</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner">+</span>
			</button>
			<div class="content__profileCreate">
				<a href="/project/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Редактирование заявки</h2>
		</article>
		<article class="content__editTask">
			<form action="" method="post" class="create__form">
				<div class="create__text">
					<div class="create__container">
						<label class="create__textareaLabel" for="createTitle">Редактируйте Название</label>
						<input name = "title" id="createTitle" type="text" class="create__title" placeholder="Название заявки" value="сюда вставить название">
					</div>
					<div class="create__container">
						<label class="create__textareaLabel" for="taskDescription">Редактируйте Описание</label>
						<textarea name="description" id="taskDescription" class="create__description" cols="30" rows="10">сюда вставить описание</textarea>
					</div>
					<div class="splitContainer">
						<div class="create__container">
							<label class="create__textareaLabel" for="createMaxPrice">Редактируйте максимальную стоимость</label>
							<input name = "maxPrice" id="createMaxPrice" type="number" class="create__title" value="сюда вставить максимальную стоимость">
						</div>
						<div class="create__container editTaskStatus">
							<label class="create__textareaLabel" for="createMaxPrice">Редактируйте статус заявки</label>
							<select class="editStatusSelect" name="status" id="">
								<option value="new">Новая</option>
								<option value="inProgress">Выполняется</option>
								<option value="stopped">Приостановлена</option>
								<option value="done">Сделана</option>
							</select>
						</div>
					</div>

					<div class="create__container">
						<fieldset>
							<legend>Редактируйте теги в заявке</legend>
							<?php if (isset($arResult['TAGS']) > 0): ?>
								<ul class="filter__list">
									<?php foreach ($arResult['TAGS'] as $tag): ?>
										<li class="filter__item">
											<input type="checkbox" class="filter__checkbox" name="tagIds[<?=$tag->getId()?>]" value="<?=$tag->getId()?>">
											<label class="filter__label"><?=$tag->getTitle()?></label>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php else: ?>
								<p class="empty">У вас пока нет тегов</p>
							<?php endif;?>
						</fieldset>
					</div>
				</div>
				<button class="editBtn" type="submit">Сохранить Изменения</button>
			</form>
			<form action="" method="post" class="deleteTask__form">
				<button class="deleteTask">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/skull.svg" alt="">
					Удалить заявку
				</button>
			</form>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>