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
    
   
    // if($exportsql !='')
    //     $ExportResult = $plstandard->ExporttoExcel($exportsql);
    // elseif($exportsql1)
    //     $ExportResult = $growthpercentage->ExporttoExcel($exportsql1);
    // elseif($exportsql2)
    //     $ExportResult = $cagr->ExporttoExcel($exportsql2);
   // $field = $_POST['company_exportid'];
   if($_POST['company_exportid']!='')
   {
    $field = $_POST['company_exportid'];
   }
   if($_POST['companyhiddenval']!='')
   {
    $value = $_POST['companyhiddenval'];
    $field = str_replace(",","','",$value);
   }
    // exit();
    $ExportResult = $plstandard->getchargesholderList($field);
      
    
     // echo $exportsql; die;
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
	header("Content-Disposition: attachment; filename=ioc_chargeholderList.xls");
	header("Pragma: no-cache");
  header("Expires: 0");
  print("\n"); 
  if($_POST['company_exportid']!='')
   {
  echo  $ExportResult[0]['company_name'];
   }
  print("\n"); 
  print("\n"); 
    $sep = "\t"; //tabbed character
    $newline="\n";
    //print("\n");
    $currFY = Date('y');
  // echo "S.No"."\t";
  if($_POST['companyhiddenval']!='')
  {
  echo "Company Name"."\t";
  }
  echo "SRN"."\t";
 	echo "Charge ID"."\t";
	echo "Charges Holder Name"."\t";
	echo "Date of creation"."\t";
  echo "Date of modification"."\t";
  echo "Date of satisfaction"."\t";
  echo "Amount"."\t";
  echo "Chargeholder Address"."\t";
  echo "City (Company)"."\t";
	echo "State (Company)"."\t";
  
  
    // echo "Year Founded"."\t";
    print("\n");
    //print("\n");
	$flag = false; 
        $schema_insert = "";
       
        // $previousCompId = '';
        // $currentFY = $currFY;
       
        $cnt=1;
       // $schema_insert .=.$newline;
       
	foreach($ExportResult as $row) { 
    if($row['Created_Date']!=NULL)
     {
       $createdate=$row['Created_Date'];
       $timestamp = strtotime($createdate);
       $create_date = date("d/m/Y", $timestamp);
      }else{$create_date= "-";}
     if($row['Modified_Date']!=NULL)
     {
      $modifieddate=$row['Modified_Date'];
      $timestamp1 = strtotime($modifieddate);
      $modified_date = date("d/m/Y", $timestamp1);
     }else{$modified_date= "-";}
      if($row['dateofcharge']!=NULL)
      {
        $satisfactiondate=$row['dateofcharge'];
        $timestamp2 = strtotime($satisfactiondate);
        $satisfaction_date = date("d/m/Y", $timestamp2);
      }else{$satisfaction_date= "-";}
    //$schema_insert .=$cnt.$sep;
    if($_POST['companyhiddenval']!='')
    {
     $schema_insert .= $row['company_name'].$sep;
    }
     $schema_insert .= $row['SRN'].$sep;
    
     $schema_insert .= $row['chargeid'].$sep;
     $schema_insert .= trim(str_replace(";","",$row['chargeholder'])).$sep;
    
     $schema_insert .= $create_date.$sep;
     $schema_insert .= trim($modified_date).$sep;
     $schema_insert .= trim($satisfaction_date).$sep;
    
     $schema_insert .= str_replace(",","",$row['amount'].$sep);
     $schema_insert .= str_replace(", "," ",$row['Address'].$sep);
     $schema_insert .=$row['city'].$sep;
     $schema_insert .= $row['state'];
     
    
     $schema_insert .=$newline;
     //$cnt++;
	} 
        print(trim($schema_insert));
        print "\n";
         mysql_close();
	exit;
   
?>