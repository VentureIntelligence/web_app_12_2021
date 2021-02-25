<?php
include "header.php";
include "sessauth.php";
	$concps = mysql_connect("localhost","venture_cpslogin","Cps$2010");
	if (!$concps)
	  {
	  die('Could not connect: ' . mysql_error());
	  }
	mysql_select_db("venture_cps", $concps);
	
?>
