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
	<?php
	$APPLICATION->IncludeComponent('up:user.aside', '', [
		'USER_ID' => $arParams['USER_ID'],
	]); ?>
	<section class="content">
		<article class="content__header">
			<h1>Рабочая область</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner">+</span>
			</button>
			<div class="content__profileCreate">
				<a href="/project/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваш проект</h2>
		</article>
		<article class="content__userProject">
			<article class="content__editProject">



			</article>
			<article class="content__tagButtons">
				<div class="content__header">
					<ul class="content__tagList">
						<li id="edit-btn" class="content__tagItem">
							Редактировать заявки в проекте
						</li>
						<li id="addTask-btn" class="content__tagItem">
							Добавить существующую заявку
						</li>
						<li id="createTask-btn" class="content__tagItem active-tag-item">
							Создать заявку
						</li>
						<li id="delete-btn" class="content__tagItem">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/skull.svg" alt="">
							Удалить проект
						</li>
					</ul>
				</div>
			</article>
			<!-- Контейнер для редактирования проекта !-->
			<div id="edit-reviews" class="content__nonPriorityContainer tab__container">
				<div class="board">
					<form action="/project/add-stage/" method="post">
						<?= bitrix_sessid_post() ?>
						<input type="hidden" name="projectId" value="<?=$arParams['PROJECT_ID']?>">
						<button class="submitDrag" type="submit">Добавить этап(временное решение)</button>
					</form>
					<form action="/project/delete-stage/" method="post">
						<?= bitrix_sessid_post() ?>
						<input type="hidden" name="projectId" value="<?=$arParams['PROJECT_ID']?>">
						<button class="submitDrag" type="submit">удалить этап(временное решение)</button>
					</form>
					<form action="/project/update/" id="drag-form" method="post">
						<?= bitrix_sessid_post() ?>
						<input type="hidden" name="projectId" value="<?=$arParams['PROJECT_ID']?>">
						<button class="submitDrag" type="submit">Сохранить изменения</button>
						<div class="lanes">
							<?php foreach ($arResult['PROJECT']->getStages() as $stage):?>
							<div class="swim-lane" id="todo-lane" data-zone-id="<?=$stage->getId()?>">
								<h3 class="heading">
									<?php if($stage->getNumber()===0){echo "Независимые задачи";}
									else{echo $stage->getNumber()." этап";}?>
									<?php if ($stage->getExpectedCompletionDate()):?>
									<p>Окончание этапа: <?=$stage->getExpectedCompletionDate()?></p>
									<?php endif;?>

								</h3>
								<?php foreach ($stage->getTasks() as $task): ?>
								<div class="task" draggable="true">
<!--									<input type="hidden" name="stages[--><?php //=$stage->getId()?><!--][taskId]" value = "--><?php //=$task->getId()?><!--">-->
									<input type="hidden" name="tasks[<?=$task->getId()?>][zoneId]" value = "<?=$stage->getId()?>">
									<p><?=$task->getTitle()?></p>
									<p>Статус: <?=$task->getStatus()?></p>
									<?php if($task->getDeadline()):?>
									<p>Дедлайн: <?=$task->getDeadline()?></p>
									<?php endif;?>
									<input class="projectTaskDelete" type="checkbox" name="tasks[<?=$task->getId()?>][taskDelete]" >
								</div>
								<?php endforeach;?>
							</div>
							<?php endforeach;?>
						</div>
					</form>
				</div>
			</div>
			<!-- Контейнер для добавления существующей заявки !-->
			<div id="addTask-reviews" class="content__nonPriorityContainer tab__container">
				<form action="/project/add-tasks/" method="post" class="addTask__form">
					<?= bitrix_sessid_post() ?>
					<input type="hidden" name="projectId" value="<?=$arParams['PROJECT_ID']?>">
					<fieldset>
						<legend>Выберите заявки для добавления в проект</legend>
						<?php if (isset($arResult['ADD_TASK_LIST'])): ?>
							<ul class="filter__list">
								<?php foreach ($arResult['ADD_TASK_LIST'] as $task): ?>
									<li class="filter__item">
										<input type="checkbox" class="filter__checkbox" name="taskIds[<?=$task->getId()?>]" value="<?=$task->getId()?>">
										<label class="filter__label"><?=htmlspecialcharsbx($task->getTitle())?></label>
									</li>
								<?php endforeach; ?>
							</ul>
						<?php else: ?>
							<p class="empty">У вас пока нет заявок</p>
						<?php endif;?>
					</fieldset>
					<button type="submit">Добавить заявки</button>
				</form>
			</div>
			<!-- Контейнер для создания заявки сразу в проекте!-->
			<div id="createTask-reviews" class="content__priorityContainer tab__container">
				<form class="create__form" action="/task/create/" method="post">
					<?=bitrix_sessid_post()?>
					<input type="hidden" name="projectId" value="<?=$arParams['PROJECT_ID']?>">
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
					</div>
					<button class="createBtn" type="submit">Создать заявку</button>
				</form>
			</div>
			<!-- Контейнер для удаления проекта(работает!) !-->
			<div id="delete-reviews" class="content__nonPriorityContainer tab__container">
				<form action="/project/delete/" method="post" class="deleteTask__form">
					<?= bitrix_sessid_post() ?>
					<h4>Вы действительно хотите удалить проект?</h4>
					<input type="hidden" name="projectId" value='<?= $arParams['PROJECT_ID'] ?>'>
					<button class="deleteProject">
						Удалить проект
					</button>
				</form>
			</div>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/tabContainers.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/dragAndDrop.js"></script>