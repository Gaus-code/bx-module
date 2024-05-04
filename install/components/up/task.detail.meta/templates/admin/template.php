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
<div class="detail__notify">
	<section class="detail__notifyHeader">
		<h2>Уведомления по заявке</h2>
		<ul class="detail__notifyList">
			<li class="detail__notifyItem">
				<p class="detail__notifyInfo">
					<span>Исполнитель:</span>
					<a class="detail__notifyText" href="/profile/<?= $arParams['TASK']->getContractor()->getId() ?>/">
						<?= htmlspecialcharsbx($arParams['TASK']->getContractor()->getBUser()->getName()
											   . ' '
											   . $arParams['TASK']->getContractor()->getBUser()->getLastName()) ?>
					</a>
				</p>
			</li>
		</ul>
	</section>
</div>
<?php endif;?>