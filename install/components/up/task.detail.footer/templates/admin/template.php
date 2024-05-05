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
	<?php if ($arParams['TASK']->getFeedbacks() && count($arParams['TASK']->getFeedbacks()) > 0): ?>
			<p class="detail__feedback_title">Отзывы:</p>
		<?php foreach ($arParams['TASK']->getFeedbacks() as $feedback): ?>
			<div class="detail__feedback">
				<div class="feedback__header">
					<div class="feedback_names">
						<div class="feedback_from_to">
							<p>От:</p>
							<p>
								<?= htmlspecialcharsbx($feedback->getFromUser()->getBUser()->getName()
													   . ' ' .
													   $feedback->getFromUser()->getBUser()->getLastName() )?>
							</p>
						</div>
						<div class="feedback_from_to">
							<p>Кому:</p>
							<p>
								<?= htmlspecialcharsbx($feedback->getToUser()->getBUser()->getName()
													   . ' ' .
													   $feedback->getToUser()->getBUser()->getLastName() .' ('.$feedback->getToUserRole().')')?>
							</p>
						</div>
					</div>
					<div class="rating-result">
						<?php for ($i = 1; $i <= 5; $i++): ?>
							<?php if ($feedback->getRating() >= $i): ?>
								<span class="active"></span>
							<?php else : ?>
								<span></span>
							<?php endif; ?>
						<?php endfor; ?>
					</div>
				</div>
				<div class="feedback_comment">
					<p><?= htmlspecialcharsbx($feedback->getComment()) ?></p>
				</div>
				<?php if (!$feedback->getIsBanned()): ?>
					<form action="/feedback/block/" method="post">
						<?= bitrix_sessid_post() ?>
						<input name="taskId" hidden="hidden" value="<?=$arParams['TASK']->getId()?>">
						<input name="feedbackId" hidden="hidden" value="<?=$feedback->getId() ?>">
						<button id="sendComplaint" type="submit">Заблокировать отзыв</button>
					</form>
				<?php else: ?>
					<form  action="/feedback/unblock/" method="post" >
						<?= bitrix_sessid_post() ?>
						<input name="taskId" hidden="hidden" value="<?=$arParams['TASK']->getId()?>">
						<input name="feedbackId" hidden="hidden" value="<?=$feedback->getId() ?>">
						<button id="sendComplaint" class="banBtnforAdmin" type="submit">Разблокировать отзыв</button>
					</form>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>

</section>