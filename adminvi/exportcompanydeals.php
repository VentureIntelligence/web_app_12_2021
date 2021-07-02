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
   $keyword=implode(',',$json);
  // echo json_encode($json );exit();

}
else
{
$keyword = $_POST['companyauto_sug'];
}
//echo $keyword;exit();

$sql="SELECT Distinct pe.pecompanyid                                     AS PECompanyId,
pec.companyname,
pec.industry,
pe.dates                                           AS dates,
i.industry                                         AS industry,
pec.sector_business                                AS sector_business,
amount,
pe.amount_inr,
round,
s.stage,
stakepercentage,
Date_format(dates, '%b-%Y')                        AS dealperiod,
pec.website,
pec.city,
pec.region,
pe.peid,
pe.comment,
pe.moreinfor,
hideamount,
hidestake,
pe.stageid,
spv,
pec.regionid,
agghide,
pe.exit_status,
(SELECT Group_concat(inv.investor ORDER BY investor='others' SEPARATOR
        ', ')
 FROM   peinvestments_investors AS peinv_inv,
        peinvestors AS inv
 WHERE  peinv_inv.peid = pe.peid
        AND inv.investorid = peinv_inv.investorid) AS Investor,
(SELECT Count(inv.investor)
 FROM   peinvestments_investors AS peinv_inv,
        peinvestors AS inv
 WHERE  peinv_inv.peid = pe.peid
        AND inv.investorid = peinv_inv.investorid) AS Investorcount
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
WHERE  pec.pecompanyid IN( $keyword )
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
GROUP  BY pe.pecompanyid ";
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
            $PEId = $rows['PEId'];
        }else{
            $PEId = $rows[15];
        }
        
        $companiessql = "select Distinct pe.PEId,pe.PEId, pec.OtherLocation, pe.PECompanyID, pe.StageId, pec.countryid, pec.industry, pec.companyname, i.industry,pec.sector_business,amount,round,s.stage, it.InvestorTypeName ,stakepercentage,DATE_FORMAT(dates,'%b-%y') as dealperiod, pec.website,pec.city,r.Region, MoreInfor,hideamount,hidestake,c.country,c.country, Link,pec.RegionId,Valuation,FinLink, Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple, listing_status,Exit_Status,SPV,AggHide,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pe.Amount_INR, pe.Company_Valuation_pre, pe.Revenue_Multiple_pre, pe.EBITDA_Multiple_pre, pe.PAT_Multiple_pre, pe.Company_Valuation_EV, pe.Revenue_Multiple_EV, pe.EBITDA_Multiple_EV, pe.PAT_Multiple_EV, pe.Total_Debt, pe.Cash_Equ, pec.yearfounded,pec.state,pec.CINNo from peinvestments as pe
                LEFT JOIN pecompanies as pec
                ON pec.PEcompanyID = pe.PECompanyID
                LEFT JOIN industry as i
                ON pec.industry = i.industryid
                LEFT JOIN stage as s
                ON pe.StageId=s.StageId
                LEFT JOIN country as c
                ON c.countryid=pec.countryid
                LEFT JOIN region as r
                ON r.RegionId=pec.RegionId OR (pec.RegionId=0 and r.RegionId=1)
                LEFT JOIN investortype as it ON it.InvestorType = pe.InvestorType 
                where pe.Deleted=0 and pec.industry !=15 and pe.PEId=".$PEId." AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE  hide_pevc_flag =1 ) order by companyname";
        
               // echo $companiessql;exit();
        $result2 = mysql_query($companiessql) or die( mysql_error() );
        $row = mysql_fetch_row($result2);
        
       
        // T960
        
    
        if(in_array("Company Name", $rowArray))
            {
                $DataList[] = $row[7];
            }
          
           
            if(in_array("Industry", $rowArray))
            {
                $DataList[] = $row[8];
            }
            if(in_array("Sector", $rowArray))
            {
                $DataList[] = $row[9];
            }

         
            if(in_array("Website", $rowArray))
            {
                $DataList[] = $row[16];
            }
            if(in_array("Location", $rowArray))
            {
                $DataList[] = $row[2];
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


	