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
         $companysql = "SELECT pe.MAMAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
                        Amount, DATE_FORMAT( DealDate, '%b-%Y' ) as dealperiod,ac.Acquirer,Asset
                         FROM mama AS pe, industry AS i, pecompanies AS pec, acquirers as ac
                         WHERE pec.industry = i.industryid and pe.AcquirerId= ac.AcquirerId 
                         AND pec.PEcompanyID = pe.PECompanyID
                         and pe.Deleted=0"  .$addVCFlagqry." order by DealDate desc,Amount desc";

        }
        elseif (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--") )
        {

                $dt1 = $year1."-".$month1."-01";
                //echo "<BR>DATE1---" .$dt1;
                $dt2 = $year2."-".$month2."-01";
                $companysql = "select pe.MAMAId,pe.PECompanyID,pec.companyname,pec.industry,i.industry,
                                Amount,DATE_FORMAT(DealDate,'%b-%Y') as dealperiod,ac.Acquirer,Asset
                                from mama as pe, industry as i,pecompanies as pec, acquirers as ac where pec.industry=i.industryid and pe.AcquirerId= ac.AcquirerId 
                                and DealDate between '".$dt1."' and '".$dt2 ."'
                                and pec.PEcompanyID = pe.PECompanyID
                                and pe.Deleted=0" .$addVCFlagqry. " order by DealDate desc,pe.Amount desc";
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
        header("Content-Disposition: attachment; filename=meracq.$file_ending");
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
        echo "Amount(US\$M)"."\t";
        echo "Date"."\t";
        echo "Acquirer"."\t";

        print("\n");

        print("\n");
        //end of printing column names

        //start while loop to get data
        /*
        note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
        */

        while($row = mysql_fetch_row($result))
        {

             $schema_insert = "";
             $schema_insert .= $row[2].$sep;   
             $schema_insert .= $row[4].$sep; //industry
              $schema_insert .= $row[5].$sep;   //amount
             $schema_insert .= $row[6].$sep; //date
             $schema_insert .= $row[7].$sep; //Acquirer

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