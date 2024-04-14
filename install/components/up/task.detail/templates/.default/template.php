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

<?php if ($arResult['TASK']): ?>
<main class="detail wrapper">
	<div class="detail__mainContainer">
		<section class="detail__header">
			<h1><?= $arResult['TASK']->getTitle() ?></h1>
			<div class="detail__tags">
				<?php foreach ($arResult['TASK']->getTags() as $tag): ?>
					<p class="task__tag"><?= $tag->getTitle() ?></p>
				<?php endforeach; ?>
			</div>
		</section>
		<section class="detail__main">
			<div class="detail__description">
				<?= $arResult['TASK']->getDescription() ?>
			</div>
			<div class="detail__container">
				<div class="detail__status"><?= $arResult['TASK']->getStatus() ?></div>
			</div>
		</section>
		<section class="detail__footer">
			<section class="detail__footer">
				<?php switch ($arResult['USER_ACTIVITY']):
					case 'owner': ?>
						<div class="detail__status">
							<span> Вы владелец этой задачи! Хотите <a href="/edit/task/<?= $arResult['TASK']->getId() ?>/"> отредактировать</a> ее?  </span>
						</div>
						<?php break;
					case 'wait approve this user': ?>
						<div class="detail__status">
							<span> Заказчик этой задачи уже получил уведомление, ждите его решения! </span>
						</div>
						<?php break;
					case 'approved this user': ?>
						<div class="detail__status">
							<span> Круто, ваш отклик подтвердили! Заказчик ждет, что Вы с ним свяжетесь! </span>
						</div>
						<?php break;
					case 'approved other user': ?>
						<div class="detail__status">
							<span> К сожалению, эту задачу уже кто-то выполняет </span>
						</div>
						<?php break;
					default: ?>
						<form action="/create/response/" class="detail__form" method="post">
							<?= bitrix_sessid_post() ?>
							<input type="hidden" name="taskId" value="<?= $arResult['TASK']->getId() ?>">
							<label for="setPrice">Добавьте стоимость:</label>
							<input name="price" required id="setPrice" type="number" class="create__title" placeholder="Ваша цена">
							<label for="detail__coverLetter">Добавьте сопроводительное письмо:</label>
							<textarea id="detail__coverLetter" name="coverLetter"></textarea>
							<button class="detail__btn" type="submit">Откликнуться</button>
						</form>
					<?php endswitch; ?>
			</section>
	</div>
	<div class="detail__metaContainer">
		<section class="metaContainer__header">
			<h2>Дополнительная информация:</h2>
			<ul class="metaContainer__list">
				<li class="metaContainer__item">
					<p class="metaContainer__info">
						<span>Задача создана:</span>
						<?= $arResult['TASK']->getCreatedAt() ?>
					</p>
				</li>
				<li class="metaContainer__item">
					<p class="metaContainer__info">
						<span>Заказчик:</span>
						<?= $arResult['TASK']->getClient()->getName() . ' ' . $arResult['TASK']->getClient()->getSurname() ?>
					</p>
				</li>
			</ul>
		</section>
	</div>
</main>
<?php else: ?>
	<main class="detail wrapper">
		<section class="detail__header">
			<h1>Задача не найдена!</h1
		</section>
	</main>
<?php endif; ?>
