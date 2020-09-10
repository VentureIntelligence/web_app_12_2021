<?php /* Smarty version 2.5.0, created on 2014-11-07 05:00:30
         compiled from admin/deletePlstandard.tpl */ ?>
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
    
    <script type="text/javascript" language="javascript1.2">
jQuery.noConflict();

function suggest(inputString){
		jQuery(\'#submitbtn\').hide();
		jQuery(\'#viewfinance\').hide();
                jQuery(\'#suggestionsList\').show();               
                 
		if(inputString.length == 0) {
			jQuery(\'#suggestions\').fadeOut();
                        jQuery(\'#cid\').val(\'\');
		} else {
		jQuery(\'#country\').addClass(\'load\');
			jQuery.post("autosuggest.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					jQuery(\'#suggestions\').fadeIn();
					jQuery(\'#suggestionsList\').html(data);
					jQuery(\'#country\').removeClass(\'load\');
				}
			});
		}
}
	function fill(thisValue) {
		jQuery(\'#country\').val(thisValue);
		setTimeout("$(\'#suggestions\').fadeOut();", 300);
	}

	function fillHidden(thisid) {
		jQuery(\'#cid\').val(thisid);
		jQuery(\'#submitbtn\').show();
		jQuery(\'#suggestionsList\').hide();
		jQuery(\'.suggestionsBox\').hide();
	    jQuery(\'#viewfinance\').html(\'<a href="viewannual.php?vcid=\'+thisid+\'" target="_blank"><img src="images/cfs/vfinancial.jpg" style="width:87px; height:25px;" /></a>\');
		jQuery(\'#viewfinance\').show();
		setTimeout("$(\'#suggestions\').fadeOut();", 300);
	}
	
        
</script>

<script type="text/javascript" language="javascript1.2">
$j = jQuery.noConflict();
$j(document).ready(function(){
$j(".PLDFlip").click(function(){
    $j(".PLDPanel").slideToggle("slow");
  });
});
$j(document).ready(function(){
$j(".BSFlip").click(function(){
    $j(".BSPanel").slideToggle("slow");
  });
});
$j(document).ready(function(){
$j(".CFFlip").click(function(){
    $j(".CFPanel").slideToggle("slow");
  });
});
	label1 = document.getElementById(\'req_answer[CompanyId]\');
	label2 = document.getElementById(\'req_answer[PLStandard]\');
	label1.setAttribute("class","error");
	label2.setAttribute("class","error");

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
width:275px;
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
</style>
'; ?>

</head>
<div class="contentbg">
<div class="breadcrumb">
	<div class="content" style="padding-top:0px;">
	<div class="breadtext">&nbsp;</div>
	</div>
</div>
		<div class="adminbox">
		<div><?php echo $this->_tpl_vars['SuccessMsg']; ?>
</div>
		<div class="adtitle" align="center">Add Delete PL Standard</div>


<form name="Frm_AddRating" id="Frm_AddRating" action="" method="post" onSubmit="return RatingValidation('Frm_AddRating')" enctype="multipart/form-data">
<input type="hidden" name="AddRating" id="AddRating" value="AddRating" />
<input type="hidden" name="op" id="op" value="" />
		<div align="center">
			<label id="req_answer[CompanyId]">Company:</label>
					<!-- <select id="answer[CompanyId]" name="answer[CompanyId]"  class="req_value" forError="CompanyId">
						   <option value="" >Please Select a Company</option>
								
				 	</select> -->
                                             <div id="suggest">
				<input type="hidden" name="answer[CompanyId]" id="cid" value="" />
				<input type="text" size="25" value="" name="country" id="country" onkeyup="suggest(this.value);" onblur="fill();" class=""  autocomplete=off  style="height:24px;"/>&nbsp;&nbsp;
				<div class="suggestionsBox" id="suggestions" style="display: none;">
				  <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
				</div>
			</div>
		</div>
		<br />
		<div align="center">
			<input type="image" name="save_business"  src="images/submit.png" style="width:87px; height:25px;"/>
		</div><br />
<?php if ($this->_tpl_vars['AskConfirm']): ?>
<script type="text/javascript" language="javascript1.2">
	//upDateFinancial('YesConfirm');
</script>
<?php endif; ?>	
</form>

	</div>
</div>