<?php
	include "header.php";
	include "conf_Admin.php";
	require_once MODULES_DIR."cprofile.php";
	$cprofile = new cprofile();
	
	$where = "TRIM(CIN) like '".Trim($_GET['queryString'])."' and Company_Id != ".Trim($_GET['CProfileId'])." ";
	$val = $cprofile->CheckCinExists($where);
    if($val != 0)
	{
	  echo "CIN Already Exists";
	  echo "<script type='text/javascript'>";
	 // echo "document.getElementById('save_business').style.display='none';";
	  echo "document.getElementById('save_business').disabled = true;";
	  echo "</script>";
	}else{
	  //echo "<span style='color:#008000;'>CIN does NOT Exist</span>";
           echo "<script type='text/javascript'>";
	  echo "document.getElementById('save_business').disabled = false;";
	  echo "</script>";
	}
	
?>