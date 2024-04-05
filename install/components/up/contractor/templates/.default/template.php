<?php ?>
<main class="profile__main">
	<?php $APPLICATION->IncludeComponent('up:contractor.aside', '', []); ?>
	<section class="content">
		<article class="content__header">
			<h1>Рабочая область</h1>
		</article>
		<article class="content__name">
			<h2 class="content__tittle">Ваш профиль</h2>
		</article>
		<article class="profileBio">
			<ul class="account__editData">
				<li class="editData__item">
					<h2 class="editData__title">Имя</h2>
					<div class="editData__form">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="edit name" class="editData__img">
						<p class="editData__input">Тут имя вывести</p>
						<button class="editData__btn" type="button" id="accountEditName">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="make your edits"
								 class="editData__btnImg">
						</button>
					</div>
				</li>
				<li class="editData__item">
					<h2 class="editData__title">Почта</h2>
					<div class="editData__form">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/email.svg" alt="edit e-mail address"
							 class="editData__img">
						<p class="editData__input">Тут почту вывести</p>
						<button class="editData__btn" type="button" id="accountEditEmail">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="make your edits"
								 class="editData__btnImg">
						</button>
					</div>
				</li>
				<li class="editData__item">
					<h2 class="editData__title">Фамилия</h2>
					<div class="editData__form">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/user.svg" alt="edit surname"
							 class="editData__img">
						<p class="editData__input">Тут фамилию вывести</p>
						<button class="editData__btn" type="button" id="accountEditSurname">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="make your edits"
								 class="editData__btnImg">
						</button>
					</div>
				</li>
				<li class="editData__item">
					<h2 class="editData__title">Пароль</h2>
					<div class="editData__form">
						<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/key.svg" alt="edit Password"
							 class="editData__img">
						<p class="editData__input">password</p>
						<button class="editData__btn" type="button" id="accountEditPassword">
							<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/edit.svg" alt="make your edits"
								 class="editData__btnImg">
						</button>
					</div>
				</li>
			</ul>
		</article>
	</section>
</main>
