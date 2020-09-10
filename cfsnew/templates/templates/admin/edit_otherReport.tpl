{include file="admin/header.tpl"}
<script type="text/javascript" src="{$SITE_PATH}js/common.js"></script>
<script type="text/javascript" src="{$SITE_PATH}js/validator.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}jquery.js"></script>
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
<form name="Frm_UpdateCProfile" id="Frm_UpdateCProfile" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="UpdateReport" id="UpdateReport" value="UpdateReport" />

<div id="slidecontainer">


	<div id="slidecontent">
	
		<div id="slider">
			<ul>				
			<li>
		<div class="adminbox">
		<div class="adtitle" align="center">Edit Report</div>
                <a href="otherReport.php" style="float: right;margin-top: -34px;">Back to List</a>
		<div align="center">
			<label id="ciner" style="color:#FF0000;margin-left:200px;">&nbsp;</label>
		</div>
<br />
<br />
<div align="center">
			<label id="req_answer[reportTitle]">Title of Report :</label>
                        <input  type="text" id="answer[reportTitle]" size="26" name="answer[reportTitle]"  forError="reportTitle" value="{$reportList.reportTitle}"  required/>
		</div>
<br />
                <div align="center">
			<label id="req_answer[FCompanyName]">Period of Report :</label>
			 <select id="answer[reportPeriod]" name="answer[reportPeriod]"  class="req_value" forError="reportPeriod" >
			<option id="1" value="" >Select Report Period </option>
                        <option value="Annual" {if $reportList.reportPeriod=='Annual'} selected='selected' {/if}>Annual</option>
                        <option value="Half_Yearly" {if $reportList.reportPeriod=='Half_Yearly'} selected='selected' {/if}>Half Yearly</option>
                        <option value="Quarterly" {if $reportList.reportPeriod=='Quarterly'} selected='selected' {/if}>Quarterly</option>
                        <option value="Monthly" {if $reportList.reportPeriod=='Monthly'} selected='selected' {/if}>Monthly</option>
                        <option value="Other" {if $reportList.reportPeriod=='Other'} selected='selected' {/if}>Other</option>
                       </select>
		</div>
<br />

		<div align="center">
			<label id="req_answer[date]">Date :</label>
			<input type="date" id="answer[date]" size="26" name="answer[date]" class="req_value" forError="date" value="{$reportList.date}"  required/>		
		</div><br />
<br />
		
		<div align="center">
			<label id="req_answer[embedCode]">Paste Nanobi Embed code :</label>
                        <textarea id="answer[embedCode]"  name="answer[embedCode]" class="" forError="embedCode"  required/>{$embedCode}</textarea>
		</div>
<br />
                <div align="center">
			<label id="req_answer[definition]">Definition :</label>
                        <textarea id="answer[definition]" name="answer[definition]" class="" forError="definition"/>{$reportList.definition}</textarea>
					
		</div>
<br />
		
<br />

	<div align="center">
		<input type="image" name="save_business"  id="save_business" src="images/submit.png" style="width:87px; height:25px;"/>
	</div><br />

	
	</div><br />
	</li>
			</ul>
		</div>
	</div>

</div>
</form>


</div>