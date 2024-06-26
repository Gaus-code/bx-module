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
<main class="profile__main">
	<?php $APPLICATION->IncludeComponent('up:user.aside', '', [
		'USER_ID' => $arParams['USER_ID'],
	]); ?>
	<section class="content">
		<article class="content__header header-border">
			<h1 id="quickCreate">Быстрое создание</h1>
			<div class="content__profileCreate">
				<a href="/project/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваши Уведомления</h2>
		</article>
		<?php if (count($arResult['NOTIFICATIONS']) > 0): ?>
			<article class="notify">
				<ul class="notify__list">
					<?php foreach ($arResult['NOTIFICATIONS'] as $notification) : ?>
						<li class="notify__item">
							<div class="notify__profileUser">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/headerUser.svg" alt="user image">
								<div class="userInfo">
									<p class="userInfo__name">
										<a href="/profile/<?=$notification->getFromUserId()?>/">
											<?= htmlspecialcharsbx($notification->getFromUser()->getBUser()->getName() . ' ' . $notification->getFromUser()->getBUser()->getLastName()) ?>
										</a>
									</p>
								</div>
							</div>
							<div class="notify__profile">
								<p><?=$notification->getMessage()?></p>
							</div>
							<div class="notify__title">
								<?php if ($notification->getTask()): ?>
									<span>Заявка:</span> <?=htmlspecialcharsbx($notification->getTask()->getTitle())  ?>
								<?php else: ?>
									<span>Без заявки</span>
								<?php endif; ?>
							</div>
							<div class="notify__buttons">
								<?php if ($notification->getTask()): ?>
									<a class="notify__accept" href="/task/<?= $notification->getTask()->getId() ?>/">Посмотреть</a>
								<?php endif; ?>
								<form action="/notification/delete/" method="post">
									<?=bitrix_sessid_post()?>
									<input hidden="hidden" name="notificationId" value="<?= $notification->getId() ?>">
									<button class="notify__reject" type="submit">Удалить</button>
								</form>
							</div>
						</li>
					<?php endforeach; ?>
				</ul>
			</article>
			<?php
			if ($arParams['CURRENT_PAGE'] !== 1 || $arParams['EXIST_NEXT_PAGE'])
			{
				$APPLICATION->IncludeComponent('up:pagination', '', [
					'EXIST_NEXT_PAGE' => $arParams['EXIST_NEXT_PAGE'],
				]);
			}
			?>
		<?php else: ?>
			<div class="contractor__emptyContainer">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/EmptyInbox.svg" alt="empty inbox image">
				<p class="contractor__emptyLink">У нас пока нет уведомлений</p>
			</div>
		<?php endif; ?>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
