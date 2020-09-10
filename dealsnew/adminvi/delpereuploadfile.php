<?php
//delete file in uploadrefiles directory in publichtml
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
 session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();


$delfile= $_POST['txtfile'];
$uploadfile_projectfile=$_POST['hiddenfile'];
$delprojectfile=$_POST['txtprojectfile'];
$PEIdtoUpdate = $_POST['txtPEId'];



//echo "<br>***". $delfile;


$currentdir=getcwd();
//echo "<br>Current Diretory=" .$currentdir;
$curdir =  str_replace("/adminvi","",$currentdir);


$target = $curdir . "/uploadrefiles/".$delfile;

//echo "<br><br>Target- ".$target;

//unlink($target);

if($uploadfile_projectfile=="F")
{
	if(unlink($target))
	{

		$UpdateInvestmentSql="update REinvestments set uploadfilename='',source='' where PEId=$PEIdtoUpdate";
		if($updatersinvestment=mysql_query($UpdateInvestmentSql))
		{
			echo "<br> Deleted file from the server - " .$delfile;
			echo "<br>Source is also set to Null";
		}
	}
	else
	{

		$UpdateInvestmentSql="update REinvestments set uploadfilename='',source='' where PEId=$PEIdtoUpdate";
	//	echo "<br>-- ".$UpdateInvestmentSql;
		if($updatersinvestment=mysql_query($UpdateInvestmentSql))
		{
			echo "<br> File  deleted";

			echo "<br>Source is also set to Null";
		}

	}
}
elseif($uploadfile_projectfile=="P")
{
	if(unlink($target))
	{

		$UpdateREInvestmentSql="update REinvestments set ProjectDetailsFileName='' where PEId=$PEIdtoUpdate";
	//	echo "<Br>**** " .$UpdateREInvestmentSql;
		if($rsupdateinvestment=mysql_query($UpdateREInvestmentSql))
		{
			echo "<br> Poject file Deleted file from the server - " .$delfile;
		}
	}
	else
	{

		$UpdateREInvestmentSql="update REinvestments set ProjectDetailsFileName='' where PEId=$PEIdtoUpdate";
	//	echo "<br>-- ".$UpdateInvestmentSql;
		if($rsupdateinvestment=mysql_query($UpdateREInvestmentSql))
		{
			echo "<br>Project File  deleted";
		}
     	}
}
?>
