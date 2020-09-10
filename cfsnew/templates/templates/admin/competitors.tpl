{include file="admin/header.tpl"}
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}jquery.js"></script>
{literal}
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
		<div class="adtitle" align="center">Add Competitors</div>


<form name="Frm_AddCompetitors" id="Frm_AddCompetitors" action="" method="post" onSubmit="return CompetitorsValidation('Frm_AddCompetitors')" enctype="multipart/form-data">
<input type="hidden" name="AddCompetitors" id="AddCompetitors" value="AddCompetitors" />
<input type="hidden" name="op" id="op" value="" />

		<div align="center">
			<label id="req_answer[CompanyId]">Source Company:</label>
				<select id="answer[CompanyId]" name="answer[CompanyId]"  class="req_value" forError="CompanyId">
					   <option value="" >Please Select a Company</option>
							{html_options options=$companies}
				</select>
		</div>
		<br />
		<div align="center">
			<label id="req_answer[LCompanyId]">List Competitor Company:</label>
				<select id="LCompanyId[]" name="LCompanyId[]"  class="req_value" forError="LCompanyId" multiple="multiple">
							{html_options options=$companies}
				</select>
		</div>														
		<br />
		
		<div align="center">
			<label id="req_answer[UCompanyId]">Unlist Competitor Company:</label>
				<select id="UCompanyId[]" name="UCompanyId[]"  class="req_value" forError="UCompanyId" multiple="multiple">
							{html_options options=$companies}
				</select>
		</div>														
		<br />
		
		<div align="center">
			<input type="image" name="save_business"  src="images/submit.png" style="width:87px; height:25px;"/>
		</div><br />
{if $AskConfirm}
<script type="text/javascript" language="javascript1.2">
	//upDateFinancial('YesConfirm');
</script>
{/if}	
</form>

	</div>
</div>