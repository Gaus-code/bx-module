const activeResponses = document.getElementById('responsesLink');
const activeNotification = document.getElementById('notificationLink');
const activeProjects = document.getElementById('projectToogle');
const activeTasks = document.getElementById('taskToogle');
const activeUser = document.getElementById('userLink');
const activeComments = document.getElementById('commentLink');

let asideUrl = window.location.pathname;
function extractPathFromUrl(path, element) {
	const pathRegex = new RegExp(`\/profile\/\\d+\/${path}\/?`);
	const match = pathRegex.exec(asideUrl);

	if (match)
	{
		element.classList.add('active-profile-btn');
		return match[0];
	}
	else
	{
		return null;
	}
}

const paths = ['responses', 'notifications', 'projects', 'tasks', 'edit', 'comments'];

const userPathRegex = /\/profile\/\d+\/$/;
const userPathMatch = userPathRegex.exec(url);

if (userPathMatch)
{
	extractPathFromUrl('', activeUser);
}
else
{
	paths.forEach((path) => {
		let element = null;

		switch (path)
		{
			case 'responses':
				element = activeResponses;
				break;
			case 'notifications':
				element = activeNotification;
				break;
			case 'projects':
				element = activeProjects;
				break;
			case 'tasks':
				element = activeTasks;
				break;
			case 'edit':
				element = activeUser;
				break;
			case 'comments':
				element = activeComments;
				break;
		}

		if (element)
		{
			extractPathFromUrl(path, element);
		}
	});
}

const logOutButton = document.querySelector('.profile__logOut');

logOutButton.addEventListener('click', () => {
	localStorage.clear();
});