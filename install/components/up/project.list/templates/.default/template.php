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
				<span class="plus-link__inner">+</span>
			</button>
			<div class="content__profileCreate">
				<a href="/project/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваши проекты</h2>
		</article>
		<article class="content__projects">
			<div class="projects__header">
				<ul class="projects__tagList">
					<li id="active-btn" class="projects__tagItem active-tag-item">
						Активные
					</li>
					<li id="done-btn" class="projects__tagItem">
						Завершенные
					</li>
				</ul>
			</div>
			<!-- Контейнер для активных проектов юзера !-->
			<div id="active-reviews" class="projects__list tab__container">
				<?php if (count($arResult['PROJECTS']) > 0): ?>
				<table id="projectsTable">
					<thead>
						<tr>
							<th>Название проекта</th>
							<th>Дата создания</th>
							<th>Количество задач</th>
							<th>Количество исполнителей</th>
							<th></th>
						</tr>
					</thead>
					<tbody>
					<?php foreach ($arResult['PROJECTS'] as $project): ?>
						<tr>
							<td data-label="Название проекта"><?= $project->getTitle() ?></td>
							<td data-label="Дата создания"><?= $project->getCreatedAt() ?></td>
							<td data-label="Количество задач">10 (HARDCODE!!!!)</td>
							<td data-label="Количество исполнителей">9 (HARDCODE!!!!)</td>
							<td data-label="Редактировать">
								<a class="editProject" href="/project/<?= $project->getId() ?>/">Редактировать проект</a>
							</td>
						</tr>
					<?php endforeach; ?>
					</tbody>
				</table>
				<?php
				if ($arParams['CURRENT_PAGE'] !== 1 || $arParams['EXIST_NEXT_PAGE'])
				{
					$APPLICATION->IncludeComponent('up:pagination', '', [
						'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE'],
					]);
				}
				?>
				<?php else: ?>
					<div class="contractor__emptyContainer">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoTasks.svg" alt="no tasks image">
						<p>Пока что тут нет проектов</p>
					</div>
				<?php endif; ?>
			</div>
			<!-- Контейнер для завершенных проектов юзера !-->
			<div id="done-reviews" class="projects__doneList tab__container">
				<?php if (count($arResult['PROJECTS']) > 0): ?>
					<table id="projectsTable">
						<thead>
						<tr>
							<th>Название проекта</th>
							<th>Дата создания</th>
							<th>Количество задач</th>
							<th>Количество исполнителей</th>
							<th></th>
						</tr>
						</thead>
						<tbody>
							<tr>
								<td data-label="Название проекта">HARDCODE!!!</td>
								<td data-label="Дата создания">HARDCODE!!!</td>
								<td data-label="Количество задач">10 (HARDCODE!!!!)</td>
								<td data-label="Количество исполнителей">9 (HARDCODE!!!!)</td>
								<td data-label="Редактировать">
									<a class="editProject" href="/project/HARDCODE!!!/">Редактировать проект</a>
								</td>
							</tr>
						</tbody>
					</table>
					<?php
					if ($arParams['CURRENT_PAGE'] !== 1 || $arParams['EXIST_NEXT_PAGE'])
					{
						$APPLICATION->IncludeComponent('up:pagination', '', [
							'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE'],
						]);
					}
					?>
				<?php else: ?>
					<div class="contractor__emptyContainer">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoTasks.svg" alt="no tasks image">
						<p>Пока что тут нет проектов</p>
					</div>
				<?php endif; ?>
			</div>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/tabContainers.js"></script>
