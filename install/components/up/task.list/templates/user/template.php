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
<!-- Открытые заявки без исполнителя(УДАЛИ потом этот коммент) !-->
<div id="open-reviews" class="content__tableTask tab__container">
	<?php if (count($arResult['OPEN_TASKS']) > 0): ?>
	<table id="taskTable">
		<thead>
		<tr>
			<th>Название заявки</th>
			<th>Описание заявки</th>
			<th>Дата создания заявки</th>
			<th>Исполнитель</th>
			<?php if ($arParams['USER_ACTIVITY'] === 'owner'):?>
			<th></th>
			<?php endif;?>
		</tr>
		</thead>
			<tbody>
			<?php foreach ($arResult['OPEN_TASKS'] as $task): ?>
				<tr>
					<td>
						<a href="/task/<?= $task->getId() ?>/">
							<?= htmlspecialcharsbx($task->getTitle()) ?>
						</a>
					</td>
					<td><?= htmlspecialcharsbx($task->getDescription()) ?></td>
					<td><?= $task->getCreatedAt()->format('d.m.Y') ?></td>
					<td>В поиске исполнителя</td>
					<?php if ($arParams['USER_ACTIVITY'] === 'owner'):?>
					<td data-label="Редактировать">
						<a class="editTask" href="/task/<?= $task->getId() ?>/edit/">Редактировать заявку</a>
					</td>
					<?php endif;?>
				</tr>
				<?php endforeach; ?>
			</tbody>
	</table>
	<?php else: ?>
		<div class="contractor__emptyContainer">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoTasks.svg" alt="no tasks image">
			<p>Пока что тут нет заявок</p>
		</div>
	<?php endif; ?>
	<?php
	if ($arParams['CURRENT_PAGE'] !== 1 || $arParams['EXIST_NEXT_PAGE'])
	{
		$APPLICATION->IncludeComponent('up:pagination', '', [
			'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE'],
		]);
	}
	?>
</div>
<!-- Заявки с исполнителем(УДАЛИ потом этот коммент) !-->
<?php if ($arParams['USER_ACTIVITY'] === 'owner'):?>
<div id="inProgress-reviews" class="content__tableTask tab__container">
	<?php if (count($arResult['AT_WORK_TASKS']) > 0): ?>
		<table id="taskTable">
			<thead>
			<tr>
				<th>Название заявки</th>
				<th>Описание заявки</th>
				<th>Дата создания заявки</th>
				<th>Исполнитель</th>
				<th></th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($arResult['AT_WORK_TASKS'] as $task): ?>
				<tr>
					<td>
						<a href="/task/<?= $task->getId() ?>/">
							<?= htmlspecialcharsbx($task->getTitle()) ?>
						</a>
					</td>
					<td><?= htmlspecialcharsbx($task->getDescription()) ?></td>
					<td><?= $task->getCreatedAt()->format('d.m.Y') ?></td>
					<td>
						<a href="/profile/<?= $task->getContractorId() ?>/">
							<?= htmlspecialcharsbx($task->getContractor()->getBUser()->getName()
												   . ' ' . $task->getContractor()->getBUser()->getLastName()) ?>
						</a>
					</td>
					<td data-label="Редактировать">
						<a class="editTask" href="/task/<?= $task->getId() ?>/edit/">Редактировать заявку</a>
					</td>

				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
		<div class="contractor__emptyContainer">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoTasks.svg" alt="no tasks image">
			<p>Пока что тут нет заявок</p>
		</div>
	<?php endif; ?>
	<?php
	if ($arParams['CURRENT_PAGE'] !== 1 || $arParams['EXIST_NEXT_PAGE'])
	{
		$APPLICATION->IncludeComponent('up:pagination', '', [
			'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE'],
		]);
	}
	?>
</div>
<?php endif;?>
<!-- Завершенные заявки(УДАЛИ потом этот коммент) !-->
<div id="doneTask-reviews" class="content__tableTask tab__container">
	<?php if (count($arResult['DONE_TASKS']) > 0): ?>
		<table id="taskTable">
			<thead>
			<tr>
				<th>Название заявки</th>
				<th>Описание заявки</th>
				<th>Дата создания заявки</th>
				<th>Исполнитель</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($arResult['DONE_TASKS'] as $task): ?>
				<tr>
					<td>
						<a href="/task/<?= $task->getId() ?>/">
							<?= htmlspecialcharsbx($task->getTitle()) ?>
						</a>
					</td>
					<td><?= htmlspecialcharsbx($task->getDescription()) ?></td>
					<td><?= $task->getCreatedAt()->format('d.m.Y') ?></td>
					<td>
						<a href="/profile/<?= $task->getContractorId() ?>/">
							<?= htmlspecialcharsbx($task->getContractor()->getBUser()->getName()
												   . ' ' . $task->getContractor()->getBUser()->getLastName()) ?>
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
	<?php else: ?>
		<div class="contractor__emptyContainer">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoTasks.svg" alt="no tasks image">
			<p>Пока что тут нет заявок</p>
		</div>
	<?php endif; ?>
	<?php
	if ($arParams['CURRENT_PAGE'] !== 1 || $arParams['EXIST_NEXT_PAGE'])
	{
		$APPLICATION->IncludeComponent('up:pagination', '', [
			'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE'],
		]);
	}
	?>
</div>



