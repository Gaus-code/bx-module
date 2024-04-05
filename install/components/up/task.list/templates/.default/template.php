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

<?php foreach ($arResult['TASKS'] as $task): ?>
	<div href="/task/<?= $task->getId() ?>/" class="task">
		<a href="/task/<?= $task->getId() ?>/" class="task__link">
			<div class="task__header">
				<?php foreach ($task->getTags() as $tag): ?>
					<p class="task__tag"><?= $tag->getTitle() ?></p>
				<?php endforeach; ?>
				<div class="task__edit">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="edit task">
				</div>
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
					<button class="task__respond__btn">Откликнуться</button>
				</div>
			<?php endif; ?>
		</div>
	</div>
<?php endforeach; ?>