<?php
require("../dbconnectvi.php");
	$Db = new dbInvestments();
	require("checkaccess.php");
	checkaccess( 'edit' );
 session_save_path("/tmp");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{

?>
<html><head>
<title> Incubator Profile</title>
<SCRIPT LANGUAGE="JavaScript">


</SCRIPT>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=editincubatorprofile method=post action="incubatorprofileupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=100%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

	$SelCompRef=$value;
   	$getDatasql = "select * from incubators where IncubatorId=$SelCompRef";
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
		   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Edit Incubator Profile</b></td></tr>
				<tr>

				<!-- IncubatorId -->
				<td  style="font-family: Verdana; font-size: 8pt" align=left>
				<input type="hidden" name="txtincubatorId" size="10" value="<?php echo $mycomprow["IncubatorId"]; ?>"> </td>
				</tr>

				<tr style="font-family: Verdana; font-size: 8pt">
				<td >Incubator</td>
				<td><input type="text" name="txtname" size="50" value="<?php echo $mycomprow["Incubator"]; ?>"> </td>
				</tr>
                                <tr>
				<td>Firm Type (for Incubators)</td>
				<td > <SELECT name="incfirmtype">

				<?php

					$incfirmtypesql = "select IncFirmTypeId,IncTypeName from incfirmtypes order by IncFirmTypeId";
					if ($incfirmrs = mysql_query($incfirmtypesql))
					{
					  $inctype_cnt = mysql_num_rows($incfirmrs);
					}
					if($inctype_cnt > 0)
					{
						While($myincrow=mysql_fetch_array($incfirmrs, MYSQL_BOTH))
						{
							$id = $myincrow[0];
							$name = $myincrow[1];
							if ($id==$mycomprow["IncFirmTypeId"])
							{
								echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
							}
							else
							{
								echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
							}
						}
						mysql_free_result($incfirmrs);
					}

				?>
			</select> </td> </tR>

				<tr><td >Address1 </td>
				<td><textarea name="txtaddress1" rows="2" cols="50"><?php echo $mycomprow["Address1"]; ?> </textarea> </td>
				</tr>
				<tr><td >&nbsp; </td>
				<td >
				<input type="text" name="txtaddress2" size="50" value="<?php echo $mycomprow["Address2"]; ?>">
				</td>
				</tr>
				<tr><td >City</td>
				<td>
				<input type="text" name="txtadcity" size="50" value="<?php echo $mycomprow["City"]; ?>"> </td>
				</tr>
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
          	   <td><input type="text" name="txtEmail" size="50" value="<?php echo $mycomprow["Email"]; ?>"> </td>
				</tr>
				<tr><td >Website</td>
				<td>
				<input type="text" name="txtwebsite" size="50" value="<?php echo $mycomprow["website"]; ?>"> </td>
				</tr>
				<tr><td >LinkedIn URL</td>
				<td>
				<input type="text" name="txtlinkedin" size="50" value="<?php echo $mycomprow["linkedIn"]; ?>"> </td>
				</tr>
				<tr><td >Management</td>
				<td><textarea name="txtmgmt" rows="2" cols="50"><?php echo $mycomprow["Management"]; ?> </textarea> </td>
				</tr>
				<tr><td >Funds Available</td>
				<td >
				<input type="text" name="txtfundsavailable" size="50" value="<?php echo $mycomprow["FundsAvailable"]; ?>">
				</td>
				</tr>

				<tr><td >Additional Information</td>
				<td><textarea name="txtaddinfor" rows="5" cols="50"><?php echo $mycomprow["AdditionalInfor"]; ?> </textarea> </td>
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
 	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>
