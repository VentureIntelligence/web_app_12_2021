<?php
/* created :Nov-16-09
formname:remamaadd
filename: remamaadd.php
invoked from: ventureintelligence.com/admin.php
invoked to: On submits updates RE-MAMA data to the database.
*/
require("../dbconnectvi.php");
	$Db = new dbInvestments();
	require("checkaccess.php");
	checkaccess( 'edit' );
 session_save_path("/tmp");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{
		$currentyear = date("Y");
?>
<html><head>
<title>Add rE MA_MA Exit Deal Info</title>

<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=remamaadd enctype="multipart/form-data"  method=post action="remamaaddupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=50%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	
?>

   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> RE - Add M&A Deal</b></td></tr>

				<tr style="font-family: Arial; font-size: 8pt">
				<td >&nbsp;Target Company</td>
				<td><input type="text" name="txtcompanyname" size="50" value="<?php echo $mycomprow["companyname"]; ?>"> </td>
				</tr>

				<tr><td >&nbsp;Industry</td><td>
					<SELECT name="txtindustry" style="font-family: Arial; color: #004646;font-size: 8pt">
				<OPTION id=0 value="--" selected> Choose Industry  </option>
				<?php
					 $industrysql="select industryid,industry from reindustry";
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
					<td >&nbsp;City</td>
					<td>
						<input name="txtTargetCity" type="text" size="50" value=""  >
					</td></tr>

							<tr>
								 <td>&nbsp;Region</td>
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

							<tr><td >&nbsp;Country (Target)</td><td>
							<SELECT name="txtTargetCountry" style="font-family: Arial; color: #004646;font-size: 8pt">
						<OPTION id=0 value="--" selected> Choose Country  </option>
						<?php
							 $dealtypesql="select CountryId,Country from country where countryid NOT IN('','--','10','11') order by country asc";
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
					<td >&nbsp;City (Acquirer)</td>
					<td>
						<input name="txtAcquirorCity" type="text" size="50" value=""  >
					</td></tr>

						<tr><td >&nbsp;Country (Acquirer)</td><td>
						<SELECT name="txtAcquirorCountry" style="font-family: Arial; color: #004646;font-size: 8pt">
					<OPTION id=0 value="--" selected> Choose Country  </option>
					<?php
						 $dealtypesql="select CountryId,Country from country where countryid NOT IN('','--','10','11') order by country asc";
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
								<Td><input name="chkAssetFlag" type="checkbox" ></td></tr?

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



<tr> <td rowspan=2> &nbsp;</td></tr>
	<tr> <td colspan=2> &nbsp;</td></tr>
	<tr style="font-family: Arial; color: #004646;font-size: 10pt"><td align=left> <a href="admin.php">Admin Home</a> </td> <td align=right><a href="remamaadd.php">Add RE - M&A Deal </a></td></tr>
</table>
<table align=center>
<tr> <Td> <input type="submit" value="Add RE - M&A" name="REAddMAMA" > </td></tr></table>


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