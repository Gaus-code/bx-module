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
			<h2 class="content__tittle">Жалобы на отзывы</h2>
		</article>
		<article>
			<?php if (count($arResult['ADMIN_FEEDBACKS']) > 0):?>
			<table class="response-table">
				<thead>
				<tr>
					<th>Отзыв</th>
					<th>Действия</th>
				</tr>
				</thead>
				<tbody>
					<?php foreach ($arResult['ADMIN_FEEDBACKS'] as $feedback): ?>
					<tr>
						<td><?= htmlspecialcharsbx($feedback->getToFeedback()->getComment()) ?></td>
						<td>
							<div class="responseBtns">
								<a href="/task/<?= $feedback->getToTask()->getId() ?>/">Посмотреть заявку</a>
								<form action="">
									<button type="submit">Удалить отзыв</button>
								</form>
							</div>
						</td>
					</tr>
					<?php endforeach; ?>
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
