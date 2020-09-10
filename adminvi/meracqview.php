<?php include_once("../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
				$Db = new dbInvestments();
 session_save_path("/tmp");
session_start();
if (isset($_SESSION['MALAST_ACTIVITY']) && (time() - $_SESSION['MALAST_ACTIVITY'] > 1800))
{
    // last request was more than 3 minates ago
   // echo "<br>___";
    session_destroy();   // destroy session data in storage
    session_unset();     // unset $_SESSION variable for the runtime
    echo "<br>Your session has expired...";
?>
   <table border=0 align=center cellpadding=0 cellspacing=0 width=95%
	style="font-family: Arial; font-size:10pt;
	 border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
    <tr><td><A href="../malogin.php" >Click here </a>to login again </td></tr>
    </table>

<?php

}
$_SESSION['MALAST_ACTIVITY'] = time(); // update last activity time stamp

$username=$_SESSION['MAUserNames'];
		$emailid=$_SESSION['MAUserEmail'];
	 if ((session_is_registered("MAUserNames")))
	{
			$sesID=session_id();
			$ipadd=$_SESSION['MAIP'];
                        if($ipadd=="MIP")
                          $logvar="MIP";
                        else
                          $logvar="M";
			
				$notable=false;
				/*$vcflagValue=$_POST['txtvcFlagValue'];

				if($vcflagValue==1)
				{
					$addVCFlagqry = " and VCFlag=1";
					$searchTitle = "List of VC Exits - M&A";
					$searchAggTitle = "Aggregate Data - VC Exits - M&A";
				}
				else
				{
					$addVCFlagqry = "";
					$searchTitle = "List of PE Exits - M&A";
					$searchAggTitle = "Aggregate Data - PE Exits - M&A";
				} */

				$searchTitle= "Mergers & Acquistions";
				//echo "<br>1 --". $vcflagValue;

									$aggsql="";
									$totalDisplay="";
									$acquirersearch= $_POST['keywordsearch'];
									if($acquirersearch!=="")
									{
										$splitStringAcquirer=explode(" ", $acquirersearch);
										$splitString1Acquirer=$splitStringAcquirer[0];
										$splitString2Acquirer=$splitStringAcquirer[1];
										$stringToHideAcquirer=$splitString1Acquirer. "+" .$splitString2Acquirer;
									}
									$targetcompanysearch=$_POST['companysearch'];
									if($targetcompanysearch!=="")
									{
										$splitString=explode(" ", $targetcompanysearch);
										$splitString1=$splitString[0];
										$splitString2=$splitString[1];
										$stringToHide=$splitString1. "+" .$splitString2;
									}
									//echo "<Br>--------" .$targetcompanysearch;
									$advisorsearch_legal=$_POST['advisorsearch_legal'];
									$advisorsearchhidden_legal=ereg_replace(" ","-",$advisorsearch_legal);

                                                                        $advisorsearch_trans=$_POST['advisorsearch_trans'];
									$advisorsearchhidden_trans=ereg_replace(" ","-",$advisorsearch_trans);

									$searchallfield=$_POST['searchallfield'];
									$searchallfieldhidden=ereg_replace(" ","-",$searchallfield);

									$industry=$_POST['industry'];
									$dealtypeId=$_POST['dealType'];
									$targetProjectTypeId=$_POST['targetType'];
									//$range=$_POST['invrangestart'];
									//echo "<br>--" .$dealtypeId;
									//$range1=$_POST['invrangeend'];

                                                                        $target_comptype=$_POST['targetcompanytype'];
                                                                        $acquirer_comptype=$_POST['acquirercompanytype'];
                                                                        //echo "<br>***".$target_comptype;
									$startRangeValue=$_POST['invrangestart'];
									$endRangeValue=$_POST['invrangeend'];
									$endRangeValueDisplay =$endRangeValue;

									//$startRangeValue="--";
									//$endRangeValue="--";

									//$targetCountryId=$_POST['targetCountry'];
									//$acquirerCountryId=$_POST['acquirerCountry'];
									if($_POST['targetCountry'])
										$targetCountryId=$_POST['targetCountry'];
									else
										$targetCountryId="--";

									IF($_POST['acquirerCountry'])
										$acquirerCountryId=$_POST['acquirerCountry'];
									else
										$acquirerCountryId="--";


									$month1=$_POST['month1'];
									$year1 = $_POST['year1'];
									$month2=$_POST['month2'];
									$year2 = $_POST['year2'];



									$whereind="";
									$wheredealtype="";
									$wheredates="";
									$whererange="";
									$wheretargetCountry="";
									$whereacquirerCountry="";
									$wheretargetcomptype="";
                                                                        $whereacquirercomptype="";

				$datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
				$splityear1=(substr($year1,2));
				$splityear2=(substr($year2,2));

				if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
				{	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
					$datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
					$wheredates1= "";
				}
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
					if($dealtypeId >0)
					{
						$dealtypesql= "select MADealType from madealtypes where MADealTypeId=$dealtypeId";
						if ($dealtypers = mysql_query($dealtypesql))
						{
							While($myrow=mysql_fetch_array($dealtypers, MYSQL_BOTH))
							{
								$dealtypevalue=$myrow["MADealType"];
							}
						}
					}

					if($targetProjectTypeId ==1)
                                		$projecttypename="Entity";
					elseif($targetProjectTypeId ==2)
                                                $projecttypename="Project / Asset";
				if($target_comptype=="L")
				{   $target_comptype_display="Target Type-Listed";}
				elseif($target_comptype=="U")
				{   $target_comptype_display="Target Type-Unlisted";}
				else
                                {    $target_comptype_display="";}


                                if($acquirer_comptype=="L")
				   $acquirer_comptype_display="Acquirer Type-Listed";
				elseif($acquirer_comptype=="U")
				   $acquirer_comptype_display="Acquirer Type-Unlisted";
				else
                                    $acquirer_comptype_display="";

                                if($targetCountryId !="--")
					{
						$countrySql= "select countryid,country from country where countryid='$targetCountryId'";
						if ($countryrs = mysql_query($countrySql))
						{
							While($myrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
							{
								$targetcountryvalue=$myrow["country"];
							}
						}
					}


				if($acquirerCountryId !="--")
					{
						$AcountrySql= "select countryid,country from country where countryid='$acquirerCountryId'";
						if ($Acountryrs = mysql_query($AcountrySql))
						{
							While($Amyrow=mysql_fetch_array($Acountryrs, MYSQL_BOTH))
							{
								$acquirercountryvalue=$Amyrow["country"];
							}
						}
					}
						//echo "<br>***".$startRangeValue;
						//echo "<br>***".$endRangeValue;
						if(($startRangeValue != "--")&& ($endRangeValue != ""))
						{
							if($startRangeValue==$endRangeValue)
							{
								//echo "<br>--EQUALS";
							}
							elseif($startRangeValue < endRangeValue)
							{
								//echo "<br>--Less than";
								$startRangeValue=$startRangeValue;
								$endRangeValue=$endRangeValue-0.01;
								$rangeText=$myrow["RangeText"];
							}

						}



/*echo "<Br>1";
echo "<br>Acquirer * ".$acquirersearch;
echo "<br>Target * ".$targetcompanysearch;
echo "<br>Advisor * ".$advisorsearch;
echo "<br>Industry * ". $industry;
echo "<br>Deal type * " .$dealtypeId;
echo "<Br>Dates**" .$month1. "**" .$year1. "**" .$month2. "*****" .$year2 ;
echo "<Br>CountryId ** " .$acquirerCountryId ." ** ".$targetCountryId;
echo "<br>Range** " .$startRangeValue . "**" .$endRangeValue;
*/


					if (($acquirersearch == "") && ($targetcompanysearch == "") && ($searchallfield=="") && ($advisorsearch_legal=="") && ($advisorsearch_trans=="")&& ($industry =="--") && ($dealtypeId == "--")  && ($target_comptype=="--") && ($acquirer_comptype=="--") && ($targetProjectTypeId=="--") && ($startRangeValue == "--") && ($endRangeValue == "--")  && ($month1 == "--")  && ($year1 == "--") && ($month2 == "--") && ($year2 == "--") && ($acquirerCountryId=="--") && ($targetCountryId=="--"))
					{
							$yourquery=0;
							 $companysqlFinal = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
							 Amount, MAMAId,Asset,hideamount,pe.AcquirerId,ac.Acquirer ,AggHide
									 FROM mama AS pe, industry AS i, pecompanies AS pec,acquirers as ac
									 WHERE pec.industry = i.industryid
									 AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15
									 and ac.AcquirerId=pe.AcquirerId order by companyname";

					//	echo "<br>3 Query for All records" .$companysqlFinal;
						}
					elseif ($targetcompanysearch != "")
						{
						$yourquery=1;
						$datevalueDisplay1="";
							$companysqlFinal="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business,
							pe.Amount,MAMAId,Asset,hideamount,pe.AcquirerId,ac.Acquirer ,AggHide FROM
							mama AS pe, industry AS i, pecompanies AS pec,acquirers as ac
							WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
							AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry.
							" AND  (pec.companyname LIKE '%$companysearch%' or sector_business like '%$companysearch%')
								order by companyname";
							$fetchRecords=true;
							$fetchAggregate==false;
						//echo "<br>Query for company search";
						// echo "<br> Company search--" .$companysqlFinal;
						}
					elseif($acquirersearch!="")
						{
						$yourquery=1;
						$datevalueDisplay1="";
							$companysqlFinal="SELECT peinv.PECompanyId, peinv.MAMAId,c.companyname, c.industry, i.industry, sector_business,
							peinv.Amount, peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount ,AggHide
							FROM acquirers AS ac, mama AS peinv, pecompanies AS c, industry AS i
							WHERE ac.AcquirerId = peinv.AcquirerId
							AND c.industry = i.industryid
							AND c.PECompanyId = peinv.PECompanyId and peinv.Deleted=0
							AND c.industry !=15  AND ac.Acquirer LIKE '%$acquirersearch%'
							order by companyname ";

					//		echo "<br> Acquirer search- ".$companysqlFinal;
						}
						elseif($advisorsearch_legal!="")
						{
							$yourquery=1;
						$datevalueDisplay1="";

							$companysqlFinal="(select peinv.MAMAId,peinv.PECompanyId,c.companyname,i.industry,c.sector_business,peinv.Amount,
							cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount ,AggHide
							from mama AS peinv, pecompanies AS c, industry AS i,advisor_cias AS cia,mama_advisoracquirer AS adac,acquirers as ac
							where c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0
                                                        and adac.CIAId=cia.CIAID and adac.MAMAId=peinv.MAMAId and AdvisorType='L' and cia.cianame LIKE '%$advisorsearch_legal%')
							UNION
							(select peinv.MAMAId,peinv.PECompanyId,c.companyname,i.industry,c.sector_business,peinv.Amount,
							cia.CIAId,cia.Cianame,adcomp.CIAId AS CompCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount,AggHide
							from mama AS peinv, pecompanies AS c, industry AS i,advisor_cias AS cia,mama_advisorcompanies AS adcomp,acquirers as ac
							where c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0
                                                        and adcomp.CIAId=cia.CIAID and adcomp.MAMAId=peinv.MAMAId and AdvisorType='L' and cia.cianame LIKE '%$advisorsearch_legal%')
							order by companyname";

						//echo "<br> Advisor  search- ".$companysqlFinal;
						}
						elseif($advisorsearch_trans!="")
						{
							$yourquery=1;
						$datevalueDisplay1="";

							$companysqlFinal="(select peinv.MAMAId,peinv.PECompanyId,c.companyname,i.industry,c.sector_business,peinv.Amount,
							cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount,Agghide
							from mama AS peinv, pecompanies AS c, industry AS i,advisor_cias AS cia,mama_advisoracquirer AS adac,acquirers as ac
							where c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0
                                                         and adac.CIAId=cia.CIAID and adac.MAMAId=peinv.MAMAId and AdvisorType='T' and cia.cianame LIKE '%$advisorsearch_trans%')
							UNION
							(select peinv.MAMAId,peinv.PECompanyId,c.companyname,i.industry,c.sector_business,peinv.Amount,
							cia.CIAId,cia.Cianame,adcomp.CIAId AS CompCIAId,peinv.AcquirerId, ac.Acquirer,peinv.Asset,peinv.hideamount,AggHide
							from mama AS peinv, pecompanies AS c, industry AS i,advisor_cias AS cia,mama_advisorcompanies AS adcomp,acquirers as ac
							where c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0
                                                         and adcomp.CIAId=cia.CIAID and adcomp.MAMAId=peinv.MAMAId and AdvisorType='T' and cia.cianame LIKE '%$advisorsearch_trans%')
							order by companyname";

						//echo "<br> Advisor  search- ".$companysqlFinal;
						}

						elseif ($searchallfield != "")
						{
						$yourquery=1;
						$datevalueDisplay1="";
							$companysqlFinal="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business,
							pe.Amount,MAMAId,Asset,hideamount,pe.AcquirerId,ac.Acquirer,AggHide FROM
							mama AS pe, industry AS i, pecompanies AS pec,acquirers as ac
							WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
							AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry.
							" AND  (pec.companyname LIKE '%$searchallfield%' or sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%')
								order by companyname";
							$fetchRecords=true;
							$fetchAggregate==false;
						//echo "<br>Query for company search";
						// echo "<br> Company search--" .$companysqlFinal;
						}

					elseif (($industry > 0) || ($dealtypeId != "--") || ($target_comptype!="--") || ($acquirer_comptype!="--") || ($targetProjectTypeId!="--") || ($startRangeValue !="--") || ($endRangeValue != "--") || (($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--"))|| ($targetCountryId!="--") || ($acquirerCountryId!="--"))
						{
							$yourquery=1;
							$dt1 = $year1."-".$month1."-01";
							$dt2 = $year2."-".$month2."-31";

							$companysql = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry,
							sector_business, pe.Amount, pe.MAMAId, i.industry,pec.countryId,c.country,
							pe.AcquirerId,ac.Acquirer,ac.countryid,pe.Asset,pe.hideamount ,AggHide
							FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac

							where";

							if ($industry > 0)
							{
								$whereind = " pec.industry=" .$industry ;
							}
							if ($dealtypeId!= "--")
							{
								$wheredealtype = " pe.MADealTypeId =" .$dealtypeId;
							}
                                                        if($target_comptype!="--")
                                                                 $wheretargetcomptype= " pe.target_listing_status='$target_comptype'";
                                                        if($acquirer_comptype!="--")
                                                                 $whereacquirercomptype= " pe.acquirer_listing_status='$acquirer_comptype'";
                                                         if($targetProjectTypeId==1)
							       $whereSPVCompanies=" pe.Asset=0";
						        elseif($targetProjectTypeId==2)
                                                               $whereSPVCompanies=" pe.Asset=1";
							$acrossDealsDisplay="";
							if(($startRangeValue != "--") && ($endRangeValue != ""))
							{

								if($startRangeValue == $endRangeValue)
								{
								//	echo "<br>**********";
									$whererange = " pe.Amount = ".$startRangeValue ." and pe.hideamount=0 ";
								}
								elseif($startRangeValue < $endRangeValue)
								{
									$whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ." and pe.hideamount=0";
								}
								elseif($endRangeValue="--")
								{
									$endRangeValue=50000;
									$endRangeValueDisplay=50000;
									$whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ." and pe.hideamount=0";
								}

								$acrossDealsDisplay=1;
							}
							if($targetCountryId !="--")
							{
								$wheretargetCountry=" pec.countryId='" .$targetCountryId. "' ";
							}
							if($acquirerCountryId!="--")
							{
								$whereacquirerCountry=" ac.countryId='" .$acquirerCountryId. "' and c.countryid=ac.countryid";
							}

							if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
							{
								$wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
							}

							if ($whereind != "")
							{
								$companysql=$companysql . $whereind ." and ";
								$bool=true;
							}
							if (($wheredealtype != ""))
							{
								$companysql=$companysql . $wheredealtype . " and " ;
								$bool=true;
							}
							if($wheretargetcomptype!="")
                                                                $companysql=$companysql .$wheretargetcomptype . " and ";

                                                        if($whereacquirercomptype!="")
                                                                $companysql=$companysql .$whereacquirercomptype . " and ";
							if (($whereSPVCompanies != "") )
						        {
							        $companysql=$companysql .$whereSPVCompanies . " and ";
								$bool=true;
					        	}
							if (($whererange != "") )
							{
								$companysql=$companysql .$whererange . " and ";
								$bool=true;
							}
							if($wheretargetCountry!="")
							{
								$companysql=$companysql .$wheretargetCountry . " and ";
							}
							if(($wheredates !== "") )
							{
								$companysql = $companysql . $wheredates ." and ";
								$bool=true;
							}
							$companysqlFinal = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
							and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId
							and pec.industry != 15 and pe.Deleted=0  order by companyname ";
							if($whereacquirerCountry!="")
							{

								$companysql=$companysql .$whereacquirerCountry . " and ";
								$companysqlFinal = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
								and  ac.AcquirerId = pe.AcquirerId
								and pec.industry != 15 and pe.Deleted=0  order by companyname ";
							}


							$fetchRecords=true;
							$fetchAggregate==false;
							//echo "<br><br>WHERE CLAUSE SQL---" .$companysqlFinal;
						}
						else
						{
							//echo "<br> INVALID DATES GIVEN ";
							$fetchRecords=false;
							$fetchAggregate==false;
						}
//echo "<br>--".$companysqlFinal;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="language" content="en-us" />
<title>Venture Intelligence - Private Equity, Venture Capital and M&A deals in India</title>

<script type="text/javascript">
</script>

<style type="text/css">

</style>
<link href="../css/style_root.css" rel="stylesheet" type="text/css">
</head>
<body onbeforeunload="HandleOnClose(event)">

<form name="mergacqview"  method="post" action="exportmeracq.php">
<div id="containerproductpeview">
<!-- Starting Left Panel -->
  <?php include_once('leftpanel.php'); ?>
<!--  <div id="leftpanel">
    <div><a href="<?php echo GLOBAL_BASE_URL; ?>index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgpropeview">
    	<div id="vertMenu">
        	<div>Welcome ! &nbsp;&nbsp;<?php echo $MAUserNames; ?> <br/ ><br /></div>
						<div><a href="changepassword.php?value=M">Change your Password </a> <br /><br /></div>
						<div><a href="madealsearch.php">Database Home</a> <br /><br /></div>
			<div><a href="../logoff.php?value=<?php echo $logvar;?>">Logout </a> <br /><br /></div>
      	</div>
    </div>
   </div>-->
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
<!--     <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
    <SCRIPT>
     call()
     </script>-->
  	<div style="width:565px; float:left; padding-left:2px;">
  	  <div style="background-color:#FFF; width:565px; height:445px; margin-top:0px;">
  	    <div id="maintextpro">
        <div id="headingtextpro">
        	<input type="hidden" name="txtsearchon" value="4" >

			<input type="hidden" name="txthidename" value=<?php echo $MAUserNames; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $MAUserEmail; ?> >
			<input type="hidden" name="txthideindustry" value=<?php echo $industry; ?> >
			<input type="hidden" name="txthideindustryvalue" value=<?php echo $industryvalue; ?> >
			<input type="hidden" name="txthidetargetcomptype" value=<?php echo $target_comptype; ?> >
			<input type="hidden" name="txthideacquirercomptype" value=<?php echo $acquirer_comptype; ?> >
			<input type="hidden" name="txthidedealtype" value=<?php echo $dealtypeId; ?> >
			<input type="hidden" name="txthidedealtypevalue" value=<?php echo $dealtypevalue; ?> >
			<input type="hidden" name="txthideSPV" value=<?php echo $targetProjectTypeId; ?> >

			<input type="hidden" name="txthiderange" value=<?php echo $rangeText; ?> >
			<input type="hidden" name="txthiderangeStartValue" value=<?php echo $startRangeValue; ?> >
			<input type="hidden" name="txthiderangeEndValue" value=<?php echo $endRangeValue; ?> >
			<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

			<input type="hidden" name="txthidecompany" value=<?php echo $stringToHide; ?> >
			<input type="hidden" name="txthideadvisor_legal" value=<?php echo $advisorsearchhidden_legal; ?> >
			<input type="hidden" name="txthideadvisor_trans" value=<?php echo $advisorsearchhidden_trans; ?> >
			<input type="hidden" name="txthideacquirer" value=<?php echo $stringToHideAcquirer; ?> >
			<input type="hidden" name="txttargetcountry" value=<?php echo $targetCountryId; ?>>
			<input type="hidden" name="txtacquirercountry" value=<?php echo $acquirerCountryId; ?>>
			<input type="hidden" name="txthidesearchallfield" value=<?php echo $searchallfieldhidden; ?> >


<?php
								$exportToExcel=0;
								$TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc ,malogin_members as dm
								where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
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
								$totalDisplay="Total";
						    	$industryAdded ="";
						    	$totalAmount=0.0;
						    	$totalInv=0;
								$compDisplayOboldTag="";
								$compDisplayEboldTag="";
						 	// echo "<br> query final-----" .$companysql;
						 	      /* Select queries return a resultset */
								 if ($companyrs = mysql_query($companysqlFinal))
								 {
								    $company_cnt = mysql_num_rows($companyrs);
								 }

						           if($company_cnt > 0)
						           {
						           		//$searchTitle=" List of PE Exits - M & A";
						           }
						           else
						           {
						              	$searchTitle= " No Deals(s) found for this search ";
						              	$notable=true;
						           }

				           ?>
			<div id="headingtextproboldfontcolor">
			    <?php


                                  	echo $queryDisplayTitle;

				if($industry >0 )
					echo "&nbsp;" .$industryvalue;
				if($dealtypeId!="--")
				 	echo "&nbsp;&nbsp;&nbsp;> ".$dealtypevalue;
			 	if(($target_comptype=="L" ) || ($target_comptype=="U"))
                                        echo "&nbsp;&nbsp;&nbsp;> ".$target_comptype_display;
                                if($acquirer_comptype!="--")
                                        echo "&nbsp;&nbsp;&nbsp;> ".$acquirer_comptype_display;
                                if(($targetProjectTypeId!="--") && ($targetProjectTypeId!=""))
                                        echo "&nbsp;&nbsp;&nbsp;#> ".$projecttypename;
				if(($startRangeValue != "--") && ($endRangeValue != ""))
	           		echo "&nbsp;&nbsp;&nbsp;>(USM) " .$startRangeValue ."-" .$endRangeValueDisplay;
	           	if($targetCountryId !="--")
					echo "&nbsp;&nbsp;&nbsp;>(T) ".$targetcountryvalue;
				if($acquirerCountryId!="--")
					echo "&nbsp;&nbsp;&nbsp;>(A) ".$acquirercountryvalue;
	           	if($datevalueDisplay1!="")
	           		echo "&nbsp;&nbsp;&nbsp;> ".$datevalueDisplay1. "-" .$datevalueDisplay2;
	           	if($acquirersearch!="")
	           		echo "&nbsp;&nbsp;&nbsp;> ".$acquirersearch;
	           	if($targetcompanysearch!="")
	           		echo "&nbsp;&nbsp;&nbsp;> ".$targetcompanysearch;
				if($advisorsearch!="")
					echo "&nbsp;&nbsp;&nbsp;> ".$advisorsearch;
				if($searchallfield!="")
							echo "&nbsp;&nbsp;&nbsp;> ".$searchallfield;

				?>

			 <br /><br /></div>
						<div id="headingtextproboldfontcolor"> <?php echo $searchTitle; ?> <br />  </div>								<div id="headingtextprosmallfont">Note: Target in () indicates sale of asset rather than the company. </div>
								<!--<div id="tableContainer" class="tableContainer"> -->
							<div style="width: 510px; height: 305px; overflow: scroll;">


										<table border="1" cellpadding="3" cellspacing="0" width="100%"  >
									<!--	<thead class="fixedHeader"> -->
											<tr>
												<th width=23%>Target  &nbsp;&nbsp;
												<th width=15%>Acquirer</th>
												<th width=5%>Amount (US$M)</th>
												<th width=8%>Deal Info </th>
											</tr>

									<!--	</thead>  -->
								<?php
								if ($company_cnt>0)
								{


									$acrossDealsCnt=0;
								   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
									{
										$searchString4="PE Firm(s)";
										$searchString4=strtolower($searchString4);
										$searchString4ForDisplay="PE Firm(s)";

										$searchString="Undisclosed";
										$searchString=strtolower($searchString);

										$searchString3="Individual";
										$searchString3=strtolower($searchString3);

										$companyName=trim($myrow["companyname"]);
										$companyName=strtolower($companyName);
										$compResult=substr_count($companyName,$searchString);
										$compResult4=substr_count($companyName,$searchString4);

										$acquirerName=$myrow["Acquirer"];
										$acquirerName=strtolower($acquirerName);

										$compResultAcquirer=substr_count($acquirerName,$searchString4);
										$compResultAcquirerUndisclosed=substr_count($acquirerName,$searchString);
										$compResultAcquirerIndividual=substr_count($acquirerName,$searchString3);

										if($compResult==0)
											$displaycomp=$myrow["companyname"];
										elseif($compResult4==1)
											$displaycomp=ucfirst("$searchString4");
										elseif($compResult==1)
											$displaycomp=ucfirst("$searchString");

										if(($compResultAcquirer==0) && ($compResultAcquirerUndisclosed==0) && ($compResultAcquirerIndividual==0))
											$displayAcquirer=$myrow["Acquirer"];
										elseif($compResultAcquirer==1)
											$displayAcquirer=ucfirst("$searchString4ForDisplay");
										elseif($compResultAcquirerUndisclosed==1)
											$displayAcquirer=ucfirst("$searchString");
										elseif($compResultAcquirerIndividual==1)
											$displayAcquirer=ucfirst("$searchString3");

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
										if($myrow["Amount"]==0)
										{
											$hideamount="";
											$amountobeAdded=0;
										}
										elseif($myrow["hideamount"]==1)
										{
											$hideamount="";
											$amountobeAdded=0;

										}
										else
										{
											$hideamount=$myrow["Amount"];
											$acrossDealsCnt=$acrossDealsCnt+1;
											$amountobeAdded=$myrow["Amount"];
										}
										if($myrow["AggHide"]==1)
								                {
                									$opensquareBracket="{";
                									$closesquareBracket="}";
                									$amtTobeDeductedforAggHide=$myrow["Amount"];
                									$NoofDealsCntTobeDeducted=1;
								                 }
                								else
                								{
                									$opensquareBracket="";
                									$closesquareBracket="";
                									$amtTobeDeductedforAggHide=0;
                									$NoofDealsCntTobeDeducted=0;
                								}
                								if($myrow["Amount"]==0)
                                                                                {
                                                                                $NoofDealsCntTobeDeducted=1;
                                                                                }
										if(trim($myrow["sector_business"])=="")
											$showindsec=$myrow["industry"];
										else
											$showindsec=$myrow["sector_business"];

							   ?>
											<tr>
											<td >
												<?php echo $openBracket ; ?><?php echo $opensquareBracket ; ?><?php echo $displaycomp; ?><?php echo $closesquareBracket ; ?><?php echo $closeBracket ; ?>&nbsp;</td>

												<td><?php echo $displayAcquirer; ?></td>
												<td align=right><?php echo $hideamount; ?>&nbsp;</td>
												<td>
												<A href="meracqdetail.php?value=<?php echo $myrow["MAMAId"];?>/<?php echo $searchallfield;?>  "
												target="popup" onclick="MyWindow=window.open('meracqdetail.php?value=<?php echo $myrow["MAMAId"];?>/<?php echo $searchallfield;?> ', 'popup', 'location=0,scrollbars=1,width=600,height=500,status=no');MyWindow.focus(top);return false">
		   									   click here
											 	</A>   </td>
											</tr>
										<!--</tbody>-->
									<?php
										$industryAdded = $myrow["industry"];
										$totalInv=$totalInv+1-$NoofDealsCntTobeDeducted;
								              $totalAmount=$totalAmount+ $myrow["Amount"]-$amtTobeDeductedforAggHide;
									}
								}

								?>
							 </table>
							</div>


		<?php
			$totalAmount=round($totalAmount, 0);
			$totalAmount=number_format($totalAmount);
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
				<div id="headingtextproboldbcolor">&nbsp; Announced Value US$ <?php echo $totalAmount; ?>&nbsp;M across  <?php echo $acrossDealsCnt; ?> &nbsp;deals;
					   Total No. of Deals = <?php echo $totalInv; ?> <br /></div>
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
							if($totalInv>0 && $exportToExcel==1)
							{
						?>
								<span style="float:left" class="one">
									To Export the above deals into a Spreadsheet,&nbsp;<input type="submit"  value="Click Here" name="showmandadeals">
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
							<a target="_blank" href="../Sample_merger_acq_data.xls"><u>Click Here</u> </a> for a sample spreadsheet containing M&A deals
							</span>

							<?php

					}
			} //end of student if
						?>

		</div>

        </div> <!-- end of maintext pro-->
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
 }
 else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;


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