<?php
/*
	Created Date- Apr-27-2010
	invoked from -  pegetdatainput.php
	invoked to - incedit.php on hyperlink of the company
*/
 require("../dbconnectvi.php");
			 $Db = new dbInvestments();
			 require("checkaccess.php");
	checkaccess( 'edit' );
 session_save_path("/tmp");
	session_start();
	include('pedelete_log.php');
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
		{

			$sesID=session_id();
			//echo "<br>peview session id--" .$sesID;
			
		$username= $_SESSION[ 'name' ];	 	
		$delPEIdArrayLength=0;
		$delPEId=$_POST['incId'];
		
		$delPEIdArrayLength= count($delPEId);
		if($delPEIdArrayLength>0)
		{
			foreach ($delPEId as $delPEIdtoDelete)
			{
				$updateSql="Update incubatordeals set Deleted=1 where IncDealId=".$delPEIdtoDelete ;
				if ($companyrs=mysql_query($updateSql))
				{
					insertlog($delPEIdtoDelete,"Inc",$username); 
			//		echo "<Br>--".$updateSql;
				}
			}
		}


				$searchTitle = "List of Incubator deals";
                 
			 $companysql = "SELECT pe.IncDealId,pec.PECompanyId,pe.IncubateeId,pec.companyname,
                         	pe.IncubatorId,incu.Incubator ,pe.Comment
				 FROM incubatordeals AS pe, pecompanies AS pec ,incubators as incu
				 WHERE pec.PEcompanyID = pe.IncubateeId and incu.IncubatorId=pe.IncubatorId
				 and pe.Deleted=0 order by companyname ";

		//echo "<br>--" .$companysql;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="language" content="en-us" />
<title>Venture Intelligence - Incubator</title>

<script type="text/javascript">
function updateDeletion()
{
	var chk;
	var e=document.getElementsByName("incId[]");
		for(var i=0;i<e.length;i++)
		{
			chk=e[i].checked;
		//	alert(chk);
			if(chk==true)
			{
				if (confirm("Are you sure you want to delete selected deals ? "))
				{
					e[i].checked=true;
					document.incdeals.action="getincdeals.php";
					document.incdeals.submit();
					break;
				}
			}
		}


	if (chk==false)
		{
			alert("Pls select one or more to delete");
			return false;
		}
}
</script>

<style type="text/css">


</style>
<link href="../css/style_root.css" rel="stylesheet" type="text/css">

</head><body>

<form name="incdeals"  method="post" >
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
	  <div style="background-color:#FFF; width:565px; /*height:405px;*/ margin-top:-5px;" class="main_content_container">
	    <div id="maintextpro">
        <div id="headingtextpro">

		<?php

				 	  // echo "<br> query final-----" .$companysql;
				 	      /* Select queries return a resultset */
						 if ($companyrs = mysql_query($companysql))
						 {
						    $company_cnt = mysql_num_rows($companyrs);
						 }
				           if($company_cnt > 0)
				           {
				           	//	$searchTitle=" List of M&A Exit Deals";
				           }
				           else
				           {
				              	$searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
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
								<tr>
										<th> Del </th>
										<th>Incubatee</th>
										<th>Incubator</th>

                                                                <tr>
						<?php
						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
									$comment=trim($myrow["Comment"]);
									if(trim($comment)=="")
									{
										$compDisplayOboldTag="";
										$compDisplayEboldTag="";
									}
									else
									{
										$compDisplayOboldTag="<b><i>";
										$compDisplayEboldTag="</b></i>";
									}
							 ?>
							 		<tr>
							 		<td align=center><input name="incId[]" type="checkbox" value=" <?php echo $myrow["IncDealId"]; ?>" ></td>

									<td><?php echo $compDisplayOboldTag ?>
									<A style="text-decoration:none" href="incdealedit.php?value=<?php echo $myrow["IncDealId"];?> "
								   target="popup" onclick="window.open('incdealedit.php?value=<?php echo $myrow["IncDealId"];?>', 'popup', 'scrollbars=1,width=500,height=500');return false">
								   <?php echo $myrow["companyname"]; ?>  &nbsp;<?php echo $compDisplayOboldTag ?>
									</A></td>


										<td><?php echo $myrow["Incubator"];?></td>

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
			<span style="float:left" class="one">
			<input type="button"  value="Delete Deal(s)" name="delDeal"  onClick="updateDeletion();" style="margin-right:10px;">
			</span> 
                        </form>
                        <form name="pelisting"  method="post" action="exportinc.php">

                            <input type="submit"  value="Export" name="showdeals">
                        </form><br /><br />
		</div>

		<div id="headingtextproboldbcolor">&nbsp; No. of Deals  - <?php echo $totalInv; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

		 <br /></div>

	        </div> <!-- end of maintext pro-->
	  </div>
	  </div>
	</div>
  </div>
  <!-- Ending Work Area -->

</div>
   <SCRIPT LANGUAGE="JavaScript1.2" SRC="../js/bottom1.js"></SCRIPT>

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
