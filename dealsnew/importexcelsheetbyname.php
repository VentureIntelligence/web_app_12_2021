<?php

//include 'vi_webapp/LeagueTables/simplexlsx.class.php';
include_once('../PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');

$uploadOk = 1;

//$username=$_REQUEST['username'];
if(isset($_FILES['leaguefilepath']))
{
     $file_array = explode(".", $_FILES["leaguefilepath"]["name"]); 
    // echo json_encode($file_array);exit();
      if($file_array[1] == "xls" || $file_array[1] == "xlsx" || $file_array[1] == "csv" )  
      {  
       $inputFile=$_FILES["leaguefilepath"]["tmp_name"];
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
echo rtrim($val , ',');
//print_r($data);
//$string = print_r($data,true);

        exit();
       // $object = $reader->load($_FILES["excel_file"]["tmp_name"]);
        

      }

   

}



?> 