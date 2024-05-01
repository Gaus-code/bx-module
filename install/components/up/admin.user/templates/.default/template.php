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
			<?php if (count($arResult['ADMIN_USERS']) > 0):?>
			<table class="response-table">
				<thead>
				<tr>
					<th>Пользователь</th>
					<th>Жалоба</th>
					<th>Действия</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($arResult['ADMIN_USERS'] as $report):?>
					<tr>
						<td><?= $report->getToUser()->getBUser()->getName() ?></td>
						<td><?= $report->getMessage()?></td>
						<td>
							<div class="responseBtns">
								<a href="/profile/<?= $report->getToUserId() ?>/">Посмотреть профиль</a>
								<form action="">
									<button type="submit">Забанить пользователя</button>
								</form>
								<form action="/report/delete/" method="post" >
									<?= bitrix_sessid_post() ?>
									<input name="reportId" hidden="hidden" value="<?= $report->getId() ?>">
									<button id="sendComplaint" type="submit">Отклонить жалобу</button>
								</form>
							</div>
						</td>
					</tr>
				<?php endforeach;?>
				</tbody>
			</table>
			<?php else:?>
				<div class="contractor__emptyContainer">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/Box.svg" alt="no projects image">
					<p class="empty">У вас пока нет жалоб</p>
				</div>
			<?php endif;?>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
