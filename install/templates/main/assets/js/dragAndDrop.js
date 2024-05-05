document.addEventListener('DOMContentLoaded', () => {
	const draggables = document.querySelectorAll('.task');
	const droppables = document.querySelectorAll('.swim-lane');

	draggables.forEach((task) => {
		task.addEventListener('dragstart', (e) => {
			const swimLane = task.closest('.swim-lane');
			const zoneStatus = swimLane.querySelector('.project__stage__status').textContent.trim();

			if (zoneStatus === 'Активен' || zoneStatus === 'Завершен')
			{
				task.style.cursor = 'not-allowed';
				e.preventDefault();
				return;
			}
			else
			{
				task.style.cursor = 'grab';
			}

			task.classList.add('is-dragging');
		});
		task.addEventListener('dragend', () => {
			task.classList.remove('is-dragging');
		});
	});

	droppables.forEach((zone) => {
		zone.addEventListener('dragover', (e) => {
			e.preventDefault();

			const zoneStatus = zone.querySelector('.project__stage__status').textContent.trim();
			if (zoneStatus === 'Активен' || zoneStatus === 'Завершен')
			{
				return;
			}

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
			const {top} = task.getBoundingClientRect();
			const offset = mouseY - top;

			if (offset < 0 && offset > closestOffset)
			{
				closestOffset = offset;
				closestTask = task;
			}
		});

		return closestTask;
	};

	//delete task from project
	const projectTaskDeletes = document.querySelectorAll('.projectTaskDelete');

	projectTaskDeletes.forEach(projectTaskDelete => {
		projectTaskDelete.addEventListener('click', () => {
			projectTaskDelete.classList.toggle('checked');
			projectTaskDelete.closest('.task').classList.toggle('checked');
			const taskSelect = projectTaskDelete.closest('.task').querySelector('select');
			taskSelect.disabled = projectTaskDelete.checked;
		});
	});
});