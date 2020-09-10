{include file="header.tpl"}
{include file="leftpanel.tpl"}
{literal}
  
   <script>
       
          $(document).ready(function() {
        
      
        $.urlParam = function(name){
            var results = new RegExp('[\\?&]' + name + '=([^&#]*)').exec(window.location.href);
            return results[1] || 0;
        }
        $('#pgLoading').show();
        var vcid=$.urlParam('vcid');
        //alert(vcid);
	var ccur1 = 'INR';
	var str = 'c';
        
	$.get("ajaxmilliCurrency2.php", {queryString: ""+ccur1+"",vcid:""+vcid+"",rconv:""+str+""}, function(data){
			$('#result').html(data);
			$('.displaycmp').hide();
                        $('#stMsg').hide();
			resetfoundation();
                        
                        $('.companies-details').show();
                        $('#pgLoading').hide();
	});

});

    function projectdisplay(){
        $('#pgLoading').show();
	var projvcid = jQuery('#projvcid').val();
	var noofyear = jQuery('#noofyear').val();
	var CAGR = jQuery('#CAGR').val();
	var projnext = jQuery('#projnext').val();
        var ccur1 = $('#ccur').val();
        var convr = $('#currencytype').val();
        /*if(ccur1 =='INR'){
             var convr = 'c';
        }
        else
        {
            var convr = 'm';
        }*/
	//alert(projvcid+","+noofyear+","+CAGR+","+projnext);
	jQuery.get("ajaxCAGR.php", {queryString: ""+ccur1+"",rconv:""+convr+"",vcid: ""+projvcid+"",noofyear:""+noofyear+"",CAGR:""+CAGR+"",projnext:""+projnext+""}, function(data){
		jQuery('#result').html(data);
		jQuery('.displaycmp').hide();
                resetfoundation();
		//alert(data);
                $('#pgLoading').hide();
	});
}
function millconversion(str,vcid){
    //alert(str + "," +vcid);
         $('#pgLoading').show();
	var noofyear = jQuery('#noofyear').val();
	var CAGR = jQuery('#CAGR').val();
	var projnext = jQuery('#projnext').val();
	var ccur1 = $('#ccur').val();
        /*$('#stMsg').show();
        $('#stMsg').html('Please wait while we load values....');*/
       
	if(ccur1 =='-- select currency --'){
		ccur1 = 'INR';
	}
        
	$.get("ajaxmilliCurrency2.php", {queryString: ""+ccur1+"",vcid:""+vcid+"",rconv:""+str+"",noofyear:""+noofyear+"",CAGR:""+CAGR+"",projnext:""+projnext+""}, function(data){
			$('#result').html(data);
			$('.displaycmp').hide();
                        //$('#stMsg').hide();
			resetfoundation();
                        $('#pgLoading').hide();
		});
}
function currencyconvert(inputString,vcid){
    $('#pgLoading').show();
    var noofyear = jQuery('#noofyear').val();
    var CAGR = jQuery('#CAGR').val();
    var projnext = jQuery('#projnext').val();
    //var ccur1 = $('#currencytype').val();
    if(inputString =='INR'){
             var ccur1 = 'c';
    }
        else
        {
            var ccur1 = 'm';
        }

    /*$('#stMsg').show();
    $('#stMsg').html('Please wait while we load values....');*/
       
        //alert(ccur1+","+yoyr+","+inputString);
	$.get("ajaxcurr2.php", {queryString: ""+inputString+"",vcid:""+vcid+"",rconv:""+ccur1+"",noofyear:""+noofyear+"",CAGR:""+CAGR+"",projnext:""+projnext+""}, function(data){
			$('#result').html(data);
			$('.displaycmp').hide();
                        //$('#stMsg').hide();
                        resetfoundation();
                        $('#pgLoading').hide();
			//alert(data);
		});
}
function resetfoundation()
{
$(document).foundation();
$(".multi-select").dropdownchecklist('destroy');
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

{/literal}
<div class="container-right">
{include file="filters.tpl"}

<div class="list-tab cfsDeatilPage">
<ul>
<li><a class="postlink" href="home.php"><i class="i-grid-view"></i> LIST VIEW</a></li>
<li><a href="details.php?vcid={$VCID}" class="active postlink"><i class="i-detail-view"></i> DETAIL VIEW</a></li>
</ul>
</div>

<div class="companies-details" style="display:none;">
<div class="detailed-title-links"> <h2>{$FCompanyName} - {$SCompanyName} </h2> 
    
    
    
    
     {if $prevKey neq '-1'}<a class="previous postlink" id="previous" href="projectionall.php?vcid={$prevNextArr[$prevKey]}">< Previous</a>{/if}
    {if $prevNextArr|@count gt $nextKey}<a class="next postlink" id="next" href="projectionall.php?vcid={$prevNextArr[$nextKey]}"> Next > </a>{/if}
    <!--a class="previous" href="javascript:;">Previous</a> <a class="next" href="javascript:;">Next</a--> </div>


<div class="finance-cnt" id="result">

<div class="title-table"><h3>PROJECTION</h3> <a class="postlink" href="details.php?vcid={$VCID}">Back to details</a></div>
<div id="stMsg"></div>
<div class="project-filter projectionDetails">  
    <input type="hidden" name="projvcid" id="projvcid" value="{$VCID}"/>
<div class="left-cnt" ><label>Take CAGR of past</label><select name="noofyear" id="noofyear"><option value="0">None</option><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option></select>
    <label>CAGR % </label>  <input  type="text" name="CAGR" id="CAGR" value="" placeholder="Enter Percentage" /> </select> 
    <label>Project for</label><select name="projnext" id="projnext"><option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option><option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option><option value="9">9</option><option value="10">10</option></select> 
    <input type="button" name="projection" id="projection" onclick="javascript:projectdisplay()" value="Project Now" /> 
    </div>
    

    <div class="right-cnt">
        <label>Currency</label>  <select onChange="javascript:currencyconvert(this.value,{$VCID})" name="ccur" id="ccur">
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
        
        <label>Show in</label>   <select name="currencytype" id="currencytype" onchange="javascript:millconversion(this.value,{$VCID});">
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
<div style="">{section name=List loop=$FinanceAnnual}<ul>
<li><h4>FY {$FinanceAnnual[List].FY}</h4></li>
<li>{if $FinanceAnnual[List].OptnlIncome eq 0}-{else}{$FinanceAnnual[List].OptnlIncome|number_format:0:".":","}{/if}</li>
<li>{if $FinanceAnnual[List].OtherIncome eq 0}-{else}{$FinanceAnnual[List].OtherIncome|number_format:0:".":","}{/if}</li>
<li>{if $FinanceAnnual[List].TotalIncome eq 0}-{else}{$FinanceAnnual[List].TotalIncome|number_format:0:".":","}{/if}</li>
<li>{if $FinanceAnnual[List].OptnlAdminandOthrExp eq 0}-{else}{$FinanceAnnual[List].OptnlAdminandOthrExp|number_format:0:".":","}{/if}</li>
<li>{if $FinanceAnnual[List].OptnlProfit eq 0}-{else}{$FinanceAnnual[List].OptnlProfit|number_format:0:".":","}{/if}</li>
<li>{if $FinanceAnnual[List].EBITDA eq 0}{else}-{$FinanceAnnual[List].EBITDA|number_format:0:".":","}{/if}</li>
<li>{if $FinanceAnnual[List].Interest eq 0}{else}-{$FinanceAnnual[List].Interest|number_format:0:".":","}{/if}</li>
<li>{if $FinanceAnnual[List].EBDT eq 0}-{else}{$FinanceAnnual[List].EBDT|number_format:0:".":","}{/if}</li>
<li>{if $FinanceAnnual[List].Depreciation eq 0}-{else}{$FinanceAnnual[List].Depreciation|number_format:0:".":","}{/if}</li>
<li>{if $FinanceAnnual[List].EBT eq 0}-{else}{$FinanceAnnual[List].EBT|number_format:0:".":","}{/if}</li>
<li>{if $FinanceAnnual[List].Tax eq 0}-{else}{$FinanceAnnual[List].Tax|number_format:0:".":","}{/if}</li>
<li>{if $FinanceAnnual[List].PAT eq 0}-{else}{$FinanceAnnual[List].PAT|number_format:0:".":","}{/if}</li>
<li>{if $smarty.section.List.last}&nbsp;{/if}</li>
<li>{if $FinanceAnnual[List].BINR eq 0}-{else}{$FinanceAnnual[List].BINR|number_format:0:".":","}{/if}</li>
<li>{if $FinanceAnnual[List].DINR eq 0}-{else}{$FinanceAnnual[List].DINR|number_format:0:".":","}{/if}</li>
<li>&nbsp;</li>
<li>&nbsp;</li>
<li>{if $FinanceAnnual[List].EmployeeRelatedExpenses eq 0}-{else}{$FinanceAnnual[List].EmployeeRelatedExpenses|number_format:0:".":","}{/if}</li>
<li>{if $FinanceAnnual[List].ForeignExchangeEarningandOutgo eq 0}-{else}{$FinanceAnnual[List].ForeignExchangeEarningandOutgo|number_format:0:".":","}{/if}</li>
<li> {if $FinanceAnnual[List].EarninginForeignExchange eq 0}-{else}{$FinanceAnnual[List].EarninginForeignExchange|number_format:0:".":","}{/if}</li>
<li> {if $FinanceAnnual[List].OutgoinForeignExchange eq 0}-{else}{$FinanceAnnual[List].OutgoinForeignExchange|number_format:0:".":","}{/if}</li>
</ul>{/section}</div>
 
</div>

</div>  
</div>
</div>

<!--div class="btn-cnt p10"><input name="" type="button" value="EXPORT" /></div-->

  </div> 
</div>

</div>


 
