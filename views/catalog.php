<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");
?>
<main class="catalog wrapper">
	<aside class="catalog__aside">
		<h2>Фильтры</h2>
		<p class="catalog__subtitle">Специализация</p>
		<ul class="filter__list">
			<li class="filter__item">
				<input type="checkbox" class="filter__checkbox">
				<label class="filter__label">Frontend-разработчик</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" class="filter__checkbox">
				<label class="filter__label">Backend-разработчик</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" class="filter__checkbox">
				<label class="filter__label">FullStack-разработчик</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" class="filter__checkbox">
				<label class="filter__label">Тестировщик</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" class="filter__checkbox">
				<label class="filter__label">Дизайнер</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" class="filter__checkbox">
				<label class="filter__label">Специалист по безопасности</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" class="filter__checkbox">
				<label class="filter__label">Менеджер</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" class="filter__checkbox">
				<label class="filter__label">Верстальщик</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" class="filter__checkbox">
				<label class="filter__label">DevOps-инженер</label>
			</li>
			<li class="filter__item">
				<input type="checkbox" class="filter__checkbox">
				<label class="filter__label">Аналитик</label>
			</li>
		</ul>
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
		<div class="content__main">
			<?php $APPLICATION->IncludeComponent('up:task.list', '', [
				'CLIENT_ID' => (int)request()->get('user_id'),
				'TAG_ID' => (int)request()->get('tag_id'),
			]);
			?>
		</div>
		<div class="pagination">
			<a href="/catalog/1/" class="pagination__btn">
				Предыдущая страница
			</a>
			<a href="/catalog/1/" class="pagination__btn">
				Следующая страница
			</a>
		</div>
	</section>
</main>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>
