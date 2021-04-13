const linkButtons = document.querySelectorAll(".link-button");
const menuButton = document.getElementById("menu-button");
const form = document.getElementById("form");
const table = document.getElementById("table");
const menu = document.getElementById("menu");
const sidebar = document.getElementById("sidebar");
import { renderForm } from "./form";
import { renderTable } from "./form";
import { renderCkeditor } from "../../ckeditor";

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
                        menu.classList.remove("active");
                        sidebar.classList.remove("active");
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
      
    } else {
        menuButton.classList.add("active");
        menu.classList.add("active");
        sidebar.classList.add("active");
    }      
})

