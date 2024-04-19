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
	<form action="/response/create/" class="detail__form" method="post">
		<?= bitrix_sessid_post() ?>
		<input type="hidden" name="taskId" value="<?= $arResult['TASK']->getId() ?>">
		<input type="hidden" name="clientId" value="<?= $arResult['TASK']->getClientId() ?>">
		<label for="setPrice">Добавьте стоимость:</label>
		<input name="price" required id="setPrice" type="number" class="create__title" placeholder="Ваша цена">
		<label for="detail__coverLetter">Добавьте сопроводительное письмо:</label>
		<textarea id="detail__coverLetter" name="coverLetter"></textarea>
		<button class="detail__btn" type="submit">Откликнуться</button>
	</form>
</section>