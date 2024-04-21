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

<main class="catalog wrapper">
	<aside class="catalog__aside">
		<form method="get">
			<h2>Фильтры</h2>
			<p class="catalog__subtitle">Специализация</p>
			<ul class="filter__list">
				<?php foreach ($arResult['TAGS'] as $tag): ?>
					<li class="filter__item">
						<?php if (!empty($arParams['TAGS_ID']) && in_array($tag->getId(), $arParams['TAGS_ID'], false)): ?>
						<input type="checkbox" class="filter__checkbox" name="tags[]" value="<?=$tag->getId()?>" checked>
						<?php else: ?>
						<input type="checkbox" class="filter__checkbox" name="tags[]" value="<?=$tag->getId()?>">
						<?php endif;?>
						<label class="filter__label"><?= htmlspecialcharsbx($tag->getTitle()) ?></label>
					</li>
				<?php endforeach; ?>
			</ul>
			<button type="button" id="resetFilters">Очистить Мой Выбор</button>
			<button class="filterBtn" type="submit">Отфильтровать</button>
		</form>
	</aside>
	<section class="catalog__main">
		<div class="catalog__header">
			<h1>Рекомендованные вакансии <span>369</span></h1>

			<select name="sortBy" class="catalog__sort">
				<option value="all">Все</option>
				<option value="new">Сначала новые</option>
				<option value="old">Сначала старые</option>
				<option value="low">Сначала высокая цена</option>
				<option value="high">Сначала низкая цена</option>
			</select>
		</div>

		<?php $APPLICATION->IncludeComponent('up:task.list', '', [
			'CLIENT_ID' => (int)request()->get('user_id'),
		]);
		?>
		<div class="adv">
			<a href="/subscription/" id="advLink">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/ufo.svg" alt="ufo image">
			</a>
		</div>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/catalog.js"></script>