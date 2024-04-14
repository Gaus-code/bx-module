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
<div class="content__main">
	<?php if (count($arResult['TASKS']) > 0): ?>
		<?php foreach ($arResult['TASKS'] as $task): ?>
			<div href="/task/<?= $task->getId() ?>/" class="task">
				<a href="/task/<?= $task->getId() ?>/" class="task__link">
					<div class="task__header">
						<?php foreach ($task->getTags() as $tag): ?>
							<p class="task__tag"><?= $tag->getTitle() ?></p>
						<?php endforeach; ?>
					</div>
					<div class="task__main">
						<h3><?= $task->getTitle() ?></h3>
						<p class="task__description"><?= $task->getDescription() ?></p>
					</div>
				</a>
				<div class="task__footer">

					<?php if (!$arParams['IS_PERSONAL_ACCOUNT_PAGE']): ?>
						<div class="task__footer_img">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
							<p><?= $task->getClient()->getName() . ' ' . $task->getClient()->getSurname() ?></p>
						</div>
						<div class="task__respond">
							<a href="/task/<?= $task->getId() ?>/" class="task__link">
								<button class="task__respond__btn">Откликнуться</button>
							</a>
						</div>
					<?php endif; ?>
				</div>
			</div>
		<?php endforeach; ?>
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

