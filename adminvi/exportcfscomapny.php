<?php include_once("../globalconfig.php"); ?>
<?php
ini_set('memory_limit', '2048M');
ini_set("max_execution_time", 10000);

?>
<?php
//session_save_path("/tmp")peadd
//session_start();
require("../dbconnectvi.php");
$Db = new dbInvestments();



    $sql="SELECT b.Company_Id,b.SCompanyName,b.FCompanyName,i.IndustryName,s.SectorName,b.Website,city.city_name FROM plstandard a INNER JOIN cprofile b ON b.Company_Id = a.CId_FK LEFT JOIN balancesheet_new bsn on bsn.CID_FK = b.Company_Id AND a.FY = bsn.FY AND a.resulttype = bsn.resulttype INNER JOIN currencyrates as c on a.FY = c.FY INNER JOIN industries as i on i.Industry_Id=b.Industry LEFT JOIN sectors as s on s.Sector_Id=b.Sector LEFT JOIN city as city on city.city_id=b.City WHERE a.fy = (SELECT Max(fy) FROM plstandard WHERE cid_fk = a.cid_fk) AND a.resulttype = (SELECT Max(resulttype) FROM plstandard WHERE cid_fk = a.cid_fk AND fy = a.fy) AND b.ListingStatus IN (1,2,3,4) and b.Permissions1 IN (0,1) and b.UserStatus = 0 and b.Industry != '' and b.State != '' and a.fy != '' ORDER BY LEFT(a.FY,2) DESC, trim(b.SCompanyName) REGEXP '^[a-z]' DESC, trim(b.SCompanyName) ASC
";

// $keyword;exit();


//echo $sql;exit();
//execute query
$result = mysql_query($sql) or die(mysql_error());
 
  
$exportvalue = "Company ID,SCompany Name,FCompany Name,Industry,Sector,Website,Location";    
    
    
    $expval=explode(",",$exportvalue);
    //print_r($expval);exit();
    // end T960
    
    
    $searchString = "Undisclosed";
    $searchString = strtolower($searchString);
    $searchStringDisplay = "Undisclosed";
    
    $searchString1 = "Unknown";
    $searchString1 = strtolower($searchString1);
    
    $searchString2 = "Others";
    $searchString2 = strtolower($searchString2);
    
    $dbTypeSV='PE';
    
   
    $replace_array = array('\t','\n','<br>','<br/>','<br />','\r','\v');
    /** Error reporting */
    error_reporting(E_ALL);
    ini_set('display_errors', TRUE);
    ini_set('display_startup_errors', TRUE);
    date_default_timezone_set('Europe/London');
    if (PHP_SAPI == 'cli')
        die('This example should only be run from a Web Browser');
    /** Include PHPExcel */
    require_once '../PHPExcel_1.8.0_doc/Classes/PHPExcel.php';
    // Create new PHPExcel object
    $objPHPExcel = new PHPExcel();
    // Set document properties
    $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
                                 ->setLastModifiedBy("Maarten Balliauw")
                                 ->setTitle("Office 2007 XLSX Test Document")
                                 ->setSubject("Office 2007 XLSX Test Document")
                                 ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
                                 ->setKeywords("office 2007 openxml php")
                                 ->setCategory("Test result file");
    // Add some data
    $rowArray = $expval;
    //print_r($rowArray);exit();
    $objPHPExcel->getActiveSheet()
        ->fromArray(
            $rowArray,   // The data to set
            NULL,        // Array values with this value will not be set
            'A1'         // Top left coordinate of the worksheet range where
                         //    we want to set these values (default is A1)
        );
    
    $index = 2;
    
    $peidcheck = '';
    $dbTypeSV='PE';
    $arrayData = array();
    while ($row = mysql_fetch_array($result)) {
    $DataList = array();
    $col = 0;  
            if(in_array("Company ID", $rowArray))
            {
                $DataList[] = $row[0];
            }
            if(in_array("SCompany Name", $rowArray))
            {
                $DataList[] = $row[1];
            }
          
            if(in_array("FCompany Name", $rowArray))
            {
                $DataList[] = $row[2];
            }
            if(in_array("Industry", $rowArray))
            {
                $DataList[] = $row[3];
            }
            if(in_array("Sector", $rowArray))
            {
                $DataList[] = $row[4];
            }

         
            if(in_array("Website", $rowArray))
            {
                $DataList[] = $row[5];
            }
            if(in_array("Location", $rowArray))
            {
                $DataList[] = $row[6];
            }
                
        
        $arrayData[] = $DataList;
    
         
         $index++;
    }
    
    // T960
    $objPHPExcel->getActiveSheet()
                ->fromArray(
                    $arrayData,  // The data to set
                    NULL,        // Array values with this value will not be set
                    'A2'         // Top left coordinate of the worksheet range where
                                //    we want to set these values (default is A1)
                );
    
    
    $indexfortitle = $index + 5;
    $indexfortranche = $index + 7;
    
    $objPHPExcel->setActiveSheetIndex(0);
                
    
    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Simple');
    
    
    // T960 Changes
    $objPHPExcel->getActiveSheet()
        ->getStyle('A2:A2')
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    
    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    // Redirect output to a client’s web browser (Excel5)
    header('Content-type: text/csv');
    header('Content-Disposition: attachment;filename="cprofile.csv"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');
    // If you're serving to IE over SSL, then the following may be needed
    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
    header ('Pragma: public'); // HTTP/1.0
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');
    $objWriter->save('php://output');
exit();
    
		
//else
//	header( 'Location: http://www.ventureintelligence.in/pelogin.php' ) ;
mysql_close();
mysql_close($cnx);
?>


	