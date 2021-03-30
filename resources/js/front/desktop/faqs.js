const moreButtons = document.querySelectorAll(".button");
const show = document.querySelectorAll(".description");

moreButtons.forEach(moreButton =>{

    moreButton.addEventListener("click", () => {
        
        if (moreButton.classList.contains("active")){
            moreButton.classList.remove("active");
            moreButton.parentElement.nextElementSibling.classList.remove("active");
        } else {
            moreButton.classList.add("active");
            moreButton.parentElement.nextElementSibling.classList.add("active");
        }      
    })
})