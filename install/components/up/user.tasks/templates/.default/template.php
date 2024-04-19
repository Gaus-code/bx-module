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
				<a href="/project/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваши Заявки</h2>
		</article>
		<article class="content__tasks">
			<div class="content__header">
				<ul class="content__tagList">
					<li id="open-btn" class="content__tagItem active-tag-item">
						Открытые
					</li>
					<li id="inProgress-btn" class="content__tagItem">
						В работе
					</li>
					<li id="doneTask-btn" class="content__tagItem">
						Завершенные
					</li>
				</ul>
			</div>
		</article>
			<?php $APPLICATION->IncludeComponent('up:task.list', 'user', [
				'CLIENT_ID' => (int)request()->get('user_id'),
				'TAG_ID' => (int)request()->get('tag_id'),
				'IS_PERSONAL_ACCOUNT_PAGE' => true,
			]);
			?>

	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/tabContainers.js"></script>