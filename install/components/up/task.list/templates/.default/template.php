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
	<div href="/task/<?= $task['ID'] ?>/" class="task">
		<a href="/task/<?= $task['ID'] ?>/" class="task__link">
			<div class="task__header">
				<?php foreach ($task['TAGS'] as $tag): ?>
					<p class="task__tag"><?= $tag ?></p>
				<? endforeach; ?>
			</div>
			<div class="task__main">
				<h3><?= $task['TITLE'] ?></h3>
				<p class="task__description"><?= $task['DESCRIPTION'] ?></p>
			</div>
		</a>
		<div class="task__footer">
			<div class="task__footer_img">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
				<p><?= $task['CLIENT'] ?></p>
			</div>
			<div class="task__respond">
				<button class="task__respond__btn">Откликнуться</button>
			</div>
		</div>
	</div>
<?php endforeach; ?>