<?php include_once("../../globalconfig.php"); ?>
<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
 	session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
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

<link href="../style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="deletemember"  method="post" action="" >
<div id="containerproductproducts">
<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgproproducts">
		<div id="vertMenu">
					<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Import</span></div>
				</div>
				<div id="linksnone">
					<a href="dealsinput.php">Investment Deals</a> | <a href="companyinput.php">Profiles</a><br />

				  <!--<a href="investorinput.php">Investor Profile</a><br />-->
				</div>

				<div id="vertMenu">
					<div><img src="../images/dot1.gif" />&nbsp;<span class="linkhover">&nbsp;Edit</span></div>
				</div>
				<div id="linksnone">
					<a href="pegetdatainput.php">Deals / Profile</a><br />
					<a href="peadd.php">Add PE Inv </a> | <a href="ipoadd.php">IPO </a> | <a href="mandaadd.php">MandA  </a> | <a href="mamaadd.php">MA </a><br />

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
				<div id="linksnone">
					<a href="../adminlogoff.php">Logout</a><br />
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

	    Deleted members List : <Br /><br />
	    Deleted members will no longer be visible for use .To activate a member, Please go to <b>Deleted Emails </b> page.<br /><br />
	    	<div style="width: 542px; height: 300px; overflow: scroll;">
			<table border="1" cellpadding="2" cellspacing="0" width="100%"  >


		<?php
			$DeleteEmailId=$_POST['DelEmailId'];
			$DeleteEmailArrayLength=count($DeleteEmailId);
			$MADeleteEmailId=$_POST['MADelEmailId'];
			$MDeleteEmailArrayLength=count($MADeleteEmailId);
			$REDeleteEmailId=$_POST['REDelEmailId'];
			$RDeleteEmailArrayLength=count($REDeleteEmailId);
		//	echo "<br>**********".$MDeleteEmailArrayLength;

			for ($i=0;$i<=$DeleteEmailArrayLength-1;$i++)
			{
				$mailid=trim($DeleteEmailId[$i]);
				$delMemberSql="delete from dealmembers where Emailid='$mailid'";
				//$delMemberSql= "Update dealmembers set Deleted=1 where 					//Emailid='$mailid' ";
			//	echo "<Br>--" .$delMemberSql;
				if ($companyrs=mysql_query($delMemberSql))
				{
		?>
					<tr bgcolor="#00CC66" style="font-family: Verdana; font-size: 8pt">
					<td> <?php echo $mailid; ?> -- Deleted (PE login)</td> </tr>
		<?php
				}
				else
				{
		?>
					<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt">
					<td> <?php echo $mailid; ?> -- Delete Failed (PE login)</td> </tr>
				<?php
				}
			}


			for ($j=0;$j<=$MDeleteEmailArrayLength-1;$j++)
					{
						$MAmailid=trim($MADeleteEmailId[$j]);
						$MAdelMemberSql="delete from malogin_members where Emailid='$MAmailid'";
						//echo "<Br>--" .$MAdelMemberSql;
						if ($MAcompanyrs=mysql_query($MAdelMemberSql))
						{
				?>
							<tr bgcolor="#00CC66" style="font-family: Verdana; font-size: 8pt">
							<td> <?php echo $MAmailid; ?> -- Deleted (MA login)</td> </tr>
				<?php
						}
						else
						{
				?>
							<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt">
							<td> <?php echo $MAmailid; ?> -- Delete Failed (Merger login)</td> </tr>
						<?php
						}
					}

				// re login
			for ($k=0;$k<=$RDeleteEmailArrayLength-1;$k++)
					{
						$REmailid=trim($REDeleteEmailId[$k]);
						$REdelMemberSql="delete from RElogin_members where Emailid='$REmailid'";
					//	echo "<Br>--" .$REdelMemberSql;
						if ($REcompanyrs=mysql_query($REdelMemberSql))
						{
				?>
							<tr bgcolor="#00CC66" style="font-family: Verdana; font-size: 8pt">
							<td> <?php echo $REmailid; ?> -- Deleted (RE login)</td> </tr>
				<?php
						}
						else
						{
				?>
							<tr bgcolor="red" style="font-family: Verdana; font-size: 8pt">
							<td> <?php echo $REmailid; ?> -- Delete Failed (RE login)</td> </tr>
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

} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>