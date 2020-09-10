<?php include_once("../globalconfig.php"); ?>
<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
 session_save_path("/tmp");
	session_start();
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

                //global $LoginAccess;
                //global $LoginMessage;
                $TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";

                //VCFLAG VALUE
                //variable that differentiates PE/VC Investors frm which page

                $isShowAll=$_POST['hideShowAll'];
                $vcflagValue=$_POST['hidevcflagValue'];
                $dealvalue=$_POST['txthidedv'];
                $submitemail=$_POST['txthideemail'];
                $industry=$_POST['txthideindustryid'];
                $keyword=$_POST['txthidekeyword'];
                $companysearch=$_POST['txthidecompany'];
                $sectorsearch=$_POST['txthidesector'];
                $advisorsearchstring_legal=$_POST['txthideadvisorlegal'];
                $advisorsearchstring_trans=$_POST['txthideadvisortrans'];
                $wherestagehide=$_POST['txthidestageid'];
                if($_POST['txthidestageid'] && $stageval!="")
                {
                    $boolStage=true;
                }
                else
                {
                    $stage="--";
                    $boolStage=false;
                }
                $startrange=$_POST['txthidestartrange'];
                $endrange=$_POST['txthideendrange'];
                $investorTypeId=$_POST['txthideinvestorTypeid'];
                $dealTypeId=$_POST['txthidedealTypeid'];
                $dt1=$_POST['txthidedateStartValue'];
                $dt2=$_POST['txthidedateEndValue'];

                $tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
                if($vcflagValue==0)
                {
                        if ($keyword != "")
                        {

                                $getInvestorSql="select distinct peinv.InvestorId,inv.*
                                from REinvestments_investors as peinv,REinvestments as pe,realestatetypes as s,REinvestors as inv,REcompanies as pec
                                where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.REtypeId and pe.PECompanyId=pec.PECompanyId and
                                pe.Deleted=0  and Investor like '%$keyword%' order by inv.Investor ";
                        }
                        else if($companysearch!="")
                        {
                                $getInvestorSql="select distinct peinv.InvestorId,inv.*
                                from REinvestments_investors as peinv,REinvestments as pe,realestatetypes as s,REinvestors as inv,REcompanies as pec
                                where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.REtypeId and pe.PECompanyId=pec.PECompanyId and
                                pe.Deleted=0  and pec.companyname like '%$companysearch%' order by inv.Investor ";
                        }
                        else if($sectorsearch!="")
                        {
                                $getInvestorSql ="select distinct peinv.InvestorId,inv.*
                                from REinvestments_investors as peinv,REinvestments as pe,realestatetypes as s,REinvestors as inv,REcompanies as pec
                                where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.REtypeId and pe.PECompanyId=pec.PECompanyId and
                                pe.Deleted=0  and pec.sector_business like '%$sectorsearch%' order by inv.Investor ";
                        }
                        elseif($advisorsearchstring_legal!="")
                        {
                            $yourquery=1;
                            $datevalueDisplay1="";
                        $getInvestorSql="(
                            SELECT REinvi.InvestorId, ras.* , (
                            SELECT GROUP_CONCAT( REinvoinv.InvestorId )
                            FROM REinvestments_investors AS REinvoinv, REinvestors AS REinv
                            WHERE REinvoinv.PEId = peinv.PEId
                            AND REinv.InvestorId = REinvoinv.InvestorId
                            ) AS InvestorId
                            FROM REinvestments AS peinv, REcompanies AS c, REinvestments_investors AS REinvi, REinvestors AS ras, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                            WHERE peinv.Deleted =0
                            AND peinv.IndustryId = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID
                            AND adac.PEId = peinv.PEId
                            AND REinvi.PEId = peinv.PEId
                            AND ras.InvestorId = REinvi.InvestorId
                            AND AdvisorType = 'L'
                            AND cia.cianame LIKE '$advisorsearchstring_legal%'
                            GROUP BY peinv.PEId
                            )
                            UNION (
                            SELECT REinvi.InvestorId, ras.* , (
                            SELECT GROUP_CONCAT( REinvoinv.InvestorId )
                            FROM REinvestments_investors AS REinvoinv, REinvestors AS REinv
                            WHERE REinvoinv.PEId = peinv.PEId
                            AND REinv.InvestorId = REinvoinv.InvestorId
                            ) AS InvestorId
                            FROM REinvestments AS peinv, REcompanies AS c, REinvestments_investors AS REinvi, REinvestors AS ras, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                            WHERE peinv.Deleted =0
                            AND peinv.IndustryId = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID
                            AND adac.PEId = peinv.PEId
                            AND REinvi.PEId = peinv.PEId
                            AND ras.InvestorId = REinvi.InvestorId
                            AND AdvisorType = 'L'
                            AND cia.cianame LIKE '$advisorsearchstring_legal%'
                            GROUP BY peinv.PEId
                            )";
                         $orderby="companyname";
                         $ordertype="asc";

                           //     echo "<Br>ADvisor search--" . $getInvestorSql;
                        }
                        elseif($advisorsearchstring_trans!="")
                        {
                            $yourquery=1;
                            $datevalueDisplay1="";
                            $getInvestorSql="(
                            SELECT REinvi.InvestorId, ras.* , (
                            SELECT GROUP_CONCAT( REinvoinv.InvestorId )
                            FROM REinvestments_investors AS REinvoinv, REinvestors AS REinv
                            WHERE REinvoinv.PEId = peinv.PEId
                            AND REinv.InvestorId = REinvoinv.InvestorId
                            ) AS InvestorId
                            FROM REinvestments AS peinv, REcompanies AS c, REinvestments_investors AS REinvi, REinvestors AS ras, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                            WHERE peinv.Deleted =0
                            AND peinv.IndustryId = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID
                            AND adac.PEId = peinv.PEId
                            AND REinvi.PEId = peinv.PEId
                            AND ras.InvestorId = REinvi.InvestorId
                            AND AdvisorType = 'T'
                            AND cia.cianame LIKE '$advisorsearchstring_trans%'
                            GROUP BY peinv.PEId
                            )
                            UNION (
                            SELECT REinvi.InvestorId, ras.* , (
                            SELECT GROUP_CONCAT( REinvoinv.InvestorId )
                            FROM REinvestments_investors AS REinvoinv, REinvestors AS REinv
                            WHERE REinvoinv.PEId = peinv.PEId
                            AND REinv.InvestorId = REinvoinv.InvestorId
                            ) AS InvestorId
                            FROM REinvestments AS peinv, REcompanies AS c, REinvestments_investors AS REinvi, REinvestors AS ras, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                            WHERE peinv.Deleted =0
                            AND peinv.IndustryId = i.industryid
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID
                            AND adac.PEId = peinv.PEId
                            AND REinvi.PEId = peinv.PEId
                            AND ras.InvestorId = REinvi.InvestorId
                            AND AdvisorType = 'T'
                            AND cia.cianame LIKE '$advisorsearchstring_trans%'
                            GROUP BY peinv.PEId
                            )";
                         $orderby="companyname";
                         $ordertype="asc";
                              //          echo "<Br>Trans search--" . $getInvestorSql;
                       }
                        else
                        {
                            $getInvestorSql = "select distinct peinv.InvestorId,inv.*
                               from REinvestments_investors as peinv,REinvestments as pe,REcompanies as pec,
                               realestatetypes as s,REinvestors as inv,industry as i
                               where ";
                            
                            if ($industry > 0)
                            {
                                $whereind = " pe.IndustryId=" .$industry ;
                            }
                            if ($investorTypeId!= "")
                            {
                                $whereInvType = " pe.InvestorType = '".$investorTypeId."'";
                            }
                           
                           if ($startrange!= "" && $endrange!= "" )
                            {
                                if($startrange < $endrange)
                                        $whererange = " pe.amount between  ".$startrange." and ".$endrange."";
                                elseif($startrange == $endrange)
                                        $whererange = " pe.amount >= ".$startrange ."";
                            }
                            if($dt1!='' && $dt2!='')
                            {
                                    $wheredates= " dates between '" .$dt1. "' and '" .$dt2. "'";
                            }
                            if ($whereind != "")
                            {
                                    $getInvestorSql=$getInvestorSql.$whereind ." and ";
                            }
                            if (($wherestagehide != ""))
                            {
                                    $getInvestorSql=$getInvestorSql.$wherestagehide . " and " ;
                            }
                            if (($whereInvType != "") )
                            {
                                    $getInvestorSql=$getInvestorSql.$whereInvType . " and ";
                            }
                            if (($whererange != "") )
                            {
                                    $getInvestorSql=$getInvestorSql.$whererange. " and ";
                            }
                            if(($wheredates !== "") )
                            {
                                    $getInvestorSql = $getInvestorSql.$wheredates." and ";
                            }

                            $getInvestorSql = $getInvestorSql." pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.REtypeId and pe.IndustryId=i.IndustryId and
                                pe.Deleted=0  order by inv.Investor ";
                            //echo "<br><br>WHERE CLAUSE SQL---" .$getInvestorSql;
                        }
                
                    }
                    elseif($vcflagValue==1)
                    {
                        if($keyword!="")
                        {
                                $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.*
                                FROM REipos AS pe, REcompanies AS pec, REipo_investors AS peinv, REinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND peinv.IPOId = pe.IPOId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 and Investor like '%$keyword%' order by inv.Investor ";
                        }
                        else if($companysearch!="")
                        { 
                                $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.*
                                FROM REipos AS pe, REcompanies AS pec, REipo_investors AS peinv, REinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND peinv.IPOId = pe.IPOId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 and pec.companyname like '%$companysearch%' order by inv.Investor ";
                        }
                        elseif($searchallfield!="")
                        {
                               $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.*
                                FROM REipos AS pe, REcompanies AS pec, REipo_investors AS peinv, REinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND peinv.IPOId = pe.IPOId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 and Investor like '%$searchallfield%' order by inv.Investor ";
                        }
                        else{
                            $getInvestorSql = "SELECT DISTINCT inv.InvestorId, inv.*
                            FROM REipos AS pe, REcompanies AS pec, REipo_investors AS peinv, REinvestors AS inv
                            WHERE";

                            //echo "<br> individual where clauses have to be merged ";
                            if ($industry > 0)
                            {
                                 $whereind = " pec.industry=" .$industry;
                            }

                            if($dt1!='' && $dt2!='')
                            {
                                $wheredates= " IPODate between '" .$dt1. "' and '" .$dt2. "'";
                            }

                            if ($whereind != "")
                            {
                                    $getInvestorSql=$getInvestorSql . $whereind ." and ";
                                    $bool=true;
                            }
                            else
                            {
                                    $bool=false;
                            }
                            if(($wheredates !== "") )
                            {
                                    $getInvestorSql = $getInvestorSql . $wheredates ." and ";
                                    $bool=true;
                            }
                            $getInvestorSql = $getInvestorSql . " pe.PECompanyId = pec.PEcompanyId
                            AND peinv.IPOId = pe.IPOId AND inv.InvestorId = peinv.InvestorId AND pe.Deleted=0 ".$dirsearchall." order by inv.Investor";
                        }
                    }    
                    elseif($vcflagValue==2){
                        
                        if($keyword!="")
                        {
                                $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.*
                                FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0  and Investor like '%$keyword%' order by inv.Investor ";
                        }
                        else if($companysearch!="")
                        {
                                $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.*
                                FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0  and pec.companyname like '%$companysearch%' order by inv.Investor ";
                        }
                        else if($sectorsearch!="")
                        {
                                $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.*
                                FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0  and pec.sector_business like '%$sectorsearch%' order by inv.Investor ";
                        }
                        elseif($advisorsearchstring_legal!="")
                        {

                                $getInvestorSql="( SELECT Reinvi.InvestorId, ras.* , (SELECT GROUP_CONCAT( inv.Investor ) FROM REmanda_investors as peinv_inv,REinvestors as inv WHERE peinv_inv.MandAId = peinv.MandAId AND inv.InvestorId = peinv_inv.InvestorId) AS Investor 
                                FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s,REmanda_investors as Reinvi,REinvestors as ras
                                WHERE c.industry = i.industryid 
                                AND ac.AcquirerId = peinv.AcquirerId 
                                AND peinv.Deleted =0 
                                AND peinv.StageId = s.RETypeId 
                                AND c.PECompanyId = peinv.PECompanyId 
                                AND adac.CIAId = cia.CIAID
                                AND Reinvi.MandAId  =peinv.MandAId 
                                AND ras.InvestorId = Reinvi.InvestorId
                                AND adac.PEId = peinv.MandAId  and AdvisorType='L' 
                                AND cia.cianame LIKE '%$advisorsearchstring_legal%' 
                                GROUP BY peinv.MandAId 
                                )
                                UNION (

                                 SELECT Reinvi.InvestorId, ras.* , (SELECT GROUP_CONCAT( inv.Investor ) FROM REmanda_investors as peinv_inv,REinvestors as inv WHERE peinv_inv.MandAId = peinv.MandAId AND inv.InvestorId = peinv_inv.InvestorId) AS Investor  
                                FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s,REmanda_investors as Reinvi,REinvestors as ras
                                WHERE c.industry = i.industryid
                                AND ac.AcquirerId = peinv.AcquirerId
                                AND peinv.Deleted =0
                                AND peinv.StageId = s.RETypeId
                                AND c.PECompanyId = peinv.PECompanyId
                                AND adcomp.CIAId = cia.CIAID
                                AND Reinvi.MandAId  =peinv.MandAId 
                                AND ras.InvestorId = Reinvi.InvestorId 
                                AND adcomp.PEId = peinv.MandAId  and AdvisorType='L'
                                AND cianame LIKE '%$advisorsearchstring_legal%' 
                                GROUP BY peinv.MandAId 
                                ) ";
                        }
                        elseif($advisorsearchstring_trans!="")
                        {
                             $getInvestorSql="( SELECT Reinvi.InvestorId, ras.* , (SELECT GROUP_CONCAT( inv.Investor ) FROM REmanda_investors as peinv_inv,REinvestors as inv WHERE peinv_inv.MandAId = peinv.MandAId AND inv.InvestorId = peinv_inv.InvestorId) AS Investor 
                                FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s,REmanda_investors as Reinvi,REinvestors as ras
                                WHERE c.industry = i.industryid 
                                AND ac.AcquirerId = peinv.AcquirerId 
                                AND peinv.Deleted =0 
                                AND peinv.StageId = s.RETypeId 
                                AND c.PECompanyId = peinv.PECompanyId 
                                AND adac.CIAId = cia.CIAID
                                AND Reinvi.MandAId  =peinv.MandAId 
                                AND ras.InvestorId = Reinvi.InvestorId
                                AND adac.PEId = peinv.MandAId  and AdvisorType='T' 
                                AND cia.cianame LIKE '%$advisorsearchstring_trans%' 
                                GROUP BY peinv.MandAId 
                                )
                                UNION (

                                 SELECT Reinvi.InvestorId, ras.* , (SELECT GROUP_CONCAT( inv.Investor ) FROM REmanda_investors as peinv_inv,REinvestors as inv WHERE peinv_inv.MandAId = peinv.MandAId AND inv.InvestorId = peinv_inv.InvestorId) AS Investor  
                                FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s,REmanda_investors as Reinvi,REinvestors as ras
                                WHERE c.industry = i.industryid
                                AND ac.AcquirerId = peinv.AcquirerId
                                AND peinv.Deleted =0
                                AND peinv.StageId = s.RETypeId
                                AND c.PECompanyId = peinv.PECompanyId
                                AND adcomp.CIAId = cia.CIAID
                                AND Reinvi.MandAId  =peinv.MandAId 
                                AND ras.InvestorId = Reinvi.InvestorId 
                                AND adcomp.PEId = peinv.MandAId  and AdvisorType='T'
                                AND cianame LIKE '%$advisorsearchstring_trans%' 
                                GROUP BY peinv.MandAId 
                                ) ";
                        }
                        elseif($searchallfield!="")
                        {
                                $getInvestorSql="SELECT DISTINCT inv.InvestorId, inv.*
                                FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv
                                WHERE pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry =15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0  and Investor like '%$searchallfield%' order by inv.Investor ";
                        }
                        else{
                                $getInvestorSql = "SELECT DISTINCT inv.InvestorId, inv.*
                                FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv,industry as i
                                where ";

                                //echo "<br> individual where clauses have to be merged ";

                                if ($industry > 0)
                                {
                                     $whereind = " pec.industry=" .$industry;
                                }
                                if ($dealTypeId!= "")
                                {
                                    $wheredealtype = " pe.DealTypeId =" .$dealTypeId;
                                }
                                if ($startrange!= "" && $endrange!= "" )
                                {
                                    if($startrange < $endrange)
                                            $whererange = " pe.DealAmount between  ".$startrange." and ".$endrange."";
                                    elseif($startrange == $endrange)
                                            $whererange = " pe.DealAmount >= ".$startrange ."";
                                }
                                if($dt1!='' && $dt2!='')
                                {
                                     $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                                }
                                if ($whereind != "")
                                {
                                        $getInvestorSql=$getInvestorSql . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                                if (($wherestagehide != ""))
                                {
                                        $getInvestorSql=$getInvestorSql . $wherestagehide . " and " ;
                                        $bool=true;
                                }
                                if (($wheredealtype != "") )
                                {
                                        $getInvestorSql=$getInvestorSql .$wheredealtype . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $getInvestorSql=$getInvestorSql .$whererange . " and ";
                                        $bool=true;
                                }
                                if(($wheredates !== "") )
                                {
                                        $getInvestorSql = $getInvestorSql . $wheredates ." and ";
                                        $bool=true;
                                }
                                $getInvestorSql = $getInvestorSql . " pe.PECompanyId = pec.PEcompanyId 
                                AND peinv.MandAId = pe.MandAId AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 ".$dirsearchall." order by inv.Investor";
                        }
                    }

                        $sql=$getInvestorSql;
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
                        $filetitle="RE-Investors";
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
                               echo "Address 2"."\t";
                               echo "City"."\t";
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
                               echo "Type"."\t";
                               echo "Limited Partners"."\t";
                               echo "Number of Funds"."\t";
                               echo "Additional Info"."\t";
                               echo "Industry (Existing Investments)"."\t";
                               echo "Investments"."\t";
                               echo "Exits - IPO"."\t";
                               echo "Exits - M&A"."\t";
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

				     while($row = mysql_fetch_row($result))
				     {
                                         if(trim($row[2]) !=''){
				         //set_time_limit(60); // HaRa
				         $schema_insert = "";
				         $strStage="";
				         $strIndustry="";
				         $strCompany="";
				         $stripoCompany="";
				         $strmandaCompany="";



						$Investorname=trim($row[1]);
						$Investorname=strtolower($Investorname);

						$invResult=substr_count($Investorname,$searchString);
						$invResult1=substr_count($Investorname,$searchString1);
						$invResult2=substr_count($Investorname,$searchString2);

						if(($invResult==0) && ($invResult1==0) && ($invResult2==0))

						{
									 $InvestorId=$row[0];//investorid
									$schema_insert .=$row[2].$sep; //Investorname
									$schema_insert .=$row[3].$sep; //address
									$schema_insert .=$row[4].$sep; //address line 2
									$schema_insert .=$row[5].$sep; //city
									$schema_insert .=$row[6].$sep; //zip
									$schema_insert .=$row[7].$sep; //Telephone
									$schema_insert .=$row[8].$sep; //Fax
									$schema_insert .=$row[9].$sep; //Email
									$schema_insert .=$row[10].$sep; //Website
									$schema_insert .=$row[12].$sep; //Description
									$schema_insert .=$row[13].$sep; //Year founded


									$onMgmtSql="select pec.InvestorId,mgmt.InvestorId,mgmt.ExecutiveId,
									exe.ExecutiveName,exe.Designation,exe.Company from
									REinvestors as pec,executives as exe,REinvestors_management as mgmt
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

									$stageSql= "select distinct s.REType,pe.StageId,peinv_inv.InvestorId
												from REinvestments_investors as peinv_inv,REinvestors as inv,REinvestments as pe,realestatetypes as s
												where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId
												and pe.PEId=peinv_inv.PEId and s.RETypeId=pe.StageId and REType!='' order by REType ";
									if($rsStage= mysql_query($stageSql))
									{
										While($myStageRow=mysql_fetch_array($rsStage, MYSQL_BOTH))
										{
											$strStage=$strStage.", ".$myStageRow[0];
										}
										$strStage =substr_replace($strStage, '', 0,1);
									}
									$schema_insert .=$strStage.$sep; //Type
									$schema_insert .=$row[20].$sep; //Limited Partners
									$schema_insert .=$row[21].$sep; //Number of funds
									$schema_insert .=$row[24].$sep; //Addtional Info

									/*$indSql= " SELECT DISTINCT i.industry as ind, c.industry, peinv_inv.InvestorId
											FROM REinvestments_investors AS peinv_inv, REinvestors AS inv, REcompanies AS c, REinvestments AS peinv, reindustry AS i
											WHERE peinv_inv.InvestorId =$InvestorId
											AND inv.InvestorId = peinv_inv.InvestorId
											AND c.PECompanyId = peinv.PECompanyId
											AND peinv.PEId = peinv_inv.PEId
											AND i.industryid = c.industry order by i.industry";*/
                                                                        if($industry > 0){
                                                                            $indSql = "SELECT DISTINCT i.industry as ind, peinv.IndustryId, peinv_inv.InvestorId
                                                                            FROM REinvestments_investors AS peinv_inv, REinvestors AS inv, REcompanies AS c, REinvestments AS peinv, reindustry AS i
                                                                            WHERE peinv_inv.InvestorId =$InvestorId AND inv.InvestorId = peinv_inv.InvestorId AND c.PECompanyId = peinv.PECompanyId
                                                                            AND peinv.PEId = peinv_inv.PEId AND i.industryid = peinv.IndustryId AND peinv.IndustryId = $industry  order by i.industry";
                                                                        }else{
                                                                        $indSql = "SELECT DISTINCT i.industry as ind, peinv.IndustryId, peinv_inv.InvestorId
                                                                            FROM REinvestments_investors AS peinv_inv, REinvestors AS inv, REcompanies AS c, REinvestments AS peinv, reindustry AS i
                                                                            WHERE peinv_inv.InvestorId =$InvestorId AND inv.InvestorId = peinv_inv.InvestorId AND c.PECompanyId = peinv.PECompanyId
                                                                            AND peinv.PEId = peinv_inv.PEId AND i.industryid = peinv.IndustryId  order by i.industry";
                                                                        }                                                                        
                                                                        
									if($rsInd= mysql_query($indSql))
										{
											While($myIndrow=mysql_fetch_array($rsInd, MYSQL_BOTH))
											{
												$strIndustry=$strIndustry.", ".$myIndrow["ind"];
											}
											$strIndustry =substr_replace($strIndustry, '', 0,1);
										}

									$schema_insert .=$strIndustry.$sep; //Industry for Existing investments

                                                                        if($industry > 0){
                                                                            $indSql1 = mysql_query("select peinv_inv.PEId
                                                                            FROM REinvestments_investors AS peinv_inv, REinvestors AS inv, REcompanies AS c, REinvestments AS peinv, reindustry AS i
                                                                            WHERE peinv_inv.InvestorId =$InvestorId and inv.InvestorId = peinv_inv.InvestorId AND c.PECompanyId = peinv.PECompanyId
                                                                            AND peinv.PEId = peinv_inv.PEId AND i.industryid = peinv.IndustryId AND peinv.IndustryId = $industry group by peinv_inv.PEId order by i.industry");
                                                                            $PEIds= ' ( ';
										While($indSqlrow=mysql_fetch_array($indSql1, MYSQL_BOTH))
										{
                                                                                    $PEIds .= " peinv_inv.PEId=".$indSqlrow['PEId'].' or ';
                                                                                }
                                                                                $PEIds = trim($PEIds, ' or ');
                                                                                if($PEIds== ' ( '){
                                                                                    $PEIds = '';
                                                                                }else{
                                                                                    $PEIds .= ' ) ';                                                                                    
                                                                                }
                                                                                
                                                                            $Investmentsql="select peinv_inv.InvestorId,peinv_inv.PEId,peinv.PECompanyId, c.companyname,DATE_FORMAT( peinv.dates, '%b-%Y' )as dealperiod,inv.* from REinvestments_investors as peinv_inv,REinvestors as inv, REinvestments as peinv,REcompanies as c where $PEIds and inv.InvestorId=peinv_inv.InvestorId and peinv.PEId=peinv_inv.PEId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0 order by peinv.dates desc";
                                                                        }else{
                                                                            $Investmentsql="select peinv_inv.InvestorId,peinv_inv.PEId,peinv.PECompanyId, c.companyname,DATE_FORMAT( peinv.dates, '%b-%Y' )as dealperiod,inv.* from REinvestments_investors as peinv_inv,REinvestors as inv, REinvestments as peinv,REcompanies as c where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId and peinv.PEId=peinv_inv.PEId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0 order by peinv.dates desc";
                                                                        }

									if ($getcompanyinvrs = mysql_query($Investmentsql))
									{
										While($myInvestrow=mysql_fetch_array($getcompanyinvrs, MYSQL_BOTH))
										{
											$companyName=trim($myInvestrow["companyname"]);
											$companyName=strtolower($companyName);
											$compResult=substr_count($companyName,$searchString);
											$compResult1=substr_count($companyName,$searchString1);
											if(($compResult==0) && ($compResult1==0))
												$compdisplay=$myInvestrow["companyname"];
											else
												$compdisplay= $searchStringDisplay;

											$strCompany=$strCompany.",".$compdisplay."-".$myInvestrow["dealperiod"];
										}
									}
										$strInvestments =substr_replace($strCompany, '', 0,1);
										$schema_insert .=$strInvestments.$sep;  // Existing Investments with deal date

										$iposql="select peinv_inv.InvestorId,peinv_inv.IPOId,peinv.PECompanyId,c.companyname,
										DATE_FORMAT( peinv.IPODate, '%b-%Y' ) as dealperiod,inv.*from REipo_investors as peinv_inv,REinvestors as inv,
										REipos as peinv,REcompanies as c where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId
										and peinv.Deleted=0 and peinv.IPOId=peinv_inv.IPOId and c.PECompanyId=peinv.PECompanyId";

										if ($getcompanyipors = mysql_query($iposql))
										{
											While($myInvestiporow=mysql_fetch_array($getcompanyipors, MYSQL_BOTH))
											{
												$ipocompanyName=trim($myInvestiporow["companyname"]);
												$ipocompanyName=strtolower($ipocompanyName);
												$ipocompResult=substr_count($ipocompanyName,$searchString);
												$ipocompResult1=substr_count($ipocompanyName,$searchString1);
												if(($ipocompResult==0) && ($ipocompResult1==0))
													$ipocompdisplay=$myInvestiporow["companyname"];
												else
													$ipocompdisplay= $searchStringDisplay;

												$stripoCompany=$stripoCompany.",".$ipocompdisplay."-".$myInvestiporow["dealperiod"];
											}
										}
											$stripoInvestments =substr_replace($stripoCompany, '', 0,1);
											$schema_insert .=$stripoInvestments.$sep;  // Existing IPO Exits with deal date


										$mandasql="select peinv_inv.InvestorId,peinv_inv.MandAId,peinv.PECompanyId,
											c.companyname,DATE_FORMAT( peinv.DealDate, '%b-%Y' )as dealperiod,inv.*
											from REmanda_investors as peinv_inv,REinvestors as inv,
											REmanda as peinv,REcompanies as c
											where peinv_inv.InvestorId=$InvestorId and inv.InvestorId=peinv_inv.InvestorId
											and peinv.MandAId=peinv_inv.MandAId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0
											order by DealDate desc";
										if ($getcompanymandars = mysql_query($mandasql))
										{
											While($myInvestmandarow=mysql_fetch_array($getcompanymandars, MYSQL_BOTH))
											{
												$mandacompanyName=trim($myInvestmandarow["companyname"]);
												$mandacompanyName=strtolower($mandacompanyName);
												$mandacompResult=substr_count($mandacompanyName,$searchString);
												$mandacompResult1=substr_count($mandacompanyName,$searchString1);
												if(($mandacompResult==0) && ($mandacompResult1==0))
													$mandacompdisplay=$myInvestmandarow["companyname"];
												else
													$mandacompdisplay= $searchStringDisplay;

												$strmandaCompany=$strmandaCompany.",".$mandacompdisplay."-".$myInvestmandarow["dealperiod"];
											}
										}
											$strmandaInvestments =substr_replace($strmandaCompany, '', 0,1);
											$schema_insert .=$strmandaInvestments.$sep;  // Existing M&A Exits with deal date

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
							} //end of ifloop that checks for companies not having undisclosed as the name
                                        }
				     }

                    print("\n");
                    print("\n");
                    print("\n");
                    print("\n");
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
									//	mail($to,$subject,$message,$headers);
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
				?>


