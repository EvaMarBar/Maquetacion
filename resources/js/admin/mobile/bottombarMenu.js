import {showFilterTable, hideFilterTable} from './filterTable';
import {renderTable} from './form';

const bottombarItems = document.querySelectorAll('.bottombar-item');
const table = document.getElementById("table");
const form = document.getElementById("form");

bottombarItems.forEach( bottombarItem => {

    bottombarItem.addEventListener("click", () => {

        let activeElements = document.querySelectorAll(".bottombar-active");

        activeElements.forEach(activeElement => {
            activeElement.classList.remove("bottombar-active");
        });
                
        bottombarItem.classList.add('bottombar-active');

        if(bottombarItem.dataset.option == 'form'){
            showForm();
        }

        if(bottombarItem.dataset.option == 'table'){
            showTable(bottombarItem.dataset.url);
        }
    });
});

export let showForm = () => {
    form.classList.add('active');
    table.classList.remove('active');
    hideFilterTable();
};

export let showTable = (url) => {

    let sendShowRequest = async () => {

        try {
            await axios.get(url).then(response => {
                table.innerHTML = response.data.table;
                renderTable();
            });
            
        } catch (error) {
            console.error(error);
        }
    };

    sendShowRequest();

    table.classList.add('active');
    form.classList.remove('active');
    showFilterTable();
};
