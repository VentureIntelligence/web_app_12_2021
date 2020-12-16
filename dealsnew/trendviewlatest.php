<?php
if($vcflagValue==0)
        {
            $addVCFlagqry = " and pec.industry !=15 ";
            $checkForStage = ' && ('.'$stage'.' =="--")';
            //$checkForStage = " && (" .'$stage'."=='--') ";
            $checkForStageValue = " || (" .'$stage'.">0) ";
            $searchTitle = "List of PE Investments ";
            $searchAggTitle = "Aggregate Data - PE Investments ";
            $aggsql= "select count(PEId) as totaldeals,sum(amount) as totalamount from peinvestments as pe,
            pecompanies as pec,industry as i where ";
            $samplexls="../xls/Sample_Sheet_Investments.xls";
        }
        elseif($vcflagValue==1)
        {
            $addVCFlagqry = " and pec.industry!=15  and s.VCview=1 and pe.amount <=20 ";

            $checkForStage = '&& ('.'$stage'.'=="--") ';
            //$checkForStage = " && (" .'$stage'."=='--') ";
            $checkForStageValue =  " || (" .'$stage'.">0) ";
            $searchTitle = "List of VC Investments ";
            $searchAggTitle = "Aggregate Data - VC Investments ";
            $aggsql= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
            FROM peinvestments AS pe,pecompanies as pec,industry as i,stage as s  where pe.StageID=s.StageId and s.VCView=1 and  " ;
            $samplexls="Sample_Sheet_Investments(VC Deals).xls";
            //	echo "<br>Check for stage** - " .$checkForStage;
        }
           // print_r($_POST);
                        if(!$_POST){
                            //echo "not post";
				$yourquery=0;
				$stagevaluetext="";
				$industry=0;
                                //echo "<br>Query for all records";
                                 if($type==1)
                                { 
                                    $companysql = "SELECT  t1.yr,count(t1.PEId), sum(t1.amount) from (SELECT distinct pe.PEId, YEAR( pe.dates ) as yr , pe.amount FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s WHERE i.industryid = pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId = s.StageId AND pe.Deleted =0 " .$addVCFlagqry. " AND pe.amount!=0 and pe.AggHide =0 AND pe.SPV=0 and dates between '".$startyear."' and '".$endyear."' AND pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1) )  as t1 group by t1.yr"  ;
                                    //echo  $companysql;
                                    
                                    //$resultcompany= mysql_query($companysql);
                                }
                                elseif ($type==2) 
                                {
                                   $companysql = "SELECT i.industry,YEAR(pe.dates) , COUNT(distinct pe.PEId) , SUM(pe.amount) from peinvestments as pe, industry as i,pecompanies as pec,stage as s where i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and pe.StageId = s.StageId and  pe.Deleted = 0 " .$addVCFlagqry. " and pe.amount!=0 AND pe.AggHide = 0 AND pe.SPV=0 and  dates between '".$startyear."' and '".$endyear."' AND pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1) GROUP BY i.industry,YEAR(pe.dates) order by YEAR(pe.dates) asc";
                                 //echo  $companysql;
                                          
                                   //$resultcompany= mysql_query($companysql);
                                }
                                elseif($type==3)
                                {
                                   $companysql = "SELECT s.Stage,YEAR(pe.dates) , COUNT(distinct pe.PEId) , SUM(pe.amount) from peinvestments as pe, industry as i,pecompanies as pec,stage as s where i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and pe.StageId = s.StageId and  pe.Deleted = 0 " .$addVCFlagqry. " and pe.amount!=0 AND pe.AggHide = 0 AND pe.SPV=0 and  dates between '".$startyear."' and '".$endyear."' AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1) GROUP BY s.Stage,YEAR(pe.dates) ";   
                                   //echo  $companysql;
                                   //$resultcompany= mysql_query($companysql);
                                }
                                
                                else if($type ==4)
                                {
                                    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200+");
                                    for($r=0;$r<count($range);$r++)
                                    {
                                        if($r == count($range)-1)
                                        {
                                            $companysql = "SELECT  t1.yr,count(t1.PEId), sum(t1.amount) from (SELECT distinct pe.PEId, YEAR( pe.dates ) as yr , pe.amount  FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s WHERE i.industryid = pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId = s.StageId and  (pe.amount > 200) AND pe.Deleted =0 " .$addVCFlagqry. " AND pe.AggHide =0 and pe.amount!=0 AND pe.SPV=0 and dates between '".$startyear."' and '".$endyear."' AND pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1) )  as t1   group by t1.yr";
                                            //echo  $companysql;
                                             //$resultcompany= mysql_query($companysql);
                                        }
                                        else
                                        {
                                            $limit=(string)$range[$r];
                                            $elimit=explode("-", $limit);
                                            
                                            $companysql = "SELECT  t1.yr,count(t1.PEId), sum(t1.amount) from (SELECT distinct pe.PEId, YEAR( pe.dates ) as yr , pe.amount  FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s WHERE i.industryid = pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId = s.StageId and  (pe.amount > ".$elimit[0]." and pe.amount<= ".$elimit[1].") AND pe.Deleted =0" .$addVCFlagqry. " and pe.amount!=0 AND pe.AggHide =0 AND pe.SPV=0 and dates between '".$startyear."' and '".$endyear."' AND pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1))  as t1   group by t1.yr";
                                           // echo  $companysql;
                                            //$resultcompany= mysql_query($companysql);
                                        }
                                        if(mysql_num_rows($resultcompany)>0)
                                        {
                                            while ($rowrange = mysql_fetch_array($resultcompany))
                                            {
                                                $deal[$range[$r]][$rowrange[0]]['dealcount']=$rowrange[1];
                                                $deal[$range[$r]][$rowrange[0]]['sumamount']=$rowrange[2];   
                                            }
                                        }
                                        /*else
                                        {
                                            $deal='';
                                        }*/
                                     }
                                }
                                elseif($type==5)
                                {
                                    $companysql = "SELECT inv.InvestorTypeName,YEAR(pe.dates) , COUNT(distinct pe.PEId) , SUM(pe.amount) from peinvestments as pe, industry as i,pecompanies as pec,stage as s,investortype as inv where i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and pe.StageId = s.StageId and  pe.Deleted = 0 " .$addVCFlagqry. " and pe.amount!=0 AND pe.AggHide = 0 AND pe.SPV=0 and pe.InvestorType=inv.InvestorType and  dates between '".$startyear."' and '".$endyear."' AND pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1) GROUP BY inv.InvestorTypeName,YEAR(pe.dates) ";
                                   // echo  $companysql;
                                  //$resultcompany= mysql_query($companysql);
                                }
                                elseif($type==6)
                                {
                                    $companysql  = "SELECT r.Region,YEAR(pe.dates) , COUNT(distinct pe.PEId) , SUM(distinct pe.amount) from peinvestments as pe, industry as i,pecompanies as pec,stage as s,investortype as inv, region as r where i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and  r.RegionId=pec.RegionId and pe.StageId = s.StageId and  pe.Deleted = 0 " .$addVCFlagqry. " and pe.amount!=0 AND pe.AggHide = 0 AND pe.SPV=0 and pe.InvestorType=inv.InvestorType and dates between '".$startyear."' and '".$endyear."' AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1) GROUP BY r.Region,YEAR(pe.dates)";
                                    //echo  $companysql;
                                    //echo "<br>all records" .$companysql;
                                  //$resultcompany= mysql_query($companysql);
                                }
			//	     echo "<br>all records" .$companysql;
			}
			else if($_POST)
                        {
                             //echo "post ---------------"; exit;
                              $dt1 =  $startyear;
                              $dt2 = $endyear;
                            if($type != 4)
                            {
                                //echo $keyword.'----';
                               // if($keyword != "" && $keyword != " ")
                               // {
                                        $keybef=", peinvestors as peinv, peinvestments_investors as p_inv";
                               // }
                                  if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                {
                                        $albef2=" ,advisor_cias as cia , peinvestments_advisorcompanies as adac";
										$albef=" ,advisor_cias as cia , peinvestments_advisorinvestors as adac";
                                }
                                if($type==1)
                                {
                                    if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select year(dates),count(distinct PEId),sum(amount)from (";
                                             $companysql= $companyadd."select pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef." where";
                                            $companysql2 = "select pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef2." where";
                                    }
                                    else {
                                        $companysql = "SELECT  t1.yr,count(t1.PEId), sum(t1.amount) from (SELECT distinct pe.PEId, YEAR( pe.dates ) as yr , pe.amount  from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$keybef." where";
                                    }
                                    //echo $companysql; exit;
                                }
                                else if($type==2)
                                {
                                    if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select industry, year(dates), count(distinct PEId), sum(amount)from (";
                                             $companysql= $companyadd."select i.industry, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef." where pec.industry = i.industryid and "; 
                                             $companysql2 = "select i.industry, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef2." where pec.industry = i.industryid and "; 
                                    }
                                    else {
                                        $companysql = "select i.industry,year(pe.dates),count(distinct pe.PEId),sum(pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$keybef." where pec.industry = i.industryid and "; 
                                    }
                                }
                                else if($type==3)
                                {
                                     if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select Stage, year(dates), count(distinct PEId), sum(amount)from (";
                                             $companysql= $companyadd."select s.Stage, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef." where pe.StageId = s.StageId and "; 
                                             $companysql2 = "select s.Stage, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef2." where pe.StageId = s.StageId and "; 
                                    }
                                    else {
                                        $companysql = "select s.Stage,year(pe.dates),count(distinct pe.PEId),sum(pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$keybef." where pe.StageId = s.StageId and "; 
                                    } 
                                }
                                else if($type==5)
                                {
                                     if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select InvestorTypeName, year(dates), count(distinct PEId), sum(amount)from (";
                                             $companysql= $companyadd."select inv.InvestorTypeName, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,investortype as inv,pecompanies as pec,stage as s ".$albef." where pe.InvestorType = inv.InvestorType and "; 
                                             $companysql2 = "select inv.InvestorTypeName, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,investortype as inv,pecompanies as pec,stage as s ".$albef2." where pe.InvestorType = inv.InvestorType and "; 
                                    }
                                    else {
                                        $companysql = "select inv.InvestorTypeName,year(pe.dates),count(distinct pe.PEId),sum(pe.amount)from peinvestments as pe, industry as i,investortype as inv,pecompanies as pec,stage as s ".$keybef." where pe.InvestorType = inv.InvestorType and "; 
                                    } 
                                }
                                else if($type==6)
                                {
                                     if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select Region, year(dates), count(distinct PEId), sum(distinct amount)from (";
                                             $companysql= $companyadd."select re.Region, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,investortype as inv,region as re,pecompanies as pec,stage as s ".$albef." where pec.RegionId=re.RegionId and"; 
                                             $companysql2 = "select re.Region, pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,investortype as inv,region as re,pecompanies as pec,stage as s ".$albef2." where pec.RegionId=re.RegionId and"; 
                                    }
                                    else {
                                        $companysql = "select re.Region,year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,investortype as inv,region as re,pecompanies as pec,stage as s ".$keybef." where  pec.RegionId=re.RegionId and"; 
                                    } 
                               }
                            
				//echo "<br> individual where clauses have to be merged ";
					if ($industry > 0)
                                        {
                                                $whereind = " pec.industry=" .$industry ;
                                                $qryIndTitle="Industry - ";
                                        }
                                        if ($regionId > 0)
                                        {
                                                $qryRegionTitle="Region - ";
                                                $whereregion = " pec.RegionId  =".$regionId;
                                        }
                                        if($companyType != "--" && $companyType != "")
                                        {
                                          $wherelisting_status=" pe.listing_status='".$companyType."'";
                                        }
                                        if($debt_equity != "--" && $debt_equity != "")
                                        {  
                                            $whereSPVdebt=" pe.SPV=".$debt_equity; 
                                        }
                                        else
                                        {
                                            $whereSPVdebt=" pe.SPV=0"; 
                                        }
                                        if ($invType != "--" && $invType != "")
                                        {
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pe.InvestorType = '".$invType."'";
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
                                       
                                //	echo "<br>Where stge---" .$wherestage;
                                        if (($startRangeValue!= "--") && ($endRangeValue != "--")  && ($startRangeValue!= "") && ($endRangeValue != "")  )
                                        {
                                                $startRangeValue=$startRangeValue;
                                                $endRangeValue=$endRangeValue-0.01;
                                                $qryRangeTitle="Deal Range (M$) - ";
                                                if($startRangeValue < $endRangeValue)
                                                {
                                                        $whererange = " pe.amount >  ".$startRangeValue ." and  pe.amount <= ". $endRangeValue ." and AggHide=0";
                                                }
                                                elseif(($startRangeValue = $endRangeValue) )
                                                {
                                                        $whererange = " pe.amount >= ".$startRangeValue ." and AggHide=0";
                                                }
                                        }
                                        else
                                        {
                                             $whererange ="";
                                        }
                                       
                                        //echo "<Br>***".$whererange;
                              
                                        if( ($dt1 != "")  && ($dt2 != ""))
                                        {
                                           $qryDateTitle ="Period - ";
                                           $wheredates= " (dates between '".$dt1."' and '".$dt2."')";
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
                                        if (($whereregion != "") )
                                        {
                                //		echo "<br>TRUE";
                                        $companysql=$companysql . $whereregion . " and " ;
                                                $aggsql=$aggsql . $whereregion ." and ";
                                //	echo "<br>----comp sql after region-- " .$companysql;
                                        $bool=true;
                                        }
                                        if (($wherestage != ""))
                                        {
                                        //	echo "<BR>--STAGE" ;
                                                $companysql=$companysql . $wherestage . " and " ;
                                                $aggsql=$aggsql . $wherestage ." and ";
                                                $bool=true;
                                        //	echo "<br>----comp sql after stage-- " .$companysql;

                                        }
                                        if($wherelisting_status!="")
                                        {
                                         $companysql=$companysql .$wherelisting_status . " and ";
                                        }
                                        if($whereSPVdebt!="")
                                        { $companysql=$companysql .$whereSPVdebt ." and "; }
                                        if (($whereInvType != "") )
                                        {
                                                $companysql=$companysql .$whereInvType . " and ";
                                                $aggsql = $aggsql . $whereInvType ." and ";
                                                $bool=true;
                                        }
                                        if (($whererange != "") )
                                        {
                                                $companysql=$companysql .$whererange . " and ";
                                                $aggsql=$aggsql .$whererange . " and ";
                                                $bool=true;
                                        }
                                       
                                         if($keyword != "")
                                        {
                                                $keyaft=" peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and peinv.InvestorId IN ($keyword)";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        else if($companysearch != "")
                                        {

                                                $csaft=" pec.PECompanyId IN ($companysearch) ";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                       else if($sectorsearch != "")
                                        {
                                            $sectorsearchArray = explode(",", str_replace("'","",$sectorsearch)); 
                                            $sector_sql = array(); // Stop errors when $words is empty

                                            foreach($sectorsearchArray as $word){
                                                $word = trim($word);
                //                                $sector_sql[] = " sector_business LIKE '$word%' ";
                                                                $sector_sql[] = " sector_business = '$word' ";
                                                                $sector_sql[] = " sector_business LIKE '$word(%' ";
                                                                $sector_sql[] = " sector_business LIKE '$word (%' ";
                                            }
                                            $sector_filter = implode(" OR ", $sector_sql);
                                                $ssaft=" peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and ($sector_filter) ";
                                                 $companysql=$companysql . $ssaft. " and ";
                                        }
                                        else if($searchallfield!="")
                                        {
                                            
                                            $findTag = strpos($searchallfield,'tag:');
                                            $findTags = "$findTag";
                                            if($findTags == ''){
                                                $tagsval = "pec.city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'	OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or peinv.Investor LIKE '$searchallfield%'";                                    
                                            }else{
                                                $tags = '';
                                                $ex_tags = explode(',',$searchallfield);
                                                if(count($ex_tags) > 0){
                                                    for($l=0;$l<count($ex_tags);$l++){
                                                        if($ex_tags[$l] !=''){
                                                            $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                            $tags .= "pec.tags like '%:$value%' or ";
                                        }
                                                    }
                                                }
                                                $tagsval = trim($tags,' or ');
                                            }
                                            
                                                $companysql.="peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and ( $tagsval ) AND";
                                        }
                                        if(($wheredates !== "") )
                                        {
                                                $companysql = $companysql ." pe.Deleted=0 AND pe.AggHide =0 and pe.amount!=0 and pec.industry = i.industryid and pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId " . $addVCFlagqry . "  AND ".$wheredates ." and ";
												 
						$companysql2 = $companysql2 ." pe.Deleted=0 AND pe.AggHide =0 and pe.amount!=0 AND  pec.industry = i.industryid and pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId " . $addVCFlagqry . "  AND ".$wheredates ." and ";
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                        if($advisorsearchstring_legal!="")
                                        {
                                                $alaft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_legal%' and AdvisorType='L'";
                                                $companysql=$companysql . $alaft . " and ";
						$companysql2=$companysql2 . $alaft . " and ";
                                        }
                                        else if($advisorsearchstring_trans!="")
                                        {
                                                $ataft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_trans%' and AdvisorType='T'";
                                                $companysql=$companysql . $ataft . " and ";
						$companysql2=$companysql2 . $ataft . " and ";
                                        }
                                        //the foll if was previously checked for range// pe.AggHide = 0 AND pe.SPV=0
                                        if($whererange  !="")
                                        {
                                                $companysql = $companysql . " pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1)";
												$companysql2 = $companysql . " pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1)";
                                        //	echo "<br>----" .$whererange;
                                        }
                                        elseif($whererange == "")
                                        {
                                                $companysql = $companysql . "pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1)";
												$companysql2 = $companysql2 . "pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE  hide_pevc_flag =1)";
                                        //	echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
                                        }
                                       
                                       
					if($advisorsearchstring_legal!="")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        if($advisorsearchstring_trans!="")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                         if($type == 1)
                                        {
                                            if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                   // $searchtype=" )  as t1   group by t1.yr";
                                            }
                                            else {
                                                    $searchtype=" )  as t1   group by t1.yr";
                                            }                                                                
                                      }
                                        if($type == 2)
                                        {
                                           if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $searchtype=" group by industry, year(dates) order by year(dates) desc,industry asc";
                                            }
                                            else {
                                                    $searchtype=" group by i.industry,year(pe.dates) order by year(dates) desc,industry asc";
                                            }
                                        }
                                        if($type == 3)
                                        {
                                            if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $searchtype=" group by Stage, year(dates)";
                                            }
                                            else {
                                                    $searchtype=" group by s.Stage, year(pe.dates)";
                                            }
                                          
                                        }
                                        if($type == 5)
                                        {
                                            if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $searchtype=" group by  InvestorTypeName, year(dates)";
                                            }
                                            else {
                                                    $searchtype=" group by inv.InvestorTypeName, year(pe.dates)";
                                            }
                                        }
                                        if($type == 6)
                                        {
                                            if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $searchtype=" group by Region, year(dates)";
                                            }
                                            else {
                                                    $searchtype=" group by re.Region, year(pe.dates)";
                                            }
                                        }
                                        if(($searchtype!== "") )
                                        {
                                                $companysql = $companysql .$searchtype;
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                  // echo $companysql;
                                        // $resultcompany= mysql_query($companysql) or die(mysql_error());
                               }
                                                
                               else if($type == 4 && $_POST)
                                {
                                   
                                     if (($startRangeValue == "--") && ($endRangeValue == "--"))
                                       {
                                            $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200");
                                       }
                                       else if (($startRangeValue!= "--") && ($endRangeValue != "--"))
                                       {
                                            $startFlag=0;$endFlag=0;
                                            $arr_range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200");
                                            $range = array();
                                            foreach($arr_range as $value)
                                            {
                                                $arr_srange= spliti('-', $value);
                                                
                                                if($startFlag == 0 || $endFlag == 0)
                                                {
                                                    if(($arr_srange[0] >= $startRangeValue))
                                                    { 
                                                        if ($startFlag == 0){
                                                            $finalsrange = $startRangeValue;
                                                            $startFlag = 1;
                                                        }else{
                                                            $finalsrange = $arr_srange[0];
                                                        }
                                                    }
                                                    
                                                    
                                                    //echo $arr_srange[1];
                                                    if( $startFlag == 1)
                                                    {
                                                        if($endRangeValue >= $arr_srange[1])
                                                        {
                                                            if($endFlag == 0)
                                                            {
                                                                $finalerange = $arr_srange[1];
                                                                
                                                            }
                                                            else
                                                            {
                                                                 $finalerange = $endRangeValue;
                                                                 
                                                            }
                                                        }else{
                                                            $finalerange = $endRangeValue;
                                                            $endFlag=1;
                                                        }
                                                    }
                                                     //echo $finalsrange."-".$finalerange."</br>";
                                                    
                                                   if($finalsrange !='' && $finalerange!='')
                                                   {
                                                        $comserange="$finalsrange"."-"."$finalerange";
                                                        array_push($range, $comserange);
                                                   }
                                                }
                                            }
                                       }     
                                     //print_r($range);
								   $compRangeSql = '';
                                   for($r=0;$r<count($range);$r++)
                                    {
                                          if($keyword != "" && $keyword != " ")
                                            {
                                                    $keybef=", peinvestors as peinv, peinvestments_investors as p_inv";
                                            }
                                          else if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $albef=" ,advisor_cias as cia , peinvestments_advisorinvestors as adac";
                                                    $albef2=" ,advisor_cias as cia , peinvestments_advisorcompanies as adac";
                                            }
                              
                                        if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                        {
                                                $companyadd = "select year(dates),count(distinct PEId),sum(amount)from (";
                                                $companysql= $companyadd."select pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef." where";
                                                $companysql2 = "select pe.dates,pe.PEId,pe.amount from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$albef2." where";
                                        }
                                        else {
                                            $companysql = "select year(pe.dates),count(distinct pe.PEId),sum(pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$keybef." where";
                                        }
                                        if ($industry > 0)
                                        {
                                                $whereind = " pec.industry=" .$industry ;
                                                $qryIndTitle="Industry - ";
                                        }
                                        if ($regionId > 0)
                                        {
                                                $qryRegionTitle="Region - ";
                                                $whereregion = " pec.RegionId  =".$regionId;
                                        }
                                        if($companyType != "--" && $companyType != "")
                                        {
                                          $wherelisting_status="pe.listing_status='".$companyType."'";
                                        }
                                        if($debt_equity != "--" && $debt_equity != "")
                                        {  
                                            $whereSPVdebt=" pe.SPV=".$debt_equity; 
                                        }
                                        if ($invType != "--" && $invType != "")
                                        {
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pe.InvestorType = '".$investorType."'";
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
                                        $limit=(string)$range[$r];
                                        $elimit=explode("-", $limit);
                                        if( $elimit[0] !='' && $elimit[1] !='' && $elimit[0] != $elimit[1])
                                        {
                                           $whererange = " pe.amount >  ".$elimit[0] ." and pe.amount <= ". $elimit[1] ." "; 
                                        }
                                        else if($elimit[0] >= 200 || $elimit[1] >= 200)
                                        {
                                            $whererange = " pe.amount > 200";
                                        }
                                        else
                                        {
                                             $whererange="";
                                        }

                              
                                        if( ($dt1 != "")  && ($dt2 != ""))
                                        {
                                            $qryDateTitle ="Period - ";
                                            if($type == 4)
                                            {
                                                $wheredates= "  dates between '".$dt1."' and '".$dt2."'";
                                               
                                            }
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
                                        if (($whereregion != "") )
                                        {
                                //		echo "<br>TRUE";
                                        $companysql=$companysql . $whereregion . " and " ;
                                                $aggsql=$aggsql . $whereregion ." and ";
                                //	echo "<br>----comp sql after region-- " .$companysql;
                                        $bool=true;
                                        }
                                        if (($wherestage != ""))
                                        {
                                        //	echo "<BR>--STAGE" ;
                                                $companysql=$companysql . $wherestage . " and " ;
                                                $aggsql=$aggsql . $wherestage ." and ";
                                                $bool=true;
                                        //	echo "<br>----comp sql after stage-- " .$companysql;

                                        }
                                        if($wherelisting_status!="")
                                        {
                                         $companysql=$companysql .$wherelisting_status . " and ";
                                        }
                                        if($whereSPVdebt!="")
                                        { $companysql=$companysql .$whereSPVdebt ." and "; }
                                        if (($whereInvType != "") )
                                        {
                                                $companysql=$companysql .$whereInvType . " and ";
                                                $aggsql = $aggsql . $whereInvType ." and ";
                                                $bool=true;
                                        }
                                        if (($whererange != "") )
                                        {
                                                $companysql=$companysql .$whererange . " and ";
												$companysql2=$companysql2 .$whererange . " and ";
                                                $aggsql=$aggsql .$whererange . " and ";
                                                $bool=true;
                                        }
                                         if($keyword != "" && $keyword != " ")
                                        {
                                                $keyaft=" peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and peinv.InvestorId IN ($keyword) ";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        else if($companysearch != "" && $companysearch != " ")
                                        {

                                                $csaft=" pec.PECompanyId IN ($companysearch) ";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                        else if($sectorsearch != "")
                                        {
                                                $ssaft=" peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and ( sector_business IN ($sectorsearch) )";
                                                 $companysql=$companysql . $ssaft. " and ";
                                        }
                                        else if($advisorsearchstring_legal!="" && $advisorsearchstring_legal!=" ")
                                        {
                                                $alaft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_legal%' and AdvisorType='L'";
                                                $companysql=$companysql . $alaft . " and ";
												$companysql2=$companysql2 . $alaft . " and ";
                                        }
                                        else if($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" ")
                                        {
                                                $ataft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_trans%' and AdvisorType='T'";
                                                $companysql=$companysql . $ataft . " and ";
												$companysql2=$companysql2 . $ataft . " and ";
                                        }
                                        else if($searchallfield!="")
                                        {
                                                $companysql.="peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and ( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'	OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or peinv.Investor LIKE '$searchallfield%' ) AND";

                                                
                                        }
                                        //the foll if was previously checked for range
                                      
                                        if(($wheredates != "") )
                                        {
                                                $companysql = $companysql ." i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pe.Deleted=0 " . $addVCFlagqry . "  AND ".$wheredates ." and ";
                                                $aggsql = $aggsql . $wheredates ." and  ";
												
						$companysql2 = $companysql2 ." i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId and pe.Deleted=0 " . $addVCFlagqry . "  AND ".$wheredates ." and ";
                                                $aggsql = $aggsql . $wheredates ." and  ";
                                                $bool=true;
                                        }
                                        //the foll if was previously checked for range
                                        if($whererange  !="")
                                        {
                                                $companysql = $companysql . " pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1)";
												$companysql2 = $companysql2 . " pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1)";
                                        //	echo "<br>----" .$whererange;
                                        }
                                        elseif($whererange == "")
                                        {
                                                $companysql = $companysql . " pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1)";
												$companysql2 = $companysql2 . " pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE hide_pevc_flag =1)";
                                        //	echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
                                        }
                                       
                                        if($advisorsearchstring_legal!="" && $advisorsearchstring_legal!=" ")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
					if($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" ")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        if($type == 4)
                                        {
                                            if(($advisorsearchstring_legal!="" && $advisorsearchstring_legal!=" ") || ($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" "))
                                            {
                                                    $searchtype=" group by year(dates)";
                                            }
                                            else {
                                                    $searchtype=" group by year(pe.dates)";
                                            }
                                        }
                                         if(($searchtype!== "") )
                                        {
                                                $companysql = $companysql .$searchtype;
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
										
                                        $compRangeSql .= $companysql."#";
										
                                         
                                     }
                                }
                               
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
	
	$TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm	where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
	
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

	$getcompaniesSql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region	FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s WHERE pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15	AND r.RegionId = pec.RegionId " .$addVCFlagqry. " ORDER BY pec.companyname";
	
	//Stage
	$stagesql = "select StageId,Stage from stage ";
?>
<div>
<table cellpadding="0" cellspacing="0" width="100%" >
	<tr>
		<td>
			<div style="padding:20px;">
            <?php
				if($vcflagValue==0){
			?>
				<div id="sec-header">
			 		<table cellpadding="0" cellspacing="0">
			 			<tr>
							<td>
                                <h3>Types</h3>
                                <label><input class="typeoff-nav2" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
                                <label><input class="typeoff-nav2" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
                                <label><input class="typeoff-nav2" name="typeoff" type="radio"  value="3" <?php if($type==3) { ?> checked="checked" <?php } ?>/>Stage</label>
                                <label><input class="typeoff-nav2" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
                                <label><input class="typeoff-nav2" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
                                <label><input class="typeoff-nav2" name="typeoff" type="radio" value="6" <?php if($type==6) { ?> checked="checked" <?php } ?>/>Region</label>
							</td>
                        </tr>
				    </table>
				</div>
			<?php
			}else if($vcflagValue==1){
			?>
				<div id="sec-header">
			 		<table cellpadding="0" cellspacing="0">
			 			<tr>
							<td>
                                <h3>Types</h3>
                                <label><input class="typeoff-nav21" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
                                <label><input class="typeoff-nav21" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
                                <label><input class="typeoff-nav21" name="typeoff" type="radio"  value="3" <?php if($type==3) { ?> checked="checked" <?php } ?>/>Stage</label>
                                <label><input class="typeoff-nav21" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
                                <label><input class="typeoff-nav21" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
                                <label><input class="typeoff-nav21" name="typeoff" type="radio" value="6" <?php if($type==6) { ?> checked="checked" <?php } ?>/>Region</label>
							</td>
						</tr>
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
                    <h2>PE - Year on Year</h2>
                <?php
                 }
                 elseif($type==2 && $vcflagValue==0)
                 {
                ?>
                     <h2>PE - By Industry</h2>
                <?php
                 }
                  elseif($type==3  && $vcflagValue==0)
                 {
                 ?>
                     <h2>PE - By Stage</h2>
                 <?php
                 }
                  elseif($type==4  && $vcflagValue==0)
                 {
                     ?>
                     <h2>PE - By Range</h2>
                 <?php
                 }
                  elseif($type==5  && $vcflagValue==0)
                 {
                     ?>
                     <h2>PE - By Investor</h2>
                 <?php
                 } elseif($type==6  && $vcflagValue==0)
                 {
                     ?>
                     <h2>PE - By Region</h2>
                 <?php
                 }
                 else  if($type==1 && $vcflagValue==1)
                 {
                 ?>
                    <h2>VC - Year on Year</h2>
                <?php
                 }
                 elseif($type==2 && $vcflagValue==1)
                 {
                     ?>
                     <h2>VC - By Industry</h2>
                 <?php
                 }
                  elseif($type==3  && $vcflagValue==1)
                 {
                     ?>
                     <h2>VC - By Stage</h2>
                 <?php
                 }
                  elseif($type==4  && $vcflagValue==1)
                 {
                     ?>
                     <h2>VC - By Range</h2>
                 <?php
                 }
                  elseif($type==5  && $vcflagValue==1)
                 {
                     ?>
                     <h2>VC - By Investor</h2>
                 <?php
                 } elseif($type==6  && $vcflagValue==1)
                 {
                     ?>
                     <h2>VC - By Region</h2>
                 <?php
                 }
                 ?>
            </div><br>
		</td>
	</tr>
</table>
<div class=""></div>
