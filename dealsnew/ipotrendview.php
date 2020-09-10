<?php
        $type=isset($_REQUEST['type']) ? $_REQUEST['type'] :1; 
       
               $invtypesql = "select InvestorType,InvestorTypeName from investortype where Hide=0";

                   if($vcflagValue==0)
                    {
                            $addVCFlagqry = "" ;
                            $searchTitle = "List of PE-backed IPOs ";
                            $searchAggTitle = "Aggregate Data - PE-backed IPOs ";
                     }
                    elseif($vcflagValue==1)
                    {
                            $addVCFlagqry = " and VCFlag=1 ";
                            $searchTitle = "List of VC-backed IPOs ";
                            $searchAggTitle = "Aggregate Data - VC-backed IPOs ";
                    }
                  
                     
		 $dbTypeSV="SV";
                $dbTypeIF="IF";
                $dbTypeCT="CT";

                $searchString="Undisclosed";
                $searchString=strtolower($searchString);

                $searchString1="Unknown";
                $searchString1=strtolower($searchString1);

                $searchString2="Others";
                $searchString2=strtolower($searchString2);

                $buttonClicked=$_POST['hiddenbutton'];
                $fetchRecords=true;
                $totalDisplay="";
               
               
                 
                        

               if($industry >0)
		{
			$industrysql= "select industry from industry where IndustryId=$industry";
			if ($industryrs = mysql_query($industrysql))
			{
				While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
				{
					$industryvalue=$myrow["industry"];
				}
			}
		}
		if($investorType !="--")
		{
		       $invTypeSql= "select InvestorTypeName from investortype where InvestorType='$investorType'";
		       if ($invrs = mysql_query($invTypeSql))
		       {
		          While($myrow=mysql_fetch_array($invrs, MYSQL_BOTH))
		          {
		             $invtypevalue=$myrow["InvestorTypeName"];
		          }
		       }
		}

		$aggsql= "select count(pe.IPOId) as totaldeals,sum(pe.IPOSize) as totalamount from ipos as pe,industry as i,pecompanies as pec where";

		
		if($exitstatusvalue=="0")
		  $exitstatusdisplay="Partial Exit";
		elseif($exitstatusvalue=="1")
                  $exitstatusdisplay="Complete Exit";
                else
                  $exitstatusdisplay="";
                
                if( $investorSale=="1")
		  $investorSaleDisplay="Yes";
		elseif( $investorSale=="0")
                  $investorSaleDisplay="No";
                else
                  $investorSaleDisplay="";
            //  print_r($_POST);
             // echo $keyword."asd";
                    if(count($_POST)==0){
				// echo "not post";
				$yourquery=0;
				$stagevaluetext="";
				$industry=0;
                                //echo "<br>Query for all records";
                                if($type==1)
                                { 
                                   $companysql = " select year(pei.IPODate),count(DISTINCT pei.IPOId),sum(DISTINCT pei.IPOSize) from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv where 
                                            IPODate between '".$startyear."' and '".$endyear."' AND i.industryid=pec.industry and pec.PEcompanyID = pei.PECompanyID and ipoinv.IPOId=pei.IPOId and pei.Deleted=0 " .$addVCFlagqry. " group by year(pei.IPODate)";
                                  
                                //echo  $companysql;
                                    $resultcompany= mysql_query($companysql);
                                }
                                elseif ($type==2) 
                                {
                                   $companysql = "select  i.industry,year(pei.IPODate),count(DISTINCT  pei.IPOId),sum(DISTINCT pei.IPOSize) from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv where i.industryid=pec.industry and
					pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and pei.Deleted=0 " .$addVCFlagqry. " and IPODate between '".$startyear."' and '".$endyear."' group by i.industry,year(pei.IPODate)";
                                  //echo  $companysql;
                                   $resultcompany= mysql_query($companysql);
                                }
                                else if($type ==4)
                                {
									$compRangeSql="";
                                    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200+");
                                    for($r=0;$r<count($range);$r++)
                                    {
                                        if($r == count($range)-1)
                                        {
                                            $companysql = "select year(pei.IPODate),count(DISTINCT  pei.IPOId),sum(DISTINCT pei.IPOSize) from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv where i.industryid=pec.industry and
                                            pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and pei.Deleted=0 " .$addVCFlagqry. " and (pei.IPOSize  > 200) and IPODate between '".$startyear."' and '".$endyear."' group by year(pei.IPODate)";
                                            
                                          //echo  $companysql;
                                             $resultcompany= mysql_query($companysql);
                                        }
                                        else
                                        {
                                            $limit=(string)$range[$r];
                                            $elimit=explode("-", $limit);
                                            $companysql  = "select year(pei.IPODate),count(DISTINCT pei.IPOId),sum(pei.IPOSize) from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv where i.industryid=pec.industry and
                                            pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and pei.Deleted=0 " .$addVCFlagqry. " and (pei.IPOSize > ".$elimit[0]." and pei.IPOAmount <= ".$elimit[1].") and IPODate between '".$startyear."' and '".$endyear."' group by year(pei.IPODate)";                           
                                            //echo  $companysql;
                                            $resultcompany= mysql_query($companysql);
                                        }
										$compRangeSql .= $companysql."#";   
                                       /* if(mysql_num_rows($resultcompany)>0)
                                        {
                                            while ($rowrange = mysql_fetch_array($resultcompany))
                                            {
                                                $deal[$range[$r]][$rowrange[0]]['dealcount']=$rowrange[1];
                                                $deal[$range[$r]][$rowrange[0]]['sumamount']=$rowrange[2];   
                                            }
                                        }*/
                                       /* else
                                        {
                                            $deal='';
                                        }*/
                                     }
									 $compRangeSql= urlencode($compRangeSql);
                                }
                                elseif($type==5)
                                {
                                   $companysql = "select inv.InvestorTypeName,year(pei.IPODate),count(DISTINCT  pei.IPOId),sum(DISTINCT pei.IPOSize) from ipos as pei, industry as i,pecompanies as pec, investortype as inv, ipo_investors as ipoinv where i.industryid=pec.industry and
                                            pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and pei.Deleted=0 " .$addVCFlagqry. " and pei.InvestorType=inv.InvestorType and IPODate between '".$startyear."' and '".$endyear."' group by inv.InvestorTypeName, year(pei.IPODate)";
                                  //echo  $companysql;
                                  $resultcompany= mysql_query($companysql);
                                }
                               
				//   echo "<br>all records" .$companysql;
			}
			//if (($companyType!="--") || ($debt_equity!="--") || ($invType != "--") || ($regionId>0)  || ($startRangeValue == "--") || ($endRangeValue == "--") || (($year1 != "")  && ($year2 != "")) || ($advisorsearchstring_trans!= " ")||($advisorsearchstring_legal!=" ")||($sectorsearch != " ")||($companysearch != " ")||($keyword != " ").$checkForStageValue)
			 elseif(count($_POST)>0)	
                        {
                               //echo "post";
                              $dt1 =  $startyear;
                              $dt2 = $endyear;
                              
                            if($type != 4)
                            {
                                if($keyword != "" && $keyword != " ")
                                {
                                        $keybef=", peinvestors as pinv";
                                }
                                if($type==1)
                                {
                                    $companysql = "select year(pei.IPODate),count(DISTINCT  pei.IPOId),sum( DISTINCT pei.IPOSize) from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv ".$keybef." where";
                                }
                                else if($type==2)
                                {
                                   $companysql = "select i.industry,year(pei.IPODate),count(DISTINCT pei.IPOId),sum(DISTINCT pei.IPOSize) from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv ".$keybef." where "; 
                                
                                }
                                else if($type==5)
                                {
                                   $companysql = "select inv.InvestorTypeName,year(pei.IPODate),count(DISTINCT pei.IPOId),sum(DISTINCT pei.IPOSize) from ipos as pei, industry as i,pecompanies as pec, investortype as inv, ipo_investors as ipoinv ".$keybef." where inv.InvestorType=pei.InvestorType and "; 
                                
                                }
                            
				//echo "<br> individual where clauses have to be merged ";
					
                                        if ($industry > 0)
                                        {
                                                $whereind = " pec.industry=" .$industry ;
                                                $qryIndTitle="Industry - ";
                                        }
                                        if (($investorType!= "--")  && ($investorType!=""))
                                        {
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pei.InvestorType = '".$investorType."'";
                                        }
                                          if($exitstatusvalue!="--")
                                          {    $whereexitstatus=" pei.ExitStatus=".$exitstatusvalue;  }

                                          if($investorSale!="--")
                                          {    $whereinvestorSale=" pei.InvestorSale=".$investorSale;

                                          }
                                            if ($region!= "--")
                                            {
                                                    $qryRegionTitle="Region - ";
                                                    $whereregion = " pei.region ='".$region."'";
                                            }
                                            if( ($dt1 != "")  && ($dt2 != ""))
                                            {
                                                    $qryDateTitle ="Period - ";
                                                    $wheredates= " and IPODate between '" . $dt1. "' and '" . $dt2 . "' ";
                                            }
                                            if($type == 1)
                                            {
                                                    $searchtype=" group by year(pei.IPODate)";                                                          
                                            }
                                            if($type == 2)
                                            {
                                                    $searchtype=" group by i.industry, year(pei.IPODate)";
                                            }
                                            if($type == 5)
                                            {
                                                    $searchtype=" group by  inv.InvestorTypeName, year(pei.IPODate)";
                                            }
                                         
                                            if(trim($txtfrm>0) && trim($txtto==""))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" ipoinv.MultipleReturn > " .$txtfrm  ;
                                            }
                                            elseif(trim($txtfrm=="") && trim($txtto>0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" ipoinv.MultipleReturn < " .$txtto  ;
                                            }
                                            elseif(trim($txtfrm>0) && trim($txtto >0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" ipoinv.MultipleReturn > " .$txtfrm . " and  ipoinv.MultipleReturn <".$txtto;
                                            }
                                               // echo "<bR>***" .$whereReturnMultiple;
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
                                        if (($whereInvType != "") )
                                        {
                                                $companysql=$companysql .$whereInvType . " and ";
                                                $aggsql = $aggsql . $whereInvType ." and ";
                                                $bool=true;
                                        }
                                        if($whereexitstatus!="")
                                        {
                                          $companysql=$companysql .$whereexitstatus . " and ";
                                        }
					if($whereinvestorSale!="")
                                        {
                                          $companysql=$companysql .$whereinvestorSale . " and ";
                                        }
                                                
                                        if($keyword != "" && $keyword != " ")
                                        {
                                                $keyaft=" pinv.InvestorId=ipoinv.InvestorId and pei.IPOId=ipoinv.IPOId and pinv.investor like '%$keyword%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        else if($companysearch != "" && $companysearch != " ")
                                        {

                                                $csaft=" pec.companyname LIKE '%$companysearch%'";
                                                $companysql=$companysql . $csaft . " and ";
                                        }
                                         if($searchallfield!="")
                                        {
                                                $companysql.="( city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
                                                OR sector_business LIKE '$searchallfield%' or  MoreInfor LIKE '$searchallfield%' or  InvestmentDeals LIKE '$searchallfield%' ) AND";
                                        }
                                        if($whereReturnMultiple!= "")
                                        {
                                         $companysql = $companysql . $whereReturnMultiple ." and ";
                                        }
                                        
                                        $companysql = $companysql . "  i.industryid=pec.industry and
					pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and
					pei.Deleted=0 " .$addVCFlagqry. " ";
                                        
					if(($wheredates !== "") )
					{
						$companysql = $companysql . $wheredates;
						$aggsql = $aggsql . $wheredates ." and ";
						$bool=true;
					}
                                        if(($searchtype!== "") )
                                        {
                                                $companysql = $companysql .$searchtype;
                                        }
                                      //echo $companysql;
                                         $resultcompany= mysql_query($companysql);
                               }
                                        
                                        
                                        
                               else if($type == 4 && $_POST)
                                {
                                    
                                    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200");
                                    //print_r($range);
									$compRangeSql = '';
                                    for($r=0;$r<count($range);$r++)
                                    {
                                         if($keyword != "" && $keyword != " ")
                                        {
                                                $keybef=", peinvestors as pinv";
                                        }
                                        $limit=(string)$range[$r];
                                        $elimit=explode("-", $limit);
                                         if( $elimit[0] !='' && $elimit[1] !='' && $elimit[0] != $elimit[1])
                                         {
                                             $whererange = " and (pei.IPOSize > ".$elimit[0]." and pei.IPOSize <= ".$elimit[1].")";
                                         }
                                         else
                                         {
                                             $whererange = " and (pei.IPOSize > ".$elimit[0].")";
                                         }
                                        $companysql = "select year(pei.IPODate),count(DISTINCT pei.IPOId),sum(DISTINCT pei.IPOSize) from ipos as pei, industry as i,pecompanies as pec, ipo_investors as ipoinv ".$keybef." where i.industryid=pec.industry and
                                            pec.PEcompanyID = pei.PECompanyID  and  ipoinv.IPOId=pei.IPOId  and pei.Deleted=0 " .$addVCFlagqry.$whererange." and ";
                                         if ($industry > 0)
                                        {
                                                $whereind = "  pec.industry=" .$industry ;
                                                $qryIndTitle="Industry - ";
                                        }
                                        if (($investorType!= "--")  && ($investorType!=""))
                                        {
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = "  pei.InvestorType = '".$investorType."'";
                                        }
                                          if($exitstatusvalue!="--")
                                          {    $whereexitstatus="  pei.ExitStatus=".$exitstatusvalue;  }

                                          if($investorSale!="--")
                                          {    $whereinvestorSale="  pei.InvestorSale=".$investorSale;

                                          }
                                            if ($region!= "--")
                                            {
                                                    $qryRegionTitle="Region - ";
                                                    $whereregion = " pei.region ='".$region."'";
                                            }
                                            if( ($dt1 != "")  && ($dt2 != ""))
                                            {
                                                    $qryDateTitle ="Period - ";
                                                    $wheredates= " IPODate between '" . $dt1. "' and '" . $dt2 . "' group by year(pei.IPODate)";
                                            }

                                            if(trim($txtfrm>0) && trim($txtto==""))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" and ipoinv.MultipleReturn > " .$txtfrm  ;
                                            }
                                            elseif(trim($txtfrm=="") && trim($txtto>0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" and ipoinv.MultipleReturn < " .$txtto  ;
                                            }
                                            elseif(trim($txtfrm>0) && trim($txtto >0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" and ipoinv.MultipleReturn > " .$txtfrm . " and  ipoinv.MultipleReturn <".$txtto;
                                            }
                                               // echo "<bR>***" .$whereReturnMultiple;
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
                                        if (($whereInvType != "") )
                                        {
                                                $companysql=$companysql .$whereInvType . " and ";
                                                $aggsql = $aggsql . $whereInvType ." and ";
                                                $bool=true;
                                        }
                                        if($whereexitstatus!="")
                                        {
                                          $companysql=$companysql .$whereexitstatus . " and ";
                                        }
					if($whereinvestorSale!="")
                                        {
                                          $companysql=$companysql .$whereinvestorSale . " and ";
                                        }
                                                
                                        if($keyword != "" && $keyword != " ")
                                        {
                                                $keyaft=" pinv.InvestorId=ipoinv.InvestorId and pei.IPOId=ipoinv.IPOId and pinv.investor like '%$keyword%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        else if($companysearch != "" && $companysearch != " ")
                                        {

                                                $csaft=" pec.companyname LIKE '%$companysearch%'";
                                                $companysql=$companysql . $csaft . " and ";
                                        }
                                        if($searchallfield!="")
                                        {
                                                $companysql.="( city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
				OR sector_business LIKE '$searchallfield%' or  MoreInfor LIKE '$searchallfield%' or  InvestmentDeals LIKE '$searchallfield%' ) AND";
                                        }
                                        if($whereReturnMultiple!= "")
                                        {
                                         $companysql = $companysql . $whereReturnMultiple ." and ";
                                        }
                                        
					if(($wheredates !== "") )
					{
						$companysql = $companysql . $wheredates ."";
						$aggsql = $aggsql . $wheredates ." ";
						$bool=true;
					}
						$compRangeSql .= $companysql."#"; 
                                         //echo $companysql;
                                              
                                     }
						 $compRangeSql = urlencode($compRangeSql);
                                }
                           //  echo $companysql;
		}
			
			
				else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
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

<div>
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
    <!--div style="float:right;padding: 20px" class="key-search"><b></b> <input type="text" name="searchallfield" placeholder=" Keyword Search"> <input type="button" name="fliter_stage" value="Go" onclick="this.form.submit();"></div-->

<div class="result-cnt">		
                         
    <?php
if($vcflagValue==0)
{
?>
<div id="sec-header">
 <table cellpadding="0" cellspacing="0" width="100%">
 <tr>
<td class="investment-form">
<h3>Types</h3>
<label><input class="typeoff-nav20" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav20" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
<label><input class="typeoff-nav20" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav20" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>

</td></tr>
</table>
</div>
<?php
}
else if($vcflagValue==1)
{
?>
<div id="sec-header">
 <table cellpadding="0" cellspacing="0">
 <tr>
<td class="investment-form">
<h3>Types</h3>
<label><input class="typeoff-nav21" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav21" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
<label><input class="typeoff-nav21" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav21" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
</td></tr>
</table>
</div>
<?php     
}
?>
 <div class="profile-view-title"> 
 <?php 
 if($type==1 && $vcflagValue==0)
 {
 ?>
    <h2>IPO(PE) - Year on Year</h2>
<?php
 }
 elseif($type==2  && $vcflagValue==0)
 {
     ?>
     <h2>IPO(PE) - By Industry</h2>
 <?php
 }
 
  elseif($type==4 && $vcflagValue==0)
 {
     ?>
     <h2>IPO(PE)  - By Range</h2>
 <?php
 }
  elseif($type==5 && $vcflagValue==0)
 {
     ?>
     <h2>IPO(PE)  - By Investor</h2>
 <?php
 } 
 else if($type==1 && $vcflagValue==1)
 {
 ?>
    <h2>IPO(VC) - Year on Year</h2>
<?php
 }
 elseif($type==2  && $vcflagValue==1)
 {
     ?>
     <h2>IPO(VC) - By Industry</h2>
 <?php
 }
 
  elseif($type==4 && $vcflagValue==1)
 {
     ?>
     <h2>IPO(VC)  - By Range</h2>
 <?php
 }
  elseif($type==5 && $vcflagValue==1)
 {
     ?>
     <h2>IPO(VC)  - By Investor</h2>
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