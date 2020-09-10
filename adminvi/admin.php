<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
require("checkaccess.php");
	checkaccess( 'subscribers' );
 ////session_save_path("/tmp");
        session_save_path("/tmp");
	session_start();
       
	//if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
        if (isset($_SESSION["SessLoggedAdminPwd"]) && isset($_SESSION["SessLoggedIpAdd"]))
 	{
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">
function findCompanies()
{
	document.admin.action="admin.php";
	document.admin.submit();
}

function updateAuthentication()
{
	document.admin.action="adminauthenticate.php";
	document.admin.submit();
}

function updateDeletion()
{
	var chk;
	var e=document.getElementsByName("DelCompId[]");
	for(var i=0;i<e.length;i++)
	{
		chk=e[i].checked;
	//	alert(chk);
		if(chk==true)
		{
			e[i].checked=true;
			document.admin.action="companydelete.php";
			document.admin.submit();
			break;
		}
	}
		if (chk==false)
		{
			alert("Pls select one or more to delete");
			return false;
		}
}
</SCRIPT>

<link href="../css/vistyle.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="admin"  method="post" action="" >
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

	<div style="background-color:#FFF;width:565px; float:left; padding-left:2px;">
	  <div style=" width:565px; margin-top:4px;">
	    <div id="maintextpro">
		<?php


			//echo "<br>*******-".$_SESSION['SessLoggedAdminPwd'];
			$keyword="";
			$keyword=$_POST['companysearch'];
			$complikesearch = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
			if($complikesearch=="All")
			{
				$dealcompanySql="select * from dealcompanies where Deleted=0  order by DCompanyName";
				if ($companyrs = mysql_query($dealcompanySql))
				 {
					$company_cnt = mysql_num_rows($companyrs);
				 }
			}
			elseif(($complikesearch!="All") && ($complikesearch<>""))
			{
				$dealcompanySql="select * from dealcompanies where Deleted=0 and DCompanyName like '$complikesearch%' order by DCompanyName";
				if ($companyrs = mysql_query($dealcompanySql))
				 {
					$company_cnt = mysql_num_rows($companyrs);
				 }
			}
			elseif(trim($keyword)!="")
			{
				$dealcompanySql="select * from dealcompanies where Deleted=0 and DCompanyName like '$keyword%' order by DCompanyName";
				if ($companyrs = mysql_query($dealcompanySql))
				 {
					$company_cnt = mysql_num_rows($companyrs);
				 }
			}
			else
			{
				$dealcompanySql="select * from dealcompanies where Deleted=0 and DCompanyName like 'A%'order by DCompanyName";
				if ($companyrs = mysql_query($dealcompanySql))
				 {
					$company_cnt = mysql_num_rows($companyrs);
				 }
			}
		?>
        <div id="headingtextpro">
				Company&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
					<img src="../images/arrow.gif" />
					<input type=text name="companysearch" size=39> &nbsp;&nbsp;&nbsp;&nbsp;
				<input type="button"  value="Find" name="search"  onClick="findCompanies();">
				<br />

			<table border=0 align=center cellspacing=0 cellpadding=3 width=80%>
					<tr style="font-family: Verdana; font-size: 8pt">
					<td><a href="admin.php?value=All" > All </a> </td>
					<td> <a href="admin.php?value=A">A </a></td>
					<td><a href="admin.php?value=B">B </a></td>
					<td><a href="admin.php?value=C">C </a></td>
					<td> <a href="admin.php?value=D">D </a></td>
					<td> <a href="admin.php?value=E">E</a></td>
					<td> <a href="admin.php?value=F">F </a></td>
					<td> <a href="admin.php?value=G"> G</a></td>
					<td> <a href="admin.php?value=H">H </a></td>
					<td> <a href="admin.php?value=I">I</a></td>
					<td> <a href="admin.php?value=J">J</a></td>
					<td> <a href="admin.php?value=K"> K</a></td>
					<td> <a href="admin.php?value=L">L</a> </td>
					<td> <a href="admin.php?value=M"> M</a></td>
					<td> <a href="admin.php?value=N">N </a></td>
					<td> <a href="admin.php?value=O">O</a></td>
					<td> <a href="admin.php?value=P">P</a></td>
					<td>  <a href="admin.php?value=Q">Q</a></td>
					<td> <a href="admin.php?value=R">R </a></td>
					<td>  <a href="admin.php?value=S">S</a></td>
					<td> <a href="admin.php?value=T">T </a></td>
					<td> <a href="admin.php?value=U">U</a></td>
					<td> <a href="admin.php?value=V">V</a></td>
					<td > <a href="admin.php?value=W"> W</a></td>
					<td> <a href="admin.php?value=X">X </a></td>
					<td>  <a href="admin.php?value=Y">Y </a></td>
					<td>  <a href="admin.php?value=Z">Z </a></td>
					</tr>
		</table>

			<div style="width: 530px; height: 705px; overflow: auto;">
                            <table border="1" cellpadding="2" cellspacing="0" width="50%"  >

                                <tr style="font-family: Verdana; font-size: 8pt">
                                <th colspan=2 BGCOLOR="#FF6699" >Del</th>
                                <th>Status</th>
                                        <th width=35%>Company</th>
                                        <th>PE-Inv</th>
                                        <th>VC-Inv</th>
                                <!--	<th>RE</th> -->
                                        <th>PE-IPO</th>
                                        <th>VC-IPO</th>
                                        <th>PE-M&A</th>
                                        <th>VC-M&A</th>
                                        <th>PE-Dir </th>
                                        <th>VC-Dir</th>
                                        <th>SP-Dir</th>
                                        <th>LP-Dir</th>
                                        <!-- <th>PE-back</th>
                                        <th>VC-back</th>
                                        <th>MA-MA</th> -->

                                        <!--<th> </th> -->
                                </tr>

									<?php
										if ($company_cnt>0)
										{
											While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
											{
												$PEInv="";
												$VCInv="";
												//$REInv="";
												$PEIpo="";
												$VCIpo="";
												$PEMa="";
												$VCMa="";
												$PEDir="";
												$VCDir="";
												$SPDir="";
												$LPDir="";
												$PE_back="";
												$VC_back="";
												$Ma_Ma="";


												if( date('Y-m-d')<=$myrow["ExpiryDate"])
													{
														$expDate="";
														$bgcolors='<td BGCOLOR="#white"> ';
													}
												else
													{
														$expDate=$myrow["ExpiryDate"];
														$bgcolors='<td BGCOLOR="red">';
													}
												if($myrow["PEInv"]==1)
													$PEInv="checked";
												if($myrow["VCInv"]==1)
													$VCInv="checked";
												//if($myrow["REInv"]==1)
												//	$REInv="checked";
												if($myrow["PEIpo"]==1)
													$PEIpo="checked";
												if($myrow["VCIpo"]==1)
													$VCIpo="checked";
												if($myrow["PEMa"]==1)
													$PEMa="checked";
												if($myrow["VCMa"]==1)
													$VCMa="checked";
												if($myrow["PEDir"]==1)
													$PEDir="checked";
												if($myrow["VCDir"]==1)
													$VCDir="checked";
												if($myrow["SPDir"]==1)
													$SPDir="checked";
												if($myrow["LPDir"]==1)
													$LPDir="checked";
												/*if($myrow["PE_backDir"]==1)
													$PE_back="checked";
												if($myrow["VC_backDir"]==1)
													$VC_back="checked";
												if($myrow["MAMA"]==1)
													$Ma_Ma="checked";*/
									 ?>
									 			<tr style="font-family: Verdana; font-size: 8pt">
									 <?php
									 			if($myrow["TrialLogin"]==1)
												{
									?>

									 			<td align=center colspan=2 BGCOLOR="#FF6699"><input name="DelCompId[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" >
												<?php echo $bgcolors; ?><?php echo $expDate; ?> </td>
									<?php
												}
												else
												{
									?>
												<td align=center colspan=2 BGCOLOR="white"><input name="DelCompId[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" >
												<?php echo $bgcolors; ?><?php echo $expDate; ?> </td>
									<?php
												}
									?>
									 			<input type=hidden name="DCompId[]"  value="<?php echo $myrow["DCompId"]; ?>" ></td>
									 			<td>
									 			<a href="companyedit.php?value=<?php echo $myrow["DCompId"];?>" >  <?php echo $myrow["DCompanyName"]; ?>  </a>
												</td>

												<!--<td ><?php echo $myrow["DCompanyName"]; ?>&nbsp;</td> -->
												<td align=center><input name="PEInv[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $PEInv; ?>></td>
												<td align=center><input name="VCInv[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $VCInv; ?> ></td>
												<!--<td align=center><input name="RE[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $REInv; ?> ></td>-->
												<td align=center><input name="PEIpo[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $PEIpo; ?> ></td>
												<td align=center><input name="VCIpo[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $VCIpo; ?> ></td>
												<td align=center><input name="PEMa[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $PEMa; ?> ></td>
												<td align=center><input name="VCMa[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $VCMa; ?> ></td>
												<td align=center><input name="PEDir[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $PEDir; ?> ></td>
												<td align=center><input name="CODir[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $VCDir; ?> ></td>
												<td align=center><input name="SPDir[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $SPDir; ?> ></td>
												<td align=center><input name="LPDir[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $LPDir; ?> ></td>

												<!-- <td align=center><input name="PE_back[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $PE_back; ?> ></td>
												<td align=center><input name="VC_back[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $VC_back; ?> ></td>
												<td align=center><input name="MA_MA[]" type="checkbox" value=" <?php echo $myrow["DCompId"]; ?>" <?php echo $Ma_Ma; ?> ></td> -->



												<!--<td ><?php echo $myrow["DCompanyName"]; ?>&nbsp;</td> -->

												</tr>
									<?php
											}
										}
									?>
									</table>
							 </div>
								<span style="float:left; padding: 10px 0px 0px 0px;" class="one">
												<input type="button"  value="Delete Company" name="updateDelete"  onClick="updateDeletion();">
												</span>
                                                                <span style="float:right;padding: 10px 0px 0px 0px;" class="one">
												<input type="button"  value="Update Authentication" name="updateAuthenticate"  onClick="updateAuthentication();">
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