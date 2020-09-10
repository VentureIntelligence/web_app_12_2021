
<input type="hidden" name="HmeSearch" id="HmeSearch" value="HmeSearch" />
<input type="hidden" name="permission" id="permission" value="{$authAdmin.Permissions}" />
<input type="hidden" name="CountingStatus" id="CountingStatus" value="{$authAdmin.CountingStatus}" />
<input type="hidden" name="Country" id="Country" value="" />

<div class="left-td-bg"> <a class="btn-slide {if $pageName eq 'home.php'}active {/if}" href="#">Slide Panel</a>
<div id="panel"  class="container-left" >


{* Tag Search *}
<div id='lastrefine'>
  <i class="fa fa-question-circle-o" id="tag-popup" aria-hidden="true" style="float: right;color: #fff;position: absolute;right: 55px;margin-top: 11px;font-size: 18px;cursor: pointer;"></i>
    <h2>
    {if $tagsearch neq ''}
    <span style="margin-top: 4px;margin-left: -1px;"> [-] </span>Tag Search<sup>*</sup></h2>
      <div class="acc_container acc_container_active" > 
    {else}
    <span style="margin-top: 4px;margin-left: -1px;"> [+] </span>Tag Search<sup>*</sup></h2>
      <div class="acc_container" > 
    {/if} 
  <ul>
    <li style="padding-bottom: 30px;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="growth-table" >
        <tr>
          <td Colspan="2">
            <input type="hidden" id="tagsearch" name="tagsearch" value="{$tagsearch}" placeholder="" >
            <input type="text" id="tagsearch_auto" name="tagsearch_auto" value="{$tagsearch}" placeholder="" > 
          </td>
        </tr>
      </table>
      <input type="hidden" id="tagradio" name="tagradio" value="{if $tagandor neq ''}{$tagandor}{else}0{/if}" placeholder="" style="width:220px;">
      <div class="btn-cnt"> <div class="switch-and-or"> 
        
      <input type="radio"  name="tagandor" id="gandd"  value="and"  {if $REQUEST.tagandor=="and" }checked="checked"{elseif $REQUEST.tagandor==""}checked="checked"{/if}/>
      <input type="radio"  name="tagandor" id="gorr"   value="or" {if $REQUEST.tagandor=="or" }checked="checked"{/if} />
      <label for="gandd" class="{if $REQUEST.tagandor=="and" } cb-enable selected {elseif $REQUEST.tagandor==""}cb-enable selected  {else}cb-disable{/if}"><span>AND</span></label>
      <label for="gorr" class="{if $REQUEST.tagandor=="or" } cb-enable selected {else}cb-disable{/if}"><span>OR</span></label>
      </div>
      <input name="refine" type="submit" value="Refine" class="refine" style="width: auto!important;padding: 4px 30px;float: right;background-position: 107% 7px!important;min-width: 120px;"/>
    </li>
  </ul>
   <p style="padding: 5px;">*limited to PE backed companies</p>
  </div>
</div>
{* Tag Search *}



<div style="width:264px; display:block; overflow:hidden;">

<h2 class="active"><span> [-] </span> REFINE SEARCH</h2>
<div class="acc_container acc_container_active" style="display:block; "> 
<ul>
<li><h3>Transaction Status</h3>

<label> <input type="checkbox" name="answer[Permissions]" id="answer[Permissions]" value="0" {if $REQUEST_Answer.Permissions eq "0" or count($REQUEST_Answer) eq 0} checked {/if} /> PE Backed</label>
<label> <input type="checkbox" name="answer[Permissions2]" id="answer[Permissions2]" value="1" {if $REQUEST_Answer.Permissions2 eq 1 or count($REQUEST_Answer) eq 0} checked {/if}/> Non-PE Backed</label>
</li>
<li>
    <div style="clear:both">   
<h3>Regions{$REQUEST_Answer.val}</h3>
<select id="Region" multiple="multiple" name="answer[Region][]" class="multi-select1"  forError="Region" onchange="changeregion();" >
    <option value="South"  {if in_array("South",$REQUEST_Answer.Region)} selected {/if}>South</option>
    <option value="North"   {if in_array("North",$REQUEST_Answer.Region)} selected {/if}>North</option>
    <option value="West"    {if in_array("West",$REQUEST_Answer.Region)} selected {/if}>West</option>
    <option value="East"    {if in_array("East",$REQUEST_Answer.Region)} selected {/if}>East</option>
    <option value="Central"   {if in_array("Central",$REQUEST_Answer.Region)} selected {/if}>Central</option>
</select>
    </div>
    <div style="clear:both">   
<h3>state </h3>
<div id="statedisplay">
<select id="State" multiple="multiple" name="answer[State][]"  class="multi-select1"   forError="State"   onchange="changestate();">
    {html_options options=$state selected=$REQUEST_Answer.State}
</select>
</div>
    </div>   
    <div style="clear:both">   
<h3>city</h3>
<span id="citydisplay">
<select id="City" multiple="multiple" name="answer[City][]"  class="multi-select1"   forError="City">
    {html_options options=$city selected=$REQUEST_Answer.City}
 </select>
</span>
    </div>   
</li>

<li class="year-select">
<h3>Year founded</h3>

<div class="year-after"><label>After </label> 
<select name="answer[YearGrtr]" style="" class="styled dateclass">	
    <option value=''>--select--</option>				
    {html_options options=$BYearArry1 selected=$REQUEST_Answer.YearGrtr}
</select></div>
<div class="year-before"><label>before</label> 
<select name="answer[YearLess]" style="" class="styled dateclass">		
        <option value=''>--select--</option>
        {html_options options=$BYearArry1 selected=$REQUEST_Answer.YearLess}	
</select></div>
  
</li>

<li style="position: relative;">
<h3>Auditor Name</h3>
<input autocomplete="off" type="text" name="auditorname" id="auditorname"  class="auditorname" value="{if $auditorname}{$auditorname}{/if}" style="width:100% !important;margin-bottom: 0px;"  {if $auditorname}readonly{/if}> 
           <span id="auditor_clearall" title="Clear All" onclick="clear_auditorname();" style=" {if $auditorname eq ''}display:none;{/if}background: #ccc;  position: absolute;  top: 51px;  right: 12px;  padding: 5px;">(X)</span> 
           <div id="auditorname_suggest" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;">
        
    </div>
</li>

<li class="year-select">
<h3>Financials Result Type</h3>
<select name="ResultType" style="" id="select-resultType">  
    <option value="0" {if $REQUEST.ResultType eq "0" } selected {/if}>Standalone</option>
    <option value="1" {if $REQUEST.ResultType eq "1"} selected {/if}>Consolidated</option>
    <option value="both" {if $REQUEST.ResultType eq "both" or count($REQUEST) eq 0} selected {/if}>Both</option>
</select>
<!-- <label for="Standalone" ><input type="radio" name="ResultType" id="Standalone" value="0" {if $REQUEST.ResultType eq "0" or count($REQUEST) eq 0} checked {/if}/>  Standalone </label>
<label for="Consolidated" ><input type="radio" name="ResultType" id="Consolidated" value="1" {if $REQUEST.ResultType eq "1"} checked {/if}/>  Consolidated  </label> -->
</li>

<li class="btn-cnt"><input name="refine" type="submit" value="Refine" class="refine"/> <input name="refinecancel" type="button" value="Cancel" /> </li>
</ul>
</div> 


<h2><span> [+] </span> FINANCIAL BASED </h2>

{if $REQUEST.Crores neq '' or $REQUEST.arcossall neq '' or $REQUEST.financesearchfieds neq ''}
<div class="acc_container acc_container_active" > 
{else}
<div class="acc_container" > 
{/if} 


<ul>

<li>
 
<div class="growth-yr"> 
    <label for="Crores"><input type="checkbox" name="Crores" id="Crores" value="10000000" {if $REQUEST.Crores eq "10000000" or count($REQUEST) eq 0} checked {/if}/>  In Cr <span style="margin-left:10px;">Year:</span> </label>
<label for="anyof"><input type="radio" name="arcossall" id="anyof" value="AnyOf" {if $REQUEST.arcossall eq ("AnyOf")} checked {/if}/>  Any Of  </label>
<label for="acrossall"><input type="radio" name="arcossall" id="acrossall" value="across" {if $REQUEST.arcossall eq ("across")} checked {/if}/> Across All </label>
</div>
    
<div class="selectgroup" style="display: inline-flex;">

<select class="multi-select" multiple="multiple" id="financesearchfieds" name="financesearchfieds[]"  >
        <!--<option value="" >Please Select a Field</option>-->
        <option value="0" label="TotalIncome" {if in_array("0", $REQUEST.financesearchfieds)} selected {/if}>Revenue</option>
        <option value="1" label="EBITDA" {if in_array("1", $REQUEST.financesearchfieds)} selected {/if}>EBITDA</option>
        <!--<option value="2" label="EBDT">EBDT</option>
        <option value="3" label="EBT">EBT</option>-->
        <option value="4" label="PAT" {if in_array("4", $REQUEST.financesearchfieds)} selected {/if}>Net Profit</option>
        
        <option value="5" label="Long term borrowings+Short-term borrowings" {if in_array("5", $REQUEST.financesearchfieds)} selected {/if}>Total Debt</option>
        <option value="6" label="Total shareholders' funds" {if in_array("6", $REQUEST.financesearchfieds)} selected {/if}>Networth</option>
        <option value="7" label="Total Debt+Net worth" {if in_array("7", $REQUEST.financesearchfieds)} selected {/if}>Capital Employed</option>
</select>
<input name="refine" type="button" value="ADD" id="addfinance" style="vertical-align: top;margin-top: 4px;" />   </div>

  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="growth-table" id="fintable">
 <thead> <tr>
    <th>Fields</th>
    <th>Greater than </th>
    <th>Less than </th>
  </tr>
  </thead>
  
  <tbody>
    {$finfieldshtml}
  </tbody>
</table>
 <!-- Dynamic Images Add Ends -->	

		<div class="maindiv" style="display:none;">
			<div class="descdiv">
					<select id="answer[SearchFieds][]" name="answer[SearchFieds][]"  class="" forError="Sector">
						   <option value="" >Please Select a Field</option>
						   <option value="0" label="TotalIncome">Revenue</option>
						   <option value="1" label="EBITDA">EBITDA</option>
						   <!--<option value="2" label="EBDT">EBDT</option>
						   <option value="3" label="EBT">EBT</option>-->
						   <option value="4" label="PAT">Net Profit</option>
				 	</select>
			</div>
			
			<div class="gretrdiv">Greater than&nbsp;<input  type="text" name="OptnlIncomeGrtr" id="OptnlIncomeGrtr" /></div>
			<div class="lesrdiv">Less than&nbsp;<input  type="text" name="OptnlIncomeLess" id="OptnlIncomeLess" /></div>			
		</div>

  
 <div class="btn-cnt"> <div class="switch-and-or" style="margin-bottom:10px;"> 
    <input type="radio"  name="Commonandor" id="fand"  value="and"  checked="checked"/>
   <input type="radio"  name="Commonandor" id="for"   value="or"/>
    <label for="fand" class="{if $REQUEST.Commonandor=="and" } cb-enable selected {elseif $REQUEST.Commonandor==""}cb-enable selected  {else}cb-disable{/if}"><span>AND</span></label>
    <label for="for" class="{if $REQUEST.Commonandor=="or" } cb-enable selected {else}cb-disable{/if}"><span>OR</span></label>
 

</div> 

<input name="refine" type="submit" value="Refine" class="refine"/>  <input name="cancel" type="button" value="Cancel" />
</div>
</li> 
</ul>


</div>

  <div >
<h2><span> [+] </span>GROWTH BASED</h2>

{if $REQUEST.YOYCAGR neq '' or $growthfieldshtml neq ''}
<div class="acc_container acc_container_active" > 
{else}
<div class="acc_container" > 
{/if} 

<ul>

<li>
<div class="growth-yr">

 
   <label for="gacrossall"><input type="radio" name="YOYCAGR" id="gacrossall" value="gacross" {if $REQUEST.YOYCAGR eq "gacross"} checked {/if} /> ALL YEARS</label>
    <label for="ganyof" ><input type="radio" name="YOYCAGR" id="ganyof" value="gAnyOf" {if $REQUEST.YOYCAGR eq "gAnyOf"} checked {/if} /> ANY YEARS</label>
    <label for="YOYCAGR"><input type="radio" name="YOYCAGR" id="YOYCAGR" value="CAGR" {if $REQUEST.YOYCAGR eq "CAGR"} checked {/if}/> CAGR </label>   
   
</div>
 
  
<div class="fields-add">
<select  id="growthsearchfieds" name="growthsearchfieds"  class="multi-select"  multiple="multiple">
        <option value="0"  {if in_array("0", $REQUEST.answer.GrowthSearchFieds)} selected {/if}>Revenue</option>
        <option value="1" {if in_array("1", $REQUEST.answer.GrowthSearchFieds)} selected {/if}>EBITDA</option>
        <!--<option value="2">EBDT</option>
        <option value="3">EBT</option>-->
        <option value="4" {if in_array("4", $REQUEST.answer.GrowthSearchFieds)} selected {/if}>Net Profit</option>
        
        <!--<option value="5">Across all</option>
        <option value="6">In any of</option>-->
</select>
<input name="addgrowth" type="button" value="ADD" id="addgrowth"  />   </div>
 
  <table width="100%" border="0" cellspacing="0" cellpadding="0" class="growth-table" id="growth-table">
 <thead> <tr>
    <th>Fields</th>
    <th>More than(%)</th>
    <th># of Yrs</th>
  </tr>
  </thead>
  
  <tbody>
      {$growthfieldshtml}
  </tbody>
</table>
 
  
 <div class="btn-cnt"> <div class="switch-and-or"> 
   <input type="radio"  name="growthandor" id="gand"  value="and"  checked="checked"/>
  <input type="radio"  name="growthandor" id="gor"   value="or"/>
    <label for="gand" class="{if $REQUEST.growthandor=="and" } cb-enable selected {elseif $REQUEST.growthandor==""}cb-enable selected  {else}cb-disable{/if}"><span>AND</span></label>
    <label for="gor" class="{if $REQUEST.growthandor=="or" } cb-enable selected {else}cb-disable{/if}"><span>OR</span></label>
 

</div> 

<input name="refine" type="submit" value="Refine" class="refine"/>  <input name="cancel" type="button" value="Cancel" />
</div>

  <div class="maindivGrowth" style="display:none;">
			<div class="descdiv">
				<select id="answer[GrowthSearchFieds][]" name="answer[GrowthSearchFieds][]"  class="" forError="Sector">
					<option value="" >Please Select a Field</option>
					<option value="0">TotalIncome</option>
					<option value="1">EBITDA</option>
					<option value="2">EBDT</option>
					<!--<option value="3">EBT</option>
					<option value="4">PAT</option>-->
				</select>
			</div>
			<div class="gretrdiv">Greater than&nbsp;%<input  type="text" name="GrothPerc_'+g+'" id="GrothPerc_0"  size="4"/></div>
			<div class="lesrdiv">No.of Years&nbsp;<input  type="text" name="NumYears_'+g+'" id="NumYears_0" size="4"/></div>
		</div>
  </li>
  
</ul>

</div>
  </div>
 
  
    <!-- -->
<div>
<h2><span> [+] </span>Charges based</h2>

{if $chargewhere neq ''}
<div class="acc_container acc_container_active" > 
{else}
<div class="acc_container" > 
{/if} 

<ul>

<li>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="growth-table" id="fintable">
    <tr><td colspan="2">Charge Date</td></tr>   
    <tr> <td><input type="text" name="chargefromdate" id="chargefromdate" value="{if $chargefromdate}{$chargefromdate}{/if}" style="width:100% !important"></td>  <td><input type="text" name="chargetodate" id="chargetodate"  value="{if $chargetodate}{$chargetodate}{/if}" style="width:100% !important"></td>  </tr>
<tr><td colspan="2">Charge Amount (in Rs. Cr)</td></tr>  
<tr> <td><input type="text" name="chargefromamount" id="chargefromamount" onkeypress="return isNumber(event)" value="{if $chargefromamount}{$chargefromamount}{/if}" style="width:100% !important"></td>  <td><input type="text" name="chargetoamount" id="chargetoamount"onkeypress="return isNumber(event)" value="{if $chargetoamount}{$chargetoamount}{/if}" style="width:100% !important"></td>  </tr>
<tr><td colspan="2">Charge Holder</td></tr>  
{*<tr> <td Colspan="2"><input type="text" name="chargeholdertest" id="chargeholdertest"  value="{if $chargeholder}{$chargeholder}{/if}" style="width:100% !important"> <img  id="autosuggest_loading2"  src="images/autosuggest_loading.gif" style="display:none;"></td>  </tr>*}
<tr> <td Colspan="2" style="position:relative" id="chholderfilter"><input autocomplete="off" type="text" name="chargeholdertest" id="chargeholdertest"  class="chargeholdertest" value="{if $chargeholdertest}{$chargeholdertest}{/if}" style="width:100% !important"  {if $chargeholdertest}readonly{/if}> 
           <span id="charge_clearall" title="Clear All" onclick="clear_chholder();" style=" {if $chargeholdertest eq ''}display:none;{/if}background: #ccc;  position: absolute;  top: 7px;  right: 8px;  padding: 5px;">(X)</span> 
           <div id="testholder" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none; width:225px;">
        
    </div>
       </td>  </tr>
<tr><td colspan="2">Address (city)</td></tr>  
<tr><td Colspan="2"><input type="text" name="chargeaddress" id="chargeaddress"  value="{if $chargeaddress}{$chargeaddress}{/if}" style="width:100% !important" > <img  id="autosuggest_loading3"  src="images/autosuggest_loading.gif" style="display:none;"></td>  </tr>

</table>

    <div class="btn-cnt">
    <input name="refine" type="submit" value="Refine" class="refine"/>  <input name="cancel" type="button" value="Cancel" />
</div>

</li>

</ul>
    
</div>
</div>
  <!-- -->
  
</div>
  
  





{*<ul>
<li>
<table width="100%" border="0" cellspacing="0" cellpadding="0" class="growth-table" id="fintable">
   <tr><td colspan="2">Charge Holder</td></tr>  
   <tr> <td Colspan="2" style="position:relative">
           <input type="text" name="chargeholdertest" id="chargeholdertest"  style="width:100% !important"> 
           <span id="charge_clearall" title="Clear All" onclick="clear_chholder();" style="display:none;background: #ccc;  position: absolute;  top: 7px;  right: 8px;  padding: 5px;">(X)</span> 
       </td>  </tr>
</table>  
    <div id="testholder" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;">
        
</div>
</li>
</ul>*}

</div>

</div>
</div>
 <input type="hidden" name="resetfield" value="" id="resetfield"/>	
   <input type="hidden" name="resetfieldindex" value="" id="resetfieldindex"/>

  