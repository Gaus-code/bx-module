document.addEventListener('DOMContentLoaded', () => {
	const userBtn = document.querySelector('.header__userBtn');
	const modal = document.querySelector('.header__modal');

	userBtn.addEventListener('click', () => {
		modal.classList.toggle('header__modal--visible');
	});
});