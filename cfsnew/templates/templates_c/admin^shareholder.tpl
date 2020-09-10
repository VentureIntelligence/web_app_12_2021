<?php /* Smarty version 2.5.0, created on 2014-01-27 08:36:50
         compiled from admin/shareholder.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'admin/shareholder.tpl', 137, false),)); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("admin/header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
common.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
validator.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
jquery.js"></script>
<?php echo '
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
		<div class="adtitle" align="center">Add Shareholder</div>


<form name="Frm_AddShare" id="Frm_AddShare" action="" method="post" onSubmit="return ShareValidation('Frm_AddShare')" enctype="multipart/form-data">
<input type="hidden" name="AddShare" id="AddShare" value="AddShare" />
<input type="hidden" name="op" id="op" value="" />
		<div align="center">
			<label id="req_answer[CompanyId]">Company:</label>
					<select id="answer[CompanyId]" name="answer[CompanyId]"  class="req_value" forError="CompanyId">
						   <option value="" >Please Select a Company</option>
								<?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['companies']), $this) ; ?>

				 	</select>
		</div>
<br />
		<div align="center">
			<label id="req_answer[Title]">Title</label>
			  <select id="answer[Title]" name="answer[Title]" class="req_value" forError="Title">
					   <option value="" >Please Select</option>
						<?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['roundname']), $this) ; ?>

		 	  </select>
		</div>
<br />
		<br />
		<div align="center">
			<label id="req_answer[Name]">Name</label>
			  <input type="text" id="answer[Name]" size="26" name="answer[Name]" class="req_value" forError="Name"/>
		</div>
<br />

		<div align="center">
			<label id="req_answer[Type]">Type</label>
			  <input type="text" id="answer[Type]" size="26" name="answer[Type]" class="req_value" forError="Type"/>
		</div>
<br />
		<div align="center">
			<label id="req_answer[Noofshares]">Noofshares</label>
			  <input type="text" id="answer[Noofshares]" size="26" name="answer[Noofshares]" class="req_value" forError="Noofshares"/>
		</div>
<br />
		<div align="center">
			<label id="req_answer[Stake]">Stake</label>
			  <input type="text" id="answer[Stake]" size="26" name="answer[Stake]" class="req_value" forError="Stake"/>
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