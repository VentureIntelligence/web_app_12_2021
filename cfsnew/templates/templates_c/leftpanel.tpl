<?php /* Smarty version 2.5.0, created on 2020-07-09 14:31:48
         compiled from leftpanel.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'leftpanel.tpl', 75, false),)); ?>
<input type="hidden" name="HmeSearch" id="HmeSearch" value="HmeSearch" />
<input type="hidden" name="permission" id="permission" value="<?php echo $this->_tpl_vars['authAdmin']['Permissions']; ?>
" />
<input type="hidden" name="CountingStatus" id="CountingStatus" value="<?php echo $this->_tpl_vars['authAdmin']['CountingStatus']; ?>
" />
<input type="hidden" name="Country" id="Country" value="" />

<div class="left-td-bg"> <a class="btn-slide <?php if ($this->_tpl_vars['pageName'] == 'home.php'): ?>active <?php endif; ?>" href="#">Slide Panel</a>
<div id="panel"  class="container-left" >



<div id='lastrefine'>
  <i class="fa fa-question-circle-o" id="tag-popup" aria-hidden="true" style="float: right;color: #fff;position: absolute;right: 55px;margin-top: 11px;font-size: 18px;cursor: pointer;"></i>
    <h2>
    <?php if ($this->_tpl_vars['tagsearch'] != ''): ?>
    <span style="margin-top: 4px;margin-left: -1px;"> [-] </span>Tag Search<sup>*</sup></h2>
      <div class="acc_container acc_container_active" > 
    <?php else: ?>
    <span style="margin-top: 4px;margin-left: -1px;"> [+] </span>Tag Search<sup>*</sup></h2>
      <div class="acc_container" > 
    <?php endif; ?> 
  <ul>
    <li style="padding-bottom: 30px;">
      <table width="100%" border="0" cellspacing="0" cellpadding="0" class="growth-table" >
        <tr>
          <td Colspan="2">
            <input type="hidden" id="tagsearch" name="tagsearch" value="<?php echo $this->_tpl_vars['tagsearch']; ?>
" placeholder="" >
            <input type="text" id="tagsearch_auto" name="tagsearch_auto" value="<?php echo $this->_tpl_vars['tagsearch']; ?>
" placeholder="" > 
          </td>
        </tr>
      </table>
      <input type="hidden" id="tagradio" name="tagradio" value="<?php if ($this->_tpl_vars['tagandor'] != ''): ?><?php echo $this->_tpl_vars['tagandor']; ?>
<?php else: ?>0<?php endif; ?>" placeholder="" style="width:220px;">
      <div class="btn-cnt"> <div class="switch-and-or"> 
        
      <input type="radio"  name="tagandor" id="gandd"  value="and"  <?php if ($this->_tpl_vars['REQUEST']['tagandor'] == 'and'): ?>checked="checked"<?php elseif ($this->_tpl_vars['REQUEST']['tagandor'] == ""): ?>checked="checked"<?php endif; ?>/>
      <input type="radio"  name="tagandor" id="gorr"   value="or" <?php if ($this->_tpl_vars['REQUEST']['tagandor'] == 'or'): ?>checked="checked"<?php endif; ?> />
      <label for="gandd" class="<?php if ($this->_tpl_vars['REQUEST']['tagandor'] == 'and'): ?> cb-enable selected <?php elseif ($this->_tpl_vars['REQUEST']['tagandor'] == ""): ?>cb-enable selected  <?php else: ?>cb-disable<?php endif; ?>"><span>AND</span></label>
      <label for="gorr" class="<?php if ($this->_tpl_vars['REQUEST']['tagandor'] == 'or'): ?> cb-enable selected <?php else: ?>cb-disable<?php endif; ?>"><span>OR</span></label>
      </div>
      <input name="refine" type="submit" value="Refine" class="refine" style="width: auto!important;padding: 4px 30px;float: right;background-position: 107% 7px!important;min-width: 120px;"/>
    </li>
  </ul>
   <p style="padding: 5px;">*limited to PE backed companies</p>
  </div>
</div>




<div style="width:264px; display:block; overflow:hidden;">

<h2 class="active"><span> [-] </span> REFINE SEARCH</h2>
<div class="acc_container acc_container_active" style="display:block; "> 
<ul>
<li><h3>Transaction Status</h3>

<label> <input type="checkbox" name="answer[Permissions]" id="answer[Permissions]" value="0" <?php if ($this->_tpl_vars['REQUEST_Answer']['Permissions'] == '0' || count ( $this->_tpl_vars['REQUEST_Answer'] ) == 0): ?> checked <?php endif; ?> /> PE Backed</label>
<label> <input type="checkbox" name="answer[Permissions2]" id="answer[Permissions2]" value="1" <?php if ($this->_tpl_vars['REQUEST_Answer']['Permissions2'] == 1 || count ( $this->_tpl_vars['REQUEST_Answer'] ) == 0): ?> checked <?php endif; ?>/> Non-PE Backed</label>
</li>
<li>
    <div style="clear:both">   
<h3>Regions<?php echo $this->_tpl_vars['REQUEST_Answer']['val']; ?>
</h3>
<select id="Region" multiple="multiple" name="answer[Region][]" class="multi-select1"  forError="Region" onchange="changeregion();" >
    <option value="South"  <?php if (in_array ( 'South' , $this->_tpl_vars['REQUEST_Answer']['Region'] )): ?> selected <?php endif; ?>>South</option>
    <option value="North"   <?php if (in_array ( 'North' , $this->_tpl_vars['REQUEST_Answer']['Region'] )): ?> selected <?php endif; ?>>North</option>
    <option value="West"    <?php if (in_array ( 'West' , $this->_tpl_vars['REQUEST_Answer']['Region'] )): ?> selected <?php endif; ?>>West</option>
    <option value="East"    <?php if (in_array ( 'East' , $this->_tpl_vars['REQUEST_Answer']['Region'] )): ?> selected <?php endif; ?>>East</option>
    <option value="Central"   <?php if (in_array ( 'Central' , $this->_tpl_vars['REQUEST_Answer']['Region'] )): ?> selected <?php endif; ?>>Central</option>
</select>
    </div>
    <div style="clear:both">   
<h3>state </h3>
<div id="statedisplay">
<select id="State" multiple="multiple" name="answer[State][]"  class="multi-select1"   forError="State"   onchange="changestate();">
    <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['state'],'selected' => $this->_tpl_vars['REQUEST_Answer']['State']), $this) ; ?>

</select>
</div>
    </div>   
    <div style="clear:both">   
<h3>city</h3>
<span id="citydisplay">
<select id="City" multiple="multiple" name="answer[City][]"  class="multi-select1"   forError="City">
    <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['city'],'selected' => $this->_tpl_vars['REQUEST_Answer']['City']), $this) ; ?>

 </select>
</span>
    </div>   
</li>

<li class="year-select">
<h3>Year founded</h3>

<div class="year-after"><label>After </label> 
<select name="answer[YearGrtr]" style="" class="styled dateclass">	
    <option value=''>--select--</option>				
    <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['BYearArry1'],'selected' => $this->_tpl_vars['REQUEST_Answer']['YearGrtr']), $this) ; ?>

</select></div>
<div class="year-before"><label>before</label> 
<select name="answer[YearLess]" style="" class="styled dateclass">		
        <option value=''>--select--</option>
        <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['BYearArry1'],'selected' => $this->_tpl_vars['REQUEST_Answer']['YearLess']), $this) ; ?>
	
</select></div>
  
</li>

<li style="position: relative;">
<h3>Auditor Name</h3>
<input autocomplete="off" type="text" name="auditorname" id="auditorname"  class="auditorname" value="<?php if ($this->_tpl_vars['auditorname']): ?><?php echo $this->_tpl_vars['auditorname']; ?>
<?php endif; ?>" style="width:100% !important;margin-bottom: 0px;"  <?php if ($this->_tpl_vars['auditorname']): ?>readonly<?php endif; ?>> 
           <span id="auditor_clearall" title="Clear All" onclick="clear_auditorname();" style=" <?php if ($this->_tpl_vars['auditorname'] == ''): ?>display:none;<?php endif; ?>background: #ccc;  position: absolute;  top: 51px;  right: 12px;  padding: 5px;">(X)</span> 
           <div id="auditorname_suggest" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none;">
        
    </div>
</li>

<li class="year-select">
<h3>Financials Result Type</h3>
<select name="ResultType" style="" id="select-resultType">  
    <option value="0" <?php if ($this->_tpl_vars['REQUEST']['ResultType'] == '0'): ?> selected <?php endif; ?>>Standalone</option>
    <option value="1" <?php if ($this->_tpl_vars['REQUEST']['ResultType'] == '1'): ?> selected <?php endif; ?>>Consolidated</option>
    <option value="both" <?php if ($this->_tpl_vars['REQUEST']['ResultType'] == 'both' || count ( $this->_tpl_vars['REQUEST'] ) == 0): ?> selected <?php endif; ?>>Both</option>
</select>
<!-- <label for="Standalone" ><input type="radio" name="ResultType" id="Standalone" value="0" <?php if ($this->_tpl_vars['REQUEST']['ResultType'] == '0' || count ( $this->_tpl_vars['REQUEST'] ) == 0): ?> checked <?php endif; ?>/>  Standalone </label>
<label for="Consolidated" ><input type="radio" name="ResultType" id="Consolidated" value="1" <?php if ($this->_tpl_vars['REQUEST']['ResultType'] == '1'): ?> checked <?php endif; ?>/>  Consolidated  </label> -->
</li>

<li class="btn-cnt"><input name="refine" type="submit" value="Refine" class="refine"/> <input name="refinecancel" type="button" value="Cancel" /> </li>
</ul>
</div> 


<h2><span> [+] </span> FINANCIAL BASED </h2>

<?php if ($this->_tpl_vars['REQUEST']['Crores'] != '' || $this->_tpl_vars['REQUEST']['arcossall'] != '' || $this->_tpl_vars['REQUEST']['financesearchfieds'] != ''): ?>
<div class="acc_container acc_container_active" > 
<?php else: ?>
<div class="acc_container" > 
<?php endif; ?> 


<ul>

<li>
 
<div class="growth-yr"> 
    <label for="Crores"><input type="checkbox" name="Crores" id="Crores" value="10000000" <?php if ($this->_tpl_vars['REQUEST']['Crores'] == '10000000' || count ( $this->_tpl_vars['REQUEST'] ) == 0): ?> checked <?php endif; ?>/>  In Cr <span style="margin-left:10px;">Year:</span> </label>
<label for="anyof"><input type="radio" name="arcossall" id="anyof" value="AnyOf" <?php if ($this->_tpl_vars['REQUEST']['arcossall'] == ( 'AnyOf' )): ?> checked <?php endif; ?>/>  Any Of  </label>
<label for="acrossall"><input type="radio" name="arcossall" id="acrossall" value="across" <?php if ($this->_tpl_vars['REQUEST']['arcossall'] == ( 'across' )): ?> checked <?php endif; ?>/> Across All </label>
</div>
    
<div class="selectgroup" style="display: inline-flex;">

<select class="multi-select" multiple="multiple" id="financesearchfieds" name="financesearchfieds[]"  >
        <!--<option value="" >Please Select a Field</option>-->
        <option value="0" label="TotalIncome" <?php if (in_array ( '0' , $this->_tpl_vars['REQUEST']['financesearchfieds'] )): ?> selected <?php endif; ?>>Revenue</option>
        <option value="1" label="EBITDA" <?php if (in_array ( '1' , $this->_tpl_vars['REQUEST']['financesearchfieds'] )): ?> selected <?php endif; ?>>EBITDA</option>
        <!--<option value="2" label="EBDT">EBDT</option>
        <option value="3" label="EBT">EBT</option>-->
        <option value="4" label="PAT" <?php if (in_array ( '4' , $this->_tpl_vars['REQUEST']['financesearchfieds'] )): ?> selected <?php endif; ?>>Net Profit</option>
        
        <option value="5" label="Long term borrowings+Short-term borrowings" <?php if (in_array ( '5' , $this->_tpl_vars['REQUEST']['financesearchfieds'] )): ?> selected <?php endif; ?>>Total Debt</option>
        <option value="6" label="Total shareholders' funds" <?php if (in_array ( '6' , $this->_tpl_vars['REQUEST']['financesearchfieds'] )): ?> selected <?php endif; ?>>Networth</option>
        <option value="7" label="Total Debt+Net worth" <?php if (in_array ( '7' , $this->_tpl_vars['REQUEST']['financesearchfieds'] )): ?> selected <?php endif; ?>>Capital Employed</option>
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
    <?php echo $this->_tpl_vars['finfieldshtml']; ?>

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
    <label for="fand" class="<?php if ($this->_tpl_vars['REQUEST']['Commonandor'] == 'and'): ?> cb-enable selected <?php elseif ($this->_tpl_vars['REQUEST']['Commonandor'] == ""): ?>cb-enable selected  <?php else: ?>cb-disable<?php endif; ?>"><span>AND</span></label>
    <label for="for" class="<?php if ($this->_tpl_vars['REQUEST']['Commonandor'] == 'or'): ?> cb-enable selected <?php else: ?>cb-disable<?php endif; ?>"><span>OR</span></label>
 

</div> 

<input name="refine" type="submit" value="Refine" class="refine"/>  <input name="cancel" type="button" value="Cancel" />
</div>
</li> 
</ul>


</div>

  <div >
<h2><span> [+] </span>GROWTH BASED</h2>

<?php if ($this->_tpl_vars['REQUEST']['YOYCAGR'] != '' || $this->_tpl_vars['growthfieldshtml'] != ''): ?>
<div class="acc_container acc_container_active" > 
<?php else: ?>
<div class="acc_container" > 
<?php endif; ?> 

<ul>

<li>
<div class="growth-yr">

 
   <label for="gacrossall"><input type="radio" name="YOYCAGR" id="gacrossall" value="gacross" <?php if ($this->_tpl_vars['REQUEST']['YOYCAGR'] == 'gacross'): ?> checked <?php endif; ?> /> ALL YEARS</label>
    <label for="ganyof" ><input type="radio" name="YOYCAGR" id="ganyof" value="gAnyOf" <?php if ($this->_tpl_vars['REQUEST']['YOYCAGR'] == 'gAnyOf'): ?> checked <?php endif; ?> /> ANY YEARS</label>
    <label for="YOYCAGR"><input type="radio" name="YOYCAGR" id="YOYCAGR" value="CAGR" <?php if ($this->_tpl_vars['REQUEST']['YOYCAGR'] == 'CAGR'): ?> checked <?php endif; ?>/> CAGR </label>   
   
</div>
 
  
<div class="fields-add">
<select  id="growthsearchfieds" name="growthsearchfieds"  class="multi-select"  multiple="multiple">
        <option value="0"  <?php if (in_array ( '0' , $this->_tpl_vars['REQUEST']['answer']['GrowthSearchFieds'] )): ?> selected <?php endif; ?>>Revenue</option>
        <option value="1" <?php if (in_array ( '1' , $this->_tpl_vars['REQUEST']['answer']['GrowthSearchFieds'] )): ?> selected <?php endif; ?>>EBITDA</option>
        <!--<option value="2">EBDT</option>
        <option value="3">EBT</option>-->
        <option value="4" <?php if (in_array ( '4' , $this->_tpl_vars['REQUEST']['answer']['GrowthSearchFieds'] )): ?> selected <?php endif; ?>>Net Profit</option>
        
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
      <?php echo $this->_tpl_vars['growthfieldshtml']; ?>

  </tbody>
</table>
 
  
 <div class="btn-cnt"> <div class="switch-and-or"> 
   <input type="radio"  name="growthandor" id="gand"  value="and"  checked="checked"/>
  <input type="radio"  name="growthandor" id="gor"   value="or"/>
    <label for="gand" class="<?php if ($this->_tpl_vars['REQUEST']['growthandor'] == 'and'): ?> cb-enable selected <?php elseif ($this->_tpl_vars['REQUEST']['growthandor'] == ""): ?>cb-enable selected  <?php else: ?>cb-disable<?php endif; ?>"><span>AND</span></label>
    <label for="gor" class="<?php if ($this->_tpl_vars['REQUEST']['growthandor'] == 'or'): ?> cb-enable selected <?php else: ?>cb-disable<?php endif; ?>"><span>OR</span></label>
 

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

<?php if ($this->_tpl_vars['chargewhere'] != ''): ?>
<div class="acc_container acc_container_active" > 
<?php else: ?>
<div class="acc_container" > 
<?php endif; ?> 

<ul>

<li>

<table width="100%" border="0" cellspacing="0" cellpadding="0" class="growth-table" id="fintable">
    <tr><td colspan="2">Charge Date</td></tr>   
    <tr> <td><input type="text" name="chargefromdate" id="chargefromdate" value="<?php if ($this->_tpl_vars['chargefromdate']): ?><?php echo $this->_tpl_vars['chargefromdate']; ?>
<?php endif; ?>" style="width:100% !important"></td>  <td><input type="text" name="chargetodate" id="chargetodate"  value="<?php if ($this->_tpl_vars['chargetodate']): ?><?php echo $this->_tpl_vars['chargetodate']; ?>
<?php endif; ?>" style="width:100% !important"></td>  </tr>
<tr><td colspan="2">Charge Amount (in Rs. Cr)</td></tr>  
<tr> <td><input type="text" name="chargefromamount" id="chargefromamount" onkeypress="return isNumber(event)" value="<?php if ($this->_tpl_vars['chargefromamount']): ?><?php echo $this->_tpl_vars['chargefromamount']; ?>
<?php endif; ?>" style="width:100% !important"></td>  <td><input type="text" name="chargetoamount" id="chargetoamount"onkeypress="return isNumber(event)" value="<?php if ($this->_tpl_vars['chargetoamount']): ?><?php echo $this->_tpl_vars['chargetoamount']; ?>
<?php endif; ?>" style="width:100% !important"></td>  </tr>
<tr><td colspan="2">Charge Holder</td></tr>  

<tr> <td Colspan="2" style="position:relative" id="chholderfilter"><input autocomplete="off" type="text" name="chargeholdertest" id="chargeholdertest"  class="chargeholdertest" value="<?php if ($this->_tpl_vars['chargeholdertest']): ?><?php echo $this->_tpl_vars['chargeholdertest']; ?>
<?php endif; ?>" style="width:100% !important"  <?php if ($this->_tpl_vars['chargeholdertest']): ?>readonly<?php endif; ?>> 
           <span id="charge_clearall" title="Clear All" onclick="clear_chholder();" style=" <?php if ($this->_tpl_vars['chargeholdertest'] == ''): ?>display:none;<?php endif; ?>background: #ccc;  position: absolute;  top: 7px;  right: 8px;  padding: 5px;">(X)</span> 
           <div id="testholder" style="  overflow-y: scroll;  max-height: 110px;  background: #fff;display:none; width:225px;">
        
    </div>
       </td>  </tr>
<tr><td colspan="2">Address (city)</td></tr>  
<tr><td Colspan="2"><input type="text" name="chargeaddress" id="chargeaddress"  value="<?php if ($this->_tpl_vars['chargeaddress']): ?><?php echo $this->_tpl_vars['chargeaddress']; ?>
<?php endif; ?>" style="width:100% !important" > <img  id="autosuggest_loading3"  src="images/autosuggest_loading.gif" style="display:none;"></td>  </tr>

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
  
  







</div>

</div>
</div>
 <input type="hidden" name="resetfield" value="" id="resetfield"/>	
   <input type="hidden" name="resetfieldindex" value="" id="resetfieldindex"/>

  