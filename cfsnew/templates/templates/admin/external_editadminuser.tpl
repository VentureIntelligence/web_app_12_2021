{include file="admin/header.tpl"}
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
{literal}
<style type="text/css">
/* CSS Document */
.error{
color:#990000;
font-weight:bold;
}
/*.slider-bg {
	height:472px;
	position:absolute;
	width:980px;
	left: 155px;
	top: -39px;
	z-index:1000;
}*/
ul#primary-nav {
	float:left;
	height:75px;
	left:225px;
	position:absolute;
	top:57px;
	width: 746px;
}

ul#primary-nav {
margin:0; padding:0;
}

ul#primary-nav li {display:block; float:left; margin-right:22px;} 

ul#primary-nav li.home:hover{background: url(images/homehover.png) left top; width:77px; height:50px;}
ul#primary-nav li.aboutus:hover{background: url(images/abouthover.png) left top; width:114px; height:50px;}
ul#primary-nav li.services:hover{background: url(images/serviceshover.png) left top; width:114px; height:50px;}
ul#primary-nav li.contactus:hover{background: url(images/contactushover.png) left top; width:134px; height:50px;}

ul#primary-nav li.home a
{
background:url(images/home.png) no-repeat;
line-height:64px;
padding:19px 38px;
}

ul#primary-nav li.aboutus a
{
background:url(images/aboutus.png) no-repeat;
line-height:64px;
padding:19px 57px;
}

ul#primary-nav li.services a
{
background:url(images/services.png) no-repeat;
line-height:64px;
padding:19px 57px;
}

ul#primary-nav li.contactus a
{
background:url(images/contactus.png) no-repeat;
line-height:64px;
padding:19px 67px;
}

ul#primary-nav li a{
height:19px;
width:auto;
}
.contentbg
{
height:auto;
position:relative;
}
.content
{
width:930px;
height:auto;
margin:0 auto;
padding-top:42px;

}
.wrapper {
padding:0px 0px 20px;
width:300px;
float:left;
}
.breadtext
{
font:13px Verdana, Arial, Helvetica, sans-serif;
color:#FFFFFF;
text-align:left;
text-indent:15px;
}
.breadcrumb
{
width:100%;
/*background-color:#000000;*/
/*padding:15px 0;*/
}
.title {
color:#FFFFFF;
font:lighter 25px impact;
text-transform:uppercase;
text-align:left;
}
.imagebg
{
background-color:#FFFFFF;
width:278px;
height:auto;
margin:25px auto;
border:1px solid #cecece;
padding:6px;
}
.conttext
{
font:12px/1.8 Arial, Helvetica, sans-serif;
color:#FFFFFF;
text-align:left;
width:290px;

}
h1{
display:inline;
}
.ListText{
	font:18px Arial, Helvetica, sans-serif;
	bor

}
#slidecontent {

    position: relative;
}
#slidecontent ul li {list-style-type: none;}
ol#controls {
    height: 28px;
    left: 360px;
    margin: 1em 0;
    padding: 0;
    position: absolute;
    top: 121px;
    z-index: 1000;
}
.adminbox {
    border: 1px solid #589711;
	background-color:#FFFFFF;
    border-radius: 10px 10px 10px 10px;
	-webkit-border-radius: 10px 10px 10px 10px;
    box-shadow: 2px 2px 2px #B0AEA6;
    padding: 10px;
	
    margin: 20px auto;
    height: auto;
    padding: 20px;
    width: 500px;
}
.adtitle
{
font:bold 24px "Courier New", Courier, monospace;
margin:15px 0;
color:#000;

}
select, input
{
padding:5px;
width:250px;
}
label{
font-family:Arial, Helvetica, sans-serif;
font-size:18px;
float:left;
width:150px;
color:#333333;
text-align:left;
}
input[type=radio]{
width:20px;
}
.dob{
	width:60px;
	padding:0px;
}

</style>

	<script type="text/javascript" language="javascript1.3">
		var $j = jQuery.noConflict();
		$j(document).ready(function(){	
			$j("#slider").easySlider({
				//auto: false, 
				//continuous: true,
				numeric: true
			});
		});	



/*function Validation(id){
  var flag		=		0;
  if(id == 1 && id != undefined){
	var email = document.getElementById('emailaddress').value;
	var City = document.getElementById('City').value;
	 if(email==""){
		$('CatErrorMsg').innerHTML = "Please Enter Email";
		$('emailaddress').focus();
		flag=1;
	 }else if (!isValidEmail(email)){
		$('CatErrorMsg').innerHTML = "Please Enter Valid Email Address";
		$('emailaddress').focus();
		flag=1;
	}
  }	
	if(flag == 0 && email != "" && email != undefined){
		document.authcheck.submit();
	}
}
*/
function IndexKeyPress(id,e){
		// look for window.event in case event isn't passed in
		if (window.event) { e = window.event; }
		if (e.keyCode == 13){
		return true;
			//	validation(id);
		}
}

	</script>

	{/literal}
</head>
<div class="contentbg">
<div class="breadcrumb">
	<div class="content" style="padding-top:0px;">
	<div class="breadtext">&nbsp;</div>
	</div>
</div>
<form name="Frm_EditAdminUser" id="Frm_EditAdminUser" action="" method="post" onSubmit="return Validation('Frm_EditAdminUser')" enctype="multipart/form-data">
<input type="hidden" name="EditAdminUser" id="EditAdminUser" value="EditAdminUser" />
<div id="slidecontainer">


	<div id="slidecontent">
	
		<div id="slider">
			<ul>				
				<li><div class="adminbox">
		<div class="adtitle" align="center">Edit Admin User</div>
		<div align="center">
			<label id="req_answer[FirstName]">First Name:</label>
			<input type="text" id="answer[FirstName]" size="26" name="answer[FirstName]" class="req_value" forError="FirstName" value="{$AdminUser.Firstname}">		
		</div><br />

		<div align="center">
			<label id="req_answer[LastName]">Last Name:</label>
			<input type="text" id="answer[LastName]" size="26" name="answer[LastName]" class="req_value" forError="LastName" value="{$AdminUser.Lastname}"/>
		</div>
<br />
		<div align="center">
			<label id="req_answer[Email]">Email:</label>
			  <input type="text" id="answer[Email]" size="26" name="answer[Email]" class="req_email" forError="Email" value="{$AdminUser.Email}"/>
		</div>
<br />
		<div align="center">
			<label id="req_answer[Password]">New Password:</label>
			  <input type="password" id="answer[Password]" size="26" name="answer[Password]" class="" forError="" value=""/>
		</div>
<br />
		{if $AdminUser.usr_type neq 3}
		<div align="center">
			<label id="req_answer[user_type]">User Type:</label>
			<select id="answer[user_type]" name="answer[user_type]" class="req_value"  forError="user_type">
                <option {if $AdminUser.usr_type eq 2}selected{/if} value="2">Intern</option>
                <option {if $AdminUser.usr_type eq 1}selected{/if} value="1">Admin</option>
                <option {if $AdminUser.usr_type eq 4}selected{/if} value="4">XBRL Automation</option>
                <option {if $AdminUser.usr_type eq 6}selected{/if} value="6">Intern + XBRL Automation</option>
				<option {if $AdminUser.usr_type eq 7}selected{/if} value="7">API</option>
            </select>
		</div>
		<input type="hidden" name="answer[external_api_access]" id="answer[external_api_access]" value="1"/>
		{/if}
<br />
	<div align="center">
		<input type="image" name="edit_business"  src="images/submit.png" style="width:87px; height:25px;"/>
	</div><br />

	
	</div><br />

{* 	
	 <option <?php if ($this->_tpl_vars['AdminUser']['usr_type'] == 2): ?>selected<?php endif; ?> value="2">Intern</option>
                <option <?php if ($this->_tpl_vars['AdminUser']['usr_type'] == 1): ?>selected<?php endif; ?> value="1">Admin</option>
                <option <?php if ($this->_tpl_vars['AdminUser']['usr_type'] == 4): ?>selected<?php endif; ?> value="4">XBRL Automation</option>
                <option <?php if ($this->_tpl_vars['AdminUser']['usr_type'] == 6): ?>selected<?php endif; ?> value="6">Intern + XBRL Automation</option>
				 *}
	
	
	</li>
				
							
			</ul>
		</div>
	</div>

</div>
</form>


</div>
{*include file ="groupon/footer.tpl"*}