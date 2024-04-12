<?php

/**
 * @var array $arResult
 * @var array $arParams
 */

if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true)
{
	die();
}

?>
<main class="profile__main">
	<?php $APPLICATION->IncludeComponent('up:user.aside', '', []); ?>
	<section class="content">
		<article class="content__header">
			<h1>Рабочая область</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner">+</span>
			</button>
			<div class="content__profileCreate">
				<a href="/create/project/<?=$arParams['USER_ID']?>/" class="create__link">Создать проект</a>
				<a href="/create/task/<?=$arParams['USER_ID']?>/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваши Отклики</h2>
		</article>
		<article class="content__responses">
		<?php if (count($arResult['RESPONSES']) > 0): ?>
			<?php foreach ($arResult['RESPONSES'] as $response):?>
				<div href="/task/<?= $response->getTask()->getId() ?>/" class="task__response">
					<a href="/task/<?= $response->getTask()->getId() ?>/" class="task__link">
						<div class="task__header">
							<?php foreach ($response->getTask()->getTags() as $tag): ?>
								<p class="task__tag"><?= $tag->getTitle() ?></p>
							<?php endforeach; ?>
						</div>
						<div class="task__responseMain">
							<h3 class="task__responseTitle"><?= $response->getTask()->getTitle() ?></h3>
							<p class="task__responseCreated"><span>Дата отклика:</span> <?= $response->getCreatedAt() ?> </p>
						</div>
					</a>
					<div class="task__responseFooter">
						<p>Ваша цена: <?= $response->getPrice() ?> </p>
						<form action="/delete/response/" method="post">
							<?=bitrix_sessid_post()?>
							<input hidden="hidden" name="responseId" value="<?= $response->getId() ?>">
							<button class="task__responseDelete" type="submit">Отменить отклик</button>
						</form>
					</div>
				</div>
			<?php endforeach; ?>
			<?php
			if ($arParams['CURRENT_PAGE'] !== 1 || $arParams['EXIST_NEXT_PAGE'])
			{
				$APPLICATION->IncludeComponent('up:pagination', '', [
					'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE'],
				]);
			}
			?>
		</article>
		<?php else: ?>
			<div class="contractor__emptyContainer">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/EmptyResponce.svg" alt="empty responses image">
				<p class="contractor__emptyLink">Пока что тут пусто.</p>
				<p class="contractor__emptyLink">Давайте попробуем <a href="/catalog/">откликнуться</a>!</p>
			</div>
		<?php endif; ?>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
