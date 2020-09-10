<?php include_once("../../globalconfig.php"); ?>
<?php
/*created- Nov-16-09
formname: remeracqgetdata
filename:remeracqgetdata.php
invoked from : pegetdatainput.php
invoked to: remeracqeditdata.php (FOR EDITING)
*/

 	session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
		{

			$sesID=session_id();
			//echo "<br>peview session id--" .$sesID;
			 require("../dbconnectvi.php");
			 $Db = new dbInvestments();

		$delPEIdArrayLength=0;
		$delPEId=$_POST['MAMAId'];
		$delPEIdArrayLength= count($delPEId);
		if($delPEIdArrayLength>0)
		{
			foreach ($delPEId as $delPEIdtoDelete)
			{
				$updateSql="Update REmama set Deleted=1 where MAMAId=".$delPEIdtoDelete ;
				if ($companyrs=mysql_query($updateSql))
				{
			//		echo "<Br>--".$updateSql;
				}
			}
		}
				$month1=$_POST['month1'];
				$year1 = $_POST['year1'];
				$month2=$_POST['month2'];
				$year2 = $_POST['year2'];

				$searchTitle = "List of RE - M & A ";

			if(($month1=="--") && ($year1=="--") && ($month2=="--") && ($year2=="--"))
			{
			 $companysql = "SELECT pe.MAMAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
							Amount, DATE_FORMAT( DealDate, '%b-%Y' ) as dealperiod,Asset
							 FROM REmama AS pe, reindustry AS i, REcompanies AS pec
							 WHERE pec.industry = i.industryid
							 AND pec.PEcompanyID = pe.PECompanyID
							 and pe.Deleted=0 order by DealDate desc,Amount desc";

			}
			elseif (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--") )
				{

					$dt1 = $year1."-".$month1."-01";
					//echo "<BR>DATE1---" .$dt1;
					$dt2 = $year2."-".$month2."-01";
					$companysql = "select pe.MAMAId,pe.PECompanyID,pec.companyname,pec.industry,i.industry,
				    Amount,DATE_FORMAT(DealDate,'%b-%Y') as dealperiod,Asset
					from REmama as pe, reindustry as i,REcompanies as pec where pec.industry=i.industryid
					and DealDate between '".$dt1."' and '".$dt2 ."'
					and	pec.PEcompanyID = pe.PECompanyID
					and pe.Deleted=0 order by DealDate desc,pe.Amount desc ";
	//				echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
				}
			else
			{
				echo "<br> INVALID DATES GIVEN ";
				$fetchRecords=false;
				}
		//echo "<br>--" .$companysql;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="language" content="en-us" />
<title>Venture Intelligence - PE Investments</title>


<script type="text/javascript">
function updateDeletion()
{
	var chk;
	var e=document.getElementsByName("MAMAId[]");
		for(var i=0;i<e.length;i++)
		{
			chk=e[i].checked;
		//	alert(chk);
			if(chk==true)
			{
				if (confirm("Are you sure you want to delete selected deals ? "))
				{
					e[i].checked=true;
					document.remeracqgetdata.action="remeracqgetdata.php";
					document.remeracqgetdata.submit();
					break;
				}
			}
		}
	if (chk==false)
		{
			alert("Pls select one or more to delete");
			return false;
		}
}
</script>

<style type="text/css">


</style>
<link href="../style.css" rel="stylesheet" type="text/css">

</head><body oncontextmenu="return false;">

<form name="remeracqgetdata"  method="post" >
<div id="containerproductpeview">
<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgpropeview">
    	<div id="vertMenu">
			<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Import</span></div>
			</div>
			<div id="linksnone">
						<a href="dealsinput.php">Investment Deals</a> | <a href="companyinput.php">Profiles</a><br />

					  <!--<a href="investorinput.php">Investor Profile</a><br />-->
		</div>


			<div id="vertMenu">
					<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Edit</span></div>
				</div>
				<div id="linksnone">
							<a href="pegetdatainput.php">Deals / Profile</a><br />
			<a href="peadd.php">Add PE Inv </a> |  <a href="ipoadd.php">IPO </a> | <a href="mandaadd.php">MandA  </a> | <a href="mamaadd.php">MA </a> |
			<A href="peadd_RE.php"> RE Inv</a> | <A href="reipoadd.php"> RE-IPO</a> | <A href="remandaadd.php"> RE-M&A</a><br /> | <a href="remamaadd.php">RE-MA </a> |
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
	  <div style="background-color:#FFF; width:565px; height:405px; margin-top:5px;">
	    <div id="maintextpro">
        <div id="headingtextpro">
		<input type="hidden" name="month1" value="<?php echo $month1;?>"
		<input type="hidden" name="year1" value="<?php echo $year1;?>"
		<input type="hidden" name="month2" value="<?php echo $month2;?>"
		<input type="hidden" name="year2" value="<?php echo $year2;?>"
		<?php

				 	  //echo "<br> query final-----" .$companysql;
				 	      /* Select queries return a resultset */
						 if ($companyrs = mysql_query($companysql))
						 {
						    $company_cnt = mysql_num_rows($companyrs);
						 }
				           if($company_cnt > 0)
				           {
				           	//	$searchTitle=" List of M&A Exit Deals";
				           }
				           else
				           {
				              	$searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
				           }

		           ?>
						<div id="headingtextproboldfontcolor"> <?php echo $searchTitle; ?> <br />  <br /> </div>
					<?php
					if($company_cnt>0)
					{

					?>
						<!--<div id="tableContainer" class="tableContainer"> -->
					<div style="width: 542px; height:305px; overflow: scroll;">
								<table border="1" cellpadding="3" cellspacing="0" width="100%"  >
								<tr>
										<th> Del </th>
										<th >Target Company</th>
										<th>Industry</th>
										<th>Amt(US$M)</th>
										<th>Date </th>
									</tr>
						<?php
						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
									$comment=trim($myrow["comment"]);
									if(trim($comment)=="")
									{
										$compDisplayOboldTag="";
										$compDisplayEboldTag="";
									}
									else
									{
										$compDisplayOboldTag="<b><i>";
										$compDisplayEboldTag="</b></i>";
									}
									if($myrow["Asset"]==1)
									{
										$openBracket="(";
										$closeBracket=")";
									}
									else
									{
										$openBracket="";
										$closeBracket="";
									}
							 ?>
							 		<tr>
							 		<td align=center><input name="MAMAId[]" type="checkbox" value=" <?php echo $myrow["MAMAId"]; ?>" ></td>

									<td width=25%><?php echo $openBracket ; ?><?php echo $compDisplayOboldTag ?>
									<A style="text-decoration:none" href="remeracqeditdata.php?value=<?php echo $myrow["MAMAId"];?> "
								   target="popup" onclick="window.open('remeracqeditdata.php?value=<?php echo $myrow["MAMAId"];?>', 'popup', 'scrollbars=1,width=500,height=500');return false">
								   <?php echo $myrow["companyname"]; ?> <?php echo $compDisplayOboldTag ?></a><?php echo $closeBracket ; ?>
									</td>


										<td><?php echo $myrow["industry"];?></td>
										<td align=right width=10%><?php echo $myrow["Amount"]; ?>&nbsp;</td>
										<td><?php echo $myrow["dealperiod"];?> </td>
									 </tr>
							<?php
								$totalInv=$totalInv+1;
								$totalAmount=$totalAmount+ $myrow["Amount"];
							}

						?>
					 </table>
					</div>

		<?php
					}
		?>
			<span style="float:left" class="one">
			<input type="button"  value="Delete Deal(s)" name="delDeal"  onClick="updateDeletion();">
			</span> <br /><br />
		</div>

		<div id="headingtextproboldbcolor">&nbsp; No. of Deals  - <?php echo $totalInv; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

		Amount (US$ Million)&nbsp;<?php echo $totalAmount; ?> <br /></div>

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