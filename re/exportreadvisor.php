<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
 session_save_path("/tmp");
        session_start();
        include ('checklogin.php');  
	$username=$_SESSION['REUserNames'];
	$emailid=$_SESSION['REUserEmail'];
	if(session_is_registered("REUserNames"))
	{
        
        //Check Session Id 
        $sesID=session_id();
        $emailid=$_SESSION['REUserEmail'];
        $sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='".$emailid."' AND `dbTYpe`='RE'";
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
            $dlogUserEmail = $_SESSION['REUserEmail'];
            $today = date('Y-m-d');

            //Check Existing Entry
           $sqlSelCount = "SELECT `recDownloaded`  FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='RE' AND `downloadDate` = CURRENT_DATE";
           $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
           $rowSelCount = mysql_num_rows($sqlSelResult);
           $rowSel = mysql_fetch_object($sqlSelResult);
           $downloads = $rowSel->recDownloaded;

           if ($rowSelCount > 0){
               $upDownloads = $recCount + $downloads;
               $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='RE' AND `downloadDate` = CURRENT_DATE";
               $resUdt = mysql_query($sqlUdt) or die(mysql_error());
           }else{
               $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('0','".$dlogUserEmail."','".$today."','RE','".$recCount."')";
               mysql_query($sqlIns) or die(mysql_error());
           }
        }
        
        
        
		//include('onlineaccount.php');
		$displayMessage="";
		$mailmessage="";
                $TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";
                $isShowAll=$_POST['hideShowAll'];
                $dealvalue=$_POST['txthidedv'];
                $submitemail=$_POST['txthideemail'];
                $vcflagValue=$_POST['hidevcflagValue'];
                $industry=$_POST['txthideindustryid'];
                $keyword=$_POST['txthidekeyword'];
                $companysearch=$_POST['txthidecompany'];
                $sectorsearch=$_POST['txthidesector'];
                $advisorsearchstring_legal=$_POST['txthideadvisorlegal'];
                $advisorsearchstring_trans=$_POST['txthideadvisortrans'];
                $wherestagehide=$_POST['txthidestageid'];
                $startrange=$_POST['txthidestartrange'];
                $endrange=$_POST['txthideendrange'];
                $investorTypeId=$_POST['txthideinvestorTypeid'];
                $dealTypeId=$_POST['txthidedealTypeid'];
                $dt1=$_POST['txthidedateStartValue'];
                $dt2=$_POST['txthidedateEndValue'];

                $tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
                if($vcflagValue==0){
                        if($dealvalue==103 || $dealvalue==104){
                   
                            if($dealvalue == 103)
                            {
                                $adtype = "L";
                            }
                            else
                            {
                                $adtype = "T";
                            }

                            if($keyword!="")
                            {
                                $getadvisorSql="(
                                 SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                                 FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac,REinvestors as inv,REinvestments_investors AS REinvi
                                 WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid and peinv.PEId=REinvi.PEId and REinvi.InvestorId=inv.InvestorId AND c.PECompanyId = peinv.PECompanyId
                                 AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                                 AND Investor like '%$keyword%'  GROUP BY peinv.PEId
                                 )
                                 UNION (
                                 SELECT  cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                 FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac,REinvestors as inv,REinvestments_investors AS REinvi
                                 WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid and peinv.PEId=REinvi.PEId and REinvi.InvestorId=inv.InvestorId AND c.PECompanyId = peinv.PECompanyId
                                 AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                                 AND Investor like '%$keyword%' GROUP BY peinv.PEId
                                 )";  
                            }
                            else if($companysearch!="")
                            {
                                    $getadvisorSql="(
                                    SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                                    FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                                    WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                                    AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                                    AND c.companyname like '%$companysearch%' GROUP BY peinv.PEId
                                    )
                                    UNION (
                                    SELECT  cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                    FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                                    WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                                    AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                                    AND c.companyname like '%$companysearch%' GROUP BY peinv.PEId
                                    )";
                            }
                            else if($sectorsearch!="")
                            { 
                                    $getadvisorSql="(
                                    SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                                    FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                                    WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                                    AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                                    AND c.sector_business like '%$sectorsearch%' GROUP BY peinv.PEId
                                    )
                                    UNION (
                                    SELECT  cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                    FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                                    WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                                    AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                                    AND c.sector_business like '%$sectorsearch%' GROUP BY peinv.PEId
                                    )";
                            }
                            elseif($advisorsearchstring_legal!="")
                            {

                            $getadvisorSql="(
                                    SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                                    FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                                    WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                                    AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                                    AND cia.cianame LIKE '$advisorsearchstring_legal%'  GROUP BY peinv.PEId
                                    )
                                    UNION (
                                    SELECT  cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                    FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                                    WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                                    AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                                    AND cia.cianame LIKE '$advisorsearchstring_legal%' GROUP BY peinv.PEId
                                    )";
            //			echo "<Br>ADvisor search--" . $companysql;
                            }
                            elseif($advisorsearchstring_trans!="")
                            {

                            $getadvisorSql="(
                                    SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                                    FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                                    WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                                    AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                                    AND cia.cianame LIKE '$advisorsearchstring_trans%'  GROUP BY peinv.PEId
                                    )
                                    UNION (
                                    SELECT  cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                    FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                                    WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                                    AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                                    AND cia.cianame LIKE '$advisorsearchstring_trans%' GROUP BY peinv.PEId
                                    )";
            //				echo "<Br>Trans search--" . $companysql;
                           }
                            elseif($searchallfield!="")
                            {
                                    $getadvisorSql="(
                                    SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                                    FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                                    WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                                    AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                                    AND cia.cianame LIKE '$searchallfield%'  GROUP BY peinv.PEId
                                    )
                                    UNION (
                                    SELECT  cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                                    FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                                    WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                                    AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='$adtype'
                                    AND cia.cianame LIKE '$searchallfield%' GROUP BY peinv.PEId
                                    )";

                                    $showallsql= $getInvestorSqlreal;

                            //echo "<br> allsearchfield search- ".$InvestorSqlreal;
                            }
                            else{

                                $companysql= "(SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac WHERE";
                                $companysql2= "SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac WHERE";

                                //echo "<br> individual where clauses have to be merged ";
                                if ($industry > 0)
                                    $whereind = " peinv.IndustryId=" .$industry ;
                                if ($investorType!= "")
                                    $whereInvType = " peinv.InvestorType = '".$investorType."'";
                                
                                if ($startrange!= "" && $endrange!= "" )
                                {
                                    if($startrange < $endrange)
                                            $whererange = " pe.amount between  ".$startrange." and ".$endrange."";
                                    elseif($startrange == $endrange)
                                            $whererange = " pe.amount >= ".$startrange ."";
                                }
                                if($dt1!='' && $dt2!='')
                                    $wheredates= " dates between '" . $dt1. "' and '" . $dt2 . "'";

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
                                    if (($wherestagehide != ""))
                                    {
                                             $companysql=$companysql .$wherestagehide . " and ";
                                            $companysql2=$companysql2 .$wherestagehide . " and ";
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

                                     $companysql = $companysql ." peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                                AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='".$adtype ."' ".$dirsearchall."  GROUP BY peinv.PEId";


                                    $companysql2 = $companysql2 ." peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                                AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='".$adtype ."' ".$dirsearchall."  GROUP BY peinv.PEId";


                                    $showallsql=$companysql.") UNION (".$companysql2.") ";

                                    $orderby="order by Cianame"; 
                                    $getadvisorSql=$showallsql.$orderby;
                           }
                        }
                }     
                elseif($vcflagValue==2){
                    if($dealvalue==103 || $dealvalue==104){
                   
                    if($dealvalue == 103)
                    {
                        $adtype = "L";
                    }
                    else
                    {
                        $adtype = "T";
                    } 
                    if($keyword!="")
                    { 
                        $getadvisorSql="( SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId , (SELECT GROUP_CONCAT( inv.Investor ), cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM REmanda_investors as peinv_inv,REinvestors as inv WHERE peinv_inv.MandAId = peinv.MandAId AND inv.InvestorId = peinv_inv.InvestorId) AS Investor 
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s,REmanda_investors as Reinvi,REinvestors as ras
                        WHERE c.industry = i.industryid 
                        AND ac.AcquirerId = peinv.AcquirerId 
                        AND peinv.Deleted =0 
                        AND peinv.StageId = s.RETypeId 
                        AND c.PECompanyId = peinv.PECompanyId 
                        AND adac.CIAId = cia.CIAID
                        AND Reinvi.MandAId  =peinv.MandAId 
                        AND ras.InvestorId = Reinvi.InvestorId
                        AND adac.PEId = peinv.MandAId  and AdvisorType='$adtype' 
                        AND Investor like '%$keyword%'
                        GROUP BY peinv.MandAId 
                        )
                        UNION (

                         SELECT cia.CIAId, cia.Cianame,adcomp.CIAId AS AcqCIAId  , (SELECT GROUP_CONCAT( inv.Investor ), cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM REmanda_investors as peinv_inv,REinvestors as inv WHERE peinv_inv.MandAId = peinv.MandAId AND inv.InvestorId = peinv_inv.InvestorId) AS Investor  
                        FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s,REmanda_investors as Reinvi,REinvestors as ras
                        WHERE c.industry = i.industryid
                        AND ac.AcquirerId = peinv.AcquirerId
                        AND peinv.Deleted =0
                        AND peinv.StageId = s.RETypeId
                        AND c.PECompanyId = peinv.PECompanyId
                        AND adcomp.CIAId = cia.CIAID
                        AND Reinvi.MandAId  =peinv.MandAId 
                        AND ras.InvestorId = Reinvi.InvestorId 
                        AND adcomp.PEId = peinv.MandAId  and AdvisorType='$adtype'
                        AND Investor like '%$keyword%'
                        GROUP BY peinv.MandAId 
                        ) ";
                    }
                    else if($companysearch!="")
                    {
                            $getadvisorSql="(SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin  
                            FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s
                            WHERE c.industry = i.industryid 
                            AND ac.AcquirerId = peinv.AcquirerId 
                            AND peinv.Deleted =0 
                            AND peinv.StageId = s.RETypeId 
                            AND c.PECompanyId = peinv.PECompanyId 
                            AND adac.CIAId = cia.CIAID 
                            AND adac.PEId = peinv.MandAId  and AdvisorType='$adtype' 
                            AND c.companyname like '%$companysearch%' 
                            GROUP BY peinv.MandAId 
                            )
                            UNION (

                            SELECT cia.CIAId, cia.Cianame,adcomp.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                            FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s
                            WHERE c.industry = i.industryid
                            AND ac.AcquirerId = peinv.AcquirerId
                            AND peinv.Deleted =0
                            AND peinv.StageId = s.RETypeId
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adcomp.CIAId = cia.CIAID
                            AND adcomp.PEId = peinv.MandAId  and AdvisorType='$adtype'
                            AND c.companyname like '%$companysearch%'
                            GROUP BY peinv.MandAId 
                            ) ";
                    }
                    else if($sectorsearch!="")
                    { 
                            $getadvisorSql="(SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin  
                            FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s
                            WHERE c.industry = i.industryid 
                            AND ac.AcquirerId = peinv.AcquirerId 
                            AND peinv.Deleted =0 
                            AND peinv.StageId = s.RETypeId 
                            AND c.PECompanyId = peinv.PECompanyId 
                            AND adac.CIAId = cia.CIAID 
                            AND adac.PEId = peinv.MandAId  and AdvisorType='$adtype' 
                            AND c.sector_business like '%$sectorsearch%'
                            GROUP BY peinv.MandAId 
                            )
                            UNION (

                            SELECT cia.CIAId, cia.Cianame,adcomp.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                            FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s
                            WHERE c.industry = i.industryid
                            AND ac.AcquirerId = peinv.AcquirerId
                            AND peinv.Deleted =0
                            AND peinv.StageId = s.RETypeId
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adcomp.CIAId = cia.CIAID
                            AND adcomp.PEId = peinv.MandAId  and AdvisorType='$adtype'
                            AND c.sector_business like '%$sectorsearch%'
                            GROUP BY peinv.MandAId 
                            ) ";
                    }
                    elseif($advisorsearchstring_legal!="")
                    {

                            $getadvisorSql="(SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s
                            WHERE c.industry = i.industryid 
                            AND ac.AcquirerId = peinv.AcquirerId 
                            AND peinv.Deleted =0 
                            AND peinv.StageId = s.RETypeId 
                            AND c.PECompanyId = peinv.PECompanyId 
                            AND adac.CIAId = cia.CIAID 
                            AND adac.PEId = peinv.MandAId  and AdvisorType='$adtype' 
                            AND cia.cianame LIKE '%$advisorsearchstring_legal%' 
                            GROUP BY peinv.MandAId 
                            )
                            UNION (

                            SELECT cia.CIAId, cia.Cianame,adcomp.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s
                            WHERE c.industry = i.industryid
                            AND ac.AcquirerId = peinv.AcquirerId
                            AND peinv.Deleted =0
                            AND peinv.StageId = s.RETypeId
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adcomp.CIAId = cia.CIAID
                            AND adcomp.PEId = peinv.MandAId  and AdvisorType='$adtype'
                            AND cianame LIKE '%$advisorsearchstring_legal%' 
                            GROUP BY peinv.MandAId 
                            ) ";
                    }
                    elseif($advisorsearchstring_trans!="")
                    {

                            $getadvisorSql="(SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s
                            WHERE c.industry = i.industryid
                            AND ac.AcquirerId = peinv.AcquirerId
                            AND peinv.Deleted =0
                            AND peinv.StageId = s.RETypeId
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID
                            AND adac.PEId = peinv.MandAId  and AdvisorType='$adtype'
                            AND cia.cianame LIKE '%$advisorsearchstring_trans%'
                            GROUP BY peinv.MandAId 
                            )
                            UNION (

                            SELECT cia.CIAId, cia.Cianame,adcomp.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s
                            WHERE c.industry = i.industryid
                            AND ac.AcquirerId = peinv.AcquirerId
                            AND peinv.Deleted =0
                            AND peinv.StageId = s.RETypeId
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adcomp.CIAId = cia.CIAID
                            AND adcomp.PEId = peinv.MandAId  and AdvisorType='$adtype'
                            AND cianame LIKE '%$advisorsearchstring_trans%' 
                            GROUP BY peinv.MandAId 
                            ) ";
                   }
                    elseif($searchallfield!="")
                    {
                            $getadvisorSql="(SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s
                            WHERE c.industry = i.industryid
                            AND ac.AcquirerId = peinv.AcquirerId
                            AND peinv.Deleted =0
                            AND peinv.StageId = s.RETypeId
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID
                            AND adac.PEId = peinv.MandAId  and AdvisorType='$adtype'
                            AND cia.cianame LIKE '%$searchallfield%'
                            GROUP BY peinv.MandAId 
                            )
                            UNION (

                            SELECT cia.CIAId, cia.Cianame,adcomp.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s
                            WHERE c.industry = i.industryid
                            AND ac.AcquirerId = peinv.AcquirerId
                            AND peinv.Deleted =0
                            AND peinv.StageId = s.RETypeId
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adcomp.CIAId = cia.CIAID
                            AND adcomp.PEId = peinv.MandAId  and AdvisorType='$adtype'
                            AND cianame LIKE '%$searchallfield%' 
                            GROUP BY peinv.MandAId 
                            ) ";
                    }
                    else{

                        $companysql= "(SELECT cia.CIAId, cia.Cianame,adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s where";
                        $companysql2= "SELECT cia.CIAId, cia.Cianame,adcomp.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s where";

                        //echo "<br> individual where clauses have to be merged ";
                        if ($industry > 0)
                            $whereind = " c.industry=" .$industry ;
                        if ($dealTypeId!= "")
                        {
                            $wheredealtype = " peinv.DealTypeId =" .$dealTypeId;
                        }
                        if ($startrange!= "" && $endrange!= "" )
                        {
                            if($startrange < $endrange)
                                    $whererange = " peinv.DealAmount between  ".$startrange." and ".$endrange."";
                            elseif($startrange == $endrange)
                                    $whererange = " peinv.DealAmount >= ".$startrange ."";
                        }
                        if($dt1!='' && $dt2!='')
                            $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";

                            if ($whereind != "")
                            {
                                    $companysql=$companysql . $whereind ." and ";
                                    $companysql2=$companysql2 . $whereind ." and ";
                            }

                            if ($wheredealtype != "")
                            {
                                    $companysql=$companysql . $wheredealtype ." and ";
                                    $companysql2=$companysql2 . $wheredealtype ." and ";
                            }
                            if (($wherestagehide != ""))
                            {
                                     $companysql=$companysql .$wherestagehide . " and ";
                                    $companysql2=$companysql2 .$wherestagehide . " and ";
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

                            $companysql = $companysql ." c.industry = i.industryid AND ac.AcquirerId = peinv.AcquirerId
                            AND peinv.Deleted =0 AND peinv.StageId = s.RETypeId AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.MandAId  and AdvisorType='".$adtype ."' ".$dirsearchall."
                            GROUP BY peinv.MandAId";


                            $companysql2 = $companysql2 ." c.industry = i.industryid AND ac.AcquirerId = peinv.AcquirerId
                            AND peinv.Deleted =0 AND peinv.StageId = s.RETypeId AND c.PECompanyId = peinv.PECompanyId
                            AND adcomp.CIAId = cia.CIAID AND adcomp.PEId = peinv.MandAId  and AdvisorType='".$adtype ."' ".$dirsearchall."
                            GROUP BY peinv.MandAId ";

                            $showallsql=$companysql.") UNION (".$companysql2.") ";

                            $orderby="order by Cianame"; 
                            $getadvisorSql=$showallsql.$orderby;
                        }
                    }
                }
                elseif($vcflagValue==3){
                    if($dealvalue==103 || $dealvalue==104){
                   
                    if($dealvalue == 103)
                    {
                        $adtype = "L";
                    }
                    else
                    {
                        $adtype = "T";
                    }
                    if($companysearch!="")
                    {
                            $getadvisorSql="(
                            SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                            WHERE Deleted =0
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID
                            AND adac.MAMAId = peinv.MAMAId  and AdvisorType='$adtype'
                            AND c.companyname like '%$companysearch%'
                            )
                            UNION (
                            SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                            WHERE Deleted =0
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adcomp.CIAId = cia.CIAID
                            AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='$adtype'
                            AND c.companyname like '%$companysearch%'
                            )";
                    }
                    else if($sectorsearch!="")
                    { 
                           $getadvisorSql="(
                            SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                            WHERE Deleted =0
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID
                            AND adac.MAMAId = peinv.MAMAId  and AdvisorType='$adtype'
                            AND c.sector_business like '%$sectorsearch%'
                            )
                            UNION (
                            SELECT DISTINCT adcomp.CIAId, cia.Cianame, adcomp.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                            WHERE Deleted =0
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adcomp.CIAId = cia.CIAID
                            AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='$adtype'
                            AND c.sector_business like '%$sectorsearch%'
                            )";
                    }
                    elseif($advisorsearchstring_legal!="")
                    {
                            $getadvisorSql="(
                            SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                            WHERE Deleted =0
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID
                            AND adac.MAMAId = peinv.MAMAId  and AdvisorType='".$adtype ."'
                            AND cia.cianame LIKE '%$advisorsearchstring_legal%'
                            )
                            UNION (
                            SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                            WHERE Deleted =0
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adcomp.CIAId = cia.CIAID
                            AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='".$adtype ."'
                            AND cia.cianame LIKE '%$advisorsearchstring_legal%'
                            )
                            ORDER BY Cianame";
                    }
                    elseif($advisorsearchstring_trans!="")
                    {
                        $getadvisorSql="(
                            SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                            WHERE Deleted =0
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID
                            AND adac.MAMAId = peinv.MAMAId  and AdvisorType='".$adtype ."'
                            AND cia.cianame LIKE '%$advisorsearchstring_trans%'
                            )
                            UNION (
                            SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                            WHERE Deleted =0
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adcomp.CIAId = cia.CIAID
                            AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='".$adtype ."'
                            AND cia.cianame LIKE '%$advisorsearchstring_trans%'
                            )
                            ORDER BY Cianame";
                   }
                    elseif($searchallfield!="")
                    {
                       $getadvisorSql="(
                            SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                            WHERE Deleted =0
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID
                            AND adac.MAMAId = peinv.MAMAId  and AdvisorType='".$adtype ."'
                            AND cia.cianame LIKE '%$searchallfield%'
                            )
                            UNION (
                            SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin
                            FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                            WHERE Deleted =0
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adcomp.CIAId = cia.CIAID
                            AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='".$adtype ."'
                            AND cia.cianame LIKE '%$searchallfield%'
                            )
                            ORDER BY Cianame";
                    }
                    else{

                        $companysql= "(SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM REmama AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REmama_advisoracquirer AS adac WHERE";
                        $companysql2= "SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId, cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM REmama AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp WHERE ";

                        //echo "<br> individual where clauses have to be merged ";
                        if ($industry > 0)
                            $whereind = " c.industry=" .$industry ;
                        if ($dealTypeId!= "")
                        {
                            $wheredealtype = " peinv.MADealTypeId =" .$dealTypeId;
                        }

                         if ($startrange!= "" && $endrange!= "" )
                        {
                            if($startrange < $endrange)
                                    $whererange = " peinv.Amount between  ".$startrange." and ".$endrange."";
                            elseif($startrange == $endrange)
                                    $whererange = " peinv.Amount >= ".$startrange ."";
                        }
                        if($dt1!='' && $dt2!='')
                            $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";

                            if ($whereind != "")
                            {
                                    $companysql=$companysql . $whereind ." and ";
                                    $companysql2=$companysql2 . $whereind ." and ";
                            }

                            if ($wheredealtype != "")
                            {
                                    $companysql=$companysql . $wheredealtype ." and ";
                                    $companysql2=$companysql2 . $wheredealtype ." and ";
                            }
                            if (($wherestagehide != ""))
                            {
                                     $companysql=$companysql .$wherestagehide . " and ";
                                    $companysql2=$companysql2 .$wherestagehide . " and ";
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

                             $companysql = $companysql ." c.industry = i.industryid and Deleted =0 AND c.PECompanyId = peinv.PECompanyId AND adac.CIAId = cia.CIAID
                            AND adac.MAMAId = peinv.MAMAId  and AdvisorType='".$adtype ."' ".$dirsearchall." ";


                             $companysql2 = $companysql2 ." c.industry = i.industryid and Deleted =0 AND c.PECompanyId = peinv.PECompanyId AND adcomp.CIAId = cia.CIAID
                            AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='".$adtype ."' ".$dirsearchall." ";

                            $showallsql=$companysql.") UNION (".$companysql2.") ";

                            $orderby="order by Cianame"; 
                            $getadvisorSql=$showallsql.$orderby;
                        }
                    
                    }
                }
                        $sql=$getadvisorSql;
//                        echo "<br>---" .$sql;
//                        exit;
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
                                $filetitle="RE-Advisors";
                                
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
					echo "Advisor"."\t";
                                        echo "Advisor - Company"."\t";
					echo " Advisor - Investors"."\t";
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
                                while($row = mysql_fetch_array($result))
                                {
                                    //set_time_limit(60); // HaRa
                                    $schema_insert = "";
                                            $advisorId=$row['CIAId'];
                                           $advisorName=$row['Cianame'];
                                           $schema_insert .=$row['Cianame'].$sep; //advisor name


                                           $advisor_to_companysql="
							SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
							DATE_FORMAT( dates, '%M-%Y' ) AS dt,peinv.PEId as PEId
							FROM REinvestments AS peinv, REcompanies AS c,  REadvisor_cias AS cia,
							REinvestments_advisorcompanies AS adac
							WHERE peinv.Deleted=0
							AND c.PECompanyId = peinv.PECompanyId
							AND adac.CIAId = cia.CIAID
							AND adac.PEId = peinv.PEId and adac.CIAId=$advisorId order by Cianame";

                                           if($rsMgmt= mysql_query($advisor_to_companysql))
                                           {
                                                   $MgmtTeam="";
                                                   While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                                                   {
                                                           $cname= $mymgmtrow["Companyname"];
                                                           $dealperiod=$mymgmtrow["dt"];
                                                           $MgmtTeam=$MgmtTeam.",".$cname."-".$dealperiod;
                                                   }
                                                   $MgmtTeam=substr_replace($MgmtTeam, '', 0,1);
                                           }
                                           $schema_insert .=$MgmtTeam.$sep; //Advisor - Company

                                            $advisor_to_investorsql="
                                            SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.PEId as PEId,c.Companyname,
                                            DATE_FORMAT( dates, '%M-%Y' ) AS dt
                                            FROM REinvestments AS peinv,REcompanies AS c, REadvisor_cias AS cia,
                                            REinvestments_advisorinvestors AS adac, stage as s,REinvestors as inv,REinvestments_investors as pe_inv
                                            WHERE peinv.Deleted=0
                                             AND c.PECompanyId = peinv.PECompanyId
                                            AND adac.CIAId = cia.CIAID and pe_inv.PEId=peinv.PEId and inv.InvestorId=pe_inv.InvestorId
                                            AND adac.PEId = peinv.PEId and adac.CIAId=$advisorId order by dt";

                                           if($rsInvestors= mysql_query($advisor_to_investorsql))
                                           {
                                                   $strInvestor="";
                                                   While($myinvestrow=mysql_fetch_array($rsInvestors, MYSQL_BOTH))
                                                   {
                                                           $compname= $myinvestrow["Companyname"];
                                                           $dealperioddt=$myinvestrow["dt"];
                                                           $strInvestor=$strInvestor.",".$compname."-".$dealperioddt;
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
                            print("\n");
                            print("\n");
                            print("\n");
                            print("\n");
                            echo ( html_entity_decode( $tsjtitle, ENT_COMPAT, 'ISO-8859-1' ) );
                            print("\n");
                            print("\n");
				 /*
                                  
				 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
				 */



}
 mysql_close();  
				?>


