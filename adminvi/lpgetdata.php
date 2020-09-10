<?php
require("../dbconnectvi.php");
			 $Db = new dbInvestments();
			require("checkaccess.php");
			checkaccess( 'edit' );
 //session_save_path("/tmp");
	session_start();
	//include('pedelete_log.php');
		if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
		{

			$sesID=session_id();
			//echo "<br>peview session id--" .$sesID;
			 
		$username= $_SESSION[ 'name' ];	 
		$delPEIdArrayLength=0;
		$delPEId=$_POST['LPId'];
		$delPEIdArrayLength= count($delPEId);
		
		if($delPEIdArrayLength>0)
		{
			foreach ($delPEId as $delPEIdtoDelete)
			{
				$updateSql="Update limited_partners set Deleted=1 where LPId=".$delPEIdtoDelete ;
				if ($companyrs=mysql_query($updateSql))
				{
					//insertlog($delPEIdtoDelete,"PE",$username);
				     echo "<Br>--".$updateSql;
				}
			}
		}
	
					$searchTitle = "List of LP Directory ";

				
				$companysql="select * from limited_partners where Deleted = 0";
		//echo "<br>--" .$companysql;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta http-equiv="language" content="en-us" />
<title>Venture Intelligence - PE Investments</title>

<script type="text/javascript">
function updateDeletion()
{
	var chk;
	var e=document.getElementsByName("LPId[]");
		for(var i=0;i<e.length;i++)
		{
			chk=e[i].checked;
		//	alert(chk);
			if(chk==true)
			{
				if (confirm("Are you sure you want to delete selected deals ? "))
				{
					e[i].checked=true;
					document.pegetdata.action="lpgetdata.php";
					document.pegetdata.submit();
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
	  <div style="background-color:#FFF; width:565px; height:1000px;overflow-y-scroll; margin-top:5px;" class="main_content_container">
	    <div id="maintextpro">
        <div id="headingtextpro">
            <form name="pegetdata"  method="post" >
		<!-- <input type="hidden" name="month1" value="<?php echo $month1;?>"
		<input type="hidden" name="year1" value="<?php echo $year1;?>"
		<input type="hidden" name="month2" value="<?php echo $month2;?>"
		<input type="hidden" name="year2" value="<?php echo $year2;?>"
		<input type="hidden" name="pe_or_re"" value="PE" > -->

		<?php

				 	  // echo "<br> query final-----" .$companysql;
				 	      /* Select queries return a resultset */
						 if ($companyrs = mysql_query($companysql))
						 {
						    $company_cnt = mysql_num_rows($companyrs);
						 }
				           if($company_cnt > 0)
				           {
				           	//	$searchTitle=" List of Deals";
				           }
				           else
				           {
				              	$searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
				           }

		           ?>
						<div id="headingtextproboldfontcolor"> <?php echo $searchTitle; ?>
                                               <!-- <input type="button" value="Financials" border=0 bgcolor='#D0A9F5' > &nbsp;&nbsp;&nbsp;<input type="button" value="Fin Link">
                                                 -->
                                                 <br />  <br /> </div>
					<?php
					if($company_cnt>0)
					{

					?>
						
					<div style="width: 542px; height:850px; overflow: auto;" class="content_container">
								<table border="1" cellpadding="3" cellspacing="0" width="100%"  >
								<tr>
										<th> Delete </th>
                                                                              <!--   <th> Hide Agg </th> -->
										<th>Institution Name</th>
										<th>Contact Person</th>
										<th>Designation</th>
										
									</tr>
						<?php
						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
                                                         //marking with color if the column is empty
                                                          /*$bgcolor="#FFF";    //white
                                                                        if(trim($myrow["uploadfilename"])!="")
                                                                           $bgcolor="#D0A9F5";
                                                                        if(trim($myrow["FinLink"])!=="")
                                                                           $bgcolor="#F5A9F2";

									$comment=trim($myrow["comment"]);
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
									if($myrow["AggHide"]==1)
									{
										$openBracket="(";
										$closeBracket=")";
									}
									else
									{
										$openBracket="";
										$closeBracket="";
									}*/
							 ?>
							 		<tr>
							 		<td align=center><input name="LPId[]" type="checkbox" value=" <?php echo $myrow["LPId"]; ?>" ></td>
                                                                       
									<td><a style="text-decoration:none" href="lpeditdata.php?value=PE-<?php echo $myrow["LPId"];?> "
								   target="popup" onclick="window.open('lpeditdata.php?value=LP-<?php echo $myrow["LPId"];?>', 'popup', 'scrollbars=1,width=600,height=500');return false"><?php echo $myrow["InstitutionName"]; ?> </a></td>
									<td><?php echo $myrow["ContactPerson"];?></td>
									<td align=right ><?php echo $myrow["Designation"]; ?>&nbsp;</td>
										
									 </tr>
							<?php
								/*$totalInv=$totalInv+1;
								$totalAmount=$totalAmount+ $myrow["amount"];*/
							}

						?>
					 </table>
					</div>

		<?php
					}
		?>
			<span style="float:left;margin-top: 15px;" class="one" >
                            <input type="button"  value="Delete Directory(s)" name="delDeal"  onClick="updateDeletion();">
                            <!-- <input type="button"  value="Hide for Aggregate" name="aggHideDeal"  onClick="aggHide();"> -->
                        </span>
                   </form>
                   <span style="float:left;margin-left:3px;">
                        <form name="pelisting"  method="post" action="exportpeinv.php">
                            <input type="hidden" name="month1" value=<?php echo $month1; ?> >
                            <input type="hidden" name="month2" value=<?php echo $month2; ?> >
                            <input type="hidden" name="year1" value=<?php echo $year1; ?> >
                            <input type="hidden" name="year2" value=<?php echo $year2; ?> >
                            <!-- <input type="submit"  value="Export" name="showdeals"> -->
                        </form>
                    </span> <br /><br />
		</div>

		

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