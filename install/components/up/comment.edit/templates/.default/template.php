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
			<h2 class="content__tittle">Редактировать отзыв для заявки <span><?= $arResult['COMMENT']->getTask()->getTitle() ?></span></h2>
		</article>
		<article class="content__editComment">
			<form action="" method="post" class="edit__commentForm">
				<div class="stars">
					<div class="star-group">
						<input type="radio" class="star" id="one" name="starRate">
						<input type="radio" class="star" id="two" name="starRate">
						<input type="radio" class="star" id="three" name="starRate">
						<input type="radio" class="star" id="four" name="starRate">
						<input type="radio" class="star" id="five" name="starRate" >
					</div>
				</div>
				<textarea class="edit__commentText" name="editTitle"><?= $arResult['COMMENT']->getFeedback() ?></textarea>
				<button class="edit__commentBtn" type="submit">Редактировать</button>
			</form>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
