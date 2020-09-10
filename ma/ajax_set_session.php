
<?php
session_save_path("/tmp");
session_start();
unset($_SESSION['ma_popup_display']);
echo "success";
?>