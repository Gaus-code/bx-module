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
<div class="detail__notify">
	<section class="detail__notifyHeader">
		<h2>Уведомления по заявке</h2>
		<ul class="detail__notifyList">
			<li class="detail__notifyItem">
				<p class="metaContainer__info">
					<span> Круто, ваш отклик подтвердили!</span>
				</p>
			</li>
			<li class="detail__notifyItem">
				<div class="detail__notifyInfo">
					<span>Контакты заказчика:</span>
					<p class="detail__notifyText"> <?= htmlspecialcharsbx($arParams['TASK']->getClient()->getContacts()) ?></p>
				</div>
			</li>
		</ul>
	</section>
</div>
<?php endif; ?>