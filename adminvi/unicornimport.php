<?php

/*include_once '../LeagueTables/db.php';
include_once('../PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');*/


include_once('../PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
    
require("../dbconnectvi.php");  
$Db = new dbInvestments();

//$uploadOk = 1;
    
if(isset($_FILES['unicornfilepath']))
{
    if($_FILES['unicornfilepath']['tmp_name'])
    {
        if(!$_FILES['unicornfilepath']['error'])
        {
            $target_dir = "importfiles/";
            $inputFile = $_FILES['unicornfilepath']['tmp_name'];

            $inputFilename = $_FILES['unicornfilepath']['name'];
            $name="Unicorntable";
            $extension = pathinfo($inputFilename, PATHINFO_EXTENSION);
            
            if($extension == 'XLS' || $extension == 'XLSX'|| $extension == 'xls' || $extension == 'xlsx'){

                        //Read spreadsheeet workbook
                        try {
                            $inputFileType = PHPExcel_IOFactory::identify($inputFile);
                            $objReader = PHPExcel_IOFactory::createReader($inputFileType);
                            $objPHPExcel = $objReader->load($inputFile);
                        } catch(Exception $e) {
                            die($e->getMessage());
                        }
                        $data = array($objPHPExcel->getActiveSheet()->toArray(null,true,true,true));
                        $rowcount=0;
                        if(count($data) <= 0){ ?>
                            <Br>
                            <div style="font-family: Verdana; font-size: 8pt">Problem in uploaded Excel as data not in proper format or no row has been added. Please check and uplaod again <a href="uploaddeals.php">Back to Upload</a></td></div>
                                    
                        <?php  
                      
                            exit();
                        }
                      
                        foreach($data[0] as $da){

                            if($da['A'] !=''){
                                $rowcount++;
                            }
                        }
                       
                        //Get worksheet dimensions
                        $sheet = $objPHPExcel->getSheet(0); 
                        $highestRow = $rowcount; 
                        $highestColumn = 'G';

                        $rowData = array();
                         mysql_query("TRUNCATE table unicorn_table_data");
                         
                        //Loop through each row of the worksheet in turn
                        for ($row = 2; $row <= $highestRow; $row++){ 
                             $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, "", TRUE, TRUE);
                            /*echo '<pre>';
                            print_r($rowData);
                            echo '</pre>';*/
                            $id=$rowData[0][0];
                            $company = $rowData[0][1];
                            $sector = $rowData[0][2];
                            $valuation = $rowData[0][3];
                            $entry = $rowData[0][4];
                            $location = $rowData[0][5];
                            $selectInvestor = $rowData[0][6];
                           // echo $company;
                            $insert_Query = "INSERT INTO `unicorn_table_data` (`id`, `company`, `sector`, `valuation`, `entry`, `location`, `selectInvestor`) 
                                                VALUES ('$id', '$company', '$sector', '$valuation', '$entry', '$location', '$selectInvestor');";

                                                
                                             //   echo $insert_Query; 
                                $insert_exec = mysql_query($insert_Query) or die ('Error updating database: '.mysql_error());

                        }
                        

                        echo "Success";


                    }

                    $target_file = $target_dir . $name.".".$extension;

                    move_uploaded_file($inputFile, $target_file);
           /* if($uploadOk != 0){

                if (move_uploaded_file($inputFile, $target_file)) {
                  
                    mysql_query("TRUNCATE table unicorn_table_data");
                    $xlsx = new SimpleXLSX($target_file);
                    echo $target_file;
                    echo $xlsx;
                     echo "check5";
            exit();
                    $dataleague = $xlsx->rows();

                    for($i=1;$i<count($dataleague); $i++){
                         //print_r($dataleague);
                        $company = (trim($dataleague[$i][1]) != "") ? trim($dataleague[$i][1]) : "";
                        $sector = (trim($dataleague[$i][2]) != "") ? trim($dataleague[$i][2]) : "";
                        $valuation = (trim($dataleague[$i][3]) != "") ? trim($dataleague[$i][3]) : "";
                        $entry = (trim($dataleague[$i][4]) != "") ? trim($dataleague[$i][4]) : "";
                        $location = (trim($dataleague[$i][5]) != "") ? trim($dataleague[$i][5]) : "";
                        $selectInvestor = (trim($dataleague[$i][6]) != "") ? trim($dataleague[$i][6]) : "";
                        
                        
                        $select_Query = "SELECT id FROM `unicorn_table_data` WHERE company='$company' AND sector='$sector' AND valuation='$valuation' AND entry='$entry' AND location='$location' AND selectInvestor='$selectInvestor'";
                        $exec_sel = mysql_query($select_Query);
                        $selcnt = mysql_num_rows($exec_sel);
                        if($selcnt == 0){
                            if((count($dataleague[$i]) == '10') || (count($dataleague[$i]) == '11')){
                                $insert_Query = "INSERT INTO `unicorn_table_data` (`id`, `company`, `sector`, `valuation`, `entry`, `location`, `selectInvestor`) 
                                                VALUES (NULL, '$company', '$sector', '$valuation', '$entry', '$location', '$selectInvestor')";
                                $insert_exec = mysql_query($insert_Query);
                            }
                        }
                    }

                    echo "Success";
                }   
            } */
        }
    }
}

?>