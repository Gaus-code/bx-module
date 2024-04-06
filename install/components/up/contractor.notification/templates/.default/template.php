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
			<h2 class="content__tittle">Ваши Уведомления</h2>
		</article>
		<div class="contractor__emptyContainer">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/EmptyInbox.svg" alt="empty inbox image">
			<p class="contractor__emptyLink">У нас пока нет уведомлений</p>
		</div>
	</section>
</main>