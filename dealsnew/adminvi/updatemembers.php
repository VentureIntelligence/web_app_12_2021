<?php include_once("../../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
		session_start();
	//	if (session_is_registered("SessLoggedAdminPwd"))
	//	{
	//	//&& session_is_registered("SessLoggedIpAdd"))


?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">


</SCRIPT>

<link href="../style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="admin"  method="post" action="" >
<div id="containerproductproducts">
<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgproproducts">
		<div id="vertMenu">
		        	<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Import</span></div>
		      	</div>
		      <div id="linksnone">
			  			<a href="dealsinput.php">Investment Deals</a><br />
			  			<a href="companyinput.php">Profiles</a><br />
			  		  <!--<a href="investorinput.php">Investor Profile</a><br />-->
			  		</div>

			  		<div id="vertMenu">
			  			<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Edit</span></div>
			  		</div>
			  		<div id="linksnone">
			  			<a href="pegetdatainput.php">Deals / Profile</a><br />
			  			<a href="peadd.php">Add PE Inv </a> | <a href="ipoadd.php">IPO </a> | <a href="mandaadd.php">MandA  </a><br />

			  		</div>

			  		<div id="vertMenu">
			  			<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Subscribers</span></div>
			  		</div>
			  		<div id="linksnone">
			  			<a href="admin.php">Subscriber List</a><br />
			  			<a href="addcompany.php">Add Subscriber / Members</a><br />
			  			<a href="delcompanylist.php">List of Deleted Companies</a><br />
			  			<a href="delmemberlist.php">List of Deleted Emails</a><br />
			  			<a href="deallog.php">Log</a><br />
		</div>
				<div id="vertMenu">
					<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Exit</span></div>
				</div>
				<div id="linksnone"><a href="../adminlogoff.php">Logout</a><br />
		</div>

    </div>
   </div>
  <!-- Ending Left Panel -->
<!-- Starting Work Area -->

  <div style="width:570px; float:right; ">
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../top1.js"></SCRIPT>
  <SCRIPT>
   call()
   </script>

	<div style="width:565px; float:left; padding-left:2px;">
	  <div style="background-color:#FFF; width:565px; height:405px; margin-top:5px;">
	    <div id="maintextpro">
	     <div id="headingtextpro">

	        Updated members List : <Br /><br />
		 	 <div style="width: 542px; height: 300px; overflow: scroll;">
			<table border="1" cellpadding="2" cellspacing="0" width="100%"  >
		<?php
			$companyId=$_POST['compId'];
			$companyName= $_POST['companyname'];
			$expDate=$_POST['date'];
			$trial=$_POST['txtTrialLogin'];
			$relogin=$_POST['txtRELogin'];
			$student=$_POST['txtStudent'];
			$ipAdd=$_POST['txtIPAdd'];
			if($_POST['txtTrialLogin'])
			{
				$trial=1;
			}
			else
			{
				$trial=0;
			}
			if($_POST['txtStudent'])
			{
				$student=1;
			}
			else
			{
				$student=0;
			}
			if($_POST['txtRELogin'])
			{
				$relogin=1;
			}
			else
			{
				$relogin=0;
			}
                        if($_POST['txtIPAdd'])
			{
				$ipFlag=1;
			}
			else
			{
				$ipFlag=0;
			}
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
				$Inc=0;
				$angelInv=0;
				$sv=0;
				$itech=0;
				$ctech=0;
			$PEInvArray=$_POST['PEInv'];
			if($_POST['PEInv'])
				$PEInv=1;

			$VCInvArray=$_POST['VCInv'];
			if($_POST['VCInv'])
				$VCInv=1;

			$ReInvArray=$_POST['REInv'];
			if($_POST['REInv'])
				$REInv=1;

			$PEIpoArray=$_POST['PEIpo'];
			if($_POST['PEIpo'])
				$PEIpo=1;

			$VCIpoArray=$_POST['VCIpo'];
			if($_POST['VCIpo'])
				$VCIpo=1;

			$PEMaArray=$_POST['PEMa'];
			if($_POST['PEMa'])
				$PEMa=1;

			$VCMaArray=$_POST['VCMa'];
			if($_POST['VCMa'])
				$VCMa=1;

			$PEDirArray=$_POST['PEDir'];
			if($_POST['PEDir'])
				$PEDir=1;

			$CODirArray=$_POST['CODir'];
			if($_POST['CODir'])
				$CODir=1;

			$SPDirArray=$_POST['SPDir'];
			if($_POST['SPDir'])
				$SPDir=1;

			$MAMAArray=$_POST['MA_MA'];
			if($_POST['MA_MA'])
				$MaMa=1;

			$IncArray=$_POST['INC'];
			if($_POST['INC'])
				$Inc=1;
			$AngelInvArray=$_POST['AngelInv'];
			if($_POST['AngelInv'])
				$angelInv=1;

                        $SVArray=$_POST['SVInv'];
			if($_POST['SVInv'])
				$sv=1;
                        $IfArray=$_POST['IfTech'];
			if($_POST['IfTech'])
				$itech=1;
                        $CtArray=$_POST['CTech'];
			if($_POST['CTech'])
				$ctech=1;

			$MailsArray=$_POST['email'];
			$MailsArrayLength= count($MailsArray);
			$nameArray=$_POST['Nams'];
			//$nameArrayLength= count($nameArray);
			$NewMailArray=$_POST['Mails'];
			//$NewMailArrayLength= count($txtnameArray);
			$NewPwd=$_POST['Pwd'];

			$MAMailsArray=$_POST['emailMA'];
			$MAMailsArrayLength= count($MAMailsArray);
			$MAnameArray=$_POST['NamsMA'];
			$MANewMailArray=$_POST['MailsMA'];
			$MANewPwd=$_POST['PwdMA'];

			//echo "<br>----" .$MAMailsArrayLength;

			$REMailsArray=$_POST['emailRE'];
			$REMailsArrayLength= count($REMailsArray);
			$REnameArray=$_POST['NamsRE'];
			$RENewMailArray=$_POST['MailsRE'];
			$RENewPwd=$_POST['PwdRE'];

		//	echo "<Br>Companyid - " .$companyId;
		//	echo "<Br>Company - " .$companyName;
			$UpdateCompSql= "Update dealcompanies set DCompanyName='$companyName',ExpiryDate='$expDate',TrialLogin=$trial, PEInv=$PEInv,VCInv=$VCInv,REInv=$REInv,PEIpo=$PEIpo,VCIpo=$VCIpo,
				PEMa=$PEMa,VCMa=$VCMa,PEDir=$PEDir,VCDir=$CODir,SPDir=$SPDir,MAMA=$MaMa,Inc=$Inc,AngelInv=$angelInv,SVInv=$sv,IfTech=$itech,CTech=$ctech,
                                 Student=$student,REInv=$relogin,IPAdd=$ipFlag
				where DCompId=$companyId ";
			echo "<br>--" .$UpdateCompSql;
				if ($rsUpdateComp=mysql_query($UpdateCompSql))
				{
			?>
					<tr bgcolor="#FF6699" style="font-family: Verdana; font-size: 8pt">
					<td> <?php echo $companyName; ?> -- Company Name,Expiry Date change recorded </td> </tr>

				<?php
				}
			for ($i=0;$i<=$MailsArrayLength-1;$i++)
			{
			//	echo "<br>Mail id to Update" .$MailsArray[$i];
			//	echo "<Br> Name - " .$nameArray[$i];
			//	echo "<Br>New Email - ".$NewMailArray[$i];
			//	echo "<Br>New Pwd - ".$NewPwd[$i];
				$mailidtoUpdate = trim($MailsArray[$i]);
				$newEmail= trim($NewMailArray[$i]);

				$newPwd=trim($NewPwd[$i]);
				$UpdateMemberSql= "Update dealmembers set EmailId='$newEmail',Name='$nameArray[$i]',
				Passwrd='$newPwd' where Emailid='$mailidtoUpdate' ";
				//echo "<br>--" .$UpdateMemberSql;
				if ($companyrs=mysql_query($UpdateMemberSql))
				{
		?>
					<tr bgcolor="#00CC66" style="font-family: Verdana; font-size: 8pt">
					<td> <?php echo $MailsArray[$i]; ?> -- Updated (PE Login)</td> </tr>
		<?php
				}
				else
				{
		?>
					<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt">
					<td> <?php echo $MailsArray[$i]; ?> -- Update Failed (PE Login)</td> </tr>
				<?php
				}
			}

			// Merger login members
			for ($j=0;$j<=$MAMailsArrayLength-1;$j++)
			{
						//	echo "<br>Mail id to Update" .$MailsArray[$i];
						//	echo "<Br> Name - " .$nameArray[$i];
						//	echo "<Br>New Email - ".$NewMailArray[$i];
						//	echo "<Br>New Pwd - ".$MANewPwd[$j];
							$MAmailidtoUpdate = trim($MAMailsArray[$j]);
							$MAnewEmail= trim($MANewMailArray[$j]);

							$MAnewPwd=trim($MANewPwd[$j]);
			$MAUpdateMemberSql= "Update malogin_members set EmailId='$MAnewEmail',Name='$MAnameArray[$j]',
							Passwrd='$MAnewPwd' where Emailid='$MAmailidtoUpdate' ";
							//echo "<br>--" .$MAUpdateMemberSql;
							if ($MAcompanyrs=mysql_query($MAUpdateMemberSql))
							{
					?>
								<tr bgcolor="#00CC66" style="font-family: Verdana; font-size: 8pt">
								<td> <?php echo $MAMailsArray[$j]; ?> -- Updated (Merger Login)</td> </tr>
					<?php
							}
							else
							{
					?>
								<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt">
								<td> <?php echo $MAMailsArray[$j]; ?> -- Update Failed (Merger Login) </td> </tr>
							<?php
							}
			}

			//RE login members
			for ($k=0;$k<=$REMailsArrayLength-1;$k++)
			{

					$REmailidtoUpdate = trim($REMailsArray[$k]);
					$REnewEmail= trim($RENewMailArray[$k]);

					$REnewPwd=trim($RENewPwd[$k]);
					$REUpdateMemberSql= "Update RElogin_members set EmailId='$REnewEmail',Name='$REnameArray[$k]',
					Passwrd='$REnewPwd' where Emailid='$REmailidtoUpdate' ";
					echo "<br>--" .$MAUpdateMemberSql;
					if ($REcompanyrs=mysql_query($REUpdateMemberSql))
					{
			?>
						<tr bgcolor="#00CC66" style="font-family: Verdana; font-size: 8pt">
						<td> <?php echo $REMailsArray[$k]; ?> -- Updated (RE  Login)</td> </tr>
			<?php
					}
					else
					{
			?>
						<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt">
						<td> <?php echo $REMailsArray[$k]; ?> -- Update Failed (RE  Login) </td> </tr>
					<?php
					}
			}

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
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../../js/bottom1.js"></SCRIPT>
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
	//header( 'Location: https://www.ventureintelligence.com/logoff.php?value=P' ) ;

//} // if resgistered loop ends
//else
//	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>