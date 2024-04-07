<aside class="aside">
	<div class="aside__profile">
		<p class="profile__name">Исполнительный Исполнитель Исполняет</p>
		<p class="profile__email">ispIsSuper007@gmail.com</p>
	</div>
	<div class="aside__header">
		<nav class="aside__nav">
			<button type="button" class="aside__btn active-profile-btn">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/dashboard.svg" alt="task folder">
				Рабочая Область
			</button>

			<div class="aside__navContainer">
				<a href="/contractor/1/" type="button" class="aside__btn">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/task.svg" alt="task folder">
					Ваш профиль
				</a>
			</div>

			<div class="aside__navContainer">
				<a href="/contractor/1/responses/" class="aside__btn">
					<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/folder.svg" alt="project folder">
					Отклики
				</a>
			</div>

			<a href="/contractor/1/notifications/" class="aside__btn">
				<img src="<?= SITE_TEMPLATE_PATH ?>/assets/images/email.svg" alt="notification folder">
				Уведомления
				<span>2</span>
			</a>
		</nav>
		<a href="/logout?sessid=<?= bitrix_sessid() ?>" class="profile__logOut">Выйти</a>
	</div>
</aside>