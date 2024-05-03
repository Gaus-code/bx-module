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
	<div class="modalResponse">
		<?php $APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
	</div>
	<button class="responseBtn">Откликнуться</button>
	<form action="/response/create/" class="detail__form hidden" method="post">
		<button type="button" class="closeResponse">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/cross.svg" alt="close form cross">
		</button>
		<?= bitrix_sessid_post() ?>
		<input type="hidden" name="taskId" value="<?= $arParams['TASK']->getId() ?>">
		<label for="setPrice">Добавьте стоимость (₽):</label>
		<input name="price" id="setPrice" type="number" class="detail__setPrice validate" placeholder="Ваша цена">
		<label for="detail__coverLetter">Добавьте сопроводительное письмо:</label>
		<textarea id="detail__coverLetter" name="coverLetter"></textarea>
		<button class="detail__btn" type="submit">Откликнуться на заявку</button>
	</form>
</section>
<?php
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/validation.js");
?>