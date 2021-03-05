<?php
// require("../dbconnectvi.php");
// 	$Db = new dbInvestments();
    include ('checklogin.php');  
    ?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Venture Intelligence</title>
<link href="<?php echo $refUrl; ?>css/re_skin.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="<?php echo $refUrl; ?>css/detect800.css" />

<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery-1.8.2.min.js"></script> 
<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="<?php echo $refUrl; ?>js/popup.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="<?php echo $refUrl; ?>/resources/demos/style.css" />

<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.multiselect.js"></script> 
  <script type="text/javascript" src="<?php echo $refUrl; ?>js/expand.js"></script>
 <script src="<?php echo $refUrl; ?>js/showHide.js" type="text/javascript"></script>
 <script src="<?php echo $refUrl; ?>js/jquery.flexslider.js"></script>
<script src="<?php echo $refUrl; ?>js/jquery.masonry.min.js"></script>
 <script type="text/javascript">

$(document).ready(function(){


   $('.show_hide').showHide({			 
		speed: 500,  // speed you want the toggle to happen	
		easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
		changeText: 1, // if you dont want the button text to change, set this to 0
		showText: 'View Table',// the button text to show when a div is closed
		hideText: 'Close Table' // the button text to show when a div is open
					 
	}); 
     $("#slidingDataTable").show();
     $('.show_hide').addClass("active");
	$(".btn-slide").click(function(){
            $("#panel").animate({width: 'toggle'}, 200); 
            $(this).removeClass("active"); 

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
	$("#myTable").tablesorter({widthFixed: true}); 
	$("div.holder").jPages({
	  containerID : "movies",
	  previous : "�? Previous",
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
    
  $(window).scroll(function(){
                            if ($(this).scrollTop() > 100) {
                                $('.scrollup').fadeIn();
                               // alert("Adsasd");
                            } else {
                                $('.scrollup').fadeOut();
                            }
                        }); 

                        $('.scrollup').click(function(){
                           // alert("asda");
                            $("html, body").animate({ scrollTop: 0 }, 600);
                            return false;
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

$('.typeoff-nav').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
        window.location.assign("dashboard.php?type=1");
    }
    else if (value == 2) {
        window.location.assign("dashboard.php?type=2");
    }
    else if (value == 3) {
        window.location.assign("dashboard.php?type=3");
    }
    else if (value == 4) {
        window.location.assign("dashboard.php?type=4");
    }
    else if (value == 5) {
        window.location.assign("dashboard.php?type=5");
    }
    else if (value == 6) {
        window.location.assign("dashboard.php?type=6");
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
<script type="text/javascript" src="//www.google.com/jsapi"></script>
    <script type="text/javascript">
      google.load('visualization', '1', {packages: ['corechart']});
    </script>
<style type="text/css">
                
                .scrollup{
                        width:58px;
                        height:58px;
                        opacity:0.3;
                        position:fixed;
                        cursor: pointer;
                        bottom:80px;
                        right:30px;
                        display:none;
                        text-indent:-9999px;
                        background: url(images/up_arrow.png) no-repeat;
                        z-index: 8000;
                    }
                    .scrollup:hover{opacity:1;}
                
/*                .mylist{margin: 5px;padding: 0;display: block;}
                .mylist li{border-right:#867979 solid thin;padding: 1px;}
                */
                
            </style>
</head>

<?php if($_SESSION['RE_TrialLogin']==1){ ?>
<body > 
<?php }else { ?>
<body ondragstart="return false" onselectstart="return false" oncontextmenu="return false" oncopy="return false" onpaste="return false" oncut="return false"> 
<?php } ?>
    <a href="#" class="scrollup">Scroll</a>
    <div id="maskscreen" ></div>
<div id="preloading"></div>
<script type="text/javascript" >
$('#maskscreen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
jQuery(window).load(function(){
jQuery('#preloading').fadeOut(3000);
jQuery('#maskscreen').fadeOut(3000);
});
</script>
    <?php //include_once('definitions.php');?>
    <?php //include_once('refinedef.php');?>
<!--Header-->
<?php 
    $actionlink="dashboard.php?type=".$_GET['type'];

?>

<form name="searchall" action="<?php echo $actionlink; ?>" method="post" id="searchall">    
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="reindex.php"><img src="<?php echo $refUrl; ?>images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>


<td class="right-box">
<?php include('top_menu.php'); ?>
<!-- <ul class="tour-lock">
<li <?php //echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php //echo ($topNav=='Deals') ? 'class="active"' : '' ; ?>><a href="javascript:void(0)" class="popup_call" data-url="reindex.php"><i class="i-data-deals"></i>Deals</a></li>
<li <?php //echo ($topNav=='Directory') ? 'class="active"' : '' ; ?>><a href="redirview.php"><i class="i-directory"></i>Directory</a></li>
<li <?php //echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a href="refunds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
</ul> -->
<ul class="fr">
     <!-- <li class="classic-btn"><a href="http://www.ventureintelligence.com/review/rehome.php" >Classic View</a></li> -->
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
                        
			<li><a href="changepassword.php?value=P">Change Password</a></li>
                        <li><a href="logoff.php?value=R">Logout</a></li>
		</ul>
	</div>
<?php } ?></li>
</ul>
</td>
</tr>
</table>

</div>
</form>

<form name="reinvestment" action="<?php echo $actionlink; ?>" method="post" id="pesearch">  
<?php
$passwrd = $_GET['value'];
if($passwrd != 'P')
{
?>
<div id="sec-header" class="sec-header-fix">
<table cellpadding="0" cellspacing="0">
<tr>
<?php
 //print_r($_POST);
    $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 1;
    ?>
<td class="investment-form" style="display:flex;">
<h3>Types</h3>
<label><input class="typeoff-nav" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
<label><input class="typeoff-nav" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
<label><input class="typeoff-nav" name="typeoff" type="radio" value="6" <?php if($type==6) { ?> checked="checked" <?php } ?>/>Region</label>
</td> 
</tr>
</table>
</div>
<?php
}
?>
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