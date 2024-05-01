document.addEventListener('DOMContentLoaded', () => {
	const swimLanes = document.querySelectorAll('.swim-lane');
	const zoneStatuses = document.querySelectorAll('.zoneStatus');

	zoneStatuses.forEach((zoneStatus) => {
		const status = zoneStatus.textContent.trim();
		const swimLane = zoneStatus.closest('.swim-lane');

		switch (status)
		{
			case 'В очереди':
				swimLane.style.backgroundColor = 'inherit';
				break;
			case 'Ожидает начала выполнения':
				swimLane.style.backgroundColor = '#E3963E';
				break;
			case 'Активен':
				swimLane.style.backgroundColor = 'rgba(72, 164, 122, 1)';
				break;
			case 'Завершен':
				swimLane.style.backgroundColor = 'rgba(228, 216, 216, 0.4)';
				swimLane.style.opacity = '0.5';
				break;
			case 'Независимый':
				swimLane.style.backgroundColor = 'rgba(228, 216, 216, 0.5)';
				break;
			default:
				swimLane.style.backgroundColor = 'inherit';
		}
	});

});