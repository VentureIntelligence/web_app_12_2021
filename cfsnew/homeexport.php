<?php
    include "header.php";
    include "sessauth.php";
    require_once MODULES_DIR."plstandard.php";
    $plstandard = new plstandard();
    require_once MODULES_DIR."balancesheet.php";
    $balancesheet = new balancesheet();
    require_once MODULES_DIR."growthpercentage.php";
    $growthpercentage = new growthpercentage();
    require_once MODULES_DIR."cagr.php";
    $cagr = new cagr();
    require_once MODULES_DIR."cprofile.php";
    $cprofile = new cprofile();
    require_once MODULES_DIR."industries.php";
    $industries = new industries();
    require_once MODULES_DIR."sectors.php";
    $sectors = new sectors();
    require_once MODULES_DIR."city.php";
    $city = new city();
    require_once MODULES_DIR."countries.php";
    $countries = new countries();
    include_once('conversionarray.php');
    $currency=$_REQUEST['currency'];
    function updateDownload($res){
        //Added By JFR-KUTUNG - Download Limit
        $recCount = count($res);
        $dlogUserEmail = $_SESSION['UserEmail'];
        $today = date('Y-m-d');

        //Check Existing Entry
       $sqlSelCount = "SELECT `recDownloaded`  FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='CFS' AND `downloadDate` = CURRENT_DATE";
       $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
       $rowSelCount = mysql_num_rows($sqlSelResult);
       $rowSel = mysql_fetch_object($sqlSelResult);
       $downloads = $rowSel->recDownloaded;

    //   if(is_null($downloads))
    //    $downloads=0;
       $dloguser_id = $_SESSION['user_id'];

       if ($rowSelCount > 0){
           $upDownloads = $recCount + $downloads;
             $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' , user_id='".$dloguser_id."'    WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='CFS' AND `downloadDate` = CURRENT_DATE";
           $resUdt = mysql_query($sqlUdt) or die(mysql_error());
       }else{
             $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('".$dloguser_id."','".$dlogUserEmail."','".$today."','CFS','".$recCount."')";
           mysql_query($sqlIns) or die(mysql_error());
       }
    } 
    
        
    $exportsql = stripslashes($_REQUEST['exportexcel']);
    $exportsql1 = stripslashes($_REQUEST['exportexcel1']);
    $exportsql2 = stripslashes($_REQUEST['exportexcel2']);
    
   
    if($exportsql !='')
        $ExportResult = $plstandard->ExporttoExcel($exportsql);
    elseif($exportsql1)
        $ExportResult = $growthpercentage->ExporttoExcel($exportsql1);
    elseif($exportsql2)
        $ExportResult = $cagr->ExporttoExcel($exportsql2);
    
    $resultcount=count($ExportResult);
    $filters=$_REQUEST['filters'];
    $filtervalue=rtrim($filters,",");
    
       
    $to    = 'krishna.s@praniontech.com';
    $from 	= 'info@ventureintelligence.in';
    $subject 	= "CFS bulk export"; // Subject of the email
    //Message
    $message .= 'Please find the details below:';

    $message 	.= "<p></p>";

    $message 	.="<table style='border-spacing: 0px;'>
    <tr><th style='padding: 3px 6px;border: 1px solid #cccfcf;'>User Emailid </th>
    <th style='padding: 3px 6px;border: 1px solid #cccfcf;'>No of rows</th>
    <th style='padding: 3px 6px;border: 1px solid #cccfcf;'>Filters used</th></tr>";
    $message 	.="<tr><td style='border: 1px solid #cccfcf;'>".$_SESSION['UserEmail']."</td><td style='border: 1px solid #cccfcf;'>".$resultcount."</td><td style='border: 1px solid #cccfcf;'>".$filtervalue."</td></tr>";
    $message 	.="</table>";
    $headers  = 'MIME-Version: 1.0' . "\r\n";
		    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		    $headers .= 'From: VI Admin <info@ventureintelligence.in>' . "\r\n";
		    $headers .= "Reply-To: no-reply@ventureintelligence.com\r\n";
		    $headers .= 'Cc:  vijayakumar.k@praniontech.com' . "\r\n";   
        if (@mail($to, $subject, $message, $headers)){
        }else{
        }
    
    
    
    updateDownload($ExportResult);
    
    function movetabs($fytabs){
    $rval = "";
    for($i=0;$i<$fytabs;$i++){
         
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         
         
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         
         $rval .= ""."\t";
           if($i>10){  break; }
    }
    
    return $rval;
            
}

   /* echo '<pre>';
    print_r($ExportResult);
    echo '</pre>';die;*/
    
  //  
    //pr(implode(',',$_REQUEST['answer']['CCompanies']));
	//pr($ExportResult);
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=cfsexport.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
        
        $sep = "\t"; //tabbed character
        //print("\n");
        $currFY = Date('y');
	echo "Company Name"."\t";
    echo "CIN Number"."\t";
        echo "Brand Name"."\t";
        echo "Industry"."\t";
	echo "Sector"."\t";
    echo "NAICS Code"."\t";
        echo "Entity Type"."\t";
       // echo "Status"."\t";
        echo "Transaction Status"."\t";
        echo "Year Founded"."\t";
        echo "Business Description"."\t";
        echo "Address"."\t";
        echo "City"."\t";
        echo "Country"."\t";
        echo "Telephone"."\t";
        echo "Contact Name"."\t";
        echo "Designation"."\t";
        echo "Auditor Name"."\t";
        echo "Email"."\t";
        echo "Website"."\t";
       // echo "Year Founded"."\t";
        for($i=$currFY;$i>=6;$i--){
            
            echo "FY".$i."\t";
             
             
            echo "Revenue (cr)"."\t";
            echo "EBIDTA(cr)"."\t";
            echo "EBDT(cr)"."\t";
            echo "EBT(cr)"."\t";
            echo "PAT(cr)"."\t";
             echo "Opertnl Income(cr)"."\t";
            echo "Interest(cr)"."\t";
            
            echo 'Share Capital'."\t";
            echo 'Reserves & Surplus'."\t";
            echo 'Long-Term Borrowing'."\t";
            echo 'Short-Term Borrowing'."\t";
            echo 'Total Current Liabilities'."\t";
            echo 'Total Fixed Assets'."\t";
            echo 'Cash and Bank Balance'."\t";
            echo 'Total Current Assets'."\t";
            echo 'Inventory'."\t";
            echo 'Total Assets'."\t";
            echo 'Trade receivables'."\t";
            echo 'Trade payables'."\t";
            echo 'Total Liabilities'."\t";
            
            
            
        }
        
        print("\n");

        //print("\n");
	$flag = false; 
        $schema_insert = "";
       
        $previousCompId = '';
        $currentFY = $currFY;
    
	foreach($ExportResult as $row) { 
            
            if ($previousCompId!=$row[1]){
                $fyDiff = $currFY-$row[9];
                $previousCompId=$row[1];
                $schema_insert .= ""."\n";
                $currentFY = $row[9];
                $company_name = preg_replace("/\s+/", " ", $row[12]);
                $schema_insert .= trim($company_name).$sep; //Company Name
                // $schema_insert .= $row[19].$sep; // CIN Number
                // $brand = preg_replace("/\s+/", " ", $row[17]);
                // $schema_insert .= trim($brand).$sep; //Brand

                $cin = trim($row[19]);
                $cin = preg_replace("/\r\n|\r|\n/",'<br/>',$cin);
                $cin = preg_replace("/\s+/", " ", $cin);
                $cin =  str_replace($replace_array, '', $cin);
                $schema_insert .= trim(stripslashes($cin)).$sep;//Brand

                $brand = trim($row[17]);
                $brand = preg_replace("/\r\n|\r|\n/",'<br/>',$brand);
                $brand = preg_replace("/\s+/", " ", $brand);
                $brand =  str_replace($replace_array, '', $brand);
                $schema_insert .= trim(stripslashes($brand)).$sep;//Brand

                $where5 = " Industry_Id= ".$row[2];
                $order5="";
                $compdetail = $industries->getsingleIndustries($where5,$order5);
                //print_r($compdetail);
                $industry="";
                $industry=$compdetail[0];
                $schema_insert .= $industry.$sep; //Industry

                $where6 = "Sector_Id= ".$row[18];
                $order6="";
                $sectordetail = $sectors->getsingleSectors($where6,$order6);
                //print_r($sectordetail);
                $sectorname="";
                $sectorname=$sectordetail[0];
                $schema_insert .= $sectorname.$sep; //sector
                $naicsdetail = $sectors->getSectorsNaicsCode($where6,$order6);
                $naicsCode=$naicsdetail[0];
                $schema_insert .= $naicsCode.$sep; //NAICS Code

                $where6 = " Company_Id = ".$row[11];
                $comdetail = $cprofile->getcomdetails_allfiled($where6);

               // print_r($comdetail);die;
                foreach($comdetail as $comdetails)
                    {
                        //Entity Type
                        if($comdetails['listingstatus']==1)
                        {
                            $schema_insert .= 'Listed'.$sep;
                        }
                        elseif($comdetails['listingstatus']==2)
                        {
                            $schema_insert .= 'UnListed'.$sep;
                        }
                        elseif($comdetails['listingstatus']==3)
                        {
                            $schema_insert .= 'Partnership'.$sep;
                        }
                        elseif($comdetails['listingstatus']==4)
                        {
                            $schema_insert .= 'Proprietorship'.$sep;
                        }else{
                            $schema_insert .= $sep;
                        }
                        //Transaction status
                        if($comdetails['permission1']==0)
                        {
                            $schema_insert .= 'PE Backed'.$sep;
                        }
                        elseif($comdetails['permission1']==1)
                        {
                            $schema_insert .= 'Non-PE Backed'.$sep;
                        }
                        else{
                            $schema_insert .= $sep;
                        }
                        // elseif($comdetails['permission1']==2){

                        //     $schema_insert .= 'Non-Transacted and Fund Raising'.$sep;
                        // }

                        $where7 = " city_id = ".$comdetails['city'];
                        $getcity = $city->getsinglecity($where7);

                         $schema_insert .= trim($comdetails['IncorpYear']).$sep;//year found
                         $replace_array = array('\t','\n','<br>','<br/>','<br />','\r','\v');
                         /*$BusinessDesc =  str_replace($replace_array, ' ', $comdetails['BusinessDesc']);
                         $BusinessDesc1 = nl2br($BusinessDesc);
                         $BusinessDesc =  trim(str_replace($replace_array, '', $BusinessDesc1));*/
                         $BusinessDesc = preg_replace("/\r\n|\r|\n/",'<br/>',$comdetails['BusinessDesc']);
                         $BusinessDesc =  str_replace($replace_array, '', $BusinessDesc);
                         $BusinessDesc = preg_replace("/\s+/", " ", $BusinessDesc);
                         $schema_insert .= trim(stripslashes($BusinessDesc)).$sep;//BusinessDesc
                         $AddressHead = trim($comdetails['AddressHead']);
                         $AddressHead = preg_replace("/\s+/", " ", $AddressHead);
                         $AddressHead = preg_replace("/\r\n|\r|\n/",'<br/>',$AddressHead);
                         $AddressHead =  str_replace($replace_array, '', $AddressHead);
                         $AddressLine2 = trim($comdetails['AddressLine2']);
                         $AddressLine2 = preg_replace("/\s+/", " ", $AddressLine2);
                         $AddressLine2 = preg_replace("/\r\n|\r|\n/",'<br/>',$AddressLine2);
                         $AddressLine2 =  str_replace($replace_array, '', $AddressLine2);
                         $Address = trim((stripslashes($AddressHead).','.stripslashes($AddressLine2)),',');
                         $schema_insert .= trim(stripslashes($Address)).$sep;//Address
                         $schema_insert .= trim($getcity[0]).$sep; //city
                        $where7 = " Country_Id = ".$comdetails['AddressCountry'];
                        $getcountry = $countries->getsinglecountry($where7);
                         $schema_insert .= $getcountry[0].$sep;//Country

                         // $schema_insert .= trim($comdetails['Phone']).$sep;  //Phone
                         // $schema_insert .= trim($comdetails['CEO']).$sep;  //Contact person
                         // $schema_insert .= trim($comdetails['CFO']).$sep;  //designation
                         // $schema_insert .= trim($comdetails['auditor_name']).$sep;  //auditor_name
                         // $schema_insert .= trim($comdetails['Email']).$sep;  //Email

                         $Phone = trim($comdetails['Phone']);
                         $Phone = preg_replace("/\r\n|\r|\n/",'<br/>',$Phone);
                         $Phone = preg_replace("/\s+/", " ", $Phone);
                         $Phone =  str_replace($replace_array, '', $Phone);
                         $schema_insert .= trim(stripslashes($Phone)).$sep;//Phone

                         $CEO = trim($comdetails['CEO']);
                         $CEO = preg_replace("/\r\n|\r|\n/",'<br/>',$CEO);
                         $CEO = preg_replace("/\s+/", " ", $CEO);
                         $CEO =  str_replace($replace_array, '', $CEO);
                         $schema_insert .= trim(stripslashes($CEO)).$sep;//Contact person

                         $CFO = trim($comdetails['CFO']);
                         $CFO = preg_replace("/\r\n|\r|\n/",'<br/>',$CFO);
                         $CFO = preg_replace("/\s+/", " ", $CFO);
                         $CFO =  str_replace($replace_array, '', $CFO);
                         $schema_insert .= trim(stripslashes($CFO)).$sep;//designation

                         $auditor_name = trim($comdetails['auditor_name']);
                         $auditor_name = preg_replace("/\r\n|\r|\n/",'<br/>',$auditor_name);
                         $auditor_name = preg_replace("/\s+/", " ", $auditor_name);
                         $auditor_name =  str_replace($replace_array, '', $auditor_name);
                         $schema_insert .= trim(stripslashes($auditor_name)).$sep;//auditor_name

                         $Email = trim($comdetails['Email']);
                         $Email = preg_replace("/\r\n|\r|\n/",'<br/>',$Email);
                         $Email = preg_replace("/\s+/", " ", $Email);
                         $Email =  str_replace($replace_array, '', $Email);
                         $schema_insert .= trim(stripslashes($Email)).$sep;//Email

                         $schema_insert .= trim($comdetails['website']).$sep;  //website
                         //$schema_insert .= $comdetails['IncorpYear'].$sep;
                    }
            
            }else{
                $fyDiff = ($currentFY-$row[9])-1;
                $currentFY = $row[9];
            }
            
//            if ($fyDiff > 0)
//                $schema_insert .= movetabs($fyDiff);    
            
               
                 $compid =$row[1];
                 $resultType =$row[10];
                // $q= mysql_query("SELECT EBITDA,PAT,TotalIncome,FY FROM `plstandard` WHERE `CId_FK` ='$compid' ORDER BY FY DESC LIMIT 9");
                  $q= mysql_query("SELECT p.EBITDA,p.PAT,p.TotalIncome,p.FY, b.ShareCapital,b.ReservesSurplus,b.L_term_borrowings,b.S_term_borrowings,b.T_current_liabilities,b.T_fixed_assets,b.Cash_bank_balances,b.T_current_assets,p.EBDT,p.EBT,p.OptnlIncome,p.Interest,b.Inventories,b.Total_assets,b.Trade_receivables,b.Trade_payables,b.T_equity_liabilities FROM plstandard p  LEFT JOIN balancesheet_new b  ON b.CID_FK=p.CID_FK  WHERE p.FY = b.FY and p.CId_FK ='$compid' and p.ResultType='$resultType' group BY p.FY ORDER BY p.FY DESC LIMIT 9");

                 $currentFYr = Date('y');
                 $a=1;
                 $currentFormatedYear=0;
                 $skipnextyear = false;
                 
                 while ($pl=mysql_fetch_array($q)){                

               $yearstr=$pl['FY'];
              
               if(preg_match('/\(/',$yearstr)){
                   
                   $year = substr($yearstr, 0, 2);
               }
               else if(preg_match('/[a-zA-Z]/',$yearstr)){
                   
                  $year = substr($yearstr,-2);
               }
               else{
                    $year = $yearstr;
                   
               }
               $FYyearnew = explode(' ',$year);
                $diff = $currentFYr-$FYyearnew[0];  
               
               if($skipnextyear){
                    $skipnextyear = false;
                    if($FYyearnew[0] == $currentFormatedYear){
                        continue;
                    }
                }

               //print_r($FYyearnew);
                if($FYyearnew[2] != '' || $FYyearnew[1] != ''){
                    $skipnextyear = true;
                    $currentFormatedYear = $FYyearnew[0];
                } else {
                    $skipnextyear = false;
                }

               // echo "-$year";
                if($a==1){
                    $currentFYr=$FYyearnew[0]; 
                    $a++;                    
                }                
          // echo "$diff-";
                if($diff>0){
                    
                $schema_insert.= movetabs($diff); 
                $currentFYr=$FYyearnew[0];
                }    
                
                
               $schema_insert .= $pl['FY'].$sep;
               // total income
               $total_income=$pl['TotalIncome'];
                    /*if($exportsql !='')
                    {*/
                        if($total_income=="")
                        {
                            $schema_insert .= $sep;
                        }
                        else
                        {
//                            if($total_income<100000){
//                                $roundDigit = 4;
//                            }else{
//                                $roundDigit = 2;                               
//                            }
                            if($currency == "INR"){
                                $revenue=$total_income/10000000;
                                $revenueincr=round($revenue, 2);
                            }else if($currency == "USD"){
                                $revenue=($total_income/$yearcurrency[$pl['FY']])/1000000;
                                $revenueincr=round($revenue, 2);
                            }
                          //  $revenueincr = ($revenueincr==0) ? "" : $revenueincr;
                            $schema_insert .= $revenueincr.$sep;
                        }

                    /*}
                    else
                    {
                        $total_income = ($total_income==0) ? "" : $total_income;
                        $schema_insert .= $total_income.$sep;
                    }*/
                    // ebitda
                    if ($pl['EBITDA']=='' || $pl['EBITDA'] == 0){
                        $schema_insert .= $sep;
                    }else{
                        $EBIDTA = $pl['EBITDA'];
                        if($currency == "INR"){
                            $EBIDTAdiv=$EBIDTA/10000000;
                            $EBIDTAcr=round($EBIDTAdiv, 2);
                        }else if($currency == "USD"){
                            $EBIDTAdiv=($EBIDTA/$yearcurrency[$pl['FY']])/1000000;
                            $EBIDTAcr=round($EBIDTAdiv, 2);
                        }
                       // $EBIDTAcr = ($EBIDTAcr==0) ? "" : $EBIDTAcr;
                        $schema_insert .= $EBIDTAcr.$sep;
                    }
                    //EBDT
                    
                    $EBDT=$pl['EBDT'];
                    if ($pl['EBDT']=="" || $pl['EBDT']==0){
                        $schema_insert .= $sep;
                    }else{
                       /*if($exportsql !='')
                       {*/
                        if($currency == "INR"){
                            $EBDTdiv=$EBDT/10000000;
                            $EBDTcr=round($EBDTdiv, 2);
                        }else if($currency == "USD"){
                            $EBDTdiv=($EBDT/$yearcurrency[$pl['FY']])/1000000;
                            $EBDTcr=round($EBDTdiv, 2);
                        }
                       // $EBDTcr = ($EBDTcr==0) ? "" : $EBDTcr;
                        $schema_insert .= $EBDTcr.$sep;
                       /*}
                       else{
                           $schema_insert .= $EBDT.$sep;
                       }*/
                    }
                    
                    //EBT
                    
                    $EBT=$pl['EBT'];
                    if ($pl['EBT']=="" || $pl['EBT']==0){
                        $schema_insert .= $sep;
                    }else{
                       /*if($exportsql !='')
                       {*/
                        if($currency == "INR"){
                            $EBTdiv = $EBT/10000000;
                            $EBTcr = round($EBTdiv, 2);
                        }else if($currency == "USD"){
                            $EBTdiv = ($EBT/$yearcurrency[$pl['FY']])/1000000;
                            $EBTcr = round($EBTdiv, 2);
                        }
                      //  $EBTcr = ($EBTcr==0) ? "" : $EBTcr;
                        $schema_insert .= $EBTcr.$sep;
                       /*}
                       else{
                           $schema_insert .= $EBT.$sep;
                       }*/
                    }
                    //pat
                    $PAT=$pl['PAT'];
                    if ($pl['PAT']=="" || $pl['PAT']==0){
                        $schema_insert .= $sep;
                    }else{
                       /*if($exportsql !='')
                       {*/
                        if($currency == "INR"){
                            $PATdiv=$PAT/10000000;
                            $PATcr=round($PATdiv, 2);
                        }else if($currency == "USD"){
                            $PATdiv=($PAT/$yearcurrency[$pl['FY']])/1000000;
                            $PATcr=round($PATdiv, 2);
                        }
                       // $PATcr = ($PATcr==0) ? "" : $PATcr;
                        $schema_insert .= $PATcr.$sep;
                       /*}
                       else{
                           $schema_insert .= $PAT.$sep;
                       }*/
                    }
                    //Optional Income
                    
                    $OptnlIncome=$pl['OptnlIncome'];
                    if ($pl['OptnlIncome']=="" || $pl['OptnlIncome']==0){
                        $schema_insert .= $sep;
                    }else{
                       /*if($exportsql !='')
                       {*/
                        if($currency == "INR"){
                            $OptnlIncomediv = $OptnlIncome/10000000;
                            $OptnlIncomecr = round($OptnlIncomediv, 2);
                        }else if($currency == "USD"){
                            $OptnlIncomediv = ($OptnlIncome/$yearcurrency[$pl['FY']])/1000000;
                            $OptnlIncomecr = round($OptnlIncomediv, 2);
                        }
                     //   $OptnlIncomecr = ($OptnlIncomecr==0) ? "" : $OptnlIncomecr;
                        $schema_insert .= $OptnlIncomecr.$sep;
                       /*}
                       else{
                           $schema_insert .= $OptnlIncome.$sep;
                       }*/
                    }
                    
                     //Interest
                    
                    $Interest=$pl['Interest'];
                    if ($pl['Interest']=="" || $pl['Interest']==0){
                        $schema_insert .= $sep;
                    }else{
                       /*if($exportsql !='')
                       {*/
                        if($currency == "INR"){
                            $Interestdiv = $Interest/10000000;
                            $Interestcr = round($Interestdiv, 2);
                        }else if($currency == "USD"){
                            $Interestdiv = ($Interest/$yearcurrency[$pl['FY']])/1000000;
                            $Interestcr = round($Interestdiv, 2);
                        }
                      //  $Interestcr = ($Interestcr==0) ? "" : $Interestcr;
                        $schema_insert .= $Interestcr.$sep;
                       /*}
                       else{
                           $schema_insert .= $Interest.$sep;
                       }*/
                    }
                    
                    
                   //////////////////balance sheet/////////////////////////////
               // /*
                
                //Share Capital
                 $ShareCapital=$pl['ShareCapital'];
                if ($pl['ShareCapital']=="" || $pl['ShareCapital']==0){
                    $schema_insert .= $sep;
                }else{
                   /*if($exportsql !='')
                   {*/
                    if($currency == "INR"){
                        $ShareCapitaldiv=$ShareCapital/10000000;
                        $ShareCapitalcr=round($ShareCapitaldiv, 2);
                    }else if($currency == "USD"){
                        $ShareCapitaldiv=($ShareCapital/$yearcurrency[$pl['FY']])/1000000;
                        $ShareCapitalcr=round($ShareCapitaldiv, 2);
                    }
                 //   $ShareCapitalcr = ($ShareCapitalcr==0) ? "" : $ShareCapitalcr;
                    $schema_insert .= $ShareCapitalcr.$sep;
                   /*}
                   else{
                       $schema_insert .= $ShareCapital.$sep;
                   }*/
                }
                
                
                
                
                //Reserves & Surplus
                $ReSu=$pl['ReservesSurplus'];
                if ($pl['ReservesSurplus']=="" || $pl['ReservesSurplus']==0){
                    $schema_insert .= $sep;
                }else{
                   /*if($exportsql !='')
                   {*/
                    if($currency == "INR"){
                        $ReSudiv=$ReSu/10000000;
                        $ReSucr=round($ReSudiv, 2);
                    }else if($currency == "USD"){
                        $ReSudiv=($ReSu/$yearcurrency[$pl['FY']])/1000000;
                        $ReSucr=round($ReSudiv, 2);
                    }
                   // $ReSucr = ($ReSucr==0) ? "" : $ReSucr;
                    $schema_insert .= $ReSucr.$sep;
                   /*}
                   else{
                       $schema_insert .= $ReSu.$sep;
                   }*/
                }
                
                
                
                //Long-Term Borrowing 
                $LTB=$pl['L_term_borrowings'];
                if ($pl['L_term_borrowings']=="" || $pl['L_term_borrowings']==0){
                    $schema_insert .= $sep;
                }else{
                   /*if($exportsql !='')
                   {*/
                    if($currency == "INR"){
                        $LTBdiv=$LTB/10000000;
                        $LTBcr=round($LTBdiv, 2);
                    }else if($currency == "USD"){
                        $LTBdiv=($LTB/$yearcurrency[$pl['FY']])/1000000;
                        $LTBcr=round($LTBdiv, 2);
                    }
                //    $LTBcr = ($LTBcr==0) ? "" : $LTBcr;
                    $schema_insert .= $LTBcr.$sep;
                   /*}
                   else{
                       $schema_insert .= $LTB.$sep;
                   }*/
                }
                
                
                // Short-Term Borrowing
                $STB=$pl['S_term_borrowings'];
                if ($pl['S_term_borrowings']=="" || $pl['S_term_borrowings']==0){
                    $schema_insert .= $sep;
                }else{
                   /*if($exportsql !='')
                   {*/
                    if($currency == "INR"){
                        $STBdiv=$STB/10000000;
                        $STBcr=round($STBdiv, 2);
                    }else if($currency == "USD"){
                        $STBdiv=($STB/$yearcurrency[$pl['FY']])/1000000;
                        $STBcr=round($STBdiv, 2);
                    }
                 //   $STBcr = ($STBcr==0) ? "" : $STBcr;
                    $schema_insert .= $STBcr.$sep;
                   /*}
                   else{
                       $schema_insert .= $STB.$sep;
                   }*/
                }
                
                
                
                // Total Current Liabilities
                $TCL=$pl['T_current_liabilities'];
                if ($pl['T_current_liabilities']=="" || $pl['T_current_liabilities']==0){
                    $schema_insert .= $sep;
                }else{
                   /*if($exportsql !='')
                   {*/
                    if($currency == "INR"){
                        $TCLdiv=$TCL/10000000;
                        $TCLcr=round($TCLdiv, 2);
                    }else if($currency == "USD"){
                        $TCLdiv=($TCL/$yearcurrency[$pl['FY']])/1000000;
                        $TCLcr=round($TCLdiv, 2);
                    }
                   // $TCLcr = ($TCLcr==0) ? "" : $TCLcr;
                    $schema_insert .= $TCLcr.$sep;
                   /*}
                   else{
                       $schema_insert .= $TCL.$sep;
                   }*/
                }
                
                
                
                
                // Total Fixed Assets
                $TFA=$pl['T_fixed_assets'];
                if ($pl['T_fixed_assets']=="" || $pl['T_fixed_assets']==0){
                    $schema_insert .= $sep;
                }else{
                   /*if($exportsql !='')
                   {*/
                    if($currency == "INR"){
                        $TFAdiv=$TFA/10000000;
                        $TFAcr=round($TFAdiv, 2);
                    }else if($currency == "USD"){
                        $TFAdiv=($TFA/$yearcurrency[$pl['FY']])/1000000;
                        $TFAcr=round($TFAdiv, 2);
                    }
                 //   $TFAcr = ($TFAcr==0) ? "" : $TFAcr;
                    $schema_insert .= $TFAcr.$sep;
                   /*}
                   else{
                       $schema_insert .= $TFA.$sep;
                   }*/
                }
                
                
                
                //Cash and Bank Balance
                $CBB=$pl['Cash_bank_balances'];
                if ($pl['Cash_bank_balances']=="" || $pl['Cash_bank_balances']==0){
                    $schema_insert .= $sep;
                }else{
                   /*if($exportsql !='')
                   {*/
                    if($currency == "INR"){
                        $CBBdiv=$CBB/10000000;
                        $CBBcr=round($CBBdiv, 2);
                    }else if($currency == "USD"){
                        $CBBdiv=($CBB/$yearcurrency[$pl['FY']])/1000000;
                        $CBBcr=round($CBBdiv, 2);
                    }
                  //  $CBBcr = ($CBBcr==0) ? "" : $CBBcr;
                    $schema_insert .= $CBBcr.$sep;
                   /*}
                   else{
                       $schema_insert .= $CBB.$sep;
                   }*/
                }
                
                
                
                //Total Current Assets
                $TCA=$pl['T_current_assets'];
                if ($pl['T_current_assets']=="" || $pl['T_current_assets']==0){
                    $schema_insert .= $sep;
                }else{
                   /*if($exportsql !='')
                   {*/
                    if($currency == "INR"){
                        $TCAdiv=$TCA/10000000;
                        $TCAcr=round($TCAdiv, 2);
                    }else if($currency == "USD"){
                        $TCAdiv=($TCA/$yearcurrency[$pl['FY']])/1000000;
                        $TCAcr=round($TCAdiv, 2);
                    }
                 //   $TCAcr = ($TCAcr==0) ? "" : $TCAcr;
                    $schema_insert .= $TCAcr.$sep;
                   /*}
                   else{
                       $schema_insert .= $TCA.$sep;
                   }*/
                }
                
                //Inventories
                $Inventories=$pl['Inventories'];
                if ($pl['Inventories']=="" || $pl['Inventories']==0){
                    $schema_insert .= $sep;
                }else{
                   /*if($exportsql !='')
                   {*/
                    if($currency == "INR"){
                        $Inventoriesdiv=$Inventories/10000000;
                        $Inventoriescr=round($Inventoriesdiv, 2);
                    }else if($currency == "USD"){
                        $Inventoriesdiv=($Inventories/$yearcurrency[$pl['FY']])/1000000;
                        $Inventoriescr=round($Inventoriesdiv, 2);
                    }
                  //  $Inventoriescr = ($Inventoriescr==0) ? "" : $Inventoriescr;
                    $schema_insert .= $Inventoriescr.$sep;
                   /*}
                   else{
                       $schema_insert .= $Inventories.$sep;
                   }*/
                }
                
                //Total Assets
                $TA=$pl['Total_assets'];
                if ($pl['Total_assets']=="" || $pl['Total_assets']==0){
                    $schema_insert .= $sep;
                }else{
                   /*if($exportsql !='')
                   {*/
                    if($currency == "INR"){
                        $TAdiv=$TA/10000000;
                        $TAcr=round($TAdiv, 2);
                    }else if($currency == "USD"){
                        $TAdiv=($TA/$yearcurrency[$pl['FY']])/1000000;
                        $TAcr=round($TAdiv, 2);
                    }
                    //  $TAcr = ($TAcr==0) ? "" : $TAcr;
                    $schema_insert .= $TAcr.$sep;
                   /*}
                   else{
                       $schema_insert .= $TA.$sep;
                   }*/
                }
                
                //Trade receivables
                $TR=$pl['Trade_receivables'];
                if ($pl['Trade_receivables']=="" || $pl['Trade_receivables']==0){
                    $schema_insert .= $sep;
                }else{
                   /*if($exportsql !='')
                   {*/
                    if($currency == "INR"){
                        $TRdiv=$TR/10000000;
                        $TRcr=round($TRdiv, 2);
                    }else if($currency == "USD"){
                        $TRdiv=($TR/$yearcurrency[$pl['FY']])/1000000;
                        $TRcr=round($TRdiv, 2);
                    }
                //    $TRcr = ($TRcr==0) ? "" : $TRcr;
                    $schema_insert .= $TRcr.$sep;
                   /*}
                   else{
                       $schema_insert .= $TR.$sep;
                   }*/
                }
                
                //Trade payables
                $TP=$pl['Trade_payables'];
                if ($pl['Trade_payables']=="" || $pl['Trade_payables']==0){
                    $schema_insert .= $sep;
                }else{
                   /*if($exportsql !='')
                   {*/
                    if($currency == "INR"){
                        $TPdiv=$TP/10000000;
                        $TPcr=round($TPdiv, 2);
                    }else if($currency == "USD"){
                        $TPdiv=($TP/$yearcurrency[$pl['FY']])/1000000;
                        $TPcr=round($TPdiv, 2);
                    }
                  //  $TPcr = ($TPcr==0) ? "" : $TPcr;
                    $schema_insert .= $TPcr.$sep;
                   /*}
                   else{
                       $schema_insert .= $TP.$sep;
                   }*/
                }
                
                //TotalLiabilities - Total equity liabilities
                $TEL=$pl['T_equity_liabilities'];
                if ($pl['T_equity_liabilities']=="" || $pl['T_equity_liabilities']==0){
                    $schema_insert .= $sep;
                }else{
                   /*if($exportsql !='')
                   {*/
                    if($currency == "INR"){
                        $TELdiv=$TEL/10000000;
                        $TELcr=round($TELdiv, 2);
                    }else if($currency == "USD"){
                        $TELdiv=($TEL/$yearcurrency[$pl['FY']])/1000000;
                        $TELcr=round($TELdiv, 2);
                    }
                  //  $TELcr = ($TELcr==0) ? "" : $TELcr;
                    $schema_insert .= $TELcr.$sep;
                   /*}
                   else{
                       $schema_insert .= $TEL.$sep;
                   }*/
                }
                
               // */        
                   
           
           $currentFYr--;
                 }
	} 
        print(trim($schema_insert));
        print "\n";
         mysql_close();
	exit;
   
        

        
?>