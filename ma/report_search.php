<?php include_once("../globalconfig.php");
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
include ('machecklogin.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"> 
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Venture Intelligence</title>
<link href="<?php echo $refUrl; ?>css/skin.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="<?php echo $refUrl; ?>css/detect800.css" />
<link href="hopscotch.min.css" rel="stylesheet"></link>
<!--<link href="bootstrap.css" rel="stylesheet"></link>-->
<!--<link href="flat-ui.css" rel="stylesheet"></link>-->
<link href="demo.css" rel="stylesheet"></link>

<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery-1.8.2.min.js"></script> 
<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="<?php echo $refUrl; ?>js/popup.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.multiselect.js"></script> 
  <script type="text/javascript" src="<?php echo $refUrl; ?>js/expand.js"></script>
 <script src="<?php echo $refUrl; ?>js/showHide.js" type="text/javascript"></script>
 <script src="<?php echo $refUrl; ?>js/jquery.flexslider.js"></script>
<script src="<?php echo $refUrl; ?>js/jquery.masonry.min.js"></script>
<style type="text/css">
    .ui-widget-overlay{z-index: 2000 !important;}
    .ui-dialog{position: fixed !important;z-index: 2001 !important;}
</style>        
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
              hopscotch.startTour(tour, 6);   
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
//	  previous : "???? Previous",
//	  next : "Next ???",
//	  perPage : 50,
//	  delay : 20
//	});
});
    $(document).ready(function(){
         // var  totlen=$('.cbox').length;
          var  checklen=$('.cbox:checked').length
        //   alert(checklen);
//            if (checklen <= 2) {
//            $("#checksearch").show();
//        } else {
//            $("#checksearch").hide();
//        }
        totlen=$('[name="dealtype[]"]').length;
        checklen=$('[name="dealtype[]"]:checked').length;
           if(checklen==0)
               $('#checksearch').hide();
           else
               $('#checksearch').show();
           
        $('input').on('ifChecked', function(event){
            totlen=$('[name="dealtype[]"]').length;
            checklen=$('[name="dealtype[]"]:checked').length;
           if(checklen==0){
               $('#checksearch').hide();
               if(demotour==1){
                 hopscotch.showStep(1);
               }
           }
           else{
              
                if(demotour==1){
                  var isDomestic=0;
                    $('[name="dealtype[]"]:checked').each(function(){
                    if($(this).val()=='3')
                        isDomestic=1;
                    });
                    if(isDomestic==1){
                            $('#checksearch').show();
                            hopscotch.showStep(2);
                    }
                }else{
                     $('#checksearch').show();
                }
               
           }
          });
          $('input').on('ifUnchecked', function(event){
                totlen=$('[name="dealtype[]"]').length;
                checklen=$('[name="dealtype[]"]:checked').length;
                if(checklen==0)
                {
                    $('#checksearch').hide();
                    if(demotour==1){
                        showErrorDialog("Please leave domestic deals checked for the purpose of the tour");
                        hopscotch.showStep(1);
                    }
                    else{
                        alert("Please select atleast one Deal Type to Search");
                    }
                    event.stopPropagation();
                    return false;
                }else{
                    
                    if(demotour==1){
                        var isDomestic=0;
                        $('[name="dealtype[]"]:checked').each(function(){
                        if($(this).val()=='3')
                            isDomestic=1;
                        });
                        if(isDomestic==1){
                            $('#checksearch').show();
                            hopscotch.showStep(2);
                        }else{
                            $('#checksearch').hide();
                            hopscotch.showStep(1);
                            showErrorDialog("Please leave domestic deals checked for the purpose of the tour");
                        }
                    }else{
                        $('#checksearch').show();
                    }
                }
          }); 
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
	
        $("#resetall").click(function (){
           
            $('#companysearch').attr("value","");
            $('#assectorsearch').attr("value","");
            $('#askeywordsearch').attr("value","");
           $('#asadvisorsearch_legal').attr("value","");
           $('#asadvisorsearch_trans').attr("value","");
           
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



$('.typeoff-nav2').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
           var hrefval = 'index.php?type=1';
                    $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=1&value=0");
    }
    else if (value == 2) {
         var hrefval = 'index.php?type=2';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=2&value=0");
    }
    else if (value == 4) {
         var hrefval = 'index.php?type=4';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=4&value=0");
    }
    else if (value == 5) {
                     var hrefval = 'index.php?type=5';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=5&value=0");
    }
    else if (value == 6) {
                     var hrefval = 'index.php?type=6';
                     $('<input>').attr({type: 'hidden',id: 'searchallfield',name: 'searchallfield',value:'<?php echo $searchallfield; ?>'}).appendTo('#pesearch');
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
        //window.location.assign("trendviewlatest.php?type=6&value=0");
    }
});
});

$(document).ready(function() {
  $(".datesubmit").click(function() {
      
        
	var year1=$('#year1').val();
	var year2=$('#year2').val();
        
        var month1=$('#month1').val();
        var month2=$('#month2').val();
	
	if(month1=="--" || year1=="--" || month2=="--" || year2=="--")
	{
            return false;
        }
        else if(year1 > year2)
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
                $("#controlName").val("dealperiod");
                $("#pesearch").submit();
            }
        }
	else
	{
               
                $("#controlName").val("dealperiod");
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
                $("#controlName").val("dealperiod");
                $("#pesearch").submit();
            }
        }
	else
	{
                $("#controlName").val("dealperiod");
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
top: 298,
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



/*var nav = $('#navTable');
var isTFixed = false;
alert(scrollTop);
alert(navHomeY);
var tableBeFixed = scrollTop > navHomeY+500;
if (tableBeFixed && !isTFixed) {
nav.css({
position: 'fixed',
top: 298,
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
}*/

});
});
</script>

<!--<script type='text/javascript'>
$(function() {
// Stick the #nav to the top of the window
var nav = $('#navTable');
var navTableY = nav.offset().top;
alert(navTableY);
var isFixed = false;
var cntheight = $('.result-cnt').height();
var secheight = $('.sec-header-fix').height();
var headheight = $('#header').height();
var totheight=cntheight+secheight+headheight;
var $w = $(window);
$w.scroll(function() {
var scrollTop = $w.scrollTop();

scrollTop=scrollTop+totheight;
//alert(scrollTop);
//alert(navHomeY);
var shouldBeFixed = scrollTop > navHomeY;


if (shouldBeFixed && !isFixed) {
nav.css({
position: 'fixed',
top: 298,
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
</script>-->
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

<body ondragstart="return false" onselectstart="return false" oncontextmenu="return false" oncopy="return false" onpaste="return false" oncut="return false">
    <div id="maskscreen" ></div>
<div id="preloading"></div>
<script type="text/javascript" >
$('#maskscreen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
jQuery(window).load(function(){
jQuery('#preloading').fadeOut(3000);
jQuery('#maskscreen').fadeOut(3000);
});
</script>
    <?php include_once('definitions.php');?>
    <?php include_once('marefinedef.php');?>
<!--Header-->
<?php
    $actionlink="report.php";
?>

<form name="searchall" action="<?php echo $actionlink; ?>" method="post" id="searchall"> 

<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="index.php"><img src="<?php echo $refUrl; ?>images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>


<td class="right-box">
    <ul class="tour-lock">
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?> id="dashboardmenu"><a href="madashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active"' : '' ; ?> id="dealsmenu"><a href="javascript:void(0)" class="popup_call" data-url="index.php"><i class="i-data-deals"></i>Deals</a></li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?> id="directorymenu"><a href="pedirview.php"><i class="i-directory"></i>Directory</a></li>
</ul>
<ul class="fr">
   
     <li class="classic-btn classic-link"><a href="<?php echo GLOBAL_BASE_URL; ?>deals/madealsearch.php" >Classic View</a></li>
<!--     <li class="classic-btn"><input  type="button" id="startTourBtn" value="Start Tour" /></li>-->
<li ><div style="float:right;padding: 9px 15px" class="key-search"><b></b> <input  autofocus="autofocus" type="text" name="searchallfield" placeholder=" Keyword Search"
                                                                                      <?php if($searchallfield!="") echo "value='".$searchallfield."'" ;?>
                                                                                       style="padding:5px;"  /> 
        <input type="button" name="fliter_stage" value="Go" onclick="this.form.submit();" style="padding: 5px;"/>
    </div></li>
<?php if($_SESSION['student']!="1") { ?>
    <li class="user-avt"><span class="example" data-dropdown="#myaccount"> Welcome  <?php echo $username; ?></span>
<?php } else {?>
        <li class="user-avt"><span class="studentlogin" data-dropdown="#myaccount"> Welcome  <?php echo $username; ?></span>
<?php } ?>
<?php if($_SESSION['student']!="1") { ?>
<div id="myaccount" class="dropdown" style="left:inherit !important; max-width: 250px !important;">
		<ul class="dropdown-menu">
                        <li class="o_link"><a href="../pelogin.php" target="_blank">PE/VC Deals Database</a></li>
                        <li class="o_link"><a href="../relogin.php" target="_blank">PE in Real Estate Database</a></li>
                        <li class="o_link"><a href="../cfsnew/login.php" target="_blank">Company Financials Database</a></li>
                        
			<li><a href="changepassword.php?value=P">Change Password</a></li>
                        <li><a href="logoff.php?value=M">Logout</a></li>
		</ul>
	</div>
<?php } ?></li>
</ul>
</td>
</tr>
</table>

</div>
</form>

<form name="pesearch" action="<?php echo $actionlink; ?>" method="post" id="pesearch">
<input type="hidden" id="controlName"  name="controlName"  value=""  />
<input type="hidden" id="demoTour"  name="demoTour"  value="0"  />
<?php
$passwrd = $_GET['value'];
if($passwrd != 'P')
{
?>
<div id="sec-header" class="sec-header-fix">
<table cellpadding="0" cellspacing="0">
<tr>
   
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
    <OPTION id=2 value="--"> Year </option>
    <?php 
		$yearsql="select distinct DATE_FORMAT( DealDate, '%Y') as Year from mama order by DealDate desc";
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
                        While($i>= 2004 )
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

<SELECT NAME="year2" id="year2"  id='year2'>
    <OPTION id=2 value="--"> Year </option>
    <?php 
		/*$yearsql="select distinct DATE_FORMAT( DealDate, '%Y') as Year from mama order by DealDate asc";
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
                While($i>= 2004 )
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
 <div id="dealsubmit"> <input name="repType" type="button" value="Search" class="datesubmit" /></div>
</td>
    
</tr>
</table>
</div>
<?php
}
?>

<script>
    
    function setCurControl(control)
    {       
        if(control=="industry" && demotour=='1')
        {
            if($("#industry").val()=="<?php  echo $tourIndustryId;?>")
            {
                 $("#controlName").val(control);
                 $("#pesearch").submit();
                 return true;
            }else
                {
                    showErrorDialog('Click on the industry tab and select "<?php echo $tourIndustryName;?>" to proceed further');
                    return false;
                }
        } else{
           $("#controlName").val(control);
           $("#pesearch").submit();
        }
    }
    //var $cBoxes = $('#1,#2,#3');
   /* $('#checksearch').attr("disabled",true);
$(".cbox").click(function(){
    alert("ddddddddddddd");
    $('#checksearch').attr('disabled', $('.cbox:checked').length >2);//submit will be disabled as per the boolean value of condition
});
    
    function evaluate(){
        
    var item = $(this);
    var relatedItem = $("#" + item.attr("data-related-item")).parent();
 if(item.is(":checked")){
        relatedItem.fadeIn();
    }else{
        relatedItem.fadeOut();   
    }

   $('.cbox').click(function() {
        if ( $('.cbox:checked').length <= 2) {
            $("#checksearch").show();
        } else {
            $("#checksearch").hide();
        }
    }); 
}

$('input[type="checkbox"]').click(evaluate).each(evaluate);*/
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