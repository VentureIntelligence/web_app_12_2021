<?php /* Smarty version 2.5.0, created on 2019-06-04 06:34:23
         compiled from admin/xbrlparse.tpl */ ?>
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
<?php echo '

<script>
	var run_id;
	$j = jQuery.noConflict();
	$j(document).ready(function(){
		$j( \'.addRow\' ).click( function() {
			var rowID = parseInt( $j( this ).attr( \'data-rowID\' ) );
			var curRowID = rowID + 1;

			var tempContent = \'<tr class="xbrl_\'+curRowID+\' xbrl-row"><td><input type="text" size="25" value="" name="req_answer[cin][]" id="req_answer[cin]" class="req_cin" /></td>\';
			tempContent += \'<td><select class="req_folder" name="req_answer[folder][]" id="req_answer[folder]"><option Value="N">Ind-as</option><option Value="O">In-gaap</option></select></td>\';
			tempContent += \'<td><select class="req_type" name="req_answer[type][]" id="req_answer[type]"><option Value="S">Standalone</option><option Value="C">Consolidated</option></select></td>\';
			tempContent += \'<td><span class="remove_row" onclick="removeRow(\'+curRowID+\');"></span></td></tr>\';

			/*var tempContent = \'<div class="xbrl_\'+curRowID+\' xbrl-row"><div class="col-3"><div><label id="req_answer[cin]">CIN:</label><input class="req_cin" type="text" size="25" value="" name="req_answer[cin][]" id="req_answer[cin]" style="margin-left:10px;" /></div></div>\';
			tempContent += \'<div class="col-2"><div><label id="req_answer[folder]">FOLDER:</label><select class="req_folder" name="req_answer[folder][]" id="req_answer[folder]" style="width: 70px;margin-left:10px;"><option Value="N">Ind-as</option><option Value="O">In-gaap</option></select></div></div>\';
			tempContent += \'<div class="col-2"><div><label id="req_answer[type]">TYPE:</label><select class="req_type" style="width: 150px;margin-left:10px;" name="req_answer[type][]" id="req_answer[type]"><option Value="S">Standalone</option><option Value="C">Consolidated</option></select></div></div><span class="remove_row" onclick="removeRow(\'+curRowID+\');">Remove</span><div style="clear: both;"></div></div>\';*/
			if( $j( \'.xbrl-row\' ).length <= 9 ) {
				$j( this ).attr( \'data-rowID\', curRowID );
				$j( \'.xbrl-row:last-child\' ).after( tempContent );	
			} else {
				alert( \'Only 10 companies allowed\' );
			}
			
		});

	});
	function removeRow( rowID ) {
		$j( \'.xbrl_\'+rowID ).remove();
	}
	$j(document).ready(function(){
		$j( \'.btn-submit\' ).click( function() {
			var form  =$j( \'#Frm_AddRating\' );
			if( $j( \'.req_cin[value=""]\' ).length > 0 ) {
				alert( \'please enter cin number\' );
				return false;	
			}
			if( $j( \'.req_folder[value=""]\' ).length > 0 ) {
				alert( \'please enter choose folder\' );
				return false;	
			}
			if( $j( \'.req_type[value=""]\' ).length > 0 ) {
				alert( \'please enter choose type\' );
				return false;	
			}
			run_id = $j( \'#run_id\' ).val();
			$j( \'.body-overlay \' ).show();
			$j.ajax({
				type: \'POST\',
				url: \'xbrlparse_ajx.php\',
				data: form.serialize(),
				success: function(response){
					$j( \'#run_id\' ).val( response );
		            checkErrorXBRL( run_id );  
		            $j( \'.body-overlay \' ).hide();
		        },
		        error: function(msg) {
		        	alert( msg.statusText );
		        	$j( \'.body-overlay \' ).hide();
		        }
			});
			return false;
			//$j( \'#Frm_AddRating\' ).submit();
		});
	});
	function checkErrorXBRL( run_id ) {
		$j.ajax({
			type: \'GET\',
			url: \'xbrlparse_ajx_get.php\',
			data: "run_id="+run_id,
			success: function( msg ) {
				$j( \'.log_link\' ).remove();
				var respData = JSON.parse( msg );
				respData.each(function(value,key){
					var dynaCont = \'<div class="err-fields">\';
					if( value.file_error > 0 ) {
						dynaCont += \'<span class="up-err"><a target="_blank" href="logs/\'+value.cin+\'/\'+value.log_file+\'.txt">File</a></span><span class="">-</span><span class="">-</span>\'
					} else {
						if( value.upload_error > 0 ) {
							dynaCont += \'<span class="up-err"><a target="_blank" href="logs/\'+value.cin+\'/\'+value.log_file+\'.txt">Upload</a></span>\';
						} else {
							dynaCont += \'<span class="up-err success">Upload</span>\';
						}
						if( value.is_error > 0 && value.start_upload == 1 ) {
							dynaCont += \'<span class="up-err"><a target="_blank" href="logs/\'+value.cin+\'/\'+value.log_file+\'.txt">Validation</a></span>\';
							if(value.isSHP == 1){
								dynaCont += \'<span class="up-err success " style="border-right:none;">SHP<span class="showdownload" style="background: url(../../images/gray_arrow.gif) no-repeat 40px;cursor: pointer;height: 18px;width: 26px;display: block;float: right;background-position: 0px;margin-top: -18px;margin-right: -30px;"></span></span>\';
							}
						} else if( value.start_upload == 1 ){
							dynaCont += \'<span class="up-err success">Validation</span>\';
							if(value.isSHP == 1){
								dynaCont += \'<span class="up-err success " style="border-right:none;">SHP<span class="showdownload" style="background: url(../../images/gray_arrow.gif) no-repeat 40px;cursor: pointer;height: 18px;width: 26px;display: block;float: right;background-position: 0px;margin-top: -18px;margin-right: -30px;"></span></span>\';
							}
						}
					}
					
					dynaCont += \'</div>\';
					$j( $j( $j( \'.req_cin[value="\'+value.cin+\'"]\' )[value.view_index] ).parents(\'.xbrl-row\').find(\'td:last\') ).find(\'.remove_row\').remove();
					$j( $j( $j( \'.req_cin[value="\'+value.cin+\'"]\' )[value.view_index] ).parents(\'.xbrl-row\').find(\'td:last\') ).find(\'.err-fields\').remove();
					$j( $j( $j( \'.req_cin[value="\'+value.cin+\'"]\' )[value.view_index] ).parents(\'.xbrl-row\').find(\'td:last\') ).append(dynaCont);
				});
			}
		});
	}

	$(document).on(\'click\',\'.showdownload\',function(){
		$j(\'#maskscreen\').fadeIn(1000);
		$j( \'#SHPexport-popup\' ).show();
	});

	$(document).on(\'click\',\'.getshp\',function(){
		
		$j.ajax({
			type: \'GET\',
			url: \'downloadSHP.php\',
			data: "run_id="+run_id,
			success: function( msg ) {
				console.log("Success");
				window.location.href = "downloadSHP.php?run_id="+run_id;
			}
		});
	});

	$( document ).on( \'click\', \'.close-lookup\', function() {
            $j( \'#SHPexport-popup\' ).hide();
            $j(\'#maskscreen\').fadeOut(1000);
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
/*.loader-text:after {
    content: "Loading...";
    position: absolute;
    top: 40%;
    left: 0;
    right: 0;
    text-align: center;
    display: table-cell;
}*/

.loader-text:after {
	content: "Processing...";
    position: absolute;
    top: 40%;
    left: 0;
    right: 0;
    text-align: center;
    display: table-cell;
    max-width: 390px;
    margin: auto;
    height: 120px;
    border-radius: 10px;
    background: #f9f9f9 url(../images/loading.gif);
    font-size: 0;
    background-position: 0;
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
    background: rgba(0, 0, 0, 0.07);
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
    background: url(../images/add.png) no-repeat;
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
    background: url(../images/delete.svg) no-repeat;
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
/*.err-fields {
    padding: 5px 0 0 0;
}

.err-fields > span a {
    color: #F10000;
    text-decoration: underline;
}

.up-err {
    padding-right: 10px;
    margin-right: 10px;
    border-right: 1px solid #ccc;
}
.err-fields > span.success {
    color: #008000;
}*/

.err-fields {
    padding: 5px 0 0 0;
}

.err-fields > span {
    /*text-decoration: underline;*/
    padding: 0px 10px;
    border-right: 1px solid #ccc;
}

.up-err a {
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
'; ?>

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
		<?php echo $this->_tpl_vars['ADMIN_BASE_URL']; ?>

		<div><span style="float:left; font-size: 13px; text-decoration: underline;"><a href="<?php echo @constant('ADMIN_BASE_URL'); ?>
index.php">Back to Home</a></span></div>
		<div class="adtitle" align="center">XBRL Automation<!-- <a style="float: right; font-size: 14px;" href="xbrl_log.php" target="_blank">View Log History</a> --></div>

<form name="Frm_AddRating" id="Frm_AddRating" action="xbrlparse_ajx.php" method="post" enctype="multipart/form-data">
	
	<div class="xbrlContainer">
		<input type="hidden" name="run_id" id="run_id" value="<?php echo $this->_tpl_vars['run_id']; ?>
" />
		<input type="hidden" name="isSHP" id="isSHP" value="<?php echo $this->_tpl_vars['isSHP']; ?>
" />
		<table>
			<thead>
				<tr>
					<th style="width: 300px;">
						CIN
					</th>
					<th style="width: 200px;">
						FOLDER
					</th>
					<th style="width: 215px;">
						TYPE
					</th>
					<th>
						ACTION
					</th>
				</tr>
			</thead>
			<tbody>
				<tr class="xbrl_1 xbrl-row">
					<td>

						<input type="text" size="25" value="" name="req_answer[cin][]" id="req_answer[cin]" class="req_cin" />
					</td>
					<td>
						<select class="req_folder" name="req_answer[folder][]" id="req_answer[folder]">
							<option Value="N">Ind-as</option>
							<option Value="O">In-gaap</option>
						</select>
					</td>
					<td>
						<select class="req_type" name="req_answer[type][]" id="req_answer[type]">
							<option Value="S">Standalone</option>
							<option Value="C">Consolidated</option>
						</select>
					</td>
					<td>
					</td>
				</tr>
			</tbody>
		</table>
		<!-- <div class="xbrl_1 xbrl-row">
			<div class="col-3">
				<div>
					<label id="req_answer[cin]">CIN:</label>
					<input type="text" size="25" value="" name="req_answer[cin][]" id="req_answer[cin]" class="req_cin" style="margin-left:10px;" />
				</div>
			</div>
			<div class="col-2">
				<div>
					<label id="req_answer[folder]">FOLDER:</label>
					<select style="width: 70px;margin-left:10px;" class="req_folder" name="req_answer[folder][]" id="req_answer[folder]">
						<option Value="N">Ind-as</option>
						<option Value="O">In-gaap</option>
					</select>
				</div>
			</div>
			<div class="col-2">
				<div>
					<label id="req_answer[type]">TYPE:</label>
					<select style="width: 150px;margin-left:10px;" class="req_type" name="req_answer[type][]" id="req_answer[type]">
						<option Value="S">Standalone</option>
						<option Value="C">Consolidated</option>
					</select>
				</div>
			</div>
			<div style="clear: both;"></div>
		</div> -->
	</div>
	<div>
		<a href="javascript:;" class="addRow" data-rowID="1">Add Row</a>
	</div>
		<br />
		<div style="clear: both;"></div>
		<div align="center">
			<a href="javascript:;" class="btn-submit">Submit</a>
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