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
    
   
    
     $filtered_chargesholdername = $_POST['ChargesholderName'];
     $chargeaddress=$_POST['chargeaddress'];
     $chargefromamount=$_POST['chargefromamount'];
     $chargetoamount=$_POST['chargetoamount'];
     $chargefromdate=$_POST['chargefromdate'];
     $chargetodate=$_POST['chargetodate'];
     $city=$_POST['city'];
     $state=$_POST['state'];
     $cityflag=$_POST['cityflag'];
     if($filtered_chargesholdername !=''){
        if($chargewhere != ''){
            $chargewhere .='    and a1.`Charge Holder` IN  ('.$filtered_chargesholdername.')';
        }else{
            $chargewhere .='    a1.`Charge Holder` IN ('.$filtered_chargesholdername.')';
        }
    }

    // if($filtered_chargesholdername !=''){
    //     if($chargewhere != ''){
    //         $chargewhere .="    and a1.`Charge Holder` LIKE  "."'%".$filtered_chargesholdername."%'";
    //     }else{
    //         $chargewhere .="   a1.`Charge Holder` LIKE "."'%".$filtered_chargesholdername."%'";
    //     }
    //  }
   if($chargefromdate !=""){
     if($chargewhere != ''){
        $chargewhere .="    and  (a1.`Date of Charge` BETWEEN "."'".$chargefromdate."' AND "."'".$chargetodate."' ) ";
    }else{
            $chargewhere .="   (a1.`Date of Charge` BETWEEN "."'".$chargefromdate."' AND "."'".$chargetodate."' ) ";
    }
   }
   if($chargefromamount!=''){
    
    $chargefromamount = $chargefromamount*10000000;
    $chargetoamount = $chargetoamount*10000000;
    
    if($chargetoamount!='' && ($chargefromamount <= $chargetoamount)){
        
        

        if($chargewhere != ''){
                    $chargewhere .="    and ROUND(REPLACE(a1.`Charge amount secured`,',', '')) BETWEEN "."'".$chargefromamount."' AND "."'".$chargetoamount."'  ";
            }else{
                    $chargewhere .="    ROUND(REPLACE(a1.`Charge amount secured`,',', '')) BETWEEN "."'".$chargefromamount."' AND "."'".$chargetoamount."'  ";
            }
          
    }
    else{
        
        if($chargewhere != ''){
                    $chargewhere .="    and ROUND(REPLACE(a1.`Charge amount secured`,',', '')) >= "."'".$chargefromamount."'";
            }else{
                    $chargewhere .="   ROUND(REPLACE(a1.`Charge amount secured`,',', '')) >= "."'".$chargefromamount."'";
            }
    }
        
}

   if(isset($chargeaddress) && $chargeaddress!=''){
    
    if($chargewhere != ''){
        $chargewhere .="    and a1.`Address` LIKE  "."'%".$chargeaddress."%'";
    }else{
        $chargewhere .="    a1.`Address` LIKE "."'%".$chargeaddress."%'";
    }
        
        $template->assign("chargeaddress" , $chargeaddress);
       
}

if(isset($city) && $city!=''){
    $city=str_replace(",","','",$city);
    if($chargewhere != ''){
        $chargewhere .="    and a1.`city` IN( '".$city."')";
    }else{
        $chargewhere .="    a1.`city` IN( '".$city."')";
    }
        
       // $template->assign("cities" , $city);
       
}
if(isset($state) && $state!=''){
    $state=str_replace(",","','",$state);
    if($chargewhere != '' && $cityflag==0 ){
        $chargewhere .="    and a1.`state` IN( '".$state."')";
    }elseif($chargewhere != '' && $cityflag==1){
        $chargewhere .="    or a1.`State` IN( '".$state."')";
    }else{
        $chargewhere .="    a1.`state` IN( '".$state."')";
    }
        
       // $template->assign("state" , $state);
       
}


        
    $ExportResult = $plstandard->getcompanyList_cnt($chargewhere,$limit,$page);
     
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
	header("Content-Disposition: attachment; filename=ioc_companylist.xls");
	header("Pragma: no-cache");
	header("Expires: 0");
        
        $sep = "\n"; //tabbed character
        $tab = "\t"; //tabbed character
        //print("\n");
        $currFY = Date('y');
    echo "Company Name"."\t";
    echo "State"."\t";
    echo "City"."\t";    
        
        print("\n");

        //print("\n");
	$flag = false; 
        $schema_insert = "";
       
        $previousCompId = '';
        $currentFY = $currFY;
        // print_r($ExportResult);
        // exit();
	foreach($ExportResult as $row) { 
           
            $company_name = preg_replace("/\s+/", " ", $row['company_name']);
            $schema_insert .= htmlspecialchars_decode(trim($company_name)).$tab;
            $schema_insert .= htmlspecialchars_decode(trim($row['state'])).$tab;
            $schema_insert .= htmlspecialchars_decode(trim($row['city'])).$sep;
//            if ($fyDiff > 0)
//                $schema_insert .= movetabs($fyDiff);    
                   
           
           
               
	} 
        print(trim($schema_insert));
        print "\n";
         mysql_close();
	exit;
   
        

        
?>