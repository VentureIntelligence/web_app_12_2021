{include file="admin/header.tpl"}
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
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
<form name="Frm_AddCProfile" id="Frm_AddCProfile" action="" method="post" enctype="multipart/form-data">
<input type="hidden" name="AddReport" id="AddReport" value="AddReport" />
<div id="slidecontainer">


	<div id="slidecontent">
	
		<div id="slider">
			<ul>				
			<li>
		<div class="adminbox">
		<div>{$SuccessMsg}</div>
		<div class="adtitle" align="center">Add Report</div>
                <a href="otherReport.php" style="float: right;margin-top: -34px;">Back to List</a>
                
		<div align="center">
			<label id="ciner" style="color:#FF0000;margin-left:200px;">&nbsp;</label>
		</div>
<br />
<br />
		
		<div align="center">
			<label id="req_answer[reportTitle]">Title of Report :</label>
                        <input  type="text" id="answer[reportTitle]" size="26" name="answer[reportTitle]"  forError="reportTitle" required />
		</div>
<br />
                <div align="center">
			<label id="req_answer[reportPeriod]">Period of Report :</label>
			 <select id="answer[reportPeriod]" name="answer[reportPeriod]"  class="req_value" forError="reportPeriod" >
			<option id="1" value="" selected="">Select Report Period </option>
                        <option value="Annual">Annual</option>
                        <option value="Half_Yearly">Half Yearly</option>
                        <option value="Quarterly">Quarterly</option>
                        <option value="Monthly">Monthly</option>
                        <option value="Other">Other</option>
                       </select>
		</div>
<br />

		<div align="center">
			<label id="req_answer[date]">Date :</label>
			<input type="date" id="answer[date]" size="26" name="answer[date]" class="req_value" forError="date" required/>		
		</div><br />
<br />
		
		<div align="center">
			<label id="req_answer[FormerlyCalled]">Paste Nanobi Embed code :</label>
                        <textarea id="answer[embedCode]"  name="answer[embedCode]" class="" forError="embedCode"  required/> </textarea>
		</div>
<br />
                <div align="center">
			<label id="req_answer[GroupCStaus]">Definition :</label>
                        <textarea id="answer[definition]" name="answer[definition]" class="" forError="definition"/> </textarea>
					
		</div>
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