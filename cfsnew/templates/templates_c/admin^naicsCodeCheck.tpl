<?php /* Smarty version 2.5.0, created on 2018-04-30 10:41:02
         compiled from admin/naicsCodeCheck.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'admin/naicsCodeCheck.tpl', 86, false),)); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("admin/header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
js/common.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
js/validator.js"></script>
<?php echo '
<style type="text/css">
/* CSS Document */
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
<div class="container">
	<div class="content">
        <div class="page-header">
        	<h1>NAICS Code Check</h1>
        </div>
        <form action="naicsCodeCheck.php" method="post" name="naics_form" id="naics_form">
        <div class="span12">
        	<div class="form-control">
        		<label for="com_industry">Select an Industry:</label><br/> <br/>
        		<select id="com_industry" name="com_industry"  class="req_value" forError="Industry">
					<option value="" >All</option>
					<?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['industries']), $this) ; ?>

			 	</select>
			 	&nbsp;&nbsp;<input type="submit" name="export_naics" id="export_naics" value="Export" />
        	</div>
        </div><br/><!-- 
        <table class="condensed-table">
	        <thead>
	          	<tr>
	            	<th width="10%">CIN</th>
	            	<th width="33%">Company Name</th>
	            	<th width="31%">Added Date </th>
	            	<th colspan="2">Actions</th>
	          	</tr>
	        </thead>
	        <tbody>

	        </tbody>
        </table> -->
  	</div>
</div>