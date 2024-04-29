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
			<?php if (count($arResult['ADMIN_TAGS']) > 0):?>
			<table class="task-table">
				<thead>
				<tr>
					<th>Тег</th>
					<th>Жалоба</th>
					<th>Действия</th>
				</tr>
				</thead>
				<tbody>
				<?php foreach ($arResult['ADMIN_TAGS'] as $tag): ?>
						<tr>
							<td><?= htmlspecialcharsbx($tag->getToTag()->getTitle()) ?></td>
							<td><?= htmlspecialcharsbx($tag->getMessage()) ?></td>
							<td>
								<a href="/task/<?= $tag->getToTask()->getID() ?>/">Посмотреть заявку</a>
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
