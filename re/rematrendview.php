<?php
           //print_r($_POST);
                if(!$_POST){
                            //echo "not post";
				$yourquery=0;
				$stagevaluetext="";
				$industry=0;
                                //echo "<br>Query for all records";
                                if($type==1)
                                { 
                                    $companysql = "SELECT YEAR(pe.DealDate) , COUNT(pe.MAMAId) , SUM(pe.Amount)
                                                FROM REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac
                                            WHERE  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry=15 and ac.AcquirerId=pe.AcquirerId 
                                            and DealDate between '".$startyear."' and '".$endyear."' GROUP BY YEAR(pe.DealDate)";
                                    //echo  $companysql;
                                    $resultcompany= mysql_query($companysql);
                                }
                                elseif ($type==2) 
                                {
                                   $companysql = "SELECT i.industry,YEAR(pe.DealDate) , COUNT(pe.MAMAId) , SUM(pe.Amount)
                                                FROM REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac
                                            WHERE  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry=15 and ac.AcquirerId=pe.AcquirerId 
                                            and DealDate between '".$startyear."' and '".$endyear."' GROUP BY i.industry,YEAR(pe.DealDate) ";
                                 //echo  $companysql;
                                          
                                   $resultcompany= mysql_query($companysql);
                                }
                                else if($type ==4)
                                {
                                    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200+");
                                    for($r=0;$r<count($range);$r++)
                                    {
                                        if($r == count($range)-1)
                                        {
                                            $companysql = "SELECT YEAR(pe.DealDate) , COUNT(pe.MAMAId) , SUM(pe.Amount)
                                                FROM REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac
                                            WHERE  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry=15 and ac.AcquirerId=pe.AcquirerId 
                                            and DealDate between '".$startyear."' and '".$endyear."' and (pe.Amount > 200) GROUP BY YEAR(pe.DealDate)";
                                           // echo  $companysql;
                                             $resultcompany= mysql_query($companysql);
                                        }
                                        else
                                        {
                                            $limit=(string)$range[$r];
                                            $elimit=explode("-", $limit);
                                            
                                            $companysql = "SELECT YEAR(pe.DealDate) , COUNT(pe.MAMAId) , SUM(pe.Amount)
                                                FROM REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac
                                            WHERE  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry=15 and ac.AcquirerId=pe.AcquirerId 
                                            and DealDate between '".$startyear."' and '".$endyear."' and (pe.Amount between ".$elimit[0]." and ".$elimit[1].") GROUP BY YEAR(pe.DealDate)";
                                            //echo  $companysql;
                                            $resultcompany= mysql_query($companysql);
                                        }
                                       $compRangeSql .= $companysql."#"; 					
                                     }
                                }
			}
			else if($_POST)
                        {
                            
                             // echo "post";
                              $dt1 =  $startyear;
                              $dt2 = $endyear;
                              $addVCFlagqry=' and pec.industry=15';
                            if($type != 4)
                            {
                                
                                 if($advisorsearch_legal!="" || $advisorsearch_trans!="")
                                {
                                        $albef2=" ,REadvisor_cias AS cia,REmama_advisoracquirer AS adac";
					$albef=" ,REadvisor_cias as cia ,REmama_advisorcompanies AS adac";
                                }
                                if($type==1)
                                {
                                    if($advisorsearch_legal!="" || $advisorsearch_trans!="")
                                    {
                                             $companyadd = "select year(DealDate),count(MAMAId),SUM(Amount) from (";
                                             $companysql= $companyadd."select pe.DealDate,pe.MAMAId,pe.Amount FROM REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac,country as c ".$albef." where ";
                                            $companysql2 = "select pe.DealDate,pe.MAMAId,pe.Amount FROM REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac,country as c ".$albef2." where ";
                                    }
                                    else {
                                        //$companysql = "select year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$keybef." where";
                                        $companysql = "SELECT YEAR(pe.DealDate) , COUNT(pe.MAMAId) , SUM(pe.Amount) 
                                                FROM REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac,country as c where ";
                                        //echo $companysql;
                                    }
                                }
                                else if($type==2)
                                {
                                    if($advisorsearch_legal!="" || $advisorsearch_trans!="")
                                    {
                                            $companyadd = "select industry,year(DealDate),count(MAMAId),SUM(Amount) from (";
                                             $companysql= $companyadd."select i.industry,pe.DealDate,pe.MAMAId,pe.Amount FROM REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac,country as c ".$albef." where "; 
                                             $companysql2 = "select i.industry,pe.DealDate,pe.MAMAId,pe.Amount FROM REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac,country as c ".$albef2." where "; 
                                    }
                                    else {
                                        //$companysql = "select i.industry,year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$keybef." where pec.industry = i.industryid and "; 
                                        $companysql = "SELECT i.industry,YEAR(pe.DealDate) , COUNT(pe.MAMAId) ,SUM(pe.Amount) 
					FROM REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac,country as c where ";
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
                                        if ($dealtypeId > 0)
                                        {
                                                $wheredealtype = " pe.MADealTypeId =" .$dealtypeId;
                                        }

                                       if($targetProjectTypeId==1)
                                               $whereSPVCompanies=" pe.Asset=0";
                                        elseif($targetProjectTypeId==2)
                                               $whereSPVCompanies=" pe.Asset=1";

                                      //         echo "<Br>&&&&&&".$whereSPVCompanies;
                                        $acrossDealsDisplay="";
                                        if(($startRangeValue != "--") && ($endRangeValue != ""))
                                        {

                                                if($startRangeValue == $endRangeValue)
                                                {
                                                //	echo "<br>**********";
                                                        $whererange = " pe.Amount = ".$startRangeValue ."";
                                                }
                                                elseif($startRangeValue < $endRangeValue)
                                                {
                                                        $whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                                }
                                                elseif($endRangeValue!="--")
                                                {
                                                        $endRangeValue=50000;
                                                        $endRangeValueDisplay=50000;
                                                        $whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                                }

                                                $acrossDealsDisplay=1;
                                        }
                                        if($targetCountryId !="--")
                                        {
                                                $wheretargetCountry=" pec.countryId='" .$targetCountryId. "' ";
                                        }
                                        if($acquirerCountryId!="--")
                                        {
                                                $whereacquirerCountry=" ac.countryId='" .$acquirerCountryId. "' and c.countryid=ac.countryid";
                                        }

                                        if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                                        {
                                                $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                                        }
                                         
                                        if ($whereind != "")
                                        {
                                                $companysql=$companysql . $whereind ." and ";
                                                $bool=true;
                                        }
                                        else
                                        {
                                                $bool=false;
                                        }
                                        if (($wheredealtype != "") )
                                        {
                                                $companysql=$companysql . $wheredealtype . " and " ;
                                                $bool=true;
                                        }
                                        if (($whereSPVCompanies != "") )
                                        {
                                                $companysql=$companysql .$whereSPVCompanies . " and ";
                                                $bool=true;
                                        }
                                        if (($whererange != "") )
                                        {
                                                $companysql=$companysql .$whererange . " and ";
                                                $bool=true;
                                        }
                                       
                                        if($wheretargetCountry!="")
                                        { 
                                            $companysql=$companysql .$wheretargetCountry ." and "; 
                                        }
                                        if($whereacquirerCountry!="")
                                        {
                                            $companysql=$companysql .$whereacquirerCountry ." and "; 
                                        }
                          
                                      
                                        if($acquirersearch != " " && $acquirersearch != "")
                                        {
                                            $acs =" ac.Acquirer LIKE '%$acquirersearch%'";
                                            $companysql=$companysql . $acs . " and ";
                                        }
                                        else if($targetcompanysearch != "")
                                        {

                                                $csaft=" (pec.companyname LIKE '%$targetcompanysearch%' or sector_business like '%$targetcompanysearch%')";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                        elseif ($sectorsearch != "")
                                        {
                                               $companysql.="pec.sector_business LIKE '%$sectorsearch%' and";
                                        }
                                        else if($searchallfield!="")
                                        {
                                                $companysql.="( city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
							OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '$searchallfield%' ) AND";
                                        }
                                        if(($wheredates !== "") )
                                        {
                                                $companysql = $companysql ." i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                                and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId
                                                and pe.Deleted=0 AND ".$wheredates ."";
												 
						$companysql2 = $companysql2 ." i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                                and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId
                                                and pe.Deleted=0 AND ".$wheredates ."";
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                        if($advisorsearch_legal!=" " && $advisorsearch_legal !="")
                                        {
                                                $alaft=" and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and AdvisorType='L' and cia.cianame LIKE '%$advisorsearch_legal%'";
                                                $companysql=$companysql . $alaft . "";
						$companysql2=$companysql2 . $alaft . " ";
                                        }
                                        else if($advisorsearch_trans!="")
                                        {
                                                $ataft="and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and AdvisorType='T' and cia.cianame LIKE '%$advisorsearch_trans%'";
                                                $companysql=$companysql . $ataft . "";
						$companysql2=$companysql2 . $ataft . "";
                                        }
                                       
					if($advisorsearch_legal!="")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        if($advisorsearch_trans!="")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                         if($type == 1)
                                        {
                                            if($advisorsearch_legal!="" || $advisorsearch_trans!="")
                                            {
                                                    $searchtype=" $addVCFlagqry group by year(DealDate)";
                                            }
                                            else {
                                                    $searchtype=" $addVCFlagqry group by year(pe.DealDate)";
                                            }                                                                
                                      }
                                        if($type == 2)
                                        {
                                           if($advisorsearch_legal!="" || $advisorsearch_trans!="")
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
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                   //echo $companysql;
                                         //$resultcompany= mysql_query($companysql) or die(mysql_error());
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
                                    // print_r($range);
                                   for($r=0;$r<count($range);$r++)
                                    {
                                        if($advisorsearch_legal!="" || $advisorsearch_trans!="")
                                        {
                                                $albef2=" ,REadvisor_cias AS cia,REmama_advisoracquirer AS adac";
                                                $albef=" ,REadvisor_cias as cia ,REmama_advisorcompanies AS adac";
                                        }
                                       
                                        if($advisorsearch_legal!="" || $advisorsearch_trans!="")
                                        {
                                                 $companyadd = "select year(DealDate),count(MAMAId),SUM(Amount) from (";
                                                 $companysql= $companyadd."select pe.DealDate,pe.MAMAId,pe.Amount FROM REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac,country as c ".$albef." where ";
                                                $companysql2 = "select pe.DealDate,pe.MAMAId,pe.Amount FROM REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac,country as c ".$albef2." where ";
                                        }
                                        else {
                                            //$companysql = "select year(pe.dates),count(distinct pe.PEId),sum(distinct pe.amount)from peinvestments as pe, industry as i,pecompanies as pec,stage as s ".$keybef." where";
                                            $companysql = "SELECT YEAR(pe.DealDate) , COUNT(pe.MAMAId) , SUM(pe.Amount) 
                                                    FROM REmama AS pe, reindustry AS i, REcompanies AS pec,REacquirers as ac,country as c where ";
                                            //echo $companysql;
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
                                        if ($dealtypeId > 0)
                                        {
                                                $wheredealtype = " pe.MADealTypeId =" .$dealtypeId;
                                        }

                                       if($targetProjectTypeId==1)
                                               $whereSPVCompanies=" pe.Asset=0";
                                        elseif($targetProjectTypeId==2)
                                               $whereSPVCompanies=" pe.Asset=1";

                                      //         echo "<Br>&&&&&&".$whereSPVCompanies;
                                        $acrossDealsDisplay="";
                                           $limit=(string)$range[$r];
                                        $elimit=explode("-", $limit);
                                        if( $elimit[0] !='' && $elimit[1] !='' && $elimit[0] != $elimit[1])
                                        {
                                           $whererange = " pe.amount between  ".$elimit[0] ." and ". $elimit[1] ." "; 
                                        }
                                        else if($elimit[0] >= 200 || $elimit[1] >= 200)
                                        {
                                            $whererange = " pe.amount > 200";
                                        }
                                        else
                                        {
                                             $whererange="";
                                        }
                                        if($targetCountryId !="--")
                                        {
                                                $wheretargetCountry=" pec.countryId='" .$targetCountryId. "' ";
                                        }
                                        if($acquirerCountryId!="--")
                                        {
                                                $whereacquirerCountry=" ac.countryId='" .$acquirerCountryId. "' and c.countryid=ac.countryid";
                                        }

                                        if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                                        {
                                                $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                                        }
                                         
                                        if ($whereind != "")
                                        {
                                                $companysql=$companysql . $whereind ." and ";
                                                $bool=true;
                                        }
                                        else
                                        {
                                                $bool=false;
                                        }
                                        if (($wheredealtype != "") )
                                        {
                                                $companysql=$companysql . $wheredealtype . " and " ;
                                                $bool=true;
                                        }
                                        if (($whereSPVCompanies != "") )
                                        {
                                                $companysql=$companysql .$whereSPVCompanies . " and ";
                                                $bool=true;
                                        }
                                        if (($whererange != "") )
                                        {
                                                $companysql=$companysql .$whererange . " and ";
                                                $companysql2=$companysql2 .$whererange . " and ";
                                                $bool=true;
                                        }
                                       
                                        if($wheretargetCountry!="")
                                        { 
                                            $companysql=$companysql .$wheretargetCountry ." and "; 
                                        }
                                        if($whereacquirerCountry!="")
                                        {
                                            $companysql=$companysql .$whereacquirerCountry ." and "; 
                                        }
                          
                                      
                                        if($acquirersearch != " " && $acquirersearch != "")
                                        {
                                            $acs =" ac.Acquirer LIKE '%$acquirersearch%'";
                                            $companysql=$companysql . $acs . " and ";
                                        }
                                        else if($targetcompanysearch != "")
                                        {

                                                $csaft=" (pec.companyname LIKE '%$targetcompanysearch%')";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                        elseif ($sectorsearch != "")
                                        {
                                               $companysql.=" pec.sector_business LIKE '%$sectorsearch%' and";
                                        }
                                        else if($searchallfield!="")
                                        {
                                                $companysql.="( city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
							OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '$searchallfield%' ) AND";
                                        }
                                        if(($wheredates !== "") )
                                        {
                                                $companysql = $companysql ." i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                                and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId
                                                and pe.Deleted=0 AND ".$wheredates ."";
												 
						$companysql2 = $companysql2 ." i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                                and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId
                                                and pe.Deleted=0 AND ".$wheredates ."";
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                        if($advisorsearch_legal!=" " && $advisorsearch_legal !="")
                                        {
                                                $alaft=" and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and AdvisorType='L' and cia.cianame LIKE '%$advisorsearch_legal%'";
                                                $companysql=$companysql . $alaft . "";
						$companysql2=$companysql2 . $alaft . "";
                                        }
                                        else if($advisorsearch_trans!="")
                                        {
                                                $ataft=" and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and AdvisorType='T' and cia.cianame LIKE '%$advisorsearch_trans%'";
                                                $companysql=$companysql . $ataft . "";
						$companysql2=$companysql2 . $ataft . "";
                                        }
                                       
					if($advisorsearch_legal!="")
                                        {    
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        if($advisorsearch_trans!="")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        if($type == 4)
                                        {
                                            if(($advisorsearch_legal!="" && $advisorsearch_legal!=" ") || ($advisorsearch_trans!="" && $advisorsearch_trans!=" "))
                                            {
                                                    $searchtype=" $addVCFlagqry group by year(DealDate)";
                                            }
                                            else {
                                                    $searchtype=" $addVCFlagqry group by year(pe.DealDate)";
                                            }
                                        }
                                         if(($searchtype!== "") )
                                        {
                                                $companysql = $companysql .$searchtype;
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                        // echo "<br><br>".$companysql;
                                        $compRangeSql .= $companysql."#"; 					
                                     }
                                }
                               
		}	else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}
	
$companyId=632270771;
	$compId=0;
	$currentyear = date("Y");
	
        $TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin,Student from dealcompanies as dc ,malogin_members as dm where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
	
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
        $compRangeSql = urlencode($compRangeSql);
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
<label><input class="typeoff-nav2" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>Range</label>
</td></tr>
</table>
</div>

 <div class="profile-view-title"> 
 <?php 
 if($type==1)
 {
 ?>
    <h2>MA - Year on Year</h2>
<?php
 }
 elseif($type==2)
 {
     ?>
     <h2>MA - By Industry</h2>
 <?php
 }
 elseif($type==4)
 {
     ?>
     <h2>MA - By Range</h2>
 <?php
 }
  elseif($type==5)
 {
     ?>
     <h2>MA - By Investor</h2>
 <?php
 } elseif($type==6)
 {
 ?>
     <h2>MA - By Region</h2>
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

