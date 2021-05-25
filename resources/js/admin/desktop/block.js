export let renderBlockParameters = () =>{

    let blockParameters = document.querySelectorAll('.block-parameters');

    if(blockParameters){
        let firstSlug = '';
        let value = '';

        blockParameters.forEach(blockParameter => {

            blockParameter.addEventListener('keydown', () =>{
            
                 firstSlug = blockParameter.value.match(/\{.*?\}/g);
                 value =  blockParameter.value
                


            })

            blockParameter.addEventListener('keyup', () =>{

                let slug = blockParameter.value.match(/\{.*?\}/g);
                console.log(value)
               
                if(slug === firstSlug){
                    console.log('ok')

                }else{
                   blockParameter.value = value
                }
             

            })
        })
    }
}
