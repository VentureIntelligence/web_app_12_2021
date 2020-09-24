<?php /* Smarty version 2.5.0, created on 2020-09-24 10:49:43
         compiled from ajaxchargesholderlist_suggest.tpl */ ?>

<form method="post" id="Frm_HmeSearch1" action="companylist_suggest.php">
                      <input type="hidden" name="holderhiddenval" class="holderhiddenval" value='<?php echo $this->_tpl_vars['ChargesholderName']; ?>
'>
</form>
<table width="100%" border="0" cellspacing="0" cellpadding="0">

  <thead> 
    <tr>
      <th  class="sorthead <?php if ($this->_tpl_vars['sortby'] == 'sortcompany'): ?> <?php echo $this->_tpl_vars['sortorder']; ?>
 <?php endif; ?>" id="sortcompany">Company Name</th>
    </tr>
  </thead>
  <tbody>  
 
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['SearchResults']) ? count($this->_tpl_vars['SearchResults']) : max(0, (int)$this->_tpl_vars['SearchResults']);
$this->_sections['List']['show'] = true;
$this->_sections['List']['max'] = $this->_sections['List']['loop'];
$this->_sections['List']['step'] = 1;
$this->_sections['List']['start'] = $this->_sections['List']['step'] > 0 ? 0 : $this->_sections['List']['loop']-1;
if ($this->_sections['List']['show']) {
    $this->_sections['List']['total'] = $this->_sections['List']['loop'];
    if ($this->_sections['List']['total'] == 0)
        $this->_sections['List']['show'] = false;
} else
    $this->_sections['List']['total'] = 0;
if ($this->_sections['List']['show']):

            for ($this->_sections['List']['index'] = $this->_sections['List']['start'], $this->_sections['List']['iteration'] = 1;
                 $this->_sections['List']['iteration'] <= $this->_sections['List']['total'];
                 $this->_sections['List']['index'] += $this->_sections['List']['step'], $this->_sections['List']['iteration']++):
$this->_sections['List']['rownum'] = $this->_sections['List']['iteration'];
$this->_sections['List']['index_prev'] = $this->_sections['List']['index'] - $this->_sections['List']['step'];
$this->_sections['List']['index_next'] = $this->_sections['List']['index'] + $this->_sections['List']['step'];
$this->_sections['List']['first']      = ($this->_sections['List']['iteration'] == 1);
$this->_sections['List']['last']       = ($this->_sections['List']['iteration'] == $this->_sections['List']['total']);
?>  
      <tr>
        <td>
            <a class="postlinkval" href="companylist_suggest.php?id=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['cin']; ?>
&ioc_fstatus=1&ioc_c=<?php echo $this->_tpl_vars['companyURL']; ?>
<?php if ($this->_tpl_vars['ioc_fstatus'] == 1): ?><?php if ($this->_tpl_vars['ioc_faddress'] != ''): ?>&chargeaddress=<?php echo $this->_tpl_vars['ioc_faddress']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['ioc_fchargefromdate'] != ''): ?>&chargefromdate=<?php echo $this->_tpl_vars['ioc_fchargefromdate']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['ioc_fchargetodate'] != ''): ?>&chargetodate=<?php echo $this->_tpl_vars['ioc_fchargetodate']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['ioc_fchargefromamount'] != ''): ?>&chargefromamount=<?php echo $this->_tpl_vars['ioc_fchargefromamount']; ?>
<?php endif; ?><?php if ($this->_tpl_vars['ioc_fchargetoamount'] != ''): ?>&chargetoamount=<?php echo $this->_tpl_vars['ioc_fchargetoamount']; ?>
<?php endif; ?><?php elseif ($this->_tpl_vars['companyURL'] != ''): ?>&ioc_c=<?php echo $this->_tpl_vars['companyURL']; ?>
<?php endif; ?>" style="color:#414141;text-decoration: none;"><b><?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['company_name']; ?>
</b></a></td>
      </tr>
    <?php endfor; endif; ?>
  </tbody>
</table>
<?php echo '

 

    <script type="text/javascript">
    $("a.postlinkval").live(\'click\',function(){
        hrefval= $(this).attr("href");
        $("#Frm_HmeSearch1").attr("action", hrefval);
        $("#Frm_HmeSearch1").submit();
        return false;
     });
     </script>
'; ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("pagination.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>


