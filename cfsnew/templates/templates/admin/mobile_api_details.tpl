{include file="admin/header.tpl"}
<link href="{$ADMIN_CSS_PATH}home.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}jquery.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css" />
<script type="text/javascript" src="{$smarty.const.BASE_URL}/cfsnew/admin/js/jquery.tablesorter.js"></script>


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
        width: 70%;
    margin: auto;
}
.fieldset-user{
    width: 62%;
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
    right: -60px;
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
</style>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="https://code.highcharts.com/stock/highstock.js"></script>
<script src="https://code.highcharts.com/modules/series-label.js"></script>
<script src="https://code.highcharts.com/modules/exporting.js"></script>
<script src="https://code.highcharts.com/modules/export-data.js"></script>
<script type="text/javascript">
{/literal} 
    var mobileapi = {$apitrackinglist};
 {literal} 
    $(document).ready(function(){
        mobileApiList = [] ;
        for(i=0 ; i<mobileapi.length;i++) {
            mobileApiList.push(mobileapi[i].user);
                 $("#optionList").append('<option value="'+mobileapi[i].user+'">'+mobileapi[i].user+'</option>');
        }
    });
    function userList() {
        var username = $('#optionList').val();
        var dataString = 'name='+ username ;
            $.ajax({
                type: 'POST',
                url: "ajaxmobiletracking.php",
                data: dataString ,
                success: function(response){
                    var counlist = JSON.parse(response);
                    $("#totalCount").append(counlist.totalcount);
                    $("#profileCount").append(counlist.profileData);
                    $("#financialCount").append(counlist.financialData);
                    $("#searchCount").append(counlist.totalusers);
                 }
          })
    }
     $(document).on("change","#optionList",function(){
            $("#totalCount,#profileCount,#financialCount,#searchCount").empty();
            userList();
    });
    
</script>
{/literal}
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
			<div><span style="float:left; font-size: 13px; text-decoration: underline;"><a href="{$smarty.const.ADMIN_BASE_URL}index.php">Back to Home</a></span></div>
				<div class="adtitle" align="center">
						MOBILE API TRACKING
                 </div>
<div class="api-details">
            <div class="widget-selectUser">
                <fieldset class="fieldset-user">
                    <legend>Select user :</legend>
                       <select name="username" id="optionList">
                            <option hidden>Select User</option>
                       </select>
                </fieldset>
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
                    <legend>Company Count :</legend>
                       <div class="counter">
                            <span id="searchCount">0</span>
                        </div>
                </fieldset>
                <div class="totalCount">
                        <span><i class="fa fa-clock-o" aria-hidden="true"></i>Total API Count :</span>
                         <span id="totalCount">0</span>
                </div>
                <div style="clear:both"></div>
                </div>
            </div>
</div>
</div>
</div>