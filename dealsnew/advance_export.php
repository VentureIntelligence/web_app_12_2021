<?php

require_once "../dbconnectvi.php";
$Db = new dbInvestments();
//session_save_path("/tmp");
session_start();
include_once 'advExport_header.php';

$dbtype=$_POST['dbtypeValue'];
  require_once('aws.php');    // load logins
    require_once('aws.phar');

    use Aws\S3\S3Client;

    $client = S3Client::factory(array(
        'key'    => $GLOBALS['key'],
        'secret' => $GLOBALS['secret']
    ));
    
?>
