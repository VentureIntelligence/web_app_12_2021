///////////////////////////////////////////////////
// ShowHide plugin                               
// Author: Ashley Ford - http://papermashup.com
// Demo: Tutorial - http://papermashup.com/jquery-show-hide-plugin
// Built: 19th August 2011                                     
///////////////////////////////////////////////////

(function ($) {
    $.fn.showHide = function (options) {

		//default vars for the plugin
        var defaults = {
            speed: 500,
			easing: '',
			changeText: 0
			
        };
		
		 $(".show_hide").click(function () {
$(this).toggleClass("active"); 
$('#restable').addClass('testTable1');
});
 
        var options = $.extend(defaults, options);

        $(this).click(function () {	  
		$("#slidingDiv").animate({width:'toggle'},500); 
           
             $('.toggleDiv').slideUp(options.speed, options.easing);	
			 // this var stores which button you've clicked
             var toggleClick = $(this);
		     // this reads the rel attribute of the button to determine which div id to toggle
		     var toggleDiv = $(this).attr('rel');
		     // here we toggle show/hide the correct div at the right speed and using which easing effect
		     $(toggleDiv).slideToggle(options.speed, options.easing, function() {
		     // this only fires once the animation is completed
			 if(options.changeText==1){
		     $(toggleDiv).is(":visible") ? toggleClick.text(options.hideText) : toggleClick.text(options.showText);
			 }
              });
		  //$(window).trigger('resize'); 
                  
		  return false;
		   	   
        });

    };
})(jQuery);





/*
 * jQuery dropdown: A simple dropdown plugin
 *
 * Inspired by Bootstrap: http://twitter.github.com/bootstrap/javascript.html#dropdowns
 *
 * Copyright 2013 Cory LaViska for A Beautiful Site, LLC. (http://abeautifulsite.net/)
 *
 * Dual licensed under the MIT / GPL Version 2 licenses
 *
*/
if(jQuery) (function($) {
	
	$.extend($.fn, {
		dropdown: function(method, data) {
			
			switch( method ) {
				case 'hide':
					hide();
					return $(this);
				case 'attach':
					return $(this).attr('data-dropdown', data);
				case 'detach':
					hide();
					return $(this).removeAttr('data-dropdown');
				case 'disable':
					return $(this).addClass('dropdown-disabled');
				case 'enable':
					hide();
					return $(this).removeClass('dropdown-disabled');
			}
			
		}
	});
	
	function show(event) {
		
		var trigger = $(this),
			dropdown = $(trigger.attr('data-dropdown')),
			isOpen = trigger.hasClass('dropdown-open');
		
		// In some cases we don't want to show it
		if( $(event.target).hasClass('dropdown-ignore') ) return;
		
		event.preventDefault();
		event.stopPropagation();
		hide();
		
		if( isOpen || trigger.hasClass('dropdown-disabled') ) return;
		
		// Show it
		trigger.addClass('dropdown-open');
		dropdown
			.data('dropdown-trigger', trigger)
			.show();
			
		// Position it
		position();
		
		// Trigger the show callback
		dropdown
			.trigger('show', {
				dropdown: dropdown,
				trigger: trigger
			});
		
	}
	
	function hide(event) {
		
		// In some cases we don't hide them
		var targetGroup = event ? $(event.target).parents().addBack() : null;
		
		// Are we clicking anywhere in a dropdown?
		if( targetGroup && targetGroup.is('.dropdown') ) {
			// Is it a dropdown menu?
			if( targetGroup.is('.dropdown-menu') ) {
				// Did we click on an option? If so close it.
				if( !targetGroup.is('A') ) return;
			} else {
				// Nope, it's a panel. Leave it open.
				return;
			}
		}
		
		// Hide any dropdown that may be showing
		$(document).find('.dropdown:visible').each( function() {
			var dropdown = $(this);
			dropdown
				.hide()
				.removeData('dropdown-trigger')
				.trigger('hide', { dropdown: dropdown });
		});
		
		// Remove all dropdown-open classes
		$(document).find('.dropdown-open').removeClass('dropdown-open');
		
	}
	
	function position() {
		
		var dropdown = $('.dropdown:visible').eq(0),
			trigger = dropdown.data('dropdown-trigger'),
			hOffset = trigger ? parseInt(trigger.attr('data-horizontal-offset') || 0, 10) : null,
			vOffset = trigger ? parseInt(trigger.attr('data-vertical-offset') || 0, 10) : null;
		
		if( dropdown.length === 0 || !trigger ) return;
		
		// Position the dropdown relative-to-parent...
		if( dropdown.hasClass('dropdown-relative') ) {
			dropdown.css({
				left: dropdown.hasClass('dropdown-anchor-right') ?
					trigger.position().left - (dropdown.outerWidth(true) - trigger.outerWidth(true)) - parseInt(trigger.css('margin-right')) + hOffset :
					trigger.position().left + parseInt(trigger.css('margin-left')) + hOffset,
				top: trigger.position().top + trigger.outerHeight(true) - parseInt(trigger.css('margin-top')) + vOffset
			});
		} else {
			// ...or relative to document
			dropdown.css({
				left: dropdown.hasClass('dropdown-anchor-right') ? 
					trigger.offset().left - (dropdown.outerWidth() - trigger.outerWidth()) + hOffset : trigger.offset().left + hOffset,
				top: trigger.offset().top + trigger.outerHeight() + vOffset
			});
		}
	}
	
	$(document).on('click.dropdown', '[data-dropdown]', show);
	$(document).on('click.dropdown', hide);
	$(window).on('resize', position);
	
})(jQuery);


$(document).ready(function(){
	
//Set default open/close settings
$('.acc_container').show(); //Hide/close all containers

if($("h2").hasClass("showdeal"))
{
    $('.acc_trigger').addClass('active').next().show();
   $('.showdeal').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container
}
else
    {
    $('.acc_trigger').addClass('active').next().show(); //Add "active" class to first trigger, then show/open the immediate next container
    }
//On Click
$('.acc_trigger').click(function(){
	if( $(this).next().is(':hidden') ) { //If immediate next container is closed...
		 
		$(this).toggleClass('active').next().slideDown(); //Add .acc_trigger class to clicked trigger and slide down the immediate next container
	$("html, body").animate({ scrollTop: 0 }, "slow"); //Add .acc_trigger class to clicked trigger and slide down the immediate next container
	} 
	else { //If immediate next container is closed..//Remove all .acc_trigger classes and slide up the immediate next container
		$(this).toggleClass('active').next().slideUp(); //Add .acc_trigger class to clicked trigger and slide down the immediate next container
	  
	} 
	return false; //Prevent the browser jump to the link anchor
});




$('.showhide-link').click(function(){
	 $("html, body").animate({ scrollTop: 0 }, "slow"); //Add .acc_trigger class to clicked trigger and slide down the immediate next container
	 

});

});

 
$(document).ready(function(){
  
    $(".hide-period-form").click(function() {
        $(".vertical-form").addClass("hide_description");
    });
 
});