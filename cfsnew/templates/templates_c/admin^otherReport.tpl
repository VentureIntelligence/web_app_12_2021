<?php /* Smarty version 2.5.0, created on 2018-08-30 06:02:40
         compiled from admin/otherReport.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include('admin/header.tpl', array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo $this->_tpl_vars['ADMIN_CSS_PATH']; ?>
home.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
common.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
validator.js"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-latest.min.js"></script>
<?php echo '
    

<script  type="text/javascript" language="javascript1.2">
function deleteReg(op,extra)
{	if (confirm("Are you sure you want to delete? ")) {
		
	document.addformspringform.op.value=op;
	document.addformspringform.extra.value=extra;
	document.addformspringform.submit();

    } else {
       document.addformspringform.op.value=op;
    }
}


</script>
<style>
    
    .condensed-table td,.condensed-table th{
        padding: 14px 2px;
    }
</style>
'; ?>

<body>
<form  method="post" name="addformspringform" id="addformspringform">
  <input type="hidden" name="op" />
  <input type="hidden" name="extra" />
  <input type="hidden" name="status" />
  <input type="hidden" name="edstatus" />
</form>
<div class="container">

      <div class="content">
        <div class="page-header">
          <h1>Other Report List </h1><a href="add_otherReport.php" style="float: right;margin-top: -34px;">Add Report</a>
        </div>
          
              
         
          <div class="row" style="clear:both; margin-top: 1%">
          <div style="margin-left: 2%;">
           
			<table class="condensed-table" >
        <thead>
          <tr>
            <th width="4%">ID</th>
            <th>Report Title</th>
            <th>Report Period </th>
            <th>Date </th>
            <th>Embed Code </th>
            <th>Definition</th>
            <th colspan="15%">Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (isset($this->_sections['i'])) unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($this->_tpl_vars['reportList']) ? count($this->_tpl_vars['reportList']) : max(0, (int)$this->_tpl_vars['reportList']);
$this->_sections['i']['show'] = true;
$this->_sections['i']['max'] = $this->_sections['i']['loop'];
$this->_sections['i']['step'] = 1;
$this->_sections['i']['start'] = $this->_sections['i']['step'] > 0 ? 0 : $this->_sections['i']['loop']-1;
if ($this->_sections['i']['show']) {
    $this->_sections['i']['total'] = $this->_sections['i']['loop'];
    if ($this->_sections['i']['total'] == 0)
        $this->_sections['i']['show'] = false;
} else
    $this->_sections['i']['total'] = 0;
if ($this->_sections['i']['show']):

            for ($this->_sections['i']['index'] = $this->_sections['i']['start'], $this->_sections['i']['iteration'] = 1;
                 $this->_sections['i']['iteration'] <= $this->_sections['i']['total'];
                 $this->_sections['i']['index'] += $this->_sections['i']['step'], $this->_sections['i']['iteration']++):
$this->_sections['i']['rownum'] = $this->_sections['i']['iteration'];
$this->_sections['i']['index_prev'] = $this->_sections['i']['index'] - $this->_sections['i']['step'];
$this->_sections['i']['index_next'] = $this->_sections['i']['index'] + $this->_sections['i']['step'];
$this->_sections['i']['first']      = ($this->_sections['i']['iteration'] == 1);
$this->_sections['i']['last']       = ($this->_sections['i']['iteration'] == $this->_sections['i']['total']);
?>
		  <tr>
            <td ><?php echo $this->_tpl_vars['reportList'][$this->_sections['i']['index']]['id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['reportList'][$this->_sections['i']['index']]['reportTitle']; ?>
</td>
            <td><?php echo $this->_tpl_vars['reportList'][$this->_sections['i']['index']]['reportPeriod']; ?>
</td>
            <td><?php echo $this->_tpl_vars['reportList'][$this->_sections['i']['index']]['date']; ?>
</td>
            <td><?php echo $this->_tpl_vars['reportList'][$this->_sections['i']['index']]['embedCode']; ?>
</td>
            <td><?php echo $this->_tpl_vars['reportList'][$this->_sections['i']['index']]['definition']; ?>
</td>
            <td width="3%" align="center">
                <a href="edit_otherReport.php?rid=<?php echo $this->_tpl_vars['reportList'][$this->_sections['i']['index']]['id']; ?>
"><img src="images/edit.png" width="16" height="16" title="Click to Edit" alt="Click to Edit" style="cursor:pointer;" /></a></td>
            <td width="3%"><img src="images/close.gif" width="16" height="16"  onClick="deleteReg('delete','<?php echo $this->_tpl_vars['reportList'][$this->_sections['i']['index']]['id']; ?>
');" alt="delete" title="delete"/></td>
			
          </tr>
		  <?php endfor; else: ?>
			<tr>
				<td colspan="">&nbsp;</td>
				<td colspan="3" align="center">No Data Found !</td>
				<td colspan="">&nbsp;</td>
			</tr>		  		  
		  <?php endif; ?>
	  
        </tbody>
      </table>
          </div>          
        </div>
      </div>

      <footer>
        <p>&copy; Company 2011</p>
      </footer>
    </div>
</body>