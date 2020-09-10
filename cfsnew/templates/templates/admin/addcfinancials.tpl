{include file="admin/header.tpl"}
<link href="{$ADMIN_CSS_PATH}home.css" rel="stylesheet" type="text/css" media="screen"/>
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}jquery.js"></script>

{literal}
<script type="text/javascript" language="javascript1.2">
jQuery.noConflict();

function suggest(inputString){
		jQuery('#submitbtn').hide();
		jQuery('#viewfinance').hide();
                jQuery('#suggestionsList').show();
                
                 jQuery('#suggestionsList2').hide(); jQuery('#suggestions2').hide();
                 jQuery('#suggestionsList3').hide(); jQuery('#suggestions3').hide();
                 jQuery('#suggestionsList4').hide(); jQuery('#suggestions4').hide();
                 
		if(inputString.length == 0) {
			jQuery('#suggestions').fadeOut();
                        jQuery('#cid').val('');
		} else {
		jQuery('#country').addClass('load');
			jQuery.post("autosuggest.php", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					jQuery('#suggestions').fadeIn();
					jQuery('#suggestionsList').html(data);
					jQuery('#country').removeClass('load');
				}
			});
		}
}
	function fill(thisValue) {
		jQuery('#country').val(thisValue);
		setTimeout("$('#suggestions').fadeOut();", 300);
	}

	function fillHidden(thisid) {
		jQuery('#cid').val(thisid);
		jQuery('#submitbtn').show();
		jQuery('#suggestionsList').hide();
		jQuery('.suggestionsBox').hide();
	    jQuery('#viewfinance').html('<a href="viewannual.php?vcid='+thisid+'" target="_blank"><img src="images/cfs/vfinancial.jpg" style="width:87px; height:25px;" /></a>');
		jQuery('#viewfinance').show();
		setTimeout("$('#suggestions').fadeOut();", 300);
	}
	


//  auto  suggest2
function suggest2(inputString){
		
                 jQuery('#suggestionsList2').show();
                 
                 jQuery('#suggestionsList').hide(); jQuery('#suggestions').hide();
                 jQuery('#suggestionsList3').hide(); jQuery('#suggestions3').hide();
                 jQuery('#suggestionsList4').hide();  jQuery('#suggestions4').hide();
                 
		if(inputString.length == 0) {
			jQuery('#suggestions2').fadeOut();
                        jQuery('#anscompanyid2').val('');
		} else {
		jQuery('#country').addClass('load');
			jQuery.post("autosuggestfinancials.php?suggest=suggest2&", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					jQuery('#suggestions2').fadeIn();
					jQuery('#suggestionsList2').html(data);
					
				}
			});
		}
}
function fill2(thisValue) {
		jQuery('#companyid2').val(thisValue);
		setTimeout("$('#suggestions2').fadeOut();", 300);               
	}

	function fillHidden2(thisid) {
		jQuery('#anscompanyid2').val(thisid);		
		jQuery('#suggestionsList2').hide();
		jQuery('.suggestionsBox').hide();
	      setTimeout("$('#suggestions2').fadeOut();", 300);
	}
        
 
 
//  auto  suggest3
function suggest3(inputString){
		 jQuery('#suggestionsList3').show();
                 
                 jQuery('#suggestionsList').hide(); jQuery('#suggestions').hide();
                 jQuery('#suggestionsList2').hide(); jQuery('#suggestions2').hide();
                 jQuery('#suggestionsList4').hide(); jQuery('#suggestions4').hide();
                 
		if(inputString.length == 0) {
			jQuery('#suggestions3').fadeOut();
                        jQuery('#anscompanyid3').val('');
		} else {
		jQuery('#country').addClass('load');
			jQuery.post("autosuggestfinancials.php?suggest=suggest3&", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					jQuery('#suggestions3').fadeIn();
					jQuery('#suggestionsList3').html(data);
					
				}
			});
		}
}
function fill3(thisValue) {
		jQuery('#companyid3').val(thisValue);
		setTimeout("$('#suggestions3').fadeOut();", 300);
	}

	function fillHidden3(thisid) {
		jQuery('#anscompanyid3').val(thisid);		
		jQuery('#suggestionsList3').hide();
		jQuery('.suggestionsBox').hide();
	      setTimeout("$('#suggestions3').fadeOut();", 300);
	}
        
        
//  auto  suggest4
function suggest4(inputString){
		 jQuery('#suggestionsList4').show();
                 
                 jQuery('#suggestionsList').hide(); jQuery('#suggestions').hide();
                 jQuery('#suggestionsList2').hide(); jQuery('#suggestions2').hide();
                 jQuery('#suggestionsList3').hide(); jQuery('#suggestions3').hide();
                 
		if(inputString.length == 0) {
			jQuery('#suggestions4').fadeOut();
                        jQuery('#anscompanyid4').val('');
		} else {
		jQuery('#country').addClass('load');
			jQuery.post("autosuggestfinancials.php?suggest=suggest4&", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					jQuery('#suggestions4').fadeIn();
					jQuery('#suggestionsList4').html(data);
					
				}
			});
		}
}
function fill4(thisValue) {
		jQuery('#companyid4').val(thisValue);
		setTimeout("$('#suggestions4').fadeOut();", 300);
	}

	function fillHidden4(thisid) {
		jQuery('#anscompanyid4').val(thisid);		
		jQuery('#suggestionsList4').hide();
		jQuery('.suggestionsBox').hide();
	      setTimeout("$('#suggestions4').fadeOut();", 300);
	}  

function suggest5(inputString){
		 jQuery('#suggestionsList5').show();
                 
                 jQuery('#suggestionsList').hide(); jQuery('#suggestions').hide();
                 jQuery('#suggestionsList2').hide(); jQuery('#suggestions2').hide();
                 jQuery('#suggestionsList3').hide(); jQuery('#suggestions3').hide();
                 jQuery('#suggestionsList4').hide(); jQuery('#suggestions4').hide();
                 
		if(inputString.length == 0) {
			jQuery('#suggestions5').fadeOut();
                        jQuery('#anscompanyid5').val('');
		} else {
		jQuery('#country').addClass('load');
			jQuery.post("autosuggestfinancials.php?suggest=suggest5&", {queryString: ""+inputString+""}, function(data){
				if(data.length >0) {
					jQuery('#suggestions5').fadeIn();
					jQuery('#suggestionsList5').html(data);
					
				}
			});
		}
}
function fill5(thisValue) {
		jQuery('#companyid5').val(thisValue);
		setTimeout("$('#suggestions5').fadeOut();", 300);
	}

	function fillHidden5(thisid) {
		jQuery('#anscompanyid5').val(thisid);		
		jQuery('#suggestionsList5').hide();
		jQuery('.suggestionsBox').hide();
	      setTimeout("$('#suggestions5').fadeOut();", 300);
	}        
</script>
<script type="text/javascript" language="javascript1.2">
$j = jQuery.noConflict();
$j(document).ready(function(){
$j(".PLDFlip").click(function(){
    $j(".PLDPanel").slideToggle("slow");
  });
});
$j(document).ready(function(){
$j(".BSFlip").click(function(){
    $j(".BSPanel").slideToggle("slow");
  });
});
$j(document).ready(function(){
$j(".CFFlip").click(function(){
    $j(".CFPanel").slideToggle("slow");
  });
});
$j(document).ready(function(){
$j(".CFFlip1").click(function(){
    $j(".CFPanel1").slideToggle("slow");
  });
});
	label1 = document.getElementById('req_answer[CompanyId]');
	label2 = document.getElementById('req_answer[PLStandard]');
	label1.setAttribute("class","error");
	label2.setAttribute("class","error");

</script>
<style type="text/css">
/* CSS Document */
.PLDPanel{
display:none;
cursor:pointer;
}
.BSPanel{
display:none;
}
.CFPanel{
display:none;
}
.PLDFlip{
cursor:pointer;
}
.BSFlip{
cursor:pointer;
}
.CFFlip{
cursor:pointer;
}
.CFPanel1{
display:none;
}
.CFFlip1{
cursor:pointer;
}
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
/* Hides from IE-mac \*/
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


.suggestionsBox {
margin-left: 280px !important;
margin-right: 14px  !important;
max-height: 500px;
overflow-y: scroll;
z-index: 10;

min-width: 256px;
}
.suggestionList ul
{
    padding: 0 !important; 
    }
.suggestionList ul li{
color: #fff;    
}
</style>

<script>
  jQuery(document).ready(function(){   
          jQuery(".template").click(function() {
              
              jQuery(".balsheetfile").replaceWith(jQuery(".balsheetfile").clone(true));
              
           var selected = jQuery(".template:checked");
            var selectedValue = selected.val();
            
                if(selectedValue==1){
                    jQuery("#chan_template").html('(Old Template)');
                    jQuery("#anscompanyid3").attr('name','answer[BSCompanyId]');
                    jQuery(".balsheetfile").attr('name','answer[BalSheet]'); 
                }
                else if(selectedValue==2){
                     jQuery("#chan_template").html('(New Template)');
                      jQuery("#anscompanyid3").attr('name','answer[New_BSCompanyId]');
                      jQuery(".balsheetfile").attr('name','answer[New_BalSheet]'); 
                }
        
            });
      
      });
</script>

{/literal}
</head>
<div class="contentbg">
<div class="breadcrumb">
	<div class="content" style="padding-top:0px;">
	<div class="breadtext">&nbsp;</div>
	</div>
</div>
		<div class="adminbox">
		<div>{$SuccessMsg}</div>
		<div class="adtitle" align="center">Add Company Financials</div>

  {if $updated} <h3 style="text-align: center;color: red;margin-bottom: 4%;"> {$updated} </h3>{/if}
<form name="Frm_AddCFinancials" id="Frm_AddCFinancials" action="" method="post" onSubmit="return PLStandardValidation('Frm_AddCFinancials')" enctype="multipart/form-data">
<input type="hidden" name="AddCFinancials" id="AddCFinancials" value="AddCFinancials" />
<input type="hidden" name="op" id="op" value="" />
                <div align="center">
			<label id="req_answer[AddFinancials]">Source of Financials:</label>
				<select id="answer[AddFinancials]" name="answer[AddFinancials]">
					<option value="AE">AE</option>
					<option value="BSE">BSE</option>
					<option value="CO WEBSITE">CO WEBSITE</option>
					<option value="MCA">MCA</option>
					<option value="PWS">PWS</option>
					<option value="RATING - CARE">RATING - CARE</option>
					<option value="RATING - CRISIL">RATING - CRISIL</option>
					<option value="RATING - ICRA">RATING - ICRA</option>
				</select>
		</div><br/>
		<div align="center">
			<label id="answer[CompanyId]">Company:</label>
			<div id="suggest">
				<input type="hidden" name="answer[CompanyId]" id="cid" value="" />
				<input type="text" size="25" value="" name="country" id="country" onkeyup="suggest(this.value);" onblur="fill();" class=""  autocomplete=off  style="height:24px;"/>&nbsp;&nbsp;
				<div class="suggestionsBox" id="suggestions" style="display: none;">
				  <div class="suggestionList" id="suggestionsList"> &nbsp; </div>
				</div>
			</div>
		</div>
		<br />
		<!--<div align="center">
			<label id="req_answer[CompanyId]">Company:</label>
					<input type="text" id="answer[CompanyId]" size="26" name="answer[CompanyId]"  class="req_value" forError="CompanyId"/>
		</div>
		<br/>-->
		<div align="center">
	    <label id="req_answer[PLStandardFormat]" style="width: 248px;"> Upload P&L format</label>
	     <input type="radio" id="pl_newtemplate"  name="PLStandardFormat" value="2" class="template" checked/> <label for="pl_newtemplate" style="font-size:14px; width: auto;  float: none;">New Template </label> 
	     <input type="radio" id="pl_oldtemplate"  name="PLStandardFormat" value="1" class="template" disabled/> <label for="pl_oldtemplate" style="font-size:14px; width: auto;  float: none;cursor: not-allowed;" > Old Template</label> 
	    </div> 
		<br /> 
		<div align="center">
			<label id="req_answer[PLStandard]">Upload P & L Standard:</label>
			<input type="file" id="answer[PLStandard]" size="26" name="answer[PLStandard]" class="req_value" forError="PLStandard"/>		
		</div><br />
		
		<div align="center">
			<label id="req_answer[ResultType]">By Result Type:</label>
			<input id="Private" type="radio" checked="checked" value="0" name="ResultType">&nbsp;Standalone
			<input id="Public" type="radio" value="1" name="ResultType">&nbsp;Consolidated	
		</div><br />
		<div >
			<label id="req_answer[Restate]">Re-State:</label>
			<input id="restatecheck" type="checkbox"  value="1" name="Restate" style="margin-left: 10px;">
			
		</div><br />
		<div align="center">
			<input type="image" name="save_business"  src="images/submit.png" style="width:87px; height:25px;"/>
		</div><br />
{if $AskConfirm}
<script type="text/javascript" language="javascript1.2">
	//upDateFinancial('YesConfirm');
</script>
{/if}	
</form>
{if $Usr_Type neq 2}<div class="PLDFlip">Click to Upload P&L Detail:</div>{/if}
<div class="PLDPanel">
<form name="Frm_AddPLDetail" id="Frm_AddPLDetail" action="" method="post" onSubmit="return PLDetailedValidation('Frm_AddPLDetail')" enctype="multipart/form-data">
<input type="hidden" name="AddPLDetail" id="AddPLDetail" value="AddPLDetail" />
		<div align="center">
			<label id="req_answer[AddPLDetailCompanyId]">Company:</label>
					<!-- <select id="answer[AddPLDetailCompanyId]" name="answer[AddPLDetailCompanyId]"  class="req_value" forError="AddPLDetailCompanyId">
						   <option value="" >Please Select a Company</option>
								
				 	</select> -->
                                        
                                        <div id="suggest">
				<input type="hidden" name="answer[AddPLDetailCompanyId]" id="anscompanyid2" value="" />
				<input type="text" size="25" value="" name="companyid2" id="companyid2" onkeyup="suggest2(this.value);" onblur="fill2();" class=""  autocomplete=off  style="height:24px;"/>&nbsp;&nbsp;
				<div class="suggestionsBox" id="suggestions2" style="display: none;"> 
				  <div class="suggestionList" id="suggestionsList2"> &nbsp; </div>
				</div>
			</div>
                                        
                                       
		</div>
		<br />

		<div align="center">
			<label id="req_answer[PLDetailed]">Upload P&L Detailed:</label>
			<input type="file" id="answer[PLDetailed]" size="26" name="answer[PLDetailed]" class="req_value" forError="PLDetailed"/>		
		</div><br />

		<div align="center">
			<input type="image" name="save_business"  src="images/submit.png" style="width:87px; height:25px;"/>
		</div><br />
</form>
</div>

<div class="BSFlip">Click to Upload Balance Sheet:</div>
<div class="BSPanel">
<form name="Frm_AddBS" id="Frm_AddBS" action="" method="post" onSubmit="return BSValidation('Frm_AddBS')" enctype="multipart/form-data">
    
    
    
<input type="hidden" name="AddBS" id="AddBS" value="AddBS" />


<br /><br />
		<div align="center">
			<label id="req_answer[BSCompanyId]">Company:</label>
					<!-- <select id="answer[BSCompanyId]" name="answer[BSCompanyId]"  class="req_value" forError="BSCompanyId">
						   <option value="" >Please Select a Company</option>
								
				 	</select>-->
                                <div id="suggest">
				<input type="hidden" name="answer[New_BSCompanyId]" id="anscompanyid3" value="" />
				<input type="text" size="25" value="" name="companyid3" id="companyid3" onkeyup="suggest3(this.value);" onblur="fill3();" class=""  autocomplete=off  style="height:24px;"/>&nbsp;&nbsp;
				<div class="suggestionsBox" id="suggestions3" style="display: none;"> 
				  <div class="suggestionList" id="suggestionsList3"> &nbsp; </div>
				</div>
			</div>
		</div>

<br /><br />


		

		<div align="center">
    <label style="width: 248px;"> Upload Balance Sheet</label>
     <input type="radio" id="newtemplate2"  name="BalSheet_template" value="2" class="template" checked/> <label for="newtemplate2" style="font-size:14px; width: auto;  float: none;">New Template </label> 
     <input type="radio" id="oldtemplate"  name="BalSheet_template" value="1" class="template" /> <label for="oldtemplate" style="font-size:14px; width: auto;  float: none;"> Old Template</label> 
    </div> 
<br />

<div align="center">
			<label style="width: 222px;">By Result Type:</label>
                        <input id="balanceResultType1" type="radio" checked="checked" value="0" name="balanceResultType" class="template"><label for="newtemplate2" style="font-size:14px; width: auto;  float: none;">Standalone</label>
                        <input id="balanceResultType2" type="radio" value="1" name="balanceResultType" class="template"><label for="newtemplate2" style="font-size:14px; width: auto;  float: none;">Consolidated</label>	
		</div><br />
<br />

<div align="center">
                    <label id="req_answer[BalSheet]"><!-- Upload Balance Sheet <small id="chan_template" style="font-size: 11px;">(Old Template)</small> : --></label>
                    <input type="file" id="answer[BalSheet]" size="26" name="answer[New_BalSheet]" class="req_value balsheetfile" forError="BalSheet" required=""/>		
		</div>
<br /><br />


		<div align="center">
			<input type="image" name="save_business"  src="images/submit.png" style="width:87px; height:25px;"/>
		</div><br />
</form>
</div>

{if $Usr_Type neq 2}<div class="CFFlip">Click to Upload Cashflow - Old :</div>{/if}
<div class="CFPanel">
<form name="Frm_AddCF" id="Frm_AddCF" action="" method="post" onSubmit="return CFValidation('Frm_AddCF')" enctype="multipart/form-data">
<input type="hidden" name="AddCF" id="AddCF" value="AddCF" />
		<div align="center">
			<label id="req_answer[CFCompanyId]">Company:</label>
					<!-- <select id="answer[CFCompanyId]" name="answer[CFCompanyId]"  class="req_value" forError="CFCompanyId">
						   <option value="" >Please Select a Company</option>
								
				 	</select> --> 
                                           <div id="suggest">
				<input type="hidden" name="answer[CFCompanyId]" id="anscompanyid4" value="" />
				<input type="text" size="25" value="" name="companyid4" id="companyid4" onkeyup="suggest4(this.value);" onblur="fill4();" class=""  autocomplete=off  style="height:24px;"/>&nbsp;&nbsp;
				<div class="suggestionsBox" id="suggestions4" style="display: none;"> 
				  <div class="suggestionList" id="suggestionsList4"> &nbsp; </div>
				</div>
			</div>
                                        
                                        
		</div>
		<br />

		<div align="center">
			<label id="req_answer[Cashflow]">Upload Cashflow:</label>
			<input type="file" id="answer[Cashflow]" size="26" name="answer[Cashflow]" class="" forError="Cashflow"/>		
		</div><br />

		<div align="center">
			<input type="image" name="save_business"  src="images/submit.png" style="width:87px; height:25px;"/>
		</div><br />
</form>
</div>
{if $Usr_Type neq 2}<div class="CFFlip1">Click to Upload Cashflow:</div>{/if}
<div class="CFPanel1">
<form name="Frm_AddCFnew" id="Frm_AddCFnew" action="" method="post" onSubmit="return CFValidationnew('Frm_AddCFnew')" enctype="multipart/form-data">
<input type="hidden" name="AddCFnew" id="AddCFnew" value="AddCFnew" />
		<div align="center">
			<label id="req_answer[CFCompanyIdnew]">Company:</label>
					<!-- <select id="answer[CFCompanyId]" name="answer[CFCompanyId]"  class="req_value" forError="CFCompanyId">
						   <option value="" >Please Select a Company</option>
								
				 	</select> --> 
            <div id="suggest">
				<input type="hidden" name="answer[CFCompanyIdnew]" id="anscompanyid5" value="" />
				<input type="text" size="25" value="" name="companyid5" id="companyid5" onkeyup="suggest5(this.value);" onblur="fill5();" class=""  autocomplete=off  style="height:24px;"/>&nbsp;&nbsp;
				<div class="suggestionsBox" id="suggestions5" style="display: none;"> 
				  <div class="suggestionList" id="suggestionsList5"> &nbsp; </div>
				</div>
			</div>
                                        
                                        
		</div>
		<br />

		<div align="center">
			<label id="req_answer[Cashflownew]">Upload Cashflow:</label>
			<input type="file" id="answer[Cashflownew]" size="26" name="answer[Cashflownew]" class="" forError="Cashflownew"/>		
		</div><br />

		<div align="center">
			<label id="req_answer[ResultType]">By Result Type:</label>
			<input id="Private" type="radio" checked="checked" value="0" name="ResultType">&nbsp;Standalone
			<input id="Public" type="radio" value="1" name="ResultType">&nbsp;Consolidated	
		</div><br />

		<div align="center">
			<input type="image" name="save_business"  src="images/submit.png" style="width:87px; height:25px;"/>
		</div><br />
</form>
</div>

	</div>
</div>