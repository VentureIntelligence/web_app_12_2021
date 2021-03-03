<?php

error_reporting(E_ALL);
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
$count = 0;
$sql = $_POST['exporttablesql'];
$sql = stripcslashes($sql);
// $sql = stripcslashes($sql);
//echo $sql;
if(!isset($_SESSION['UserNames']))
   {
           header('Location:../pelogin.php');
   }
   else
   {
if ($sql != '') {

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
    $tblCont = '';
    $pintblcnt = '';

    $pintblcnt .= '<table class="testTable1" border="1" >';
    //$pintblcnt .= '<tr><th style="text-align:center">INDUSTRY</th><tr>';

    //tblCont = '<thead>';
    $tblCont .='<tr><th style="text-align:center">INDUSTRY</th>';
    for ($i = 0; $i < count($Years); $i++) {
        $tblCont .='<th style="text-align:center" colspan="2">' . $Years[$i] . '</th>';
    }
    $tblCont .='</tr>';
    $tblCont .='<tr><th style="text-align:center"></th>';
    for ($i = 0; $i < count($Years); $i++) {
        if ($i == 0) {
            //$pintblcnt .='<tr><th style="text-align:center">&nbsp;</th><tr>';
        }
        $tblCont .='<th style="text-align:center">DEAL</th><th style="text-align:center">AMOUNT</th>';
    }
    $tblCont .='</tr>';

    $val = array();

    for ($i = 0; $i < count($arrhead); $i++) {
        $tblCont .= '<tr><td><b>' . $arrhead[$i] . '</b></td>';
        //$pintblcnt .='<tr><th>' . $arrhead[$i] . '</th><tr>';

        //var flag =0;
        for ($j = 0; $j < count($Years); $j++) {
            $deal = '';
            $amt = '';
            $val = $dataArray[$arrhead[$i]][$Years[$j]];
            if ($val) {
                $deal = $val['0'];
                $amt = $val['1'];
            }
            /* if(flag==1)
              tblCont = tblCont + '<td>'+deal+'</td><td>'+amt+'</td></tr>';
              else */
            $tblCont .= '<td>' . $deal . '</td><td>' . $amt . '</td>';
            //flag =1;
        }
        $tblCont .= '<tr>';
        //console.log(dataArray[arrhead[i]]);
    }

    $pintblcnt .= $tblCont.' </table>';
    
    header('Content-Type: application/force-download');
    header('Content-disposition: attachment; filename=ExportHtmlToExcel.xls');
    header("Pragma: ");
    header("Cache-Control: ");
    echo $pintblcnt;
}
    
mysql_close();
    mysql_close($cnx);
}
    ?>