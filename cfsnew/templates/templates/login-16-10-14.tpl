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

 
<form name="Frm_Login" id="Frm_Login" action="" method="post" onSubmit="return LoginValidate('Frm_Login')">
    
<ul>

    <li><input type="text" id="username"  name="username" value="" forError="username"   placeholder="Email"/></li>
    <li> <input type="password" name="user_password" value=""  id="user_password" placeholder="Password"/></li>
   
    <li>
    <div class="keeplogin"><input type="checkbox" name="chkTerm" CHECKED /> By accessing this database, you agree to the  <a href="../terms.htm">terms & conditions</a> of use upon which access is provided.</div>
    </li>
     
    <li><input type="submit" name="btnSubmit" value ="Login" class="fp"/> <a href="javascript:;" class="forgot-link">Forgot your password?</a> </li>
    <li><font color="red">{if $ErrMsg}{$ErrMsg}{/if}</font></li>
    <li><font color="green">{if $auth eq 1}Authorization successful. Please login now{/if}</font></li>
</ul>
</form>

</div>

<div class="login-right">

<h3>Company Financials Search  </h3>

<p>Using powerful search filters, Venture Intelligence CFS helps users narrow down and compare companies based on their industry, financial information and growth criteria for Revenue, EBITDA or PAT.</p>

<p>Unlike other databases, CFS has a standardised format for all companies which enables easier comparison.</p>

<p>Thousands of Private Company Financials are already available for download. What’s more, in case you do not find a company you are looking for, CFS enables you to make a custom request from within the database itself.</p> 



<h3>Subscription Options  </h3>

<h4>Annual Subscription</h4>

<p>For PE/VC Firms, Investment Banks, Corporate Law Firms and other service providers in the transactions ecosystem, an annual subscription to the database - either as a standalone product / in combination with our PE/VC and M&A transactions databases - would be the most cost-effective option.</p>
<div class="price-subscribe">For pricing/subscription details <a href="https://www.ventureintelligence.com/dd-subscribe.php">Click Here.</a></div>
<div class="free-trail"><span>Request for a  free trial login</span> <a href="https://www.ventureintelligence.com/trialrequest.php">Request Now</a></div>
<br><br><br><br>
<p>OR</p>

<h4>One off Requirement</h4>

<p>Ideal for someone seeking to research potential customers, vendors and competitors. Just email the list of companies (that you would like the financials for) <strong>along with your contact details</strong> to <a href="mailto:cfs-sales@ventureintelligence.com">cfs-sales@ventureintelligence.com</a> and we will revert with a custom price quote. (Pricing: Just Rs 5,000 for 3 companies; Rs 1,500 per additional company.)</p> 



</div>

</div>

</div>  

</body>
</html>

