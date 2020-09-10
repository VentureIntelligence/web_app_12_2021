<?php
//07/12/2011 (mm/dd/yyyy)
//filename dbConnect.php
//does the database connection to the development database

        class db_connection {
                var $cnx ;
                function db_connection() {
                  //echo "<br>~~~~~~~~~~~~~~~~~~~1";
                        global $cnx;
                        global $dcnx;
                        $servername="ventureintelligence.ipowermysql.com";
                        $dbname="vi_dev_fin";
                        $user="vi_admin_dev";
                        $userpwd="admindev";

                $cnx = mysql_connect("$servername","$user","$userpwd")or die("ERROR Cant connect to database");
                $dcnx = mysql_select_db("$dbname",$cnx);
                 //echo "<br>`````````````` " .$dcnx;
                }
                  function execute($sql) {
                    echo "<br>4-----";
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
?>
