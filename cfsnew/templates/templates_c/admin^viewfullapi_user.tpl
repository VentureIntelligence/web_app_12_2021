<?php /* Smarty version 2.5.0, created on 2020-04-24 10:48:13
         compiled from admin/viewfullapi_user.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("admin/header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
common.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
validator.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js"></script>
 <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
 <link rel="stylesheet" type="text/css" href="http://demos.codexworld.com/add-date-time-picker-input-field-jquery/jquery.datetimepicker.css"/>
 <script src="http://demos.codexworld.com/add-date-time-picker-input-field-jquery/jquery.datetimepicker.full.js"></script>
<?php echo '
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
clear:both;

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
.submit-btn{
    border-radius: 0px;
    width: 100px !important;
    margin-top: 8px;
    color: #fff;
    background: #282828;
}
</style>

<script>
 '; ?>
 

</script>

</head>
<div class="contentbg">
   <div class="breadcrumb">
      <div class="content" style="padding-top:0px;">
         <div class="breadtext">&nbsp;</div>
      </div>
   </div>
   <form  class="update_form" id="update_internal_partner" data-toogle="validator">
      <input type="hidden" name="EditPartner" id="EditPartner" value="EditPartner" />
      <div id="slidecontainer">
         <div id="slidecontent">
            <div id="slider">
               <ul>
                  <li>
                     <div class="adminbox">
                        <div align="center"> <a href="fullapi/users-fullapilist.php" style="float: right;">Back to Users</a> </div>
                        <div class="adtitle" align="center">View  User - JSON</div>
                        <div align="center">
                           <label id="req_answer">Name</label>
                           <input type="text" id="partner_name" name="partner_name" value="<?php echo $this->_tpl_vars['fullapi_details']['userName']; ?>
" required readonly/>		
						         <input type="hidden" class="partner_id" name="partner_id" value="<?php echo $this->_tpl_vars['fullapi_details']['fullapi_user_id']; ?>
" />
						         <input type="hidden" id="user_id" class="user_id" name="user_id" value="<?php echo $this->_tpl_vars['fullapi_details']['user_id']; ?>
" />
                        </div>
                        <br />
						<div align="center">
                           <label id="req_answer">Company</label>
                           <input type="text" id="partner_company" name="partner_company" value="<?php echo $this->_tpl_vars['fullapi_details']['user_company']; ?>
" required readonly/>		
                        </div>
                        <br />
						<div align="center">
                           <label id="req_answer">Type</label>
                           
                           <select class="form-control" id="user_type" name="user_type" style="width: 260px;" readonly>
                           <option id="type_internal" value="internal_user" <?php if ($this->_tpl_vars['fullapi_details']['userType'] == 'internal_user'): ?> selected="selected"<?php endif; ?>>Internal User</option>
                           <option id="type_external" value="external_user" <?php if ($this->_tpl_vars['fullapi_details']['userType'] == 'external_user'): ?> selected="selected"<?php endif; ?>>External User</option>
                           </select>
                        </div>
                        <br />
						<div align="center">
                           <label id="req_answer">Token</label>
                           <input type="text" id="user_token" name="user_token" style="width: 207px;"  required value="<?php echo $this->_tpl_vars['fullapi_details']['userToken']; ?>
" readonly/>		
                           <button onclick="myToken()" type="button" id="copied" style="padding:8px;">Copy</button>
                        </div>
                        <br />
						<div align="center">
                           <label id="req_answer">Validate From</label>
                           <input type="text" name="partner_validate_from" value="<?php echo $this->_tpl_vars['fullapi_details']['validityFrom']; ?>
" required readonly/>		
                        </div>
                        <br />
						<div align="center">
                           <label id="req_answer">Validate To</label>
                           <input type="text" name="partner_validate_to" value="<?php echo $this->_tpl_vars['fullapi_details']['validityTo']; ?>
" required readonly/>		
                        </div>
                        <br />
						<div align="center" style="display:none;">
                           <label id="req_answer">Search Count</label>
                           <input type="number" id="partner_search_count" name="partner_search_count" value="<?php echo $this->_tpl_vars['fullapi_details']['serachCount']; ?>
" required readonly/>		
                        </div>
                        
						<div align="center" style="display:none;">
                           <label id="req_answer">API Count</label>
                           <input type="number" id="partner_api_count" name="partner_api_count" value="<?php echo $this->_tpl_vars['fullapi_details']['apiCount']; ?>
" required readonly/>		
                        </div>
                        
                        <?php if ($this->_tpl_vars['fullapi_details']['userType'] == 'external_user'): ?>
                        <div align="center">
                           <label id="req_answer">E-Mail</label>
                           <input type="text" value="<?php echo $this->_tpl_vars['external_details']['username']; ?>
" required readonly/>		
                        </div>
                        <br />
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['fullapi_details']['userType'] == 'external_user'): ?>
                        <div align="center">
                           <label id="req_answer">IP Address</label>
                           <input type="text" value="<?php echo $this->_tpl_vars['external_details']['ipAddress']; ?>
" required readonly/>		
                        </div>
                        <br />
                        <?php endif; ?>
                        <?php if ($this->_tpl_vars['fullapi_details']['userType'] == 'external_user'): ?>
                        <div align="center">
                           <label id="req_answer">Is Admin</label>
                           <input type="text" value="<?php if ($this->_tpl_vars['fullapi_details']['isadmin'] == '1'): ?> Yes <?php else: ?> No <?php endif; ?>" required readonly/>		
                        </div>
                        <br />
                        <?php endif; ?>

                        <div align="center">
                           <label id="req_answer">Status</label>
                           <input type="text" value="<?php if ($this->_tpl_vars['fullapi_details']['user_status'] == '1'): ?> Active <?php else: ?> Inactive <?php endif; ?>" required readonly/>		
                        </div>
                        <br />
                        <br />
                     </div>
                     <br />
                  </li>
               </ul>
            </div>
         </div>
      </div>
   </form>
</div>
<script>
<?php echo '
function myToken() {
  var copyText = document.getElementById("user_token");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  //alert("Copied the text: " + copyText.value);
  $("#copied").text("Copied");
}
'; ?>

</script>
<script>
 <?php echo ' 
$(document).ready(function(e){
   // DatePicker
    $("#datetimepicker_from").attr("autocomplete","off");
    $("#datetimepicker_to").attr("autocomplete","off");
    $(\'#datetimepicker_from\').datetimepicker({
    format:\'Y-m-d H:i:s\',
    });
    $(\'#datetimepicker_to\').datetimepicker({
    format:\'Y-m-d H:i:s\',
    });
    //End User Controls
	var p_type = $("#user_type").val();
	if(p_type == "internal_user"){
		$("#partner-external").hide();
      $("#type_external").hide();
	}else if(p_type == "external_user"){
      $("#type_internal").hide();
   }
});
 '; ?>
 
</script>