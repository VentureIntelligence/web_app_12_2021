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
                    $stageval=substr($_POST['txthidestageid'],1);                  
                    $stageval = explode(',',$stageval);
                    if(isset($stageval)){
                         $boolStage=true;
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
                        if($invname!=""){
                            $filetitle=$invname." - Investor Profile - VI";
                        }else{
                            $filetitle="PE-Investors";
                        }
                       // $filetitle="PE-Investors";
                    }
                    elseif($pe_vc_flag==1)
                    {
                        $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                        if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                             $filetitle="VC-Investors";
                        }
                        //$filetitle="VC-Investors";
                    }
                    elseif($pe_vc_flag==2) //Angel Companies
                    {
                        $addVCFlagqry="";
                        if($invname!=""){
                            $filetitle=$invname." - Investor Profile - VI";
                        }else{
                             $filetitle="Angel-backed-Investors";
                        }
                        //$filetitle="Angel-backed-Investors";
                    }
                    else if($pe_vc_flag==3)
                    {
                        $addVCFlagqry = "";
                        $dbtype="SV";
                        if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                              $filetitle="Social-Venture-Investors";
                        }
                        //$filetitle="Social-Venture-Investors";
                    }
                    else if($pe_vc_flag==4)
                    {
                        $addVCFlagqry = "";
                        $dbtype="CT";
                        if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                             $filetitle="CleanTech-Investments-Investors";
                        }
                        //$filetitle="CleanTech-Investments-Investors";
                    }
                    elseif($pe_vc_flag==5)
                    {
                        $addVCFlagqry = "";
                        $dbtype="IF";
                        if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                             $filetitle="Infrastructure-Investments-Investors";
                        }
                        //$filetitle="Infrastructure-Investments-Investors";
                    }
                    elseif($pe_vc_flag==7) //PE_ipos
                    {
                        $addVCFlagqry="";
                        if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                            $filetitle="PE-backed-IPOInvestors";
                        }
                       // $filetitle="PE-backed-IPOInvestors";
                    }
                    elseif($pe_vc_flag==8) //VC-ipos
                    {
                        $addVCFlagqry="and VCFlag=1";
                        if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                             $filetitle="VC-backed-IPO-Investors";
                        }
                      //  $filetitle="VC-backed-IPO-Investors";
                    }
                    elseif($pe_vc_flag==10) //PE-EXits M&A Companies
                    {
                        $addVCFlagqry="";
                        if($invname!=""){
                            $filetitle=$invname." - Investor Profile - VI";
                        }else{
                            $filetitle="PE-Exits-M&A-Investors";
                        }
                      //  $filetitle="PE-Exits-M&A-Investors";
                    }
                    elseif($pe_vc_flag==11) //VC-EXits M&A Companies
                    {
                        $addVCFlagqry="and VCFlag=1";
                        if($invname!=""){
                            $filetitle=$invname." - Investor Profile - VI";
                        }else{
                            $filetitle="VC-Exits-M&A-Investors";
                        }
                      //  $filetitle="VC-Exits-M&A-Investors";
                    }

                    elseif($pe_vc_flag==9)
                    {
                        $addVCFlagqry="";
                        if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                             $filetitle="PMS";
                        }
                       // $filetitle="PMS";
                    }
                    elseif($pe_vc_flag==12)
                    {
                        $addVCFlagqry="and VCFlag=1";
                        if($invname!=""){
                             $filetitle=$invname." - Investor Profile - VI";
                        }else{
                              $filetitle="VCPMS";
                        }
                      //  $filetitle="VCPMS";
                    }
                if(!isset($_POST[ 'sqlquery' ])){
                
                    if($pe_vc_flag==0 || $pe_vc_flag==1){
                        if($keyword!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec
                                    where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and
                                    pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
                                    
                                    $getInvestorSql=$showallsql;
                                //echo "<br> Investor search 0 or 1- ".$showallsql;
                            }
                            elseif($companysearch!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec
                                    where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and
                                    pe.Deleted=0 " .$addVCFlagqry. " and pec.companyname like '%$companysearch%' order by inv.Investor ";
                                    
                                    $getInvestorSql=$showallsql;
                                //echo "<br> company search-0 or 1 ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec
                                    where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and
                                    pe.Deleted=0 " .$addVCFlagqry. " and pec.sector_business like '%$sectorsearch%' order by inv.Investor ";
                                    
                                   $getInvestorSql=$showallsql;
                                //echo "<br> sector search 0 or 1- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                    $showallsql="(select distinct peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 
                                        " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' order by inv.Investor )
                                        UNION(select distinct peinv.InvestorId,inv.Investor,inv.* 
                                        from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, advisor_cias AS cia,
                                        peinvestments_advisorcompanies AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.StageId=s.StageId and 
                                        pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 " .$addVCFlagqry. "
                                        and cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='L' order by inv.Investor )";
                                    
                                    $getInvestorSql=$showallsql;
                                //echo "<br>advisor_legal search 0 or 1- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                    $showallsql="(select distinct peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 
                                        " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' order by inv.Investor )
                                        UNION(select distinct peinv.InvestorId,inv.Investor,inv.* 
                                        from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, advisor_cias AS cia,
                                        peinvestments_advisorcompanies AS adac where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.StageId=s.StageId and 
                                        pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and pe.Deleted=0 " .$addVCFlagqry. "
                                        and cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='T' order by inv.Investor )";
                                    
                                   $getInvestorSql=$showallsql;
                                //echo "<br> $advisor_trans search 0 or 1- ".$showallsql;
                            }elseif($searchallfield!=""){
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
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, country as c
                                    where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and inv.countryid= c.countryid and 
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and
                                    pe.Deleted=0 " .$addVCFlagqry. " and ( $tagsval ) order by inv.Investor ";
                                    
                                    $getInvestorSql=$showallsql;                                
                            }
                            else
                            {
                           
                                if(isset($_REQUEST['txthideinvestorId']) && $_REQUEST['txthideinvestorId']!=''){
                                $InvestorId = $_REQUEST['txthideinvestorId'];    
                                $showallsql = "select distinct peinv.InvestorId,inv.Investor,inv.*
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv
                                where  inv.InvestorId='$InvestorId' AND ";
                                }
                                else
                                {
                                    $showallsql = "select distinct peinv.InvestorId,inv.Investor,inv.*
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv
                                where ";
                                }
                            //echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                            if($stage !=''){
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                            }
                                        }
                                        if($stageidvalue !=''){
                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;
                                        }
                                }
                                //
                                
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
                               
                                if($dt1!='' && $dt2!=''){

                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                                }
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
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                                if(($wheredates !== "") )
                                {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                                }
                                
                                $showallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15 and
                                pe.Deleted=0 " .$addVCFlagqry. " order by inv.Investor ";
                                
                                $getInvestorSql=$showallsql;
                                        
                                //echo $showallsql;
                            }
                    }
                    else if($pe_vc_flag==2)
                    {
                       
                           if($keyword!="")
                            {
                                    $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                        WHERE pe.InvesteeId = pec.PEcompanyId
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
                                    
                                    $showallsql = $showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            else
                            {
                                    $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                        WHERE pe.InvesteeId = pec.PEcompanyId
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall." order by inv.Investor ";
                                    
                                    $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                        WHERE pe.InvesteeId = pec.PEcompanyId
                                        AND pec.industry !=15
                                        AND peinv.AngelDealId = pe.AngelDealId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND pe.Deleted=0 " .$addVCFlagqry. " ".$dirsearchall." order by inv.Investor ";
                            }
                       
                            
                      $getInvestorSql=$showallsql;      
                           
                       
                    }
                    elseif($pe_vc_flag==3 || $pe_vc_flag==4 || $pe_vc_flag==5){
                        
                        if($keyword!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
                                //echo "<br> Investor search- ".$showallsql;
                                    $getInvestorSql=$showallsql;
                                    
                            }
                            elseif($companysearch!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry. " and pec.companyname like '%$companysearch%' order by inv.Investor ";
                                    
                                   $getInvestorSql=$showallsql;
                               // echo "<br> company search- ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry. " and pec.sector_business like '%$sectorsearch%' order by inv.Investor ";
                                    
                                   $getInvestorSql=$showallsql;
                                //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                    $showallsql="(select distinct peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac,peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 
                                        " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' order by inv.Investor)
                                        UNION(select distinct peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorcompanies AS adac,peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 
                                        " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' order by inv.Investor)";
                                    
                                    $getInvestorSql=$showallsql;
                                //echo "<br>advisor_legal search- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                   $showallsql="(select distinct peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorinvestors AS adac,peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 
                                        " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' order by inv.Investor)
                                        UNION(select distinct peinv.InvestorId,inv.Investor,inv.* from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,
                                        pecompanies as pec, advisor_cias AS cia,peinvestments_advisorcompanies AS adac,peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and 
                                        pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15 and
                                        pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and pe.Deleted=0 
                                        " .$addVCFlagqry. " and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' order by inv.Investor)";
                                    
                                    $getInvestorSql=$showallsql;
                                //echo "<br> $advisor_trans search- ".$showallsql;
                            }elseif($searchallfield!="")
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
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, country as c,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and inv.countryid= c.countryid and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry. " and ( $tagsval ) order by inv.Investor ";
                                    
                                   $getInvestorSql=$showallsql;
                               // echo "<br> company search- ".$showallsql;
                            }
                            else
                            {
                              $showallsql = "select distinct peinv.InvestorId,inv.Investor,inv.*
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,
                                peinvestments_dbtypes as pedb where ";

                            //echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                                if ($boolStage==true)
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        foreach($stageval as $stage)
                                        {
                                            if($stage !=''){
                                                //echo "<br>****----" .$stage;
                                                $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                $stageidvalue=$stageidvalue.",".$stage;
                                            }
                                        }

                                        if($stageidvalue !=''){
                                        $wherestage = $stagevalue ;
                                        $qryDealTypeTitle="Stage  - ";
                                        $strlength=strlen($wherestage);
                                        $strlength=$strlength-3;
                                //echo "<Br>----------------" .$wherestage;
                                $wherestage= substr ($wherestage , 0,$strlength);
                                $wherestage ="(".$wherestage.")";
                                //echo "<br>---" .$stringto;
                                        }
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
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates != "") )
                               {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                               }
             
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
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                $showallsql = $showallsql. " pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall."  order by inv.Investor ";
                                
                               $getInvestorSql=$showallsql;
                            }
                        
                    }
                    elseif($pe_vc_flag==7 || $pe_vc_flag==8){
                        
                        if($keyword!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                WHERE pe.PECompanyId = pec.PEcompanyId
                AND pec.industry !=15
                AND peinv.IPOId = pe.IPOId
                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";
                                
                                $getInvestorSql=$showallsql;
                                 //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($companysearch!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                WHERE pe.PECompanyId = pec.PEcompanyId
                AND pec.industry !=15
                AND peinv.IPOId = pe.IPOId
                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 " .$addVCFlagqry. " and pec.companyname like '%$companysearch%' order by inv.Investor ";
                                
                                $getInvestorSql=$showallsql;
                                 //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                WHERE pe.PECompanyId = pec.PEcompanyId
                AND pec.industry !=15
                AND peinv.IPOId = pe.IPOId
                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 " .$addVCFlagqry. " and pec.sector_business like '%$sectorsearch%' order by inv.Investor ";
                                
                                $getInvestorSql=$showallsql;
                                 //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($searchallfield!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv, country as c
                WHERE pe.PECompanyId = pec.PEcompanyId
                AND pec.industry !=15
                AND peinv.IPOId = pe.IPOId
                AND inv.InvestorId = peinv.InvestorId AND  inv.countryid= c.countryid
                AND pe.Deleted=0 " .$addVCFlagqry. " and ( inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%' ) order by inv.Investor ";
                                
                                $getInvestorSql=$showallsql;
                                // echo "<br> sector search- ".$showallsql;
                            }
                            else
                            {
                             $showallsql = "SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                WHERE ";

                            //echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                               if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                               {
                                       $startRangeValue=$startRangeValue;
                                       $endRangeValue=$endRangeValue-0.01;
                                       $qryRangeTitle="Deal Range (M$) - ";
                                       if($startRangeValue < $endRangeValue)
                                       {
                                               $whererange = " pe.IPOAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.IPOAmount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
                                    $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "'";
                               }
                               
                               if(($wheredates != "") )
                               {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";
                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                 
                                $showallsql = $showallsql. " pe.PECompanyId = pec.PEcompanyId
                AND pec.industry !=15
                AND peinv.IPOId = pe.IPOId
                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 " .$addVCFlagqry. "  order by inv.Investor ";
                                
                                $getInvestorSql=$showallsql;
                            }
                        
                    }
                    elseif($pe_vc_flag==9 || $pe_vc_flag==10 || $pe_vc_flag==11 || $pe_vc_flag==12){
                        
                            $dealtype=' , dealtypes as dt '; 
                            if($pe_vc_flag==9 || $pe_vc_flag==12) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1'; }
                            else if($pe_vc_flag==10 || $pe_vc_flag==11) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0'; }
                        
                        if($keyword!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv  ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%'   ".$dealcond."  order by inv.Investor";
                                
                                $getInvestorSql=$showallsql;
                            }
                            elseif($companysearch!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv  ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 " .$addVCFlagqry. " and pec.companyname like '%$companysearch%'   ".$dealcond."  order by inv.Investor";
                                    
                                    $getInvestorSql=$showallsql;
                                //echo "<br> company search- ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                    $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv  ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND pec.industry !=15
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND pe.Deleted=0 " .$addVCFlagqry. " and pec.sector_business like '%$sectorsearch%'   ".$dealcond."  order by inv.Investor";
                                    
                                    $getInvestorSql=$showallsql;
                                //echo "<br> sector search- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                    $showallsql="(SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac  ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND pec.industry !=15
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   ".$dealcond."  and AdvisorType='L'
                                         AND adac.PEId = pe.MandAId)
                                         UNION(SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac  ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND pec.industry !=15
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   ".$dealcond."  and AdvisorType='L'
                                         AND adac.PEId = pe.MandAId)";
                                    
                                    $getInvestorSql=$showallsql;
                                //echo "<br>advisor_legal search- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                    $showallsql="(SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac  ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND pec.industry !=15
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='T'
                                         AND adac.PEId = pe.MandAId)
                                         UNION(SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac  ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND pec.industry !=15
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='T'
                                         AND adac.PEId = pe.MandAId)";
                                    
                                     $getInvestorSql=$showallsql;
                                //echo "<br> $advisor_trans search- ".$showallsql;
                            }
                            elseif($searchallfield!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, country as c  ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId AND  inv.countryid= c.countryid
                                AND pe.Deleted=0 " .$addVCFlagqry. " and ( inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%' ) ".$dealcond."  order by inv.Investor";
                                    
                                    $getInvestorSql=$showallsql;
                                //echo "<br> company search- ".$showallsql;
                            }
                            else
                            {
                              $showallsql = "SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv   ".$dealtype."   WHERE ";

                            //echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
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
                               
                               if($dt1!='' && $dt2!=''){
                                   
                                    $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                                   
                               }
                               
                               if(($wheredates != "") )
                               {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                               
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                               
                                
                                $showallsql = $showallsql. " pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                AND pe.Deleted=0 " .$addVCFlagqry. "   ".$dealcond."  order by inv.Investor ";  
                                
                                $getInvestorSql=$showallsql;
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

                if( $dt1 != '' && $dt2 != '' ) {
                    $pevcInvestmentWhere = " and peinv.dates between '" . $dt1. "' and '" . $dt2 . "'";
                    $IPOInvestmentWhere = " and peinv.IPODate between '" . $dt1. "' and '" . $dt2 . "'";
                    $MAInvestmentWhere = " and peinv.DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                } else {
                    $pevcInvestmentWhere = '';
                    $IPOInvestmentWhere = '';
                    $MAInvestmentWhere = '';
                }

                if( $dt1 != '' && $dt2 != '' ) {
                    $wheredate = " dates between '" . $dt1. "' and '" . $dt2 . "'";
                } else {
                    $wheredate = '';
                }

                if($industry > 0){
                    $ind_where = " and i.industryid = '$industry' ";
                }else{
                    $ind_where = "";                                    
                }

                // $sql= "select distinct peinv.InvestorId,inv.Investor,inv.* , 
                // GROUP_CONCAT(distinct i.industry SEPARATOR ', ') as industry ,
                // GROUP_CONCAT(distinct s.Stage SEPARATOR ', ') as Stage , 
                // (select country from country  where countryid = inv.countryid) as Countryname ,
                // (select focuscapsource from focus_capitalsource where focuscapsourceid = inv.focuscapsourceid) as focuscapsource,
                // SUM(peinv.Amount_M) as total_amount
                // from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv ,industry AS i
                // where ".$wheredate." ".$ind_where." and pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId 
                // and pe.StageId=s.StageId and pec.industry!=15 and pe.Deleted=0 AND i.industryid = pec.industry and Investor!='Others' 
                // AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) 
                // GROUP BY peinv.InvestorId order by inv.Investor";
                    
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
                    echo "Investor"."\t";
                    echo "Address"."\t";
                    echo ""."\t";
                    echo "City"."\t";
                    /*echo "Country"."\t";*/
                    echo "Country (Headquarters)"."\t";
                    echo "Zip"."\t";

                    echo "Telephone "."\t";
                    echo "Fax"."\t";
                    echo "Email"."\t";
                    echo "Website"."\t";
                    echo "Description"."\t";
                    echo "In India Since"."\t";
                    echo "Management"."\t";
                   echo "Firm Type"."\t";
                    if($pe_vc_flag!=2){
                        
                        
                        echo "Focus and Capital Source"."\t";
                        echo "Other Location(s)"."\t";
                        echo "Assets Under Management (US $M)"."\t";
                        echo "Already Invested Management (US $M)"."\t";
                        if($dry_powder_hide == 0){
                        echo "Dry Powder (US $M)"."\t";
                        }
                        echo "Stage of Funding (Existing Investments)"."\t";
                        echo "Limited Partners"."\t";
                        echo "Number of Funds"."\t";
                        echo "Additional Info"."\t";
                        echo "Industry (Existing Investments)"."\t";
                        if($_POST['showprofile'] == 0){
                            echo "PE/VC Investments"."\t";
                            echo "Exits - IPO"."\t";
                            echo "Exits - M&A"."\t";
                            echo "Social Venture Investments"."\t";
                            echo "Cleantech Investments"."\t";
                            echo "Infrastructure Investments"."\t";
                        }
                    }
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

                         $Investorname=$row[1];
                         $Investorname=strtolower($Investorname);

                         $invResult=substr_count($Investorname,$searchString);
                         $invResult1=substr_count($Investorname,$searchString1);
                         $invResult2=substr_count($Investorname,$searchString2);
                         if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                         {
                                $schema_insert .=trim($row[1]).$sep; //Investorname
//                                $schema_insert .=strip_tags(str_replace(','," ",$row[4])).$sep; //address
//                                $schema_insert .=strip_tags(str_replace(','," ",$row[5])).$sep; //address line 2
                                $schema_insert .=trim($row[4]).$sep; //address
                                $schema_insert .=trim($row[5]).$sep; //address line 2
                                $schema_insert .=trim($row[6]).$sep; //city

                                if($isUpdated == true){
                                    $schema_insert .=trim($row[35]).$sep; //country
                                } else {
                                    $txtcountryid= $row[27]; //countryid
                                            $countrysql="select country from country where countryid='$txtcountryid'";
                                            if($rscountry= mysql_query($countrysql))
                                            {
                                            While($mycountryrow=mysql_fetch_array($rscountry, MYSQL_BOTH))
                                                    {
                                                            $countryname=$mycountryrow["country"];
                                                    }
                                            }
                                    $schema_insert .=trim($countryname).$sep; //country
                                }

                                $schema_insert .=trim($row[7]).$sep; //zip
                                $schema_insert .=trim($row[8]).$sep; //Telephone
                                $schema_insert .=trim($row[9]).$sep; //Fax
                                $schema_insert .=trim($row[10]).$sep; //Email
                                $schema_insert .=trim($row[11]).$sep; //Website
                                $schema_insert .= trim($row[13]).$sep; //Description
                                $schema_insert .= trim($row[14]).$sep; //Year founded
                                

                                // $onMgmtSql="select pec.InvestorId,mgmt.InvestorId,mgmt.ExecutiveId,
                                // exe.ExecutiveName,exe.Designation,exe.Company from
                                // peinvestors as pec,executives as exe,peinvestors_management as mgmt
                                // where pec.InvestorId=$InvestorId and mgmt.InvestorId=pec.InvestorId and exe.ExecutiveId=mgmt.ExecutiveId";
                                // if($rsMgmt= mysql_query($onMgmtSql))
                                // {
                                //         $MgmtTeam="";
                                //         While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                                //         {
                                //                 $Exename= $mymgmtrow["ExecutiveName"];
                                //                 $Designation=$mymgmtrow["Designation"];
                                //                 if($Designation!="")
                                //                         $MgmtTeam=$MgmtTeam.";".$Exename.",".$Designation;
                                //                 else
                                //                         $MgmtTeam=$MgmtTeam.";".$Exename;
                                //         }
                                //         $MgmtTeam=substr_replace($MgmtTeam, '', 0,1);
                                // }
                                // $schema_insert .=$MgmtTeam.$sep; //Management Team

                                $onMgmtSql = mysql_query("select CONCAT(exe.ExecutiveName,',',exe.Designation) as ExecutiveMgmt
                                from peinvestors as pec,executives as exe,peinvestors_management as mgmt
                                where pec.InvestorId=$InvestorId and mgmt.InvestorId=pec.InvestorId and exe.ExecutiveId=mgmt.ExecutiveId");
                                    $MgmtTeam = mysql_fetch_array($onMgmtSql);
                                
                                    
                                $schema_insert .=rtrim($MgmtTeam['ExecutiveMgmt'],',').$sep;  //Management Team
                                $firm_typeId      = $row[29];
                                $firm_typesql      = "SELECT FirmType FROM firmtypes where FirmTypeId='$firm_typeId'";
                                if ($rsfirm_type = mysql_query($firm_typesql)) {
                                    While ($myfirm_typerow = mysql_fetch_array($rsfirm_type, MYSQL_BOTH)) {
                                        $firm_typename = $myfirm_typerow["FirmType"];
                                    }
                                }
                                $schema_insert .= $firm_typename.$sep; //FirmType
                                
                            if($pe_vc_flag!=2){

                                if($isUpdated == true){
                                    $schema_insert .=$row[36].$sep; // focuscapsource
                                } else {
                                    //$schema_insert .=$row[30].$sep;
                                    if ($row[30] != "" && $row[30] > 0) { 
                                        $res = mysql_query("select focuscapsource from focus_capitalsource where focuscapsourceid=".$row[30]);
                                        $focusrow = mysql_fetch_array($res);
                                        $schema_insert .=$focusrow['focuscapsource'].$sep;
                                    }
                                    else{
                                        $schema_insert .=''.$sep;
                                    }
                                }

                                $schema_insert .=$row[17].$sep; //Other Location
                                $assets_management=$row[18];

                                 $schema_insert .=$assets_management.$sep; //Assets under managment

                                // if($isUpdated == true){
                                //     $investor_amount = $row[37];
                                // } else {
                                //     $getinvestorAmount = "select SUM(peinvestments_investors.Amount_M) as total_amount FROM peinvestments 
                                //     JOIN peinvestments_investors ON peinvestments_investors.PEId = peinvestments.PEId 
                                //     JOIN pecompanies ON pecompanies.PECompanyId = peinvestments.PECompanyId 
                                //     where peinvestments_investors.InvestorId = ".$InvestorId." and peinvestments_investors.exclude_dp = 0 AND peinvestments.Deleted=0 AND 
                                //     peinvestments.AggHide=0 and peinvestments.SPV = 0 and pecompanies.industry !=15 AND 
                                //     peinvestments.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 )";
                                //     $investor_amount='';
                                //     $investoramountrs = mysql_query($getinvestorAmount);
                                //     $investorrowrow = mysql_fetch_row($investoramountrs, MYSQL_BOTH);
                                //     $investor_amount = $investorrowrow['total_amount'];
                                // }

                                $getinvestorAmount = "select SUM(peinvestments_investors.Amount_M) as total_amount FROM peinvestments 
                                    JOIN peinvestments_investors ON peinvestments_investors.PEId = peinvestments.PEId 
                                    JOIN pecompanies ON pecompanies.PECompanyId = peinvestments.PECompanyId 
                                    where peinvestments_investors.InvestorId = ".$InvestorId." and peinvestments_investors.exclude_dp = 0 AND peinvestments.Deleted=0 AND 
                                    peinvestments.AggHide=0 and peinvestments.SPV = 0 and pecompanies.industry !=15 AND 
                                    peinvestments.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 )";
                                    $investor_amount='';
                                    $investoramountrs = mysql_query($getinvestorAmount);
                                    $investorrowrow = mysql_fetch_row($investoramountrs, MYSQL_BOTH);
                                    $investor_amount = $investorrowrow['total_amount'];
                               
                                if($assets_management!=''){
                                   $Assets_mgmt = (int)preg_replace("/[^0-9\.]/", '', $assets_management);
                                }else{
                                    $Assets_mgmt = 0;
                                }
                                    
                                $schema_insert .=$investor_amount.$sep; //Invested Amount
                               
                                if($row[32] == 0){
                                $schema_insert .=($Assets_mgmt-$investor_amount).$sep; //Dry Powder
                                }else{
                                    $schema_insert .= ''.$sep; //Dry Powder
                                }

                                if($isUpdated == true){
                                    $schema_insert .=$row[34].$sep; //Preferred Stage of funding
                                } else {
                                    $stageSql= "select distinct s.Stage,pe.StageId,peinv_inv.InvestorId
                                    from peinvestments_investors as peinv_inv,peinvestors as inv,peinvestments as pe,stage as s
                                    where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId
                                    and pe.PEId=peinv_inv.PEId and s.StageId=pe.StageId order by Stage ";
                                    if($rsStage= mysql_query($stageSql))
                                    {
                                            While($myStageRow=mysql_fetch_array($rsStage, MYSQL_BOTH))
                                            {
                                                    $strStage=$strStage.", ".$myStageRow["Stage"];
                                            }
                                            $strStage =substr_replace($strStage, '', 0,1);
                                    }
                                    $schema_insert .=$strStage.$sep; //Preferred Stage of funding
                                }

                                $schema_insert .=$row[21].$sep; //Limited Partners
                                $schema_insert .=$row[22].$sep; //Number of funds
                                $schema_insert .=$row[25].$sep; //Addtional Info
                                
                                if($isUpdated == true){
                                    $schema_insert .=$row[33].$sep; //Industry for Existing investments
                                } else {
                                    $indSql= " SELECT DISTINCT i.industry as ind, c.industry, peinv_inv.InvestorId
                                            FROM peinvestments_investors AS peinv_inv, peinvestors AS inv, pecompanies AS c, peinvestments AS peinv, industry AS i
                                            WHERE peinv_inv.InvestorId = $InvestorId
                                            AND inv.InvestorId = peinv_inv.InvestorId
                                            AND c.PECompanyId = peinv.PECompanyId
                                            AND peinv.PEId = peinv_inv.PEId  and i.industryid!=15
                                            AND i.industryid = c.industry and peinv.Deleted=0 $ind_where order by i.industry";

                                            if($rsInd= mysql_query($indSql))
                                            {
                                                    While($myIndrow=mysql_fetch_array($rsInd, MYSQL_BOTH))
                                                    {
                                                            $strIndustry=$strIndustry.", ".$myIndrow["ind"];
                                                    }
                                                    $strIndustry =substr_replace($strIndustry, '', 0,1);
                                            }

                                    $schema_insert .=$strIndustry.$sep; //Industry for Existing investments
                                }

                            if($_POST['showprofile'] == 0){

                                $Investmentsql="SELECT distinct peinv_inv.InvestorId, peinv_inv.PEId, peinv.PECompanyId, pec.industry,i.industry as indname, 
                                DATE_FORMAT( peinv.dates, '%b-%y' ) AS dealperiod, inv . * , peinv.AggHide, peinv.Exit_Status , 
                                GROUP_CONCAT(distinct pec.companyname,
                                    '(',i.industry,';',DATE_FORMAT( peinv.dates, '%b-%y' ),';',
                                        CASE 
                                            WHEN peinv.AggHide = 1 THEN ' Tranche;'
                                            ELSE '' 
                                        END,
                                        CASE 
                                            WHEN peinv.Exit_Status = 1 THEN 'Unexited' 
                                            WHEN peinv.Exit_Status = 2 THEN 'Partially Exited' 
                                            WHEN peinv.Exit_Status = 3 THEN 'Fully Exited'
                                            ELSE 'Unexited' 
                                        END,
                                    ')' order by peinv.dates desc) as PEinvets
                                FROM peinvestments AS peinv
                                JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = peinv.PEId
                                JOIN pecompanies AS pec ON pec.PECompanyId = peinv.PECompanyId
                                JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                                JOIN industry AS i ON i.industryid = pec.industry
                                WHERE peinv_inv.InvestorId = $InvestorId " . $pevcInvestmentWhere . " AND peinv.Deleted =0 AND pec.industry !=15 
                                $ind_where AND peinv.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId='$dbTypeSV' and hide_pevc_flag=1)";

                                $getcompanyinvrs = mysql_query($Investmentsql);
                                $PEinvets = mysql_fetch_array($getcompanyinvrs);
                                $schema_insert .=$PEinvets['PEinvets'].$sep; // Existing Investments with deal date

                                $IPOInvestmentsql="SELECT peinv_inv.InvestorId,peinv_inv.IPOId,peinv.PECompanyId,pec.companyname,pec.industry,i.industry as indname,DATE_FORMAT( peinv.IPODate, '%b-%y' ) as dealperiod,peinv.ExitStatus,inv.*,
                                GROUP_CONCAT(distinct pec.companyname,
                                    '(',i.industry,';',DATE_FORMAT( peinv.IPODate, '%b-%y' ),';',
                                        CASE 
                                            WHEN peinv.ExitStatus = 0 THEN 'Partial Exit' 
                                            WHEN peinv.ExitStatus = 1 THEN 'Complete Exit'
                                            ELSE '' 
                                        END,
                                    ')' order by peinv.IPODate desc) as IPOinvets
                                FROM ipos AS peinv
                                JOIN ipo_investors AS peinv_inv ON peinv_inv.IPOId = peinv.IPOId
                                JOIN pecompanies AS pec ON pec.PECompanyId = peinv.PECompanyId
                                JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                                JOIN industry AS i ON i.industryid = pec.industry
                                WHERE peinv_inv.InvestorId = $InvestorId  " . $IPOInvestmentWhere . " AND peinv.Deleted =0 $ind_where"; 

                                $getcompanyIPO = mysql_query($IPOInvestmentsql);
                                $IPOinvets = mysql_fetch_array($getcompanyIPO);
                                $schema_insert .=$IPOinvets['IPOinvets'].$sep; // Existing IPO Exits with deal date

                                $MAInvestmentsql="SELECT peinv_inv.InvestorId,peinv_inv.MandAId,peinv.PECompanyId,peinv.DealTypeId, dt.DealType,pec.companyname,pec.industry, i.industry as indname,DATE_FORMAT( peinv.DealDate, '%b-%y' )as dealperiod,peinv.ExitStatus,inv.*,
                                GROUP_CONCAT(distinct pec.companyname,
                                    '(',i.industry,';',DATE_FORMAT( peinv.DealDate, '%b-%y' ),';',
                                        CASE 
                                            WHEN peinv.ExitStatus = 0 THEN 'Partial Exit' 
                                            WHEN peinv.ExitStatus = 1 THEN 'Complete Exit'
                                            ELSE '' 
                                        END,
                                    ')'  order by peinv.DealDate desc) as MandAinvets
                                FROM manda AS peinv
                                JOIN manda_investors AS peinv_inv ON peinv_inv.MandAId = peinv.MandAId
                                JOIN pecompanies AS pec ON pec.PECompanyId = peinv.PECompanyId
                                JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                                JOIN dealtypes AS dt ON peinv.DealTypeId=dt.DealTypeId
                                JOIN industry AS i ON i.industryid = pec.industry
                                WHERE peinv_inv.InvestorId = $InvestorId " . $MAInvestmentWhere . " AND peinv.Deleted =0 $ind_where";

                                $getcompanyMA = mysql_query($MAInvestmentsql);
                                $MandAinvets = mysql_fetch_array($getcompanyMA);
                                $schema_insert .=$MandAinvets['MandAinvets'].$sep; // Existing M&A Exits with deal date
                                
                                $SVInvestmentsql="SELECT distinct peinv.PECompanyId, pec.companyname, pec.industry, i.industry AS indname, peinv_inv.InvestorId,
                                peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod,peinv.AggHide,SPV,peinv.Exit_Status , 
                                GROUP_CONCAT(distinct pec.companyname,
                                    '(',i.industry,';',DATE_FORMAT( peinv.dates, '%b-%y' ),';',
                                        CASE 
                                            WHEN peinv.AggHide = 1 THEN ' Tranche;'
                                            ELSE '' 
                                        END,
                                        CASE 
                                            WHEN SPV = 1 THEN ' Debt;'
                                            ELSE '' 
                                        END,
                                        CASE 
                                            WHEN peinv.Exit_Status = 1 THEN 'Unexited' 
                                            WHEN peinv.Exit_Status = 2 THEN 'Partially Exited' 
                                            WHEN peinv.Exit_Status = 3 THEN 'Fully Exited'
                                            ELSE 'Unexited' 
                                        END,
                                    ')' order by peinv.dates desc) as SVinvets
                                FROM peinvestments AS peinv
                                JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = peinv.PEId
                                JOIN pecompanies AS pec ON pec.PECompanyId = peinv.PECompanyId
                                JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                                JOIN industry AS i ON i.industryid = pec.industry
                                WHERE peinv_inv.InvestorId = $InvestorId " . $pevcInvestmentWhere . " AND peinv.Deleted =0 AND pec.industry !=15 
                                $ind_where AND peinv.PEId IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId='$dbTypeSV')";

                                $getcompanySV = mysql_query($SVInvestmentsql);
                                $SVinvets = mysql_fetch_array($getcompanySV);
                                $schema_insert .=$SVinvets['SVinvets'].$sep; // Existing SV Investments with deal date

                                $CTInvestmentsql="SELECT peinv.PECompanyId, pec.companyname, pec.industry, i.industry AS indname, peinv_inv.InvestorId, peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod,peinv.Exit_Status,
                                GROUP_CONCAT(distinct pec.companyname,
                                    '(',i.industry,';',DATE_FORMAT( peinv.dates, '%b-%y' ),';',
                                        CASE 
                                            WHEN peinv.Exit_Status = 1 THEN 'Unexited' 
                                            WHEN peinv.Exit_Status = 2 THEN 'Partially Exited' 
                                            WHEN peinv.Exit_Status = 3 THEN 'Fully Exited'
                                            ELSE 'Unexited' 
                                        END,
                                    ')' order by peinv.dates desc) as CTinvets
                                FROM peinvestments AS peinv
                                JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = peinv.PEId
                                JOIN pecompanies AS pec ON pec.PECompanyId = peinv.PECompanyId
                                JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                                JOIN industry AS i ON i.industryid = pec.industry
                                WHERE peinv_inv.InvestorId = $InvestorId " . $pevcInvestmentWhere . " AND peinv.Deleted =0 AND pec.industry !=15 
                                $ind_where AND peinv.PEId IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId='$dbTypeCT')";

                                $getcompanyCT = mysql_query($CTInvestmentsql);
                                $CTinvets = mysql_fetch_array($getcompanyCT);
                                $schema_insert .=$CTinvets['CTinvets'].$sep; // Existing CT Investments with deal date


                                $IFInvestmentsql="SELECT peinv.PECompanyId, pec.companyname, pec.industry, i.industry AS indname, peinv_inv.InvestorId, peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod,peinv.Exit_Status , 
                                GROUP_CONCAT(distinct pec.companyname,
                                    '(',i.industry,';',DATE_FORMAT( peinv.dates, '%b-%y' ),';',
                                        CASE 
                                            WHEN peinv.Exit_Status = 1 THEN 'Unexited' 
                                            WHEN peinv.Exit_Status = 2 THEN 'Partially Exited' 
                                            WHEN peinv.Exit_Status = 3 THEN 'Fully Exited'
                                            ELSE 'Unexited' 
                                        END,
                                    ')' order by peinv.dates desc) as IFinvets
                                FROM peinvestments AS peinv
                                JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = peinv.PEId
                                JOIN pecompanies AS pec ON pec.PECompanyId = peinv.PECompanyId
                                JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                                JOIN industry AS i ON i.industryid = pec.industry
                                WHERE peinv_inv.InvestorId = $InvestorId " . $pevcInvestmentWhere . " AND peinv.Deleted =0 AND pec.industry !=15 
                                $ind_where AND peinv.PEId IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId='$dbTypeIF')";

                                $getcompanyIF = mysql_query($IFInvestmentsql);
                                $IFinvets = mysql_fetch_array($getcompanyIF);
                                $schema_insert .=$IFinvets['IFinvets'].$sep; // Existing IF Investments with deal date
                                
                               /* $Investmentsql="select peinv_inv.InvestorId,peinv_inv.PEId,peinv.PECompanyId,
                                                c.companyname,c.industry,i.industry as indname,
                                                DATE_FORMAT( peinv.dates, '%b-%y' )as dealperiod,inv.*,peinv.AggHide,peinv.Exit_Status
                                                from peinvestments_investors as peinv_inv,peinvestors as inv,
                                                peinvestments as peinv,pecompanies as c,industry as i
                                                where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId
                                                and peinv.PEId=peinv_inv.PEId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0
                                                and c.industry!=15 $ind_where and c.PECompanyId=peinv.PECompanyId and i.industryid=c.industry
                                                " . $pevcInvestmentWhere . "
                                                AND peinv.PEId NOT
                                                IN (
                                                SELECT PEId
                                                FROM peinvestments_dbtypes AS db
                                                WHERE DBTypeId='$dbTypeSV' and hide_pevc_flag=1
                                                )
                                                order by peinv.dates desc";
                                if ($getcompanyinvrs = mysql_query($Investmentsql))
                                {
                                        While($myInvestrow=mysql_fetch_array($getcompanyinvrs, MYSQL_BOTH))
                                        {
                                                $companyName=trim($myInvestrow["companyname"]);
                                                $companyName=strtolower($companyName);
                                                $compResult=substr_count($companyName,$searchString);
                                                $compResult1=substr_count($companyName,$searchString1);
                                                if($myInvestrow["AggHide"]==1)
                                                        $addTrancheWord="; Tranche";
                                                else
                                                        $addTrancheWord="";

                                                        if($myInvestrow['Exit_Status']==1){
                                                            $exitstatusis='Unexited';
                                                        }
                                                        else if($myInvestrow['Exit_Status']==2){
                                                            $exitstatusis='Partially Exited';
                                                        }
                                                        else if($myInvestrow['Exit_Status']==3){
                                                            $exitstatusis='Fully Exited';
                                                        }
                                                        else{
                                                            $exitstatusis='Unexited';
                                                        }

                                                if(($compResult==0) && ($compResult1==0))
                                                        $compdisplay=$myInvestrow["companyname"];
                                                else
                                                        $compdisplay= $searchStringDisplay;

                                                        $strCompany=$strCompany.",".$compdisplay."(".$myInvestrow["indname"].";".$myInvestrow["dealperiod"].$addTrancheWord.";".$exitstatusis.")";
                                        }
                                }
                                        $strInvestments =substr_replace($strCompany, '', 0,1);
                                        $schema_insert .=$strInvestments.$sep;  // Existing Investments with deal date

                                        $iposql="select peinv_inv.InvestorId,peinv_inv.IPOId,peinv.PECompanyId,
                                                                        c.companyname,c.industry,i.industry as indname,DATE_FORMAT( peinv.IPODate, '%b-%y' ) as dealperiod,peinv.ExitStatus,inv.*
                                                                        from ipo_investors as peinv_inv,peinvestors as inv,
                                                                        ipos as peinv,pecompanies as c,industry as i
                                                                        where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId and peinv.Deleted=0
                                                                        and i.industryid=c.industry
                                                                        and peinv.IPOId=peinv_inv.IPOId and c.PECompanyId=peinv.PECompanyId and c.industry $ind_where";
                                        if ($getcompanyipors = mysql_query($iposql))
                                        {
                                                While($myInvestiporow=mysql_fetch_array($getcompanyipors, MYSQL_BOTH))
                                                {
                                                        $ipocompanyName=trim($myInvestiporow["companyname"]);
                                                        $ipocompanyName=strtolower($ipocompanyName);
                                                        $ipocompResult=substr_count($ipocompanyName,$searchString);
                                                        $ipocompResult1=substr_count($ipocompanyName,$searchString1);
                                                        $exitstatusvalueforIPO=$myInvestiporow["ExitStatus"];
                                                        if($exitstatusvalueforIPO==0)
                                                        {$exitstatusdisplayforIPO="Partial Exit";}
                                                        elseif($exitstatusvalueforIPO==1)
                                                        {  $exitstatusdisplayforIPO="Complete Exit";}
                                                        if(($ipocompResult==0) && ($ipocompResult1==0))
                                                                $ipocompdisplay=$myInvestiporow["companyname"];
                                                        else
                                                                $ipocompdisplay= $searchStringDisplay;

                                                        $stripoCompany=$stripoCompany.",".$ipocompdisplay."(".$myInvestiporow["indname"] .";" .$myInvestiporow["dealperiod"].";". $exitstatusdisplayforIPO .")";
                                                }
                                        }
                                                $stripoInvestments =substr_replace($stripoCompany, '', 0,1);
                                                $schema_insert .=$stripoInvestments.$sep;  // Existing IPO Exits with deal date


                                        $mandasql="select peinv_inv.InvestorId,peinv_inv.MandAId,peinv.PECompanyId,peinv.DealTypeId, dt.DealType,
                                                                c.companyname,c.industry, i.industry as indname,DATE_FORMAT( peinv.DealDate, '%b-%y' )as dealperiod,peinv.ExitStatus,inv.*
                                                                from manda_investors as peinv_inv,peinvestors as inv,
                                                                manda as peinv,pecompanies as c,industry as i,  dealtypes AS dt
                                                                where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId
                                                                and peinv.MandAId=peinv_inv.MandAId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0 and i.industryid=c.industry
                                                                and c.industry $ind_where   and peinv.DealTypeId=dt.DealTypeId
                                                                order by DealDate desc";
                                        if ($getcompanymandars = mysql_query($mandasql))
                                        {
                                                While($myInvestmandarow=mysql_fetch_array($getcompanymandars, MYSQL_BOTH))
                                                {
                                                        $mandacompanyName=trim($myInvestmandarow["companyname"]);
                                                        $mandacompanyName=strtolower($mandacompanyName);
                                                        $mandacompResult=substr_count($mandacompanyName,$searchString);
                                                        $mandacompResult1=substr_count($mandacompanyName,$searchString1);
                                                        $exitstatusdisplay="";
                                                        $exitstatusvalue=$myInvestmandarow["ExitStatus"];
                                                        if($exitstatusvalue==0)
                                                        {$exitstatusdisplay="Partial Exit";}
                                                        elseif($exitstatusvalue==1)
                                                        {  $exitstatusdisplay="Complete Exit";}
                                                        if(($mandacompResult==0) && ($mandacompResult1==0))
                                                                $mandacompdisplay=$myInvestmandarow["companyname"];
                                                        else
                                                                $mandacompdisplay= $searchStringDisplay;

                                                        $strmandaCompany=$strmandaCompany.",".$mandacompdisplay."(".$myInvestmandarow["indname"]. ";" .$myInvestmandarow["dealperiod"].";". $myInvestmandarow["DealType"] .";". $exitstatusdisplay .")";
                                                }
                                        }
                                                $strmandaInvestments =substr_replace($strmandaCompany, '', 0,1);
                                                $schema_insert .=$strmandaInvestments.$sep;  // Existing M&A Exits with deal date

                                  $SVInvestmentsql="SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId,
                                   peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod,peinv.AggHide,SPV,peinv.Exit_Status
                                    FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                                    WHERE peinv.Deleted =0
                                    AND c.PECompanyId = peinv.PECompanyId
                                    AND c.industry!=15 $ind_where
                                    AND i.industryid = c.industry
                                    AND peinv_inv.InvestorId =$InvestorId
                                    AND inv.InvestorId = peinv_inv.InvestorId
                                    AND peinv.PEId = peinv_inv.PEId
                                    AND peinv.PEId
                                    IN (
                                     SELECT PEId
                                    FROM peinvestments_dbtypes AS db
                                    WHERE DBTypeId = '$dbTypeSV'
                                    ) order by peinv.dates desc";

                                   if ($getcompanysvrs = mysql_query($SVInvestmentsql))
                                        {
                                          $strsvcompany="";
                                                While($mysvrow =mysql_fetch_array($getcompanysvrs, MYSQL_BOTH))
                                                {
                                                        $SVcompanyName=trim($mysvrow["companyname"]);
                                                        $SVcompanyName=strtolower($SVcompanyName);
                                                       $compResult=substr_count($SVcompanyName,$searchString);
                                                       $compResult1=substr_count($SVcompanyName,$searchString1);
                                                       if($mysvrow["AggHide"]==1)
                                                        $addTrancheWord1="; Tranche";
                                                        else
                                                        $addTrancheWord1="";
                                                        
                                                        if($mysvrow['Exit_Status']==1){
                                                            $exitstatusis='Unexited';
                                                        }
                                                        else if($mysvrow['Exit_Status']==2){
                                                            $exitstatusis='Partially Exited';
                                                        }
                                                        else if($mysvrow['Exit_Status']==3){
                                                            $exitstatusis='Fully Exited';
                                                        }
                                                        else{
                                                            $exitstatusis='';
                                                        }
                                                         if($mysvrow["SPV"]==1)
                                                        $addDebtWord1="; Debt";
                                                         else
                                                        $addDebtWord1="";
                                                        if(($compResult==0) && ($compResult1==0))
                                                        {   $svcompdisplay=$mysvrow["companyname"];   }
                                                        else
                                                        {   $svcompdisplay= $searchStringDisplay;  }

                                                        $strsvcompany=$strsvcompany.",".$svcompdisplay."(".$mysvrow["indname"]. ";" .$mysvrow["dealperiod"].$addTrancheWord1.$addDebtWord1.";".$exitstatusis.")";
                                                }
                                                //echo "<br>***".$strsvcompany;
                                        }
                                                $strsvinvestments =substr_replace($strsvcompany, '', 0,1);
                                                $schema_insert .=$strsvinvestments.$sep;  // Existing SV Investments with deal date


                                     $CTInvestmentsql="SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId, peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod,peinv.Exit_Status
                                    FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                                    WHERE peinv.Deleted =0
                                    AND c.PECompanyId = peinv.PECompanyId
                                    AND c.industry!=15 $ind_where
                                    AND i.industryid = c.industry
                                    AND peinv_inv.InvestorId =$InvestorId
                                    AND inv.InvestorId = peinv_inv.InvestorId
                                    AND peinv.PEId = peinv_inv.PEId
                                    AND peinv.PEId
                                    IN (
                                     SELECT PEId
                                    FROM peinvestments_dbtypes AS db
                                    WHERE DBTypeId = '$dbTypeCT'
                                    ) order by peinv.dates desc";

                                   if ($getcompanyctrs = mysql_query($CTInvestmentsql))
                                        {
                                          $strctcompany="";
                                                While($myctrow =mysql_fetch_array($getcompanyctrs, MYSQL_BOTH))
                                                {
                                                        $CTcompanyName=trim($myctrow["companyname"]);
                                                        $CTcompanyName=strtolower($CTcompanyName);
                                                       $compResult=substr_count($CTcompanyName,$searchString);
                                                       $compResult1=substr_count($CTcompanyName,$searchString1);
                                                        if(($compResult==0) && ($compResult1==0))
                                                        {   $ctcompdisplay=$myctrow["companyname"];   }
                                                        else
                                                        {   $ctcompdisplay= $searchStringDisplay;  }

                                                        if($myctrow['Exit_Status']==1){
                                                            $exitstatusis='Unexited';
                                                }
                                                        else if($myctrow['Exit_Status']==2){
                                                            $exitstatusis='Partially Exited';
                                                        }
                                                        else if($myctrow['Exit_Status']==3){
                                                            $exitstatusis='Fully Exited';
                                                        }
                                                        else{
                                                            $exitstatusis='Unexited';
                                                        }

                                                        $strctcompany=$strctcompany.",".$ctcompdisplay."(".$myctrow["indname"]. ";" .$myctrow["dealperiod"].";".$exitstatusis.")";
                                                }
                                                //echo "<br>***".$strsvcompany;
                                        }
                                                $strctinvestments =substr_replace($strctcompany, '', 0,1);
                                                $schema_insert .=$strctinvestments.$sep;  // Existing CTInvestments with deal date


                                    $IFInvestmentsql="SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId, peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod,peinv.Exit_Status
                                    FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                                    WHERE peinv.Deleted =0
                                    AND c.PECompanyId = peinv.PECompanyId
                                    AND c.industry!=15 $ind_where
                                    AND i.industryid = c.industry
                                    AND peinv_inv.InvestorId =$InvestorId
                                    AND inv.InvestorId = peinv_inv.InvestorId
                                    AND peinv.PEId = peinv_inv.PEId
                                    AND peinv.PEId
                                    IN (
                                     SELECT PEId
                                    FROM peinvestments_dbtypes AS db
                                    WHERE DBTypeId = '$dbTypeIF'
                                    ) order by peinv.dates desc";

                                   if ($getcompanyifrs = mysql_query($IFInvestmentsql))
                                        {
                                          $strifcompany="";
                                                While($myifrow =mysql_fetch_array($getcompanyifrs, MYSQL_BOTH))
                                                {
                                                        $IFcompanyName=trim($myifrow["companyname"]);
                                                        $IFcompanyName=strtolower($IFcompanyName);
                                                       $compResult=substr_count($IFcompanyName,$searchString);
                                                       $compResult1=substr_count($IFcompanyName,$searchString1);
                                                       
                                                       if($myifrow['Exit_Status']==1){
                                                            $exitstatusis='Unexited';
                                                        }
                                                        else if($myifrow['Exit_Status']==2){
                                                            $exitstatusis='Partially Exited';
                                                        }
                                                        else if($myifrow['Exit_Status']==3){
                                                            $exitstatusis='Fully Exited';
                                                        }
                                                        else{
                                                            $exitstatusis='Unexited';
                                                        }
                                                       
                                                        if(($compResult==0) && ($compResult1==0))
                                                        {   $ifcompdisplay=$myifrow["companyname"];   }
                                                        else
                                                        {   $ifcompdisplay= $searchStringDisplay;  }

                                                        $strifcompany=$strifcompany.",".$ifcompdisplay."(".$myifrow["indname"]. ";" .$myifrow["dealperiod"].";".$exitstatusis.")";
                                                }
                                                //echo "<br>***".$strsvcompany;
                                        }
                                                $strifinvestments =substr_replace($strifcompany, '', 0,1);
                                                $schema_insert .=$strifinvestments.$sep;  // Existing IF nvestments with deal date
                                         */
                                    }             
                                                
                                }
                                 $schema_insert .= ""."\n";
                                //following fix suggested by Josue (thanks, Josue!)
                                //this corrects output in excel when table fields contain \n or \r
                                //these two characters are now replaced with a space
                                $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                         $schema_insert .= "\t";
                         print($schema_insert);
                         print "\n";
                         
                         } //endof if loop for investorname check         
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