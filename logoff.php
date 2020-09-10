<?php include_once("globalconfig.php"); ?>
<?php
		 require("dbconnectvi.php");
	     $Db = new dbInvestments();
	     $Db->dbInvestments();
		// session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
session_start();
		session_register("UserNames");

			$logoffPage = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
			//echo "<Br>-- ".$logoffPage;
	 	if ((session_is_registered("UserNames")) || (session_is_registered("MAUserNames")) || (session_is_registered("REUserNames")))
		 {
		 		$sessionID=session_id();
				$logofftime=date("Y-m-d")." ".date("H:i:s");
				//echo "<br>session id off-" .$sessionID;
				$LogOfftimeSql="Update dealLog set LoggedOff='$logofftime' where LogSessionID='$sessionID'";
				//echo "<br>".$LogOfftimeSql;
				if($logrs=mysql_query($LogOfftimeSql))
				{
					//unset($_SESSION['UserNames']);
					$_SESSION = array();
					session_unset();
					session_regenerate_id();
					session_destroy();
					session_unregister("UserNames");
					session_unregister("MAUserNames");
					session_write_close();
					session_unregister("UserEmail");
					session_unregister("MAUserEmail");

                                        session_unregister("REUserEmail");
					session_unregister("REUserEmail");

					session_unregister("MAIP");
					session_unregister("REIP");
					session_commit();
				}
		}
			if($logoffPage=="P")
				header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;
			elseif($logoffPage=="PIP")
				header( 'Location: '. GLOBAL_BASE_URL .'peloginip.php' ) ;
			elseif($logoffPage=="M")
				header( 'Location: '. GLOBAL_BASE_URL .'malogin.php' ) ;
			elseif($logoffPage=="MIP")
			        header( 'Location: '. GLOBAL_BASE_URL .'maloginip.php' ) ;
			elseif($logoffPage=="R")
				header( 'Location: '. GLOBAL_BASE_URL .'relogin.php' ) ;
			elseif($logoffPage=="RIP")
				header( 'Location: '. GLOBAL_BASE_URL .'reloginip.php' ) ;
                        else
				header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;


?>


