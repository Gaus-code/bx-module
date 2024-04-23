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
			<h2 class="content__tittle">Заявки</h2>
		</article>
		<table class="task-table">
			<thead>
			<tr>
				<th>Title</th>
				<th>Description</th>
				<th>Actions</th>
			</tr>
			</thead>
			<tbody>
			<tr>
				<td>Request 1</td>
				<td>This is a description of request 1.</td>
				<td>
					<a href="/task/1/">Посмотреть заявку</a>
				</td>
			</tr>
			<tr>
				<td>Request 2</td>
				<td>This is a description of request 2.</td>
				<td>
					<a href="/task/1/">Посмотреть заявку</a>
				</td>
			</tr>
			</tbody>
		</table>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
