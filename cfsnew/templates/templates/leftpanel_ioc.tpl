{literal}
    <script>
    $(document).ready(function(){
    var searchhead = $(".search-main").height();
var tophead = $(".header-right").height();
var overall = $(window).height();
var headsection = searchhead + tophead;
var bodyheight = overall - headsection;
var containerheight = $(".container-right").height();
//$(".container-right").css("height",bodyheight);
if(containerheight > overall){
    $("#panel").css("height",containerheight);
}else{
$("#panel").css("height",bodyheight);
}
});
    </script>
    <style>
    .container-left .growth-table td {
    padding: 3px 0px !important;
}
    .ui-state-default .ui-icon {
    background-image: url(images/ui-icons_888888_256x240.png) !important;
}
    .container-left li{
        border-bottom : 1px solid transparent !important;
    }
.token-input-list-facebook{
    padding: 2px 1px;
}
li.token-input-token-facebook {
    margin: 2px 3px 2px 3px;
    padding: 3px;
}

    button.ui-multiselect.ui-widget.ui-state-default.ui-corner-all {
    margin-bottom: auto;
    width: 245px !important;
}
.ui-multiselect-filter input {
    width: 215px !important;
    font-size: 10px !important;
    margin-left: 0px !important;
    height: 15px !important;
    padding: 5px !important;
    border: 1px solid #999999 !important;
    -webkit-appearance: textfield;
    -webkit-box-sizing: content-box;
    margin-bottom: 2px;
}
.ui-multiselect-menu {
    display: none;
    padding: 3px;
    position: absolute;
    z-index: 10000;
    text-align: left;
    height: auto;
    width: 245px !important;
}
    </style>
{/literal}
<input type="hidden" name="HmeSearch" id="HmeSearch" value="HmeSearch" />
<input type="hidden" name="permission" id="permission" value="{$authAdmin.Permissions}" />
<input type="hidden" name="CountingStatus" id="CountingStatus" value="{$authAdmin.CountingStatus}" />
<input type="hidden" name="Country" id="Country" value="" />

<div class="left-td-bg"> <a class="btn-slide active" href="#">Slide Panel</a>
<div id="panel"  class="container-left" >


<div style="width:264px; display:block; overflow:hidden;">



 
  
    <!-- -->
<div>
<h2 class="active"><span> [-] </span>Charges based</h2>

{if $chargewhere neq ''}
<div class="acc_container acc_container_active" > 
{else}
<div class="acc_container acc_container_active" > 
{/if} 

<ul>

<li >

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="growth-table" id="fintable">
    <tr><td colspan="2">Charge Date</td></tr>   
    <tr> <td style="padding-right:4px !important;"><input type="text" name="chargefromdate" id="chargefromdate" autocomplete="off" value="{if $chargefromdate}{$chargefromdate}{/if}" style="width:100% !important"></td>  <td><input type="text" name="chargetodate" id="chargetodate"  autocomplete="off" value="{if $chargetodate}{$chargetodate}{/if}" style="width:100% !important"></td>  </tr>
<tr><td colspan="2">Charge Amount (in Rs. Cr)</td></tr>  
<tr> <td style="padding-right:4px !important;"><input type="text" name="chargefromamount" id="chargefromamount" autocomplete="off"  onkeypress="return isNumber(event)" value="{if $chargefromamount}{$chargefromamount}{/if}" style="width:100% !important"></td>  <td><input type="text" name="chargetoamount" id="chargetoamount" autocomplete="off" onkeypress="return isNumber(event)" value="{if $chargetoamount}{$chargetoamount}{/if}" style="width:100% !important"></td>  </tr>
{* <tr><td colspan="2">Charge Holder</td></tr>   *}
{*<tr> <td Colspan="2"><input type="text" name="chargeholdertest" id="chargeholdertest"  value="{if $chargeholder}{$chargeholder}{/if}" style="width:100% !important"> <img  id="autosuggest_loading2"  src="images/autosuggest_loading.gif" style="display:none;"></td>  </tr>*}
{* <tr> <td Colspan="2" style="position:relative" id="chholderfilter"><input autocomplete="off" type="text" name="chargeholdertest" id="chargeholdertest"  class="chargeholdertest" value="{if $chargeholdertest}{$chargeholdertest}{/if}" style="width:100% !important"  {if $chargeholdertest}readonly{/if}> 
           <span id="charge_clearall" title="Clear All" onclick="clear_chholder();" style=" {if $chargeholdertest eq ''}display:none;{/if}background: #ccc;  position: absolute;  top: 7px;  right: 8px;  padding: 5px;">(X)</span> 
           <div id="testholder" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none; width:225px;">
        
    </div>
       </td>  </tr> *}
 <tr><td colspan="2">State</td></tr>  
<tr><td Colspan="2"><select id="State" multiple="multiple" name="answer[State][]"  class="multi"   forError="State">
    {html_options options=$iocstate selected=$states}
    
</select></td>  </tr> 
<tr><td colspan="2">City</td></tr>  
<tr><td Colspan="2"><select id="City" multiple="multiple" name="answer[City][]"  class="multi"   forError="City">
    {html_options options=$ioccity selected=$cities}
   
 </select></td>  </tr>
<input type="hidden" name="name" id="ChargesholderName" value="{if $ChargesholderName}{$ChargesholderName}{/if}" style="width:100% !important">
{* <tr><td colspan="2">Address (city)</td></tr>  
<tr><td Colspan="2"><input type="text" name="chargeaddress" id="chargeaddress" autocomplete="off"  value="{if $chargeaddress}{$chargeaddress}{/if}" style="width:100% !important" > <img  id="autosuggest_loading3"  src="images/autosuggest_loading.gif" style="display:none;"></td>  </tr>
<input type="hidden" name="name" id="ChargesholderName" value="{if $ChargesholderName}{$ChargesholderName}{/if}" style="width:100% !important"> *}
</table>

    <div class="btn-cnt">
    <input name="refine" type="submit" value="Refine" class="refine"/> {*  <input name="cancel" type="button" value="Cancel" /> *}
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

  