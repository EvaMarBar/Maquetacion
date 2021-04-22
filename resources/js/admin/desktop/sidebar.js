const linkButtons = document.querySelectorAll(".link-button");
const menuButton = document.getElementById("menu-icon");
const form1 = document.getElementById("form-1");
const form2 = document.getElementById("form-2");
const form3 = document.getElementById("form-3");
const form = document.getElementById("form");
const table = document.getElementById("table");
const menu = document.getElementById("menu");
const sidebar = document.getElementById("sidebar");
import { renderForm } from "./form";
import { renderTable } from "./form";
import { renderCkeditor } from "../../ckeditor";
import { renderFilterTable } from "./filterTable";

linkButtons.forEach(linkButton => {
    linkButton.addEventListener('click', () =>{
        let url = linkButton.dataset.url;

            let sendMenuRequest = async () => {

                try {
                    await axios.get(url).then(response => {
                        form.innerHTML = response.data.form
                        table.innerHTML = response.data.table
                        renderForm();
                        renderTable();
                        renderCkeditor();
                        renderFilterTable();
                        menu.classList.remove("active");
                        sidebar.classList.remove("active");
                        form1.classList.remove("active");
                        form2.classList.remove("active");
                        form3.classList.remove("active");
                        window.history.pushState('','',url);
                        //Este cambia el enlace y lo recarga, el que estamos usando solo cambia el enlace.
                        //window.location = url;
                        
                        
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };

            sendMenuRequest();
        });
    });

menuButton.addEventListener("click", ()=>{

    if (menuButton.classList.contains("active")){
        menuButton.classList.remove("active");
        menu.classList.remove("active");
        sidebar.classList.remove("active");
        form1.classList.remove("active");
        form2.classList.remove("active");
        form3.classList.remove("active");
      
    } else {
        menuButton.classList.add("active");
        menu.classList.add("active");
        sidebar.classList.add("active");
        form1.classList.add("active");
        form2.classList.add("active");
        form3.classList.add("active");
    }      
})

