document.addEventListener('DOMContentLoaded', () => {
    const button = document.querySelector('#quickCreate');
    const createContent = document.querySelector('.content__profileCreate');

    button.addEventListener('click', () => {
        createContent.classList.toggle('open');
    });
});


