<?php
include "header.php";
if( isset( $_GET[ 'companyID' ] ) ) {
    if( $_GET[ 'excel_type' ] == 'pl' ) {
        if( $_GET[ 'format' ] == 's' ) {
            $zipName = 'PL_Standalone_' . $_GET[ 'companyID' ] . '.zip';
            if( file_exists( FOLDER_CREATE_PATH . '/plstandard/PLStandard_' . $_GET[ 'companyID' ] . '_NEW.xls' ) ){
                $files[] = FOLDER_CREATE_PATH . '/plstandard/PLStandard_' . $_GET[ 'companyID' ] . '_NEW.xls';
            }
            if( file_exists( FOLDER_CREATE_PATH . '/plstandard/PLStandard_' . $_GET[ 'companyID' ] . '_OLD.xls' ) ){
                $files[] = FOLDER_CREATE_PATH . '/plstandard/PLStandard_' . $_GET[ 'companyID' ] . '_OLD.xls';
            }
        } else {
            $zipName = 'PL_Consolidated_' . $_GET[ 'companyID' ] . '.zip';
            if( file_exists( FOLDER_CREATE_PATH . '/plstandard/PLStandard_' . $_GET[ 'companyID' ] . '_NEW_1.xls' ) ){
                $files[] = FOLDER_CREATE_PATH . '/plstandard/PLStandard_' . $_GET[ 'companyID' ] . '_NEW_1.xls';
            }
            if( file_exists( FOLDER_CREATE_PATH . '/plstandard/PLStandard_' . $_GET[ 'companyID' ] . '_OLD_1.xls' ) ){
                $files[] = FOLDER_CREATE_PATH . '/plstandard/PLStandard_' . $_GET[ 'companyID' ] . '_OLD_1.xls';
            }
        }
    } else {
        if( $_GET[ 'format' ] == 's' ) {
            $zipName = 'BS_Standalone_' . $_GET[ 'companyID' ] . '.zip';
            if( file_exists( FOLDER_CREATE_PATH . '/balancesheet_new/New_BalSheet_' . $_GET[ 'companyID' ] . '_NEW.xls' ) ){
                $files[] = FOLDER_CREATE_PATH . '/balancesheet_new/New_BalSheet_' . $_GET[ 'companyID' ] . '_NEW.xls';
            }
            if( file_exists( FOLDER_CREATE_PATH . '/balancesheet_new/New_BalSheet_' . $_GET[ 'companyID' ] . '_OLD.xls' ) ){
                $files[] = FOLDER_CREATE_PATH . '/balancesheet_new/New_BalSheet_' . $_GET[ 'companyID' ] . '_OLD.xls';
            }
        } else {
            $zipName = 'BS_Consolidated_' . $_GET[ 'companyID' ] . '.zip';
            if( file_exists( FOLDER_CREATE_PATH . '/balancesheet_new/New_BalSheet_' . $_GET[ 'companyID' ] . '_NEW_1.xls' ) ){
                $files[] = FOLDER_CREATE_PATH . '/balancesheet_new/New_BalSheet_' . $_GET[ 'companyID' ] . '_NEW_1.xls';
            }
            if( file_exists( FOLDER_CREATE_PATH . '/balancesheet_new/New_BalSheet_' . $_GET[ 'companyID' ] . '_OLD_1.xls' ) ){
                $files[] = FOLDER_CREATE_PATH . '/balancesheet_new/New_BalSheet_' . $_GET[ 'companyID' ] . '_OLD_1.xls';
            }
        }
    }
    /*echo '<pre>'; print_r( $files ); echo '</pre>';
    exit;*/
    # create new zip opbject
    $zip = new ZipArchive();
    # create a temp file & open it
    $tmp_file = tempnam('.','');
    $zip->open($tmp_file, ZipArchive::CREATE);
    # loop through each file
    foreach($files as $file){
        # download file
        $download_file = file_get_contents($file);
        #add it to the zip
        $zip->addFromString(basename($file),$download_file);
    }
    # close zip
    $zip->close();
    # send the file to the browser as a download
    header('Content-disposition: attachment; filename=' . $zipName);
    header('Content-type: application/zip');
    readfile($tmp_file);
    unlink($tmp_file);
}    
?>
