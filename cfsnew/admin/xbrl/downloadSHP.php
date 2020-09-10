<?php
include "../header.php";

require_once MODULES_DIR."xbrl2.php";
require_once MODULES_DIR."cprofile.php";
$runID = $_GET[ 'run_id' ];
$PLStandard  = "SHP";
$Dir = FOLDER_CREATE_PATH.$PLStandard;
$Target_Path = $Dir.'/';

$cprofile = new cprofile();
$xbrl2 = new xbrl2();
$fullList = $xbrl2->select( $runID );

    $file= $fullList[0]['SHP_link'];
    $filename= $fullList[0]['SHP_link'];
    $filenamearray = explode("_",$filename);
    $fileIDarray = explode(".",$filenamearray[1]);
    $where2 = "Company_Id =".$fileIDarray[0];
    $order="";
    $companyname = $cprofile->getCompanies($where2,$order);
    $filename=$companyname[$fileIDarray[0]].' SHP.xls';//die;
    $filename= str_replace(' ', '_', $filename);
    $file = $Target_Path.$file;
   
    header('Content-Description: File Transfer');
    header('Content-Type: application/xls');
    header('Content-Disposition: attachment; filename='.basename($filename));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
//echo json_encode( $fullList );
?>