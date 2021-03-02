<?php include_once("../globalconfig.php"); ?>
<?php
 //session_save_path("/tmp");
//	session_start();

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
			$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";

                        $columntitle="";
                        $submitemail=$_POST['txthideemail'];
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

                        $companysearch=$_POST['txthidecompany'];
                        $keyword=$_POST['txthidekeyword'];
                        $sectorsearch=$_POST['txthidesector'];
                        $advisorsearch_legal=$_POST['txthideadvisorlegal'];
                        $advisorsearch_trans=$_POST['txthideadvisortrans'];
                       $searchallfield=$_POST['searchallfield'];

                        $tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";

                        if($pe_ipo_manda_flag==1)
                                $frmwhichpage="Investments";
                        elseif($pe_ipo_manda_flag==2)
                                $frmwhichpage="IPO-Exits";
                        elseif($pe_ipo_manda_flag==3)
                                $frmwhichpage="M&A-Exits";
                        elseif($pe_ipo_manda_flag ==4)
                                $frmwhichpage="PE Dir";
                        elseif($pe_ipo_manda_flag==5)
                        $frmwhichpage="Individual";

                        //$keyword=$isShowAll;
                        // investments investors						
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
                       /* if($pe_vc_flag==0 || $pe_vc_flag==1)
                        {
  
                            if($companysearch!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                          FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                          WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                          AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                          AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and pec.companyname LIKE '%$companysearch%'
                                          ORDER BY pec.companyname";

                                    $getcompanySql=$showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            else if($keyword!="")
                            {
                                
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                          FROM peinvestments_investors as peinv,pecompanies AS pec, peinvestments AS pe,peinvestors as inv, industry AS i, region AS r , stage AS s
                                          WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                          AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                          AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and Investor like '%$keyword%'
                                          ORDER BY pec.companyname";
                                    
                                    $getcompanySql=$showallsql;
                                //echo "<br> Investor search 0 or 1- ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                          FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                          WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                          AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                          AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and pec.sector_business like '%$sectorsearch%'
                                          ORDER BY pec.companyname";
                                    
                                    $getcompanySql=$showallsql;
                                //echo "<br> sector search 0 or 1- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                
                                $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, advisor_cias AS cia,
                                            peinvestments_advisorinvestors AS adac, industry AS i, region AS r , stage AS s
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " AND adac.CIAId = cia.CIAID AND 
                                            cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='L' AND adac.PEId = pe.PEId)
                                            UNION (SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, advisor_cias AS cia,
                                            peinvestments_advisorcompanies AS adac, industry AS i, region AS r , stage AS s
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " AND adac.CIAId = cia.CIAID AND 
                                            cia.cianame LIKE '%$advisorsearch_legal%' and AdvisorType='L' AND adac.PEId = pe.PEId) 
                                            ORDER BY companyname";
                                    
                                    $getcompanySql=$showallsql;
                                //echo "<br>advisor_legal search 0 or 1- 102l".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                    $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, advisor_cias AS cia,
                                            peinvestments_advisorinvestors AS adac, industry AS i, region AS r , stage AS s
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " AND adac.CIAId = cia.CIAID AND 
                                            cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='T' AND adac.PEId = pe.PEId)
                                            UNION (SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, advisor_cias AS cia,
                                            peinvestments_advisorcompanies AS adac, industry AS i, region AS r , stage AS s
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " AND adac.CIAId = cia.CIAID AND 
                                            cia.cianame LIKE '%$advisorsearch_trans%' and AdvisorType='T' AND adac.PEId = pe.PEId) 
                                            ORDER BY companyname";
                                    
                                    $getcompanySql=$showallsql;
                               //echo "<br> $advisor_trans search 0 or 1-102t ".$showallsql;
                            }
                            else if($searchallfield!="")
                            {
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                            OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%'";                                    
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
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                          FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                          WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                          AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                          AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and ( $tagsval )
                                          ORDER BY pec.companyname";

                                    $getcompanySql=$showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            else
                            {
                            $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                          FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                                          WHERE ";

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
                                        $showallsql=$showallsql . $whereind ." and ";
                                }

                                if (($wherestage != ""))
                                {
                                    $showallsql=$showallsql ."(".$wherestage.") and" ;

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
                                if(($wheredates != "") )
                                {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                                }

                                $showallsql = $showallsql. " pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                                          AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                          AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall."
                                          ORDER BY pec.companyname";
                                $getcompanySql=$showallsql;
                            }
                        }                        
                         else if($pe_vc_flag==2) {
                         if($_POST['txthidedv']==102)
                                {
                                    if($searchallfield!="")
                                    {
                                        $findTag = strpos($searchallfield,'tag:');
                                        $findTags = "$findTag";
                                        if($findTags == ''){
                                            $tagsval = "i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                            OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%'";                                    
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

                                     $showallsql="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                                 FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                                 WHERE pec.PECompanyId = pe.InvesteeId 
                                                 AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                         AND r.RegionId = pec.RegionId and ( $tagsval ) " .$addVCFlagqry. " ".$dirsearchall."
                                                         ORDER BY pec.companyname";

                                    }else{
                                             $showallsql="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                                         FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                                         WHERE pec.PECompanyId = pe.InvesteeId 
                                                         AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                 AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall."
                                                 ORDER BY pec.companyname";

                                     $showallsql="SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region
                                                 FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r
                                                 WHERE pec.PECompanyId = pe.InvesteeId 
                                                 AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                 AND r.RegionId = pec.RegionId " .$addVCFlagqry. " ".$dirsearchall."
                                                 ORDER BY pec.companyname";
                                }
                                    }
                                   $getcompanySql=$showallsql;  
                        }                        
                        elseif($pe_vc_flag==3 || $pe_vc_flag==4 || $pe_vc_flag==5)
                        {
                            if($companysearch!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                                FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                                stage AS s ,peinvestments_dbtypes as pedb
                                                WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                                and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and pec.companyname LIKE '%$companysearch%' ORDER BY pec.companyname";

                                    $getcompanySql=$showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            elseif($keyword!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM peinvestments_investors as peinv,pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestors as inv,peinvestments_dbtypes as pedb
                                            WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. "  and Investor like '%$keyword%'  ORDER BY pec.companyname";
                              
                                    $getcompanySql=$showallsql;
                                      //echo "<br> Investor search- ".$showallsql;
                                    
                            }
                            elseif($sectorsearch!="")
                            {
                                     $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and pec.sector_business LIKE '%$sectorsearch%' ORDER BY pec.companyname";
                                    
                                    $getcompanySql=$showallsql;
                               // echo "<br> sector search- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                     $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb, advisor_cias AS cia,peinvestments_advisorinvestors AS adac 
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. "  and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' ORDER BY pec.companyname
                                            )
                                        UNION(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb, advisor_cias AS cia,peinvestments_advisorcompanies AS adac 
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. "  and cia.cianame LIKE '%$advisorsearch_legal%'  and AdvisorType='L' ORDER BY pec.companyname
                                            )";
                                    
                                    $getcompanySql=$showallsql;
                                //echo "<br>advisor_legal search- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                    $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb, advisor_cias AS cia,peinvestments_advisorinvestors AS adac 
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. "  and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' ORDER BY pec.companyname
                                            )
                                        UNION(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                            FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                            stage AS s ,peinvestments_dbtypes as pedb, advisor_cias AS cia,peinvestments_advisorcompanies AS adac 
                                            WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and adac.CIAId = cia.CIAID AND adac.PEId = pe.PEId and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. "  and cia.cianame LIKE '%$advisorsearch_trans%'  and AdvisorType='T' ORDER BY pec.companyname
                                            )";
                                    
                                    $getcompanySql=$showallsql;
                                //echo "<br> $advisor_trans search- ".$showallsql;
                            }
                            else if($searchallfield!="")
                            {
                                $findTag = strpos($searchallfield,'tag:');
                                $findTags = "$findTag";
                                if($findTags == ''){
                                    $tagsval = "i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                            OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%'";                                    
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
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                                FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                                stage AS s ,peinvestments_dbtypes as pedb
                                                WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                                and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                                AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and ( $tagsval ) ORDER BY pec.companyname";

                                    $getcompanySql=$showallsql;
                            }
                            else
                            {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                                FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,
                                                stage AS s ,peinvestments_dbtypes as pedb
                                                WHERE ";
                                if ($industry > 0)
                                        $whereind = " pec.industry=" .$industry ;

                                if ($investorType!= "")
                                        $whereInvType = " pe.InvestorType = '".$investorType."'";

                                if ($stageval!='')
                                {
                                        $stagevalue="";
                                        $stageidvalue="";
                                        $stageidvalue=explode(",",$stageval);
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
                                        $showallsql=$showallsql . $whereind ." and ";
                                }
                                
                                if (($whereInvType != "") )
                                {
                                        $showallsql=$showallsql.$whereInvType . " and ";
                                        $bool=true;
                                }
                                if (($wherestage != ""))
                                {
                                    $showallsql=$showallsql ."(".$wherestage.") and" ;

                                }
                                if (($whererange != "") )
                                {
                                        $showallsql=$showallsql.$whererange . " and ";
                                        $bool=true;
                                }
                                if(($wheredates != "") )
                                {
                                         $showallsql = $showallsql . $wheredates ." and ";
                                         $bool=true;
                                }
                                $showallsql = $showallsql. " pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                            and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                            AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall."
                                            ORDER BY pec.companyname";
                                    
                                $getcompanySql=$showallsql;
                            }
                     
                        }
                        elseif($pe_vc_flag==7 || $pe_vc_flag==8)
                        {
                
                            if($companysearch!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                                        WHERE pec.PECompanyId = pe.PEcompanyId 
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and pec.companyname LIKE '%$companysearch%' 
                                        ORDER BY pec.companyname";

                                    $getcompanySql=$showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            else if($keyword!="")
                            {
                                 $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r, ipo_investors AS peinv, peinvestors AS inv
                                        WHERE pec.PECompanyId = pe.PEcompanyId
                                        AND peinv.IPOId = pe.IPOId
                                        AND inv.InvestorId = peinv.InvestorId
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and Investor like '%$keyword%'
                                        ORDER BY pec.companyname";
                                
                                $getcompanySql=$showallsql;
                                // echo "<br> sector search- ".$showallsql;
                            }
                            elseif($sectorsearch!="")
                            {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                                        WHERE pec.PECompanyId = pe.PEcompanyId 
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and pec.sector_business LIKE '%$sectorsearch%' 
                                        ORDER BY pec.companyname";
                                
                                $getcompanySql=$showallsql;
                                // echo "<br> sector search- ".$showallsql;
                            }
                            else  if($searchallfield!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                        FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                                        WHERE pec.PECompanyId = pe.PEcompanyId 
                                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                        AND r.RegionId = pec.RegionId " .$addVCFlagqry. " and ( i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                            OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%')
                                        ORDER BY pec.companyname";

                                    $getcompanySql=$showallsql;
                                //echo "<br>  search- ".$showallsql;
                            }
                            else
                            {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                      FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                                      WHERE ";
                                
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
                               
                                if($hidedateStartValue !="" && $hidedateEndValue!=''){
                                    $wheredates= " IPODate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
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
                                 
                               if(($wheredates != "") )
                               {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                $showallsql = $showallsql. " pec.PECompanyId = pe.PEcompanyId 
                                      AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                      AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall." 
                                      ORDER BY pec.companyname";
                                
                                $getcompanySql=$showallsql;
                            }
                        }
                        else if($pe_vc_flag==9 ||$pe_vc_flag==10 || $pe_vc_flag==11 || $pe_vc_flag==12)
                        {
                            $dealtype=' , dealtypes as dt '; 
                            if($pe_vc_flag==9 || $pe_vc_flag==12) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1'; }
                            else if($pe_vc_flag==10 || $pe_vc_flag==11) { $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0'; }
                            
                            
                            if($companysearch!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r   ".$dealtype."    
                                    WHERE pec.PECompanyId = pe.PEcompanyId 
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId " .$addVCFlagqry." and pec.companyname LIKE '%$companysearch%'     ".$dealcond."  
                                    ORDER BY pec.companyname";

                                    $getcompanySql=$showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            elseif($keyword!="")
                            {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, industry AS i, region AS r  ".$dealtype."    
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId 
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId " .$addVCFlagqry. " and Investor like '%$keyword%'   ".$dealcond."   order by inv.Investor";
                                
                                $getcompanySql=$showallsql;
                            }
                            
                            elseif($sectorsearch!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r  ".$dealtype."    
                                    WHERE pec.PECompanyId = pe.PEcompanyId 
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId " .$addVCFlagqry." and pec.sector_business LIKE '%$sectorsearch%'     ".$dealcond."  
                                    ORDER BY pec.companyname";
                                    
                                    $getcompanySql=$showallsql;
                               // echo "<br> sector search- ".$showallsql;
                            }
                            elseif($advisorsearch_legal!="")
                            {
                                    $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac,
                                    industry AS i, region AS r  ".$dealtype."    
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   ".$dealcond."  and AdvisorType='L'
                                         AND adac.PEId = pe.MandAId)
                                         UNION(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,
                                    industry AS i, region AS r  ".$dealtype."    
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_legal%'   ".$dealcond."  and AdvisorType='L'
                                         AND adac.PEId = pe.MandAId)";
                                    
                                    $getcompanySql=$showallsql;
                                //echo "<br>advisor_legal search- ".$showallsql;
                            }
                            elseif($advisorsearch_trans!="")
                            {
                                    $showallsql="(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisoracquirer AS adac,
                                    industry AS i, region AS r  ".$dealtype."    
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='T'
                                         AND adac.PEId = pe.MandAId)
                                         UNION(SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,
                                    industry AS i, region AS r  ".$dealtype."    
                                    WHERE pe.PECompanyId = pec.PEcompanyId
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId
                                    AND peinv.MandAId = pe.MandAId
                                    AND inv.InvestorId = peinv.InvestorId AND adac.CIAId = cia.CIAID AND cia.Cianame LIKE '%$advisorsearch_trans%'   ".$dealcond."  and AdvisorType='T'
                                         AND adac.PEId = pe.MandAId)";
                                    
                                    $getcompanySql=$showallsql;
                               // echo "<br> $advisor_trans search- ".$showallsql;
                            }else if($searchallfield!="")
                            {
                                    $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                    FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r   ".$dealtype."    
                                    WHERE pec.PECompanyId = pe.PEcompanyId 
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId " .$addVCFlagqry." and ( i.industry LIKE '$searchallfield%' or pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                            OR pec.sector_business LIKE '%$searchallfield%' or pec.AdditionalInfor like '%$searchallfield%' or pec.website like '$searchallfield%' or pec.linkedIn like '%$searchallfield%' or pec.yearfounded like '$searchallfield%' or pec.Address1 like '%$searchallfield%' or pec.Address2 like '%$searchallfield%' or pec.AdCity like '$searchallfield%' or pec.Zip like '$searchallfield%' or pec.OtherLocation like '%$searchallfield%' or pec.Country like '$searchallfield%' or pec.Telephone like '$searchallfield%' or pec.Fax like '$searchallfield%' or pec.Email like '%$searchallfield%' or pec.stockcode like '%$searchallfield%') ".$dealcond."  
                                    ORDER BY pec.companyname";

                                    $getcompanySql=$showallsql;
                                //echo "<br> Investor search- ".$showallsql;
                            }
                            else
                            {
                                $showallsql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                                FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r  ".$dealtype."    
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
                                               $whererange = " pe.DealAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                       }
                                       elseif($startRangeValue = $endRangeValue)
                                       {
                                               $whererange = " pe.DealAmount >= ".$startRangeValue ."";
                                       }
                               }
                               
                               if($hidedateStartValue !="" && $hidedateEndValue!=''){
                                    $wheredates= " DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
                                }
                                
                                if ($whereind != "")
                                {
                                        $showallsql=$showallsql . $whereind ." and ";
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
                                if(($wheredates != "") )
                               {
                                        $showallsql = $showallsql . $wheredates ." and ";
                                        $bool=true;
                               }
             
                                $showallsql = $showallsql. "  pec.PECompanyId = pe.PEcompanyId 
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId " .$addVCFlagqry. " " .$search." ".$dirsearchall."     ".$dealcond."  
                                ORDER BY pec.companyname ";
                                
                                $getcompanySql=$showallsql;
                            }
                        }
  			*/
                        $getcompanySql = $_POST['sqlquery'];
  				 $sql=$getcompanySql;
				//echo "<br>---" .$sql; exit;
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
				 	{ 		echo("$title\n"); 	}

				 	/*echo ("$tsjtitle");
				 	 print("\n");
				 	  print("\n");*/

				 //define separator (defines columns in excel & tabs in word)
				 $sep = "\t"; //tabbed character

				        echo "Company"."\t";
					echo "Industry"."\t";
					echo "Sector"."\t";
					echo "Stock Code"."\t";
                    echo "CIN No"."\t";
					echo "Year Founded"."\t";
					echo "Address"."\t";
					echo ""."\t";
					echo "City"."\t";
					//echo "Region"."\t";
					echo "Country"."\t";
					echo "Zip"."\t";
					echo "Telephone "."\t";
					echo "Fax"."\t";
					echo "Email"."\t";
					echo "Website"."\t";
					echo "Other Location(s)"."\t";
					//echo "More Information"."\t";
					echo "Investors"."\t";
					echo "Investor Board Members"."\t";
					echo "Top Management "."\t";
					echo "Exits "."\t";
					echo "Angel Investors "."\t";
                    #echo "CIN "."\t";

                                	print("\n");
				 /*print("\n");*/
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

					$invResult=substr_count($companyname,$searchString);
					$invResult1=substr_count($companyname,$searchString1);
					$invResult2=substr_count($companyname,$searchString2);
                                while($row = mysql_fetch_array($result))
				     {
				         //set_time_limit(60); // HaRa
				         $schema_insert = "";
				         $strStage="";
				         $strIndustry="";
				         $strCompany="";
				         $stripoCompany="";
				         $strmandaCompany="";
                                    $companyname=$row['companyname'];
						$companyname=strtolower($companyname);
						$invResult=substr_count($companyname,$searchString);
						$invResult1=substr_count($companyname,$searchString1);
						$invResult2=substr_count($companyname,$searchString2);

						if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
						{

                                        $companyId=$row['PECompanyId'];//CompanyId
                                        $schema_insert .=$row['companyname'].$sep; //Companyname
                                        $schema_insert .=$row['industry'].$sep; //Industry
                                        $schema_insert .=$row['sector_business'].$sep; //sector
                                        $schema_insert .=$row['stockcode'].$sep; //stockcode
                                        if($row['CINNo'] !="" ){
                                            $schema_insert .=$row['CINNo'].$sep;//CIN No
                                        }else{
                                            $schema_insert .=" ".$sep; 
                                        }
                                        $schema_insert .=$row['yearfounded'].$sep; //year founded
                                        $schema_insert .=$row['Address1'].$sep; //address1
                                        if($row['Address1']!=''){
                                            $schema_insert .=$row['Address2'].$sep; //address2
                                                                }
                                                                else{
                                                                    $schema_insert .=" ".$sep; //address2
                                                                }
                                        $schema_insert .=$row['city'].$sep; //city
                                        $schema_insert .=$row['Country'].$sep; //country
                                        $schema_insert .=$row['Zip'].$sep; //zip
                                        $schema_insert .=$row['Telephone'].$sep; //Telephone
                                        $schema_insert .=$row['Fax'].$sep; //Fax
                                        $schema_insert .=$row['Email'].$sep; //Email
                                        $schema_insert .=$row['website'].$sep; //website
                                        $schema_insert .=$row['OtherLocation'].$sep; //Other Location
								//$schema_insert .=$row[20].$sep; //Moreinformation

                                                                $investorSql="select pe.PEId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide from
									peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,
									peinvestors as inv where pe.PECompanyId=$companyId and
									peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId
									and pec.PEcompanyId=pe.PECompanyId order by dates desc";

                                                 if($rsStage= mysql_query($investorSql))
						{

							While($myInvestorRow=mysql_fetch_array($rsStage, MYSQL_BOTH))
							{
                                                           $Investorname=trim($myInvestorRow["Investor"]);
							   $Investorname=strtolower($Investorname);
							   $invResult=substr_count($Investorname,$searchString);
							   $invResult1=substr_count($Investorname,$searchString1);
							   $invResult2=substr_count($Investorname,$searchString2);
							   if($myInvestorRow["AggHide"]==1)
                                                                    $addTrancheWord="; Tranche";
                                                                else
                                                                    $addTrancheWord="";

                                                           if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
							   {
								$strStage=$strStage.", ".$myInvestorRow["Investor"]."(".$myInvestorRow["dt"].$addTrancheWord.")";
                                                           }
                                                         }
                                                        // echo "<br>***".$strStage;
                                                 }
                                               if($getcompanyrs1= mysql_query($investorSql))
					       {
                                               $AddOtherAtLast="";
					       While($myInvestorrow1=mysql_fetch_array($getcompanyrs1, MYSQL_BOTH))
						{
							$Investorname1=trim($myInvestorrow1["Investor"]);
							$Investorname1=strtolower($Investorname1);
							$invResulta=substr_count($Investorname1,$searchString);
							$invResult1b=substr_count($Investorname1,$searchString1);
							$invResult2c=substr_count($Investorname1,$searchString2);
							if($myInvestorrow1["AggHide"]==1)
                                                                    $addTrancheWord1="; Tranche";
                                                                else
                                                                    $addTrancheWord1="";
							if(($invResulta==1)|| ($invResult1b==1) || ($invResult2c==1))
							    {
								$strStage=$strStage.", ".$myInvestorrow1["Investor"]."(".$myInvestorrow1["dt"].$addTrancheWord1.")";
							    }
					                 }
						}
						$strStage =substr_replace($strStage, '', 0,1);
						$schema_insert .=$strStage.$sep; //Investors


							$onBoardSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,
								exe.ExecutiveName,exe.Designation,exe.Company from
								pecompanies as pec,executives as exe,pecompanies_board as mgmt
								where pec.PECompanyId=$companyId and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";
								if($rsBoard= mysql_query($onBoardSql))
								{
									$MgmtTeam="";
									While($myBoardRow=mysql_fetch_array($rsBoard, MYSQL_BOTH))
									{
										$Exename= $myBoardRow["ExecutiveName"];
										$Designation=$myBoardRow["Designation"];
										if($Designation!="")
											$MgmtTeam=$MgmtTeam.";".$Exename.",".$Designation;
										else
											$MgmtTeam=$MgmtTeam.";".$Exename;
									}
									$MgmtTeam=substr_replace($MgmtTeam, '', 0,1);
								}
								$schema_insert .=$MgmtTeam.$sep; //Management Team
                                                         
                                                                
                                                                $onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,
								exe.ExecutiveName,exe.Designation,exe.Company from
								pecompanies as pec,executives as exe,pecompanies_management as mgmt
								where pec.PECompanyId=$companyId and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";
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
                                                                
                                                                
                                                         $strIpos="";
                                  			$FinalStringIPOs="";
                                  			$ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,
                                  						IPOAmount, DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId ,pe.ExitStatus
                                  						FROM ipos AS pe, industry AS i, pecompanies AS pec,ipo_investors as ipoi,peinvestors as inv
                                                                                  WHERE  i.industryid=pec.industry
                                  						AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=$companyId 
                                                                                   and inv.InvestorId=ipoi.InvestorId and ipoi.IPOId=pe.IPOId
                                                                                  order by dt desc";
                                  					if($rsipoexit= mysql_query($ipoexitsql))
                                  					{
                                  					While($ipoexitrow=mysql_fetch_array($rsipoexit, MYSQL_BOTH))
                                  						{
                                  							  $exitstatusvalueforIPO=$ipoexitrow["ExitStatus"];
                                                                                          if($exitstatusvalueforIPO==0)
                    		                                                          {$exitstatusdisplayforIPO="Partial Exit";}
                    		                                                          elseif($exitstatusvalueforIPO==1)
                                                                                          {  $exitstatusdisplayforIPO="Complete Exit";}
                                                                                          $strIpos=$strIpos.",".$ipoexitrow["Investor"]." ".$ipoexitrow["dt"].", ".$exitstatusdisplayforIPO;
                                  						}
                                  					}
                                  						$strIpos=substr_replace($strIpos,'',0,1);
                                  						if((trim(strIpos)!=" ") &&($strIpos!=""))
                                  						{
                                  							$FinalStringIPOs="IPO:".$strIpos.";";
                                  						}
                                  			$strmas="";
                                  			$FinalStringMAs="";
                                  
                                  			$maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,
                                  			DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId ,pe.ExitStatus
                                  			FROM manda AS pe, industry AS i, pecompanies AS pec,manda_investors as mi ,peinvestors as inv
                                                          WHERE  i.industryid=pec.industry
                                  			AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=$companyId 
                                  			and inv.InvestorId=mi.InvestorId and mi.MandAId=pe.MandAId
                                                        order by dt desc";
                                  				if($rsmaexit= mysql_query($maexitsql))
                                  					{
                                  					While($maexitrow=mysql_fetch_array($rsmaexit, MYSQL_BOTH))
                                  						{
                                  							  $exitstatusvalue=$maexitrow["ExitStatus"];
                                                                                          if($exitstatusvalue==0)
                    		                                                          {$exitstatusdisplay="Partial Exit";}
                    		                                                          elseif($exitstatusvalue==1)
                                                                                          {  $exitstatusdisplay="Complete Exit";}
                                                                                          $strmas=$strmas.",".$maexitrow["Investor"]." " .$maexitrow["dt"].", ".$exitstatusdisplay;
                                  						}
                                  					}
                                  					$strmas=substr_replace($strmas, '', 0,1);
                                        if($strmas!="")
                                  					{
                                  						$FinalStringMAs="  M&A:".$strmas;
                                  					}
                                  				$schema_insert .=$FinalStringIPOs."" .$FinalStringMAs.$sep; // Exits IPOs-M&As

                                  $angelinvsql="SELECT pe.InvesteeId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.AngelDealId ,peinv.InvestorId,inv.Investor
				FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,
   	                        angel_investors as peinv,peinvestors as inv
                                 WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.InvesteeId and 
                                 pe.Deleted=0 and pec.industry !=15 and pe.InvesteeId=$companyId
                                 and  peinv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv.InvestorId order by dt desc";
                                  $strangelinvs='';
                                 if($rsangel= mysql_query($angelinvsql))
				{
				     $angel_cnt = mysql_num_rows($rsangel);
				}
                               	While($angelrow=mysql_fetch_array($rsangel, MYSQL_BOTH))
				{
                                  	$strangelinvs=$strangelinvs.",".$angelrow["Investor"]."(".$angelrow["dt"].")";
				}
				$strangelinvs=substr_replace($strangelinvs, '', 0,1);
					$schema_insert .=$strangelinvs.$sep; // Angel investments
                    #$schema_insert .= $row['CINNo']; // CIN


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
											$subject="company Profile - $filetitle";
											$message="<html><center><b><u> Company Profile :$frmwhichpage - $filetitle - $submitemail</u></b></center><br>
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


				//		}
				//else
				//	header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;
                }
  mysql_close();
    mysql_close($cnx);
    ?>


