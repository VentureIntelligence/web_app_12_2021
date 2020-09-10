<?php /* Smarty version 2.5.0, created on 2019-06-04 06:34:27
         compiled from admin/xbrl_log.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("admin/header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo $this->_tpl_vars['ADMIN_CSS_PATH']; ?>
home.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
common.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
validator.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
jquery.js"></script>
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script type="text/javascript" src="<?php echo @constant('BASE_URL'); ?>
/cfsnew/admin/js/jquery.tablesorter.js"></script>

<?php echo '

<script>

	$j = jQuery.noConflict();
	$j(document).ready(function(){
		$j( \'.btn-submit\' ).click( function() {
			var form  =$j( \'#Frm_AddRating\' );
			var cinflag = false;
			var to_dateflag = false;
			var from_dateflag = false;
			if( $j( \'.req_cin[value=""]\' ).length > 0 ) {
				cinflag = true;	
			}
			if( $j( \'.req_to_date[value=""]]\' ).length > 0 || $j( \'.req_to_date\' ).val() == \'\' ) {
				to_dateflag = true;
			}
			if( $j( \'.req_from_date[value=""]]\' ).length > 0 || $j( \'.req_from_date\' ).val() == \'\' ) {
				from_dateflag = true
			}
			if( cinflag && to_dateflag && from_dateflag ) {
				alert( "Please choose from & to date or enter CIN" );
				return false;
			} else if( !from_dateflag && to_dateflag ) {
				alert( "Please choose to date" );
				return false;
			} else if( from_dateflag && !to_dateflag ) {
				alert( "Please choose from date" );
				return false;
			} else if( cinflag && ( to_dateflag && from_dateflag ) ) {
				alert( "Please enter cin" );
				return false;
			}
			$( \'#today_cin_container\' ).hide();
			$j( \'.body-overlay \' ).show();
			$j.ajax({
				type: \'POST\',
				url: \'xbrllog_ajx.php\',
				data: form.serialize(),
				success: function(response){
		           var content = \'\';
		           var uploadError = \'\';
		           var validationError = \'\';
		           var fileError = \'\';
		           var xml_type = \'\';
		           var excel_type = \'\';
		           var respData = JSON.parse( response );
		           if( respData != \'\' ) {
						respData.each(function(value,key){
							var excelFilePath = \'\';
							content += \'<tr class="row_\'+value.id+\'">\';
							var dateObject;
							dateObject = new Date(Date.parse(value.created_on));
							var dd = dateObject.getDate();
							var mm = dateObject.getMonth() + 1; 
							var yyyy = dateObject.getFullYear();
							var dateFormated = dd+\'-\'+mm+\'-\'+yyyy;
							var dateAMPM = formatAMPM(dateObject);
							if( value.log_file ) {
								content += \'<td>\'+dateFormated+\' \'+dateAMPM+\'</td><td data-cindetails="\'+value.cin+\'">\'+value.cin+\'</td><td data-logfile="\'+value.log_file+\'.txt"><a href="logs/\'+value.cin+\'/\'+value.log_file+\'.txt" target="_blank">\'+value.log_file+\'.txt</a></td>\';
							} else {
								content += \'<td>\'+dateFormated+\' \'+dateAMPM+\'</td><td data-cindetails="\'+value.cin+\'">\'+value.cin+\'</td data-logfile="-"><td>-</td>\';
							}
							if( value.file_error == 0 ) {
								content += \'<td><a href="'; ?>
<?php echo @constant('BASE_URL'); ?>
<?php echo 'cfsnew/details.php?vcid=\'+value.Company_Id+\'" target="_blank"><img width="15" src="../../images/export-icon1.png" /></a></td>\';
							} else {
								content += \'<td></td>\';
							}
							if( value.xml_type == \'N\' ) {
								xml_type = \'ind-as\';
							} else if( value.xml_type == \'O\' ) {
								xml_type = \'in-gapp\';
							} else {
								xml_type = \'-\';
							}
							if( value.excel_type == \'S\' ) {
								excel_type = \'Standalone\';
							} else if( value.excel_type == \'C\' ) {
								excel_type = \'Consolidated\';
							}
							content += \'<td data-xmltype="\'+xml_type+\'">\'+xml_type+\'</td>\';

							content += \'<td data-exceltype="\'+excel_type+\'">\'+excel_type+\'</td>\';
							content += \'<td>\';
							if( value.isSHP == 1) {
								content += \'<span style="padding: 0px;" class="showdownload" data-runid="\'+value.run_id+\'" ><img src="../images/success.png" class="isSHP " /></span>\';
							} else {
								content += \'<span style="padding: 0px;"><img src="../images/error.png" class="isSHP" /></span>\';
							}
							content += \'</td>\';
							if( value.is_error > 0 ) {
								validationError = \'up-err\';
							} else {
								validationError = \'success\';
							}
							if( value.upload_error > 0 ) {
								uploadError = \'up-err\';
							} else {
								uploadError = \'success\';
							}
							if( value.run_type == "1" ) {
								if( value.file_error > 0 ) {
									content += \'<td><div class="err-fields"><span class="up-err">File</span><span class="">-</span><span class="">-</span></</div></td>\';
								} else {
									content += \'<td><div class="err-fields"><span class="\'+uploadError+\'">Upload</span><span class="\'+validationError+\'">Validation</span></</div></td>\';
								}
							} else {
								content += \'<td>-</td>\';
							}
							
							content += \'<td>\';
							if( value.run_type == "1" || value.run_type == "2" ) {
								content += \'<a href="javascript:;" onclick="userpopup(\'+value.id+\');"><i data-runid="\'+value.run_id+\'" data-createdon="\'+value.created_on+\'" data-userfname="\'+value.user_name+\'"><img src="../images/info.png" width="16" height="16" /></i></a>\';
							} else {
								content += \'&nbsp;\';
							}
							content += \'</td></tr>\';
						});
					} else {
						content = \'<tr><td colspan="8">No records found</td></tr>\';
					}
					$j( \'.xbrl-row\' ).html( content );
					$j( \'.maintable\' ).show();
					$j("#check").tablesorter({
						headers: { 
				            1: { 
				                sorter: false 
				            }, 
				            2: { 
				                sorter: false 
				            },
				            3: { 
				                sorter: false 
				            },
				            4: { 
				                sorter: false 
				            },
				            5: { 
				                sorter: false 
				            },
				            6: { 
				                sorter: false 
				            },
				            7: { 
				                sorter: false 
				            } 
				        } 
					});
					$j( \'.body-overlay \' ).hide();
		        }
			});
			return false;
		});

		
	});
	function formatAMPM(date) {
	  	var hours = date.getHours();
	  	var minutes = date.getMinutes();
	  	var ampm = hours >= 12 ? \'pm\' : \'am\';
	  	hours = hours % 12;
	  	hours = hours ? hours : 12; // the hour \'0\' should be \'12\'
	  	minutes = minutes < 10 ? \'0\'+minutes : minutes;
	  	var strTime = hours + \':\' + minutes + \' \' + ampm;
	  	return strTime;
	}

	function userpopup( rowID ) {
		var rDate = $j($j(\'.row_\'+rowID).find(\'td\')).find(\'a i\').attr(\'data-createdon\');
		var dateData, dateObject, dateReadable;
		dateObject = new Date(Date.parse(rDate));
		dateReadable = dateObject.toDateString();
		var dateAMPM = formatAMPM(dateObject);
		var rCin = $j(\'.row_\'+rowID).find(\'td[data-cindetails]\').attr(\'data-cindetails\');
		var rLogid = $j(\'.row_\'+rowID).find(\'td[data-logfile]\').attr(\'data-logfile\');
		var rFolder = $j(\'.row_\'+rowID).find(\'td[data-xmltype]\').attr(\'data-xmltype\');
		var rType = $j(\'.row_\'+rowID).find(\'td[data-exceltype]\').attr(\'data-exceltype\');
		var rName  =$j($j(\'.row_\'+rowID).find(\'td\')).find(\'a i\').attr(\'data-userfname\');
		var rRunid  =$j($j(\'.row_\'+rowID).find(\'td\')).find(\'a i\').attr(\'data-runid\');
		var formdata = { "runid":rRunid};
		$j.ajax({
			type: \'POST\',
			url: \'xbrl2log_ajx.php\',
			data: formdata,
			success: function(response){
				var result = JSON.parse( response );
				if(result != \'\'){
					if(result[0].isXBRL == 1){
						$j( \'.rengine\' ).text( "XBRL2" );
					} else {
						$j( \'.rengine\' ).text( "XBRL1" );
					}
				} else {
					$j( \'.rengine\' ).text( "XBRL1" );
				}
			}
		});
		$j( \'.rdate\' ).text( dateReadable+\' \'+dateAMPM );
		$j( \'.rcin\' ).text( rCin );
		$j( \'.rlogfile\' ).text( rLogid );
		$j( \'.rfolder\' ).text( rFolder );
		$j( \'.rtype\' ).text( rType );
		$j( \'.rname\' ).text( rName ); 
		//$j( \'.rcin\' ).text( rCin );
		$j( \'.body-overlay2\' ).show();
	}
	function closeuserpopup( rowID ) {
		$j( \'.body-overlay2\' ).hide();	
	}
	
	
</script>
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
/* Hides from IE-mac \\*/
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
.isSHP {
    width: 16px;
    height: 22px;
    padding-left: 0px;
    vertical-align: bottom;
    display: inline-block;
    cursor: pointer;
}
#maskscreen {
    position: fixed;
    left: 0;
    top: 0;
    right: 0;
    bottom: 0;
    background: rgba(0,0,0,0.8);
    z-index: 8000;
    overflow: hidden;
    display: none;
}
.popup-box{position: fixed;z-index: 9000;left: 30%;top: 20%;background-color: #fff;}
.lookup-body {
    margin-bottom: 20px;
    padding: 10px;
    text-align: center;
}
.lookup-body a, .lookup-body a:hover, .lookup-body a:focus, .lookup-body a:visited {
    color: #fff;
    background: #7f6000;
    text-decoration: none;
    padding: 5px;
}
.lb { width:400px; border:1px solid #ccc; box-shadow:0 0 2px #eaeaea; overflow:hidden; margin: 0 auto; z-index: 9000;left: 40%;top: 25%;position: fixed;background-color: #fff;display: none;}
	.title { background:#bfa074; padding:5px 0 8px; color:#fff; text-align:center;}
	.entry { overflow:hidden; padding:10px; }
	.entry label { display:block; width:80px; color:#000; font-size:13px; margin-bottom:5px; font-weight:bold;}
	.entry input[type=\'text\'] { float:left; width:95%; padding:2px 5px; border:1px solid #ccc;}
	.entry p {color:#6C6C6C; font-size:13px; border: #ccc thin solid;padding: 5px;word-break: break-all;}
	.entry h5 { margin-bottom:3px; font-size:13px;}
	.entry input[type=\'button\'] { float:left; margin-right:10px;}
</style>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
var run_id;
	$( document ).ready( function() {
		var dateFormat = "dd-mm-yy",
	      	from = $( "#from_date" ).datepicker({
	          	//defaultDate: "+1w",
	          	changeMonth: true,
	          	maxDate: 0,
	          	dateFormat: "dd-mm-yy",
	         	//numberOfMonths: 3
	        }).on( "change", function() {
	          	to.datepicker( "option", "minDate", getDate( this ) );
	          	$( \'.req_cin\' ).val(\'\');
	        }),
	     	to = $( "#to_date" ).datepicker({
	        	//defaultDate: "+1w",
	       		changeMonth: true,
	       		maxDate: 0,
	       		dateFormat: "dd-mm-yy",
	        	//numberOfMonths: 3
	      	}).on( "change", function() {
	        	from.datepicker( "option", "maxDate", getDate( this ) );
	        	$( \'.req_cin\' ).val(\'\');
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
	    $( \'.req_cin\' ).on( \'keyup\', function() {
	    	$( \'#from_date\' ).val(\'\');
	    	$( \'#to_date\' ).val(\'\');
	    });

	    $( \'.trig_search\' ).click( function() {
	    	$( \'.req_cin\' ).val(\'\');
	    	var formdata = { "req_answer[cin]":$(this).data(\'cin\')};
	    	$( \'#today_cin_container\' ).hide();
	    	$j.ajax({
				type: \'POST\',
				url: \'xbrllog_ajx.php\',
				data: formdata,
				success: function(response){
					
		           var content = \'\';
		           var uploadError = \'\';
		           var validationError = \'\';
		           var xml_type = \'\';
		           var excel_type = \'\';
		           var respData = JSON.parse( response );
		           if( respData != \'\' ) {
						respData.each(function(value,key){
							var excelFilePath = \'\';
							content += \'<tr class="row_\'+value.id+\'">\';
							var dateObject;
							dateObject = new Date(Date.parse(value.created_on));
							var dd = dateObject.getDate();
							var mm = dateObject.getMonth() + 1; 
							var yyyy = dateObject.getFullYear();
							var dateFormated = dd+\'-\'+mm+\'-\'+yyyy;
							var dateAMPM = formatAMPM(dateObject);
							if( value.log_file ) {
								content += \'<td>\'+dateFormated+\' \'+dateAMPM+\'</td><td data-cindetails="\'+value.cin+\'">\'+value.cin+\'</td><td data-logfile="\'+value.log_file+\'.txt"><a href="logs/\'+value.cin+\'/\'+value.log_file+\'.txt" target="_blank">\'+value.log_file+\'.txt</a></td>\';
							} else {
								content += \'<td>\'+dateFormated+\' \'+dateAMPM+\'</td><td data-cindetails="\'+value.cin+\'">\'+value.cin+\'</td><td data-logfile="-">-</td>\';
							}
							if( value.file_error == 0 ) {
								content += \'<td><a href="'; ?>
<?php echo @constant('BASE_URL'); ?>
<?php echo 'cfsnew/details.php?vcid=\'+value.Company_Id+\'" target="_blank"><img width="15" src="../../images/export-icon1.png" /></a></td>\';
							} else {
								content += \'<td></td>\';
							}
							if( value.xml_type == \'N\' ) {
								xml_type = \'ind-as\';
							} else if( value.xml_type == \'O\' ) {
								xml_type = \'in-gapp\';
							} else {
								xml_type = \'-\';
							}
							if( value.excel_type == \'S\' ) {
								excel_type = \'Standalone\';
							} else if( value.excel_type == \'C\' ) {
								excel_type = \'Consolidated\';
							}
							content += \'<td data-xmltype="\'+xml_type+\'">\'+xml_type+\'</td>\';

							content += \'<td data-exceltype="\'+excel_type+\'">\'+excel_type+\'</td>\';
							content += \'<td>\';
							if( value.isSHP == 1) {
								content += \'<span style="padding: 0px;" class="showdownload" data-runid="\'+value.run_id+\'" ><img src="../images/success.png" class="isSHP " /></span>\';
							} else {
								content += \'<span style="padding: 0px;"><img src="../images/error.png" class="isSHP" /></span>\';
							}
							content += \'</td>\';
							if( value.is_error > 0 ) {
								validationError = \'up-err\';
							} else {
								validationError = \'success\';
							}
							if( value.upload_error > 0 ) {
								uploadError = \'up-err\';
							} else {
								uploadError = \'success\';
							}
							if( value.run_type == 1 ) {
								if( value.file_error > 0 ) {
									content += \'<td><div class="err-fields"><span class="up-err">File</span><span class="">-</span><span class="">-</span></</div></td>\';
								} else {
									content += \'<td><div class="err-fields"><span class="\'+uploadError+\'">Upload</span><span class="\'+validationError+\'">Validation</span></</div></td>\';
								}
							} else {
								content += \'<td>-</td>\';
							}
							
							content += \'<td>\';
							if( value.run_type == "1" || value.run_type == "2" ) {
								content += \'<a href="javascript:;" onclick="userpopup(\'+value.id+\');"><i data-runid="\'+value.run_id+\'" data-createdon="\'+value.created_on+\'" data-userfname="\'+value.user_name+\'"><img src="../images/info.png" width="16" height="16" /></i></a>\';
							} else {
								content += \'&nbsp;\';
							}
							content += \'</td></tr>\';
						});
					} else {
						content = \'<tr><td colspan="8">No records found</td></tr>\';
					}
					$j( \'.xbrl-row\' ).html( content );
					$j( \'.maintable\' ).show();
					$j("#check").tablesorter({
						headers: { 
				            1: { 
				                sorter: false 
				            }, 
				            2: { 
				                sorter: false 
				            },
				            3: { 
				                sorter: false 
				            },
				            4: { 
				                sorter: false 
				            },
				            5: { 
				                sorter: false 
				            },
				            6: { 
				                sorter: false 
				            },
				            7: { 
				                sorter: false 
				            }
				        } 
					});
					$j( \'.body-overlay \' ).hide();
		        }
			});
	    })
	});

	$(document).on(\'click\',\'.showdownload\',function(){
		run_id = $j(this).attr(\'data-runid\');
		//alert($j(this).attr(\'data-runid\'));
		$j(\'#maskscreen\').fadeIn(1000);
		$j( \'#SHPexport-popup\' ).show();
	});

	$(document).on(\'click\',\'.getshp\',function(){
		
		$j.ajax({
			type: \'GET\',
			url: \'downloadSHP.php\',
			data: "run_id="+run_id,
			success: function( msg ) {
				//console.log("Success");
				window.location.href = "downloadSHP.php?run_id="+run_id;
				$j( \'#SHPexport-popup\' ).hide();
				$j(\'#maskscreen\').fadeOut(1000);
			}
		});
	});

	$( document ).on( \'click\', \'.close-lookup\', function() {
            $j( \'#SHPexport-popup\' ).hide();
            $j(\'#maskscreen\').fadeOut(1000);
        });
</script>
'; ?>

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
			<tr>
				<td>Engine</td>
				<td class="rengine"></td>
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
		<div><span style="float:left; font-size: 13px; text-decoration: underline;"><a href="<?php echo @constant('ADMIN_BASE_URL'); ?>
index.php">Back to Home</a></span></div>
		<div class="adtitle" align="center">
			XBRL LOG
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
				<label id="req_answer[cin]">CIN:</label>
				<input type="text" id="req_answer[cin]" size="26" name="req_answer[cin]" class="req_cin" forerror="cin">		
				<div style="clear: both;"></div>
			</div>
			<div class="search_box_submit">
				<a class="btn-submit" name="btn-log-submit" id="btn-log-submit">Submit</a>		
			</div>
			<span style="position: relative;top: 7px; left: 10px;"><a href="<?php echo $this->_tpl_vars['ADMIN_BASE_URL']; ?>
xbrl_log.php">Clear Search</a></span>
			<div style="clear: both;"></div>
		</div>
		<div id="today_cin_container">
			<h3>Today processed CIN's</h3>
			<?php if (! empty ( $this->_tpl_vars['today_run'] )): ?>
			<div>
				<ul >
				<?php if (count((array)$this->_tpl_vars['today_run'])):
    foreach ((array)$this->_tpl_vars['today_run'] as $this->_tpl_vars['foo']):
?>
				    <li><a href="javascript:;" data-cin="<?php echo $this->_tpl_vars['foo']['cin']; ?>
" class="trig_search"><?php echo $this->_tpl_vars['foo']['cin']; ?>
</a></li>
				<?php endforeach; endif; ?>
				</ul>
			</div>
			<?php else: ?>
				<p>No CIN processed today</p>
			<?php endif; ?>
		</div>
		<table class="maintable" id="check" style="display: none;">
			<thead>
				<tr>
					<th style="width: 360px;">
						Date
					</th>
					<th style="width: 300px;">
						CIN
					</th>
					<th style="width: 300px;">
						Log File
					</th>
					<th style="width: 300px;">
						Excel
					</th>
					<th style="width: 300px;">
						Folder
					</th>
					<th style="width: 250px;">
						Type
					</th>
					<th style="width: 250px;">
						SHP
					</th>
					<th>
						Status
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

<div id="maskscreen"></div>
<div class="lb" id="SHPexport-popup" style="width: 650px; overflow: visible; left: 50%; top: 50%; transform: translate(-50%, -50%);">
  <span class="close-lookup" style="position: relative; background: #ec4444; font-size: 26px; padding: 0px 5px 5px 6px; z-index: 9022; color: #fff; font-weight: bold; cursor: pointer; float:right;">&times;</span>
  <div class="lookup-body" style="margin-bottom: 5px; padding: 15px;">
      You are about to download SHP Data for this company. <br> <br> &copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.<br/><br/>
      <b><a href="javascript:;" class="agree-plexport getshp">I Agree</a></b><!-- <b><a href="javascript:;" class="close-lookup">Cancel</a></b> --> 
  </div>
</div>