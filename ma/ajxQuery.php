<?php
	require_once("../dbconnectvi.php");
		$Db = new dbInvestments();
		include ('machecklogin.php');	
	$count =0;
	$sql = $_POST['sql'];
       
        $sql=  urldecode($sql);
	$rng = $_POST['rng'];
	//$sql =  'select year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s  where pe.amount >  0 and pe.amount <= 5  and  i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pe.Deleted=0  and pec.industry !=15   AND   dates between \'2012-1-01\' and \'2013-9-31\' and  pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1) group by year(pe.dates)#select year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s  where pe.amount >  5 and pe.amount <= 10  and  i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pe.Deleted=0  and pec.industry !=15   AND   dates between \'2012-1-01\' and \'2013-9-31\' and  pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1) group by year(pe.dates)#select year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s  where pe.amount >  10 and pe.amount <= 15  and  i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pe.Deleted=0  and pec.industry !=15   AND   dates between \'2012-1-01\' and \'2013-9-31\' and  pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1) group by year(pe.dates)#select year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s  where pe.amount >  15 and pe.amount <= 25  and  i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pe.Deleted=0  and pec.industry !=15   AND   dates between \'2012-1-01\' and \'2013-9-31\' and  pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1) group by year(pe.dates)#select year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s  where pe.amount >  25 and pe.amount <= 50  and  i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pe.Deleted=0  and pec.industry !=15   AND   dates between \'2012-1-01\' and \'2013-9-31\' and  pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1) group by year(pe.dates)#select year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s  where pe.amount >  50 and pe.amount <= 100  and  i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pe.Deleted=0  and pec.industry !=15   AND   dates between \'2012-1-01\' and \'2013-9-31\' and  pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1) group by year(pe.dates)#select year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s  where pe.amount >  100 and pe.amount <= 200  and  i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pe.Deleted=0  and pec.industry !=15   AND   dates between \'2012-1-01\' and \'2013-9-31\' and  pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1) group by year(pe.dates)#select year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s  where pe.amount > 200 and  i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pe.Deleted=0  and pec.industry !=15   AND   dates between \'2012-1-01\' and \'2013-9-31\' and  pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1) group by year(pe.dates)#';
	
	//$rng = '0-5#5-10#10-15#15-25#25-50#50-100#100-200#200';
	//$_POST['typ']=4;
	if (@$_POST['typ']==4){
		$data = array();
		$sqlarr = explode('#',$sql);
		$rngarr = explode('#',$rng);
		
		//Create head array
		/*$data[0][] = 'Year';
		for($i=0;$i<count($rngarr);$i++){
			$data[0][] = $rngarr[$i];
		}*/
		for($i=0;$i<count($sqlarr);$i++){
			$bdarr = array();
			if ($sqlarr[$i]!=''){
				$sql = $sqlarr[$i];
				$res = mysql_query($sql);	
				while($row = mysql_fetch_assoc($res)) {
					$data[$count][] = $rngarr[$i];   
					foreach ($row as $col => $val) {
						$data[$count][] = $val;
					}
					$count++;
				}
			}
		}
	}else{
		if($sql!=''){
			$res = @mysql_query($sql);	
			$data = array();
			while($row = @mysql_fetch_assoc($res)) {   
				foreach ($row as $col => $val) {
					$data[$count][] = $val;
				}
				$count++;
			}
		}
	}
	
	
	
	
	
	
	
	echo json_encode($data);
        mysql_close();
?>