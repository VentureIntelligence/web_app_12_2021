<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="https://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<!-- <title>{$pageTitle}</title> -->
<title>Private Company Financials Database</title>
<meta  name="description" content="{$pageDescription}" />
<meta name="keywords" content="{$pageKeyWords}" />
<link href="css/screen.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/doc.css" />
<link rel="stylesheet" href="css/login.css" />

<script src="https://www.google-analytics.com/urchin.js" type="text/javascript"></script>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.7.js"></script>  
<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="js/ui.dropdownchecklist.js"></script>
<link rel="stylesheet" href="https://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
{literal}
    
<script language="JavaScript" type="text/javascript">
	function submitForm(){
		document.Frm_Login.submit();
	}
	function removeIframe(){
		document.getElementById( 'mRbjH' ).setAttribute( 'src', '' );
	}
</script>

{/literal}
</head>

<body class="loginpage"> 
 
<!--Header-->

<div class="login-screen">

<div class="headerlg">
<div class="cnt-left"><div class="logo"><a href="javascript:;"><img src="images/logo.png" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></a></div></div>
<ul>
<li><a href="{$smarty.const.BASE_URL}index.htm">Home</a></li>
    <li><a href="{$smarty.const.BASE_URL}products.htm" class="active">Products</a></li>
    <li><a href="{$smarty.const.BASE_URL}events.htm">Events</a></li>
    <!--<li><a href="https://www.ventureintelligence.com/news.htm">News</a></li>-->
    <li><a href="{$smarty.const.BASE_URL}aboutus.htm">About Us</a></li>
    <li class="last"><a href="{$smarty.const.BASE_URL}contactus.htm">Contact Us</a></li>
</ul>
</div>
    
<div class="login-container">

<div   class="login-left">

 
<form name="Frm_Login" id="Frm_Login" action="" method="post" onSubmit="return LoginValidate('Frm_Login')">
    
<ul>

    <li><input type="text" id="username"  name="username" value="" forError="username"   placeholder="Email"/></li>
    <li> <input type="password" name="user_password" value=""  id="user_password" placeholder="Password"/></li>
   
    <li>
    <div class="keeplogin"><input type="checkbox" name="chkTerm" CHECKED /> By accessing this database, you agree to the  <a href="{$smarty.const.BASE_URL}terms.htm">terms & conditions</a> of use upon which access is provided.</div>
    </li>
     
    <li><input type="submit" name="btnSubmit" value ="Login" class="fp"/> <a href="../forgetpwd.php" class="forgot-link">Forgot your password?</a> </li>
    {if ($displayMessage || $displayMessage2) }<li><font color="red">{if $displayMessage}{$displayMessage}{/if}</font> {if $displayMessage2}{$displayMessage2}{/if} </li>{/if} 
    {if ($ErrMsg || $ErrMsg2)}<li><font color="red">{if $ErrMsg}{$ErrMsg}{/if}</font> {if $ErrMsg2}{$ErrMsg2}{/if} </li>{/if} 
    {if $auth eq 1}<li><font color="green">{if $auth eq 1}Authorization successful. Please login now{/if}</font></li>{/if} 
</ul>
</form>
<div style="margin-top:40px;">
    <a href="https://play.google.com/store/apps/details?id=com.venture.intelligence" target="_blank"><img src="images/googleplay.png" width="160" height="50"></a><p style="color: #000;padding: 5px 0px;">Private Co. Financials at your fingertips</p>
</div>

</div>

<div class="login-right">

<h3>Company Financials Search  </h3>

<p>Using powerful search filters, Venture Intelligence CFS helps users narrow down and compare companies based on their industry, financial information and growth criteria for Revenue, EBITDA or PAT.</p>
<!-- <p>Unlike other databases, CFS has a standardised format for all companies which enables easier comparison.</p> -->
<p>Thousands of Private Company Financials are already available for download. What’s more, in case you do not find a company you are looking for, CFS enables you to make a custom request from within the database itself.</p>


<h3 style='padding: 25px 0 10px 0;'>Subscription Options  </h3>
<table cellspacing="7"  cellpadding="5" width="100%" borde="1" style="border: solid 1px #ccc;">
    <tr>
        <td style="border-right: solid 1px #ccc;padding-right: 2px;">
<h4>Annual Subscription</h4>

<p style='padding-bottom:1px;' >For PE/VC Firms, Investment Banks, Corporate Law Firms and other service providers in the transactions ecosystem, an annual subscription to the database - either as a standalone product / in combination with our PE/VC and M&A transactions databases - would be the most cost-effective option.</p>

<!--<div class="free-trail"><span>For pricing/subscription details</span> <a href="https://www.ventureintelligence.com/dd-subscribe.php">Click Here.</a></div>-->


<div class="free-trail"><span>Request a demo</span> <a href="{$smarty.const.BASE_URL}trial.htm">Click Here</a></div>

</td>
        <td>

<h4>One off Requirement</h4>

<p>Ideal for someone seeking to research competitors. Or potential customers, vendors, or even new employers - it’s the least you can do to avoid nasty surprises owing to shaky financials!</p>
<p>Just email the list of companies (that you would like the financials for) <b>along with your contact details to </b>
    <a href="mailto:sales@ventureintelligence.com">sales@ventureintelligence.com</a> and we will revert with the availability details and price quote. (Indicative Pricing: Just INR 5,000 for 3 companies; INR 1,500 per additional company.)</p>
</td>
        </tr>
</table>


</div>


</div>

</div> 
<div style="clear: both;"></div> 
<footer class="footer-container">
    <div class="footer-sec"> <span>© TSJ Media Pvt Ltd. All rights reserved. </span> <!--<a href="http://kutung.com/" class="fr">it's a kutung</a>--> </div>
</footer>

{php} 
$device_list_flag = $this->get_template_vars('device_list_flag');
if($device_list_flag) {
{/php}    
<div class="popup_main" id="popup_main" style="display:none1;">
    
<div class="popup_box">
<!--  <h1 class="popup_header">Financial Details</h1>-->
<span class="popup_close"><a href="javascript: void(0);">X</a></span>
  <div class="popup_content" id="popup_content">
      
      <form name="authform" method="post" action="authdevice.php" onSubmit="return checkpopup();">
      <p  class="pop-header">Your Login is already authorized in the following 3 Browsers*. 
      <br>  Please select one of them to deauthorize</p>
      <div class="pop-div">
      {php}
           $emailid = $this->get_template_vars('emailid');

           $device_array = $this->get_template_vars('devices_array'); 
           $device_array_list = $this->get_template_vars('devices_array_list');
           $deviceDetail_devices =array();
             
            $count= 1; 
            $deviceDetail_versions = array();
            $min_version="";
            $targer_device_compare=""; 

            foreach($device_array_list as $device_name_array) { 
                $current_device_name_match = preg_match("/(.+)\_[0-9]+/", $device_name_array, $current_matched_name);
                $current_matched_name_string = $current_matched_name[1];  
                array_push($deviceDetail_devices,$current_matched_name_string);
            }
            // print_r($deviceDetail_devices);
            
            $repeated_device_name = array_not_unique($deviceDetail_devices);
	        $repeated_device_name = $repeated_device_name[0];

            foreach($device_array as $da){  
                $counts = array_count_values($deviceDetail_devices);  
                $current_device_name_match = preg_match("/(.+)\_[0-9]+/", $da['device_details'], $current_matched_name); 
                $current_matched_name_string = $current_matched_name[1];
                if($counts) {
                    @$repeated_device_count = $counts[$current_matched_name_string]; 
                    if($repeated_device_count >=2 && $repeated_device_name == $current_matched_name_string ) { 
                        $targer_device = $da['device_details']; 
                        $current_device_version_match = preg_match("/([0-9].+)/", $da['device_details'], $current_matched_version);
                        $current_device_version_match = $current_matched_version[1];
                        $current_matched_name_string; 
                        array_push($deviceDetail_versions,$current_device_version_match);   
                        $min_version = min(@$deviceDetail_versions); 
                    }   
                } 	 		
 
            }  
           // print_r($deviceDetail_versions);

            
            $targer_device_compare = $repeated_device_name."_".$min_version; 

            foreach($device_array as $da) {  
                if ($da['device_details'] == @$targer_device_compare) {	 
                    echo "<p style='width:100%; float:left;'> <b class='recommended'>Recommended</b>   &nbsp; <input type='radio' name='dauth' value=".$da['id'].' id="dauth'.$count.'" class="popup-label" >
                            <label class="popup-label-text" for="dauth'.$count.'">  '. $da['device_details'].'</label></p>';
                } else {
                    echo "<p style='width:100%; float:left;'><b class='recommended'> &nbsp;</b>  &nbsp;   <input type='radio' name='dauth' value=".$da['id'].' id="dauth'.$count.'" class="popup-label" >
                            <label class="popup-label-text" for="dauth'.$count.'">'. $da['device_details'].'</label></p>';
                } 
                 $count++;		
            }


            /* foreach($device_array as $da){ 
                echo "<input type='radio' name='dauth' value=".$da['id'].' id="dauth'.$count.'" class="popup-label" ><label class="popup-label-text" for="dauth'.$count.'">'.$da['device_details'].'</label><br>';
                $count++;
            } */
           
        {/php}
      <input type="hidden" name="device_details" value="{if $device_details}{$device_details}{/if}" >
      <input type="hidden" name="user_email" value="{if $emailid}{$emailid}{/if}" >
        <input type="hidden" name="user_password" value="{if $emailpassword}{$emailpassword}{/if}" >
      
      <div class="text-center" style="margin-left: -25px;">
        <button class="pop-btn"> Submit </button>
      </div>
      </div>
      <p class="authnotes">* Note: Updated versions of your browser get counted as a "new" browser. </p>
      </form>

</div>
</div>	
</div>
{php} } 

function array_not_unique($input) {
       $duplicates=array();
       $processed=array();
       foreach($input as $i) {
           if(in_array($i,$processed)) {
               $duplicates[]=$i;
           } else {
               $processed[]=$i;
           }
       }
       return $duplicates; 
   }


{/php}
{literal}
<style>
div.token-input-dropdown-facebook{
    z-index: 999;
}
.text-center{
  text-align: center;
}
.popup_content ul.token-input-list-facebook{
    height: 39px !important;
    width: 537px !important;
}
.popup_main
{
        position: fixed;
        left:0;
        top:0px;
        bottom:0px;
        right:0px;
        background: rgba(2,2,2,0.5);
        z-index: 999;
}
.popup_box
{
	width:500px;
	height: 0;
	position: relative;
	left:0px;
	right:0px;
	bottom:0px;
	top:35px;
	margin: auto;
	
}

.pop_menu ul li {
    margin-right: 0;
    background: #413529;
    margin-bottom: 10px;
    width: 10%;
    cursor: pointer;
    text-align: center;
    color: rgba(255,255,255,1);
    display: table-cell;
    vertical-align: middle;
    height: 60px;
    font-size: 14px;
}

.pop_menu ul li:first-child {
    margin-right: 0;
    background: #ffffff;
    margin-bottom: 10px;
    width: 10%;
    cursor: pointer;
    text-align: center;
    color: #413529;
    display: table-cell;
    vertical-align: middle;
    height: 60px;
    font-size: 14px;
    border:1px solid #413529;
}
.popup_content
{
	background: #ececec;
        border:3px solid #211B15;
}
.popup_form
{
	width:700px;
	border:1px solid #d5d5d5;
	background: #fff;
	height: 40px;
}
.popup_dropdown
{
	 width: 155px;
	 margin:0px;
	 border: none;
	 height: 40px;
	 -webkit-appearance: none;
	 -moz-appearance: none;
	 appearance: none;
	 background: url("images/polygon1.png") no-repeat 95% center;
	 padding-left: 17px;
	 cursor: pointer;
	 font-size: 14px;
}
.popup_text
{
	width:538px;
	border: none;
	border-left:1px solid #d5d5d5;
	padding-left: 17px;
	box-sizing: border-box;
	height: 40px;
	font-size: 16px;
	float: right;
}
.auto_keywords
{
	position: absolute;
	top: 106px;
	width:537px;
	background: #fff;
        border:1px solid #d5d5d5;
        border-top: none;
        display: none;
}
.auto_keywords ul
{
	line-height: 25px;
	font-size: 16px;
}

.auto_keywords ul li
{
 padding-left: 20px; 
 cursor:pointer;
}
.auto_keywords ul li a
{
  text-decoration: none;
  color: #414141;
}
.auto_keywords ul li:hover
{
   background: #f2f2f2;                                 
}
.popup_btn
{
	text-align: center;
	padding: 33px 0 50px;
	
}
.popup_cancel
{
	background: #d5d5d5;
	cursor: pointer;
	padding:10px 27px;
	text-align: center;
	color: #767676;
	text-decoration: none;
	margin-right: 16px;
	font-size: 16px;
	display: none;
	
}
.popup_btn input[type="button"]
{
	background: #a27639;
	cursor: pointer;
	padding:10px 27px;
	text-align: center;
	color: #fff;
	text-decoration: none;
	font-size: 16px;
	float: right;

}
.popup_close
{
    color: #fff;
    right: 0px;
    font-size: 20px;
    position: absolute;
    top: 1px;
    width: 15px;
    background: #413529;
    text-align: center;
}
.popup_close a
{
	color: #fff;
	text-decoration: none;
	cursor: pointer;
}
.popup_searching
{
	width:538px;
	float: right;
        position: relative;
}
div.token-input-dropdown{
        z-index: 999 !important;
}

.detail-table-div { display:block; float:left; overflow:hidden;border:1px solid #B3B3B3;}
.detail-table-div table{ border-top:0 !important; border-bottom:0 !important; width:auto !important; margin:0 !important;  }
.detail-table-div th{background:#E5E5E5; text-align:right !important;}
.detail-table-div td{ background:#fff; min-width:130px; text-align:right !important;}
/*.detail-table-div th:first-child {    max-width: 280px; text-align:left !important;
    min-width: 280px;  background:#C9C2AF;}*/
.detail-table-div th:first-child {    max-width: 240px; text-align:left !important;min-width: 240px;  background:#C9C2AF;padding:8px;}
.detail-table-div td:first-child {    max-width: 240px; text-align:left !important;min-width: 240px; background:#E0D8C3;}
.detail-table-div td { padding:8px;}
    
.tab-res{ display:block; overflow-y:hidden !important; overflow:auto; border:1px solid #B3B3B3; margin:10px 0 !important;}
.tab-res table{ border-top:0 !important; border-bottom:1px solid #B3B3B3; border-right:1px solid #B3B3B3; width:auto !important; margin:0 !important;  }
.tab-res th{background:#E5E5E5; text-align:right !important;}
.tab-res td{ background:#fff; min-width:150px; text-align:right !important;padding:8px; border-right: 1px solid #b3b3b3;}
.tab-res table thead th {
    border-bottom: 1px solid #b3b3b3;
    border-right: 1px solid #b3b3b3;
    text-align: left;
    padding: 8px;
    font-weight: bold;
}

.tab-res th {
    background: #E5E5E5;
    text-align: right !important;
}
detail-table-div table thead th:last-child {
    border-right: 0 !important;
}

.tab-res table thead th {
    border-bottom: 1px solid #b3b3b3;
}

#allfinancial {
    display: inline-block; 
    font-size: 17px;
    color:#804040;
    font-weight: bolder;
    cursor:pointer;
    float:right;
}
.recommended {
    float:left;
    width:22%;
}

.popup-label { 
    /* margin:5px 10px 30px 40px !important; */
    float:left !important;
   
}

/* .popup-label-text {  font-weight: bold; } */
 
 .popup-label-text { width:75% !important;  } 
 

.pop-div{
    padding: 20px 0px 0px 25px;
}

.pop-btn{
    margin: 10px 0px 10px 0px;
}
.pop-header{
    text-align: center;
    font-size: 14px; 
    font-weight: bold;
    padding: 10px 0px 0px 0px;
}
.authnotes{
    font-size:12px;
    margin-bottom: 10px;
    text-align: center;
}

@media (min-width:1366px) and (max-width: 2559px) {
    #allfinancial {
        margin-right: 5px;
    }
}

@media (max-width:1500px){
    .popup_content {
        background: #ececec;
        /* height: 500px; */
        overflow-y: auto;
    }
    .popup_main {
        top: 0px;
    }
    
}

@media (max-width:1025px){
       .popup_content {
            /* min-height: 500px; */
        }
        .popup_main {
            top: 0px;
        }
        
}
@media (min-width:780px){
       
    .popup_content {
            min-height: 225px;
        }
    .list_companyname{
        margin-left:160px !important;
    }
 
    .popup_box
    {
            
            top:250px !important;
        
    }
    

}
@media (max-width:600px){
    .popup_box
    {
        width:20% !important;
    }
    
}
@media (min-width:1280px){
       
    .list_companyname{
        margin-left:250px !important;
    }
}
@media (min-width:1439px){
       
    .list_companyname{
        margin-left:340px !important;
    }
}
@media (min-width:1639px){
       
    .list_companyname{
        margin-left:520px !important;
    }
}

@media (min-width:1921px){
    
    .popup_content
    {
        background: #ececec;
        height: 600px;
        overflow-y: auto;
    }
    
}
    

/* Styles */


</style>

<script>    
   
    $(document).ready(function(){
        
        $('.popup_close a').click(function(){
            $(".popup_main").hide();
            
         });
   
        $('#deviceauth').click(function(){
                $(".popup_main").show();
               
        });
    });
    

function checkpopup()
{
    if((document.authform.dauth.value == ""))
    {
            alert("Please choose any one of the existing device.");
            return false
    }
 	
}
</script>
{/literal}
</body>
</html>

