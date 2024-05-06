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
<div
	<?php if ($arResult['USER_ACTIVITY'] === 'owner')
	{
		echo "id=\"openForOwner-reviews\"";
	}
	else {
		echo "id=\"open-reviews\"";
	}
	?>
	 class="content__tableTask tab__container">
	<?php if (count($arResult['OPEN_TASKS']) > 0): ?>
	<table id="taskTable">
		<thead>
		<tr>
			<th>Название заявки</th>
			<th>Категория</th>
			<th>Дата создания </th>
			<th>Исполнитель</th>
			<?php if ($arParams['USER_ACTIVITY'] === 'owner' && !$arResult['USER_IS_BANNED']):?>
			<th></th>
			<?php endif;?>
		</tr>
		</thead>
			<tbody>
			<?php foreach ($arResult['OPEN_TASKS'] as $task): ?>
				<tr>
					<td>
						<a class="taskViewLink" href="/task/<?= $task->getId() ?>/">
							<?= htmlspecialcharsbx($task->getTitle()) ?>
						</a>
					</td>
					<td><?= htmlspecialcharsbx($task->getCategory()->getTitle()) ?></td>
					<td><?= $task->getCreatedAt()->format('d.m.Y') ?></td>
					<td>В поиске исполнителя</td>
					<?php if ($arParams['USER_ACTIVITY'] === 'owner' && !$arResult['USER_IS_BANNED']):?>
					<td data-label="Редактировать">
						<a class="editTask" href="/task/<?= $task->getId() ?>/edit/">Редактировать заявку</a>
					</td>
					<?php endif;?>
				</tr>
				<?php endforeach; ?>
			</tbody>
	</table>
		<?php

		if ($arParams['CURRENT_PAGE' . '_OPEN_TASKS'] !== 1 || $arParams['EXIST_NEXT_PAGE' . '_OPEN_TASKS'])
		{
			$APPLICATION->IncludeComponent('up:pagination', '', [
				'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE' . '_OPEN_TASKS'],
				'NAME_OF_PAGE' => '_OPEN_TASKS',
			]);
		}
		?>
	<?php else: ?>
		<div class="contractor__emptyContainer">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoTasks.svg" alt="no tasks image">
			<p>Пока что тут нет заявок</p>
		</div>
	<?php endif; ?>

</div>
<!-- Заявки с исполнителем(УДАЛИ потом этот коммент) !-->
<?php if ($arParams['USER_ACTIVITY'] === 'owner'):?>
<div id="inProgress-reviews" class="content__tableTask tab__container">
	<?php if (count($arResult['AT_WORK_TASKS']) > 0): ?>
		<table id="taskTable">
			<thead>
			<tr>
				<th>Название заявки</th>
				<th>Категория</th>
				<th>Дата создания</th>
				<th>Исполнитель</th>
				<?php if ($arParams['USER_ACTIVITY'] === 'owner' && !$arResult['USER_IS_BANNED']):?>
				<th></th>
				<?php endif; ?>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($arResult['AT_WORK_TASKS'] as $task): ?>
				<tr>
					<td>
						<a class="taskViewLink" href="/task/<?= $task->getId() ?>/">
							<?= htmlspecialcharsbx($task->getTitle()) ?>
						</a>
					</td>
					<td><?= htmlspecialcharsbx($task->getCategory()->getTitle()) ?></td>
					<td><?= $task->getCreatedAt()->format('d.m.Y') ?></td>
					<td>
						<a class="taskViewLink" href="/profile/<?= $task->getContractorId() ?>/">
							<?= htmlspecialcharsbx($task->getContractor()->getBUser()->getName()
												   . ' ' . $task->getContractor()->getBUser()->getLastName()) ?>
						</a>
					</td>
					<?php if ($arParams['USER_ACTIVITY'] === 'owner' && !$arResult['USER_IS_BANNED']):?>
					<td data-label="Редактировать">
						<a class="editTask" href="/task/<?= $task->getId() ?>/edit/">Редактировать заявку</a>
					</td>
					<?php endif; ?>

				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php
		if ($arParams['CURRENT_PAGE' . '_AT_WORK_TASKS'] !== 1 || $arParams['EXIST_NEXT_PAGE' . '_AT_WORK_TASKS'])
		{
			$APPLICATION->IncludeComponent('up:pagination', '', [
				'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE' . '_AT_WORK_TASKS'],
				'NAME_OF_PAGE' => '_AT_WORK_TASKS',
			]);
		}
		?>
	<?php else: ?>
		<div class="contractor__emptyContainer">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoTasks.svg" alt="no tasks image">
			<p>Пока что тут нет заявок</p>
		</div>
	<?php endif; ?>
</div>
<?php endif;?>
<!-- Завершенные заявки(УДАЛИ потом этот коммент) !-->
<div
	<?php if ($arResult['USER_ACTIVITY'] === 'owner') {echo "id=\"doneTaskForOwner-reviews\"";}
	else {echo "id=\"doneTask-reviews\"";}?>
	class="content__tableTask tab__container">
	<?php if (count($arResult['DONE_TASKS']) > 0): ?>
		<table id="taskTable">
			<thead>
			<tr>
				<th>Название заявки</th>
				<th>Категория</th>
				<th>Дата создания</th>
				<th>Исполнитель</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($arResult['DONE_TASKS'] as $task): ?>
				<tr>
					<td>
						<a class="taskViewLink" href="/task/<?= $task->getId() ?>/">
							<?= htmlspecialcharsbx($task->getTitle()) ?>
						</a>
					</td>
					<td><?= htmlspecialcharsbx($task->getCategory()->getTitle()) ?></td>
					<td><?= $task->getCreatedAt()->format('d.m.Y') ?></td>
					<td>
						<a class="taskViewLink" href="/profile/<?= $task->getContractorId() ?>/">
							<?= htmlspecialcharsbx($task->getContractor()->getBUser()->getName()
												   . ' ' . $task->getContractor()->getBUser()->getLastName()) ?>
						</a>
					</td>
				</tr>
			<?php endforeach; ?>
			</tbody>
		</table>
		<?php
		if ($arParams['CURRENT_PAGE' . '_DONE_TASKS'] !== 1 || $arParams['EXIST_NEXT_PAGE' . '_DONE_TASKS'])
		{
			$APPLICATION->IncludeComponent('up:pagination', '', [
				'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE' . '_DONE_TASKS'],
				'NAME_OF_PAGE' => '_DONE_TASKS',
			]);
		}
		?>
	<?php else: ?>
		<div class="contractor__emptyContainer">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoTasks.svg" alt="no tasks image">
			<p>Пока что тут нет заявок</p>
		</div>
	<?php endif; ?>

</div>
<!-- Заявки в качестве исполнителя (УДАЛИ потом этот коммент) !-->
<?php if ($arParams['USER_ACTIVITY'] === 'owner'):?>
	<div id="performing-reviews" class="content__tableTask tab__container">
		<?php if (count($arResult['PERFORMING_TASKS']) > 0): ?>
			<table id="taskTable">
				<thead>
				<tr>
					<th>Название заявки</th>
					<th>Категория</th>
					<th>Описание заявки</th>
					<th>Дата создания заявки</th>
					<th>Заказчик</th>
					<?php if ($arParams['USER_ACTIVITY'] === 'owner' && !$arResult['USER_IS_BANNED']):?>
						<th></th>
					<?php endif; ?>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($arResult['PERFORMING_TASKS'] as $task): ?>
					<tr>
						<td>
							<a class="taskViewLink" href="/task/<?= $task->getId() ?>/">
								<?= htmlspecialcharsbx($task->getTitle()) ?>
							</a>
						</td>
						<td><?= $task->getCategory()->getTitle() ?></td>
						<td><?= htmlspecialcharsbx($task->getDescription()) ?></td>
						<td><?= $task->getCreatedAt()->format('d.m.Y') ?></td>
						<td>
							<a class="taskViewLink" href="/profile/<?= $task->getContractorId() ?>/">
								<?= htmlspecialcharsbx($task->getClient()->getBUser()->getName()
													   . ' ' . $task->getClient()->getBUser()->getLastName()) ?>
							</a>
						</td>
						<?php if ($arParams['USER_ACTIVITY'] === 'owner' && !$arResult['USER_IS_BANNED']):?>
							<td data-label="Редактировать">
								<a class="editTask" href="/task/<?= $task->getId() ?>/">Открыть заявку</a>
							</td>
						<?php endif; ?>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php
			if ($arParams['CURRENT_PAGE' . '_PERFORMING_TASKS'] !== 1 || $arParams['EXIST_NEXT_PAGE' . '_PERFORMING_TASKS'])
			{
				$APPLICATION->IncludeComponent('up:pagination', '', [
					'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE' . '_PERFORMING_TASKS'],
					'NAME_OF_PAGE' => '_PERFORMING_TASKS',
				]);
			}
			?>
		<?php else: ?>
			<div class="contractor__emptyContainer">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoTasks.svg" alt="no tasks image">
				<p>Пока что тут нет заявок</p>
			</div>
		<?php endif; ?>
	</div>
<?php endif;?>
<!-- Заявки приостановленные (УДАЛИ потом этот коммент) !-->
<?php if ($arParams['USER_ACTIVITY'] === 'owner'):?>
	<div id="stop-reviews" class="content__tableTask tab__container">
		<?php if (count($arResult['STOP_TASKS']) > 0): ?>
			<table id="taskTable">
				<thead>
				<tr>
					<th>Название заявки</th>
					<th>Категория</th>
					<th>Описание заявки</th>
					<th>Дата создания заявки</th>
					<?php if ($arParams['USER_ACTIVITY'] === 'owner' && !$arResult['USER_IS_BANNED']):?>
						<th></th>
					<?php endif; ?>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($arResult['STOP_TASKS'] as $task): ?>
					<tr>
						<td>
							<a class="taskViewLink" href="/task/<?= $task->getId() ?>/">
								<?= htmlspecialcharsbx($task->getTitle()) ?>
							</a>
						</td>
						<td><?= $task->getCategory()->getTitle() ?></td>
						<td><?= htmlspecialcharsbx($task->getDescription()) ?></td>
						<td><?= $task->getCreatedAt()->format('d.m.Y') ?></td>

						<?php if ($arParams['USER_ACTIVITY'] === 'owner' && !$arResult['USER_IS_BANNED']):?>
							<?php if ($task->getStatus() === \Up\Ukan\Service\Configuration::getOption('task_status')['waiting_to_start'] ):?>
								<td data-label="Редактировать">
									<a class="editTask" href="/task/<?= $task->getId() ?>/edit/">Редактировать заявку</a>
								</td>
							<?php else: ?>

								<td data-label="Редактировать">
									<a class="editTask" href="/project/<?= $task->getProject()->getId() ?>/">Открыть в проекте</a>
								</td>
							<?php endif; ?>
						<?php endif; ?>

					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
			<?php
			if ($arParams['CURRENT_PAGE' . '_STOP_TASKS'] !== 1 || $arParams['EXIST_NEXT_PAGE' . '_STOP_TASKS'])
			{
				$APPLICATION->IncludeComponent('up:pagination', '', [
					'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE' . '_STOP_TASKS'],
					'NAME_OF_PAGE' => '_STOP_TASKS',
				]);
			}
			?>
		<?php else: ?>
			<div class="contractor__emptyContainer">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoTasks.svg" alt="no tasks image">
				<p>Пока что тут нет заявок</p>
			</div>
		<?php endif; ?>
	</div>
<?php endif;?>


