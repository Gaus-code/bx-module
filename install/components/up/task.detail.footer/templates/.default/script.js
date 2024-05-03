document.addEventListener('DOMContentLoaded', () => {
	const responseBtn = document.querySelector('.responseBtn');
	const detailForm = document.querySelector('.detail__form');
	const closeResponseBtn = document.querySelector('.closeResponse');

	responseBtn.addEventListener('click', () => {
		detailForm.classList.toggle('hidden');
		responseBtn.classList.toggle('hidden');
	});

	closeResponseBtn.addEventListener('click', () => {
		detailForm.classList.toggle('hidden');
		responseBtn.classList.toggle('hidden');
	});
});