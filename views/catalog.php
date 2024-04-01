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
			<div href="/task/1/" class="task">
				<a href="/task/1/" class="task__link">
					<div class="task__header">
						<p class="task__tag">Website</p>
						<p class="task__tag">Design</p>
						<div class="task__edit">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="edit task">
						</div>
					</div>
					<div class="task__main">
						<h3>Bugo Website About page</h3>
						<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
					</div>
				</a>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>Заказчик Заказчиков</p>
					</div>
					<div class="task__respond">
						<button class="task__respond__btn">Откликнуться</button>
					</div>
				</div>
			</div>
			<div href="/task/1/" class="task">
				<a href="/task/1/" class="task__link">
					<div class="task__header">
						<p class="task__tag">Website</p>
						<p class="task__tag">Design</p>
						<div class="task__edit">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="edit task">
						</div>
					</div>
					<div class="task__main">
						<h3>Bugo Website About page</h3>
						<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
					</div>
				</a>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>Заказчик Заказчиков</p>
					</div>
					<div class="task__respond">
						<button class="task__respond__btn">Откликнуться</button>
					</div>
				</div>
			</div>
			<div href="/task/1/" class="task">
				<a href="/task/1/" class="task__link">
					<div class="task__header">
						<p class="task__tag">Website</p>
						<p class="task__tag">Design</p>
						<div class="task__edit">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="edit task">
						</div>
					</div>
					<div class="task__main">
						<h3>Bugo Website About page</h3>
						<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
					</div>
				</a>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>Заказчик Заказчиков</p>
					</div>
					<div class="task__respond">
						<button class="task__respond__btn">Откликнуться</button>
					</div>
				</div>
			</div>
			<div href="/task/1/" class="task">
				<a href="/task/1/" class="task__link">
					<div class="task__header">
						<p class="task__tag">Website</p>
						<p class="task__tag">Design</p>
						<div class="task__edit">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="edit task">
						</div>
					</div>
					<div class="task__main">
						<h3>Bugo Website About page</h3>
						<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
					</div>
				</a>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>Заказчик Заказчиков</p>
					</div>
					<div class="task__respond">
						<button class="task__respond__btn">Откликнуться</button>
					</div>
				</div>
			</div>
			<div href="/task/1/" class="task">
				<a href="/task/1/" class="task__link">
					<div class="task__header">
						<p class="task__tag">Website</p>
						<p class="task__tag">Design</p>
						<div class="task__edit">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="edit task">
						</div>
					</div>
					<div class="task__main">
						<h3>Bugo Website About page</h3>
						<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
					</div>
				</a>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>Заказчик Заказчиков</p>
					</div>
					<div class="task__respond">
						<button class="task__respond__btn">Откликнуться</button>
					</div>
				</div>
			</div>
			<div href="/task/1/" class="task">
				<a href="/task/1/" class="task__link">
					<div class="task__header">
						<p class="task__tag">Website</p>
						<p class="task__tag">Design</p>
						<div class="task__edit">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="edit task">
						</div>
					</div>
					<div class="task__main">
						<h3>Bugo Website About page</h3>
						<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
					</div>
				</a>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>Заказчик Заказчиков</p>
					</div>
					<div class="task__respond">
						<button class="task__respond__btn">Откликнуться</button>
					</div>
				</div>
			</div>
			<div href="/task/1/" class="task">
				<a href="/task/1/" class="task__link">
					<div class="task__header">
						<p class="task__tag">Website</p>
						<p class="task__tag">Design</p>
						<div class="task__edit">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="edit task">
						</div>
					</div>
					<div class="task__main">
						<h3>Bugo Website About page</h3>
						<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
					</div>
				</a>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>Заказчик Заказчиков</p>
					</div>
					<div class="task__respond">
						<button class="task__respond__btn">Откликнуться</button>
					</div>
				</div>
			</div>
			<div href="/task/1/" class="task">
				<a href="/task/1/" class="task__link">
					<div class="task__header">
						<p class="task__tag">Website</p>
						<p class="task__tag">Design</p>
						<div class="task__edit">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="edit task">
						</div>
					</div>
					<div class="task__main">
						<h3>Bugo Website About page</h3>
						<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
					</div>
				</a>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>Заказчик Заказчиков</p>
					</div>
					<div class="task__respond">
						<button class="task__respond__btn">Откликнуться</button>
					</div>
				</div>
			</div>
			<div href="/task/1/" class="task">
				<a href="/task/1/" class="task__link">
					<div class="task__header">
						<p class="task__tag">Website</p>
						<p class="task__tag">Design</p>
						<div class="task__edit">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="edit task">
						</div>
					</div>
					<div class="task__main">
						<h3>Bugo Website About page</h3>
						<p class="task__description">Amet minim mollit non deserunt ullamco est sit aliqua dolor do amet sint. Velit officia consequat duis enim velit mollit. Exercitation veniam consequat sunt nostrud amet.</p>
					</div>
				</a>
				<div class="task__footer">
					<div class="task__footer_img">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
						<p>Заказчик Заказчиков</p>
					</div>
					<div class="task__respond">
						<button class="task__respond__btn">Откликнуться</button>
					</div>
				</div>
			</div>
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
