<?php
 require("../dbconnectvi.php");
			 $Db = new dbInvestments();
require("checkaccess.php");
	checkaccess( 'edit' );
 //session_save_path("/tmp");
	session_start();
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
		{

			$sesID=session_id();
			//echo "<br>peview session id--" .$sesID;
			
			$searchTitle = "List of RE Investors ";

			$invsearch=$_POST['investorsearch'];
			if(trim($invsearch)=="")
				$getinvSql="select * from REinvestors order by investor";
			elseif(trim($invsearch)!="")
				$getinvSql="select InvestorId,Investor from REinvestors where Investor like '%$invsearch%' order by Investor";


		//echo "<br>--" .$companysql;
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
<link href="../css/style_root.css" rel="stylesheet" type="text/css">

</head><body>

<form name="getinvestor"  method="post" >
<div id="containerproductpeview">
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
	  <div style="background-color:#FFF; width:565px; /*height:405px;*/ margin-top:5px;" class="main_content_container">
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
				              	$searchTitle= $searchTitle ." -- No Investor found for this search ";
				           }

		           ?>
						<div id="headingtextproboldfontcolor"> <?php echo $searchTitle; ?> <br />  <br /> </div>
					<?php
					if($company_cnt>0)
					{

					?>
						<!--<div id="tableContainer" class="tableContainer"> -->
					<div style="width: 542px; /*height:305px;*/ overflow: scroll;" class="content_container">
								<table border="1" cellpadding="3" cellspacing="0" width="100%"  >
								<tr><th>RE Investor</th></tr>
						<?php
						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
							 ?>
							<tr><Td>
							<A href="reinvestorprofileedit.php?value=<?php echo $myrow["InvestorId"];?> "
						   target="popup" onclick="MyWindow=window.open('reinvestorprofileedit.php?value=<?php echo $myrow["InvestorId"];?>', 'popup', 'scrollbars=1,width=600,height=500');MyWindow.focus(top);return false">
						  <?php echo $myrow["Investor"];?></a> </td>
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

		<div id="headingtextproboldbcolor">&nbsp; No. of Investors  - <?php echo $totalInv; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		</div>

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