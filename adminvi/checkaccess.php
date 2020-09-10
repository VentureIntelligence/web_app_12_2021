<?php
session_start();
function checkaccess( $pageName = '' ) {
    
    if( $_SESSION[ 'is_admin' ] == 0 ) {
        $modulesArray = explode( ',', $_SESSION[ 'modules_permission' ] );
        if( !in_array( $pageName, $modulesArray ) ) {
            header('Location:'.BASE_URL.'adminusers.php');
        }
    }
}
?>