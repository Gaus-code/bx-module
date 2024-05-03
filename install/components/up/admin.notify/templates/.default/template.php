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
	<?php
	$APPLICATION->IncludeComponent('up:admin.aside', '', [
		'USER_ID' => $USER->GetID(),
	]); ?>
	<!-- Вкладка уведомлений для админа !-->
	<section class="admin">
		<article class="content__header">
			<h1>Рабочая область</h1>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Уведомления</h2>
		</article>
		<article class="notify">
			<ul class="notify__list">
				<?php foreach ($arResult['ADMIN_NOTIFY'] as $notify):?>
					<?php if ($notify->getType() === 'task'): ?>
					<li class="notify__item task-report">
						<div class="notify__profile">
							<p>Жалоба на заявку: <?= htmlspecialcharsbx($notify->getTask()->getTitle()) ?></p>
						</div>
						<div class="notify__profile">
							<p>Сообщение: <?= htmlspecialcharsbx($notify->getMessage()) ?></p>
						</div>
						<div class="notify__buttons">
							<a class="notify__accept" href="/task/<?= $notify->getTask()->getId() ?>/">Посмотреть</a>
						</div>
					</li>
					<?php endif;?>
					<?php if ($notify->getType() === 'user'): ?>
					<li class="notify__item user-report">
						<div class="notify__profile">
							<p>Жалоба описание профиля: <?= htmlspecialcharsbx($notify->getToUser()->getBio()) ?></p>
						</div>
						<div class="notify__profile">
							<p>Сообщение: <?= htmlspecialcharsbx($notify->getMessage()) ?></p>
						</div>
						<div class="notify__buttons">
							<a class="notify__accept" href="/profile/<?= $notify->getToUser()->getId() ?>/">Посмотреть</a>
						</div>
					</li>
					<?php endif;?>
					<?php if ($notify->getType() === 'tag'): ?>
					<li class="notify__item tag-report">
						<div class="notify__profile">
							<p>Жалоба на тег в заявке: <?= htmlspecialcharsbx($notify->getTask()->getTitle()) ?> </p>
						</div>
						<div class="notify__profile">
							<p>Сообщение: <?= htmlspecialcharsbx($notify->getMessage()) ?></p>
						</div>
						<div class="notify__buttons">
							<a class="notify__accept" href="/task/<?= $notify->getTask()->getId() ?>/">Посмотреть</a>
						</div>
					</li>
					<?php endif;?>
					<?php if ($notify->getType() === 'feedback'): ?>
					<li class="notify__item feedback-report">
						<div class="notify__profile">
							<p>Жалоба на комментарий: <?= htmlspecialcharsbx($notify->getToFeedback()->getComment()) ?></p>
						</div>
						<div class="notify__profile">
							<p>Сообщение: <?= htmlspecialcharsbx($notify->getMessage()) ?></p>
						</div>
						<div class="notify__buttons">
							<a class="notify__accept" href="/task/<?= $notify->getTask()->getId() ?>/">Посмотреть</a>
						</div>
					</li>
					<?php endif;?>
				<?php endforeach;?>
			</ul>
			<?php
			if ($arParams['CURRENT_PAGE'] !== 1 || $arParams['EXIST_NEXT_PAGE'])
			{
				$APPLICATION->IncludeComponent('up:pagination', '', [
					'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE'],
				]);
			}
			?>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
