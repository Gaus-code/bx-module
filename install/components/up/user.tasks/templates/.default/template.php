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
	<?php $APPLICATION->IncludeComponent('up:user.aside', '', [
		'USER_ID' => $arParams['USER_ID'],
	]); ?>
	<section class="content">
		<?php if ($arResult['USER_ACTIVITY'] === 'owner'):?>
		<article class="content__header">
			<h1 id="quickCreate">Быстрое создание</h1>
			<div class="content__profileCreate">
				<a href="/project/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<?php endif;?>
		<article class="content__name">
			<h2 class="content__tittle">Заявки</h2>
		</article>
		<article class="content__tasks">
			<div class="content__header">
				<ul class="content__tagList">
					<li
						<?php if ($arResult['USER_ACTIVITY'] === 'owner') {echo "id=\"openForOwner-btn\"";}
						else {echo "id=\"open-btn\"";}?>
						class="content__tagItem active-tag-item">
						Открытые
					</li>
					<?php if ($arResult['USER_ACTIVITY'] === 'owner'):?>
					<li id="inProgress-btn" class="content__tagItem">
						В работе
					</li>
					<?php endif; ?>
					<li
						<?php if ($arResult['USER_ACTIVITY'] === 'owner') {echo "id=\"doneTaskForOwner-btn\"";}
						else {echo "id=\"doneTask-btn\"";}?>
						class="content__tagItem">
						Завершенные
					</li>
					<?php if ($arResult['USER_ACTIVITY'] === 'owner'):?>
						<li id="performing-btn" class="content__tagItem">
							Исполняемые
						</li>
					<?php endif; ?>
				<?php if ($arResult['USER_ACTIVITY'] === 'owner'):?>
						<li id="stop-btn" class="content__tagItem">
							Приостановленны
						</li>
					<?php endif; ?>
				</ul>
			</div>
			<form method="get" class="searchForm">
				<input type="text" name="q" placeholder="Поиск задачи">
				<button type="submit" class="searchBtn">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/search.svg" alt="search what you want">
				</button>
			</form>
		</article>
			<?php $APPLICATION->IncludeComponent('up:task.list', 'user', [
				'USER_ID' => $arParams['USER_ID'],
				'IS_PERSONAL_ACCOUNT_PAGE' => true,
				'USER_ACTIVITY' => $arResult['USER_ACTIVITY'],
			]);
			?>

	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/tabContainers.js"></script>