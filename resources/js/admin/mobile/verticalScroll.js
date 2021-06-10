import { paginatorElement } from "./form";

export function scrollWindowElement (element){

    'use strict'; //es para usar js estricto

    let scrollWindowElement = element;

    let rafPending = false;
    let initialTouchPos = null;
    let lastTouchPos = null;
    let currentYPosition = 0;

    //el this y el bind(this) eran la forma antigua de evitar que el this tenga comflicto entre ellos. 
    // a esta función se le llama abajo.
    //cualquier evento de js se puede recoger escribiedo evt como parámetro.
    this.handleGestureStart = function(evt) {

        //que solo haya un evento de touch
        if(evt.touches && evt.touches.length > 1) {
            return;
        }

        if (scrollWindowElement.PointerEvent) {
            evt.target.setPointerCapture(evt.pointerId);

        //para hacer pruebas con el portatil.
        } else {
            document.addEventListener('mousemove', this.handleGestureMove, true);
            document.addEventListener('mouseup', this.handleGestureEnd, true);
        }

        //llama a la funcion getGesturePointFromEvent pasandole la informacion del evento que captura al tocar y se guarda en la variable vacia que hemos declarado al principio.
        initialTouchPos = getGesturePointFromEvent(evt);

    }.bind(this);

    //esta fiuncion se arranca al mover el dedo.
    this.handleGestureMove = function (evt) {

        //initialTouchPos es la posicion en el eje de las y. Si no tiene ningun valor (!) el return para la funcion. No mediremos el movimiento si no hemos tocado antes, esto se pone por seguridad.
        if(!initialTouchPos) {
            return;
        }

        //se coje la ultima posicion del movimiento
        lastTouchPos = getGesturePointFromEvent(evt);

        //si rafPending es verdadero (declarado antes), ahora es falso por lo que no devuelve nada.
        //dentro de un condicional siempre se evalue si lo que hay es verdadero
        if(rafPending) {
            return;
        }

        //al acabar se pone rafPending true como bandera, para que no se pueda volver para atras y queden cosas pendientes
        rafPending = true;

        //la ventana necesita del requestAnimationFrame que esta en boostrap porque lo vamos a usar amenudo, sirve para que las animaciones sean más suaves. Además, lo primero que ejecuta es la animación para darle prioridad. La animación es onAnimeFrame. Puedes pasar como parámetro de una función otra función. Dentro del reqestAnimation se va a cargar el onAnimeFrame. 
        window.requestAnimationFrame(onAnimFrame);

    }.bind(this);

    this.handleGestureEnd = function(evt) {

        evt.preventDefault();

        if(evt.touches && evt.touches.length > 0) {
            return;
        }

        rafPending = false;

        if (scrollWindowElement.PointerEvent) {
            evt.target.releasePointerCapture(evt.pointerId);
        } else {
            document.removeEventListener('mousemove', this.handleGestureMove, true);
            document.removeEventListener('mouseup', this.handleGestureEnd, true);
        }

        updateScrollRestPosition();

        initialTouchPos = null;

    }.bind(this);


    function updateScrollRestPosition() {
        let transformStyle;
        let differenceInY = initialTouchPos.y - lastTouchPos.y;
        currentYPosition = currentYPosition - differenceInY;


        transformStyle = currentYPosition+'px';
        scrollWindowElement.style.top = transformStyle;
        scrollWindowElement.style.transition = 'all 300ms ease-out';

        changeState();
    }


    function getGesturePointFromEvent(evt) {

        //esto es un json
        let point = {};

        //dentro del json point hay una clave "y" que tiene como valor la posicion del valor del evento de tocar
        //el json seria asi:
        // point = {
        //     y: valor
        // }
        if(evt.targetTouches) {
            point.y = evt.targetTouches[0].clientY;
        } else {
            point.y = evt.clientY;
        }

        return point; 

    }

    function onAnimFrame() {

        //revisa la bandera, si es falsa entonces vuelve, porque en el handleGestureMove le hemos dicho que la bandera sea verdadera, si fuera falsa no habría entrado en la funcion de movimiento
        if(!rafPending) {
            return;
        }

        //la diferencia sera lo que se ha desplazado, si el valor es negativo el movimiento es hacia arriba
        let differenceInY = initialTouchPos.y - lastTouchPos.y;
        //miramos cual es la posicion actual y le restamos la difencia para saber que es lo que tenemos que cambiar en pixeles
        let transformStyle  = (currentYPosition - differenceInY)+'px';

        scrollWindowElement.style.top = transformStyle;
        

        
        rafPending = false;
    }
    //toda esta funcion él la tiene dentro de onAnimeFrame.
    function changeState() {
        let transformStyle
        let menu = document.getElementById('bottombar-item').getBoundingClientRect(),
            elemRect = document.querySelector('.table').getBoundingClientRect(),
            container = elemRect.bottom - elemRect.top;
        //si el gesto es de ir hacia arriba entonces: (el usa differenceInY)
        if(currentYPosition > 1){
            //si la aprte superior de la tabla (en este caso) es mayor que 0px, entonces volvemos a 0px para que no pueda seguir 
            if(scrollWindowElement.style.top>=0+'px')

            currentYPosition = 0;
            transformStyle  = currentYPosition+'px';
            scrollWindowElement.style.top = transformStyle;
            //si no
            //scrollWindowElement.style.top=transforStyle.

        //si va hacia abajo, también podría ser un else. Él tiene una bandera llamada paginationVisible que llama a la paginación y le cambia el atributo.Esta bandera es para evitar que se lance muchas veces.
        //La funcion pagination y sustituye todo lo que no sean digitos por nada. RegEx ayuda a saber que quieres cambiar, son generadores de expresiones regulares, sirven para buscar, remplazar, etc. 
        // url.replace(/^\D+/g, '')
        //Luego crea un json con información que va a guardar en el tracking. Hace un axios get y adjunta la nueva pagina al final de la anterior y no encima. En response tenemos los datos de la siguiente página. Pregunta si hay rows, es decir datos, si los hay los añade abajo, pero si no no. Lo hace con:
        //response.data.table.match(/table-row/g). A un númer un ++ le suma 1, para saber la siguiente página al NextPage le pasamos la currentPage como un número (parseInt) y le sumamos 1 y lo cambiamos a la url. 
        }else if(currentYPosition < -1 ){
           
            if(elemRect.bottom<=menu.top){
             
                if(element.querySelector('.table-container').dataset.current!=element.querySelector('.table-container').dataset.last){
                    paginatorElement(element.querySelector('.table-container').dataset.page);
                }
          

                if(element.querySelector('.table-container').dataset.current==element.querySelector('.table-container').dataset.last){
                    currentYPosition = menu.top - container;
                    transformStyle  = currentYPosition+'px';
                    scrollWindowElement.style.top = transformStyle;
                }
            
               
            }
            //editElement(element.querySelector('.right-swipe').dataset.url);
        };
    
    };

    //el elemento que le hemos pasado (la tabla) tiene 4 eventos, el passive:true es para hacer mas fluido el touch
    //googloe recomienda que a todos los eventos touch start y move se les añada passive:true
    scrollWindowElement.addEventListener('touchstart', this.handleGestureStart, {passive: true} );
    scrollWindowElement.addEventListener('touchmove', this.handleGestureMove, {passive: true} );
    scrollWindowElement.addEventListener('touchend', this.handleGestureEnd, true);
    scrollWindowElement.addEventListener('touchcancel', this.handleGestureEnd, true);
};   