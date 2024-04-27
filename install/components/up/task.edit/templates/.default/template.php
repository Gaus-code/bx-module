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
		<article class="content__header">
			<h1>Рабочая область</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner"></span>
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
			<div class="modalResponse">
				<?php $APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
			</div>
			<form action="/task/update/" method="post" class="create__form">
				<?=bitrix_sessid_post()?>
				<input type="hidden" name="taskId" value="<?=$arParams['TASK_ID']?>">
				<div class="create__text">
					<div class="create__container">
						<label class="create__textareaLabel" for="createTitle">Редактируйте Название</label>
						<input name = "title" id="createTitle" type="text" class="create__title" placeholder="Название заявки" value="<?=htmlspecialcharsbx($arResult['TASK']->getTitle())?>" required>
					</div>
					<div class="create__container">
						<label class="create__textareaLabel" for="taskDescription">Редактируйте Описание</label>
						<textarea name="description" id="taskDescription" class="create__description" cols="30" rows="10" required><?=htmlspecialcharsbx($arResult['TASK']->getDescription())?></textarea>
					</div>
					<div class="splitContainer">
						<div class="create__container">
							<label class="create__textareaLabel" for="createMaxPrice">Редактируйте максимальную стоимость (₽)</label>
							<input name = "maxPrice" id="createMaxPrice" type="number" class="create__title" value="<?php if ($arResult['TASK']->getMaxPrice()) {echo $arResult['TASK']->getMaxPrice();} ?>">
						</div>
					</div>
					<div class="create__container">
						<label class="create__textareaLabel" for="deadline">Установите крайний срок</label>
						<input name = "deadline" id="deadline" type="date" class="create__title" value="<?=$arResult['TASK']->getDeadline()->format("Y-m-d")?>">
					</div>
					<div class="filter__item">
						<input class="filter__checkbox" name = "useGPT" type = "checkbox">
						<label class="filter__label">Автоматическое проставление тегов по описанию</label>
					</div>
					<div class="create__container">
						<fieldset>
							<legend>Редактируйте теги в заявке</legend>
							<input name = "tagsString" id="createMaxPrice"  class="create__title" placeholder="#HTML #CSS #..." value="<?= $arResult['TAGS_STRING'] ?>">
						</fieldset>
						<fieldset>
							<legend>Выберите категорию</legend>
							<?php if (count($arResult['CATEGORIES']) > 0): ?>
								<ul class="filter__list">
									<?php foreach ($arResult['CATEGORIES'] as $category): ?>
										<li class="filter__item">
											<input type="radio" class="filter__checkbox" name="categoryId" value="<?=$category->getId()?>"
												<?= ($arResult['TASK']->getCategoryId() === $category->getId()) ? 'checked' : '' ?>>
											<label class="filter__label"><?=htmlspecialcharsbx($category->getTitle())?></label>
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
						<fieldset>
							<legend>Выберите Проект</legend>
							<?php if (count($arResult['PROJECTS']) > 0): ?>
								<ul class="filter__list">
									<?php foreach ($arResult['PROJECTS'] as $project): ?>
										<li class="filter__item">
											<input type="radio" class="filter__checkbox" name="projectId" value="<?=$project->getId()?>"
												<?php if ($arResult['TASK']->getProject() && $arResult['TASK']->getProject()->getId()===$project->getId()) { echo 'checked'; } ?>>
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
				</div>
				<button class="editBtn" type="submit">Сохранить Изменения</button>
			</form>
			<?php if ($arResult['TASK']->getStatus() === \Up\Ukan\Service\Configuration::getOption('task_status')['search_contractor']):?>
			<form action="/task/stop-search-contractor/" method="post" class="deleteTask__form">
				<?=bitrix_sessid_post()?>
				<input type="hidden" name="taskId" value="<?=$arParams['TASK_ID']?>">
				<button class="deleteTask">
					Приостановить поиск исполнителя
				</button>
			</form>
			<?php endif;?>
			<form action="/task/delete/" method="post" class="deleteTask__form">
				<?=bitrix_sessid_post()?>
				<input type="hidden" name="taskId" value="<?=$arParams['TASK_ID']?>">
				<button class="deleteTask">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/skull.svg" alt="">
					Удалить заявку
				</button>
			</form>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>