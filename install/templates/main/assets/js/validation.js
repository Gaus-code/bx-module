document.addEventListener('DOMContentLoaded', () => {
	const forms = document.querySelectorAll('form');

	forms.forEach((form) => {
		form.addEventListener('submit', (e) => {
			e.preventDefault();
			let isValid = true;

			const inputs = form.querySelectorAll('.validate');
			inputs.forEach((input) => {
				if (input.value.trim() === '')
				{
					isValid = false;
					input.classList.add('error');
					const errorText = input.parentNode.querySelector('.error-text');
					if (!errorText)
					{
						const errorText = document.createElement('div');
						errorText.textContent = 'Пожалуйста, заполните это поле';
						errorText.classList.add('error-text');
						input.parentNode.insertBefore(errorText, input);
					}
					const img = input.parentNode.querySelector('.modalField__img');
					const eye = input.parentNode.querySelector('.modalField__eye');
					if (img)
					{
						img.style.top = '45%';
					}
					if (eye)
					{
						eye.style.top = '45%';
					}
				}
				else
				{
					input.classList.remove('error');
					const errorText = input.parentNode.querySelector('.error-text');
					if (errorText)
					{
						errorText.remove();
					}
					const img = input.parentNode.querySelector('.modalField__img');
					const eye = input.parentNode.querySelector('.modalField__eye');
					if (img)
					{
						img.style.top = '30%';
					}
					if (eye)
					{
						eye.style.top = '30%';
					}
				}
			});

			const radioInputs = form.querySelectorAll('input[type="radio"].validate');
			if (radioInputs.length > 0)
			{
				let isRadioSelected = false;
				radioInputs.forEach((input) => {
					if (input.checked)
					{
						isRadioSelected = true;
					}
				});

				if (!isRadioSelected)
				{
					const errorText = document.createElement('div');
					errorText.textContent = 'Пожалуйста, выберите один из вариантов';
					errorText.classList.add('error-text');
					const fieldset = radioInputs[0].closest('fieldset');
					fieldset.insertBefore(errorText, fieldset.firstChild);
					fieldset.classList.add('error');
				}
				else
				{
					const fieldset = radioInputs[0].closest('fieldset');
					const errorText = radioInputs[0].closest('fieldset').querySelector('.error-text');
					if (errorText)
					{
						fieldset.classList.remove('error');
						errorText.remove();
					}
				}
			}

			if (isValid)
			{
				form.submit();
			}
		});
	});
});