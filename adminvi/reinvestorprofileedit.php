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
<title>PE Investment Company Profile</title>
<SCRIPT LANGUAGE="JavaScript">


</SCRIPT>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=editreinvestorprofile method=post action="reinvestorprofileeditupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=100%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

	$SelCompRef=$value;
   	$getDatasql = "SELECT InvestorId,Investor,Address1,Address2,City,Zip,
   	Telephone,Fax,Email,website,linkedIn,Description,yearfounded,NoEmployees,FirmType,
   	OtherLocation,Assets_mgmt,AlreadyInvested,LimitedPartners,
   	NoFunds,NoActiveFunds,MinInvestment,AdditionalInfor,Comment,countryid
			FROM REinvestors WHERE InvestorId=$SelCompRef";
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
		   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Edit RE Investor Profile</b></td></tr>
				<tr>

				<!-- InvestorId -->
				<td  style="font-family: Verdana; font-size: 8pt" align=left>
				<input type="hidden" name="txtInvestorId" size="10" value="<?php echo $mycomprow["InvestorId"]; ?>"> </td>
				</tr>

				<tr style="font-family: Verdana; font-size: 8pt">
				<td >Investor</td>
				<td><input type="text" name="txtname" size="50" value="<?php echo $mycomprow["Investor"]; ?>"> </td>
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
				<input type="text" name="txtadcity" size="50" value="<?php echo $mycomprow["City"]; ?>"> </td>
				</tr>
				<tr><td >Zip</td>
				<td>
				<input type="text" name="txtzip" size="50" value="<?php echo $mycomprow["Zip"]; ?>"> </td>
				</tr>
				<tr>
				<td>Country</td>
				<td > <SELECT name="country">
					<!-- <OPTION id=0 value="--" selected> Choose Country  </option> -->
				<?php

					$countrysql = "select i.countryid,i.country  from country as i where i.countryid NOT IN('','--','10','11') order by i.country asc";
					if ($countryrs = mysql_query($countrysql))
					{
					  $ind_cnt = mysql_num_rows($countryrs);
					}
					if($ind_cnt > 0)
					{
						if($mycomprow[23] == 11)
                                            {
                                                echo "<OPTION id=". $mycomprow[23]. " value='11' SELECTED>Choose Country</OPTION> \n";
                                            }else{
                                                echo "<OPTION id=". $mycomprow[23]. " value='11' >Choose Country</OPTION> \n";
                                            }
						While($myrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
						{
							$id = $myrow[0];
							$name = $myrow[1];
							if ($id==$mycomprow[23])
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
				<input type="text" name="txtwebsite" size="50" value="<?php echo $mycomprow["website"]; ?>"> </td>
				</tr>
                                <tr><td >LinkedIn URL</td>
				<td>
				<input type="text" name="txtlinkedin" size="50" value="<?php echo $mycomprow["linkedIn"]; ?>"> </td>
				</tr>
				<tr><td >Description</td>
				<td><textarea name="txtdescription" rows="2" cols="50"><?php echo $mycomprow["Description"]; ?> </textarea> </td>
				</tr>
				<tr><td >Year founded</td>
				<td >
				<input type="text" name="txtyearfounded" size="50" value="<?php echo $mycomprow["yearfounded"]; ?>">
				</td>
				</tr>
				<tr><td >No Of Employees</td>
				<td>
				<input type="text" name="txtnoemployees"  size="50" value="<?php echo $mycomprow["NoEmployees"]; ?>"> </td>
				</tr>
				<tr><td >Firm Type</td>
				<td >
				<input type="text" name="txtfirmtype" size="50" value="<?php echo $mycomprow["FirmType"]; ?>">
				</td>
				</tr>
				<tr><td >Other Location(s)</td>
				<td><textarea name="txtotherlocation" rows="2" cols="50"><?php echo $mycomprow["OtherLocation"]; ?> </textarea> </td>
				</tr>
				<tr><td >Assets Under Management (US$ Million)</td>
				<td>
				<input type="text" name="txtassets_mgmt" size="50" value="<?php echo $mycomprow["Assets_mgmt"]; ?>"> </td>
				</tr>
				<tr><td >Already Invested (US$ Million)</td>
				<td>
				<input type="text" name="txtalreadyinvested" size="50" readonly value="<?php echo $mycomprow["AlreadyInvested"]; ?>"> </td>
				</tr>
				<tr><td >Limited Partners</td>
				<td>
				<input type="text" name="txtlps" size="50"  value="<?php echo $mycomprow["LimitedPartners"]; ?>"> </td>
				</tr>
				<tr><td >No of Funds</td>
				<td>
				<input type="text" name="txtnofunds" size="50"  value="<?php echo $mycomprow["NoFunds"]; ?>"> </td>
				</tr>
				<tr><td >No of Active Funds</td>
				<td>
				<input type="text" name="txtactivefunds" size="50"  value="<?php echo $mycomprow["NoActiveFunds"]; ?>"> </td>
				</tr>
				<tr><td >Minimum Investment Size (US$ Million)</td>
				<td>
				<input type="text" name="txtmininvestment" size="50"  value="<?php echo $mycomprow["MinInvestment"]; ?>"> </td>
				</tr>
				<tr><td >Additional Information</td>
				<td><textarea name="txtaddinfor" rows="2" cols="50"><?php echo $mycomprow["AdditionalInfor"]; ?> </textarea> </td>
				</tr>
				<tr><td >Comment</td>
				<td><textarea name="txtcomment" rows="2" cols="50"><?php echo $mycomprow["Comment"]; ?> </textarea> </td>
				</tr>


					<tr>
					<td>Management
					<input type="button" value="Add Executive" name="btnaddmgmt"
					onClick="window.open('addREinvestorMgmt.php?value=<?php echo $SelCompRef;?>','mywindow','width=400,height=400')">

					</td>
					<td valign=top style="font-family: Verdana; font-size: 8pt" align=left>
					<table border=1 width=100% cellpadding=1 cellspacing=0>

					<?php
					$strManagement="";
					 $getInvestorsSql="select peinv.InvestorId,peinv.ExecutiveId,e.ExecutiveName,e.Designation,e.Company from
					 REinvestors_management as peinv,
					 executives as e where e.ExecutiveId=peinv.ExecutiveId and peinv.InvestorId=$SelCompRef";

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
 	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>