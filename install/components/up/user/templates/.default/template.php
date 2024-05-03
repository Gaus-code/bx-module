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
		<article class="content__header">
			<h1>Рабочая область</h1>
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
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/headerUser.svg" alt="user image" class="userImage">
					<div class="userInfo">

						<p class="userInfo__name"><?= htmlspecialcharsbx($user->getBUser()->getName()) ?></p>
						<p class="userInfo__surname"><?= htmlspecialcharsbx($user->getBUser()->getLastName()) ?></p>
						<p class="userInfo__surname">Рейтинг: <?= htmlspecialcharsbx($user->getRating()) ?> (<?= htmlspecialcharsbx($user->getFeedbackCount()) ?> оценки)</p>

					</div>
					<?php if ($arResult['USER_ACTIVITY'] === 'owner' && !$arResult['USER']->getIsBanned()):?>
					<a href="/profile/<?= $user->getID() ?>/edit/" class="editProfile">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/editDots.svg" alt="edit user profile">
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
					<h4>Пожелания по способу для связи:</h4>
					<p class="userInfo__bio"><?= htmlspecialcharsbx($user->getContacts()) ?></p>
				</div>
				<?php endif;?>
			</article>

	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/banForm.js"></script>
