<?php include_once("../globalconfig.php"); ?>

<?php
 session_start();
require("../dbconnectvi.php");
$Db = new dbInvestments();

 $investorName=$_POST['investorName'];

$array=explode(',', $investorName);
//echo json_encode($array);
$array = implode("','",$array);

$query="SELECT `InvestorId` FROM `peinvestors` WHERE `Investor` IN ('".$array."')";

//echo $query;exit();
$sqlSelResult = mysql_query($query) or die(mysql_error());
$rowSelCount = mysql_num_rows($sqlSelResult);

//echo $rowSelCount;exit();

//echo json_encode(mysql_fetch_assoc($sqlSelResult));exit();
if($sqlSelResult)
{
while ($row = mysql_fetch_assoc($sqlSelResult)) {

    $InvestorId .= $row['InvestorId'] ."," ;
}

echo rtrim($InvestorId,",");

}

?>