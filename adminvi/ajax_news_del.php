<?php

require("../dbconnectvi.php");
$Db = new dbInvestments();
 //session_save_path("/tmp");
session_start();
//print_r($_POST);
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{
    if( isset( $_POST ) ) {
        $user_id = $_POST[ 'userid' ];
        $source_id = $_POST[ 'source_id' ];
        if($source_id)
        {
            $update = "Delete From  sources  WHERE source_id = " . $source_id;

            mysql_query( $update ) or die( mysql_error() );
            echo 1;
        }
        else{
        //$update = "DELETE FROM newsletter WHERE  id   = " . $user_id;
        $update = "UPDATE newsletter SET is_deleted = 1 WHERE id = " . $user_id;

        mysql_query( $update ) or die( mysql_error() );
        echo 1;
        }
    } else {
        echo 2;
    }
    

?>
<?php

} // if resgistered loop ends
else
    header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>