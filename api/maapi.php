<?php
	require_once '../dbconnectvi.php';
	$DB = new dbInvestments();
	if( !$_SESSION[ 'api_user_id' ] || !$_SESSION[ 'api_username' ] ) {
		header( 'Location: index.php' );
	}
	if( !$_SESSION[ 'is_admin' ] && $_SESSION[ 'logged_db' ] != 'MA' ) {
		if( $_SESSION[ 'logged_db' ] == 'PE' ) {
			$redirectPage = 'peapi.php';
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
	<title>M&amp;A | JSON Generate</title>
	<link rel="icon" href="images/company.png" sizes="16x16" type="image/png">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
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
					<div class="frm-fld center-text">
						<input class="effect-9" disabled type="text" value="https://api.vionweb.com/">				
					</div>
					<?php 
					if( $_SESSION[ 'is_admin' ] ) {
					?>
					<div class="frm-fld login-as-admin">
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
					</div>
					<input class="effect-9" name="is_admin" id="is_admin" type="hidden" value="1" />
					<?php } else { ?>
						<input class="effect-9" name="api_userName" id="api_userName" type="hidden" value="<?php echo $_SESSION[ 'api_username' ]; ?>" />
						<input class="effect-9" type="hidden" name="api_password" id="api_password" value="<?php echo $_SESSION[ 'hashKey' ]; ?>" />
					<?php } ?>
					<label class="fetch-label">Section:</label>
					<div class="frm-fld select-info">
						<select name="section" id="section">
							<option value="1">Deals</option>
							<option value="2">Directory</option>
						</select>					
					</div>
					<div class="deal_select">
						<label class="fetch-label">Deal Type:</label>
						<div class="frm-fld select-info">
							<select name="dealtype" id="dealtype">
								<option value="1,2,3">All</option>
								<option value="1">Inbound</option>
								<option value="2">Outbound</option>
								<option value="3">Domestic</option>
							</select>					
						</div>
					</div>
					<label class="fetch-label">Year:</label>
					<div class="frm-fld">
						<input class="effect-9" type="text" name="time" id="time" value="" />					
					</div>
					<label class="fetch-label">Data Type:</label>
					<div class="frm-fld select-info">
						<select name="datatype" id="datatype">
							<option value="1">Details</option>
							<option value="2">Aggregate</option>
						</select>					
					</div>
					<label class="fetch-label">Company (optional) <span class="help-icon" data-toggle="tooltip" title=" 1. For Target company, input value must be 1 with company name (e.g. CARE/1 2). For Acquirer company, input value must be 2 with company name (e.g. CARE/2)">&quest;</span>:</label>
					<div class="frm-fld">
						<input class="effect-9" type="text" name="company" id="company" value="" />					
					</div>
					<div class="category_select" style="display:none;">
					<label class="fetch-label">Category:</label>
						<div class="frm-fld select-info">
							<select name="category" id="category">
								<option value="1">Target Company</option>
								<option value="2">Acquirer Company</option>
								<option value="3">Legal Advisor</option>
								<option value="4">Transaction Advisor</option>
							</select>					
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
							<option value="pe">PE</option>
							<option selected="" value="ma">MA</option>
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
							<!-- <div class="result-radio">
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
							</div> -->
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
					<div class="json-resposne">
						<span class="no-results">Generate Json to check the updated data.</span>
						<pre class="json-code" style="width:100%; display: none;"></pre>
						<form action="downloadMAJson.php" method="post">
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
		$( '#section' ).on( 'change', function() {
			if( $( this ).val() == 1 ) {
				$( '.category_select' ).hide();
				$( '.deal_select' ).show();
			} else {
				$( '.deal_select' ).hide();
				$( '.category_select' ).show();
			}
		});
		$( '#submit' ).click( function() {
			var error = 0;
			var msg = '';
			var timeVal = $( '#time' ).val();
			if( timeVal == '' ) {
				msg += 'Please enter time \n';
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
			$.ajax({
				type : 'POST',
				url : 'maapi_fetch.php',
				data : form.serialize(),
				success: function(msg){
					msg = $.parseJSON(msg);
					if( msg.Status == 'Success' ) {
						$( '.json-resposne .no-results' ).hide();
						$( '.json-resposne pre' ).show().html( JSON.stringify(msg.Results, undefined, 2) );
						$( '#jsonObj' ).val( JSON.stringify(msg.Results, undefined, 2) );
						$( '#exportData' ).show();
					} else {
						alert( msg.Result );
						$( '.json-resposne .no-results' ).show();
						$( '.json-resposne pre' ).hide().html( '' );
						$( '#jsonObj' ).val('');
						$( '#exportData' ).hide();
					}
					$( '.body-overlay' ).hide();
				}
			})
		});

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
    		url: 'downloadMAJson.php',
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
	$( document ).on( 'click', '.financialinfo-link', function(e) {
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

</script>
</body>
</html>