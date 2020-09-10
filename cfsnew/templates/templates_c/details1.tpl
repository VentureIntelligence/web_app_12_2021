<?php /* Smarty version 2.5.0, created on 2014-02-05 05:13:24
         compiled from details1.tpl */ ?>
<?php $this->_load_plugins(array(
array('modifier', 'count', 'details1.tpl', 196, false),
array('modifier', 'number_format', 'details1.tpl', 317, false),
array('function', 'math', 'details1.tpl', 713, false),)); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
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
<!--<script src="http://foundation.zurb.com/docs/assets/vendor/custom.modernizr.js"></script>-->
<script type="text/javascript">
   
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
        
	$.get("ajaxmilliCurrency1.php", {queryString: ""+ccur1+"",vcid:""+vcid+"",rconv:""+str+""}, function(data){
			$(\'#result\').html(data);
			$(\'.displaycmp\').hide();
                        $(\'#stMsg\').hide();
			resetfoundation();
                        
                        $(\'.companies-details\').show();
                        $(\'#pgLoading\').hide();
	});
        
        /* $("#cagr").click(function() {
        alert("ddddddddddddddddd");
        //$("#ccur").attr("disabled",true);
    });*/

});

function millconversion(str,vcid){
    //alert(str + "," +vcid);
        $(\'#pgLoading\').show();
	var ccur1 = $(\'#ccur\').val();
        var yoy1= $(\'#yoy\').val();
        var yoy2= $(\'#cagr\').val();
        if(yoy1 !=\'\')
        {
             yoyr=yoy1;
        }
        else
        {
             yoyr=yoy2;
        }
	if(ccur1 ==\'-- select currency --\'){
		ccur1 = \'INR\';
	}
        
	$.get("ajaxmilliCurrency.php", {queryString: ""+ccur1+"",vcid:""+vcid+"",rconv:""+str+"",yoy:""+yoyr+""}, function(data){
			$(\'#result\').html(data);
			$(\'.displaycmp\').hide();
                        $(\'#stMsg\').hide();
			resetfoundation();
                        $(\'#pgLoading\').hide();
		});
}
function currencyconvert(inputString,vcid){
    //alert("ddddddddddddddd");
    $(\'#pgLoading\').show();
    if(inputString ==\'INR\')
    { 
         var ccur1 = \'c\';
    }
    else
    {
        var ccur1 = \'m\';
    }
        var yoy1= $(\'#yoy\').val();
        var yoy2= $(\'#cagr\').val();
        if(yoy1 !=\'\')
        {
             yoyr=yoy1;
        }
        else
        {
             yoyr=yoy2;
        }
        //alert(ccur1+","+yoyr+","+inputString);
	$.get("ajaxCurrency.php", {queryString: ""+inputString+"",vcid:""+vcid+"",rconv:""+ccur1+"",yoy:""+yoyr+""}, function(data){
			$(\'#result\').html(data);
			$(\'.displaycmp\').hide();
                        $(\'#stMsg\').hide();
                        resetfoundation();
                        $(\'#pgLoading\').hide();
			//alert(data);
		});
}
function valueconversion(inputString1,vcid1){
  
    $(\'#pgLoading\').show();
    var ccur1 = $(\'#currencytype\').val();
    //alert(ccur1);
    var inputString= $(\'#ccur\').val();
        var yoy1= $(\'#yoy\').val();
        var yoy2= $(\'#cagr\').val();
        if(yoy1 !=\'\')
        {
             yoyr=yoy1;
        }
        else
        {
             yoyr=yoy2;
        }
	$.get("ajaxGrowth.php", {queryString: ""+inputString+"",queryString1: ""+inputString1+"",vcid:""+vcid1+"",rconv:""+ccur1+"",yoy:""+yoyr+""}, function(data){
			$(\'#result\').html(data);
			$(\'.displaycmp\').hide();
                        $(\'#stMsg\').hide();
                        resetfoundation();
                        $(\'#pgLoading\').hide();
			//alert(data);
		});
}
function projectdisplay(){
        $(\'#pgLoading\').show();
	var projvcid = $(\'#projvcid\').val();
	var noofyear = $(\'#noofyear\').val();
	var CAGR = $(\'#CAGR\').val();
	var projnext = $(\'#projnext\').val();
	//alert(projvcid);
	$.get("ajaxCAGR.php", {vcid: ""+projvcid+"",noofyear:""+noofyear+"",CAGR:""+CAGR+"",projnext:""+projnext+""}, function(data){
		$(\'#result\').html(data);
		$(\'.displaycmp\').hide();
                resetfoundation();
                $(\'#pgLoading\').hide();
		//alert(data);
	});
}
function check(newLink)
{
	location.href= newLink; //document.getElementById("google-link").value; //  "http://www.yahoo.com/";
	return false;	// so important
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
<div style="overflow: hidden;">
 <div class="btn-cnt p10" style="float:right;">
    <?php if ($this->_tpl_vars['PLSTANDARD_MEDIA_PATH']): ?>

           <input  name="" type="button" value="Standard P&L EXPORT" onClick="window.location.href='downloadtrack.php?vcid=<?php echo $this->_tpl_vars['Company_Id']; ?>
'" />
        <!--a href="downloadtrack.php?vcid=<?php echo $this->_tpl_vars['Company_Id']; ?>
" target="popup" onclick="MyWindow=window.open('downloadtrack.php?vcid=<?php echo $this->_tpl_vars['Company_Id']; ?>
','popup','scrollbars=1,width=200,height=150,status=0,toolbar=no,menubar=no,location=0');MyWindow.focus(top);return false" >Click Here</a></div-->
    <?php endif; ?>	
    <?php if ($this->_tpl_vars['PLDETAILED_MEDIA_PATH']): ?>

        <input  name="" type="button" value="Detailed P&L EXPORT" onClick="window.location.href='<?php echo $this->_tpl_vars['MEDIA_PATH']; ?>
pldetailed/PLDetailed_<?php echo $this->_tpl_vars['VCID']; ?>
.xls'" />
            <!--div>&nbsp;</div><div class="anchorblue">To download Detailed P&L   :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="<?php echo $this->_tpl_vars['MEDIA_PATH']; ?>
pldetailed/PLDetailed_<?php echo $this->_tpl_vars['VCID']; ?>
.xls">Click Here</a></div-->
    <?php endif; ?>
    <?php if ($this->_tpl_vars['BSHEET_MEDIA_PATH']): ?>	

       <input  name="" type="button" value="BALANCESHEET EXPORT" onClick="window.location.href='<?php echo $this->_tpl_vars['MEDIA_PATH']; ?>
balancesheet/BalSheet_<?php echo $this->_tpl_vars['VCID']; ?>
.xls'" />
    <?php endif; ?>
    <?php if ($this->_tpl_vars['CASHFLOW_MEDIA_PATH']): ?>

            <input  name="" type="button" value="CASHFLOW EXPORT" onClick="window.location.href='<?php echo $this->_tpl_vars['MEDIA_PATH']; ?>
cashflow/Cashflow_<?php echo $this->_tpl_vars['VCID']; ?>
.xls'" />
            <!--div>&nbsp;</div><div class="anchorblue">To download CashFlow :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="<?php echo $this->_tpl_vars['MEDIA_PATH']; ?>
cashflow/Cashflow_<?php echo $this->_tpl_vars['VCID']; ?>
.xls">Click Here</a></div-->
    <?php endif; ?>
</div></div>
<div class="list-tab">
<ul>
<li><a class="postlink" href="home.php"><i></i> LIST VIEW</a></li>
<li><a  href="details.php?vcid=<?php echo $this->_tpl_vars['VCID']; ?>
" class="active postlink"><i class="i-detail-view"></i> DETAIL VIEW</a></li>
</ul>
</div>

<div class="companies-details" style="display:none;">
<div class="detailed-title-links"> <h2><?php echo $this->_tpl_vars['SCompanyName']; ?>
</h2> 
    
    <?php if ($this->_tpl_vars['prevKey'] != '-1'): ?><a class="previous postlink" id="previous" href="details.php?vcid=<?php echo $this->_tpl_vars['prevNextArr'][$this->_tpl_vars['prevKey']]; ?>
">< Previous</a><?php endif; ?>
    <?php if ($this->_run_mod_handler('count', false, $this->_tpl_vars['prevNextArr']) > $this->_tpl_vars['nextKey']): ?><a class="next postlink" id="next" href="details.php?vcid=<?php echo $this->_tpl_vars['prevNextArr'][$this->_tpl_vars['nextKey']]; ?>
"> Next > </a><?php endif; ?>
<!--a class="previous" href="javascript:;">Previous</a> <a class="next" href="javascript:;">Next</a--> </div>


<div class="finance-cnt" id="result">

<div class="title-table"><h3>FINANCIALS</h3> <a class="postlink" href="projectionall.php?vcid=<?php echo $this->_tpl_vars['Company_Id']; ?>
">See Projection</a></div>
<div id="stMsg"></div>
<div class="finance-filter"> <!--form class="custom"-->
<div class="left-cnt"> 
    <label> <input type="radio" name="yoy" id="yoy" value="V" onChange="javascript:valueconversion('V',<?php echo $this->_tpl_vars['VCID']; ?>
);" checked="checked" /> Value</label>
    <label>   <input type="radio" name="yoy" id="cagr" value="G" onChange="javascript:valueconversion('G',<?php echo $this->_tpl_vars['VCID']; ?>
);" /> Growth</label> 
    <select onChange="javascript:currencyconvert(this.value,<?php echo $this->_tpl_vars['VCID']; ?>
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
</div>
<div class="right-cnt"><label>Show in</label>  
    <select name="currencytype" id="currencytype" onchange="javascript:millconversion(this.value,<?php echo $this->_tpl_vars['VCID']; ?>
);">
        <option value='r'>Actual Vlaue</option>
        <option value='m'>Millions</option>
        <option value='c'>Crores</option>
    </select> </div><!--/form-->
</div>
        <?php if (( $this->_tpl_vars['grouplimit'][0][2] >= $this->_tpl_vars['grouplimit'][0][5] )): ?>
<div class="detail-table">
    <div>
        <table  width="100%" border="0" cellspacing="0" cellpadding="0">
            <tHead> 
                <tr>
                    <th>OPERATIONS</th>
                </tr>
            </thead>
            <tbody>  
              <tr>
                <td>Opertnl Income</td>
              </tr>
              <tr>
                <td>Other Income</td>
              </tr>
              <tr>
                <td>Total Income</td>
              </tr>
              <tr>
                <td><span  data-tooltip="" title="Operating,Admministrative & Other Expenses">Ope,Ad&Other</span></td>
              </tr>
              <tr>
                <td>Operating Profit</td>
              </tr>
              <tr>
                <td>EBITDA</td>
              </tr>
              <tr>
                <td>Interest</td>
               </tr>
              <tr>
                <td>EBDT</td>
              </tr>
              <tr>
                <td>Depreciation</td>
              </tr>
              <tr>
                <td>EBT</td>
              </tr>
              <tr>
                <td>Tax</td>
              </tr>
              <tr>
                <td>PAT</td>
              </tr>
              <tr>
                <td><b>EPS</b></td>
              </tr>
              <tr>
                <td>Basic INR</td>
              </tr>
              <tr>
                <td>Diluted INR</td>
               </tr>
              <tr>
                    <td>&nbsp;</td>
              </tr>
              <tr>
                <td>Employee Related Expenses</td>
              </tr>
              <tr>
                <td>Foreign Exchange EarningandOutgo</td>
              </tr>
              <tr>
                <td>Earningin Foreign Exchange</td>
              </tr>
              <tr>
                <td>Outgoin Foreign Exchange</td>
              </tr>

            </tbody>
            </table>
    </div>
    <div>
            <table  width="100%" border="0" cellspacing="0" cellpadding="0">
            <tHead> <tr>
            
            <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
            <th>FY <?php echo $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['FY']; ?>
</th>
            <?php endfor; endif; ?>
            </tr></thead>
            <tbody>  
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OptnlIncome'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OptnlIncome'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                 <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OtherIncome'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OtherIncome'], 0, ".", ","); ?>
<?php endif; ?></td>
                 <?php endfor; endif; ?>
              </tr>
              <tr>
                
                 <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['TotalIncome'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['TotalIncome'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OptnlAdminandOthrExp'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OptnlAdminandOthrExp'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OptnlProfit'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OptnlProfit'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EBITDA'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EBITDA'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['Interest'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['Interest'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EBDT'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EBDT'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['Depreciation'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['Depreciation'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EBT'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EBT'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['Tax'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['Tax'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['PAT'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['PAT'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                 <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td>&nbsp;</td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['BINR'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['BINR'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['DINR'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['DINR'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td>&nbsp;</td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EmployeeRelatedExpenses'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EmployeeRelatedExpenses'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['ForeignExchangeEarningandOutgo'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['ForeignExchangeEarningandOutgo'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EarninginForeignExchange'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['EarninginForeignExchange'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>
              <tr>
                
                <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
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
?>
                    <td><?php if ($this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OutgoinForeignExchange'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['OutgoinForeignExchange'], 0, ".", ","); ?>
<?php endif; ?></td>
                <?php endfor; endif; ?>
              </tr>

            </tbody>
            </table>
    </div>

  </div>
 
</div>
  <div style="font-size: 16px;margin-top: -20px;">
   <a  href="mailto:cfs@ventureintelligence.com?subject=Request for latest financials&body=Please add to the database the financials for the company" >Click here to check for latest financial year availability</a><br><br>
  </div>
   <!--div class="finance-cnt">
    
<?php if ($this->_tpl_vars['FinanceAnnual2'] != '0'): ?>
<sub><b>(Values are in INR)</b></sub>    
<div class="detail-table">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
     <?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['FY'] != '05' && $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['FY'] != '06'): ?>
<tHead> <tr>
<th>SOURCES OF FUNDS</th>
<?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
<th>FY <?php echo $this->_tpl_vars['FinanceAnnual'][$this->_sections['List']['index']]['FY']; ?>
</th>
<?php endfor; endif; ?>
</tr></thead>
<tbody>  
  <tr>
    <td>Shareholders' funds</td>
     <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td>&nbsp;</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Paid-up share capital</td>
     <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['ShareCapital'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['ShareCapital'], 0, ".", ","); ?>
<?php endif; ?></td>
     <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Share application</td>
     <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['ShareApplication'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['ShareApplication'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Reserves & Surplus</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['ReservesSurplus'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['ReservesSurplus'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Shareholders' funds(total)</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['TotalFunds'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['TotalFunds'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Loan funds</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td>&nbsp;</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Secured loans</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['SecuredLoans'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['SecuredLoans'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Unsecured loans</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['UnSecuredLoans'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['UnSecuredLoans'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Loan funds(total)</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['LoanFunds'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['LoanFunds'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Other Liabilities</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['OtherLiabilities'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['OtherLiabilities'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Deferred Tax Liability</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['DeferredTax'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['DeferredTax'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
    <td>TOTAL SOURCES OF FUNDS</td>
     <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['SourcesOfFunds'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['SourcesOfFunds'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
   <tr>
    <td>&nbsp;</td>
     <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td>&nbsp;</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>APPLICATION OF FUNDS</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td>&nbsp;</td>
    <?php endfor; endif; ?>
  </tr>
  
  <tr>
    <td>Fixed assets</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td>&nbsp;</td>
    <?php endfor; endif; ?>
  </tr>
 
  <tr>
    <td>Gross Block</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['GrossBlock'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['GrossBlock'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Less : Depreciation Reserve</td>
   <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['LessAccumulated'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['LessAccumulated'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Net Block</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['NetBlock'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['NetBlock'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Add : Capital Work in Progress</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['CapitalWork'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['CapitalWork'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Fixed Assets(total)</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['FixedAssets'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['FixedAssets'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Intangible Assets(total)</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['IntangibleAssets'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['IntangibleAssets'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Other Non-Current Assets</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['OtherNonCurrent'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['OtherNonCurrent'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Investments</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['Investments'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['Investments'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Deferred Tax Assets</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['DeferredTaxAssets'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['DeferredTaxAssets'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Current Assets, Loans & Advances</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td>&nbsp;</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Sundry Debtors</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['SundryDebtors'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['SundryDebtors'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Cash & Bank Balances</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['CashBankBalances'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['CashBankBalances'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Inventories</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['Inventories'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['Inventories'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Loans & Advances</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['LoansAdvances'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['LoansAdvances'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Other Current Assets</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['OtherCurrentAssets'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['OtherCurrentAssets'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Current Assets, Loans & Advances(total)</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['CurrentAssets'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['CurrentAssets'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Current Liabilities & Provisions</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td>&nbsp;</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Current Liabilities</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['CurrentLiabilities'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['CurrentLiabilities'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Provisions</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['Provisions'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['Provisions'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Current Liabilities & Provisions(total)</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['CurrentLiabilitiesProvision'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['CurrentLiabilitiesProvision'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Net Current Assets</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['NetCurrentAssets'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['NetCurrentAssets'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Profit & Loss Account</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['ProfitLoss'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['ProfitLoss'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Miscellaneous Expenditure</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['Miscellaneous'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['Miscellaneous'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>TOTAL APPLICATION OF FUNDS</td>
    <?php if (isset($this->_sections['List'])) unset($this->_sections['List']);
$this->_sections['List']['name'] = 'List';
$this->_sections['List']['loop'] = is_array($this->_tpl_vars['FinanceAnnual1']) ? count($this->_tpl_vars['FinanceAnnual1']) : max(0, (int)$this->_tpl_vars['FinanceAnnual1']);
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
        <td><?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['TotalAssets'] == 0): ?>&nbsp;<?php else: ?><?php echo $this->_run_mod_handler('number_format', true, $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['TotalAssets'], 0, ".", ","); ?>
<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  
</tbody>
 <?php endif; ?>
  </table></div>
 <?php endif; ?>
 
 <?php if ($this->_tpl_vars['RatioCalculation1'] != '0'): ?>
     <div class="detail-table">
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
     <?php if ($this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['FY'] != '05' && $this->_tpl_vars['FinanceAnnual1'][$this->_sections['List']['index']]['FY'] != '06'): ?>
<tHead> <tr>
<th>Ratio Names</th>
<?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
<th>FY <?php echo $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['FY']; ?>
</th>
<?php endfor; endif; ?>
</tr></thead>
<tbody>  
  <tr>
    <td>Current Ratio</td>
     <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "((x + y + z)/a)",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['SundryDebtors'],'y' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['CashBankBalances'],'z' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['Inventories'],'a' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['CurrentLiabilities'],'format' => "%.3f"), $this) ; ?>
</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Quick Ratio</td>
     <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "((x + y)/a)",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['SundryDebtors'],'y' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['CashBankBalances'],'a' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['CurrentLiabilities'],'format' => "%.3f"), $this) ; ?>
</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>RoE</td>
     <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x/a)",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['PAT'],'a' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalFunds'],'assign' => 'value3'), $this) ; ?>
<?php if ($this->_tpl_vars['value3'] == ''): ?>&nbsp;<?php endif; ?></td>
     <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>RoCE</td>
     <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "((x + y)/a)",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['EBT'],'y' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['Interest'],'a' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['SourcesOfFunds'],'format' => "%.3f",'assign' => 'value4'), $this) ; ?>
<?php if ($this->_tpl_vars['value4'] == ''): ?>&nbsp;<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>RoA</td>
    <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x/a)",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['PAT'],'a' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalAssets'],'format' => "%.3f"), $this) ; ?>
</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Cash Turnover Ratio</td>
    <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x/((a+a)/2))",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalIncome'],'a' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['CashBankBalances'],'format' => "%.3f"), $this) ; ?>
</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Debtor Turnover Ratio</td>
    <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x/((a+a)/2))",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalIncome'],'a' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['SundryDebtors'],'format' => "%.3f"), $this) ; ?>
</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Days Sale</td>
    <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "(365/(x/((a+a)/2)))",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalIncome'],'a' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['SundryDebtors'],'format' => "%.3f"), $this) ; ?>
</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Inventory Turnover Ratio</td>
    <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x/((a+a)/2))",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalIncome'],'a' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['Inventories'],'format' => "%.3f"), $this) ; ?>
</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Days Inventory</td>
    <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "(365/(x/((a+a)/2)))",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalIncome'],'a' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['Inventories'],'format' => "%.3f"), $this) ; ?>
</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Working Capital Turnover Ratio</td>
    <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x/(((a+b+c)-d)+((a+b+c)-d)/2))",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalIncome'],'a' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['SundryDebtors'],'b' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['CashBankBalances'],'c' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['Inventories'],'d' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['CurrentLiabilities'],'format' => "%.3f"), $this) ; ?>
</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Total Asset Turnover Ratio</td>
    <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x/((a+a)/2))",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalIncome'],'a' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalAssets'],'format' => "%.3f"), $this) ; ?>
</td>
    <?php endfor; endif; ?>
  </tr>
    <td>Fixed Asset Turnover Ratio</td>
     <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x/((a+a)/2))",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalIncome'],'a' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['FixedAssets'],'format' => "%.3f"), $this) ; ?>
</td>
    <?php endfor; endif; ?>
  </tr>
   <tr>
    <td>EBITDA Margin</td>
     <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x/y)",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['EBITDA'],'y' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalIncome'],'format' => "%.3f"), $this) ; ?>
</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>EBIT Margin</td>
    <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "((x+y)/z)",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['EBT'],'y' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['Interest'],'z' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalIncome'],'format' => "%.3f",'assign' => 'value15'), $this) ; ?>
<?php if ($this->_tpl_vars['value15'] == ''): ?>&nbsp;<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  
  <tr>
    <td>PAT Margin</td>
    <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x/y)",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['PAT'],'y' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalIncome'],'format' => "%.3f"), $this) ; ?>
</td>
    <?php endfor; endif; ?>
  </tr>
 
  <tr>
    <td>Employee Remuneration</td>
   <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x/y)",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['EmployeeRelatedExpenses'],'y' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['OptnlIncome'],'format' => "%.3f",'assign' => 'value17'), $this) ; ?>
<?php if ($this->_tpl_vars['value17'] == ''): ?>&nbsp;<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Debt Equity Ratio</td>
   <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "(x/y)",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['SourcesOfFunds'],'y' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['TotalFunds'],'format' => "%.3f"), $this) ; ?>
</td>
    <?php endfor; endif; ?>
  </tr>
  <tr>
    <td>Interest Coverage</td>
    <?php if (isset($this->_sections['List1'])) unset($this->_sections['List1']);
$this->_sections['List1']['name'] = 'List1';
$this->_sections['List1']['loop'] = is_array($this->_tpl_vars['RatioCalculation']) ? count($this->_tpl_vars['RatioCalculation']) : max(0, (int)$this->_tpl_vars['RatioCalculation']);
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
        <td><?php echo $this->_plugins['function']['math'][0](array('equation' => "((x+y)/z)",'x' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['EBT'],'y' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['Interest'],'z' => $this->_tpl_vars['RatioCalculation'][$this->_sections['List1']['index']]['Interest'],'format' => "%.3f",'assign' => 'value19'), $this) ; ?>
<?php if ($this->_tpl_vars['value19'] == ''): ?>&nbsp;<?php endif; ?></td>
    <?php endfor; endif; ?>
  </tr>
  
</tbody>
 <?php endif; ?>
  </table></div>
     <?php endif; ?>
     
   </div-->
  <div class="finance-cnt postContainer postContent masonry-container">
      <?php if ($this->_tpl_vars['searchResults']): ?>
    <div  class="work-masonry-thumb col-3" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
    <h2>FILINGS <a class="postlink" href="viewfiling.php?c=<?php echo $this->_tpl_vars['encodedcompany']; ?>
&cid=<?php echo $this->_tpl_vars['Company_Id']; ?>
"> View all</a></h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="tableview download-links">
    <thead><tr><th>File Name </th> <th>Date</th></tr></thead>
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
             <?php if ($this->_sections['customer']['index'] < 5): ?>
        <tr><td style="alt"><?php echo $this->_tpl_vars['searchResults'][$this->_sections['customer']['index']]['name']; ?>
</td>
            <td> <?php echo $this->_tpl_vars['searchResults'][$this->_sections['customer']['index']]['uploaddate']; ?>
 </td>    </tr>  
        <?php endif; ?>
        <?php endfor; endif; ?>
    </tbody>
    </table> 
    </div>
       <?php endif; ?>  
         
      <div  class="work-masonry-thumb col-4" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
    <h2>  COMPANY PROFILE</h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="company-profile-table"> 
    <tbody>
    <tr>
        <?php if ($this->_tpl_vars['CompanyProfile']['IndustryName'] != ""): ?>
            <td >Industry	
            <span><?php echo $this->_tpl_vars['CompanyProfile']['IndustryName']; ?>
</span> </td>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['CompanyProfile']['AddressHead'] != ""): ?>
            <td> Address
            <span><?php echo $this->_tpl_vars['CompanyProfile']['AddressHead']; ?>
</span> </td>
        <?php endif; ?>   
        <?php if ($this->_tpl_vars['CompanyProfile']['Phone'] != ""): ?>
            <td> Telephone
            <span><?php echo $this->_tpl_vars['CompanyProfile']['Phone']; ?>
</span></td> 
        <?php endif; ?>
   </tr> 
   <tr>
        <?php if ($this->_tpl_vars['CompanyProfile']['SectorName'] != ""): ?>
        <td> Sector
        <span><?php echo $this->_tpl_vars['CompanyProfile']['SectorName']; ?>
</span> </td>
        <?php endif; ?>
        <?php if ($this->_tpl_vars['CompanyProfile']['city_name'] != ""): ?>
        <td> City
        <span><?php echo $this->_tpl_vars['CompanyProfile']['city_name']; ?>
</span> </td>
        <?php endif; ?>      
        <?php if ($this->_tpl_vars['CompanyProfile']['Email'] != ""): ?>
        <td> Email
        <span><?php echo $this->_tpl_vars['CompanyProfile']['Email']; ?>
</span></td> 
        <?php endif; ?>
   </tr>  
   <tr>
        <?php if ($this->_tpl_vars['CompanyProfile']['IncorpYear'] != ""): ?>
            <td> Year Founded 
            <span><?php echo $this->_tpl_vars['CompanyProfile']['IncorpYear']; ?>
</span></td> 
        <?php endif; ?>
        <?php if ($this->_tpl_vars['CompanyProfile']['Country_Name'] != ""): ?>
            <td> Country
            <span><?php echo $this->_tpl_vars['CompanyProfile']['Country_Name']; ?>
</span> </td>
       <?php endif; ?>
       <?php if ($this->_tpl_vars['CompanyProfile']['Website'] != ""): ?>
            <td> website
                <span><a href="<?php echo $this->_tpl_vars['CompanyProfile']['Website']; ?>
" target="_blank"><?php echo $this->_tpl_vars['CompanyProfile']['Website']; ?>
</a></span>
            </td> 
       <?php endif; ?>
    </tr>  
    
    <div class="linkedin-bg">
<?php echo '
     <script type="text/javascript" > 
            
            $(document).ready(function () {
        $(\'#lframe,#lframe1\').on(\'load\', function () {
//            $(\'#loader\').hide();
            
        });
            });
            
function autoResize(id){
    var newheight;
    var newwidth;

    if(document.getElementById){
        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
    }

    document.getElementById(id).height= (newheight) + "px";
    document.getElementById(id).width= (newwidth) + "px";
}
 </script>

        <script type="text/javascript" src="http://platform.linkedin.com/in.js">
        api_key:65623uxbgn8l
        onLoad: onLinkedInLoad
        </script>
        <script type="text/javascript" > 
        var idvalue;
         //document.getElementById("sa").textContent=\'asdasdasd\'; 
        function onLinkedInLoad() {
           var profileDiv = document.getElementById("sample");

               var url = \'/companies?email-domain='; ?>
<?php echo $this->_tpl_vars['companylinkedIn']; ?>
<?php echo '\';
             
                console.log(url);
            
                IN.API.Raw(url).result(function(response) {   

                    console.log(response);
                    //var id = response.id;
                   // alert(id);
                    console.log(response._total);
                    var arrayValues=response.values;
                    console.log(arrayValues);

                    var value=arrayValues[0];
                    console.log(value);
                    console.log(value.id);
                    console.log(value.name);
                    idvalue=value.id;
                    if(idvalue)
                        {
                    //$(\'#dataId\').val(idvalue);
                    //var inHTML = \'<script type="IN/CompanyProfile" data-id="\'+idvalue+\'" data-format="inline"></\'+\'script>\';
                   var inHTML=\'loadlinkedin.php?data_id=\'+idvalue;
                    var inHTML2=\'linkedprofiles.php?data_id=\'+idvalue;
                    $(\'#lframe\').attr(\'src\',inHTML);
                    $(\'#lframe1\').attr(\'src\',inHTML2);
                    }
                    else
                        {
                             $(\'#lframe\').hide();
                             $(\'#lframe1\').hide();
                             $(\'#loader\').hide();
                        }
                        
                    //  profileDiv.innerHtml=inHTML;
                    //document.getElementById(\'sa\').innerHTML=\'<script type="IN/CompanyProfile" data-id="\'+idvalue+\'" data-format="inline"></\'+\'script>\';
                }).error( function(error){
                    
                   $(\'#lframe\').hide();
                   $(\'#lframe1\').hide();
                   $(\'#loader\').hide(); });
          }


        </script>
        '; ?>

   

    <input type="hidden" name="dataId" id="dataId" >
   
 </div>
        
        <tr><td colspan="3">  <div  id="sample" style="padding:10px 10px 0 0;" class="fl">
        
        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="220"></iframe>
    </div> <div class="fl" style="padding:10px 10px 0 0;" ><iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="300" ></iframe></div> </td>    </tr>
    </tbody>
    </table> 
    </div>  
    
     <?php if ($this->_tpl_vars['industry2']): ?>                                              
    <div  class="work-masonry-thumb col-3" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
    <h2>SIMILAR COMPANIES <a href="home.php?industryId=<?php echo $this->_tpl_vars['industry1']; ?>
"> View all</a></h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
    <thead><tr><th>Company Name</th><th>Location</th> </tr></thead>
    <tbody>
      
            <?php if (isset($this->_sections['company'])) unset($this->_sections['company']);
$this->_sections['company']['name'] = 'company';
$this->_sections['company']['loop'] = is_array($this->_tpl_vars['industry2']) ? count($this->_tpl_vars['industry2']) : max(0, (int)$this->_tpl_vars['industry2']);
$this->_sections['company']['show'] = true;
$this->_sections['company']['max'] = $this->_sections['company']['loop'];
$this->_sections['company']['step'] = 1;
$this->_sections['company']['start'] = $this->_sections['company']['step'] > 0 ? 0 : $this->_sections['company']['loop']-1;
if ($this->_sections['company']['show']) {
    $this->_sections['company']['total'] = $this->_sections['company']['loop'];
    if ($this->_sections['company']['total'] == 0)
        $this->_sections['company']['show'] = false;
} else
    $this->_sections['company']['total'] = 0;
if ($this->_sections['company']['show']):

            for ($this->_sections['company']['index'] = $this->_sections['company']['start'], $this->_sections['company']['iteration'] = 1;
                 $this->_sections['company']['iteration'] <= $this->_sections['company']['total'];
                 $this->_sections['company']['index'] += $this->_sections['company']['step'], $this->_sections['company']['iteration']++):
$this->_sections['company']['rownum'] = $this->_sections['company']['iteration'];
$this->_sections['company']['index_prev'] = $this->_sections['company']['index'] - $this->_sections['company']['step'];
$this->_sections['company']['index_next'] = $this->_sections['company']['index'] + $this->_sections['company']['step'];
$this->_sections['company']['first']      = ($this->_sections['company']['iteration'] == 1);
$this->_sections['company']['last']       = ($this->_sections['company']['iteration'] == $this->_sections['company']['total']);
?>
                <?php if ($this->_sections['company']['index'] < 5): ?>
                  <tr><td style="alt"><a href='details.php?vcid=<?php echo $this->_tpl_vars['industry2'][$this->_sections['company']['index']]['Company_Id']; ?>
' ><?php echo $this->_tpl_vars['industry2'][$this->_sections['company']['index']]['FCompanyName']; ?>
</a></td> <td><?php echo $this->_tpl_vars['industry2'][$this->_sections['company']['index']]['state_name']; ?>
</td></tr>
                  <?php endif; ?>
<?php endfor; endif; ?>
    </tbody>
    </table> 
    </div>
      <?php endif; ?>  
      <?php if ($this->_tpl_vars['directors']): ?> 
        <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
               <h2>BOARD OF DIRECTORS</h2>
               <ul class="board-directors">

                    <?php if (isset($this->_sections['dir'])) unset($this->_sections['dir']);
$this->_sections['dir']['name'] = 'dir';
$this->_sections['dir']['loop'] = is_array($this->_tpl_vars['directors']) ? count($this->_tpl_vars['directors']) : max(0, (int)$this->_tpl_vars['directors']);
$this->_sections['dir']['show'] = true;
$this->_sections['dir']['max'] = $this->_sections['dir']['loop'];
$this->_sections['dir']['step'] = 1;
$this->_sections['dir']['start'] = $this->_sections['dir']['step'] > 0 ? 0 : $this->_sections['dir']['loop']-1;
if ($this->_sections['dir']['show']) {
    $this->_sections['dir']['total'] = $this->_sections['dir']['loop'];
    if ($this->_sections['dir']['total'] == 0)
        $this->_sections['dir']['show'] = false;
} else
    $this->_sections['dir']['total'] = 0;
if ($this->_sections['dir']['show']):

            for ($this->_sections['dir']['index'] = $this->_sections['dir']['start'], $this->_sections['dir']['iteration'] = 1;
                 $this->_sections['dir']['iteration'] <= $this->_sections['dir']['total'];
                 $this->_sections['dir']['index'] += $this->_sections['dir']['step'], $this->_sections['dir']['iteration']++):
$this->_sections['dir']['rownum'] = $this->_sections['dir']['iteration'];
$this->_sections['dir']['index_prev'] = $this->_sections['dir']['index'] - $this->_sections['dir']['step'];
$this->_sections['dir']['index_next'] = $this->_sections['dir']['index'] + $this->_sections['dir']['step'];
$this->_sections['dir']['first']      = ($this->_sections['dir']['iteration'] == 1);
$this->_sections['dir']['last']       = ($this->_sections['dir']['iteration'] == $this->_sections['dir']['total']);
?>
                        <li><a href='bod.php?ID=<?php echo $this->_tpl_vars['directors'][$this->_sections['dir']['index']]['DIN']; ?>
&vcid=<?php echo $this->_tpl_vars['VCID']; ?>
' ><?php echo $this->_tpl_vars['directors'][$this->_sections['dir']['index']][1]; ?>
</a></li>

       <?php endfor; endif; ?>
                    </ul>
               </div> 
      <?php endif; ?> 
      <?php if ($this->_tpl_vars['roc']): ?>
       <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>REGISTERED TRADEMARK</h2>
        <ul class="registered-trade"> 
            <li> REGISTERED TO <br />
<span>
<?php echo $this->_tpl_vars['roc']; ?>

</span></li></ul>
        </div>     
      <?php endif; ?>  
          
         </div>
  </form>
		<?php else: ?>
			<h1>"Your Subscription limit of <?php echo $this->_tpl_vars['grouplimit'][0][2]; ?>
 companies has been reached. Please contact info@ventureintelligence.com to top up your subscription"</h1><br/>
                    <?php endif; ?>
  
</div>

</div>