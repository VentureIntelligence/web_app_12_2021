<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>Venture Intelligence</title>
<link href="css/skin.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="css/detect800.css" />

<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/popup.js"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />

<script type="text/javascript" src="js/jquery.multiselect.js"></script> 
<script type="text/javascript" src="js/expand.js"></script>
<script src="js/showHide.js" type="text/javascript"></script>
<script src="js/jquery.flexslider.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<script type="text/javascript">

$(document).ready(function(){


   $('.show_hide').showHide({			 
		speed: 500,  // speed you want the toggle to happen	
		easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
		changeText: 1 // if you dont want the button text to change, set this to 0
		
					 
	}); 
	$(".btn-slide").click(function(){
		$("#panel").animate({width: 'toggle'});
		$(this).toggleClass("active"); return false; 
	});
	
	 
});
</script>
 <script type="text/javascript" >
$(document).ready(function()
{
$(".account").click(function()
{

$('.submenu').toggle();
});

//Mouseup textarea false
$(".submenu").mouseup(function()
{
return false
});
$(".account").mouseup(function()
{
return false
});
//Textarea without editing.
$(document).mouseup(function()
{
$(".submenu").hide();
});

}); 
</script> 
<script type="text/javascript" src="js/tytabs.jquery.min.js"></script>
<script type="text/javascript">
<!--
$(document).ready(function(){
	 
	$("#tabsholder2").tytabs({
                prefixtabs:"tabz",
                prefixcontent:"contentz",
                classcontent:"tabscontent",
                tabinit:"1",
                catchget:"tab2",
                fadespeed:"normal"
                });
});
-->
</script>   
<script src="js/jPages.js"></script>
<script src="js/jquery.icheck.min.js?v=0.9.1"></script>
<script src="js/jquery.flexslider.js"></script><!--[if lt IE 9]>
<script type="text/javascript" src="http://erikjohanssonphoto.com/wp-content/themes/erikj/js/IE9.js"></script>
<![endif]-->

<!-- Masonry -->
<script src="js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="js/responsive-tables.js"></script>
    
<script type="text/javascript">
	
    jQuery(window).load(function() {
                    jQuery('.flexslider').flexslider({ directionNav: false });
                    jQuery(function(){
                            jQuery('.masonry-container').masonry({
                                    itemSelector: '.work-masonry-thumb',
                                    columnWidth: 159 
                            });
                    });

    });
    
  $(document).ready(function(){ 
		$("#myTable").tablesorter({widthFixed: true}); 
		$("div.holder").jPages({
		  containerID : "movies",
		  previous : "← Previous",
		  next : "Next →",
		  perPage : 50,
		  delay : 20
		});
	});
    $(document).ready(function(){
      $('input').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
      });
    });
</script>   
 <script>
       
    
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) { 
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
			//( ".selector" ).on( "autocompletechange", function( event, ui ) {} );
          },
         /*  autocompletechange: "_removeIfInvalid",*/
		   
   			/*autocompletechange: function( event, ui ) { 
				$("form").submit();
			}*/
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
	var keywordsearchbox = $("#keywordsearch").combobox();
    var companysearchbox = $("#combobox").combobox();
	var advisorsearch_legalbox = $("#advisorsearch_legal").combobox();
	var advisorsearch_transbox = $("#advisorsearch_trans").combobox();
    var sectorsearchbox = $("#sectorsearch").combobox();
	/*$( ".custom-combobox" ).autocomplete({
	  change: function( event, ui ) { this.form.submit(); }
	});*/
        
         keywordsearchbox.on( "comboboxselect", function( event, ui ) {
           companysearchbox.combobox("destroy") ;
           advisorsearch_legalbox.combobox("destroy") ;
           advisorsearch_transbox.combobox("destroy") ;
           sectorsearchbox.combobox("destroy") ; 
           $("#combobox option:eq(0)").attr('selected','selected');
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           $("#sectorsearch option:eq(0)").attr('selected','selected');
           companysearchbox.combobox() ;
           advisorsearch_legalbox.combobox() ;
           advisorsearch_transbox.combobox() ;
           sectorsearchbox.combobox() ; 
        } );
       companysearchbox.on( "comboboxselect", function( event, ui ) {
           keywordsearchbox.combobox("destroy") ;
           advisorsearch_legalbox.combobox("destroy") ;
           advisorsearch_transbox.combobox("destroy") ;
           sectorsearchbox.combobox("destroy") ; 
           $("#keywordsearch option:eq(0)").attr('selected','selected');
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           $("#sectorsearch option:eq(0)").attr('selected','selected');
           keywordsearchbox.combobox() ;
           advisorsearch_legalbox.combobox() ;
           advisorsearch_transbox.combobox() ;
           sectorsearchbox.combobox() ; 
        } );
         sectorsearchbox.on( "comboboxselect", function( event, ui ) {
           keywordsearchbox.combobox("destroy") ;
           companysearchbox.combobox("destroy") ;
           advisorsearch_legalbox.combobox("destroy") ;
           advisorsearch_transbox.combobox("destroy") ; 
           $("#combobox option:eq(0)").attr('selected','selected');
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           $("#sectorsearch option:eq(0)").attr('selected','selected');
           keywordsearchbox.combobox() ;
           companysearchbox.combobox() ;
           advisorsearch_legalbox.combobox() ;
           advisorsearch_transbox.combobox() ;
        } );
       advisorsearch_legalbox.on( "comboboxselect", function( event, ui ) {
           keywordsearchbox.combobox("destroy") ;
           companysearchbox.combobox("destroy") ;
           advisorsearch_transbox.combobox("destroy") ;
           sectorsearchbox.combobox("destroy") ; 
           $("#keywordsearch option:eq(0)").attr('selected','selected');
           $("#combobox option:eq(0)").attr('selected','selected');
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           $("#sectorsearch option:eq(0)").attr('selected','selected');
           keywordsearchbox.combobox() ;
           companysearchbox.combobox() ;
           advisorsearch_transbox.combobox() ;
           sectorsearchbox.combobox() ; 
        } );
         advisorsearch_transbox.on( "comboboxselect", function( event, ui ) {
           keywordsearchbox.combobox("destroy") ;
           companysearchbox.combobox("destroy") ;
           advisorsearch_legalbox.combobox("destroy") ;
           sectorsearchbox.combobox("destroy") ; 
            $("#keywordsearch option:eq(0)").attr('selected','selected');
           $("#combobox option:eq(0)").attr('selected','selected');
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           $("#sectorsearch option:eq(0)").attr('selected','selected');
           keywordsearchbox.combobox() ;
           companysearchbox.combobox() ;
           advisorsearch_legalbox.combobox() ;
           sectorsearchbox.combobox() ; 
        } );
       
        
        $("#resetall").click(function (){
           keywordsearchbox.combobox("destroy") ;
           companysearchbox.combobox("destroy") ;
           advisorsearch_legalbox.combobox("destroy") ;
           advisorsearch_transbox.combobox("destroy") ;
           sectorsearchbox.combobox("destroy") ; 
           
           $("#keywordsearch option:eq(0)").attr('selected','selected');
           $("#combobox option:eq(0)").attr('selected','selected');
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           $("#sectorsearch option:eq(0)").attr('selected','selected');
           
           keywordsearchbox.combobox();
           companysearchbox.combobox() ;
           advisorsearch_legalbox.combobox() ;
           advisorsearch_transbox.combobox() ;
           sectorsearchbox.combobox() ; 
        });
    
 
        
  });
 
 

/*$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);*/ 
      jQuery(window).load(function() {
                    jQuery('.flexslider').flexslider({ directionNav: false });
                    jQuery(function(){
                            jQuery('.masonry-container').masonry({
                                    itemSelector: '.work-masonry-thumb',
                                    columnWidth: 159 
                            });
                    });

    });
 
</script>
  <script>
  
  $(document).ready(function() {

	if ((screen.width>=1280) && (screen.height>=720))
	{
		//alert('Screen size: 1280x720 or larger');
		//$("link[rel=stylesheet]:not(:first)").attr({href : "css/detect1024.css"});
	}
	else
	{
		//alert('Screen size: less than 1280x720, 1024x768, 800x600 maybe?');
		$("link[rel=stylesheet]:not(:first)").attr({href : "css/detect800.css"});
	}
});
 
$(document).ready(function(){
 
  	$(".popup").LePopup({

		skin : "big-shadow"
           });

        
     $('.investment-nav').on('ifChecked', function(event){
       
 navvalue=$(this).val();
       switch(navvalue)
       {
           case '0':
                    var hrefval = 'index.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    break;
           case '1':
                    var hrefval = 'index.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    break;
           case '2':
                   window.location.href = 'angelindex.php';
                   break;
           case '3':
                    var hrefval = 'svindex.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                   //window.location.href = 'svtrendview.php?value='+$(this).val();
                   break;
           case '4':
                    var hrefval = 'svindex.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                     //window.location.href = 'svtrendview.php?value='+$(this).val();
                    break;
           case '5':
                    var hrefval = 'svindex.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                   // window.location.href = 'svtrendview.php?value='+$(this).val();
                   break;
            case '6':
                   window.location.href = 'incindex.php';
                   break;
            
       }
       

});

 $('.section-nav').on('ifChecked', function(event){
       
 navvalue=$(this).val();
       switch(navvalue)
       {
           case '0':
                   window.location.href = 'pedirview.php?value='+$(this).val();
                   break;
           case '1':
                   window.location.href = 'index.php?value='+$(this).val();
                   break;
           case '2':
                   window.location.href = 'angelindex.php';
                   break;
           case '3':
                   window.location.href = 'svindex.php?value='+$(this).val();
                   break;
           case '4':
                   window.location.href = 'svindex.php?value='+$(this).val();
                   break;
           case '5':
                   window.location.href = 'svindex.php?value='+$(this).val();
                   break;
            case '6':
                   window.location.href = 'incindex.php';
                   break;
            case '0-0':
                   window.location.href = 'pemaexist.php?value='+$(this).val();
                   break;
       }
       

});

 $('.exist-nav').on('ifChecked', function(event){
       navvalue=$(this).val();
       switch(navvalue)
       {
           case 'PE-BACKED-IPO':
                   window.location.href = 'ipoindex.php?value=0';
                   break;
           case 'VC-BACKED-IPO':
                   window.location.href = 'ipoindex.php?value=1';
                   break;
           case 'PMS':
                   window.location.href = 'mandaindex.php?value=0-1';
                   break;
           case 'PE-EXIST':
                   window.location.href = 'mandaindex.php?value=0-0';
                   break;
           case 'VC-EXIST':
                   window.location.href = 'mandaindex.php?value=1-0';
                   break;
               
       }
       

});

$('.typeoff-nav').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
        window.location.assign("trendview.php?type=1");
    }
    else if (value == 2) {
        window.location.assign("trendview.php?type=2");
    }
    else if (value == 3) {
        window.location.assign("trendview.php?type=3");
    }
    else if (value == 4) {
        window.location.assign("trendview.php?type=4");
    }
    else if (value == 5) {
        window.location.assign("trendview.php?type=5");
    }
    else if (value == 6) {
        window.location.assign("trendview.php?type=6");
    }
});
$('.typeoff-nav2').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
           var hrefval = 'index.php?type=1&value=0';
                    $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=1&value=0");
    }
    else if (value == 2) {
         var hrefval = 'index.php?type=2&value=0';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=2&value=0");
    }
    else if (value == 3) {
         var hrefval = 'index.php?type=3&value=0';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=3&value=0");
    }
    else if (value == 4) {
         var hrefval = 'index.php?type=4&value=0';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=4&value=0");
    }
    else if (value == 5) {
                     var hrefval = 'index.php?type=5&value=0';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=5&value=0");
    }
    else if (value == 6) {
                     var hrefval = 'index.php?type=6&value=0';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=6&value=0");
    }
});
$('.typeoff-nav21').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
                  var hrefval = 'index.php?type=1&value=1';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
      
    }
    else if (value == 2) {
        var hrefval = 'index.php?type=2&value=1';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        
    }
    else if (value == 3) {
         var hrefval = 'index.php?type=3&value=1';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
     
    }
    else if (value == 4) {
         var hrefval = 'index.php?type=4&value=1';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
      
    }
    else if (value == 5) {
       var hrefval = 'index.php?type=5&value=1';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
    }
    else if (value == 6) {
        var hrefval = 'index.php?type=6&value=1';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
    }
});
$('.typeoff-nav24').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
          var hrefval = 'svindex.php?type=1&value=4';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("svtrendview.php?type=1&value=4");
    }
    else if (value == 2) {
        var hrefval = 'svindex.php?type=2&value=4';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("svtrendview.php?type=2&value=4");
    }
    else if (value == 3) {
        var hrefval = 'svindex.php?type=3&value=4';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("svtrendview.php?type=3&value=4");
    }
    else if (value == 4) {
        var hrefval = 'svindex.php?type=4&value=4';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("svtrendview.php?type=4&value=4");
    }
    else if (value == 5) {
        var hrefval = 'svindex.php?type=5&value=4';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("svtrendview.php?type=5&value=4");
    }
    else if (value == 6) {
        var hrefval = 'svindex.php?type=6&value=4';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("svtrendview.php?type=6&value=4");
    }
});
$('.typeoff-nav23').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
                var  hrefval= "svindex.php?type=1&value=3";
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
    }
    else if (value == 2) {
         var  hrefval= "svindex.php?type=2&value=3";
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
    }
    else if (value == 3) {
         var  hrefval= "svindex.php?type=3&value=3";
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
    }
    else if (value == 4) {
          var  hrefval= "svindex.php?type=4&value=3";
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
    }
    else if (value == 5) {
          var  hrefval= "svindex.php?type=5&value=3";
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
    }
    else if (value == 6) {
          var  hrefval= "svindex.php?type=6&value=3";
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
    }
});
$('.typeoff-nav25').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
          var  hrefval= "svindex.php?type=1&value=5";
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
    }
    else if (value == 2) {
        var  hrefval= "svindex.php?type=2&value=5";
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
    }
    else if (value == 3) {
        var  hrefval= "svindex.php?type=3&value=5";
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
    }
    else if (value == 4) {
       var  hrefval= "svindex.php?type=4&value=5";
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
    }
    else if (value == 5) {
         var  hrefval= "svindex.php?type=5&value=5";
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
    }
    else if (value == 6) {
       var  hrefval= "svindex.php?type=6&value=5";
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
    }
});
});


function checkForAggregates()
{
	document.manda.hiddenbutton.value='Aggregate';
	document.manda.submit();
}
 function isNumberKey(evt)
          {
             var charCode = (evt.which) ? evt.which : event.keyCode

             if (((charCode > 47) && (charCode < 58 ) ) || (charCode == 8) || (charCode==46))
              {     return true;}
             else {  return false; }
          }
function isless()
//' do not submit if to < than from
           {

             var num1 = document.manda.txtmultipleReturnFrom.value;
             var num2 = document.manda.txtmultipleReturnTo.value;

             var x  = parseInt( num1  ,  10  )
             var y  = parseInt( num2  ,  10  )
             if(x > y)
                { 
                  alert("Please enter valid range");
                  return false;
                }

           }

</script>
<script type="text/javascript">
$(function(){
	$(".selectgroup select").multiselect();
});

</script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
</head>

<body> 
<?php 

require_once("../dbconnectvi.php");
$Db = new dbInvestments();

$drilldownflag = $_REQUEST['drilldownflag'];
$vcflagValue = $_REQUEST['vcflagValue'];
$type = $_REQUEST['type'];
$fixstart = $_REQUEST['fixstart'];
$startyear = $_REQUEST['startyear'];
$fixend = $_REQUEST['fixend'];
$endyear = $_REQUEST['endyear'];
$buttonClicked = $_REQUEST['buttonClicked'];
$keyword = $_REQUEST['keyword'];
$companysearch = $_REQUEST['companysearch'];
$sectorsearch = $_REQUEST['sectorsearch'];
$advisorsearchstring_legal = $_REQUEST['advisorsearchstring_legal']; 
$advisorsearchstring_trans = $_REQUEST['advisorsearchstring_trans'];
$searchallfield = $_REQUEST['searchallfield'];
$boolStage = $_REQUEST['boolStage'];
$companyType = $_REQUEST['companyType']; 
$companyTypeDisplay = $_REQUEST['companyTypeDisplay'];
$debt_equity = $_REQUEST['debt_equity'];
$regionId = $_REQUEST['regionId'];
$startRangeValue = $_REQUEST['startRangeValue'];
$endRangeValue = $_REQUEST['endRangeValue']; 
$endRangeValueDisplay = $_REQUEST['endRangeValueDisplay'];
$stagevaluetext = $_REQUEST['stagevaluetext'];
$debt_equity = $_REQUEST['debt_equity'];
$debt_equityDisplay = $_REQUEST['debt_equityDisplay'];

if($vcflagValue==0)
        {
            $addVCFlagqry = " and pec.industry !=15 ";
            $checkForStage = ' && ('.'$stage'.' =="--")';
            //$checkForStage = " && (" .'$stage'."=='--') ";
            $checkForStageValue = " || (" .'$stage'.">0) ";
            $searchTitle = "List of PE Investments ";
            $searchAggTitle = "Aggregate Data - PE Investments ";
            $aggsql= "select count(PEId) as totaldeals,sum(amount) as totalamount from peinvestments as pe,
            pecompanies as pec,industry as i where ";
            $samplexls="../Sample_Sheet_Investments.xls";
        }
        elseif($vcflagValue==1)
        {
            $addVCFlagqry = " and pec.industry!=15  and s.VCview=1 and pe.amount <=20 ";

            $checkForStage = '&& ('.'$stage'.'=="--") ';
            //$checkForStage = " && (" .'$stage'."=='--') ";
            $checkForStageValue =  " || (" .'$stage'.">0) ";
            $searchTitle = "List of VC Investments ";
            $searchAggTitle = "Aggregate Data - VC Investments ";
            $aggsql= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
            FROM peinvestments AS pe,pecompanies as pec,industry as i,stage as s  where pe.StageID=s.StageId and s.VCView=1 and  " ;
            $samplexls="Sample_Sheet_Investments(VC Deals).xls";
            //	echo "<br>Check for stage** - " .$checkForStage;
        }
           // print_r($_POST);
                        if(!$_POST){
                            //echo "not post";
				$yourquery=0;
				$stagevaluetext="";
				$industry=0;
                                //echo "<br>Query for all records";
                                 if($type==1)
                                { 
                                    $companysql = "SELECT YEAR( pe.dates ) , COUNT(distinct pe.PEId ) , SUM(distinct pe.amount ) 
                                                FROM peinvestments AS pe, industry AS i, pecompanies AS pec
                                                WHERE i.industryid = pec.industry
                                                AND pec.PEcompanyID = pe.PECompanyID
                                                AND pe.Deleted =0
                                                AND pe.AggHide =0
                                                AND pe.SPV =0
                                                and dates between '".$startyear."' and '".$endyear."'
                                                AND pe.PEId NOT 
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )
                                                GROUP BY YEAR( pe.dates )"  ;
                                   // echo  $companysql;
                                    
                                    $resultcompany= mysql_query($companysql);
                                }
                                elseif ($type==2) 
                                {
                                   $companysql = "SELECT i.industry,YEAR(pe.dates) , COUNT(distinct pe.PEId) , SUM(distinct pe.amount) 
					from peinvestments as pe, industry as i,pecompanies as pec where i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and  pe.Deleted = 0 AND pe.AggHide = 0 AND pe.SPV=0
						and  dates between '".$startyear."' and '".$endyear."'
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )
                                                GROUP BY i.industry,YEAR(pe.dates)";
                                 //echo  $companysql;
                                          
                                   $resultcompany= mysql_query($companysql);
                                }
                                elseif($type==3)
                                {
                                   $companysql = "SELECT s.Stage,YEAR(pe.dates) , COUNT(distinct pe.PEId) , SUM(distinct pe.amount) 
					from peinvestments as pe, industry as i,pecompanies as pec,stage as s where i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId = s.StageId and  pe.Deleted = 0 AND pe.AggHide = 0 AND pe.SPV=0
						and  dates between '".$startyear."' and '".$endyear."'
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )
                                                GROUP BY s.Stage,YEAR(pe.dates) ";   
                                   //echo  $companysql;
                                   $resultcompany= mysql_query($companysql);
                                }
                                
                                else if($type ==4)
                                {
                                    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200+");
                                    for($r=0;$r<count($range);$r++)
                                    {
                                        if($r == count($range)-1)
                                        {
                                            $companysql = "SELECT YEAR( pe.dates ) , COUNT(distinct pe.PEId ) , SUM(distinct pe.amount ) 
                                                            FROM peinvestments AS pe, industry AS i, pecompanies AS pec
                                                            WHERE i.industryid = pec.industry
                                                            AND pec.PEcompanyID = pe.PECompanyID and  (pe.amount > 200)
                                                            AND pe.Deleted =0 " .$addVCFlagqry. "
                                                            AND pe.AggHide =0
                                                            AND pe.SPV =0
                                                            and  dates between '".$startyear."' and '".$endyear."'
                                                            AND pe.PEId NOT 
                                                            IN (

                                                            SELECT PEId
                                                            FROM peinvestments_dbtypes AS db
                                                            WHERE hide_pevc_flag =1
                                                            )
                                                            GROUP BY YEAR( pe.dates )";
                                            //echo  $companysql;
                                             $resultcompany= mysql_query($companysql);
                                        }
                                        else
                                        {
                                            $limit=(string)$range[$r];
                                            $elimit=explode("-", $limit);
                                            
                                            $companysql = "SELECT YEAR( pe.dates ) , COUNT(distinct pe.PEId ) , SUM(distinct pe.amount ) 
                                                        FROM peinvestments AS pe, industry AS i, pecompanies AS pec
                                                        WHERE i.industryid = pec.industry
                                                        AND pec.PEcompanyID = pe.PECompanyID and  (pe.amount > ".$elimit[0]." and pe.amount<= ".$elimit[1].")
                                                        AND pe.Deleted =0" .$addVCFlagqry. "
                                                        AND pe.AggHide =0
                                                        AND pe.SPV =0
                                                        and  dates between '".$startyear."' and '".$endyear."'
                                                        AND pe.PEId NOT 
                                                        IN (

                                                        SELECT PEId
                                                        FROM peinvestments_dbtypes AS db
                                                        WHERE hide_pevc_flag =1
                                                        )
                                                        GROUP BY YEAR( pe.dates )";
                                           // echo  $companysql;
                                            $resultcompany= mysql_query($companysql);
                                        }
                                        if(mysql_num_rows($resultcompany)>0)
                                        {
                                            while ($rowrange = mysql_fetch_array($resultcompany))
                                            {
                                                $deal[$range[$r]][$rowrange[0]]['dealcount']=$rowrange[1];
                                                $deal[$range[$r]][$rowrange[0]]['sumamount']=$rowrange[2];   
                                            }
                                        }
                                        /*else
                                        {
                                            $deal='';
                                        }*/
                                     }
                                }
                                elseif($type==5)
                                {
                                    $companysql = "SELECT inv.InvestorTypeName,YEAR(pe.dates) , COUNT(distinct pe.PEId) , SUM(distinct pe.amount) 
					from peinvestments as pe, industry as i,pecompanies as pec,stage as s,investortype as inv where i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId = s.StageId and  pe.Deleted = 0 " .$addVCFlagqry. " AND pe.AggHide = 0 AND pe.SPV=0
						and pe.InvestorType=inv.InvestorType and  dates between '".$startyear."' and '".$endyear."'
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )
                                                GROUP BY inv.InvestorTypeName,YEAR(pe.dates) ";
                                   // echo  $companysql;
                                  $resultcompany= mysql_query($companysql);
                                }
                                elseif($type==6)
                                {
                                    $companysql  = "SELECT r.Region,YEAR(pe.dates) , COUNT(distinct pe.PEId) , SUM(distinct pe.amount) 
					from peinvestments as pe, industry as i,pecompanies as pec,stage as s,investortype as inv, region as r where i.industryid=pec.industry and
						pec.PEcompanyID = pe.PECompanyID and  r.RegionId=pec.RegionId and pe.StageId = s.StageId and  pe.Deleted = 0 " .$addVCFlagqry. " AND pe.AggHide = 0 AND pe.SPV=0
						and pe.InvestorType=inv.InvestorType and dates between '".$startyear."' and '".$endyear."'
                                                AND pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )
                                                GROUP BY r.Region,YEAR(pe.dates)";
                                    //echo  $companysql;
                                    //echo "<br>all records" .$companysql;
                                  $resultcompany= mysql_query($companysql);
                                }
			//	     echo "<br>all records" .$companysql;
			}
			else if($_POST)
                        {
                             // echo "post";
                              $dt1 =  $startyear;
                              $dt2 = $endyear;
                            if($type != 4)
                            {
                                if($keyword != "" && $keyword != " ")
                                {
                                        $keybef=", peinvestors as peinv, peinvestments_investors as p_inv";
                                }
                                 else if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                {
                                        $albef2=" ,advisor_cias as cia , peinvestments_advisorcompanies as adac";
					$albef=" ,advisor_cias as cia , peinvestments_advisorinvestors as adac";
                                }
                                if($type==1)
                                {
                                    if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select year(dates),count(distinct PEId),sum(distinct amount)from (";
                                             $companysql= $companyadd."select pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef." where";
                                            $companysql2 = "select pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef2." where";
                                    }
                                    else {
                                        $companysql = "select year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$keybef." where";
                                    }
                                }
                                else if($type==2)
                                {
                                    if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select industry, year(dates), count(distinct PEId), sum(distinct amount)from (";
                                             $companysql= $companyadd."select i.industry, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef." where pec.industry = i.industryid and "; 
                                             $companysql2 = "select i.industry, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef2." where pec.industry = i.industryid and "; 
                                    }
                                    else {
                                        $companysql = "select i.industry,year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$keybef." where pec.industry = i.industryid and "; 
                                    }
                                }
                                else if($type==3)
                                {
                                     if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select Stage, year(dates), count(distinct PEId), sum(distinct amount)from (";
                                             $companysql= $companyadd."select s.Stage, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef." where pe.StageId = s.StageId and "; 
                                             $companysql2 = "select s.Stage, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef2." where pe.StageId = s.StageId and "; 
                                    }
                                    else {
                                        $companysql = "select s.Stage,year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$keybef." where pe.StageId = s.StageId and "; 
                                    } 
                                }
                                else if($type==5)
                                {
                                     if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select InvestorTypeName, year(dates), count(distinct PEId), sum(distinct amount)from (";
                                             $companysql= $companyadd."select inv.InvestorTypeName, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,investortype as inv,pecompanies as pec,stage as s ".$albef." where pe.InvestorType = inv.InvestorType and "; 
                                             $companysql2 = "select inv.InvestorTypeName, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,investortype as inv,pecompanies as pec,stage as s ".$albef2." where pe.InvestorType = inv.InvestorType and "; 
                                    }
                                    else {
                                        $companysql = "select inv.InvestorTypeName,year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,investortype as inv,pecompanies as pec,stage as s ".$keybef." where pe.InvestorType = inv.InvestorType and "; 
                                    } 
                                }
                                else if($type==6)
                                {
                                     if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select Region, year(dates), count(distinct PEId), sum(distinct amount)from (";
                                             $companysql= $companyadd."select re.Region, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,investortype as inv,region as re,pecompanies as pec,stage as s ".$albef." where pec.RegionId=re.RegionId and"; 
                                             $companysql2 = "select re.Region, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,investortype as inv,region as re,pecompanies as pec,stage as s ".$albef2." where pec.RegionId=re.RegionId and"; 
                                    }
                                    else {
                                        $companysql = "select re.Region,year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,investortype as inv,region as re,pecompanies as pec,stage as s ".$keybef." where  pec.RegionId=re.RegionId and"; 
                                    } 
                               }
                            
				//echo "<br> individual where clauses have to be merged ";
					if ($industry > 0)
                                        {
                                                $whereind = " pec.industry=" .$industry ;
                                                $qryIndTitle="Industry - ";
                                        }
                                        if ($regionId > 0)
                                        {
                                                $qryRegionTitle="Region - ";
                                                $whereregion = " pec.RegionId  =".$regionId;
                                        }
                                        if($companyType != "--" && $companyType != "")
                                        {
                                          $wherelisting_status=" pe.listing_status='".$companyType."'";
                                        }
                                        if($debt_equity != "--" && $debt_equity != "")
                                        {  
                                            $whereSPVdebt=" pe.SPV=".$debt_equity; 
                                        }
                                        if ($invType != "--" && $invType != "")
                                        {
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pe.InvestorType = '".$invType."'";
                                        }
                                        if ($boolStage==true)
                                        {
                                                $stagevalue="";
                                                $stageidvalue="";
                                                foreach($stageval as $stage)
                                                {
                                                        //echo "<br>****----" .$stage;
                                                        $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                        $stageidvalue=$stageidvalue.",".$stage;
                                                }

                                                $wherestage = $stagevalue ;
                                                $qryDealTypeTitle="Stage  - ";
                                                $strlength=strlen($wherestage);
                                                $strlength=$strlength-3;
                                                //echo "<Br>----------------" .$wherestage;
                                                $wherestage= substr ($wherestage , 0,$strlength);
                                                $wherestage ="(".$wherestage.")";
                                                //echo "<br>---" .$stringto;

                                        }
                                       
                                //	echo "<br>Where stge---" .$wherestage;
                                        if (($startRangeValue!= "--") && ($endRangeValue != "--")  && ($startRangeValue!= "") && ($endRangeValue != "")  )
                                        {
                                                $startRangeValue=$startRangeValue;
                                                $endRangeValue=$endRangeValue-0.01;
                                                $qryRangeTitle="Deal Range (M$) - ";
                                                if($startRangeValue < $endRangeValue)
                                                {
                                                        $whererange = " pe.amount >  ".$startRangeValue ." and  pe.amount <= ". $endRangeValue ." and AggHide=0";
                                                }
                                                elseif(($startRangeValue = $endRangeValue) )
                                                {
                                                        $whererange = " pe.amount >= ".$startRangeValue ." and AggHide=0";
                                                }
                                        }
                                        else
                                        {
                                             $whererange ="";
                                        }
                                       
                                        //echo "<Br>***".$whererange;
                              
                                        if( ($dt1 != "")  && ($dt2 != ""))
                                        {
                                           $qryDateTitle ="Period - ";
                                           $wheredates= " (dates between '" . $dt1. "' and '" . $dt2 . "')";
                                        }
                                        if ($whereind != "")
                                        {
                                                $companysql=$companysql . $whereind ." and ";
                                                $aggsql=$aggsql . $whereind ." and ";
                                                $bool=true;
                                        }
                                        else
                                        {
                                                $bool=false;
                                        }
                                        if (($whereregion != "") )
                                        {
                                //		echo "<br>TRUE";
                                        $companysql=$companysql . $whereregion . " and " ;
                                                $aggsql=$aggsql . $whereregion ." and ";
                                //	echo "<br>----comp sql after region-- " .$companysql;
                                        $bool=true;
                                        }
                                        if (($wherestage != ""))
                                        {
                                        //	echo "<BR>--STAGE" ;
                                                $companysql=$companysql . $wherestage . " and " ;
                                                $aggsql=$aggsql . $wherestage ." and ";
                                                $bool=true;
                                        //	echo "<br>----comp sql after stage-- " .$companysql;

                                        }
                                        if($wherelisting_status!="")
                                        {
                                         $companysql=$companysql .$wherelisting_status . " and ";
                                        }
                                        if($whereSPVdebt!="")
                                        { $companysql=$companysql .$whereSPVdebt ." and "; }
                                        if (($whereInvType != "") )
                                        {
                                                $companysql=$companysql .$whereInvType . " and ";
                                                $aggsql = $aggsql . $whereInvType ." and ";
                                                $bool=true;
                                        }
                                        if (($whererange != "") )
                                        {
                                                $companysql=$companysql .$whererange . " and ";
                                                $aggsql=$aggsql .$whererange . " and ";
                                                $bool=true;
                                        }
                                       
                                         if($keyword != "")
                                        {
                                                $keyaft=" peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and peinv.investor LIKE '%$keyword%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        else if($companysearch != "")
                                        {

                                                $csaft=" pec.companyname LIKE '%$companysearch%'";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                       else if($sectorsearch != "")
                                        {
                                                $ssaft=" ( sector_business LIKE '%$sectorsearch%' )";
                                                 $companysql=$companysql . $ssaft. " and ";
                                        }
                                        else if($searchallfield!="")
                                        {
                                                $companysql.="( city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
							OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '$searchallfield%' ) AND";
                                        }
                                        if(($wheredates !== "") )
                                        {
                                                $companysql = $companysql ." pe.Deleted=0 AND pe.AggHide =0 AND pe.SPV =0 and pec.industry = i.industryid and
                                                pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                                                 " . $addVCFlagqry . "  AND ".$wheredates ." and ";
												 
						$companysql2 = $companysql2 ." pe.Deleted=0 AND pe.AggHide =0 AND pe.SPV =0 and pec.industry = i.industryid and
                                                pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                                                 " . $addVCFlagqry . "  AND ".$wheredates ." and ";
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                        if($advisorsearchstring_legal!="")
                                        {
                                                $alaft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_legal%' and AdvisorType='L'";
                                                $companysql=$companysql . $alaft . " and ";
						$companysql2=$companysql2 . $alaft . " and ";
                                        }
                                        else if($advisorsearchstring_trans!="")
                                        {
                                                $ataft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_trans%' and AdvisorType='T'";
                                                $companysql=$companysql . $ataft . " and ";
						$companysql2=$companysql2 . $ataft . " and ";
                                        }
                                        //the foll if was previously checked for range// pe.AggHide = 0 AND pe.SPV=0
                                        if($whererange  !="")
                                        {
                                                $companysql = $companysql . " pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )";
						$companysql2 = $companysql . " pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )";
                                        //	echo "<br>----" .$whererange;
                                        }
                                        elseif($whererange == "")
                                        {
                                                $companysql = $companysql . "
                                                 pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )";
						$companysql2 = $companysql2 . "
                                                pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE  hide_pevc_flag =1
                                                )";
                                        //	echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
                                        }
                                       
                                       
					if($advisorsearchstring_legal!="")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        if($advisorsearchstring_trans!="")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                         if($type == 1)
                                        {
                                            if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $searchtype=" group by year(dates)";
                                            }
                                            else {
                                                    $searchtype=" group by year(pe.dates)";
                                            }                                                                
                                      }
                                        if($type == 2)
                                        {
                                           if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $searchtype=" group by industry, year(dates)";
                                            }
                                            else {
                                                    $searchtype=" group by i.industry,year(pe.dates)";
                                            }
                                        }
                                        if($type == 3)
                                        {
                                            if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $searchtype=" group by Stage, year(dates)";
                                            }
                                            else {
                                                    $searchtype=" group by s.Stage, year(pe.dates)";
                                            }
                                          
                                        }
                                        if($type == 5)
                                        {
                                            if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $searchtype=" group by  InvestorTypeName, year(dates)";
                                            }
                                            else {
                                                    $searchtype=" group by inv.InvestorTypeName, year(pe.dates)";
                                            }
                                        }
                                        if($type == 6)
                                        {
                                            if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $searchtype=" group by Region, year(dates)";
                                            }
                                            else {
                                                    $searchtype=" group by re.Region, year(pe.dates)";
                                            }
                                        }
                                        if(($searchtype!== "") )
                                        {
                                                $companysql = $companysql .$searchtype;
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                   //echo $companysql;
                                         $resultcompany= mysql_query($companysql) or die(mysql_error());
                               }
                                                
                               else if($type == 4 && $_POST)
                                {
                                   
                                     if (($startRangeValue == "--") && ($endRangeValue == "--"))
                                       {
                                            $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200");
                                       }
                                       else if (($startRangeValue!= "--") && ($endRangeValue != "--"))
                                       {
                                            $startFlag=0;$endFlag=0;
                                            $arr_range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200");
                                            $range = array();
                                            foreach($arr_range as $value)
                                            {
                                                $arr_srange= spliti('-', $value);
                                                
                                                if($startFlag == 0 || $endFlag == 0)
                                                {
                                                    if(($arr_srange[0] >= $startRangeValue))
                                                    { 
                                                        if ($startFlag == 0){
                                                            $finalsrange = $startRangeValue;
                                                            $startFlag = 1;
                                                        }else{
                                                            $finalsrange = $arr_srange[0];
                                                        }
                                                    }
                                                    
                                                    
                                                    //echo $arr_srange[1];
                                                    if( $startFlag == 1)
                                                    {
                                                        if($endRangeValue >= $arr_srange[1])
                                                        {
                                                            if($endFlag == 0)
                                                            {
                                                                $finalerange = $arr_srange[1];
                                                                
                                                            }
                                                            else
                                                            {
                                                                 $finalerange = $endRangeValue;
                                                                 
                                                            }
                                                        }else{
                                                            $finalerange = $endRangeValue;
                                                            $endFlag=1;
                                                        }
                                                    }
                                                     //echo $finalsrange."-".$finalerange."</br>";
                                                    
                                                   if($finalsrange !='' && $finalerange!='')
                                                   {
                                                        $comserange="$finalsrange"."-"."$finalerange";
                                                        array_push($range, $comserange);
                                                   }
                                                }
                                            }
                                       }     
                                     //print_r($range);
                                   for($r=0;$r<count($range);$r++)
                                    {
                                          if($keyword != "" && $keyword != " ")
                                            {
                                                    $keybef=", peinvestors as peinv, peinvestments_investors as p_inv";
                                            }
                                          else if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $albef=" ,advisor_cias as cia , peinvestments_advisorinvestors as adac";
                                                    $albef2=" ,advisor_cias as cia , peinvestments_advisorcompanies as adac";
                                            }
                              
                                        if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                        {
                                                $companyadd = "select year(dates),count(distinct PEId),sum(distinct amount)from (";
                                                $companysql= $companyadd."select pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef." where";
                                                $companysql2 = "select pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef2." where";
                                        }
                                        else {
                                            $companysql = "select year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$keybef." where";
                                        }
                                        if ($industry > 0)
                                        {
                                                $whereind = " pec.industry=" .$industry ;
                                                $qryIndTitle="Industry - ";
                                        }
                                        if ($regionId > 0)
                                        {
                                                $qryRegionTitle="Region - ";
                                                $whereregion = " pec.RegionId  =".$regionId;
                                        }
                                        if($companyType != "--" && $companyType != "")
                                        {
                                          $wherelisting_status="pe.listing_status='".$companyType."'";
                                        }
                                        if($debt_equity != "--" && $debt_equity != "")
                                        {  
                                            $whereSPVdebt=" pe.SPV=".$debt_equity; 
                                        }
                                        if ($invType != "--" && $invType != "")
                                        {
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pe.InvestorType = '".$investorType."'";
                                        }
                                        if ($boolStage==true)
                                        {
                                                $stagevalue="";
                                                $stageidvalue="";
                                                foreach($stageval as $stage)
                                                {
                                                        //echo "<br>****----" .$stage;
                                                        $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                        $stageidvalue=$stageidvalue.",".$stage;
                                                }

                                                $wherestage = $stagevalue ;
                                                $qryDealTypeTitle="Stage  - ";
                                                $strlength=strlen($wherestage);
                                                $strlength=$strlength-3;
                                                //echo "<Br>----------------" .$wherestage;
                                                $wherestage= substr ($wherestage , 0,$strlength);
                                                $wherestage ="(".$wherestage.")";
                                                //echo "<br>---" .$stringto;

                                        }
                                        $limit=(string)$range[$r];
                                        $elimit=explode("-", $limit);
                                        if( $elimit[0] !='' && $elimit[1] !='' && $elimit[0] != $elimit[1])
                                        {
                                           $whererange = " pe.amount >  ".$elimit[0] ." and pe.amount <= ". $elimit[1] ." "; 
                                        }
                                        else if($elimit[0] >= 200 || $elimit[1] >= 200)
                                        {
                                            $whererange = " pe.amount > 200";
                                        }
                                        else
                                        {
                                             $whererange="";
                                        }

                              
                                        if( ($dt1 != "")  && ($dt2 != ""))
                                        {
                                            $qryDateTitle ="Period - ";
                                            if($type == 4)
                                            {
                                                $wheredates= "  dates between '" . $dt1. "' and '" . $dt2 . "'";
                                               
                                            }
                                        }
                                        if ($whereind != "")
                                        {
                                                $companysql=$companysql . $whereind ." and ";
                                                $aggsql=$aggsql . $whereind ." and ";
                                                $bool=true;
                                        }
                                        else
                                        {
                                                $bool=false;
                                        }
                                        if (($whereregion != "") )
                                        {
                                //		echo "<br>TRUE";
                                        $companysql=$companysql . $whereregion . " and " ;
                                                $aggsql=$aggsql . $whereregion ." and ";
                                //	echo "<br>----comp sql after region-- " .$companysql;
                                        $bool=true;
                                        }
                                        if (($wherestage != ""))
                                        {
                                        //	echo "<BR>--STAGE" ;
                                                $companysql=$companysql . $wherestage . " and " ;
                                                $aggsql=$aggsql . $wherestage ." and ";
                                                $bool=true;
                                        //	echo "<br>----comp sql after stage-- " .$companysql;

                                        }
                                        if($wherelisting_status!="")
                                        {
                                         $companysql=$companysql .$wherelisting_status . " and ";
                                        }
                                        if($whereSPVdebt!="")
                                        { $companysql=$companysql .$whereSPVdebt ." and "; }
                                        if (($whereInvType != "") )
                                        {
                                                $companysql=$companysql .$whereInvType . " and ";
                                                $aggsql = $aggsql . $whereInvType ." and ";
                                                $bool=true;
                                        }
                                        if (($whererange != "") )
                                        {
                                                $companysql=$companysql .$whererange . " and ";
												$companysql2=$companysql2 .$whererange . " and ";
                                                $aggsql=$aggsql .$whererange . " and ";
                                                $bool=true;
                                        }
                                         if($keyword != "" && $keyword != " ")
                                        {
                                                $keyaft=" peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and peinv.investor LIKE '%$keyword%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        else if($companysearch != "" && $companysearch != " ")
                                        {

                                                $csaft=" pec.companyname LIKE '%$companysearch%'";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                        else if($sectorsearch != "")
                                        {
                                                $ssaft=" ( sector_business LIKE '%$sectorsearch%' )";
                                                 $companysql=$companysql . $ssaft. " and ";
                                        }
										else if($advisorsearchstring_legal!="" && $advisorsearchstring_legal!=" ")
                                        {
                                                $alaft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_legal%' and AdvisorType='L'";
                                                $companysql=$companysql . $alaft . " and ";
												$companysql2=$companysql2 . $alaft . " and ";
                                        }
                                        else if($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" ")
                                        {
                                                $ataft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_trans%' and AdvisorType='T'";
                                                $companysql=$companysql . $ataft . " and ";
												$companysql2=$companysql2 . $ataft . " and ";
                                        }
                                        else if($searchallfield!="")
                                        {
                                                $companysql.="( city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
							OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '$searchallfield%' ) AND";
                                        }
                                        //the foll if was previously checked for range
                                      
                                        if(($wheredates != "") )
                                        {
                                                $companysql = $companysql ." i.industryid=pec.industry and
                                                pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and
                                                pe.Deleted=0 " . $addVCFlagqry . "  AND ".$wheredates ." and ";
                                                $aggsql = $aggsql . $wheredates ." and  ";
												
						$companysql2 = $companysql2 ." i.industryid=pec.industry and
                                                pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and
                                                pe.Deleted=0 " . $addVCFlagqry . "  AND ".$wheredates ." and ";
                                                $aggsql = $aggsql . $wheredates ." and  ";
                                                $bool=true;
                                        }
                                        //the foll if was previously checked for range
                                        if($whererange  !="")
                                        {
                                                $companysql = $companysql . " pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )";
						$companysql2 = $companysql2 . " pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )";
                                        //	echo "<br>----" .$whererange;
                                        }
                                        elseif($whererange == "")
                                        {
                                                $companysql = $companysql . " pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )";
						$companysql2 = $companysql2 . " pe.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE hide_pevc_flag =1
                                                )";
                                        //	echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
                                        }
                                       
                                        if($advisorsearchstring_legal!="" && $advisorsearchstring_legal!=" ")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
					if($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" ")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        if($type == 4)
                                        {
                                            if(($advisorsearchstring_legal!="" && $advisorsearchstring_legal!=" ") || ($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" "))
                                            {
                                                    $searchtype=" group by year(dates)";
                                            }
                                            else {
                                                    $searchtype=" group by year(pe.dates)";
                                            }
                                        }
                                         if(($searchtype!== "") )
                                        {
                                                $companysql = $companysql .$searchtype;
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                        // echo "<br><br>".$companysql;
                                              $resultcompany= mysql_query($companysql) or die(mysql_error());
                                        
                                        if(mysql_num_rows($resultcompany)>0)
                                        {
                                            while ($rowrange = mysql_fetch_array($resultcompany))
                                            {
                                                $deal[$range[$r]][$rowrange[0]]['dealcount']=$rowrange[1];
                                                $deal[$range[$r]][$rowrange[0]]['sumamount']=$rowrange[2];   
                                            }
                                        }
                                     }
                                }
                               
		}
			
			
				else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}
	//}
	//END OF POST
	
	
	
	$companyId=632270771;
	$compId=0;
	$currentyear = date("Y");
	
	$TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
		where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
	
	if($trialrs=mysql_query($TrialSql))
	{
		while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
		{
			$exportToExcel=$trialrow["TrialLogin"];
			$compId=$trialrow["compid"];

		}
	}
	
   if($compId==$companyId){ 
   		$hideIndustry = " and display_in_page=1 "; 
	} else { 
		$hideIndustry=""; 
	}
	
	
	/*$getTotalQuery="SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
	FROM peinvestments AS pe, pecompanies AS pec
	WHERE pe.Deleted =0  and pe.PECompanyId=pec.PECompanyId
	AND pec.industry !=15 and pe.AggHide=0 and
				pe.PEId NOT
						IN (
						SELECT PEId
						FROM peinvestments_dbtypes AS db
						WHERE DBTypeId ='SV'
						AND hide_pevc_flag =1
						)";
	$pagetitle="PE Investments -> Search";
	$stagesql = "select StageId,Stage from stage ";*/
	
	//INDUSTRY
	$industrysql="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";
	
	//Company Sector
	$searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
	
	$addVCFlagqry="";
	$pagetitle="PE-backed Companies";

	$getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
					FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
					WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
					AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
					AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
	ORDER BY pec.companyname";
	
	//Stage
	$stagesql = "select StageId,Stage from stage ";
	

?>
<div>
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
 <?php

				$exportToExcel=0;
			 $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
										where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";
			//echo "<br>---" .$TrialSql;
			if($trialrs=mysql_query($TrialSql))
			{
				while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
				{
					$exportToExcel=$trialrow["TrialLogin"];
					$studentOption=$trialrow["Student"];
				}
			}

			if($yourquery==1)
				$queryDisplayTitle="Query:";
			elseif($yourquery==0)
				$queryDisplayTitle="";
                        if(trim($buttonClicked==""))
                        {
		           ?>


<td>
<div class="result-cnt">		
                       
    <?php
if($vcflagValue==0)
{
?>
<div id="sec-header">
 <table cellpadding="0" cellspacing="0">
 <tr>
<td>
<h3>Types</h3>
<label><input class="typeoff-nav2" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav2" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
<label><input class="typeoff-nav2" name="typeoff" type="radio"  value="3" <?php if($type==3) { ?> checked="checked" <?php } ?>/>Stage</label>
<label><input class="typeoff-nav2" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav2" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
<label><input class="typeoff-nav2" name="typeoff" type="radio" value="6" <?php if($type==6) { ?> checked="checked" <?php } ?>/>Region</label>

</td></tr>
</table>
</div>
<?php
}
else if($vcflagValue==1)
{
?>
<div id="sec-header">
 <table cellpadding="0" cellspacing="0">
 <tr>
<td>
<h3>Types</h3>
<label><input class="typeoff-nav21" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav21" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
<label><input class="typeoff-nav21" name="typeoff" type="radio"  value="3" <?php if($type==3) { ?> checked="checked" <?php } ?>/>Stage</label>
<label><input class="typeoff-nav21" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav21" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
<label><input class="typeoff-nav21" name="typeoff" type="radio" value="6" <?php if($type==6) { ?> checked="checked" <?php } ?>/>Region</label>

</td></tr>
</table>
</div>
<?php     
}
?>
 <div class="profile-view-title"> 
 <?php 
 if($type==1 && $vcflagValue==0)
 {
 ?>
    <h2>PE - Year on Year</h2>
<?php
 }
 elseif($type==2 && $vcflagValue==0)
 {
     ?>
     <h2>PE - By Industry</h2>
 <?php
 }
  elseif($type==3  && $vcflagValue==0)
 {
     ?>
     <h2>PE - By Stage</h2>
 <?php
 }
  elseif($type==4  && $vcflagValue==0)
 {
     ?>
     <h2>PE - By Range</h2>
 <?php
 }
  elseif($type==5  && $vcflagValue==0)
 {
     ?>
     <h2>PE - By Investor</h2>
 <?php
 } elseif($type==6  && $vcflagValue==0)
 {
     ?>
     <h2>PE - By Region</h2>
 <?php
 }
 else  if($type==1 && $vcflagValue==1)
 {
 ?>
    <h2>VC - Year on Year</h2>
<?php
 }
 elseif($type==2 && $vcflagValue==1)
 {
     ?>
     <h2>VC - By Industry</h2>
 <?php
 }
  elseif($type==3  && $vcflagValue==1)
 {
     ?>
     <h2>VC - By Stage</h2>
 <?php
 }
  elseif($type==4  && $vcflagValue==1)
 {
     ?>
     <h2>VC - By Range</h2>
 <?php
 }
  elseif($type==5  && $vcflagValue==1)
 {
     ?>
     <h2>VC - By Investor</h2>
 <?php
 } elseif($type==6  && $vcflagValue==1)
 {
     ?>
     <h2>VC - By Region</h2>
 <?php
 }
 ?>
 </div><br>
    <!--div class="result-title">
                                            
                            <?php if($_POST)
                               {
                              ?>
                            <ul>
                                <?php
                                 //echo $queryDisplayTitle;
                                if($industry >0 && $industry != "--"){ ?>
                                <li>
                                    <?php echo $industryvalue; ?> <a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($stagevaluetext!="" && $stagevaluetext!=null) { ?>
                                <li> 
                                    <?php echo $stagevaluetext ?> <a  onclick="resetinput('stage');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companyType!="--" && $companyType!=null){ ?>
                                <li> 
                                    <?php echo $companyTypeDisplay; ?> <a  onclick="resetinput('comptype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($invType !="--" && $invType!=null){ ?>
                                <li> 
                                    <?php echo $invtypevalue; ?> <a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                if($regionId>0){ ?>
                                <li> 
                                    <?php echo $regionvalue; ?> <a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  
                                if (($startRangeValue!= "--") && ($endRangeValue != "")){ ?>
                                <li> 
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?> <a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($debt_equity!="--" && $debt_equity!=null) { ?>
                                <li> 
                                    <?php echo  $debt_equityDisplay;?> <a  onclick="resetinput('dealtype_debtequity');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($keyword!="") { ?>
                                <li> 
                                    <?php echo $keyword;?> <a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($companysearch!=""){ ?>
                                <li> 
                                    <?php echo $companysearch?> <a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($sectorsearch!=""){ ?>
                                <li> 
                                    <?php echo  $sectorsearch?> <a  onclick="resetinput('sectorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearchstring_legal!="") { ?>
                                <li> 
                                    <?php echo $advisorsearchstring_legal?> <a  onclick="resetinput('advisorsearch_legal');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($advisorsearchstring_trans!=""){ ?>
                                <li> 
                                    <?php echo $advisorsearchstring_trans?> <a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }  if($searchallfield!=""){ ?>
                                <li> 
                                    <?php echo $searchallfield?> <a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php }
                                if($year2 !="" && $year1 != ""){ ?>
                                <li> 
                                    <?php echo $year1. "-" .$year2;?> <a  onclick="resetinput('year1,year2');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                ?>
                             </ul>
                             <?php } ?>
    </div-->
<table cellpadding="0" cellspacing="0" width="100%">
 <?php
 if($type==2)
{
    if(mysql_num_rows($resultcompany)>0)
    {
        while($rowindus = mysql_fetch_array($resultcompany))	
        {  
           $deal[$rowindus['industry']][$rowindus[1]]['dealcount']=$rowindus[2];
           $deal[$rowindus['industry']][$rowindus[1]]['sumamount']=$rowindus[3];  
        }  
    }
    else
    {
        $deal='';
    }
}
elseif($type==3)
{
    if(mysql_num_rows($resultcompany)>0)
    {
       while($rowstage = mysql_fetch_array($resultcompany))	
       {  
          $deal[$rowstage['Stage']][$rowstage[1]]['dealcount']=$rowstage[2];
          $deal[$rowstage['Stage']][$rowstage[1]]['sumamount']=$rowstage[3];  
       }
    }
    else
    {
        $deal='';
    }
}
else if($type==5)
{
    if(mysql_num_rows($resultcompany)>0)
    {
       while($rowinvestor = mysql_fetch_array($resultcompany))	
       {  
          $deal[$rowinvestor['InvestorTypeName']][$rowinvestor[1]]['dealcount']=$rowinvestor[2];
          $deal[$rowinvestor['InvestorTypeName']][$rowinvestor[1]]['sumamount']=$rowinvestor[3];  
       }
     }
    else
    {
        $deal='';
    }
}
else if($type==6)
{
    if(mysql_num_rows($resultcompany)>0)
    {
       while($rowregion = mysql_fetch_array($resultcompany))	
       {  
          $deal[$rowregion['Region']][$rowregion[1]]['dealcount']=$rowregion[2];
          $deal[$rowregion['Region']][$rowregion[1]]['sumamount']=$rowregion[3];  
       }
    }
    else
    {
        $deal='';
    }
}
?>
 </div>          		

</form>
   <?php
    if($type==1 && $vcflagValue==0)
    { ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization2").offsetWidth;
  
  divheight=  document.getElementById("visualization2").offsetHight;
  
        // Create and populate the data table.
          var data = google.visualization.arrayToDataTable([
            ['Year', 'No of Deals', 'Amount($m)']
            <?php   mysql_data_seek($resultcompany, 0);
            while($rowsyear = mysql_fetch_array($resultcompany))	
        { ?>
            ,['<?php echo $rowsyear[0]; ?>',  <?php echo $rowsyear[1]; ?>,  <?php echo $rowsyear[2]; ?>]
        <?php }?>
          ]);
          
          // Create and draw the visualization.
          var chart = new google.visualization.LineChart(document.getElementById('visualization2'));
                   function selectHandler() {
             
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=0&y='+topping;
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
        google.visualization.events.addListener(chart, 'select', selectHandler);
             chart.draw(data,
                   {
                    title:"<?php echo $charttitle ?>",
                    width:divwidth, height:400,
                    hAxis: {title: "Year"},
                     vAxes: {
                            0: {
                                title: 'No of Deals',
                            },
                            1: {
                                title: 'Amount'
                            }
                        },
                    colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  }
              );
              //$('#slidingTable').hide();
			  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
        
    }
    else if($type==1 && $vcflagValue==1)
    { ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization2").offsetWidth;
  
  divheight=  document.getElementById("visualization2").offsetHight;
  
        // Create and populate the data table.
          var data = google.visualization.arrayToDataTable([
            ['Year', 'No of Deals', 'Amount($m)']
            <?php   mysql_data_seek($resultcompany, 0);
            while($rowsyear = mysql_fetch_array($resultcompany))	
        { ?>
            ,['<?php echo $rowsyear[0]; ?>',  <?php echo $rowsyear[1]; ?>,  <?php echo $rowsyear[2]; ?>]
        <?php }?>
          ]);
          
          // Create and draw the visualization.
          var chart = new google.visualization.LineChart(document.getElementById('visualization2'));
                   function selectHandler() {
             
          var selectedItem = chart.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var query_string = 'value=1&y='+topping;
             <?php if($drilldownflag==1){ ?>
             window.location.href = 'index.php?'+query_string;
            <?php } ?>
          }
        }
        google.visualization.events.addListener(chart, 'select', selectHandler);
             chart.draw(data,
                   {
                    title:"<?php echo $charttitle ?>",
                    width:divwidth, height:400,
                    hAxis: {title: "Year"},
                     vAxes: {
                            0: {
                                title: 'No of Deals',
                            },
                            1: {
                                title: 'Amount'
                            }
                        },
                    colors: ["#FCCB05","#a2753a"],
                    series: {
                                0: {targetAxisIndex: 0},
                                1: {targetAxisIndex: 1,type : "bars",curveType: "function"}
                            }
                  }
              );
              //$('#slidingTable').hide();
			  <?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>
      <?php
        
    }
    else if($type==2 && $vcflagValue==0)
    {
      //  print_r($deal);
        ?>
    
     <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                         for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);
         var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart1.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var industry = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
            <?php if($drilldownflag==1){ ?>
             window.location.href = 'index.php?'+query_string;
            <?php } ?>
          }
        }

        google.visualization.events.addListener(chart1, 'select', selectHandler);
          chart1.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                 colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart2.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var industry = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=0&y='+topping+'&i='+encodeURIComponent(industry);
            <?php if($drilldownflag==1){ ?>
             window.location.href = 'index.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart2, 'select', selectHandler2);
          chart2.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                 colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
       colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
       colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      
      google.setOnLoadCallback(drawVisualization);
    </script>
    
       
    <? 
     }
    else if($type==2 && $vcflagValue==1)
    {
        ?>
    
     <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                         for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);
         var chart1 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart1.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var industry = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=1&y='+topping+'&i='+encodeURIComponent(industry);
             <?php if($drilldownflag==1){ ?>
             window.location.href = 'index.php?'+query_string;
            <?php } ?>
          }
        }

        google.visualization.events.addListener(chart1, 'select', selectHandler);
          chart1.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                 colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $industry => $values)
                      { 
                          echo ",'".$industry."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $industry => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart2= new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart2.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var industry = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
            var query_string = 'value=1&y='+topping+'&i='+encodeURIComponent(industry);
             <?php if($drilldownflag==1){ ?>
             window.location.href = 'index.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart2, 'select', selectHandler2);
          chart2.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                 colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
       colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $industry => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$industry."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
       colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
        //$('#slidingTable').hide();
		<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      
      google.setOnLoadCallback(drawVisualization);
    </script>
    
       
    <? 
     }
    else if($type==3 && $vcflagValue==0)
    {
        ?>
    
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $Stage => $values)
                      { 
                          echo ",'".$Stage."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $Stage => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
        var chart4 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart4.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var stage = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
              <?php if($drilldownflag==1){ ?>
             window.location.href = 'index.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart4, 'select', selectHandler);
         chart4. draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $Stage => $values)
                      { 
                          echo ",'".$Stage."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $Stage => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart5 = new google.visualization.ColumnChart(document.getElementById('visualization'));
           function selectHandler2() {
          var selectedItem = chart5.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var stage = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&s='+encodeURIComponent(stage);
             <?php if($drilldownflag==1){ ?>
             window.location.href = 'index.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart5, 'select', selectHandler2);
         chart5.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Amount"},
               colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $Stage => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$Stage."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $Stage=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$Stage."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
      chart.draw(data4, {title:"Amount",colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      google.visualization.events.addListener(chart, 'select', function() {
    var selection = chart.getSelection();
    console.log(selection);  
});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>    
    
       
    <? 
     }
      else if($type==3 && $vcflagValue==1)
    {
        ?>
    
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $Stage => $values)
                      { 
                          echo ",'".$Stage."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $Stage => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
        var chart4 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
         function selectHandler() {
          var selectedItem = chart4.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var stage = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1&y='+topping+'&s='+encodeURIComponent(stage);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart4, 'select', selectHandler);
         chart4. draw(data1,
               {
                title:"By Stage - Deal",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $Stage => $values)
                      { 
                          echo ",'".$Stage."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $Stage => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart5 = new google.visualization.ColumnChart(document.getElementById('visualization'));
           function selectHandler2() {
          var selectedItem = chart5.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var stage = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1&y='+topping+'&s='+encodeURIComponent(stage);
             <?php if($drilldownflag==1){ ?>
             window.location.href = 'index.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart5, 'select', selectHandler2);
         chart5.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
               colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $Stage => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$Stage."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deal",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $Stage=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$Stage."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  var chart=new google.visualization.PieChart(document.getElementById('visualization3'));
      chart.draw(data4, {title:"Amount",colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      google.visualization.events.addListener(chart, 'select', function() {
    var selection = chart.getSelection();
    console.log(selection);  
});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>    
    
       
    <? 
     }
    else if($type == 4 && $vcflagValue==0 &&  !$_POST)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <? 
     }
    else if($type == 4 && $vcflagValue==1 &&  !$_POST)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <? 
     }
    else if($type==5 && $vcflagValue==0)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $InvestorTypeName => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"By Deal",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $InvestorTypeName=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>  
    
       
    <? 
     }
     else if($type==5 && $vcflagValue==1)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart8=new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart8.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var invtype = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart8, 'select', selectHandler);
         chart8.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $InvestorTypeName => $values)
                      { 
                          echo ",'".$InvestorTypeName."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $InvestorTypeName => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart9=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart9.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var invtype = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1&y='+topping+'&inv='+encodeURIComponent(invtype);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart9, 'select', selectHandler2);
          chart9.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $InvestorTypeName => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $InvestorTypeName=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$InvestorTypeName."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script>  
    
       
    <? 
     }
    else if($type==6 && $vcflagValue==0)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $region  => $values)
                      { 
                          echo ",'".$region."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $region => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         chart11= new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart11.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var reg = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $region  => $values)
                      { 
                          echo ",'".$region."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $region => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart12=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart12.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var reg = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=0&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $region  => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$region."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $region => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$region."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <? 
     }
    else if($type==6 && $vcflagValue==1)
    {
        ?>
    
      <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $region  => $values)
                      { 
                          echo ",'".$region."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $region => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         chart11= new google.visualization.ColumnChart(document.getElementById('visualization1'));
          function selectHandler() {
          var selectedItem = chart11.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var reg = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=1&y='+topping+'&reg='+encodeURIComponent(reg);
              <?php if($drilldownflag==1){ ?>
             window.location.href = 'index.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart11, 'select', selectHandler);
          chart11.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $region  => $values)
                      { 
                          echo ",'".$region."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $region => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart12=new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart12.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var reg = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           if(reg == '')
            {
                reg='empty';
            }
            else
            {
                   reg;
            }
           var query_string = 'value=1&y='+topping+'&reg='+encodeURIComponent(reg);
             <?php if($drilldownflag==1){ ?>
             window.location.href = 'index.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart12, 'select', selectHandler2);
         chart12.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $region  => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$region."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"By Deal",colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $region => $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$region."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
       
    <? 
     }
    if($type == 4 && $vcflagValue==0 && $_POST)
    {
        ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
            <?php if($drilldownflag==1){ ?>
             window.location.href = 'index.php?'+query_string;
            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=0&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
     colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
    <? 
    }
    else if($type == 4 && $vcflagValue==1 && $_POST)
    {
        ?>
    <script type="text/javascript">
      function drawVisualization() {
          
  divwidth=  document.getElementById("visualization").offsetWidth;
  
  divheight=  document.getElementById("visualization").offsetHight;
        // Create and populate the data table.
       
          var data1 = google.visualization.arrayToDataTable([
            ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
          var chart6 = new google.visualization.ColumnChart(document.getElementById('visualization1'));
           function selectHandler() {
          var selectedItem = chart6.getSelection()[0];
          if (selectedItem) {
            var topping = data1.getValue(selectedItem.row, 0);
            var range = data1.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart6, 'select', selectHandler);
          chart6.draw(data1,
               {
                title:"No of Deals",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "No of Deals"},
               colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );
          
           var data = google.visualization.arrayToDataTable([
           ['Year'<?php foreach($deal as $range => $values)
                      { 
                          echo ",'".$range."'";
                       }?>],
                       <?php
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                        ?>   ["<?php echo $i; ?>"
                             <?php foreach($deal as $range => $values)
                            {?>,<?php echo ($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                            }?>],
                           <?php 
                             }
                        ?> ]);  
         var chart7 =  new google.visualization.ColumnChart(document.getElementById('visualization'));
          function selectHandler2() {
          var selectedItem = chart7.getSelection()[0];
          if (selectedItem) {
            var topping = data.getValue(selectedItem.row, 0);
            var range = data.getColumnLabel(selectedItem.column).toString();
            //alert('The user selected ' + topping +industry);
           
           var query_string = 'value=1&y='+topping+'&rg='+encodeURIComponent(range);
             <?php if($drilldownflag==1){ ?>             window.location.href = 'index.php?'+query_string;            <?php } ?>
          }
        }
         google.visualization.events.addListener(chart7, 'select', selectHandler2);
          chart7.draw(data,
               {
                title:"Amount",
                width:500, height:700,
                hAxis: {title: "Year"},
                vAxis: {title: "Amount"},
                colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"],
                isStacked : true
              }
          );   
          
   var data3 = google.visualization.arrayToDataTable([
      ['Industry','deal'],
          <?php 
        
              foreach($deal as $range => $values)
              { 
                    $sumdeal=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realdeal=($values[$i]['dealcount']!="")?$values[$i]['dealcount']:0;
                                     $sumdeal=$sumdeal+$realdeal;
                                    
                        }
                            echo $sumdeal;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization2')).
      draw(data3, {title:"No of Deals",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
      
       var data4 = google.visualization.arrayToDataTable([
      ['Industry','Amount'],
          <?php 
        
              foreach($deal as $range=> $values)
              { 
                    $sumamount=0;
              ?>  [ <?php echo "'".$range."'".",";
                       for($i=$fixstart;$i<=$fixend;$i++)
                        {
                            ?><?php $realamount=($values[$i]['sumamount']!="")?$values[$i]['sumamount']:0;
                                     $sumamount=$sumamount+$realamount;
                                    
                        }
                            echo $sumamount;?>],
                           <?php 
                             }
                        ?>
  ]);

  // Create and draw the visualization.
  new google.visualization.PieChart(document.getElementById('visualization3')).
      draw(data4, {title:"Amount",
      colors: ["#2D140F","#472D1E","#3D2111","#5E402D","#793C25","#6E5034","#925130","#905D40","#A56033","#A16B47","#9E6831","#B47748","#CB9460","#AA7A46",
"#D1A787","#DEA66E","#E7D0B9","#DCB292","#E7DCD3","#ECDAC8","#F0E7DF"]});
//$('#slidingTable').hide();
<?php echo ($_GET['type']=='') ? "$('#slidingTable').hide();" : ""; ?>
      }
      google.setOnLoadCallback(drawVisualization);
    </script> 
    
    <? 
    }
    ?>
<?php
if($type!=1)
{
 ?>
<tr>
<td width="50%" class="profile-view-left">
 <div id="visualization2" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>   
</td>
<td class="profile-view-rigth" width="50%" >
  <div id="visualization3" style="max-width: 100%; height: 500px;overflow-x: auto;overflow-y: hidden;"></div>  
</td>
</tr> 

<tr>
<td width="50%" class="profile-view-left" id="chartbar">
    <div id="visualization1" style="max-width: 100%; height: 750px;overflow-x: auto;overflow-y: hidden;"></div>    
</td>
<td  id="chartbar" class="profile-view-rigth" width="50%" >
    <div id="visualization" style="max-width: 100%; height: 700px;overflow-x: auto;overflow-y: hidden;"></div> 
</td>
</tr>
<?php
}
else
{
?>
<tr>
    <td colspan="2" width="100%">
<div id="visualization2" style="max-width: 100%; height: 600px;overflow-x: auto;overflow-y: hidden;"></div>   
</td>
</tr> 
<?php
}
?>
<tr>
     <td class="profile-view-left" colspan="2">
  <div class="showhide-link link-expand-table"><a href="#" class="show_hide" rel="#slidingDataTable">View Table</a></div>
  

 <div class="view-table expand-table" id="slidingDataTable" style="display:none; overflow:hidden;">
     <div class="restable" >
         <table class="responsive" cellpadding="0" cellspacing="0" >
<thead>
   
    <?php
    if($type==1)
    {
        ?>
    
        <tr><th colspan="1" style="text-align:center">Year</th>
            <th colspan="1" style="text-align:center">No. of Deals</th>
            <th colspan="1" style="text-align:center">Amount($m)</th>
        </tr>
<?php
    }
    elseif($type==2)
    {
    ?>

   
    <tr><th rowspan="2"  style="text-align:center">Industry</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
            if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
  <?php   
    }
    elseif($type==3)
    {
        ?>
  <tr><th rowspan="2"  style="text-align:center">Stage</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                 if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        ?>
    </tr>
    <?php
    }
    else if($type==5)
    {
        ?>
   
       <tr><th rowspan="2"  style="text-align:center">Investor</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
           echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
   <?php     
    }
    else if($type==4)
    {
        ?>
        <tr><th rowspan="2"  style="text-align:center">Range</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        ?>
    </tr>
    <?php
    }
    else if($type==6)
    {
        ?>
    <tr><th rowspan="2"  style="text-align:center">Region</th>
        <?php 
        for($i=$fixstart;$i<=$fixend;$i++)
        {
             echo" <th colspan=\"2\" style=\"text-align:center\">".$i."</th>";
        }
        
        ?>
    </tr>
    <tr>
         <?php 
         $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
                if($i==$da)
                {
                    echo"<th colspan=\"2\" style=\"text-align:left\">&nbsp; </th>";
                }
                else   
                    echo"<th class=\"deal-th\">Deal </th><th style=\"text-align:left\">Amount</th>";
        }
        
        ?>
    </tr>
   <?php
    }
    ?></thead>

     <tbody>
      <?php
    if($type==1)
    {
        if(mysql_num_rows($resultcompany)>0)
        {    
            mysql_data_seek($resultcompany, 0);
            while($rowsyear = mysql_fetch_array($resultcompany))	
            {
                    echo "<tr style=\"text-align:center;\">
                    <td>".$rowsyear[0]."</td>
                    <td>".$rowsyear[1]."</td>
                    <td>".$rowsyear[2]."</td>
                    </tr>";		                                                                           
            }
        }
        else
        {
             echo "<tr style=\"text-align:center;\">
                    No Data Found
                    </tr>";
        }
    }
    else if($type==2)
    {
         if($deal !='')
        {
            $content ='';

            foreach($deal as $industry => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$industry.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 
            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    else if($type==3)
    {
        if($deal !='')
        {
            $content ='';

            foreach($deal as $Stage => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$Stage.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 
            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    else if($type == 4 &&  !$_POST)
    {
        if($deal!='')
        {
            $content ='';
            foreach($deal as $range => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$range.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 

            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    else if($type==5)
    {
        if($deal !='')
        {
            $content ='';

           foreach($deal as $InvestorTypeName => $values){
               $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
               $content .= '<td>'.$InvestorTypeName.'</td>';
                for($i=$fixstart;$i<=$fixend;$i++){
                    $content .= "<td>".$values[$i]['dealcount']."</td>";
                    $content .= "<td>".$values[$i]['sumamount']."</td>";
                }
                $content.= '</tr>';
           } 

           echo $content; 
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    else if($type==6)
    {
        if($deal !='')
        {
            $content ='';

            foreach($deal as $region => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$region.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 

            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    if($type == 4 && $_POST)
    {
        if($deal!='')
        {
            $content ='';

            foreach($deal as $range => $values){
                $content .= '<tr style=\"\&quot;text-align:center;\&quot;\">';
                $content .= '<td>'.$range.'</td>';
                 for($i=$fixstart;$i<=$fixend;$i++){
                     $content .= "<td>".$values[$i]['dealcount']."</td>";
                     $content .= "<td>".$values[$i]['sumamount']."</td>";
                 }
                 $content.= '</tr>';
            } 

            echo $content;
        }
        else
        {
            $content ='';
            $content = '<tr style=\"\&quot;text-align:center;\&quot;\">No Data Found</tr>';
            echo $content;
        }
    }
    ?>
    </tbody>
 </table></div> 
</div>
    </form>
    </div>
</td>
</tr>
</table>
 </td>
  <? 
    }
    ?>
</tr>
</table>

</div>
<div class=""></div>
<?php mysql_close();  ?>
