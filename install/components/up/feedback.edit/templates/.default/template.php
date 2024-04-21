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
			<h2 class="content__tittle">Редактировать отзыв для заявки <span>
					<a href="/task/<?=$arResult['FEEDBACK']->getTaskId()?>/"><?= $arResult['FEEDBACK']->getTask()->getTitle() ?></a>
				</span></h2>
		</article>
		<article class="content__editComment">
			<form action="/feedback/edit/" method="post" class="edit__commentForm">
				<?= bitrix_sessid_post() ?>
				<input name="feedbackId" type="hidden" value="<?= $arResult['FEEDBACK']->getId() ?>">
				<div class="rating-area">
					<?php for ($rating = 5; $rating > 0; $rating--): ?>
						<input type="radio" id="star-<?= $rating ?>" name="rating" value="<?= $rating ?>"
							<?php if ($rating === $arResult['FEEDBACK']->getRating()) {echo 'checked'; } ?>>
						<label for="star-<?= $rating ?>" title="Оценка «<?= $rating ?>»"></label>
					<?php endfor; ?>
				</div>
				<textarea class="edit__commentText" name="comment"><?= $arResult['FEEDBACK']->getComment() ?></textarea>
				<button class="edit__commentBtn" type="submit">Сохранить</button>
			</form>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>