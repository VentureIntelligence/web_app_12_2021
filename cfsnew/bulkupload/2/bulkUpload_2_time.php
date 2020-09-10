<?php
$dbhost = "localhost";
$dbuser = "venture_admin16";
$dbpassword = "V@dm!n2016";
$dbname = "venture_peinvestments";
$dbhandle = mysql_connect($dbhost, $dbuser, $dbpassword) 
  or die("Unable to connect to MySQL");
$selected = mysql_select_db($dbname,$dbhandle) 
  or die("Database could not select");

//if(isset($_GET["action"]) && ($_GET["action"] == "upload")){
    //company upload    
    $added_date = date('Y-m-d H:i:s');
    $date = date('ymdHis');
    $p_outfile = "csv/plstd.csv";
    $new_p_outfile = "csv/plstd_".$date.".csv";
    $b_outfile = "csv/bsnew.csv";
    $new_b_outfile = "csv/bsnew_".$date.".csv";
    $source_flag = 5;
    if((file_exists($p_outfile)) && (file_exists($b_outfile))){
        $to = "arun@ventureintelligence.in";
        $subject = "File started";
        $txt = "Started successfully !!!";
        $headers = "From: Test";

        mail($to,$subject,$txt,$headers);
                //////////////////Sheet Name - PL Standard ///////////////////////////
       /* $file = fopen($p_outfile, "r");
        $count = 0; 
        while (($plstandard = fgetcsv($file, 10000, ",")) !== FALSE) {
         $count++;
            if($count>1){
                if($plstandard[21] !='' && $plstandard[21] !='CIN Number'){
                    $cin = $plstandard[21];echo "SELECT Company_Id,Industry FROM cprofile WHERE CIN='$cin'";
                    $result = mysql_query("SELECT Company_Id,Industry FROM cprofile WHERE CIN='$cin'");
                    if(mysql_num_rows($result) >0){
                        $res = mysql_fetch_array($result);
                        $cprofile_id = $res['Company_Id'];
                        $res_type = $plstandard[15];
                        if($res_type=="Consolidated"){
                            $result_type = 1;
                        }else{
                            $result_type = 0;
                        }
                        $OptnlIncome = $plstandard[0];
                        $OtherIncome = $plstandard[1];
                        $TotalIncome = $plstandard[2];
                        $OptnlAdminandOthrExp = $plstandard[3];
                        $OptnlProfit = $plstandard[4];
                        $EBITDA = $plstandard[5];
                        $Interest = $plstandard[6];
                        $EBDT = $plstandard[7];
                        $Depreciation = $plstandard[8];
                        $EBT = $plstandard[9];
                        $Tax = $plstandard[10];
                        $PAT = $plstandard[11];
                        $FY = $plstandard[12];
                        $FY_len = strlen($FY);
                        if($FY_len == 6){
                            $FY = substr($FY,2,-2);
                        }else if($FY_len == 4){
                            $FY = substr($FY,2);                        
                        }
                        $BINR = round($plstandard[13]);
                        $DINR = round($plstandard[14]);
                        $EmployeeRelatedExpenses = $plstandard[16];
                        $ForeignExchangeEarningandOutgo = $plstandard[17];
                        $EarninginForeignExchange = $plstandard[18];
                        $OutgoinForeignExchange = $plstandard[19];
                        $AddFinancials = $plstandard[20];

                        $pl_check = mysql_query("SELECT PLStandard_Id FROM plstandard WHERE CId_FK='$cprofile_id' and FY='$FY' and ResultType='$result_type'" );
                        $pl_check_count = mysql_num_rows($pl_check);
                        if($pl_check_count > 0){
                            $res = mysql_fetch_array($pl_check);
                            $pls_id = $res['PLStandard_Id'];
                            mysql_query("update plstandard set IndustryId_FK='".$res['Industry']."',OptnlIncome='$OptnlIncome',OtherIncome='$OtherIncome',OptnlAdminandOthrExp='$OptnlAdminandOthrExp',OptnlProfit='$OptnlProfit',EBITDA='$EBITDA',Interest='$Interest',EBDT='$EBDT',Depreciation='$Depreciation',EBT='$EBT',Tax='$Tax',PAT='$PAT',BINR='$BINR',DINR='$DINR',TotalIncome='$TotalIncome',EmployeeRelatedExpenses='$EmployeeRelatedExpenses',ForeignExchangeEarningandOutgo='$ForeignExchangeEarningandOutgo',EarninginForeignExchange='$EarninginForeignExchange',OutgoinForeignExchange='$OutgoinForeignExchange',AddFinancials='$AddFinancials',updated_date='$added_date' where PLStandard_Id='$pls_id'");
                            mysql_query("insert into test_cin (cin,file_name,action,added_date,pl_bs_id) values ('$cin','plstd','update','$added_date','$pls_id')");
                        }else{
                            $sql_insert_pl = "INSERT INTO plstandard 
                                            (
                                                CId_FK,IndustryId_FK,OptnlIncome,OtherIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT
                                                ,Tax,PAT,FY,TotalIncome,BINR,DINR,Added_Date,ResultType,EmployeeRelatedExpenses,ForeignExchangeEarningandOutgo,EarninginForeignExchange
                                                ,OutgoinForeignExchange,AddFinancials,updated_date                                                
                                            ) 
                                            VALUES 
                                            (
                                                '$cprofile_id','".$res['Industry']."','$OptnlIncome','$OtherIncome','$OptnlAdminandOthrExp','$OptnlProfit','$EBITDA','$Interest','$EBDT'
                                                ,'$Depreciation','$EBT','$Tax','$PAT','$FY','$TotalIncome','$BINR','$DINR','$added_date','$result_type'
                                                ,'$EmployeeRelatedExpenses','$ForeignExchangeEarningandOutgo','$EarninginForeignExchange','$OutgoinForeignExchange','$AddFinancials','$added_date'
                                            )";
                            $result_insert_pl = mysql_query($sql_insert_pl) or die(mysql_error()); 
                            mysql_query("insert into test_cin (cin,file_name,action,added_date,pl_bs_id) values ('$cin','plstd','insert','$added_date','$result_insert_pl')"); 
                        }
                        mysql_query("UPDATE cprofile SET source_flag='$source_flag' WHERE Company_id='$cprofile_id'");
                    }else{
                        mysql_query("insert into test_cin (cin,file_name,action,added_date) values ('$cin','plstd','no_company','$added_date')");
                    }
                }
            }
        }die;
        /////////////Sheet Name - BS-new //////////////
        $file = fopen($b_outfile, "r");
        $count = 0;
        while (($balancenew = fgetcsv($file, 10000, ",")) !== FALSE) {
            $count++;
            if($count>1){
                if($balancenew[38] !=''){
                    $cin = $balancenew[38];
                    $result = mysql_query("SELECT Company_Id,Industry FROM cprofile WHERE CIN='$cin'");
                    if(mysql_num_rows($result) >0){
                        $res = mysql_fetch_array($result);
                        $cprofile_id = $res['Company_Id'];
                        $ShareCapital = $balancenew[0];
                        $ReservesSurplus = $balancenew[1];
                        $TotalFunds = $balancenew[2];
                        $ShareApplication = $balancenew[3];
                        $N_current_liabilities = $balancenew[4];
                        $L_term_borrowings = $balancenew[5];
                        $deferred_tax_liabilities = $balancenew[6];
                        $O_long_term_liabilities = $balancenew[7];
                        $L_term_provisions = $balancenew[8];
                        $T_non_current_liabilities = $balancenew[9];
                        $Current_liabilities = $balancenew[10];
                        $S_term_borrowings = $balancenew[11];
                        $Trade_payables = $balancenew[12];
                        $O_current_liabilities = $balancenew[13];
                        $S_term_provisions = $balancenew[14];
                        $T_current_liabilities = $balancenew[15];
                        $T_equity_liabilities = $balancenew[16];
                        $Assets = $balancenew[17];
                        $N_current_assets = $balancenew[18];
                        $Fixed_assets = $balancenew[19];
                        $Tangible_assets = $balancenew[20];
                        $Intangible_assets = $balancenew[21];
                        $T_fixed_assets = $balancenew[22];
                        $N_current_investments = $balancenew[23];
                        $Deferred_tax_assets = $balancenew[24];
                        $L_term_loans_advances = $balancenew[25];
                        $O_non_current_assets = $balancenew[26];
                        $T_non_current_assets = $balancenew[27];
                        $Current_assets = $balancenew[28];
                        $Current_investments = $balancenew[29];
                        $Inventories = $balancenew[30];
                        $Trade_receivables = $balancenew[31];
                        $Cash_bank_balances = $balancenew[32];
                        $S_term_loans_advances = $balancenew[33];
                        $O_current_assets = $balancenew[34];
                        $T_current_assets = $balancenew[35];
                        $Total_assets = $balancenew[36];
                        $FY = $balancenew[37];
                        $FY_len = strlen($FY);
                        if($FY_len == 6){
                            $FY = substr($FY,2,-2);
                        }else if($FY_len == 4){
                            $FY = substr($FY,2);                        
                        }

                        $bs_check = mysql_query("SELECT BalanceSheet_Id FROM balancesheet_new WHERE CId_FK='$cprofile_id' and FY='$FY' and ResultType='$result_type'" );
                        $bs_check_count = mysql_num_rows($bs_check);
                        if($bs_check_count > 0){
                            $res = mysql_fetch_array($bs_check);
                            $bs_id = $res['BalanceSheet_Id'];
                            mysql_query("update balancesheet_new set IndustryId_FK='".$res['Industry']."',ShareCapital='$ShareCapital',ReservesSurplus='$ReservesSurplus',TotalFunds='$TotalFunds',ShareApplication='$ShareApplication',
                                    N_current_liabilities='$N_current_liabilities',L_term_borrowings='$L_term_borrowings',deferred_tax_liabilities='$deferred_tax_liabilities',O_long_term_liabilities='$O_long_term_liabilities',L_term_provisions='$L_term_provisions',T_non_current_liabilities='$T_non_current_liabilities',
                                    Current_liabilities='$Current_liabilities',S_term_borrowings='$S_term_borrowings',Trade_payables='$Trade_payables',O_current_liabilities='$O_current_liabilities',S_term_provisions='$S_term_provisions',
                                    T_current_liabilities='$T_current_liabilities',T_equity_liabilities='$T_equity_liabilities',Assets='$Assets',N_current_assets='$N_current_assets',
                                    Fixed_assets='$Fixed_assets',Tangible_assets='$Tangible_assets',Intangible_assets='$Intangible_assets',T_fixed_assets='$T_fixed_assets',
                                    N_current_investments='$N_current_investments',Deferred_tax_assets='$Deferred_tax_assets',L_term_loans_advances='$L_term_loans_advances',O_non_current_assets='$O_non_current_assets',
                                    T_non_current_assets='$T_non_current_assets',Current_assets='$Current_assets',Current_investments='$Current_investments',Inventories='$Inventories',
                                    Trade_receivables='$Trade_receivables',Cash_bank_balances='$Cash_bank_balances',S_term_loans_advances='$S_term_loans_advances',O_current_assets='$O_current_assets',
                                    T_current_assets='$T_current_assets',Total_assets='$Total_assets',
                                    updated_date='$added_date' where CId_FK='$cprofile_id' and FY='$FY' and ResultType='$result_type'");
                            mysql_query("insert into test_cin (cin,file_name,action,added_date,pl_bs_id) values ('$cin','bs','update','$added_date','$bs_id')");
                        }else{
                            $sql_insert_bs = "INSERT INTO balancesheet_new 
                                             (
                                                 BalanceSheet_Id,CID_FK,IndustryId_FK,ShareCapital,ReservesSurplus,TotalFunds,ShareApplication,N_current_liabilities,L_term_borrowings
                                                 ,deferred_tax_liabilities,O_long_term_liabilities,L_term_provisions,T_non_current_liabilities,Current_liabilities,S_term_borrowings
                                                 ,Trade_payables,O_current_liabilities,S_term_provisions,T_current_liabilities,T_equity_liabilities,Assets,N_current_assets,Fixed_assets
                                                 ,Tangible_assets,Intangible_assets,T_fixed_assets,N_current_investments,Deferred_tax_assets,L_term_loans_advances,O_non_current_assets
                                                 ,T_non_current_assets,Current_assets,Current_investments,Inventories,Trade_receivables,Cash_bank_balances,S_term_loans_advances,O_current_assets
                                                 ,T_current_assets,Total_assets,FY,Added_Date
                                             ) 
                                             VALUES 
                                             (
                                                 '','$cprofile_id','".$res['Industry']."','$ShareCapital','$ReservesSurplus','$TotalFunds','$ShareApplication','$N_current_liabilities','$L_term_borrowings','$deferred_tax_liabilities'
                                                 ,'$O_long_term_liabilities','$L_term_provisions','$T_non_current_liabilities','$Current_liabilities','$S_term_borrowings','$Trade_payables'
                                                 ,'$O_current_liabilities','$S_term_provisions','$T_current_liabilities','$T_equity_liabilities','$Assets','$N_current_assets','$Fixed_assets'
                                                 ,'$Tangible_assets','$Intangible_assets','$T_fixed_assets','$N_current_investments','$Deferred_tax_assets','$L_term_loans_advances','$O_non_current_assets'
                                                 ,'$T_non_current_assets','$Current_assets','$Current_investments','$Inventories','$Trade_receivables','$Cash_bank_balances','$S_term_loans_advances'
                                                 ,'$O_current_assets','$T_current_assets','$Total_assets','$FY','$added_date'
                                             )";
                            $result_insert_bs = mysql_query($sql_insert_bs) or die(mysql_error());
                            mysql_query("insert into test_cin (cin,file_name,action,added_date,pl_bs_id) values ('$cin','bs','insert','$added_date','$result_insert_bs')");
                        }
                        mysql_query("UPDATE cprofile SET source_flag='$source_flag' WHERE Company_id='$cprofile_id'");
                    }else{
                        mysql_query("insert into test_cin (cin,file_name,action,added_date) values ('$cin','bs','no_company','$added_date')");
                    }
                }
            }
        }      die;
        rename($p_outfile,$new_p_outfile);
        rename($b_outfile,$new_b_outfile);*/
        
        //////////// Find CAGR & PL standard //////////////////   
        $cprofile_check = mysql_query("SELECT Company_Id,Industry FROM cprofile WHERE source_flag='$source_flag'" );
        $cin_check_count = mysql_num_rows($cprofile_check);
        if($cin_check_count > 0){
            while($cprofileDetails = mysql_fetch_array($cprofile_check)){
                $cprofile_id = $cprofileDetails['Company_Id'];
                $IndustryId_FK = $cprofileDetails['Industry'];
                $pl_details = mysql_query("SELECT * FROM plstandard WHERE CId_FK='$cprofile_id' order by FY desc" );
                $pl_check_count = mysql_num_rows($pl_details);
                if($pl_check_count > 0){
                    $FYCount = $pl_check_count;
                    $GFYCount = $pl_check_count - 1;
                    echo "UPDATE  `cprofile` SET FYCount='$FYCount',GFYCount='$GFYCount'  WHERE Company_Id='$cprofile_id'";
                    mysql_query("UPDATE  `cprofile` SET FYCount='$FYCount',GFYCount='$GFYCount'  WHERE Company_Id='$cprofile_id'" );   
                    $i=0;
                    while($pl_detail = mysql_fetch_array($pl_details)){
                            $plDetails[] = $pl_detail;
                    }
                    for($i=0;$i<$pl_check_count-1;$i++){ 
                        $FY  = ereg_replace("[^0-9]", "", $plDetails[$i]['FY']);
                        $Year = $i+1;
                        $Added_Date = date("Y-m-d:H:i:s");
                        $ResultType = $plDetails[$i]['ResultType'];

                        //Find growth percentage
                        if(($plDetails[$i]['OptnlIncome'] != "NULL") && ($plDetails[$i+1]['OptnlIncome'] != "NULL")){
                            $growth_OptnlIncome = ($plDetails[$i]['OptnlIncome'] - $plDetails[$i+1]['OptnlIncome']) / ($plDetails[$i+1]['OptnlIncome'] )*100;  
                        }else{
                            $growth_OptnlIncome = NULL;
                        }
                        if(($plDetails[$i]['OtherIncome'] != "NULL") && ($plDetails[$i+1]['OtherIncome'] != "NULL")){
                            $growth_OtherIncome = ($plDetails[$i]['OtherIncome'] - $plDetails[$i+1]['OtherIncome']) / (abs($plDetails[$i+1]['OtherIncome'] ))*100; 
                        }else{
                            $growth_OtherIncome = NULL;
                        }
                        if(($plDetails[$i]['TotalIncome'] != "NULL") && ($plDetails[$i+1]['TotalIncome'] != "NULL")){
                            $growth_TotalIncome = ($plDetails[$i]['TotalIncome'] - $plDetails[$i+1]['TotalIncome']) / (abs($plDetails[$i+1]['TotalIncome'] ))*100; 
                        }else{
                            $growth_TotalIncome = NULL;
                        }
                        if(($plDetails[$i]['OptnlAdminandOthrExp'] != "NULL") && ($plDetails[$i+1]['OptnlAdminandOthrExp'] != "NULL")){ 
                            $growth_OptnlAdminandOthrExp = ($plDetails[$i]['OptnlAdminandOthrExp'] - $plDetails[$i+1]['OptnlAdminandOthrExp']) / (abs($plDetails[$i+1]['OptnlAdminandOthrExp'] ))*100; 
                        }else{
                            $growth_OptnlAdminandOthrExp = NULL;
                        } 
                        if(($plDetails[$i]['OptnlProfit'] != "NULL") && ($plDetails[$i+1]['OptnlProfit'] != "NULL")){
                            $growth_OptnlProfit = ($plDetails[$i]['OptnlProfit'] - $plDetails[$i+1]['OptnlProfit']) / (abs($plDetails[$i+1]['OptnlProfit'] ))*100;  
                        }else{
                            $growth_OptnlProfit = NULL;
                        }
                        if(($plDetails[$i]['EBITDA'] != "NULL") && ($plDetails[$i+1]['EBITDA'] != "NULL")){
                            $growth_EBITDA = ($plDetails[$i]['EBITDA'] - $plDetails[$i+1]['EBITDA']) / (abs($plDetails[$i+1]['EBITDA'] ))*100;  
                        }else{
                            $growth_EBITDA = NULL;
                        } 
                        if(($plDetails[$i]['Interest'] != "NULL") && ($plDetails[$i+1]['Interest'] != "NULL")){
                            $growth_Interest = ($plDetails[$i]['Interest'] - $plDetails[$i+1]['Interest']) / (abs($plDetails[$i+1]['Interest'] ))*100;  
                        }else{
                            $growth_Interest = NULL;
                        }
                        if(($plDetails[$i]['EBDT'] != "NULL") && ($plDetails[$i+1]['EBDT'] != "NULL")){ 
                            $growth_EBDT = ($plDetails[$i]['EBDT'] - $plDetails[$i+1]['EBDT']) / (abs($plDetails[$i+1]['EBDT'] ))*100;  
                        }else{
                            $growth_EBDT = NULL;
                        } 
                        if(($plDetails[$i]['Depreciation'] != "NULL") && ($plDetails[$i+1]['Depreciation'] != "NULL")){
                            $growth_Depreciation = ($plDetails[$i]['Depreciation'] - $plDetails[$i+1]['Depreciation']) / (abs($plDetails[$i+1]['Depreciation'] ))*100; 
                        }else{
                            $growth_Depreciation = NULL;
                        }
                        if(($plDetails[$i]['EBT'] != "NULL") && ($plDetails[$i+1]['EBT'] != "NULL")){  
                            $growth_EBT = ($plDetails[$i]['EBT'] - $plDetails[$i+1]['EBT']) / (abs($plDetails[$i+1]['EBT'] ))*100;
                        }else{
                            $growth_EBT = NULL;
                        }
                        if(($plDetails[$i]['Tax'] != "NULL") && ($plDetails[$i+1]['Tax'] != "NULL")){   
                            $growth_Tax = ($plDetails[$i]['Tax'] - $plDetails[$i+1]['Tax']) / (abs($plDetails[$i+1]['Tax'] ))*100; 
                        }else{
                            $growth_Tax = NULL;
                        }
                        if(($plDetails[$i]['PAT'] != "NULL") && ($plDetails[$i+1]['PAT'] != "NULL")){  
                            $growth_PAT = ($plDetails[$i]['PAT'] - $plDetails[$i+1]['PAT']) / (abs($plDetails[$i+1]['PAT'] ))*100; 
                        }else{
                            $growth_PAT = NULL;
                        }
                        if(($plDetails[$i]['BINR'] != "NULL") && ($plDetails[$i+1]['BINR'] != "NULL")){  
                            $growth_BINR = ($plDetails[$i]['BINR'] - $plDetails[$i+1]['BINR']) / (abs($plDetails[$i+1]['BINR'] ))*100; 
                        }else{
                            $growth_BINR = NULL;
                        }  
                        if(($plDetails[$i]['DINR'] != "NULL") && ($plDetails[$i+1]['DINR'] != "NULL")){
                            $growth_DINR = ($plDetails[$i]['DINR'] - $plDetails[$i+1]['DINR']) / (abs($plDetails[$i+1]['DINR'] ))*100; 
                        }else{
                            $growth_DINR = NULL;
                        }
                        $growth_details = mysql_query("SELECT GrowthPerc_Id FROM growthpercentage WHERE CId_FK='$cprofile_id' and FY='$FY' order by FY desc" );
                        $growth_check_count = mysql_num_rows($growth_details);
                        if($growth_check_count > 0){
                            $growth_detail = mysql_fetch_array($growth_details);
                            $GrowthPerc_Id = $growth_detail['GrowthPerc_Id'];
                            echo "update growthpercentage set OptnlIncome='$growth_OptnlIncome',OtherIncome='$growth_OtherIncome',TotalIncome='$growth_TotalIncome',OptnlAdminandOthrExp='$growth_OptnlAdminandOthrExp',OptnlProfit='$growth_OptnlProfit',EBITDA='$growth_EBITDA',Interest='$growth_Interest',EBDT='$growth_EBDT',Depreciation='$growth_Depreciation',EBT='$growth_EBT',Tax='$growth_Tax',PAT='$growth_PAT',BINR='$growth_BINR',DINR='$growth_DINR',FY='$FY',GrowthYear='$Year',Updated_date='$Added_Date',IndustryId_FK='$IndustryId_FK',ResultType='$ResultType' where GrowthPerc_Id='$GrowthPerc_Id'";
                            mysql_query("update growthpercentage set OptnlIncome='$growth_OptnlIncome',OtherIncome='$growth_OtherIncome',TotalIncome='$growth_TotalIncome',OptnlAdminandOthrExp='$growth_OptnlAdminandOthrExp',OptnlProfit='$growth_OptnlProfit',EBITDA='$growth_EBITDA',Interest='$growth_Interest',EBDT='$growth_EBDT',Depreciation='$growth_Depreciation',EBT='$growth_EBT',Tax='$growth_Tax',PAT='$growth_PAT',BINR='$growth_BINR',DINR='$growth_DINR',FY='$FY',GrowthYear='$Year',Updated_date='$Added_Date',IndustryId_FK='$IndustryId_FK',ResultType='$ResultType' where GrowthPerc_Id='$GrowthPerc_Id'");
                        }else{
                            echo "insert into growthpercentage (OptnlIncome,OtherIncome,TotalIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,BINR,DINR,FY,GrowthYear,Added_Date,IndustryId_FK,ResultType,CId_FK) values ('$growth_OptnlIncome','$growth_OtherIncome','$growth_TotalIncome','$growth_OptnlAdminandOthrExp','$growth_OptnlProfit','$growth_EBITDA','$growth_Interest', '$growth_EBDT','$growth_Depreciation','$growth_EBT','$growth_Tax','$growth_PAT','$growth_BINR','$growth_DINR','$FY','$Year','$Added_Date','$IndustryId_FK','$ResultType','$cprofile_id')";
                            mysql_query("insert into growthpercentage (OptnlIncome,OtherIncome,TotalIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,BINR,DINR,FY,GrowthYear,Added_Date,IndustryId_FK,ResultType,CId_FK) values ('$growth_OptnlIncome','$growth_OtherIncome','$growth_TotalIncome','$growth_OptnlAdminandOthrExp','$growth_OptnlProfit','$growth_EBITDA','$growth_Interest', '$growth_EBDT','$growth_Depreciation','$growth_EBT','$growth_Tax','$growth_PAT','$growth_BINR','$growth_DINR','$FY','$Year','$Added_Date','$IndustryId_FK','$ResultType','$cprofile_id')");
                        } 
                        
                        ///////////////////////////////////////////////////////
                        
                        //Find CAGR
                        if(($plDetails[0]['OptnlIncome'] != "NULL") && ($plDetails[$i+1]['OptnlIncome'] != "NULL") && ($plDetails[0]['OptnlIncome'] > 0) && ($plDetails[$i+1]['OptnlIncome'] > 0)){
                            $cagr_OptnlIncome = (pow(($plDetails[0]['OptnlIncome'] / $plDetails[$i+1]['OptnlIncome']), (1/($i+1)))-1)*100;
                        }else{
                            $cagr_OptnlIncome = NULL;
                        }
                        if(($plDetails[0]['OtherIncome'] != "NULL") && ($plDetails[$i+1]['OtherIncome'] != "NULL") && ($plDetails[0]['OtherIncome'] > 0) && ($plDetails[$i+1]['OtherIncome'] > 0)){
                            $cagr_OtherIncome = (pow(($plDetails[0]['OtherIncome'] / $plDetails[$i+1]['OtherIncome']), (1/($i+1)))-1)*100;
                        }else{
                            $cagr_OtherIncome = NULL;
                        }
                        if(($plDetails[0]['TotalIncome'] != "NULL") && ($plDetails[$i+1]['TotalIncome'] != "NULL") && ($plDetails[0]['TotalIncome'] > 0) && ($plDetails[$i+1]['TotalIncome'] > 0)){
                            $cagr_TotalIncome = (pow(($plDetails[0]['TotalIncome'] / $plDetails[$i+1]['TotalIncome']), (1/($i+1)))-1)*100;
                        }else{
                            $cagr_TotalIncome = NULL;
                        }
                        if(($plDetails[0]['OptnlAdminandOthrExp'] != "NULL") && ($plDetails[$i+1]['OptnlAdminandOthrExp'] != "NULL") && ($plDetails[0]['OptnlAdminandOthrExp'] > 0) && ($plDetails[$i+1]['OptnlAdminandOthrExp'] > 0)){ 
                            $cagr_OptnlAdminandOthrExp = (pow(($plDetails[0]['OptnlAdminandOthrExp'] / $plDetails[$i+1]['OptnlAdminandOthrExp']), (1/($i+1)))-1)*100; 
                        }else{
                            $cagr_OptnlAdminandOthrExp = NULL;
                        } 
                        if(($plDetails[0]['OptnlProfit'] != "NULL") && ($plDetails[$i+1]['OptnlProfit'] != "NULL") && ($plDetails[0]['OptnlProfit'] > 0) && ($plDetails[$i+1]['OptnlProfit'] > 0)){
                            $cagr_OptnlProfit = (pow(($plDetails[0]['OptnlProfit'] / $plDetails[$i+1]['OptnlProfit']), (1/($i+1)))-1)*100;
                        }else{
                            $cagr_OptnlProfit = NULL;
                        }
                        if(($plDetails[0]['EBITDA'] != "NULL") && ($plDetails[$i+1]['EBITDA'] != "NULL") && ($plDetails[0]['EBITDA'] > 0) && ($plDetails[$i+1]['EBITDA'] > 0)){
                            $cagr_EBITDA = (pow(($plDetails[0]['EBITDA'] / $plDetails[$i+1]['EBITDA']), (1/($i+1)))-1)*100;
                        }else{
                            $cagr_EBITDA = NULL;
                        } 
                        if(($plDetails[0]['Interest'] != "NULL") && ($plDetails[$i+1]['Interest'] != "NULL") && ($plDetails[0]['Interest'] > 0) && ($plDetails[$i+1]['Interest'] > 0)){
                            $cagr_Interest = (pow(($plDetails[0]['Interest'] / $plDetails[$i+1]['Interest']), (1/($i+1)))-1)*100;  
                        }else{
                            $cagr_Interest = NULL;
                        }
                        if(($plDetails[0]['EBDT'] != "NULL") && ($plDetails[$i+1]['EBDT'] != "NULL") && ($plDetails[0]['EBDT'] > 0) && ($plDetails[$i+1]['EBDT'] > 0)){ 
                            $cagr_EBDT = (pow(($plDetails[0]['EBDT'] / $plDetails[$i+1]['EBDT']), (1/($i+1)))-1)*100;
                        }else{
                            $cagr_EBDT = NULL;
                        } 
                        if(($plDetails[0]['Depreciation'] != "NULL") && ($plDetails[$i+1]['Depreciation'] != "NULL") && ($plDetails[0]['Depreciation'] > 0) && ($plDetails[$i+1]['Depreciation'] > 0)){
                            $cagr_Depreciation = (pow(($plDetails[0]['Depreciation'] / $plDetails[$i+1]['Depreciation']), (1/($i+1)))-1)*100;
                        }else{
                            $cagr_Depreciation = NULL;
                        }
                        if(($plDetails[0]['EBT'] != "NULL") && ($plDetails[$i+1]['EBT'] != "NULL") && ($plDetails[0]['EBT'] > 0) && ($plDetails[$i+1]['EBT'] > 0)){  
                            $cagr_EBT = (pow(($plDetails[0]['EBT'] / $plDetails[$i+1]['EBT']), (1/($i+1)))-1)*100;
                        }else{
                            $cagr_EBT = NULL;
                        }
                        if(($plDetails[0]['Tax'] != "NULL") && ($plDetails[$i+1]['Tax'] != "NULL") && ($plDetails[0]['Tax'] > 0) && ($plDetails[$i+1]['Tax'] > 0)){   
                            $cagr_Tax = (pow(($plDetails[0]['Tax'] / $plDetails[$i+1]['Tax']), (1/($i+1)))-1)*100;
                        }else{
                            $cagr_Tax = NULL;
                        }
                        if(($plDetails[0]['PAT'] != "NULL") && ($plDetails[$i+1]['PAT'] != "NULL") && ($plDetails[0]['PAT'] > 0) && ($plDetails[$i+1]['PAT'] > 0)){  
                            $cagr_PAT = (pow(($plDetails[0]['PAT'] / $plDetails[$i+1]['PAT']), (1/($i+1)))-1)*100;
                        }else{
                            $cagr_PAT = NULL;
                        }
                        if(($plDetails[0]['BINR'] != "NULL") && ($plDetails[$i+1]['BINR'] != "NULL") && ($plDetails[0]['BINR'] > 0) && ($plDetails[$i+1]['BINR'] > 0)){  
                            $cagr_BINR = (pow(($plDetails[0]['BINR'] / $plDetails[$i+1]['BINR']), (1/($i+1)))-1)*100;
                        }else{
                            $cagr_BINR = NULL;
                        }  
                        if(($plDetails[0]['DINR'] != "NULL") && ($plDetails[$i+1]['DINR'] != "NULL") && ($plDetails[0]['DINR'] > 0) && ($plDetails[$i+1]['DINR'] > 0)){
                            $cagr_DINR = (pow(($plDetails[0]['DINR'] / $plDetails[$i+1]['DINR']), (1/($i+1)))-1)*100; 
                        }else{
                            $cagr_DINR = NULL;
                        }

                        $cagr_details = mysql_query("SELECT CAGR_Id FROM cagr WHERE CId_FK='$cprofile_id' and FY='$FY' order by FY desc" );
                        $cagr_check_count = mysql_num_rows($cagr_details);
                        if($cagr_check_count > 0){
                            $cagr_detail = mysql_fetch_array($cagr_details);
                            $CAGR_Id = $cagr_detail['CAGR_Id'];
                            echo "update cagr set OptnlIncome='$cagr_OptnlIncome',OtherIncome='$cagr_OtherIncome',TotalIncome='$cagr_TotalIncome',OptnlAdminandOthrExp='$cagr_OptnlAdminandOthrExp',OptnlProfit='$cagr_OptnlProfit',EBITDA='$cagr_EBITDA',Interest='$cagr_Interest',EBDT='$cagr_EBDT',Depreciation='$cagr_Depreciation',EBT='$cagr_EBT',Tax='$cagr_Tax',PAT='$cagr_PAT',BINR='$cagr_BINR',DINR='$cagr_DINR',FY='$FY',CAGRYear='$Year',Updated_date='$Added_Date',IndustryId_FK='$IndustryId_FK',ResultType='$ResultType' where CAGR_Id='$CAGR_Id'";
                            mysql_query("update cagr set OptnlIncome='$cagr_OptnlIncome',OtherIncome='$cagr_OtherIncome',TotalIncome='$cagr_TotalIncome',OptnlAdminandOthrExp='$cagr_OptnlAdminandOthrExp',OptnlProfit='$cagr_OptnlProfit',EBITDA='$cagr_EBITDA',Interest='$cagr_Interest',EBDT='$cagr_EBDT',Depreciation='$cagr_Depreciation',EBT='$cagr_EBT',Tax='$cagr_Tax',PAT='$cagr_PAT',BINR='$cagr_BINR',DINR='$cagr_DINR',FY='$FY',CAGRYear='$Year',Updated_date='$Added_Date',IndustryId_FK='$IndustryId_FK',ResultType='$ResultType' where CAGR_Id='$CAGR_Id'");
                        }else{
                            echo "insert into cagr (OptnlIncome,OtherIncome,TotalIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,BINR,DINR,FY,CAGRYear,Added_Date,IndustryId_FK,ResultType,CId_FK) values ('$cagr_OptnlIncome','$cagr_OtherIncome','$cagr_TotalIncome','$cagr_OptnlAdminandOthrExp','$cagr_OptnlProfit','$cagr_EBITDA','$cagr_Interest', '$cagr_EBDT','$cagr_Depreciation','$cagr_EBT','$cagr_Tax','$cagr_PAT','$cagr_BINR','$cagr_DINR','$FY','$Year','$Added_Date','$IndustryId_FK','$ResultType','$cprofile_id')";
                            mysql_query("insert into cagr (OptnlIncome,OtherIncome,TotalIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,BINR,DINR,FY,CAGRYear,Added_Date,IndustryId_FK,ResultType,CId_FK) values ('$cagr_OptnlIncome','$cagr_OtherIncome','$cagr_TotalIncome','$cagr_OptnlAdminandOthrExp','$cagr_OptnlProfit','$cagr_EBITDA','$cagr_Interest', '$cagr_EBDT','$cagr_Depreciation','$cagr_EBT','$cagr_Tax','$cagr_PAT','$cagr_BINR','$cagr_DINR','$FY','$Year','$Added_Date','$IndustryId_FK','$ResultType','$cprofile_id')");
                        }
                    }
                }
            }
        }
        
        echo "Companies details imported successfully";
    }else{
        $to = "arun@ventureintelligence.in";
        $subject = "File not found";
        $txt = "No files!!!";
        $headers = "From: Test";
        mail($to,$subject,$txt,$headers);
        exit;        
    }
  //  header("Location:upload.php");
//}
?>