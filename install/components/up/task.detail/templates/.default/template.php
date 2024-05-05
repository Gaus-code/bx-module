<?php
/**
 * @var array $arResult
 * @var array $arParams
 */

global $USER;

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}
?>

<?php
if ($arResult['TASK'] && (!$arResult['TASK']->getIsBanned() || $USER->IsAdmin())): ?>
	<main class="detail wrapper">
		<div class="detail__mainContainer">
			<div class="detail__mainInfo">
				<section class="detail__header">
					<h1><?= htmlspecialcharsbx($arResult['TASK']->getTitle()) ?></h1>
					<div class="detail__tags">
						<p class="task__categories"><?= $arResult['TASK']->getCategory()->getTitle() ?></p>
						<?php
						foreach ($arResult['TASK']->getTags() as $tag): ?>
							<p class="task__tag">#<?= htmlspecialcharsbx($tag->getTitle()) ?></p>
						<?php
						endforeach; ?>
					</div>
				</section>
				<section class="detail__main">
					<div class="detail__description">
						<?= htmlspecialcharsbx($arResult['TASK']->getDescription()) ?>
					</div>
				</section>
			</div>


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
		<div class="detail__metaContainers">
			<div class="detail__metaContainer">
				<section class="metaContainer__header">
					<h2>Дополнительная информация</h2>
					<ul class="metaContainer__list">
						<li class="metaContainer__item">
							<p class="metaContainer__info">
								<span>Задача создана:</span>
								<?= $arResult['TASK']->getCreatedAt()->format('d.m.Y') ?>
							</p>
						</li>
						<li class="metaContainer__item">
							<p class="metaContainer__info">
								<span>Заказчик:</span>
								<a class="metaContainer__text" href="/profile/<?= $arResult['TASK']->getClient()->get('B_USER')->getId() ?>/">
									<?= htmlspecialcharsbx($arResult['TASK']->getClient()->get('B_USER')->getName()
										. ' '
										. $arResult['TASK']->getClient()->get('B_USER')->getLastName()) ?>
								</a>
							</p>
						</li>
						<li class="metaContainer__item">
							<div class="metaContainer__info">
								<span>Статус:</span>
								<p class="metaContainer__text"><?= $arResult['TASK']->getStatus() ?></p>
							</div>
						</li>
						<?php if (!empty($arResult['TASK']->getDeadline())): ?>
						<li class="metaContainer__item">
							<div class="metaContainer__info">
								<span>Дедлайн:</span>
								<p class="metaContainer__text"> <?= $arResult['TASK']->getDeadline() ?></p>
							</div>

						</li>
						<?php endif;?>
						<?php if (!empty($arResult['TASK']->getMaxPrice())): ?>
						<li class="metaContainer__item">
							<div class="metaContainer__info">
								<span>Цена:</span>
								<p class="metaContainer__text"> До <?= $arResult['TASK']->getMaxPrice() ?> ₽</p>
							</div>
						</li>
						<?php endif;?>
						<?php if (!empty($arResult['TASK']->getProject())): ?>
							<li class="metaContainer__item">
								<div class="metaContainer__info">
									<span>Проект:</span>
									<a class="metaContainer__text" href="/project/<?= $arResult['TASK']->getProject()->getId()?>/">
										<?= htmlspecialcharsbx($arResult['TASK']->getProject()->getTitle()) ?>
									</a>
								</div>
							</li>
						<?php endif;?>
					</ul>
				</section>
			</div>
			<section class="metaContainer__header">
				<?php if ($USER->IsAdmin()):?>
					<?php if (!$arResult['TASK']->getIsBanned()):?>
						<div class="metaContainer__item">
							<form  action="/task/block/" method="post" >
								<?= bitrix_sessid_post() ?>
								<input name="taskId" hidden="hidden" value="<?= $arResult['TASK']->getId() ?>">
								<button id="sendComplaint" class="banBtn" type="submit">Заблокировать заявку</button>
							</form>
						</div>
						<?php if (count($arResult['TASK']->getTags()) > 0): ?>
						<div class="metaContainer__item">
							<div class="detail__metaContainer">
								<form action="/tag/block/" method="post" >
									<?= bitrix_sessid_post() ?>
									<input name="taskId" hidden="hidden" value="<?= $arResult['TASK']->getId() ?>">
									<ul class="filter__list">
										<?php foreach ($arResult['TASK']->getTags() as $tag): ?>
											<li class="filter__item">
												<input type="checkbox" class="filter__checkbox" name="tagsId[]" value="<?=$tag->getId()?>">
												<label class="filter__label">#<?= htmlspecialcharsbx($tag->getTitle()) ?></label>
											</li>
										<?php endforeach; ?>
									</ul>
									<button id="sendComplaint" type="submit">Заблокировать тэги</button>
								</form>
							</div>
						</div>
						<?php endif; ?>
					<?php else :?>
						<div class="metaContainer__item">
							<form  action="/task/unblock/" method="post" >
								<?= bitrix_sessid_post() ?>
								<input name="taskId" hidden="hidden" value="<?= $arResult['TASK']->getId() ?>">
								<button id="sendComplaint" class="banBtn" type="submit">Разблокировать заявку</button>
							</form>
						</div>
					<?php endif; ?>
				<?php elseif ($arResult['USER_ACTIVITY'] !== 'owner' && $USER->IsAuthorized()) :?>
					<?php if (!$arResult['ISSET_REPORT'] ): ?>
						<div class="metaContainer__item">
							<button class="banBtn" type="button">Пожаловаться</button>
							<form class="banForm" action="/report/create/" method="post">
								<?= bitrix_sessid_post() ?>
								<button id="closeFormBtn" type="button">
									<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/cross.svg" alt="close form cross">
								</button>
								<input name="taskId" hidden="hidden" value="<?= $arResult['TASK']->getId() ?>">
								<input hidden="hidden" name="complaintType" value="task">
								<textarea class="complaintText" type="text" name="complaintMessage" placeholder="Пожалуйста, опишите проблему"></textarea>
								<button id="sendComplaint" type="submit">Отправить</button>
							</form>
						</div>
					<?php else: ?>
						<p class="banBtnIsSent">Вы уже отправили жалобу</p>
					<?php endif; ?>
				<?php endif; ?>
			</section>
			<?php $APPLICATION->IncludeComponent('up:task.detail.meta',
				$arResult['USER_ACTIVITY'],
				[
					'USER_ACTIVITY' => $arResult['USER_ACTIVITY'],
					'TASK' => $arResult['TASK'],
					'RESPONSE' => $arResult['RESPONSE'],
				]);
			?>
			<?php
			else: ?>
				<main class="detail wrapper">
					<section class="detail__header">
						<h1>Задача не найдена или заблокирована!</h1
					</section>
				</main>
			<?php
			endif; ?>
		</div>
	</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/banForm.js"></script>
