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
		$delPEId=$_POST['MAMAId'];
		$delPEIdArrayLength= count($delPEId);
		if($delPEIdArrayLength>0)
		{
			foreach ($delPEId as $delPEIdtoDelete)
			{
				$updateSql="Update mama set Deleted=1 where MAMAId=".$delPEIdtoDelete ;
				if ($companyrs=mysql_query($updateSql))
				{
					insertlog($delPEIdtoDelete,"MAMA",$username);
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
					$searchTitle = "List of M & A ";

			if(($month1=="--") && ($year1=="--") && ($month2=="--") && ($year2=="--"))
			{
			 $companysql = "SELECT pe.MAMAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
							Amount, DATE_FORMAT( DealDate, '%b-%Y' ) as dealperiod,Asset
							 FROM mama AS pe, industry AS i, pecompanies AS pec
							 WHERE pec.industry = i.industryid
							 AND pec.PEcompanyID = pe.PECompanyID
							 and pe.Deleted=0"  .$addVCFlagqry." order by DealDate desc,Amount desc";

			}
			elseif (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--") )
				{

					$dt1 = $year1."-".$month1."-01";
					//echo "<BR>DATE1---" .$dt1;
					$dt2 = $year2."-".$month2."-01";
					$companysql = "select pe.MAMAId,pe.PECompanyID,pec.companyname,pec.industry,i.industry,
				    Amount,DATE_FORMAT(DealDate,'%b-%Y') as dealperiod,Asset
					from mama as pe, industry as i,pecompanies as pec where pec.industry=i.industryid
					and DealDate between '".$dt1."' and '".$dt2 ."'
					and	pec.PEcompanyID = pe.PECompanyID
					and pe.Deleted=0" .$addVCFlagqry. " order by DealDate desc,pe.Amount desc ";
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
					document.meracqgetdata.action="meracqgetdata.php";
					document.meracqgetdata.submit();
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
	  <div style="background-color:#FFF; width:565px; /*height:405px;*/ margin-top:5px;" class="main_content_container">
	    <div id="maintextpro">
        <div id="headingtextpro">
            <form name="meracqgetdata"  method="post" >
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
					<div style="width: 542px; /*height:305px;*/ overflow: scroll;" class="content_container">
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
									<A style="text-decoration:none" href="meracqeditdata.php?value=<?php echo $myrow["MAMAId"];?> "
								   target="popup" onclick="window.open('meracqeditdata.php?value=<?php echo $myrow["MAMAId"];?>', 'popup', 'scrollbars=1,width=700,height=500');return false">
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
			</span> 
                    </form>
                        <span style="float:left;margin-left:3px;">
                             <form name="pelisting"  method="post" action="exportmeracq.php">
                                 <input type="hidden" name="month1" value=<?php echo $month1; ?> >
                                 <input type="hidden" name="month2" value=<?php echo $month2; ?> >
                                 <input type="hidden" name="year1" value=<?php echo $year1; ?> >
                                 <input type="hidden" name="year2" value=<?php echo $year2; ?> >
                                 <input type="submit"  value="Export" name="showdeals">
                             </form>
                </span>
		</div>


	        </div> <!-- end of maintext pro-->
                
                
		<div id="headingtextproboldbcolor" style="margin-top:-30px;width:90%">&nbsp; No. of Deals  - <?php echo $totalInv; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

		Amount (US$ Million)&nbsp;<?php echo $totalAmount; ?> <br />
	  </div>
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