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
	<!-- Вкладка категорий для админа !-->
	<section class="admin">
		<article class="content__header">
			<h1>Рабочая область</h1>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Категории</h2>
		</article>
		<article class="content__create">
			<div class="modalResponse">
				<?php $APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
			</div>
			<form class="create__form" action="/category/create/" method="post">
				<?=bitrix_sessid_post()?>
				<input type="text" name="title" class="create__title" placeholder="Создайте новую категорию">
				<button class="createBtn" type="submit">Создать Категорию</button>
			</form>
		</article>
		<article>
			<?php if (count($arResult['ADMIN_CATEGORIES']) > 0):?>
			<table class="response-table">
				<thead>
				<tr>
					<th>Отзыв</th>
					<th>Действия</th>
				</tr>
				</thead>
				<tbody>
					<?php foreach ($arResult['ADMIN_CATEGORIES'] as $category): ?>
					<tr>
						<td><?= htmlspecialcharsbx($category->getTitle()) ?></td>
						<td>
							<?php if ($category->getTitle() !== 'Другое'): ?>
							<div class="responseBtns" >
								<form action="/category/delete/" method="post">
									<?=bitrix_sessid_post()?>
									<input type="number" hidden="hidden" name="categoryId" value="<?= $category->getId() ?>">
									<button type="submit">Удалить</button>
								</form>
							</div>
							<?php endif; ?>
						</td>
					</tr>
					<?php endforeach; ?>
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
					<p class="empty">У вас пока нет категорий</p>
				</div>
			<?php endif;?>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
