<!-- 
	Copyright @ 2020 VentureIntelligence
    Version - 1.0.0 ; Date - 2102 Apr 2020
	Changes : Consume API
	Manager : Vijayakumar
	Developer : Kalaiselvan
    File name = peapi.php
-->
<?php
	require_once '../dbconnectvi.php';
	$DB = new dbInvestments();
	if( !$_SESSION[ 'api_user_id' ] || !$_SESSION[ 'api_username' ] ) {
		header( 'Location: index.php' );
	}
	if( !$_SESSION[ 'is_admin' ] && $_SESSION[ 'logged_db' ] != 'PE' ) {
		if( $_SESSION[ 'logged_db' ] == 'MA' ) {
			$redirectPage = 'maapi.php';
		} else if( $_SESSION[ 'logged_db' ] == 'CFS' ) {
			$redirectPage = 'home.php';
		} else {
			$redirectPage = 'index.php';
		}
		header( 'Location:'.$redirectPage );
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"> 
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">	
	<title>PE | JSON Generate</title>
	<link rel="icon" href="images/company.png" sizes="16x16" type="image/png">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<style>
.result-tbl-wpr.pecompanylist table tbody tr td {
    padding: 10px 10px;
}
.pecompanydetails .tbl-cnt .tab-pane {
    width: 100%;
    height: 350px;
    overflow: auto;
}
.pecompanydetails .tab-cont-sec ul li.moreinfodetails{
	    width: 600px;
}
.tbl-cnt ul li {
    list-style: none;
    width: auto;
	min-width: 150px;
    text-align: center;
    border-right: 1px solid #e3e3e3;
}
.tab-scroll ul li span, .tbl-cnt ul li span{min-height:35px;}
</style>
<body>
	<div class="body-overlay">
		<div class="loader-text"></div>
	</div>
<div class="container-fluid no-pd">
	<div class="header">
		<div class="logo-sec">
			<a href="#">
				<img src="images/company.png" alt="company-logo">
			</a>
			<span class="ttl1">API Gateway</span>
		</div>
		<div class="logout-btn pull-right"><a href="logout.php">Logout</a></div>
	</div>
	<div class="col-xs-12 cnt-sec">
		<div class="col-lg-3 col-md-3 col-sm-4 col-xs-12 left-sec">
			<form action="home.php" method="post" id="from_fetch" enctype="multipart/form-data">
				<div class="fetch-cmp-dt">
					<!-- <div class="frm-fld center-text">
						<input class="effect-9" disabled type="text" value="https://api.vionweb.com/">				
					</div> -->
					<?php 
					if( $_SESSION[ 'is_admin' ] ) {
					?>
					<!-- <div class="frm-fld login-as-admin">
						<p><input class="effect-2" name="user_check" id="user_check" type="checkbox" value="1"><label class="admin_acc">User level check</label></p>
					</div>
					<label class="fetch-label">Username:</label>
					<div class="frm-fld">
						<input class="effect-9" name="api_userName" disabled="" id="api_userName" type="text" value="" />
					    <span class="focus-border"><i></i></span>					
					</div>
					<label class="fetch-label">Password:</label>
					<div class="frm-fld">
						<input class="effect-9" type="password" disabled="" name="api_password" id="api_password" value="" />
					    <span class="focus-border"><i></i></span>					
					</div> -->
					<input class="effect-9" name="is_admin" id="is_admin" type="hidden" value="1" />
					<?php } else { ?>
						<input class="effect-9" name="api_userName" id="api_userName" type="hidden" value="<?php echo $_SESSION[ 'api_username' ]; ?>" />
						<input class="effect-9" type="hidden" name="api_password" id="api_password" value="<?php echo $_SESSION[ 'hashKey' ]; ?>" />
					<?php } ?>
					<label class="fetch-label">Category :</label>
					<div class="frm-fld select-info">
						<select name="categoryType" id="dirCategory">
							<option value="deals">Deals Category</option>
							<option value="directory">Directory Category</option>
							<option value="funds">Funds Category</option>
						</select>					
					</div>
					<div class="forDeals">
						<label class="fetch-label">Deal Type:</label>
						<div class="frm-fld select-info">
							<select name="dealtype" id="dealtype">
								<option value="INVESTMENTS">Investments</option>
								<option value="EXITS">Exits</option>
							</select>					
						</div>
						
						<label class="fetch-label">Deal Category:</label>
						<div class="frm-fld select-info">
							<select name="dealcategory" id="dealcategory">
								<option class="invest_select" value="PE">PE</option>
								<option class="invest_select" value="VC">VC</option>
								<option class="invest_select" value="ANGEL">Angel</option>
								<option class="invest_select" value="INCUBATION">Incubation</option>
								<option class="invest_select" value="SOCIAL">Social</option>
								<option class="invest_select" value="CLEANTECH">Cleantech</option>
								<option class="invest_select" value="INFRASTRUCTURE">Infrasturcture</option>

								<option class="exits_select" disabled="" value="PEMA">PE - M&amp;A Exit</option>
								<option class="exits_select" disabled="" value="PEPM">PE - Public Market EXIT</option>
								<option class="exits_select" disabled="" value="PEIPO">PE - IPOExit</option>
								<option class="exits_select" disabled="" value="VCMA">VC - M&amp;A Exit</option>
								<option class="exits_select" disabled="" value="VCPM">VC - Public Market EXIT</option>
								<option class="exits_select" disabled="" value="VCIPO">VC - IPOExit</option>
							</select>					
						</div>
						<div class="forDirectory" style="display:none">
						<label class="fetch-label">Type :</label>
						<div class="frm-fld select-info">
							<select  name="dirCategoryType" id="dirCategoryType">
								<option class=""  value="investor">Investor</option>
								<option class="" value="company">Company</option>
								<option class="" value="legalAdvisor">Legal Advisor</option>
								<option class=""  value="transactionAdvisor">Transaction Advisor</option>
								<option class="forAngel"  value="fundedComp">Funded Companies</option>
								<option class="forAngel"  value="fundraisingComp">Fundraising Companies</option>
								<option class="forIncubation"  value="incubator">Incubator/Accelerator</option>
								<option class="forIncubation"  value="incubatee">Incubatee</option>
							</select>					
						</div>
						</div>
					</div>
					<!-- Time Filter -->
					<label class="fetch-label">From :</label>
						<div class="frm-fld select-info" style="width: 47%;">
							<select  name="from_month" id="from_month">
								<option value="00">Month</option>
								<option value="01">January</option>
								<option value="02">February</option>
								<option value="03">March</option>
								<option value="04">April</option>
								<option value="05">May</option>
								<option value="06">June</option>
								<option value="07">July</option>
								<option value="08">August</option>
								<option value="09">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>					
						</div>
						<div class="frm-fld select-info" style="width: 47%;margin-left: 14px;">
							<select  name="from_year" id="from_year">
								<option value="0000">Year</option>
								<option value="2020">2020</option>
								<option value="2019">2019</option>
								<option value="2018">2018</option>
								<option value="2017">2017</option>
								<option value="2016">2016</option>
								<option value="2015">2015</option>
								<option value="2014">2014</option>
								<option value="2013">2013</option>
								<option value="2012">2012</option>
								<option value="2011">2011</option>
								<option value="2010">2010</option>
								<option value="2009">2009</option>
								<option value="2008">2008</option>
								<option value="2007">2007</option>
								<option value="2006">2006</option>
								<option value="2005">2005</option>
								<option value="2004">2004</option>
								<option value="2003">2003</option>
								<option value="2002">2002</option>
								<option value="2001">2001</option>
								<option value="2000">2000</option>
								<option value="1999">1999</option>
								<option value="1998">1998</option>
							</select>					
						</div>
						<!-- To -->
						<label class="fetch-label">To :</label>
						<div class="frm-fld select-info" style="width: 47%;">
							<select  name="to_month" id="to_month">
								<option value="00">Month</option>
								<option value="01">January</option>
								<option value="02">February</option>
								<option value="03">March</option>
								<option value="04">April</option>
								<option value="05">May</option>
								<option value="06">June</option>
								<option value="07">July</option>
								<option value="08">August</option>
								<option value="09">September</option>
								<option value="10">October</option>
								<option value="11">November</option>
								<option value="12">December</option>
							</select>					
						</div>
						<div class="frm-fld select-info" style="width: 47%;margin-left: 14px;">
							<select  name="to_year" id="to_year">
								<option value="0000">Year</option>
								<option valuec="2020">2020</option>
								<option value="2019">2019</option>
								<option value="2018">2018</option>
								<option value="2017">2017</option>
								<option value="2016">2016</option>
								<option value="2015">2015</option>
								<option value="2014">2014</option>
								<option value="2013">2013</option>
								<option value="2012">2012</option>
								<option value="2011">2011</option>
								<option value="2010">2010</option>
								<option value="2009">2009</option>
								<option value="2008">2008</option>
								<option value="2007">2007</option>
								<option value="2006">2006</option>
								<option value="2005">2005</option>
								<option value="2004">2004</option>
								<option value="2003">2003</option>
								<option value="2002">2002</option>
								<option value="2001">2001</option>
								<option value="2000">2000</option>
								<option value="1999">1999</option>
								<option value="1998">1998</option>
							</select>					
						</div>
					<!-- End Time Filter -->
					<!-- <label class="fetch-label">Year:</label> -->
					<div class="frm-fld">
						<!-- <input class="effect-9" type="text" name="time" id="time" value="" /><br> -->
						<div class="login-as-admin"> <p style="margin-top: 10px;"><input class="effect-2" name="isAll" id="isAll" type="checkbox" value="All"><label class="admin_acc">All</label></p> </div>
					</div>
					<label class="fetch-label">Filter Result:</label>
					<div class="frm-fld select-info">
					<select name="dataFiler" id="dataFiler">
						<?php 
							if( $_SESSION[ 'is_admin' ] ) {
							?>
							<option value="all">All</option>
							<?php 
								}
							?>
							<option selected value="10">Top 10 deals</option>
							<option value="25"> Top 25 deals</option>
							
						</select>				
					</div>

					<label class="fetch-label">Data Type:</label>
					<div class="frm-fld select-info">
						<select name="datatype" id="datatype">
							<option value="1">Details</option>
							<option class="aggregate" value="2">Aggregate</option>
						</select>					
					</div>
					<div class="forCompany">
						<label class="fetch-label">Company Name <small class="text-muted">(optional)</small>:</label>
						<div class="frm-fld">
							<input class="effect-9" type="text" name="company" id="company" value="" />					
						</div>
					</div>
					<div class="forInvestor">
						<label class="fetch-label">Investor Name <small class="text-muted">(optional)</small>:</label>
						<div class="frm-fld">
							<input class="effect-9" type="text" name="investor" id="investor" value="" />					
						</div>
					</div>
					
					
					<div class="frm-fld">
						<a href="javascript:;"  id="submit" class="btn c-btn btn-primary">Fetch</a>
					</div>
					<?php if( $_SESSION[ 'is_admin' ] ) { ?>
					<div class="clearfix"></div>
					<!-- <div class="well well-sm"> -->
					<label class="fetch-label">Change DB:</label>
					<div class="frm-fld select-info">
						<select name="db_type" id="db_type">
							<option value="cfs">CFS</option>
							<option selected="" value="pe">PE</option>
							<option value="ma">MA</option>
						</select>
					</div>
					<label class="fetch-label">Api Fields Check:</label>
					<div class="frm-fld">
						<a href="javascript:;" class="cfs-btn btn c-btn btn-primary">CFS</a>
						<a href="javascript:;" class="pe-btn btn c-btn btn-primary">PE</a>
						<a href="javascript:;" class="ma-btn btn c-btn btn-primary">MA</a>
					</div>
					<!-- <div class="clearfix"></div>
					</div> -->
					<?php } ?>				
				</div>
			</form>
		</div>

		<div class="col-lg-9 col-md-9 col-sm-8 col-xs-12 right-sec">
			<div class="col-xs-12 no-pd">
				<div class="result-wpr" style="display: block;">
					<div class="result-radio-wrapper">
						<div class="radio-sec">
							<span class="result-text">Results</span>
							 <div class="result-radio">
								<form action="#">
								  <p>
								    <input type="radio" id="test1" name="radio-group" checked>
								    <label for="test1">TABLE</label>
								  </p>
								  <p>
								    <input type="radio" id="test2" name="radio-group">
								    <label for="test2">JSON</label>
								  </p>
								</form>						
							</div> 
						</div>
						<?php if( $_SESSION[ 'is_admin' ] ) { ?>
						<button class="btn c-btn pull-right" id="fetch_update_cin">Fetch</button>
						<div class="cin-select-sec">
							<label class="fetch-label">Check CIN Update:</label>
							<div class="frm-fld select-info">
								<select name="week" id="week">
									<option value="1">1 week</option>
									<option value="2">2 weeks</option>
									<option value="3">3 weeks</option>
									<option value="4">4 weeks</option>
									<option value="8">8 weeks</option>
								</select>					
							</div>
						</div>
						<?php } ?>
					</div>

					<!-- Fetch Popup -->
					<div class="modal fade" id="fetchInfo" role="dialog">
					    <div class="modal-dialog" style="width: 700px;">
					    
					      <!-- Modal content-->
					      <div class="modal-content">
					        <div class="modal-header">
					          <button type="button" class="close" data-dismiss="modal">&times;</button>
					          <h4 class="modal-title">Recent Updated CIN's</h4>
					        </div>
					        <div class="modal-body">
					        </div>
					        <div class="modal-footer">
					          <button type="button" class="btn c-btn btn-default" data-dismiss="modal">Close</button>
					        </div>
					      </div>
					      
					    </div>
					</div>
					<div class="result-tbl-wpr pecompanylist"  style="display:none;">
						<span class="no-results">Generate Json to check the updated data.</span>
					</div>
					<div class="json-resposne">
						<span class="no-results">Generate Json to check the updated data.</span>
						<pre class="json-code" style="width:100%; display: none;"></pre>
						<form action="downloadPEJson.php" method="post">
							<input type="hidden" name="jsonObj" id="jsonObj" />
							<button type="submit" class="btn c-btn pull-right" id="exportData" style="display: none;">Download JSON</button>	
						</form>
					</div>
				</div>
				<div class="cfs-fields" style="display: none;">
					<h3>CFS API Fields <span class="close-icon">&times;</span></h3>
					<div class="row">
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>Username</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									CFS login username
								</div>
							</div>
						</div>
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>Password</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									CFS login password
								</div>
							</div>
						</div>
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>CIN</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									Company CIN number
								</div>
							</div>
						</div>
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>Currency Code</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									INR OR USD
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="pe-fields" style="display: none;">
					<h3>PE API Fields <span class="close-icon">&times;</span></h3>
					<div class="row">
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>Dealtype</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									INVESTMENTS OR EXITS
								</div>
							</div>
						</div>
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>Deal Category</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									INVESTMENT CATEGORY : (PE, VC, Angel, Incubation, Social, Cleantech, Infrastructure).<br/><br/>
									EXITS  CATEGORY : (PE-M&A Exit, PE - Public Market EXIT, PE – IPOExit, VC-M&A Exit, VC - Public Market EXIT, VC - IPOExit ).
								</div>
							</div>
						</div>
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>Time</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									1.For Monthly result, input must be value  i.e :<br/>

									    For January value is 1 with year  e.g. 1/2016.
									    For Feb value is 2 with year  e.g. 2/2016.
									    For March value is 3with year  e.g. 3/2016.
									    For April value is 4with year  e.g. 4/2016.
									    For May value is 5 with year  e.g. 5/2016.
									    For June value is 6 with year  e.g. 6/2016.
									    For July value is 7 with year  e.g. 7/2016.
									    For August value is 8 with year  e.g. 8/2016.
									    For Spetember value is 9 with year  e.g. 9/2016.
									    For October value is 10 with year  e.g. 10/2016.
									    For November value is 11 with year  e.g. 11/2016.
									    For December value is 12 with year  e.g. 12/2016.<br/><br/>

									2.For Quaterly result, input must be value  i.e :<br/>

									    For First Quater, input must be value with Q and year e.g. 1Q/2016
									    For Second Quater, input must be value with Q and year e.g. 2Q/2016.
									    For Third Quater, input must be value with Q and year e.g. 3Q/2016.
									    For Fourth Quater, input must be value with Q and year e.g. 4Q/2016.<br/><br/>

									3.For Yearly result, input must be value  i.e :<br/>

									    For year, input must be only year e.g. 2016 or 2015 etc.

								</div>
							</div>
						</div>
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>Datatype</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									For DETAILS value assigned as 1.<br/><br/>
    								For AGGREGATE value assigned as 2.
								</div>
							</div>
						</div>
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>Company / Investor</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									Search by Company name or by Investor name. The result return period is from 1998 to current month, it will take all the years.
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="ma-fields" style="display: none;">
					<h3>M&amp;A API Fields <span class="close-icon">&times;</span></h3>
					<div class="row">
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>Section</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									For Deals value is 1 and for Directory its 2
								</div>
							</div>
						</div>
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>Dealtype</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									For Inbound value assigned as 1.<br/>
								    For Outbound value assigned as 2.<br/>
								    For Domestic value assigned as 3.<br/>
								</div>
							</div>
						</div>
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>Time</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									Default is ALL YEAR (2004 to Current Year)<br/><br/>
								    1. For Monthly result, input must be value  i.e :<br/>
								    For January value is 1 with year  e.g. 1/2016.<br/>
								    For Feb value is 2 with year  e.g. 2/2016.<br/>
								    For March value is 3with year  e.g. 3/2016.<br/><br/>
								    2. For Quarterly result, input must be value  i.e :<br/>
								    For First Quarter, input must be value with Q and year e.g. 1Q/2016.<br/>
								    For Second Quarter, input must be value with Q and year e.g. 2Q/2016.<br/>
								    For Third Quarter, input must be value with Q and year e.g. 3Q/2016.<br/>
								    For Fourth Quarter, input must be value with Q and year e.g. 4Q/2016.<br/><br/>
								    3. For Yearly result, input must be value  i.e :<br/>
								    For year, input must be only year e.g. 2016 or 2015 etc.
								</div>
							</div>
						</div>
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>Datatype</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									For DETAILS value assigned as 1.<br/>
    								For AGGREGATE value assigned as 2.
								</div>
							</div>
						</div>
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>Company</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									1. For Target company, input value must be 1 with company name e.g. CARE/1.
    								2.For Acquirer company, input value must be 2 with company name e.g. CARE/2
								</div>
							</div>
						</div>
						<div class="frm-fld">
							<div class="col-sm-3">
								<label>Category</label>
							</div>
							<div class="col-sm-6">
								<div class="well well-sm">
									category field must only used for Directory section. In Directory,<br/>
								    1. For Target Company, input value must be 1.<br/>
								    2. For Acquirer Company, input value must be 2.<br/>
								    3. For Legal Advisor, input value must be 3.<br/>
								    4.For Transaction Advisor, input value must be 4.

								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	$( document ).ready( function() {
		$( '#db_type' ).on( 'change', function() {
			if( $( this ).val() == 'cfs' ) {
				window.location.href = 'home.php';
			} else if( $( this ).val() == 'pe' ) {
				window.location.href = 'peapi.php';
			} else if( $( this ).val() == 'ma' ) {
				window.location.href = 'maapi.php';
			}
		});
		$( '#dealtype' ).on( 'change', function() {
			if( $( this ).val() == 'INVESTMENTS' ) {
				$( '.exits_select' ).attr('disabled', true);
				$( '.invest_select' ).removeAttr( 'disabled' );
				$( '.forAngel' ).removeAttr('disabled');
				$( '.forIncubation' ).removeAttr('disabled');
				$( '#dealcategory').val('PE');
				$( '#dealcategory option[value=PE]').attr('selected','selected');
			} else if( $( this ).val() == 'EXITS' ) {
				$( '.invest_select' ).attr('disabled', true);
				$( '.exits_select' ).removeAttr( 'disabled' );
				$( '.forAngel' ).attr('disabled', true);
				$( '.forIncubation' ).attr('disabled', true);
				$( '#dealcategory').val('PEMA');
				$( '#dealcategory option[value=PEMA]').attr('selected','selected');
			}
		});

		$( '#company, #investor' ).on( 'keyup', function() {
			
			if($(this).val() != '' && $(this).val() != undefined){
				$("#dataFiler").css({"background-color": "#999999", "cursor": "not-allowed"});
				$('#dataFiler').attr( 'disabled', true );
			} else {
				$("#dataFiler").css({"background-color": "buttonface", "cursor": "default"});
				$('#dataFiler').attr( 'disabled', false );
			}
			
		});

		$( '#submit' ).click( function() {
			var error = 0;
			var msg = '';
			var timeVal = $( '#time' ).val();
			var fromMonth = $( '#from_month' ).val();
			var fromYear = $( '#from_year' ).val();
			var toMonth = $( '#to_month' ).val();
			var toYear = $( '#to_year' ).val();
			var isAll = $( '#isAll' ).val();
			var companyName = $( '#company' ).val();
			var investorName = $( '#investor' ).val();
			var datatype = $( '#datatype' ).val();
			var datafilter = $( '#dataFiler' ).val();
			var dealcategory = $( '#dealcategory' ).val();
			var dealtype = $( '#dealtype' ).val();
			var dirCategory = $('#dirCategory').val();
			var dirCategoryType = $('#dirCategoryType').val();
			var userType = 'internal';
			var token = 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9';

			//var companyName = $('#company').val();
			//var investorName = $('#investor').val();
			//alert(dirCategoryType);
			
			$("#response_table").empty();
			$( '.json-resposne pre' ).empty();

			
			if( $( '#isAll' ).prop( 'checked' ) ) {
				$( '#time' ).val('');
				$( '#from_month' ).val('');
				$( '#from_year' ).val('');
				$( '#to_month' ).val('');
				$( '#to_year' ).val('');
				document.getElementById("from_month").value = "";
				document.getElementById("from_year").value = "";
				document.getElementById("to_month").value = "";
				document.getElementById("to_year").value = "";
				timeVal = "All";
			}else{
				if( (fromMonth == '00' || fromYear == '0000') || (toMonth == '00' || toYear == '0000')  ) {
				msg += 'Please select "From and To" month and year Or All \n';
				error = 1;
				}else if(fromYear > toYear){
					msg += 'To date cannot be less than the From date \n';
					error = 1;
				}
				else if((fromYear == toYear) && (fromMonth > toMonth)){
					msg += 'To date cannot be less than the From date \n';
					error = 1;
				}
			}
			
			
			 
			if( datafilter == '' ) {
				msg += 'Please select Filter Value F \n';
				error = 1;
			} 
			<?php 
			if( is_admin ) { ?>
				if( $( '#user_check' ).prop( 'checked' ) ) {
					var username = $( '#api_userName' ).val();
					var password = $( '#api_password' ).val();
					if( username == '' ) {
						msg += 'Please enter username\n';
						error = 1;
					}
					if( password == '' ) {
						msg += 'Please enter password\n';
						error = 1;
					}
				}
			<?php } ?>
			if( error > 0 ) {
				alert( msg );
				return false;
			}
			$( '.close-icon' ).trigger( 'click' );
			var form = $( '#from_fetch' );
			$( '.body-overlay' ).show();
			// Consume API Start *****************************************************************************************
			// For API Changes
				if(timeVal == 'All'){
					var date_all = 'all';
					fromdate = '';
					todate = '';
				}else{
					var date_all = '';
					fromdate = fromYear+"-"+fromMonth+"-01";
					todate = toYear+"-"+toMonth+"-31";
				}
				if(datafilter == 'all'){
					var allRecord = true;
				}else{
					var allRecord = false;
				}
			// Datas Assign To Variable
				var fromDate = fromdate;
				var toDate = todate;
				var date = date_all;
				var recordCount = Number(datafilter);
				var allRecord = Boolean(allRecord);
				var companyName = companyName;
				var investor = investorName;
				
			// API Path 
			var domain_path = "https://api.vionweb.com/webapi/pe/";
			// API Controls
			if( dirCategory == 'deals' ){
				// Deals API Controls

				// Datas Compose to object For NodeJS API
				var obj =new Object();
					obj.fromDate =fromDate;
					obj.toDate=toDate;
					obj.date=date_all;
					obj.recordCount=Number(recordCount);
					obj.allRecord=Boolean(allRecord);
					obj.companyName=companyName;
					obj.investorName=investor;
					obj.userType=userType;
					obj.token=token;
					
					// datatype - Investments
					if(dealtype == 'INVESTMENTS' && dealcategory == 'PE'){
							var url = domain_path+'deals/investments/pe';
						}else if(dealtype == 'INVESTMENTS' && dealcategory == 'VC'){
							var url = domain_path+'deals/investments/vc';
						}else if(dealtype == 'INVESTMENTS' && dealcategory == 'SOCIAL'){
							var url = domain_path+'deals/investments/social';
						}else if(dealtype == 'INVESTMENTS' && dealcategory == 'CLEANTECH'){
							var url = domain_path+'deals/investments/cleantech';
						}else if(dealtype == 'INVESTMENTS' && dealcategory == 'INFRASTRUCTURE'){
							var url = domain_path+'deals/investments/infrastructure';
						}else if(dealtype == 'INVESTMENTS' && dealcategory == 'INCUBATION'){
							var url = domain_path+'deals/investments/incubation';
						}else if(dealtype == 'INVESTMENTS' && dealcategory == 'ANGEL'){
							var url = domain_path+'deals/investments/angel';
						}
					// datatype - Exits
						if(dealtype == 'EXITS' && dealcategory == 'PEMA'){
							var url = domain_path+'deals/exits/pe-manda';
						}else if(dealtype == 'EXITS' && dealcategory == 'PEPM'){
							var url = domain_path+'deals/exits/pe-publicmarket';
						}else if(dealtype == 'EXITS' && dealcategory == 'PEIPO'){
							var url = domain_path+'deals/exits/pe-ipo';
						}else if(dealtype == 'EXITS' && dealcategory == 'VCMA'){
							var url = domain_path+'deals/exits/vc-manda';
						}else if(dealtype == 'EXITS' && dealcategory == 'VCPM'){
							var url = domain_path+'deals/exits/vc-publicmarket';
						}else if(dealtype == 'EXITS' && dealcategory == 'VCIPO'){
							var url = domain_path+'deals/exits/vc-ipo';
						}
			}
			else if ( dirCategory == 'directory'){
				// Directory API Controlls

				// Datas Compose to object For NodeJS API
					var obj =new Object();
					obj.fromDate =fromDate;
					obj.toDate=toDate;
					obj.date=date_all;
					obj.recordCount=Number(recordCount);
					obj.allRecord=Boolean(allRecord);
					obj.userType=userType;
					obj.token=token;
					// Investments
						if(dealtype == 'INVESTMENTS' && dealcategory == 'PE' && dirCategoryType == 'investor'){
							var url = domain_path+'directory/investments/pe/investor';
							// key
							obj.investorName=investorName;
						}else if(dealtype == 'INVESTMENTS' && dealcategory == 'PE' && dirCategoryType == 'company'){
							var url = domain_path+'directory/investments/pe/company';
							// key
							obj.companyName=companyName;
						}else if (dealtype == 'INVESTMENTS' && dealcategory == 'PE' && dirCategoryType == 'legalAdvisor'){
							var url = domain_path+'directory/investments/pe/legaladvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'PE' && dirCategoryType == 'transactionAdvisor'){
							var url = domain_path+'directory/investments/pe/transactionadvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'VC' && dirCategoryType == 'investor'){
							var url = domain_path+'directory/investments/vc/investor';
							// key
							obj.investorName=investorName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'VC' && dirCategoryType == 'company'){
							var url = domain_path+'directory/investments/vc/company';
							// key
							obj.companyName=companyName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'VC' && dirCategoryType == 'legalAdvisor'){
							var url = domain_path+'directory/investments/vc/legaladvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'VC' && dirCategoryType == 'transactionAdvisor'){
							var url = domain_path+'directory/investments/vc/transactionadvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'ANGEL' && dirCategoryType == 'investor'){
							var url = domain_path+'directory/investments/angel/investor';
							// key
							obj.investorName=investorName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'ANGEL' && dirCategoryType == 'fundedComp'){
							var url = domain_path+'directory/investments/angel/fundedcompanies';
							// key
							obj.companyName=companyName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'ANGEL' && dirCategoryType == 'fundraisingComp'){
							var url = domain_path+'directory/investments/angel/fundraisingcompanies';
							// key
							obj.companyName=companyName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'INCUBATION' && dirCategoryType == 'incubator'){
							var url = domain_path+'directory/investments/incubation/incubator';
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'INCUBATION' && dirCategoryType == 'incubatee'){
							var url = domain_path+'directory/investments/incubation/incubatee';
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'SOCIAL' && dirCategoryType == 'investor'){
							var url = domain_path+'directory/investments/social/investor';
							// key
							obj.investorName=investorName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'SOCIAL' && dirCategoryType == 'company'){
							var url = domain_path+'directory/investments/social/company';
							// key
							obj.companyName=companyName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'SOCIAL' && dirCategoryType == 'legalAdvisor'){
							var url = domain_path+'directory/investments/social/legaladvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'SOCIAL' && dirCategoryType == 'transactionAdvisor'){
							var url = domain_path+'directory/investments/social/transactionadvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'CLEANTECH' && dirCategoryType == 'investor'){
							var url = domain_path+'directory/investments/cleantech/investor';
							// key
							obj.investorName=investorName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'CLEANTECH' && dirCategoryType == 'company'){
							var url = domain_path+'directory/investments/cleantech/company';
							// key
							obj.companyName=companyName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'CLEANTECH' && dirCategoryType == 'legalAdvisor'){
							var url = domain_path+'directory/investments/cleantech/legaladvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'CLEANTECH' && dirCategoryType == 'transactionAdvisor'){
							var url = domain_path+'directory/investments/cleantech/transactionadvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'INFRASTRUCTURE' && dirCategoryType == 'investor'){
							var url = domain_path+'directory/investments/infrastructure/investor';
							// key
							obj.investorName=investorName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'INFRASTRUCTURE' && dirCategoryType == 'company'){
							var url = domain_path+'directory/investments/infrastructure/company';
							// key
							obj.companyName=companyName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'INFRASTRUCTURE' && dirCategoryType == 'legalAdvisor'){
							var url = domain_path+'directory/investments/infrastructure/legaladvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'INVESTMENTS' && dealcategory == 'INFRASTRUCTURE' && dirCategoryType == 'transactionAdvisor'){
							var url = domain_path+'directory/investments/infrastructure/transactionadvisor';
							// key
							obj.advisorName=investorName;
						}
				// Exits
						else if (dealtype == 'EXITS' && dealcategory == 'PEMA' && dirCategoryType == 'investor'){
							var url = domain_path+'directory/exits/pe-manda/investor';
							// key
							obj.investorName=investorName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'PEMA' && dirCategoryType == 'company'){
							var url = domain_path+'directory/exits/pe-manda/company';
							// key
							obj.companyName=companyName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'PEMA' && dirCategoryType == 'legalAdvisor'){
							var url = domain_path+'directory/exits/pe-manda/legaladvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'PEMA' && dirCategoryType == 'transactionAdvisor'){
							var url = domain_path+'directory/exits/pe-manda/transactionadvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'PEPM' && dirCategoryType == 'investor'){
							var url = domain_path+'directory/exits/pe-publicmarket/investor';
							// key
							obj.investorName=investorName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'PEPM' && dirCategoryType == 'company'){
							var url = domain_path+'directory/exits/pe-publicmarket/company';
							// key
							obj.companyName=companyName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'PEPM' && dirCategoryType == 'legalAdvisor'){
							var url = domain_path+'directory/exits/pe-publicmarket/legaladvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'PEPM' && dirCategoryType == 'transactionAdvisor'){
							var url = domain_path+'directory/exits/pe-publicmarket/transactionadvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'PEIPO' && dirCategoryType == 'investor'){
							var url = domain_path+'directory/exits/pe-ipo/investor';
							// key
							obj.investorName=investorName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'PEIPO' && dirCategoryType == 'company'){
							var url = domain_path+'directory/exits/pe-ipo/company';
							// key
							obj.companyName=companyName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'VCMA' && dirCategoryType == 'investor'){
							var url = domain_path+'directory/exits/vc-manda/investor';
							// key
							obj.investorName=investorName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'VCMA' && dirCategoryType == 'company'){
							var url = domain_path+'directory/exits/vc-manda/company';
							// key
							obj.companyName=companyName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'VCMA' && dirCategoryType == 'legalAdvisor'){
							var url = domain_path+'directory/exits/vc-manda/legaladvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'VCMA' && dirCategoryType == 'transactionAdvisor'){
							var url = domain_path+'directory/exits/vc-manda/transactionadvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'VCPM' && dirCategoryType == 'investor'){
							var url = domain_path+'directory/exits/vc-publicmarket/investor';
							// key
							obj.investorName=investorName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'VCPM' && dirCategoryType == 'company'){
							var url = domain_path+'directory/exits/vc-publicmarket/company';
							// key
							obj.companyName=companyName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'VCPM' && dirCategoryType == 'legalAdvisor'){
							var url = domain_path+'directory/exits/vc-publicmarket/legaladvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'VCPM' && dirCategoryType == 'transactionAdvisor'){
							var url = domain_path+'directory/exits/vc-publicmarket/transactionadvisor';
							// key
							obj.advisorName=investorName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'VCIPO' && dirCategoryType == 'investor'){
							var url = domain_path+'directory/exits/vc-ipo/investor';
							// key
							obj.investorName=investorName;
						}
						else if (dealtype == 'EXITS' && dealcategory == 'VCIPO' && dirCategoryType == 'company'){
							var url = domain_path+'directory/exits/vc-ipo/company';
							// key
							obj.companyName=companyName;
						}
			}
			else if ( dirCategory == 'funds'){
				// Funds API Controlls

				// Datas Compose to object For NodeJS API
				var obj =new Object();
					obj.fromDate =fromDate;
					obj.toDate=toDate;
					obj.date=date_all;
					obj.recordCount=Number(recordCount);
					obj.allRecord=Boolean(allRecord);
					obj.investorName=investorName;
					obj.userType=userType;
					obj.token=token;
				var url = domain_path+'funds';
			}
				
			// Ajax Section Start Here
			$.ajax({
				type : 'POST',
				url : url,
				dataType: 'json',
				contentType: 'application/json',
				data:JSON.stringify(obj),
				success: function(msg){
					// For API Changes ************************************************************
						// JSON Values 
							$( '#test1' ).trigger( 'click' );
							$( '.json-resposne .no-results' ).hide();
							$( '.json-resposne pre' ).show().html( JSON.stringify(msg, undefined, 2) );
							$( '#jsonObj' ).val( JSON.stringify(msg, undefined, 2) );
							$( '#exportData' ).show();
							$( '.body-overlay' ).hide();
						// END JSON
						// TABLE
						if( dirCategory == 'deals' ){
							//  Deals Category Menus 
							if((dealtype == 'INVESTMENTS' && dealcategory == 'PE') || (dealtype == 'INVESTMENTS' && dealcategory == 'VC') || (dealtype == 'INVESTMENTS' && dealcategory == 'SOCIAL') || (dealtype == 'INVESTMENTS' && dealcategory == 'CLEANTECH') || (dealtype == 'INVESTMENTS' && dealcategory == 'INFRASTRUCTURE')){
								$str = '<table id="response_data_table">'
									+'<thead>'
										+'<tr>'
											+'<th>Company Name</th>'
											+'<th>Details</th>'
										+'</tr>'
									+'</thead>'
										+'<tbody id="response_table">'
										+'</tbody>'
									+'</table>';
									$( '.result-tbl-wpr .no-results' ).hide();
									$( '.result-tbl-wpr' ).show();
									$( '.result-tbl-wpr' ).html( $str );
									
									$.each(msg.Deal_Details, function(index) {
										$("#response_table").append('<tr>'
												+'<td>'+msg.Deal_Details[index].CompanyName+'</td>'
												+'<td><span class="showinfo-link info-link">Show details</span></td>'
											+'</tr>'
											+'<tr class="infoTR financialRow pecompanydetails" style="display: none;">'
												+'<td colspan="6" class="no-pd">'
													+'<div class="fin-wpr">'
														+'<ul class="nav nav-tabs">'
															+'<li class="active"><a data-toggle="tab" href="#deal_info' +msg.Deal_Details[index].PEId+ '">Deal Info</a></li>'
															+'<li><a data-toggle="tab" href="#valuation_info' +msg.Deal_Details[index].PEId+ '">Valuation Info</a></li>'
															+'<li><a data-toggle="tab" href="#financial_info' +msg.Deal_Details[index].PEId+ '">Financials </a></li>'
															+'<li><a data-toggle="tab" href="#investor_info' +msg.Deal_Details[index].PEId+ '">Investor Info</a></li>'
															+'<li><a data-toggle="tab" href="#company_info' +msg.Deal_Details[index].PEId+ '">Company Info</a></li>'
															+'<li><a data-toggle="tab" href="#more_info' +msg.Deal_Details[index].PEId+ '">More Info</a></li>'
														+'</ul>'
														+'<div class="tab-content tbl-cnt">'
															+'<div id="deal_info' +msg.Deal_Details[index].PEId+ '" class="tab-pane fade active in">'
																+'<ul class="fix-ul">'
																	+'<li><span>Amount ($ M)</span></li>'
																	+'<li><span>Amount (₹ Cr)</span></li>'
																	+'<li><span>Exit Status</span></li>'
																	+'<li><span>Date</span></li>'
																	+'<li><span>BV Per Share</span></li>'
																	+'<li><span>Stake</span></li>'
																	+'<li><span>Stage</span></li>'
																	+'<li><span>Round</span></li>'
																	+'<li><span>Price Per Share</span></li>'
																	+'<li><span>Price To Book</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['amount']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['Amount_INR']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['Exit Status']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['date']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['BV Per Share']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['Stake']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['stage']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['round']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['Price Per Share']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['Price To Book']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="investor_info' +msg.Deal_Details[index].PEId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Investor</span></li>'
																	+'<li><span>Investor Type</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Investor Info'][0]['Investor']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Investor Info'][0]['InvestorType']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="financial_info' +msg.Deal_Details[index].PEId+'" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Financial Year</span></li>'
																	+'<li><span>Revenue</span></li>'
																	+'<li><span>EBITDA</span></li>'
																	+'<li><span>PAT</span></li>'
																	+'<li><span>Total Debt</span></li>'
																	+'<li><span>Cash & Cash Equ.</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Financials'][0]['Financial Year']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financials'][0]['Revenue']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financials'][0]['EBITDA']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financials'][0]['PAT']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financials'][0]['Total_Debt']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financials'][0]['Cash_Equ']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="valuation_info' +msg.Deal_Details[index].PEId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li class="empty-tab"><span></span></li>'
																	+'<li><span>Valuation</span></li>'
																	+'<li><span>Revenue Multiple</span></li>'
																	+'<li><span>EBITDA Multiple</span></li>'
																	+'<li><span>PAT Multiple</span></li>'
																	+'<li><span>More Info</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll valuation-tab">'
																		+'<ul>'
																			+'<li><span>Pre Money</span></li>'
																			+'<li ><span>'+msg.Deal_Details[index]['Valuation Info'][0]['Pre Money Valuation']['Company_Valuation']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Valuation Info'][0]['Pre Money Valuation']['Revenue_Multiple']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Valuation Info'][0]['Pre Money Valuation']['EBITDA_Multiple']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Valuation Info'][0]['Pre Money Valuation']['PAT_Multiple']+'</span></li>'
																		+'</ul>'
																		+'<ul>'
																			+'<li><span>Post Money</span></li>'
																			+'<li ><span>'+msg.Deal_Details[index]['Valuation Info'][0]['Post Money Valuation']['Company_Valuation']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Valuation Info'][0]['Post Money Valuation']['Revenue_Multiple']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Valuation Info'][0]['Post Money Valuation']['EBITDA_Multiple']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Valuation Info'][0]['Post Money Valuation']['PAT_Multiple']+'</span></li>'
																		+'</ul>'
																		+'<ul>' 
																			+'<li><span>EV</span></li>'
																			+'<li ><span>'+msg.Deal_Details[index]['Valuation Info'][0]['EV']['Company_Valuation']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Valuation Info'][0]['EV']['Revenue_Multiple']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Valuation Info'][0]['EV']['EBITDA_Multiple']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Valuation Info'][0]['EV']['PAT_Multiple']+'</span></li>'
																		+'</ul>'
																		+'<span class="more-info-val">'+msg.Deal_Details[index]['Valuation Info'][0]['More info']+'</span>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="company_info' +msg.Deal_Details[index].PEId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Company</span></li>'
																	+'<li><span>Industry</span></li>'
																	+'<li><span>Sector</span></li>'
																	+'<li><span>Type</span></li>'
																	+'<li><span>City</span></li>'
																	+'<li><span>Region</span></li>'
																	+'<li><span>Website</span></li>'
																	+'<li><span>News Link</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Info'][0]['companyname']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Info'][0]['industry']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Info'][0]['sector_business']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Info'][0]['companyType']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Info'][0]['city']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Info'][0]['region']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Info'][0]['website']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Info'][0]['Link']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="more_info' +msg.Deal_Details[index].PEId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Moreinfo</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li class="moreinfodetails"><span >'+msg.Deal_Details[index]['More Info'][0]['Moreinfo']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
														+'</div>'
													+'</div>'
												+'</td>'
											+'</tr>'
										);			
									
									});
									$("html, body").animate({ scrollTop: 0 }, "slow");
							}else if(dealtype == 'INVESTMENTS' && dealcategory == 'ANGEL'){
								$str = '<table id="response_data_table">'
									+'<thead>'
										+'<tr>'
											+'<th>Company Name</th>'
											+'<th>Details</th>'
										+'</tr>'
									+'</thead>'
										+'<tbody id="response_table">'
											
										+'</tbody>'
									+'</table>';
									$( '.result-tbl-wpr .no-results' ).hide();
									$( '.result-tbl-wpr' ).show();
									$( '.result-tbl-wpr' ).html( $str );
									
									$.each(msg.Deal_Details, function(index) {

										// Investor deal period groupby methods
										investorsName= msg.Deal_Details[index]['Investments']['Angel investors'];
										var resultArray =[];
										var names = "";
										var currentPeriod;
										var nextPeriod="";
										for(var i=0;i<investorsName.length;i++)
										{
											currentPeriod = investorsName[i]['Deal Period'].substring(4,8);
											var InvestorName = investorsName[i]['Investor Name']; 
											if(i<investorsName.length-1)
											{
												nextPeriod = investorsName[i+1]['Deal Period'].substring(4,8);
											}
											// console.log(currentPeriod+"zdfgsrd"+nextPeriod);
											if(currentPeriod==nextPeriod)
											{
												names = names + "," +InvestorName;
											}
											else{
												resultArray.push(currentPeriod +names + "," +InvestorName);
												names = "";
											}

										}
										if(nextPeriod != "")
											resultArray.push(currentPeriod +names);
										// End Investor deal period groupby methods
										// console.log(resultArray);

										$("#response_table").append('<tr>'
												+'<td>'+msg.Deal_Details[index].companyname+'</td>'
												+'<td><span class="showinfo-link info-link">Show details</span></td>'
											+'</tr>'
											+'<tr class="infoTR financialRow pecompanydetails" style="display: none;">'
												+'<td colspan="6" class="no-pd">'
													+'<div class="fin-wpr">'
														+'<ul class="nav nav-tabs">'
															+'<li class="active"><a data-toggle="tab" href="#deal_info' +msg.Deal_Details[index].AngelDealId+ '">Deal Info</a></li>'
															+'<li><a data-toggle="tab" href="#company_info' +msg.Deal_Details[index].AngelDealId+ '">Company Info</a></li>'
															+'<li><a data-toggle="tab" href="#company_profile' +msg.Deal_Details[index].AngelDealId+ '">Company Profile</a></li>'
															+'<li><a data-toggle="tab" href="#investor_info' +msg.Deal_Details[index].AngelDealId+ '">Investor Info</a></li>'
															+'<li><a data-toggle="tab" href="#more_info' +msg.Deal_Details[index].AngelDealId+ '">More Info</a></li>'
														+'</ul>'
														+'<div class="tab-content tbl-cnt">'
															+'<div id="deal_info' +msg.Deal_Details[index].AngelDealId+ '" class="tab-pane fade active in">'
																+'<ul class="fix-ul">'
																	+'<li><span>Investor</span></li>'
																	+'<li><span>Multiple round</span></li>'
																	+'<li><span>Follow on Funding</span></li>'
																	+'<li><span>Exited status</span></li>'
																	+'<li><span>Date</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['Investor']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['multipleround']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['followonFunding']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['exitedstatus']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index].Deal_Info[0]['date']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="company_info' +msg.Deal_Details[index].AngelDealId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Company Name</span></li>'
																	+'<li><span>Industry</span></li>'
																	+'<li><span>Sector</span></li>'
																	+'<li><span>City</span></li>'
																	+'<li><span>Region</span></li>'
																	+'<li><span>Website</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Info'][0]['companyname']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Info'][0]['industry']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Info'][0]['sector']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Info'][0]['city']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Info'][0]['region']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Info'][0]['website']+'</span></li>'
																			
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="company_profile' +msg.Deal_Details[index].AngelDealId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Company name</span></li>'
																	+'<li><span>Investor</span></li>'
																	+'<li><span>Industry</span></li>'
																	+'<li><span>Sector</span></li>'
																	+'<li><span>Website</span></li>'
																	+'<li><span>Address</span></li>'
																	+'<li><span>City</span></li>'
																	+'<li><span>Zipcode</span></li>'
																	+'<li><span>OtherLocation</span></li>'
																	+'<li><span>Country</span></li>'
																	+'<li><span>Telephone</span></li>'
																	+'<li><span>Fax</span></li>'
																	+'<li><span>Email</span></li>'
																	+'<li><span>Stock code</span></li>'
																	+'<li><span>Year founded</span></li>'
																	+'<li><span>LinkedIn</span></li>'
																	+'<li><span>LinkedIn_Company</span></li>'
																	+'<li><span>News</span></li>'
																	+'<li><span>Additional Information</span></li>'
																	+'<li><span>Top Management</span></li>'
																	+'<li><span>Investor Board Member</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Companyname']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Investor']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Industry']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Sector']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Website']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Address']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['City']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Zipcode']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['OtherLocation']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Country']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Telephone']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Fax']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Email']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Stockcode']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Yearfounded']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['LinkedIn']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['LinkedIn_Company']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['News']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['AdditionalInformation']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile']['Top Management']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile']['Investor Board Member']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="investor_info' +msg.Deal_Details[index].AngelDealId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul" id="DealPeriod'+msg.Deal_Details[index].AngelDealId+'">'
																	+'<li class="empty-tab"><span>PE/VC investors</span></li>'
																	+'<li><span>incubators</span></li>'
																	+'<li style="padding:8px;"><u>Deal Period</u></li>'
																	+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll valuation-tab">'
																		+'<ul id="InvestorName'+msg.Deal_Details[index].AngelDealId+'">'
																			+'<li ><span>'+msg.Deal_Details[index]['Investments']['PE/VC investors']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Investments']['incubators']+'</span></li>'
																			+'<li style="padding: 5px;margin: 5px;text-align: left;width:auto;"><u>Investor Name</u></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="more_info' +msg.Deal_Details[index].AngelDealId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>More info</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['More Info'][0]['Moreinfo']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
														+'</div>'
													+'</div>'
												+'</td>'
											+'</tr>'
										);			
										// Dynamic Values Appending place for Investor Info
										// Investor Info -> Investor Name
										var InvestorName = "";
											if(resultArray.length != 0){
												for(var i=0;i<resultArray.length;i++)
												{
													InvestorName = "<li style='padding: 5px;margin: 5px;text-align: left;width:auto;'>"+resultArray[i].substring(5)+"</li>";
													// console.log(InvestorName);
													$("#InvestorName"+msg.Deal_Details[index].AngelDealId).append(InvestorName);
												}
											}else{
												InvestorName ="<li>--</li>";
												$("#InvestorName"+msg.Deal_Details[index].AngelDealId).append(InvestorName);

											}
											
											// Investor Info -> Deal Period
											var DealPeriod = "";
											if(resultArray.length != 0){
												for(var i=0;i<resultArray.length;i++)
												{
													DealPeriod = "<li style='padding: 8px;'>"+resultArray[i].substring(0, 4)+"</li>";
													// console.log(DealPeriod);
													$("#DealPeriod"+msg.Deal_Details[index].AngelDealId).append(DealPeriod);
												}
											}else{
												DealPeriod ="<li>--</li>";
												$("#DealPeriod"+msg.Deal_Details[index].AngelDealId).append(DealPeriod);

											}
										// End  Dynamic Values Appending place for Investor Info
									});
									$("html, body").animate({ scrollTop: 0 }, "slow");

							}else if(dealtype == 'INVESTMENTS' && dealcategory == 'INCUBATION'){
								$str = '<table id="response_data_table">'
									+'<thead>'
										+'<tr>'
											+'<th>Company Name</th>'
											+'<th>Details</th>'
										+'</tr>'
									+'</thead>'
										+'<tbody id="response_table">'
											
										+'</tbody>'
									+'</table>';
									$( '.result-tbl-wpr .no-results' ).hide();
									$( '.result-tbl-wpr' ).show();
									$( '.result-tbl-wpr' ).html( $str );
									
									$.each(msg.Deal_Details, function(index) {
										$("#response_table").append('<tr>'
												+'<td>'+msg.Deal_Details[index].CompanyName+'</td>'
												+'<td><span class="showinfo-link info-link">Show details</span></td>'
											+'</tr>'
											+'<tr class="infoTR financialRow pecompanydetails" style="display: none;">'
												+'<td colspan="6" class="no-pd">'
													+'<div class="fin-wpr">'
														+'<ul class="nav nav-tabs">'
															+'<li><a data-toggle="tab" href="#company_info' +msg.Deal_Details[index].IncDealId+ '">Company Info</a></li>'
															+'<li><a data-toggle="tab" href="#company_profile' +msg.Deal_Details[index].IncDealId+ '">Company Profile</a></li>'
															+'<li><a data-toggle="tab" href="#financial_info' +msg.Deal_Details[index].IncDealId+ '">Investor Info</a></li>'
															+'<li><a data-toggle="tab" href="#investor_info' +msg.Deal_Details[index].IncDealId+ '">Investor Info</a></li>'
															+'<li><a data-toggle="tab" href="#more_info' +msg.Deal_Details[index].IncDealId+ '">More Info</a></li>'
														+'</ul>'
														+'<div class="tab-content tbl-cnt">'
															+'<div id="company_info' +msg.Deal_Details[index].IncDealId+ '" class="tab-pane fade active in">'
																+'<ul class="fix-ul">'
																	+'<li><span>Follow on Fund</span></li>'
																	+'<li><span>Incubator</span></li>'
																	+'<li><span>Status</span></li>'
																	+'<li><span>City</span></li>'
																	+'<li><span>Company</span></li>'
																	+'<li><span>Deal date</span></li>'
																	+'<li><span>Industry</span></li>'
																	+'<li><span>Region</span></li>'
																	+'<li><span>Sector_business</span></li>'
																	+'<li><span>Website</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['FollowonFund']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['Incubator']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['Status']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['city']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['company']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['deal_date']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['industry']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['region']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['sector_business']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['website']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="company_profile' +msg.Deal_Details[index].IncDealId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Additional Information</span></li>'
																	+'<li><span>Address</span></li>'
																	+'<li><span>City</span></li>'
																	+'<li><span>Company name</span></li>'
																	+'<li><span>Country</span></li>'
																	+'<li><span>Email</span></li>'
																	+'<li><span>Fax</span></li>'
																	+'<li><span>Industry</span></li>'
																	+'<li><span>Investor</span></li>'
																	+'<li><span>LinkedIn</span></li>'
																	+'<li><span>LinkedIn Company</span></li>'
																	+'<li><span>News</span></li>'
																	+'<li><span>Other Location</span></li>'
																	+'<li><span>Sector</span></li>'
																	+'<li><span>Stock code</span></li>'
																	+'<li><span>Telephone</span></li>'
																	+'<li><span>Website</span></li>'
																	+'<li><span>Year founded</span></li>'
																	+'<li><span>Zipcode</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['AdditionalInformation']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Address']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['City']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Companyname']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Country']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Email']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Fax']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Industry']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Investor']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['LinkedIn']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['LinkedIn_Company']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['News']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['OtherLocation']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Sector']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Stockcode']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Telephone']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Website']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Yearfounded']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Zipcode']+'</span></li>'
																			
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="financial_info' +msg.Deal_Details[index].IncDealId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>File</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Financials Info'][0]['File']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="investor_info' +msg.Deal_Details[index].IncDealId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li class="empty-tab"><span>Angel investors</span></li>'
																	+'<li><span>PE/VC Investors</span></li>'
																	+'<li><span>Incubators</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll valuation-tab">'
																		+'<ul>'
																			+'<li ><span>'+msg.Deal_Details[index]['Investments']['Angel investors']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Investments']['PE/VC investors']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Investments']['incubators']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="more_info' +msg.Deal_Details[index].IncDealId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>More info</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['More Info'][0]['Moreinfo']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
														+'</div>'
													+'</div>'
												+'</td>'
											+'</tr>'
										);			
									
									});
									$("html, body").animate({ scrollTop: 0 }, "slow");

							}
							// Deals Exits Section Starts Here 
							// PEMA & VCMA
							else if((dealtype == 'EXITS' && dealcategory == 'PEMA') || (dealtype == 'EXITS' && dealcategory == 'VCMA')){
								$str = '<table id="response_data_table">'
									+'<thead>'
										+'<tr>'
											+'<th>Company Name</th>'
											+'<th>Details</th>'
										+'</tr>'
									+'</thead>'
										+'<tbody id="response_table">'
											
										+'</tbody>'
									+'</table>';
									$( '.result-tbl-wpr .no-results' ).hide();
									$( '.result-tbl-wpr' ).show();
									$( '.result-tbl-wpr' ).html( $str );
									
									$.each(msg.Deal_Details, function(index) {

										// Investor deal period groupby methods
										investorsName= msg.Deal_Details[index]['Investments']['PE/VC investors'];
										var resultArray =[];
										var names = "";
										var currentPeriod;
										var nextPeriod="";
										for(var i=0;i<investorsName.length;i++)
										{
											currentPeriod = investorsName[i]['Deal Period'].substring(4,8);
											var InvestorName = investorsName[i]['Investor Name']; 
											if(i<investorsName.length-1)
											{
												nextPeriod = investorsName[i+1]['Deal Period'].substring(4,8);
											}
											// console.log(currentPeriod+"zdfgsrd"+nextPeriod);
											if(currentPeriod==nextPeriod)
											{
												names = names + "," +InvestorName;
											}
											else{
												resultArray.push(currentPeriod +names + "," +InvestorName);
												names = "";
											}

										}
										if(nextPeriod != "")
											resultArray.push(currentPeriod +names);
										// End Investor deal period groupby methods
										// console.log(resultArray);
										$("#response_table").append('<tr>'
												+'<td>'+msg.Deal_Details[index].CompanyName+'</td>'
												+'<td><span class="showinfo-link info-link">Show details</span></td>'
											+'</tr>'
											+'<tr class="infoTR financialRow pecompanydetails" style="display: none;">'
												+'<td colspan="6" class="no-pd">'
													+'<div class="fin-wpr">'
														+'<ul class="nav nav-tabs">'
															+'<li><a data-toggle="tab" href="#company_info' +msg.Deal_Details[index].MandAId+ '">Company Info</a></li>'
															+'<li><a data-toggle="tab" href="#company_profile' +msg.Deal_Details[index].MandAId+ '">Company Profile</a></li>'
															+'<li><a data-toggle="tab" href="#deal_info' +msg.Deal_Details[index].MandAId+ '">Deal_Info</a></li>'
															+'<li><a data-toggle="tab" href="#exit_details' +msg.Deal_Details[index].MandAId+ '">Exit Details</a></li>'
															+'<li><a data-toggle="tab" href="#financial_info' +msg.Deal_Details[index].MandAId+ '">Financials Info</a></li>'
															+'<li><a data-toggle="tab" href="#investor_info' +msg.Deal_Details[index].MandAId+ '">Investor Info</a></li>'
															+'<li><a data-toggle="tab" href="#investor_advisor_info' +msg.Deal_Details[index].MandAId+ '">Investor and Advisor Info</a></li>'
														+'</ul>'
														+'<div class="tab-content tbl-cnt">'
															+'<div id="company_info' +msg.Deal_Details[index].MandAId+ '" class="tab-pane fade active in">'
																+'<ul class="fix-ul">'
																	+'<li><span>Company name</span></li>'
																	+'<li><span>Industry</span></li>'
																	+'<li><span>Sector</span></li>'
																	+'<li><span>Website</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['companyname']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['industry']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['sector']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['website']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="company_profile' +msg.Deal_Details[index].MandAId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Additional Information</span></li>'
																	+'<li><span>Address</span></li>'
																	+'<li><span>City</span></li>'
																	+'<li><span>Company name</span></li>'
																	+'<li><span>Country</span></li>'
																	+'<li><span>Email</span></li>'
																	+'<li><span>Fax</span></li>'
																	+'<li><span>Industry</span></li>'
																	+'<li><span>Investor</span></li>'
																	+'<li><span>LinkedIn</span></li>'
																	+'<li><span>LinkedIn Company</span></li>'
																	+'<li><span>News</span></li>'
																	+'<li><span>Other Location</span></li>'
																	+'<li><span>Sector</span></li>'
																	+'<li><span>Stock code</span></li>'
																	+'<li><span>Telephone</span></li>'
																	+'<li><span>Website</span></li>'
																	+'<li><span>Year founded</span></li>'
																	+'<li><span>Zipcode</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['AdditionalInformation']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Address']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['City']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Companyname']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Country']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Email']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Fax']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Industry']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Investor']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['LinkedIn']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['LinkedIn_Company']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['News']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['OtherLocation']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Sector']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Stockcode']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Telephone']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Website']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Yearfounded']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Profile'][0]['Zipcode']+'</span></li>'
																			
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="deal_info' +msg.Deal_Details[index].MandAId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Acquirer</span></li>'
																	+'<li><span>Date</span></li>'
																	+'<li><span>Deal Size</span></li>'
																	+'<li><span>Deal Type</span></li>'
																	+'<li><span>Exit status</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['Acquirer']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['Date']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['Deal Size']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['DealType']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['Exitstatus']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="exit_details' +msg.Deal_Details[index].MandAId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Company Valuation</span></li>'
																	+'<li><span>EBITDA</span></li>'
																	+'<li><span>EBITDA Multiple</span></li>'
																	+'<li><span>PAT</span></li>'
																	+'<li><span>PAT Multiple</span></li>'
																	+'<li><span>Revenue</span></li>'
																	+'<li><span>Revenue Multiple</span></li>'
																	+'<li><span>Valuation</span></li>'
																	+'<li><span>Book value per share</span></li>'
																	+'<li><span>Price per share</span></li>'
																	+'<li><span>Price to book</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['Company Valuation - Equity - Post Money (INR Cr)']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['EBITDA']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['EBITDA Multiple (based on Equity Value)']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['PAT']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['PAT Multiple (based on Equity Value)']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['Revenue']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['Revenue Multiple (based on Equity Value / Market Cap)']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['Valuation']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['book_value_per_share']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['price_per_share']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['price_to_book']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="financial_info' +msg.Deal_Details[index].MandAId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>File</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul style="width: 6%;">'
																			+'<li><span>'+msg.Deal_Details[index]['Financials Info'][0]['file']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="investor_info' +msg.Deal_Details[index].MandAId+ '" class="tab-pane fade">'
															
																+'<ul class="fix-ul" id="DealPeriod'+msg.Deal_Details[index].MandAId+'">'
																+'<li style="padding:8px;"> Deal Period</li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll valuation-tab">'
																		+'<ul id="InvestorName'+msg.Deal_Details[index].MandAId+'">'
																		+'<li style="padding: 5px;margin: 5px;text-align: left;width:auto;">Investor Name </li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="investor_advisor_info' +msg.Deal_Details[index].MandAId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Advisor Buyer</span></li>'
																	+'<li><span>Advisor Seller</span></li>'
																	+'<li><span>Type</span></li>'
																	+'<li><span>Investor</span></li>'
																	+'<li><span>Investment Details</span></li>'
																	+'<li><span>More Details</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul style="width: 6%;">'
																			+'<li><span>'+msg.Deal_Details[index]['Investor and Advisor Info'][0]['Advisor Buyer']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Investor and Advisor Info'][0]['Advisor Seller']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Investor and Advisor Info'][0]['Type']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Investor and Advisor Info'][0]['investor']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Investor and Advisor Info'][1]['Investment Details']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Investor and Advisor Info'][0]['More Details']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
														+'</div>'
													+'</div>'
												+'</td>'
											+'</tr>'
										);
										// Dynamic Values Appending place for Investor Info
										// Investor Info -> Investor Name
											var InvestorName = "";
											if(resultArray.length != 0){
												for(var i=0;i<resultArray.length;i++)
												{
													InvestorName = "<li style='padding: 5px;margin: 5px;text-align: left;width:auto;'>"+resultArray[i].substring(5)+"</li>";
													// console.log(InvestorName);
													$("#InvestorName"+msg.Deal_Details[index].MandAId).append(InvestorName);
												}
											}else{
												InvestorName ="<li>--</li>";
												$("#InvestorName"+msg.Deal_Details[index].MandAId).append(InvestorName);

											}
											
											// Investor Info -> Deal Period
											var DealPeriod = "";
											if(resultArray.length != 0){
												for(var i=0;i<resultArray.length;i++)
												{
													DealPeriod = "<li style='padding: 8px;'>"+resultArray[i].substring(0, 4)+"</li>";
													// console.log(DealPeriod);
													$("#DealPeriod"+msg.Deal_Details[index].MandAId).append(DealPeriod);
												}
											}else{
												DealPeriod ="<li>--</li>";
												$("#DealPeriod"+msg.Deal_Details[index].MandAId).append(DealPeriod);

											}
										// End  Dynamic Values Appending place for Investor Info
										
									});
									$("html, body").animate({ scrollTop: 0 }, "slow");

							}
							// PEPM & VCPM
							else if((dealtype == 'EXITS' && dealcategory == 'PEPM') || (dealtype == 'EXITS' && dealcategory == 'VCPM')){
								$str = '<table id="response_data_table">'
									+'<thead>'
										+'<tr>'
											+'<th>Company Name</th>'
											+'<th>Details</th>'
										+'</tr>'
									+'</thead>'
										+'<tbody id="response_table">'
											
										+'</tbody>'
									+'</table>';
									$( '.result-tbl-wpr .no-results' ).hide();
									$( '.result-tbl-wpr' ).show();
									$( '.result-tbl-wpr' ).html( $str );
									
									$.each(msg.Deal_Details, function(index) {

										// Investor deal period groupby methods
										investorsName= msg.Deal_Details[index]['Investments']['PE/VC investors'];
										var resultArray =[];
										var names = "";
										var currentPeriod;
										var nextPeriod="";
										for(var i=0;i<investorsName.length;i++)
										{
											currentPeriod = investorsName[i]['Deal Period'].substring(4,8);
											var InvestorName = investorsName[i]['Investor Name']; 
											if(i<investorsName.length-1)
											{
												nextPeriod = investorsName[i+1]['Deal Period'].substring(4,8);
											}
											// console.log(currentPeriod+"zdfgsrd"+nextPeriod);
											if(currentPeriod==nextPeriod)
											{
												names = names + "," +InvestorName;
											}
											else{
												resultArray.push(currentPeriod +names + "," +InvestorName);
												names = "";
											}

										}
										if(nextPeriod != "")
											resultArray.push(currentPeriod +names);
										// End Investor deal period groupby methods
										// console.log(resultArray);
										$("#response_table").append('<tr>'
												+'<td>'+msg.Deal_Details[index].CompanyName+'</td>'
												+'<td><span class="showinfo-link info-link">Show details</span></td>'
											+'</tr>'
											+'<tr class="infoTR financialRow pecompanydetails" style="display: none;">'
												+'<td colspan="6" class="no-pd">'
													+'<div class="fin-wpr">'
														+'<ul class="nav nav-tabs">'
															+'<li><a data-toggle="tab" href="#company_info' +msg.Deal_Details[index].MandAId+ '">Company Info</a></li>'
															+'<li><a data-toggle="tab" href="#company_profile' +msg.Deal_Details[index].MandAId+ '">Company Profile</a></li>'
															+'<li><a data-toggle="tab" href="#deal_info' +msg.Deal_Details[index].MandAId+ '">Deal_Info</a></li>'
															+'<li><a data-toggle="tab" href="#exit_details' +msg.Deal_Details[index].MandAId+ '">Exit Details</a></li>'
															+'<li><a data-toggle="tab" href="#financial_info' +msg.Deal_Details[index].MandAId+ '">Financials Info</a></li>'
															+'<li><a data-toggle="tab" href="#investor_info' +msg.Deal_Details[index].MandAId+ '">Investor Info</a></li>'
															+'<li><a data-toggle="tab" href="#investor_advisor_info' +msg.Deal_Details[index].MandAId+ '">Investor and Advisor Info</a></li>'
														+'</ul>'
														+'<div class="tab-content tbl-cnt">'
															+'<div id="company_info' +msg.Deal_Details[index].MandAId+ '" class="tab-pane fade active in">'
																+'<ul class="fix-ul">'
																	+'<li><span>Company name</span></li>'
																	+'<li><span>Industry</span></li>'
																	+'<li><span>Sector</span></li>'
																	+'<li><span>Website</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['companyname']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['industry']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['sector']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['website']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="company_profile' +msg.Deal_Details[index].MandAId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Additional Information</span></li>'
																	+'<li><span>Address</span></li>'
																	+'<li><span>City</span></li>'
																	+'<li><span>Company name</span></li>'
																	+'<li><span>Country</span></li>'
																	+'<li><span>Email</span></li>'
																	+'<li><span>Fax</span></li>'
																	+'<li><span>Industry</span></li>'
																	+'<li><span>Investor</span></li>'
																	+'<li><span>LinkedIn</span></li>'
																	+'<li><span>LinkedIn Company</span></li>'
																	+'<li><span>News</span></li>'
																	+'<li><span>Other Location</span></li>'
																	+'<li><span>Sector</span></li>'
																	+'<li><span>Stock code</span></li>'
																	+'<li><span>Telephone</span></li>'
																	+'<li><span>Website</span></li>'
																	+'<li><span>Year founded</span></li>'
																	+'<li><span>Zipcode</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['AdditionalInformation']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Address']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['City']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Companyname']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Country']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Email']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Fax']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Industry']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Investor']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['LinkedIn']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['LinkedIn_Company']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['News']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['OtherLocation']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Sector']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Stockcode']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Telephone']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Website']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Yearfounded']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Zipcode']+'</span></li>'
																			
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="deal_info' +msg.Deal_Details[index].MandAId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Acquirer</span></li>'
																	+'<li><span>Date</span></li>'
																	+'<li><span>Deal Size</span></li>'
																	+'<li><span>Deal Type</span></li>'
																	+'<li><span>Exit status</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['Acquirer']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['Date']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['Deal Size']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['DealType']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['Exitstatus']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="exit_details' +msg.Deal_Details[index].MandAId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Company Valuation</span></li>'
																	+'<li><span>EBITDA</span></li>'
																	+'<li><span>EBITDA Multiple</span></li>'
																	+'<li><span>PAT</span></li>'
																	+'<li><span>PAT Multiple</span></li>'
																	+'<li><span>Revenue</span></li>'
																	+'<li><span>Revenue Multiple</span></li>'
																	+'<li><span>Valuation</span></li>'
																	+'<li><span>Book value per share</span></li>'
																	+'<li><span>Price per share</span></li>'
																	+'<li><span>Price to book</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['Company Valuation - Equity - Post Money (INR Cr)']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['EBITDA']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['EBITDA Multiple (based on Equity Value)']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['PAT']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['PAT Multiple (based on Equity Value)']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['Revenue']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['Revenue Multiple (based on Equity Value / Market Cap)']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['Valuation']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['book_value_per_share']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['price_per_share']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Exit Details'][0]['price_to_book']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="financial_info' +msg.Deal_Details[index].MandAId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>File</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Financials Info'][0]['file']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="investor_info' +msg.Deal_Details[index].MandAId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul" id="DealPeriod'+msg.Deal_Details[index].MandAId+'">'
																+'<li style="padding:8px;"> Deal Period</li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll valuation-tab">'
																		+'<ul id="InvestorName'+msg.Deal_Details[index].MandAId+'">'
																		+'<li style="padding: 5px;margin: 5px;text-align: left;width:auto;">Investor Name </li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="investor_advisor_info' +msg.Deal_Details[index].MandAId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Type</span></li>'
																	+'<li><span>Investor</span></li>'
																	+'<li><span>Investment Details</span></li>'
																	+'<li><span>More Details</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Investor and Advisor Info'][0]['Type']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Investor and Advisor Info'][0]['investor']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Investor and Advisor Info'][1]['Investment Details']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Investor and Advisor Info'][0]['More Details']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
														+'</div>'
													+'</div>'
												+'</td>'
											+'</tr>'
										);			
										// Dynamic Values Appending place for Investor Info
										// Investor Info -> Investor Name
										var InvestorName = "";
											if(resultArray.length != 0){
												for(var i=0;i<resultArray.length;i++)
												{
													InvestorName = "<li style='padding: 5px;margin: 5px;text-align: left;width:auto;'>"+resultArray[i].substring(5)+"</li>";
													// console.log(InvestorName);
													$("#InvestorName"+msg.Deal_Details[index].MandAId).append(InvestorName);
												}
											}else{
												InvestorName ="<li>--</li>";
												$("#InvestorName"+msg.Deal_Details[index].MandAId).append(InvestorName);

											}
											
											// Investor Info -> Deal Period
											var DealPeriod = "";
											if(resultArray.length != 0){
												for(var i=0;i<resultArray.length;i++)
												{
													DealPeriod = "<li style='padding: 8px;'>"+resultArray[i].substring(0, 4)+"</li>";
													// console.log(DealPeriod);
													$("#DealPeriod"+msg.Deal_Details[index].MandAId).append(DealPeriod);
												}
											}else{
												DealPeriod ="<li>--</li>";
												$("#DealPeriod"+msg.Deal_Details[index].MandAId).append(DealPeriod);

											}
										// End  Dynamic Values Appending place for Investor Info
									});
									$("html, body").animate({ scrollTop: 0 }, "slow");
							}
							// PEIPO & VCIPO
							else if((dealtype == 'EXITS' && dealcategory == 'PEIPO') || (dealtype == 'EXITS' && dealcategory == 'VCIPO')){
								$str = '<table id="response_data_table">'
									+'<thead>'
										+'<tr>'
											+'<th>Company Name</th>'
											+'<th>Details</th>'
										+'</tr>'
									+'</thead>'
										+'<tbody id="response_table">'
											
										+'</tbody>'
									+'</table>';
									$( '.result-tbl-wpr .no-results' ).hide();
									$( '.result-tbl-wpr' ).show();
									$( '.result-tbl-wpr' ).html( $str );
									
									$.each(msg.Deal_Details, function(index) {

										// Investor deal period groupby methods
										investorsName= msg.Deal_Details[index]['Investments']['PE/VC investors'];
										var resultArray =[];
										var names = "";
										var currentPeriod;
										var nextPeriod="";
										for(var i=0;i<investorsName.length;i++)
										{
											currentPeriod = investorsName[i]['Deal Period'].substring(4,8);
											var InvestorName = investorsName[i]['Investor Name']; 
											if(i<investorsName.length-1)
											{
												nextPeriod = investorsName[i+1]['Deal Period'].substring(4,8);
											}
											// console.log(currentPeriod+"zdfgsrd"+nextPeriod);
											if(currentPeriod==nextPeriod)
											{
												names = names + "," +InvestorName;
											}
											else{
												resultArray.push(currentPeriod +names + "," +InvestorName);
												names = "";
											}

										}
										if(nextPeriod != "")
											resultArray.push(currentPeriod +names);
										// End Investor deal period groupby methods
										// console.log(resultArray);

										$("#response_table").append('<tr>'
												+'<td>'+msg.Deal_Details[index].companyname+'</td>'
												+'<td><span class="showinfo-link info-link">Show details</span></td>'
											+'</tr>'
											+'<tr class="infoTR financialRow pecompanydetails" style="display: none;">'
												+'<td colspan="6" class="no-pd">'
													+'<div class="fin-wpr">'
														+'<ul class="nav nav-tabs">'
															+'<li><a data-toggle="tab" href="#company_info' +msg.Deal_Details[index].IPOId+ '">Company Info</a></li>'
															+'<li><a data-toggle="tab" href="#company_profile' +msg.Deal_Details[index].IPOId+ '">Company Profile</a></li>'
															+'<li><a data-toggle="tab" href="#deal_info' +msg.Deal_Details[index].IPOId+ '">Deal_Info</a></li>'
															+'<li><a data-toggle="tab" href="#financial_info' +msg.Deal_Details[index].IPOId+ '">Financials Info</a></li>'
															+'<li><a data-toggle="tab" href="#investment_details' +msg.Deal_Details[index].IPOId+ '">Investment details</a></li>'
															+'<li><a data-toggle="tab" href="#investments' +msg.Deal_Details[index].IPOId+ '">Investments</a></li>'
															+'<li><a data-toggle="tab" href="#investor_info' +msg.Deal_Details[index].IPOId+ '">Investor Info</a></li>'
															+'<li><a data-toggle="tab" href="#more_details' +msg.Deal_Details[index].IPOId+ '">More Info</a></li>'
															// +'<li><a data-toggle="tab" href="#return_info' +msg.Deal_Details[index].IPOId+ '">Return Info</a></li>'
														+'</ul>'
														+'<div class="tab-content tbl-cnt">'
															+'<div id="company_info' +msg.Deal_Details[index].IPOId+ '" class="tab-pane fade active in">'
																+'<ul class="fix-ul">'
																	+'<li><span>Company name</span></li>'
																	+'<li><span>Industry</span></li>'
																	+'<li><span>Sector</span></li>'
																	+'<li><span>Website</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['company']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['industry']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['sector']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Company Info'][0]['website']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="company_profile' +msg.Deal_Details[index].IPOId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Additional Information</span></li>'
																	+'<li><span>Address</span></li>'
																	+'<li><span>City</span></li>'
																	+'<li><span>Company name</span></li>'
																	+'<li><span>Country</span></li>'
																	+'<li><span>Email</span></li>'
																	+'<li><span>Fax</span></li>'
																	+'<li><span>Industry</span></li>'
																	+'<li><span>Investor</span></li>'
																	+'<li><span>LinkedIn</span></li>'
																	+'<li><span>LinkedIn Company</span></li>'
																	+'<li><span>News</span></li>'
																	+'<li><span>Other Location</span></li>'
																	+'<li><span>Sector</span></li>'
																	+'<li><span>Stock code</span></li>'
																	+'<li><span>Telephone</span></li>'
																	+'<li><span>Website</span></li>'
																	+'<li><span>Year founded</span></li>'
																	+'<li><span>Zipcode</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['AdditionalInformation']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Address']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['City']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Companyname']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Country']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Email']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Fax']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Industry']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Investor']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['LinkedIn']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['LinkedIn_Company']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['News']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['OtherLocation']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Sector']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Stockcode']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Telephone']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Website']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Yearfounded']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Company Profile'][0]['Zipcode']+'</span></li>'
																			
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="deal_info' +msg.Deal_Details[index].IPOId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Deal Period</span></li>'
																	+'<li><span>Exitstatus</span></li>'
																	+'<li><span>IPO Price</span></li>'
																	+'<li><span>IPO Size (US $M)</span></li>'
																	+'<li><span>IPO Valuation</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['Deal Period']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['Exitstatus']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['IPO Price']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['IPO Size (US $M)']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Deal_Info'][0]['IPO Valuation']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="financial_info' +msg.Deal_Details[index].IPOId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Company Valuation</span></li>'
																	+'<li><span>EBITDA</span></li>'
																	+'<li><span>EBITDA Multiple</span></li>'
																	+'<li><span>PAT</span></li>'
																	+'<li><span>PAT Multiple</span></li>'
																	+'<li><span>Revenue</span></li>'
																	+'<li><span>Revenue Multiple</span></li>'
																	+'<li><span>Valuation</span></li>'
																	+'<li><span>Book value per share</span></li>'
																	+'<li><span>File</span></li>'
																	+'<li><span>Price per share</span></li>'
																	+'<li><span>Price to book</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li><span>'+msg.Deal_Details[index]['Financial Info'][0]['Company Valuation - Equity - Post Money (INR Cr)']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financial Info'][0]['EBITDA']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financial Info'][0]['EBITDA Multiple (based on Equity Value)']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financial Info'][0]['PAT']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financial Info'][0]['PAT Multiple (based on Equity Value)']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financial Info'][0]['Revenue']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financial Info'][0]['Revenue Multiple (based on Equity Value / Market Cap)']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financial Info'][0]['Valuation']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financial Info'][0]['book_value_per_share']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financial Info'][0]['file']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financial Info'][0]['price_per_share']+'</span></li>'
																			+'<li><span>'+msg.Deal_Details[index]['Financial Info'][0]['price_to_book']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="investment_details' +msg.Deal_Details[index].IPOId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Investment deals</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li style="width: 30%;"><span>'+msg.Deal_Details[index]['Investment Details'][0]['Investmentdeals']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="investments' +msg.Deal_Details[index].IPOId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul" id="DealPeriod'+msg.Deal_Details[index].IPOId+'">'
																+'<li style="padding:8px;"> Deal Period</li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll valuation-tab">'
																		+'<ul id="InvestorName'+msg.Deal_Details[index].IPOId+'">'
																		+'<li style="padding: 5px;margin: 5px;text-align: left;width:auto;">Investor Name </li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="investor_info' +msg.Deal_Details[index].IPOId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li><span>Investor</span></li>'
																	+'<li><span>Investor Type</span></li>'
																	+'<li><span>Link</span></li>'
																	+'<li><span>Investor sale display</span></li>'
																	+'<li><span>Selling investors value</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll">'
																		+'<ul>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Investor Info'][0]['Investor']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Investor Info'][0]['InvestorType']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Investor Info'][0]['Link']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Investor Info'][0]['investor_sale_display']+'</span></li>'
																			+'<li class="moreinfodetails"><span>'+msg.Deal_Details[index]['Investor Info'][0]['selling_investors_value']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															+'<div id="more_details' +msg.Deal_Details[index].IPOId+ '" class="tab-pane fade">'
																+'<ul class="fix-ul">'
																	+'<li class="empty-tab"><span>More info</span></li>'
																+'</ul>'
																+'<div class="tab-cont-sec">'
																	+'<div class="tab-scroll valuation-tab">'
																		+'<ul>'
																			+'<li class="moreinfodetails"><span style="width: 100%;">'+msg.Deal_Details[index]['More Details(Overall IPO)'][0]['moreinfor']+'</span></li>'
																		+'</ul>'
																	+'</div>'
																+'</div>'
															+'</div>'
															// +'<div id="return_info' +msg.Deal_Details[index].IPOId+ '" class="tab-pane fade">'
															// 	+'<ul class="fix-ul">'
															// 		+'<li class="empty-tab"><span>Pranion</span></li>'
															// 	+'</ul>'
															// 	+'<div class="tab-cont-sec">'
															// 		+'<div class="tab-scroll valuation-tab">'
															// 			+'<ul>'
															// 				+'<li class="moreinfodetails"><span>Work INProgress</span></li>'
															// 			+'</ul>'
															// 		+'</div>'
															// 	+'</div>'
															// +'</div>'
														+'</div>'
													+'</div>'
												+'</td>'
											+'</tr>'
										);			
										// Dynamic Values Appending place for Investor Info
										// Investor Info -> Investor Name
										var InvestorName = "";
											if(resultArray.length != 0){
												for(var i=0;i<resultArray.length;i++)
												{
													InvestorName = "<li style='padding: 5px;margin: 5px;text-align: left;width:auto;'>"+resultArray[i].substring(5)+"</li>";
													// console.log(InvestorName);
													$("#InvestorName"+msg.Deal_Details[index].IPOId).append(InvestorName);
												}
											}else{
												InvestorName ="<li>--</li>";
												$("#InvestorName"+msg.Deal_Details[index].IPOId).append(InvestorName);

											}
											
											// Investor Info -> Deal Period
											var DealPeriod = "";
											if(resultArray.length != 0){
												for(var i=0;i<resultArray.length;i++)
												{
													DealPeriod = "<li style='padding: 8px;'>"+resultArray[i].substring(0, 4)+"</li>";
													// console.log(DealPeriod);
													$("#DealPeriod"+msg.Deal_Details[index].IPOId).append(DealPeriod);
												}
											}else{
												DealPeriod ="<li>--</li>";
												$("#DealPeriod"+msg.Deal_Details[index].IPOId).append(DealPeriod);

											}
										// End  Dynamic Values Appending place for Investor Info
									});
									$("html, body").animate({ scrollTop: 0 }, "slow");
							}else{
								//alert('No table');
								$("#response_data_table").hide();
								$("html, body").animate({ scrollTop: 0 }, "slow");
							}
						}
						// Directory Section Starts Here
						else if ( dirCategory == 'directory'){
							// alert(dealcategory);
							if((dirCategoryType == "company" || dirCategoryType == "investor") || (dealcategory == 'ANGEL' &&  dirCategoryType == 'investor')){
								if(dealcategory == 'PE' || dealcategory == 'VC' || dealcategory == 'SOCIAL' || dealcategory == 'CLEANTECH' || dealcategory == 'INFRASTRUCTURE' || (dealcategory == 'ANGEL' &&  dirCategoryType == 'investor') ||
								dealcategory == 'PEMA' || dealcategory == 'PEPM' || dealcategory == 'PEIPO' || dealcategory == 'VCMA' || dealcategory == 'VCPM' || dealcategory == 'VCIPO') 
								{ 
									//alert(dirCategoryType);
									$str = '<table id="response_directory_table">'
												+'<thead>'
													+'<tr>';
														if(dirCategoryType == "company"){
															$str += '<th>Company Name</th>';
														} else if(dirCategoryType == "investor"){
															$str += '<th>Investor Name</th>';
														}
														$str += '<th>Details</th>'
													+'</tr>'
												+'</thead>'
												+'<tbody id="response_directory_table_body">';
												$( '.result-tbl-wpr .no-results' ).hide();
												$( '.result-tbl-wpr' ).show();
												$( '.result-tbl-wpr' ).html( $str );
												if(msg['Directory']['Investor info']){
													var location = msg['Directory']['Investor info'];
													var responsive_id = msg['Directory']['Investor info']
												}
												if(msg['Directory']['InvestorInfo']){
													var location = msg['Directory']['InvestorInfo'];
												}
												$.each(location, function(index) {
													var str_dir = '<tr class="companyList">';
														if(dirCategoryType == "company"){
															var responsive_id = location[index]['CompanyId']; 
															str_dir += '<td>'+location[index]["Company Name"]+'</td>';
														} else if(dirCategoryType == "investor"){
															var responsive_id = location[index]['InvestorId']; 
															str_dir += '<td>'+location[index]['Investor Name']+'</td>';
														}
                            							str_dir += '<td><span class="showinfo-link info-link">Show details</span></td>';
													str_dir += '</tr>';
													str_dir += '<tr class="infoTR financialRow pecompanydetails" style="display:none">'
                                        							+'<td colspan="6" class="no-pd">'
                                        								+'<div class="fin-wpr">'
                                            								+'<ul class="nav nav-tabs">';
                                            									if(dirCategoryType == "company"){
																					str_dir += '<li class="active"><a data-toggle="tab" href="#company_info'+responsive_id+'">Company Profile</a></li>';
                                            									}else if(dirCategoryType == "investor"){
                                                									str_dir += '<li class="active"><a data-toggle="tab" href="#company_info'+responsive_id+'">Investor Profile</a></li>';
                                                									str_dir += '<li><a data-toggle="tab" href="#more_info'+responsive_id+'">More Info</a></li>';
                                            									}
                            										str_dir +='</ul>';
																	str_dir +='<div class="tab-content tbl-cnt">'
                                        										+'<div id="company_info'+responsive_id+'" class="tab-pane fade active in">'
																					+'<ul class="fix-ul">';
																						if(dirCategoryType == "company"){
																							str_dir += '<li><span>Company Name</span></li>';
																						} else if(dirCategoryType == "investor"){
																							str_dir += '<li><span>Investor Name</span></li>';
																						}
																						str_dir += '<li><span>Address</span></li>'
																								+'<li><span>City</span></li>'
																								+'<li><span>Country</span></li>'
																								+'<li><span>Zip</span></li>'
																								+'<li><span>Telephone</span></li>';
																								if(dirCategoryType == "investor"){
																									str_dir += '<li><span>Management</span></li>';
																								}
																						str_dir += '<li><span>Email</span></li>'
																								+'<li><span>In India Since</span></li>'
																								+'<li><span>Website</span></li>'
																					+'</ul>'
																					+'<div class="tab-cont-sec">'
																						+'<div class="tab-scroll">'
																							+'<ul>';
																								if(dirCategoryType == "company"){
																									str_dir += '<li class="moreinfodetails"><span>'+location[index]["Company Name"]+'</span></li>';
																								} else if(dirCategoryType == "investor"){
																									str_dir += '<li class="moreinfodetails"><span>'+ location[index]['Investor Name'] +'</span></li>';
																								}
																								str_dir += '<li class="moreinfodetails"><span>'+ location[index]['Investor']['Address'] +'</span></li>';
																								if(dirCategoryType == "company"){
																									str_dir += '<li class="moreinfodetails"><span>'+ location[index]['Investor']['City'] +'</span></li>';
																								} else if(dirCategoryType == "investor"){
																									str_dir += '<li class="moreinfodetails"><span>'+ location[index]['Investor']['City'] +'</span></li>';
																								}
																								str_dir += '<li class="moreinfodetails"><span>'+ location[index]['Investor']['Country'] +'</span></li>'
																											+'<li class="moreinfodetails"><span>'+ location[index]['Investor']['Zip'] +'</span></li>'
																											+'<li class="moreinfodetails"><span>'+ location[index]['Investor']['Telephone'] +'</span></li>';
																								if(dirCategoryType == "investor"){
																									str_dir += '<li class="moreinfodetails"><span>'+ location[index]['Investor']['Management'] +'</span></li>';
																								}	
																								str_dir+= '<li class="moreinfodetails"><span>'+ location[index]['Investor']['Email'] +'</span></li>'
																											+'<li class="moreinfodetails"><span>'+ location[index]['Investor']['Since'] +'</span></li>'
																											+'<li class="moreinfodetails"><span>'+ location[index]['Investor']['Website'] +'</span></li>'
																							+'</ul>'
																						+'</div>'
																					+'</div>'
																				+'</div>';
																				if(dirCategoryType == "investor"){

																				str_dir+= '<div id="more_info'+responsive_id+'" class="tab-pane fade">'
																					+'<ul class="fix-ul">'
																						+'<li><span>Firm Type</span></li>'
																						+'<li class=""><span >Focus & Capital Source</span></li>'
																						+'<li class=""><span >Stage Of Funding</span></li>'
																						+'<li class=""><span >No Of Funds</span></li>'
																						+'<li class=""><span >Limited partners</span></li>'
																						+'<li class=""><span >Industry (Existing Investments)</span></li>'
																						+'<li class=""><span >Assets Under Management (US$M)</span></li>'
																						+'<li class=""><span >Already Invested (US$ Million)</span></li>'
																						+'<li class=""><span >Dry Powder (US$ Million)</span></li>'
																						+'<li class=""><span >Other Location</span></li>'
																						+'<li class=""><span >Descrption</span></li>'
																					+'</ul>'
																					+'<div class="tab-cont-sec">'
																						+'<div class="tab-scroll">'
																							+'<ul>'
																								+'<li class="moreinfodetails"><span >'+ location[index]['MoreInfo']['FirmType'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ location[index]['MoreInfo']['Focus & Capital Source'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ location[index]['MoreInfo']['Stage Of Funding'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ location[index]['MoreInfo']['No Of Funds'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ location[index]['MoreInfo']['Limited Partners'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ location[index]['MoreInfo']['Industry (Existing Investments)'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ location[index]['MoreInfo']['Assets Under Management'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ location[index]['MoreInfo']['Already Invested'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ location[index]['MoreInfo']['Drypowder'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ location[index]['MoreInfo']['Other Location'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ location[index]['MoreInfo']['Description'] +'</span></li>'
																							+'</ul>'
																						+'</div>'
																					+'</div>'
																				+'</div>';
																				}
																			str_dir+='</div>'
																		+'</div>'
																	+'</td>'
																+'</tr>';
															$( '#response_directory_table_body' ).append( str_dir );
												});
								}
							}
							// Angel Fun
							else if((dealcategory == 'ANGEL' &&  dirCategoryType == 'fundedComp') || (dealcategory == 'ANGEL' &&  dirCategoryType == 'fundraisingComp')){
									$str = '<table id="response_directory_table">'
												+'<thead>'
													+'<tr>'
														+'<th>Company Name</th>'
														+'<th>Details</th>'
													+'</tr>'
												+'</thead>'
												+'<tbody id="response_directory_angel_fun_table_body">';
												$( '.result-tbl-wpr .no-results' ).hide();
												$( '.result-tbl-wpr' ).show();
												$( '.result-tbl-wpr' ).html( $str );
												
												$.each(msg['Directory'], function(index) {
													
													if(msg['Directory'][index]['Funded Companies']){
														
														var location = msg['Directory'][index]['Funded Companies'];
													}
													if(msg['Directory'][index]['Fundraising Companies']){
														var location = msg['Directory'][index]['Fundraising Companies'];
													}
													
													var str_dir = '<tr class="companyList">'
																	+'<td>'+location["Company Name"]+'</td>'
																	+'<td><span class="showinfo-link info-link">Show details</span></td>'
																+'</tr>'
																+'<tr class="infoTR financialRow pecompanydetails" style="display:none">'
                                        							+'<td colspan="6" class="no-pd">'
                                        								+'<div class="fin-wpr">'
                                            								+'<ul class="nav nav-tabs">'
																				+'<li class="active"><a data-toggle="tab" href="#company_info">Company Profile</a></li>'
                                            								+'</ul>'
																			+'<div class="tab-content tbl-cnt">'
                                        										+'<div id="company_info" class="tab-pane fade active in">'
																					+'<ul class="fix-ul">'
																						+'<li><span>Company Name</span></li>'
																					+'</ul>'
																					+'<div class="tab-cont-sec">'
																						+'<div class="tab-scroll">'
																							+'<ul>'
																								+'<li class="moreinfodetails"><span>'+location["Company Name"]+'</span></li>'
																							+'</ul>'
																						+'</div>'
																					+'</div>'
																				+'</div>'
																			+'</div>'
																		+'</div>'
																	+'</td>'
																+'</tr>';
															$( '#response_directory_angel_fun_table_body' ).append( str_dir );
												});
								}
							// END Angel Fun
							// PE Legal
							else if(dirCategoryType == "legalAdvisor" || dirCategoryType == "transactionAdvisor"){
								if(dealcategory == 'PE' || dealcategory == 'VC' || dealcategory == 'SOCIAL' || dealcategory == 'CLEANTECH' || dealcategory == 'INFRASTRUCTURE' || dealcategory == 'ANGEL' ||
								dealcategory == 'PEMA' || dealcategory == 'PEPM' || dealcategory == 'PEIPO' || dealcategory == 'VCMA' || dealcategory == 'VCPM' || dealcategory == 'VCIPO') 
								{ 
									//alert(dirCategoryType);
									$str = '<table id="response_directory_table">'
												+'<thead>'
													+'<tr>'
														+'<th>Advisor Profile</th>'
														+'<th>Details</th>'
													+'</tr>'
												+'</thead>'
												+'<tbody id="response_directory_angel_table_body">';
												$( '.result-tbl-wpr .no-results' ).hide();
												$( '.result-tbl-wpr' ).show();
												$( '.result-tbl-wpr' ).html( $str );
												
												$.each(msg['Directory'], function(index) {
													var str_dir = '<tr class="companyList">'
																	+'<td>'+msg['Directory'][index]["Advisor Profile"]["Advisor Name"]+'</td>'
                            										+'<td><span class="showinfo-link info-link">Show details</span></td>'
																+'</tr>'
																+'<tr class="infoTR financialRow pecompanydetails" style="display:none">'
                                        							+'<td colspan="6" class="no-pd">'
                                        								+'<div class="fin-wpr">'
                                            								+'<ul class="nav nav-tabs">'
                                            									+'<li class="active"><a data-toggle="tab" href="#company_info">Advisor Name</a></li>'
                                            								+'</ul>'
																			+'<div class="tab-content tbl-cnt">'
                                        										+'<div id="company_info" class="tab-pane fade active in">'
																					+'<ul class="fix-ul">'
																						+ '<li><span>Advisor Name</span></li>'
																						+'<li><span>Advisor Type</span></li>'
																						+'<li><span>Address</span></li>'
																						+'<li><span>City</span></li>'
																						+'<li><span>Country</span></li>'
																						+'<li><span>Phone Number</span></li>'
																						+'<li><span>Website</span></li>'
																						+'<li><span>Contact Person</span></li>'
																						+'<li><span>Designation</span></li>'
																						+'<li><span>Email ID</span></li>'
																					+'</ul>'
																					+'<div class="tab-cont-sec">'
																						+'<div class="tab-scroll">'
																							+'<ul>'
																								+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['Advisor Profile']["Advisor Name"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['Advisor Profile']["Advisor Type"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['Advisor Profile']["Address"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['Advisor Profile']["City"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['Advisor Profile']["Country"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['Advisor Profile']["Phone Number"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['Advisor Profile']["Website"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['Advisor Profile']["Contact Person"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['Advisor Profile']["Designation"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['Advisor Profile']["Email"]+'</span></li>'
																								
																							+'</ul>'
																						+'</div>'
																					+'</div>'
																				+'</div>'
																			+'</div>'
																		+'</div>'
																	+'</td>'
																+'</tr>';
															$( '#response_directory_angel_table_body' ).append( str_dir );
												});
								}
							}
							// End PE Legal
							// Incubation
							else if((dealcategory == "INCUBATION" && dirCategoryType == "incubator") || (dealcategory == "INCUBATION" && dirCategoryType == "incubatee")){
								
								//alert(dirCategoryType);
								$str = '<table id="response_directory_table">'
											+'<thead>'
												+'<tr>';
												if(dirCategoryType == "incubator"){
													$str += '<th>Incubator Name</th>';
												}else if(dirCategoryType == "incubatee"){
													$str += '<th>Incubatee Name</th>';
												}
												$str +='<th>Details</th>'
												+'</tr>'
											+'</thead>'
											+'<tbody id="response_directory_incubation_table_body">';
											$( '.result-tbl-wpr .no-results' ).hide();
											$( '.result-tbl-wpr' ).show();
											$( '.result-tbl-wpr' ).html( $str );
											
											$.each(msg['Directory'], function(index) {
												var str_dir = '<tr class="companyList">'
																+'<td>'+msg['Directory'][index]["IncubationInfo"]["CompanyName"]+'</td>'
																+'<td><span class="showinfo-link info-link">Show details</span></td>'
															+'</tr>'
															+'<tr class="infoTR financialRow pecompanydetails" style="display:none">'
																+'<td colspan="6" class="no-pd">'
																	+'<div class="fin-wpr">'
																		+'<ul class="nav nav-tabs">';
																			if(dirCategoryType == "incubator"){
																				str_dir +='<li class="active"><a data-toggle="tab" href="#company_info">Incubator Profile</a></li>';
																			}else if(dirCategoryType == "incubatee"){
																				str_dir +='<li class="active"><a data-toggle="tab" href="#company_info">Incubatee Profile</a></li>';
																			}
																			
																		str_dir +='</ul>'
																		+'<div class="tab-content tbl-cnt">'
																			+'<div id="company_info" class="tab-pane fade active in">'
																				+'<ul class="fix-ul">'
																					+ '<li><span>Company Name</span></li>'
																					+'<li><span>Sector Business</span></li>'
																					+'<li><span>Address</span></li>';
																					if(dirCategoryType == "incubator"){
																						str_dir +='<li><span>Management</span></li>';
																					}
																					str_dir += '<li><span>Email</span></li>'
																					+'<li><span>Telephone</span></li>'
																					+'<li><span>City</span></li>'
																					+'<li><span>Country</span></li>'
																					+'<li><span>Zip</span></li>'
																					+'<li><span>Website</span></li>'
																				+'</ul>'
																				+'<div class="tab-cont-sec">'
																					+'<div class="tab-scroll">'
																						+'<ul>'
																							+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['IncubationInfo']["CompanyName"]+'</span></li>'
																							+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['IncubationInfo']["Sector Business"]+'</span></li>'
																							+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['IncubationInfo']["Address"]+'</span></li>';
																							if(dirCategoryType == "incubator"){
																								str_dir +='<li class="moreinfodetails"><span>'+msg['Directory'][index]['IncubationInfo']["Management"]+'</span></li>';
																							}
																							str_dir +='<li class="moreinfodetails"><span>'+msg['Directory'][index]['IncubationInfo']["Email"]+'</span></li>'
																							+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['IncubationInfo']["Telephone"]+'</span></li>'
																							+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['IncubationInfo']["City"]+'</span></li>'
																							+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['IncubationInfo']["Country"]+'</span></li>'
																							+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['IncubationInfo']["Zip"]+'</span></li>'
																							+'<li class="moreinfodetails"><span>'+msg['Directory'][index]['IncubationInfo']["Website"]+'</span></li>'
																							
																						+'</ul>'
																					+'</div>'
																				+'</div>'
																			+'</div>'
																		+'</div>'
																	+'</div>'
																+'</td>'
															+'</tr>';
														$( '#response_directory_incubation_table_body' ).append( str_dir );
											});
							
								}
							// End Incubation
							// Exits Section Start Here --------------------------------------------------------
							else if( (dirCategory == 'directory' && dealtype == 'EXITS') && (dealcategory == "PEMA" && dirCategoryType == "investor" || dirCategoryType == "company") || (dealcategory == "VCMA" && dirCategoryType == "investor" || dirCategoryType == "company")  ){
								//alert(dirCategoryType);
								$str = '<table id="response_directory_table">'
											+'<thead>'
												+'<tr>';
												if(dirCategoryType == "investor"){
													$str += '<th>Investor Name</th>'
												}else if(dirCategoryType == "company"){
													$str += '<th>Company Name</th>';
												}
												$str +='<th>Details</th>'
												+'</tr>'
												+'</thead>'
												+'<tbody id="response_directory_PEMA_or_VCMA_table_body">';
												$( '.result-tbl-wpr .no-results' ).hide();
												$( '.result-tbl-wpr' ).show();
												$( '.result-tbl-wpr' ).html( $str );
												if(msg['Directory']['Investor info']){
													var location = msg['Directory']['Investor info'];
												}
												if(msg['Directory']['InvestorInfo']){
													var location = msg['Directory']['InvestorInfo'];
												}
												$.each(location, function(index) {
													var str_dir = '<tr class="companyList">';
																		if(dirCategoryType == "investor"){
																			str_dir +='<td>'+location[index]['Investor Name']+'</td>';
																		}else if(dirCategoryType == "company"){
																			str_dir +='<td>'+location[index]['Company Name']+'</td>';
																		}
																		str_dir +='<td><span class="showinfo-link info-link">Show details</span></td>'
																	+'</tr>'
																	+'<tr class="infoTR financialRow pecompanydetails" style="display:none">'
                                        							+'<td colspan="6" class="no-pd">'
                                        								+'<div class="fin-wpr">'
                                            								+'<ul class="nav nav-tabs">';
																			if(dirCategoryType == "investor"){
                                                								str_dir +='<li class="active"><a data-toggle="tab" href="#company_info">Investor Profile</a></li>';
																				str_dir +='<li><a data-toggle="tab" href="#more_info">More Info</a></li>';
																			}else if(dirCategoryType == "company"){
																				str_dir +='<li class="active"><a data-toggle="tab" href="#company_info">Company Profile</a></li>';
																			}
                                                								
                                            								str_dir +='</ul>'
																			+'<div class="tab-content tbl-cnt">'
                                        										+'<div id="company_info" class="tab-pane fade active in">'
																					+'<ul class="fix-ul">';
																					if(dirCategoryType == "investor"){
																						str_dir +='<li><span>Investor Name</span></li>';
																					}else if(dirCategoryType == "company"){
																						str_dir +='<li><span>Company Name</span></li>';
																					}
																					str_dir +='<li><span>Address</span></li>'
																						+'<li><span>City</span></li>'
																						+'<li><span>Country</span></li>'
																						+'<li><span>Zip</span></li>'
																						+'<li><span>Telephone</span></li>';
																						if(dirCategoryType == "investor"){
																							str_dir +='<li><span>Management</span></li>';
																						}
																						str_dir +='<li><span>Email</span></li>'
																						+'<li><span>In India Since</span></li>'
																						+'<li><span>Website</span></li>'
																					+'</ul>'
																					+'<div class="tab-cont-sec">'
																						+'<div class="tab-scroll">'
																							+'<ul>';
																							if(dirCategoryType == "investor"){
																								str_dir +='<li class="moreinfodetails"><span>'+ location[index]['Investor Name'] +'</span></li>';
																							}else if(dirCategoryType == "company"){
																								str_dir +='<li class="moreinfodetails"><span>'+ location[index]['Company Name'] +'</span></li>';
																							}
																							str_dir +='<li class="moreinfodetails"><span>'+ location[index]['Investor']['Address'] +'</span></li>'
																								+'<li class="moreinfodetails"><span>'+ location[index]['Investor']['City'] +'</span></li>'
																								+'<li class="moreinfodetails"><span>'+ location[index]['Investor']['Country'] +'</span></li>'
																								+'<li class="moreinfodetails"><span>'+ location[index]['Investor']['Zip'] +'</span></li>'
																								+'<li class="moreinfodetails"><span>'+ location[index]['Investor']['Telephone'] +'</span></li>';
																								if(dirCategoryType == "investor"){
																									str_dir +='<li class="moreinfodetails"><span>'+ location[index]['Investor']['Management'] +'</span></li>';
																								}
																								str_dir +='<li class="moreinfodetails"><span>'+ location[index]['Investor']['Email'] +'</span></li>'
																								+'<li class="moreinfodetails"><span>'+ location[index]['Investor']['Since'] +'</span></li>'
																								+'<li class="moreinfodetails"><span>'+ location[index]['Investor']['Website'] +'</span></li>'
																							+'</ul>'
																						+'</div>'
																					+'</div>'
																				+'</div>';
																				if(dirCategoryType == "investor"){
																					str_dir +='<div id="more_info" class="tab-pane fade">'
																					+'<ul class="fix-ul">'
																						+'<li><span>Firm Type</span></li>'
																						+'<li class=""><span >Focus & Capital Source</span></li>'
																						+'<li class=""><span >Stage Of Funding</span></li>'
																						+'<li class=""><span >No Of Funds</span></li>'
																						+'<li class=""><span >Limited partners</span></li>'
																						+'<li class=""><span >Industry (Existing Investments)</span></li>'
																						+'<li class=""><span >Assets Under Management (US$M)</span></li>'
																						+'<li class=""><span >Already Invested (US$ Million)</span></li>'
																						+'<li class=""><span >Dry Powder (US$ Million)</span></li>'
																						+'<li class=""><span >Other Location</span></li>'
																						+'<li class=""><span >Descrption</span></li>'
																					+'</ul>'
																					+'<div class="tab-cont-sec">'
																						+'<div class="tab-scroll">'
																							+'<ul>'
																								+'<li class="moreinfodetails"><span >'+ msg['Directory']['Investor info'][index]['MoreInfo']['FirmType'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ msg['Directory']['Investor info'][index]['MoreInfo']['Focus & Capital Source'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ msg['Directory']['Investor info'][index]['MoreInfo']['Stage Of Funding'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ msg['Directory']['Investor info'][index]['MoreInfo']['No Of Funds'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ msg['Directory']['Investor info'][index]['MoreInfo']['Limited Partners'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ msg['Directory']['Investor info'][index]['MoreInfo']['Industry (Existing Investments)'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ msg['Directory']['Investor info'][index]['MoreInfo']['Assets Under Management'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ msg['Directory']['Investor info'][index]['MoreInfo']['Already Invested'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ msg['Directory']['Investor info'][index]['MoreInfo']['Drypowder'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ msg['Directory']['Investor info'][index]['MoreInfo']['Other Location'] +'</span></li>'
																								+'<li class="moreinfodetails"><span >'+ msg['Directory']['Investor info'][index]['MoreInfo']['Description'] +'</span></li>'
																							+'</ul>'
																						+'</div>'
																					+'</div>';
																				}
																				str_dir +='</div>'
																			+'</div>'
																		+'</div>'
																	+'</td>'
																+'</tr>';
															$( '#response_directory_PEMA_or_VCMA_table_body' ).append( str_dir );
												});
							
							}
							// End Exits ---------------------------------------------------------- 
						}		
						else if(dirCategory == 'funds'){
							//alert(dirCategoryType);
							$str = '<table id="response_directory_table">'
												+'<thead>'
													+'<tr>'
													+'<th>Investor Name</th>'
													+'<th>Details</th>'
													+'</tr>'
												+'</thead>'
												+'<tbody id="response_directory_fund_table_body">';
												$( '.result-tbl-wpr .no-results' ).hide();
												$( '.result-tbl-wpr' ).show();
												$( '.result-tbl-wpr' ).html( $str );
												
												$.each(msg['Fund_Details'], function(index) {
													var str_dir = '<tr class="companyList">'
																	+'<td>'+msg['Fund_Details'][index]["Investor Name"]+'</td>'
                            										+'<td><span class="showinfo-link info-link">Show details</span></td>'
																  +'</tr>'
																  +'<tr class="infoTR financialRow pecompanydetails" style="display:none">'
                                        							+'<td colspan="6" class="no-pd">'
                                        								+'<div class="fin-wpr">'
                                            								+'<ul class="nav nav-tabs">'
																				+'<li class="active"><a data-toggle="tab" href="#company_info'+msg['Fund_Details'][index]["InvestorId"]+'">Fund Details</a></li>'
																				+'<li><a data-toggle="tab" href="#more_info'+msg['Fund_Details'][index]["InvestorId"]+'">More Info</a></li>'
																				+'<li><a data-toggle="tab" href="#source_info'+msg['Fund_Details'][index]["InvestorId"]+'">Source</a></li>'
                            												+'</ul>'
																			+'<div class="tab-content tbl-cnt">'
                                        										+'<div id="company_info'+msg['Fund_Details'][index]["InvestorId"]+'" class="tab-pane fade active in">'
																					+'<ul class="fix-ul">'
																						+'<li><span>Investor Name</span></li>'
																						+'<li><span>Fund Name</span></li>'
																						+'<li><span>Fund Manager</span></li>'
																						+'<li><span>Fund Type</span></li>'
																						+'<li><span>Target Size</span></li>'
																						+'<li><span>Amount raised</span></li>'
																						+'<li><span>Fund Status</span></li>'
																						+'<li><span>Capital Source</span></li>'
																						+'<li><span>Date</span></li>'
																					+'</ul>'
																					+'<div class="tab-cont-sec">'
																						+'<div class="tab-scroll">'
																							+'<ul>'
																								+'<li class="moreinfodetails"><span>'+msg['Fund_Details'][index]["Investor Name"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Fund_Details'][index]["Fund Info"]["Fund Name"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Fund_Details'][index]["Fund Info"]["Fund Manager"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Fund_Details'][index]["Fund Info"]["Fund Type"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Fund_Details'][index]["Fund Info"]["Target Size"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Fund_Details'][index]["Fund Info"]["Amount raised"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Fund_Details'][index]["Fund Info"]["Fund Status"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Fund_Details'][index]["Fund Info"]["Capital Source"]+'</span></li>'
																								+'<li class="moreinfodetails"><span>'+msg['Fund_Details'][index]["Fund Info"]["Date"]+'</span></li>'
																							+'</ul>'
																						+'</div>'
																					+'</div>'
																				+'</div>'
																				+'<div id="more_info'+msg['Fund_Details'][index]["InvestorId"]+'" class="tab-pane fade">'
																					+'<ul class="fix-ul">'
																						+'<li><span>More Info</span></li>'
																					+'</ul>'
																					+'<div class="tab-cont-sec">'
																						+'<div class="tab-scroll">'
																							+'<ul>'
																								+'<li class="moreinfodetails"><span >'+msg['Fund_Details'][index]["More Info"] +'</span></li>'
																							+'</ul>'
																						+'</div>'
																					+'</div>'
																				+'</div>'
																				+'<div id="source_info'+msg['Fund_Details'][index]["InvestorId"]+'" class="tab-pane fade">'
																					+'<ul class="fix-ul">'
																						+'<li><span>Source</span></li>'
																					+'</ul>'
																					+'<div class="tab-cont-sec">'
																						+'<div class="tab-scroll">'
																							+'<ul>'
																								+'<li class="moreinfodetails"><span >'+msg['Fund_Details'][index]["Source Info"] +'</span></li>'
																							+'</ul>'
																						+'</div>'
																					+'</div>'
																				+'</div>'

																			+'</div>'
																		+'</div>'
																	+'</td>'
																+'</tr>';
															$( '#response_directory_fund_table_body' ).append( str_dir );
												});

						}
						// END TABLE
					// End ************************************************************************
				},
				error: function(err) {
					console.log( err );
					$( '.body-overlay' ).hide();
				}
			})
		});

		// For API Changes End Here ************************************************************

		$( document ).on( 'click', '#user_check', function() {
			if( $( this ).prop( 'checked' ) ) {
				$( '#api_userName' ).attr( 'disabled', false );
				$( '#api_password' ).attr( 'disabled', false );
			} else {
				$( '#api_userName' ).val('').attr( 'disabled', true );
				$( '#api_password' ).val('').attr( 'disabled', true );
			}
		});

		$( document ).on( 'click', '.close-icon', function() {
			$( '.cfs-fields, .pe-fields, .ma-fields' ).hide();
			$( '.result-wpr' ).show();
		});
		$( document ).on( 'click', '.cfs-btn', function() {
			$( '.close-icon' ).trigger( 'click' );
			$( '.result-wpr' ).hide();
			$( '.cfs-fields' ).show();
		});
		$( document ).on( 'click', '.pe-btn', function() {
			$( '.close-icon' ).trigger( 'click' );
			$( '.result-wpr' ).hide();
			$( '.pe-fields' ).show();
		});
		$( document ).on( 'click', '.ma-btn', function() {
			$( '.close-icon' ).trigger( 'click' );
			$( '.result-wpr' ).hide();
			$( '.ma-fields' ).show();
		});

		$( document ).on( 'click', '.add-cin', function() {
			$( '.add-cin' ).remove();
			var tempContent = '<div class="frm-fld cin_rows">'+
								'<input class="effect-9" type="text" name="cin[]">'+
					    		'<span class="focus-border"><i></i></span>'+
					    		'<i class="close-cin"></i><i class="add-cin"></i>'+
							'</div>';
			if( $( '.cin_rows' ).length <= 9 ) {
				$( '.cin_rows:last' ).after( tempContent );	
			} else {
				alert( 'Only 10 CIN\'s allowed' );
			}
		});
		$( document ).on( 'click', '.close-cin', function(e) {
			if( $($( $(e.target) ).parent('.cin_rows').prev('.cin_rows')).find( '.close-cin' ).length > 0 ) {
				if( $($( $(e.target) )).parent('.cin_rows').is(':last-child') ) {
					$($( $(e.target) ).parent('.cin_rows').prev('.cin_rows')).find( '.close-cin' ).after('<i class="add-cin"></i>');	
				}
			} else {
				if( $($( $(e.target) )).parent('.cin_rows').is(':last-child') ) {
					$($( $(e.target) ).parent('.cin_rows').prev('.cin_rows')).find( '.focus-border' ).after('<i class="add-cin"></i>');
				}
			}
			
			$( $(e.target) ).parent('.cin_rows').remove();			
		});

		$( '#test2' ).on( 'click', function() {
			$( '.result-tbl-wpr' ).hide();
			$( '.json-resposne' ).show();
		});
		$( '#test1' ).on( 'click', function() {
			$( '.json-resposne' ).hide();
			$( '.result-tbl-wpr' ).show();
		});
		$( '#fetch_update_cin' ).on( 'click', function(e) {
			var week = $( '#week' ).val();
			$.ajax({
				type: 'post',
				url: 'cinfetch.php',
				data: {'week':week},
				success: function( msg ) {
					$( '#fetchInfo .modal-body' ).html( msg );
					$( '#fetchInfo' ).modal( 'show' );
				}
			})
		});
	});
	$('.tab-scroll').scroll(function () {
        var winScroll = $(this).scrollRight();
        console.log(winScroll);
    });

    /*$( '#exportData' ).on( 'click', function() {
    	//var obj = JSON.parse($( '.json-code' ).text());
    	$.ajax({
    		type: 'post',
    		url: 'exportJson.php',
    		data: {'jsonObj':$( '.json-code' ).text()},
    		success: function( msg ) {
    			alert( msg );
    		}
    	})
    });*/

	$(window).resize(function() {
		lftH();
	});

	lftH();
	function lftH() {
		var wH = $(document).height() - 70;
	    $('.left-sec').height(wH);
	}
	/*$( document ).on( 'click', '.financialinfo-link', function(e) {
		if($(this).hasClass('active')) {
			$(e.target).parents('tr').nextAll('tr.financialRow:first').fadeOut();
			$(this).removeClass('active');
			$(this).text('Show details');
		}
		else
		{
			$( '.info-link.active' ).trigger( 'click' );
			$(e.target).parents('tr').nextAll('tr.financialRow:first').fadeIn();
			$(this).addClass('active');
			$(this).text('Hide details');
		}
	});*/
	$( document ).on( 'click', '.showinfo-link', function(e) {
		if($(this).hasClass('active')) {
			$(e.target).parents('tr').nextAll('tr.financialRow:first').fadeOut();
			$(this).removeClass('active');
			$(this).text('Show details');
		}
		else
		{
			$( '.info-link.active' ).trigger( 'click' );
			$(e.target).parents('tr').nextAll('tr.financialRow:first').fadeIn();
			$(this).addClass('active');
			$(this).text('Hide details');
		}
	});
	$( document ).on( 'click', '.fundinginfo-link', function(e) {
		if($(this).hasClass('active')) {
			$(e.target).parents('tr').nextAll('tr.fundingRow:first').fadeOut();
			$(this).removeClass('active');
			$(this).text('Show details');
		}
		else
		{
			$( '.info-link.active' ).trigger( 'click' );
			$(e.target).parents('tr').nextAll('tr.fundingRow:first').fadeIn();
			$(this).addClass('active');
			$(this).text('Hide details');
		}
	});

	$( document ).on( 'click', '.companyinfo-link', function(e) {
		if($(this).hasClass('active')) {
			$(e.target).parents('tr').nextAll('tr.companyRow:first').fadeOut();
			$(this).removeClass('active');
			$(this).text('Show details');
		}
		else
		{
			$( '.info-link.active' ).trigger( 'click' );
			$(e.target).parents('tr').nextAll('tr.companyRow:first').fadeIn();
			$(this).addClass('active');
			$(this).text('Hide details');
		}
	});

	var wWs = $(window).width();
	if(wWs > 1024) {
		finWd();
		$(window).resize(function() {
			finWd();
		});
		function finWd() {
			var wW = $(window).width();
			var lftW = $('.left-sec').width();
			$('.fin-wpr').width(wW-lftW-115);
		}
	}

	$(document).on("change","#dealtype",function(){
         $catgoryType=$(this).val();
        if($catgoryType == "INVESTMENTS" || $catgoryType == "EXITS" ) {
			$("#dirCategoryType option").removeAttr('disabled');
            $(".forIncubation, .forAngel").attr('disabled','');
			$("#dirCategoryType ").val('investor');
        } 
    });


	$(document).on("change","#dirCategory",function(){
		var dirType = $("#dirCategory").val();
		
		if( dirType == "directory") {
				$("#dirCategoryType option").removeAttr('disabled');
				$("#dirCategoryType option").removeClass('exits_select');
				$("#dirCategoryType ").val('investor');
				$(".forCompany").hide();
				$(".forDirectory").show();
				$( '.forDeals' ).show();
				$(".forIncubation, .forAngel").attr('disabled','');
				$("#datatype ").val('1');
				$( '.aggregate' ).attr('disabled', true);
		} else {
				$("#dirCategoryType option").attr('disabled','');
				$("#dirCategoryType option").addClass('exits_select');
				$("#dirCategoryType ").val('');
				
				if(dirType == 'funds'){
					$( '.forDeals' ).hide();
					$( '.forCompany' ).hide();
				} else {
					$(".forCompany").show();
				}
				$(".forDirectory").hide();
				$(".forInvestor").show();
				
				$("#datatype ").val('1');
				$( '.aggregate' ).removeAttr('disabled');
		}

	});

	$(document).on("change","#dirCategoryType",function(){
		// $("#company").val('');
		// $("#investor").val('');
		if($( this ).val() == 'investor'){
			$(".forCompany").hide();
			$(".forInvestor").show();
		} else if($( this ).val() == 'company'){
			$(".forCompany").show();
			$(".forInvestor").hide();
		}else{
			$(".forInvestor").show();
			$(".forCompany").show();
		}
	});

	$(document).on("click","#isAll",function(){
		if( $( '#isAll' ).prop( 'checked' ) ) {
			$( '#time' ).val('');
			$( '#time' ).attr('disabled',true);
			$( '#from_month' ).attr('disabled',true);
			$( '#to_month' ).attr('disabled',true);
			$( '#from_year' ).attr('disabled',true);
			$( '#to_year' ).attr('disabled',true);
		} else {
			$( '#time' ).attr('disabled',false);
			$( '#from_month' ).attr('disabled',false);
			$( '#to_month' ).attr('disabled',false);
			$( '#from_year' ).attr('disabled',false);
			$( '#to_year' ).attr('disabled',false);
		}
	});

	$(document).on("change","#dealcategory",function(){ 
		var dealType = $("#dealcategory").val();
		
		if( dealType == "ANGEL") {
			$("#dirCategoryType  option").attr('disabled','');
			$("#dirCategoryType option").addClass('exits_select1');

			$("#dirCategoryType  option[value='investor'],#dirCategoryType  option[value='fundedComp'],#dirCategoryType  option[value='fundraisingComp']").removeAttr('disabled');
			$("#dirCategoryType  option[value='investor'],#dirCategoryType  option[value='fundedComp'],#dirCategoryType  option[value='fundraisingComp']").removeClass('exits_select1');
			$("#dirCategoryType ").val('investor');
			$(".forCompany").hide();
			$(".forInvestor").show();

		} else if( dealType == "INCUBATION") { 
			$("#dirCategoryType  option").attr('disabled','');
			$("#dirCategoryType option").addClass('exits_select1');
			$("#dirCategoryType  option[value='incubator'],#dirCategoryType  option[value='incubatee']")
			.removeAttr('disabled');
			$("#dirCategoryType  option[value='incubator'],#dirCategoryType  option[value='incubatee']")
			.removeClass('exits_select1');
			$("#dirCategoryType ").val('incubator');
			$(".forCompany").hide();
			$(".forInvestor").hide();

		} else if( dealType == "PEIPO" || dealType == "VCIPO") { 
			$("#dirCategoryType  option").attr('disabled','');
			$("#dirCategoryType option").addClass('exits_select1');
			$("#dirCategoryType  option[value='investor'],#dirCategoryType  option[value='company']")
			.removeAttr('disabled');
			$("#dirCategoryType  option[value='investor'],#dirCategoryType  option[value='company']")
			.removeClass('exits_select1');
			$("#dirCategoryType ").val('investor');
			$(".forCompany").hide();
			$(".forInvestor").show();

		} else {
			
			$("#dirCategoryType  option").attr('disabled','');
			$("#dirCategoryType option").addClass('exits_select1');

			$("#dirCategoryType  option[value='investor'],#dirCategoryType  option[value='company'],#dirCategoryType  option[value='legalAdvisor'],#dirCategoryType  option[value='transactionAdvisor']")
			.removeAttr('disabled');
			$("#dirCategoryType  option[value='investor'],#dirCategoryType  option[value='company'],#dirCategoryType  option[value='legalAdvisor'],#dirCategoryType  option[value='transactionAdvisor']")
			.removeClass('exits_select1');

				$("#dirCategoryType ").val('investor');
				$(".forCompany").show();
			$(".forInvestor").show();
		}

	});

</script>
</body>
</html>