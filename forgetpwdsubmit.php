<?php 
include "onlineaccount.php";
$pwdemail=$_POST['forgotpwdemailid']; 
$pwdForDB=$_POST['txtpwdforDB'];
if($pwdForDB == "") {
   $pwdForDB="cfs";
}
$displayMessage="";

//require_once("reconfig.php");
require_once("dbconnectvi.php");
$Db = new dbInvestments();
if(trim($pwdemail)!="")
{

  if($pwdForDB == "" || $pwdForDB == "cfs") { 
    $checkForUnknownLoginSql="select * from users where username='$pwdemail'";
    $firstnamesql="select firstname from users where username='$pwdemail'";
  } else if ($pwdForDB == "P" || $pwdForDB == "R" || $pwdForDB == "M") {
    // $checkForUnknownLoginSql="select * from dealmembers where EmailId='$pwdemail'";
    // $firstnamesql="select Name from dealmembers where EmailId='$pwdemail'";
    if ($pwdForDB == "P"){
      $checkForUnknownLoginSql="select * from dealmembers where EmailId='$pwdemail'";
      $firstnamesql="select Name from dealmembers where EmailId='$pwdemail'";
    }else if($pwdForDB == "R"){
      $checkForUnknownLoginSql="select * from RElogin_members where EmailId='$pwdemail'";
      $firstnamesql="select Name from RElogin_members where EmailId='$pwdemail'";
    }else if($pwdForDB == "M"){
      $checkForUnknownLoginSql="select * from malogin_members where EmailId='$pwdemail'";
      $firstnamesql="select Name from malogin_members where EmailId='$pwdemail'";
    }else{
      $checkForUnknownLoginSql="select * from dealmembers where EmailId='$pwdemail'";
      $firstnamesql="select Name from dealmembers where EmailId='$pwdemail'";
    }
  }
  /*  else if($pwdForDB == "R") {
    $checkForUnknownLoginSql="select * from dealmembers where EmailId='$pwdemail'";
  } else if($pwdForDB == "M") {
    $checkForUnknownLoginSql="select * from dealmembers where EmailId='$pwdemail'";
  } */
  
  
  // MA - $checkForUnknownLoginSql="select * from dealmembers where EmailId='$pwdemail'";

 // $firstnamesql="select firstname from users where username='$pwdemail'";
 
  $firstnamedata=mysql_query($firstnamesql);
	if($rsRandom=mysql_query($checkForUnknownLoginSql))
	{
		 $random_cnt= mysql_num_rows($rsRandom);
	}
  while($row=mysql_fetch_array($firstnamedata,MYSQLI_ASSOC)){
  if($pwdForDB == "" || $pwdForDB == "cfs") {
  $firstname=$row['firstname'];
  }else if ($pwdForDB == "P" || $pwdForDB == "R" || $pwdForDB == "M") {
    $firstname=$row['Name'];
  }
  }
	//echo "<br>----" .$random_cnt;

	$UnauthorisedLoginMessage="Your are not listed as a database subscriber. Please contact us for subscription information. <a href='contactus.htm'> Contact us >> </a>";
  
  
function RandomToken($length = 10){
  // if(!isset($length) || intval($length) <= 8 ){
  //   $length = 32;
  // }
  if (function_exists('random_bytes')) {
      return bin2hex(random_bytes($length));
  }
  if (function_exists('mcrypt_create_iv')) {
     return bin2hex(mcrypt_create_iv($length, MCRYPT_DEV_URANDOM));
  } 
  if (function_exists('openssl_random_pseudo_bytes')) {
      return bin2hex(openssl_random_pseudo_bytes($length));
  }
}

function token(){
  return substr(strtr(base64_encode(hex2bin(RandomToken(32))), '+', '.'), 0, 25);
}


	if($random_cnt==1)
	{
		
      $DBPwd="Company Financials Search"; 
      $token = token();
      //$date = date("Y-m-d");
      $date =  date("Y-m-d H:i:s");

      $reset_detail = "INSERT INTO password_reset(email, db_type, token, token_date,status) VALUES ('$pwdemail', '$pwdForDB', '$token','$date',0)";
      $results = mysql_query($reset_detail);
			
    // $displayMessage=$forgotpwdMessage;
    $displayMessage='Password reset link has been sent to your email id';
    $from   = 'subscription@ventureintelligence.in';
		$headers  = "MIME-Version: 1.0\n";
		$headers .= "Content-type: text/html;
		charset=iso-8859-1;Content-Transfer-Encoding: 7bit\n";

    $headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
    $headers .= "From: $from\r\n";
    $headers .= 'Bcc: subscription@ventureintelligence.com' . "\r\n";
    //$headers .= 'Bcc: krishna.s@praniontech.com' . "\r\n";

		/* additional headers
		$headers .= "Cc: sow_ram@yahoo.com\r\n"; */

		$RegDate=date("M-d-Y");
    $to= $pwdemail; 
   
    //$to="vijayakumar.k@praniontech.com,krishna.s@praniontech.com";
    $subject="Reset Password -" .$pwdemail ;
		$message="<html>
    <head>
    </head>
    <body>
    <p>Dear $firstname,</p>
    <p>To reset the password for your Venture Intelligence Database, click the web address below or copy and paste it into your browser:</p>
    <p><a href='".BASE_URL."password-reset.php?key=$token' target='_blank'>".BASE_URL."password-reset.php?key=".$token."</a></p>
    <p>This link will expire within 12 hours. If you do not wish to reset your password, simply ignore this email and nothing will be changed.</p>
    <p><b>Please Note :</b> Resetting your password will also change the password for the other <a href='".BASE_URL."index.htm' target='_blank'>Venture Intelligence Databases</a> you are subscribed to.</p>
    <p>If you have questions or need further assistance, feel free to contact us at subscription@ventureintelligence.com or +91-44-4218-5180 / 82.</p>
    <br/>
    <p>Venture Intelligence Team.</p>
    
          </body>
          </html>";
		 mail($to,$subject,$message,$headers);
	}
	else
	{
		$displayMessage=$UnauthorisedLoginMessage;

	}
	
}



?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>Venture Intelligence</title>
<link href="<?php echo $refUrl; ?>cfsnew/css/skin.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="<?php echo $refUrl; ?>cfsnew/css/detect800.css" />

<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script> 

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
 
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<script src="js/jPages.js"></script>
<script src="js/jquery.icheck.min.js?v=0.9.1"></script>-->
<!--<link rel="stylesheet" href="/resources/demos/style.css" /> -->

<script type="text/javascript" src="<?php echo $refUrl; ?>cfsnew/js/jquery-1.8.2.min.js"></script> 
 
 
</head>

<body> 
 
<!--Header-->

<div class="login-screen">

<div class="header"><img src="<?php echo $refUrl; ?>images/logo.gif" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></div>
<h3 style="text-align:center;  margin-top: 40px !important;"> Reset Password </h3> 
<div class="login-cnt" style="margin-top:20px !important; "> 
    <ul> 
            <li style="text-align:center;"><?php echo $displayMessage; ?> </li>      
    </ul> 
</div> 
</body>
</html>
<?php mysql_close(); ?>



