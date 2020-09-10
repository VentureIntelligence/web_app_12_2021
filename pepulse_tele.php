<?php include_once("globalconfig.php"); ?>
      <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
	  "http://www.w3.org/TR/html4/loose.dtd">
	  <html>
	  <head>
	  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
	  <title>Venture Intelligence</title>
	  <SCRIPT LANGUAGE="JavaScript">
	  function ltrim(str){
	                  return str.replace(/^\s+/, '');
	              }
	              function rtrim(str) {
	                  return str.replace(/\s+$/, '');
	              }
	              function alltrim(str) {
	                  return str.replace(/^\s+|\s+$/g, '');
	              }

	  </SCRIPT>

	  <link href="style.css" rel="stylesheet" type="text/css">
	  </head>

	  <body>
	  <form name="pepulsetelephp"  method="post" action="pepulse_telesubmit.php">
	  <div id="containerproductpeimpact">

	  <!-- Starting Left Panel -->
	    <div id="leftpanel">
	      <div><a href="index.htm"><img src="images/logo.jpg" width="183" height="98" border="0"></a></div>

	      <div id="vertbgpropeimpact">

	        <div id="vertMenu">
	          <div><img src="images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Products</span></div>
	        </div>
	        <div id="linksnone"><a href="newsletters.htm">Newsletters</a><br />
	            <span id="visitlink"><a href="peroundup.htm">PE Reports</a><br />
	            </span>
	             <a href="vcroundup.htm">VC Reports</a><br />
	  		           <a href="directories.htm">Directories</a><br />
	  		           <a href="pepulsedu.htm">PE Impact Report </a> <br />
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
	  	  <div style="background-color:#FFF; width:565px; height:727px; margin-top:5px;"><div id="navpro">
	          <div class="links">
	          <!--  <ul>
	              <li><img src="images/arrow.gif" /> <a href="subscribe.htm">Subscribe</a> </li>
	              <li><img src="images/arrow.gif" /> <a href="advertise.htm">Advertise </a> </li>
	              <li><img src="images/arrow.gif" /> <a href="sponsor.htm">Sponsor</a></li>
	            </ul> -->
	          </div>
	  	  </div>
	  	    <div id="maintextpro">


	            <div id="headingtextpro">
	            <?php
	            	$yourname=$_POST['txtyourname'];

	            	$designation=$_POST['txtdesignation'];
	            	$city=$_POST['txtcity'];
	            	$emailid=$_POST['txtemailid'];
	            	$phone=$_POST['txtphone'];
	            	$firmname=$_POST['txtfirmname'];
	            	$firm_type=$_POST['FirmType'];
	            	$learnt_through=$_POST['learntthrough'];

	            ?>


	          <div id="headingtextprobold"> Private Equity Pulse on Telecom <br /> <br /></div>


		  		  <br /> <br />


	  				<input type="hidden" name="txtyourname"  value="<?php echo $yourname; ?>" READONLY size=39>


	  			<input type="hidden" name="txtdesignation" value="<?php echo $designation; ?>" READONLY size=39>


	  			<input type="hidden" name="txtcity" value="<?php echo $city; ?>"  READONLY size=39>

	  		<input type="hidden" name="txtemailid" value="<?php echo $emailid; ?>" READONLY size=39>


	  				<input type="hidden" name="txtphone" value="<?php echo $phone; ?>" READONLY size=39>

	  			<input type="hidden" name="txtfirmname" value="<?php echo $firmname; ?>"  READONLY  size=39>

	  			<input type="hidden" name="txtfirmtype"  value="<?php echo $firm_type; ?>"  size=39>

	  		<!--	<input type="radio" value="Educaion Co" name="FirmType" CHECKED  DISABLED>Education Co.
	  			&nbsp;
	  			<input type="radio" value="PE_VC Investor" name="FirmType" DISABLED>PE/VC Investor
	  			&nbsp;
	  			<input type="radio" value="Advisory Firm" name="FirmType" DISABLED >Advisory Firm
	  			&nbsp;
	  			<input type="radio" value="Other" name="FirmType" DISABLED >Other -->


	  				<input type="hidden" name="learntthrough" value="<?php echo $learnt_through; ?>" >

				 <div id="headingtextprobold">Final Step:  <br /><br /><br /></div>

				 <div id="headingtextprobold">Your Co.’s Revenue Range:  &nbsp;&nbsp;&nbsp;&nbsp;
													 <SELECT NAME=revenuerange>

													 <OPTION VALUE=1 selected>0-15 Cr</OPTION>
													 <OPTION VALUE=2>15-50 Cr</OPTION>
													 <OPTION VALUE=3>50-200 Cr</OPTION>
													 <OPTION VALUE=4>>200 Cr</OPTION>

									</SELECT>
				<br /><br /></div>


	  			<span style="float:right" class="one">
	  							<input type="submit"  value="SUBMIT TO DOWNLOAD THIS REPORT" name="Submit" >
	  				</span> <br /> <br />

	  		 </div>

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
