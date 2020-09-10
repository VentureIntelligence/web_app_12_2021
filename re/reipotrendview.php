<?php
           // print_r($_POST);
                        if(!$_POST){
                            //echo "not post";
				$yourquery=0;
				$stagevaluetext="";
				$industry=0;
                                //echo "<br>Query for all records";
                                if($type==1)
                                { 
                                   $companysql = " select year(pe.IPODate),count(pe.IPOId),sum(pe.IPOSize)FROM REipos AS pe, reindustry AS i, REcompanies AS pec, region as r where 
                                            IPODate between '".$startyear."' and '".$endyear."' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and r.RegionId=pe.RegionId
                                                    and pe.Deleted=0 and pec.industry=15 group by year(pe.IPODate)";
                                   
                                //echo  $companysql;
                                    $resultcompany= mysql_query($companysql);
                                }
                                elseif ($type==2) 
                                {
                                   $companysql = "select  i.industry,year(pe.IPODate),count(pe.IPOId),sum(pe.IPOSize) from REipos AS pe, reindustry as i,REcompanies as pec where i.industryid = pec.industry and
					pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0  and pec.industry=15 and IPODate between '".$startyear."' and '".$endyear."' group by i.industry,year(pe.IPODate)";
                                 // echo  $companysql;
                                   $resultcompany= mysql_query($companysql);
                                }
			}
			else if($_POST)
                        {
                             // echo "post";
                              $dt1 =  $startyear;
                              $dt2 = $endyear;
                                if($keyword != "" && $keyword != " ")
                                {
                                        $keybef=", REipo_investors as peinv_inv,REinvestors as peinv";
                                }
                                else if($searchallfield!="")
                                {
                                        $keybef=", REipo_investors as peinv_inv,REinvestors as peinv";
                                }
                                if($type==1)
                                {
                                        $companysql = "select year(pe.IPODate),count( DISTINCT pe.IPOId),sum(pe.IPOSize)FROM REipos AS pe, reindustry AS i, REcompanies AS pec, region as r ".$keybef." where ";
                                    
                                }
                                else if($type==2)
                                {
                                    $companysql = "select i.industry,year(pe.IPODate),count(DISTINCT pe.IPOId),sum(pe.IPOSize)FROM REipos AS pe, reindustry AS i, REcompanies AS pec, region as r ".$keybef." where pec.industry = i.industryid and "; 
                                  
                                }
                            
				//echo "<br> individual where clauses have to be merged ";
					if (count($industry) > 0)
                                        {
                                            $indusSql = '';
                                            foreach($industry as $industrys)
                                            {
                                                $indusSql .= " pec.industry=$industrys or ";
                                            }
                                            $indusSql = trim($indusSql,' or ');
                                            if($indusSql !=''){
                                                $whereind = ' ( '.$indusSql.' ) ';
                                            }
                                                $qryIndTitle="Industry - ";
                                            $addVCFlagqry='';
                                        }
                                        if( ($dt1 != "")  && ($dt2 != ""))
                                        {
                                           $qryDateTitle ="Period - ";
                                           $wheredates= " (pe.IPODate between '" . $dt1. "' and '" . $dt2 . "')";
                                        }
                                        if ($whereind != "")
                                        {
                                                $companysql=$companysql . $whereind ." and ";
                                                $aggsql=$aggsql . $whereind ." and ";
                                                $bool=true;
                                        }
                                        else
                                        {
                                                $bool=false;
                                        }
                                      
                                     
                                        if($keyword != "")
                                        {
                                                $keyaft=" peinv.InvestorId=peinv_inv.InvestorId and pe.IPOId=peinv_inv.IPOId and peinv.investor like '%$keyword%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        else if($companysearch != "")
                                        {

                                                $csaft=" pec.companyname LIKE '%$companysearch%'";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                        else if($searchallfield!="")
                                        {
                                                $companysql.=" peinv.InvestorId=peinv_inv.InvestorId and pe.IPOId=peinv_inv.IPOId and ( pec.city LIKE '5$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
				OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or peinv.investor like '%$searchallfield%' ) AND";
                                        }
                                        if(($wheredates !== "") )
                                        {
                                                $companysql = $companysql ." pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and r.RegionId=pe.RegionId
                                                    and pe.Deleted=0 AND ".$wheredates ."";
                                                $bool=true;
                                        }
                                      
                                         if($type == 1)
                                        {
                                                    $searchtype=" and pec.industry=15 group by year(pe.IPODate)";                                                                  
                                        }
                                        if($type == 2)
                                        {
                                                    $searchtype=" and pec.industry=15 group by i.industry,year(pe.IPODate)";
                                        }
                                        if(($searchtype!== ""))
                                        {
                                                $companysql = $companysql .$searchtype;
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                  // echo $companysql;
                                         //$resultcompany= mysql_query($companysql) or die(mysql_error());               
                                }
				else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}
	$companyId=632270771;
	$compId=0;
	$currentyear = date("Y");
	
	$TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
		where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
	
	if($trialrs=mysql_query($TrialSql))
	{
		while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
		{
			$exportToExcel=$trialrow["TrialLogin"];
			$compId=$trialrow["compid"];

		}
	}
	
   if($compId==$companyId){ 
   		$hideIndustry = " and display_in_page=1 "; 
	} else { 
		$hideIndustry=""; 
	}
	
	//INDUSTRY
	$industrysql="select industryid,industry from industry where industryid !=15" . $hideIndustry ." order by industry";
	
	//Company Sector
	$searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
	
	$addVCFlagqry="";
	$pagetitle="PE-backed Companies";

	$getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
					FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
					WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
					AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
					AND r.RegionId = pec.RegionId " .$addVCFlagqry. "
	ORDER BY pec.companyname";
	
	//Stage
	$stagesql = "select StageId,Stage from stage ";
	
        $companysql=  urlencode($companysql);
?>



<div >
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
 <?php

				$exportToExcel=0;
			 $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
										where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";
			//echo "<br>---" .$TrialSql;
			if($trialrs=mysql_query($TrialSql))
			{
				while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
				{
					$exportToExcel=$trialrow["TrialLogin"];
					$studentOption=$trialrow["Student"];
				}
			}

			if($yourquery==1)
				$queryDisplayTitle="Query:";
			elseif($yourquery==0)
				$queryDisplayTitle="";
                        if(trim($buttonClicked==""))
                        {
		           ?>


<td>
<div style="padding:20px;">		
<div id="sec-header">
 <table cellpadding="0" cellspacing="0">
 <tr>
<td>
<h3>Types</h3>
<label><input class="typeoff-nav2" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav2" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
</td></tr>
</table>
</div>
 <div class="profile-view-title"> 
 <?php 
 if($type==1)
 {
 ?>
    <h2>PE - Year on Year</h2>
<?php
 }
 elseif($type==2)
 {
     ?>
     <h2>PE - By Industry</h2>
 <?php
 }
  elseif($type==3)
 {
     ?>
     <h2>PE - By Stage</h2>
 <?php
 }
  elseif($type==4)
 {
     ?>
     <h2>PE - By Range</h2>
 <?php
 }
  elseif($type==5)
 {
     ?>
     <h2>PE - By Investor</h2>
 <?php
 } elseif($type==6)
 {
     ?>
     <h2>PE - By Region</h2>
 <?php
 }
 ?>
 </div><br>
 
 </td>
  <? 
    }
    ?>
</tr>
</table>
</div>
<div class=""></div>