document.addEventListener('DOMContentLoaded', () => {
	//const swimLanes = document.querySelectorAll('.swim-lane');
	const zoneStatuses = document.querySelectorAll('.project__stage__status');

	zoneStatuses.forEach((zoneStatus) => {
		const status = zoneStatus.textContent.trim();
		const swimLane = zoneStatus.closest('.swim-lane');

		switch (status)
		{
			case 'В очереди':
				zoneStatus.style.backgroundColor = '#fff556';
				break;
			case 'Ожидает начала выполнения':
				zoneStatus.style.backgroundColor = '#FFAC1C';
				break;
			case 'Активен':
				zoneStatus.style.backgroundColor = 'rgba(72, 164, 122, 1)';
				break;
			case 'Завершен':
				zoneStatus.style.backgroundColor = 'rgba(228, 216, 216, 0.4)';
				swimLane.style.opacity = '0.5';
				break;
			case 'Независимый этап':
				zoneStatus.style.backgroundColor = 'rgba(153, 170, 255, 1)';
				break;
			default:
				zoneStatus.style.backgroundColor = '#FFF556';
		}
	});

});