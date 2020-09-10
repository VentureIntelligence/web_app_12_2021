<?php include_once("../globalconfig.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>Venture Intelligence</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link href="css/skin_test.css" rel="stylesheet" type="text/css" />  
<link href="css/popstyle.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="css/detect800.css" />
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<link rel="stylesheet" type="text/css" href="css/token-input.css" />
<link rel="stylesheet" type="text/css" href="css/token-input-facebook.css" />
<!--<script type="text/javascript" src="js/jquery.tablesorter.js"></script>-->
<script type="text/javascript" src="js/popup.js"></script>

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
<link href="hopscotch.min.css" rel="stylesheet"></link>
<script type="text/javascript" src="js/jquery.tokeninput.js"></script> 
<script type="text/javascript" src="js/jquery.multiselect.js"></script> 
  <script type="text/javascript" src="js/expand.js"></script>
 <script src="js/showHide.js" type="text/javascript"></script>
 <script src="js/jquery.flexslider.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<!--  <script src="js/switch.min.js" type="text/javascript"></script>-->
<!-- <link href="css/switch.css" type="text/css" rel="stylesheet">-->

<?php if($tour!='Allow'){ ?>
<script src="TourStart.js"></script> 
<?php } ?>

 <script type="text/javascript">

$(document).ready(function(){


   $('.show_hide').showHide({			 
		speed: 800,  // speed you want the toggle to happen	
		easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
		changeText: 1 // if you dont want the button text to change, set this to 0
		
					 
	}); 
            $(".btn-slide").click(function(){
            $("#panel").animate({width: 'toggle'}, 200); 
            $(this).toggleClass("active"); 
            if ($('.left-td-bg').css("min-width") == '264px') {
            $('.left-td-bg').css("min-width", '36px');
            $('.acc_main').css("width", '35px');
                $('.download-link').addClass('download-link-size1');
                $('.download-link').removeClass('download-link-size2');
                $('.inner-section').removeClass('inner-section-width2').addClass('inner-section-width1');
                $('.inner-list').removeClass('inner-list_width2').addClass('inner-list_width1');
                if( $('#financials_info.fullBox').length == 0){
                    $('.col-p-11').css("width",""); 
                    $('#financials_info').removeClass('col-p-11').addClass('col-p-11_1');
                   /* $('#investor_info').removeClass('col-p-9').addClass('col-p-9_1');
                    $('#advisor_info').removeClass('col-p-8').addClass('col-p-8_1');*/
                }else{
                    if( $('.col-p-11').length > 0){
                        $('.col-p-11').css("width","19%");  
            }
                }
                $("#deal_info td:nth-child(1), #deal_info td:nth-child(3), #valuation_info td:first-child, #financials_info td:first-child, #investor_info td:first-child, #company_info td:first-child, #company_info td:nth-child(3), #advisor_info td:first-child").css("padding-left","15px");
                $("#company_info td:nth-child(3)").css("width","14%");
                $("#company_info td:first-child").css("width","13%");
                $('.col-p-7').css("width","36%");
                $('.col-p-8_1').css("width","16%"); 
                $('.col-p-8_2').css("width","15%"); 
                $("#company_info td:nth-child(2)").css("width","38%");
                $("#company_info td:nth-child(4)").css("width","35%");
                $("#deal_info td:nth-child(1)").css("width","26%");
                $("#deal_info td:nth-child(2)").css("width","24%");
                $("#deal_info td:nth-child(3)").css("width","27%");
                $("#deal_info td:nth-child(4)").css("width","23%");
            }
            else {
            $('.left-td-bg').css("min-width", '264px');
            $('.acc_main').css("width", '264px');
                $('.download-link').addClass('download-link-size2');
                $('.download-link').removeClass('download-link-size1');
                $('.inner-section').removeClass('inner-section-width1').addClass('inner-section-width2');
                $('.inner-list').removeClass('inner-list_width1').addClass('inner-list_width2');
                if( $('#financials_info.fullBox').length == 0){
                    $('#financials_info').removeClass('col-p-11_1').addClass('col-p-11');
                    /*$('#investor_info').removeClass('col-p-9_1').addClass('col-p-9');
                    $('#advisor_info').removeClass('col-p-8_1').addClass('col-p-8');*/
                    if( $('.col-p-11').length > 0){
                        $('.col-p-11').css("width","21%");  
            } 
                }else{
                    if( $('.col-p-11').length > 0){
                        $('.col-p-11').css("width","21%");   
                    }
                }
                $("#deal_info td:nth-child(1), #deal_info td:nth-child(3), #valuation_info td:first-child, #financials_info td:first-child, #investor_info td:first-child, #company_info td:first-child, #company_info td:nth-child(3), #advisor_info td:first-child").css("padding-left","10px");
                $("#company_info td:nth-child(3)").css("width","17%");
                $("#company_info td:first-child").css("width","14%");
                $('.col-p-7').css("width","40%");
                $('.col-p-8_1').css("width","22%");
                $('.col-p-8_2').css("width","22%"); 
                $("#company_info td:nth-child(2)").css("width","33%");
                $("#company_info td:nth-child(4)").css("width","36%");
                $("#deal_info td:nth-child(1)").css("width","24%");
                $("#deal_info td:nth-child(2)").css("width","22%");
                $("#deal_info td:nth-child(3)").css("width","28%");
                $("#deal_info td:nth-child(4)").css("width","26%");
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
<!--<script src="js/jPages.js"></script>-->
<script src="js/jquery.icheck.min.js?v=0.9.1"></script>
<script src="js/jquery.flexslider.js"></script>
 

<!-- Masonry -->
<script src="js/jquery.masonry.min.js"></script>
<!--<script type="text/javascript" src="js/responsive-tables.js"></script>-->
<script type="text/javascript" src="js/jquery.responsivetable.js"></script>
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
//	  previous : "â†? Previous",
//	  next : "Next â†’",
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
          }
         
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
 
//  $(function() {
//	//var keywordsearchbox = $("#keywordsearch").combobox();
//        var companysearchbox = $("#combobox").combobox();
//	var advisorsearch_legalbox = $("#advisorsearch_legal").combobox();
//	var advisorsearch_transbox = $("#advisorsearch_trans").combobox();
//        var sectorsearchbox = $("#sectorsearch").combobox();
//	/*$( ".custom-combobox" ).autocomplete({
//	  change: function( event, ui ) { this.form.submit(); }
//	});*/
//        
//        /*
//         keywordsearchbox.on( "comboboxselect", function( event, ui ) {
//           companysearchbox.combobox("destroy") ;
//           advisorsearch_legalbox.combobox("destroy") ;
//           advisorsearch_transbox.combobox("destroy") ;
//           sectorsearchbox.combobox("destroy") ; 
//           $("#combobox option:eq(0)").attr('selected','selected');
//           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
//           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
//           $("#sectorsearch option:eq(0)").attr('selected','selected');
//           companysearchbox.combobox() ;
//           advisorsearch_legalbox.combobox() ;
//           advisorsearch_transbox.combobox() ;
//           sectorsearchbox.combobox() ; 
//        } ); */
//       companysearchbox.on( "comboboxselect", function( event, ui ) {
//         //  keywordsearchbox.combobox("destroy") ;
//           advisorsearch_legalbox.combobox("destroy") ;
//           advisorsearch_transbox.combobox("destroy") ;
//           sectorsearchbox.combobox("destroy") ; 
//           $("#keywordsearch option:eq(0)").attr('selected','selected');
//           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
//           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
//           $("#sectorsearch option:eq(0)").attr('selected','selected');
//       //    keywordsearchbox.combobox() ;
//           advisorsearch_legalbox.combobox() ;
//           advisorsearch_transbox.combobox() ;
//           sectorsearchbox.combobox() ; 
//        } );
//         sectorsearchbox.on( "comboboxselect", function( event, ui ) {
//      //     keywordsearchbox.combobox("destroy") ;
//           companysearchbox.combobox("destroy") ;
//           advisorsearch_legalbox.combobox("destroy") ;
//           advisorsearch_transbox.combobox("destroy") ; 
//           $("#combobox option:eq(0)").attr('selected','selected');
//           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
//           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
//        //   keywordsearchbox.combobox() ;
//           companysearchbox.combobox() ;
//           advisorsearch_legalbox.combobox() ;
//           advisorsearch_transbox.combobox() ;
//        } );
//       advisorsearch_legalbox.on( "comboboxselect", function( event, ui ) {
//           keywordsearchbox.combobox("destroy") ;
//           companysearchbox.combobox("destroy") ;
//           advisorsearch_transbox.combobox("destroy") ;
//           sectorsearchbox.combobox("destroy") ; 
//           $("#keywordsearch option:eq(0)").attr('selected','selected');
//           $("#combobox option:eq(0)").attr('selected','selected');
//           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
//           $("#sectorsearch option:eq(0)").attr('selected','selected');
//         //  keywordsearchbox.combobox() ;
//           companysearchbox.combobox() ;
//           advisorsearch_transbox.combobox() ;
//           sectorsearchbox.combobox() ; 
//        } );
//         advisorsearch_transbox.on( "comboboxselect", function( event, ui ) {
//           keywordsearchbox.combobox("destroy") ;
//           companysearchbox.combobox("destroy") ;
//           advisorsearch_legalbox.combobox("destroy") ;
//           sectorsearchbox.combobox("destroy") ; 
//            $("#keywordsearch option:eq(0)").attr('selected','selected');
//           $("#combobox option:eq(0)").attr('selected','selected');
//           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
//           $("#sectorsearch option:eq(0)").attr('selected','selected');
//           keywordsearchbox.combobox() ;
//           companysearchbox.combobox() ;
//           advisorsearch_legalbox.combobox() ;
//           sectorsearchbox.combobox() ; 
//        } );
//       
//        
//        $("#resetall").click(function (){
//         //  keywordsearchbox.combobox("destroy") ;
//           companysearchbox.combobox("destroy") ;
//           advisorsearch_legalbox.combobox("destroy") ;
//           advisorsearch_transbox.combobox("destroy") ;
//           sectorsearchbox.combobox("destroy") ; 
//           
//           $("#keywordsearch option:eq(0)").attr('selected','selected');
//           $("#combobox option:eq(0)").attr('selected','selected');
//           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
//           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
//           $("#sectorsearch option:eq(0)").attr('selected','selected');
//           
//           keywordsearchbox.combobox();
//           companysearchbox.combobox() ;
//           advisorsearch_legalbox.combobox() ;
//           advisorsearch_transbox.combobox() ;
//           sectorsearchbox.combobox() ; 
////           $("#year1,#year2,#month1,#month2").removeAttr("disabled");
//        });
//    
// 
//        
//  });
 
 

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

       $("#disselect").find(':input').prop("disabled", true);  
     $('.investment-nav').on('ifChecked', function(event){
         
            <?php if($tour=='Allow'){ ?> 
            if(demotour==1 || vcdemotour==1){
                    showErrorDialog(warmsg);
                     return false;
                }
            <?php } ?>    
       
 var navvalue=$(this).val();
       switch(navvalue)
       {
           case '0':
                    var hrefval = 'index.php?value='+$(this).val();
                    window.location.href = hrefval;
//                  $("#pesearch").attr("action", hrefval);
//                  $("#pesearch").submit();
                    return false;
                    break;
           case '1':
                    var hrefval = 'index.php?value='+$(this).val();
                    window.location.href = hrefval;
//                    $("#pesearch").attr("action", hrefval);
//                    $("#pesearch").submit();
                    return false;
                    break;
           case '2':
                   window.location.href = 'angelindex.php';
                   break;
           case '3':
                    var hrefval = 'svindex.php?value='+$(this).val();
                    window.location.href = hrefval;
//                    $("#pesearch").attr("action", hrefval);
//                    $("#pesearch").submit();
                    return false;
                   //window.location.href = 'svtrendview.php?value='+$(this).val();
                   break;
           case '4':
                    var hrefval = 'svindex.php?value='+$(this).val();
                    window.location.href = hrefval;
//                    $("#pesearch").attr("action", hrefval);
//                    $("#pesearch").submit();
                    return false;
                     //window.location.href = 'svtrendview.php?value='+$(this).val();
                    break;
           case '5':
                    var hrefval = 'svindex.php?value='+$(this).val();
                    window.location.href = hrefval;
//                    $("#pesearch").attr("action", hrefval);
//                    $("#pesearch").submit();
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
     
     
     <?php if($tour=='Allow'){ ?> 
        if(demotour==1 || vcdemotour==1){
                    showErrorDialog(warmsg);
                     return false;
                }
     <?php } ?>  
         
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
            case 'VCPMS':
                   window.location.href = 'mandaindex.php?value=1-1';
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
$(document).ready(function() {
  $(".datesubmit").click(function() {
      
    var year1=$('#year1').val();
    var year2=$('#year2').val();
     
    var month1=$('#month1').val();
    var month2=$('#month2').val();
        
	if(year1 > year2)
	{
		alert("Error: 'To' Year cannot be before 'From' Year");
		return false;
	}
        else if(year1 == year2)
        {
            if(parseInt(month1) > parseInt(month2))
            {
                alert("Error: 'To' Month cannot be before 'From' Month");
		return false;
            } 
            else
                {
                    $("#pesearch").submit();
                }
        }
	else
	{
		$("#pesearch").submit();
	}
  
});
});
function checkForAggregates()
{
	document.manda.hiddenbutton.value='Aggregate';
	document.manda.submit();
}
function checkForDate()
{
	var year1=$('#year1').val();
	var year2=$('#year2').val();
        
        var month1=$('#month1').val();
        var month2=$('#month2').val();
	
	if(year1 > year2)
	{
		alert("Error: 'To' date cannot be before 'From' date");
		return false;
	}
        else if(year1 == year2)
        {
            if(parseInt(month1) > parseInt(month2))
            {
                alert("Error: 'To' Month cannot be before 'From' Month");
		return false;
            } 
            else
                {
                    $("#pesearch").submit();
                }
        }
	else
	{
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
<script type="text/javascript">
$(function(){
	$(".selectgroup select").multiselect();
});



$(window).load(function(){
$('#searchall').submit(function () { 
    
     if(demotour==1){
         var txt = $("#searchallfield").val();
         if(txt=='Offshore' || txt=='offshore') { $("#searchall").submit(); } else {  showErrorDialog(warmsg); return false; }
       } 
     else  if(vcdemotour==1){
         var txt = $("#searchallfield").val();
         if(txt=='E-Commerce' || txt=='e-commerce') { $("#searchall").submit(); } else {  showErrorDialog(warmsg); return false; }
       } 
});



$('#fliter_stage').click(function () {
  // alert('test');
     if(demotour==1){
         
         var txt2 = $("#searchallfield").val();
         if(txt2=="Offshore" || txt2=="offshore") {
             $("#searchall").submit(); 
         }
         else {  showErrorDialog(warmsg); return false; }
        
       }
       else if(vcdemotour==1){
         
         var txt2 = $("#searchallfield").val();
         if(txt2=="E-Commerce" || txt2=="e-commerce") {
             $("#searchall").submit(); 
         }
         else {  showErrorDialog(warmsg); return false; }
        
       }
       else
           {
               $("#searchall").submit();
           }
});



});

</script>
<script type="text/javascript" src="http://www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
<style type="text/css">

#preloading {
background:url(images/linked-in.gif) no-repeat center center;
height: 100px;
width: 100px;
position: fixed;
left: 50%;
top: 50%;
margin: -25px 0 0 -25px;
z-index: 1000;
}

#maskscreen
{
position: fixed;
left: 0;
top: 0;
background: #000;
z-index: 8000;
overflow: hidden;
}


</style>



<script type="text/javascript">

$(document).ready(function() {
  $("#tourlibtn").click(function(){
      $("#tourlist").show();
  });
});

$(document).mouseup(function (e)
{
    $("#tourlist").hide();
});



</script>


</head>

<?php if($_SESSION['PE_TrialLogin']==1){ ?>
<body > 
<?php }else { ?>
<body ondragstart="return false" onselectstart="return false" oncontextmenu="return false" oncopy="return false" onpaste="return false" oncut="return false"> 
<?php } ?>
    
<div id="maskscreen" ></div>
<div id="preloading"></div>
<script type="text/javascript" >
                                                                                        console.log($(document).height());
$('#maskscreen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
jQuery(window).load(function(){
jQuery('#preloading').fadeOut(1000);
jQuery('#maskscreen').fadeOut(1000);
});
</script>
    <?php include_once('definitions.php');?>
    <?php include_once('refinedef.php');?>
<!--Header-->
<?php if($vcflagValue=="0" || $vcflagValue=="1" || $vcflagValue=="2")
{
    $actionlink="index.php?value=".$vcflagValue;
}
else 
{
        $actionlink="svindex.php?value=".$vcflagValue;
}
?>

<!--<form name="searchall" action="<?php echo $actionlink; ?>" method="post" id="searchall">    -->
<form name="pesearch" action="<?php echo $actionlink; ?>" method="post" id="pesearch">
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="index.php"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>


<td class="right-box">
    
    <?php include('top_menu.php'); ?>
    
<!--<ul class="tour-lock">
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active"' : '' ; ?>><a href="index.php"><i class="i-data-deals"></i>Deals</a></li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?>><a href="pedirview.php?value=0"><i class="i-directory"></i>Directory</a></li>
<li <?php echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a href="funds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
<!--li <?php echo ($topNav=='Report') ? 'class="active"' : '' ; ?>><a href="report.php"><i class="i-directory"></i>Report</a></li
</ul>-->
    
<ul class="fr">
    <li class="classic-btn tour-lock"><a href="<?php echo GLOBAL_BASE_URL; ?>deals/dealhome.php" >Classic View</a></li>
    <?php include('TourStartbtn.php'); ?>
    
            
<li ><div style="float:right;padding: 9px 15px" class="key-search"><b></b> <input  autofocus="autofocus" type="text" id="searchallfield" name="searchallfield" placeholder="Search"
    <?php if($searchallfield!="") echo "value='".$searchallfield."'" ;?> style="padding:5px;"  /> 
        <input type="submit" name="fliter_stage" id="fliter_stage" value="Go" style="padding: 5px;"/>
    </div></li>
 <?php if($_SESSION['student']!="1") { ?>   
<li class="user-avt"><span class="example" data-dropdown="#myaccount"> Welcome  <?php echo $_SESSION['UserNames']; ?></span> 
    <?php } 
 else {
 ?>       
 <li class="user-avt"><span class="studentlogin" data-dropdown="#myaccount"> Welcome  <?php echo $_SESSION['UserNames']; ?></span> 
 <?php    
 }?>
<?php if($_SESSION['student']!="1") { ?>
<div id="myaccount" class="dropdown" style="left:inherit !important; max-width: 250px !important;">
		<ul class="dropdown-menu">
                        <li class="o_link"><a href="../relogin.php" target="_blank">PE in Real Estate Database</a></li>
                        <li class="o_link"><a href="../malogin.php" target="_blank">M&A Deals Database</a></li>
                        <li class="o_link"><a href="../cfsnew/login.php" target="_blank">Company Financials Database</a></li>
                        
                        
			<li><a href="changepassword.php?value=P">Change Password</a></li>
                        <li><a href="logoff.php?value=P">Logout</a></li>
		</ul>
	</div>
<?php } ?>
</li>
</ul>
</td>
</tr>
</table>

</div>
<!--</form>

<form name="pesearch" action="<?php echo $actionlink; ?>" method="post" id="pesearch">  -->
<?php
$passwrd = $_GET['value'];
if($passwrd != 'P')
{
?>
    <!--div id="sec-header" class="sec-header-fix"-->
<div id="sec-header" class="sec-header-fix">
<table cellpadding="0" cellspacing="0">
<tr>

<td class="investment-form">
<h3>INVESTMENTS</h3>
<div class="investmentlabel">
<?php // echo $vcflagValue;?>

    <select id="investmentswitch" >  
<option  class="peonly" value="investmentspe" <?php echo ($vcflagValue==0) ? 'SELECTED' : ""; ?>>PE</option>
<option  class="vconly" value="investmentsvc" <?php echo ($vcflagValue==2 || $vcflagValue==1 || $vcflagValue==6 ||$vcflagValue==3) ? 'SELECTED' : ""; ?> >VC</option>
</select>  

<div id="investmentspe" >
<label><input class="investment-nav" name="investments" type="radio" value=0  <?php if($vcflagValue==0) { ?> checked="checked" <?php } ?>  /> PE</label></div>

<div id="investmentsvc" class="select-hide">
<label><input class="investment-nav" name="investments" type="radio" value=1  <?php if($vcflagValue==1) { ?> checked="checked" <?php } ?>/> VC</label>
<label><input class="investment-nav" name="investments" type="radio" value=2  <?php if($vcflagValue==2) { ?> checked="checked" <?php } ?>/>Angel</label>
<label><input class="investment-nav" name="investments" type="radio" value=6  <?php if($vcflagValue==6) { ?> checked="checked" <?php } ?>/>Incubation</label>
<label><input class="investment-nav" name="investments" type="radio" value=3  <?php if($vcflagValue==3) { ?> checked="checked" <?php } ?>/>Social</label></div>
</div>

<!--<div id="invspecialisedsocial" class="">
</div>-->

<div id="investmentsspecialised" class="">
<label><input class="investment-nav" name="investments" type="radio" value=4  <?php if($vcflagValue==4) { ?> checked="checked" <?php } ?>/>Cleantech</label>
<label><input class="investment-nav" name="investments" type="radio" value=5  <?php if($vcflagValue==5) { ?> checked="checked" <?php } ?>/>Infrastructure</label></div>
</td>



<td class="exit-form">
<h3>EXITS <!--VIA--></h3>
<div class="exitslabel">    
    <select id="exitswitch">
        <option value="1" class="peonly">PE</option>
    <option value="0" class="vconly">VC</option>
    </select>
 
<div id="exitsviape" >



<label><input class="exist-nav" name="investments" type="radio" value="PE-EXIST" />M&A(PE) </label>

<label><input class="exist-nav" name="investments" type="radio" value="PMS" /> Public Market</label>

<label><input class="exist-nav" name="investments" type="radio" value="PE-BACKED-IPO" />IPO(PE)</label>
</div>


<div id="exitsviavc" class="select-hide" >




<label><input class="exist-nav" name="investments" type="radio" value="VC-EXIST" />M&A(VC) </label>

<label><input class="exist-nav" name="investments" type="radio" value="VCPMS" /> Public Market</label>

<label><input class="exist-nav" name="investments" type="radio" value="VC-BACKED-IPO" />IPO(VC)</label>

 </div>

 
</div>


</td>
<?php
if(trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
{
?>
<!--<td class="vertical-form" id="disselect">-->
<?php
}
else
{
?>
<!--    <td class="vertical-form">-->
<?php
}?>
 <td class="vertical-form">        
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
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates desc";
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

			/*While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselected = ($year1==$id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselected.">".$name."</OPTION>\n";
			}*/		
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
		$yearsql="select distinct DATE_FORMAT( dates, '%Y') as Year from peinvestments order by dates desc";
                 if($_POST['year2']=='')
                {
                    $year2=date("Y");
                }
		if($yearSql=mysql_query($yearsql))
		{
			/*While($myrow=mysql_fetch_array($yearSql, MYSQL_BOTH))
			{
				$id = $myrow["Year"];
				$name = $myrow["Year"];
				$isselcted = ($year2== $id) ? 'SELECTED' : '';
				echo "<OPTION id=". $id. " value='". $id."' ".$isselcted.">".$name."</OPTION>\n";
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
		}
	?> 
</SELECT>
</div>
  <div class="search-btn"  > <input name="searchpe" type="submit" value="Search" class="datesubmit" /></div>
</td>
 
</tr>
</table>
</div>
<?php
}
?>
<script>
 
<?php if($vcflagValue==0 || $vcflagValue==4 || $vcflagValue==5) { ?> 
    $("#investmentspe").show();  
     $("#investmentsvc").hide();
     $("#investmentsspecialised").show();
     $("#invspecialisedsocial").hide();
     
    
<?php } else if($vcflagValue==2 || $vcflagValue==1 || $vcflagValue==6 || $vcflagValue==3) { 
    ?>
     $("#investmentspe").hide();  
     $("#investmentsvc").show();
      $("#invspecialisedsocial").show();
     $("#investmentsspecialised").hide();
    
<?php } ?>

//$('.investment-form select, .exit-form select').switchify();
      
//    $('.ui-switch-middle').removeClass('ui-switch-middle');  	
	
/*     $('.investmentlabel .ui-switch-off').click(function() {   
        $("#investmentspe").show();  
        $("#investmentsvc").hide();
        $("#investmentsspecialised").show();
        $("#invspecialisedsocial").hide();
    });	 
        $('.investmentlabel .ui-switch-on').click(function() {   
        $("#investmentspe").hide();  
        $("#investmentsvc").show();
        $("#invspecialisedsocial").show();
        $("#investmentsspecialised").hide();
    }); */
    
    $('#investmentswitch').change(function() {
        thisvalue= $(this).val();
        if(thisvalue=="investmentspe")
        {
        $("#investmentspe").show();  
        $("#investmentsvc").hide();
        $("#investmentsspecialised").show();
        $("#invspecialisedsocial").hide();
        }
        else {
        $("#investmentspe").hide();  
        $("#investmentsvc").show();
        $("#invspecialisedsocial").show();
        $("#investmentsspecialised").hide();
        }
    });
	
	
        $('#exitswitch').change(function() { 
             thisvalue= $(this).val();
        if(thisvalue=="1")
        {
            $("#exitsviape").show();  
            $("#exitsviavc").hide();
        }
        else{ 
            $("#exitsviape").hide();  
            $("#exitsviavc").show();
        }
        });	
        
    $('#investmentswitch').change(function(event){
       
       navvalue=$(this).val();
       switch(navvalue)
       {
           case 'investmentspe':
                    var hrefval = 'index.php?value=0';
                    window.location.href = hrefval;
//                  $("#pesearch").attr("action", hrefval);
//                  $("#pesearch").submit();
                    return false;
                    break;
           case 'investmentsvc':
                    var hrefval = 'index.php?value=1';
                    window.location.href = hrefval;
//                    $("#pesearch").attr("action", hrefval);
//                    $("#pesearch").submit();
                    return false;
                    break;
            
       }
    });
    
    $('#exitswitch').change(function(event){
       
       navvalue=$(this).val();
       switch(navvalue)
       {
           case '1':
                window.location.href = 'mandaindex.php?value=0-0';
                break;
           case '0':
                window.location.href = 'mandaindex.php?value=1-0';
                break;
            
       }  

});

// available options:
// 
// .switchify()
// => default (builds new switch widget)
// .switchify('update')
// => update the cached position of the widget
// .switchify({ on: "1", off: "0" })
// => specify the vals for "on" and "off"

   <?php if($_SESSION['peonly']==1){ ?>
                $(document).ready(function(){  
                $("#investmentsvc").hide();                
                $("#investmentsspecialised").show();
                $("#investmentspe").show();
                });
   <?php } 
        else if($_SESSION['vconly']==1){ ?>
                $(document).ready(function(){  
                $("#investmentspe").hide();                
                $("#investmentsspecialised").hide();
                $("#investmentsvc").show();
                });
   <?php } ?>
</script> 