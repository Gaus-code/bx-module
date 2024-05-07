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
	$APPLICATION->IncludeComponent('up:user.aside', '', [
		'USER_ID' => $arParams['USER_ID'],
	]); ?>
	<section class="content">
		<?php if ($arResult['USER_ACTIVITY'] === 'owner'):?>
		<article class="content__header header-border">
			<h1 id="quickCreate">Быстрое создание</h1>
			<button type="button" class="plus-link">
				<span class="plus-link__inner"></span>
			</button>
			<div class="content__profileCreate">
				<a href="/project/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?= $arParams['USER_ID'] ?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<?php endif;?>
		<article class="content__name">
			<h2 class="content__tittle">Профиль</h2>
		</article>
	<?php $user=$arResult['USER']?>
			<article class="content__mainBio">
				<div class="content__mainBio_header">
					<?php if ($arResult['PROFILE_IMAGE']):?>
							<?php if ($user->get('SUBSCRIPTION_STATUS') === "Active"):?>
							<div class="userImage__containerPremium gradient-border">

							<?php else:?>
							<div class="userImage__container">
							<?php endif;?>
							<?= CFile::ShowImage($arResult['PROFILE_IMAGE'], 130, 130, );?>
								<?php if ($arResult['USER_ACTIVITY'] === 'owner'):?>
									<form action="/profile/deleteImage" method="post" class="deleteUserImageForm">
										<?= bitrix_sessid_post() ?>
										<button type="submit" class="deleteImgBtn">
											<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/cross.svg" title="удалить изображение" alt="close form cross">
										</button>
									</form>
								<?php endif;?>
						</div>
					<?php else:?>
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/headerUser.svg" alt="user image" class="userImage">
					<?php endif;?>
					<div class="userInfo">
						<p class="userInfo__name"><?= htmlspecialcharsbx($user->getBUser()->getName()) ?></p>
						<p class="userInfo__surname"><?= htmlspecialcharsbx($user->getBUser()->getLastName()) ?></p>
						<?php if((int)$arResult['USER_CONTRACTOR_RATING']['FEEDBACK_COUNT']===0): ?>
							<p class="userInfo__rating">Рейтинг исполнителя: нет отзывов</p>
						<?php else:?>
						<p class="userInfo__rating">Рейтинг исполнителя: <?= htmlspecialcharsbx($arResult['USER_CONTRACTOR_RATING']['RATING']) ?> <span>★</span> (<?= $arResult['USER_CONTRACTOR_RATING']['FEEDBACK_COUNT'] ?> оценки)</p>
						<?php endif;?>
						<?php if((int)$arResult['USER_CLIENT_RATING']['FEEDBACK_COUNT']===0): ?>
							<p class="userInfo__rating">Рейтинг заказчика: нет отзывов</p>
						<?php else:?>
							<p class="userInfo__rating">Рейтинг заказчика: <?= htmlspecialcharsbx($arResult['USER_CLIENT_RATING']['RATING']) ?> <span>★</span> (<?= $arResult['USER_CLIENT_RATING']['FEEDBACK_COUNT'] ?> оценки)</p>
						<?php endif;?>
					</div>
					<?php if ($arResult['USER_ACTIVITY'] === 'owner' && !$arResult['USER']->getIsBanned()):?>
					<a href="/profile/<?= $user->getID() ?>/edit/" class="editProfile">
						редактировать профиль
					</a>
					<?php endif;?>

<!--					если зашел админ-->
					<?php if ($USER->IsAdmin()):?>
						<?php if (!$arResult['USER']->getIsBanned()):?>
<!--							если юзер не забанен-->
							<form action="/user/block/" method="post" >
								<?= bitrix_sessid_post() ?>
								<input hidden="hidden" name="userId" value="<?= $arParams['USER_ID'] ?>">
								<button class="banBtn" type="submit">Заблокировать пользователя</button>
							</form>
						<?php else: ?>
<!--						если юзер забанен-->
							<form action="/user/unblock/" method="post" >
								<?= bitrix_sessid_post() ?>
								<input hidden="hidden" name="userId" value="<?= $arParams['USER_ID'] ?>">
								<button class="banBtn" type="submit">Разлокировать пользователя</button>
							</form>
						<?php endif; ?>
					<?php else: ?>
						<?php if ($arResult['USER']->getIsBanned()):?>
							<p class="banBtn">Профиль заблокирован</p>
						<?php elseif ($arResult['USER_ACTIVITY'] !== 'owner'):?>
							<?php if (!$arResult['ISSET_REPORT']):?>
<!--							если зашел НЕ владелец задачи и не было жалоб от него-->
								<button class="banBtn" type="button">Пожаловаться на пользователя</button>
								<form class="banForm" action="/report/create/" method="post">
									<?= bitrix_sessid_post() ?>
									<input hidden="hidden" name="complaintType" value="user">
									<input hidden="hidden" name="toUserId" value="<?= $arParams['USER_ID'] ?>">
									<button id="closeFormBtn" type="button">
										<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/cross.svg" alt="close form cross">
									</button>
									<textarea class="complaintText" type="text" name="complaintMessage" placeholder="Пожалуйста, опишите проблему"></textarea>
									<button id="sendComplaint" type="submit">Отправить</button>
								</form>
							<?php else :?>
<!--							если жалоба уже отправлена-->
								<p class="banBtn">Вы уже отправили жалобу</p>
							<?php endif; ?>
						<?php endif; ?>
					<?php endif; ?>
				</div>
				<div class="content__mainBio_main">
					<?php
					if (!empty($user->getBio())): ?>
					<h4>Описание профиля:</h4>

						<p class="userInfo__bio"><?= htmlspecialcharsbx($user->getBio()) ?></p>
					<?php
					else: ?>
					<?php if ($arResult['USER_ACTIVITY'] === 'owner'):?>
						<h4>Описание профиля:</h4>
						<p class="userInfo__bio">У вас пока нет описания. Давайте
							<a href="/profile/<?= $user->getID() ?>/edit/">добавим</a></p>
						<?php endif;?>
					<?php
					endif; ?>
				</div>
				<div class="content__mainBio_footer">
					<h4>Аккаунт создан:</h4>
					<p class="userInfo__createdAt"><?= $user->getBUser()->getDateRegister()->format('d.m.Y') ?></p>
				</div>
				<?php if ($arResult['USER_ACTIVITY'] === 'owner'):?>
				<div class="content__mainBio_footer">
					<h4>Подписка активна до:</h4>
					<?php
					if ($user->get('SUBSCRIPTION_STATUS') === "Active")
					{
						?>
						<p class="userInfo__subscription"> <?= $user->get('SUBSCRIPTION_END_DATE') ?></p>
						<?php
					}
					else
					{
						?>
						<p class="userInfo__subscription">У вас пока нет премиум подписки. Хотите
							<a href="/subscription/" class="rainbow-border-link premium-link">завести?</a></p>
						<?php
					} ?>
				</div>

				<div class="content__mainBio_footer">
					<h4>Контакты для связи:</h4>
					<?php
					if (!empty($user->getPhoneNumber())): ?>
						<p class="userInfo__bio">Номер телефона: <?= htmlspecialcharsbx($user->getPhoneNumber()) ?></p>
					<?php
					else: ?>
						<p class="userInfo__bio">У вас не указан телефон. Давайте
							<a href="/profile/<?= $user->getID() ?>/edit/">добавим</a></p>
					<?php
					endif; ?>
					<?php
					if (!empty($user->getContacts())): ?>
						<p class="userInfo__bio">Предпочтительный способ связи: <?= htmlspecialcharsbx($user->getContacts()) ?></p>
					<?php
					else: ?>
						<p class="userInfo__bio">У вас не указан предпочтительный способ для связи. Давайте
							<a href="/profile/<?= $user->getID() ?>/edit/">добавим</a></p>
					<?php
					endif; ?>
				</div>
				<?php endif;?>
			</article>

	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/banForm.js"></script>
