<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");
?>
<section class="content">
	<article class="content__header">
		<h1>Создание проекта</h1>
	</article>
	<article class="content__create">
		<form class="create__form" action="" method="post">
			<input type="text" class="create__title" placeholder="Название проекта">
			<input type="text" class="create__description" placeholder="Описание проекта">
			<button class="createBtn" type="submit">Создать Проект</button>
			<fieldset>
				<legend>Добавьте Заявки К Проеку</legend>
				<ul class="filter__list">
					<li class="filter__item">
						<input type="checkbox" class="filter__checkbox">
						<label class="filter__label">Какая-то сущестующая заявка</label>
					</li>
					<li class="filter__item">
						<input type="checkbox" class="filter__checkbox">
						<label class="filter__label">Какая-то сущестующая заявка</label>
					</li>
					<li class="filter__item">
						<input type="checkbox" class="filter__checkbox">
						<label class="filter__label">Какая-то сущестующая заявка</label>
					</li>
					<li class="filter__item">
						<input type="checkbox" class="filter__checkbox">
						<label class="filter__label">Какая-то сущестующая заявка</label>
					</li>
					<li class="filter__item">
						<input type="checkbox" class="filter__checkbox">
						<label class="filter__label">Какая-то сущестующая заявка</label>
					</li>
					<li class="filter__item">
						<input type="checkbox" class="filter__checkbox">
						<label class="filter__label">Какая-то сущестующая заявка</label>
					</li>
					<li class="filter__item">
						<input type="checkbox" class="filter__checkbox">
						<label class="filter__label">Какая-то сущестующая заявка</label>
					</li>
					<li class="filter__item">
						<input type="checkbox" class="filter__checkbox">
						<label class="filter__label">Какая-то сущестующая заявка</label>
					</li>
					<li class="filter__item">
						<input type="checkbox" class="filter__checkbox">
						<label class="filter__label">Какая-то сущестующая заявка</label>
					</li>
					<li class="filter__item">
						<input type="checkbox" class="filter__checkbox">
						<label class="filter__label">Какая-то сущестующая заявка</label>
					</li>
				</ul>
			</fieldset>
		</form>
	</article>
</section>