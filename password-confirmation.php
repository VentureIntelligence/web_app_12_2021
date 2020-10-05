<?php include_once("globalconfig.php"); ?>
<?php
include "onlineaccount.php";
$passwordForDB = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

require_once("dbconnectvi.php");
$Db = new dbInvestments();

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
  <!-- Global site tag (gtag.js) - Google Analytics -->
 <script async src="https://www.googletagmanager.com/gtag/js?id=UA-168374697-1"></script>
 <script>
   window.dataLayer = window.dataLayer || [];
   function gtag(){dataLayer.push(arguments);}
   gtag('js', new Date());
 
   gtag('config', 'UA-168374697-1');
 </script>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>Reset Password  - Venture Intelligence</title>
<link href="cfsnew/css/skin.css" rel="stylesheet" type="text/css" />    
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
     <h3 style="text-align:center;  margin-top: 40px !important;"> Reset Password </h3>
	<div class="login-cnt forgot-screen" style="width: 400px; margin-top:20px !important;">    

      <?php 
          $emailAddress = false;
          $noError = false;
          if(isset($_POST['id']) && isset($_POST['email']) && isset($_POST['new_pass'])  && isset($_POST['db_type'])){
              $id = $_POST['id'];
              $emailid = $_POST['email'];
              $newpasswordMD5 = md5($_POST['new_pass']);
              $newpassword = $_POST['new_pass']; 
              $resetUserDbType = $_POST['db_type'];  

              // update cfs 
              $getCountCfs = mysql_query("select * from users where username='$emailid'");
              $getCountCfs = mysql_num_rows($getCountCfs); 
              if($getCountCfs >=1) {
                $updatepwdrsCfs = mysql_query("Update users set user_password='$newpasswordMD5' where username='$emailid'"); 
                if($updatepwdrsCfs) { $noError = true; } else { $noError = false;   }
              }

              // update PE
              
              $getCountPe = mysql_query("select * from dealmembers where EmailId='$emailid'");
              $getCountPe = mysql_num_rows($getCountPe); 
              if($getCountPe >=1) {
                $updatepwdrsPe = mysql_query("Update dealmembers set Passwrd='$newpasswordMD5' where EmailId='$emailid'"); 
                if($updatepwdrsPe) { $noError = true; } else { $noError = false;   }
              }


              // update RE 
              
              $getCountRe = mysql_query("select * from RElogin_members where EmailId='$emailid'");
              $getCountRe = mysql_num_rows($getCountRe); 
              if($getCountRe >=1) {
                $updatepwdrsRe=mysql_query("Update RElogin_members set Passwrd='$newpasswordMD5' where EmailId='$emailid'"); 
                if($updatepwdrsRe) { $noError = true; } else { $noError = false;   }
              }
              // update MA
              $getCountMa = mysql_query("select * from malogin_members where EmailId='$emailid'");
              $getCountMa = mysql_num_rows($getCountMa); 
              if($getCountMa >=1) {
                $updatepwdrsMa=mysql_query("Update malogin_members set Passwrd='$newpasswordMD5' where EmailId='$emailid'"); 
                if($updatepwdrsMa) { $noError = true; } else { $noError = false;   }
              }

              if($noError) {

             
                // $mainURL = "http://localhost/ventureintelligence/"; 

                $mainURL = GLOBAL_BASE_URL; 

                if($resetUserDbType =='cfs') { $loginUrl="$mainURL"."cfsnew/login.php";  }
                if($resetUserDbType =='P') { $loginUrl="$mainURL"."pelogin.php";  }
                if($resetUserDbType =='R') { $loginUrl="$mainURL"."relogin.php";  }
                if($resetUserDbType =='M') { $loginUrl="$mainURL"."malogin.php";  }
                
                  $UpdatePwdSql=mysql_query("UPDATE `password_reset` SET `status` = '1' WHERE `password_reset`.`id` = '$id'");
                ?>   <p style="text-align:center;">  Your password has been reset. Please
                
                 <a href="<?php echo $loginUrl;?>"> Click Here  </a> to Login  </p>  <?php
              } else {
                ?>   <p> <center> There is some issue in Password reset Process </center> </p> <br /> <br />   <?php 
              }


              /*
              if($updatepwdrs=mysql_query($UpdatePwdSql))
                {
                  $getCountOthers = mysql_query("select * from malogin_members where EmailId='$emailid'");
                  $getCountOthers = mysql_num_rows($getCountOthers);
                  if($getCountOthers >=1) {
                  mysql_query("Update malogin_members set Passwrd='$newpassword' where EmailId='$emailid'"); 
                 }
                  $UpdatePwdSql=mysql_query("UPDATE `password_reset` SET `status` = '1' WHERE `password_reset`.`id` = '$id'");
                 ?>
                   <p> <center> Your password has been reset. Please <a href="#">  Click Here  </a> to Login </center> <br /> <br /> 
                 <?php 
                } else {
                  ?> 
                <p> <center> There is some issue in Password reset Process </center> <br /> <br /> 
                  <?php 
                }
                */

              }
      ?>

    </div>
  </div>
  <div style="clear: both;"></div>

  <h4 id="message-container"> </h4>

  <footer class="footer-container">
      <div class="footer-sec"> <span>© 2018 TSJ Media Pvt Ltd. All rights reserved. </span> <!--<a href="http://kutung.com/" class="fr">it's a kutung</a>--> </div>
  </footer>
  
 

 
</body>
</html>




