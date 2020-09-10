<?php

error_reporting(E_ALL);

require_once("../dbconnectvi.php");
$Db = new dbInvestments();
require_once 'Classes/PHPExcel.php';
$count = 0;
$sql = $_POST['exporttablesql'];
$type = $_POST['type'];
$sql = urldecode($sql);
$sql = stripcslashes($sql);
// $sql = stripcslashes($sql);
//echo $sql;
//exit();
if ($sql != '') {

        if ($type == 1) {

            $res = @mysql_query($sql) or die(mysql_error());
            $data = array();
            while ($row = @mysql_fetch_assoc($res)) {
                foreach ($row as $col => $val) {
                    $data[$count][] = $val;
                }
                $count++;
            }

            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);

            $objPHPExcel->getActiveSheet()->setTitle('PE_by_Year');
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Year');
            $objPHPExcel->getActiveSheet()->setCellValue('B1', 'No. of Deals');
            $objPHPExcel->getActiveSheet()->setCellValue('C1', 'Amount');
            $objPHPExcel->getActiveSheet()->getStyle('B1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $objPHPExcel->getActiveSheet()->getStyle('C1')->getFont()->setBold(true);
            for ($i = 0; $i < count($data); $i++) {

                $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + 2), $data[$i][0]);
                $objPHPExcel->getActiveSheet()->setCellValue('B' . ($i + 2), $data[$i][1]);
                $objPHPExcel->getActiveSheet()->setCellValue('C' . ($i + 2), $data[$i][2]);
            }
            
            $filename = 'IPO_year.xls'; //save our workbook as this file name
        } 
        elseif ($type == 2 || $type == 5) {

            $res = @mysql_query($sql) or die(mysql_error());
            $data = array();
            while ($row = @mysql_fetch_assoc($res)) {

                foreach ($row as $col => $val) {
                    $data[$count][] = $val;
                }
                $count++;
            }
            echo '<pre>';
            //print_r($data);

            $dataArray = array();
            $arrhead = array();
            for ($i = 0; $i < count($data); $i++) {

                if (!in_array($data[$i][0], $arrhead)) {

                    $arrhead[] = $data[$i][0];
                }
            }
            //print_r($arrhead);
            //Get Years
            $Years = array();

            for ($i = 0; $i < count($data); $i++) {

                if (!in_array($data[$i][1], $Years)) {

                    $Years[] = $data[$i][1];
                }
            }

            //print_r($Years);

            for ($i = 0; $i < count($arrhead); $i++) {

                $tempArr = array();
                for ($j = 0; $j < count($data); $j++) {

                    $values = array();
                    if ($data[$j][0] == $arrhead[$i]) {

                        if ($data[$j][2]) {
                            $values[] = $data[$j][2];
                        } else {
                            $values[] = 0;
                        }

                        if ($data[$j][3]) {

                            $values[] = $data[$j][3];
                        } else {
                            $values[] = 0;
                        }

                        $tempArr[$data[$j][1]] = $values;
                    }
                }

                $dataArray[$arrhead[$i]] = $tempArr;
            }

            //print_r($dataArray);
            $column = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);

            $objPHPExcel->getActiveSheet()->setTitle('PE_by_Industry');
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'INDUSTRY');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', '');
            $objPHPExcel->getActiveSheet()->getColumnDimension('A1')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $letters = 1;
            for ($i = 0; $i < count($Years); $i++) {
                //echo "'".$column[$letters].($i+1).":".$column[$letters+1].($i+1)."'";
                //$objPHPExcel->getActiveSheet()->mergeCells("'".$column[$letters].($i+1).":".$column[$letters+1].($i+1)."'");
                $objPHPExcel->getActiveSheet()->setCellValue($column[$letters] . '1', $Years[$i]);
                $objPHPExcel->getActiveSheet()->getStyle($column[$letters] . '1')->getFont()->setBold(true);
                //$objPHPExcel->getActiveSheet()->mergeCells('B1:C1');
                $objPHPExcel->getActiveSheet()->mergeCells($column[$letters] . '1' . ":" . $column[$letters + 1] . '1');
                $objPHPExcel->getActiveSheet()->getStyle($column[$letters] . '1' . ":" . $column[$letters + 1] . '1')->getAlignment()->setHorizontal('center');

                $objPHPExcel->getActiveSheet()->setCellValue($column[$letters] . '2', 'Deal');
                $objPHPExcel->getActiveSheet()->setCellValue($column[$letters + 1] . '2', 'Amount');

                $letters+=2;
            }

            //$val = array();
            $ind = 3;
            $dealcount = 3;
            for ($i = 0; $i < count($arrhead); $i++) {

                $letters = 1;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + $ind), $arrhead[$i]);

                for ($j = 0; $j < count($Years); $j++) {
                    $deal = '';
                    $amt = '';
                    $val = $dataArray[$arrhead[$i]][$Years[$j]];

                    if ($val) {
                        $deal = $val[0];
                        $amt = $val[1];
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($column[$letters] . $dealcount, $deal);

                    $objPHPExcel->getActiveSheet()->setCellValue($column[$letters + 1] . $dealcount, $amt);


                    $letters+=2;
                }
                $dealcount++;
                //$letters+=1;
            }
            if($type==5){
            $filename = 'IPO_InvestorType.xls'; //save our workbook as this file name
            }else{
                $filename = 'IPO_industry.xls'; //save our workbook as this file name
            }
               
        }
        elseif ($type == 4) {

            $data = array();
            $sqlarr = explode('#', $sql);
            $rngarr = explode('#', $_POST['range']);

            for ($i = 0; $i < count($sqlarr); $i++) {
                $bdarr = array();
                if ($sqlarr[$i] != '') {
                    $sql = $sqlarr[$i];
                    $res = mysql_query($sql) or die(mysql_error());
                    while ($row = mysql_fetch_assoc($res)) {
                        $data[$count][] = $rngarr[$i];
                        foreach ($row as $col => $val) {
                            $data[$count][] = $val;
                        }
                        $count++;
                    }
                }
            }

            $dataArray = array();
            $arrhead = array();
            for ($i = 0; $i < count($data); $i++) {

                if (!in_array($data[$i][0], $arrhead)) {

                    $arrhead[] = $data[$i][0];
                }
            }
            //Get Years
            $Years = array();

            for ($i = 0; $i < count($data); $i++) {

                if (!in_array($data[$i][1], $Years)) {

                    $Years[] = $data[$i][1];
                }
            }

            //print_r($Years);

            for ($i = 0; $i < count($arrhead); $i++) {

                $tempArr = array();
                for ($j = 0; $j < count($data); $j++) {

                    $values = array();
                    if ($data[$j][0] == $arrhead[$i]) {

                        if ($data[$j][2]) {
                            $values[] = $data[$j][2];
                        } else {
                            $values[] = 0;
                        }

                        if ($data[$j][3]) {

                            $values[] = $data[$j][3];
                        } else {
                            $values[] = 0;
                        }

                        $tempArr[$data[$j][1]] = $values;
                    }
                }

                $dataArray[$arrhead[$i]] = $tempArr;
            }

            //print_r($dataArray);
            $column = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', 'AA', 'AB', 'AC', 'AD', 'AE', 'AF', 'AG', 'AH', 'AI', 'AJ', 'AK', 'AL', 'AM', 'AN', 'AO', 'AP', 'AQ', 'AR', 'AS', 'AT', 'AU', 'AV', 'AW', 'AX', 'AY', 'AZ', 'BA', 'BB', 'BC', 'BD', 'BE', 'BF', 'BG', 'BH');
            $objPHPExcel = new PHPExcel();
            $objPHPExcel->getActiveSheet()->getPageSetup()->setHorizontalCentered(true);

            $objPHPExcel->getActiveSheet()->setTitle('PE_by_Range');
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'RANGE');
            $objPHPExcel->getActiveSheet()->setCellValue('A2', '');
            $objPHPExcel->getActiveSheet()->getColumnDimension('A1')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
            $letters = 1;
            for ($i = 0; $i < count($Years); $i++) {
                //echo "'".$column[$letters].($i+1).":".$column[$letters+1].($i+1)."'";
                //$objPHPExcel->getActiveSheet()->mergeCells("'".$column[$letters].($i+1).":".$column[$letters+1].($i+1)."'");
                $objPHPExcel->getActiveSheet()->setCellValue($column[$letters] . '1', $Years[$i]);
                $objPHPExcel->getActiveSheet()->getStyle($column[$letters] . '1')->getFont()->setBold(true);
                //$objPHPExcel->getActiveSheet()->mergeCells('B1:C1');
                $objPHPExcel->getActiveSheet()->mergeCells($column[$letters] . '1' . ":" . $column[$letters + 1] . '1');
                $objPHPExcel->getActiveSheet()->getStyle($column[$letters] . '1' . ":" . $column[$letters + 1] . '1')->getAlignment()->setHorizontal('center');

                $objPHPExcel->getActiveSheet()->setCellValue($column[$letters] . '2', 'Deal');
                $objPHPExcel->getActiveSheet()->setCellValue($column[$letters + 1] . '2', 'Amount');

                $letters+=2;
            }

            //$val = array();
            $ind = 3;
            $dealcount = 3;
            for ($i = 0; $i < count($arrhead); $i++) {

                $letters = 1;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . ($i + $ind), $arrhead[$i]);

                for ($j = 0; $j < count($Years); $j++) {
                    $deal = '';
                    $amt = '';
                    $val = $dataArray[$arrhead[$i]][$Years[$j]];

                    if ($val) {
                        $deal = $val[0];
                        $amt = $val[1];
                    }

                    $objPHPExcel->getActiveSheet()->setCellValue($column[$letters] . $dealcount, $deal);

                    $objPHPExcel->getActiveSheet()->setCellValue($column[$letters + 1] . $dealcount, $amt);


                    $letters+=2;
                }
                $dealcount++;
                //$letters+=1;
            }
                $filename = 'IPO_Range.xls'; //save our workbook as this file name
            
        }
    }
   
    mysql_close();
    mysql_close($cnx);
   
    ob_end_clean();
    // Redirect output to a client’s web browser (Excel5)
    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    // If you're serving to IE 9, then the following may be needed
    header('Cache-Control: max-age=1');
    //save it to Excel5 format (excel 2003 .XLS file), change this to 'Excel2007' (and adjust the filename extension, also the header mime type)
    //if you want to save it as .XLSX Excel 2007 format
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    //force user to download the Excel file without writing it to server's HD
    $objWriter->save('php://output');
    exit;

?>