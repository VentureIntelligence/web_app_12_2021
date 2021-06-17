<?php include_once("../globalconfig.php");
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
if(!isset($_SESSION['UserNames']))
{
        header('Location:../pelogin.php');
}
else
{
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Venture Intelligence</title>
<link href="css/skin.css" rel="stylesheet" type="text/css" />   

  <script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
  <script type="text/javascript" src="js/jquery.tablesorter.js"></script>
  <script src="js/showHide.js" type="text/javascript"></script>
  <script src="js/jPages.js"></script>
  <script src="js/jquery.icheck.min.js?v=0.9.1"></script>
 
  <script type="text/javascript" src="js/expand.js"></script>
  <script type="text/javascript" src="js/popup.js"></script>
  <link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
  <script src="https://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
  <link rel="stylesheet" href="/resources/demos/style.css" />
  <script type="text/javascript" src="js/jquery.multiselect.js"></script>
  <script src="js/jquery.flexslider.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<script src="js/jquery.responsivetable.js"></script>

<script src="TourStart.js"></script>  
<style>
  /* .btn-disabled,
.btn-disabled[disabled] {
  opacity: .4;
  cursor: default !important;
  pointer-events: none;
} */
/* .request-for-lp{
  position: absolute;
    background: #41352999;
    right: 205px;
    padding: 10px 75px;
    background-image: none !important;
    cursor: pointer;
    top: 4px;
    margin-right: 0px !important;
    width:15px;
} */
  </style>
 <div id="maskscreen" ></div>
      <div id="preloading"></div>
      <div id="preloadingInv"></div>
      <script type="text/javascript" >
         $('#maskscreen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
         jQuery(window).load(function(){
         jQuery('#preloading').fadeOut(1000);
         jQuery('#maskscreen').fadeOut(1000);
         });
      </script>
<script>
$(document).ready(function() {
$('.testTable1').responsiveTable( {scrollRight: false, scrollHintEnabled: false} ); 
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
            var hrefval = 'dashboard.php?type=1';
            $("#pesearch").attr("action", hrefval);
            $("#pesearch").submit();
            return false;
                    //window.location.assign("dashboard.php?type=1");
    }
    else if (value == 2) {
        var hrefval = 'dashboard.php?type=2';
        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;
        //window.location.assign("dashboard.php?type=2");
    }
    else if (value == 3) {
        var hrefval = 'dashboard.php?type=3';
        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;
       // window.location.assign("dashboard.php?type=3");
    }
    else if (value == 4) {
        var hrefval = 'dashboard.php?type=4';
        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;
        //window.location.assign("dashboard.php?type=4");
    }
    else if (value == 5) {
        var hrefval = 'dashboard.php?type=5';
        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;
        //window.location.assign("dashboard.php?type=5");
    }
    else if (value == 6) {
        var hrefval = 'dashboard.php?type=6';
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
           $('#maskscreen').css({ opacity: 0.7, 'width':$(document).width(),'height':$(document).height()});
jQuery(window).load(function(){
jQuery('#preloading').fadeOut(1000);
jQuery('#maskscreen').fadeOut(1000);
});
           $(document).on('click','.request-for-lp,.request-lp',function(){
            
            jQuery('#maskscreen').fadeIn(1000);
            jQuery('#ymessage').val('');
            jQuery('#popup-box-lp').fadeIn();   
            return false;
           });
           $(document).on('click','#cancelbtnhd-lp',function(){
          
            jQuery('#maskscreen').fadeOut();
            jQuery('#popup-box-lp').fadeOut();   
            return false;
           });

           $('#mailbtnhd-lp').click(function(e){ 
                        e.preventDefault();
                       // if(checkEmail())
                       // {
                        $.ajax({
                            url: 'ajaxsendmailLP.php',
                             type: "POST",
                           /* data: { to : $("#toaddress").val(), ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },*/
                            data: { ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },
                            success: function(data){
                                    if(data=="1"){
                                         alert("Mail Sent Successfully");
                                        jQuery('#popup-box-lp').fadeOut();   
                                        jQuery('#maskscreen').fadeOut(1000);
                                   
                                }else{
                                    jQuery('#popup-box-lp').fadeOut();   
                                    jQuery('#maskscreen').fadeOut(1000);
                                    alert("Try Again");
                                }
                            },
                            error:function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem sending mail...");
                            }

                        });
                       // }
                        return false;
                    });

</script>

   <script type="text/javascript">
$(function(){
	$(".selectgroup select").multiselect();
});
$(function () {
            $('.expander').simpleexpand();
          
        });
</script>
   <script type="text/javascript" src="https://www.google.com/jsapi"></script>
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

<?php if($_SESSION['PE_TrialLogin']==1){ ?>
<body > 
<?php }else { ?>
<body ondragstart="return false" onselectstart="return false" oncontextmenu="return false" oncopy="return false" onpaste="return false" oncut="return false"> 
<?php } ?>
    <a href="#" class="scrollup">Scroll</a>
    <?php 
    $defpage=$VCFlagValue."";
    include_once('definitions.php');
    include_once('../globalconfig.php');
    ?>
<!--Header-->

<form name="searchall" action="" method="post" id="searchall">
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="index.php"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>
<td class="right-box">
     <?php include('top_menu.php'); ?>
<!--<ul>
<li <?php echo ($topNav=='Dashboard') ? 'class="active"' : '' ; ?>><a href="dashboard.php?type=1"><i class="i-dashboard"></i>Dashboard</a></li>
<li <?php echo ($topNav=='Deals') ? 'class="active"' : '' ; ?>><a href="index.php"><i class="i-data-deals"></i>Deals</a></li>
<li <?php echo ($topNav=='Directory') ? 'class="active"' : '' ; ?>><a href="pedirview.php?value=0"><i class="i-directory"></i>Directory</a></li>
<li <?php echo ($topNav=='Funds') ? 'class="active"' : '' ; ?>><a href="funds.php"><i class="i-directory"></i>Funds <span class="betaversion">Beta</span></a></li>
<!--li <?php echo ($topNav=='Report') ? 'class="active"' : '' ; ?>><a href="report.php"><i class="i-directory"></i>Report</a></li
</ul>-->
<ul class="fr">
     <!-- <li class="classic-btn"><a href="<?php echo GLOBAL_BASE_URL; ?>deals/dealhome.php" >Classic View</a></li> -->
     <?php //include('TourStartbtn.php'); ?>
     
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
<?php } ?></li>
</ul>
</td>
</tr>
</table>

</div>
</form>
<?php 
    $actionlink="dashboard.php?type=".$_GET['type'];

?>
<form name="pesearch" action="<?php echo $actionlink; ?>" method="post" id="pesearch">
<div id="sec-header" class="sec-header-fix">
<table cellpadding="0" cellspacing="0">
<tr>

<td>
<?php $type = isset($_REQUEST['type']) ? $_REQUEST['type'] : 1; ?>
<h3 style="float:left;">Types</h3>
<label><input class="typeoff-nav" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
 <label><input class="typeoff-nav" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
<label><input class="typeoff-nav" name="typeoff" type="radio"  value="3" <?php if($type==3) { ?> checked="checked" <?php } ?>/>Stage</label>
<label><input class="typeoff-nav" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
<label><input class="typeoff-nav" name="typeoff" type="radio" value="6" <?php if($type==6) { ?> checked="checked" <?php } ?>/>Region</label> 
 <!--a style="float: right;font-size: 16px;font-weight: bold;" class="senddeal" href="https://www.ventureintelligence.com/dev/dealsnew/report.php" >Other Reports</a-->
 <a href='<?php echo BASE_URL; ?>dealsnew/otherreport.php'><input style="float: right;margin-right: 9px;" type="button" name="otherreport" value="Trend Reports" id="otherreport" class="senddeal"></a>
    <?php
   $dlogUserEmail = $_SESSION['UserEmail'];

$sqlQuery="SELECT dc.custom_limit_enable as custom_limit_enable FROM dealmembers dm INNER JOIN dealcompanies dc on dc.DCompId=dm.DCompId WHERE EmailId='$dlogUserEmail' ";   
$sqlSelResult = mysql_query($sqlQuery) or die(mysql_error());
while ($row = mysql_fetch_assoc($sqlSelResult)) {

$custom_limit_enable= $row['custom_limit_enable']  ;

}
    ?> 
    <?php
        if ($custom_limit_enable == 1)
        {
        ?>
        <a href='<?php echo BASE_URL; ?>dealsnew/advance_export.php'><input style="float: right;margin-right: 9px;color:white;background-color: #A2753A;text-transform:capitalize;padding:7px 30px 7px 30px;border-radius:5px;" type="button"  name="advExport" value="Advanced Filters" id="advExport" ></a>
        <?php 
        }

        else{
        ?>
        <span class="request-for-lp" style="">

        <button style="float: right;margin-right: 9px;color:white;background-color: #A2753A;text-transform:capitalize;padding:7px 30px 7px 30px;border-radius:5px;    opacity: 0.5;" type="button" class="btn-disabled" disabled="disabled"  name="advExport" value="Advanced Filters" id="advExport" ><i class="fa fa-lock" aria-hidden="true" style="
    background-image: none;    font-size: 15px;
"></i>       Advanced Filters
        </button> </span>
        <?php  }?>
        
                           
</td>

</tr>
</table>
</div>

<?php } ?>
<div class="lb" id="popup-box-lp" style="width: 450px;">
    <div class="title" style="font-size: 16px;"> Request for - Advanced Filters </div>
        <form style="margin-bottom: 0px;">
            <div class="entry">
                    <h5>Add a note..</h5><span style='float:right;display: block;margin-top: -20px;'></span>
                    <textarea name="ymessage" id="ymessage" style="width: 420px; height: 57px;" placeholder="Need access for advanced filters" val=''></textarea>
                    <input type="hidden" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"/>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailbtnhd-lp" />
                <input type="button" value="Cancel" id="cancelbtnhd-lp" />
                <span style="padding: 3px 0px;">(Alternatively please call us at +91 44 42185180)</span>
            </div>

        <!-- </form> -->
    </div>