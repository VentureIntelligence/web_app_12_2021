{include file="admin/header.tpl"}
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
{literal}
<style type="text/css">
/* CSS Document */
/* CSS Document */
.error{
color:#990000;
font-weight:bold;
}

#tcerror{
color:#990000;
margin:2px;
}
input{
	border:#000000 solid 1px;
}
body
{
margin:0; padding:0;
}
.clear
{
clear:both;
}

#formback
{
width:100%;
}

#formcontainer
{
width:950px;
margin:0 auto;
}

#sidebox
{
width:355px;
}

#side
{
padding:15px;
}

#form
{
width:595px;
margin:0px auto;
}

#formnametop
{
width:594px;
height:72px;
margin:0px auto 25px;
}

/*GREEN*/



#formnametop ul
{
margin:0; padding:0; float: left;
}

#formnametop ul li 
{
	float: left;
	display: inline; /*For ignore double margin in IE6*/
}

/*#formnametop li.first a
{
background: url(images/registration/.firsta.png) no-repeat 0 0;
border:0px;
height:70px;
}

#formnametop li.last a
{
background:url(images/registration/.lasta.png) no-repeat right 0 ;
border:0px;
height:70px;
}*/

#formnametop ul li a
{
font-family:'pts55f-webfont-webfont';
float:left;
text-decoration:none;
color:#FFFFFF;
background:url(images/registration/menu.png) no-repeat center bottom;
width:145px;
height:44px;
border-left:1px solid #CCCCCC;
border-bottom:1px solid #CCCCCC;
text-align:center;
display:block;
padding:13px 0;
}


#formnametop ul li a:hover {
	background: url(images/registration/menu.png) no-repeat top center;


}

#formnametop ul li.current a, li.current a:hover {
	background: url(images/registration/menu.png) no-repeat top left;
	color:#000000;
	border:0px;
}

#formnametop ul li.current1 a, li.current1 a:hover {
	background: url(images/registration/menu.png) no-repeat top right;
	color:#000000;
	border:0px;
}


#formtoptr, #formtoptl, #formtopbg, #formbotlbg, #formbotmbg, #formbotrbg, #inputform, #desc, #fields, #sidebox, #descnew
{
float:left;
}

#formtop
{
clear:both;
height:18px;
}

#formtoptl
{
background:url(images/registration/formtoplbg.gif) no-repeat 0 0;
width:15px;
height:18px;
}

#formtopbg
{
background:url(images/registration/formtbg.gif) repeat-x 0 0;
width:563px;
height:18px;
}


#formtoptr
{
background:url(images/registration/formtoprbg.gif) no-repeat 0 0;
width:15px;
height:18px;
}

#formbg
{
background:url(images/registration/formbg.gif) repeat-y 0 0;
margin:0 auto;
}

#formbotbg
{
height:63px;
}

#formbotlbg
{
background:url(images/registration/formleftbg.gif) no-repeat 0 0;
width:14px;
height:63px;
}

#formbotmbg
{
background:url(images/registration/formbotbg.gif) repeat-x 0 0;
width:565px;
height:63px;
}

#botinfo
{
padding:17px 0 15px;
}

#fields
{
width:223px;
color:#FFFFFF;
font-family:'pts55f-webfont-webfont';
font-size:17px;
font-style:italic;
background:url(images/registration/required.gif) no-repeat left top;
padding-left:15px;
}

#next
{
background:url(images/registration/next.gif) no-repeat 0 0;
width:151px;
height:34px;
text-indent:-9999px;
float:right;
}

#formbotrbg
{
background:url(images/registration/formrightbg.gif) no-repeat 0 0;
width:14px;
height:63px;
}

#inputdesc
{
background:url(images/registration/border-bot.gif) repeat-x 0 bottom;
width:593px;
}

#inputbgform
{
padding:0px 15px 10px;

}

#inputbgformnew
{
padding:15px 15px;

}

#inputform
{
width:200px;
}

#desc
{
width:280px;
margin-left:40px;
margin-top:32px;
}

#descnew{
width:280px;
margin-left:40px;
margin-top:32px;
}

/* Typography */

.label
{
font-family:'pts55f-webfont-webfont';
font-size:18px;
font-weight:bold;
line-height:2;
color:#515151;
background:url(images/registration/userrequired.gif) no-repeat right top;
padding-right:12px;
width:auto;
}
label
{
font-family:'pts55f-webfont-webfont';
font-size:18px;
font-weight:bold;
line-height:1.5;
color:#515151;
padding-right:12px;
width:330px;
}

.username, .lock, .mail
{
width:195px;
height:23px;
border:0px;
padding:5px 36px 5px 5px;
color:#FFFFFF;
font:italic 16px/2 Arial, Helvetica, sans-serif;
}

.username
{
background:url(images/registration/username.gif) no-repeat 0 0 transparent;
}

.lock
{
background:url(images/registration/lock.gif) no-repeat 0 0 transparent;

}

.mail
{
background:url(images/registration/lock.gif) no-repeat 0 0 transparent;
}


.SI-FILES-STYLIZED label.cabinet
{
	width: 351px;
	height: 34px;
	background: url(images/registration/browse.gif) 0 0 no-repeat;
	display: block;
	overflow: hidden;
	cursor: pointer;
}

.SI-FILES-STYLIZED label.cabinet input.file
{
	position: relative;
	height: 100%;
	width: auto;
	opacity: 0;
	-moz-opacity: 0;
	filter:progid:DXImageTransform.Microsoft.Alpha(opacity=0);
}
@font-face{ 
	font-family:'pts55f-webfont-webfont';
	src: url('fonts/pts55f-webfont-webfont.eot');
	src: url('fonts/pts55f-webfont-webfont.eot?#iefix') format('embedded-opentype'),
	     url('fonts/pts55f-webfont-webfont.woff') format('woff'),
	     url('fonts/pts55f-webfont-webfont.ttf') format('truetype'),
	     url('fonts/pts55f-webfont-webfont.svg#webfont') format('svg');
}
/*Personal Details*/

.fullname
{
background:url(images/registration/fullname.png) no-repeat 0 0;
width:200px;
height:28px;
color:#FFFFFF;
font-family:'droidsans-bold-webfont';
font-size:13px;
border:0px;
padding:0 5px;
}

.add
{
background:url(images/registrationimages/street.png) no-repeat 0 0;
width:200px;
height:28px;
border:0px;
padding:0 5px;
}

.city, .country
{
background:url(images/registrationimages/city.png) no-repeat 0 0;
width:200px;
height:28px;
border:0px;
padding:0 5px;
margin:6px 0;
}

span.customStyleSelectBox  { font-size:11px; background:url(images/registration/inputbg.png) no-repeat 0 0; width:198px; height:28px; font-size:14px; font-family:'droidsans-bold-webfont'; padding-left:10px; color:#FFFFFF;} 

span.customStyleSelectBox.changed { background-color: #f0dea4; }

.customStyleSelectBoxInner { background: url(images/registration/drop.png) no-repeat center right; width:200px; padding:5px 0; font-size:14px; }

select
{
width:198px;
height:28px;
}
.country, .zip
{
background:url(images/registration/inputbg.png) no-repeat 0 0;
width:200px;
height:28px;
border:0px;
padding:0 5px;
}

input[type=radio]
{
background:url(images/registration/circledivider.png) no-repeat 0 0;
width:14px; height:14px; float:left; margin-left:8px;
}

.name
{
font-size:15px;
font-family:'droidsans-bold-webfont';
float:left;
color:#515151;
}

.error, .success {
text-align: left;
/*padding-top: 30px;*/
}
.msg
{
font-size: 15px;
font-family: 'droidsans-bold-webfont';
color: #8DC63F;
line-height:2em;
text-align:left;
}
.errormsg
{
color:#c6423f;
font-weight:bold;
}
.sucsmsg{
color:#003300;
font-weight:bold;
}

.tc{
width:900px;font-weight:bold;
}</style>
{/literal}
</head>
<div class="contentbg">
<div class="breadcrumb">
	<div class="content" style="padding-top:0px;">
	<div class="breadtext">&nbsp;</div>
	</div>
</div>
<div id="slidecontainer">


	<div id="slidecontent">
	
		<div id="slider">
<div class="adminbox">
<form name="Frm_Reg" id="Frm_Reg" action="" method="post">
<input type="hidden" name="Registration" id="Registration" value="Registration" />
	<div id="formback">
		<div id="formcontainer">
		<div id="sidebox">
			<div class="side">
			</div>		
		</div>
		<div id="form">
			
	
		<div id="finishdetails">
	<div id="accountdetails">	
			<div id="formbg">						
				<div id="inputdesc">
					<div id="inputbgform">
						<div id="inputform">
							<div class="errormsg" style="padding:3px;">{$ExistError}</div><div class="sucsmsg">{$SucsMsg}</div>
							<label  class="label">User Name</label>	
							<input type="text" id="answer[UserName]" size="26" name="answer[UserName]" class="req_value"  forError="UserName" value="{$Request.UserName}" />
						</div>
						<div id="desc"><label id="req_answer[UserName]"></label><label id="UNameError" style="display:none;"></label></div>
						<div class="clear"></div>
					</div>
				</div>
				
				<div id="inputdesc">
					<div id="inputbgform">
						<div id="inputform">
							<label class="label">Password</label>		
							 <input type="password" id="answer[Password]" size="26" name="answer[Password]" class="req_password" forError="Password" />
						</div>
						<div id="descnew"><label id="req_answer[Password]"></label><label id="PasswordError"></label></div>
						<div class="clear"></div>
					</div>
				</div>
				
				<div id="inputdesc">
					<div id="inputbgform">
						<div id="inputform">
							<label class="label">Retype Password</label>		
						<input type="password" id="password_again" size="26" name="password_again" class="req_password_again" forError="req_password_again" disabled="disabled"/>
						</div>
						<div id="descnew"><label id="req_answer[password_again]"></label></div>
						<div class="clear"></div>
					</div>
				</div>
				
				<div id="inputdesc">
					<div id="inputbgform">
						<div id="inputform">
							<label class="label">Email</label>	
							 <input type="text" id="answer[Email]" size="26" name="answer[Email]" class="req_email" forError="Email" value="{$Request.Email}" />
						</div>
						<div id="desc"><label id="req_answer[Email]"></label><label id="EmailError" style="display:none;"></label></div>
						<div class="clear"></div>
					</div>
				</div>	
				
			<div id="inputbgform">
					<div id="inputform">
						<label class="label">First Name</label>	
						<input type="text" id="answer[FirstName]" size="26" name="answer[FirstName]" class="req_value"  forError="FirstName" />
					</div>
					<div id="desc"><label id="req_answer[FirstName]"></label></div>
					<div class="clear"></div>
				</div>
			</div>


				<div id="inputbgform">
					<div id="inputform">
						<label class="label">Last Name</label>	
						<input type="text" id="answer[LastName]" size="26" name="answer[LastName]" class="req_value"  forError="LastName" />
					</div>
					<div id="desc"><label id="req_answer[LastName]"></label></div>
					<div class="clear"></div>
				</div>
			</div>
				
			
			<div id="inputbgform">
					<div id="inputform">
						<label class="label">Role</label>	<br/>
						<input type="radio" id="answer[Role]" size="26" name="answer[Role]" value="Admin" class="req_value"  forError="Role" />
						&nbsp;Admin<br/><br/>
						<label class="label">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
						<input type="radio" id="answer[Role]" size="26" name="answer[Role]" value="User" class="req_value"  forError="Role" />
						&nbsp;User<br/>
					</div>
					<div id="desc"><label id="req_answer[LastName]"></label></div>
					<div class="clear"></div>
				</div>
			</div>
			
			</div>
			<div id="formbotbg">
				<div id="formbotlbg">
				</div>
				<div id="formbotmbg">
					<div id="botinfo">
						<div>Already have a Account? Please <a href="login.php">Login</a>&nbsp;&nbsp;</div>
						<div id="nxt" align="right">
							<input type="image" name="save_business"  src="images/registration/Register.gif"   onclick="return CFSRegistration('Frm_Reg')"/>
						</div>
					</div>
				</div>
				<div id="formbotrbg">
				</div>
				<div class="clear"></div>
			</div>
		</div>
		</div>
		<!-- Finish Final Details Ends -->	
			
			
		</div>
		</div>
	<div>&nbsp;</div>
	</div>	
</form>	
</div>