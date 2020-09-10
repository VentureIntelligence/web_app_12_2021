<?php

require_once("../dbconnectvi.php");
$Db = new dbInvestments();
$string='';
$jsonarray=array();
$mainsector=$_REQUEST['sector'];
$flag = $_REQUEST['vcflag'];

if($flag == 'PE' || $flag == 4 || $flag == 5 || $flag == 3){
	$tableName = 'peinvestments';
} else if($flag == 'EXITS'){
	$tableName = 'manda';
} 
if($flag == 'PE'){
	$DBType = "AND pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'SV' AND hide_pevc_flag =1 )  ";
} else if($flag == 4){
	$DBType = "AND pe.PEId IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'CT' )  ";
} else if($flag == 5){
	$DBType = "AND pe.PEId IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'IF' )  ";
} else if($flag == 3){
	$DBType = "AND pe.PEId IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId =  'SV' )  ";
} else if($flag == 'EXITS'){
	$DBType = "";
}

if($mainsector!='')
{
	 
	$string = implode(',', $mainsector);
	//$peSubSectorSql= "select sector_id,sector_name from pe_sectors where industry IN (".$string.") and sector_name !='' order by sector_name";
	$peSubSectorSql= "SELECT pe_sec.sector_id, pe_sec.sector_name
					  FROM ".$tableName." AS pe, pe_subsectors AS pe_sub, pecompanies AS pec, pe_sectors AS pe_sec
					  WHERE pe.PECompanyId = pe_sub.PEcompanyId AND pe.PECompanyId = pec.PEcompanyId AND pe_sec.sector_id = pe_sub.sector_id AND pe.Deleted=0 ".$DBType." AND pec.industry IN (".$string.") and pe_sec.sector_name !=''
					  GROUP BY pe_sec.sector_name
					  ORDER BY pe_sec.sector_name";
	// echo $peSubSectorSql;
	// exit();
	if($getPESubSector = mysql_query($peSubSectorSql))
		{
			$subsector_count=mysql_num_rows($getPESubSector);
			if($subsector_count>0)
			{
				While($myrow=mysql_fetch_array($getPESubSector, MYSQL_BOTH))
				{	
					$sectorid = $myrow["sector_id"];
					$sectorname = $myrow["sector_name"];
					$jsonarray[]=array('id'=>$sectorid,'name'=>$sectorname);
					
				}
			}
			else{
				$jsonarray[]='';
			}
		}
		
		echo json_encode(utf8ize($jsonarray));//exit();
}
function utf8ize( $mixed ) {
	if (is_array($mixed)) {
		foreach ($mixed as $key => $value) {
			$mixed[$key] = utf8ize($value);
		}
	} elseif (is_string($mixed)) {
		return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
	}
	return $mixed;
}
?>
