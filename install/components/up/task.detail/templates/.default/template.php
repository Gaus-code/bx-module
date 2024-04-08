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
	<div class="detail__mainContainer">
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
			<form action="" class="detail__form">
				<label for="detail__coverLetter">Добавьте сопроводительное письмо:</label>
				<textarea id="detail__coverLetter" name="coverLetter"></textarea>
				<button class="detail__btn" type="submit">Откликнуться</button>
			</form>
		</section>
	</div>
	<div class="detail__metaContainer">
		<section class="metaContainer__header">
			<h2>Дополнительная информация:</h2>
			<ul class="metaContainer__list">
				<li class="metaContainer__item">
					<p class="metaContainer__info">
						<span>Задача создана:</span>
						08.04.2024 в 12:57
					</p>
				</li>
				<li class="metaContainer__item">
					<p class="metaContainer__info">
						<span>Исполнитель:</span>
						<?= $arResult['TASK']->getClient()->getName() . ' ' . $arResult['TASK']->getClient()->getSurname() ?>
					</p>
				</li>
			</ul>
		</section>
	</div>
</main>
<?php else: ?>
	<main class="detail wrapper">
		<section class="detail__header">
			<h1>Задача не найдена!</h1
		</section>
	</main>
<?php endif; ?>
