<?php
require($_SERVER["DOCUMENT_ROOT"]."/bitrix/header.php");
$APPLICATION->SetTitle("UKAN - super service");
?>
<main class="main">
	<section class="preview wrapper">
		<div class="preview__container">
			<h1>Стань на шаг ближе <br>
				<span>К работе своей мечты</span>
			</h1>
			<p>Поможем найти работу, которая подойдет вам лучше всего!</p>
			<div class="preview__btnContainer">
				<a href="/sign-up" class="previewBtn">Начать</a>
			</div>
		</div>
	</section>
	<section class="banner">
		<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/Rectangle-1.svg" alt="banner background" class="banner2">
		<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/Rectangle-1.svg" alt="banner background" class="banner1">
	</section>
	<section class="companiesPreview wrapper">
		<div class="companiesPreview__imagesContainer">
			<img id="bitrix" src="<?= SITE_TEMPLATE_PATH ?>/assets/images/bitrix24.svg" alt="bitrix logo">
			<img id="tinkoff" src="<?= SITE_TEMPLATE_PATH ?>/assets/images/tinkoff.png" alt="tinkoff logo">
			<img id="googleMusic" src="<?= SITE_TEMPLATE_PATH ?>/assets/images/googleMusic.svg" alt="google music logo">
			<img id="sber" src="<?= SITE_TEMPLATE_PATH ?>/assets/images/sber.svg" alt="sber logo">
			<img id="yandexMusic" src="<?= SITE_TEMPLATE_PATH ?>/assets/images/yandexMusic.svg" alt="yandex logo">
			<img id="avito" src="<?= SITE_TEMPLATE_PATH ?>/assets/images/avito.png" alt="avito logo">
			<img id="rosTelekom" src="<?= SITE_TEMPLATE_PATH ?>/assets/images/RosTelekom.png" alt="rosTelekom logo">
		</div>
		<div class="companiesPreview__textContainer">
			<h2>Работайте с <span> интересными</span> <br> команиями</h2>
			<p>Выбирай любую и откликайся на заявки!</p>
			<a href="/sign-up" class="previewBtn">Начать</a>
		</div>
	</section>
	<section class="catalogPreview wrapper">
		<div class="catalogPreview__header">
			<h2 class="catalogPreview__tittle">Лучшие <span>заявки</span> для вас</h2>
			<p class="catalogPreview__subtitle">Получите самое быстрое приложение</p>
			<ul class="catalogPreview__list">
				<li class="catalogPreview__item">
					<p class="catalogPreview__text active-text">Все Вакансии</p>
				</li>
				<li class="catalogPreview__item">
					<p class="catalogPreview__text">Разработчикам</p>
				</li>
				<li class="catalogPreview__item">
					<p class="catalogPreview__text">Тестировщикам</p>
				</li>
				<li class="catalogPreview__item">
					<p class="catalogPreview__text">Дизайнерам</p>
				</li>
			</ul>
		</div>
		<div class="catalogPreview__main">
			<div class="card">
				<div class="card__header">
					<p class="card__tag">fulltime</p>
					<p class="card__tag">onsite</p>
					<p class="card__tag">₽300K</p>
				</div>
				<div class="card__main">
					<h3 class="card__tittle">UX designer</h3>
					<p class="card__subtitle">Bitrix24//University</p>
				</div>
				<div class="card__footer">
					<button type="button" class="card__btn">Откликнуться</button>
				</div>
			</div>
			<div class="card">
				<div class="card__header">
					<p class="card__tag">fulltime</p>
					<p class="card__tag">onsite</p>
					<p class="card__tag">₽300K</p>
				</div>
				<div class="card__main">
					<h3 class="card__tittle">UX designer</h3>
					<p class="card__subtitle">Bitrix24//University</p>
				</div>
				<div class="card__footer">
					<button type="button" class="card__btn">Откликнуться</button>
				</div>
			</div>
			<div class="card">
				<div class="card__header">
					<p class="card__tag">fulltime</p>
					<p class="card__tag">onsite</p>
					<p class="card__tag">₽300K</p>
				</div>
				<div class="card__main">
					<h3 class="card__tittle">UX designer</h3>
					<p class="card__subtitle">Bitrix24//University</p>
				</div>
				<div class="card__footer">
					<button type="button" class="card__btn">Откликнуться</button>
				</div>
			</div>
			<div class="card">
				<div class="card__header">
					<p class="card__tag">fulltime</p>
					<p class="card__tag">onsite</p>
					<p class="card__tag">₽300K</p>
				</div>
				<div class="card__main">
					<h3 class="card__tittle">UX designer</h3>
					<p class="card__subtitle">Bitrix24//University</p>
				</div>
				<div class="card__footer">
					<button type="button" class="card__btn">Откликнуться</button>
				</div>
			</div>
			<div class="card">
				<div class="card__header">
					<p class="card__tag">fulltime</p>
					<p class="card__tag">onsite</p>
					<p class="card__tag">₽300K</p>
				</div>
				<div class="card__main">
					<h3 class="card__tittle">UX designer</h3>
					<p class="card__subtitle">Bitrix24//University</p>
				</div>
				<div class="card__footer">
					<button type="button" class="card__btn">Откликнуться</button>
				</div>
			</div>
			<div class="card">
				<div class="card__header">
					<p class="card__tag">fulltime</p>
					<p class="card__tag">onsite</p>
					<p class="card__tag">₽300K</p>
				</div>
				<div class="card__main">
					<h3 class="card__tittle">UX designer</h3>
					<p class="card__subtitle">Bitrix24//University</p>
				</div>
				<div class="card__footer">
					<button type="button" class="card__btn">Откликнуться</button>
				</div>
			</div>
		</div>
	</section>
	<section class="peoplePreview wrapper">
		<div class="peoplePreview__textcontainer">
			<h2>Так много людей уже <span>заняты</span><br> по всему Калининграду</h2>
			<p>Находите надёжных исполнителей для решений любых задач</p>
			<a class="peoplePreview__link" href="/sign-up">Разместить заявку</a>
		</div>
		<div class="peoplePreview__imagecontainer">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/group.png" alt="create your first request">
		</div>
	</section>
</main>
<?php require($_SERVER["DOCUMENT_ROOT"]."/bitrix/footer.php");?>