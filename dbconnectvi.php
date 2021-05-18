<?php
//error_reporting(1);
//ini_set("display_errors",1);
//ini_set('max_execution_time', 99999);
session_save_path("/tmp");
session_start();
//define('BASE_URL','https://localhost/vi_webapp/');
define('BASE_URL','http://localhost/vi_webapp/');
function session_register($arg){
    $_SESSION[$arg] = true; 
}
function session_is_registered($x)
{
    if (isset($_SESSION[$x]))
    return true;
    else 
    return false;
}
function session_unregister($arg){ 
    unset($_SESSION[$arg]);
}
        class dbConnect {
                var $cnx ;
                function dbConnect() {
                        global $cnx;
                        global $clsx;
                //$cnx = mysql_connect("localhost","venture_admin","Admin2014")or die("Sorry. There is a temporary server problem. Please try later.");
                $cnx = mysql_connect("localhost","root","root@123")or die("Sorry. There is a temporary server problem. Please try later.");
                $dcnx = mysql_select_db("vi_db",$cnx);
                }

                function getRs($sql) {
                        global $cnx;
                        global $dcnx;
                        $rs = "";
                        if ($cnx != null) {
                                $rs = mysql_query($sql);
                                return $rs;
                        } else {
                                return "";
                        }
                }

                function execute($sql) {
                        global $cnx;
                        global $dcnx;
                        if ($cnx != null) {
                                mysql_query($sql);
                                return true;
                        } else {
                                return false;
                        }
                }

                function closeDB() {
				                        global $cnx;
				                        global $dcnx;
				                        if ($cnx != null) {
				                                mysql_close($cnx);
				                        }
                }
        }


         class dbInvestments {
		                 var $cnx ;
		                 function dbInvestments() {
		                         global $cnx;
		                         global $clsx;
		                 //$cnx = mysql_connect("localhost","venture_admin","Admin2014")or die("Sorry. There is a temporary server problem. Please try later.");
		                 $cnx = mysql_connect("localhost","root","root@123")or die("Sorry. There is a temporary server problem. Please try later.");

		                 //$cnx = mysql_connect("localhost","venture_kutung","Kutung@123")or die("Sorry. There is a temporary server problem. Please try later.");
		                 $dcnx = mysql_select_db("vi_db",$cnx)or die( "Sorry. There is a temporary server problem. Please try later." );
		                 }

		                 function getRs($sql) {
		                         global $cnx;
		                         global $dcnx;
		                         $rs = "";
		                         if ($cnx != null) {
		                                 $rs = mysql_query($sql);
		                                 return $rs;
		                         } else {
		                                 return "";
		                         }
		                 }



		                 function execute($sql) {
		                         global $cnx;
		                         global $dcnx;
		                         if ($cnx != null) {
		                                 mysql_query($sql);
		                                 return true;
		                         } else {
		                                 return false;
		                         }
		                 }


        }

                                 function closeDB() {
						global $cnx;
						global $dcnx;
						if ($cnx != null) {
								mysql_close($cnx);
						}
		                 }

                                  function close() {
						global $cnx;
						global $dcnx;
						if ($cnx != null) {
								mysql_close($cnx);
						}
		                 }



?>
