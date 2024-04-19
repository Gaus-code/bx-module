const form = document.querySelector('.modalCard__form');

form.addEventListener('input', (e) => {
	const input = e.target;
	const name = input.name;

	if (name && !input.classList.contains('password'))
	{
		localStorage.setItem(name, input.value);
	}
});

document.addEventListener('DOMContentLoaded', () => {
	const inputs = form.querySelectorAll('input');

	inputs.forEach((input) => {
		const name = input.name;

		if (!input.classList.contains('password'))
		{
			const value = localStorage.getItem(name);

			if (value)
			{
				input.value = value;
			}
		}
	});
});