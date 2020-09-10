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
require(dirname(__FILE__).$dir."/xml/XML.php"); // PLUGIN FILES
require(dirname(__FILE__).$dir."/xml/XBRL.php"); // PLUGIN FILES
require(dirname(__FILE__).$dir."/class.xmlprase.php"); // OWN FILES
require(dirname(__FILE__).$dir."/class.excelgenerate.php"); // OWN FILES
require(dirname(__FILE__).$dir."/class.logs.php"); // OWN FILES
require(dirname(__FILE__).$dir."/class.addcfinancials.php");
require_once "../../aws.php";	// load logins
require_once('../../aws.phar');
require_once MODULES_DIR."xbrl.php";
use Aws\S3\S3Client;

// Timezone to asia/kolkatta
date_default_timezone_set('Asia/Kolkata');

// Global variables to use in class files.
global $logs;
global $xbrl;

// Class intialization & variable intialization
$xbrl = new xbrl_insert();
$xml = new XML();
$xmlParse = new XmlFetch();
$Excelgenerate = new Excelgenerate();
$addcfinancials = new addcfinancials();
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
			$sfyYear = array();
			$xbrlretval = array();
			$companyName = '';
			$companyNature = '';

			$type = $_POST[ 'req_answer' ][ 'folder' ][ $inputkey ];
			$excel_type = $_POST[ 'req_answer' ][ 'type' ][ $inputkey ];
			$addPL = true;
			$addBS = true;

			$dateTime = date( 'dmYhis' );
			$logFileName = "logs".$dateTime;
			// Log class intialize for individual cin with file name and run id.
			$logs = new Logs( $logfolder, $cin, $run_id, $logFileName, $processedCin[ $cin ], $type, $excel_type );
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
				$error = false;
				/*foreach( $objects as $object ) {
					if( is_array( $object ) && !empty( $object ) ) {
						echo '<pre>'; print_r( $object ); echo '</pre>';
					}
				}
				exit;*/
				foreach ($objects as $xmlFliesList) {
					if( is_array( $xmlFliesList ) && !empty( $xmlFliesList ) ) {
						foreach( $xmlFliesList as $fileIndex => $filePath ) { // Looping thorugh XML files.
							if( $j > 0 ) {
								// FY getting from XML will be stored in fyYear and sfyYear(Short form of year).
								$fyYear = array();
								$sfyYear = array();
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
											$cinMissmatch = true;
											$xbrl->update_upload_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
											$logs->logWrite( "CIN missmatch in file " . $fileurl . "", true );
											//break;
										} else {
											
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
															if( !in_array( $contextID, $bsContextArray[ $yearTemp ] ) ) {
																$bsContextArray[ $yearTemp ][0] = $contextID;	
															}
															if( !in_array( $yearTemp, $fyYear ) ) {
																$fyYear[] = $yearTemp; 	
																$sfyYear[] = $syearTemp;
																$monthDate[$yearTemp] = $montTemp;
															}
														}
														if( array_key_exists( 'endDate', $contextLoopPeriod[0][ 'xbrli' ] ) && !array_key_exists( 'scenario', $contextLoopFirst[ 'xbrli' ] ) ) {
															$yearTemp = date( 'Y', strtotime( $contextLoopPeriod[0][ 'xbrli' ][ 'endDate' ][0][ '_value:' ] ) );
															$syearTemp = date( 'y', strtotime( $contextLoopPeriod[0][ 'xbrli' ][ 'endDate' ][0][ '_value:' ] ) );
															$montTemp = date( 'm-d', strtotime( $contextLoopPeriod[0][ 'xbrli' ][ 'instant' ][0][ '_value:' ]) );
															if( !in_array( $contextID, $plContextArray[ $yearTemp ] ) ) {
																$plContextArray[ $yearTemp ][0] = $contextID;	
															}
															if( !in_array( $yearTemp, $fyYear ) ) {
																$fyYear[] = $yearTemp; 	
																$sfyYear[] = $syearTemp;
																$monthDate[$yearTemp] = $montTemp;
															}
														}
														
													}
												} else {
													foreach( $contextLoopFirst[''] as $contextLoopPeriod ) {
														if( array_key_exists( 'instant', $contextLoopPeriod[0] ) ) {
															$yearTemp = date( 'Y', strtotime( $contextLoopPeriod[0][ 'instant' ][0][ '_value:' ] ) );
															$syearTemp = date( 'y', strtotime( $contextLoopPeriod[0][ 'instant' ][0][ '_value:' ] ) );
															$montTemp = date( 'm-d', strtotime( $contextLoopPeriod[0][ 'xbrli' ][ 'instant' ][0][ '_value:' ]) );
															if( !in_array( $contextID, $bsContextArray[ $yearTemp ] ) ) {
																$bsContextArray[ $yearTemp ][0] = $contextID;	
															}
															if( !in_array( $yearTemp, $fyYear ) ) {
																$fyYear[] = $yearTemp; 	
																$sfyYear[] = $syearTemp;
																$monthDate[$yearTemp] = $montTemp;
															}
														}
														if( array_key_exists( 'endDate', $contextLoopPeriod[0] ) ) {
															$yearTemp = date( 'Y', strtotime( $contextLoopPeriod[0][ 'endDate' ][0][ '_value:' ] ) );
															$syearTemp = date( 'y', strtotime( $contextLoopPeriod[0][ 'endDate' ][0][ '_value:' ] ) );
															$montTemp = date( 'm-d', strtotime( $contextLoopPeriod[0][ 'xbrli' ][ 'instant' ][0][ '_value:' ]) );
															if( !in_array( $contextID, $plContextArray[ $yearTemp ] ) ) {
																$plContextArray[ $yearTemp ][0] = $contextID;	
															}
															if( !in_array( $yearTemp, $fyYear ) ) {
																$fyYear[] = $yearTemp; 	
																$sfyYear[] = $syearTemp;
																$monthDate[$yearTemp] = $montTemp;
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
															$xbrlretval = $xmlParse->xbrlNewFormatStandalone( $content[ 'xbrl' ][ 'ind-as' ], $fyYear, $cin, $plContextArray, $bsContextArray );
															$compledtedArray[ $cin ][ 'ind-as' ][] = array( 'fileUrl' => $fileurl, 'fileName' => $fileName ); // GET XML filename and file url for moving to compledted folder.
														} else if( $excel_type == 'C' ) {
															$logs->logWrite( "New format - Excel type consolidate entered" );
															$xbrlretval = $xmlParse->xbrlNewFormatConsolidated( $content[ 'xbrl' ][ 'ind-as' ], $fyYear, $cin, $plContextArray, $bsContextArray );
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
															$xbrlretval = $xmlParse->xbrlOldFormatStandalone( $content[ 'xbrl' ][ 'in-gaap' ], $fyYear, $cin, $plContextArray, $bsContextArray, $fyoldArray, $tempData );
															$tempData = $xbrlretval;
															$compledtedArray[ $cin ][ 'in-gaap' ][] = array( 'fileUrl' => $fileurl, 'fileName' => $fileName ); // GET XML filename and file url for moving to compledted folder.
														} else if( $excel_type == 'C' ) {
															$logs->logWrite( "Old format & Excel type consolidate entered" );
															$xbrlretval = $xmlParse->xbrlOldFormatConsolidated( $content[ 'xbrl' ][ 'in-gaap' ], $fyYear, $cin, $plContextArray, $bsContextArray, $fyoldArray, $tempData1 );
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
				/*echo '<pre>'; print_r( $xbrlretval ); echo '</pre>';
				exit;*/
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
								}
								if( $addPL ) {
									// Uploading generated excel to S3
									/*try {
										$result = $client->putObject(array(
									        'Bucket' => 'companyfilings',
									        'Key'    => 'XBRL_EXCEL/'.$cin.'/in-gaap/'. basename( $excelFilePathPL ),
									        'SourceFile'   => $excelFilePathPL,
									        'ACL'    => 'public-read'
									    ));	
									} catch( Exception $e ) {
										$logs->logWrite( "AWS Excel Move failed - PL OLD(" . $excel_type . ")" );
										$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
									}*/
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
								}
								if( $addBS ) {
									// Uploading generated excel to S3.
									/*try {
										$result = $client->putObject(array(
									        'Bucket' => 'companyfilings',
									        'Key'    => 'XBRL_EXCEL/'.$cin.'/in-gaap/'. basename( $excelFilePathBS ),
									        'SourceFile'   => $excelFilePathBS,
									        'ACL'    => 'public-read'
									    ));
									} catch( Exception $e ) {
										$logs->logWrite( "AWS Excel Move failed BS OLD(" . $excel_type . ")" );
										$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
									}*/
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
								if( /*$xbrlretval[ 'error' ] == 0 &&*/ $addPL ) { // validation error flag check before processing addcfinancials
									$logs->logWrite( "Add financial for pl starting" );
									$addcfinancials->plstandaloneadd( $cin, $excel_type, $excelFilePathPL, $type, $run_id, $processedCin[ $cin ], $logFileName );
								}
								$completeMove = true;
								if( $addPL ) {
									// Uploading generated excel to S3
									/*try {
										$result = $client->putObject(array(
									        'Bucket' => 'companyfilings',
									        'Key'    => 'XBRL_EXCEL/'.$cin.'/ind-as/'. basename( $excelFilePathPL ),
									        'SourceFile'   => $excelFilePathPL,
									        'ACL'    => 'public-read'
									    ));	
									} catch( Exception $e ) {
										$logs->logWrite( "AWS Excel Move failed - PL NEW(" . $excel_type . ")" );
										$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
									}*/
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
								if( /*$xbrlretval[ 'error' ] == 0 &&*/ $addBS ) { // validation error flag check before processing addcfinancials
									$logs->logWrite( "Add financial for bs starting" );
									$addcfinancials->bsaddfinancialdata( $cin, $excel_type, $excelFilePathBS, $type, $run_id, $processedCin[ $cin ], $logFileName );
								}
								$completeMove = true;
								if( $addBS ) {
									// Uploading generated excel to S3
									/*try {
										$result = $client->putObject(array(
									        'Bucket' => 'companyfilings',
									        'Key'    => 'XBRL_EXCEL/'.$cin.'/ind-as/'. basename( $excelFilePathBS ),
									        'SourceFile'   => $excelFilePathBS,
									        'ACL'    => 'public-read'
									    ));
									} catch( Exception $e ) {
										$logs->logWrite( "AWS Excel Move failed BS NEW(" . $excel_type . ")" );
										$xbrl->update_error( $run_id, $cin, $processedCin[ $cin ], $logFileName );
									}*/
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
		}
	}
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