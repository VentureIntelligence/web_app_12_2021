<?php /* Smarty version 2.5.0, created on 2014-09-25 02:01:17
         compiled from comparers.tpl */ ?>
<?php $this->_load_plugins(array(
array('modifier', 'truncate', 'comparers.tpl', 191, false),
array('modifier', 'lower', 'comparers.tpl', 191, false),
array('modifier', 'capitalize', 'comparers.tpl', 191, false),
array('modifier', 'number_format', 'comparers.tpl', 256, false),
array('function', 'math', 'comparers.tpl', 207, false),)); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
js/common.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
js/compare.js"></script>
<!--<script type="text/javascript" src="<?php echo $this->_tpl_vars['SITE_PATH']; ?>
js/jquery.js"></script>-->

<?php echo '<script src="http://foundation.zurb.com/docs/assets/vendor/custom.modernizr.js"></script>'; ?>


<?php echo '
<script type="text/javascript" language="javascript1.2">
$(document).ready(function(){
$(".relSpace").hide();
$(".balancesheetminus").click(function(){
    $(".balancesheet").slideToggle("slow");
	$(".balancesheetminus").hide();
	$(".balancesheetplus").show();
	
  });
});
$(document).ready(function(){
$(".balancesheetplus").click(function(){
    $(".balancesheet").slideToggle("slow");
	$(".balancesheetminus").show();
	$(".balancesheetplus").hide();
	
  });
});

$(document).ready(function(){
$(".balancesheetminus1").click(function(){
    $(".balancesheet1").slideToggle("slow");
	$(".balancesheetminus1").hide();
	$(".balancesheetplus1").show();
	
  });
});
$(document).ready(function(){
$(".balancesheetplus1").click(function(){
    $(".balancesheet1").slideToggle("slow");
	$(".balancesheetminus1").show();
	$(".balancesheetplus1").hide();
	
  });
});

$(document).ready(function(){
$(".diagramsminus").click(function(){
    $(".diagrams").slideToggle("slow");
	$(".diagramsminus").hide();
	$(".diagramsplus").show();
	
  });
});
$(document).ready(function(){
$(".diagramsplus").click(function(){
    $(".diagrams").slideToggle("slow");
	$(".diagramsminus").show();
	$(".diagramsplus").hide();
	
  });
});
/*$(document).ready(function(){
	$(".ExportComparsion").click(function(){
		$(".downloadExportComparsion").show();
	  });
});*/

	/*label1 = document.getElementById(\'req_answer[CompanyId]\');
	label2 = document.getElementById(\'req_answer[PLStandard]\');
	label1.setAttribute("class","error");
	label2.setAttribute("class","error");*/
	
function comaparepercen(pertype){
	if(pertype==\'Percentage\'){
                $(".relSpace").show();
		$(".relativecal").show();
		$(".absolutecal").hide();
	}else{
                $(".relSpace").hide();
		$(".relativecal").hide();
		$(".absolutecal").show();
	}
}

$(function() {
    
    $( "#company1" ).autocomplete({
        source: "autosuggestjson.php",
        minLength: 2,
        select: function( event, ui ) {
          $(\'#comp_1\').val(ui.item.id);
          $(\'#compname_1\').val(ui.item.value);
        }
    });
    $( "#company2" ).autocomplete({
        source: "autosuggestjson.php",
        minLength: 2,
        select: function( event, ui ) {
          $(\'#comp_2\').val(ui.item.id);
          $(\'#compname_2\').val(ui.item.value);
        }
    });
    
     $( "#company3" ).autocomplete({
        source: "autosuggestjson.php",
        minLength: 2,
        select: function( event, ui ) {
           $(\'#comp_3\').attr(\'disabled\',false);
           $(\'#compname_3\').attr(\'disabled\',false);
           $(\'#comp_3\').val(ui.item.id);
           $(\'#compname_3\').val(ui.item.value);
        }
    });
     $(".resetcompany").click(function(){
         id=$(this).attr(\'id\');
         $(\'#resetcompany\').val(id);
         $(\'#Frm_HmeSearch\').submit();
     });
    
});


function submitselect(value){
    
     $(\'#answerYear\').val(value);
     company1=$(\'#company1\').val();
     company2=$(\'#company2\').val();
     if(company1!="" &&  company2!=""){
     document.forms[\'Frm_HmeSearch\'].submit();
     }
}
function validate()
{
    if($("#comp_1").val()!="" && $("#comp_2").val()!="")
    {
         document.forms[\'Frm_HmeSearch\'].submit();
        return true;
    }
    else
    {
        alert("Specify two Company Names to Compare !!");
        return false;
    }
     return false;
}
</script>
'; ?>

 
<div class="container ">
   
    <?php if (! $this->_tpl_vars['comparecompany']): ?>
    <div class="compare-companies compare-start" >
        <ul>
            <li><input name="company1" type="text" placeholder="Enter Company Name Here" id='company1'/></li>
            <li><input name="company2" type="text" placeholder="Enter Company Name Here" id='company2'/></li>
            <li><input name="save" type="button" value="Compare" onclick="return validate();"/></li>
            <input type="hidden" name="answer[CCompanies][]" id="comp_1">
            <input type="hidden" name="answer[CCompanies][]" id="comp_2">
            <input type="hidden" name="answer[CCompanynames][]" id="compname_1">
            <input type="hidden" name="answer[CCompanynames][]" id="compname_2">
            <input type="hidden" name="resetcompany" id="resetcompany">
            <input type="hidden" id="answerYear" name="answer[Year]" value="<?php echo $this->_tpl_vars['comparecompanyyear']; ?>
"/>
            
        </ul>
    </div>
    <?php endif; ?>
    
    <?php if ($this->_tpl_vars['comparecompany']): ?>
      <p style="padding:0.5% 1%; text-align: right;color: #A37635;">All figures are in INR Crore, unless otherwise specified</p>   
    <div class="compare-companies">
        <ul  class="operations-list">
            <li><h4>OPERATIONS</h4></li>
            <li class="relSpace">&nbsp;</li>
            <li class="fontb">OPERTNAL INCOME</li>
            <li class="fontb">OTHER INCOME</li>
            <li>Total Income</li>
            <li><span  data-tooltip="" title="Operating,Admministrative & Other Expenses">Ope,Ad&Other</span></li>
            <li>Operating Profit</li>
            <li class="fontb">EBITDA</li>
            <li>Interest</li>
            <li class="fontb">EBDT</li>
            <li>Depreciation</li>
            <li class="fontb">EBT</li>
            <li>Tax</li>
            <li class="fontb">PAT</li> 
            
            <li>Basic INR</li>
            <li>Diluted INR</li>
        </ul>

        <div class="compare-scroll" style="">
            <div style=""><?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['CompareResults']) ? count($this->_tpl_vars['CompareResults']) : max(0, (int)$this->_tpl_vars['CompareResults']);
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
?><ul><li><h4><?php echo $this->_run_mod_handler('capitalize', true, $this->_run_mod_handler('lower', true, $this->_run_mod_handler('truncate', true, $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['SCompanyName'], 100))); ?>
<?php if (count ( $this->_tpl_vars['comparecompany'] ) > 2): ?><span class="resetcompany" style="float: right; top: 0px; position: absolute; right: 0px; font-size: 16px; padding: 5px; margin: 0px; background: #999;cursor: pointer;" id="<?php echo $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['CId_FK']; ?>
"><img width="7" height="7" border="0" src="images/icon-close-ul.png" alt=""></span><?php endif; ?></h4></li>
                
                <li class="relSpace">&nbsp;</li>
                <li><?php if ($this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['OptnlIncome'] == 0): ?>-<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "comresult/crores",'comresult' => $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['OptnlIncome'],'crores' => 10000000), $this) ; ?>
<?php endif; ?></li>
                 <li><?php if ($this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['OtherIncome'] == 0): ?>-<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "comresult/crores",'comresult' => $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['OtherIncome'],'crores' => 10000000), $this) ; ?>
<?php endif; ?></li>
                 <li><?php if ($this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['TotalIncome'] == 0): ?>-<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "comresult/crores",'comresult' => $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['TotalIncome'],'crores' => 10000000), $this) ; ?>
<?php endif; ?></li>
                 <li><?php if ($this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['OptnlAdminandOthrExp'] == 0): ?>-<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "comresult/crores",'comresult' => $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['OptnlAdminandOthrExp'],'crores' => 10000000), $this) ; ?>
<?php endif; ?></li>
                 <li><?php if ($this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['OptnlProfit'] == 0): ?>-<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "comresult/crores",'comresult' => $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['OptnlProfit'],'crores' => 10000000), $this) ; ?>
<?php endif; ?></li>
                 <li><?php if ($this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['EBITDA'] == 0): ?>-<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "comresult/crores",'comresult' => $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['EBITDA'],'crores' => 10000000), $this) ; ?>
<?php endif; ?></li>
                 <li><?php if ($this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['Interest'] == 0): ?>-<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "comresult/crores",'comresult' => $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['Interest'],'crores' => 10000000), $this) ; ?>
<?php endif; ?></li>
                 <li><?php if ($this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['EBDT'] == 0): ?>-<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "comresult/crores",'comresult' => $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['EBDT'],'crores' => 10000000), $this) ; ?>
<?php endif; ?></li>
                 <li><?php if ($this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['Depreciation'] == 0): ?>-<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "comresult/crores",'comresult' => $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['Depreciation'],'crores' => 10000000), $this) ; ?>
<?php endif; ?></li>
                 <li><?php if ($this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['EBT'] == 0): ?>-<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "comresult/crores",'comresult' => $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['EBT'],'crores' => 10000000), $this) ; ?>
<?php endif; ?></li>
                 <li><?php if ($this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['Tax'] == 0): ?>-<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "comresult/crores",'comresult' => $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['Tax'],'crores' => 10000000), $this) ; ?>
<?php endif; ?></li>
                 <li><?php if ($this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['PAT'] == 0): ?>-<?php else: ?><?php echo $this->_plugins['function']['math'][0](array('equation' => "comresult/crores",'comresult' => $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['PAT'],'crores' => 10000000), $this) ; ?>
<?php endif; ?></li>
                 
                 <li><?php if ($this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['BINR'] == 0): ?>-<?php else: ?><?php echo $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['BINR']; ?>
<?php endif; ?></li>
                 <li><?php if ($this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['DINR'] == 0): ?>-<?php else: ?><?php echo $this->_tpl_vars['CompareResults'][$this->_sections['List']['index']]['DINR']; ?>
<?php endif; ?></li>
                 </ul><?php endfor; endif; ?><?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['unavailcomp']) ? count($this->_tpl_vars['unavailcomp']) : max(0, (int)$this->_tpl_vars['unavailcomp']);
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
?><ul><li><h4><?php echo $this->_tpl_vars['unavailcomp'][$this->_sections['List']['index']]; ?>
<?php if (count ( $this->_tpl_vars['comparecompany'] ) > 2): ?><span class="resetcompany" style="float: right; top: 0px; position: absolute; right: 0px; font-size: 16px; padding: 5px; margin: 0px; background: #999;cursor: pointer;" id="<?php echo $this->_tpl_vars['unavailid'][$this->_sections['List']['index']]; ?>
"><img width="7" height="7" border="0" src="images/icon-close-ul.png" alt=""></span><?php endif; ?></h4></li>
                 <li>No Data Available</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                 <li>-</li>
                <li>-</li>
                </ul><?php endfor; endif; ?><?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['CompareMean']) ? count($this->_tpl_vars['CompareMean']) : max(0, (int)$this->_tpl_vars['CompareMean']);
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
?><ul class="compare-list absolutecal" id='absolutecal' <?php if (CompareType != 0): ?> style="display:none;"<?php endif; ?>>
                <li><h4><?php echo $this->_tpl_vars['SCompanyName1'][$this->_sections['List']['index_next']]; ?>
/<?php echo $this->_tpl_vars['SCompanyName1'][0]; ?>
 (-)</h4></li>
                <li class="relSpace">&nbsp;</li>
                <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['CompareMean'][$this->_sections['List']['index']]) ? count($this->_tpl_vars['CompareMean'][$this->_sections['List']['index']]) : max(0, (int)$this->_tpl_vars['CompareMean'][$this->_sections['List']['index']]);
$this->_sections['List1']['show'] = true;
$this->_sections['List1']['max'] = $this->_sections['List1']['loop'];
$this->_sections['List1']['step'] = 1;
$this->_sections['List1']['start'] = $this->_sections['List1']['step'] > 0 ? 0 : $this->_sections['List1']['loop']-1;
if ($this->_sections['List1']['show']) {
    $this->_sections['List1']['total'] = $this->_sections['List1']['loop'];
    if ($this->_sections['List1']['total'] == 0)
        $this->_sections['List1']['show'] = false;
} else
    $this->_sections['List1']['total'] = 0;
if ($this->_sections['List1']['show']):

            for ($this->_sections['List1']['index'] = $this->_sections['List1']['start'], $this->_sections['List1']['iteration'] = 1;
                 $this->_sections['List1']['iteration'] <= $this->_sections['List1']['total'];
                 $this->_sections['List1']['index'] += $this->_sections['List1']['step'], $this->_sections['List1']['iteration']++):
$this->_sections['List1']['rownum'] = $this->_sections['List1']['iteration'];
$this->_sections['List1']['index_prev'] = $this->_sections['List1']['index'] - $this->_sections['List1']['step'];
$this->_sections['List1']['index_next'] = $this->_sections['List1']['index'] + $this->_sections['List1']['step'];
$this->_sections['List1']['first']      = ($this->_sections['List1']['iteration'] == 1);
$this->_sections['List1']['last']       = ($this->_sections['List1']['iteration'] == $this->_sections['List1']['total']);
?>
                <li><?php if ($this->_tpl_vars['CompareMean'][$this->_sections['List']['index']][$this->_sections['List1']['index']] == 0): ?>-<?php else: ?> <?php if ($this->_sections['List1']['index'] == 12 || $this->_sections['List1']['index'] == 13): ?> <?php echo $this->_tpl_vars['CompareMean'][$this->_sections['List']['index']][$this->_sections['List1']['index']]; ?>
 <?php else: ?> <?php echo $this->_plugins['function']['math'][0](array('equation' => "comresult/crores",'comresult' => $this->_tpl_vars['CompareMean'][$this->_sections['List']['index']][$this->_sections['List1']['index']],'crores' => 10000000), $this) ; ?>
<?php endif; ?><?php endif; ?> </li>
                <?php endfor; endif; ?></ul><?php endfor; endif; ?>
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['RealtiveCompareMean']) ? count($this->_tpl_vars['RealtiveCompareMean']) : max(0, (int)$this->_tpl_vars['RealtiveCompareMean']);
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
?><ul class="compare-list relativecal" id='relativecal' <?php if (CompareType != 1): ?> style="display:none;"<?php endif; ?>>
                 <li class="lo"><h4 class="frh"><?php echo $this->_tpl_vars['SCompanyName1'][$this->_sections['List']['index_next']]; ?>
/<?php echo $this->_tpl_vars['SCompanyName1'][0]; ?>
</h4></li>
                 
                <!-- <li>
                     <table>
                         
                         <tr>
                             <td>Multiple(x)</td>
                             <td>|</td>
                             <td>Percentage (%)</td>
                         </tr>
                         <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RealtiveCompareMean'][$this->_sections['List']['index']]) ? count($this->_tpl_vars['RealtiveCompareMean'][$this->_sections['List']['index']]) : max(0, (int)$this->_tpl_vars['RealtiveCompareMean'][$this->_sections['List']['index']]);
$this->_sections['List1']['show'] = true;
$this->_sections['List1']['max'] = $this->_sections['List1']['loop'];
$this->_sections['List1']['step'] = 1;
$this->_sections['List1']['start'] = $this->_sections['List1']['step'] > 0 ? 0 : $this->_sections['List1']['loop']-1;
if ($this->_sections['List1']['show']) {
    $this->_sections['List1']['total'] = $this->_sections['List1']['loop'];
    if ($this->_sections['List1']['total'] == 0)
        $this->_sections['List1']['show'] = false;
} else
    $this->_sections['List1']['total'] = 0;
if ($this->_sections['List1']['show']):

            for ($this->_sections['List1']['index'] = $this->_sections['List1']['start'], $this->_sections['List1']['iteration'] = 1;
                 $this->_sections['List1']['iteration'] <= $this->_sections['List1']['total'];
                 $this->_sections['List1']['index'] += $this->_sections['List1']['step'], $this->_sections['List1']['iteration']++):
$this->_sections['List1']['rownum'] = $this->_sections['List1']['iteration'];
$this->_sections['List1']['index_prev'] = $this->_sections['List1']['index'] - $this->_sections['List1']['step'];
$this->_sections['List1']['index_next'] = $this->_sections['List1']['index'] + $this->_sections['List1']['step'];
$this->_sections['List1']['first']      = ($this->_sections['List1']['iteration'] == 1);
$this->_sections['List1']['last']       = ($this->_sections['List1']['iteration'] == $this->_sections['List1']['total']);
?>
                         <tr>
                             <td><?php if ($this->_tpl_vars['RealtiveCompareMean'][$this->_sections['List']['index']][$this->_sections['List1']['index']] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['RealtiveCompareMean'][$this->_sections['List']['index']][$this->_sections['List1']['index']], 2, ".", ","); ?>
(x)<?php endif; ?></td>
                             <td>|</td>
                             <td><?php if ($this->_tpl_vars['RelativeCompareMeanper'][$this->_sections['List']['index']][$this->_sections['List1']['index']] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['RelativeCompareMeanper'][$this->_sections['List']['index']][$this->_sections['List1']['index']], 0, ".", ","); ?>
%<?php endif; ?></td>
                         </tr>
                         <?php endfor; endif; ?>
                     </table>
                 </li>-->
                         
                         <li class="relSpace"><div class="main-cn"><div class="lfhead-cn">Multiple(x)</div><div class="rghead-cn">Percentage (%)</div></div></li>
                 <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RealtiveCompareMean'][$this->_sections['List']['index']]) ? count($this->_tpl_vars['RealtiveCompareMean'][$this->_sections['List']['index']]) : max(0, (int)$this->_tpl_vars['RealtiveCompareMean'][$this->_sections['List']['index']]);
$this->_sections['List1']['show'] = true;
$this->_sections['List1']['max'] = $this->_sections['List1']['loop'];
$this->_sections['List1']['step'] = 1;
$this->_sections['List1']['start'] = $this->_sections['List1']['step'] > 0 ? 0 : $this->_sections['List1']['loop']-1;
if ($this->_sections['List1']['show']) {
    $this->_sections['List1']['total'] = $this->_sections['List1']['loop'];
    if ($this->_sections['List1']['total'] == 0)
        $this->_sections['List1']['show'] = false;
} else
    $this->_sections['List1']['total'] = 0;
if ($this->_sections['List1']['show']):

            for ($this->_sections['List1']['index'] = $this->_sections['List1']['start'], $this->_sections['List1']['iteration'] = 1;
                 $this->_sections['List1']['iteration'] <= $this->_sections['List1']['total'];
                 $this->_sections['List1']['index'] += $this->_sections['List1']['step'], $this->_sections['List1']['iteration']++):
$this->_sections['List1']['rownum'] = $this->_sections['List1']['iteration'];
$this->_sections['List1']['index_prev'] = $this->_sections['List1']['index'] - $this->_sections['List1']['step'];
$this->_sections['List1']['index_next'] = $this->_sections['List1']['index'] + $this->_sections['List1']['step'];
$this->_sections['List1']['first']      = ($this->_sections['List1']['iteration'] == 1);
$this->_sections['List1']['last']       = ($this->_sections['List1']['iteration'] == $this->_sections['List1']['total']);
?>
                 
                 <li><div class="main-cn"><div class="lf-cn"><?php if ($this->_tpl_vars['RealtiveCompareMean'][$this->_sections['List']['index']][$this->_sections['List1']['index']] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['RealtiveCompareMean'][$this->_sections['List']['index']][$this->_sections['List1']['index']], 2, ".", ","); ?>
(x)<?php endif; ?> </div>
                         <div class="rg-cn"><?php if ($this->_tpl_vars['RelativeCompareMeanper'][$this->_sections['List']['index']][$this->_sections['List1']['index']] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['RelativeCompareMeanper'][$this->_sections['List']['index']][$this->_sections['List1']['index']], 0, ".", ","); ?>
%<?php endif; ?></div></div> </li>
                 
                 <?php endfor; endif; ?>
                 
                 
                 
                 </ul>
                 <?php endfor; endif; ?></div>
                 
                 
    </div>
        
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['comparecompany']) ? count($this->_tpl_vars['comparecompany']) : max(0, (int)$this->_tpl_vars['comparecompany']);
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
                    <input type="hidden" id="answer[CCompanies][]" name="answer[CCompanies][]" value="<?php echo $this->_tpl_vars['comparecompany'][$this->_sections['List']['index']]; ?>
"/>
                <?php endfor; endif; ?>
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['comparecompanyname']) ? count($this->_tpl_vars['comparecompanyname']) : max(0, (int)$this->_tpl_vars['comparecompanyname']);
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
                    <input type="hidden" id="answer[CCompanynames][]" name="answer[CCompanynames][]" value="<?php echo $this->_tpl_vars['comparecompanyname'][$this->_sections['List']['index']]; ?>
"/>
                <?php endfor; endif; ?>
                <input type="hidden" name="resetcompany" id="resetcompany">
                <input type="hidden" id="answerYear" name="answer[Year]" value="<?php echo $this->_tpl_vars['comparecompanyyear']; ?>
"/>
                <input type="hidden" name="answer[CCompanies][]" id="comp_3" disabled>
                <input type="hidden" name="answer[CCompanynames][]" id="compname_3" disabled>
 
    </div>
    

    <?php if ($this->_tpl_vars['CompareResults']): ?>
    <div class="chart-cnt">
    <h3><span>[+]</span>  VIEW CHART</h3>
        
        <div class="show-chart">
            <!-- Chart Part Starts -->
            <?php include "piechartphpgoogle.php" ?>
		<div style="clear:both;">&nbsp;</div>
            <?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include('chart/comparechart.tpl', array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
        <!-- Chart Parts Ends -->
            <div id="optnlIncome"></div>
            <div id="EBITDA"></div>
            <div id="PAT"></div>
        </div>
    </div>
    
    <?php endif; ?>
    </form>
    <form name="Frm_Compare" id="Frm_Compare" action="comparers.php" method="post" enctype="multipart/form-data">
            <input type="hidden" name="exportenable" id="exportenable" value="0"/>
            <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['CompareResults']) ? count($this->_tpl_vars['CompareResults']) : max(0, (int)$this->_tpl_vars['CompareResults']);
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
                    <input type="hidden" id="answer[CCompanies][]" name="answer[CCompanies][]" value="<?php echo $this->_tpl_vars['comparecompany'][$this->_sections['List']['index']]; ?>
"/>
            <?php endfor; endif; ?>
            <input type="hidden" id="answer[Year]" name="answer[Year]" value="<?php echo $this->_tpl_vars['comparecompanyyear']; ?>
"/>
            <div class="btn-cnt p10"><input name="exportcompare" id="exportcompare" type="submit" value="EXPORT" /></div>
    </form>
    
    
    <?php endif; ?>
</div>


<?php echo '
<script type="text/javascript">

$("#compare-btn").hide();  

$("#add-company").click(function () {
$("#add-company-btn").hide();  
$("#compare-btn").show(); 
});

$("#compare").click(function () {
$("#add-company-btn").show();  
$("#compare-btn").hide(); 
});

$(".show-chart").hide(); 
$(".chart-cnt h3").click(function () {
    $(this).next(".show-chart").slideToggle("fast");
    var text = $(this).find(\'span\').text();
    $(this).find(\'span\').text(text == " [-] " ? " [+] " : " [-] ");
});
 

</script>

'; ?>


</body>
</html>