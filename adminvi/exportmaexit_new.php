<?php
        require("../dbconnectvi.php");
        $Db = new dbInvestments();
    if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
    {
        
        $month1=$_POST['month1'];
        $year1 = $_POST['year1'];
        $month2=$_POST['month2'];
        $year2 = $_POST['year2'];

        $addVCFlagqry = " and pec.industry !=15 ";
        $searchTitle = "List of IPO Exits";
		
        if(($month1=="--") && ($year1=="--") && ($month2=="--") && ($year2=="--"))
        {
         /*$companysql = "SELECT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
                        DealAmount,pe.uploadfilename,FinLink, DATE_FORMAT( DealDate, '%b-%Y' ) as dealperiod
                        FROM manda AS pe, industry AS i, pecompanies AS pec
                        WHERE pec.industry = i.industryid
                        AND pec.PEcompanyID = pe.PECompanyID
                        and pe.Deleted=0" .$addVCFlagqry.
                        "order by DealDate desc,DealAmount desc";*/
        $companysql = "SELECT pe.MandAId, pe.PECompanyId, pec.companyname, i.industry, pec.sector_business, pe.DealAmount, dt.DealType, pe.type, pe.ExitStatus, acq.Acquirer, ivt.InvestorTypeName, DATE_FORMAT( pe.DealDate, '%b-%Y' ) as dealperiod, pec.website, pe.Comment, pe.MoreInfor, pe.InvestmentDeals, pe.Validation, pe.VCFlag, pe.Link, pe.EstimatedIRR, pe.MoreInfoReturns, pe.Company_Valuation, pe.Revenue_Multiple, pe.EBITDA_Multiple, pe.PAT_Multiple, pe.price_to_book, pe.Valuation, pe.Revenue, pe.EBITDA, pe.PAT, pe.book_value_per_share, pe.price_per_share, pe.FinLink, pe.uploadfilename, pe.source, pe.AcquirerId, pe.DealTypeId, pe.hidemoreinfor, pe.hideamount, pe.InvestorType
                                FROM manda as pe
                                LEFT JOIN pecompanies as pec
                                    ON pec.PEcompanyID = pe.PECompanyID
                                LEFT JOIN industry as i
                                    ON i.industryid = pec.industry
                                LEFT JOIN dealtypes as dt
                                    ON dt.DealTypeId=pe.DealTypeId
                                LEFT JOIN acquirers as acq
                                    ON acq.AcquirerId = pe.AcquirerId
                                LEFT JOIN investortype as ivt
                                    ON ivt.InvestorType = pe.InvestorType
                                WHERE pe.Deleted = 0 " .$addVCFlagqry. "ORDER BY pe.DealDate desc, pe.DealAmount desc";

        }
        elseif (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--") )
        {

                $dt1 = $year1."-".$month1."-01";
                //echo "<BR>DATE1---" .$dt1;
                $dt2 = $year2."-".$month2."-01";
                /*$companysql = "select pe.MandAId,pe.PECompanyID,pec.companyname,pec.industry,i.industry,
                                DealAmount,DATE_FORMAT(DealDate,'%b-%Y') as dealperiod,pe.uploadfilename,FinLink
                                from manda as pe, industry as i,pecompanies as pec where pec.industry=i.industryid
                                and DealDate between '".$dt1."' and '".$dt2 ."'
                                and	pec.PEcompanyID = pe.PECompanyID
                                and pe.Deleted=0 " .$addVCFlagqry. "order by DealDate desc,pe.DealAmount desc ";*/
                $companysql = "SELECT pe.MandAId, pe.PECompanyId, pec.companyname, i.industry, pec.sector_business, pe.DealAmount, dt.DealType, pe.type, pe.ExitStatus, acq.Acquirer, ivt.InvestorTypeName, DATE_FORMAT( pe.DealDate, '%b-%Y' ) as dealperiod, pec.website, pe.Comment, pe.MoreInfor, pe.InvestmentDeals, pe.Validation, pe.VCFlag, pe.Link, pe.EstimatedIRR, pe.MoreInfoReturns, pe.Company_Valuation, pe.Revenue_Multiple, pe.EBITDA_Multiple, pe.PAT_Multiple, pe.price_to_book, pe.Valuation, pe.Revenue, pe.EBITDA, pe.PAT, pe.book_value_per_share, pe.price_per_share, pe.FinLink, pe.uploadfilename, pe.source, pe.AcquirerId, pe.DealTypeId, pe.hidemoreinfor, pe.hideamount, pe.InvestorType                             
                                FROM manda as pe
                                LEFT JOIN pecompanies as pec
                                    ON pec.PEcompanyID = pe.PECompanyID
                                LEFT JOIN industry as i
                                    ON i.industryid = pec.industry
                                LEFT JOIN dealtypes as dt
                                    ON dt.DealTypeId=pe.DealTypeId
                                LEFT JOIN acquirers as acq
                                    ON acq.AcquirerId = pe.AcquirerId
                                LEFT JOIN investortype as ivt
                                    ON ivt.InvestorType = pe.InvestorType
                                WHERE pe.DealDate between '".$dt1."' and '".$dt2 ."'
                                AND pe.Deleted = 0 " .$addVCFlagqry. "ORDER BY pe.DealDate desc, pe.DealAmount desc";
                                //				echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
        }
        else
        {
            echo "<br> INVALID DATES GIVEN ";
            $fetchRecords=false;
        }

			

        $sql=$companysql;
       //echo "<br>---" .$sql;die;
        //execute query
        $result = @mysql_query($sql)
            or die("Error in connection:<br>");

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
        header("Content-Disposition: attachment; filename=MA_exit.$file_ending");
        header("Pragma: no-cache");
        header("Expires: 0");

 /*    Start of Formatting for Word or Excel    */

 /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */

 	//create title with timestamp:
 	if ($Use_Title == 1)
 	{
 		echo("$title\n");
 	}
        //define separator (defines columns in excel & tabs in word)
        $sep = "\t"; //tabbed character


        echo "Company"."\t";
        echo "Industry"."\t";
        echo "Sector"."\t";
        echo "Amount(US\$M)"."\t";
        echo "Deal Type"."\t";
        echo "Type"."\t";
        echo "Exit Status"."\t";
        echo "Acquirer"."\t";
        echo "Investors"."\t";
        echo "Investors - Multiple Return - More Info"."\t";
        echo "Investor Type"."\t";
        echo "Advisor Seller"."\t";
        echo "Advisor Buyer"."\t";
        echo "Period"."\t";
        echo "Website"."\t";
        echo "Comment"."\t";
        echo "More Information"."\t";
        echo "Inv Deal(Summary)"."\t";
        echo "Validation"."\t";
        echo "VC Flag"."\t";
        echo "Link"."\t";
        echo "Estimated Return Multiple"."\t";
        echo "More Infor (Returns)"."\t";
        echo "Company Valuation (INR Cr)"."\t";
        echo "Revenue Multiple"."\t";
        echo "EBITDA Multiple"."\t";
        echo "PAT Multiple"."\t";
        echo "Price to Book"."\t";
        echo "Valuation (More Info)"."\t";
        echo "Revenues (INR Cr)"."\t";
        echo "EBITDA (INR Cr)"."\t";
        echo "PAT (INR Cr)"."\t";
        echo "Book Value Per Share"."\t";
        echo "Price Per Share"."\t";
        echo "Link for Financials (LISTED FIRM ONLY)"."\t";
        echo "Financial "."\t";
        echo "Source"."\t";

        print("\n");

        print("\n");
        //end of printing column names

        //start while loop to get data
        /*
        note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
        */

        while($row = mysql_fetch_array($result))
        {

            $investorString = '';
            $moreInfo = '';
            $getInvestorsSql="SELECT peinv.MandAId,peinv.InvestorId,inv.Investor,peinv.MultipleReturn,peinv.InvMoreInfo 
                             FROM manda_investors as peinv
                             LEFT JOIN peinvestors as inv
                                ON inv.InvestorId = peinv.InvestorId
                            WHERE peinv.MandAId=$row[0]";
            if ($rsinvestors = mysql_query($getInvestorsSql)) {
                $i=1;
                $numRows = mysql_num_rows( $rsinvestors );
                While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH)) {
                    if( $i == $numRows ) {
                        $invCommaStr = '';
                        $invMoreCommaStr = '';
                    } else {
                        $invCommaStr = ',';
                        $invMoreCommaStr = ',';
                    }
                    $strInvestorValue = str_replace( "/", " ", $myInvrow["Investor"] );
                    $investorString .= $strInvestorValue . $invCommaStr;
                    $moreInfo .= $strInvestorValue . " - " . $myInvrow[ "MultipleReturn" ] . $invMoreCommaStr;
                    $i++;
                }
            }
            $strAdvComp = "";
            $advcompanysql="SELECT advcomp.PEId,advcomp.CIAId,cia.cianame,cia.AdvisorType
                            FROM peinvestments_advisorcompanies as advcomp
                            LEFT JOIN advisor_cias as cia
                                ON cia.CIAId = advcomp.CIAId 
                            WHERE advcomp.PEId=$row[0]";
            if ( $rsAdvisorCompany = mysql_query( $advcompanysql ) ) {
                While( $myInvrow = mysql_fetch_array( $rsAdvisorCompany, MYSQL_BOTH ) ) {
                    $strAdvComp = $strAdvComp.",".$myInvrow["cianame"]."/" .$myInvrow["AdvisorType"];
                }
            }
            $strAdvComp =substr_replace( $strAdvComp, '', 0,1 );
            $strAdvAcq = '';
            $advacquirersql="SELECT advinv.PEId,advinv.CIAId,cia.cianame,cia.AdvisorType
                            FROM peinvestments_advisoracquirer as advinv
                            LEFT JOIN advisor_cias as cia
                                ON cia.CIAId = advinv.CIAId 
                            WHERE advinv.PEId=$row[0]";
            if ( $rsAdvisorAcquirer = mysql_query( $advacquirersql ) ) {
                While( $myInvrow = mysql_fetch_array( $rsAdvisorAcquirer, MYSQL_BOTH ) ) {
                    $strAdvAcq = $strAdvAcq.",".trim($myInvrow["cianame"])."/" .$myInvrow["AdvisorType"];
                }
            }
            $strAdvAcq =substr_replace($strAdvAcq, '', 0,1);

            if( $row['ExitStatus'] == 0 ) {
                $existStaus = 'Partial';
            } else if( $row['ExitStatus'] == 1 ) {
                $existStaus = 'Complete';
            } else {
                $existStaus = '-';
            }

            if( $row[ 'DealTypeId' ] != 4 ) {
                $type = '-';
            } else {
                if( $row[ 'type' ] == 1 ) {
                    $type = 'IPO';
                } else if( $row[ 'type' ] == 3 ) {
                    $type = 'Reverse Merger';
                }else {
                    $type = 'Open Market Transaction';
                }
            }

            $schema_insert = "";
            $schema_insert .= $row['companyname'].$sep; // Company
            $schema_insert .= $row['industry'].$sep; //Industry
            $schema_insert .= $row['sector_business'].$sep;   //Sector
            $schema_insert .= $row['DealAmount'].$sep; //Amount
            $schema_insert .= $row['DealType'].$sep; // Deal Type
            $schema_insert .= $type.$sep; //Type
            $schema_insert .= $existStaus.$sep;   //Exit Status
            $schema_insert .= $row['Acquirer'].$sep; //Acquirer
            $schema_insert .= $investorString.$sep; //Investors
            $schema_insert .= $moreInfo.$sep; //Investors
            $schema_insert .= $row['InvestorTypeName'].$sep;   //Investor Type
            $schema_insert .= $strAdvComp.$sep; //Advisor Seller
            $schema_insert .= $strAdvAcq.$sep; //Advisor Buyer
            $schema_insert .= $row['dealperiod'].$sep;   //Period
            $schema_insert .= $row['website'].$sep; //Website
            $schema_insert .= $row['Comment'].$sep; //Comment
            $schema_insert .= $row['MoreInfor'].$sep;   //More Information
            $schema_insert .= $row['InvestmentDeals'].$sep; //Inv Deal(Summary)
            $schema_insert .= $row['Validation'].$sep; //Validation
            $schema_insert .= $row['VCFlag'].$sep;   //VC Flag
            $schema_insert .= $row['Link'].$sep; //Link
            $schema_insert .= $row['EstimatedIRR'].$sep; //Estimated Return Multiple
            $schema_insert .= $row['MoreInfoReturns'].$sep;   //More Infor (Returns)
            $schema_insert .= $row['Company_Valuation'].$sep; //Company Valuation (INR Cr)
            $schema_insert .= $row['Revenue_Multiple'].$sep; //Revenue Multiple
            $schema_insert .= $row['EBITDA_Multiple'].$sep;   //EBITDA Multiple
            $schema_insert .= $row['PAT_Multiple'].$sep; //PAT Multiple
            $schema_insert .= $row['price_to_book'].$sep; //Price to Book
            $schema_insert .= $row['Valuation'].$sep;   //Valuation (More Info)
            $schema_insert .= $row['Revenue'].$sep; //Revenues (INR Cr)
            $schema_insert .= $row['EBITDA'].$sep; // EBITDA (INR Cr)
            $schema_insert .= $row['PAT'].$sep; //PAT (INR Cr)
            $schema_insert .= $row['book_value_per_share'].$sep;   //Book Value Per Share
            $schema_insert .= $row['price_per_share'].$sep; //Price Per Share
            $schema_insert .= $row['FinLink'].$sep; // Link for Financials (LISTED FIRM ONLY)
            $schema_insert .= $row['uploadfilename'].$sep; //Financial
            $schema_insert .= $row['source'].$sep;   //Source

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