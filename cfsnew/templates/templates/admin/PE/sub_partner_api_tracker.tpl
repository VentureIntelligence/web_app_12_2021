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
#partnerApi_filter{
    display:none;
}
#partnerApi_length{
    float:right;
}
.dataTables_length select{
    width:60px !important;
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
	var partnerapi = {$apitrackinglist};
    console.log(partnerapi);
 {literal} 
$( document ).ready( function() {
        

			  $.fn.dataTable.ext.search.push(
					function (settings, data, dataIndex) {
					//var min = $('#from_date').datepicker("getDate");
					//var max = $('#to_date').datepicker("getDate");
					var endTime = $('#to_date').val();
					var min = $('#from_date').val();
                    
					if(endTime == '') {
						var max = endTime;
					}else {
						var max = endTime +'23:59:59';
					}
					
					var startDate = data[5];
					if (min == '' && max == '') { return true; }
					if (min == '' && startDate <= max) { return true;}
					if(max == '' && startDate >= min) {return true;}
					if (startDate <= max && startDate >= min) { return true; }
					return false;
			});
			var table;
			recreateTable();

			function recreateTable() {
				 table = $('#partnerApi').DataTable({
				"autoWidth": true,
                "order": [[ 4, "desc" ]],
				 data: partnerapi,
				"ordering": true,
				"columns": [
					{ "data": "apiName" },
					{ "data": "user" },
					{ "data": "companyName" },
					{ "data": "createdAt",
                        render: function(data, type, full) {
                            if (data != '')
                                return moment(new Date(data)).locale('el').format('DD/MM/YYYY HH:mm:ss');
                            else
                                return "No-Date";             
                            } 
                     },
                    { "data": "createdAt",
                        render: function(data, type, full) {
                            if (data != '')
                                return data;
                            else
                                return "No-Date";             
                        } 
                    }
				],
                "columnDefs": [
                    {
                         "targets": 3,
                         "orderData": 4
                     },
                     {
                         "targets": 4,
                         "visible": false
                     }
                ]
				});		
			}		
		$('#from_date, #to_date').on('change',function () {
						table.clear().destroy();
						$(".req_answer").val('');
						recreateTable();
		                table.draw();
		});

		var dateFormat = "yy-mm-dd",
	      	from = $( "#from_date" ).datepicker({
	          	//defaultDate: "+1w",
	          	changeMonth: true,
	          	maxDate: 0,
	          	dateFormat: "yy-mm-dd ",
	         	//numberOfMonths: 3
	        }).on( "change", function() {
	          	to.datepicker( "option", "minDate", getDate( this ) );
	          	$( '.req_cin' ).val('');
	        }),
	     	to = $( "#to_date" ).datepicker({
	       		changeMonth: true,
	       		maxDate: 0,
	       		dateFormat: "yy-mm-dd",
	        	//numberOfMonths: 3
	      	}).on( "change", function() {
	        	from.datepicker( "option", "maxDate", getDate( this ) );
	        	$( '.req_cin' ).val('');
	      	});
	 
	    	function getDate( element ) {
                var date;
	      		try {
	        		date = $.datepicker.parseDate( dateFormat, element.value );
                   
	      		} catch( error ) {
	        		date = null;
	      		}
	      		return date;
			}

			$('.req_cin').on( 'keyup', function() {
				$( '#from_date' ).val('');
				$( '#to_date' ).val('');
			});

			$('.req_cin').keyup(function() {
				var searchfilter =$('.req_cin').val();
				 var table = $('#partnerApi').DataTable();
				 var filtered = table.search(searchfilter).column().data().draw();
			  });

			   
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
            PE - SUB - Partner API TRACKING
         </div>
         <form name="Frm_AddRating" id="Frm_AddRating" action="xbrlparse_ajx.php" method="post" enctype="multipart/form-data">
            <div class="xbrlContainer">
               <div class="search_box">
                  <span style="float: left;font-size: 16px; position: relative; top: 7px; font-weight: bold; margin-right: 15px;">Search</span>
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
                  <span class="search_sep">or</span>
                  <div class="cin_box">
                     <label id="req_answer">Filter:</label>
                     <input type="text" id="req_answer" size="26" name="" class="req_cin" forerror="cin">		
                     <div style="clear: both;"></div>
                  </div>
                  <!-- <div class="search_box_submit">
                     <a class="btn-submit" name="btn-log-submit" id="btn-log-submit">Submit</a>		
                     </div> -->
                  <span style="position: relative;top: 7px; left: 10px;"><a href="{$ADMIN_BASE_URL}partner-api-tracker.php">Clear Search</a></span>
                  <div style="clear: both;"></div>
               </div>
               <label style=" font: bold 13px &quot;Courier New&quot;, Courier, monospace;  margin: 10px 10px; color: #000;  position: absolute;">API URL https://api.vionweb.com/partnersubapi/pe/</label>
               <table class="maintable" id="partnerApi">
                  <thead>
                     <tr>
                        <th >
                           API Name
                        </th>
                        <th >
                           User
                        </th>
                        <th >
                           Company Name
                        </th>
                        <th>
                           Created Date
                        </th>
                        <th>
                           Created Date
                        </th>
                     </tr>
                  </thead>
                  <tbody class="xbrl-row"></tbody>
               </table>
            </div>
            <br />	
         </form>
      </div>
   </div>
</div>