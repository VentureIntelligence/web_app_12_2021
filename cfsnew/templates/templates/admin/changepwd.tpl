<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>{$pageTitle}</title>
 <script language="javascript" type="text/javascript" src="{$ADMIN_JS_DIR}validator.js"></script>
 <script language="javascript" type="text/javascript" src="{$ADMIN_JS_DIR}prototype.js"></script>
{include file='groupon/admin/header.tpl'}
{literal}
<script language="javascript" type="text/javascript">
function frmVal(){
var val1 = document.getElementById('cPwd').value;
var val2 = document.getElementById('pwd').value;
	if(val1 == val2 && val1 != '' && val2 != ''){
		document.chngPwdfrm.submit();
	}else{
		alert('incorrect password');
		return false;
	}	
}
</script>
<style type="text/css">
div{margin:0; padding:0;}
.boxcont{
width:250px;
float:left;
padding:5px 7px;
border:1px solid #cecece;
font:lighter italic 13px Georgia, "Times New Roman", Times, serif;
color:#999;
}
.boxcont a{
width:250px;
float:left;
padding:5px 7px;
border:1px solid #cecece;
font:lighter italic 13px Georgia, "Times New Roman", Times, serif;
color:#999;
}

.bcontainer
{
width:500px;
margin:0 auto;
background-color:#eee;
border:#000000 solid 1px;
padding:15px;

}

.label a{
float: left;
width: 250px;
font-weight: bold;
margin-right:15px;
font-size:18px;
}

.label h2
{
font:bold 18px Arial, Helvetica, sans-serif;
margin-top:5px;
}
input, textarea{
width:250px;
float:left;
padding:5px 7px;
border:1px solid #cecece;
font:lighter italic 13px Georgia, "Times New Roman", Times, serif;
color:#777;
}

textarea{
width: 250px;
height: 150px;
padding:5px 10px;
}


</style>
{/literal}
<body>
<form name="chngPwdfrm" action="" method="post" onsubmit="return frmVal();">
<div class="bcontainer">
<div align="center"><p class="errormessage" style="color:#006600;font-weight:bold;">{$msg}</p></div>
<div class="label" align="center"><h2>Change Password<h2></div>

    <div class="label">
    <h3>New Password</h3>
    </div>
    <div>
		<input type="password" name="pwd" id="pwd"/>
    </div>
    <div style="clear:both"></div>


    <div class="label">
    <h3>Confirm Password</h3>
    </div>
    <div>
	  <div id="stateDropDown">
		<input type="password" name="cPwd" id="cPwd"/>
	  </div>
    </div>
     <div style="clear:both">&nbsp;</div>
	  <div id="stateDropDown">
		 <input type="submit" name="pwdbtn" id="pwdbtn" value="Submit">
	 </div>	 
     <div style="clear:both"></div>	 
</div>
</form>
</body>
</html>