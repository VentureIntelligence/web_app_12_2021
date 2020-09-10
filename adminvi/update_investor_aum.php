<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
    session_save_path("/tmp");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd")) {
        if( isset( $_POST[ 'investor_addaum' ] ) ) {
            $investor_addaum = trim( $_POST[ 'investor_addaum' ] );
            $dbType = trim( $_POST[ 'dbType' ] );
            $investor_db_id = trim( $_POST[ 'investor_db_id' ] );
            $investor_addaum = str_replace('"','',$investor_addaum);
            if( $dbType == 'PE' ) {
                $update = "UPDATE peinvestors SET Assets_mgmt = '$investor_addaum' WHERE InvestorId = " . $investor_db_id; 
                mysql_query( $update ) or die( $update );
            } else {
                $update = "UPDATE REinvestors SET Assets_mgmt = '$investor_addaum' WHERE InvestorId = " . $investor_db_id;
                mysql_query( $update ) or die( $update );
            }
            echo json_encode( array( 'Status' => 'Success', 'Data' => '' ) );
        } else {
            echo json_encode( array( 'Status' => 'Error', 'Data' => 'Something Wrong' ) );
        }
    } else {
        echo json_encode( array( 'Status' => 'Error', 'Data' => 'Session expired. Please login' ) );
    }
                
?>