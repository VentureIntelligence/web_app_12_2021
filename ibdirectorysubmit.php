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
	  <form name="ibdirectorysubmit"  method="post" action="http://www.ibinfo.in">

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


    </div>
<!--
			 <a href="pe-impact-2007.pdf"> -->
    <?php
    	$industrysql="select industryid,industry from industry order by industry";

				$nametoAdd=$_POST['txtyourname'];
				$firmnametoAdd=$_POST['txtfirmname'];
				$designationtoAdd=$_POST['txtdesignation'];
				$emailtoAdd=$_POST['txtemailid'];
				$citytoAdd=$_POST['txtcity'];
				$countrytoAdd=$_POST['txtcountry'];
				$phonetoAdd=$_POST['txtphone'];
				$firm_type=$_POST['FirmType'];
				$learntthrough=$_POST['learntthrough'];


//********Mail details

		?>

	    <div id="maintextpro">


           <div id="headingtextpro">
              <div id="headingtextprobold">IB Directory<br /> <br /></div>

			<br /></div>

						  <br /> <br />

							<input type="hidden" name="txtyourname"  value="<?php echo $nametoAdd; ?>" READONLY size=39>
							<input type="hidden" name="txtfirmname" value="<?php echo $firmnametoAdd; ?>"  READONLY  size=39>
							<input type="hidden" name="txtdesignation" value="<?php echo $designationtoAdd; ?>"  READONLY  size=39>
							<input type="hidden" name="txtcity" value="<?php echo $citytoAdd; ?>"  READONLY size=39>
							<input type="hidden" name="txtemailid" value="<?php echo $emailtoAdd; ?>" READONLY size=39>
							<input type="hidden" name="txtphone" value="<?php echo $phonetoAdd; ?>" READONLY size=39>
							<input type="hidden" name="txtcountry"  value="<?php echo $countrytoAdd; ?>"  size=39>
							<input type="hidden" name="txtfirmtype"  value="<?php echo $firm_type; ?>"  size=39>
	  						<input type="hidden" name="learntthrough" value="<?php echo $learntthrough; ?>" >

							 <div id="headingtextprobold">Final Step:  <br /><br /><br /></div>
							<div id="headingtextprobold">Industry:  &nbsp;&nbsp;&nbsp;&nbsp;
								<SELECT name="industry" style="font-family: Arial; color: #004646;font-size: 8pt">
												<OPTION id=0 value="--" selected> Choose Industry </option>
								<?php
												if ($industryrs = mysql_query($industrysql))
												{
												 $ind_cnt = mysql_num_rows($industryrs);
												}
												if($ind_cnt>0)
												{
													 While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
													{
														$id = $myrow[0];
														$name = $myrow[1];
														echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
													}
													mysql_free_result($industryrs);
												}
											?></select> <br /><br />
							</div>


							 <div id="headingtextprobold">Your Co.’s Revenue Range:  &nbsp;&nbsp;&nbsp;&nbsp;
																 <SELECT NAME=revenuerange>

																 <OPTION VALUE=1 selected>0-15 Cr</OPTION>
																 <OPTION VALUE=2>15-50 Cr</OPTION>
																 <OPTION VALUE=3>50-200 Cr</OPTION>
																 <OPTION VALUE=4>>200 Cr</OPTION>
												</SELECT>
						<br /><br /></div>

						<span style="float:right" class="one">
								<input type="submit"  value="SUBMIT" name="Submit" >
					</span> <br /> <br />

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
