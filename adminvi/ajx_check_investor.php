<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
    session_save_path("/tmp");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd")) {
        if( isset( $_POST[ 'investor' ] ) ) {
            $investor = trim( $_POST[ 'investor' ] );
            $dbType = trim( $_POST[ 'dbType' ] );
            if( $dbType == 'PE' ) {
                $sel = "SELECT InvestorId FROM peinvestors
                    WHERE Investor = '" . $investor . "'
                    ";
                $res = mysql_query( $sel ) or die( $sel );
                $result = mysql_fetch_array( $res );    
            } else {
                $sel = "SELECT InvestorId FROM REinvestors
                    WHERE Investor = '" . $investor . "'
                    ";
                $res = mysql_query( $sel ) or die( $sel );
                $result = mysql_fetch_array( $res );
            }
            
            echo json_encode( array( 'Status' => 'Success', 'Data' => $result[ 'InvestorId' ] ) );
        } else {
            echo json_encode( array( 'Status' => 'Error', 'Data' => 'Something Wrong' ) );
        }
    } else {
        echo json_encode( array( 'Status' => 'Error', 'Data' => 'Session expired. Please login' ) );
    }
                
?>