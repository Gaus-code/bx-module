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
<?php foreach ($arResult['TASK'] as $task): ?>
<main class="detail wrapper">
	<section class="detail__header">
		<h1><?= $task['TITLE'] ?></h1>
		<div class="detail__tags">
			<?php foreach ($task['TAGS'] as $tag): ?>
				<p class="task__tag"><?= $tag ?></p>
			<?php endforeach; ?>
		</div>
	</section>
	<section class="detail__main">
		<div class="detail__description">
			<?= $task['DESCRIPTION'] ?>
		</div>
		<div class="detail__container">
			<div class="detail__priority"><?= $task['PRIORITY'] ?> приоритет</div>
			<div class="detail__status"><?= $task['STATUS'] ?></div>
		</div>
	</section>
	<section class="detail__footer">
		<div class="detail__client"><?= $task['CLIENT'] ?></div>
		<button class="detail__btn">Откликнуться</button>
	</section>
</main>
<?php endforeach; ?>