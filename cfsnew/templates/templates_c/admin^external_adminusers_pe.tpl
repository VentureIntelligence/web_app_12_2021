<?php /* Smarty version 2.5.0, created on 2020-09-10 12:19:26
         compiled from admin/external_adminusers_pe.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include('admin/header.tpl', array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<link href="<?php echo @constant('BASE_URL'); ?>
cfs/css/demo_page.css" rel="stylesheet" type="text/css" media="screen"/>
<link href="<?php echo @constant('BASE_URL'); ?>
cfs/css/demo_table.css" rel="stylesheet" type="text/css" media="screen"/>
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
function deleteReg1(op1,extra1)
{	if (confirm("Are you sure you want to delete? ")) {
		
	document.addformspringform1.op1.value=op1;
	document.addformspringform1.extra1.value=extra1;
	document.addformspringform1.submit();

    } else {
       document.addformspringform1.op1.value=op;
    }
}

function ChangeStatus1(op1,status1,msg1)
{	if (confirm("Are you sure you want to "+msg1)) {
		
	document.addformspringform1.op1.value=op1;
	document.addformspringform1.status1.value=status1;
	document.addformspringform1.edstatus1.value=msg1;
	document.addformspringform1.submit();

    } else {
       document.addformspringform1.op1.value=op1;
    }
}
</script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.3.2/jquery.js"></script>
<script type="text/javascript" src="'; ?>
<?php echo @constant('BASE_URL'); ?>
<?php echo 'cfs/js/jquery.dataTables.js"></script>
<script type="text/javascript" src="'; ?>
<?php echo @constant('BASE_URL'); ?>
<?php echo 'cfs/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" language="javascript1.2">
	jQuery.noConflict();
	jQuery(document).ready(function() {
		jQuery(\'#example\').dataTable({
					"sPaginationType": "full_numbers"
				});
		
	})
</script>
'; ?>

<body>
<form  method="post" name="addformspringform" id="addformspringform">
  <input type="hidden" name="op" />
  <input type="hidden" name="extra" />
  <input type="hidden" name="status" />
  <input type="hidden" name="edstatus" />
</form>
<form  method="post" name="addformspringform1" id="addformspringform1">
  <input type="hidden" name="op1" />
  <input type="hidden" name="extra1" />
  <input type="hidden" name="status1" />
  <input type="hidden" name="edstatus1" />
</form>
<div class="container">

      <div class="content">
        <div class="page-header">
          <h1>External API User(s) - PE </h1>
        </div>
        <div class="row">
            
            <a href="external_add_adminuser_pe.php" style="float: right;margin:2% 0;font-weight: bold;font-size: 15px;">Add User</a> 
            
          <div>
           
		<table border="1" cellspacing="0" cellpadding="0" id="example1">
        <thead>
          <tr>
            <th width="8%">ID</th>
            <th width="26%">User Name</th>
		    <th width="26%">First Name</th>
			 <th width="30%">Added Date </th>
            <th width="10%">Action</th>
			
          </tr>
        </thead>
        <tbody>
          <?php if (isset($this->_sections['i'])) unset($this->_sections['i']);
$this->_sections['i']['name'] = 'i';
$this->_sections['i']['loop'] = is_array($this->_tpl_vars['AdminUserList']) ? count($this->_tpl_vars['AdminUserList']) : max(0, (int)$this->_tpl_vars['AdminUserList']);
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
            <td><?php echo $this->_tpl_vars['AdminUserList'][$this->_sections['i']['index']]['id']; ?>
</td>
            <td><?php echo $this->_tpl_vars['AdminUserList'][$this->_sections['i']['index']]['user_name']; ?>
</td>
		    <td><?php echo $this->_tpl_vars['AdminUserList'][$this->_sections['i']['index']]['first_name']; ?>
</td>
            <td><?php echo $this->_tpl_vars['AdminUserList'][$this->_sections['i']['index']]['created_on']; ?>
</td>
            <td width="10%" align="center"><a href="external_editadminusers_pe.php?auid=<?php echo $this->_tpl_vars['AdminUserList'][$this->_sections['i']['index']]['id']; ?>
"><img src="images/edit.png" width="16" height="16" title="Click to Edit" alt="Click to Edit" style="cursor:pointer;" /></a>
           <!-- <td width="3%"><img src="images/close.gif" width="16" height="16"  onClick="deleteReg('delete','<?php echo $this->_tpl_vars['AdminUserList'][$this->_sections['i']['index']]['Ident']; ?>
');" alt="delete" title="delete"/></td>-->
           <img src="images/delete.svg" width="16" height="16" alt="Click to Disable" title="Click to Delete"  onClick="deleteReg('delete','<?php echo $this->_tpl_vars['AdminUserList'][$this->_sections['i']['index']]['id']; ?>
');"  style="cursor:pointer; margin-left:10px;"/></td>
			
          </tr>
		  <?php endfor; endif; ?>
                  
                  
                  
                  
                  
                  
                   <tr>
  <td  colspan="8" style="color:#000000; padding-left:390px;padding-top:15px;" align="right">
		<?php if ($this->_tpl_vars['pages_New']['first'] == '0' && $this->_tpl_vars['pages_New']['next'] == '0'): ?>
<tr><td colspan="7">&nbsp;</td></tr>
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
	       </div> 
      <footer>
        <p>&copy; Company 2011</p>
      </footer>
    </div>
</body>