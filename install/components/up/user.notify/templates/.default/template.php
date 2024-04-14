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
			<h2 class="content__tittle">Ваши Уведомления</h2>
		</article>
		<?php if (count($arResult['RESPONSES']) > 0): ?>
			<article class="notify">
				<ul class="notify__list">
					<?php foreach ($arResult['RESPONSES'] as $response) : ?>
					<li class="notify__item">
						<div class="notify__profile">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/headerUser.svg" alt="user image">
							<div class="userInfo">
								<p class="userInfo__name">
									<a href="/profile/<?=$response->getContractor()->getId()?>/">
										<?= htmlspecialchars($response->getContractor()->getName() . ' ' . $response->getContractor()->getSurname()) ?>
									</a>
								</p>
								<p class="userInfo__surname">откликнулся</p>
							</div>
						</div>
						<div class="notify__title"><span>Заявка:</span> <?= $response->getTask()->getTitle() ?></div>
						<div class="notify__buttons">
							<form action="/approve/response/" method="post">
								<?=bitrix_sessid_post()?>
								<input hidden="hidden" name="taskId" value="<?= $response->getTask()->getId() ?>">
								<input hidden="hidden" name="contractorId" value="<?= $response->getContractorId() ?>">
								<button class="notify__accept" type="submit">Принять</button>
							</form>
							<form action="/reject/response/" method="post">
								<?=bitrix_sessid_post()?>
								<input hidden="hidden" name="taskId" value="<?= $response->getTask()->getId() ?>">
								<input hidden="hidden" name="contractorId" value="<?= $response->getContractorId() ?>">
								<button class="notify__reject" type="submit">Отклонить</button>
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
