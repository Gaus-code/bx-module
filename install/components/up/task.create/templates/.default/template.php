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
				<span class="plus-link__inner"></span>
			</button>
			<div class="content__profileCreate">
				<a href="/project/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__create">
			<div class="modalResponse">
				<?php $APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
			</div>

			<form class="create__form" action="/task/create/" method="post">
				<?=bitrix_sessid_post()?>
				<h2>Обязательные поля:</h2>
				<div class="create__text">
					<div class="create__container">
						<label class="create__textareaLabel" for="createTitle">Добавьте Название</label>
						<input name = "title" id="createTitle" type="text" class="create__title validate" placeholder="Название заявки">
					</div>
					<div class="create__container">
						<label class="create__textareaLabel" for="taskDescription">Добавьте Описание</label>
						<textarea name="description" id="taskDescription" class="create__description validate" cols="30" rows="10"></textarea>
					</div>
					<div class="create__containers">
						<div class="create__dateContainer">
							<label class="create__textareaLabel" for="deadline">Установите крайний срок</label>
							<input name="deadline" id="deadline" type="date" class="create__dateInput validate">
						</div>
						<select class="create__category" name="categoryId" id="">
							<option selected disabled>Выберите категорию</option>
							<?php foreach ($arResult['CATEGORIES'] as $category): ?>
								<option value="<?=$category->getId()?>"><?=htmlspecialcharsbx($category->getTitle())?></option>
							<?php endforeach; ?>
						</select>
					</div>
					<h2>Дополнительные поля:</h2>

					<div class="create__container">
						<label class="create__textareaLabel">Добавьте тэги (используя #)</label>
						<input name = "tagsString" class="create__title" placeholder="#HTML #CSS #...">
					</div>
				</div>


				<div class="create__fieldsetContainer">
					<div class="create__containers">
						<div class="create__dateContainer">
							<label class="create__textareaLabel" for="createMaxPrice">Добавьте максимальную стоимость (₽)</label>
							<input name="maxPrice" id="createMaxPrice" class="create__priceInput" type="number" placeholder="Максимальная стоимость">
						</div>
						<?php if (count($arResult['PROJECTS']) > 0): ?>
							<select name="projectId">
								<option selected disabled>Выберите Проект</option>
								<?php foreach ($arResult['PROJECTS'] as $project): ?>
									<option value="<?=$project->getId()?>"><?=htmlspecialcharsbx($project->getTitle())?></option>
								<?php endforeach; ?>
							</select>
						<?php endif;?>
					</div>
				</div>
				<button class="createBtn" type="submit">Создать заявку</button>
			</form>
			<div class="gptCreate">
				<form action="" method="post" class="premium-link-tag">
					<?=bitrix_sessid_post()?>
					<input class="filter__checkbox" name = "useGPT" type = "checkbox">
					<button type="submit">Автоматическое проставление тегов по описанию</button>
				</form>
			</div>
		</article>
	</section>
</main>

<?php
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/validation.js");
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/localStorageForActions.js");
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/profile.js");
?>
