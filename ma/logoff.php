<?php
		 require("../dbconnectvi.php");
	     $Db = new dbInvestments();
             session_save_path("/tmp");
            session_start();
	     $Db->dbInvestments();
//		session_register("UserNames");

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
					unset($_SESSION['MAUserNames']);
					unset($_SESSION['demoTour']);
					unset($_SESSION['ma_popup_display']);
					unset($_SESSION['type']);
					unset($_SESSION['username']);
        			unset($_SESSION['type']);
        			unset($_SESSION['UserNames']);
        			unset($_SESSION['REUserNames']);
        			unset($_SESSION['loginusername']);
                    unset($_SESSION['password']);  
//					$_SESSION = array();
//					session_unset();
//					session_regenerate_id();
//					session_destroy();
//					session_unregister("UserNames");
//					session_unregister("MAUserNames");
//					session_write_close();
//					session_unregister("UserEmail");
//					session_unregister("MAUserEmail");

//                                        session_unregister("REUserEmail");
//					session_unregister("REUserEmail");

//					session_unregister("MAIP");
//					session_unregister("REIP");
//					session_commit();
				}
		}
			
                if($logoffPage=="M")
                    header( 'Location: ' . BASE_URL . 'refer.php' ) ;
                elseif($logoffPage=="caccess")
                     header( 'Location: ' . BASE_URL . 'malogin.php?flag=ca' ) ;
                else
                     header( 'Location: ' . BASE_URL . 'malogin.php' ) ;

mysql_close();

?>


