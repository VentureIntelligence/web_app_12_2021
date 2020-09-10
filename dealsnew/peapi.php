<?php include_once("../globalconfig.php"); ?>
<?php
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    
    $typepost =    isset($_POST['dealtype']) ? $_POST['dealtype'] : 'INVESTMENTS';
    
    if(strtoupper($typepost) === 'INVESTMENTS'){ //1 for Investment and 2 for Exit (default will be 0/Investment)
        
        $dealType =  1; // INVESTMENT
    }
    elseif(strtoupper($typepost) === 'EXITS'){
        
        $dealType =  2; //  EXITS
    }else{
        $dealType =  1; //  INVESTMENT
    }
    
    $dealCategory = strtoupper(isset($_POST['dealcategory']) ? $_POST['dealcategory'] : 'PE'); //For Investement(1 for PE, and 2 for VC, and 3 for Angel and, 4 for Incubation, and 5 for Social, and 6 for Cleantech, and 7 for Infrasturcture)
                                                                    // For Exit( 8 for M&A,9 for Public Market, 10 for IPO)
    $time = $_POST['time']; // For month 01/2016, for quater 1Q/2016, for year only 2016, default current year.
    
    $companysearch = isset($_POST['company']) ? $_POST['company'] : ''; // For company
    
    $investorsearch = isset($_POST['investor']) ? $_POST['investor'] : ''; // For company
    
    if($companysearch!='' || $investorsearch!=''){
        
        $from_date = "1998-01-01";
        $to_date =  date('Y')."-12-31";
        
    }else{
        
        if($time != ''){
            
            $timeexp = explode('/',$time);

            if(count($timeexp)>1)
            {

                if(preg_match("/[a-zA-Z]/i", $timeexp[0])){

                    if($timeexp[0] == '1Q'){

                        $from_date = $timeexp[1]."-01-01";
                        $to_date = $timeexp[1]."-03-31";

                    }elseif($timeexp[0] == '2Q'){

                        $from_date = $timeexp[1]."-04-01";
                        $to_date = $timeexp[1]."-06-30";

                    }elseif($timeexp[0] == '3Q'){

                        $from_date = $timeexp[1]."-07-01";
                        $to_date = $timeexp[1]."-09-30";

                    }elseif($timeexp[0] == '4Q'){

                        $from_date = $timeexp[1]."-10-01";
                        $to_date = $timeexp[1]."-12-31";

                    }else{

                        echo 'Invalid input.Please provide proper input e.g. 1Q for First Quater/ 2Q for Second Quater/ 3Q for Third Quater/ 4Q for Fourth Quater.';

                    }
                }else{

                    $from_date = $timeexp[1]."-".$timeexp[0]."-01";
                    $to_date = $timeexp[1]."-".$timeexp[0]."-31";

                }
            }else{
                $from_date = $timeexp[0]."-01-01";
                $to_date = $timeexp[0]."-12-31";
            }

        }else{
            
            echo $from_date = "1998-01-01";
            echo $to_date = date('Y')."-12-31";
        }
    }
    
    
    $datatype = isset($_POST['datatype']) ? $_POST['datatype'] : 1; // For Detail 1, for aggregate 2.
    
    $dbTypeSV="SV";
    $dbTypeIF="IF";
    $dbTypeCT="CT";
    
    if($dealType == 1){
       //echo "eeeeeeeeeeee".$dealCategory;
        if($dealCategory == 'PE'){ // for PE Investment
        
            
            if($companysearch != ''){
                    
                $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                $comrs = mysql_query($comsql);
                $comres = mysql_fetch_array($comrs);
                $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";

            }elseif($investorsearch != ''){

                $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                $invrs = mysql_query($invsql);
                $invres = mysql_fetch_array($invrs);
                $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                $investor_from = " ,peinvestments_investors as peinv_invs,peinvestors as invs";
                $investor_where = " and peinv_invs.PEId=pe.PEId and invs.InvestorId=peinv_invs.InvestorId";
            }
            if($datatype == 1){
                
                 $sql = "SELECT pe.PEId FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ".$investor_from."
                        WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID 
                        and pe.StageId=s.StageId ".$investor_where." and pe.Deleted=0 and pec.industry !=15".$company_search.$investor_search." AND pe.PEId NOT
                        IN (
                            SELECT PEId
                            FROM peinvestments_dbtypes AS db
                            WHERE DBTypeId =  '$dbTypeSV'
                            AND hide_pevc_flag =1
                            )  
                        GROUP BY pe.PEId";
            }else{
                
                 $sql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business, amount ,pe.Exit_Status,
                        DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,pe.PEId,pe.hideamount,pe.SPV,pe.AggHide,(SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') FROM peinvestments_investors as peinv_inv,
                        peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                        FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ".$inv_from."
                        WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                        ".$investor_where." and pe.Deleted=0 and pec.industry !=15".$company_search.$investor_search." AND pe.PEId NOT
                        IN (
                            SELECT PEId
                            FROM peinvestments_dbtypes AS db
                            WHERE DBTypeId =  '$dbTypeSV'
                            AND hide_pevc_flag =1
                            ) 
                        GROUP BY pe.PEId";
            }
        
        }
        elseif($dealCategory == 'VC'){ //for VC Investment
            
            if($companysearch != ''){
                
                $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                $comrs = mysql_query($comsql);
                $comres = mysql_fetch_array($comrs);
                $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";

            }elseif($investorsearch != ''){

                $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                $invrs = mysql_query($invsql);
                $invres = mysql_fetch_array($invrs);
                $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                $investor_from = " ,peinvestments_investors as peinv_invs,peinvestors as invs";
                $investor_where = " and peinv_invs.PEId=pe.PEId and invs.InvestorId=peinv_invs.InvestorId";
            }
            if($datatype == 1){
  
                $sql = "SELECT pe.PEId FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s,peinvestments_investors as peinv_invs,peinvestors as invs
                        WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID 
                        and pe.StageId=s.StageId ".$investor_where." and pe.Deleted=0 and pec.industry!=15  and s.VCview=1 and pe.amount <=20".$company_search.$investor_search." AND pe.PEId NOT
                        IN (
                            SELECT PEId
                            FROM peinvestments_dbtypes AS db
                            WHERE DBTypeId =  '$dbTypeSV'
                            AND hide_pevc_flag =1
                            )  
                        GROUP BY pe.PEId";
            }else{
                
                $sql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business, amount ,pe.Exit_Status,
                        DATE_FORMAT( dates, '%b-%Y' ) as dealperiod ,pe.PEId,pe.hideamount,pe.SPV,pe.AggHide,(SELECT GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') 
                        FROM peinvestments_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.PEId=pe.PEId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                        FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ".$investor_from."
                        WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId
                        ".$investor_where." and pe.Deleted=0 and pec.industry!=15  and s.VCview=1 and pe.amount <=20".$company_search.$investor_search." AND pe.PEId NOT
                        IN (
                            SELECT PEId
                            FROM peinvestments_dbtypes AS db
                            WHERE DBTypeId =  '$dbTypeSV'
                            AND hide_pevc_flag =1
                            ) 
                        GROUP BY pe.PEId";
            }
            
        }
        elseif($dealCategory == 'ANGEL'){ // for Angel Investment
      
            if($companysearch != ''){
                    
                $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                $comrs = mysql_query($comsql);
                $comres = mysql_fetch_array($comrs);
                $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";

            }elseif($investorsearch != ''){

                $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                $invrs = mysql_query($invsql);
                $invres = mysql_fetch_array($invrs);
                $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
            }
            if($datatype == 1){
                
                $sql="SELECT pe.AngelDealId,pe.InvesteeId,pe.AggHide,pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business, 
                    DATE_FORMAT( pe.DealDate, '%M-%Y' ) as dealperiod
                    FROM angelinvdeals AS pe, industry AS i,  pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
                    WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.InvesteeId 
                    AND pe.Deleted =0 and pec.industry !=15 and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId ".$company_search.$investor_search." GROUP BY pe.AngelDealId";
            }else{
                
                $sql="SELECT pe.AngelDealId,pe.InvesteeId,pe.AggHide,pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business, 
                    DATE_FORMAT( pe.DealDate, '%M-%Y' ) as dealperiod,pe.Dealdate as Dealdate,GROUP_CONCAT( inv.Investor ORDER BY Investor='others' ) AS Investor 
                    FROM angelinvdeals AS pe, industry AS i,  pecompanies AS pec,angel_investors as peinv_inv,peinvestors as inv
                    WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.InvesteeId 
                    AND pe.Deleted =0 and pec.industry !=15 and peinv_inv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv_inv.InvestorId ".$company_search.$investor_search." GROUP BY pe.AngelDealId";
            }
            
            
        }elseif($dealCategory == 'INCUBATION'){ // for Incubation Investment
            
            if($companysearch != ''){
                    
                $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                $comrs = mysql_query($comsql);
                $comres = mysql_fetch_array($comrs);
                $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";

            }elseif($investorsearch != ''){

                $invsql = "SELECT GROUP_CONCAT(IncubatorId) as incubatorId FROM  `incubators` WHERE  `Incubator` LIKE  '$investorsearch'";
                $invrs = mysql_query($invsql);
                $invres = mysql_fetch_array($invrs);
                $investor_search = " AND inc.IncubatorId IN(".$invres['incubatorId'].")";
            }
            if($datatype == 1){
                
                $sql="SELECT pe.IncDealId,pe.IncubateeId, pec.companyname, pec.industry, i.industry, pec.sector_business  as sector_business, Individual,inc.Incubator,
                pec.PECompanyid as companyid, pe.date_month_year
                FROM incubatordeals AS pe, industry AS i,  pecompanies AS pec,incubators as inc,region as r
                WHERE date_month_year between '" . $from_date. "' and '" . $to_date . "' and i.industryid=pec.industry and pec.PEcompanyID = pe.IncubateeId and inc.IncubatorId=pe.IncubatorId and  r.RegionId=pec.RegionId
                and pe.Deleted=0 and pec.industry !=15 ".$company_search.$investor_search."";
            }else{
                
                $sql="SELECT pe.IncDealId,pe.IncubateeId, pec.companyname, pec.industry, i.industry, pec.sector_business  as sector_business, Individual,inc.Incubator,
                pec.PECompanyid as companyid, pe.date_month_year
                FROM incubatordeals AS pe, industry AS i,  pecompanies AS pec,incubators as inc,region as r
                WHERE date_month_year between '" . $from_date. "' and '" . $to_date . "' and i.industryid=pec.industry and pec.PEcompanyID = pe.IncubateeId and inc.IncubatorId=pe.IncubatorId and  r.RegionId=pec.RegionId
                and pe.Deleted=0 and pec.industry !=15 ".$company_search.$investor_search."";
            }
            
            
        }elseif($dealCategory == 'SOCIAL'){ // for Social Investment
            
            if($companysearch != ''){
                    
                $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                $comrs = mysql_query($comsql);
                $comres = mysql_fetch_array($comrs);
                $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";

            }elseif($investorsearch != ''){

                $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                $invrs = mysql_query($invsql);
                $invres = mysql_fetch_array($invrs);
                $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
            }
            if($datatype == 1){
                    
                    $sql = "SELECT pe.PEId FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes  as pedb,peinvestments_investors as peinv_inv,peinvestors as inv
                    WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND i.industryid=pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                    and pedb.PEId=pe.PEId and pedb.DBTypeId='SV' and pe.Deleted=0 and pec.industry!=15 ".$company_search.$investor_search." and peinv_inv.PEId=pe.PEId and 
                    inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId";
            }else{
                
                    $sql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,pe.Exit_Status,
                    amount, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pe.PEId,pe.MoreInfor,pe.hideamount,
                    pe.SPV ,pe.AggHide,GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
                    FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes  as pedb,peinvestments_investors as peinv_inv,peinvestors as inv
                    WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND i.industryid=pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                    and pedb.PEId=pe.PEId and pedb.DBTypeId='SV' and pe.Deleted=0 and pec.industry!=15 ".$company_search.$investor_search." and peinv_inv.PEId=pe.PEId and 
                    inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId";
            }   
            
        }elseif($dealCategory == 'CLEANTECH'){ // Cleantech Investment
            
            if($companysearch != ''){
                    
                $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                $comrs = mysql_query($comsql);
                $comres = mysql_fetch_array($comrs);
                $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";

            }elseif($investorsearch != ''){

                $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                $invrs = mysql_query($invsql);
                $invres = mysql_fetch_array($invrs);
                $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
            }
            
            if($datatype == 1){
                    
                $sql = "SELECT pe.PEId FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes  as pedb,peinvestments_investors as peinv_inv,peinvestors as inv
                    WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND i.industryid=pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                    and pedb.PEId=pe.PEId and pedb.DBTypeId='CT' and pe.Deleted=0 and pec.industry!=15 ".$company_search.$investor_search." and peinv_inv.PEId=pe.PEId and 
                    inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId";
            }else{
                
                $sql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,pe.Exit_Status,
                     amount, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pe.PEId,pe.MoreInfor,pe.hideamount,
                    pe.SPV ,pe.AggHide,GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
                    FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes  as pedb,peinvestments_investors as peinv_inv,peinvestors as inv
                    WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND i.industryid=pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                    and pedb.PEId=pe.PEId and pedb.DBTypeId='CT' and pe.Deleted=0 and pec.industry!=15 ".$company_search.$investor_search." and peinv_inv.PEId=pe.PEId and 
                    inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId";
            }  
            
        }elseif($dealCategory == 'INFRASTRUCTURE'){ // for Infrastructure Investment
            
            if($companysearch != ''){
                    
                $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                $comrs = mysql_query($comsql);
                $comres = mysql_fetch_array($comrs);
                $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";

            }elseif($investorsearch != ''){

                $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                $invrs = mysql_query($invsql);
                $invres = mysql_fetch_array($invrs);
                $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
            }
            if($datatype == 1){
                    
                $sql = "SELECT pe.PEId FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes  as pedb,peinvestments_investors as peinv_inv,peinvestors as inv
                    WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND i.industryid=pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                    and pedb.PEId=pe.PEId and pedb.DBTypeId='IF' and pe.Deleted=0 and pec.industry!=15 ".$company_search.$investor_search." and peinv_inv.PEId=pe.PEId and 
                    inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId";
            }else{
                
                $sql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,pe.Exit_Status,
                     amount, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pe.PEId,pe.MoreInfor,pe.hideamount,
                    pe.SPV ,pe.AggHide,GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
                    FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes  as pedb,peinvestments_investors as peinv_inv,peinvestors as inv
                    WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND i.industryid=pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                    and pedb.PEId=pe.PEId and pedb.DBTypeId='IF' and pe.Deleted=0 and pec.industry!=15 ".$company_search.$investor_search." and peinv_inv.PEId=pe.PEId and 
                    inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId";
            } 
            
        }
    }else{
            
            if($dealCategory == 'PEMA'){ // for PE - M&A EXIT
                
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";

                }elseif($investorsearch != ''){

                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                    $investor_from = " ,manda_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.MandAId=pe.MandAId and invs.InvestorId=peinv_invs.InvestorId";
                }
            
                $sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business,pe.DealAmount,pec.website, pe.MandAId,pe.Comment,
                MoreInfor,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,(SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') 
                FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                FROM manda AS pe, industry AS i, pecompanies AS pec ,dealtypes dt ".$investor_from."
                WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and 
                pec.industry != 15 ".$investor_where." and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit=0 ".$company_search.$investor_search." GROUP BY pe.MandAId";
                
            }elseif($dealCategory == 'PEPM'){ // for PE - Public Market EXIT
                
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";

                }elseif($investorsearch != ''){

                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                    $investor_from = " ,manda_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.MandAId=pe.MandAId and invs.InvestorId=peinv_invs.InvestorId";
                }
                $sql="SELECT DISTINCT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business, pe.DealAmount,pe.ExitStatus, 
                i.industry, hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others') 
                FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt ".$investor_from."
                where DealDate between '" . $from_date. "' and '" . $to_date . "' and i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID
                and pec.industry != 15 ".$investor_where." and pe.Deleted=0 and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit=1 ".$company_search.$investor_search."
                GROUP BY pe.MandAId";
                
            }elseif($dealCategory == 'PEIPO'){ // for PE - IPOExit
                
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";

                }elseif($investorsearch != ''){

                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                    $investor_from = " ,ipo_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.IPOId=pe.IPOId and invs.InvestorId=peinv_invs.InvestorId";
                }
                $sql="SELECT pe.PECompanyId as companyid, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,pe.IPOSize,pe.IPOAmount, 
                pe.IPOValuation,IPODate as dates,DATE_FORMAT( IPODate, '%b-%Y' ) as IPODate,pec.website,pec.city, pec.region, pe.IPOId,pe.Comment,MoreInfor,hideamount,hidemoreinfor,
                (SELECT GROUP_CONCAT( inv.Investor ) FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                FROM ipos AS pe, industry AS i,pecompanies AS pec ".$investor_from."
                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and IPODate between '" . $from_date. "' and '" . $to_date . "' AND pe.Deleted =0 
                ".$investor_where.$company_search.$investor_search." GROUP BY pe.IPOId ";
            }
            elseif($dealCategory == 'VCMA'){ // for VC - M&A EXIT
                
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";

                }elseif($investorsearch != ''){

                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                    $investor_from = " ,manda_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.MandAId=pe.MandAId and invs.InvestorId=peinv_invs.InvestorId";
                }
                $sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business,pe.DealAmount,pec.website, pe.MandAId,pe.Comment,
                MoreInfor,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,(SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') 
                FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                FROM manda AS pe, industry AS i, pecompanies AS pec ,dealtypes dt ".$investor_from."
                WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and 
                pec.industry != 15 ".$investor_where." and pe.DealTypeId= dt.DealTypeId and VCFlag=1 and dt.hide_for_exit=0 ".$company_search.$investor_search." GROUP BY pe.MandAId ";
                
            }elseif($dealCategory == 'VCPM'){ // for VC - Public Market EXIT
                
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";

                }elseif($investorsearch != ''){

                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                    $investor_from = " ,manda_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.MandAId=pe.MandAId and invs.InvestorId=peinv_invs.InvestorId";
                }
                $sql="SELECT DISTINCT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business, pe.DealAmount,pe.ExitStatus, 
                i.industry, hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period, 
                (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId 
                and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt ".$investor_from."
                where DealDate between '" . $from_date. "' and '" . $to_date . "' and i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID
                and pec.industry != 15 ".$investor_where." and pe.Deleted=0 and VCFlag=1 and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit=1 ".$company_search.$investor_search." GROUP BY pe.MandAId";

            }elseif($dealCategory == 'VCIPO'){ // for VC - IPOExit
                
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";

                }elseif($investorsearch != ''){

                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                    $investor_from = " ,ipo_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.IPOId=pe.IPOId and invs.InvestorId=peinv_invs.InvestorId";
                }
                    $sql = "SELECT pe.PECompanyId as companyid, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,pe.IPOSize,pe.IPOAmount, 
                    pe.IPOValuation,IPODate as dates,DATE_FORMAT( IPODate, '%b-%Y' ) as IPODate,pec.website,pec.city, pec.region, pe.IPOId,pe.Comment,MoreInfor,hideamount,hidemoreinfor,
                    (SELECT GROUP_CONCAT( inv.Investor ) FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                    FROM ipos AS pe, industry AS i,pecompanies AS pec ".$investor_from."
                    WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and IPODate between '" . $from_date. "' and '" . $to_date . "' AND pe.Deleted =0 ".$investor_where." and VCFlag=1 
                    ".$company_search.$investor_search." GROUP BY pe.IPOId ";
            }
    }
//    echo  $sql;
//    exit();
    $results = mysql_query($sql);
    
    if($datatype==1 && $dealType==1){
        
        if($dealCategory == 'PE' || $dealCategory == 'VC' || $dealCategory == 'SOCIAL' || $dealCategory == 'CLEANTECH' || $dealCategory == 'INFRASTRUCTURE'){
            
            if(mysql_num_rows($results) > 0){
           
                while($data_res = mysql_fetch_array($results)) {

                    $res1 = array();
                    $data_inner = array();
                    $dealsql = "SELECT pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, pec.industry, i.industry, pec.sector_business,
                        amount, round, s.Stage, stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dt, pec.website, pec.city, pec.region,pe.PEId,comment,MoreInfor,hideamount,
                        hidestake, pe.InvestorType, its.InvestorTypeName,pe.StageId,pe.Link,pec.uploadfilename,pe.source,pe.Valuation,pe.FinLink,pec.RegionId, pe.AggHide, 
                        pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple,pe.listing_status,Exit_Status,pe.SPV,pe.Revenue,pe.EBITDA,pe.PAT
                        FROM peinvestments AS pe, industry AS i, pecompanies AS pec, investortype as its,stage as s WHERE pec.industry = i.industryid AND 
                        pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15 and pe.PEId = ".$data_res['PEId']." and s.StageId=pe.StageId and its.InvestorType=pe.InvestorType ";


                        if ($companyrs = mysql_query($dealsql))
                        {  

                            if($myrow = mysql_fetch_array($companyrs,MYSQL_BOTH))
                            {
                                $data_inner['CompanyName'] = $myrow["companyname"];
                                if($myrow["hideamount"] == 1)
                                {
                                        $res1['amount'] = "--";
                                }
                                else
                                {
                                        $res1['amount'] = $myrow["amount"];
                                }
                                $res1['stage'] = $myrow["Stage"];
                                $res1['round'] = $myrow["round"];
                                $res1['date'] = $myrow["dt"];
                                $exitstatusSql = "select id,status from exit_status where id=".$myrow["Exit_Status"];
                                if ($exitstatusrs = mysql_query($exitstatusSql))
                                {
                                  $exitstatus_cnt = mysql_num_rows($exitstatusrs);
                                }
                                if($exitstatus_cnt > 0)
                                {
                                        While($Exit_myrow = mysql_fetch_array($exitstatusrs, MYSQL_BOTH))
                                        {
                                                $exitstatusis = $Exit_myrow[1];
                                        }
                                        $res1['Exit Status'] = $exitstatusis;
                                }
                                //print_r($res1);

                            }
                             $data_inner['Deal_Info'][] = $res1;
                        }

                        $res2 = array();
                        $investorSql = "select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
                        peinvestors as inv where peinv.PEId = ".$data_res['PEId']." and inv.InvestorId=peinv.InvestorId";
                        $investors='';
                        if ($getinvestorrs = mysql_query($investorSql))
                        {
                           While($myInvrow = mysql_fetch_array($getinvestorrs, MYSQL_BOTH))
                           {

                               $investors .= $myInvrow["Investor"].',';
                           }
                           $res2['Investor'] = $investors;

                        }

                        $res2['InvestorType'] = $myrow["InvestorTypeName"];

                        if($myrow["stakepercentage"]>0){

                            $res2['stake'] = $myrow["stakepercentage"];
                        }
                        else{
                            $res2['stake'] = "-";
                        }

                        $res3 = array();
                        $advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,AdvisorType from peinvestments_advisorcompanies as advcomp,
                        advisor_cias as cia where advcomp.PEId =".$data_res['PEId']." and advcomp.CIAId=cia.CIAId";
                        $advisorcom = '';
                        if ($getcompanyrs = mysql_query($advcompanysql))
                        {
                            While($myadcomprow = mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                            { 
                                    $advisorcom .= $myadcomprow["cianame"].',';

                            }
                            if(rtrim($advisorcom,',') != ''){

                                $res2['Advisor_Company'] = rtrim($advisorcom,',');
                            }else{
                                $res2['Advisor_Company'] = '';
                            }
                        }
                        $res3['Advisor_Company'] = $res2;
                        $advinvestorssql = "select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from peinvestments_advisorinvestors as advinv,
                        advisor_cias as cia where advinv.PEId =".$data_res['PEId']." and advinv.CIAId=cia.CIAId";
                        $advisorinv = '';
                        if ($getinvestorrs = mysql_query($advinvestorssql))
                        {
                            While($myadinvrow = mysql_fetch_array($getinvestorrs, MYSQL_BOTH))
                            {
                                $advisorinv .= $myadinvrow["cianame"].',';

                            }
                            if(rtrim($advisorinv,',') != ''){

                                $res2['Advisor_Investor'] = rtrim($advisorinv,',');
                            }else{
                                $res2['Advisor_Investor'] ='';
                            }
                        }
                        $res3['Advisor Details'] = $res2;

                        if($myrow["Revenue"] > 0 && $myrow["Revenue"] != ''){

                            $res2['Revenue'] = $myrow["Revenue"];
                        }else{
                            $res2['Revenue'] = 0;
                        }

                        if($myrow["EBITDA"] > 0 && $myrow["EBITDA"] != ''){

                            $res2['EBITDA'] = $myrow["EBITDA"];
                        }else{
                            $res2['EBITDA'] = 0;
                        }

                        if($myrow["PAT"] > 0 && $myrow["PAT"] != ''){

                            $res2['PAT'] = $myrow["PAT"];
                        }else{
                            $res2['PAT'] = 0;
                        }

                        if($myrow["Company_Valuation"] <= 0){

                            $res2['Company_Valuation'] = $myrow["Company_Valuation"];
                        }
                        else{

                            $res2['Company_Valuation'] = 0.00;
                        }

                        if($myrow["Revenue_Multiple"] <= 0){

                            $res2['Revenue_Multiple'] = $myrow["Revenue_Multiple"];
                        }
                        else{

                            $res2['Revenue_Multiple'] = 0.00;
                        }

                        if($myrow["EBITDA_Multiple"] <= 0){

                            $res2['EBITDA_Multiple'] = $myrow["EBITDA_Multiple"];
                        }
                        else{

                            $res2['EBITDA_Multiple'] = 0.00;
                        }

                        if($myrow["PAT_Multiple"] <= 0){

                           $res2['PAT_Multiple'] = $myrow["PAT_Multiple"];
                        }
                        else{

                            $res2['PAT_Multiple'] = 0.00;
                        }

                        if($myrow["price_to_book"] <= 0){

                            $res2['price_to_book'] = 0.00;
                        }
                        else{
                            $res2['price_to_book'] = $myrow["price_to_book"];
                        }


                        if($myrow["book_value_per_share"] <= 0){

                            $res2['book_value_per_share'] = 0.00;
                        }
                        else{
                            $res2['book_value_per_share'] = $myrow["book_value_per_share"];
                        }


                        if($myrow["price_per_share"] <= 0){

                            $res2['price_per_share'] = 0.00;
                        }
                        else{

                            $res2['price_per_share'] = $myrow["price_per_share"];
                        }

                        $data_inner['Investment Info'][] = $res2;

                        $res6 = array();
                        $uploadname = $myrow["uploadfilename"];
                        $file = "<?php echo GLOBAL_BASE_URL; ?>/uploadmamafiles/" . $uploadname;

                        if($myrow["uploadfilename"] != "")
                        {
                            $res6['File'] = $file;
                        }else{

                            $res6['File'] = '';
                        }
                        $data_inner['Financials Info'][] = $res6;

                        $res4 =  array();
                        if($myrow["companyname"] != ''){

                            $res4['companyname'] = $myrow["companyname"];
                        }else{
                            $res4['companyname'] = '';
                        }

                        if($myrow["listing_status"] == "L"){

                           $res4['companyType'] = "Listed";
                        }
                        elseif($myrow["listing_status"] == "U"){

                            $res4['companyType'] = "Unlisted"; 
                        }

                        if($myrow["industry"] != "") {

                            $res4['industry'] = $myrow["industry"]; 
                        }else{

                            $res4['industry'] = ""; 
                        }

                        if($myrow["sector_business"] != "") {

                            $res4['sector_business'] = $myrow["sector_business"]; 
                        }else{

                            $res4['sector_business'] = ""; 
                        }

                        if($myrow["city"] != "") {

                            $res4['city'] = $myrow["city"];
                        }else{

                            $res4['city'] = ""; 
                        }

                        $regionid=$myrow["RegionId"];
                        if($regionid > 0)
                        { 

                            $res4['region'] = return_insert_get_RegionIdName($regionid);  
                        }
                        else
                        {

                            $res4['region'] = $myrow["region"];  
                        }

                        if($myrow["website"] != ''){

                            $res4['website'] = $myrow["website"];
                        }else{

                            $res4['website'] = '';
                        }

                        $linkrow = $myrow["Link"];
                        $linkstring = str_replace('"','',$linkrow);
                        $linkstring = explode(";",$linkstring);
                        if(count($linkstring) > 0) {

                            foreach ($linkstring as $linkstr)
                            {
                                    if(trim($linkstr) != "")
                                    {

                                        $res4['Link'] = nl2br($linkstr);
                                    }
                            }
                        }
                        $data_inner['Company Info'][] = $res4;

                        $res5 = array();

                        $moreinfor=$myrow["MoreInfor"];
                        if($moreinfor != ''){

                            $res5['Moreinfo'] = $text = str_replace("\r\n",'', $moreinfor);
                        }else{
                             $res5['Moreinfo'] = '';
                        }
                        $data_inner['More Info'][] = $res5;

                        //------------------------------------------------------ Company Profile starts----------------------------------------------------------
                        $sql = "SELECT pe.FinLink, pec.angelco_compID, pec.uploadfilename, pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, 
                            website,linkedIn, stockcode, yearfounded, pec.Address1, pec.Address2, pec.AdCity, pec.Zip, pec.OtherLocation, c.country, pec.Telephone, pec.Fax, 
                            pec.Email, pec.AdditionalInfor, linkedin_companyname
                            FROM pecompanies pec
                            LEFT JOIN peinvestments AS pe ON ( pe.PECompanyId = pec.PECompanyId ) 
                            LEFT JOIN industry i ON ( pec.industry = i.industryid ) 
                            LEFT JOIN country c ON ( c.countryid = pec.countryid ) 
                            WHERE pec.PECompanyId =".$myrow['PECompanyId'];	

                        $company_link_Sql = mysql_query("select * from pecompanies_links where PECompanyId=".$myrow['PECompanyId']); 

                        $incubatorSql = "SELECT pe.IncDealId,pe.IncubatorId,inc.Incubator 
                                FROM `incubatordeals` as pe, incubators as inc 
                                WHERE IncubateeId = ".$myrow['PECompanyId']." and pe.IncubatorId= inc.IncubatorId ";

                        $onMgmtSql = "SELECT pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,exe.ExecutiveName,exe.Designation,exe.Company 
                                From pecompanies as pec,executives as exe,pecompanies_management as mgmt
                                where pec.PECompanyId=".$myrow['PECompanyId']." and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";

                        $onBoardSql = "SELECT pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId, exe.ExecutiveName,exe.Designation,exe.Company 
                                FROM pecompanies as pec,executives as exe,pecompanies_board as bd
                                WHERE pec.PECompanyId=".$myrow['PECompanyId']." and bd.PECompanyId=pec.PECompanyId and exe.ExecutiveId=bd.ExecutiveId";

                        $investorSql = "SELECT pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV 
                                FROM peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,peinvestors as inv 
                                WHERE pe.PECompanyId=".$myrow['PECompanyId']." and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0
                                and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15 order by dates desc";

                        $maexitsql = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, inv.Investor,DealAmount, 
                                DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId ,pe.ExitStatus, pe.DealTypeId, dt.DealType
                                FROM manda AS pe, industry AS i, pecompanies AS pec,manda_investors as mi ,peinvestors as inv, dealtypes AS dt
                                WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and 
                                pe.PECompanyId=".$myrow['PECompanyId']." and inv.InvestorId=mi.InvestorId and mi.MandAId=pe.MandAId and pe.DealTypeId=dt.DealTypeId
                                order by DealDate desc ";

                        $ipoexitsql = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,IPOAmount, 
                                DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId ,pe.ExitStatus
                                FROM ipos AS pe, industry AS i, pecompanies AS pec,ipo_investors as ipoi,peinvestors as inv
                                WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and 
                                pe.PECompanyId=".$myrow['PECompanyId']." and inv.InvestorId=ipoi.InvestorId and ipoi.IPOId=pe.IPOId order by IPODate desc";

                        $angelinvsql = "SELECT pe.InvesteeId, pe.AggHide, pec.companyname, pec.industry, i.industry, pec.sector_business,
                                DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.AngelDealId ,peinv.InvestorId,inv.Investor
                                FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,angel_investors as peinv,peinvestors as inv
                                WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.InvesteeId and pe.Deleted=0 and pec.industry !=15 and 
                                pe.InvesteeId=".$myrow['PECompanyId']." and  peinv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv.InvestorId order by dt desc";

                        $comres = array();
                        if ($companyrs = mysql_query($sql))
                        {

                            $comrow = mysql_fetch_array($companyrs,MYSQL_BOTH);

                            if($comrow["companyname"] != ''){

                                $comres['Companyname'] = $comrow["companyname"];
                            }else{

                                $comres['Companyname'] = '';
                            }

                            if($comrow["industry"] != ''){

                                $comres['Industry'] = $comrow["industry"];
                            }else{

                                $comres['Industry'] = '';
                            }

                             if($comrow["sector_business"] != ''){

                                $comres['Sector_business'] = $comrow["sector_business"];
                            }else{

                                $comres['Sector_business'] = '';
                            }

                             if($comrow["stockcode"] != ''){

                                $comres['Stockcode'] = $comrow["stockcode"];
                            }else{

                                $comres['Stockcode'] = '';
                            }

                            if($comrow["Address1"] != ''){

                                $comres['Address'] = $comrow["Address1"];
                            }else{

                                $comres['Address'] = '';
                            }

                            if($comrow["AdCity"] != ''){

                                $comres['City'] = $comrow["AdCity"];
                            }else{

                                $comres['City'] = '';
                            }

                            if($comrow["country"] != ''){

                                $comres['Country'] = $comrow["country"];
                            }else{

                                $comres['Country'] = '';
                            }

                            if($comrow["Zip"] != ''){

                                $comres['Pincode'] = $comrow["Zip"];
                            }else{

                                $comres['Pincode'] = '';
                            }

                            if($comrow["Telephone"] != ''){

                                $comres['Telephone'] = $comrow["Telephone"];
                            }else{

                                $comres['Telephone'] = '';
                            }

                            if($comrow["Fax"] != ''){

                                $comres['Fax'] = $comrow["Fax"];
                            }else{

                                $comres['Fax'] = '';
                            }

                            if($comrow["Email"] != ''){

                                $comres['Email'] = $comrow["Email"];
                            }else{

                                $comres['Email'] = '';
                            }

                            if($comrow["yearfounded"] != ''){

                                $comres['Yearfounded'] = $comrow["yearfounded"];
                            }else{

                                $comres['Yearfounded'] = '';
                            }

                            if($comrow["OtherLocation"] != ''){

                                $comres['OtherLocation'] = $comrow["OtherLocation"];
                            }else{

                                $comres['OtherLocation'] = '';
                            }

                            if($comrow["website"] != ''){

                                $comres['Website'] = $comrow["website"];
                            }else{

                                $comres['Website'] = '';
                            }

                            if($comrow["OtherLocation"] != ''){

                                $comres['OtherLocation'] = $comrow["OtherLocation"];
                            }else{

                                $comres['OtherLocation'] = '';
                            }

                            $companyName = trim($comres["companyname"]);
                            $companyurl = urlencode($companyName);
                            $company_newssearch = "https://www.google.co.in/search?q=".$companyurl."+site:ventureintelligence.com/ddw/";

                            if($company_newssearch != ''){

                                $comres['News'] = $company_newssearch;
                            }else{

                                $comres['News'] = '';
                            }

                            if($comrow["linkedIn"] != ''){

                                $comres['LinkedIN'] = $comrow["linkedIn"];
                            }else{

                                $comres['LinkedIN'] = '';
                            }

                            if($comrow["AdditionalInfor"] != ''){

                                $comres['AdditionalInfo'] = $comrow["AdditionalInfor"];
                            }else{

                                $comres['AdditionalInfo'] = '';
                            }

                            $data_inner['Company Profile'][] = $comres;
                        }

                        $comres1 = array();$topmanagement = array();
                        if($rsMgmt = mysql_query($onMgmtSql))
                        {
                            While($mymgmtrow = mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                            {

                                $comres1['Name'] = $mymgmtrow["ExecutiveName"];
                                $comres1['Designation'] = $mymgmtrow["Designation"];  

                                $topmanagement[] = $comres1;
                            }
                            if(count($topmanagement) > 0){

                                $data_inner['Company Profile']['Top Management'] = $topmanagement;
                            }else{

                                $data_inner['Company Profile']['Top Management'] = '';
                            }
                        }

                        $comres2 = array();$boardmember = array();
                        if($rsBoard = mysql_query($onBoardSql))
                        {
                            While($myboardrow = mysql_fetch_array($rsBoard, MYSQL_BOTH))
                            {

                                $comres2['Name'] = $myboardrow["ExecutiveName"];
                                $comres2['Designation'] = $myboardrow["Designation"].', '.$myboardrow["Company"];  
                                $comres2['LinkedIn'] = "https://www.google.co.in/search?q=".$myboardrow["ExecutiveName"].$myboardrow["Designation"].$myboardrow["Company"]. "+site%3Alinkedin.com"; 

                                $boardmember[]=$comres2;
                            }
                             if(count($boardmember) > 0){

                                $data_inner['Company Profile']['Investor Board Member'] = $boardmember;
                             }else{
                                 $data_inner['Company Profile']['Investor Board Member'] = '';
                             }
                        }

                        $comres3 = array(); $investors = array();
                        if($rsinvestor = mysql_query($investorSql))
                        {
                            While($investorsrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                            {

                                $comres3['Investor Name'] = $investorsrow["Investor"];
                                $comres3['Deal Period'] = $investorsrow["dt"];
                                $investors[] = $comres3;
                            }
                             if(count($investors) > 0){

                                $data_inner['Investments']['PE/VC investors'] = $investors;
                             }else{
                                 $data_inner['Investments']['PE/VC investors'] = '';
                             }
                        }
                        
                         $comres4 = array(); $incubators = array();
                        if($rsincubator = mysql_query($ipoexitsql))
                        {
                            While($incsrow=mysql_fetch_array($rsincubator, MYSQL_BOTH))
                            {

                                $comres4['Investor Name'] = $incsrow["Investor"];
                                $comres4['Deal Period'] = $incsrow["dt"];
                                
                                if($incsrow["ExitStatus"]){
                                    
                                    if($incsrow["ExitStatus"]==0){
                                        
                                        $comres4['Exitstatus'] = "Partial Exit";
                                    }
                                   elseif($incsrow["ExitStatus"]==1){  
                                       
                                        $comres4['Exitstatus'] = "Complete Exit";
                                       
                                   }
                                    
                                }else{
                                    $comres4['Exitstatus'] = "";
                                }
                          
                                $incubators[] = $comres4;
                            }
                             if(count($incubators) > 0){

                                $data_inner['Investments']['Incubators'] = $incubators;
                             }else{
                                 $data_inner['Investments']['incubators'] = '';
                             }
                        }
                        
                        $comres5 = array(); $maincubators = array();
                        if($rsmaincubator = mysql_query($maexitsql))
                        {
                            While($maincsrow=mysql_fetch_array($rsmaincubator, MYSQL_BOTH))
                            {

                                $comres5['Investor Name'] = $maincsrow["Investor"];
                                $comres5['Deal Period'] = $maincsrow["dt"];
                                
                                if($maincsrow["ExitStatus"]){
                                    
                                    if($maincsrow["ExitStatus"]==0){
                                        
                                        $comres4['Exitstatus'] = "Partial Exit";
                                    }
                                   elseif($maincsrow["ExitStatus"]==1){  
                                       
                                        $comres4['Exitstatus'] = "Complete Exit";
                                       
                                   }
                                    
                                }else{
                                    $comres4['Exitstatus'] = "";
                                }
                                $maincubators[] = $comres4;
                            }
                             if(count($maincubators) > 0){

                                $data_inner['Investments']['Incubators'] = $maincubators;
                             }else{
                                 $data_inner['Investments']['incubators'] = '';
                             }
                        }
                        
                        $comres6 = array(); $angelinvestors = array();
                        if($rsangelinvestor = mysql_query($angelinvsql))
                        {
                            While($angelinvestorsrow=mysql_fetch_array($rsangelinvestor, MYSQL_BOTH))
                            {

                                $comres6['Investor Name'] = $angelinvestorsrow["Investor"];
                                $comres6['Deal Period'] = $angelinvestorsrow["dt"];
                                $angelinvestors[] = $comres6;
                            }
                             if(count($angelinvestors) > 0){

                                $data_inner['Investments']['Angel investors'] = $angelinvestors;
                             }else{
                                 $data_inner['Investments']['Angel investors'] = '';
                             }
                        }
                        
                        $data['Deal_Details'][] = $data_inner;
                }   
            }
        }
        elseif($dealCategory == 'ANGEL'){
            
            if(mysql_num_rows($results) > 0){
           
                while($data_res = mysql_fetch_array($results)) {

                    $res1 = array();
                    $data_inner = array();
              
                    $dealsql="SELECT pe.InvesteeId, pe.AggHide, pec.companyname, pec.industry, i.industry, pec.sector_business,DATE_FORMAT( DealDate, '%M-%Y' ) as dt, 
                        pec.website, pec.city,pec.RegionId,pe.AngelDealId,Comment,MoreInfor,r.Region,MultipleRound,FollowonVCFund,Exited,   pe.Link
                        FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec, region as r
                        WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.InvesteeId and pe.Deleted=0 and pec.industry !=15 and pe.AngelDealId=".$data_res['AngelDealId']." and 
                        r.RegionId=pec.RegionId ";

                    $investorSql="select peinv.AngelDealId,peinv.InvestorId,inv.Investor from angel_investors as peinv,
                        peinvestors as inv where peinv.AngelDealId=".$data_res['AngelDealId']." and inv.InvestorId=peinv.InvestorId ";
                   
                    if(mysql_num_rows($dealrs = mysql_query($dealsql))>0){
                        
                        if(mysql_num_rows($getinv = mysql_query($investorSql))>0){
                        
                            while($myInvrow=mysql_fetch_array($getinv, MYSQL_BOTH))
                            {
                                if($myInvrow["Investor"] != ''){

                                    $res1['Investor'] = $myInvrow["Investor"];
                                }
                            }
                        }
                    
                        while($dealrow = mysql_fetch_array($dealrs,MYSQL_BOTH))
                        {
                            if($dealrow["MultipleRound"] != ''){

                                if($dealrow["MultipleRound"] == 1)
                                 {
                                         $res1['multipleround'] = "Yes";
                                 }
                                 else
                                 {
                                         $res1['multipleround'] = "No";
                                 } 
                            }else{

                                $res1['multipleround'] = "";
                            }

                            if($dealrow["FollowonVCFund"] != ''){

                                if($dealrow["FollowonVCFund"] == 1)
                                 {    
                                    $res1['followonFunding'] = "Yes";

                                 }
                                 else
                                 {    
                                     $res1['followonFunding'] = "No";

                                 }
                            }else{

                                $res1['followonFunding'] = "";
                            }
                            
                            if($dealrow["Exited"] != ''){
                                
                                if($dealrow["Exited"] == 1)
                                {    
                                    $res1['exitedstatus'] = "Yes"; 
                                }
                                else
                                {    
                                    $res1['exitedstatus'] = "No";
                                }
                                
                            }else{
                                
                                $res1['exitedstatus'] = "";
                            }
                            
                            if($dealrow["dt"] != ''){
                                
                                $res1['date'] = $dealrow["dt"];
                            }else{
                                $res1['date'] = '';
                            }     
                            
                            $data_inner['Deal_Info'][] = $res1;
                            
                            if($dealrow["companyname"] != ''){
                               
                                $res2['companyname'] = $dealrow["companyname"];
                            }else{
                               
                                $res2['companyname'] = '';
                            }
                            
                            if($dealrow["industry"] != ''){
                               
                                $res2['industry'] = $dealrow["industry"];
                            }else{
                               
                                $res2['industry'] = '';
                            }

                            if($dealrow["sector_business"] != ''){
                               
                                $res2['sector'] = $dealrow["sector_business"];
                            }else{
                               
                                $res2['sector'] = '';
                            }
                            
                            if($dealrow["city"] !=''){
                               
                                $res2['city'] = $dealrow["city"];
                            }else{
                               
                                $res2['city'] = '';
                            }
                            
                            if($dealrow["region"] !=''){
                               
                                $res2['region'] = $dealrow["Region"];
                            }else{
                               
                                $res2['Region'] = '';
                            }
                            
                            if($dealrow["website"] != ''){
                               
                                $res2['website'] = $dealrow["website"];
                            }else{
                               
                                $res2['website'] = '';
                            }
                            
                            $data_inner['company_Info'][] = $res2;
                            
                            $res5 = array();
                            $moreinfor = $dealrow["MoreInfor"];
                            
                            if($moreinfor != ''){

                                $res5['Moreinfo'] = $text = str_replace("\r\n",'', $moreinfor);
                            }else{
                                 $res5['Moreinfo'] = '';
                            }
                            
                            $data_inner['More Info'][] = $res5;
                            
                            
                //------------------------------------------------------ Company Profile starts----------------------------------------------------------
                            
                            $comsql="SELECT pe.FinLink, pec.angelco_compID, pec.uploadfilename, pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, 
                                website,linkedIn, stockcode, yearfounded, pec.Address1, pec.Address2, pec.AdCity, pec.Zip, pec.OtherLocation, c.country, pec.Telephone, pec.Fax, 
                                pec.Email, pec.AdditionalInfor, linkedin_companyname
                                FROM pecompanies pec
                                LEFT JOIN peinvestments AS pe ON ( pe.PECompanyId = pec.PECompanyId ) 
                                LEFT JOIN industry i ON ( pec.industry = i.industryid ) 
                                LEFT JOIN country c ON ( c.countryid = pec.countryid ) 
                                WHERE pec.PECompanyId =".$data_res['PECompanyId'];	

                            $company_link_Sql =mysql_query("select * from pecompanies_links where PECompanyId='$SelCompRefvalue'"); 

                            $onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,exe.ExecutiveName,exe.Designation,exe.Company 
                                FROM pecompanies as pec,executives as exe,pecompanies_management as mgmt
                                WHERE pec.PECompanyId=".$data_res['PECompanyId']." and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";

                            $onBoardSql="select pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId,exe.ExecutiveName,exe.Designation,exe.Company 
                                FROM pecompanies as pec,executives as exe,pecompanies_board as bd
                                WHERE pec.PECompanyId=".$data_res['PECompanyId']." and bd.PECompanyId=pec.PECompanyId and exe.ExecutiveId=bd.ExecutiveId";

                            $investorSql="select pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV 
                                FROM peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,peinvestors as inv 
                                WHERE pe.PECompanyId=".$data_res['PECompanyId']." and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0
                                and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15 order by dates desc";

                             $incubatorSql="SELECT pe.IncDealId,pe.IncubatorId,inc.Incubator 
                                FROM `incubatordeals` as pe, incubators as inc 
                                WHERE IncubateeId =".$data_res['PECompanyId']." and pe.IncubatorId= inc.IncubatorId ";
                             
                            $maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, inv.Investor,DealAmount, 
                                DATE_FORMAT( DealDate, '%b-%Y' ) as dt,pe.MandAId ,pe.ExitStatus, pe.DealTypeId, dt.DealType
                                FROM manda AS pe, industry AS i, pecompanies AS pec,manda_investors as mi ,peinvestors as inv, dealtypes AS dt
                                WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=".$data_res['PECompanyId']."
                                and inv.InvestorId=mi.InvestorId and mi.MandAId=pe.MandAId and pe.DealTypeId=dt.DealTypeId order by DealDate desc ";

                            $ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,IPOAmount,
                                DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId ,pe.ExitStatus
                                FROM ipos AS pe, industry AS i, pecompanies AS pec,ipo_investors as ipoi,peinvestors as inv
                                WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=".$data_res['PECompanyId']."
                                and inv.InvestorId=ipoi.InvestorId and ipoi.IPOId=pe.IPOId order by IPODate desc";

                            $angelinvsql="SELECT pe.InvesteeId, pe.AggHide, pec.companyname, pec.industry, i.industry, pec.sector_business, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, 
                                pe.AngelDealId ,peinv.InvestorId,inv.Investor
                                FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,angel_investors as peinv,peinvestors as inv
                                WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.InvesteeId and pe.Deleted=0 and pec.industry !=15 and pe.InvesteeId=".$data_res['InvesteeId']."
                                and  peinv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv.InvestorId order by dt desc";
                            
                            $comres = array();
                            if ($companyrs = mysql_query($comsql))
                            {      
                                $myrow=mysql_fetch_array($companyrs,MYSQL_BOTH);

                                if($myrow["companyname"]!=''){

                                    $comres['Companyname'] = $myrow["companyname"];
                                }else{

                                    $comres['Companyname'] = '';
                                }

                                if($myrow["Investor"]!=''){

                                    $comres['Investor'] = $myrow["Investor"];
                                }else{

                                    $comres['Investor'] = '';
                                }

                                if($myrow["industry"]!=''){

                                    $comres['Industry'] = $myrow["industry"];
                                }else{

                                    $comres['Industry'] = '';
                                }

                                if($myrow["sector_business"]!=''){

                                    $comres['Sector'] = $myrow["sector_business"];
                                }else{

                                    $comres['Sector'] = '';
                                }

                                if($myrow["website"]!=''){

                                    $comres['Website'] = $myrow["website"];
                                }else{

                                    $comres['Website'] = '';
                                }

                                if($myrow["Address1"]!=''){

                                    $comres['Address'] = $myrow["Address1"];
                                }else{

                                    $comres['Address'] = '';
                                }

                                if($myrow["AdCity"]!=''){

                                    $comres['City'] = $myrow["AdCity"];
                                }else{

                                    $comres['City'] = '';
                                }

                                if($myrow["Zip"]!=''){

                                    $comres['Zipcode'] = $myrow["Zip"];
                                }else{

                                    $comres['Zipcode'] = '';
                                }

                                if($myrow["OtherLocation"]!=''){

                                    $comres['OtherLocation'] = $myrow["OtherLocation"];
                                }else{

                                    $comres['OtherLocation'] = '';
                                }

                                if($myrow["country"]!=''){

                                    $comres['Country'] = $myrow["country"];
                                }else{

                                    $comres['Country'] = '';
                                }

                                if($myrow["Telephone"]!=''){

                                    $comres['Telephone'] = $myrow["Telephone"];
                                }else{

                                    $comres['Telephone'] = '';
                                }

                                if($myrow["Fax"]!=''){

                                    $comres['Fax'] = $myrow["Fax"];
                                }else{

                                    $comres['Fax'] = '';
                                }

                                if($myrow["Email"]!=''){

                                    $comres['Email'] = $myrow["Email"];
                                }else{

                                    $comres['Email'] = '';
                                }

                                if($myrow["stockcode"]!=''){

                                    $comres['Stockcode'] = $myrow["stockcode"];
                                }else{

                                    $comres['Stockcode'] = '';
                                }

                                 if($myrow["yearfounded"]!=''){

                                    $comres['Yearfounded'] = $myrow["yearfounded"];
                                }else{

                                    $comres['Yearfounded'] = '';
                                }

                                if($myrow["linkedIn"]!=''){

                                    $comres['LinkedIn'] = $myrow["linkedIn"];
                                }else{

                                    $comres['LinkedIn'] = '';
                                }

                                if($myrow["linkedin_companyname"]!=''){

                                    $comres['LinkedIn_Company'] = $myrow["linkedin_companyname"];
                                }else{

                                    $comres['LinkedIn_Company'] = '';
                                }

                                $companyurl=  urlencode($myrow["companyname"]);
                                $company_newssearch="https://www.google.co.in/search?q=".$companyurl."+site:ventureintelligence.com/ddw/";

                                if($company_newssearch!=''){

                                    $comres['News'] = $company_newssearch;
                                }else{

                                    $comres['News'] = '';
                                }

                                if($myrow["AdditionalInformation"]!=''){

                                    $comres['AdditionalInformation'] = $myrow["AdditionalInfor"];
                                }else{

                                    $comres['AdditionalInformation'] = '';
                                }

                                $data_inner['Company Profile'][] = $comres;      
                            }

                            $comres1 = array();$topmanagement = array();
                            if($rsMgmt = mysql_query($onMgmtSql))
                            {
                                While($mymgmtrow = mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                                {

                                    $comres1['Name'] = $mymgmtrow["ExecutiveName"];
                                    $comres1['Designation'] = $mymgmtrow["Designation"];  

                                    $topmanagement[] = $comres1;
                                }
                                if(count($topmanagement) > 0){

                                    $data_inner['Company Profile']['Top Management'] = $topmanagement;
                                }else{

                                    $data_inner['Company Profile']['Top Management'] = '';
                                }
                            }
                            
                            $comres2 = array();$boardmember = array();
                            if($rsBoard = mysql_query($onBoardSql))
                            {
                                While($myboardrow = mysql_fetch_array($rsBoard, MYSQL_BOTH))
                                {

                                    $comres2['Name'] = $myboardrow["ExecutiveName"];
                                    $comres2['Designation'] = $myboardrow["Designation"].', '.$myboardrow["Company"];  
                                    $comres2['LinkedIn'] = "https://www.google.co.in/search?q=".$myboardrow["ExecutiveName"].$myboardrow["Designation"].$myboardrow["Company"]. "+site%3Alinkedin.com"; 

                                    $boardmember[]=$comres2;
                                }
                                 if(count($boardmember) > 0){

                                    $data_inner['Company Profile']['Investor Board Member'] = $boardmember;
                                 }else{
                                     $data_inner['Company Profile']['Investor Board Member'] = '';
                                 }
                            }

                            $comres3 = array(); $investors = array();
                            if($rsinvestor = mysql_query($investorSql))
                            {
                                While($investorsrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                {

                                    $comres3['Investor Name'] = $investorsrow["Investor"];
                                    $comres3['Deal Period'] = $investorsrow["dt"];
                                    $investors[] = $comres3;
                                }
                                 if(count($investors) > 0){

                                    $data_inner['Investments']['PE/VC investors'] = $investors;
                                 }else{
                                     $data_inner['Investments']['PE/VC investors'] = '';
                                 }
                            }
                            
                            $comres4 = array(); $incubators = array();
                            if($rsincubator = mysql_query($ipoexitsql))
                            {
                                While($incsrow=mysql_fetch_array($rsincubator, MYSQL_BOTH))
                                {

                                    $comres4['Investor Name'] = $incsrow["Investor"];
                                    $comres4['Deal Period'] = $incsrow["dt"];

                                    if($incsrow["ExitStatus"]){

                                        if($incsrow["ExitStatus"]==0){

                                            $comres4['Exitstatus'] = "Partial Exit";
                                        }
                                       elseif($incsrow["ExitStatus"]==1){  

                                            $comres4['Exitstatus'] = "Complete Exit";

                                       }

                                    }else{
                                        $comres4['Exitstatus'] = "";
                                    }

                                    $incubators[] = $comres4;
                                }
                                 if(count($incubators) > 0){

                                    $data_inner['Investments']['Incubators'] = $incubators;
                                 }else{
                                     $data_inner['Investments']['incubators'] = '';
                                 }
                            }

                            $comres5 = array(); $maincubators = array();
                            if($rsmaincubator = mysql_query($maexitsql))
                            {
                                While($maincsrow=mysql_fetch_array($rsmaincubator, MYSQL_BOTH))
                                {

                                    $comres5['Investor Name'] = $maincsrow["Investor"];
                                    $comres5['Deal Period'] = $maincsrow["dt"];

                                    if($maincsrow["ExitStatus"]){

                                        if($maincsrow["ExitStatus"]==0){

                                            $comres4['Exitstatus'] = "Partial Exit";
                                        }
                                       elseif($maincsrow["ExitStatus"]==1){  

                                            $comres4['Exitstatus'] = "Complete Exit";

                                       }

                                    }else{
                                        $comres4['Exitstatus'] = "";
                                    }
                                    $maincubators[] = $comres4;
                                }
                                 if(count($maincubators) > 0){

                                    $data_inner['Investments']['Incubators'] = $maincubators;
                                 }else{
                                     $data_inner['Investments']['incubators'] = '';
                                 }
                            }

                            $comres6 = array(); $angelinvestors = array();
                            if($rsangelinvestor = mysql_query($angelinvsql))
                            {
                                While($angelinvestorsrow=mysql_fetch_array($rsangelinvestor, MYSQL_BOTH))
                                {

                                    $comres6['Investor Name'] = $angelinvestorsrow["Investor"];
                                    $comres6['Deal Period'] = $angelinvestorsrow["dt"];
                                    $angelinvestors[] = $comres6;
                                }
                                 if(count($angelinvestors) > 0){

                                    $data_inner['Investments']['Angel investors'] = $angelinvestors;
                                 }else{
                                     $data_inner['Investments']['Angel investors'] = '';
                                 }
                            }
                            
                        }
                      
                    }
                    $data['Deal_Details'][] = $data_inner;
                }
                
            }
            
        }
        elseif($dealCategory == 'INCUBATION'){  
            
            if(mysql_num_rows($results) > 0){
           
                while($data_res = mysql_fetch_array($results)) {
                    
                    $res1 = array();
                    $data_inner = array();
                    
                    $data_inner['CompanyName'] = $data_res["companyname"];
                    
                    $dealsql = "SELECT pe.IncubateeId, pec.companyname, pec.industry, i.industry, pec.sector_business,pec.website, pec.AdCity,pec.region,
                        MoreInfor,pe.IncubatorId,inc.Incubator,pec.RegionId,pe.StatusId,pec.yearfounded,Individual,s.Status ,FollowonFund,
                        DATE_FORMAT( date_month_year, '%M-%Y' ) as dt
                        FROM incubatordeals AS pe, industry AS i, pecompanies AS pec,incubators as inc,incstatus as s
                        WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.IncubateeId and pe.Deleted=0 and pec.industry !=15
                        and pe.IncDealId=".$data_res["IncDealId"]." and s.StatusId=pe.StatusId and inc.IncubatorId=pe.IncubatorId ";
                    
                        if ($companyrs = mysql_query($dealsql))
                        {  

                            if($myrow = mysql_fetch_array($companyrs,MYSQL_BOTH))
                            {

                                    $res1['company'] = $myrow["companyname"];

                                    if($myrow["industry"] != "") {

                                        $res1['industry'] = $myrow["industry"];
                                    }
                                    else{

                                        $res1['industry'] = '';
                                    }

                                    if($myrow["sector_business"] != "") {

                                        $res1['sector_business'] = $myrow["sector_business"];
                                    }else{

                                        $res1['sector_business'] = '';
                                    }

                                    if(trim($myrow["AdCity"])!="") { 

                                        $res1['city'] = $myrow["AdCity"];

                                    }else{

                                        $res1['city'] = '';

                                    }
                                    if($myrow["region"] != "") {

                                        $res1['region'] = $myrow["region"];
                                    }else{

                                        $res1['region'] = '';
                                    }

                                    if($myrow["website"] != "") {

                                        $res1['website'] =  $myrow["website"];;
                                    }else{

                                        $res1['website'] = '';
                                    }


                                    if(rtrim($myrow["Incubator"]) != "") {

                                        $res1['Incubator'] = $myrow["Incubator"]; 
                                    }else{

                                        $res1['Incubator'] = ''; 
                                    }

                                    if($myrow["dt"] != ''){ 

                                        $res1['deal_date'] = $myrow["dt"]; 
                                    }
                                    else{ 

                                        $res1['deal_date'] = ''; 

                                    }

                                    if($myrow["Status"] != "") {

                                        $res1['Status'] = $myrow["Status"];

                                    }else{

                                        $res1['Status'] = ""; 
                                    }

                                    if($myrow["FollowonFund"]!=''){

                                        if($myrow["FollowonFund"] == 1){    

                                            $res1['FollowonFund'] ="Yes";
                                        }
                                        else
                                        {    

                                            $res1['FollowonFund'] ="No";
                                        }
                                    }else{
                                        $res1['FollowonFund'] ="";
                                    }

                            }

                            $data_inner['Company Info'][] = $res1;

                            $res5 = array();

                            $moreinfor=$myrow["MoreInfor"];
                            if($moreinfor != ''){

                                $res5['Moreinfo'] = $text = str_replace("\r\n",'', $moreinfor);
                            }else{
                                 $res5['Moreinfo'] = '';
                            }
                            $data_inner['More Info'][] = $res5;
                        }
                        
                        $res6 = array();
                        $uploadname = $myrow["uploadfilename"];
                        $file = "<?php echo GLOBAL_BASE_URL; ?>/uploadmamafiles/" . $uploadname;

                        if($myrow["uploadfilename"] != "")
                        {
                            $res6['File'] = $file;
                        }else{

                            $res6['File'] = '';
                        }
                        $data_inner['Financials Info'][] = $res6;

       //------------------------------------------------------ Company Profile starts----------------------------------------------------------    
                        
                        $sql = "SELECT pe.FinLink, pec.angelco_compID, pec.uploadfilename, pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, 
                            website,linkedIn, stockcode, yearfounded, pec.Address1, pec.Address2, pec.AdCity, pec.Zip, pec.OtherLocation, c.country, pec.Telephone, 
                            pec.Fax, pec.Email, pec.AdditionalInfor, linkedin_companyname
                            FROM pecompanies pec
                            LEFT JOIN peinvestments AS pe ON ( pe.PECompanyId = pec.PECompanyId ) 
                            LEFT JOIN industry i ON ( pec.industry = i.industryid ) 
                            LEFT JOIN country c ON ( c.countryid = pec.countryid ) 
                            WHERE pec.PECompanyId =".$data_res['IncubateeId'];	

                        $company_link_Sql = mysql_query("select * from pecompanies_links where PECompanyId=".$data_res['IncubateeId']); 

                        $incubatorSql = "SELECT pe.IncDealId,pe.IncubatorId,inc.Incubator 
                            FROM `incubatordeals` as pe, incubators as inc 
                            WHERE IncubateeId = ".$data_res['IncubateeId']." and pe.IncubatorId= inc.IncubatorId ";

                        $onMgmtSql = "select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId, exe.ExecutiveName,exe.Designation,exe.Company 
                            FROM pecompanies as pec,executives as exe,pecompanies_management as mgmt
                            WHERE pec.PECompanyId = ".$data_res['IncubateeId']." and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";

                        $onBoardSql = "select pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId,exe.ExecutiveName,exe.Designation,exe.Company 
                            FROM pecompanies as pec,executives as exe,pecompanies_board as bd
                            WHERE pec.PECompanyId = ".$data_res['IncubateeId']." and bd.PECompanyId=pec.PECompanyId and exe.ExecutiveId=bd.ExecutiveId";

                        $investorSql="select pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV 
                            FROM peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,peinvestors as inv 
                            WHERE pe.PECompanyId = ".$data_res['IncubateeId']." and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0
                            and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15 order by dates desc";

                        $maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, inv.Investor,
                            DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId ,pe.ExitStatus, pe.DealTypeId, dt.DealType
                            FROM manda AS pe, industry AS i, pecompanies AS pec,manda_investors as mi ,peinvestors as inv, dealtypes AS dt
                            WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and 
                            pe.PECompanyId = ".$data_res['IncubateeId']." and inv.InvestorId=mi.InvestorId and mi.MandAId=pe.MandAId and 
                            pe.DealTypeId=dt.DealTypeId order by DealDate desc ";

                        $ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,IPOAmount, 
                            DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId ,pe.ExitStatus
                            FROM ipos AS pe, industry AS i, pecompanies AS pec,ipo_investors as ipoi,peinvestors as inv
                            WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and 
                            pe.PECompanyId = ".$data_res['IncubateeId']." and inv.InvestorId=ipoi.InvestorId and ipoi.IPOId=pe.IPOId order by IPODate desc";

                        $angelinvsql="SELECT pe.InvesteeId, pe.AggHide, pec.companyname, pec.industry, i.industry, pec.sector_business,DATE_FORMAT( DealDate, '%b-%Y' ) as dt, 
                            pe.AngelDealId ,peinv.InvestorId,inv.Investor
                            FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec, angel_investors as peinv,peinvestors as inv
                            WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.InvesteeId and pe.Deleted=0 and pec.industry !=15 and pe.InvesteeId = ".$data_res['IncubateeId']."
                            and  peinv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv.InvestorId order by dt desc";
                        
                        $comres = array();
                        if ($companyrs = mysql_query($sql))
                        {      
                            $myrow=mysql_fetch_array($companyrs,MYSQL_BOTH);
                            
                            if($myrow["companyname"]!=''){
                                
                                $comres['Companyname'] = $myrow["companyname"];
                            }else{
                                
                                $comres['Companyname'] = '';
                            }
                            
                            if($myrow["Investor"]!=''){
                                
                                $comres['Investor'] = $myrow["Investor"];
                            }else{
                                
                                $comres['Investor'] = '';
                            }
                            
                            if($myrow["industry"]!=''){
                                
                                $comres['Industry'] = $myrow["industry"];
                            }else{
                                
                                $comres['Industry'] = '';
                            }
                            
                            if($myrow["sector_business"]!=''){
                                
                                $comres['Sector'] = $myrow["sector_business"];
                            }else{
                                
                                $comres['Sector'] = '';
                            }
                            
                            if($myrow["website"]!=''){
                                
                                $comres['Website'] = $myrow["website"];
                            }else{
                                
                                $comres['Website'] = '';
                            }
                            
                            if($myrow["Address1"]!=''){
                                
                                $comres['Address'] = $myrow["Address1"];
                            }else{
                                
                                $comres['Address'] = '';
                            }
                            
                            if($myrow["AdCity"]!=''){
                                
                                $comres['City'] = $myrow["AdCity"];
                            }else{
                                
                                $comres['City'] = '';
                            }
                            
                            if($myrow["Zip"]!=''){
                                
                                $comres['Zipcode'] = $myrow["Zip"];
                            }else{
                                
                                $comres['Zipcode'] = '';
                            }
                            
                            if($myrow["OtherLocation"]!=''){
                                
                                $comres['OtherLocation'] = $myrow["OtherLocation"];
                            }else{
                                
                                $comres['OtherLocation'] = '';
                            }
                            
                            if($myrow["country"]!=''){
                                
                                $comres['Country'] = $myrow["country"];
                            }else{
                                
                                $comres['Country'] = '';
                            }
                            
                            if($myrow["Telephone"]!=''){
                                
                                $comres['Telephone'] = $myrow["Telephone"];
                            }else{
                                
                                $comres['Telephone'] = '';
                            }
                            
                            if($myrow["Fax"]!=''){
                                
                                $comres['Fax'] = $myrow["Fax"];
                            }else{
                                
                                $comres['Fax'] = '';
                            }
                            
                            if($myrow["Email"]!=''){
                                
                                $comres['Email'] = $myrow["Email"];
                            }else{
                                
                                $comres['Email'] = '';
                            }
                            
                            if($myrow["stockcode"]!=''){
                                
                                $comres['Stockcode'] = $myrow["stockcode"];
                            }else{
                                
                                $comres['Stockcode'] = '';
                            }
                            
                             if($myrow["yearfounded"]!=''){
                                
                                $comres['Yearfounded'] = $myrow["yearfounded"];
                            }else{
                                
                                $comres['Yearfounded'] = '';
                            }
                            
                            if($myrow["linkedIn"]!=''){
                                
                                $comres['LinkedIn'] = $myrow["linkedIn"];
                            }else{
                                
                                $comres['LinkedIn'] = '';
                            }
                            
                            if($myrow["linkedin_companyname"]!=''){
                                
                                $comres['LinkedIn_Company'] = $myrow["linkedin_companyname"];
                            }else{
                                
                                $comres['LinkedIn_Company'] = '';
                            }
                            
                            $companyurl=  urlencode($myrow["companyname"]);
                            $company_newssearch="https://www.google.co.in/search?q=".$companyurl."+site:ventureintelligence.com/ddw/";
                            
                            if($company_newssearch!=''){
                                
                                $comres['News'] = $company_newssearch;
                            }else{
                                
                                $comres['News'] = '';
                            }
                            
                            if($myrow["AdditionalInformation"]!=''){
                                
                                $comres['AdditionalInformation'] = $myrow["AdditionalInfor"];
                            }else{
                                
                                $comres['AdditionalInformation'] = '';
                            }

                            $data_inner['Company Profile'][] = $comres;      
                        }
                        
                        $comres1 = array();$topmanagement = array();
                        if($rsMgmt = mysql_query($onMgmtSql))
                        {
                            While($mymgmtrow = mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                            {

                                $comres1['Name'] = $mymgmtrow["ExecutiveName"];
                                $comres1['Designation'] = $mymgmtrow["Designation"];  

                                $topmanagement[] = $comres1;
                            }
                            if(count($topmanagement) > 0){

                                $data_inner['Company Profile']['Top Management'] = $topmanagement;
                            }else{

                                $data_inner['Company Profile']['Top Management'] = '';
                            }
                        }

                        $comres2 = array();$boardmember = array();
                        if($rsBoard = mysql_query($onBoardSql))
                        {
                            While($myboardrow = mysql_fetch_array($rsBoard, MYSQL_BOTH))
                            {

                                $comres2['Name'] = $myboardrow["ExecutiveName"];
                                $comres2['Designation'] = $myboardrow["Designation"].', '.$myboardrow["Company"];  
                                $comres2['LinkedIn'] = "https://www.google.co.in/search?q=".$myboardrow["ExecutiveName"].$myboardrow["Designation"].$myboardrow["Company"]. "+site%3Alinkedin.com"; 

                                $boardmember[]=$comres2;
                            }
                             if(count($boardmember) > 0){

                                $data_inner['Company Profile']['Investor Board Member'] = $boardmember;
                             }else{
                                 $data_inner['Company Profile']['Investor Board Member'] = '';
                             }
                        }
                        
                        $comres3 = array(); $investors = array();
                        if($rsinvestor = mysql_query($investorSql))
                        {
                            While($investorsrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                            {

                                $comres3['Investor Name'] = $investorsrow["Investor"];
                                $comres3['Deal Period'] = $investorsrow["dt"];
                                $investors[] = $comres3;
                            }
                             if(count($investors) > 0){

                                $data_inner['Investments']['PE/VC investors'] = $investors;
                             }else{
                                 $data_inner['Investments']['PE/VC investors'] = '';
                             }
                        }
                        
                        $comres4 = array(); $incubators = array();
                        if($rsincubator = mysql_query($ipoexitsql))
                        {
                            While($incsrow=mysql_fetch_array($rsincubator, MYSQL_BOTH))
                            {

                                $comres4['Investor Name'] = $incsrow["Investor"];
                                $comres4['Deal Period'] = $incsrow["dt"];
                                
                                if($incsrow["ExitStatus"]){
                                    
                                    if($incsrow["ExitStatus"]==0){
                                        
                                        $comres4['Exitstatus'] = "Partial Exit";
                                    }
                                   elseif($incsrow["ExitStatus"]==1){  
                                       
                                        $comres4['Exitstatus'] = "Complete Exit";
                                       
                                   }
                                    
                                }else{
                                    $comres4['Exitstatus'] = "";
                                }
                          
                                $incubators[] = $comres4;
                            }
                             if(count($incubators) > 0){

                                $data_inner['Investments']['Incubators'] = $incubators;
                             }else{
                                 $data_inner['Investments']['incubators'] = '';
                             }
                        }
                        
                        $comres5 = array(); $maincubators = array();
                        if($rsmaincubator = mysql_query($maexitsql))
                        {
                            While($maincsrow=mysql_fetch_array($rsmaincubator, MYSQL_BOTH))
                            {

                                $comres5['Investor Name'] = $maincsrow["Investor"];
                                $comres5['Deal Period'] = $maincsrow["dt"];
                                
                                if($maincsrow["ExitStatus"]){
                                    
                                    if($maincsrow["ExitStatus"]==0){
                                        
                                        $comres4['Exitstatus'] = "Partial Exit";
                                    }
                                   elseif($maincsrow["ExitStatus"]==1){  
                                       
                                        $comres4['Exitstatus'] = "Complete Exit";
                                       
                                   }
                                    
                                }else{
                                    $comres4['Exitstatus'] = "";
                                }
                                $maincubators[] = $comres4;
                            }
                             if(count($maincubators) > 0){

                                $data_inner['Investments']['Incubators'] = $maincubators;
                             }else{
                                 $data_inner['Investments']['incubators'] = '';
                             }
                        }
                        
                        $comres6 = array(); $angelinvestors = array();
                        if($rsangelinvestor = mysql_query($angelinvsql))
                        {
                            While($angelinvestorsrow=mysql_fetch_array($rsangelinvestor, MYSQL_BOTH))
                            {

                                $comres6['Investor Name'] = $angelinvestorsrow["Investor"];
                                $comres6['Deal Period'] = $angelinvestorsrow["dt"];
                                $angelinvestors[] = $comres6;
                            }
                             if(count($angelinvestors) > 0){

                                $data_inner['Investments']['Angel investors'] = $angelinvestors;
                             }else{
                                 $data_inner['Investments']['Angel investors'] = '';
                             }
                        }
            
                        $data['Deal_Details'][] = $data_inner;
                }
            }
            
            
        }
        
   
    }elseif($datatype==2 && $dealType==1){
        
        if($dealCategory == 'PE' || $dealCategory == 'VC' || $dealCategory == 'SOCIAL' || $dealCategory == 'CLEANTECH' || $dealCategory == 'INFRASTRUCTURE'){
            
            $res = array(); $data_inner = array();$cos_array = array();$res1 = array();
        
            while($data_res = mysql_fetch_array($results)) {
                //echo "dd".$data_res["AggHide"];
                 //echo "ss".$data_res["SPV"];
                if($data_res["AggHide"] == 1){

                    $NoofDealsCntTobeDeducted = 1;

                }elseif($data_res["SPV"] == 1){

                    $NoofDealsCntTobeDeducted = 1;

                }
                else{

                    $NoofDealsCntTobeDeducted = 0;
                    $cos_array[] = $data_res["PECompanyId"];
                }

                if($data_res["AggHide"] == 1)
                {

                    $amtTobeDeductedagg = $data_res["amount"];
                }
                else
                {
                    $amtTobeDeductedagg = 0;
                }
                if($data_res["SPV"] == 1)          //Debt
                {

                    $amtTobeDeducted=$data_res["amount"];
                }
                else
                {
                    $amtTobeDeducted = 0;
                }

                $totalInv=$totalInv+1-$NoofDealsCntTobeDeducted;
                $coscount = count(array_count_values($cos_array));
                $totalAmount=$totalAmount+ $data_res["amount"]-$amtTobeDeducted-$amtTobeDeductedagg;
            }
            $res1['total Deals'] = $totalInv;
            $res1['total_companies'] = $coscount;
            $res1['total_amount'] = round($totalAmount);

            if($res1['total Deals'] > 0 && $res1['total_amount'] > 0){
                $data_inner['aggregate_details']= $res1;
            }


            mysql_data_seek($results,0);

            while($data_res = mysql_fetch_array($results)) {

                $res['companyname'] = $data_res['companyname'];

                if(trim($data_res["sector_business"]) == ""){

                    $res['sector'] = $data_res["industry"];
                }
                else{

                    $res['sector'] = $data_res["sector_business"];
                }

                if($data_res["Investor"] != ''){

                    $res['investors'] = $data_res["Investor"];
                }else{

                     $res['investors'] = '';
                }

                if($data_res["dealperiod"] != ''){

                    $res['dealperiod'] = $data_res["dealperiod"];
                }else{

                     $res['dealperiod'] = '';
                }

                if($data_res["Exit_Status"] == 1){

                    $res['exitstatus'] = 'Unexited';
                }
                else if($data_res["Exit_Status"] == 2){

                     $res['exitstatus']  = 'Partially Exited';
                }
                else if($data_res["Exit_Status"] == 3){

                     $res['exitstatus']  = 'Fully Exited';
                }
                else{

                    $res['exitstatus']  = '';
                }

                if($data_res["hideamount"]==1)
                {
                    $res['Amount']="--";
                }
                else
                {
                    $res['Amount'] = $data_res["amount"];
                }

                $data_inner['Deals'][]= $res;

            }
            
        }
        elseif($dealCategory == 'ANGEL'){
            
            $res = array(); $data_inner = array();$cos_array = array();$res1=array();
            while($data_res = mysql_fetch_array($results)) {
                
                if($data_res["AggHide"]==1)
                {
                        $NoofDealsCntTobeDeducted=1;
                }
                else
                {
                        $NoofDealsCntTobeDeducted=0;
                        $cos_array[]=$data_res["PECompanyId"];
                }
             
                $totalInv=$totalInv+1-$NoofDealsCntTobeDeducted;
            }
            $res1['total Deals'] = $totalInv;
            $res1['total_companies'] = count(array_count_values($cos_array));
            
            if($res1['total Deals'] > 0){
                $data_inner['aggregate_details']= $res1;
            }
            
            mysql_data_seek($results,0);
            
            while($data_res = mysql_fetch_array($results)) {

                $res['investee'] = $data_res['companyname'];

                if(trim($data_res["sector_business"]) == ""){

                    $res['sector'] = $data_res["industry"];
                }
                else{

                    $res['sector'] = $data_res["sector_business"];
                }
                
                $res['Investor'] = $data_res['Investor'];
                
                if($data_res['dealperiod']!=''){

                    $res['date'] = date('M-Y', strtotime($data_res['dealperiod']));
                }else{

                     $res['date'] = '';
                }
                
                $data_inner['Deals'][]= $res;

            }
            
        }
        elseif($dealCategory == 'INCUBATION'){
            
            $res = array(); $data_inner = array();$cos_array = array();$res1=array();
            while($data_res = mysql_fetch_array($results)) {
                
                $cos_array[]=$data_res["companyid"];
                $totalInv=$totalInv+1;
            }
            $res1['total Deals'] = $totalInv;
            $res1['total_companies'] = count(array_count_values($cos_array));
            
            if($res1['total Deals'] > 0){
                $data_inner['aggregate_details']= $res1;
            }
            
            mysql_data_seek($results,0);
            
            while($data_res = mysql_fetch_array($results)) {

                $res['Incubatee'] = $data_res['companyname'];
                $res['Incubator'] = $data_res['Incubator'];

                if(trim($data_res["sector_business"]) == ""){

                    $res['sector'] = $data_res["industry"];
                }
                else{

                    $res['sector'] = $data_res["sector_business"];
                }

                if($data_res['date_month_year']!='0000-00-00'){

                    $res['date'] = date('M-Y', strtotime($data_res['date_month_year']));
                }else{

                     $res['date'] = '';
                }
                
                $data_inner['Deals'][]= $res;

            }
            
        }
               
        if(count($data_inner) > 0){
            $data['Deals_Aggregate'] = $data_inner;
        }
        
    }elseif($datatype==1 && $dealType==2){
        
        if($dealCategory == 'PEMA' || $dealCategory == 'VCMA' || $dealCategory == 'PEPM' || $dealCategory == 'VCPM'){ 
            
             if(mysql_num_rows($results) > 0){
                 
                
                while($data_res = mysql_fetch_array($results)) {
                    
                    $res1 = array();$data_inner = array();
                    $dealsql="SELECT pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, pec.industry, i.industry, pec.sector_business,
                        DealAmount, DATE_FORMAT( DealDate, '%M-%Y' ) as dt, pec.website,pe.MandAId,pe.Comment,MoreInfor,type,hideamount,hidemoreinfor,pe.DealTypeId,dt.DealType,
                        pe.InvestmentDeals,pe.Link,pe.EstimatedIRR,pe.MoreInfoReturns,it.InvestorTypeName,pec.uploadfilename,pe.source,pe.Valuation,pe.FinLink,pe.Company_Valuation,
                        pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple,pe.ExitStatus,pe.Revenue,pe.EBITDA,pe.PAT
                        FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,investortype as it
                        WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.MandAId=".$data_res['MandAId']."
                        and dt.DealTypeId=pe.DealTypeId and it.InvestorType=pe.InvestorType";

                    $AcquirerSql= "select peinv.MandAId,peinv.AcquirerId,ac.Acquirer from manda as peinv,acquirers as ac
                        where peinv.MandAId=".$data_res['MandAId']." and ac.AcquirerId=peinv.AcquirerId";

                    $investorSql="select peinv.MandAId,peinv.InvestorId,inv.Investor,peinv.MultipleReturn,InvMoreInfo from manda_investors as peinv,peinvestors as inv 
                        where peinv.MandAId=".$data_res['MandAId']." and inv.InvestorId=peinv.InvestorId";

                    $advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,AdvisorType from peinvestments_advisorcompanies as advcomp,advisor_cias as cia 
                        where advcomp.PEId=".$data_res['MandAId']." and advcomp.CIAId=cia.CIAId";

                    $adacquirersql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from peinvestments_advisoracquirer as advinv,advisor_cias as cia 
                        where advinv.PEId=".$data_res['MandAId']." and advinv.CIAId=cia.CIAId";
                  
                    $data_inner['CompanyName'] = $data_res["companyname"];
                    
                    if ($getAcquirerSql = mysql_query($AcquirerSql))
                    {
                        $res1['Acquirer']='';
                        While($myAcquirerrow=mysql_fetch_array($getAcquirerSql, MYSQL_BOTH))
                        {

                            $acquirer = $myAcquirerrow["Acquirer"];
                        }
                        if(rtrim($acquirer, ',') !=''){

                            $res1['Acquirer'] = $acquirer;
                        }else{
                            $res1['Acquirer'] = "";
                        }
                    }
                    $dealrs = mysql_query($dealsql);
                    if($dealrow=mysql_fetch_array($dealrs,MYSQL_BOTH))
                    {
                            
                        if($dealrow["hideamount"] != ''){
                            
                            if($dealrow["hideamount"] == 1)
                            {
                                $res1['Deal Size'] = "--";
                            }
                            else
                            {
                                $res1['Deal Size'] = $dealrow["DealAmount"];
                            }
                        }else{
                            $res1['Deal Size'] = "";
                        }
                        
                        if($dealrow["DealType"] != ''){
                            
                            if($res1['DealType']==4){
                                
                                $res1['DealType'] = $dealrow["DealType"];
                                
                                if($dealrow["type"] == 1){
                                    
                                    $res1['Type'] = 'IPO';
                                    
                                }elseif($dealrow["type"] == 2){
                                    
                                    $res1['Type'] = 'Open Market Transaction';
                                    
                                }elseif($dealrow["type"] == 2){
                                    
                                    $res1['Type'] = 'Reverse Merger';
                                }
                                else{
                                    
                                    $res1['Type'] = 'Open Market Transaction';
                                }
                            }else{
                                 $res1['DealType'] = $dealrow["DealType"];
                            }
                        }else{
                            $res1['DealType'] = "";
                        }
                        
                        if($dealrow["ExitStatus"] != ''){
                            
                            if($dealrow["ExitStatus"]==0){
                                
                                $res1['Exitstatus'] = "Partial";
                            }
                            elseif($dealrow["ExitStatus"]==1){
                                
                                $res1['Exitstatus'] = "Complete";
                            }
                        }
                        else{
                            
                            $res1['Exitstatus'] = "";
                        }
                        
                        if($dealrow["dt"] != ''){
                            
                            $res1['Date'] = $dealrow["dt"];
                        }else{
                            
                            $res1['Date'] = "";
                        }
                        
                        
                        $data_inner['Deal Info'][] = $res1;
                    }
                    
                    $res3 = array();
                    
                    if($data_res["companyname"] != ''){
                        
                        $res3['company'] = rtrim($data_res["companyname"]);
                    }else{
                        
                        $res3['company'] = '';
                    }
                    
                    if($data_res["sector_business"] != ''){
                        
                        $res3['sector'] = rtrim($data_res["sector_business"]);
                    }else{
                        
                        $res3['sector'] = '';
                    }
                    
                    if($data_res["industry"] != ''){
                        
                        $res3['industry'] = rtrim($data_res["industry"]);
                        
                    }else{
                        
                        $res3['industry'] = '';
                    }
                    
                    if($data_res["website"] != ''){
                        
                        $res3['website'] = rtrim($data_res["website"]);
                        
                    }else{
                        
                        $res3['website'] = '';
                    }
                    
                    $data_inner['Company Info'][] = $res3;
                    
                    $res2=array();
                    
                    if ($getinvrs = mysql_query($investorSql))
                    {
                        While($myInvrow=mysql_fetch_array($getinvrs, MYSQL_BOTH))
                        {
                            if($myInvrow["Investor"]){
                                
                                $res2['investor'] = $myInvrow["Investor"];
                            }else{
                                
                                $res2['investor'] = '';
                            }
                            
                        }
                    }
                    
                    if($data_res["InvestorTypeName"] != ''){
                        
                        $res2['Type'] = $data_res["InvestorTypeName"];
                    }else{
                        
                        $res2['Type'] = '';
                    }
                    
                    if ($getcompanyrs = mysql_query($advcompanysql))
                    {
                        
                        While($myadcomprow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                        {
                            if($myadcomprow["cianame"] != ''){
                                
                                $res2['Advisor Seller'] = $myadcomprow["cianame"];
                            }else{
                                
                                $res2['Advisor Seller'] = '';
                            }
                        }
                    }
                    
                    if ($getadvrs = mysql_query($adacquirersql))
                    {
                        
                        While($myadinvrow=mysql_fetch_array($getadvrs, MYSQL_BOTH))
                        {
                            if($myadinvrow["cianame"] != ''){
                                
                                $res2['Advisor Buyer'] = $myadinvrow["cianame"];
                            }else{
                                
                                $res2['Advisor Buyer'] = '';
                            }
                        }
                    }
                    
                    if($data_res["MoreInfor"] != ''){
                        
                        $res2['More Details'] = $data_res["MoreInfor"];
                    }else{
                        
                        $res2['More Details'] = '';
                    }
                    
                    $data_inner['Investor and Advisor Info'][] = $res2;
                    
                     $res6 = array();
                    if($myrow["uploadfilename"] != ''){
                        
                        $uploadname=$myrow["uploadfilename"];
                        $res6['file'] = GLOBAL_BASE_URL.'uploadmamafiles/' . $uploadname;
                    }else{
                        
                        $res6['file'] = '';
                    }
                    $data_inner['Finalcial Info'][] = $res6;
                   
                    if($data_res["InvestmentDeals"] != ''){

                        $res4['Investment Details'] = $data_res["InvestmentDeals"];
                    }else{

                        $res4['Investment Details'] = '';
                    }
                    
                    $data_inner['Investor and Advisor Info'][] = $res4;
                    
                    $res5 = array();
                    if($dealrow["Company_Valuation"] <= 0){
                        
                        $res5['Company Valuation - Equity - Post Money (INR Cr)'] = 0.00;
                    }
                    else{
                        
                        $res5['Company Valuation - Equity - Post Money (INR Cr)'] = $dealrow["Company_Valuation"];
                    }
                    if($dealrow["Revenue_Multiple"] <= 0){
                        
                        $res5['Revenue Multiple (based on Equity Value / Market Cap)'] = 0.00;
                    }
                    else{
                        
                        $res5['Revenue Multiple (based on Equity Value / Market Cap)'] = $dealrow["Revenue_Multiple"];
                    }

                    if($dealrow["EBITDA_Multiple"] <= 0){
                        
                        $res5['EBITDA Multiple (based on Equity Value)'] = 0.00;
                    }
                    else{
                        
                        $res5['EBITDA Multiple (based on Equity Value)'] = $dealrow["EBITDA_Multiple"];
                    }
                    if($dealrow["PAT_Multiple"] <= 0){
                        
                        $res5['PAT Multiple (based on Equity Value)'] = 0.00;
                    }
                    else{
                        
                         $res5['PAT Multiple (based on Equity Value)'] = $dealrow["PAT_Multiple"];
                    }
                    
                    if($dealrow["price_to_book"] <= 0){
                        
                       $res5['price_to_book'] = 0.00;
                    }
                    else{
                        
                        $res5['price_to_book'] = $dealrow["price_to_book"];
                    }
                    
                    if($dealrow["Valuation"] != ''){
                        
                        $res5['Valuation'] = trim($dealrow["Valuation"]);
                    }else{
                        
                        $res5['Valuation'] = '';
                    }
                    
                    if($dealrow["Company_Valuation"] > 0 && $dealrow["Revenue_Multiple"] > 0){

                        $res5['Revenue'] = number_format($dealrow["Company_Valuation"]/$dealrow["Revenue_Multiple"], 2, '.', '');
                    }else{
                         $res5['Revenue'] = '';
                    }
                  
                    if($dealrow["Company_Valuation"] > 0 && $dealrow["EBITDA_Multiple"] > 0){
                        
                        $res5['EBITDA'] = number_format($dealrow["Company_Valuation"]/$dealrow["EBITDA_Multiple"], 2, '.', '');
                        
                    }else{
                        
                        $res5['EBITDA'] = '';
                    }
                    
                    if($dealrow["Company_Valuation"] > 0 && $dealrow["PAT_Multiple"] > 0){
                        
                        $res5['PAT'] = number_format($dealrow["Company_Valuation"]/$dealrow["PAT_Multiple"], 2, '.', '');
                        
                    }else{
                        
                        $res5['PAT'] = '';
                    }
                    
                    if($dealrow["book_value_per_share"]<=0){
                        
                        $res5['book_value_per_share'] = 0.00;
                    }
                    else{
                        
                        $res5['book_value_per_share'] = $dealrow["book_value_per_share"];
                    }


                    if($dealrow["price_per_share"]<=0){
                        
                        $res5['price_per_share'] = 0.00;
                    }
                    else{
                        
                        $res5['price_per_share'] = $dealrow["price_per_share"];
                    }
                   
                    $data_inner['Exit Details'][] = $res5;
                   
                    
                    //------------------------------------------------------ Company Profile starts----------------------------------------------------------  
                    
                    $comsql="SELECT pe.FinLink, pec.angelco_compID, pec.uploadfilename, pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, website,
                        linkedIn, stockcode, yearfounded, pec.Address1, pec.Address2, pec.AdCity, pec.Zip, pec.OtherLocation, c.country, pec.Telephone, pec.Fax, pec.Email, 
                        pec.AdditionalInfor, linkedin_companyname
                        FROM pecompanies pec
                        LEFT JOIN peinvestments AS pe ON ( pe.PECompanyId = pec.PECompanyId ) 
                        LEFT JOIN industry i ON ( pec.industry = i.industryid ) 
                        LEFT JOIN country c ON ( c.countryid = pec.countryid ) 
                        WHERE pec.PECompanyId =".$data_res['PECompanyId'];	
        
                    $company_link_Sql =mysql_query("select * from pecompanies_links where PECompanyId=".$data_res['PECompanyId']); 
       
                    $incubatorSql="SELECT pe.IncDealId,pe.IncubatorId,inc.Incubator 
                        FROM `incubatordeals` as pe, incubators as inc WHERE IncubateeId =".$data_res['PECompanyId']." and pe.IncubatorId= inc.IncubatorId ";

                    $onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,exe.ExecutiveName,exe.Designation,exe.Company 
                        FROM pecompanies as pec,executives as exe,pecompanies_management as mgmt
                        WHERE pec.PECompanyId=".$data_res['PECompanyId']." and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";

                    $onBoardSql="select pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId,exe.ExecutiveName,exe.Designation,exe.Company 
                        FROM pecompanies as pec,executives as exe,pecompanies_board as bd
                        WHERE pec.PECompanyId=".$data_res['PECompanyId']." and bd.PECompanyId=pec.PECompanyId and exe.ExecutiveId=bd.ExecutiveId";

                    $investorSql="select pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV 
                        FROM peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec, peinvestors as inv 
                        WHERE pe.PECompanyId=".$data_res['PECompanyId']." and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0
                        and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15 order by dates desc";

                    $maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, inv.Investor,DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, 
                        pe.MandAId ,pe.ExitStatus, pe.DealTypeId, dt.DealType
                        FROM manda AS pe, industry AS i, pecompanies AS pec,manda_investors as mi ,peinvestors as inv, dealtypes AS dt
                        WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=".$data_res['PECompanyId']."
                        and inv.InvestorId=mi.InvestorId and mi.MandAId=pe.MandAId and pe.DealTypeId=dt.DealTypeId order by DealDate desc ";

                    $ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor, IPOAmount, DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId ,pe.ExitStatus
                        FROM ipos AS pe, industry AS i, pecompanies AS pec,ipo_investors as ipoi,peinvestors as inv
                        WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=".$data_res['PECompanyId']."
                        and inv.InvestorId=ipoi.InvestorId and ipoi.IPOId=pe.IPOId order by IPODate desc";

                    $angelinvsql="SELECT pe.InvesteeId, pe.AggHide, pec.companyname, pec.industry, i.industry, pec.sector_business,DATE_FORMAT( DealDate, '%b-%Y' ) as dt, 
                        pe.AngelDealId ,peinv.InvestorId,inv.Investor
                        FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,angel_investors as peinv,peinvestors as inv
                        WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.InvesteeId and pe.Deleted=0 and pec.industry !=15 and pe.InvesteeId=".$data_res['PECompanyId']."
                        and  peinv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv.InvestorId order by dt desc";
                    
                        $comres = array();
                            if ($companyrs = mysql_query($comsql))
                            {      
                                $myrow=mysql_fetch_array($companyrs,MYSQL_BOTH);

                                if($myrow["companyname"]!=''){

                                    $comres['Companyname'] = $myrow["companyname"];
                                }else{

                                    $comres['Companyname'] = '';
                                }

                                if($myrow["Investor"]!=''){

                                    $comres['Investor'] = $myrow["Investor"];
                                }else{

                                    $comres['Investor'] = '';
                                }

                                if($myrow["industry"]!=''){

                                    $comres['Industry'] = $myrow["industry"];
                                }else{

                                    $comres['Industry'] = '';
                                }

                                if($myrow["sector_business"]!=''){

                                    $comres['Sector'] = $myrow["sector_business"];
                                }else{

                                    $comres['Sector'] = '';
                                }

                                if($myrow["website"]!=''){

                                    $comres['Website'] = $myrow["website"];
                                }else{

                                    $comres['Website'] = '';
                                }

                                if($myrow["Address1"]!=''){

                                    $comres['Address'] = $myrow["Address1"];
                                }else{

                                    $comres['Address'] = '';
                                }

                                if($myrow["AdCity"]!=''){

                                    $comres['City'] = $myrow["AdCity"];
                                }else{

                                    $comres['City'] = '';
                                }

                                if($myrow["Zip"]!=''){

                                    $comres['Zipcode'] = $myrow["Zip"];
                                }else{

                                    $comres['Zipcode'] = '';
                                }

                                if($myrow["OtherLocation"]!=''){

                                    $comres['OtherLocation'] = $myrow["OtherLocation"];
                                }else{

                                    $comres['OtherLocation'] = '';
                                }

                                if($myrow["country"]!=''){

                                    $comres['Country'] = $myrow["country"];
                                }else{

                                    $comres['Country'] = '';
                                }

                                if($myrow["Telephone"]!=''){

                                    $comres['Telephone'] = $myrow["Telephone"];
                                }else{

                                    $comres['Telephone'] = '';
                                }

                                if($myrow["Fax"]!=''){

                                    $comres['Fax'] = $myrow["Fax"];
                                }else{

                                    $comres['Fax'] = '';
                                }

                                if($myrow["Email"]!=''){

                                    $comres['Email'] = $myrow["Email"];
                                }else{

                                    $comres['Email'] = '';
                                }

                                if($myrow["stockcode"]!=''){

                                    $comres['Stockcode'] = $myrow["stockcode"];
                                }else{

                                    $comres['Stockcode'] = '';
                                }

                                 if($myrow["yearfounded"]!=''){

                                    $comres['Yearfounded'] = $myrow["yearfounded"];
                                }else{

                                    $comres['Yearfounded'] = '';
                                }

                                if($myrow["linkedIn"]!=''){

                                    $comres['LinkedIn'] = $myrow["linkedIn"];
                                }else{

                                    $comres['LinkedIn'] = '';
                                }

                                if($myrow["linkedin_companyname"]!=''){

                                    $comres['LinkedIn_Company'] = $myrow["linkedin_companyname"];
                                }else{

                                    $comres['LinkedIn_Company'] = '';
                                }

                                $companyurl=  urlencode($myrow["companyname"]);
                                $company_newssearch="https://www.google.co.in/search?q=".$companyurl."+site:ventureintelligence.com/ddw/";

                                if($company_newssearch!=''){

                                    $comres['News'] = $company_newssearch;
                                }else{

                                    $comres['News'] = '';
                                }

                                if($myrow["AdditionalInformation"]!=''){

                                    $comres['AdditionalInformation'] = $myrow["AdditionalInfor"];
                                }else{

                                    $comres['AdditionalInformation'] = '';
                                }

                                $data_inner['Company Profile'][] = $comres;      
                            }

                            $comres1 = array();$topmanagement = array();
                            if($rsMgmt = mysql_query($onMgmtSql))
                            {
                                While($mymgmtrow = mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                                {

                                    $comres1['Name'] = $mymgmtrow["ExecutiveName"];
                                    $comres1['Designation'] = $mymgmtrow["Designation"];  

                                    $topmanagement[] = $comres1;
                                }
                                if(count($topmanagement) > 0){

                                    $data_inner['Company Profile']['Top Management'] = $topmanagement;
                                }else{

                                    $data_inner['Company Profile']['Top Management'] = '';
                                }
                            }
                            
                            $comres2 = array();$boardmember = array();
                            if($rsBoard = mysql_query($onBoardSql))
                            {
                                While($myboardrow = mysql_fetch_array($rsBoard, MYSQL_BOTH))
                                {

                                    $comres2['Name'] = $myboardrow["ExecutiveName"];
                                    $comres2['Designation'] = $myboardrow["Designation"].', '.$myboardrow["Company"];  
                                    $comres2['LinkedIn'] = "https://www.google.co.in/search?q=".$myboardrow["ExecutiveName"].$myboardrow["Designation"].$myboardrow["Company"]. "+site%3Alinkedin.com"; 

                                    $boardmember[]=$comres2;
                                }
                                 if(count($boardmember) > 0){

                                    $data_inner['Company Profile']['Investor Board Member'] = $boardmember;
                                 }else{
                                     $data_inner['Company Profile']['Investor Board Member'] = '';
                                 }
                            }

                            $comres3 = array(); $investors = array();
                            if($rsinvestor = mysql_query($investorSql))
                            {
                                While($investorsrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                {

                                    $comres3['Investor Name'] = $investorsrow["Investor"];
                                    $comres3['Deal Period'] = $investorsrow["dt"];
                                    $investors[] = $comres3;
                                }
                                 if(count($investors) > 0){

                                    $data_inner['Investments']['PE/VC investors'] = $investors;
                                 }else{
                                     $data_inner['Investments']['PE/VC investors'] = '';
                                 }
                            }
                            
                            $comres4 = array(); $incubators = array();
                            if($rsincubator = mysql_query($ipoexitsql))
                            {
                                While($incsrow=mysql_fetch_array($rsincubator, MYSQL_BOTH))
                                {

                                    $comres4['Investor Name'] = $incsrow["Investor"];
                                    $comres4['Deal Period'] = $incsrow["dt"];

                                    if($incsrow["ExitStatus"]){

                                        if($incsrow["ExitStatus"]==0){

                                            $comres4['Exitstatus'] = "Partial Exit";
                                        }
                                       elseif($incsrow["ExitStatus"]==1){  

                                            $comres4['Exitstatus'] = "Complete Exit";

                                       }

                                    }else{
                                        $comres4['Exitstatus'] = "";
                                    }

                                    $incubators[] = $comres4;
                                }
                                 if(count($incubators) > 0){

                                    $data_inner['Investments']['Incubators'] = $incubators;
                                 }else{
                                     $data_inner['Investments']['incubators'] = '';
                                 }
                            }

                            $comres5 = array(); $maincubators = array();
                            if($rsmaincubator = mysql_query($maexitsql))
                            {
                                While($maincsrow=mysql_fetch_array($rsmaincubator, MYSQL_BOTH))
                                {

                                    $comres5['Investor Name'] = $maincsrow["Investor"];
                                    $comres5['Deal Period'] = $maincsrow["dt"];

                                    if($maincsrow["ExitStatus"]){

                                        if($maincsrow["ExitStatus"]==0){

                                            $comres4['Exitstatus'] = "Partial Exit";
                                        }
                                       elseif($maincsrow["ExitStatus"]==1){  

                                            $comres4['Exitstatus'] = "Complete Exit";

                                       }

                                    }else{
                                        $comres4['Exitstatus'] = "";
                                    }
                                    $maincubators[] = $comres4;
                                }
                                 if(count($maincubators) > 0){

                                    $data_inner['Investments']['Incubators'] = $maincubators;
                                 }else{
                                     $data_inner['Investments']['incubators'] = '';
                                 }
                            }

                            $comres6 = array(); $angelinvestors = array();
                            if($rsangelinvestor = mysql_query($angelinvsql))
                            {
                                While($angelinvestorsrow=mysql_fetch_array($rsangelinvestor, MYSQL_BOTH))
                                {

                                    $comres6['Investor Name'] = $angelinvestorsrow["Investor"];
                                    $comres6['Deal Period'] = $angelinvestorsrow["dt"];
                                    $angelinvestors[] = $comres6;
                                }
                                 if(count($angelinvestors) > 0){

                                    $data_inner['Investments']['Angel investors'] = $angelinvestors;
                                 }else{
                                     $data_inner['Investments']['Angel investors'] = '';
                                 }
                            }
                    
                    
                    
                    $data['Deal_Details'][] = $data_inner;
                    
                }
                
            }
            
            
        }
        elseif($dealCategory == 'PEIPO' || $dealCategory == 'VCIPO'){
            
             if(mysql_num_rows($results) > 0){
                 
                
                while($data_res = mysql_fetch_array($results)) {
                    
                    $res1 = array();$data_inner = array();
                    $dealsql = "SELECT pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, pec.industry, i.industry, pec.sector_business,
                    pe.IPOSize,pe.IPOAmount, pe.IPOValuation, DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate ,pec.website, pec.city, pec.region,pe.IPOId,Comment,MoreInfor,hideamount,
                    hidemoreinfor,pe.InvestmentDeals,pe.Link,pe.EstimatedIRR,pe.MoreInfoReturns,pe.InvestorType, its.InvestorTypeName,Valuation,FinLink,
                    Company_Valuation,Sales_Multiple,EBITDA_Multiple,Netprofit_Multiple,InvestorSale,SellingInvestors,ExitStatus,Revenue,EBITDA,PAT,pec.uploadfilename
                    FROM ipos AS pe, industry AS i, pecompanies AS pec,investortype as its
                    WHERE pec.industry = i.industryid and pe.IPOId =".$data_res['IPOId']." and pec.PEcompanyId = pe.PECompanyId and its.InvestorType=pe.InvestorType
                    and pe.Deleted=0 order by IPOSize desc,i.industry";

                    $investorSql="SELECT peinv.IPOId, peinv.InvestorId, inv.Investor,MultipleReturn,InvMoreInfo
                    FROM ipo_investors AS peinv, peinvestors AS inv
                    WHERE peinv.IPOId =".$data_res['IPOId']." AND inv.InvestorId = peinv.InvestorId";

                    $advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame 
                    FROM peinvestments_advisorcompanies as advcomp, advisor_cias as cia 
                    WHERE advcomp.PEId=".$data_res['IPOId']." and advcomp.CIAId=cia.CIAId";

                    $dealrs = mysql_query($dealsql);
                    if($dealrow=mysql_fetch_array($dealrs,MYSQL_BOTH))
                    {

                        if($dealrow["hideamount"] != ''){

                            if($dealrow["hideamount"] == 1)
                            {
                                $res1['IPO Size (US $M)'] = "--";
                            }
                            else
                            {
                                $res1['IPO Size (US $M)'] = $dealrow["IPOSize"];
                            }
                        }else{
                            $res1['IPO Size (US $M)'] = "";
                        }


                        if($dealrow["IPOAmount"]!=''){

                            if($dealrow["IPOAmount"] <= 0)
                            { 
                                $res1['IPO Price']="";

                            }else{
                                $res1['IPO Price'] = $dealrow["IPOAmount"];
                            }

                        }else{
                            $res1['IPO Price'] = "";
                        }

                        if($dealrow["IPOValuation"]!=''){

                            if($dealrow["IPOValuation"] <= 0)
                            {  
                                $res1['IPO Valuation'] = '';

                            }else{

                                $res1['IPO Valuation'] = $dealrow["IPOValuation"];
                            }
                        }else{
                            $res1['IPO Valuation'] = '';
                        }


                       if($dealrow["IPODate"] !=''){

                           $res1['Deal Period'] = $dealrow["IPODate"];
                       }else{

                           $res1['Deal Period'] = '';
                       }

                        if($dealrow["ExitStatus"] != ''){

                            if($dealrow["ExitStatus"]==0){

                                $res1['Exitstatus'] = "Partial";
                            }
                            elseif($dealrow["ExitStatus"]==1){

                                $res1['Exitstatus'] = "Complete";
                            }
                        }
                        else{

                            $res1['Exitstatus'] = "";
                        }

                        $data_inner['Deal Info'][] = $res1;
                        
                        $res3 = array();
                    
                        if($data_res["companyname"] != ''){

                            $res3['company'] = rtrim($data_res["companyname"]);
                        }else{

                            $res3['company'] = '';
                        }

                        if($data_res["sector_business"] != ''){

                            $res3['sector'] = rtrim($data_res["sector_business"]);
                        }else{

                            $res3['sector'] = '';
                        }

                        if($data_res["industry"] != ''){

                            $res3['industry'] = rtrim($data_res["industry"]);

                        }else{

                            $res3['industry'] = '';
                        }

                        if($data_res["website"] != ''){

                            $res3['website'] = rtrim($data_res["website"]);

                        }else{

                            $res3['website'] = '';
                        }

                        $data_inner['Company Info'][] = $res3;

                        $res5 = array();
                        if($dealrow["Company_Valuation"] <= 0){

                            $res5['Company Valuation - Equity - Post Money (INR Cr)'] = 0.00;
                        }
                        else{

                            $res5['Company Valuation - Equity - Post Money (INR Cr)'] = $dealrow["Company_Valuation"];
                        }
                        if($dealrow["Sales_Multiple"] <= 0){

                            $res5['Revenue Multiple (based on Equity Value / Market Cap)'] = 0.00;
                        }
                        else{

                            $res5['Revenue Multiple (based on Equity Value / Market Cap)'] = $dealrow["Sales_Multiple"];
                        }

                        if($dealrow["EBITDA_Multiple"] <= 0){

                            $res5['EBITDA Multiple (based on Equity Value)'] = 0.00;
                        }
                        else{

                            $res5['EBITDA Multiple (based on Equity Value)'] = $dealrow["EBITDA_Multiple"];
                        }
                        if($dealrow["Netprofit_Multiple"] <= 0){

                            $res5['PAT Multiple (based on Equity Value)'] = 0.00;
                        }
                        else{

                             $res5['PAT Multiple (based on Equity Value)'] = $dealrow["Netprofit_Multiple"];
                        }

                        if($dealrow["price_to_book"] <= 0){

                           $res5['price_to_book'] = 0.00;
                        }
                        else{

                            $res5['price_to_book'] = $dealrow["price_to_book"];
                        }

                        if($dealrow["Valuation"] != ''){

                            $res5['Valuation'] = trim($dealrow["Valuation"]);
                        }else{

                            $res5['Valuation'] = '';
                        }

                        if($dealrow["Company_Valuation"] > 0 && $dealrow["Sales_Multiple"] > 0){

                            $res5['Revenue'] = number_format($dealrow["Company_Valuation"]/$dealrow["Sales_Multiple"], 2, '.', '');
                        }else{
                             $res5['Revenue'] = '';
                        }

                        if($dealrow["Company_Valuation"] > 0 && $dealrow["EBITDA_Multiple"] > 0){

                            $res5['EBITDA'] = number_format($dealrow["Company_Valuation"]/$dealrow["EBITDA_Multiple"], 2, '.', '');

                        }else{

                            $res5['EBITDA'] = '';
                        }

                        if($dealrow["Company_Valuation"] > 0 && $dealrow["Netprofit_Multiple"] > 0){

                            $res5['PAT'] = number_format($dealrow["Company_Valuation"]/$dealrow["Netprofit_Multiple"], 2, '.', '');

                        }else{

                            $res5['PAT'] = '';
                        }

                        if($dealrow["book_value_per_share"]<=0){

                            $res5['book_value_per_share'] = 0.00;
                        }
                        else{

                            $res5['book_value_per_share'] = $dealrow["book_value_per_share"];
                        }


                        if($dealrow["price_per_share"]<=0){

                            $res5['price_per_share'] = 0.00;
                        }
                        else{

                            $res5['price_per_share'] = $dealrow["price_per_share"];
                        }

                        if($dealrow["uploadfilename"] != ''){
                            
                            $res5['File'] = GLOBAL_BASE_URL.'uploadmamafiles/'.$dealrow["uploadfilename"];
                        }else{
                            
                            $res5['File'] = '';
                        }
                        $data_inner['Financial Info'][] = $res5;
                        
                        $res4 = array();
                        if ($getcompanyrs = mysql_query($investorSql))
                        {
                            $invReturnString=array();       
                            While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                            {
                                $investors = $myInvrow['Investor'].",";
                                $invReturnString[]=$myInvrow["Investor"].",".$myInvrow["MultipleReturn"];
                                
                            }
                            $res4['Investor'] = rtrim($investors,',');
                        }
                        
                        if($dealrow["InvestorTypeName"]!= ''){
                            
                            $res4['InvestorType'] = rtrim($dealrow["InvestorTypeName"],',');
                        }else{
                            $res4['InvestorType'] = '';
                        }
                        
                        if($dealrow["InvestorSale"]!=''){
                            
                            if($dealrow["InvestorSale"] == 1){
                                                              
                                $res4['investor_sale_display'] = "Yes";
                            }
                            else{
                                
                               $res4['investor_sale_display'] = "No";
                            }
                        }else{
                            $res4['investor_sale_display'] = "";
                        }
                        
                        if($dealrow["SellingInvestors"] != "")
                        { 
                     
                            $res4['selling_investors_value'] = $dealrow["SellingInvestors"];
                        }
                        else
                        {
                            $res4['selling_investors_value'] = "";     
                        }
                        if($dealrow["Link"] != ''){
                            
                            $res4['Link'] = $dealrow["Link"];
                        }else{
                            $res4['Link'] = "";
                        }
                        $data_inner['Investor Info'][] = $res4;
                        
                        $res7 = array();
                        if($dealrow["MoreInfor"] != "")
			{
                            $text = str_replace("\r\n",'', $dealrow["MoreInfor"]);
                            if(empty($text) && is_null($text)){
                                
                                $res7['moreinfor'] =  "";
                            }else{
                                
                                $res7['moreinfor'] =  $text;
                            }
			}else{
                            $res7['moreinfor'] =  "";
                        }
                        $data_inner['More Details(Overall IPO)'][] = $res7;
                        
                        $res9 = array();
                        $investmentdeals=$dealrow["InvestmentDeals"];
			if($investmentdeals!="")
			{
                            $res9['Investmentdeals'] =  str_replace("\r\n",'', $investmentdeals);
			}
                        $data_inner['Investment Details'][] = $res9;
                        
                    }
                    
                    $res8 = array();
                    for($i=0;$i<count($invReturnString);$i++)
                    {
                        $invStringToSplit=$invReturnString[$i];
                        $invString  =explode(",",$invStringToSplit);
                        $investorName=$invString[0];
                        $returnValue=$invString[1];
                        $investormoreinfo=$invMoreInfoString[$i];
                        
                        $res8[]= rtrim(($investorName.",".$returnValue.",".$investormoreinfo),",");
                    }
                    $data_inner['Return Info'][] = $res8;
                    
    //------------------------------------------------------ Company Profile starts----------------------------------------------------------  
                    
                    $comsql="SELECT pe.FinLink, pec.angelco_compID, pec.uploadfilename, pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, website,
                        linkedIn, stockcode, yearfounded, pec.Address1, pec.Address2, pec.AdCity, pec.Zip, pec.OtherLocation, c.country, pec.Telephone, pec.Fax, pec.Email, 
                        pec.AdditionalInfor, linkedin_companyname
                        FROM pecompanies pec
                        LEFT JOIN peinvestments AS pe ON ( pe.PECompanyId = pec.PECompanyId ) 
                        LEFT JOIN industry i ON ( pec.industry = i.industryid ) 
                        LEFT JOIN country c ON ( c.countryid = pec.countryid ) 
                        WHERE pec.PECompanyId =".$data_res['companyid'];	

                    $company_link_Sql =mysql_query("select * from pecompanies_links where PECompanyId=".$data_res['companyid']); 

                    $incubatorSql="SELECT pe.IncDealId,pe.IncubatorId,inc.Incubator 
                        FROM `incubatordeals` as pe, incubators as inc WHERE IncubateeId =".$data_res['companyid']." and pe.IncubatorId= inc.IncubatorId ";

                    $onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,exe.ExecutiveName,exe.Designation,exe.Company 
                        FROM pecompanies as pec,executives as exe,pecompanies_management as mgmt
                        WHERE pec.PECompanyId=".$data_res['companyid']." and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";

                    $onBoardSql="select pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId,exe.ExecutiveName,exe.Designation,exe.Company 
                        FROM pecompanies as pec,executives as exe,pecompanies_board as bd
                        WHERE pec.PECompanyId=".$data_res['companyid']." and bd.PECompanyId=pec.PECompanyId and exe.ExecutiveId=bd.ExecutiveId";

                    $investorSql="select pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV 
                        FROM peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec, peinvestors as inv 
                        WHERE pe.PECompanyId=".$data_res['companyid']." and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0
                        and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15 order by dates desc";

                    $maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, inv.Investor,DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, 
                        pe.MandAId ,pe.ExitStatus, pe.DealTypeId, dt.DealType
                        FROM manda AS pe, industry AS i, pecompanies AS pec,manda_investors as mi ,peinvestors as inv, dealtypes AS dt
                        WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=".$data_res['companyid']."
                        and inv.InvestorId=mi.InvestorId and mi.MandAId=pe.MandAId and pe.DealTypeId=dt.DealTypeId order by DealDate desc ";

                    $ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor, IPOAmount, DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId ,pe.ExitStatus
                        FROM ipos AS pe, industry AS i, pecompanies AS pec,ipo_investors as ipoi,peinvestors as inv
                        WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=".$data_res['companyid']."
                        and inv.InvestorId=ipoi.InvestorId and ipoi.IPOId=pe.IPOId order by IPODate desc";

                    $angelinvsql="SELECT pe.InvesteeId, pe.AggHide, pec.companyname, pec.industry, i.industry, pec.sector_business,DATE_FORMAT( DealDate, '%b-%Y' ) as dt, 
                        pe.AngelDealId ,peinv.InvestorId,inv.Investor
                        FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,angel_investors as peinv,peinvestors as inv
                        WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.InvesteeId and pe.Deleted=0 and pec.industry !=15 and pe.InvesteeId=".$data_res['companyid']."
                        and  peinv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv.InvestorId order by dt desc";

                        $comres = array();
                            if ($companyrs = mysql_query($comsql))
                            {      
                                $myrow=mysql_fetch_array($companyrs,MYSQL_BOTH);

                                if($myrow["companyname"]!=''){

                                    $comres['Companyname'] = $myrow["companyname"];
                                }else{

                                    $comres['Companyname'] = '';
                                }

                                if($myrow["Investor"]!=''){

                                    $comres['Investor'] = $myrow["Investor"];
                                }else{

                                    $comres['Investor'] = '';
                                }

                                if($myrow["industry"]!=''){

                                    $comres['Industry'] = $myrow["industry"];
                                }else{

                                    $comres['Industry'] = '';
                                }

                                if($myrow["sector_business"]!=''){

                                    $comres['Sector'] = $myrow["sector_business"];
                                }else{

                                    $comres['Sector'] = '';
                                }

                                if($myrow["website"]!=''){

                                    $comres['Website'] = $myrow["website"];
                                }else{

                                    $comres['Website'] = '';
                                }

                                if($myrow["Address1"]!=''){

                                    $comres['Address'] = $myrow["Address1"];
                                }else{

                                    $comres['Address'] = '';
                                }

                                if($myrow["AdCity"]!=''){

                                    $comres['City'] = $myrow["AdCity"];
                                }else{

                                    $comres['City'] = '';
                                }

                                if($myrow["Zip"]!=''){

                                    $comres['Zipcode'] = $myrow["Zip"];
                                }else{

                                    $comres['Zipcode'] = '';
                                }

                                if($myrow["OtherLocation"]!=''){

                                    $comres['OtherLocation'] = $myrow["OtherLocation"];
                                }else{

                                    $comres['OtherLocation'] = '';
                                }

                                if($myrow["country"]!=''){

                                    $comres['Country'] = $myrow["country"];
                                }else{

                                    $comres['Country'] = '';
                                }

                                if($myrow["Telephone"]!=''){

                                    $comres['Telephone'] = $myrow["Telephone"];
                                }else{

                                    $comres['Telephone'] = '';
                                }

                                if($myrow["Fax"]!=''){

                                    $comres['Fax'] = $myrow["Fax"];
                                }else{

                                    $comres['Fax'] = '';
                                }

                                if($myrow["Email"]!=''){

                                    $comres['Email'] = $myrow["Email"];
                                }else{

                                    $comres['Email'] = '';
                                }

                                if($myrow["stockcode"]!=''){

                                    $comres['Stockcode'] = $myrow["stockcode"];
                                }else{

                                    $comres['Stockcode'] = '';
                                }

                                 if($myrow["yearfounded"]!=''){

                                    $comres['Yearfounded'] = $myrow["yearfounded"];
                                }else{

                                    $comres['Yearfounded'] = '';
                                }

                                if($myrow["linkedIn"]!=''){

                                    $comres['LinkedIn'] = $myrow["linkedIn"];
                                }else{

                                    $comres['LinkedIn'] = '';
                                }

                                if($myrow["linkedin_companyname"]!=''){

                                    $comres['LinkedIn_Company'] = $myrow["linkedin_companyname"];
                                }else{

                                    $comres['LinkedIn_Company'] = '';
                                }

                                $companyurl=  urlencode($myrow["companyname"]);
                                $company_newssearch="https://www.google.co.in/search?q=".$companyurl."+site:ventureintelligence.com/ddw/";

                                if($company_newssearch!=''){

                                    $comres['News'] = $company_newssearch;
                                }else{

                                    $comres['News'] = '';
                                }

                                if($myrow["AdditionalInformation"]!=''){

                                    $comres['AdditionalInformation'] = $myrow["AdditionalInfor"];
                                }else{

                                    $comres['AdditionalInformation'] = '';
                                }

                                $data_inner['Company Profile'][] = $comres;      
                            }

                            $comres1 = array();$topmanagement = array();
                            if($rsMgmt = mysql_query($onMgmtSql))
                            {
                                While($mymgmtrow = mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                                {

                                    $comres1['Name'] = $mymgmtrow["ExecutiveName"];
                                    $comres1['Designation'] = $mymgmtrow["Designation"];  

                                    $topmanagement[] = $comres1;
                                }
                                if(count($topmanagement) > 0){

                                    $data_inner['Company Profile']['Top Management'] = $topmanagement;
                                }else{

                                    $data_inner['Company Profile']['Top Management'] = '';
                                }
                            }

                            $comres2 = array();$boardmember = array();
                            if($rsBoard = mysql_query($onBoardSql))
                            {
                                While($myboardrow = mysql_fetch_array($rsBoard, MYSQL_BOTH))
                                {

                                    $comres2['Name'] = $myboardrow["ExecutiveName"];
                                    $comres2['Designation'] = $myboardrow["Designation"].', '.$myboardrow["Company"];  
                                    $comres2['LinkedIn'] = "https://www.google.co.in/search?q=".$myboardrow["ExecutiveName"].$myboardrow["Designation"].$myboardrow["Company"]. "+site%3Alinkedin.com"; 

                                    $boardmember[]=$comres2;
                                }
                                 if(count($boardmember) > 0){

                                    $data_inner['Company Profile']['Investor Board Member'] = $boardmember;
                                 }else{
                                     $data_inner['Company Profile']['Investor Board Member'] = '';
                                 }
                            }

                            $comres3 = array(); $investors = array();
                            if($rsinvestor = mysql_query($investorSql))
                            {
                                While($investorsrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                                {

                                    $comres3['Investor Name'] = $investorsrow["Investor"];
                                    $comres3['Deal Period'] = $investorsrow["dt"];
                                    $investors[] = $comres3;
                                }
                                 if(count($investors) > 0){

                                    $data_inner['Investments']['PE/VC investors'] = $investors;
                                 }else{
                                     $data_inner['Investments']['PE/VC investors'] = '';
                                 }
                            }

                            $comres4 = array(); $incubators = array();
                            if($rsincubator = mysql_query($ipoexitsql))
                            {
                                While($incsrow=mysql_fetch_array($rsincubator, MYSQL_BOTH))
                                {

                                    $comres4['Investor Name'] = $incsrow["Investor"];
                                    $comres4['Deal Period'] = $incsrow["dt"];

                                    if($incsrow["ExitStatus"]){

                                        if($incsrow["ExitStatus"]==0){

                                            $comres4['Exitstatus'] = "Partial Exit";
                                        }
                                       elseif($incsrow["ExitStatus"]==1){  

                                            $comres4['Exitstatus'] = "Complete Exit";

                                       }

                                    }else{
                                        $comres4['Exitstatus'] = "";
                                    }

                                    $incubators[] = $comres4;
                                }
                                 if(count($incubators) > 0){

                                    $data_inner['Investments']['Incubators'] = $incubators;
                                 }else{
                                     $data_inner['Investments']['incubators'] = '';
                                 }
                            }

                            $comres5 = array(); $maincubators = array();
                            if($rsmaincubator = mysql_query($maexitsql))
                            {
                                While($maincsrow=mysql_fetch_array($rsmaincubator, MYSQL_BOTH))
                                {

                                    $comres5['Investor Name'] = $maincsrow["Investor"];
                                    $comres5['Deal Period'] = $maincsrow["dt"];

                                    if($maincsrow["ExitStatus"]){

                                        if($maincsrow["ExitStatus"]==0){

                                            $comres4['Exitstatus'] = "Partial Exit";
                                        }
                                       elseif($maincsrow["ExitStatus"]==1){  

                                            $comres4['Exitstatus'] = "Complete Exit";

                                       }

                                    }else{
                                        $comres4['Exitstatus'] = "";
                                    }
                                    $maincubators[] = $comres4;
                                }
                                 if(count($maincubators) > 0){

                                    $data_inner['Investments']['Incubators'] = $maincubators;
                                 }else{
                                     $data_inner['Investments']['incubators'] = '';
                                 }
                            }

                            $comres6 = array(); $angelinvestors = array();
                            if($rsangelinvestor = mysql_query($angelinvsql))
                            {
                                While($angelinvestorsrow=mysql_fetch_array($rsangelinvestor, MYSQL_BOTH))
                                {

                                    $comres6['Investor Name'] = $angelinvestorsrow["Investor"];
                                    $comres6['Deal Period'] = $angelinvestorsrow["dt"];
                                    $angelinvestors[] = $comres6;
                                }
                                 if(count($angelinvestors) > 0){

                                    $data_inner['Investments']['Angel investors'] = $angelinvestors;
                                 }else{
                                     $data_inner['Investments']['Angel investors'] = '';
                                 }
                            }
                    
                    $data['Deal_Details'][] = $data_inner;
                }
            }
            
        }
    }
    elseif($datatype==2 && $dealType==2){
        
        if($dealCategory == 'PEMA' || $dealCategory == 'VCMA' || $dealCategory == 'PEPM' || $dealCategory == 'VCPM'){ 
            
            $res = array(); $data_inner = array();$cos_array = array();$res1=array();
            while($data_res = mysql_fetch_array($results)) {
                
                $cos_array[]=$data_res["PECompanyId"];
                $totalInv=$totalInv+1;
                $totalAmount=$totalAmount+ $data_res["DealAmount"];
            }
            $res1['total Deals'] = $totalInv;
            $res1['total_companies'] = count(array_count_values($cos_array));
            $res1['total Amount'] = round($totalAmount);
            
            if($res1['total Deals'] > 0){
                
                $data_inner['aggregate_details']= $res1;
            }
            
            mysql_data_seek($results,0);
            
            while($data_res = mysql_fetch_array($results)) {

                $res['company'] = $data_res['companyname'];
               
                if(trim($data_res["sector_business"]) == ""){

                    $res['sector'] = $data_res["industry"];
                }
                else{

                    $res['sector'] = $data_res["sector_business"];
                }
                
                if($data_res['Investor']!=''){
                    
                    $res['investor'] = $data_res['Investor'];
                }else{
                    
                    $res['investor'] ='';
                }
                
                if($data_res['period']!=''){

                    $res['date'] = date('M-Y', strtotime($data_res['period']));
                }else{

                     $res['date'] = '';
                }
                
                if($data_res["hideamount"]!=''){
                    
                    if($data_res["hideamount"]==1)
                    {
                        
                        $res['hideamount']="--";
                    }
                    else
                    {
                        
                        $res['hideamount']=$data_res["DealAmount"];
                    }
                }else{
                    
                    $res['hideamount']=$data_res["DealAmount"];
                }
                
                if($data_res["ExitStatus"] != ''){
                    
                    if($data_res["ExitStatus"] == 1)
                    {
                           $res['Exitstus'] = "Complete";
                    }
                    else if($data_res["ExitStatus"] == 0)
                    {
                             $res['Exitstus'] = "Partial";
                    }
                }else{
                    
                    $res['Exitstus'] = "";
                }
                
                                        
                $data_inner['Deals'][]= $res;

            }
        }
        elseif($dealCategory == 'PEIPO' || $dealCategory == 'VCIPO'){
             
            $res = array(); $data_inner = array();$cos_array = array();$res1=array();
            while($data_res = mysql_fetch_array($results)) {
                
                $cos_array[]=$data_res["companyid"];
                $totalInv=$totalInv+1;
                $totalAmount=$totalAmount+ $data_res["IPOSize"];
            }
            $res1['total Deals'] = $totalInv;
            $res1['total_companies'] = count(array_count_values($cos_array));
            $res1['total Amount'] = round($totalAmount);
            
            if($res1['total Deals'] > 0){
                
                $data_inner['aggregate_details']= $res1;
            }
            
            mysql_data_seek($results,0);
            
            while($data_res = mysql_fetch_array($results)) {

                $res['company'] = $data_res['companyname'];
               
                if(trim($data_res["sector_business"]) == ""){

                    $res['sector'] = $data_res["industry"];
                }
                else{

                    $res['sector'] = $data_res["sector_business"];
                }
                
                if($data_res['Investor']!=''){
                    
                    $res['investor'] = $data_res['Investor'];
                }else{
                    
                    $res['investor'] ='';
                }
                
                if($data_res['IPODate']!=''){

                    $res['date'] = date('M-Y', strtotime($data_res['IPODate']));
                }else{

                    $res['date'] = '';
                }
                
                if($data_res["hideamount"]==1){
                    
                    $res['IPOSize'] = '';
                    
                }else{
                    
                    if($data_res["IPOSize"]!=''){
                    
                        $res['IPOSize'] = $data_res["IPOSize"];
                    
                    }else{

                        $res['IPOSize'] = '';
                    }
                }
                
                                        
                $data_inner['Deals'][]= $res;

            }
            
        }
               
        if(count($data_inner) > 0){
            $data['Deals_Aggregate'] = $data_inner;
        }
    }
   
    
    function return_insert_get_RegionIdName($regionidd)
    {
            $dbregionlink = new dbInvestments();
            $getRegionIdSql = "select Region from region where RegionId=$regionidd";

            if ($rsgetInvestorId = mysql_query($getRegionIdSql))
            {
                $regioncnt = mysql_num_rows($rsgetInvestorId);
                //echo "<br>Investor count-- " .$investor_cnt;

                if($regioncnt == 1)
                {
                    While($myrow = mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
                    {
                            $regionIdname = $myrow[0];
                            //echo "<br>Insert return investor id--" .$invId;
                            return $regionIdname;
                    }
                }
            }
            $dbregionlink.close();
    }
    
    function highlightWords($text, $words)
    {

            /*** loop of the array of words ***/
            foreach ($words as $worde)
            {

                    /*** quote the text for regex ***/
                    $word = preg_quote($worde);
                    /*** highlight the words ***/
                    //$text = preg_replace("/\b($worde)\b/i", '', $text);
            }
            /*** return the text ***/
            return $text;
    }
    if(count($data) > 0){
        echo json_encode($data);
    }else{
        echo 'No Data Found.';
    }
?>