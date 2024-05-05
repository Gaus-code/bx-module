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
		<?php
		$APPLICATION->IncludeComponent('up:user.aside', '', [
			'USER_ID' => $arParams['USER_ID'],
		]); ?>
		<section class="content">
			<article class="content__header">
				<h1 id="quickCreate">Быстрое создание</h1>
				<div class="content__profileCreate">
					<a href="/project/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать проект</a>
					<a href="/task/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать заявку</a>
				</div>
			</article>
			<article class="content__name">
				<h2 class="project__detail_title">Детальная страница проекта</h2>
				<div class="content__projectDetail">
					<h2 class="project__title"><?= htmlspecialcharsbx($arResult['PROJECT']->getTitle()) ?></h2>
					<p class="project__description"><?= htmlspecialcharsbx(
							$arResult['PROJECT']->getDescription()
						) ?>
					</p>
					<?php
					if ($arResult['USER_ACTIVITY'] === 'owner'): ?>
						<div class="content__project_btnContainer">
							<a class="project__link" href="/project/<?= $arParams['PROJECT_ID'] ?>/edit/">
								Перейти к настройке проекта
							</a>
							<form class="doneProjectForm" action="/project/complete/" method="post">
								<?= bitrix_sessid_post() ?>
								<input type="hidden" name="projectId" value="<?= $arParams['PROJECT_ID'] ?>">
								<button type="submit">Завершить проект</button>
							</form>
						</div>
					<?php
					endif; ?>
				</div>
			</article>
			<article class="content__project">

				<div class="project__categories">
					<ul class="project__tagList">
						<?php
						if ($arResult['WAITING_TO_START_STAGE']): ?>
							<li id="waitingToStartStage-btn" class="project__tagItem active-tag-item">
								Ожидает начала
							</li>
						<?php
						else: ?>
							<li id="activeStage-btn" class="project__tagItem active-tag-item">
								Активный этап
							</li>
						<?php
						endif; ?>
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
				<?php
				$APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
				<?php
				if ($arResult['WAITING_TO_START_STAGE']): ?>
					<div id="waitingToStartStage-reviews" class="tab__container">
							<?php
							if ($arResult['USER_ACTIVITY'] === 'owner'): ?>
								<form class="project__stageForm" action="/stage/start/" method="post">
									<?= bitrix_sessid_post() ?>
									<input type="hidden" name="stageId" value="<?= $arResult['WAITING_TO_START_STAGE']->getId(
									) ?>">
									<button type="submit" class="project__stageBtn">
										Начать <span>этап <?= $arResult['WAITING_TO_START_STAGE']->getNumber() ?></span>
									</button>
								</form>
							<?php
							endif; ?>
							<?php if (count($arResult['WAITING_TO_START_STAGE']->getTasks()) > 0):?>
							<h2>Заявки в этапе:</h2>

							<table class="rounded-corners">
								<thead>
								<tr>
									<th>Название</th>
									<th>Описание</th>
									<th>Статус</th>
									<th>Дедлайн</th>
								</tr>
								</thead>
								<tbody>
									<?php foreach ($arResult['WAITING_TO_START_STAGE']->getTasks() as $task): ?>
										<tr>
											<td>
												<a class="taskViewLink" href="/task/<?= $task->getId() ?>/">
													<?= htmlspecialcharsbx($task->getTitle()) ?>
												</a>
											</td>
											<td><?= $task->getDescription() ?></td>
											<td><?= $task->getStatus() ?></td>
											<td><?= $task->getDeadline() ?></td>
										</tr>
									<?php endforeach; ?>
								</tbody>
							</table>
							<?php else: ?>
								<div class="emptyStage">
									<p>У вас нет заявок в этом этапе</p>
									<a class="project__link" href="/project/<?= $arParams['PROJECT_ID'] ?>/edit/">Перейти к планированию проекта</a>
								</div>
							<?php endif;?>
					</div>
				<?php
				else: ?>
					<div id="activeStage-reviews" class="tab__container">
						<?php
						if ($arResult['ACTIVE_STAGE']): ?>
							<?php
							if ($arResult['USER_ACTIVITY'] === 'owner'): ?>
								<form class="project__stageForm" action="/stage/complete/" method="post">
									<?= bitrix_sessid_post() ?>
									<input type="hidden" name="stageId" value="<?= $arResult['ACTIVE_STAGE']->getId(
									) ?>">
									<button type="submit" class="project__stageBtn">
										Завершить <span>этап <?= $arResult['ACTIVE_STAGE']->getNumber() ?></span>
									</button>
								</form>
							<?php
							endif; ?>
							<?php if (count($arResult['ACTIVE_STAGE']->getTasks()) > 0):?>
							<h2>Заявки в этапе:</h2>
							<table class="rounded-corners">
								<thead>
								<tr>
									<th>Название</th>
									<th>Описание</th>
									<th>Статус</th>
									<th>Дедлайн</th>
								</tr>
								</thead>
								<tbody>
								<?php
								foreach ($arResult['ACTIVE_STAGE']->getTasks() as $task): ?>
									<tr>
										<td>
											<a class="taskViewLink" href="/task/<?= $task->getId() ?>/">
												<?= htmlspecialcharsbx($task->getTitle()) ?>
											</a>
										</td>
										<td><?= $task->getDescription() ?></td>
										<td><?= $task->getStatus() ?></td>
										<td><?= $task->getDeadline() ?></td>
									</tr>
								<?php
								endforeach; ?>
								</tbody>
							</table>
							<?php else: ?>
								<div class="emptyStage">
									<p>У вас нет заявок в этом этапе</p>
									<a class="project__link" href="/project/<?= $arParams['PROJECT_ID'] ?>/edit/">Перейти к планированию проекта</a>
								</div>
							<?php endif;?>
						<?php
						else: ?>
							<div class="emptyStage">
								<p>У вас пока нет активных этапов</p>
								<a class="project__link" href="/project/<?= $arParams['PROJECT_ID'] ?>/edit/">Перейти к планированию проекта</a>
							</div>
						<?php
						endif; ?>
					</div>
				<?php
				endif; ?>
				<div id="independentStage-reviews" class="tab__container nonPriorityContainer">
					<?php if (count($arResult['INDEPENDENT_STAGE']->getTasks()) > 0):?>
					<h2>Заявки в этапе:</h2>
					<table class="rounded-corners">
						<thead>
						<tr>
							<th>Название</th>
							<th>Описание</th>
							<th>Статус</th>
							<th>Дедлайн</th>
							<?php
							if ($arResult['USER_ACTIVITY'] === 'owner'): ?>
								<th>Действия</th>
							<?php
							endif; ?>

						</tr>
						</thead>
						<tbody>
							<?php
							foreach ($arResult['INDEPENDENT_STAGE']->getTasks() as $task): ?>
								<tr>

									<td>
										<a class="taskViewLink" href="/task/<?= $task->getId() ?>/">
											<?= htmlspecialcharsbx($task->getTitle()) ?>
										</a>
									</td>
									<td><?= $task->getDescription() ?></td>
									<td><?= $task->getStatus() ?></td>
									<td><?= $task->getDeadline() ?></td>

									<?php
									if ($arResult['USER_ACTIVITY'] === 'owner'): ?>
										<td>
											<?php if ($task->getStatus()===\Up\Ukan\Service\Configuration::getOption('task_status')['waiting_to_start']):?>
											<form action="/project/task/start-search-contractor/" method="post">
												<?= bitrix_sessid_post() ?>
												<input type="hidden" name="taskId" value="<?=$task->getId()?>">
												<button class="project__stageBtn" type="submit">Начать поиск исполнителя</button>
											</form>
										<?php elseif ($task->getStatus()===\Up\Ukan\Service\Configuration::getOption('task_status')['search_contractor']):?>
											<form action="/project/task/stop-search-contractor/" method="post">
												<?= bitrix_sessid_post() ?>
												<input type="hidden" name="taskId" value="<?=$task->getId()?>">
												<button class="project__stageBtn" type="submit">Приостановить задачу</button>
											</form>
										<?php elseif ($task->getStatus()===\Up\Ukan\Service\Configuration::getOption('task_status')['at_work']):?>
											<form action="/project/task/finish/" method="post">
												<?= bitrix_sessid_post() ?>
												<input type="hidden" name="taskId" value="<?=$task->getId()?>">
												<button class="project__stageBtn" type="submit">Завершить задачу</button>
											</form>
											<?php
											endif; ?>
										</td>
									<?php
									endif; ?>

								</tr>
							<?php
							endforeach; ?>
						</tbody>
					</table>
					<?php else: ?>
						<div class="emptyStage">
							<p>У вас нет заявок в этом этапе</p>
							<a class="project__link" href="/project/<?= $arParams['PROJECT_ID'] ?>/edit/">Перейти к планированию проекта</a>
						</div>
					<?php endif;?>
				</div>
				<div id="futureStage-reviews" class="tab__container nonPriorityContainer">
					<?php
					if (count($arResult['FUTURE_STAGE']) > 0): ?>
						<table class="rounded-corners">
							<thead>
							<tr>
								<th>Номер этапа</th>
								<th>Статус</th>
								<th>Предполагаемая дата окончания</th>
							</tr>
							</thead>
							<tbody>
							<?php
							foreach ($arResult['FUTURE_STAGE'] as $stage): ?>
								<tr>
									<td><?= $stage->getNumber() ?></td>
									<td><?= $stage->getStatus() ?></td>
									<?php
									if (!empty($stage->getExpectedCompletionDate())): ?>
										<td><?= $stage->getExpectedCompletionDate()->format('d.m.Y') ?></td>
									<?php
									else: ?>
										<td>нет даты</td>
									<?php
									endif; ?>
								</tr>
							<?php
							endforeach; ?>
							</tbody>
						</table>
					<?php
					else: ?>
						<div class="emptyStage">
							<p>У вас пока нет запланированных этапов</p>
							<a class="project__link" href="/project/<?= $arParams['PROJECT_ID'] ?>/edit/">Перейти к планированию проекта</a>
						</div>
					<?php
					endif; ?>
				</div>
				<div id="closedStage-reviews" class="tab__container nonPriorityContainer">
					<?php
					if (count($arResult['COMPLETED_STAGE']) > 0): ?>
						<table class="rounded-corners">
							<thead>
							<tr>
								<th>Номер этапа</th>
								<th>Статус</th>
								<th>Этап завершился</th>
							</tr>
							</thead>
							<tbody>
							<?php
							foreach ($arResult['COMPLETED_STAGE'] as $stage): ?>
								<tr>
									<td><?= $stage->getNumber() ?></td>
									<td><?= $stage->getStatus() ?></td>
									<?php
									if (!empty($stage->getExpectedCompletionDate())): ?>
										<td><?= $stage->getExpectedCompletionDate()->format('d.m.Y') ?></td>
									<?php
									else: ?>
										<td>нет даты</td>
									<?php
									endif; ?>
								</tr>
							<?php
							endforeach; ?>
							</tbody>
						</table>
					<?php
					else: ?>
						<div class="emptyStage">
							<p>У данного проекта нет завершенных этапов</p>
							<?php
							if ($arResult['USER_ACTIVITY'] === 'owner'): ?>
								<a class="project__link" href="/project/<?= $arParams['PROJECT_ID'] ?>/edit/">Перейти к планированию проекта</a>
							<?php
							endif; ?>
						</div>
					<?php
					endif; ?>
				</div>
			</article>
		</section>
	</main>
<?php
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/tabContainers.js");
\Bitrix\Main\Page\Asset::getInstance()->addJs(SITE_TEMPLATE_PATH . "/assets/js/profile.js");
?>