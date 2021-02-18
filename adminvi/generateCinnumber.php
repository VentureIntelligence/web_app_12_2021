<?php include_once("../globalconfig.php"); ?>
<?php
ini_set('max_execution_time', '600');
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
    $exportval='CompanyName,Cinno,Brandname,Target_companyname,Sector,Acquirer,Dates,Amount';
   
    $exportvalue=rtrim($exportval,',');
    $expval=explode(",",$exportvalue);
    $rowArray = $expval;

    $arrayData = array();
    $flag =''; 
    foreach( $cinId as $cin){
    //$pattern="^([L|U]{1})([0-9]{5})([A-Za-z]{2})([0-9]{4})([A-Za-z]{3})([0-9]{6})$";
    $pattern="/^([L|U]{1})([0-9]{5})([A-Za-z]{2})([0-9]{4})([A-Za-z]{3})([0-9]{6})$/";

      if(preg_match($pattern, $cin)){
        $brandsql="SELECT `SCompanyName` FROM `cprofile` WHERE `CIN`='".$cin."'";
        $companyrsbrand = mysql_query($brandsql);          
        $mybrandname=mysql_fetch_array($companyrsbrand);
        // get company by CIN
        $getcompanysql = "select PECompanyId,companyname from pecompanies where CINNo ='".$cin."'";
        $companyrs = mysql_query($getcompanysql);          
        //$myrow=mysql_fetch_array($companyrs);
        $num_rows = mysql_num_rows($companyrs);
        if($num_rows > 0)
        {
           
        while($myrow=mysql_fetch_array($companyrs)){
            $companyidarr[]=$myrow['PECompanyId'];
            $company=str_replace("'", " ", trim($myrow['companyname']));
            $companyname .= "Acquirer LIKE '".$company."' or ";
            }
            $companyname = trim($companyname,"or ");
        $acquirersql ="SELECT AcquirerId FROM acquirers WHERE $companyname";
        $acquirer= mysql_query($acquirersql);
        while($myacq=mysql_fetch_array($acquirer)){
        $acqarr[]=$myacq['AcquirerId'];
        }
        $companyid='';
                $acqval='';
               
        $companyid=implode(",",$companyidarr);
        $acqval=implode(",",$acqarr);
       
        $order = $order_status ? $order_status:'asc';
        $query_orderby = $order_query?$order_query : 'companyname';
                
        // if(count($myrow) > 0 && $myrow['PECompanyId']!=''){
           
               if($companyid =='' ){
                    $order1 ='ORDER  BY dealdate '.$order;
                }else{
                    $order1 ='ORDER  BY CASE WHEN c.pecompanyid IN ( '.$companyid.' ) THEN 1 ELSE 2 END,dealdate DESC,'.$query_orderby.' '.$order;
                }
                if($acqval !=""){
                    $acqvar=" ac.acquirerid IN ( ".$acqval." )";
                }else{
                    $acqvar="";
                }
                if($acqval !="" && $companyid !=''){
                    $orcond=" or ";
                }else{
                    $orcond="";
                }
                if($companyid !=''){
                $companyvar="  c.pecompanyid IN ( ".$companyid." )";
                }else{
                    $companyvar="";
                }
             
            $sql = "SELECT c.CINNo as companyName,c.CINNo as Cinno,c.companyname as BrandName,c.companyname as Target_company,sector_business AS sector_business,
            ac.acquirer,Date_format(dealdate, '%b-%Y') AS dates,peinv.amount
            FROM   acquirers AS ac, 
            mama AS peinv, 
            pecompanies AS c, 
            industry AS i 
            WHERE  dealdate BETWEEN '2004-1-01' AND CURDATE() 
            AND ac.acquirerid = peinv.acquirerid 
            AND c.industry = i.industryid 
            AND c.pecompanyid = peinv.pecompanyid 
            AND peinv.deleted = 0 
            AND c.industry != 15 
            AND ( $acqvar $orcond $companyvar )
            AND c.industry IN ( 49, 14, 9, 25, 
                                24, 7, 4, 16, 
                                17, 23, 3, 21, 
                                1, 2, 10, 54, 
                                18, 11, 66, 106, 
                                8, 12, 22 ) ".$order1;
            ///*AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) */
           
            $pers = mysql_query($sql);
            $flag = 0; 
            $companyidarr=array();
            $acqarr=array();
            $pedata=array();
            $cont=0;
            $number_rows = mysql_num_rows($pers);
            if($number_rows==0){
            while($rows1 = mysql_fetch_array($pers))
            {
                $pedata[$cont]=$rows1;
                $cont++;
            }  
            //echo count($pedata);exit();
            if(count($pedata) ==0)
            {
                $sql="SELECT `SCompanyName` as companyName ,`cin` as Cinno,`FCompanyName` FROM `cprofile` WHERE `CIN` ='".$cin."'";   
                $pers = mysql_query($sql);  
                $flag =1;
                
            }
        }
            }
                
            } else{
                $getcompanysql = "select PECompanyId,companyname from pecompanies where companyname LIKE '".$cin."'";
                $companyrs = mysql_query($getcompanysql);

                $number_rows = mysql_num_rows($companyrs);

                if($number_rows != 0)
                {
         
                while($myrow=mysql_fetch_array($companyrs)){
                    $companyidarr[]=$myrow['PECompanyId'];
                    $company=str_replace("'", " ", trim($myrow['SCompanyName']));
                    $companyname .= "Acquirer LIKE '".$company."' or ";
                   // $companyname .= "Acquirer LIKE '".trim($mybrandname['SCompanyName'])."%' or ";
                }
                $companyname = trim($companyname,"or ");
                $acquirersql ="SELECT AcquirerId FROM acquirers WHERE $companyname";
                $acquirer= mysql_query($acquirersql);
                while($myacq=mysql_fetch_array($acquirer)){
                    $acqarr[]=$myacq['AcquirerId'];
                }
                $companyid='';
                $acqval='';
                
                $companyid=implode(",",$companyidarr);
                $acqval=implode(",",$acqarr);
                $order = $order_status ? $order_status:'asc';
                $query_orderby = $order_query?$order_query : 'companyname';
                if($companyid == "" ){
                    $order1 ='ORDER  BY dealdate '.$order;
                }else{
                    $order1 ='ORDER  BY CASE WHEN c.pecompanyid IN ( '.$companyid.' ) THEN 1 ELSE 2 END,dealdate DESC,'.$query_orderby.' '.$order;
                }
                if($acqval !=""){
                    $acqvar=" ac.acquirerid IN ( ".$acqval." )";
                }else{
                    $acqvar="";
                }
                if($acqval !="" && $companyid !=''){
                    $orcond=" or ";
                }else{
                    $orcond="";
                }
                if($companyid !=''){
                $companyvar="  c.pecompanyid IN ( ".$companyid." )";
                }else{
                    $companyvar="";
                }
                
                $sql = "SELECT c.CINNo as companyName,c.CINNo as Cinno,c.companyname as BrandName,c.companyname as Target_company,sector_business AS sector_business,
                ac.acquirer,Date_format(dealdate, '%b-%Y') AS dates,peinv.amount
                 FROM   acquirers AS ac, 
            mama AS peinv, 
            pecompanies AS c, 
            industry AS i 
     WHERE  dealdate BETWEEN '2004-1-01' AND CURDATE() 
            AND ac.acquirerid = peinv.acquirerid 
            AND c.industry = i.industryid 
            AND c.pecompanyid = peinv.pecompanyid 
            AND peinv.deleted = 0 
            AND c.industry != 15 
            AND ( $acqvar $orcond $companyvar)
            AND c.industry IN ( 49, 14, 9, 25, 
                                24, 7, 4, 16, 
                                17, 23, 3, 21, 
                                1, 2, 10, 54, 
                                18, 11, 66, 106, 
                                8, 12, 22 ) ".$order1;
            ///*AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) */
           
            $pers = mysql_query($sql);  
            $flag =0;  
            $companyidarr=array();
        $acqarr=array();
        $cont=0; 
        
            }
        }
            if($num_rows == 0 ){
                $getcompanysql = "select PECompanyId,companyname from pecompanies where companyname LIKE '".trim($mybrandname['SCompanyName'])."'";
                $companyrs = mysql_query($getcompanysql);

                $number_rows = mysql_num_rows($companyrs);

                if($number_rows != 0)
                {
         
                while($myrow=mysql_fetch_array($companyrs)){
                    $companyidarr[]=$myrow['PECompanyId'];
                    $company=str_replace("'", " ", trim($myrow['SCompanyName']));
                    $companyname .= "Acquirer LIKE '".$company."' or ";
                   // $companyname .= "Acquirer LIKE '".trim($mybrandname['SCompanyName'])."%' or ";
                }
                $companyname = trim($companyname,"or ");
                $acquirersql ="SELECT AcquirerId FROM acquirers WHERE $companyname";
                $acquirer= mysql_query($acquirersql);
                while($myacq=mysql_fetch_array($acquirer)){
                    $acqarr[]=$myacq['AcquirerId'];
                }
                $companyid='';
                $acqval='';
                
                $companyid=implode(",",$companyidarr);
                $acqval=implode(",",$acqarr);
                $order = $order_status ? $order_status:'asc';
                $query_orderby = $order_query?$order_query : 'companyname';
                if($companyid == "" ){
                    $order1 ='ORDER  BY dealdate '.$order;
                }else{
                    $order1 ='ORDER  BY CASE WHEN c.pecompanyid IN ( '.$companyid.' ) THEN 1 ELSE 2 END,dealdate DESC,'.$query_orderby.' '.$order;
                }
                if($acqval !=""){
                    $acqvar=" ac.acquirerid IN ( ".$acqval." )";
                }else{
                    $acqvar="";
                }
                if($acqval !="" && $companyid !=''){
                    $orcond=" or ";
                }else{
                    $orcond="";
                }
                if($companyid !=''){
                $companyvar="  c.pecompanyid IN ( ".$companyid." )";
                }else{
                    $companyvar="";
                }
                
                $sql = "SELECT c.CINNo as companyName,c.CINNo as Cinno,c.companyname as BrandName,c.companyname as Target_company,sector_business AS sector_business,
                ac.acquirer,Date_format(dealdate, '%b-%Y') AS dates,peinv.amount
                 FROM   acquirers AS ac, 
            mama AS peinv, 
            pecompanies AS c, 
            industry AS i 
     WHERE  dealdate BETWEEN '2004-1-01' AND CURDATE() 
            AND ac.acquirerid = peinv.acquirerid 
            AND c.industry = i.industryid 
            AND c.pecompanyid = peinv.pecompanyid 
            AND peinv.deleted = 0 
            AND c.industry != 15 
            AND ( $acqvar $orcond $companyvar)
            AND c.industry IN ( 49, 14, 9, 25, 
                                24, 7, 4, 16, 
                                17, 23, 3, 21, 
                                1, 2, 10, 54, 
                                18, 11, 66, 106, 
                                8, 12, 22 ) ".$order1;
            ///*AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) */
           
            $pers = mysql_query($sql);  
           
            $flag =0;  
            $companyidarr=array();
        $acqarr=array();
        $cont=0;
            // while($rows1 = mysql_fetch_array($pers))
            // {
            //     $pedata[$cont]=$rows1;
            //     $cont++;
            // }  
            // //echo count($pedata);exit();
            // if(count($pedata) ==0)
            // {
            //     $sql="SELECT `SCompanyName` as companyName ,`cin` as Cinno,`FCompanyName` FROM `cprofile` WHERE `SCompanyName` LIKE '".trim($mybrandname['SCompanyName'])."'";   
            //     $pers = mysql_query($sql);  
            //     $flag =1;
                
            // }
       
            }
           
            }
            if($number_rows == 0 && $num_rows == 0)
            {
                if(preg_match($pattern, $cin)){
                $sql="SELECT `FCompanyName` as companyName ,`cin` as Cinno,`SCompanyName` FROM `cprofile` WHERE `CIN` ='".$cin."'";   
                }else{
                    $sql="SELECT `FCompanyName` as companyName ,`cin` as Cinno,`SCompanyName` FROM `cprofile` WHERE `SCompanyName` ='".$cin."'";  
                }
                $pers = mysql_query($sql);  
                $flag =1; 
            }
          //  echo $sql."<br>";
           
            while ($rows = mysql_fetch_array($pers)) {
                $DataList = array();  
               
                if(in_array("CompanyName", $rowArray))
                {
                       // echo $flag;

                if($flag == 1){
                    $DataList[] = $rows[0];
        
                }
                else{
                if($rows[0] != null && $rows[0] != '')
                {
                $query='SELECT `FCompanyName` FROM `cprofile` WHERE `CIN` ="'.$rows[0].'"' ;
                $queryResult = mysql_query($query) or die(mysql_error());
                while($row = mysql_fetch_array($queryResult))
                {
                
                $FCmpName =$row['FCompanyName'];
                }
                
                $value = $FCmpName;
                }
                else{
                $value = $rows[5];
                }
                $pefirm="PE Firm(s)";
                if(strpos($value,$pefirm)!==false){
                $DataList[] = $rows[3];
                }else{
                $DataList[] = $value;
                }
            }
            }
            if(in_array("Cinno",$rowArray))
            {
                if($flag == 1){
                    $DataList[] = $rows[1];
    
                   }
                   else{
                if($rows[1] == null && $rows[1] == '')
                {
                $query='SELECT `cin` FROM `cprofile` WHERE `SCompanyName` ="'.$rows[3].'"' ;
                $queryResult = mysql_query($query) or die(mysql_error());
                while($row = mysql_fetch_array($queryResult))
                {
                $cin =$row['cin'];
                }
                
                $DataList[] = $cin;
                }
                else{
                $DataList[] = $rows[1];
                }
            }
                //$DataList[] = $rows[6]; 
            }
            if(in_array("Brandname", $rowArray))
            {
             $pefirm="PE Firm(s)";
             if(strpos($rows[3],$pefirm)!==false){
             $DataList[] = $rows[3];
             }else{
             $DataList[] = $rows[5];
             }                      
            }
            if(in_array("Target_companyname", $rowArray))
            {
            $DataList[] = $rows[3];
            }
            if(in_array("Sector", $rowArray))
            {
            $DataList[] = $rows[4];
            }
            if(in_array("Acquirer", $rowArray))
            {
            $DataList[] = $rows[5];
            }
            if(in_array("Dates", $rowArray))
            {
            $DataList[] = $rows[6];
            }
            if(in_array("Amount", $rowArray))
            {
            $DataList[] = $rows[7];
            }
      
            $arrayData[] = $DataList;

            
            
            }
            
            //$sql = ""; 
            //$DataList=array();
            //echo $sql ."<br>";
        }            
       // exit();

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
            // $i = 0; 
            // $exportval='';
            // //$exportval.='BrandName'.',';
            // while($i<mysql_num_fields($pers)) 
            // { 
            // $meta=mysql_fetch_field($pers,$i); 
            // $exportval.= "".$meta->name.","; 
            // $i++; 
            // } 
            // $exportvalue=rtrim($exportval,',');
            // $expval=explode(",",$exportvalue);

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
