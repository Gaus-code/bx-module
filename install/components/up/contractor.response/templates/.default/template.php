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
	<?php $APPLICATION->IncludeComponent('up:contractor.aside', '', []); ?>
	<section class="content">
		<article class="content__header">
			<h1>Рабочая область</h1>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваши Отклики</h2>
		</article>
		<div class="contractor__emptyContainer">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/EmptyResponce.svg" alt="empty responses image">
			<p class="contractor__emptyLink">Пока что тут пусто.</p>
			<p class="contractor__emptyLink">Давайте попробуем <a href="/catalog/1/">откликнуться</a>!</p>
		</div>
	</section>
</main>
