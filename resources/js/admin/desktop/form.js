const axios = require('axios');
const forms = document.querySelectorAll(".admin-form");
const sendButton = document.getElementById("send");
const table = document.getElementById("table");
const editButtons = document.querySelectorAll(".edit-button");
const deleteButtons  = document.querySelectorAll(".delete-button");
const formContainer = document.getElementById("form");

sendButton.addEventListener("click", () => {
    
    forms.forEach(form => { 
        
        let data = new FormData(form);
        let url = form.action;

        let sendPostRequest = async () => {

            try {
                await axios.post(url, data).then(response => {
                    //console.log(response.data.table)
                    form.id.value = response.data.id;
                    table.innerHTML = response.data.table;
                });
                 
            } catch (error) {
                console.error(error);
            }
        };

        sendPostRequest();
    });
});

editButtons.forEach(editButton => {

    editButton.addEventListener('click', () =>{

        let url = editButton.dataset.url;

        let sendGetRequest = async () => {

            try {
                console.log(url);
                await axios.get(url).then(response => {
                    formContainer.innerHTML = response.data.form;
                });
                 
            }catch (error) {
                console.error(error);
            }
        };

        sendGetRequest();
    })
});

deleteButtons.forEach(deleteButton =>{

    deleteButton.addEventListener("click", ()=>{

        let url = deleteButton.dataset.url;

        let sendDeleteRequest = async () => {

            try {
                await axios.delete(url).then(response => {
                    console.log(response.data.table)
                    table.innerHTML = response.data.table;
                });
                 
            }catch (error) {
                console.error(error);
            }
        };

        sendDeleteRequest();
    })
});