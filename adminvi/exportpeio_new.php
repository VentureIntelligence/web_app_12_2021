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
         /*$companysql = "SELECT pe.IPOId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
                        IPOSize, DATE_FORMAT( IPODate, '%b-%Y' ) as dealperiod
                        FROM ipos AS pe, industry AS i, pecompanies AS pec
                        WHERE pec.industry = i.industryid
                        AND pec.PEcompanyID = pe.PECompanyID
                        and pe.Deleted=0" .$addVCFlagqry.
                        "order by IPODate desc,IPOSize desc";*/
        $companysql = "SELECT 
                        pe.IPOId, pe.PECompanyId, pec.companyname, i.industry, pec.sector_business, pe.IPOSize, pe.IPOAmount, pe.IPOValuation, ivt.InvestorTypeName, pe.InvestorSale, pe.ExitStatus, DATE_FORMAT( pe.IPODate, '%b-%Y' )  as dealperiod, CONCAT( cia.cianame) as cianame, pe.Comment, pe.SellingInvestors, pe.MoreInfor, pe.InvestmentDeals, pec.website, pe.Validation, pe.VCFlag, pe.Link, pe.Company_Valuation, pe.Sales_Multiple, pe.EBITDA_Multiple, pe.Netprofit_Multiple, pe.price_to_book, pe.EstimatedIRR, pe.MoreInfoReturns, pe.Valuation, pe.Revenue, pe.EBITDA, pe.PAT, pe.book_value_per_share, pe.price_per_share, pe.FinLink, pe.Valuation_Working_fname
                    FROM ipos as pe
                    LEFT JOIN pecompanies as pec
                        ON pec.PEcompanyID = pe.PECompanyID
                    LEFT JOIN industry as i
                        ON i.industryid = pec.industry
                    LEFT JOIN peinvestments_advisorcompanies as advcomp
                        ON advcomp.PEId = pe.IPOId
                    LEFT JOIN advisor_cias as cia
                        ON cia.CIAId = advcomp.CIAId
                    LEFT JOIN investortype as ivt
                        ON ivt.InvestorType = pe.InvestorType
                    /*LEFT JOIN ipo_investors as peinv
                        ON peinv.IPOId = pe.IPOId
                    LEFT JOIN peinvestors as inv
                        ON inv.InvestorId = peinv.InvestorId*/
                    WHERE pe.Deleted = 0 " . $addVCFlagqry . " ORDER BY pe.IPODate desc, pe.IPOSize desc 
                    ";

        }
        elseif (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--") )
        {

                $dt1 = $year1."-".$month1."-01";
                //echo "<BR>DATE1---" .$dt1;
                $dt2 = $year2."-".$month2."-01";
                /*$companysql = "select pe.IPOId,pe.PECompanyID,pec.companyname,pec.industry,i.industry,
                                IPOSize,DATE_FORMAT(IPODate,'%b-%Y') as dealperiod
                                from ipos as pe, industry as i,pecompanies as pec where pec.industry=i.industryid
                                and IPODate between '".$dt1."' and '".$dt2 ."'
                                and	pec.PEcompanyID = pe.PECompanyID
                                and pe.Deleted=0 " .$addVCFlagqry. "order by IPODate desc,pe.IPOSize desc ";*/

            $companysql = "SELECT 
                            pe.IPOId, pe.PECompanyId, pec.companyname, i.industry, pec.sector_business, pe.IPOSize, pe.IPOAmount, pe.IPOValuation, ivt.InvestorTypeName, pe.InvestorSale, pe.ExitStatus, DATE_FORMAT( pe.IPODate, '%b-%Y' )  as dealperiod, CONCAT( cia.cianame) as cianame, pe.Comment, pe.SellingInvestors, pe.MoreInfor, pe.InvestmentDeals, pec.website, pe.Validation, pe.VCFlag, pe.Link, pe.Company_Valuation, pe.Sales_Multiple, pe.EBITDA_Multiple, pe.Netprofit_Multiple, pe.price_to_book, pe.EstimatedIRR, pe.MoreInfoReturns, pe.Valuation, pe.Revenue, pe.EBITDA, pe.PAT, pe.book_value_per_share, pe.price_per_share, pe.FinLink, pe.Valuation_Working_fname
                        FROM ipos as pe
                        LEFT JOIN pecompanies as pec
                            ON pec.PEcompanyID = pe.PECompanyID
                        LEFT JOIN industry as i
                            ON i.industryid = pec.industry
                        LEFT JOIN peinvestments_advisorcompanies as advcomp
                            ON advcomp.PEId = pe.IPOId
                        LEFT JOIN advisor_cias as cia
                            ON cia.CIAId = advcomp.CIAId
                        LEFT JOIN investortype as ivt
                            ON ivt.InvestorType = pe.InvestorType
                        /*LEFT JOIN ipo_investors as peinv
                            ON peinv.IPOId = pe.IPOId
                        LEFT JOIN peinvestors as inv
                            ON inv.InvestorId = peinv.InvestorId*/
                        WHERE 
                            pe.IPODate between '".$dt1."' and '".$dt2 ."'
                            AND pe.Deleted = 0 " . $addVCFlagqry . " ORDER BY pe.IPODate desc, pe.IPOSize desc 
                        ";
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
            or die(mysql_error());

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
        header("Content-Disposition: attachment; filename=ipo_exit.$file_ending");
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
        echo "Sector (Rs)"."\t";
        echo "Deal Size (US $M)"."\t";
        echo "Deal Amount (Rs)"."\t";
        echo "Deal Valuation (US $M)"."\t";
        echo "Investors"."\t";
        echo "Investors - Multiple Return - More Info"."\t";
        echo "Investor Type"."\t";
        echo "Investor Sale ?"."\t";
        echo "Exit Status"."\t";
        echo "Date"."\t";
        echo "Advisors-Company"."\t";
        echo "Comment"."\t";
        echo "Selling Investors"."\t";
        echo "More Information"."\t";
        echo "Inv Deal(Summary)"."\t";
        echo "Website"."\t";
        echo "Validation"."\t";
        echo "VC Flag"."\t";
        echo "Link"."\t";
        echo "Company Valuation (INR Cr)"."\t";
        echo "Revenue Multiple"."\t";
        echo "EBITDA Multiple"."\t";
        echo "PAT Multiple"."\t";
        echo "Price to Book"."\t";
        echo "Estimated Return Multiple"."\t";
        echo "More Infor (Returns)"."\t";
        echo "Valuation (More Info)"."\t";
        echo "Revenues (INR Cr)"."\t";
        echo "EBITDA (INR Cr)"."\t";
        echo "PAT (INR Cr)"."\t";
        echo "Book Value Per Share"."\t";
        echo "Price Per Share"."\t";
        echo "Link for Financials"."\t";
        echo "Valuation Working "."\t";
        print("\n");

        print("\n");
        //end of printing column names

        //start while loop to get data
        /*
        note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
        */
        while($row = mysql_fetch_row($result))
        {
            $investorString = '';
            $moreInfo = '';
            $getInvestorsSql="SELECT peinv.IPOId,peinv.InvestorId,inv.Investor,peinv.MultipleReturn,peinv.InvMoreInfo 
                             FROM ipo_investors as peinv
                             LEFT JOIN peinvestors as inv
                                ON inv.InvestorId = peinv.InvestorId
                            WHERE peinv.IPOId=$row[0]";
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
            if( $row[9] == 1 ) {
                $inverstorSale = 'Yes';
            } else {
                $inverstorSale = 'No';
            }
            if( $row[10] == 0 ) {
                $existStaus = 'Partial';
            } else if( $row[10] == 1 ) {
                $existStaus = 'Complete';
            } else {
                $existStaus = '-';
            }
            $schema_insert = "";
            $schema_insert .= $row[2].$sep; // Company  
            $schema_insert .= $row[3].$sep; //Industry
            $schema_insert .= $row[4].$sep;   //Sector
            $schema_insert .= $row[5].$sep; //Deal Size
            $schema_insert .= $row[6].$sep;  //Deal Amount 
            $schema_insert .= $row[7].$sep; //Deal Valuation
            $schema_insert .= $investorString.$sep;   //Investors
            $schema_insert .= $moreInfo.$sep;   //Investors , Multiple Return, More Info
            $schema_insert .= $row[8].$sep; //Investor Type;   
            $schema_insert .= $inverstorSale.$sep; //Investor Sale ?
            $schema_insert .= $existStaus.$sep;   //Exit Status
            $schema_insert .= $row[11].$sep; //Date;   
            $schema_insert .= $row[12].$sep; //industry
            $schema_insert .= $row[13].$sep;   //amount
            $schema_insert .= $row[14].$sep; //date$schema_insert .= $row[4].$sep;   
            $schema_insert .= $row[15].$sep; //industry
            $schema_insert .= $row[16].$sep;   //amount
            $schema_insert .= $row[17].$sep; //date$schema_insert .= $row[4].$sep;   
            $schema_insert .= $row[18].$sep; //industry
            $schema_insert .= $row[19].$sep;   //amount
            $schema_insert .= $row[20].$sep; //date$schema_insert .= $row[4].$sep;   
            $schema_insert .= $row[21].$sep; //industry
            $schema_insert .= $row[22].$sep;   //amount
            $schema_insert .= $row[23].$sep; //date$schema_insert .= $row[4].$sep;   
            $schema_insert .= $row[24].$sep; //industry
            $schema_insert .= $row[25].$sep;   //amount
            $schema_insert .= $row[26].$sep; //date$schema_insert .= $row[4].$sep;   
            $schema_insert .= $row[27].$sep; //industry
            $schema_insert .= $row[28].$sep;   //amount
            $schema_insert .= $row[29].$sep;   //amount
            $schema_insert .= $row[30].$sep;   //amount
            $schema_insert .= $row[31].$sep;   //amount
            $schema_insert .= $row[32].$sep;   //amount
            $schema_insert .= $row[33].$sep;   //amount
            $schema_insert .= $row[34].$sep;   //amount
            $schema_insert .= $row[35].$sep;   //amount

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