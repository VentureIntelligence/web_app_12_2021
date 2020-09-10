<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
	require("checkaccess.php");
	checkaccess( 'subscribers' );
 session_save_path("/tmp");
	session_start();
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
 	{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">

</SCRIPT>

<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="admin"  method="post" action="activatecompanies.php" >
<div id="containerproductproducts">
<!-- Starting Left Panel -->
<?php include_once('leftpanel.php'); ?>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; /*height:542px;*/ margin-top:4px;" class="main_content_container">
	    <div id="maintextpro">
		<?php
				$delCompanyListSql="select * from dealcompanies where Deleted=1 order by DCompanyName";
				if ($companyrs = mysql_query($delCompanyListSql))
				 {
					$company_cnt = mysql_num_rows($companyrs);
				 }

		?>
        <div id="headingtextpro">
			Following are the list of deleted Companies. To activate, please select and press 'Activate' button. <br /><br />
			Members for that company will automatically be made active.
			<br /><br />

				<div style="width: 542px; /*height: 280px;*/ overflow: scroll;" class="content_container">
					<table border="1" cellpadding="2" cellspacing="0" width="60%"  >
					<tr style="font-family: Verdana; font-size: 8pt">
					<th BGCOLOR="#FF6699" >Activate</th>
						<th width=75%>Company</th>

					</tr>

					<?php
						if ($company_cnt>0)
						{
							While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
					 ?>
					 			<tr style="font-family: Verdana; font-size: 8pt">
					 			<td align=center  BGCOLOR="#FF6699"><input name="ActCompId[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" >
					 			<td>  <?php echo $myrow["DCompanyName"]; ?>
								</td>
								</tr>
					<?php
							}
						}
					?>
					</table>
				</div>

				<span style="float:right" class="one">
				<input type="submit"  value="Activate" name="makeActivate" >
				</span>

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
	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>