<?php include_once("../globalconfig.php"); ?>
<?php
 session_save_path("/tmp");
	session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
        
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
					$hidesearchon=$_POST['txtsearchon'];
					$industry=$_POST['txthideindustryid'];
					$hideindustryvalue=$_POST['txthideindustryvalue'];
					$rangeText=$_POST['txthiderange'];
					$datevalue=$_POST['txthidedate'];

					$targetcompanysearch=$_POST['txthidecompany'];
					 $targetcompanysearch =ereg_replace("-"," ",$targetcompanysearch);

                                         
                                        $sectorsearch=$_POST['txthide_sectorsearch']; 
					//echo "<Br>***".$targetcompanysearch;

					//echo "<br>--".$targetcompanysearch;
					$advisorsearch_legal=$_POST['txthideadvisor_legal'];
					$advisorsearch_legal =ereg_replace("-"," ",$advisorsearch_legal);
					$advisorsearch_trans=$_POST['txthideadvisor_trans'];
					$advisorsearch_trans =ereg_replace("-"," ",$advisorsearch_trans);
					$acquirersearch=$_POST['txthideacquirer'];
					$dealtype=$_POST['txthidedealtype'];
					$dealtypevalue=$_POST['txthidedealtypevalue'];
					$SPVvalue=$_POST['txthideSPV'];
					//echo "<Br>*****".$SPVvalue;
                                        $searchallfield=$_POST['txthidesearchallfield'];
					$hiderangeStartValue=$_POST['txthiderangeStartValue'];
					$hiderangeEndValue=$_POST['txthiderangeEndValue'];
					$hidedateStartValue=$_POST['txthidedateStartValue'];
					$hidedateEndValue=$_POST['txthidedateEndValue'];
					$dateValue=$_POST['txthidedate'];

					//$submitemail=$_POST['txtemailid'];
					$submitpassword=$_POST['txtemailpassword'];
					//echo "<br>--".$hidesearchon;
					//echo "<Br>--**__" .$acquirersearch;

					//meracq view values
					$targetCountryId=$_POST['txttargetcountry'];
					$acquirerCountryId=$_POST['txtacuquirercountry'];


                                        if($SPVvalue ==1)
                                		$projecttypename="Entity";
					elseif($SPVvalue ==2)
                                                $projecttypename="Project / Asset";
                                        else
                                                $projecttypename="";
					$tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";


				/*echo "<br>Industry Id-----------------**".$hideindustryid;
				echo "<br>Inv type id-----------------**".$invtypevalueid;
				echo "<br>Start Range Value-----------------**".$hiderangeStartValue;
				echo "<br>End Range value-----------------**".$hiderangeEndValue;
				*/
				//echo "<br>start Date-----------------**".$hidedateStartValue;
				//echo "<br>End Date-----------------**".$dateValue;
				//echo "<br>Deal Type---**". $dealtype;

                                        $addVCFlagqry = " and pec.industry=15 ";
					if($acquirersearch!="")
					{
						$companysqlFinal="SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
						ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
						pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
						sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
						DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
						pec.website,pe.MoreInfor,pe.city,r.Region,pe.MoreInfor,pe.city,r.Region,Link
						FROM
						REmama AS pe, reindustry AS i, REcompanies AS pec,country as c,REacquirers as ac,madealtypes as md,region as r
						WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and  md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
						AND pec.PEcompanyID = pe.PECompanyID
						and ac.AcquirerId = pe.AcquirerId
						and c.CountryId=pec.countryid AND pe.Deleted =0 " .$addVCFlagqry. "
						AND r.RegionId=pe.RegionId  AND ac.AcquirerId IN ($acquirersearch) 
						order by companyname ";
					//	echo "<br> Acquirer search- ".$companysqlFinal;
					}
                                        elseif($searchallfield!=''){
                                           $companysqlFinal=" SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
						ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
						pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
						sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
						DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
						pec.website,pe.MoreInfor,pe.city,r.Region,pe.MoreInfor,pe.city,r.Region
						FROM REmama AS pe, reindustry AS i, REcompanies AS pec,country as c,REacquirers as ac,madealtypes as md,region as r
						WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
						AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 " .$addVCFlagqry. " and r.RegionId=pe.RegionId and
						c.CountryId=pec.countryId
						 and ac.AcquirerId=pe.AcquirerId AND  ( pec.companyname LIKE '%$searchallfield%' OR sector_business LIKE '%$searchallfield%' Or ac.Acquirer LIKE '%$searchallfield%'
                                                OR MoreInfor LIKE '%$searchallfield%' ) order by companyname";
//                                           echo $companysqlFinal;
//                                           exit;
                                        }
					elseif($advisorsearch_legal!="")
					{

						$companysqlFinal="(SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
						ac.countryid,pe.Asset,pe.MADealTypeId,pec.PEcompanyId,
						pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
						pec.sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
						DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
						pec.website,pe.MoreInfor,pec.city,r.Region,
						cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,Link
						FROM REmama AS pe, reindustry AS i, REcompanies AS pec,country as c,REacquirers as ac,madealtypes as md,
						REadvisor_cias AS cia,REmama_advisoracquirer AS adac, region as r
						where md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
						AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 " .$addVCFlagqry. " and r.RegionId=pe.RegionId and
						c.CountryId=pec.countryId    and AdvisorType='L'
						 and ac.AcquirerId=pe.AcquirerId and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and cia.cianame LIKE '%$advisorsearch_legal%')
						UNION
						(SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
						ac.countryid,pe.Asset,pe.MADealTypeId,pec.PEcompanyId,
						pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
						pec.sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
						DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
						pec.website,pe.MoreInfor,pec.city,r.Region,
						cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,Link
						FROM REmama AS pe, reindustry AS i, REcompanies AS pec,country as c,REacquirers as ac,madealtypes as md,
					        REadvisor_cias AS cia,REmama_advisorcompanies AS adac,region as r
						where DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and  md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
						AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 " .$addVCFlagqry. " and r.RegionId=pe.RegionId and
						c.CountryId=pec.countryId  and AdvisorType='L'
						 and ac.AcquirerId=pe.AcquirerId and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and cia.cianame LIKE '%$advisorsearch_legal%')
						order by Target_Company";
					//				echo "<br> Advisor  search- ".$companysqlFinal;
					}
                                       elseif($advisorsearch_trans!="")
					{

						$companysqlFinal="(SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
						ac.countryid,pe.Asset,pe.MADealTypeId,pec.PEcompanyId,
						pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
						pec.sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
						DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
						pec.website,pe.MoreInfor,pec.city,r.Region,
						cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,Link
						FROM REmama AS pe, reindustry AS i, REcompanies AS pec,country as c,REacquirers as ac,madealtypes as md,
						REadvisor_cias AS cia,REmama_advisoracquirer AS adac, region as r
						where md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
						AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 " .$addVCFlagqry. " and r.RegionId=pe.RegionId and
						c.CountryId=pec.countryId and AdvisorType='T'
						 and ac.AcquirerId=pe.AcquirerId and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and cia.cianame LIKE '%$advisorsearch_trans%')
						UNION
						(SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
						ac.countryid,pe.Asset,pe.MADealTypeId,pec.PEcompanyId,
						pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
						pec.sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
						DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
						pec.website,pe.MoreInfor,pec.city,r.Region,
						cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,Link
						FROM REmama AS pe, reindustry AS i, REcompanies AS pec,country as c,REacquirers as ac,madealtypes as md,
						REadvisor_cias AS cia,REmama_advisorcompanies AS adac,region as r
						where DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and  md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
						AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 " .$addVCFlagqry. " and r.RegionId=pe.RegionId and
						c.CountryId=pec.countryId   and AdvisorType='T'
						 and ac.AcquirerId=pe.AcquirerId and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and cia.cianame LIKE '%$advisorsearch_trans%')
						order by Target_Company";
									echo "<br> Advisor  search- ".$companysqlFinal;
					}
					elseif (($acquirersearch == "") && ($targetcompanysearch == "") && ($advisorsearch=="") && ($hideindustry =="--") && ($dealtype == "--") && ($SPVvalue=="--") && ($hiderangeStartValue == "") && ($hiderangeEndValue == "")  && ($dateValue="---to---") && ($acquirerCountryId=="--") && ($targetCountryId=="--"))
				{

						 $companysqlFinal="SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
						ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
						pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
						sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
						DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
						pec.website,pe.MoreInfor,pe.city,r.Region,pe.MoreInfor,pe.city,r.Region
						FROM REmama AS pe, reindustry AS i, REcompanies AS pec,country as c,REacquirers as ac,madealtypes as md,region as r
						WHERE md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
						AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 " .$addVCFlagqry. " and r.RegionId=pe.RegionId and
						c.CountryId=pec.countryId
						 and ac.AcquirerId=pe.AcquirerId order by companyname";


				//echo "<br>3 Query for All records" .$companysqlFinal;
					}
				elseif (trim($targetcompanysearch != ""))
					{
						$companysqlFinal="SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
						ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
						pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
						sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
						DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
						pec.website,pe.MoreInfor,pe.city,r.Region,pe.MoreInfor,pe.city,r.Region
						FROM
						REmama AS pe, reindustry AS i, REcompanies AS pec,country as c,REacquirers as ac,madealtypes as md,region as r
						WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and  md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
						AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
						and c.CountryId=pec.countryid
						AND pe.Deleted =0 " .$addVCFlagqry. " and r.RegionId=pe.RegionId AND pec.PECompanyId IN ($targetcompanysearch) 
						order by companyname";

						$fetchRecords=true;
						$fetchAggregate==false;
					//	echo "<br>Query for company search";
				//	echo "<Br>***".$targetcompanysearch;
				// echo "<br> Company search--" .$companysqlFinal;
					}
				elseif (trim($sectorsearch != ""))
					{
                                    
                                         $sectorsearchArray = explode(",", str_replace("'","",$sectorsearch)); 
                                            $sector_sql = array(); // Stop errors when $words is empty

                                            foreach($sectorsearchArray as $word){
                                                $word = trim($word);
//                                                $sector_sql[] = " pec.sector_business LIKE '$word%' ";
                                                
                                                $sector_sql[] = " pec.sector_business = '$word' ";
                                                $sector_sql[] = " pec.sector_business LIKE '$word(%' ";
                                                $sector_sql[] = " pec.sector_business LIKE '$word (%' ";
                                            }
                                            $sector_filter = implode(" OR ", $sector_sql);
                                            
						$companysqlFinal="SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
						ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
						pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
						sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
						DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
						pec.website,pe.MoreInfor,pe.city,r.Region,pe.MoreInfor,pe.city,r.Region
						FROM
						REmama AS pe, reindustry AS i, REcompanies AS pec,country as c,REacquirers as ac,madealtypes as md,region as r
						WHERE DealDate between '" .$hidedateStartValue. "' and '" .$hidedateEndValue. "' and  md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
						AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
						and c.CountryId=pec.countryid
						AND pe.Deleted =0 " .$addVCFlagqry. " and r.RegionId=pe.RegionId AND  ($sector_filter) 
						order by companyname";

						$fetchRecords=true;
						$fetchAggregate==false;
					//	echo "<br>Query for company search";
				//	echo "<Br>***".$targetcompanysearch;
				// echo "<br> Company search--" .$companysqlFinal;
					}
				elseif (count($industry) > 0 || ($dealtype != "--") || ($SPVvalue > 0) || ($hiderangeStartValue !="--") || ($hiderangeEndValue != "--") || (($hidedateStartValue != "--") && ($hidedateEndValue!="--")) || ($targetCountryId!="--") || ($acquirerCountryId!="--"))
					{
						//echo "<br>-________________";
						$companysql = "SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
						ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
						pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
						sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
						DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
						pec.website,pe.MoreInfor,pe.city,r.Region,pe.MoreInfor,pe.city,r.Region,Link
						FROM REmama AS pe, reindustry AS i, REcompanies AS pec,country as c,REacquirers as ac,madealtypes as md,region as r
						where md.MADealTypeId=pe.MADealTypeId and ";

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
						if ($dealtype!= "--" && $dealtype!= "")
						{
							$wheredealtype = " pe.MADealTypeId =" .$dealtype;
						}
						$whereSPVCompanies="";
						//echo "<BR>%%%%%".$SPVvalue;
						if($SPVvalue==1)
							       $whereSPVCompanies=" pe.Asset=0";
						        elseif($SPVvalue==2)
                                                               $whereSPVCompanies=" pe.Asset=1";
                                               // echo "<Br>^^^^^^^".$whereSPVCompanies;
						$whererange ="";


						if (($hiderangeStartValue!= "--") && ($hiderangeEndValue != ""))
						{

							if($hiderangeStartValue == $hiderangeEndValue)
							{
								$whererange = " pe.Amount = ".$hiderangeStartValue ."";
							}
							elseif($hiderangeStartValue < $hiderangeEndValue)
							{
								$whererange = " pe.Amount between  ".$hiderangeStartValue ." and ". $hiderangeEndValue ."";
							}

							//echo "<br>-- ".$whererange;

						}
						if($targetCountryId !="--")
						{
							$wheretargetCountry=" pec.countryId='" .$targetCountryId. "' ";
						}
						if($acquirerCountryId!="--")
						{
							$whereacquirerCountry=" ac.countryId='" .$acquirerCountryId. "' and c.countryid=ac.countryid";
						}

						//if( ($hidedateStartValue !="------01") && ($hidedateEndValue != "------01"))
						if($datevalue!="---to---")
						{
							$wheredates= " DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
						}
						else
						{
							$wheredates="";
						}

						if ($whereind != "")
						{
							$companysql=$companysql . $whereind ." and ";
							$bool=true;
						}
						if (($wheredealtype != ""))
						{
							$companysql=$companysql . $wheredealtype . " and " ;
							$bool=true;
						}
						if (($whereSPVCompanies != "") )
						        {
							        $companysql=$companysql .$whereSPVCompanies . " and ";
								$bool=true;
					        	}
						if (($whererange != "") )
						{
							$companysql=$companysql .$whererange . " and ";
							$bool=true;
						}
						if($wheretargetCountry!="")
						{
							$companysql=$companysql .$wheretargetCountry . " and ";
						}
					//	echo "<br>-###" .$wheredates;
						if($wheredates !== "")
						{
						//	echo "<bR>----------".$wheredates;
							$companysql = $companysql . $wheredates ." and ";
							$bool=true;
						}
						$companysqlFinal = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
						and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId
						and r.RegionId=pe.RegionId and pe.Deleted=0 " .$addVCFlagqry. "  order by companyname ";
						if($whereacquirerCountry!="")
						{
							$companysql=$companysql .$whereacquirerCountry. " and ";
						//	echo "<br>".$companysql;
							$companysqlFinal = $companysql . " i.industryid=pec.industry
							and  pec.PEcompanyID = pe.PECompanyID
							and  ac.AcquirerId = pe.AcquirerId
							and r.RegionId=pe.RegionId and pe.Deleted=0  " .$addVCFlagqry. " order by companyname ";
						}


						$fetchRecords=true;
						$fetchAggregate==false;
						//echo "<br><br>WHERE CLAUSE SQL---" .$companysqlFinal;
					}
					else
					{
						//echo "<br> INVALID DATES GIVEN ";
						$fetchRecords=false;
						$fetchAggregate==false;
			}

//mail sending
$insert_downloadlog_sql="insert into downloads_log(EmailId,dbcategory,dbtype,industry,dealtype,period,targettype,companysearch,advisorsearch_legal,advisorsearch_trans,acquirersearch,targetcountry,acquirercountry)
 values('$submitemail','RE','MAMA','$hideindustryvalue','$dealtypevalue','$datevalue','$projecttypename','$companysearch','$advisorsearch_legal','$advisorsearch_trans','$acquirersearch','$targetCountry','$acquirerCountry')";
      if ($rsinsert_download = mysql_query($insert_downloadlog_sql))
      {
        //echo "<br>***".$insert_downloadlog_sql;
      }
                        $checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM RElogin_members AS dm,
			dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
			dm.EmailId='$submitemail' AND dc.Deleted =0";

			if ($totalrs = mysql_query($checkUserSql))
			{

				$cnt= mysql_num_rows($totalrs);

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

									$searchdisplay="Real Estate";


								if($hidesearchon==4)
								{
									$searchdisplay="";
									$subject="Send Excel Data : Mergers & Acquistion - $searchdisplay ";
									$message="<html><center><b><u> Send Mergers & Acquistion Data :$searchdisplay to - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustryvalue</td></tr>
									<tr><td width=1%>Deal Type </td><td width=99%>$dealtypevalue</td></tr>
									<tr><td width=1%>Project Type </td><td width=99%>$projecttypename</td></tr>
         								<tr><td width=1%>Period</td><td width=99%>$datevalue</td></tr>
									<tr><td width=1%>Target Company</td><td width=99%>$companysearch</td></tr>
									<tr><td width=1%>Advisor</td><td width=99%>$advisorsearch_legal</td></tr>
									<tr><td width=1%>Advisor</td><td width=99%>$advisorsearch_trans</td></tr>
									<tr><td width=1%>Acquirer</td><td width=99%>$acquirersearch</td></tr>
									<tr><td width=1%>Target Country</td><td width=99%>$targetCountry</td></tr>
									<tr><td width=1%>Acquirer Country</td><td width=99%>$acquirerCountry</td></tr>
									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";
								}
								//mail($to,$subject,$message,$headers);
								//header( 'Location: https://www.ventureintelligence.com/deals/cthankyou.php' ) ;


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


//export
		$sql=$companysqlFinal;
//		echo "<br>---" .$sql;
//                exit;
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
		 header("Content-Disposition: attachment; filename=REmerger_acq_data.$file_ending");
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
		 for ($i =9; $i < mysql_num_fields($result)-6; $i++)
		 {
			if( mysql_field_name($result,$i) == 'Amount' ) {
		 		echo mysql_field_name($result,$i) . " (US\$M)\t";
		 	} else {
		 		echo mysql_field_name($result,$i) . "\t";
		 	}
		 }
			//echo "Deal Date"."\t";
			//echo "Type"."\t";
			echo "Advisor_Target"."\t";
			echo "Advisor_Acquirer"."\t";
			echo "City"."\t";
			echo "Region"."\t";
			echo "Country_Target"."\t";
			echo "City_Acquirer"."\t";
			echo "Country_Acquirer"."\t";
                        echo "Link"."\t";
			//echo "Website_Target"."\t";
		//	echo "More Information"."\t";
		 print("\n");
		 /*print("\n");*/
		 //end of printing column names



		 //start while loop to get data
		 /*
		 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
		 */

		 while($row = mysql_fetch_row($result))
			 {

				$searchString="Undisclosed";
				$searchString=strtolower($searchString);
				$searchStringDisplay="Undisclosed";

				$searchString1="Unknown";
				$searchString1=strtolower($searchString1);
				$searchString1Display="Unknown";

				$searchString2="Others";
				$searchString2=strtolower($searchString2);
				$searchString2Display="Others";


				$searchString4="PE Firm(s)";
				$searchString4ForDisplay="PE Firm(s)";
				$searchString4=strtolower($searchString4);

				 //set_time_limit(60); // HaRa
				 $schema_insert = "";
				 $MAMAId=$row[2];
				$AcquirerId=$row[4];
				$PECompanyId=$row[0];

				$companyName=$row[9];
				$companyName=strtolower($companyName);
				$compResult=substr_count($companyName,$searchString);
				$compResult1=substr_count($companyName,$searchString1);

				$acquirerName=$row[10];
				$acquirerName=strtolower($acquirerName);
				$compResultAcquirer=substr_count($acquirerName,$searchString4);
				$compResultAcquirer1=substr_count($acquirerName,$searchString);

				if(($compResult==0) && ($compResult1==0))
					$comp=$row[9];
				else
					$comp=$searchStringDisplay;

				 if($row[6]==1)
					$schema_insert .= "("."$comp".")".$sep;
				 else
					$schema_insert .= "$comp".$sep;


				if(($compResultAcquirer==0) && ($compResultAcquirer1==0))
					$acquirerDisplay=$row[10];
				elseif($compResultAcquirer==1)
					$acquirerDisplay=$searchString4ForDisplay;
				elseif($compResultAcquirer1==1)
					$acquirerDisplay=$searchStringDisplay;

				$schema_insert .= $acquirerDisplay.$sep;

				 for($j=11; $j<mysql_num_fields($result)-6;$j++)
				 {
					 if(!isset($row[$j]))
						 $schema_insert .= "NULL".$sep;
					 elseif ($row[$j] != "")
					 {
						if(($j==13) || ($j==14))
						  {
							if($row[$j]<=0)
								{$schema_insert .= "".$sep;}
							else
								$schema_insert .= "$row[$j]".$sep;
						 }
						else
							$schema_insert .= "$row[$j]".$sep;
					  }

					 else
						 $schema_insert .= "".$sep;
				 }
			  //   $schema_insert .= "AAAA".$sep;
			   //    $schema_insert = str_replace($sep."$", "", $schema_insert);

					//Deal Date
					// $schema_insert .= $row[15].$sep;
					 //Type
					// $schema_insert .= $row[16].$sep;

					 $mama_advisorTargetSql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame,AdvisorType from REmama_advisorcompanies as advcomp,
				REadvisor_cias as cia where advcomp.MAMAId=$MAMAId and advcomp.CIAId=cia.CIAId";
				if($resultTarget = mysql_query($mama_advisorTargetSql))
						 {
							 $targetString="";
						   while($rowTarget = mysql_fetch_array($resultTarget))
							{
								$targetString=$targetString.",".$rowTarget[2]."(".$rowTarget[3].")";
							}
								$targetString=substr_replace($targetString, '', 0,1);
						}
						$schema_insert .= $targetString.$sep;

				 $mama_advisoracquirerSql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame,AdvisorType from REmama_advisoracquirer as advcomp,
				REadvisor_cias as cia where advcomp.MAMAId=$MAMAId and advcomp.CIAId=cia.CIAId";
				 if($result1 = mysql_query($mama_advisoracquirerSql))
				 {
					 $acquirerString="";
				   while($row1 = mysql_fetch_array($result1))
					{
						$acquirerString=$acquirerString.",".$row1[2]."(".$row1[3].")";
					}
						$acquirerString=substr_replace($acquirerString, '', 0,1);
				}
						$schema_insert .= $acquirerString.$sep;


					 $targetCityCountrySql="select pe.city,pe.CountryId,co.Country from
				  REcompanies as pe,country as co where pe.PECompanyId=$PECompanyId and co.CountryId=pe.CountryId";
				 // echo "<bR>---" .$targetCityCountrySql;
				  if($targetrs=mysql_query($targetCityCountrySql))
				  {
					while($targetrow=mysql_fetch_array($targetrs))
					{
						//$targetCity=$targetrow[0];
						$targetCity=$row[19];
						$targetCountry=$targetrow[2];
					}
				  }
					//city as part of the deal (NOT TARGET CITY)
					$schema_insert .= $targetCity.$sep;
					//Region
				   $schema_insert .= $row[20].$sep;

					$schema_insert .= $targetCountry.$sep;

				  $acquirerCityCountrySql="select ac.CityId,ac.CountryId,co.Country from
				  REacquirers as ac,country as co where ac.AcquirerId=$AcquirerId and co.CountryId=ac.CountryId";
				  if($acquirerrs=mysql_query($acquirerCityCountrySql))
				  {
					while($acquirerrow=mysql_fetch_array($acquirerrs))
					{
						$acquirerCity=$acquirerrow[0];
						$acquirerCountry=$acquirerrow[2];
					}
				  }
						$schema_insert .= $acquirerCity.$sep;
						$schema_insert .= $acquirerCountry.$sep;
                                                $schema_insert .= $row[24].$sep;
					// $schema_insert .= $row[17].$sep;
					// $schema_insert .= $row[18].$sep;

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
//	header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;
                          mysql_close();  
?>


