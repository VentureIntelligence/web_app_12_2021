<?php /* Smarty version 2.5.0, created on 2016-03-07 01:59:26
         compiled from other_report.tpl */ ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php echo '
<style type="text/css">
    form.custom .custom.dropdown
    {
        width:80px !important;
        }
        
    </style>
'; ?>



<div class="container-right">
	<div class="companies-list">

            
            <div class="result-title" style="margin-top:1%;border-bottom: 1px solid #ccc;">
             <h3>
               <span class="result-no"> Listed Reports(<?php echo $this->_tpl_vars['ReportsCount']; ?>
)</span>
            </h3>                   
               
            </div>
            
            <table width="100%" border="0" cellspacing="0" cellpadding="0" style="margin-top:2%;">
<thead> 
<tr>
<th style=" background:none;">Title </th>
<th style=" background:none;"> Period <br/> </th>
<th style=" background:none;"> Date <br/> </th>
</tr>
</thead>
<tbody>  
  
  <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['reportList']) ? count($this->_tpl_vars['reportList']) : max(0, (int)$this->_tpl_vars['reportList']);
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
          <td class="name-list">
              <a class="postlink_new" href="other_report_details.php?rid=<?php echo $this->_tpl_vars['reportList'][$this->_sections['List']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['reportList'][$this->_sections['List']['index']]['reportTitle']; ?>
 </a>
          </td>
          <td class="name-list">
                <a class="postlink_new"  href="other_report_details.php?rid=<?php echo $this->_tpl_vars['reportList'][$this->_sections['List']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['reportList'][$this->_sections['List']['index']]['reportPeriod']; ?>
 </a>
          </td>
          <td class="name-list">
                <a class="postlink_new"  href="other_report_details.php?rid=<?php echo $this->_tpl_vars['reportList'][$this->_sections['List']['index']]['id']; ?>
"><?php echo $this->_tpl_vars['reportList'][$this->_sections['List']['index']]['date']; ?>
 </a>
          </td>
  </tr>
  <?php endfor; endif; ?>
   
  </tbody>
  </table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("pagination.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
</div>

</form>


</div>




</div>


</div>
  

</div>
<!-- End of Container -->


</body>
</html>

<?php echo '
               
                
 <script type="text/javascript">
 $("a.postlink_new").live(\'click\',function(){
      
        hrefval= $(this).attr("href");
        $("#Frm_reportSearch").attr("action", hrefval);
        $("#Frm_reportSearch").submit();
        return false;

    });
 </script>

'; ?>

