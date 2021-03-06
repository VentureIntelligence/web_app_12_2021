<?php
/**
 * Class Excelgenerate
 *
 * Processed XML field data's are passed and respective Excel is generated.
 * Excel is kept locally in box for future referrence
 * 
 *
 * 
 * Functions used plstdStandaloneExcelgenerate, plstdConsolidatedExcelgenerate, bsStandaloneExcelgenerate, bsConsolidatedExcelgenerate, createColumnsArray
 *
 * createColumnsArray - Excel column index generation based on the given template format
 * 
 * @author     Jagdeesh MV <jagadeesh@kutung.in>
 * @version    1.0
 * @created    20-07-2018
 */
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;

class Excelgenerate {
	
	function __construct() {
		# code...
	}

	// PL Standalone excel generate function
	public function plstdStandaloneExcelgenerate( $finalArray = '', $sfyYear = '', $cin = '', $type = '', $fyCheck = '' ) {
		global $logs;
		$errorReport = 0;
		$errorArray = array();
		$logs->logWrite( "PL Standalone Excel Generation process started" );

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
	    $excelIndex = $this->createColumnsArray( 'BZ' );
	    $spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
    	// Heading Creation for Excel sheet
    	$sheet->setCellValue('A1', '?? TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.')->getStyle('A1')->getAlignment()->setWrapText(true);
	    $sheet->setCellValue('A3', $finalArray[ 'Company name' ])->getStyle("A3")->applyFromArray( $companyStyle );
	    $sheet->setCellValue('A4', 'All Figures (unless otherwise specified) is in INR');
	    $sheet->setCellValue('A6', 'Particulars')->getStyle("A6")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A7', 'Operational Income')->getStyle("A7")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A8', 'Other Income')->getStyle("A8")->applyFromArray( $defaultStyle );
		$sheet->setCellValue('A9', 'Total Income')->getStyle("A9")->applyFromArray( $defaultStyle );
		$sheet->setCellValue('A10', 'Cost of materials consumed')->getStyle("A10")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A11', 'Purchases of stock-in-trade')->getStyle("A11")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A12', 'Changes in Inventories')->getStyle("A12")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A13', 'Employee benefit expense')->getStyle("A13")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A14', 'CSR expenditure')->getStyle("A14")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A15', 'Other Expenses')->getStyle("A15")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A16', 'Operational, Admin & Other Expenses')->getStyle("A16")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A17', 'Operating Profit')->getStyle("A17")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A18', 'EBITDA')->getStyle("A18")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A19', 'Interest')->getStyle("A19")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A20', 'EBDT')->getStyle("A20")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A21', 'Depreciation')->getStyle("A21")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A22', 'EBT before Exceptional Items')->getStyle("A22")->applyFromArray( $defaultStyle );
		$sheet->setCellValue('A23', 'Prior period/Exceptional /Extra Ordinary Items')->getStyle("A23")->applyFromArray( $defaultStyle );
		$sheet->setCellValue('A24', 'EBT')->getStyle("A24")->applyFromArray( $defaultStyle );
		$sheet->setCellValue('A25', 'Current tax')->getStyle("A25")->applyFromArray( $defaultStyle );
		$sheet->setCellValue('A26', 'Deferred tax')->getStyle("A26")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A27', 'Tax')->getStyle("A27")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A28', 'PAT')->getStyle("A28")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A29', 'EPS ')->getStyle("A29")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A30', '(Basic in INR)')->getStyle("A30")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A31', '(Diluted in INR)')->getStyle("A31")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A33', 'Foreign Exchange Earning and Outgo:')->getStyle("A33")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A34', 'Earning in Foreign Exchange')->getStyle("A34")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A35', 'Outgo in Foreign Exchange')->getStyle("A35")->applyFromArray( $defaultStyle );
	    $sheet->getColumnDimension('A')->setWidth(50);

	    $i = 0;
	    $index = 1;

	    $logs->logWrite( "PL Standalone Excel Loop enter" );
	    krsort( $finalArray[ 'Excel Data' ][ 'pl' ] );
	    // Looping throught the generated data from the XML.
	    foreach( $finalArray[ 'Excel Data' ][ 'pl' ] as $excelKey => $excelData ) {
	    	$keyVal = '01-01-'.$excelKey;
	    	if( $fyCheck[ $excelKey ] == '12-31' ) {
	    		$excelKey = (int)$excelKey;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3112' . $currentYear . ')';
	    	} else if( $fyCheck[ $excelKey ] == '06-30' ) {
				$excelKey = (int)$excelKey + 1;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3006' . $currentYear . ')';
	    	} else if( $fyCheck[ $excelKey ] == '09-30' ) {
				$excelKey = (int)$excelKey + 1;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3009' . $currentYear . ')';
	    	} else {
	    		$fy = 'FY'.date( 'y', strtotime( $keyVal ) );	
	    	}
	    	$sheet->setCellValue( $excelIndex[ $index ] . '6', $fy)->getStyle( $excelIndex[ $index ] . '6' )->applyFromArray( $boldStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '7', $excelData[ 'Operational Income' ] )->getStyle( $excelIndex[ $index ] . '7' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '8', $excelData[ 'Other Income' ] )->getStyle( $excelIndex[ $index ] . '8' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '9', $excelData[ 'Total Income' ] )->getStyle( $excelIndex[ $index ] . '9' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '10', $excelData[ 'Cost Of Materials Consumed' ] )->getStyle( $excelIndex[ $index ] . '10' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '11', $excelData[ 'Purchases Of Stock In Trade' ] )->getStyle( $excelIndex[ $index ] . '11' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '12', $excelData[ 'Changes In Inventories' ] )->getStyle( $excelIndex[ $index ] . '12' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '13', $excelData[ 'Employee Related Expenses' ] )->getStyle( $excelIndex[ $index ] . '13' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '14', $excelData[ 'CSR Expenditure' ] )->getStyle( $excelIndex[ $index ] . '14' )->applyFromArray( $defaultStyle );
			$sheet->setCellValue( $excelIndex[ $index ] . '15', $excelData[ 'Other Expenses' ] )->getStyle( $excelIndex[ $index ] . '15' )->applyFromArray( $defaultStyle );
			$sheet->setCellValue( $excelIndex[ $index ] . '16', $excelData[ 'Operational, Admin & Other Expenses' ] )->getStyle( $excelIndex[ $index ] . '16' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '17', $excelData[ 'Operating Profit' ] )->getStyle( $excelIndex[ $index ] . '17' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '18', $excelData[ 'EBITDA' ] )->getStyle( $excelIndex[ $index ] . '18' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '19', $excelData[ 'Interest' ] )->getStyle( $excelIndex[ $index ] . '19' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '20', $excelData[ 'EBDT' ] )->getStyle( $excelIndex[ $index ] . '20' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '21', $excelData[ 'Depreciation' ] )->getStyle( $excelIndex[ $index ] . '21' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '22', $excelData[ 'EBT before Exceptional Items' ] )->getStyle( $excelIndex[ $index ] . '22' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '23', $excelData[ 'Prior period/Exceptional /Extra Ordinary Items' ] )->getStyle( $excelIndex[ $index ] . '23' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '24', $excelData[ 'EBT' ] )->getStyle( $excelIndex[ $index ] . '24' )->applyFromArray( $defaultStyle );
			$sheet->setCellValue( $excelIndex[ $index ] . '25', $excelData[ 'CurrentTax' ] )->getStyle( $excelIndex[ $index ] . '25' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '26', $excelData[ 'DeferredTax' ] )->getStyle( $excelIndex[ $index ] . '26' )->applyFromArray( $defaultStyle );
			$sheet->setCellValue( $excelIndex[ $index ] . '27', $excelData[ 'Tax' ] )->getStyle( $excelIndex[ $index ] . '27' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '28', $excelData[ 'PAT' ] )->getStyle( $excelIndex[ $index ] . '28' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '29', '' )->getStyle( $excelIndex[ $index ] . '29' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '30', $excelData[ '(Basic in INR)' ] )->getStyle( $excelIndex[ $index ] . '30' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '31', $excelData[ '(Diluted in INR)' ] )->getStyle( $excelIndex[ $index ] . '31' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '33', '')->getStyle( $excelIndex[ $index ] . '33' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '34', $excelData[ 'Earning in Foreign Exchange' ] )->getStyle( $excelIndex[ $index ] . '34' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '35', $excelData[ 'Outgo in Foreign Exchange' ] )->getStyle( $excelIndex[ $index ] . '35' )->applyFromArray( $defaultStyle );
	    	$sheet->getColumnDimension( $excelIndex[ $index ] )->setWidth(20);
	    	$i++;
	    	$index++;
	    }
	    $logs->logWrite( "PL Standalone Excel Loop ends" );
	    try {
	        $writer = new Xlsx( $spreadsheet );
	        try {
	        	if( !file_exists( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] ) ) { // Check directory exists or create a directory in admin output folder
		        	try {
			        	if( mkdir( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] ) ) {
			        		$old = umask(0);
							chmod( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ], 0777 );
							umask($old);
						} else {
							$errorReport++;
							$errorArray[ $cin ]['common'][] = "Directory creation in server failed";
						}
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				if( $type == 'old' ) {
					$excelgentype = 'OLD';
				} else {
					$excelgentype = 'NEW';
				}
				$csvFile = dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] . '/' . $finalArray[ 'Company name' ] . '_PL_STANDALONE_' . $excelgentype . '.xlsx';
	            $writer->save( $csvFile ); // Save generated excel in folder
	            try {
	            	$old = umask(0);
					chmod( $csvFile , 0777 );
					umask($old);	
	            } catch( Exception $e ) {
	            	echo $e->getMessage();
	            }
	            
	            $logs->logWrite( "PL Standalone Excel Created" );    
	        } catch( Exception $e ) {
	        	$errorReport++;
	        	$errorArray[ $cin ]['common'][] = "PL Standalone Excel write failed";
	            //echo $e->getMessage(); 
	        }
	    } catch( Exception $e ) {
	    	$errorReport++;
	    	$errorArray[ $cin ]['common'][] = "Spreadsheet Plugin problem";
	        //echo $e->getMessage(); 
	    }
	    return array( 'error' => $errorReport, 'error_array' => $errorArray  );
	}

	// PL Consolidated excel generate function
	public function plstdConsolidatedExcelgenerate( $finalArray = '', $sfyYear = '', $cin = '', $type = '', $fyCheck = '' ) {
		global $logs;

		$errorReport = 0;
		$errorArray = array();
		$logs->logWrite( "PL Consolidated Excel Generation process started" );

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
	    $excelIndex = $this->createColumnsArray( 'BZ' );
	    $spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
    	// Heading Creation for Excel sheet
    	$sheet->setCellValue('A1', '?? TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.')->getStyle('A1')->getAlignment()->setWrapText(true);
	    $sheet->setCellValue('A3', $finalArray[ 'Company name' ])->getStyle("A3")->applyFromArray( $companyStyle );
	    $sheet->setCellValue('A4', 'All Figures (unless otherwise specified) is in INR');
	    $sheet->setCellValue('A6', 'Particulars')->getStyle("A6")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A7', 'Operational Income')->getStyle("A7")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A8', 'Other Income')->getStyle("A8")->applyFromArray( $defaultStyle );
		$sheet->setCellValue('A9', 'Total Income')->getStyle("A9")->applyFromArray( $defaultStyle );
		$sheet->setCellValue('A10', 'Cost of materials consumed')->getStyle("A10")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A11', 'Purchases of stock-in-trade')->getStyle("A11")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A12', 'Changes in Inventories')->getStyle("A12")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A13', 'Employee benefit expense')->getStyle("A13")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A14', 'CSR expenditure')->getStyle("A14")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A15', 'Other Expenses')->getStyle("A15")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A16', 'Operational, Admin & Other Expenses')->getStyle("A16")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A17', 'Operating Profit')->getStyle("A17")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A18', 'EBITDA')->getStyle("A18")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A19', 'Interest')->getStyle("A19")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A20', 'EBDT')->getStyle("A20")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A21', 'Depreciation')->getStyle("A21")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A22', 'EBT before Exceptional Items')->getStyle("A22")->applyFromArray( $defaultStyle );
		$sheet->setCellValue('A23', 'Prior period/Exceptional /Extra Ordinary Items')->getStyle("A23")->applyFromArray( $defaultStyle );
		$sheet->setCellValue('A24', 'EBT')->getStyle("A24")->applyFromArray( $defaultStyle );
		$sheet->setCellValue('A25', 'Current tax')->getStyle("A25")->applyFromArray( $defaultStyle );
		$sheet->setCellValue('A26', 'Deferred tax')->getStyle("A26")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A27', 'Tax')->getStyle("A27")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A28', 'PAT')->getStyle("A28")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A29', 'Profit (loss) of minority interest')->getStyle("A29")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A30', 'Total profit (loss) for period')->getStyle("A30")->applyFromArray( $defaultStyle );    
	    $sheet->setCellValue('A31', 'EPS ')->getStyle("A31")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A32', '(Basic in INR)')->getStyle("A32")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A33', '(Diluted in INR)')->getStyle("A33")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A35', 'Foreign Exchange Earning and Outgo:')->getStyle("A35")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A36', 'Earning in Foreign Exchange')->getStyle("A36")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A37', 'Outgo in Foreign Exchange')->getStyle("A37")->applyFromArray( $defaultStyle );
	    $sheet->getColumnDimension('A')->setWidth(50);
	    $i = 0;
	    $index = 1;
	    $logs->logWrite( "PL Consolidated Excel Loop enter" );
	    krsort( $finalArray[ 'Excel Data' ][ 'pl' ] );
	    // Looping throught the generated data from the XML.
	    foreach( $finalArray[ 'Excel Data' ][ 'pl' ] as $excelKey => $excelData ) {
	    	$keyVal = '01-01-'.$excelKey;
	    	if( $fyCheck[ $excelKey ] == '12-31' ) {
	    		$excelKey = (int)$excelKey;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3112' . $currentYear . ')';
	    	} else if( $fyCheck[ $excelKey ] == '06-30' ) {
				$excelKey = (int)$excelKey + 1;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3006' . $currentYear . ')';
	    	} else if( $fyCheck[ $excelKey ] == '09-30' ) {
				$excelKey = (int)$excelKey + 1;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3009' . $currentYear . ')';
	    	} else {
	    		$fy = 'FY'.date( 'y', strtotime( $keyVal ) );	
	    	}
	    	$sheet->setCellValue( $excelIndex[ $index ] . '6', $fy)->getStyle( $excelIndex[ $index ] . '6' )->applyFromArray( $boldStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '7', $excelData[ 'Operational Income' ])->getStyle( $excelIndex[ $index ] . '7' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '8', $excelData[ 'Other Income' ])->getStyle( $excelIndex[ $index ] . '8' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '9', $excelData[ 'Total Income' ])->getStyle( $excelIndex[ $index ] . '9' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '10', $excelData[ 'Cost Of Materials Consumed' ] )->getStyle( $excelIndex[ $index ] . '10' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '11', $excelData[ 'Purchases Of Stock In Trade' ] )->getStyle( $excelIndex[ $index ] . '11' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '12', $excelData[ 'Changes In Inventories' ] )->getStyle( $excelIndex[ $index ] . '12' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '13', $excelData[ 'Employee Related Expenses' ] )->getStyle( $excelIndex[ $index ] . '13' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '14', $excelData[ 'CSR Expenditure' ] )->getStyle( $excelIndex[ $index ] . '14' )->applyFromArray( $defaultStyle );
			$sheet->setCellValue( $excelIndex[ $index ] . '15', $excelData[ 'Other Expenses' ] )->getStyle( $excelIndex[ $index ] . '15' )->applyFromArray( $defaultStyle );
			$sheet->setCellValue( $excelIndex[ $index ] . '16', $excelData[ 'Operational, Admin & Other Expenses' ] )->getStyle( $excelIndex[ $index ] . '16' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '17', $excelData[ 'Operating Profit' ] )->getStyle( $excelIndex[ $index ] . '17' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '18', $excelData[ 'EBITDA' ] )->getStyle( $excelIndex[ $index ] . '18' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '19', $excelData[ 'Interest' ] )->getStyle( $excelIndex[ $index ] . '19' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '20', $excelData[ 'EBDT' ] )->getStyle( $excelIndex[ $index ] . '20' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '21', $excelData[ 'Depreciation' ] )->getStyle( $excelIndex[ $index ] . '21' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '22', $excelData[ 'EBT before Exceptional Items' ] )->getStyle( $excelIndex[ $index ] . '22' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '23', $excelData[ 'Prior period/Exceptional /Extra Ordinary Items' ] )->getStyle( $excelIndex[ $index ] . '23' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '24', $excelData[ 'EBT' ] )->getStyle( $excelIndex[ $index ] . '24' )->applyFromArray( $defaultStyle );
			$sheet->setCellValue( $excelIndex[ $index ] . '25', $excelData[ 'CurrentTax' ] )->getStyle( $excelIndex[ $index ] . '25' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '26', $excelData[ 'DeferredTax' ] )->getStyle( $excelIndex[ $index ] . '26' )->applyFromArray( $defaultStyle );
			$sheet->setCellValue( $excelIndex[ $index ] . '27', $excelData[ 'Tax' ] )->getStyle( $excelIndex[ $index ] . '27' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '28', $excelData[ 'PAT' ])->getStyle( $excelIndex[ $index ] . '28' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '29', $excelData[ 'Profit (loss) of minority interest' ])->getStyle( $excelIndex[ $index ] . '29' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '30', $excelData[ 'Total profit (loss) for period' ])->getStyle( $excelIndex[ $index ] . '30' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '31', '')->getStyle( $excelIndex[ $index ] . '31' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '32', $excelData[ '(Basic in INR)' ])->getStyle( $excelIndex[ $index ] . '32' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '33', $excelData[ '(Diluted in INR)' ])->getStyle( $excelIndex[ $index ] . '33' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '35', '')->getStyle( $excelIndex[ $index ] . '35' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '36', $excelData[ 'Earning in Foreign Exchange' ])->getStyle( $excelIndex[ $index ] . '36' )->applyFromArray( $defaultStyle );
	    	$sheet->setCellValue( $excelIndex[ $index ] . '37', $excelData[ 'Outgo in Foreign Exchange' ])->getStyle( $excelIndex[ $index ] . '37' )->applyFromArray( $defaultStyle );
	    	$sheet->getColumnDimension( $excelIndex[ $index ] )->setWidth(20);
	    	$i++;
	    	$index++;
	    }
	    $logs->logWrite( "PL Consolidated Excel Loop ends" );
	    try {
	        $writer = new Xlsx( $spreadsheet );
	        try {
	        	if( !file_exists( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] ) ) { // Check directory exists or create a directory in admin output folder
		        	try {
			        	if( mkdir( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] ) ) {
							chmod( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ], 0777 );
						} else {
							$errorReport++;
							$errorArray[ $cin ]['common'][] = "Directory creation in server failed";
						}
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				if( $type == 'old' ) {
					$excelgentype = 'OLD';
				} else {
					$excelgentype = 'NEW';
				}
	            $csvFile = dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] . '/' . $finalArray[ 'Company name' ] . '_PL_CONSOLIDATED_' . $excelgentype . '.xlsx';
	            $writer->save( $csvFile ); // Save generated excel in folder
	            try {
		            $old = umask(0);
					chmod( $csvFile , 0777 );
					umask($old);
				} catch( Exception $e ) {
					echo $e->getMessage();
				}
	            $logs->logWrite( "PL Consolidated Excel Created" );    
	        } catch( Exception $e ) {
	        	$errorReport++;
	        	$errorArray[ $cin ]['common'][] = "PL Consolidated Excel write failed";
	            //echo $e->getMessage(); 
	        }
	    } catch( Exception $e ) {
	    	$errorReport++;
	    	$errorArray[ $cin ]['common'][] = "Spreadsheet Plugin problem";
	        //echo $e->getMessage(); 
	    }
	    return array( 'error' => $errorReport, 'error_array' => $errorArray  );
	}

	// BS Standalone excel generate function
	public function bsStandaloneExcelgenerate( $finalArray = '', $sfyYear = '', $cin = '', $type = '', $fyCheck = '' ) {
		global $logs;
		$errorReport = 0;
		$errorArray = array();
		$logs->logWrite( "BS Standalone Excel Generation process started" );

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
	    $excelIndex = $this->createColumnsArray( 'BZ' );
	    $spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
    	// Heading Creation for Excel sheet
    	$sheet->setCellValue('A1', '?? TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.    ')->getStyle('A1')->getAlignment()->setWrapText(true);
	    $sheet->setCellValue('A3', $finalArray[ 'Company name' ] )->getStyle("A3")->applyFromArray( $companyStyle );
	    $sheet->setCellValue('A4', 'All Figures (unless otherwise specified) is in INR');
	    $sheet->setCellValue('A6', "Shareholders funds [Abstract]")->getStyle("A6")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A7', 'Share capital')->getStyle("A7")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A8', 'Reserves and surplus')->getStyle("A8")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A9', "Total shareholders funds")->getStyle("A9")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A10', 'Share application money pending allotment')->getStyle("A10")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A11', '')->getStyle("A11")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A12', 'Non-current liabilities [Abstract]')->getStyle("A12")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A13', 'Long-term borrowings')->getStyle("A13")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A14', 'Deferred tax liabilities (net)')->getStyle("A14")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A15', 'Other long-term liabilities')->getStyle("A15")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A16', 'Long-term provisions')->getStyle("A16")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A17', 'Total non-current liabilities')->getStyle("A17")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A18', '')->getStyle("A18")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A19', 'Current liabilities [Abstract]')->getStyle("A19")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A20', 'Short-term borrowings')->getStyle("A20")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A21', 'Trade payables')->getStyle("A21")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A22', 'Other current liabilities')->getStyle("A22")->applyFromArray( $defaultStyle );    
	    $sheet->setCellValue('A23', 'Short-term provisions ')->getStyle("A23")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A24', 'Total current liabilities')->getStyle("A24")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A25', 'Total equity and liabilities')->getStyle("A25")->applyFromArray( $boldWFill );
	    $sheet->setCellValue('A26', '')->getStyle("A26")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A27', 'Assets [Abstract]')->getStyle("A27")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A28', '')->getStyle("A28")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A29', 'Non-current assets [Abstract]')->getStyle("A29")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A30', '')->getStyle("A30")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A31', 'Fixed assets [Abstract]')->getStyle("A31")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A32', 'Tangible assets')->getStyle("A32")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A33', 'Intangible assets')->getStyle("A33")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A34', 'Total fixed assets')->getStyle("A34")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A35', 'Non-current investments')->getStyle("A35")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A36', 'Deferred tax assets (net)')->getStyle("A36")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A37', 'Long-term loans and advances')->getStyle("A37")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A38', 'Other non-current assets')->getStyle("A38")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A39', 'Total non-current assets')->getStyle("A39")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A40', '')->getStyle("A40")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A41', 'Current assets [Abstract]')->getStyle("A41")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A42', 'Current investments')->getStyle("A42")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A43', 'Inventories')->getStyle("A43")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A44', 'Trade receivables')->getStyle("A44")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A45', 'Cash and bank balances')->getStyle("A45")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A46', 'Short-term loans and advances')->getStyle("A46")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A47', 'Other current assets')->getStyle("A47")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A48', 'Total current assets')->getStyle("A48")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A49', 'Total assets')->getStyle("A49")->applyFromArray( $boldWFill );
	    $sheet->getColumnDimension('A')->setWidth(50);

	    $i = 0;
	    $index = 1;
	    $logs->logWrite( "BS Standalone Excel loop enter" );
	    krsort( $finalArray[ 'Excel Data' ][ 'bs' ] );
	    // Looping throught the generated data from the XML.
	    foreach( $finalArray[ 'Excel Data' ][ 'bs' ] as $excelKey => $excelData ) {
	    	$keyVal = '01-01-'.$excelKey;
	    	if( $fyCheck[ $excelKey ] == '12-31' ) {
	    		$excelKey = (int)$excelKey;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3112' . $currentYear . ')';
	    	} else if( $fyCheck[ $excelKey ] == '06-30' ) {
				$excelKey = (int)$excelKey + 1;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3006' . $currentYear . ')';
	    	} else if( $fyCheck[ $excelKey ] == '09-30' ) {
				$excelKey = (int)$excelKey + 1;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3009' . $currentYear . ')';
	    	} else {
	    		$fy = 'FY'.date( 'y', strtotime( $keyVal ) );	
	    	}
	    	$sheet->setCellValue( $excelIndex[ $index ] . '6', $fy)->getStyle( $excelIndex[ $index ] . '6' )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '7', $excelData[ 'Share capital' ] )->getStyle( $excelIndex[ $index ] . "7" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '8', $excelData[ 'Reserves and surplus' ] )->getStyle( $excelIndex[ $index ] . "8" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '9', $excelData[ 'Total shareholders funds' ] )->getStyle( $excelIndex[ $index ] . "9" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '10', $excelData[ 'Share application money pending allotment' ] )->getStyle( $excelIndex[ $index ] . "10" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '11', '' )->getStyle( $excelIndex[ $index ] . "11" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '12', '' )->getStyle( $excelIndex[ $index ] . "12" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '13', $excelData[ 'Long-term borrowings' ] )->getStyle( $excelIndex[ $index ] . "13" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '14', $excelData[ 'Deferred tax liabilities (net)' ] )->getStyle( $excelIndex[ $index ] . "14" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '15', $excelData[ 'Other long-term liabilities' ] )->getStyle( $excelIndex[ $index ] . "15" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '16', $excelData[ 'Long-term provisions' ] )->getStyle( $excelIndex[ $index ] . "16" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '17', $excelData[ 'Total non-current liabilities' ] )->getStyle( $excelIndex[ $index ] . "17" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '18', '')->getStyle($excelIndex[ $index ] . "18")->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '19', '' )->getStyle( $excelIndex[ $index ] . "19" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '20', $excelData[ 'Short-term borrowings' ] )->getStyle( $excelIndex[ $index ] . "20" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '21', $excelData[ 'Trade payables' ] )->getStyle( $excelIndex[ $index ] . "21" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '22', $excelData[ 'Other current liabilities' ] )->getStyle( $excelIndex[ $index ] . "22" )->applyFromArray( $defaultStyle );    
		    $sheet->setCellValue( $excelIndex[ $index ] . '23', $excelData[ 'Short-term provisions' ] )->getStyle( $excelIndex[ $index ] . "23" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '24', $excelData[ 'Total current liabilities' ] )->getStyle( $excelIndex[ $index ] . "24" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '25', $excelData[ 'Total equity and liabilities' ] )->getStyle( $excelIndex[ $index ] . "25" )->applyFromArray( $boldWFill );
		    $sheet->setCellValue( $excelIndex[ $index ] . '26', '')->getStyle( $excelIndex[ $index ] . "26" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '27', '' )->getStyle( $excelIndex[ $index ] . "27" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '28', '')->getStyle( $excelIndex[ $index ] . "28" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '29', '' )->getStyle( $excelIndex[ $index ] . "29" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '30', '')->getStyle( $excelIndex[ $index ] . "30" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '31', '' )->getStyle( $excelIndex[ $index ] . "31" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '32', $excelData[ 'Tangible assets' ] )->getStyle( $excelIndex[ $index ] . "32" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '33', $excelData[ 'Intangible assets' ] )->getStyle( $excelIndex[ $index ] . "33" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '34', $excelData[ 'Total fixed assets' ] )->getStyle( $excelIndex[ $index ] . "34" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '35', $excelData[ 'Non-current investments' ] )->getStyle( $excelIndex[ $index ] . "35" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '36', $excelData[ 'Deferred tax assets (net)' ] )->getStyle( $excelIndex[ $index ] . "36" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '37', $excelData[ 'Long-term loans and advances' ] )->getStyle( $excelIndex[ $index ] . "37" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '38', $excelData[ 'Other non-current assets' ] )->getStyle( $excelIndex[ $index ] . "38" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '39', $excelData[ 'Total non-current assets' ] )->getStyle( $excelIndex[ $index ] . "39" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '40', '')->getStyle( $excelIndex[ $index ] . "40" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '41', '' )->getStyle( $excelIndex[ $index ] . "41" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '42', $excelData[ 'Current investments' ] )->getStyle( $excelIndex[ $index ] . "42" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '43', $excelData[ 'Inventories' ] )->getStyle( $excelIndex[ $index ] . "43" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '44', $excelData[ 'Trade receivables' ] )->getStyle( $excelIndex[ $index ] . "44" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '45', $excelData[ 'Cash and bank balances' ] )->getStyle( $excelIndex[ $index ] . "45" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '46', $excelData[ 'Short-term loans and advances' ] )->getStyle( $excelIndex[ $index ] . "46" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '47', $excelData[ 'Other current assets' ] )->getStyle( $excelIndex[ $index ] . "47" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '48', $excelData[ 'Total current assets' ] )->getStyle( $excelIndex[ $index ] . "48" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '49', $excelData[ 'Total assets' ] )->getStyle( $excelIndex[ $index ] . "49" )->applyFromArray( $boldWFill );
	    	$sheet->getColumnDimension( $excelIndex[ $index ] )->setWidth(20);
	    	$i++;
	    	$index++;
	    }
	    $logs->logWrite( "BS Standalone Excel loops ends" );
	    try {
	        $writer = new Xlsx( $spreadsheet );
	        try {
	        	if( !file_exists( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] ) ) { // Check directory exists or create a directory in admin output folder
		        	try {
			        	if( mkdir( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] ) ) {
							chmod( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ], 0777 );
						} else {
							$errorReport++;
							$errorArray[ $cin ]['common'][] = "Directory creation in server failed";
						}
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				if( $type == 'old' ) {
					$excelgentype = 'OLD';
				} else {
					$excelgentype = 'NEW';
				}
	            $csvFile = dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] . '/' . $finalArray[ 'Company name' ] . '_BS_STANDALONE_' . $excelgentype . '.xlsx';
	            $writer->save( $csvFile ); // Save generated excel in folder
	            try {
		            $old = umask(0);
					chmod( $csvFile , 0777 );
					umask($old);
				} catch( Exception $e ) {
					echo $e->getMessage();
				}
	            $logs->logWrite( "BS Standalone Excel Created" );        
	        } catch( Exception $e ) {
	        	$errorReport++;
	        	$errorArray[ $cin ]['common'][] = "BS Standalone Excel write failed";
	            //echo $e->getMessage(); 
	        }
	    } catch( Exception $e ) {
	    	$errorReport++;
	    	$errorArray[ $cin ]['common'][] = "Spreadsheet Plugin problem";
	        //echo $e->getMessage(); 
	    }
	    return array( 'error' => $errorReport, 'error_array' => $errorArray  );
	}
	//CF excelgenerate function
	public function cfStandaloneExcelgenerate( $finalArray = '', $sfyYear = '', $cin = '', $type = '', $fyCheck = '' ) {
		global $logs;
		$errorReport = 0;
		$errorArray = array();
		$logs->logWrite( "Cash-Flow Standalone Excel Generation process started" );

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
	    $excelIndex = $this->createColumnsArray( 'BZ' );
	    $spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
    	// Heading Creation for Excel sheet
    	$sheet->setCellValue('A1', '?? TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.    ')->getStyle('A1')->getAlignment()->setWrapText(true);
	    $sheet->setCellValue('A3', $finalArray[ 'Company name' ] )->getStyle("A3")->applyFromArray( $companyStyle );
	    $sheet->setCellValue('A4', 'All Figures (unless otherwise specified) is in INR');
	    $sheet->setCellValue('A6', "Particulars")->getStyle("A6")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A7', "Statement of cash flows")->getStyle("A7")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A8', "Net Profit/Loss Before Extraordinary Items And Tax")->getStyle("A8")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A9', 'Net CashFlow From Operating Activities')->getStyle("A9")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A10', 'Net Cash Used In Investing Activities')->getStyle("A10")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A11', 'Net Cash Used From Financing Activities')->getStyle("A11")->applyFromArray($defaultStyle );
	    $sheet->setCellValue('A12', "Net Inc/Dec In Cash And Cash Equivalents")->getStyle("A12")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A13', 'Cash And Cash Equivalents Begin of Year')->getStyle("A13")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A14', 'Cash And Cash Equivalents End Of Year')->getStyle("A14")->applyFromArray( $defaultStyle );
	    $sheet->getColumnDimension('A')->setWidth(50);

	    $i = 0;
	    $index = 1;
	    $logs->logWrite( "Cash-Flow Standalone Excel loop enter" );
	    krsort( $finalArray[ 'Excel Data' ][ 'cf' ] );
	    // Looping throught the generated data from the XML.
	    foreach( $finalArray[ 'Excel Data' ][ 'cf' ] as $excelKey => $excelData ) {
	    	$keyVal = '01-01-'.$excelKey;
	    	if( $fyCheck[ $excelKey ] == '12-31' ) {
	    		$excelKey = (int)$excelKey;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3112' . $currentYear . ')';
	    	} else if( $fyCheck[ $excelKey ] == '06-30' ) {
				$excelKey = (int)$excelKey + 1;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3006' . $currentYear . ')';
	    	} else if( $fyCheck[ $excelKey ] == '09-30' ) {
				$excelKey = (int)$excelKey + 1;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3009' . $currentYear . ')';
	    	} else {
	    		$fy = 'FY'.date( 'y', strtotime( $keyVal ) );	
	    	}
	    	$sheet->setCellValue( $excelIndex[ $index ] . '6', $fy)->getStyle( $excelIndex[ $index ] . '6' )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '7', '')->getStyle( $excelIndex[ $index ] . "7" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '8', $excelData[ 'Net Profit/Loss Before Extraordinary Items And Tax' ] )->getStyle( $excelIndex[ $index ] . "8" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '9', $excelData[ 'Net CashFlow From Operating Activities' ] )->getStyle( $excelIndex[ $index ] . "9" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '10', $excelData[ 'Net Cash Used In Investing Activities' ] )->getStyle( $excelIndex[ $index ] . "10" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '11', $excelData['Net Cash Used From Financing Activities'] )->getStyle( $excelIndex[ $index ] . "11" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '12', $excelData['Net Inc/Dec In Cash And Cash Equivalents'] )->getStyle( $excelIndex[ $index ] . "12" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '13', '')->getStyle( $excelIndex[ $index ] . "13" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '14', $excelData[ 'Cash And Cash Equivalents End Of Year' ] )->getStyle( $excelIndex[ $index ] . "14" )->applyFromArray( $defaultStyle );
		    $sheet->getColumnDimension( $excelIndex[ $index ] )->setWidth(20);
	    	$i++;
			$index++;
			
	    }
	    $logs->logWrite( "Cash-Flow Standalone Excel loops ends" );
	    try {
	        $writer = new Xlsx( $spreadsheet );
	        try {
	        	if( !file_exists( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] ) ) { // Check directory exists or create a directory in admin output folder
		        	try {
			        	if( mkdir( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] ) ) {
							chmod( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ], 0777 );
						} else {
							$errorReport++;
							$errorArray[ $cin ]['common'][] = "Directory creation in server failed";
						}
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				if( $type == 'old' ) {
					$excelgentype = 'OLD';
				} else {
					$excelgentype = 'NEW';
				}
	            $csvFile = dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] . '/' . $finalArray[ 'Company name' ] . '_CF_STANDALONE_' . $excelgentype . '.xlsx';
	            $writer->save( $csvFile ); // Save generated excel in folder
	            try {
		            $old = umask(0);
					chmod( $csvFile , 0777 );
					umask($old);
				} catch( Exception $e ) {
					echo $e->getMessage();
				}
	            $logs->logWrite( "Cash-Flow Standalone Excel Created" );        
	        } catch( Exception $e ) {
	        	$errorReport++;
	        	$errorArray[ $cin ]['common'][] = "Cash-Flow Standalone Excel write failed";
	            //echo $e->getMessage(); 
	        }
	    } catch( Exception $e ) {
	    	$errorReport++;
	    	$errorArray[ $cin ]['common'][] = "Spreadsheet Plugin problem";
	        //echo $e->getMessage(); 
	    }
	    return array( 'error' => $errorReport, 'error_array' => $errorArray  );
	}
	//CF excel generate end

	// BS Consolidated excel generate function
	public function bsConsolidatedExcelgenerate( $finalArray = '', $sfyYear = '', $cin = '', $type = '', $fyCheck = '' ) {
		global $logs;

		$errorReport = 0;
		$errorArray = array();
		$logs->logWrite( "BS Consolidated Excel Generation process started" );

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
	    $excelIndex = $this->createColumnsArray( 'BZ' );
	    $spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
    	// Heading Creation for Excel sheet
    	$sheet->setCellValue('A1', '?? TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.    ')->getStyle('A1')->getAlignment()->setWrapText(true);
	    $sheet->setCellValue('A3', $finalArray[ 'Company name' ] )->getStyle("A3")->applyFromArray( $companyStyle );
	    $sheet->setCellValue('A4', 'All Figures (unless otherwise specified) is in INR');
	    $sheet->setCellValue('A6', "Shareholders' funds [Abstract]")->getStyle("A6")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A7', 'Share capital')->getStyle("A7")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A8', 'Reserves and surplus')->getStyle("A8")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A9', "Total shareholders funds")->getStyle("A9")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A10', 'Share application money pending allotment')->getStyle("A10")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A11', 'Minority interest')->getStyle("A11")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A12', 'Non-current liabilities [Abstract]')->getStyle("A12")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A13', 'Long-term borrowings')->getStyle("A13")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A14', 'Deferred tax liabilities (net)')->getStyle("A14")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A15', 'Other long-term liabilities')->getStyle("A15")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A16', 'Long-term provisions')->getStyle("A16")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A17', 'Total non-current liabilities')->getStyle("A17")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A18', '')->getStyle("A18")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A19', 'Current liabilities [Abstract]')->getStyle("A19")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A20', 'Short-term borrowings')->getStyle("A20")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A21', 'Trade payables')->getStyle("A21")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A22', 'Other current liabilities')->getStyle("A22")->applyFromArray( $defaultStyle );    
	    $sheet->setCellValue('A23', 'Short-term provisions ')->getStyle("A23")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A24', 'Total current liabilities')->getStyle("A24")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A25', 'Total equity and liabilities')->getStyle("A25")->applyFromArray( $boldWFill );
	    $sheet->setCellValue('A26', '')->getStyle("A26")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A27', 'Assets [Abstract]')->getStyle("A27")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A28', '')->getStyle("A28")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A29', 'Non-current assets [Abstract]')->getStyle("A29")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A30', '')->getStyle("A30")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A31', 'Fixed assets [Abstract]')->getStyle("A31")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A32', 'Tangible assets')->getStyle("A32")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A33', 'Intangible assets')->getStyle("A33")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A34', 'Total fixed assets')->getStyle("A34")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A35', 'Non-current investments')->getStyle("A35")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A36', 'Deferred tax assets (net)')->getStyle("A36")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A37', 'Long-term loans and advances')->getStyle("A37")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A38', 'Other non-current assets')->getStyle("A38")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A39', 'Total non-current assets')->getStyle("A39")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A40', '')->getStyle("A40")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A41', 'Current assets [Abstract]')->getStyle("A41")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A42', 'Current investments')->getStyle("A42")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A43', 'Inventories')->getStyle("A43")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A44', 'Trade receivables')->getStyle("A44")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A45', 'Cash and bank balances')->getStyle("A45")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A46', 'Short-term loans and advances')->getStyle("A46")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A47', 'Other current assets')->getStyle("A47")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A48', 'Total current assets')->getStyle("A48")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A49', 'Total assets')->getStyle("A49")->applyFromArray( $boldWFill );
	    $sheet->getColumnDimension('A')->setWidth(50);

	    $i = 0;
	    $index = 1;
	    $logs->logWrite( "BS Consolidated Excel Loop enter" );
	    krsort( $finalArray[ 'Excel Data' ][ 'bs' ] );
	    // Looping throught the generated data from the XML.
	    foreach( $finalArray[ 'Excel Data' ][ 'bs' ] as $excelKey => $excelData ) {
	    	$keyVal = '01-01-'.$excelKey;
	    	if( $fyCheck[ $excelKey ] == '12-31' ) {
	    		$excelKey = (int)$excelKey;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3112' . $currentYear . ')';
	    	} else if( $fyCheck[ $excelKey ] == '06-30' ) {
				$excelKey = (int)$excelKey + 1;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3006' . $currentYear . ')';
	    	} else if( $fyCheck[ $excelKey ] == '09-30' ) {
				$excelKey = (int)$excelKey + 1;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3009' . $currentYear . ')';
	    	} else {
	    		$fy = 'FY'.date( 'y', strtotime( $keyVal ) );	
	    	}
	    	$sheet->setCellValue( $excelIndex[ $index ] . '6', $fy)->getStyle( $excelIndex[ $index ] . '6' )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '7', $excelData[ 'Share capital' ] )->getStyle( $excelIndex[ $index ] . "7" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '8', $excelData[ 'Reserves and surplus' ] )->getStyle( $excelIndex[ $index ] . "8" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '9', $excelData[ 'Total shareholders funds' ] )->getStyle( $excelIndex[ $index ] . "9" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '10', $excelData[ 'Share application money pending allotment' ] )->getStyle( $excelIndex[ $index ] . "10" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '11', $excelData[ 'Minority interest' ] )->getStyle( $excelIndex[ $index ] . "11" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '12', '' )->getStyle( $excelIndex[ $index ] . "12" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '13', $excelData[ 'Long-term borrowings' ] )->getStyle( $excelIndex[ $index ] . "13" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '14', $excelData[ 'Deferred tax liabilities (net)' ] )->getStyle( $excelIndex[ $index ] . "14" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '15', $excelData[ 'Other long-term liabilities' ] )->getStyle( $excelIndex[ $index ] . "15" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '16', $excelData[ 'Long-term provisions' ] )->getStyle( $excelIndex[ $index ] . "16" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '17', $excelData[ 'Total non-current liabilities' ] )->getStyle( $excelIndex[ $index ] . "17" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '18', '')->getStyle($excelIndex[ $index ] . "18")->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '19', '' )->getStyle( $excelIndex[ $index ] . "19" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '20', $excelData[ 'Short-term borrowings' ] )->getStyle( $excelIndex[ $index ] . "20" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '21', $excelData[ 'Trade payables' ] )->getStyle( $excelIndex[ $index ] . "21" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '22', $excelData[ 'Other current liabilities' ] )->getStyle( $excelIndex[ $index ] . "22" )->applyFromArray( $defaultStyle );    
		    $sheet->setCellValue( $excelIndex[ $index ] . '23', $excelData[ 'Short-term provisions' ] )->getStyle( $excelIndex[ $index ] . "23" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '24', $excelData[ 'Total current liabilities' ] )->getStyle( $excelIndex[ $index ] . "24" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '25', $excelData[ 'Total equity and liabilities' ] )->getStyle( $excelIndex[ $index ] . "25" )->applyFromArray( $boldWFill );
		    $sheet->setCellValue( $excelIndex[ $index ] . '26', '')->getStyle( $excelIndex[ $index ] . "26" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '27', '' )->getStyle( $excelIndex[ $index ] . "27" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '28', '')->getStyle( $excelIndex[ $index ] . "28" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '29', '' )->getStyle( $excelIndex[ $index ] . "29" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '30', '')->getStyle( $excelIndex[ $index ] . "30" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '31', '' )->getStyle( $excelIndex[ $index ] . "31" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '32', $excelData[ 'Tangible assets' ] )->getStyle( $excelIndex[ $index ] . "32" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '33', $excelData[ 'Intangible assets' ] )->getStyle( $excelIndex[ $index ] . "33" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '34', $excelData[ 'Total fixed assets' ] )->getStyle( $excelIndex[ $index ] . "34" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '35', $excelData[ 'Non-current investments' ] )->getStyle( $excelIndex[ $index ] . "35" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '36', $excelData[ 'Deferred tax assets (net)' ] )->getStyle( $excelIndex[ $index ] . "36" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '37', $excelData[ 'Long-term loans and advances' ] )->getStyle( $excelIndex[ $index ] . "37" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '38', $excelData[ 'Other non-current assets' ] )->getStyle( $excelIndex[ $index ] . "38" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '39', $excelData[ 'Total non-current assets' ] )->getStyle( $excelIndex[ $index ] . "39" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '40', '')->getStyle( $excelIndex[ $index ] . "40" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '41', '' )->getStyle( $excelIndex[ $index ] . "41" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '42', $excelData[ 'Current investments' ] )->getStyle( $excelIndex[ $index ] . "42" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '43', $excelData[ 'Inventories' ] )->getStyle( $excelIndex[ $index ] . "43" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '44', $excelData[ 'Trade receivables' ] )->getStyle( $excelIndex[ $index ] . "44" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '45', $excelData[ 'Cash and bank balances' ] )->getStyle( $excelIndex[ $index ] . "45" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '46', $excelData[ 'Short-term loans and advances' ] )->getStyle( $excelIndex[ $index ] . "46" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '47', $excelData[ 'Other current assets' ] )->getStyle( $excelIndex[ $index ] . "47" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '48', $excelData[ 'Total current assets' ] )->getStyle( $excelIndex[ $index ] . "48" )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '49', $excelData[ 'Total assets' ] )->getStyle( $excelIndex[ $index ] . "49" )->applyFromArray( $boldWFill );
	    	$sheet->getColumnDimension( $excelIndex[ $index ] )->setWidth(20);
	    	$i++;
	    	$index++;
	    }
	    $logs->logWrite( "BS Consolidated Excel Loop ends" );
	    try {
	        $writer = new Xlsx( $spreadsheet );
	        try {
	        	if( !file_exists( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] ) ) { // Check directory exists or create a directory in admin output folder
		        	try {
			        	if( mkdir( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] ) ) {
							chmod( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ], 0777 );
						} else {
							$errorReport++;
							$errorArray[ $cin ]['common'][] = "Directory creation in server failed";
						}
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				if( $type == 'old' ) {
					$excelgentype = 'OLD';
				} else {
					$excelgentype = 'NEW';
				}
	            $csvFile = dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] . '/' . $finalArray[ 'Company name' ] . '_BS_CONSOLIDATED_' . $excelgentype . '.xlsx';
	            $writer->save( $csvFile ); // Save generated excel in folder
	            try {
		            $old = umask(0);
					chmod( $csvFile , 0777 );
					umask($old);   
				} catch( Exception $e ) {
					echo $e->getMessage();
				}
	            $logs->logWrite( "BS Consolidated Excel Created" );     
	        } catch( Exception $e ) {
	        	$errorReport++;
	        	$errorArray[ $cin ]['common'][] = "BS Consolidated Excel write failed";
	        }
	    } catch( Exception $e ) {
	    	$errorReport++;
	    	$errorArray[ $cin ]['common'][] = "Spreadsheet Plugin problem";
	    }
	    return array( 'error' => $errorReport, 'error_array' => $errorArray  );
	}
//CF consolidated 
	public function cfConsolidatedExcelgenerate( $finalArray = '', $sfyYear = '', $cin = '', $type = '', $fyCheck = '' ) {
		global $logs;

		$errorReport = 0;
		$errorArray = array();
		$logs->logWrite( "Cash-Flow Consolidated Excel Generation process started" );

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
	    $excelIndex = $this->createColumnsArray( 'BZ' );
	    $spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
    	// Heading Creation for Excel sheet
    	$sheet->setCellValue('A1', '?? TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.    ')->getStyle('A1')->getAlignment()->setWrapText(true);
	    $sheet->setCellValue('A3', $finalArray[ 'Company name' ] )->getStyle("A3")->applyFromArray( $companyStyle );
	    $sheet->setCellValue('A4', 'All Figures (unless otherwise specified) is in INR');
	    $sheet->setCellValue('A6', "Particulars")->getStyle("A6")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A7', "Statement of cash flows")->getStyle("A7")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A8', "Net Profit/Loss Before Extraordinary Items And Tax")->getStyle("A8")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A9', 'Net CashFlow From Operating Activities')->getStyle("A9")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A10', 'Net Cash Used In Investing Activities')->getStyle("A10")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A11', 'Net Cash Used From Financing Activities')->getStyle("A11")->applyFromArray($defaultStyle );
	    $sheet->setCellValue('A12', "Net Inc/Dec In Cash And Cash Equivalents")->getStyle("A12")->applyFromArray( $boldStyle );
	    $sheet->setCellValue('A13', 'Cash And Cash Equivalents Begin of Year')->getStyle("A13")->applyFromArray( $defaultStyle );
	    $sheet->setCellValue('A14', 'Cash And Cash Equivalents End Of Year')->getStyle("A14")->applyFromArray( $defaultStyle );
	    $sheet->getColumnDimension('A')->setWidth(50);

	    $i = 0;
	    $index = 1;
	    $logs->logWrite( "CF Consolidated Excel Loop enter" );
	    krsort( $finalArray[ 'Excel Data' ][ 'cf' ] );
	    // Looping throught the generated data from the XML.
	    foreach( $finalArray[ 'Excel Data' ][ 'cf' ] as $excelKey => $excelData ) {
	    	$keyVal = '01-01-'.$excelKey;
	    	if( $fyCheck[ $excelKey ] == '12-31' ) {
	    		$excelKey = (int)$excelKey;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3112' . $currentYear . ')';
	    	} else if( $fyCheck[ $excelKey ] == '06-30' ) {
				$excelKey = (int)$excelKey + 1;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3006' . $currentYear . ')';
	    	} else if( $fyCheck[ $excelKey ] == '09-30' ) {
				$excelKey = (int)$excelKey + 1;
	    		$keyVal = '01-01-'.$excelKey;
	    		$nextYear = date( 'y', strtotime( $keyVal ) );
	    		$currentYear = date( 'y', strtotime( $keyVal ) ) - 1;
	    		$fy = 'FY'. $nextYear . ' (3009' . $currentYear . ')';
	    	} else {
	    		$fy = 'FY'.date( 'y', strtotime( $keyVal ) );	
	    	}
	    	$sheet->setCellValue( $excelIndex[ $index ] . '6', $fy)->getStyle( $excelIndex[ $index ] . '6' )->applyFromArray( $boldStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '7', '')->getStyle( $excelIndex[ $index ] . "7" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '8', $excelData[ 'Net Profit/Loss Before Extraordinary Items And Tax' ] )->getStyle( $excelIndex[ $index ] . "8" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '9', $excelData[ 'Net CashFlow From Operating Activities' ] )->getStyle( $excelIndex[ $index ] . "9" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '10', $excelData[ 'Net Cash Used In Investing Activities' ] )->getStyle( $excelIndex[ $index ] . "10" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '11', $excelData['Net Cash Used From Financing Activities'] )->getStyle( $excelIndex[ $index ] . "11" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '12', $excelData['Net Inc/Dec In Cash And Cash Equivalents'] )->getStyle( $excelIndex[ $index ] . "12" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '13', '')->getStyle( $excelIndex[ $index ] . "13" )->applyFromArray( $defaultStyle );
		    $sheet->setCellValue( $excelIndex[ $index ] . '14', $excelData[ 'Cash And Cash Equivalents End Of Year' ] )->getStyle( $excelIndex[ $index ] . "14" )->applyFromArray( $defaultStyle );
		    $sheet->getColumnDimension( $excelIndex[ $index ] )->setWidth(20);
	    	$i++;
	    	$index++;
	    }
	    $logs->logWrite( "Cash-Flow Consolidated Excel Loop ends" );
	    try {
	        $writer = new Xlsx( $spreadsheet );
	        try {
	        	if( !file_exists( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] ) ) { // Check directory exists or create a directory in admin output folder
		        	try {
			        	if( mkdir( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] ) ) {
							chmod( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ], 0777 );
						} else {
							$errorReport++;
							$errorArray[ $cin ]['common'][] = "Directory creation in server failed";
						}
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				if( $type == 'old' ) {
					$excelgentype = 'OLD';
				} else {
					$excelgentype = 'NEW';
				}
	            $csvFile = dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] . '/' . $finalArray[ 'Company name' ] . '_CF_CONSOLIDATED_' . $excelgentype . '.xlsx';
	            $writer->save( $csvFile ); // Save generated excel in folder
	            try {
		            $old = umask(0);
					chmod( $csvFile , 0777 );
					umask($old);   
				} catch( Exception $e ) {
					echo $e->getMessage();
				}
	            $logs->logWrite( "Cash-Flow Consolidated Excel Created" );     
	        } catch( Exception $e ) {
	        	$errorReport++;
	        	$errorArray[ $cin ]['common'][] = "Cash-Flow Consolidated Excel write failed";
	        }
	    } catch( Exception $e ) {
	    	$errorReport++;
	    	$errorArray[ $cin ]['common'][] = "Spreadsheet Plugin problem";
	    }
	    return array( 'error' => $errorReport, 'error_array' => $errorArray  );
	}
//CF consolidate end

	
	/**
     * Dynamic column aarray function. Common function used in all functions
     *
     * @param  string $end_column Excel end column
     * @param  string $first_letters Starting letters
     * @return Returns Excel Data
     */
	public function createColumnsArray( $end_column, $first_letters = '' ) {
	  	$columns = array();
	  	$length = strlen($end_column);
	  	$letters = range('A', 'Z');

	  	// Iterate over 26 letters.
	  	foreach ($letters as $letter) {
	      	// Paste the $first_letters before the next.
	      	$column = $first_letters . $letter;

	      	// Add the column to the final array.
	      	$columns[] = $column;

	      	// If it was the end column that was added, return the columns.
	      	if ($column == $end_column) {
	          	return $columns;
	      	}
	  	}

	  	// Add the column children.
	  	foreach ($columns as $column) {
	      	// Don't itterate if the $end_column was already set in a previous itteration.
	      	// Stop iterating if you've reached the maximum character length.
	      	if (!in_array($end_column, $columns) && strlen($column) < $length) {
	          	$new_columns = $this->createColumnsArray($end_column, $column);
	          	// Merge the new columns which were created with the final columns array.
	          	$columns = array_merge($columns, $new_columns);
	      	}
	  	}
	  	return $columns;
	}

	public function shpExcelgenerate( $finalArray = '', $cin = '') {
		
		global $logs;

		$errorReport = 0;
		$errorArray = array();
		$logs->logWrite( "SHP Excel Generation process started" );

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
	    $excelIndex = $this->createColumnsArray( 'BZ' );
	    $spreadsheet = new Spreadsheet();
    	$sheet = $spreadsheet->getActiveSheet();
    	// Heading Creation for Excel sheet
    	$sheet->setCellValue('A1', '?? TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.')->getStyle('A1')->getAlignment()->setWrapText(true);
	    $sheet->setCellValue('A3', $finalArray['Company name'])->getStyle("A3")->applyFromArray( $companyStyle );
	    $sheet->setCellValue('A4', 'All Figures (unless otherwise specified) is in INR');
	    $sheet->setCellValue('A6', 'Shareholding of Promoters')->getStyle("A6")->applyFromArray( $boldStyle );
	    
	    $sheet->setCellValue('A8', 'Shareholder???s Name')->getStyle("A8")->applyFromArray( $boldStyle );
		$sheet->setCellValue('B8', 'Shareholding at the beginning of the year')->getStyle("B8")->applyFromArray( $boldStyle );
		$sheet->setCellValue('C8', 'Shareholding at the end of the year')->getStyle("C8")->applyFromArray( $boldStyle);
	    
		$sheet->getColumnDimension('A')->setWidth(50);
		$sheet->getColumnDimension('B')->setWidth(40);
		$sheet->getColumnDimension('C')->setWidth(40);
		$i = 0;
		$totalStart_Value = 0;
		$totalEnd_Value = 0;
		$indexOfName = 8;
		
		$shp_check_count_promoter = count($finalArray['Excel Data']['promoters']);
		$shp_check_count_shareholder = count($finalArray['Excel Data']['shareholder']);
	     
		
			for($j=1;$j<=$shp_check_count_promoter;$j++){
				$indexOfName = $indexOfName + 1;
				$sheet->setCellValue( "A".$indexOfName, $finalArray['Excel Data']['promoters'][$j][ 'name' ])->getStyle("A".$indexOfName)->applyFromArray( $defaultStyle );
				$sheet->setCellValue( "B".$indexOfName, $finalArray['Excel Data']['promoters'][$j][ 'start-shares' ])->getStyle("B".$indexOfName)->applyFromArray( $defaultStyle );
				$sheet->setCellValue( "C".$indexOfName, $finalArray['Excel Data']['promoters'][$j][ 'end-shares' ])->getStyle("C".$indexOfName)->applyFromArray( $defaultStyle );
				$totalStart_Value = $totalStart_Value + $finalArray['Excel Data']['promoters'][$j][ 'start-shares' ];
				$totalEnd_Value = $totalEnd_Value + $finalArray['Excel Data']['promoters'][$j][ 'end-shares' ];
			}
			
		$indexOfTotal = $indexOfName + 2;
		$indexOfShareholders = $indexOfTotal + 2;
		
		if( $shp_check_count_promoter > 0 ) {
			$sheet->setCellValue('A'.$indexOfTotal, 'Total')->getStyle("A".$indexOfTotal)->applyFromArray( $defaultStyle );
			$sheet->setCellValue('B'.$indexOfTotal, $totalStart_Value)->getStyle("B".$indexOfTotal)->applyFromArray( $defaultStyle );
			$sheet->setCellValue('C'.$indexOfTotal, $totalEnd_Value)->getStyle("C".$indexOfTotal)->applyFromArray( $defaultStyle );
		}

		if( $shp_check_count_shareholder > 0 ) {

			$sheet->setCellValue('A'.$indexOfShareholders, 'For each of the Top 10 Shareholders')->getStyle('A'.$indexOfShareholders)->applyFromArray( $boldStyle );

			for($j=1; $j<=$shp_check_count_shareholder; $j++){
				
				$indexOfShareholders = $indexOfShareholders + 1;
				$sheet->setCellValue( "A".$indexOfShareholders, $finalArray['Excel Data']['shareholder'][$j][ 'name' ])->getStyle("A".$indexOfShareholders)->applyFromArray( $defaultStyle );
				$sheet->setCellValue( "B".$indexOfShareholders, $finalArray['Excel Data']['shareholder'][$j][ 'start-shares' ])->getStyle("B".$indexOfShareholders)->applyFromArray( $defaultStyle );
				$sheet->setCellValue( "C".$indexOfShareholders, $finalArray['Excel Data']['shareholder'][$j][ 'end-shares' ])->getStyle("C".$indexOfShareholders)->applyFromArray( $defaultStyle );
				
			}
		}

		$i = 0;
	    $index = 1;
	    $logs->logWrite( "SHP Excel Generation Loop ends" );
	    try {
	        $writer = new Xlsx( $spreadsheet );
	        try {
	        	if( !file_exists( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] ) ) { // Check directory exists or create a directory in admin output folder
		        	try {
			        	if( mkdir( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ] ) ) {
							chmod( dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ], 0777 );
						} else {
							$errorReport++;
							$errorArray[ $cin ]['common'][] = "Directory creation in server failed";
						}
					} catch( Exception $e ) {
						echo $e->getMessage();
					}
				}
				
	            $csvFile = dirname(__FILE__).'/output/' . $finalArray[ 'Company name' ].'/'. $finalArray[ 'Company name' ] . '_SHP.xlsx';
	           	//echo $csvFile;exit();
	            $writer->save( $csvFile ); // Save generated excel in folder

	            try {
		            $old = umask(0);
					chmod( $csvFile , 0777 );
					umask($old);   
				} catch( Exception $e ) {
					echo $e->getMessage();
				}
	            $logs->logWrite( "SHP Excel Created" );    

	        } catch( Exception $e ) {
	        	
	        	$errorReport++;
	        	$errorArray[ $cin ]['common'][] = "SHP Excel write failed";
	        }
	    } catch( Exception $e ) {
	    	//echo "error";exit();
	    	$errorReport++;
	    	$errorArray[ $cin ]['common'][] = "Spreadsheet Plugin problem";
		}
		
	    return array( 'error' => $errorReport, 'error_array' => $errorArray  );
	}			
}
?>