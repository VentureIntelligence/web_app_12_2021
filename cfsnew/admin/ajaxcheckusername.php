<?php 

error_reporting(0);

//echo $_POST['username'];
//exit;
include "header.php";
	
	if(isset($_POST['username'])){
		require_once MODULES_DIR."users.php";
                $users = new users();
                
		$where = " username = '$_POST[username]' ";
                            
    		$count = $users->count($where);
                
                echo $count;               
			
        }
        
        
        if(isset($_POST['usernamesuggest'])){
		require_once MODULES_DIR."users.php";
                $users = new users();
                $NotFound='No match found';
                 $html="<ul>";
                
		$where = " username like '%$_POST[usernamesuggest]%' ";
                $order=' username';            
    		$user_li = $users->usernamesuggest($where,$order);
                            
                if(array_keys($user_li)){
			foreach($user_li as $id => $name) {
				$html.="<li style='cursor:pointer;'onClick='fill(\"".addslashes($name)."\"),fillHidden($id)';>".$name."</li>";
			}
		}else{
			$html.="<li>".$NotFound."</li>";
		}
                
                
               echo $html."</ul>";              
			
        }
?>
