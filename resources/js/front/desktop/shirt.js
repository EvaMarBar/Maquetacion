let shirtColours = document.querySelectorAll('.shirt-colour');
let shirtSizes = document.querySelectorAll('.shirt-size');
let cart = document.getElementById('cart');
let cartAdded = document.getElementById('cart-added');
let wishList = document.getElementById('wish-list');



shirtColours.forEach(shirtColour =>{
    shirtColour.addEventListener('click', ()=>{

        let activeColours = document.querySelectorAll('.colour-active');
        activeColours.forEach(activeColour =>{
            activeColour.classList.remove('colour-active')
        });
        shirtColour.classList.add('colour-active');

    })
});

shirtSizes.forEach(shirtSize =>{
    shirtSize.addEventListener('click', ()=>{
        let activeSizes = document.querySelectorAll('.size-active');
        activeSizes.forEach(activeSize =>{
            activeSize.classList.remove('size-active')
            console.log(activeSizes)
        });
        shirtSize.classList.add('size-active');
        console.log('click')
        console.log(shirtSize.className)
    })
})

cart.addEventListener('click', () =>{
    cartAdded.classList.add('active');
    cart.classList.remove('active')
})

cartAdded.addEventListener('click', () =>{
    cart.classList.add('active');
    cartAdded.classList.remove('active')
})

wishList.addEventListener('click', () =>{
    wishList.classList.toggle('active');

})
