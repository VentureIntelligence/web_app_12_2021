{include file="admin/header.tpl"}
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js"></script>


{* Date-time-pickers *}
<script type="text/javascript" src="http://netdna.bootstrapcdn.com/bootstrap/3.1.1/js/bootstrap.min.js" charset="UTF-8"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.9.0/moment-with-locales.js" charset="UTF-8"></script>
<link href="https://cdn.rawgit.com/Eonasdan/bootstrap-datetimepicker/v4.0.0/build/css/bootstrap-datetimepicker.css" rel="stylesheet" media="screen">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" media="screen">
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js" charset="UTF-8"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.15.1/jquery.validate.min.js"></script>
{* <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-tools/1.2.7/jquery.tools.min.js"></script> *}
{literal}
<style type="text/css">
/* .tooltip {
    background:#404040;
    color:#fff !important;
    top: 47% !important;
    padding:5px;
    border-radius:5px;
    
} */
.tooltip {
    background:#404040;
    color:#fff !important;
    top: 80% !important;
    padding: 5px;
    border-radius: 5px;
    position: absolute;
    right: 0;
    
}
#download_now{
    font-size: 18px;
    cursor: pointer;
    margin: 6px 5px;
}
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
 {/literal} 

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
                        <div align="center"> <a href="PE/partners-list.php" style="float: right;">Back to Partners</a> </div>
                        <div class="adtitle" id="title_id" align="center"></div>
                        <div class="row">
                            <div class="col-md-6">
                                <label id="req_answer">Name</label>
                            </div>
                            <div class="col-md-6">
                                <input type="text" id="partner_name" name="partner_name" value="{$partner_details.partnerName}" placeholder="Enter Name"/>		
                              <input type="hidden" class="partner_id" name="partner_id" value="{$partner_details.partner_id}" />
                              <input type="hidden" id="user_id" class="user_id" name="user_id" value="{$partner_details.user_id}" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <label id="req_answer">Company Name</label>
                            </div>
                            <div class="col-md-6">
                              <input type="text" id="partner_company" name="partner_company" value="{$partner_details.partner_company}" placeholder="Enter Company Name"/>		
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                               <label id="req_answer">Type</label>
                            </div>
                            <div class="col-md-6">
                              <select class="form-control" id="partner_type" name="partner_type" style="width: 260px;">
                                 <option id="type_internal" value="internal_partner" {if $partner_details.partnerType == "internal_partner"} selected="selected"{/if}>internal_partner</option>
                                 <option id="type_external" value="external_partner" {if $partner_details.partnerType == "external_partner" or $partner_details.partnerType == "SubAPI"} selected="selected"{/if}>external_partner</option>
                                 {* <option id="type_subapi" value="sub_api_partner" {if $partner_details.partnerType == "sub_api_partner"} selected="selected"{/if}>sub_api_partner</option> *}
                              </select>
                              <input type="hidden" name="sub_api_partner" id="sub_api_partner" {if $external_details.api_type == "1"}value="1"{else}value="0"{/if}>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col-md-6">
                               <label id="req_answer">Period From</label>
                            </div>
                            <div class="col-md-6" style="width: 60%;">
                            
                              <div class="input-group startdatepicker date">
                                 <input class="form-control" type="text" id="sdate" name="partner_validate_from" value="{$partner_details.validityFrom|date_format:"%d/%m/%Y"}" placeholder="DD/MM/YYYY" readonly />
                                 <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              </div>
                              {* <input type="datetime" id="datetimepicker_from" name="partner_validate_from" value="{$partner_details.validityFrom}" placeholder="Validate From"/>		
                              <br>
                              <span class="datetime_v" style="display:none;color:red;margin-left: 40px;">Please Enter Currect DateTime</span> *}
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                               <label id="req_answer">Period To</label>
                            </div>
                            <div class="col-md-6" style="width: 60%;">
                              {* <input type="datetime" id="datetimepicker_to" name="partner_validate_to" value="{$partner_details.validityTo}" placeholder="Validate To"/> *}
                              <div class="input-group expiredatepicker date">
                                 <input class="form-control" type="text" id="edate" name="partner_validate_to" value="{$partner_details.validityTo|date_format:"%d/%m/%Y"}" placeholder="DD/MM/YYYY" />
                                 <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                              </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                               <label id="req_answer">Overall Count</label>
                            </div>
                            <div class="col-md-6" style="width: 62%;position:relative;">
                              <input type="number" class="used_search_count" id="o_count" readonly/>
                              <input type="number" class="total_search_count" id="partner_overall_count" name="partner_overall_count" value="{$partner_details.overallCount}" placeholder="Enter Overall Count"/>		
                              <i class="fa fa-question-circle" aria-hidden="true" id="download_now"></i>
                            <span class="tooltip " style="display:none;">It is summation of dealcount and companycount should not exceeds the overall count</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                               <label id="req_answer">Deal Count</label>
                            </div>
                            <div class="col-md-6" style="width: 53%;">
                              <input type="number" class="used_search_count" id="s_count" readonly/> 
                              <input type="number" class="total_search_count" id="partner_search_count" name="partner_search_count" value="{$partner_details.dealCount}" placeholder="Enter Deal Count"/>		
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                               <label id="req_answer">Company Count</label>
                            </div>
                            <div class="col-md-6" style="width: 53%;">
                              <input type="number" class="used_search_count" id="a_count" readonly/>
                              <input type="number" class="total_search_count" id="partner_api_count" name="partner_api_count" value="{$partner_details.companyCount}" placeholder="Enter Company Count"/>		
                            </div>
                        </div>
                        
                        <div class="row r_email">
                           <div align="center" id="partner-external" class="partner-external">
                              <div class="col-md-6">
                                 <label id="req_answer">Partner E-Mail</label>
                              </div>
                              <div class="col-md-6">
                                 <input type="text" id="partner_email" name="partner_email" placeholder="Enter Email" value="{$external_details.username}" placeholder="Enter E-Mail"/>		
                              </div>
                           </div>
                           </div>
                           <div class="row r_pass">
                           <div align="center" id="partner-external" class="partner-external">
                              <div class="col-md-6">
                                 <label id="req_answer">Partner Password</label>
                              </div>
                              <div class="col-md-6">
                                 <input type="password" id="partner_password" name="partner_password" placeholder="Update Password ?"/>		
                              </div>
                           </div>
                           </div>
                            <div class="row">
                            <div class="col-md-6">
                               <label id="req_answer">Token</label>
                            </div>
                            <div class="col-md-6" style="width: 53%;">
                              <input type="text" id="partner_token" name="partner_token" style="width: 199px;" readonly value="{$partner_details.partnerToken}" />		
                              <button onclick="myToken()" type="button" id="copied" style="padding:8px;">Copy</button>
                            </div>
                        </div>
                           <div class="row">
                           <div align="center">
                              <div class="col-md-6">
                                 <label id="req_answer">Active</label>
                              </div>
                              <div class="col-md-6">
                                 <input type="checkbox" id="partner_status" name="partner_status" {if $partner_details.partner_status == "1"} checked="checked"{/if} style="margin-right: 240px;"/>		
                              </div>
                           </div>
                           </div>
                         <br />
                        <div align="center">
                        <input type="hidden" name="count" id="count" value="">
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
{literal}
/*$(document).ready(function() {
      $("#download_now").tooltip({ effect: 'slide'});
    });*/
$( "#download_now" ).hover(function(){
    $('.tooltip').toggle();
});
function myToken() {
  var copyText = document.getElementById("partner_token");
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
//Validation 
$(function() {
  $("form[name='update_form']").validate({
    rules: {
      partner_name: "required",
      partner_company: "required",
      partner_type: "required",
      partner_token: "required",
      partner_validate_from: "required",
      partner_validate_to: "required",
      partner_search_count: "required",
      partner_api_count: "required",
      partner_overall_count:"required",
      partner_email: "required"
    },
    // Specify validation error messages
    messages: {
      partner_name: "Please Enter Name",
      partner_company: "Please Enter Company",
      partner_validate_from: "Please Enter From Date",
      partner_validate_to: "Please Enter To Date",
      partner_search_count: "Please Enter Search Count",
      partner_api_count: "Please Enter API Count",
      partner_overall_count:"Please Enter overall count",
      partner_email: "Please Enter Email"
    }
  });
});
   // DatePicker
    
    $(function () {
    $(".startdatepicker,.expiredatepicker").datetimepicker({
        locale: "en",
        format:'DD/MM/YYYY',
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
    $("#update_internal_partner").on('submit', function(e){
       
           var overallcount=parseInt($("#partner_search_count").val())+parseInt($("#partner_api_count").val());
          var count=$("#partner_overall_count").val();
        
                if (overallcount > count) {
                    var flag=1;
                  } 
          e.preventDefault();
        
        if(flag !=1){
           $('#partner_search_count').css('border-color','#ccc');
           $('#partner_api_count').css('border-color','#ccc');
        $.ajax({
            type: 'POST',
            url: "PE/edit-partner.php",
            data: new FormData(this),
            contentType: false,
            cache: false,
            processData:false,
            success: function(response){
                console.log(response);
				if(response == "1"){
                  alert('Update Partner Details Successfully');
                  window.location = 'PE/partners-list.php';
               }else if(response == "0"){
                  alert('Not Inserted Successfully');
               }
              
            }
        });
        
        }else{
           
           alert("Company count and Deal count should not be greater than the overall count. ");
           $('#partner_search_count').css('border-color','red');
           $('#partner_api_count').css('border-color','red');
        }
        return false;
    });
    //End Partner Controls
	var p_type = $("#partner_type").val();
   var subapi = $("#sub_api_partner").val();
	if(p_type == "internal_partner"){
      document.title = 'Create Internal Partner';
      $("#title_id").html("Edit Internal Partner");
		$(".partner-external").hide();
      $("#type_external").hide();
      //$("#type_subapi").hide();
      $(".r_email").hide();
      $(".r_pass").hide();
      //$("#sub_api_partner").val("0");
	}else if(p_type == "external_partner"){
      if(subapi == 1){
         $("#title_id").html("Edit Sub API Partner");
      }else{
         $("#title_id").html("Edit External Partner");
      }
      document.title = 'Create External Partner';
      $("#type_internal").hide();
      //$("#type_subapi").hide();
     // $("#sub_api_partner").val("0");
   }
   else if(p_type == "SubAPI"){
      $("#title_id").html("Edit Sub API Partner");
      document.title = 'Create Sub API Partner';
      $("#type_internal").hide();
      //$("#type_subapi").hide();
      //$("#sub_api_partner").val("0");
      /* $("#title_id").html("Edit Sub API Partner");
      document.title = 'Create Sub API Partner';
      $("#sub_api_partner").val("1");
      $("#type_internal").hide();
      $("#type_external").hide(); */
   }

   //Partner Count Details
   
   var TokenID = $("#partner_token").val();
   
    $.ajax({ 
        type: 'POST',
        url: "PE/partner_api_count_details.php",
        data: {"token": TokenID},
        success: function(response){
            if(response !=''){
                var counlist = JSON.parse(response);
                $("#s_count").val(counlist.s_count);
                $("#a_count").val(counlist.a_count);
                $("#o_count").val(counlist.o_count);
                
            }
        }
    });
});
 {/literal} 
</script>
