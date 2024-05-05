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
		<article class="content__header">
			<h1 id="quickCreate">Быстрое создание</h1>
			<div class="content__profileCreate">
				<a href="/project/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать проект</a>
				<a href="/task/<?=$arParams['USER_ID']?>/create/" class="create__link">Создать заявку</a>
			</div>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваш профиль</h2>
		</article>
		<?php $user = $arResult['USER']?>
		<article class="profile__changeImage">
			<h2 class="profile__changeBio_title">Смена фотографии</h2>
			<form class="changeImageForm" action="/profile/changeImage" method="post" enctype="multipart/form-data">
				<?php echo bitrix_sessid_post(); ?>
				<?= $arResult['FILES']->show(); ?>
				<button class="changeImageBtn" type="submit">Изменить фотографию</button>
			</form>
		</article>
		<article class="profile__changeContacts">
			<?php $APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
			<h2 class="profile__changeBio_title">Контакты для связи</h2>
			<p>*будут видеть ваши исполнители</p>
			<form action="/profile/changeContacts" method="post" class="profile__changeContacts_form">
				<?= bitrix_sessid_post() ?>
				<div class="editData__item">
					<label class="editData__title">Телефон</label>
					<input type="tel" name="phoneNumber" value="<?= $user->getPhoneNumber(); ?>">
				</div>
				<div class="editData__item">
					<label class="editData__title">Пожелания по способу связи</label>
					<input type="text" name="contacts" value="<?= $user->getContacts(); ?>" placeholder="Пожелания по способу связи">
				</div>
				<button type="submit">Редактировать</button>
			</form>
		</article>
		<article class="profile__changeBio">
			<?php $APPLICATION->IncludeComponent('up:errors.message', '', []); ?>
			<h2 class="profile__changeBio_title">Смена личной информации</h2>
			<form action="/profile/changeBio" method="post" class="profile__changeBio_form">
					<?= bitrix_sessid_post() ?>
					<ul class="editData__list">
						<li class="editData__item">
							<label class="editData__title">Имя</label>
							<input type="text" class="editData__input" name="userName" value="<?=htmlspecialcharsbx($user->getBUser()->getName())  ?>">
						</li>
						<li class="editData__item">
							<label class="editData__title">Фамилия</label>
							<input type="text" class="editData__input" name="userLastName" value="<?= htmlspecialcharsbx($user->getBUser()->getLastName()) ?>">
						</li>
						<li class="editData__item">
							<label class="editData__title">Почта</label>
							<input type="text" class="editData__input" name="userEmail" value="<?= htmlspecialcharsbx($user->getBUser()->getEmail()) ?>">
						</li>
						<li class="editData__item">
							<label class="editData__title">Логин</label>
							<input type="text" class="editData__input" name="userLogin" value="<?= htmlspecialcharsbx($user->getBUser()->getLogin()) ?>">

						</li>
					</ul>
					<div class="editData__bioContainer">
						<div class="editData__textArea">
							<h2 class="editData__title">Описание профиля</h2>
							<textarea class="editData__bio" name="userBio"><?=htmlspecialcharsbx($user->getBio())?></textarea>
						</div>
						<input type="hidden" value="<?= $user->getID() ?>" name="userId">
						<button type="submit">Изменить личную информацию</button>
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