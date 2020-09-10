<?php
        require("../dbconnectvi.php");
        $Db = new dbInvestments();
    if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
    {
        

        $addVCFlagqry = "";
        $searchTitle = "List of Real Estate Deals ";
		
       $companysql = "SELECT pe.IncDealId,pec.PECompanyId,pe.IncubateeId,pec.companyname,
                         	pe.IncubatorId,incu.Incubator ,pe.Comment
				 FROM incubatordeals AS pe, pecompanies AS pec ,incubators as incu
				 WHERE pec.PEcompanyID = pe.IncubateeId and incu.IncubatorId=pe.IncubatorId
				 and pe.Deleted=0 order by companyname";

			

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
        header("Content-Disposition: attachment; filename=inc_deals.$file_ending");
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


        echo "incubatee"."\t";
        echo "incubator"."\t";

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
             $schema_insert .= $row[3].$sep;   
              $schema_insert .= $row[5].$sep;

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