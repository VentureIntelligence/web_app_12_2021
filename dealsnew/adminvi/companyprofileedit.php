<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{

?>
<html><head>
<title>PE Investment Company Profile</title>
<SCRIPT LANGUAGE="JavaScript">
function checkFields()
{
 alert(document.editcompprofile.txtbrdExecutiveId[].length);
}

</SCRIPT>
</head>

<body>
 <form name=editcompprofile enctype="multipart/form-data" method=post  action="companyprofileeditupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=100%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

	$SelCompRef=$value;
   	$getDatasql = "SELECT pec.PECompanyId, pec.companyname,pec.CINNo, pec.industry, i.industry, pec.sector_business, website,
  			stockcode, yearfounded,pec.Address1,pec.Address2,pec.AdCity,pec.Zip,pec.OtherLocation,
  			pec.countryid,pec.Telephone,pec.Fax,pec.Email,pec.AdditionalInfor,pec.RegionId,pec.uploadfilename,pec.tags 
			FROM industry AS i,pecompanies AS pec
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
		   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Edit Company Profile</b></td></tr>
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
				<td><input type="text" name="txtcinno" size="50" value="<?php echo $mycomprow["CINNo"]; ?>"> </td>
				</tr>

				<tr>
				<td>Industry</td>
				<td > <SELECT name="industry">

				<?php

					$industrysql = "select distinct i.industryid,i.industry  from industry as i
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
							if ($id==$mycomprow[3])
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

				<tr><td >Tags</td>
				<td>
				<input type="text" name="txttags" size="50" value="<?php echo $mycomprow["tags"]; ?>"> </td>
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
				<input type="text" name="txtadcity" size="50" value="<?php echo $mycomprow["AdCity"]; ?>"> </td>
				</tr>

				<tr>
							 <td> Region</td>
							 <Td width=5% align=left> <SELECT NAME=txtregion>
							  <OPTION value="1" selected> Choose Region </option>

						<?php
							$regionSql = "select RegionId,Region from region where Region!=''";
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

		<tr><td >Country (Target)</td><td>
				<SELECT name="txtcountry" style="font-family: Arial; color: #004646;font-size: 8pt">
			<OPTION id=0 value="--" selected> Choose Country  </option>
			<?php
				//$countryselected="IN";
				$countryselected=$mycomprow["countryid"];

				 $dealtypesql="select CountryId,Country from country";
					if ($rsdealtypes = mysql_query($dealtypesql))
					{
					 $dealtype_cnt = mysql_num_rows($rsdealtypes);
					}
					if($dealtype_cnt>0)
					{
						 While($myrow=mysql_fetch_array($rsdealtypes, MYSQL_BOTH))
						{
							$id = $myrow[0];
							$name = $myrow[1];
							if($id==$countryselected)
								echo "<OPTION id=".$id. " value=".$id." SELECTED>".$name."</OPTION> \n";
							else
								echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
						}
						mysql_free_result($rsdealtypes);
					}
			?></select></td></tr>



				<tr><td >Zip</td>
				<td>
				<input type="text" name="txtzip" size="50" value="<?php echo $mycomprow["Zip"]; ?>"> </td>
				</tr>

				<tr><td >Other Location</td>
				<td><textarea name="txtotherlocation" rows="2" cols="50"><?php echo $mycomprow["OtherLocation"]; ?> </textarea> </td>
				</tr>




				<tr><td >Telephone</td>
				<td>
				<input type="text" name="txttelephone" size="50" value="<?php echo $mycomprow["Telephone"]; ?>"> </td>
				</tr>
				<tr><td >Website</td>
				<td>
				<input type="text" name="txtwebsite" size="50" value="<?php echo $mycomprow["website"]; ?>"> </td>
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
					onClick="window.open('addcompBoardMgmt.php?value=<?php echo $SelCompRef;?>','mywindow','width=400,height=600')">
					<td valign=top style="font-family: Verdana; font-size: 8pt" align=left>
					<table border=1 width=100% cellpadding=1 cellspacing=0>

					<?php
					$strBoard="";
          			 $getInvestorsSql="select peinv.PECompanyId,peinv.ExecutiveId,e.ExecutiveName,e.Designation,e.Company from
          			 pecompanies_board as peinv,
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
						<input  name="txtbrdExecutiveId[]" type="text" READONLY size="15" value=" <?php echo $myInvrow["ExecutiveId"]; ?>"  >
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
					onClick="window.open('addcompBoardMgmt.php?value=<?php echo $SelCompRef;?>','mywindow','width=400,height=600')">
					<td valign=top style="font-family: Verdana; font-size: 8pt" align=left>
					<table border=1 width=100% cellpadding=1 cellspacing=0>

					<?php
					$strManagement="";
					 $getInvestorsSql="select peinv.PECompanyId,peinv.ExecutiveId,e.ExecutiveName,e.Designation,e.Company from
					 pecompanies_management as peinv,
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
					<input name="txtmgmtExecutiveId[]" type="text" READONLY size="15" value=" <?php echo $myMgmtInvrow["ExecutiveId"]; ?>"  >
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


                                <tr>
					<td>Links & Comments <br>
					<input type="button" value="Add Links & Comments" name="btnlinkcomment"
					onClick="window.open('addCompLink.php?value=<?php echo $SelCompRef;?>','mywindow','width=800,height=500')">
					<td valign=top style="font-family: Verdana; font-size: 8pt" align=left>
					<table border=1 width=100% cellpadding=1 cellspacing=0>

					<?php
					$strlinkcomment="";
          			 $getCompanyLinkSql="select peinv.PECompanyId,peinv.Link,peinv.Comment from
          			 pecompanies_links as peinv  where peinv.PECompanyId=$SelCompRef";

					  if ($rscompanylink = mysql_query($getCompanyLinkSql))
					  {
                        			While($mycompLinkrow=mysql_fetch_array($rscompanylink, MYSQL_BOTH))
						{

						?>
						<tr style="font-family: Verdana; font-size: 8pt" >
						<td valign=top width="20" >
						<input  name="txtCompanyLinkhidden[]" type="hidden" size="50" value=" <?php echo $mycompLinkrow["Link"]; ?>"  >
						<input  name="txtCompanyLink[]" type="text" size="50" value=" <?php echo $mycompLinkrow["Link"]; ?>"  >

						 <textarea name="txtCompanyComment[]" rows="3" cols="50"><?php echo $mycompLinkrow["Comment"]; ?> </textarea> </td>

						</tr>

					<?php

						}

					}
					?>
					</table>
					</td>
				</tr>

                                <tr>
								<td >&nbsp;Financial <br>
								</td>
								<td valign=top><INPUT NAME="txtfilepath" TYPE="file" value="<?php echo $mycomprow["uploadfilename"]; ?>" size=50>
								<input name="txtfile" type="text" size="50" value="<?php echo $mycomprow["uploadfilename"]; ?>" >
								<?php
									if($pe_re=="PE")
									{
									?>
										<input type="button" value="Delete File" name="deletepeuploadfile" onClick="delUploadFile();"  >
									<?php
									}
									else
									{
									?>
										<input type="button" value="Delete File" name="deletereuploadfile" onClick="delREUploadFile('F');"  >
									<?php
									}
									?>
								</td>
								</tr>

			<?php
				}
			mysql_free_result($rscompanylink);
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