<?php include_once("../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
	require("checkaccess.php");
	checkaccess( 'subscribers' );
 //session_save_path("/tmp");
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

function exportDealLog() {
	document.exportForm.submit();
}

</SCRIPT>

<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="log"  method="post" action="" >
<div id="containerproductproducts">

<!-- Starting Left Panel -->
  <?php include_once('leftpanel.php'); ?>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../dealsnew/top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; height:742px; margin-top:4px;">
	    <div id="maintextpro">
		<?php


			//echo "<br>*******-".$_SESSION['SessLoggedAdminPwd'];

			$keyword="";
			$keyword=$_POST['emailsearch'];

			/*$logdate1=$_POST['date1'];
			$logdate2=$_POST['date2'];*/

			if( isset( $_POST[ 'date1' ] ) ) {
				$fromDate = $_POST['date1'];
			} else {
				$fromDate=date("Y-m-d");
			}

			if( isset( $_POST[ 'date2' ] ) ) {
				$toDate = $_POST['date2'];
			} else {
				$toDate=date("Y-m-d");
			}

			//$todaysdate=date("Y-m-d");

			//echo "<br>*******-".$logindate;
			if(($fromDate=="") || ($toDate==""))
			{
			//	echo "<Br>empty dates";
				$querydate="";
				$allquerydate=" where DATE_FORMAT( LoggedIn, '%Y-%m-%d' ) between '" . $fromDate. "' and '" . $toDate . "'";
			//	echo "<Br>All Query string- " .$allquerydate;

				//$allquerydate="" ;
				}
			else
			{
				$querydate=" and DATE_FORMAT( LoggedIn, '%Y-%m-%d')  between '" . $fromDate. "' and '" . $toDate . "'";
				$allquerydate=" where DATE_FORMAT( LoggedIn, '%Y-%m-%d')  between '" . $fromDate. "' and '" . $toDate . "'";
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
					<input type=text name="date1" value=<?php echo $fromDate; ?> size=10>
					<input type=text name="date2" value=<?php echo $toDate; ?> size=10>(yyyy-mm-dd)<br />

				<span style="float:right" class="one">
				<input type="button"  value="Fetch Emails" name="search"  onClick="findEmails();">
				</span>
				<br /><br />

				<div style="width: 542px; height: 648px; overflow: scroll;">
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
					<input type="button"  value="Export" name="expDeallog"  onClick="exportDealLog();">
					</span>
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

   <form name="exportForm" action="exportdeallog.php" method="post">
   		<input type="hidden" name="from_date" id="from_date" value="<?php echo $fromDate; ?>" />
   		<input type="hidden" name="to_date" id="from_date" value="<?php echo $toDate; ?>" />
   		<input type="hidden" name="email_search" id="email_search" value="<?php echo $keyword; ?>" />
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