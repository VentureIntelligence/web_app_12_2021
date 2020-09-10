<?php 

    include( dirname(__FILE__)."/../../etc/conf.php");
    
    $company_type = $_POST['company_type'];
    $financial_year = implode(',',$_POST['financial_year']);
    $revenue_min = intval($_POST['revenue_min']);
    $revenue_min_cr = $revenue_min * 10000000;
    $revenue_max = intval($_POST['revenue_max']);
    $revenue_max_cr = $revenue_max * 10000000;

    // Company Type
    if(count($_POST['financial_year']) != 5){
        if($company_type != '-'){
            $listingstatus = " and ListingStatus = ".$company_type;
        }else{
            $listingstatus = "";
        }
    }else{
        if($company_type != '-'){
            $listingstatus = " and cfs_original.ListingStatus = ".$company_type;
        }else{
            $listingstatus = "";
        }

    }
    // Financial Year
    if(count($_POST['financial_year']) != 5){
        if(count($_POST['financial_year']) != 0 && count($_POST['financial_year']) != 5){
            $FY = " and FY IN ($financial_year)";
        }else{
            $FY = " and FY IN (16, 17, 18, 19, 20)";
        }
    }else{
        if(count($_POST['financial_year']) != 0 && count($_POST['financial_year']) != 5){
            $FY = " and cfs_original.FY IN ($financial_year)";
        }else{
            $FY = " and cfs_original.FY IN (16, 17, 18, 19, 20)";
        }
    }
    // Revenue Validation
    // if(count($_POST['financial_year']) != 5){
    //     if(($revenue_min >= 0 && $revenue_max > $revenue_min)){
    //         if($revenue_min ==0 && $revenue_max == 1000){
    //             $RFY = "";
    //         }else{
    //             if($revenue_max !=0 ){
    //                 $RFY = " and RFY  BETWEEN ".$revenue_min_cr." and ".$revenue_max_cr;
    //             }else{
    //                 $RFY = "";
    //             }
    //         }
            
    //     }else{
    //         $RFY = "";
    //         echo 'please check revenue values';
    //         exit();
    //      }
    // }else{
    //     if(($revenue_min >= 0 && $revenue_max > $revenue_min)){
    //         if($revenue_min ==0 && $revenue_max == 1000){
    //             $RFY = "";
    //         }else{
    //             if($revenue_max !=0 ){
    //                 $RFY = " and cfs_original.RFY  BETWEEN ".$revenue_min_cr." and ".$revenue_max_cr;
    //             }else{
    //                 $RFY = "";
    //             }
    //         }
            
    //     }else{
    //         $RFY = "";
    //         echo 'please check revenue values';
    //         exit();
    //      }
    // }
    // Revenue Validation
    if(count($_POST['financial_year']) != 5){
        if(($revenue_min >= 0 && $revenue_max > $revenue_min) || ($_POST['revenue_min'] == "" || $_POST['revenue_max'] == "") ){
         if(($_POST['revenue_min'] != "" || $_POST['revenue_max']!= "")){
            
            if($_POST['revenue_min'] != "" && $_POST['revenue_max']!= "" ){
                $RFY = " and RFY  BETWEEN ".$revenue_min_cr." and ".$revenue_max_cr;
            }else{
                $max_value = 100000000000000000;
                $min_value = 0;
                if($_POST['revenue_min'] != ''){
                    $RFY = " and RFY  BETWEEN ".$revenue_min_cr." and ".$max_value;
                }else if($_POST['revenue_max']!= ''){
                    $RFY = " and RFY  BETWEEN ".$min_value." and ".$revenue_max_cr;    
                }
            }
         }else{
            $RFY = ""; 
         }
        }else{
            echo 'please check revenue values';
            exit();
        }
    }else{
        if(($revenue_min >= 0 && $revenue_max > $revenue_min) || ($_POST['revenue_min'] == "" || $_POST['revenue_max'] == "") ){
        // if(($_POST['revenue_min'] != "" || $_POST['revenue_max']!= "") && ($revenue_min !=0 && $revenue_max != 1000) ){
            if(($_POST['revenue_min'] != "" || $_POST['revenue_max']!= "")){
            if($_POST['revenue_min'] != "" && $_POST['revenue_max']!= "" ){
                $RFY = " and cfs_original.RFY  BETWEEN ".$revenue_min_cr." and ".$revenue_max_cr;
            }else{
                $max_value = 100000000000000000;
                $min_value = 0;
                if($_POST['revenue_min'] != ''){
                    $RFY = " and cfs_original.RFY  BETWEEN ".$revenue_min_cr." and ".$max_value;
                }else if($_POST['revenue_max']!= ''){
                    $RFY = " and cfs_original.RFY  BETWEEN ".$min_value." and ".$revenue_max_cr;    
                }
            }
         }else{
            $RFY = ""; 
         }
        }else{
            echo 'please check revenue values';
            exit();
        }

    }
    // Query ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~
    if(count($_POST['financial_year']) == 1){
        
        // xbrl_PEBacked
        $sql_xbrl_PEBacked = "select count(DISTINCT company_id) as total from cfs_dashboard_analytics 
                                where is_xbrl = 'XBRL' 
                                $listingstatus
                                $FY
                                $RFY
                                and is_PEBacked = 1";
        $xbrl_PEBacked_count = mysql_query($sql_xbrl_PEBacked);
        $xbrl_PEBacked_total = mysql_fetch_array($xbrl_PEBacked_count);
        $xbrl_PEBacked = $xbrl_PEBacked_total['total'];
        

        // xbrl_nonPEBacked
        $sql_xbrl_nonPEBacked = "select count(DISTINCT company_id) as total from cfs_dashboard_analytics 
                                where is_xbrl = 'XBRL' 
                                $listingstatus
                                $FY
                                $RFY
                                and is_PEBacked = 0";
        $xbrl_nonPEBacked = mysql_query($sql_xbrl_nonPEBacked);
        $xbrl_nonPEBacked_total = mysql_fetch_array($xbrl_nonPEBacked);
        $xbrl_nonPEBacked = $xbrl_nonPEBacked_total['total'];

        // nonxbrl_PEBacked
        $sql_nonxbrl_PEBacked = "select count(DISTINCT company_id) as total from cfs_dashboard_analytics 
                                where is_xbrl = 'NON-XBRL' 
                                $listingstatus
                                $FY
                                $RFY
                                and is_PEBacked = 1";
        $nonxbrl_PEBacked = mysql_query($sql_nonxbrl_PEBacked);
        $nonxbrl_PEBacked_total = mysql_fetch_array($nonxbrl_PEBacked);
        $nonxbrl_PEBacked = $nonxbrl_PEBacked_total['total'];

        // nonxbrl_nonPEBacked
        $sql_nonxbrl_nonPEBacked = "select count(DISTINCT company_id) as total from cfs_dashboard_analytics 
                                where is_xbrl = 'NON-XBRL' 
                                $listingstatus
                                $FY
                                $RFY
                                and is_PEBacked = 0";
        $nonxbrl_nonPEBacked = mysql_query($sql_nonxbrl_nonPEBacked);
        $nonxbrl_nonPEBacked_total = mysql_fetch_array($nonxbrl_nonPEBacked);
        $nonxbrl_nonPEBacked = $nonxbrl_nonPEBacked_total['total'];

        // Industry Selection
        $sql_industries = "select DISTINCT IndustryName as iname,count(DISTINCT company_id) as comcount from cfs_dashboard_analytics 
        where  IndustryName != ''
        $listingstatus
        $FY
        $RFY
        group by IndustryName";
        // exit();
        
        $industries = mysql_query($sql_industries);
    }else if(count($_POST['financial_year']) > 1){
        // xbrl_PEBacked
        $sql_xbrl_PEBacked = "select count(cfs_original.company_id) as total from cfs_dashboard_analytics as cfs_original 
                                where cfs_original.FY = (select max(cfs_sub.FY) from cfs_dashboard_analytics as cfs_sub where cfs_sub.company_id = cfs_original.company_id) 
                                and cfs_original.is_xbrl = 'XBRL'
                                $listingstatus
                                $FY
                                $RFY
                                and cfs_original.is_PEBacked = 1";
                                
        $xbrl_PEBacked_count = mysql_query($sql_xbrl_PEBacked);
        $xbrl_PEBacked_total = mysql_fetch_array($xbrl_PEBacked_count);
        $xbrl_PEBacked = $xbrl_PEBacked_total['total'];
        
        // xbrl_nonPEBacked
        $sql_xbrl_nonPEBacked = "select count(cfs_original.company_id) as total from cfs_dashboard_analytics as cfs_original
                                where cfs_original.FY = (select max(cfs_sub.FY) from cfs_dashboard_analytics as cfs_sub where cfs_sub.company_id = cfs_original.company_id) 
                                and cfs_original.is_xbrl = 'XBRL' 
                                $listingstatus
                                $FY
                                $RFY
                                and cfs_original.is_PEBacked = 0";
        $xbrl_nonPEBacked = mysql_query($sql_xbrl_nonPEBacked);
        $xbrl_nonPEBacked_total = mysql_fetch_array($xbrl_nonPEBacked);
        $xbrl_nonPEBacked = $xbrl_nonPEBacked_total['total'];


        // nonxbrl_PEBacked
        $sql_nonxbrl_PEBacked = "select count(cfs_original.company_id) as total from cfs_dashboard_analytics as cfs_original
                                where cfs_original.FY = (select max(cfs_sub.FY) from cfs_dashboard_analytics as cfs_sub where cfs_sub.company_id = cfs_original.company_id) 
                                and cfs_original.is_xbrl = 'NON-XBRL' 
                                $listingstatus
                                $FY
                                $RFY
                                and cfs_original.is_PEBacked = 1";
        $nonxbrl_PEBacked = mysql_query($sql_nonxbrl_PEBacked);
        $nonxbrl_PEBacked_total = mysql_fetch_array($nonxbrl_PEBacked);
        $nonxbrl_PEBacked = $nonxbrl_PEBacked_total['total'];

        // nonxbrl_nonPEBacked
        $sql_nonxbrl_nonPEBacked = "select count(cfs_original.company_id) as total from cfs_dashboard_analytics as cfs_original
                                where cfs_original.FY = (select max(cfs_sub.FY) from cfs_dashboard_analytics as cfs_sub where cfs_sub.company_id = cfs_original.company_id) 
                                and cfs_original.is_xbrl = 'NON-XBRL' 
                                $listingstatus
                                $FY
                                $RFY
                                and cfs_original.is_PEBacked = 0";
        $nonxbrl_nonPEBacked = mysql_query($sql_nonxbrl_nonPEBacked);
        $nonxbrl_nonPEBacked_total = mysql_fetch_array($nonxbrl_nonPEBacked);
        $nonxbrl_nonPEBacked = $nonxbrl_nonPEBacked_total['total'];

        // Industry Selection
        $sql_industries = "select DISTINCT cfs_original.IndustryName as iname,count(DISTINCT cfs_original.company_id) as comcount from cfs_dashboard_analytics as cfs_original
        where cfs_original.FY = (select max(cfs_sub.FY) from cfs_dashboard_analytics as cfs_sub where cfs_sub.company_id = cfs_original.company_id) 
        and cfs_original.IndustryName != ''
        $listingstatus
        $FY
        $RFY
        group by cfs_original.IndustryName";
        // exit();
        
        $industries = mysql_query($sql_industries);

    }
    // ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

    while($row = mysql_fetch_array($industries)){
        $industriesarr []= ['iname'=>$row['iname'],'comcount'=>$row['comcount']];
    }
    $induscount = count($industriesarr);
    $incount = (round($induscount/2));

    if(!$induscount){
        $firstinarr = "<tr><td> Not found </td></tr>";
        $secinarr = "<tr><td> Not found </td></tr>";
    }
    else{

        $firstinarr = "";
        $secinarr = "";
    }

    $industriesarr = array_chunk($industriesarr,$incount);

    foreach($industriesarr[0] as $k => $v){
        $firstinarr .= "<tr><td> {$v['iname']} <span style='float:right;font-weight:normal'>{$v['comcount']}</span></td></tr>"; 
            
    }

    foreach($industriesarr[1] as $k => $v){
        $secinarr .= "<tr><td> {$v['iname']} <span style='float:right;font-weight:normal'>{$v['comcount']}</span></td></tr>"; 
    }


    // Culculation for count
    $xbrl_pebacked_nonpebacked_total = $xbrl_PEBacked + $xbrl_nonPEBacked;
    $nonxbrl_pebacked_nonpebacked_total = $nonxbrl_PEBacked + $nonxbrl_nonPEBacked;
    $xbrl_nonxbrl_pebacked_total = $xbrl_PEBacked + $nonxbrl_PEBacked;
    $xbrl_nonxbrl_nonpebacked_total = $xbrl_nonPEBacked + $nonxbrl_nonPEBacked;
    $total = $xbrl_pebacked_nonpebacked_total + $nonxbrl_pebacked_nonpebacked_total;

    // Making Array
    $cfsdashboard = array(
        "xbrl_PEBacked_count"=>$xbrl_PEBacked,
        "xbrl_nonPEBacked_count"=>$xbrl_nonPEBacked,
        "nonxbrl_PEBacked_count"=>$nonxbrl_PEBacked,
        "nonxbrl_nonPEBacked_count"=>$nonxbrl_nonPEBacked,
        "xbrl_pebacked_nonpebacked_total"=>$xbrl_pebacked_nonpebacked_total,
        "nonxbrl_pebacked_nonpebacked_total"=>$nonxbrl_pebacked_nonpebacked_total,
        "xbrl_nonxbrl_pebacked_total"=>$xbrl_nonxbrl_pebacked_total,
        "xbrl_nonxbrl_nonpebacked_total"=>$xbrl_nonxbrl_nonpebacked_total,
        "firstinarr"=>$firstinarr,
        "secinarr"=>$secinarr,
        "total"=>$total
    );

    echo json_encode($cfsdashboard);


?>