<?php include_once("../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
 session_save_path("/tmp");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
 	{
	//	$username=$_SESSION['UserNames'];
	//	$emailid=$_SESSION['UserEmail'];

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">


</SCRIPT>

<link href="../css/style_root.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="companydelete"  method="post" action="" >
<div id="containerproductproducts">
<!-- Starting Left Panel -->
<?php include_once('leftpanel.php'); ?>
<!--  <div id="leftpanel">
    <div><a href="index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgproproducts">
		<div id="vertMenu">
		        	<div><img src="images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Import</span></div>
		      	</div>
		      	<div id="linksnone"><a href="dealsinput.php">Investment Deals</a><br />
		          <span id="visitlink">
		          <a href="companyinput.php">Company Profile</a><br />
		          </span>
		          <a href="investorinput.php">Investor Profile</a><br />
				</div>

					<div id="vertMenu">
						<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Edit</span></div>
					</div>
					<div id="linksnone"><a href="pegetdatainput.php">Investments</a><br />
								<a href="pegetdatainput.php">Company / Investor Profile</a><br />

			</div>

				<div id="vertMenu">
					<div><img src="images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Companies</span></div>
				</div>
				<div id="linksnone"><a href="admin.php">Company List</a><br />
				  <span id="visitlink">
				  <a href="addcompany.php">Add Company / Members</a><br />
				  </span>
				  <a href="delcompanylist.php">List of Deleted Companies</a><br />
                                    <a href="delmemberlist.php">List of Deleted Emails</a><br />
				</div>

				<div id="vertMenu">
					<div><img src="images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Exit</span></div>
				</div>
				<div id="linksnone"><a href="../adminlogoff.php">Logout</a><br />
		</div>

    </div>
   </div>-->
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">

	  <div style="background-color:#FFF; width:565px; height:405px; margin-top:5px;">

	    <div id="maintextpro">
	    <div id="headingtextpro">

			 The following Companies have been activated :  <Br /> <br />
	    	<div style="width: 542px; height: 300px; overflow: scroll;">
			<table border="1" cellpadding="2" cellspacing="0" width="100%"  >


		<?php
			$CompId=$_POST['ActCompId'];

				foreach ($CompId as $companyId)
				{
					$getCompName= "select DCompanyName from dealcompanies where DCompId=" .$companyId;


					if ($companyrs=mysql_query($getCompName))
					{
						While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
						{
							$CompanyName=$myrow["DCompanyName"];
						}
					}

					$updateSql="Update dealcompanies set Deleted=0 where DCompId=".$companyId ;
					//echo "<Br>&&&&&&&&&&&&" .updateSql;
					if ($companyrs=mysql_query($updateSql))
					{
						$updateMembersSql="Update dealmembers set Deleted=0 where DCompId=".$companyId ;
						if ($rsmembers=mysql_query($updateMembersSql))
						{

			?>
							<tr bgcolor="#00CC66" style="font-family: Verdana; font-size: 8pt">
							<td> <?php echo $CompanyName; ?> -- Activated </td> </tr>
			<?php
						}
						else
						{
				?>
							<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt">
							<td> <?php echo $CompanyName; ?> -- Activation Failed </td> </tr>
			<?php
						}
					} //if loop ends
				} //for each loop ends

			?>

				</table>
				</div>


		</div><!-- end of headingtextpro-->
        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>
   </form>

   <script src="http://www.google-analytics.com/urchin.js" type="text/javascript">
     </script>
     <script type="text/javascript">
     _uacct = "UA-1492351-1";
     urchinTracker();
  </script>

</body>
</html>
<?php

} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>