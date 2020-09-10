<?php
    require("dbconnectvi.php");
    $Db = new dbInvestments();
    //$Db->dbInvestments();
    //session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
    session_save_path("/tmp");
    session_start();
    //session_register("SessLoggedAdminPwd");
    
    if ( $_SESSION[ "SessLoggedAdminPwd" ] )
    {
        if( $_SESSION[ "is_admin" ] == 1 ) {
                $redirect = 'admin';
        } else {
                $redirect = 'adminusers';
        }
        //unset($_SESSION['UserNames']);
        session_unset();
        session_destroy();
        unset( $_SESSION[ "SessLoggedAdminPwd" ] );
        unset( $_SESSION[ "SessLoggedIpAdd" ] );
        unset( $_SESSION[ "user_type" ] );
        unset( $_SESSION[ "is_admin" ] );
        unset( $_SESSION[ "modules_permission" ] );
        //session_unregister("SessLoggedAdminPwd");

    }
   
    header( 'Location: '. BASE_URL . $redirect .'.php' ) ;
?>


