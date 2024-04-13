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
			<h2 class="content__tittle">Редактирование проекта</h2>
		</article>
		<article class="content__editProject">
			<form action="" method="post" class="create__form">
				<input type="text" class="content__editInput" name="title" placeholder="Название проекта" value="Какое-то название проекта" required>
				<input type="text" class="content__editInput" name="description" placeholder="Описание проекта" value="Какое-то описание проекта" required>
				<div class="content__projectEditContainer">
					<h2>Редактируйте заявки в проекте</h2>
					<div class="tbl-header">
						<table>
							<thead>
							<tr>
								<th class="test">Порядок Выполнения</th>
								<th>Название задачи</th>
								<th>Описание задачи</th>
								<th>Исполнитель</th>
								<th>Статус</th>
								<th>Дедлайн</th>
								<th>Сделать независимой задачей</th>
								<th>Удалить задачу</th>
							</tr>
							</thead>
						</table>
					</div>
					<div class="tbl-content">
						<table>
							<tbody>
							<tr>
								<td>
									<input class="editTaskPriority" type="number" name="priority" value="1">
								</td>
								<td class="test">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto.</td>
								<td>Описание описание описание</td>
								<td>В поиске исполнителя</td>
								<td>Новая</td>
								<td>20.04.2024 17:56</td>
								<td>
									<input class="withoutPriority" type="checkbox" name="withoutPriority">
								</td>
								<td>
									<input class="deleteTask" type="checkbox" name="deleteTask">
								</td>
							</tr>
							<tr>
								<td>
									<input class="editTaskPriority" type="number" name="priority" value="2">
								</td>
								<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto.</td>
								<td>Описание описание описание</td>
								<td class="test">В поиске исполнителя</td>
								<td>Новая</td>
								<td>20.04.2024 17:56</td>
								<td>
									<input class="withoutPriority" type="checkbox" name="withoutPriority">
								</td>
								<td>
									<input class="deleteTask" type="checkbox" name="deleteTask">
								</td>
							</tr>
							<tr>
								<td>
									<input class="editTaskPriority" type="number" name="priority" value="3">
								</td>
								<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto.</td>
								<td>Описание описание описание</td>
								<td>В поиске исполнителя</td>
								<td>Новая</td>
								<td>20.04.2024 17:56</td>
								<td>
									<input class="withoutPriority" type="checkbox" name="withoutPriority">
								</td>
								<td>
									<input class="deleteTask" type="checkbox" name="deleteTask">
								</td>
							</tr>
							<tr>
								<td>
									<input class="editTaskPriority" type="number" name="priority" value="3">
								</td>
								<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto.</td>
								<td>Описание описание описание</td>
								<td>В поиске исполнителя</td>
								<td>Новая</td>
								<td>20.04.2024 17:56</td>
								<td>
									<input type="checkbox" name="withoutPriority">
								</td>
								<td>
									<input class="deleteTask" type="checkbox" name="deleteTask">
								</td>
							</tr>
							</tbody>
						</table>
					</div>
				</div>
				<button class="createBtn" type="submit">Сохранить Изменения</button>
			</form>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/deleteTaskFromProject.js"></script>