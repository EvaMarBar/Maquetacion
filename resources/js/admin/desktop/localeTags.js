import {renderTable} from './form';
import {showMessage} from './messages';

export let renderLocaleTags = () => {

    let table = document.getElementById("table");
    let importTags = document.getElementById('import-tags');

    if(importTags){
        
        importTags.addEventListener("click", (evt) => {
            evt.preventDefault
    
            let url = importTags.dataset.url;
        
            let sendEditRequest = async () => {
    
                try {
                    await axios.get(url).then(response => {
                        table.innerHTML = response.data.table;
                        renderTable();
                        showMessage('success', response.data.message);
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };
    
            sendEditRequest();
        });
    }

}
renderLocaleTags();