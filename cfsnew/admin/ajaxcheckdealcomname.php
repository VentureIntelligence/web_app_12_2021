<?php 

error_reporting(0);

//echo $_POST['username'];
//exit;
include "header.php";
	
	if(isset($_POST['G_Name'])){
		require_once MODULES_DIR."dealcompanies.php";
                $dealcompanies = new dealcompanies();
                
		$where = " DCompanyName = '$_POST[G_Name]' ";
                            
    		$count = $dealcompanies->count($where);
                
                echo $count;
                
			
        }
        
        
        
          if(isset($_POST['groupnamesuggest'])){
		require_once MODULES_DIR."dealcompanies.php";
                $dealcompanies = new dealcompanies();
                $NotFound='No match found';
                 $html="<ul>";
                
		$where = " DCompanyName like '%$_POST[groupnamesuggest]%' ";
                $order=' DCompanyName';            
    		$groupli = $dealcompanies->groupnamesuggest($where,$order);
                            
                if(array_keys($groupli)){
			foreach($groupli as $id => $name) {
				if($_POST['redirect']=='redirect'){
                                $html.="<li style='cursor:pointer;'onClick='fillgroupname(\"".addslashes($name)."\"),filterredirect($id)';>".$name."</li>";
                                }
                                else{
                                    $html.="<li style='cursor:pointer;'onClick='fillgroupname(\"".addslashes($name)."\"),fillHidden($id)';>".$name."</li>";
                                } 
                                    
			}
		}else{
			$html.="<li>".$NotFound."</li>";
		}
                
                
               echo $html."</ul>";              
			
        }
        
        
        
?>

