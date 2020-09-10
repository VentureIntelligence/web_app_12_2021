<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{
		$currentyear = date("Y");
?>
<html><head>
<title>Add MA_MA Exit Deal Info</title>

<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=mamaadd enctype="multipart/form-data"  method=post action="mamaaddupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=55%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
?>

   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Add MA_MA Deal</b></td></tr>

				<tr style="font-family: Arial; font-size: 8pt">
				<td >&nbsp;Target Company</td>
				<td><input type="text" name="txtcompanyname" size="50" value="<?php echo $mycomprow["companyname"]; ?>"> </td>
				</tr>

                                <tr>
                                <td >Target Company Type</td>
                                <td > <SELECT name="target_listingstatus">
                                <OPTION value="--" selected> Choose </option>
                                <option value="L">Listed</option>
                                <option value="U">Unlisted</option>
                                 </select></td> </tr>

				<tr><td >&nbsp;Industry</td><td>
					<SELECT name="txtindustry" style="font-family: Arial; color: #004646;font-size: 8pt">
				<OPTION id=0 value="--" selected> Choose Industry  </option>
				<?php
					 $industrysql="select industryid,industry from industry where industryid !=15 order by industry";
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

								<tr><td >&nbsp;Sector</td>
								<td><input type="text" name="txtsector" size="50" value=""> </td></tr>


								<tr><td >&nbsp;Amount(US $M)</td>
								<td ><input type="text" name="txtsize" size="10" value="0" STYLE="text-align:right">
								<input name="chkhideamount" type="checkbox" >
								</td></tr>

				<tr><td >&nbsp;Stake (%)</td>
					<td >	<input type="text" name="txtstake" size="10" value="" STYLE="text-align:right">
					</td>
				</tr>

						<tr>
						 <td>&nbsp;Period</td>
						<Td width=5% align=left> <SELECT NAME=month1 style="font-family: Arial; color: #004646;font-size: 8pt>
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
							<SELECT NAME=year1 style="font-family: Arial; color: #004646;font-size: 8pt">
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


				<tr><td >&nbsp;Deal Type</td><td>
					<SELECT name="txtdealtype" style="font-family: Arial; color: #004646;font-size: 8pt">
				<OPTION id=0 value="--" selected> Choose Deal Type  </option>
				<?php
					 $dealtypesql="select MADealTypeId,MADealType from madealtypes order by MADealTypeId";
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
								echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
							}
							mysql_free_result($rsdealtypes);
						}
				?></select></td></tr>

								<tr>
								<td >&nbsp;Advisors-Target Company</td>
								<td >
								<input name="txtAdvTargetCompany" type="text" size="50" value="">
								</td></tr>

						<tr>
					<td >&nbsp;City (Target)</td>
					<td>
						<input name="txtTargetCity" type="text" size="50" value=""  >
					</td></tr>


					<tr>
					 <td> Region (Target)</td>
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
						While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
						{
							$id = $myregionrow[0];
							$name = $myregionrow[1];
						echo "<OPTION id=". $id. " value=". $id." >".$name."  </OPTION>\n";
						}
					}
				?>
				</SELECT></td></tr>


							<tr><td >&nbsp;Country (Target)</td><td>
							<SELECT name="txtTargetCountry" style="font-family: Arial; color: #004646;font-size: 8pt">
						<OPTION id=0 value="--" selected> Choose Country  </option>
						<?php
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
										echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
									}
									mysql_free_result($rsdealtypes);
								}
				?></select></td></tr>

					<tr>
					<td >&nbsp;Website (Target)</td>
					<td >
					<input type="text" name="txtTargetwebsite" size="50" value=""> </td>
						</tr>

				<tr><td >&nbsp;Acquirer</td>
					<td >
					<input type="text" name="txtacquirer" size="50" value="">
					</td>
				</tr>
                                 <tr>
                                <td >Acquirer Company Type</td>
                                <td > <SELECT name="acquirer_listingstatus">
                                <OPTION value="--" selected> Choose </option>
                                <option value="L">Listed</option>
                                <option value="U">Unlisted</option>
                                 </select></td> </tr>
				<tr>
					<td >&nbsp;City (Acquirer)</td>
					<td>
						<input name="txtAcquirorCity" type="text" size="50" value=""  >
					</td></tr>



						<tr><td >&nbsp;Country (Acquirer)</td><td>
						<SELECT name="txtAcquirorCountry" style="font-family: Arial; color: #004646;font-size: 8pt">
					<OPTION id=0 value="--" selected> Choose Country  </option>
					<?php
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
									echo "<OPTION id=".$id. " value=".$id.">".$name."</OPTION> \n";
								}
								mysql_free_result($rsdealtypes);
							}
						?></select></td></tr>

								<tr>
								<td >&nbsp;Advisors-Acquirer</td>
								<td>
									<input name="txtAdvAcquiror" type="text" size="50" value=""  >
								</td></tr>




								<tr>
								<td >&nbsp;Comment</td>

								<td><textarea name="txtcomment" rows="3" cols="40"> </textarea> </td>
								</tr>

								<tr>
								<td >&nbsp;More Information</td>
								<td valign=top><textarea name="txtmoreinfor" rows="3" cols="40"></textarea>
							</td>

								</tr>

								<tr>
								<td >&nbsp;Validation</td>
								<td><textarea name="txtvalidation" rows="1" cols="40"> </textarea> </td>

								</tr>

								<tr><td>&nbsp;Asset </td>
								<Td><input name="chkAssetFlag" type="checkbox" ></td></tr>

								<tr>
								<td >&nbsp;Link</td>
								<td valign=top><textarea name="txtlink" rows="3" cols="37"></textarea>
								</td></tr>


                                                                <tr>
								<td >Company Valuation (INR Cr)</td>
								<td >
								<input name="txtcompanyvaluation" type="text" size="10" value="0.00"> </td>
								</tr>
								<tr>
								<td >Revenue Multiple</td>
								<td ><input name="txtrevenuemultiple" type="text" size="10" value="0.00"> </td>
							        </tr>
								<tr>
								<td >EBITDA Multiple</td>
								<td ><input name="txtEBITDAmultiple" type="text" size="10" value="0.00"> </td>
								</tr>
								<tr>
								<td >PAT Multiple</td>
								<td ><input name="txtpatmultiple" type="text" size="10" value="0.00"> </td>
								</tr>
                                                                	<tr>
								<td >Valuation (More Info)</td>
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



<tr> <td rowspan=2> &nbsp;</td></tr>
	<tr> <td colspan=2> &nbsp;</td></tr>
	<tr style="font-family: Arial; color: #004646;font-size: 10pt"><td align=left> <a href="admin.php">Admin Home</a> </td> <td align=right><a href="mamaadd.php">Add MA_MA Deal </a></td></tr>
</table>
<table align=center>
<tr> <Td> <input type="submit" value="Add MA_MA" name="AddMAMA" > </td></tr></table>


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