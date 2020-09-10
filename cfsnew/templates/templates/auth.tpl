<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>{$pageTitle}</title>
<meta  name="description" content="{$pageDescription}" />
<meta name="keywords" content="{$pageKeyWords}" />
<link href="css/screen.css" rel="stylesheet" type="text/css" />
<link rel="stylesheet" href="css/doc.css" />
<link rel="stylesheet" href="css/login.css" />
    
<script type="text/javascript" src="http://code.jquery.com/jquery-1.7.js"></script>  
<script type="text/javascript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="js/ui.dropdownchecklist.js"></script>
<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
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
<li><a href="https://www.ventureintelligence.com/index.htm">Home</a></li>
    <li><a href="https://www.ventureintelligence.com/products.htm" class="active">Products</a></li>
    <li><a href="https://www.ventureintelligence.com/events.htm">Events</a></li>
    <li><a href="https://www.ventureintelligence.com/news.htm">News</a></li>
    <li><a href="https://www.ventureintelligence.com/aboutus.htm">About Us</a></li>
    <li class="last"><a href="https://www.ventureintelligence.com/contactus.htm">Contact Us</a></li>
</ul>
</div>
    
<div class="login-container">

<div   class="login-left">
</div>

<div class="login-right">

<form name="pelogin" onSubmit="return checkFields();" method="post" action="" >
    <p style="color:#F10000;font-weight: bold;background: #fff;width:52.5%;padding: 1% 4%;border-radius: 2px;font-size: 13px;line-height: 16px;">Please await email from Venture Intelligence (in your registered email id) containing your authorization code.</br><small style="font-size: 11px">Please check your spam/junk folder also.</small></p> 
    <ul style="width:300px">
        <li style="text-align: center"><h3>Device Authorization</h3></li>
        <li><label>Email</label> <input type=text name="emailid" value="{$emailid}" style="padding: 5px;"/></li>
        <li><label>Authorization Code</label> <input type=password name="authCode" value="{$authCode}" style="padding: 5px;"/></li>
         <input type="hidden" value="{$device}" name="autdevice" ></input>
        <li><input type="submit" name="btnSubmit" value ="Authorize" class="fp"/> <a href="https://www.ventureintelligence.com/contactus.htm" class="fp">Contact us for any questions</a></li>
        <li><font color="red">{$displayMessage}</font></li>
        <li><font color="green">{$successMessage}</font></li>
   </ul>

</form>



</div>

</div>

</div>  
<div style="clear: both;"></div> 
  <footer class="footer-container footer-posnot">
      <div class="footer-sec"> <span>© 2018 TSJ Media Pvt Ltd. All rights reserved. </span> <!--<a href="http://kutung.com/" class="fr">it's a kutung</a>--> </div>
  </footer>
</body>
</html>

