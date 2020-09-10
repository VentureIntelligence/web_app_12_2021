<?php /* Smarty version 2.5.0, created on 2019-01-18 15:02:08
         compiled from viewfiling.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("leftpanel.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<div class="container-right">

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("filters.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="list-tab">
<ul>
    <li><a class="postlink" href="home.php"><i></i> LIST VIEW</a></li>
<li><a   href="details.php?vcid=<?php echo $this->_tpl_vars['VCID']; ?>
" class="active postlink"><i class="i-detail-view"></i> DETAIL VIEW</a></li>
</ul>
</div>

<div class="companies-details">
<div class="detailed-title-links"> <h2><?php echo $this->_tpl_vars['companyName']; ?>
</h2> <!--<a class="previous" href="javascript:;">Previous</a> <a class="next" href="javascript:;">Next</a> --><br></div>


<div class="filing-cnt">

<div class="title-table"><h3>FILINGS</h3> <a href="details.php?vcid=<?php echo $this->_tpl_vars['backcid']; ?>
" class="postlink">Back to details</a></div>

 

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<!--tHead> <tr>
<!--th><input name="" type="checkbox" value="" /></th>
    <th>File Name </th>
<th> Date</th>
<th>  </th> 
</tr></thead-->
<tbody>  
    <?php if (isset($this->_sections['customer'])) unset($this->_sections['customer']);
$this->_sections['customer']['name'] = 'customer';
$this->_sections['customer']['loop'] = is_array($this->_tpl_vars['searchResults']) ? count($this->_tpl_vars['searchResults']) : max(0, (int)$this->_tpl_vars['searchResults']);
$this->_sections['customer']['show'] = true;
$this->_sections['customer']['max'] = $this->_sections['customer']['loop'];
$this->_sections['customer']['step'] = 1;
$this->_sections['customer']['start'] = $this->_sections['customer']['step'] > 0 ? 0 : $this->_sections['customer']['loop']-1;
if ($this->_sections['customer']['show']) {
    $this->_sections['customer']['total'] = $this->_sections['customer']['loop'];
    if ($this->_sections['customer']['total'] == 0)
        $this->_sections['customer']['show'] = false;
} else
    $this->_sections['customer']['total'] = 0;
if ($this->_sections['customer']['show']):

            for ($this->_sections['customer']['index'] = $this->_sections['customer']['start'], $this->_sections['customer']['iteration'] = 1;
                 $this->_sections['customer']['iteration'] <= $this->_sections['customer']['total'];
                 $this->_sections['customer']['index'] += $this->_sections['customer']['step'], $this->_sections['customer']['iteration']++):
$this->_sections['customer']['rownum'] = $this->_sections['customer']['iteration'];
$this->_sections['customer']['index_prev'] = $this->_sections['customer']['index'] - $this->_sections['customer']['step'];
$this->_sections['customer']['index_next'] = $this->_sections['customer']['index'] + $this->_sections['customer']['step'];
$this->_sections['customer']['first']      = ($this->_sections['customer']['iteration'] == 1);
$this->_sections['customer']['last']       = ($this->_sections['customer']['iteration'] == $this->_sections['customer']['total']);
?>
          
       <tr> 
        <td><?php echo $this->_tpl_vars['searchResults'][$this->_sections['customer']['index']]['name']; ?>
  </td>
      
  </tr>
    <?php endfor; endif; ?>
</tbody>
  </table>
  
 </div>
</div>

</div>

<?php echo '
<script type="text/javascript">


function check(newLink)
{
	location.href= newLink; //document.getElementById("google-link").value; //  "http://www.yahoo.com/";
	return false;	// so important
}
</script>


    
'; ?>