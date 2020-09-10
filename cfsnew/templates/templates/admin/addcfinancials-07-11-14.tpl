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
		if(inputString.length == 0) {
			jQuery('#suggestions').fadeOut();
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

</style>
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
                                    <!-- <img src="images/arrow.png" style="position: relative; top: -12px; left: 30px;" alt="upArrow" /> -->
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
			<label id="req_answer[PLStandard]">Upload P & L Standard:</label>
			<input type="file" id="answer[PLStandard]" size="26" name="answer[PLStandard]" class="req_value" forError="PLStandard"/>		
		</div><br />
		
		<div align="center">
			<label id="req_answer[ResultType]">By Result Type:</label>
			<input id="Private" type="radio" checked="checked" value="0" name="ResultType">&nbsp;Standalone
			<input id="Public" type="radio" value="1" name="ResultType">&nbsp;Consolidated	
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
<div class="PLDFlip">Click to Upload P&L Detail:</div>
<div class="PLDPanel">
<form name="Frm_AddPLDetail" id="Frm_AddPLDetail" action="" method="post" onSubmit="return PLDetailedValidation('Frm_AddPLDetail')" enctype="multipart/form-data">
<input type="hidden" name="AddPLDetail" id="AddPLDetail" value="AddPLDetail" />
		<div align="center">
			<label id="req_answer[AddPLDetailCompanyId]">Company:</label>
					<select id="answer[AddPLDetailCompanyId]" name="answer[AddPLDetailCompanyId]"  class="req_value" forError="AddPLDetailCompanyId">
						   <option value="" >Please Select a Company</option>
								{html_options options=$companies}
				 	</select>
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
		<div align="center">
			<label id="req_answer[BSCompanyId]">Company:</label>
					<select id="answer[BSCompanyId]" name="answer[BSCompanyId]"  class="req_value" forError="BSCompanyId">
						   <option value="" >Please Select a Company</option>
								{html_options options=$companies}
				 	</select>
		</div>
		<br />

		<div align="center">
			<label id="req_answer[BalSheet]">Upload Balance Sheet:</label>
			<input type="file" id="answer[BalSheet]" size="26" name="answer[BalSheet]" class="req_value" forError="BalSheet"/>		
		</div><br />


		<div align="center">
			<input type="image" name="save_business"  src="images/submit.png" style="width:87px; height:25px;"/>
		</div><br />
</form>
</div>

<div class="CFFlip">Click to Upload Cashflow:</div>
<div class="CFPanel">
<form name="Frm_AddCF" id="Frm_AddCF" action="" method="post" onSubmit="return CFValidation('Frm_AddCF')" enctype="multipart/form-data">
<input type="hidden" name="AddCF" id="AddCF" value="AddCF" />
		<div align="center">
			<label id="req_answer[CFCompanyId]">Company:</label>
					<select id="answer[CFCompanyId]" name="answer[CFCompanyId]"  class="req_value" forError="CFCompanyId">
						   <option value="" >Please Select a Company</option>
								{html_options options=$companies}
				 	</select>
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

	</div>
</div>