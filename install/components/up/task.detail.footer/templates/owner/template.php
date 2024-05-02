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
		<span> Вы владелец этой задачи! Хотите <a href="/task/<?= $arParams['TASK']->getId() ?>/edit/"> отредактировать</a> ее?  </span>
	</div>

	<?php if ($arParams['TASK']->getStatus() === $arParams['TASK_STATUSES']['search_contractor']): ?>
		<?php if (count($arResult['RESPONSES']) > 0): ?>
			<div class="detail__status">
				<p> Вы можете просмотреть несколько ваших откликов здесь!</p>
				<p> (Хотите посмотреть все? Тогда нажмите <a href="/profile/<?= $arParams['USER_ID']?>/responses/?show=receive&filter=wait&q=<?= $arParams['TASK']->getTitle() ?>"> сюда </a> )</p>
			</div>
			<?php foreach ($arResult['RESPONSES'] as $response): ?>
				<div href="/task/<?= $response->getTask()->getId() ?>/" class="task__response">
					<a href="/task/<?= $response->getTask()->getId() ?>/" class="task__link">
						<div class="task__responseMain">
							<p class="task__responseCreated">
								<span>Дата отклика:</span> <?= $response->getCreatedAt() ?> </p>
							<p class="task__responseCreated">
								<span>Предложенная цена:</span> <?= $response->getPrice() ?> </p>
							<p class="task__responseCreated">
								<span>Исполнитель:</span> <?= htmlspecialcharsbx($response->getContractor()->getBUser()->getName()
																				 . ' ' . $response->getContractor()->getBUser()->getLastName()) ?> </p>
							<p class="task__responseCreated">
								<span>Сопроводительное письмо:</span> <?= htmlspecialcharsbx($response->getDescription()) ?> </p>
						</div>
					</a>
					<div class="task__responseFooter">
						<form action="/response/approve/" method="post">
							<?= bitrix_sessid_post() ?>
							<input hidden="hidden" name="taskId" value="<?= $response->getTaskId() ?>">
							<input hidden="hidden" name="contractorId" value="<?= $response->getContractorId() ?>">
							<button class="task__responseDelete" type="submit">Одобрить отклик</button>
						</form>
						<form action="/response/reject/" method="post">
							<?= bitrix_sessid_post() ?>
							<input hidden="hidden" name="taskId" value="<?= $response->getTaskId() ?>">
							<input hidden="hidden" name="contractorId" value="<?= $response->getContractorId() ?>">
							<button class="task__responseDelete" type="submit">Отклонить отклик</button>
						</form>
					</div>
				</div>
			<?php endforeach; ?>
		<?php endif; ?>
	<?php endif; ?>

	<?php if ($arParams['TASK']->getStatus() === $arParams['TASK_STATUSES']['at_work']): ?>
		<div class="detail__status">
			<span> Отлично, Ваша задача имеет исполнителя! Если Вы с ним еще не связались, то скорее сделайте это! </span>
			<p> Вот его имя и контакты: </p> <?= htmlspecialcharsbx($arResult['CONTRACTOR']->getBUser()->getName()
																	. ' ' .
																	$arResult['CONTRACTOR']->getBUser()->getLastName()) ?>
			<p> <?= $arResult['CONTRACTOR']->getContacts() ?> </p>
		</div>
		<form action="/task/finish/" method="post">
			<?= bitrix_sessid_post() ?>
			<input name="taskId" type="hidden" value="<?= $arParams['TASK']->GetId() ?>">
			<button class="createBtn" type="submit">Завершить задачу!</button>
		</form>
	<?php endif; ?>

	<?php if ($arParams['TASK']->getStatus() === $arParams['TASK_STATUSES']['done']): ?>
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
										   $feedback->getFromUser()->getBUser()->getLastName() )?>
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
				<p><?= htmlspecialcharsbx($feedback->getComment()) ?></p>
				<?php if (!$feedback->getIsBanned()): ?>
					<?php if ($feedback->getFromUserId() === $arParams['USER_ID'] ): ?>
						<div class="rating-result">
							<a href="/feedback/<?=$feedback->getId() ?>/edit/">Отредактировать отзыв</a>
						</div>
					<?php elseif (!$arResult['ISSET_REPORT']): ?>
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
						<p class="banBtn">Вы уже отправили жалобу</p>
					<?php endif; ?>
				<?php endif; ?>
			</div>
		<?php endforeach; ?>
	<?php endif; ?>

</section>