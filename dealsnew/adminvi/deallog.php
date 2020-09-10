<?php include_once("../../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
 	session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
//	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
// 	{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">
function findEmails()
{
	document.log.action="deallog.php";
	document.log.submit();
}

function updateDeletion()
{
	var chk;
	var e=document.getElementsByName("DelLog[]");
	for(var i=0;i<e.length;i++)
	{
		chk=e[i].checked;
	//	alert(chk);
		if(chk==true)
		{
			e[i].checked=true;
			document.log.action="deletelog.php";
			document.log.submit();
			break;
		}
	}
		if (chk==false)
		{
			alert("Pls select one or more log entry to delete");
			return false;
		}
}

</SCRIPT>

<link href="../vistyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="log"  method="post" action="" >
<div id="containerproductproducts">

<!-- Starting Left Panel -->
  <div id="leftpanel">

    <div><a href="index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>

  <div id="vertbgproproducts">

    	<div id="vertMenu">
			<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Import</span></div>
		</div>
		<div id="linksnone">
			<a href="dealsinput.php">Investment Deals</a><br />
			<a href="companyinput.php">Profiles</a><br />
		  <!--<a href="investorinput.php">Investor Profile</a><br />-->
		</div>

		<div id="vertMenu">
			<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Edit</span></div>
		</div>
		<div id="linksnone">
			<a href="pegetdatainput.php">Deals / Profile</a><br />
			<a href="peadd.php">Add PE Inv </a> | <a href="ipoadd.php">IPO </a> | <a href="mandaadd.php">MandA  </a><br />

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
		<div id="linksnone">
			<a href="../adminlogoff.php">Logout</a><br />
		</div>

    </div> <!-- end of vertbgproducts div-->
   </div>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; height:616px; margin-top:4px;">
	    <div id="maintextpro">
		<?php


			//echo "<br>*******-".$_SESSION['SessLoggedAdminPwd'];

			$keyword="";
			$keyword=$_POST['emailsearch'];

			$logdate1=$_POST['date1'];
			$logdate2=$_POST['date2'];

			$todaysdate=date("Y-m-d");
			//echo "<br>*******-".$logindate;
			if(($logdate1=="") || ($logdate2==""))
			{
			//	echo "<Br>empty dates";
				$querydate="";
				$allquerydate=" where DATE_FORMAT( LoggedIn, '%Y-%m-%d' ) between '" . $todaysdate. "' and '" . $todaysdate . "'";
			//	echo "<Br>All Query string- " .$allquerydate;

				//$allquerydate="" ;
				}
			else
			{
				$querydate=" and DATE_FORMAT( LoggedIn, '%Y-%m-%d')  between '" . $logdate1. "' and '" . $logdate2 . "'";
				$allquerydate=" where DATE_FORMAT( LoggedIn, '%Y-%m-%d')  between '" . $logdate1. "' and '" . $logdate2 . "'";
			//	echo "<Br>--All Query string- " .$allquerydate;

			}
			if(trim($keyword)!="")
			{
				$dealcompanySql="select EmailId,LoggedIn, DATE_FORMAT( LoggedIn, '%m-%d-%y %H:%i:%S') as dt,IpAdd,DATE_FORMAT( LoggedOff, '%m-%d-%Y %H:%i:%S') as logoff,UnAuthorized,PE_MA from dealLog where EmailId like '%$keyword%'" .$querydate. " order by LoggedIn desc";
			}
			else
			{
				$dealcompanySql="select EmailId,LoggedIn, DATE_FORMAT( LoggedIn, '%m-%d-%Y %H:%i:%S' ) as dt,IpAdd,DATE_FORMAT( LoggedOff, '%m-%d-%Y %H:%i:%S' ) as logoff,UnAuthorized,PE_MA from dealLog" .$allquerydate. "  order by LoggedIn desc";
			}
			//	echo "<br>***--" .$dealcompanySql;

		?>
        <div id="headingtextpro">

				EmailId (@)&nbsp;
					<input type=text name="emailsearch" size=25>&nbsp;&nbsp;&nbsp;
					<input type=text name="date1" value=<?php echo $todaysdate; ?> size=10>
					<input type=text name="date2" value=<?php echo $todaysdate; ?> size=10>(yyyy-mm-dd)<br />

				<span style="float:right" class="one">
				<input type="button"  value="Fetch Emails" name="search"  onClick="findEmails();">
				</span>
				<br /><br />

				<div style="width: 542px; height: 275px; overflow: scroll;">
				<table border="1" cellpadding="2" cellspacing="0" width="50%"  >

					<tr style="font-family: Verdana; font-size: 8pt">
					<th colspan=2 BGCOLOR="#FF6699" >Del</th>
					<th width="3%">Email Id</th>
						<th width="20%">Logged In (m/dd/yy)</th>
						<th>IP Add</th>
						<th width="20%">Logout Time</th>
						<th>Unauthorized</th>

					</tr>

					<?php
						if ($companyrs = mysql_query($dealcompanySql))
						 {
							$company_cnt = mysql_num_rows($companyrs);
						 }
						if ($company_cnt>0)
						{
							While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
								$access="";
								if($myrow["UnAuthorized"]==1)
								{
									$access="checked";
									$bgcolors='<td BGCOLOR="red">';
								}
								else
								{
									$bgcolors='<td BGCOLOR="#white">';
								}
								if($myrow["PE_MA"]==1)
									$bgcolorMA='<td width=3% BGCOLOR="#FFFF00">';
								elseif($myrow["PE_MA"]==0)
									$bgcolorMA='<td width=3% BGCOLOR="#white">';
								elseif($myrow["PE_MA"]==2)
									$bgcolorMA='<td width=3% BGCOLOR="#AFC7C7">';

								$keywrd=$myrow["EmailId"]."+".$myrow["LoggedIn"];
					 ?>
								<tr style="font-family: Verdana; font-size: 8pt">
								<td align=center colspan=2 BGCOLOR="#FF6699"><input name="DelLog[]" type="checkbox" value=" <?php echo $keywrd; ?>" >
								<?php echo $EmailId; ?> </td>


								<?php echo $bgcolorMA;?><?php echo trim($myrow["EmailId"]); ?>  	</td>
								<td width="20%"><?php echo $myrow["dt"]; ?>  	</td>
								<td><?php echo $myrow["IpAdd"]; ?>  	</td>
								<td width="20%"><?php echo $myrow["logoff"]; ?>  	</td>
								<?php echo $bgcolors;?><input name="access[]" type="checkbox" value=" <?php echo $myrow["EmailId"]; ?>" <?php echo $access; ?>> </td>

								</tr>
					<?php
							}
						}
					?>
					</table>
							 </div>

					<span style="float:left" class="one">

					<input type="button"  value="Delete Log" name="DelLog"  onClick="updateDeletion();">
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

//} // if resgistered loop ends
//else
//	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>