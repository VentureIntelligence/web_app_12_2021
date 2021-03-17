<?php
/**
 * XBRL PARSING - FORM POSTING DATA PROCESSING
 *
 * Posted data fromt the view are looped through the CIN number given. These individual CIN is checked in s3 bucket. 
 * If folder with CIN exist, Folder type is cross checked with the given format. ( N - ind-as, O - in-gaap ).
 * If folder type check is passed, Requested file type is checked and Passed to XML parsing.
 * With parsed XML data, Requested excel is generated and data is uploaded to DB.
 *
 * Main class files are class.xmlparse.php, class.excelgenerate.php, class.logs.php, class.addcfinancials.php
 *
 *
 * 
 * @author     Jagdeesh MV <jagadeesh@kutung.in>
 * @version    1.0
 * @created    20-07-2018
 */

// Required class files and configuration files include.
include "../header.php";
require 'vendor/autoload.php';
require(dirname(__FILE__).$dir."/xml/XML.php"); // PLUGIN FILES
require(dirname(__FILE__).$dir."/xml/XBRL.php"); // PLUGIN FILES
require(dirname(__FILE__).$dir."/class.xmlprase.php"); // OWN FILES
require(dirname(__FILE__).$dir."/class.excelgenerate.php"); // OWN FILES
require(dirname(__FILE__).$dir."/class.logs.php"); // OWN FILES
require(dirname(__FILE__).$dir."/class.addcfinancials.php");
require_once "../../aws.php";	// load logins
require_once('../../aws.phar');
require_once MODULES_DIR."xbrl.php";
require_once MODULES_DIR."xbrl2.php";
require_once MODULES_DIR."cprofile.php";
/*For Export All Excel*/
include_once('vendor/PHPExcel/Classes/PHPExcel.php');
require_once MODULES_DIR."industries.php";
$industries = new industries();
require_once MODULES_DIR."sectors.php";
$sectors = new sectors();
require_once MODULES_DIR."city.php";
$city = new city();
require_once MODULES_DIR."countries.php";
$countries = new countries();

use Aws\S3\S3Client;

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\IOFactory;

// Timezone to asia/kolkatta
date_default_timezone_set('Asia/Kolkata');

// Global variables to use in class files.
global $logs;
global $xbrl;
global $xbrl2;
global $Insert_XBRL2;
// Class intialization & variable intialization
$xbrl = new xbrl_insert();
$xbrl2 = new xbrl2();
$xml = new XML();
$xmlParse = new XmlFetch();
$Excelgenerate = new Excelgenerate();
$addcfinancials = new addcfinancials();
$cprofile = new cprofile();
$processedCin = array(); // Variable for identifaying the index of the cin in view to display the errors. This processed value will be added in log_table.
$logfolder = 'logs';

// S3 Client creating using the key and secret key.
$client = S3Client::factory(array(
    'key'    => $GLOBALS['key'],
    'secret' => $GLOBALS['secret']
));

if( isset( $_POST ) ) { // Checking for is post.
	$run_id = $_POST[ 'run_id' ];
	$tempData = $tempData1 = array(); // Intializing the tempdata for each cin operation. This is used for IN-GAAP format alone.
	foreach( $_POST[ 'req_answer' ][ 'cin' ] as $inputkey => $cin ) { // Looping the posted cin numbers.
		if( !empty( $cin ) ) { // Checking cin number is not empty
			if( !array_key_exists( $cin, $processedCin ) ) {
				$processedCin[ $cin ] = 0;	
			} else {
				$processedCin[ $cin ] = $processedCin[ $cin ] + 1;
			}
			// Initiaize data
			$cinMissmatch = false;
			$finalArray = array();
			$fyYear = array();
			$fyYear1 = array();
			$sfyYear = array();
			$xbrlretval = array();
			$xbrlshpValue = array();
			$companyName = '';
			$companyNature = '';

			$type = $_POST[ 'req_answer' ][ 'folder' ][ $inputkey ];
			$excel_type = $_POST[ 'req_answer' ][ 'type' ][ $inputkey ];
			$Insert_XBRL2['xml_type'] = $type;
        	$Insert_XBRL2['excel_type'] = $excel_type;
			$addPL = true;
			$addBS = true;
			$addCF = true;
			$isSHP = false;
			$maxYearSHP = 0;
			$xmlFliesForSHP = '';
			$dateTime = date( 'dmYhis' );
			$logFileName = "logs".$dateTime;
			// Log class intialize for individual cin with file name and run id.
			$logs = new Logs( $logfolder, $cin, $run_id, $logFileName, $processedCin[ $cin ], $type, $excel_type, $isSHP );
			$startComment = "Started at " . date( 'd-m-Y h:i:s' );
			$logs->logWrite( $startComment );
			try {
				if( $type == 'N' ) { // XML file type identification
					$xbrlFolder = 'ind-as';
				} else {
					$xbrlFolder = 'in-gaap';
				}
				if( $excel_type == 'S' ) { // XML to be parsed standalone or consolidate condition check.
					$checkFile = 'Standalone';
				} else if( $excel_type == 'C' ) {
					$checkFile = 'Consolidated';
				}
				// List of XML's in s3.
				$objects = $client->ListObjects(array(
				    'Bucket' => $GLOBALS['bucket'],
				    'Delimiter' => '/',
				    'Prefix' => 'XBRL/'.$cin.'/'.$xbrlFolder.'/'
				));
				$j = 0;
				$fileCount = $fileCheckCount = $completedCount = 0;
				$isUpdated = false;
				$error = false;
				/*foreach( $objects as $object ) {
					if( is_array( $object ) && !empty( $object ) ) {
						echo '<pre>'; print_r( $object ); echo '</pre>';
					}
				}
				exit;*/
				$indasfilecount = 0;
				if($xbrlFolder == 'in-gaap'){
					$objectindas = $client->ListObjects(array(
						'Bucket' => $GLOBALS['bucket'],
						'Delimiter' => '/',
						'Prefix' => 'XBRL/'.$cin.'/ind-as/'
					));
					foreach( $objectindas as $object ) {
						if( is_array( $object ) && !empty( $object ) ) {
							if(count($object) > 1){
								$indasfilecount = count($object);
								break;
							}
						}
					}
				}
				
				if($indasfilecount > 1 && $excel_type == 'S'){
					$shpValue = findmaxyearxmlfile($objectindas,$checkFile,$client,'ind-as');
				} else if($indasfilecount == 0 && $excel_type == 'S'){ 
					$shpValue = findmaxyearxmlfile($objects,$checkFile,$client,$xbrlFolder);
				}
				$logs->logWrite( "XBRL2 Started" );
				if(!empty($shpValue['xmlFliesForSHP'])){
					$filefolder = 'XBRL/'.$cin.'/'.$shpValue['folderType'].'/'.$shpValue['xmlFliesForSHP'];
					$fileurl = $client->getObjectUrl('companyfilings', $filefolder, '+60 minutes');
					$content = $xml->perseXml( $fileurl ); // Get XML data using s3 file url.
					//print_r($content[ 'xbrl' ][ 'in-ca' ]);
					//exit();
					$maxyeararray = explode("_",$shpValue['xmlFliesForSHP']);
					$maxyeararray1 = explode(".",end($maxyeararray));
					$maxYearSHP = substr( $maxyeararray1[0], -2);
					
					if( $excel_type == 'S' ) {
						$logs->logWrite( "SHP standalone entered" );
						$xbrlshpValue = $xmlParse->xbrlSHP( $content[ 'xbrl' ][ 'in-ca' ], $cin );
					} else {
						$logs->logWrite( "SHP standalone condition failed", true );
						$xbrl->update_upload_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
					}
				}
				

				foreach ($objects as $xmlFliesList) {

					if( is_array( $xmlFliesList ) && !empty( $xmlFliesList ) ) {

						foreach( $xmlFliesList as $fileIndex => $filePath ) { // Looping thorugh XML files.
							if( $j > 0 ) {
								// FY getting from XML will be stored in fyYear and sfyYear(Short form of year).
								$fyYear = array();
								$sfyYear = array();
								$plContextArray = $bsContextArray = $cfContextArray = array();
								
								if( array_key_exists( 'Key', $filePath ) ) {

									if( ( stripos( $filePath[ 'Key' ], $checkFile ) !== false ) || ( stripos( $filePath[ 'Key' ], strtoupper( $checkFile ) ) !== false ) || ( stripos( $filePath[ 'Key' ], strtolower( $checkFile ) ) !== false ) ) { // Check XML file exists for the user given types.
										if( stripos( $filePath[ 'Key' ], 'completed/') !== false ) {
											$completedCount++;
										}
										$fileName = basename( $filePath[ 'Key' ] ); // XML File Name
										$fileurl = $client->getObjectUrl('companyfilings', $filePath[ 'Key' ], '+60 minutes');
										$content = $xml->perseXml( $fileurl ); // Get XML data using s3 file url.
										$companyCIN = $content[ 'xbrl' ][ 'in-ca' ][ 'CorporateIdentityNumber' ][ 0 ][ '_value:' ];

										if( $companyCIN != $cin && $completedCount == 0 ) { // CIN condition check.
											if($companyCIN != ''){
												$cinMissmatch = true;
												$xbrl->update_upload_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
												$logs->logWrite( "CIN missmatch in file " . $fileurl . "", true );
											} else {
												$xbrl->update_upload_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
												$logs->logWrite( "S3 browser connection issue " . $fileurl . "", true );
											}
											//break;
										} else {
											$Insert_XBRL2['CIN'] = $cin;
											$isUpdated = true;
											/* 	
												Loop to get the context of the given XML. 
												This is used for getting value in XML using the particular field with in array condition of context referrence.
											*/
											foreach( $content[ 'xbrl' ]['xbrli']['context'] as $contextLoopFirst ) {
												$contextID = $contextLoopFirst[ '_attributes:' ][ 'id' ];
												if( array_key_exists( 'xbrli', $contextLoopFirst ) ) {
													foreach( $contextLoopFirst[ 'xbrli' ] as $contextLoopPeriod ) {
														if( array_key_exists( 'instant', $contextLoopPeriod[0][ 'xbrli' ] ) && !array_key_exists( 'scenario', $contextLoopFirst[ 'xbrli' ] ) ) {
															$yearTemp = date( 'Y', strtotime( $contextLoopPeriod[0][ 'xbrli' ][ 'instant' ][0][ '_value:' ] ) );
															$syearTemp = date( 'y', strtotime( $contextLoopPeriod[0][ 'xbrli' ][ 'instant' ][0][ '_value:' ]) );
															$montTemp = date( 'm-d', strtotime( $contextLoopPeriod[0][ 'xbrli' ][ 'instant' ][0][ '_value:' ]) );
															if($montTemp == '12-31'){
																$yearTemp = $yearTemp + 1;
															}
															if( !in_array( $contextID, $bsContextArray[ $yearTemp ] ) && !array_key_exists( $yearTemp, $bsContextArray ) ) {
																$bsContextArray[ $yearTemp ][0] = $contextID;	
															}
															if( !in_array( $yearTemp, $fyYear1 ) ) {
																$monthDate[$yearTemp] = $montTemp;
															}
															if( !in_array( $yearTemp, $fyYear ) ) {
																$fyYear[] = $yearTemp;
																$fyYear1[$yearTemp] = $yearTemp;  	
																$sfyYear[] = $syearTemp;
																//$monthDate[$yearTemp] = $montTemp;
															}
														}
														if( array_key_exists( 'endDate', $contextLoopPeriod[0][ 'xbrli' ] ) && !array_key_exists( 'scenario', $contextLoopFirst[ 'xbrli' ] ) ) {
															$yearTemp = date( 'Y', strtotime( $contextLoopPeriod[0][ 'xbrli' ][ 'endDate' ][0][ '_value:' ] ) );
															$syearTemp = date( 'y', strtotime( $contextLoopPeriod[0][ 'xbrli' ][ 'endDate' ][0][ '_value:' ] ) );
															$montTemp = date( 'm-d', strtotime( $contextLoopPeriod[0][ 'xbrli' ][ 'endDate' ][0][ '_value:' ]) );
															if($montTemp == '12-31'){
																$yearTemp = $yearTemp + 1;
															}
															if( !in_array( $contextID, $plContextArray[ $yearTemp ] ) ) {
																$plContextArray[ $yearTemp ][0] = $contextID;	
															}
															if( !in_array( $yearTemp, $fyYear1 ) ) {
																$monthDate[$yearTemp] = $montTemp;
															}
															if( !in_array( $yearTemp, $fyYear ) ) {
																$fyYear[] = $yearTemp; 	
																$fyYear1[$yearTemp] = $yearTemp;
																$sfyYear[] = $syearTemp;
																//$monthDate[$yearTemp] = $montTemp;
															}
														}

														//cashflow array
														if( array_key_exists( 'endDate', $contextLoopPeriod[0][ 'xbrli' ] ) && !array_key_exists( 'scenario', $contextLoopFirst[ 'xbrli' ] ) ) {
															
															
															$yearTemp = date( 'Y', strtotime( $contextLoopPeriod[0][ 'xbrli' ][ 'endDate' ][0][ '_value:' ] ) );
															$syearTemp = date( 'y', strtotime( $contextLoopPeriod[0][ 'xbrli' ][ 'endDate' ][0][ '_value:' ] ) );
															$montTemp = date( 'm-d', strtotime( $contextLoopPeriod[0][ 'xbrli' ][ 'endDate' ][0][ '_value:' ]) );
															if($montTemp == '12-31'){
																$yearTemp = $yearTemp + 1;
															}
															if( !in_array( $contextID, $cfContextArray[ $yearTemp ] ) ) {
																$cfContextArray[ $yearTemp ][0] = $contextID;
															}
															if( !in_array( $yearTemp, $fyYear1 ) ) {
																$monthDate[$yearTemp] = $montTemp;
															}
															if( !in_array( $yearTemp, $fyYear ) ) {
																$fyYear[] = $yearTemp; 	
																$fyYear1[$yearTemp] = $yearTemp; 
																$sfyYear[] = $syearTemp;
																//$monthDate[$yearTemp] = $montTemp;
															}
															
														}
														
													}
												} else {
													foreach( $contextLoopFirst[''] as $contextLoopPeriod ) {
														if( array_key_exists( 'instant', $contextLoopPeriod[0] ) ) {
															$yearTemp = date( 'Y', strtotime( $contextLoopPeriod[0][ 'instant' ][0][ '_value:' ] ) );
															$syearTemp = date( 'y', strtotime( $contextLoopPeriod[0][ 'instant' ][0][ '_value:' ] ) );
															$montTemp = date( 'm-d', strtotime( $contextLoopPeriod[0][ 'instant' ][0][ '_value:' ]) );
															if($montTemp == '12-31'){
																$yearTemp = $yearTemp + 1;
															}
															if( !in_array( $contextID, $bsContextArray[ $yearTemp ] ) ) {
																$bsContextArray[ $yearTemp ][0] = $contextID;	
															}
															if( !in_array( $yearTemp, $fyYear1 ) ) {
																$monthDate[$yearTemp] = $montTemp;
															}
															if( !in_array( $yearTemp, $fyYear ) ) {
																$fyYear[] = $yearTemp; 	
																$fyYear1[$yearTemp] = $yearTemp; 
																$sfyYear[] = $syearTemp;
																//$monthDate[$yearTemp] = $montTemp;
															}
														}
														if( array_key_exists( 'endDate', $contextLoopPeriod[0] ) ) {
															$yearTemp = date( 'Y', strtotime( $contextLoopPeriod[0][ 'endDate' ][0][ '_value:' ] ) );
															$syearTemp = date( 'y', strtotime( $contextLoopPeriod[0][ 'endDate' ][0][ '_value:' ] ) );
															$montTemp = date( 'm-d', strtotime( $contextLoopPeriod[0][ 'endDate' ][0][ '_value:' ]) );
															if($montTemp == '12-31'){
																$yearTemp = $yearTemp + 1;
															}
															if( !in_array( $contextID, $plContextArray[ $yearTemp ] ) ) {
																$plContextArray[ $yearTemp ][0] = $contextID;	
															}
															if( !in_array( $yearTemp, $fyYear1 ) ) {
																$monthDate[$yearTemp] = $montTemp;
															}
															if( !in_array( $yearTemp, $fyYear ) ) {
																$fyYear[] = $yearTemp; 
																$fyYear1[$yearTemp] = $yearTemp; 		
																$sfyYear[] = $syearTemp;
																//$monthDate[$yearTemp] = $montTemp;
															}
														}
														//cashflow array
														if( array_key_exists( 'endDate', $contextLoopPeriod[0] ) ) {

															$yearTemp = date( 'Y', strtotime( $contextLoopPeriod[0][ 'endDate' ][0][ '_value:' ] ) );
															$syearTemp = date( 'y', strtotime( $contextLoopPeriod[0][ 'endDate' ][0][ '_value:' ] ) );
															$montTemp = date( 'm-d', strtotime( $contextLoopPeriod[0][ 'endDate' ][0][ '_value:' ]) );
															if($montTemp == '12-31'){
																$yearTemp = $yearTemp + 1;
															}
															if( !in_array( $contextID, $cfContextArray[ $yearTemp ] ) ) {
																$cfContextArray[ $yearTemp ][0] = $contextID;	
															}
															if( !in_array( $yearTemp, $fyYear1 ) ) {
																$monthDate[$yearTemp] = $montTemp;
															}
															if( !in_array( $yearTemp, $fyYear ) ) {
																$fyYear[] = $yearTemp; 	
																$fyYear1[$yearTemp] = $yearTemp; 	
																$sfyYear[] = $syearTemp;
																//$monthDate[$yearTemp] = $montTemp;
															}
															
														}
														
														
													}
												}
											}
											/* Context ref Loop ends */
											$periodEndArray = $content[ 'xbrl' ][ 'in-ca' ][ 'DateOfEndOfReportingPeriod' ];
											$periodStartArray = $content[ 'xbrl' ][ 'in-ca' ][ 'DateOfStartOfReportingPeriod' ];
											$startInc = 0;
											$fyoldArrayPartial = array(); // Partial array check for OLD format.
											foreach( $periodStartArray as $periodStart ) { // FY start year loop.
												$startyear = $periodStart[ '_value:' ];
												$startyearTemp = date( 'Y', strtotime( $startyear ) );
												$startsyearTemp = date( 'y', strtotime( $startyear ) );
												$nextyearTemp = date( 'Y', strtotime( $startyear ) ) + 1;
												$startRef = $periodStart[ '_attributes:' ][ 'contextRef' ];
												if( !in_array( $startyearTemp, $fyoldArrayPartial ) ) {
													$fyoldArrayPartial[] = $startyearTemp;
												}
												$startInc++;
											}
											foreach( $periodEndArray as $periodEnd ) { // FY end yar loop
												$endYear = $periodEnd[ '_value:' ];
												$endyearTemp = date( 'Y', strtotime( $endYear ) );
												$endsyearTemp = date( 'y', strtotime( $endYear ) );
												if( !in_array( $endyearTemp, $fyoldArrayPartial ) ) {
													$fyoldArrayPartial[] = $endyearTemp;
												}
											}
											/*echo '============================================================================<br/>';
											echo $fileurl . '<br/>';*/
											//echo '<pre>'; print_r( $fyoldArrayPartial ); echo '</pre>';
											// Looping for identifying the partial or full data using the start year and end year loop data.
											foreach( $fyoldArrayPartial as $paritalVal ) {
												$maxValue = max( $fyoldArrayPartial );
												if( $maxValue == $paritalVal ) {
													$fyoldArray[ $paritalVal ] = 'Partial';
												} else {
													$fyoldArray[ $paritalVal ] = 'Full';
												}
											}
											/*echo '<pre>'; print_r( $fyoldArray ); echo '</pre>';*/
											$step1 = "Requested For Type = " . $type . " Excel Type = " . $checkFile . " - XML Found - " . $filePath[ 'Key' ];
											$logs->logWrite( $step1 );
											if( empty( $companyNature ) ) {
												$companyNature = $content[ 'xbrl' ][ 'in-ca' ][ 'NatureOfReportStandaloneConsolidated' ][ 0 ][ '_value:' ];
											}
											if( $companyNature == 'Standalone' && $excel_type != 'S' ) { // Standlaone condition check
												$logs->logWrite( "S3 xml is wrong or not requested format is not found in xml", true );
												$xbrl->update_upload_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
											} else if( $companyNature == 'Consolidated' && $excel_type != 'C' ) { // Consolidated condition check
												$logs->logWrite( "S3 xml is wrong or not requested format is not found in xml", true );
												$xbrl->update_upload_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
											} else if( $companyNature == 'Standalone' && $excel_type == 'S' || $companyNature == 'Consolidated' && $excel_type == 'C' ) { //processing the XML file
												$logs->logWrite( "S3 xml file check success" );
												$fyYear = array_unique( $fyYear );
												$sfyYear = array_unique( $sfyYear );
												rsort( $fyYear );
												rsort( $sfyYear );

												//echo '<pre>'; print_r( $monthDate ); echo '</pre>';
												//echo '<pre>'; print_r( $fyYear ); echo '</pre>';

												$maxyear = max( $fyYear );
												$cni = 0;
												foreach( $content[ 'xbrl' ][ 'in-ca' ][ 'NameOfCompany' ] as $companyNameLoop ) {
													if( in_array( $content[ 'xbrl' ][ 'in-ca' ][ 'NameOfCompany' ][ $cni ][ '_attributes:' ][ 'contextRef' ], $plContextArray[ $maxyear ] ) ) {
														$companyName = strtoupper( $content[ 'xbrl' ][ 'in-ca' ][ 'NameOfCompany' ][ $cni ][ '_value:' ] );
													}
													$cni++;
												}
												$finalArray[ 'Company name' ] = $companyName;
												
												$logs->logWrite( "Starting xml and requested format check for old or new" );
												if( array_key_exists( 'ind-as', $content[ 'xbrl' ] ) ) { // Check the XML has ind-as kay for new format.
													if( $type == 'N' ) { // Check whether new format condition satisfied
														$logs->logWrite( "New format condition staisfied" );
														if( $excel_type == 'S' ) { // Check whether it is standalone or consolidated.
															$logs->logWrite( "New format & Excel type standalone entered" );
															$xbrlretval = $xmlParse->xbrlNewFormatStandalone( $content[ 'xbrl' ][ 'ind-as' ], $fyYear, $cin, $plContextArray, $bsContextArray,$cfContextArray  );
															$compledtedArray[ $cin ][ 'ind-as' ][] = array( 'fileUrl' => $fileurl, 'fileName' => $fileName ); // GET XML filename and file url for moving to compledted folder.
														} else if( $excel_type == 'C' ) {
															$logs->logWrite( "New format - Excel type consolidate entered" );
															$xbrlretval = $xmlParse->xbrlNewFormatConsolidated( $content[ 'xbrl' ][ 'ind-as' ], $fyYear, $cin, $plContextArray, $bsContextArray,$cfContextArray );
															$compledtedArray[ $cin ][ 'ind-as' ][] = array( 'fileUrl' => $fileurl, 'fileName' => $fileName ); // GET XML filename and file url for moving to compledted folder.
														} else {
															$logs->logWrite( "New format & Excel type both condition failed", true );
															$xbrl->update_upload_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
														}
													} else {
														$logs->logWrite( "New format condition failed", true );
														$xbrl->update_upload_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
													}
												} else if( array_key_exists( 'in-gaap', $content[ 'xbrl' ] ) ) { // Check the XML has in-gapp for old format.

													if( $type != 'N' ) { // Check whether new format condition satisfied
														$logs->logWrite( "Old format condition staisfied" );
														if( $excel_type == 'S' ) {
															$logs->logWrite( "Old format & Excel type standalone entered" );
															$xbrlretval = $xmlParse->xbrlOldFormatStandalone( $content[ 'xbrl' ][ 'in-gaap' ], $fyYear, $cin, $plContextArray, $bsContextArray,$cfContextArray, $fyoldArray, $tempData );
															$tempData = $xbrlretval;
															$compledtedArray[ $cin ][ 'in-gaap' ][] = array( 'fileUrl' => $fileurl, 'fileName' => $fileName ); // GET XML filename and file url for moving to compledted folder.
														} else if( $excel_type == 'C' ) {
															$logs->logWrite( "Old format & Excel type consolidate entered" );
															$xbrlretval = $xmlParse->xbrlOldFormatConsolidated( $content[ 'xbrl' ][ 'in-gaap' ], $fyYear, $cin, $plContextArray, $bsContextArray,$cfContextArray, $fyoldArray, $tempData1 );
															$tempData1 = $xbrlretval;
															$compledtedArray[ $cin ][ 'in-gaap' ][] = array( 'fileUrl' => $fileurl, 'fileName' => $fileName ); // GET XML filename and file url for moving to compledted folder.	
														} else {
															$logs->logWrite( "Old format - Excel type both condition failed", true );
															$xbrl->update_upload_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
														}
													} else {
														$logs->logWrite( "Old format condition failed", true );
														$xbrl->update_upload_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
													}
												} else {
													$logs->logWrite( "Invalid format", true );
													$xbrl->update_upload_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
												}
												//echo '----------------------------------------------------------------------------------------------<br/>';
											}
										}
									} else {
										$fileCheckCount = $fileCheckCount + 1;
									}
								}
								
								$fileCount++;
							}
							$j++;
						}
					}
					/*if( $cinMissmatch ) { // CIN mismatch error. Update log_table with upload error.
						$xbrl->update_upload_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
						$logs->logWrite( "CIN missmatch in file " . $fileurl . "" );
						//break;
					}*/ // Requested by VI team to hide the condition. Instead of stopping the process run for remaining FY if CIN missmatch.
				}
				$logs->logWrite( "<<<<<<<< End of XML loop from s3 >>>>>>>>" );

				if( !empty( $xbrlshpValue[ 'promoters' ] ) || !empty( $xbrlshpValue[ 'shareholder' ] )) {
					if( $excel_type == 'S' ) { // Satndalone excel generate function call if condition satisfied.
						if( !empty( $xbrlshpValue[ 'promoters' ] ) || !empty( $xbrlshpValue[ 'shareholder' ] ) ) { // PLSTD excel generate
							$finalArray[ 'Excel Data' ] = $xbrlshpValue;
							$finalArray[ 'Company name' ] = $companyName;
							$logs->logWrite( "Add SHP Array Into Excel creation starting" );
							$SHPExcelgenerate = $Excelgenerate->shpExcelgenerate( $finalArray, $cin);
							$excelFilePathSHP = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_SHP.xlsx';
						}
					}
				}
				
	     		//exit();
				if( !empty( $xbrlshpValue[ 'promoters' ] ) || !empty( $xbrlshpValue[ 'shareholder' ] ) ) {
					$xbrl->update_SHP( $run_id, $cin, $processedCin[ $cin ], $logFileName );
					$addcfinancials->addSHPdata( $cin, $excelFilePathSHP, $type, $run_id, $processedCin[ $cin ], $logFileName, $maxYearSHP );
				}
				$pltargetarray = array();
				$pltargetarray = $xbrlretval['data']['pl'];
				$pltargetyear=max(array_keys($pltargetarray)) - 1;
				$pltargetarray = $pltargetarray[$pltargetyear];

				$bstargetarray = array();
				$bstargetarray = $xbrlretval['data']['bs'];
				$bstargetyear=max(array_keys($bstargetarray)) - 1;
				$bstargetarray = $bstargetarray[$bstargetyear];

				$targetPLExcel = '';
				$targetBSExcel = '';
				
				if( $type == 'O' ) {
					if( $excel_type == 'S' ) {
						$targetPLExcel = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_PL_STANDALONE_OLD.xlsx';
						$targetBSExcel = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_BS_STANDALONE_OLD.xlsx';

					}
					else if( $excel_type == 'C' ) { 
						$targetPLExcel = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_PL_CONSOLIDATED_OLD.xlsx';
						$targetBSExcel = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_BS_CONSOLIDATED_OLD.xlsx';
					}
				}
				else if( $type == 'N' ) {
					if( $excel_type == 'S' ) {
						$targetPLExcel = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_PL_STANDALONE_NEW.xlsx';
						$targetBSExcel = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_BS_STANDALONE_NEW.xlsx';
					}
					else if( $excel_type == 'C' ) { 
						$targetPLExcel = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_PL_CONSOLIDATED_NEW.xlsx';
						$targetBSExcel = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_BS_CONSOLIDATED_NEW.xlsx';
					}
				}
				
				$isPLrestate = comparePLExcel($pltargetyear,$pltargetarray,$targetPLExcel,$type,$excel_type,$companyName,$run_id);
				$isBSrestate = compareBSExcel($bstargetyear,$bstargetarray,$targetBSExcel,$type,$excel_type,$companyName,$run_id);
				
				if($isPLrestate == true || $isBSrestate == true){
					
					if(file_exists($targetPLExcel)){
						if($isPLrestate == true)
						{
							if( $type == 'O' ) {
								if( $excel_type == 'S' ) {
									copy($targetPLExcel,MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_PL_STANDALONE_OLD_'.$run_id.'.xlsx');
								}else if( $excel_type == 'C' ) { 
									copy($targetPLExcel,MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_PL_CONSOLIDATED_OLD_'.$run_id.'.xlsx');
								}
							}
							else if( $type == 'N' ) {
								if( $excel_type == 'S' ) {
									copy($targetPLExcel,MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_PL_STANDALONE_NEW_'.$run_id.'.xlsx');
								}else if( $excel_type == 'C' ) { 
									copy($targetPLExcel,MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_PL_CONSOLIDATED_NEW_'.$run_id.'.xlsx');
								}
							}
							
						}
					}
					
					if(file_exists($targetBSExcel)){
						if($isBSrestate == true)
						{
							if( $type == 'O' ) {
								if( $excel_type == 'S' ) {
									copy($targetBSExcel,MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_BS_STANDALONE_OLD_'.$run_id.'.xlsx');
								}else if( $excel_type == 'C' ) { 
									copy($targetBSExcel,MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_BS_CONSOLIDATED_OLD_'.$run_id.'.xlsx');
								}
							}
							else if( $type == 'N' ) {
								if( $excel_type == 'S' ) {
									copy($targetBSExcel,MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_BS_STANDALONE_NEW_'.$run_id.'.xlsx');
								}else if( $excel_type == 'C' ) { 
									copy($targetBSExcel,MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_BS_CONSOLIDATED_NEW_'.$run_id.'.xlsx');
								}
							}
						}
					}
					$Companies = $cprofile->updateRestart( $cin , true );
					$Companieslog = $xbrl->updateRestart( $cin,$run_id, true );
				} else {
					$Companies = $cprofile->updateRestart( $cin , false );
					$Companieslog = $xbrl->updateRestart( $cin,$run_id, false );
				}

				// echo '<pre>'; print_r( $xbrlretval ); echo '</pre>';
				// exit;
				//T-580 XBRL: METAROLLS ISPAT PRIVATE LIMITED - Excel not generated changes
				$where = "CIN = '" . $cin . "'";
						$Companies = $cprofile->getCompaniesAutoSuggest( $where );
						foreach ($Companies as $key => $value) {
						  $Companies_original= $value;
						}
						$comparevalue=strcmp($Companies_original,$finalArray[ 'Company name' ]);
						if($comparevalue != 0 ){
							if($cin == $companyCIN )
							{
								$finalArray[ 'Company name' ] = $companyName = $Companies_original;	

							}
							else{
								 $logs->logWrite( "Company name and cin mismatch" ); 
								 $xbrl->update_upload_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
								 unset($xbrlretval);
								 $xbrlretval = array();
							}
						}
				
				if( !empty( $xbrlretval ) /*&& !$cinMissmatch*/ ) { // Checking data returned from the xml parse class.
					/* Processing the Old format XML. If condition satisfied create Excel for old format. */
					if( $type == 'O' ) {
						if( !array_key_exists( 'common', $xbrlretval[ 'error_array' ][ $cin ] ) ) { // Check common array exists. This is error is for XML format not supported.
							if( $xbrlretval[ 'error' ] > 0 ) { // Update error in log_table as validation error
								$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
							}
							$finalArray[ 'Excel Data' ] = $xbrlretval[ 'data' ];
							if( $excel_type == 'S' ) { // Satndalone excel generate function call if condition satisfied.
								if( !empty( $xbrlretval[ 'data' ][ 'pl' ] ) ) { // PLSTD excel generate
									$logs->logWrite( "Add financial for type old pl standalone excel create starting" );
									$plExcelgenerate = $Excelgenerate->plstdStandaloneExcelgenerate( $finalArray, $sfyYear, $cin, 'old', $monthDate );
									$excelFilePathPL = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_PL_STANDALONE_OLD.xlsx';
								} else {
									$addPL = false;
								}
								if( !empty( $xbrlretval[ 'data' ][ 'bs' ] ) ) { // BS excel generate
									$logs->logWrite( "Add financial for type old bs standalone excel create starting" );
									$bsExcelgenerate = $Excelgenerate->bsStandaloneExcelgenerate( $finalArray, $sfyYear, $cin, 'old', $monthDate );
									$excelFilePathBS = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_BS_STANDALONE_OLD.xlsx';
								} else {
									$addBS = false;
								}

								if( !empty( $xbrlretval[ 'data' ][ 'cf' ] ) ) { // CF excel generate
									
									$logs->logWrite( "Add financial for type old Cash-Flow standalone excel create starting" );
									$cfExcelgenerate = $Excelgenerate->cfStandaloneExcelgenerate( $finalArray, $sfyYear, $cin, 'old', $monthDate );
									$excelFilePathCF = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_CF_STANDALONE_OLD.xlsx';
								} else {
									$addCF = false;
								}
							} else if( $excel_type == 'C' ) { // Consolidated excel generate function call if condition satisfied.
								if( !empty( $xbrlretval[ 'data' ][ 'pl' ] ) ) { // PLSTD excel generate
									$logs->logWrite( "Add financial for type old pl consolidated excel create starting" );
									$plExcelgenerate = $Excelgenerate->plstdConsolidatedExcelgenerate( $finalArray, $sfyYear, $cin, 'old', $monthDate );
									$excelFilePathPL = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_PL_CONSOLIDATED_OLD.xlsx';
								} else {
									$addPL = false;
								}
								if( !empty( $xbrlretval[ 'data' ][ 'bs' ] ) ) { // BS excel generate
									$logs->logWrite( "Add financial for type old bs consolidated excel create starting" );
									$bsExcelgenerate = $Excelgenerate->bsConsolidatedExcelgenerate( $finalArray, $sfyYear, $cin, 'old', $monthDate );
									$excelFilePathBS = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_BS_CONSOLIDATED_OLD.xlsx';
								} else {
									$addBS = false;
								}
								if( !empty( $xbrlretval[ 'data' ][ 'cf' ] ) ) { // CF excel generate
									$logs->logWrite( "Add financial for type old Cash-Flow consolidated excel create starting" );
									$cfExcelgenerate = $Excelgenerate->cfConsolidatedExcelgenerate( $finalArray, $sfyYear, $cin, 'old', $monthDate );
									$excelFilePathCF = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_CF_CONSOLIDATED_OLD.xlsx';
								} else {
									$addCF = false;
								}
							}
							/*
								PLSTD generate excel error check.
								If error update validation error.
								Else addcfinancial call for plstandaloneadd
								Parameters: cin, excel type(S|C), excelFilePathPL(generated excel path), type(OLD|NEW), run_id(for updating error log), processed cin(view index update), logfilename(current log file name).
							*/
							if( $plExcelgenerate[ 'error' ] > 0 && array_key_exists( 'common', $plExcelgenerate[ 'error_array' ][ $cin ] ) ) {
								$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
								$completeMove = false;
							} else {
								$completeMove = true;
								if( /*$xbrlretval[ 'error' ] == 0 &&*/ $addPL ) { // validation error flag check before processing addcfinancials
									$logs->logWrite( "Add financial for pl starting" );
									$addcfinancials->plstandaloneadd( $cin, $excel_type, $excelFilePathPL, $type, $run_id, $processedCin[ $cin ], $logFileName );
									$where = "CIN = '" . $cin . "'";
									$Companies = $cprofile->getCompaniesAutoSuggest( $where );
									if( empty( $Companies ) ) {
								        $completeMove = false;
									}
									$companyIDArray = array_keys ( $Companies );
									$companyID = $companyIDArray[0];
									$where2 = "Company_Id =".$companyID;
									$order="";
									$companyname = $cprofile->getCompanies($where2,$order);
									if( $excel_type == 'S' ) {
									$excelgenerateFilePathPL = FOLDER_CREATE_PATH.'plstandard/PLStandard_' . $companyID  . '.xls';
									$excelgenerateFilePathPLName= $companyname[$companyID]. '_PL_STANDALONE.xls';
									}else if( $excel_type == 'C' ) {
									$excelgenerateFilePathPL = FOLDER_CREATE_PATH.'plstandard/PLStandard_' . $companyID  . '_1.xls';
									$excelgenerateFilePathPLName= $companyname[$companyID]. '_PL_CONSOLIDATED.xls';
									}
									//echo "ingaap PL name----".$excelgenerateFilePathPLName."<br>";
									//echo "ingaap----".$excelgenerateFilePathPL."<br>";
								}
								if( $addPL ) {
									// Uploading generated excel to S3
									try {
										$result = $client->putObject(array(
									        'Bucket' => 'companyfilings',
									        'Key'    => 'XBRL_EXCEL/'.$cin.'/in-gaap/'. basename( $excelgenerateFilePathPLName ),
									        'SourceFile'   => $excelgenerateFilePathPL
									    ));	
									} catch( Exception $e ) {
										$logs->logWrite( "AWS Excel Move failed - PL OLD(" . $excel_type . ")" );
										$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
									}
									// Moving Completed 
								}
							}
							/*
								BS generate excel error check.
								If error update validation error.
								Else addcfinancial call for bsaddfinancialdata
								Parameters: cin, excel type(S|C), excelFilePathPL(generated excel path), type(OLD|NEW), run_id(for updating error log), processed cin(view index update), logfilename(current log file name).
							*/
							if( $bsExcelgenerate[ 'error' ] > 0 && array_key_exists( 'common', $bsExcelgenerate[ 'error_array' ][ $cin ] ) ) { 
								$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
								$completeMove = false;
							} else {
								$completeMove = true;
								if( /*$xbrlretval[ 'error' ] == 0 &&*/ $addBS ) { // validation error flag check before processing addcfinancials
									$logs->logWrite( "Add financial for bs starting" );
									$addcfinancials->bsaddfinancialdata( $cin, $excel_type, $excelFilePathBS, $type, $run_id, $processedCin[ $cin ], $logFileName );
									$where = "CIN = '" . $cin . "'";
									$Companies = $cprofile->getCompaniesAutoSuggest( $where );
									if( empty( $Companies ) ) {
								        $completeMove = false;
									}
									$companyIDArray = array_keys ( $Companies );
									$companyID = $companyIDArray[0];
									$where2 = "Company_Id =".$companyID;
									$order="";
									$companyname = $cprofile->getCompanies($where2,$order);
									if( $excel_type == 'S' ) {
									$excelgenerateFilePathBS = FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_' . $companyID  . '.xls';
									$excelgenerateFilePathBSName= $companyname[$companyID]. '_BS_STANDALONE.xls';

									}else if( $excel_type == 'C' ) {
									$excelgenerateFilePathBS = FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_' . $companyID  . '_1.xls';
									$excelgenerateFilePathBSName=$companyname[$companyID]. '_BS_CONSOLIDATED.xls';

									}
									//echo "ingaap BS name----".$excelgenerateFilePathBSName."<br>";
									//echo "ingaap BS----".$excelgenerateFilePathBS."<br>";
								}
								if( $addBS ) {
									// Uploading generated excel to S3.
									try {
										$result = $client->putObject(array(
									        'Bucket' => 'companyfilings',
									        'Key'    => 'XBRL_EXCEL/'.$cin.'/in-gaap/'. basename( $excelgenerateFilePathBSName ),
									        'SourceFile'   => $excelgenerateFilePathBS
									    ));
									} catch( Exception $e ) {
										$logs->logWrite( "AWS Excel Move failed BS OLD(" . $excel_type . ")" );
										$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
									}
								}

							}

							if( $cfExcelgenerate[ 'error' ] > 0 && array_key_exists( 'common', $cfExcelgenerate[ 'error_array' ][ $cin ] ) ) {
								$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
								$completeMove = false;
							} else {
								$completeMove = true;
								if( /*$xbrlretval[ 'error' ] == 0 &&*/ $addCF ) { // validation error flag check before processing addcfinancials
									$logs->logWrite( "Add financial for CF starting" );
									$addcfinancials->cfaddfinancialdata( $cin, $excel_type, $excelFilePathCF, $type, $run_id, $processedCin[ $cin ], $logFileName );
									$where = "CIN = '" . $cin . "'";
									$Companies = $cprofile->getCompaniesAutoSuggest( $where );
									if( empty( $Companies ) ) {
								        $completeMove = false;
									}
									$companyIDArray = array_keys ( $Companies );
									$companyID = $companyIDArray[0];
									$where2 = "Company_Id =".$companyID;
									$order="";
									$companyname = $cprofile->getCompanies($where2,$order);
									if( $excel_type == 'S' ) {
									$excelgenerateFilePathCF = FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_' . $companyID  . '.xls';
									$excelgenerateFilePathCFName= $companyname[$companyID]. '_CF_STANDALONE.xls';
									}else if( $excel_type == 'C' ) {
									$excelgenerateFilePathCF = FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_' . $companyID  . '_1.xls';
									$excelgenerateFilePathCFName= $companyname[$companyID]. '_CF_CONSOLIDATED.xls';
									}
									//echo "ingaap CF name----".$excelgenerateFilePathCFName."<br>";
									//echo "ingaap CF----".$excelgenerateFilePathCF."<br>";
								}
								
								if( $addCF ) {
									// Uploading generated excel to S3.
									try {
										$result = $client->putObject(array(
									        'Bucket' => 'companyfilings',
									        'Key'    => 'XBRL_EXCEL/'.$cin.'/in-gaap/'. basename( $excelgenerateFilePathCFName ),
									        'SourceFile'   => $excelgenerateFilePathCF
									    ));
									} catch( Exception $e ) {
										$logs->logWrite( "AWS Excel Move failed CF OLD(" . $excel_type . ")" );
										$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
									}
								}
							}
						}
						if( $completeMove ) {
							$logs->logWrite( "Complete Folder move started for in-gaap - " . $cin );
							foreach( $compledtedArray as $cinKey => $cinValue ) {
								foreach( $cinValue[ 'in-gaap' ] as $typeKey => $typeValue ) {
									try {
										$result = $client->copyObject([
											    //'ACL' => 'public-read',
											    'Bucket' => 'companyfilings', // REQUIRED
											    'Key' => "XBRL/" . $cinKey . "/in-gaap/completed/".$typeValue[ 'fileName' ], // REQUIRED
											    'CopySource' => 'companyfilings/XBRL/'. $cinKey .'/in-gaap/'.$typeValue[ 'fileName' ]
											]);
										// Delete an object from the bucket.
										$client->deleteObject([
										    'Bucket' => 'companyfilings',
										    'Key'    => "XBRL/" . $cinKey . "/in-gaap/".$typeValue[ 'fileName' ],
										]);
									} catch( Exception $e ) {
										/*$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
										$logs->logWrite( $e->getMessage(), true );*/
									}
								}
							}
						}
					} else if( $type == 'N' ) {
						if( !array_key_exists( 'common', $xbrlretval[ 'error_array' ][ $cin ] ) ) { // Check common array exists. This is error is for XML format not supported.
							if( $xbrlretval[ 'error' ] > 0 ) { // Update error in log_table as validation error
								$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
							}
							$finalArray[ 'Excel Data' ] = $xbrlretval[ 'data' ];
							if( $excel_type == 'S' ) {
								if( !empty( $xbrlretval[ 'data' ][ 'pl' ] ) ) { // PLSTD excel generate
									$logs->logWrite( "Add financial for type new pl standalone excel create starting" );
									$plExcelgenerate = $Excelgenerate->plstdStandaloneExcelgenerate( $finalArray, $sfyYear, $cin, 'new', $monthDate );
									$excelFilePathPL = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_PL_STANDALONE_NEW.xlsx';
								} else {
									$addPL = false;
								}
								if( !empty( $xbrlretval[ 'data' ][ 'bs' ] ) ) { // BS excel generate
									$logs->logWrite( "Add financial for type new bs standalone excel create starting" );
									$bsExcelgenerate = $Excelgenerate->bsStandaloneExcelgenerate( $finalArray, $sfyYear, $cin, 'new', $monthDate );
									$excelFilePathBS = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_BS_STANDALONE_NEW.xlsx';
								} else {
									$addBS = false;
								}
								if( !empty( $xbrlretval[ 'data' ][ 'cf' ] ) ) { // CF excel generate
									
									$logs->logWrite( "Add financial for type new Cash-Flow standalone excel create starting" );
									$cfExcelgenerate = $Excelgenerate->cfStandaloneExcelgenerate( $finalArray, $sfyYear, $cin, 'new', $monthDate );
									$excelFilePathCF = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_CF_STANDALONE_NEW.xlsx';
								} else {
									$addCF = false;
								}
							} else if( $excel_type == 'C' ) {
								if( !empty( $xbrlretval[ 'data' ][ 'pl' ] ) ) { // PLSTD excel generate
									$logs->logWrite( "Add financial for type new pl consolidated excel create starting" );
									$plExcelgenerate = $Excelgenerate->plstdConsolidatedExcelgenerate( $finalArray, $sfyYear, $cin, 'new', $monthDate );
									$excelFilePathPL = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_PL_CONSOLIDATED_NEW.xlsx';
								} else {
									$addPL = false;
								}
								if( !empty( $xbrlretval[ 'data' ][ 'bs' ] ) ) { // BS excel generate
									$logs->logWrite( "Add financial for type new bs consolidated excel create starting" );
									$bsExcelgenerate = $Excelgenerate->bsConsolidatedExcelgenerate( $finalArray, $sfyYear, $cin, 'new', $monthDate );
									$excelFilePathBS = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_BS_CONSOLIDATED_NEW.xlsx';
								} else {
									$addBS = false;
								}	
								if( !empty( $xbrlretval[ 'data' ][ 'cf' ] ) ) { // CF excel generate
									$logs->logWrite( "Add financial for type new Cash-Flow consolidated excel create starting" );
									$cfExcelgenerate = $Excelgenerate->cfConsolidatedExcelgenerate( $finalArray, $sfyYear, $cin, 'new', $monthDate );
									$excelFilePathCF = MAIN_PATH.'/admin/xbrl/output/' . $companyName . '/' . $companyName . '_CF_CONSOLIDATED_NEW.xlsx';
								} else {
									$addCF = false;
								}						
							}
							/*
								PLSTD generate excel error check.
								If error update validation error.
								Else addcfinancial call for plstandaloneadd
								Parameters: cin, excel type(S|C), excelFilePathPL(generated excel path), type(OLD|NEW), run_id(for updating error log), processed cin(view index update), logfilename(current log file name).
							*/
							if( $plExcelgenerate[ 'error' ] > 0 && array_key_exists( 'common', $plExcelgenerate[ 'error_array' ][ $cin ] ) ) {
								$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
								$completeMove = false;
							} else {
								$completeMove = true;
								if( /*$xbrlretval[ 'error' ] == 0 &&*/ $addPL ) { // validation error flag check before processing addcfinancials
									$logs->logWrite( "Add financial for pl starting" );
									$addcfinancials->plstandaloneadd( $cin, $excel_type, $excelFilePathPL, $type, $run_id, $processedCin[ $cin ], $logFileName );
									$where = "CIN = '" . $cin . "'";
									$Companies = $cprofile->getCompaniesAutoSuggest( $where );
									if( empty( $Companies ) ) {
								        $completeMove = false;
									}
									$companyIDArray = array_keys ( $Companies );
									$companyID = $companyIDArray[0];
									$where2 = "Company_Id =".$companyID;
									$order="";
									$companyname = $cprofile->getCompanies($where2,$order);
									if( $excel_type == 'S' ) {
									$excelgenerateFilePathPL = FOLDER_CREATE_PATH.'plstandard/PLStandard_' . $companyID  . '.xls';
									$excelgenerateFilePathPLName= $companyname[$companyID]. '_PL_STANDALONE.xls';
									}else if( $excel_type == 'C' ) {
									$excelgenerateFilePathPL = FOLDER_CREATE_PATH.'plstandard/PLStandard_' . $companyID  . '_1.xls';
									$excelgenerateFilePathPLName= $companyname[$companyID]. '_PL_CONSOLIDATED.xls';
									}
									//echo "indas PL name----".$excelgenerateFilePathPLName."<br>";
									//echo "indas----".$excelgenerateFilePathPL."<br>";
									/*echo $companyID;
									echo $excelFilePathPL123 ;
									exit();*/
								}
								if( $addPL ) {
									// Uploading generated excel to S3
									try {
										$result = $client->putObject(array(
									        'Bucket' => 'companyfilings',
									        'Key'    => 'XBRL_EXCEL/'.$cin.'/ind-as/'. basename( $excelgenerateFilePathPLName ),
									        'SourceFile'   => $excelgenerateFilePathPL
									    ));	
									} catch( Exception $e ) {
										$logs->logWrite( "AWS Excel Move failed - PL NEW(" . $excel_type . ")" );
										$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
									}
								}
							}
							/*
								BS generate excel error check.
								If error update validation error.
								Else addcfinancial call for bsaddfinancialdata
								Parameters: cin, excel type(S|C), excelFilePathPL(generated excel path), type(OLD|NEW), run_id(for updating error log), processed cin(view index update), logfilename(current log file name).
							*/
							if( $bsExcelgenerate[ 'error' ] > 0 && array_key_exists( 'common', $bsExcelgenerate[ 'error_array' ][ $cin ] ) ) {
								$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
								$completeMove = false;
							} else {
								$completeMove = true;
								if( /*$xbrlretval[ 'error' ] == 0 &&*/ $addBS ) { // validation error flag check before processing addcfinancials
									$logs->logWrite( "Add financial for bs starting" );
									$addcfinancials->bsaddfinancialdata( $cin, $excel_type, $excelFilePathBS, $type, $run_id, $processedCin[ $cin ], $logFileName );
									$where = "CIN = '" . $cin . "'";
									$Companies = $cprofile->getCompaniesAutoSuggest( $where );
									if( empty( $Companies ) ) {
								        $completeMove = false;
									}
									$companyIDArray = array_keys ( $Companies );
									$companyID = $companyIDArray[0];
									$where2 = "Company_Id =".$companyID;
									$order="";
									$companyname = $cprofile->getCompanies($where2,$order);
									if( $excel_type == 'S' ) {
									$excelgenerateFilePathBS = FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_' . $companyID  . '.xls';
									$excelgenerateFilePathBSName= $companyname[$companyID]. '_BS_STANDALONE.xls';

									}else if( $excel_type == 'C' ) {
									$excelgenerateFilePathBS = FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_' . $companyID  . '_1.xls';
									$excelgenerateFilePathBSName=$companyname[$companyID]. '_BS_CONSOLIDATED.xls';

									}
									//echo "indas BS name----".$excelgenerateFilePathBSName."<br>";
									//echo "indas BS----".$excelgenerateFilePathBS."<br>";
								}
								if( $addBS ) {
									// Uploading generated excel to S3
									try {
										$result = $client->putObject(array(
									        'Bucket' => 'companyfilings',
									        'Key'    => 'XBRL_EXCEL/'.$cin.'/ind-as/'. basename( $excelgenerateFilePathBSName ),
									        'SourceFile'   => $excelgenerateFilePathBS
									    ));
									} catch( Exception $e ) {
										$logs->logWrite( "AWS Excel Move failed BS NEW(" . $excel_type . ")" );
										$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
									}
								}
							}
							if( $cfExcelgenerate[ 'error' ] > 0 && array_key_exists( 'common', $cfExcelgenerate[ 'error_array' ][ $cin ] ) ) {
								$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
								$completeMove = false;
							} else {
								$completeMove = true;
								if( /*$xbrlretval[ 'error' ] == 0 &&*/ $addCF ) { // validation error flag check before processing addcfinancials
									$logs->logWrite( "Add financial for Cash-Flow starting" );
									$addcfinancials->cfaddfinancialdata( $cin, $excel_type, $excelFilePathCF, $type, $run_id, $processedCin[ $cin ], $logFileName );
									$where = "CIN = '" . $cin . "'";
									$Companies = $cprofile->getCompaniesAutoSuggest( $where );
									if( empty( $Companies ) ) {
								        $completeMove = false;
									}
									$companyIDArray = array_keys ( $Companies );
									$companyID = $companyIDArray[0];
									$where2 = "Company_Id =".$companyID;
									$order="";
									$companyname = $cprofile->getCompanies($where2,$order);
									if( $excel_type == 'S' ) {
									$excelgenerateFilePathCF = FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_' . $companyID  . '.xls';
									$excelgenerateFilePathCFName= $companyname[$companyID]. '_CF_STANDALONE.xls';
									}else if( $excel_type == 'C' ) {
									$excelgenerateFilePathCF = FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_' . $companyID  . '_1.xls';
									$excelgenerateFilePathCFName= $companyname[$companyID]. '_CF_CONSOLIDATED.xls';
									}
									//echo "indas CF name----".$excelgenerateFilePathCFName."<br>";
									//echo "indas CF----".$excelgenerateFilePathCF."<br>";
								}
								if( $addCF ) {
									// Uploading generated excel to S3
									try {
										$result = $client->putObject(array(
									        'Bucket' => 'companyfilings',
									        'Key'    => 'XBRL_EXCEL/'.$cin.'/ind-as/'. basename( $excelgenerateFilePathCFName ),
									        'SourceFile'   => $excelgenerateFilePathCF
									    ));
									} catch( Exception $e ) {
										$logs->logWrite( "AWS Excel Move failed CF NEW(" . $excel_type . ")" );
										$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
									}
								}
							}
							if( $completeMove ) {
								$logs->logWrite( "Complete Folder move started for ind-as - " . $cin );
								foreach( $compledtedArray as $cinKey => $cinValue ) {
									foreach( $cinValue[ 'ind-as' ] as $typeKey => $typeValue ) {
										try {
											$result = $client->copyObject([
											    //'ACL' => 'public-read',
											    'Bucket' => 'companyfilings', // REQUIRED
											    'Key' => "XBRL/" . $cinKey . "/ind-as/completed/".$typeValue[ 'fileName' ], // REQUIRED
											    'CopySource' => 'companyfilings/XBRL/'. $cinKey .'/ind-as/'.$typeValue[ 'fileName' ]
											]);
											// Delete an object from the bucket.
											$client->deleteObject([
											    'Bucket' => 'companyfilings',
											    'Key'    => "XBRL/" . $cinKey . "/ind-as/".$typeValue[ 'fileName' ],
											]);
										} catch( Exception $e ) {
											/*$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
											$logs->logWrite( $e->getMessage(), true );*/
										}
									}
								}
							}
						}
					}
				}
			} catch( AwsException $e ) { // Catch aws error in log file.
				$logs->logWrite( "AWS Object list failed", true );
				$xbrl->update_file_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
			}
			if( $fileCheckCount == $fileCount || $fileCheckCount == ($fileCount - $completedCount) ) { // XML found in s3 condition fails.
				$xbrl->update_file_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
				$nf = "Requested For Type = " . $type . " Excel Type = " . $checkFile . " - XML not Found in s3";
				$logs->logWrite( $nf, true );
			}
			$logs->logWrite( "End of Script" );
			$Insert_XBRL2[ 'user_name' ] = $_SESSION[ 'business' ][ 'loggedUserName' ];
			$Insert_XBRL2[ 'Added_Date' ] = date("Y-m-d H:i:s");
			$Insert_XBRL2[ 'run_id' ] = $run_id;
			$Insert_XBRL2[ 'updated_date' ] = date("Y-m-d H:i:s");
			if($isUpdated){
				$xbrl2->update( $Insert_XBRL2 );
			}
			
			/* Export All Excel Flow */
			combineAllExcel($companyID,$cprofile,$industries,$sectors,$city,$countries);
		}
	}
}

/**
* Function To Combine All the Excel of the company
*
*/
function combineAllExcel($companyID,$cprofile,$industries,$sectors,$city,$countries)
{
	
	
	$filenames = array();
	$_GET['vcid'] = $companyID;

	if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'_1.xls')){
	    $PLSTANDARD_MEDIA_PATH_CON=FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'_1.xls';
	    $filenames['P&L Consolidated'] = $PLSTANDARD_MEDIA_PATH_CON;
	}
	if(file_exists(FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'.xls')){
	    $PLSTANDARD_MEDIA_PATH=FOLDER_CREATE_PATH.'plstandard/PLStandard_'.$_GET['vcid'].'.xls';
	    $filenames['P&L Standalone'] = $PLSTANDARD_MEDIA_PATH;
	}

	if(file_exists(FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$_GET['vcid'].'_1.xls')){
	    $BSHEET_MEDIA_PATH_NEW_CON=FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$_GET['vcid'].'_1.xls';
	    $filenames['BS Consolidated'] = $BSHEET_MEDIA_PATH_NEW_CON;
	}
	if(file_exists(FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$_GET['vcid'].'.xls')){
	    $BSHEET_MEDIA_PATH_NEW=FOLDER_CREATE_PATH.'balancesheet_new/New_BalSheet_'.$_GET['vcid'].'.xls';
	    $filenames['BS Standalone'] = $BSHEET_MEDIA_PATH_NEW;
	}
	if(file_exists(FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'_1.xls')){
	    $CASHFLOW_MEDIA_PATH_NEW_CON=FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'_1.xls';
	    $filenames['CF Consolidated'] = $CASHFLOW_MEDIA_PATH_NEW_CON;
	}
	if(file_exists(FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'.xls')){
	    $CASHFLOW_MEDIA_PATH=FOLDER_CREATE_PATH.'cashflow_xbrl2/CASHFLOW_'.$_GET['vcid'].'.xls';
	    $filenames['CF Standalone'] = $CASHFLOW_MEDIA_PATH;
	}

	$fields3 ='*';
	$order3 = '';
	$sep = '';
	$where3 = " Company_Id = ".$_GET['vcid'];
	//$where3 = " Company_Id = 994";

	$CompanyProfile = $cprofile->getFullList("","",$fields3,$where3,$order3,"name3");
	///print_r($CompanyProfile);

	$where5 = " Industry_Id= ".$CompanyProfile[8];
	$order5="";
	$compdetail = $industries->getsingleIndustries($where5,$order5);
	$industry="";
	$industry=$compdetail[0];

	$where6 = "Sector_Id= ".$CompanyProfile[9];
	$order6="";
	$sectordetail = $sectors->getsingleSectors($where6,$order6);
	$sectorname="";
	$sectorname=$sectordetail[0];

	$naicsdetail = $sectors->getSectorsNaicsCode($where6,$order6);
	$naicsCode=$naicsdetail[0];

	if($CompanyProfile[16]==1)
	{
	    $ListingStatus = 'Listed';
	}
	elseif($CompanyProfile[16]==2)
	{
	    $ListingStatus = 'UnListed';
	}
	elseif($CompanyProfile[16]==3)
	{
	    $ListingStatus = 'Partnership';
	}
	elseif($CompanyProfile[16]==4)
	{
	    $ListingStatus = 'Proprietorship';
	}else{
	    $ListingStatus = '';
	}
	                        //Transaction status
	if($CompanyProfile[6]==0)
	{
	    $Permissions = 'PE Backed';
	}
	elseif($CompanyProfile[6]==1)
	{
	    $Permissions = 'Non-PE Backed';
	}
	else{
	    $Permissions = '';
	}
	// elseif($CompanyProfile[6]==2)
	// {
	//     $Permissions = 'Non-Transacted and Fund Raising';
	// }

	$where7 = " city_id = ".$CompanyProfile[27];
	$getcity = $city->getsinglecity($where7);
	$runType = $cprofile->getrunType( $whererunType );

	if($runType['run_type'] == 1){
		$runTypetext = "XBRL";
	} else {
		$runTypetext = "NON-XBRL";
	}
	$replace_array = array('\t','\n','<br>','<br/>','<br />','\r','\v');

	$BusinessDesc  = preg_replace("/\r\n|\r|\n/", '<br/>', $CompanyProfile[11]);
	$BusinessDesc  = str_replace($replace_array, '', $BusinessDesc);
	$BusinessDesc  = preg_replace("/\s+/", " ", $BusinessDesc);
	$BusinessDesc = trim(stripslashes($BusinessDesc)) . $sep; //BusinessDesc
	$AddressHead  = trim($CompanyProfile[25]);
	$AddressHead  = preg_replace("/\s+/", " ", $AddressHead);
	$AddressHead  = preg_replace("/\r\n|\r|\n/", '<br/>', $AddressHead);
	$AddressHead  = str_replace($replace_array, '', $AddressHead);
	$AddressLine2 = trim($CompanyProfile[26]);
	$AddressLine2 = preg_replace("/\s+/", " ", $AddressLine2);
	$AddressLine2 = preg_replace("/\r\n|\r|\n/", '<br/>', $AddressLine2);
	$AddressLine2 = str_replace($replace_array, '', $AddressLine2);
	$Address      = trim((stripslashes($AddressHead) . ',' . stripslashes($AddressLine2)), ',');
	$Address = trim(stripslashes($Address)) . $sep; //Address
	$city = trim($getcity[0]) . $sep; //city
	$where7     = " Country_Id = " . $CompanyProfile[30];
	$getcountry = $countries->getsinglecountry($where7);
	$Country = $getcountry[0] . $sep; //Country

	$Phone = trim($CompanyProfile[31]);
	$Phone = preg_replace("/\r\n|\r|\n/", '<br/>', $Phone);
	$Phone = preg_replace("/\s+/", " ", $Phone);
	$Phone = str_replace($replace_array, '', $Phone);
	$Phone = trim(stripslashes($Phone)) . $sep; //Phone

	$CEO = trim($CompanyProfile[37]);
	$CEO = preg_replace("/\r\n|\r|\n/", '<br/>', $CEO);
	$CEO = preg_replace("/\s+/", " ", $CEO);
	$CEO = str_replace($replace_array, '', $CEO);
	$Contactperson = trim(stripslashes($CEO)) . $sep; //Contact person

	$CFO = trim($CompanyProfile[38]);
	$CFO = preg_replace("/\r\n|\r|\n/", '<br/>', $CFO);
	$CFO = preg_replace("/\s+/", " ", $CFO);
	$CFO = str_replace($replace_array, '', $CFO);
	$designation = trim(stripslashes($CFO)) . $sep; //designation

	$auditor_name = trim($CompanyProfile[56]);
	$auditor_name = preg_replace("/\r\n|\r|\n/", '<br/>', $auditor_name);
	$auditor_name = preg_replace("/\s+/", " ", $auditor_name);
	$auditor_name = str_replace($replace_array, '', $auditor_name);
	$auditor_name = trim(stripslashes($auditor_name)) . $sep; //auditor_name

	$Email = trim($CompanyProfile[33]);
	$Email = preg_replace("/\r\n|\r|\n/", '<br/>', $Email);
	$Email = preg_replace("/\s+/", " ", $Email);
	$Email = str_replace($replace_array, '', $Email);
	$Email = trim(stripslashes($Email)) . $sep; //Email

	$websit = trim($CompanyProfile[34]) . $sep; //websit

	error_reporting(E_ALL);
	ini_set('display_errors', TRUE);
	ini_set('display_startup_errors', TRUE);

	$cprofileExcel = new PHPExcel();
	$cprofileExcel->getActiveSheet()->setTitle('C Profile');
	$cprofileExcel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
	$cprofileExcel->setActiveSheetIndex(0)
	            ->setCellValue('A1', 'Company Name')
				->setCellValue('B1', 'CIN Number')
				->setCellValue('C1', 'Company Type')
	            ->setCellValue('D1', 'Brand Name')
	            ->setCellValue('E1', 'Industry')
	            ->setCellValue('F1', 'Sector')
	            ->setCellValue('G1', 'NAICS Code')
	            ->setCellValue('H1', 'Entity Type')
	            ->setCellValue('I1', 'Transaction Status')
	            ->setCellValue('J1', 'Year Founded')
	            ->setCellValue('K1', 'Business Description')
	            ->setCellValue('L1', 'Address')
	            ->setCellValue('M1', 'City')
	            ->setCellValue('N1', 'Country')
	            ->setCellValue('O1', 'Telephone')
	            ->setCellValue('P1', 'Contact Name')
	            ->setCellValue('Q1', 'Designation')
	            ->setCellValue('R1', 'Auditor Name')
	            ->setCellValue('S1', 'Email')
	            ->setCellValue('T1', 'Website');


	$cprofileExcel->setActiveSheetIndex(0)
	            ->setCellValue('A2', $CompanyProfile[2])
				->setCellValue('B2', $CompanyProfile[50])
				->setCellValue('C2', $runTypetext)
	            ->setCellValue('D2', $CompanyProfile[1])
	            ->setCellValue('E2', $industry)
	            ->setCellValue('F2', $sectorname)
	            ->setCellValue('G2', $naicsCode)
	            ->setCellValue('H2', $ListingStatus)
	            ->setCellValue('I2', $Permissions)
	            ->setCellValue('J2', $CompanyProfile[15])
	            ->setCellValue('K2', $BusinessDesc)
	            ->setCellValue('L2', $Address)
	            ->setCellValue('M2', $city)
	            ->setCellValue('N2', $Country)
	            ->setCellValue('O2', $Phone)
	            ->setCellValue('P2', $Contactperson)
	            ->setCellValue('Q2', $designation)
	            ->setCellValue('R2', $auditor_name)
	            ->setCellValue('S2', $Email)
	            ->setCellValue('T2', $websit);

	$outputFile = 'companyDetail_'.$CompanyProfile[0].".xls";

	foreach ($filenames as $key=>$filename) {

	    $excel = new PHPExcel();
	    $excel = PHPExcel_IOFactory::load($filename);
	    
	    $excel->getActiveSheet()->setTitle($key);
	    $excel->getActiveSheet()->getDefaultRowDimension()->setRowHeight(15);
	    foreach($excel->getSheetNames() as $sheetName) {
	       $sheet = $excel->getSheetByName($sheetName);
	       $sheet->setTitle($sheet->getTitle());
	       if($sheet->getTitle() == $key){
	           $cprofileExcel->addExternalSheet($sheet);
	       }
	    }
	}

	$companyDetailpath  = "companyDetail";
	$Dir = FOLDER_CREATE_PATH.$companyDetailpath;
	if(!is_dir($Dir)){
		mkdir($Dir,0777);chmod($Dir, 0777);
	}
	
	$Target_Path = $Dir.'/';
	$strOriginalPath = $Target_Path.$outputFile;
	//echo $strOriginalPath;exit();
	$objWriter = PHPExcel_IOFactory::createWriter($cprofileExcel, "Excel5");
	header("Content-Type: application/vnd.ms-excel");
	header("Content-Disposition: attachment; filename=$outputFile");
	header("Cache-Control: max-age=0");
	$objWriter->save($strOriginalPath);

}

/**
 * Function to find the XML file for SHP. 
 * 
 */
function findmaxyearxmlfile($objects = '',$checkFile = '', $client = '', $folderparsed){
	$j = 0;
	$fileCount = $fileCheckCount = $completedCount = 0;
	$error = false;
	global $xml;
	$fileName = array();
	$fyYearSHP = array();
	$xmlFliesForSHP = '';
	foreach ($objects as $xmlFliesList) {
		if( is_array( $xmlFliesList ) && !empty( $xmlFliesList ) ) {
			//print_r($xmlFliesList);
			foreach( $xmlFliesList as $fileIndex => $filePath ) { // Looping thorugh XML files.
				if( $j > 0 ) {
					if( array_key_exists( 'Key', $filePath ) ) {
						if( ( stripos( $filePath[ 'Key' ], $checkFile ) !== false ) || ( stripos( $filePath[ 'Key' ], strtoupper( $checkFile ) ) !== false ) || ( stripos( $filePath[ 'Key' ], strtolower( $checkFile ) ) !== false ) ) { // Check XML file exists for the user given types.
							if( stripos( $filePath[ 'Key' ], 'completed/') !== false ) {
								$completedCount++;
							}
							$fileName[] = basename( $filePath[ 'Key' ] ); // XML File Name
						} else {
							$fileCheckCount = $fileCheckCount + 1;
						}
					}
					$fileCount++;
				}
				$j++;
			}
		}
	}
	rsort($fileName, "strnatcmp");
	$xmlFliesForSHP = $fileName[count($fileName) - 1];
	return array( 'xmlFliesForSHP' => $xmlFliesForSHP, 'folderType' => $folderparsed);
}
/**
 * Function to compare PL Excel
 * 
 */
function comparePLExcel($pltargetyear,$pltargetarray,$targetPLExcel,$type,$excel_type,$companyName,$run_id)
{
	global $Excelgenerate;
	
	$isPLrestate = false;
		
	if(file_exists($targetPLExcel))
	{
		
		try {
					$inputFileType = IOFactory::identify($targetPLExcel);
					$reader = IOFactory::createReader($inputFileType);
					$spreadsheet1 = $reader->load($targetPLExcel);
					$dataSheet = $spreadsheet1->getActiveSheet()->toArray(null, true, true, true);
					$YearCount = count($dataSheet[6]);
					$YearCount1 = count($dataSheet[6]);	
				} catch( Exception $e ) {
					//print_r( $e->getMessage() );
				}
				
				$excelIndex = $Excelgenerate->createColumnsArray( 'BZ' );
				$i=0;
				//$logs->logWrite( "Add financial - Year count check" );
				for( $m = 0; $m <= $YearCount -2; $m++ ) {
					$x=6; $i=0;
					for ( $x; $x <= count($dataSheet)+3; $x++ ) {
						$i++;
						$Test[ $m ][ $i ] = ( $dataSheet[$x][$excelIndex[$m+1]] == '-' )?'NULL':$dataSheet[$x][$excelIndex[$m+1]];
					}
				}
				$rowname =  $dataSheet[10][A];
		    	$rowname1 =  $dataSheet[11][A];
		    	$targetindex=0;
		    	for( $k = 0; $k <= $YearCount -2; $k++ ) {
		    		
			    		if(substr($pltargetyear,2,2)==substr($Test[$k][1],2,2)){
								$targetindex=$k;
						}
					
				}
				
				if(substr($pltargetyear,2,2)==substr($Test[$targetindex][1],2,2))
				{
					if( $rowname=="Operational, Admin & Other Expenses" && $rowname1=="Operating Profit")
					{ 
						$isPLrestate = true;		
						
					}
					else if($rowname=="Cost of materials consumed" && $rowname1=="Purchases of stock-in-trade")
                	{
                				if($Test[$targetindex][2] != "NULL"){
								if($pltargetarray['Operational Income'] != $Test[$targetindex][2]){
									$isPLrestate=true;
								}
								}
								 
								if($Test[$targetindex][3] != "NULL"){
								if($pltargetarray['Other Income'] != $Test[$targetindex][3]){
									$isPLrestate=true;
								}
								}
					         
								if($Test[$targetindex][4] != "NULL"){
								if($pltargetarray['Total Income'] != $Test[$targetindex][4]){
									$isPLrestate=true;
									}
									
								}
                                      
					
								if($Test[$targetindex][5] != "NULL"){
									if($pltargetarray['Cost Of Materials Consumed'] != $Test[$targetindex][5]){
										$isPLrestate=true;
									}
								}
								
								if($Test[$targetindex][6] != "NULL"){
									if($pltargetarray['Purchases Of Stock In Trade'] != $Test[$targetindex][6]){
										$isPLrestate=true;
									}
									
								}
								
								if($Test[$targetindex][7] != "NULL"){
									if($pltargetarray['Changes In Inventories'] != $Test[$targetindex][7]){
										$isPLrestate=true;
									}
									
								}
								
								if($Test[$targetindex][9] != "NULL"){
									if($pltargetarray['CSR Expenditure'] != $Test[$targetindex][9]){
										$isPLrestate=true;
									}
									
								}
								
								if($Test[$targetindex][10] != "NULL"){
									if($pltargetarray['Other Expenses'] != $Test[$targetindex][10]){
										$isPLrestate=true;
									}
									
								}
					            

								if($Test[$targetindex][11] != "NULL"){
									if($pltargetarray['Operational, Admin & Other Expenses'] != $Test[$targetindex][11]){
										$isPLrestate=true;
									}
									
								}
					           
								if($Test[$targetindex][12] != "NULL"){
									if($pltargetarray['Operating Profit'] != $Test[$targetindex][12]){
										$isPLrestate=true;
									}
									
								}
								
								if($Test[$targetindex][13] != "NULL"){
									if($pltargetarray['EBITDA'] != $Test[$targetindex][13]){
										$isPLrestate=true;
									}
									
								}
								
								if($Test[$targetindex][14] != "NULL"){
									if($pltargetarray['Interest'] != $Test[$targetindex][14]){
										$isPLrestate=true;
									}
									
								}
								
								if($Test[$targetindex][15] != "NULL"){
									if($pltargetarray['EBDT'] != $Test[$targetindex][15]){
										$isPLrestate=true;
									}
									$Insert_PLStandard['EBDT'] = $Test[$k][15];
								}
								
								if($Test[$targetindex][16] != "NULL"){
									if($pltargetarray['Depreciation'] != $Test[$targetindex][16]){
										$isPLrestate=true;
									}
									
								}
								
								if($Test[$targetindex][17] != "NULL"){
									if($pltargetarray['EBT before Exceptional Items'] != $Test[$targetindex][17]){
										$isPLrestate=true;
									}
									
								}
								
								if($Test[$targetindex][18] != "NULL"){
									if($pltargetarray['Prior period/Exceptional /Extra Ordinary Items'] != $Test[$targetindex][18]){
										$isPLrestate=true;
									}
									
								}
								
								if($Test[$targetindex][19] != "NULL"){
									if($pltargetarray['EBT'] != $Test[$targetindex][19]){
										$isPLrestate=true;
									}
									
								}
								

								if($Test[$targetindex][20] != "NULL"){
									if($pltargetarray['CurrentTax'] != $Test[$targetindex][20]){
										$isPLrestate=true;
									}
									
								}
								
								if($Test[$targetindex][21] != "NULL"){
									if($pltargetarray['DeferredTax'] != $Test[$targetindex][21]){
										$isPLrestate=true;
									}
									
								}
								

								if($Test[$targetindex][22] != "NULL"){
									if($pltargetarray['Tax'] != $Test[$targetindex][22]){
										$isPLrestate=true;
									}
									
								}
								
								if($Test[$targetindex][23] != "NULL"){
									if($pltargetarray['PAT'] != $Test[$targetindex][23]){
										$isPLrestate=true;
									}
									
								}
								
								
								if( $excel_type == 'S' ) {
									if($Test[$targetindex][25] != "NULL"){
										if($pltargetarray['(Basic in INR)'] != $Test[$targetindex][25]){
										$isPLrestate=true;
										}
										
									}
									
									if($Test[$targetindex][26] != "NULL"){
										if($pltargetarray['(Diluted in INR)'] != $Test[$targetindex][26]){
										$isPLrestate=true;
										}
										
									}
					                
					                if($Test[$targetindex][8] != "NULL"){
					                	if($pltargetarray['Employee Related Expenses'] != $Test[$targetindex][8]){
										$isPLrestate=true;
										}
										
									}
									
									if($Test[$targetindex][28] != "NULL"){
										if($pltargetarray['Foreign Exchange Earning and Outgo:'] != $Test[$targetindex][28]){
										$isPLrestate=true;
										}
											
									}
									
									if($Test[$targetindex][29] != "NULL"){
										if($pltargetarray['Earning in Foreign Exchange'] != $Test[$targetindex][29]){
										$isPLrestate=true;
										}
										
									}
									
									if($Test[$targetindex][30] != "NULL") {
										if($pltargetarray['Outgo in Foreign Exchange'] != $Test[$targetindex][30]){
										$isPLrestate=true;
										}
										
									}
					               
								} else if($excel_type == 'C')
								{
									if($Test[$targetindex][24] != "NULL"){
										if($pltargetarray['Profit (loss) of minority interest'] != $Test[$targetindex][24]){
										$isPLrestate=true;
										}
									}
									
									if($Test[$targetindex][25] != "NULL"){
										if($pltargetarray['Total profit (loss) for period'] != $Test[$targetindex][25]){
										$isPLrestate=true;
										}
									}
									
									if($Test[$targetindex][27] != "NULL"){
										if($pltargetarray['(Basic in INR)'] != $Test[$targetindex][27]){
										$isPLrestate=false;
										}
										
									}
									
									if($Test[$targetindex][28] != "NULL"){
										if($pltargetarray['(Diluted in INR)'] != $Test[$targetindex][28]){
										$isPLrestate=true;
										}
										
									}
					                
					                if($Test[$targetindex][8] != "NULL"){
										if($pltargetarray['Employee Related Expenses'] != $Test[$targetindex][8]){
										$isPLrestate=true;
										}
									}
									
									if($Test[$targetindex][30] != "NULL"){
										if($pltargetarray['Foreign Exchange Earning and Outgo:'] != $Test[$targetindex][30]){
										$isPLrestate=true;
										}
									}
									if($Test[$targetindex][31] != "NULL"){
										if($pltargetarray['Earning in Foreign Exchange'] != $Test[$targetindex][31]){
										$isPLrestate=true;
										}
									}
									
									if($Test[$targetindex][32] != "NULL") {
										if($pltargetarray['Outgo in Foreign Exchange'] != $Test[$targetindex][32]){
										$isPLrestate=true;
										}
									}
					               
			                    	
			                    }

			                	}
						
				}
		}else{
			$isPLrestate = true;
		}
		//echo $isPLrestate;
		return $isPLrestate;
		
}


function compareBSExcel($bstargetyear,$bstargetarray,$targetBSExcel,$type,$excel_type,$companyName,$run_id)
{
	global $Excelgenerate;
	
	$isBSrestate = false;
	
	if(file_exists($targetBSExcel))
	{
		try {
					$inputFileType = IOFactory::identify($targetBSExcel);
					$reader = IOFactory::createReader($inputFileType);
					$spreadsheet1 = $reader->load($targetBSExcel);
					$dataSheet = $spreadsheet1->getActiveSheet()->toArray(null, true, true, true);
					$YearCount = count($dataSheet[6]);
					$YearCount1 = count($dataSheet[6]);	
				} catch( Exception $e ) {
					//print_r( $e->getMessage() );
				}
				
				$excelIndex = $Excelgenerate->createColumnsArray( 'BZ' );
				$i=0;
				//$logs->logWrite( "Add financial - Year count check" );
				for( $m = 0; $m <= $YearCount -2; $m++ ) {
					$x=6; $i=0;
					for ( $x; $x <= count($dataSheet)+3; $x++ ) {
						$i++;
						$Test[ $m ][ $i ] = ( $dataSheet[$x][$excelIndex[$m+1]] == '-' )?'NULL':$dataSheet[$x][$excelIndex[$m+1]];
					}
				}
				$rowname =  $dataSheet[10][A];
		    	$rowname1 =  $dataSheet[11][A];
		    	$targetindex=0;
		    	for( $k = 0; $k <= $YearCount -2; $k++ ) {
		    		
			    		if(substr($bstargetyear,2,2)==substr($Test[$k][1],2,2)){
								$targetindex = $k;
						}
					
				}
				if(substr($bstargetyear,2,2)==substr($Test[$targetindex][1],2,2))
				{
					if($Test[$targetindex][2] != "NULL"){		
						if($bstargetarray['Share capital'] != $Test[$targetindex][2]){
								$isBSrestate=true;
						}			
					}
					if($Test[$targetindex][3] != "NULL"){
						if($bstargetarray['Reserves and surplus'] != $Test[$targetindex][3]){
								$isBSrestate=true;
						}
					}
					if($Test[$targetindex][4] != "NULL"){
						if($bstargetarray['Total shareholders funds'] != $Test[$targetindex][4]){
								$isBSrestate=true;
						}
					}	
					if($Test[$targetindex][5] != "NULL"){
						if($bstargetarray['Share application money pending allotment'] != $Test[$targetindex][5]){
								$isBSrestate=true;
						}
					}
					if($excel_type == 'C'){
						if($Test[$targetindex][6] != "NULL"){
							if($bstargetarray['Minority interest'] != $Test[$targetindex][6]){
									$isBSrestate=true;
							}
						}
					}
					if($Test[$targetindex][7] != "NULL"){
						if($bstargetarray['Non-current liabilities [Abstract]'] != $Test[$targetindex][7]){
								$isBSrestate=true;
						}
					}
					if($Test[$targetindex][8] != "NULL"){
						if($bstargetarray['Long-term borrowings'] != $Test[$targetindex][8]){
								$isBSrestate=true;
						}
					}                                        
                    if($Test[$targetindex][9] != "NULL"){
						if($bstargetarray['Deferred tax liabilities (net)'] != $Test[$targetindex][9]){
								$isBSrestate=true;
						}
					}
					if($Test[$targetindex][10] != "NULL"){
						if($bstargetarray['Other long-term liabilities'] != $Test[$targetindex][10]){
								$isBSrestate=true;
						}
					} 
					if($Test[$targetindex][11] != "NULL"){
						if($bstargetarray['Long-term provisions'] != $Test[$targetindex][11]){
								$isBSrestate=true;
						}
					}
					if($Test[$targetindex][12] != "NULL"){
						if($bstargetarray['Total non-current liabilities'] != $Test[$targetindex][12]){
								$isBSrestate=true;
						}
					}
					if($Test[$targetindex][14] != "NULL"){
						if($bstargetarray['Current liabilities [Abstract]'] != $Test[$targetindex][14]){
								$isBSrestate=true;
						}
					}
					if($Test[$targetindex][15] != "NULL"){
						if($bstargetarray['Short-term borrowings'] != $Test[$targetindex][15]){
								$isBSrestate=true;
						}
					}
					if($Test[$targetindex][16] != "NULL"){
						if($bstargetarray['Trade payables'] != $Test[$targetindex][16]){
								$isBSrestate=true;
						}
					}
					if($Test[$targetindex][17] != "NULL"){
						if($bstargetarray['Other current liabilities'] != $Test[$targetindex][17]){
								$isBSrestate=true;
						}
					}
					if($Test[$targetindex][18] != "NULL"){
						if($bstargetarray['Short-term provisions'] != $Test[$targetindex][18]){
								$isBSrestate=true;
						}
					}
					if($Test[$targetindex][19] != "NULL"){
						if($bstargetarray['Total current liabilities'] != $Test[$targetindex][19]){
								$isBSrestate=true;
						}
					}
					if($Test[$targetindex][20] != "NULL"){
						if($bstargetarray['Total equity and liabilities'] != $Test[$targetindex][20]){
								$isBSrestate=true;
						}
					}
					if($Test[$targetindex][22] != "NULL"){
						if($bstargetarray['Assets [Abstract]'] != $Test[$targetindex][22]){
								$isBSrestate=true;
						}
					}
                                        
                    if($Test[$targetindex][24] != "NULL"){
                    	if($bstargetarray['Non-current assets [Abstract]'] != $Test[$targetindex][24]){
								$isBSrestate=true;
						}
					}
                                        
                    if($Test[$targetindex][26] != "NULL"){
                    	if($bstargetarray['Fixed assets [Abstract]'] != $Test[$targetindex][26]){
								$isBSrestate=true;
						}
					}

					if($Test[$targetindex][27] != "NULL"){
						if($bstargetarray['Tangible assets'] != $Test[$targetindex][27]){
								$isBSrestate=true;
						}
					}

					if($Test[$targetindex][28] != "NULL"){
						if($bstargetarray['Intangible assets'] != $Test[$targetindex][28]){
								$isBSrestate=true;
						}
					}

					if($Test[$targetindex][29] != "NULL"){
						if($bstargetarray['Total fixed assets'] != $Test[$targetindex][29]){
								$isBSrestate=true;
						}
					}

					if($Test[$targetindex][30] != "NULL"){
						if($bstargetarray['Non-current investments'] != $Test[$targetindex][30]){
								$isBSrestate=true;
						}
					}

					if($Test[$targetindex][31] != "NULL"){
						if($bstargetarray['Deferred tax assets (net)'] != $Test[$targetindex][31]){
								$isBSrestate=true;
						}
					}

					if($Test[$targetindex][32] != "NULL"){
						if($bstargetarray['Long-term loans and advances'] != $Test[$targetindex][32]){
								$isBSrestate=true;
						}
					}

					if($Test[$targetindex][33] != "NULL"){
						if($bstargetarray['Other non-current assets'] != $Test[$targetindex][33]){
								$isBSrestate=true;
						}
					}

					if($Test[$targetindex][34] != "NULL"){
						if($bstargetarray['Total non-current assets'] != $Test[$targetindex][34]){
								$isBSrestate=true;
						}
					}

					if($Test[$targetindex][36] != "NULL"){
						if($bstargetarray['Current assets [Abstract]'] != $Test[$targetindex][36]){
								$isBSrestate=true;
						}
					}

					if($Test[$targetindex][37] != "NULL"){
						if($bstargetarray['Current investments'] != $Test[$targetindex][37]){
								$isBSrestate=true;
						}
					}

					if($Test[$targetindex][38] != "NULL"){
						if($bstargetarray['Inventories'] != $Test[$targetindex][38]){
								$isBSrestate=true;
						}
					}

					if($Test[$targetindex][39] != "NULL"){
						if($bstargetarray['Trade receivables'] != $Test[$targetindex][39]){
								$isBSrestate=true;
						}
					}

					if($Test[$targetindex][40] != "NULL"){
						if($bstargetarray['Cash and bank balances'] != $Test[$targetindex][40]){
								$isBSrestate=true;
						}
					}

                    if($Test[$targetindex][41] != "NULL"){
                    	if($bstargetarray['Short-term loans and advances'] != $Test[$targetindex][41]){
								$isBSrestate=true;
						}
					}

                    if($Test[$targetindex][42] != "NULL"){
                    	if($bstargetarray['Other current assets'] != $Test[$targetindex][42]){
								$isBSrestate=true;
						}
					}

                    if($Test[$targetindex][43] != "NULL"){
                    	if($bstargetarray['Total current assets'] != $Test[$targetindex][43]){
								$isBSrestate=true;
						}
					}
                     
                    if($Test[$targetindex][44] != "NULL"){
                     	if($bstargetarray['Total assets'] != $Test[$targetindex][44]){
								$isBSrestate=true;
						}
					}

				}

		}else{
			$isBSrestate = true;
		}
		
	return $isBSrestate;	
}
unset( $tempData );
unset( $tempData1 );
unset( $processedCin );
unset( $fyoldArrayPartial );
unset( $fyoldArray );
unset( $fyYear );
unset( $sfyYear );

echo date( 'ymdhis' ); // echo date stamp for next run id update in view after ajax call.

?>


