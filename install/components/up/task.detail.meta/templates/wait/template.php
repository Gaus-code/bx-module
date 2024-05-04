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

<div class="detail__notify">
	<section class="detail__notifyHeader">
		<h2>Уведомления по заявке</h2>
		<ul class="detail__notifyList">
			<li class="detail__notifyItem">
				<p class="metaContainer__info">
					<span> Заказчик уже получил ваш отклик!</span>
				</p>
			</li>
			<li class="detail__notifyItem">
				<div class="detail__notifyInfo">
					<span>Ваше отправленное письмо:</span>
					<p class="detail__notifyText"> <?=htmlspecialcharsbx($arParams['RESPONSE']->getDescription())  ?> </p>
				</div>
			</li>
		</ul>
	</section>
</div>
