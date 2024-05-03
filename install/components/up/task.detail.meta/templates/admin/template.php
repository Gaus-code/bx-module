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
<?php if ($arParams['TASK']->getContractor()): ?>
	<div class="detail__metaContainers">
		<div class="detail__metaContainer">
			<section class="metaContainer__header">
				<h2>Дополнительная информация 2</h2>
				<ul class="metaContainer__list">
					<li class="metaContainer__item">
						<p class="metaContainer__info">
							<span>Исполнитель:</span>
							<a class="metaContainer__text" href="/profile/<?= $arParams['TASK']->getContractor()->getId() ?>/">
								<?= htmlspecialcharsbx($arParams['TASK']->getContractor()->getBUser()->getName()
													   . ' '
													   . $arParams['TASK']->getContractor()->getBUser()->getLastName()) ?>
							</a>
						</p>
					</li>
				</ul>
			</section>
		</div>
	</div>
<?php endif;?>