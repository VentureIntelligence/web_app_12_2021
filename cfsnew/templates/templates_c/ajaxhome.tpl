<?php /* Smarty version 2.5.0, created on 2018-12-21 12:53:21
         compiled from ajaxhome.tpl */ ?>
<?php $this->_load_plugins(array(
array('modifier', 'lower', 'ajaxhome.tpl', 28, false),
array('modifier', 'capitalize', 'ajaxhome.tpl', 28, false),
array('modifier', 'explode', 'ajaxhome.tpl', 42, false),
array('modifier', 'replace', 'ajaxhome.tpl', 63, false),
array('function', 'math', 'ajaxhome.tpl', 37, false),
array('function', 'assign', 'ajaxhome.tpl', 42, false),)); ?><?php if ($this->_tpl_vars['searchupperlimit'] >= $this->_tpl_vars['searchlowerlimit']): ?>   

<table width="100%" border="0" cellspacing="0" cellpadding="0">
<tHead> <tr>
        <th  class="sorthead <?php if ($this->_tpl_vars['sortby'] == 'sortcompany'): ?> <?php echo $this->_tpl_vars['sortorder']; ?>
 <?php endif; ?>" id="sortcompany">Company Name</th>
<th class="sorthead <?php if ($this->_tpl_vars['sortby'] == 'sortrevenue'): ?> <?php echo $this->_tpl_vars['sortorder']; ?>
 <?php endif; ?>" id="sortrevenue"> Revenue <br/> </th>
<th class="sorthead <?php if ($this->_tpl_vars['sortby'] == 'sortebita'): ?> <?php echo $this->_tpl_vars['sortorder']; ?>
 <?php endif; ?>" id="sortebita"> EBITDA <br/> </th>
<th class="sorthead <?php if ($this->_tpl_vars['sortby'] == 'sortpat'): ?> <?php echo $this->_tpl_vars['sortorder']; ?>
 <?php endif; ?>" id="sortpat"> PAT <br/> </th>
<th class="sorthead <?php if ($this->_tpl_vars['sortby'] == 'sortdetailed'): ?> <?php echo $this->_tpl_vars['sortorder']; ?>
 <?php endif; ?>" id="sortdetailed"> Detailed</th>

<?php if ($this->_tpl_vars['chargewhere'] != ''): ?>

 <th style='background:none'> Date of Charge</th> 
 <th style='background:none'> Charge Amount</th> 
 <th style='background:none'> Charge Holder</th> 
<?php endif; ?>


</tr></thead>
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
    
      <tr><td class="name-list" style="text-transform: uppercase"> <span class="has-tip" data-tooltip="" title="<?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '0'): ?>Both<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '1'): ?> Listed<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '2'): ?> Privately held(Ltd)<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '3'): ?> Partnership <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '4'): ?> Proprietorship<?php endif; ?>"><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '0'): ?>Both<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '1'): ?> L<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '2'): ?> PVT<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '3'): ?> PART <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '4'): ?> PROP<?php endif; ?></span>
              <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['COMPANYNAME']): ?>
            <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['Company_Id']; ?>
&c=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['COMPANYNAME']; ?>
" title="Click here to view Annual Report" 
         
        ><?php echo $this->_run_mod_handler('capitalize', true, $this->_run_mod_handler('lower', true, $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['SCompanyName'])); ?>
</a>	

        <?php else: ?>
        <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['Company_Id']; ?>
" title="Click here to view Annual Report" 
       
        ><?php echo $this->_run_mod_handler('capitalize', true, $this->_run_mod_handler('lower', true, $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['SCompanyName'])); ?>
</a>

        <?php endif; ?>
              </td>
    <td><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['TotalIncome'] == 0): ?>&nbsp;<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GrowthPerc_Id'] || $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['CAGR_Id']): ?><?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['TotalIncome']; ?>
<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "x / y",'x' => $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['TotalIncome'],'y' => 10000000,'format' => "%.2f"), $this) ; ?>
<?php endif; ?></td>
    <td><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['EBITDA'] == 0): ?>&nbsp;<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GrowthPerc_Id'] || $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['CAGR_Id']): ?><?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['EBITDA']; ?>
<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "x / y",'x' => $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['EBITDA'],'y' => 10000000,'format' => "%.2f"), $this) ; ?>
<?php endif; ?></td>
    <td><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['PAT'] == 0): ?>&nbsp;<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GrowthPerc_Id'] || $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['CAGR_Id']): ?><?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['PAT']; ?>
<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "x / y",'x' => $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['PAT'],'y' => 10000000,'format' => "%.2f"), $this) ; ?>
<?php endif; ?></td>
    <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FY'] > 0): ?>
    <td>
        <?php echo $this->_plugins['function']['assign'][0](array('var' => 'FY','value' => $this->_run_mod_handler('explode', true, ' ', $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FY'])), $this) ; ?>

        <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['COMPANYNAME']): ?>
            <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['Company_Id']; ?>
&c=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['COMPANYNAME']; ?>
" title="Click here to view Annual Report" 
         
        >FY<?php echo $this->_tpl_vars['FY'][0]; ?>
 </a>	(upto <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue'] == 1): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue']; ?>
 Year <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue'] != ''): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue']; ?>
 Years<?php endif; ?> <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY'] == 1): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY']; ?>
 Year <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY'] != ''): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY']; ?>
 Years<?php endif; ?> )	

        <?php else: ?>
        
        <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['Company_Id']; ?>
" title="Click here to view Annual Report" 
       
        >FY<?php echo $this->_tpl_vars['FY'][0]; ?>
 </a>	(upto <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue'] == 1): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue']; ?>
 Year <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue'] != ''): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue']; ?>
 Years<?php endif; ?> <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY'] == 1): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY']; ?>
 Year <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY'] != ''): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY']; ?>
 Years<?php endif; ?> )	
        <?php endif; ?>

    </td> 
     <?php else: ?>
         <td><a> </a></td>
        <?php endif; ?>
        
    <?php if ($this->_tpl_vars['chargewhere'] != ''): ?>
  
    <td> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['dateofcharge']; ?>
 </td> 
    <td> <?php echo $this->_plugins['function']['math'][0](array('equation' => "x / y",'x' => $this->_run_mod_handler('replace', true, $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['chargeamt'], ',', ''),'y' => 10000000,'format' => "%.2f"), $this) ; ?>
 </td> 
    <td> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['chargeholder']; ?>
 </td> 
   <?php endif; ?>
     
     
    
  </tr>
  <?php endfor; endif; ?>
   
  </tbody>
  </table>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("pagination.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
  
<?php else: ?>
      <p>Your Subscription limit of companies has been reached. Please contact info@ventureintelligence.com to top up your subscription</p>
<?php endif; ?>
