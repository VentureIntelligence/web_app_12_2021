<?php
session_start();
header("Cache-control: private");
if(trim($_SESSION['validation_code']) != trim($_REQUEST['validation_code'])){
 echo 'Error validation code';
}else{
 echo 'Vlidation code ok';
}
?>