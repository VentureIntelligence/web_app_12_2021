<?php session_start();session_save_path("/tmp");
require_once MODULES_DIR."database.php";
require_once MODULES_DIR."users.php";
class Auth extends database{

	var $users;
	var $authUser;
	var $maxLoginAttempts = AUTH_MAX_LOGIN_ATTEMPTS;
	
	function Auth() {
		database::database();	
		$this->user =  new users();
	}
	
	function doAuth() { 
		$returnValue = false;
		$initLogin = $this->initLoginAttempts();
		
		if($initLogin)
			$checkResult = $this->checkSession();
//print $checkResult;exit;
		if ($checkResult) {
//print "else";exit;		
			$userValidateResult = $this->validateUser();
			print $userValidateResult; 
			if ($userValidateResult) {		
				$returnValue = true;

			} else {
				$this->error['auth'] = "Please check the username / password you have given";
				$loginAttemptsResult = $this->checkLoginAttempts();
				if ($loginAttemptsResult) {
					$this->accessDenied();
				}

			}
		
		} 
		return $returnValue;
	}
	
	function checkSession() {
			
			
		$returnValue = false;
		if (($_SESSION['user']->elements->username != '') && ($_SESSION['user']->elements->user_password != '')) {
			$this->authUser['username']     = $_SESSION['user']->elements->username;
			$this->authUser['user_password']  = $_SESSION['user']->elements->user_password;
			$returnValue = true;
			//	print_r($_POST);
		} elseif (($_POST['username'] !='') && ($_POST['user_password'] !='')) {
			$this->authUser['username']     = $_POST['username'];
			$this->authUser['user_password'] = md5($_POST['user_password']);
			$returnValue = true;
				print_r($_POST);
		} elseif ($_POST['answer']['username'] != '' && $_POST['answer']['user_password'] != '') {
			$this->authUser['username']     = $_POST['answer']['username'];
			$this->authUser['user_password'] = md5($_POST['answer']['user_password']);
			$returnValue = true;
			//	print_r($_POST);
		}
	
		/*if ($_SESSION['user']['username'] && $_SESSION['user']['fb_userid']) {
		print "session";
			$this->authUser['username']     = $_SESSION['user']['username'];
			$this->authUser['fb_userid']  = $_SESSION['user']['fb_userid'];
			$returnValue = true;
		}	*/		
		
		/*				print "<pre>";
			print_r($returnValue);
			print "</pre>";
			
		*/
		return $returnValue;
	}
	
	function validateUser() {

		$returnValue = false;
		//$where = 'username ='.$this->authUser['username'];
		 //$test = $this->user->getFullList($pageID=1,$rows=300,$fields=array('*'),$where,$order="",$type="num");
		 $username = "'".$this->authUser['username']."'";
		 $test = $this->user->selectByUName('Hari');
		//print_r($this->authUser['user_password']);
		 //print_r($test);
		//print_r($this->user->selectByUName('Hari'));
		//print_r($test['username']);
		
		if (  ( $this->authUser['username']    == $test['username'] ) && 
		      ( $this->authUser['user_password'] == $test['user_password']) ) {
			print_r($test);
			if(!$_SESSION['user']) { 
				//if( $this->user->elements['user_status'] != 'B' )
					session_start();
					$_SESSION['user'] = serialize($test);
					//print_r($_SESSION);
				$_SESSION['loginAttempts'] = '';
				unset($_SESSION['loginAttempts']);
				unset($_SESSION['security_code']);
			}
		if( $this->user->elements['user_status'] != 'B' || $closeMyAccount == 1) $returnValue = true;		
			
		} else {
		
			$_SESSION['loginAttempts'] = $_SESSION['loginAttempts'] + 1;	
		}
		

		return $returnValue;
		
	}
	
	function initLoginAttempts() {
		$returnValue = true;				
		if(!$_SESSION['loginAttempts']) {
			$_SESSION['loginAttempts'] = 1;	
		} elseif($_SESSION['loginAttempts'] >=3) {
			if($_SESSION['security_code'] != $_POST['security_code']) {
				$this->error['auth'] = "Pal - please check the security code you have given";
				$returnValue = false;
			}	
		}
		return $returnValue;					
	}
	
	function checkLoginAttempts() {

		$returnValue = false;
					
		if ($_SESSION['loginAttempts'] >= $this->maxLoginAttempts) {
				$returnValue = true;	
		}	
		return $returnValue;
	}
	
	
	function accessDenied() {
		
		
		echo "Failed logging attempts logging data ...<br>";
		die();
		
	}
	function setLoginAttempts($number) {

		$this->maxLoginAttempts = $number;
	}
		
	function destruct() {
		$this->user = NULL;
		$this->authUser = NULL;
		$this->disconnect();
	}
		


}//End of Function 
?>
