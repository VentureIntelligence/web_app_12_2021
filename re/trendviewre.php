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
                                    $companysql = "SELECT YEAR( pe.dates ) , COUNT(pe.PEId ) , COUNT( CASE WHEN hideamount=0 and pe.AggHide =0 THEN pe.PEId END), SUM(CASE WHEN pe.amount >0 AND pe.hideamount =0 and pe.AggHide =0 THEN  pe.amount END) 
                                                FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s
						 WHERE pe.IndustryId = i.industryid
						 AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
						 and pe.Deleted=0 and pec.industry=15 and dates between '".$startyear."' and '".$endyear."'
                                                GROUP BY YEAR( pe.dates )"  ;
                                    //echo  $companysql;
                                    $resultcompany= mysql_query($companysql);
                                }
                                elseif ($type==2) 
                                {
                                   $companysql = "SELECT i.industry,YEAR(pe.dates) , COUNT( pe.PEId) , SUM( CASE WHEN pe.amount >0 AND pe.hideamount =0 and pe.AggHide =0 THEN  pe.amount END) 
					FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s
						 WHERE pe.IndustryId = i.industryid
						 AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
						 and pe.Deleted=0 and pec.industry=15 and dates between '".$startyear."' and '".$endyear."'
                                                GROUP BY i.industry,YEAR(pe.dates)";
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
                                            $companysql = "SELECT YEAR( pe.dates ) , COUNT(pe.PEId ) , SUM(CASE WHEN pe.amount >0 AND pe.hideamount =0 and pe.AggHide =0 THEN  pe.amount END) 
                                            FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s
                                            WHERE pe.IndustryId = i.industryid
                                            AND pec.PEcompanyID = pe.PECompanyID and (pe.amount>200) and pe.StageId=s.RETypeId
                                            and pe.Deleted=0 and pec.industry=15 and dates between '".$startyear."' and '".$endyear."'
                                            GROUP BY YEAR( pe.dates )";
                                            //echo  $companysql;
                                             $resultcompany= mysql_query($companysql);
                                        }
                                        else
                                        {
                                            $limit=(string)$range[$r];
                                            $elimit=explode("-", $limit);
                                            
                                            $companysql = "SELECT YEAR( pe.dates ) , COUNT(pe.PEId ) , SUM(CASE WHEN pe.amount >0 AND pe.hideamount =0 and pe.AggHide =0 THEN  pe.amount END) 
                                            FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s
                                            WHERE pe.IndustryId = i.industryid AND pec.PEcompanyID = pe.PECompanyID 
                                            and  (pe.amount between ".$elimit[0]." and ".$elimit[1].")
                                            and pe.StageId=s.RETypeId and pe.Deleted=0 and pec.industry=15 and dates between '".$startyear."' and '".$endyear."'
                                            GROUP BY YEAR( pe.dates )";
                                            
                                           // echo  $companysql;
                                            $resultcompany= mysql_query($companysql);
                                        }
					$compRangeSql .= $companysql."#"; 					
                                     }
                                    $compRangeSql= urlencode($compRangeSql);
                                }
                                elseif($type==5)
                                {
                                    $companysql = "SELECT inv.InvestorTypeName,YEAR(pe.dates) , COUNT(pe.PEId) , SUM(CASE WHEN pe.amount >0 AND pe.hideamount =0 and pe.AggHide =0 THEN  pe.amount END) 
					FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,investortype as inv
						 WHERE pe.IndustryId = i.industryid
						 AND pec.PEcompanyID = pe.PECompanyID and pe.InvestorType=inv.InvestorType and pe.StageId=s.RETypeId
						 and pe.Deleted=0 and pec.industry=15 and dates between '".$startyear."' and '".$endyear."'
                                                GROUP BY inv.InvestorTypeName,YEAR(pe.dates) ";
                                    //echo  $companysql;
                                  $resultcompany= mysql_query($companysql);
                                }
                                elseif($type==6)
                                {
                                    $companysql  = "SELECT r.Region,YEAR(pe.dates) , COUNT(pe.PEId) , SUM(CASE WHEN pe.amount >0 AND pe.hideamount =0 and pe.AggHide =0 THEN  pe.amount END) 
                                                FROM REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r
						 WHERE pe.IndustryId = i.industryid and pe.RegionId=r.RegionId 
						 AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
						 and pe.Deleted=0 and pec.industry=15 and dates between '".$startyear."' and '".$endyear."'
                                                    GROUP BY r.Region,YEAR(pe.dates)";
                                    //echo  $companysql;
                                 
                                  $resultcompany= mysql_query($companysql);
                                }
			}
			else if($_POST)
                        {
                             // echo "post";
                              $dt1 =  $startyear;
                              $dt2 = $endyear;
                              $addVCFlagqry = " and pec.industry=15";
                            if($type != 4)
                            {
                                if($keyword != "" && $keyword != " ")
                                {
                                        $keybef=", REinvestors as peinv, REinvestments_investors as p_inv";
                                }
                                else if($searchallfield!="")
                                {
                                         $keybef=", REinvestors as peinv, REinvestments_investors as p_inv, REadvisorcompanies_advisorinvestors as reacai";
                                }
                                 else if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                {
                                        $albef2=" ,REadvisor_cias as cia , REinvestments_advisorcompanies as adac";
					$albef=" ,REadvisor_cias as cia , REinvestments_advisorinvestors as adac";
                                }
                                if($type==1)
                                {
                                    if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select year(dates),count(PEId),sum(amount)from (";
                                             $companysql= $companyadd."select pe.dates,pe.PEId,pe.amount from REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$albef." where";
                                            $companysql2 = "select pe.dates,pe.PEId,pe.amount from REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$albef2." where";
                                    }
                                    else {
                                        $companysql = "select year(pe.dates),count(pe.PEId), COUNT( DISTINCT CASE WHEN pe.hideamount =0 and pe.AggHide =0 THEN pe.PEId END) ,sum(CASE WHEN pe.amount >0 AND pe.hideamount =0 and pe.AggHide =0 THEN  pe.amount END)from REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$keybef." where";
                                    }
                                }
                                else if($type==2)
                                {
                                    if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select industry, year(dates), count(PEId), sum(amount)from (";
                                             $companysql= $companyadd."select i.industry, pe.dates,pe.PEId,pe.amount from REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$albef." where "; 
                                             $companysql2 = "select i.industry, pe.dates,pe.PEId,pe.amount from  REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$albef2." where "; 
                                    }
                                    else {
                                        $companysql = "select i.industry,year(pe.dates),count(pe.PEId),sum(CASE WHEN pe.amount >0 AND pe.hideamount =0 and pe.AggHide =0 THEN  pe.amount END)from REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$keybef." where "; 
                                    }
                                }
                                else if($type==5)
                                {
                                     if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select InvestorTypeName, year(dates), count(PEId), sum(amount)from (";
                                             $companysql= $companyadd."select inv.InvestorTypeName, pe.dates,pe.PEId,pe.amount from investortype as inv,REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$albef." where pe.InvestorType = inv.InvestorType and "; 
                                             $companysql2 = "select inv.InvestorTypeName, pe.dates,pe.PEId,pe.amount from investortype as inv,REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$albef2." where pe.InvestorType = inv.InvestorType and "; 
                                    }
                                    else {
                                        $companysql = "select inv.InvestorTypeName,year(pe.dates),count(pe.PEId),sum(CASE WHEN pe.amount >0 AND pe.hideamount =0 and pe.AggHide =0 THEN  pe.amount END)from REinvestments AS pe,investortype as inv, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$keybef." where pe.InvestorType = inv.InvestorType and "; 
                                    } 
                                }
                                else if($type==6)
                                {
                                     if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select Region, year(dates), count(PEId), sum(amount)from (";
                                             $companysql= $companyadd."select r.Region, pe.dates,pe.PEId,pe.amount from investortype as inv,REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$albef." where"; 
                                             $companysql2 = "select r.Region, pe.dates,pe.PEId,pe.amount from investortype as inv,REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$albef2." where"; 
                                    }
                                    else {
                                        $companysql = "select r.Region,year(pe.dates),count(pe.PEId),sum(CASE WHEN pe.amount >0 AND pe.hideamount =0 and pe.AggHide =0 THEN  pe.amount END)from REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$keybef." where "; 
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
                                        if ($regionId > 0)
                                        {
                                                $qryRegionTitle="Region - ";
                                                $whereregion = " pe.RegionId  =".$regionId;
                                        }
                                        if($companyType != "--" && $companyType != "")
                                        {
                                          $wherelisting_status=" pe.listing_status='".$companyType."'";
                                        }
                                        if($entityProject==1)
							$whereSPVCompanies=" pe.SPV=0";
						elseif($entityProject==2)
							$whereSPVCompanies=" pe.SPV=1";
                                        if($debt_equity != "--" && $debt_equity != "")
                                        {  
                                            $whereSPVdebt=" pe.SPV=".$debt_equity; 
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
                                                }
                                                $stageidvalue = implode($stageval,',');

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
                                                        $whererange = " pe.amount>=".$startRangeValue ." and pe.amount<". $endRangeValue ." and AggHide=0 and pe.hideamount=0 ";
                                                }
                                                elseif(($startRangeValue = $endRangeValue) )
                                                {
                                                        $whererange = " pe.amount >= ".$startRangeValue ." and AggHide=0 and pe.hideamount=0 ";
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
                                           $wheredates= " (pe.dates between '" . $dt1. "' and '" . $dt2 . "')";
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
                                        if($whereSPVCompanies!="")
                                        { $companysql=$companysql .$whereSPVCompanies ." and "; }
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
                                            if(isset($_POST['popup_select']) && $_POST['popup_select']=='investor'){
                                                $keyaft=" peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and (".$trend_inv_qry.")";                                                
                                            }else{
                                                $keyaft=" peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and p_inv.InvestorId IN ($keywordsearch)";
                                            }
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        else if($companysearch != "")
                                        {

                                            if(isset($_POST['popup_select']) && $_POST['popup_select']=='company'){
                                                $csaft=" (".$trend_com_qry.")";                                                
                                            }else{
                                                $csaft=" pec.PECompanyId IN ($companysearch) ";
                                            }
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                       else if($sectorsearch != "")
                                        {
                                            if(isset($_POST['popup_select']) && $_POST['popup_select']=='sector'){
                                                $ssaft=" (".$sector_filter.")";                                                
                                            }else{
                                                $ssaft=" sector_business IN ($sectorsearch)";
                                            }
                                                 $companysql=$companysql . $ssaft. " and ";
                                        }
                                        else if($searchallfield!="")
                                        {
                                                $companysql.=" peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and ( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
				OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '$searchallfield%' or peinv.investor like '$searchallfield%'   or (reacai.Cianame like '$searchallfield%'  and reacai.dates between '" . $dt1. "' and '" . $dt2 . "'  AND reacai.PEId=p_inv.PEId)) AND";
                                        }
                                        if(($wheredates !== "") )
                                        {
                                               
                                            $companysql = $companysql ." i.industryid= pe.IndustryId
                                             AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
                                             and pe.RegionId=r.RegionId and pe.Deleted=0 " . $addVCFlagqry . "  AND ".$wheredates ."";

                                            $companysql2 = $companysql2 ." i.industryid= pe.IndustryId
                                             AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
                                             and pec.RegionId=r.RegionId and pe.Deleted=0 " . $addVCFlagqry . "  AND ".$wheredates ."";
                                            $bool=true;
                                               
                                        }
                                        if($advisorsearchstring_legal!="")
                                        {
                                                $alaft=" and adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_legal%' and AdvisorType='L'";
                                                $companysql=$companysql . $alaft . "";
						$companysql2=$companysql2 . $alaft . "";
                                        }
                                        else if($advisorsearchstring_trans!="")
                                        {
                                                $ataft=" and adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_trans%' and AdvisorType='T'";
                                                $companysql=$companysql . $ataft . "";
						$companysql2=$companysql2 . $ataft . "";
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
                                                    $searchtype=" group by year(dates)";
                                            }
                                            else {
                                                    $searchtype=" group by year(pe.dates)";
                                            }                                                                
                                      }
                                        if($type == 2)
                                        {
                                           if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $searchtype=" group by industry, year(dates)";
                                            }
                                            else {
                                                    $searchtype=" group by i.industry,year(pe.dates)";
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
                                                    $searchtype=" group by r.Region, year(pe.dates)";
                                            }
                                        }
                                        if(($searchtype!== "") )
                                        {
                                                $companysql = $companysql .$searchtype;
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                   //echo $companysql;
                                         $resultcompany= mysql_query($companysql) or die(mysql_error());
                               }
                                                
                               else if($type == 4 && $_POST)
                                {
                                   
                                   	$compRangeSql = '';
                                       
                                     if (($startRangeValue == "--" || trim($startRangeValue) == "" ) && ($endRangeValue == "--" || trim($startRangeValue) == ""))
                                       {
                                         
                                            $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200");
                                       }
                                       else if (($startRangeValue!= "--" || trim($startRangeValue) != "") && ($endRangeValue != "--" || trim($startRangeValue) != ""))
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
                                    // print_r($range);
                                   for($r=0;$r<count($range);$r++)
                                    {
                                        if($keyword != "" && $keyword != " ")
                                        {
                                                $keybef=", REinvestors as peinv, REinvestments_investors as p_inv";
                                        }
                                        else if($searchallfield!="")
                                        {
                                                 $keybef=", REinvestors as peinv, REinvestments_investors as p_inv";
                                        }
                                         else if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                        {
                                                $albef2=" ,REadvisor_cias as cia , REinvestments_advisorcompanies as adac";
                                                $albef=" ,REadvisor_cias as cia , REinvestments_advisorinvestors as adac";
                                        }
                                        
                                        if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                        {
                                                 $companyadd = "select year(dates),count(PEId),sum(amount)from (";
                                                 $companysql= $companyadd."select pe.dates,pe.PEId,pe.amount from REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$albef." where";
                                                $companysql2 = "select pe.dates,pe.PEId,pe.amount from REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$albef2." where";
                                        }
                                        else {
                                            $companysql = "select year(pe.dates),count( pe.PEId),sum(CASE WHEN pe.amount >0 AND pe.hideamount =0 and pe.AggHide =0 THEN  pe.amount END)from REinvestments AS pe, reindustry AS i, REcompanies AS pec,realestatetypes as s,region as r ".$keybef." where";
                                        }
                                       
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
                                        if ($regionId > 0)
                                        {
                                                $qryRegionTitle="Region - ";
                                                $whereregion = " pe.RegionId  =".$regionId;
                                        }
                                        if($companyType != "--" && $companyType != "")
                                        {
                                          $wherelisting_status=" pe.listing_status='".$companyType."'";
                                        }
                                        if($entityProject==1)
							$whereSPVCompanies=" pe.SPV=0";
						elseif($entityProject==2)
							$whereSPVCompanies=" pe.SPV=1";
                                        if($debt_equity != "--" && $debt_equity != "")
                                        {  
                                            $whereSPVdebt=" pe.SPV=".$debt_equity; 
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
                                                $wheredates= "  dates between '" . $dt1. "' and '" . $dt2 . "'";
                                               
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
                                        if($whereSPVCompanies!="")
                                        { $companysql=$companysql .$whereSPVCompanies ." and "; }
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
                                       
                                         if($keyword != "")
                                        {
                                                $keyaft=" peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and peinv.investor LIKE '%$keyword%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        else if($companysearch != "")
                                        {

                                                $csaft=" pec.companyname LIKE '%$companysearch%'";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                       else if($sectorsearch != "")
                                        {
                                                $ssaft=" ( sector_business LIKE '%$sectorsearch%' )";
                                                 $companysql=$companysql . $ssaft. " and ";
                                        }
                                       else if($searchallfield!="")
                                        {
                                                $companysql.=" peinv.InvestorId = p_inv.InvestorId AND pe.PEId = p_inv.PEId and ( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
				OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '$searchallfield%' or peinv.investor like '$searchallfield%') AND";
                                        }
                                        if(($wheredates !== "") )
                                        {
                                                $companysql = $companysql ." i.industryid= pe.IndustryId
						 AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
						 and r.RegionId=pe.RegionId and pe.Deleted=0 " . $addVCFlagqry . "  AND ".$wheredates ."";
												 
						$companysql2 = $companysql2 ." i.industryid= pe.IndustryId
						 AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.RETypeId
						 and r.RegionId=pec.RegionId and pe.Deleted=0 " . $addVCFlagqry . "  AND ".$wheredates ."";
                                                $bool=true;
                                        }
                                        if($advisorsearchstring_legal!="")
                                        {
                                                $alaft=" and adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_legal%' and AdvisorType='L'";
                                                $companysql=$companysql . $alaft . "";
						$companysql2=$companysql2 . $alaft . "";
                                        }
                                        else if($advisorsearchstring_trans!="")
                                        {
                                                $ataft=" and adac.CIAId = cia.CIAId AND adac.PEId = pe.PEId AND cia.cianame LIKE '%$advisorsearchstring_trans%' and AdvisorType='T'";
                                                $companysql=$companysql . $ataft . "";
						$companysql2=$companysql2 . $ataft . "";
                                        }
                                       
					if($advisorsearchstring_legal!="")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        if($advisorsearchstring_trans!="")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        if($type == 4)
                                        {
                                            if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
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
					//echo "<br><br>".$companysql;
                                     }
                                    $compRangeSql = urlencode($compRangeSql);
                                }
                               
                        }	else
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
<div sytle="padding:20px">		
<div id="sec-header">
 <table cellpadding="0" cellspacing="0">
 <tr>
<td>
<h3>Types</h3>
<label><input class="typeoff-nav2" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/> Year On year</label>
<label><input class="typeoff-nav2" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />Industry</label>
<!--label><input class="typeoff-nav2" name="typeoff" type="radio"  value="3" <?php if($type==3) { ?> checked="checked" <?php } ?>/>Stage</label-->
<label><input class="typeoff-nav2" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
<label><input class="typeoff-nav2" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>Investor Type</label>
<label><input class="typeoff-nav2" name="typeoff" type="radio" value="6" <?php if($type==6) { ?> checked="checked" <?php } ?>/>Region</label>

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