document.addEventListener('DOMContentLoaded', () => {
	const loader = document.getElementById('loader');
	const loaderText = loader.querySelector('p');

	document.getElementById('taskLoader').addEventListener('click', () => {
		loader.style.display = 'flex';

		loaderText.textContent = 'пьем кофе...';
	});
});