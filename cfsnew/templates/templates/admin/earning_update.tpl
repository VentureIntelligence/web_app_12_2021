{include file="admin/header.tpl"}
<link href="{$ADMIN_CSS_PATH}home.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}jquery.js"></script>
{literal}

<script>
	$j = jQuery.noConflict();
	$j(document).ready(function(){
		$j( '#btn-log-submit' ).click( function() {
			var form  =$j( '#Frm_AddRating' );
			if( $j( '.req_cin[value=""]' ).length > 0 ) {
				alert( 'please enter cin number' );
				return false;	
			}
			$j( '.body-overlay ' ).show();
			$j.ajax({
				type: 'POST',
				url: 'earningupdate_ajx.php',
				data: form.serialize(),
				success: function(response){
		           	var content = '';
		           	var uploadError = '';
		           	var validationError = '';
		           	var respData = JSON.parse( response );
		           	$j( '.company_name' ).text( respData.company_fname );
		           	$j( '#company_cid' ).val( respData.company_id );
		           	$j( '#result_type' ).val( respData.ResultType )
		           	if( respData.Earnings.length != 0 ) {
		           		respData.Earnings.each(function(value,key){
		           			var outgoContent = '';
		           			var earningContent = '';
		           			var outgoAttr = '';
		           			var earningAttr = '';
		           			if( value.BINR > 0 || value.BINR < 0 ) {
		           				outgoContent = '<span class="edit_outgoearning">Edit</span>';
		           				outgoAttr = 'readonly';
		           			}
		           			if( value.DINR > 0 || value.DINR < 0 ) {
		           				earningContent = '<span class="edit_outgoearning">Edit</span>';
		           				earningAttr = 'readonly';
		           			}
		           			content += '<tr><td>'+value.FY+'<input type="hidden" name="fy[]" value="'+value.FY+'" /></td><td class="forex_in_box"><input type="text" name="binr[]" class="binr" value="'+value.BINR+'" '+outgoAttr+' />'+outgoContent+'</td><td class="forex_in_box"><input type="text" name="dinr[]" class="dinr" value="'+value.DINR+'" '+earningAttr+' />'+earningContent+'</td></tr>';
						});
		           	} else {
		           		content += '<tr><td colspan="3">No plstd data found</td></tr>';
		           	}
		           	$j( '.maintable' ).show();
					$j( '.xbrl-row' ).html( content );
					$j( '.body-overlay ' ).hide();
		        }
			});
			return false;
		});
		$j( '#btn-forex-submit' ).click(function() {
			var checkFlag = true;
			var form  =$j( '#Frm_AddForex' );
			if( $j( '.binr[value=""]' ).length > 0 ) {
				alert( 'please enter BINR value' );
				checkFlag = false;
				return false;	
			} else if( $j( '.dinr[value=""]' ).length > 0 ) {
				alert( 'please enter DINR value' );
				checkFlag = false;
				return false;	
			}

			$j('input[name="binr[]"]').each(function() { 
				var aValue = $j(this).val();
				if( isNaN(aValue) ) {
					alert( 'Only integer allowed in BINR' );
					checkFlag = false;
					return false;	
				}
			});
			$j('input[name="dinr[]"]').each(function() { 
				var bValue = $j(this).val();
				if( isNaN(bValue) ) {
					alert( 'Only integer allowed in DINR' );
					checkFlag = false;
					return false;	
				}
			});
			if( checkFlag ) {
				var r = confirm("Do you wan to update the Earnings value!");
				if ( r == true ) {
					$j( '.body-overlay ' ).show();
				   $j.ajax({
						type: 'POST',
						url: 'earningsupdateval_ajx.php',
						data: form.serialize(),
						success: function(response){
							$j( '.body-overlay ' ).hide();
				           alert( 'Earnings updated successfully' );
				           location.reload();
				        }
					}); 
				} else {
				    txt = "You pressed Cancel!";
				}
			}
		});
	});
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
float: none;
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

.body-overlay {
    background: rgba(0,0,0,0.5);
    display: none;
    position: absolute;
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
    color: #F10000;
    /*text-decoration: underline;*/
    margin-left: 10px;
}

.up-err {
    padding-right: 10px;
}
.err-fields > span.success {
    color: #008000;
}
.err-fields > span:first-child {
    padding-right: 10px;
    border-right: 1px solid #ccc;
    margin-left: 0px;
}
.fy_loop {
	padding: 0px;
	margin: 0px;
}
.fy_loop li { margin: 10px 0px; }
.fy_loop li label {
	margin-right: 10px;
}

.xbrl-row .forex_in_box input {
	width: 100px;
}

.xbrl-row .forex_in_box input[disabled],
.xbrl-row .forex_in_box input[readonly] {
	background-color: #ececec;
}


.edit_outgoearning,
.cancel_outgoearning {
    position: relative;
    display: inline-block;
    font-size: 0;
    margin: 5px 10px;
    vertical-align: top;
    cursor: pointer;
}
.edit_outgoearning:before,
.cancel_outgoearning:before {
    content: "";
    background: url(../images/edit1.png) no-repeat;
    padding: 8px;
    width: 26px;
    height: 26px;
    background-size: 100%;
}
.cancel_outgoearning:before {
	background-image: url(../images/close1.png);
}

.filter_container {
	background: #eaeaea; padding: 13px 10px 10px 10px; text-align: center;
}

.filter_container form {
	margin-bottom: 0px;
}

.filter_container .filter_box {
	margin: 0 auto;
	width: 60%;
}


</style>
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script type="text/javascript">
	$( document ).ready( function() {
		$( '.xbrl-row' ).on( 'click', '.edit_outgoearning', function() {
			$(this).prev('input').removeAttr('readonly');
			$( this ).removeClass( 'edit_outgoearning' ).addClass('cancel_outgoearning').text( 'Cancel' );
		});
		$( '.xbrl-row' ).on( 'click', '.cancel_outgoearning', function() {
			$(this).prev('input').attr('readonly','readonly');
			$( this ).removeClass( 'cancel_outgoearning' ).addClass('edit_outgoearning').text( 'Edit' );
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
		<div class="adtitle" align="center">EARNINGS UPDATE</div>


	
	<div class="xbrlContainer">
		<div class="filter_container" style="">
			<div class="filter_box">
				<form name="Frm_AddRating" id="Frm_AddRating" action="forexupdate_ajx.php" method="post" enctype="multipart/form-data">
					<div style="float: left;">
						<label style="width: 50px;" id="req_answer[cin]">CIN:</label>
						<input style="width: 180px;" type="text" id="req_answer[cin]" size="26" name="req_answer[cin]" class="req_cin" forerror="cin">		
					</div>
					<div  style="float: left; position: relative; top: 4px; left: 5px; margin-right: 5px;">
						<input type="radio" style="box-shadow: 0 0 0 !important;" name="req_answer[file_type]" value="0" checked="" /> Satandalone
						<input type="radio" style="box-shadow: 0 0 0 !important;" name="req_answer[file_type]" value="1" /> Consolidated
					</div>
					<span style="position: relative; top: -2px;"><a class="btn-submit" name="btn-log-submit" id="btn-log-submit">Check</a></span>
				</form>
			</div>
			<div style="clear: both;"></div>
		</div>
		<div class="maintable" style="display: none; margin-top:10px; text-align: center">
			<div style="text-align:center">
				<h3 class="company_name"></h3>
			</div>
			<form name="Frm_AddForex" id="Frm_AddForex" action="forexformupdate_ajx.php" method="post" enctype="multipart/form-data">
				<input type="hidden" name="company_cid" id="company_cid" />
				<input type="hidden" name="result_type" id="result_type" />
				<div style="width:60%; margin: 0 auto;">
				<table>
					<thead>
						<tr>
							<th style="width: 50px;">
								FY
							</th>
							<th style="width: 180px;">
								BINR
							</th>
							<th style="width: 180px;">
								DINR
							</th>
						</tr>
					</thead>
					<tbody class="xbrl-row"></tbody>
				</table>
				</div>
				<a class="btn-submit" name="btn-forex-submit" id="btn-forex-submit">Update</a>
			</form>
		</div>
	</div>
		<br />	
	</div>
	</div>
</div>