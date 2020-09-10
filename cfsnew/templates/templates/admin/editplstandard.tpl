{include file="admin/header.tpl"}
<script type="text/javascript" src="{$ADMIN_JS_PATH}common.js"></script>
<script type="text/javascript" src="{$ADMIN_JS_PATH}validator.js"></script>
{literal}
<style type="text/css">
/* CSS Document */
.error{
color:#990000;
font-weight:bold;
}
/*.slider-bg {
	height:472px;
	position:absolute;
	width:980px;
	left: 155px;
	top: -39px;
	z-index:1000;
}*/
ul#primary-nav {
	float:left;
	height:75px;
	left:225px;
	position:absolute;
	top:57px;
	width: 746px;
}

ul#primary-nav {
margin:0; padding:0;
}

ul#primary-nav li {display:block; float:left; margin-right:22px;} 

ul#primary-nav li.home:hover{background: url(images/homehover.png) left top; width:77px; height:50px;}
ul#primary-nav li.aboutus:hover{background: url(images/abouthover.png) left top; width:114px; height:50px;}
ul#primary-nav li.services:hover{background: url(images/serviceshover.png) left top; width:114px; height:50px;}
ul#primary-nav li.contactus:hover{background: url(images/contactushover.png) left top; width:134px; height:50px;}

ul#primary-nav li.home a
{
background:url(images/home.png) no-repeat;
line-height:64px;
padding:19px 38px;
}

ul#primary-nav li.aboutus a
{
background:url(images/aboutus.png) no-repeat;
line-height:64px;
padding:19px 57px;
}

ul#primary-nav li.services a
{
background:url(images/services.png) no-repeat;
line-height:64px;
padding:19px 57px;
}

ul#primary-nav li.contactus a
{
background:url(images/contactus.png) no-repeat;
line-height:64px;
padding:19px 67px;
}

ul#primary-nav li a{
height:19px;
width:auto;
}
.contentbg
{
height:auto;
position:relative;
}
.content
{
width:930px;
height:auto;
margin:0 auto;
padding-top:42px;

}
.wrapper {
padding:0px 0px 20px;
width:300px;
float:left;
}
.breadtext
{
font:13px Verdana, Arial, Helvetica, sans-serif;
color:#FFFFFF;
text-align:left;
text-indent:15px;
}
.breadcrumb
{
width:100%;
/*background-color:#000000;*/
/*padding:15px 0;*/
}
.title {
color:#FFFFFF;
font:lighter 25px impact;
text-transform:uppercase;
text-align:left;
}
.imagebg
{
background-color:#FFFFFF;
width:278px;
height:auto;
margin:25px auto;
border:1px solid #cecece;
padding:6px;
}
.conttext
{
font:12px/1.8 Arial, Helvetica, sans-serif;
color:#FFFFFF;
text-align:left;
width:290px;

}
h1{
display:inline;
}
.ListText{
	font:18px Arial, Helvetica, sans-serif;
	bor

}
#slidecontent {

    position: relative;
}
ol#controls {
    height: 28px;
    left: 360px;
    margin: 1em 0;
    padding: 0;
    position: absolute;
    top: 121px;
    z-index: 1000;
}
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
    width: 500px;
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
width:150px;
color:#333333;
text-align:left;
}
input[type=radio]{
width:20px;
}
.dob{
	width:60px;
	padding:0px;
}

.padd{
	padding:5px;
	border-bottom:1px solid #000000;
	border-right:1px solid #000000;
}
.paddnew{
	padding:5px;
	border-bottom:1px solid #000000;
	border-right:1px solid #000000;
	text-align:right;
}
.paddRupee{
	padding:5px;
	border-bottom:1px solid #000000;
	border-right:1px solid #000000;
	border-right:none;
	border-top:none;
}
.paddTitle{
	padding:5px;
	border-bottom:1px solid #000000;
	border-left:1px solid #000000;
	border-right:1px solid #000000;
}

</style>

	<script type="text/javascript" language="javascript1.3">
		var $j = jQuery.noConflict();
		$j(document).ready(function(){	
			$j("#slider").easySlider({
				//auto: false, 
				//continuous: true,
				numeric: true
			});
		});	



/*function Validation(id){
  var flag		=		0;
  if(id == 1 && id != undefined){
	var email = document.getElementById('emailaddress').value;
	var City = document.getElementById('City').value;
	 if(email==""){
		$('CatErrorMsg').innerHTML = "Please Enter Email";
		$('emailaddress').focus();
		flag=1;
	 }else if (!isValidEmail(email)){
		$('CatErrorMsg').innerHTML = "Please Enter Valid Email Address";
		$('emailaddress').focus();
		flag=1;
	}
  }	
	if(flag == 0 && email != "" && email != undefined){
		document.authcheck.submit();
	}
}
*/
function IndexKeyPress(id,e){
		// look for window.event in case event isn't passed in
		if (window.event) { e = window.event; }
		if (e.keyCode == 13){
		return true;
			//	validation(id);
		}
}

	</script>

	{/literal}
</head>
<div class="contentbg">
<div class="breadcrumb">
	<div class="content" style="padding-top:0px;">
	<div class="breadtext">&nbsp;</div>
	</div>
</div>
{if $FinanceAnnual}
	<h1 style="margin-left:320px;">{$SCompanyName}</h1><br/><br/>
	<div style="margin-left:320px;">
		<form name="Frm_AddPLstandard" id="Frm_AddPLstandard" action="" method="post" onSubmit="return PLStandardValidation('Frm_AddPLstandard')" enctype="multipart/form-data">
		    <input type="hidden" name="AddPLstandard" id="AddPLstandard" value="AddPLstandard" />
		    {section name=List loop=$FinanceAnnual}
					<input type="hidden" name="test[]" id="test[]" value="{if $FinanceAnnual[List].CId_FK eq 0}-{else}{$FinanceAnnual[List].CId_FK|number_format:0:".":","}{/if}"/>
					<br/><br/>
					<p>
						<label>FY</label>
						<input type="text" name="test[]" id="test[]" value="{if $FinanceAnnual[List].FY eq 0}-{else}{$FinanceAnnual[List].FY|number_format:0:".":","}{/if}"/>
					</p>
					<p>
						<label>Total Income</label>		
						<input type="text" name="test[]" id="test[]" value="{if $FinanceAnnual[List].TotalIncome eq 0}-{else}{$FinanceAnnual[List].TotalIncome|number_format:0:".":","}{/if}"/>         </p>
					<p>
						<label>EBITDA</label>
						<input type="text" name="test[]" id="test[]" value="{if $FinanceAnnual[List].EBITDA eq 0}-{else}{$FinanceAnnual[List].EBITDA|number_format:0:".":","}{/if}"/>			         </p>
					 <p>   
						<label>EBDT</label>
						<input type="text" name="test[]" id="test[]" value="{if $FinanceAnnual[List].EBDT eq 0}-{else}{$FinanceAnnual[List].EBDT|number_format:0:".":","}{/if}"/>
					  </p>
					  <p>
					    <label>EBT</label>
						<input type="text" name="test[]" id="test[]" value="{if $FinanceAnnual[List].EBT eq 0}-{else}{$FinanceAnnual[List].EBT|number_format:0:".":","}{/if}"/>
 					  </p>
					  <p> 					
					    <label>PAT</label>
						<input type="text" name="test[]" id="test[]" value="{if $FinanceAnnual[List].PAT eq 0}-{else}{$FinanceAnnual[List].PAT|number_format:0:".":","}{/if}"/>
					  </p>
		   {/section}	
		   <input type="image" name="save_business"  src="images/submit.png" style="width:87px; height:25px;"/>
		</form>
	</div>
{else}
<form name="Frm_EditPLStandard" id="Frm_EditPLStandard" action="" method="post" onSubmit="return EditPLStandardValidation('Frm_EditPLStandard')" enctype="multipart/form-data">
<input type="hidden" name="EditPLStandard" id="EditPLStandard" value="EditPLStandard" />
<div id="slidecontainer">


	<div id="slidecontent">
	
		<div id="slider">
			<ul style="list-style-type:none;">				
				<li><div class="adminbox">
		<div class="adtitle" align="center">Edit PL Standard</div>
		<div align="center">
			<label id="req_answer[CompanyId]">Company:</label>
					<select id="answer[CompanyId]" name="answer[CompanyId]"  class="req_value" forError="CompanyId">
						   <option value="" >Please Select a Company</option>
								{html_options options=$companies}
				 	</select>
		</div>
		<br />
	
		<div align="center">
			<label id="req_answer[TypeId]">Type:</label>
					<select id="answer[TypeId]" name="answer[TypeId]"  class="req_value" forError="TypeId">
						   <option value="">Please Select a Company</option>
						   <option value="plstandard">PL Standard</option>
						   <option value="growthpercentage">Growth Percentage</option>
						   <option value="cagr">CAGR</option>
				 	</select>
		</div>
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
{/if}

</div>
{*include file ="groupon/footer.tpl"*}