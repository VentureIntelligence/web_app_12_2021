<?php
    
/*echo $addedflagQry . $addhide_pms_qry . $addDelind;
echo $startyear;
echo $endyear;*/
                    if(count($_POST)==0){
                          
				 //echo "not post";
				$yourquery=0;
				$stagevaluetext="";
				$industry=0;
                                //echo "<br>Query for all records";
                                if($type==1)
                                { 
                                      
                                    $companysql = "select year(pe.DealDate),count(pe.MandAId) as totaldeals,sum(case when pe.hideamount=0 then pe.DealAmount end)as totalamount from REmanda AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s where pec.industry = i.industryid
                                         AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry=15 and pe.StageId=s.RETypeId and DealDate between '".$startyear."' and '".$endyear."' group by year(pe.DealDate)"  ;
                                   //echo  $companysql;
                                    $resultcompany= mysql_query($companysql);
                                }
                                elseif ($type==2) 
                                {
                                   $companysql = "select  i.industry,year(pe.DealDate),count(pe.MandAId) as totaldeals,sum(case when pe.hideamount=0 then pe.DealAmount end)as totalamount from REmanda AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s where  i.industryid=pec.industry 
                                       and pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry=15 and pe.StageId=s.RETypeId and DealDate between '".$startyear."' and '".$endyear."' group by i.industry,year(pe.DealDate)";
                                  //echo  $companysql;
                                   $resultcompany= mysql_query($companysql);
                                }
                               
			//	     echo "<br>all records" .$companysql;
			}
			else if($_POST)
                        {
                              $dt1 =  $startyear;
                              $dt2 = $endyear;
                              $addVCFlagqry = ' and pec.industry =15';
                           
                                if(trim($investorsearch) != "")
                                {
                                        $keybef=" ,REmanda_investors as peinv_inv,REinvestors as inv";
                                }
                                if(trim($acquirersearch)!= "")
                                    {
                                    $acqbef=", acquirers AS ac";
                                }
                                if(trim($adcompanyacquirer_legal)!="" || trim($adcompanyacquirer_trans)!="")
                                {
                                        $albef=",REadvisor_cias AS cia, REinvestments_advisoracquirer AS adac";
                                         $albef2=",REadvisor_cias AS cia, REinvestments_advisorcompanies AS adac";
                                }
                              
                                if($type==1)
                                {
                                    if($adcompanyacquirer_legal!="" || $adcompanyacquirer_trans!="")
                                    {
                                             $companyadd = "select year(DealDate),count(MandAId),sum(DealAmount)from (";
                                             $companysql= $companyadd."select pe.DealDate,pe.MandAId,pe.DealAmount from REmanda AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s ".$albef." where";
                                             $companysql2 = "select pe.DealDate,pe.MandAId,pe.DealAmount from REmanda AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s ".$albef2." where";
                                    }
                                    else {
                                        $companysql = "select year(pe.DealDate),count(pe.MandAId),sum(case when pe.hideamount=0 then pe.DealAmount end)from REmanda AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s ".$keybef.$albef." where";
                                    }
                                }
                                 if($type==2)
                                {
                                    if($adcompanyacquirer_legal!="" || $adcompanyacquirer_trans!="")
                                    {
                                             $companyadd = "select industry,year(DealDate),count(MandAId),sum(DealAmount)from (";
                                             $companysql= $companyadd."select i.industry, pe.DealDate,pe.MandAId,pe.DealAmount from REmanda AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s ".$albef." where";
                                             $companysql2 = "select i.industry,pe.DealDate,pe.MandAId,pe.DealAmount from REmanda AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s ".$albef2." where";
                                    }
                                    else {
                                        $companysql = "select i.industry,year(pe.DealDate),count(pe.MandAId),sum(case when pe.hideamount=0 then pe.DealAmount end)from REmanda AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s ".$keybef.$albef." where";
                                    }
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
                                            if ($boolStage==true)
                                            {
                                                $stagevalue="";
                                                $stageidvalue="";
                                                foreach($stageval as $stage)
                                                {
                                                        //echo "<br>****----" .$stage;
                                                        $stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
                                                        $stageidvalue=$stageidvalue.",".$stage;
                                                }

                                                $wherestage = $stagevalue ;
                                                $qryDealTypeTitle="Stage  - ";
                                                $strlength=strlen($wherestage);
                                                $strlength=$strlength-3;
                                                //echo "<Br>----------------" .$wherestage;
                                                $wherestage= substr ($wherestage , 0,$strlength);
                                                $wherestage ="(".$wherestage.")";
                                                //echo "<br>---" .$stringto;

                                            }
                                           /* if ($stage>0)
                                            {
                                             $wherestage = " pe.StageId =" .$stage ;
                                             $qryDealTypeTitle="Stage  - ";
                                            }*/
                                            if ($dealtype!= "--" && $dealtype!= "")
                                            {
                                                    $wheredealtype = " pe.DealTypeId =" .$dealtype;
                                                    $qryDealTypeTitle="Deal Type - ";
                                            }
                                            if($targetProjectTypeId==1)
                                                   $whereSPVCompanies=" pe.SPV=0";
                                            elseif($targetProjectTypeId==2)
                                                   $whereSPVCompanies=" pe.SPV=1";
                                            if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                                            {
                                                    $qryDateTitle ="Period - ";
                                                    $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                                            }       
                                           
                                       if ($whereind != "")
                                        {
                                                $companysql=$companysql . $whereind ." and ";
                                                $aggsql=$aggsql . $whereind ." and ";
                                                $bool=true;
                                        }
                                        if (($wherestage != ""))
                                        {
                                                 $companysql=$companysql . $wherestage . " and " ;
                                                 $aggsql=$aggsql . $wherestage ." and ";
                                                 $bool=true;
                                        }

                                        if (($wheredealtype != ""))
                                        {
                                                $companysql=$companysql . $wheredealtype . " and " ;
                                                $aggsql=$aggsql . $wheredealtype . " and " ;
                                                $bool=true;
                                        }
                                        if (($whereSPVCompanies != "") )
                                        {
                                                $companysql=$companysql .$whereSPVCompanies . " and ";
                                                $bool=true;
                                        }
                                        if(($wheredates !== "") )
                                        {
                                                $companysql = $companysql . $wheredates ." and ";
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                            
                                         if(trim($investorsearch) != "")
                                        {
                                                $keyaft=" pe.MandAId=peinv_inv.MandAId and inv.InvestorId=peinv_inv.InvestorId and inv.investor LIKE '%$investorsearch%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        else if(trim($acquirersearch)!= "")
                                        {
                                            $acqaft=" ac.AcquirerId = pe.AcquirerId and ac.Acquirer LIKE '%$acquirersearch%'";
                                            $companysql=$companysql . $acqaft . " and ";
                                        }
                                        else if(trim($companysearch) != "")
                                        {

                                                $csaft=" (pec.companyname LIKE '%$companysearch%')";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                        else if($sectorsearch != "")
                                        {
                                                $ssaft=" (pec.sector_business LIKE '%$sectorsearch%')";
                                                 $companysql=$companysql . $ssaft. " and ";
                                        }
                                        else if($searchallfield!="")
                                        {
                                                $companysql.="( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
                                            OR sector_business LIKE '$searchallfield%' or  MoreInfoReturns LIKE '$searchallfield%' or  InvestmentDeals LIKE '$searchallfield%') AND";
                                        }
                                        if(($wheredates !== "") )
                                        {
                                                $companysql = $companysql ." i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                        and pe.Deleted=0 and pe.StageId=s.RETypeId  AND ".$wheredates ."";
												 
						$companysql2 = $companysql2 ." i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                        and pe.Deleted=0 and pe.StageId=s.RETypeId  AND ".$wheredates ."";
                                                $aggsql = $aggsql . $wheredates ." ";
                                                $bool=true;
                                        }
                                        if($adcompanyacquirer_legal!="")
                                        {
                                                $alaft=" and adac.CIAId = cia.CIAId AND adac.PEId = pe.MandAId AND cia.cianame LIKE '%$adcompanyacquirer_legal%' and AdvisorType='L'";
                                                $companysql=$companysql . $alaft . " ";
						$companysql2=$companysql2 . $alaft . "";
                                        }
                                        else if($adcompanyacquirer_trans!="")
                                        {
                                                $ataft=" and adac.CIAId = cia.CIAId AND adac.PEId = pe.MandAId AND cia.cianame LIKE '%$adcompanyacquirer_trans%' and AdvisorType='T'";
                                                $companysql=$companysql . $ataft . "  ";
						$companysql2=$companysql2 . $ataft . " ";
                                        }
                                       
					if($adcompanyacquirer_legal!="")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        if($adcompanyacquirer_trans!="")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                         if($type == 1)
                                        {
                                            if($adcompanyacquirer_legal!="" || $adcompanyacquirer_trans!="")
                                            {
                                                    $searchtype=" $addVCFlagqry group by year(DealDate)";
                                            }
                                            else {
                                                    $searchtype=" $addVCFlagqry group by year(pe.DealDate)";
                                            }                                                                
                                      }
                                        if($type == 2)
                                        {
                                           if($adcompanyacquirer_legal!="" || $adcompanyacquirer_trans!="")
                                            {
                                                    $searchtype=" $addVCFlagqry group by industry, year(DealDate)";
                                            }
                                            else {
                                                    $searchtype=" $addVCFlagqry group by i.industry,year(pe.DealDate)";
                                            }
                                        }
                                         if(($searchtype!== "") )
                                        {
                                                $companysql = $companysql .$searchtype;
                                                $bool=true;
                                        }
                                   //echo $companysql;
                                         $resultcompany= mysql_query($companysql);
		}
	//}
	//END OF POST
	
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
	
	
	/*$getTotalQuery="SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
	FROM peinvestments AS pe, pecompanies AS pec
	WHERE pe.Deleted =0  and pe.PECompanyId=pec.PECompanyId
	AND pec.industry !=15 and pe.AggHide=0 and
				pe.PEId NOT
						IN (
						SELECT PEId
						FROM peinvestments_dbtypes AS db
						WHERE DBTypeId ='SV'
						AND hide_pevc_flag =1
						)";
	$pagetitle="PE Investments -> Search";
	$stagesql = "select StageId,Stage from stage ";*/
	
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



<table cellpadding="0" cellspacing="0" width="100%">
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

<div id="sec-header">
 <table cellpadding="0" cellspacing="0">
 <tr>
<td class="investment-form">
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
    <h2>M&A(PE) - Year on Year</h2>
<?php
 }
 elseif($type==2)
 {
     ?>
     <h2>M&A(PE) - By Industry</h2>
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


<div class=""></div>

            <script type="text/javascript">
                $("a.postlink").click(function(){
                  
                    hrefval= $(this).attr("href");
                    $("#pesearch").attr("action", hrefval);
                    $("#pesearch").submit();
                    return false;
                    
                });
                function resetinput(fieldname)
                {
                    
                  $("#resetfield").val(fieldname);
                  $("#pesearch").submit();
                    return false;
                }
            </script>
</body>
</html>
 <?php  mysql_close();   ?>
