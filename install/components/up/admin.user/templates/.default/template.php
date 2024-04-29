<?php
/**
 * @var array $arResult
 * @var array $arParams
 * @var CUser $USER
 * @var CMain $APPLICATION
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
			<h2 class="content__tittle">Жалобы на пользователей</h2>
		</article>
		<article>
			<table class="response-table">
				<thead>
				<tr>
					<th>Пользователь</th>
					<th>Жалоба</th>
					<th>Действия</th>
				</tr>
				</thead>
				<tbody>
					<tr>
						<td>какой-то умный чел</td>
						<td>сообщение о том, какой этот чел не умный</td>
						<td>
							<div class="responseBtns">
								<a href="/profile/HARDCODE/">Посмотреть профиль</a>
								<form action="">
									<button type="submit">Забанить пользователя</button>
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
