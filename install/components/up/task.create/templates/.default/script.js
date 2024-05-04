document.addEventListener('DOMContentLoaded', () => {

	const inputs = document.querySelectorAll('input[name="title"], textarea[name="description"], input[name="maxPrice"], input[name="deadline"], input[name="tagsString"]');

	function saveToLocalStorage() {
		inputs.forEach(input => {
			const name = input.name;
			const value = input.value;
			localStorage.setItem(name, value);
		});
	}

	function loadFromLocalStorage() {
		inputs.forEach(input => {
			const name = input.name;
			const value = localStorage.getItem(name);
			if (value)
			{
				input.value = value;
			}
		});
	}

	inputs.forEach(input => {
		input.addEventListener('input', saveToLocalStorage);
	});

	loadFromLocalStorage();
});

document.addEventListener('DOMContentLoaded', () => {
	const title = BX('createTitle')
	const button = BX('gptBtn')
	const description = BX('taskDescription')
	const sessid = BX('sessid')
	const taskTagsInput = BX('taskTags')
	const gptError = BX('gptError')

	BX.bind(button, 'click', () => {
		const loader = document.getElementById('loader');
		loader.style.display = 'flex';
		BX.ajax({
			url: '/task/gpt-tags/',
			data: {
				sessid: sessid.value,
				title: title.value,
				description: description.value,
			},
			method: 'POST',
			dataType: 'json',
			timeout: 10,
			onsuccess: function( data ) {
				if (data.status === 'success')
				{
					let tags = data.data;
					tags = (tags === '[]' || tags === '') ? [] : JSON.parse(tags);

					if (tags.length > 0)
					{
						const tagStrings = tags.map(tag => `#${tag}`);
						taskTagsInput.value = tagStrings.join(' ');
						taskTagsInput.classList.remove('gptGenerateError');
						taskTagsInput.classList.add('gptGenerate');
					}
					else
					{
						const message = 'Просим прощения, чат gpt решил прилечь ненадолго, скоро он снова вернется к вам';
						taskTagsInput.classList.add('gptGenerateError');
						taskTagsInput.classList.remove('gptGenerate');
						gptError.textContent = message;
					}
				}
				loader.style.display = 'none';
			},
			onfailure: e => {
				console.error( e )
				loader.style.display = 'none';
			}
		})
	})
});