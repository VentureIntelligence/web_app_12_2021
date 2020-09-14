<?php /* Smarty version 2.5.0, created on 2020-04-24 10:19:15
         compiled from admin/editfullapi_user.tpl */ ?>
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



<script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js" charset="UTF-8"></script>
<link href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/v4.0.0/build/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
<link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="https://rawgit.com/Eonasdan/bootstrap-datetimepicker/development/src/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
<?php echo '
<style type="text/css">
/* CSS Document */
.error{
color:#990000;
font-size: 12px;
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
    width: 151px !important;
    padding: 10px;
    font-weight: bold;
    margin-top: -25px;
    color: #fff;
    background: #282828;
}
.row{
    margin-left: 0px !important;
    margin-bottom: 15px !important;
}
.col-md-6{
    float:left;
    width:35%;
}
.submit-btn{
    cursor:pointer;
}
table th, table td {
    padding: 0px 5px 5px !important;
}
.total_search_count{
   width: 114px;
   float: left;
   padding: 5px;
   margin-left: 12px;
}
.used_search_count{
   width: 111px;
   float: left;
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
   <form  class="update_form" id="update_internal_partner" name="update_form" data-toogle="validator">
      <input type="hidden" name="EditPartner" id="EditPartner" value="EditPartner" />
      <div id="slidecontainer">
         <div id="slidecontent">
            <div id="slider">
               <ul>
                  <li>
                     <div class="adminbox">
                        <div align="center"> <a href="fullapi/users-fullapilist.php" style="float: right;">Back to Users</a> </div>
                        <div class="adtitle" id="title_id" align="center"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <label id="req_answer">Name</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="fullapi_name" name="fullapi_name" value="<?php echo $this->_tpl_vars['fullapi_details']['userName']; ?>
" placeholder="Enter Name"/>		
                              <input type="hidden" class="fullapi_id" name="fullapi_id" value="<?php echo $this->_tpl_vars['fullapi_details']['fullapi_user_id']; ?>
" />
                              <input type="hidden" id="user_id" class="user_id" name="user_id" value="<?php echo $this->_tpl_vars['fullapi_details']['user_id']; ?>
" />
                              <input type="hidden" id="fullapi_search_count" name="fullapi_search_count" value="<?php echo $this->_tpl_vars['fullapi_details']['serachCount']; ?>
"/>		
                              <input type="hidden" id="fullapi_api_count" name="fullapi_api_count" value="<?php echo $this->_tpl_vars['fullapi_details']['apiCount']; ?>
"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label id="req_answer">Company Name</label>
                            </div>
                            <div class="col-md-6">
                              <input type="text" id="fullapi_company" name="fullapi_company" value="<?php echo $this->_tpl_vars['fullapi_details']['user_company']; ?>
" placeholder="Enter Company Name"/>		
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                               <label id="req_answer">Type</label>
                            </div>
                            <div class="col-md-6">
                              <select class="form-control" id="fullapi_type" name="fullapi_type" style="width: 260px;">
                                 <option id="type_internal" value="internal_user" <?php if ($this->_tpl_vars['fullapi_details']['userType'] == 'internal_user'): ?> selected="selected"<?php endif; ?>>Internal User</option>
                                 <option id="type_external" value="external_user" <?php if ($this->_tpl_vars['fullapi_details']['userType'] == 'external_user'): ?> selected="selected"<?php endif; ?>>External User</option>
                              </select>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-6">
                               <label id="req_answer">Period From</label>
                            </div>
                            <div class="col-md-6" style="width: 60%;">
                            
                              <div class="input-group startdatepicker date">
                                 <input class="form-control" type="text" id="sdate" name="fullapi_validate_from" value="<?php echo $this->_tpl_vars['fullapi_details']['validityFrom']; ?>
" placeholder="DD/MM/YYYY" readonly />
                                 <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              </div>
                              
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                               <label id="req_answer">Period To</label>
                            </div>
                            <div class="col-md-6" style="width: 60%;">
                              
                              <div class="input-group expiredatepicker date">
                                 <input class="form-control" type="text" id="edate" name="fullapi_validate_to" value="<?php echo $this->_tpl_vars['fullapi_details']['validityTo']; ?>
" placeholder="DD/MM/YYYY" />
                                 <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              </div>
                            </div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="col-md-6">
                               <label id="req_answer">Search Count</label>
                            </div>
                            <div class="col-md-6" style="width: 53%;">
                              <input type="number" class="used_search_count" id="s_count" readonly/>
                              <input type="number" class="total_search_count" id="fullapi_search_count1" name="fullapi_search_count1" value="<?php echo $this->_tpl_vars['fullapi_details']['serachCount']; ?>
" placeholder="Enter Search Count"/>		
                            </div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="col-md-6">
                               <label id="req_answer">API Count</label>
                            </div>
                            <div class="col-md-6" style="width: 53%;">
                              <input type="number" class="used_search_count" id="a_count" readonly/>
                              <input type="number" class="total_search_count" id="fullapi_api_count1" name="fullapi_api_count1" value="<?php echo $this->_tpl_vars['fullapi_details']['apiCount']; ?>
" placeholder="Enter API Count"/>		
                            </div>
                        </div>
                        <div class="row r_email">
                           <div align="center" id="partner-external" class="partner-external">
                              <div class="col-md-6">
                                 <label id="req_answer">Partner E-Mail</label>
                              </div>
                              <div class="col-md-6">
                                 <input type="text" id="fullapi_email" name="fullapi_email" placeholder="Enter Email" value="<?php echo $this->_tpl_vars['external_details']['username']; ?>
" placeholder="Enter E-Mail" autocomplete="off"/>		
                              </div>
                           </div>
                           </div>
                           <div class="row r_pass">
                           <div align="center" id="partner-external" class="partner-external">
                              <div class="col-md-6">
                                 <label id="req_answer">Partner Password</label>
                              </div>
                              <div class="col-md-6">
                                 <input type="password" id="fullapi_password" name="fullapi_password" placeholder="Update Password ?"/>		
                              </div>
                           </div>
                           </div>
                           <div class="row r_pass">
                              <div align="center" id="partner-external" class="partner-external">
                                 <div class="col-md-6">
                                    <label id="req_answer">IP Address </label>
                                 </div>
                                 <div class="col-md-6">
                                    <input type="text" id="fullapi_ip" name="fullapi_ip" value="<?php echo $this->_tpl_vars['external_details']['ipAddress']; ?>
" placeholder="Enter IP Address" />		
                                    
                                 </div>
                              </div>
                              <br />
                                    <span style="color:#990000;margin-left: 175px;"> EX : 000.000.00.000 </span><br />
                           </div>
                            <div class="row">
                            <div class="col-md-6">
                               <label id="req_answer">Token</label>
                            </div>
                            <div class="col-md-6" style="width: 53%;">
                              <input type="text" id="fullapi_token" name="fullapi_token" style="width: 199px;" readonly value="<?php echo $this->_tpl_vars['fullapi_details']['userToken']; ?>
" />		
                              <button onclick="myToken()" type="button" id="copied" style="padding:8px;">Copy</button>
                            </div>
                        </div>
                        <div class="row r_pass">
                           <div align="center">
                              <div class="col-md-6">
                                 <label id="req_answer">Is Admin</label>
                              </div>
                              <div class="col-md-6">
                                 <input type="checkbox" id="fullapi_isadmin" name="fullapi_isadmin" <?php if ($this->_tpl_vars['external_details']['isadmin'] == '1'): ?> checked="checked"<?php endif; ?> style="margin-right: 240px;"/>		
                              </div>
                           </div>
                           </div>
                           <div class="row">
                           <div align="center">
                              <div class="col-md-6">
                                 <label id="req_answer">Active</label>
                              </div>
                              <div class="col-md-6">
                                 <input type="checkbox" id="fullapi_status" name="fullapi_status" <?php if ($this->_tpl_vars['fullapi_details']['user_status'] == '1'): ?> checked="checked"<?php endif; ?> style="margin-right: 240px;"/>		
                              </div>
                           </div>
                           </div>
                           
                         <br />
                        <div align="center">
                           <input type="submit" class="form-control submit-btn" name="submit"/>
                        </div>
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
  var copyText = document.getElementById("fullapi_token");
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
//Validation 
$(function() {
  $("form[name=\'update_form\']").validate({
    rules: {
      fullapi_name: "required",
      fullapi_company: "required",
      fullapi_type: "required",
      fullapi_token: "required",
      fullapi_validate_from: "required",
      fullapi_validate_to: "required",
      fullapi_search_count: "required",
      fullapi_api_count: "required",
      fullapi_ip: "required",
      fullapi_email: "required"
    },
    // Specify validation error messages
    messages: {
      fullapi_name: "Please Enter Name",
      fullapi_company: "Please Enter Company",
      fullapi_validate_from: "Please Enter From Date",
      fullapi_validate_to: "Please Enter To Date",
      fullapi_search_count: "Please Enter Search Count",
      fullapi_api_count: "Please Enter API Count",
      fullapi_ip: "Please Enter IP Address",
      fullapi_email: "Please Enter Email"
    }
  });
});
   // DatePicker
    
    $(function () {
    $(".startdatepicker,.expiredatepicker").datetimepicker({
        locale: "en",
        format: "YYYY-MM-DD",
        useCurrent: false,
        showTodayButton: true,
        showClear: true,
        icons: {
            time: "fa fa-clock-o",
            date: "fa fa-calendar",
            up: "fa fa-arrow-up",
            down: "fa fa-arrow-down",
            previous: "fa fa-angle-left",
            next: "fa fa-angle-right",
            today: "fa fa-thumb-tack",
            clear: "fa fa-trash"
        }
    });
    $(".startdatepicker").on("dp.change", function (e) {
        $(".expiredatepicker").data("DateTimePicker").minDate(e.date);
    });
    $(".expiredatepicker").on("dp.change", function (e) {
        $(".startdatepicker").data("DateTimePicker").maxDate(e.date);
    });
    $("#sdate").focus(function () {
        $(".startdatepicker").data("DateTimePicker").show();
    });
    $("#edate").focus(function () {
        $(".expiredatepicker").data("DateTimePicker").show();
    });
});
	//Insert Partner Controls
    $("#update_internal_partner").on(\'submit\', function(e){
        e.preventDefault();
        $.ajax({
            type: \'POST\',
            url: "fullapi/edit-fullapi-user.php",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response){
                console.log(response);
				if(response == "1"){
                  alert(\'Update User Details Successfully\');
                  window.location = \'fullapi/users-fullapilist.php\';
               }else if(response == "0"){
                  alert(\'Not Inserted Successfully\');
               }
              
            }
        });
        return false;
    });
    //End Partner Controls
	var p_type = $("#fullapi_type").val();
	if(p_type == "internal_user"){
      document.title = \'Create Internal User - JSON\';
      $("#title_id").html("Edit Internal User - JSON");
		$(".partner-external").hide();
      $("#type_external").hide();
      $(".r_email").hide();
      $(".r_pass").hide();
	}else if(p_type == "external_user"){
      $("#title_id").html("Edit External User - JSON");
      document.title = \'Edit External User - JSON\';
      $("#type_internal").hide();
   }

   //Partner Count Details
   
   var TokenID = $("#fullapi_token").val();
   
    $.ajax({ 
        type: \'POST\',
        url: "fullapi/fullapi_api_count_details.php",
        data: {"token": TokenID},
        success: function(response){
            if(response !=\'\'){
                var counlist = JSON.parse(response);
                $("#s_count").val(counlist.s_count);
                $("#a_count").val(counlist.a_count);
                
            }
        }
    });
});
 '; ?>
 
</script>