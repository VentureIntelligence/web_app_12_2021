{include file="admin/header.tpl"}
<link href="{$ADMIN_CSS_PATH}home.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}jquery.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" />

<script type="text/javascript" src="{$smarty.const.BASE_URL}/cfsnew/admin/js/jquery.tablesorter.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment-with-locales.min.js" charset="UTF-8"></script>
{literal}


<style type="text/css">
/* CSS Document */
.container > .content{
    margin: 0px -45px!important;
    }
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
#mobileApi_filter,#customerTrack_filter {
	visibility: hidden;
	height:1px;
}
#mobileApi_wrapper table.dataTable thead th, #mobileApi_wrapper table.dataTable thead td ,
#customerTrack_wrapper table.dataTable thead th, #customerTrack_wrapper table.dataTable thead td {
    padding: 8px 10px;
    border-bottom: 1px solid #111;
}


#mobileApi_length select ,#customerTrack_length select{
   width: 65px;
}
#mobileApi_length label ,#customerTrack_length label{
   font-size: 15px;
}
#mobileApi_length ,#customerTrack_length{
    float: right;
}
.highcharts-title tspan{
	font: bold 24px "Courier New", Courier, monospace;
    margin: 15px 0;
    fill: #000;
}
#containerChart {
	margin-top: 25px ;
}
#partnersDetails_filter{
   display:none;
}
.dataTables_length select{
  width: 60px !important;
}
.dataTables_length{
   float:right !important;
}
table.dataTable thead th, table.dataTable thead td{
   padding:5px !important;
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
	//var mobileapi = {$apitrackinglist};
	var partnersDetails = {$partnerlist};
    console.log(partnersDetails);
 {literal} 
$( document ).ready( function() {

   $('.req_cin').keyup(function() {
				var searchfilter =$('.req_cin').val();
				 var table = $('#partnersDetails').DataTable();
				 var filtered = table.search(searchfilter).column().data().draw();
			  });

		table1 = $('#partnersDetails').DataTable({
				"autoWidth": false,
				 data: partnersDetails,
                 "order": [7,"DESC"],
				"ordering": true,
            "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
				"columns": [
					{ "data": "partnerName" },
					{ "data": "partner_company" },
                    { "data": "api_type",
                        render: function(data, type, full) {
                            if (data == '1')
                                return 'SubAPI';
                            else
                                return 'PE'       
                            } 
                    },
					{ "data": "partnerType",
                        render: function(data, type, full) {
                            if (data == 'external_partner')
                                return 'External';
                            else if(data == 'internal_partner')
                                return "Internal";
                            else
                                return 'error'       
                            } 
                    },
					
					{ "data": "validityFrom",
                        render: function(data, type, full) {
                            if (data != '')
                                return moment(new Date(data)).locale('el').format('DD/MM/YYYY');
                            else
                                return "No-Date";             
                            } 
                    },
					{ "data": "validityTo",
                        render: function(data, type, full) {
                            if (data != '')
                                return moment(new Date(data)).locale('el').format('DD/MM/YYYY');
                            else
                                return "No-Date";             
                            }
                         },
					{ "data": "dealCount",
                     
                        render: function(data, type, row) {
                            if (data != '')
                            return row.searchApi + ' / ' + row.dealCount;
                              //  return row.dealCount;
                            else
                                return "-";             
                            }
                     },
					{ "data": "companyCount",
                        render: function(data, type, row) {
                            if (data != '')
                              return row.apiTotal + ' / ' + row.companyCount;
                              // return row.companyCount;
                            else
                                return "-";             
                            }
                     }
                     ,
                     { "data": "overallCount",
                        render: function(data, type, row) {
                            if (data != '')
                               return row.overallTotal + ' / ' + row.overallCount;
                              // return row.overallCount;
                            else
                                return "-";             
                            }
                     },
					/*{ "data": "partner_status",
						render: function(data, type, full) {
                            if (data == '1')
                                return "Active";
							else if(data == '0')
                                return "Inactive";             
                            else
								return "No-status";
						}
							
					},*/
					/* { "data": "createdAt",
                        render: function(data, type, full) {
                            if (data != '')
                                return moment(new Date(data)).locale('el').format('DD/MM/YYYY');
                            else
                                return "No-Date";             
                            }
                     },	 */ 
                     
                    { "data": "partner_id",
                        
                        render: function(data, type, full) {
                            if (data != '')
                                return '<a href="../viewpepartner.php?pid='+data+'"> <img src="../images/view.png" width="20" height="20" title="Click to View" alt="Click to Edit" style="cursor:pointer;" /></a>  <a href="../editpepartner.php?pid='+data+'" style="float: right;"> <img src="../images/edit.png" width="16" height="16" title="Click to Edit" alt="Click to Edit" style="cursor:pointer;" /></a>';
                            else
                                return "";             
                            }
                        
                         }
				]
				});	
           

	});

</script>
{/literal}
</head>

<div class="body-overlay">
   <div class="loader-text"></div>
</div>

<div class="body-overlay2">
   <div class="popup-container" style="width: 500px; background: #fff; height: auto; margin: 135px auto; padding:10px; position: relative;">
      <div style="position: absolute; top: 5px; right: 5px;"><a href="javascript:;" onclick="closeuserpopup();"><i><img src="../images/Close.png" width="15" height="15" /></i></a></div>
      <table>
         <tr>
            <td style="border-top: 0px;">Date</td>
            <td style="border-top: 0px;" class="rdate"></td>
         </tr>
         <tr>
            <td>User name</td>
            <td class="rname"></td>
         </tr>
         <tr>
            <td>CIN</td>
            <td class="rcin"></td>
         </tr>
         <tr>
            <td>Log File</td>
            <td class="rlogfile"></td>
         </tr>
         <tr>
            <td>Folder</td>
            <td class="rfolder"></td>
         </tr>
         <tr>
            <td>Type</td>
            <td class="rtype"></td>
         </tr>
      </table>
   </div>
</div>


<div class="contentbg">

   <div class="breadcrumb">
      <div class="breadtext">&nbsp;</div>
   </div>

   <div class="container">
      <div class="content">
         <div><span style="float:left; font-size: 13px; text-decoration: underline;"><a href="../index.php">Back to Home</a></span></div>
		 
		 <div class="adtitle" align="center">
            Manage Partners
         </div>
         <form method="get" enctype="multipart/form-data">
            <div class="xbrlContainer">
               <div class="search_box">
                  {* <span style="float: left;font-size: 16px; position: relative; top: 7px; font-weight: bold; margin-right: 15px;">Search</span>
                  <div class="from_date_box">
                     <label id="req_answer[from_date]">From:</label>
                     <input type="text" id="from_date" size="26" name="req_answer[from_date]" class="req_from_date" forerror="date">		
                     <div style="clear: both;"></div>
                  </div>
                  <div class="to_date_box">
                     <label id="req_answer[to_date]">To:</label>
                     <input type="text" id="to_date" size="26" name="req_answer[to_date]" class="req_to_date" forerror="date">		
                     <div style="clear: both;"></div>
                  </div>
                  <span class="search_sep">or</span> *}
                  <div class="cin_box">
                     <label id="req_answer">Filter:</label>
                     <input type="text" id="req_answer" size="26" name="" class="req_cin" forerror="cin">		
                     <div style="clear: both;"></div>
                  </div>
                  <a style="float:right;padding: 8px;font-size: 16px;" href="partner-api-create.php" >Create Partner</a>
                  <!-- <div class="search_box_submit">
                     <a class="btn-submit" name="btn-log-submit" id="btn-log-submit">Submit</a>		
                     </div> -->
                  {* <span style="position: relative;top: 7px; left: 10px;"><a href="{$ADMIN_BASE_URL}mobile_api_tracker.php">Clear Search</a></span> *}
                  <div style="clear: both;"></div>
               </div>
               {* <label style=" font: bold 13px &quot;Courier New&quot;, Courier, monospace;  margin: 10px 10px; color: #000;  position: absolute;">http://162.214.29.33:3000/</label> *}
               <table class="maintable" id="partnersDetails">
                  <thead>
                     <tr>
                        <th >Name</th>
                        <th>Company</th>
                        <th>APIType</th>
                        <th>Type</th>
                        {* <th >Token</th> *}
                        <th >Validate From</th>
                        <th >Validate To</th>
                        <th >Deal Count</th>
                        <th >Company Count</th>
                        <th >Overall Count</th>
						{* <th >Status</th> *}
                         {* <th >Created At </th> *}
                        <th style="width:7%;">Action</th>
                     </tr>
                  </thead>
                  <tbody class="xbrl-row"></tbody>
               </table>
            </div>
            <br />	
         </form>
         {* 
         <div id="containerChart"></div>
         <div id="results"></div>
         *}
	</div>
    </div>
</div>