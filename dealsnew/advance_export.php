<?php
//session_save_path("/tmp");
include_once 'advExport_header.php';
include_once 'checklogin.php';

$dbtype=$_POST['dbtypeValue'];
  require_once('aws.php');    // load logins
    require_once('aws.phar');

    use Aws\S3\S3Client;

    $client = S3Client::factory(array(
        'key'    => $GLOBALS['key'],
        'secret' => $GLOBALS['secret']
    ));
    
?>
