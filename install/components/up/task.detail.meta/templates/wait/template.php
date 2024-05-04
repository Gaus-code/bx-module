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

<div class="detail__metaContainers">
	<div class="detail__metaContainer">
		<section class="metaContainer__header">
			<h2>Дополнительная информация 2</h2>
			<ul class="metaContainer__list">
				<li class="metaContainer__item">
					<p class="metaContainer__info">
						<span> Заказчик уже получил уведомление!</span>
					</p>
				</li>
				<li class="metaContainer__item">
					<div class="metaContainer__info">
						<span>Ваше отправленное письмо:</span>
						<p class="metaContainer__text"> <?=htmlspecialcharsbx($arParams['RESPONSE']->getDescription())  ?> </p>
					</div>
				</li>
			</ul>
		</section>
	</div>
</div>
