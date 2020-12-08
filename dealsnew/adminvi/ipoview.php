<?php include_once("../../globalconfig.php"); ?>
<?php
 	session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900))
	{
	    // last request was more than 3 minates ago
	    session_destroy();   // destroy session data in storage
	    session_unset();     // unset $_SESSION variable for the runtime
	    echo "<br>Your session has expired...";
	
	?>
	   <table border=o align=center cellpadding=0 cellspacing=0 width=95%
	    style="font-family: Arial; font-size: 10pt; 
	     border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
	    <tr><td><A href="../pelogin.php" >Click here </a>to login again </td></tr>
	    </table> 
	<?php
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	

	 if ((session_is_registered("UserNames")))
	{

			$sesID=session_id();
			//echo "<br>peview session id--" .$sesID;

			 require("../dbconnectvi.php");
			 $Db = new dbInvestments();
			 	$buttonClicked=$_POST['hiddenbutton'];
				$fetchRecords=true;
				$totalDisplay="";
				$keyword= $_POST['investorsearch'];
				$companysearch=$_POST['companysearch'];
				$advisorsearch=$_POST['advisorsearch'];
				$advisorsearch="";
				$industry=$_POST['industry'];
                                $investorType=$_POST['invType'];
                                $exitstatusvalue=$_POST['exitstatus'];
                                $investorSale=$_POST['invSale'];
				$whereind="";
				$whereinvType="";
				$whereinvestorSale="";
				$wheredates="";
				$wheredates1="";
				$whereexitstatus="";

				$month1=$_POST['month1'];
				$year1 = $_POST['year1'];
				$month2=$_POST['month2'];
				$year2 = $_POST['year2'];

				$notable=false;
				$vcflagValue=$_POST['txtvcFlagValue'];

				$searchallfield=$_POST['searchallfield'];
				$searchallfieldhidden=ereg_replace(" ","-",$searchallfield);

			//	echo "<br>FLAG VALIE--" .$vcflagValue;
				if($vcflagValue==0)
				{
					$addVCFlagqry = "" ;
					$searchTitle = "List of PE-backed IPOs ";
					$searchAggTitle = "Aggregate Data - PE-backed IPOs ";
				}
				elseif($vcflagValue==1)
				{
					$addVCFlagqry = " and VCFlag=1 ";
					$searchTitle = "List of VC-backed IPOs ";
					$searchAggTitle = "Aggregate Data - VC-backed IPOs ";
				}

				//echo "<br>Investor search*- ". $keyword ;
				/*echo "<br>Company search*- " .$companysearch;
				echo "<br>Advisor search*- " .$advisorsearch;
				echo "<br>Industry*- " .$industry;
				echo "<br>Dates- " .$month1 ." ** " .$year1. " ** " .$month2. " ** " .$year2 ; */


		if($industry >0)
		{
			$industrysql= "select industry from industry where IndustryId=$industry";
			if ($industryrs = mysql_query($industrysql))
			{
				While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
				{
					$industryvalue=$myrow["industry"];
				}
			}
		}
		if($investorType !="--")
		{
		       $invTypeSql= "select InvestorTypeName from investortype where InvestorType='$investorType'";
		       if ($invrs = mysql_query($invTypeSql))
		       {
		          While($myrow=mysql_fetch_array($invrs, MYSQL_BOTH))
		          {
		             $invtypevalue=$myrow["InvestorTypeName"];
		          }
		       }
		}

		$datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
		$splityear1=(substr($year1,2));
		$splityear2=(substr($year2,2));

		if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
		{	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
			$datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
					$dt1 = $year1."-".$month1."-01";
					$dt2 = $year2."-".$month2."-01";
					$wheredates1= "";
		}

			$aggsql= "select count(pe.IPOId) as totaldeals,sum(pe.IPOSize)
					as totalamount from ipos as pe,industry as i,pecompanies as pec where";

		if($range != "--")
		{
			$rangesql= "select startRange,EndRange from investmentrange where InvestRangeId=". $range ." ";
			if ($rangers = mysql_query($rangesql))
			{
				While($myrow=mysql_fetch_array($rangers, MYSQL_BOTH))
				{
					$startRangeValue=$myrow["startRange"];
					$endRangeValue=$myrow["EndRange"];
					$rangeText=$myrow["RangeText"];

				}
			}
		}
		if($exitstatusvalue==0)
		  $exitstatusdisplay="Partial Exit";
		elseif($exitstatusvalue==1)
                  $exitstatusdisplay="Full Exit";
                elseif($exitstatusvalue=="--")
                  $exitstatusdisplay="";

			if ((trim($keyword)=="") && (trim($companysearch)=="")  && ($searchallfield=="") && ($industry =="--") && ($investorType == "--") && ($exitstatusvalue=="--") && ($investorSale == "--")&& ($month1 == "--")  && ($year1 == "--") && ($month2 == "--") && ($year2 == "--") )
			{
				//&& (trim($advisorsearch)=="")
		//		echo "<br>Query for all records";
				$yourquery=0;
				 $companysql = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				 pe.IPOSize,pe.IPOAmount, pe.IPOValuation, DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate , pec.website, pec.city,
				 pec.region,IPOId,Comment,MoreInfor,hideamount,hidemoreinfor FROM ipos AS pe, industry AS i, pecompanies AS pec
						 WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID
						 and pe.Deleted=0" .$addVCFlagqry.
						 " order by companyname";
			//     echo "<br>all records" .$companysql;
			}
			elseif ($companysearch != "")
			{
				$yourquery=1;
				$datevalueDisplay1="";
				$companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				pe.IPOSize,pe.IPOAmount, pe.IPOValuation, DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate,
				pec.website,pec.city, pec.region, IPOId,
				Comment,MoreInfor,hideamount,hidemoreinfor FROM ipos AS pe, industry AS i,
				pecompanies AS pec
				WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
				" AND pe.Deleted =0 " .$addVCFlagqry. " AND ( pec.companyname LIKE '%$companysearch%'
				OR sector_business LIKE '%$companysearch%' )
				order by companyname";
			//	echo "<br>Query for company search";
		 	 //echo "<br> Company search--" .$companysql;
			}
			elseif($keyword!="")
			{
				$yourquery=1;
				$datevalueDisplay1="";
				$companysql="select peinv.PECompanyId,c.companyname,c.industry,i.industry,sector_business,peinv.IPOSize,
				peinv_inv.InvestorId,peinv_inv.IPOId,inv.Investor,peinv.PECompanyId,c.industry,
				c.companyname,DATE_FORMAT( peinv.IPODate, '%M-%Y' )as IPODate,i.industry,hideamount
			from ipo_investors as peinv_inv,peinvestors as inv,
			ipos as peinv,pecompanies as c,industry as i
			where inv.InvestorId=peinv_inv.InvestorId and c.industry = i.industryid " .$wheredates1.
			" and peinv.IPOId=peinv_inv.IPOId and c.PECompanyId=peinv.PECompanyId
			and " .$addVCFlagqry."  inv.investor like '%$keyword%' order by companyname";
		//		echo "<br> Investor search- ".$companysql;
			}
			elseif ($searchallfield != "")
			{
				$yourquery=1;
				$datevalueDisplay1="";
				$companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				pe.IPOSize,pe.IPOAmount, pe.IPOValuation, DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate,
				pec.website,pec.city, pec.region, IPOId,
				Comment,MoreInfor,hideamount,hidemoreinfor FROM ipos AS pe, industry AS i,
				pecompanies AS pec
				WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
				" AND pe.Deleted =0 " .$addVCFlagqry. " AND ( pec.companyname LIKE '%$searchallfield%'
				OR sector_business LIKE '%$searchallfield%' or  MoreInfor LIKE '%$searchallfield%' or  InvestmentDeals LIKE '%$searchallfield%' )
				order by companyname";
			//	echo "<br>Query for company search";
			 //echo "<br> Company search--" .$companysql;
			}

			elseif($advisorsearch!="")
			{
				$yourquery=1;
				$datevalueDisplay1="";
				$companysql="SELECT peinv.IPOId, peinv.PECompanyId, c.companyname, i.industry,
				c.sector_business,peinv.IPOSize,DATE_FORMAT( peinv.IPODate, '%M-%Y' )as IPODate,
				cia.CIAId, cia.cianame, adac.CIAId AS AcqCIAId,
				 hideamount
				FROM advisor_cias AS cia, ipos AS peinv, pecompanies AS c, industry AS i,
				peinvestments_advisorcompanies AS adac
				WHERE peinv.Deleted=0 and c.industry = i.industryid
				AND c.PECompanyId = peinv.PECompanyId " .$addVCFlagqry.
				" AND adac.CIAId=cia.CIAId and adac.PEId=peinv.IPOId and
				cia.cianame LIKE '%$advisorsearch%'
				AND c.industry !=15
				order by companyname";
				$fetchRecords=true;
				$fetchAggregate==false;
			//echo "<br> Advisor Acquirer search- ".$companysql;
			}
			elseif (($industry > 0) || ($exitstatusvalue!="--") ||  ($investorType != "--") || ($investorSale!="--" ) || (($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--")) )
				{
					$yourquery=1;

					$dt1 = $year1."-".$month1."-01";
				//	echo "<BR>DATE1---" .$dt1;
					$dt2 = $year2."-".$month2."-01";
					$companysql = "select pei.PECompanyID,pec.companyname,pec.industry,i.industry,
					pec.sector_business,pei.IPOSize,IPOAmount,IPOValuation,DATE_FORMAT(IPODate,'%M-%Y') as IPODate,
					pec.website,pec.city,IPOId,Comment,MoreInfor,hideamount,hidemoreinfor
					from ipos as pei, industry as i,pecompanies as pec where";
					//echo "<br> individual where clauses have to be merged ";
					if ($industry > 0)
						{
							$whereind = " pec.industry=" .$industry ;
							$qryIndTitle="Industry - ";
						}
			//	echo "<br> WHERE IND--" .$whereind;
			    	           if ($investorType!= "--")
						{
							$qryInvType="Investor Type - " ;
							$whereInvType = " pei.InvestorType = '".$investorType."'";
						}
					 if($exitstatusvalue!="--")
                                          {    $whereexitstatus=" pei.ExitStatus=".$exitstatusvalue;}
                                          if($investorSale!="--")
                                          {    $whereinvestorSale=" pei.InvestorSale=".$investorSale;}

						if ($region!= "--")
							{
								$qryRegionTitle="Region - ";
								$whereregion = " pei.region ='".$region."'";
							}
					//	echo " <bR> where REGION--- " .$whereregion;

						if(($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
						{
							$qryDateTitle ="Period - ";
							$wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "'";

						}
					if ($whereind != "")
						{
							$companysql=$companysql . $whereind ." and ";
							$aggsql=$aggsql . $whereind ." and ";
							$bool=true;
						}
						else
						{
							$bool=false;
						}
                                        if (($whereInvType != "") )
						{
							$companysql=$companysql .$whereInvType . " and ";
							$aggsql = $aggsql . $whereInvType ." and ";
							$bool=true;
						}
						if($whereinvestorSale!="")
                                                {
                                                  $companysql=$companysql .$whereinvestorSale . " and ";
                                                }
					if(($wheredates !== "") )
					{
						$companysql = $companysql . $wheredates ." and ";
						$aggsql = $aggsql . $wheredates ." and ";
						$bool=true;
					}
					$companysql = $companysql . "  i.industryid=pec.industry and
					pec.PEcompanyID = pei.PECompanyID  and
					pei.Deleted=0 " .$addVCFlagqry. " order by companyname ";
					//echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
				}
				else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="language" content="en-us" />
<title>Venture Intelligence - PE Investments</title>

<script type="text/javascript">

</script>

<style type="text/css">


</style>
<link href="../style.css" rel="stylesheet" type="text/css">

</head><body>

<form name="pelisting"  method="post" action="exportipodeals.php">
<div id="containerproductpeview">
<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgpropeview">
    	<div id="vertMenu">
        	<div>Welcome ! &nbsp;&nbsp;<?php echo $UserNames; ?> <br/ ><br /></div>

						<div><a href="changepassword.php">Change your Password </a> <br /><br /></div>
						<div><a href="dealhome.php">Database Home</a> <br /><br /></div>

			<div><a href="../logoff.php">Logout </a> <br /><br /></div>
      	</div>


    </div>
   </div>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
<!--   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>-->
	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; height:445px; margin-top:0px;">
	    <div id="maintextpro">
        <div id="headingtextpro">
       	<input type="hidden" name="txtsearchon" value="2" >
       	<input type="hidden" name="txttitle" value=<?php echo $vcflagValue; ?> >
        <input type="hidden" name="txthidename" value=<?php echo $UserNames; ?> >
		<input type="hidden" name="txthideemail" value=<?php echo $UserEmail; ?> >
		<input type="hidden" name="txthideindustry" value=<?php echo $industryvalue; ?> >
		<input type="hidden" name="txthideindustryid" value=<?php echo $industry; ?> >
                <input type="hidden" name="txthideinvtype" value=<?php echo $invtypevalue; ?> >
		<input type="hidden" name="txthideinvtypeid" value=<?php echo $investorType; ?> >
		<input type="hidden" name="txthideexitstatusvalue" value=<?php echo $exitstatusvalue; ?> >
		<input type="hidden" name="txthideinvestorSale" value=<?php echo $investorSale; ?> >
		<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
		<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
		<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >
		<input type="hidden" name="txthideinvestor" value=<?php echo $keyword; ?> >
		<input type="hidden" name="txthidecompany" value=<?php echo $companysearch; ?> >
		<input type="hidden" name="txthideadvisor" value=<?php echo $advisorsearch; ?> >
		<input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >


		<?php
				$exportToExcel=0;;
				$TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
					where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";
					//echo "<br>---" .$TrialSql;
					if($trialrs=mysql_query($TrialSql))
					{
						while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
						{
							$exportToExcel=$trialrow["TrialLogin"];
							$studentOption=$trialrow["Student"];

						}
					}
					if($yourquery==1)
						$queryDisplayTitle="Query:";
					elseif($yourquery==0)
						$queryDisplayTitle="";

					if(trim($buttonClicked==""))
					{
						$totalDisplay="Total";
				    	$industryAdded ="";
				    	$totalAmount=0.0;
				    	$totalInv=0;
						$compDisplayOboldTag="";
						$compDisplayEboldTag="";
				 	  // echo "<br> query final-----" .$companysql;
				 	      /* Select queries return a resultset */
						 if ($companyrs = mysql_query($companysql))
						 {
						    $company_cnt = mysql_num_rows($companyrs);
						 }

				           if($company_cnt > 0)
				           {
				           		//$searchTitle=" List of Deals";
				           }
				           else
				           {
				              	$searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
				              	$notable=true;
				           }

		           ?>
				<div id="headingtextproboldfontcolor">
				<?php
					echo $queryDisplayTitle;

				if($industry >0 )
					echo "> " .$industryvalue;
                                if($investorType !="--")
					echo "&nbsp;&nbsp;&nbsp;> ".$invtypevalue;
				if($investorSale==1)
                                        echo "&nbsp;&nbsp;&nbsp;> Investor Sale";
				if($datevalueDisplay1!="")
					echo "&nbsp;&nbsp;&nbsp;> ".$datevalueDisplay1. "-" .$datevalueDisplay2;
				if($keyword!="")
					echo "&nbsp;&nbsp;&nbsp;> ".$keyword;
				if($companysearch!="")
					echo "&nbsp;&nbsp;&nbsp;> ".$companysearch;
				if($advisorsearch!="")
					echo "&nbsp;&nbsp;&nbsp;> ".$advisorsearch;
				if($searchallfield!="")
					echo "&nbsp;&nbsp;&nbsp;> ".$searchallfield;
				?>

			 <br /><br /></div>
						<div id="headingtextproboldfontcolor"> <?php echo $searchTitle; ?> <br />  </div>
					<?php
					if($notable==false)
					{
					?>
						<!--<div id="tableContainer" class="tableContainer"> -->
					<div style="width: 500px; height: 315px; overflow: scroll;">


								<table border="1" cellpadding="3" cellspacing="0" width="100%"  >
							<!--	<thead class="fixedHeader"> -->
									<tr>
										<th width=15%>Company</th>
										<th width=15%> Sector</th>
										<th width=7%>Size(US$M)</th>
										<th width=8%>Exit Info </th>
									</tr>

							<!--	</thead>  -->
						<?php
						if ($company_cnt>0)
						  {



						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
								if($myrow["hideamount"]==1)
								{
									$hideamount="--";
								}
								else
								{
									$hideamount=$myrow[5];
								}
								if(trim($myrow["sector_business"])=="")
									$showindsec=$myrow["industry"];
								else
									$showindsec=$myrow["sector_business"];
					   ?>
								<!--<tbody class="scrollContent">-->
									<tr>
										<td ><?php echo $myrow["companyname"]; ?>&nbsp;</td>
										<td><?php echo trim($showindsec); ?></td>
										<td align=right><?php echo $hideamount; ?>&nbsp;</td>
										<td>
											<A href="ipodealinfo.php?value=<?php echo $myrow["IPOId"];?>/<?php echo $searchallfield;?>  "
										   target="popup" onclick="MyWindow=window.open('ipodealinfo.php?value=<?php echo $myrow["IPOId"];?>/<?php echo $searchallfield;?> ', 'popup', 'scrollbars=1,width=600,height=400,status=no');MyWindow.focus(top);return false">
										   click here
									 	</A>   </td>
									</tr>
								<!--</tbody>-->
							<?php
								$industryAdded = $myrow[2];
								$totalInv=$totalInv+1;
								$totalAmount=$totalAmount+$myrow[5];
							}
						}
						?>
					 </table>
					</div>
			<?php
			}
		?>
		<?php
		if($studentOption==1)
		{
		?>
		<div id="headingtextproboldbcolor">&nbsp; No. of Deals  - <?php echo $totalInv; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									&nbsp;&nbsp;&nbsp;
									Amount (US$ M)
					<?php echo $totalAmount; ?> <br /></div>
				<?php
			
			if($exportToExcel==1)
			{
                        ?>
                          <span style="float:left" class="one">
			        To Export the above deals into a Spreadsheet,&nbsp;<input type="submit"  value="Click Here" name="showdeals">
			        </span>
			<?php
			}
		}
		else
		{
				if($exportToExcel==1)
				{
				?>
					<div id="headingtextproboldbcolor">&nbsp; No. of Deals  - <?php echo $totalInv; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					&nbsp;&nbsp;&nbsp;
					Amount (US$ Million)
					<?php echo $totalAmount; ?> <br /></div>
				<?php
				}
				else
				{
				?>
					<div id="headingtextproboldbcolor">&nbsp;No. of Deals - XX &nbsp;&nbsp;&nbsp;&nbsp;Value (US$ M) - YYY <br />Aggregate data for each search result is displayed here for Paid Subscribers <br /></div>

				<?php
				}
		?>

		<?php
					if(($totalInv>0) &&  ($exportToExcel==1))
					{
		?>
		<span style="float:left" class="one">
			To Export the above deals into a Spreadsheet,&nbsp;<input type="submit"  value="Click Here" name="showipodeals">
		</span>
		<?php
					}

			elseif(($totalInv<=0) &&  ($exportToExcel==1))
			{
			}
			elseif(($totalInv>0) && ($exportToExcel==0))
			{
					?>
							<span style="float:left" class="one">
							<b>Note:</b> Only paid subscribers will be able to export data on to Excel.
							<a target="_blank" href="../xls/sample-pe-backed-IPOs.xls"><u>Click Here</u> </a> for a sample spreadsheet containing PE-backed IPOs
							</span>
					<?php
					}
		} //end of student if
		?>
		</div>
		<?php
					}
					elseif($buttonClicked=='Aggregate')
					{

						$aggsql= $aggsql. " i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
								and  pe.Deleted=0 " .$addVCFlagqry.
									 " order by pe.IPOSize desc,IPODate desc";
							//echo "<br>Agg SQL--" .$aggsql;
							 if ($rsAgg = mysql_query($aggsql))
							 {
								$agg_cnt = mysql_num_rows($rsAgg);
							 }
							   if($agg_cnt > 0)
							   {
									 While($myrow=mysql_fetch_array($rsAgg, MYSQL_BOTH))
									   {
											$totDeals = $myrow["totaldeals"];
											$totDealsAmount = $myrow["totalamount"];
										}
							   }
							   else
							   {
									$searchTitle= $searchTitle ." -- No Investments found for this search";
							   }
							   if($industry >0)
							   {
							   	  $indSql= "select industry from industry where industryid=$industry";
							   	  if($rsInd=mysql_query($indSql))
							   	  {
								   	  while($myindRow=mysql_fetch_array($rsInd,MYSQL_BOTH))
								   	  {
								   	  	$indqryValue=$myindRow["industry"];
								   	  }
								   }
								}
								if($dealtype!= "--")
								{
									$dealSql= "select Stage from dealtypes where StageId=$stage";
								  	if($rsDealType=mysql_query($dealSql))
								  	{
									  while($mydealRow=mysql_fetch_array($rsDealType,MYSQL_BOTH))
									  {
										$stageqryValue=$mydealRow["Stage"];
									  }
								   	}
								 }
								if($range!= "--")
								{
									$rangeqryValue= $range;
								}
								if($wheredates !== "")
								{
									$dateqryValue= returnMonthname($month1) ." ".$year1 ." - ". returnMonthname($month2) ." " .$year2;
								}
								$searchsubTitle="";
								if(($industry==0) && ($wheredates==""))
								{
									$searchsubTitle= "All";
								}

					?>
						<div id="headingtextpro">
						<div id="headingtextproboldfontcolor"> <?php echo $searchAggTitle; ?> <br />  <br /> </div>
						<div id="headingtextprobold"> Search By :  <?php echo $searchsubTitle; ?> <br /> <br /></div>
					<?php
						$spacing="<Br />";
						if ($industry > 0)
						{

					?>
							<?php echo $qryIndTitle; ?><?php echo $indqryValue; ?> <?php echo $spacing; ?>
					<?php
						}

						if($wheredates!="--")
						{
					?>
							<?php echo $qryDateTitle; ?><?php echo $dateqryValue; ?> <?php echo $spacing; ?>
					<?php
						}
					?>
						<div id="headingtextprobold"> <br />No of Deals : <?php echo $totDeals; ?>  <br /> <br/></div>
						<div id="headingtextprobold"> Value (US $M) : <?php echo $totDealsAmount; ?>   <br /></div>
						</div>
					<?php
					}
			?>

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

 }
 else
	header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;
function returnMonthname($mth)
		{
			if($mth==1)
				return "Jan";
			elseif($mth==2)
				return "Feb";
			elseif($mth==3)
				return "Mar";
			elseif($mth==4)
				return "Apr";
			elseif($mth==5)
				return "May";
			elseif($mth==6)
				return "Jun";
			elseif($mth==7)
				return "Jul";
			elseif($mth==8)
				return "Aug";
			elseif($mth==9)
				return "Sep";
			elseif($mth==10)
				return "Oct";
			elseif($mth==11)
				return "Nov";
			elseif($mth==12)
				return "Dec";
	}

 ?>