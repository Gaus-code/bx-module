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
	<?php if ($arParams['TASK']->getStatus() !== $arParams['TASK_STATUSES']['done']): ?>
		<div class="detail__status">
			<span> Круто, ваш отклик подтвердили! Если Вы еще не связались с заказчиком, скорее сделайте это! </span>
			<p> Вот его имя и контакты: </p> <?= htmlspecialcharsbx($arResult['CLIENT']->getBUser()->getName()
																	. ' ' .
																	$arResult['CLIENT']->getBUser()->getLastName()) ?>
			<p> <?= htmlspecialcharsbx($arResult['CLIENT']->getContacts()) ?> </p>
		</div>
	<?php else: ?>
		<div class="modalResponse">
			<?php $APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
		</div>
		<p class="detail__feedback_title">Отзывы:</p>
		<?php if (!$arResult['USER_SENT_FEEDBACK']): ?>
			<form class="comment__form" action="/feedback/create/" method="post">
				<?= bitrix_sessid_post() ?>
				<div class="create__container">
					<input name="taskId" type="hidden" value="<?= $arParams['TASK']->GetId() ?>">
					<input name="toUserId" type="hidden" value="<?= $arResult['LEAVE_FEEDBACK_FORM']['TO_USER_ID'] ?>">
					<input name="fromUserId" type="hidden" value="<?= $arResult['LEAVE_FEEDBACK_FORM']['FROM_USER_ID'] ?>">
					<div class="rating-area">
						<?php for ($rating = 5; $rating > 0; $rating--): ?>
							<input type="radio" id="star-<?= $rating ?>" name="rating" value="<?= $rating ?>">
							<label for="star-<?= $rating ?>" title="Оценка «<?= $rating ?>»"></label>
						<?php endfor; ?>
					</div>
					<label class="create__textareaLabel" for="taskDescription">Комментарий</label>
					<textarea name="comment" id="taskDescription" class="create__description" cols="30" rows="10"></textarea>
				</div>
				<button class="createBtn" type="submit">Оставить Отзыв</button>
			</form>
		<?php endif; ?>
		<?php foreach ($arParams['TASK']->getFeedbacks() as $feedback): ?>
			<div class="detail__feedback">
				<p>
					<?= htmlspecialcharsbx($feedback->getFromUser()->getBUser()->getName()
										   . ' ' .
										   $feedback->getFromUser()->getBUser()->getLastName()) ?>
				</p>
				<div class="rating-result">
					<?php for ($i = 1; $i <= 5; $i++): ?>
						<?php if ($feedback->getRating() >= $i): ?>
							<span class="active"></span>
						<?php else : ?>
							<span></span>
						<?php endif; ?>
					<?php endfor; ?>
				</div>
				<p class="commentText"><?=htmlspecialcharsbx($feedback->getComment())  ?></p>
				<?php if ($feedback->getFromUserId() === $arParams['USER_ID'] ): ?>
					<?php if (!$feedback->getIsBanned() ): ?>
						<div class="rating-result">
							<a href="/feedback/<?=$feedback->getId() ?>/edit/">Отредактировать отзыв</a>
						</div>
					<?php endif; ?>
				<?php elseIf (!$arResult['ISSET_REPORT']): ?>
					<button class="banBtn" type="button">Пожаловаться</button>
					<form class="banForm" action="/report/create/" method="post">
						<?= bitrix_sessid_post() ?>
						<button id="closeFormBtn" type="button">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/cross.svg" alt="close form cross">
						</button>
						<input name="taskId" hidden="hidden" value="<?=$arParams['TASK']->getId()?>">
						<input name="feedbackId" hidden="hidden" value="<?=$feedback->getId() ?>">
						<input hidden="hidden" name="complaintType" value="feedback">
						<textarea class="complaintText" type="text" name="complaintMessage" placeholder="Пожалуйста, опишите проблему"></textarea>
						<button id="sendComplaint" type="submit">Отправить</button>
					</form>
				<?php else: ?>
					<p class="banBtnIsSent">Вы уже отправили жалобу</p>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</section>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/banForm.js"></script>