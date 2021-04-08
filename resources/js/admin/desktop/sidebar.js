const menuButtons = document.querySelectorAll(".menu-button");
const form = document.getElementById("form");
const table = document.getElementById("table");
import { renderForm } from "./form";
import { renderTable } from "./form";
import { renderCkeditor } from "../../ckeditor";

menuButtons.forEach(menuButton => {
    menuButton.addEventListener('click', () =>{
        let url = menuButton.dataset.url;

            let sendMenuRequest = async () => {

                try {
                    await axios.get(url).then(response => {
                        form.innerHTML = response.data.form
                        table.innerHTML = response.data.table
                        renderForm();
                        renderTable();
                        renderCkeditor();
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };

            sendMenuRequest();
        });
    });