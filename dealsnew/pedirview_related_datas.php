<?php
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
      
       $searchallfield = $_POST['searchallfield'];
       $dirsearch = $_POST['dirsearch'];
       $search_valid=$_POST['search_valid'];
       $filed_name = $_POST['filed_name'];
       $tour_month1 = $_POST['tour_month1'];
       $tour_year1 = $_POST['tour_year1'];
       $tour_month2 = $_POST['tour_month2'];
       $tour_year2 = $_POST['tour_year2'];
       $investments = $_POST['investments'];
       $dirview_type = $_POST['dirview_type'];

    // Month and Year
    $month1=01; 
    $year1 = 1998;
    $month2= date('n');
    $year2 = date('Y');
    // $dt1 = $year1."-".$month1."-01";
    // $dt2 = $year2."-".$month2."-31";
    $dt1 = $tour_year1."-".$tour_month1."-01";
    $dt2 = $tour_year2."-".$tour_month2."-31";
    $wheredates = " and dates between '" . $dt1. "' and '" . $dt2 . "' ";
    $wheredates1= " and DealDate between '" . $dt1. "' and '" . $dt2 . "' ";
    $wheredates2= " and IPODate between '" . $dt1. "' and '" . $dt2 . "' ";
    // Investor
    if( $filed_name == 101){
        $filed_name = "investor";
    }
    // Class Name
    if($searchallfield == ''){
        $clasname = "other_db_links postlink";
    } else {
        $clasname = "other_db_link";
    }

    // Investments
    if($investments == 0){
        $investments = "PE-Inv";
    }else if($investments == 1){
        $investments = "VC-Inv";
        $pagetitle="PE Investors";
    }else if($investments == 2){
        $investments = "VC-Inv-Angel";
    }else if($investments == 3){
        $investments = "VC-Inv-Social";
    }else if($investments == 4){
        $investments = "PE-Inv-Cleantech";
    }else if($investments == 5){
        $investments = "PE_Inv_Infrastructure";
    }else if($investments == 6){
        $investments = "VC-Inv-Incubations";
    }
    
    // Response Array 
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
    $dealtype=' , dealtypes as dt '; 
    if(($key = array_search($section, $sectionList)) !== false) {
        unset($sectionList[$key]);
        
    }

    // print_r($sectionList);
    // End Array Response
    // Searching datas
    if($searchallfield != "" ){
       if($search_valid == 0){
          $search_dir="search=".$searchallfield;
          $inv_search=" Investor like '%$searchallfield%' ";
          $inc_search =" and  Incubator like '$searchallfield%' ";
       }else if($search_valid == 1){
        $search_dir="dirsearch=".$searchallfield;
        $inv_search=" Investor like '$searchallfield%' ";
        $inc_search =" and  Incubator like '$searchallfield%' ";
     }
        // Investments - PE
        if($dirview_type != 0){
            if(in_array('PE-Inv', $sectionList)){
                if($_SESSION['PE_industries']!=''){
                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                }
                $addVCFlagqry="";
            
                if($filed_name=='investor'){
                
                    $companysql = "select distinct peinv.InvestorId,inv.Investor,inv.*,GROUP_CONCAT(distinct i.industry SEPARATOR ', ') as industry ,
                            GROUP_CONCAT(distinct s.Stage SEPARATOR ', ') as Stage , 
                            (select country from country  where countryid = inv.countryid) as Countryname ,
                            (select focuscapsource from focus_capitalsource where focuscapsourceid = inv.focuscapsourceid) as focuscapsource,
                            SUM(peinv.Amount_M) as total_amount
                            from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,industry as i
                            where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                            pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and i.industryid=pec.industry and peinv.InvestorId!=9 and
                            pe.Deleted=0 " .$addVCFlagqry.$wheredates. " and ".$inv_search . $comp_industry_id_where."group by inv.Investor  order by inv.Investor ";
                }

                $query = mysql_query($companysql);

                    $PE_Inv_Count = mysql_num_rows($query);
                    
                // $PE_Inv_Count = PE_Inv($searchallfield,$filed_name);
                if($PE_Inv_Count>0){
                    $Response['sections']['PE-Inv']['count'] = $PE_Inv_Count; 
                    $Response['sections']['PE-Inv']['section'] = 'PE-Investments'; 
                
                    $Response['sections']['PE-Inv']['html'] = '<a href="pedirview.php?value=0&'.$search_dir.'" class="'.$clasname.'" data-search_val="'.$searchallfield.'">PE-Investments</a>'; 
                
                
                
                }
            }
        }
        if($dirview_type != 4){
            if(in_array('PE-Inv-Cleantech', $sectionList)){
                
                $addVCFlagqry = "";
                $dbtype="CT";
                $showallcompInvFlag=9;
                $peorvcflg=3;
                $firmtype = "";
                
                if($_SESSION['PE_industries']!=''){
                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                }
                if($filed_name=='investor'){
                    $companysql="select distinct peinv.InvestorId,inv.Investor,inv.*
                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                    pe.Deleted=0 " .$addVCFlagqry.  $firmtype .$wheredates. " and ". $inv_search . $comp_industry_id_where." order by inv.Investor ";
                }
                    $query = mysql_query($companysql);
                    $PE_Inv_Cleantech_Count = mysql_num_rows($query);

                if($PE_Inv_Cleantech_Count>0){
                    $Response['sections']['PE-Inv-Cleantech']['count'] = $PE_Inv_Cleantech_Count; 
                    $Response['sections']['PE-Inv-Cleantech']['section'] = 'PE-Cleantech';
                    $Response['sections']['PE-Inv-Cleantech']['html'] = '<a href="pedirview.php?value=4&'.$search_dir.'" class="'.$clasname.'" data-search_val="'.$searchallfield.'">PE-Cleantech</a>';
                    
                }
            }
        }
        if($dirview_type != 5){
            if(in_array('PE-Inv-Infrastructure', $sectionList)){
                $addVCFlagqry = "";
                $dbtype="IF";
                $showallcompInvFlag=10;
                $peorvcflg=3;
                $firmtype = "";
                
                if($_SESSION['PE_industries']!=''){
                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                }
                if($filed_name=='investor'){
                    $companysql="select distinct peinv.InvestorId,inv.Investor,inv.*
                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                    pe.Deleted=0 " .$addVCFlagqry.  $firmtype .$wheredates. " and ". $inv_search . $comp_industry_id_where."  order by inv.Investor ";
                }
                $query = mysql_query($companysql);
                $PE_Inv_Infrastructure_Count = mysql_num_rows($query);

                if($PE_Inv_Infrastructure_Count>0){
                    $Response['sections']['PE-Inv-Infrastructure']['count'] = $PE_Inv_Infrastructure_Count; 
                    $Response['sections']['PE-Inv-Infrastructure']['section'] = 'PE-Infrastructure'; 
                    $Response['sections']['PE-Inv-Infrastructure']['html'] = '<a href="pedirview.php?value=5&'.$search_dir.'" class="'.$clasname.'" data-search_val="'.$searchallfield.'">PE-Infrastructure</a>';
                }
            }
        }
        if($dirview_type != 1){
            if(in_array('VC-Inv', $sectionList)){
                
                if($_SESSION['PE_industries']!=''){
                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                }
                $addVCFlagqry="";
            
                if($filed_name=='investor'){
                
                    $companysql = "select distinct peinv.InvestorId,inv.Investor,inv.*,GROUP_CONCAT(distinct i.industry SEPARATOR ', ') as industry ,
                            GROUP_CONCAT(distinct s.Stage SEPARATOR ', ') as Stage , 
                            (select country from country  where countryid = inv.countryid) as Countryname ,
                            (select focuscapsource from focus_capitalsource where focuscapsourceid = inv.focuscapsourceid) as focuscapsource,
                            SUM(peinv.Amount_M) as total_amount
                            from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,industry as i
                            where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                            pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and i.industryid=pec.industry and peinv.InvestorId!=9 and
                            pe.Deleted=0 " .$addVCFlagqry.$wheredates. " and ". $inv_search . $comp_industry_id_where."  group by inv.Investor  order by inv.Investor ";
                }
            
                $query = mysql_query($companysql);
                $VC_Inv_Count = mysql_num_rows($query);
                if($VC_Inv_Count>0){
                    $Response['sections']['VC-Inv']['count'] = $VC_Inv_Count; 
                    $Response['sections']['VC-Inv']['section'] = 'VC-Investments'; 
                    $Response['sections']['VC-Inv']['html'] = '<a href="pedirview.php?value=1&'.$search_dir.'" class="'.$clasname.'" data-search_val="'.$searchallfield.'">VC-Investments</a>';
                }
            }
        }
        if($dirview_type != 2){
            if(in_array('VC-Inv-Angel', $sectionList)){
                
                $addVCFlagqry="";
                if($_SESSION['PE_industries']!=''){

                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                }

                if($filed_name=='investor'){
                    $companysql="SELECT DISTINCT inv.InvestorId, inv.Investor
                    FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv, country as c where  DealDate between '" . $dt1. "' and '" . $dt2 . "' and  pe.InvesteeId = pec.PEcompanyId and inv.countryid= c.countryid  
                    AND pec.industry !=15
                    AND peinv.AngelDealId = pe.AngelDealId
                    AND inv.InvestorId = peinv.InvestorId
                    AND pe.Deleted=0 and Investor!='Others' and ". $inv_search . $comp_industry_id_where."  order by inv.Investor"; 
                    // $companysql="SELECT DISTINCT inv.InvestorId, inv.Investor
                    //                 FROM angelinvdeals AS pe, pecompanies AS pec, angel_investors AS peinv, peinvestors AS inv, country as c where 
                    //                 pe.InvesteeId = pec.PEcompanyId and inv.countryid= c.countryid  
                    //                 AND pec.industry !=15 AND peinv.AngelDealId = pe.AngelDealId
                    //                 AND inv.InvestorId = peinv.InvestorId 
                    //                 AND pe.Deleted=0 and pec.companyname like '%$searchallfield%' $comp_industry_id_where order by inv.Investor ";
                }
                $query = mysql_query($companysql);
                $VC_Inv_Angel_Count = mysql_num_rows($query);
                if($VC_Inv_Angel_Count>0){
                    $Response['sections']['VC-Inv-Angel']['count'] = $VC_Inv_Angel_Count; 
                    $Response['sections']['VC-Inv-Angel']['section'] = 'VC-Angel'; 
                    $Response['sections']['VC-Inv-Angel']['html'] = '<a href="pedirview.php?value=2&'.$search_dir.'" class="'.$clasname.'" data-search_val="'.$searchallfield.'">Angel Investments</a>';
                }

            }
        }
        
        if(in_array('VC-Inv-Incubations', $sectionList)){
            
            $addVCFlagqry = " and pec.industry !=15 ";
            $addDefunctqry=" and Defunct=0 ";
            $addDelind="";
            
            if($_SESSION['PE_industries']!=''){
                $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
            }
            $datefilter=" date_month_year between '" . $dt1. "' and '" . $dt2 . "' AND  ";
            // $inv_search =" "
            if($filed_name=='investor'){
                $companysql="select pe.IncDealId,pe.IncubateeId,pec.companyname,pec.industry,i.industry,pec.sector_business  as sector_business,Individual,
                        pe.IncubatorId,inc.Incubator,pec.PECompanyid as companyid , pe.date_month_year
                        from incubatordeals as pe,pecompanies as pec,industry as i ,incubators as inc 
                        where $datefilter pec.industry = i.industryid and  inc.IncubatorId=pe.IncubatorId and pe.Deleted=0 
                        and pec.PECompanyId=pe.IncubateeId " .$inc_search.$addVCFlagqry.$addDefunctqry.$addDelind;   
            }
            //echo $companysql;
            $query = mysql_query($companysql);
            $VC_Inv_Incubations_Count = mysql_num_rows($query);
            if($VC_Inv_Incubations_Count>0){
                $Response['sections']['VC-Inv-Incubations']['count'] = $VC_Inv_Incubations_Count; 
                $Response['sections']['VC-Inv-Incubations']['section'] = 'VC-Incubations'; 
                $Response['sections']['VC-Inv-Incubations']['html'] = '<a href="pedirview.php?value=6&'.$search_dir.'" class="'.$clasname.'" data-search_val="'.$searchallfield.'">Incubation</a>';
            }

        }
        if($dirview_type != 3){
            if(in_array('VC-Inv-Social', $sectionList)){
                
                $addVCFlagqry = "";
                $dbtype="SV";
                $showallcompInvFlag=8;
                $peorvcflg=3;
                $firmtype = " and inv.FirmTypeId = 4";
                    
                if($_SESSION['PE_industries']!=''){
                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                }
                if($filed_name=='investor'){
                    $companysql="select distinct peinv.InvestorId,inv.Investor,inv.*
                    from peinvestments_investors as peinv,peinvestments as pe,stage as s,peinvestors as inv,pecompanies as pec,
                    peinvestments_dbtypes as pedb where peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and
                    pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId and pec.industry!=15 and  pedb.PEId=pe.PEId and pedb.DBTypeId='$dbtype' and
                    pe.Deleted=0 " .$addVCFlagqry.  $firmtype .$wheredates. " and ". $inv_search . $comp_industry_id_where." order by inv.Investor ";
                }

                $query = mysql_query($companysql);
                $VC_Inv_Social_Count = mysql_num_rows($query);

                if($VC_Inv_Social_Count>0){
                    $Response['sections']['VC-Inv-Social']['count'] = $VC_Inv_Social_Count; 
                    $Response['sections']['VC-Inv-Social']['section'] = 'VC-Social'; 
                    $Response['sections']['VC-Inv-Social']['html'] = '<a href="pedirview.php?value=3&'.$search_dir.'" class="'.$clasname.'" data-search_val="'.$searchallfield.'">VC-Social</a>';
                }
            }
        }

        // Exits
        if($dirview_type != 10){
            if(in_array('PE-Exits-MA', $sectionList)){
                $var_hideforexit=0;
                $addVCFlagqry="";
                $showallcompInvFlag=5;
                $peorvcflg=4;
                if($_SESSION['PE_industries']!=''){
                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                }
                $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0';
                if($filed_name=='investor'){
                    $companysql="SELECT DISTINCT inv.InvestorId, inv.Investor
                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, industry AS i, region AS r  , dealtypes as dt 
                    WHERE pe.PECompanyId = pec.PEcompanyId
                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                    AND r.RegionId = pec.RegionId 
                    AND peinv.MandAId = pe.MandAId
                    AND inv.InvestorId = peinv.InvestorId  " .$addVCFlagqry.$wheredates1." and ". $inv_search .$dealcond.$comp_industry_id_where." order by inv.Investor";
                
                            }
                //echo $companysql;
                $query = mysql_query($companysql);
                $PE_Exits_MA_Count = mysql_num_rows($query);
                if($PE_Exits_MA_Count>0){
                    $Response['sections']['PE-Exits-MA']['count'] = $PE_Exits_MA_Count; 
                    $Response['sections']['PE-Exits-MA']['section'] = 'PE-Exits-MA'; 
                    $Response['sections']['PE-Exits-MA']['html'] = '<a href="pedirview.php?value=10&'.$search_dir.'" class="'.$clasname.'" data-search_val="'.$searchallfield.'">PE-Exits M&A</a>'; 
                }
            }
        }
        if($dirview_type != 9){
            if(in_array('PE-Exits-PublicMarket', $sectionList) ){
                $var_hideforexit=1;
                $addVCFlagqry = "";
                $showallcompInvFlag=11;
                $peorvcflg=4;
                if($_SESSION['PE_industries']!=''){

                $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1';
                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                }

                if($filed_name=='investor'){
                    $companysql="SELECT DISTINCT inv.InvestorId, inv.Investor
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, industry AS i, region AS r  , dealtypes as dt 
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                            AND r.RegionId = pec.RegionId 
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId " .$addVCFlagqry.$wheredates1." and ". $inv_search. $dealcond . $comp_industry_id_where." order by inv.Investor";
                //     $showallsql="SELECT DISTINCT inv.InvestorId, inv.Investor
                //                 FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv  ".$dealtype." 
                //                 WHERE pe.PECompanyId = pec.PEcompanyId
                //                 AND pec.industry !=15
                //                 AND peinv.MandAId = pe.MandAId
                //                 AND inv.InvestorId = peinv.InvestorId
                //                 AND pe.Deleted=0 " .$addVCFlagqry.$wheredates." and ". $inv_search. $dealcond . $comp_industry_id_where." order by inv.Investor";
                 }
                
                $query = mysql_query($companysql);
                $PE_Exits_PublicMarket_Count = mysql_num_rows($query);
               // echo $PE_Exits_PublicMarket_Count;
                if($PE_Exits_PublicMarket_Count>0){
                   // echo $PE_Exits_PublicMarket_Count;
                    $Response['sections']['PE-Exits-PublicMarket']['count'] = $PE_Exits_PublicMarket_Count; 
                    $Response['sections']['PE-Exits-PublicMarket']['section'] = 'PE-Exits-Public Market'; 
                    $Response['sections']['PE-Exits-PublicMarket']['html'] = '<a href="pedirview.php?value=9&'.$search_dir.'" class="'.$clasname.'" data-search_val="'.$searchallfield.'">PE-Exits PublicMarket</a>'; 
                }
            }
        }
        if($dirview_type != 7){
            if(in_array('PE-Exits-IPO', $sectionList) ){
                
                $addVCFlagqry="";
                $showallcompInvFlag=3;
                $peorvcflg=2;

                if($_SESSION['PE_industries']!=''){
                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                }

                if($filed_name=='investor'){
                    $companysql="SELECT DISTINCT inv.InvestorId, inv.Investor
                                    FROM pecompanies AS pec, ipos AS pe, industry AS i, region AS r, ipo_investors AS peinv, peinvestors AS inv
                                    WHERE pec.PECompanyId = pe.PEcompanyId
                                    AND peinv.IPOId = pe.IPOId
                                    AND inv.InvestorId = peinv.InvestorId
                                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                                    AND r.RegionId = pec.RegionId " .$addVCFlagqry.$wheredates2. " and ". $inv_search . $comp_industry_id_where." order by inv.Investor "; 
                    // $companysql="SELECT DISTINCT inv.InvestorId, inv.Investor
                    //             FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                    //             WHERE pe.PECompanyId = pec.PEcompanyId
                    //             AND pec.industry !=15
                    //             AND peinv.IPOId = pe.IPOId
                    //             AND inv.InvestorId = peinv.InvestorId
                    //             AND pe.Deleted=0 " .$addVCFlagqry.$wheredates2. " and ". $inv_search . $comp_industry_id_where." order by inv.Investor ";
                }
                $query = mysql_query($companysql);
                $PE_Exits_IPO_Count = mysql_num_rows($query);
                if($PE_Exits_IPO_Count>0){
                    $Response['sections']['PE-Exits-IPO']['count'] = $PE_Exits_IPO_Count; 
                    $Response['sections']['PE-Exits-IPO']['section'] = 'PE-Exits-IPO'; 
                    $Response['sections']['PE-Exits-IPO']['html'] = '<a href="pedirview.php?value=7&'.$search_dir.'" class="other_db_link" data-search_val="'.$searchallfield.'">PE-Exits IPO</a>'; 
                }
            }
        }
        if($dirview_type != 11){
            if(in_array('VC-Exits-MA', $sectionList) ){
                $addVCFlagqry=" and VCFlag=1 ";
                $showallcompInvFlag=5;
                $peorvcflg=4;
                $var_hideforexit=0;
                if($_SESSION['PE_industries']!=''){
                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                }

                $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=0';
                if($filed_name=='investor'){
                    $companysql="SELECT DISTINCT inv.InvestorId, inv.Investor
                            FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, industry AS i, region AS r  , dealtypes as dt 
                            WHERE pe.PECompanyId = pec.PEcompanyId
                            AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                            AND r.RegionId = pec.RegionId 
                            AND peinv.MandAId = pe.MandAId
                            AND inv.InvestorId = peinv.InvestorId " .$addVCFlagqry.$wheredates1." and ". $inv_search . $dealcond. $comp_industry_id_where." order by inv.Investor";
 
                    // $companysql="SELECT DISTINCT inv.InvestorId, inv.Investor
                    //             FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv  ".$dealtype." 
                    //             WHERE pe.PECompanyId = pec.PEcompanyId
                    //             AND pec.industry !=15
                    //             AND peinv.MandAId = pe.MandAId
                    //             AND inv.InvestorId = peinv.InvestorId
                    //             AND pe.Deleted=0 " .$addVCFlagqry.$wheredates1." and ". $inv_search . $dealcond. $comp_industry_id_where." order by inv.Investor";
                }
                //echo $companysql;
                $query = mysql_query($companysql);
                $VC_Exits_MA_Count = mysql_num_rows($query);

                if($VC_Exits_MA_Count>0){
                $Response['sections']['VC-Exits-MA']['count'] = $VC_Exits_MA_Count; 
                $Response['sections']['VC-Exits-MA']['section'] = 'VC-Exits-MA'; 
                $Response['sections']['VC-Exits-MA']['html'] = '<a href="pedirview.php?value=11&'.$search_dir.'" class="'.$clasname.'" data-search_val="'.$searchallfield.'">VC-Exits M&A</a>'; 
                }
            } 
        }
        if($dirview_type != 12){
            if(in_array('VC-Exits-PublicMarket', $sectionList) ){

                $var_hideforexit=1;
                $addVCFlagqry = " and VCFlag=1 ";
                $showallcompInvFlag=11;
                $dealcond='AND pe.DealTypeId= dt.DealTypeId  AND dt.hide_for_exit=1';
                $peorvcflg=4;
                if($_SESSION['PE_industries']!=''){
                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                }
                if($filed_name=='investor'){
                    $companysql="SELECT DISTINCT inv.InvestorId, inv.Investor
                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, industry AS i, region AS r ".$dealtype."
                    WHERE pe.PECompanyId = pec.PEcompanyId
                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                    AND r.RegionId = pec.RegionId 
                    AND peinv.MandAId = pe.MandAId
                    AND inv.InvestorId = peinv.InvestorId " .$addVCFlagqry.$wheredates1." and ". $inv_search . $dealcond. $comp_industry_id_where." order by inv.Investor";
                    // $companysql="SELECT DISTINCT inv.InvestorId, inv.Investor
                    //             FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv  ".$dealtype." 
                    //             WHERE pe.PECompanyId = pec.PEcompanyId
                    //             AND pec.industry !=15
                    //             AND peinv.MandAId = pe.MandAId
                    //             AND inv.InvestorId = peinv.InvestorId
                    //             AND pe.Deleted=0 " .$addVCFlagqry.$wheredates1." and ". $inv_search . $dealcond. $comp_industry_id_where." order by inv.Investor";
                } 
               // echo $companysql;
                $query = mysql_query($companysql);
                $VC_Exits_PublicMarket_Count = mysql_num_rows($query);
                if($VC_Exits_PublicMarket_Count>0){
                $Response['sections']['VC-Exits-PublicMarket']['count'] = $VC_Exits_PublicMarket_Count; 
                $Response['sections']['VC-Exits-PublicMarket']['section'] = 'VC-Exits-Public Market'; 
                $Response['sections']['VC-Exits-PublicMarket']['html'] = '<a href="pedirview.php?value=12&'.$search_dir.'" class="'.$clasname.'" data-search_val="'.$searchallfield.'">VC-Exits PublicMarket</a>'; 
                }
            }
        }
        if($dirview_type != 8){
            if(in_array('VC-Exits-IPO', $sectionList) ){

                $addVCFlagqry = " and VCFlag=1 ";
                $showallcompInvFlag=4;
                $peorvcflg=2;

                if($_SESSION['PE_industries']!=''){
                    $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                }

                if($filed_name=='investor'){
                    $companysql="SELECT DISTINCT pe.PECompanyId, pec. * , i.industry, r.Region
                    FROM manda AS pe, pecompanies AS pec, manda_investors AS peinv, peinvestors AS inv, industry AS i, region AS r ".$dealtype."
                    WHERE pe.PECompanyId = pec.PEcompanyId
                    AND i.industryid = pec.industry and pe.Deleted=0 and pec.industry!=15
                    AND r.RegionId = pec.RegionId 
                    AND peinv.MandAId = pe.MandAId
                    AND inv.InvestorId = peinv.InvestorId " .$addVCFlagqry.$wheredates2. " and ". $inv_search . $comp_industry_id_where." order by inv.Investor ";
                    
                    // $companysql="SELECT DISTINCT inv.InvestorId, inv.Investor
                    //             FROM ipos AS pe, pecompanies AS pec, ipo_investors AS peinv, peinvestors AS inv
                    //             WHERE pe.PECompanyId = pec.PEcompanyId
                    //             AND pec.industry !=15
                    //             AND peinv.IPOId = pe.IPOId
                    //             AND inv.InvestorId = peinv.InvestorId
                    //             AND pe.Deleted=0 " .$addVCFlagqry.$wheredates2. " and ". $inv_search . $comp_industry_id_where." order by inv.Investor ";
                }

                $query = mysql_query($companysql);
                $VC_Exits_IPO_Count = mysql_num_rows($query);

                if($VC_Exits_IPO_Count>0){
                $Response['sections']['VC-Exits-IPO']['count'] = $VC_Exits_IPO_Count; 
                $Response['sections']['VC-Exits-IPO']['section'] = 'VC-Exits-IPO'; 
                $Response['sections']['VC-Exits-IPO']['html'] = '<a href="pedirview.php?value=8&'.$search_dir.'" class="other_db_link" data-search_val="'.$searchallfield.'">VC-Exits IPO</a>'; 
                }
            } 
        }

        // Response
        if(count($Response)==0){
            $Response['result']=0;
        }else{
            $Response['result']=1;
            $Response['message']='There are matching results for this search in ';
        }
        echo json_encode($Response);
        //  print_r();
        mysql_close();
        mysql_close($cnx);
        exit;
    }
    else{
        echo "0";
    }
?>