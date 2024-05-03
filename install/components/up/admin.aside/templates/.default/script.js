document.addEventListener('DOMContentLoaded', () => {
	const asideBtns = document.querySelectorAll('.aside__btn');
	const currentPath = window.location.pathname;

	asideBtns.forEach((btn) => {
		if (btn.href.includes(currentPath))
		{
			btn.style.backgroundColor = 'rgb(115, 103, 240)';
		}
	});
});
