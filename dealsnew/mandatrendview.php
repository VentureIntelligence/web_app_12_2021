<?php
    
/*echo $addedflagQry . $addhide_pms_qry . $addDelind;
echo $startyear;
echo $endyear;*/
			
                    if(count($_POST)==0){
                         if(isset($_REQUEST["type"])) { $type=$_REQUEST["type"]; } else { $type=1; }
				 //echo "not post";
				$yourquery=0;
				$stagevaluetext="";
				$industry=0;
				
				
                                //echo "<br>Query for all records";
                                if($type==1)
                                { 
      								 
                                   /* $companysql = "select year(pe.DealDate),count(DISTINCT pe.MandAId) as totaldeals,sum(pe.DealAmount)as totalamount from manda as pe, industry as i, pecompanies as pec,dealtypes as dt where i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                            and pec.industry != 15 and pe.Deleted=0 " .$addedflagQry . $addedhide_pms_qry . $addDelind. " and DealDate between '".$startyear."' and '".$endyear."' group by year(pe.DealDate)"  ;
                                   echo  $companysql;*/
                                    $resultcompany= mysql_query($companysql);
                                    
                                   $companysql = " SELECT year( DealDate ) , count( MandAId ) AS totaldeals, sum( DealAmount ) AS totalamount
                                    FROM (
                                    SELECT DISTINCT pe.MandAId, pe.DealDate, pe.DealAmount
                                    FROM manda AS pe, pecompanies AS pec, industry AS i, dealtypes AS dt, manda_investors AS mandainv
                                    WHERE i.industryid = pec.industry
                                    AND pec.PEcompanyID = pe.PECompanyID
                                    AND pe.Deleted =0
                                    " .$addedflagQry . $addedhide_pms_qry . $addDelind. "
                                    AND DealDate between '".$startyear."' and '".$endyear."'
                                    AND mandainv.MandAId = pe.MandAId
                                    AND pec.industry !=15
                                    ) AS T
                                    GROUP BY year( DealDate )"  ;
                                  // echo  $companysql;
                                    $resultcompany= mysql_query($companysql);
                                }
                                elseif ($type==2) 
                                {  
                                   /*$companysql = "select  i.industry,year(pe.DealDate),count(DISTINCT pe.MandAId) as totaldeals,sum(pe.DealAmount)as totalamount from manda as pe, industry as i,pecompanies as pec,dealtypes as dt where i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                             and pec.industry != 15 and pe.Deleted=0 " .$addedflagQry . $addedhide_pms_qry . $addDelind. " and  DealDate between '".$startyear."' and '".$endyear."' group by pec.industry,year(pe.DealDate)";
                                  //echo  $companysql;*/
                                    $companysql = "SELECT industry, year( DealDate ) , count( MandAId ) AS totaldeals, sum( DealAmount ) AS totalamount
                                            FROM (

                                            SELECT DISTINCT pe.MandAId, pe.DealDate, pe.DealAmount, i.industry
                                            FROM manda AS pe, pecompanies AS pec, industry AS i, dealtypes AS dt, manda_investors AS mandainv
                                            WHERE i.industryid = pec.industry
                                            AND pec.PEcompanyID = pe.PECompanyID
                                            AND pe.Deleted =0
                                            AND pe.DealTypeId = dt.DealTypeId
                                            AND dt.hide_for_exit =0
                                            AND DealDate
                                            BETWEEN '2012-01-01'
                                            AND '2013-12-01'
                                            AND mandainv.MandAId = pe.MandAId
                                            AND pec.industry !=15
                                            ) AS T
                                            GROUP BY industry, year( DealDate )";
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
                                            /*$companysql = "select year(pe.DealDate),count(DISTINCT pe.MandAId) as totaldeals,sum(pe.DealAmount)as totalamount from manda as pe, industry as i,pecompanies as pec,dealtypes as dt where i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                            and pec.industry != 15 and pe.Deleted=0 " .$addedflagQry . $addedhide_pms_qry . $addDelind. " and  (pe.DealAmount  > 200) and DealDate between '".$startyear."' and '".$endyear."' group by year(pe.DealDate)";*/
                                             $companysql = " SELECT year( DealDate ) , count( MandAId ) AS totaldeals, sum( DealAmount ) AS totalamount
                                                FROM (
                                                SELECT DISTINCT pe.MandAId, pe.DealDate, pe.DealAmount
                                                FROM manda AS pe, pecompanies AS pec, industry AS i, dealtypes AS dt, manda_investors AS mandainv
                                                WHERE i.industryid = pec.industry
                                                AND pec.PEcompanyID = pe.PECompanyID
                                                AND pe.Deleted =0
                                                " .$addedflagQry . $addedhide_pms_qry . $addDelind. "
                                                    and  (pe.DealAmount  > 200) and
                                                AND DealDate between '".$startyear."' and '".$endyear."'
                                                AND mandainv.MandAId = pe.MandAId
                                                AND pec.industry !=15
                                                ) AS T
                                                GROUP BY year( DealDate )"  ;
                                          //echo  $companysql;
                                             $resultcompany= mysql_query($companysql);
                                        }
                                        else
                                        {  
                                            $limit=(string)$range[$r];
                                            $elimit=explode("-", $limit);
                                            /*$companysql  = "select year(pe.DealDate),count(DISTINCT pe.MandAId) as totaldeals,sum( pe.DealAmount)as totalamount from manda as pe, industry as i,pecompanies as pec,dealtypes as dt where i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                            and pec.industry != 15 and pe.Deleted=0 " .$addedflagQry . $addedhide_pms_qry . $addDelind. " and  (pe.DealAmount > ".$elimit[0]." and pe.DealAmount <= ".$elimit[1].") and DealDate between '".$startyear."' and '".$endyear."' group by year(pe.DealDate)";   */                        
                                            $companysql = " SELECT year( DealDate ) , count( MandAId ) AS totaldeals, sum( DealAmount ) AS totalamount
                                                FROM (
                                                SELECT DISTINCT pe.MandAId, pe.DealDate, pe.DealAmount
                                                FROM manda AS pe, pecompanies AS pec, industry AS i, dealtypes AS dt, manda_investors AS mandainv
                                                WHERE i.industryid = pec.industry
                                                AND pec.PEcompanyID = pe.PECompanyID
                                                AND pe.Deleted =0
                                                " .$addedflagQry . $addedhide_pms_qry . $addDelind. "
                                                    and  (pe.DealAmount>=".$elimit[0]." and pe.DealAmount<".$elimit[1].") and
                                                AND DealDate between '".$startyear."' and '".$endyear."'
                                                AND mandainv.MandAId = pe.MandAId
                                                AND pec.industry !=15
                                                ) AS T
                                                GROUP BY year( DealDate )"  ;
                                              // echo  $companysql;
                                            $resultcompany= mysql_query($companysql);
                                        }
					$compRangeSql .= $companysql."#";  
                                     }
				$compRangeSql= urlencode($compRangeSql);
                                }
                                elseif($type==5)
                                {
								
                                  /* $companysql = "select inv.InvestorTypeName,year(pe.DealDate),count(DISTINCT pe.MandAId) as totaldeals,sum(pe.DealAmount)as totalamount from manda as pe, industry as i, investortype as inv ,pecompanies as pec,dealtypes as dt where i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                            and pec.industry != 15 and pe.Deleted=0 " .$addedflagQry . $addedhide_pms_qry . $addDelind. " and  pe.InvestorType=inv.InvestorType and DealDate between '".$startyear."' and '".$endyear."' group by inv.InvestorTypeName,year(pe.DealDate)";*/
                                    $companysql = "SELECT InvestorTypeName, year( DealDate ) , count( MandAId ) AS totaldeals, sum( DealAmount ) AS totalamount
                                            FROM (
                                                SELECT DISTINCT pe.MandAId, pe.DealDate, pe.DealAmount, inv.InvestorTypeName
                                                FROM manda AS pe, pecompanies AS pec, industry AS i,investortype as inv,dealtypes AS dt, manda_investors AS mandainv
                                                WHERE i.industryid = pec.industry
                                                AND pec.PEcompanyID = pe.PECompanyID
                                                AND pe.Deleted =0
                                                and pe.Deleted=0 " .$addedflagQry . $addedhide_pms_qry . $addDelind. " and  pe.InvestorType=inv.InvestorType and
                                                DealDate BETWEEN '2012-01-01' AND '2013-12-01'
                                                AND mandainv.MandAId = pe.MandAId
                                                AND pec.industry !=15
                                                ) AS T
                                                GROUP BY industry, year( DealDate )";
                                    
                                   // echo  $companysql;
                                    
                                  $resultcompany= mysql_query($companysql);
                                }
                               
			//	     echo "<br>all records" .$companysql;
			}
			else if($_POST)
                        {
							if(isset($_REQUEST["type"])) { $type=$_REQUEST["type"]; } else { $type=1; }
							
                              $dt1 =  $startyear;
                              $dt2 = $endyear;
                            if($type != 4)
                            {
                                if(trim($investorsearch) != "")
                                {
                                        $keybef=" ,manda_investors as peinv_inv, peinvestors as inv";
                                }
                                if(trim($acquirersearch)!= "")
                                    {
                                    $acqbef=", acquirers AS ac";
                                }
                                if(trim($advisorsearchstring_legal)!="" || trim($advisorsearchstring_trans)!="")
                                {
                                        $albef2=" ,advisor_cias AS cia, peinvestments_advisorcompanies AS adac, acquirers AS ac";
					$albef=" ,advisor_cias as cia , peinvestments_advisoracquirer  AS adac, acquirers AS ac";
                                }
                                if($type==1)
                                {
                                    if(trim($advisorsearchstring_legal)!="" || trim($advisorsearchstring_trans)!="")
                                    {
                                            $companyadd = "select year(DealDate),count(MandAId),sum(DealAmount) from (";
                                            $companysql = $companyadd."select pe.DealDate,pe.MandAId,pe.DealAmount from manda as pe,  pecompanies as pec, industry as i,dealtypes as dt".$albef." where";
                                           $companysql2 = "select pe.DealDate,pe.MandAId,pe.DealAmount from manda as pe,  pecompanies as pec, industry as i,dealtypes as dt".$albef2." where";
                                    }
                                    else {
                                            $companyadd = "select year(DealDate),count(MandAId),sum(DealAmount) from (";
                                            $companysql = $companyadd."select DISTINCT pe.MandAId,pe.DealDate,pe.DealAmount from manda as pe,  pecompanies as pec, industry as i,dealtypes as dt, manda_investors AS mandainv ".$keybef. " ".$acqbef." where";
                                         //$companysql = "select year(pe.DealDate),count(DISTINCT  pe.MandAId) as totaldeals,sum(pe.DealAmount)as totalamount from manda as pe,  pecompanies as pec, industry as i,dealtypes as dt".$keybef." where";
                                    }
                                    
                                }
                                else if($type==2)
                                {
                                    if(trim($advisorsearchstring_legal)!="" || trim($advisorsearchstring_trans)!="")
                                    {
                                             $companyadd = "select industry,year(DealDate),count(MandAId),sum(DealAmount) from (";
                                             $companysql= $companyadd."select i.industry,pe.DealDate,DISTINCT pe.MandAId,pe.DealAmount from manda as pe,  pecompanies as pec, industry as i,dealtypes as dt".$albef." where"; 
                                             $companysql2 = "select i.industry,pe.DealDate,pe.MandAId,pe.DealAmount from manda as pe,  pecompanies as pec, industry as i,dealtypes as dt".$albef2." where"; 
                                    }
                                    else {
                                         $companyadd = "select industry,year(DealDate),count(MandAId),sum(DealAmount) from (";
                                       $companysql= $companyadd."select DISTINCT pe.MandAId,pe.DealDate,pe.DealAmount,i.industry from manda as pe,  pecompanies as pec, industry as i,dealtypes as dt, manda_investors AS mandainv ".$keybef. " ".$acqbef." where"; 
          
                                    }
                                                         
                                }
                                else if($type==5)
                                {
                                     if(trim($advisorsearchstring_legal)!="" || trim($advisorsearchstring_trans)!="")
                                    {
                                             $companyadd = "select InvestorTypeName,year(DealDate),count(MandAId),sum(DealAmount) from (";
                                             $companysql= $companyadd."select inv.InvestorTypeName,pe.DealDate,pe.MandAId,pe.DealAmount from manda as pe,investortype as inv,  pecompanies as pec, industry as i,dealtypes as dt".$albef." where  pe.InvestorType=inv.InvestorType  and "; 
                                             $companysql2 = "select inv.InvestorTypeName,pe.DealDate,pe.MandAId,pe.DealAmount from manda as pe,investortype as inv,  pecompanies as pec, industry as i,dealtypes as dt".$albef2." where  pe.InvestorType=inv.InvestorType  and"; 
                                    }
                                    else {
                                            $companyadd = "select InvestorTypeName,year(DealDate),count(MandAId),sum(DealAmount) from (";
                                             $companysql= $companyadd."select DISTINCT pe.MandAId,pe.DealDate,pe.DealAmount,inv.InvestorTypeName from manda as pe,investortype as inv,  pecompanies as pec, industry as i,dealtypes as dt , manda_investors AS mandainv ".$keybef. " ".$acqbef." where  pe.InvestorType=inv.InvestorType  and "; 
          
                                    }
                                                                   
                                }
								
								
                               
                            
				//echo "<br> individual where clauses have to be merged ";
                                            if ($industry > 0)
                                            {
                                                     $iftest=$iftest.".1";
                                                    $whereind = " pec.industry=" .$industry ;
                                                    $qryIndTitle="Industry - ";
                                            }
                                            if ($dealtype!= "--" && $dealtype!= "" )
                                            {
                                                 $iftest=$iftest.".2";
                                                    $wheredealtype = " pe.DealTypeId =" .$dealtype;
                                                    $qryDealTypeTitle="Deal Type - ";
                                            }
                                            if ($invType!= "--" && $invType!= "")
                                            {
                                                  $iftest=$iftest.".3";
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pe.InvestorType = '".$investorType."'";
                                            }
											
											if ($InType!= "")
                                            {
                                                $whereInType = " pe.type = '".$InType."'";
                                            }
											
											
                                            if($exitstatusvalue!="--" && $exitstatusvalue!="")
                                            {     $iftest=$iftest.".4";
                                                $whereexitstatus=" pe.ExitStatus=".$exitstatusvalue;  }
                                        //echo "<Br>***".$whererange;
                                            if(trim($txtfrm>0) && trim($txtto==""))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" mandainv.MultipleReturn >= " .$txtfrm  ;
                                            }
                                            elseif(trim($txtfrm=="") && trim($txtto>0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" mandainv.MultipleReturn < " .$txtto  ;
                                            }
                                            elseif(trim($txtfrm>  0) && trim($txtto >0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" mandainv.MultipleReturn >= " .$txtfrm . " and  mandainv.MultipleReturn <".$txtto;
                                            }
                                            if( ($dt1 != "")  && ($dt2 != ""))
                                            {
                                               $wheredates= " DealDate  between '".$startyear."' and '".$endyear."'";
                                            }

                                        
                                        if ($whereind != "")
                                        {
                                                $companysql=$companysql . $whereind ." and ";
                                                $aggsql=$aggsql . $whereind ." and ";
                                                $bool=true;
                                        }
										
										if ($whereInType != "")
                                        {
                                                $companysql=$companysql . $whereInType ." and ";
                                                $aggsql=$aggsql . $whereInType ." and ";
                                                $bool=true;
                                        }
										
                                        if (($wheredealtype != ""))
                                        {
                                                $companysql=$companysql . $wheredealtype . " and " ;
                                                $aggsql=$aggsql . $wheredealtype . " and " ;
                                                $bool=true;
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

                                         if($whereReturnMultiple!= "")
                                         {
                                         $companysql = $companysql . $whereReturnMultiple ." and ";
                                         }
                                            
                                         if(trim($investorsearch) != "")
                                        {
                                                $keyaft=" pe.MandAId=peinv_inv.MandAId and inv.InvestorId=peinv_inv.InvestorId and inv.investor LIKE '%$investorsearch%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        if(trim($acquirersearch)!= "")
                                        {
                                            $acqaft=" ac.AcquirerId = pe.AcquirerId and ac.Acquirer LIKE '%$acquirersearch%'";
                                            $companysql=$companysql . $acqaft . " and ";
                                        }
                                        if(trim($companysearch) != "")
                                        {

                                                $csaft=" (pec.companyname LIKE '%$companysearch%')";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                         if(trim($sectorsearch) != "")
                                        {

                                                $csaft=" (sector_business LIKE '$sectorsearch%')";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                        if($searchallfield!="")
                                        {
                                                $companysql.="( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
                                            OR sector_business LIKE '$searchallfield%' or  MoreInfoReturns LIKE '$searchallfield%' or  InvestmentDeals LIKE '$searchallfield%') AND";
                                        }
                                        //the foll if was previously checked for range
                                        if(($wheredates != "") )
                                        {
                                            if(trim($advisorsearchstring_legal)!="" || trim($advisorsearchstring_trans)!="")
                                            {
                                                    $companysql = $companysql . " i.industryid=pec.industry AND ac.AcquirerId = pe.AcquirerId and 
                                                pec.PEcompanyID = pe.PECompanyID and
                                                Deleted=0 " .$addedflagQry . " AND ".$wheredates ."";

                                                $companysql2 = $companysql2 . " i.industryid=pec.industry AND ac.AcquirerId = pe.AcquirerId and
                                                pec.PEcompanyID = pe.PECompanyID and
                                                Deleted=0 " .$addedflagQry . " AND ".$wheredates ."";
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                            }
                                            else if(trim($investorsearch) != "" || trim($acquirersearch)!= "" || trim($companysearch) != "" || trim($sectorsearch) != "" || $searchallfield!="")
                                            {
                                                $companysql = $companysql . " i.industryid=pec.industry and
                                                pec.PEcompanyID = pe.PECompanyID and mandainv.MandAId = pe.MandAId AND pec.industry !=15 and
                                                pe.Deleted=0 " .$addedflagQry . $addedhide_pms_qry . $addDelind. "";
                                                
                                            }
                                            else {
                                                $companysql = $companysql . " i.industryid=pec.industry and
                                                pec.PEcompanyID = pe.PECompanyID and mandainv.MandAId = pe.MandAId AND pec.industry !=15 and
                                                pe.Deleted=0 " .$addedflagQry . $addedhide_pms_qry . $addDelind. " AND ".$wheredates ."";
                                            }
                                        }
                                            
                                        if($advisorsearchstring_legal!=" " && $advisorsearchstring_legal !="")
                                        {
                                                $alaft=" and adac.CIAId = cia.CIAId AND adac.PEId = pe.MandAId and AdvisorType='L' AND cia.cianame LIKE '%$advisorsearchstring_legal%'";
                                                $companysql=$companysql . $alaft . "";
												$companysql2=$companysql2 . $alaft . "";
                                        }
                                        else if($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" ")
                                        {
                                               $ataft=" and adac.CIAId = cia.CIAId AND adac.PEId = pe.MandAId and AdvisorType='T' AND cia.cianame LIKE '%$advisorsearchstring_trans%'";
                                                $companysql=$companysql . $ataft . "";
												$companysql2=$companysql2 . $ataft . "";
                                        }
                                       
										if($advisorsearchstring_legal!="" && $advisorsearchstring_legal!=" ")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        if($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" ")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                         if($type == 1)
                                        {
                                            if(trim($advisorsearchstring_legal)!="" || trim($advisorsearchstring_trans)!="")
                                            {
                                                    $searchtype=" group by year(DealDate)";
                                            }
                                            else 
											{
                                                    $searchtype=" ) AS T group by year(DealDate)";
                                            }                                                                
                                     	 }
                                        if($type == 2)
                                        {
                                           if(trim($advisorsearchstring_legal)!="" || trim($advisorsearchstring_trans)!="")
                                            {
                                                    $searchtype=" group by industry, year(DealDate)";
                                            }
                                            else {
                                                    $searchtype=") AS T group by industry,year(DealDate)";
                                            }
                                        }
										
                                        if($type == 5)
                                        {
                                           if(trim($advisorsearchstring_legal)!="" || trim($advisorsearchstring_trans)!="")
                                            {
                                                    $searchtype=" group by InvestorTypeName, year(DealDate)";
                                            }
                                            else {
                                                    $searchtype=") AS T group by InvestorTypeName,year(DealDate)";
                                            }
                                        }
                                        if(($searchtype!== "") )
                                        {
                                                $companysql = $companysql .$searchtype;
                                                $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
                                        
                                  // echo $companysql;
                                         $resultcompany= mysql_query($companysql);
                               }
                                        
                                else if($type == 4 && $_POST)
                                {
                                     
                                    $range = array("0-5", "5-10", "10-15", "15-25", "25-50", "50-100", "100-200", "200");
                                    //print_r($range);
                                    $compRangeSql = '';
                                    for($r=0;$r<count($range);$r++)
                                    {
                                        if(trim($investorsearch) != "")
                                        {
                                                $keybef=" ,manda_investors as peinv_inv, peinvestors as inv";
                                        }
                                        if(trim($acquirersearch)!= "")
                                            {
                                            $acqbef=", acquirers AS ac";
                                        }
                                        if(trim($advisorsearchstring_legal)!="" || trim($advisorsearchstring_trans)!="")
                                        {
                                                $albef2=" ,advisor_cias AS cia, peinvestments_advisorcompanies AS adac, acquirers AS ac";
                                                $albef=" ,advisor_cias as cia , peinvestments_advisoracquirer  AS adac, acquirers AS ac";
                                        }
                               
                                        $limit=(string)$range[$r];
                                        $elimit=explode("-", $limit);
                                         if( $elimit[0] !='' && $elimit[1] !='' && $elimit[0] != $elimit[1])
                                         {
                                             $whererange = "(pe.DealAmount>=".$elimit[0]." and pe.DealAmount<".$elimit[1].")";
                                         }
                                         else
                                         {
                                             $whererange = "  (pe.DealAmount > ".$elimit[0].")";
                                         }
                                       
                                        if(trim($advisorsearchstring_legal)!="" || trim($advisorsearchstring_trans)!="")
                                        {
                                                $companyadd = "select year(DealDate),count(MandAId),sum(DealAmount) from (";
                                                $companysql = $companyadd."select pe.DealDate,pe.MandAId,pe.DealAmount from manda as pe,  pecompanies as pec, industry as i,dealtypes as dt".$albef." where";
                                               $companysql2 = "select pe.DealDate,pe.MandAId,pe.DealAmount from manda as pe,  pecompanies as pec, industry as i,dealtypes as dt".$albef2." where";
                                        }
                                        else {
                                             
                                            $companyadd = "select year(DealDate),count(MandAId),sum(DealAmount) from (";
                                                $companysql = $companyadd."select DISTINCT pe.MandAId,pe.DealDate,pe.DealAmount from manda as pe,  pecompanies as pec, industry as i,dealtypes as dt, manda_investors AS mandainv ".$keybef. " ".$acqbef." where";
                                        }
                                    
                                
                                         if ($industry > 0)
                                            {
                                                     $iftest=$iftest.".1";
                                                    $whereind = " pec.industry=" .$industry ;
                                                    $qryIndTitle="Industry - ";
                                            }
                                            if ($dealtype!= "--" && $dealtype!= "")
                                            {
                                                 $iftest=$iftest.".2";
                                                    $wheredealtype = " pe.DealTypeId =" .$dealtype;
                                                    $qryDealTypeTitle="Deal Type - ";
                                            }
                                             if ($invType!= "--" && $invType!= "")
                                            {
                                                  $iftest=$iftest.".3";
                                                $qryInvType="Investor Type - " ;
                                                $whereInvType = " pe.InvestorType = '".$investorType."'";
                                            }
                                            if($exitstatusvalue!="--" && $exitstatusvalue!="")
                                            {     $iftest=$iftest.".4";
                                                $whereexitstatus=" pe.ExitStatus=".$exitstatusvalue;  }
                                        //echo "<Br>***".$whererange;
                                           if(trim($txtfrm>0) && trim($txtto==""))
                                            {
                                                         $iftest=$iftest.".7";
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" pe.MandAId=ipoinv.MandAId and ipoinv.MultipleReturn > " .$txtfrm  ;
                                            }
                                            elseif(trim($txtfrm=="") && trim($txtto>0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" pe.MandAId=ipoinv.MandAId and ipoinv.MultipleReturn < " .$txtto  ;
                                            }
                                            elseif(trim($txtfrm>  0) && trim($txtto >0))
                                            {
                                                   $qryReturnMultiple="Return Multiple - ";
                                                   $whereReturnMultiple=" pe.MandAId=ipoinv.MandAId and ipoinv.MultipleReturn > " .$txtfrm . " and  ipoinv.MultipleReturn <".$txtto;
                                            }
                                            if( ($dt1 != "")  && ($dt2 != ""))
                                            {
                                               $wheredates= " and DealDate between '".$startyear."' and '".$endyear."' ";
                                            }

                                        
                                        if ($whereind != "")
                                        {
                                                $companysql=$companysql . $whereind ." and ";
                                                $aggsql=$aggsql . $whereind ." and ";
                                                $bool=true;
                                        }
                                        if (($wheredealtype != ""))
                                        {
                                                $companysql=$companysql . $wheredealtype . " and " ;
                                                $aggsql=$aggsql . $wheredealtype . " and " ;
                                                $bool=true;
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

                                         if($whereReturnMultiple!= "")
                                         {
                                         $companysql = $companysql . $whereReturnMultiple ." and ";
                                         }
                                       
                                         if(trim($investorsearch) != "")
                                        {
                                                $keyaft=" pe.MandAId=peinv_inv.MandAId and inv.InvestorId=peinv_inv.InvestorId and inv.investor LIKE '%$investorsearch%'";
                                                $companysql=$companysql . $keyaft . " and ";
                                        }
                                        if(trim($acquirersearch)!= "")
                                        {
                                            $acqaft=" ac.AcquirerId = pe.AcquirerId and ac.Acquirer LIKE '%$acquirersearch%'";
                                            $companysql=$companysql . $acqaft . " and ";
                                        }
                                        if(trim($companysearch) != "")
                                        {

                                                $csaft=" (pec.companyname LIKE '%$companysearch%')";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                        if(trim($sectorsearch) != "")
                                        {

                                                $csaft=" (sector_business LIKE '$sectorsearch%')";
                                                $companysql=$companysql . $csaft . " and ";

                                        }
                                        if($searchallfield!="")
                                        {
                                                $companysql.="( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
                                            OR sector_business LIKE '$searchallfield%' or  MoreInfoReturns LIKE '$searchallfield%' or  InvestmentDeals LIKE '$searchallfield%') AND";
                                        }
                                        //the foll if was previously checked for range
                                      
                                        if(($whererange  !== "") )
                                        {
                                            if(trim($advisorsearchstring_legal)!="" || trim($advisorsearchstring_trans)!="")
                                            {
                                                    $companysql = $companysql . " i.industryid=pec.industry AND ac.AcquirerId = pe.AcquirerId and 
                                                pec.PEcompanyID = pe.PECompanyID and
                                                Deleted=0 " .$addedflagQry . " AND ".$whererange ."and";

                                                $companysql2 = $companysql2 . " i.industryid=pec.industry AND ac.AcquirerId = pe.AcquirerId and
                                                pec.PEcompanyID = pe.PECompanyID and
                                                Deleted=0 " .$addedflagQry . " AND ".$whererange ." and ";
                                                $bool=true;
                                            }
                                            else {
                                                $companysql = $companysql . " i.industryid=pec.industry and
                                                pec.PEcompanyID = pe.PECompanyID and mandainv.MandAId = pe.MandAId AND pec.industry !=15 and
                                                pe.Deleted=0 " .$addedflagQry . $addedhide_pms_qry . $addDelind. " AND ".$whererange ." ";

                                            }
                                        }
                                        if(($wheredates !== "") )
                                        {
                                            if(trim($investorsearch) != "" || trim($acquirersearch)!= "" || trim($companysearch) != "" || trim($sectorsearch) != "" || $searchallfield!="")
                                            {
                                                $companysql = $companysql ."";
                                                $companysql2 = $companysql2 ."";
                                                //$aggsql = $aggsql . $wheredates ."";
                                                $bool=true;
                                                
                                            }
                                            else {
                                                $companysql = $companysql . $wheredates;
                                                $companysql2 = $companysql2 . $wheredates;
                                                //$aggsql = $aggsql . $wheredates ."";
                                                $bool=true;
                                            }
                                        }
                                        if($advisorsearchstring_legal!=" " && $advisorsearchstring_legal !="")
                                        {
                                                $alaft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.MandAId and AdvisorType='L' AND cia.cianame LIKE '%$advisorsearchstring_legal%'";
                                                $companysql=$companysql . $alaft . "";
						$companysql2=$companysql2 . $alaft . "";
                                        }
                                        else if($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" ")
                                        {
                                               $ataft=" adac.CIAId = cia.CIAId AND adac.PEId = pe.MandAId and AdvisorType='T' AND cia.cianame LIKE '%$advisorsearchstring_trans%'";
                                                $companysql=$companysql . $ataft . "";
						$companysql2=$companysql2 . $ataft . "";
                                        }
                                       
					if($advisorsearchstring_legal!="" && $advisorsearchstring_legal!=" ")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        if($advisorsearchstring_trans!="" && $advisorsearchstring_trans!=" ")
                                        {
                                                
                                                $companysql=$companysql." UNION ".$companysql2.") AS T ";
                                        }
                                        
                                        if(trim($advisorsearchstring_legal)!="" || trim($advisorsearchstring_trans)!="")
                                        {
                                                $searchtype=" group by year(DealDate)";
                                        }
                                        else {
                                                $searchtype=") AS T group by year(DealDate)";
                                        }                                                                
                                      
                                        if(($searchtype!== "") )
                                        {
                                                $companysql = $companysql .$searchtype;
                                               // $aggsql = $aggsql . $wheredates ." and ";
                                                $bool=true;
                                        }
					$compRangeSql .= $companysql."#";  
                                       // echo  "<br><br>".$compRangeSql;
                                     }
                                        $compRangeSql = urlencode($compRangeSql);
                                }
                                
                            // echo $companysql; 
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
//echo $companysql;	
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
      <td><div class="result-cnt">
        <?php
    
if($VCFlagValueString == '0-1')
{
?>
        <div id="sec-header">
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td class="investment-form"><h3>Types</h3>
                <label>
                <input class="typeoff-nav20" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/>
                Year On year</label>
                <label>
                <input class="typeoff-nav20" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />
                Industry</label>
                <label>
                <input class="typeoff-nav20" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>
                Range</label>
                <label>
                <input class="typeoff-nav20" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>
                Investor Type</label>
                
              </td>
            </tr>
          </table>
        </div>
        <?php
}
else if($VCFlagValueString == '0-0')
{
?>
        <div id="sec-header">
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td class="investment-form"><h3>Types</h3>
                <label>
                <input class="typeoff-nav21" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/>
                Year On year</label>
                <label>
                <input class="typeoff-nav21" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />
                Industry</label>
                <label>
                <input class="typeoff-nav21" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>
                Range</label>
                <label>
                <input class="typeoff-nav21" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>
                Investor Type</label>
              </td>
            </tr>
          </table>
        </div>
        <?php     
}
else if($VCFlagValueString == '1-0')
{
?>
        <div id="sec-header">
          <table cellpadding="0" cellspacing="0">
            <tr>
              <td class="investment-form"><h3>Types</h3>
                <label>
                <input class="typeoff-nav22" name="typeoff" type="radio"  value="1"  <?php if($type==1) { ?> checked="checked" <?php } ?>/>
                Year On year</label>
                <label>
                <input class="typeoff-nav22" name="typeoff" type="radio"  value="2" <?php if($type==2) { ?> checked="checked" <?php } ?> />
                Industry</label>
                <label>
                <input class="typeoff-nav22" name="typeoff" type="radio" value="4" <?php if($type==4) { ?> checked="checked" <?php } ?>/>
                Range</label>
                <label>
                <input class="typeoff-nav22" name="typeoff" type="radio" value="5" <?php if($type==5) { ?> checked="checked" <?php } ?>/>
                Investor Type</label>
              </td>
            </tr>
          </table>
        </div>
        <?php     
}
?>
        <div class="profile-view-title">
          <?php 
 if($type==1 && $hide_pms==1)
 {
 ?>
          <h2>Public Market Sales - Year on Year</h2>
          <?php
 }
 elseif($type==2 && $hide_pms==1)
 {
     ?>
          <h2>Public Market Sales - By Industry</h2>
          <?php
 }
 
  elseif($type==4 && $hide_pms==1)
 {
     ?>
          <h2>Public Market Sales - By Range</h2>
          <?php
 }
 elseif($type==5 && $hide_pms==1)
 {
     ?>
          <h2>Public Market Sales - By Investor</h2>
          <?php
 } 
 elseif($type==7 && $hide_pms==1)
 {
     ?>
          <h2>Public Market Sales - By Type</h2>
          <?php
 } 
 else if($type==1 && $vcflagValue==0)
 {
 ?>
          <h2>M&A(PE) - Year on Year</h2>
          <?php
 }
 elseif($type==2 && $vcflagValue==0)
 {
     ?>
          <h2>M&A(PE) - By Industry</h2>
          <?php
 }
 
  elseif($type==4 && $vcflagValue==0)
 {
     ?>
          <h2>M&A(PE) - By Range</h2>
          <?php
 }
  elseif($type==5 && $vcflagValue==0)
 {
     ?>
          <h2>M&A(PE) - By Investor</h2>
          <?php
 } 
 else if($type==1 && $vcflagValue==1)
 {
 ?>
          <h2>M&A(VC) - Year on Year</h2>
          <?php
 }
 elseif($type==2 && $vcflagValue==1)
 {
     ?>
          <h2>M&A(VC) - By Industry</h2>
          <?php
 }
 
  elseif($type==4 && $vcflagValue==1)
 {
     ?>
          <h2>M&A(VC) - By Range</h2>
          <?php
 }
  elseif($type==5 && $vcflagValue==1)
 {
     ?>
          <h2>M&A(VC) - By Investor</h2>
          <?php
 } 
 ?>
        </div>
        <br>
      </td>
      <? 
    }
    ?>
    </tr>
  </table>
</div>
<div class=""></div>
