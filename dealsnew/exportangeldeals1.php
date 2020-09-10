<?php
session_save_path("/tmp");
session_start();

require("../dbconnectvi.php");
$Db = new dbInvestments();

//Check Session Id 
$sesID=session_id();
$emailid=$_SESSION['UserEmail'];
$sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='".$emailid."' AND `dbTYpe`='PE'";
$resUserLogSel = mysql_query($sqlUserLogSel);
$cntUserLogSel = mysql_num_rows($resUserLogSel);
if ($cntUserLogSel > 0){
    $resUserLogSel = mysql_fetch_array($resUserLogSel);
    $logSessionId = $resUserLogSel['sessionId'];
    if ($logSessionId != $sesID){
        header( 'Location: logoff.php?value=caccess' ) ;
    }
}

function updateDownload($res){
    //Added By JFR-KUTUNG - Download Limit
    $recCount = mysql_num_rows($res);
    $dlogUserEmail = $_SESSION['UserEmail'];
    $today = date('Y-m-d');

    //Check Existing Entry
   $sqlSelCount = "SELECT `recDownloaded`  FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
   $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
   $rowSelCount = mysql_num_rows($sqlSelResult);
   $rowSel = mysql_fetch_object($sqlSelResult);
   $downloads = $rowSel->recDownloaded;

   if ($rowSelCount > 0){
       $upDownloads = $recCount + $downloads;
       $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
       $resUdt = mysql_query($sqlUdt) or die(mysql_error());
   }else{
       $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('0','".$dlogUserEmail."','".$today."','PE','".$recCount."')";
       mysql_query($sqlIns) or die(mysql_error());
   }
}        



$displayMessage="";
$mailmessage="";
$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";
$dbTypeSV="SV";
$dbTypeIF="IF";
$dbTypeCT="CT";
$companyIdDel=1718772497;
$companyIdSGR=390958295;
$companyIdVA=38248720;


$addVCFlagqry   = $_POST['addVCFlagqryhidden'];
$addDelind      = $_POST['addDelindhidden'];
$searchallfield = $_POST['searchallfieldhidden'];  
$companysearch  = $_POST['companysearchhidden'];
$keyword        = $_POST['keywordhidden'];
$industry       = $_POST['industryhidden'];
$city           = $_POST['cityhidden'];
$regionId       = $_POST['regionhidden'];
$followonVCFund = $_POST['followonVCFundhidden'];
$exited         = $_POST['exitedhidden'];
$month1         = $_POST['month1hidden'];
$year1          = $_POST['year1hidden'];
$month2         = $_POST['month2hidden'];  
$year2          = $_POST['year2hidden'];

$searchtitle="List of Angel Deals";
$tsjtitle="� TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";


            /*if(!$_POST)
            {
                    $iftest=1;
                    $yourquery=0;
                    $dt1 = $year1."-".$month1."-01";
                    $dt2 = $year2."-".$month2."-01";
                    //echo "<br>Query for all records";
                     $companysql = "SELECT pe.AngelDealId,pe.InvesteeId,pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
                     DATE_FORMAT( pe.DealDate, '%M-%Y' ) as dealperiod,pe.Dealdate as Dealdate, GROUP_CONCAT( inv.Investor ) AS Investor 
                     FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
                     WHERE  DealDate between '" . $dt1. "' and '" . $dt2 . "' and i.industryid  = pec.industry
                     AND pec.PEcompanyID = pe.InvesteeId  and pe.Deleted=0 and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId " .$addVCFlagqry. " ".$addDelind." GROUP BY pe.AngelDealId"  ;
                    $orderby="companyname";
                    $ordertype="asc";
           	     //echo "<br>all records" .$companysql;
            }(*/
            
if($searchallfield!="")
{
     $iftest=4;
        $yourquery=1;
        $datevalueDisplay1="";
        $datevalueCheck1="";
        $dt1 = $year1."-".$month1."-01";
        $dt2 = $year2."-".$month2."-31";
        
        $findTag = strpos($searchallfield,'tag:');
        $findTags = "$findTag";
        if($findTags == ''){
            $tagsval = "pec.city LIKE '$searchallfield%' OR pec.companyname LIKE '$searchallfield%' OR  sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%'";                                    
        }else{
            $tags = '';
            $ex_tags = explode(',',$searchallfield);
            if(count($ex_tags) > 0){
                for($l=0;$l<count($ex_tags);$l++){
                    if($ex_tags[$l] !=''){
                        $value = trim(str_replace('tag:','',$ex_tags[$l]));
                        $tags .= "pec.tags like '%:$value%' or ";
                    }
                }
            }
            $tagsval = trim($tags,' or ');
        }    

        $companysql="SELECT pe.AngelDealId,pe.InvesteeId, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
        DATE_FORMAT( pe.DealDate, '%M-%Y' ) as dealperiod,
         pe.Comment,pe.MoreInfor,pe.Dealdate as Dealdate, GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') AS Investor,pe.FollowonVCFund,pe.Exited,pe.MultipleRound,pe.MoreInfor,pec.website,pec.city, pec.region,pec.RegionId, pe.AggHide, pec.CINNo, pec.PECompanyId
         FROM angelinvdeals AS pe, industry AS i,    pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
        WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.InvesteeId 
        AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId AND 
        ( $tagsval )  GROUP BY pe.AngelDealId ";
        $orderby="companyname";
        $ordertype="asc";  
//    echo "<bR>---" .$companysql;
//    exit;
}
elseif ($companysearch != "")
{
     $iftest=2;
    $yourquery=1;
    $datevalueDisplay1="";
    $datevalueCheck1="";
        $dt1 = $year1."-".$month1."-01";
        $dt2 = $year2."-".$month2."-31";
    $companysql="SELECT pe.AngelDealId,pe.InvesteeId, pec.companyname, pec.industry, i.industry, 
        pec.sector_business as sector_business, DATE_FORMAT( pe.DealDate, '%M-%Y' ) as dealperiod,pe.Dealdate as Dealdate, GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') AS Investor,pe.FollowonVCFund,pe.Exited,pe.MultipleRound,pe.MoreInfor,pec.website,pec.city, pec.region,pec.RegionId, pe.AggHide, pec.CINNo, pec.PECompanyId
        FROM angelinvdeals AS pe, industry AS i,  pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
        WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.InvesteeId 
        AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId AND   pec.PECompanyId IN ($companysearch)    GROUP BY pe.AngelDealId";
        $orderby="companyname";
        $ordertype="asc";         
//	echo "<br>Query for company search";
// echo "<br> Company search--" .$companysql;
}
elseif($keyword !="")
{
     $iftest=3;
$yourquery=1;
$datevalueDisplay1="";
$datevalueCheck1="";
        $dt1 = $year1."-".$month1."-01";
        $dt2 = $year2."-".$month2."-31";
    $companysql="select pe.AngelDealId,pec.companyname,pec.industry,i.industry,sector_business as sector_business,
    peinv_inv.InvestorId,inv.Investor,pe.InvesteeId,pec.industry,
    pec.companyname,DATE_FORMAT( pe.DealDate, '%M-%Y' ) as dealperiod,i.industry,pe.Dealdate as Dealdate, GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') AS Investor,pe.FollowonVCFund,pe.Exited,pe.MultipleRound,pe.MoreInfor,pec.website,pec.city, pec.region,pec.RegionId, pe.AggHide, pec.CINNo, pec.PECompanyId
    from angel_investors as peinv_inv,peinvestors as inv,
    angelinvdeals as pe,pecompanies as pec,industry as i
    where DealDate between '" . $dt1. "' and '" . $dt2 . "' and  inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid  and pe.Deleted=0
    and pe.AngelDealId=peinv_inv.AngelDealId and pec.PECompanyId=pe.InvesteeId " .$addVCFlagqry." ".$addDelind." AND
    inv.InvestorId IN($keyword)   GROUP BY pe.AngelDealId ";
    $orderby="companyname";
    $ordertype="asc";  
//echo "<br> Investor search- ".$companysql;
}
elseif ((($industry !='') ||  ($regionId != "--" || $regionId !='') || ($city!='')|| ($exited >=0)) && (($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--") ))
        {
     $iftest=5;
        $yourquery=1;
        $dt1 = $year1."-".$month1."-01";
        //echo "<BR>DATE1---" .$dt1;
        $dt2 = $year2."-".$month2."-01";
        $companysql = "select pe.AngelDealId,pe.InvesteeId,pec.companyname,pec.industry,i.industry,
        pec.sector_business as sector_business,DATE_FORMAT( pe.DealDate, '%M-%Y' ) as dealperiod,pe.Dealdate as Dealdate, GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') AS Investor,pe.FollowonVCFund,pe.Exited,pe.MultipleRound,pe.MoreInfor,pec.website,pec.city, pec.region,pec.RegionId, pe.AggHide, pec.CINNo, pec.PECompanyId
                from angelinvdeals as pe, industry as i,pecompanies as pec,angel_investors as peinv_inv,peinvestors as inv where";
        //	echo "<br> individual where clauses have to be merged ";
                if ($industry != '') {
                    $inSql = '';
                    $industry1 = explode(',',$industry);
                    foreach($industry1 as $industrys)
                        {
                        $inSql .= " pec.industry= '".$industrys."' or ";
                    }
                    $inSql = trim($inSql,' or ');
                    if($inSql !=''){
                        $whereind=  ' ( '.$inSql.' ) ';
                        //$whereRound="pe.round LIKE '".$round."'";
                    }
                                $qryIndTitle="Industry - ";
                        }
                $whereregion = '';
                if ($regionId != '') {
                    $regionSql = '';
                    $regionId1 = explode(',',$regionId);
                    foreach($regionId1 as $regionIds)
                    {
                        $regionSql .= " pec.RegionId  = '".$regionIds."' or ";
                    }
                    $regionSql = trim($regionSql,' or ');
                    if($regionSql !=''){
                        $whereregion=  ' ( '.$regionSql.' ) ';
                        //$whereregion = " pec.RegionId  =" . $regionId;
                    }
                $qryregionTitle="Region  - ";
                }

                if (($followonVCFund =="3") || ($followonVCFund=="1"))
                        {
                            $wherefollowonVCFund = " pe.FollowonVCFund = ".$followonVCFund;
                            $qryDealTypeTitle="Follow on Funding Status  - ";
                        }
                if (($exited=="3") || ($exited=="1"))
                {
                        $whereexited = " pe.Exited =".$exited;
                        $qryDealTypeTitle="Exited  - ";

                }
                if($city != "")
                {
                    $whereCity=" pec.city LIKE '".$city."%'";
                }
                if(($month1 != "--") && (year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                {
                        $qryDateTitle ="Period - ";
                       $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                }
        if ($whereind != "")
            $companysql=$companysql . $whereind ." and ";
        if($wherefollowonVCFund!="")
            $companysql=$companysql .$wherefollowonVCFund. " and ";
        if($whereexited !="")
            $companysql=$companysql .$whereexited. " and ";
        
        if($whereCity !="")
        {
            $companysql=$companysql.$whereCity." and ";
        }
        if (($whereregion != ""))
        {
            $companysql=$companysql . $whereregion . " and " ;
        }
        if($wheredates !== "") 
            $companysql = $companysql . $wheredates ." and ";


    $companysql = $companysql . "  i.industryid=pec.industry and
            pec.PEcompanyID = pe.InvesteeId  and
            pe.Deleted=0 and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId " .$addVCFlagqry ."  ".$addDelind." GROUP BY pe.AngelDealId ";
            //echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
     $orderby="companyname";
     $ordertype="asc";  
    }
else
{
        $iftest=1;
        $yourquery=0;
        $dt1 = $year1."-".$month1."-01";
        $dt2 = $year2."-".$month2."-01";
        //echo "<br>Query for all records";
         $companysql = "SELECT pe.AngelDealId,pe.InvesteeId,pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,
         DATE_FORMAT( pe.DealDate, '%M-%Y' ) as dealperiod,pe.Dealdate as Dealdate, GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') AS Investor,pe.FollowonVCFund,pe.Exited,pe.MultipleRound,pe.MoreInfor,pec.website,pec.city, pec.region,pec.RegionId, pe.AggHide, pec.CINNo, pec.PECompanyId
         FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
         WHERE  DealDate between '" . $dt1. "' and '" . $dt2 . "' and i.industryid  = pec.industry
         AND pec.PEcompanyID = pe.InvesteeId  and pe.Deleted=0 and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId " .$addVCFlagqry. " ".$addDelind." GROUP BY pe.AngelDealId"  ;
        $orderby="companyname";
        $ordertype="asc";
        //echo "<br> Invalid input selection ";
        //$fetchRecords=false;
}	

if($companysql!="" && $orderby!="" && $ordertype!="")
           $companysql = $companysql . " order by  Dealdate desc,companyname asc "; 	

$sql=$companysql;
//echo "<br>---" .$sql."<br>";
//execute query
$result = @mysql_query($sql) or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());

updateDownload($result);

////if this parameter is included ($w=1), file returned will be in word format ('.doc')
//if parameter is not included, file returned will be in excel format ('.xls')
if (isset($w) && ($w==1)){
        $file_type = "msword";
        $file_ending = "doc";
}else{
        $file_type = "vnd.ms-excel";
        $file_ending = "xls";
}
//header info for browser: determines file type ('.doc' or '.xls')
header("Content-Type: application/$file_type");
header("Content-Disposition: attachment; filename=Angel_Deals.$file_ending");
header("Pragma: no-cache");
header("Expires: 0");

/*    Start of Formatting for Word or Excel    */
/*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */

//create title with timestamp:
if ($Use_Title == 1){
        echo("$title\n");
}

echo ("$tsjtitle");
print("\n");
print("\n");

 //define separator (defines columns in excel & tabs in word)
 $sep = "\t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }
echo "Company"."\t";
//echo "PE/VC INVESTORS"."\t";
echo "Industry"."\t";
echo "Sector"."\t";
echo "Investors"."\t";
echo "Date"."\t";
echo "Multiple Angel Rounds"."\t";
echo "Follow on VC Funding"."\t";
echo "Exited"."\t";
echo "City"."\t";
echo "Region"."\t";
echo "Website"."\t";
echo "More Details"."\t";


 print("\n");
 print("\n");
 //end of printing column names
 //start while loop to get data
 /*
 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
 */
 $searchString="Undisclosed";
 $searchString=strtolower($searchString);
 $searchStringDisplay="Undisclosed";

 $searchString1="Unknown";
 $searchString1=strtolower($searchString1);

 $searchString2="Others";
 $searchString2=strtolower($searchString2);
$pe_inv = array();
 while($row = mysql_fetch_array($result)){
       
    $schema_insert = "";
    $companyName    =   $row['companyname'];
    //$CINNo    =   $row['CINNo'];
   $pe_inv[] = $PECompanyId    =   $row['PECompanyId'];
    $industry       =   $row['industry'];
    $sector         =   $row['sector_business'];
    $investors      =   $row['Investor'];
    $date           =   $row['dealperiod'];
    $multipleRounds =   ($row['MultipleRound']==1) ? "Yes" : "No";
    $followOnVC     =   ($row['FollowonVCFund']==1) ? "Obtained" : "None";
    $exited         =   ($row['Exited']==1) ? "Exited" : "Non Exited";
    $website        =   $row['website'];
    $city           =   $row['city'];
    $region         =   $row['region'];
    $regionId       =   $row['RegionId'];
    $moreDetails    =   $row['MoreInfor'];
            
    
    if($row["AggHide"]==1)
    {
        $openBracket="(";
        $closeBracket=")";
    }
    else
    {
        $openBracket="";
        $closeBracket="";
    }
    
    if($regionId>0){
        $getRegionSql="select Region from region where RegionId=$regionId";
        if ($rsregion = mysql_query($getRegionSql)){
            While($regionrow=mysql_fetch_array($rsregion, MYSQL_BOTH)){
                    $regiontext=$regionrow["Region"];
            }
        }
    }else{
        $regiontext=$region; // Region
    }
 
    $schema_insert .= $openBracket.$companyName.$closeBracket.$sep;    
    //$schema_insert .= $CINNo.$sep;
    /*$PE_investroeList = '';
    $investorSql="select pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV from
            peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,
            peinvestors as inv where pe.PECompanyId='$PECompanyId' and
            peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0
            and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15 order by dates desc";
    if($investorSql!="")
    {
        if($getcompanyrs= mysql_query($investorSql))
        {
            $investor_cnt = mysql_num_rows($getcompanyrs);
            While($myInvestorrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH)){
                $Investorname=trim($myInvestorrow["Investor"]);
                $Investorname=strtolower($Investorname);
                $invResult=substr_count($Investorname,$searchString);
                $invResult1=substr_count($Investorname,$searchString1);
                $invResult2=substr_count($Investorname,$searchString2);
                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                {
                   $addTrancheWord="";
                   $addDebtWord="";
                    if(($pe_re==0) || ($pe_re==1) || ($pe_re==8) )
                    {
                        if($myInvestorrow["AggHide"]==1)
                            $addTrancheWord="; Tranche";
                        else
                            $addTrancheWord="";
                    }
                    else
                        $addTrancheWord="";
                    if($myInvestorrow["SPV"]==1)
                        $addDebtWord="; Debt";
                    else
                        $addDebtWord="";
                    $peinvestor = $myInvestorrow["Investor"];
                    $pedt = $myInvestorrow["dt"];
                    $PE_investroeList .= $peinvestor.'-'.$pedt.', ';
                }
            }
        }
    }
    $PE_investroeList = trim($PE_investroeList, ', ');
    $schema_insert .= $PE_investroeList.$sep;*/
    $schema_insert .= $industry.$sep;
    $schema_insert .= $sector.$sep;
    $schema_insert .= $investors.$sep;
    $schema_insert .= $date.$sep;
    $schema_insert .= $multipleRounds.$sep;
    $schema_insert .= $followOnVC.$sep;
    $schema_insert .= $exited.$sep;
    $schema_insert .= $city.$sep;
    $schema_insert .= $regiontext.$sep;
    $schema_insert .= $website.$sep;
    $schema_insert .= $moreDetails.$sep;
    $schema_insert .= ""."\n"; 
    //following fix suggested by Josue (thanks, Josue!)
    //this corrects output in excel when table fields contain \n or \r
    //these two characters are now replaced with a space
    $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
    $schema_insert .= "\t";
    print(trim($schema_insert));
    print "\n";

     }
     $_SESSION['pe_inv'] = $pe_inv;


   mysql_close();
    mysql_close($cnx);
    ?>


