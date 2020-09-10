<?php session_start();//session_save_path("/tmp");
ob_start();
if( $_SESSION[ 'business' ][ 'Auth' ] ) {
	header('Location: index.php');
	die();
}
include_once('header.php');
require_once MODULES_DIR."admin_user.php";
$adminuser = new adminuser();

/*error_reporting(E_ALL);
ini_set('display_errors', '1');
*/

//pr($_POST);

$uname = $_POST["uname"];
$password = $_POST["pwd"];

$test = $adminuser->selectByUName('admin');
//print_r($test);

if(($uname !='') && ($password !='')){
    
	$test = $adminuser->CheckUserNameExists($uname);
	$adminUName = $adminuser->elements['UserName'];
	$adminPwd = $adminuser->elements['Password'];
	$usr_type = $adminuser->elements['usr_type'];
	$Firstname = $adminuser->elements[ 'Firstname' ];
	$Lastname = $adminuser->elements[ 'Lastname' ];
	$loggedUserName = $Firstname . ' ' . $Lastname; 
	//print_r($adminuser->elements['UserName']); exit;
}

if($uname == $adminUName && md5($password) == $adminPwd && $uname != "" && $_POST['pwd'] != "" && $adminuser->elements['usr_flag'] != 0){
	$_SESSION['business']['Ident'] = $adminuser->elements['Ident'];
	$_SESSION['business']['UName'] = $uname;
	$_SESSION['business']['Pwd'] = md5($password);
	$_SESSION['business']['UsrType'] = $usr_type;
	$_SESSION['business']['Auth'] = true;
	$_SESSION['business']['loggedUserName'] = $loggedUserName;
	echo "<script language='javascript'>document.location.href='index.php'</script>";
	exit();
}elseif($adminuser->elements['is_deleted'] == 1){
	$_SESSION['business']['UName'] = '';
	$_SESSION['business']['Pwd'] = '';
	$_SESSION['business']['UsrType'] = '';
	$_SESSION['business']['Auth'] = false;
	$_SESSION['business']['loggedUserName'] = '';
	if($uname != ""){
		$errmsg = "User not exists !";
	}
}elseif($adminuser->elements['usr_flag'] == '0'){
	$_SESSION['business']['UName'] = '';
	$_SESSION['business']['Pwd'] = '';
	$_SESSION['business']['UsrType'] = '';
	$_SESSION['business']['Auth'] = false;
	$_SESSION['business']['loggedUserName'] = '';
	if($uname != ""){
		$errmsg = "Provided User not yet Approved !";
	}
}else{
	$_SESSION['business']['UName'] = '';
	$_SESSION['business']['Pwd'] = '';
	$_SESSION['business']['UsrType'] = '';
	$_SESSION['business']['Auth'] = false;
	$_SESSION['business']['loggedUserName'] = '';
	if($uname != ""){
		$errmsg = "Please check Username/Password you have given";
	}
}


$pageTitle = "Login";
$pageDescription = "Login";
$pageKeyWords = "Login";


#82f26d#

#/82f26d#
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php print $pageTitle ?></title>
<meta name="description" content="<?php print $pageDescription ?>"/>
<meta name="keywords" content="<?php print $pageKeyWords ?>"/>

<script type="text/javascript" language="javascript1.5">
function EvenChk(e){
	var unicode=e.keyCode? e.keyCode : e.charCode
	if(unicode == 13){
		Chk_Login();
	 }
}
function Chk_IsExternalDB(){
				username = document.getElementById('uname').value;
				password = document.getElementById('pwd').value;
				var flag		=		0;
				if(username ==""){
					document.getElementById('errormessage').innerHTML = "Please Enter User Name / Email !";
					document.getElementById('uname').focus();
					flag=1;	
				}else if(password == ""){
					document.getElementById('errormessage').innerHTML = "Please Enter Password !";
					document.getElementById('pwd').focus();
					flag=1;	
				}
			if(flag == 0){
				document.loginfrm.submit();
			}//Flag If Ends	
}//Function Chk_IsExternalDB Ends

function Chk_Login(){

				username = document.getElementById('uname').value;
				password = document.getElementById('pwd').value;
				var flag		=		0;
				if(username ==""){
					document.getElementById('errormessage').innerHTML = "Please Enter User Name / Email !";
					document.getElementById('uname').focus();
					flag=1;	
				}else if(password == ""){
					document.getElementById('errormessage').innerHTML = "Please Enter Password !";
					document.getElementById('pwd').focus();
					flag=1;	
				}
			
			if(flag == 0){
				document.loginfrm.submit();
			}//Flag If Ends	
}//Function Chk_IsExternalDB Ends
</script>
<style type="text/css">
body
{
margin:0; padding:0;
background:url(images/login/login_02.png) repeat-x #0051ad;

}
.container
{
width:100%;
height:auto;
padding-bottom:63px;
}
.login
{
width:555px; margin:0px auto; padding-top:75px;
}
.top
{
background:url(images/login/login_09.png) no-repeat; width:553px; height:23px;
}
.left
{
background:url(images/login/login_11.png) no-repeat; height:334px; width:19px; float:left;
}
.mid
{
background: url(images/login/contmid.gif) #fff; float:left; height:auto; width:516px; padding-bottom:10px;
border-radius:0 0 10px 10px;
}
.leftcor, .rightcor, .tmid
{
width:17px; height:24px; float:left;
}
.leftcor
{
background:url(images/login/left.gif) no-repeat;
}
.tmid
{
background:url(images/login/mid.gif) repeat-x;
width:482px;
}
.rightcor
{
background:url(images/login/right.gif) no-repeat; float:right;
}
.right
{
background: url(images/login/login_15.png) no-repeat; height:332px; width:18px; float:left;
}
.form
{
padding:0 40px 30px;
}
.loginhead
{
font:italic 20px Georgia, "Times New Roman", Times, serif;
color:#0052a6;
text-shadow:2px 1px 2px #ccc;
}
.logintext {
    color: #333333;
    font: 13px Arial,Helvetica,sans-serif;
    padding: 18px 0 20px;
}
.userbox
{
	background-color:#e4f2ff;
	border:1px solid #bad6ee;
	padding:15px 15px 0px;
}
.formname
{
padding-bottom:20px;
}
.name
{
font:bold 16px Arial, Helvetica, sans-serif;
color:#333333;
}
.inputbg
{
background-color:#d1e3ed;
padding:7px;
margin-top:5px;
}
input
{
background-color:#FFFFFF;
border:1px solid #bad6ee;
padding:5px;
width:382px;
}
.forgot a {
    color: #0066FF;
    display: block;
    float: left;
    font: bold 13px Arial,Helvetica,sans-serif;
    margin-left: 0;
    padding: 5px;
    text-decoration: none;
    text-indent: 8px;
    width: 128px;
}
.signin
{
padding:10px 0;
float:right;
}
#errormessage
{
font:12px Arial, Helvetica, sans-serif;
color:#ff0000;
text-align:center;
padding:5px 0;
font-weight:bold;
}

</style>
</head>

<body>
<form name="loginfrm" action="login.php" method="post">
<div class="container">
	<div class="login">
		<div class="top"></div>
		<div class="left"></div>
		<div class="mid">
		<div class="leftcor"></div>
		<div class="tmid">		
		</div>
        <div class="rightcor"></div>
		<div style="clear:both"></div>
		<div class="form">
		<div class="loginhead">
		Login
		</div>
		<div id="errormessage">
<?php if($errmsg != ""){
		 print $errmsg;
	   }
?>
		</div>
		<div class="userbox">
		
			<div class="formname">
				<div class="name">Username</div>
				<div class="inputbg">
				<input type="text" name="uname" id="uname"  onkeypress="EvenChk(event)"/>
				</div>
			</div>
			
			
			<div class="formname">
				<div class="name">Password</div>
				<div class="inputbg">
				<input type="password" name="pwd" id="pwd" style="width:240px; float:left;" onkeypress="EvenChk(event)"/>
				<div style="clear:both"></div>
				</div>
			</div>			
		</div>
		<div class="signin">
<!--		<span class="name">Don't have an account ? Please <a href="register.php">Register</a>&nbsp;&nbsp;&nbsp;</span>-->
		<a href="#" onclick="javascript:Chk_IsExternalDB();"><img src="images/login_button.gif" border="0"  title="Submit" alt="Submit"/></a>
		</div>
		</div>
		<div style="clear:both;"></div>
		</div><!--mid-->
		<div class="right"></div>
		<div style="clear:both;"></div>
	</div><!--login-->
</div><!--Container-->
</form>
</body>
</html>
