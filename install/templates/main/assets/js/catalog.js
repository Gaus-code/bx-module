const resetFiltersButton = document.getElementById('resetFilters');
const filterCheckboxes = document.querySelectorAll('.filter__checkbox');

resetFiltersButton.addEventListener('click', () => {
	filterCheckboxes.forEach(checkbox => {
		checkbox.checked = false;
	});
});