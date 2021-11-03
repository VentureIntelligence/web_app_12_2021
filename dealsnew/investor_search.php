<?php require_once("../dbconnectvi.php");
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
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>Venture Intelligence</title>
<link href="css/skin.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="css/detect800.css" />

<script type="text/javascript" src="js/jquery-1.8.2.min.js"></script> 
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script type="text/javascript" src="js/popup.js"></script>

<link rel="stylesheet" href="//code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="//code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<!--<link rel="stylesheet" href="/resources/demos/style.css" />-->

<script type="text/javascript" src="js/expand.js"></script>
<script src="js/showHide.js" type="text/javascript"></script>
<script src="js/jquery.flexslider.js"></script>
<script src="js/jquery.masonry.min.js"></script>
<script type="text/javascript" src="js/jquery.multiselect.js"></script> 
<script type="text/javascript" src="js/jquery.tokeninput.js"></script> 
<link rel="stylesheet" type="text/css" href="css/jquery.multiselect.filter.css" />
<script type="text/javascript" src="js/jquery.multiselect.filter.js"></script>
<!--<script src="js/switch.min.js" type="text/javascript"></script>-->
<!--<link href="css/switch.css" type="text/css" rel="stylesheet">-->
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
<script src="js/jquery.flexslider.js">
</script>


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
      $('input').iCheck({
        checkboxClass: 'icheckbox_flat-red',
        radioClass: 'iradio_flat-red'
      });
    });
</script>   
 <script>
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

 /*$('.showdealsby').each(function(){
    $('input[type=radio]:first', this).attr('checked', true);
});*/

       $("#disselect").find(':input').prop("disabled", true);  
       
        $('.show-nav').on('ifChecked', function(event){
            
           <?php if($_SESSION['vconly']!=1){ ?>
            var current_tour = hopscotch.getCurrStepNum();
           <?php } else {?>  
            var current_tour = '';
           <?php } ?>
          
            var slt_shows = $("input[name=showdeals]:checked").val();
            
            if(Directorydemotour==1){
                    if(slt_shows==103 && current_tour==12){ 
            $("#pesearch").submit();
                     }
                     else {
                         showErrorDialog(warmsg);
                         return false;
                     }
                }            
            $("#pesearch").submit();
        });
        
       
     $('.investment-nav').on('ifChecked', function(event){
       
                if(Directorydemotour==1){
                    showErrorDialog(warmsg);
                     return false;
                }
       
 navvalue=$(this).val();
       switch(navvalue)
       {
           case '0':
                    var hrefval = 'pedirview.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    break;
           case '1':
                    var hrefval = 'pedirview.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    break;
           case '2':
                   window.location.href = 'pedirview.php?value='+$(this).val();
                   break;
           case '3':
                    var hrefval = 'pedirview.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                   //window.location.href = 'svtrendview.php?value='+$(this).val();
                   break;
           case '4':
                    var hrefval = 'pedirview.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                     //window.location.href = 'svtrendview.php?value='+$(this).val();
                    break;
           case '5':
                    var hrefval = 'pedirview.php?value='+$(this).val();
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                   // window.location.href = 'svtrendview.php?value='+$(this).val();
                   break;
            case '6':
                   window.location.href = 'pedirview.php?value='+$(this).val();
                   break;
            
       }
       

});


 $('.exist-nav').on('ifChecked', function(event){
       navvalue=$(this).val();
            
           <?php if($_SESSION['vconly']!=1){ ?>
            var current_tour = hopscotch.getCurrStepNum();
           <?php } else {?>  
            var current_tour = '';
           <?php } ?>
          
     
        
        if(Directorydemotour==1 && current_tour!=11){
                    showErrorDialog(warmsg);
                     return false;
                }                 
        else if(Directorydemotour==1 && current_tour==11){
            
            if(navvalue!='PE-EXIST') { showErrorDialog(warmsg); return false; }            
        }        
       
                
                      
       switch(navvalue)
       {
           case 'PE-BACKED-IPO':
                   window.location.href = 'pedirview.php?value=7';
                   break;
           case 'VC-BACKED-IPO':
                   window.location.href = 'pedirview.php?value=8';
                   break;
           case 'PMS':
                   window.location.href = 'pedirview.php?value=9';
                   break;
           case 'VCPMS':
                   window.location.href = 'pedirview.php?value=12';
                   break;  
           case 'PE-EXIST':
                   window.location.href = 'pedirview.php?value=10';
                   break;
           case 'VC-EXIST':
                   window.location.href = 'pedirview.php?value=11';
                   break;
               
       }
       

});
});

$(function () {
            $('.expander').simpleexpand();
        });
        


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


/*css newly added 28-05-19*/
.period-date {
        margin-right: 5px !important;
}
.search-btn input
{
  line-height: 18px !important;
}
.period-date label{
  line-height: 25px !important;
  font-size: 13px;
    font-weight: 600;
    margin: 0px 5px;
}
.detailed-title-links h2{
  margin-bottom: -20px !important;
}
.result-title {
    margin-top: -20px !important;
    padding: 20px 0 15px !important;
    position:inherit;
}
.datesubmit{
    cursor: pointer;
    float: left;
    background: url(../dealsnew/images/icon-search.png) no-repeat center #a2753a !important;
    border: 1px solid #a2753a;
    width: 33px !important;
    height: 25px;
    min-width: 33px !important;
}
.investorfilter{
    float:right;
    width: 33%;
}
.investorfilter select{padding:3px;}
.period-date select,.period-date+.search-btn,#expshowdeals{margin-top:0px !important;}
.exportinvest {
    border: 1px solid #a2733a;
}

.with-invs{
    font-size: 13px;
    padding: 5px;
    border-bottom: 1px solid #a37535;
    background-color: #fff;
    text-align: center;
    padding-top: 30px;
    cursor: pointer;
}
.without-invs{
    font-size: 13px;
    padding: 5px;
    border-bottom: 1px solid #a37535;
    background-color: #fff;
    text-align: center;
    cursor: pointer;
}
 .profile-invs {
    font-size: 13px;
    padding: 5px;
    background-color: #fff;
    text-align: center;
    cursor: pointer;
}
.title-links a{
    margin-left:0px !important;
}
.export {
    padding-left: 20px !important;
}
.result-title .title-links {
    position: absolute !important;
}
.inves{
    position: absolute;
    right: 10%;
}
.result-title h2{
    margin-bottom:5px;
}
.result-title li{
    position:unset !important;
}
.result-select {
    padding: 3px 3px 1px 2px !important;
}
.result-select-close a {
    margin: -6px 0px 0px 0px !important;
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
        <?php include_once('definitions.php');
        include_once('refinedef.php');?>
    <!--Header-->
    <?php
    if(basename($_SERVER['PHP_SELF'])=="pedirview.php"){
        $actionlink="pedirview.php?value=".$vcflagValue;
    }elseif(basename($_SERVER['PHP_SELF'])=="investorreport.php"){
        $actionlink="investorreport.php";
    }elseif(basename($_SERVER['PHP_SELF'])=="newinvestorreport.php"){
        $actionlink="newinvestorreport.php";
    }
   
       //$actionlink="investorreport.php?value=".$vcflagValue;
    ?>


<!--Header-->
<form name="searchall" id="searchall" action="angelindex.php" method="post">
<div id="header">
<table cellpadding="0" cellspacing="0">
<tr>
<td class="left-box"> <div class="logo-img"> <a href="index.php"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></td>

<td class="right-box">
<?php include('top_menu.php'); ?>
<ul class="fr">
<li ><div style="float:right;padding: 9px 15px" class="key-search"><b></b> <input  autofocus="autofocus" type="text" name="searchallfield" placeholder=" Keyword Search"
                                                                                      <?php if($searchallfield!="") echo "value=".$searchallfield ;?>
                                                                                       style="padding:5px;"  /> 
        <input type="button" name="fliter_stage" value="Go" onclick="this.form.submit();" style="padding: 5px;"/>
    </div></li>
<li class="user-avt"><span class="example" data-dropdown="#myaccount"> Welcome  <?php echo $_SESSION['UserNames']; ?></span> 
<div id="myaccount" class="dropdown">
		<ul class="dropdown-menu">
			<li><a href="changepassword.php?value=P">Change Password</a></li>
                        <li><a href="logoff.php?value=P">Logout</a></li> 
		</ul>
	</div></li>
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
    <td class="investment-form">
<h3 >INVESTMENTS</h3>
<div class="investmentlabel  frmDropDown">
<?php // echo $vcflagValue;?>

<select id="investmentswitch"  style="display:none;">  
<option  class="peonly"  value="investmentspe" <?php echo ($vcflagValue==0) ? 'SELECTED' : ""; ?>>PE</option>
<option  class="vconly"  value="investmentsvc" <?php echo ($vcflagValue==2 || $vcflagValue==1 || $vcflagValue==6) ? 'SELECTED' : ""; ?> >VC</option>
</select>  

<div id="investmentspe"  >
<label style="display:none;"><input class="investment-nav" name="investments" type="radio" value=0  <?php if($vcflagValue==0) { ?> checked="checked" <?php } ?>  /> PE</label></div>

<div id="investmentsvc" class="select-hide">
<label><input class="investment-nav" name="investments" type="radio" value=1  <?php if($vcflagValue==1) { ?> checked="checked" <?php } ?>/> VC</label>
<label><input class="investment-nav" name="investments" type="radio" value=2  <?php if($vcflagValue==2) { ?> checked="checked" <?php } ?>/>Angel</label>
<label><input class="investment-nav" name="investments" type="radio" value=6  <?php if($vcflagValue==6) { ?> checked="checked" <?php } ?>/>Incubation</label>
<label><input class="investment-nav" name="investments" type="radio" value=3  <?php if($vcflagValue==3) { ?> checked="checked" <?php } ?>/>Social</label></div>
<!-- <label><input class="investment-nav" name="investments" type="radio" value=4  <?php if($vcflagValue==4) { ?> checked="checked" <?php } ?>/>Cleantech</label>
<label><input class="investment-nav" name="investments" type="radio" value=5  <?php if($vcflagValue==5) { ?> checked="checked" <?php } ?>/>Infrastructure</label> -->
</div>

<!--<div id="invspecialisedsocial" class="">
</div>-->

<!-- <div id="" class="">
  <div class="investmentlabel">
<div>
<label><input class="investment-nav" name="investments" type="radio" value=4  <?php if($vcflagValue==4) { ?> checked="checked" <?php } ?>/>Cleantech</label>
<label><input class="investment-nav" name="investments" type="radio" value=5  <?php if($vcflagValue==5) { ?> checked="checked" <?php } ?>/>Infrastructure</label></div>
</div>
</div> -->
</td>



<td class="exit-form">
<h3 >EXITS <!--VIA--></h3>
<div class="exitslabel">    
    <select id="exitswitch">
    <option  class="peonly"  value="1" <?php echo ($vcflagValue==7 || $vcflagValue==9 || $vcflagValue==10) ? 'SELECTED' : ""; ?> >PE</option>
    <option  class="vconly"  value="0" <?php echo ($vcflagValue==8 || $vcflagValue==11 || $vcflagValue==12) ? 'SELECTED' : ""; ?>>VC</option>
    </select>
 
<div id="exitsviape" >
<label><input class="exist-nav" name="investments" type="radio" value="PE-BACKED-IPO" <?php if($vcflagValue==7) { ?> checked="checked" <?php } ?>/>IPO(PE)</label>
<label id="PEmaexits_tour"><input class="exist-nav" name="investments" type="radio" value="PE-EXIST" <?php if($vcflagValue==10) { ?> checked="checked" <?php } ?>/>M&A(PE) </label>
<label id="PEpublicexits_tour"><input class="exist-nav" name="investments" type="radio" value="PMS" <?php if($vcflagValue==9) { ?> checked="checked" <?php } ?>/> Public Market</label>
</div>

<div id="exitsviavc" class="select-hide" >
<label><input class="exist-nav" name="investments" type="radio" value="VC-BACKED-IPO" <?php if($vcflagValue==8) { ?> checked="checked" <?php } ?>/>IPO(VC)</label>
<label><input class="exist-nav" name="investments" type="radio" value="VC-EXIST" <?php if($vcflagValue==11) { ?> checked="checked" <?php } ?> />M&A(VC) </label>
<label><input class="exist-nav" name="investments" type="radio" value="VCPMS" <?php if($vcflagValue==12) { ?> checked="checked" <?php } ?> />Public Market </label>

</div>
</div>
</td>
    
<td class="vertical-form">
<!-- <h3>Show By</h3>
 --><div>    
   <?php 


    if ($_POST['flagvalue123'] != "")
    {
        if($_POST['flag']==0){ ?>
        <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> PE </h3>
        <?php }elseif($_POST['flag']==1 ){ ?>
        <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> VC </h3>
        <?php }elseif($_POST['flag']==2 ){ ?>
        <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Angel</h3>
        <?php }elseif($_POST['flag']==3 ){ ?>
        <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Social VC</h3>
        <?php }elseif($_POST['flag']==4){ ?>
        <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Cleantech</h3>
        <?php }elseif($_POST['flag']==5 ){ ?>
        <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Infrastructure</h3>
        <?php }elseif($_POST['flag']==6){ ?>
        <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Incubation</h3>
        <?php } 
    }else{
        if($_GET['flag']==0){ ?>
            <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> PE </h3>
            <?php }elseif($_GET['flag']==1 ){ ?>
            <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> VC </h3>
            <?php }elseif($_GET['flag']==2 ){ ?>
            <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Angel</h3>
            <?php }elseif($_GET['flag']==3 ){ ?>
            <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Social VC</h3>
            <?php }elseif($_GET['flag']==4){ ?>
            <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Cleantech</h3>
            <?php }elseif($_GET['flag']==5 ){ ?>
            <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Infrastructure</h3>
            <?php }elseif($_GET['flag']==6){ ?>
            <h3 id="investmenttype">Investments <span style="padding-left: 2px;padding-right: 2px;">></span> Incubation</h3>
            <?php } 
    }

    ?>



<?php if($vcflagValue != 6){?>
<div class="showdealsby" style="float:right;">
  <label>SHOW BY</label>
<label id="peinvestor_tour"><input  class="show-nav" name="showdeals" type="radio"  value=101  <?php if($dealvalue==101) { ?> checked="checked" <?php } ?>/> Investor</label>
<label id="peinvestor_tour1"><input  class="show-nav" name="showdeals" type="radio"  value=102  <?php if($dealvalue==102) { ?> checked="checked" <?php } ?>/>Company</label>
<?php 
if($vcflagValue==0 || $vcflagValue==1 || $vcflagValue==3 || $vcflagValue==4 || $vcflagValue==5 || $vcflagValue==9 || $vcflagValue==10 || $vcflagValue==11 || $vcflagValue==12)
{  
?>
<label id="PElegalad_tour"><input  class="show-nav" name="showdeals" type="radio"  value=103  <?php if($dealvalue==103) { ?> checked="checked" <?php } ?>/>Legal Advisor</label>
<label  id="peinvestor_tour2"><input  class="show-nav" name="showdeals" type="radio"  value=104  <?php if($dealvalue==104) { ?> checked="checked" <?php } ?>/>Transaction Advisor</label>
<?php
}
?></div>
    <?php
    }
    else
    {
    ?> 
<div class="showdealsby">
<label><input  class="show-nav" name="showdeals" type="radio"  value=105  <?php if($dealvalue==105) { ?> checked="checked" <?php } ?>/> Incubator/Accelerator</label>
<label><input  class="show-nav" name="showdeals" type="radio"  value=106  <?php if($dealvalue==106) { ?> checked="checked" <?php } ?>/>Incubatee</label>
</div>
    
    <?php 
    }
    ?>
</div>
</td>
</tr>
</table>
</div>
    <?php
}
?>


<script>
    $(document).ready(function(){
        
        $( "#year" ).change(function() {
            
            $("#yearchange").submit();
        });

    });

    
</script>
<script type="text/javascript">
 
<?php if($vcflagValue==0 || $vcflagValue==4 || $vcflagValue==5) { ?> 
    $("#investmentspe").show();  
     $("#investmentsvc").hide();
     $("#investmentsspecialised").show();
     $("#invspecialisedsocial").hide();
     
    
<?php } else if($vcflagValue==2 || $vcflagValue==1 || $vcflagValue==6 || $vcflagValue==3) { ?>
     $("#investmentspe").hide();  
     $("#investmentsvc").show();
      $("#invspecialisedsocial").show();
     $("#investmentsspecialised").hide();
    
<?php } ?>
    
    
    <?php if($vcflagValue==7 || $vcflagValue==9 || $vcflagValue==10) { ?> 
   $("#exitsviape").show();  
        $("#exitsviavc").hide();
     
    
<?php } else if($vcflagValue==8 || $vcflagValue==11   || $vcflagValue==12 ) { ?>
     $("#exitsviape").hide();  
        $("#exitsviavc").show();
<?php } ?>

//$('.investment-form select, .exit-form select').switchify();
//      
//    $('.ui-switch-middle').removeClass('ui-switch-middle');  	
	
         $('#investmentswitch').change(function() {
        thisvalue= $(this).val();
        if(thisvalue=="investmentspe")
        {
        
        $("#investmentspe").show();  
        $("#investmentsvc").hide();
        $("#investmentsspecialised").show();
        $("#invspecialisedsocial").hide(); 
        
        var getdealvalue = $("#getdealvalue").val();
       
        if(getdealvalue==101 || getdealvalue==102 || getdealvalue==103 || getdealvalue==104){
                $("#pesearchshowby").attr("action","pedirview.php?value=0");
                $("#pesearchshowby").submit();                    
        }
        else{
            window.location.href ='pedirview.php?value=0';
        }
        
        return false;
        
        }
        else {
        //window.location.href ='pedirview.php?value=1';    
        $("#investmentspe").hide();  
        $("#investmentsvc").show();
        $("#invspecialisedsocial").show();
        $("#investmentsspecialised").hide();
        
        var getdealvalue = $("#getdealvalue").val();
       
        if(getdealvalue==101 || getdealvalue==102 || getdealvalue==103 || getdealvalue==104){
                $("#pesearchshowby").attr("action","pedirview.php?value=1");
                $("#pesearchshowby").submit();                    
        }
        else{
            window.location.href ='pedirview.php?value=1';
        }
        
        return false;
        
        }
        });
	
	
        
        
	$('#exitswitch').change(function() { 
        thisvalue= $(this).val();
        if(thisvalue=="1")
        {
        //window.location.href ='pedirview.php?value=10';  
        $("#exitsviape").show();  
        $("#exitsviavc").hide();
        var getdealvalue = $("#getdealvalue").val();
       
        if(getdealvalue==101 || getdealvalue==102 || getdealvalue==103 || getdealvalue==104){
                $("#pesearchshowby").attr("action","pedirview.php?value=7");
                $("#pesearchshowby").submit();                    
        }
        else{
            window.location.href ='pedirview.php?value=7';
        }
        
        return false;
       
        }
        else{ 
       // window.location.href ='pedirview.php?value=11';      
        $("#exitsviape").hide();  
        $("#exitsviavc").show();
        var getdealvalue = $("#getdealvalue").val();
       
        if(getdealvalue==101 || getdealvalue==102 || getdealvalue==103 || getdealvalue==104){
                $("#pesearchshowby").attr("action","pedirview.php?value=8");
                $("#pesearchshowby").submit();                    
        }
        else{
            window.location.href ='pedirview.php?value=11';
        }
        
        return false;
       
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


$(document).ready(function(){  
$("#peinvestor_tour,#PElegalad_tour,#peinvestor_tour1,#peinvestor_tour2").click(function() {     
        if(Directorydemotour==1)
         { 
            
            var current_tour = hopscotch.getCurrStepNum(); 
            if(current_tour==12){
                 $('#peinvestor_tour div,#peinvestor_tour1 div,#peinvestor_tour2 div').removeClass("checked");  
            }
            else {
            $('#PElegalad_tour div,#peinvestor_tour1 div,#peinvestor_tour2 div').removeClass("checked");   
            $('#peinvestor_tour div').addClass("checked"); 
            }
         }
         }); 
         
 $("#PEmaexits_tour,#PEpublicexits_tour").click(function() {     
        if(Directorydemotour==1)
         { 
            var current_tour = hopscotch.getCurrStepNum(); 
            if(current_tour>=9 && current_tour<11){
            $('#PEmaexits_tour div,#PEpublicexits_tour div').removeClass("checked");
            }
            else if(current_tour==11){
            $('#PEpublicexits_tour div').removeClass("checked"); 
            }
         }
         });         
         
         
});
$(".ttl3").click(function() {
        $(this).toggleClass('active').next('.frmDropDown').toggleClass("active");
     });
         
</script>
<?php } ?>   
