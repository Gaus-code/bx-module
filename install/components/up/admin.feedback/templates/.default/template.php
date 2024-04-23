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
	<!-- Вкладка уведомлений для админа !-->
	<section class="admin">
		<article class="content__header">
			<h1>Рабочая область</h1>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Отзывы</h2>
		</article>
		<article>
			<table class="response-table">
				<thead>
				<tr>
					<th>Отзыв</th>
					<th>Actions</th>
				</tr>
				</thead>
				<tbody>
				<tr>
					<td>This is a description of request 1.</td>
					<td>
						<div class="responseBtns">
							<a href="/task/1/">Посмотреть заявку</a>
							<form action="">
								<button type="submit">Удалить отзыв</button>
							</form>
						</div>
					</td>
				</tr>
				<tr>
					<td>This is a description of request 2.</td>
					<td>
						<div class="responseBtns">
							<a href="/task/1/">Посмотреть заявку</a>
							<form action="">
								<button type="submit">Удалить отзыв</button>
							</form>
						</div>
					</td>
				</tr>
				</tbody>
			</table>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
