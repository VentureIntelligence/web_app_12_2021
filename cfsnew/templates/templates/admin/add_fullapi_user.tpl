{include file="admin/header.tpl"}
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js"></script>

{* Date-time-pickers *}
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js" charset="UTF-8"></script>
<link href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/v4.0.0/build/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
<link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="https://rawgit.com/Eonasdan/bootstrap-datetimepicker/development/src/js/bootstrap-datetimepicker.js" charset="UTF-8"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
{literal}
<style type="text/css">
/* CSS Document */
.error{
color:#990000;
font-size: 12px;
}
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
.token_generate{
    padding: 5px;
    font-size: 14px;
    float: left;
    background: #282828;
    /* width: 78%; */
    text-align: center;
    cursor: pointer;
    color: #ffffff;
}
#token_refresh{
    padding: 10px;
    font-size: 12px;
    float: left;
    cursor: pointer;
}
</style>

<script>
 {/literal} 

</script>
<script>
 {literal}
$(document).ready(function(e){
    var url = $(location).attr("href");
    var arguments = url.split('=');
    arguments.shift();
    var fullapi_type_control = arguments;

    if(fullapi_type_control == "internal_fullapi"){
        $("#fullapi-external").hide();
        document.title = 'Create Internal User';
        $("#title_id").html("Create Internal User - JSON");
        $("#fullapi_type option[value='internal_user']").attr("selected","selected");
        $(".p_external_control").hide();
        $("#fullapi_info").val("internal");
        $("#insert_internal_fullapi #fullapi_password").removeAttr('required');
        $("#insert_internal_fullapi #fullapi_email").removeAttr('required');
    }
    else if(fullapi_type_control == "external_fullapi"){
        $("#title_id").html("Create External User - JSON");
        document.title = 'Create External User';
        $("#fullapi-internal").hide();
        $("#fullapi_type option[value='external_user']").attr("selected","selected");
        $("#fullapi_info").val("external");
    }
});
 {/literal}
</script>
</head>
<div class="contentbg">
   <div class="breadcrumb">
      <div class="content" style="padding-top:0px;">
         <div class="breadtext">&nbsp;</div>
      </div>
   </div>
   <form  class="update_form" name="update_form" id="insert_internal_fullapi">
      <div id="slidecontainer">
         <div id="slidecontent">
            <div id="slider">
               <ul>
                  <li>
                     <div class="adminbox">
                        <div align="center"> <a href="user-fullapi-create.php" style="float: right;">Back to Create User</a> </div>
                        <div class="adtitle" id="title_id" align="center"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="fullapi_name">Name</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Enter Name" id="fullapi_name" name="fullapi_name" autocomplete="off"/>
                                <input type="hidden" name="fullapi_info" id="fullapi_info" />
                                <input type="hidden" name="fullapi_search_limit" value="0"/>
                                <input type="hidden" name="fullapi_api_limit" value="0"/>
                                <input type="hidden" name="location_for_mail" value="FULL API - JSON ACCESS - PE" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="fullapi_company">Company Name</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" class="form-control" placeholder="Enter Company" name="fullapi_company" id="fullapi_company" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="fullapi_type">Type</label>
                            </div>
                            <div class="col-md-6">
                                <select class="form-control" name="fullapi_type" id="fullapi_type" style="width: 265px;">
                                    <option hidden="">Select fullapi Type</option>
                                    <option id="fullapi-internal" value="internal_user">Internal User</option>
                                    <option id="fullapi-external" value="external_user">External User</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <label for="fullapi_duration_from">Period From</label>
                            </div>
                            <div class="col-md-6" style="width: 65%;">
                               <div class="input-group startdatepicker date">
                                    <input class="form-control" type="text" id="sdate" autocomplete="off" name="fullapi_duration_from" value="" placeholder="YYYY-MM-DD" />
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="fullapi_duration_to">Period To</label>
                            </div>
                            <div class="col-md-6" style="width: 65%;">
                                <div class="input-group expiredatepicker date">
                                    <input class="form-control" type="text" id="edate" autocomplete="off" name="fullapi_duration_to" value="" placeholder="YYYY-MM-DD" />
                                    <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                </div>
                            </div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="col-md-6">
                               <label for="fullapi_search_limit">Search Count</label>
                            </div>
                            <div class="col-md-6" style="width: 65%;">
                                <input type="number" class="form-control" placeholder="Enter Search Count Limit" name="fullapi_search_limit1" autocomplete="off"/>
                            </div>
                        </div>
                        <div class="row" style="display:none;">
                            <div class="col-md-6">
                               <label for="fullapi_api_limit">API Count</label>
                            </div>
                            <div class="col-md-6" style="width: 65%;">
                                <input type="number" class="form-control" placeholder="Enter API Count Limit" name="fullapi_api_limit1" autocomplete="off"/>
                            </div>
                        </div>
                        
                        <div id="p_external_control" class="p_external_control">
                        <div class="row"  >
                            <div align="center">
                                <div class="col-md-6">
                                    <label for="fullapi_email">User E-Mail</label>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control email_auto" placeholder="Enter E-Mail" name="fullapi_email" id="fullapi_email" autocomplete="off"/>
                                    <label style="color: #990000;font-size: 12px;display:none;" id="email_valid_err">fullapi already exists</label>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div id="p_external_control" class="p_external_control">
                            <div class="row" >
                                <div align="center">
                                    <div class="col-md-6">
                                        <label for="fullapi_password">User Password</label>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="password" class="form-control pass_auto" placeholder="Enter Password" name="fullapi_password" id="fullapi_password" autocomplete="off"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div id="p_external_control" class="p_external_control">
                            <div class="row">
                                <div class="col-md-6">
                                <label for="fullapi_api_limit">IP Address</label>
                                </div>
                                <div class="col-md-6" style="width: 65%;">
                                    <input type="text" class="form-control" placeholder="Enter IP Address" name="fullapi_ip" id="fullapi_ip"/>
                                    
                                </div>
                                <br />
                                    <span style="color:#990000;margin-left: 175px;"> EX : 000.000.00.000 </span><br />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label for="fullapi_password">Token</label>
                            </div>
                            <div class="col-md-6" style="width: 65%;">
                                <p class="form-control token_generate">Generate</p>
                                <i class="fa fa-refresh" aria-hidden="true" style="display:none;"  id="token_refresh"></i>
                                <div style="display:none;" class="token_view">
                                    <input type="text" class="form-control" placeholder="Enter Token" name="fullapi_token" id="fullapi_token" readonly/>
                                    <button onclick="myToken()" type="button" id="copied" style="padding:8px;">Copy</button>
                                </div>
                            </div>
                        </div>
                        
                        <div id="p_external_control" class="p_external_control">
                            <div class="row">
                                <div class="col-md-6">
                                <label for="fullapi_api_limit">Is Admin</label>
                                </div>
                                <div class="col-md-6" style="width: 65%;">
                                    <input type="checkbox" class="form-control" name="fullapi_isadmin" value="1"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                               <label for="fullapi_api_limit">Active</label>
                            </div>
                            <div class="col-md-6" style="width: 65%;">
                                <input type="checkbox" class="form-control" name="fullapi_status" value="1" checked/>
                            </div>
                        </div>
                        <br />
                        <br />
                        <div class="row">
                            <div align="center">
                                <input type="submit" class="form-control submit-btn" name="submit"/>
                            </div>
                        </div>
                        
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
{literal}
function myToken() {
  var copyText = document.getElementById("fullapi_token");
  copyText.select();
  copyText.setSelectionRange(0, 99999)
  document.execCommand("copy");
  //alert("Copied the text: " + copyText.value);
    $("#copied").text("Copied");
}
{/literal}
</script>
<script>
 {literal}
$(document).ready(function(e){
    $(".email_auto").attr("autocomplete", "off");
    $(".pass_auto").attr("autocomplete", "off");
    //DatePicker
    $(function () {
    $(".startdatepicker,.expiredatepicker").datetimepicker({
        locale: "en",
        format: "YYYY-MM-DD",
        useCurrent: false,
        showTodayButton: true,
        showClear: true,
        minDate: moment(),
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
    //Validation 
    $(function() {
        $("form[name='update_form']").validate({
            rules: {
            fullapi_name: "required",
            fullapi_company: "required",
            fullapi_type: "required",
            fullapi_token: "required",
            fullapi_duration_from: "required",
            fullapi_duration_to: "required",
            fullapi_search_limit: "required",
            fullapi_ip: "required",
            fullapi_api_limit: "required",
            //fullapi_email: "required",
            fullapi_email: 
                {
                    required: true,
                    email: true
                },
            fullapi_password: "required"
            },
            // Specify validation error messages
            messages: {
            fullapi_name: "Please Enter Name",
            fullapi_company: "Please Enter Company",
            fullapi_duration_from: "Select From Date",
            fullapi_duration_to: "Select To Date",
            fullapi_search_limit: "Please Enter Search Count",
            fullapi_api_limit: "Please Enter API Count",
            fullapi_ip: "Please Enter IP Address",
            fullapi_password: "Please Enter Password",
            fullapi_email: {
                required: "Please enter email address",
                email: "Please enter a valid email address.",
            }

            }
            //submitHandler: function(form) {
            //}
        });
    });
    
    //Insert Datas
    $("#insert_internal_fullapi").on('submit', function(e){
        e.preventDefault();
        $.ajax({
            type: 'POST',
            url: "add-fullapi.php",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response){
                console.log(response);
                if(response == "1"){
                    $.ajax({         
                        type: 'POST',  
                        url : "../submission_mail.php",
                        data: $('#insert_internal_fullapi').serialize(),
                        success: function (response) {          
                            console.log(response);          
                        },
                        error: function(request,  error , status) {
                            console.log(error); 
                        }       
                    });
                    alert('User Created Successfully');
                    window.location = 'users-fullapilist.php';
                    //$("#insert_internal_fullapi").trigger("reset");
                }else if(response == "0"){
                    alert('User Not Created Successfully');
                    //window.location.href ="fullapis-list.php";
                }
                else if(response == "not_valid_email"){
                    $("#email_valid_err").show();
                   
                }
                
            }
        });
        return false;
    });

    //Token Create
    var userT = $("#fullapi_info").val();
    $.ajax({ 
        type: 'POST',
        url: "create-token.php",
        data: {"fullapi_info": userT},
        success: function(response){
            if(response !=''){
                $("#fullapi_token").val(response);
                
            }
        }
    });
    $(".token_generate").on('click', function(e){
        e.preventDefault();
        $("#token_refresh").show();
        $(".token_view").show();
    });
    $("#token_refresh").on('click', function(e){
        var userT = $("#fullapi_info").val();
        e.preventDefault();
        $.ajax({ 
        type: 'POST',
        url: "create-token.php",
        data: {"fullapi_info": userT},
        success: function(response){
            if(response !=''){
                $("#fullapi_token").val(response);
            }
        }
    });
        return false;
    });
    //End fullapi Controls
});
 {/literal}
</script>