<?php
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    
  // $typepost =    isset($_POST['dealtype']) ? $_POST['dealtype'] : 'INVESTMENTS';
    
    // if(strtoupper($typepost) === 'INVESTMENTS'){ //1 for Investment and 2 for Exit (default will be 0/Investment)
        
    //     $dealType =  1; // INVESTMENT
    // }
    // elseif(strtoupper($typepost) === 'EXITS'){
        
    //     $dealType =  2; //  EXITS
    // }else{
    //     $dealType =  1; //  INVESTMENT
    // }
       

    $categoryType = $_POST['categoryType'];
    $typepost =    isset($_POST['dealtype']) ? $_POST['dealtype'] : 'INVESTMENTS';

    if ($categoryType == "deals") { 
            $categoryType = "DE";
            if (strtoupper($typepost) === 'INVESTMENTS') { //1 for Investment and 2 for Exit (default will be 0/Investment)
                $dealType = 1; // INVESTMENT
            } elseif (strtoupper($typepost) === 'EXITS') {
                $dealType = 2; //  EXITS
            } else {
                $dealType = 1; //  INVESTMENT
            }
    } elseif ($categoryType == "directory") {
            $categoryType = "DR";
            if (strtoupper($typepost) === 'INVESTMENTS') { //1 for Investment and 2 for Exit (default will be 0/Investment)
                $dealType = 1; // INVESTMENT
            } elseif (strtoupper($typepost) === 'EXITS') {
                $dealType = 2; //  EXITS
            } else {
                $dealType = 1; //  INVESTMENT
            }
    } elseif ($categoryType == "funds") {
        $categoryType = "FD";
    }
    $dirCategoryType = $_POST['dirCategoryType'];

    
    
    $userName = $_POST[ 'api_userName' ];
    $password = $_POST[ 'api_password' ];

    if( isset( $_POST[ 'is_admin' ] ) ) {
        $is_admin = true;
    } else {
        $is_admin = false;
    }
    if( isset( $_POST[ 'user_check' ] ) ) {
        $userCheck = true;
    } else {
        $userCheck = false;
    }

    if( !$is_admin || $userCheck ) {
        $sel = "SELECT dealmembers.DCompId, dealmembers.EmailId, dealmembers.Name, dealmembers.user_authorization_status, dealcompanies.api_access 
                        FROM dealmembers
                        LEFT JOIN dealcompanies
                            ON dealcompanies.DCompId = dealmembers.DCompId 
                        WHERE dealmembers.EmailId = '$userName' AND dealmembers.Passwrd = '" . md5($password) . "'";
        $res = mysql_query( $sel ) or die( mysql_error() );
        $numrows = mysql_num_rows( $res );

        if( $numrows == 0 ) {
            $data['Status'] = "Failure";
            $data['Result'] = "Username or Password not found";
            echo json_encode($data);
            exit;
        } else {
            $result = mysql_fetch_array( $res );
            if( $result[ 'api_access' ] != 1 ) {
                $data['Status'] = "Failure";
                $data['Result'] = "User not allowed for using api service";
                echo json_encode($data);
                exit;
            }
        }
    }

    
    

    $dealCategory = strtoupper(isset($_POST['dealcategory']) ? $_POST['dealcategory'] : 'PE'); //For Investement(1 for PE, and 2 for VC, and 3 for Angel and, 4 for Incubation, and 5 for Social, and 6 for Cleantech, and 7 for Infrasturcture)
                                                                    // For Exit( 8 for M&A,9 for Public Market, 10 for IPO)
    $time = $_POST['time']; // For month 01/2016, for quater 1Q/2016, for year only 2016, default current year.
    
    $companysearch = isset($_POST['company']) ? $_POST['company'] : ''; // For company
    
    $investorsearch = isset($_POST['investor']) ? $_POST['investor'] : ''; // For company
    
    // if($companysearch!='' || $investorsearch!=''){
        
    //     $from_date = "1998-01-01";
    //     $to_date =  date('Y')."-12-31";
        
    // } else{
        
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
            
           $from_date = "1998-01-01";
           $to_date = date('Y')."-12-31";
        }
    //}
    
    $datafilter = $_POST['dataFiler'];

    if( $datafilter != "all" && $datafilter !='') {
        $dataLimit = " Limit " . $datafilter;
    } else {
        $dataLimit = "" ;
    }
    
    $datatype = isset($_POST['datatype']) ? $_POST['datatype'] : 1; // For Detail 1, for aggregate 2.
    
    $dbTypeSV="SV";
    $dbTypeIF="IF";
    $dbTypeCT="CT";
    

if($categoryType == "DE"){

    if($dealType == 1){
       //echo "eeeeeeeeeeee".$dealCategory;
        if($dealCategory == 'PE'){ // for PE Investment
            
            if($companysearch != ''){
                    
                $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '%$companysearch%'";
                $comrs = mysql_query($comsql);
                $comres = mysql_fetch_array($comrs);
                $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
                $orderby = "order by dates desc";
            }elseif($investorsearch != ''){

                $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                $invrs = mysql_query($invsql);
                $invres = mysql_fetch_array($invrs);
                $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
                $investor_from = " ,peinvestments_investors as peinv_invs,peinvestors as invs";
                $investor_where = " and peinv_invs.PEId=pe.PEId and invs.InvestorId=peinv_invs.InvestorId";
                $orderby = "order by dates desc";
            } else {
                $orderby = "order by amount desc";
            }
            if($datatype == 1){

                $sql = "SELECT peinv_inv.PEId,peinv_inv.InvestorId,inv.Investor,pe.PEId,pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, 
                pec.industry, i.industry, pec.sector_business,pe.Total_Debt,pe.Cash_Equ,pe.amount,pe.Amount_INR, 
                pe.round, s.Stage,pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dt, pec.website, pec.city, pec.region,pe.PEId,pe.comment,pe.MoreInfor,
                pe.hideamount,pe.hidestake, pe.InvestorType, its.InvestorTypeName,pe.StageId,pe.Link,pec.uploadfilename,pe.source,pe.Valuation,
                pe.FinLink,pec.RegionId, pe.AggHide, pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple,pe.listing_status,pe.Exit_Status,
                pe.SPV,pe.Revenue,pe.EBITDA,pe.PAT,pe.Company_Valuation_pre,pe.Revenue_Multiple_pre,pe.EBITDA_Multiple_pre,pe.PAT_Multiple_pre,pe.Company_Valuation_EV,
                pe.Revenue_Multiple_EV,pe.EBITDA_Multiple_EV,pe.PAT_Multiple_EV,pe.financial_year,
                (select Region from region where RegionId=pec.RegionId) as RegionName,
                (select status from exit_status where id=pe.Exit_Status) as ExitStatusName,
                GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') as Investors
                FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
                JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
                JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                JOIN investortype AS its ON its.InvestorType=pe.InvestorType 
                JOIN industry AS i ON pec.industry = i.industryid
                JOIN stage AS s ON s.StageId=pe.StageId
                WHERE dates between '" . $from_date. "' and '" . $to_date . "' and  pe.Deleted=0 and pec.industry !=15 ".$company_search.$investor_search."
                and pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes WHERE DBTypeId =  'SV' AND hide_pevc_flag =1) 
                GROUP BY pe.PEId $orderby" .$dataLimit;

            } else{
                
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
                        GROUP BY pe.PEId $orderby".$dataLimit;
            }
            
        }
        elseif($dealCategory == 'VC'){ //for VC Investment
            
            if($companysearch != ''){
                
                $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '%$companysearch%'";
                $comrs = mysql_query($comsql);
                $comres = mysql_fetch_array($comrs);
                $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
                $orderby = "order by dates desc";
            }elseif($investorsearch != ''){

                $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                $invrs = mysql_query($invsql);
                $invres = mysql_fetch_array($invrs);
                $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                $investor_from = " ,peinvestments_investors as peinv_invs,peinvestors as invs";
                $investor_where = " and peinv_invs.PEId=pe.PEId and invs.InvestorId=peinv_invs.InvestorId";
                $orderby = "order by dates desc";
            } else {
                $orderby = "order by amount desc";
            }
            if($datatype == 1){
  
                // $sql = "SELECT pe.PEId FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s,peinvestments_investors as peinv_invs,peinvestors as invs
                //         WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID 
                //         and pe.StageId=s.StageId ".$investor_where." and pe.Deleted=0 and pec.industry!=15  and s.VCview=1 and pe.amount <=20".$company_search.$investor_search." AND pe.PEId NOT
                //         IN (
                //             SELECT PEId
                //             FROM peinvestments_dbtypes AS db
                //             WHERE DBTypeId =  '$dbTypeSV'
                //             AND hide_pevc_flag =1
                //             )  
                //         GROUP BY pe.PEId";
                
                $sql="SELECT peinv_inv.PEId,peinv_inv.InvestorId,inv.Investor,pe.PEId,pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, 
                pec.industry, i.industry, pec.sector_business,pe.Total_Debt,pe.Cash_Equ,pe.amount,pe.Amount_INR, 
                pe.round, s.Stage,pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dt, pec.website, pec.city, pec.region,pe.PEId,pe.comment,pe.MoreInfor,
                pe.hideamount,pe.hidestake, pe.InvestorType, its.InvestorTypeName,pe.StageId,pe.Link,pec.uploadfilename,pe.source,pe.Valuation,
                pe.FinLink,pec.RegionId, pe.AggHide, pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple,pe.listing_status,pe.Exit_Status,
                pe.SPV,pe.Revenue,pe.EBITDA,pe.PAT,pe.Company_Valuation_pre,pe.Revenue_Multiple_pre,pe.EBITDA_Multiple_pre,pe.PAT_Multiple_pre,pe.Company_Valuation_EV,
                pe.Revenue_Multiple_EV,pe.EBITDA_Multiple_EV,pe.PAT_Multiple_EV,pe.financial_year,
                (select Region from region where RegionId=pec.RegionId) as RegionName,
                (select status from exit_status where id=pe.Exit_Status) as ExitStatusName,
                GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') as Investors
                FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
                JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
                JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                JOIN investortype AS its ON its.InvestorType=pe.InvestorType 
                JOIN industry AS i ON pec.industry = i.industryid
                JOIN stage AS s ON s.StageId=pe.StageId
                WHERE dates between '" . $from_date. "' and '" . $to_date . "' and  pe.Deleted=0 and pec.industry !=15 and s.VCview=1 and pe.amount <=20".$company_search.$investor_search."
                and pe.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes WHERE DBTypeId =  'SV' AND hide_pevc_flag =1) 
                GROUP BY pe.PEId $orderby".$dataLimit;

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
                        GROUP BY pe.PEId $orderby".$dataLimit;
            }
            
        }
        elseif($dealCategory == 'ANGEL'){ // for Angel Investment
      
            if($companysearch != ''){
                    
                $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                $comrs = mysql_query($comsql);
                $comres = mysql_fetch_array($comrs);
                $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
                $orderby = "order by dates desc";
            }elseif($investorsearch != ''){

                $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                $invrs = mysql_query($invsql);
                $invres = mysql_fetch_array($invrs);
                $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
                $orderby = "order by dates desc";
            } else {
                $orderby = "order by amount desc";
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
                $orderby = "order by dates desc";
            }elseif($investorsearch != ''){

                $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                $invrs = mysql_query($invsql);
                $invres = mysql_fetch_array($invrs);
                $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
                $orderby = "order by dates desc";
            } else {
                $orderby = "order by amount desc";
            }
            if($datatype == 1){
                    
                    // $sql = "SELECT pe.PEId FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes  as pedb,peinvestments_investors as peinv_inv,peinvestors as inv
                    // WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND i.industryid=pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                    // and pedb.PEId=pe.PEId and pedb.DBTypeId='SV' and pe.Deleted=0 and pec.industry!=15 ".$company_search.$investor_search." and peinv_inv.PEId=pe.PEId and 
                    // inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId";

                    $sql="SELECT peinv_inv.PEId,peinv_inv.InvestorId,inv.Investor,pe.PEId,pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, 
                    pec.industry, i.industry, pec.sector_business,pe.Total_Debt,pe.Cash_Equ,pe.amount,pe.Amount_INR, 
                    pe.round, s.Stage,pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dt, pec.website, pec.city, pec.region,pe.PEId,pe.comment,pe.MoreInfor,
                    pe.hideamount,pe.hidestake, pe.InvestorType, its.InvestorTypeName,pe.StageId,pe.Link,pec.uploadfilename,pe.source,pe.Valuation,
                    pe.FinLink,pec.RegionId, pe.AggHide, pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple,pe.listing_status,pe.Exit_Status,
                    pe.SPV,pe.Revenue,pe.EBITDA,pe.PAT,pe.Company_Valuation_pre,pe.Revenue_Multiple_pre,pe.EBITDA_Multiple_pre,pe.PAT_Multiple_pre,pe.Company_Valuation_EV,
                    pe.Revenue_Multiple_EV,pe.EBITDA_Multiple_EV,pe.PAT_Multiple_EV,pe.financial_year,
                    (select Region from region where RegionId=pec.RegionId) as RegionName,
                    (select status from exit_status where id=pe.Exit_Status) as ExitStatusName,
                    GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') as Investors
                    FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
                    JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
                    JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                    JOIN investortype AS its ON its.InvestorType=pe.InvestorType 
                    JOIN industry AS i ON pec.industry = i.industryid
                    JOIN stage AS s ON s.StageId=pe.StageId
                    JOIN peinvestments_dbtypes AS pedb ON pedb.PEId=pe.PEId
                    WHERE dates between '" . $from_date. "' and '" . $to_date . "' and  pe.Deleted=0 and pec.industry !=15 ".$company_search.$investor_search." and pedb.DBTypeId='SV'
                    GROUP BY pe.PEId $orderby".$dataLimit;
            }else{
                
                    $sql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,pe.Exit_Status,
                    amount, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pe.PEId,pe.MoreInfor,pe.hideamount,
                    pe.SPV ,pe.AggHide,GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
                    FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes  as pedb,peinvestments_investors as peinv_inv,peinvestors as inv
                    WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND i.industryid=pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                    and pedb.PEId=pe.PEId and pedb.DBTypeId='SV' and pe.Deleted=0 and pec.industry!=15 ".$company_search.$investor_search." and peinv_inv.PEId=pe.PEId and 
                    inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId $orderby".$dataLimit;
            }   
            
        }elseif($dealCategory == 'CLEANTECH'){ // Cleantech Investment
            
            if($companysearch != ''){
                    
                $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                $comrs = mysql_query($comsql);
                $comres = mysql_fetch_array($comrs);
                $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
                $orderby = "order by dates desc";
            }elseif($investorsearch != ''){

                $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                $invrs = mysql_query($invsql);
                $invres = mysql_fetch_array($invrs);
                $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
                $orderby = "order by dates desc";
            } else {
                $orderby = "order by amount desc";
            }
            
            if($datatype == 1){
                    
                // $sql = "SELECT pe.PEId FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes  as pedb,peinvestments_investors as peinv_inv,peinvestors as inv
                //     WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND i.industryid=pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                //     and pedb.PEId=pe.PEId and pedb.DBTypeId='CT' and pe.Deleted=0 and pec.industry!=15 ".$company_search.$investor_search." and peinv_inv.PEId=pe.PEId and 
                //     inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId";

                $sql = "SELECT peinv_inv.PEId,peinv_inv.InvestorId,inv.Investor,pe.PEId,pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, 
                pec.industry, i.industry, pec.sector_business,pe.Total_Debt,pe.Cash_Equ,pe.amount,pe.Amount_INR, 
                pe.round, s.Stage,pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dt, pec.website, pec.city, pec.region,pe.PEId,pe.comment,pe.MoreInfor,
                pe.hideamount,pe.hidestake, pe.InvestorType, its.InvestorTypeName,pe.StageId,pe.Link,pec.uploadfilename,pe.source,pe.Valuation,
                pe.FinLink,pec.RegionId, pe.AggHide, pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple,pe.listing_status,pe.Exit_Status,
                pe.SPV,pe.Revenue,pe.EBITDA,pe.PAT,pe.Company_Valuation_pre,pe.Revenue_Multiple_pre,pe.EBITDA_Multiple_pre,pe.PAT_Multiple_pre,pe.Company_Valuation_EV,
                pe.Revenue_Multiple_EV,pe.EBITDA_Multiple_EV,pe.PAT_Multiple_EV,pe.financial_year,
                (select Region from region where RegionId=pec.RegionId) as RegionName,
                (select status from exit_status where id=pe.Exit_Status) as ExitStatusName,
                GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') as Investors
                FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
                JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
                JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                JOIN investortype AS its ON its.InvestorType=pe.InvestorType 
                JOIN industry AS i ON pec.industry = i.industryid
                JOIN stage AS s ON s.StageId=pe.StageId
                JOIN peinvestments_dbtypes AS pedb ON pedb.PEId=pe.PEId
                WHERE dates between '" . $from_date. "' and '" . $to_date . "' and  pe.Deleted=0 and pec.industry !=15 ".$company_search.$investor_search." and pedb.DBTypeId='CT'
                GROUP BY pe.PEId $orderby".$dataLimit;

            }else{
                
                $sql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,pe.Exit_Status,
                     amount, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pe.PEId,pe.MoreInfor,pe.hideamount,
                    pe.SPV ,pe.AggHide,GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
                    FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes  as pedb,peinvestments_investors as peinv_inv,peinvestors as inv
                    WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND i.industryid=pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                    and pedb.PEId=pe.PEId and pedb.DBTypeId='CT' and pe.Deleted=0 and pec.industry!=15 ".$company_search.$investor_search." and peinv_inv.PEId=pe.PEId and 
                    inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId $orderby".$dataLimit;
            }  
            
        }elseif($dealCategory == 'INFRASTRUCTURE'){ // for Infrastructure Investment
            
            if($companysearch != ''){
                    
                $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                $comrs = mysql_query($comsql);
                $comres = mysql_fetch_array($comrs);
                $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
                $orderby = "order by dates desc";
            }elseif($investorsearch != ''){

                $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                $invrs = mysql_query($invsql);
                $invres = mysql_fetch_array($invrs);
                $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
                $orderby = "order by dates desc";
            } else {
                $orderby = "order by amount desc";
            }
            if($datatype == 1){
                    
                // $sql = "SELECT pe.PEId FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes  as pedb,peinvestments_investors as peinv_inv,peinvestors as inv
                //     WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND i.industryid=pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                //     and pedb.PEId=pe.PEId and pedb.DBTypeId='IF' and pe.Deleted=0 and pec.industry!=15 ".$company_search.$investor_search." and peinv_inv.PEId=pe.PEId and 
                //     inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId";

                $sql = "SELECT peinv_inv.PEId,peinv_inv.InvestorId,inv.Investor,pe.PEId,pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, 
                pec.industry, i.industry, pec.sector_business,pe.Total_Debt,pe.Cash_Equ,pe.amount,pe.Amount_INR, 
                pe.round, s.Stage,pe.stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dt, pec.website, pec.city, pec.region,pe.PEId,pe.comment,pe.MoreInfor,
                pe.hideamount,pe.hidestake, pe.InvestorType, its.InvestorTypeName,pe.StageId,pe.Link,pec.uploadfilename,pe.source,pe.Valuation,
                pe.FinLink,pec.RegionId, pe.AggHide, pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple,pe.listing_status,pe.Exit_Status,
                pe.SPV,pe.Revenue,pe.EBITDA,pe.PAT,pe.Company_Valuation_pre,pe.Revenue_Multiple_pre,pe.EBITDA_Multiple_pre,pe.PAT_Multiple_pre,pe.Company_Valuation_EV,
                pe.Revenue_Multiple_EV,pe.EBITDA_Multiple_EV,pe.PAT_Multiple_EV,pe.financial_year,
                (select Region from region where RegionId=pec.RegionId) as RegionName,
                (select status from exit_status where id=pe.Exit_Status) as ExitStatusName,
                GROUP_CONCAT( inv.Investor  ORDER BY Investor='others') as Investors
                FROM peinvestments AS pe JOIN pecompanies AS pec ON pec.PEcompanyID = pe.PECompanyID
                JOIN peinvestments_investors AS peinv_inv ON peinv_inv.PEId = pe.PEId
                JOIN peinvestors AS inv ON inv.InvestorId = peinv_inv.InvestorId
                JOIN investortype AS its ON its.InvestorType=pe.InvestorType 
                JOIN industry AS i ON pec.industry = i.industryid
                JOIN stage AS s ON s.StageId=pe.StageId
                JOIN peinvestments_dbtypes AS pedb ON pedb.PEId=pe.PEId
                WHERE dates between '" . $from_date. "' and '" . $to_date . "' and  pe.Deleted=0 and pec.industry !=15 ".$company_search.$investor_search." and pedb.DBTypeId='IF'
                GROUP BY pe.PEId $orderby".$dataLimit;

            }else{
                
                $sql = "SELECT pe.PECompanyId as PECompanyId, pec.companyname, pec.industry, i.industry as industry, pec.sector_business as sector_business,pe.Exit_Status,
                     amount, DATE_FORMAT( dates, '%b-%Y' ) as dealperiod , pe.PEId,pe.MoreInfor,pe.hideamount,
                    pe.SPV ,pe.AggHide,GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') AS Investor
                    FROM peinvestments AS pe, industry AS i, pecompanies AS pec,stage as s ,peinvestments_dbtypes  as pedb,peinvestments_investors as peinv_inv,peinvestors as inv
                    WHERE dates between '" . $from_date. "' and '" . $to_date . "' AND i.industryid=pec.industry AND pec.PEcompanyID = pe.PECompanyID and pe.StageId=s.StageId 
                    and pedb.PEId=pe.PEId and pedb.DBTypeId='IF' and pe.Deleted=0 and pec.industry!=15 ".$company_search.$investor_search." and peinv_inv.PEId=pe.PEId and 
                    inv.InvestorId=peinv_inv.InvestorId  GROUP BY pe.PEId $orderby".$dataLimit;
            } 
            
        }
    } else{
            
            if($dealCategory == 'PEMA'){ // for PE - M&A EXIT
                
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
                    $orderby = "order by DealDate desc";
                }elseif($investorsearch != ''){

                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                    $investor_from = " ,manda_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.MandAId=pe.MandAId and invs.InvestorId=peinv_invs.InvestorId";
                    $orderby = "order by DealDate desc";
                } else {
                    $orderby = "order by DealAmount desc";
                }
            
                $sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business,pe.DealAmount,pec.website, pe.MandAId,pe.Comment,
                MoreInfor,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,(SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') 
                FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                FROM manda AS pe, industry AS i, pecompanies AS pec ,dealtypes dt ".$investor_from."
                WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and 
                pec.industry != 15 ".$investor_where." and pe.DealTypeId= dt.DealTypeId and 
                dt.hide_for_exit=0 ".$company_search.$investor_search." GROUP BY pe.MandAId $orderby".$dataLimit;
                
            }elseif($dealCategory == 'PEPM'){ // for PE - Public Market EXIT
                
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
                    $orderby = "order by DealDate desc";
                }elseif($investorsearch != ''){

                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                    $investor_from = " ,manda_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.MandAId=pe.MandAId and invs.InvestorId=peinv_invs.InvestorId";
                    $orderby = "order by DealDate desc";
                } else {
                    $orderby = "order by DealAmount desc";
                }
                $sql="SELECT DISTINCT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business, pe.DealAmount,pe.ExitStatus, 
                i.industry, hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period, (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others') 
                FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt ".$investor_from."
                where DealDate between '" . $from_date. "' and '" . $to_date . "' and i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID
                and pec.industry != 15 ".$investor_where." and pe.Deleted=0 and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit=1 ".$company_search.$investor_search."
                GROUP BY pe.MandAId $orderby".$dataLimit;
                
            }elseif($dealCategory == 'PEIPO'){ // for PE - IPOExit
                
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
                    $orderby = "order by IPODate desc";
                }elseif($investorsearch != ''){

                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                    $investor_from = " ,ipo_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.IPOId=pe.IPOId and invs.InvestorId=peinv_invs.InvestorId";
                    $orderby = "order by IPODate desc";
                } else {
                    $orderby = "order by IPOSize desc";
                }
                $sql="SELECT pe.PECompanyId as companyid, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,pe.IPOSize,pe.IPOAmount, 
                pe.IPOValuation,IPODate as dates,DATE_FORMAT( IPODate, '%b-%Y' ) as IPODate,pec.website,pec.city, pec.region, pe.IPOId,pe.Comment,MoreInfor,hideamount,hidemoreinfor,
                (SELECT GROUP_CONCAT( inv.Investor ) FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                FROM ipos AS pe, industry AS i,pecompanies AS pec ".$investor_from."
                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and IPODate between '" . $from_date. "' and '" . $to_date . "' AND pe.Deleted =0 
                ".$investor_where.$company_search.$investor_search." GROUP BY pe.IPOId $orderby".$dataLimit;
            }
            elseif($dealCategory == 'VCMA'){ // for VC - M&A EXIT
                
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
                    $orderby = "order by DealDate desc";
                }elseif($investorsearch != ''){

                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                    $investor_from = " ,manda_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.MandAId=pe.MandAId and invs.InvestorId=peinv_invs.InvestorId";
                    $orderby = "order by DealDate desc";
                } else {
                    $orderby = "order by DealAmount desc";
                }
                $sql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business,pe.DealAmount,pec.website, pe.MandAId,pe.Comment,
                MoreInfor,hideamount,ExitStatus,DATE_FORMAT(DealDate,'%b-%Y') as period,DealDate as DealDate,(SELECT GROUP_CONCAT( inv.Investor   ORDER BY Investor='others') 
                FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                FROM manda AS pe, industry AS i, pecompanies AS pec ,dealtypes dt ".$investor_from."
                WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID AND pe.Deleted =0 and 
                pec.industry != 15 ".$investor_where." and pe.DealTypeId= dt.DealTypeId and 
                VCFlag=1 and dt.hide_for_exit=0 ".$company_search.$investor_search." GROUP BY pe.MandAId $orderby".$dataLimit;
                
            }elseif($dealCategory == 'VCPM'){ // for VC - Public Market EXIT
                
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
                    $orderby = "order by DealDate desc";
                }elseif($investorsearch != ''){

                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                    $investor_from = " ,manda_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.MandAId=pe.MandAId and invs.InvestorId=peinv_invs.InvestorId";
                    $orderby = "order by DealDate desc";
                } else {
                    $orderby = "order by DealAmount desc";
                }
                $sql="SELECT DISTINCT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business, pe.DealAmount,pe.ExitStatus, 
                i.industry, hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period, 
                (SELECT GROUP_CONCAT( inv.Investor ORDER BY Investor='others') FROM manda_investors as peinv_inv,peinvestors as inv WHERE peinv_inv.MandAId=pe.MandAId 
                and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt ".$investor_from."
                where DealDate between '" . $from_date. "' and '" . $to_date . "' and i.industryid=pec.industry and pec.PEcompanyID = pe.PECompanyID
                and pec.industry != 15 ".$investor_where." and pe.Deleted=0 and VCFlag=1 and pe.DealTypeId= dt.DealTypeId 
                and dt.hide_for_exit=1 ".$company_search.$investor_search." GROUP BY pe.MandAId $orderby".$dataLimit;

            }elseif($dealCategory == 'VCIPO'){ // for VC - IPOExit
                
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
                    $orderby = "order by IPODate desc";
                } elseif($investorsearch != ''){

                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND invs.InvestorId IN(".$invres['investorId'].")";
                    $investor_from = " ,ipo_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.IPOId=pe.IPOId and invs.InvestorId=peinv_invs.InvestorId";
                    $orderby = "order by IPODate desc";
                } else {
                    $orderby = "order by IPOSize desc";
                }
                    $sql = "SELECT pe.PECompanyId as companyid, pec.companyname, pec.industry, i.industry, pec.sector_business as sector_business,pe.IPOSize,pe.IPOAmount, 
                    pe.IPOValuation,IPODate as dates,DATE_FORMAT( IPODate, '%b-%Y' ) as IPODate,pec.website,pec.city, pec.region, pe.IPOId,pe.Comment,MoreInfor,hideamount,hidemoreinfor,
                    (SELECT GROUP_CONCAT( inv.Investor ) FROM ipo_investors AS peinv_inv, peinvestors AS inv WHERE peinv_inv.IPOId =pe.IPOId and inv.InvestorId=peinv_inv.InvestorId ) AS Investor 
                    FROM ipos AS pe, industry AS i,pecompanies AS pec ".$investor_from."
                    WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and IPODate between '" . $from_date. "' and '" . $to_date . "' AND pe.Deleted =0 ".$investor_where." and VCFlag=1 
                    ".$company_search.$investor_search." GROUP BY pe.IPOId $orderby".$dataLimit;
            }
    } 
}   elseif ($categoryType == "DR")  {
            
        if($dealType == 1){ 

            if($dealCategory == 'PE'){ // for PE Investment
                
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
    
                } elseif($investorsearch != ''){
    
                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
                }

                if($datatype == 1){

                    if($dirCategoryType == "investor") {

                        $sql = "SELECT distinct peinv.InvestorId,inv.Investor,inv.*,
                        (select country from country where countryid=pec.countryid) As Countryname
                        from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv
                        where  dates between '" . $from_date. "' and '" . $to_date . "' 
                        and  pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                        pe.StageId=s.StageId $investor_search and pec.industry!=15 and
                        pe.Deleted=0 and Investor!='Others'    
                        AND pec.industry IN (
                                                    SELECT industry
                                                    FROM  pecompanies AS pecIn
                                                    WHERE  pec.industry!=15
                        
                        ) GROUP BY peinv.InvestorId
                        order by inv.Investor".$dataLimit;
                        
                    } elseif($dirCategoryType == "company")  {

                        $sql = "SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region ,
                        (select country from country where countryid=pec.countryid) As Countryname
                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                        WHERE  dates between '" . $from_date. "' and '" . $to_date . "' and  pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                        AND r.RegionId = pec.RegionId  $company_search  AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) 
                        GROUP BY pe.PECompanyId ORDER BY pec.companyname".$dataLimit;
                        
                    } elseif($dirCategoryType == "legalAdvisor") {

                        $sql = "(SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        from peinvestments as pe, industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorinvestors AS adac,stage as s 
                        where c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  pe.Deleted=0 and c.industry = i.industryid 
                        and c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId AND adac.CIAId = cia.CIAID and AdvisorType='L'  
                        AND adac.PEId = pe.PEId  AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        UNION 
                        (SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        from peinvestments as pe, industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,stage as s 
                        where c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  pe.Deleted=0 and c.industry = i.industryid and 
                        c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId AND adac.CIAId = cia.CIAID and AdvisorType='L'  
                        AND adac.PEId = pe.PEId  AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        order by Cianame".$dataLimit;
                     
                    } elseif($dirCategoryType == "transactionAdvisor") {

                        $sql = "(SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        from peinvestments as pe, industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorinvestors AS adac,stage as s 
                        where c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  pe.Deleted=0 and c.industry = i.industryid 
                        and c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId AND adac.CIAId = cia.CIAID and AdvisorType='T'  
                        AND adac.PEId = pe.PEId  AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        UNION 
                        (SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        from peinvestments as pe, industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,stage as s 
                        where c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  pe.Deleted=0 and c.industry = i.industryid and 
                        c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId AND adac.CIAId = cia.CIAID and AdvisorType='T'  
                        AND adac.PEId = pe.PEId  AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        order by Cianame".$dataLimit;

                    } 

                } else {
                    
                     $sql = "SELECT distinct peinv.InvestorId,inv.Investor,inv.*
                     from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv
                     where  dates between '" . $from_date. "' and '" . $to_date . "' 
                     and  pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                     pe.StageId=s.StageId and pec.industry!=15 and
                     pe.Deleted=0 and Investor!='Others'    
                     AND pec.industry IN (
                                                 SELECT industry
                                                 FROM  pecompanies AS pecIn
                                                 WHERE  pec.industry!=15
                     
                                            )
                     order by inv.Investor  ".$dataLimit;
                }
            
            } elseif($dealCategory == 'VC'){ //for VC Investment

                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
    
                } elseif($investorsearch != ''){
    
                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
                }

                if($datatype == 1){

                    if($dirCategoryType == "investor") {

                        $sql = "SELECT distinct peinv.InvestorId,inv.Investor,inv.*,
                                (select country from country where countryid=pec.countryid) As Countryname
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv
                                where  dates between '" . $from_date. "' and '" . $to_date . "' 
                                and  pe.PECompanyId=pec.PECompanyId 
                                and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId $investor_search
                                and pec.industry!=15 
                                and pe.Deleted=0 and Investor!='Others' 
                                and s.VCview=1 and pe.amount<=20    
                                AND pec.industry IN (
                                                    SELECT industry
                                                    FROM  pecompanies AS pecIn
                                                    WHERE  pec.industry!=15
                        
                        ) GROUP BY peinv.InvestorId order by inv.Investor ".$dataLimit;

                    } elseif($dirCategoryType == "company")  {
                        
                        $sql = "SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region,
                        (select country from country where countryid=pec.countryid) As Countryname
                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r , stage AS s
                        WHERE  dates between '2016-5-01' and '2019-5-01' and  pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                        AND r.RegionId = pec.RegionId $company_search and s.VCview=1 and pe.amount<=20    AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) 
                        GROUP BY pe.PECompanyId ORDER BY pec.companyname".$dataLimit;
                        
                    } elseif($dirCategoryType == "legalAdvisor") {

                        $sql = "(SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        from peinvestments as pe, industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorinvestors AS adac,stage as s 
                        where c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  pe.Deleted=0 and c.industry = i.industryid 
                        and c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId AND adac.CIAId = cia.CIAID and AdvisorType='L'  
                        AND adac.PEId = pe.PEId AND s.VCview=1 and pe.amount<=20 AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        UNION 
                        (SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        from peinvestments as pe, industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,stage as s 
                        where c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  pe.Deleted=0 and c.industry = i.industryid and 
                        c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId AND adac.CIAId = cia.CIAID and AdvisorType='L'  
                        AND adac.PEId = pe.PEId AND s.VCview=1 and pe.amount<=20 AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        order by Cianame".$dataLimit;
                     
                    } elseif($dirCategoryType == "transactionAdvisor") {

                        $sql = "(SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        from peinvestments as pe, industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorinvestors AS adac,stage as s 
                        where c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  pe.Deleted=0 and c.industry = i.industryid 
                        and c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId AND adac.CIAId = cia.CIAID and AdvisorType='T'  
                        AND adac.PEId = pe.PEId AND s.VCview=1 and pe.amount<=20 AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        UNION 
                        (SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        from peinvestments as pe, industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adac,stage as s 
                        where c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  pe.Deleted=0 and c.industry = i.industryid and 
                        c.PEcompanyId = pe.PECompanyId and pe.StageId=s.StageId AND adac.CIAId = cia.CIAID and AdvisorType='T'  
                        AND adac.PEId = pe.PEId AND s.VCview=1 and pe.amount<=20 AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        order by Cianame".$dataLimit;

                    } 

                } else {
                    
                    $sql = " SELECT distinct peinv.InvestorId,inv.Investor,inv.*
                    from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv
                    where  dates between '" . $from_date. "' and '" . $to_date . "' 
                    and  pe.PECompanyId=pec.PECompanyId 
                    and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                    pe.StageId=s.StageId 
                    and pec.industry!=15 
                    and pe.Deleted=0 and Investor!='Others' 
                    and s.VCview=1 and pe.amount<=20    
                    AND pec.industry IN (
                                        SELECT industry
                                        FROM  pecompanies AS pecIn
                                        WHERE  pec.industry!=15
            
                         ) order by inv.Investor ".$dataLimit;
                }


               
            } elseif($dealCategory == 'CLEANTECH'){ //for CLEANTECH Investment
              
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
    
                } elseif($investorsearch != ''){
    
                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
                }

                if($datatype == 1){
                    
                    if($dirCategoryType == "investor") {

                        $sql = "SELECT distinct peinv.InvestorId,inv.Investor,inv.*,
                        (select country from country where countryid=pec.countryid) As Countryname
                        from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,
                        peinvestments_dbtypes as pedb where  dates between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                        pe.StageId=s.StageId $investor_search and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='CT' and
                        pe.Deleted=0 and Investor!='Others' AND pec.industry  IN (
                                                    SELECT industry
                                                    FROM  pecompanies AS pecIn
                                                    WHERE  pec.industry!=15
                        
                        )
                        GROUP BY peinv.InvestorId order by inv.Investor".$dataLimit;
                        
                    } elseif($dirCategoryType == "company")  {
                        
                        $sql = "SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region,
                        (select country from country where countryid=pec.countryid) As Countryname
                        FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,stage AS s ,peinvestments_dbtypes as pedb
                        WHERE  dates between '" . $from_date. "' and '" . $to_date . "' and  pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                        and  pedb.PEId=pe.PEId and pedb.DBTypeId='CT'
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                        AND r.RegionId = pec.RegionId $company_search AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) 
                        GROUP BY pe.PECompanyId ORDER BY pec.companyname".$dataLimit;
                        
                    } elseif($dirCategoryType == "legalAdvisor") {

                        $sql = "(SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        FROM peinvestments AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,
                        peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb 
                        WHERE c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  peinv.Deleted=0 and  s.StageId = peinv.StageId   
                        AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='CT'
                        AND adac.CIAId = cia.CIAID and AdvisorType='L'   
                        AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) AND adac.PEId = peinv.PEId ) 
                        UNION 
                        (SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM peinvestments AS peinv,industry as i,
                        investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,peinvestments_advisorcompanies AS adac, stage as s,peinvestments_dbtypes as pedb 
                        WHERE c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  peinv.Deleted=0 and  s.StageId = peinv.StageId   
                        AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='CT'
                        AND adac.CIAId = cia.CIAID and AdvisorType='L'   
                        AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22)  
                        AND adac.PEId = peinv.PEId ) 
                        order by Cianame".$dataLimit;
                     
                    } elseif($dirCategoryType == "transactionAdvisor") {

                        $sql = "(SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        FROM peinvestments AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,
                        peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb 
                        WHERE c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  peinv.Deleted=0 and  s.StageId = peinv.StageId   
                        AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='CT'
                        AND adac.CIAId = cia.CIAID and AdvisorType='T'   
                        AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) AND adac.PEId = peinv.PEId ) 
                        UNION 
                        (SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM peinvestments AS peinv,industry as i,
                        investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,peinvestments_advisorcompanies AS adac, stage as s,peinvestments_dbtypes as pedb 
                        WHERE c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  peinv.Deleted=0 and  s.StageId = peinv.StageId   
                        AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='CT'
                        AND adac.CIAId = cia.CIAID and AdvisorType='T'   
                        AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22)  
                        AND adac.PEId = peinv.PEId ) 
                        order by Cianame".$dataLimit;

                    } 
                     
                } else {
                    $sql = "SELECT distinct peinv.InvestorId,inv.Investor,inv.*
                    from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,
                    peinvestments_dbtypes as pedb where  dates between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                    pe.StageId=s.StageId and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='CT' and
                    pe.Deleted=0 and Investor!='Others' AND pec.industry  IN (
                                                SELECT industry
                                                FROM  pecompanies AS pecIn
                                                WHERE  pec.industry!=15
                    
                    )
                    order by inv.Investor".$dataLimit;
                }

              }elseif($dealCategory == 'INFRASTRUCTURE'){ // for Infrastructure Investment 
               
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
    
                } elseif($investorsearch != ''){
    
                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
                }

                if($datatype == 1){
                    
                    if($dirCategoryType == "investor") {

                        $sql = "SELECT distinct peinv.InvestorId,inv.Investor,inv.*,
                                (select country from country where countryid=pec.countryid) As Countryname
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,
                                peinvestments_dbtypes as pedb where  dates between '" . $from_date. "' and '" . $to_date . "'and  pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId $investor_search and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='IF' and
                                pe.Deleted=0 and Investor!='Others'    AND pec.industry  IN (
                                                            SELECT industry
                                                            FROM  pecompanies AS pecIn
                                                            WHERE  pec.industry!=15
                            )
                            GROUP BY peinv.InvestorId order by inv.Investor".$dataLimit;
                        
                    } elseif($dirCategoryType == "company")  {
                        
                        $sql = "SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region,
                                (select country from country where countryid=pec.countryid) As Countryname
                                FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,stage AS s ,peinvestments_dbtypes as pedb
                                WHERE  dates between '" . $from_date. "' and '" . $to_date . "' and  pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                and  pedb.PEId=pe.PEId and pedb.DBTypeId='IF'
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId $company_search AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) 
                                GROUP BY pe.PECompanyId ORDER BY pec.companyname".$dataLimit;
                        
                    } elseif($dirCategoryType == "legalAdvisor") {

                        $sql = "(SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        FROM peinvestments AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,
                        peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb 
                        WHERE c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  peinv.Deleted=0 and  s.StageId = peinv.StageId   
                        AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='IF'
                        AND adac.CIAId = cia.CIAID and AdvisorType='L'   
                        AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) AND adac.PEId = peinv.PEId ) 
                        UNION 
                        (SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM peinvestments AS peinv,industry as i,
                        investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,peinvestments_advisorcompanies AS adac, stage as s,peinvestments_dbtypes as pedb 
                        WHERE c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  peinv.Deleted=0 and  s.StageId = peinv.StageId   
                        AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='IF'
                        AND adac.CIAId = cia.CIAID and AdvisorType='L'   
                        AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22)  
                        AND adac.PEId = peinv.PEId ) 
                        order by Cianame".$dataLimit;
                     
                    } elseif($dirCategoryType == "transactionAdvisor") {

                        $sql = "(SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        FROM peinvestments AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,
                        peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb 
                        WHERE c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  peinv.Deleted=0 and  s.StageId = peinv.StageId   
                        AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='IF'
                        AND adac.CIAId = cia.CIAID and AdvisorType='T'   
                        AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) AND adac.PEId = peinv.PEId ) 
                        UNION 
                        (SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM peinvestments AS peinv,industry as i,
                        investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,peinvestments_advisorcompanies AS adac, stage as s,peinvestments_dbtypes as pedb 
                        WHERE c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  peinv.Deleted=0 and  s.StageId = peinv.StageId   
                        AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='IF'
                        AND adac.CIAId = cia.CIAID and AdvisorType='T'   
                        AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22)  
                        AND adac.PEId = peinv.PEId ) 
                        order by Cianame".$dataLimit;

                    } 
                     
                } else {
                    
                    $sql = "SELECT distinct peinv.InvestorId,inv.Investor,inv.*
                    from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,
                    peinvestments_dbtypes as pedb where  dates between '" . $from_date. "' and '" . $to_date . "'and  pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                    pe.StageId=s.StageId and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='IF' and
                    pe.Deleted=0 and Investor!='Others'    AND pec.industry  IN (
                                                SELECT industry
                                                FROM  pecompanies AS pecIn
                                                WHERE  pec.industry!=15
                    
                    )
                    order by inv.Investor".$dataLimit;
                }

              } 
              elseif($dealCategory == 'SOCIAL'){ //for SOCIAL Investment
              
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
    
                } elseif($investorsearch != ''){
    
                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
                }

                if($datatype == 1){
                    
                    if($dirCategoryType == "investor") {

                        $sql = "SELECT distinct peinv.InvestorId,inv.Investor,inv.*,
                                (select country from country where countryid=pec.countryid) As Countryname
                                from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,
                                peinvestments_dbtypes as pedb where  dates between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                                pe.StageId=s.StageId $investor_search and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='SV' and
                                pe.Deleted=0 and Investor!='Others'  and inv.FirmTypeId = 4   AND pec.industry  IN (
                                                            SELECT industry
                                                            FROM  pecompanies AS pecIn
                                                            WHERE  pec.industry!=15
                                
                                )
                                GROUP BY peinv.InvestorId order by inv.Investor".$dataLimit;
                        
                    } elseif($dirCategoryType == "company")  {
                        
                        $sql = "SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region,
                                (select country from country where countryid=pec.countryid) As Countryname
                                FROM pecompanies AS pec, peinvestments AS pe, industry AS i, region AS r ,stage AS s ,peinvestments_dbtypes as pedb
                                WHERE  dates between '" . $from_date. "' and '" . $to_date . "' and  pec.PECompanyId = pe.PEcompanyId AND s.StageId = pe.StageId  
                                and  pedb.PEId=pe.PEId and pedb.DBTypeId='SV'
                                AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                AND r.RegionId = pec.RegionId $company_search AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) 
                                GROUP BY pe.PECompanyId ORDER BY pec.companyname".$dataLimit;
                        
                    } elseif($dirCategoryType == "legalAdvisor") {

                        $sql = "(SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        FROM peinvestments AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,
                        peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb 
                        WHERE c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  peinv.Deleted=0 and  s.StageId = peinv.StageId   
                        AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='SV'
                        AND adac.CIAId = cia.CIAID and AdvisorType='L'   
                        AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) AND adac.PEId = peinv.PEId ) 
                        UNION 
                        (SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM peinvestments AS peinv,industry as i,
                        investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,peinvestments_advisorcompanies AS adac, stage as s,peinvestments_dbtypes as pedb 
                        WHERE c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  peinv.Deleted=0 and  s.StageId = peinv.StageId   
                        AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='SV'
                        AND adac.CIAId = cia.CIAID and AdvisorType='L'   
                        AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22)  
                        AND adac.PEId = peinv.PEId ) 
                        order by Cianame".$dataLimit;
                     
                    } elseif($dirCategoryType == "transactionAdvisor") {

                        $sql = "(SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        FROM peinvestments AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,
                        peinvestments_advisorinvestors AS adac, stage as s,peinvestments_dbtypes as pedb 
                        WHERE c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  peinv.Deleted=0 and  s.StageId = peinv.StageId   
                        AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='SV'
                        AND adac.CIAId = cia.CIAID and AdvisorType='T'   
                        AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) AND adac.PEId = peinv.PEId ) 
                        UNION 
                        (SELECT distinct adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,
                        cia.phoneno,cia.contactperson,cia.designation,cia.email,cia.linkedin FROM peinvestments AS peinv,industry as i,
                        investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia,peinvestments_advisorcompanies AS adac, stage as s,peinvestments_dbtypes as pedb 
                        WHERE c.RegionId=re.RegionId and dates between '" . $from_date. "' and '" . $to_date . "' and  peinv.Deleted=0 and  s.StageId = peinv.StageId   
                        AND c.PECompanyId = peinv.PECompanyId  and pedb.PEId=peinv.PEId and pedb.DBTypeId='SV'
                        AND adac.CIAId = cia.CIAID and AdvisorType='T'   
                        AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22)  
                        AND adac.PEId = peinv.PEId ) 
                        order by Cianame".$dataLimit;

                    } 
                     
                } else {
                    
                    $sql = "SELECT distinct peinv.InvestorId,inv.Investor,inv.*
                    from peinvestments_investors as peinv,peinvestments as pe,pecompanies as pec,stage as s,peinvestors as inv,
                    peinvestments_dbtypes as pedb where  dates between '" . $from_date. "' and '" . $to_date . "'and  pe.PECompanyId=pec.PECompanyId and peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                    pe.StageId=s.StageId and pec.industry!=15  and  pedb.PEId=pe.PEId and pedb.DBTypeId='IF' and
                    pe.Deleted=0 and Investor!='Others'    AND pec.industry  IN (
                                                SELECT industry
                                                FROM  pecompanies AS pecIn
                                                WHERE  pec.industry!=15
                    
                    )
                    order by inv.Investor".$dataLimit;
                }
            }
    
            elseif($dealCategory == 'INCUBATION'){ //for INCUBATION Investment

                if($companysearch != ''){
                    
                    $comsql = "SELECT DISTINCT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
    
                } elseif($investorsearch != ''){
    
                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
                }

                if($datatype == 1){
                     
                    if ( $dirCategoryType == "incubator" ) {  

                        $sql = "SELECT DISTINCT pe.IncubatorId, inc.Incubator,inc.*
                        FROM incubatordeals AS pe,  incubators as inc
                        WHERE inc.IncubatorId=pe.IncubatorId AND inc.Incubator != '' and pe.Deleted=0  
                        order by inc.Incubator".$dataLimit;

                    } elseif ($dirCategoryType == "incubatee") {
                        
                        $sql = "SELECT DISTINCT pe.IncubateeId, pec. *,
                        (select country from country where countryid=pec.countryid) As Countryname
                        FROM pecompanies AS pec, incubatordeals AS pe,industry as i
                        WHERE   pec.PECompanyId = pe.IncubateeId AND i.industryid=pec.industry
                        and pe.Deleted=0  AND pec.industry  IN (
                                                SELECT industry
                                                FROM  pecompanies AS pecIn
                                                WHERE  pec.industry!=15
                    
                      )  and pec.industry!=15
                        ORDER BY pec.companyname".$dataLimit;

                    }

                    
                } 

             } 
             elseif($dealCategory == 'ANGEL'){  //for ANGEL Investment
                
                if($companysearch != ''){
                    
                    $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch'";
                    $comrs = mysql_query($comsql);
                    $comres = mysql_fetch_array($comrs);
                    $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
    
                } elseif($investorsearch != ''){
    
                    $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
                    $invrs = mysql_query($invsql);
                    $invres = mysql_fetch_array($invrs);
                    $investor_search = " AND inv.InvestorId IN(".$invres['investorId'].")";
                }

                if($datatype == 1){
                    //angelInvestor
                    if ( $dirCategoryType == "investor" ) {
                        
                        $sql = "SELECT DISTINCT inv.InvestorId, inv.Investor, inv.*,
                        (select country from country where countryid=pec.countryid) As Countryname
                        FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv, country as c 
                        where  DealDate  between '" . $from_date. "' and '" . $to_date . "' and  pe.InvesteeId = pec.PEcompanyId and inv.countryid= c.countryid  
                        AND pec.industry !=15
                        AND peinv.AngelDealId = pe.AngelDealId
                        AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0 and Investor!='Others' $investor_search  AND pec.industry  IN (
                                                    SELECT industry
                                                    FROM  pecompanies AS pecIn
                                                    WHERE  pec.industry!=15
                        
                        )
                        group by inv.InvestorId order by inv.Investor".$dataLimit;
                        
                    } elseif ( $dirCategoryType == "fundedComp") {

                        $sql = "SELECT DISTINCT pe.InvesteeId, pec. * , i.industry, r.Region,
                        (select country from country where countryid=pec.countryid) As Countryname
                        FROM pecompanies AS pec, angelinvdeals AS pe, industry AS i, region AS r WHERE  DealDate between '" . $from_date. "' and '" . $to_date . "' and pec.PECompanyId = pe.InvesteeId 
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                        AND r.RegionId = pec.RegionId    AND pec.industry  IN (
                                                    SELECT industry
                                                    FROM  pecompanies AS pecIn
                                                    WHERE  pec.industry!=15
                        
                        )
                        ORDER BY pec.companyname".$dataLimit;
                        
                    } elseif ( $dirCategoryType == "fundraisingComp") {

                        $sql = "SELECT a.*,p.PECompanyId FROM angelco_fundraising_cos a 
                        LEFT JOIN  pecompanies p ON p.angelco_compID=a.angel_id 
                        ORDER BY a.company_name".$dataLimit;

                        
                    }
                    
                    
                }

             } 
        } else { 

        if($dealCategory == 'PEMA') {

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
                $investor_from = " ,manda_investors as peinv_invs,peinvestors as invs";
                $investor_where = " and peinv_invs.MandAId=pe.MandAId and invs.InvestorId=peinv_invs.InvestorId";
            }
            if($datatype == 1){
                if($dirCategoryType == "investor") {

                    $sql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv. *,
                    (select country from country where countryid=pec.countryid) As Countryname
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv    , dealtypes as dt
                            WHERE  DealDate between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 and Investor!='Others' $investor_search   
                            AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0 AND pec.industry IN (SELECT industry FROM  pecompanies AS pecIn WHERE  pec.industry!=15)
                            group by inv.InvestorId order by inv.Investor".$dataLimit;
                    
                } elseif($dirCategoryType == "company")  {
                   
                    $sql = "SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region,
                    (select country from country where countryid=pec.countryid) As Countryname
                    FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r   , dealtypes as dt 
                    WHERE  DealDate between '" . $from_date. "' and '" . $to_date . "' and   pec.PECompanyId = pe.PEcompanyId 
                    AND i.industryid = pec.industry and pe.Deleted=0 $company_search and pec.industry!=15
                    AND r.RegionId = pec.RegionId AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0 AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) 
                    ORDER BY pec.companyname".$dataLimit;
                    
                } elseif($dirCategoryType == "legalAdvisor") {

                    $sql = "(SELECT DISTINCT adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,
                    cia.contactperson,cia.designation,cia.email,cia.linkedin 
                    FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac, dealtypes as dt     
                    WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' AND c.RegionId=re.RegionId and Deleted =0
                    AND c.PECompanyId = peinv.PECompanyId AND adac.CIAId = cia.CIAID and AdvisorType='L'   
                    AND adac.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0  
                    AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                    UNION (SELECT DISTINCT adcomp.CIAId, cia.Cianame, cia.AdvisorType, adcomp.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,
                    cia.designation,cia.email,cia.linkedin 
                    FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, dealtypes as dt
                    WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' AND c.RegionId=re.RegionId and Deleted =0 AND c.PECompanyId = peinv.PECompanyId AND adcomp.CIAId = cia.CIAID and AdvisorType='L'   
                    AND adcomp.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0  AND 
                    c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                    order by Cianame".$dataLimit;
                 
                } elseif($dirCategoryType == "transactionAdvisor") {

                    $sql = "(SELECT DISTINCT adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,
                    cia.contactperson,cia.designation,cia.email,cia.linkedin 
                    FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac, dealtypes as dt     
                    WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' AND c.RegionId=re.RegionId and Deleted =0
                    AND c.PECompanyId = peinv.PECompanyId AND adac.CIAId = cia.CIAID and AdvisorType='T'   
                    AND adac.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0  
                    AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                    UNION (SELECT DISTINCT adcomp.CIAId, cia.Cianame, cia.AdvisorType, adcomp.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,
                    cia.designation,cia.email,cia.linkedin 
                    FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, dealtypes as dt
                    WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' AND c.RegionId=re.RegionId and Deleted =0 AND c.PECompanyId = peinv.PECompanyId AND adcomp.CIAId = cia.CIAID and AdvisorType='T'   
                    AND adcomp.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0  AND 
                    c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                    order by Cianame".$dataLimit;

                } 

            } else {
                $sql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv. *
                        FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv    , dealtypes as dt
                        WHERE  DealDate between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId = pec.PEcompanyId
                        AND pec.industry !=15
                        AND peinv.MandAId = pe.MandAId
                        AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0 and Investor!='Others'   
                        AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0 AND pec.industry IN (SELECT industry FROM  pecompanies AS pecIn WHERE  pec.industry!=15)
                        order by inv.Investor".$dataLimit;
            }
            
            
            } elseif($dealCategory == 'PEPM') { 

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
                    $investor_from = " ,manda_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.MandAId=pe.MandAId and invs.InvestorId=peinv_invs.InvestorId";
                }

                if($datatype == 1){
                    if($dirCategoryType == "investor") {
    
                        $sql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv. *,
                        (select country from country where countryid=pec.countryid) As Countryname
                                FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv    , dealtypes as dt
                                WHERE  DealDate between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId = pec.PEcompanyId
                                AND pec.industry !=15
                                AND peinv.MandAId = pe.MandAId
                                AND inv.InvestorId = peinv.InvestorId
                                AND pe.Deleted=0 and Investor!='Others' $investor_search  
                                AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1 AND pec.industry IN (SELECT industry FROM  pecompanies AS pecIn WHERE  pec.industry!=15)
                                group by inv.InvestorId order by inv.Investor".$dataLimit;
                        
                    } elseif($dirCategoryType == "company")  {
                       
                        $sql = "SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region,
                        (select country from country where countryid=pec.countryid) As Countryname
                        FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r   , dealtypes as dt 
                        WHERE  DealDate between '" . $from_date. "' and '" . $to_date . "' and   pec.PECompanyId = pe.PEcompanyId 
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15 $company_search
                        AND r.RegionId = pec.RegionId AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1 AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) 
                        ORDER BY pec.companyname".$dataLimit;
                        
                    } elseif($dirCategoryType == "legalAdvisor") {

                        $sql = "(SELECT DISTINCT adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,
                        cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac, dealtypes as dt     
                        WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' AND c.RegionId=re.RegionId and Deleted =0
                        AND c.PECompanyId = peinv.PECompanyId AND adac.CIAId = cia.CIAID and AdvisorType='L'   
                        AND adac.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1  
                        AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        UNION (SELECT DISTINCT adcomp.CIAId, cia.Cianame, cia.AdvisorType, adcomp.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,
                        cia.designation,cia.email,cia.linkedin 
                        FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, dealtypes as dt
                        WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' AND c.RegionId=re.RegionId and Deleted =0 AND c.PECompanyId = peinv.PECompanyId AND adcomp.CIAId = cia.CIAID and AdvisorType='L'   
                        AND adcomp.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1  AND 
                        c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        order by Cianame".$dataLimit;
                     
                    } elseif($dirCategoryType == "transactionAdvisor") {
    
                        $sql = "(SELECT DISTINCT adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,
                        cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac, dealtypes as dt     
                        WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' AND c.RegionId=re.RegionId and Deleted =0
                        AND c.PECompanyId = peinv.PECompanyId AND adac.CIAId = cia.CIAID and AdvisorType='T'   
                        AND adac.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1  
                        AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        UNION (SELECT DISTINCT adcomp.CIAId, cia.Cianame, cia.AdvisorType, adcomp.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,
                        cia.designation,cia.email,cia.linkedin 
                        FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, dealtypes as dt
                        WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' AND c.RegionId=re.RegionId and Deleted =0 AND c.PECompanyId = peinv.PECompanyId AND adcomp.CIAId = cia.CIAID and AdvisorType='T'   
                        AND adcomp.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1  AND 
                        c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        order by Cianame".$dataLimit;
    
                    } 
    
                } else {
                    $sql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv. *
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv    , dealtypes as dt
                            WHERE  DealDate between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId = pec.PEcompanyId
                            AND pec.industry !=15
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId
                            AND pe.Deleted=0 and Investor!='Others'   
                            AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1 AND pec.industry IN (SELECT industry FROM  pecompanies AS pecIn WHERE  pec.industry!=15)
                            order by inv.Investor".$dataLimit;
                }
                // $sql="SELECT DISTINCT inv.InvestorId, inv.Investor
                // FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv    , dealtypes as dt 
                // WHERE  DealDate between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId = pec.PEcompanyId
                // AND pec.industry !=15
                // AND peinv.MandAId = pe.MandAId
                // AND inv.InvestorId = peinv.InvestorId
                // AND pe.Deleted=0 and Investor!='Others' 
                // AND pe.DealTypeId= dt.DealTypeId  
                // AND dt.hide_for_exit=1 AND pec.industry  IN (
                //                                                 SELECT industry
                //                                                 FROM  pecompanies AS pecIn
                //                                                  WHERE  pec.industry!=15
                //                                            )
                // order by inv.Investor".$dataLimit;

            }
            elseif($dealCategory == 'PEIPO') { 

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
                    $investor_from = " ,manda_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.MandAId=pe.MandAId and invs.InvestorId=peinv_invs.InvestorId";
                }
                if($datatype == 1){
                    if($dirCategoryType == "investor") {
    
                        $sql="SELECT DISTINCT inv.InvestorId, inv.Investor, inv. *,
                        (select country from country where countryid=pec.countryid) As Countryname
                        FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                        WHERE  IPODate between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId = pec.PEcompanyId
                        AND pec.industry !=15
                        AND peinv.IPOId = pe.IPOId
                        AND inv.InvestorId = peinv.InvestorId 
                        AND pe.Deleted=0 and Investor!='Others' $investor_search AND pec.industry IN (
                                                                        SELECT industry
                                                                        FROM  pecompanies AS pecIn
                                                                        WHERE  pec.industry!=15
                                                                )
                        order by inv.Investor".$dataLimit;
                        
                    } elseif($dirCategoryType == "company")  {
                        $sql = "SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region,
                        (select country from country where countryid=pec.countryid) As Countryname
                        FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                        WHERE  IPODate between '" . $from_date. "' and '" . $to_date . "' and  pec.PECompanyId = pe.PEcompanyId 
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                        AND r.RegionId = pec.RegionId  $company_search  AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22)  
                        ORDER BY pec.companyname".$dataLimit;
                    } 
    
                } else {
                    $sql="SELECT DISTINCT inv.InvestorId, inv.Investor
                        FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                        WHERE  IPODate between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId = pec.PEcompanyId
                        AND pec.industry !=15
                        AND peinv.IPOId = pe.IPOId
                        AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0 and Investor!='Others' AND pec.industry IN (
                                                                        SELECT industry
                                                                        FROM  pecompanies AS pecIn
                                                                        WHERE  pec.industry!=15
                                                                )
                        order by inv.Investor".$dataLimit;
                }
                

            }
            elseif($dealCategory == 'VCMA') { 

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
                    $investor_from = " ,manda_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.MandAId=pe.MandAId and invs.InvestorId=peinv_invs.InvestorId";
                }
                
                if($datatype == 1){
                    if($dirCategoryType == "investor") {
    
                        $sql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv. *,
                        (select country from country where countryid=pec.countryid) As Countryname
                          FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv    , dealtypes as dt 
                          WHERE  DealDate between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId = pec.PEcompanyId
                          AND pec.industry !=15 AND peinv.MandAId = pe.MandAId AND inv.InvestorId = peinv.InvestorId
                          AND pe.Deleted=0 and Investor!='Others'  and VCFlag=1 AND pe.DealTypeId= dt.DealTypeId 
                          AND dt.hide_for_exit=0 $investor_search AND pec.industry  IN (
                          SELECT industry FROM  pecompanies AS pecIn WHERE  pec.industry!=15 )
                          order by inv.Investor".$dataLimit;
                        
                    } elseif($dirCategoryType == "company")  {
                        $sql = "SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region,
                        (select country from country where countryid=pec.countryid) As Countryname
                        FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r   , dealtypes as dt 
                        WHERE  DealDate between '" . $from_date. "' and '" . $to_date . "' and   pec.PECompanyId = pe.PEcompanyId 
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                        AND r.RegionId = pec.RegionId $company_search and VCFlag=1  AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0 
                        AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) 
                        ORDER BY pec.companyname" .$dataLimit;
                    } elseif($dirCategoryType == "legalAdvisor") {

                        $sql = "(SELECT DISTINCT adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,
                        cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac, dealtypes as dt     
                        WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' AND c.RegionId=re.RegionId and Deleted =0
                        AND c.PECompanyId = peinv.PECompanyId AND adac.CIAId = cia.CIAID and AdvisorType='L'   
                        AND adac.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0  
                        AND VCFlag=1 AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        UNION (SELECT DISTINCT adcomp.CIAId, cia.Cianame, cia.AdvisorType, adcomp.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,
                        cia.designation,cia.email,cia.linkedin 
                        FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, dealtypes as dt
                        WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' AND c.RegionId=re.RegionId and Deleted =0 AND c.PECompanyId = peinv.PECompanyId AND adcomp.CIAId = cia.CIAID and AdvisorType='L'   
                        AND adcomp.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0  AND 
                        VCFlag=1 AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        order by Cianame".$dataLimit;
                     
                    } elseif($dirCategoryType == "transactionAdvisor") {
    
                        $sql = "(SELECT DISTINCT adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,
                        cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac, dealtypes as dt     
                        WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' AND c.RegionId=re.RegionId and Deleted =0
                        AND c.PECompanyId = peinv.PECompanyId AND adac.CIAId = cia.CIAID and AdvisorType='T'   
                        AND adac.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0  
                        AND VCFlag=1 AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        UNION (SELECT DISTINCT adcomp.CIAId, cia.Cianame, cia.AdvisorType, adcomp.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,
                        cia.designation,cia.email,cia.linkedin 
                        FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, dealtypes as dt
                        WHERE DealDate between '" . $from_date. "' and '" . $to_date . "' AND c.RegionId=re.RegionId and Deleted =0 AND c.PECompanyId = peinv.PECompanyId AND adcomp.CIAId = cia.CIAID and AdvisorType='T'   
                        AND adcomp.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0  AND 
                        VCFlag=1 AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        order by Cianame".$dataLimit;
    
                    } 
    
                } else {
                    $sql="SELECT DISTINCT inv.InvestorId, inv.Investor
                          FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv    , dealtypes as dt 
                          WHERE  DealDate between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId = pec.PEcompanyId
                          AND pec.industry !=15 AND peinv.MandAId = pe.MandAId AND inv.InvestorId = peinv.InvestorId
                          AND pe.Deleted=0 and Investor!='Others'  and VCFlag=1    AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0 AND pec.industry  IN (
                          SELECT industry FROM  pecompanies AS pecIn WHERE  pec.industry!=15 )
                          order by inv.Investor".$dataLimit;
                }

                

            }
            elseif($dealCategory == 'VCPM') {

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
                    $investor_from = " ,manda_investors as peinv_invs,peinvestors as invs";
                    $investor_where = " and peinv_invs.MandAId=pe.MandAId and invs.InvestorId=peinv_invs.InvestorId";
                }
                
                if($datatype == 1){
                    if($dirCategoryType == "investor") {
                        $sql="SELECT DISTINCT inv.InvestorId, inv.Investor, inv.*,
                          (select country from country where countryid=pec.countryid) As Countryname
                          FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv    , dealtypes as dt 
                          WHERE  DealDate between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId = pec.PEcompanyId
                          AND pec.industry !=15 AND peinv.MandAId = pe.MandAId AND inv.InvestorId = peinv.InvestorId
                          AND pe.Deleted=0 and Investor!='Others' $investor_search and VCFlag=1 AND pe.DealTypeId= dt.DealTypeId 
                          AND dt.hide_for_exit=1 AND pec.industry  IN (
                          SELECT industry FROM  pecompanies AS pecIn WHERE  pec.industry!=15 )
                          order by inv.Investor".$dataLimit;
                    } elseif($dirCategoryType == "company")  {
                        $sql = "SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region,
                        (select country from country where countryid=pec.countryid) As Countryname
                        FROM pecompanies AS pec, manda AS pe, industry AS i, region AS r   , dealtypes as dt 
                        WHERE  DealDate between '" . $from_date. "' and '" . $to_date . "' and   pec.PECompanyId = pe.PEcompanyId 
                        AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                        AND r.RegionId = pec.RegionId $company_search and VCFlag=1 AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1 
                        AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) 
                        ORDER BY pec.companyname " .$dataLimit;
                    } elseif($dirCategoryType == "legalAdvisor") {

                        $sql = "(SELECT DISTINCT adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,
                        cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac, dealtypes as dt     
                        WHERE c.RegionId=re.RegionId and Deleted =0
                        AND c.PECompanyId = peinv.PECompanyId AND adac.CIAId = cia.CIAID and AdvisorType='L'   
                        AND adac.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1  
                        AND VCFlag=1 AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        UNION (SELECT DISTINCT adcomp.CIAId, cia.Cianame, cia.AdvisorType, adcomp.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,
                        cia.designation,cia.email,cia.linkedin 
                        FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, dealtypes as dt
                        WHERE c.RegionId=re.RegionId and Deleted =0 AND c.PECompanyId = peinv.PECompanyId AND adcomp.CIAId = cia.CIAID and AdvisorType='L'   
                        AND adcomp.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1  AND 
                        VCFlag=1 AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        order by Cianame".$dataLimit;
                     
                    } elseif($dirCategoryType == "transactionAdvisor") {
    
                        $sql = "(SELECT DISTINCT adac.CIAId, cia.Cianame, cia.AdvisorType, adac.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,
                        cia.contactperson,cia.designation,cia.email,cia.linkedin 
                        FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisoracquirer AS adac, dealtypes as dt     
                        WHERE c.RegionId=re.RegionId and Deleted =0
                        AND c.PECompanyId = peinv.PECompanyId AND adac.CIAId = cia.CIAID and AdvisorType='T'   
                        AND adac.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1  
                        AND VCFlag=1 AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        UNION (SELECT DISTINCT adcomp.CIAId, cia.Cianame, cia.AdvisorType, adcomp.CIAId AS AcqCIAId,cia.website,cia.address,cia.city,cia.country,cia.phoneno,cia.contactperson,
                        cia.designation,cia.email,cia.linkedin 
                        FROM manda AS peinv,industry as i,investortype as inv,region as re, pecompanies AS c, advisor_cias AS cia, peinvestments_advisorcompanies AS adcomp, dealtypes as dt
                        WHERE c.RegionId=re.RegionId and Deleted =0 AND c.PECompanyId = peinv.PECompanyId AND adcomp.CIAId = cia.CIAID and AdvisorType='T'   
                        AND adcomp.PEId = peinv.MandAId AND peinv.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1  AND 
                        VCFlag=1 AND c.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22) ) 
                        order by Cianame".$dataLimit;
    
                    }  


                } else {
                        $sql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv.*,
                        (select country from country where countryid=pec.countryid) As Countryname
                        FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv    , dealtypes as dt 
                        WHERE  DealDate between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId = pec.PEcompanyId
                        AND pec.industry !=15 AND peinv.MandAId = pe.MandAId AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0 and Investor!='Others' and VCFlag=1 AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1 AND pec.industry  IN (
                        SELECT industry FROM  pecompanies AS pecIn WHERE  pec.industry!=15 )
                        order by inv.Investor".$dataLimit;
                }

                


            }elseif($dealCategory == 'VCIPO'){  

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

                if($datatype == 1){
                    if($dirCategoryType == "investor") {
                        $sql="SELECT DISTINCT inv.InvestorId, inv.Investor,inv. *,
                        (select country from country where countryid=pec.countryid) As Countryname
                        FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                        WHERE  IPODate between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId = pec.PEcompanyId
                        AND pec.industry !=15
                        AND peinv.IPOId = pe.IPOId
                        AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0 and Investor!='Others' $investor_search and VCFlag=1  
                        AND pec.industry IN ( SELECT industry FROM  pecompanies AS pecIn WHERE  pec.industry!=15 )
                        order by inv.Investor".$dataLimit;
                    } elseif($dirCategoryType == "company")  {
                        $sql = "SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region,
                        (select country from country where countryid=pec.countryid) As Countryname
                        FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r
                        WHERE  IPODate between '" . $from_date. "' and '" . $to_date . "' and  pec.PECompanyId = pe.PEcompanyId 
                        AND i.industryid = pec.industry and pe.Deleted=0 and VCFlag=1 and pec.industry!=15
                        AND r.RegionId = pec.RegionId $company_search   AND pec.industry IN (49, 14, 9, 25, 24, 7, 4, 16, 17, 23, 3, 21, 1, 2, 10, 54, 18, 11, 66, 106, 8, 12, 22)  
                        ORDER BY pec.companyname".$dataLimit;
                    } 
                } else {
                        $sql="SELECT DISTINCT inv.InvestorId, inv.Investor
                        FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                        WHERE  IPODate between '" . $from_date. "' and '" . $to_date . "' and  pe.PECompanyId = pec.PEcompanyId
                        AND pec.industry !=15
                        AND peinv.IPOId = pe.IPOId
                        AND inv.InvestorId = peinv.InvestorId
                        AND pe.Deleted=0 and Investor!='Others'  and VCFlag=1  
                        AND pec.industry IN ( SELECT industry FROM  pecompanies AS pecIn WHERE  pec.industry!=15 )
                        order by inv.Investor".$dataLimit;
                }
            }
        }
           
    } else if ($categoryType == "FD")  {
        if($investorsearch != ''){
            $invsql = "SELECT GROUP_CONCAT(InvestorId) as investorId FROM  `peinvestors` WHERE  `Investor` LIKE  '$investorsearch'";
            $invrs = mysql_query($invsql);
            $invres = mysql_fetch_array($invrs);
            $investor_search = " AND fd.investorId IN(".$invres['investorId'].")";
        }
        if($datatype == 1){
            $sql="SELECT pi.InvestorId,pi.Investor,fn.fundName,fn.fundId,fd.fundManager,fd.id,DATE_FORMAT( fd.fundDate, '%b-%Y' )as fundDate,fd.size,fts.fundTypeName as stage,fti.fundTypeName as industry,frs.fundStatus,fd.fundClosedStatus,fes.closeStatus,fcs.source, fd.amount_raised, fd.moreInfo, fd.source as fdsource FROM fundRaisingDetails as fd
                LEFT JOIN peinvestors pi ON fd.investorId = pi.InvestorId
                LEFT JOIN fundNames fn ON fd.fundName = fn.fundId
                LEFT JOIN fundType fts ON  fd.fundTypeStage=fts.id 
                LEFT JOIN fundType fti ON  fd.fundTypeIndustry=fti.id 
                LEFT JOIN fundRaisingStatus frs ON fd.fundStatus = frs.id
                LEFT JOIN fundCloseStatus fes ON fd.fundClosedStatus = fes.id
                LEFT JOIN fundCapitalSource fcs ON fd.capitalSource = fcs.id 
                WHERE fd.dbtype='PE'  and (fd.fundDate between "."'".$from_date."'"." and "."'".$to_date."'".") $investor_search order by fd.fundDate desc".$dataLimit;

        } else {
            $sql="SELECT pi.InvestorId,pi.Investor,fn.fundName,fn.fundId,fd.fundManager,fd.id,DATE_FORMAT( fd.fundDate, '%b-%Y' )as fundDate,fd.size,fts.fundTypeName as stage,fti.fundTypeName as industry,frs.fundStatus,fd.fundClosedStatus,fes.closeStatus,fcs.source, fd.amount_raised, fd.moreInfo, fd.source as fdsource FROM fundRaisingDetails as fd
                LEFT JOIN peinvestors pi ON fd.investorId = pi.InvestorId
                LEFT JOIN fundNames fn ON fd.fundName = fn.fundId
                LEFT JOIN fundType fts ON  fd.fundTypeStage=fts.id 
                LEFT JOIN fundType fti ON  fd.fundTypeIndustry=fti.id 
                LEFT JOIN fundRaisingStatus frs ON fd.fundStatus = frs.id
                LEFT JOIN fundCloseStatus fes ON fd.fundClosedStatus = fes.id
                LEFT JOIN fundCapitalSource fcs ON fd.capitalSource = fcs.id 
                WHERE fd.dbtype='PE'  and (fd.fundDate between "."'".$from_date."'"." and "."'".$to_date."'".") $investor_search order by fd.fundDate desc".$dataLimit;
        }
    }
  
$results = mysql_query($sql);

//  echo $sql  ;
//  exit();


if($categoryType == "DE"){

    if($datatype==1 && $dealType==1){
        
        if($dealCategory == 'PE' || $dealCategory == 'VC' || $dealCategory == 'SOCIAL' || $dealCategory == 'CLEANTECH' || $dealCategory == 'INFRASTRUCTURE'){
            
            if(mysql_num_rows($results) > 0){
                $str = '<table>
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Details</th>
                                        
                                    </tr>
                                </thead>
                                <tbody>';
           
                while($myrow = mysql_fetch_array($results)) {

                    $res1 = array();
                    $data_inner = array();
                    // $dealsql = "SELECT pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, pec.industry, i.industry, pec.sector_business,pe.Total_Debt,pe.Cash_Equ,
                    //     amount,Amount_INR, round, s.Stage, stakepercentage, DATE_FORMAT( dates, '%M-%Y' ) as dt, pec.website, pec.city, pec.region,pe.PEId,comment,MoreInfor,hideamount,
                    //     hidestake, pe.InvestorType, its.InvestorTypeName,pe.StageId,pe.Link,pec.uploadfilename,pe.source,pe.Valuation,pe.FinLink,pec.RegionId, pe.AggHide, 
                    //     pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple,pe.listing_status,Exit_Status,pe.SPV,pe.Revenue,pe.EBITDA,pe.PAT,
                    //     pe.Company_Valuation_pre,pe.Revenue_Multiple_pre,pe.EBITDA_Multiple_pre,pe.PAT_Multiple_pre,
                    //     pe.Company_Valuation_EV,pe.Revenue_Multiple_EV,pe.EBITDA_Multiple_EV,pe.PAT_Multiple_EV,pe.financial_year
                    //     FROM peinvestments AS pe, industry AS i, pecompanies AS pec, investortype as its,stage as s WHERE pec.industry = i.industryid AND 
                    //     pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15 and pe.PEId = ".$data_res['PEId']." and s.StageId=pe.StageId and its.InvestorType=pe.InvestorType ";
                    //      $companyrs1 = mysql_query($dealsql);
                    //      $myrow1 = mysql_fetch_array($companyrs1,MYSQL_BOTH);

                        //if ($companyrs = mysql_query($sql))
                        //{  

                            //if($myrow = mysql_fetch_array($companyrs,MYSQL_BOTH))
                            //{
                                 $str .= '<tr>
                           
                            <td>'.$myrow["companyname"].'</td>
                            <td><span class="showinfo-link info-link">Show details</span></td>
                        </tr>';
                         $str .= '<tr class="infoTR financialRow pecompanydetails" style="display: none;">
                            <td colspan="6" class="no-pd">
                                <div class="fin-wpr">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#deal_info' . $myrow["PEId"] . '">Deal Info</a></li>
                                        <li><a data-toggle="tab" href="#valuation_info' .  $myrow["PEId"]  . '">Valuation Info</a></li>
                                        <li><a data-toggle="tab" href="#financial_info' . $myrow["PEId"] . '">Financials </a></li>
                                        <li><a data-toggle="tab" href="#investor_info' .  $myrow["PEId"] . '">Investor Info</a></li>
                                        <li><a data-toggle="tab" href="#company_info' .  $myrow["PEId"] . '">Company Info</a></li>
                                        <li><a data-toggle="tab" href="#more_info' .  $myrow["PEId"] . '">More Info</a></li>
                                    </ul>';
                                     $str .='<div class="tab-content tbl-cnt">
                                        <div id="deal_info' .  $myrow["PEId"] . '" class="tab-pane fade active in">';
                                    $str .= '<ul class="fix-ul">
                                                <li><span>Amount ($ M)</span></li>
                                                <li><span>Amount (₹ Cr)</span></li>
                                                <li><span>Exit Status</span></li>
                                                <li><span>Date</span></li>
                                                <li><span>BV Per Share</span></li>
                                                <li><span>Stake</span></li>
                                                <li><span>Stage</span></li>
                                                <li><span>Round</span></li>
                                                <li><span>Price Per Share</span></li>
                                                <li><span>Price To Book</span></li>
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll">';
                                $data_inner['CompanyName'] = $myrow["companyname"];
                                if($myrow["hideamount"] == 1)
                                {
                                        $res1['amount'] = "--";
                                }
                                else
                                {
                                        $res1['amount'] = $myrow["amount"];
                                }
                                $res1['Amount_INR']=$myrow['Amount_INR'];
                                // $exitstatusSql = "select id,status from exit_status where id=".$myrow["Exit_Status"];
                                // if ($exitstatusrs = mysql_query($exitstatusSql))
                                // {
                                //   $exitstatus_cnt = mysql_num_rows($exitstatusrs);
                                // }
                                // if($exitstatus_cnt > 0)
                                // {
                                //         While($Exit_myrow = mysql_fetch_array($exitstatusrs, MYSQL_BOTH))
                                //         {
                                //                 $exitstatusis = $Exit_myrow[1];
                                //         }
                                //         $res1['Exit Status'] = $exitstatusis;
                                // }
                                $res1['Exit Status'] = $myrow["ExitStatusName"];
                                $res1['date'] = $myrow["dt"];
                                $res1['BV Per Share']=$myrow["book_value_per_share"];
                                $res1['Stake']=$myrow["stakepercentage"];
                                $res1['stage'] = $myrow["Stage"];
                                $res1['round'] = $myrow["round"];
                                $res1['Price Per Share']=$myrow["price_per_share"];
                                $res1['Price To Book']=$myrow["price_to_book"];
                                 $str .= '<ul>            <li><span>' . $res1['amount']. '</span></li>
                                                        <li><span>' . $res1['Amount_INR']. '</span></li>
                                                        <li><span>' . $res1['Exit Status'] . '</span></li>
                                                        <li><span>' . $res1['date']  . '</span></li>
                                                        <li><span>' . $res1['BV Per Share'] . '</span></li>
                                                        <li><span>' . $res1['Stake'] . '</span></li>
                                                        <li><span>' . $res1['stage'] . '</span></li>
                                                        <li><span>' . $res1['round'] . '</span></li>
                                                        <li><span>' . $res1['Price Per Share'] . '</span></li>
                                                        <li><span>' . $res1['Price To Book'] . '</span></li>
                                                       
                                                    </ul>';
                                
                                 $str .= '</div> </div>';
                                //print_r($res1);

                            //}
                             $data_inner['Deal_Info'][] = $res1;
                        //}
                        $str .= '               </div>
                                        <div id="investor_info' . $myrow["PEId"] . '" class="tab-pane fade">';
                        // $res2 = array();
                        // $investorSql = "select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
                        // peinvestors as inv where peinv.PEId = ".$data_res['PEId']." and inv.InvestorId=peinv.InvestorId";
                        // $investors='';
                        $str .= '<ul class="fix-ul">
                                                <li><span>Investor</span></li>
                                                <li><span>Investor Type</span></li>
                                               
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll">';

                        $res2 = array();
                        // $investorSql = "select peinv.PEId,peinv.InvestorId,inv.Investor from peinvestments_investors as peinv,
                        // peinvestors as inv where peinv.PEId = ".$data_res['PEId']." and inv.InvestorId=peinv.InvestorId";
                        // $investors='';
                        // if ($getinvestorrs = mysql_query($investorSql))
                        // {
                        //    While($myInvrow = mysql_fetch_array($getinvestorrs, MYSQL_BOTH))
                        //    {

                        //        $investors .= $myInvrow["Investor"].',';
                        //    }
                        //    $res2['Investor'] = $investors;

                        // }
                        $res2['Investor'] = $myrow["Investors"];
                        $res2['InvestorType'] = $myrow["InvestorTypeName"];

                        
                        $str .= '<ul>
                                                        <li class="moreinfodetails"><span>' . $res2['Investor']. '</span></li>
                                                        <li class="moreinfodetails"><span>' . $res2['InvestorType']. '</span></li>
                                                        
                                                       
                                                    </ul>';
                                
                                 $str .= '</div> </div> </div>';

                        $res3 = array();
                        
                         $str.='<div id="financial_info' . $myrow["PEId"] . '" class="tab-pane fade">';
                      


                       



                         $str .='<ul class="fix-ul">
                                                <li><span>Financial Year</span></li>
                                                <li><span>Revenue</span></li>
                                                <li><span>EBITDA</span></li>
                                                <li><span>PAT</span></li>
                                                <li><span>Total Debt</span></li>
                                                <li><span>Cash & Cash Equ.</span></li>
                                                
                                            </ul>';
                                           $str .= '<div class="tab-cont-sec">
                                                <div class="tab-scroll">
                                                <ul>
                                                        <li><span>' .$myrow['financial_year']. '</span></li>
                                                        <li><span>' .$myrow['Revenue']. '</span></li>
                                                        <li><span>' .$myrow['EBITDA']. '</span></li>
                                                        <li><span>' .$myrow['PAT']. '</span></li>
                                                        <li><span>' .$myrow['Total_Debt']. '</span></li>
                                                        <li><span>' .$myrow[' Cash_Equ']. '</span></li>
                                                        
                                                       
                                                    </ul>';
                                                    $str .='</div> </div> </div>';
                                                        $str.=' <div id="valuation_info' . $myrow["PEId"] . '" class="tab-pane fade">';

                       
                        $va_info = array();$pre_money = array();
                        $va_info1 = array();
                        $va_info2 = array();
                         if($myrow["Company_Valuation_pre"] >= 0){
                             $va_info['Company_Valuation'] = $myrow["Company_Valuation_pre"];
                         }
                         else{
                             $va_info['Company_Valuation'] = 0.00;
                         }

                         if($myrow["Revenue_Multiple_pre"]  >= 0){
                             $va_info['Revenue_Multiple'] = $myrow["Revenue_Multiple_pre"];
                         }
                         else{
                             $va_info['Revenue_Multiple'] = 0.00;
                         }

                         if($myrow["EBITDA_Multiple_pre"]  >= 0){
                             $va_info['EBITDA_Multiple'] = $myrow["EBITDA_Multiple_pre"];
                         }
                         else{
                             $va_info['EBITDA_Multiple'] = 0.00;
                         }

                         if($myrow["PAT_Multiple_pre"]  >= 0){
                             $va_info['PAT_Multiple'] = $myrow["PAT_Multiple_pre"];
                         }
                         else{
                             $va_info['PAT_Multiple'] = 0.00;
                         }
                     
                         


                         if($myrow["Company_Valuation"] >= 0){
                             $va_info1['Company_Valuation'] = $myrow["Company_Valuation"];
                         }
                         else{
                             $va_info1['Company_Valuation'] = 0.00;
                         }

                         if($myrow["Revenue_Multiple"] >= 0){
                             $va_info1['Revenue_Multiple'] = $myrow["Revenue_Multiple"];
                         }
                         else{
                             $va_info1['Revenue_Multiple'] = 0.00;
                         }

                         if($myrow["EBITDA_Multiple"] >= 0){
                             $va_info1['EBITDA_Multiple'] = $myrow["EBITDA_Multiple"];
                         }
                         else{
                             $va_info1['EBITDA_Multiple'] = 0.00;
                         }

                         if($myrow["PAT_Multiple"] >= 0){
                             $va_info1['PAT_Multiple'] = $myrow["PAT_Multiple"];
                         }
                         else{
                             $va_info1['PAT_Multiple'] = 0.00;
                         }




                         if($myrow["Company_Valuation_EV"] >= 0){
                             $va_info2['Company_Valuation'] = $myrow["Company_Valuation_EV"];
                         }
                         else{
                             $va_info2['Company_Valuation'] = 0.00;
                         }

                         if($myrow["Company_Valuation_EV"] >= 0){
                             $va_info2['Revenue_Multiple'] = $myrow["Company_Valuation_EV"];
                         }
                         else{
                             $va_info2['Revenue_Multiple'] = 0.00;
                         }

                         if($myrow["EBITDA_Multiple_EV"] >= 0){
                             $va_info2['EBITDA_Multiple'] = $myrow["EBITDA_Multiple_EV"];
                         }
                         else{
                             $va_info2['EBITDA_Multiple'] = 0.00;
                         }

                         if($myrow["PAT_Multiple_EV"] >= 0){
                             $va_info2['PAT_Multiple'] = $myrow["PAT_Multiple_EV"];
                         }
                         else{
                             $va_info2['PAT_Multiple'] = 0.00;
                         }
                         $target = array();
                         if(count( $va_info) > 0){
                            $data_inner_1['Pre Money Valuation']=  $va_info;
                        } else{
                            $data_inner_1['Pre Money Valuation']  = '';
                        }
                       // $data_inner['Valuation Info'][]=$data_inner_1;

                        if(count( $va_info1) > 0){
                            $data_inner_1['Post Money Valuation'] =  $va_info1;
                        } else{
                            $data_inner_1['Post Money Valuation']  = '';
                        }
                       // $data_inner['Valuation Info'][]=$data_inner_2;

                        if(count( $va_info2) > 0){
                            $data_inner_1['EV'] =  $va_info2;
                        } else{
                            $data_inner_1['EV']  = '';
                        }
                        $data_inner_1['More info']  = $myrow['Valuation'];
                        $data_inner['Valuation Info'][]=$data_inner_1;
                         $res6 = array();
                        $uploadname = $myrow["uploadfilename"];
                        $file = "https://www.ventureintelligence.com/uploadmamafiles/" . $uploadname;

                      $res6['Financial Year'] = $myrow["financial_year"];

                        

                        if($myrow["Revenue"] > 0 && $myrow["Revenue"] != ''){

                            $res6['Revenue'] = $myrow["Revenue"];
                        }else{
                            $res6['Revenue'] = 0;
                        }

                        if($myrow["EBITDA"] > 0 && $myrow["EBITDA"] != ''){

                            $res6['EBITDA'] = $myrow["EBITDA"];
                        }else{
                            $res6['EBITDA'] = 0;
                        }

                        if($myrow["PAT"] > 0 && $myrow["PAT"] != ''){

                            $res6['PAT'] = $myrow["PAT"];
                        }else{
                            $res6['PAT'] = 0;
                        }
                        if($myrow["Total_Debt"] > 0 && $myrow["Total_Debt"] != ''){

                            $res6['Total_Debt'] = $myrow["Total_Debt"];
                        }else{
                            $res6['Total_Debt'] = 0;
                        }
                        if($myrow["Cash_Equ"] > 0 && $myrow["Cash_Equ"] != ''){

                            $res6['Cash_Equ'] = $myrow["Cash_Equ"];
                        }else{
                            $res6['Cash_Equ'] = 0;
                        }

                        
                        $data_inner['Financials'][] = $res6;
                        $data_inner['Investor Info'][] = $res2;

                         $str .= '<ul class="fix-ul">
                                                <li class="empty-tab"><span></span></li>
                                                <li><span>Valuation</span></li>
                                                <li><span>Revenue Multiple</span></li>
                                                <li><span>EBITDA Multiple</span></li>
                                                <li><span>PAT Multiple</span></li>
                                                <li><span>More Info</span></li>
                                                
                                               
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll valuation-tab">
                                                 <ul>
                                                        <li><span>Pre Money</span></li>
                                                        <li ><span>' . $myrow['Company_Valuation_pre'] . '</span></li>
                                                        <li><span>' . $myrow['Revenue_Multiple_pre']. '</span></li>
                                                        <li><span>' . $myrow['EBITDA_Multiple_pre'] . '</span></li>
                                                        <li><span>' . $myrow['PAT_Multiple_pre']. '</span></li>
                                                 </ul>
                                                 <ul>
                                                        <li><span>Post Money</span></li>
                                                        <li ><span>' . $myrow['Company_Valuation'] . '</span></li>
                                                        <li><span>' . $myrow['Revenue_Multiple']. '</span></li>
                                                        <li><span>' . $myrow['EBITDA_Multiple'] . '</span></li>
                                                        <li><span>' . $myrow['PAT_Multiple']. '</span></li>
                                                 </ul>
                                                 <ul>
                                                        <li><span>EV</span></li>
                                                        <li ><span>' . $myrow['Company_Valuation_EV'] . '</span></li>
                                                        <li><span>' . $myrow['Revenue_Multiple_EV']. '</span></li>
                                                        <li><span>' . $myrow['EBITDA_Multiple_EV'] . '</span></li>
                                                        <li><span>' . $myrow['PAT_Multiple_EV']. '</span></li>
                                                 </ul>
                                                 <span class="more-info-val">' . $myrow['Valuation']. '</span>';

                                                  $str .= '</div> </div> </div>';

                       

                        $res4 =  array();
                        if($myrow["companyname"] != ''){

                            $res4['companyname'] = $myrow["companyname"];
                        }else{
                            $res4['companyname'] = '';
                        }
                         if($myrow["industry"] != "") {

                            $res4['industry'] = $myrow["industry"]; 
                        }else{

                            $res4['industry'] = ""; 
                        }

                        if($myrow["listing_status"] == "L"){

                           $res4['companyType'] = "Listed";
                        }
                        elseif($myrow["listing_status"] == "U"){

                            $res4['companyType'] = "Unlisted"; 
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

                            //$res4['region'] = return_insert_get_RegionIdName($regionid);  
                            $res4['region'] = $myrow["RegionName"];
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
                        $str.=' <div id="company_info' . $myrow["PEId"] . '" class="tab-pane fade">';
                                $str .= '<ul class="fix-ul">
                                                <li><span>Company</span></li>
                                                <li><span>Industry</span></li>
                                                <li><span>Sector</span></li>
                                                <li><span>Type</span></li>
                                                <li><span>City</span></li>
                                                <li><span>Region</span></li>
                                                <li><span>Website</span></li>
                                                <li><span>News Link</span></li>
                                                
                                               
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll">
                                                <ul>
                                                        <li class="moreinfodetails"><span>' . $res4['companyname'] . '</span></li>
                                                        <li class="moreinfodetails"><span>' . $res4['industry']. '</span></li>
                                                        <li class="moreinfodetails"><span>' . $res4['sector_business'] . '</span></li>
                                                        <li class="moreinfodetails"><span>' . $res4['companyType']. '</span></li>
                                                        <li class="moreinfodetails"><span>' . $res4['city'] . '</span></li>
                                                        <li class="moreinfodetails"><span>' . $res4['region']. '</span></li>
                                                        <li class="moreinfodetails"><span>' . $res4['website'] . '</span></li>
                                                        <li class="moreinfodetails"><span>' . $res4['Link']. '</span></li>
                                                        
                                                 </ul>';
                                                  $str .= '</div> </div> </div>';
                                                $str .= '  <div id="more_info' . $myrow["PEId"] . '" class="tab-pane fade">';
                                $str .= '<ul class="fix-ul">
                                                <li><span>Moreinfo</span></li>
                                            </ul>
                                            <div class="tab-cont-sec">
                                                <div class="tab-scroll">
                                                <ul>
                                                        <li class="moreinfodetails"><span >' . $res5['Moreinfo'] . '</span></li>
                                                        
                                                        
                                                 </ul>';
                                                  $str .= '</div> </div> </div>';
                                                 

                        //------------------------------------------------------ Company Profile starts----------------------------------------------------------
                       /* $sql = "SELECT pe.FinLink, pec.angelco_compID, pec.uploadfilename, pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, 
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

                          //  $data_inner['Company Profile'][] = $comres;
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

                               // $data_inner['Company Profile']['Top Management'] = $topmanagement;
                            }else{

                              //  $data_inner['Company Profile']['Top Management'] = '';
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

                              //  $data_inner['Company Profile']['Investor Board Member'] = $boardmember;
                             }else{
                               //  $data_inner['Company Profile']['Investor Board Member'] = '';
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

                             //   $data_inner['Investments']['PE/VC investors'] = $investors;
                             }else{
                             //    $data_inner['Investments']['PE/VC investors'] = '';
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

                             //   $data_inner['Investments']['Incubators'] = $incubators;
                             }else{
                                //$data_inner['Investments']['incubators'] = '';
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

                             //   $data_inner['Investments']['Incubators'] = $maincubators;
                             }else{
                               //  $data_inner['Investments']['incubators'] = '';
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

                             //   $data_inner['Investments']['Angel investors'] = $angelinvestors;
                             }else{
                             //    $data_inner['Investments']['Angel investors'] = '';
                             }
                        } */
                        
                        $data['Deal_Details'][] = $data_inner;
                }   
            } else {
                
                $res1= array();
                    $str = '<br><br><p>No Data Found</p>';
                            $data['Deal_Details'][] = $res1;  
               
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

                                  //  $data_inner['Company Profile']['Top Management'] = $topmanagement;
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
                
            } else {
                
                $res1= array();
                    $str = '<br><br><p>No Data Found</p>';
                            $data['Deal_Details'][] = $res1;  
               
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
                        $file = "https://www.ventureintelligence.com/uploadmamafiles/" . $uploadname;

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
            
            
        } else {
                
            $res1= array();
                $str = '<br><br><p>No Data Found</p>';
                        $data['Deal_Details'][] = $res1;  
           
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
                        $res6['file'] = 'www.ventureintelligence.com/uploadmamafiles/' . $uploadname;
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
                            
                            $res5['File'] = 'www.ventureintelligence.com/uploadmamafiles/'.$dealrow["uploadfilename"];
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
} elseif ( $categoryType == "DR") {
    
    if($datatype==1){
        if($dirCategoryType == "company" || $dirCategoryType == "investor"){

            if($dealCategory == 'PE' || $dealCategory == 'VC' || $dealCategory == 'SOCIAL' || $dealCategory == 'CLEANTECH' || $dealCategory == 'INFRASTRUCTURE' || $dealCategory == 'ANGEL' ||
            $dealCategory == 'PEMA' || $dealCategory == 'PEPM' || $dealCategory == 'PEIPO' || $dealCategory == 'VCMA' || $dealCategory == 'VCPM' || $dealCategory == 'VCIPO') 
            { 
               
                $str = '<table>
                                    <thead>
                                        <tr>';
                                        if($dirCategoryType == "company"){
                                            $str .= '<th>Company Name</th>';
                                        } else if($dirCategoryType == "investor"){
                                            $str .= '<th>Investor Name</th>';
                                        }
                                            $str .= '<th>Details</th>
                                            
                                        </tr>
                                    </thead>
                            <tbody>';

                    if(mysql_num_rows($results) > 0){
                        $res1 = array();
                        $data_inner = array();
                        while($myrow = mysql_fetch_array($results)) { 
                            
                            $str .= '<tr class="companyList">';
                            if($dirCategoryType == "company"){
                                $str .= '<td>'.$myrow["companyname"].'</td>';
                            } else if($dirCategoryType == "investor"){
                                $str .= '<td>'.$myrow["Investor"].'</td>';
                            }
                            $str .= '<td><span class="showinfo-link info-link">Show details</span></td>
                                    </tr>';
                            $str .= '<tr class="infoTR financialRow pecompanydetails" style="display: none;">
                                        <td colspan="6" class="no-pd">
                                        <div class="fin-wpr">
                                            <ul class="nav nav-tabs">';
                                            if($dirCategoryType == "company"){
                                                $str .= '<li class="active"><a data-toggle="tab" href="#company_info' .  $myrow["InvestorId"] . '">Company Profile</a></li>';
                                            } else if($dirCategoryType == "investor"){
                                                $str .= '<li class="active"><a data-toggle="tab" href="#company_info' .  $myrow["InvestorId"] . '">Investor Profile</a></li>';
                                                $str .= '<li><a data-toggle="tab" href="#more_info' .  $myrow["InvestorId"] . '">More Info</a></li>';
                                            }
                            $str .='</ul>';
                            $str .='<div class="tab-content tbl-cnt">
                                        <div id="company_info' .  $myrow["InvestorId"] . '" class="tab-pane fade active in">';

                            $str .= '<ul class="fix-ul">';
                            if($dirCategoryType == "company"){
                                $str .= '<li><span>Company Name</span></li>';
                            } else if($dirCategoryType == "investor"){
                                $str .= '<li><span>Investor Name</span></li>';
                            }
                                                    
                            $str .= '    <li><span>Address</span></li>
                                                    <li><span>City</span></li>
                                                    <li><span>Country</span></li>
                                                    <li><span>Zip</span></li>
                                                    <li><span>Telephone</span></li>';
                                                    if($dirCategoryType == "investor"){
                                                        $str .= '<li><span>Management</span></li>';
                                                    }
                                                    $str .= '<li><span>Email</span></li>
                                                    <li><span>In India Since</span></li>
                                                    <li><span>Website</span></li>
                                                    
                                                </ul>
                                                <div class="tab-cont-sec">
                                                    <div class="tab-scroll">
                                                    <ul>';
                                                            if($dirCategoryType == "company"){
                                                                $str .= '<li class="moreinfodetails"><span>' . $myrow['companyname'] . '</span></li>';
                                                            } else if($dirCategoryType == "investor"){
                                                                $str .= '<li class="moreinfodetails"><span>' . $myrow['Investor'] . '</span></li>';
                                                            }
                                                            $str .= '<li class="moreinfodetails"><span>' . $myrow['Address1'].' '. $myrow['Address2']. '</span></li>';
                                                            if($dirCategoryType == "company"){
                                                                $str .= '<li class="moreinfodetails"><span>' . $myrow['city'] . '</span></li>';
                                                            } else if($dirCategoryType == "investor"){
                                                                $str .= '<li class="moreinfodetails"><span>' . $myrow['City'] . '</span></li>';
                                                            }
                                                            $str .= '<li class="moreinfodetails"><span>' . $myrow['Countryname']. '</span></li>
                                                            <li class="moreinfodetails"><span>' . $myrow['Zip'] . '</span></li>
                                                            <li class="moreinfodetails"><span>' . $myrow['Telephone']. '</span></li>';
                                                            
                                                            $res1['Address']    =  $myrow['Address1'] .' '.$myrow['Address2'];
                                                            
                                                            if($dirCategoryType == "company"){
                                                                $res1['City']        =  $myrow['city'] ;
                                                            } else if($dirCategoryType == "investor"){
                                                                $res1['City']        =  $myrow['City'] ;
                                                            }
                                                            $res1['Country'] =  $myrow['Countryname'] ;
                                                            $res1['Zip']       =    $myrow['Zip'] ;
                                                            $res1['Telephone'] =    $myrow['Telephone'] ;

                            $onMgmtSql = "select pec.InvestorId,mgmt.InvestorId,mgmt.ExecutiveId,
                                        exe.ExecutiveName,exe.Designation,exe.Company from
                                        peinvestors as pec,executives as exe,peinvestors_management as mgmt
                                        where pec.InvestorId=".$myrow['InvestorId']." and mgmt.InvestorId=pec.InvestorId and exe.ExecutiveId=mgmt.ExecutiveId";
                        
                            

                            $rsMgmt = mysql_query($onMgmtSql);
                            While ($mymgmtrow = mysql_fetch_array($rsMgmt, MYSQL_BOTH)) {
                                $designation = $mymgmtrow["Designation"];
                                if ($mymgmtrow["Designation"] == "")
                                    $designation = "";
                                else
                                    $designation = $mymgmtrow["Designation"];
                                $str .= '<li class="moreinfodetails"><span>' . $mymgmtrow["ExecutiveName"]. ' ( '.$designation.' )</span></li>';
                                $res1['Management'] = $mymgmtrow["ExecutiveName"]. ' ( '.$designation.' )';
                            }
                            

                            $str .= '<li class="moreinfodetails"><span>'    . $myrow['Email'] . '</span></li>
                                        <li class="moreinfodetails"><span>' . $myrow['yearfounded']. '</span></li>
                                        <li class="moreinfodetails"><span>' . $myrow['website']. '</span></li>
                                    </ul>';
                            $str .= '</div> </div> </div>';

                            $stageSql = "select distinct s.Stage,pe.StageId,peinv_inv.InvestorId
                                        from peinvestments_investors as peinv_inv,peinvestors as inv,peinvestments as pe,stage as s
                                        where peinv_inv.InvestorId=".$myrow['InvestorId']." and inv.InvestorId=peinv_inv.InvestorId
                                        and pe.PEId=peinv_inv.PEId and s.StageId=pe.StageId order by Stage ";
                            $strStage = ""; $strIndustry = "";
                            $rsStage = mysql_query($stageSql);
                            
                            While ($myStageRow = mysql_fetch_array($rsStage, MYSQL_BOTH)) {
                                    $strStage = $strStage . ", " . $myStageRow["Stage"];
                                }
                            $strStage = substr_replace($strStage, '', 0, 1);
                            $preferred_stage = ltrim($strStage);
                            
                            $myrow['preferredStage'] = $preferred_stage;


                            $indSql = "select DISTINCT i.industry as ind, c.industry, peinv_inv.InvestorId
                                        FROM peinvestments_investors AS peinv_inv, peinvestors AS inv, pecompanies AS c, peinvestments AS peinv, industry AS i
                                        WHERE peinv_inv.InvestorId=".$myrow['InvestorId']." 
                                        AND inv.InvestorId = peinv_inv.InvestorId
                                        AND c.PECompanyId = peinv.PECompanyId
                                        AND peinv.PEId = peinv_inv.PEId and i.industryid!=15  and peinv.Deleted=0
                                        AND i.industryid = c.industry and c.industry!=15 order by i.industry";
                                        
                            $rsInd = mysql_query($indSql);
                                While ($myIndrow = mysql_fetch_array($rsInd, MYSQL_BOTH)) {
                                    $strIndustry = $strIndustry . ", " . $myIndrow["ind"];
                                }
                                $strIndustry = substr_replace($strIndustry, '', 0, 1);
                            
                            $myrow['strIndustry'] = $strIndustry;

                            $getinvestorAmount = "select SUM(peinvestments_investors.Amount_M) as total_amount FROM peinvestments 
                                                    JOIN peinvestments_investors ON peinvestments_investors.PEId = peinvestments.PEId 
                                                    JOIN pecompanies ON pecompanies.PECompanyId = peinvestments.PECompanyId 
                                                    where peinvestments_investors.InvestorId = ".$myrow['InvestorId']." and peinvestments_investors.exclude_dp = 0 AND peinvestments.Deleted=0 AND 
                                                    peinvestments.AggHide=0 and peinvestments.SPV = 0 and pecompanies.industry !=15 AND 
                                                    peinvestments.PEId NOT IN (SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 )";

                            $investor_amount='';
                            $investoramountrs = mysql_query($getinvestorAmount);
                            $investorrowrow = mysql_fetch_row($investoramountrs, MYSQL_BOTH);
                            $investor_amount = $investorrowrow['total_amount'];

                            
                            $focuscapsourcesql = "select focuscapsource from focus_capitalsource where focuscapsourceid=".$myrow['focuscapsourceid'];
                            $focuscapsourcename = "";
                            if ($rsfocuscapsource = mysql_query($focuscapsourcesql)) {
                                While ($rsfocuscapsourcerow = mysql_fetch_array($rsfocuscapsource, MYSQL_BOTH)) {
                                    $focuscapsourcename = $rsfocuscapsourcerow["focuscapsource"];
                                }
                            }
                            if ($myrow['Assets_mgmt'] != '') {
                                    $Assets_mgmt = (int) preg_replace("/[^0-9\.]/", '', $myrow['Assets_mgmt']);
                                } else {
                                    $Assets_mgmt = 0;
                                    $investor_amount = '';
                                    
                            }
                            
                            if($myrow['dry_hide'] == 0){
                                $drypowder = $Assets_mgmt - $investor_amount;
                            } else {
                                $drypowder = "";
                            }
                            
                            $str .= '  <div id="more_info' . $myrow["InvestorId"] . '" class="tab-pane fade">';
                            $str .= '<ul class="fix-ul">
                                                            <li><span>Firm Type</span></li>
                                                            <li class=""><span >Focus & Capital Source</span></li>
                                                            <li class=""><span >Stage Of Funding</span></li>
                                                            <li class=""><span >No Of Funds</span></li>
                                                            <li class=""><span >Limited partners</span></li>
                                                            <li class=""><span >Industry (Existing Investments)</span></li>
                                                            <li class=""><span >Assets Under Management (US$M)</span></li>
                                                            <li class=""><span >Already Invested (US$ Million)</span></li>
                                                            <li class=""><span >Dry Powder (US$ Million)</span></li>
                                                            <li class=""><span >Other Location</span></li>
                                                            <li class=""><span >Descrption</span></li>
                                                </ul>
                                                <div class="tab-cont-sec">
                                                    <div class="tab-scroll">
                                                    <ul>
                                                        <li class="moreinfodetails"><span >' . $myrow['FirmType'] . '</span></li>
                                                        <li class="moreinfodetails"><span >' . $focuscapsourcename . '</span></li>
                                                        <li class="moreinfodetails"><span >' . $myrow['preferredStage'] . '</span></li>
                                                        <li class="moreinfodetails"><span >' . $myrow['NoFunds'] . '</span></li>
                                                        <li class="moreinfodetails"><span >' . $myrow['LimitedPartners'] . '</span></li>
                                                        <li class="moreinfodetails"><span >' . $myrow['strIndustry'] . '</span></li>

                                                        <li class="moreinfodetails"><span >' . $myrow['Assets_mgmt'] . '</span></li>
                                                        <li class="moreinfodetails"><span >' . $investor_amount . '</span></li>
                                                        <li class="moreinfodetails"><span >' . $drypowder . '</span></li>
                                                        <li class="moreinfodetails"><span >' . $myrow['OtherLocation'] . '</span></li>
                                                        <li class="moreinfodetails"><span >' . $myrow['Description'] . '</span></li>
                                                    </ul>';
                                                    
                            $str .= '</div> </div> </div>';
                            $str .= '</div> </div> </td> </tr>';
                            $data_inner_1=array();
                            //$res1['InvestorName']    =  $myrow['Investor'];
                            
                            
                            $res1['Email'] = trim($myrow['Email']);
                            $res1['Since'] =    $myrow['yearfounded'] ;
                            $res1['Website'] =    $myrow['website'] ;
                            if($dirCategoryType == "company"){
                                $data_inner_1['Company Name']=$myrow['companyname'];
                            } else if($dirCategoryType == "investor"){
                                $data_inner_1['Investor Name']=$myrow['Investor'];
                            }
                            
                            $data_inner_1['Investor']= $res1;
                            
                            if($dirCategoryType == "investor"){
                                $res2=array();
                                $res2['FirmType']    =  $myrow['FirmType'];
                                $res2['Focus & Capital Source']    =  $focuscapsourcename;
                                $res2['Stage Of Funding']    =  $myrow['preferredStage'];
                                $res2['No Of Funds']    =  $myrow['NoFunds'];
                                $res2['Limited Partners']    =  $myrow['LimitedPartners'];
                                $res2['Industry (Existing Investments)']    =  $myrow['strIndustry'];
                                $res2['Assets Under Management']    =  $myrow['Assets_mgmt'];
                                $res2['Already Invested']    =  $investor_amount;
                                $res2['Drypowder']    =  $drypowder;
                                $res2['Other Location']    =  trim($myrow['OtherLocation']);
                                $res2['Description']    =  $myrow['Description'];

                                $data_inner_1['MoreInfo']= $res2;
                            }
                            
                            $data_inner['InvestorInfo'][]=$data_inner_1;
                        }
                        
                    } else {
                
                        $res1= array();
                            $str = '<br><br><p>No Data Found</p>';
                                    $data['Directory'][] = $res1;  
                       
                    }
                } 
            $data['Directory'] = $data_inner;
        } elseif($dirCategoryType == "legalAdvisor" || $dirCategoryType == "transactionAdvisor") {
            if($dealCategory == 'PE' || $dealCategory == 'VC' || $dealCategory == 'SOCIAL' || $dealCategory == 'CLEANTECH' || $dealCategory == 'INFRASTRUCTURE' ||
               $dealCategory == 'PEMA' || $dealCategory == 'PEPM' || $dealCategory == 'VCMA' || $dealCategory == 'VCPM') 
            { 
                
                
                if(mysql_num_rows($results) > 0){

                    $str = '<table>
                                    <thead>
                                        <tr>
                                            <th>Advisor Name</th>
                                            <th>Details</th>
                                            
                                        </tr>
                                    </thead>
                            <tbody>';
                    
                    while($myrow = mysql_fetch_array($results)) {
                        $res1 = array();
                        $data_inner = array();
                        $str .= '<tr class="companyList">
                                    <td>'.$myrow["Cianame"].'</td>
                                    <td><span class="showinfo-link info-link">Show details</span></td>
                                </tr>';
                        $str .= '<tr class="infoTR financialRow pecompanydetails" style="display: none;">
                                <td colspan="6" class="no-pd">
                                <div class="fin-wpr">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#advisor_details' .  $myrow["CIAId"] . '">Advisor Profile</a></li>
                                    </ul>';
                        $str .='<div class="tab-content tbl-cnt">
                                    <div id="advisor_details' .  $myrow["CIAId"] . '" class="tab-pane fade active in">';
                        $str .= '<ul class="fix-ul">
                                    <li><span>Advisor Name</span></li>
                                    <li><span>Advisor Type</span></li>
                                    <li><span>Address</span></li>
                                    <li><span>City</span></li>
                                    <li><span>Country</span></li>
                                    <li><span>Phone Number</span></li>
                                    <li><span>Website</span></li>
                                    <li><span>Contact Person</span></li>
                                    <li><span>Designation</span></li>
                                    <li><span>Email ID</span></li>
                                </ul>';
                        $str .= '<div class="tab-cont-sec">
                                <div class="tab-scroll">
                                <ul>
                                    <li class="moreinfodetails"><span>' . $myrow['Cianame'] . '</span></li>';
                        $res1['Advisor Name']    =  $myrow['Cianame'];
                        if($myrow['AdvisorType'] == "L"){
                            $str .='<li class="moreinfodetails"><span>Legal Advisor</span></li>';
                            $res1['Advisor Type']    =  'Legal Advisor';
                        } else if($myrow['AdvisorType'] == "T"){
                            $str .='<li class="moreinfodetails"><span>Transaction Advisor</span></li>';
                            $res1['Advisor Type']    =  'Transaction Advisor';
                        }
                                    
                        $str .= '<li class="moreinfodetails"><span>' . $myrow['address'] . '</span></li>
                                    <li class="moreinfodetails"><span>' . $myrow['city'] . '</span></li>
                                    <li class="moreinfodetails"><span>' . $myrow['country'] . ' '. $data_res['industry']. '</span></li>
                                    <li class="moreinfodetails"><span>' . $myrow['phoneno'] . '</span></li>
                                    <li class="moreinfodetails"><span>' . $myrow['website'] . '</span></li>
                                    <li class="moreinfodetails"><span>' . $myrow['contactperson'] . '</span></li>
                                    <li class="moreinfodetails"><span>' . $myrow['designation'] . '</span></li>
                                    <li class="moreinfodetails"><span>' . $myrow['email'] . '</span></li>';
                        
                        $res1['Address']    =  $myrow['address'];
                        $res1['City']    =  $myrow['city'];
                        $res1['Country']    =  $myrow['country'];
                        $res1['Phone Number']    =  $myrow['phoneno'];
                        $res1['Website']    =  $myrow['website'];
                        $res1['Contact Person']    =  $myrow['contactperson'];
                        $res1['Designation']    =  $myrow['designation'];
                        $res1['Email'] =  $myrow['email'];

                        $data_inner['Advisor Profile'] = $res1;
                        $data['Directory'][] = $data_inner;            
                    }
                } else {
                
                    $res1= array();
                        $str = '<br><br><p>No Data Found</p>';
                                $data['Directory'][] = $res1;  
                   
                }
            } 
        } else if($dirCategoryType == "fundedComp"){
            if(mysql_num_rows($results) > 0){

                $str = '<table>
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                        <th>Details</th>
                                        
                                    </tr>
                                </thead>
                        <tbody>';
                
                while($myrow = mysql_fetch_array($results)) {
                    $res1 = array();
                    $data_inner = array();
                    $str .= '<tr class="companyList">
                                    <td>'.$myrow["companyname"].'</td>
                                    <td><span class="showinfo-link info-link">Show details</span></td>
                                </tr>';

                    $str .= '<tr class="infoTR financialRow pecompanydetails" style="display: none;">
                                <td colspan="6" class="no-pd">
                                <div class="fin-wpr">
                                    <ul class="nav nav-tabs">
                                        <li class="active"><a data-toggle="tab" href="#company_details' .  $myrow["PECompanyId "] . '">Company Profile</a></li>
                                    </ul>';
                    $str .='<div class="tab-content tbl-cnt">
                                    <div id="company_details' .  $myrow["PECompanyId"] . '" class="tab-pane fade active in">';
                    $str .= '<ul class="fix-ul">
                                    <li><span>Company Name</span></li>
                                    <li><span>Industry</span></li>
                                    <li><span>Sector</span></li>
                                    <li><span>Address</span></li>
                                    <li><span>City</span></li>
                                    <li><span>Country</span></li>
                                    <li><span>Zip</span></li>
                                    <li><span>Telephone</span></li>
                                    <li><span>Email</span></li>
                                    <li><span>Website</span></li>
                                </ul>';
                    $str .= '<div class="tab-cont-sec">
                                <div class="tab-scroll">
                                <ul>
                                    <li class="moreinfodetails"><span>' . $myrow['companyname'] . '</span></li>';
                    $str .= '<li class="moreinfodetails"><span>' . $myrow['industry'] . '</span></li>
                            <li class="moreinfodetails"><span>' . $myrow['sector_business'] . '</span></li>
                            <li class="moreinfodetails"><span>' . $myrow['Address1'] . ' '. $myrow['Address2']. '</span></li>
                            <li class="moreinfodetails"><span>' . $myrow['city'] . '</span></li>
                            <li class="moreinfodetails"><span>' . $myrow['Countryname'] . '</span></li>
                            <li class="moreinfodetails"><span>' . $myrow['Zip'] . '</span></li>
                            <li class="moreinfodetails"><span>' . $myrow['Telephone'] . '</span></li>
                            <li class="moreinfodetails"><span>' . $myrow['Email'] . '</span></li>
                            <li class="moreinfodetails"><span>' . $myrow['website'] . '</span></li>';
                    
                    $res1['Company Name']    =  $myrow['companyname'];
                    $res1['Industry']    =  $myrow['industry'];
                    $res1['Sector']    =  $myrow['sector_business'];
                    $res1['Address']    =  $myrow['Address1'] . ' ' . $myrow['Address2'];
                    $res1['Country']    =  $myrow['Countryname'];
                    $res1['Zip']    =  $myrow['Zip'];
                    $res1['Telephone']    =  $myrow['Telephone'];
                    $res1['Email']    =  $myrow['Email'];
                    $res1['Website'] =  $myrow['website'];

                    $data_inner['Funded Companies'] = $res1;
                    
                    $data['Directory'][] = $data_inner;   
                }
            } else {
                
                $res1= array();
                    $str = '<br><br><p>No Data Found</p>';
                            $data['Directory'][] = $res1;  
               
            }
        } elseif($dirCategoryType == "fundraisingComp"){
            
            
            if(mysql_num_rows($results) > 0){
                
                $str = '<table>
                                <thead>
                                    <tr>
                                        <th>Company Name</th>
                                    </tr>
                                </thead>
                        <tbody>';
                
                while($myrow = mysql_fetch_array($results)) {
                    $res1 = array();
                    $data_inner = array();
                    $str .= '<tr class="companyList">
                                    <td>'.$myrow["company_name"].'</td>
                                </tr>';
                    $res1['Company Name']    =  $myrow['company_name'];
                    $data_inner['Fundraising Companies'] = $res1;
                    
                    $data['Directory'][] = $data_inner;   
                }
            } else {
                
                $res1= array();
                    $str = '<br><br><p>No Data Found</p>';
                            $data['Directory'][] = $res1;  
               
            }
        } elseif($dealCategory == 'INCUBATION'){ 
            // echo $sql;
            // exit();
            $str = '<table>
                        <thead>
                            <tr>';
                            if($dirCategoryType == "incubator")  {
                                $str .='<th>Incubator Name</th>';
                            }elseif($dirCategoryType == "incubatee")  { 
                                $str .='<th>Incubatee Name</th>';
                            }
                                $str .='<th>Details</th>
                            </tr>
                        </thead>
                    <tbody>';
            if(mysql_num_rows($results) > 0){ 
                $res1 = array();
                $data_inner = array();
                while($myrow = mysql_fetch_array($results)) {  
                    $str .= '<tr class="companyList">';
                    if($dirCategoryType == "incubator")  {
                        $str .='<td>'.$myrow["Incubator"].'</td>';
                    }elseif($dirCategoryType == "incubatee")  { 
                        $str .='<td>'.$myrow["companyname"].'</td>';
                    }
                    $str .='<td><span class="showinfo-link info-link">Show details</span></td>
                           </tr>';
                    $str .= '<tr class="infoTR financialRow pecompanydetails" style="display: none;">
                                <td colspan="6" class="no-pd">
                                <div class="fin-wpr">
                                    <ul class="nav nav-tabs">';
                                    if($dirCategoryType == "incubator")  {
                                        $str .='<li class="active"><a data-toggle="tab" href="#company_info' .  $myrow["IncubatorId"] . '">Incubator Profile</a></li>';
                                    }elseif($dirCategoryType == "incubatee")  { 
                                        $str .='<li class="active"><a data-toggle="tab" href="#company_info' .  $myrow["IncubateeId"] . '">Incubatee Profile</a></li>';
                                    }
                            $str .='</ul>';
                        $str .='<div class="tab-content tbl-cnt">';
                                    if($dirCategoryType == "incubator")  {
                                        $str .='<div id="company_info' .  $myrow["IncubatorId"] . '" class="tab-pane fade active in">';
                                    }elseif($dirCategoryType == "incubatee")  { 
                                        $str .='<div id="company_info' .  $myrow["IncubateeId"] . '" class="tab-pane fade active in">';
                                    }
                        $str .= '<ul class="fix-ul">
                                            <li><span>Company Name</span></li>
                                            <li><span>Sector Business</span></li>
                                            <li><span>Address</span></li>';
                                            if($dirCategoryType == "incubator")  {
                                                $str .='<li><span>Management</span></li>';
                                            }
                                            $str .='<li><span>Email</span></li>
                                            <li><span>Telephone</span></li>
                                            <li><span>Fax</span></li>
                                            <li><span>Additional Info</span></li>
                                            <li><span>City</span></li>
                                            <li><span>Country</span></li>
                                            <li><span>Zip</span></li>
                                            <li><span>Website</span></li>
                                        </ul>
                                        <div class="tab-cont-sec">
                                            <div class="tab-scroll">
                                            <ul>';
                                            if($dirCategoryType == "incubator")  {
                                                $str .='<li class="moreinfodetails"><span>' . $myrow['Incubator'] . '</span></li>';
                                            }elseif($dirCategoryType == "incubatee")  { 
                                                $str .='<li class="moreinfodetails"><span>' . $myrow['companyname'] . '</span></li>';
                                            }
                                            $str .='<li class="moreinfodetails"><span>' . $myrow['sector_business'].'</span></li>
                                                    <li class="moreinfodetails"><span>' . $myrow['Address1'].' '. $myrow['Address2']. '</span></li>';
                                                    if($dirCategoryType == "incubator")  {
                                                        $str .='<li class="moreinfodetails"><span>' . $myrow['Management']. '</span></li>';
                                                    }
                                                    $str .='<li class="moreinfodetails"><span>' . $myrow['Email']. '</span></li>
                                                    <li class="moreinfodetails"><span>' . $myrow['Telephone']. '</span></li>
                                                    <li class="moreinfodetails"><span>' . $myrow['Fax']. '</span></li>
                                                    <li class="moreinfodetails"><span>' . $myrow['AdditionalInfor']. '</span></li>';
                                                    if($dirCategoryType == "incubator")  {
                                                        $str .='<li class="moreinfodetails"><span>' . $myrow['City'] . '</span></li>';
                                                    }elseif($dirCategoryType == "incubatee")  { 
                                                        $str .='<li class="moreinfodetails"><span>' . $myrow['AdCity'] . '</span></li>';
                                                    }
                                                    $str .='<li class="moreinfodetails"><span>' . $myrow['Countryname']. '</span></li>
                                                    <li class="moreinfodetails"><span>' . $myrow['Zip'] . '</span></li>
                                                    <li class="moreinfodetails"><span>' . $myrow['website']. '</span></li>';
                                                    

                                        $str .= '</div> </div> </div>';
                                        $str .= '</div> </div> </td> </tr>';

                                        if($dirCategoryType == "incubator")  {
                                            $res1['CompanyName'] =    $myrow['Incubator'];
                                        }elseif($dirCategoryType == "incubatee")  { 
                                            $res1['CompanyName'] =    $myrow['companyname'];
                                        }
                                        $res1['Sector Business'] =    $myrow["sector_business"];
                                        $res1['Address']    =  $myrow['Address1'].' '. $myrow['Address2'];
                                        if($dirCategoryType == "incubator")  { 
                                            $res1['Management'] =    $myrow['Management'] ;
                                        }
                                        $res1['Email'] =    $myrow['Email'] ;
                                        
                                        if($dirCategoryType == "incubator")  {
                                            $res1['City']        =  $myrow['City'] ;
                                        }elseif($dirCategoryType == "incubatee")  { 
                                            $res1['City']        =  $myrow['AdCity'] ;
                                        }
                                        $res1['Country'] =  $myrow['Countryname'] ;
                                        $res1['Zip']       =    $myrow['Zip'] ;
                                        $res1['Telephone'] =    $myrow['Telephone'] ;
                                        $res1['Website'] =    $myrow['website'] ;
  
                                        
                                        $data_inner['IncubationInfo']= $res1;
                                        $data['Directory'][] = $data_inner; 

                }
            } else {
                
                $res1= array();
                    $str = '<br><br><p>No Data Found</p>';
                            $data['Directory'][] = $res1;  
               
            }
          }

        
     }    
            
} else if ($categoryType == "FD") {
    
    if($datatype == 1){
        if(mysql_num_rows($results) > 0){
            $str = '<table>
                        <thead>
                            <tr>
                                <th>Investor Name</th>
                                <th>Details</th>
                             </tr>
                        </thead>
                        <tbody>';
    
            while($data_res = mysql_fetch_array($results)) {
                $res1 = array();
                $data_inner = array();
    
                $str .= '<tr class="companyList">
                            <td>'.$data_res["Investor"].'</td>
                            <td><span class="showinfo-link info-link">Show details</span></td>
                        </tr>';
                $str .= '<tr class="infoTR financialRow pecompanydetails" style="display: none;">
                            <td colspan="6" class="no-pd">
                            <div class="fin-wpr">
                                <ul class="nav nav-tabs">
                                    <li class="active"><a data-toggle="tab" href="#fund_details' .  $data_res["id"] . '">Fund Details</a></li>
                                    <li><a data-toggle="tab" href="#more_info' .  $data_res["id"] . '">More Info</a></li>
                                    <li><a data-toggle="tab" href="#source_info' .  $data_res["id"] . '">Source</a></li>
                                </ul>';
                $str .='<div class="tab-content tbl-cnt">
                            <div id="fund_details' .  $data_res["id"] . '" class="tab-pane fade active in">';
                $str .= '<ul class="fix-ul">
                            <li><span>Investor Name</span></li>
                            <li><span>Fund Name</span></li>
                            <li><span>Fund Manager</span></li>
                            <li><span>Fund Type</span></li>
                            <li><span>Target Size</span></li>
                            <li><span>Amount raised</span></li>
                            <li><span>Fund Status</span></li>
                            <li><span>Capital Source</span></li>
                            <li><span>Date</span></li>
                        </ul>';
                $str .= '<div class="tab-cont-sec">
                        <div class="tab-scroll">
                        <ul>
                            <li class="moreinfodetails"><span>' . $data_res['Investor'] . '</span></li>
                            <li class="moreinfodetails"><span>' . $data_res['fundName'] . '</span></li>
                            <li class="moreinfodetails"><span>' . $data_res['fundManager'] . '</span></li>
                            <li class="moreinfodetails"><span>' . $data_res['stage'] . ' '. $data_res['industry']. '</span></li>
                            <li class="moreinfodetails"><span>' . $data_res['size'] . '</span></li>
                            <li class="moreinfodetails"><span>' . $data_res['amount_raised'] . '</span></li>';
                            
                            $res1['Fund Name'] = $data_res['fundName'];
                            $res1['Fund Manager'] = $data_res['fundManager'];
                            $res1['Fund Type'] = $data_res['stage']. ' ' .$data_res['industry'];
                            $res1['Target Size'] = $data_res['size'];
                            $res1['Amount raised'] = $data_res['amount_raised'];
    
                if($data_res['fundStatus'] == 'Closed') {
                    $str .= '<li class="moreinfodetails"><span>' . $data_res['closeStatus'] . '</span></li>';
                    $res1['Fund Status'] = $data_res['closeStatus'];
                } else {
                    $str .= '<li class="moreinfodetails"><span>' . $data_res['fundStatus'] . '</span></li>';
                    $res1['Fund Status'] = $data_res['closeStatus'];
                }
                $str .= '<li class="moreinfodetails"><span>' . $data_res['source'] . '</span></li>
                            <li class="moreinfodetails"><span>' . $data_res['fundDate'] . '</span></li>
                        </ul>';
                $str .= '</div> </div> </div>';
                
                $res1['Capital Source'] = $data_res['source'];
                $res1['Date'] = $data_res['fundDate'];
                $data_inner['Investor Name'] = $data_res['Investor'];
                $data_inner['Fund Info'] = $res1;
                
    
                $str .= '<div id="more_info' .  $data_res["id"] . '" class="tab-pane fade">';
                $str .= '<ul class="fix-ul">
                            <li><span>More Info</span></li>
                        </ul>';
                $str .= '<div class="tab-cont-sec">
                        <div class="tab-scroll">
                        <ul>
                            <li class="moreinfodetails"><span>' . $data_res['moreInfo'] . '</span></li>
                        </ul>';
                $str .= '</div> </div> </div>';
                $data_inner['More Info'] = $data_res['moreInfo'];
    
                $str .= '<div id="source_info' .  $data_res["id"] . '" class="tab-pane fade">';
                $str .= '<ul class="fix-ul">
                            <li><span>Source</span></li>
                        </ul>';
                $str .= '<div class="tab-cont-sec">
                        <div class="tab-scroll">
                        <ul>
                            <li class="moreinfodetails"><span>' . $data_res['fdsource'] . '</span></li>
                        </ul>';
                $str .= '</div> </div> </div>';
    
    
                $str .= '</div> </div> </td> </tr>';
                $data_inner['Source Info'] = $data_res['fdsource'];
                $data['Fund_Details'][] = $data_inner;
            }
            $str .= '</tbody></table>';
        } else {
                
            $res1= array();
                $str = '<br><br><p>No Data Found</p>';
                        $data['Fund_Details'][] = $res1;  
           
        }
    } else {
        
        if(mysql_num_rows($results) > 0){
            
            $totalAmount = 0;
            $data_inner = array(); 
            while($data_res = mysql_fetch_array($results)) {
                
                $res2 = array();
                $res1 = array();

                $res1['total Deals'] = mysql_num_rows($results);
                $res1['total_companies'] = mysql_num_rows($results);
                $totalAmount=$totalAmount+ $data_res["amount_raised"];
                $res1['total_amount'] = round($totalAmount);
                $data_inner['aggregate_details'] = $res1;

                $res2['Fund Name'] = $data_res['fundName'];
                $res2['Fund Manager'] = $data_res['fundManager'];
                $res2['Fund Type'] = $data_res['stage']. ' ' .$data_res['industry'];
                $res2['Target Size'] = $data_res['size'];
                $res2['Amount raised'] = $data_res['amount_raised'];
    
                if($data_res['fundStatus'] == 'Closed') {
                    $res2['Fund Status'] = $data_res['closeStatus'];
                } else {
                    $res2['Fund Status'] = $data_res['closeStatus'];
                }

                $res2['Capital Source'] = $data_res['source'];
                $res2['Date'] = $data_res['fundDate'];
                $data_inner['Funds'][] = $res2;
                //print_r($data['Funds_Aggregate']);
                

            }
            $data['Funds_Aggregate'][] = $data_inner;
        } else {
                
            $res1= array();
                $str = '<br><br><p>No Data Found</p>';
                        $data['Funds_Aggregate'][] = $res1;  
           
        }
    }
    
    
    // if(count($data_inner) > 0){
    //     $data['Funds_Aggregate'] = $data_inner;
    // }
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

    function utf8ize( $mixed ) {
        if (is_array($mixed)) {
            foreach ($mixed as $key => $value) {
                $mixed[$key] = utf8ize($value);
            }
        } elseif (is_string($mixed)) {
            return mb_convert_encoding($mixed, "UTF-8", "UTF-8");
        }
        return $mixed;
    }

    if(count($data) > 0){
       // $data['Status'] = "Success";
       // $data['Result'] = $resData;
        echo json_encode( array('html'=>utf8ize($str), 'Status' => 'Success', 'Result' => utf8ize( $data ) ) );
        /*$error = json_last_error_msg();
        print_r( $error );*/
        //echo $data;
    }else{
       // $data['Status'] = "Failure";
      //  $data['Result'] = 'No Data Found.';
        echo json_encode( $data );
    }
?>