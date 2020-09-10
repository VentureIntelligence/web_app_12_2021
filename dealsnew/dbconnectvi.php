<?php
        class dbConnect {
                var $cnx ;
                function dbConnect() {
                        global $cnx;
                        global $clsx;
                $cnx = mysql_connect("localhost","venture_admin","Admin2014")or die("Sorry. There is a temporary server problem. Please try later.");
                $dcnx = mysql_select_db("venture_Tsjmedia",$cnx);
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
		                 $cnx = mysql_connect("localhost","venture_admin","Admin2014")or die("Sorry. There is a temporary server problem. Please try later.");
		                 $dcnx = mysql_select_db("venture_peinvestments",$cnx);
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
