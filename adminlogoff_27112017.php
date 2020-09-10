<?php include_once("globalconfig.php"); ?>
<?php
		 //require("dbconnectvi.php");
	    // $Db = new dbInvestments();
	     //$Db->dbInvestments();
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
		session_start();
		session_register("SessLoggedAdminPwd");
	 	if ((session_is_registered("SessLoggedAdminPwd")))
		 {

					//unset($_SESSION['UserNames']);
					session_unset();
					session_destroy();
					session_unregister("SessLoggedAdminPwd");

		}
			header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>

