<?php
ob_start();
require("dbconnectvi.php");
$Db = new dbInvestments();
// //session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
session_save_path("/tmp");
session_start();
if( isset( $_SESSION[ 'SessLoggedAdminPwd' ] ) ) {
	header( 'Location:'.BASE_URL.'adminvi/index.php' );
}
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
/*
	filename - admin.php     (password checking and ip checking for admin people)
    formanme - viadmin
   invoked from -  direct from website link
  */
               
            $displayMessage="";
            include "onlineaccount.php";
            global $adminpassword;
            global $adminipadd;
            global $adminipadd1;
            //echo "<br>--" .$loggedadminpwd;

            //echo "<br>***".$adminipadd;
            //echo "<Br>####".$adminipadd1;
            $loggedadminpwd="";
            $loggedadminname= "";
            if(isset($_POST['adminPassword'])){
                $loggedadminpwd=$_POST['adminPassword'];
            }
            if(isset($_POST['adminUserName'])){
                $loggedadminname=$_POST['adminUserName'];
            }

            if((trim($loggedadminpwd)!=""))
            {
                    $loggedadminpwd = md5( $loggedadminpwd );
                    $loggedipadd=$_SERVER['REMOTE_ADDR'];
                    $splitIpAdd= explode(".", $loggedipadd);
                    $splitIpAdd1=$splitIpAdd[0];
                    $splitIpAdd2=$splitIpAdd[1];

                    $sel = "SELECT * FROM adminvi_user WHERE user_name = '$loggedadminname' AND password = '$loggedadminpwd'";
                    $res = mysql_query( $sel ) or die( mysql_error() );
                    $numRows = mysql_num_rows( $res );
                    if( $numRows > 0 ) {
                            $result = mysql_fetch_array( $res );
                            $userID = $result[ 'id' ];
                            $is_enabled = $result[ 'is_enabled' ];
                            if( $is_enabled == 1 ) {
                                    $lastLogin = date( "Y-m-d h:i:s" );
                                    $update = "UPDATE adminvi_user SET last_login = '" . $lastLogin . "' WHERE id = $userID";
                                    mysql_query( $update ) or die( mysql_error() );
                                    $sel1 = "SELECT * FROM adminvi_user_module WHERE user_id = '$userID'";
                                    $res1 = mysql_query( $sel1 ) or die( mysql_error() );
                                    $result1 = mysql_fetch_array( $res1 );
                                    $_SESSION[ 'SessLoggedAdminPwd' ]  =true;
                                    $_SESSION['SessLoggedIpAdd']=$loggedipadd;
                                    $_SESSION['user_type']=2;
                                    $_SESSION['is_admin']=0;
                                    $_SESSION[ 'modules_permission' ] = $result1[ 'module_permission' ];
                                    $_SESSION[ 'name' ] = $result[ 'first_name' ]." ".$result[ 'last_name' ];
                                    header('Location: adminvi/index.php') ;
            exit;
                            } else {
                                    $displayMessage = "Login failed. Permission pending.";
                            }
                    } else {
                            $displayMessage = "Login failed. Please check your user name or password";
                    }
            }
            else
            {
                    $displayMessage= "";
            }

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">
function checkFields()
 {
  	if((document.viadmin.adminpassword.value == ""))
    {
		alert("Please enter the Password");
		return false
 	}
}
</SCRIPT>
<link href="css/style_root.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="viadmin" onSubmit="return checkFields();" method="post" action="adminusers.php" >
<div id="containerproductpelogin">
<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="index.htm"><img src="images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgpropelogin">

    	<div id="vertMenupelogin">

        	<div style="padding: 0px 0px 5px 3px;">User Name</div>

        	<div style="text-align: center;"> 
                    
                    <input type=text name="adminUserName" value="" size="23" style="width:140px;"> <br /><br />
                
                
                </div>
                
                <div style="padding: 0px 0px 5px 3px;">Password</div>

        	<div style="text-align: center;"> 
                    
                    <input type=password name="adminPassword" value="" size="23" style="width:140px;"> <br /><br />
                
                    <input type="submit" name="btnSubmit" value ="Authenticate" >
                
                </div>

        	<div id="headingtextproboldfontcolor"> <?php echo $displayMessage; ?></div>

        </div>
    </div>

   </div>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="js/top-removed.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">

	  <div style="background-color:#FFF; width:565px; height:406px; margin-top:5px;">
		<div id="navpro">
		        <!--<div class="links">
		          <ul>
		            <li><img src="images/arrow.gif" /> <a href="subscribe.htm">Subscribe</a> </li>
		            <li><img src="images/arrow.gif" /> <a href="advertise.htm">Advertise </a> </li>
		            <li><img src="images/arrow.gif" /> <a href="sponsor.htm">Sponsor</a></li>
		          </ul>
		        </div> -->
	  </div>
	    <div id="maintextpro">

        <div id="headingtextpro">
        <!--
     	<div id="headingtextproboldfontcolor"> Private Equity Deal Database <br />  <br /> </div>

     	The Venture Intelligence <i> Private Equity Deal Database </i> lists cash-for-equity investments in India-based companies
     	by private equity and venture capital firms. The database also includes financial investments by
     	strategic investors which function similar to PE/VC firms and often co-invest with them. <br /><br />

		Each deal listed in this database typically includes the name of the investee company, its location,
		Industry & Sector it operates in, the investors involved, the amount and date. Wherever available,
		we also include information on the valuation and the advisors to the deal.<br /><br />

		Apart from the deal-by-deal listing, the database also provides aggregate private equity and
		venture capital statistics that includes data on deals that have been disclosed in confidence
		to Venture Intelligence. <Br /><Br />
		The database also features a listing of PE/VC exits, profiles of PE firms,
		advisors and PE/VC-backed companies. <br /><br />

		<div id="headingtextprosmallfont">
		Note: The Venture Intelligence database is based on publicly announced / reported
		deals and data collected from Private Equity / Venture Capital / Investment Banking firms.
		The Venture Intelligence database is updated continuously and is therefore subject to change at any time.
		 </div>
		-->


		</div>
        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="js/bottom.js"></SCRIPT>
   </form>
   <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
  </script>
</body>
</html>