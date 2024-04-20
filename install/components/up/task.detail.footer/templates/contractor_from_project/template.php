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


<section class="detail__footer">
	<div class="detail__status">
		<span> Эта задача уже выполняется им:  </span>
		<p> Имя: <?= $arResult['CONTRACTOR']->getBUser()->getName() . ' ' .  $arResult['CONTRACTOR']->getBUser()->getLastName()?></p>
		<p> Как связаться: <?= $arResult['CONTRACTOR']->getContacts() ?></p>
	</div>
</section>