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

<?php
if ($arResult['TASK']): ?>
	<main class="detail wrapper">
		<div class="detail__mainContainer">
			<section class="detail__header">
				<h1><?= htmlspecialcharsbx($arResult['TASK']->getTitle()) ?></h1>
				<div class="detail__tags">
					<?php
					foreach ($arResult['TASK']->getTags() as $tag): ?>
						<p class="task__tag"><?= htmlspecialcharsbx($tag->getTitle()) ?></p>
					<?php
					endforeach; ?>
				</div>
			</section>
			<section class="detail__main">
				<div class="detail__description">
					<?= htmlspecialcharsbx($arResult['TASK']->getDescription()) ?>
				</div>
				<div class="detail__container">
					<div class="detail__status"><?= $arResult['TASK']->getStatus() ?></div>
				</div>
			</section>

			<?php if ($USER->IsAuthorized()): ?>
			<?php $APPLICATION->IncludeComponent('up:task.detail.footer',
												 ($arResult['USER_ACTIVITY']),
												 [
													'USER_ACTIVITY' => $arResult['USER_ACTIVITY'],
													'TASK' => $arResult['TASK'],
													'RESPONSE' => $arResult['RESPONSE'],
												]);
			?>
			<?php endif; ?>
		</div>
		<div class="detail__metaContainer">
			<section class="metaContainer__header">
				<h2>Дополнительная информация:</h2>
				<ul class="metaContainer__list">
					<li class="metaContainer__item">
						<p class="metaContainer__info">
							<span>Задача создана:</span>
							<?= $arResult['TASK']->getCreatedAt() ?>
						</p>
					</li>
					<li class="metaContainer__item">
						<p class="metaContainer__info">
							<span>Заказчик:</span>
							<?= htmlspecialcharsbx($arResult['TASK']->getClient()->get('B_USER')->getName()
												   . ' '
												   . $arResult['TASK']->getClient()->get('B_USER')->getLastName()) ?>
						</p>
					</li>
				</ul>
			</section>
		</div>
	</main>
<?php
else: ?>
	<main class="detail wrapper">
		<section class="detail__header">
			<h1>Задача не найдена!</h1
		</section>
	</main>
<?php
endif; ?>
