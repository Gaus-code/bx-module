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
			<?php if (count($arResult['TASKS']) > 0): ?>
			<?php foreach ($arResult['TASKS'] as $task): ?>
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
					<td><?= $task->getStatusId() ?>HARDCODE!(need to get name)</td>
					<td data-label="Редактировать">
						<a class="editTask" href="/edit/task/<?= $task->getId() ?>/">Редактировать заявку</a>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
	</table>
</div>

<?php
if ($arParams['CURRENT_PAGE'] !== 1 || $arParams['EXIST_NEXT_PAGE'])
{
	$APPLICATION->IncludeComponent('up:pagination', '', [
		'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE'],
	]);
}
?>
<?php else: ?>
	<div class="content__image">
		<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoTasks.svg" alt="no tasks image">
		<p>Пока что тут нет заявок</p>
	</div>
<?php endif; ?>
