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

<form method="get" class="searchForm">
	<input type="text" name="q" placeholder="Поиск...">
	<button type="submit" class="searchBtn">
		<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/search.svg" alt="search what you want">
	</button>
</form>
<div class="content__main">
	<?php if (count($arResult['TASKS']) > 0): ?>
		<?php foreach ($arResult['TASKS'] as $task): ?>
			<?php if($task->getClient()->getSubscriptionEndDate() >= date("Y-m-d")):?>
			<div class="task subscriberTask">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/catalogCrown.svg" alt="star image" class="subscriberStar">
			<?php else:?>
			<div class="task">
			<?php endif;?>
					<div class="task__main">
						<h3><?= htmlspecialcharsbx($task->getTitle()) ?></h3>
						<?php if (count($task->getTags()) > 0):?>
						<p class="task__description"><?= htmlspecialcharsbx($task->getDescription()) ?>
						<?php else:?>
						<p class="task__descriptionWithoutTags"><?= htmlspecialcharsbx($task->getDescription()) ?>
						<?php endif;?>
					</div>
					<div class="task__header">
						<?php foreach ($task->getTags() as $tag): ?>
							<p class="task__tag"><?=htmlspecialcharsbx($tag->getTitle())  ?></p>
						<?php endforeach; ?>
					</div>
					<div class="task__footer">

						<?php if (!$arParams['IS_PERSONAL_ACCOUNT_PAGE']): ?>
							<div class="task__footer_img">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/people.svg" alt="count executers">
								<p><?= htmlspecialcharsbx($task->getClient()->getBUser()->getName() . ' ' . $task->getClient()->getBUser()->getLastName()) ?></p>
							</div>
						<?php endif; ?>
					</div>
				<div class="overlay"></div>
				<div class="task__button"><a class="task__link" href="/task/<?= $task->getId() ?>/">Подробнее</a></div>
			</div>
		<?php endforeach; ?>
</div>

		<?php
		if ($arParams['CURRENT_PAGE'] !== 1 || $arParams['EXIST_NEXT_PAGE'])
		{
			$APPLICATION->IncludeComponent('up:pagination', '', [
				'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE'],
			]);
		}
		?>
	<?php else: ?>
		<div class="content__image">
			<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/NoTasks.svg" alt="no tasks image">
			<p>Пока что тут нет заявок</p>
		</div>
	<?php endif; ?>

