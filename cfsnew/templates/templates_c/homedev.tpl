<?php /* Smarty version 2.5.0, created on 2013-11-26 07:12:26
         compiled from homedev.tpl */ ?>
<?php $this->_load_plugins(array(
array('modifier', 'lower', 'homedev.tpl', 34, false),
array('modifier', 'capitalize', 'homedev.tpl', 34, false),
array('modifier', 'escape', 'homedev.tpl', 62, false),
array('function', 'math', 'homedev.tpl', 43, false),)); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("headerdev.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("leftpanel.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="container-right">
<?php if ($this->_tpl_vars['searchupperlimit'] >= $this->_tpl_vars['searchlowerlimit']): ?>   
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("filters.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="list-tab">
<ul>
<li><a  href="home.php" class="active postlink"><i></i> LIST VIEW</a></li>
<li><a class="postlink" href="<?php if (count ( $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']] ) > 0): ?>details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][0]['Company_Id']; ?>
<?php else: ?>#<?php endif; ?>"><i class="i-detail-view"></i> DETAIL VIEW</a></li>
</ul><div class="page-no" style="position: initial;"><span>(in Rs. Cr) &nbsp;&nbsp;</span></div>
</div>

<div class="companies-list">

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
<th> Filings	</th></tr></thead>
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
    
      <tr><td class="name-list"> <span class="has-tip" data-tooltip="" title="<?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '0'): ?>Both<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '1'): ?> Listed<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '2'): ?> Privately held(Ltd)<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '3'): ?> Partnership <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '4'): ?> Proprietorship<?php endif; ?>"><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '0'): ?>Both<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '1'): ?> L<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '2'): ?> PVT<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '3'): ?> PART <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['ListingStatus'] == '4'): ?> PROP<?php endif; ?></span>
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
    <td><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['EBDT'] == 0): ?>&nbsp;<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GrowthPerc_Id'] || $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['CAGR_Id']): ?><?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['EBDT']; ?>
<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "x / y",'x' => $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['EBDT'],'y' => 10000000,'format' => "%.2f"), $this) ; ?>
<?php endif; ?></td>
    <td><?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['PAT'] == 0): ?>&nbsp;<?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GrowthPerc_Id'] || $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['CAGR_Id']): ?><?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['PAT']; ?>
<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "x / y",'x' => $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['PAT'],'y' => 10000000,'format' => "%.2f"), $this) ; ?>
<?php endif; ?></td>
    <td>
        <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['COMPANYNAME']): ?>
            <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['Company_Id']; ?>
&c=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['COMPANYNAME']; ?>
" title="Click here to view Annual Report" 
         
        >FY<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FY']; ?>
 </a>	(upto <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue'] == 1): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue']; ?>
 Year <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue'] != ''): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue']; ?>
 Years<?php endif; ?> <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY'] == 1): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY']; ?>
 Year <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY'] != ''): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY']; ?>
 Years<?php endif; ?> )	

        <?php else: ?>
        <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['Company_Id']; ?>
" title="Click here to view Annual Report" 
       
        >FY<?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FY']; ?>
 </a>	(upto <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue'] == 1): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue']; ?>
 Year <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue'] != ''): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FYValue']; ?>
 Years<?php endif; ?> <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY'] == 1): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY']; ?>
 Year <?php elseif ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY'] != ''): ?> <?php echo $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['GFY']; ?>
 Years<?php endif; ?> )	

        <?php endif; ?>
        
    </td> 
     <td>
        <?php if ($this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['filing'] == 'true'): ?>
            <a class="postlink" href="viewfiling.php?c=<?php echo $this->_run_mod_handler('escape', true, $this->_tpl_vars['SearchResults'][$this->_sections['List']['index']]['FCompanyName'], 'url'); ?>
">View</a>
        <?php else: ?>
            -
        <?php endif; ?>
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
  
<?php else: ?>
      <p>Your Subscription limit of companies has been reached. Please contact info@ventureintelligence.com to top up your subscription</p>
<?php endif; ?>
</div>
<!-- End of container-right -->

</div>
<!-- End of Container -->
<input type="hidden" name="sortby" id="sortby" value="<?php echo $this->_tpl_vars['sortby']; ?>
"/>
<input type="hidden" name="sortorder" id="sortorder" value="<?php echo $this->_tpl_vars['sortorder']; ?>
"/>
<input type="hidden" name="pageno" id="pageno" value="<?php echo $this->_tpl_vars['pageno']; ?>
"/>
</form>

</body>
</html>
<?php echo '
    <script type="text/javascript">
        $(document).ready(function() {
              $(".sorthead").live(\'click\',function(){
                 // $(this).html($(this).text()+\'<img src="images/ajax-loader.gif" style="float:right;height:20px;"/>\');
                 $(this).addClass(\'loadingth\');
                sortby=$(this).attr(\'id\');
                if($(this).hasClass("asc"))
                        sortorder="desc";
                    else
                        sortorder="asc";
                 $("#sortby").val(sortby);
                 $("#sortorder").val(sortorder);
                   $.ajax({
            type: "POST",
          url: "ajaxhomedev.php",
          data: $("#Frm_HmeSearch").serializeArray(),
          success: function( data ) {
              $(\'.companies-list\').html(data);
             // alert(data);
          }
        });
                 //$("#Frm_HmeSearch").submit();
              });
        });
    </script>
'; ?>