<?php
 require("../dbconnectvi.php");
$Db = new dbInvestments();

$tsjtitle ="Companies Profile";  
 
$getCompanySql="SELECT pec.PECompanyId AS companyId, pec.companyname, pec.industry, i.industry, pec.sector_business, website,
stockcode, yearfounded,pec.Address1,pec.Address2,pec.AdCity,pec.Zip,pec.OtherLocation,
c.country,pec.Telephone,pec.Fax,pec.Email,pec.AdditionalInfor,pec.angelco_compID,pec.tags,pec.CINNo
FROM industry AS i,pecompanies AS pec,country as c
WHERE pec.industry = i.industryid  and c.countryid=pec.countryid order by pec.companyname";
			 
$result = @mysql_query($getCompanySql)
    or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
                                
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
    header("Content-Disposition: attachment; filename=Companiesprofile.$file_ending");
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

    //define separator (defines columns in excel & tabs in word)
    $sep = "\t"; //tabbed character

    echo "Company"."\t";
    echo "CIN No."."\t";
    echo "Industry"."\t";
    echo "Sector"."\t";
    echo "Stock Code"."\t";
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
    echo "Tags "."\t";

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
        
            $companyId=$row['PECompanyId'];//CompanyId
            $schema_insert .=$row['companyname'].$sep; //Companyname
            $schema_insert .=$row['CINNo'].$sep; //CIN No
            $schema_insert .=$row['industry'].$sep; //Industry
            $schema_insert .=$row['sector_business'].$sep; //sector
            $schema_insert .=$row['stockcode'].$sep; //stockcode
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
								
            // investor
            $investorSql="select pe.PEId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide from
            peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,peinvestors as inv where pe.PECompanyId=".$row['companyId']." and
            peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pec.PEcompanyId=pe.PECompanyId order by dates desc";

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

            $onBoardSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,exe.ExecutiveName,exe.Designation,exe.Company from
            pecompanies as pec,executives as exe,pecompanies_board as mgmt where pec.PECompanyId=".$row['companyId']." and
            mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";
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
                                                         
                                                                
            $onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,exe.ExecutiveName,exe.Designation,exe.Company from
            pecompanies as pec,executives as exe,pecompanies_management as mgmt where pec.PECompanyId=".$row['companyId']." and
            mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";
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
                                                                                                          
            $strIpos="";$FinalStringIPOs="";
            
            $ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,IPOAmount, DATE_FORMAT( IPODate, '%b-%Y' ) as dt, 
            pe.IPOId ,pe.ExitStatus FROM ipos AS pe, industry AS i, pecompanies AS pec,ipo_investors as ipoi,peinvestors as inv WHERE  i.industryid=pec.industry
            AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId==".$row['companyId']." and inv.InvestorId=ipoi.InvestorId and ipoi.IPOId=pe.IPOId
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
            
            $strmas="";$FinalStringMAs="";
                                  
            $maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,
            DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId ,pe.ExitStatus
            FROM manda AS pe, industry AS i, pecompanies AS pec,manda_investors as mi ,peinvestors as inv
            WHERE  i.industryid=pec.industry
            AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=".$row['companyId']." and 
            inv.InvestorId=mi.InvestorId and mi.MandAId=pe.MandAId order by dt desc";
            
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

            $angelinvsql="SELECT pe.InvesteeId, pec.companyname, pec.industry, i.industry, pec.sector_business,DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.AngelDealId ,
            peinv.InvestorId,inv.Investor FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,angel_investors as peinv,peinvestors as inv
            WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.InvesteeId and pe.Deleted=0 and pec.industry !=15 and pe.InvesteeId=".$row['companyId']." AND
            peinv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv.InvestorId order by dt desc";
            
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

            
            if($row["tags"]!=''){
                
               $schema_insert .= $row["tags"].$sep;
            }
            
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

?>


