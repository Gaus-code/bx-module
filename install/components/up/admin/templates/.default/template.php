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
	$APPLICATION->IncludeComponent('up:admin.aside', '', [
		'USER_ID' => $USER->GetID(),
	]); ?>
	<!-- Таблица тасков у админа !-->
	<section class="admin">
		<article class="content__header">
			<h1>Рабочая область</h1>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Жалоба на заявки</h2>
		</article>
		<?php if (count($arResult['ADMIN_TASKS']) > 0):?>
		<table class="task-table">
			<thead>
			<tr>
				<th>Заголовок</th>
				<th>Описание</th>
				<th>Действия</th>
			</tr>
			</thead>
			<tbody>
			<?php foreach ($arResult['ADMIN_TASKS'] as $report): ?>
			<tr>
				<td><?= htmlspecialcharsbx($report->getTask()->getTitle()) ?></td>
				<td><?= htmlspecialcharsbx($report->getTask()->getDescription()) ?></td>
				<td>
					<a href="/task/<?= $report->getTask()->getId() ?>/">Посмотреть заявку</a>
					<form action="/report/delete/" method="post" >
						<?= bitrix_sessid_post() ?>
						<input name="reportId" hidden="hidden" value="<?= $report->getId() ?>">
						<button id="sendComplaint" type="submit">Отклонить жалобу</button>
					</form>
				</td>
			</tr>
			<?php endforeach;?>
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
		<?php else:?>
			<div class="contractor__emptyContainer">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/Box.svg" alt="no projects image">
				<p class="empty">У вас пока нет жалоб</p>
			</div>
		<?php endif;?>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
