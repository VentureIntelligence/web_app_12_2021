<?php
include "../header.php";

require_once MODULES_DIR."cprofile.php";
$cprofile = new cprofile();

$cin = $_POST[ 'req_answer' ][ 'cin' ];
$file_type = $_POST[ 'req_answer' ][ 'file_type' ];
$companyDetails = $cprofile->getearnningsbycin( $cin, $file_type );
echo json_encode( $companyDetails );
?>