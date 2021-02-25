<?php include_once("../globalconfig.php"); ?>
<?php
////session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
//session_start();
require("../dbconnectvi.php");
$Db = new dbInvestments();
if(!isset($_SESSION['UserNames']))
        {
        header('Location:../pelogin.php');
        }
        else
        {
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
                        $TrialExpired="Your email login has expired. Please contact info@ventureintelligence.in";
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
                        $investorType=$_POST['txthideinvestorTypeid'];
                        //echo "<bR>*******************".$investorTypeId;
                        $startRangeValue=$_POST['txthiderange'];
                        $endRangeValue=$_POST['txthiderangeEnd'];
                        //echo "<bR>-----" .$range;
                        $hidedateStartValue=$_POST['txthidedateStartValue'];
                        $hidedateEndValue=$_POST['txthidedateEndValue'];

                       $companysearch=$_POST['txthidecompany'];
                       $keyword=$_POST['txthidekeyword'];
                       $sectorsearch=$_POST['txthidesector'];
                       $advisorsearch_legal=$_POST['txthideadvisorlegal'];
                       $advisorsearch_trans=$_POST['txthideadvisortrans'];
                       $searchallfield=$_POST['searchallfield'];
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
				//	echo "<br>Date value-" .$dateValue;

                    $tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

                    if($pe_vc_flag==0)
                    {
                            $addVCFlagqry="";
                            $filetitle="PE-Companies";
                    }
                    elseif($pe_vc_flag==1)
                    {
                            $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                            $filetitle="VC-Companies";
                    }
                    elseif($pe_vc_flag==2) //Angel Companies
                    {
                        $addVCFlagqry="";
                        $filetitle="Angel-backed-Companies";
                    }
                    else if($pe_vc_flag==3)
                    {
                            $addVCFlagqry = "";
                            $dbtype="SV";
                            $filetitle="Social-Venture";
                    }
                    else if($pe_vc_flag==4)
                    {
                            $addVCFlagqry = "";
                            $dbtype="CT";
                            $filetitle="CleanTech-Investments-Investors";
                    }
                    elseif($pe_vc_flag==5)
                    {
                            $addVCFlagqry = "";
                            $dbtype="IF";
                            $filetitle="Infrastructure-Investments-Investors";
                    }
                    elseif($pe_vc_flag==7) //PE_ipos
                    {
                            $addVCFlagqry="";
                            $filetitle="PE-backed-IPOCompanies";
                    }
                    elseif($pe_vc_flag==8) //VC-ipos
                    {
                            $addVCFlagqry="and VCFlag=1";
                            $filetitle="VC-backed-IPO-Companies";
                    }
                    elseif($pe_vc_flag==10) //PE-EXits M&A Companies
                    {
                            $addVCFlagqry="";
                            $filetitle="PE-Exits-M&A-Companies";
                    }
                    elseif($pe_vc_flag==11) //VC-EXits M&A Companies
                    {
                        $addVCFlagqry="and VCFlag=1";
                        $filetitle="VC-Exits-M&A-Companies";
                    }

                    elseif($pe_vc_flag==9)
                    {
                            $addVCFlagqry="";
                            $filetitle="PMS";
                    }
                    elseif($pe_vc_flag==12)
                    {
                           $addVCFlagqry="and VCFlag=1";
                            $filetitle="VCPMS";
                    }
                    
                    
                                        
                    
                    if($pe_vc_flag==0 || $pe_vc_flag==1)
                    {
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
                              //  echo "<br>advisor_legal search 0 or 1- ".$showallsql;
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
                               // echo "<br> $advisor_trans search 0 or 1- ".$showallsql;
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
                            $showallsql = "select distinct peinv.InvestorId,inv.Investor,inv.*
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv
                                where ";

                        	//echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;
                                
                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";
                                
                                if ($stageval!='')
                                {
                                    $stagevalue="";
                                    $stageidvalue="";
                                    $stageidvalue=explode(",",$stageval);
                                    foreach($stageidvalue as $stage)
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
                                   //echo "<br>---" .$stringto;

                                 }
                                //
                                            if($round != "--" && $round !="")
                                            {
                                                $whereRound="pe.round LIKE '".$round."%'";
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
                                    $showallsql=$showallsql ."(".$wherestage.") and " ;

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
                                pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall."  order by inv.Investor ";
                                
                                 $getInvestorSql=$showallsql;
                                        
                                //echo $showallsql;
                            }
                    }
                    else if($pe_vc_flag==2)
                       {
                        
                                if($_POST['txthidedv']==101)
                                {
                                    if($keyword!="")
                                     {
                                             $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                                 FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                                 WHERE pe.InvesteeId = pec.PEcompanyId
                                                 AND pec.industry !=15
                                                 AND peinv.AngelDealId = pe.AngelDealId
                                                 AND inv.InvestorId = peinv.InvestorId
                                                 AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%' order by inv.Investor ";

                                             $showallsql = $showallsql;
                                         //echo "<br> Investor search- ".$showallsql;
                                     }
                                    elseif($searchallfield!="")
                                     {
                                        $findTag = strpos($searchallfield,'tag:');
                                        $findTags = "$findTag";
                                        if($findTags == ''){
                                            $tagsval = "pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                                     OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or  Investor like '%$searchallfield%' or pec.tags like '%$searchallfield%'";                                    
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
                                        $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                                 FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                                 WHERE pe.InvesteeId = pec.PEcompanyId
                                                 AND pec.industry !=15
                                                 AND peinv.AngelDealId = pe.AngelDealId
                                                 AND inv.InvestorId = peinv.InvestorId
                                                 AND pe.Deleted=0 " .$addVCFlagqry. " and ( $tagsval ) order by inv.Investor ";

                                             $totalallsql = $showallsql; 

                                     }
                                     else
                                     {
                                             $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                                 FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                                 WHERE pe.InvesteeId = pec.PEcompanyId
                                                 AND pec.industry !=15
                                                 AND peinv.AngelDealId = pe.AngelDealId
                                                 AND inv.InvestorId = peinv.InvestorId
                                                 AND pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall." order by inv.Investor ";

                                             $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                                 FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv
                                                 WHERE pe.InvesteeId = pec.PEcompanyId
                                                 AND pec.industry !=15
                                                 AND peinv.AngelDealId = pe.AngelDealId
                                                 AND inv.InvestorId = peinv.InvestorId
                                                 AND pe.Deleted=0 " .$addVCFlagqry. " ".$dirsearchall." order by inv.Investor ";
                                     }
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
                                //echo "<br> company search- ".$showallsql;
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
                                    $showallsql="select distinct peinv.InvestorId,inv.Investor,inv.*
                                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec, country as c,
                                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and inv.countryid= c.countryid and
                                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                                    pe.Deleted=0 " .$addVCFlagqry. " and ( $tagsval ) order by inv.Investor ";
                                    
                                    $getInvestorSql=$showallsql;
                                //echo "<br> company search- ".$showallsql;
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
                                
                                if ($stageval!='')
                                {
                                    $stagevalue="";
                                    $stageidvalue="";
                                    $stageidvalue=explode(",",$stageval);
                                    foreach($stageidvalue as $stage)
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
                                    $showallsql=$showallsql ."(".$wherestage.") and " ;

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
                                // echo "<br> sector search- ".$showallsql;
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
				AND inv.InvestorId = peinv.InvestorId
                                and  inv.countryid= c.countryid 
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
				AND pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall."  order by inv.Investor ";
                                
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
				AND pe.Deleted=0 " .$addVCFlagqry. " and Investor like '%$keyword%'  ".$dealcond."  order by inv.Investor";
                                
                                $getInvestorSql=$showallsql;
                                //echo "<br> company search- ".$showallsql;
                            }
                            elseif($companysearch!="")
                            {
                                $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv  ".$dealtype."
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
				AND pe.Deleted=0 " .$addVCFlagqry. " and pec.companyname like '%$companysearch%'  ".$dealcond." order by inv.Investor";
                                    
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
                                    AND pe.Deleted=0 " .$addVCFlagqry. " and pec.sector_business like '%$sectorsearch%'  ".$dealcond." order by inv.Investor";
                                    
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
                                    AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'  ".$dealcond." and AdvisorType='L'
                                         AND adac.PEId = pe.MandAId)
                                         UNION(SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac  ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND pec.industry !=15
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'  ".$dealcond." and AdvisorType='L'
                                         AND adac.PEId = pe.MandAId)";
                                    
                                    $getInvestorSql=$showallsql;
                               // echo "<br>advisor_legal search- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                    $showallsql="(SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac  ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND pec.industry !=15
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'    ".$dealcond."   and AdvisorType='T'
                                         AND adac.PEId = pe.MandAId)
                                         UNION(SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac  ".$dealtype."
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND pec.industry !=15
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND pe.Deleted=0 AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'    ".$dealcond."    and AdvisorType='T'
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
				AND pe.Deleted=0 " .$addVCFlagqry. " and ( inv.investor like '$searchallfield%' or inv.AdditionalInfor like '%$searchallfield%' or inv.Description like '%$searchallfield%' or inv.Address1 like '$searchallfield%' or inv.Address2 like '$searchallfield%' or inv.City like '$searchallfield%' or c.country like '$searchallfield%' or inv.Zip like '$searchallfield%' or inv.Telephone like '$searchallfield%' or inv.Email like '$searchallfield%' or inv.yearfounded like '$searchallfield%' or inv.website like '$searchallfield%' or inv.linkedIn like '$searchallfield%' or inv.FirmType like '$searchallfield%' or inv.OtherLocation like '%$searchallfield%' or inv.Assets_mgmt like '%$searchallfield%' or inv.LimitedPartners like '%$searchallfield%' or inv.NoFunds like '$searchallfield%' or inv.MinInvestment like '$searchallfield%' or pec.tags like '%$searchallfield%' ) ".$dealcond." order by inv.Investor";
                                    
                                    $getInvestorSql=$showallsql;
                                //echo "<br> company search- ".$showallsql;
                            }
                            else
                            {
                              $showallsql = "SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*
							FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv   ".$dealtype."  WHERE ";

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
                               
                               if(($month1 != "--") && ($month1 != "") && (year1 != "--")  && (year1 != "")  && ($month2 !="--") && ($month2 !="") && ($year2 != "--") && ($year2 != "")){
                                    $dt1 = $year1."-".$month1."-01";
                                    $dt2 = $year2."-".$month2."-01";
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
				AND pe.Deleted=0 " .$addVCFlagqry. " " .$search." ".$dirsearchall."   ".$dealcond."    order by inv.Investor ";  
                                
                                  $getInvestorSql=$showallsql;
                                //echo $showallsql;
                            }
                        
                    }
                    
                    
                  //  echo $getInvestorSql; 
                    
                    echo mysql_num_rows(mysql_query($getInvestorSql));
                    exit;
                    
                    $getInvestorSql = $_POST[ 'sqlquery' ];
                    $sql=$getInvestorSql;
                    /*echo "<br>---" .$sql;
                    exit();*/
                     //execute query
                     $result = @mysql_query($sql)
                         or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
                     //echo mysql_num_rows($result);
                     //exit;

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
                    { 		echo("$title\n"); 	}

                    /*echo ("$tsjtitle");
                     print("\n");
                      print("\n");*/

                    //define separator (defines columns in excel & tabs in word)
                    $sep = "\t"; //tabbed character

                    //start of printing column names as names of MySQL fields
                    //-1 to avoid printing of coulmn heading country
                   // for ($i =9; $i < mysql_num_fields($result)-4; $i++)
                   // {
                   // 	echo mysql_field_name($result,$i) . "\t";
                   // }
                    echo "Investor"."\t";
                    echo "Address"."\t";
                    echo ""."\t";
                    echo "City"."\t";
                    echo "Country"."\t";
                    echo "Zip"."\t";

                    echo "Telephone "."\t";
                    echo "Fax"."\t";
                    echo "Email"."\t";
                    echo "Website"."\t";
                    echo "Description"."\t";
                    echo "In India Since"."\t";
                    echo "Management"."\t";
                    echo "Firm Type"."\t";
                    echo "Other Location(s)"."\t";
                    echo "Assets Under Management (US $M)"."\t";
                    echo "Stage of Funding (Existing Investments)"."\t";
                    echo "Limited Partners"."\t";
                    echo "Number of Funds"."\t";
                    echo "Additional Info"."\t";
                    echo "Industry (Existing Investments)"."\t";
                    echo "PE/VC Investments"."\t";
                    echo "Exits - IPO"."\t";
                    echo "Exits - M&A"."\t";
                    echo "Social Venture Investments"."\t";
                    echo "Cleantech Investments"."\t";
                    echo "Infrastructure Investments"."\t";
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
                                $schema_insert .=$row[1].$sep; //Investorname
                                $schema_insert .=$row[4].$sep; //address
                                $schema_insert .=$row[5].$sep; //address line 2
                                $schema_insert .=$row[6].$sep; //city

                                $txtcountryid= $row[26]; //countryid
                                        $countrysql="select country from country where countryid='$txtcountryid'";
                                        if($rscountry= mysql_query($countrysql))
                                        {
                                        While($mycountryrow=mysql_fetch_array($rscountry, MYSQL_BOTH))
                                                {
                                                        $countryname=$mycountryrow["country"];
                                                }
                                        }
                                $schema_insert .=$countryname.$sep; //country

                                $schema_insert .=$row[7].$sep; //zip
                                $schema_insert .=$row[8].$sep; //Telephone
                                $schema_insert .=$row[9].$sep; //Fax
                                $schema_insert .=$row[10].$sep; //Email
                                $schema_insert .=$row[11].$sep; //Website
                                $schema_insert .=$row[12].$sep; //Description
                                $schema_insert .=$row[13].$sep; //Year founded


                                $onMgmtSql="select pec.InvestorId,mgmt.InvestorId,mgmt.ExecutiveId,
                                exe.ExecutiveName,exe.Designation,exe.Company from
                                peinvestors as pec,executives as exe,peinvestors_management as mgmt
                                where pec.InvestorId=$InvestorId and mgmt.InvestorId=pec.InvestorId and exe.ExecutiveId=mgmt.ExecutiveId";
                                if($rsMgmt= mysql_query($onMgmtSql))
                                {
                                        $MgmtTeam="";
                                        While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                                        {
                                                $Exename= $mymgmtrow["ExecutiveName"];
                                                $Designation=$mymgmtrow["Designation"];
                                                if($Designation!="")
                                                        $MgmtTeam=$MgmtTeam.";".$Exename.",".$Designation;
                                                else
                                                        $MgmtTeam=$MgmtTeam.";".$Exename;
                                        }
                                        $MgmtTeam=substr_replace($MgmtTeam, '', 0,1);
                                }
                                $schema_insert .=$MgmtTeam.$sep; //Management Team

                                $schema_insert .=$row[15].$sep; //FirmType

                                $schema_insert .=$row[16].$sep; //Other Location
                                $assets_management=$row[17];

                                $schema_insert .=$assets_management.$sep; //Assets under managment

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
                                $schema_insert .=$row[20].$sep; //Limited Partners
                                $schema_insert .=$row[21].$sep; //Number of funds
                                $schema_insert .=$row[24].$sep; //Addtional Info

                                $indSql= " SELECT DISTINCT i.industry as ind, c.industry, peinv_inv.InvestorId
                                        FROM peinvestments_investors AS peinv_inv, peinvestors AS inv, pecompanies AS c, peinvestments AS peinv, industry AS i
                                        WHERE peinv_inv.InvestorId =$InvestorId
                                        AND inv.InvestorId = peinv_inv.InvestorId
                                        AND c.PECompanyId = peinv.PECompanyId
                                        AND peinv.PEId = peinv_inv.PEId  and i.industryid!=15
                                        AND i.industryid = c.industry and peinv.Deleted=0 order by i.industry";

                                        if($rsInd= mysql_query($indSql))
                                        {
                                                While($myIndrow=mysql_fetch_array($rsInd, MYSQL_BOTH))
                                                {
                                                        $strIndustry=$strIndustry.", ".$myIndrow["ind"];
                                                }
                                                $strIndustry =substr_replace($strIndustry, '', 0,1);
                                        }

                                $schema_insert .=$strIndustry.$sep; //Industry for Existing investments

                                $Investmentsql="select peinv_inv.InvestorId,peinv_inv.PEId,peinv.PECompanyId,
                                                c.companyname,c.industry,i.industry as indname,
                                                DATE_FORMAT( peinv.dates, '%b-%y' )as dealperiod,inv.*,peinv.AggHide
                                                from peinvestments_investors as peinv_inv,peinvestors as inv,
                                                peinvestments as peinv,pecompanies as c,industry as i
                                                where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId
                                                and peinv.PEId=peinv_inv.PEId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0
                                                and c.industry!=15 and c.PECompanyId=peinv.PECompanyId and i.industryid=c.industry
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

                                                if(($compResult==0) && ($compResult1==0))
                                                        $compdisplay=$myInvestrow["companyname"];
                                                else
                                                        $compdisplay= $searchStringDisplay;

                                                $strCompany=$strCompany.",".$compdisplay."(".$myInvestrow["indname"] .";".$myInvestrow["dealperiod"].$addTrancheWord.")";
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
                                                                        and peinv.IPOId=peinv_inv.IPOId and c.PECompanyId=peinv.PECompanyId and c.industry $industryvalue";
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


                                        $mandasql="select peinv_inv.InvestorId,peinv_inv.MandAId,peinv.PECompanyId,
                                                                c.companyname,c.industry, i.industry as indname,DATE_FORMAT( peinv.DealDate, '%b-%y' )as dealperiod,peinv.ExitStatus,inv.*
                                                                from manda_investors as peinv_inv,peinvestors as inv,
                                                                manda as peinv,pecompanies as c,industry as i
                                                                where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId
                                                                and peinv.MandAId=peinv_inv.MandAId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0 and i.industryid=c.industry
                                                                and c.industry $industryvalue
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

                                                        $strmandaCompany=$strmandaCompany.",".$mandacompdisplay."(".$myInvestmandarow["indname"]. ";" .$myInvestmandarow["dealperiod"].";". $exitstatusdisplay .")";
                                                }
                                        }
                                                $strmandaInvestments =substr_replace($strmandaCompany, '', 0,1);
                                                $schema_insert .=$strmandaInvestments.$sep;  // Existing M&A Exits with deal date

                                  $SVInvestmentsql="SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId,
                                   peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod,peinv.AggHide,SPV
                                    FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                                    WHERE peinv.Deleted =0
                                    AND c.PECompanyId = peinv.PECompanyId
                                    AND c.industry!=15
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
                                                         if($mysvrow["SPV"]==1)
                                                        $addDebtWord1="; Debt";
                                                         else
                                                        $addDebtWord1="";
                                                        if(($compResult==0) && ($compResult1==0))
                                                        {	$svcompdisplay=$mysvrow["companyname"];   }
                                                        else
                                                        {	$svcompdisplay= $searchStringDisplay;  }

                                                        $strsvcompany=$strsvcompany.",".$svcompdisplay."(".$mysvrow["indname"]. ";" .$mysvrow["dealperiod"].$addTrancheWord1.$addDebtWord1.")";
                                                }
                                                //echo "<br>***".$strsvcompany;
                                        }
                                                $strsvinvestments =substr_replace($strsvcompany, '', 0,1);
                                                $schema_insert .=$strsvinvestments.$sep;  // Existing SV Investments with deal date


                                     $CTInvestmentsql="SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId, peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod
                                    FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                                    WHERE peinv.Deleted =0
                                    AND c.PECompanyId = peinv.PECompanyId
                                    AND c.industry!=15
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
                                                        {	$ctcompdisplay=$myctrow["companyname"];   }
                                                        else
                                                        {	$ctcompdisplay= $searchStringDisplay;  }

                                                        $strctcompany=$strctcompany.",".$ctcompdisplay."(".$myctrow["indname"]. ";" .$myctrow["dealperiod"].")";
                                                }
                                                //echo "<br>***".$strsvcompany;
                                        }
                                                $strctinvestments =substr_replace($strctcompany, '', 0,1);
                                                $schema_insert .=$strctinvestments.$sep;  // Existing CTInvestments with deal date


                                    $IFInvestmentsql="SELECT peinv.PECompanyId, c.companyname, c.industry, i.industry AS indname, peinv_inv.InvestorId, peinv_inv.PEId, DATE_FORMAT( peinv.dates, '%b-%Y' ) AS dealperiod
                                    FROM peinvestments AS peinv, pecompanies AS c, industry AS i, peinvestments_investors AS peinv_inv, peinvestors AS inv
                                    WHERE peinv.Deleted =0
                                    AND c.PECompanyId = peinv.PECompanyId
                                    AND c.industry!=15
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
                                                        if(($compResult==0) && ($compResult1==0))
                                                        {	$ifcompdisplay=$myifrow["companyname"];   }
                                                        else
                                                        {	$ifcompdisplay= $searchStringDisplay;  }

                                                        $strifcompany=$strifcompany.",".$ifcompdisplay."(".$myifrow["indname"]. ";" .$myifrow["dealperiod"].")";
                                                }
                                                //echo "<br>***".$strsvcompany;
                                        }
                                                $strifinvestments =substr_replace($strifcompany, '', 0,1);
                                                $schema_insert .=$strifinvestments.$sep;  // Existing IF nvestments with deal date

                         } //endof if loop for investorname check         
                        //commented the foll line in order to get printed $ symbol in excel file
                        // $schema_insert = str_replace($sep."$", "", $schema_insert);

                            $schema_insert .= ""."\n";
                                //following fix suggested by Josue (thanks, Josue!)
                                //this corrects output in excel when table fields contain \n or \r
                                //these two characters are now replaced with a space
                                $schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
                         $schema_insert .= "\t";
                         print(trim($schema_insert));
                         print "\n";
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
										$to="arun.natarajan@gmail.com,arun@ventureintelligence.in";
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
                                }

				//		}
				//else
				//	header( 'Location: http://www.ventureintelligence.in/pelogin.php' ) ;

   mysql_close();
    mysql_close($cnx);
    ?>