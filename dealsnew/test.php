<?php
//$cnx = mysql_connect("162.144.122.247","venture_admin","Admin2014")or die("Sorry. There is a temporary server problem. Please try later.");
$cnx = mysql_connect("localhost","venture_admin","Admin2014")or die("Sorry. There is a temporary server problem. Please try later.");
//$cnx = mysql_connect("venture.ipowermysql.com","venture_admin","Admin2014")or die("Sorry. There is a temporary server problem. Please try later.");
    $dcnx = mysql_select_db("venture_peinvestments",$cnx) or die(mysql_error());
    /*
    $headers = 'From: webmaster@ventureintelligence.com' . "\r\n" .
    'Reply-To: webmaster@ventureintelligence.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
    
    mail('fidelis@kutung.com',"Connection and email Test","Looks like there was no errors")
     * */
    echo phpinfo();
?>

This is the new server...



