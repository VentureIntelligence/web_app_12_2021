<?php
	require_once '../dbconnectvi.php';
	$DB = new dbInvestments();
	session_start();
	if( isset( $_POST ) ) {
		$jsonObj = json_decode( $_POST[ 'jsonObj' ] );
		$jsonObj = (array) $jsonObj;
		$cinArray = array_keys( $jsonObj );
		foreach( $cinArray as $cin ) {
			if( !file_exists( dirname(__FILE__).'/output/' . $cin ) ) { // Check directory exists or create a directory in admin output folder
	        	try {
		        	if( mkdir( dirname(__FILE__).'/output/' . $cin ) ) {
		        		$old = umask(0);
						chmod( dirname(__FILE__).'/output/' . $cin, 0777 );
						umask($old);
						$fp = fopen( dirname(__FILE__).'/output/' . $cin."/".$cin.".json", 'w');
			            fwrite( $fp, json_encode( $jsonObj[ $cin ] ) );
			            fclose($fp);
			            echo "File exported sucessfully\n";
					} else {
						$errorReport++;
						$errorArray[ $cin ]['common'][] = "Directory creation in server failed";
					}
				} catch( Exception $e ) {
					echo $e->getMessage();
				}
			} else {
				chmod( dirname(__FILE__).'/output/' . $cin, 0777 );
				$fp = fopen( dirname(__FILE__).'/output/' . $cin."/".$cin.".json", 'w');
	            fwrite( $fp, json_encode( $jsonObj[ $cin ] ) );
	            fclose($fp);
	            echo "File exported sucessfully\n";
			}
		}

	}
?>