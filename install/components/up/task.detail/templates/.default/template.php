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

<?php
if ($arResult['TASK']): ?>
	<main class="detail wrapper">
		<div class="detail__mainContainer">
			<section class="detail__header">
				<h1><?= $arResult['TASK']->getTitle() ?></h1>
				<div class="detail__tags">
					<?php
					foreach ($arResult['TASK']->getTags() as $tag): ?>
						<p class="task__tag"><?= $tag->getTitle() ?></p>
					<?php
					endforeach; ?>
				</div>
			</section>
			<section class="detail__main">
				<div class="detail__description">
					<?= $arResult['TASK']->getDescription() ?>
				</div>
				<div class="detail__container">
					<div class="detail__status"><?= $arResult['TASK']->getStatus() ?></div>
				</div>
			</section>
			<section class="detail__footer">
				<section class="detail__footer">
					<?php
					switch ($arResult['TASK']->getStatus()):
						case $arResult['TASK_STATUSES']['done']:
							?>
							<p class="detail__feedback_title">Отзывы:</p>
							<?php
							if ($arResult['USER_FEEDBACK_FLAG'])
							{ ?>
								<form class="create__form" action="/feedback/create/" method="post">
									<?= bitrix_sessid_post() ?>
									<div class="create__container">
										<input name="toUserId" type="hidden" value="<?=$arResult['TASK']->GetId()?>">
										<input name="fromUserId" type="hidden" value="<?=$USER->GetID()?>">
										<input name="toUserId" type="hidden" value="<?=$USER->GetID()?>">
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
							}
							foreach ($arResult['TASK']->getFeedbacks() as $feedback):?>
								<div class="detail__feedback">
									<p><?= $feedback->getFromUser()->getBUser()->getName()
										. ' '
										. $feedback->getFromUser()->getBUser()->getLastName() ?></p>
									<div class="rating-result">
										<?php for ($i=1;$i<=5;$i++)
											{
												if ($feedback->getRating()>=$i)
												{ ?>
													<span class="active"></span>
												<?php }
												else
												{ ?>
													<span></span>
												<?php }
											}?>
									</div>
									<p><?= $feedback->getFeedback() ?></p>
								</div>
							<?php
							endforeach;
							break;
						default:
							switch ($arResult['USER_ACTIVITY']):
								case 'owner': ?>
									<div class="detail__status">
										<span> Вы владелец этой задачи! Хотите <a href="/task/<?= $arResult['TASK']->getId(
											) ?>/edit/"> отредактировать</a> ее?  </span>
									</div>
									<?php
									break;
								case 'wait approve this user': ?>
									<div class="detail__status">
										<span> Заказчик этой задачи уже получил уведомление, ждите его решения! </span>
									</div>
									<?php
									break;
								case 'approved this user': ?>
									<div class="detail__status">
										<span> Круто, ваш отклик подтвердили! Заказчик ждет, что Вы с ним свяжетесь! </span>
									</div>
									<?php
									break;
								case 'approved other user': ?>
									<div class="detail__status">
										<span> К сожалению, эту задачу уже кто-то выполняет </span>
									</div>
									<?php
									break;
								default: ?>
									<form action="/response/create/" class="detail__form" method="post">
										<?= bitrix_sessid_post() ?>
										<input type="hidden" name="taskId" value="<?= $arResult['TASK']->getId() ?>">
										<label for="setPrice">Добавьте стоимость:</label>
										<input name="price" required id="setPrice" type="number" class="create__title" placeholder="Ваша цена">
										<label for="detail__coverLetter">Добавьте сопроводительное письмо:</label>
										<textarea id="detail__coverLetter" name="coverLetter"></textarea>
										<button class="detail__btn" type="submit">Откликнуться</button>
									</form>
								<?php
							endswitch;
					endswitch;
					?>
				</section>
		</div>
		<div class="detail__metaContainer">
			<section class="metaContainer__header">
				<h2>Дополнительная информация:</h2>
				<ul class="metaContainer__list">
					<li class="metaContainer__item">
						<p class="metaContainer__info">
							<span>Задача создана:</span>
							<?= $arResult['TASK']->getCreatedAt() ?>
						</p>
					</li>
					<li class="metaContainer__item">
						<p class="metaContainer__info">
							<span>Заказчик:</span>
							<?= $arResult['TASK']->getClient()->get('B_USER')->getName()
							. ' '
							. $arResult['TASK']->getClient()->get('B_USER')->getLastName() ?>
						</p>
					</li>
				</ul>
			</section>
		</div>
	</main>
<?php
else: ?>
	<main class="detail wrapper">
		<section class="detail__header">
			<h1>Задача не найдена!</h1
		</section>
	</main>
<?php
endif; ?>
