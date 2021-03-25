const sendButton = document.getElementById("send");


sendButton.addEventListener('click', () => {
    
    const forms = document.querySelectorAll(".admin-form");
    
        forms.forEach(form => {
            let idForm =document.getElementById(form.id);
            let data = new FormData(idForm);
            let url = form.action;

            let sendPostRequest = async () => {

                try {
                    let response = await axios.post(url, data).then(response => {
                        form.innerHTML = response.data.form;
                        console.log('2');
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };

            sendPostRequest();

            console.log('1');
        });
});