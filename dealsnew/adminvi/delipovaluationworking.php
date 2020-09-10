<?php
//delete file in uploadmamafiles directory in publichtml
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
 session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();


$delfile= $_POST['txtvaluationworkingfile'];
$IPOIdtoUpdate = $_POST['txtIPOId'];

$currentdir=getcwd();
$curdir =  str_replace("/adminvi","",$currentdir);

$target = $curdir . "/uploadmamafiles/valuation_workings/".$delfile;

//echo "<br><br>Target- ".$target;

//unlink($target);

if(unlink($target))
{

	$UpdateInvestmentSql="update ipos set Valuation_Working_fname='' where PEId=$IPOIdtoUpdate";
	if($updatersinvestment=mysql_query($UpdateInvestmentSql))
	{
		echo "<br> Deleted file from the server - " .$delfile;
	}
}
else
{
	echo "<br> File could not be deleted";
}

?>
