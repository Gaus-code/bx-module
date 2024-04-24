const banBtn = document.querySelector('.banBtn');
const banForm = document.querySelector('.banForm');
const closeFormBtn = document.querySelector('#closeFormBtn');


// Add a click event listener to the button
banBtn.addEventListener('click', () => {
	// Show the form and hide the button with a fade-in/fade-out effect
	banForm.style.transition = 'opacity 0.3s ease-in-out';
	banForm.style.opacity = '1';
	banBtn.style.opacity = '0';
	banBtn.style.transition = 'opacity 0.3s ease-in-out';
	banForm.style.display = 'block';
});

// Add a click event listener to the close form button
closeFormBtn.addEventListener('click', () => {
	// Hide the form and show the button with a fade-in/fade-out effect
	banForm.style.transition = 'opacity 0.3s ease-in-out';
	banForm.style.opacity = '0';
	banBtn.style.opacity = '1';
	banBtn.style.transition = 'opacity 0.3s ease-in-out';
	banForm.style.display = 'none';
});