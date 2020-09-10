<?php
require("../dbconnectvi.php");
$Db = new dbInvestments();
require("checkaccess.php");
  checkaccess( 'user_management' );
 //session_save_path("/tmp");
session_start();
//print_r($_POST);
if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
{
    $userExists = false;
    $emailExists = false;
    $successState = false;
    if( isset( $_POST[ 'add_btn' ] ) ) {
        $userName = mysql_real_escape_string( $_POST[ 'user_name' ] );
        $password = md5( $_POST[ 'password' ] );
        $first_name = mysql_real_escape_string( $_POST[ 'first_name' ] );
        $email = mysql_real_escape_string( $_POST[ 'email' ] );
        $last_name = mysql_real_escape_string( $_POST[ 'last_name' ] );
        $createdOn = date( 'Y-m-d h:i:s' );
        $module_all = $_POST[ 'module_all' ];
        $module_permission = $_POST[ 'module_permission' ];
        $sel = "SELECT id, user_name, email from adminvi_user where user_name = '" . trim($userName) . "' OR email = '" . trim( $email ) . "'";
        $res = mysql_query( $sel ) or die( mysql_error() );
        $numrows = mysql_num_rows( $res );
        if( $numrows > 0 ) {
            $result = mysql_fetch_array( $res );
            if( $userName == $result[ 'user_name' ] ) {
                $userExists = true;
            }
            if( $email == $result[ 'email' ] ) {
                $emailExists = true;
            }
        } else {
            $insert = "INSERT INTO adminvi_user ( user_name, password, email, first_name, last_name, created_on )
                        VALUES( '" . $userName . "', '" . $password . "', '" . $email . "', '" . $first_name . "', '" . $last_name . "', '" . $createdOn . "' )";
            if( mysql_query( $insert ) ) {
                $lastInsertId = mysql_insert_id();
                if( $module_all == 'all' ) {
                    $fullPermission = 1;
                } else {
                    $fullPermission = 0;
                }
                $module_permission = implode( ',', $module_permission );
                $insert_mod = "INSERT INTO adminvi_user_module ( user_id, module_permission, full_permission )
                                VALUES( '" . $lastInsertId . "', '" . $module_permission . "', " . $fullPermission . " )";
                mysql_query( $insert_mod ) or die( mysql_error() );
                $successState = true;
            }
        }
    }
?>

<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<link rel="stylesheet" href="../css/jquery-ui.css">
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.js"></script>
<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
<link href="../css/material-design-iconic-font.min.css" rel="stylesheet" type="text/css">

</head>
<body class="">
    <!-- <div class="loader-wrapper">
        <div class="loadersmall"></div>
    </div> -->
<div id="containerproductproducts">
    <!-- Starting Left Panel -->
    <?php include_once('leftpanel.php'); ?>
    <!-- Ending Left Panel -->
    <!-- Starting Work Area -->

    <div style="width:570px; float:right; ">
    	<div style="width:565px; float:left; padding-left:2px;">
            <div style=" width:565px;  margin-top:4px;" class="main_content_container">
                
                <div id="maintextpro" style="background-color: #ffffff;width:100%; min-height: 774px;">
                    <div id="headingtextpro">
                        <div class="form_container">
                            <?php
                            if( $emailExists && $userExists  ) {
                                echo '<div class="error_msg">Email id and user name already exists</div>';
                            } else if( $emailExists ) {
                                echo '<div class="error_msg">Email already exists</div>';
                            } else if( $userExists ) {
                                echo '<div class="error_msg">User name already exists</div>';
                            }
                            if( $successState ) {
                                echo '<div class="success_msg">User added successfully</div>';
                            }
                            ?>
                            <form method="post" action="addadmin_user.php">
                                <table border="1" align="center" cellpadding="2" cellspacing="0" width="80%" style="font-family: Arial; margin-top: 20px; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" bgcolor="#F5F0E4">
                                    <tbody>
                                        <tr bgcolor="#808000"><td colspan="2" align="center" style="color: #FFFFFF"><b> Add User</b></td></tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="user_name">User Name</label>
                                            </td>
                                            <td>
                                                <input type="text" id="user_name" size="26" name="user_name" class="req_value" forerror="UserName" value=""> 
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="password">Password</label> 
                                            </td>
                                            <td>
                                                <input type="password" id="password" size="26" name="password" class="req_value" forerror="UserName" value="">
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="email">Email</label> 
                                            </td>
                                            <td>
                                                <input type="text" id="email" size="26" name="email" class="req_value" forerror="UserName" value="">
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="first_name">First Name</label> 
                                            </td>
                                            <td>
                                                <input type="text" id="first_name" size="26" name="first_name" class="req_value" forerror="UserName" value="">
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="last_name">Last Name</label> 
                                            </td>
                                            <td>
                                                <input type="text" id="last_name" size="26" name="last_name" class="req_value" forerror="UserName" value="">
                                            </td>
                                        </tr>
                                        <tr style="font-family: Verdana; font-size: 8pt">
                                            <td>
                                                <label for="">Module Permission</label>
                                            </td>
                                            <td>
                                                <div>
                                                    <input type="checkbox" id="module_all" name="module_all" value="all" />
                                                    <label for="module_all">Check All</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="import" name="module_permission[]" value="import" />
                                                    <label for="import">Import</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="export" name="module_permission[]" value="export" />
                                                    <label for="export">Export</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="edit" name="module_permission[]" value="edit" />
                                                    <label for="edit">Edit</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="subscribers" name="module_permission[]"  value="subscribers" />
                                                    <label for="subscribers">Subscribers</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="fund_raising" name="module_permission[]" value="fund_raising" />
                                                    <label for="fund_raising">Fund Raising</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="admin_report" name="module_permission[]" value="admin_report" />
                                                    <label for="admin_report">Admin Report</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="upload_deals" name="module_permission[]" value="upload_deals" />
                                                    <label for="upload_deals">Upload Deals</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="reports" name="module_permission[]" value="reports" />
                                                    <label for="reports">Reports</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="user_management" name="module_permission[]" value="user_management" />
                                                    <label for="user_management">User Management</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="currency_conversion" name="module_permission[]" value="currency_conversion" />
                                                    <label for="currency_conversion">Currency Conversion</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="upload_league" name="module_permission[]" value="upload_league" />
                                                    <label for="upload_league">League Table</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="upload_weeklyNL" name="module_permission[]" value="upload_weeklyNL" />
                                                    <label for="upload_weeklyNL">Upload weeklyNL</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="upload_unicornTrack" name="module_permission[]" value="upload_unicornTrack" />
                                                    <label for="upload_unicornTrack">Upload Unicorn</label> 
                                                </div>
                                                 <div>
                                                    <input type="checkbox" id="faq" name="module_permission[]" value="faq" />
                                                    <label for="faq">FAQ</label> 
                                                </div>
                                                <div>
                                                    <input type="checkbox" id="LPDir" name="module_permission[]" value="LPDir" />
                                                    <label for="LPDir">LPDir</label> 
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                                <div style="text-align: center; margin-top: 20px;">
                                    <input type="submit" id="add_btn" name="add_btn" value="Add" />
                                    <button type="button" name="cancel_user" id="cancel_user">Cancel</button>
                                </div>
                            </form>
                            <!-- <div>
                                <label for="user_name">User Name</label> 
                                <input type="text" id="user_name" size="26" name="user_name" class="req_value" forerror="UserName" value="">
                            </div>
                            <div>
                                <label for="password">Password</label> 
                                <input type="text" id="password" size="26" name="password" class="req_value" forerror="UserName" value="">
                            </div>
                            <div>
                                <label for="email">Email</label> 
                                <input type="text" id="email" size="26" name="email" class="req_value" forerror="UserName" value="">
                            </div>
                            <div>
                                <label for="first_name">First Name</label> 
                                <input type="text" id="first_name" size="26" name="first_name" class="req_value" forerror="UserName" value="">
                            </div>
                            <div>
                                <label for="last_name">Last Name</label> 
                                <input type="text" id="last_name" size="26" name="last_name" class="req_value" forerror="UserName" value="">
                            </div>
                            <div>
                                <label for="">Module Permission</label> <br/>
                                <div>
                                    <label for="import">Import</label> 
                                    <input type="checkbox" id="import" name="module_permission[]" value="import" />
                                </div>
                                <div>
                                    <label for="export">Export</label> 
                                    <input type="checkbox" id="export" name="module_permission[]" value="export" />
                                </div>
                                <div>
                                    <label for="edit">Edit</label> 
                                    <input type="checkbox" id="edit" name="module_permission[]" value="edit" />
                                </div>
                                <div>
                                    <label for="subscribers">Subscribers</label> 
                                    <input type="checkbox" id="subscribers" name="module_permission[]" value="subscribers" />
                                </div>
                                <div>
                                    <label for="fund_raising">Fund Raising</label> 
                                    <input type="checkbox" id="fund_raising" name="module_permission[]" value="fund_raising" />
                                </div>
                                <div>
                                    <label for="admin_report">Admin Report</label> 
                                    <input type="checkbox" id="admin_report" name="module_permission[]" value="admin_report" />
                                </div>
                                <div>
                                    <label for="upload_deals">Upload Deals</label> 
                                    <input type="checkbox" id="upload_deals" name="module_permission[]" value="upload_deals" />
                                </div>
                                <div>
                                    <label for="reports">Reports</label> 
                                    <input type="checkbox" id="reports" name="module_permission[]" value="reports" />
                                </div>
                                <div>
                                    <label for="user_management">User Management</label> 
                                    <input type="checkbox" id="user_management" name="module_permission[]" value="user_management" />
                                </div>
                            </div> -->
                        </div>
                    </div><!-- end of headingtextpro-->
                </div> <!-- end of maintext pro-->
           </div>
    	</div>
    </div>

    <div class="bottom-section">
        <div style="padding-top: 10px;height: 25px;font-size: 11px;margin-left: 0px;padding-left: 25px; width: 75%; float: left;">
            <span><a href="../index.htm">Home</a> I <a href="../products.htm">Products</a> I </span>
            <span><a href="../events.htm">Events</a> I<a href="../investors.htm"> Investors</a> I </span>
            <span><a href="../entrepreneurs.htm">Entrepreneurs</a> I <a href="../serviceproviders.htm">Service Providers</a> I  </span>
            <span><a  href="../news.htm">News</a> I <a href="../aboutus.htm">About Us</a> I</span>
            <span><a href="../contactus.htm"> Contact Us</a>	</span>
        </div>
        <div id="copyright">� TSJ Media Pvt. Ltd</div>
    </div>
</div>
  <!-- Ending Work Area -->

<!--   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>-->

   <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
  </script>
  <script>
  $( '#cancel_user' ).on('click', function() {
    window.location.href = '<?php echo BASE_URL; ?>adminvi/users.php';
  });
  $( '#module_all' ).on( 'change', function(e) {
    var checkAllProp = $(e.currentTarget).prop('checked');
    if( checkAllProp ) {
        $('input[name="module_permission[]"]').prop('checked',true);    
    } else {
        $('input[name="module_permission[]"]').prop('checked',false);
    }
    //$('input[value="subscribers"]').prop('checked',true);
  });
  $('input[name="module_permission[]"]').on( 'change', function(e) {
    var modulelength = $('input[name="module_permission[]"]').length;
    var moduleCheckedlength = $('input[name="module_permission[]"]:checked').length;
    if( moduleCheckedlength == modulelength ) {
        $( '#module_all' ).prop( 'checked', true );
    } else {
        $( '#module_all' ).prop( 'checked', false );
    }
  });
  $( '#add_btn' ).on('click', function(){
    var error = 0;
    var msg = '';
    var user_name = $( '#user_name' ).val();
    var password = $( '#password' ).val();
    var email = $( '#email' ).val();
    var first_name = $( '#first_name' ).val();
    var checkedlength = $('input[name="module_permission[]"]:checked').length
    if( user_name == "" ) {
        error = 1;
        msg += "\n     -  Please enter user name";
    }
    if( password == "" ) {
        error = 1;
        msg += "\n     -  Please enter password";
    }
    if( !validateEmail( email ) ) {
        error = 1;
        msg += "\n     -  Please enter valid email";
    }
    if( first_name == "" ) {
        error = 1;
        msg += "\n     -  Please enter first name";
    }
    if( checkedlength == 0 ) {
        error = 1;
        msg += "\n     -  Please choose atleast one module permission";
    }
    if( error == 1 ) {
        alert(msg);
        return false;
    }
  });
    function validateEmail(sEmail) {
        var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
        if (filter.test(sEmail)) {
            return true;
        }
        else {
            return false;
        }
    }
  </script>
</body>
</html>
<?php

} // if resgistered loop ends
else
    header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>