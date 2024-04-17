const activeCatalog = document.getElementById('catalogLink');
const activeMain = document.getElementById('mainLink');

let url = window.location.pathname;
function getUrlPathBeforeQuery(url)
{
	return url.split('?')[0];
}

function activateElement(path, element)
{
	if (path === getUrlPathBeforeQuery(window.location.pathname))
	{
		element.classList.add('active-link');
	}
}

activateElement('/catalog/', activeCatalog);
activateElement('/', activeMain);
