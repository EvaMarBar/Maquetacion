export let renderLocaleTabs = () => {

    let localeTabsItems = document.querySelectorAll(".locale-tab-item");
    let localeTabPanels = document.querySelectorAll(".locale-tab-panel");

    localeTabsItems.forEach(localeTabItem => { 
        localeTabItem.addEventListener("click", () => {
    
            let activeElements = document.querySelectorAll(".locale-tab-active");
            let activeTab = localeTabItem.dataset.tab;

            activeElements.forEach(activeElement => {

                if(activeElement.dataset.tab == activeTab){
                    activeElement.classList.remove("locale-tab-active");
                    console.log(activeElement.className)
                }
            });
            
            localeTabItem.classList.add("locale-tab-active");
            console.log(localeTabItem.className)
    
            localeTabPanels.forEach(localeTabPanel => {
    
                if(localeTabPanel.dataset.tab == activeTab){
                    if(localeTabPanel.dataset.localetab == localeTabItem.dataset.localetab){
                        localeTabPanel.classList.add("locale-tab-active"); 
                        console.log(localeTabPanel.className)
                    }
                }                
            });
        });
    });
}
renderLocaleTabs();