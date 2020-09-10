<?php
include "onlineaccount.php";
$pwdemail=$_POST['forgotpwdemailid'];
$pwdForDB=$_POST['txtpwdforDB'];
$displayMessage="";
require("dbconnectvi.php");
$Db = new dbInvestments();
if(trim($pwdemail)!="")
{
	$checkForUnknownLoginSql="select * from dealmembers where EmailId='$pwdemail'";
	if($rsRandom=mysql_query($checkForUnknownLoginSql))
	{
		$random_cnt= mysql_num_rows($rsRandom);
	}
	//echo "<br>----" .$random_cnt;
	if($random_cnt==1)
	{
		if($pwdForDB=="P")
			$DBPwd= "PE";
		elseif($pwdForDB=="M")
			$DBPwd="M&A";
		elseif($pwdForDB=="R")
			$DBPwd="Real Estate";
		$displayMessage=$forgotpwdMessage;
		$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html;
		charset=iso-8859-1;Content-Transfer-Encoding: 7bit\n";

		/* additional headers
		$headers .= "Cc: sow_ram@yahoo.com\r\n"; */

		$RegDate=date("M-d-Y");
		$to="arun.natarajan@gmail.com,subscription@ventureintelligence.in";
		$subject="Send Pwd to -" .$pwdemail ;
		$message="<html><center><b><u>Password has to be sent to</u></b></center><br>
		<head>
		</head>
		<body>
			$DBPwd Password has to be sent to - $pwdemail
					</body>
				 	</html>";
		mail($to,$subject,$message,$headers);
	}
	else
	{
		$displayMessage=$UnauthorisedLoginMessage;

	}
}



?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">

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
		        <!--<div class="links">
		          <ul>
		            <li><img src="images/arrow.gif" /> <a href="subscribe.htm">Subscribe</a> </li>
		            <li><img src="images/arrow.gif" /> <a href="advertise.htm">Advertise </a> </li>
		            <li><img src="images/arrow.gif" /> <a href="sponsor.htm">Sponsor</a></li>
		          </ul>
		        </div>-->
	  </div>
	    <div id="maintextpro">

        <div id="headingtextpro">
     	<div id="headingtextproboldfontcolor">  <br />  <br /> </div>

     	<div> <?php echo $displayMessage; ?> </div> <br />



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
