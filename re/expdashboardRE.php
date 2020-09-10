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
            $recCount = $res;
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
        
        
        
        $type=$_POST['txttype'];
        $startyear=$_POST['txtstartdate'];
       $endyear=$_POST['txtenddate'];
       $fixstart=$_POST['txtfixstart'];
       $fixend=$_POST['txtfixend'];
        
        $tsjtitle="� TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media Pvt. Ltd. Any unauthorized redistribution will constitute a violation of copyright law.";
        $tranchedisplay="Note: Target/Company in () indicates the deal is not to be used for calculating aggregate data owing to the it being a tranche / not meeting Venture Intelligence definitions for PE.";
        $exportstatusdisplay="Pls Note : Excel Export is available for transactions of all year, as part of search results. You can export transactions prior  to all year on a deal by deal basis from the deal details popup." ;
 
    if($type==1)
    {
        $Tabletitle="RE - Year on Year";
        $filename="RE_BY_YEAR";
         $sqlYear = "SELECT YEAR( pe.dates ) , COUNT(pe.PEId ) , SUM( pe.amount ) 
                    FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s
                    WHERE pe.IndustryId = i.industryid
                    AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
                    and pe.Deleted=0 and hideamount=0 and dates between '".$startyear."' and '".$endyear."'
                    GROUP BY YEAR( pe.dates )";
         //echo $sqlYear;
    }
    elseif ($type==2) 
    {
        $Tabletitle="RE - By Industry";
         $filename="RE_BY_INDUSTRY";
       $sqlindus = "SELECT i.industry,YEAR(pe.dates) , COUNT( pe.PEId) , SUM( pe.amount) 
                    FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s
                    WHERE pe.IndustryId = i.industryid
                    AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
                    and pe.Deleted=0 and hideamount=0 and dates between '".$startyear."' and '".$endyear."'
                    GROUP BY i.industry,YEAR(pe.dates)";
      
    }
    else if($type==4)
{
         $filename="RE_By_Range";
    }
    elseif($type==5)
    {
         $Tabletitle="RE - By Investor";
         $filename="RE_By_Investor";
       $sqlinvestor = "SELECT inv.InvestorTypeName,YEAR(pe.dates) , COUNT(pe.PEId) , SUM(pe.amount) 
                        FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,investortype as inv
                        WHERE pe.IndustryId = i.industryid
                        AND pec.PEcompanyID = pe.PECompanyID and pe.InvestorType=inv.InvestorType and pe.StageId=s.RETypeId
                        and pe.Deleted=0 and hideamount=0 and dates between '".$startyear."' and '".$endyear."'
                        GROUP BY inv.InvestorTypeName,YEAR(pe.dates)";
     
    }
    elseif($type==6)
    {
         $Tabletitle=" RE - By Region";
         $filename="RE_By_Region";
       $sqlregion =  "SELECT r.Region,YEAR(pe.dates) , COUNT(pe.PEId) , SUM(pe.amount) 
                    FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r
                    WHERE pe.IndustryId = i.industryid and r.RegionId=pe.RegionId 
                    AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
                    and pe.Deleted=0 and hideamount=0 and dates between '".$startyear."' and '".$endyear."'
                    GROUP BY r.Region,YEAR(pe.dates)";
    }
 
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
 header("Content-Disposition: attachment; filename=\"".$filename.".".$file_ending."\"");
 header("Pragma: no-cache");
 header("Expires: 0");
 
if($type==1)
{
     $sql=$sqlYear;
 $result = @mysql_query($sql)
     or die("Error in connection:<br>");
$recCount = mysql_num_rows($result);
 updateDownload($recCount);
 /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */

 	//create title with timestamp:
 	echo ("$Tabletitle");
 	 print("\n");
 	  print("\n");
 	echo ("$tsjtitle");
 	 print("\n");
 	  print("\n");
   	echo ("$tranchedisplay");
 	 print("\n");
 	  print("\n");
            echo ("$exportstatusdisplay");
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
	echo "Year"."\t";
	echo "NO. of Deals"."\t";
	echo "Amount"."\t";
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
         
        $schema_insert .= $row[0].$sep;
        $schema_insert .= $row[1].$sep;
        $schema_insert .= $row[2].$sep;
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
else if($type==2)
{
    $sql=$sqlindus;
 $result = @mysql_query($sql) or die("Error in connection:<br>");


 /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */

 	//create title with timestamp:
 	echo ("$Tabletitle");
 	 print("\n");
 	  print("\n");
 	echo ("$tsjtitle");
 	 print("\n");
 	  print("\n");
   	echo ("$tranchedisplay");
 	 print("\n");
 	  print("\n");
            echo ("$exportstatusdisplay");
 	      print("\n");
 	      print("\n");
              
 //define separator (defines columns in excel & tabs in word)
 //$sep = "\t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }
	echo "INDUSTRY\t";
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo $i."\t\t";
        }
         print("\n");
       
        $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
            if($i==$da)
                {
                    echo "\t";
                }
                else   
                    echo "Deal"."\t"."Amount"."\t";
        }
 print("\n");


 //end of printing column names

 //start while loop to get data
 /*
 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
 */
    while($rowindus = mysql_fetch_array($result))
    { 
       $deal[$rowindus['industry']][$rowindus[1]]['dealcount']=$rowindus[2];
       $deal[$rowindus['industry']][$rowindus[1]]['sumamount']=$rowindus[3];  
    }
    
       $schema_insert = "";
       updateDownload(count($deal));
        foreach($deal as $industry => $values){
           
            $schema_insert .= $industry."\t";
            
             for($i=$fixstart;$i<=$fixend;$i++){
                 $schema_insert .= $values[$i]['dealcount']."\t";
                 $schema_insert .= $values[$i]['sumamount']."\t";
                 
             }
              $schema_insert .= "\n"; 
        
    }
     print(trim($schema_insert));
     print "\n";
}
else if($type==4)
{
    $Tabletitle="RE - By Range";
    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200+");
    for($r=0;$r<count($range);$r++)
    {
        if($r == count($range)-1)
        {
              $sqlrange = "SELECT YEAR( pe.dates ) , COUNT(pe.PEId ) , SUM(pe.amount ) 
                            FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s
                            WHERE pe.IndustryId = i.industryid
                            AND pec.PEcompanyID = pe.PECompanyID and (pe.amount>200) and pe.StageId=s.RETypeId
                            and pe.Deleted=0 and hideamount=0 and dates between '".$startyear."' and '".$endyear."'
                            GROUP BY YEAR( pe.dates )";

              $resultrange= mysql_query($sqlrange);
        }
        else
        {
            $limit=(string)$range[$r];
            $elimit=explode("-", $limit);
           $sqlrange = "SELECT YEAR( pe.dates ) , COUNT(pe.PEId ) , SUM(pe.amount ) 
                        FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s
                        WHERE pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID 
                        and  (pe.amount between ".$elimit[0]." and ".$elimit[1].")
                        and pe.StageId=s.RETypeId and pe.Deleted=0 and hideamount=0 and dates between '".$startyear."' and '".$endyear."'
                        GROUP BY YEAR( pe.dates )";
            
             $resultrange= mysql_query($sqlrange);
        }
        while ($rowrange = mysql_fetch_array($resultrange))
        {
            $deal[$range[$r]][$rowrange[0]]['dealcount']=$rowrange[1];
            $deal[$range[$r]][$rowrange[0]]['sumamount']=$rowrange[2];   
        }

    }
 /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */

 	//create title with timestamp:
 	echo ("$Tabletitle");
 	 print("\n");
 	  print("\n");
 	echo ("$tsjtitle");
 	 print("\n");
 	  print("\n");
   	echo ("$tranchedisplay");
 	 print("\n");
 	  print("\n");
            echo ("$exportstatusdisplay");
 	      print("\n");
 	      print("\n");
              
 //define separator (defines columns in excel & tabs in word)
 //$sep = "\t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }
	echo "Range\t";
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo $i."\t\t";
        }
         print("\n");
       
        $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
            if($i==$da)
                {
                    echo "\t";
                }
                else   
                    echo "Deal"."\t"."Amount"."\t";
        }
 print("\n");


 //end of printing column names

 //start while loop to get data
 /*
 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
 */    
       $schema_insert = "";
       updateDownload(count($deal));
        foreach($deal as $range => $values){
           
            $schema_insert .= $range."\t";
            
             for($i=$fixstart;$i<=$fixend;$i++){
                 $schema_insert .= $values[$i]['dealcount']."\t";
                 $schema_insert .= $values[$i]['sumamount']."\t";
                 
             }
              $schema_insert .= "\n"; 
        
    }
     print(trim($schema_insert));
     print "\n";
}
else if($type==5)
{
    $sql=$sqlinvestor;
 $result = @mysql_query($sql) or die("Error in connection:<br>");


 /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */

 	//create title with timestamp:
 	echo ("$Tabletitle");
 	 print("\n");
 	  print("\n");
 	echo ("$tsjtitle");
 	 print("\n");
 	  print("\n");
   	echo ("$tranchedisplay");
 	 print("\n");
 	  print("\n");
            echo ("$exportstatusdisplay");
 	      print("\n");
 	      print("\n");
              
 //define separator (defines columns in excel & tabs in word)
 //$sep = "\t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }
	echo "INVESTOR\t";
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo $i."\t\t";
        }
         print("\n");
       
        $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
            if($i==$da)
                {
                    echo "\t";
                }
                else   
                    echo "Deal"."\t"."Amount"."\t";
        }
 print("\n");


 //end of printing column names

 //start while loop to get data
 /*
 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
 */
    while($rowinvestor = mysql_fetch_array($result))	
    {  
       $deal[$rowinvestor['InvestorTypeName']][$rowinvestor[1]]['dealcount']=$rowinvestor[2];
       $deal[$rowinvestor['InvestorTypeName']][$rowinvestor[1]]['sumamount']=$rowinvestor[3];  
    }
    
       $schema_insert = "";
       updateDownload(count($deal));
        foreach($deal as $InvestorTypeName => $values){
           
            $schema_insert .= $InvestorTypeName."\t";
            
             for($i=$fixstart;$i<=$fixend;$i++){
                 $schema_insert .= $values[$i]['dealcount']."\t";
                 $schema_insert .= $values[$i]['sumamount']."\t";
                 
             }
              $schema_insert .= "\n"; 
        
    }
     print(trim($schema_insert));
     print "\n";
}
else if($type==6)
{
    $sql= $sqlregion;
 $result = @mysql_query($sql) or die("Error in connection:<br>");


 /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */

 	//create title with timestamp:
 	echo ("$Tabletitle");
 	 print("\n");
 	  print("\n");
 	echo ("$tsjtitle");
 	 print("\n");
 	  print("\n");
   	echo ("$tranchedisplay");
 	 print("\n");
 	  print("\n");
            echo ("$exportstatusdisplay");
 	      print("\n");
 	      print("\n");
              
 //define separator (defines columns in excel & tabs in word)
 //$sep = "\t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }
	echo "REGION\t";
        for($i=$fixstart;$i<=$fixend;$i++)
        {
            echo $i."\t\t";
        }
         print("\n");
       
        $da=$fixstart;
        for($i=$fixstart;$i<=$fixend+1;$i++)
        {
            if($i==$da)
                {
                    echo "\t";
                }
                else   
                    echo "Deal"."\t"."Amount"."\t";
        }
 print("\n");


 //end of printing column names

 //start while loop to get data
 /*
 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
 */
    while($rowregion = mysql_fetch_array( $result))	
    {  
       $deal[$rowregion['Region']][$rowregion[1]]['dealcount']=$rowregion[2];
       $deal[$rowregion['Region']][$rowregion[1]]['sumamount']=$rowregion[3];  
    }
       $schema_insert = "";
       updateDownload(count($deal));
        foreach($deal as $Region => $values){
           
            $schema_insert .= $Region."\t";
            
             for($i=$fixstart;$i<=$fixend;$i++){
                 $schema_insert .= $values[$i]['dealcount']."\t";
                 $schema_insert .= $values[$i]['sumamount']."\t";
                 
             }
              $schema_insert .= "\n"; 
        
    }
     print(trim($schema_insert));
     print "\n";
}
 mysql_close();
?>
