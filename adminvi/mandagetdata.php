<?php
require("../dbconnectvi.php");
			 $Db = new dbInvestments();
			 require("checkaccess.php");
	checkaccess( 'edit' );
 session_save_path("/tmp");
	session_start();
	include('pedelete_log.php');
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
		{

			$sesID=session_id();
			//echo "<br>peview session id--" .$sesID;
			 
		$username= $_SESSION[ 'name' ];	 
		$delPEIdArrayLength=0;
		$delPEId=$_POST['MandAId'];
		$delPEIdArrayLength= count($delPEId);
		if($delPEIdArrayLength>0)
		{
			foreach ($delPEId as $delPEIdtoDelete)
			{
				$updateSql="Update manda set Deleted=1 where MandAId=".$delPEIdtoDelete ;
				if ($companyrs=mysql_query($updateSql))
				{
					insertlog($delPEIdtoDelete,"M&A",$username);
			//		echo "<Br>--".$updateSql;
				}
			}
		}
				$month1=$_POST['month1'];
				$year1 = $_POST['year1'];
				$month2=$_POST['month2'];
				$year2 = $_POST['year2'];

			//	$notable=false;
			//	$vcflagValue=$_POST['txtvcFlagValue'];
			//	echo "<br>FLAG VALIE--" .$vcflagValue;

					$addVCFlagqry = " and pec.industry !=15 ";
					$searchTitle = "List of M&A Exits";

			if(($month1=="--") && ($year1=="--") && ($month2=="--") && ($year2=="--"))
			{
			 $companysql = "SELECT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
							 DealAmount,pe.uploadfilename,FinLink, DATE_FORMAT( DealDate, '%b-%Y' ) as dealperiod
							 FROM manda AS pe, industry AS i, pecompanies AS pec
							 WHERE pec.industry = i.industryid
							 AND pec.PEcompanyID = pe.PECompanyID
							 and pe.Deleted=0" .$addVCFlagqry.
						 "order by DealDate desc,DealAmount desc";

			}
			elseif (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--") )
				{

					$dt1 = $year1."-".$month1."-01";
					//echo "<BR>DATE1---" .$dt1;
					$dt2 = $year2."-".$month2."-01";
					$companysql = "select pe.MandAId,pe.PECompanyID,pec.companyname,pec.industry,i.industry,
					DealAmount,DATE_FORMAT(DealDate,'%b-%Y') as dealperiod,pe.uploadfilename,FinLink
					from manda as pe, industry as i,pecompanies as pec where pec.industry=i.industryid
					and DealDate between '".$dt1."' and '".$dt2 ."'
					and	pec.PEcompanyID = pe.PECompanyID
					and pe.Deleted=0 " .$addVCFlagqry. "order by DealDate desc,pe.DealAmount desc ";
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
	var e=document.getElementsByName("MandAId[]");
		for(var i=0;i<e.length;i++)
		{
			chk=e[i].checked;
		//	alert(chk);
			if(chk==true)
			{
				if (confirm("Are you sure you want to delete selected deals ? "))
				{
					e[i].checked=true;
					document.mandagetdata.action="mandagetdata.php";
					document.mandagetdata.submit();
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
<link href="../css/style_root.css" rel="stylesheet" type="text/css">

</head><body>

<form name="mandagetdata"  method="post" >
<div id="containerproductpeview">
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
	  <div style=" width:565px; /*height:405px;*/ margin-top:5px;" class="main_content_container">
	    <div id="maintextpro">
        <div id="headingtextpro">
		<input type="hidden" name="month1" value="<?php echo $month1;?>"
		<input type="hidden" name="year1" value="<?php echo $year1;?>"
		<input type="hidden" name="month2" value="<?php echo $month2;?>"
		<input type="hidden" name="year2" value="<?php echo $year2;?>"
		<?php

				 	  // echo "<br> query final-----" .$companysql;
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
					<div style="width: 542px; /*height:305px;*/ overflow: scroll;" class="content_container">
								<table border="1" bgcolor="#FFF" cellpadding="3" cellspacing="0" width="100%"  >
								<tr>
										<th> Del </th>
										<th>Company</th>
										<th>Industry</th>
										<th>Amt(US$M)</th>
										<th>Date </th>
									</tr>
						<?php
						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
									 //$bgcolor="#FFF";    //white
                                                                        if(trim($myrow["uploadfilename"])!="")
                                                                           $bgcolor="#D0A9F5";
                                                                        if(trim($myrow["FinLink"])!=="")
                                                                           $bgcolor="#F5A9F2";
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
							 ?>
							 		<tr>
							 		<td align=center><input name="MandAId[]" type="checkbox" value=" <?php echo $myrow["MandAId"]; ?>" ></td>

									<td width=25%  bgcolor=<?php echo $bgcolor;?> ><?php echo $compDisplayOboldTag ?>
									<A style="text-decoration:none" href="mandaeditdata.php?value=PE-<?php echo $myrow["MandAId"];?> "
								   target="popup" onclick="window.open('mandaeditdata.php?value=PE-<?php echo $myrow["MandAId"];?>', 'popup', 'scrollbars=1,width=500,height=500');return false">
								   <?php echo $myrow["companyname"]; ?>  &nbsp;<?php echo $compDisplayOboldTag ?>
									</A></td>


										<td><?php echo $myrow["industry"];?></td>
										<td align=right width=10%><?php echo $myrow["DealAmount"]; ?>&nbsp;</td>
										<td><?php echo $myrow["dealperiod"];?> </td>
									 </tr>
							<?php
								$totalInv=$totalInv+1;
								$totalAmount=$totalAmount+ $myrow["DealAmount"];
							}

						?>
					 </table>
					</div>

		<?php
					}
		?>
			<span style="float:left" class="one">
			<input type="button"  value="Delete Deal(s)" name="delDeal"  onClick="updateDeletion();">
			</span> 
                        </form>
                        <span style="float:left;margin-left:3px;">
                             <form name="pelisting"  method="post" action="exportmaexit_new.php">
                                 <input type="hidden" name="month1" value=<?php echo $month1; ?> >
                                 <input type="hidden" name="month2" value=<?php echo $month2; ?> >
                                 <input type="hidden" name="year1" value=<?php echo $year1; ?> >
                                 <input type="hidden" name="year2" value=<?php echo $year2; ?> >
                                 <input type="submit"  value="Export" name="showdeals">
                             </form>
                         </span> 
                                                <br /><br />
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
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>

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