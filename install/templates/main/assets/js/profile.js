document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('.plus-link');
    const createContent = document.querySelector('.content__profileCreate');

    button.addEventListener('click', () => {
        createContent.classList.toggle('open');
    });
});


