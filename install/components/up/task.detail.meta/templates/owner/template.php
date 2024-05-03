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

<?php if ($arParams['TASK']->getStatus() === $arParams['TASK_STATUSES']['at_work']): ?>
	<div class="detail__metaContainers">
		<div class="detail__metaContainer">
			<section class="metaContainer__header">
				<h2>Дополнительная информация 2</h2>
				<ul class="metaContainer__list">
					<li class="metaContainer__item">
						<p class="metaContainer__info">
							<span> Хотите <a href="/task/<?= $arParams['TASK']->getId() ?>/edit/"> отредактировать</a> задачу?  </span>
						</p>
					</li>
					<li class="metaContainer__item">
						<div class="metaContainer__info">
							<span>Исполнитель:</span>
							<p class="metaContainer__text"> <?= htmlspecialcharsbx($arParams['TASK']->getContractor()->getBUser()->getName() . ' ' . $arParams['TASK']->getContractor()->getBUser()->getLastName()) ?></p>
						</div>
					</li>
					<li class="metaContainer__item">
						<div class="metaContainer__info">
							<span>Контакты исполнителя:</span>
							<p class="metaContainer__text"> <?= htmlspecialcharsbx($arParams['TASK']->getContractor()->getContacts()) ?></p>
						</div>
					</li>
				</ul>
			</section>
		</div>
	</div>
<?php endif; ?>
