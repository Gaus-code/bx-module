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