<?php
/**
 * Class Logs
 *
 * Tracking the logs during the file exceution.
 * On creating object log file with datetime stamp is created with in logs folder and cin number.
 * For tracking log file name is stored in DB
 *
 * 
 * Functions used logWrite
 *
 * logWrite - Common function used for writing the comments in txt file. 
 * 
 * @author     Jagdeesh MV <jagadeesh@kutung.in>
 * @version    1.0
 * @created    20-07-2018
 */
class Logs {
	
	public $logFile;
	function __construct( $logFolder = '', $cin = '', $run_id = '', $logFileName = '', $processedCin, $type, $excel_type ) {
		global $xbrl;
		$companyLogFolder = $logFolder."/".$cin;

		try {
			if( !is_dir( $companyLogFolder ) ) {
				if( mkdir( $companyLogFolder ) ) {
					chmod( $companyLogFolder, 0777 );
				} else {
					echo 'Log direcotry ceration error';
				}	
			}	
		} catch( Exception $e ) {
			echo $e->getMessage();
		}
		
		$Insert_RegUser['log_file'] = $logFileName;
        $Insert_RegUser['cin'] = $cin;
        $Insert_RegUser['is_error'] = 0;
        $Insert_RegUser['run_id'] = $run_id;
        $Insert_RegUser['xml_type'] = $type;
        $Insert_RegUser['excel_type'] = $excel_type;
        $Insert_RegUser['view_index'] = $processedCin;
        $Insert_RegUser['created_on'] = date( 'Y-m-d h:i:s' );
        $Insert_RegUser[ 'user_id' ] = $_SESSION[ 'business' ][ 'Ident' ];
        $Insert_RegUser[ 'user_name' ] = $_SESSION[ 'business' ][ 'loggedUserName' ];
		$sel = $xbrl->select( $run_id, $cin, $logFileName );
		if( !empty( $sel ) ) {
			$Insert_RegUser['id'] = $sel[ 'id' ];
		}
		$xbrl->update( $Insert_RegUser );
		try {
			$this->logFile = fopen( $companyLogFolder . "/".$logFileName.".txt", "w");	
		} catch( Exception $e ) {
			echo $e->getMessage();
		}
		return $this->logFile;
	}

	public function logWrite( $comment = '', $highlight = false ) {
		try {
			fwrite( $this->logFile, date( 'd-m-Y h:i:s' ) . " : " . $comment );
			if( $highlight ) {
				fwrite( $this->logFile, "\n--------------------------------------------------------------------------------\n" );	
			}
			fwrite( $this->logFile, "\n--------------------------------------------------------------------------------\n" );
		} catch( Exception $e ) {
			echo $e->getMessage();
		}
		return true;
	}

	function __destruct() {
		try {
        	fclose( $this->logFile );
        } catch( Exception $e ) {
			echo $e->getMessage();
		}
    }
}
?>