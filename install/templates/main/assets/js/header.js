document.addEventListener('DOMContentLoaded', () => {
	const userBtn = document.querySelector('.header__userBtn');
	const modal = document.querySelector('.header__modal');
	if	(userBtn)
	{
		userBtn.addEventListener('click', () => {
			modal.classList.toggle('header__modal--visible');
		});
	}

	let styleMode = localStorage.getItem('styleMode');
	const styleToggle = document.querySelector("#styleModeBtn");

	const enableDarkStyle = () => {
		document.body.classList.add('darkStyle');
		localStorage.setItem('styleMode', 'dark');
		styleToggle.checked = true;
	};

	const disableDarkStyle = () => {
		document.body.classList.remove('darkStyle');
		localStorage.setItem('styleMode', null);
		styleToggle.checked = false;
	};

	styleToggle.addEventListener('click', () => {
		let styleMode = localStorage.getItem('styleMode');

		if (styleMode !== 'dark')
		{
			enableDarkStyle();
		}
		else
		{
			disableDarkStyle();
		}
	});

	if (styleMode === 'dark')
	{
		enableDarkStyle();
	}
});