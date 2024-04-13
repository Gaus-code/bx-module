<?php

/**
 * @var array $arResult
 * @var array $arParams
 * @var CUser $USER
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
				<a href="/create/project/<?=$arParams['USER_ID']?>/" class="create__link">Создать проект</a>
				<a href="/create/task/<?=$arParams['USER_ID']?>/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваш проект</h2>
		</article>
		<article class="content__userProject">
			<div class="userProject__title">
				<h2>Заголовок проекта мы вставляем сюда мы вставляем сюд мы вставляем сюд мы вставляем сюд мы вставляем сюд</h2>
			</div>
			<div class="userProject__main">
				<p class="userProject__description">
					Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab accusantium animi aperiam architecto consectetur consequuntur cum, cumque debitis dolores eligendi, eos et eveniet, exercitationem explicabo fuga illum impedit ipsam itaque laudantium magni minus neque odio porro possimus qui quidem rem repellat repudiandae similique unde velit vero voluptas voluptate? A accusamus accusantium, ad aliquam aliquid architecto assumenda commodi culpa dicta dolorum eius error et ex explicabo facilis fugiat fugit impedit inventore ipsum itaque provident sint velit, veniam vitae voluptatum? Ab, aliquid iusto laborum magnam molestiae non possimus quae quam qui! Aspernatur at ea eaque earum enim eos facilis fugiat hic id ipsam iste laborum nam nemo neque, perferendis quisquam quos ratione sed similique voluptatem?
				</p>
			</div>
			<div class="userProject__btnContainer">
				<form action="" method="post">
					<button class="deleteProject">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/skull.svg" alt="">
						Удалить проект
					</button>
				</form>
				<a href="/edit/project/1/" class="userProject__edit">Редактировать проект</a>
				<button class="userProject__add">Добавить задачу</button>
			</div>


			<div class="userProject__tasks">
				<h2>Задачи в проекте:</h2>
				<div class="tbl-header">
					<table>
						<thead>
						<tr>
							<th>Название</th>
							<th>Описание</th>
							<th>Приоритет</th>
							<th>Исполнитель</th>
							<th>Статус</th>
							<th>Последние изменения</th>
							<th>Дедлайн</th>
						</tr>
						</thead>
					</table>
				</div>
				<div class="tbl-content">
					<table>
						<tbody>
						<tr>
							<td>Какой-то заголовок такси</td>
							<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto, debitis dignissimos doloremque dolorum ducimus eius, facere, facilis harum hic incidunt laborum molestiae natus nemo possimus provident quidem quod repellendus soluta.</td>
							<td>1</td>
							<td>В поиске исполнителя</td>
							<td>Новая</td>
							<td>20.04.2024 17:56</td>
							<td>22.04.2024 18:56</td>
						</tr>
						<tr>
							<td>Какой-то заголовок такси Какой-то заголовок такси Какой-то заголовок такси</td>
							<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto, debitis dignissimos doloremque dolorum ducimus eius, facere, facilis harum hic incidunt laborum molestiae natus nemo possimus provident quidem quod repellendus soluta.</td>
							<td>2</td>
							<td>В поиске исполнителя</td>
							<td>В заморозке</td>
							<td>20.04.2024 17:56</td>
							<td>22.04.2024 18:56</td>
						</tr>
						<tr>
							<td>Какой-то заголовок такси</td>
							<td>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Architecto, debitis dignissimos doloremque dolorum ducimus eius, facere, facilis harum hic incidunt laborum molestiae natus nemo possimus provident quidem quod repellendus soluta.</td>
							<td>3</td>
							<td>Исполнительный Исполнитель</td>
							<td>Выполняется</td>
							<td>20.04.2024 17:56</td>
							<td>22.04.2024 18:56</td>
						</tr>
						</tbody>
					</table>
				</div>
			</div>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>