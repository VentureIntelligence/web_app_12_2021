<?php
$passwordForDB = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">
function checkFields()
 {
  	if((document.forgotpwd.forgotpwdemailid.value == "") )
    {
		alert("Please enter your Email Id");
		return false
 	}
}
</SCRIPT>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="forgotpwd" onSubmit="return checkFields();" method="post" action="forgotpwdsubmit.php" >
<div id="containerproductpelogin">
<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="index.htm"><img src="images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgpropelogin">

    	<div id="vertMenupelogin">

       	<!--<div>Email </div>
        	<div> <input type=text name="emailid" value="" size="23"> <br /><br /></div>
        	<div>Password </div>
        	<div> <input type=password name="emailpassword" value="" size="23"> <br /><br /> <br /></div>
	       	<div> <span style="float:right" >
        	<input type="submit" name="btnSubmit" value ="Login"> </span> <br /><br /></div>

        	<div id="headingtextproboldfontcolor"> <?php echo $displayMessage; ?></div>
        	-->


		</div>


    </div>

   </div>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->
<div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="js/top.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">

	  <div style="background-color:#FFF; width:565px; height:406px; margin-top:5px;">
		<div id="navpro">

	  </div>
	    <div id="maintextpro">

        <div id="headingtextpro">
        		<input type="hidden" name="txtpwdforDB" value="<?php echo $passwordForDB;?>" >
     	<div id="headingtextproboldfontcolor"> Forgot Password? <br />  <br /> </div>

     	<div>Enter your Email Id </div> <br />
		        	<div> <input type=text name="forgotpwdemailid" value="" size="35"> <br /><br /></div>

					<div> <span style="float:right" >
			        	<input type="submit" name="btnPwdSubmit" value ="Submit"> </span> <br /><br /></div>


		</div>
        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="js/bottom.js"></SCRIPT>
   </form>
   <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
  </script>
</body>
</html>
