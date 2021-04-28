const spinner = document.getElementById('spinner');
const background = document.getElementById('spinner-background');

export let startWait = () => {
    spinner.classList.add('active');
    background.classList.add('active');
}

export let stopWait = () => {
    spinner.classList.remove('active');
    background.classList.remove('active');
}