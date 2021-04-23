import { renderCkeditor } from "../../ckeditor";
import {swipeRevealItem} from './tableSwipe';
import { showForm } from './bottombarMenu';
import {scrollWindowElement} from './verticalScroll';


const table = document.getElementById("table");
const form = document.getElementById("form");



export let renderForm = () => {

    let forms = document.querySelectorAll(".admin-form");
    let sendButton = document.getElementById("send");

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
    
                try {
                    await axios.post(url, data).then(response => {
                        form.id.value = response.data.id;
                        table.innerHTML = response.data.table;
                        renderTable();  
                        renderCkeditor();
                        paginatorElement();
                });
                    
                } catch (error) {
                    console.error(error);
                }
            };
    
            sendPostRequest();
        });
    });
};


export let renderTable = () => {

    let editButtons = document.querySelectorAll(".edit-button");
    let deleteButtons = document.querySelectorAll(".delete-button");
    
    editButtons.forEach(editButton => {

        editButton.addEventListener("click", () => {

            let url = editButton.dataset.url;

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
    let paginationButtons = document.querySelectorAll('.table-pagination-button');

    paginationButtons.forEach(paginationButton => {

    paginationButton.addEventListener("click", () => {


        let sendPaginationRequest = async () => {

            try {
                console.log(url)
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


