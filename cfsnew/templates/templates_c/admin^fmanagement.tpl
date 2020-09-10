<?php /* Smarty version 2.5.0, created on 2013-11-12 01:59:35
         compiled from admin/fmanagement.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include('admin/header.tpl', array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
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

function ChangeStatus(op,status,msg)
{	if (confirm("Are you sure you want to "+msg)) {
		
	document.addformspringform.op.value=op;
	document.addformspringform.status.value=status;
	document.addformspringform.edstatus.value=msg;
	document.addformspringform.submit();

    } else {
       document.addformspringform.op.value=op;
    }
}

</script>
'; ?>

<body>
<form  method="post" name="addformspringform" id="addformspringform">
  <input type="hidden" name="op" />
  <input type="hidden" name="extra" />
  <input type="hidden" name="status" />
  <input type="hidden" name="edstatus" />

<div class="container">

      <div class="content">
        <div class="page-header">
          <h1>Company Financials</h1><a href="addcfinancials.php">Add Company Financials</a>
          <div style="margin-left:20px;float: right;"> Show Records Per Page:
              <select id="rowperpage" name="rowperpage" onchange="document.forms['addformspringform'].submit();" style="width: 60px;height: 22px;">
                    <option value="10" <?php if ($this->_tpl_vars['rowperpage'] == '10'): ?>SELECTED<?php endif; ?>>10</option>
                    <option value="20" <?php if ($this->_tpl_vars['rowperpage'] == '20'): ?>SELECTED<?php endif; ?>>20</option>
                    <option value="30" <?php if ($this->_tpl_vars['rowperpage'] == '30'): ?>SELECTED<?php endif; ?>>30</option>
                    <option value="40" <?php if ($this->_tpl_vars['rowperpage'] == '40'): ?>SELECTED<?php endif; ?>>40</option>
                    <option value="50" <?php if ($this->_tpl_vars['rowperpage'] == '50'): ?>SELECTED<?php endif; ?>>50</option>
            </select>
          </div>
        </div>
             <div id="alphaPagination">
                        <?php if (isset($this->_sections['i'])) unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($this->_tpl_vars['alphaletter']) ? count($this->_tpl_vars['alphaletter']) : max(0, (int)$this->_tpl_vars['alphaletter']);
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
                                <a href="fmanagement.php?pag=<?php echo $this->_tpl_vars['alphaletter'][$this->_sections['i']['index']]; ?>
"><?php echo $this->_tpl_vars['alphaletter'][$this->_sections['i']['index']]; ?>
</a>	
                        <?php endfor; endif; ?>
             </div><br>
        <div class="row">
          <div class="span10">
           
			<table class="condensed-table">
        <thead>
          <tr>
            <th width="10%">ID</th>
            <th width="60%">Company Name</th>
			<th width="12%">F.Year</th>
            <th width="31%">Added Date </th>
           <!-- <th colspan="2">Actions</th>-->
          </tr>
        </thead>
        <tbody>
          <?php if (isset($this->_sections['i'])) unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($this->_tpl_vars['FinancialList']) ? count($this->_tpl_vars['FinancialList']) : max(0, (int)$this->_tpl_vars['FinancialList']);
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
            <th><?php echo $this->_tpl_vars['FinancialList'][$this->_sections['i']['index']]['PLStandard_Id']; ?>
</th>
            <td><?php echo $this->_tpl_vars['FinancialList'][$this->_sections['i']['index']]['SCompanyName']; ?>
</td>
			<td><?php echo $this->_tpl_vars['FinancialList'][$this->_sections['i']['index']]['FY']; ?>
</td>
            <td><?php echo $this->_tpl_vars['FinancialList'][$this->_sections['i']['index']]['Added_Date']; ?>
</td>
           <!-- <td width="3%" align="center"><a href="edituser.php?uid=<?php echo $this->_tpl_vars['FinancialList'][$this->_sections['i']['index']]['user_id']; ?>
"><img src="images/edit.png" width="16" height="16" title="Click to Edit" alt="Click to Edit" style="cursor:pointer;" /></a></td>-->
            <!--<td width="3%"><img src="images/close.gif" width="16" height="16"  onClick="deleteReg('delete','<?php echo $this->_tpl_vars['FinancialList'][$this->_sections['i']['index']]['PLStandard_Id']; ?>
');" alt="delete" title="delete" style="cursor:pointer;"/></td>-->
			<td width="3%">
		<?php if ($this->_tpl_vars['FinancialList'][$this->_sections['i']['index']]['usr_flag'] == '1'): ?>
			<!--<img src="images/enable.png" width="16" height="16" alt="Click to Disable" title="Click to Disable"  onClick="ChangeStatus('changestatus','<?php echo $this->_tpl_vars['FinancialList'][$this->_sections['i']['index']]['user_id']; ?>
','Disable');"  style="cursor:pointer;"/>-->
		<?php else: ?>
			<!--<img src="images/disable.png"  width="16" height="16" alt="Click to Enable" title="Click to Enable"  onClick="ChangeStatus('changestatus','<?php echo $this->_tpl_vars['FinancialList'][$this->_sections['i']['index']]['user_id']; ?>
','Enable');"  style="cursor:pointer;"/>-->
		<?php endif; ?>	
			</td>
          </tr>
		  <?php endfor; else: ?>
			<tr>
				<td colspan="">&nbsp;</td>
				<td colspan="3" align="center">No Data Found !</td>
				<td colspan="">&nbsp;</td>
			</tr>		  		  
		  <?php endif; ?>
  <tr>
  <td  colspan="8" style="color:#000000; padding-left:380px;padding-top:15px;" align="right">
		<?php if ($this->_tpl_vars['pages_New']['first'] == '0' && $this->_tpl_vars['pages_New']['next'] == '0'): ?>

		<?php else: ?>

		<?php if ($this->_tpl_vars['pages_New']['first']): ?><a href="<?php echo $this->_tpl_vars['pages_New']['link']; ?>
<?php echo $this->_tpl_vars['pages_New']['first']; ?>
" style="color:#000000;" >first</a><?php else: ?>first&nbsp;<?php endif; ?> |

		<?php if ($this->_tpl_vars['pages_New']['first']): ?><a href="<?php echo $this->_tpl_vars['pages_New']['link']; ?>
<?php echo $this->_tpl_vars['pages_New']['previous']; ?>
" style="color:#000000;">&lt; previous</a><?php else: ?> &lt;   
		previous<?php endif; ?> |

		<?php if ($this->_tpl_vars['pages_New']['next']): ?><a href="<?php echo $this->_tpl_vars['pages_New']['link']; ?>
<?php echo $this->_tpl_vars['pages_New']['next']; ?>
" style="color:#000000;">next &gt;</a><?php else: ?> next &gt;&nbsp;	<?php endif; ?> |

		<?php if ($this->_tpl_vars['pages_New']['last']): ?><a href="<?php echo $this->_tpl_vars['pages_New']['link']; ?>
<?php echo $this->_tpl_vars['pages_New']['last']; ?>
" style="color:#000000;">last</a><?php else: ?>&nbsp;last<?php endif; ?>

		<?php endif; ?>

</td></tr>	  
        </tbody>
      </table>
          </div>          
        </div>
      </div>

      <footer>
        <p>&copy; Company 2011</p>
      </footer>
    </div>
  </form>
</body>