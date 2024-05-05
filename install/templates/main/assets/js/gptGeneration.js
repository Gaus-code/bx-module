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
					tags = (tags === '[]' || tags === '' || tags === null) ? [] : JSON.parse(tags);

					if (tags.length > 0)
					{
						const tagStrings = tags.map(tag => `#${tag}`);
						taskTagsInput.value = tagStrings.join(' ');
						taskTagsInput.classList.remove('gptGenerateError');
						taskTagsInput.classList.add('gptGenerate');
						gptError.style.display = "none";
					}
					else
					{
						const message = 'Чат gpt не смог ничего придумать. Попробуйте изменить описание';
						taskTagsInput.classList.add('gptGenerateError');
						taskTagsInput.classList.remove('gptGenerate');
						gptError.textContent = message;
					}
				}
				loader.style.display = 'none';
			},
			onfailure: e => {
				console.log(data);
				console.error( e )
				loader.style.display = 'none';
			}
		})
	})
});