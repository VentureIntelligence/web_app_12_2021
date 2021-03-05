<?php include_once("../globalconfig.php"); ?>
<?php
 //session_save_path("/tmp");
	//session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
	include ('checklogin.php');    
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

					$submitemail=$_POST['txthideemail'];

					$searchdisplay="PREExits-M&A";
					$filetitle="REExits-M&A";

						//variable that differentiates, PE/VC/RealEstate

					$industry=$_POST['txthideindustryid'];
					$hideindustrytext=$_POST['txthideindustry'];
                                        $stage=$_POST['txthidestageid'];
                                        $stagetext=$_POST['txthidestagevalue'];
					$dealtypetext=$_POST['txthidedealtype'];
					$dealtype=$_POST['txthidedealtypeid'];
					$SPVvalue=$_POST['txthideSPV'];
					$SPVvaluenmae=$_POST['txthideSPVName'];
                                        $searchallfield=$_POST['txthidesearchallfield'];
					$hidedateStartValue=$_POST['txthidedateStartValue'];
					$hidedateEndValue=$_POST['txthidedateEndValue'];
					$dateValue=$_POST['txthidedate'];

					$keyword=$_POST['txthideinvestor'];
					//echo "<br>^^^^^^^^^" .$keyword;
					$companysearch=$_POST['txthidecompany'];
					$acquirersearch=$_POST['txthideacquirer'];
					$advisorsearch_legal=$_POST['txthideadvisor_legal'];
                                        $advisorsearch_legal =ereg_replace("-"," ",$advisorsearch_legal);
                                        $advisorsearch_trans=$_POST['txthideadvisor_trans'];
                                        $advisorsearch_trans =ereg_replace("-"," ",$advisorsearch_trans);

                                        $sectorsearch=$_POST['txthidesectorsearch'];
                                        $sectorsearch =stripslashes(ereg_replace("_"," ",$sectorsearch));

                                        $exitstatusValue = $_POST['txthideexitstatus'];

					$submitemail=$_POST['txthideemail'];

                                        
                                        

					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";


				//echo "<br>Industry Id-----------------**".$hideindustryid;
				//echo "<br>Inv type id-----------------**".$invtypevalueid;
				//echo "<br>Start Range Value-----------------**".$hiderangeStartValue;
				//echo "<br>End Range value-----------------**".$hiderangeEndValue;

				//echo "<br>start Date-----------------**".$hidedateStartValue;
				//echo "<br>End Date-----------------**".$hidedateEndValue;
				//echo "<br>---date text- " .$dateValue;
			//	echo "<br>Investor Search text-----------------**".$advisorsearch;
			//	echo "<br>Deal Type---**". $dealtype;


			if (($keyword == "") && ($companysearch=="") && ($acquirersearch=="") && ($advisorsearch_legal=="") && ($advisorsearch_trans=="")&& (count($industry) <=0)  && (count($stage)<=0) && ($dealtype=="--")&& ($SPVvalue=="--") && ($hidedateStartValue == "------01") && ($hidedateEndValue == "------01"))
                        {
				 $companysql = "SELECT pe.MandAId,pe.MandAId,pe.MandAId,pe.PECompanyId,pec.industry,pe.DealTypeId,pe.AcquirerId,
				 pec.companyname, i.industry, s.REType,
				 dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
				 DealAmount, website, MoreInfor,hideamount,hidemoreinfor,pe.city,r.Region,pe.InvestmentDeals,
                                 pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,SPV,ProjectName,ExitStatus,pec.sector_business  as sector_business
				 FROM
				 REmanda AS pe, reindustry AS i, REcompanies AS pec,dealtypes as dt,region as r,realestatetypes as s
				 WHERE pec.industry = i.industryid and dt.DealTypeId=pe.DealTypeId and r.RegionId=pe.RegionId
				 AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry=15 and pe.StageId=s.RETypeId order by companyname";

				//echo "<br>3 Query for All records" .$companysql;
                        }
                        elseif ($searchallfield != "")
                        {
                        $companysql="SELECT pe.MandAId,pe.PECompanyId, pec.industry,pe.DealTypeId,pe.AcquirerId,
                        pec.companyname, i.industry, s.REType,
                        dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
                        pe.DealAmount,website, MoreInfor,hideamount,hidemoreinfor,pe.city,r.Region,pe.InvestmentDeals,
                        pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,SPV,ProjectName,ExitStatus
                        FROM
                        REmanda AS pe, reindustry AS i, REcompanies AS pec,dealtypes as dt,region as r,realestatetypes as s
                        WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' AND pec.industry = i.industryid AND dt.DealTypeId=pe.DealTypeId and
                        pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
                        AND pe.Deleted =0 and pec.industry=15 and r.RegionId=pe.RegionId
                        AND ( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
                        OR sector_business LIKE '$searchallfield%' OR MoreInfor LIKE '%$searchallfield%' )
                        order by companyname";
//				echo "<br>Query for all search";
//				echo "<br> Company search--" .$companysql;
//                          exit;
                        }                                        
                        elseif ($sectorsearch != "")
                        {
                                            
                            $sectorsearchArray = explode(",", str_replace("'","",$sectorsearch)); 
                            $sector_sql = array(); // Stop errors when $words is empty

                            foreach($sectorsearchArray as $word){

                            //                                                $sector_sql[] = " sector_business LIKE '$word%' ";
                               $sector_sql[] = " sector_business = '$word' ";
                               $sector_sql[] = " sector_business LIKE '$word(%' ";
                               $sector_sql[] = " sector_business LIKE '$word (%' ";
                            }
                            $sector_filter = implode(" OR ", $sector_sql);


                            $companysql="SELECT pe.MandAId,pe.PECompanyId, pec.industry,pe.DealTypeId,pe.AcquirerId,
                            pec.companyname, i.industry, s.REType,
                            dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
                            pe.DealAmount,website, MoreInfor,hideamount,hidemoreinfor,pe.city,r.Region,pe.InvestmentDeals,
                            pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,SPV,ProjectName,ExitStatus,pec.sector_business  as sector_business
                            FROM
                            REmanda AS pe, reindustry AS i, REcompanies AS pec,dealtypes as dt,region as r,realestatetypes as s
                            WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' AND pec.industry = i.industryid AND dt.DealTypeId=pe.DealTypeId and
                            pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
                            AND pe.Deleted =0 and pec.industry=15 and r.RegionId=pe.RegionId
                            AND  ($sector_filter) 
                            order by companyname";
                            //				echo "<br>Query for all search";
                            //				echo "<br> Company search--" .$companysql;
                            //                          exit;
                        }
				elseif ($companysearch != "")
					{
					$companysql="SELECT pe.MandAId,pe.PECompanyId, pec.industry,pe.DealTypeId,pe.AcquirerId,
					pec.companyname, i.industry, s.REType,
					dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
					pe.DealAmount,website, MoreInfor,hideamount,hidemoreinfor,pe.city,r.Region,pe.InvestmentDeals,
                                        pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,SPV,ProjectName,ExitStatus,pec.sector_business  as sector_business
					FROM
					REmanda AS pe, reindustry AS i, REcompanies AS pec,dealtypes as dt,region as r,realestatetypes as s
					WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' AND  pec.industry = i.industryid AND dt.DealTypeId=pe.DealTypeId and
					pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
					AND pe.Deleted =0 and pec.industry=15 and r.RegionId=pe.RegionId
					AND  pec.PECompanyId IN ($companysearch)
					order by companyname";
					//	echo "<br>Query for company search";
				// echo "<br> Company search--" .$companysql;
					}
				elseif($keyword!="")
					{
					$companysql="select peinv.MandAId,peinv.PECompanyId,c.industry,peinv.DealTypeId,
					peinv.AcquirerID,
							c.companyname,i.industry,s.REType,
							dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
							peinv.DealAmount,c.website,Moreinfor,hideamount,hidemoreinfor,
							inv.Investor,peinv.city,r.Region,InvestmentDeals,Link,EstimatedIRR,
                                                        MoreInfoReturns,SPV,ProjectName,ExitStatus,c.sector_business  as sector_business
							from
							REmanda_investors as peinv_inv,
							REinvestors as inv,
							REmanda as peinv,dealtypes as dt,region as r,realestatetypes as s,
							REcompanies as c,reindustry as i
							WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' AND 
							peinv_inv.MandAId=peinv.MandAId and dt.DealTypeId=peinv.DealTypeId and
							inv.InvestorId=peinv_inv.InvestorId and c.industry = i.industryid and
							 c.PECompanyId=peinv.PECompanyId and r.RegionId=peinv.RegionId and peinv.Deleted=0 and pec.industry=15 and
							 peinv.StageId=s.RETypeId
							 AND inv.InvestorId IN  ($keyword) order by companyname";

					//	echo "<br> Investor search- ".$companysql;
					}
				elseif($acquirersearch!="")
				{
				$companysql="SELECT peinv.MandAId,peinv.PECompanyId,c.industry,peinv.DealTypeId,peinv.AcquirerId,
                                                c.companyname,i.industry, s.REType,dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
                                                peinv.DealAmount,c.website,Moreinfor,hideamount,hidemoreinfor,peinv.city,re.Region,ac.Acquirer,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,SPV,ProjectName,ExitStatus,c.sector_business  as sector_business 
                                                FROM REacquirers AS ac, REmanda AS peinv, REcompanies AS c, reindustry AS i, realestatetypes AS s,dealtypes as dt,region as re
                                                WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' AND  ac.AcquirerId = peinv.AcquirerId
                                                AND c.industry = i.industryid
                                                AND peinv.Deleted =0 and pec.industry=15 and dt.DealTypeId=peinv.DealTypeId
                                                AND peinv.StageId = s.RETypeId AND re.RegionId=peinv.RegionId
                                                AND c.PECompanyId = peinv.PECompanyId
                                                AND ac.AcquirerId IN ($acquirersearch)
                                                ORDER BY companyname ASC";
                                    //echo "<Br>Acquirer search--" .$companysql;
				}
				elseif($advisorsearch_legal!="")
				{
				$companysql="(select peinv.MandAId,peinv.PECompanyId,c.industry,peinv.DealTypeId,adac.CIAId AS AcqCIAId,cia.CIAId,peinv.AcquirerId,
							c.companyname,i.industry,s.REType,
							dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
							peinv.DealAmount,c.website,Moreinfor,hideamount,hidemoreinfor,
							peinv.city,r.Region,cia.cianame,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,SPV,ProjectName,ExitStatus,c.sector_business  as sector_business
							from REmanda AS peinv, REcompanies AS c, reindustry AS i,REadvisor_cias AS cia,
							REinvestments_advisoracquirer AS adac,REacquirers as ac,dealtypes as dt,region as r ,realestatetypes as s
							where
							c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and dt.DealType=peinv.DealTypeId and r.RegionId=peinv.RegionId
							and c.PECompanyId=peinv.PECompanyId and adac.CIAId=cia.CIAID and  peinv.Deleted=0 and c.industry=15 and peinv.StageId=s.RETypeId and
							adac.PEId=peinv.MandAId and AdvisorType='L' and cia.cianame LIKE '%$advisorsearch_legal%')
							UNION
							(SELECT peinv.MandAId, peinv.PECompanyId,c.industry,peinv.DealTypeId,adcomp.CIAId AS CompCIAId,cia.CIAId,peinv.AcquirerId,
							c.companyname, i.industry, s.REType,
							dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
							peinv.DealAmount,c.website,Moreinfor,hideamount,hidemoreinfor,
							peinv.city,r.Region,cia.cianame,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns ,SPV,ProjectName,ExitStatus,c.sector_business  as sector_business
							FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia,
							REinvestments_advisorcompanies AS adcomp, REacquirers AS ac,dealtypes as dt,region as r,realestatetypes as s
							WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' AND  c.industry = i.industryid
							AND ac.AcquirerId = peinv.AcquirerId and dt.DealTypeId=peinv.DealTypeId and r.RegionId=peinv.RegionId
							AND c.PECompanyId = peinv.PECompanyId
							AND adcomp.CIAId = cia.CIAID  and  peinv.Deleted=0 and c.industry=15 and peinv.StageId=s.RETypeId
							AND adcomp.PEId = peinv.MandAId  and AdvisorType='L'
							AND cianame LIKE '%$advisorsearch_legal%')
							ORDER BY companyname";
					//echo "<br>Advisor search-- " .$companysql;
				}
				elseif($advisorsearch_trans!="")
				{
				$companysql="(select peinv.MandAId,peinv.PECompanyId,c.industry,peinv.DealTypeId,adac.CIAId AS AcqCIAId,cia.CIAId,peinv.AcquirerId,
							c.companyname,i.industry,s.REType,
							dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
							peinv.DealAmount,c.website,Moreinfor,hideamount,hidemoreinfor,
							peinv.city,r.Region,cia.cianame,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,SPV,ProjectName,ExitStatus,c.sector_business  as sector_business
							from REmanda AS peinv, REcompanies AS c, reindustry AS i,REadvisor_cias AS cia,
							REinvestments_advisoracquirer AS adac,REacquirers as ac,dealtypes as dt,region as r ,realestatetypes as s
							where
							c.industry=i.industryid and ac.AcquirerId=peinv.AcquirerId and dt.DealType=peinv.DealTypeId and r.RegionId=peinv.RegionId
							and c.PECompanyId=peinv.PECompanyId and adac.CIAId=cia.CIAID and  peinv.Deleted=0 and c.industry=15 and peinv.StageId=s.RETypeId and
							adac.PEId=peinv.MandAId and AdvisorType='T' and  cia.cianame LIKE '%$advisorsearch_trans%')
							UNION
							(SELECT peinv.MandAId, peinv.PECompanyId,c.industry,peinv.DealTypeId,adcomp.CIAId AS CompCIAId,cia.CIAId,peinv.AcquirerId,
							c.companyname, i.industry, s.REType,
							dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,
							peinv.DealAmount,c.website,Moreinfor,hideamount,hidemoreinfor,
							peinv.city,r.Region,cia.cianame,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns ,SPV,ProjectName,ExitStatus,c.sector_business  as sector_business
							FROM REmanda AS peinv, REcompanies AS c, reindustry AS i, REadvisor_cias AS cia,
							REinvestments_advisorcompanies AS adcomp, REacquirers AS ac,dealtypes as dt,region as r,realestatetypes as s
							WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' AND  c.industry = i.industryid
							AND ac.AcquirerId = peinv.AcquirerId and dt.DealTypeId=peinv.DealTypeId and r.RegionId=peinv.RegionId
							AND c.PECompanyId = peinv.PECompanyId
							AND adcomp.CIAId = cia.CIAID  and  peinv.Deleted=0 and c.industry=15 and peinv.StageId=s.RETypeId
							AND adcomp.PEId = peinv.MandAId   and AdvisorType='T'
							AND cianame LIKE '%$advisorsearch_trans%')
							ORDER BY companyname";
					//echo "<br>Advisor search-- " .$companysql;
				}
                                /////<------------------------------------------------------------------>
				elseif ((count($industry) > 0) || ($SPVvalue > 0) ||  (count($stage) > 0) || ($dealtype != "--") ||  ($dateValue!="---to---"))
					{
							$companysql = "SELECT pe.MandAId,pe.PECompanyId,pec.industry,pe.DealTypeId,pe.AcquirerId,
							pec.companyname,i.industry,s.REType,
							dt.DealType,DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate, pe.DealAmount,pec.website,
							pe.MoreInfor,pe.hideamount,pe.hidemoreinfor,pe.city,r.Region,InvestmentDeals,InvestmentDeals,Link,
                                                        EstimatedIRR,MoreInfoReturns,SPV,ProjectName,ExitStatus,pec.sector_business  as sector_business
							FROM REmanda AS pe, reindustry AS i, REcompanies AS pec,dealtypes as dt,region as r,realestatetypes as s where";
					$whereind="";
					$wheredates="";
					$wheredealtype="";
                                        $wherestage="";
                                        $whereSPVCompanies="";
                                        if (count($industry) > 0 && $industry[0]!='')
                                        {
                                           $indusSql = '';
                                           foreach($industry as $industrys)
                                           {
                                               $indusSql .= " pec.industry=$industrys or ";
                                           }
                                           $indusSql = trim($indusSql,' or ');
                                           if($indusSql !=''){
                                               $whereind = ' ( '.$indusSql.' ) ';
                                           }
                                           $qryIndTitle="Industry - ";
                                           $addVCFlagqry='';
                                        } 
						
                                        if (count($stage) > 0) {

                                            $stagevalue="";
                                            foreach($stage as $stageval)
                                            {
                                                    //echo "<br>****----" .$stage;
                                                    $stagevalue= $stagevalue. " pe.StageId=" .$stageval." or ";
                                            }
                                            $stagevalue = trim($stagevalue,' or ');
                                            if($stagevalue !=''){
                                                $wherestage = ' ( '.$stagevalue .' ) ';
                                            }
                                        }
						if ($dealtype!="--")
							$wheredealtype = " pe.DealTypeId =" .$dealtype;

						//echo "<BR>%%%%%".$SPVvalue;
						if($SPVvalue==1)
							       $whereSPVCompanies=" pe.SPV=0";
						        elseif($SPVvalue==2)
                                                               $whereSPVCompanies=" pe.SPV=1";
						
						if($dateValue!="---to---")
							$wheredates= " DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";

                                                if ($exitstatusValue != '' && $exitstatusValue != '--') {

                                                        $whereexitstatus = " ExitStatus = $exitstatusValue";
                                                    }
                                                    

					if ($whereind != "")
							$companysql=$companysql . $whereind ." and ";
					if ($wherestage != "")
							$companysql=$companysql . $wherestage ." and ";
					if (($wheredealtype != ""))
						$companysql=$companysql . $wheredealtype . " and " ;
						
					if (($whereSPVCompanies != "") )
					        $companysql=$companysql .$whereSPVCompanies . " and ";
					if($wheredates !== "")
						$companysql = $companysql . $wheredates ." and ";

                                         if ($whereexitstatus != "") {

                                                        $companysql = $companysql . $whereexitstatus . " and ";
                                                    }
                                         

					$companysql = $companysql . "  i.industryid=pec.industry and
					pec.PEcompanyID = pe.PECompanyID  and dt.DealtypeId=pe.DealTypeId and
					pe.Deleted=0 ".$addVCFlagqry." and pe.StageId=s.RETypeId and r.RegionId=pe.RegionId order by companyname ";
				//	echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
				}
				else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}



//mail sending
    $insert_downloadlog_sql="insert into downloads_log(EmailId,dbcategory,dbtype,industry,sector,dealtype,period,targettype,companysearch,advisorsearch_legal,advisorsearch_trans,investorsearch,acquirersearch)
 values('$submitemail','RE','M&AExit','$hideindustrytext','$stagetext','$dealtypetext','$dateValue','$SPVvalue','$companysearch','$advisorsearch_legal','$advisorsearch_trans','$keyword','$acquirersearch')";
      if ($rsinsert_download = mysql_query($insert_downloadlog_sql))
      {
        //echo "<br>***".$insert_downloadlog_sql;
      }

//if((trim($submitemail)!= "") && (trim($submitpassword)!=""))
//		{
			$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM dealmembers AS dm,
													dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
													dm.EmailId='$submitemail' AND dc.Deleted =0";

			if ($totalrs = mysql_query($checkUserSql))
			{

				$cnt= mysql_num_rows($totalrs);
				//echo "<Br>mail count------------------" .$hidesearchon;
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
								//$to="sowmyakvn@gmail.com";


									$subject="Send Excel Data : RE-M&A Exits - $searchdisplay ";
									$message="<html><center><b><u> Send RE-M&A Data :$searchdisplay to - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustrytext</td></tr>
                                                                        <tr><td width=1%>Sector </td><td width=99%>$stagetext</td></tr>
									<tr><td width=1%>Deal Type </td><td width=99%>$dealtypetext</td></tr>
                                                                        <tr><td width=1%>Target Type (SPV Value)</td><td width=99%>$SPVvalue</td></tr>
									<tr><td width=1%>Period</td><td width=99%>$dateValue</td></tr>
									<tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
									<tr><td width=1%>Company</td><td width=99%>$companysearch</td></tr>
									<tr><td width=1%>Legal Advisor</td><td width=99%>$advisorsearch_legal</td></tr>
									<tr><td width=1%>Transaction Advisor</td><td width=99%>$advisorsearch_trans</td></tr>
									<tr><td width=1%>Acquirer</td><td width=99%>$acquirersearch</td></tr>
									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";

								mail($to,$subject,$message,$headers);
								//header( 'Location: http://www.ventureintelligence.in/deals/cthankyou.php' ) ;


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
	//	}


 $sql=$companysql;
//echo "<br>---" .$sql;die;
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
	echo "Portfolio Company"."\t";
	echo "PE Firm(s)"."\t";
	echo "Industry"."\t";
        echo "Sector"."\t";
        echo "Project Name"."\t";
	echo "Type"."\t";
	echo "Acquirer "."\t";
	echo "Deal Date"."\t";
	echo "Deal Amount (US$ M)"."\t";
	echo "Advisor-Company"."\t";
	echo "Advisor-Acquirer"."\t";
	echo "City"."\t";
	echo "Region"."\t";
	echo "Exit Status"."\t";
	echo "Website"."\t";
	echo "Addln Info"."\t";
	echo "Investment Details"."\t";
	echo "Link"."\t";
	echo "Estimated Returns"."\t";
	echo "More Info(Returns)"."\t";

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
         //set_time_limit(60); // HaRa
         $schema_insert = "";
         $MandAId=$row[0];


         $mandaAcquirerId=$row[4];
          //SPV
                     if($row[22]==1)
		{
			$openBracket="(";
			$closeBracket=")";
		}
		else
		{
			$openBracket="";
			$closeBracket="";
		}

          $schema_insert .= $openBracket.$row[5].$closeBracket.$sep;    //company name with brackets if SPV=1

		$AcquirerSql= "select peinv.MandAId,peinv.AcquirerId,ac.Acquirer from REmanda as peinv,REacquirers as ac
		where peinv.MandAId=$MandAId and ac.AcquirerId=peinv.AcquirerId";

		$investorSql="select peinv.MandAId,peinv.InvestorId,inv.Investor from REmanda_investors as peinv,
		REinvestors as inv where peinv.MandAId=$MandAId and inv.InvestorId=peinv.InvestorId";
	//echo "<Br>Investor".$investorSql;

	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,AdvisorType from REinvestments_advisorcompanies as advcomp,
	REadvisor_cias as cia where advcomp.PEId=$MandAId and advcomp.CIAId=cia.CIAId";

	$adacquirersql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from REinvestments_advisoracquirer as advinv,
	REadvisor_cias as cia where advinv.PEId=$MandAId and advinv.CIAId=cia.CIAId";
		//echo "<Br>".$adacquirersql;


//	echo "<Br>".$advcompanysql;

		if ($rsgetAcquirerSql = mysql_query($AcquirerSql))
		{
			While($myAcquirerrow=mysql_fetch_array($rsgetAcquirerSql, MYSQL_BOTH))
			{
				$Acquirer=$myAcquirerrow["Acquirer"];
				$AcquirerId=$myAcquirerrow["AcquirerId"];
			}
	     }

             
		if($investorrs = mysql_query($investorSql))
		 {
			 $investorString="";
			 $AddUnknowUndisclosedAtLast="";
			 $AddOtherAtLast="";
		   while($rowInvestor = mysql_fetch_array($investorrs))
			{
				$Investorname=$rowInvestor[2];
				$Investorname=strtolower($Investorname);

				$invResult=substr_count($Investorname,$searchString);
				$invResult1=substr_count($Investorname,$searchString1);
				$invResult2=substr_count($Investorname,$searchString2);

				if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
					$investorString=$investorString .", ".$rowInvestor[2];
				elseif(($invResult==1) || ($invResult1==1))
					$AddUnknowUndisclosedAtLast=$rowInvestor[2];
				elseif($invResult2==1)
					$AddOtherAtLast=$rowInvestor[2];


			}
			$investorString =substr_replace($investorString, '', 0,1);


				if($AddUnknowUndisclosedAtLast!=="")
					$investorString=$investorString .", ".$AddUnknowUndisclosedAtLast;
				if($AddOtherAtLast!="")
					$investorString=$investorString .", ".$AddOtherAtLast;
		}

		 if($advisorcompanyrs = mysql_query($advcompanysql))
		 {
			 $advisorCompanyString="";
			 while($row1 = mysql_fetch_array($advisorcompanyrs))
			{
				$advisorCompanyString=$advisorCompanyString.",".$row1[2]."(".$row1[3].")";
			}
				$advisorCompanyString=substr_replace($advisorCompanyString, '', 0,1);
		}


		 if($advisoracquirerrs = mysql_query($adacquirersql))
		 {
			 $advisorAcquirerString="";
			 while($row2 = mysql_fetch_array($advisoracquirerrs))
			{
				$advisorAcquirerString=$advisorAcquirerString.",".$row2[2]."(".$row2[3].")";
			}
				$advisorAcquirerString=substr_replace($advisorAcquirerString, '', 0,1);
		}



		//investors
			$schema_insert .= $investorString.$sep;
		//industry
		 	$schema_insert .= $row[6].$sep;
                        
                        if($row[7]!="")
                           $schema_insert .= $row[7].$sep;
                        else
                            $schema_insert .= $row[6].$sep;
		//project name

			$schema_insert .= $row[23].$sep;
		//dealtype
			$schema_insert .= $row[8].$sep;
		//Acquirer Name
			$schema_insert .= $Acquirer.$sep;
		//deal date
			$schema_insert .= $row[9].$sep;
		//deal amount
			if(($row[13]==1) && ($row[10]>=0))
				$hideamount="";
			else
				$hideamount=$row[10];
			$schema_insert .= $hideamount.$sep;
			$schema_insert .= $advisorCompanyString.$sep;
			$schema_insert .= $advisorAcquirerString.$sep;
			//city
	         $schema_insert .= $row[15].$sep;
			//region
	         $schema_insert .= $row[16].$sep;

                 
                 
                         if($row[24]=="0")
                        {$Exit_Status="Partial Exit"; }
                        elseif($row[24]=="1")
                        {$Exit_Status="Complete Exit";}
                        //Exit_Status
                        $schema_insert .= $Exit_Status.$sep;

			//website
	         $schema_insert .= $row[11].$sep;

	         //additional info
                if($row[14]==1)
                    $hidemoreinfor="";
                else
                    $hidemoreinfor=$row[12];
	         $schema_insert .= $hidemoreinfor.$sep;

			//investment deal summary
	         $schema_insert .= $row[18].$sep;
                 //link
                 $schema_insert .= $row[19].$sep;

                 /*if($row[22]>0)
				{
					$estimatedirrvalue=$row[20];
					$moreinforeturnsvalue=$row[21];
				}
				else
				{
					$estimatedirrvalue="";
					$moreinforeturnsvalue="";
				}*/
					$estimatedirrvalue=$row[20];
					$moreinforeturnsvalue=$row[21];
				$schema_insert .= $estimatedirrvalue.$sep; //EstimatedIRR
		   		$schema_insert .= $moreinforeturnsvalue.$sep; // MoreInfo Returns

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

//		}
//else
//	header( 'Location: http://www.ventureintelligence.in/pelogin.php' ) ;
mysql_close();  
?>


