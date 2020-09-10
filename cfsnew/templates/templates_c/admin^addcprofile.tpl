<?php /* Smarty version 2.5.0, created on 2020-07-30 08:47:07
         compiled from admin/addcprofile.tpl */ ?>
<?php $this->_load_plugins(array(
array('function', 'html_options', 'admin/addcprofile.tpl', 201, false),)); ?><?php $_smarty_tpl_vars = $this->_tpl_vars;
$this->_smarty_include("admin/header.tpl", array());
$this->_tpl_vars = $_smarty_tpl_vars;
unset($_smarty_tpl_vars);
 ?>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
common.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
validator.js"></script>
<script type="text/javascript" src="<?php echo $this->_tpl_vars['ADMIN_JS_PATH']; ?>
jquery.js"></script>
<?php echo '
<script type="text/javascript" language="javascript1.2">
	jQuery.noConflict();
	function suggest(inputString){
	       	if(inputString.length == 0) {
				jQuery(\'#ciner\').fadeOut();
			} else {
			jQuery.get("cinsuggest.php", {queryString: ""+inputString+""}, function(data){
					if(data.length >0) {
						jQuery(\'#ciner\').html(data);
                                                autoPick(inputString);
					}
				});
			}
	}
        
        function autoPick(inputString){
            
            // Year of Incorporation - auto pick 
            var year = inputString.substring(8,12);
                /* var year = inputString.split(/[^\\d]/).filter(function(n){
                if((n>=1800) && (n<=2099) && (n.length == 4)){
                    return n
                }
            })*/
            var IncorpYear = document.getElementById(\'answer[IncorpYear]\');
            IncorpYear.selectedIndex = 0;
            var opts = IncorpYear.options;
            for(var opt, j = 0; opt = opts[j]; j++) {
                if(opt.value == year) {
                    IncorpYear.selectedIndex = j;
                    break;
                }
            }
            //----------------//
            
            
            // Entity Type - auto pick (only for Listing and Unlisting)
            
            var entity_type = inputString.charAt(0);
            var entity_type_val = 0;
            if(entity_type == \'L\' ){
                var entity_type_val = 1;
            }
            if(entity_type == \'U\'){
                var entity_type_val = 2;
            }
            var ListingStatus = document.getElementById(\'answer[ListingStatus]\');
            ListingStatus.selectedIndex = 0;
            if(entity_type_val != 0)
            {
                var opts = ListingStatus.options;
                for(var opt, j = 0; opt = opts[j]; j++) {
                    if(opt.value == entity_type_val) {
                        ListingStatus.selectedIndex = j;
                        break;
                    }
                }
            }
            //----------------//
            
        }
        
</script>
<style type="text/css">
/* CSS Document */
.error{
color:#990000;
font-weight:bold;
}
/* CSS Clearfix */
.clearfix:after {
	content: ".";
	display: block;
	height: 0;
	clear: both;
	visibility: hidden;
}
.clearfix{clear:both;}
.clearfix {display: inline-table;}
/* Hides from IE-mac \\*/
* html .clearfix {height: 1%;}
.clearfix {display: block;}
/* End hide from IE-mac */
ul, ol, dl {
list-style:none outside none;
padding-left:20px;
}

p, pre, ul, ol, dl, dd, blockquote, address, fieldset, .gallery-row, .post-thumb, .post-thumb-single, .entry-meta {
padding-bottom:0px;
}
							/*END OF COMMON CODE*/

.adminbox {
    border: 1px solid #589711;
	background-color:#FFFFFF;
    border-radius: 10px 10px 10px 10px;
	-webkit-border-radius: 10px 10px 10px 10px;
    box-shadow: 2px 2px 2px #B0AEA6;
    padding: 10px;
	
    margin: 20px auto;
    height: auto;
    padding: 20px;
    width: 550px;
}
.adtitle
{
font:bold 24px "Courier New", Courier, monospace;
margin:15px 0;
color:#000;

}
select, input
{
padding:5px;
width:250px;
}
label{
font-family:Arial, Helvetica, sans-serif;
font-size:18px;
float:left;
width:275px;
color:#333333;
text-align:left;
}
input[type=radio]{
width:20px;
}

</style>
'; ?>

</head>
<div class="contentbg">
<div class="breadcrumb">
	<div class="content" style="padding-top:0px;">
	<div class="breadtext">&nbsp;</div>
	</div>
</div>
<form name="Frm_AddCProfile" id="Frm_AddCProfile" action="" method="post" onSubmit="return Validation('Frm_AddCProfile')" enctype="multipart/form-data">
<input type="hidden" name="AddCProfile" id="AddCProfile" value="AddCProfile" />
<div id="slidecontainer">


	<div id="slidecontent">
	
		<div id="slider">
			<ul>				
			<li>
		<div class="adminbox">
		<div><?php echo $this->_tpl_vars['SuccessMsg']; ?>
</div>
		<div class="adtitle" align="center">Add Company Profile</div>
		<div><span class="mandat">*&nbsp;</span>Fields are Mandatory.</div>
		<div align="center">
			<label id="ciner" style="color:#FF0000;margin-left:200px;">&nbsp;</label>
		</div>
<br />
<br />
		
		<div align="center">
			<label id="req_answer[CIN]">CIN:</label>
			<input  type="text" id="answer[CIN]" size="26" name="answer[CIN]"  forError="CIN" onblur="suggest(this.value);"/>
		</div>
<br />
<div align="center">
	<label>Old CIN:</label>
	<input type="text" id="answer[Old_CIN]" name="answer[Old_CIN]" onkeypress="OldCINKeypress(event);" />
</div> 
<br />
                <div align="center">
			<label id="req_answer[FCompanyName]">Company Name (Full Form):<span class="mandat">&nbsp;*</span></label>
			  <input type="text" id="answer[FCompanyName]" size="26" name="answer[FCompanyName]" class="req_value" forError="FCompanyName"/>
		</div>
<br />

		<div align="center">
			<label id="req_answer[SCompanyName]">Company Name (Short Form/Best known Brandname):<span class="mandat">&nbsp;*</span></label>
			<input type="text" id="answer[SCompanyName]" size="26" name="answer[SCompanyName]" class="req_value" forError="SCompanyName"/>		
		</div><br />
<br />
		
		<div align="center">
			<label id="req_answer[FormerlyCalled]">Formerly Called :</label>
			   <input type="text" id="answer[FormerlyCalled]" size="26" name="answer[FormerlyCalled]" class="" forError="FormerlyCalled"/>
		</div>
<br />
<div align="center">
					<label id="req_answer[company_status]">Company Status:<span class="mandat">&nbsp;*</span></label>
					<input  type="text" id="answer[company_status]" size="26" class="req_value" name="answer[company_status]"  forError="company_status" />
				</div>
<br />
                <div align="center">
			<label id="req_answer[GroupCStaus]">Group Status :<span class="mandat">&nbsp;*</span></label>
					<select id="answer[GroupCStaus]" name="answer[GroupCStaus]"  class="req_value" forError="GroupCStaus" onchange="ShowHide(this.value);">
						   <option value="" >Please Select</option>
						   <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['GroupCStaus']), $this) ; ?>

				 	</select>
                </div>
<br />
		<div align="center" id="ParentCopmanyShowHide" style="display:none;">
			<label id="req_answer[ParentCompany]">Parent Company:</label>
					<select id="answer[ParentCompany]" name="answer[ParentCompany]"  forError="ParentCompany">
						   <option value="" >Please Select</option>
							<option value="yahoo"  >Yahoo</option>
							<option value="google" >Google</option>
				 	</select>
			  (If Group Company Please Select Name of the Parent Company)
		</div>
<br />
		
		<div align="center">
			<label id="req_answer[permissions]">Transaction Status :<span class="mandat">&nbsp;*</span></label>
			   <select id="answer[permissions]" name="answer[permissions]" class="req_value" forError="permissions">
				   	<option value="">Please Select a Transaction Status</option>
					<option value="0">PE Backed</option>
					<option value="1">Non-PE Backed</option>
					
			   </select>
		</div>
<br />
<!--
		<div align="center">
			<label id="req_answer[UserStatus]">User Counting Status:<span class="mandat">&nbsp;*</span></label>
			   <select id="answer[UserStatus]" name="answer[UserStatus]" class="req_value" forError="UserStatus">
				   	<option value="">Please Select a UserStatus</option>
					<option value="0">Countable</option>
					<option value="1">Non Countable</option>
			   </select>
		</div>
<br />
-->
		<div align="center">
			<label id="req_answer[Industry]">Industry:<span class="mandat">&nbsp;*</span></label>
					<select id="answer[Industry]" name="answer[Industry]"  class="req_value" forError="Industry"  onchange="loadSector(this.value)">
						   <option value="" >Please Select an Industry</option>
								<?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['industries']), $this) ; ?>

					</select>
		</div>
<br />
		<div align="center">
			<label id="req_answer[Sector]">Sector:<span class="mandat">&nbsp;*</span></label>
				<div id="sectorDropDown">
					<select id="answer[Sector]" name="answer[Sector]"  class="req_value" forError="Sector" onchange="loadNaicsCode(this.value)">
						   <option value="" >Please Select a Sector</option>
						   <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['sectors']), $this) ; ?>

				 	</select>
				</div>
		</div>
<br />
		<div align="center">
			<label id="req_answer[Naics_code]">NAICS Code:<span class="mandat">&nbsp;*</span></label>
			<input type="text" id="answer[Naics_code]" size="26" name="answer[Naics_code]" class="" forError="Naics_code"/>
		</div>
<br/>
		<div align="center">
			<label id="req_answer[tags]">Tags:</label>
			<textarea name="answer[tags]" id="answer[tags]"   forError="tags" ></textarea>
		</div>
<br />
		<div align="center">
			<label id="req_answer[BusinessDesc]">Business Description:</label>
			<textarea name="answer[BusinessDesc]" id="answer[BusinessDesc]"></textarea>
		</div>
<br />
		
	<!--	<div align="center">
			<label id="req_answer[Country]">Country:<span class="mandat">&nbsp;*</span></label>
					<select id="answer[Country]" name="answer[Country]"  class="req_value" forError="Country">
						   <option value="" >Please Select a Country</option>
						   <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['countries']), $this) ; ?>

				 	</select>
		</div>
<br />
 -->
		<div align="center">
			<label id="req_answer[IncorpYear]">Year of Incorporation<span class="mandat">&nbsp;*</span></label>
  				<select name="answer[IncorpYear]"  id="answer[IncorpYear]" style=""  class="req_value" forError="IncorpYear">		
					<?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['BYearArry'],'selected' => $this->_tpl_vars['selectedYear']), $this) ; ?>
	
				</select>
		</div>
<br />
		<div align="center">
			<label id="req_answer[ListingStatus]">Entity Type:<span class="mandat">&nbsp;*</span></label>
			  		<select id="answer[ListingStatus]" name="answer[ListingStatus]"  class="req_value" forError="ListingStatus">
						<option value="" >Please Select</option>
						<option value="1" label="Listed">Listed</option>
				 		<option value="2" label="UnListed">UnListed</option>
					    <option value="3" label="Partnership">Partnership</option>
				 		<option value="4" label="Proprietorship">Proprietorship</option>
					</select>
		</div>
<br />
		
		<div align="center">
			<label id="req_answer[RocCode]">ROC Code:</label>
			<input  type="text" id="answer[RocCode]" size="26" name="answer[RocCode]"  forError="RocCode" />
		</div>
<br />
		<div align="center">
			<label id="req_answer[RegNumber]">Registration Number:</label>
			<input  type="text" id="answer[RegNumber]" size="26" name="answer[RegNumber]"  forError="RegNumber" />
		</div>
<br />
		<div align="center">
			<label id="req_answer[AuthorisedCapital]">Authorised Capital (Rs):</label>
			<input  type="text" id="answer[AuthorisedCapital]" size="26" name="answer[AuthorisedCapital]"  forError="AuthorisedCapital" />
		</div>
<br />
		<div align="center">
			<label id="req_answer[PaidCapital]">Paid Up Capital (Rs):</label>
			<input  type="text" id="answer[PaidCapital]" size="26" name="answer[PaidCapital]"  forError="PaidCapital" />
		</div>
<br />
		<div>Contact Information</div>
		<div align="center">
			<label id="req_answer[AddressHead]">Address (Headquarters) :</label>
			<input  type="text" id="answer[AddressHead]" size="26" name="answer[AddressHead]"  forError="AddressHead" />
		</div>
<br />
		<div align="center">
			<label id="req_answer[AddressLine2]">Address (Line 2) :</label>
			<input  type="text" id="answer[AddressLine2]" size="26" name="answer[AddressLine2]"  forError="AddressLine2" />
		</div>
<br />
		<div align="center">
			<label id="req_answer[AddressCountry]">Country:<span class="mandat">&nbsp;*</span></label>
			<select id="answer[AddressCountry]" name="answer[AddressCountry]"  class="req_value" forError="AddressCountry" onchange="loadState(this.value)">
						   <option value="" >Please Select a Country</option>
						   <?php echo $this->_plugins['function']['html_options'][0](array('options' => $this->_tpl_vars['countries']), $this) ; ?>

		 	</select>
		</div>
<br />
		<div align="center">
			<label id="req_answer[State]">State:<span class="mandat">&nbsp;*</span></label>
			<div id="stateDropDown">
			<select id="answer[State]" name="answer[State]"  class="req_value" forError="State" onchange="loadCity(this.value)">
						   <option value="" >Please Select a State</option>
		 	
			</select>
			</div>
		</div>
<br />
		<div align="center">
			<label id="req_answer[City]">City:<span class="mandat">&nbsp;*</span></label>
					<div id="cityDropDown">
						<select id="answer[City]" name="answer[City]"  class="req_value" forError="City">
							   <option value="" >Please Select a City</option>
						</select>
					</div>	
		</div>
<br />
		<div align="center">
			<label id="req_answer[Pincode]">Pincode:</label>
			<input  type="text" id="answer[Pincode]" size="26" name="answer[Pincode]"  forError="Pincode" />
		</div>
<br />
		<div align="center">
			<label id="req_answer[Phone]">Telephone:</label>
			<input  type="text" id="answer[Phone]" size="26" name="answer[Phone]"  forError="Phone" />
		</div>
<br />
		<div align="center">
			<label id="req_answer[Email]">Email:</label>
			<input  type="text" id="answer[Email]" size="26" name="answer[Email]"  forError="Email" />
		</div>
<br />
		<div align="center">
			<label id="req_answer[Website]">Web Site:</label>
			<input  type="text" id="answer[Website]" size="26" name="answer[Website]"  forError="Website" />
		</div>
<br />
		<div align="center">
			<label id="req_answer[LinkedIn]">LinkedIn URL:</label>
			<input  type="text" id="answer[LinkedIn]" size="26" name="answer[LinkedIn]"  forError="LinkedIn" />
		</div>
<br />
		<div align="center">
			<label id="req_answer[CEO]">Contact Name:</label>
			<input  type="text" id="answer[CEO]" size="26" name="answer[CEO]"  forError="CEO" />
		</div>
<br />

		<div align="center">
			<label id="req_answer[CFO]">Designation:</label>
			<input  type="text" id="answer[CFO]" size="26" name="answer[CFO]"  forError="CFO" />
		</div>
<br />

		<div align="center">
			<label id="req_answer[auditor_name]">Auditor Name:</label>
			<input  type="text" id="answer[auditor_name]" size="26" name="answer[auditor_name]"  forError="auditor_name" />
		</div>
<br />
<!--                
                <div>
			<label>Check if Revenue > 100Cr:</label>
                        <input  style="margin-left:10px;" type="checkbox" id="answer[rgthcr]"  name="answer[rgthcr]"  value="1" forError="rgthcr" />
		</div>
<br />
-->
		

	<div align="center">
		<input type="image" name="save_business"  id="save_business" src="images/submit.png" style="width:87px; height:25px;"/>
	</div><br />
	<h4>Non Active fields</h4><br/>
	<div align="center">
			<label id="req_answer[SubSector]">Sub-Sector:</label>
			 <input type="text" id="answer[SubSector]" size="26" name="answer[SubSector]" class="" forError="SubSector"/>
		</div>
<br />
	<div align="center">
			<label id="req_answer[Brands]">Brands:</label>
			<input  type="text" id="answer[Brands]" size="26" name="answer[Brands]"  forError="Brands" />
		</div>
<br />
<div align="center">
			<label id="req_answer[StockBSE]">Stock Code - BSE:</label>
			<input  type="text" id="answer[StockBSE]" size="26" name="answer[StockBSE]"  forError="StockBSE" />
		</div>
<br />
		<div align="center">
			<label id="req_answer[StockNSE]">Stock Code - NSE :</label>
			<input  type="text" id="answer[StockNSE]" size="26" name="answer[StockNSE]"  forError="StockNSE" />
		</div>
<br />
		<div align="center">
			<label id="req_answer[IPODate]">IPO Date :</label>
			<input  type="text" id="answer[IPODate]" size="26" placeholder="YYYY-MM-DD" name="answer[IPODate]"  forError="IPODate" />
		</div>
<br />
		<div align="center">
			<label id="req_answer[Fax]">Fax:</label>
			<input  type="text" id="answer[Fax]" size="26" name="answer[Fax]"  forError="Fax" />
		</div>
<br />
<div align="center">
			<label id="req_answer[Total_Income_equal_OpIncome]">Total Income equal OpIncome:</label>
				<select id="answer[Total_Income_equal_OpIncome]" name="answer[Total_Income_equal_OpIncome]" forError="Total_Income_equal_OpIncome">
				   <option value="" >Please Select</option>
				   <option value="Yes" label="Yes">Yes</option>
				   <option value="No" label="No">no</option>
				</select>
		</div>
<br />
	</div><br />
	</li>
			</ul>
		</div>
	</div>

</div>
</form>
<?php echo '
<script type="text/javascript">
	function OldCINKeypress(event){
		
		var key = event.charCode;
		console.log(key);
		if((key > 47 && key < 58) || (key > 64 && key < 91) || (key > 96 && key < 123) || key == 44 || key == 8 || key == 9 || key == 0){
			return true;
		} else {
			event.preventDefault();
		}
	}
</script>
'; ?>


</div>