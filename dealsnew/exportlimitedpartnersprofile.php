<?php include_once("../globalconfig.php"); ?>
<?php //session_save_path("/tmp");
ini_set ( 'max_execution_time', 300);
session_start();
require("../dbconnectvi.php");
$Db = new dbInvestments();
//print_r($_POST);
//exit();
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
        //include('onlineaccount.php');
                    $displayMessage="";
                    $mailmessage="";

                    //global $LoginAccess;
                    //global $LoginMessage;
                    $TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";
                     $dbTypeSV="SV";
                    $dbTypeIF="IF";
                    $dbTypeCT="CT";
                    $wheredates="";
                                
                    //VCFLAG VALUE
                    $submitemail=$_POST['txthideemail'];
                    $pe_ipo_manda_flag=$_POST['hidepeipomandapage'];
                    $pe_vc_flag=$_POST['hidevcflagValue'];
                    $isShowAll=$_POST['hideShowAll'];
                    $industry=$_POST['txthideindustryid'];
                        $round=$_POST['txthideround'];
                    if($_POST['txthidestageid'] !=''){
                    $stageval=substr($_POST['txthidestageid'],1); 

                    $stageval = explode(',',$stageval);
                    if(isset($stageval)){
                         $boolStage=true;
                    }
                }
                    $investorType=$_POST['txthideinvestorTypeid'];
                    //echo "<bR>*******************".$investorTypeId;
                    $startRangeValue=$_POST['txthiderange'];
                    $endRangeValue=$_POST['txthiderangeEnd'];
                    //echo "<bR>-----" .$range;
                   $dt1=$_POST['txthidedateStartValue'];
                   $dt2=$_POST['txthidedateEndValue'];
                   $hiddenSearchKey = $_POST['hiddenSearchKey'];
                
                   
                    $companysearch=$_POST['txthidecompany'];
                    $keyword=$_POST['txthidekeyword'];
                    $sectorsearch=$_POST['txthidesector'];
                    $advisorsearch_legal=$_POST['txthideadvisorlegal'];
                    $advisorsearch_trans=$_POST['txthideadvisortrans'];
                       $searchallfield=$_POST['searchallfield'];
                       $invname=$_POST['invname'];
                                    //echo "<br>^^^".$investorID;

                    $searchString="Undisclosed";
                    $searchString=strtolower($searchString);

                    $searchString1="Unknown";
                    $searchString1=strtolower($searchString1);

                    $searchString2="Others";
                    $searchString2=strtolower($searchString2);

                                        //echo "<bR>--********-".$investorID;
                    //echo "<br>PE VC Flag-" .$pe_vc_flag;
                    //echo "<br>End date-" .$hidedateEndValue;
                //  echo "<br>Date value-" .$dateValue;

                    $tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

                    if($pe_vc_flag==0)
                    {
                        $addVCFlagqry="";
                       /* if($invname!=""){
                            $filetitle=$invname." - Investor Profile - VI";
                        }else{
                            $filetitle="PE-Investors";
                        }*/
                        $filetitle="PE-Limited-Partners";
                    }
                    elseif($pe_vc_flag==1)
                    {
                        $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                        /*if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                             $filetitle="VC-Investors";
                        }*/
                        //$filetitle="VC-Investors";
                        $filetitle="VC-Limited-Partners";
                    }
                    elseif($pe_vc_flag==2) //Angel Companies
                    {
                        $addVCFlagqry="";
                        /*if($invname!=""){
                            $filetitle=$invname." - Investor Profile - VI";
                        }else{
                             $filetitle="Angel-backed-Investors";
                        }*/
                        //$filetitle="Angel-backed-Investors";
                        $filetitle="Angel-Limited-Partners";

                    }
                    else if($pe_vc_flag==3)
                    {
                        $addVCFlagqry = "";
                        $dbtype="SV";
                        /*if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                              $filetitle="Social-Venture-Investors";
                        }*/
                        //$filetitle="Social-Venture-Investors";
                        $filetitle="Social-Venture-Limited-Partners";
                    }
                    else if($pe_vc_flag==4)
                    {
                        $addVCFlagqry = "";
                        $dbtype="CT";
                        /* if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                             $filetitle="CleanTech-Investments-Investors";
                        }*/
                        //$filetitle="CleanTech-Investments-Investors";
                        $filetitle="CT-Limited-Partners";
                    }
                    elseif($pe_vc_flag==5)
                    {
                        $addVCFlagqry = "";
                        $dbtype="IF";
                       /* if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                             $filetitle="Infrastructure-Investments-Investors";
                        }*/
                       // $filetitle="Infrastructure-Investments-Investors";
                        $filetitle="IF-Limited-Partners";
                    }
                    elseif($pe_vc_flag==7) //PE_ipos
                    {
                        $addVCFlagqry="";
                       /* if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                            $filetitle="PE-backed-IPOInvestors";
                        }*/
                       // $filetitle="PE-backed-IPOInvestors";
                        $filetitle="PE-backed-Limited-Partners";
                    }
                    elseif($pe_vc_flag==8) //VC-ipos
                    {
                        $addVCFlagqry="and VCFlag=1";
                       /* if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                             $filetitle="VC-backed-IPO-Investors";
                        }*/
                       // $filetitle="VC-backed-IPO-Investors";
                        $filetitle="VC-backed-Limited-Partners";
                    }
                    elseif($pe_vc_flag==10) //PE-EXits M&A Companies
                    {
                        $addVCFlagqry="";
                       /*  if($invname!=""){
                            $filetitle=$invname." - Investor Profile - VI";
                        }else{
                            $filetitle="PE-Exits-M&A-Investors";
                        }*/
                      //  $filetitle="PE-Exits-M&A-Investors";
                        $filetitle="PE-Exits-M&A-Limited-Partners";
                    }
                    elseif($pe_vc_flag==11) //VC-EXits M&A Companies
                    {
                        $addVCFlagqry="and VCFlag=1";
                        /* if($invname!=""){
                            $filetitle=$invname." - Investor Profile - VI";
                        }else{
                            $filetitle="VC-Exits-M&A-Investors";
                        }*/
                      //  $filetitle="VC-Exits-M&A-Investors";
                        $filetitle="VC-Exits-M&A-Limited-Partners";
                    }

                    elseif($pe_vc_flag==9)
                    {
                        $addVCFlagqry="";
                         /*if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                             $filetitle="PMS";
                        }*/
                      //  $filetitle="PMS";
                        $filetitle="PMS-Limited-Partners";
                    }
                    elseif($pe_vc_flag==12)
                    {
                        $addVCFlagqry="and VCFlag=1";
                       /* if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                              $filetitle="VCPMS";
                        }*/
                      //  $filetitle="VCPMS";
                        $filetitle="VCPMS-Limited-Partners";
                    }
                if(!isset($_POST[ 'sqlquery' ])){
                
                    if($pe_vc_flag==0 || $pe_vc_flag==1){
                        if($keyword!="")
                         {
                            $showallsql="select distinct lp.*,peinv.InvestorId,inv.Investor,inv.*,GROUP_CONCAT(distinct i.industry SEPARATOR ', ') as industry , GROUP_CONCAT(distinct s.Stage SEPARATOR ', ') as Stage , 
                            (select country from country  where countryid = inv.countryid) as Countryname ,
                            (select focuscapsource from focus_capitalsource where focuscapsourceid = inv.focuscapsourceid) as focuscapsource,
                            SUM(peinv.Amount_M) as total_amount
                            from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,industry as i,limited_partners as lp
                            where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                            pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and i.industryid=pec.industry and peinv.InvestorId!=9 and
                            pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry. " and inv.Investor like '%$keyword%' $comp_industry_id_where group by inv.Investor  GROUP BY lp.LPId order by lp.InstitutionName ";

                            $totalallsql=$exportsql=$showallsql;
                             //echo "<br> Investor search 0 or 1- ".$showallsql;
                         }
                         elseif($companysearch!="")
                         {
                                 $showallsql="select distinct lp.*,peinv.InvestorId,inv.Investor,inv.*, GROUP_CONCAT(distinct i.industry SEPARATOR ', ') as industry , GROUP_CONCAT(distinct s.Stage SEPARATOR ', ') as Stage , 
                            (select country from country  where countryid = inv.countryid) as Countryname ,
                            (select focuscapsource from focus_capitalsource where focuscapsourceid = inv.focuscapsourceid) as focuscapsource,
                            SUM(peinv.Amount_M) as total_amount
                                 from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,industry as i,limited_partners as lp
                                 where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                 pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and i.industryid=pec.industry and peinv.InvestorId!=9 and 
                                 pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry. " and pec.companyname like '%$companysearch%' $comp_industry_id_where group by inv.Investor  GROUP BY lp.LPId order by lp.InstitutionName";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "<br> company search-0 or 1 ".$showallsql;
                         }
                         elseif($sectorsearch!="")
                         {
                                 $showallsql="select distinct lp.*,peinv.InvestorId,inv.Investor,inv.*,GROUP_CONCAT(distinct i.industry SEPARATOR ', ') as industry ,
                            GROUP_CONCAT(distinct s.Stage SEPARATOR ', ') as Stage , 
                            (select country from country  where countryid = inv.countryid) as Countryname ,
                            (select focuscapsource from focus_capitalsource where focuscapsourceid = inv.focuscapsourceid) as focuscapsource,
                            SUM(peinv.Amount_M) as total_amount
                                 from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,industry as i,limited_partners as lp
                                 where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                 pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and peinv.InvestorId!=9 and
                                 pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry. " and pec.sector_business like '%$sectorsearch%' $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName ";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "<br> sector search 0 or 1- ".$showallsql;
                         }
                         elseif($advisorsearch_legal!="")
                         {
                                 $showallsql="(select distinct lp.*,peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                     pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                     pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 
                                     " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName )
                                     UNION(select distinct lp.*,peinv.InvestorId,inv.Investor,inv.* 
                                     from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, advisor_cias AS cia,
                                     peinvestments_advisorcompanies AS adac,limited_partners as lp where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.StageId=s.StageId and 
                                     pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners) " .$addVCFlagqry. "
                                     and cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='L' $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName )";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "<br>advisor_legal search 0 or 1- ".$showallsql;
                         }
                         elseif($advisorsearch_trans!="")
                         {
                                 $showallsql="(select distinct lp.*,peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                     pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                     pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 
                                     " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName )
                                     UNION(select distinct lp.*,peinv.InvestorId,inv.Investor,inv.* 
                                     from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, advisor_cias AS cia,
                                     peinvestments_advisorcompanies AS adac,limited_partners as lp where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.StageId=s.StageId and 
                                     pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners) " .$addVCFlagqry. "
                                     and cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='T' $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName )";

                                 $totalallsql=$exportsql=$showallsql;
                             //echo "<br> $advisor_trans search 0 or 1- ".$showallsql;
                         }elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                                //$tags .= "pec.tags like '%:$value%' or ";
                                                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }

                            $showallsql="select distinct lp.*,peinv.InvestorId,inv.Investor,inv.*,GROUP_CONCAT(distinct i.industry SEPARATOR ', ') as industry ,
                            GROUP_CONCAT(distinct s.Stage SEPARATOR ', ') as Stage , 
                            (select country from country  where countryid = inv.countryid) as Countryname ,
                            (select focuscapsource from focus_capitalsource where focuscapsourceid = inv.focuscapsourceid) as focuscapsource,
                            SUM(peinv.Amount_M) as total_amount
                                 from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, country as c,industry as i,limited_partners as lp
                                 where $wheredates peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and inv.countryid= c.countryid and 
                                 pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and i.industryid=pec.industry  and i.industryid=pec.industry and s.StageId=pe.StageId and
                                 pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry." and ( $tagsval ) $search $comp_industry_id_where group by inv.Investor GROUP BY lp.LPId order by lp.InstitutionName ";

                                 $totalallsql=$exportsql=$showallsql;                                
                         }elseif($searchallfield!="")
                         {
 
                         //    if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                         //         $dt1 = $year1."-".$month1."-01";
                         //         $dt2 = $year2."-".$month2."-01";
                         //         $wheredates = " dates between '" . $dt1. "' and '" . $dt2 . "' and";
                         //    }
                              
                              $findTag = strpos($searchallfield,'tag:');
                              $findTags = "$findTag";
                             
                                  /*$tagsval = "inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%'"; */
                                 $searchExplode = explode( ' ', $searchallfield );
                                 foreach( $searchExplode as $searchFieldExp ) {
                                     $LimitedPartnersLike .= "lp.InstitutionName REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    // $cityLike .= "inv.City REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    // $countryLike .= "c.country REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                  //   $ZipLike .= "inv.Zip REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                //     $investorLike .= "inv.investor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $websiteLike .= "inv.website REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $AdditionalInforLike .= "inv.AdditionalInfor REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $DescriptionLike .= "inv.Description REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $Address1Like .= "inv.Address1 REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $Address2Like .= "inv.Address2 REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $TelephoneLike .= "inv.Telephone REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $EmailLike .= "inv.Email REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $yearfoundedLike .= "inv.yearfounded REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $linkedInLike .= "inv.linkedIn REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $FirmTypeLike .= "inv.FirmType REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $OtherLocationLike .= "inv.OtherLocation REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $Assets_mgmtLike .= "inv.Assets_mgmt REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $NoFundsLike .= "inv.NoFunds REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $MinInvestmentLike .= "inv.MinInvestment REGEXP '[[:<:]]".$searchFieldExp."[[:>:]]' AND ";
                                    //  $tagsLike .= "pec.tags REGEXP '[[.colon.]]$searchFieldExp$' or pec.tags REGEXP '[[.colon.]]$searchFieldExp,' OR ";
                                 }
                                 $LimitedPartnersLike = '('.trim($LimitedPartnersLike,'AND ').')';
                              //   $investorLike = '('.trim($investorLike,'AND ').')';
                                // $cityLike = '('.trim($cityLike,'AND ').')';
                                // $countryLike = '('.trim($countryLike,'AND ').')';
                                // $ZipLike = '('.trim($ZipLike,'AND ').')';
                                //   $websiteLike = '('.trim($websiteLike,'AND ').')';
                                //  $AdditionalInforLike = '('.trim($AdditionalInforLike,'AND ').')';
                                //  $DescriptionLike = '('.trim($DescriptionLike,'AND ').')';
                                //  $Address1Like = '('.trim($Address1Like,'AND ').')';
                                //  $Address2Like = '('.trim($Address2Like,'AND ').')';
                                //  $TelephoneLike = '('.trim($TelephoneLike,'AND ').')';
                                //  $EmailLike = '('.trim($EmailLike,'AND ').')';
                                //  $yearfoundedLike = '('.trim($yearfoundedLike,'AND ').')';
                                //  $linkedInLike = '('.trim($linkedInLike,'AND ').')';
                                //  $FirmTypeLike = '('.trim($FirmTypeLike,'AND ').')';
                                //  $OtherLocationLike = '('.trim($OtherLocationLike,'AND ').')';
                                //  $Assets_mgmtLike = '('.trim($Assets_mgmtLike,'AND ').')';
                                //  $NoFundsLike = '('.trim($NoFundsLike,'AND ').')';
                                //  $MinInvestmentLike = '('.trim($MinInvestmentLike,'AND ').')';
                                //  $tagsLike = '('.trim($tagsLike,'OR ').')';
                                //  $tagsval =$LimitedPartnersLike . ' OR ' . $cityLike . ' OR ' . $countryLike . ' OR ' . $investorLike . ' OR ' . $websiteLike . ' OR ' . $AdditionalInforLike . ' OR ' . $DescriptionLike . ' OR ' . $Address1Like . ' OR ' . $Address2Like . ' OR ' . $TelephoneLike . ' OR ' . $EmailLike . ' OR ' . $yearfoundedLike . ' OR ' . $linkedInLike . ' OR ' . $FirmTypeLike . ' OR ' . $OtherLocationLike . ' OR ' . $Assets_mgmtLike . ' OR ' .  $NoFundsLike . ' OR ' . $MinInvestmentLike . ' OR ' . $tagsLike;                                   
                                $tagsval =$LimitedPartnersLike ;                                   
                             
                                  $showallsql="select distinct lp.*
                                  from limited_partners as lp
                                  where  lp.Deleted!=1" .$addVCFlagqry. " and ( $tagsval ) $search GROUP BY lp.LPId order by lp.InstitutionName ";
 
                                  $totalallsql=$exportsql=$showallsql;                                
                          }
                         elseif(($industry > 0) || ($countrytxt != "" && $countrytxt != "--" && $countrytxt != "NIN") || ($countryNINtxt != "" && $countryNINtxt != "---")|| ($cityname != "" && $cityid != "--") || ($investorType!= "") || ($firmtypetxt!= "" && $firmtypetxt != "--") || ($city != "") || ($round != "--" && $round !="") || (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  ) )
                         {
                            $showallsql = "select distinct lp.*,inv.* , 
                            GROUP_CONCAT(distinct i.industry SEPARATOR ', ') as industry ,
                            GROUP_CONCAT(distinct s.Stage SEPARATOR ', ') as Stage , 
                            (select country from country  where countryid = inv.countryid) as Countryname ,
                            (select focuscapsource from focus_capitalsource where focuscapsourceid = inv.focuscapsourceid) as focuscapsource,
                            SUM(peinv.Amount_M) as total_amount
                            from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv ,industry AS i,limited_partners as lp
                             where ";

                             //echo "<br> individual where clauses have to be merged ";
                            if ($industry > 0)
                                $whereind = " pec.industry=" .$industry ;

                            if ($countrytxt != "" && $countrytxt != "--" && $countrytxt != "NIN")
                                $wherecountry = " inv.countryid = '".$countrytxt."'" ;
                            
                            if ($countryNINtxt != "" && $countryNINtxt != "---")
                                {
                                    if($countryNINtxt == 'All'){
                                        $wherecountryNIN = " inv.countryid != 'IN'" ;
                                    } else {
                                        $wherecountryNIN = " inv.countryid = '".$countryNINtxt."'" ;
                                    }
                                }
                            
                            
                            if ($cityname != "" && $cityid != "--")
                                $wherecitytxt = " inv.City LIKE '".$cityname."'" ;

                            if ($investorType!= "")
                                $whereInvType = " pe.InvestorType = '".$investorType."'";

                            if ($firmtypetxt!= "" && $firmtypetxt != "--")
                                $wherefirmtypetxt = " inv.FirmTypeId IN (".$firmtypevalue.")";

                            if($city != "")
                            {
                               $whereCity=" pec.city LIKE '".$city."'";
                            }
                             
                            if ($boolStage==true)
                            {
                                $stagevalue="";
                                $stageidvalue="";
                                foreach($stageval as $stage)
                                {
                                        //echo "<br>****----" .$stage;
                                        $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                        $stageidvalue=$stageidvalue.",".$stage;
                                }

                                $wherestage = $stagevalue ;
                                $qryDealTypeTitle="Stage  - ";
                                $strlength=strlen($wherestage);
                                $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                             //echo "<br>---" .$stringto;

                            }
                              //
                             if($round != "--" && $round !="")
                             {
                                 $whereRound=" pe.round LIKE '".$round."'";
                             }
                             //
                            if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                            {
                                $startRangeValue=$startRangeValue;
                                $endRangeValue=$endRangeValue-0.01;
                                $qryRangeTitle="Deal Range (M$) - ";
                                if($startRangeValue < $endRangeValue)
                                {
                                        $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                }
                                elseif($startRangeValue = $endRangeValue)
                                {
                                        $whererange = " pe.amount >= ".$startRangeValue ."";
                                }
                            }

                            /*if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                 $dt1 = $year1."-".$month1."-01";
                                 $dt2 = $year2."-".$month2."-01";
                                 $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                            }*/
                             if ($whereind != "")
                             {
                                     $showallsql=$showallsql . $whereind ." and ";

                                     $bool=true;
                             }
                             else
                             {
                                     $bool=false;
                             }

                             if (($wherestage != ""))
                             {
                                     $showallsql=$showallsql. $wherestage . " and " ;
                                     $bool=true;
                             }

                             if ($wherecountry != "")
                             {
                                     $showallsql=$showallsql . $wherecountry ." and ";
                                     $bool=true;
                             }
                             if ($wherecountryNIN != "")
                             {
                                     $showallsql=$showallsql . $wherecountryNIN ." and ";
                                     $bool=true;
                             }
                             if ($wherecitytxt != "")
                             {
                                     $showallsql=$showallsql . $wherecitytxt ." and ";
                                     $bool=true;
                             }


                             if($whereRound !="")
                                     {
                                         $showallsql=$showallsql.$whereRound." and ";
                                     }
                             if (($whereInvType != "") )
                             {
                                     $showallsql=$showallsql.$whereInvType . " and ";
                                     $bool=true;
                             }
                             if (($wherefirmtypetxt != "") )
                             {
                                     $showallsql=$showallsql.$wherefirmtypetxt . " and ";
                                     $bool=true;
                             }
                             if (($whererange != "") )
                             {
                                     $showallsql=$showallsql.$whererange . " and ";
                                     $bool=true;
                             }
                            /* if(($wheredates !== "") )
                             {
                                     $showallsql = $showallsql . $wheredates ." and ";
                                     $bool=true;
                             }*/

                             if($whereCity !="")
                             {
                                 $showallsql=$showallsql.$whereCity." and ";
                             }

                             $totalallsql = $exportsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                             pe.StageId=s.StageId  AND i.industryid = pec.industry and pec.industry!=15 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners) and 
                             pe.Deleted=0 and Investor!='Others' " .$addVCFlagqry. " ".$dirsearchall.$comp_industry_id_where."  GROUP BY lp.LPId order by lp.InstitutionName ";

                             $showallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                             pe.StageId=s.StageId  AND i.industryid = pec.industry and pec.industry!=15 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners) and 
                             pe.Deleted=0 and Investor!='Others' " .$addVCFlagqry. " " .$search." ".$dirsearchall.$comp_industry_id_where."  GROUP BY lp.LPId order by lp.InstitutionName ";
                             
                             //echo $showallsql;
                         }
                         else
                         {
                           /* if($vcflagValue==1)
                            {
                                $joinvctable=" ,peinvestments as pe   ";
                                $vccondition=" and pe.amount<=20 ";
                            }*/

                            // $showallsql = "select distinct lp.* from limited_partners as lp,peinvestors as inv ".$joinvctable."
                            //  where    inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, REPLACE( inv.LimitedPartners,', ',',')) and lp.Deleted!=1  " .$search.$vccondition. " GROUP BY lp.LPId order by lp.InstitutionName
                            //  ";
                            /* $showallsql = "select distinct lp.* from limited_partners as lp,peinvestors as inv ".$joinvctable."
                             where    inv.LimitedPartners !='' and lp.Deleted!=1  " .$search.$vccondition. " GROUP BY lp.LPId order by lp.InstitutionName
                             ";*/
                              $showallsql = "select distinct lp.* from limited_partners as lp,peinvestors as inv 
                             where    inv.LimitedPartners !='' and lp.Deleted!=1 GROUP BY lp.LPId order by lp.InstitutionName
                             ";
                             $totalallsql=$exportsql=$showallsql;  

                            
                         }

                    }
                    
                    elseif($pe_vc_flag==3 || $pe_vc_flag==4 || $pe_vc_flag==5){
                        
                       if($pe_vc_flag==3){
                            $firmtype = " and inv.FirmTypeId = 4";
                        }
                           if($keyword!="")
                            {
                                    $showallsql="select distinct lp.*,peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                                    peinvestments_dbtypes as pedb,limited_partners as lp where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry.  $firmtype . " and Investor like '%$keyword%' $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName";
                                //echo "<br> Investor search- ".$showallsql;
                                    $totalallsql = $exportsql =$showallsql;
                                    
                            }
                            elseif($companysearch!="")
                            {
                                    $showallsql="select distinct lp.*,peinv.InvestorId,inv.Investor,inv.*,lp.InstitutionName
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                                    peinvestments_dbtypes as pedb,limited_partners as lp where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry.  $firmtype . " and pec.companyname like '%$companysearch%' $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName ";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                               // echo "<br> company search- ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                    $showallsql="select distinct lp.*,peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                                    peinvestments_dbtypes as pedb,limited_partners as lp where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry. $firmtype . " and pec.sector_business like '%$sectorsearch%' $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                                //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                    $showallsql="(select distinct lp.*,peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac,peinvestments_dbtypes as pedb,limited_partners as lp where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)
                                        " .$addVCFlagqry. $firmtype ." and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName)
                                        UNION(select distinct lp.*,peinv.InvestorId,inv.Investor,inv.*from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorcompanies AS adac,peinvestments_dbtypes as pedb,limited_partners as lp where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)
                                        " .$addVCFlagqry.  $firmtype . " and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName)";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                                //echo "<br>advisor_legal search- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                   $showallsql="(select distinct lp.*,peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac,peinvestments_dbtypes as pedb,limited_partners as lp where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)
                                        " .$addVCFlagqry. $firmtype . " and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName)
                                        UNION(select distinct lp.*,peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorcompanies AS adac,peinvestments_dbtypes as pedb,limited_partners as lp where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)
                                        " .$addVCFlagqry. $firmtype .  " and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName)";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                                //echo "<br> $advisor_trans search- ".$showallsql;
                            }
                            elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                                //$tags .= "pec.tags like '%:$value%' or ";
                                                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP '[[.colon.]]".$value."[[:space:]]'
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                                
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                                    $showallsql="select distinct lp.*,peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, country as c,
                                    peinvestments_dbtypes as pedb,limited_partners as lp where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and inv.countryid= c.countryid and 
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry.  $firmtype . " and ( $tagsval ) $search $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName ";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                            }
                            elseif($searchallfield!="")
                            {
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
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
                                    $showallsql="select distinct lp.*,peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, country as c,
                                    peinvestments_dbtypes as pedb,limited_partners as lp where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and inv.countryid= c.countryid and 
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry.  $firmtype . " and ( $tagsval ) $search $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName ";
                                    
                                    $totalallsql = $exportsql =$showallsql;
                               // echo "<br> company search- ".$showallsql;
                            }
                            elseif(($industry > 0) || ($countrytxt != "" && $countrytxt != "--" && $countrytxt != "NIN") || ($countryNINtxt != "" && $countryNINtxt != "---")|| ($cityname != "" && $cityid != "--") || ($investorType!= "") || ($firmtypetxt!= "" && $firmtypetxt != "--") || ($city != "") || ($round != "--" && $round !="") || (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  ) )
                         {
                              $showallsql = "select distinct lp.*,peinv.InvestorId,inv.Investor,inv.*
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,
                                peinvestments_dbtypes as pedb,limited_partners as lp where ";

                            //echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";

                                if ($countrytxt != "" && $countrytxt != "--" && $countrytxt != "NIN")
                                        $wherecountry = " inv.countryid = '".$countrytxt."'" ;
                                    
                                if ($countryNINtxt != "" && $countryNINtxt != "---")
                                        // $wherecountryNIN = " inv.countryid = '".$countryNINtxt."'" ;
                                        {
                                            if($countryNINtxt == 'All'){
                                                $wherecountryNIN = " inv.countryid != 'IN'" ;
                                            } else {
                                                $wherecountryNIN = " inv.countryid = '".$countryNINtxt."'" ;
                                            }
                                        }
                                    
                                if ($cityname != "" && $cityid != "--")
                                        $wherecitytxt = " inv.City LIKE '".$cityname."'" ;
                                
                                if ($firmtypetxt!= "" && $firmtypetxt != "--")
                                        $wherefirmtypetxt = " inv.FirmTypeId IN (".$firmtypevalue.")";

                                if($city != "")
                                {
                                       $whereCity=" pec.city LIKE '".$city."'";
                                }
                             
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                        }

                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;

                                }
                                 //
                                if($round != "--" && $round !="")
                                {
                                    $whereRound="pe.round LIKE '".$round."'";
                                }
                                        //
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.amount >= ".$startRangeValue ."";
                                       }
                               }
                               
                              /* if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates != "") )
                               {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                               }*/
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($wherestage != ""))
                                {
                                        $showallsql=$showallsql. $wherestage . " and " ;
                                        $bool=true;
                                }
                                if($whereRound !="")
                                        {
                                            $showallsql=$showallsql.$whereRound." and ";
                                        }     
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($wherefirmtypetxt != "") )
                                {
                                        $showallsql=$showallsql.$wherefirmtypetxt . " and ";
                                        $bool=true;
                                }

                                if ($wherecountry != "")
                                {
                                         $showallsql=$showallsql . $wherecountry ." and ";
                                         $bool=true;
                                }
                                if ($wherecountryNIN != "")
                                {
                                         $showallsql=$showallsql . $wherecountryNIN ." and ";
                                         $bool=true;
                                }
                                if ($wherecitytxt != "")
                                {
                                         $showallsql=$showallsql . $wherecitytxt ." and ";
                                         $bool=true;
                                }
                                
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                                if($whereCity !="")
                                {
                                    $showallsql=$showallsql.$whereCity." and ";
                                }
                                
                                $totalallsql = $exportsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                pe.Deleted=0 and Investor!='Others' and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry. $firmtype .  " ".$dirsearchall.$comp_industry_id_where."  GROUP BY lp.LPId order by lp.InstitutionName ";
                                 
                                $showallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                pe.Deleted=0 and Investor!='Others' and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry. $firmtype .  " " .$search." ".$dirsearchall.$comp_industry_id_where."  GROUP BY lp.LPId order by lp.InstitutionName ";
                                
                               
                            }
                            else
                         {
                            if($vcflagValue==1)
                            {
                                $joinvctable=" ,peinvestments as pe   ";
                                $vccondition=" and pe.amount<=20 ";
                            }else{
                                $joinvctable="";
                                $vccondition="";
                            }

                            // $showallsql = "select distinct lp.* from limited_partners as lp,peinvestors as inv ".$joinvctable."
                            //  where    inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, REPLACE( inv.LimitedPartners,', ',',')) and lp.Deleted!=1  " .$search.$vccondition. " GROUP BY lp.LPId order by lp.InstitutionName
                            //  ";
                             $showallsql = "select distinct lp.* from limited_partners as lp,peinvestors as inv ".$joinvctable."
                             where    inv.LimitedPartners !='' and lp.Deleted!=1  " .$search.$vccondition. " GROUP BY lp.LPId order by lp.InstitutionName
                             ";
                             $totalallsql=$exportsql=$showallsql;  

                            
                         }
                        
                    }
                    
                    elseif($pe_vc_flag==9 || $pe_vc_flag==10 || $pe_vc_flag==11 || $pe_vc_flag==12){
                        
                            if($pe_vc_flag==9 || $pe_vc_flag==12) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1'; }
                            else if($pe_vc_flag==10 || $pe_vc_flag==11) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0'; }

                        if($keyword!="")
                        {
                            $showallsql="SELECT DISTINCT lp.*,inv.InvestorId, inv.Investor
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv,limited_partners as lp  ".$dealtype." 
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry." and Investor like '%$keyword%'   ".$dealcond." $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName";

                            $totalallsql = $exportsql =$showallsql;
                        }
                        elseif($companysearch!="")
                        {
                            $showallsql="SELECT DISTINCT lp.*,inv.InvestorId, inv.Investor
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv,limited_partners as lp   ".$dealtype." 
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry. " and pec.companyname like '%$companysearch%'   ".$dealcond." $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName";

                                $totalallsql = $exportsql =$showallsql;
                            //echo "<br> company search- ".$showallsql;
                        }
                        elseif($sectorsearch!="")
                        {
                                $showallsql="SELECT DISTINCT lp.*inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv,limited_partners as lp  ".$dealtype." 
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry. " and pec.sector_business like '%$sectorsearch%'   ".$dealcond." $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName";

                                $totalallsql = $exportsql =$showallsql;
                            //echo "<br> sector search- ".$showallsql;
                        }
                        elseif($advisorsearch_legal!="")
                        {
                                $showallsql="(SELECT DISTINCT lp.*,inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac,limited_partners as lp  ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)".$dealcond."  and AdvisorType='L'"."
                                     AND adac.PEId = pe.MandAId $comp_industry_id_where)
                                     UNION(SELECT DISTINCT lp.*,inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,limited_partners as lp  ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'  and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners) ".$dealcond."  and AdvisorType='L'"."
                                     AND adac.PEId = pe.MandAId $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName)";

                                $totalallsql = $exportsql =$showallsql;
                            //echo "<br>advisor_legal search- ".$showallsql;
                        }
                        elseif($advisorsearch_trans!="")
                        {
                                $showallsql="(SELECT DISTINCT lp.*,inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac,limited_partners as lp  ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)".$dealcond."  and AdvisorType='T'"."
                                     AND adac.PEId = pe.MandAId $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName)
                                     UNION(SELECT DISTINCT lp.*,inv.InvestorId, inv.Investor
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,limited_partners as lp  ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'  and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners) ".$dealcond."  and AdvisorType='T'"."
                                     AND adac.PEId = pe.MandAId $comp_industry_id_where GROUP BY lp.LPId order by lp.InstitutionName)";

                                $totalallsql = $exportsql =$showallsql;
                            //echo "<br> $advisor_trans search- ".$showallsql;
                        }
                            elseif($tagsearch != ""){
                            $ex_tags = explode(',', $tagsearch);
                                    if (count($ex_tags) > 0) {
                                        for ($l = 0; $l < count($ex_tags); $l++) {
                                            if ($ex_tags[$l] != '') {
                                                $value = trim(str_replace('tag:', '', $ex_tags[$l]));
                                                $value = str_replace(" ", "", $value);
                                               
                                                if ($tagandor == 0) {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " and";
                                                } else {
                                                    $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]" . $value . "[[:>:]]'" . " or";
                                                }
                                            }
                                        }
                                    }

                                    if ($tagandor == 0) {
                                        $tagsval = trim($tags, ' and ');
                                    } else {
                                        $tagsval = trim($tags, ' or ');
                                    }
                                    $showallsql="SELECT DISTINCT lp.*,inv.InvestorId, inv.Investor
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, country as c ,limited_partners as lp  ".$dealtype." 
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                            and  inv.countryid= c.countryid 
                            AND pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry. " and ( $tagsval ) "."  ".$dealcond."  GROUP BY lp.LPId order by lp.InstitutionName";

                                $totalallsql = $exportsql=$showallsql;
                    }
                        elseif($searchallfield!="")
                        {
                            $showallsql="SELECT DISTINCT lp.*,inv.InvestorId, inv.Investor
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, country as c  ,limited_partners as lp ".$dealtype." 
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                            and  inv.countryid= c.countryid 
                            AND pe.Deleted=0 and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry. " and ( inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%' ) "."  ".$dealcond."  GROUP BY lp.LPId order by lp.InstitutionName";

                                $totalallsql = $exportsql=$showallsql;
                            //echo "<br> company search- ".$showallsql;

                        }
                        elseif(($industry > 0) || ($countrytxt != "" && $countrytxt != "--" && $countrytxt != "NIN") || ($countryNINtxt != "" && $countryNINtxt != "---")|| ($cityname != "" && $cityid != "--") || ($investorType!= "") || ($firmtypetxt!= "" && $firmtypetxt != "--") || ($city != "") || ($round != "--" && $round !="") || (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  ) )
                         {
                          $showallsql = "SELECT DISTINCT lp.*,inv.InvestorId, inv.Investor
                                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv ,limited_partners as lp  ".$dealtype." WHERE ";

                            //echo "<br> individual where clauses have to be merged ";
                            if ($industry > 0)
                                    $whereind = " pec.industry=" .$industry ;

                            if ($investorType!= "")
                                    $whereInvType = " pe.InvestorType = '".$investorType."'";

                            if ($countrytxt != "" && $countrytxt != "--" && $countrytxt != "NIN")
                                    $wherecountry = " inv.countryid = '".$countrytxt."'" ;
                                
                            if ($countryNINtxt != "" && $countryNINtxt != "---")
                                    // $wherecountryNIN = " inv.countryid = '".$countryNINtxt."'" ;
                                    {
                                        if($countryNINtxt == 'All'){
                                            $wherecountryNIN = " inv.countryid != 'IN'" ;
                                        } else {
                                            $wherecountryNIN = " inv.countryid = '".$countryNINtxt."'" ;
                                        }
                                    }
                                
                            if ($cityname != "" && $cityid != "--")
                                    $wherecitytxt = " inv.City LIKE '".$cityname."'" ;

                            if ($firmtypetxt!= "" && $firmtypetxt != "--")
                                    $wherefirmtypetxt = " inv.FirmTypeId IN (".$firmtypevalue.")";

                            if($city != "")
                            {
                                   $whereCity=" pec.city LIKE '".$city."'";
                            }
                            

                           if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                           {
                                   $startRangeValue=$startRangeValue;
                                   $endRangeValue=$endRangeValue-0.01;
                                   $qryRangeTitle="Deal Range (M$) - ";
                                   if($startRangeValue < $endRangeValue)
                                   {
                                           $whererange = " pe.DealAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                   }
                                   elseif($startRangeValue = $endRangeValue)
                                   {
                                           $whererange = " pe.DealAmount >= ".$startRangeValue ."";
                                   }
                           }

                          /* if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-01";
                                $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                           }

                           if(($wheredates != "") )
                           {
                                    $showallsql = $showallsql . $wheredates ." and ";
                                    $bool=true;
                           }*/

                            if ($whereind != "")
                            {
                                    $showallsql=$showallsql . $whereind ." and ";

                                    $bool=true;
                            }
                            else
                            {
                                    $bool=false;
                            }

                              if ($wherecountry != "")
                             {
                                     $showallsql=$showallsql . $wherecountry ." and ";
                                     $bool=true;
                             }
                             if ($wherecountryNIN != "")
                             {
                                     $showallsql=$showallsql . $wherecountryNIN ." and ";
                                     $bool=true;
                             }
                             if ($wherecitytxt != "")
                             {
                                     $showallsql=$showallsql . $wherecitytxt ." and ";
                                     $bool=true;
                             }

                            if (($whereInvType != "") )
                            {
                                    $showallsql=$showallsql.$whereInvType . " and ";
                                    $bool=true;
                            }
                            if (($wherefirmtypetxt != "") )
                            {
                                    $showallsql=$showallsql.$wherefirmtypetxt . " and ";
                                    $bool=true;
                            }
                            if (($whererange != "") )
                            {
                                    $showallsql=$showallsql.$whererange . " and ";
                                    $bool=true;
                            }
                            if($whereCity !="")
                            {
                                $showallsql=$showallsql.$whereCity." and ";
                            }

                            $totalallsql = $exportsql = $showallsql. " pe.PECompanyId = pec.PEcompanyId
                                                    AND pec.industry !=15
                                                    AND peinv.MandAId = pe.MandAId
                                                    AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 and Investor!='Others' and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry. " ".$dirsearchall."    ".$dealcond.$comp_industry_id_where."  GROUP BY lp.LPId order by lp.InstitutionName ";  

                            $showallsql = $showallsql. " pe.PECompanyId = pec.PEcompanyId
                                                    AND pec.industry !=15
                                                    AND peinv.MandAId = pe.MandAId
                                                    AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 and Investor!='Others' and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)" .$addVCFlagqry. " " .$search." ".$dirsearchall."    ".$dealcond.$comp_industry_id_where."  GROUP BY lp.LPId order by lp.InstitutionName ";  


                            //echo $showallsql;
                        }
                          else
                         {
                            if($vcflagValue==1)
                            {
                                $joinvctable=" ,peinvestments as pe   ";
                                $vccondition=" and pe.amount<=20 ";
                            }else{
                                $joinvctable="";
                                $vccondition="";
                            }

                            // $showallsql = "select distinct lp.* from limited_partners as lp,peinvestors as inv ".$joinvctable."
                            //  where    inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, REPLACE( inv.LimitedPartners,', ',',')) and lp.Deleted!=1  " .$search.$vccondition. " GROUP BY lp.LPId order by lp.InstitutionName
                            //  ";
                             $showallsql = "select distinct lp.* from limited_partners as lp,peinvestors as inv ".$joinvctable."
                             where    inv.LimitedPartners !='' and lp.Deleted!=1  " .$search.$vccondition. " GROUP BY lp.LPId order by lp.InstitutionName
                             ";
                             $totalallsql=$exportsql=$showallsql;  

                            
                         }
                    }
                    
                    $sql=$getInvestorSql;
                    
                }else{
                    $getInvestorSql = $_POST[ 'sqlquery' ];
                    $sql=$getInvestorSql;
                    $isUpdated = false;
                    if($pe_vc_flag==0 || $pe_vc_flag==1)
                    {
                        $isUpdated = true;
                    } 
                  
                }

              


                
                

              
//                    echo $_REQUEST['txthideinvestorId']."<br>---" .$sql;
//                   exit();
                    //execute query
                   $result = @mysql_query($sql)
                        or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
                   updateDownload($result);

                    //if this parameter is included ($w=1), file returned will be in word format ('.doc')
                    //if parameter is not included, file returned will be in excel format ('.xls')
                    if (isset($w) && ($w==1))
                    {
                        $file_type = "msword";
                        $file_ending = "doc";
                    }
                    else
                    {
                        $file_type = "vnd.ms-excel";
                        $file_ending = "xls";
                    }
                    //header info for browser: determines file type ('.doc' or '.xls')
                    header("Content-Type: application/$file_type");
                    header("Content-Disposition: attachment; filename=$filetitle.$file_ending");
                    header("Pragma: no-cache");
                    header("Expires: 0");

                    /*    Start of Formatting for Word or Excel    */
                    /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */
                           //create title with timestamp:
                    if ($Use_Title == 1)
                    {       echo("$title\n");   }
                        
                    /*echo ("$tsjtitle");
                    print("\n");
                    print("\n");*/

                    //define separator (defines columns in excel & tabs in word)
                    $sep = " \t"; //tabbed character

                    //start of printing column names as names of MySQL fields
                    //-1 to avoid printing of coulmn heading country
                   // for ($i =9; $i < mysql_num_fields($result)-4; $i++)
                   // {
                   //   echo mysql_field_name($result,$i) . "\t";
                   // }
                     echo "Institution Name"."\t";
                    echo "Contact Person"."\t";
                    echo "Designation"."\t";
                    echo "Email"."\t";
                    echo "Address"."\t";
                    echo ""."\t";
                    echo "City"."\t";
                    echo "Pincode"."\t";
                    echo "Country"."\t";
                    echo "Telephone "."\t";
                    echo "Fax"."\t";
                    echo "Website"."\t";
                    echo "TypeOfInstitution"."\t";
                    echo "Investor"."\t";
                    print("\n");

                    /*print("\n");*/
                    //end of printing column names

                    //start while loop to get data
                    /*
                    note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
                    */



                    while($row = mysql_fetch_row($result))
                     {
                         //set_time_limit(60); // HaRa
                         $schema_insert = "";
                         $strStage="";
                         $strIndustry="";
                         $strCompany="";
                         $stripoCompany="";
                         $strmandaCompany="";

                         $InvestorId=$row[0];//investorid

                         $schema_insert .=trim($row[1]).$sep; //LP Name
                                $schema_insert .=trim($row[2]).$sep;//Contact person
                                $schema_insert .=trim($row[3]).$sep;//Designation
//                                $schema_insert .=strip_tags(str_replace(','," ",$row[4])).$sep; //address
//                                $schema_insert .=strip_tags(str_replace(','," ",$row[5])).$sep; //address line 2
                                $schema_insert .=trim($row[4]).$sep; //Email
                                $schema_insert .=trim($row[5]).$sep; //Address1
                                $schema_insert .=trim($row[6]).$sep; //Address2
                                $schema_insert .=trim($row[7]).$sep; //City
                                $schema_insert .=trim($row[8]).$sep; //PinCode
                                $schema_insert .=trim($row[9]).$sep; //Country
                                $schema_insert .=trim($row[10]).$sep; //Phone
                                $schema_insert .=trim($row[11]).$sep; //Fax
                                $schema_insert .= trim($row[12]).$sep; //Website
                                $schema_insert .= trim($row[13]).$sep; //TypeOfInstitution
                                
                                                          

                               
                               
                               
                                    $Investmentsql = "SELECT inv.Investor
                   FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv,limited_partners as lp
                   WHERE peinv.Deleted =0
                   AND c.PECompanyId = peinv.PECompanyId
                   AND c.industry !=15
                   AND i.industryid = c.industry
                   AND lp.LPId = $InvestorId and inv.LimitedPartners !='' and FIND_IN_SET(lp.InstitutionName, inv.LimitedPartners)
                   AND inv.InvestorId = peinv_inv.InvestorId
                   AND peinv.PEId = peinv_inv.PEId
                   group by inv.Investor order by peinv.dates desc"; 
                   
                                    if($rsStage= mysql_query($Investmentsql))
                                    {
                                            While($myStageRow=mysql_fetch_array($rsStage, MYSQL_BOTH))
                                            {
                                                    $strStage=$strStage.", ".$myStageRow["Investor"];
                                            }
                                            $strStage =substr_replace($strStage, '', 0,1);
                                    }
                                    $schema_insert .=$strStage.$sep;
                                 $schema_insert .= ""."\n";
                                //following fix suggested by Josue (thanks, Josue!)
                                //this corrects output in excel when table fields contain \n or \r
                                //these two characters are now replaced with a space
                                $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                         $schema_insert .= "\t";
                         print($schema_insert);
                         print "\n";
                         
                         //} //endof if loop for investorname check         
                        //commented the foll line in order to get printed $ symbol in excel file
                        // $schema_insert = str_replace($sep."$", "", $schema_insert);

                           
                     }

                    print "\n";
                    print "\n";
                    print "\n";
                    print "\n";
                    print "\n";
                    echo ( html_entity_decode( $tsjtitle, ENT_COMPAT, 'ISO-8859-1' ) );
                    print("\n");
                    print("\n");

    /* mail sending area starts*/
                            //mail sending

                $checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM dealmembers AS dm,
                                                            dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
                                                            dm.EmailId='$submitemail' AND dc.Deleted =0";
                    if ($totalrs = mysql_query($checkUserSql))
                    {
                        $cnt= mysql_num_rows($totalrs);
                        //echo "<Br>mail count------------------" .$checkUserSql;
                        if ($cnt==1)
                        {
                            While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
                            {
                                if( date('Y-m-d')<=$myrow["ExpiryDate"])
                                {
                                        $OpenTableTag="<table border=1 cellpadding=1 cellspacing=0 ><td>";
                                        $CloseTableTag="</table>";
                                        $headers  = "MIME-Version: 1.0\n";
                                        $headers .= "Content-type: text/html;
                                        charset=iso-8859-1;Content-Transfer-Encoding: 7bit\n";
                                        /* additional headers
                                        $headers .= "Cc: sow_ram@yahoo.com\r\n"; */
                                        $RegDate=date("M-d-Y");
                                        $to="arun.natarajan@gmail.com,arun@ventureintelligence.com";
                                        //$to="sow_ram@yahoo.com";
                                            $subject="Investor Profile - $filetitle";
                                            $message="<html><center><b><u> Investor Profile :$frmwhichpage - $filetitle - $submitemail</u></b></center><br>
                                            <head>
                                            </head>
                                            <body >
                                            <table border=1 cellpadding=0 cellspacing=0  width=74% >
                                            <tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
                                            <tr><td width=1%>Industry </td><td width=99%>$hideindustrytext</td></tr>
                                            <tr><td width=1%>Stage</td><td width=99%>$hidestagetext</td></tr>
                                            <tr><td width=1%>Investor Type</td><td width=99%>$invtypevalue</td></tr>
                                            <tr><td width=1%>Range</td><td width=99%>$rangeText</td></tr>
                                            <tr><td width=1%>Period</td><td width=99%>$dateValue</td></tr>
                                            <tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
                                            <td width=29%> $CloseTableTag</td></tr>
                                            </table>
                                            </body>
                                            </html>";
                                        mail($to,$subject,$message,$headers);
                                }
                                elseif($myrow["ExpiryDate"] >= date('y-m-d'))
                                {
                                    $displayMessage= $TrialExpired;
                                    $submitemail="";
                                    $submitpassword="";
                                }
                            }
                        }
                        elseif ($cnt==0)
                        {
                            $displayMessage= "Invalid Login / Password";
                            $submitemail="";
                            $submitpassword="";
                        }
                    }
                /* mail sending area ends */


                //      }
                //else
                //  header( 'Location: http://www.ventureintelligence.com/pelogin.php' ) ;

    ?>