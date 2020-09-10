<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>


<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="containerproductnews">

<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="index.htm"><img src="images/logo.jpg" width="183" height="98" border="0"></a></div>

    <div id="vertbgpronews">

      <div id="vertMenu">
        <div><img src="images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;<a href="products.htm">Products</a></span></div>
      </div>
      <div id="eventslinkabt1">
        <div><img src="images/dot1.gif" />&nbsp;&nbsp;<a href="events.htm">Events</a></div>
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
	  <div style="width:565px; margin-top:8px;"><img src="images/event-top.jpg" width="566" height="121"></div>
	  <div style="background-color:#FFF; width:565px; height:197px; margin-top:5px;"><div id="navpro">
        <div class="links">
          <ul>
            <li><img src="images/arrow.gif" /> <a href="subscribe.htm">Subscribe</a> </li>
            <li><img src="images/arrow.gif" /> <a href="advertise.htm">Advertise </a> </li>
            <li><img src="images/arrow.gif" /> <a href="sponsor.htm">Sponsor</a></li>
          </ul>
        </div>
	  </div>
	  <?php

	  // To insert datas into tables VIRequest,Members
	  //Get count for reqno and update counter table

	  $whosubmitted=$_POST['whosubmitted'];

	  $bestfundearlystage=$_POST['bfes'];

	  $bestfundgrowthstage=$_POST['BFGS'];
	  $bestfundlatestage=$_POST['BFLS'];

	  $bestcompanyearlystage=$_POST['BCES'];
	  $bestcompanygrowthstage=$_POST['BCGS'];

	$bestcompanylatestage=$_POST['BCLS'];

	  /* mail */
	  				$strTableToAdd="";
	  				$OpenTableTag="<table border=1 cellpadding=1 cellspacing=0 ><td>";
	  				$CloseTableTag="</td></table>";
	  				$headers  = "MIME-Version: 1.0\r\n";
	  				$headers .= "Content-type: text/html;
	  				charset=iso-8859-1\r\n";
	  				/* additional headers
	  				$headers .= "Cc: sow_ram@yahoo.com\r\n"; */
	  				$RegDate=date("M-d-Y");
	  				//$to="arun.natarajan@gmail.com,info@ventureintelligence.com";
	  				$to="sow_ram@yahoo.com";
	  				$subject="APEX - Jury Votes";
	  				$message="<center><b><u>Jury Vote Details</u></b></center><br>

	  				<table border=0 cellpadding=0 cellspacing=2  width=90%>
	  				<tr><td > Date</td><td >$RegDate</td></tr>
	  				<tr> <td colspan=2><b>Private Equity Funds </b> </td></tr>
	  				<tr><td >Best Fund - Early Stage</td><td width=64%>$bestfundearlystage</td></tr>

	  				<tr><td >Best Fund - Growth Stage</td><td width=64%>$bestfundgrowthstage</td></tr>

	  				<tr><td >Best Fund - Late Stage & PIPE</td><td width=64%>$bestfundlatestage</td></tr>


	  				<tr> <td colspan=2><b>Private Equity-backed Companies </b> </td></tr>
	  				<tr><td >Early Stage</td><td >$bestcompanyearlystage</td></tr>

	  				<tr><td >Growth Stage</td><td width=64%>$bestcompanygrowthstage</td></tr>

	  				<tr><td>Late Stage</td><td>$bestcompanylatestage</td></tr>


	  				<tr> <td colspan=2><b>Submitted By </b> </td></tr>
	  				<tr><td >Name</td><td >$whosubmitted</td></TR>


	  				<td width=80%>$OpenTableTag $strTableToAdd $CloseTableTag</td></tr>
	  				</table>";
	  				mail($to,$subject,$message,$headers);

	    	?>

	    <div id="maintextpro">
          <div id="headingtextpro">
		  	<div id="headingtextprobold">  Jury Votes   <br /></div>
		  	Thank you for taking the time and effort to submit your Jury Votes. <br /><br /> <br />

			<div id="headingtextprobold"> <a href="juryloginew.php">Resubmit</a>  <br /></div>
			 <br />
          </div>  <!-- End if headingtextpro -->

        </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
  <SCRIPT LANGUAGE="JavaScript1.2" SRC="js/bottom.js"></SCRIPT>
</body>
</html>
