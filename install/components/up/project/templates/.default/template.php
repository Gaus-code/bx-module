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
				<form action="/project/update/" method="post" class="editProject__form">
					<?= bitrix_sessid_post() ?>
					<input type="hidden" name="projectId" value='<?=$arParams['PROJECT_ID']?>'>
					<div class="userProject__title">
						<input type="text" class="content__editInput" name="title" placeholder="Название проекта" value="<?=htmlspecialcharsbx($arParams['PROJECT']->getTitle())?>" required>
					</div>
					<div class="userProject__main">
						<p class="userProject__description">
							<input type="text" class="content__editInput" name="description" placeholder="Описание проекта" value="<?=htmlspecialcharsbx($arParams['PROJECT']->getDescription())?>" required>
						</p>
					</div>
					<div class="content__projectEditContainer">
						<h2>Заявки в проекте:</h2>
						<div class="tbl-header">
							<table>
								<thead>
								<tr>
									<th>Независимый порядок</th>
									<th class="test">Порядок Выполнения</th>
									<th>Название задачи</th>
									<th>Исполнитель</th>
									<th>Статус</th>
									<th>Последние изменения</th>
									<th>Удалить задачу</th>
								</tr>
								</thead>
							</table>
						</div>
						<div class="tbl-content">
							<?php if (count($arParams['PROJECT']->getTasks()) > 0): ?>
								<table>
									<tbody>
									<?php
									foreach ($arParams['PROJECT']->getTasks() as $task)
									{
										?>
										<tr>
											<td>
												<input class="withoutPriority" type="checkbox" name="withoutPriorityFlags[<?=$task->getId()?>]" value="on" <?php if ($task->getProjectPriority()==0) { echo "checked";}?>>
											</td>
											<td>
												<input class="editTaskPriority" type="number" min="1" name="priorityNumbers[<?=$task->getId()?>]" value="<?=$task->getProjectPriority()?>">
											</td>

											<td><?=htmlspecialcharsbx($task->getTitle())  ?></td>

											<?php
											if ($task->getContractor() !== null)
											{
												?>
												<td><?= htmlspecialcharsbx($task->getContractor()->getBUser()->getName()) ?></td>
												<?php
											}
											else
											{ ?>
												<td> Исполнителя нет</td> <?php
											}
											?>
											<td><?= $task->getStatus() ?></td>
											<td><?= $task->getUpdatedAt() ?></td>
											<td>
												<input class="deleteTask" type="checkbox" name="deleteTaskFlags[<?=$task->getId()?>]">
											</td>
										</tr>
										<?php
									} ?>
									</tbody>
								</table>
							<?php else: ?>
								<p id="noTasks">у вас пока нет заявок в проекте</p>
							<?php endif; ?>
						</div>
					</div>
					<button class="createBtn" type="submit">Сохранить Изменения</button>
				</form>
			</div>
			<!-- Контейнер для добавления существующей заявки !-->
			<div id="addTask-reviews" class="content__nonPriorityContainer tab__container">
				<form action="" method="post" class="addTask__form">
					<fieldset>
						<legend>Выберите заявки для добавления в проект</legend>
						<?php if (isset($arResult['TASK'])): ?>
							<ul class="filter__list">
								<?php foreach ($arResult['TAGS'] as $task): ?>
									<li class="filter__item">
										<input type="checkbox" class="filter__checkbox" name="tagIds[<?=$task->getId()?>]" value="<?=$task->getId()?>">
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
				<form action="" method="post" class="createTask__form">
					<input type="text" placeholder="название заявки">
					<input type="text" placeholder="описание заявки">
					<button type="submit">Создать заявку</button>
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
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/deleteTaskFromProject.js"></script>