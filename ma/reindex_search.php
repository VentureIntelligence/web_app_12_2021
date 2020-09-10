<?php include_once("../globalconfig.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<title>PE in Real Estate Deal Database</title>
<link href="<?php echo $refUrl; ?>css/re_skin_1.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="<?php echo $refUrl; ?>css/detect800.css" />
<link href="hopscotch.min.css" rel="stylesheet"></link>

<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery-1.8.2.min.js"></script> 

<link rel="stylesheet" type="text/css" href="<?php echo $refUrl; ?>css/token-input.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $refUrl; ?>css/token-input-facebook.css" />
<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="<?php echo $refUrl; ?>js/popup.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo $refUrl; ?>/resources/demos/style.css" />

<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.multiselect.js"></script> 
<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.tokeninput.js"></script> 

  <script type="text/javascript" src="<?php echo $refUrl; ?>js/expand.js"></script>
 <script src="<?php echo $refUrl; ?>js/showHide.js" type="text/javascript"></script>
 <script src="<?php echo $refUrl; ?>js/jquery.flexslider.js"></script>
<script src="<?php echo $refUrl; ?>js/jquery.masonry.min.js"></script>
<script src="hopscotch.js"></script>
<script src="demo.js"></script>
 <script type="text/javascript">

$(document).ready(function(){


   $('.show_hide').showHide({			 
		speed: 800,  // speed you want the toggle to happen	
		easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
		changeText: 1 // if you dont want the button text to change, set this to 0
		
					 
	}); 
	$(".btn-slide").click(function(){
            
            $("#panel").animate({width: 'toggle'},{duration:200,step:function(){
                      if(demotour==1){
                     hopscotch.refreshBubblePosition();
                      }
            }}); 
            $(this).toggleClass("active"); 
                
            if($(this).hasClass("active")){
                if(demotour==1){
              hopscotch.startTour(tour, 2);   
                }
            }
                
                
            if ($('.left-td-bg').css("min-width") == '264px') {
            $('.left-td-bg').css("min-width", '36px');
            $('.acc_main').css("width", '35px');
            }
            else {
            $('.left-td-bg').css("min-width", '264px');
            $('.acc_main').css("width", '264px');
            }
           
            return false; //Prevent the browser jump to the link anchor
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
<script type="text/javascript" src="<?php echo $refUrl; ?>js/tytabs.jquery.min.js"></script>
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
<script src="<?php echo $refUrl; ?>js/jPages.js"></script>
<script src="<?php echo $refUrl; ?>js/jquery.icheck.min.js?v=0.9.1"></script>
<script src="<?php echo $refUrl; ?>js/jquery.flexslider.js"></script>

<!-- Masonry -->
<script src="<?php echo $refUrl; ?>js/jquery.masonry.min.js"></script>
<!--script type="text/javascript" src="<?php echo $refUrl; ?>js/responsive-tables.js"></script-->
<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.responsivetable.js"></script>
<script>
    $(document).ready(function() {
    $('.testTable1').responsiveTable( {scrollRight: false, scrollHintEnabled: false} );
});
</script>    
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
//	$("#myTable").tablesorter({widthFixed: true}); 
//	$("div.holder").jPages({
//	  containerID : "movies",
//	  previous : "�? Previous",
//	  next : "Next →",
//	  perPage : 50,
//	  delay : 20
//	});
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
        
        //$( ".custom-combobox" ).autocomplete({
	//  change: function( event, ui ) { this.form.submit(); }
	//});
        
        
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
           
           clear_keywordsearch();
           clear_companysearch();
           clear_sectorsearch();
           clear_searchallfield();
            disableFileds();  
           
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
           
           
           clear_keywordsearch();
           clear_companysearch();
           clear_sectorsearch();
           clear_searchallfield();
            disableFileds();  
           
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
           
           clear_keywordsearch();
           clear_companysearch();
           clear_sectorsearch();
           clear_Legal_Trans();
           
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
       
                     if(demotour==1)
                { 
                    showErrorDialog(warmsg);           
                   return false;
                } 
       
 navvalue=$(this).val();
       switch(navvalue)
       {
           case '0':
                    var hrefval = 'reindex.php?value=0';
                    window.location.href = hrefval;
                    break;
           case '1':
                    var hrefval = 'reindex.php';
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

$("#rtour2,#rtour3,#rtour4").click(function() { 
    
     if(demotour==1)
         { 
             $('#rtour2 div').removeClass("checked");         
            $('#rtour3 div').removeClass("checked");
            $('#rtour4 div').removeClass("checked");
            $('#definition_step div').addClass("checked");
         }
});

 $('.exist-nav').on('ifChecked', function(event){
         if(demotour==1)
         {               
             showErrorDialog(warmsg);
             return false;
         }
         navvalue=$(this).val();
       switch(navvalue)
       {
           case 'PE-BACKED-IPO':
                   window.location.href = 'reipoindex.php?value=1';
                   break;
           case 'PE-EXIST':
                   window.location.href = 'remandaindex.php?value=2';
                   break;
           case 'VC-EXIST':
                   window.location.href = 'remaindex.php?value=3';
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
           var hrefval = 'reindex.php?type=1';
                    $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=1&value=0");
    }
    else if (value == 2) {
         var hrefval = 'reindex.php?type=2';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=2&value=0");
    }
    else if (value == 3) {
         var hrefval = 'reindex.php?type=3';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=3&value=0");
    }
    else if (value == 4) {
         var hrefval = 'reindex.php?type=4';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=4&value=0");
    }
    else if (value == 5) {
                     var hrefval = 'reindex.php?type=5';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=5&value=0");
    }
    else if (value == 6) {
                     var hrefval = 'reindex.php?type=6';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=6&value=0");
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


$(document).ready(function() {
  $(".datesubmit").click(function() {
      
    var year1=$('#year1').val();
    var year2=$('#year2').val();
     
    var month1=$('#month1').val();
    var month2=$('#month2').val();
        
	if(year1 > year2)
	{
		 if(demotour==1)
                {
                    showErrorDialog(warmsg);
                    return false;
                }
                else {
                    alert("Error: 'To' Year cannot be before 'From' Year");
		return false;
                }
	}
        else if(year1 == year2)
        {
            if(parseInt(month1) > parseInt(month2))
            {
                 if(demotour==1)
                {
                    showErrorDialog(warmsg);
                    return false;
                }
                else {
                alert (" 'To' date should be greater than 'From' date.");
		return false;
                }
            } 
            else
            {
                 if(demotour==1)
                {
                     if(!(parseInt(month1)==1 && parseInt(month2)==3 && year1=="2014" && year2=="2014"))
                     {
                         showErrorDialog(warmsg);
                          return false;
                     }
                }
                $("#pesearch").submit();
            }
        }
	else
	{
		  if(demotour==1)
                {
                     if(!(parseInt(month1)==1 && parseInt(month2)==3 && year1=="2014" && year2=="2014"))
                     {
                          showErrorDialog(warmsg);
                          return false;
                     }
                }
                $("#pesearch").submit();
	}
  
});
});

function checkForDate()
{
	var year1=$('#year1').val();
	var year2=$('#year2').val();
        
        var month1=$('#month1').val();
        var month2=$('#month2').val();
	
	if(year1 > year2)
	{
		if(demotour==1)
                {
                    showErrorDialog(warmsg);
                    return false;
                }
                else { 
                    alert("Error: 'To' date cannot be before 'From' date");
		return false;
                }
	}
        else if(year1 == year2)
        {
            if(parseInt(month1) > parseInt(month2))
            {
                 if(demotour==1)
                {
                    showErrorDialog(warmsg);
                    return false;
                }
                else { 
                    alert("Error: 'To' Month cannot be before 'From' Month");
		return false;
                }
            } 
            else
            {
                 if(demotour==1)
                {
                     if(!(parseInt(month1)==1 && parseInt(month2)==3 && year1=="2014" && year2=="2014"))
                     {
                          showErrorDialog(warmsg);
                          return false;
                     }
                }
                $("#pesearch").submit();
            }
        }
	else
	{
		 if(demotour==1)
                {
                     if(!(parseInt(month1)==1 && parseInt(month2)==3 && year1=="2014" && year2=="2014"))
                     {
                          showErrorDialog(warmsg);
                          return false;
                     }
                }
                $("#pesearch").submit();
	}
	
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
<script type='text/javascript'>
    $(function() {
    // Stick the #nav to the top of the window
        var nav = $('#trendnav');
        var navHomeY = nav.offset().top;
        var isFixed = false;
        var cntheight = $('.result-cnt').height();
        var secheight = $('.sec-header-fix').height();
        var headheight = $('#header').height();
        var totheight=cntheight+secheight+headheight+100;
        
        var $w = $(window);
        $w.scroll(function() {
        var scrollTop = $w.scrollTop();
        scrollTop=scrollTop+totheight;
        var shouldBeFixed = scrollTop > navHomeY;
        if (shouldBeFixed && !isFixed) {
        nav.css({
        position: 'fixed',
        top: 295,
        left: nav.offset().left,
        width: nav.width()
        });
        isFixed = true;
        }
        else if (!shouldBeFixed && isFixed) {
        nav.css({
        position: 'static'
        });
        isFixed = false;
        }

        });
    });
</script>

<script type="text/javascript">
function industrypesearch()
{
    var sltindustry = $("#sltindustry").val();
       
     if(demotour==1){
         if(sltindustry==15) { $("#pesearch").submit(); } else {  showErrorDialog(warmsg); return false; }
       }  
       else
           {
               $("#pesearch").submit();
           }
                    
}

</script>

<script type="text/javascript">
$(function(){
	$(".selectgroup select").multiselect();
});

</script>
<script type="text/javascript" src="//www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
</head>

<?php if($_SESSION['RE_TrialLogin']==1){ ?>
<body > 
<?php }else { ?>
<body ondragstart="return false" onselectstart="return false" oncontextmenu="return false" oncopy="return false" onpaste="return false" oncut="return false"> 
<?php } ?>
    <div id="maskscreen" ></div>
<div id="preloading"></div>
<script type="text/javascript" >
$('#maskscreen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
jQuery(window).load(function(){
jQuery('#preloading').fadeOut(1000);
jQuery('#maskscreen').fadeOut(1000);
});
</script>
    <?php
        $defpage=0;
        include_once('redefinitions.php');
        include_once('refineredef.php');?>
<!--Header-->
<?php 
    $actionlink="reindex.php";

?>

<!--<form name="searchall" action="<?php echo $actionlink; ?>" method="post" id="searchall">    -->

<form name="reinvestment" action="<?php echo $actionlink; ?>" method="post" id="pesearch"> 
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="reindex.php"><img src="<?php echo $refUrl; ?>images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>


<td class="right-box">
<ul  class="tour-lock">
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active"' : '' ; ?>><a href="javascript:void(0)" class="popup_call" data-url="reindex.php"><i class="i-data-deals"></i>Deals</a></li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?>><a href="redirview.php"  id="redirectorytour"><i class="i-directory"></i>Directory</a></li>
<li <?php echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a href="refunds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
</ul>
<ul class="fr">
   <li class="classic-btn tour-lock"><a href="refaq.php" id="faq-btn" style="opacity: 1;">FAQ</a></li>
    <!--  <li class="classic-btn   tour-lock"><a href="https://www.ventureintelligence.com/review/rehome.php" >Classic View</a></li>
      <li class="classic-btn"><input  type="button" id="startTourBtn" value="Start Tour" /></li> -->
      <li ><div style="float:right;padding: 9px 15px" class="key-search"><b></b> <input  autofocus="autofocus" type="text" name="searchallfield" id="searchallfield" placeholder=" Keyword Search" value='<?php echo (isset($searchallfield) && $searchallfield !='')?$searchallfield:''; ?>' style="padding:5px;"  /> 
        <input type="hidden" value="" name="searchallfieldHide" id="searchallfieldHide" />
        <input type="button" name="fliter_stage" value="Go" onclick="this.form.submit();" style="padding: 5px;"/>
    </div></li>

<?php if($_SESSION['student']!="1") { ?>    
<li class="user-avt"><span class="example" data-dropdown="#myaccount"> Welcome  <?php echo $_SESSION['REUserNames']; ?></span>
 <?php }else{
     ?>
  <li class="user-avt"><span class="studentlogin" data-dropdown="#myaccount"> Welcome  <?php echo $_SESSION['REUserNames']; ?></span>  
<?php
 }
 ?>
<?php if($_SESSION['student']!="1") { ?>
<div id="myaccount" class="dropdown" style="left:inherit !important; max-width: 250px !important;">
		<ul class="dropdown-menu">
                        <li class="o_link"><a href="../pelogin.php" target="_blank">PE/VC Deals Database</a></li>
                        <li class="o_link"><a href="../malogin.php" target="_blank">M&A Deals Database</a></li>
                        <li class="o_link"><a href="../cfsnew/login.php" target="_blank">Company Financials Database</a></li>
                        
			<li><a href="changepassword.php?value=R">Change Password</a></li>
                        <li><a href="logoff.php?value=R">Logout</a></li>
		</ul>
	</div>
<?php } ?></li>
</ul>
</td>
</tr>
</table>

</div>
<!--</form>

<form name="reinvestment" action="<?php echo $actionlink; ?>" method="post" id="pesearch">  -->
<?php
$passwrd = $_GET['value'];
if($passwrd != 'P')
{
?>
<div id="sec-header" class="sec-header-fix reindex">
<table cellpadding="0" cellspacing="0">
<tr>

<td class="investment-form">
    <?php if($topNav=='Funds' || $topNav=='Fund-details' ){ ?>
     <h3>INVESTOR</h3>

        <div class="investmentlabel">
        <input type="text" id="investorauto" name="investorauto" value="<?php if(isset($_REQUEST['investorauto'])) echo  $_REQUEST['investorauto'];  ?>" placeholder="" style="width:220px;height:25px;z-index:1111;">
        <input type="hidden" id="investorsearch" name="investorsearch" value="<?php if(isset($_REQUEST['investorsearch'])) echo  $_REQUEST['investorsearch'];  ?>" placeholder="" style="width:220px;z-index:1111;"> 
<?php } else { ?>   
<h3> </h3>
<label id="definition_step"  ><input class="investment-nav" name="investments" type="radio" value=0 checked="checked" id="definition_step1" /> PE Investments - Real Estate </label>

<label id="rtour2" ><input class="exist-nav" name="investments" type="radio" value="PE-BACKED-IPO" id="definition_step2"/>PE backed IPO</label>

<label  id="rtour3" ><input class="exist-nav" name="investments" type="radio" value="PE-EXIST" id="definition_step3"/>PE Exits via M&A </label>

<label  id="rtour4"  ><input class="exist-nav" name="investments" type="radio" value="VC-EXIST" id="definition_step4"/>Other M&A</label>
<?php } ?>  
</td>




<td class="vertical-form">
    <div style="float:left">
   
<h3>PERIOD</h3>

<div class="period-date">
<label>From</label>
<SELECT NAME="month1" id="month1">
     <OPTION id=1 value="--"> Month </option>
     <OPTION VALUE='1' <?php echo ($month1 == '1') ? 'SELECTED' : ''; ?> >Jan</OPTION>
     <OPTION VALUE='2' <?php echo ($month1 == '2') ? 'SELECTED' : ''; ?>>Feb</OPTION>
     <OPTION VALUE='3' <?php echo ($month1 == '3') ? 'SELECTED' : ''; ?>>Mar</OPTION>
     <OPTION VALUE='4' <?php echo ($month1 == '4') ? 'SELECTED' : ''; ?>>Apr</OPTION>
     <OPTION VALUE='5' <?php echo ($month1 == '5') ? 'SELECTED' : ''; ?>>May</OPTION>
     <OPTION VALUE='6' <?php echo ($month1 == '6') ? 'SELECTED' : ''; ?>>Jun</OPTION>
     <OPTION VALUE='7' <?php echo ($month1 == '7') ? 'SELECTED' : ''; ?>>Jul</OPTION>
     <OPTION VALUE='8' <?php echo ($month1 == '8') ? 'SELECTED' : ''; ?>>Aug</OPTION>
     <OPTION VALUE='9' <?php echo ($month1 == '9') ? 'SELECTED' : ''; ?>>Sep</OPTION>
     <OPTION VALUE='10' <?php echo ($month1 == '10') ? 'SELECTED' : ''; ?>>Oct</OPTION>
     <OPTION VALUE='11' <?php echo ($month1 == '11') ? 'SELECTED' : ''; ?>>Nov</OPTION>
    <OPTION VALUE='12' <?php echo ($month1 == '12') ? 'SELECTED' : ''; ?>>Dec</OPTION>
</SELECT>

<SELECT NAME="year1" id="year1"  id="year1">
    <OPTION id=2 value=""> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from REinvestments order by dates desc";
		if($yearSql=mysql_query($yearsql))
		{
                        if($type == 1)  
                        {
                            if($_POST['year1']=='')
                            {
                                $year1;
                            }
                        }
                        else
                        {
                            if($_POST['year1']=='')
                            {
                                $year1;
                            }
                        }
			/*While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselected = ($year1==$id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
			}*/
                        $currentyear = date("Y");
                        $i=$currentyear;
                        While($i>= 1998 )
                        {
                        $id = $i;
                        $name = $i;
                        $isselected = ($year1==$id) ? 'SELECTED' : '';
                        echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                        $i--;
                        }
		}
	?> 
</SELECT>
</div>
<div class="period-date">
<label>To</label>

<SELECT NAME="month2" id='month2'>
      <OPTION id=1 value="--"> Month </option>
     <OPTION VALUE='1' <?php echo ($month2 == '1') ? 'SELECTED' : ''; ?> >Jan</OPTION>
     <OPTION VALUE='2' <?php echo ($month2 == '2') ? 'SELECTED' : ''; ?>>Feb</OPTION>
     <OPTION VALUE='3' <?php echo ($month2 == '3') ? 'SELECTED' : ''; ?>>Mar</OPTION>
     <OPTION VALUE='4' <?php echo ($month2 == '4') ? 'SELECTED' : ''; ?>>Apr</OPTION>
     <OPTION VALUE='5' <?php echo ($month2 == '5') ? 'SELECTED' : ''; ?>>May</OPTION>
     <OPTION VALUE='6' <?php echo ($month2 == '6') ? 'SELECTED' : ''; ?>>Jun</OPTION>
     <OPTION VALUE='7' <?php echo ($month2 == '7') ? 'SELECTED' : ''; ?>>Jul</OPTION>
     <OPTION VALUE='8' <?php echo ($month2 == '8') ? 'SELECTED' : ''; ?>>Aug</OPTION>
     <OPTION VALUE='9' <?php echo ($month2 == '9') ? 'SELECTED' : ''; ?>>Sep</OPTION>
     <OPTION VALUE='10' <?php echo ($month2 == '10') ? 'SELECTED' : ''; ?>>Oct</OPTION>
     <OPTION VALUE='11' <?php echo ($month2 == '11') ? 'SELECTED' : ''; ?>>Nov</OPTION>
    <OPTION VALUE='12' <?php echo ($month2 == '12') ? 'SELECTED' : ''; ?>>Dec</OPTION>
</SELECT>

<SELECT NAME="year2" id="year2" onchange="checkForDate();" id='year2'>
    <OPTION id=2 value=""> Year </option>
    <?php 
		/*$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from REinvestments order by dates asc";
                 if($_POST['year2']=='')
                {
                    $year2=date("Y");
                }
		if($yearSql=mysql_query($yearsql))
		{
			While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselcted = ($year2== $id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselcted.">".$name."</OPTION>\n";
			}		
		}*/
                $currentyear = date("Y");
                $i=$currentyear;
                While($i>= 1998 )
                {
                $id = $i;
                $name = $i;
                $isselected = ($year2==$id) ? 'SELECTED' : '';
                echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
                $i--;
                }
	?> 
</SELECT>
</div>

  <div class="search-btn"   id="datesubmit"> <input name="searchpe" type="submit" value="Search" class="datesubmit"/></div>
  </div>
<div style="float:left; margin-left: 15px;font-size: 14px;">
     <div style="padding-bottom: 10px;">For Data Support</div>
     <div>
         <a href="mailto:research@ventureintelligence.com">research@ventureintelligence.com</a>
         <br/>
         +91-44-42185180/82
     </div>
 </div>
</td>
</tr>
</table>
</div>
<?php
}
?>

 
     
<script>
   $(function() {
    $( "#investorauto" ).autocomplete({
    
      source: function( request, response ) {  
      
        $('#investorsearch').val('');
        $.ajax({
          type: "POST",
          url: "ajaxFundInvDetails.php",
          dataType: "json",
          data: {
            search: request.term
          },
          success: function( data ) {
            response( $.map( data, function( item ) {
              return {
                label: item.label,
                value: item.value,
                 id: item.id
              }
            }));
          }
        });
      },
      minLength: 2,
      select: function( event, ui ) {
      
        $("#month1").val('1');
        $("#month2").val('<?php echo date('n')?>');
        $("#year1").val('1998');
        $("#year2").val('<?php echo date('Y')?>');  
       $('#investorauto').val(ui.item.value);
       $('#investorsearch').val(ui.item.id);
       this.form.submit();
      },
      open: function() {
            $( this ).autocomplete('widget').css('z-index',2000);
//        $( this ).removeClass( "ui-corner-all" ).addClass( "ui-corner-top" );
      },
      close: function() {
          if(  $('#investorsearch').val()=="")
             $( "#investorauto" ).val('');  
             
      }
    });
    });
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
 



</script>
     
     
          <script>


function setCurControl(control)
{       
   if(control=="industry" && demotour=='1')
   {
       if($("#sltindustry").val()=="15")
       {
            $("#controlName").val(control);
            $("#pesearch").submit();
            return true;
       }else
           {
               showErrorDialog(warmsg);
               return false;
           }
   } else{
      $("#controlName").val(control);
      $("#pesearch").submit();
   }
}

</script>
<script>
    $(".tour-lock").on('click', '.popup_call', function(e) {
        e.preventDefault();
        var url = $(this).attr('data-url'); 
        $.ajax({
            url: 'ajax_set_session.php',
            type: 'POST',
            timeout: 30000, // in milliseconds
            success: function(data) { 
                window.location.href=url;
                return true;
            }
        });
    });
</script>