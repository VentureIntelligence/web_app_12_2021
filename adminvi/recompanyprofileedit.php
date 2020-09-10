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
<title>RE Investment Company Profile</title>
<SCRIPT LANGUAGE="JavaScript">
function checkFields()
{
 alert(document.editcompprofile.txtbrdExecutiveId[].length);
}

</SCRIPT>
</head>

<body>
 <form name=editcompprofile method=post  action="recompanyprofileeditupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=100%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php


$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

	$SelCompRef=$value;
   	$getDatasql = "SELECT pec.PECompanyId, pec.companyname,pec.CIN ,pec.industry, i.industry, pec.sector_business, website,linkedIn,
  			stockcode, yearfounded,pec.Address1,pec.Address2,pec.AdCity,pec.Zip,pec.OtherLocation,
  			pec.Country,pec.Telephone,pec.Fax,pec.Email,pec.AdditionalInfor,city,pec.RegionId
			FROM reindustry AS i,REcompanies AS pec
			WHERE pec.industry = i.industryid
			 AND  pec.PECompanyId=$SelCompRef";
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
		   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Edit RE Company Profile</b></td></tr>
				<tr>

				<!-- industry id -->
				<td  style="font-family: Verdana; font-size: 87pt" align=left>
				<input type="hidden" name="txtindustryId" size="10" value="<?php echo $mycomprow[2]; ?>"> </td>

				<!-- PECompanyid -->
				<td  style="font-family: Verdana; font-size: 8pt" align=left>
				<input type="hidden" name="txtcompanyid" size="10" value="<?php echo $mycomprow["PECompanyId"]; ?>"> </td>
				</tr>

				<tr style="font-family: Verdana; font-size: 8pt">
				<td >Company</td>
				<td><input type="text" name="txtname" size="50" value="<?php echo $mycomprow["companyname"]; ?>"> </td>
				</tr>

                                <tr style="font-family: Verdana; font-size: 8pt">
				<td >CIN No</td>
				<td><input type="text" name="txtcinno" size="50" value="<?php echo $mycomprow["CIN"]; ?>"> </td>
				</tr>

				<tr>
				<td>Industry</td>
				<td > <SELECT name="industry">

				<?php

					$industrysql = "select distinct i.industryid,i.industry  from reindustry as i
					order by i.industry";
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

				<tr><td >Sector</td>
				<td>
				<input type="text" name="txtsector" size="50" value="<?php echo $mycomprow["sector_business"]; ?>"> </td>
				</tr>


				<tr><td >Stock Code</td>
				<td >
				<input type="text" name="txtstockcode" size="50" value="<?php echo $mycomprow["stockcode"]; ?>">
				</td>
				</tr>
				<tr><td >Year founded</td>
				<td >
				<input type="text" name="txtyearfounded" size="50" value="<?php echo $mycomprow["yearfounded"]; ?>">
				</td>
				</tr>
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
				<input type="text" name="txtadcity" size="50" value="<?php echo $mycomprow["city"]; ?>"> </td>
				</tr>

					<tr>
						 <td> Region</td>
						 <Td width=5% align=left> <SELECT NAME=txtregion>

					<?php
						$regionSql = "select RegionId,Region from region order by RegionId";
						if ($regionrs = mysql_query($regionSql))
						{
						  $region_cnt = mysql_num_rows($regionrs);
						}
						if($region_cnt > 0)
						{
							While($myrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
							{
								$id = $myrow[0];
								$name = $myrow[1];
								if ($id==$mycomprow["RegionId"])
          							{
          								echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
          							}
          							else
          							{
          								echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
          							}
                                                        }
						}
					?>
			</SELECT></td></tr>

				<tr><td >Zip</td>
				<td>
				<input type="text" name="txtzip" size="50" value="<?php echo $mycomprow["Zip"]; ?>"> </td>
				</tr>

				<tr><td >Other Location</td>
				<td><textarea name="txtotherlocation" rows="2" cols="50"><?php echo $mycomprow["OtherLocation"]; ?> </textarea> </td>
				</tr>

				<tr><td >Country</td>
				<td>
				<input type="text" name="txtcountry" size="50" value="<?php echo $mycomprow["Country"]; ?>"> </td>
				</tr>
				<tr><td >Telephone</td>
				<td>
				<input type="text" name="txttelephone" size="50" value="<?php echo $mycomprow["Telephone"]; ?>"> </td>
				</tr>
				<tr><td >Website</td>
				<td>
				<input type="text" name="txtwebsite" size="50" value="<?php echo $mycomprow["website"]; ?>"> </td>
				</tr>
                                <tr><td >LinkedIn URL</td>
				<td>
				<input type="text" name="txtlinkedin" size="50" value="<?php echo $mycomprow["linkedIn"]; ?>"> </td>
				</tr>
				<tr><td >Fax</td>
				<td>
				<input type="text" name="txtfax" size="50" value="<?php echo $mycomprow["Fax"]; ?>"> </td>
				</tr>
				<tr><td >Email</td>
				<td>
				<input type="text" name="txtemail" size="50" value="<?php echo $mycomprow["Email"]; ?>"> </td>
				</tr>
				<tr><td >Additional Information</td>
				<td><textarea name="txtaddinfor" rows="2" cols="50"><?php echo $mycomprow["AdditionalInfor"]; ?> </textarea> </td>
				</tr>


				<tr>
					<td>Board <br>
					<input type="button" value="Add Executive (Board)" name="btnaddboard"
					onClick="window.open('addREcompBoardMgmt.php?value=<?php echo $SelCompRef;?>','mywindow','width=400,height=500')">
					<td valign=top style="font-family: Verdana; font-size: 8pt" align=left>
					<table border=1 width=100% cellpadding=1 cellspacing=0>

					<?php
					$strBoard="";
          			 $getInvestorsSql="select peinv.PECompanyId,peinv.ExecutiveId,e.ExecutiveName,e.Designation,e.Company from
          			 REcompanies_board as peinv,
					 executives as e where e.ExecutiveId=peinv.ExecutiveId and peinv.PECompanyId=$SelCompRef";

					  if ($rsinvestors = mysql_query($getInvestorsSql))
					  {


						While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
						{
							$strBoard=$strBoard.", ".$myInvrow["ExecutiveName"];
							if(trim($myInvrow["Designation"])!="")
								$strBoard=$strBoard.", ".$myInvrow["Designation"];
							if(trim($myInvrow["Company"])!="")
								$strBoard=$strBoard.", ".$myInvrow["Company"];
							$strBoard =substr_replace($strBoard, '', 0,1);
						?>
						<tr style="font-family: Verdana; font-size: 8pt" >
						<td valign=top width="20" >
						<input  name="txtbrdExecutiveId[]" type="text" size="15" value=" <?php echo $myInvrow["ExecutiveId"]; ?>"  >
						</td>
						<td> <input type="text" name="txtbrdExecutiveName[]"  size="50" value="<?php echo trim($strBoard); ?> "> </td>

						</tr>

					<?php
							$strBoard="";
						}

					}
					?>
					</table>
					</td>
				</tr>

					<tr>
					<td>Management
					<input type="button" value="Add Executive (Management)" name="btnaddmgmt"
					onClick="window.open('addREcompBoardMgmt.php?value=<?php echo $SelCompRef;?>','mywindow','width=400,height=500')">
					<td valign=top style="font-family: Verdana; font-size: 8pt" align=left>
					<table border=1 width=100% cellpadding=1 cellspacing=0>

					<?php
					$strManagement="";
					 $getInvestorsSql="select peinv.PECompanyId,peinv.ExecutiveId,e.ExecutiveName,e.Designation,e.Company from
					 REcompanies_management as peinv,
					 executives as e where e.ExecutiveId=peinv.ExecutiveId and peinv.PECompanyId=$SelCompRef";

					  if ($rsMgmtinvestors = mysql_query($getInvestorsSql))
					  {

						While($myMgmtInvrow=mysql_fetch_array($rsMgmtinvestors, MYSQL_BOTH))
						{
							$strManagement=$strManagement.", ".$myMgmtInvrow["ExecutiveName"];
							if(trim($myMgmtInvrow["Designation"])!="")
								$strManagement=$strManagement.", ".$myMgmtInvrow["Designation"];
							if(trim($myMgmtInvrow["Company"])!="")
								$strManagement=$strManagement.", ".$myMgmtInvrow["Company"];
						  $strManagement =substr_replace($strManagement, '', 0,1);

							//$strManagement=$strManagement.";";
						?>
					<tr style="font-family: Verdana; font-size: 8pt" >
					<td valign=top width="20" >
					<input name="txtmgmtExecutiveId[]" type="text" size="15" value=" <?php echo $myMgmtInvrow["ExecutiveId"]; ?>"  >
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
 	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>