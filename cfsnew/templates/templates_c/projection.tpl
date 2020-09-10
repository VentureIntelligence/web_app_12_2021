<?php /* Smarty version 2.5.0, created on 2019-07-12 11:30:04
         compiled from projection.tpl */ ?>
<?php $this->_load_plugins(array(
array('modifier', 'count', 'projection.tpl', 143, false),
array('modifier', 'number_format', 'projection.tpl', 215, false),)); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("leftpanel.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<?php echo '
  
   <script>
       
          $(document).ready(function() {
        
      
        $.urlParam = function(name){
            var results = new RegExp(\'[\\\\?&]\' + name + \'=([^&#]*)\').exec(window.location.href);
            return results[1] || 0;
        }
        $(\'#pgLoading\').show();
        var vcid=$.urlParam(\'vcid\');
        //alert(vcid);
	var ccur1 = \'INR\';
	var str = \'c\';
        
	$.get("ajaxmilliCurrency2.php", {queryString: ""+ccur1+"",vcid:""+vcid+"",rconv:""+str+""}, function(data){
			$(\'#result\').html(data);
			$(\'.displaycmp\').hide();
                        $(\'#stMsg\').hide();
			resetfoundation();
                        
                        $(\'.companies-details\').show();
                        $(\'#pgLoading\').hide();
	});

});

    function projectdisplay(){
        $(\'#pgLoading\').show();
	var projvcid = jQuery(\'#projvcid\').val();
	var noofyear = jQuery(\'#noofyear\').val();
	var CAGR = jQuery(\'#CAGR\').val();
	var projnext = jQuery(\'#projnext\').val();
        var ccur1 = $(\'#ccur\').val();
        var convr = $(\'#currencytype\').val();
        /*if(ccur1 ==\'INR\'){
             var convr = \'c\';
        }
        else
        {
            var convr = \'m\';
        }*/
	//alert(projvcid+","+noofyear+","+CAGR+","+projnext);
	jQuery.get("ajaxCAGR.php", {queryString: ""+ccur1+"",rconv:""+convr+"",vcid: ""+projvcid+"",noofyear:""+noofyear+"",CAGR:""+CAGR+"",projnext:""+projnext+""}, function(data){
		jQuery(\'#result\').html(data);
		jQuery(\'.displaycmp\').hide();
                resetfoundation();
		//alert(data);
                $(\'#pgLoading\').hide();
	});
}
function millconversion(str,vcid){
    //alert(str + "," +vcid);
         $(\'#pgLoading\').show();
	var noofyear = jQuery(\'#noofyear\').val();
	var CAGR = jQuery(\'#CAGR\').val();
	var projnext = jQuery(\'#projnext\').val();
	var ccur1 = $(\'#ccur\').val();
        /*$(\'#stMsg\').show();
        $(\'#stMsg\').html(\'Please wait while we load values....\');*/
       
	if(ccur1 ==\'-- select currency --\'){
		ccur1 = \'INR\';
	}
        
	$.get("ajaxmilliCurrency2.php", {queryString: ""+ccur1+"",vcid:""+vcid+"",rconv:""+str+"",noofyear:""+noofyear+"",CAGR:""+CAGR+"",projnext:""+projnext+""}, function(data){
			$(\'#result\').html(data);
			$(\'.displaycmp\').hide();
                        //$(\'#stMsg\').hide();
			resetfoundation();
                        $(\'#pgLoading\').hide();
		});
}
function currencyconvert(inputString,vcid){
    $(\'#pgLoading\').show();
    var noofyear = jQuery(\'#noofyear\').val();
    var CAGR = jQuery(\'#CAGR\').val();
    var projnext = jQuery(\'#projnext\').val();
    //var ccur1 = $(\'#currencytype\').val();
    if(inputString ==\'INR\'){
             var ccur1 = \'c\';
    }
        else
        {
            var ccur1 = \'m\';
        }

    /*$(\'#stMsg\').show();
    $(\'#stMsg\').html(\'Please wait while we load values....\');*/
       
        //alert(ccur1+","+yoyr+","+inputString);
	$.get("ajaxcurr2.php", {queryString: ""+inputString+"",vcid:""+vcid+"",rconv:""+ccur1+"",noofyear:""+noofyear+"",CAGR:""+CAGR+"",projnext:""+projnext+""}, function(data){
			$(\'#result\').html(data);
			$(\'.displaycmp\').hide();
                        //$(\'#stMsg\').hide();
                        resetfoundation();
                        $(\'#pgLoading\').hide();
			//alert(data);
		});
}
function resetfoundation()
{
$(document).foundation();
$(".multi-select").dropdownchecklist(\'destroy\');
$(".multi-select").dropdownchecklist({emptyText: "Please select ...",
onItemClick: function(checkbox, selector){
var justChecked = checkbox.prop("checked");
var checkCount = (justChecked) ? 1 : -1;
for( i = 0; i < selector.options.length; i++ ){
if ( selector.options[i].selected ) checkCount += 1;
}
if ( checkCount > 3 ) {
alert( "Limit is 3" );
throw "too many";
}
}
});
}
</script>

'; ?>

<div class="container-right">
<?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("filters.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>

<div class="list-tab cfsDeatilPage">
<ul>
<li><a class="postlink" href="home.php"><i class="i-grid-view"></i> LIST VIEW</a></li>
<li><a href="details.php?vcid=<?php echo $this->_tpl_vars['VCID']; ?>
" class="active postlink"><i class="i-detail-view"></i> DETAIL VIEW</a></li>
</ul>
</div>

<div class="companies-details" style="display:none;">
<div class="detailed-title-links"> <h2><?php echo $this->_tpl_vars['FCompanyName']; ?>
 - <?php echo $this->_tpl_vars['SCompanyName']; ?>
 </h2> 
    
    
    
    
     <?php if ($this->_tpl_vars['prevKey'] != '-1'): ?><a class="previous postlink" id="previous" href="projectionall.php?vcid=<?php echo $this->_tpl_vars['prevNextArr'][$this->_tpl_vars['prevKey']]; ?>
">< Previous</a><?php endif; ?>
    <?php if ($this->_run_mod_handler('count', false, $this->_tpl_vars['prevNextArr']) > $this->_tpl_vars['nextKey']): ?><a class="next postlink" id="next" href="projectionall.php?vcid=<?php echo $this->_tpl_vars['prevNextArr'][$this->_tpl_vars['nextKey']]; ?>
"> Next > </a><?php endif; ?>
    <!--a class="previous" href="javascript:;">Previous</a> <a class="next" href="javascript:;">Next</a--> </div>


<div class="finance-cnt" id="result">

<div class="title-table"><h3>PROJECTION</h3> <a class="postlink" href="details.php?vcid=<?php echo $this->_tpl_vars['VCID']; ?>
">Back to details</a></div>
<div id="stMsg"></div>
<div class="project-filter projectionDetails">  
    <input type="hidden" name="projvcid" id="projvcid" value="<?php echo $this->_tpl_vars['VCID']; ?>
"/>
<div class="left-cnt" ><label>Take CAGR of past</label><select name="noofyear" id="noofyear"><option value="0">None</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>
    <label>CAGR % </label>  <input  type="text" name="CAGR" id="CAGR" value="" placeholder="Enter Percentage" /> </select> 
    <label>Project for</label><select name="projnext" id="projnext"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select> 
    <input type="button" name="projection" id="projection" onclick="javascript:projectdisplay()" value="Project Now" /> 
    </div>
    

    <div class="right-cnt">
        <label>Currency</label>  <select onChange="javascript:currencyconvert(this.value,<?php echo $this->_tpl_vars['VCID']; ?>
)" name="ccur" id="ccur">
        <option>-- select currency --</option>
        <option value="GBP">British Pound GBP</option>
        <option value="EUR">Euro EUR</option>
        <option value="USD">US Dollar USD</option>
        <option value="JPY">Japanese Yen JPY</option>
        <option value="CNY">Chinese Yuan CNY</option>
        <option value="AUD">Australian Dollar AUD</option>
        <option value="CHF">Swiss Franc CHF</option>
        <option value="CAD">Canadian Dollar CAD</option>
        <option value="THB">Thai Baht THB</option>
        <option value="INR" selected="selected">Indian Rupee INR</option>
        <option value="IDR">Indonesian Rupiah IDR</option>
        <option value="HKD">Hong Kong Dollar HKD</option>
    </select>  
        
        <label>Show in</label>   <select name="currencytype" id="currencytype" onchange="javascript:millconversion(this.value,<?php echo $this->_tpl_vars['VCID']; ?>
);">
        <option value='c'>Crores</option>
        <option value='r'>Actual Value</option>
        <option value='m'>Millions</option>
    </select> </div>

</div>

<div class="projection-cnt">
<div class="projection-cnt">
<div class="compare-companies">
<ul  class="operations-list">
<li><h4>OPERATIONS</h4></li>
<li class="fontb">Operational Income</li>
<li class="fontb">Other Income</li>
<li class="fontb">Total Income</li>
<li><span  data-tooltip="" title="Operating,Admministrative & Other Expenses">Ope,Ad&Other</span></li>
<li>Operating Profit</li>
<li class="fontb">EBITDA</li>
<li>Interest</li>
<li class="fontb">EBDT</li>
<li>Depreciation</li>
<li class="fontb">EBT</li>
<li>Tax</li>
<li class="fontb">PAT</li>
<li class="fontb"><b>EPS</b></li>
<li>Basic INR</li>
<li>Diluted INR</li>
<li>&nbsp;</li> 
<li>&nbsp;</li>
<li class="fonts">Employee Related Expenses</li>
<li class="fonts">Foreign Exchange EarningandOutgo</li>
<li class="fonts">Earningin Foreign Exchange</li>
<li class="fonts">Outgoin Foreign Exchange</li>
</ul>
<div class="compare-scroll" style="">
<div style=""><?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual']) ? count($this->_tpl_vars['FinanceAnnual']) : max(0, (int)$this->_tpl_vars['FinanceAnnual']);
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
?><ul>
<li><h4>FY <?php echo $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['FY']; ?>
</h4></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OptnlIncome'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OptnlIncome'], 0, ".", ","); ?>
<?php endif; ?></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OtherIncome'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OtherIncome'], 0, ".", ","); ?>
<?php endif; ?></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['TotalIncome'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['TotalIncome'], 0, ".", ","); ?>
<?php endif; ?></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OptnlAdminandOthrExp'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OptnlAdminandOthrExp'], 0, ".", ","); ?>
<?php endif; ?></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OptnlProfit'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OptnlProfit'], 0, ".", ","); ?>
<?php endif; ?></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EBITDA'] == 0): ?><?php else: ?>-<?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EBITDA'], 0, ".", ","); ?>
<?php endif; ?></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['Interest'] == 0): ?><?php else: ?>-<?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['Interest'], 0, ".", ","); ?>
<?php endif; ?></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EBDT'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EBDT'], 0, ".", ","); ?>
<?php endif; ?></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['Depreciation'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['Depreciation'], 0, ".", ","); ?>
<?php endif; ?></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EBT'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EBT'], 0, ".", ","); ?>
<?php endif; ?></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['Tax'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['Tax'], 0, ".", ","); ?>
<?php endif; ?></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['PAT'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['PAT'], 0, ".", ","); ?>
<?php endif; ?></li>
<li><?php if ($this->_sections['List']['last']): ?>&nbsp;<?php endif; ?></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['BINR'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['BINR'], 0, ".", ","); ?>
<?php endif; ?></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['DINR'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['DINR'], 0, ".", ","); ?>
<?php endif; ?></li>
<li>&nbsp;</li>
<li>&nbsp;</li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EmployeeRelatedExpenses'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EmployeeRelatedExpenses'], 0, ".", ","); ?>
<?php endif; ?></li>
<li><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['ForeignExchangeEarningandOutgo'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['ForeignExchangeEarningandOutgo'], 0, ".", ","); ?>
<?php endif; ?></li>
<li> <?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EarninginForeignExchange'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EarninginForeignExchange'], 0, ".", ","); ?>
<?php endif; ?></li>
<li> <?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OutgoinForeignExchange'] == 0): ?>-<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OutgoinForeignExchange'], 0, ".", ","); ?>
<?php endif; ?></li>
</ul><?php endfor; endif; ?></div>
 
</div>

</div>  
</div>
</div>

<!--div class="btn-cnt p10"><input name="" type="button" value="EXPORT" /></div-->

  </div> 
</div>

</div>


 