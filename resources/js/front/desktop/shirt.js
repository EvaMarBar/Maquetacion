let shirtColours = document.querySelectorAll('.shirt-colour');
let shirtSizes = document.querySelectorAll('.shirt-size');
let cart = document.getElementById('cart');
let cartAdded = document.getElementById('cart-added');
let wishList = document.getElementById('wish-list');
let linkButtons = document.querySelectorAll('.shirt-link');
let nextPhotoButtons = document.querySelectorAll('.next-photo');


export let renderColours = () =>{
    if(shirtColours){
        shirtColours.forEach(shirtColour =>{
            shirtColour.addEventListener('click', ()=>{
        
                let activeColours = document.querySelectorAll('.colour-active');
                activeColours.forEach(activeColour =>{
                    activeColour.classList.remove('colour-active')
                });
                shirtColour.classList.add('colour-active');
        
            })
        });
    }
}
renderColours();

export let renderSizes = () =>{
    if(shirtSizes){
        shirtSizes.forEach(shirtSize =>{
            shirtSize.addEventListener('click', ()=>{
                let activeSizes = document.querySelectorAll('.size-active');
                activeSizes.forEach(activeSize =>{
                    activeSize.classList.remove('size-active')
                });
                shirtSize.classList.add('size-active');
            
            })
        })
    }
}
renderSizes();

export let renderCart = () =>{
    if(cart){
        cart.addEventListener('click', () =>{
            cartAdded.classList.add('active');
            cart.classList.remove('active')
        })
        
        cartAdded.addEventListener('click', () =>{
            cart.classList.add('active');
            cartAdded.classList.remove('active')
        })
        
    }
}
renderCart();

export let renderWishList = () =>{
    if(wishList){
        wishList.addEventListener('click', () =>{
            wishList.classList.toggle('active');
        }) 
    }
}
renderWishList();

export let renderLinkButtons = () =>{

    if(linkButtons){

        linkButtons.forEach(linkButton =>{
            linkButton.addEventListener('click', () => {
    
            let url = linkButton.dataset.url;
            let content =  document.getElementById('content');

            let sendProductRequest = async () => {
    
                try {
                        axios.get(url).then(response => {
                        content.innerHTML = response.data.product
                        window.history.pushState('','',url);
                        renderColours();
                    
                    });
                    
                } catch (error) {
                    console.error(error);
                }
            };
            renderColours();
            sendProductRequest();
            })
        })
    
    }
}
renderLinkButtons();

export let renderNextPhoto = () =>{
    if (nextPhotoButtons){

        let second = 

        nextPhotoButtons.forEach(nextPhoto =>{
            nextPhoto.addEventListener('click', () =>{
            
                if(second){
                    nextPhoto.style.transform = "translateX(0px)"
                    second = false
                
                }else{
                    nextPhoto.style.transform = "translateX(-250px)"
                    second = true    
                
                }
            })
        })
        renderLinkButtons();
    }
}
renderNextPhoto();