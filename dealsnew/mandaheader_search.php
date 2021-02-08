<?php include_once("../globalconfig.php"); require_once("../dbconnectvi.php");
$Db = new dbInvestments();
if(!isset($_SESSION['UserNames']))
{
        header('Location:../pelogin.php');
}
else
{?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Venture Intelligence</title>
<link href="css/skin_1.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="css/detect800.css" />
  <!-- Global site tag (gtag.js) - Google Analytics -->
  <script async src="https://www.googletagmanager.com/gtag/js?id=UA-168374697-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-168374697-1');
</script>
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<link rel="stylesheet" type="text/css" href="css/token-input.css" />
<link rel="stylesheet" type="text/css" href="css/token-input-facebook.css" />
<script type="text/javascript" src="js/jquery.tokeninput.js"></script> 
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script src="js/jPages.js"></script>
<script type="text/javascript" src="js/popup.js"></script>
<script src="js/jquery.icheck.min.js?v=0.9.1"></script>

<link href="hopscotch.min.css" rel="stylesheet"></link>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
<script type="text/javascript" src="js/jquery.multiselect.js"></script> 
<link rel="stylesheet" type="text/css" href="css/jquery.multiselect.filter.css" />
<script type="text/javascript" src="js/jquery.multiselect.filter.js"></script>
<script type="text/javascript" src="js/expand.js"></script>

<script src="js/showHide.js" type="text/javascript"></script>
<script src="js/jquery.flexslider.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<script src="hopscotch.js"></script>
 <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>
<!--<script src="js/switch.min.js" type="text/javascript"></script>
 <link href="css/switch.css" type="text/css" rel="stylesheet">-->
<style type="text/css">
.com-wrapper {
    height: 100%;
    width: 100%;
    margin: 0 auto;
    font-family: "Trebuchet MS", Arial, Helvetica, sans-serif, calibri, Helvetica;
}
</style>
<?php if($tour!='Allow'){ ?>
<script src="TourStart.js"></script> 
<?php } ?>
 

<script src="js/jquery.responsivetable.js"></script>
<script>
$(document).ready(function() {
$('.testTable1').responsiveTable( {scrollRight: false, scrollHintEnabled: false} ); 
});
</script>
<script type="text/javascript">
     
     $(document).ready(function(){
       $('.show_hide').showHide({			 
		speed: 800,  // speed you want the toggle to happen	
		easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
		changeText: 1 // if you dont want the button text to change, set this to 0
		
					 
	}); 
        
       <?php if($tourpage!='mandaindex'){ ?>
               $(".btn-slide").click(function(){
            $("#panel").animate({width: 'toggle'}, 200); 
            $(this).toggleClass("active"); 

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
       <?php } ?>
           
    });
     
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
           //keywordsearchbox.combobox("destroy") ;
           $("#investorauto_sug").tokenInput("clear",{focus:false});
           clear_companysearch();
           clear_acquirersearch();
           clear_sectorsearch();
           
           companysearchbox.combobox("destroy") ;
           advisorsearch_legalbox.combobox("destroy") ;
           advisorsearch_transbox.combobox("destroy") ;
           sectorsearchbox.combobox("destroy") ; 
           
           //$("#keywordsearch option:eq(0)").attr('selected','selected');
           $("#combobox option:eq(0)").attr('selected','selected');
           $("#advisorsearch_legal option:eq(0)").attr('selected','selected');
           $("#advisorsearch_trans option:eq(0)").attr('selected','selected');
           $("#sectorsearch option:eq(0)").attr('selected','selected');
           $("#acquirersearch").val("");
           //keywordsearchbox.combobox();
           companysearchbox.combobox() ;
           advisorsearch_legalbox.combobox() ;
           advisorsearch_transbox.combobox() ;
           sectorsearchbox.combobox() ;
           
        });
        
 
        
  });
 

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
//	$("#myTable").tablesorter({widthFixed: true}); 
//	$("div.holder").jPages({
//	  containerID : "movies",
//	  previous : "�? Previous",
//	  next : "Next →",
//	  perPage : 50,
//	  delay : 20
//	});
});

/*$(function(){
	$("#myTable").tablesorter(); 
	$("div.holder").jPages({
	  containerID : "movies",
	  previous : "�? Previous",
	  next : "Next →",
	  perPage : 20,
	  delay : 20
	});
});*/
 
$(document).ready(function(){
 
  
  $('input').iCheck({
	checkboxClass: 'icheckbox_flat-red',
	radioClass: 'iradio_flat-red'
  });
  $(".popup").LePopup({

		skin : "big-shadow"
           });
     $("#disselect").find(':input').prop("disabled", true);
     $(document).on('ifChecked', '.investment-nav', function(event){
         
          if(EXITSdemotour==1){
                    showErrorDialog(warmsg);
                     return false;
                }
                
         
       navvalue=$(this).val();
       switch(navvalue)
       {
           case '0':
                   window.location.href = 'index.php?value='+$(this).val();
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
       }
       

});

$(document).on('ifChecked', '.exist-nav', function(event){
        
       
       navvalue=$(this).val();
        var current_tour = hopscotch.getCurrStepNum();
        
     
        
        if(EXITSdemotour==1 && current_tour!=13){
                    showErrorDialog(warmsg);
                     return false;
                }                
        else if(EXITSdemotour==1 && current_tour==13){
            
            if(navvalue!='PMS') { showErrorDialog(warmsg); return false; }            
        }        
       
       
       switch(navvalue)
       {
           case 'PE-BACKED-IPO':
                   window.location.href = 'ipoindex.php?value=0';
                   break;
           case 'VC-BACKED-IPO':
                   window.location.href = 'ipoindex.php?value=1';
                   break;
           case 'PMS':
                   var hrefval = 'mandaindex.php?value=0-1';
                   window.location.href = hrefval;
                   return false;
                   break;
           case 'VCPMS':
                   var hrefval = 'mandaindex.php?value=1-1';
                   window.location.href = hrefval;
                   return false;
                   break;       
           case 'PE-EXIST':
                    var hrefval = 'mandaindex.php?value=0-0';
                    window.location.href = hrefval;  
                    return false;
                    break;
           case 'VC-EXIST':
                    var hrefval = 'mandaindex.php?value=1-0';
                    window.location.href = hrefval;
                    return false;
                    break;
               
       }
      
});

$(document).on('ifChecked', '.typeoff-nav', function(event){
     
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
	else if (value == 7) {
        window.location.assign("trendview.php?type=6");
    }
});
$(document).on('ifChecked', '.typeoff-nav20', function(event){
      $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
     var value = $(this).val();
      if (value == 1) {
          var hrefval = 'mandaindex.php?type=1&value=0-1';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("mtrendview.php?type=1&value=0-1");
    }
    else if (value == 2) {
        var hrefval = 'mandaindex.php?type=2&value=0-1';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("mtrendview.php?type=2&value=0-1");
    }
    else if (value == 4) {
        var hrefval = 'mandaindex.php?type=4&value=0-1';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("mtrendview.php?type=4&value=0-1");
    }
    else if (value == 5) {
        var hrefval = 'mandaindex.php?type=5&value=0-1';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("mtrendview.php?type=5&value=0-1");
    }
	else if (value == 7) {
        var hrefval = 'mandaindex.php?type=7&value=0-1';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("mtrendview.php?type=5&value=0-1");
    }
});
$(document).on('ifChecked', '.typeoff-nav21', function(event){
      $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
     var value = $(this).val();
      if (value == 1) {
           var hrefval = 'mandaindex.php?type=1&value=0-0';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
       // window.location.assign("mtrendview.php?type=1&value=0-0");
    }
    else if (value == 2) {
         var hrefval = 'mandaindex.php?type=2&value=0-0';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("mtrendview.php?type=2&value=0-0");
    }
    else if (value == 4) {
         var hrefval = 'mandaindex.php?type=4&value=0-0';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("mtrendview.php?type=4&value=0-0");
    }
    else if (value == 5) {
         var hrefval = 'mandaindex.php?type=5&value=0-0';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
       // window.location.assign("mtrendview.php?type=5&value=0-0");
    }
});
$(document).on('ifChecked', '.typeoff-nav22', function(event){
      $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
     var value = $(this).val();
      if (value == 1) {
           var hrefval = 'mandaindex.php?type=1&value=1-0';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
       // window.location.assign("mtrendview.php?type=1&value=1-0");
    }
    else if (value == 2) {
         var hrefval = 'mandaindex.php?type=2&value=1-0';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
       // window.location.assign("mtrendview.php?type=2&value=1-0");
    }
    else if (value == 4) {
         var hrefval = 'mandaindex.php?type=4&value=1-0';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("mtrendview.php?type=4&value=1-0");
    }
    else if (value == 5) {
         var hrefval = 'mandaindex.php?type=5&value=1-0';
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
       // window.location.assign("mtrendview.php?type=5&value=1-0");
    }
});
});


$(document).ready(function() {
  $(".datesubmit").click(function() {
      
    var year1=$('#year1').val();
    var year2=$('#year2').val();
     
    var month1=$('#month1').val();
    var month2=$('#month2').val();
        
    
    
    
      if(EXITSdemotour==1)
                {
                    
                    if(hopscotch.getCurrStepNum()==14) { var m1=7; var m2=9; var y1=2014; var y2=2014; }
                    else { var m1=4; var m2=6; var y1=2013; var y2=2013;}
                    
                    if(month1==m1 && month2==m2 && year1==y1 && year2==y2)
                    { 
                        $("#pesearch").submit();
                    }
                    else
                        {
                            showErrorDialog(warmsg);
                            return false;
                        }
                }
                
                
        
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

function checkForDate()
{
	var year1=$('#year1').val();
	var year2=$('#year2').val();
        
        var month1=$('#month1').val();
        var month2=$('#month2').val();
	
        
         if(EXITSdemotour==1)
                {
                    if(hopscotch.getCurrStepNum()==14) { var m1=7; var m2=9; var y1=2014; var y2=2014; }
                    else { var m1=4; var m2=6; var y1=2013; var y2=2013;}
                    
                    if(month1==m1 && month2==m2 && year1==y1 && year2==y2)
                    { 
                        $("#pesearch").submit();
                    }
                    else
                        {
                            showErrorDialog(warmsg);
                            return false;
                        }
                }
                
                
	
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

function checkForAggregates()
{
	document.ipo.hiddenbutton.value='Aggregate';
	document.ipo.submit();
}
  //' Allow user to enter only numbers  , - (minus) and .(dot) eg. -1.2    45- mindus
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

             var num1 = document.pesearch.txtmultipleReturnFrom.value;
             var num2 = document.pesearch.txtmultipleReturnTo.value;
             var x  = parseInt( num1  ,  10  )
             var y  = parseInt( num2  ,  10  )
             if(x > y)
                { 
                  alert("Please enter valid range");
                  document.pesearch.txtmultipleReturnTo.focus();
                  return false;
                }
               

           }

function checkFields()
 {
 	var selection = false;
 	var keyselection=false;
 //alert(document.ipo.industry.selectedIndex);
  if ((document.ipo.keywordsearch.value  != '') || (document.ipo.companysearch.value != ''))
    	  keyselection=true;
if (!keyselection)
{
  if (document.ipo.industry[document.ipo.industry.selectedIndex].value > 0)
   {
   	//alert ("comapny selected index > 0");
  	selection=true;
   }

 }
 	if((keyselection == true ) || (selection==true))
 		  {
 		  //	alert ("insie true");
 		   return true;
 		  // alert (selection);
 		  }
 	else
 		{
 		  alert("Search using keyword or choose inputs");
 		        return false;
		}
} 

</script>
<script type="text/javascript">
$(function(){
	$(".selectgroup select").multiselect();
  $(".selectgroup #sltsector,.selectgroup #sltsubsector").multiselect({ noneSelectedText: 'Select options', selectedList: 0, checkAllText: '',  uncheckAllText: ''}).multiselectfilter();

});
</script>
       <script type="text/javascript" src="//www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
       <style type="text/css">
         .restable div.table-wrapper div.scrollable { overflow: auto; overflow-y: hidden; }	
     </style>
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

.investment-form h3{
  opacity: 0.5;
}
.investment-form h3:hover{
  opacity: 1;
}

</style>
  
       
<script type="text/javascript">
                                                        
function industrypesearch()
{
    var sltindustry = $("#sltindustry").val();
       
     if(EXITSdemotour==1){
            if(sltindustry==1) {            
               $('#stage,#valuations').attr("disabled","disabled");
               $("#pesearch").submit(); 
            }
            else {  showErrorDialog(warmsg); return false; }
       }
       else
           {
               $("#pesearch").submit();
           }
                    
}


$(document).ready(function() {
  $("#tourlibtn").click(function(){
      $("#tourlist").show();
  });
});

$(document).mouseup(function (e)
{
    $("#tourlist").hide();
});




$(window).load(function(){
$('#searchall').submit(function () { 
    
     if(EXITSdemotour==1){
         var txt = $("#searchallfield").val();
         if(txt=='Justdial' || txt=='justdial') { $("#searchall").submit(); } else {  showErrorDialog(warmsg); return false; }
       } 
});

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
$('#maskscreen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
jQuery(window).load(function(){
jQuery('#preloading').fadeOut(1000);
jQuery('#maskscreen').fadeOut(1000);
});
</script>
 <?php 
  // oncontextmenu="return false;" oncopy="return false" oncut="return false" onpaste="return false"
                        $aggsql="";
                        $totalDisplay="";
                       /* $acquirersearch= $_POST['acquirersearch'];
                        $companysearch=$_POST['companysearch'];
                        $sectorsearch=$_POST['sectorsearch'];*/
                        if($companysearch!=="")
                        {
                                $splitStringCompany=explode(" ", trim($companysearch));
                                $splitString1Company=$splitStringCompany[0];
                                $splitString2Company=$splitStringCompany[1];
                                $stringToHideCompany=$splitString1Company. "+" .$splitString2Company;
                        }


                       // $investorsearch=$_POST['investorsearch'];
                        if($investorsearch!=="")
                        {
                                $splitStringInvestor=explode(" ", trim($investorsearch));
                                $splitString1Investor=$splitStringInvestor[0];
                                $splitString2Investor=$splitStringInvestor[1];
                                $stringToHideInvestor=$splitString1Investor. "+" .$splitString2Investor;
                        }
                        //$adcompanyacquirer=$_POST['adcompanyacquirersearch'];

                        /*$searchallfield=$_POST['searchallfield'];
                        $searchallfieldhidden=ereg_replace(" ","-",trim($searchallfield));*/
                        
                        
                          if(isset($_REQUEST['searchallfield_other'])){
                            $searchallfield=$_REQUEST['searchallfield_other'];
                           $searchallfieldhidden=ereg_replace(" ","_",$searchallfield);
                                            $month1=01; 
                                            $year1 = 1998;
                                            $month2= date('n');
                                            $year2 = date('Y');                                

                            }
                            
                           

                      /*  $advisorsearchstring_legal=$_POST['advisorsearch_legal'];
                        $advisorsearchhidden_legal=ereg_replace(" ","_",trim($advisorsearchstring_legal));

                        $advisorsearchstring_trans=$_POST['advisorsearch_trans'];
                        $advisorsearchhidden_trans=ereg_replace(" ","_",trim($advisorsearchstring_trans));*/

                //	echo "<br>Key word ---" .$keyword;
                      /*  $industry=$_POST['industry'];
						$type=$_POST['InType'];
                        if($_POST['dealtype'])
                                $dealtype=$_POST['dealtype'];
                        else
                                $dealtype="--";
                        //echo "<bR>--- ".$dealtype."***";

                        $investorType=$_POST['invType'];
                        $exitstatusvalue=$_POST['exitstatus'];
                        $startRangeValue="--";
                        $endRangeValue="--";*/
                       
						if($industry >0)
                        {
                                $industrysql= "select industry from industry where IndustryId=$industry";
                                if ($industryrs = mysql_query($industrysql))
                                {
                                        While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                                        {
                                                $industryvalue=$myrow["industry"];
                                        }
                                }
                        }
						
						
						
                        if($dealtype >0)
                                $dealtypesql= "select DealType from dealtypes where DealTypeId=$dealtype";
                        elseif(($dealtype=="--") && ($hide_pms==1))
                                $dealtypesql= "select DealType from dealtypes where hide_for_exit=".$hide_pms;
                        //echo "<Br>***** ".$dealtypesql;
                                if ($dealtypers = mysql_query($dealtypesql))
                                {
                                        While($myrow=mysql_fetch_array($dealtypers, MYSQL_BOTH))
                                        {
                                                $dealtypevalue=$myrow["DealType"];
                                        }
                                }

                                //echo "<bR>%%%%%%".$dealtypevalue;
                        if($investorType !="--")
                        {
                               $invTypeSql= "select InvestorTypeName from investortype where InvestorType='$investorType'";
                               if ($invrs = mysql_query($invTypeSql))
                               {
                                  While($myrow=mysql_fetch_array($invrs, MYSQL_BOTH))
                                  {
                                     $invtypevalue=$myrow["InvestorTypeName"];
                                  }
                               }
                        }
                        //echo "<br>**".$exitstatusvalue;
                        if($exitstatusvalue=="0")
                        {$exitstatusdisplay="Partial Exit"; }
                        //echo "<bR>111";}
                        elseif($exitstatusvalue=="1")
                        {$exitstatusdisplay="Complete Exit";}
                        //echo "<bR>222";}
                        elseif($exitstatusvalue=="--")
                        {$exitstatusdisplay=""; }
                        //echo "<bR>333";}
                        if(($startRangeValue != "--")&& ($endRangeValue != ""))
                        {
                         $startRangeValue=$startRangeValue;
                        $endRangeValue=$endRangeValue-0.01;
                        }

                        $aggsql= "select count(pe.MandAId) as totaldeals,sum(pe.DealAmount)
                                    as totalamount from manda as pe,industry as i,pecompanies as pec where";
        
	
        
                        $addhide_pms_qry=" and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=".$hide_pms;
			$getTotalQuery = "select count(MandAId) as totaldeals,sum(DealAmount)
			as totalamount from manda as ma,dealtypes as dt where Deleted=0" .$addVCFlagqry.$addhide_pms_qry ;

			//echo "<br>*(((( ".$getTotalQuery;

			if ($totalrs = mysql_query($getTotalQuery))
			{
			 While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
			   {
					$totDeals = $myrow["totaldeals"];
					$totDealsAmount = $myrow["totalamount"];
				}
			}

			$TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
			where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";
			//echo "<br>---" .$TrialSql;
			if($trialrs=mysql_query($TrialSql))
			{
				while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
				{
					$exportToExcel=$trialrow["TrialLogin"];
					$compId=$trialrow["compid"];
				}
			}
			
?>
     <?php 
     $defpage=$defvalue;
     $investdef = 1;
     $dealdef = 1;
     include_once('definitions.php');
     include_once('refinedef.php');?>
<!--Header-->
<!--<form name="searchall" id="searchall" action="mandaindex.php?value=<?php echo $flagvalue; ?>" method="post">-->
<form name="pesearch" id="pesearch" action="mandaindex.php?value=<?php echo $flagvalue; ?>" method="post"  >
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="index.php"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>


<td class="right-box">
     <?php include('top_menu.php'); ?>
<!--<ul class="tour-lock">
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active"' : '' ; ?>><a href="index.php"><i class="i-data-deals"></i>Deals</a></li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?>><a href="pedirview.php"><i class="i-directory"></i>Directory</a></li>
<li <?php echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a href="funds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
<!--li <?php echo ($topNav=='Report') ? 'class="active"' : '' ; ?>><a href="report.php"><i class="i-directory"></i>Report</a></li
</ul>-->
<ul class="fr">
      <!-- <li class="classic-btn tour-lock"><a href="http://www.ventureintelligence.com/deals/dealhome.php" >Classic View</a></li> -->
      
     <?php //include('TourStartbtn.php'); ?>
      
      
<li><div style="float:right;padding: 9px 15px" class="key-search"><b></b> <input type="text" name="searchallfield" id="searchallfield" placeholder="Search"
                                                                                      value="<?php if($searchallfield!="") echo $searchallfield; ?>"
                                                                                       style="padding:5px;"  /> 
        <input type="submit" name="fliter_stage" id="fliter_stage"  value="Go"  style="padding: 5px;"/>
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
                        <li><a href="logoff.php?value=P"></a></li> 
		</ul>
	</div>
<?php } ?></li>
</ul>
</td>
</tr>
</table>

</div>
<!--</form>
<form name="pesearch" id="pesearch" action="mandaindex.php?value=<?php echo $flagvalue; ?>" method="post"  >-->
<div id="sec-header" class="sec-header-fix">
<table cellpadding="0" cellspacing="0">
<tr>
<!-- <td class="investment-form">
<h3 class="ttl3">INVESTMENTS</h3>
<div class="investmentlabel frmDropDown" style="padding: 5px 30px 5px 0px;">
<div>
<label><input class="investment-nav" name="investments" type="radio" value=0  <?php if($flagvalue==0) { ?> checked="checked" <?php } ?>/> PE</label>
<label><input class="investment-nav" name="investments" type="radio" value=4  <?php if($flagvalue==4) { ?> checked="checked" <?php } ?>/>Cleantech</label>
<label><input class="investment-nav" name="investments" type="radio" value=5  <?php if($flagvalue==5) { ?> checked="checked" <?php } ?>/>Infrastructure</label>
<label><input class="investment-nav" name="investments" type="radio" value=1  <?php if($flagvalue==1) { ?> checked="checked" <?php } ?>/> VC</label>

<label><input class="investment-nav" name="investments" type="radio" value=2  <?php if($flagvalue==2) { ?> checked="checked" <?php } ?>/>Angel</label>

<label><input class="investment-nav" name="investments" type="radio" value=6  <?php if($flagvalue==6) { ?> checked="checked" <?php } ?>/>Incubation</label>
<label><input class="investment-nav" name="investments" type="radio" value=3  <?php if($flagvalue==3) { ?> checked="checked" <?php } ?>/>Social VC</label>
</div> -->

<!--<div id="invspecialisedsocial" class="">
</div>-->

<!-- <div id="investmentsspecialised" class="">
<label><input class="investment-nav" name="investments" type="radio" value=4  <?php if($flagvalue==4) { ?> checked="checked" <?php } ?>/>Cleantech</label>
<label><input class="investment-nav" name="investments" type="radio" value=5  <?php if($flagvalue==5) { ?> checked="checked" <?php } ?>/>Infrastructure</label></div> -->
<!-- </div>

</td>

    
 <td class="exit-form">
<h3 class="ttl3">EXITS </h3>
<div class="exitslabel frmDropDown">
<div >

<label id="exits_ma_tour"><input class="exist-nav" name="investments" type="radio" value="PE-EXIST" <?php if($flagvalue=="0-0") { ?> checked="checked" <?php } ?>/>M&A(PE) </label>
<label id="exits_public_tour"><input class="exist-nav" name="investments" type="radio" value="PMS" <?php if($flagvalue==="0-1") { ?> checked="checked" <?php } ?>/> Public Market(PE)</label>
<label  id="ipo_public_tour"><input class="exist-nav" name="investments" type="radio" value="PE-BACKED-IPO" <?php if($vcflagValue=="7") { ?> checked="checked" <?php } ?>/>IPO(PE)</label>
<label><input class="exist-nav" name="investments" type="radio" value="VC-EXIST" <?php if($flagvalue==="1-0") { ?> checked="checked" <?php } ?>/>M&A(VC) </label>
<label><input class="exist-nav" name="investments" type="radio" value="VCPMS" <?php if($flagvalue==="1-1") { ?> checked="checked" <?php } ?>/> Public Market(VC)</label>
<label><input class="exist-nav" name="investments" type="radio" value="VC-BACKED-IPO" <?php if($vcflagValue=="8") { ?> checked="checked" <?php } ?>/>IPO(VC)</label>
</div>
</div>
</td>  -->
<?php
if(trim($_POST['investorsearch'])!="" || trim($_POST['acquirersearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
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
    <?php
     if($_GET['value']=='0-0' || $strvalue[1]=='0-0'){ ?>
        <!-- <h3 id="investmenttype">EXITS - M&A(PE)</h3> -->
        <h3 id="investmenttype">Exits <span style="padding-left: 2px;padding-right: 2px;">></span> M&A(PE)</h3>
    <?php }elseif($_GET['value']=='0-1' || $strvalue[1]=='0-1'){ ?>
        <h3 id="investmenttype">Exits <span style="padding-left: 2px;padding-right: 2px;">></span> Public Market(PE)</h3>
    <?php }elseif($_GET['value']=='1-0' || $strvalue[1]=='1-0'){ ?>
        <h3 id="investmenttype">Exits <span style="padding-left: 2px;padding-right: 2px;">></span> M&A(VC)</h3>
    <?php }elseif($_GET['value']=='1-1' || $strvalue[1]=='1-1'){ ?>
        <h3 id="investmenttype">Exits <span style="padding-left: 2px;padding-right: 2px;">></span> Public Market(VC)</h3>
    <?php } elseif($_GET['value']=='0-2' || $strvalue[1]=='0-2'){ ?>
        <h3 id="investmenttype">Exits <span style="padding-left: 2px;padding-right: 2px;">></span> M&A and Public Market(PE)</h3>
    <?php } ?>
<div style="float: right;" class="sort-by-date">
<!-- <h3>PERIOD</h3> -->

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

<SELECT NAME="year1" id="year1">
    <OPTION id=2 value=""> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( DealDate, '%Y') as Year from manda order by DealDate desc";
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
			}	*/
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

<SELECT NAME="year2" id="year2" onchange="checkForDate();">
    <OPTION id=2 value=""> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( DealDate, '%Y') as Year from manda order by DealDate desc";
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
			}	*/
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

<div class="search-btn"> <input name="searchpe" type="submit" value="Search" class="datesubmit" id="datesubmit"/></div>
</div>
</td>
</tr>
</table>
</div>
    
     <script>
      $( document ).ready( function() {
      meta();
    });
      function meta() {
      if( $(window).width() < 768 ) {
        $("meta[name='viewport']").attr("content", "width=device-width, initial-scale=0");
      }
      else {
         $("meta[name='viewport']").attr("content", "width=device-width, initial-scale=1.0"); 
      }
    } 
   <?php if($flagvalue==="0-1" || $flagvalue=="0-0") { ?> 
 $("#exitsviape").show();  
        $("#exitsviavc").hide();
    
<?php } else if($flagvalue==="1-0" || $flagvalue==="1-1" ) { ?>
      $("#exitsviape").hide();  
      $("#exitsviavc").show();
<?php } ?>
    
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



    
<?php if(isset($_SESSION["EXITSdemoTour"]) && $_SESSION["EXITSdemoTour"]=='1' && $_POST['tourlistview']!='startstep14') {    
    ?>  
        $(document).ready(function(){  
     
        <?php if($_GET["value"]=='0-0' || $_GET["value"]=='1161888502/0-0/'){?>
        $("#exits_public_tour,#ipo_public_tour").click(function() {     
        if(EXITSdemotour==1)
         { 
                        
            $('#exits_public_tour div').removeClass("checked"); 
            $('#ipo_public_tour div').removeClass("checked"); 
            $('#exits_ma_tour div').addClass("checked"); 
            
             
         }
         });
        <?php } ?> 
            
            
        <?php if($_GET["value"]=='0-1'){?>
        $("#exits_ma_tour,#ipo_public_tour").click(function() {     
        if(EXITSdemotour==1)
         { 
            $('#exits_ma_tour div').removeClass("checked");
            $('#ipo_public_tour div').removeClass("checked");
            $('#exits_public_tour div').addClass("checked");          
         }
         });
        <?php } ?>     

        });
 <?php } ?>

    $("#fliter_stage").click(submitSearchRemove);
               
    $('#searchallfield').on('keyup', function(e){
        if(e.which == 13) {
            e.preventDefault();
            $("#fliter_stage").trigger('click');
        }

    });

    function submitSearchRemove(){

         $('#hide_company_array').val('');
         $('#pe_checkbox_disbale').val('');
         $('#pe_checkbox_enable').val('');
         $('#all_checkbox_search').val('');

         $('#total_inv_deal').val('');
         $('#total_inv_amount').val('');
         $('#total_inv_company').val('');
         $("#tagsearch").val("");
                    $('#tagsearch_auto').val("");
         $('#real_total_inv_deal').val('');
         $('#real_total_inv_amount').val('');
         $('#real_total_inv_company').val('');
        this.form.submit();
    }
    
 $(".ttl3").click(function() {
      $(this).toggleClass('active').next('.frmDropDown').toggleClass("active");
   });
   $(document).ready(function(){
                $(".sectorlist").parent().prev().find('ul').css("display","none");
                $(".subsectorlist").parent().prev().find('ul').css("display","none");
               });
</script>
<?php } ?>



