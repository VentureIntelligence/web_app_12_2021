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
    /*$result = mysql_query("SELECT FY,CAGR_Id FROM cagr");
    if(mysql_num_rows($result) >0){
        while($res = mysql_fetch_array($result)){
            $FYear = $res['FY'];
            $FY  = ereg_replace("[^0-9]", "", $FYear);            
            if($FY !=''){ echo "UPDATE  `cagr` SET FY='$FY' WHERE CAGR_Id='".$res['CAGR_Id']."'";
                mysql_query("UPDATE  `cagr` SET FY='$FY' WHERE CAGR_Id='".$res['CAGR_Id']."'" );                  
            }
            
        }
    }
    $result = mysql_query("SELECT FY,PLStandard_Id FROM plstandard");
    if(mysql_num_rows($result) >0){
        while($res = mysql_fetch_array($result)){
            $FYear = $res['FY'];
            $FY  = ereg_replace("[^0-9]", "", $FYear);            
            if($FY !=''){
                mysql_query("UPDATE  `plstandard` SET FY='$FY' WHERE PLStandard_Id='".$res['PLStandard_Id']."'" );                  
            }
            
        }
    }*/
    $result = mysql_query("SELECT FY,PLStandard_Id FROM plstandard");
    if(mysql_num_rows($result) >0){
        while($res = mysql_fetch_array($result)){
         $FYear = $res['FY'];
            $FY_len = strlen($FYear);
            $FY  = ereg_replace("[^0-9]", " ", $FYear); 
            if($FY_len == 8){
                $FY = substr_replace($FY, ' ', 2, -6);        
                if($FY !=''){
                    mysql_query("UPDATE  `plstandard` SET FY='$FY' WHERE PLStandard_Id='".$res['PLStandard_Id']."'" );                  
                }
            } else{
                $FY  = ereg_replace("[^0-9]", " ", $FYear);  
                $FY = trim($FY);
                mysql_query("UPDATE  `plstandard` SET FY='$FY' WHERE PLStandard_Id='".$res['PLStandard_Id']."'" );  
            }
            
        }
    }die;
    $result = mysql_query("SELECT FY,CAGR_Id FROM cagr");
    if(mysql_num_rows($result) >0){
        while($res = mysql_fetch_array($result)){
         $FYear = $res['FY'];
            $FY_len = strlen($FYear);
            $FY  = ereg_replace("[^0-9]", " ", $FYear); 
            if($FY_len == 8){
                $FY = substr_replace($FY, ' ', 2, -6);        
                if($FY !=''){
                    mysql_query("UPDATE  `cagr` SET FY='$FY' WHERE CAGR_Id='".$res['CAGR_Id']."'" );                  
                }
            } else{
                $FY  = ereg_replace("[^0-9]", " ", $FYear);  
                $FY = trim($FY);
                mysql_query("UPDATE  `cagr` SET FY='$FY' WHERE CAGR_Id='".$res['CAGR_Id']."'" );  
            }  
            
        }
    }
    $result = mysql_query("SELECT FY,GrowthPerc_Id FROM growthpercentage");
    if(mysql_num_rows($result) >0){
        while($res = mysql_fetch_array($result)){
         $FYear = $res['FY'];
            $FY_len = strlen($FYear);
            $FY  = ereg_replace("[^0-9]", " ", $FYear); 
            if($FY_len == 8){
                $FY = substr_replace($FY, ' ', 2, -6);        
                if($FY !=''){
                    mysql_query("UPDATE  `growthpercentage` SET FY='$FY' WHERE GrowthPerc_Id='".$res['GrowthPerc_Id']."'" );                  
                }
            }  else{
                $FY  = ereg_replace("[^0-9]", " ", $FYear);  
                $FY = trim($FY);
                mysql_query("UPDATE  `growthpercentage` SET FY='$FY' WHERE GrowthPerc_Id='".$res['GrowthPerc_Id']."'" );  
            }   
            
        }
    }
    $result = mysql_query("SELECT FY,BalanceSheet_Id FROM balancesheet");
    if(mysql_num_rows($result) >0){
        while($res = mysql_fetch_array($result)){
         $FYear = $res['FY'];
            $FY_len = strlen($FYear);
            $FY  = ereg_replace("[^0-9]", " ", $FYear); 
            if($FY_len == 8){
                $FY = substr_replace($FY, ' ', 2, -6);        
                if($FY !=''){
                    mysql_query("UPDATE  `balancesheet` SET FY='$FY' WHERE BalanceSheet_Id='".$res['BalanceSheet_Id']."'" );                  
                }
            }  else{
                $FY  = ereg_replace("[^0-9]", " ", $FYear);  
                $FY = trim($FY);
                mysql_query("UPDATE  `balancesheet` SET FY='$FY' WHERE BalanceSheet_Id='".$res['BalanceSheet_Id']."'" );  
            }   
            
        }
    }
    $result = mysql_query("SELECT FY,BalanceSheet_Id FROM balancesheet_new");
    if(mysql_num_rows($result) >0){
        while($res = mysql_fetch_array($result)){
         $FYear = $res['FY'];
            $FY_len = strlen($FYear);
            $FY  = ereg_replace("[^0-9]", " ", $FYear);   
            if($FY_len == 8){
                $FY = substr_replace($FY, ' ', 2, -6);        
                if($FY !=''){
                    mysql_query("UPDATE  `balancesheet_new` SET FY='$FY' WHERE BalanceSheet_Id='".$res['BalanceSheet_Id']."'" );                  
                }
            }  else{
                $FY  = ereg_replace("[^0-9]", " ", $FYear);  
                $FY = trim($FY);
                mysql_query("UPDATE  `balancesheet_new` SET FY='$FY' WHERE BalanceSheet_Id='".$res['BalanceSheet_Id']."'" );  
            }   
            
        }
    }
    

        
        
        echo "CAGR imported successfully";
  //  header("Location:upload.php");
//}
mysql_close(); 
?>