{* {include file="admin/header.tpl"} *}
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
   <head>
      <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
      <title>{$pageTitle}</title>
      <script language="javascript" type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
      {* <script language="javascript" type="text/javascript" src="{$ADMIN_JS_PATH}prototype.js"></script> *}
      <link type="text/css" rel="stylesheet" href="{$ADMIN_CSS_PATH}bootstrap.min.css" />
      <link type="text/css" rel="stylesheet" href="{$ADMIN_CSS_PATH}header.css" />
      <link href="{$ADMIN_CSS_PATH}home.css" rel="stylesheet" type="text/css" media="screen"/>
      {literal}
      <style type="text/css">
         /* Override some defaults */
         html, body {
         background-color: #eee;
         }
         body {
         padding-top: 40px; /* 40px to make the container go all the way to the bottom of the topbar */
         }
         .container > footer p {
         text-align: center; /* center align it with the container */
         }
         .container {
         width: 915px; /* downsize our container to make the content feel a bit tighter and more cohesive. NOTE: this removes two full columns from the grid, meaning you only go to 14 columns and not 16. */
         }
         /* The white background content wrapper */
         .container > .content {
         background-color: #fff;
         padding: 20px;
         margin: 0 -20px; /* negative indent the amount of the padding to maintain the grid system */
         -webkit-border-radius: 0 0 6px 6px;
         -moz-border-radius: 0 0 6px 6px;
         border-radius: 0 0 6px 6px;
         -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.15);
         -moz-box-shadow: 0 1px 2px rgba(0,0,0,.15);
         box-shadow: 0 1px 2px rgba(0,0,0,.15);
         }
         /* Page header tweaks */
         .page-header {
         background-color: #f5f5f5;
         padding: 20px 20px 10px;
         margin: -20px -20px 20px;
         }
         /* Styles you shouldn't keep as they are for displaying this base example only */
         .content .span10,
         .content .span4 {
         min-height: 500px;
         }
         /* Give a quick and non-cross-browser friendly divider */
         .content .span4 {
         margin-left: 0;
         padding-left: 19px;
         border-left: 1px solid #eee;
         }
         .topbar .btn {
         border: 0;
         }
      </style>
      {/literal}
      <div class="topbar">
         <div class="fill">
            <div class="container">
               <a class="brand" href="{$smarty.const.ADMIN_BASE_URL}index.php">CFS Admin Panel</a>
               {if $curPage neq 'register.php'}
               <ul class="nav">
                  {if $Usr_Flag eq 1 or $Usr_Flag eq 2}<li {if $curPage eq 'pmanagement.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}pmanagement.php">Company Profile</a></li>{/if}
                  {if $Usr_Flag eq 1 or $Usr_Flag eq 2}<li {if $curPage eq 'fmanagement.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}fmanagement.php">Company Financials</a></li>{/if}
                  {if $Usr_Flag eq 1}<li {if $curPage eq 'addIndustry.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}addIndustry.php">Add Industry</a></li>{/if}
                  {if $Usr_Flag eq 1}<li {if $curPage eq 'addSector.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}addSector.php">Add Sector</a></li>{/if}
                  {if $Usr_Flag eq 1}<li {if $curPage eq 'adminusers.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}adminusers.php">Admin Users</a></li>{/if}
                  {if $Usr_Flag eq 1}<li {if $curPage eq 'naicsCodeCheck.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}naicsCodeCheck.php">NAICS Code Check</a></li>{/if}
                  {if $Usr_Flag eq 1}<li {if $curPage eq 'index.php'}{/if}><a href="{$smarty.const.ADMIN_BASE_URL}index.php">Back To Home</a></li>{/if}
                  <li {if $curPage eq 'logout.php'}class="active"{/if}><a href="{$smarty.const.ADMIN_BASE_URL}logout.php">logout</a></li>
                  {/if} 
               </ul>
            </div>
         </div>
      </div>
   </head>
   <link href="{$ADMIN_CSS_PATH}home.css" rel="stylesheet" type="text/css" media="screen"/>
   <script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
   <script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
   <script type="text/javascript" src="{$ADMIN_JS_PATH}jquery.js"></script>
   <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
   <link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
   <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
   <script type="text/javascript" src="{$smarty.const.BASE_URL}/cfsnew/admin/js/jquery.tablesorter.js"></script>
   {* datepickers *}
   <script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
   <script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
   <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
   <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
   {* end *}
   {literal}
   <style type="text/css">
      /* CSS Document */
      .PLDPanel{
      display:none;
      cursor:pointer;
      }
      .BSPanel{
      display:none;
      }
      .CFPanel{
      display:none;
      }
      .PLDFlip{
      cursor:pointer;
      }
      .BSFlip{
      cursor:pointer;
      }
      .CFFlip{
      cursor:pointer;
      }
      .error{
      color:#990000;
      font-weight:bold;
      }
      /* CSS Clearfix */
      .clearfix:after {
      content: ".";
      display: block;
      height: 0;
      clear: both;
      visibility: hidden;
      }
      .clearfix{clear:both;}
      .clearfix {display: inline-table;}
      /* Hides from IE-mac \*/
      * html .clearfix {height: 1%;}
      .clearfix {display: block;}
      /* End hide from IE-mac */
      ul, ol, dl {
      list-style:none outside none;
      padding-left:20px;
      }
      p, pre, ul, ol, dl, dd, blockquote, address, fieldset, .gallery-row, .post-thumb, .post-thumb-single, .entry-meta {
      padding-bottom:0px;
      }
      /*END OF COMMON CODE*/
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
      width: 550px;
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
      width:auto;
      color:#333333;
      text-align:left;
      }
      input[type=radio]{
      width:20px;
      }
      .suggestionsBox {
      margin-left: 280px !important;
      margin-right: 14px  !important;
      max-height: 500px;
      overflow-y: scroll;
      z-index: 10;
      min-width: 256px;
      }
      .suggestionList ul
      {
      padding: 0 !important; 
      }
      .suggestionList ul li{
      color: #fff;    
      }
      .col-3 {
      width: 40%;
      float: left;
      }
      .col-2 {
      width: 25%;
      float: left;
      }
      .xbrl-row {
      margin-top: 15px;
      }
      span.remove_row,
      span.log_link {
      text-decoration: underline;
      cursor: pointer;
      position: relative;
      top: 10px;
      }
      span.log_link a {
      color: #F00;
      }
      span.log_link:not(:first-child) {
      left: 8px;
      }
      .loader-text:after {
      content: "Loading...";
      position: absolute;
      top: 40%;
      left: 0;
      right: 0;
      text-align: center;
      display: table-cell;
      }
      .loader-text {
      position: relative;
      Font-size: 30px;
      color: #fff;
      display: table;
      height: 100vh;
      width: 100%;
      }
      .body-overlay, .body-overlay2 {
      background: rgba(0,0,0,0.5);
      display: none;
      position: fixed;
      top: 0;
      bottom: 0;
      left: 0;
      right: 0;
      z-index:9;
      }
      .addRow {
      background: transparent;
      border: none;
      display: inline-block;
      position: relative;
      font-size: 15px;
      color: #1d52b0;
      margin-left: 12px;
      outline: 0;
      }
      .addRow:hover, .addRow:active, .addRow:focus {
      text-decoration: none;
      outline: 0;
      }
      .addRow:before {
      content: "";
      background: url(images/add.png) no-repeat;
      height: 25px;
      width: 25px;
      display: inline-block;
      vertical-align: middle;
      margin-right: 3px;
      background-size: 21px;
      }
      .remove_row {
      font-size: 0;
      }
      .remove_row:before {
      content: "";
      display: inline-block;
      background: url(images/delete.svg) no-repeat;
      height: 25px;
      width: 25px;
      display: inline-block;
      vertical-align: middle;
      margin-right: 5px;
      background-size: 15px;
      margin-top:-4px;
      }
      .btn-submit {
      background: #1D52B0;
      display: inline-block;
      padding: 10px 20px;
      color: #fff;
      border-radius: 4px;
      font-size: 15px;
      cursor: pointer;
      }
      .btn-submit:hover {
      color: #fff;
      text-decoration: none;
      }
      input.req_cin {
      width: 180px;
      }
      select.req_folder {
      width: 100px;
      }
      select.req_type {
      width: 130px;
      }
      .err-fields {
      padding: 5px 0 0 0;
      }
      .err-fields > span {
      /*text-decoration: underline;*/
      padding: 0px 10px;
      border-right: 1px solid #ccc;
      }
      .up-err {
      color: #F10000;
      }
      .err-fields > span.success {
      color: #008000;
      }
      .err-fields > span:first-child {
      padding-left: 0px;
      }
      .err-fields > span:last-child {
      border: 0;
      }
      #today_cin_container {
      margin:30px 0 0 0; 
      text-align: center;
      }
      #today_cin_container div {
      overflow-y: scroll; max-height: 500px;
      }
      #today_cin_container div ul {
      margin:0 auto;padding:0px; width: 35%;
      }
      #today_cin_container div ul li {
      font-size:13px; background: #dedede; margin-bottom: 2px;
      }
      #today_cin_container div ul li a {
      padding: 10px; display: block;
      }
      .search_box {
      background: #eaeaea; padding: 13px 10px 10px 10px;
      }
      .from_date_box {
      float: left; margin-right: 10px;
      }
      .to_date_box {
      float: left;
      }
      .from_date_box input, .to_date_box input {
      float: left; width: 85px;
      }
      .from_date_box label {
      float: left; width: 55px;
      }
      .to_date_box label {
      float: left; width: 35px;
      }
      .search_sep {
      float: left; margin: 1px 10px 0px 5px; font-size: 16px; padding: 6px; color: #949494;
      }
      .cin_box {
      float: left;
      }
      .cin_box label {
      width: 48px;
      }
      .cin_box input {
      float: left; width: 180px;
      }
      .search_box_submit {
      float: left;margin-left: 10px;margin-top: -3px;
      }
      .maintable tbody td {
      vertical-align: middle;
      }
      .widget-selectUser{
      padding-bottom:15px;
      width: 90%;
      margin: auto;
      }
      .fieldset-user{
      width: 50%;
      }
      #optionList:focus {
      outline:0;
      }
      #optionList{
      background: transparent;
      border: 0px;
      font-size: 16px;
      padding: 0px 7px;
      width: 100%;
      }
      .widget-selectUser fieldset{ 
      border-color: #eeeeeeb3 !important;
      display: block;
      padding: 12px !important;
      -webkit-margin-start: 2px;
      -webkit-margin-end: 2px;
      -webkit-padding-before: 0.35em;
      -webkit-padding-start: 0.75em;
      -webkit-padding-end: 0.75em;
      -webkit-padding-after: 0.625em;
      min-width: -webkit-min-content;
      border-width: 2px;
      border-style: groove;
      border-color: threedface;
      border-image: initial;
      }
      .widget-selectUser legend{
      font-size: 13px;
      font-weight: bold;
      padding-left: 8px !important;
      padding-right: 10px !important;
      display: block;
      -webkit-padding-start: 2px;
      -webkit-padding-end: 2px;
      border-width: initial;
      border-style: none;
      border-color: initial;
      border-image: initial;
      }
      .apilist{
      width: 35%;
      margin-right: 15px !important;
      float: left;
      }
      .search-countlist{
      width: 20%;
      float: left;
      }
      .api-countlist{
      margin-top: 30px;
      position: relative;
      }
      #profileCount,#financialCount {
      float:right;
      color:#000;
      font-size: 16px;
      }
      .api-color {
      color: #808080;
      font-size: 16px;
      }
      .list-1 {
      margin-bottom:7px ;
      }
      .counter{
      padding: 11px;
      font-size: 16px;
      color: #000;
      }
      .totalCount{
      position: absolute;
      right: 35px;
      top: 30px;
      font-size: 19px;
      color: #000;
      }
      .totalCount i {
      margin-right: 12px;
      }
      .totalCount::before {
      content: '';
      position: absolute;
      border-left: 1px solid #ccc;
      height: 70px;
      top: -25px;
      left: -50px;
      }
      .date_style{
      width: 87%;
      padding: 10px;
      margin: 10px;
      }
      #betweendateCount{
      float: right;
      color: #000;
      font-size: 16px;
      }
      #totalCount{
      
      color: #000;
      font-size: 16px;
      }
      .daterangepicker .calendar-table th, .daterangepicker .calendar-table td{
      min-width:0px !important;
      }
      .daterangepicker .ranges li.active{
            background-color: #2a2a2a !important;
      }
      .search-btn{
         color:#fff;
         background: #2a2a2a;
         border-radius: 0px;
         width: 110px !important;
         padding: 10px;
      }
      .search-btn:hover{
          color:#fff !important;
          background: #2a2a2a;
      }
      .loading {
        background: rgba(0, 0, 0, 0.3);
        bottom: 0;
        left: 0;
        position: fixed;
        right: 0;
        top: 0;
        z-index: 9998;
        }

        .spinner {
        background: #000 url(https://code.jquery.com/mobile/1.1.0/images/ajax-loader.gif) 0 0 no-repeat;
        border: 0;
        -webkit-border-radius: 36px;
        -moz-border-radius: 36px;
        border-radius: 36px;
        box-shadow: 0 1px 1px -1px #fff;
        display: block;
        height: 46px;
        left: 50%;
        margin: -23px 0 0 -23px;
        opacity: 0.18;
        overflow: hidden;
        padding: 1px;
        position: fixed;
        text-align: center;
        top: 50%;
        width: 46px;
        z-index: 9999;
        }
      .agree_btn{
         color: #fff;
         background: #462d2d;
         border-radius: 0px;
         width: 110px !important;
         /* padding: 10px; */
         align-items: center;
      }
      .cross_agree{
         position: absolute;
         right: 0px;
         top: -7px;
         background: red;
         color: #fff;
         padding: 2px;
         opacity: 1;
      }
      .agree_popup{
             display: block;
            padding-right: 0px;
            width: 695px;
            border-radius: 0;
      }
   </style>
{/literal} 
   <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
   <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
   <!--<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
      <script src="https://code.highcharts.com/stock/highstock.js"></script>
      <script src="https://code.highcharts.com/modules/series-label.js"></script>
      <script src="https://code.highcharts.com/modules/exporting.js"></script>
      <script src="https://code.highcharts.com/modules/export-data.js"></script>-->
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
         <script type="text/javascript">
   var partnerapi = {$partner_apitrackinglist};
   
   {literal} 
       
         $(document).ready(function(){
              partnerApiList = [] ;
              for(i=0 ; i<partnerapi.length;i++) {
                  partnerApiList.push(partnerapi[i].user);
                       $("#optionList").append('<option value="'+partnerapi[i].user+'">'+partnerapi[i].user+'</option>');
                       $('#optionList').val('vijayakumar.k@praniontech.com');
              }
          });
         $(document).on("click","#submit-data",function(){
                  $("#totalCount,#profileCount,#financialCount,#searchCount").empty();
                  userList();
         });
         $(document).ready(function(e){
            $("#search_data").on('submit', function(e){
               var drp = $('#reportrange span').html();
               $("#drp").val(drp);
               $("#duration_data").val(drp);
               var user_email = $("#optionList").val();
               $("#user_data").val(user_email);
               $("#totalCount,#profileCount,#financialCount,#searchCount").text('0');
               e.preventDefault();
               $.ajax({
                  type: 'POST',
                  url: "ajaxpartnertracking.php",
                  data: new FormData(this),
                  //data: {"username": username, "drp": date1},
                  contentType: false,
                  cache: false,
                  processData:false,
                  success: function(response){
                     showLoader();
                     console.log(response);
                     if(response !=''){
                        $("#totalCount,#profileCount,#financialCount,#searchCount,#betweendateCount").empty();
                        $(".search_count_datas").show();
                        var counlist = JSON.parse(response);
                        $("#totalCount").append(counlist.totalcount);
                        $("#profileCount").append(counlist.profileData);
                        $("#financialCount").append(counlist.financialData);
                        $("#searchCount").append(counlist.totalusers);
                        $("#betweendateCount").append(counlist.betweendateCount);
                        console.log(counlist.totalcount,"totalCount");
                           $("#profile_data_count").val(counlist.profileData);
                           $("#financial_data_count").val(counlist.financialData);
                           $("#search_data_h").val(counlist.totalusers);
                           $("#total_data").val(counlist.totalcount);
                           //$("#user_data").val(username);
                          
                     }else{
                        $("#profile_data_count").val('0');
                           $("#financial_data_count").val('0');
                           $("#search_data_h").val('0');
                           $("#total_data").val('0');
                     }
                        hideLoader();
                     }
               });
               return false;
            });
         });
   {/literal}
</script>
   </head>
   <div class="body-overlay">
      <div class="loader-text"></div>
   </div>
   <div class="contentbg">
   <div class="breadcrumb">
      <div class="breadtext">&nbsp;</div>
   </div>
   <div class="container">
      <div class="content">
        <div class="loading" style="display: none;">
            <div class="spinner"></div>
        </div>
         <div>
            <span style="float:left; font-size: 13px; text-decoration: underline;"><a href="{$smarty.const.ADMIN_BASE_URL}index.php">Back to Home</a></span>
         </div>
         <div class="adtitle" align="center">
            Partner API TRACKING
         </div>
         <div class="api-details">
            
               <div class="widget-selectUser">
               <form method="post" id="search_data" name="search_data" enctype="multipart/form-data" data-toogle="validator">
                  <div class="col-md-6" style="width:80%;">
                     <fieldset class="fieldset-user" style="float: left;margin-right: 5px;">
                        <legend>Select user :</legend>
                        <select name="username" id="optionList" required>
                           <option hidden>Select User</option>
                        </select>
                        <input type="hidden" id="drp" name="drp"/>
                        <input type="hidden" id="drp_load" value=""/>
                        <input type="hidden" id="username_load"/>

                     </fieldset>
                  </div>
                  <div class="col-md-6" style="width:96%;">
                     <fieldset class="fieldset-user">
                        <legend>Select Duration :</legend>
                        <div id="reportrange" style="cursor: pointer; padding: 5px 10px;width: 94%;color: #838080;font-size:16px;">
                           <i class="fa fa-calendar" style="float:right;"></i>&nbsp;
                           <span></span> 
                        </div>
                     </fieldset>
                  </div>
                  <br>
                  <div class="col-md-6">
                        <input class="btn search-btn" id="submit" type="submit" value="Search ">
                  </div>
                  <div class="api-countlist">
                     <fieldset class="fieldset-user apilist" >
                        <legend>API:</legend>
                        <div class="list-1">
                           <span class="api-color">Profile Data</span>
                           <span id="profileCount">0</span>
                        </div>
                        <div class="list-2">
                           <span class="api-color">Financial Data</span>
                           <span id="financialCount">0</span>
                        </div>
                     </fieldset>
                     <fieldset class="fieldset-user search-countlist">
                        <legend>Search Count :</legend>
                        <div class="counter">
                           <span id="searchCount">0</span>
                        </div>
                     </fieldset>
                     <div class="totalCount">
                        <span><i class="fa fa-clock-o" aria-hidden="true"></i>Total Count :</span>
                        <span id="totalCount">0</span>
                      
                     </div>
                     
                     <div style="clear:both"></div>
                     
                  </div>
                  </form>
                  <div class="col-md-6">
                  <button type="button" class="btn search-btn" data-toggle="modal" data-target="#myModal" style="float:right;">CSV Export</button>
            <div style="clear:both"></div>
            </div>
                </div>
            {* Model For Explod *}
            <div class="modal fade agree_popup" id="myModal" role="dialog">
               <div class="modal-dialog">
                  <!-- Modal content-->
                  <div class="modal-content" style="position: relative;">
                     <div class="modal-body">
                     <button type="button" class="close cross_agree" data-dismiss="modal">&times;</button>
                        <p style="text-align:center;">© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.</p>
                        <form method="post" action="partner-api-details-csv.php" id="csv_file_export" name="csv_file_export">
                           <input type="hidden" name="user_data" id="user_data" />
                           <input type="hidden" name="duration_data" id="duration_data" />
                           <input type="hidden" name="profile_data_count" id="profile_data_count" />
                           <input type="hidden" name="financial_data_count" id="financial_data_count" />
                           <input type="hidden" name="search_data_h" id="search_data_h" />
                           <input type="hidden" name="total_data" id="total_data" />
                           <center><input type="submit" class="btn agree_btn" name="export" value="I Agree"/></center>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   {literal}
   <script type="text/javascript">
      jQuery.noConflict();
      $(function() {
          var start = moment("20190101", "YYYYMMDD");
          var end = moment();
          function cb(start, end) {
              $('#reportrange span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'));
          }
          
          $('#reportrange').daterangepicker({
              startDate: moment("20190101", "YYYYMMDD"),
              endDate: end,
              ranges: {
                 'Today': [moment(), moment()],
                 'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                 'Last 7 Days': [moment().subtract(6, 'days'), moment()],
                 //'Last 30 Days': [moment().subtract(29, 'days'), moment()],
                 'This Month': [moment().startOf('month'), moment().endOf('month')],
                 'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
                 'All': [moment("20190101", "YYYYMMDD"), moment()],
                }
          }, cb);
      
          cb(start, end);
           
      });

      function showLoader() {
        $(".loading").css("display", "block");
        }
        function hideLoader() {
        setTimeout(function () {
        $(".loading").css("display", "none");
        }, 1000);
        }
        $(document).ready(function(){
            var username = $("#optionList").val();
            var drp = $('#reportrange span').text();
               $.ajax({ 
                      type: 'POST',
                      url: "ajaxpartnertracking.php",
                      data: {"username": username, "drp": drp},
                     success: function(response){
                        showLoader();
                        console.log(response);
                        if(response !=''){
                           $("#totalCount,#profileCount,#financialCount,#searchCount,#betweendateCount").empty();
                           $(".search_count_datas").show();
                           var counlist = JSON.parse(response);
                           $("#totalCount").append(counlist.totalcount);
                           $("#profileCount").append(counlist.profileData);
                           $("#financialCount").append(counlist.financialData);
                           $("#searchCount").append(counlist.totalusers);
                           $("#betweendateCount").append(counlist.betweendateCount);
                           console.log(counlist.totalcount,"totalCount");
                           $("#profile_data_count").val(counlist.profileData);
                           $("#financial_data_count").val(counlist.financialData);
                           $("#search_data_h").val(counlist.totalusers);
                           $("#total_data").val(counlist.totalcount);
                           $("#user_data").val(username);
                           $("#duration_data").val(drp);
                        }
                           hideLoader();
                     }
                  });
         });
   </script>
   {/literal}