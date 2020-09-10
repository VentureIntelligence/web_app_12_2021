<?php 
require("../dbconnectvi.php");
$Db = new dbInvestments();

$currentINR = $_POST['usd'];
$inrvalue = "SELECT value FROM configuration WHERE purpose='USD_INR'";
$inramount = mysql_query($inrvalue);
while($inrAmountRow = mysql_fetch_array($inramount,MYSQL_BOTH))
{
    $usdtoinramount = $inrAmountRow['value'];
}
$inramount_cnt = mysql_num_rows($inramount);
$currentDateTime = date('Y-m-d h:i:s');

if($inramount_cnt > 0){
    $currencyQuery = "UPDATE `configuration` SET `value` = '$currentINR',`modified_on` = '$currentDateTime' WHERE `purpose` = 'USD_INR'";
}else {
    $currencyQuery = "INSERT INTO `configuration`(`name`,`purpose`,`value`,`created_on`,`modified_on`) 
                      VALUES ('USD to INR Current Rate','USD_INR','$currentINR','$currentDateTime','$currentDateTime')";
}

mysql_query($currencyQuery);
echo "INR Value is Updated Successfully";

?>

