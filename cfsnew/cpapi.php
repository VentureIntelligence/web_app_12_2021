<?php include_once("../globalconfig.php"); ?>
<?php

$_POST = array ("username" => "team1@kutung.com","password" => "vi123","cin" => 'L40100GJ1996PLC030533');
$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => GLOBAL_BASE_URL."cfsnew/capkconnectCprofile.php",
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_POSTFIELDS => $_POST,
  
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