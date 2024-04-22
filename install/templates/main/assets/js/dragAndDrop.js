const draggables = document.querySelectorAll('.task');
const droppables = document.querySelectorAll('.swim-lane');

draggables.forEach((task) => {
	task.addEventListener('dragstart', () => {
		task.classList.add('is-dragging');
	});
	task.addEventListener('dragend', () => {
		task.classList.remove('is-dragging');
	});
});

droppables.forEach((zone) => {
	zone.addEventListener('dragover', (e) => {
		e.preventDefault();

		const bottomTask = insertAboveTask(zone, e.clientY);
		const currentTask = document.querySelector('.is-dragging');

		if (!bottomTask)
		{
			zone.appendChild(currentTask);
			//currentTask.querySelector('input[name="zoneId"]').value = zone.dataset.zoneId;
			const taskIndex = currentTask.querySelector('input[name^="tasks"]').name.match(/\[(\d+)\]/)[1];
			currentTask.querySelector(`input[name="tasks[${taskIndex}][zoneId]"]`).value = zone.dataset.zoneId;
		}
		else
		{
			zone.insertBefore(currentTask, bottomTask);
			//currentTask.querySelector('input[name="zoneId"]').value = zone.dataset.zoneId;
			const taskIndex = currentTask.querySelector('input[name^="tasks"]').name.match(/\[(\d+)\]/)[1];
			currentTask.querySelector(`input[name="tasks[${taskIndex}][zoneId]"]`).value = zone.dataset.zoneId;
		}
	});
});

const insertAboveTask = (zone, mouseY) => {
	const els = zone.querySelectorAll('.task:not(.is-dragging)');
	let closestTask = null;
	let closestOffset = Number.NEGATIVE_INFINITY;

	els.forEach((task) => {
		const { top } = task.getBoundingClientRect();
		const offset = mouseY - top;

		if (offset < 0 && offset > closestOffset)
		{
			closestOffset = offset;
			closestTask = task;
		}
	});

	return closestTask;
};

// const dragForm = document.getElementById('todo-form');
// const dragInput = document.getElementById('todo-input');
// const dragLane = document.querySelector('.lanes');
//
// dragForm.addEventListener('submit', (e) => {
// 	e.preventDefault();
//
// 	const inputValue = dragInput.value;
//
// 	if (!inputValue)
// 	{
// 		return;
// 	}
//
// 	const newZone = document.createElement('div');
// 	newZone.className = 'swim-lane';
//
// 	const newHeading = document.createElement('h3');
// 	newHeading.className = 'heading';
// 	newHeading.textContent = inputValue;
//
// 	newZone.appendChild(newHeading);
//
// 	dragLane.appendChild(newZone);
// 	dragInput.value = '';
// });