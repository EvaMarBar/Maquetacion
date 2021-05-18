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
export let startOverlay = () => {
    overlay.classList.add('overlay-active');

    overlay.addEventListener("click", (e) => {
        
        let modals = document.querySelectorAll('.modal');

        modals.forEach(modal => {
            if(modal.classList.contains('modal-active')){
                modal.classList.remove('modal-active');
            }
        }); 

        overlay.classList.remove('overlay-active');

    })
}

export let stopOverlay = () => {
    overlay.classList.remove('overlay-active');
}