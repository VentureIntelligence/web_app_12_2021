<?php include_once("../globalconfig.php"); ?>
<?php
 session_save_path("/tmp");
session_start();
/*
	filename - malogin.php
    formanme - malogin
    invoked from -  direct from website link
    invoked to - peauthenticate.php
  */
  //setcookie("TCook");
require("../dbconnectvi.php");
require("maconfig.php");
$Db = new dbInvestments();
$Db->dbInvestments();
$displayMessage="";
include "../onlineaccount.php";

if ($_POST['btnSubmit']=='Authorize'){
    $displayMessage = '';
    
    //Valdation
    if ($_POST['emailid']=='')
        $displayMessage = 'Please enter your email address<br>';
    if ($_POST['authCode']=='')
        $displayMessage .= 'Please enter the authorization code<br>';
    
    
    if ($displayMessage==''){
        $userEmail = strtolower($_POST['emailid']);
        $authCode  = $_POST['authCode'];
        $today     = date('Y-m-d');
        
        //Check if the auth code is correct
        $sqlAuthCheck = "SELECT `expDate` FROM `user_auth_code` WHERE `emailId`='".$userEmail."' AND `dbType`='MA' AND `authCode`='$authCode' AND `expDate` >= '".$today."'";
        $resAuthCheck = mysql_query($sqlAuthCheck);
        $cntAuthCheck = mysql_num_rows($resAuthCheck);
        
        // if($_POST['autdevice'] > 0 && $_POST['autdevice']!='' && $cntAuthCheck==1){
          if($_POST['autdevice'] > 0 && $_POST['autdevice']!=''){
            // $sqlnewdevice = "update user_authorized_device set `status`=1 where id=".$_POST['autdevice'];
            // mysql_query($sqlnewdevice);
               
            // $sqlreuserstatus = "update RElogin_members set user_authorization_status=1 where EmailId ='".$userEmail."'";
            //     mysql_query($sqlreuserstatus) or die(mysql_error());
                
            // $sqlpeuserstatus = "update dealmembers set user_authorization_status=1 where EmailId ='".$userEmail."'";
            // mysql_query($sqlpeuserstatus) or die(mysql_error());

        }else{
            
               if(strpos($_SERVER['HTTP_USER_AGENT'], 'Windows') !== FALSE)
                   $user_os =  'Windows';
               elseif((strpos($_SERVER['HTTP_USER_AGENT'], 'Android') !== FALSE) && strpos($_SERVER['HTTP_USER_AGENT'], 'Linux')!==FALSE)
                   $user_os = 'Android';
               elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Linux') !== FALSE) //For Supporting IE 11
                   $user_os =  'Linux';
               elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPhone') !== FALSE)
                   $user_os = 'IOS';
               elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'iPad') !== FALSE)
                   $user_os = 'IOS';
               elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Macintosh') !== FALSE || strpos($_SERVER['HTTP_USER_AGENT'], 'Mac') !== FALSE)
                   $user_os = 'iOS';

               if($user_os=='IOS'){      

                   if(strpos($_SERVER['HTTP_USER_AGENT'], 'FxiOS') !== FALSE)
                       $user_browser = 'Firefox';
                   elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'CriOS') !== FALSE)
                       $user_browser = 'Chrome';
                   else
                       $user_browser = "Safari";
               }else{

                   if(strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE') !== FALSE)
                       $user_browser =  'IE';
                   elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Trident') !== FALSE) //For Supporting IE 11
                       $user_browser =  'IE';
                   elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Edge') !== FALSE) //For Supporting IE EDGE
                       $user_browser =  'IE';
                   elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Firefox') !== FALSE)
                       $user_browser = 'Firefox';
                   elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Chrome') !== FALSE)
                       $user_browser = 'Chrome';
                   elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera Mini') !== FALSE)
                       $user_browser = "Opera_Mini";
                   elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Opera') !== FALSE)
                       $user_browser = "Opera";
                   elseif(strpos($_SERVER['HTTP_USER_AGENT'], 'Safari') !== FALSE)
                       $user_browser = "Safari";
               }

            /*echo $_SERVER['HTTP_USER_AGENT'];
               echo $user_os;
               echo $user_browser;*/

               $exp_user = explode(' ',$_SERVER['HTTP_USER_AGENT']);

               if($user_os=='IOS'){

                   $searchKey = search_array($exp_user, 'Mobile');
                   $deviceId = str_replace('/', '_', $exp_user[$searchKey]);
               }else{

                   $searchKey = search_array($exp_user, $user_browser);
                   $deviceId = str_replace('/', '_', $exp_user[$searchKey]);
               }

                $device_details = $user_os."_".$user_browser."_".$deviceId;

                $sqlgetdeviceCnt = "SELECT * FROM user_authorized_device WHERE `user_email`='".$userEmail."' and device_details='".$device_details."' ";
                $resgetdeviceCnt = mysql_query($sqlgetdeviceCnt) or die(mysql_error());

                if(mysql_num_rows($resgetdeviceCnt) > 0){

                   // $sqlnewdevice = "update user_authorized_device set `status`=1 WHERE `user_email`='".$userEmail."' and device_details='".$device_details."'";
                   // mysql_query($sqlnewdevice) or die(mysql_error());
                }else{

                    $sqlnewdevice = "insert into user_authorized_device (user_email,device_details,status) values ('".$userEmail."','".$device_details."',1 )";
                    mysql_query($sqlnewdevice) or die(mysql_error());
                }
                
        if ($cntAuthCheck==1){

                    $sqlmemberstatus = "update dealmembers set user_authorization_status=1 where EmailId ='".$userEmail."'";
                    mysql_query($sqlmemberstatus) or die(mysql_error());

                    /*$sqluserstatus = "update users set user_authorized_status=1 where email ='".$userEmail."' or username = '".$userEmail."'";
                    mysql_query($sqluserstatus) or die(mysql_error());*/

                    $sqlreuserstatus = "update RElogin_members set user_authorization_status=1 where EmailId ='".$userEmail."'";
                    mysql_query($sqlreuserstatus) or die(mysql_error());

                    $sqlmauserstatus = "update malogin_members set user_authorization_status=1 where EmailId ='".$userEmail."'";
                    mysql_query($sqlmauserstatus) or die(mysql_error());


                    
                }
        }
        
        if ($cntAuthCheck==1){
            //Check if cookie can be created. Should not have exceeded device limit
            $devicesUsed = getDevicesUsedCount($userEmail);
            $sqlgetdevCnt = "SELECT * FROM `malogin_members` WHERE `EmailId`='".$userEmail."'";
            $resgetdevCnt = mysql_query($sqlgetdevCnt);
            $cntgetdevRes = mysql_fetch_array($resgetdevCnt);
            $allowedNoDevices = $cntgetdevRes['deviceCount'];
            
            if ($devicesUsed <= $allowedNoDevices){
                
                //Create Cookie
                $cookieMAName = 'MA'.$cntgetdevRes['Name'].'-'.$cntgetdevRes['DCompId'].'-'.rand();
                $currMACookieArray[$userEmail]=$cookieMAName;
                $currMACookieJson=  json_encode($currMACookieArray);
                setcookie('maLoginAuth',$currMACookieJson,time() + (86400 * 365),'/'); // 86400 = 1 day //Create Cookie  

                //Store Cookie value in DB
                $sqlInsCookie = "INSERT INTO `userlog_device` (`EmailId`,`deviceId`,`DCompId`,`dbType`)";
                $sqlInsCookie .= " VALUES ('".$userEmail."','".$cookieMAName."','".$cntgetdevRes['DCompId']."','MA')";
                mysql_query($sqlInsCookie) or die(mysql_error());
                                
                //Delete authcode record in DB
                $sqlDelAuthCode = "DELETE FROM `user_auth_code` WHERE `emailId`='".$userEmail."' AND `dbType`='MA' AND `authCode`='$authCode'";
                mysql_query($sqlDelAuthCode);

                
                
                //Check if cookie can be created. Should not have exceeded device limit
                $devicesUsed = getDevicesUsedCount($userEmail);
                $sqlgetdevCnt = "SELECT * FROM `RElogin_members` WHERE `EmailId`='".$userEmail."'";
                $resgetdevCnt = mysql_query($sqlgetdevCnt);
                $cntgetdevRes = mysql_fetch_array($resgetdevCnt);
                $allowedNoDevices = $cntgetdevRes['deviceCount'];

                if ($devicesUsed < $allowedNoDevices){
                    
                    //Create Cookie
                    $cookieREName = 'RE'.$cntgetdevRes['Name'].'-'.$cntgetdevRes['DCompId'].'-'.rand();
                    $currRECookieArray[$userEmail]=$cookieREName;
                    $currRECookieJson=  json_encode($currRECookieArray);
                    setcookie('reLoginAuth',$currRECookieJson,time() + (86400 * 365),'/'); // 86400 = 1 day //Create Cookie  

                    //Store Cookie value in DB
                    $sqlInsCookie = "INSERT INTO `userlog_device` (`EmailId`,`deviceId`,`DCompId`,`dbType`)";
                    $sqlInsCookie .= " VALUES ('".$userEmail."','".$cookieREName."','".$cntgetdevRes['DCompId']."','RE')";
                    mysql_query($sqlInsCookie) or die(mysql_error());

                    //Delete authcode record in DB
                    $sqlDelAuthCode = "DELETE FROM `user_auth_code` WHERE `emailId`='".$userEmail."' AND `dbType`='RE' AND `authCode`='$authCode'";
                    mysql_query($sqlDelAuthCode);

                }else{
                    $displayMessage = 'You have exceeded the allowed number of devices from which you can login. Please contact us at subscription@ventureintelligence.com for more details';
                }
                
                
                $devicesUsed = getDevicesUsedCount($userEmail);
                $sqlgetdevCnt = "SELECT * FROM `dealmembers` WHERE `EmailId`='".$userEmail."'";
                $resgetdevCnt = mysql_query($sqlgetdevCnt);
                $cntgetdevRes = mysql_fetch_array($resgetdevCnt);
                $allowedNoDevices = $cntgetdevRes['deviceCount'];

                if ($devicesUsed < $allowedNoDevices){
                    
                    //Create Cookie
                    $cookiePEName = 'PE'.$cntgetdevRes['Name'].'-'.$cntgetdevRes['DCompId'].'-'.rand();
                    $currPECookieArray[$userEmail]=$cookiePEName;
                    $currPECookieJson=  json_encode($currPECookieArray);
                    setcookie('peLoginAuth',$currPECookieJson,time() + (86400 * 365),'/'); // 86400 = 1 day //Create Cookie  

                    //Store Cookie value in DB
                    $sqlInsCookie = "INSERT INTO `userlog_device` (`EmailId`,`deviceId`,`DCompId`,`dbType`)";
                    $sqlInsCookie .= " VALUES ('".$userEmail."','".$cookiePEName."','".$cntgetdevRes['DCompId']."','PE')";
                    mysql_query($sqlInsCookie) or die(mysql_error());

                    //Delete authcode record in DB
                    $sqlDelAuthCode = "DELETE FROM `user_auth_code` WHERE `emailId`='".$userEmail."' AND `dbType`='PE' AND `authCode`='$authCode'";
                    mysql_query($sqlDelAuthCode);
                    
                 }else{
                    $displayMessage = 'You have exceeded the allowed number of devices from which you can login. Please contact us at subscription@ventureintelligence.com for more details';
                }
                
                
                
                //Message to login
                /*$successMessage = 'You have successfully authorized this device. <a href="malogin.php">Login Here</a>';
                $userEmail = '';
                $authCode  = '';*/


                $sqlnewdevice = "update user_authorized_device set `status`=1, `device_details`='".$_GET['device_detail']."' where id=".$_POST['autdevice'];
                mysql_query($sqlnewdevice);

                // $sqlnewdevice = "update user_authorized_device set `status`=1 where id=".$_POST['autdevice'];
                // mysql_query($sqlnewdevice);
                   
                $sqlreuserstatus = "update RElogin_members set user_authorization_status=1 where EmailId ='".$userEmail."'";
                    mysql_query($sqlreuserstatus) or die(mysql_error());
                    
                $sqlpeuserstatus = "update dealmembers set user_authorization_status=1 where EmailId ='".$userEmail."'";
                mysql_query($sqlpeuserstatus) or die(mysql_error());

                
                header( 'Location: '. GLOBAL_BASE_URL .'malogin.php?auth=1' ) ;
//                header("location:malogin.php?auth=1");
                exit;
                
            }else{
                $displayMessage = 'You have exceeded the allowed number of devices from which you can login. Please contact us at subscription@ventureintelligence.com for more details';
            }
        }else{
            $displayMessage = 'Invalid Email / Authorization Code or Authorization Code has expired';
        }
    }
}

/*function getDevicesUsedCount($email,$db){
    $sqlCheckDevice = "SELECT `deviceId` FROM `userlog_device` WHERE `EmailId`='".$email."' AND `dbType`='".$db."'  AND auth_type='0' ";
    $resCheckDevice = mysql_query($sqlCheckDevice) or die(mysql_error());
    $cntCheckDevice = mysql_num_rows($resCheckDevice);
    return $cntCheckDevice;
}*/

function getDevicesUsedCount($email){
    $sqlCheckDevice = "SELECT `id` FROM `user_authorized_device` WHERE `user_email`='".$email."'  AND status=1 ";
    $resCheckDevice = mysql_query($sqlCheckDevice) or die(mysql_error());
    $cntCheckDevice = mysql_num_rows($resCheckDevice);
    return $cntCheckDevice;
}

 function search_array ( array $array, $term )
{
    foreach ( $array as $key => $value )
        if ( stripos( $value, $term ) !== false )
            return $key;

    return false;
}  
                                
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<META NAME="ROBOTS" CONTENT="NOINDEX, NOFOLLOW">
<title>Venture Intelligence</title>
<link href="<?php echo $refUrl; ?>css/skin.css" rel="stylesheet" type="text/css" />  
<link rel="stylesheet" type="text/css" href="<?php echo $refUrl; ?>css/detect800.css" />

<!--<script src="http://code.jquery.com/jquery-1.9.1.js"></script> 

<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" />
 
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>


<script src="js/jPages.js"></script>
<script src="js/jquery.icheck.min.js?v=0.9.1"></script>-->
<!--<link rel="stylesheet" href="/resources/demos/style.css" /> -->

<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery-1.8.2.min.js"></script> 
<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.tablesorter.js"></script>
<script src="js/jPages.js"></script>

<script src="<?php echo $refUrl; ?>js/jquery.icheck.min.js?v=0.9.1"></script>




<link rel="stylesheet" href="http://code.jquery.com/ui/1.10.3/themes/smoothness/jquery-ui.css" /> 
<script src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>
<link rel="stylesheet" href="/resources/demos/style.css" />

<script type="text/javascript" src="<?php echo $refUrl; ?>js/jquery.multiselect.js"></script> 
  
 <script>
  (function( $ ) {
    $.widget( "custom.combobox", {
      _create: function() {
        this.wrapper = $( "<span>" )
          .addClass( "custom-combobox" )
          .insertAfter( this.element );
 
        this.element.hide();
        this._createAutocomplete();
        this._createShowAllButton();
      },
 
      _createAutocomplete: function() {
        var selected = this.element.children( ":selected" ),
          value = selected.val() ? selected.text() : "";
 
        this.input = $( "<input>" )
          .appendTo( this.wrapper )
          .val( value )
          .attr( "title", "" )
          .addClass( "custom-combobox-input ui-widget ui-widget-content ui-state-default ui-corner-left" )
          .autocomplete({
            delay: 0,
            minLength: 0,
            source: $.proxy( this, "_source" )
          })
          .tooltip({
            tooltipClass: "ui-state-highlight"
          });
 
        this._on( this.input, {
          autocompleteselect: function( event, ui ) { 
            ui.item.option.selected = true;
            this._trigger( "select", event, {
              item: ui.item.option
            });
			//( ".selector" ).on( "autocompletechange", function( event, ui ) {} );
          },
         /*  autocompletechange: "_removeIfInvalid",*/
		   
   			/*autocompletechange: function( event, ui ) { 
				$("form").submit();
			}*/
        });
      },
 
      _createShowAllButton: function() {
        var input = this.input,
          wasOpen = false;
 
        $( "<a>" )
          .attr( "tabIndex", -1 )
          .attr( "title", "Show All Items" )
          .tooltip()
          .appendTo( this.wrapper )
          .button({
            icons: {
              primary: "ui-icon-triangle-1-s"
            },
            text: false
          })
          .removeClass( "ui-corner-all" )
          .addClass( "custom-combobox-toggle ui-corner-right" )
          .mousedown(function() {
            wasOpen = input.autocomplete( "widget" ).is( ":visible" );
          })
          .click(function() {
            input.focus();
 
            // Close if already visible
            if ( wasOpen ) {
              return;
            }
 
            // Pass empty string as value to search for, displaying all results
            input.autocomplete( "search", "" );
          });
      },
 
      _source: function( request, response ) {
        var matcher = new RegExp( $.ui.autocomplete.escapeRegex(request.term), "i" );
        response( this.element.children( "option" ).map(function() {
          var text = $( this ).text();
          if ( this.value && ( !request.term || matcher.test(text) ) )
            return {
              label: text,
              value: text,
              option: this
            };
        }) );
      },
 
      _removeIfInvalid: function( event, ui ) {
 
        // Selected an item, nothing to do
        if ( ui.item ) {
          return;
        }
 
        // Search for a match (case-insensitive)
        var value = this.input.val(),
          valueLowerCase = value.toLowerCase(),
          valid = false;
        this.element.children( "option" ).each(function() {
          if ( $( this ).text().toLowerCase() === valueLowerCase ) {
            this.selected = valid = true;
            return false;
          }
        });
 
        // Found a match, nothing to do
        if ( valid ) {
          return;
        }
 
        // Remove invalid value
        this.input
          .val( "" )
          .attr( "title", value + " didn't match any item" )
          .tooltip( "open" );
        this.element.val( "" );
        this._delay(function() {
          this.input.tooltip( "close" ).attr( "title", "" );
        }, 2500 );
        this.input.data( "ui-autocomplete" ).term = "";
      },
 
      _destroy: function() {
        this.wrapper.remove();
        this.element.show();
      }
    });
  })( jQuery );
 
  $(function() {
	$("#keywordsearch").combobox();
    $("#combobox").combobox();
	$("#advisorsearch_legal").combobox();
	$("#advisorsearch_trans").combobox();
        $("#sectorsearch").combobox();
	/*$( ".custom-combobox" ).autocomplete({
	  change: function( event, ui ) { this.form.submit(); }
	});*/
        
        
 
        
  });
 

/*$(document).ready(function() 
    { 
        $("#myTable").tablesorter(); 
    } 
);*/ 
   

</script>
            
  <script>
  
  $(document).ready(function() {

	if ((screen.width>=1280) && (screen.height>=720))
	{
		//alert('Screen size: 1280x720 or larger');
		//$("link[rel=stylesheet]:not(:first)").attr({href : "css/detect1024.css"});
	}
	else
	{
		//alert('Screen size: less than 1280x720, 1024x768, 800x600 maybe?');
		$("link[rel=stylesheet]:not(:first)").attr({href : "css/detect800.css"});
	}
});




/*$(function(){
	$("#myTable").tablesorter(); 
	$("div.holder").jPages({
	  containerID : "movies",
	  previous : "?? Previous",
	  next : "Next ?",
	  perPage : 20,
	  delay : 20
	});
});*/
 
$(document).ready(function(){
 
  $('input').iCheck({
	checkboxClass: 'icheckbox_flat-red',
	radioClass: 'iradio_flat-red'
  });



});


</script>

   <script type="text/javascript">
$(function(){
	$(".selectgroup select").multiselect();
});
</script>

<SCRIPT LANGUAGE="JavaScript">
function checkFields()
 {
  	if((document.malogin.emailid.value == "") || (document.malogin.emailpassword.value == ""))
    {
		alert("Please enter both Email Id and Password");
		return false
 	}
 	if(document.malogin.chkTerm.checked==false)
 	{
 		alert("Please agree to Terms & Conditions");
 		return false
 	}
}
</SCRIPT>

</head>

<body class="loginpage"> 
 
<!--Header-->

<div class="login-screen">

<div class="header"><img src="<?php echo $refUrl; ?>images/logo.png" width="167" height="45" alt="Venture Intelligence" title="Venture Intelligence" border="0" /></div>


<div class="login-cnt">

<form name="pelogin" onSubmit="return checkFields();" method="post" action="" >
  <p style="color: #F10000;font-weight: bold;background: #fff;width: 79%;padding: 1% 4%;border-radius: 2px;font-size: 13px;line-height: 16px;">Please await email from Venture Intelligence (in your registered email id) containing your authorization code.</br><small>Please check your spam/junk folder also.</small></p>  
    <ul>
        <li style="text-align: center"><h3>Device Authorization</h3></li>
        <?php  /* value="<?php echo $userEmail; ?>" */ ?>
<li><label>Email</label> <input type=text name="emailid" value="<?php echo $_GET['email']; ?>"  size="23" style="padding: 5px;"/></li>
<li><label>Authorization Code</label> <input type=password name="authCode" value="<?php echo $authCode; ?>" size="23" style="padding: 5px;"/></li>

<li><input type="submit" name="btnSubmit" value ="Authorize" class="fp"/> <a href="<?php echo GLOBAL_BASE_URL; ?>contactus.htm" class="fp">Contact us for any questions</a></li>
<li><font color="red"><?php echo $displayMessage; ?></font></li>
<li><font color="green"><?php echo $successMessage; ?></font></li>
</ul>
 <input type="hidden" value="<?php echo $_REQUEST['device']; ?>" name="autdevice" ></input>
</form>


</div>

</div>
<div style="clear: both;"></div> 
  <footer class="footer-container">
      <div class="footer-sec"> <span>� 2018 TSJ Media Pvt Ltd. All rights reserved. </span> <!--<a href="http://kutung.com/" class="fr">it's a kutung</a>--> </div>
  </footer>
  <style>
    .footer-container {
      background: #232323;width: 100%;overflow: hidden;position: absolute;bottom: 0px;
    }
    .footer-sec {
      max-width: 1170px;margin: 0 auto; padding: 20px 0; text-align: center;
    }
    .footer-sec span {
      color: #8a8f8f;font-size: 13px;
    }
  </style>

</body>
</html>
<?php mysql_close(); ?>


