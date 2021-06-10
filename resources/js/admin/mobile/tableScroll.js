import {editElement} from './form';
import {deletePopUp} from './form';

export function scrollRevealItem (){
// window.requestAnimFrame = (function(){
//     'use strict';

// //     return  window.requestAnimationFrame       ||
// //             window.webkitRequestAnimationFrame ||
// //             window.mozRequestAnimationFrame    ||
// //             function( callback ){
// //               window.setTimeout(callback, 1000 / 60);
// //             };
// //   })();

//   /* // [START pointereventsupport] */
//   var pointerDownName = 'pointerdown';
//   var pointerUpName = 'pointerup';
//   var pointerMoveName = 'pointermove';

//   if(window.navigator.msPointerEnabled) {
//     pointerDownName = 'MSPointerDown';
//     pointerUpName = 'MSPointerUp';
//     pointerMoveName = 'MSPointerMove';
//   }

//   // Simple way to check if some form of pointerevents is enabled or not
//   window.PointerEventsSupport = false;
//   if(window.PointerEvent || window.navigator.msPointerEnabled) {
//     window.PointerEventsSupport = true;
//   }
//   /* // [END pointereventsupport] */

  function ScrollRevealItem(element) {
    'use strict';

    // Gloabl state variables
    var STATE_DEFAULT = 1;
    var STATE_TOP_SIDE = 2;
    var STATE_BOTTOM_SIDE = 3;

    var scrollFrontElement = document.querySelector('.table-container');
    var rafPending = false;
    var initialTouchPos = null;
    var lastTouchPos = null;
    var currentYPosition = 0;
    var currentState = STATE_DEFAULT;
    var handleSize = 10;
    let topScrollVisible = 0;
    let bottomScrollVisible = 0;

    // Perform client width here as this can be expensive and doens't
    // change until window.onresize
    var itemWidth = scrollFrontElement.clientWidth;
    var slopValue = itemWidth * (1/4);

    // On resize, change the slop value
    this.resize = function() {
      itemWidth = scrollFrontElement.clientWidth;
      slopValue = itemWidth * (1/4);
    };

    /* // [START handle-start-gesture] */
    // Handle the start of gestures
    this.handleGestureStart = function(evt) {
      evt.preventDefault();

      if(evt.touches && evt.touches.length > 1) {
        return;
      }

      // Add the move and end listeners
      if (scrollFrontElement.PointerEvent) {
        evt.target.setPointerCapture(evt.pointerId);
      } else {
        // Add Mouse Listeners
        document.addEventListener('mousemove', this.handleGestureMove, true);
        document.addEventListener('mouseup', this.handleGestureEnd, true);
      }

      initialTouchPos = getGesturePointFromEvent(evt);

      // scrollFrontElement.style.transition = 'initial';
    }.bind(this);
    /* // [END handle-start-gesture] */

    // Handle move gestures
    //
    /* // [START handle-move] */
    this.handleGestureMove = function (evt) {
      // evt.preventDefault();

      if(!initialTouchPos) {
        return;
      }

      lastTouchPos = getGesturePointFromEvent(evt);

      if(rafPending) {
        return;
      }

      rafPending = true;

      window.requestAnimFrame(onAnimFrame);
    }.bind(this);
    /* // [END handle-move] */

    /* // [START handle-end-gesture] */
    // Handle end gestures
    this.handleGestureEnd = function(evt) {
      evt.preventDefault();

      if(evt.touches && evt.touches.length > 0) {
        return;
      }

      rafPending = false;

      // Remove Event Listeners
      if (scrollFrontElement.PointerEvent) {
        evt.target.releasePointerCapture(evt.pointerId);
      } else {
        // Remove Mouse Listeners
        document.removeEventListener('mousemove', this.handleGestureMove, true);
        document.removeEventListener('mouseup', this.handleGestureEnd, true);
      }

      updateScrollRestPosition();

      initialTouchPos = null;
    }.bind(this);
    /* // [END handle-end-gesture] */

    function updateScrollRestPosition() {
      let transformStyle = 'translateY('+currentYPosition+'px)';
      var differenceInY = initialTouchPos.y - lastTouchPos.y;
      currentYPosition = currentYPosition - differenceInY;

      // Go to the default state and change
      // var newState = STATE_DEFAULT;

      // Check if we need to change state to top or bottom based on slop value
          if(differenceInY > 0) {
            currentYPosition = currentYPosition + 200;
           
        } else if (differenceInY < 0){
        currentYPosition = currentYPosition - 200;
        
        }else if(scrollWindowElement.offsetTop < 0){

          transformStyle = 'translateY('+currentYPosition+'px)';

          scrollWindowElement.style.msTransform = transformStyle;
          scrollWindowElement.style.MozTransform = transformStyle;
          scrollWindowElement.style.webkitTransform = transformStyle;
          scrollWindowElement.style.transform = transformStyle;

          scrollWindowElement.style.transition = 'all 300ms ease-out';
        }
      };
  }
  

    // function changeState(newState) {
    //   var transformStyle;
    //   switch(newState) {
    //     case STATE_DEFAULT:
    //       currentYPosition = 0;
    //       break;
    //     case STATE_TOP_SIDE:
    //       currentYPosition = -(itemWidth - handleSize);
          
    //       currentYPosition = 0;
    //       transformStyle = 'translateY('+currentYPosition+'px)';

    //       scrollFrontElement.style.msTransform = transformStyle;
    //       scrollFrontElement.style.MozTransform = transformStyle;
    //       scrollFrontElement.style.webkitTransform = transformStyle;
    //       scrollFrontElement.style.transform = transformStyle;
    
    //       currentState = newState;
    //       break;
    //     case STATE_BOTTOM_SIDE:
    //       currentYPosition = itemWidth - handleSize;
         
    //       break;
    //   }

    //   transformStyle = 'translateY('+currentYPosition+'px)';

    //   scrollFrontElement.style.msTransform = transformStyle;
    //   scrollFrontElement.style.MozTransform = transformStyle;
    //   scrollFrontElement.style.webkitTransform = transformStyle;
    //   scrollFrontElement.style.transform = transformStyle;

    //   currentState = newState;
    // }

    function getGesturePointFromEvent(evt) {
      var point = {};

      if(evt.targetTouches) {
       
        point.y = evt.targetTouches[0].clientY;
      } else {
        // Either Mouse event or Pointer Event
        
        point.y = evt.clientY;
      }

      return point;
    }

    /* // [START on-anim-frame] */
    function onAnimFrame() {
      if(!rafPending) {
        return;
      }

      var differenceInY = initialTouchPos.y - lastTouchPos.y;

      var newYTransform = (currentYPosition - differenceInY)+'px';
      var transformStyle = 'translateY('+newYTransform+')';
    
      scrollFrontElement.style.webkitTransform = transformStyle;
      scrollFrontElement.style.MozTransform = transformStyle;
      scrollFrontElement.style.msTransform = transformStyle;
      scrollFrontElement.style.transform = transformStyle;

      rafPending = false;
    }
    /* // [END on-anim-frame] */

    /* // [START addlisteners] */
    // Check if pointer events are supported.
    if (scrollFronts.PointerEvent) {
      // Add Pointer Event Listener
      scrollFrontElement.addEventListener('pointerdown', this.handleGestureStart, true);
      scrollFrontElement.addEventListener('pointermove', this.handleGestureMove, true);
      scrollFrontElement.addEventListener('pointerup', this.handleGestureEnd, true);
      scrollFrontElement.addEventListener('pointercancel', this.handleGestureEnd, true);
    } else {
      // Add Touch Listener
      scrollFrontElement.addEventListener('touchstart', this.handleGestureStart, true);
      scrollFrontElement.addEventListener('touchmove', this.handleGestureMove, true);
      scrollFrontElement.addEventListener('touchend', this.handleGestureEnd, true);
      scrollFrontElement.addEventListener('touchcancel', this.handleGestureEnd, true);

      // Add Mouse Listener
      scrollFrontElement.addEventListener('mousedown', this.handleGestureStart, true);
    }
    /* // [END addlisteners] */
  

//   var scrollRevealItems = [];

//   window.onload = function () {
//     'use strict';
//     var scrollRevealItemElements = document.querySelectorAll('.swipe-element');
//     for(var i = 0; i < scrollRevealItemElements.length; i++) {
//       sscrollRevealItems.push(new ScrollRevealItem(scrollRevealItemElements[i]));
//     }

//     // We do this so :active pseudo classes are applied.
//     window.onload = function() {
//       if(/iP(hone|ad)/.test(window.navigator.userAgent)) {
//         document.body.addEventListener('touchstart', function() {}, false);
//       }
//     };
//   };

//   window.onresize = function () {
//     'use strict';
//     for(var i = 0; i < scrollRevealItems.length; i++) {
//       scrollRevealItems[i].resize();
//     }
//   };


//   var registerInteraction = function () {
//     'use strict';
//     // window.sampleCompleted('touch-demo-1.html-ScrollFrontTouch');
//   };

//   var scrollFronts = document.querySelectorAll('.swipe-front');
//   for(var i = 0; i < scrollFronts.length; i++) {
//     scrollFronts[i].addEventListener('touchstart', registerInteraction);
//   }

//   (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
//   function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
//   e=o.createElement(i);r=o.getElementsByTagName(i)[0];
//   e.src='//www.google-analytics.com/analytics.js';
//   r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
//   ga('create','UA-52746336-1');ga('send','pageview');
//   var isCompleted = {};
//   function sampleCompleted(sampleName){
//     if (ga && !isCompleted.hasOwnProperty(sampleName)) {
//       ga('send', 'event', 'WebCentralSample', sampleName, 'completed');
//       isCompleted[sampleName] = true;
//     }
//   }
 }
