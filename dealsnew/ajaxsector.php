<?php

require_once("../dbconnectvi.php");
$Db = new dbInvestments();
$string='';
$jsonarray=array();
$mainsector=$_REQUEST['sector'];
$flag = $_REQUEST['vcflag'];
$industry = $_REQUEST['industry'];
if(!isset($_SESSION['UserNames']))
{
        header('Location:../pelogin.php');
}
else
{
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
	 foreach($mainsector as $value)
	{
		$query="select pes.sector_name from pe_sectors as pes,".$tableName." AS pe, pecompanies AS pec where pes.sector_id=".$value." AND pe.PECompanyId = pec.PEcompanyId ".$DBType;
	//	echo $query;
		$sqlquery=mysql_query($query);
		if($row=mysql_fetch_row($sqlquery)){
			$sectorname.="'".$row[0]."'";
			$sectorname.=",";	
		}
		
	}
	$sectorname=trim($sectorname,",");
	/*$string = implode(',', $mainsector);*/
	$industryString = implode(',', $industry);
	//$peSubSectorSql= "select DISTINCT(subsector_name),subsector_id from pe_subsectors where sector_id IN (".$string.") and subsector_name !='' group by subsector_name order by subsector_name";
	$peSubSectorSql= "SELECT DISTINCT(pes.subsector_name),pes.subsector_id 
					  FROM pe_subsectors AS pes,".$tableName." AS pe, pecompanies AS pec,pe_sectors as pesecnew 
					  WHERE pe.PECompanyId=pes.PECompanyId AND pe.PECompanyId = pec.PEcompanyId and pesecnew.PECompanyId = pes.PECompanyId AND pe.Deleted=0 AND pesecnew.sector_name IN (".$sectorname.") AND pec.industry IN (".$industryString.") ".$DBType." AND subsector_name !='' 
					  GROUP BY pes.subsector_name 
					  ORDER BY pes.subsector_name";

	if($getPESubSector = mysql_query($peSubSectorSql))
		{
			$subsector_count=mysql_num_rows($getPESubSector);
			if($subsector_count>0)
			{
				While($myrow=mysql_fetch_array($getPESubSector, MYSQL_BOTH))
				{	
					$subsectorid = $myrow["subsector_id"];
					$subsectorname = $myrow["subsector_name"];
					$jsonarray[]=array('id'=>$subsectorid,'name'=>$subsectorname);
					
				}
			}
		}
		
		echo json_encode(utf8ize($jsonarray));//exit();
}
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
