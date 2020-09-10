<?php
error_reporting(-1);
$con = mysql_connect("208.91.198.19","vcint6bu_user1","venture123")or die( mysql_error() );
$dcnx = mysql_select_db("vcint6bu_mca",$con);



exit;

include 'Classes/PHPExcel/IOFactory.php';
$filePath = $_SERVER[ 'DOCUMENT_ROOT' ] . '/vi_info/vi/cfs-old/media/plstandard/';
$localpath = $_SERVER[ 'DOCUMENT_ROOT' ] . "/vi_file_upload/";
$sel = "SELECT Company_Id, FCompanyName
        FROM cprofile
        WHERE 1=1
        LIMIT 0,2500
        ";
$res = mysql_query( $sel ) or die( mysql_error() );
$numrows = mysql_num_rows( $res );
$myarray = array();
$csvFileName = 'plstd_4.csv';
$out = fopen( $localpath.$csvFileName, 'w');
chmod( $localpath.$csvFileName, 0777);
fputcsv($out, array( 'Company Name', 'Excel', 'Excel Company Name' ), ',', '"');
if( $numrows > 0 ) {
    while( $result = mysql_fetch_array( $res ) ) {
        $companyID = $result[ 'Company_Id' ];
        $companyName = $result[ 'FCompanyName' ];
        if( !empty( $companyID ) ) {
            $fileurl = $filePath . 'PLStandard_' . $companyID . '.xls';
            if( file_exists( $fileurl ) ) {
                $objReader = PHPExcel_IOFactory::createReaderForFile( $fileurl );
                $objReader->setReadDataOnly(true);
                $objPHPExcel = $objReader->load( $fileurl );
                $data = $objPHPExcel->getSheet(0)->getCell('A3')->getValue();
                if( $companyName != $data ) {
                    fputcsv($out, array( $companyName, 'Yes', $data ), ',', '"');
                }
                $objPHPExcel->disconnectWorksheets();
                unset($objPHPExcel);
            } else {
                fputcsv($out, array( $companyName, 'No', '' ), ',', '"');
            }
        }
    }
} else {
}
fclose($out);
mysql_close($con);
?>

