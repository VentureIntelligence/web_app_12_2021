<?php include_once("../globalconfig.php"); ?>
<?php
include "../onlineaccount.php";
$passwordForDB = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

require_once("../dbconnectvi.php");
$Db = new dbInvestments();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>Reset Password  - Venture Intelligence</title>
<link href="css/skin.css" rel="stylesheet" type="text/css" />    
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>  
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.0/dist/jquery.validate.js"></script> 

<style>
    body.forgotpwd{ height: 100vh;}
    .footer-container {
      background: #232323;width: 100%;overflow: hidden;position: absolute;bottom: 0px;
    }
    .footer-sec {
      max-width: 1170px;margin: 0 auto; padding: 20px 0; text-align: center;
    }
    .footer-sec span {
      color: #8a8f8f;font-size: 13px;
    }
    .help-block-login {
      text-align: right;
      color: #c93b3b;
      font-size: 11px;
    }
    #newpassword-error.help-block-login {
      width: 60% ;
      margin-left: auto;
      margin-right: auto;
    }
    #new_pass_c-error {
      width:100%;
    }
    #message-container {
      text-align:center;
      margin-top:20px;
    }
  </style>
</head>

<body class="forgotpwd"> 
 
  <!--Header-->

  <div class="login-screen">

    <div class="header"><img src="images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></div>
    <div class="login-cnt forgot-screen" style="width: 400px;">  
    <?php   
        
        $key = $_GET['key'];
          
        $getresetDetail = "SELECT * FROM password_reset WHERE token='$key' LIMIT 1";
        $getresetDetailResult = mysql_query($getresetDetail);
        $getresetDetailResult = mysql_fetch_assoc($getresetDetailResult); 
          

          $resetUserId =   $getresetDetailResult['id'];
          $resetUserEmail =   $getresetDetailResult['email'];
          $resetUserDbType =   $getresetDetailResult['db_type'];
          $resetUserTokenDate =   $getresetDetailResult['token_date'];
          $resetUserStatus =   $getresetDetailResult['status'];          
          $dateFromDatabase = strtotime($resetUserTokenDate);
          $dateTwelveHoursAgo = strtotime("-12 hours");
 
          if ($dateFromDatabase >= $dateTwelveHoursAgo && $resetUserStatus !=1) {
           // echo 'With in  12 hours'.'<br />';
           // echo 'resetUserTokenDate='.$resetUserTokenDate;
             ?> 
          <form class="login-form" action="password-confirmation.php" method="post">
          <input type="hidden" name="id" id="id" value="<?php echo $resetUserId;?>" />
          <input type="hidden" name="token" id="token"  value="<?php echo $_GET['key'];?>" />
          <input type="hidden" name="status" id="status" value="<?php echo $resetUserStatus;?>" />
          <input type="hidden" name="db_type" id="db_type" value="<?php echo $resetUserDbType;?>" />
          <input type="hidden" name="email" id="email" value="<?php echo $resetUserEmail;?>" />
            <ul>           
           <li><label style="width:40%;"> Password:  </label>  <input type="password" id="newpassword" name="new_pass" 
            style="width: 55% !important;text-align:left !important;padding: 5px;" />         
           <li><label style="width:40%; float:left;text-align: left;">Re-enter Password:  </label> 
            <input type="password" id="" name="new_pass_c" style="width: 55% !important;text-align:left !important;"padding: 5px; /> 
           <li>
           <center> <input type="submit" name="reset_pass"  class="login-btn" value ="SUBMIT"/> </center> </li>
           </ul>
          </form>
          <?php 
          }
          else {
              //echo 'more than 12 hours ago'.'<br />';
              //echo 'resetUserTokenDate='.$resetUserTokenDate;
              ?> 
              <h4> Your password has been expired, kindly reset password again. </h4> <br />
              <?php 

             
              if($resetUserDbType =='cfs') {
                ?> Click here to    <a href="<?php echo $loginUrl;?>"> <a href="<?php echo GLOBAL_BASE_URL; ?>cfsnew/forgetpwd.php?value=cfs"> Reset Password </a> <?php
              } else if($resetUserDbType =='P') {
                ?> Click here to  <a href="<?php echo GLOBAL_BASE_URL; ?>cfsnew/forgetpwd.php?value=P"> Reset Password </a> <?php
              } else if($resetUserDbType =='R') {
                ?> Click here to  <a href="<?php echo GLOBAL_BASE_URL; ?>cfsnew/forgetpwd.php?value=R"> Reset Password </a> <?php
              } else if($resetUserDbType =='M') {
                ?> Click here to <a href="<?php echo GLOBAL_BASE_URL; ?>cfsnew/forgetpwd.php?value=M"> Reset Password </a> <?php
              } 
          }

 
    ?> 

       

     


    </div>
  </div>
  <div style="clear: both;"></div>

  <h4 id="message-container"> </h4>

  <footer class="footer-container">
      <div class="footer-sec"> <span>© 2018 TSJ Media Pvt Ltd. All rights reserved. </span> <!--<a href="http://kutung.com/" class="fr">it's a kutung</a>--> </div>
  </footer>
  

  
  <script>   /*
  $(document).ready(function(){  
        var email           = $('#email').val();
          var reset_password   = $('#newpassword').val();
          var status          = $('#status').val();
          var id              = $('#id').val();
          var db_type         = $('#db_type').val();

          console.log('id',id);

        $('form').on('submit', function (e) {
         e.preventDefault();
         $.ajax({
            type: 'post',
            url: 'password-logic.php', 
            data: {password:$('#newpassword').val(),email: email, id: id,db_type:db_type},
            success: function (data) {
              alert(data);
              if(data ==1) { 
                $("#message-container").html("Password has been changed across all the databases");
                $("#message-container").html(data); 
              } else {
                $("#message-container").html("There is some issue - Re-enter your password detail");
              }
              
            }
          });

        });

      }); */
    </script>


  <script>
    $(".login-form").validate({
            rules : {
              new_pass: "required",
              new_pass_c: {
                equalTo: "#newpassword"
              }
            },
            messages : {
              new_pass: 'Please enter your new password',
              new_pass_c: 'Enter Confirm password same as new password'
            },
              errorElement: "div",
              errorClass: 'help-block-login',
              errorPlacement : function(error, element) {
              error.insertAfter(element.parent());
            }

          }); 
  </script>
</body>
</html>
