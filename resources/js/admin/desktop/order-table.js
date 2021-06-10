const headerButtons = document.querySelectorAll('.header-table');

headerButtons.forEach(headerButton =>{
    
    headerButton.addEventListener( 'click', () => {  

        let url = headerButton.dataset.action;

        let sendGetRequest = async () => {
    
            try {
                await axios.get(url).then(response => {
                    table.innerHTML = response.data.table;
                });
                
            } catch (error) {
    
            }
        };

        sendGetRequest();
        
    })
})