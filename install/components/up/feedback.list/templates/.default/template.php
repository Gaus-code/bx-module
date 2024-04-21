<?php
/**
 * @var array $arResult
 * @var array $arParams
 * @var CUser $USER
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

?>

<main class="profile__main">
	<?php $APPLICATION->IncludeComponent('up:user.aside', '', [
		'USER_ID' => $arParams['USER_ID'],
	]); ?>
	<section class="content">
		<?php if ($arResult['USER_ACTIVITY'] === 'owner'):?>
		<article class="content__header">
			<h1>Рабочая область</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner">+</span>
			</button>
			<div class="content__profileCreate">
				<a href="/project/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<?php endif;?>
		<article class="content__name">
			<h2 class="content__tittle">Отзывы</h2>
		</article>
		<div class="content__comment">
			<div class="comment__categories">
				<ul class="responses__tagList">
					<li id="contractor-btn" class="responses__tagItem active-tag-item">
						Полученные отзывы
					</li>
					<?php if ($arResult['USER_ACTIVITY'] === 'owner'):?>
					<li id="client-btn" class="responses__tagItem">
						Отправленные отзывы
					</li>
					<li id="waiting-btn" class="responses__tagItem">
						Ждут отзыва
					</li>
					<?php endif;?>
				</ul>
			</div>
			<!-- Отзывы, которые оставлены исполнителю(не забудь УДАЛИТЬ этот коммент) !-->
			<div id="contractor-reviews" class="tab__container contractor-reviews">
				<?php if (count($arResult['RECEIVE_FEEDBACKS']) > 0): ?>
					<ul class="clientComment__list">
						<?php foreach ($arResult['RECEIVE_FEEDBACKS'] as $feedback) :?>
							<li class="clientComment__item">
								<div class="comment__header">
									<a href="/task/<?= $feedback->getTaskId() ?>/"><p class="comment__title"><?= htmlspecialcharsbx($feedback->getTask()->getTitle()) ?></p></a>
									<div class="comment__rating">
										<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/star.svg" alt="star rating img">
										<p><?= $feedback->getRating() ?></p>
									</div>
								</div>
								<p class="comment__body"><?= htmlspecialcharsbx($feedback->getComment()) ?></p>
								<div class="comment__footer">
									<p class="comment__date"> <span>Опубликован: </span><?= $feedback->getCreatedAt() ?></p>
									<div class="comment__btnContainer">
										<img class="comment__userPhoto" src="<?= SITE_TEMPLATE_PATH ?>/assets/images/headerUser.svg" alt="contractor photo">
										<p><?= htmlspecialcharsbx($feedback->getFromUser()->getBUser()->getName() . ' ' . $feedback->getFromUser()->getBUser()->getLastName()) ?></p>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<!-- Отзывы, которые оставил сам исполнитель(не забудь УДАЛИТЬ этот коммент) !-->
			<?php if ($arResult['USER_ACTIVITY'] === 'owner'):?>
			<div id="client-reviews" class="tab__container client-reviews">
				<?php if (count($arResult['SENT_FEEDBACKS']) > 0): ?>
					<ul class="clientComment__list">
						<?php foreach ($arResult['SENT_FEEDBACKS'] as $feedback) :?>
							<li class="clientComment__item">
								<div class="comment__header">
									<a href="/task/<?= $feedback->getTaskId() ?>/"><p class="comment__title"><?= htmlspecialcharsbx($feedback->getTask()->getTitle())  ?></p></a>
									<div class="comment__rating">
										<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/star.svg" alt="star rating img">
										<p><?= $feedback->getRating() ?></p>
									</div>
								</div>
								<p class="comment__body"><?= htmlspecialcharsbx($feedback->getComment())  ?></p>
								<div class="comment__footer">
									<p class="comment__date"> <span>Опубликован:</span> <?= $feedback->getCreatedAt() ?></p>
									<div class="comment__btnContainer">
										<a href="/feedback/<?= $feedback->getId() ?>/edit/">Редактировать</a>
										<form method="post" action="/feedback/delete/">
											<?= bitrix_sessid_post() ?>
											<input hidden="hidden" name="feedbackId" value="<?= $feedback->getId() ?>">
											<button type="submit">Удалить</button>
										</form>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
					</ul>
				<?php endif; ?>
			</div>
			<!-- выполненные заявки, на которые ожидается отзыв(не забудь УДАЛИТЬ этот коммент) !-->
			<div id="waiting-reviews" class="tab__container waiting-reviews">
				<?php if (count($arResult['TASKS_WITHOUT_FEEDBACKS']) > 0) : ?>
				<ul class="clientComment__list">
					<?php foreach ($arResult['TASKS_WITHOUT_FEEDBACKS'] as $task) : ?>
					<li class="clientComment__item">
						<div class="comment__header">
							<p class="comment__waiting"> <?= htmlspecialcharsbx($task->getTitle())  ?> <span>выполнена</span></p>
							<a class="comment__waitingLink" href="/task/<?= $task->getId() ?>/">Оставить отзыв</a>
						</div>
					</li>
					<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</div>
			<?php endif;?>
		</div>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/tabContainers.js"></script>
