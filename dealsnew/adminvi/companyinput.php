<?php include_once("../../globalconfig.php"); ?>
<?php
//require("../dbconnectvi.php");
//	$Db = new dbInvestments();
 	session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
 	{

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">
function checkFileName()
{
	if (document.companyinput.txtcompfilepath.value == "")
		{
			alert("Please choose the company profile file to import");
			return false;
		}
	else
		{
			document.companyinput.action="pecompanyimport.php";
			document.companyinput.submit();
			//return true;
		}
}

function checkREFileName()
{
	if (document.companyinput.txtcompfilepath.value == "")
		{
			alert("Please choose the RE company profile file to import");
			return false;
		}
	else
		{
			document.companyinput.action="recompanyimport.php";
			document.companyinput.submit();
			//return true;
		}
}
function checkAngelcompanyFileName()
{
	if (document.companyinput.txtcompfilepath.value == "")
		{
			alert("Please choose the company profile file to import");
			return false;
		}
	else
		{
			document.companyinput.action="angelcompanyimport.php";
			document.companyinput.submit();
			//return true;
		}
}


function checkInvestorFileName()
{
	if (document.companyinput.txtinvfilepath.value == "")
	{
		alert("Please choose the Investor profile file to import");
		return false;
	}
	else
	{
	//	return true;
		document.companyinput.action="peinvestorimport.php";
		document.companyinput.submit();
	}
}

function checkREInvestorFileName()
{
	if (document.companyinput.txtinvfilepath.value == "")
	{
		alert("Please choose the RE Investor profile file to import");
		return false;
	}
	else
	{
	//	return true;
		document.companyinput.action="reinvestorimport.php";
		document.companyinput.submit();
	}
}
function checkAngelInvestorFileName()
{
	if (document.companyinput.txtinvfilepath.value == "")
	{
		alert("Please choose the Angel Investor profile file to import");
		return false;
	}
	else
	{
	//	return true;
		document.companyinput.action="angelinvestorimport.php";
		document.companyinput.submit();
	}
}


function checkIncubatorFileName()
{
	if (document.companyinput.txtincubatorfilepath.value == "")
	{
		alert("Please choose the Incubator Profile to import");
		return false;
	}
	else
	{
	//	return true;
		document.companyinput.action="incubatorprofileimport.php";
		document.companyinput.submit();
	}
}
function checkFundRaise()
{
	if (document.companyinput.txtfundraising.value == "")
	{
		alert("Please choose the Fund Raise Sheet to import");
		return false;
	}
	else
	{
	//	return true;
		document.companyinput.action="fundraisingexport.php";
		document.companyinput.submit();
	}
}

</SCRIPT>

<link href="../vistyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="companyinput" enctype="multipart/form-data" method="post">
<div id="containerproductproducts">
<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgproproducts">

		<div id="vertMenu">
		        	<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Import</span></div>
		      	</div>
		      	<div id="linksnone"><a href="dealsinput.php">Investment Deals</a> | <a href="companyinput.php"> Profiles</a><br />

				</div>

					<div id="vertMenu">
						<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Edit</span></div>
					</div>
					<div id="linksnone"><a href="pegetdatainput.php">Deals / Profile</a><br />
									<a href="peadd.php">Add PE Inv </a> | <a href="ipoadd.php">IPO </a> | <a href="mandaadd.php">MandA  </a> | <a href="mamaadd.php">MA </a><br />
					</div>

				<div id="vertMenu">
					<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Subscribers</span></div>
				</div>
				<div id="linksnone">
				 <a href="admin.php">Subscriber List</a><br />
				 			<a href="addcompany.php">Add Subscriber / Members</a><br />
				 			<a href="delcompanylist.php">List of Deleted Companies</a><br />
				 			<a href="delmemberlist.php">List of Deleted Emails</a><br />
				 			<a href="deallog.php">Log</a><br />

				</div>
                                  <div id="vertMenu">
                        <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Admin Report</span></div>
                </div>
                <div id="linksnone">
                        <a href="viewlist.php">View Report</a><br />
                        <a href="addlist.php">Add Report</a><br />
                        <!--a href="delcompanylist.php">List of Deleted Companies</a><br />
                        <a href="delmemberlist.php">List of Deleted Emails</a><br />
                        <a href="deallog.php">Log</a><br /-->
		</div>
                <div id="vertMenu">
                        <div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Fund Raising</span></div>
                </div>
                <div id="linksnone">
                    <a href="fundlist.php">View Funds</a><br />
                    <a href="addfund.php">Add Fund</a><br />
		</div>
				<div id="vertMenu">
					<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Exit</span></div>
				</div>
				<div id="linksnone"><a href="../adminlogoff.php">Logout</a><br />
		</div>

    </div>
   </div>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; height:616px; margin-top:5px;">
	    <div id="maintextpro">

        <div id="headingtextpro">
        <div id="headingtextproboldfontcolor">Company Profile </div>
        Import Company Profile  as .txt file through this window: <Br />
		<div id="headingtextprosmallfont">  (Please make sure that you had created the tab delimited .txt file from the Excel before importing ) </div>

			<br />

			<INPUT NAME="txtcompfilepath" TYPE="file" size=50>
			<br / ><br />


<span style="float:right" class="one">
					<input type="button" value="Angel Comp Profile" name="btnangelcompimporttxt" onClick="checkAngelcompanyFileName();">
				</span>
				<span style="float:right" class="one">
					<input type="button" value="RE Profile" name="btncompREimporttxt" onClick="checkREFileName();">
				</span>

				<span style="float:right" class="one">
					<input type="button" value="PE Profile" name="btncompimporttxt" onClick="checkFileName();">
				</span> 
				 <br />

		<div id="headingtextproboldfontcolor">Investor Profile </div>

		        Import Investor Profile  as .txt file through this browse option: <Br />
				<div id="headingtextprosmallfont">  (Please make sure that you had created the tab delimited .txt file from the Excel before importing ) </div>

					<br />

					<INPUT NAME="txtinvfilepath" TYPE="file" size=50>
					<br / ><br />

					<span style="float:right" class="one">
					<input type="button" value="Import Angel Investor" name="btninvAngimporttxt"  onClick="checkAngelInvestorFileName();">
				</span>
					<span style="float:right" class="one">
							<input type="button" value="Import RE Investor" name="btninvREimporttxt"  onClick="checkREInvestorFileName();">
				</span>

						<span style="float:right" class="one">
							<input type="button" value="Import PE Investor" name="btninvimporttxt"  onClick="checkInvestorFileName();">
				</span>    <br /><br />
				
					<div id="headingtextproboldfontcolor">Incubator Profile </div>

		        Import Incubator Profile  as .txt file through this browse option: <Br />
				<div id="headingtextprosmallfont">  (Please make sure that you had created the tab delimited .txt file from the Excel before importing ) </div>

					<br />

					<INPUT NAME="txtincubatorfilepath" TYPE="file" size=50>

    				<span style="float:right" class="one">
							<input type="button" value="Import Incubator" name="btnincubatorimporttxt"  onClick="checkIncubatorFileName();">
				</span>
				<Br /> <br />
				<div id="headingtextproboldfontcolor">Fund Raising Detail </div>
                                    Import Fund Raising Details  as .txt file through this browse option:
				<br />
                                <INPUT name="txtfundraising" TYPE="file" size=50>

    				<span style="float:right" class="one">
							<input type="button" value="Import Fund Raising" name="btnfundraising"  onClick="checkFundRaise();">
				</span>

		</div><!-- end of headingtextpro-->
        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../../js/bottom1.js"></SCRIPT>
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
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>