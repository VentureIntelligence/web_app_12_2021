<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{

?>
<html><head>
<title>RE Acquirer Profile</title>
<SCRIPT LANGUAGE="JavaScript">


</SCRIPT>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=editacqprofile method=post action="reacquirerprofileeditupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=100%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

	$SelCompRef=$value;
   	$getDatasql = "SELECT AcquirerId,Acquirer,IndustryId,Sector,Stockcode,Address,Address1,CityId,Zip,
   	acq.countryid,c.country,Telephone,Fax,Email,Website,
   	OtherLocations,AdditionalInfor FROM REacquirers as acq,country as c WHERE
   	acq.AcquirerId=$SelCompRef and c.countryid=acq.countryid";
//echo "<br>--" .$getDatasql;
	if ($companyrs = mysql_query($getDatasql))
	{
		$company_cnt = mysql_num_rows($companyrs);
	}
	  if($company_cnt > 0)
	{
		While($mycomprow=mysql_fetch_array($companyrs, MYSQL_BOTH))
		{
?>
		   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Edit Acquirer Profile</b></td></tr>
				<tr>

				<!-- InvestorId -->
				<td  style="font-family: Verdana; font-size: 8pt" align=left>
				<input type="hidden" name="txtAcquirerId" size="10" value="<?php echo $mycomprow["AcquirerId"]; ?>"> </td>
				</tr>

				<tr style="font-family: Verdana; font-size: 8pt">
				<td >Acquirer</td>
				<td><input type="text" name="txtname" size="50" value="<?php echo $mycomprow["Acquirer"]; ?>"> </td>
				</tr>

				<tr>
				<td>Industry</td>
				<td > <SELECT name="industry">

				<?php

					$industrysql = "select i.industryid,i.industry  from industry as i	order by i.industry";
					if ($industryrs = mysql_query( $industrysql))
					{
					  $ind_cnt = mysql_num_rows($industryrs);
					}
					if($ind_cnt > 0)
					{
						While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
						{
							$id = $myrow[0];
							$name = $myrow[1];
							if ($id==$mycomprow[2])
							{
								echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
							}
							else
							{
								echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
							}
						}
						mysql_free_result($industryrs);
					}

				?>
				</select> </td> </tR>
				<tr><td>Sector </td>
				<td><input type="text" name="txtsector" size="50" value="<?php echo $mycomprow["Sector"]; ?>"> </td>
				</tr>


				<tr><td >StockCode </td>
								<td><textarea name="txtstockcode" rows="2" cols="50"><?php echo $mycomprow["StockCode"]; ?> </textarea> </td>
				</tr>

				<tr><td >Address </td>
				<td><textarea name="txtaddress1" rows="2" cols="50"><?php echo $mycomprow["Address"]; ?> </textarea> </td>
				</tr>
				<tr><td >&nbsp; </td>
				<td >
				<input type="text" name="txtaddress2" size="50" value="<?php echo $mycomprow["Address1"]; ?>">
				</td>
				</tr>
				<tr><td >City</td>
				<td>
				<input type="text" name="txtadcity" size="50" value="<?php echo $mycomprow["CityId"]; ?>"> </td>
				</tr>

				<tr>
					<td>Country</td>
					<td > <SELECT name="country">

					<?php

						$countrysql = "select i.countryid,i.country  from country as i";
						if ($countryrs = mysql_query($countrysql))
						{
						  $ind_cnt = mysql_num_rows($countryrs);
						}
						if($ind_cnt > 0)
						{
							While($myrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
							{
								$id = $myrow[0];
								$name = $myrow[1];
								if ($id==$mycomprow[9])
								{
									echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
								}
								else
								{
									echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
								}
							}
							mysql_free_result($countryrs);
						}

					?>
				</select> </td> </tR>

				<tr><td >Zip</td>
				<td>
				<input type="text" name="txtzip" size="50" value="<?php echo $mycomprow["Zip"]; ?>"> </td>
				</tr>
				<tr><td >Telephone</td>
				<td>
				<input type="text" name="txttelephone" size="50" value="<?php echo $mycomprow["Telephone"]; ?>"> </td>
				</tr>
				<tr><td >Fax</td>
				<td>
				<input type="text" name="txtfax" size="50" value="<?php echo $mycomprow["Fax"]; ?>"> </td>
				</tr>
				<tr><td >Email</td>
				<td><textarea name="txtemail" rows="2" cols="50"><?php echo $mycomprow["Email"]; ?> </textarea> </td>
				</tr>
				<tr><td >Website</td>
				<td>
				<input type="text" name="txtwebsite" size="50" value="<?php echo $mycomprow["Website"]; ?>"> </td>
				</tr>

				<tr><td >Other Location(s)</td>
				<td><textarea name="txtotherlocation" rows="2" cols="50"><?php echo $mycomprow["OtherLocations"]; ?> </textarea> </td>
				</tr>

				<tr><td >More Info</td>
				<td><textarea name="txtaddinfor" rows="2" cols="50"><?php echo $mycomprow["AdditionalInfor"]; ?> </textarea> </td>
				</tr>

					<tr>
					<td>Management
					<input type="button" value="Add Executive" name="btnaddmgmt"
					onClick="window.open('addreAcquirerMgmt.php?value=<?php echo $SelCompRef;?>','mywindow','width=400,height=400')">

					</td>
					<td valign=top style="font-family: Verdana; font-size: 8pt" align=left>
					<table border=1 width=100% cellpadding=1 cellspacing=0>

					<?php
					$strManagement="";
					 $getInvestorsSql="select peinv.AcquirerId,peinv.ExecutiveId,e.ExecutiveName,e.Designation,e.Company from
					 REacquirer_management as peinv,
					 executives as e where e.ExecutiveId=peinv.ExecutiveId and peinv.AcquirerId=$SelCompRef";

					  if ($rsinvestors = mysql_query($getInvestorsSql))
					  {
						While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
						{
							$strManagement=$strManagement.", ".$myInvrow["ExecutiveName"];
							if(trim($myInvrow["Designation"])!="")
								$strManagement=$strManagement.", ".$myInvrow["Designation"];
							if(trim($myInvrow["Company"])!="")
								$strManagement=$strManagement.", ".$myInvrow["Company"];
						  $strManagement =substr_replace($strManagement, '', 0,1);

							//$strManagement=$strManagement.";";
						?>
					<tr style="font-family: Verdana; font-size: 8pt" >
					<td valign=top width="20" >
					<input name="txtmgmtExecutiveId[]" type="text" size="10" value=" <?php echo $myInvrow["ExecutiveId"]; ?>"  >
					</td>
					<td> <input type="text" name="txtmgmtExecutiveName[]"  size="50" value="<?php echo trim($strManagement); ?> "> </td>
					</tr>

					<?php
						$strManagement="";
						}

					?>
						<!--<tr><td valign=top >
						<td valign=top><textarea name="txtboard" rows="2" cols="50"><?php echo trim($strManagement); ?> </textarea> </td>
						</tr> -->

					<?php
					}
					?>
					</table>
					</td>
				</tr>


			<?php
				}
			mysql_free_result($companyrs);
		}

 ?>

</table>
<table align=center>
<tr> <Td> <input type="submit" value="Update" name="updateDeal" > </td></tr></table>


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