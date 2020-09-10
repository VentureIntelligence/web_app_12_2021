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
             $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' , user_id='".$dloguser_id."'   WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='CFS' AND `downloadDate` = CURRENT_DATE";
           $resUdt = mysql_query($sqlUdt) or die(mysql_error());
       }else{
             $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('".$dloguser_id."','".$dlogUserEmail."','".$today."','CFS','".$recCount."')";
           mysql_query($sqlIns) or die(mysql_error());
       }
    } 
    
        
    $exportsql = stripslashes($_REQUEST['exportexcel']);
    $exportsql1 = stripslashes($_REQUEST['exportexcel1']);
    $exportsql2 = stripslashes($_REQUEST['exportexcel2']);
    
    //echo  "1-".$exportsql; exit;
//    echo  "2-".$exportsql1;
//    echo  "3-".$exportsql2;
//    exit;
    
    
    if($exportsql !='')
        $ExportResult = $plstandard->ExporttoExcel($exportsql);
    elseif($exportsql1)
        $ExportResult = $growthpercentage->ExporttoExcel($exportsql1);
    elseif($exportsql2)
        $ExportResult = $cagr->ExporttoExcel($exportsql2);
    
    
    
    updateDownload($ExportResult);
    /*echo '<pre>';
    print_r($ExportResult);
    echo '</pre>';
    exit;*/
    
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
    echo "CIN"."\t";
        echo "Industry"."\t";
	echo "Sector"."\t";
    echo "NAICS Code"."\t";
        echo "Entity Type"."\t";
        echo "Transaction Status"."\t";
        echo "City"."\t";
        echo "Website"."\t";
        
        
          echo "Date of Charge"."\t";
           echo "Charge Amount"."\t";
            echo "Charge Holder"."\t";
            
            
            
        for($i=$currFY;$i>=6;$i--){
            echo "Revenue (cr)"."\t";
            echo "EBIDTA(cr)"."\t";
            echo "PAT(cr)"."\t";
            echo "EBDT(cr)"."\t";
            echo "EBT(cr)"."\t";
            echo "FY".$i."\t";
        }
        
       
        print("\n");

        //print("\n");
	$flag = false; 
        $schema_insert = "";
        //print_r($ExportResult);
        $previousCompId = '';
        $currentFY = $currFY;
    
	foreach($ExportResult as $row) { 
            
            if ($previousCompId!=$row[1+4]){
                $fyDiff = $currFY-$row[9+4];
                $previousCompId=$row[1+4];
                $schema_insert .= ""."\n";
                $currentFY = $row[9+4];
                $schema_insert .= $row[12+4].$sep;
                $schema_insert .= $row[0].$sep;
            
                $where5 = " Industry_Id= ".$row[2+4];
                $order5="";
                $compdetail = $industries->getsingleIndustries($where5,$order5);
                //print_r($compdetail);
                $industry="";
                $industry=$compdetail[0];
                $schema_insert .= $industry.$sep;

                $where6 = "Sector_Id= ".$row[18+4];
                $order6="";
                $sectordetail = $sectors->getsingleSectors($where6,$order6);
                //print_r($sectordetail);
                $sectorname="";
                $sectorname=$sectordetail[0];
                $schema_insert .= $sectorname.$sep; //sector
                $naicsdetail = $sectors->getSectorsNaicsCode($where6,$order6);
                $naicsCode=$naicsdetail[0];
                $schema_insert .= $naicsCode.$sep; //NAICS Code

                $where6 = " Company_Id = ".$row[4];
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
                            $schema_insert .= 'PE Backed'.$sep;
                        }
                        elseif($comdetails['permission1']==1)
                        {
                            $schema_insert .= 'Non-PE Backed'.$sep;
                        }
                        // elseif($comdetails['permission1']==2){

                        //     $schema_insert .= 'Non-Transacted and Fund Raising'.$sep;
                        // }

                        $where7 = " city_id = ".$comdetails['city'];
                        $getcity = $city->getsinglecity($where7);

                         $schema_insert .= $getcity[0].$sep;
                         $schema_insert .= $comdetails['website'].$sep;
                         
                        
                         
                         
                    }
            
            }else{
                $fyDiff = ($currentFY-$row[9+4])-1;
                $currentFY = $row[9+4];
            }
                        $chargeamount = round(str_replace(',', '', $row[2]))/10000000;
                        
                        $schema_insert .= $row[1].$sep; // charge Date
                        $schema_insert .= $chargeamount.$sep; // charge Amount
                        $schema_insert .= stripslashes(strip_tags(str_replace("\n","",$row[3]))).$sep;                         // charge holder
                       
                        //
//            if ($fyDiff > 0)
//                $schema_insert .= movetabs($fyDiff);    
           
                    
                 $compid =$row[4];
                 //$q= mysql_query("SELECT EBITDA,PAT,EBDT,EBT,TotalIncome,FY FROM `plstandard` WHERE `CId_FK` ='$compid' ORDER BY FY DESC LIMIT 9");
                 $q= mysql_query("SELECT p.EBITDA,p.PAT,p.TotalIncome,p.FY, b.ShareCapital,b.ReservesSurplus,b.L_term_borrowings,b.S_term_borrowings,b.T_current_liabilities,b.T_fixed_assets,b.Cash_bank_balances,b.T_current_assets,p.EBDT,p.EBT,p.OptnlIncome,p.Interest,b.Inventories,b.Total_assets,b.Trade_receivables,b.Trade_payables,b.T_equity_liabilities FROM plstandard p  LEFT JOIN balancesheet_new b  ON b.CID_FK=p.CID_FK  WHERE p.FY = b.FY and p.CId_FK ='$compid' and p.ResultType='0' group BY p.FY ORDER BY p.FY DESC LIMIT 9");
                 $currentFYr = Date('y');
                 $a=1;
                 while ($pl=mysql_fetch_array($q)){
                 
           //for($i=$currFY;$i>=6;$i--)
//           if($currFY==$pl['FY']) { }
//           else { $schema_insert .=movetabs(1);}
           
           $diff = $currentFYr-$pl['FY'];         
           
                if($a==1) { $currentFYr=$pl['FY']; $a++; }
                
           $schema_insert.= movetabs($diff);    
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
                            $revenue=$total_income/10000000;
                            $revenueincr=round($revenue, 2);
                            $revenueincr = ($revenueincr==0) ? "" : $revenueincr;
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
                        $EBIDTA = $pl['EBITDA'].$sep;;
                        $EBIDTAdiv=$EBIDTA/10000000;
                        $EBIDTAcr=round($EBIDTAdiv, 2);
                        $EBIDTAcr = ($EBIDTAcr==0) ? "" : $EBIDTAcr;
                        $schema_insert .= $EBIDTAcr.$sep;
                    }

                    //pat
                    $PAT=$pl['PAT'];
                    if ($pl['PAT']=="" || $pl['PAT']==0){
                        $schema_insert .= $sep;
                    }else{
                       /*if($exportsql !='')
                       {*/
                        $PATdiv=$PAT/10000000;
                        $PATcr=round($PATdiv, 2);
                        $PATcr = ($PATcr==0) ? "" : $PATcr;
                        $schema_insert .= $PATcr.$sep;
                       /*}
                       else{
                           $schema_insert .= $PAT.$sep;
                       }*/
                    }
                    
                    //EBDT
                    
                    $EBDT=$pl['EBDT'];
                    if ($pl['EBDT']=="" || $pl['EBDT']==0){
                        $schema_insert .= $sep;
                    }else{
                       /*if($exportsql !='')
                       {*/
                        $EBDTdiv=$EBDT/10000000;
                        $EBDTcr=round($EBDTdiv, 2);
                        $EBDTcr = ($EBDTcr==0) ? "" : $EBDTcr;
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
                        $EBTdiv = $EBT/10000000;
                        $EBTcr = round($EBTdiv, 2);
                        $EBTcr = ($EBTcr==0) ? "" : $EBTcr;
                        $schema_insert .= $EBTcr.$sep;
                       /*}
                       else{
                           $schema_insert .= $EBT.$sep;
                       }*/
                    }

                    $schema_insert .= $pl['FY'].$sep;
           
           $currentFYr--;
                 }
                 
                 
                
	} 
        
        print(trim($schema_insert));
        print "\n";
         
	exit;
   
        
function movetabs($fytabs){
    $rval = "";
    for($i=0;$i<$fytabs;$i++){
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         $rval .= ""."\t";
         
          if($i>15){  break; }
    
    }
    
  
    
    return $rval;
            
}
        
?>