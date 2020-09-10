<?php 

//error_reporting(0);


include "header.php";
	
	if(isset($_POST['groupnamesuggest'])){
		// require_once MODULES_DIR."admin_user_external.php";
        //         $adminuserexternal = new adminuserexternal();
                
		$where = "'".$_POST['groupnamesuggest']."'";
                            
    		$count = $adminuserexternal->mailcount($where);
				if($count>0)
				{
					echo "Email id is already exists";
				}
                               
			
        }
        
        
        // if(isset($_POST['groupnamesuggest'])){
		// require_once MODULES_DIR."users.php";
        //         $users = new users();
        //         $NotFound='No match found';
        //          $html="<ul>";
                
		// $where = " email = '$_POST[groupnamesuggest]' ";
        //         $order=' UserName';            
    	// 	$user_li = $adminuser->usernamesuggest($where,$order);
                            
        //         if(array_keys($user_li)){
		// 	foreach($user_li as $id => $name) {
		// 		$html.="<li style='cursor:pointer;'onClick='fillgroupname(\"".addslashes($name)."\"),fillHidden($id)';>".$name."</li>";
		// 	}
		// }else{
		// 	$html.="<li>".$NotFound."</li>";
		// }
                
                
        //        echo $html."</ul>";              
			
        // }
?>
