<?php 
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
      
       $searchallfield = $_REQUEST['search'];
       $section = $_REQUEST['section'];
       $filed_name = $_REQUEST['filed_name'];
       
       $sectionList=$Response=array();
       
       // Investment section
       $sectionList[]='PE-Inv';
       $sectionList[]='PE-Inv-Cleantech';
       $sectionList[]='PE-Inv-Infrastructure';       
       
       
       $sectionList[]='VC-Inv';
       $sectionList[]='VC-Inv-Angel';
       $sectionList[]='VC-Inv-Incubations';
       $sectionList[]='VC-Inv-Social';
       
       
       // Exit section
       $sectionList[]='PE-Exits-MA';
       $sectionList[]='PE-Exits-PublicMarket';
       $sectionList[]='PE-Exits-IPO';
       
       
       
       $sectionList[]='VC-Exits-MA';
       $sectionList[]='VC-Exits-PublicMarket';
       $sectionList[]='VC-Exits-IPO';
      
       
       ///////////////////////////////
       /*
          if($getyear !='')
        {
            $getdt1 = $getyear.'-01-01';
            $getdt2 = $getyear.'-12-31';
            //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
        }
        if($getsy !='' && $getey !='')
        {
            $getdt1 = $getsy.'-01-01';
            $getdt2 = $getey.'-12-31';
            //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
        }
        if($getindus !='')
        { 
            $isql="select industryid,industry from industry where industry='".$getindus."'" ;
            $irs=mysql_query($isql);
            $irow=mysql_fetch_array($irs);
            $geti = $irow['industryid'];
            $getind=" and pec.industry=".$geti;
        }
         if($getstage !='')
        { 
            $ssql="select StageId,Stage from stage where Stage='".$getstage."'" ;
            $srs=mysql_query($ssql);
            $srow=mysql_fetch_array($srs);
            $gets = $srow['StageId'];
            $getst=" and pe.StageId=" .$gets;
        }
        * 
        */
       ///////////////////////////////
       
       
       
       
       
       
       if(($key = array_search($section, $sectionList)) !== false) {
            unset($sectionList[$key]);
            
        }
       
        
        //print_r($sectionList); exit;
        
        
        
        // Start Investments 
        if(in_array('PE-Inv', $sectionList) ){
            
            $PE_Inv_Count = PE_Inv($searchallfield,$filed_name);
            if($PE_Inv_Count>0){
            $Response['sections']['PE-Inv']['count'] = $PE_Inv_Count; 
            $Response['sections']['PE-Inv']['section'] = 'PE-Investments'; 
            $Response['sections']['PE-Inv']['html'] = '<a href="index.php?value=0" class="other_db_link" data-search_val="'.$searchallfield.'">PE-Investments</a>'; 
            }
        }        
        if(in_array('PE-Inv-Cleantech', $sectionList) ){
            $PE_Inv_Cleantech_Count = PE_Inv_Cleantech($searchallfield,$filed_name);
            if($PE_Inv_Cleantech_Count>0){
            $Response['sections']['PE-Inv-Cleantech']['count'] = $PE_Inv_Cleantech_Count; 
            $Response['sections']['PE-Inv-Cleantech']['section'] = 'PE-Cleantech'; 
            $Response['sections']['PE-Inv-Cleantech']['html'] = '<a href="svindex.php?value=4" class="other_db_link" data-search_val="'.$searchallfield.'">PE-Cleantech</a>';
            }
        }        
        if(in_array('PE-Inv-Infrastructure', $sectionList) ){
            $PE_Inv_Infrastructure_Count = PE_Inv_Infrastructure($searchallfield,$filed_name);
            if($PE_Inv_Infrastructure_Count>0){
            $Response['sections']['PE-Inv-Infrastructure']['count'] = $PE_Inv_Infrastructure_Count; 
            $Response['sections']['PE-Inv-Infrastructure']['section'] = 'PE-Infrastructure'; 
            $Response['sections']['PE-Inv-Infrastructure']['html'] = '<a href="svindex.php?value=5" class="other_db_link" data-search_val="'.$searchallfield.'">PE-Infrastructure</a>';
            }
        }        
        if(in_array('VC-Inv', $sectionList) ){
            $VC_Inv_Count = VC_Inv($searchallfield,$filed_name);
            if($VC_Inv_Count>0){
            $Response['sections']['VC-Inv']['count'] = $VC_Inv_Count; 
            $Response['sections']['VC-Inv']['section'] = 'VC-Investments'; 
            $Response['sections']['VC-Inv']['html'] = '<a href="index.php?value=1" class="other_db_link" data-search_val="'.$searchallfield.'">VC-Investments</a>';
            }
        }       
        if(in_array('VC-Inv-Angel', $sectionList) ){
            $VC_Inv_Angel_Count = VC_Inv_Angel($searchallfield,$filed_name);
            if($VC_Inv_Angel_Count>0){
            $Response['sections']['VC-Inv-Angel']['count'] = $VC_Inv_Angel_Count; 
            $Response['sections']['VC-Inv-Angel']['section'] = 'VC-Angel'; 
            $Response['sections']['VC-Inv-Angel']['html'] = '<a href="angelindex.php" class="other_db_link" data-search_val="'.$searchallfield.'">Angel Investments</a>';
            }
        }        
        if(in_array('VC-Inv-Incubations', $sectionList) ){
            $VC_Inv_Incubations_Count = VC_Inv_Incubations($searchallfield,$filed_name);
            if($VC_Inv_Incubations_Count>0){
            $Response['sections']['VC-Inv-Incubations']['count'] = $VC_Inv_Incubations_Count; 
            $Response['sections']['VC-Inv-Incubations']['section'] = 'VC-Incubations'; 
            $Response['sections']['VC-Inv-Incubations']['html'] = '<a href="incindex.php" class="other_db_link" data-search_val="'.$searchallfield.'">Incubation</a>';
            }
        }        
        if(in_array('VC-Inv-Social', $sectionList) ){
            $VC_Inv_Social_Count = VC_Inv_Social($searchallfield,$filed_name);
            if($VC_Inv_Social_Count>0){
            $Response['sections']['VC-Inv-Social']['count'] = $VC_Inv_Social_Count; 
            $Response['sections']['VC-Inv-Social']['section'] = 'VC-Social'; 
            $Response['sections']['VC-Inv-Social']['html'] = '<a href="svindex.php?value=3" class="other_db_link" data-search_val="'.$searchallfield.'">VC-Social</a>';
            }
        }
       // Start Exits 
        if(in_array('PE-Exits-MA', $sectionList) ){

             $PE_Exits_MA_Count = PE_Exits_MA($searchallfield,$filed_name);
             if($PE_Exits_MA_Count>0){
             $Response['sections']['PE-Exits-MA']['count'] = $PE_Exits_MA_Count; 
             $Response['sections']['PE-Exits-MA']['section'] = 'PE-Exits-MA'; 
             $Response['sections']['PE-Exits-MA']['html'] = '<a href="mandaindex.php?value=0-0" class="other_db_link" data-search_val="'.$searchallfield.'">PE-Exits M&A</a>'; 
             }
         }  
        if(in_array('PE-Exits-PublicMarket', $sectionList) ){

             $PE_Exits_PublicMarket_Count = PE_Exits_PublicMarket($searchallfield,$filed_name);
             if($PE_Exits_PublicMarket_Count>0){
             $Response['sections']['PE-Exits-PublicMarket']['count'] = $PE_Exits_PublicMarket_Count; 
             $Response['sections']['PE-Exits-PublicMarket']['section'] = 'PE-Exits-Public Market'; 
             $Response['sections']['PE-Exits-PublicMarket']['html'] = '<a href="mandaindex.php?value=0-1" class="other_db_link" data-search_val="'.$searchallfield.'">PE-Exits PublicMarket</a>'; 
             }
         }  
        if(in_array('PE-Exits-IPO', $sectionList) ){

             $PE_Exits_IPO_Count = PE_Exits_IPO($searchallfield,$filed_name);
             if($PE_Exits_IPO_Count>0){
             $Response['sections']['PE-Exits-IPO']['count'] = $PE_Exits_IPO_Count; 
             $Response['sections']['PE-Exits-IPO']['section'] = 'PE-Exits-IPO'; 
             $Response['sections']['PE-Exits-IPO']['html'] = '<a href="ipoindex.php?value=0" class="other_db_link" data-search_val="'.$searchallfield.'">PE-Exits IPO</a>'; 
             }
         }  
        if(in_array('VC-Exits-MA', $sectionList) ){

             $VC_Exits_MA_Count = VC_Exits_MA($searchallfield,$filed_name);
             if($VC_Exits_MA_Count>0){
             $Response['sections']['VC-Exits-MA']['count'] = $VC_Exits_MA_Count; 
             $Response['sections']['VC-Exits-MA']['section'] = 'VC-Exits-MA'; 
             $Response['sections']['VC-Exits-MA']['html'] = '<a href="mandaindex.php?value=1-0" class="other_db_link" data-search_val="'.$searchallfield.'">VC-Exits M&A</a>'; 
             }
         }  
        if(in_array('VC-Exits-PublicMarket', $sectionList) ){

             $VC_Exits_PublicMarket_Count = VC_Exits_PublicMarket($searchallfield,$filed_name);
             if($VC_Exits_PublicMarket_Count>0){
             $Response['sections']['VC-Exits-PublicMarket']['count'] = $VC_Exits_PublicMarket_Count; 
             $Response['sections']['VC-Exits-PublicMarket']['section'] = 'VC-Exits-Public Market'; 
             $Response['sections']['VC-Exits-PublicMarket']['html'] = '<a href="mandaindex.php?value=1-1" class="other_db_link" data-search_val="'.$searchallfield.'">VC-Exits PublicMarket</a>'; 
             }
         }  
        if(in_array('VC-Exits-IPO', $sectionList) ){

             $VC_Exits_IPO_Count = VC_Exits_IPO($searchallfield,$filed_name);
             if($VC_Exits_IPO_Count>0){
             $Response['sections']['VC-Exits-IPO']['count'] = $VC_Exits_IPO_Count; 
             $Response['sections']['VC-Exits-IPO']['section'] = 'VC-Exits-IPO'; 
             $Response['sections']['VC-Exits-IPO']['html'] = '<a href="ipoindex.php?value=1" class="other_db_link" data-search_val="'.$searchallfield.'">VC-Exits IPO</a>'; 
             }
         } 
       
       // Start Investments        
       function PE_Inv($searchallfield,$filed_name='') {
           
        
			
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
				
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                $dbTypeSV="SV";
                                $addVCFlagqry = " and pec.industry !=15 ";
                                $addDelind="";
                                if($filed_name==''){
                                    $companysql="SELECT distinct pe.PECompanyId as PECompanyId 
                                        FROM peinvestments AS pe, industry AS i,
                                    pecompanies AS pec,stage as s,
                                    peinvestments_investors as peinv_invs,peinvestors as invs
                                    WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                    AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                    OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or invs.investor like '$searchallfield%')
                                    AND pe.PEId NOT
                                    IN (
                                    SELECT PEId
                                    FROM peinvestments_dbtypes AS db
                                    WHERE DBTypeId =  '$dbTypeSV'
                                    AND hide_pevc_flag =1
                                    ) GROUP BY pe.PEId";
                                }else if($filed_name=='investor'){
                                    $companysql="SELECT distinct pe.PECompanyId as PECompanyId 
                                        FROM peinvestments AS pe, industry AS i,
                                    pecompanies AS pec,stage as s,
                                    peinvestments_investors as peinv_invs,peinvestors as invs
                                    WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                    AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( invs.investor like '$searchallfield%' )
                                    AND pe.PEId NOT
                                    IN (
                                    SELECT PEId
                                    FROM peinvestments_dbtypes AS db
                                    WHERE DBTypeId =  '$dbTypeSV'
                                    AND hide_pevc_flag =1
                                    ) GROUP BY pe.PEId";
                                }else if($filed_name=='company'){
                                    $companysql="SELECT distinct pe.PECompanyId as PECompanyId 
                                        FROM peinvestments AS pe, industry AS i,
                                    pecompanies AS pec,stage as s,
                                    peinvestments_investors as peinv_invs,peinvestors as invs
                                    WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                    AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                    OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or invs.investor like '$searchallfield%')
                                    AND pe.PEId NOT
                                    IN (
                                    SELECT PEId
                                    FROM peinvestments_dbtypes AS db
                                    WHERE DBTypeId =  '$dbTypeSV'
                                    AND hide_pevc_flag =1
                                    ) GROUP BY pe.PEId";
                                }else if($filed_name=='sector'){
                                            $sector_sql = array();
                                            $sector_sql[] = " sector_business = '$searchallfield' ";
                                            $sector_sql[] = " sector_business LIKE '$searchallfield(%' ";
                                            $sector_sql[] = " sector_business LIKE '$searchallfield (%' ";
                                            $sectorFilter = implode(" OR ", $sector_sql);
                                    $companysql="SELECT distinct pe.PECompanyId as PECompanyId 
                                        FROM peinvestments AS pe, industry AS i,
                                    pecompanies AS pec,stage as s,
                                    peinvestments_investors as peinv_invs,peinvestors as invs
                                    WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                    AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( $sectorFilter )
                                    AND pe.PEId NOT
                                    IN (
                                    SELECT PEId
                                    FROM peinvestments_dbtypes AS db
                                    WHERE DBTypeId =  '$dbTypeSV'
                                    AND hide_pevc_flag =1
                                    ) GROUP BY pe.PEId";
                                }else if($filed_name=='alegal' || $filed_name=='atrans'){
                                    if( $filed_name=='alegal'){
                                        $AdvisorType = 'L';
                                    }else{
                                        $AdvisorType = 'T';                                        
                                    }
                                    $companysql="(
                                        SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,
                                        cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
                                        (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                        FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
                                        peinvestments_advisorinvestors AS adac,stage as s WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND   pe.Deleted=0 and pec.industry = i.industryid
                                        AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
                                        AND adac.PEId = pe.PEId " .$addVCFlagqry. " ".$addDelind." AND cia.cianame LIKE '%$searchallfield%'  and AdvisorType='$AdvisorType'
                                        AND pe.PEId NOT
                                        IN (
                                        SELECT PEId
                                        FROM peinvestments_dbtypes AS db
                                        WHERE DBTypeId = '$dbTypeSV'
                                        AND hide_pevc_flag =1
                                        ) $comp_industry_id_where GROUP BY pe.PEId  )
                                        UNION (
                                        SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,
                                         cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
                                        (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                        FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
                                        peinvestments_advisorcompanies AS adac,stage as s WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND pe.Deleted=0 and pec.industry = i.industryid
                                        AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
                                        AND adac.PEId = pe.PEId " .$addVCFlagqry. " ".$addDelind." AND cia.cianame LIKE '%$searchallfield%'  and AdvisorType='$AdvisorType'
                                        AND pe.PEId NOT
                                        IN (
                                        SELECT PEId
                                        FROM peinvestments_dbtypes AS db
                                        WHERE DBTypeId = '$dbTypeSV'
                                        AND hide_pevc_flag =1
                                        ) 
                                        $comp_industry_id_where                 
                                        GROUP BY pe.PEId )";
                                }
                                
                                $query = mysql_query($companysql);
                                return $count = mysql_num_rows($query);
                                
			
                        
       }
       function PE_Inv_Cleantech($searchallfield,$filed_name='') {
           
        
			
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
				
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                $dbtype='CT';
                                $addVCFlagqry = " and pec.industry!=15 ";
                                $addDelind="";
                                
                            if($filed_name==''){
                                $companysql="SELECT pe.PECompanyId as companyid 
                                                                 FROM peinvestments AS pe, industry AS i,
                                pecompanies AS pec,stage as s,peinvestments_dbtypes as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'   AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%') 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                            }else if($filed_name=='investor'){
                               $companysql= "select peinv.PECompanyId as companyid  FROM peinvestments_investors as peinv_inv,peinvestors as inv 
                                            WHERE peinv_inv.PEId=peinv.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor FROM peinvestments AS peinv, pecompanies as pec,industry AS i,stage as s,country as c,investortype as it,region as r , 
                                    peinvestments_dbtypes as pedb, peinvestments_investors as peinv_inv,peinvestors as inv WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid and
                             s.StageId=peinv.StageId and c.countryid=pec.countryid and it.InvestorType=peinv.InvestorType and AggHide=0 and peinv.Deleted=0  and pedb.PEId=peinv.PEId and pedb.DBTypeId='$dbtype'
                            and peinv.PEId=peinv_inv.PEId and r.RegionId=pec.RegionId
                            and pec.PECompanyId=peinv.PECompanyId " .$addVCFlagqry." ".$addDelind." AND inv.Investor like '$searchallfield'
                                            and peinv_inv.PEId=peinv.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY peinv.PEId ";
                            }else if($filed_name=='company'){
                                $companysql="SELECT pe.PECompanyId as companyid 
                                                                 FROM peinvestments AS pe, industry AS i,
                                pecompanies AS pec,stage as s,peinvestments_dbtypes as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'   AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( pec.companyname LIKE '%$searchallfield%' ) 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                            }else if($filed_name=='sector'){
                                $sector_sql = array();
                                $sector_sql[] = " sector_business = '$searchallfield' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield(%' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield (%' ";
                                $sectorFilter = implode(" OR ", $sector_sql);
                                
                                $companysql="SELECT pe.PECompanyId as companyid 
                                                                 FROM peinvestments AS pe, industry AS i,
                                pecompanies AS pec,stage as s,peinvestments_dbtypes as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'   AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( $sectorFilter ) 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                            }else if($filed_name=='alegal' || $filed_name=='atrans'){
                                if( $filed_name=='alegal'){
                                    $AdvisorType = 'L';
                                }else{
                                    $AdvisorType = 'T';                                        
                                }
                                $companysql="(
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount, cia.CIAId, cia.Cianame,
                                 adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,
                                 GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac,stage as s ,peinvestments_dbtypes as pedb,
                                peinvestments_investors as peinv_inv,peinvestors as inv
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND adac.PEId = pe.PEId " .$addVCFlagqry. " ".$addDelind." 
				AND cia.cianame LIKE '$searchallfield%' and AdvisorType='$AdvisorType'  
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId 
				)
				UNION (
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount, cia.CIAId, cia.Cianame,
                                 adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,
                                 GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac,stage as s,peinvestments_dbtypes as pedb,
                                peinvestments_investors as peinv_inv,peinvestors as inv
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				AND adac.PEId = pe.PEId " .$addVCFlagqry. " ".$addDelind." 
				AND cia.cianame LIKE '$searchallfield%' and AdvisorType='$AdvisorType' 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId 
				)  ";
                            }
                                
                               // echo $companysql; exit;
                               
                                
                                
                                $query = mysql_query($companysql);
                                return $count = mysql_num_rows($query);
                                
			
                        
       }
       function PE_Inv_Infrastructure($searchallfield,$filed_name='') {
           
        
			
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
				
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                $dbtype='IF';
                                $addVCFlagqry = " and pec.industry!=15 ";
                                $addDelind="";
                                
                            if($filed_name==''){
                                $companysql="SELECT pe.PECompanyId as companyid
                                                                 FROM peinvestments AS pe, industry AS i,
                                pecompanies AS pec,stage as s,peinvestments_dbtypes as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'   AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%') 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                            }else if($filed_name=='investor'){
                                $companysql="SELECT pe.PECompanyId as companyid
                                                                 FROM peinvestments AS pe, industry AS i,
                                pecompanies AS pec,stage as s,peinvestments_dbtypes as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'   AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND (inv.Investor LIKE '%$searchallfield%') 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                            } else if($filed_name=='company'){
                                $companysql="SELECT pe.PECompanyId as companyid
                                                                 FROM peinvestments AS pe, industry AS i,
                                pecompanies AS pec,stage as s,peinvestments_dbtypes as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'   AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( pec.companyname LIKE '%$searchallfield%' ) 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                            }else if($filed_name=='sector'){
                                $sector_sql = array();
                                $sector_sql[] = " sector_business = '$searchallfield' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield(%' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield (%' ";
                                $sectorFilter = implode(" OR ", $sector_sql);
                                $companysql="SELECT pe.PECompanyId as companyid
                                                                 FROM peinvestments AS pe, industry AS i,
                                pecompanies AS pec,stage as s,peinvestments_dbtypes as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'   AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( $sectorFilter ) 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                            }else if($filed_name=='alegal' || $filed_name=='atrans'){
                                if( $filed_name=='alegal'){
                                    $AdvisorType = 'L';
                                }else{
                                    $AdvisorType = 'T';                                        
                                }
                                $companysql="(
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount, cia.CIAId, cia.Cianame,
                                 adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,
                                 GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac,stage as s ,peinvestments_dbtypes as pedb,
                                peinvestments_investors as peinv_inv,peinvestors as inv
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND adac.PEId = pe.PEId " .$addVCFlagqry. " ".$addDelind." 
				AND cia.cianame LIKE '$searchallfield%' and AdvisorType='$AdvisorType'  
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId 
				)
				UNION (
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount, cia.CIAId, cia.Cianame,
                                 adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,
                                 GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac,stage as s,peinvestments_dbtypes as pedb,
                                peinvestments_investors as peinv_inv,peinvestors as inv
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				AND adac.PEId = pe.PEId " .$addVCFlagqry. " ".$addDelind." 
				AND cia.cianame LIKE '$searchallfield%' and AdvisorType='$AdvisorType' 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId 
				)  ";
                            }
                                
                               // echo $companysql; exit;
                               
                                
                                
                                $query = mysql_query($companysql);
                                return $count = mysql_num_rows($query);
                                
			
                        
       }           
       function VC_Inv($searchallfield,$filed_name='') {
           
        
			
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
				
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                $dbTypeSV="SV";
                                $addVCFlagqry = " and pec.industry!=15  and s.VCview=1 and pe.amount <=20 ";
                                $addDelind="";
                            if($filed_name==''){    
				$companysql="SELECT distinct pe.PECompanyId as PECompanyId
                                     FROM peinvestments AS pe, industry AS i,
				pecompanies AS pec,stage as s,
                                peinvestments_investors as peinv_invs,peinvestors as invs
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
				AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
				OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' or invs.investor like '$searchallfield%')
				AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                ) GROUP BY pe.PEId";
                            }else if($filed_name=='investor'){
                                $companysql="SELECT distinct pe.PECompanyId as PECompanyId
                                     FROM peinvestments AS pe, industry AS i,
				pecompanies AS pec,stage as s,
                                peinvestments_investors as peinv_invs,peinvestors as invs
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
				AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( invs.investor like '$searchallfield%')
				AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                ) GROUP BY pe.PEId";
                            }else if($filed_name=='company'){
                                $companysql="SELECT distinct pe.PECompanyId as PECompanyId
                                     FROM peinvestments AS pe, industry AS i,
				pecompanies AS pec,stage as s,
                                peinvestments_investors as peinv_invs,peinvestors as invs
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
				AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( pec.companyname LIKE '%$searchallfield%' )
				AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                ) GROUP BY pe.PEId";
                            }else if($filed_name=='sector'){
                                $sector_sql = array();
                                $sector_sql[] = " sector_business = '$searchallfield' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield(%' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield (%' ";
                                $sectorFilter = implode(" OR ", $sector_sql);
				$companysql="SELECT distinct pe.PECompanyId as PECompanyId
                                     FROM peinvestments AS pe, industry AS i,
				pecompanies AS pec,stage as s,
                                peinvestments_investors as peinv_invs,peinvestors as invs
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
				AND invs.InvestorId=peinv_invs.InvestorId and pe.PEId=peinv_invs.PEId and pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( $sectorFilter )
				AND pe.PEId NOT
                                IN (
                                SELECT PEId
                                FROM peinvestments_dbtypes AS db
                                WHERE DBTypeId =  '$dbTypeSV'
                                AND hide_pevc_flag =1
                                ) GROUP BY pe.PEId";
                            }else if($filed_name=='alegal' || $filed_name=='atrans'){
                                    if( $filed_name=='alegal'){
                                        $AdvisorType = 'L';
                                    }else{
                                        $AdvisorType = 'T';                                        
                                    }
                                    $companysql="(
                                        SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,
                                        cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
                                        (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                        FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
                                        peinvestments_advisorinvestors AS adac,stage as s WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND   pe.Deleted=0 and pec.industry = i.industryid
                                        AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
                                        AND adac.PEId = pe.PEId " .$addVCFlagqry. " ".$addDelind." AND cia.cianame LIKE '%$searchallfield%'  and AdvisorType='$AdvisorType'
                                        AND pe.PEId NOT
                                        IN (
                                        SELECT PEId
                                        FROM peinvestments_dbtypes AS db
                                        WHERE DBTypeId = '$dbTypeSV'
                                        AND hide_pevc_flag =1
                                        ) $comp_industry_id_where GROUP BY pe.PEId  )
                                        UNION (
                                        SELECT pe.PEId,pe.PECompanyId as PECompanyId, pec.companyname, i.industry as industry, pec.sector_business as sector_business, pe.amount,
                                         cia.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,pe.Exit_Status,
                                        (SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                        FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
                                        peinvestments_advisorcompanies AS adac,stage as s WHERE dates between '" . $dt1. "' and '" . $dt2 . "' AND pe.Deleted=0 and pec.industry = i.industryid
                                        AND pec.PECompanyId = pe.PECompanyId AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
                                        AND adac.PEId = pe.PEId " .$addVCFlagqry. " ".$addDelind." AND cia.cianame LIKE '%$searchallfield%'  and AdvisorType='$AdvisorType'
                                        AND pe.PEId NOT
                                        IN (
                                        SELECT PEId
                                        FROM peinvestments_dbtypes AS db
                                        WHERE DBTypeId = '$dbTypeSV'
                                        AND hide_pevc_flag =1
                                        ) 
                                        $comp_industry_id_where                 
                                        GROUP BY pe.PEId )";
                                }                                
                                
                                $query = mysql_query($companysql);
                                return $count = mysql_num_rows($query);
                                
			
                        
       }
       function VC_Inv_Angel($searchallfield,$filed_name='') {
           
        
			
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
				
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                $addVCFlagqry = " and pec.industry !=15 ";
                                $addDelind="";
                              
                            if($filed_name==''){
                                $companysql="SELECT pe.AngelDealId
                                    FROM angelinvdeals AS pe, industry AS i,    pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
                                WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.InvesteeId 
                                AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId AND 
                                ( pec.region LIKE '$searchallfield%' OR pec.city LIKE '$searchallfield%' OR pec.companyname LIKE '$searchallfield%' OR  sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%' )  GROUP BY pe.AngelDealId ";
                            }else if($filed_name=='investor'){
                                 $companysql="select pe.AngelDealId,pec.PECompanyId,pe.AggHide,pec.companyname,pec.industry,i.industry,sector_business as sector_business,
                peinv_inv.InvestorId,inv.Investor,pe.InvesteeId,pec.industry,
                pec.companyname,DATE_FORMAT( pe.DealDate, '%M-%Y' ) as dealperiod,i.industry,pe.Dealdate as Dealdate, 
                ( SELECT GROUP_CONCAT(p.Investor  ORDER BY Investor='others') from peinvestors p JOIN  angel_investors a ON  a.InvestorId=p.InvestorId where  a.AngelDealId =pe.AngelDealId  ) AS  Investor 
                from angel_investors as peinv_inv,peinvestors as inv,
                angelinvdeals as pe,pecompanies as pec,industry as i
                where DealDate between '" . $dt1. "' and '" . $dt2 . "' and  inv.InvestorId=peinv_inv.InvestorId and pec.industry = i.industryid  and pe.Deleted=0
                and pe.AngelDealId=peinv_inv.AngelDealId and pec.PECompanyId=pe.InvesteeId " .$addVCFlagqry." ".$addDelind." AND
                inv.investor like '$searchallfield%'  GROUP BY pe.AngelDealId ";
                            }else if($filed_name=='company'){
                                 $companysql="SELECT pe.AngelDealId
                                    FROM angelinvdeals AS pe, industry AS i,    pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
                                WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.InvesteeId 
                                AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId AND 
                                ( pec.companyname LIKE '$searchallfield%' )  GROUP BY pe.AngelDealId ";
                            }else if($filed_name=='sector'){
                                $sector_sql = array();
                                $sector_sql[] = " sector_business = '$searchallfield' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield(%' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield (%' ";
                                $sectorFilter = implode(" OR ", $sector_sql);
                                $companysql="SELECT pe.AngelDealId
                                    FROM angelinvdeals AS pe, industry AS i,    pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
                                WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.InvesteeId 
                                AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId AND 
                                ( $sectorFilter )  GROUP BY pe.AngelDealId ";                                
                            } 
                                $query = mysql_query($companysql);
                                return $count = mysql_num_rows($query);
                                
			
                        
       }                 
       function VC_Inv_Incubations($searchallfield,$filed_name='') {
           
        
			
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
				
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                $addVCFlagqry = " and pec.industry !=15 ";
                                $addDefunctqry=" and Defunct=0 ";
                                $addDelind="";
                              
                                 $datefilter=" date_month_year between '" . $dt1. "' and '" . $dt2 . "' AND  ";
                            if($filed_name==''){
                                $companysql="SELECT pe.IncDealId
                                        FROM incubatordeals AS pe, industry AS i,pecompanies AS pec,incubators as inc
                                        WHERE $datefilter pec.industry = i.industryid AND pec.PEcompanyID = pe.IncubateeId and  inc.IncubatorId=pe.IncubatorId
                                        AND pe.Deleted =0 " .$addVCFlagqry .$addDefunctqry.  " ".$addDelind."  AND ( pec.AdCity LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%' or sector_business LIKE '$searchallfield%'
                                        or MoreInfor LIKE '%$searchallfield%'  or Incubator LIKE '%$searchallfield%' ) "; 
                            }else if($filed_name=='investor'){
                                $companysql="select pe.IncDealId,pe.IncubateeId,pec.companyname,pec.industry,i.industry,pec.sector_business  as sector_business,Individual,
                                        pe.IncubatorId,inc.Incubator,pec.PECompanyid as companyid , pe.date_month_year
                                        from incubatordeals as pe,pecompanies as pec,industry as i ,incubators as inc 
                                        where $datefilter pec.industry = i.industryid and  inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 
                                        and pec.PECompanyId=pe.IncubateeId " .$addVCFlagqry.$addDefunctqry. " ".$addDelind." AND inc.Incubator like '$searchallfield%' ";   
                            }else if($filed_name=='company'){
                                $companysql="SELECT pe.IncDealId
                                        FROM incubatordeals AS pe, industry AS i,pecompanies AS pec,incubators as inc
                                        WHERE $datefilter pec.industry = i.industryid AND pec.PEcompanyID = pe.IncubateeId and  inc.IncubatorId=pe.IncubatorId
                                        AND pe.Deleted =0 " .$addVCFlagqry .$addDefunctqry.  " ".$addDelind."  AND ( pec.companyname LIKE '%$searchallfield%' ) "; 
                            }else if($filed_name=='sector'){
                                $sector_sql = array();
                                $sector_sql[] = " sector_business = '$searchallfield' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield(%' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield (%' ";
                                $sectorFilter = implode(" OR ", $sector_sql);
                                $companysql="SELECT pe.IncDealId
                                        FROM incubatordeals AS pe, industry AS i,pecompanies AS pec,incubators as inc
                                        WHERE $datefilter pec.industry = i.industryid AND pec.PEcompanyID = pe.IncubateeId and  inc.IncubatorId=pe.IncubatorId
                                        AND pe.Deleted =0 " .$addVCFlagqry .$addDefunctqry.  " ".$addDelind."  AND ( $sectorFilter ) "; 
                            }
                                
                                $query = mysql_query($companysql);
                                return $count = mysql_num_rows($query);
                                
			
                        
       }  
       function VC_Inv_Social($searchallfield,$filed_name='') {
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
				
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                $addVCFlagqry = " and pec.industry!=15 ";
                                $addDelind="";
                                $dbtype='SV';
                              
                            if($filed_name==''){      
                                $companysql="SELECT pe.PECompanyId as companyid
                                    FROM peinvestments AS pe, industry AS i,
                                pecompanies AS pec,stage as s,peinvestments_dbtypes as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( pec.city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                OR sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%') 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                            }else if($filed_name=='investor'){
                                $companysql="SELECT pe.PECompanyId as companyid
                                    FROM peinvestments AS pe, industry AS i,
                                pecompanies AS pec,stage as s,peinvestments_dbtypes as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( inv.Investor LIKE '%$searchallfield%' ) 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                            }else if($filed_name=='company'){  
                                $companysql="SELECT pe.PECompanyId as companyid
                                    FROM peinvestments AS pe, industry AS i,
                                pecompanies AS pec,stage as s,peinvestments_dbtypes as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( pec.companyname LIKE '%$searchallfield%' ) 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                            }else if($filed_name=='sector'){
                                $sector_sql = array();
                                $sector_sql[] = " sector_business = '$searchallfield' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield(%' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield (%' ";
                                $sectorFilter = implode(" OR ", $sector_sql);
                                $companysql="SELECT pe.PECompanyId as companyid
                                    FROM peinvestments AS pe, industry AS i,
                                pecompanies AS pec,stage as s,peinvestments_dbtypes as pedb,
                                         peinvestments_investors as peinv_inv,peinvestors as inv
                                WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                                and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
                                AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( $sectorFilter ) 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId ";
                            }else if($filed_name=='alegal' || $filed_name=='atrans'){
                                if( $filed_name=='alegal'){
                                    $AdvisorType = 'L';
                                }else{
                                    $AdvisorType = 'T';                                        
                                }
                                $companysql="(
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount, cia.CIAId, cia.Cianame,
                                 adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,
                                 GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorinvestors AS adac,stage as s ,peinvestments_dbtypes as pedb,
                                peinvestments_investors as peinv_inv,peinvestors as inv
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and  pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND adac.PEId = pe.PEId " .$addVCFlagqry. " ".$addDelind." 
				AND cia.cianame LIKE '$searchallfield%' and AdvisorType='$AdvisorType'  
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId 
				)
				UNION (
				SELECT pe.PEId,pe.PECompanyId, pec.companyname, i.industry, pec.sector_business as sector_business, pe.amount, cia.CIAId, cia.Cianame,
                                 adac.CIAId AS AcqCIAId,hideamount,SPV,AggHide,DATE_FORMAT( pe.dates, '%b-%Y' )as dealperiod,pe.dates as dates,
                                 GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
				FROM peinvestments AS pe, pecompanies AS pec, industry AS i, advisor_cias AS cia,
				peinvestments_advisorcompanies AS adac,stage as s,peinvestments_dbtypes as pedb,
                                peinvestments_investors as peinv_inv,peinvestors as inv
				WHERE dates between '" . $dt1. "' and '" . $dt2 . "' and pe.Deleted=0 and pec.industry = i.industryid
				AND pec.PECompanyId = pe.PECompanyId and pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype'
				AND adac.CIAId = cia.CIAID and  pe.StageId=s.StageId
				AND adac.PEId = pe.PEId " .$addVCFlagqry. " ".$addDelind." 
				AND cia.cianame LIKE '$searchallfield%' and AdvisorType='$AdvisorType' 
                                            and peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId 
				)  ";
                            }
                                
                                $query = mysql_query($companysql);
                                return $count = mysql_num_rows($query);
                                
			
                        
       }        
       // Start Exits
       function PE_Exits_MA($searchallfield,$filed_name='') {          
        
			
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
				
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                $var_hideforexit=0;
                            if($filed_name==''){    
				$companysql="SELECT ma.PECompanyId, 
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( co.city LIKE '%$searchallfield%' OR co.companyname LIKE '%$searchallfield%' OR sector_business LIKE '%$searchallfield%'  or  ma.MoreInfor LIKE '%$searchallfield%' or  InvestmentDeals LIKE '%$searchallfield%') group by ma.MandAId";
                            }else if($filed_name=='investor'){
                                $companysql="SELECT ma.PECompanyId, 
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( investor.Investor LIKE '%$searchallfield%' ) group by ma.MandAId";
                            }else if($filed_name=='company'){ 
                                $companysql="SELECT ma.PECompanyId, 
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( co.companyname LIKE '%$searchallfield%' ) group by ma.MandAId";
                            }else if($filed_name=='sector'){
                                $sector_sql = array();
                                $sector_sql[] = " sector_business = '$searchallfield' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield(%' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield (%' ";
                                $sectorFilter = implode(" OR ", $sector_sql);
                                $companysql="SELECT ma.PECompanyId, 
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( $sectorFilter) group by ma.MandAId";                                        
                            } else if($filed_name=='alegal' || $filed_name=='atrans'){
                                if( $filed_name=='alegal'){
                                    $AdvisorType = 'L';
                                }else{
                                    $AdvisorType = 'T';                                        
                                }
                                $companysql="(select pe.MandAId,pe.PECompanyId,c.companyname,i.industry,c.sector_business as sector_business,pe.DealAmount,
                                            cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.AcquirerId, ac.Acquirer,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
                                            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                            from manda AS pe, pecompanies AS c, industry AS i,advisor_cias AS cia,peinvestments_advisoracquirer AS adac,acquirers as ac,
                                            dealtypes as dt
                                            where
                                            Deleted=0 and c.industry=i.industryid and ac.AcquirerId=pe.AcquirerId and c.PECompanyId=pe.PECompanyId and adac.CIAId=cia.CIAID and  AdvisorType='$AdvisorType' and 
                                            adac.PEId=pe.MandAId and cia.cianame LIKE '%$searchallfield%' and  GROUP BY pe.MandAId)
                                            UNION
                                            (SELECT pe.MandAId, pe.PECompanyId, c.companyname, i.industry, c.sector_business, pe.DealAmount, cia.CIAId,
                                            cia.cianame, adcomp.CIAId AS CompCIAId, pe.AcquirerId, ac.Acquirer,hideamount ,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
                                            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                            FROM manda AS pe, pecompanies AS c, industry AS i, advisor_cias AS cia,
                                            peinvestments_advisorcompanies AS adcomp, acquirers AS ac ,dealtypes as dt
                                            WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and   Deleted=0 and c.industry = i.industryid
                                            AND ac.AcquirerId = pe.AcquirerId AND c.PECompanyId = pe.PECompanyId
                                            AND adcomp.CIAId = cia.CIAID  and AdvisorType='$AdvisorType'
                                            AND adcomp.PEId = pe.MandAId
                                            AND cianame LIKE '%$searchallfield%' GROUP BY pe.MandAId)  ";
                            }   
                                
                                $query = mysql_query($companysql);
                                return $count = mysql_num_rows($query);
                                
			
                        
       }
       function PE_Exits_PublicMarket($searchallfield,$filed_name='') {          
        
			
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
				
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                $var_hideforexit=1;
                            if($filed_name==''){
				$companysql="SELECT ma.PECompanyId,
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( co.city LIKE '%$searchallfield%' OR co.companyname LIKE '%$searchallfield%' OR sector_business LIKE '%$searchallfield%'  or  ma.MoreInfor LIKE '%$searchallfield%' or  InvestmentDeals LIKE '%$searchallfield%') group by ma.MandAId";
                            }else if($filed_name=='investor'){
                                $companysql="SELECT ma.PECompanyId,
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( investor.Investor LIKE '%$searchallfield%' ) group by ma.MandAId";
                            }else if($filed_name=='company'){
                                $companysql="SELECT ma.PECompanyId,
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( co.companyname LIKE '%$searchallfield%' ) group by ma.MandAId";
                            }else if($filed_name=='sector'){     
                                $sector_sql = array();
                                $sector_sql[] = " sector_business = '$searchallfield' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield(%' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield (%' ";
                                $sectorFilter = implode(" OR ", $sector_sql);       
                                $companysql="SELECT ma.PECompanyId,
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( $sectorFilter) group by ma.MandAId";
                            } else if($filed_name=='alegal' || $filed_name=='atrans'){
                                if( $filed_name=='alegal'){
                                    $AdvisorType = 'L';
                                }else{
                                    $AdvisorType = 'T';                                        
                                }
                                $companysql="(select pe.MandAId,pe.PECompanyId,c.companyname,i.industry,c.sector_business as sector_business,pe.DealAmount,
                                            cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.AcquirerId, ac.Acquirer,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
                                            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                            from manda AS pe, pecompanies AS c, industry AS i,advisor_cias AS cia,peinvestments_advisoracquirer AS adac,acquirers as ac,
                                            dealtypes as dt
                                            where
                                            Deleted=0 and c.industry=i.industryid and ac.AcquirerId=pe.AcquirerId  and c.PECompanyId=pe.PECompanyId and adac.CIAId=cia.CIAID and  AdvisorType='$AdvisorType' and 
                                            adac.PEId=pe.MandAId and cia.cianame LIKE '%$searchallfield%' and  GROUP BY pe.MandAId)
                                            UNION
                                            (SELECT pe.MandAId, pe.PECompanyId, c.companyname, i.industry, c.sector_business, pe.DealAmount, cia.CIAId,
                                            cia.cianame, adcomp.CIAId AS CompCIAId, pe.AcquirerId, ac.Acquirer,hideamount ,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
                                            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                            FROM manda AS pe, pecompanies AS c, industry AS i, advisor_cias AS cia,
                                            peinvestments_advisorcompanies AS adcomp, acquirers AS ac ,dealtypes as dt
                                            WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and   Deleted=0 and c.industry = i.industryid
                                            AND ac.AcquirerId = pe.AcquirerId AND c.PECompanyId = pe.PECompanyId
                                            AND adcomp.CIAId = cia.CIAID  and AdvisorType='$AdvisorType'
                                            AND adcomp.PEId = pe.MandAId
                                            AND cianame LIKE '%$searchallfield%' GROUP BY pe.MandAId)  ";
                            }                                 
                                
                                $query = mysql_query($companysql);
                                return $count = mysql_num_rows($query);
                                
			
                        
       }       
       function PE_Exits_IPO($searchallfield,$filed_name='') {          
        
			
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
				
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                
                                $addVCFlagqry = "" ;
                                $addDelind='';
				$wheredates1='';
                              
                            if($filed_name==''){   
                                $companysql="SELECT pe.PECompanyId as companyid,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                FROM ipos AS pe, industry AS i,
                                pecompanies AS pec,ipo_investors AS peinv_invs, peinvestors AS invs
                                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
                                " AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND (pec.city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
                                OR sector_business LIKE '$searchallfield%' or  MoreInfor LIKE '%$searchallfield%' or  InvestmentDeals LIKE '$searchallfield%' ) and peinv_invs.IPOId=pe.IPOId and invs.InvestorId=peinv_invs.InvestorId  GROUP BY pe.IPOId";
                            }else if($filed_name=='investor'){
                                $companysql="SELECT pe.PECompanyId as companyid,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                FROM ipos AS pe, industry AS i,
                                pecompanies AS pec,ipo_investors AS peinv_invs, peinvestors AS invs
                                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
                                " AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND (invs.Investor LIKE '$searchallfield%' ) and peinv_invs.IPOId=pe.IPOId and invs.InvestorId=peinv_invs.InvestorId  GROUP BY pe.IPOId";
                            }else if($filed_name=='company'){
                                $companysql="SELECT pe.PECompanyId as companyid,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                FROM ipos AS pe, industry AS i,
                                pecompanies AS pec,ipo_investors AS peinv_invs, peinvestors AS invs
                                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
                                " AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( pec.companyname LIKE '$searchallfield%' ) and peinv_invs.IPOId=pe.IPOId and invs.InvestorId=peinv_invs.InvestorId  GROUP BY pe.IPOId";
                            }else if($filed_name=='sector'){     
                                $sector_sql = array();
                                $sector_sql[] = " sector_business = '$searchallfield' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield(%' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield (%' ";
                                $sectorFilter = implode(" OR ", $sector_sql); 
                                $companysql="SELECT pe.PECompanyId as companyid,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                FROM ipos AS pe, industry AS i,
                                pecompanies AS pec,ipo_investors AS peinv_invs, peinvestors AS invs
                                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
                                " AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( $sectorFilter ) and peinv_invs.IPOId=pe.IPOId and invs.InvestorId=peinv_invs.InvestorId  GROUP BY pe.IPOId";
                            }
                                
                                $query = mysql_query($companysql);
                                return $count = mysql_num_rows($query);
                                
			
                        
       }       
       function VC_Exits_MA($searchallfield,$filed_name='') {          
        
			
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
				
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                $var_hideforexit=0;
                            if($filed_name==''){    
				$companysql="SELECT ma.PECompanyId,
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( co.city LIKE '%$searchallfield%' OR co.companyname LIKE '%$searchallfield%' OR sector_business LIKE '%$searchallfield%'  or  ma.MoreInfor LIKE '%$searchallfield%' or  InvestmentDeals LIKE '%$searchallfield%') group by ma.MandAId";
                            }else if($filed_name=='investor'){
                                $companysql="SELECT ma.PECompanyId,
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( investor.Investor LIKE '$searchallfield%') group by ma.MandAId";
                            }else if($filed_name=='company'){
                                $companysql="SELECT ma.PECompanyId,
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15  and VCFlag=1 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( co.companyname LIKE '%$searchallfield%' ) group by ma.MandAId";
                            }else if($filed_name=='sector'){     
                                $sector_sql = array();
                                $sector_sql[] = " sector_business = '$searchallfield' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield(%' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield (%' ";
                                $sectorFilter = implode(" OR ", $sector_sql);  
                                $companysql="SELECT ma.PECompanyId,
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( $sectorFilter ) group by ma.MandAId";
                            } else if($filed_name=='alegal' || $filed_name=='atrans'){
                                if( $filed_name=='alegal'){
                                    $AdvisorType = 'L';
                                }else{
                                    $AdvisorType = 'T';                                        
                                }
                                $companysql="(select pe.MandAId,pe.PECompanyId,c.companyname,i.industry,c.sector_business as sector_business,pe.DealAmount,
                                            cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.AcquirerId, ac.Acquirer,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
                                            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                            from manda AS pe, pecompanies AS c, industry AS i,advisor_cias AS cia,peinvestments_advisoracquirer AS adac,acquirers as ac,
                                            dealtypes as dt
                                            where
                                            Deleted=0 and c.industry=i.industryid and ac.AcquirerId=pe.AcquirerId and c.PECompanyId=pe.PECompanyId and adac.CIAId=cia.CIAID and  AdvisorType='$AdvisorType' and 
                                            adac.PEId=pe.MandAId and cia.cianame LIKE '%$searchallfield%' and  GROUP BY pe.MandAId)
                                            UNION
                                            (SELECT pe.MandAId, pe.PECompanyId, c.companyname, i.industry, c.sector_business, pe.DealAmount, cia.CIAId,
                                            cia.cianame, adcomp.CIAId AS CompCIAId, pe.AcquirerId, ac.Acquirer,hideamount ,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
                                            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                            FROM manda AS pe, pecompanies AS c, industry AS i, advisor_cias AS cia,
                                            peinvestments_advisorcompanies AS adcomp, acquirers AS ac ,dealtypes as dt
                                            WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and   Deleted=0 and c.industry = i.industryid
                                            AND ac.AcquirerId = pe.AcquirerId AND c.PECompanyId = pe.PECompanyId
                                            AND adcomp.CIAId = cia.CIAID  and AdvisorType='$AdvisorType'
                                            AND adcomp.PEId = pe.MandAId
                                            AND cianame LIKE '%$searchallfield%' GROUP BY pe.MandAId)  ";
                            } 
                                
                                
                                $query = mysql_query($companysql);
                                return $count = mysql_num_rows($query);
                                
			
                        
       }
       function VC_Exits_PublicMarket($searchallfield,$filed_name='') {          
        
			
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
				
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                $var_hideforexit=1;
                            if($filed_name==''){    
				$companysql="SELECT ma.PECompanyId,
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( co.city LIKE '%$searchallfield%' OR co.companyname LIKE '%$searchallfield%' OR sector_business LIKE '%$searchallfield%'  or  ma.MoreInfor LIKE '%$searchallfield%' or  InvestmentDeals LIKE '%$searchallfield%') group by ma.MandAId";
                            }else if($filed_name=='investor'){
                                $companysql="SELECT ma.PECompanyId,
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( investor.Investor LIKE '$searchallfield%' ) group by ma.MandAId";
                            }else if($filed_name=='company'){
                                $companysql="SELECT ma.PECompanyId,
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15  and VCFlag=1 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( co.companyname LIKE '%$searchallfield%' ) group by ma.MandAId";
                            } else if($filed_name=='sector'){     
                                $sector_sql = array();
                                $sector_sql[] = " sector_business = '$searchallfield' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield(%' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield (%' ";
                                $sectorFilter = implode(" OR ", $sector_sql);          
                               $companysql="SELECT ma.PECompanyId,
                                                (SELECT GROUP_CONCAT( inv_sub.Investor ORDER BY Investor =  'others' ) FROM manda_investors AS peinv_sub, peinvestors AS inv_sub WHERE peinv_sub.MandAId =ma.MandAId AND inv_sub.InvestorId = peinv_sub.InvestorId) as Investor FROM manda AS ma 
                                            JOIN pecompanies AS co ON co.PECompanyId = ma.PECompanyId
                                            JOIN industry AS ind ON ind.industryid = co.industry
                                            JOIN dealtypes AS dt ON dt.DealTypeId =  ma.DealTypeId
                                            JOIN investortype AS itype ON itype.InvestorType = ma.InvestorType
                                            JOIN manda_investors AS minvestor ON minvestor.MandAId=ma.MandAId
                                            LEFT JOIN peinvestors as investor on investor.InvestorId=minvestor.InvestorId
                                            LEFT JOIN peinvestments_investors as invinv on invinv.InvestorId = minvestor.InvestorId
                                            LEFT JOIN peinvestments as inv on inv.PECompanyId = ma.PECompanyId AND inv.PEId = invinv.PEId
                                            LEFT JOIN acquirers AS acq ON acq.AcquirerId = ma.AcquirerId
                                            where ma.DealDate between '" . $dt1. "' and '" . $dt2 . "' and ma.Deleted=0 and co.industry != 15 and ma.DealTypeId= dt.DealTypeId and dt.hide_for_exit=$var_hideforexit  AND ( $sectorFilter) group by ma.MandAId";
                            } else if($filed_name=='alegal' || $filed_name=='atrans'){
                                if( $filed_name=='alegal'){
                                    $AdvisorType = 'L';
                                }else{
                                    $AdvisorType = 'T';                                        
                                }
                                $companysql="(select pe.MandAId,pe.PECompanyId,c.companyname,i.industry,c.sector_business as sector_business,pe.DealAmount,
                                            cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.AcquirerId, ac.Acquirer,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
                                            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                            from manda AS pe, pecompanies AS c, industry AS i,advisor_cias AS cia,peinvestments_advisoracquirer AS adac,acquirers as ac,
                                            dealtypes as dt
                                            where
                                            Deleted=0 and c.industry=i.industryid and ac.AcquirerId=pe.AcquirerId and c.PECompanyId=pe.PECompanyId and adac.CIAId=cia.CIAID and  AdvisorType='$AdvisorType' and 
                                            adac.PEId=pe.MandAId and cia.cianame LIKE '%$searchallfield%' and  GROUP BY pe.MandAId)
                                            UNION
                                            (SELECT pe.MandAId, pe.PECompanyId, c.companyname, i.industry, c.sector_business, pe.DealAmount, cia.CIAId,
                                            cia.cianame, adcomp.CIAId AS CompCIAId, pe.AcquirerId, ac.Acquirer,hideamount ,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,
                                            (SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                            FROM manda AS pe, pecompanies AS c, industry AS i, advisor_cias AS cia,
                                            peinvestments_advisorcompanies AS adcomp, acquirers AS ac ,dealtypes as dt
                                            WHERE DealDate between '" . $dt1. "' and '" . $dt2 . "' and   Deleted=0 and c.industry = i.industryid
                                            AND ac.AcquirerId = pe.AcquirerId AND c.PECompanyId = pe.PECompanyId
                                            AND adcomp.CIAId = cia.CIAID  and AdvisorType='$AdvisorType'
                                            AND adcomp.PEId = pe.MandAId
                                            AND cianame LIKE '%$searchallfield%' GROUP BY pe.MandAId)  ";
                            } 
                                
                                
                                $query = mysql_query($companysql);
                                return $count = mysql_num_rows($query);
                                
			
                        
       }
       function VC_Exits_IPO($searchallfield,$filed_name='') {          
        
			
                            $month1=01; 
                            $year1 = 1998;
                            $month2= date('n');
                            $year2 = date('Y');
				
                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-31";
                                
                                $addVCFlagqry = " and VCFlag=1 ";
                                $addDelind='';
				$wheredates1='';
                              
                            if($filed_name==''){    
                                $companysql="SELECT pe.PECompanyId as companyid,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                FROM ipos AS pe, industry AS i,
                                pecompanies AS pec,ipo_investors AS peinv_invs, peinvestors AS invs
                                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
                                " AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND (pec.city LIKE '$searchallfield%' or pec.companyname LIKE '$searchallfield%'
                                OR sector_business LIKE '$searchallfield%' or  MoreInfor LIKE '%$searchallfield%' or  InvestmentDeals LIKE '$searchallfield%' ) and peinv_invs.IPOId=pe.IPOId and invs.InvestorId=peinv_invs.InvestorId  GROUP BY pe.IPOId";
                            }else if($filed_name=='investor'){
                                $companysql="SELECT pe.PECompanyId as companyid,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                FROM ipos AS pe, industry AS i,
                                pecompanies AS pec,ipo_investors AS peinv_invs, peinvestors AS invs
                                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
                                " AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND (invs.Investor LIKE '$searchallfield%' ) and peinv_invs.IPOId=pe.IPOId and invs.InvestorId=peinv_invs.InvestorId  GROUP BY pe.IPOId";
                            }else if($filed_name=='company'){
                                $companysql="SELECT pe.PECompanyId as companyid,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                FROM ipos AS pe, industry AS i,
                                pecompanies AS pec,ipo_investors AS peinv_invs, peinvestors AS invs
                                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
                                " AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( pec.companyname LIKE '$searchallfield%' ) and peinv_invs.IPOId=pe.IPOId and invs.InvestorId=peinv_invs.InvestorId  GROUP BY pe.IPOId";
                            }else if($filed_name=='sector'){     
                                $sector_sql = array();
                                $sector_sql[] = " sector_business = '$searchallfield' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield(%' ";
                                $sector_sql[] = " sector_business LIKE '$searchallfield (%' ";
                                $sectorFilter = implode(" OR ", $sector_sql);    
                                $companysql="SELECT pe.PECompanyId as companyid,
                                (SELECT GROUP_CONCAT( inv.Investor ) FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                                FROM ipos AS pe, industry AS i,
                                pecompanies AS pec,ipo_investors AS peinv_invs, peinvestors AS invs
                                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID " .$wheredates1.
                                " AND pe.Deleted =0 " .$addVCFlagqry. " ".$addDelind." AND ( $sectorFilter ) and peinv_invs.IPOId=pe.IPOId and invs.InvestorId=peinv_invs.InvestorId  GROUP BY pe.IPOId";
                            }  
                                
                                $query = mysql_query($companysql);
                                return $count = mysql_num_rows($query);
                                
			
                        
       }
       // End Exits
       
       
       
       if(count($Response)==0){
           $Response['result']=0;
       }else{
           $Response['result']=1;
           $Response['message']='There are matching results for this search in ';
       }

       
        print_r(json_encode($Response));
        mysql_close();
        mysql_close($cnx);
   
        exit;
        
  ?>