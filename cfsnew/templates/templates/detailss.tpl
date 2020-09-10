{include file="header.tpl"}
{include file="leftpanel.tpl"}

{literal}
<script type="text/javascript">
function millconversion(str,vcid){
    //alert(str + "," +vcid);
	var ccur1 = $('#ccur').val();
        var yoy1= $('#yoy').val();
        var yoy2= $('#cagr').val();
        if(yoy1 !='')
        {
             yoyr=yoy1;
        }
        else
        {
             yoyr=yoy2;
        }
	if(ccur1 =='-- select currency --'){
		ccur1 = 'INR';
	}
        
	$.get("ajaxmilliCurrency.php", {queryString: ""+ccur1+"",vcid:""+vcid+"",rconv:""+str+"",yoy:""+yoyr+""}, function(data){
			$('#result').html(data);
			$('.displaycmp').hide();
			
		});
}
function currencyconvert(inputString,vcid){
    var ccur1 = $('#currencytype').val();
        var yoy1= $('#yoy').val();
        var yoy2= $('#cagr').val();
        if(yoy1 !='')
        {
             yoyr=yoy1;
        }
        else
        {
             yoyr=yoy2;
        }
        alert(ccur1+","+yoyr+","+inputString);
	$.get("ajaxCurrency.php", {queryString: ""+inputString+"",vcid:""+vcid+"",rconv:""+ccur1+"",yoy:""+yoyr+""}, function(data){
			$('#result').html(data);
			$('.displaycmp').hide();
			//alert(data);
		});
}
function valueconversion(inputString1,vcid1){
    alert(inputString1+","+vcid1)
	$.get("ajaxGrowth.php", {queryString1: ""+inputString1+"",vcid:""+vcid1+""}, function(data){
			$('#result').html(data);
			$('.displaycmp').hide();
			//alert(data);
		});
}
function projectdisplay(){
	var projvcid = $('#projvcid').val();
	var noofyear = $('#noofyear').val();
	var CAGR = $('#CAGR').val();
	var projnext = $('#projnext').val();
	//alert(projvcid);
	$.get("ajaxCAGR.php", {vcid: ""+projvcid+"",noofyear:""+noofyear+"",CAGR:""+CAGR+"",projnext:""+projnext+""}, function(data){
		$('#result').html(data);
		$('.displaycmp').hide();
		//alert(data);
	});
}
function check(newLink)
{
	location.href= newLink; //document.getElementById("google-link").value; //  "http://www.yahoo.com/";
	return false;	// so important
}
</script>
</script>
{/literal}
<div class="container-right">

{include file="filters.tpl"}

<div class="list-tab">
<ul>
<li><a href="home.php"><i></i> LIST VIEW</a></li>
<li><a href="details.php?vcid={$VCID}" class="active"><i></i> DETAIL VIEW</a></li>
</ul>
</div>

<div class="companies-details">
<div class="detailed-title-links"> <h2>{$SCompanyName}</h2> <a class="previous" href="javascript:;">Previous</a> <a class="next" href="javascript:;">Next</a> </div>


<div class="finance-cnt">

<div class="title-table"><h3>FINANCIALS</h3> <a href="projectionall.php?vcid={$Company_Id}">See Projection</a></div>

<div class="finance-filter"> <form class="custom">
<div class="left-cnt"> 
    <label> <input type="radio" name="yoy" id="yoy" value="V" onChange="javascript:valueconversion('V',{$VCID});" checked="checked" /> Value</label>
    <label>   <input type="radio" name="yoy" id="cagr" value="G" onChange="javascript:valueconversion('G',{$VCID});" /> Growth</label> 
    <select onChange="javascript:currencyconvert(this.value,{$VCID})" name="ccur" id="ccur">
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
        <option value="INR">Indian Rupee INR</option>
        <option value="IDR">Indonesian Rupiah IDR</option>
        <option value="HKD">Hong Kong Dollar HKD</option>
    </select> 
</div>
<div class="right-cnt"><label>Show in</label>  
    <select name="currencytype" id="currencytype" onchange="javascript:millconversion(this.value,{$VCID});">
        <option value='r'>Rupees</option>
        <option value='m'>Millions</option>
        <option value='c'>Crores</option>
    </select> </div></form>
</div>

<table id="result" width="100%" border="0" cellspacing="0" cellpadding="0">
<tHead> <tr>
<th>OPERATIONS</th>
{section name=List loop=$FinanceAnnual}
<th>FY {$FinanceAnnual[List].FY}</th>
{/section}
</tr></thead>
<tbody>  
  <tr>
    <td>Opertnl Income</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].OptnlIncome eq 0}&nbsp;{else}{$FinanceAnnual[List].OptnlIncome|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Other Income</td>
     {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].OtherIncome eq 0}&nbsp;{else}{$FinanceAnnual[List].OtherIncome|number_format:0:".":","}{/if}</td>
     {/section}
  </tr>
  <tr>
    <td>Total Income</td>
     {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].TotalIncome eq 0}&nbsp;{else}{$FinanceAnnual[List].TotalIncome|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Ope,Ad&amp;Other</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].OptnlAdminandOthrExp eq 0}&nbsp;{else}{$FinanceAnnual[List].OptnlAdminandOthrExp|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Operating Profit</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].OptnlProfit eq 0}&nbsp;{else}{$FinanceAnnual[List].OptnlProfit|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>EBITDA</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].EBITDA eq 0}&nbsp;{else}{$FinanceAnnual[List].EBITDA|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Interest</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].Interest eq 0}&nbsp;{else}{$FinanceAnnual[List].Interest|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>EBDT</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].EBDT eq 0}&nbsp;{else}{$FinanceAnnual[List].EBDT|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Depreciation</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].Depreciation eq 0}&nbsp;{else}{$FinanceAnnual[List].Depreciation|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>EBT</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].EBT eq 0}&nbsp;{else}{$FinanceAnnual[List].EBT|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Tax</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].Tax eq 0}&nbsp;{else}{$FinanceAnnual[List].Tax|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>PAT</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].PAT eq 0}&nbsp;{else}{$FinanceAnnual[List].PAT|number_format:0:".":","}{/if}</td>
    {/section}
  </tr><br>
  <tr>
    <td><b>EPS</b></td>
     {section name=List loop=$FinanceAnnual}
        <td>&nbsp;</td>
    {/section}
  </tr>
  <tr>
    <td>Basic INR</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].BINR eq 0}&nbsp;{else}{$FinanceAnnual[List].BINR|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Diluted INR</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].DINR eq 0}&nbsp;{else}{$FinanceAnnual[List].DINR|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
     {section name=List loop=$FinanceAnnual}
        <td>&nbsp;</td>
    {/section}
  </tr>
  <tr>
    <td>Employee Related Expenses</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].EmployeeRelatedExpenses eq 0}&nbsp;{else}{$FinanceAnnual[List].EmployeeRelatedExpenses|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Foreign Exchange EarningandOutgo</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].ForeignExchangeEarningandOutgo eq 0}&nbsp;{else}{$FinanceAnnual[List].ForeignExchangeEarningandOutgo|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Earningin Foreign Exchange</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].EarninginForeignExchange eq 0}&nbsp;{else}{$FinanceAnnual[List].EarninginForeignExchange|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Outgoin Foreign Exchange</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].OutgoinForeignExchange eq 0}&nbsp;{else}{$FinanceAnnual[List].OutgoinForeignExchange|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
 
</tbody>
</table><br>
    
{if $FinanceAnnual2 neq '0'}
<table width="100%" border="0" cellspacing="0" cellpadding="0">
     {if $FinanceAnnual1[List].FY neq '05' AND $FinanceAnnual1[List].FY neq '06'}
<tHead> <tr>
<th>SOURCES OF FUNDS</th>
{section name=List loop=$FinanceAnnual1}
<th>FY {$FinanceAnnual[List].FY}</th>
{/section}
</tr></thead>
<tbody>  
  <tr>
    <td>Shareholders' funds</td>
     {section name=List loop=$FinanceAnnual1}
        <td>&nbsp;</td>
    {/section}
  </tr>
  <tr>
    <td>Paid-up share capital</td>
     {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].ShareCapital eq 0}&nbsp;{else}{$FinanceAnnual1[List].ShareCapital|number_format:0:".":","}{/if}</td>
     {/section}
  </tr>
  <tr>
    <td>Share application</td>
     {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].ShareApplication eq 0}&nbsp;{else}{$FinanceAnnual1[List].ShareApplication|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Reserves & Surplus</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].ReservesSurplus eq 0}&nbsp;{else}{$FinanceAnnual1[List].ReservesSurplus|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Shareholders' funds(total)</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].TotalFunds eq 0}&nbsp;{else}{$FinanceAnnual1[List].TotalFunds|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Loan funds</td>
    {section name=List loop=$FinanceAnnual1}
        <td>&nbsp;</td>
    {/section}
  </tr>
  <tr>
    <td>Secured loans</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].SecuredLoans eq 0}&nbsp;{else}{$FinanceAnnual1[List].SecuredLoans|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Unsecured loans</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].UnSecuredLoans eq 0}&nbsp;{else}{$FinanceAnnual1[List].UnSecuredLoans|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Loan funds(total)</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].LoanFunds eq 0}&nbsp;{else}{$FinanceAnnual1[List].LoanFunds|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Other Liabilities</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].OtherLiabilities eq 0}&nbsp;{else}{$FinanceAnnual1[List].OtherLiabilities|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Deferred Tax Liability</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].DeferredTax eq 0}&nbsp;{else}{$FinanceAnnual1[List].DeferredTax|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
    <td>TOTAL SOURCES OF FUNDS</td>
     {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].SourcesOfFunds eq 0}&nbsp;{else}{$FinanceAnnual1[List].SourcesOfFunds|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
   <tr>
    <td>&nbsp;</td>
     {section name=List loop=$FinanceAnnual1}
        <td>&nbsp;</td>
    {/section}
  </tr>
  <tr>
    <td>APPLICATION OF FUNDS</td>
    {section name=List loop=$FinanceAnnual1}
        <td>&nbsp;</td>
    {/section}
  </tr>
  
  <tr>
    <td>Fixed assets</td>
    {section name=List loop=$FinanceAnnual1}
        <td>&nbsp;</td>
    {/section}
  </tr>
 
  <tr>
    <td>Gross Block</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].GrossBlock eq 0}&nbsp;{else}{$FinanceAnnual1[List].GrossBlock|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Less : Depreciation Reserve</td>
   {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].LessAccumulated eq 0}&nbsp;{else}{$FinanceAnnual1[List].LessAccumulated|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Net Block</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].NetBlock eq 0}&nbsp;{else}{$FinanceAnnual1[List].NetBlock|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Add : Capital Work in Progress</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].CapitalWork eq 0}&nbsp;{else}{$FinanceAnnual1[List].CapitalWork|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Fixed Assets(total)</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].FixedAssets eq 0}&nbsp;{else}{$FinanceAnnual1[List].FixedAssets|number_format:0:".":","}{/if}</td>
    {/section}
  </tr><br>
  <tr>
    <td>Intangible Assets(total)</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].IntangibleAssets eq 0}&nbsp;{else}{$FinanceAnnual1[List].IntangibleAssets|number_format:0:".":","}{/if}</td>
    {/section}
  </tr><br>
  <tr>
    <td>Other Non-Current Assets</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].OtherNonCurrent eq 0}&nbsp;{else}{$FinanceAnnual1[List].OtherNonCurrent|number_format:0:".":","}{/if}</td>
    {/section}
  </tr><br>
  <tr>
    <td>Investments</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].Investments eq 0}&nbsp;{else}{$FinanceAnnual1[List].Investments|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Deferred Tax Assets</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].DeferredTaxAssets eq 0}&nbsp;{else}{$FinanceAnnual1[List].DeferredTaxAssets|number_format:0:".":","}{/if}</td>
    {/section}
  </tr><br>
  <tr>
    <td>Current Assets, Loans & Advances</td>
    {section name=List loop=$FinanceAnnual1}
        <td>&nbsp;</td>
    {/section}
  </tr>
  <tr>
    <td>Sundry Debtors</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].SundryDebtors eq 0}&nbsp;{else}{$FinanceAnnual1[List].SundryDebtors|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Cash & Bank Balances</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].CashBankBalances eq 0}&nbsp;{else}{$FinanceAnnual1[List].CashBankBalances|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Inventories</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].Inventories eq 0}&nbsp;{else}{$FinanceAnnual1[List].Inventories|number_format:0:".":","}{/if}</td>
    {/section}
  </tr><br>
  <tr>
    <td>Loans & Advances</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].LoansAdvances eq 0}&nbsp;{else}{$FinanceAnnual1[List].LoansAdvances|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Other Current Assets</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].OtherCurrentAssets eq 0}&nbsp;{else}{$FinanceAnnual1[List].OtherCurrentAssets|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Current Assets, Loans & Advances(total)</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].CurrentAssets eq 0}&nbsp;{else}{$FinanceAnnual1[List].CurrentAssets|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Current Liabilities & Provisions</td>
    {section name=List loop=$FinanceAnnual1}
        <td>&nbsp;</td>
    {/section}
  </tr>
  <tr>
    <td>Current Liabilities</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].CurrentLiabilities eq 0}&nbsp;{else}{$FinanceAnnual1[List].CurrentLiabilities|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Provisions</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].Provisions eq 0}&nbsp;{else}{$FinanceAnnual1[List].Provisions|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Current Liabilities & Provisions(total)</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].CurrentLiabilitiesProvision eq 0}&nbsp;{else}{$FinanceAnnual1[List].CurrentLiabilitiesProvision|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Net Current Assets</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].NetCurrentAssets eq 0}&nbsp;{else}{$FinanceAnnual1[List].NetCurrentAssets|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Profit & Loss Account</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].ProfitLoss eq 0}&nbsp;{else}{$FinanceAnnual1[List].ProfitLoss|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Miscellaneous Expenditure</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].Miscellaneous eq 0}&nbsp;{else}{$FinanceAnnual1[List].Miscellaneous|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>TOTAL APPLICATION OF FUNDS</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].TotalAssets eq 0}&nbsp;{else}{$FinanceAnnual1[List].TotalAssets|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  
</tbody>
 {/if}
  </table><br>
 {/if}
 
 {if $RatioCalculation1 neq '0'}
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
     {if $FinanceAnnual1[List].FY neq '05' AND $FinanceAnnual1[List].FY neq '06'}
<tHead> <tr>
<th>Ratio Names</th>
{section name=List1 loop=$RatioCalculation}
<th>FY {$RatioCalculation[List1].FY}</th>
{/section}
</tr></thead>
<tbody>  
  <tr>
    <td>Current Ratio</td>
     {section name=List1 loop=$RatioCalculation}
        <td>{math equation="((x + y + z)/a)" x=$RatioCalculation[List1].SundryDebtors y=$RatioCalculation[List1].CashBankBalances z=$RatioCalculation[List1].Inventories a=$RatioCalculation[List1].CurrentLiabilities format="%.3f"}</td>
    {/section}
  </tr>
  <tr>
    <td>Quick Ratio</td>
     {section name=List1 loop=$RatioCalculation}
        <td>{math equation="((x + y)/a)" x=$RatioCalculation[List1].SundryDebtors y=$RatioCalculation[List1].CashBankBalances a=$RatioCalculation[List1].CurrentLiabilities format="%.3f"}</td>
    {/section}
  </tr>
  <tr>
    <td>RoE</td>
     {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/a)" x=$RatioCalculation[List1].PAT a=$RatioCalculation[List1].TotalFunds assign="value3"}{if $value3 eq ''}&nbsp;{/if}</td>
     {/section}
  </tr>
  <tr>
    <td>RoCE</td>
     {section name=List1 loop=$RatioCalculation}
        <td>{math equation="((x + y)/a)" x=$RatioCalculation[List1].EBT y=$RatioCalculation[List1].Interest a=$RatioCalculation[List1].SourcesOfFunds format="%.3f" assign="value4"}{if $value4 eq ''}&nbsp;{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>RoA</td>
    {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/a)" x=$RatioCalculation[List1].PAT a=$RatioCalculation[List1].TotalAssets format="%.3f"}</td>
    {/section}
  </tr>
  <tr>
    <td>Cash Turnover Ratio</td>
    {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/((a+a)/2))" x=$RatioCalculation[List1].TotalIncome a=$RatioCalculation[List1].CashBankBalances format="%.3f"}</td>
    {/section}
  </tr>
  <tr>
    <td>Debtor Turnover Ratio</td>
    {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/((a+a)/2))" x=$RatioCalculation[List1].TotalIncome a=$RatioCalculation[List1].SundryDebtors format="%.3f"}</td>
    {/section}
  </tr>
  <tr>
    <td>Days Sale</td>
    {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(365/(x/((a+a)/2)))" x=$RatioCalculation[List1].TotalIncome a=$RatioCalculation[List1].SundryDebtors format="%.3f"}</td>
    {/section}
  </tr>
  <tr>
    <td>Inventory Turnover Ratio</td>
    {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/((a+a)/2))" x=$RatioCalculation[List1].TotalIncome a=$RatioCalculation[List1].Inventories format="%.3f"}</td>
    {/section}
  </tr>
  <tr>
    <td>Days Inventory</td>
    {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(365/(x/((a+a)/2)))" x=$RatioCalculation[List1].TotalIncome a=$RatioCalculation[List1].Inventories format="%.3f"}</td>
    {/section}
  </tr>
  <tr>
    <td>Working Capital Turnover Ratio</td>
    {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/(((a+b+c)-d)+((a+b+c)-d)/2))" x=$RatioCalculation[List1].TotalIncome a=$RatioCalculation[List1].SundryDebtors b=$RatioCalculation[List1].CashBankBalances c=$RatioCalculation[List1].Inventories d=$RatioCalculation[List1].CurrentLiabilities format="%.3f"}</td>
    {/section}
  </tr>
  <tr>
    <td>Total Asset Turnover Ratio</td>
    {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/((a+a)/2))" x=$RatioCalculation[List1].TotalIncome a=$RatioCalculation[List1].TotalAssets format="%.3f"}</td>
    {/section}
  </tr>
    <td>Fixed Asset Turnover Ratio</td>
     {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/((a+a)/2))" x=$RatioCalculation[List1].TotalIncome a=$RatioCalculation[List1].FixedAssets format="%.3f"}</td>
    {/section}
  </tr>
   <tr>
    <td>EBITDA Margin</td>
     {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/y)" x=$RatioCalculation[List1].EBITDA y=$RatioCalculation[List1].TotalIncome format="%.3f"}</td>
    {/section}
  </tr>
  <tr>
    <td>EBIT Margin</td>
    {section name=List1 loop=$RatioCalculation}
        <td>{math equation="((x+y)/z)" x=$RatioCalculation[List1].EBT y=$RatioCalculation[List1].Interest z=$RatioCalculation[List1].TotalIncome format="%.3f" assign="value15"}{if $value15 eq ''}&nbsp;{/if}</td>
    {/section}
  </tr>
  
  <tr>
    <td>PAT Margin</td>
    {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/y)" x=$RatioCalculation[List1].PAT y=$RatioCalculation[List1].TotalIncome format="%.3f"}</td>
    {/section}
  </tr>
 
  <tr>
    <td>Employee Remuneration</td>
   {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/y)" x=$RatioCalculation[List1].EmployeeRelatedExpenses y=$RatioCalculation[List1].OptnlIncome format="%.3f" assign="value17"}{if $value17 eq ''}&nbsp;{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Debt Equity Ratio</td>
   {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/y)" x=$RatioCalculation[List1].SourcesOfFunds y=$RatioCalculation[List1].TotalFunds format="%.3f"}</td>
    {/section}
  </tr>
  <tr>
    <td>Interest Coverage</td>
    {section name=List1 loop=$RatioCalculation}
        <td>{math equation="((x+y)/z)" x=$RatioCalculation[List1].EBT y=$RatioCalculation[List1].Interest z=$RatioCalculation[List1].Interest format="%.3f" assign="value19"}{if $value19 eq ''}&nbsp;{/if}</td>
    {/section}
  </tr>
  
</tbody>
 {/if}
  </table><br>
     {/if}
     
 </div>
 
 
 <div class="postContainer postContent masonry-container">  
     
      {if $searchResults}
    <div  class="work-masonry-thumb col-3" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
    <h2>FILINGS  <a  href="viewfiling.php?c={$encodedcompany}&cid={$Company_Id}">View all</a></h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="tableview download-links">
    <thead><tr><th>File Name </th> <th>Date</th></tr></thead>
    <tbody>
         {section name=customer loop=$searchResults}        
        <tr><td style="alt">{$searchResults[customer].name}</td>
            <td> 13 Jan 2013 </td>    </tr>                    
        {/section}
    </tbody>
    </table> 
    </div>
       {/if}  
         
      <div  class="work-masonry-thumb col-4" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
    <h2>  COMPANY PROFILE</h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="company-profile-table"> 
    <tbody>
    <tr>
        {if $CompanyProfile.IndustryName neq ""}
            <td >Industry	
            <span>{$CompanyProfile.IndustryName}</span> </td>
        {/if}
        {if $CompanyProfile.AddressHead neq ""}
            <td> Address
            <span>{$CompanyProfile.AddressHead}</span> </td>
        {/if}   
        {if $CompanyProfile.Phone neq ""}
            <td> Telephone
            <span>{$CompanyProfile.Phone}</span></td> 
        {/if}
   </tr> 
   <tr>
        {if $CompanyProfile.SectorName neq ""}
        <td> Sector
        <span>{$CompanyProfile.SectorName}</span> </td>
        {/if}
        {if $CompanyProfile.city_name neq ""}
        <td> City
        <span>{$CompanyProfile.city_name}</span> </td>
        {/if}      
        {if $CompanyProfile.Email neq ""}
        <td> Email
        <span>{$CompanyProfile.Email}</span></td> 
        {/if}
   </tr>  
   <tr>
        {if $CompanyProfile.IncorpYear neq ""}
            <td> In india since 
            <span>{$CompanyProfile.IncorpYear}</span></td> 
        {/if}
        {if $CompanyProfile.Country_Name neq ""}
            <td> Country
            <span>{$CompanyProfile.Country_Name}</span> </td>
       {/if}
       {if $CompanyProfile.Website neq ""}
            <td> website
            <span>{$CompanyProfile.Website}</span></td> 
       {/if}
    </tr>  
    
    <div class="linkedin-bg">
{literal}
     <script type="text/javascript" > 
            
            $(document).ready(function () {
        $('#lframe,#lframe1').on('load', function () {
//            $('#loader').hide();
            
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
         //document.getElementById("sa").textContent='asdasdasd'; 
        function onLinkedInLoad() {
           var profileDiv = document.getElementById("sample");

               var url = '/companies?email-domain={/literal}{$companylinkedIn}{literal}';
             
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
                    //$('#dataId').val(idvalue);
                    //var inHTML = '<script type="IN/CompanyProfile" data-id="'+idvalue+'" data-format="inline"></'+'script>';
                   var inHTML='loadlinkedin.php?data_id='+idvalue;
                    var inHTML2='linkedprofiles.php?data_id='+idvalue;
                    $('#lframe').attr('src',inHTML);
                    $('#lframe1').attr('src',inHTML2);
                    }
                    else
                        {
                             $('#lframe').hide();
                             $('#lframe1').hide();
                             $('#loader').hide();
                        }
                        
                    //  profileDiv.innerHtml=inHTML;
                    //document.getElementById('sa').innerHTML='<script type="IN/CompanyProfile" data-id="'+idvalue+'" data-format="inline"></'+'script>';
                }).error( function(error){
                    
                   $('#lframe').hide();
                   $('#lframe1').hide();
                   $('#loader').hide(); });
          }


        </script>
        {/literal}
   

    <input type="hidden" name="dataId" id="dataId" >
   
 </div>
        
        <tr><td colspan="3">  <div  id="sample" style="padding:10px 10px 0 0;" class="fl">
        
        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="220"></iframe>
    </div> <div class="fl" style="padding:10px 10px 0 0;" ><iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="300" ></iframe></div> </td>    </tr>
    </tbody>
    </table> 
    </div>  
    
     {if $companies}                                              
    <div  class="work-masonry-thumb col-3" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
    <h2>SIMILAR COMPANIES</h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
    <thead><tr><th>Company Name</th><th>Location</th></tr></thead>
    <tbody>
      
            {section name=company loop=$companies}
                  <tr><td style="alt"><a href='javascript:;' >{$companies[company][14]}</a></td> <td>{$companies[company].State}</td></tr>
{/section}
    </tbody>
    </table> 
    </div>
      {/if}  
      {if $director} 
        <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
               <h2>BOARD OF DIRECTORS</h2>
               <ul class="board-directors">

                    {section name=dir loop=$director}
                        <li><a href='bod.php?ID={$director[dir]|urlencode}' >{$director[dir]}</a></li>

       {/section}
                    </ul>
               </div> 
      {/if} 
      {if $roc}
       <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>REGISTERED TRADEMARK</h2>
        <ul class="registered-trade"> 
            <li> REGISTERED TO <br />
<span>
{$roc}
</span></li></ul>
        </div>     
      {/if}  
            
         </div>
  
  
</div>

</div>
      {include file="footer.tpl"}