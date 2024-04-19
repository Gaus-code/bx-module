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
				<a href="/project/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваши Отзывы</h2>
		</article>
		<div class="content__comment">
			<div class="comment__categories">
				<ul class="responses__tagList">
					<li id="client-btn" class="responses__tagItem active-tag-item">
						Ваши отзывы
					</li>
					<li id="contractor-btn" class="responses__tagItem">
						Отзывы исполнителей
					</li>
					<li id="waiting-btn" class="responses__tagItem">
						Ждут отзыва
					</li>
				</ul>
			</div>
			<!-- Отзывы, которые оставил сам исполнитель(не забудь УДАЛИТЬ этот коммент) !-->
			<div id="client-reviews" class="comment__container client-reviews">
				<ul class="clientComment__list">
					<!-- Жесткий HARDCODE!!!!(не забудь УДАЛИТЬ этот коммент) !-->
					<li class="clientComment__item">
						<div class="comment__header">
							<p class="comment__title">Заявка и ее тайтл какой-то</p>
							<div class="comment__rating">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/star.svg" alt="star rating img">
								<p>4.8</p>
							</div>
						</div>
						<p class="comment__body">спасибо за индивидуальную упаковку, она спасла книгу от перевозки :) спасибо за индивидуальную упаковку, она спасла книгу от перевозки :) спасибо за индивидуальную упаковку, она спасла книгу от перевозки :)</p>
						<div class="comment__footer">
							<p class="comment__date"> <span>Опубликован:</span> 18.04.2024</p>
							<div class="comment__btnContainer">
								<a href="/comment/1/edit/">Редактировать</a>
								<form method="post" action="/comment/delete">
									<button type="submit">Удалить</button>
								</form>
							</div>
						</div>
					</li>
					<li class="clientComment__item">
						<div class="comment__header">
							<p class="comment__title">Заявка и ее тайтл какой-то</p>
							<div class="comment__rating">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/star.svg" alt="star rating img">
								<p>5</p>
							</div>
						</div>
						<p class="comment__body">спасибо за индивидуальную упаковку, она спасла книгу от перевозки :)</p>
						<div class="comment__footer">
							<p class="comment__date"> <span>Опубликован:</span> 18.04.2024</p>
							<div class="comment__btnContainer">
								<a href="/comment/1/edit/">Редактировать</a>
								<form method="post" action="/comment/delete/">
									<button type="submit">Удалить</button>
								</form>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<!-- Отзывы, которые оставлены исполнителю(не забудь УДАЛИТЬ этот коммент) !-->
			<div id="contractor-reviews" class="comment__container contractor-reviews">
				<ul class="clientComment__list">
					<!-- Жесткий HARDCODE!!!!(не забудь УДАЛИТЬ этот коммент) !-->
					<li class="clientComment__item">
						<div class="comment__header">
							<p class="comment__title">Заявка и ее тайтл какой-то</p>
							<div class="comment__rating">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/star.svg" alt="star rating img">
								<p>5</p>
							</div>
						</div>
						<p class="comment__body">тут текст отзыва исполнителя вставляется Lorem ipsum dolor sit amet, consectetur adipisicing elit. Amet aperiam commodi consequatur delectus dicta dolore doloremque eaque enim, et eveniet excepturi exercitationem facere fuga harum laudantium molestiae natus obcaecati perspiciatis quam quasi quis quisquam ratione reprehenderit sequi sunt suscipit vel.</p>
						<div class="comment__footer">
							<p class="comment__date"> <span>Опубликован:</span> 18.04.2024</p>
							<div class="comment__btnContainer">
								<img class="comment__userPhoto" src="<?= SITE_TEMPLATE_PATH ?>/assets/images/headerUser.svg" alt="contractor photo">
								<p>Исполнительный исполнитель</p>
							</div>
						</div>
					</li>
					<li class="clientComment__item">
						<div class="comment__header">
							<p class="comment__title">Заявка и ее тайтл какой-то</p>
							<div class="comment__rating">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/star.svg" alt="star rating img">
								<p>5</p>
							</div>
						</div>
						<p class="comment__body">спасибо за индивидуальную упаковку, она спасла книгу от перевозки :)</p>
						<div class="comment__footer">
							<p class="comment__date"> <span>Опубликован:</span> 18.04.2024</p>
							<div class="comment__btnContainer">
								<img class="comment__userPhoto" src="<?= SITE_TEMPLATE_PATH ?>/assets/images/headerUser.svg" alt="contractor photo">
								<p>Исполнительный исполнитель</p>
							</div>
						</div>
					</li>
				</ul>
			</div>
			<!-- выполненные заявки, на которые ожидается отзыв(не забудь УДАЛИТЬ этот коммент) !-->
			<div id="waiting-reviews" class="comment__container waiting-reviews">
				<ul class="clientComment__list">
					<!-- Жесткий HARDCODE!!!!(не забудь УДАЛИТЬ этот коммент) !-->
					<li class="clientComment__item">
						<div class="comment__header">
							<p class="comment__waiting">Заявка и ее тайтл какой-то <span>выполнена</span></p>
							<a class="comment__waitingLink" href="/task/1/">Отставить отзыв</a>
						</div>
					</li>
					<li class="clientComment__item">
						<div class="comment__header">
							<p class="comment__waiting">Заявка и ее тайтл какой-то <span>выполнена</span></p>
							<a class="comment__waitingLink" href="/task/1/">Отставить отзыв</a>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/comment.js"></script>
