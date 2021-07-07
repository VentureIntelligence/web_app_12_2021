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


$keyword = $_POST['allcompanyauto_sug'];
//echo $keyword;exit();
if($keyword =="")
{
$keycheck = $_POST['companyauto_sug'];
}
//echo $keycheck;exit();
if($keycheck == "pe"){
    $sql="SELECT DISTINCT pe.PECompanyId,pec.companyname,pec.industry,  i.industry,pec.sector_business                                AS sector_business,
    pec.website,
    pec.city FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s , peinvestments_investors AS peinv , peinvestors AS inv WHERE dates between '1998-7-01' and '2021-7-01' and pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15 AND r.RegionId = pec.RegionId and pec.companyname NOT LIKE 'Undisclosed%' and pec.companyname NOT LIKE 'Unknown%' and pec.companyname NOT LIKE 'Others%' AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ORDER BY pec.PECompanyId";
   }
else if($keycheck == "angel"){
    $sql="SELECT DISTINCT pec.PECompanyId,pec.companyname,
    pec.industry,
    i.industry                                         AS industry,
    pec.sector_business                                AS sector_business,
    pec.website,
    pec.city FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r WHERE DealDate between '1998-7-01' and '2021-7-01' and pec.PECompanyId = pe.InvesteeId AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15 AND r.RegionId = pec.RegionId and pec.companyname NOT LIKE '%Undisclosed%' and pec.companyname NOT LIKE '%Unknown%' and pec.companyname NOT LIKE '%Others%' AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ORDER BY pec.PECompanyId";
}
else if($keycheck == "incubatee")
{
    $sql="SELECT DISTINCT pec.PECompanyId, pec.companyname,pec.industry,pec.sector_business,pec.website,pec.city
    FROM incubatordeals AS pe join pecompanies as pec on pec.PECompanyId=pe.IncubateeId join  incubators as inc on inc.IncubatorId=pe.IncubatorId join  industry i on  pec.industry = i.industryid
    WHERE   pe.Deleted=0 
    GROUP by inc.IncubatorId order by pec.PECompanyId";

}
else
{
    $sql="SELECT Distinct pe.pecompanyid    AS PECompanyId,
pec.companyname,
pec.industry,
i.industry                                         AS industry,
pec.sector_business                                AS sector_business,
pec.website,
pec.city
FROM   peinvestments AS pe
JOIN pecompanies AS pec
  ON pec.pecompanyid = pe.pecompanyid
JOIN peinvestments_investors AS peinv_inv
  ON peinv_inv.peid = pe.peid
JOIN peinvestors AS inv
  ON inv.investorid = peinv_inv.investorid
JOIN industry AS i
  ON pec.industry = i.industryid
JOIN stage AS s
  ON s.stageid = pe.stageid
WHERE  pec.pecompanyid IN( $keyword  )
AND dates BETWEEN '1998-1-01' AND '2021-7-31'
AND pe.deleted = 0
AND pec.industry != 15
AND pe.peid NOT IN (SELECT peid
                    FROM   peinvestments_dbtypes AS db
                    WHERE  dbtypeid = 'SV'
                           AND hide_pevc_flag = 1)
AND pec.industry IN ( 49, 14, 9, 25,
                      24, 7, 4, 16,
                      17, 23, 3, 21,
                      1, 2, 10, 54,
                      18, 11, 66, 106,
                      8, 12, 22 )
GROUP  BY pe.PECompanyId 
";
}
//echo $keyword;exit();


//echo $sql;exit();
//execute query
$result = mysql_query($sql) or die(mysql_error());
 
  
$exportvalue = "Company ID,Company Name,Industry,Sector,Website,Location";    
    
    
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


	