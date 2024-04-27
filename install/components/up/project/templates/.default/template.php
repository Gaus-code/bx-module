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
				<?php foreach ($arResult['PROJECT'] as $project):?>
				<h2 class="project__title"><?= htmlspecialcharsbx($project->getTitle()) ?></h2>
				<p class="project__description"><?= htmlspecialcharsbx($project->getDescription()) ?></p>
				<?php endforeach;?>
			</div>
		</article>
		<article class="content__project">
			<a class="project__link" href="/project/<?=$arParams['PROJECT_ID']?>/edit/">
				Перейти к настройке проекта
			</a>
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
			<div id="activeStage-reviews" class="tab__container">
				<?php if (count($arResult['ACTIVE_STAGE']) > 0): ?>
				<table class="rounded-corners">
					<thead>
					<tr>
						<th>Номер этапа</th>
						<th>Статус</th>
						<th>Предполагаемая дата окончания</th>
						<th>Активности</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($arResult['ACTIVE_STAGE'] as $stage):?>
					<tr>
						<td><?= $stage->getNumber() ?></td>
						<td><?= $stage->getStatus() ?></td>
						<td><?= $stage->getExpectedCompletionDate()->format('d.m.Y') ?></td>
						<td>
							<?php if ($stage->getStatus() === 'Активен'): ?>
							<form class="project__stageForm" action="/stage/complete/" method="post">
								<?=bitrix_sessid_post()?>
								<input type="hidden" name="stageId" value="<?= $stage->getId() ?>">
								<button type="submit" class="project__stageBtn">
									Завершить <span>этап <?= $stage->getNumber() ?></span> ?
								</button>
							</form>
							<?php else:?>
							<form class="project__stageForm" action="/stage/start/" method="post">
								<?=bitrix_sessid_post()?>
								<input type="hidden" name="stageId" value="<?= $stage->getId() ?>">
								<button type="submit" class="project__stageBtn">
									Начать <span>этап <?= $stage->getNumber() ?></span> ?
								</button>
							</form>
							<?php endif;?>
						</td>
					</tr>
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
			<div id="independentStage-reviews" class="tab__container">
				<table class="rounded-corners">
					<thead>
					<tr>
						<th>Номер этапа</th>
						<th>Статус</th>
						<th>Предполагаемая дата окончания</th>
					</tr>
					</thead>
					<tbody>
					<?php foreach ($arResult['INDEPENDENT_STAGE'] as $stage):?>
					<tr>
						<td><?= $stage->getNumber() ?></td>
						<td><?= $stage->getStatus() ?></td>
						<td><?= $stage->getExpectedCompletionDate()->format('d.m.Y') ?></td>
					</tr>
					<?php endforeach;?>
					</tbody>
				</table>
			</div>
			<div id="futureStage-reviews" class="tab__container">
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
							<td><?= $stage->getExpectedCompletionDate()->format('d.m.Y') ?></td>
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
			<div id="closedStage-reviews" class="tab__container">
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
						<td><?= $stage->getExpectedCompletionDate()->format('d.m.Y') ?></td>
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
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/tabContainers.js"></script>