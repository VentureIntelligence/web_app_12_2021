<?php
    require("../dbconnectvi.php");
    $Db = new dbInvestments();
                
    $tsjtitle ="Incubatees";
    
    $getcompanySql="SELECT DISTINCT pe.IncubateeId, pec.PECompanyId AS companyId, pec.companyname, pec.industry, i.industry, pec.sector_business, website,
    pec.stockcode, pec.yearfounded,pec.Address1,pec.Address2,pec.AdCity,pec.Zip,pec.OtherLocation,
    c.country,pec.Telephone,pec.Fax,pec.Email,pec.AdditionalInfor,pec.angelco_compID,pec.tags FROM pecompanies AS pec, incubatordeals AS pe,industry as i,country as c
    WHERE pec.PECompanyId = pe.IncubateeId AND pec.industry = i.industryid  and c.countryid=pec.countryid and pe.Deleted=0  and pec.industry!=15 ORDER BY pec.companyname";
   
    //execute query
    $result = @mysql_query($getcompanySql)
        or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());

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
    header("Content-Disposition: attachment; filename=incubatees.".$file_ending);
    header("Pragma: no-cache");
    header("Expires: 0");

    /*    Start of Formatting for Word or Excel    */
    /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */
    //create title with timestamp:
    if ($Use_Title == 1)
    { 		
        echo("$title\n"); 	
    }

    echo $tsjtitle;
    print("\n");
    print("\n");
                       
                                
    //define separator (defines columns in excel & tabs in word)
     $sep = "\t"; //tabbed character

        echo "Company"."\t";
        echo "Industry"."\t";
        echo "Sector"."\t";
        echo "Stock Code"."\t";
        echo "Year Founded"."\t";
        echo "Address"."\t";
        echo "Address2"."\t";
        echo "City"."\t";
        //echo "Region"."\t";
        echo "Country"."\t";
        echo "Zip"."\t";
        echo "Telephone "."\t";
        echo "Fax"."\t";
        echo "Email"."\t";
        echo "Website"."\t";
        echo "Other Location(s)"."\t";
        echo "Tags"."\t";
        //echo "More Information"."\t";

        print("\n");
        print("\n");
     //end of printing column names

     //start while loop to get data
     /*
     note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
     */

        while($row = mysql_fetch_row($result))
        {
             //set_time_limit(60); // HaRa
             $schema_insert = "";
             $strStage="";
             $strIndustry="";
             $strCompany="";
             $stripoCompany="";
             $strmandaCompany="";
            $companyname=$row[2];
            $companyname=strtolower($companyname);
            $invResult=substr_count($companyname,$searchString);
            $invResult1=substr_count($companyname,$searchString1);
            $invResult2=substr_count($companyname,$searchString2);

            //set_time_limit(60); // HaRa
            $schema_insert = "";

             $schema_insert .=$row[2].$sep; //Companyname
             $schema_insert .=$row[4].$sep; //Industry
             $schema_insert .=$row[5].$sep; //sector
             $schema_insert .=$row[7].$sep; //Stock code
             $schema_insert .=$row[8].$sep; //Year founded
             $schema_insert .=$row[9].$sep; //Adress
             $schema_insert .=$row[10].$sep; //address line 2
             $schema_insert .=$row[11].$sep; //Ad city
             $schema_insert .=$row[14].$sep; //Country
             $schema_insert .=$row[12].$sep; //zip
             $schema_insert .=$row[15].$sep; //Telephone
             $schema_insert .=$row[16].$sep; //Fax
             $schema_insert .=$row[17].$sep; //Email
             $schema_insert .=$row[6].$sep; //website
             $schema_insert .=$row[13].$sep; //Other Location
             
             
            if($row[20]!=''){
                
               $schema_insert .= $row[20].$sep;
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



