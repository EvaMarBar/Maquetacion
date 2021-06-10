import { renderCkeditor } from "../../ckeditor";
import { showForm } from './bottombarMenu';
import {scrollWindowElement} from './verticalScroll';
import { showMessage } from "./messages";
import { startWait } from "./spinner";
import {stopWait} from "./spinner";


const table = document.getElementById("table");
const form = document.getElementById("form");



export let renderForm = () => {

    let forms = document.querySelectorAll(".admin-form");
    let sendButton = document.getElementById("send");
    let createButton = document.getElementById("button-create");
    let onOffSwitch = document.getElementById("switch")

    sendButton.addEventListener("click", (event) => {
    
        event.preventDefault();
        
        forms.forEach(form => { 
        
            let data = new FormData(form);

            if( ckeditors != 'null'){

                Object.entries(ckeditors).forEach(([key, value]) => {
                    data.append(key, value.getData());
                });
              
            }

            let url = form.action;

            let sendPostRequest = async () => {
    
                startWait();
                try {
                    await axios.post(url, data).then(response => {

                        form.id.value = response.data.id;
                        table.innerHTML = response.data.table;

                        stopWait();
                        showMessage('success', response.data.message);
                        renderTable();
                    });
                    
                } catch (error) {

                    stopWait();

                    if(error.response.status == '422'){

                        let errors = error.response.data.errors;      
                        let errorMessage = '';

                        Object.keys(errors).forEach(function(key) {
                            errorMessage += '<li>' + errors[key] + '</li>';
                        })
        
                        showMessage('error', errorMessage);
                    }
                };
                
            };

        sendPostRequest();
        });
    });

    onOffSwitch.addEventListener("click", () => {

        if(onOffSwitch.value == "true"){
            onOffSwitch.value = "false";
        }else{
            onOffSwitch.value = "true";
        }
    });

    createButton.addEventListener("click", () =>{
        let url= createButton.dataset.url;


        let sendCreateRequest = async () => {

            try {
                await axios.get(url).then(response => {
                    form.innerHTML = response.data.form;
                    renderForm();
                    renderCkeditor();
                    renderFilterTable();
                });
                
            } catch (error) {
                console.error(error);
            }
        };

        sendCreateRequest();
    });
}



export let renderTable = () => {

    let editButtons = document.querySelectorAll(".edit-button");
    let deleteButtons = document.querySelectorAll(".delete-button");
    
    editButtons.forEach(editButton => {

        editButton.addEventListener("click", () => {

            let url = editButton.dataset.url;

            if(onOffSwitch.value == "true"){
                onOffSwitch.value = "false";
            }else{
                onOffSwitch.value = "true";
            }
            

            let sendEditRequest = async () => {


                try {
                    await axios.get(url).then(response => {
                        form.innerHTML = response.data.form;
                        renderForm();
                        renderCkeditor();
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };

            sendEditRequest();
        });
    });

    deleteButtons.forEach(deleteButton => {

        deleteButton.addEventListener("click", () => {

            let url = deleteButton.dataset.url;

            let sendDeleteRequest = async () => {

                try {
                    await axios.delete(url).then(response => {
                        table.innerHTML = response.data.table;
                        renderTable();
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };

            sendDeleteRequest();
        });

})
    new scrollWindowElement(table);
}; 

export   let paginatorElement = (url) =>{

        let sendPaginationRequest = async () => {

            try {
                let currentPage = document.getElementById('table-container').dataset.current
                let nextPage = ++currentPage
                let newUrl = url.replace(/[0-9]/g, nextPage);

                await axios.get(newUrl).then(response => {
                    table.insertAdjacentHTML("beforeend", response.data.table);
                    document.querySelector('.table-container').dataset.current=url;
                    
                    currentPage = nextPage.toString()
                
                    renderTable();
                });
                
            } catch (error) {
                console.error(error);
            }
        };

        sendPaginationRequest();
}

export let editElement = (url) => {
    

    let sendEditRequest = async () => {

        try {
            await axios.get(url).then(response => {
                form.innerHTML = response.data.form;
                showForm();
                renderForm();
                paginatorElement();
            });
            
        } catch (error) {
            console.error(error);
        }
    };

    sendEditRequest();
}

export let deletePopUp = (url) =>{
    let popUp = document.getElementById('pop-up');
    let confirmDelete = document.getElementById('confirm-delete');

    popUp.classList.add('active');
    confirmDelete.dataset.url = url;
}

export let deleteConfirmation = () =>{
    let popUp = document.getElementById('pop-up');
    let confirmDelete = document.getElementById('confirm-delete');
    let cancelDelete = document.getElementById('cancel-delete');
    let swipeRevealItemElements = document.querySelectorAll('.swipe-element');


    cancelDelete.addEventListener("click",() =>{
        popUp.classList.remove('active');
        renderTable();
        // swipeRevealItemElements.forEach(swipeRevealItemElement =>{
        //     transformStyle = 'translateX('+0+'px)';
        // })
    
        
    });
    
    confirmDelete.addEventListener("click", () =>{
        let url = confirmDelete.dataset.url;
        
            let sendDeleteRequest = async () => {
    
                try {
                    await axios.delete(url).then(response => {
                        table.innerHTML = response.data.table;
                        popUp.classList.remove('active');
                        renderTable();
                        paginatorElement();
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };
    
            sendDeleteRequest();
        });
}
deleteConfirmation();

renderForm();
renderTable();


