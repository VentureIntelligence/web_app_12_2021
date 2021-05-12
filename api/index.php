<?php
	require_once '../dbconnectvi.php';
	$DB = new dbInvestments();
	if( $_SESSION[ 'api_user_id' ] || $_SESSION[ 'api_username' ] ) {
		if( !$_SESSION[ 'is_admin' ] ) {
			if( $_SESSION[ 'logged_db' ] == 'CFS' ) {
				$redirectPage = 'home.php';
			} else if( $_SESSION[ 'logged_db' ] == 'PE' ) {
				$redirectPage = 'peapi.php';
			} else if( $_SESSION[ 'logged_db' ] == 'MA' ) {
				$redirectPage = 'maapi.php';
			} else {
				$redirectPage = 'index.php';
			}
			header( 'Location:'.$redirectPage );
		} else {
			header( 'Location: home.php' );
		}
	}
	if( isset( $_POST ) && isset( $_POST[ 'submit' ] ) ) {
		$username = $_POST[ 'username' ];
		$password = $_POST[ 'password' ];
		if( isset( $_POST[ 'login_admin' ] ) ) {
			$is_admin = $_POST[ 'login_admin' ];
			//$sel = "SELECT au.* FROM admin_user as au,grouplist as g, users as u,dealcompanies as dc,dealmembers as dm WHERE dc.DCompId=dm.DCompId and g.Group_Id=u.GroupList and (dm.EmailId= '$username' and dm.Passwrd= '" . md5($password) ."' AND dc.api_access = 1) Or (u.email= '$username' and u.user_password= '" . md5($password) ."' AND g.api_access = 1) Or (au.UserName = '$username' AND au.Password = '" . md5($password) ."' AND au.api_access = 1) ";
			$sel = "SELECT DISTINCT au.* FROM admin_user as au WHERE  au.UserName = '$username' AND au.Password = '" . md5($password) ."' AND au.api_access = 1 ";
			//$sel = "SELECT au.* FROM admin_user as au,grouplist as g, users as u WHERE  g.Group_Id=u.GroupList and (u.email= '$username' and u.user_password= '" . md5($password) ."' AND g.admin_api_access = 1) Or (au.UserName = '$username' AND au.Password = '" . md5($password) ."' AND au.api_access = 1) ";
			
			$res = mysql_query( $sel ) or die( mysql_error() );
			$numRows = mysql_num_rows( $res );
			 $selquerygu= "SELECT DISTINCT u.user_id as user_id FROM grouplist as g, users as u WHERE g.Group_Id=u.GroupList and u.email=  '$username' and u.user_password= '" . md5($password) ."' AND g.admin_api_access = 1";
			 $res1 = mysql_query( $selquerygu ) or die( mysql_error() );
			 $numRowsgu = mysql_num_rows( $res1 );
			$selquerydc= "SELECT DISTINCT dc.DCompId as DCompId FROM dealcompanies as dc,dealmembers as dm WHERE dc.DCompId=dm.DCompId and dm.EmailId= '$username' and dm.Passwrd= '" . md5($password) ."' AND dc.admin_api_access = 1";
			$res2 = mysql_query( $selquerydc ) or die( mysql_error() );
			$numRowsdc = mysql_num_rows( $res2 );
			$sel3 = "SELECT ext.Firstname, ext.Lastname, ext.Email, ext.UserName, ext.Ident FROM admin_user_external as ext
						WHERE ( ext.UserName = '$username' || ext.Email = '$username' ) AND ext.Password = '" . md5($password) . "' AND ext.external_api_access = 1 and ext.api_access=1 and usr_flag=4 and is_deleted = 0";
				$res3 = mysql_query( $sel3 ) or die( mysql_error() );
			$numRows3 = mysql_num_rows( $res3 );
			$sel4 = "SELECT ext.first_name, ext.last_name, ext.email, ext.user_name, ext.id FROM adminvi_user_external as ext
				WHERE (ext.email = '$username' ) AND ext.password  = '" . md5($password) . "' AND ext.external_api_access = 1 and ext.admin_api_access=1 and ext.is_enabled = 1 and ext.is_deleted = 0";
		    $res4 = mysql_query( $sel4 ) or die( mysql_error() );
		    $numRows4 = mysql_num_rows( $res4 );
			
			if( $numRows > 0 || $numRowsdc>0 || $numRowsgu>0 || $numRows3>0 || $numRows4>0 ) {
				if($numRows > 0){
					
				$result = mysql_fetch_array( $res );
				
				if( $result[ 'is_deleted' ] == 1 ) {
					$message = 'Admin User not exists !';
				} else if( $result[ 'usr_flag' ] == 0 ) {
					$message = 'Provided User not yet Approved !';
				} else {
					//$_SESSION[ 'api_username' ] = $result[ 'UserName' ];
					$_SESSION[ 'api_username' ] = $username;
					
					$_SESSION[ 'api_user_id' ] = $result[ 'Ident' ];
					$_SESSION[ 'is_admin' ] = true;
					header( 'Location: home.php' );
					
				}
				}elseif($numRowsdc>0 || $numRowsgu>0 ){

					
					if($numRowsgu > 0){
					$result1 = mysql_fetch_array( $res1 );
					$id=$result1[ 'user_id' ];
					}else if($numRowsdc > 0){
						$result2 = mysql_fetch_array( $res2 );
					$id=$result2[ 'DCompId' ];
					}
					// echo $username;
					// echo $password;
					// echo $id;
					// exit();
					$_SESSION[ 'api_username' ] = $username;
						$_SESSION[ 'hashKey' ] = $password;
						$_SESSION[ 'api_user_id' ] =$id ;
						$_SESSION[ 'is_admin' ] = true;
						
						header( 'Location: home.php' );
				}elseif($numRows3>0 || $numRows4>0){
					   
					 if($numRows3 > 0){
						$result3 = mysql_fetch_array( $res3 );
						$id=$result3[ 'Ident' ];
						}else if($numRows4 > 0){
							$result4 = mysql_fetch_array( $res4 );
						$id=$result4[ 'id' ];
						}
						

						
					    $_SESSION[ 'api_username' ] = $username;
						$_SESSION[ 'hashKey' ] = $password;
						$_SESSION[ 'api_user_id' ] =$id ;
						$_SESSION[ 'is_admin' ] = true;
						
						header( 'Location: home.php' );
						
					
				}
				
				
				
			} else {
				$message = 'Username or Password is not found. Please use subscribers login';
			}
		} else {
			$db_type = $_POST[ 'db_type' ];
			if( $db_type == 'CFS' ) {
				
				$sel = "SELECT users.firstname, users.lastname, users.email, users.username, users.user_id, grouplist.status, users.user_authorized_status FROM users
						LEFT JOIN grouplist
							ON grouplist.Group_Id = users.GroupList 
						WHERE ( users.username = '$username' || users.email = '$username' ) AND users.user_password = '" . md5($password) . "' AND api_access = 1";
				$res = mysql_query( $sel ) or die( mysql_error() );
				$numRows = mysql_num_rows( $res );
				$sel1 = "SELECT ext.Firstname, ext.Lastname, ext.Email, ext.UserName, ext.Ident FROM admin_user_external as ext
						WHERE ( ext.UserName = '$username' || ext.Email = '$username' ) AND ext.Password = '" . md5($password) . "' AND ext.external_api_access = 1 and ext.usr_flag = 4 and ext.is_deleted = 0";
				$res1 = mysql_query( $sel1 ) or die( mysql_error() );
				$numRows1 = mysql_num_rows( $res1 );
				//echo $sel1;
				if( $numRows > 0 || $numRows1 > 0 ) {
					if( $numRows > 0){
					$result = mysql_fetch_array( $res );
					if( $result[ 'status' ] == 1 ) {
						$message = "Group is not active. Please contact to activate.";
					} else if( $result[ 'user_authorized_status' ] == 0 ) {
						$message = 'User not yet authorized !';
					} else {
						$_SESSION[ 'api_username' ] = $username;
						$_SESSION[ 'hashKey' ] = $password;
						$_SESSION[ 'api_user_id' ] = $result[ 'user_id' ];
						$_SESSION[ 'is_admin' ] = false;
						$_SESSION[ 'logged_db' ] = 'CFS';
						header( 'Location: home.php' );
					}
				   }elseif($numRows1 > 0){

					$result1 = mysql_fetch_array( $res1 );
					
						$_SESSION[ 'api_username' ] = $username;
						$_SESSION[ 'hashKey' ] = $password;
						$_SESSION[ 'api_user_id' ] = $result1[ 'Ident' ];
						$_SESSION[ 'is_admin' ] = false;
						$_SESSION[ 'logged_db' ] = 'CFS';
						header( 'Location: home.php' );
					
				   }
				} else {
					$message = 'Username or Password is not found';
				}
			} else if( $db_type == 'PE' ) {
				$sel = "SELECT dealmembers.DCompId, dealmembers.EmailId, dealmembers.Name, dealmembers.user_authorization_status 
						FROM dealmembers
						LEFT JOIN dealcompanies
							ON dealcompanies.DCompId = dealmembers.DCompId 
						WHERE dealmembers.EmailId = '$username' AND dealmembers.Passwrd = '" . md5($password) . "' AND dealcompanies.api_access = 1";
				$res = mysql_query( $sel ) or die( mysql_error() );
				$numRows = mysql_num_rows( $res );
				$sel1 = "SELECT ext.first_name, ext.last_name, ext.email, ext.user_name, ext.id FROM adminvi_user_external as ext
						WHERE (ext.email = '$username' ) AND ext.password  = '" . md5($password) . "' AND ext.external_api_access = 1 and ext.is_enabled = 1 and ext.is_deleted = 0";
				$res1 = mysql_query( $sel1 ) or die( mysql_error() );
				$numRows1 = mysql_num_rows( $res1 );
//				echo $sel1;
				if( $numRows > 0 || $numRows1 > 0 ) {
					if( $numRows > 0){
					$result = mysql_fetch_array( $res );
					if( $result[ 'user_authorization_status' ] == 0 ) {
						$message = 'User not yet authorized !';
					} else {
						$_SESSION[ 'api_username' ] = $username;
						$_SESSION[ 'hashKey' ] = $password;
						$_SESSION[ 'api_user_id' ] = $result[ 'DCompId' ];
						$_SESSION[ 'is_admin' ] = false;
						$_SESSION[ 'logged_db' ] = 'PE';
						header( 'Location: peapi.php' );
					}
					}elseif( $numRows1 > 0){
					$result1 = mysql_fetch_array( $res1 );
					
						$_SESSION[ 'api_username' ] = $username;
						$_SESSION[ 'hashKey' ] = $password;
						$_SESSION[ 'api_user_id' ] = $result1[ 'id' ];
						$_SESSION[ 'is_admin' ] = false;
						$_SESSION[ 'logged_db' ] = 'PE';
						header( 'Location: peapi.php' );
					
					}
				} else {
					$message = 'Username or Password is not found';
				}
			} else if( $db_type == 'MA' ) {
				$sel = "SELECT malogin_members.DCompId, malogin_members.EmailId, malogin_members.Name, malogin_members.user_authorization_status 
						FROM malogin_members
						LEFT JOIN dealcompanies
							ON dealcompanies.DCompId = malogin_members.DCompId 
						WHERE malogin_members.EmailId = '$username' AND malogin_members.Passwrd = '" . md5($password) . "' AND dealcompanies.api_access = 1";
				$res = mysql_query( $sel ) or die( mysql_error() );
				$numRows = mysql_num_rows( $res );
				$domainName = substr(strrchr($result[1], "@"), 1);
				if( $numRows > 0 ) {
					$result = mysql_fetch_array( $res );
					$domainName = substr(strrchr($result[1], "@"), 1);
					if ( ($domainName != "truenorthco.in")  )  {
						if( $result[ 'user_authorization_status' ] == 0 ) {
							$message = 'User not yet authorized !';
						} else {
							$_SESSION[ 'api_username' ] = $username;
							$_SESSION[ 'hashKey' ] = $password;
							$_SESSION[ 'api_user_id' ] = $result[ 'DCompId' ];
							$_SESSION[ 'is_admin' ] = false;
							$_SESSION[ 'logged_db' ] = 'MA';
							header( 'Location: maapi.php' );
						}
					} else {
						$message = "You don't have access for MA";
					}
				} else {
					$message = 'Username or Password is not found';
				}
			}
		}		
	} else {
		$message = "";
	}
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">	
	<title>Login</title>
	<link rel="icon" href="images/company.png" sizes="16x16" type="image/png">
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
	<script type="text/javascript" src="js/jquery-2.2.0.min.js"></script>
	<script type="text/javascript" src="js/bootstrap.min.js"></script>
</head>
<body class="lg-pg">
<div class="lg-wpr">
	<div class="lg-frm">
		<div class="logo-wpr">
			<img src="images/logo1.png" alt="logo">
		</div>
		<?php if( $message ) { ?>
		<div class="alert alert-danger alert-dismissible">
			<a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
		<?php 
			echo $message;
		?>
		</div>
		<?php } ?>
		<form method="post" action="index.php">
			<div class="lg-frm-wpr">
				<div class="frm-fld login-as-admin">
					<p><input class="effect-2" name="login_admin" id="login_admin" type="checkbox" value="1"><label>Login as Admin</label></p>
				</div>
				<div class="frm-fld">
					<input class="effect-2" name="username" id="username" type="text" placeholder="Username">
				    <span class="focus-border"></span>
				</div>
				<div class="frm-fld">
					<input class="effect-2" type="password" name="password" id="password" placeholder="Password">
				    <span class="focus-border"></span>
				</div>
				<div class="frm-fld login-admin-radio">
					<p>
						<input class="effect-2 db_type" type="radio" name="db_type" id="db_cfs" value= 'CFS' />
					    <label for="db_cfs">CFS</label>
					</p>
					<p>
						<input class="effect-2 db_type" type="radio" name="db_type" id="db_pe" value= 'PE' />
					    <label for="db_pe">PE</label>
					</p>
					<p>
						<input class="effect-2 db_type" type="radio" name="db_type" id="db_ma" value= 'MA' />
					    <label for="db_ma">MA</label>
					</p>
				</div>
				<div class="frm-fld">
					<input type="submit" name="submit" id="submit" class="login-btn" value="Login" />
				</div>												
			</div>
		</form>
	</div>
</div>
<script type="text/javascript">
	$( document ).ready( function() {
		$( '#login_admin' ).on( 'click', function(e) {
			if ( $(this).prop('checked') ) {
				$( '.login-admin-radio' ).hide();
			} else {
				$( '.login-admin-radio' ).show();
			}
		});
		$( '#submit' ).on( 'click', function() {
			var username = $( '#username' ).val();
			var password = $( '#password' ).val();
			var msg = '';
			var error = 0;
			if( username == '' ) {
				msg += 'Please enter username\n';
				error = 1;
			}
			if( password == '' ) {
				msg += 'Please enter password\n';
				error = 1;
			}
			if( $($( '.db_type' ).is( ':checked' )).length == 0 && !( $('#login_admin').prop('checked') ) ) {
				msg += 'Please choose db type\n';
				error = 1;
			}
			if( error > 0 ) {
				alert( msg );
				return false;
			} else {
				return true;
			}
		});
	});
</script>
</body>
</html>