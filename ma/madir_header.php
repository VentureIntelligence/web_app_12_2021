<?php include_once("../globalconfig.php"); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
   <!-- Global site tag (gtag.js) - Google Analytics -->
   <script async src="https://www.googletagmanager.com/gtag/js?id=UA-168374697-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-168374697-1');
</script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Venture Intelligence</title>
<?php $refUrl = "../dealsnew/"; ?>
<link href="<?php echo $refUrl; ?>css/ma_skin.css" rel="stylesheet" type="text/css" />  
<link href="<?php echo $refUrl; ?>css/popstyle.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="<?php echo $refUrl; ?>css/detect800.css" />

<link href="hopscotch.min.css" rel="stylesheet"></link>
<link href="demo.css" rel="stylesheet"></link>

<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery-1.8.2.min.js"></script> 
<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="<?php echo $refUrl; ?>js/popup.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />

<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.multiselect.js"></script> 
<script type="text/javascript" src="<?php echo $refUrl; ?>js/expand.js"></script>
<script src="<?php echo $refUrl; ?>js/showHide.js" type="text/javascript"></script>
<script src="<?php echo $refUrl; ?>js/jquery.flexslider.js"></script>
<script src="<?php echo $refUrl; ?>js/jquery.masonry.min.js"></script>
<script src="<?php echo $refUrl; ?>js/switch.min.js" type="text/javascript"></script>
<link href="<?php echo $refUrl; ?>css/switch.css" type="text/css" rel="stylesheet">
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
<script src="<?php echo $refUrl; ?>js/jquery.flexslider.js"></script><!--[if lt IE 9]>
<![endif]-->

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
//	$("div.holder").jPages({
//	  containerID : "movies",
//	  previous : "�? Previous",
//	  next : "Next →",
//	  perPage : 1,
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
	$("#keywordsearch").combobox();
        $("#keywordsearchmain").combobox();
    $("#combobox").combobox();
	$("#advisorsearch_legal").combobox();
	$("#advisorsearch_trans").combobox();
        $("#sectorsearch").combobox();
	/*$( ".custom-combobox" ).autocomplete({
	  change: function( event, ui ) { this.form.submit(); }
	});*/
        
    
 
        
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
		$("link[rel=stylesheet]:not(:first)").attr({href : "../dealsnew/css/detect800.css"});
	}
});
 
$(document).ready(function(){
 
  	$(".popup").LePopup({

		skin : "big-shadow"
           });

       $("#disselect").find(':input').prop("disabled", true);  
       
        $('.show-nav').on('ifChecked', function(event){
            
            $("#pesearch").submit();
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
<style type="text/css">

#preloading {
background:url(<?php echo $refUrl; ?>images/linked-in.gif) no-repeat center center;
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
</head>

<?php if($_SESSION['MA_TrialLogin']==1){ ?>
<body > 
<?php }else { ?>
<body ondragstart="return false" onselectstart="return false" oncontextmenu="return false" oncopy="return false" onpaste="return false" oncut="return false"> 
<?php } ?>
 <div id="maskscreen" ></div>
<div id="preloading"></div>
<script type="text/javascript" >
$('#maskscreen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
jQuery(window).load(function(){
jQuery('#preloading').fadeOut(500);
jQuery('#maskscreen').fadeOut(500);
});
</script>
    <?php //include_once('definitions.php');
    //include_once('refinedef.php');?>
<!--Header-->
<?php
   $actionlink="pedirview.php";
?>
<form name="searchall" action="" method="post" id="searchall">    
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="index.php"><img src="<?php echo $refUrl; ?>images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>


<td class="right-box">
    <ul class="tour-lock">
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?> id="dashboardmenu"><a href="madashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active"' : '' ; ?> id="dealsmenu"><a href="javascript:void(0)" class="popup_call" data-url="index.php"><i class="i-data-deals"></i>Deals</a></li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?> id="directorymenu"><a href="pedirview.php?value=0"><i class="i-directory"></i>Directory</a></li>
</ul>
<ul class="fr">
   <!--  <li class="classic-btn classic-link"><a href="<?php echo GLOBAL_BASE_URL; ?>deals/madealsearch.php" >Classic View</a></li> -->
    <li class="classic-btn"><input  type="button" id="restartTourBtn" value="Start Tour" /></li>
<!--li ><div style="float:right;padding: 9px 15px" class="key-search"><b></b> <input  autofocus="autofocus" type="text" name="searchallfield" placeholder=" Keyword Search"
                                                                                      <?php if($searchallfield!="") echo "value=".$searchallfield ;?>
                                                                                       style="padding:5px;"  /> 
        <input type="button" name="fliter_stage" value="Go" onclick="this.form.submit();" style="padding: 5px;"/>
    </div></li-->
<?php if($_SESSION['student']!="1") { ?>
<li class="user-avt"><span class="example" data-dropdown="#myaccount"> Welcome  <?php echo $_SESSION['MAUserNames']; ?></span>
<?php } else { ?>
    <li class="user-avt"><span class="studentlogin" data-dropdown="#myaccount"> Welcome  <?php echo $_SESSION['MAUserNames']; ?></span>
<?php }?>
<?php if($_SESSION['student']!="1") { ?>
<div id="myaccount" class="dropdown" style="left:inherit !important; max-width: 250px !important;">
		<ul class="dropdown-menu">
                        <li class="o_link"><a href="../pelogin.php" target="_blank">PE/VC Deals Database</a></li>
                        <li class="o_link"><a href="../relogin.php" target="_blank">PE in Real Estate Database</a></li>
                        <li class="o_link"><a href="../cfsnew/login.php" target="_blank">Company Financials Database</a></li>
                        
			<li><a href="changepassword.php?value=P">Change Password</a></li>
                        <li><a href="logoff.php?value=P">Logout</a></li>
                        
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

<?php
$passwrd = $_GET['value'];
if($passwrd != 'P')
{
?>
<div id="sec-header" class="sec-header-fix">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="vertical-form">
<h3>Show By</h3>
<div>    
    <div class="showdealsby" id="dirshowdealby" style="display: inline-block">
<!-- <label class="iradio"><input  class="show-nav" name="showdeals" type="radio"  value=101  <?php if($dealvalue==101) { ?> checked="checked" <?php } ?>/>Target Company</label> -->
<label class="iradio"><input  class="show-nav" name="showdeals" type="radio"  value=102  <?php if($dealvalue==102) { ?> checked="checked" <?php } ?>/>Acquirer Company</label>
<label class="iradio"><input  class="show-nav" name="showdeals" type="radio"  value=103  <?php if($dealvalue==103) { ?> checked="checked" <?php } ?>/>Legal Advisor</label>
<label class="iradio" id="transaction-adv"><input  class="show-nav" name="showdeals" type="radio"  value=104  <?php if($dealvalue==104) { ?> checked="checked" <?php } ?>/>Transaction Advisor</label>
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

    