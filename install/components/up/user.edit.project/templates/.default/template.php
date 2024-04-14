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
				<a href="/create/project/<?=$arParams['USER_ID']?>/" class="create__link">Создать проект</a>
				<a href="/create/task/<?=$arParams['USER_ID']?>/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Редактирование проекта</h2>
		</article>
		<article class="content__editProject">
			<form action="/project/update/" method="post" class="create__form">
				<?= bitrix_sessid_post() ?>
				<input type="hidden" name="projectId" value='<?=$arParams['PROJECT_ID']?>'>
				<input type="text" class="content__editInput" name="title" placeholder="Название проекта" value="<?=$arParams['PROJECT']->getTitle()?>" required>
				<input type="text" class="content__editInput" name="description" placeholder="Описание проекта" value="<?=$arParams['PROJECT']->getDescription()?>" required>
				<div class="content__projectEditContainer">
					<h2>Редактируйте заявки в проекте</h2>
					<div class="tbl-header">
						<table>
							<thead>
							<tr>
								<th>Независимый порядок</th>
								<th class="test">Порядок Выполнения</th>
								<th>Название задачи</th>
								<th>Исполнитель</th>
								<th>Статус</th>
								<th>Дедлайн</th>
								<th>Удалить задачу</th>
							</tr>
							</thead>
						</table>
					</div>
					<div class="tbl-content">
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

									<td><?= $task->getTitle() ?></td>

									<?php
									if ($task->getContractor() !== null)
									{
										?>
										<td><?= $task->getContractor()->getName() ?></td>
										<?php
									}
									else
									{ ?>
										<td> Исполнителя нет</td> <?php
									}
									?>
									<td><?= $task->getStatus() ?></td>
									<td>Дедлайн</td>
									<td>
										<input class="deleteTask" type="checkbox" name="deleteTaskFlags[<?=$task->getId()?>]">
									</td>
								</tr>
								<?php
							} ?>
							</tbody>
						</table>
					</div>
				</div>
				<button class="createBtn" type="submit">Сохранить Изменения</button>
			</form>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/deleteTaskFromProject.js"></script>