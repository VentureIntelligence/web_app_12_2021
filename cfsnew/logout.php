<?php 

if (isset($_COOKIE['backpage'])) {
    unset($_COOKIE['backpage']); 
    setcookie('backpage', null); 
    // return true;
} else {
    // return false;
}

include_once('header.php');

if($isAuth) {
	$logoutUser = new users();
	session_start();
	$updateUser['user_id'] = $_SESSION["user_id"];
	$updateUser['user_lastLoginTime'] = date("Y-m-d H:i:s", mktime(date("H"), date("i")-4, date("s"), date("m"), date("d"), date("Y")));
	$logoutUser->update($updateUser); 
	
        // where condition for the same city needed to be done...
        unset($_SESSION['username']);
        unset($_SESSION['type']);
        unset($_SESSION["ipuser"]);
        unset($_SESSION['UserNames']);
        unset($_SESSION['MAUserNames']);
        unset($_SESSION['REUserNames']);
        unset($_SESSION['loginusername']);
        unset($_SESSION['password']);  
        session_destroy();
	//session_unset('user'); 
	//session_destroy();
	
	header('Location: login.php');
} else {
	/*For Redirect to surf when user logged out by anega prabhu on 21.12.09*/
	if($_SERVER["HTTP_REFERER"] !=  "http://www.prabhu/cfs/logout.php"){
		
                unset($_SESSION['username']);
                 
               // session_unset('user');
		header('Location: '.WEB_DIR);
		exit();
	};

}
$template->display("logout.tpl");
mysql_close();
?>