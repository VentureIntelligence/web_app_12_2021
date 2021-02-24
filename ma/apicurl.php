<?php include_once("../globalconfig.php");
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
include ('machecklogin.php');
?>
<?php

$_POST = array ("dealtype" => '1,2,3',"time" => "2016","datatype" => "1");

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => GLOBAL_BASE_URL."ma/maapi.php",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $_POST, //Post data here
  
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}
?>
