<?php
//delete file in uploadrefiles directory in publichtml
 session_save_path("/tmp");
 session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();


$delfile= $_POST['txtfile'];
$MandAIdtoUpdate = $_POST['txtMAMAId'];



//echo "<br>***". $delfile;


$currentdir=getcwd();
//echo "<br>Current Diretory=" .$currentdir;
$curdir =  str_replace("/adminvi","",$currentdir);


$target = $curdir . "/uploadrefiles/".$delfile;

//echo "<br><br>Target- ".$target;

//unlink($target);

if(unlink($target))
{
	$UpdateInvestmentSql="update REmama set uploadfilename='',source='' where MAMAId=$MandAIdtoUpdate";
	if($updatersinvestment=mysql_query($UpdateInvestmentSql))
	{
		echo "<br> Deleted file from the server - " .$delfile;
		echo "<br>Source is also set to Null";
	}
}
else
{
	echo "<br> File can't be deleted";
}

?>
