<?php
	include "header.php";
	include "sessauth.php";
	require_once MODULES_DIR."plstandard.php";
	$plstandard = new plstandard();
	require_once MODULES_DIR."balancesheet.php";
	$balancesheet = new balancesheet();

	$fields = array("*");
	$CompareCount = count($_REQUEST['answer']['CCompanies']);
	$where29 .= "CId_FK IN (".implode(',',$_REQUEST['answer']['CCompanies']).") AND FY = ".$_REQUEST['answer']['Year'];
	$order29 = "SCompanyName ASC";
	//$CompareResults = $plstandard->ExportGetCompareCompanies($where29,$order29,"name");
        $CompareResults = $plstandard->ExportGetCompareCompaniesNew($where29,$order29,"name");
	
	//pr(implode(',',$_REQUEST['answer']['CCompanies']));
	//pr($CompareResults);exit;
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=exportComparsion.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
	$flag = false; 
	foreach($CompareResults as $row) { 
	 if(!$flag) { 
	 // display field/column names as first row 
		 echo implode("\t", array_keys($row)) . "\r\n"; 
		 $flag = true; 
	 } 
	 array_walk($row, 'cleanData');
	 echo implode("\t", array_values($row)) . "\r\n"; 
	} 
        mysql_close();
	exit;
?>	