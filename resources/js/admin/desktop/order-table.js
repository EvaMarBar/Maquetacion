import {renderTable} from "./form";
import { renderFilterTable } from "./filterTable";
const titleButton = document.getElementById("title");
const table = document.getElementById("table");

titleButton.addEventListener("click", () => {

    let url = titleButton.dataset.url;

    let sendOrderRequest = async () => {

        try {
            await axios.get(url).then(response => {
                table.innerHTML = response.data.table;
                renderTable();
                renderFilterTable();
            });
            
        } catch (error) {
            console.error(error);
        }
    };

    sendOrderRequest();
});
