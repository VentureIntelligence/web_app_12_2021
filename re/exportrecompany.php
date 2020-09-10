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
                $stagehidevalue=$_POST['txthidestageid'];
                if($_POST['txthidestageid'] && $stagehidevalue!="")
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
                            $getcompanySql=" SELECT pe.PECompanyId  as PECompanyId, pec.* FROM REinvestments_investors as peinv,REinvestments as pe,realestatetypes as s,
                            REinvestors as inv,REcompanies AS pec, reindustry AS i WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.StageId=s.REtypeId 
                            and pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and Investor like '%$keyword%' group by pe.PECompanyId ORDER BY pec.companyname";
                        }
                        else if($companysearch!="")
                        {
                            $getcompanySql="SELECT pe.PECompanyId  as PECompanyId, pec.* FROM REinvestments AS pe,REcompanies AS pec, reindustry AS i
                            WHERE pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and pec.companyname like '%$companysearch%' 
                            group by pe.PECompanyId ORDER BY pec.companyname";
                        }
                        else if($sectorsearch!="")
                        {
                            $getcompanySql=" SELECT pe.PECompanyId  as PECompanyId, pec.* FROM REinvestments_investors as peinv,REinvestments as pe,realestatetypes as s,
                            REinvestors as inv,REcompanies AS pec, reindustry AS i WHERE peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.StageId=s.REtypeId 
                            and pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and pec.sector_business like '%$sectorsearch%' group by pe.PECompanyId ORDER BY pec.companyname";
                        }
                        elseif($advisorsearchstring_legal!="")
                        {
                            $getcompanySql="(
                            SELECT peinv.PECompanyId  as PECompanyId, c.*
                            FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                            WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='L'
                            AND cia.cianame LIKE '$advisorsearchstring_legal%' GROUP BY peinv.PEId
                            )
                            UNION (
                            SELECT peinv.PECompanyId  as PECompanyId, c.*
                            FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                            WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='L'
                            AND cia.cianame LIKE '$advisorsearchstring_legal%' GROUP BY peinv.PEId
                            )";
                        }
                        elseif($advisorsearchstring_trans!="")
                        {
                            $getcompanySql="(
                            SELECT peinv.PECompanyId  as PECompanyId, c.* 
                            FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorinvestors AS adac
                            WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='T'
                            AND cia.cianame LIKE '$advisorsearchstring_trans%' GROUP BY peinv.PEId
                            )
                            UNION (
                            SELECT peinv.PECompanyId  as PECompanyId, c.*
                            FROM REinvestments AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac
                            WHERE peinv.Deleted=0 and peinv.IndustryId = i.industryid AND c.PECompanyId = peinv.PECompanyId
                            AND adac.CIAId = cia.CIAID AND adac.PEId = peinv.PEId   and AdvisorType='T'
                            AND cia.cianame LIKE '$advisorsearchstring_trans%' GROUP BY peinv.PEId
                            )";
                            
                        }
                        else
                        {
                            $getcompanySql = "SELECT pe.PECompanyId  as PECompanyId, pec.* FROM REinvestments AS pe,REcompanies AS pec, reindustry AS i
				WHERE ";
                            
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
                                    $getcompanySql=$getcompanySql.$whereind ." and ";
                            }
                            if (($stagehidevalue != ""))
                            {
                                    $getcompanySql=$getcompanySql.$stagehidevalue . " and " ;
                            }
                            if (($whereInvType != "") )
                            {
                                    $getcompanySql=$getcompanySql.$whereInvType . " and ";
                            }
                            if (($whererange != "") )
                            {
                                    $getcompanySql=$getcompanySql.$whererange. " and ";
                            }
                            if(($wheredates != "") )
                            {
                                    $getcompanySql = $getcompanySql.$wheredates." and ";
                            }

                            $getcompanySql = $getcompanySql."  pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 group by pe.PECompanyId 
                            ORDER BY pec.companyname ";
                        }
                    }
                    elseif($vcflagValue==1)
                    {
                        if($keyword!="")
                        {

                            $getcompanySql="SELECT DISTINCT pe.PECompanyId, pec.*
                            FROM REipos AS pe, REcompanies AS pec, REipo_investors AS peinv, REinvestors AS inv
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry =15
                            AND peinv.IPOId = pe.IPOId
                            AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 and Investor like '%$keyword%' order by inv.Investor ";
                        }
                        else if($companysearch!="")
                        {

                            $getcompanySql="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REipos AS pe
                            WHERE pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 and pec.companyname like '%$companysearch%' ORDER BY pec.companyname";
                        }
                        elseif($searchallfield!="")
                        {
                            $getcompanySql="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REipos AS pe
                            WHERE pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 and pec.companyname like '%$searchallfield%' ORDER BY pec.companyname";
                        }
                        else{
                            
                            $getcompanySql="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REipos AS pe, reindustry AS i WHERE";
                                if ($industry > 0)
                                    $whereind = " pec.industry=" .$industry ;

                                if($dt1!='' && $dt2!='')
                                {
                                        $wheredates= " IPODate between '" .$dt1. "' and '" .$dt2. "'";
                                }
                                if ($whereind != "")
                                {
                                        $getcompanySql=$getcompanySql . $whereind ." and ";
                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                                if(($wheredates != "") )
                                {
                                        $getcompanySql = $getcompanySql . $wheredates ." and ";
                                        $bool=true;
                                }
                                $getcompanySql=$getcompanySql." pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 
                                            ".$dirsearchall."  ORDER BY pec.companyname";
                        }
                    
                    }          
                    elseif($vcflagValue==2)
                    {
                        if($keyword!="")
                        {
                            $getcompanySql="SELECT pe.PECompanyId  as PECompanyId, pec.*
                            FROM REmanda AS pe, REcompanies AS pec, REmanda_investors AS peinv, REinvestors AS inv
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry =15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0  and Investor like '%$keyword%' order by inv.Investor ";
                        }
                        else if($companysearch!="")
                        {
                                $getcompanySql="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REmanda AS pe
                                WHERE pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 and pec.companyname like '%$companysearch%' ORDER BY pec.companyname";
                        }
                        else if($sectorsearch!=""){

                                $getcompanySql="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REmanda AS pe
                                WHERE pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 and pec.sector_business like '%$sectorsearch%' ORDER BY pec.companyname";
                        }
                        elseif($advisorsearchstring_legal!="")
                        {
                                $getcompanySql="(SELECT peinv.PECompanyId as PECompanyId, c.* 
                                FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s
                                WHERE c.industry = i.industryid 
                                AND ac.AcquirerId = peinv.AcquirerId 
                                AND peinv.Deleted =0 
                                AND peinv.StageId = s.RETypeId 
                                AND c.PECompanyId = peinv.PECompanyId 
                                AND adac.CIAId = cia.CIAID 
                                AND adac.PEId = peinv.MandAId  and AdvisorType='L' 
                                AND cia.cianame LIKE '%$advisorsearchstring_legal%' 
                                GROUP BY peinv.MandAId 
                                )
                                UNION (

                                SELECT peinv.PECompanyId as PECompanyId, c.*
                                FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s
                                WHERE c.industry = i.industryid
                                AND ac.AcquirerId = peinv.AcquirerId
                                AND peinv.Deleted =0
                                AND peinv.StageId = s.RETypeId
                                AND c.PECompanyId = peinv.PECompanyId
                                AND adcomp.CIAId = cia.CIAID
                                AND adcomp.PEId = peinv.MandAId  and AdvisorType='L'
                                AND cianame LIKE '%$advisorsearchstring_legal%' 
                                GROUP BY peinv.MandAId 
                                ) ";
                        }
                        elseif($advisorsearchstring_trans!="")
                        {
                            $getcompanySql="(SELECT peinv.PECompanyId as PECompanyId, c.*
                            FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac, REacquirers AS ac, realestatetypes AS s
                            WHERE c.industry = i.industryid 
                            AND ac.AcquirerId = peinv.AcquirerId 
                            AND peinv.Deleted =0 
                            AND peinv.StageId = s.RETypeId 
                            AND c.PECompanyId = peinv.PECompanyId 
                            AND adac.CIAId = cia.CIAID 
                            AND adac.PEId = peinv.MandAId  and AdvisorType='T' 
                            AND cia.cianame LIKE '%$advisorsearchstring_trans%' 
                            GROUP BY peinv.MandAId 
                            )
                            UNION (

                            SELECT peinv.PECompanyId as PECompanyId, c.* 
                            FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia, REinvestments_advisorcompanies AS adcomp, REacquirers AS ac, realestatetypes AS s
                            WHERE c.industry = i.industryid
                            AND ac.AcquirerId = peinv.AcquirerId
                            AND peinv.Deleted =0
                            AND peinv.StageId = s.RETypeId
                            AND c.PECompanyId = peinv.PECompanyId
                            AND adcomp.CIAId = cia.CIAID
                            AND adcomp.PEId = peinv.MandAId  and AdvisorType='T'
                            AND cianame LIKE '%$advisorsearchstring_trans%' 
                            GROUP BY peinv.MandAId 
                            ) ";
                       }
                        elseif($searchallfield!="")
                        {
                                 $getcompanySql="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REmanda AS pe
                                WHERE pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 and pec.companyname like '%$searchallfield%' ORDER BY pec.companyname";
                        }
                        else{
                           $getcompanysqlreal="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REmanda AS pe WHERE";
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
                                       $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                                if ($whereind != "")
                                {
                                        $getcompanysqlreal=$getcompanysqlreal . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }

                                if (($stagehidevalue != ""))
                                {
                                        $getcompanysqlreal=$getcompanysqlreal . $stagehidevalue . " and " ;
                                        $bool=true;
                                }
                                if (($wheredealtype != "") )
                                {
                                        $getcompanysqlreal=$getcompanysqlreal .$wheredealtype . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $getcompanysqlreal=$getcompanysqlreal .$whererange . " and ";
                                        $bool=true;
                                }
                                if(($wheredates != "") )
                                {
                                        $getcompanysqlreal = $getcompanysqlreal . $wheredates ." and ";
                                        $bool=true;
                                }
                                $getcompanySql=$getcompanysqlreal." pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 ".$dirsearchall."  ORDER BY pec.companyname";
                               
                        }
                        
                    }
                    elseif($vcflagValue==3)
                    {
                        if($companysearch!="")
                        {
                                $getcompanySql="SELECT DISTINCT pe.PECompanyId, pec.*
                                FROM REcompanies AS pec, REmama AS pe WHERE pec.PECompanyId = pe.PEcompanyId 
                                and pe.Deleted=0 and pec.companyname like '%$companysearch%' ORDER BY pec.companyname";
                        }
                        else if($sectorsearch!=""){

                                $getcompanySql="SELECT DISTINCT pe.PECompanyId, pec.*
                                FROM REcompanies AS pec, REmama AS pe WHERE pec.PECompanyId = pe.PEcompanyId 
                                and pe.Deleted=0 and pec.sector_business like '%$sectorsearch%' ORDER BY pec.companyname";
                        }
                        elseif($advisorsearchstring_legal!="")
                        { 
                                $getcompanySql="(
                                SELECT DISTINCT peinv.PECompanyId,c.*
                                FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                                WHERE Deleted =0
                                AND c.PECompanyId = peinv.PECompanyId
                                AND adac.CIAId = cia.CIAID
                                AND adac.MAMAId = peinv.MAMAId  and AdvisorType='L'
                                 AND cia.cianame LIKE '%$advisorsearchstring_legal%'
                                )
                                UNION (
                                SELECT DISTINCT peinv.PECompanyId,c.*
                                FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                                WHERE Deleted =0
                                AND c.PECompanyId = peinv.PECompanyId
                                AND adcomp.CIAId = cia.CIAID
                                AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='L'
                                 AND cia.cianame LIKE '%$advisorsearchstring_legal%'
                                )";
                        }
                        elseif($advisorsearchstring_trans!="")
                        {
                            $getcompanySql="(
                                SELECT DISTINCT peinv.PECompanyId,c.*
                                FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisoracquirer AS adac
                                WHERE Deleted =0
                                AND c.PECompanyId = peinv.PECompanyId
                                AND adac.CIAId = cia.CIAID
                                AND adac.MAMAId = peinv.MAMAId  and AdvisorType='T'
                                 AND cia.cianame LIKE '%$advisorsearchstring_trans%'
                                )
                                UNION (
                                SELECT DISTINCT peinv.PECompanyId,c.*
                                FROM REmama AS peinv, REcompanies AS c, REadvisor_cias AS cia, REmama_advisorcompanies AS adcomp
                                WHERE Deleted =0
                                AND c.PECompanyId = peinv.PECompanyId
                                AND adcomp.CIAId = cia.CIAID
                                AND adcomp.MAMAId = peinv.MAMAId and AdvisorType='T'
                                 AND cia.cianame LIKE '%$advisorsearchstring_trans%'
                                )";
                       }
                        elseif($searchallfield!="")
                        {
                                $getcompanySql="SELECT DISTINCT pe.PECompanyId, pec.*
                                FROM REcompanies AS pec, REmama AS pe WHERE pec.PECompanyId = pe.PEcompanyId 
                                and pe.Deleted=0 and pec.companyname like '%$searchallfield%' ORDER BY pec.companyname";
                        }
                        else{

                                $getcompanysqlreal="SELECT DISTINCT pe.PECompanyId, pec.* FROM REcompanies AS pec, REmama AS pe WHERE";
                                if ($industry > 0)
                                {
                                     $whereind = " pec.industry=" .$industry;
                                }
                                if ($dealTypeId!= "")
                                {
                                    $wheredealtype = " pe.MADealTypeId =" .$dealTypeId;
                                }

                                if ($startrange!= "" && $endrange!= "" )
                                {
                                    if($startrange < $endrange)
                                            $whererange = " pe.Amount between  ".$startrange." and ".$endrange."";
                                    elseif($startrange == $endrange)
                                            $whererange = " pe.Amount >= ".$startrange ."";
                                }
                                if($dt1!='' && $dt2!='')
                                       $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                                if ($whereind != "")
                                {
                                        $getcompanysqlreal=$getcompanysqlreal . $whereind ." and ";

                                        $bool=true;
                                }
                                else
                                {
                                        $bool=false;
                                }
                                if (($wheredealtype != "") )
                                {
                                        $getcompanysqlreal=$getcompanysqlreal .$wheredealtype . " and ";
                                        $bool=true;
                                }
                                if (($whererange != "") )
                                {
                                        $getcompanysqlreal=$getcompanysqlreal .$whererange . " and ";
                                        $bool=true;
                                }
                                if(($wheredates != "") )
                                {
                                        $getcompanysqlreal = $getcompanysqlreal . $wheredates ." and ";
                                        $bool=true;
                                }
                               
                                $getcompanysqlreal = $getcompanysqlreal." pec.PECompanyId = pe.PEcompanyId and pe.Deleted=0 ".$dirsearchall." ORDER BY pec.companyname";

                                $getcompanySql= $getcompanysqlreal;
                        }
                        
                    }
                        $sql=$getcompanySql;
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
                                $filetitle="RE-Companies";
                                
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
					echo "Company"."\t";
					echo "Industry"."\t";
					echo "Sector"."\t";
					echo "Stock Code"."\t";
					echo "Year Founded"."\t";
					echo "Address"."\t";
					echo ""."\t";
					echo "City"."\t";
					echo "Country"."\t";
					echo "Zip"."\t";
					echo "Telephone "."\t";
					echo "Fax"."\t";
					echo "Email"."\t";
					echo "Website"."\t";
					echo "More Information"."\t";
					echo "Other Location(s)"."\t";
					echo "Investors"."\t";
					echo "Investor Board Members"."\t";
					echo "Top Management "."\t";
					echo "Exits "."\t";
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


                                                $companyId=$row[0];//investorid
						$schema_insert .=$row[2].$sep; //CompanyName
						$companyName=$row[2];
						$schema_insert .=$row[3].$sep; //inudstry
						$schema_insert .=$row[4].$sep; //sector_business
						$schema_insert .=$row[9].$sep; //stockcode
						$schema_insert .=$row[10].$sep; //yearfounded

						$schema_insert .=$row[11].$sep; //address
						$schema_insert .=$row[12].$sep; //address line 2
						$schema_insert .=$row[7].$sep; //city
						$schema_insert .=$row[16].$sep; //Country
						$schema_insert .=$row[14].$sep; //ZIP
						$schema_insert .=$row[18].$sep; //Telephone
						$schema_insert .=$row[19].$sep; //Fax
						$schema_insert .=$row[20].$sep; //Email
						$schema_insert .=$row[5].$sep; //Website
						$schema_insert .=$row[21].$sep; //Description
						$schema_insert .=$row[13].$sep; //Description


						if($rsStage= mysql_query($investorSql))
						{
							While($myInvestorRow=mysql_fetch_array($rsStage, MYSQL_BOTH))
							{
								$strStage=$strStage.", ".$myInvestorRow["Investor"]."(".$myInvestorRow["dt"].")";
							}
							$strStage =substr_replace($strStage, '', 0,1);
						}
						//echo "<BR>*********************".$strStage;
						$schema_insert .=$strStage.$sep; //investors

					$onBoardSql="select pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId,
						exe.ExecutiveName,exe.Designation,exe.Company from
						REcompanies as pec,executives as exe,REcompanies_board as bd
						where pec.PECompanyId=$companyId and bd.PECompanyId=pec.PECompanyId and exe.ExecutiveId=bd.ExecutiveId";
								//echo "<Br>Board-" .$onBoardSql;

						if($rsBoard= mysql_query($onBoardSql))
						{
							$BoardTeam="";
							While($myboardrow=mysql_fetch_array($rsBoard, MYSQL_BOTH))
							{
								$Exename= $myboardrow["ExecutiveName"];
								$Designation=$myboardrow["Designation"];
								if($Designation!="")
									$BoardTeam=$BoardTeam.";".$Exename.",".$Designation;
								else
									$BoardTeam=$BoardTeam.";".$Exename;

								$company=$myboardrow["Company"];
								if($company!="")
									$BoardTeam=$BoardTeam.";".$company;
								else
									$BoardTeam=$BoardTeam;

							}
							$BoardTeam=substr_replace($BoardTeam, '', 0,1);
						}
						$schema_insert .=$BoardTeam.$sep; //BoardTeam

				$onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,
				exe.ExecutiveName,exe.Designation,exe.Company from
				REcompanies as pec,executives as exe,REcompanies_management as mgmt
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
			$ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry,
						IPOAmount, DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId
						FROM REipos AS pe, reindustry AS i, REcompanies AS pec WHERE  i.industryid=pec.industry
						AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0  and pe.PECompanyId=$companyId order by dt desc";
					if($rsipoexit= mysql_query($ipoexitsql))
					{
					While($ipoexitrow=mysql_fetch_array($rsipoexit, MYSQL_BOTH))
						{
							$strIpos=$strIpos.",".$ipoexitrow["dt"];
						}
					}
						$strIpos=substr_replace($strIpos,'',0,1);
						if(trim(strIpos)!="")
						{
							$FinalStringIPOs="IPO:".$strIpos;
						}



			$strmas="";
			$FinalStringMAs="";

			$maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry
			DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId
			FROM REmanda AS pe, reindustry AS i, REcompanies AS pec WHERE  i.industryid=pec.industry
			AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0  and pe.PECompanyId=$companyId order by dt desc";
				if($rsmaexit= mysql_query($maexitsql))
					{
					While($maexitrow=mysql_fetch_array($rsmaexit, MYSQL_BOTH))
						{
							$strmas=$strmas.",".$maexitrow["dt"];
						}
					}
					$strmas=substr_replace($strmas, '', 0,1);
					if(strmas!="")
					{
						$FinalStringMAs="  M&A:".$strmas;
					}
				$schema_insert .=$FinalStringIPOs.$FinalStringMAs.$sep; // Exits IPOs-M&As


				     $schema_insert = str_replace($sep."$", "", $schema_insert);
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
				/* mail sending area ends */


				//		}
				//else
				//	header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;


}
 mysql_close();  
				?>


