<?php
$dbhost = "localhost";
$dbuser = "venture_admin16";
$dbpassword = "V@dm!n2016";
$dbname = "venture_peinvestments";
$dbhandle = mysql_connect($dbhost, $dbuser, $dbpassword) 
  or die("Unable to connect to MySQL");
$selected = mysql_select_db($dbname,$dbhandle) 
  or die("Database could not select");

    //company upload    
    $date = date('ymdHis');
    //$c_outfile = "csv/cprofile_all_new_company.csv";
    //$c_outfile = "csv/cprofile_all.csv";
    $c_outfile = "csv/new_company1.csv";
    $new_c_outfile = "csv/cprofile_all".$date.".csv";
    if(file_exists($c_outfile)){
        echo "SELECT start_id,total_cnt FROM test order by id desc";
                    $result12 = mysql_query("SELECT start_id,total_cnt FROM test order by id desc");
                    if(mysql_num_rows($result12) >0){
                        $res = mysql_fetch_array($result12);
                        $start = $res['start_id']+$res['total_cnt'];
                    }else{
                        $start = 1;
                    }
                    $end = $start+700;
        $to = "saranya@kutung.in";
        $subject = "File started cprofile";
        $txt = "Started successfully !!! started @ $start";
        $headers = "From: Test";

        mail($to,$subject,$txt,$headers);
        
        ////// Sheet Name - Company Profile ///////////////
        $file = fopen($c_outfile, "r");
        $count = 0; 
        $flag_add = $flag_update = 0;
        while (($cprofile = fgetcsv($file, 10000, ",")) !== FALSE) { //print_r($cprofile);
            $count++;
            if($count>$start && $count <= $end){ //print_r($cprofile);
                echo "count--".$count;echo "<br/>";
           echo     $cin = $cprofile[46];   //CIN              
                // Duplicate check /
                if(!empty($cin)){
                    $added_date = date('Y-m-d H:i:s');
                    $sname = trim(addslashes($cprofile[1]));   //SCompanyName
                    $fname = trim(addslashes($cprofile[2]));  //FCompanyName
                    $g_status = trim($cprofile[3]);   //GroupCStaus
                    $ParentCompany = trim($cprofile[4]);  //ParentCompany
                    $FormerlyCalled = trim($cprofile[5]);   //FormerlyCalled
                    $permission1 = trim($cprofile[6]);    //Permissions1
                    $UserStatus = trim($cprofile[7]);    //UserStatus
                    $Industry = trim($cprofile[8]);    //Industry
                    $Sector = trim(addslashes($cprofile[9]));    //Sector
                    $sub_sector = trim(addslashes($cprofile[10]));    // SubSector
                    $BusinessDesc = trim(addslashes($cprofile[11]));  //BusinessDesc
                    $Brands = trim($cprofile[12]);    //Brands
                    $Country = trim($cprofile[13]);    //Country
                    $RegionId_FK = trim($cprofile[14]);    //RegionId_FK
                    $IncorpYear = trim($cprofile[15]);    //IncorpYear
                    $lstatus = trim($cprofile[16]);   //ListingStatus
                    $StockBSE = trim($cprofile[17]);    //StockBSE
                    $StockNSE = trim($cprofile[18]);    //StockNSE
                    $IPODate = trim($cprofile[19]);    //IPODate
                    $address_head = trim(addslashes($cprofile[20]));  //AddressHead
                    $AddressLine2 = trim(addslashes($cprofile[21]));  //AddressLine2
                    $City = trim(addslashes($cprofile[22]));  //City
                    $State = trim(addslashes($cprofile[23]));  //State
                    $Pincode = trim($cprofile[24]);  //Pincode
                    $AddressCountry = trim($cprofile[25]);  //AddressCountry
                    $Phone = trim($cprofile[26]);  //Phone
                    $Fax = trim($cprofile[27]);  //Fax
                    $email = trim($cprofile[28]); //Email                
                    $Website = trim($cprofile[29]);  //Website
                    $LinkedIn = trim($cprofile[30]);  //LinkedIn
                    $google_fetched_website = trim($cprofile[31]);  //google_fetched_website                
                    $ceo = trim(addslashes($cprofile[32]));   //Contact Name
                    $Designation = trim($cprofile[33]);  //Designation
                    $Auditor = trim($cprofile[34]); //Auditor
                    $rgthcr = trim($cprofile[35]);  //rgthcr
                    $profile_flag = 1;  //profile flag
                    $added_date;    //Added_Date
                    $DealUrl = trim($cprofile[38]);   //DealUrl
                    $competitorsListed = trim($cprofile[39]);  //competitorsListed
                    $competitorsUnListed = trim($cprofile[40]);  //competitorsUnListed
                    $otherCompareListed = trim($cprofile[41]);  //otherCompareListed
                    $otherCompareUnListed = trim($cprofile[42]);  //otherCompareUnListed
                    $FYCount = trim($cprofile[43]);  //FYCount
                    $GFYCount = trim($cprofile[44]);  //GFYCount
                    $cvid = trim($cprofile[45]);  //cvid
                    $Total_Income_equal_OpIncome = trim($cprofile[47]);  //Total_Income_equal_OpIncome
                    //echo "SELECT * FROM cprofile WHERE CIN='$cin'" ;
                    $cin_check = mysql_query("SELECT * FROM cprofile WHERE CIN='$cin'" );
                    $cin_check_count = mysql_num_rows($cin_check);
                    if($cin_check_count>0){
                        $cin_res = mysql_fetch_array($cin_check);
                        $cprofile_id = $cin_res['Company_Id'];
                        $GFY_count = $cin_res['GFYCount'];
                        $FY_Count = $cin_res['FYCount'];
                        //if(!empty($GFY_count)){
                         //   $g_count = $cprofile[43];
                        //}
                        if($sname == ''){
                            $sname = addslashes(stripslashes($cin_res['SCompanyName']));
                        }else if($sname != $cin_res['SCompanyName']){
                            $sname = addslashes(stripslashes($cin_res['SCompanyName']));
                        }
                        if($fname == ''){
                            $fname = addslashes(stripslashes($cin_res['FCompanyName']));
                        }else if($fname != $cin_res['FCompanyName']){
                            $fname = addslashes(stripslashes($cin_res['FCompanyName']));
                        }
                        if($g_status == ''){
                            $g_status = $cin_res['GroupCStaus'];
                        }else{                            
                            if($g_status=="Parent"){
                                $group_status = 1;
                            }else if($g_status=="Subsidiary"){
                                $group_status = 2;
                            }else{
                                $group_status = 3;
                            }
                        }
                        if($ParentCompany == ''){
                            $ParentCompany = $cin_res['ParentCompany'];
                        }
                        if($FormerlyCalled == ''){
                            $FormerlyCalled = $cin_res['FormerlyCalled'];
                        }
                        if($permission1 == ''){
                            $permission = $cin_res['Permissions1'];
                        }else{
                            if($permission1=="Transacted"){
                                $permission = 0;
                            }else if($permission1=="Non Transacted" || $permission1=="Non-Transacted"){
                                $permission = 1;
                            }else{
                                $permission = 2;
                            }
                        }
                        if($UserStatus == ''){
                            $UserStatus = $cin_res['UserStatus'];
                        }
                        if($Industry == ''){
                            $Industry = $cin_res['Industry'];
                        }
                        if($Sector == ''){
                            $Sector = $cin_res['Sector'];
                        }
                        if($sub_sector == ''){
                            $sub_sector = addslashes(stripslashes($cin_res['SubSector']));
                        }
                        if($BusinessDesc == ''){
                            $BusinessDesc = addslashes(stripslashes($cin_res['BusinessDesc']));
                        }
                        if($Brands == ''){
                            $Brands = $cin_res['Brands'];
                        }
                        if($Country == ''){
                            $Country = $cin_res['Country'];
                        }
                        if($RegionId_FK == ''){
                            $RegionId_FK = $cin_res['RegionId_FK'];
                        }
                        if($IncorpYear == ''){
                            $IncorpYear = $cin_res['IncorpYear'];
                        }
                        if($lstatus == ''){
                            $listing_status = $cin_res['ListingStatus'];
                        }else{
                            if($lstatus=="Listed"){
                                $listing_status = 1;
                            }else if($lstatus=="UnListed"){
                                $listing_status = 2;
                            }else if($lstatus=="Partnership"){
                                $listing_status = 3;
                            }else{
                                $listing_status = 4;
                            }
                        }
                        if($StockBSE == ''){
                            $StockBSE = $cin_res['StockBSE'];
                        }
                        if($StockNSE == ''){
                            $StockNSE = $cin_res['StockNSE'];
                        }
                        if($IPODate == ''){
                            $IPODate = $cin_res['IPODate'];
                        }
                        if($address_head == ''){
                            $address_head = addslashes(stripslashes($cin_res['AddressHead']));
                        }
                        if($AddressLine2 == ''){
                            $AddressLine2 = addslashes(stripslashes($cin_res['AddressLine2']));
                        }
                        if($City == ''){
                            $City = $cin_res['City'];
                        }
                        if($State == ''){
                            $State = $cin_res['State'];
                        }
                        if($Pincode == ''){
                            $Pincode = $cin_res['Pincode'];
                        }
                        if($AddressCountry == ''){
                            $AddressCountry = $cin_res['AddressCountry'];
                        }
                        if($Phone == ''){
                            $Phone = $cin_res['Phone'];
                        }
                        if($Fax == ''){
                            $Fax = $cin_res['Fax'];
                        }
                        if($email == ''){
                            $email = $cin_res['Email'];
                        }
                        if($Website == ''){
                            $Website = $cin_res['Website'];
                        }
                        if($LinkedIn == ''){
                            $LinkedIn = $cin_res['LinkedIn'];
                        }
                        if($google_fetched_website == ''){
                            $google_fetched_website = $cin_res['google_fetched_website'];
                        }
                        if($ceo == ''){
                            $ceo = $cin_res['CEO'];
                        }
                        if($Designation == ''){
                            $Designation = $cin_res['CFO'];
                        }
                        if($Auditor == ''){
                            $Auditor = $cin_res['auditor_name'];
                        }
                        if($rgthcr == ''){
                            $rgthcr = $cin_res['rgthcr'];
                        }
                        if($DealUrl == ''){
                            $DealUrl = $cin_res['DealUrl'];
                        }
                        if($competitorsListed == ''){
                            $competitorsListed = $cin_res['competitorsListed'];
                        }
                        if($competitorsUnListed == ''){
                            $competitorsUnListed = $cin_res['competitorsUnListed'];
                        }
                        if($otherCompareListed == ''){
                            $otherCompareListed = $cin_res['otherCompareListed'];
                        }
                        if($otherCompareUnListed == ''){
                            $otherCompareUnListed = $cin_res['otherCompareUnListed'];
                        }
                        if(!empty($FYCount) && $FYCount>0){
                            $f_count = $FYCount;
                        }else{
                            $f_count = $FY_Count;
                        }
                        if(!empty($GFYCount) && $GFYCount>0){
                            $g_count = $GFYCount;
                        }else{
                            $g_count = $GFY_count;
                        }
                        if($cvid == ''){
                            $cvid = $cin_res['cvid'];
                        }
                        if($Total_Income_equal_OpIncome == ''){
                            $Total_Income_equal_OpIncome = $cin_res['Total_Income_equal_OpIncome'];
                        }
                        echo $sql_update = "UPDATE cprofile SET SCompanyName='$sname',FCompanyName='$fname',GroupCStaus='$group_status',ParentCompany='$ParentCompany'
                                        ,FormerlyCalled='$FormerlyCalled',Permissions1='$permission',UserStatus='$UserStatus',Industry='$Industry',Sector='$Sector'
                                        ,SubSector='$sub_sector',BusinessDesc='$BusinessDesc',Brands='$Brands',Country='$Country',RegionId_FK='$RegionId_FK'
                                        ,IncorpYear='$IncorpYear',ListingStatus='$listing_status',StockBSE='$StockBSE',StockNSE='$StockNSE',IPODate='$IPODate'
                                        ,AddressHead='$address_head',AddressLine2='$AddressLine2',City='$City',State='$State',Pincode='$Pincode'
                                        ,AddressCountry='$AddressCountry',Phone='$Phone',Fax='$Fax',Email='$email',Website='$Website',LinkedIn='$LinkedIn'
                                        ,google_fetched_website='$google_fetched_website',CEO='$ceo',CFO='$Designation',auditor_name='$Auditor',rgthcr='$rgthcr'
                                        ,DealUrl='$DealUrl',competitorsListed='$competitorsListed',competitorsUnListed='$competitorsUnListed',otherCompareListed='$otherCompareListed'
                                        ,otherCompareUnListed='$otherCompareUnListed',FYCount='$f_count',GFYCount='$g_count',cvid='$cvid',CIN='$cin'
                                        ,Total_Income_equal_OpIncome='$Total_Income_equal_OpIncome',source_flag=3 WHERE Company_id='$cprofile_id'"; echo "<br/>";
                        $result_insert = mysql_query($sql_update) or die(mysql_error());  
//                        if(!empty($cprofile[1])){
//                            @$flag_update += mysql_affected_rows();                            
//                        } 
                        $flag_update++;

                    }else{     
                        if(empty($fname)){
                            $fname = $sname;
                        }         
                        
                        if($g_status=="Parent"){
                            $group_status = 1;
                        }else if($g_status=="Subsidiary"){
                            $group_status = 2;
                        }else{
                            $group_status = 3;
                        }
                        
                        if($permission1=="Transacted"){
                            $permission = 0;
                        }else if($permission1=="Non Transacted" || $permission1=="Non-Transacted"){
                            $permission = 1;
                        }else{
                            $permission = 2;
                        }
                        
                        if($lstatus=="Listed"){
                            $listing_status = 1;
                        }else if($lstatus=="UnListed"){
                            $listing_status = 2;
                        }else if($lstatus=="Partnership"){
                            $listing_status = 3;
                        }else{
                            $listing_status = 4;
                        }
                    
                        echo  $sql_insert = "INSERT INTO cprofile
                                    (
                                        Company_Id,SCompanyName,FCompanyName,GroupCStaus,ParentCompany,FormerlyCalled,Permissions1,UserStatus,Industry,Sector,SubSector,BusinessDesc
                                        ,Brands,Country,RegionId_FK,IncorpYear,ListingStatus,StockBSE,StockNSE,IPODate,AddressHead,AddressLine2,City,State,Pincode,AddressCountry
                                        ,Phone,Fax,Email,Website,LinkedIn,google_fetched_website,CEO,CFO,auditor_name,rgthcr,Profile_Flag,Added_Date,DealUrl,competitorsListed,competitorsUnListed
                                        ,otherCompareListed,otherCompareUnListed,FYCount,GFYCount,cvid,CIN,Total_Income_equal_OpIncome,source_flag

                                    ) 
                                    VALUES 
                                    (
                                        '','$sname','$fname','$group_status','$ParentCompany','$FormerlyCalled','$permission','$UserStatus','$Industry','$Sector'
                                        ,'$sub_sector','$BusinessDesc','$Brands','$Country','$RegionId_FK','$IncorpYear','$listing_status','$StockBSE','$StockNSE'
                                        ,'$IPODate','$address_head','$AddressLine2','$City','$State','$Pincode','$AddressCountry','$Phone','$Fax'
                                        ,'$email','$Website','$LinkedIn','$google_fetched_website','$ceo','$Designation','$Auditor','$rgthcr','$profile_flag','$added_date'
                                        ,'$DealUrl','$competitorsListed','$competitorsUnListed','$otherCompareListed','$otherCompareUnListed','$FYCount','$GFY_count','$cvid','$cin'
                                        ,'$Total_Income_equal_OpIncome',3
                                    )"; echo "<br/>";
                        $result_insert = mysql_query($sql_insert) or die(mysql_error());
//                        if(!empty($cprofile[1])){
//                            @$flag_add += count($cprofile[1]);                            
//                        }
                        $flag_add++;

                    }
                }
            }
        } 
            $total_cnt = $flag_add + $flag_update;
            
            $consolidate = mysql_query("SELECT b.Company_Id FROM plstandard a ,cprofile b WHERE b.ListingStatus IN (1,2,3,4) and b.Permissions1 IN (0,1) and b.UserStatus = 0 and a.ResultType = 1 and a.CId_FK = b.Company_Id and a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK) GROUP BY b.SCompanyName ORDER BY FIELD(a.FY,'16') DESC,FIELD(a.FY,'15') DESC, a.FY DESC, b.SCompanyName asc");
            $consolidate_cnt = mysql_num_rows($consolidate);
            $standalone = mysql_query("SELECT b.Company_Id FROM plstandard a ,cprofile b WHERE b.ListingStatus IN (1,2,3,4) and b.Permissions1 IN (0,1) and b.UserStatus = 0 and a.ResultType = 0 and a.CId_FK = b.Company_Id and a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK) GROUP BY b.SCompanyName ORDER BY FIELD(a.FY,'16') DESC,FIELD(a.FY,'15') DESC, a.FY DESC, b.SCompanyName asc");
            $standalone_cnt = mysql_num_rows($standalone);
            $total_cos = mysql_query("SELECT Company_Id FROM cprofile ORDER BY FCompanyName asc");
            $total_cos_cnt = mysql_num_rows($total_cos);
            $permissionval = mysql_query("SELECT Company_Id FROM  `cprofile` WHERE  `Permissions1` LIKE  '2'");
            $permissionval_cnt = mysql_num_rows($permissionval);
            
            echo "insert into test (start_id,added_date,insert_cnt,update_cnt,total_cnt,consolidate_cnt,standalone_cnt,total_cos_cnt,permissionval_cnt) values ('$start','$added_date','$flag_add','$flag_update','$total_cnt','$consolidate_cnt','$standalone_cnt','$total_cos_cnt','$permissionval_cnt')";
            mysql_query("insert into test (start_id,added_date,insert_cnt,update_cnt,total_cnt,consolidate_cnt,standalone_cnt,total_cos_cnt,permissionval_cnt) values ('$start','$added_date','$flag_add','$flag_update','$total_cnt','$consolidate_cnt','$standalone_cnt','$total_cos_cnt','$permissionval_cnt')");
                        $_SESSION['msg']['update'] = $flag_update." Companies Updated sucessfully";
                        $_SESSION['msg']['add'] = $flag_add." Companies Added sucessfully";
        print_r($_SESSION['msg']);
        //rename($c_outfile,$new_c_outfile);
        exit;
    }else{
        $to = "saranya@kutung.in";
        $subject = "File not found";
        $txt = "No files!!!";
        $headers = "From: Test";
        mail($to,$subject,$txt,$headers);
        exit;        
    }
?>