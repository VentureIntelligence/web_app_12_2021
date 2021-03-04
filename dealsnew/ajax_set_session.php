
<?php
session_start();
$_SESSION['popup_display'] = '';
if(!isset($_SESSION['UserNames']))
{
         header('Location:../pelogin.php');
}
else
{
echo "success";
}
?>