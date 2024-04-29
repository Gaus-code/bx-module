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
	<!-- Форма для создания тегов !-->
	<section class="admin">
		<article class="content__header">
			<h1>Рабочая область</h1>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Жалобы на теги</h2>
		</article>
		<article>
			<table class="task-table">
				<thead>
				<tr>
					<th>Заголовок</th>
					<th>Описание</th>
					<th>Действия</th>
				</tr>
				</thead>
				<tbody>
					<tr>
						<td><?= htmlspecialcharsbx('hello from xss') ?></td>
						<td><?= htmlspecialcharsbx('hello from xss :) Link also has HARDCODE') ?></td>
						<td>
							<a href="/task/<?= 'hello'?>/">Посмотреть заявку</a>
						</td>
					</tr>
				</tbody>
			</table>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
