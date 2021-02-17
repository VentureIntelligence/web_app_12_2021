<?php include_once("../globalconfig.php"); ?>
<?php

include_once('../PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
require("../dbconnectvi.php");
$Db = new dbInvestments();
$uploadOk = 1;

//$username=$_REQUEST['username'];
if(isset($_FILES['cinfilepath']))
{
     $file_array = explode(".", $_FILES["cinfilepath"]["name"]); 
    //echo json_encode($file_array);exit();
      if($file_array[1] == "xls" || $file_array[1] == "xlsx" || $file_array[1] == "csv" )  
      {  
       $inputFile=$_FILES["cinfilepath"]["tmp_name"];
        //echo $inputFile;exit();
       try {
         
       // PHPExcel_Settings::setZipClass(PHPExcel_Settings::PCLZIP);

        $inputFileType = PHPExcel_IOFactory::identify($inputFile);
        
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
       
        $objPHPExcel = $objReader->load($inputFile);
    } catch(Exception $e) {
      die($e->getMessage());
    }
                            $data = $objPHPExcel->getActiveSheet()->toArray();

for($i=1;$i< count($data);$i++){
  $val.=$data[$i][0];
  $val.=",";
  
}
       generateExcelinCinNo(rtrim($val , ','));
}
};


function generateExcelinCinNo($cinno)
{
    $cinId=explode(',',$cinno);

     $sql='SELECT `SCompanyName`,`FCompanyName` FROM `cprofile` WHERE `CIN` In ("'. implode('","', $cinId) .'")' ;
     //echo $sql;exit();
     $sqlResult = mysql_query($sql) or die(mysql_error());
     while($rows = mysql_fetch_array($sqlResult))
    {
        $FCompanyName .=$rows['SCompanyName']. ',';
    }
    $FcompanyId=rtrim($FCompanyName , ',');
    $FcmpnyName=explode(',',$FcompanyId);
    

     $sqlRes='select PECompanyId,companyname from pecompanies where CINNo In ("'. implode('","', $cinId) .'")' ;
     $sqlResResult = mysql_query($sqlRes) or die(mysql_error());
    while($rows = mysql_fetch_array($sqlResResult))
    {
        $PECompanyId .=$rows['PECompanyId']. ',';
        $cmpnyName .=$rows['companyname']. ',';
    }
        $companyId=rtrim($PECompanyId , ',');
        $acompanyname=rtrim($cmpnyName,',');

     if($acompanyname != '')
     {
         $acompanytype=explode(",",$acompanyname);

         if (count($acompanytype) > 0) {
          $acompanytypeSql = '';
             foreach ($acompanytype as $company) {
                $company=str_replace("'", " ", $company);

                $acompanytypeSql .= " Acquirer LIKE '" . $company . "' or  ";
                // $acompanytypeSql .= ' Acquirer LIKE "' . $company . '" or  ';
                
                }
             if ($acompanytypeSql != '') {
                 $acompanytype = ' ' . trim($acompanytypeSql, ' or ') . '';
             }
             //echo $acompanytype;exit();

         }
     }
     $sqlQuery="SELECT AcquirerId FROM acquirers WHERE $acompanytype " ;
     $sqlSelResult = mysql_query($sqlQuery) or die(mysql_error());
     while($row = mysql_fetch_array($sqlSelResult))
     {
         $AcquirerId .=$row['AcquirerId']. ',';
     }
     $AquireId=rtrim($AcquirerId , ',');
   //  echo $sqlQuery;exit();

     $sqlQueryResult="SELECT c.CINNo as cfs_companyName,c.companyname as companyname,sector_business AS sector_business,
      ac.acquirer,Date_format(dealdate, '%b-%Y') AS dates,peinv.amount
     FROM acquirers AS ac, mama AS peinv,pecompanies AS c,industry AS i
     WHERE dealdate BETWEEN '2004-1-01' AND '2020-10-31' AND ac.acquirerid = peinv.acquirerid 
     AND c.industry = i.industryid AND c.pecompanyid = peinv.pecompanyid 
     AND peinv.deleted = 0  AND c.industry != 15 
     AND (ac.acquirerid IN ($AquireId) or c.pecompanyid IN($companyId))
     AND c.industry IN (49,14,9,25,24,7,4,16,17,23,3,21,1,2,10, 54, 18,11,66,106,8,12,22 )
    ORDER BY CASE WHEN c.pecompanyid IN($companyId) THEN 1 ELSE 2 END, dealdate DESC, companyname asc";

     $generateSelResult = mysql_query($sqlQueryResult) or die(mysql_error());

     //echo $sqlQueryResult;exit();

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
            $i = 0; 
            $exportval='';
          //  $exportval.='parentcompanyName'.',';
            while($i<mysql_num_fields($generateSelResult)) 
            { 
            $meta=mysql_fetch_field($generateSelResult,$i); 
            $exportval.= "".$meta->name.","; 
            $i++; 
            } 
            $exportvalue=rtrim($exportval,',');
            $expval=explode(",",$exportvalue);

            //echo json_encode($expval);exit();

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
                             
            $rowArray = $expval;
            //echo json_encode($rowArray);exit();
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
                

                while ($rows = mysql_fetch_array($generateSelResult)) {
                                            // $FCompanyName1='';

                    $DataList = array();
                //  $companiessql="SELECT  c.companyname, sector_business AS sector_business,   ac.acquirer,Date_format(dealdate, '%b-%Y') AS dates,peinv.amount FROM acquirers AS ac, mama AS peinv, pecompanies AS c, industry AS i WHERE dealdate BETWEEN '2004-1-01' AND '2020-10-31' AND ac.acquirerid = peinv.acquirerid AND c.industry = i.industryid AND c.pecompanyid = peinv.pecompanyid AND peinv.deleted = 0 AND c.industry != 15 AND ( ac.acquirerid IN ( 2145,4823 ) or c.pecompanyid IN ( 3609,9881150 ) ) AND c.industry IN ( 49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22 ) ORDER BY CASE WHEN c.pecompanyid IN ( 3609,9881150 ) THEN 1 ELSE 2 END,dealdate DESC,companyname asc limit 2";

                //  $result2 = mysql_query($companiessql) or die( mysql_error() );
                //  $row = mysql_fetch_row($result2);

                   //echo json_encode($FcompanyId);exit();

                //    if(in_array("parentcompanyName", $rowArray))
                //    {
                //        $DataList[] = ;
                //    }
                if(in_array("cfs_companyName", $rowArray))
                {

                    if($rows[0] != null && $rows[0] != '')
                    {
                    $query='SELECT `SCompanyName` FROM `cprofile` WHERE `CIN` ="'.$rows[0].'"' ;
                    $queryResult = mysql_query($query) or die(mysql_error());
                    while($row = mysql_fetch_array($queryResult))
                        {

                            $FCmpName =$row['SCompanyName'];
                        }

                         $DataList[] = $FCmpName;
                    }
                    else{
                    $DataList[] = $rows[3];
                    }
                }
                   if(in_array("companyname", $rowArray))
                    {
                        $DataList[] = $rows[1];
                    }
                    if(in_array("sector_business", $rowArray))
                    {
                        $DataList[] = $rows[2];
                    }
                    if(in_array("acquirer", $rowArray))
                    {
                        $DataList[] = $rows[3];
                    }
                    if(in_array("dates", $rowArray))
                    {
                        $DataList[] = $rows[4];
                    }
                    if(in_array("amount", $rowArray))
                    {
                        $DataList[] = $rows[5];
                    }
           
                    $arrayData[] = $DataList;


                    }
                    

                    //print_r($arrayData);
                  //  exit();
                   
                    $objPHPExcel->getActiveSheet()
                    ->fromArray(
                        $arrayData,  // The data to set
                        NULL,        // Array values with this value will not be set
                        'A2'         // Top left coordinate of the worksheet range where
                                    //    we want to set these values (default is A1)
                    );

                    // Rename worksheet
                    $objPHPExcel->getActiveSheet()->setTitle('MA');

            
                    // T960 Changes
                    $objPHPExcel->getActiveSheet()
                        ->getStyle('A2:A2')
                        ->getAlignment()
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
                    $objPHPExcel->setActiveSheetIndex(0);

//                     $objPHPExcel->createSheet();


//                     $objPHPExcel->setActiveSheetIndex(1);
//                     $objPHPExcel->getActiveSheet()->setCellValue('A1', 'More data');

// // Rename 2nd sheet
// $objPHPExcel->getActiveSheet()->setTitle('Second sheet');

                    // Redirect output to a client’s web browser (Excel5)
                    header('Content-Type: application/vnd.ms-excel');
                    header('Content-Disposition: attachment;filename="peinv_deals.xls"');
                    header('Cache-Control: max-age=0');
                    // If you're serving to IE 9, then the following may be needed
                    header('Cache-Control: max-age=1');
                    // If you're serving to IE over SSL, then the following may be needed
                    header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
                    header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
                    header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
                    header ('Pragma: public'); // HTTP/1.0
                    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
                    $objWriter->save('php://output');
                    exit();

                    //		}
                    //else
                    //	header( 'Location: http://www.ventureintelligence.in/pelogin.php' ) ;
                    mysql_close();
                    mysql_close($cnx);
   
}
?>
