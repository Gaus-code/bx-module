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
				<h1><?= htmlspecialcharsbx($arResult['TASK']->getTitle()) ?></h1>
				<div class="detail__tags">
					<p class="task__categories"><?= $arResult['TASK']->getCategory()->getTitle() ?></p>
					<?php
					foreach ($arResult['TASK']->getTags() as $tag): ?>
						<p class="task__tag"><?= htmlspecialcharsbx($tag->getTitle()) ?></p>
					<?php
					endforeach; ?>
				</div>
			</section>
			<section class="detail__main">
				<div class="detail__description">
					<?= htmlspecialcharsbx($arResult['TASK']->getDescription()) ?>
				</div>
				<div class="detail__container">
					<div class="detail__status"><?= $arResult['TASK']->getStatus() ?></div>
				</div>
				<?php if (!empty($arResult['TASK']->getMaxPrice())): ?>
				<div class="detail__container">
					<div class="detail__status">до <?= $arResult['TASK']->getMaxPrice() ?> ₽</div>
				</div>
				<?php endif;?>
			</section>

			<?php if ($USER->IsAuthorized()): ?>
			<?php $APPLICATION->IncludeComponent('up:task.detail.footer',
												 ($arResult['USER_ACTIVITY']),
												 [
													'USER_ACTIVITY' => $arResult['USER_ACTIVITY'],
													'TASK' => $arResult['TASK'],
													'RESPONSE' => $arResult['RESPONSE'],
												]);
			?>
			<?php endif; ?>
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
							<?= htmlspecialcharsbx($arResult['TASK']->getClient()->get('B_USER')->getName()
												   . ' '
												   . $arResult['TASK']->getClient()->get('B_USER')->getLastName()) ?>
						</p>
					</li>
					<?php if ($USER->IsAdmin()):?>
						<li class="metaContainer__item">
							<form class="banForm" action="">
								<button type="submit">Заблокировать</button>
							</form>
						</li>
					<?php else :?>
						<?php if (!$arResult['ISSET_REPORT']): ?>
						<li class="metaContainer__item">
							<button class="banBtn" type="button">Пожаловаться</button>
							<form class="banForm" action="/report/create/" method="post">
								<?= bitrix_sessid_post() ?>
								<button id="closeFormBtn" type="button">
									<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/cross.svg" alt="close form cross">
								</button>
								<input name="toTaskId" hidden="hidden" value="<?= $arResult['TASK']->getId() ?>">
								<ul class="complaint__list">
									<li class="complaint__item">
										<input class="complaint__radio" type="radio" name="complaintType" value="task" checked>
										<label class="complaint__label">Пожаловаться на заявку</label>
									</li>
									<li class="complaint__item">
										<input class="complaint__radio" type="radio" name="complaintType" value="feedback">
										<label class="complaint__label">Пожаловаться на комментарий</label>
									</li>
									<li class="complaint__item">
										<input class="complaint__radio" type="radio" name="complaintType" value="other">
										<label class="complaint__label">Другое</label>
									</li>
								</ul>
								<textarea class="complaintText" type="text" name="complaintMessage" placeholder="Пожалуйста, опишите проблему"></textarea>
								<button id="sendComplaint" type="submit">Отправить</button>
							</form>
						</li>
						<?php else :?>
							<p class="banBtn">Вы уже отправили жалобу, ждите решение администрации</p>
						<?php endif; ?>
					<?php endif; ?>
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
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/banForm.js"></script>
