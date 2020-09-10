<?php
 //session_save_path("/tmp");
	session_start();       
        require_once("../dbconnectvi.php");
        $Db = new dbInvestments();
  
        $videalPageName="REInv";
        include ('checklogin.php');
        
        function updateDownload($res){
            //Added By JFR-KUTUNG - Download Limit
          
            $recCount = mysql_num_rows($res);
            $dlogUserEmail = $_SESSION['UserEmail'];
            $today = date('Y-m-d');
           
            //Check Existing Entry
           $sqlSelCount = "SELECT `recDownloaded`  FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='RE' AND `downloadDate` = CURRENT_DATE";
           $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
           $rowSelCount = mysql_num_rows($sqlSelResult);
           $rowSel = mysql_fetch_object($sqlSelResult);
           $downloads = $rowSel->recDownloaded;
           
           if ($rowSelCount > 0){
               $upDownloads = $recCount + $downloads;
               $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='RE' AND `downloadDate` = CURRENT_DATE";
               $resUdt = mysql_query($sqlUdt) or die(mysql_error());
           }else{
               $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('0','".$dlogUserEmail."','".$today."','RE','".$recCount."')";
               mysql_query($sqlIns) or die(mysql_error());
           }
        }
        
        
       
        
        
                $fundid = $_POST['fundid']; 
                
                $exp_query =  mysql_query("SELECT id,moreInfo FROM fundRaisingDetails  WHERE id='$fundid' ") ; 
                
                 updateDownload($exp_query);
                  $fu_de2 = mysql_fetch_array($exp_query) ; 
                        
                    $fu_de = mysql_fetch_array( mysql_query("SELECT * FROM fundRaisingDetails  fd 
                    LEFT JOIN fundNames fn ON fd.investorId=fn.investorId  
                    LEFT JOIN REinvestors re ON fd.investorId = re.InvestorId
                    LEFT JOIN fundType fts ON  fd.fundTypeStage=fts.id 
                    LEFT JOIN realestatetypes fti ON  fd.REsector=fti.RETypeId 
                    LEFT JOIN fundRaisingStatus frs ON fd.fundStatus = frs.id
                    LEFT JOIN fundCloseStatus fes ON fd.fundClosedStatus = fes.id
                   
                    WHERE fd.id='$fundid' ")) ;
                 
                            
                    function fun_ty($futyid)       {
                     $e = mysql_fetch_array( mysql_query("SELECT * FROM fundType WHERE id='$futyid' "));
                        return $e['fundTypeName'];                
                    }
                    
                    
                    function fun_in($futyid)       {
                     $e = mysql_fetch_array( mysql_query("SELECT `industryid`,`industry` FROM reindustry WHERE industryid='$futyid' "));
                        return $e['industry'];                
                    }
                    

                     function cap_sor($cap_sor)             {
                        $e = mysql_fetch_array( mysql_query("SELECT * FROM fundCapitalSource WHERE id='$cap_sor' "));
                           return $e['source'];                 
                    }
        
                    $investordetail = mysql_fetch_array(mysql_query (" SELECT InvestorId,Investor FROM REinvestors WHERE InvestorId='$fu_de[investorId]' ") );
               
                    
   if($fu_de2){      
       
       /// export
        
        
        //if parameter is not included, file returned will be in excel format ('.xls')
 	if (isset($w) && ($w==1))
 	{
 		$file_type = "msword";
 		$file_ending = "doc";
 	}
 	else
 	{
 		$file_type = "vnd.ms-excel";
 		$file_ending = "xls";
	}
 //header info for browser: determines file type ('.doc' or '.xls')
 header("Content-Type: application/$file_type");
 header("Content-Disposition: attachment; filename=re_funddetails.$file_ending");
 header("Pragma: no-cache");
 header("Expires: 0");


 	
 	      /*print("\n");
 	      print("\n");*/



	echo "Fund Name "."\t";        
	echo "Fund Type "."\t";
        echo 'Size ($USM)'."\t";
        echo "Fund Status"."\t";
        echo "Capital Source"."\t";
        echo "Fund Date "."\t";	
        
	echo "Investor Name "."\t";
	
	echo "More Info"."\t";
	echo "Source";
	
	
	

 print("\n");

 /*print("\n");*/
	
  

     
         $exportrows='';
     
            
         $exportrows.=$fu_de["fundName"]."\t";
         $exportrows.=$fu_de["REType"]."\t";
         $exportrows.=$fu_de["size"]."\t";
         $exportrows.=$fu_de["fundStatus"];
                
                if($fu_de["fundStatus"]) { $fundbr="-"; } else { $fundbr="";}
                if($fu_de['fundStatus']=='Closed' && $fu_de['closeStatus']!='') { $exportrows.= " $fundbr ". $fu_de['closeStatus']."\t"; } else { $exportrows.="\t";}                
         
         $exportrows.=cap_sor($fu_de["capitalSource"])."\t";
         $exportrows.=date("M-Y", strtotime($fu_de["fundDate"]))."\t";
         $exportrows.=$investordetail['Investor']."\t";
         $exportrows.=$fu_de2["moreInfo"]."\t";
         $exportrows.=$fu_de["source"];
         
         
         
        
         
     
     
     print trim( preg_replace("/\r\n|\n\r|\n|\r/", " ",$exportrows) );
     exit;
     
 }
        
   mysql_close();     
        
        
?>