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
		<form action="" method="post">
			<button class="deleteProject">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/skull.svg" alt="">
				Удалить проект
			</button>
		</form>
		<article class="content__editProject">
			<form action="" method="post" class="create__form">
				<input type="text" class="content__editInput" name="title" placeholder="Название проекта" value="Какое-то название проекта" required>
				<input type="text" class="content__editInput" name="description" placeholder="Описание проекта" value="Какое-то описание проекта" required>
				<div class="create__fieldsetContainer">
					<fieldset>
						<legend>Редактируйте Задачи</legend>
						<?php if (!empty($arResult['TASKS'])): ?>
							<?php if (count($arResult['TASKS']) > 0): ?>
								<ul class="filter__list">
									<?php foreach ($arResult['TASKS'] as $task): ?>
										<li class="filter__item">
											<input type="checkbox" class="filter__checkbox" name="tagIds[<?=$task->getId()?>]" value="<?=$task->getId()?>">
											<label class="filter__label"><?=$task->getTitle()?></label>
										</li>
									<?php endforeach; ?>
								</ul>
							<?php else: ?>
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoProjects.svg" alt="no projects image">
								<p class="empty">У вас пока нет задач</p>
							<?php endif;?>
						<?php else: ?>
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoProjects.svg" alt="no projects image">
							<p class="empty">У вас пока нет задач</p>
						<?php endif;?>
					</fieldset>
				</div>
				<section class="editPriority">
					<h2>Редактируйте приоритетность заявок</h2>
					<div class="tbl-header">
						<table>
							<thead>
							<tr>
								<th>Приоритетность</th>
								<th>Название заявки</th>
								<th>Статус</th>
								<th>Исполнитель</th>
								<th>Дата создания</th>
							</tr>
							</thead>
						</table>
					</div>
					<div class="tbl-content">
						<table>
							<tbody>
							<tr>
								<td>
									<input type="number" max="5" min="1" placeholder="1" value="1">
								</td>
								<td>AUSTRALIAN COMPANY </td>
								<td>Новая</td>
								<td>Не найден</td>
								<td>20.04.2024</td>
							</tr>
							<tr>
								<td>
									<input type="number" max="5" min="1" placeholder="2" value="2">
								</td>
								<td>AUSTRALIAN COMPANY </td>
								<td>В процессе</td>
								<td>Исполнительный Исполнитель Исполняет</td>
								<td>20.04.2024</td>
							</tr>
							<tr>
								<td>
									<input type="number" max="5" min="1" placeholder="2" value="2">
								</td>
								<td>AUSTRALIAN COMPANY </td>
								<td>На проверке</td>
								<td>Умный чел</td>
								<td>20.04.2024</td>
							</tr>
							<tr>
								<td>
									<input type="number" max="5" min="1" placeholder="3" value="3">
								</td>
								<td>AUSTRALIAN COMPANY </td>
								<td>Сделана</td>
								<td>Исполнительный Исполнитель Исполняет</td>
								<td>20.04.2024</td>
							</tr>
							<tr>
								<td>
									<input type="number" max="5" min="1" placeholder="1" value="1">
								</td>
								<td>AUSTRALIAN COMPANY </td>
								<td>Новая</td>
								<td>Исполнительный Исполнитель Исполняет</td>
								<td>20.04.2024</td>
							</tr>
							<tr>
								<td>
									<input type="number" max="5" min="1" placeholder="1" value="1">
								</td>
								<td>AUSTRALIAN COMPANY </td>
								<td>Новая</td>
								<td>Исполнительный Исполнитель Исполняет</td>
								<td>20.04.2024</td>
							</tr>
							</tbody>
						</table>
					</div>
				</section>
				<button class="createBtn" type="submit">Сохранить Изменения</button>
			</form>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>