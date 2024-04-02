<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");
?>
<section class="content">
	<article class="content__header">
		<h1>Создание Заявки</h1>
	</article>
	<article class="content__create">
		<form class="create__form" action="" method="post">
			<div class="create__text">
				<div class="create__container">
					<label class="create__textareaLabel" for="createTitle">Добавьте Название</label>
					<input id="createTitle" type="text" class="create__title" placeholder="Название заявки">
				</div>
				<div class="create__container">
					<label class="create__textareaLabel" for="taskDescription">Добавьте Описание</label>
					<textarea name="" id="taskDescription" class="create__description" cols="30" rows="10"></textarea>
				</div>
			</div>
			<div class="create__fieldsetContainer">
				<fieldset>
					<legend>Добавьте Специализацию</legend>
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
				</fieldset>
				<fieldset>
					<legend>Добавьте Приоритетность</legend>
					<ul class="filter__list">
						<li class="filter__item">
							<input type="radio" name="priority" class="filter__checkbox">
							<label class="filter__label">Высокая</label>
						</li>
						<li class="filter__item">
							<input type="radio" name="priority" class="filter__checkbox">
							<label class="filter__label">Средняя</label>
						</li>
						<li class="filter__item">
							<input type="radio" name="priority" class="filter__checkbox">
							<label class="filter__label">Низкая</label>
						</li>
					</ul>
				</fieldset>
				<fieldset>
					<legend>Добавьте Статаус</legend>
					<ul class="filter__list">
						<li class="filter__item">
							<input type="radio" name="status" class="filter__checkbox">
							<label class="filter__label">Новая</label>
						</li>
						<li class="filter__item">
							<input type="radio" name="status" class="filter__checkbox">
							<label class="filter__label">В заморозке??</label>
						</li>
					</ul>
				</fieldset>
			</div>
			<button class="createBtn" type="submit">Создать заявку</button>
		</form>
	</article>
</section>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>