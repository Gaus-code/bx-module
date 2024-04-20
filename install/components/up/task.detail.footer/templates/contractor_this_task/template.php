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
			<p> Вот его имя и контакты: </p> <?= $arResult['CLIENT']->getBUser()->getName()
			. ' ' .
			$arResult['CLIENT']->getBUser()->getLastName() ?>
			<p> <?= $arResult['CLIENT']->getContacts() ?> </p>
		</div>
	<?php else: ?>
		<p class="detail__feedback_title">Отзывы:</p>
		<?php if (!$arResult['USER_SENT_FEEDBACK']): ?>
			<form class="create__form" action="/feedback/create/" method="post">
				<?= bitrix_sessid_post() ?>
				<div class="create__container">
					<input name="toUserId" type="hidden" value="<?= $arParams['TASK']->GetId() ?>">
					<input name="fromUserId" type="hidden" value="<?= $USER->GetID() ?>">
					<input name="toUserId" type="hidden" value="<?= $USER->GetID() ?>">
					<div class="rating-area">
						<?php for ($rating = 5; $rating > 0; $rating--): ?>
							<input type="radio" id="star-<?= $rating ?>" name="rating" value="<?= $rating ?>">
							<label for="star-<?= $rating ?>" title="Оценка «<?= $rating ?>»"></label>
						<?php endfor; ?>
					</div>
					<label class="create__textareaLabel" for="taskDescription">Комментарий</label>
					<textarea name="feedback" id="taskDescription" class="create__description" cols="30" rows="10"></textarea>
				</div>
				<button class="createBtn" type="submit">Оставить Отзыв</button>
			</form>
		<?php endif; ?>
		<?php foreach ($arParams['TASK']->getFeedbacks() as $feedback): ?>
			<div class="detail__feedback">
				<p>
					<?= $feedback->getFromUser()->getBUser()->getName()
					. ' ' .
					$feedback->getFromUser()->getBUser()->getLastName() ?>
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
				<p><?= $feedback->getFeedback() ?></p>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>
</section>