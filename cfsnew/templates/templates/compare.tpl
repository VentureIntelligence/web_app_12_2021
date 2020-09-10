{include file="header.tpl"}
<script type="text/javascript" src="{$SITE_PATH}js/common.js"></script>
<script type="text/javascript" src="{$SITE_PATH}js/validator.js"></script>
<link href="{$SITE_PATH}css/compare.css" rel="stylesheet" type="text/css" media="screen"/>
<div id="rightpanel">
	<div id="content">
	{$BreadCrumb}
	<div class="bgcolor">

<h1><strong>Compare Companies</strong> <span style="float:right;"><a href="home.php">Back To Home</a></span></h1>
<form name="Frm_Compare" id="Frm_Compare" action="comparers.php" method="post" onSubmit="return CFSValidation('Frm_Compare')" enctype="multipart/form-data">
<input type="hidden" name="HmeSearch" id="HmeSearch" value="HmeSearch" />
 <input type="hidden" name="Country" id="Country" value="" />
<div id="content">
	<div class="bgcolor" style="padding:0px;height:160px;">
		<div>
			<div  style="float:left;width:150px;border:#666666 solid 1px;">
				<div class="padd"><b>Select Companies</b></div>
				<div class="padd">
					<select id="answer[CCompanies][]" name="answer[CCompanies][]"  class="" style="width:130px;" forError="State" multiple="multiple">
						   <option value="" >Please Select a Company</option>
						  {html_options options=$companies}
				 	</select>
				</div>
			</div>
			
			<div style="float:left;width:80px;border:#666666 solid 1px;">
				<div class="padd"><b>Year</b></div>
				<div class="padd" style="height:68px;">
					<select id="answer[Year]" name="answer[Year]"  class="" style="" forError="Year">
						  {html_options options=$BYearArry}
				 	</select>
				</div>
			</div>


			<div style="float:left;width:100px;border:#666666 solid 1px;">
				<div class="padd"><b>Action</b></div>
				<div class="padd" style="height:68px;"><input type="image" name="save_business"  src="images/submit.png" style="width:87px; height:25px;"/></div>
			</div>

		</div>
		<div style="clear:both;">&nbsp;</div>
	</div>
</div>
</form>


<div style="clear:both;"></div>
	</div>
</div>
</div>