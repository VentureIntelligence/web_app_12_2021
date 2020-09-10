<?php
require 'vendor/autoload.php';
include "../header.php";

require_once MODULES_DIR."cprofile.php";
require_once MODULES_DIR."plstandard.php";
require(dirname(__FILE__).$dir."/class.excelgenerate.php");

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;

$cprofile = new cprofile();
$plstandard = new plstandard();
$Excelgenerate = new Excelgenerate();

// Excel column styles are defined.
$companyStyle = array( 
    'font'  => array( 'bold' => true ) 
);
$boldStyle = array( 
    'font'  => array( 'bold' => true ),
    'borders' => array(
        'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
    ) 
);
$boldWFill = array( 
    'fill' => array( 'fillType' => Fill::FILL_SOLID, 'color' => array('rgb' => 'AAAAAA' ) ),
    'font'  => array( 'bold'  =>  true ),
    'borders' => array(
        'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
    )
);
$defaultStyle = array( 
    'borders' => array(
        'outline' => array( 'borderStyle' => Border::BORDER_THIN ),
    ) 
);
$companyStyleEarning = array( 
    'font'  => array( 'bold' => false ) 
);
$company_id = $_POST[ 'company_cid' ];
$result_type = $_POST[ 'result_type' ];
foreach( $_POST[ 'fy' ] as $key => $fy ) {
	$plstandard->updateEarnings( $company_id, $fy, $_POST[ 'binr' ][ $key ], $_POST[ 'dinr' ][ $key ], $result_type );
}
$plDatas = $plstandard->getpldata( $company_id, $result_type );

$PLStandard  = "plstandard";
$Dir = FOLDER_CREATE_PATH.$PLStandard;
$Target_Path = $Dir.'/';
if( $result_type == 0 ) {
	$UploadedNewFilePath = $Target_Path."PLStandard_".$company_id.".xls";
	//$UploadedOldFilePath = $Target_Path."PLStandard_".$company_id."_OLD.xls";	
} else {
	$UploadedNewFilePath = $Target_Path."PLStandard_".$company_id."_1.xls";
	//$UploadedOldFilePath = $Target_Path."PLStandard_".$company_id."_OLD_1.xls";	
}


if(file_exists($UploadedNewFilePath)) {
	$inputFileType = IOFactory::identify($UploadedNewFilePath);
	$reader = IOFactory::createReader($inputFileType);
	$spreadsheet = $reader->load($UploadedNewFilePath);
	$dataSheet = $spreadsheet->getActiveSheet()->toArray(null, true, true, true);
	$worksheet = $spreadsheet->getActiveSheet();
	if( !empty( $dataSheet ) ) {
		$YearCount = count($dataSheet[6]) - 1;	
	} else {
		$YearCount = 0;
	}
}

/*if(file_exists($UploadedOldFilePath)) {
	$inputFileType1 = IOFactory::identify($UploadedOldFilePath);
	$reader1 = IOFactory::createReader($inputFileType1);
	$spreadsheet1 = $reader1->load($UploadedOldFilePath);
	$dataSheet1 = $spreadsheet1->getActiveSheet()->toArray(null, true, true, true);
	$worksheet1 = $spreadsheet1->getActiveSheet();
	if( !empty( $dataSheet1 ) ) {
		$YearCount1 = count($dataSheet1[6]) - 1;
	} else {
		$YearCount1 = 0;
	}
}*/
/*if( $result_type == 0 ) {
	$DINRIndex = 23;
	$BINRIndex = 22;
} else {
	$DINRIndex = 25;
	$BINRIndex = 24;
} */
if( $result_type == 0 ) {
	if(($dataSheet[10][A])=="Cost of materials consumed"){
		$DINRIndex = 31;
		$BINRIndex = 30;
	}else{
		$DINRIndex = 23;
		$BINRIndex = 22;
	}
} else {
	if(($dataSheet[10][A])=="Cost of materials consumed"){
		$DINRIndex = 33;
		$BINRIndex = 32;
	}else{
		$DINRIndex = 25;
		$BINRIndex = 24;
	}
} 

$excelIndex = $Excelgenerate->createColumnsArray( 'BZ' );
foreach( $plDatas as $pldata ) {
	$dbFY = 'FY'.$pldata[ 'FY' ];
	$DINR = $pldata[ 'DINR' ];
	$BINR = $pldata[ 'BINR' ];
	for( $i = 0; $i <= $YearCount; $i++ ) {
		if( $i != 0 ) {
			if( $dataSheet[ 6 ][ $excelIndex[ $i ] ] == $dbFY ) {
				try {
					$worksheet->setCellValue( $excelIndex[ $i ] . $DINRIndex, $DINR )->getStyle( $excelIndex[ $i ] . $DINRIndex )->applyFromArray( $companyStyleEarning );
					$worksheet->setCellValue( $excelIndex[ $i ] . $BINRIndex, $BINR )->getStyle( $excelIndex[ $i ] . $BINRIndex )->applyFromArray( $companyStyleEarning );
				} catch( Exception $e ) {
					echo $e->getMessage();
				}
			}	
		}
	}
	/*for( $j = 0; $j <= $YearCount1; $j++ ) {
		if( $j != 0 ) {
			if( $dataSheet1[ 6 ][ $excelIndex[ $j ] ] == $dbFY ) {
				try {
					$worksheet1->setCellValue( $excelIndex[ $j ] . $DINRIndex, $DINR )->getStyle( $excelIndex[ $j ] . $DINRIndex )->applyFromArray( $boldStyle );
					$worksheet1->setCellValue( $excelIndex[ $j ] . $BINRIndex, $BINR )->getStyle( $excelIndex[ $j ] . $BINRIndex )->applyFromArray( $boldStyle );
				} catch( Exception $e ) {
					echo $e->getMessage();
				}
			}	
		}
	}*/
}
try {
	if( !empty( $dataSheet ) ) {
		$writer = new Xlsx( $spreadsheet );
		try {
			if( $result_type == 0 ) {
				$writer->save( $Target_Path."PLStandard_".$company_id.".xls" );
			} else {
				$writer->save( $Target_Path."PLStandard_".$company_id."_1.xls" );
			}
		} catch( Exception $e ) {
			echo $e->getMessage();
		}
	}
	/*if( !empty( $dataSheet1 ) ) {
		$writer1 = new Xlsx( $spreadsheet1 );
		try {
			if( $result_type == 0 ) {
				$writer1->save( $Target_Path."PLStandard_".$company_id."_OLD.xls" );
			} else {
				$writer1->save( $Target_Path."PLStandard_".$company_id."_OLD_1.xls" );
			}
		} catch( Exception $e ) {
			echo $e->getMessage();
		}
	}*/
} catch( Exception $e ) {
	echo $e->getMessage();
}
?>