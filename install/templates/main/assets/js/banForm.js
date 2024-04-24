const banBtn = document.querySelector('.banBtn');
const banForm = document.querySelector('.banForm');
const closeFormBtn = document.querySelector('#closeFormBtn');

banBtn.addEventListener('click', () => {
	banForm.style.transition = 'opacity 0.3s ease-in-out';
	banForm.style.opacity = '1';
	banBtn.style.opacity = '0';
	banBtn.style.transition = 'opacity 0.3s ease-in-out';
	banForm.style.display = 'block';
});

closeFormBtn.addEventListener('click', () => {
	banForm.style.transition = 'opacity 0.3s ease-in-out';
	banForm.style.opacity = '0';
	banBtn.style.opacity = '1';
	banBtn.style.transition = 'opacity 0.3s ease-in-out';
	banForm.style.display = 'none';
});