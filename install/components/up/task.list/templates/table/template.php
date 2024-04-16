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
<div class="content__tableTask">
	<?php if (count($arResult['TASKS']) > 0): ?>
	<?php foreach ($arResult['TASKS'] as $task): ?>
	<table id="taskTable">
		<thead>
		<tr>
			<th>Название заявки</th>
			<th>Описание заявки</th>
			<th>Дата создания заявки</th>
			<th>Исполнитель</th>
			<th>Статус</th>
			<th></th>
		</tr>
		</thead>
			<tbody>

				<tr>
					<td>
						<?= $task->getTitle() ?>
					</td>
					<td><?= $task->getDescription() ?></td>
					<td><?= $task->getCreatedAt()->format('d.m.Y') ?></td>
					<?php if (!empty($task->getContractorId())): ?>
					<td><?= $task->getContractorId() ?></td>
					<?php else:?>
					<td>В поиске исполнителя</td>
					<?php endif;?>
					<td><?= $task->getStatus() ?></td>
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
</div>

<?php
if ($arParams['CURRENT_PAGE'] !== 1 || $arParams['EXIST_NEXT_PAGE'])
{
	$APPLICATION->IncludeComponent('up:pagination', '', [
		'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE'],
	]);
}
?>


