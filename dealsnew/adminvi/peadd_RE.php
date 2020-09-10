<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{
		$currentyear = date("Y");

		  $onSubmitText=$_POST['pe_re_add'];
		  // echo "<br>**" .$onSubmitText;
		   if($onSubmitText=="RE")
		   {
			   	$checkValue="checked";
			   	$txtValue="RE";
  		   }
?>
<html><head>
<title>Add RE Investment Deal Info</title>
<SCRIPT LANGUAGE="JavaScript">




</script>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=adddeal enctype="multipart/form-data" method=post action="peaddupdate_RE.php">
 	<input type="hidden" name="pe_re_add" value=<?php echo $txtValue; ?> >

 <table border=1 align=center cellpadding=0 cellspacing=0 width=55%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
?>

   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Add RE Deal</b></td></tr>

								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Company</td>
								<td><input type="text" name="txtcompanyname" size="50" value="<?php echo $mycomprow["companyname"]; ?>"> </td>
								</tr>

							<tr><td >Industry</td><td>
								<SELECT name="txtindustry" style="font-family: Arial; color: #004646;font-size: 8pt">
							<?php

									$industrysql="select industryid,industry from reindustry ";

									if ($industryrs = mysql_query($industrysql))
									{
									 $ind_cnt = mysql_num_rows($industryrs);
									}
									if($ind_cnt>0)
									{
										 While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
										{
											$id = $myrow[0];
											$name = $myrow[1];
											echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
										}
										mysql_free_result($industryrs);
									}
		    				?></select></td></tr>

                                                    <tr>
								<td >Listing Status</td>
								<td > <SELECT name="listingstatus">
								 <OPTION value="--" selected> Choose </option>
								<option value="L">Listed</option>
                                                                  <option value="U">Unlisted</option>
                                                               </select></td>
								</tr>



								<tr><td >Sector</td>
								<td>
								<input type="text" name="txtsector" size="50" value=""> </td>
								</tr>

                                                                		<tr>
									 <td> Investor Type </td>
									 <Td width=5% align=left> <SELECT NAME=invType>


								<?php

									$investorTypeSql = "select InvestorType,InvestorTypeName from investortype";
									if ($invTypers = mysql_query($investorTypeSql))
									{
									  $invType_cnt = mysql_num_rows($invTypers);
									}
									if($invType_cnt > 0)
									{
										While($myrow=mysql_fetch_array($invTypers, MYSQL_BOTH))
										{
											$id = $myrow[0];
											$name = $myrow[1];
										echo "<OPTION id=". $id. " value=". $id." >".$name."  </OPTION>\n";
										}
									}
								?>
								</SELECT></td></tr>
								<tr><td >Amount</td>
								<td >
								<input type="text" name="txtamount" size="10" value="">
								<input name="chkhideamount" type="checkbox" >

								</td>
								</tr>

								<tr><td >Round</td>
								<td>
								<input type="text" name="txtround" size="50" value=""> </td>
								</tr>

								<tr>
									<td width="250"><font size="2" face="Verdana">Type</font></td>
									<td  width="343" > <SELECT name="txtstage">
									<?php
										$reSql = "select RETypeId,REType from realestatetypes order by REType";
											if ($rsreType = mysql_query( $reSql))
											{
											  $re_cnt = mysql_num_rows($rsreType);
											}
											if($re_cnt > 0)
											{
												While($myrow=mysql_fetch_array($rsreType, MYSQL_BOTH))
												{
													$id = $myrow[0];
													$name = $myrow[1];
													echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";

												}
												mysql_free_result($rsreType);
											}
								?></SELECT></td>
								</tr>

								<tr>
									<td>Investors </td>
										<Td>
										<input name="txtinvestors" type="text" size="50" value="" >
										</td>
								</tr>




								<tr>
								<td >Stake Percentage</td>
								<td >
								<input type="text" name="txtstake" size="10" value="">
								<input name="chkhidestake" type="checkbox" value=""></td>

								</tr>
							 <tr>
									 <td>Period</td>
									<Td width=5% align=left> <SELECT NAME=month1>
									 <OPTION id=1 value="--" > Month </option>
									 <OPTION VALUE=1 selected>Jan</OPTION>
									 <OPTION VALUE=2>Feb</OPTION>
									 <OPTION VALUE=3>Mar</OPTION>
									 <OPTION VALUE=4>Apr</OPTION>
									 <OPTION VALUE=5>May</OPTION>
									 <OPTION VALUE=6>Jun</OPTION>
									 <OPTION VALUE=7>Jul</OPTION>
									 <OPTION VALUE=8>Aug</OPTION>
									 <OPTION VALUE=9>Sep</OPTION>
									 <OPTION VALUE=10>Oct</OPTION>
									 <OPTION VALUE=11>Nov</OPTION>
									<OPTION VALUE=12>Dec</OPTION>
									</SELECT>
										<SELECT NAME=year1>
										<OPTION id=2 value="--" > Year </option>
										<?php

										$i=2004;
										While($i<= $currentyear )
										{
											$id = $i;
											$name = $i;
											if ($id==$currentyear)
											{
												echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."</OPTION>\n";
											}
											else
											{
												echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION>\n";
											}
											$i++;
										}
										?> </SELECT>

	   				 			</td></tr>
								<tr>
								<td >Website</td>
								<td >
								<input type="text" name="txtwebsite" size="50" value=""> </td>
								</tr>

								<tr>
								<td >City</td>
								<td >
								<input type="text" name="txtcity" size="50" value=""> </td>
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
										echo "<OPTION id=". $id. " value=". $id." >".$name."  </OPTION>\n";
										}
									}
								?>
								</SELECT></td></tr>


								<tr>
								<td >Advisors-Company (Add just the Advisor WITHOUT AdviosrType)</td>
								<td >
									<input name="txtAdvCompany" type="text" size="50" value="">
									</td></tr>


								<tr>
								<td >Advisors-Investors (Add just the Advisor WITHOUT AdviosrType)</td>
								<td>
									<input name="txtAdvInvestor" type="text" size="50" value=""  >
								</td></tr>


								<tr>
								<td >Comment</td>

								<td><textarea name="txtcomment" rows="2" cols="40"> </textarea> </td>
								</tr>

								<tr>
								<td >More Information</td>
								<td><textarea name="txtmoreinfor" rows="2" cols="40"></textarea> </td>
								</tr>

								<tr>
								<td >Validation</td>
								<td><textarea name="txtvalidation" rows="2" cols="40"> </textarea> </td>
								</tr>


								<tr>
								<td width="250"><font size="2" face="Verdana">SPV</font></td>
									<td><input type="checkbox" name="SPV" >
									</td>
								</tr>

							`	<tr>
								<td >Project Name (for SPVs)</td>
								<td >
								<input name="txtprojectname" type="text" size="50" value="">
								</td></tr>
                                                                <tr>
								<td >&nbsp;Project Details</td>
								<td valign=top><INPUT NAME="txtprojectfilepath" TYPE="file" size=50>
								</td> </tr>
								<tr>
								<td >Link</td>
								<td><textarea name="txtlink" rows="2" cols="40"> </textarea> </td>
								</tr>

								<tr>
								<td >Valuation</td>
								<td >
								<textarea name="txtvaluation" rows="3" cols="40"></textarea> </td>
								</tr>

								<tr>
								<td >Link for Financials (LISTED FIRM ONLY)</td>
								<td><textarea name="txtfinlink" rows="3" cols="40"></textarea> </td>
								</tr>
								<tr>
								<td >&nbsp;Financial</td>
								<td valign=top><INPUT NAME="txtfilepath" TYPE="file" size=50>
								</td> </tr>

								<tr>
								<td >&nbsp;Source</td>

								<td><input name="txtsource" type="text" size="50" value=""  ></td>
								</tr>


	<tr> <td colspan=2> &nbsp;</td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a> </td> <td align=right><a href="peadd_RE.php">Add RE Deal </a></td></tr>
</table>

<table align=center>
<tr> <Td> <input type="submit" value="Add RE Deal" name="AddDeal"  > </td></tr></table>




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