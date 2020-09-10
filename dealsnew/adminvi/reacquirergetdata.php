<?php include_once("../../globalconfig.php"); ?>
<?php
 	session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
		{

			$sesID=session_id();
			//echo "<br>peview session id--" .$sesID;
			 require("../dbconnectvi.php");
			 $Db = new dbInvestments();

			$searchTitle = "List of RE Acquirer(s) ";

			$acqsearch=$_POST['acquirersearch'];
			if(trim($acqsearch)=="")
				$getinvSql="select ma.AcquirerId,ac.Acquirer from REacquirers as  ac,
				REmanda as ma where ac.AcquirerId=ma.AcquirerId ";
			elseif(trim($acqsearch)!="")
				$getinvSql="select AcquirerId,Acquirer from REacquirers where Acquirer like '%$acqsearch%' order by Acquirer";


		//echo "<br>--" .$getinvSql;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="language" content="en-us" />
<title>Venture Intelligence - Investor</title>

<script type="text/javascript">

</script>

<style type="text/css">


</style>
<link href="../style.css" rel="stylesheet" type="text/css">

</head><body>

<form name="getacquire"  method="post" >
<div id="containerproductpeview">
<!-- Starting Left Panel -->
  <div id="leftpanel">
    <div><a href="index.htm"><img src="../images/logo.jpg" width="183" height="98" border="0"></a></div>
    <div id="vertbgpropeview">
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
						<a href="peadd.php">Add PE Inv </a> | <a href="ipoadd.php">IPO </a> | <a href="mandaadd.php">MandA  </a> | <a href="mamaadd.php">MA  </a><br />

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
		<input type="hidden" name="month1" value="<?php echo $month1;?>"
		<input type="hidden" name="year1" value="<?php echo $year1;?>"
		<input type="hidden" name="month2" value="<?php echo $month2;?>"
		<input type="hidden" name="year2" value="<?php echo $year2;?>"
		<?php
					$totalInv=0;
				 	  // echo "<br> query final-----" .$getcompSql;
				 	      /* Select queries return a resultset */
						 if ($companyrs = mysql_query($getinvSql))
						 {
						    $company_cnt = mysql_num_rows($companyrs);
						 }
				           if($company_cnt > 0)
				           {
				           	//	$searchTitle=" List of Deals";
				           }
				           else
				           {
				              	$searchTitle= $searchTitle ." -- No Acquirer found for this search ";
				           }

		           ?>
						<div id="headingtextproboldfontcolor"> <?php echo $searchTitle; ?> <br />  <br /> </div>
					<?php
					if($company_cnt>0)
					{

					?>
						<!--<div id="tableContainer" class="tableContainer"> -->
					<div style="width: 542px; height:305px; overflow: scroll;">
								<table border="1" cellpadding="3" cellspacing="0" width="100%"  >
								<tr><th> Acquirer</th></tr>
						<?php
						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
							 ?>
							<tr><Td>
							<A href="reacquirerprofileedit.php?value=<?php echo $myrow["AcquirerId"];?> "
						   target="popup" onclick="MyWindow=window.open('reacquirerprofileedit.php?value=<?php echo $myrow["AcquirerId"];?>', 'popup', 'scrollbars=1,width=600,height=500');MyWindow.focus(top);return false">
						  <?php echo $myrow["Acquirer"];?></a> </td>
						</tr>
							<?php
								$totalInv=$totalInv+1;
							}
						?>
					 </table>
					</div>

		<?php
					}
		?>

		</div>

		<div id="headingtextproboldbcolor">&nbsp; No. of Acquirers  - <?php echo $totalInv; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</div>

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