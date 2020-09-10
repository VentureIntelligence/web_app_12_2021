<?php include_once("globalconfig.php"); ?>
<?php

/*
formname - peimpactsubmit
filename - peimpactsubmit.php
invoked from -peimpact.htm
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
	            <a target="_blank" href="<?php echo GLOBAL_BASE_URL; ?>blog">Blog </a> </div>
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
				$nametoAdd=$_POST['txtyourname'];
				$firmnametoAdd=$_POST['txtfirmname'];
				$emailtoAdd=$_POST['txtemailid'];
				$citytoAdd=$_POST['city'];
				$countrytoAdd=$_POST['country'];
				$phonetoAdd=$_POST['phone'];
				$jobdescription=$_POST['jobdescription'];
				$learntthrough=$_POST['learntthrough'];


//********Mail details


			$RegDate=date("M-d-Y");
			$to="arun.natarajan@gmail.com,arihant@ventureintelligence.com";
		   	//$to .="sow_ram@yahoo.com";
                        
		$subject="PE Impact download -" .$firmnametoAdd;
		$message="<html><center><b><u>PE Impact</u></b></center><br>

		<head>
		</head>
		<body >
		<table border=1 cellpadding=0 cellspacing=0  width=90% >

		<tr><td>Reg Date</td><td  width=64%>$RegDate</td></tr>

		<tr><td colspan=2 ><b>Contact Details </b></td></TR>
		<tr><td >Name</td><td width=64%>$nametoAdd</td></TR>
		<tr><td >Firm Name</td><td width=64%>$firmnametoAdd</td></TR>
		<tr><td >Email Id</td><td width=64%>$emailtoAdd</td></TR>
		<tr><td >City</td><td width=64%>$citytoAdd</td></TR>
		<tr><td >Country</td><td width=64%>$countrytoAdd</td></TR>
		<tr><td >Phone</td><td width=64%>$phonetoAdd</td></TR>
		<tr><td >Job Description</td><td width=64%>$jobdescription</td></TR>
		<tr><td >Learnt through</td><td width=64%>$learntthrough</td></TR>


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
    $headers .= 'Bcc: saranya@kutung.in' . "\r\n";

		mail($to,$subject,$message,$headers);

		//echo $message;


		$file="peimpact-downloads.txt";
				$schema_insert="";

				//TRYING TO WRIRE IN EXCEL
				 //define separator (defines columns in excel & tabs in word)
					 $sep = "\t"; //tabbed character
					$cr = "\n"; //new line


									$schema_insert .=$cr;
									$schema_insert .=$RegDate.$sep; //Reg Date
									$schema_insert .=$yourname.$sep; //Name
									$schema_insert .=$emailtoAdd.$sep; //emailid
									$schema_insert .=$firmnametoAdd.$sep; //firmname
									$schema_insert .=$citytoAdd.$sep; //city
									$schema_insert .=$countrytoAdd.$sep; //country
									$schema_insert .=$phonetoAdd.$sep; //phone
									$schema_insert .=$jobdescription.$sep; //job description
									$schema_insert .=$learntthrough;  //Learntthrough

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
			           <div id="headingtextprobold">PE Impact 2011 <br /></div>
			           This first-of-its-kind report in India includes a quantitative comparison
			           of PE- and VC-backed companies vis-à-vis their non PE-backed counterparts as well as the relevant market
			           indices. <br /><br />

						The report also features case studies of successful PE/VC-backed companies from across sectors showing how these organizations benefited from PE/VC investments
						and the lessons learnt in the process.
 				<br /> <br />

						<span style="float:right" class="one">
					  <a href="downloads/pe-impact-2011.pdf"><img src="images/arrow.gif" border="0" /> Download this report </a></span><br /><br />
           <!--<div id="headingtextpro">
            <div id="headingtextprobold">PE Impact 2008 <br /></div>
           The PE Impact 2008 Report has a special focus on Infrastructure - widely identified as the key
           constraint for India’s growth.   In addition to taking a look at the current investment climate in Indian infrastructure,
           The Report features eight case studies of successful partnerships with Private Equity in India. <br /> <br />

			<span style="float:right" class="one">
		  	<a href="pe-impact-2008.pdf"><img src="images/arrow.gif" border="0" /> Download this report </a></span>

			<br /></div>-->





			</div>
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
