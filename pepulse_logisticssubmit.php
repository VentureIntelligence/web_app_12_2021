<?php
/*header("Content-type: application/octet-stream");
header("Content-Disposition: attachment; filename=hlscompanies.xls");
header("Pragma: no-cache");
header("Expires: 0");

formname - pepulse_logisitcssubmit.php
filename - pepulse_logisitcssubmit
invoked from -pepulse_logistics.htm  AND pepulse_logistics.php ( 2 files)
*/

	  	 require("dbconnectvi.php");
	     $Db = new dbInvestments();
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>


<link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
<div id="containerproductcontactus">

<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="index.htm"><img src="images/logo.jpg" width="183" height="98" border="0"></a></div>

    <div id="vertbgprocontactus">

      <div id="vertMenu">
        <div><img src="images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;<a href="products.htm">Products</a></span></div>
      </div>
       <div id="linksnone"><a href="newsletters.htm">Newsletters</a><br />
	            <span id="visitlink"><a href="peroundup.htm">PE Reports</a><br />
	            </span>
	            <a href="vcroundup.htm">VC Reports</a><br />
	           <a href="peimpact.htm">PE Impact Report </a> <br />
	            <a href="vcmarket.htm">VC Market</a><br />
	            <a href="sector.htm">Sector Reports</a><br />
	            <a href="db.htm">Databases</a><br />
	            <a target="_blank" href="http://ventureintelligence.blogspot.com">Blog </a> </div>
	        <div id="eventslinkabt">
	          <div><img src="images/dot1.gif" />&nbsp;&nbsp;<a href="events.htm">Events</a></div>
	        </div>


	   <div id="eventslinkabt1">
	  	          <div><img src="images/dot1.gif" />&nbsp;&nbsp;<a href="news.htm">News</a></div>
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
	  <div style="width:565px; margin-top:8px;"><img src="images/product-top.jpg" width="566" height="121"></div>
	  <div style="background-color:#FFF; width:565px; height:342px; margin-top:5px;"><div id="navpro">
      <div class="links">
        <!--<ul>
          <li><img src="images/arrow.gif" /> <a href="subscribe.htm">Subscribe</a> </li>
          <li><img src="images/arrow.gif" /> <a href="advertise.htm">Advertise </a> </li>
          <li><img src="images/arrow.gif" /> <a href="sponsor.htm">Sponsor</a></li>-->
        </ul>
      </div>

    </div>
<!--
			 <a href="pe-impact-2007.pdf"> -->
    <?php
				$yourname=$_POST['txtyourname'];
				$designation=$_POST['txtdesignation'];
				$city=$_POST['txtcity'];
				$emailid=$_POST['txtemailid'];
				$phone=$_POST['txtphone'];
				$firmname=$_POST['txtfirmname'];
				$firm_type=$_POST['txtfirmtype'];
				$firm_type1=$_POST['FirmType'];
	            $learnt_through=$_POST['learntthrough'];
	            $revenue_range=$_POST['revenuerange'];

				if($revenue_range==1)
					$revenure_range_display="0-15 Cr";
				elseif($revenue_range ==2)
					$revenure_range_display="15-50 Cr";
				elseif($revenue_range ==3)
					$revenure_range_display="50-200 Cr";
				elseif($revenue_range ==4)
					$revenure_range_display="> 200 Cr";


//********Mail details
			$RegDate=date("M-d-Y");
			$to="arun.natarajan@gmail.com,darshan@ventureintelligence.com";
		   	//$to .="sowmyakvn@gmail.com";
		$subject="Logistics Rep Download-" .$revenure_range_display."-".$firmname;
		$message="<html><center><b><u>Logistics Report Download</u></b></center><br>
		<head></head>		<body >
		<table border=1 cellpadding=0 cellspacing=0  width=90% >
		<tr><td>Download Date</td><td  width=64%>$RegDate</td></tr>
		<tr><td colspan=2 ><b>Contact Details </b></td></TR>
		<tr><td >Name</td><td width=64%>$yourname</td></TR>
		<tr><td >Designation</td><td width=64%>$designation</td></TR>
		<tr><td >City</td><td width=64%>$city</td></TR>
		<tr><td >Firm Name</td><td width=64%>$firmname</td></TR>
		<tr><td >Email Id</td><td width=64%>$emailid</td></TR>
		<tr><td >Phone</td><td width=64%>$phone</td></TR>
		<tr><td >Firm Type</td><td width=64%>$firm_type$firm_type1</td></TR>
		<tr><td >Learnt through</td><td width=64%>$learnt_through</td></TR>
		<tr><td >Revenue Range</td><td width=64%>$revenure_range_display</td></TR>
		</table>
		</body>
		</html>";

		/* To send HTML mail, you can set the Content-type header. */
		$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html;
		charset=iso-8859-1\n";

		/* additional headers */
		//$headers .= "Cc: info@ventureintelligence.com\n";
		//$headers .= "cc: kanaiyan_kavitha@hotmail.com\n";

		mail($to,$subject,$message,$headers);

		//	$currentdir=getcwd();
		//	$file = $currentdir . "/cleantechcompanies.xls";
		$file="logistics-cos.txt";
		$schema_insert="";
		//TRYING TO WRIRE IN EXCEL
					 //define separator (defines columns in excel & tabs in word)
						 $sep = "\t"; //tabbed character
						 $cr = "\n"; //new line

						 //start of printing column names as names of MySQL fields

							/*echo "Reg Date"."\t";
							echo "Name"."\t";
							echo "Designation"."\t";
							echo "City"."\t";
							echo "EmailId"."\t";
							echo "Phone"."\t";
							echo "Firm Name "."\t";
							echo "Firm Type"."\t";
							echo "Revenue Range"."\t";
							echo "Learnt through "."\t";*/

							print("\n");
							 print("\n");
						 //end of printing column names
						 		$schema_insert .=$cr;
								$schema_insert .=$RegDate.$sep; //Reg Date
								$schema_insert .=$yourname.$sep; //Namek
							$schema_insert .=$designation.$sep; //desgination
							$schema_insert .=$city.$sep; //city
							$schema_insert .=$emailid.$sep; //emailid
							$schema_insert .=$phone.$sep; //phone
							$schema_insert .=$firmname.$sep; //firmname
							$schema_insert .=$firm_type.$firm_type1.$sep; //FirmType
							$schema_insert .=$revenure_range_display.$sep; //RevenueRange
							$schema_insert .=$learnt_through;  //Learntthrough
							$schema_insert = str_replace($sep."$", "", $schema_insert);
						    $schema_insert .= ""."\n";

						 	//	$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
						       //  $schema_insert .= "\t";

								if (file_exists($file))
								{
									//echo "<br>break 1--" .$file;
									 $fp = fopen($file,"a+"); // $fp is now the file pointer to file
										 if($fp)
										 {//echo "<Br>-- ".$schema_insert;
											fwrite($fp,$schema_insert);    //    Write information to the file
											  fclose($fp);  //    Close the file
											 //echo "File saved successfully";
										 }
										 else
											{
											echo "Error saving file!"; }
								}

				         print "\n";

?>

	    <div id="maintextpro">


           <div id="headingtextpro">
            <div id="headingtextprobold">PE Pulse on Logsitics & Transportation<br /> <br /></div>
           Thanks for your intrest in this report.

			<span style="float:right" class="one"> <br/>
		  	<a href="pepulse-lt-2010.pdf"><img src="images/arrow.gif" border="0" /><b>Click Here</b></a> to download the PDF version.<br/> (Recommended: Use Right Click > Save As to download to your desktop)</span>

			<br /></div>


        </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="js/bottom.js"></SCRIPT>

   <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
  </script>

  <!-- Google Code for pageview Conversion Page -->
  <script language="JavaScript" type="text/javascript">
  <!--
  var google_conversion_id = 1071969709;
  var google_conversion_language = "en_US";
  var google_conversion_format = "1";
  var google_conversion_color = "FFFFFF";
  if (1) {
    var google_conversion_value = 1;
  }
  var google_conversion_label = "pageview";
  //-->
  </script>
  <script language="JavaScript" src="http://www.googleadservices.com/pagead/conversion.js">
  </script>
  <noscript>
  <img height=1 width=1 border=0 src="http://www.googleadservices.com/pagead/conversion/1071969709/imp.gif?value=1&label=pageview&script=0">
  </noscript>


</body>
</html>
