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
<form name="Frm_AddCity" id="Frm_AddCity" action="" method="post" onSubmit="return Validation('Frm_AddCity')" enctype="multipart/form-data">
<input type="hidden" name="AddCity" id="AddCity" value="AddCity" />
<div id="slidecontainer">


	<div id="slidecontent">
	
		<div id="slider">
			<ul>				
			<li>
		<div class="adminbox">
		<div>{$SuccessMsg}</div>
		<div class="adtitle" align="center">Add City</div>
		<div align="center">
			<label id="req_answer[AddressCountry]">Select an Country:<span class="mandat">&nbsp;*</span></label>
			<select id="answer[AddressCountry]" name="answer[AddressCountry]"  class="req_value" forError="AddressCountry" onchange="loadState(this.value)">
						   <option value="" >Please Select a Country</option>
						   {html_options options=$countries}
		 	</select>
		</div>
<br />
		<div align="center">
			<label id="req_answer[State]">State:<span class="mandat">&nbsp;*</span></label>
			<div id="stateDropDown">
				<select id="answer[State]" name="answer[State]"  class="req_value" forError="AddressState">
							   <option value="" >Please Select a State</option>
							   {html_options options=$State}
				</select>
			</div>	
		</div><br />
<br />
		<div align="center">
			<label id="req_answer[City]">City:</label>
			<input type="text" id="answer[City]" size="26" name="answer[City]" class="" forError="City"/>	
		</div><br />
<br />
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