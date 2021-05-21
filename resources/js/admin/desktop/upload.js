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
}

function uploadImage(inputElement){

    let uploadElement = inputElement.parentElement;

    uploadElement.addEventListener("click", (e) => {
        
        let thumbnailElement = uploadElement.querySelector(".upload-image-thumb");

        if(!thumbnailElement){
            inputElement.click();
        }else{
            openImage(uploadElement);
        };
    });
  
    inputElement.addEventListener("change", (e) => {
        if (inputElement.files.length) {
            updateThumbnail(uploadElement, inputElement.files[0]);
        }
    });
  
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
            uploadElement.querySelector(".upload-image-prompt").classList.add('hidden');
        }
        
        if (!thumbnailElement) {
            thumbnailElement = document.createElement("div");
            thumbnailElement.classList.add("upload-image-thumb");
            uploadElement.appendChild(thumbnailElement);
        }

        let reader = new FileReader();

        reader.readAsDataURL(file);
        
        reader.onload = () => {

            let temporalId = Math.floor((Math.random() * 99999) + 1);
            let content = uploadElement.dataset.content;
            let language = uploadElement.dataset.language;

            let inputElement = uploadElement.getElementsByClassName("upload-image-input")[0];

            thumbnailElement.style.backgroundImage = `url('${reader.result}')`;
            uploadElement.dataset.temporalId = temporalId;
            uploadElement.dataset.image = reader.result;
            inputElement.name = "images[" + content + "-" + temporalId + "." + language  + "]"; 

            uploadElement.classList.remove('upload-image-add');
            uploadElement.classList.add('upload-image');

            updateImageModal(uploadElement);
            openModal();
        };
        
    }else{
        thumbnailElement.style.backgroundImage = null;
    }
}

function openImage(image){

    let url = image.dataset.url;

    if(url){

        let sendImageRequest = async () => {

            try {
                axios.get(url).then(response => {

                    console.log(response)
                    openImageModal(response.data);
                    console.log(response.data)

                });
                
            } catch (error) {

            }
        };

        sendImageRequest();

    }else{       
        
        updateImageModal(image);
        openModal();
    }
}

export function deleteThumbnail(imageId) {

    let uploadImages = document.querySelectorAll(".upload-image");

    uploadImages.forEach(uploadImage => {
    
        if(uploadImage.classList.contains('collection') && uploadImage.dataset.imageid == imageId){

            uploadImage.remove();
        }

        if(uploadImage.classList.contains('single') && uploadImage.dataset.imageid == imageId){

            uploadImage.querySelector(".upload-image-thumb").remove();
            uploadImage.dataset.imageid == '';
            uploadImage.querySelector(".upload-image-prompt").classList.remove('hidden');
            uploadImage.classList.remove('upload-image');
            uploadImage.classList.add('upload-image-add');

            if(uploadImage.querySelector(".upload-image-input")){
                uploadImage.querySelector(".upload-image-input").value = "";
            }
        }
    });
}
