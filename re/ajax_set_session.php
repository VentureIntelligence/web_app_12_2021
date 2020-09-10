
<?php
session_save_path("/tmp");
session_start();
unset($_SESSION['re_popup_display']);
echo "success";
?>