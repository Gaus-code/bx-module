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
	$APPLICATION->IncludeComponent('up:user.aside', '', []); ?>
	<section class="content">
		<article class="content__header">
			<h1>Рабочая область</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner">+</span>
			</button>
			<div class="content__profileCreate">
				<a href="/project/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваш проект</h2>
		</article>
		<article class="content__userProject">
			<div class="userProject__title">
				<h2><?= $arParams['PROJECT']->getTitle() ?></h2>
			</div>
			<div class="userProject__main">
				<p class="userProject__description">
					<?= $arParams['PROJECT']->getDescription() ?>
				</p>
			</div>
			<div class="userProject__btnContainer">
				<form action="/project/delete/" method="post">
					<?= bitrix_sessid_post() ?>
					<input type="hidden" name="projectId" value='<?= $arParams['PROJECT_ID'] ?>'>
					<button class="deleteProject">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/skull.svg" alt="">
						Удалить проект
					</button>
				</form>
				<a href="/project/1/edit/" class="userProject__edit">Редактировать проект</a>
				<button class="userProject__add">Добавить задачу</button>
			</div>


			<div class="userProject__tasks">
				<h2>Задачи в проекте:</h2>
				<div class="tbl-header">
					<table>
						<thead>
						<tr>
							<th>Порядок выполнения</th>
							<th>Название</th>
							<th>Исполнитель</th>
							<th>Статус</th>
							<th>Последние изменения</th>
							<th>Дедлайн</th>
						</tr>
						</thead>
					</table>
				</div>
				<div class="tbl-content">
					<table>
						<tbody>
						<?php
						foreach ($arParams['PROJECT']->getTasks() as $task)
						{
							?>
							<tr>
								<td><?= $task->getProjectPriority() ?></td>
								<td><?= $task->getTitle() ?></td>


								<?php
								if ($task->getContractor() !== null)
								{
									?>
									<td><?= $task->getContractor()->getBUser()->getName() ?></td>
									<?php
								}
								else
								{ ?>
									<td> Исполнителя нет</td> <?php
								}
								?>
								<td><?= $task->getStatus() ?></td>
								<td><?= $task->getUpdatedAt() ?></td>
								<td>Дедлайн</td>
							</tr>

							<?php
						} ?>
						</tbody>
					</table>
				</div>
			</div>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>