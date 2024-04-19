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
		<span> Вы владелец этой задачи! Хотите <a href="/task/<?= $arResult['TASK']->getId(
			) ?>/edit/"> отредактировать</a> ее?  </span>
	</div>
	<?php
	if ($arResult['TASK']->getStatus() === $arResult['TASK_STATUSES']['done']): ?>

		<p class="detail__feedback_title">Отзывы:</p>
		<?php
		if ($arResult['USER_FEEDBACK_FLAG']): ?>
			<form class="create__form" action="/feedback/create/" method="post">
				<?= bitrix_sessid_post() ?>
				<div class="create__container">
					<input name="toUserId" type="hidden" value="<?= $arResult['TASK']->GetId() ?>">
					<input name="fromUserId" type="hidden" value="<?= $USER->GetID() ?>">
					<input name="toUserId" type="hidden" value="<?= $USER->GetID() ?>">
					<div class="rating-area">
						<input type="radio" id="star-5" name="rating" value="5">
						<label for="star-5" title="Оценка «5»"></label>
						<input type="radio" id="star-4" name="rating" value="4">
						<label for="star-4" title="Оценка «4»"></label>
						<input type="radio" id="star-3" name="rating" value="3">
						<label for="star-3" title="Оценка «3»"></label>
						<input type="radio" id="star-2" name="rating" value="2">
						<label for="star-2" title="Оценка «2»"></label>
						<input type="radio" id="star-1" name="rating" value="1">
						<label for="star-1" title="Оценка «1»"></label>
					</div>
					<label class="create__textareaLabel" for="taskDescription">Комментарий</label>
					<textarea name="feedback" id="taskDescription" class="create__description" cols="30" rows="10"></textarea>
				</div>
				<button class="createBtn" type="submit">Оставить Отзыв</button>
			</form>
		<?php
		endif;
		foreach ($arResult['TASK']->getFeedbacks() as $feedback):?>
			<div class="detail__feedback">
				<p><?= $feedback->getFromUser()->getBUser()->getName() . ' ' . $feedback->getFromUser()->getBUser()
																						->getLastName() ?></p>
				<div class="rating-result">
					<?php
					for ($i = 1; $i <= 5; $i++)
					{
						if ($feedback->getRating() >= $i)
						{ ?>
							<span class="active"></span>
						<?php
						}
						else
						{ ?>
							<span></span>
						<?php
						}
					} ?>
				</div>
				<p><?= $feedback->getFeedback() ?></p>
			</div>
		<?php
		endforeach; ?>
	<?php
	endif; ?>

</section>