<?php

require("../dbconnectvi.php");
    $Db = new dbInvestments();
    $filing_id = $_GET['delete'];
    $companyrs = mysql_query("select file_name from companies_filing_files where id = $filing_id");
    $result = mysql_fetch_assoc($companyrs);
    $file = "uploadmamafiles/".$result['file_name'];
    if($result['file_name']!='')
    {
        $currentdir=getcwd();
        //echo "<br>Current Diretory=" .$currentdir;
        $curdir =  str_replace("adminvi","",$currentdir);
        //echo "<br>*****************".$curdir;
        $target = $curdir . "/uploadfilingfiles/" .$result['file_name'];
        unlink($target);
        
    }
    if (!(file_exists($file)))
    {
       $companyrs = mysql_query("delete from companies_filing_files where id = $filing_id");
    }
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
?>