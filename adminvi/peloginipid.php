<?php include_once("../globalconfig.php"); ?>
<?php
 session_save_path("/tmp");
session_start();
/*
	filename - pelogin.php
    formanme - pelogin
    invoked from -  direct from website link
    invoked to - peauthenticate.php
  */
  //setcookie("TCook");
		require("dbconnectvi.php");
		$Db = new dbInvestments();
	     $Db->dbInvestments();
		$displayMessage="";
		include "onlineaccount.php";
		global $LoginAccess;
		global $LoginMessage;
		global $TrailExpired;
				$login=$_POST['emailid'];
				$login=trim($login);
				$pwd=$_POST['emailpassword'];
				$pwd=trim($pwd);
				//$login="sparikh@iimahd.ernet.in";
				//$pwd="1*2&3^4";
				if((trim($login)!= "") && (trim($pwd)!=""))
				{
					session_regenerate_id();
			 		$sesID=session_id();
			 		$ipadd=@$REMOTE_ADDR;
			 		//$ipadd="203.200.225.129";
			 		//echo "<Br>IPADDRESS-" .$ipadd;
					$logintime=date("Y-m-d")." ".date("H:i:s");
					$splitIpAdd= explode(".", $ipadd);
					$splitIpAdd1=$splitIpAdd[0];
					$splitIpAdd2=$splitIpAdd[1];
					$splitIpAdd3=$splitIpAdd[2];
					$splitIpAdd4=$splitIpAdd[3];
					$splitIpAddress=$splitIpAdd1.".".$splitIpAdd2.".".$splitIpAdd3.".";
					$checkForIPAddress="select * from ipAddress where ipaddress='$splitIpAddress'";
						if($rsip=mysql_query($checkForIPAddress))
						{
							$ipcnt= mysql_num_rows($rsip);
							While($myrowIP=mysql_fetch_array($rsip, MYSQL_BOTH))
							{
								if(($splitIpAdd4>=$myrowIP["StartRange"]) && ($splitIpAdd4<=$myrowIP["EndRange"]))
								{
									$companyId=$myrowIP["DCompId"];
									$cnt=1;
								}
							}
						}
						if(($ipcnt==1) && ($cnt=1))
						{
								$checkForUnknownLoginSql="select * from dealmembers where EmailId='$login' and DCompId=$companyId";
								//echo "<br>-- ".$checkForUnknownLoginSql;
								if($rsRandom=mysql_query($checkForUnknownLoginSql))
								{	$random_cnt= mysql_num_rows($rsRandom);			}
								if($random_cnt==1)
								{
									$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM dealmembers AS dm,
													dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
													dm.EmailId='$login' and dm.Passwrd='$pwd'
													AND dc.Deleted =0";
									if ($totalrs = mysql_query($checkUserSql))
									{
										$cnt= mysql_num_rows($totalrs);
										if ($cnt==1)
										{
											While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
											{
												if( date('Y-m-d')<=$myrow["ExpiryDate"])
												{
													session_register("UserNames");
													session_register("UserEmail");
													$username=trim($myrow["Name"]);
													$_SESSION['UserNames']=$username;
													$_SESSION['UserEmail']=$myrow["EmailId"];
													$LogIntimeSql="insert into dealLog(LogSessionID,EmailId,LoggedIn,IpAdd,PE_MA) values('$sesID','$login','$logintime','$ipadd',0)";
													if($logrs=mysql_query($LogIntimeSql))
													{
													}
													header( 'Location: '. GLOBAL_BASE_URL .'deals/dealhome.php' ) ;
												}
												elseif($myrow["ExpiryDate"] >= date('y-m-d'))
												{	$displayMessage= " Sorry !! Login denied";}
											}
										}
										elseif ($cnt==0)
										{  $displayMessage= $LoginAccess;}
									}
								}
								elseif($random_cnt==0)
								{
									$RandomLogSql="insert into dealLog(LogSessionID,EmailId,LoggedIn,IpAdd,UnAuthorized) values('$sesID','$login','$logintime','$ipadd',1)";
									if($logrs=mysql_query($RandomLogSql))
									{
									}
									$displayMessage= " Sorry !! Login denied";
								}
						}
						else
							$displayMessage= " Sorry !! Login denied";
				}

//echo "<Br>######" .$displayMessage;
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">

</SCRIPT>
<link href="style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="pelogin"  method="post" action="peloginipid.php" >
<div id="containerproductpelogin">
<!-- Starting Left Panel -->
  <?php include_once('leftpanel.php'); ?>
<!--  <div id="leftpanel">
    <div><a href="index.htm"><img src="images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgpropelogin">

    	<div id="vertMenupelogin">


        	<div> <input type=hidden name="emailid" value="student@iimb.ernet.in" size="23"> <br /><br /></div>

        	<div> <input type=hidden name="emailpassword" value="1*2&3^4" size="23"> <br /><br /></div>


			<div> <span style="float:right" >
			<input type="submit" name="btnSubmit" value ="Click here to Login"> </span> <br /><br /></div>


	       	<div id="headingtextproboldfontcolor"> <?php echo $displayMessage; ?> <br /></div>


			<div id="headingtextprosmallfont"
        	<input name="chkTerm" type="checkbox" checked >
        	By accessing this database, you agree to the <a href="terms.htm">terms & conditions</a>
			of use upon which access is provided.<br /></div>


        	<div id="headingtextprosmallfont">
					Requires <a target="_blank" href="http://www.mozilla.com/en-US/firefox/">Firefox <a/>
					or <A target="_blank" href=" http://www.microsoft.com/downloads">IE 7.0 </a>
					</div> <br />

			<div><a href="forgotpwd.htm">Forgot Password ?</a></div> 

		</div>


    </div>

   </div>-->
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">

	  <div style="background-color:#FFF; width:565px; height:496px; margin-top:5px;">
		<div id="navpro">
		        <div class="links">
		          <ul>
		            <!--<li><img src="images/arrow.gif" /> <a href="dd-subscribe.php">Pricing Details for Subscription</a> </li>-->
		            <!--<li><img src="images/arrow.gif" /> <a href="advertise.htm">Advertise </a> </li>
		            <li><img src="images/arrow.gif" /> <a href="sponsor.htm">Sponsor</a></li>-->
		          </ul>
		        </div>
	  </div>
	    <div id="maintextpro">

        <div id="headingtextpro">
     	<div id="headingtextproboldfontcolor"> Private Equity Deal Database <br />  <br /> </div>

     	The Venture Intelligence <i> Private Equity Deal Database </i> lists cash-for-equity investments in India-based companies
     	by private equity and venture capital firms. The database also includes financial investments by
     	strategic investors which function similar to PE/VC firms and often co-invest with them. <br /><br />

		Each deal listed in this database typically includes the name of the investee company, its location,
		Industry & Sector it operates in, the investors involved, the amount and date. Wherever available,
		we also include information on the valuation and the advisors to the deal.<br /><br />

		Apart from the deal-by-deal listing, the database also provides aggregate private equity and
		venture capital statistics that includes data on deals that have been disclosed in confidence
		to Venture Intelligence. <Br /><Br />
		The database also features a listing of PE/VC exits, profiles of PE firms and PE/VC-backed companies. <br /><br />

<!--For pricing details <a target="_blank" href="dd-subscribe.php"><b>Click Here</b></a>.<Br /><Br />-->

		<!--<div id="headingtextprosmallfont">
		Note: The Venture Intelligence database is based on publicly announced / reported
		deals and data collected from Private Equity / Venture Capital / Investment Banking firms.
		The Venture Intelligence database is updated continuously and is therefore subject to change at any time.
		 </div> <br />-->

		<div id="headingtextproboldfontcolor"> Trial Login <br />  <br /> </div>
		Qualified investors, investment banks, law firms and other players in the deal ecosystem
		can request a trial login to our database free of cost for a limited time. Email us at
		<a href="mailto:info@ventureintelligence.com?subject=Request for Trial Login">info@ventureintelligence.com</a>. Or call us at +91-44-45534303 .




		</div>
        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom.js"></SCRIPT>
   </form>
   <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
  </script>
</body>
</html>
