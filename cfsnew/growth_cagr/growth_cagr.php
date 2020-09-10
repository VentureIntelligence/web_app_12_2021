<?php
error_reporting(0);
//live
$dbhost = "localhost";
$dbuser = "venture_admin16";
$dbpassword = "V@dm!n2016";
$dbname = "venture_peinvestments";
$dbhandle = mysql_connect($dbhost, $dbuser, $dbpassword) 
  or die("Unable to connect to MySQL");
$selected = mysql_select_db($dbname,$dbhandle) 
  or die("Database could not select");
    //company upload    
    $added_date = date('Y-m-d H:i:s');
    $date = date('ymdHis');
    $cin = 'L65910KL1992PLC006623'; //id - 16932
   // $cin = 'U74899DL1992PTC049361'; //id-57
   // $cin = 'U24232AP2001PLC036097';    //id-1011
    if(!empty($cin)){
        $cin_check = mysql_query("SELECT Company_Id,Industry FROM cprofile WHERE CIN='$cin'" );
        $cin_check_count = mysql_num_rows($cin_check);
        if($cin_check_count > 0){
            $cin_res = mysql_fetch_array($cin_check);
            $cprofile_id = $cin_res['Company_Id'];
            $pl_details = mysql_query("SELECT * FROM plstandard WHERE CId_FK='$cprofile_id' order by FY desc" );
            $pl_check_count = mysql_num_rows($pl_details);
            if($pl_check_count > 0){
                $i=0;
                while($pl_detail = mysql_fetch_array($pl_details)){
                        $plDetails[] = $pl_detail;
                }
                for($i=0;$i<$pl_check_count-1;$i++){ 
                    $FY  = ereg_replace("[^0-9]", "", $plDetails[$i]['FY']);
                    $Year = $i+1;
                    $Added_Date = date("Y-m-d:H:i:s");
                    $IndustryId_FK = $cin_res['Industry'];
                    $ResultType = $plDetails[$i]['ResultType'];
                    if($plDetails[$i]['IndustryId_FK'] == 0){
                        mysql_query("update plstandard set IndustryId_FK='$IndustryId_FK' where CId_FK='$cprofile_id'");
                    }
                    
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
                       // echo "update growthpercentage set OptnlIncome='$growth_OptnlIncome',OtherIncome='$growth_OtherIncome',TotalIncome='$growth_TotalIncome',OptnlAdminandOthrExp='$growth_OptnlAdminandOthrExp',OptnlProfit='$growth_OptnlProfit',EBITDA='$growth_EBITDA',Interest='$growth_Interest',EBDT='$growth_EBDT',Depreciation='$growth_Depreciation',EBT='$growth_EBT',Tax='$growth_Tax',PAT='$growth_PAT',BINR='$growth_BINR',DINR='$growth_DINR',FY='$FY',GrowthYear='$Year',Updated_date='$Added_Date',IndustryId_FK='$IndustryId_FK',ResultType='$ResultType' where GrowthPerc_Id='$GrowthPerc_Id'";
                        mysql_query("update growthpercentage set OptnlIncome='$growth_OptnlIncome',OtherIncome='$growth_OtherIncome',TotalIncome='$growth_TotalIncome',OptnlAdminandOthrExp='$growth_OptnlAdminandOthrExp',OptnlProfit='$growth_OptnlProfit',EBITDA='$growth_EBITDA',Interest='$growth_Interest',EBDT='$growth_EBDT',Depreciation='$growth_Depreciation',EBT='$growth_EBT',Tax='$growth_Tax',PAT='$growth_PAT',BINR='$growth_BINR',DINR='$growth_DINR',FY='$FY',GrowthYear='$Year',Updated_date='$Added_Date',IndustryId_FK='$IndustryId_FK',ResultType='$ResultType' where GrowthPerc_Id='$GrowthPerc_Id'");
                    }else{
                       // echo "insert into growthpercentage (OptnlIncome,OtherIncome,TotalIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,BINR,DINR,FY,GrowthYear,Added_Date,IndustryId_FK,ResultType,CId_FK) values ('$growth_OptnlIncome','$growth_OtherIncome','$growth_TotalIncome','$growth_OptnlAdminandOthrExp','$growth_OptnlProfit','$growth_EBITDA','$growth_Interest', '$growth_EBDT','$growth_Depreciation','$growth_EBT','$growth_Tax','$growth_PAT','$growth_BINR','$growth_DINR','$FY','$Year','$Added_Date','$IndustryId_FK','$ResultType','$cprofile_id')";
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
                       // echo "insert into cagr (OptnlIncome,OtherIncome,TotalIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,BINR,DINR,FY,CAGRYear,Added_Date,IndustryId_FK,ResultType,CId_FK) values ('$cagr_OptnlIncome','$cagr_OtherIncome','$cagr_TotalIncome','$cagr_OptnlAdminandOthrExp','$cagr_OptnlProfit','$cagr_EBITDA','$cagr_Interest', '$cagr_EBDT','$cagr_Depreciation','$cagr_EBT','$cagr_Tax','$cagr_PAT','$cagr_BINR','$cagr_DINR','$FY','$Year','$Added_Date','$IndustryId_FK','$ResultType','$cprofile_id')";
                        mysql_query("insert into cagr (OptnlIncome,OtherIncome,TotalIncome,OptnlAdminandOthrExp,OptnlProfit,EBITDA,Interest,EBDT,Depreciation,EBT,Tax,PAT,BINR,DINR,FY,CAGRYear,Added_Date,IndustryId_FK,ResultType,CId_FK) values ('$cagr_OptnlIncome','$cagr_OtherIncome','$cagr_TotalIncome','$cagr_OptnlAdminandOthrExp','$cagr_OptnlProfit','$cagr_EBITDA','$cagr_Interest', '$cagr_EBDT','$cagr_Depreciation','$cagr_EBT','$cagr_Tax','$cagr_PAT','$cagr_BINR','$cagr_DINR','$FY','$Year','$Added_Date','$IndustryId_FK','$ResultType','$cprofile_id')");
                    }
                }
            }            
        }
    }
?>