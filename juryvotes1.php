<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>


<link href="style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body>
<form name="juryvotes" method="post" action="juryvotessubmit.php" >


<div id="containerproductjuryvotes">

<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="index.htm"><img src="images/logo.jpg" width="183" height="98" border="0"></a></div>

    <div id="vertbgprojuryvotes">

      <div id="vertMenu">
        <div><img src="images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;<a href="products.htm">Products</a></span></div>
      </div>
      <div id="eventslinkabt1">
        <div><img src="images/dot1.gif" />&nbsp;&nbsp;<span class="linkhover">Events</span></div>
      </div>
      <div id="linksnone"><a href="#">Upcoming Events</a><br />
          <span id="visitlink"><a href="#">Past Events</a><br />
        </span> </div>
      <div id="eventslinkbotom">
        <div></div>
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
	  <div style="background-color:#FFF; width:565px; height:1100px; margin-top:5px;"><div id="navpro">
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

	  <?php
	  	  require("dbconnectvi.php");
			$Db = new dbConnect();

		/*
			//$link = mysql_connect("ventureintelligence.ipowermysql.com", "root",  "");
			$link = mysql_connect("ventureintelligence.ipowermysql.com", "venturei_admin",  "admin");
			$dbname="venturei_Tsjmedia";
			mysql_select_db($dbname);
		*/

	  	$loginemail="";
	  	$loginpassword="";
	  	$loginemail=$_POST['companyloginemail'];

	  	$loginpassword=$_POST['companyloginpassword'];

		if(($loginemail != "")  && ($loginpassword!=""))
		{
			//check for validtiy.
			$sql="select email,name,password from jurylogin
			 where email='$loginemail' and password ='$loginpassword'";
			//echo "<Br>--" .$sql;
			if ($selectrs = mysql_query($sql))
			{
				$row_cnt = mysql_num_rows($selectrs);
			}
			if($row_cnt==1)
			{
				While($myrow=mysql_fetch_array($selectrs, MYSQL_BOTH))
				{
					$juryname = $myrow["name"];
				}
			?>

				  <div id="headingtextprobold">  Venture Intelligence Awards for Private Equity Excellence (APEX) <br /> <br /></div>

				  <div id="headingtextpro"> Welcome <b> <?php echo $juryname;?> </b> <br /> <br /> </div>
				  <div id="headingtextprobold">
					<input type=hidden name="whosubmitted" value="<?php echo $juryname;?>">
				  </div>


				  Please find below the nominations for the Venture Intelligence APEX Awards for this year.
					The nominations were based on Venture Intelligence research and a poll of various members of the PE/VC Ecosystem.

<br /><br /><div id="headingtextprobold"><u>Criteria for nominations</u><br /> <br /></div>

				 <div id="headingtextprosubbold">
				 <img src="images/dot1.gif" /> <b>Exits</>  <br />
				 <img src="images/dot1.gif" /> Successful raising of a follow-on fund  <br />
				 <img src="images/dot1.gif" /> Ability to find exclusive and different kind of deal flow <br />
				 <img src="images/dot1.gif" /> Quality of Portfolio (including follow-on financing) <br /> <br />
				 </div>
					<u>Please note that the period of consideration is calendar 2009 and that the winners for the immediate previous year are excluded from consideration this year.</u><br><br>


Please select from among the nominees in the following categories: <br />
<br><i>(The individual jury votes are treated strictly confidential and directed exlusively for
					identifying the final winners.)</i> <br /> <br />



				 <!--<div id="headingtextprobolduline">  Private Equity Funds   <br /> </div>-->

				 <div id="headingtextprobold"><u>Best Fund - Venture Capital & Specialized</u><br /> </div><br />


                                 <input type="radio" value="Accel India" name="bfes">
                                 <A HREF="noplace" onMouseover="alert('Please Tell Your Friends About Wallpaperama.com'+' ' +'ssssssssss')">
                                 Accel India (fomerly Erasmic Ventures)</A>
                                 <br/>
				 <input type="radio" value="Nexus India Capital" name="bfes">Nexus India Capital<br />
				 <input type="radio" value="Rabo" name="bfes">Rabo Equity (India Agri Business Fund)<br />
				 <br /><br />
				<div id="headingtextprobold"><u>Best Fund - Mid-Market</u><br /></div><br />
				<input type="radio" value="Avigo Capital" name="BFGS">Avigo Capital<br />
				<input type="radio" value="India Value Fund" name="BFGS">India Value Fund<br />
				<input type="radio" value="NYLIM India" name="BFGS">NYLIM India<br />
				<!--<input type="radio" value="Peepul Capital" name="BFGS">Peepul Capital <br /><br />-->
<br /><br />
				<div id="headingtextprobold"><u>Best Fund - Late Stage</u><br /></div><br />
				<!--<input type="radio" value="3i" name="BFLS">3i<br />-->
				<input type="radio" value="ChrysCapital" name="BFLS">ChrysCapital<br />
				<input type="radio" value="Citi" name="BFLS">Citi (CVC)<br />
				<input type="radio" value="IIML" name="BFLS">IIML <br />
				 <br />
<br /><br />



<!--				<div id="headingtextprobolduline">  Private Equity-backed Companies  <br /> </div>
				<div id="headingtextprobold"> Criteria   <br /> <br /></div>

				 <div id="headingtextprosubbold">
				 <img src="images/dot1.gif" /> Providing an exit route for investors  <br />
				 <img src="images/dot1.gif" /> Innovation and new product/services  <br />
				 <img src="images/dot1.gif" /> Global scope of operation <br /> <br />
				 </div>

				<div id="headingtextprobold"> Best Company - Early Stage <br /> </div>
				<input type="radio" value=" Compulink" name="BCES"> Compulink (Investor: SIDBI) <br />
				<input type="radio" value="InfoEdge" name="BCES"> InfoEdge (ICICI Venture) <br />
				<input type="radio" value="CSS Group" name="BCES">CSS Group (Baring Private Equity) <br /> <br />

				<div id="headingtextprobold"> Best Company -  Growth Stage <br /></div>
				<input type="radio" value="WNS Global Services" name="BCGS"> WNS Global Services (Warburg Pincus) <br />
				<input type="radio" value="MphasiS" name="BCGS"> MphasiS (Baring Private Equity) <br />
				<input type="radio" value="PVR Cinemas" name="BCGS"> PVR Cinemas (ICICI Venture) <br /> <br />

				<div id="headingtextprobold"> Best Company -  Late Stage <br /></div>
				<input type="radio" value="Suzlon" name="BCLS"> Suzlon (Citigroup and ChrysCapital) <br />
				<input type="radio" value="Matrix Laboratories" name="BCLS"> Matrix Laboratories (Newbridge and Temasek) <br />
			<input type="radio" value="GMR Infrastructure" name="BCLS">GMR Infrastructure (IDFC PE, ICICI Venture, Citigroup) <br /> <br />-->











			<div style="float:center ">
			<input name="submit" type="submit" value="Submit"> </div>
<?php
   			}
     	else
   		{
		?>
			  <div id="headingtextprobold">  Venture Intelligence Awards for Private Equity Excellence (APEX) <br /> <br /></div>
			  <div id="headingtextprobold"> Login Email and Password dont match. Please try again. <br /> <br /> </div>
			  <div id="headingtextprobold">  <a href="jurylogin.php">Jury Login  </a> <br /> <br /></div>

  		<?php
  		}
  	}
		?>

          </div> <!-- End of headingtextpro -->


        </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="js/bottom.js"></SCRIPT>



   </form>


</body>
</html>
