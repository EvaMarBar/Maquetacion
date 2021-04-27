let messages = document.querySelectorAll('.message');
let closeButtons = document.querySelectorAll('.message-close');

export let showMessages = (state, messageText) =>{

    messages.forEach(message =>{
        
        if (message.classList.contains(state)){
            
            let messageShowed = document.getElementById('message-'+ state);
            messageShowed.innerHTML = messageText;

            messageShowed.classList.add('active');
            window.setTimeout( ()=>{messageShowed.classList.remove('active')}, 5000);

        }
    })
}

closeButtons.forEach(closeButton =>{
    closeButton.addEventListener('click', ()=>{
        let messageShowed = document.getElementById('active');
        messageShowed.classList.remove('active');

    })
})
