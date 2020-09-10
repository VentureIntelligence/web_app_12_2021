<?php include_once("../globalconfig.php"); ?>
<?php
    require("../dbconnectvi.php");
	     $Db = new dbInvestments();
    session_save_path("/tmp");
    session_start();
    
	     $Db->dbInvestments();
	 
                
		//session_register("UserNames");

			$logoffPage = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
			//echo "<Br>-- ".$logoffPage;
	 	if ((session_is_registered("UserNames")) || (session_is_registered("MAUserNames")) || (session_is_registered("REUserNames")))
		 {
		 		$sessionID=session_id();
                                
				$logofftime=date("Y-m-d")." ".date("H:i:s");
				//echo "<br>session id off-" .$sessionID;
				$LogOfftimeSql="Update dealLog set LoggedOff='$logofftime' where LogSessionID='$sessionID'";
				
				if($logrs=mysql_query($LogOfftimeSql))
				{
					unset($_SESSION['UserNames']);
                    
					unset($_SESSION['username']);
        			unset($_SESSION['type']);
        			unset($_SESSION['MAUserNames']);
        			unset($_SESSION['REUserNames']);
        			unset($_SESSION['loginusername']);
					unset($_SESSION['password']);  
					unset($_SESSION['VCcheckflag']);
					unset($_SESSION['VCdircheckflag']);    
                                       
//					$_SESSION = array();
					//session_unset();
					//session_regenerate_id();
					//session_destroy();
					//session_unregister("UserNames");
					//session_unregister("MAUserNames");
					//session_write_close();
					//session_unregister("UserEmail");
					//session_unregister("MAUserEmail");

//                                        session_unregister("REUserEmail");
//					session_unregister("REUserEmail");

//					session_unregister("MAIP");
//					session_unregister("REIP");
					//session_commit();
				}
				unset($_SESSION['popup_display']);
				unset($_SESSION['type']);
		}
			/*if($logoffPage=="P")
				header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;
			elseif($logoffPage=="PIP")
				header( 'Location: '. GLOBAL_BASE_URL .'dealsnew/peloginip.php' ) ;
			elseif($logoffPage=="M")
				header( 'Location: '. GLOBAL_BASE_URL .'dealsnew/malogin.php' ) ;
			elseif($logoffPage=="MIP")
			        header( 'Location: '. GLOBAL_BASE_URL .'dealsnew/maloginip.php' ) ;
			elseif($logoffPage=="R")
				header( 'Location: /re/relogin.php' ) ;
			elseif($logoffPage=="RIP")
				header( 'Location: '. GLOBAL_BASE_URL .'reloginip.php' ) ;
                        elseif($logoffPage=="caccess")
				header( 'Location:'. GLOBAL_BASE_URL .'dealsnew/pelogin.php?flag=ca' ) ;
                        else
				header( 'Location: '. GLOBAL_BASE_URL .'pelogin.php' ) ;*/
                if($logoffPage=="P")
				header( 'Location: ' . BASE_URL . 'refer.php' ) ;
			elseif($logoffPage=="PIP")
				header( 'Location: ' . BASE_URL . 'dealsnew/peloginip.php' ) ;
			elseif($logoffPage=="M")
				header( 'Location: ' . BASE_URL . 'dealsnew/malogin.php' ) ;
			elseif($logoffPage=="MIP")
			        header( 'Location: ' . BASE_URL . 'dealsnew/maloginip.php' ) ;
			elseif($logoffPage=="R")
				header( 'Location: /re/relogin.php' ) ;
			elseif($logoffPage=="RIP")
				header( 'Location: ' . BASE_URL . 'reloginip.php' ) ;
                        elseif($logoffPage=="caccess")
				header( 'Location: ' . BASE_URL . 'pelogin.php?flag=ca' ) ;
                        else
				header( 'Location: ' . BASE_URL . 'pelogin.php' ) ;

?>


