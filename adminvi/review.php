<?php include_once("../globalconfig.php"); ?>
<?php
			 require("../dbconnectvi.php");
			 $Db = new dbInvestments();
 	session_save_path("/tmp");
	session_start();
	if (isset($_SESSION['RELAST_ACTIVITY']) && (time() - $_SESSION['RELAST_ACTIVITY'] > 900))
{
    // last request was more than 10 minates ago
   // echo "<br>___";
    session_destroy();   // destroy session data in storage
    session_unset();     // unset $_SESSION variable for the runtime
    echo "<br>Your session has expired...";
?>
   <table border=0 align=center cellpadding=0 cellspacing=0 width=95%
	style="font-family: Arial; font-size:10pt; 
	 border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
    <tr><td><A href="../relogin.php" target="_blank">Click here </a>to login again </td></tr>
    </table>

<?php

}
$_SESSION['RELAST_ACTIVITY'] = time(); // update last activity time stamp

			$sesID=session_id();
			$username=$_SESSION['REUserNames'];
			$emailid=$_SESSION['REUserEmail'];

                        $ipadd=$_SESSION['REIP'];
                        if($ipadd=="RIP")
                          $logvar="RIP";
                        else
                          $logvar="R";
	 if ((session_is_registered("REUserNames")))
	{
    				//echo "<br>peview session id--" .$sesID;


				$searchString="Undisclosed";
			 	$searchString=strtolower($searchString);

			 	$searchString1="Unknown";
				$searchString1=strtolower($searchString1);

			 	$buttonClicked=$_POST['hiddenbutton'];
				$fetchRecords=true;
				$totalDisplay="";
				$keyword=$_POST['keywordsearch'];

				$keywordhidden=$_POST['keywordsearch'];
				//echo "<Br>--" .$keywordhidden;
				$keywordhidden =ereg_replace(" ","-",$keywordhidden);

				//echo "<br>--" .$keywordhidden;

				$companysearch=$_POST['companysearch'];
				//$companysearchhidden=ereg_replace(" ","-",$companysearch);

				$advisorsearchstring_legal=$_POST['advisorsearch_legal'];
				$advisorsearchhidden_legal=ereg_replace(" ","-",$advisorsearchstring_legal);
				$advisorsearchstring_trans=$_POST['advisorsearch_trans'];
				$advisorsearchhidden_trans=ereg_replace(" ","-",$advisorsearchstring_trans);

				if($advisorsearchstring_legal!=="")
				{
					$splitStringAcquirer=explode(" ", $advisorsearchstring_legal);
					$splitString1Acquirer=$splitStringAcquirer[0];
					$splitString2Acquirer=$splitStringAcquirer[1];
					$stringToHideAcquirer_legal=$splitString1Acquirer. "+" .$splitString2Acquirer;
				}

			//	echo "<br>Key word ---" .$keyword;
				$industry=$_POST['industry'];
				$companyType=$_POST['comptype'];
				//echo "<Br>---------------" .$industry;
				$stage=$_POST['stage'];
				//echo "<br>STAGE- " .$stage;
				$regionId=$_POST['txtregion'];

				$entityProject=$_POST['EntityProjectType'];
				$investorType=$_POST['invType'];
				//$range=$_POST['invrange'];
				$startRangeValue=$_POST['invrangestart'];
				$endRangeValue=$_POST['invrangeend'];
				$endRangeValueDisplay=$endRangeValue;
				//echo "<br>Stge**" .$range;
				$whereind="";
				$whereregion="";
				$whereinvType="";
				$wherestage="";
				$whereSPVcompanies="";
				$wheredates="";
				$whererange="";
				$month1=$_POST['month1'];
				$year1 = $_POST['year1'];
				$month2=$_POST['month2'];
				$year2 = $_POST['year2'];

				$notable=false;
				$vcflagValue=$_POST['txtvcFlagValue'];
				$vcflagValue=2;

				//echo "<br>FLAG VALIE--" .$vcflagValue;
$datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
$splityear1=(substr($year1,2));
$splityear2=(substr($year2,2));

if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
{	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
	$datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
	$wheredates1= "";
}

$whereaddHideamount="";

		if($industry >0)
		{
			$industrysql= "select industry from reindustry where IndustryId=$industry";
			if ($industryrs = mysql_query($industrysql))
			{
				While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
				{
					$industryvalue=$myrow["industry"];
				}
			}
		}

		if($stage >0)
		{
			$stagesql= "select REType from realestatetypes where RETypeId=$stage";

			if ($stagers = mysql_query($stagesql))
			{
				While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
				{
					$stagevalue=$myrow["REType"];
				}
			}
		}
		
		if($regionId >0)
				{
					$regionsql= "select Region from region where RegionId=$regionId";
					if ($regionrs = mysql_query($regionsql))
					{
						While($myrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
						{
							$regionvalue=$myrow["Region"];
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

		if($entityProject==1)
		    $entityProjectvalue="Entity";
		elseif($entityProject==2)
		    $entityProjectvalue="Project";

                if($companyType=="L")
		        $companyTypeDisplay="Listed";
		elseif($companyType=="U")
                        $companyTypeDisplay="UnListed";
 	        elseif($companyType=="--")
                        $companyTypeDisplay="";

		$invtypesql = "select InvestorType,InvestorTypeName from investortype where Hide=0";



				if($vcflagValue==0)
				{
					//$addVCFlagqry = " and pec.industry !=15 ";
					$addVCFlagqry = "";
					$checkForStage = ' && ('.'$stage'.' =="--")';
					//$checkForStage = " && (" .'$stage'."=='--') ";
					$checkForStageValue = " || (" .'$stage'.">0) ";
					$searchTitle = "List of PE Investments ";
					$searchAggTitle = "Aggregate Data - PE Investments ";
					$aggsql= "select count(PEId) as totaldeals,sum(amount) as totalamount from peinvestments as pe,
					recompanies as pec,industry as i where ";
				}
				elseif($vcflagValue==1)
				{
					//$addVCFlagqry = " and pec.industry!=15  and s.VCview=1 and pe.amount <=20 ";
					$addVCFlagqry = " and s.VCview=1 and pe.amount <=20 ";

					$checkForStage = '&& ('.'$stage'.'=="--") ';
					//$checkForStage = " && (" .'$stage'."=='--') ";
					$checkForStageValue =  " || (" .'$stage'.">0) ";
					$searchTitle = "List of VC Investments ";
					$searchAggTitle = "Aggregate Data - VC Investments ";
					$aggsql= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
					FROM REinvestments AS pe,REcompanies as pec,industry as i,stage as s  where pe.StageID=s.StageId and s.VCView=1 and  " ;
				//	echo "<br>Check for stage** - " .$checkForStage;
				}
				elseif($vcflagValue==2)
				{
					//$addVCFlagqry = " and pec.industry =15 ";
					$checkForStage = "";
					$checkForStageValue = "";
					$searchTitle = "List of PE Investments - Real Estate";
					$searchAggTitle = "Aggregate Data - PE Investments - Real Estate";
					$aggsql= " SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
					FROM REinvestments AS pe, REcompanies AS pec,industry as i where	";
				}


			if (($keyword == "") && ($companysearch=="") && ($advisorsearchstring_legal=="") && ($advisorsearchstring_trans=="") && ($entityProject=="--") && ($industry <= 0) && ($companyType=="--") && ($regionId =="--") && ($invType == "--") && ($startRangeValue == "--") && ($endRangeValue == "--") && ($month1 == "--")  && ($year1 == "--") && ($month2 == "--") && ($year2 == "--") && ($stage=="--"))
			{
			    $yourquery=0;
				 $companysql = "SELECT pe.PECompanyId, pec.companyname, pe.IndustryId, i.industry, pe.sector,
				 amount, round, s.REType,  stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) , pec.website, pec.city,
				PEId,comment,MoreInfor,hideamount,hidestake,pe.StageId,SPV,pe.city as dealcity ,AggHide
						 FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s
						 WHERE pe.IndustryId = i.industryid
						 AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
						 and pe.Deleted=0" .$addVCFlagqry. " order by companyname";
				//     echo "<br>all records" .$companysql;
			}
			elseif ($companysearch != "")
			{
			    $yourquery=1;
			    $datevalueDisplay1="";
				$companysql="SELECT pe.PECompanyId, pec.companyname, pe.IndustryId, i.industry, pe.sector,
				pe.amount, pe.round, s.REType,  pe.stakepercentage, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod,
				website, pec.city, PEId,
				COMMENT,MoreInfor,hideamount,hidestake,pe.StageId,SPV,pe.city as dealcity,AggHide
				FROM REinvestments AS pe, reindustry AS i,
				REcompanies AS pec,realestatetypes as s
				WHERE pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
				AND pe.Deleted =0 " .$addVCFlagqry. " AND ( pec.companyname LIKE '%$companysearch%'
				OR sector_business LIKE '%$companysearch%')
				order by companyname";
			//	echo "<br>Query for company search";
			// echo "<br> Company search--" .$companysql;
			}
			elseif($keyword!="")
			{
			    $yourquery=1;
			    $datevalueDisplay1="";
				$companysql="select pe.PECompanyId,pec.companyname,pe.IndustryId,i.industry,pe.sector,pe.amount,
				peinv_inv.InvestorId,peinv_inv.PEId,inv.Investor,pe.PECompanyId,pec.industry,
				pec.companyname,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,i.industry,hideamount,SPV,s.REType,pe.city as dealcity,AggHide
			from REinvestments_investors as peinv_inv,REinvestors as inv,
			REinvestments as pe,REcompanies as pec,reindustry as i,realestatetypes as s
			where inv.InvestorId=peinv_inv.InvestorId and pe.IndustryId = i.industryid and  pe.StageId=s.RETypeId and pe.Deleted=0
			and pe.PEId=peinv_inv.PEId and pec.PECompanyId=pe.PECompanyId " .$addVCFlagqry." AND inv.investor like '$keyword%' order by companyname";


			//	echo "<br> Investor search- ".$companysql;
			}
			elseif($advisorsearchstring_legal!="")
			{
			    $yourquery=1;
			    $datevalueDisplay1="";
			$companysql="(
				SELECT peinv.PEId,peinv.PECompanyId, c.companyname, i.industry, peinv.sector, peinv.amount, cia.CIAId, cia.Cianame, 
                                adac.CIAId AS AcqCIAId,SPV,peinv.city as dealcity,AggHide ,DATE_FORMAT( dates, '%b-%Y' ) as dealperiod
				FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
				WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='L'
				AND cia.cianame LIKE '$advisorsearchstring_legal%'
				)
				UNION (
				SELECT peinv.PEId,peinv.PECompanyId, c.companyname, i.industry, peinv.sector, peinv.amount, cia.CIAId, cia.Cianame,
                                 adac.CIAId AS AcqCIAId,SPV,peinv.city as dealcity,AggHide,DATE_FORMAT( dates, '%b-%Y' ) as dealperiod
				FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
				WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid	AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='L'
				AND cia.cianame LIKE '$advisorsearchstring_legal%'
				)";
		//	echo "<Br>ADvisor search--" . $companysql;
			}
			elseif($advisorsearchstring_trans!="")
			{
			    $yourquery=1;
			    $datevalueDisplay1="";
			$companysql="(
				SELECT peinv.PEId,peinv.PECompanyId, c.companyname, i.industry, peinv.sector, peinv.amount, cia.CIAId, cia.Cianame, 
                                adac.CIAId AS AcqCIAId,SPV,peinv.city as dealcity,AggHide ,DATE_FORMAT( dates, '%b-%Y' ) as dealperiod
				FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
				WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='T'
				AND cia.cianame LIKE '$advisorsearchstring_trans%'
				)
				UNION (
				SELECT peinv.PEId,peinv.PECompanyId, c.companyname, i.industry, peinv.sector, peinv.amount, cia.CIAId, cia.Cianame, 
                                adac.CIAId AS AcqCIAId,SPV,peinv.city as dealcity,AggHide ,DATE_FORMAT( dates, '%b-%Y' ) as dealperiod
				FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
				WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid	AND c.PECompanyId = peinv.PECompanyId
				AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='T'
				AND cia.cianame LIKE '$advisorsearchstring_trans%'
				)";
			//	echo "<Br>Trans search--" . $companysql;
		       }
			elseif (($industry > 0) || ($invType != "--") || ($companyType!="--") || ($regionId> 0) ||  ($entityProject!="--") || ($startRangeValue == "--") || ($endRangeValue == "--") || (($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--")) .$checkForStageValue)
				{
				    $yourquery=1;

					$dt1 = $year1."-".$month1."-01";
					//echo "<BR>DATE1---" .$dt1;
					$dt2 = $year2."-".$month2."-01";
					$companysql = "select pe.PECompanyID,pec.companyname,pe.IndustryId,i.industry,
					pe.sector,amount,round,s.REType,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod,
					pec.website,pec.city,pec.region,PEId,comment,MoreInfor,hideamount,hidestake,pe.StageId,SPV,pe.city as dealcity,AggHide
					from REinvestments as pe, reindustry as i,REcompanies as pec,realestatetypes as s,region as r where";
				//	echo "<br> individual where clauses have to be merged ";
					if ($industry > 0)
						{
							$whereind = " pe.IndustryId=" .$industry ;
							$qryIndTitle="Industry - ";
						}
			//	echo "<br> WHERE IND--" .$whereind;
						if ($regionId > 0 )
							{
								$qryRegionTitle="Region - ";
								$whereregion = " pe.RegionId= $regionId ";
							}
					//	echo " <bR> where REGION--- " .$whereregion;
                                                if($companyType!="--")
					        {
                                                  $wherelisting_status=" pe.listing_status='".$companyType."'";
                                                  }
						if (($invType!= "--") && ($invType!=""))
						{
							$qryInvType="Investor Type - " ;
							$whereInvType = " pe.InvestorType = '".$investorType."'";
						}
						if (($stage!= "--")  && ($stage!=""))
						{
							$wherestage = " pe.StageId =" .$stage ;
							$qryDealTypeTitle="Stage  - ";
						}
						if($entityProject==1)
							$whereSPVCompanies=" pe.SPV=0";
						elseif($entityProject==2)
							$whereSPVCompanies=" pe.SPV=1";


					//	echo "<br>Where stge---" .$wherestage;
						if (($startRangeValue!= "--") && ($endRangeValue != ""))
						{
							$startRangeValue=$startRangeValue;
							$endRangeValue=$endRangeValue-0.01;
							$qryRangeTitle="Deal Range (M$) - ";
							if($startRangeValue < $endRangeValue)
							{
								$whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ." and AggHide=0";
							}
							elseif($startRangeValue = $endRangeValue)
							{
								$whererange = " pe.amount >= ".$startRangeValue ." and AggHide=0";
							}
						}
						/*if ($range!= "--")
						{
							$qryRangeTitle="Deal Range (M$) - ";
							if($startRangeValue < $endRangeValue)
							{
								$whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
							}
							elseif($startRangeValue = $endRangeValue)
							{
								$whererange = " pe.amount >= ".$startRangeValue ."";
							}
						}*/
						if(($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
						{
							$qryDateTitle ="Period - ";
							$wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";

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
					if($whereregion!="")
					{
						$companysql=$companysql .$whereregion . " and ";
					}

					if (($wherestage != ""))
						{
							$companysql=$companysql . $wherestage . " and " ;
							$aggsql=$aggsql . $wherestage ." and ";
							$bool=true;
						}

					if (($whereInvType != "") )
						{
							$companysql=$companysql .$whereInvType . " and ";
							$aggsql = $aggsql . $whereInvType ." and ";
							$bool=true;
						}
					if (($whereSPVCompanies != "") )
						{
							$companysql=$companysql .$whereSPVCompanies . " and ";
							$aggsql = $aggsql . $whereSPVCompanies ." and ";
							$bool=true;
						}
					if($wherelisting_status!="")
                                        	{
                                                 $companysql=$companysql .$wherelisting_status . " and ";
                                                }
					if (($whererange != "") )
						{
							$companysql=$companysql .$whererange . " and ";
							$aggsql=$aggsql .$whererange . " and ";
							$bool=true;
						}
					if(($wheredates !== "") )
					{
						$companysql = $companysql . $wheredates ." and ";
						$aggsql = $aggsql . $wheredates ." and ";
						$bool=true;
					}

					//the foll if was previously checked for range
					if($whererange  !="")
					{
						$companysql = $companysql . " pe.hideamount=0 and  i.industryid=pe.IndustryId and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId and r.RegionId=pe.RegionId and
						pe.Deleted=0 " . $addVCFlagqry . " order by companyname ";
					//	echo "<br>----" .$whererange;
					}
					elseif($whererange="--")
					{
						$companysql = $companysql . "  i.industryid=pe.IndustryId and
						pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId and r.RegionId=pe.RegionId and
						pe.Deleted=0 " .$addVCFlagqry. " order by companyname ";
				//		echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
					}
                                    //echo "<br>^^^".$companysql;
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
<title>Venture Intelligence - Private Equity, Venture Capital and M&A deals in India</title>

<script type="text/javascript">
var a_menu_items = new Array(1, 1, 1, 1);
function changeimage(number)
{
	if (document.images && g_bPreloadFlag)
	{
		imgName = 'menu' + number;
		// loop through the menu items array
		for ( i = 1; i < (a_menu_items.length + 1); i++ )
		{
			if ( number == i )
			{
				//pick the opposite state currently in the value
				state = ( a_menu_items[i] == 0 )? 1 : 0;
				// after assigning, switch the value to its opposite
				( a_menu_items[i] == 0 )? a_menu_items[i] = 1 : a_menu_items[i] = 0;
				break;
			}
		}
		document.images[imgName].src = g_aMenu[0][state].src;
	}
}

var g_bPreloadFlag = false;
var g_aMenu = new Array();

function preloadimages()
{
	if (document.images)
	{
		var aOffon = new Array(1);
		g_aMenu[0] = aOffon;
		g_aMenu[0][0] = new Image();
		g_aMenu[0][0].src = 'sortimage.gif';
		g_aMenu[0][1] = new Image();
		g_aMenu[0][1].src = 'sortimageasc.gif';
		g_bPreloadFlag = true;
	}
}

function movepic(img_src) {
document.img1.src=img_src;
}
</script>

<style type="text/css">


</style>
<link href="../css/style_root.css" rel="stylesheet" type="text/css">

</head>
<BODY oncontextmenu="return false;"  >
<!--ondragstart="return false" onselectstart="return false"-->
<!--<body onUnload="../logoff.php">-->
<!-- body onload="preloadimages()"-->
<form name="pelisting"  method="post" action="exportreinvdeals.php">
<div id="containerproductpeview">
<!-- Starting Left Panel -->
  <?php include_once('leftpanel.php'); ?>
<!--  <div id="leftpanel">
    <div><a href="../index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgpropeview">
    	<div id="vertMenu">
        	<div>Welcome &nbsp;&nbsp;<?php echo  $username; ?> <br/ ><br /></div>

					<div><a href="../deals/changepassword.php?value=R">Change your Password </a> <br /><br /></div>
					<div><a href="rehome.php">Database Home</a> <br /><br /></div>

			<div><a href="../logoff.php?value=<?php echo $logvar;?>">Logout </a> <br /><br /></div>
      	</div>


    </div>
   </div>-->
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
  <!-- <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>-->
	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; height:445px; margin-top:0px;">
	    <div id="maintextpro">
        <div id="headingtextpro">
           	<input type="hidden" name="txtsearchon" value="1" >
           	<input type="hidden" name="txttitle" value=<?php echo $vcflagValue; ?> >
        	<input type="hidden" name="txthidename" value=<?php echo $username; ?> >
			<input type="hidden" name="txthideemail" value=<?php echo $emailid; ?> >
			<input type="hidden" name="txthideindustry" value=<?php echo $industryvalue; ?> >
			<input type="hidden" name="txthideindustryid" value=<?php echo $industry; ?> >
			<input type="hidden" name="txthidestage" value=<?php echo $stagevalue; ?> >
			<input type="hidden" name="txthideSPVCompany" value=<?php echo $entityProject; ?> >
			<input type="hidden" name="txthideSPVCompanyValue" value=<?php echo $entityProjectvalue; ?> >
			<input type="hidden" name="txthidestageid" value=<?php echo $stage; ?> >
			<input type="hidden" name="txthideinvtype" value=<?php echo $invtypevalue; ?> >
			<input type="hidden" name="txthideinvtypeid" value=<?php echo $investorType; ?> >
			<input type="hidden" name="txthidecomptype" value=<?php echo $companyType; ?> >

			<input type="hidden" name="txthiderange" value=<?php echo $startRangeValue; ?>-<?php echo $endRangeValueDisplay; ?> >
			<input type="hidden" name="txthiderangeStartValue" value=<?php echo $startRangeValue; ?>>
			<input type="hidden" name="txthiderangeEndValue" value=<?php echo $endRangeValue; ?> >
			<input type="hidden" name="txthideregionId" value=<?php echo $regionId; ?> >
			<input type="hidden" name="txthideregionvalue" value=<?php echo $regionvalue; ?> >


			<input type="hidden" name="txthidedate" value=<?php echo $datevalue; ?> >
			<input type="hidden" name="txthidedateStartValue" value=<?php echo $dt1; ?> >
			<input type="hidden" name="txthidedateEndValue" value=<?php echo $dt2; ?> >

			<input type="hidden" name="txthideinvestor" value=<?php echo $keywordhidden; ?> >
			<input type="hidden" name="txthidecompany" value=<?php echo $companysearch; ?> >            
	                <input type="hidden" name="txthideadvisor_legal" value=<?php echo $advisorsearchhidden_legal; ?> >
			<input type="hidden" name="txthideadvisor_trans" value=<?php echo $advisorsearchhidden_trans; ?> >

			<input type="hidden" name="txthideadvisorstring_legal" value=<?php echo $stringToHideAcquirer_legal; ?> >

<!--<TEXTAREA NAME="comments" COLS=40 ROWS=6></TEXTAREA>-->
		<!--	<input type="hidden" name="txtquery" size=300 value=<?php echo $companysql; ?> >-->

		<?php

				$exportToExcel=0;
			 $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,RElogin_members as dm
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
					if(trim($buttonClicked==""))
					{
						$totalDisplay="Total";
				    	$industryAdded ="";
				    	$totalAmount=0.0;
				    	$totalInv=0;
						$compDisplayOboldTag="";
						$compDisplayEboldTag="";
				 	//echo "<br> query final-----" .$companysql;
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
				if (($stage!= "--")  && ($stage!=""))
				 	echo "&nbsp;&nbsp;&nbsp;> ".$stagevalue;
				if($companyType!="--")
                                        echo "&nbsp;&nbsp;&nbsp;> ".$companyTypeDisplay;
                                if($investorType !="--")
					echo "&nbsp;&nbsp;&nbsp;> ".$invtypevalue;
				if($regionId>0)
					echo "&nbsp;&nbsp;&nbsp;> ".$regionvalue;
				if (($entityProject!= "--")  && ($stage!="") && ($entityProject>0))
					echo "&nbsp;&nbsp;&nbsp;> ".$entityProjectvalue;
				if (($startRangeValue!= "--") && ($endRangeValue != ""))
	           		echo "&nbsp;&nbsp;&nbsp;>(USM) " .$startRangeValue ."-" .$endRangeValueDisplay;
	           	if($datevalueDisplay1!="")
	           		echo "&nbsp;&nbsp;&nbsp;> ".$datevalueDisplay1. "-" .$datevalueDisplay2;
	           	if($keyword!="")
	           		echo "&nbsp;&nbsp;&nbsp;> ".$keyword;
	           	if($companysearch!="")
	           		echo "&nbsp;&nbsp;&nbsp;> ".$companysearch;
			if($advisorsearchstring_legal!="")
					echo "&nbsp;&nbsp;&nbsp;> ".$advisorsearchstring_legal;
                        if($advisorsearchstring_trans!="")
					echo "&nbsp;&nbsp;&nbsp;> ".$advisorsearchstring_trans;
				//if($searchallfield!="")
				//	echo "&nbsp;&nbsp;&nbsp;> ".$searchallfield;
				?>

			 <br /><br /></div>
			<div id="headingtextproboldfontcolor"> <?php echo $searchTitle; ?> <br />   </div>
			<div id="headingtextprosmallfont">Note: Target in () indicates sale of SPV/ Project rather than the company.<br />  </div>
			<div id="headingtextprosmallfont">Target in { } indicates a minority stake acquisition. Such deals will not be counted for the aggregate data displayed. </div>
					<?php
					if($notable==false)
					{
					?>
						<!--<div id="tableContainer" class="tableContainer"> -->
					<div style="width: 535px; height: 300px; overflow: scroll;">


								<table border="1" cellpadding="3" cellspacing="0" width="100%"  >
							<!--	<thead class="fixedHeader"> -->
									<tr>
										<th width=12%>Company &nbsp;&nbsp;
										<!--<img name="img1" border="0" src="sortimage.gif" width="17" height="12" onclick="movepic('sortimageasc.gif')" ;> -->
									<!--	<a href="#" onclick="changeimage(1)">
										<img src="sortimage.gif" name="menu1"></a><br> -->


										</th>
										<th width=10%>City</th>
                                                                                 <th width=5%>Date</th>
										<th width=7%>Amount (US$M)</th>
										<th width=8%>Deal Info </th>
									</tr>

							<!--	</thead>  -->
						<?php
						if ($company_cnt>0)
						  {
						  	$hidecount=0;
						  	$acrossDealsCnt=0;
						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
                                                                $amtTobeDeductedforAggHide=0;
                                                                $prd=$myrow["dealperiod"];

								if($myrow["AggHide"]==1)
								{
                                                                        $openaggBracket="{";
									$closeaggBracket="}";
									$amtTobeDeductedforAggHide=$myrow["amount"];
									$NoofDealsCntTobeDeducted=1;
								}
								else
								{
                                                                       $openaggBracket="";
									$closeaggBracket="";
									$amtTobeDeductedforAggHide=0;
									$NoofDealsCntTobeDeducted=0;
								}

								if($myrow["SPV"]==1)
								{
									$openBracket="(";
									$closeBracket=")";
								}
								else
								{
									$openBracket="";
									$closeBracket="";
								}

								if(trim($myrow[17])=="")
								{
									$compDisplayOboldTag="";
									$compDisplayEboldTag="";
								}
								else
								{
									$compDisplayOboldTag="<b><i>";
									$compDisplayEboldTag="</b></i>";
								}
								if($myrow["hideamount"]==1)
								{
									$hideamount="--";
									$hidecount=$hidecount+1;
								}
								else
								{
									$hideamount=$myrow["amount"];
								}
								if($myrow["REType"]!="")
								{
									$showindsec=$myrow["REType"];
								}
								else
								{
									$showindsec="&nbsp;";
								}

								$companyName=trim($myrow["companyname"]);
								$companyName=strtolower($companyName);
								$compResult=substr_count($companyName,$searchString);
								$compResult1=substr_count($companyName,$searchString1);

								if($myrow["amount"]==0)
								{
									$hideamount="";
									$amountobeAdded=0;
								}
								if($myrow["hideamount"]==1)
								{
									$hideamount="";
									$amountobeAdded=0;

								}
								elseif($myrow["hideamount"]==0)
								{
									$hideamount=$myrow["amount"];
                                                                        $acrossDealsCnt=$acrossDealsCnt+1;
									$amountobeAdded=$myrow["amount"];
								}

					   ?>
								<!--<tbody class="scrollContent">-->
									<tr>
						<?php
								if(($compResult==0) && ($compResult1==0))
								{
						?>
								<td ><?php echo $openBracket ; ?><?php echo $openaggBracket ; ?> <?php echo trim($myrow["companyname"]);?> <?php echo $closeaggBracket ; ?><?php echo $closeBracket ; ?></td>
						<?php
								}
								else
								{
						?>
								<td width=15% ><?php echo ucfirst("$searchString");?></td>
						<?php
								}
						?>

										<!--<td><?php echo trim($showindsec); ?></td>-->
										<td><?php echo $myrow["dealcity"]; ?></td>
										<td><?php echo $prd; ?></td>
										<td align=right><?php echo $hideamount; ?>&nbsp;</td>
										<td>
						<?php

						if($vcflagValue==2)
						{
						?>
								<A href="redealinfo.php?value=<?php echo $myrow["PEId"];?> "
								target="popup" onclick="MyWindow=window.open('redealinfo.php?value=<?php echo $myrow["PEId"];?>', 'popup', 'scrollbars=1,width=500,height=400,status=no');MyWindow.focus(top);return false">
								click here

						<?php
						}
						?>
								 	</A>   </td>
									</tr>
								<!--</tbody>-->
							<?php
								$industryAdded = $myrow[2];
								$totalInv=$totalInv+1-$NoofDealsCntTobeDeducted;

								//$totalAmount=$totalAmount+ $myrow["amount"];
								$totalAmount=$totalAmount+ $amountobeAdded - $amtTobeDeductedforAggHide;;


							}
						}
						?>
					 </table>
					</div>
			<?php
			}

			$totalAmount=round($totalAmount, 0);
			$totalAmount=number_format($totalAmount);
			//	if($hidecount==1)
			//	{
			//		$totalAmount="--";
			//	}
		if($studentOption==1)
		{
		?>

		<div id="headingtextproboldbcolor">&nbsp; Announced Value US$ <?php echo $totalAmount; ?>&nbsp;M across  <?php echo $acrossDealsCnt; ?> &nbsp;deals;
					   Total No. of Deals = <?php echo $totalInv; ?> <br /></div>

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

					if(($totalInv>0) &&  ($exportToExcel==1))
					{
				?>
						<span style="float:left" class="one">
								To Export the above deals into a Spreadsheet,&nbsp;<input type="submit"  value="Click Here" name="showdeals">
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
						<a target="_blank" href="../xls/Sample_Sheet_Investments-RE.xls"><u>Click Here</u> </a> for a sample spreadsheet containing RE investments
						</span>

				<?php

					}
		}
				?>
		</div>
		<?php
					}
					elseif($buttonClicked=='Aggregate')
					{

						$aggsql= $aggsql. " i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
								and  pe.Deleted=0 " .$addVCFlagqry.
									 " order by pe.amount desc,dates desc";
						//	echo "<br>Agg SQL--" .$aggsql;
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
								 if($stage!="")
							   {
								  $stageSql= "select Stage from stage where StageId=$stage";
								  if($rsStage=mysql_query($stageSql))
								  {
									  while($mystageRow=mysql_fetch_array($rsStage,MYSQL_BOTH))
									  {
										$stageqryValue=$mystageRow["Stage"];
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
									$rangeqryValue= $rangeText;
								}
								if($wheredates !== "")
								{
									$dateqryValue= returnMonthname($month1) ." ".$year1 ." - ". returnMonthname($month2) ." " .$year2;
								}
								$searchsubTitle="";
								if(($industry==0) && ($stage=="--") && ($range=="--") && ($wheredates==""))
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
						if($stage !="")
						{
					?>
							<?php echo $qryDealTypeTitle; ?><?php echo $stageqryValue; ?> <?php echo $spacing; ?>
					<?php
						}
						if($range!="--")
						{
					?>
							<?php echo $qryRangeTitle; ?><?php echo $rangeqryValue; ?> <?php echo $spacing; ?>
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
	header( 'Location: '. GLOBAL_BASE_URL .'relogin.php' ) ;
//echo "<Br>Not logged in";
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