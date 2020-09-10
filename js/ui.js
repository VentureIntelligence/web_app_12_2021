 

 
$(function(){
	window.onorientationchange = function() { 
       window.location.reload();
    };
	
    $('.home-banner-container').width( $(window).width() );
	
	
    var slide = setInterval( function(){ $('.nextBtn').trigger('click') }, 8000 );
    $(".prevBtn").click(function(){
        if( $('.home-banner-container.selectedSlide').prev().length ){
            $('.home-banner-container.selectedSlide').prev().trigger('click');
        }else{
            $('.home-banner-container:last').trigger('click');
        }
    });
    $(".nextBtn").click(function(){
        if( $('.home-banner-container.selectedSlide').next().length ){
            $('.home-banner-container.selectedSlide').next().trigger('click');
        }else{
            $('.home-banner-container:first').trigger('click');
        }
    });

    $('.home-banner-container').click(function(){
        clearInterval(slide);
        $(this).addClass('selectedSlide').siblings().removeClass('selectedSlide');
        var thisIndex = $(this).index();
        var leftPos = $('.home-banner-container').outerWidth()*thisIndex;
        $(".home-banner-container").stop().animate({ left : "-"+leftPos },1000);
        $(".tab-banner > ul li").eq(thisIndex).addClass('bg-active').siblings().removeClass('bg-active');
        slide = setInterval( function(){ $('.nextBtn').trigger('click') }, 8000 );
    });
    $(".tab-banner > ul > li").click(function(){
        var thisIndex = $(this).index();
        $('.home-banner-container').eq(thisIndex).trigger('click');
        $(this).addClass('bg-active').siblings().removeClass('bg-active');
    });
});

 


	
	
	
	