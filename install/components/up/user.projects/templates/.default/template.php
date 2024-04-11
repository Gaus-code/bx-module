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
	<?php $APPLICATION->IncludeComponent('up:user.aside', '', []); ?>
	<section class="content">
		<article class="content__header">
			<h1>Рабочая область</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner">+</span>
			</button>
			<div class="content__profileCreate">
				<a href="/create/project/<?=$arParams['USER_ID']?>/" class="create__link">Создать проект</a>
				<a href="/create/task/<?=$arParams['USER_ID']?>/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваши проекты</h2>
		</article>
		<article class="content__projects">
			<div class="projects__header">
				<ul class="projects__tagList">
					<li class="projects__tagItem active-project-link">
						<a href="/profile/<?= $USER->GetID() ?>/projects/" class="projects__tag">Активные Проекты</a>
					</li>
					<li class="projects__tagItem">
						<a href="/profile/<?= $USER->GetID() ?>/projects/done/" class="projects__tag">Завершенные Проекты</a>
					</li>
				</ul>
			</div>
			<div class="projects__list">
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
							<td data-label="Название проекта">Проект 1 Проект 1 Проект 1 Проект 1</td>
							<td data-label="Дата создания">01.04.2024</td>
							<td data-label="Количество задач">10</td>
							<td data-label="Количество исполнителей">9</td>
							<td data-label="Редактировать">
								<a class="editProject" href="/project/1/">Редактировать проект</a>
							</td>
						</tr>
						<tr>
							<td data-label="Название проекта">Проект 2</td>
							<td data-label="Дата создания">01.04.2024</td>
							<td data-label="Количество задач">100</td>
							<td data-label="Количество исполнителей">50</td>
							<td data-label="Редактировать">
								<a class="editProject" href="/project/1/">Редактировать проект</a>
							</td>
						</tr>
						<tr>
							<td data-label="Название проекта">Проект 3</td>
							<td data-label="Дата создания">01.04.2024</td>
							<td data-label="Количество задач">3</td>
							<td data-label="Количество исполнителей">2</td>
							<td data-label="Редактировать">
								<a class="editProject" href="/project/1/">Редактировать проект</a>
							</td>
						</tr>
						<tr>
							<td data-label="Название проекта">Проект 4</td>
							<td data-label="Дата создания">01.04.2024</td>
							<td data-label="Количество задач">3</td>
							<td data-label="Количество исполнителей">2</td>
							<td data-label="Редактировать">
								<a class="editProject" href="/project/1/">Редактировать проект</a>
							</td>
						</tr>
						<tr>
							<td data-label="Название проекта">Проект 5</td>
							<td data-label="Дата создания">01.04.2024</td>
							<td data-label="Количество задач">3</td>
							<td data-label="Количество исполнителей">2</td>
							<td data-label="Редактировать">
								<a class="editProject" href="/project/1/">Редактировать проект</a>
							</td>
						</tr>
					</tbody>
				</table>
			</div>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
