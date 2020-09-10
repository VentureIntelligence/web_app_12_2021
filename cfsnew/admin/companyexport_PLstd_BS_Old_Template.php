<?php
    session_start();session_save_path("/tmp");
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
    
        
    //All Company list
    //$exportsql = stripslashes("SELECT a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY as FY, a.ResultType, b.Company_Id, b.FCompanyName,b.ListingStatus,a.TotalIncome as TotalIncome,b.FYCount AS FYValue,b.Permissions1, b.SCompanyName, b.Industry, b.Sector FROM plstandard a ,cprofile b WHERE a.CId_FK = b.Company_Id and a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK)  GROUP BY  b.SCompanyName ORDER BY FIELD(a.FY,'16') DESC,FIELD(a.FY,'15') DESC, a.FY DESC, b.SCompanyName asc");   
    //Transacted Company list
   // $exportsql = stripslashes("SELECT a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY as FY, a.ResultType, b.Company_Id, b.FCompanyName,b.ListingStatus,a.TotalIncome as TotalIncome,b.FYCount AS FYValue,b.Permissions1, b.SCompanyName, b.Industry, b.Sector FROM plstandard a ,cprofile b WHERE a.CId_FK = b.Company_Id and b.Permissions1=0 and a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK)  GROUP BY  b.SCompanyName ORDER BY FIELD(a.FY,'16') DESC,FIELD(a.FY,'15') DESC, a.FY DESC, b.SCompanyName asc");
    
     //Fy year 2010 to 2006 Company list
      for($i=10;$i>= 10-4;$i--){
        $where .= " a.FY like '$i%' or ";
        if($i != 10){
            $j = '0'.$i;
            $where .= " a.FY like '$j%' or ";            
        }
    }
    $where = '('.trim($where,'or ').')';
    $exportsql = stripslashes("SELECT a.PLStandard_Id, a.CId_FK, a.IndustryId_FK,a.OptnlIncome,a.EBITDA,a.EBDT ,a.EBT,a.Tax,a.PAT ,a.FY as FY, a.ResultType, b.Company_Id, b.FCompanyName,b.ListingStatus,a.TotalIncome as TotalIncome,b.FYCount AS FYValue,b.Permissions1, b.SCompanyName, b.Industry, b.Sector, b.CIN FROM plstandard a ,cprofile b WHERE a.CId_FK = b.Company_Id and b.Permissions1=0 and $where and a.FY=(SELECT max(aa.FY) as MFY FROM plstandard aa WHERE aa.CId_FK=a.CId_FK)  GROUP BY  b.SCompanyName ORDER BY FIELD(a.FY,'16') DESC,FIELD(a.FY,'15') DESC, a.FY DESC, b.SCompanyName asc");
     
        $ExportResult = $plstandard->ExporttoExcel($exportsql);
    
  //  updateDownload($ExportResult);
       
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

    /*echo '<pre>';
    print_r($ExportResult);
    echo '</pre>';*/
    
  //  
    //pr(implode(',',$_REQUEST['answer']['CCompanies']));
	//pr($ExportResult);
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=cfsexport.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
        
        $sep = "\t"; //tabbed character
        print("\n");
        $currFY = Date('y');
	echo "Company Name"."\t";
	echo "CIN"."\t";
        echo "Brand Name"."\t";
        echo "Industry"."\t";
	echo "Sector"."\t";
        echo "Entity Type"."\t";
        echo "Transaction Status"."\t";
        echo " Year Founded "."\t";
        echo "City"."\t";
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
            
            echo 'Paid-up share capital'."\t";
            echo 'Share application money pending allotment'."\t";
            echo 'Reserves & Surplus'."\t";
            echo 'Shareholders funds(total)'."\t";
            echo 'Secured loans'."\t";
            echo 'Unsecured loans'."\t";
            echo 'Loan funds(total)'."\t";
            echo 'Other Liabilities'."\t";
            echo 'Deferred Tax Liability'."\t";
            echo 'TOTAL SOURCES OF FUNDS'."\t";
            echo 'Gross Block'."\t";
            echo 'Less : Depreciation Reserve'."\t";
            echo 'Net Block'."\t";
            echo 'Add : Capital Work in Progress'."\t";
            echo 'Fixed Assets(total)'."\t";
            echo 'Intangible Assets(total)'."\t";            
            echo 'Other Non-Current Assets'."\t";
            echo 'Investments'."\t";
            echo 'Deferred Tax Assets'."\t";
            echo 'Sundry Debtors'."\t";
            echo 'Cash & Bank Balances'."\t";
            echo 'Inventories'."\t";
            echo 'Loans & Advances'."\t";
            echo 'Other Current Assets'."\t";
            echo 'Current Assets, Loans & Advances(total)'."\t";
            echo 'Current Liabilities'."\t";
            echo 'Provisions'."\t";
            echo 'Current Liabilities & Provisions(total)'."\t";
            echo 'Net Current Assets'."\t";
            echo 'Profit & Loss Account'."\t";
            echo 'Miscellaneous Expenditure '."\t";
            echo 'TOTAL APPLICATION OF FUNDS'."\t";
            
            
            
        }
        
        print("\n");

        print("\n");
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
                $schema_insert .= $row[12].$sep;
                $schema_insert .= $row[20].$sep;
                $schema_insert .= $row[17].$sep;
                $where5 = " Industry_Id= ".$row[2];
                $order5="";
                $compdetail = $industries->getsingleIndustries($where5,$order5);
                //print_r($compdetail);
                $industry="";
                $industry=$compdetail[0];
                $schema_insert .= $industry.$sep;

                $where6 = "Sector_Id= ".$row[19];
                $order6="";
                $sectordetail = $sectors->getsingleSectors($where6,$order6);
                //print_r($sectordetail);
                $sectorname="";
                $sectorname=$sectordetail[0];
                $schema_insert .= $sectorname.$sep;

                $where6 = " Company_Id = ".$row[11];
                $comdetail = $cprofile->getcomdetails($where6);

                foreach($comdetail as $comdetails)
                    {


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
                        }

                        if($comdetails['permission1']==0)
                        {
                            $schema_insert .= 'Transacted'.$sep;
                        }
                        elseif($comdetails['permission1']==1)
                        {
                            $schema_insert .= 'Non-Transacted'.$sep;
                        }
                        elseif($comdetails['permission1']==2){

                            $schema_insert .= 'Non-Transacted and Fund Raising'.$sep;
                        }

                        $where7 = " city_id = ".$comdetails['city'];
                        $getcity = $city->getsinglecity($where7);

                         $schema_insert .= $comdetails['IncorpYear'].$sep;
                         $schema_insert .= $getcity[0].$sep;
                         $schema_insert .= $comdetails['website'].$sep;
                         //$schema_insert .= $comdetails['IncorpYear'].$sep;
                    }
            
            }else{
                $fyDiff = ($currentFY-$row[9])-1;
                $currentFY = $row[9];
            }
            
//            if ($fyDiff > 0)
//                $schema_insert .= movetabs($fyDiff);    
            
               
                 $compid =$row[1];
                 $q= mysql_query("SELECT p.EBITDA,p.PAT,p.TotalIncome,p.FY, p.EBDT,p.EBT,p.OptnlIncome,p.Interest, b.ShareCapital, b.ShareApplication, b.ReservesSurplus, b.TotalFunds, b.SecuredLoans, b.UnSecuredLoans, b.LoanFunds, b.OtherLiabilities, b.DeferredTax, b.SourcesOfFunds, b.GrossBlock, b.LessAccumulated, b.NetBlock, b.CapitalWork, b.FixedAssets, b.IntangibleAssets, b.OtherNonCurrent, b.Investments, b.DeferredTaxAssets, b.SundryDebtors, b.CashBankBalances, b.Inventories, b.LoansAdvances, b.OtherCurrentAssets, b.CurrentAssets, b.CurrentLiabilities, b.Provisions, b.CurrentLiabilitiesProvision, b.NetCurrentAssets, b.ProfitLoss, b.Miscellaneous, b.TotalAssets FROM plstandard p  LEFT JOIN balancesheet b  ON b.CID_FK=p.CID_FK and p.FY = b.FY  WHERE p.CId_FK ='$compid' and p.ResultType='0' group BY p.FY ORDER BY p.FY DESC");
                 $currentFYr = Date('y');
                 $a=1;
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
                $diff = $currentFYr-$year;  
               
               // echo "-$year";
                if($a==1){
                    $currentFYr=$year; 
                    $a++;                    
                }                
          // echo "$diff-";
                if($diff>0){
                    
                $schema_insert.= movetabs($diff); 
                }    
                
                
               $schema_insert .= $pl['FY'].$sep;
               // total income
               $total_income=$pl['TotalIncome'];
                    if($exportsql !='')
                    {
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
                            $revenue=$total_income/10000000;
                            $revenueincr=round($revenue, 2);
                          //  $revenueincr = ($revenueincr==0) ? "" : $revenueincr;
                            $schema_insert .= $revenueincr.$sep;
                        }

                    }
                    else
                    {
                        $total_income = ($total_income==0) ? "" : $total_income;
                        $schema_insert .= $total_income.$sep;
                    }
                    // ebitda
                    if ($pl['EBITDA']=='' || $pl['EBITDA'] == 0){
                        $schema_insert .= $sep;
                    }else{
                        $EBIDTA = $pl['EBITDA'];
                        $EBIDTAdiv=$EBIDTA/10000000;
                        $EBIDTAcr=round($EBIDTAdiv, 2);
                       // $EBIDTAcr = ($EBIDTAcr==0) ? "" : $EBIDTAcr;
                        $schema_insert .= $EBIDTAcr.$sep;
                    }
                    //EBDT
                    
                    $EBDT=$pl['EBDT'];
                    if ($pl['EBDT']=="" || $pl['EBDT']==0){
                        $schema_insert .= $sep;
                    }else{
                       if($exportsql !='')
                       {
                        $EBDTdiv=$EBDT/10000000;
                        $EBDTcr=round($EBDTdiv, 2);
                       // $EBDTcr = ($EBDTcr==0) ? "" : $EBDTcr;
                        $schema_insert .= $EBDTcr.$sep;
                       }
                       else{
                           $schema_insert .= $EBDT.$sep;
                       }
                    }
                    
                    //EBT
                    
                    $EBT=$pl['EBT'];
                    if ($pl['EBT']=="" || $pl['EBT']==0){
                        $schema_insert .= $sep;
                    }else{
                       if($exportsql !='')
                       {
                        $EBTdiv = $EBT/10000000;
                        $EBTcr = round($EBTdiv, 2);
                      //  $EBTcr = ($EBTcr==0) ? "" : $EBTcr;
                        $schema_insert .= $EBTcr.$sep;
                       }
                       else{
                           $schema_insert .= $EBT.$sep;
                       }
                    }
                    //pat
                    $PAT=$pl['PAT'];
                    if ($pl['PAT']=="" || $pl['PAT']==0){
                        $schema_insert .= $sep;
                    }else{
                       if($exportsql !='')
                       {
                        $PATdiv=$PAT/10000000;
                        $PATcr=round($PATdiv, 2);
                       // $PATcr = ($PATcr==0) ? "" : $PATcr;
                        $schema_insert .= $PATcr.$sep;
                       }
                       else{
                           $schema_insert .= $PAT.$sep;
                       }
                    }
                    //Optional Income
                    
                    $OptnlIncome=$pl['OptnlIncome'];
                    if ($pl['OptnlIncome']=="" || $pl['OptnlIncome']==0){
                        $schema_insert .= $sep;
                    }else{
                       if($exportsql !='')
                       {
                        $OptnlIncomediv = $OptnlIncome/10000000;
                        $OptnlIncomecr = round($OptnlIncomediv, 2);
                     //   $OptnlIncomecr = ($OptnlIncomecr==0) ? "" : $OptnlIncomecr;
                        $schema_insert .= $OptnlIncomecr.$sep;
                       }
                       else{
                           $schema_insert .= $OptnlIncome.$sep;
                       }
                    }
                    
                     //Interest
                    
                    $Interest=$pl['Interest'];
                    if ($pl['Interest']=="" || $pl['Interest']==0){
                        $schema_insert .= $sep;
                    }else{
                       if($exportsql !='')
                       {
                        $Interestdiv = $Interest/10000000;
                        $Interestcr = round($Interestdiv, 2);
                      //  $Interestcr = ($Interestcr==0) ? "" : $Interestcr;
                        $schema_insert .= $Interestcr.$sep;
                       }
                       else{
                           $schema_insert .= $Interest.$sep;
                       }
                    }
                    
                    
                   //////////////////balance sheet/////////////////////////////
               // /*
                
                //Share Capital
                 $ShareCapital=$pl['ShareCapital'];
                if ($pl['ShareCapital']=="" || $pl['ShareCapital']==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $ShareCapitaldiv=$ShareCapital/10000000;
                    $ShareCapitalcr=round($ShareCapitaldiv, 2);
                 //   $ShareCapitalcr = ($ShareCapitalcr==0) ? "" : $ShareCapitalcr;
                    $schema_insert .= $ShareCapitalcr.$sep;
                   }
                   else{
                       $schema_insert .= $ShareCapital.$sep;
                   }
                }
                
                //Share application money pending allotment
                 $data_val =$pl['ShareApplication'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                 //   $ShareCapitalcr = ($ShareCapitalcr==0) ? "" : $ShareCapitalcr;
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Reserves & Surplus
                $ReSu=$pl['ReservesSurplus'];
                if ($pl['ReservesSurplus']=="" || $pl['ReservesSurplus']==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $ReSudiv=$ReSu/10000000;
                    $ReSucr=round($ReSudiv, 2);
                   // $ReSucr = ($ReSucr==0) ? "" : $ReSucr;
                    $schema_insert .= $ReSucr.$sep;
                   }
                   else{
                       $schema_insert .= $ReSu.$sep;
                   }
                }
                
                //Shareholders' funds(total)
                 $data_val =$pl['TotalFunds'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Secured loans
                 $data_val =$pl['SecuredLoans'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Unsecured loans
                 $data_val =$pl['UnSecuredLoans'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Loan funds(total)
                 $data_val =$pl['LoanFunds'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Other Liabilities
                 $data_val =$pl['OtherLiabilities'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Deferred Tax Liability
                 $data_val =$pl['DeferredTax'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //TOTAL SOURCES OF FUNDS
                 $data_val =$pl['SourcesOfFunds'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Gross Block
                 $data_val =$pl['GrossBlock'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Less : Depreciation Reserve
                 $data_val =$pl['LessAccumulated'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Net Block
                 $data_val =$pl['NetBlock'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Add : Capital Work in Progress
                 $data_val =$pl['CapitalWork'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Fixed Assets(total)
                 $data_val =$pl['FixedAssets'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Intangible Assets(total)
                 $data_val =$pl['IntangibleAssets'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Other Non-Current Assets
                 $data_val =$pl['OtherNonCurrent'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Investments
                 $data_val =$pl['Investments'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Deferred Tax Assets
                 $data_val =$pl['DeferredTaxAssets'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Sundry Debtors
                 $data_val =$pl['SundryDebtors'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Cash & Bank Balances
                 $data_val =$pl['CashBankBalances'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Inventories
                 $data_val =$pl['Inventories'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Loans & Advances
                 $data_val =$pl['LoansAdvances'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Other Current Assets
                 $data_val =$pl['OtherCurrentAssets'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Current Assets, Loans & Advances(total)
                 $data_val =$pl['CurrentAssets'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Current Liabilities
                 $data_val =$pl['CurrentLiabilities'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Provisions
                 $data_val =$pl['Provisions'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Current Liabilities & Provisions(total)
                 $data_val =$pl['CurrentLiabilitiesProvision'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Net Current Assets
                 $data_val =$pl['NetCurrentAssets'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Profit & Loss Account
                 $data_val =$pl['ProfitLoss'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //Miscellaneous Expenditure 
                 $data_val =$pl['Miscellaneous'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                //TOTAL APPLICATION OF FUNDS
                 $data_val =$pl['TotalAssets'];
                if ($data_val=="" || $data_val==0){
                    $schema_insert .= $sep;
                }else{
                   if($exportsql !='')
                   {
                    $data_valdiv=$data_val/10000000;
                    $data_valcr=round($data_valdiv, 2);
                    $schema_insert .= $data_valcr.$sep;
                   }
                   else{
                       $schema_insert .= $data_val.$sep;
                   }
                }
                
                
                
                
               // */        
                   
           
           $currentFYr--;
                 }
	} 
        print(trim($schema_insert));
        print "\n";
         
	exit;
   
        

        
?>