<?php include_once("../globalconfig.php"); ?>
<?php
 session_save_path("/tmp");
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
			//	global $LoginMessage;
				$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";

					$submitemail=$_POST['txthideemail'];
					//VCFLAG VALUE

					$searchtitle=$_POST['txttitle'];

					//variable that differentiates, PE/VC/RealEstate
					$hidesearchon=$_POST['txtsearchon'];
                    $hide_pms=$_POST['txthide_pms'];

					$industry=$_POST['txthideindustryid'];
					$hideindustrytext=$_POST['txthideindustry'];

					$dealtypetext=$_POST['txthidedealtype'];
					$dealtype=$_POST['txthidedealtypeid'];
					$invtypevalue=$_POST['txthideinvtype'];
					$invType=$_POST['txthideinvtypeid'];
					$exitstatusvalue=$_POST['txthideexitstatusvalue'];
					$hidedateStartValue=$_POST['txthidedateStartValue'];
					$hidedateEndValue=$_POST['txthidedateEndValue'];
					$dateValue=$_POST['txthidedate'];
                                        
                                        $hidetxtfrm=$_POST['txthideReturnMultipleFrm'];
                                        $hidetxtto=$_POST['txthideReturnMultipleTo'];

					$keyword=$_POST['txthideinvestor'];
					$investorString=$_POST['txthideInvestorString'];
					if(($investorString!=="+") && ($investorString!==""))
					{	$splitStringInv=explode("+", $investorString);
						$splitString1Inv=$splitStringInv[0];
						$splitString2Inv=$splitStringInv[1];
						if($splitString2Inv!="")
							$keyword=$splitString1Inv. " " .$splitString2Inv;
						else
							$keyword=$splitString1Inv;
					}

					$companysearch=$_POST['txthidecompany'];
					$companyString=$_POST['txthideCompanyString'];
					if(($companyString!=="+") && ($companyString!==""))
					{	$splitStringComp=explode("+", $companyString);
						$splitString1Comp=$splitStringComp[0];
						$splitString2Comp=$splitStringComp[1];
						if($splitString2Comp!="")
							$companysearch=$splitString1Comp. " " .$splitString2Comp;
						else
							$companysearch=$splitString1Comp;
					}

					$acquirersearch=$_POST['txthideacquirer'];
					$advisorsearch_legal=$_POST['txthideadvisor_legal'];
					$advisorsearch_legal =ereg_replace("_"," ",$advisorsearch_legal);
					$advisorsearch_trans=$_POST['txthideadvisor_trans'];
					$advisorsearch_trans =ereg_replace("_"," ",$advisorsearch_trans);
					$searchallfield=$_POST['txthidesearchallfield'];
					$searchallfield =ereg_replace("-"," ",$searchallfield);

                                        $addhide_pms_qry=" and dt.hide_for_exit=".$hide_pms;

					$submitemail=$_POST['txthideemail'];

					$tsjtitle="� TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
                                if($searchtitle==0)
                                {
                                    if($compId==$companyIdDel)
                                    {
                                      $addDelind = " and (pec.industry=9 or pec.industry=24)";
                                    }
                                    if($compId==$companyIdSGR)
                                    {
                                      $addDelind = " and (pec.industry=3 or pec.industry=24)";
                                    }
                                    if($compId==$companyIdVA)
                                    {
                                      $addDelind = " and (pec.industry=1 or pec.industry=3)";
                                    }
                                }
				if($searchtitle==0)
				{
					$addVCFlagqry = "" ;
					//$searchTitle = "List of PE Exits - M&A ";
				}
				elseif($searchtitle==1)
				{
					$addVCFlagqry = " and VCFlag=1 ";
					//$searchTitle = "List of VC Exits - M&A ";
				}

			if (($keyword == "") && ($companysearch=="") &&  ($searchallfield=="")  && ($acquirersearch=="") && ($advisorsearch_legal=="") && ($advisorsearch_trans=="")&& ($industry =="--")  && ($dealtype=="--") && ($invType == "--") && ($exitstatusvalue=="--") &&($hidedateStartValue == "------01") && ($hidedateEndValue == "------01"))
				{	
                            
                                    $companysql = "SELECT pec.companyname, investor.Investor, it.displayName,pe.ExitStatus, i.industry, pec.sector_business, dt.DealType TYPE , DATE_FORMAT
                                            (pe.DealDate,'%M-%Y') as MA_Date, pe.DealAmount MA_Amount, peinv.amount, DATE_FORMAT( peinv.dates, '%M-%Y' ) AS Inv_Date, peinv.stakepercentage Inv_Stake, pe.DealAmount Actual_Exit_Value, ( pe.DealAmount / 
                                            pe.Company_Valuation) *100 as Stake_Divested , pe.hideamount,pe.MandAId, 
                                            pec.website,pe.MoreInfor,pe.hidemoreinfor,pe.InvestmentDeals,mandainv.MultipleReturn,pe.Link, pe.Valuation,pe.FinLink 
                                            ,pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple
                                            FROM manda AS pe
                                            JOIN pecompanies AS pec on pec.PEcompanyID = pe.PECompanyID
                                            JOIN industry AS i on i.industryid = pec.industry
                                            JOIN dealtypes as dt on dt.DealTypeId = pe.DealTypeId
                                            JOIN investortype as it on it.InvestorType = pe.InvestorType
                                            JOIN manda_investors as mandainv on mandainv.MandAId=pe.MandAId
                                            JOIN peinvestors as investor on investor.InvestorId=mandainv.InvestorId
                                            LEFT JOIN peinvestments_investors as pe_inv on pe_inv.InvestorId = mandainv.InvestorId
                                            LEFT JOIN peinvestments as peinv on peinv.PEId = pe_inv.PEId and peinv.PECompanyId = pe.PECompanyId where pe.Deleted=0 " .$addVCFlagqry .$addhide_pms_qry .$addDelind.
                                             " group by pe.MandAId order by companyname";
//                                                 
//                                        echo "<br>3 Query for All records" .$companysql;
//                                        exit;
				}
                                elseif ($companysearch != "")
                                {
					$companysql="SELECT pec.companyname, investor.Investor, it.displayName,pe.ExitStatus, i.industry, pec.sector_business, dt.DealType TYPE , DATE_FORMAT
                                            (pe.DealDate,'%M-%Y') as MA_Date, pe.DealAmount MA_Amount, peinv.amount, DATE_FORMAT( peinv.dates, '%M-%Y' ) AS Inv_Date, peinv.stakepercentage Inv_Stake, pe.DealAmount Actual_Exit_Value, ( pe.DealAmount / 
                                            pe.Company_Valuation) *100 as Stake_Divested , pe.hideamount,pe.MandAId, 
                                            pec.website,pe.MoreInfor,pe.hidemoreinfor,pe.InvestmentDeals,mandainv.MultipleReturn,pe.Link, pe.Valuation,pe.FinLink 
                                            ,pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple
                                            FROM manda AS pe
                                            JOIN pecompanies AS pec on pec.PEcompanyID = pe.PECompanyID
                                            JOIN industry AS i on i.industryid = pec.industry
                                            JOIN dealtypes as dt on dt.DealTypeId = pe.DealTypeId
                                            JOIN investortype as it on it.InvestorType = pe.InvestorType
                                            JOIN manda_investors as mandainv on mandainv.MandAId=pe.MandAId
                                            JOIN peinvestors as investor on investor.InvestorId=mandainv.InvestorId
                                            LEFT JOIN peinvestments_investors as pe_inv on pe_inv.InvestorId = mandainv.InvestorId
                                            LEFT JOIN peinvestments as peinv on peinv.PEId = pe_inv.PEId and peinv.PECompanyId = pe.PECompanyId where pe.Deleted=0 " .$addVCFlagqry.$addhide_pms_qry.
						" AND ( pec.companyname LIKE '%$companysearch%'
						OR pec.sector_business LIKE '%$companysearch%')
             					 group by pe.MandAId order by companyname";
                                            //	echo "<br>Query for company search";
                                            //	 echo "<br> Company search--" .$companysql;
                                    }
                                    elseif($keyword!="")
                                    {
                                        $companysql="SELECT pec.companyname, investor.Investor, it.displayName,pe.ExitStatus, i.industry, pec.sector_business, dt.DealType TYPE , DATE_FORMAT
                                            (pe.DealDate,'%M-%Y') as MA_Date, pe.DealAmount MA_Amount, peinv.amount, DATE_FORMAT( peinv.dates, '%M-%Y' ) AS Inv_Date, peinv.stakepercentage Inv_Stake, pe.DealAmount Actual_Exit_Value, ( pe.DealAmount / 
                                            pe.Company_Valuation) *100 as Stake_Divested , pe.hideamount,pe.MandAId, 
                                            pec.website,pe.MoreInfor,pe.hidemoreinfor,pe.InvestmentDeals,mandainv.MultipleReturn,pe.Link, pe.Valuation,pe.FinLink 
                                            ,pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple
                                        FROM manda AS pe
                                        JOIN pecompanies AS pec on pec.PEcompanyID = pe.PECompanyID
                                        JOIN industry AS i on i.industryid = pec.industry
                                        JOIN dealtypes as dt on dt.DealTypeId = pe.DealTypeId
                                        JOIN investortype as it on it.InvestorType = pe.InvestorType
                                        JOIN manda_investors as mandainv on mandainv.MandAId=pe.MandAId
                                        JOIN peinvestors as investor on investor.InvestorId=mandainv.InvestorId
                                        LEFT JOIN peinvestments_investors as pe_inv on pe_inv.InvestorId = mandainv.InvestorId
                                        LEFT JOIN peinvestments as peinv on peinv.PEId = pe_inv.PEId and peinv.PECompanyId = pe.PECompanyId where pe.Deleted=0 " .$addVCFlagqry.$addhide_pms_qry.
                                            " AND investor.Investor like '%$keyword%' group by pe.MandAId order by companyname";


                                    //echo "<br> Investor search- ".$companysql;
                                    }

                                    elseif($acquirersearch!="")
                                    {
                                    $companysql="SELECT pec.companyname, investor.Investor, it.displayName,pe.ExitStatus, i.industry, pec.sector_business, dt.DealType TYPE , DATE_FORMAT
                                            (pe.DealDate,'%M-%Y') as MA_Date, pe.DealAmount MA_Amount, peinv.amount, DATE_FORMAT( peinv.dates, '%M-%Y' ) AS Inv_Date, peinv.stakepercentage Inv_Stake, pe.DealAmount Actual_Exit_Value, ( pe.DealAmount / 
                                            pe.Company_Valuation) *100 as Stake_Divested , pe.hideamount,pe.MandAId, 
                                            pec.website,pe.MoreInfor,pe.hidemoreinfor,pe.InvestmentDeals,mandainv.MultipleReturn,pe.Link, pe.Valuation,pe.FinLink 
                                            ,pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple
                                        FROM manda AS pe
                                        JOIN pecompanies AS pec on pec.PEcompanyID = pe.PECompanyID
                                        JOIN industry AS i on i.industryid = pec.industry
                                        JOIN dealtypes as dt on dt.DealTypeId = pe.DealTypeId
                                        JOIN investortype as it on it.InvestorType = pe.InvestorType
                                        JOIN acquirers as acq on acq.AcquirerId = pe.AcquirerId
                                        JOIN manda_investors as mandainv on mandainv.MandAId=pe.MandAId
                                        JOIN peinvestors as investor on investor.InvestorId=mandainv.InvestorId
                                        LEFT JOIN peinvestments_investors as pe_inv on pe_inv.InvestorId = mandainv.InvestorId
                                        LEFT JOIN peinvestments as peinv on peinv.PEId = pe_inv.PEId and peinv.PECompanyId = pe.PECompanyId
                                        where DealDate between '2014-2-01' and '2015-2-01' and pe.Deleted=0" .$addVCFlagqry.$addhide_pms_qry.
                                                    " AND acq.Acquirer LIKE '%$acquirersearch%' group by pe.MandAId order by companyname";

                            //	echo "<Br>Acquirer search--" .$companysql;
                                    }
				elseif ($searchallfield != "")
				{
                                    $companysql="SELECT pec.companyname, investor.Investor, it.displayName,pe.ExitStatus, i.industry, pec.sector_business, dt.DealType TYPE , DATE_FORMAT
                                            (pe.DealDate,'%M-%Y') as MA_Date, pe.DealAmount MA_Amount, peinv.amount, DATE_FORMAT( peinv.dates, '%M-%Y' ) AS Inv_Date, peinv.stakepercentage Inv_Stake, pe.DealAmount Actual_Exit_Value, ( pe.DealAmount / 
                                            pe.Company_Valuation) *100 as Stake_Divested , pe.hideamount,pe.MandAId, 
                                            pec.website,pe.MoreInfor,pe.hidemoreinfor,pe.InvestmentDeals,mandainv.MultipleReturn,pe.Link, pe.Valuation,pe.FinLink 
                                            ,pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple
                                        FROM manda AS pe
                                        JOIN pecompanies AS pec on pec.PEcompanyID = pe.PECompanyID
                                        JOIN industry AS i on i.industryid = pec.industry
                                        JOIN dealtypes as dt on dt.DealTypeId = pe.DealTypeId
                                        JOIN investortype as it on it.InvestorType = pe.InvestorType
                                        JOIN manda_investors as mandainv on mandainv.MandAId=pe.MandAId
                                        JOIN peinvestors as investor on investor.InvestorId=mandainv.InvestorId
                                        LEFT JOIN peinvestments_investors as pe_inv on pe_inv.InvestorId = mandainv.InvestorId
                                        LEFT JOIN peinvestments as peinv on peinv.PEId = pe_inv.PEId and peinv.PECompanyId = pe.PECompanyId where pe.Deleted=0 " .$addVCFlagqry.$addhide_pms_qry.
                                                " AND ( pec.companyname LIKE '%$searchallfield%'
						OR pec.sector_business LIKE '%$searchallfield%'  or  pe.MoreInfoReturns LIKE '%$searchallfield%') group by pe.MandAId order by companyname";
				//	echo "<br>Query for company search";
				//	 echo "<br> SEARCH FIELD search--" .$companysql;
                                }
				elseif($advisorsearch_legal!="")
                                {
                                    $companysql="(SELECT co.companyname, investor.Investor, itype.displayName,ExitStatus, ind.industry Industry, co.sector_business Sector_Business_Desc, dt.DealType
                                   TYPE , acq.Acquirer, DATE_FORMAT(ma.DealDate,'%M-%Y') as  MA_Date, ma.DealAmount MA_Amount, sum( inv.amount ) Inv_Amt,
                                    DATE_FORMAT( inv.dates, '%M-%Y' ) AS Inv_Date, inv.stakepercentage Inv_Stake, ma.DealAmount Actual_Exit_Value,
                                   ( ma.DealAmount / ma.Company_Valuation) *100 as Stake_Divested , ma.hideamount ,ma.MandAId,
                                   co.website,ma.MoreInfor,ma.hidemoreinfor,ma.InvestmentDeals,minvestor.MultipleReturn, ma.Link,
                                    ma.Valuation,ma.FinLink ,ma.Company_Valuation,ma.Revenue_Multiple,ma.EBITDA_Multiple,ma.PAT_Multiple
                                    from FROM pecompanies co, peinvestments inv, peinvestors investor,
                                    peinvestments_investors invinv, manda ma, manda_investors minvestor,
                                    acquirers acq, investortype itype, industry ind, dealtypes dt,advisor_cias AS cia,
                                    peinvestments_advisoracquirer AS adac
                                    WHERE co.PECompanyId = inv.PECompanyId
                                    AND co.PECompanyId = ma.PECompanyId
                                    AND minvestor.MandAId = ma.MandAId
                                    AND minvestor.InvestorId = investor.InvestorId
                                    AND invinv.PEId = inv.PEId
                                    AND minvestor.InvestorId = invinv.InvestorId
                                    AND acq.AcquirerId = ma.AcquirerId
                                    AND itype.InvestorType = inv.InvestorType
                                    AND ind.industryid = co.industry
                                    AND ma.DealTypeId = dt.DealTypeId  and minvestor.MandAId=ma.MandAId
                                    AND ma.Deleted=0 and co.industry != 15 " .$addVCFlagqry.$addhide_pms_qry.
                                    " AND AdvisorType='L'  and adac.CIAId=cia.CIAID
                                    AND adac.PEId=ma.MandAId and cia.cianame LIKE '%$advisorsearch_legal%')
                                    UNION
                                    (SELECT co.companyname, investor.Investor, itype.displayName,ExitStatus, ind.industry Industry, co.sector_business Sector_Business_Desc, dt.DealType
                                    TYPE , acq.Acquirer, DATE_FORMAT(ma.DealDate,'%M-%Y') as  MA_Date, ma.DealAmount MA_Amount, sum( inv.amount ) Inv_Amt,DATE_FORMAT( inv.dates, '%M-%Y' ) AS Inv_Date, inv.stakepercentage Inv_Stake, ma.DealAmount Actual_Exit_Value,
                                    ( ma.DealAmount / ma.Company_Valuation) *100 as Stake_Divested, ma.hideamount ,ma.MandAId,
                                    co.website,ma.MoreInfor,ma.hidemoreinfor,ma.InvestmentDeals,minvestor.MultipleReturn,ma.Link,
                                    ma.Valuation,ma.FinLink ,ma.Company_Valuation,ma.Revenue_Multiple,ma.EBITDA_Multiple,ma.PAT_Multiple
                                    from FROM pecompanies co, peinvestments inv, peinvestors investor,
                                    peinvestments_investors invinv, manda ma, manda_investors minvestor,
                                    acquirers acq, investortype itype, industry ind, dealtypes dt,advisor_cias AS cia,
                                    peinvestments_advisorcompanies AS adcomp
                                     WHERE co.PECompanyId = inv.PECompanyId
                                    AND co.PECompanyId = ma.PECompanyId
                                    AND minvestor.MandAId = ma.MandAId
                                    AND minvestor.InvestorId = investor.InvestorId
                                    AND invinv.PEId = inv.PEId
                                    AND minvestor.InvestorId = invinv.InvestorId
                                    AND acq.AcquirerId = ma.AcquirerId
                                    AND itype.InvestorType = inv.InvestorType
                                    AND ind.industryid = co.industry
                                    AND ma.DealTypeId = dt.DealTypeId and minvestor.MandAId=ma.MandAId
                                    AND ma.Deleted=0 and co.industry != 15 " .$addVCFlagqry.$addhide_pms_qry.
                                    " AND AdvisorType='L'  and adcomp.CIAId=cia.CIAID
                                    AND adcomp.PEId=ma.MandAId and cia.cianame LIKE '%$advisorsearch_legal%')
                                     GROUP BY companyname, Investor, MA_Date
                                    LIMIT 0 , 1000";

                                            //echo "<br>Advisor search-- " .$companysql;
				}
				elseif($advisorsearch_trans!="")
						{
							$companysql="(SELECT co.companyname, investor.Investor, itype.displayName ,ExitStatus, ind.industry Industry, co.sector_business Sector_Business_Desc, dt.DealType
                                                       TYPE , acq.Acquirer, DATE_FORMAT(ma.DealDate,'%M-%Y') as  MA_Date,ma.DealAmount MA_Amount, sum( inv.amount ) Inv_Amt,
                                                DATE_FORMAT( inv.dates, '%M-%Y' ) AS Inv_Date, inv.stakepercentage Inv_Stake, ma.DealAmount Actual_Exit_Value,
                                                       ( ma.DealAmount / ma.Company_Valuation) *100 as Stake_Divested, ma.hideamount,ma.MandAId,
                                                       co.website,ma.MoreInfor,ma.hidemoreinfor,ma.InvestmentDeals,minvestor.MultipleReturn,ma.Link,
                                                ma.Valuation,ma.FinLink ,ma.Company_Valuation,ma.Revenue_Multiple,ma.EBITDA_Multiple,ma.PAT_Multiple
                                            			from FROM pecompanies co, peinvestments inv, peinvestors investor,
                                                peinvestments_investors invinv, manda ma, manda_investors minvestor,
                                                acquirers acq, investortype itype, industry ind, dealtypes dt,advisor_cias AS cia,
								peinvestments_advisoracquirer AS adac
								 WHERE co.PECompanyId = inv.PECompanyId
                                                AND co.PECompanyId = ma.PECompanyId
                                                AND minvestor.MandAId = ma.MandAId
                                                AND minvestor.InvestorId = investor.InvestorId
                                                AND invinv.PEId = inv.PEId
                                                AND minvestor.InvestorId = invinv.InvestorId
                                                AND acq.AcquirerId = ma.AcquirerId
                                                AND itype.InvestorType = inv.InvestorType
                                                AND ind.industryid = co.industry
                                                AND ma.DealTypeId = dt.DealTypeId and minvestor.MandAId=ma.MandAId
                                                AND ma.Deleted=0 and co.industry != 15 " .$addVCFlagqry.$addhide_pms_qry.
						" AND AdvisorType='T'  and adac.CIAId=cia.CIAID
                                                AND adac.PEId=ma.MandAId and cia.cianame LIKE '%$advisorsearch_legal%')
								UNION
								(SELECT co.companyname, investor.Investor, itype.displayName ,ExitStatus, ind.industry Industry, co.sector_business Sector_Business_Desc, dt.DealType
                                                       TYPE , acq.Acquirer,DATE_FORMAT(ma.DealDate,'%M-%Y') as  MA_Date, ma.DealAmount MA_Amount, sum( inv.amount ) Inv_Amt,
                                                DATE_FORMAT( inv.dates, '%M-%Y' ) AS Inv_Date, inv.stakepercentage Inv_Stake, ma.DealAmount Actual_Exit_Value,
                                                       ( ma.DealAmount / ma.Company_Valuation) *100 as Stake_Divested , ma.hideamount ,ma.MandAId,
                                                       co.website ,ma.MoreInfor,ma.hidemoreinfor,ma.InvestmentDeals,ma.Link,
                                                ma.Valuation,ma.FinLink ,ma.Company_Valuation,ma.Revenue_Multiple,ma.EBITDA_Multiple,ma.PAT_Multiple
                                            		from FROM pecompanies co, peinvestments inv, peinvestors investor,
                                                peinvestments_investors invinv, manda ma, manda_investors minvestor,
                                                acquirers acq, investortype itype, industry ind, dealtypes dt,advisor_cias AS cia,
						peinvestments_advisorcompanies AS adcomp
						 WHERE co.PECompanyId = inv.PECompanyId
                                                AND co.PECompanyId = ma.PECompanyId
                                                AND minvestor.MandAId = ma.MandAId
                                                AND minvestor.InvestorId = investor.InvestorId
                                                AND invinv.PEId = inv.PEId
                                                AND minvestor.InvestorId = invinv.InvestorId
                                                AND acq.AcquirerId = ma.AcquirerId
                                                AND itype.InvestorType = inv.InvestorType
                                                AND ind.industryid = co.industry
                                                AND ma.DealTypeId = dt.DealTypeId
                                                AND ma.Deleted=0 and co.industry != 15 " .$addVCFlagqry.$addhide_pms_qry.
						" AND AdvisorType='T'  and adcomp.CIAId=cia.CIAID
                                                AND adcomp.PEId=ma.MandAId and cia.cianame LIKE '%$advisorsearch_legal%')
                                                 GROUP BY companyname, Investor, MA_Date
                                                LIMIT 0 , 1000";
							//echo "<br>Advisor search-- " .$companysql;
				}
				elseif (($industry > 0) || ($dealtype != "--") || ($invType != "--") || ($exitstatusvalue!="--") || ($dateValue!="---to---"))
				{
                                        $companysql = "SELECT pec.companyname, investor.Investor, it.displayName,pe.ExitStatus, i.industry, pec.sector_business, dt.DealType TYPE , DATE_FORMAT
                                            (pe.DealDate,'%M-%Y') as MA_Date, pe.DealAmount MA_Amount, peinv.amount, DATE_FORMAT( peinv.dates, '%M-%Y' ) AS Inv_Date, peinv.stakepercentage Inv_Stake, pe.DealAmount Actual_Exit_Value, ( pe.DealAmount / 
                                            pe.Company_Valuation) *100 as Stake_Divested , pe.hideamount,pe.MandAId, 
                                            pec.website,pe.MoreInfor,pe.hidemoreinfor,pe.InvestmentDeals,mandainv.MultipleReturn,pe.Link, pe.Valuation,pe.FinLink 
                                            ,pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple
                                            FROM manda AS pe
                                            JOIN pecompanies AS pec on pec.PEcompanyID = pe.PECompanyID
                                            JOIN industry AS i on i.industryid = pec.industry
                                            JOIN dealtypes as dt on dt.DealTypeId = pe.DealTypeId
                                            JOIN investortype as it on it.InvestorType = pe.InvestorType
                                            JOIN manda_investors as mandainv on mandainv.MandAId=pe.MandAId
                                            JOIN peinvestors as investor on investor.InvestorId=mandainv.InvestorId
                                            LEFT JOIN peinvestments_investors as pe_inv on pe_inv.InvestorId = mandainv.InvestorId
                                            LEFT JOIN peinvestments as peinv on peinv.PEId = pe_inv.PEId and peinv.PECompanyId = pe.PECompanyId where";

                                        $whereind="";
                                        $wheredates="";
                                        $wheredealtype="";
                                        if ($industry > 0)
                                                $whereind = " pec.industry=" .$industry ;
                                        if ($dealtype!="--")
                                                $wheredealtype = " dt.DealTypeId =" .$dealtype;
                                        if ($invType!= "--")
                                                $whereInvType = " it.InvestorType = '".$invType."'";
                                        if($exitstatusvalue!="--")
                                        {    $whereexitstatus=" pe.ExitStatus=".$exitstatusvalue;  }
                                        if(($hidetxtfrm>=0) &&($hidetxtto > 0))
                                         {
                                           $whereReturnMultiple=" mandainv.MultipleReturn > " .$hidetxtfrm . " and  mandainv.MultipleReturn <".$hidetxtto;
                                         }
                                        if($dateValue!="---to---")
                                                $wheredates= " DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";

                                        if ($whereind != "")
                                                        $companysql=$companysql . $whereind ." and ";
                                        if (($wheredealtype != ""))
                                                $companysql=$companysql . $wheredealtype . " and " ;
                                        if (($whereInvType != "") )
                                                $companysql=$companysql .$whereInvType . " and ";
                                        if($whereexitstatus!="")
                                          {     $companysql=$companysql .$whereexitstatus . " and ";     }
                                         if($whereReturnMultiple!= "")
                                                {
                                                 $companysql = $companysql . $whereReturnMultiple ." and ";
                                                }
                                        if($wheredates !== "")
                                                $companysql = $companysql . $wheredates ." and ";

                                        $companysql = $companysql . " pe.Deleted=0 " .$addVCFlagqry.$addhide_pms_qry." group by pe.MandAId order by companyname";
//                                        echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
//                                        exit;
			}
			else
			{
				echo "<br> INVALID DATES GIVEN ";
				$fetchRecords=false;
			}
		//mail sending
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
								$filetitle="";
								if($searchtitle==0)
								{
									$searchdisplay="M&AExits-Inv";
									$filetitle="M&AExits-Inv_deals";
								}
								elseif($searchtitle==1)
								{
									$searchdisplay="M&AVCExits-Inv";
									$filetitle="VCExits-Inv_deals";
								}
								if($hide_pms==1)
                                                                {
                                                                  $searchdisplay="Public Market Sales ".$searchdisplay;
								  $filetitle="Public_Market_Sales_".$filetitle;
                                                                }
								/*elseif($searchtitle==2)
								{
									$searchdisplay="Real Estate";
									$filetitle="";
								}
								else
									$searchdisplay="";
                                                                */
								if($hidesearchon==3)
								{
									$subject="Send Excel Data : M&A Exits and Investments  - $searchdisplay ";
									$message="<html><center><b><u> Send M&A Data :$searchdisplay to - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustrytext</td></tr>
									<tr><td width=1%>Deal Type </td><td width=99%>$dealtypetext</td></tr>
									<tr><td width=1%>Period</td><td width=99%>$dateValue</td></tr>
									<tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
									<tr><td width=1%>Investment Type</td><td width=99%>$invtypevalue</td></tr>
                                                                        <tr><td width=1%>Exit Status Type</td><td width=99%>$exitstatusvalue</td></tr>
                                                                        <tr><td width=1%>Company</td><td width=99%>$companysearch</td></tr>
									<tr><td width=1%>Advisor</td><td width=99%>$advisorsearch</td></tr>
									<tr><td width=1%>Acquirer</td><td width=99%>$acquirersearch</td></tr>
									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";
								}

								mail($to,$subject,$message,$headers);
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

 $sql=$companysql;
//echo "<br>---" .$sql;
 //execute query
 $result = @mysql_query($sql)
      
     or die("Error in connection");

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

 	echo ("$tsjtitle");
 	 print("\n");
 	  print("\n");

 //define separator (defines columns in excel & tabs in word)
 $sep = "\t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }


echo "Company"."\t";
	echo "Investor"."\t";
	echo "Syndication"."\t";
        echo "Exit Status"."\t";
        echo "Industry"."\t";
	echo "Sector_Business Description"."\t";
	echo "Type"."\t";
	echo "M&A Deal Date"."\t";
	echo "Deal Amount (US\$M)"."\t";
	echo "Investment Amount (US\$M)"."\t";
	echo  "Investment Date"."\t";
	echo "Stake (%)"."\t";
	//echo "Actual Exit Value"."\t";
	//echo "Stake Divested"."\t";

	echo "Advisor-Seller"."\t";//12
	echo "Advisor-Buyer"."\t";//13
	echo "Website"."\t";//16
        echo "Link"."\t";//21
	echo "Addln Info"."\t";//17&18
	echo "Investment Details"."\t";//19
	echo "Return Multiple"."\t";//20
    	echo "Company Valuation (INR Cr)"."\t";//24
        echo "Revenue Multiple"."\t";//25
        echo "EBITDA Multiple"."\t";//26
        echo "PAT Multiple"."\t";//27
        echo "Valuation"."\t";//22
	echo "Link for Financials"."\t";//23
 print("\n");

 print("\n");
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
               $mandaId= $row[15].$sep; // MandAId
               $schema_insert .= $row[0].$sep; //companyname
             	//investors
                    $schema_insert .= $row[1].$sep;
	        //investor type
                    $schema_insert .= $row[2].$sep;
		//Exit Status
                    if($row[3]==0){
                        $exitstatusdisplay="Partial";
                    }
                    elseif($row[3]==1){
                        $exitstatusdisplay="Complete";
                    }
                    $schema_insert .= $exitstatusdisplay.$sep;

		//industry
                    $schema_insert .= $row[4].$sep;
                //sector
                    $schema_insert .= $row[5].$sep;
                //dealtype
                    $schema_insert .= $row[6].$sep;
                //deal date
                    $schema_insert .= $row[7].$sep;
                //deal amount
                    $schema_insert .= $row[8].$sep;
		
			if(($row[12]==1) || ($row[9]<=0))
                        {
				$hideamount="";
                        }
			else{
				$hideamount=$row[8];
                        }
			$schema_insert .= $hideamount.$sep; //Investment amount
			$schema_insert .= $row[10].$sep; //Investment Date
			$schema_insert .= $row[11].$sep;  //Stake Inv
			//$schema_insert .= $row[10].$sep;  
			//$schema_insert .= $row[11].$sep;  //Actal Exit Value
			//$schema_insert .= $row[12].$sep;  //Stake Invested

                        $advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame ,AdvisorType from peinvestments_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.PEId=$mandaId and advcomp.CIAId=cia.CIAId";

	$adacquirersql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from peinvestments_advisoracquirer as advinv,
	advisor_cias as cia where advinv.PEId=$mandaId and advinv.CIAId=cia.CIAId";
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

                $schema_insert .= $advisorCompanyString.$sep;
		$schema_insert .= $advisorAcquirerString.$sep;

                $schema_insert .= $row[16].$sep;  //website
                $schema_insert .= $row[21].$sep; // Link
                if($row[18]==1)
                {
                    $hidemoreinfor="";
                }
                else
                {
                    $hidemoreinfor=$row[17];
                }
	        $schema_insert .= $hidemoreinfor.$sep;    // Addln infor- more information
                
                $schema_insert .= $row[19].$sep; // InvestmentDetails

                if(($row[20]==0)  || ($row[20]<=0) )
                {
                 $returnmultiple="";
                }
                else
                {
                 $returnmultiple =$row[20];
                }
                $schema_insert .= $returnmultiple.$sep; // Return Multiple
                

                $dec_company_valuation=$row[24];
                if ($dec_company_valuation <=0)
                {
                   $dec_company_valuation="";
                }

                $dec_revenue_multiple=$row[25];
                if($dec_revenue_multiple<=0){
                    $dec_revenue_multiple="";
                }
                    

                $dec_ebitda_multiple=$row[26];
                if($dec_ebitda_multiple<=0){
                    $dec_ebitda_multiple="";
                }
                    

                $dec_pat_multiple=$row[27];
                if($dec_pat_multiple<=0){
                   $dec_pat_multiple="";
                }

                $schema_insert .= $dec_company_valuation.$sep;  //company valuation
                $schema_insert .= $dec_revenue_multiple.$sep;  //Revenue Multiple
                $schema_insert .= $dec_ebitda_multiple.$sep;  //EBITDA Multiple
                $schema_insert .= $dec_pat_multiple.$sep;  //PAT Multiple

                 $schema_insert .= $row[22].$sep; // Valuation (more info)
                 $schema_insert .= $row[23].$sep; // fin link
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
  mysql_close();
    mysql_close($cnx);
    ?>


