<?php
	require("../dbconnectvi.php");
    $Db = new dbInvestments();
    if(!isset($_SESSION['UserNames']))
{
         header('Location:../pelogin.php');
}
else
{
require_once '../PHPExcel_1.8.0_doc/Classes/PHPExcel.php';
 
require_once '../PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php';
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
        $submitemail=$_POST['txthideemail'];
					$PEId=$_POST['txthidePEId'];
					$company_name=$_POST['company_name'];
					$deal_date=$_POST['deal_date'];
					$SelCompRef=$PEId;
        $sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
				amount, round, s.Stage, stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dt, pec.website, pec.city,
				r.Region,pe.PEId,comment,MoreInfor,hideamount,hidestake,
				pe.InvestorType, its.InvestorTypeName,pe.StageId,Link,Valuation,FinLink ,AggHide,
				Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,SPV,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,Amount_INR, Company_Valuation_pre, Revenue_Multiple_pre, EBITDA_Multiple_pre, PAT_Multiple_pre, Company_Valuation_EV, Revenue_Multiple_EV, EBITDA_Multiple_EV, PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ, pec.yearfounded,pec.state,pec.CINNo, pec.Telephone,pec.Email,pec.RegionId
				FROM peinvestments AS pe, industry AS i, pecompanies AS pec,
				investortype as its,stage as s,region as r
				WHERE pec.industry = i.industryid
				AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15
				and pe.PEId=$SelCompRef and s.StageId=pe.StageId and   (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) ) 
				and its.InvestorType=pe.InvestorType ";
		/*$sql1="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,listing_status,AggHide,SPV, pec.website,pec.CINNo, pec.Telephone,pec.Email,pec.RegionId, pec.city,pec.state,pec.countryid,
				amount, round, s.Stage, stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dt,
				r.Region,pe.PEId,comment,MoreInfor,hideamount,hidestake,
				pe.InvestorType, its.InvestorTypeName,pe.StageId,Link,Valuation,FinLink ,
				Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,Exit_Status,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,Amount_INR, Company_Valuation_pre, Revenue_Multiple_pre, EBITDA_Multiple_pre, PAT_Multiple_pre, Company_Valuation_EV, Revenue_Multiple_EV, EBITDA_Multiple_EV, PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ, pec.yearfounded
				FROM peinvestments AS pe, industry AS i, pecompanies AS pec,
				investortype as its,stage as s,region as r
				WHERE pec.industry = i.industryid
				AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15
				and pe.PEId=$SelCompRef and s.StageId=pe.StageId and   (r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1) ) 
				and its.InvestorType=pe.InvestorType ";*/
                
               $sql1 ="SELECT pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, website,
            stockcode, yearfounded,pec.Address1,pec.Address2,pec.AdCity,pec.Zip,pec.OtherLocation,
            c.country,pec.Telephone,pec.Fax,pec.Email,pec.AdditionalInfor,pec.angelco_compID,pec.CINNo
            FROM industry AS i,pecompanies AS pec,country as c,peinvestments as  pe
            WHERE pec.industry = i.industryid  and c.countryid=pec.countryid AND pec.PEcompanyID = pe.PECompanyID
             and pe.PEId=$SelCompRef";
             $query2 = mysql_query("SELECT angelco_compID FROM pecompanies as  pec,peinvestments as  pe WHERE  pec.PEcompanyID = pe.PECompanyID and pe.PEId=$SelCompRef");
                                 $result2 = mysql_fetch_array($query2);
                                  $angelco_compID=$result2['angelco_compID'];
                                 $CIN=$result['CINNo'];
                                 
                                 $AngelCount=0;
                                 
                                 if($angelco_compID !=''){
      
      
                                    $profileurl ="https://api.angel.co/1/startups/$angelco_compID/?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&type=startup";

                                    //role=founder&
                                    $roleurl ="https://api.angel.co/1/startups/$angelco_compID/roles?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&type=startup";

                                    $profilejson = file_get_contents($profileurl);
                                    $profile = json_decode($profilejson);


                                    $rolejson = file_get_contents($roleurl);
                                    $roles = json_decode($rolejson);
                                    $roles = $roles->startup_roles;

                                    $AngelCount=1;
                                  }
             
             /*$angelinvsql="SELECT pe.InvesteeId, pec.companyname, pec.industry, i.industry, pec.sector_business,
                DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.AngelDealId ,peinv.InvestorId,inv.Investor
                FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,
                            angel_investors as peinv,peinvestors as inv
                                 WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.InvesteeId and 
                                 pe.Deleted=0 and pec.industry !=15 and pe.InvesteeId=$companyId
                                 and  peinv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv.InvestorId order by dt desc";*/
				                                //echo "<Br>**" .$sql;
                    $investorSql="select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
                    peinvestors as inv where peinv.PEId=$SelCompRef and inv.InvestorId=peinv.InvestorId ORDER BY Investor='others',InvestorId desc";
            //echo "<Br>Investor".$investorSql;

                $advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,cia.AdvisorType from peinvestments_advisorcompanies as advcomp,
                advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";

                $onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,
                        exe.ExecutiveName,exe.Designation,exe.Company from
                        pecompanies as pec,executives as exe,pecompanies_management as mgmt,peinvestments AS pe
        where pe.PEId=$SelCompRef and  pec.PEcompanyID = pe.PECompanyID and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";

        		

                $result = mysql_query($sql);
                 $result1 = mysql_query($sql1);
                updateDownload($result);
                $filetitle=$company_name."-".$deal_date;
               
                //echo "<Br>".$advcompanysql;

                $advinvestorssql="select advinv.PEId,advinv.CIAId,cia.cianame,cia.AdvisorType from peinvestments_advisorinvestors as advinv,
                advisor_cias as cia where advinv.PEId=$SelCompRef and advinv.CIAId=cia.CIAId";
                $rsMgmt= mysql_query($onMgmtSql);
							
        $tsjtitle="© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
        $replace_array = array('\t','\n','<br>','<br/>','<br />','\r','\v');
        
// _____________________________________________________________________________________________________________________
// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Create a first sheet, representing sales data

$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Company')
            ->setCellValue('B1', 'Company Type')
            ->setCellValue('C1', 'Industry')
            ->setCellValue('D1', 'Sector')
            ->setCellValue('E1', 'Amount(US$M)')
            ->setCellValue('F1', 'Amount(INR Cr)')
            ->setCellValue('G1', 'Round')
            ->setCellValue('H1', 'Stage')
            ->setCellValue('I1', 'Investors')
            ->setCellValue('J1', 'Investor Type')
            ->setCellValue('K1', 'Stake (%)')
            ->setCellValue('L1', 'Date')
            ->setCellValue('M1', 'Exit Status')
            ->setCellValue('N1', 'Website')
            ->setCellValue('O1', 'Year Founded')
            ->setCellValue('P1', 'City')
            ->setCellValue('Q1', 'State')
            ->setCellValue('R1', 'Region')
            ->setCellValue('S1', 'Advisor-Company')
            ->setCellValue('T1', 'Advisor-Investors')
            ->setCellValue('U1', 'More Details')
            ->setCellValue('V1', 'Link')
            ->setCellValue('W1', 'Pre-Money')
            ->setCellValue('X1', 'Revenue Multiple')
            ->setCellValue('Y1', 'EBITDA Multiple')
            ->setCellValue('Z1', 'PAT Multiple')
            ->setCellValue('AA1', 'Post-Money')
            ->setCellValue('AB1', 'Revenue Multiple')
            ->setCellValue('AC1', 'EBITDA Multiple')
            ->setCellValue('AD1', 'PAT Multiple')
            ->setCellValue('AE1', 'EV (Enterprise Valuation)')
            ->setCellValue('AF1', 'Revenue Multiple')
            ->setCellValue('AG1', 'EBITDA Multiple')
            ->setCellValue('AH1', 'PAT Multiple')
            ->setCellValue('AI1', 'Price to Book')
            ->setCellValue('AJ1', 'Valuation (More Info)')
            ->setCellValue('AK1', 'Revenue (INR Cr)')
            ->setCellValue('AL1', 'EBITDA (INR Cr)')
            ->setCellValue('AM1', 'PAT (INR Cr)')
            ->setCellValue('AN1', 'Total Debt (INR Cr)')
            ->setCellValue('AO1', 'Cash & Cash Equ. (INR Cr)')
            ->setCellValue('AP1', 'Book Value Per Share')
            ->setCellValue('AQ1', 'Price Per Share')
            ->setCellValue('AR1', 'Link for Financials');
$index = 2;
/*$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Something');
*/

/*echo $result;
exit();*/
 $searchString="Undisclosed";
				$searchString=strtolower($searchString);
				$searchStringDisplay="Undisclosed";
				$searchString1="Unknown";
				$searchString1=strtolower($searchString1);
				$searchString2="Others";
				$searchString2=strtolower($searchString2);
while($row = mysql_fetch_row($result))
{
	
						$listing_status_display="";
						if($row[29]=="L")
                                                       $listing_status_display="Listed";
                                                elseif($row[29]=="U")
                                                       $listing_status_display="Unlisted";

						 if($row[24]==1)
		                                       {
		                                       $openBracket="(";
		                                       $closeBracket=")";
                                                       }
                                                       else
                                                       {
		                                       $openBracket="";
		                                       $closeBracket="";
                                                       }
                                                  if($row[31]==1)
		                                       {
		                                       $openDebtBracket="[";
		                                       $closeDebtBracket="]";
                                                       }
                                                       else
                                                       {
		                                       $openDebtBracket="";
		                                       $closeDebtBracket="";
                                                       }

							/*if($compResult==0)
							{*/
							  $companyName .= $openDebtBracket.$openBracket.$row[1].$closeBracket.$closeDebtBracket;
							   $webdisplay=$row[10];
							 /*}
							 else
							{
								$companyName .=$openDebtBracket.$openBracket.$searchStringDisplay.$closeBracket.$closeDebtBracket.$sep;
								 $webdisplay="";
							}*/
							 $hideamount_INR="";
                                                if($row[16]==1){
                                                    $hideamount="";
                                                }else{
                                                    $hideamount=$row[5];
                                                    if($row[38] != 0.00){
                                                        $hideamount_INR=$row[38];
                                                    }
                                                }
                            if($investorrs = mysql_query($investorSql))
						 {
							$investorString="";
							$AddOtherAtLast="";
							$AddUnknowUndisclosedAtLast="";
						   while($rowInvestor = mysql_fetch_array($investorrs))
							{
								$Investorname=$rowInvestor[2];
								$Investorname=strtolower($Investorname);

								$invResult=substr_count($Investorname,$searchString);
								$invResult1=substr_count($Investorname,$searchString1);
								$invResult2=substr_count($Investorname,$searchString2);

                                                                $investor_detail =trim($rowInvestor[2]);
                                                                if($investor_detail !=''){
                                                                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0)){
                                                                            //$investor_detail =trim(($rowInvestor[2].' - '.$rowInvestor[3].' - '.$rowInvestor[4].' - '.$rowInvestor[5]),' - ');
                                                                            $investorString .=", ".$investor_detail;
                                                                    }elseif(($invResult==1) || ($invResult1==1)){
                                                                            $AddUnknowUndisclosedAtLast .=", ".$investor_detail;
                                                                    }elseif($invResult2==1){
                                                                            $AddOtherAtLast .=", ".$investor_detail;
							}
                                                                }
							}

                                                                  $investorString =trim($investorString, ', ');
								if($AddUnknowUndisclosedAtLast!="")
								{
                                                                  $AddUnknowUndisclosedAtLast =trim($AddUnknowUndisclosedAtLast, ', ');
                                                                  $investorString .= ", ".$AddUnknowUndisclosedAtLast;
                                                                  }
								if($AddOtherAtLast!="")
								{
                                                                  $AddOtherAtLast = trim($AddOtherAtLast, ', ');
									$investorString .=", ".$AddOtherAtLast;
								}
						} 
						if($row[17]==1 || ($row[8]<=0))
							$hidestake="";
						 else
							$hidestake=$row[8];
						$exitstatusis='';
                                                $exitstatusSql = "select id,status from exit_status where id=$row[30]";
                                                if ($exitstatusrs = mysql_query($exitstatusSql))
                                                {
                                                  $exitstatus_cnt = mysql_num_rows($exitstatusrs);
                                                }
                                                if($exitstatus_cnt > 0)
                                                {
                                                        While($myrow=mysql_fetch_array($exitstatusrs, MYSQL_BOTH))
                                                        {
                                                                $exitstatusis = $myrow[1];
                                                        }
                                                }
                                                else{
                                                    $exitstatusis='';
                                                }
                                                $dec_revenue=$row[36];
    if($dec_revenue < 0 || $dec_revenue > 0){
        $dec_revenue = $dec_revenue;  //Revenue 
    }else{
        if ($dec_company_valuation > 0 && $dec_revenue_multiple > 0) {

            $dec_revenue = number_format($dec_company_valuation / $dec_revenue_multiple, 2, '.', '');
        } else {
            $dec_revenue = '';
        }
    }

    $dec_ebitda = $row[37];
    if ($dec_ebitda < 0 || $dec_ebitda > 0) {
        $dec_ebitda = $dec_ebitda;  //EBITDA 
    }else{
        if ($dec_company_valuation > 0 && $dec_ebitda_multiple > 0) {

            $dec_ebitda = number_format($dec_company_valuation / $dec_ebitda_multiple, 2, '.', '');
        } else {
            $dec_ebitda = '';
        }
    }

    $dec_pat = $row[38];
    if ($dec_pat < 0 || $dec_pat > 0) {
        $dec_pat = $dec_pat;  //PAT 
    }else{
        if ($dec_company_valuation > 0 && $dec_pat_multiple > 0) {

            $dec_pat = number_format($dec_company_valuation / $dec_pat_multiple, 2, '.', '');
        } else {
            $dec_pat = '';
        }
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
    if($advisorinvestorrs = mysql_query($advinvestorssql))
                         {
                             $advisorInvestorString="";
                           while($row2 = mysql_fetch_array($advisorinvestorrs))
                            {
                                $advisorInvestorString=$advisorInvestorString.",".$row2[2]."(".$row2[3].")";
                            }
                                $advisorInvestorString=substr_replace($advisorInvestorString, '', 0,1);
                        }
    $resmoreinfo = preg_replace('/(\v|\s)+/', ' ', $row[15]);
    $dec_company_valuation=$row[25];

                                                                $dec_revenue_multiple=$row[26];

                                                                $dec_ebitda_multiple=$row[27];

                                                                $dec_pat_multiple=$row[28];
                                                                $price_to_book=$row[35]; 
                                                                  if($price_to_book<=0)
                                                                         $price_to_book="";


                                                                  $book_value_per_share=$row[36]; 
                                                                  if($book_value_per_share<=0)
                                                                        $book_value_per_share="";


                                                                 $price_per_share=$row[37]; 
                                                                 $dec_revenue=$row[32];
                                                            if($dec_revenue > 0 || $dec_revenue < 0){
                                                                $dec_revenue = $dec_revenue;  //Revenue 
                                                            }else{
                                                               if($dec_company_valuation >0 && $dec_revenue_multiple >0){
                                                            
                                                                   $dec_revenue = number_format($dec_company_valuation/$dec_revenue_multiple, 2, '.', '');
                                                               }
                                                               else{
                                                              $dec_revenue =  '0';
                                                               }
                                                            }

                                                                $dec_ebitda=$row[33];
                                                            if($dec_ebitda > 0 || $dec_ebitda < 0){
                                                                $dec_ebitda = $dec_ebitda;  //EBITDA 
                                                            }else{
                                                                if($dec_company_valuation >0 && $dec_ebitda_multiple >0){
                                                                    
                                                                   $dec_ebitda = number_format($dec_company_valuation/$dec_ebitda_multiple, 2, '.', '');
                                                               }
                                                               else{
                                                                $dec_ebitda = '0';
                                                               }
                                                            }

                                                                $dec_pat=$row[34];
                                                            if($dec_pat > 0 || $dec_pat < 0){
                                                                $dec_pat = $dec_pat;  //PAT 
                                                            }else{
                                                                if($dec_company_valuation >0 && $dec_pat_multiple >0){
                                                                   
                                                                   $dec_pat = number_format($dec_company_valuation/$dec_pat_multiple, 2, '.', '');
                                                               }
                                                               else{
                                                                  $dec_pat= '0';
                                                               }
                                                            }
                                                        
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$index, $companyName)
            ->setCellValue('B'.$index, $listing_status_display)
            ->setCellValue('C'.$index, $row[3])
            ->setCellValue('D'.$index, $row[4])
            ->setCellValue('E'.$index, $hideamount)
            ->setCellValue('F'.$index, $hideamount_INR)
            ->setCellValue('G'.$index, $row[6])
            ->setCellValue('H'.$index, $row[7])
            ->setCellValue('I'.$index, $investorString)
            ->setCellValue('J'.$index, $row[19])
            ->setCellValue('K'.$index, $hidestake)
            ->setCellValue('L'.$index, $row[9])
            ->setCellValue('M'.$index, $exitstatusis)
            ->setCellValue('N'.$index, $webdisplay)
            ->setCellValue('O'.$index, $row[49])
            ->setCellValue('P'.$index, $row[11])
            ->setCellValue('Q'.$index, $row[50])
            ->setCellValue('R'.$index, $row[12])
            ->setCellValue('S'.$index, $advisorCompanyString)
            ->setCellValue('T'.$index, $advisorInvestorString)
            ->setCellValue('U'.$index, $resmoreinfo)
            ->setCellValue('V'.$index, $row[21])
            ->setCellValue('W'.$index, $row[39])
            ->setCellValue('X'.$index, $row[40])
            ->setCellValue('Y'.$index, $row[41])
            ->setCellValue('Z'.$index, $row[42])
            ->setCellValue('AA'.$index, $dec_company_valuation)
            ->setCellValue('AB'.$index, $dec_revenue_multiple)
            ->setCellValue('AC'.$index, $dec_ebitda_multiple)
            ->setCellValue('AD'.$index, $dec_pat_multiple)
            ->setCellValue('AE'.$index, $row[43])
            ->setCellValue('AF'.$index, $row[44])
            ->setCellValue('AG'.$index, $row[45])
            ->setCellValue('AH'.$index, $row[46])
            ->setCellValue('AI'.$index, $price_to_book)
            ->setCellValue('AJ'.$index, trim($row[22]))
            ->setCellValue('AK'.$index, $dec_revenue)
            ->setCellValue('AL'.$index, $dec_ebitda)
            ->setCellValue('AM'.$index, $dec_pat)
            ->setCellValue('AN'.$index, $row[47])
            ->setCellValue('AO'.$index, $row[48])
            ->setCellValue('AP'.$index, $book_value_per_share)
            ->setCellValue('AQ'.$index, $price_per_share)
            ->setCellValue('AR'.$index, $row[23]);
     $index++;
 }
$indexfortitle = $index + 5;
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$indexfortitle, $tsjtitle);
// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle('Deal details');
// _____________________________________________________________________________________________________________________
// Create a new worksheet, after the default sheet
$objPHPExcel->createSheet();

// Add some data to the second sheet, resembling some different data types
//$objPHPExcel->setActiveSheetIndex(1);
//$objPHPExcel->getActiveSheet()->setCellValue('A1', 'More data');
$objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A1', 'Company')
            ->setCellValue('B1', 'Industry')
            ->setCellValue('C1', 'Sector')
            ->setCellValue('D1', 'Stock Code')
            ->setCellValue('E1', 'CIN')
            ->setCellValue('F1', 'Year Founded')
            ->setCellValue('G1', 'Address')
            ->setCellValue('H1', 'City')
            ->setCellValue('I1', 'Country')
            ->setCellValue('J1', 'Zip')
            ->setCellValue('K1', 'Telephone')
            ->setCellValue('L1', 'Fax')
            ->setCellValue('M1', 'Email')
            ->setCellValue('N1', 'Website')
           /*
            ->setCellValue('O1', 'Description')
            ->setCellValue('P1', 'Additional Information')
            ->setCellValue('Q1', 'Other Location(s)')
            ->setCellValue('R1', 'Investors')
            ->setCellValue('S1', 'Investor Board Members')
            ->setCellValue('T1', 'Founders')
            ->setCellValue('U1', 'Top Management')
            ->setCellValue('V1', 'Exits')
            ->setCellValue('W1', 'Angel Investors')
            ->setCellValue('X1', 'Investors (as per AngelList)');*/
            
            
            ->setCellValue('O1', 'Additional Information')
            ->setCellValue('P1', 'Other Location(s)')
            ->setCellValue('Q1', 'Investors')
            ->setCellValue('R1', 'Investor Board Members')
            ->setCellValue('S1', 'Top Management')
            ->setCellValue('T1', 'Exits')
            ->setCellValue('U1', 'Angel Investors');
           
            

           
$index = 2;
/*echo $sql1;
exit();*/
while($row1 = mysql_fetch_row($result1))
{                   
	                if($row1[19] != "")
                        {
                            $CIN=$row1[19]; //CIN
                        }else{
                            $CIN="";
                        }   
						$investorSql="select pe.PEId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV from
                                    peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,
                                    peinvestors as inv where pe.PECompanyId=$row1[0] and
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
                                                            if($myInvestorRow["SPV"]==1)
                                                                    $addDebtWord="; Debt";
                                                                else
                                                                    $addDebtWord="";

                                                           if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                               {
                                $strStage=$strStage.", ".$myInvestorRow["Investor"]."(".$myInvestorRow["dt"].$addTrancheWord.$addDebtWord.")";
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
                        $onBoardSql="select pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId,
                        exe.ExecutiveName,exe.Designation,exe.Company from
                        pecompanies as pec,executives as exe,pecompanies_board as bd
                        where pec.PECompanyId=$row1[0] and bd.PECompanyId=pec.PECompanyId and exe.ExecutiveId=bd.ExecutiveId";
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
                        $onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,
                exe.ExecutiveName,exe.Designation,exe.Company from
                pecompanies as pec,executives as exe,pecompanies_management as mgmt
                where pec.PECompanyId=$row1[0]and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";
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
                $strIpos="";
            $FinalStringIPOs="";
            $ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,
                        IPOAmount, DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId ,pe.ExitStatus
                        FROM ipos AS pe, industry AS i, pecompanies AS pec,ipo_investors as ipoi,peinvestors as inv
                                                WHERE  i.industryid=pec.industry
                        AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=$row1[0]
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
                        $strIpos=substr_replace($strIpos,'',0,1);
                        if((trim(strIpos)!=" ") &&($strIpos!=""))
                        {
                            $FinalStringIPOs="IPO:".$strIpos.";";
                        }
                    }




            $strmas="";
            $FinalStringMAs="";

            $maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,
            DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId,pe.ExitStatus,pe.DealTypeId, dt.DealType
            FROM manda AS pe, industry AS i, pecompanies AS pec,manda_investors as mi ,peinvestors as inv, dealtypes AS dt
                        WHERE  i.industryid=pec.industry
            AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=$row1[0]
            and inv.InvestorId=mi.InvestorId and mi.MandAId=pe.MandAId  and pe.DealTypeId=dt.DealTypeId

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
                            $strmas=$strmas.",".$maexitrow["Investor"]." " .$maexitrow["dt"].", ".$maexitrow["DealType"] .", ".$exitstatusdisplay;
                        }
                    }
                    $strmas=substr_replace($strmas, '', 0,1);
                    if($strmas!="")
                    {
                        $FinalStringMAs="".$strmas;
                    } 
                    if($rsangel= mysql_query($angelinvsql))
                        {
                             $angel_cnt = mysql_num_rows($rsangel);
                        }
                                        While($angelrow=mysql_fetch_array($rsangel, MYSQL_BOTH))
                        {
                                            $strangelinvs=$strangelinvs.",".$angelrow["Investor"]."(".$angelrow["dt"].")";
                        }
                        $strangelinvs=substr_replace($strangelinvs, '', 0,1);
                       /* if($AngelCount==1)
                                                {
                                                    $description =$profile->product_desc; // description
                                                    foreach ($roles as $ro) {  
                                                        if($ro->role == 'founder') { 
                                                            $Angelfounder[] = $ro->tagged->name;
                                                        }
                                                    }
                                                    $Angelfounders = implode(',', $Angelfounder);
                                                    $founders =$Angelfounders; //Founders
                                                    foreach ($roles as $ro) {  
                                                        if($ro->role == 'past_investor' || $ro->role == 'current_investor') { 
                                                                $Angelinvestor[] =  $ro->tagged->name;
                                                        }
                                                    }
                                                        $Angelinvestors = implode(',', $Angelinvestor);
                                                        $Angelinvestors=$Angelinvestors; 
                                                }*/
                                                if($row1[9] !=""){
                                                    $address = $row1[8].$row1[9];
                                                }else{
                                                    $address = $row1[8];
                                                }

$objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A'.$index, $row1[1])
            ->setCellValue('B'.$index, $row1[3])
            ->setCellValue('C'.$index, $row1[4])
            ->setCellValue('D'.$index, $row1[6])
            ->setCellValue('E'.$index, $CIN)
            ->setCellValue('F'.$index, $row1[7])
            ->setCellValue('G'.$index, $address)
            ->setCellValue('H'.$index, $row1[10])
            ->setCellValue('I'.$index, $row1[13])
            ->setCellValue('J'.$index, $row1[11])
            ->setCellValue('K'.$index, $row1[14])
            ->setCellValue('L'.$index, $row1[15])
            ->setCellValue('M'.$index, $row1[16])
            ->setCellValue('N'.$index, $row1[5])
            ->setCellValue('O'.$index, $row1[17])
            ->setCellValue('P'.$index, $row1[12])
            ->setCellValue('Q'.$index, $strStage)
            ->setCellValue('R'.$index, $BoardTeam)
            ->setCellValue('S'.$index, $MgmtTeam)
            ->setCellValue('T'.$index, $FinalStringIPOs."" .$FinalStringMAs)
            ->setCellValue('U'.$index, $strangelinvs);
           



            
            $index++;

}      
$indexfortitle1 =$index+3 ;
$objPHPExcel->setActiveSheetIndex(1)
            ->setCellValue('A'.$indexfortitle1, $tsjtitle);
// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('Company Profile');
// ____________________________________________________________________________________________________________________
// test
$shp_validate="SELECT PEId FROM pe_shp WHERE  PEId = $SelCompRef";
$shp_validate_status = mysql_query($shp_validate);
$shp_validate_status_no = mysql_num_rows($shp_validate_status);
if($shp_validate_status_no != 0){
// Create a new worksheet, after the default sheet
$objPHPExcel->createSheet();
// Add some data to the second sheet, resembling some different data types
$from_title = "A2"; // or any value
$to_title = "B2"; // or any value
$from = "A3"; // or any value
$to = "B3"; // or any value

$objPHPExcel->setActiveSheetIndex(2)->mergeCells('A1:B1')
            ->setCellValue('A1', 'Post Deal Shareholding Pattern (as if converted basis)');

$objPHPExcel->setActiveSheetIndex(2)
            ->setCellValue('A2', 'Shareholders')
            ->setCellValue('B2', 'Stake held');
$objPHPExcel->setActiveSheetIndex(2)
            ->setCellValue('A3', 'Investor')
            ->setCellValue('B3', '');
           
$index = 3;


// Rows for investor
$shp_investorsql="SELECT ps.investor_name, ps.stake_held
                        FROM pe_shp_investor as ps WHERE  PEId = $SelCompRef order by id desc";
                        $shp_investordata = mysql_query($shp_investorsql);
                        
                        while($shp_investorsrow = mysql_fetch_array($shp_investordata)){

                            $index = $index + 1;
                            $pe_shp_investor_name = $shp_investorsrow["investor_name"];
                            $pe_shp_investor_stake_held = $shp_investorsrow["stake_held"];

                            
                    
                            $objPHPExcel->setActiveSheetIndex(2)
                                ->setCellValue('A'.$index, $pe_shp_investor_name)
                                ->setCellValue('B'.$index, $pe_shp_investor_stake_held);

                            $objPHPExcel->getActiveSheet()->getStyle('A'.$index)
                                    ->getBorders()
                                    ->getAllBorders()
                                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                            $objPHPExcel->getActiveSheet()->getStyle('B'.$index)
                                    ->getBorders()
                                    ->getAllBorders()
                                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                    
                                $totalStart_Value = $totalStart_Value + $shp_investorsrow["stake_held"];
                       }
                       $index = $index + 1;
                    $objPHPExcel->setActiveSheetIndex(2)
                       ->setCellValue('A'.$index, "Total")
                       ->setCellValue('B'.$index, $totalStart_Value);

                    $objPHPExcel->getActiveSheet()->getStyle('A'.$index)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                    $objPHPExcel->getActiveSheet()->getStyle('B'.$index)
                            ->getBorders()
                            ->getAllBorders()
                            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
// Promoters
$indexfortitle_promoters =$index+1 ;
$objPHPExcel->setActiveSheetIndex(2)
            ->setCellValue('A'.$indexfortitle_promoters, 'Promoters')
            ->setCellValue('B'.$indexfortitle_promoters, '');

            $objPHPExcel->getActiveSheet()->getStyle('A'.$indexfortitle_promoters)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->getStyle('B'.$indexfortitle_promoters)->getFont()->setBold( true );
            $objPHPExcel->getActiveSheet()->getStyle('A'.$indexfortitle_promoters)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
            $objPHPExcel->getActiveSheet()->getStyle('B'.$indexfortitle_promoters)
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

            $shp_investorsql1="SELECT promoters_name, stake_held
                        FROM pe_shp_promoters WHERE  PEId = $SelCompRef order by id desc";
                        $shp_investordata123 = mysql_query($shp_investorsql1);
                        while($shp_promorow = mysql_fetch_array($shp_investordata123)){

                       
                            $indexfortitle_promoters = $indexfortitle_promoters + 1;
                            $pe_shp_investor_name1 = $shp_promorow["promoters_name"];
                            $pe_shp_investor_stake_held1 = $shp_promorow["stake_held"];
                    
                            $objPHPExcel->setActiveSheetIndex(2)
                                ->setCellValue('A'.$indexfortitle_promoters, $pe_shp_investor_name1)
                                ->setCellValue('B'.$indexfortitle_promoters, $pe_shp_investor_stake_held1);

                                $objPHPExcel->getActiveSheet()->getStyle('A'.$indexfortitle_promoters)
                                    ->getBorders()
                                    ->getAllBorders()
                                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                
                                $objPHPExcel->getActiveSheet()->getStyle('B'.$indexfortitle_promoters)
                                    ->getBorders()
                                    ->getAllBorders()
                                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

                                $totalStart_Valuepromo = $totalStart_Valuepromo + $shp_promorow["stake_held"];
                       }
                       $indexfortitle_promoters = $indexfortitle_promoters + 1;

                       $objPHPExcel->setActiveSheetIndex(2)
                       ->setCellValue('A'.$indexfortitle_promoters, "Total")
                       ->setCellValue('B'.$indexfortitle_promoters, $totalStart_Valuepromo);
                       
                       $objPHPExcel->getActiveSheet()->getStyle('A'.$indexfortitle_promoters)
                                    ->getBorders()
                                    ->getAllBorders()
                                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                        
                        $objPHPExcel->getActiveSheet()->getStyle('B'.$indexfortitle_promoters)
                                    ->getBorders()
                                    ->getAllBorders()
                                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);

$indextitle_val_promoters =$indexfortitle_promoters;

// ESOP & Others
$shp_investorsqlothers="SELECT ESOP, Others
                        FROM pe_shp WHERE  PEId = $SelCompRef order by id desc";
                        $shp_investordataothers = mysql_query($shp_investorsqlothers);
                        $pe_shp_investor_esop="ESOP";
                        $pe_shp_investor_others="Others";
                        
                        while($shp_otherrow = mysql_fetch_array($shp_investordataothers)){

                       
                            $indextitle_val_promoters = $indextitle_val_promoters + 1;
                            $indextitle_val_promoters_update=$indextitle_val_promoters+1;
                            $pe_shp_investor_esop_val = $shp_otherrow["ESOP"];
                            $pe_shp_investor_stake_val = $shp_otherrow["Others"];
                    
                            $objPHPExcel->setActiveSheetIndex(2)
                                ->setCellValue('A'.$indextitle_val_promoters, $pe_shp_investor_esop)
                                ->setCellValue('B'.$indextitle_val_promoters, $pe_shp_investor_esop_val)
                                ->setCellValue('A'.$indextitle_val_promoters_update, $pe_shp_investor_others)
                                ->setCellValue('B'.$indextitle_val_promoters_update, $pe_shp_investor_stake_val);

                                $objPHPExcel->getActiveSheet()->getStyle('A'.$indextitle_val_promoters)->getFont()->setBold( true );
                                $objPHPExcel->getActiveSheet()->getStyle('A'.$indextitle_val_promoters_update)->getFont()->setBold( true );
                                $objPHPExcel->getActiveSheet()->getStyle('A'.$indextitle_val_promoters)
                                    ->getBorders()
                                    ->getAllBorders()
                                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle('B'.$indextitle_val_promoters)
                                    ->getBorders()
                                    ->getAllBorders()
                                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle('A'.$indextitle_val_promoters_update)
                                    ->getBorders()
                                    ->getAllBorders()
                                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                                $objPHPExcel->getActiveSheet()->getStyle('B'.$indextitle_val_promoters_update)
                                    ->getBorders()
                                    ->getAllBorders()
                                    ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                       }
                
// Rename 2nd sheet
$objPHPExcel->getActiveSheet()->setTitle('SHP');
$objPHPExcel->getActiveSheet()->getStyle("$from:$to")->getFont()->setBold( true );
$objPHPExcel->getActiveSheet()->getStyle("$from_title:$to_title")->getFont()->setBold( true );
$objPHPExcel->getActiveSheet()->getStyle("$from_title:$to_title")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getStyle("$from:$to")
            ->getBorders()
            ->getAllBorders()
            ->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
}
// ____________________________________________________________________________________________________________________
$objPHPExcel->setActiveSheetIndex(0);
// Redirect output to a client’s web browser (Excel5)
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="'.$filetitle.'.xls"');
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
        //Check Session Id 
        /**/
}
    ?>