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

<?php if ($arResult['TASK']): ?>
<main class="detail wrapper">
	<section class="detail__header">
		<h1><?= $arResult['TASK']->getTitle() ?></h1>
		<div class="detail__tags">
			<?php foreach ($arResult['TASK']->getTags() as $tag): ?>
				<p class="task__tag"><?= $tag->getTitle() ?></p>
			<?php endforeach; ?>
		</div>
	</section>
	<section class="detail__main">
		<div class="detail__description">
			<?= $arResult['TASK']->getDescription() ?>
		</div>
		<div class="detail__container">
			<div class="detail__priority"><?= $arResult['TASK']->getPriority() ?> приоритет</div>
			<div class="detail__status"><?= $arResult['TASK']->getStatus()->getTitle() ?></div>
		</div>
	</section>
	<section class="detail__footer">
		<div class="detail__client"><?= $arResult['TASK']->getClient()->getName() . ' ' . $arResult['TASK']->getClient()->getSurname() ?></div>
		<button class="detail__btn">Откликнуться</button>
	</section>
</main>
<?php else: ?>
	<main class="detail wrapper">
		<section class="detail__header">
			<h1>Задача не найдена!</h1
		</section>
	</main>
<?php endif; ?>
