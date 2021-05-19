import {openModal, openImageModal, updateImageModal} from './modalImage';

export let renderUploadImage = () => {

    let inputElements = document.querySelectorAll(".upload-image-input");
    let uploadImages = document.querySelectorAll(".upload-image");

    inputElements.forEach(inputElement => {
    
        uploadImage(inputElement);
    });

    uploadImages.forEach(uploadImage => {

        uploadImage.addEventListener("click", (e) => {

            openImage(uploadImage);
        });
    });

    //Separa en una fución todos los eventos para poder darle los eventos a los elementos clonados sin tener que darselo a los demás porque lso demás ya tienen los eventos. Si se los dieramos tendriamos que hacer dos clicks. 
    function uploadImage(inputElement){

        let uploadElement = inputElement.closest(".upload-image-add");

        //Necesitamos el evento de click para que el input te deje coger las fotos. Cuando hacemos click en el div padre damos click al input hijo.
        uploadElement.addEventListener("click", (event) => {
           let thumbnailElement = uploadElement.querySelector(".upload-image-thumb");

            if(!thumbnailElement){
                inputElement.click();
            }else{
                openImage(uploadElement);
            };
        });
      
        //El change detecta el cambio del valor del imput (el value). Si el imput cambia y tiene archivos llamamos a la función de actualizar la imagen pasandole el padre, y el archivo. 
        inputElement.addEventListener("change", (e) => {
            if (inputElement.files.length) {
                updateThumbnail(uploadElement, inputElement.files[0], inputElement, uploadElement);
            }
        });
      
        //Evento para arrastrar, no es necesario pero mola. 
        uploadElement.addEventListener("dragover", (e) => {
            e.preventDefault();
            uploadElement.classList.add("upload-image-over");
        });
      
        ["dragleave", "dragend"].forEach((type) => {
            uploadElement.addEventListener(type, (e) => {
                uploadElement.classList.remove("upload-image-over");
            });
        });
      
        uploadElement.addEventListener("drop", (e) => {
            e.preventDefault();
        
            if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                updateThumbnail(uploadElement, e.dataTransfer.files[0]);
            }
        
            uploadElement.classList.remove("upload-image-over");
        });
    }

    //Esta función enseña la foto que hemos elegido. Si queremos meter solo imagenes habria que hacer una restricción poniendo el if image/ (esta mas abajo) al principio, para que no haga nada si no es una imagen.
    // inputElement.removeEventListener("click", uploadImage);
    // upload.removeEventListener("click", uploadImage);
    //FileReader trata el value de un file input o archivos. El string en el que se convierte el archivo podemos malipularlo dentro de js con el FiloeReader. Con la funcion onload podemos enchufar el texto (el archivo) al background de la imagen. No se le pueden dar valores desde el js a los input files (por seguridad).
    //Tenemos que generar un name para el nuevo input, si no todos los inputs tendrán el mismo name. En el html le quitamos el name. Cone l math creamos un numero al azar y creamos el name. Conent y alias seran los dataset que tendrá el div padre del input en el html.
    //Hacemos un bucle donde a todas las imagenes les damos un evento que cuando ahgas click capturamos la url (enrutador).
        function updateThumbnail(uploadElement, file) {
                
            if (file.type.startsWith("image/")) {
    
                let thumbnailElement = uploadElement.querySelector(".upload-image-thumb");
    
                if(uploadElement.classList.contains('collection')){
        
                    if(!thumbnailElement){
        
                        let cloneUploadElement = uploadElement.cloneNode(true);
                        let cloneInput = cloneUploadElement.querySelector('.upload-image-input');
        
                        uploadImage(cloneInput);
                        uploadElement.parentElement.insertBefore(cloneUploadElement,uploadElement);
                    }
                }
            
                if (uploadElement.querySelector(".upload-image-prompt")) {
                    uploadElement.querySelector(".upload-image-prompt").remove();
                }
                
                if (!thumbnailElement) {
                    thumbnailElement = document.createElement("div");
                    thumbnailElement.classList.add("upload-image-thumb");
                    uploadElement.appendChild(thumbnailElement);
                }
    
                let reader = new FileReader();
            
                reader.readAsDataURL(file);
                
                reader.onload = () => {
                    thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
                    updateImageModal(reader.result);
                    openModal();
                };
    
                uploadElement.classList.remove('upload-image-add');
                uploadElement.classList.add('upload-image');
    
                if(uploadElement.classList.contains('collection')){
    
                    let content = uploadElement.dataset.content;
                    let alias = uploadElement.dataset.alias;
                    let inputElement = uploadElement.getElementsByClassName("upload-image-input")[0];
            
                    inputElement.name = "images[" + content + "-" + Math.floor((Math.random() * 99999) + 1) + "." + alias  + "]"; 
                }
                
            } else {
                thumbnailElement.style.backgroundImage = null;
            }
        }
    
    function openImage(image){

        let url = image.dataset.url;

        if(url){

            let sendImageRequest = async () => {

                try {
                    axios.get(url).then(response => {
    
                        openImageModal(response.data);
                        
                    });
                    
                } catch (error) {
    
                }
            };
    
            sendImageRequest();

        }else{            

            openModal();
        }
    }
}
    // function seeMore () {
    //     let seeButtons = document.querySelectorAll('.see-more');

    //     seeButtons.forEach(seeButton =>{
    //         seeButton.addEventListener('click', ()=>{
    //             let imageDetails = document.getElementById('image-details');

    //             imageDetails.classList.add('active');
    //         })
    //     })
    // }
    // seeMore();

