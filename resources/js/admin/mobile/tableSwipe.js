import {editElement} from './form';
import {deletePopUp} from './form';

export function SwipeRevealItem(element) {
    'use strict';

    var swipeFrontElement = element.querySelector('.swipe-front');
    
    // Gloabl state variables
    var STATE_DEFAULT = 1;
    var STATE_LEFT_SIDE = 2;
    var STATE_RIGHT_SIDE = 3;

   
    var rafPending = false;
    var initialTouchPos = null;
    var lastTouchPos = null;
    var currentXPosition = 0;
    var currentState = STATE_DEFAULT;
    var handleSize = 10;
    let leftSwipeVisible = 0;
    let rightSwipeVisible = 0;

    // Perform client width here as this can be expensive and doens't
    // change until window.onresize
    var itemWidth = swipeFrontElement.clientWidth;
    var slopValue = itemWidth * (1/4);

    // On resize, change the slop value
    this.resize = function() {
      itemWidth = swipeFrontElement.clientWidth;
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
      if (window.PointerEvent) {
        evt.target.setPointerCapture(evt.pointerId);
      } else {
        // Add Mouse Listeners
        document.addEventListener('mousemove', this.handleGestureMove, true);
        document.addEventListener('mouseup', this.handleGestureEnd, true);
      }

      initialTouchPos = getGesturePointFromEvent(evt);

      swipeFrontElement.style.transition = 'initial';
    }.bind(this);
    /* // [END handle-start-gesture] */

    // Handle move gestures
    //
    /* // [START handle-move] */
    this.handleGestureMove = function (evt) {
      evt.preventDefault();

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
      if (window.PointerEvent) {
        evt.target.releasePointerCapture(evt.pointerId);
      } else {
        // Remove Mouse Listeners
        document.removeEventListener('mousemove', this.handleGestureMove, true);
        document.removeEventListener('mouseup', this.handleGestureEnd, true);
      }

      updateSwipeRestPosition();

      initialTouchPos = null;
    }.bind(this);
    /* // [END handle-end-gesture] */

    function updateSwipeRestPosition() {
      var differenceInX = initialTouchPos.x - lastTouchPos.x;
      currentXPosition = currentXPosition - differenceInX;

      // Go to the default state and change
      var newState = STATE_DEFAULT;

      // Check if we need to change state to left or right based on slop value
      if(Math.abs(differenceInX) > slopValue) {
        if(currentState === STATE_DEFAULT) {
          if(differenceInX > 0)  {
            newState = STATE_LEFT_SIDE;
          } else {
            newState = STATE_RIGHT_SIDE;
          }
        } else {
          if(currentState === STATE_LEFT_SIDE && differenceInX > 0) {
            newState = STATE_DEFAULT;
          } else if(currentState === STATE_RIGHT_SIDE && differenceInX < 0) {
            newState = STATE_DEFAULT;
          }
        }
      } else {
        newState = currentState;
      }

      changeState(newState);

      swipeFrontElement.style.transition = 'all 150ms ease-out';
    }

    function changeState(newState) {
      var transformStyle;
      switch(newState) {
        case STATE_DEFAULT:
          currentXPosition = 0;
          break;
        case STATE_LEFT_SIDE:
          currentXPosition = -(itemWidth - handleSize);
          deletePopUp(element.querySelector('.left-swipe').dataset.url);
          currentXPosition = 0;
          transformStyle = 'translateX('+currentXPosition+'px)';

          swipeFrontElement.style.msTransform = transformStyle;
          swipeFrontElement.style.MozTransform = transformStyle;
          swipeFrontElement.style.webkitTransform = transformStyle;
          swipeFrontElement.style.transform = transformStyle;
    
          currentState = newState;
          break;
        case STATE_RIGHT_SIDE:
          currentXPosition = itemWidth - handleSize;
          editElement(element.querySelector('.right-swipe').dataset.url);
          break;
      }

      transformStyle = 'translateX('+currentXPosition+'px)';

      swipeFrontElement.style.msTransform = transformStyle;
      swipeFrontElement.style.MozTransform = transformStyle;
      swipeFrontElement.style.webkitTransform = transformStyle;
      swipeFrontElement.style.transform = transformStyle;

      currentState = newState;
    }

    function getGesturePointFromEvent(evt) {
      var point = {};

      if(evt.targetTouches) {
        point.x = evt.targetTouches[0].clientX;
        point.y = evt.targetTouches[0].clientY;
      } else {
        // Either Mouse event or Pointer Event
        point.x = evt.clientX;
        point.y = evt.clientY;
      }

      return point;
    }

    /* // [START on-anim-frame] */
    function onAnimFrame() {
      if(!rafPending) {
        return;
      }

      var differenceInX = initialTouchPos.x - lastTouchPos.x;

      var newXTransform = (currentXPosition - differenceInX)+'px';
      var transformStyle = 'translateX('+newXTransform+')';
      if(Math.sign(differenceInX) == 1 && leftSwipeVisible == 0){

        let swipeActive = document.getElementById('swipe-active');

        if(swipeActive !== null){
            swipeActive.removeAttribute('id');
        }

        element.querySelector('.left-swipe').id = 'swipe-active';
        
        leftSwipeVisible = 1;
        rightSwipeVisible = 0;

    }else if(Math.sign(differenceInX) == -1 && rightSwipeVisible == 0){

        let swipeActive = document.getElementById('swipe-active');

        if(swipeActive !== null){
            swipeActive.removeAttribute('id');
        }

        element.querySelector('.right-swipe').id = 'swipe-active';

        leftSwipeVisible = 0;
        rightSwipeVisible = 1;
    }
      swipeFrontElement.style.webkitTransform = transformStyle;
      swipeFrontElement.style.MozTransform = transformStyle;
      swipeFrontElement.style.msTransform = transformStyle;
      swipeFrontElement.style.transform = transformStyle;

      rafPending = false;
    }
    /* // [END on-anim-frame] */

    /* // [START addlisteners] */
    // Check if pointer events are supported.
    if (window.PointerEvent) {
      // Add Pointer Event Listener
      swipeFrontElement.addEventListener('pointerdown', this.handleGestureStart, true);
      swipeFrontElement.addEventListener('pointermove', this.handleGestureMove, true);
      swipeFrontElement.addEventListener('pointerup', this.handleGestureEnd, true);
      swipeFrontElement.addEventListener('pointercancel', this.handleGestureEnd, true);
    } else {
      // Add Touch Listener
      swipeFrontElement.addEventListener('touchstart', this.handleGestureStart, true);
      swipeFrontElement.addEventListener('touchmove', this.handleGestureMove, true);
      swipeFrontElement.addEventListener('touchend', this.handleGestureEnd, true);
      swipeFrontElement.addEventListener('touchcancel', this.handleGestureEnd, true);

      // Add Mouse Listener
      swipeFrontElement.addEventListener('mousedown', this.handleGestureStart, true);
    }
    /* // [END addlisteners] */
  }

  var swipeRevealItems = [];

  window.onload = function () {
    'use strict';
    var swipeRevealItemElements = document.querySelectorAll('.swipe-element');
    for(var i = 0; i < swipeRevealItemElements.length; i++) {
      swipeRevealItems.push(new SwipeRevealItem(swipeRevealItemElements[i]));
    }

    // We do this so :active pseudo classes are applied.
    window.onload = function() {
      if(/iP(hone|ad)/.test(window.navigator.userAgent)) {
        document.body.addEventListener('touchstart', function() {}, false);
      }
    };
  };

  window.onresize = function () {
    'use strict';
    for(var i = 0; i < swipeRevealItems.length; i++) {
      swipeRevealItems[i].resize();
    }
  };


  var registerInteraction = function () {
    'use strict';
    // window.sampleCompleted('touch-demo-1.html-SwipeFrontTouch');
  };

  var swipeFronts = document.querySelectorAll('.swipe-front');
  for(var i = 0; i < swipeFronts.length; i++) {
    swipeFronts[i].addEventListener('touchstart', registerInteraction);
  }

  (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
  function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
  e=o.createElement(i);r=o.getElementsByTagName(i)[0];
  e.src='//www.google-analytics.com/analytics.js';
  r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
  ga('create','UA-52746336-1');ga('send','pageview');
  var isCompleted = {};
  function sampleCompleted(sampleName){
    if (ga && !isCompleted.hasOwnProperty(sampleName)) {
      ga('send', 'event', 'WebCentralSample', sampleName, 'completed');
      isCompleted[sampleName] = true;
    }
  }
