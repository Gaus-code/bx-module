const deleteTasks = document.querySelectorAll('.deleteTask');

deleteTasks.forEach((deleteTask) => {
	deleteTask.addEventListener('change', () => {
		if (deleteTask.checked)
		{
			const row = deleteTask.closest('tr');
			row.style.backgroundColor = '#e4d8d866';
			row.classList.add('deleted-task');

			// Disable input elements
			const inputElements = row.querySelectorAll('.editTaskPriority, .withoutPriority');
			inputElements.forEach((inputElement) => {
				inputElement.setAttribute('disabled', '');
			});
		}
		else
		{
			const row = deleteTask.closest('tr');
			row.style.backgroundColor = '';
			row.classList.remove('deleted-task');

			// Enable input elements
			const inputElements = row.querySelectorAll('.editTaskPriority, .withoutPriority');
			inputElements.forEach((inputElement) => {
				inputElement.removeAttribute('disabled');
			});
		}
	});
});