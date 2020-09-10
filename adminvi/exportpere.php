<?php
        require("../dbconnectvi.php");
        $Db = new dbInvestments();
    if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
    {
        
        $month1=$_POST['month1'];
        $year1 = $_POST['year1'];
        $month2=$_POST['month2'];
        $year2 = $_POST['year2'];

        $addVCFlagqry = "";
        $searchTitle = "List of Real Estate Deals ";
		
        if(($month1=="--") && ($year1=="--") && ($month2=="--") && ($year2=="--"))
        {
         $companysql = "SELECT pe.PEId,pe.PECompanyId, pec.companyname, pec.industry,pec.sector_business,
                        i.industry,amount, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod,pe.comment,pe.SPV
                        FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec
                        WHERE pec.industry = i.industryid
                        AND pec.PEcompanyID = pe.PECompanyID
                        and pe.Deleted=0" .$addVCFlagqry.
                        "order by amount desc";

        }
        elseif (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--") )
        {

                $dt1 = $year1."-".$month1."-01";
                //echo "<BR>DATE1---" .$dt1;
                $dt2 = $year2."-".$month2."-01";
                $companysql = "select pe.PEId,pe.PECompanyID,pec.companyname,pec.industry,pec.sector_business,
                                i.industry,
                                amount,DATE_FORMAT(dates,'%b-%Y') as dealperiod,pe.comment,pe.SPV
                                from REinvestments as pe, reindustry as i,REcompanies as pec where pec.industry=i.industryid
                                and dates between '".$dt1."' and '".$dt2 ."'
                                and	pec.PEcompanyID = pe.PECompanyID
                                and pe.Deleted=0 " .$addVCFlagqry. "order by pe.amount desc ";
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
        header("Content-Disposition: attachment; filename=pere_inv.$file_ending");
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