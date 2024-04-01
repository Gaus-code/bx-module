
// const taskList = document.getElementById('taskList');
// const projectList = document.getElementById('projectList');

const toggleBtns = {
    task: {
        btn: document.getElementById('taskToogle'),
        list: document.getElementById('taskList')
    },
    project: {
        btn: document.getElementById('projectToogle'),
        list: document.getElementById('projectList')
    }
};
  
for (const type in toggleBtns) {
    toggleBtns[type].btn.addEventListener('click', () => {
        toggleBtns[type].list.classList.toggle('open');
    });
}

taskList.style.maxHeight = '100px';
taskList.style.overflowY = 'scroll';
projectList.style.maxHeight = '100px';
projectList.style.overflowY = 'scroll';

const setScrollbarStyles = (list) => {
  list.style.scrollbarWidth = 'thin';
  list.style.scrollbarColor = '#ccc transparent';
  list.style.msOverflowStyle = '-ms-autohiding-scrollbar';
};

setScrollbarStyles(taskList);
setScrollbarStyles(projectList);

const updateScrollbarThumb = (list) => {
  const scrollPercent = (list.scrollTop / (list.scrollHeight - list.offsetHeight)) * 100;
  list.querySelector('.scrollbar-thumb').style.width = `${scrollPercent}%`;
};

taskList.addEventListener('scroll', () => {
  updateScrollbarThumb(taskList);
});

projectList.addEventListener('scroll', () => {
  updateScrollbarThumb(projectList);
});

