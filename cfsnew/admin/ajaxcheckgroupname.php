<?php 

error_reporting(0);

//echo $_POST['username'];
//exit;
include "header.php";
	
	if(isset($_POST['G_Name'])){
		require_once MODULES_DIR."grouplist.php";
                $grouplist = new grouplist();
                
		$where = " G_Name = '$_POST[G_Name]' ";
                            
    		$count = $grouplist->count($where);
                
                echo $count;
                
			
        }
        
        
        
          if(isset($_POST['groupnamesuggest'])){
		require_once MODULES_DIR."grouplist.php";
                $grouplist = new grouplist();
                $NotFound='No match found';
                 $html="<ul>";
                
		$where = " G_Name like '%$_POST[groupnamesuggest]%' ";
                $order=' G_Name';            
    		$groupli = $grouplist->groupnamesuggest($where,$order);
                            
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

