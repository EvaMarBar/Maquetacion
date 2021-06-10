const pannelButtons = document.querySelectorAll('.pannel-buttons');
const pannelForms = document.querySelectorAll('.pannel-form');
const menuButton = document.getElementById("icon");
const menu = document.getElementById("form-topbar-options");
const next =document.getElementById("next");

menuButton.addEventListener("click", () => {
    
    if (menuButton.classList.contains("active")){
        menuButton.classList.remove("active");
        menu.classList.remove("active");
      
    } else {
        menuButton.classList.add("active");
        menu.classList.add("active");
    }      
})


pannelButtons.forEach(pannelButton => {
    pannelButton.addEventListener('click', () => {

        pannelForms.forEach(pannelForm => {

            if(pannelButton.dataset.but==pannelForm.dataset.num){

                let activeElements = document.querySelectorAll('.active');
            
                activeElements.forEach(activeElement =>{
                    activeElement.classList.remove("active");   
                })
                
                pannelForm.classList.add("active");
                pannelButton.classList.add("active");
            }
        })
   
    })
})

// next.addEventListener('click', () => {
            
//     pannelForms.forEach(pannelForm => {
//         let activeElements = document.querySelectorAll('.active');
            
//                 activeElements.forEach(activeElement =>{
//                     activeElement.classList.remove("active");   
//                 })
                
//         pannelForm.nextElementSibling.classList.add("active");
// 
//     })
// })