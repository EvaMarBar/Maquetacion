const moreButtons = document.querySelectorAll(".button");

moreButtons.forEach(moreButton =>{

    moreButton.addEventListener("click", () => {
        
        if (moreButton.classList.contains("active")){
            moreButton.classList.remove("active");
            moreButton.parentElement.nextElementSibling.classList.remove("active");

        } else {
            let activeElements = document.querySelectorAll('.active');
            
            activeElements.forEach(activeElement =>{
                activeElement.classList.remove("active");  
            })
            
            moreButton.classList.add("active");
            moreButton.parentElement.nextElementSibling.classList.add("active");
        }      
    })
})