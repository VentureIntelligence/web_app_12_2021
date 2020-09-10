{include file="header.tpl"}
{include file="leftpanel.tpl"}

{literal}
<link href="css/growth.css" rel="stylesheet" type="text/css" /> 
<!--<script src="http://foundation.zurb.com/docs/assets/vendor/custom.modernizr.js"></script>-->
<script type="text/javascript">
   
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
        
	$.get("ajaxmilliCurrency.php", {queryString: ""+ccur1+"",vcid:""+vcid+"",rconv:""+str+""}, function(data_milli1){
			$('#result').html(data_milli1);
			$('.displaycmp').hide();
                        $('#stMsg').hide();
                         $('.companies-details').show();
                        $('#pgLoading').hide();
			resetfoundation();
                        
                       
	});
        
        /* $("#cagr").click(function() {
        alert("ddddddddddddddddd");
        //$("#ccur").attr("disabled",true);
    });*/
    window.onload = function () { 
        var cin = '{/literal}{$CIN}{literal}';
        var value = '';
       /* $.ajax({

            url: 'ajax_mca.php',
            async: true,

            type: 'POST',

            data: { cin: cin},

            timeout: 30000, // in milliseconds

            success: function(data12) { 
                $('#mca_data').html(data12);
            }
        });*/
        /*$.get("ajax_mca.php", {cin: ""+cin+""}, function(data){
            if(data == ''){
                var value = '';
            }else{
                var value = data;
            }
            $('#mca_data').html(value);
        });*/
    }

});

function millconversion(str,vcid){
    //alert(str + "," +vcid);
        $('#pgLoading').show();
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
        
	$.get("ajaxmilliCurrency.php", {queryString: ""+ccur1+"",vcid:""+vcid+"",rconv:""+str+"",yoy:""+yoyr+""}, function(data_milli){
			$('#result').html(data_milli);
			$('.displaycmp').hide();
                        $('#stMsg').hide();
                        $('#pgLoading').hide();
			resetfoundation();
                        
		});
}
function currencyconvert(inputString,vcid){
    //alert("ddddddddddddddd");
    $('#pgLoading').show();
    if(inputString =='INR')
    { 
         var ccur1 = 'c';
    }
    else
    {
        var ccur1 = 'm';
    }
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
        //alert(ccur1+","+yoyr+","+inputString);
	$.get("ajaxCurrency.php", {queryString: ""+inputString+"",vcid:""+vcid+"",rconv:""+ccur1+"",yoy:""+yoyr+""}, function(data){
			$('#result').html(data);
                        $('#pgLoading').hide();
			$('.displaycmp').hide();
                        $('#stMsg').hide();
                        resetfoundation();
			//alert(data);
		});
}
function valueconversion(inputString1,vcid1){
  
    $('#pgLoading').show();
    var ccur1 = $('#currencytype').val();
    //alert(ccur1);
    var inputString= $('#ccur').val();
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
	$.get("ajaxGrowth.php", {queryString: ""+inputString+"",queryString1: ""+inputString1+"",vcid:""+vcid1+"",rconv:""+ccur1+"",yoy:""+yoyr+""}, function(data){
			$('#result').html(data);
                        $('#pgLoading').hide();
			$('.displaycmp').hide();
                        $('#stMsg').hide();
                        resetfoundation();
			//alert(data);
		});
}
function projectdisplay(){
        $('#pgLoading').show();
	var projvcid = $('#projvcid').val();
	var noofyear = $('#noofyear').val();
	var CAGR = $('#CAGR').val();
	var projnext = $('#projnext').val();
	//alert(projvcid);
	$.get("ajaxCAGR.php", {vcid: ""+projvcid+"",noofyear:""+noofyear+"",CAGR:""+CAGR+"",projnext:""+projnext+""}, function(data){
		$('#result').html(data);
		$('.displaycmp').hide();
                $('#pgLoading').hide();
                resetfoundation();
                
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

function openbalancesheet_ex(){
    $("#balancesheet_ex").show();
}
function openpl_ex(){
    $("#pl_ex").show();
}

$(document).mouseup(function (e)
{
    $("#balancesheet_ex").hide();
    $("#pl_ex").hide();
});


      function balsheet_ch(){         
          
           var selected = jQuery(".template:checked");
            var selectedValue = selected.val();
            if(selectedValue==1){
                $("#new_balsheet").hide();
                $("#old_balsheet").show();
                $("#new_ratio").hide();
                $("#old_ratio").show();
            }
            else if(selectedValue==2){
                $("#old_balsheet").hide();
                $("#new_balsheet").show();
                $("#old_ratio").hide();
                $("#new_ratio").show();
            }
      }
</script>
{/literal}
 <div class="lb" id="popup-box">
	<div class="title">Send this to your Colleague</div>
    <form>
    	<div class="entry">
        	<label> To</label>
                <input type="text" name="toaddress" id="toaddress"  />
        </div>
        <div class="entry">
        	<h5>Subject</h5>
        	<p>Checkout this {$SCompanyName} Company's Financials</p>
                <input type="hidden" name="subject" id="subject" value="Checkout this {$SCompanyName} Company's Financials" />
        </div>
        <div class="entry"> 
        	<h5>Message</h5>
                <p>{$curpageURL}  <input type="hidden" name="message" id="message" value="{$curpageURL}" />   <input type="hidden" name="useremail" id="useremail" value="{$smarty.session.UserEmail}"  /> </p>
        </div>
        <div class="entry">
            <input type="button" value="Submit" id="mailbtn" />
            <input type="button" value="Cancel" id="cancelbtn" />
        </div>

    </form>
</div>
<div class="container-right">

{include file="filters.tpl"}
{if ($grouplimit[0][2] gte $grouplimit[0][5])}
<div>
 <div class="btn-cnt p10" style="float:right;">
     <input class="senddeal" type="button" id="senddeal" value="Send this company profile to your colleague" name="senddeal">
    {if $PLSTANDARD_MEDIA_PATH || $PLSTANDARD_MEDIA_PATH_CON}	
       <span style="  position: relative;  width: 175px;"> 
           <input  name="" type="button" value="P&L EXPORT" onClick="openpl_ex()" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 158px 6px; width:175px; " />

       <div id="pl_ex" style="display: none;  position: absolute;  width: 100%;  left:0;">
       {if $PLSTANDARD_MEDIA_PATH}<input  name="" type="button" value="Standalone" onClick="window.open('downloadtrack.php?vcid={$Company_Id}','_blank')" style="  width: 93%;border-top: 0;" />{/if}
       {if $PLSTANDARD_MEDIA_PATH_CON}<input  name="" type="button" value="Consolidated" onClick="window.open('downloadtrack.php?vcid={$Company_Id}&type=consolidated','_blank')" style="  width: 93%;border-top: 0;" />{/if}
       </div>
       </span>
       
    {/if}	
    {if $PLDETAILED_MEDIA_PATH}

        <input  name="" type="button" value="Detailed P&L EXPORT" onClick="window.open('{$MEDIA_PATH}pldetailed/PLDetailed_{$VCID}.xls','_blank')" />
            <!--div>&nbsp;</div><div class="anchorblue">To download Detailed P&L   :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="{$MEDIA_PATH}pldetailed/PLDetailed_{$VCID}.xls">Click Here</a></div-->
    {/if}
    {if $BSHEET_MEDIA_PATH || $BSHEET_MEDIA_PATH_NEW || $BSHEET_MEDIA_PATH1 || $BSHEET_MEDIA_PATH_NEW1}	
       <span style="  position: relative;  width: 175px;"> 
           <input  name="" type="button" value="BALANCESHEET EXPORT" onClick="openbalancesheet_ex()" style=" background: #a37635 url(images/arrow-dropdown.png) no-repeat 158px 6px; width:175px; " />

       <div id="balancesheet_ex" style="display: none;  position: absolute;  width: 100%;  left:0;">
       {if $BSHEET_MEDIA_PATH_NEW}<input  name="" type="button" value="Standalone" onClick="window.open('{$MEDIA_PATH}balancesheet_new/New_BalSheet_{$VCID}.xls','_blank')" style="  width: 93%;border-top: 0;" />{/if}
       {if $BSHEET_MEDIA_PATH_NEW1}<input  name="" type="button" value="Consolidated" onClick="window.open('{$MEDIA_PATH}balancesheet_new/New_BalSheet_{$VCID}_1.xls','_blank')" style="  width: 93%;border-top: 0;" />{/if}
       {if $BSHEET_MEDIA_PATH }<input  name="" type="button" value="Standalone(Old)" onClick="window.open('{$MEDIA_PATH}balancesheet/BalSheet_{$VCID}.xls','_blank')" style="  width: 93%;border-top: 0;" />{/if}
       {if $BSHEET_MEDIA_PATH1 }<input  name="" type="button" value="Consolidated(Old)" onClick="window.open('{$MEDIA_PATH}balancesheet/BalSheet_{$VCID}_1.xls','_blank')" style="  width: 93%;border-top: 0;" />{/if}
       </div>
       </span>
       
    {/if}
    {if $CASHFLOW_MEDIA_PATH}

            <input  name="" type="button" value="CASHFLOW EXPORT" onClick="window.open('{$MEDIA_PATH}cashflow/Cashflow_{$VCID}.xls','_blank')" />
            <!--div>&nbsp;</div><div class="anchorblue">To download CashFlow :&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a  href="{$MEDIA_PATH}cashflow/Cashflow_{$VCID}.xls">Click Here</a></div-->
    {/if}
     
</div></div>
    <div class="list-tab" style="clear: both;">
<ul>
<li><a class="postlink" href="home.php"><i></i> LIST VIEW</a></li>
<li><a  href="details.php?vcid={$VCID}" class="active postlink"><i class="i-detail-view"></i> DETAIL VIEW</a></li>
</ul>
</div>

<div class="companies-details" style="display:none;">
    
<div class="detailed-title-links"> <h2>{$SCompanyName}</h2> 
    
    {if $prevKey neq '-1'}<a class="previous postlink" id="previous" href="details.php?vcid={$prevNextArr[$prevKey]}">< Previous</a>{/if}
    {if $prevNextArr|@count gt $nextKey}<a class="next postlink" id="next" href="details.php?vcid={$prevNextArr[$nextKey]}"> Next > </a>{/if}
<!--a class="previous" href="javascript:;">Previous</a> <a class="next" href="javascript:;">Next</a--> </div>


<div class="finance-cnt" id="result">

<div class="title-table"><h3>FINANCIALS</h3> <a class="postlink" href="projectionall.php?vcid={$Company_Id}">See Projection</a></div>
<div id="stMsg"></div>
<div class="finance-filter"> <!--form class="custom"-->
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
        <option value="INR" selected="selected">Indian Rupee INR</option>
        <option value="IDR">Indonesian Rupiah IDR</option>
        <option value="HKD">Hong Kong Dollar HKD</option>
    </select> 
</div>
<div class="right-cnt"><label>Show in</label>  
    <select name="currencytype" id="currencytype" onchange="javascript:millconversion(this.value,{$VCID});">
        <option value='r'>Actual Vlaue</option>
        <option value='m'>Millions</option>
        <option value='c'>Crores</option>
    </select> </div><!--/form-->
</div>

            
            
<div class="detail-table">
    
<table  width="100%" border="0" cellspacing="0" cellpadding="0">
<tHead> <tr>
<th>OPERATIONS</th>
{section name=List loop=$FinanceAnnual}
    {if ($FinanceAnnual[List].FY ne NULL)}
        <th>FY {$FinanceAnnual[List].FY}</th>
    {/if}
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
    <td><span  data-tooltip="" title="Operating,Admministrative & Other Expenses">Ope,Ad&Other</span></td>
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
  </tr>
  <tr>
    <td><b>EPS</b></td>
     {section name=List loop=$FinanceAnnual}
        <td>&nbsp;</td>
    {/section}
  </tr>
  <tr>
    <td>EPS Basic (in INR)</td>
    {section name=List loop=$FinanceAnnual}
        <td>{if $FinanceAnnual[List].BINR eq 0}&nbsp;{else}{$FinanceAnnual[List].BINR|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>EPS Diluted (in INR)</td>
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
</table>
  </div><br>
  <div style="font-size: 16px;">
   <a  href="mailto:cfs@ventureintelligence.com?subject=Request for latest financials&body=Please add to the database the financials for the company" >Click here to check for latest financial year availability</a><br><br>
  </div>

 
   <div class="finance-cnt">
    
{if $FinanceAnnual2 neq '0'}
<sub><b>(Values are in INR)</b></sub>    
<div class="detail-table">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
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
  </tr>
  <tr>
    <td>Intangible Assets(total)</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].IntangibleAssets eq 0}&nbsp;{else}{$FinanceAnnual1[List].IntangibleAssets|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
  <tr>
    <td>Other Non-Current Assets</td>
    {section name=List loop=$FinanceAnnual1}
        <td>{if $FinanceAnnual1[List].OtherNonCurrent eq 0}&nbsp;{else}{$FinanceAnnual1[List].OtherNonCurrent|number_format:0:".":","}{/if}</td>
    {/section}
  </tr>
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
  </tr>
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
  </tr>
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
  </table></div>
 {/if}
 </div>
 <div class="finance-cnt">
 {if $RatioCalculation1 neq '0'}
     <div class="detail-table">
     <table width="100%" border="0" cellspacing="0" cellpadding="0">
     
<tHead> <tr>
<th>Ratios</th>
{section name=List1 loop=$RatioCalculation}
<th>FY {$RatioCalculation[List1].FY}</th>
{/section}
</tr></thead>
<tbody>  
  <tr>
    <td>Current Ratio</td>
     {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/a)" x=$RatioCalculation[List1].CurrentAssets  a=$RatioCalculation[List1].CurrentLiabilitiesProvision format="%.2f"}</td>
    {/section}
  </tr>
  <tr>
    <td>Quick Ratio</td>
     {section name=List1 loop=$RatioCalculation}
        <td>{math equation="((x - y)/a)" x=$RatioCalculation[List1].CurrentAssets y=$RatioCalculation[List1].Inventories a=$RatioCalculation[List1].CurrentLiabilitiesProvision format="%.2f"}</td>
    {/section}
  </tr>
  <tr>
    <td>RoE</td>
     {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/a)" x=$RatioCalculation[List1].PAT a=$RatioCalculation[List1].TotalFunds format="%.2f"}{if $value3 eq ''}&nbsp;{/if}</td>
     {/section}
  </tr>
  <!--tr>
    <td>RoCE</td>
     {section name=List1 loop=$RatioCalculation}
        <td>{math equation="((x + y)/a)" x=$RatioCalculation[List1].EBT y=$RatioCalculation[List1].Interest a=$RatioCalculation[List1].SourcesOfFunds format="%.3f" assign="value4"}{if $value4 eq ''}&nbsp;{/if}</td>
    {/section}
  </tr-->
  <tr>
    <td>RoA</td>
    {section name=List1 loop=$RatioCalculation}
        <td>{math equation="(x/a)" x=$RatioCalculation[List1].PAT a=$RatioCalculation[List1].TotalAssets format="%.2f"}</td>
    {/section}
  </tr>
  <!--tr>
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
  </tr-->
   <tr>
    <td>EBITDA Margin</td>
     {section name=List1 loop=$RatioCalculation}
        <td>{math|string_format:"%.2f" equation="(x/y)*a" x=$RatioCalculation[List1].EBITDA y=$RatioCalculation[List1].TotalIncome a=100}%</td>
    {/section}
  </tr>
  <!--tr>
    <td>EBIT Margin</td>
    {section name=List1 loop=$RatioCalculation}
        <td>{math equation="((x+y)/z)" x=$RatioCalculation[List1].EBT y=$RatioCalculation[List1].Interest z=$RatioCalculation[List1].TotalIncome format="%.3f" assign="value15"}{if $value15 eq ''}&nbsp;{/if}</td>
    {/section}
  </tr-->
  
  <tr>
    <td>PAT Margin</td>
    {section name=List1 loop=$RatioCalculation}
        <td>{math|string_format:"%.2f" equation="(x/y)*a" x=$RatioCalculation[List1].PAT y=$RatioCalculation[List1].TotalIncome a=100}%</td>
    {/section}
  </tr>
 
  <!--tr>
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
  </tr-->
  
</tbody>
 {/if}
  </table></div>
</div></div>
  <div class="finance-cnt postContainer postContent masonry-container">
      {if $searchResults}
    <div  class="work-masonry-thumb col-3" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
    <h2>FILINGS <a class="postlink" href="viewfiling.php?c={$encodedcompany}&cid={$Company_Id}"> View all</a></h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="tableview download-links">
    <thead><tr><th>File Name </th> <th>Date</th></tr></thead>
    <tbody>
         {section name=customer loop=$searchResults} 
             {if $smarty.section.customer.index lt 5}
        <tr><td style="alt">{$searchResults[customer].name}</td>
            <td> {$searchResults[customer].uploaddate} </td>    </tr>  
        {/if}
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
        {if $CompanyProfile.ListingStatus neq ""}
            <td >Status	
            <span>{if $CompanyProfile.ListingStatus eq '0'}Both{elseif $CompanyProfile.ListingStatus eq '1'} Listed{elseif $CompanyProfile.ListingStatus eq '2'} Privately held(Ltd){elseif $CompanyProfile.ListingStatus eq '3'} Partnership {elseif $CompanyProfile.ListingStatus eq '4'} Proprietorship{/if}</span> </td>
        {/if}
        {if $CompanyProfile.Permissions1 neq ""}
            <td >Transaction Status	
            <span>{if $CompanyProfile.Permissions1 eq '0'}Transacted{elseif $CompanyProfile.Permissions1 eq '1'} Non Transacted{elseif $CompanyProfile.Permissions1 eq '2'} Non-Transacted  and Fund Raising{/if}</span> </td>
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
        {if $CompanyProfile.CEO neq ""}
        <td> Contact Name
        <span>{$CompanyProfile.CEO}</span></td> 
        {/if}    
        {if $CompanyProfile.CFO neq ""}
        <td> Designation
        <span>{$CompanyProfile.CFO}</span></td> 
        {/if}
   </tr>  
   <tr>
        {if $CompanyProfile.IncorpYear neq ""}
            <td> Year Founded 
            <span>{$CompanyProfile.IncorpYear}</span></td> 
        {/if}
        {if $CompanyProfile.Country_Name neq ""}
            <td> Country
            <span>{$CompanyProfile.Country_Name}</span> </td>
       {/if}
       {if $CompanyProfile.Website neq ""}
            <td> website
                <span><a href="{$CompanyProfile.Website}" target="_blank">{$CompanyProfile.Website}</a></span>
            </td> 
       {else}
           <td> website
                <span><a href="https://www.google.com/search?btnI=1&q={$SCompanyName}" target="_blank">Click Here</a></span>
            </td> 
       {/if}
    </tr>  
    
    {if $companylinkedIn neq ""}
     <tr id="viewlinkedin_loginbtn">
        
            <td> View LinkedIn Profile 
            <span> {literal} <script type="in/Login"></script> {/literal}</span></td> 
       
     </tr>    
     {/if}
     
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

 $('#senddeal').click(function(){ 
                    jQuery('#maskscreen').fadeIn(1000);
                    jQuery('#popup-box').fadeIn();   
                    return false;
                });
            $('#cancelbtn').click(function(){ 

               jQuery('#popup-box').fadeOut();   
                jQuery('#maskscreen').fadeOut(1000);
               return false;
           });
            function validateEmail(field) {
                    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return (regex.test(field)) ? true : false;
                }
            function checkEmail() {

                var email = $("#toaddress").val();
                    if (email != '') {
                        var result = email.split(",");
                        for (var i = 0; i < result.length; i++) {
                            if (result[i] != '') {
                                if (!validateEmail(result[i])) {

                                    alert('Please check, `' + result[i] + '` email addresses not valid!');
                                    email.focus();
                                    return false;
                                }
                            }
                        }
                }
                else
                {
                    alert('Please enter email address');
                    email.focus();
                    return false;
                }
                return true;
            }
            
             $('#mailbtn').click(function(){ 
                        
                        if(checkEmail())
                        {
                            
                        
                        $.ajax({
                            url: 'ajaxsendmail.php',
                             type: "POST",
                            data: { to : $("#toaddress").val(), subject : $("#subject").val(), message : $("#message").val() , userMail : $("#useremail").val() },
                            success: function(data){
                                    if(data=="1"){
                                         alert("Mail Sent Successfully");
                                        jQuery('#popup-box').fadeOut();   
                                        jQuery('#maskscreen').fadeOut(1000);
                                   
                                }else{
                                    jQuery('#popup-box').fadeOut();   
                                    jQuery('#maskscreen').fadeOut(1000);
                                    alert("Try Again");
                                }
                            },
                            error:function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem sending mail...");
                            }

                        });
                        }
                        
                    });
 </script>
 {/literal}{if $CompanyProfile.LinkedIn neq ""}
{php}

    $link = $this->get_template_vars('CompanyProfile');
    $url=$link['LinkedIn'];
     $keys = parse_url($url); // parse the url
     $path = explode("/", $keys['path']); // splitting the path
     $companyid = (int)end($path); // get the value of the last element  
{/php}
{literal}

<script type="text/javascript" src="http://platform.linkedin.com/in.js"> 
        api_key:65623uxbgn8l
        authorize:true
        onLoad: onLinkedInLoad
        </script>
        <script type="text/javascript" >
           
        var idvalue={/literal}{php} echo $companyid;{/php}{literal};

        function onLinkedInLoad() {
           $("#viewlinkedin_loginbtn").hide(); 
           var profileDiv = document.getElementById("sample");
                    
                    if(idvalue)
                    {                          
                        $("#lframe").css({"height": "220px"});
                        $("#lframe1").css({"height": "300px"});

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
                     
          }

    </script>
{/literal}

{else}

{literal}
    <script type="text/javascript" src="http://platform.linkedin.com/in.js">
        api_key:65623uxbgn8l
        authorize:true
        onLoad: LinkedAuth
    </script>
    <script type="text/javascript" > 
        var idvalue;
         //document.getElementById("sa").textContent='asdasdasd'; 
         
        function LinkedAuth() {

            if(IN.User.isAuthorized()==1){
               $("#viewlinkedin_loginbtn").hide();      
            }
            else {
                 $("#viewlinkedin_loginbtn").show();   
            }
            
            IN.Event.on(IN, "auth", onLinkedInLoad);

          } 
        
        function onLinkedInLoad() {
           $("#viewlinkedin_loginbtn").hide(); 
           var profileDiv = document.getElementById("sample");

               //var url = "/companies?email-domain=<?php echo $linkedinSearchDomain ?>";
               var url ="/company-search:(companies:(id,website-url))?keywords={/literal}{$SCompanyName}{literal}";

                console.log(url);
            
                IN.API.Raw(url).result(function(response) {   
                   
                    console.log(response);  
                    //console.log(response['companies']['values'].length);                  
                    //console.log(response['companies']['values'][0]['id']);
                    //console.log(response['companies']['values'][0]['websiteUrl']);
                    var searchlength = response['companies']['values'].length;
                    
                    var domain='';
                    var website = '{/literal}{$companylinkedIn}{literal}';
                   
                    for(var i=0; i<searchlength; i++){
                        
                        if(response['companies']['values'][i]['websiteUrl']){
                            domain = response['companies']['values'][i]['websiteUrl'].replace('www.','');
                            domain = domain.replace('http://','');
                            domain = domain.replace('/','');
                            if(domain == website){
                                idvalue = response['companies']['values'][i]['id'];
                                console.log(idvalue);
                                break;
                                
                            }
                        }
                    }
                 
                    
                    if(idvalue)
                        {                          
                    $("#lframe").css({"height": "220px"});
                    $("#lframe1").css({"height": "300px"});
                   
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
                   console.log(error);
                   $('#lframe').hide();
                   $('#lframe1').hide();
                   $('#loader').hide(); });
          }


        </script>
     
        
        {/literal}
   {/if}

    <input type="hidden" name="dataId" id="dataId" >
   
 </div>
        
        <tr><td colspan="3">  <div  id="sample" style="padding:10px 10px 0 0;" class="fl">
        
        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="0"></iframe>
    </div> <div class="fl" style="padding:10px 10px 0 0;" ><iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="0" ></iframe></div> </td>    </tr>
    </tbody>
    </table> 
    </div>  
   <span id="mca_data"><!--<div style="margin-bottom:20px;">MCA data look up... <img src="images/loadingAnimation.gif" style="margin-left:10px;"/></div>--></span>
    <!--{if $LLPMasterForm}
        {literal}            
        <style>#resultTab1{width:100%} #chargesRegistered div, #signatories div{padding: 0px 10px 10px 10px;
    margin: 0;
    border-bottom: 1px solid #d4d4d4;
    color: #c09f74 !important;
    font-weight: bold;
    font-size: 18px;} .table-header th{ border-bottom:2px solid #d4d4d4; border-right:1px solid #d4d4d4; }
        
       
/* The Modal (background) */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1; /* Sit on top */
    padding-top: 100px; /* Location of the box */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgb(0,0,0); /* Fallback color */
    background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
}

/* Modal Content */
.modal-content {
    background-color: #fefefe;
    margin: auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
    min-height: 500px;
}

/* The Close Button */
.close {
    color: #aaaaaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: #000;
    text-decoration: none;
    cursor: pointer;
}
.modal-content #resultsTab2, .modal-content #resultsTab3{ width : 100%;}
.modal-content table tr th{ border-bottom:2px solid #d4d4d4; border-right:1px solid #d4d4d4; }
.modal-content table{ border:1px solid #d4d4d4; }
.modal-content #dirMasterData span{ color: #c09f74 !important; font-weight: bold;}
table{
        border-spacing: 0px;
}
.finance-cnt .imgButton{
        margin: 0;
    font-size: 14px;
    border: 1px solid #000;
    float: left;
    background: #a37635;
    padding: 3px 5px;
    text-transform: uppercase;
    color: #fff;
    font-weight: bold;
}
        </style>
        {/literal}
        <div  class="work-masonry-thumb col-4" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
         <div class="finance-cnt">   
             <h2> Company Master Data <span style="float:right;">{$LLPMasterFormSubmit}</span></h2>
            {$LLPMasterForm}
            
            <div id="myModal" class="modal">
                <div class="modal-content">
                  <span class="close">x</span>
                  <p id="resultContent"></p>
                  <div style=" text-align: center; margin: 0 auto; width: 100%;"><img src="images/loading_page1.gif" id="loading_img" alt="" style="display: none;"/></div>
                </div>
            </div>
            
           {literal}
            <script type="text/javascript" >
                $('#confirmBtnDiv').html('');
                 $('#exportCompanyMasterData').attr('action', 'http://www.mca.gov.in/mcafoportal/exportCompanyMasterData.do');
                 
                 // Get the modal
                var modal = document.getElementById('myModal');

                // Get the <span> element that closes the modal
                var span = document.getElementsByClassName("close")[0];
                
                 $("#aShowDirectorMasterdata[href='#']").attr('href', 'javascript:;');
                function showDirectorMasterData(din=''){
                    if(din != ''){
                        $('#resultContent').html('');
                        modal.style.display = "block";
                        $("#loading_img").show(); 
                        $.ajax({
                            url: 'ajaxDataFetch.php',
                            type: 'POST',
                            data: { din: din},
                            timeout: 30000, // in milliseconds
                            success: function(data) { 
                                $("#loading_img").hide(); 
                                $('#resultContent').html(data);
                                return false;
                            }
                        });
                    }else{
                        return false;
                    }
                }

                // When the user clicks on <span> (x), close the modal
                span.onclick = function() {
                    modal.style.display = "none";
                }

                // When the user clicks anywhere outside of the modal, close it
                window.onclick = function(event) {
                    if (event.target == modal) {
                        modal.style.display = "none";
                    }
                }
                $('#exportCompanyMasterData_0').click(function (e){
                    e.preventDefault(); 
                    $('#exportCompanyMasterData').submit();
                });
            </script>
            {/literal}
        </div>
         </div>
    {/if}-->
    
    <div  class="work-masonry-thumb col-4" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
    <h2>  COMPANY RATING</h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="company-profile-table"> 
    <tbody>
    <tr>
        <td>
        {if $ICRArating neq ""}
            ICRA	
            <span><a href="{$ICRAratingUrl}" target="_blank">View Rating</a> ( {$ICRArating} )</span>
        {/if}
        </td>
     </tr>
     <tr>
         <td>
             CRISIL <span><a href="{$crisilRating}" target="_blank">View Rating</a></span>
        </td>
         <td>
             CARE <span><a href="{$careRating}" target="_blank">View Rating</a></span>
        </td>
     </tr>
     <tr>
         <td>
             SMERA <span><a href="javascript:void(0)" id="smera_link"> View Rating</a></span>
        </td>
        <form action="https://www.smera.in/live-ratings/index.aspx" name="smera_form" id="smera_form" method="post" target='_blank'>    
        <input type="hidden" name="__EVENTTARGET" id="__EVENTTARGET" value="">
        <input type="hidden" name="__EVENTARGUMENT" id="__EVENTARGUMENT" value="">
        <input type="hidden" name="__LASTFOCUS" id="__LASTFOCUS" value="">
        <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwULLTIxNDY5MjcxMzUPZBYCAgMPZBYSAgUPEGRkFgFmZAIHD2QWAgIBDxQrAAIPFgQeC18hRGF0YUJvdW5kZx4LXyFJdGVtQ291bnQCpl9kZBYCZg9kFigCAQ9kFgICAQ9kFgJmDxUFCTEyIEFwciAxNhA8dGQgY29sc3Bhbj0nMic+8AY8ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9BY29yZUluZHVzdHJpZXNQcml2YXRlTGltaXRlZC1SUi0yMDE2MDQxMi5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL0Fjb3JlSW5kdXN0cmllc1ByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDEyLnBkZicgdGFyZ2V0PSdfYmxhbmsnPkFjb3JlIEluZHVzdHJpZXMgUHJpdmF0ZSBMaW1pdGVkPC9hPjxicj48L2Rpdj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlRlcm0gTG9hbjwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMTIuNSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEIgLyBTdGFibGU8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPkNhc2ggQ3JlZGl0PC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAxLjUgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+AABkAgIPZBYCAgEPZBYCZg8VBQkxMiBBcHIgMTYQPHRkIGNvbHNwYW49JzInProLPGRpdiBjbGFzcz0nY29tcGFueSc+PGRpdiBjbGFzcz0ncGRmJz48YSBocmVmPSdodHRwOi8vc21lcmEuaW4vZG9jdW1lbnRzL3JhdGluZ3MvUmFqYXN0aGFuRGlnaXRhbFRpbGVzUHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MTIucGRmJyB0YXJnZXQ9J19ibGFuayc+VmlldzwvYT48L2Rpdj48YSBocmVmDQogIA0KICAgIA0KPScuLi9kb2N1bWVudHMvcmF0aW5ncy9SYWphc3RoYW5EaWdpdGFsVGlsZXNQcml2YXRlTGltaXRlZC1SUi0yMDE2MDQxMi5wZGYnIHRhcmdldD0nX2JsYW5rJz5SYWphc3RoYW4gRGlnaXRhbCBUaWxlcyBQcml2YXRlIExpbWl0ZWQ8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDggQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCLSAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+RXhwb3J0IFBhY2thZ2luZyBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5TaG9ydCBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAxIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTQ8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPkxldHRlciBvZiBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5TaG9ydCBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAyIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTQ8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPkJhbmsgR3VhcmFudGVlPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+U2hvcnQgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMC41IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTQ8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4AAGQCAw9kFgICAQ9kFgJmDxUFCTEyIEFwciAxNhA8dGQgY29sc3Bhbj0nMic+1QY8ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9DYWxjdXR0YU92ZXJzZWFzLVJSLTIwMTYwNDEyLnBkZicgdGFyZ2V0PSdfYmxhbmsnPlZpZXc8L2E+PC9kaXY+PGEgaHJlZg0KICANCiAgICANCj0nLi4vZG9jdW1lbnRzL3JhdGluZ3MvQ2FsY3V0dGFPdmVyc2Vhcy1SUi0yMDE2MDQxMi5wZGYnIHRhcmdldD0nX2JsYW5rJz5DYWxjdXR0YSBPdmVyc2VhczwvYT48YnI+PC9kaXY+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5Gb3JlaWduIERvY3VtZW50YXJ5IEJpbGwgUHVyY2hhc2UgPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+U2hvcnQgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMTggQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBBNCs8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlBhY2thZ2luZyBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5TaG9ydCBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiA1IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTQrPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+AABkAgQPZBYCAgEPZBYCZg8VBQkxMiBBcHIgMTYQPHRkIGNvbHNwYW49JzInPpgJPGRpdiBjbGFzcz0nY29tcGFueSc+PGRpdiBjbGFzcz0ncGRmJz48YSBocmVmPSdodHRwOi8vc21lcmEuaW4vZG9jdW1lbnRzL3JhdGluZ3MvVmVlVmVlQ29udHJvbHNQcml2YXRlTGltaXRlZC1SUi0yMDE2MDQxMi5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL1ZlZVZlZUNvbnRyb2xzUHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MTIucGRmJyB0YXJnZXQ9J19ibGFuayc+VmVlIFZlZSBDb250cm9scyBQcml2YXRlIExpbWl0ZWQ8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDIgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCQkItICAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9SZWFmZmlybWVkLmdpZicgdGl0bGU9UmVhZmZpcm1lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlRlcm0gTG9hbjwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMiBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEJCQi0gIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL1JlYWZmaXJtZWQuZ2lmJyB0aXRsZT1SZWFmZmlybWVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+QmFuayBHdWFyYW50ZWU8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5TaG9ydCBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiA2Ljc1IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTM8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvUmVhZmZpcm1lZC5naWYnIHRpdGxlPVJlYWZmaXJtZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+AABkAgUPZBYCAgEPZBYCZg8VBQkxMSBBcHIgMTYQPHRkIGNvbHNwYW49JzInPpkJPGRpdiBjbGFzcz0nY29tcGFueSc+PGRpdiBjbGFzcz0ncGRmJz48YSBocmVmPSdodHRwOi8vc21lcmEuaW4vZG9jdW1lbnRzL3JhdGluZ3MvSWNvbkRlc2lnbkF1dG9tYXRpb25Qcml2YXRlTGltaXRlZC1SUi0yMDE2MDQxMS5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL0ljb25EZXNpZ25BdXRvbWF0aW9uUHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MTEucGRmJyB0YXJnZXQ9J19ibGFuayc+SWNvbiBEZXNpZ24gQXV0b21hdGlvbiBQcml2YXRlIExpbWl0ZWQ8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+VGVybSBMb2FuPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiA0LjUgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5DYXNoIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMS41IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQiAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+TGV0dGVyIG9mIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPlNob3J0IFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDEgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBBNDxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPgAAZAIGD2QWAgIBD2QWAmYPFQUJMTEgQXByIDE2EDx0ZCBjb2xzcGFuPScyJz7DBDxkaXYgY2xhc3M9J2NvbXBhbnknPjxkaXYgY2xhc3M9J3BkZic+PGEgaHJlZj0naHR0cDovL3NtZXJhLmluL2RvY3VtZW50cy9yYXRpbmdzL1ByYWd5YVdvb2RQcml2YXRlTGltaXRlZC1SUi0yMDE2MDQxMS5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL1ByYWd5YVdvb2RQcml2YXRlTGltaXRlZC1SUi0yMDE2MDQxMS5wZGYnIHRhcmdldD0nX2JsYW5rJz5QcmFneWEgV29vZCBQcml2YXRlIExpbWl0ZWQ8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQgPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiA1IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQiAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPgAAZAIHD2QWAgIBD2QWAmYPFQUJMTEgQXByIDE2EDx0ZCBjb2xzcGFuPScyJz78BDxkaXYgY2xhc3M9J2NvbXBhbnknPjxkaXYgY2xhc3M9J3BkZic+PGEgaHJlZj0naHR0cDovL3NtZXJhLmluL2RvY3VtZW50cy9yYXRpbmdzL1JhamthbWFsQnVpbGRlcnNJbmZyYXN0cnVjdHVyZVByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDExLnBkZicgdGFyZ2V0PSdfYmxhbmsnPlZpZXc8L2E+PC9kaXY+PGEgaHJlZg0KICANCiAgICANCj0nLi4vZG9jdW1lbnRzL3JhdGluZ3MvUmFqa2FtYWxCdWlsZGVyc0luZnJhc3RydWN0dXJlUHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MTEucGRmJyB0YXJnZXQ9J19ibGFuayc+UmFqa2FtYWwgQnVpbGRlcnMgSW5mcmFzdHJ1Y3R1cmUgUHJpdmF0ZSBMaW1pdGVkPC9hPjxicj48L2Rpdj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPkJhbmsgR3VhcmFudGVlPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+U2hvcnQgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgNjAgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBBMjxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPgAAZAIID2QWAgIBD2QWAmYPFQUJMTEgQXByIDE2EDx0ZCBjb2xzcGFuPScyJz7uBjxkaXYgY2xhc3M9J2NvbXBhbnknPjxkaXYgY2xhc3M9J3BkZic+PGEgaHJlZj0naHR0cDovL3NtZXJhLmluL2RvY3VtZW50cy9yYXRpbmdzL1NocmVlTWFoYXZpck9pbCZHZW5lcmFsTWlsbHMtUlItMjAxNjA0MTEucGRmJyB0YXJnZXQ9J19ibGFuayc+VmlldzwvYT48L2Rpdj48YSBocmVmDQogIA0KICAgIA0KPScuLi9kb2N1bWVudHMvcmF0aW5ncy9TaHJlZU1haGF2aXJPaWwmR2VuZXJhbE1pbGxzLVJSLTIwMTYwNDExLnBkZicgdGFyZ2V0PSdfYmxhbmsnPlNocmVlIE1haGF2aXIgT2lsICYgR2VuZXJhbCBNaWxsczwvYT48YnI+PC9kaXY+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5DYXNoIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgNiBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEItIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5UZXJtIExvYW48L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDAuNSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEItIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+AABkAgkPZBYCAgEPZBYCZg8VBQkxMSBBcHIgMTYQPHRkIGNvbHNwYW49JzInPugGPGRpdiBjbGFzcz0nY29tcGFueSc+PGRpdiBjbGFzcz0ncGRmJz48YSBocmVmPSdodHRwOi8vc21lcmEuaW4vZG9jdW1lbnRzL3JhdGluZ3MvTk1Gb29kSW1wZXhQcml2YXRlTGltaXRlZC1SUi0yMDE2MDQxMS5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL05NRm9vZEltcGV4UHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MTEucGRmJyB0YXJnZXQ9J19ibGFuayc+Tk0gRm9vZCBJbXBleCBQcml2YXRlIExpbWl0ZWQ8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDIgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCKyAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+UGFja2luZyBDcmVkaXQvRkRCL0ZCRTwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPlNob3J0IFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDEwIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTQ8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4AAGQCCg9kFgICAQ9kFgJmDxUFCTA5IEFwciAxNhA8dGQgY29sc3Bhbj0nMic+8Ag8ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9DaGllbkhzaW5nVGFubmVyeS1SUi0yMDE2MDQwOS5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL0NoaWVuSHNpbmdUYW5uZXJ5LVJSLTIwMTYwNDA5LnBkZicgdGFyZ2V0PSdfYmxhbmsnPkNoaWVuIEhzaW5nIFRhbm5lcnk8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDQuNSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEIgLyBTdGFibGU8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPkV4cG9ydCBQYWNraW5nIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPlNob3J0IFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDAuNSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEE0PGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5Gb3JlaWduIEJpbGwgUHVyY2hhc2U8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5TaG9ydCBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAwLjUgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBBNDxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPgAAZAILD2QWAgIBD2QWAmYPFQUJMDkgQXByIDE2EDx0ZCBjb2xzcGFuPScyJz7BBjxkaXYgY2xhc3M9J2NvbXBhbnknPjxkaXYgY2xhc3M9J3BkZic+PGEgaHJlZj0naHR0cDovL3NtZXJhLmluL2RvY3VtZW50cy9yYXRpbmdzL01hcnNDb25zdHJ1Y3Rpb24tUlItMjAxNjA0MDkucGRmJyB0YXJnZXQ9J19ibGFuayc+VmlldzwvYT48L2Rpdj48YSBocmVmDQogIA0KICAgIA0KPScuLi9kb2N1bWVudHMvcmF0aW5ncy9NYXJzQ29uc3RydWN0aW9uLVJSLTIwMTYwNDA5LnBkZicgdGFyZ2V0PSdfYmxhbmsnPk1hcnMgQ29uc3RydWN0aW9uPC9hPjxicj48L2Rpdj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPkNhc2ggQ3JlZGl0PC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAyIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQisgLyBTdGFibGU8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPkJhbmsgR3VhcmFudGVlPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+U2hvcnQgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMyBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEE0PGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+AABkAgwPZBYCAgEPZBYCZg8VBQkwOSBBcHIgMTYQPHRkIGNvbHNwYW49JzInPtgGPGRpdiBjbGFzcz0nY29tcGFueSc+PGRpdiBjbGFzcz0ncGRmJz48YSBocmVmPSdodHRwOi8vc21lcmEuaW4vZG9jdW1lbnRzL3JhdGluZ3MvUy5NLkNvbnN1bWVyc1ByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDA5LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlZpZXc8L2E+PC9kaXY+PGEgaHJlZg0KICANCiAgICANCj0nLi4vZG9jdW1lbnRzL3JhdGluZ3MvUy5NLkNvbnN1bWVyc1ByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDA5LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlMuTS4gQ29uc3VtZXJzIFByaXZhdGUgTGltaXRlZDwvYT48YnI+PC9kaXY+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5UZXJtIExvYW48L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDUuNDIgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBEPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5DYXNoIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMS40IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgRDxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPgAAZAIND2QWAgIBD2QWAmYPFQUJMDkgQXByIDE2EDx0ZCBjb2xzcGFuPScyJz6tCzxkaXYgY2xhc3M9J2NvbXBhbnknPjxkaXYgY2xhc3M9J3BkZic+PGEgaHJlZj0naHR0cDovL3NtZXJhLmluL2RvY3VtZW50cy9yYXRpbmdzL0EuUy5JbmR1c3RyaWVzLVJSLTIwMTYwNDA5LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlZpZXc8L2E+PC9kaXY+PGEgaHJlZg0KICANCiAgICANCj0nLi4vZG9jdW1lbnRzL3JhdGluZ3MvQS5TLkluZHVzdHJpZXMtUlItMjAxNjA0MDkucGRmJyB0YXJnZXQ9J19ibGFuayc+QS4gUy4gSW5kdXN0cmllczwvYT48YnI+PC9kaXY+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5TZWN1cmVkIG92ZXJkcmFmdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMi41IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQkItIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL1N1c3BlbmRlZC5naWYnIHRpdGxlPVN1c3BlbmRlZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlRlcm0gTG9hbjwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMi41OSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEJCLSAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9TdXNwZW5kZWQuZ2lmJyB0aXRsZT1TdXNwZW5kZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5JbmxhbmQgTGV0dGVyIG9mIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPlNob3J0IFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDAuOSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEE0PGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL1N1c3BlbmRlZC5naWYnIHRpdGxlPVN1c3BlbmRlZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlByb3Bvc2VkIExvbmcgVGVybSBCYW5rIEZhY2lsaXR5PC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAwLjUxIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQkItIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL1N1c3BlbmRlZC5naWYnIHRpdGxlPVN1c3BlbmRlZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4AAGQCDg9kFgICAQ9kFgJmDxUFCTA5IEFwciAxNhA8dGQgY29sc3Bhbj0nMic+vQ08ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9TYWt0aGlHZWFyUHJvZHVjdHMtUlItMjAxNjA0MDkucGRmJyB0YXJnZXQ9J19ibGFuayc+VmlldzwvYT48L2Rpdj48YSBocmVmDQogIA0KICAgIA0KPScuLi9kb2N1bWVudHMvcmF0aW5ncy9TYWt0aGlHZWFyUHJvZHVjdHMtUlItMjAxNjA0MDkucGRmJyB0YXJnZXQ9J19ibGFuayc+U2FrdGhpIEdlYXIgUHJvZHVjdHM8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDYgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCQiAgLyBTdGFibGU8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvVXBncmFkZWQuZ2lmJyB0aXRsZT1VcGdyYWRlZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlRlcm0gTG9hbjwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMS4zOCBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEJCICAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9VcGdyYWRlZC5naWYnIHRpdGxlPVVwZ3JhZGVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+TGV0dGVyIG9mIENyZWRpdCA8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5TaG9ydCBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAwLjQ3IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTQrPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL1VwZ3JhZGVkLmdpZicgdGl0bGU9VXBncmFkZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5MZXR0ZXIgb2YgR3VhcmFudGVlIDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPlNob3J0IFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDAuMDUgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBBNCs8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvVXBncmFkZWQuZ2lmJyB0aXRsZT1VcGdyYWRlZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlByb3Bvc2VkIEJhbmsgRmFjaWxpdHk8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDAuNTMgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCQiAgLyBTdGFibGU8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4AAGQCDw9kFgICAQ9kFgJmDxUFCTA3IEFwciAxNhA8dGQgY29sc3Bhbj0nMic+nQs8ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9CTlByZWNhc3RQcml2YXRlTGltaXRlZC1SUi0yMDE2MDQwNy5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL0JOUHJlY2FzdFByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDA3LnBkZicgdGFyZ2V0PSdfYmxhbmsnPkJOIFByZWNhc3QgUHJpdmF0ZSBMaW1pdGVkPC9hPjxicj48L2Rpdj4gPGRpdiBjbGFzcz0nZW50aXR5Jz48c3BhbiBjbGFzcz0nY3JpdGVyaWEnPlRlcm0gTG9hbiBJPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAwLjc3IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQiAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+VGVybSBMb2FuIElJPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAzLjAxIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQiAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDEuMjYgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5Qcm9wb3NlZDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMC4wOSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEIgLyBTdGFibGU8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4AAGQCEA9kFgICAQ9kFgJmDxUFCTA3IEFwciAxNhA8dGQgY29sc3Bhbj0nMic+tQQ8ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9TaHJlZUdhcm9kaVN0ZWVscy1SUi0yMDE2MDQwNy5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL1NocmVlR2Fyb2RpU3RlZWxzLVJSLTIwMTYwNDA3LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlNocmVlIEdhcm9kaSBTdGVlbHM8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+U2VjdXJlZCBvdmVyZHJhZnQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDExIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQkIgIC8gU3RhYmxlPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+AABkAhEPZBYCAgEPZBYCZg8VBQkwNyBBcHIgMTYQPHRkIGNvbHNwYW49JzInPpQJPGRpdiBjbGFzcz0nY29tcGFueSc+PGRpdiBjbGFzcz0ncGRmJz48YSBocmVmPSdodHRwOi8vc21lcmEuaW4vZG9jdW1lbnRzL3JhdGluZ3MvU3BhcmtsaW5lRXF1aXBtZW50c1ByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDA3LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlZpZXc8L2E+PC9kaXY+PGEgaHJlZg0KICANCiAgICANCj0nLi4vZG9jdW1lbnRzL3JhdGluZ3MvU3BhcmtsaW5lRXF1aXBtZW50c1ByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDA3LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlNwYXJrbGluZSBFcXVpcG1lbnRzIFByaXZhdGUgTGltaXRlZDwvYT48YnI+PC9kaXY+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5DYXNoIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPkxvbmcgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgNSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEJCICAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+TGV0dGVyIG9mIENyZWRpdDwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPlNob3J0IFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDEyIENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQTQrPGltZyBzcmM9J2h0dHA6Ly93d3cuc21lcmEuaW4vaW1hZ2VzL3JhdGluZy1wcm9jZXNzL0Fzc2lnbmVkLmdpZicgdGl0bGU9QXNzaWduZWQgLz48L3NwYW4+PC9kaXY+PGJyIGNsYXNzPSJjbGVhciI+IDxkaXYgY2xhc3M9J2VudGl0eSc+PHNwYW4gY2xhc3M9J2NyaXRlcmlhJz5CYW5rIEd1YXJhbnRlZTwvc3Bhbj4gPHNwYW4gY2xhc3M9J3Rlcm0nPlNob3J0IFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDUgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBBNCs8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4AAGQCEg9kFgICAQ9kFgJmDxUFCTA2IEFwciAxNhA8dGQgY29sc3Bhbj0nMic+2AQ8ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9BbWJpY2FJcm9uJlN0ZWVsUHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MDYucGRmJyB0YXJnZXQ9J19ibGFuayc+VmlldzwvYT48L2Rpdj48YSBocmVmDQogIA0KICAgIA0KPScuLi9kb2N1bWVudHMvcmF0aW5ncy9BbWJpY2FJcm9uJlN0ZWVsUHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MDYucGRmJyB0YXJnZXQ9J19ibGFuayc+QW1iaWNhIElyb24gJiBTdGVlbCBQcml2YXRlIExpbWl0ZWQ8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQgPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiA2IENSPC9zcGFuPjxzcGFuIGNsYXNzPSdyYXRlJz4gU01FUkEgQisgLyBTdGFibGU8aW1nIHNyYz0naHR0cDovL3d3dy5zbWVyYS5pbi9pbWFnZXMvcmF0aW5nLXByb2Nlc3MvQXNzaWduZWQuZ2lmJyB0aXRsZT1Bc3NpZ25lZCAvPjwvc3Bhbj48L2Rpdj48YnIgY2xhc3M9ImNsZWFyIj4AAGQCEw9kFgICAQ9kFgJmDxUFCTA2IEFwciAxNhA8dGQgY29sc3Bhbj0nMic+3wY8ZGl2IGNsYXNzPSdjb21wYW55Jz48ZGl2IGNsYXNzPSdwZGYnPjxhIGhyZWY9J2h0dHA6Ly9zbWVyYS5pbi9kb2N1bWVudHMvcmF0aW5ncy9Qb25tdXJ1Z2FuRGhhbGxNaWxscy1SUi0yMDE2MDQwNi5wZGYnIHRhcmdldD0nX2JsYW5rJz5WaWV3PC9hPjwvZGl2PjxhIGhyZWYNCiAgDQogICAgDQo9Jy4uL2RvY3VtZW50cy9yYXRpbmdzL1Bvbm11cnVnYW5EaGFsbE1pbGxzLVJSLTIwMTYwNDA2LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlBvbm11cnVnYW4gRGhhbGwgTWlsbHM8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDkuOSBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEJCLSAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+UHJvcG9zZWQgTm9uIEZ1bmQgQmFzZWQgPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+U2hvcnQgVGVybTwvc3Bhbj48c3BhbiBjbGFzcz0nYW1vdW50Jz5JTlIgMC4wMyBDUjwvc3Bhbj48c3BhbiBjbGFzcz0ncmF0ZSc+IFNNRVJBIEE0KzxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPgAAZAIUD2QWAgIBD2QWAmYPFQUJMDYgQXByIDE2EDx0ZCBjb2xzcGFuPScyJz6bCTxkaXYgY2xhc3M9J2NvbXBhbnknPjxkaXYgY2xhc3M9J3BkZic+PGEgaHJlZj0naHR0cDovL3NtZXJhLmluL2RvY3VtZW50cy9yYXRpbmdzL1JpY2hjb3JlTGlmZXNjaWVuY2VzUHJpdmF0ZUxpbWl0ZWQtUlItMjAxNjA0MDYucGRmJyB0YXJnZXQ9J19ibGFuayc+VmlldzwvYT48L2Rpdj48YSBocmVmDQogIA0KICAgIA0KPScuLi9kb2N1bWVudHMvcmF0aW5ncy9SaWNoY29yZUxpZmVzY2llbmNlc1ByaXZhdGVMaW1pdGVkLVJSLTIwMTYwNDA2LnBkZicgdGFyZ2V0PSdfYmxhbmsnPlJpY2hjb3JlIExpZmVzY2llbmNlcyBQcml2YXRlIExpbWl0ZWQ8L2E+PGJyPjwvZGl2PiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+Q2FzaCBDcmVkaXQ8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5Mb25nIFRlcm08L3NwYW4+PHNwYW4gY2xhc3M9J2Ftb3VudCc+SU5SIDIgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCLSAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+VGVybSBMb2FuPC9zcGFuPiA8c3BhbiBjbGFzcz0ndGVybSc+TG9uZyBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiA1LjUgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBCLSAvIFN0YWJsZTxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPiA8ZGl2IGNsYXNzPSdlbnRpdHknPjxzcGFuIGNsYXNzPSdjcml0ZXJpYSc+TGV0dGVyIG9mIENyZWRpdCA8L3NwYW4+IDxzcGFuIGNsYXNzPSd0ZXJtJz5TaG9ydCBUZXJtPC9zcGFuPjxzcGFuIGNsYXNzPSdhbW91bnQnPklOUiAwLjUgQ1I8L3NwYW4+PHNwYW4gY2xhc3M9J3JhdGUnPiBTTUVSQSBBNDxpbWcgc3JjPSdodHRwOi8vd3d3LnNtZXJhLmluL2ltYWdlcy9yYXRpbmctcHJvY2Vzcy9Bc3NpZ25lZC5naWYnIHRpdGxlPUFzc2lnbmVkIC8+PC9zcGFuPjwvZGl2PjxiciBjbGFzcz0iY2xlYXIiPgAAZAIJDw8WAh4EVGV4dGVkZAIPDxAPFgYeDkRhdGFWYWx1ZUZpZWxkBQJpZB4NRGF0YVRleHRGaWVsZAUIQ2F0ZWdvcnkfAGdkEBUKC05HTyBHcmFkaW5nEUJhbmsgTG9hbiBSYXRpbmdzIkNvcnBvcmF0ZSAmIEluZnJhc3RydWN0dXJlIFJhdGluZ3MWTlNJQyBEJkIgU01FUkEgUmF0aW5ncwtTTUUgUmF0aW5ncyhNaWNybyBGaW5hbmNlIEluc3RpdHV0aW9ucyBHcmFkaW5nIChNRkkpE1JFU0NPL1NvbGFyIEdyYWRpbmckTWFyaXRpbWUgVHJhaW5pbmcgSW5zdGl0dXRpb25zIChNVEkpKVByb2plY3QgR3JhZGluZy9HcmVlbmZpZWxkIGFuZCBCcm93bmZpZWxkDUdyZWVuIFJhdGluZ3MVCgIxMQExATUBNAEyATMCMTABNgE4ATkUKwMKZ2dnZ2dnZ2dnZ2RkAhsPFCsAAmQQFgAWABYAZAIdDw8WAh4HVmlzaWJsZWhkZAIfDw8WAh8CBSNTaG93aW5nIDEgdG8gMTIxOTggb2YgMTIxOTggcmVjb3Jkc2RkAiEPDxYCHwVoZGQCIw8PZBYCHgVzdHlsZQUNZGlzcGxheTpub25lO2QYAwUeX19Db250cm9sc1JlcXVpcmVQb3N0QmFja0tleV9fFhAFDmhlYWRlcjEkaW1nYnRuBQxDaGtQcm9kdWN0JDAFDENoa1Byb2R1Y3QkMQUMQ2hrUHJvZHVjdCQyBQxDaGtQcm9kdWN0JDMFDENoa1Byb2R1Y3QkNAUMQ2hrUHJvZHVjdCQ1BQxDaGtQcm9kdWN0JDYFDENoa1Byb2R1Y3QkNwUMQ2hrUHJvZHVjdCQ4BQxDaGtQcm9kdWN0JDkFDENoa1Byb2R1Y3QkOQUOQnRuRmluYWxTZWFyY2gFEWJ0bmNsZWFyc2VsZWN0aW9uBRZEYXRhUGFnZXIxJGN0bDAwJGN0bDAwBRZEYXRhUGFnZXIxJGN0bDAyJGN0bDAwBQpEYXRhUGFnZXIxDxQrAARkZAIUAqZfZAUGTHN0U01FDxQrAA5kZGRkZGRkPCsAFAACpl9kZGRmAhRktN+aK0koX65tvgEiYJbOxF9S4A1ZDPobHYfYrkLpO9I=">

        <input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="4AD88828">
        <input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="/wEdACFlF39g5oQfRe874tZaaPFhZnyT7mhEczBnOZh7VM+/IlOhAn/YhUrcrtqAeI6+OkiCayLekQ77MYsrgRXByfQgF0Dhpkl1nNz5e6dmE6dnzHRTr3s3m8GcmwVu2qYu5ecXP6t0Rcqexq4DNVm7nvD+Dy4FclcPPIrz9uFm9ZVt+v6DZBrlp4Wv154ssZZW8VzVK4xUN5MTWA2Q4+HdbBMXNLkTIHg9xHcv2OSivhFeVjMQ5kispLpi+GfUulZFP9m7kE33ytKotW52m5UaflgVUYBiQauv67NsiUdxmWjOtrO1C7lE/c33D3DXsU1LVMMfqASBqjdtbF7L2z5VhQbVbY3m2KYppm4VVgUBGeE6GnfOdvkoHBbtMsQtH1HPfya4MuQKxLvDyuqaOrN8b4KyzsoKVM0lTE5Ymrt36nSnM2aLkCCLnVxqWAc1dVRXdb8JNT0JOYkdhzKbJTtzbwRSQ5UhdGvk3TctiQB8SJ8f261Pm+/5aT4TB3Xnw1s66+KknSDv+dGkMzfxzMpA+SMoFejdtvsuIJjd933uIAkUJsZvdfSDdKKibaf+giRyS6y+aAgxGPHO/fZuhI6L/xpUkvDbheG+TO9QQxm8+yJTO9ZoeaA/UoiEk4gtvGX/vVKQWLIo8nlUkh4jiurJf2EmMXRmKK0eQ5t13d2bgn72exlw577zXeceGN1AFH+9I8IsKf5CioyJlmMp/Qz1OSMMWII9OxOBnRk+BIHproa9Ag==">
            <input type="hidden" name="TxtSearch" id="TxtSearch" value="{$SCompanyName}" />
        </form>
            {literal}
                <script type="text/javascript" >
                $( "#smera_link" ).click(function() {
                  $( "#smera_form" ).submit();
                });    
                </script>
            {/literal}
         <td>
             BRICKWORK
            <form action="http://www.brickworkratings.com/CreditRatings.aspx" name="form1" id="form1" method="post" target='_blank'>    
           <input type="hidden" name="__EVENTTARGET" id="__EVENTTARGET" value="">
           <input type="hidden" name="__EVENTARGUMENT" id="__EVENTARGUMENT" value="">
          <input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="{$B_VIEWSTATE}" />

           <input type="hidden" name="__VIEWSTATEGENERATOR" id="__VIEWSTATEGENERATOR" value="D090B1EF">
               <input type="hidden" name="__SCROLLPOSITIONX" id="__SCROLLPOSITIONX" value="0" />
               <input type="hidden" name="__SCROLLPOSITIONY" id="__SCROLLPOSITIONY" value="0" />
               <input type="hidden" name="__VIEWSTATEENCRYPTED" id="__VIEWSTATEENCRYPTED" value="" />
           <input type="hidden" name="__EVENTVALIDATION" id="__EVENTVALIDATION" value="{$B_EVENTVALIDATION}" />
               <input type="hidden" name="txtSearch" value="{$SCompanyName}" />
               <span> <input type="submit" name="btnSearch" style="border:none;color: #c0a172; font-weight: bold; text-decoration: underline; font-size: 16px; text-align: left; background: none; padding: 0;" value="View Rating" /> </span>
           </form>
        </td>
     </tr> 
    </tbody>
    </table> 
    </div>  
    
   <!-- {if $indexofchargeitems}   
    <div  class="work-masonry-thumb col-4" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
    <h2>Index Of Charge</h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="tableview download-links">
    <thead><tr><th>Charge ID </th> <th>Date of Charge </th> <th>Charge amount</th>  <th>Charge Holder Name</th> <th>Charge Holder Address</th> </tr></thead>
    {$indexofchargeitems}
    </table> 
    </div>    
    {/if}    
    -->
    
     {if $industry2}                                              
    <div  class="work-masonry-thumb col-3" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
    <h2>SIMILAR COMPANIES <a href="home.php?industryId={$industry1}"> View all</a></h2>
    <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
    <thead><tr><th>Company Name</th><th>Location</th> </tr></thead>
    <tbody>
      
            {section name=company loop=$industry2}
                {if $smarty.section.company.index lt 5}
                  <tr><td style="alt"><a href='details.php?vcid={$industry2[company].Company_Id}' >{$industry2[company].FCompanyName}</a></td> <td>{$industry2[company].state_name}</td></tr>
                  {/if}
{/section}
    </tbody>
    </table> 
    </div>
      {/if}  
      <!--{if $directors} 
        <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
               <h2>BOARD OF DIRECTORS</h2>
               <ul class="board-directors">

                    {section name=dir loop=$directors}
                        <li><a href='bod.php?ID={$directors[dir].DIN}&vcid={$VCID}' >{$directors[dir][1]}</a></li>

                    {/section}
                    </ul>
               </div> 
      {/if} -->
      {if $roc}
       <div  class="work-masonry-thumb col-1" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>REGISTERED</h2>
        <ul class="registered-trade"> <li><span>{$roc}</span></li></ul>
        </div>     
      {/if}  
          
         </div>
  </form>
		
  
</div>
{else}
			<h5>"Your Subscription limit of {$grouplimit[0][2]} companies has been reached. Please contact info@ventureintelligence.com to top up your subscription"</h5><br/>
                    {/if}
</div>
