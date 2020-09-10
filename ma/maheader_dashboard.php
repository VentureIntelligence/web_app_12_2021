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
<meta http-equiv="X-UA-Compatible" content="IE=9; IE=8; IE=7; IE=EDGE; " />
<title>Venture Intelligence</title>
<link href="<?php echo $refUrl; ?>css/ma_skin.css" rel="stylesheet" type="text/css" />   

  <script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery-1.8.2.min.js"></script> 
  <script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.tablesorter.js"></script>
  <script src="<?php echo $refUrl; ?>js/showHide.js" type="text/javascript"></script>
  <script src="<?php echo $refUrl; ?>js/jPages.js"></script>
  <script src="<?php echo $refUrl; ?>js/jquery.icheck.min.js?v=0.9.1"></script>
  <!--<script type="text/javascript" src="<?php echo $refUrl; ?>js/responsive-tables.js"></script>-->
  <script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.responsivetable.js"></script>
<script>
$(document).ready(function() {
$('.testTable1').responsiveTable( {scrollRight: false, scrollHintEnabled: false} );
});
</script>
  <script type="text/javascript" src="<?php echo $refUrl; ?>js/expand.js"></script>
  <script type="text/javascript" src="<?php echo $refUrl; ?>js/popup.js"></script>
  <link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
  <script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.multiselect.js"></script>
  <script src="<?php echo $refUrl; ?>js/jquery.flexslider.js"></script>
<script src="<?php echo $refUrl; ?>js/jquery.masonry.min.js"></script>
  
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
    $("#combobox").combobox();
	$("#advisorsearch_legal").combobox();
	$("#advisorsearch_trans").combobox();
        $("#sectorsearch").combobox();
	/*$( ".custom-combobox" ).autocomplete({
	  change: function( event, ui ) { this.form.submit(); }
	});*/
        
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
	$("#myTable").tablesorter({widthFixed: true}); 
	$("div.holder").jPages({
	  containerID : "movies",
	  previous : "�? Previous",
	  next : "Next →",
	  perPage : 20,
	  delay : 20
	});
});

$(document).ready(function(){
    
    
   $('.show_hide').showHide({			 
		speed: 1000,  // speed you want the toggle to happen	
		easing: '',  // the animation effect you want. Remove this line if you dont want an effect and if you haven't included jQuery UI
		changeText: 1, // if you dont want the button text to change, set this to 0
		showText: 'View Table',// the button text to show when a div is closed
		hideText: 'Close Table' // the button text to show when a div is open
					 
	}); 
     $("#slidingDataTable").show();
     $('.show_hide').addClass("active");

	$(".btn-slide").click(function(){
		$("#panel").animate({width: 'toggle'});
		$(this).removeClass("active"); return false; 
	});
	
 
  $('input').iCheck({
	checkboxClass: 'icheckbox_flat-red',
	radioClass: 'iradio_flat-red'
  });
  
  	$(".popup").LePopup({

		skin : "big-shadow"
           });


$('.typeoff-nav').on('ifChecked', function(event){
     
     var value = $(this).val();
      if (value == 1) {
            var hrefval = 'madashboard.php?type=1';
            $("#pesearch").attr("action", hrefval);
            $("#pesearch").submit();
            return false;
                    //window.location.assign("dashboard.php?type=1");
    }
    else if (value == 2) {
        var hrefval = 'madashboard.php?type=2';
        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;
        //window.location.assign("dashboard.php?type=2");
    }
    else if (value == 4) {
        var hrefval = 'madashboard.php?type=4';
        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;
        //window.location.assign("dashboard.php?type=4");
    }
    else if (value == 6) {
        var hrefval = 'madashboard.php?type=6';
        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;
        //window.location.assign("dashboard.php?type=6");
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
$(function () {
            $('.expander').simpleexpand();
          
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
                        background: url(<?php echo $refUrl; ?>images/up_arrow.png) no-repeat;
                        z-index: 8000;
                    }
                    .scrollup:hover{opacity:1;}
                
/*                .mylist{margin: 5px;padding: 0;display: block;}
                .mylist li{border-right:#867979 solid thin;padding: 1px;}
                */
                
            </style>
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
jQuery('#preloading').fadeOut(3000);
jQuery('#maskscreen').fadeOut(3000);
});
</script>
    <a href="#" class="scrollup">Scroll</a>
    <?php 
    $defpage=$VCFlagValue."";
    include_once('definitions.php');?>
<!--Header-->
<form name="searchall" action="" method="post" id="searchall">
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="index.php"><img src="<?php echo $refUrl; ?>images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>
<td class="right-box">
    <ul class="tour-lock">
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="madashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active"' : '' ; ?>><a href="javascript:void(0)" class="popup_call" data-url="index.php"><i class="i-data-deals"></i>Deals</a></li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?>><a href="pedirview.php"><i class="i-directory"></i>Directory</a></li>
</ul>
<ul class="fr">
   <!--  <li class="classic-btn"><a href="<?php echo GLOBAL_BASE_URL; ?>deals/madealsearch.php" >Classic View</a></li>
    <?php if($_SESSION['student']!="1") { ?> -->
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
<form name="pesearch" action="" method="post" id="pesearch">
<div id="sec-header" class="sec-header-fix">
<table cellpadding="0" cellspacing="0">
<tr>

<td class="investment-form">
<h3>Types</h3>
<label><input class="typeoff-nav" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
<label><input class="typeoff-nav" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav" name="typeoff" type="radio" value="6" <?php if($type==6) { ?> checked="checked" <?php } ?>/>Region</label>


<input style="float: right;margin-right: 9px;" type="button" name="otherreport" value="Other Reports" id="otherreport" class="senddeal">
    
<script>
    $('#otherreport').click(function(){
        window.location.href='report.php';
    });
</script>
    
</td>
</tr>
</table>
</div>
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
