/*
 * jQuery FlexSlider v1.8
 * http://flex.madebymufffin.com
 *
 * Copyright 2011, Tyler Smith
 * Free to use under the MIT license.
 * http://www.opensource.org/licenses/mit-license.php
 *
 * Contrib: Darin Richardson
 */

;(function ($) {
  
  //FlexSlider: Object Instance
  $.flexslider = function(el, options) {
    var slider = el;

    slider.init = function() {
      slider.vars = $.extend({}, $.flexslider.defaults, options);
      slider.data('flexslider', true);
      slider.container = $('.slides', slider);
      slider.slides = $('.slides > li', slider);
      slider.count = slider.slides.length;
      slider.animating = false;
      slider.currentSlide = slider.vars.slideToStart;
      slider.animatingTo = slider.currentSlide;
      slider.atEnd = (slider.currentSlide == 0) ? true : false;
      slider.eventType = ('ontouchstart' in document.documentElement) ? 'touchstart' : 'click';
      slider.cloneCount = 0;
      slider.cloneOffset = 0;
      slider.manualPause = false;
      slider.vertical = (slider.vars.slideDirection == "vertical");
      slider.prop = (slider.vertical) ? "top" : "marginLeft";
      slider.args = {};
      
      //Test for webbkit CSS3 Animations
      slider.transitions = "webkitTransition" in document.body.style;
      if (slider.transitions) slider.prop = "-webkit-transform";
      
      //Test for controlsContainer
      if (slider.vars.controlsContainer != "") {
        slider.controlsContainer = $(slider.vars.controlsContainer).eq($('.slides').index(slider.container));
        slider.containerExists = slider.controlsContainer.length > 0;
      }
      //Test for manualControls
      if (slider.vars.manualControls != "") {
        slider.manualControls = $(slider.vars.manualControls, ((slider.containerExists) ? slider.controlsContainer : slider));
        slider.manualExists = slider.manualControls.length > 0;
      }
      
      ///////////////////////////////////////////////////////////////////
      // FlexSlider: Randomize Slides
      if (slider.vars.randomize) {
        slider.slides.sort(function() { return (Math.round(Math.random())-0.5); });
        slider.container.empty().append(slider.slides);
      }
      ///////////////////////////////////////////////////////////////////
      
      ///////////////////////////////////////////////////////////////////
      // FlexSlider: Slider Animation Initialize
       
      ///////////////////////////////////////////////////////////////////
      
      ///////////////////////////////////////////////////////////////////
      // FlexSlider: Control Nav
      
      ///////////////////////////////////////////////////////////////////
      
      //////////////////////////////////////////////////////////////////
      //FlexSlider: Direction Nav
      
      //////////////////////////////////////////////////////////////////
      
      //////////////////////////////////////////////////////////////////
      //FlexSlider: Keyboard Nav
      
      //////////////////////////////////////////////////////////////////
      
      ///////////////////////////////////////////////////////////////////
      // FlexSlider: Mousewheel interaction
     
      ///////////////////////////////////////////////////////////////////
      
      //////////////////////////////////////////////////////////////////
      //FlexSlider: Slideshow Setup
      
      //////////////////////////////////////////////////////////////////
      
      //////////////////////////////////////////////////////////////////
      //FlexSlider: Pause/Play
       
      //////////////////////////////////////////////////////////////////
      
      //////////////////////////////////////////////////////////////////
      //FlexSlider:Touch Swip Gestures
      //Some brilliant concepts adapted from the following sources
      //Source: TouchSwipe - http://www.netcu.de/jquery-touchwipe-iphone-ipad-library
      //Source: SwipeJS - http://swipejs.com
      
      //////////////////////////////////////////////////////////////////
      
      //////////////////////////////////////////////////////////////////
      //FlexSlider: Resize Functions (If necessary)
     
      //////////////////////////////////////////////////////////////////
      
      //////////////////////////////////////////////////////////////////
      //FlexSlider: Destroy the slider entity
      //Destory is not included in the minified version right now, but this is a working function for anyone who wants to include it.
      //Simply bind the actions you need from this function into a function in the start() callback to the event of your chosing
      /*
      slider.destroy = function() {
        slider.pause();
        if (slider.controlNav && slider.vars.manualControls == "") slider.controlNav.closest('.flex-control-nav').remove();
        if (slider.directionNav) slider.directionNav.closest('.flex-direction-nav').remove();
        if (slider.vars.pausePlay) slider.pausePlay.closest('.flex-pauseplay').remove();
        if (slider.vars.keyboardNav && $('ul.slides').length == 1) $(document).unbind('keyup', keyboardMove);
        if (slider.vars.mousewheel) slider.unbind(slider.mousewheelEvent);
        if (slider.transitions) slider.each(function(){this.removeEventListener('touchstart', onTouchStart, false);});
        if (slider.vars.animation == "slide" && slider.vars.animationLoop) slider.newSlides.filter('.clone').remove();
        if (slider.vertical) slider.height("auto");
        slider.slides.hide();
        slider.removeData('flexslider');
      }
      */
      //////////////////////////////////////////////////////////////////
      
      //FlexSlider: start() Callback 
    }
    
    //FlexSlider: Animation Actions
    slider.flexAnimate = function(target, pause) {
      if (!slider.animating) {
        //Animating flag
        slider.animating = true;
        
        //FlexSlider: before() animation Callback
        
        //Optional paramter to pause slider when making an anmiation call
        
        
        //Update controlNav    
        //Is the slider at either end
        slider.atEnd = (target == 0 || target == slider.count - 1) ? true : false;
        if (!slider.vars.animationLoop && slider.vars.directionNav) {
          if (target == 0) {
            slider.directionNav.removeClass('disabled').filter('.prev').addClass('disabled');
          } else if (target == slider.count - 1) {
            slider.directionNav.removeClass('disabled').filter('.next').addClass('disabled');
          } else {
            slider.directionNav.removeClass('disabled');
          }
        }
        
        if (!slider.vars.animationLoop && target == slider.count - 1) {
          slider.pause();
          //FlexSlider: end() of cycle Callback
          slider.vars.end(slider);
        }
        
        if (slider.vars.animation.toLowerCase() == "slide") {
          var dimension = (slider.vertical) ? slider.slides.filter(':first').height() : slider.slides.filter(':first').width();
          
          if (slider.currentSlide == 0 && target == slider.count - 1 && slider.vars.animationLoop && slider.direction != "next") {
            slider.slideString = "0px";
          } else if (slider.currentSlide == slider.count - 1 && target == 0 && slider.vars.animationLoop && slider.direction != "prev") {
            slider.slideString = (-1 * (slider.count + 1)) * dimension + "px";
          } else {
            slider.slideString = (-1 * (target + slider.cloneOffset)) * dimension + "px";
          }
          slider.args[slider.prop] = slider.slideString;

          if (slider.transitions) {
              slider.setTransition(slider.vars.animationDuration); 
              slider.args[slider.prop] = (slider.vertical) ? "translate3d(0," + slider.slideString + ",0)" : "translate3d(" + slider.slideString + ",0,0)";
              slider.container.css(slider.args).one("webkitTransitionEnd transitionend", function(){
                slider.wrapup(dimension);
              });   
          } else {
            slider.container.animate(slider.args, slider.vars.animationDuration, function(){
              slider.wrapup(dimension);
            });
          }
        } else { //Default to Fade
          slider.slides.eq(slider.currentSlide).fadeOut(slider.vars.animationDuration);
          slider.slides.eq(target).fadeIn(slider.vars.animationDuration, function() {
            slider.wrapup();
          });
        }
      }
    }
    
    //FlexSlider: Function to minify redundant animation actions
   
    
    //FlexSlider: Automatic Slideshow
    
    
    //FlexSlider: Automatic Slideshow Pause
   
    
    //FlexSlider: Automatic Slideshow Start/Resume
   
    
    //FlexSlider: Helper function for non-looping sliders
    
    
    //FlexSlider: Helper function to determine animation target
    
    
    //FlexSlider: Helper function to set CSS3 transitions
    
    //FlexSlider: Initialize
    slider.init();
  }
  
  //FlexSlider: Default Settings
   
  
  //FlexSlider: Plugin Function
  $.fn.flexslider = function(options) {
    return this.each(function() {
      if ($(this).find('.slides li').length == 1) {
        $(this).find('.slides li').fadeIn(400);
      }
      else if ($(this).data('flexslider') != true) {
        new $.flexslider($(this), options);
      }
    });
  }  

})(jQuery);