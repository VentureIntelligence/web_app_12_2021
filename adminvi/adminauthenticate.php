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
<form name="admin"  method="post" action="" >
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

	    Update Results: <Br /> <br />
	    	<div style="width: 542px; height: 300px; overflow: scroll;">
			<table border="1" cellpadding="2" cellspacing="0" width="100%"  >


		<?php
			$CompId=$_POST['DCompId'];

			$PEInvArray=$_POST['PEInv'];
			$PEInvArrayLength= count($PEInvArray);

			$VCInvArray=$_POST['VCInv'];
			$VCInvArrayLength= count($VCInvArray);

			$ReInvArray=$_POST['RE'];
			$ReInvArrayLength= count($ReInvArray);

			$PEIpoArray=$_POST['PEIpo'];
			$PEIpoArrayLength= count($PEIpoArray);

			$VCIpoArray=$_POST['VCIpo'];
			$VCIpoArrayLength= count($VCIpoArray);

			$PEMaArray=$_POST['PEMa'];
			$PEMaArrayLength= count($PEMaArray);

			$VCMaArray=$_POST['VCMa'];
			$VCMaArrayLength= count($VCMaArray);

			$PEDirArray=$_POST['PEDir'];
			$PEDirArrayLength= count($PEDirArray);

			$CODirArray=$_POST['CODir'];
			$CODirArrayLength= count($CODirArray);

			$SPDirArray=$_POST['SPDir'];
			$SPDirArrayLength= count($SPDirArray);

			$MAMAArray=$_POST['MA_MA'];
			$MAMAArrayLength=count($MAMAArray);

			$LPDirArray=$_POST['LPDir'];
			$LPDirArrayLength= count($LPDirArray);


			foreach ($CompId as $companyId)
			{
				$PEInv=0;
				$VCInv=0;
				$REInv=0;
				$PEIpo=0;
				$VCIpo=0;
				$PEMa=0;
				$VCMa=0;
				$PEDir=0;
				$CODir=0;
				$SPDir=0;
				$MaMa=0;
				$LPDir=0;

				$CompanyIdtoUpdate=$companyId;
				$getCompNameSql ="Select DCompanyName from dealcompanies where DCompId=$CompanyIdtoUpdate ";
				if($rsgetname =mysql_query($getCompNameSql))
				{

					While($myrow=mysql_fetch_array($rsgetname, MYSQL_BOTH))
					{
						$CompanyName=$myrow["DCompanyName"];
					}
				}
				for ($i=0;$i<=$PEInvArrayLength-1;$i++)
				{
					if(in_array($CompanyIdtoUpdate,$PEInvArray))
					{
						//if set to check - set 1 in the table for that DCompId
						$PEInv=1;
					}
				}
				for ($j=0;$j<=$VCInvArrayLength-1;$j++)
				{
					if(in_array($CompanyIdtoUpdate,$VCInvArray))
					{
						//if set to check - set 1 in the table for that DCompId
						$VCInv=1;
					}
				}
				for ($k=0;$k<=$ReInvArrayLength-1;$k++)
				{
					if(in_array($CompanyIdtoUpdate,$ReInvArray))
					{
						//if set to check - set 1 in the table for that DCompId
						$REInv=1;
					}
				}
				for ($l=0;$l<=$PEIpoArrayLength-1;$l++)
				{
					if(in_array($CompanyIdtoUpdate,$PEIpoArray))
					{
						//if set to check - set 1 in the table for that DCompId
						$PEIpo=1;
					}
				}
				for ($m=0;$m<=$VCIpoArrayLength-1;$m++)
				{
					if(in_array($CompanyIdtoUpdate,$VCIpoArray))
					{
						//if set to check - set 1 in the table for that DCompId
						$VCIpo=1;
					}
				}
				for ($n=0;$n<=$PEMaArrayLength-1;$n++)
				{
					if(in_array($CompanyIdtoUpdate,$PEMaArray))
					{
						//if set to check - set 1 in the table for that DCompId
						$PEMa=1;
					}
				}
				for ($p=0;$p<=$VCMaArrayLength-1;$p++)
				{
					if(in_array($CompanyIdtoUpdate,$VCMaArray))
					{
						//if set to check - set 1 in the table for that DCompId
						$VCMa=1;
					}
				}
				for ($q=0;$q<=$PEDirArrayLength-1;$q++)
				{
					if(in_array($CompanyIdtoUpdate,$PEDirArray))
					{
						//if set to check - set 1 in the table for that DCompId
						$PEDir=1;
					}
				}
				for ($r=0;$r<=$CODirArrayLength-1;$r++)
				{
					if(in_array($CompanyIdtoUpdate,$CODirArray))
					{
						//if set to check - set 1 in the table for that DCompId
						$CODir=1;
					}
				}
				for ($s=0;$s<=$SPDirArrayLength-1;$s++)
				{
					if(in_array($CompanyIdtoUpdate,$SPDirArray))
					{
						//if set to check - set 1 in the table for that DCompId
						$SPDir=1;
					}
				}
			for ($t=0;$t<=$MAMAArrayLength-1;$t++)
				{
					if(in_array($CompanyIdtoUpdate,$MAMAArray))
					{
						//if set to check - set 1 in the table for that DCompId
						$MaMa=1;
					}
				}
				for ($u=0;$u<=$LPDirArrayLength-1;$u++)
				{
					if(in_array($CompanyIdtoUpdate,$LPDirArray))
					{
						//if set to check - set 1 in the table for that DCompId
						$LPDir=1;
					}
				}
				//$updateSql="Update dealcompanies set PEInv=$PEInv,VCInv=$VCInv,REInv=$REInv,PEIpo=$PEIpo,VCIpo=$VCIpo,PEMa=$PEMa,VCMa=$VCMa,PEDir=$PEDir,VCDir=$CODir,SPDir=$SPDir,MAMA=$MaMa where DCompId=".$CompanyIdtoUpdate ;
                                $updateSql="Update dealcompanies set PEInv=$PEInv,VCInv=$VCInv,PEIpo=$PEIpo,VCIpo=$VCIpo,PEMa=$PEMa,VCMa=$VCMa,PEDir=$PEDir,VCDir=$CODir,SPDir=$SPDir,MAMA=$MaMa,LPDir=$LPDir where DCompId=".$CompanyIdtoUpdate ;
				//echo "<br>--" .$updateSql;
				if ($companyrs=mysql_query($updateSql))
				{
		?>
					<tr bgcolor="#00CC66" style="font-family: Verdana; font-size: 8pt">
					<td> <?php echo $CompanyName; ?> -- Updated </td> </tr>
		<?php
				}
				else
				{
		?>
					<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt">
					<td> <?php echo $CompanyName; ?> -- Updation Failed </td> </tr>
		<?php
				}
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