<?php include_once("../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
if($_POST['exportexit'] == "exportexit")
{
    $hidedateStartValue=$_POST['txthidedateStartValue'];
    $hidedateEndValue=$_POST['txthidedateEndValue'];
    $companysql = "SELECT count(DISTINCT pe.MandAId) as count FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,investortype as it,manda_investors as mandainv,peinvestors as inv where DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "' and i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and dt.DealtypeId=pe.DealTypeId and pe.InvestorType=it.InvestorType and mandainv.MandAId=pe.MandAId and pe.Deleted=0 and dt.hide_for_exit in (0,1) AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) order by companyname";
    $sqlSelResult = mysql_query($companysql) or die(mysql_error());

    while ($row = mysql_fetch_assoc($sqlSelResult)) {
            
        $count= $row['count']  ;

            
    }
    echo $count;exit();
}
else
{
    $month1=$_POST['month1'];
    $month2=$_POST['month2'];
    $year1=$_POST['year1'];
    $year2=$_POST['year2'];
    $startDate=$year1.'-'.$month1.'-01';
    $endYear=$year2.'-'.$month2.'-31';
    $sql="SELECT count(pe.PECompanyID) as PECompanyId,pec.companyname,pec.industry,pe.dates as dates,i.industry as industry, pec.sector_business as sector_business,amount,pe.Amount_INR,round,s.stage,stakepercentage,DATE_FORMAT(dates,'%b-%Y') as dealperiod, pec.website,pec.city,pec.region,pe.PEId,pe.comment,pe.MoreInfor,hideamount,hidestake,pe.StageId,SPV,pec.RegionId,AggHide,pe.Exit_Status, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others' separator ', ') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor, (SELECT count(inv.Investor) FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investorcount FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId JOIN industry AS i ON pec.industry = i.industryid JOIN stage AS s ON s.StageId=pe.StageId WHERE  dates between '".$startDate."' and '".$endYear."'  and pe.Deleted=0 AND pe.SPV=0 and pe.AggHide=0 and pec.industry !=15 AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) order by dates desc,companyname asc";
    //echo $sql;
    $sqlSelResult = mysql_query($sql) or die(mysql_error());

    while ($row = mysql_fetch_assoc($sqlSelResult)) {
            
        $count= $row['PECompanyId']  ;

            
    }
    echo $count;exit();
}
?>


