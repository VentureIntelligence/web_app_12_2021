<?php include_once("../globalconfig.php"); ?>
<?php
ini_set('memory_limit', '2048M');
ini_set("max_execution_time", 10000);

?>
<?php
//session_save_path("/tmp");
//session_start();
require("../dbconnectvi.php");
$Db = new dbInvestments();



$keycheck = $_POST['allcompanyauto_sug'];
if($keycheck == 1){
    $sql=mysql_query("select PECompanyId from pecompanies");
    while($row = mysql_fetch_assoc($sql)){
        $json[] = $row['PECompanyId'];
   }
   //print_r(count($json));exit();
   $keyword=implode(',',$json);
  // echo json_encode($json );exit();

}
else
{
$keyword = $_POST['companyauto_sug'];
}
//echo $keyword;exit();

$sql="SELECT DISTINCT pec.pecompanyid     AS PECompanyId,
pec.companyname,
pec.industry,
i.industry          AS industry,
pec.sector_business AS sector_business,
pec.website,
pec.city,
pec.OtherLocation
FROM  pecompanies AS pec
JOIN industry AS i
  ON pec.industry = i.industryid
WHERE  pec.pecompanyid IN( $keyword )
";
//echo $sql;exit();
//execute query
$result = mysql_query($sql) or die(mysql_error());
 
  
$exportvalue = "Company Name,Industry,Sector,Website,Location";    
    
    
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
    
    $arrayData = array();
    while ($rows = mysql_fetch_array($result)) {
    $DataList = array();
    $col = 0;  
    
        if(isset($rows['PEId'])){
            $PEId = $rows['pecompanyid'];
        }else{
            $PEId = $rows[0];
        }
        //echo $PEId;exit();
        $companiessql = "SELECT DISTINCT pec.pecompanyid     AS PECompanyId,
        pec.companyname,
        pec.industry,
        i.industry          AS industry,
        pec.sector_business AS sector_business,
        pec.website,
        pec.city,
        pec.OtherLocation
        FROM  pecompanies AS pec
        JOIN industry AS i
          ON pec.industry = i.industryid
        WHERE  pec.pecompanyid =$PEId ";   
              //  echo $companiessql;exit();
        $result2 = mysql_query($companiessql) or die( mysql_error() );
        $row = mysql_fetch_row($result2);
        
       
        // T960
        
    
        if(in_array("Company Name", $rowArray))
            {
                $DataList[] = $row[1];
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
                $DataList[] = $row[7];
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
    header('Content-Disposition: attachment;filename="peinv_deals.csv"');
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


	