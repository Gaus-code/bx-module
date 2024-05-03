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
		<article class="content__header">
			<h1>Рабочая область</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner"></span>
			</button>
			<div class="content__profileCreate">
				<a href="/project/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<div class="content__projectDetail">
				<h2 class="project__title"><?= htmlspecialcharsbx($arResult['PROJECT']->getTitle()) ?></h2>
				<p class="project__description"><?= htmlspecialcharsbx($arResult['PROJECT']->getDescription()) ?></p>
			</div>
		</article>
		<article class="content__project">
			<a class="project__link" href="/project/<?=$arParams['PROJECT_ID']?>/edit/">
				Перейти к настройке проекта
			</a>
			<form action="/project/complete/" method="post">
				<?= bitrix_sessid_post() ?>
				<input type="hidden" name="projectId" value="<?=$arParams['PROJECT_ID']?>">
				<button class="project__stageBtn" type="submit">Завершить проект</button>
			</form>
			<div class="project__categories">
				<ul class="project__tagList">
					<li id="activeStage-btn" class="project__tagItem active-tag-item">
						Активный этап
					</li>
					<li id="independentStage-btn" class="project__tagItem">
						Независимый этап
					</li>
					<li id="futureStage-btn" class="project__tagItem">
						Будущий этап
					</li>
					<li id="closedStage-btn" class="project__tagItem">
						Завершенные этапы
					</li>
				</ul>
			</div>
			<?php $APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
			<div id="activeStage-reviews" class="tab__container">
				<?php if (count($arResult['ACTIVE_STAGE']) > 0): ?>
					<?php foreach ($arResult['ACTIVE_STAGE'] as $stage): ?>
					<?php if ($stage->getStatus() === 'Активен') {
						$hasActiveStage = true;
						?>
						<form class="project__stageForm" action="/stage/complete/" method="post">
							<?=bitrix_sessid_post()?>
							<input type="hidden" name="stageId" value="<?= $stage->getId() ?>">
							<button type="submit" class="project__stageBtn">
								Завершить <span>этап <?= $stage->getNumber() ?></span> ?
							</button>
						</form>
						<?php
					}
					if (!$hasActiveStage) {
						?>
						<form class="project__stageForm" action="/stage/start/" method="post">
							<?=bitrix_sessid_post()?>
							<input type="hidden" name="stageId" value="<?= $stage->getId() ?>">
							<button type="submit" class="project__stageBtn">
								Начать <span>этап <?= $stage->getNumber() ?></span> ?
							</button>
						</form>
						<?php
					}
						?>
					<?php endforeach; ?>
					<table class="rounded-corners">
						<thead>
						<tr>
							<th>Название заявки в этапе</th>
							<th>Описание</th>
							<th>Статус</th>
							<th>Дедлайн</th>
						</tr>
						</thead>
						<tbody>
						<?php foreach ($arResult['ACTIVE_STAGE'] as $stage): ?>
						<?php if ($stage->getStatus() === 'Активен') {
							$hasActiveStage = true;
							?>
							<?php foreach ($stage->getTasks() as $task):?>
						<tr>
							<td><?= $task->getTitle() ?></td>
							<td><?= $task->getDescription() ?></td>
							<td><?= $task->getStatus() ?></td>
							<td><?= $task->getDeadline() ?></td>
						</tr>
							<?php endforeach;?>
							<?php
						}
						if (!$hasActiveStage) {
							?>
							<?php foreach ($stage->getTasks() as $task):?>
								<tr>
									<td><?= $task->getTitle() ?></td>
									<td><?= $task->getDescription() ?></td>
									<td><?= $task->getStatus() ?></td>
									<td><?= $task->getDeadline() ?></td>
								</tr>
							<?php endforeach;?>
							<?php
						}
							?>
						<?php endforeach;?>
						</tbody>
					</table>
				<?php else:?>
				<div class="emptyStage">
					<p>У вас пока нет активных этапов</p>
					<a class="project__link" href="/project/<?=$arParams['PROJECT_ID']?>/edit/">Перейти к планированию проекта</a>
				</div>
				<?php endif;?>
			</div>
			<div id="independentStage-reviews" class="tab__container nonPriorityContainer">
				<table class="rounded-corners">
					<thead>
					<tr>
						<th>Название заявки в этапе</th>
						<th>Описание</th>
						<th>Статус</th>
						<th>Дедлайн</th>
						<th>Действия</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($arResult['INDEPENDENT_STAGE'] as $stage): ?>
						<?php foreach ($stage->getTasks() as $task):?>
					<tr>

						<td><?= $task->getTitle() ?></td>
						<td><?= $task->getDescription() ?></td>
						<td><?= $task->getStatus() ?></td>
						<td><?= $task->getDeadline() ?></td>
						<td>
							<form action="" method="post">
								<button class="project__stageBtn" type="submit">Возобновить задачу</button>
							</form>
							<form action="" method="post">
								<button class="project__stageBtn" type="submit">Приостановить задачу</button>
							</form>
						</td>
					</tr>
						<?php endforeach;?>
					<?php endforeach;?>
					</tbody>
				</table>
			</div>
			<div id="futureStage-reviews" class="tab__container nonPriorityContainer">
				<?php if (count($arResult['FUTURE_STAGE']) > 0): ?>
				<table class="rounded-corners">
					<thead>
					<tr>
						<th>Номер этапа</th>
						<th>Статус</th>
						<th>Предполагаемая дата окончания</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($arResult['FUTURE_STAGE'] as $stage):?>
						<tr>
							<td><?= $stage->getNumber() ?></td>
							<td><?= $stage->getStatus() ?></td>
							<?php if (!empty($stage->getExpectedCompletionDate())):?>
								<td><?= $stage->getExpectedCompletionDate()->format('d.m.Y') ?></td>
							<?php else:?>
								<td>нет даты</td>
							<?php endif; ?>
						</tr>
					<?php endforeach;?>
					</tbody>
				</table>
				<?php else:?>
					<div class="emptyStage">
						<p>У вас пока нет запланированных этапов</p>
						<a class="project__link" href="/project/<?=$arParams['PROJECT_ID']?>/edit/">Перейти к планированию проекта</a>
					</div>
				<?php endif;?>
			</div>
			<div id="closedStage-reviews" class="tab__container nonPriorityContainer">
				<?php if (count($arResult['COMPLETED_STAGE']) > 0): ?>
				<table class="rounded-corners">
					<thead>
					<tr>
						<th>Номер этапа</th>
						<th>Статус</th>
						<th>Этап завершился</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($arResult['COMPLETED_STAGE'] as $stage):?>
					<tr>
						<td><?= $stage->getNumber() ?></td>
						<td><?= $stage->getStatus() ?></td>
						<?php if (!empty($stage->getExpectedCompletionDate())):?>
							<td><?= $stage->getExpectedCompletionDate()->format('d.m.Y') ?></td>
						<?php else:?>
							<td>нет даты</td>
						<?php endif; ?>
					</tr>
					<?php endforeach;?>
					</tbody>
				</table>
				<?php else:?>
					<div class="emptyStage">
						<p>У вас пока нет завершенных этапов</p>
						<a class="project__link" href="/project/<?=$arParams['PROJECT_ID']?>/edit/">Перейти к планированию проекта</a>
					</div>
				<?php endif;?>
			</div>
		</article>
	</section>
</main>
<?php
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/tabContainers.js");
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/profile.js");
?>