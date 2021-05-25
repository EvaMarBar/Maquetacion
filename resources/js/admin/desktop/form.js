const table = document.getElementById("table");
const form = document.getElementById("form");
import { renderCkeditor } from "../../ckeditor";
import {renderFilterTable} from "./filterTable";
import { showMessage } from "./messages";
import { startWait } from "./spinner";
import {stopWait} from "./spinner";
import { renderLocaleTabs } from "./localeTabs";
import { renderTabs } from "./tabs";
import { renderUploadImage } from "./upload";
import { renderLocaleTags } from "./localeTags";
import { renderBlockParameters } from "./block";

export let renderForm = () => {

    let forms = document.querySelectorAll(".admin-form");
    let sendButton = document.getElementById("send");
    let createButton = document.getElementById("button-create");
    let onOffSwitch = document.getElementById('switch');

    if(sendButton){
        sendButton.addEventListener("click", (event) => {
    
            event.preventDefault();
            
            forms.forEach(form => { 
            
                let data = new FormData(form);
    
                if (data.get('visible') == null) {
                    data.set('visible',0);
                }
    
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
    
                            if(response.data.id){
                                form.id.value = response.data.id;
                            }
                            
                            table.innerHTML = response.data.table;
    
                            stopWait();
                            showMessage('success', response.data.message);
                            renderTable();
                            renderLocaleTags();
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
                    }
                };
        
                sendPostRequest();
            });
        });
    }
  
   
    if(createButton){

        createButton.addEventListener("click", () =>{
            let url= createButton.dataset.url;


            let sendCreateRequest = async () => {

                try {
                    await axios.get(url).then(response => {
                        form.innerHTML = response.data.form;
                        renderForm();
                       
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };

            sendCreateRequest();
        });
        renderUploadImage();
    }

    renderCkeditor();
    renderFilterTable();
    renderLocaleTabs();
    renderTabs();
    renderBlockParameters();
    
}


export let renderTable = () => {

    let editButtons = document.querySelectorAll(".edit-button");
    let deleteButtons = document.querySelectorAll(".delete-button");
    let paginationButtons = document.querySelectorAll('.table-pagination-button');
    editButtons.forEach(editButton => {

        editButton.addEventListener("click", () => {

            let url = editButton.dataset.url;

            let sendEditRequest = async () => {

                try {
                    await axios.get(url).then(response => {
                        form.innerHTML = response.data.form;
                        renderForm();
                        renderCkeditor();
                        renderFilterTable();
                        renderLocaleTabs();
                        renderTabs();
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };

            sendEditRequest();
        });
    });

    if(deleteButtons != null){

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
                
                    }
                };

                sendDeleteRequest();
            });
        });
    }

    paginationButtons.forEach(paginationButton => {

        paginationButton.addEventListener("click", () => {

            let url = paginationButton.dataset.page;

            let sendPaginationRequest = async () => {

                try {
                    await axios.get(url).then(response => {
                        table.innerHTML = response.data.table;
                        renderTable();
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };

            sendPaginationRequest();
            
        });
    });

    renderFilterTable();
    renderLocaleTabs();
    renderTabs();
    renderLocaleTags();
};

renderForm();
renderTable();

