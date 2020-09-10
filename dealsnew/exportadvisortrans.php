<?php include_once("../globalconfig.php"); ?>
<?php
 //session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
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
        
        
        
		//include('onlineaccount.php');
		$displayMessage="";
		$mailmessage="";

				//global $LoginAccess;
				//global $LoginMessage;
				$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.in";

					$adtype=$_POST['hideadvisortype'];
                                        $columntitle="";
					$submitemail=$_POST['txthideemail'];
                                        if($adtype=="L")
      		                        {  $adtitledisplay ="Legal";}
		                        elseif($adtype=="T")
                                        {  $adtitledisplay="Transaction";}
                                        $pe_ipo_manda_flag=$_POST['hidepeipomandapage'];
					$pe_vc_flag=$_POST['hidevcflagValue'];
					$isShowAll=$_POST['hideShowAll'];

					$industry=$_POST['txthideindustryid'];
                                        
					$stageval=substr($_POST['txthidestageid'],1);
                                        
					$investorType=$_POST['txthideinvestorTypeid'];
					//echo "<bR>*******************".$investorTypeId;
					$startRangeValue=$_POST['txthiderange'];
					$endRangeValue=$_POST['txthiderangeEnd'];
					//echo "<bR>-----" .$range;
					$hidedateStartValue=$_POST['txthidedateStartValue'];
					$hidedateEndValue=$_POST['txthidedateEndValue'];
                                 
                                        $advisorsearch_trans=$_POST['txthideadvisor'];
                                        $advisorsearch_legal=$_POST['txthideadvisorlegal'];
                                        $companysearch=$_POST['txthidecompany'];
                                        $keyword=$_POST['txthidekeyword'];
                                        $sectorsearch=$_POST['txthidesector'];
                                        $searchallfield=$_POST['searchallfield'];

					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

                                        if($pe_vc_flag==0)
                                        {
                                                $addVCFlagqry="";
                                                $pagetitle="PE-Advisors-".$adtitledisplay;
                                        }
                                        elseif($pe_vc_flag==1)
                                        {
                                                //$addVCFlagqry="";
                                                $addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
                                                $pagetitle="VC-Advisors-".$adtitledisplay;
                                        }
                                        if($pe_vc_flag==3)
                                        {
                                                //$addVCFlagqry="";
                                                $addVCFlagqry = "";
                                                $pagetitle="SV-Advisors-".$adtitledisplay;
                                                $dbtype="SV";
                                        }
                                        elseif($pe_vc_flag==4)
                                        {
                                                //$addVCFlagqry="";
                                                $addVCFlagqry = "";
                                                $pagetitle="CT-Advisors-".$adtitledisplay;
                                                $dbtype="CT";
                                        }
                                        if($pe_vc_flag==5)
                                        {
                                                //$addVCFlagqry="";
                                                $addVCFlagqry = "";
                                                $pagetitle="IF-Advisors-".$adtitledisplay;
                                                $dbtype="IF";
                                        }
                                        elseif($pe_vc_flag==9)
                                        {
                                                $addVCFlagqry="";
                                                $pagetitle="Public-Market-Sale-Advisors-".$adtitledisplay;
                                        }
                                        elseif($pe_vc_flag==10)
                                        {
                                                $addVCFlagqry="";
                                                $pagetitle="PE-Exits-M&A-Advisors-".$adtitledisplay;
                                        }
                                        elseif($pe_vc_flag==11)
                                        {
                                                //$addVCFlagqry="";
                                                $addVCFlagqry = " and VCFlag=1 ";
                                                $pagetitle="VC-Exits-M&A-Advisors-".$adtitledisplay;
                                        }
                                         elseif($pe_vc_flag==12)
                                        {
                                                $addVCFlagqry = " and VCFlag=1 ";
                                                $pagetitle="Public-Market-Sale-Advisors-".$adtitledisplay;
                                        }
					/*	if($pe_vc_flag == 0 || $pe_vc_flag == 1) //investment page
						{
                                                  $columntitle="Advisor - Investors";
							if($pe_vc_flag==0)
							{
								$addVCFlagqry="";
								$pagetitle="PE-Advisors-".$adtitledisplay;
							}
							elseif($pe_vc_flag==1)
							{
								//$addVCFlagqry="";
								$addVCFlagqry = "and s.VCview=1 and pe.amount<=20 ";
								$pagetitle="VC-Advisors-".$adtitledisplay;
							}
                                                        if($advisorsearch_trans!="")
                                                        {
                                                            $showallsql="(
                                                             SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                             FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
                                                             peinvestments_advisorinvestors AS adac, stage as s
                                                             WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
                                                             " AND c.PECompanyId = pe.PECompanyId
                                                             AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='".$adtype ."'
                                                             AND adac.PEId = pe.PEId)
                                                             UNION (
                                                             SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                             FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
                                                             peinvestments_advisorcompanies AS adac, stage as s
                                                             WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
                                                             " AND c.PECompanyId = pe.PECompanyId
                                                             AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='".$adtype ."'
                                                             AND adac.PEId = pe.PEId ) order by Cianame";
                                                            
                                                             $advisorsql=$showallsql;
                                                            //echo $showallsql;
                                                        }
                                                       else if($advisorsearch_legal!="")
                                                        {
                                                            $showallsql="(
                                                             SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                             FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
                                                             peinvestments_advisorinvestors AS adac, stage as s
                                                             WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
                                                             " AND c.PECompanyId = pe.PECompanyId
                                                             AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='".$adtype ."'
                                                             AND adac.PEId = pe.PEId)
                                                             UNION (
                                                             SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                             FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
                                                             peinvestments_advisorcompanies AS adac, stage as s
                                                             WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
                                                             " AND c.PECompanyId = pe.PECompanyId
                                                             AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='".$adtype ."'
                                                             AND adac.PEId = pe.PEId ) order by Cianame";
                                                            
                                                             $advisorsql=$showallsql;
                                                            //echo $showallsql;
                                                        }
                                                        elseif($companysearch!="")
                                                        {
                                                           $showallsql="(
                                                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
                                                            peinvestments_advisorinvestors AS adac, stage as s
                                                            WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
                                                            " AND c.PECompanyId = pe.PECompanyId
                                                            AND adac.CIAId = cia.CIAID and c.companyname LIKE '%$companysearch%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = pe.PEId)
                                                            UNION (
                                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
                                                            peinvestments_advisorcompanies AS adac, stage as s
                                                            WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
                                                            " AND c.PECompanyId = pe.PECompanyId
                                                            AND adac.CIAId = cia.CIAID and c.companyname LIKE '%$companysearch%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = pe.PEId ) order by Cianame";

                                                                $advisorsql=$showallsql;
                                                            //echo "0 or 1".$showallsql;
                                                        }
                                                        else if($keyword!="")
                                                        {
                                                             $showallsql="(
                                                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments_investors as peinv, peinvestments AS pe, pecompanies AS c,peinvestors as inv, advisor_cias AS cia,
                                                            peinvestments_advisorinvestors AS adac, stage as s
                                                            WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry." 
                                                            AND c.PECompanyId = pe.PECompanyId
                                                            AND adac.CIAId = cia.CIAID and Investor like '%$keyword%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = pe.PEId)
                                                            UNION (
                                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments_investors as peinv,peinvestments AS pe, pecompanies AS c,peinvestors as inv,  advisor_cias AS cia,
                                                            peinvestments_advisorcompanies AS adac, stage as s
                                                            WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
                                                            " AND c.PECompanyId = pe.PECompanyId
                                                            AND adac.CIAId = cia.CIAID and Investor like '%$keyword%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = pe.PEId ) order by Cianame";

                                                                $advisorsql=$showallsql;
                                                            //echo "0 or 1".$showallsql;
                                                        }
                                                        elseif($sectorsearch!="")
                                                        {
                                                             $showallsql="(
                                                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
                                                            peinvestments_advisorinvestors AS adac, stage as s
                                                            WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
                                                            " AND c.PECompanyId = pe.PECompanyId
                                                            AND adac.CIAId = cia.CIAID and c.sector_business LIKE '%$sectorsearch%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = pe.PEId)
                                                            UNION (
                                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
                                                            peinvestments_advisorcompanies AS adac, stage as s
                                                            WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
                                                            " AND c.PECompanyId = pe.PECompanyId
                                                            AND adac.CIAId = cia.CIAID and c.sector_business LIKE '%$sectorsearch%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = pe.PEId ) order by Cianame";

                                                                $advisorsql=$showallsql;
                                                           //echo "0 or 1".$showallsql;
                                                        }
                                                        elseif($searchallfield!="")
                                                        {
                                                            $findTag = strpos($searchallfield,'tag:');
                                                            $findTags = "$findTag";
                                                            if($findTags == ''){
                                                                $tagsval = "cia.cianame LIKE '%$searchallfield%' or cia.website LIKE '%$searchallfield%' or cia.address LIKE '%$searchallfield%' or cia.city LIKE '$searchallfield%' or cia.country LIKE '$searchallfield%' or cia.phoneno LIKE '$searchallfield%' or cia.contactperson LIKE '%$searchallfield%' or cia.designation LIKE '%$searchallfield%' or cia.email LIKE '%$searchallfield%' or cia.linkedin LIKE '%$searchallfield%'";                                    
                                                            }else{
                                                                $tags = '';
                                                                $ex_tags = explode(',',$searchallfield);
                                                                if(count($ex_tags) > 0){
                                                                    for($l=0;$l<count($ex_tags);$l++){
                                                                        if($ex_tags[$l] !=''){
                                                                            $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                                            $tags .= "c.tags like '%:$value%' or ";
                                                                        }
                                                                    }
                                                                }
                                                                $tagsval = trim($tags,' or ');
                                                            }
                                                           $showallsql="(
                                                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
                                                            peinvestments_advisorinvestors AS adac, stage as s
                                                            WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
                                                            " AND c.PECompanyId = pe.PECompanyId
                                                            AND adac.CIAId = cia.CIAID and ( $tagsval ) and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = pe.PEId)
                                                            UNION (
                                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
                                                            peinvestments_advisorcompanies AS adac, stage as s
                                                            WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
                                                            " AND c.PECompanyId = pe.PECompanyId
                                                            AND adac.CIAId = cia.CIAID and ( $tagsval) and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = pe.PEId ) order by Cianame";

                                                                $advisorsql=$showallsql;
                                                            //echo "0 or 1".$showallsql;
                                                        }
                                                        else{

                                                         $companysql= "(SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin from peinvestments as pe, industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorinvestors AS adac,stage as s where c.RegionId=re.RegionId and";
                                                         $companysql2= "SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin from peinvestments as pe, industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,stage as s where c.RegionId=re.RegionId and";


                                                         if ($industry > 0)
                                                             $whereind = " c.industry=" .$industry ;

                                                         if ($investorType!= "")
                                                             $whereInvType = " pe.InvestorType = '".$investorType."'";

                                                         if ($stageval!="")
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

                                                         if($hidedateStartValue !="" && $hidedateEndValue!=''){
                                                              $wheredates= " dates between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
                                                         }

                                                         if ($whereind != "")
                                                         {
                                                                 $companysql=$companysql . $whereind ." and ";
                                                                 $companysql2=$companysql2 . $whereind ." and ";
                                                         }

                                                         if ($whereInvType != "")
                                                         {
                                                                 $companysql=$companysql . $whereInvType ." and ";
                                                                 $companysql2=$companysql2 . $whereInvType ." and ";
                                                         }

                                                         if (($wherestage != ""))
                                                         {
                                                                 $companysql=$companysql ."(".$wherestage.") and " ;
                                                                 $companysql2=$companysql2 ."(".$wherestage.") and " ;

                                                         }

                                                         if (($whererange != "") )
                                                         {
                                                                 $companysql=$companysql .$whererange . " and ";
                                                                 $companysql2=$companysql2 .$whererange . " and ";
                                                         }


                                                         if(($wheredates != "") )
                                                         {
                                                                 $companysql = $companysql.$wheredates. " and ";
                                                                 $companysql2 = $companysql2.$wheredates. " and ";
                                                         }

                                                         $companysql = $companysql ." pe.Deleted=0 and c.industry = i.industryid and c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId " . $addVCFlagqry . " 
                                                             AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall."
                                                             AND adac.PEId = pe.PEId ";
                                                         $companysql2 = $companysql2 ." pe.Deleted=0 and c.industry = i.industryid and c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId " . $addVCFlagqry . " 
                                                             AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall."
                                                             AND adac.PEId = pe.PEId ";



                                                         $showallsql= $companysql.") UNION (".$companysql2.") ";

                                                         $orderby="order by Cianame";       

                                                         $showallsql=$showallsql.$orderby;
                                                         $advisorsql=$showallsql;
                                                         //echo $showallsql;
                                                         }
//							$advisorsql="(
//                                                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
//                                                            FROM peinvestments AS pe, pecompanies AS c, advisor_cias AS cia,
//                                                            peinvestments_advisorinvestors AS adac, stage as s
//                                                            WHERE pe.Deleted=0 and  s.StageId = pe.StageId ".$addVCFlagqry.
//                                                            " AND c.PECompanyId = pe.PECompanyId
//                                                            AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
//                                                            AND adac.PEId = pe.PEId)
//                                                            UNION (
//                                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
//                                                            FROM peinvestments AS pe, pecompanies AS c,  advisor_cias AS cia,
//                                                            peinvestments_advisorcompanies AS adac, stage as s
//                                                            WHERE pe.Deleted=0 and  s.StageId = pe.StageId  " .$addVCFlagqry.
//                                                            " AND c.PECompanyId = pe.PECompanyId
//                                                            AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
//                                                            AND adac.PEId = pe.PEId ) order by Cianame	";
//							//echo "<Br>PE - VC---" .$advisorsql;
						}
						else if($pe_vc_flag==9 ||$pe_vc_flag==10 || $pe_vc_flag==11 || $pe_vc_flag==12) //manda
						{
                                                  $columntitle="Advisor - Investors";
                                                        if($pe_vc_flag==9)
							{
								$addVCFlagqry="";
								$pagetitle="Public-Market-Sale-Advisors-".$adtitledisplay;
							}
							if($pe_vc_flag==10)
							{
								$addVCFlagqry="";
								$pagetitle="PE-Exits-M&A-Advisors-".$adtitledisplay;
							}
							elseif($pe_vc_flag==11)
							{
								//$addVCFlagqry="";
								$addVCFlagqry = " and VCFlag=1 ";
								$pagetitle="VC-Exits-M&A-Advisors-".$adtitledisplay;
							}
                                                         elseif($pe_vc_flag==12)
							{
								$addVCFlagqry = " and VCFlag=1 ";
								$pagetitle="Public-Market-Sale-Advisors-".$adtitledisplay;
							}
                                                        
                                                     $dealtype=' , dealtypes as dt '; 
                                                     if($pe_vc_flag==9 || $pe_vc_flag==12) { $dealcond=' AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1 '; }
                                                     else if($pe_vc_flag==10 || $pe_vc_flag==11) { $dealcond=' AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0 '; }
                                                     
                                                     
                                                     if($advisorsearch_trans!="")
                                                        {
                                                             $showallsql="(
                                                                     SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac     ".$dealtype." 
                                                                     WHERE Deleted =0
                                                                     AND c.PECompanyId = peinv.PECompanyId
                                                                     AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'    ".$dealcond."   and AdvisorType='".$adtype ."'
                                                                     AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                                                     " )
                                                                     UNION (
                                                                     SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp     ".$dealtype." 
                                                                     WHERE Deleted =0
                                                                     AND c.PECompanyId = peinv.PECompanyId
                                                                     AND adcomp.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'    ".$dealcond."   and AdvisorType='".$adtype ."'
                                                                     AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                                                     " )	ORDER BY Cianame";
                                                            //echo "<br> Investor search- ".$showallsql;
                                                              $advisorsql=$showallsql;

                                                        }
                                                        else if($advisorsearch_legal!="")
                                                        {
                                                             $showallsql="(
                                                                     SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac     ".$dealtype." 
                                                                     WHERE Deleted =0
                                                                     AND c.PECompanyId = peinv.PECompanyId
                                                                     AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'    ".$dealcond."   and AdvisorType='".$adtype ."'
                                                                     AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                                                     " )
                                                                     UNION (
                                                                     SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp  ".$dealtype."
                                                                     WHERE Deleted =0
                                                                     AND c.PECompanyId = peinv.PECompanyId
                                                                     AND adcomp.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'    ".$dealcond."   and AdvisorType='".$adtype ."'
                                                                     AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                                                     " )	ORDER BY Cianame";
                                                            //echo "<br> Investor search- ".$showallsql;
                                                              $advisorsql=$showallsql;

                                                        }
                                                        elseif($companysearch!="")
                                                        {
                                                            $showallsql="(
                                                                     SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac     ".$dealtype." 
                                                                     WHERE Deleted =0
                                                                     AND c.PECompanyId = peinv.PECompanyId
                                                                     AND adac.CIAId = cia.CIAID and c.companyname LIKE '%$companysearch%'    ".$dealcond."   and AdvisorType='".$adtype ."'
                                                                     AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                                                     " )
                                                                     UNION (
                                                                     SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp     ".$dealtype." 
                                                                     WHERE Deleted =0
                                                                     AND c.PECompanyId = peinv.PECompanyId
                                                                     AND adcomp.CIAId = cia.CIAID and c.companyname LIKE '%$companysearch%'    ".$dealcond."   and AdvisorType='".$adtype ."'
                                                                     AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                                                     " )	ORDER BY Cianame";

                                                                $advisorsql=$showallsql;
                                                            //echo "<br> Investor search- ".$showallsql;
                                                        }
                                                        elseif($keyword!="")
                                                        {
                                                            $showallsql="(
                                                                     SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                                     FROM manda AS peinv, pecompanies AS c,manda_investors AS pe, peinvestors AS inv,
                                                                     advisor_cias AS cia, peinvestments_advisoracquirer AS adac  ".$dealtype." 
                                                                     WHERE Deleted =0 AND pe.MandAId = peinv.MandAId
                                                                    AND inv.InvestorId = pe.InvestorId 
                                                                     AND c.PECompanyId = peinv.PECompanyId
                                                                     AND adac.CIAId = cia.CIAID and Investor like '%$keyword%'    ".$dealcond."   and AdvisorType='".$adtype ."'
                                                                     AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                                                     " )
                                                                     UNION (
                                                                     SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                                     FROM manda AS peinv, pecompanies AS c,manda_investors AS pe, peinvestors AS inv, 
                                                                     advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp  ".$dealtype." 
                                                                     WHERE Deleted =0 AND pe.MandAId = peinv.MandAId
                                                                    AND inv.InvestorId = pe.InvestorId 
                                                                     AND c.PECompanyId = peinv.PECompanyId
                                                                     AND adcomp.CIAId = cia.CIAID and Investor like '%$keyword%'    ".$dealcond."   and AdvisorType='".$adtype ."'
                                                                     AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                                                     " )	ORDER BY Cianame"; 

                                                                $advisorsql=$showallsql;
                                                             //echo "<br> Investor search- ".$showallsql;
                                                        }
                                                        elseif($sectorsearch!="")
                                                        {
                                                                $showallsql="(
                                                                     SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac     ".$dealtype." 
                                                                     WHERE Deleted =0
                                                                     AND c.PECompanyId = peinv.PECompanyId
                                                                     AND adac.CIAId = cia.CIAID and c.sector_business LIKE '%$sectorsearch%'    ".$dealcond."   and AdvisorType='".$adtype ."'
                                                                     AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                                                     " )
                                                                     UNION (
                                                                     SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp     ".$dealtype." 
                                                                     WHERE Deleted =0
                                                                     AND c.PECompanyId = peinv.PECompanyId
                                                                     AND adcomp.CIAId = cia.CIAID and c.sector_business LIKE '%$sectorsearch%'    ".$dealcond."   and AdvisorType='".$adtype ."'
                                                                     AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                                                     " )	ORDER BY Cianame";

                                                                $advisorsql=$showallsql;
                                                            //echo "<br> sector search- ".$showallsql;
                                                        }
                                                        elseif($searchallfield!="")
                                                        {
                                                            $findTag = strpos($searchallfield,'tag:');
                                                            $findTags = "$findTag";
                                                            if($findTags == ''){
                                                                $tagsval = "cia.cianame LIKE '%$searchallfield%' or cia.website LIKE '%$searchallfield%' or cia.address LIKE '%$searchallfield%' or cia.city LIKE '$searchallfield%' or cia.country LIKE '$searchallfield%' or cia.phoneno LIKE '$searchallfield%' or cia.contactperson LIKE '%$searchallfield%' or cia.designation LIKE '%$searchallfield%' or cia.email LIKE '%$searchallfield%' or cia.linkedin LIKE '%$searchallfield%'";                                    
                                                            }else{
                                                                $tags = '';
                                                                $ex_tags = explode(',',$searchallfield);
                                                                if(count($ex_tags) > 0){
                                                                    for($l=0;$l<count($ex_tags);$l++){
                                                                        if($ex_tags[$l] !=''){
                                                                            $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                                            $tags .= "c.tags like '%:$value%' or ";
                                                                        }
                                                                    }
                                                                }
                                                                $tagsval = trim($tags,' or ');
                                                            }
                                                            $showallsql="(
                                                                     SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac     ".$dealtype." 
                                                                     WHERE Deleted =0
                                                                     AND c.PECompanyId = peinv.PECompanyId
                                                                     AND adac.CIAId = cia.CIAID and ( $tagsval )    ".$dealcond."  and AdvisorType='".$adtype ."'
                                                                     AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
                                                                     " )
                                                                     UNION (
                                                                     SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS CompCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                                     FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp     ".$dealtype." 
                                                                     WHERE Deleted =0
                                                                     AND c.PECompanyId = peinv.PECompanyId
                                                                     AND adcomp.CIAId = cia.CIAID and ( $tagsval )  ".$dealcond."  and AdvisorType='".$adtype ."'
                                                                     AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
                                                                     " )	ORDER BY Cianame";

                                                                $advisorsql=$showallsql;
                                                            //echo "<br> Investor search- ".$showallsql;
                                                        }
                                                        else
                                                        {

                                                            $companysql= "(SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac   ".$dealtype."  WHERE c.RegionId=re.RegionId and";
                                                            $companysql2= "SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp   ".$dealtype."  WHERE c.RegionId=re.RegionId and";

                                                            //echo "<br> individual where clauses have to be merged ";
                                                            if ($industry > 0)
                                                                    $whereind = " c.industry=" .$industry ;

                                                            if ($investorType!= "")
                                                                    $whereInvType = " peinv.InvestorType = '".$investorType."'";


                                                        if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                                                        {
                                                                $startRangeValue=$startRangeValue;
                                                                $endRangeValue=$endRangeValue-0.01;
                                                                $qryRangeTitle="Deal Range (M$) - ";
                                                                if($startRangeValue < $endRangeValue)
                                                                {
                                                                        $whererange = " peinv.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                                                }
                                                                elseif($startRangeValue = $endRangeValue)
                                                                {
                                                                        $whererange = " peinv.amount >= ".$startRangeValue ."";
                                                                }
                                                        }

                                                        if($hidedateStartValue !="" && $hidedateEndValue!=''){
                                                             $wheredates= " dates between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
                                                        }

                                                        if ($whereind != "")
                                                        {
                                                                $companysql=$companysql . $whereind ." and ";
                                                                $companysql2=$companysql2 . $whereind ." and ";
                                                        }

                                                        if ($whereInvType != "")
                                                        {
                                                                $companysql=$companysql . $whereInvType ." and ";
                                                                $companysql2=$companysql2 . $whereInvType ." and ";
                                                        }

                                                        if (($whererange != "") )
                                                        {
                                                                $companysql=$companysql .$whererange . " and ";
                                                                $companysql2=$companysql2 .$whererange . " and ";
                                                        }


                                                        if(($wheredates != "") )
                                                        {
                                                                $companysql = $companysql.$wheredates ." and ";
                                                                $companysql2 = $companysql2.$wheredates ." and ";
                                                        }


                                                        $companysql = $companysql ." Deleted =0
                                                                     AND c.PECompanyId = peinv.PECompanyId
                                                                     AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                                                                     AND adac.PEId = peinv.MandAId " .$addVCFlagqry.   "$dealcond"   ;
                                                        $companysql2 = $companysql2 ." Deleted =0
                                                                     AND c.PECompanyId = peinv.PECompanyId
                                                                     AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                                                                     AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.   "$dealcond"   ;



                                                        $showallsql=$companysql.") UNION (".$companysql2.") ";

                                                        $orderby="order by Cianame"; 
                                                        $showallsql=$showallsql.$orderby;
                                                         $advisorsql=$showallsql;

                                                        //echo $showallsql;

                                                        }                                          
                                                        
//							$advisorsql="(
//									SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
//									FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac
//									WHERE Deleted =0
//									AND c.PECompanyId = peinv.PECompanyId
//									AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
//									AND adac.PEId = peinv.MandAId " .$addVCFlagqry.
//									" )
//									UNION (
//									SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
//									FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp
//									WHERE Deleted =0
//									AND c.PECompanyId = peinv.PECompanyId
//									AND adcomp.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
//									AND adcomp.PEId = peinv.MandAId " .$addVCFlagqry.
//									" )	ORDER BY Cianame";
//							//echo "<Br>M&A---" .$advisorsql;
                                                }
                                                elseif($pe_vc_flag == 3 || $pe_vc_flag == 4 || $pe_vc_flag == 5) //investment page
						{
                                                  $columntitle="Advisor - Investors";
                                                        if($pe_vc_flag==3)
							{
								//$addVCFlagqry="";
								$addVCFlagqry = "";
								$pagetitle="SV-Advisors-".$adtitledisplay;
								$dbtype="SV";
							}
							elseif($pe_vc_flag==4)
							{
								//$addVCFlagqry="";
								$addVCFlagqry = "";
								$pagetitle="CT-Advisors-".$adtitledisplay;
								$dbtype="CT";
							}
							if($pe_vc_flag==5)
							{
								//$addVCFlagqry="";
								$addVCFlagqry = "";
								$pagetitle="IF-Advisors-".$adtitledisplay;
								$dbtype="IF";
							}
                                                        
                                                        
                                                        if($advisorsearch_trans!="")
                                                        {
                                                            $showallsql="(
                                                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
                                                            peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                                                            WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
                                                            " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                                            AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = peinv.PEId)
                                                            UNION (
                                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
                                                            peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                                                            WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
                                                            " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                                            AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = peinv.PEId ) order by Cianame";
                                                            //echo "<br> Investor search- ".$showallsql;
                                                            $advisorsql=$showallsql;

                                                        }
                                                        else if($advisorsearch_legal!="")
                                                        {
                                                            $showallsql="(
                                                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
                                                            peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                                                            WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
                                                            " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                                            AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = peinv.PEId)
                                                            UNION (
                                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
                                                            peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                                                            WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
                                                            " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                                            AND adac.CIAId = cia.CIAID AND cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = peinv.PEId ) order by Cianame";
                                                            //echo "<br> Investor search- ".$showallsql;
                                                            $advisorsql=$showallsql;

                                                        }
                                                         elseif($companysearch!="")
                                                        {
                                                             $showallsql="(
                                                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
                                                            peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                                                            WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
                                                            " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                                            AND adac.CIAId = cia.CIAID  and c.companyname LIKE '%$companysearch%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = peinv.PEId)
                                                            UNION (
                                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
                                                            peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                                                            WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
                                                            " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                                            AND adac.CIAId = cia.CIAID  and c.companyname LIKE '%$companysearch%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = peinv.PEId ) order by Cianame";

                                                                $advisorsql=$showallsql;
                                                            //echo "<br> Investor search- ".$showallsql;
                                                        }
                                                        elseif($keyword!="")
                                                        {
                                                             $showallsql="(
                                                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments_investors as pe,peinvestments AS peinv, pecompanies AS c,peinvestors as inv, advisor_cias AS cia,
                                                            peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                                                            WHERE pe.PEId=peinv.PEId and inv.InvestorId=pe.InvestorId and peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
                                                            " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                                            AND adac.CIAId = cia.CIAID  and Investor like '%$keyword%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = peinv.PEId)
                                                            UNION (
                                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments_investors as pe,peinvestments AS peinv, pecompanies AS c,peinvestors as inv,  advisor_cias AS cia,
                                                            peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                                                            WHERE  pe.PEId=peinv.PEId and inv.InvestorId=pe.InvestorId and peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
                                                            " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                                            AND adac.CIAId = cia.CIAID  and Investor like '%$keyword%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = peinv.PEId ) order by Cianame";

                                                                $advisorsql=$showallsql;
                                                                 // echo "<br> Investor search- ".$showallsql;

                                                        }
                                                        elseif($sectorsearch!="")
                                                        {
                                                             $showallsql="(
                                                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
                                                            peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                                                            WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
                                                            " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                                            AND adac.CIAId = cia.CIAID  and c.sector_business LIKE '%$sectorsearch%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = peinv.PEId)
                                                            UNION (
                                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
                                                            peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                                                            WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
                                                            " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                                            AND adac.CIAId = cia.CIAID  and c.sector_business LIKE '%$sectorsearch%' and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = peinv.PEId ) order by Cianame";

                                                                $advisorsql=$showallsql;
                                                            //echo "<br> sector search- ".$showallsql;
                                                        }
                                                        elseif($searchallfield!="")
                                                        {
                                                            $findTag = strpos($searchallfield,'tag:');
                                                            $findTags = "$findTag";
                                                            if($findTags == ''){
                                                                $tagsval = "cia.cianame LIKE '%$searchallfield%' or cia.website LIKE '%$searchallfield%' or cia.address LIKE '%$searchallfield%' or cia.city LIKE '$searchallfield%' or cia.country LIKE '$searchallfield%' or cia.phoneno LIKE '$searchallfield%' or cia.contactperson LIKE '%$searchallfield%' or cia.designation LIKE '%$searchallfield%' or cia.email LIKE '%$searchallfield%' or cia.linkedin LIKE '%$searchallfield%'";                                    
                                                            }else{
                                                                $tags = '';
                                                                $ex_tags = explode(',',$searchallfield);
                                                                if(count($ex_tags) > 0){
                                                                    for($l=0;$l<count($ex_tags);$l++){
                                                                        if($ex_tags[$l] !=''){
                                                                            $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                                            $tags .= "c.tags like '%:$value%' or ";
                                                                        }
                                                                    }
                                                                }
                                                                $tagsval = trim($tags,' or ');
                                                            }
                                                             $showallsql="(
                                                            SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
                                                            peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb
                                                            WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
                                                            " AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                                            AND adac.CIAId = cia.CIAID  and ( $tagsval ) and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = peinv.PEId)
                                                            UNION (
                                                            SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                                            FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
                                                            peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
                                                            WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
                                                            " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                                            AND adac.CIAId = cia.CIAID  and ( $tagsval ) and AdvisorType='".$adtype ."'
                                                            AND adac.PEId = peinv.PEId ) order by Cianame";

                                                                $advisorsql=$showallsql;
                                                            //echo "<br> Investor search- ".$showallsql;
                                                        }
                                                        else
                                                        {

                                                            $companysql= "(SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM peinvestments AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb WHERE c.RegionId=re.RegionId and";
                                                            $companysql2= "SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM peinvestments AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,peinvestments_advisorcompanies AS adac, stage as s,peinvestments_dbtypes as pedb WHERE c.RegionId=re.RegionId and";

                                                            //echo "<br> individual where clauses have to be merged ";
                                                            if ($industry > 0)
                                                                    $whereind = " c.industry=" .$industry ;

                                                            if ($investorType!= "")
                                                                    $whereInvType = " peinv.InvestorType = '".$investorType."'";

                                                            if ($stageval!='')
                                                            {
                                                                    $stagevalue="";
                                                                    $stageidvalue="";
                                                                     $stageidvalue=explode(",",$stageval);
                                                                    foreach($stageidvalue as $stage)
                                                                    {
                                                                            //echo "<br>****----" .$stage;
                                                                            $stagevalue= $stagevalue. " peinv.StageId=" .$stage." or ";
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

                                                           if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--")  )
                                                           {
                                                                   $startRangeValue=$startRangeValue;
                                                                   $endRangeValue=$endRangeValue-0.01;
                                                                   $qryRangeTitle="Deal Range (M$) - ";
                                                                   if($startRangeValue < $endRangeValue)
                                                                   {
                                                                           $whererange = " peinv.amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                                                   }
                                                                   elseif($startRangeValue = $endRangeValue)
                                                                   {
                                                                           $whererange = " peinv.amount >= ".$startRangeValue ."";
                                                                   }
                                                           }

                                                        if($hidedateStartValue !="" && $hidedateEndValue!=''){
                                                              $wheredates= " dates between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
                                                         }

                                                        if ($whereind != "")
                                                        {
                                                                $companysql=$companysql . $whereind ." and ";
                                                                $companysql2=$companysql2 . $whereind ." and ";
                                                        }

                                                        if ($whereInvType != "")
                                                        {
                                                                $companysql=$companysql . $whereInvType ." and ";
                                                                $companysql2=$companysql2 . $whereInvType ." and ";
                                                        }

                                                        if (($wherestage != ""))
                                                        {
                                                                 $companysql=$companysql ."(".$wherestage.") and " ;
                                                                 $companysql2=$companysql2 ."(".$wherestage.") and " ;

                                                        }

                                                        if (($whererange != "") )
                                                        {
                                                                $companysql=$companysql .$whererange . " and ";
                                                                $companysql2=$companysql2 .$whererange . " and ";
                                                        }


                                                        if(($wheredates != "") )
                                                        {
                                                                $companysql = $companysql.$wheredates ." and ";
                                                                $companysql2 = $companysql2.$wheredates ." and ";
                                                        }

                                                        $companysql = $companysql ." peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
                                                            " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                                            AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                                                            AND adac.PEId = peinv.PEId ";
                                                        $companysql2 = $companysql2 ." peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
                                                            " AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                                                            AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search." ".$dirsearchall." 
                                                            AND adac.PEId = peinv.PEId ";
                                                        
                                                        $showallsql=$companysql.") UNION (".$companysql2.") ";

                                                        $orderby="order by Cianame"; 
                                                        $showallsql=$showallsql.$orderby;
                                                        $advisorsql=$showallsql;
                                                        //echo $showallsql;

                                                        }
                                                        
//							$advisorsql="(
//								SELECT distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
//								FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
//								peinvestments_advisorinvestors AS adac, stage as s ,peinvestments_dbtypes as pedb
//								WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
//								" AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
//								AND adac.CIAId = cia.CIAID   and AdvisorType='".$adtype ."'
//								AND adac.PEId = peinv.PEId)
//								UNION (
//								SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
//								FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
//								peinvestments_advisorcompanies AS adac, stage as s ,peinvestments_dbtypes as pedb
//								WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
//								" AND c.PECompanyId = peinv.PECompanyId and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
//								AND adac.CIAId = cia.CIAID  and AdvisorType='".$adtype ."'
//								AND adac.PEId = peinv.PEId ) order by Cianame	";
//						 //echo "<Br>PE - VC---((()))" .$advisorsql;
						}
                                             /*   if($pe_ipo_manda_flag==4) //mama
						{
                                                  $columntitle="Advisor - Acquirer";
							if($pe_vc_flag==1)
							{
								$addVCFlagqry="";
								$pagetitle="M&A-Advisors-".$adtitledisplay;
							}

							$advisorsql="(
                        					SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId
                        				        FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
                        					WHERE Deleted =0
                        					AND c.PECompanyId = peinv.PECompanyId
                        					AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."'
                        					AND adac.MAMAId = peinv.MAMAId " .$addVCFlagqry.
                        					" )
                        					UNION (
                        					SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId
                        			                FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp
                        					WHERE Deleted =0
                        					AND c.PECompanyId = peinv.PECompanyId
                        					AND adcomp.CIAId = cia.CIAID  and AdvisorType='".$adtype ."'
                        					AND adcomp.MAMAId = peinv.MAMAId " .$addVCFlagqry.
                        					" )	ORDER BY Cianame";


						//	echo "<Br>M&A---" .$advisorsql;
					            }*/

                                
				$sql = $_POST['sqlquery'];
//                                echo "<br>---" .$sql;
//                                exit();
				 //execute query
				 $result = @mysql_query($sql) or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
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
				 header("Content-Disposition: attachment; filename=$pagetitle.$file_ending");
				 header("Pragma: no-cache");
				 header("Expires: 0");

				 /*    Start of Formatting for Word or Excel    */
				 /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */
				 	//create title with timestamp:
                                if ($Use_Title == 1)
                                { 		
                                    echo("$title\n"); 	
                                }

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
                                echo "Advisor"."\t";
                                echo "Advisor - Companies"."\t";
                                echo $columntitle."\t";
                                //echo "Advisor - Investors "."\t";
                                echo "Address"."\t";
                                echo "City"."\t";
                                echo "Country"."\t";
                                echo "Phone No."."\t";
                                echo "Website"."\t";
                                echo "Contact Person"."\t";
                                echo "Designation"."\t";
                                echo "Email ID"."\t";
                                echo "Co Linkedin Profile"."\t";
                                print("\n");

				 /*print("\n");*/
				 //end of printing column names

				 //start while loop to get data
				 /*
				 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
				 */
                                        $pe_ipo_manda_flag=$pe_vc_flag;
				 	$searchString="Undisclosed";
				 	$searchString=strtolower($searchString);
					$searchStringDisplay="Undisclosed";

				 	$searchString1="Unknown";
				 	$searchString1=strtolower($searchString1);

				 	$searchString2="Others";
				 	$searchString2=strtolower($searchString2);

				     while($row = mysql_fetch_array($result))
				     {
				         //set_time_limit(60); // HaRa
                                        $schema_insert = "";

				        $AdvisorId=$row['CIAId'];//advisorid
					$schema_insert .=$row['Cianame'].$sep; //advisor name

					if($pe_vc_flag==0 || $pe_vc_flag==1)
					{
                                                if($pe_vc_flag==0)
                                                {
                                                        $addVCFlagqry="";
                                                        $pagetitle="PE-Advisors-".$adtitledisplay;
                                                }
                                                elseif($pe_vc_flag==1)
                                                {
                                                        //$addVCFlagqry="";
                                                        $addVCFlagqry = "and s.VCview=1 and peinv.amount<=20 ";
                                                        $pagetitle="VC-Advisors-".$adtitledisplay;
                                                }
						$advisor_to_companysql="
						SELECT  distinct adac.CIAId, cia.Cianame,i.industry, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
						DATE_FORMAT( dates, '%M-%Y' ) AS dt,peinv.PEId as PEId
						FROM peinvestments AS peinv, pecompanies AS c,industry as i,  advisor_cias AS cia,
						peinvestments_advisorcompanies AS adac, stage as s
						WHERE peinv.Deleted=0 and c.industry = i.industryid and s.StageId = peinv.StageId  " .$addVCFlagqry.
						" AND c.PECompanyId = peinv.PECompanyId
						AND adac.CIAId = cia.CIAID
						AND adac.PEId = peinv.PEId and adac.CIAId=$AdvisorId order by Cianame";

						$advisor_to_investorsql="
						SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.PEId as PEId,c.Companyname,
						DATE_FORMAT( dates, '%M-%Y' ) AS dt,i.industry
						FROM peinvestments AS peinv, pecompanies AS c,industry as i, advisor_cias AS cia,
						peinvestments_advisorinvestors AS adac, stage as s,peinvestors as inv,peinvestments_investors as pe_inv
						WHERE peinv.Deleted=0 and c.industry = i.industryid and  s.StageId = peinv.StageId ".$addVCFlagqry.
						" AND c.PECompanyId = peinv.PECompanyId
						AND adac.CIAId = cia.CIAID and pe_inv.PEId=peinv.PEId and inv.InvestorId=pe_inv.InvestorId
						AND adac.PEId = peinv.PEId and adac.CIAId=$AdvisorId order by dt";
					}
					elseif($pe_vc_flag==9 || $pe_vc_flag==10 || $pe_vc_flag==11)
					{
						$advisor_to_companysql="
						SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
						DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MandAId as PEId
						FROM manda AS peinv, pecompanies AS c,  advisor_cias AS cia,
						peinvestments_advisorcompanies AS adac
						WHERE peinv.Deleted=0 " .$addVCFlagqry.
						" AND c.PECompanyId = peinv.PECompanyId
						AND adac.CIAId = cia.CIAID
						AND adac.PEId = peinv.MandAId and adac.CIAId=$AdvisorId order by Cianame";

						$advisor_to_investorsql="
						SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.MandaId  as PEId ,c.Companyname,
						DATE_FORMAT( DealDate, '%M-%Y' ) AS dt
						FROM manda AS peinv, pecompanies AS c, advisor_cias AS cia,
						peinvestments_advisoracquirer AS adac
						WHERE peinv.Deleted=0 ".$addVCFlagqry.
						" AND c.PECompanyId = peinv.PECompanyId
						AND adac.CIAId = cia.CIAID
						AND adac.PEId = peinv.MandAId and adac.CIAId=$AdvisorId order by dt";
					}
					elseif($pe_vc_flag==3 || $pe_vc_flag==4 || $pe_vc_flag==5) //social investment /CT / IF advisors page
                                        {

                                                        $advisor_to_companysql="
							SELECT  distinct peinv.PEId as PEId,adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
							DATE_FORMAT( dates, '%M-%Y' ) AS dt
							FROM peinvestments AS peinv, pecompanies AS c,  advisor_cias AS cia,
							peinvestments_advisorcompanies AS adac, stage as s
							WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId  " .$addVCFlagqry.
							" AND c.PECompanyId = peinv.PECompanyId
							AND adac.CIAId = cia.CIAID
							AND adac.PEId = peinv.PEId and adac.CIAId=$AdvisorId
                                                        AND peinv.PEId
                                                        IN (
                
                                                        SELECT PEId
                                                        FROM peinvestments_dbtypes AS db
                                                        WHERE DBTypeId='$dbtype'
                                                        )
                                                         order by dt";

							$advisor_to_investorsql="
							SELECT distinct peinv.PEId as PEId,peinv.PECompanyId,adac.CIAId AS AcqCIAId,c.Companyname,
							DATE_FORMAT( dates, '%M-%Y' ) AS dt
							FROM peinvestments AS peinv, pecompanies AS c, advisor_cias AS cia,
							peinvestments_advisorinvestors AS adac, stage as s,peinvestors as inv,peinvestments_investors as pe_inv
							WHERE peinv.Deleted=0 and  s.StageId = peinv.StageId ".$addVCFlagqry.
							" AND c.PECompanyId = peinv.PECompanyId
							AND adac.CIAId = cia.CIAID and pe_inv.PEId=peinv.PEId and inv.InvestorId=pe_inv.InvestorId
							AND adac.PEId = peinv.PEId and adac.CIAId=$AdvisorId
                                                        AND peinv.PEId
                                                        IN (
                
                                                        SELECT PEId
                                                        FROM peinvestments_dbtypes AS db
                                                        WHERE DBTypeId='$dbtype'
                                                        )
                                                        order by dt";
                                                        //echo "<br><br>".$advisor_to_companysql;
                                                        //echo "<br>".$advisor_to_investorsql;
                                        }
                                      elseif($pe_ipo_manda_flag==4) //mama
                                      {
                                       $advisor_to_investorsql="SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PEcompanyId,c.Companyname,
                        					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MAMAId as PEId
                                                                FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
                        					WHERE Deleted =0
                        					AND c.PECompanyId = peinv.PECompanyId    and adac.CIAId=$AdvisorId
                        					AND adac.CIAId = cia.CIAID
                        					AND adac.MAMAId = peinv.MAMAId  order by dt";

                        				$advisor_to_companysql=
                                                        "SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId,peinv.PEcompanyId,c.Companyname,
                        					DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MAMAId as PEId
                                                                FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp
                        					WHERE Deleted =0
                        					AND c.PECompanyId = peinv.PECompanyId  and adcomp.CIAId=$AdvisorId
                        					AND adcomp.CIAId = cia.CIAID
                        					AND adcomp.MAMAId = peinv.MAMAId order by dt";
                        				//echo "<BR>-- ".$advisor_to_companysql;
                        				//echo "<br>^^^".$advisor_to_investorsql;
                                      }
						if($rsMgmt= mysql_query($advisor_to_companysql))
						{
							$MgmtTeam="";
							While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
							{
								$cname= $mymgmtrow["Companyname"];
								$dealperiod=$mymgmtrow["dt"];
                                                                $indus=$mymgmtrow["industry"];
								$MgmtTeam=$MgmtTeam.",".$cname."(".$indus.";".$dealperiod.")";
							}
							$MgmtTeam=substr_replace($MgmtTeam, '', 0,1);
						}
						$schema_insert .=$MgmtTeam.$sep; //Advisor - Company


						if($rsInvestors= mysql_query($advisor_to_investorsql))
						{
							$strInvestor="";
							While($myinvestrow=mysql_fetch_array($rsInvestors, MYSQL_BOTH))
							{
								$compname= $myinvestrow["Companyname"];
								$dealperioddt=$myinvestrow["dt"];
                                                                $industryinv=$myinvestrow["industry"];
								$strInvestor=$strInvestor.",".$compname."(".$industryinv.";".$dealperioddt.")";
							}
							$strInvestor=substr_replace($strInvestor, '', 0,1);
						}
						$schema_insert .=$strInvestor.$sep; //Advisor - Investor - Company

						$schema_insert .=$row['address'].$sep; //advisor address                                                
						$schema_insert .=$row['city'].$sep; //city                                                
						$schema_insert .=$row['country'].$sep; //country                                             
						$schema_insert .=$row['phoneno'].$sep; //phone no                                                 
						$schema_insert .=$row['website'].$sep; //website                                              
						$schema_insert .=$row['contactperson'].$sep; //Contact person                                       
						$schema_insert .=$row['designation'].$sep; //Designation                                       
						$schema_insert .=$row['email'].$sep; //Email ID                                      
						$schema_insert .=$row['linkedin'].$sep; //linkedin

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
											$subject="Advisor Profile ";
											$message="<html><center><b><u> Advisor Profile : - $pagetitle - $submitemail</u></b></center><br>
											<head>
											</head>
											<body >
											<table border=1 cellpadding=0 cellspacing=0  width=74% >
											<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
											<tr><td width=1%>Advisors</td><td width=99%>$pagetitle</td></tr>
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


				//		}
				//else
				//	header( 'Location: http://www.ventureintelligence.in/pelogin.php' ) ;

   mysql_close();
    mysql_close($cnx);
    ?>


