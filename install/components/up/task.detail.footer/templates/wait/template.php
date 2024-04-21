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
		<span> Заказчик этой задачи уже получил уведомление, ждите его решения! </span>
		<p><span> Ваше отправленное письмо: </span></p>
		<p> <?=htmlspecialcharsbx($arParams['RESPONSE']->getDescription())  ?> </p>
	</div>
	<form action="/response/delete/" method="post">
		<?= bitrix_sessid_post() ?>
		<input hidden="hidden" name="responseId" value="<?= $arParams['RESPONSE']->getId() ?>">
		<button class="task__responseDelete" type="submit">Отменить отклик</button>
	</form>
</section>
