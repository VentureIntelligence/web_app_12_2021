<?php 
 require_once("../dbconnectvi.php");
 $Db = new dbInvestments();
 if(!isset($_SESSION['UserNames']))
 {
     header('Location:../pelogin.php');
 }
 else
 {	?>
 <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>Private Equity Deal Database</title>
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link href="css/skin.css" rel="stylesheet" type="text/css" />  
<link href="css/popstyle.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="css/detect800.css" />
<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<link rel="stylesheet" type="text/css" href="css/token-input.css" />
<link rel="stylesheet" type="text/css" href="css/token-input-facebook.css" />
<!--<script type="text/javascript" src="js/jquery.tablesorter.js"></script>-->
<script type="text/javascript" src="js/popup.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css" integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
<!--<link rel="stylesheet" href="/resources/demos/style.css" />-->
<link href="hopscotch.min.css" rel="stylesheet"></link>
<!-- <link rel="stylesheet" type="text/css" href="css/jquery.mCustomScrollbar.min.css" /> -->
<script type="text/javascript" src="js/jquery.tokeninput.js"></script> 
<script type="text/javascript" src="js/jquery.multiselect.js"></script> 
<link rel="stylesheet" type="text/css" href="css/jquery.multiselect.filter.css" />
<script type="text/javascript" src="js/jquery.multiselect.filter.js"></script>
  <script type="text/javascript" src="js/expand.js"></script>
 <script src="js/showHide.js" type="text/javascript"></script>
 <script src="js/jquery.flexslider.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<script src="js/jquery.mCustomScrollbar.concat.min.js"></script>
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
                $("#company_info td:nth-child(3)").css("width","15%");
                $("#company_info td:first-child").css("width","13%");
                $('.col-p-7').css("width","36%");
                $('.col-p-8_1').css("width","16%"); 
                $('.col-p-8_2').css("width","15%"); 
                $("#company_info td:nth-child(2)").css("width","38%");
                $("#company_info td:nth-child(4)").css("width","34%");
                $("#deal_info td:nth-child(1)").css("width","26%");
                $("#deal_info td:nth-child(2)").css("width","24%");
                $("#deal_info td:nth-child(3)").css("width","27%");
                $("#deal_info td:nth-child(4)").css("width","23%");
                    $('.detail-view-header h2').css('left','36px');
                $('.detail-view-header h2').css('width','96%');
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
                $("#deal_info td:nth-child(1)").css("width","26%");
                $("#deal_info td:nth-child(2)").css("width","21%");
                $("#deal_info td:nth-child(3)").css("width","28%");
                $("#deal_info td:nth-child(4)").css("width","25%");
                $('.detail-view-header h2').css('left','284px');
                $('.detail-view-header h2').css('width','76%');
            }  
            return false; //Prevent the browser jump to the link anchor
            });
	
	 
});
</script>
 
<script type="text/javascript" src="js/tytabs.jquery.min.js"></script>

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
  


<script type="text/javascript" src="//www.google.com/jsapi"></script>
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
.exit-form h3{
  opacity: 0.5;
}
.exit-form h3:hover{
  opacity: 1;
}

</style>
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
    <?php include_once('definitions.php');?>
    <?php include_once('refinedef.php');?>


<!--<form name="searchall" action="<?php echo $actionlink; ?>" method="post" id="searchall">    -->
<form name="pesearch" action="<?php echo $actionlink; ?>" method="post" id="pesearch">
<input type="hidden" name="listallcompanies" value="<?php echo $listallcompany?>" />
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="index.php"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>


<td class="right-box">
    
    <?php include('top_menu.php'); ?>
 
    
<ul class="fr">
   
    
            
<li ><div style="float:right;padding: 9px 15px" class="key-search"><b></b> <input type="text" id="searchallfield" name="searchallfield" placeholder="Search"
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
<div id="sec-header" class="sec-header-fix dealsindex">
<table cellpadding="0" cellspacing="0">
<tr>

<td class="vertical-form">    

    <h3 id="investmenttype">Trend Reports </h3>


</td>
 
</tr>
</table>
</div>
<?php
} }
?>
<script>
 
</script> 