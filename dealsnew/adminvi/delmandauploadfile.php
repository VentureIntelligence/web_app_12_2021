<?php
//delete file in uploadmamafiles directory in publichtml
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
 session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();


$delfile= $_POST['txtfile'];
$MandAIdtoUpdate = $_POST['txtMandAId'];



//echo "<br>***". $delfile;


$currentdir=getcwd();
//echo "<br>Current Diretory=" .$currentdir;
$curdir =  str_replace("/adminvi","",$currentdir);


$target = $curdir . "/uploadmamafiles/".$delfile;

//echo "<br><br>Target- ".$target;

//unlink($target);

if(unlink($target))
{

	$UpdateInvestmentSql="update manda set uploadfilename='',source='' where MandAId=$MandAIdtoUpdate";
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
