<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
	require("checkaccess.php");
	checkaccess( 'edit' );
 session_save_path("/tmp");
		session_start();
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
		{
	$currentyear = date("Y");

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">
function getDealInfo()
{
	document.pegetdatainput.action="pegetdata.php";
	document.pegetdatainput.submit();
}
function getREDealInfo()
{
	document.pegetdatainput.action="peregetdata.php";
	document.pegetdatainput.submit();
}
function getIPdealInfo()
{
	document.pegetdatainput.action="pegetipo.php";
	document.pegetdatainput.submit();
}
function getREIpoDealInfo()
{
	document.pegetdatainput.action="regetipo.php";
	document.pegetdatainput.submit();
}
function getMandAdealInfo()
{
	document.pegetdatainput.action="mandagetdata.php";
	document.pegetdatainput.submit();
}
function getREMandAdealInfo()
{
	document.pegetdatainput.action="remandagetdata.php";
	document.pegetdatainput.submit();
}

function getCompanies()
{
	document.pegetdatainput.action="pegetcompany.php";
	document.pegetdatainput.submit();
}
function getInvestors()
{
	document.pegetdatainput.action="pegetinvestor.php";
	document.pegetdatainput.submit();
}
function getRECompanies()
{
	document.pegetdatainput.action="regetcompany.php";
	document.pegetdatainput.submit();
}
function getREInvestors()
{
	document.pegetdatainput.action="regetinvestor.php";
	document.pegetdatainput.submit();
}

function getmeracqdealInfo()
{
	document.pegetdatainput.action="meracqgetdata.php";
	document.pegetdatainput.submit();
}
function getAngelDealInfo()
{
	document.pegetdatainput.action="angelgetdata.php";
	document.pegetdatainput.submit();
}


function getIncDeals()
{
	document.pegetdatainput.action="getincdeals.php";
	document.pegetdatainput.submit();
}
function getREmeracqdealInfo()
{
	document.pegetdatainput.action="remeracqgetdata.php";
	document.pegetdatainput.submit();
}
function getAcquirer()
{
	document.pegetdatainput.action="acquirergetdata.php";
	document.pegetdatainput.submit();
}
function getREAcquirer()
{
	document.pegetdatainput.action="reacquirergetdata.php";
	document.pegetdatainput.submit();
}
function getIncubators()
{
	document.pegetdatainput.action="getIncubators.php";
	document.pegetdatainput.submit();
}
function getIncubatees()
{
	document.pegetdatainput.action="getIncubatees.php";
	document.pegetdatainput.submit();
}
function getAdvisors()
{
	document.pegetdatainput.action="showadvisors.php";
	document.pegetdatainput.submit();
}
function getREAdvisors()
{
	document.pegetdatainput.action="showreadvisors.php";
	document.pegetdatainput.submit();
}
</SCRIPT>

<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="pegetdatainput" method="post" >
<div id="containerproductproducts">
<!-- Starting Left Panel -->
  <?php include_once('leftpanel.php'); ?>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
 <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; /*height:687px;*/ margin-top:4px;" class="main_content_container">
	    <div id="maintextpro">

        <div id="headingtextpro">
         <div id="headingtextproboldfontcolor">Deal Period&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
	   		<img src="../images/arrow.gif" />
	   				<SELECT NAME=month1>
	   			 <OPTION id=1 value="--" > Month </option>
	   			 <OPTION VALUE=1 selected>Jan</OPTION>
	   			 <OPTION VALUE=2>Feb</OPTION>
	   			 <OPTION VALUE=3>Mar</OPTION>
	   			 <OPTION VALUE=4>Apr</OPTION>
	   			 <OPTION VALUE=5>May</OPTION>
	   			 <OPTION VALUE=6>Jun</OPTION>
	   			 <OPTION VALUE=7>Jul</OPTION>
	   			 <OPTION VALUE=8>Aug</OPTION>
	   			 <OPTION VALUE=9>Sep</OPTION>
	   			 <OPTION VALUE=10>Oct</OPTION>
	   			 <OPTION VALUE=11>Nov</OPTION>
	   			<OPTION VALUE=12>Dec</OPTION>
	   			</SELECT>
	   				<SELECT NAME=year1>
	   				<OPTION id=2 value="--" > Year </option>
	   				<?php

	   				//$i=1998;
	   				/*While($i<= $currentyear )*/
	   				for($i=$currentyear;$i>=1998;$i--)
					{
						$id = $i;
						$name = $i;
						if ($id==$currentyear)
						{
							echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."</OPTION>\n";
						}
						else
						{
							echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION>\n";
						}
						//$i++;
					}
	   				?> </SELECT>
	   			<SELECT NAME=month2>
	   			 <OPTION id=3 value="--" > Month </option>
	   			 <OPTION VALUE=1>Jan</OPTION>
	   			 <OPTION VALUE=2>Feb</OPTION>
	   			 <OPTION VALUE=3>Mar</OPTION>
	   			 <OPTION VALUE=4>Apr</OPTION>
	   			 <OPTION VALUE=5>May</OPTION>
	   			 <OPTION VALUE=6>Jun</OPTION>
	   			 <OPTION VALUE=7>Jul</OPTION>
	   			 <OPTION VALUE=8>Aug</OPTION>
	   			 <OPTION VALUE=9>Sep</OPTION>
	   			 <OPTION VALUE=10>Oct</OPTION>
	   			 <OPTION VALUE=11>Nov</OPTION>
	   			 <OPTION VALUE=12 selected>Dec</OPTION>
	   			</SELECT>
	   			<SELECT name=year2>
	   			<OPTION id=4 value="--" > Year </option>

	   			<?php
	   			//$endYear=1998;
	   			/*While($endYear<= $currentyear )*/
	   			for($endYear=$currentyear;$endYear>=1998;$endYear--)
				{
					$ids=$endYear;
					if($ids==$currentyear)
					{
						echo "<OPTION id=". $endYear. "value=". $endYear." selected>".$endYear."</OPTION>\n";
					}
					else
					{
						echo "<OPTION id=". $endYear. "value=". $endYear." >".$endYear."</OPTION>\n";
					}

				//$endYear++;
				}
	   			?> </SELECT>
			</div> <br />

			<div id="headingtextpro">
			<input type="button" value="PE Inv" name="btnimporttxt" onClick="getDealInfo();" > &nbsp;&nbsp;&nbsp;
			<input type="button" value="PE-backed IPOs" name="btnimportipotxt" onClick="getIPdealInfo();" >&nbsp;&nbsp;&nbsp;
			<input type="button" value="PE-Exits via M&A" name="btnimportmandatxt" onClick="getMandAdealInfo();" >&nbsp;&nbsp;&nbsp;
			<input type="button" value="M&A" name="btnimportmatxt" onClick="getmeracqdealInfo();" >&nbsp;&nbsp;&nbsp;
			<input type="button" value="Angel Inv" name="btnimportangeltxt" onClick="getAngelDealInfo();" >

			</div>
			

			<div id="headingtextpro">
			<input type="button" value="RE Inv" name="btnimportREtxt" onClick="getREDealInfo();" > &nbsp;&nbsp;&nbsp;
			<input type="button" value="RE-IPO Exits" name="btnimportREipotxt" onClick="getREIpoDealInfo();" > &nbsp;
			<input type="button" value="RE-M&A Exits" name="btnimportREmandatxt" onClick="getREMandAdealInfo();" > &nbsp;&nbsp;
			<input type="button" value="RE-M&A" name="btnimportREmatxt" onClick="getREmeracqdealInfo();" > &nbsp;&nbsp;

                        <input type="button" value="Incubation" name="btnincdeals" onClick="getIncDeals();" >

			</div><br />


         <div id="headingtextproboldfontcolor">Profile - Company Search </div>
         	<div id="headingtextprobold">Company &nbsp;&nbsp;
		 	<img src="../images/arrow.gif" />
		 	<input type=text name="companysearch" size=39>
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="button" value="Get Companies" name="btnimportcompanyprofile" onClick="getCompanies();" >
			<span style="float:right" class="one">
			<!--<br /> -->
			<input type="button" value="Get RE Companies" name="btnimportREcompanyprofile" onClick="getRECompanies();" >
			<span style="float:right" class="one">
			<input type="button" value="Get Incubatees" name="btninportincubateeprofile" onClick="getIncubatees();" >
			</span>

			</span> <br /> <br /></div> <br />


			  <div id="headingtextproboldfontcolor">Profile - Investor Search </div>
			<div id="headingtextprobold">Investor &nbsp;&nbsp;
			<img src="../images/arrow.gif" />
			<input type=text name="investorsearch" size=39>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="button" value="Get Investors" name="btninportinvestorprofile" onClick="getInvestors();" >
			<span style="float:right" class="one">
			<input type="button" value="Get RE Investors" name="btninportREinvestorprofile" onClick="getREInvestors();" >
			</span> </div> <br /><br />

			 <div id="headingtextproboldfontcolor">Profile - Acquirer Search </div>
			         	<div id="headingtextprobold">Acquirer &nbsp;&nbsp;
					 	<img src="../images/arrow.gif" />
					 	<input type=text name="acquirersearch" size=39>
						&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<input type="button" value="Get Acquirer(s)" name="btnimportacquirerprofile" onClick="getAcquirer();" >
				<span style="float:right" class="one">
			<input type="button" value="Get RE Acquirers" name="btninportREacqurierprofile" onClick="getREAcquirer();" >
			</span>  </div>
			<br /> <br />


                        <div id="headingtextproboldfontcolor"><!-- Show All - Advisor(s)-->Profile - Advisor Search 
			<span style="float:right" class="one">Acquirer &nbsp;&nbsp;
					 	<img src="../images/arrow.gif" />
					 	<input type=text name="advisorssearch" size=39>
			<input type="button" value="Get Advisors" name="btninportAdvisors" onClick="getAdvisors();" >  &nbsp;&nbsp;&nbsp;&nbsp;
			<input type="button" value="Get RE-Advisors" name="btninportREAdvisors" onClick="getREAdvisors();" >
			</span> </div> <br />

                          <div id="headingtextproboldfontcolor">Profile - Incubator Search </div>
                         <div id="headingtextprobold">Incubator&nbsp;&nbsp;<img src="../images/arrow.gif" />
			<input type=text name="incubatorsearch" size=39>
				&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
				<input type="button" value="Get Incubators" name="btninportincubatorprofile" onClick="getIncubators();" >
			</div> <br /><br />


		</div><!-- end of headingtextpro-->
        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>
   </form>

   <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
  </script>

</body>
</html>
<?php

} // if resgistered loop ends
else
	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>