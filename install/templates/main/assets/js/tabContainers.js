document.addEventListener('DOMContentLoaded', () => {
	const reviewsBtns = document.querySelectorAll('li[id$="-btn"]');
	const reviewsContainers = document.querySelectorAll('.tab__container');

	reviewsBtns.forEach(btn => {
		btn.addEventListener('click', () => {
			reviewsBtns.forEach(b => b.classList.remove('active-tag-item'));
			btn.classList.add('active-tag-item');

			reviewsContainers.forEach(c => c.style.display = 'none');

			const containerId = btn.id.replace('-btn', '') + '-reviews';
			document.getElementById(containerId).style.display = 'block';

			localStorage.setItem('activeTab', btn.id);
		});
	});

	const activeTabId = localStorage.getItem('activeTab');

	if (activeTabId)
	{
		const activeTab = document.getElementById(activeTabId);
		if (activeTab)
		{
			activeTab.classList.add('active-tag-item');

			const containerId = activeTabId.replace('-btn', '') + '-reviews';
			document.getElementById(containerId).style.display = 'block';

			reviewsBtns.forEach(b => {
				if (b.id !== activeTabId)
				{
					b.classList.remove('active-tag-item');
				}
			});

			reviewsContainers.forEach(c => {
				if (c.id !== containerId)
				{
					c.style.display = 'none';
				}
			});
		}
	}

	const logOutLink = document.querySelector('.profile__logOut');

	logOutLink.addEventListener('click', () => {
		localStorage.clear();
	});
});
