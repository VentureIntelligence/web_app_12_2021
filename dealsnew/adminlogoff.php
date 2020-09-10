<?php include_once("../globalconfig.php"); ?>
<?php
    require("../dbconnectvi.php");
    $Db = new dbInvestments();
		
    session_save_path("/tmp");
    session_start();
    session_register("SessLoggedAdminPwd");
    if ((session_is_registered("SessLoggedAdminPwd")))
    {
        //unset($_SESSION['UserNames']);
        session_unset();
        session_destroy();
        session_unregister("SessLoggedAdminPwd");
    }
    header( 'Location: '. GLOBAL_BASE_URL .'dealsnew/admin.php' ) ; 

?>

