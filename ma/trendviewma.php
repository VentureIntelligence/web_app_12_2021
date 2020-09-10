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
                                    $companysql = "SELECT YEAR(pe.DealDate) , COUNT(pe.MAMAId) , SUM(case when pe.hideamount=0 then pe.Amount end)
                                                FROM mama AS pe, industry AS i,pecompanies AS pec,country as c,
                                                acquirers as ac where DealDate between '".$startyear."' and '".$endyear."' 
                                                and i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and c.countryid=pec.countryid 
                                                and ac.AcquirerId = pe.AcquirerId and pec.industry != 15 and pe.Deleted=0
                                                GROUP BY YEAR(pe.DealDate)"  ;
                                   // echo  $companysql;
                                    
                                    //$resultcompany= mysql_query($companysql);
                                }
                                elseif ($type==2) 
                                {
                                   $companysql = "SELECT i.industry,YEAR(pe.DealDate) , COUNT(pe.MAMAId) , SUM(case when pe.hideamount=0 then pe.Amount end) 
					FROM mama AS pe, industry AS i,pecompanies AS pec,country as c,
                                                acquirers as ac where DealDate between '".$startyear."' and '".$endyear."' 
                                                and i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and c.countryid=pec.countryid 
                                                and ac.AcquirerId = pe.AcquirerId and pec.industry != 15 and pe.hideamount=0 and pe.Deleted=0
                                                GROUP BY i.industry,YEAR(pe.DealDate)";
                                 //echo  $companysql;
                                          
                                   //$resultcompany= mysql_query($companysql);
                                }
                                else if($type ==4)
                                {
                                    $compRangeSql="";
                                    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200+");
                                    for($r=0;$r<count($range);$r++)
                                    {
                                        if($r == count($range)-1)
                                        {
                                            $companysql = "SELECT YEAR(pe.DealDate) , COUNT(pe.MAMAId) , SUM(case when pe.hideamount=0 then pe.Amount end) 
                                                FROM mama AS pe, industry AS i,pecompanies AS pec,country as c,
                                                        acquirers as ac where DealDate between '".$startyear."' and '".$endyear."' 
                                                        and i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and c.countryid=pec.countryid 
                                                        and ac.AcquirerId = pe.AcquirerId and pec.industry != 15 and pe.hideamount=0 and pe.Deleted=0
                                                        and (pe.Amount > 200) GROUP BY YEAR(pe.DealDate)";
                                            //echo  $companysql;
                                             //$resultcompany= mysql_query($companysql);
                                        }
                                        else
                                        {
                                            $limit=(string)$range[$r];
                                            $elimit=explode("-", $limit);
                                            
                                            $companysql = "SELECT YEAR(pe.DealDate) , COUNT( pe.MAMAId) , SUM(case when pe.hideamount=0 then pe.Amount end) 
                                                FROM mama AS pe, industry AS i,pecompanies AS pec,country as c,
                                                        acquirers as ac where DealDate between '".$startyear."' and '".$endyear."' 
                                                        and i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID and c.countryid=pec.countryid 
                                                        and ac.AcquirerId = pe.AcquirerId and pec.industry != 15 and pe.hideamount=0 and pe.Deleted=0
                                                        and (pe.Amount between ".$elimit[0]." and ".$elimit[1].") GROUP BY YEAR(pe.DealDate)";
                                           // echo  $companysql;
                                            //$resultcompany= mysql_query($companysql);
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
                                        /*else
                                        {
                                            $deal='';
                                        }*/
                                     }
                                     $compRangeSql= urlencode($compRangeSql);
                                }
			//	     echo "<br>all records" .$companysql;
			}
			else if($_POST)
                        {
                             // echo "post";
                              $dt1 =  $startyear;
                              $dt2 = $endyear;
                            if($type != 4)
                            {
                                 if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                {
                                        $albef2=" ,advisor_cias AS cia,mama_advisorcompanies AS adac";
					$albef=" ,advisor_cias as cia , mama_advisoracquirer  AS adac";
                                }
                                if($type==1)
                                {
                                    if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                             $companyadd = "select year(DealDate),count(MAMAId),SUM(Amount) from (";
                                             $companysql= $companyadd."select pe.DealDate,pe.MAMAId,pe.Amount  FROM mama AS pe, industry AS i,pecompanies AS pec,country as c,acquirers as ac ".$albef." where ";
                                            $companysql2 = "select pe.DealDate,pe.MAMAId,pe.Amount  FROM mama AS pe, industry AS i,pecompanies AS pec,country as c,acquirers as ac ".$albef2." where ";
                                   }
                                    else {
                                        $companysql = "SELECT YEAR(pe.DealDate) , COUNT(pe.MAMAId) , SUM(case when pe.hideamount=0 then pe.Amount end) 
                                                FROM mama AS pe, industry AS i,pecompanies AS pec,country as c,
                                                acquirers as ac where";
                                    }
                                }
                                else if($type==2)
                                {
                                    if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                    {
                                              $companyadd = "select industry,year(DealDate),count(MAMAId),SUM(Amount) from (";
                                             $companysql= $companyadd."select i.industry,pe.DealDate,pe.MAMAId,pe.Amount  FROM mama AS pe, industry AS i,pecompanies AS pec,country as c,acquirers as ac ".$albef." where pec.industry = i.industryid and "; 
                                             $companysql2 = "select i.industry,pe.DealDate,pe.MAMAId,pe.Amount  FROM mama AS pe, industry AS i,pecompanies AS pec,country as c,acquirers as ac ".$albef2." where pec.industry = i.industryid and"; 
                                    }
                                    else {
                                        $companysql = "SELECT i.industry,YEAR(pe.DealDate) , COUNT(pe.MAMAId) ,SUM(Amount) 
					FROM mama AS pe, industry AS i,pecompanies AS pec,country as c,
                                                acquirers as ac where"; 
                                    }
                                }
                            
				//echo "<br> individual where clauses have to be merged ";
					if ($industry > 0)
                                        {
                                                $whereind = " pec.industry=" .$industry ;
                                        }
                                        if ($booldeal==true)
                                        {
                                            if(count($dealtype)<3)
                                            {
                                                foreach($dealtype as $typeId)
                                                {
                                                        //echo "<br>****----" .$stage;
                                                        $wheredeal= $wheredeal. " pe.MADealTypeId=" .$typeId." or ";
                                                }

                                                    $wheredealtype = $wheredeal ;							
                                                    $strlength=strlen($wheredealtype);
                                                    $strlength=$strlength-3;
                                                    //echo "<Br>----------------" .$wherestage;
                                                    $wheredealtype= substr ($wheredealtype , 0,$strlength);
                                                    if($wheredealtype !=''){
                                                    $wheredealtype ="(".$wheredealtype.")";
                                            }
                                        }
                                        }
                                        if($target_comptype!="--" && $target_comptype !='')
                                                $wheretargetcomptype= " pe.target_listing_status='$target_comptype'";
                                        if($acquirer_comptype!="--" && $acquirer_comptype !='')
                                                $whereacquirercomptype= " pe.acquirer_listing_status='$acquirer_comptype'";
                                        
                                        if (($startRangeValue!= "--") && ($endRangeValue != "") && ($startRangeValue!= "") && ($endRangeValue != "--"))
                                        {

                                                if($startRangeValue == $endRangeValue)
                                                {
                                                //	echo "<br>**********";
                                                        $whererange = " pe.Amount = ".$startRangeValue ." and pe.hideamount=0 ";
                                                }
                                                elseif($startRangeValue < $endRangeValue)
                                                {
                                                        $whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ." and pe.hideamount=0";
                                                }
                                                elseif($endRangeValue="--")
                                                {
                                                        $endRangeValue=50000;
                                                        $endRangeValueDisplay=50000;
                                                        $whererange = " pe.Amount between  ".$startRangeValue ." and ". $endRangeValue ." and pe.hideamount=0";
                                                }

                                                $acrossDealsDisplay=1;
                                        }
                                        if($targetCountryId !="--" && $targetCountryId !='')
                                        {
                                                $wheretargetCountry=" pec.countryId='" .$targetCountryId. "' ";
                                        }
                                        if($acquirerCountryId !="--" && $acquirerCountryId !='')
                                        {
                                                $whereacquirerCountry=" ac.countryId='" .$acquirerCountryId. "' ";
                                        }
                                        if( ($dt1 != "")  && ($dt2 != ""))
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
                                        if (( $wheretargetcomptype != ""))
                                        {
                                                $companysql=$companysql . $wheretargetcomptype . " and " ;
                                                $bool=true;
                                        }
                                        if($whereacquirercomptype!="")
                                        {
                                            $companysql=$companysql .$whereacquirercomptype . " and ";
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
                                            $acs=" ac.AcquirerId IN ($acquirerId)";
                                            $companysql=$companysql . $acs . " and ";
                                        }
                                        else if($targetcompanysearch != "" && $targetcompanysearch != " ")
                                        {
                                                $csaft=" pec.PECompanyId IN ($targetCompanyId) ";
                                                $companysql=$companysql . $csaft . " and ";
                                        }
                                        else if($targetsectorsearch !=''){
                                          //  if(isset($_POST['popup_select']) && $_POST['popup_select']=='sector'){
                                                $ssaft=" (".$sector_filter.")";                                                
                                          //  }
                                                 $companysql=$companysql . $ssaft. " and ";
                                        }
                                        else if($searchallfield!="")
                                        {
                                                $companysql.="( city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
							OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '$searchallfield%' ) AND";
                                        }
                                        if(($wheredates !== "") )
                                        {
                                             if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $companysql = $companysql ." i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
							and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId AND ".$wheredates ."";
												 
						$companysql2 = $companysql2 ." i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
							and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId AND ".$wheredates ."";
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                            }
                                            else {
                                                $companysql = $companysql ." i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
							and  c.countryid=pec.countryid and pec.industry != 15 and pe.Deleted =0 and ac.AcquirerId = pe.AcquirerId AND ".$wheredates ."";
												 
						$companysql2 = $companysql2 ." i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
							and  c.countryid=pec.countryid and pec.industry != 15 and pe.Deleted =0 and ac.AcquirerId = pe.AcquirerId AND ".$wheredates ."";
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                            }
                                        }
                                        if($advisorsearchstring_legal!=" " && $advisorsearchstring_legal !="")
                                        {
                                                $alaft=" and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and AdvisorType='L' and cia.cianame LIKE '%$advisorsearchstring_legal%'";
                                                $companysql=$companysql . $alaft . "";
						$companysql2=$companysql2 . $alaft . "";
                                        }
                                        else if($advisorsearchstring_trans!="")
                                        {
                                                $ataft=" and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and AdvisorType='T' and cia.cianame LIKE '%$advisorsearchstring_trans%'";
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
                                                    $searchtype=" group by year(DealDate)";
                                            }
                                            else {
                                                    $searchtype=" group by year(pe.DealDate)";
                                            }                                                                
                                      }
                                        if($type == 2)
                                        {
                                           if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $searchtype=" group by industry, year(DealDate)";
                                            }
                                            else {
                                                    $searchtype=" group by i.industry,year(pe.DealDate)";
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
                                   $compRangeSql = '';
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
                                        if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                        {
                                                $albef2=" ,advisor_cias AS cia,mama_advisorcompanies AS adac";
                                                $albef=" ,advisor_cias as cia , mama_advisoracquirer  AS adac";
                                        } 
                              
                                        if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                        {
                                                $companyadd = "select year(DealDate),count(MAMAId),SUM(Amount) from (";
                                                 $companysql= $companyadd."select pe.DealDate,pe.MAMAId,pe.Amount  FROM mama AS pe, industry AS i,pecompanies AS pec,country as c,acquirers as ac ".$albef." where ";
                                                $companysql2 = "select pe.DealDate,pe.MAMAId,pe.Amount  FROM mama AS pe, industry AS i,pecompanies AS pec,country as c,acquirers as ac ".$albef2." where ";
                                         }
                                        else {
                                            $companysql = "SELECT YEAR(pe.DealDate) , COUNT(pe.MAMAId) , SUM(case when pe.hideamount=0 then pe.Amount end) 
                                                    FROM mama AS pe, industry AS i,pecompanies AS pec,country as c,
                                                    acquirers as ac where";
                                        }
                                      if ($industry > 0)
                                        {
                                                $whereind = " pec.industry=" .$industry ;
                                        }
                                        if ($booldeal==true)
                                        {
                                            if(count($dealtype)<3)
                                            {
                                                foreach($dealtype as $typeId)
                                                {
                                                        //echo "<br>****----" .$stage;
                                                        $wheredeal= $wheredeal. " pe.MADealTypeId=" .$typeId." or ";
                                                }

                                                    $wheredealtype = $wheredeal ;							
                                                    $strlength=strlen($wheredealtype);
                                                    $strlength=$strlength-3;
                                                    //echo "<Br>----------------" .$wherestage;
                                                    $wheredealtype= substr ($wheredealtype , 0,$strlength);
                                                    if($wheredealtype !=''){
                                                    $wheredealtype ="(".$wheredealtype.")";
                                            }
                                        }
                                        }
                                        if($target_comptype!="--")
                                                $wheretargetcomptype= " pe.target_listing_status='$target_comptype'";
                                        if($acquirer_comptype!="--")
                                                $whereacquirercomptype= " pe.acquirer_listing_status='$acquirer_comptype'";
                                        $limit=(string)$range[$r];
                                        $elimit=explode("-", $limit);
                                        if( $elimit[0] !='' && $elimit[1] !='' && $elimit[0] != $elimit[1])
                                        {
                                           $whererange = " pe.Amount between  ".$elimit[0] ." and ". $elimit[1] ." "; 
                                        }
                                        else if($elimit[0] >= 200 || $elimit[1] >= 200)
                                        {
                                            $whererange = " pe.Amount > 200";
                                        }
                                        else
                                        {
                                             $whererange="";
                                        }
                                        if($targetCountryId !="--")
                                        {
                                                $wheretargetCountry=" pec.countryId='" .$targetCountryId. "' ";
                                        }
                                        if($acquirerCountryId !="--")
                                        {
                                                $whereacquirerCountry=" ac.countryId='" .$acquirerCountryId. "' ";
                                        }
                                        if( ($dt1 != "")  && ($dt2 != ""))
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
                                        if (( $wheretargetcomptype != ""))
                                        {
                                                $companysql=$companysql . $wheretargetcomptype . " and " ;
                                                $bool=true;
                                        }
                                        if($whereacquirercomptype!="")
                                        {
                                            $companysql=$companysql .$whereacquirercomptype . " and ";
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
                                            $acs=" ac.AcquirerId IN ($acquirerId)";
                                            $companysql=$companysql . $acs . " and ";
                                        }
                                        else if($targetcompanysearch != "")
                                        {
                                            $csaft=" pec.PECompanyId IN ($targetCompanyId) ";
                                                $companysql=$companysql . $csaft . " and ";

                                        }else if($targetsectorsearch !=''){
                                            if(isset($_POST['popup_select']) && $_POST['popup_select']=='sector'){
                                                $ssaft=" (".$sector_filter.")";                                                
                                            }else{
                                                $ssaft=" sector_business IN ($sectorsearch)";
                                        }
                                                 $companysql=$companysql . $ssaft. " and ";
                                        }
                                        else if($searchallfield!="")
                                        {
                                                $companysql.="( city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
							OR sector_business LIKE '$searchallfield%' or MoreInfor LIKE '$searchallfield%' ) AND";
                                        }
                                         if(($wheredates !== "") )
                                        {
                                             if($advisorsearchstring_legal!="" || $advisorsearchstring_trans!="")
                                            {
                                                    $companysql = $companysql ." i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
							and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId AND ".$wheredates ."";
												 
						$companysql2 = $companysql2 ." i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
							and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId AND ".$wheredates ."";
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                            }
                                            else {
                                                $companysql = $companysql ." i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
							and  c.countryid=pec.countryid and pec.industry != 15 and pe.Deleted =0 and ac.AcquirerId = pe.AcquirerId AND ".$wheredates ."";
												 
						$companysql2 = $companysql2 ." i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
							and  c.countryid=pec.countryid and pec.industry != 15 and pe.Deleted =0 and ac.AcquirerId = pe.AcquirerId AND ".$wheredates ."";
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                            }
                                        }
                                        if($advisorsearchstring_legal!=" " && $advisorsearchstring_legal !="")
                                        {
                                                $alaft=" and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and AdvisorType='L' and cia.cianame LIKE '%$advisorsearchstring_legal%'";
                                                $companysql=$companysql . $alaft . "";
						$companysql2=$companysql2 . $alaft . "";
                                        }
                                        else if($advisorsearchstring_trans!="")
                                        {
                                                $ataft=" and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and AdvisorType='T' and cia.cianame LIKE '%$advisorsearchstring_trans%'";
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
                                            if(($advisorsearchstring_legal!="" && $advisorsearchstring_legal!=" ") || ($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" "))
                                            {
                                                    $searchtype=" group by year(DealDate)";
                                            }
                                            else {
                                                    $searchtype=" group by year(pe.DealDate)";
                                            }
                                        }
                                         if(($searchtype!== "") )
                                        {
                                                $companysql = $companysql .$searchtype;
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }	
					$compRangeSql .= $companysql."#";
										
                                         //echo $companysql.'<br><br>';
                                              //$resultcompany= mysql_query($companysql) or die(mysql_error());
                                        
                                        /*if(mysql_num_rows($resultcompany)>0)
                                        {
                                            while ($rowrange = mysql_fetch_array($resultcompany))
                                            {
                                                $deal[$range[$r]][$rowrange[0]]['dealcount']=$rowrange[1];
                                                $deal[$range[$r]][$rowrange[0]]['sumamount']=$rowrange[2];   
                                            }
                                        }*/
                                     }
                                    // $compRangeSql = urlencode($compRangeSql);
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
        
        
	$companysql=  urlencode($companysql);
        $compRangeSql = urlencode($compRangeSql);
?>
<div>
<table cellpadding="0" cellspacing="0" width="100%" >
	<tr>
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
							</td>
                        </tr>
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
	</tr>
</table>
<div class=""></div>

<!--
<div>
	<table>
	<tr>
     <td class="profile-view-left" colspan="2">
 		 <div class="showhide-link link-expand-table">
         	<a href="#" class="show_hide" rel="#slidingDataTable">View Table</a>
         </div>
         <div class="view-table expand-table" id="slidingDataTable" style="display:none; overflow:hidden;">
     		<div class="restable" >
            </div>
         </div>
     </td>
   </tr>
   </table>
</div>
-->
