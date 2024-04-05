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
	<?php $APPLICATION->IncludeComponent('up:client.aside', '', []); ?>
	<section class="content">
		<article class="content__header">
			<h1>Рабочая область</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner">+</span>
			</button>
			<div class="content__profileCreate">
				<a href="/create/project/" class="create__link">Создать проект</a>
				<a href="/create/task/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваши проекты</h2>
		</article>
		<article class="content__main">
			<?php $APPLICATION->IncludeComponent('up:task.list', '', [
				'CLIENT_ID' => (int)request()->get('user_id'),
				'TAG_ID' => (int)request()->get('tag_id'),
				'IS_PERSONAL_ACCOUNT_PAGE' => true,
			]);
			?>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>