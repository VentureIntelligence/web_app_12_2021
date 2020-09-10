{include file="admin/header.tpl"}
<script type="text/javascript" src="{$SITE_PATH}js/common.js"></script>
<script type="text/javascript" src="{$SITE_PATH}js/validator.js"></script>
{literal}
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
/* Hides from IE-mac \*/
* html .clearfix {height: 1%;}
.clearfix {display: block;}
/* End hide from IE-mac */
ul, ol, dl {
list-style:none outside none;

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
<form name="Frm_AddSector" id="Frm_AddSector" action="" method="post" onSubmit="return Validation('Frm_AddSector')" enctype="multipart/form-data">
<input type="hidden" name="AddSector" id="AddSector" value="AddSector" />
<div id="slidecontainer">


	<div id="slidecontent">
	
		<div id="slider">
			<ul>				
			<li>
		<div class="adminbox">
		<div>{$SuccessMsg}</div>
		<div class="adtitle" align="center">Add Sector</div>
		<div align="center">
			<label id="req_answer[Industry]">Select an Industry:<span class="mandat">&nbsp;*</span></label>
			<select id="answer[Industry]" name="answer[Industry]"  class="req_value" forError="Industry" onchange="loadState(this.value)">
						   <option value="" >Please Select an Industry</option>
						   {html_options options=$industries}
		 	</select>
		</div>
<br />
		<div align="center">
			<label id="req_answer[SectorName]">Sector Name:<span class="mandat">&nbsp;*</span></label>
			<input type="text" id="answer[SectorName]" size="26" name="answer[SectorName]" class="req_value" forError="SectorName"/>		
		</div><br />
<br />
	<div align="center">
			<label id="req_answer[naics_code]">NAICS Code:<span class="mandat">&nbsp;*</span></label>
			<input type="text" id="answer[naics_code]" size="26" name="answer[naics_code]" class="req_value" forError="naics_code"/>		
		</div><br />
<br/>
	<div align="center">
		<input type="image" name="save_business"  src="images/submit.png" style="width:87px; height:25px;"/>
	</div><br />

	
	</div><br />
	</li>
			</ul>
		</div>
	</div>

</div>
</form>


</div>