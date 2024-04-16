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
			<h2 class="content__tittle">Ваш профиль</h2>
		</article>
		<article class="profile__changeBio">
			<?php $APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
			<h2 class="profile__changeBio_title">Смена личной информации</h2>
			<form action="/profile/changeBio" method="post" class="profile__changeBio_form">
				<?php $user = $arResult['USER']?>
					<?= bitrix_sessid_post() ?>
					<ul class="editData__list">
						<li class="editData__item">
							<h2 class="editData__title">Имя</h2>
							<div class="editData__form">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="edit name" class="editData__img">
								<input type="text" class="editData__input" name="userName" value="<?= $user->getBUser()->getName() ?>">
							</div>
						</li>
						<li class="editData__item">
							<h2 class="editData__title">Фамилия</h2>
							<div class="editData__form">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="edit surname"
									 class="editData__img">
								<input type="text" class="editData__input" name="userLastName" value="<?= $user->getBUser()->getLastName() ?>">
							</div>
						</li>
						<li class="editData__item">
							<h2 class="editData__title">Почта</h2>
							<div class="editData__form">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/email.svg" alt="edit email"
									 class="editData__img">
								<input type="text" class="editData__input" name="userEmail" value="<?= $user->getBUser()->getEmail() ?>">
							</div>
						</li>
						<li class="editData__item">
							<h2 class="editData__title">Логин</h2>
							<div class="editData__form">
								<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="edit login"
									 class="editData__img">
								<input type="text" class="editData__input" name="userLogin" value="<?= $user->getBUser()->getLogin() ?>">
							</div>
						</li>
					</ul>
					<div class="editData__bioContainer">
						<div class="editData__textArea">
							<h2 class="editData__title">Описание профиля</h2>
							<textarea class="editData__bio" name="userBio"><?=$user->getBio()?></textarea>
						</div>
						<input type="hidden" value="<?= $user->getID() ?>" name="userId">
						<button type="submit">Изменить основную информацию</button>
					</div>
			</form>
		</article>
		<article class="profile__changePassword">
			<h2 class="profile__changeBio_title">Смена пароля</h2>
			<form action="/profile/changePassword" method="post" class="changePassword__form">
				<?= bitrix_sessid_post() ?>
				<ul class="changePassword__list">
					<li class="changePassword__item">
						<h2 class="editData__title">Старый пароль</h2>
						<input type="password" class="changePassword__input" name="oldPassword" >
					</li>
					<li class="changePassword__item">
						<h2 class="editData__title">Новый пароль</h2>
						<input type="password" class="changePassword__input" name="newPassword" >
					</li>
					<li class="changePassword__item">
						<h2 class="editData__title">Подтверждение пароля</h2>
						<input type="password" class="changePassword__input" name="confirmPassword" >
					</li>
				</ul>
				<button class="changePassword__btn" type="submit">Изменить пароль</button>
			</form>
		</article>
	</section>
</main>
<script src="<?= SITE_TEMPLATE_PATH ?>/assets/js/profile.js"></script>