<?php include_once("../../globalconfig.php"); ?>
<?php
 	session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
		{

			$sesID=session_id();
			//echo "<br>peview session id--" .$sesID;
			 require("../dbconnectvi.php");
			 $Db = new dbInvestments();

		$delPEIdArrayLength=0;
		$delPEId=$_POST['PEId'];
		$delPEIdArrayLength= count($delPEId);

		$hidePEIdArrayLength=0;
                $hidePEId=$_POST['hideAgg'];
                $hidePEIdArrayLength=count($hidePEId);
                //echo "<br>****".$hidePEIdArrayLength;

		if($delPEIdArrayLength>0)
		{
			foreach ($delPEId as $delPEIdtoDelete)
			{
				$updateSql="Update peinvestments set Deleted=1 where PEId=".$delPEIdtoDelete ;
				if ($companyrs=mysql_query($updateSql))
				{
				//echo "<Br>--".$updateSql;
				}
			}
		}
		if($hidePEIdArrayLength>0)
		{
			foreach ($hidePEId as $hidePEIdtoHide)
			{
				$updateAggHideSql="Update peinvestments set AggHide=1 where PEId=".$hidePEIdtoHide ;
				if ($companyrs=mysql_query($updateAggHideSql))
				{
				//echo "<Br>--".$updateAggHideSql;
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
					$searchTitle = "List of PE Investments ";

			if(($month1=="--") && ($year1=="--") && ($month2=="--") && ($year2=="--"))
			{
			 $companysql = "SELECT pe.PEId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
							 amount, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod,pe.comment,pe.uploadfilename,FinLink,AggHide
							 FROM peinvestments AS pe, industry AS i, pecompanies AS pec ,stage as s
							 WHERE pec.industry = i.industryid
							 AND pec.PEcompanyID = pe.PECompanyID and s.StageId=pe.StageId
							 and pe.Deleted=0" .$addVCFlagqry.
						 "order by companyname";

			}
			elseif (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--") )
				{

					$dt1 = $year1."-".$month1."-01";
					//echo "<BR>DATE1---" .$dt1;
					$dt2 = $year2."-".$month2."-01";
					$companysql = "select pe.PEId,pe.PECompanyID,pec.companyname,pec.industry,i.industry,
					amount,DATE_FORMAT(dates,'%b-%Y') as dealperiod,pe.comment,pe.uploadfilename,FinLink ,AggHide
					from peinvestments as pe, industry as i,pecompanies as pec,stage as s where pec.industry=i.industryid
					and dates between '".$dt1."' and '".$dt2 ."'
					and	pec.PEcompanyID = pe.PECompanyID  and s.StageId=pe.StageId
					and pe.Deleted=0 " .$addVCFlagqry. "order by companyname  ";
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
	var e=document.getElementsByName("PEId[]");
		for(var i=0;i<e.length;i++)
		{
			chk=e[i].checked;
		//	alert(chk);
			if(chk==true)
			{
				if (confirm("Are you sure you want to delete selected deals ? "))
				{
					e[i].checked=true;
					document.pegetdata.action="pegetdata.php";
					document.pegetdata.submit();
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
function aggHide()
{

	var chk1;
	var e1=document.getElementsByName("hideAgg[]");
		for(var j=0;j<e1.length;j++)
		{
			chk1=e1[j].checked;
		//	alert(chk);
			if(chk1==true)
			{
				if (confirm("Are you sure you want to hide the selected deals ? "))
				{
					e1[j].checked=true;

					document.pegetdata.action="pegetdata.php";
					document.pegetdata.submit();
					break;
				}
			}
		}


	if (chk1==false)
		{
			alert("Pls select one or more to hide");
			return false;
		}
}
</script>

<style type="text/css">


</style>
<link href="../style.css" rel="stylesheet" type="text/css">

</head><body>

<form name="pegetdata"  method="post" >
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
				<a href="peadd.php">Add PE Inv </a> | <a href="ipoadd.php">IPO </a> | <a href="mandaadd.php">MandA  </a> | <a href="mamaadd.php">MA  </a><br />
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
		<input type="hidden" name="pe_or_re"" value="PE" >

		<?php

				 	  // echo "<br> query final-----" .$companysql;
				 	      /* Select queries return a resultset */
						 if ($companyrs = mysql_query($companysql))
						 {
						    $company_cnt = mysql_num_rows($companyrs);
						 }
				           if($company_cnt > 0)
				           {
				           	//	$searchTitle=" List of Deals";
				           }
				           else
				           {
				              	$searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
				           }

		           ?>
						<div id="headingtextproboldfontcolor"> <?php echo $searchTitle; ?>
                                               <!-- <input type="button" value="Financials" border=0 bgcolor='#D0A9F5' > &nbsp;&nbsp;&nbsp;<input type="button" value="Fin Link">
                                                 -->
                                                 <br />  <br /> </div>
					<?php
					if($company_cnt>0)
					{

					?>
						<!--<div id="tableContainer" class="tableContainer"> -->
					<div style="width: 542px; height:305px; overflow: scroll;">
								<table border="1" cellpadding="3" cellspacing="0" width="100%"  >
								<tr>
										<th> Del </th>
                                                                                <th> Hide Agg </th>
										<th>Company</th>
										<th>Industry</th>
										<th>Amt(US$M)</th>
										<th>Date </th>
									</tr>
						<?php
						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
                                                         //marking with color if the column is empty
                                                          $bgcolor="#FFF";    //white
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
									if($myrow["AggHide"]==1)
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
							 		<td align=center><input name="PEId[]" type="checkbox" value=" <?php echo $myrow["PEId"]; ?>" ></td>
                                                                        <td align=center><input name="hideAgg[]" type="checkbox" value=" <?php echo $myrow["PEId"]; ?>" ></td>
									<td width=35% bgcolor=<?php echo $bgcolor;?> ><?php echo $openBracket;?><?php echo $compDisplayOboldTag ?>
									<A style="text-decoration:none" href="peeditdata.php?value=PE-<?php echo $myrow["PEId"];?> "
								   target="popup" onclick="window.open('peeditdata.php?value=PE-<?php echo $myrow["PEId"];?>', 'popup', 'scrollbars=1,width=600,height=500');return false">
								   <?php echo $myrow["companyname"]; ?>  &nbsp;<?php echo $compDisplayOboldTag ?>
									</A><?php echo $closeBracket ; ?></td>


										<td><?php echo $myrow["industry"];?></td>
										<td align=right width=10%><?php echo $myrow["amount"]; ?>&nbsp;</td>
										<td><?php echo $myrow["dealperiod"];?> </td>
									 </tr>
							<?php
								$totalInv=$totalInv+1;
								$totalAmount=$totalAmount+ $myrow["amount"];
							}

						?>
					 </table>
					</div>

		<?php
					}
		?>
			<span style="float:left" class="one">
			<input type="button"  value="Delete Deal(s)" name="delDeal"  onClick="updateDeletion();">
			<input type="button"  value="Hide for Aggregate" name="aggHideDeal"  onClick="aggHide();">
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