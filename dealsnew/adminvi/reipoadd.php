<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{
		$currentyear = date("Y");
?>
<html><head>
<title>Add IPO Exit Deal Info</title>
<SCRIPT LANGUAGE="JavaScript">
function checkCompany()
{
	var compname="Undisclosed";
	var usercompname;
	usercompname=document.readdipo.txtcompanyname.value;
	//alert(usercompname);

	if(usercompname.toLowerCase() == compname.toLowerCase())
	{
		alert('Please use Undisclosed followed by some string delimted by "-" for the Company Name');
		return false;
	}
	else
		return true;
}
</SCRIPT>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=readdipo  onSubmit="return checkCompany();" method=post action="reipoaddupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=50%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
?>

   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Add RE-PE-backed IPOs</b></td></tr>

				<tr style="font-family: Verdana; font-size: 8pt">
				<td >&nbsp;Company</td>
				<td><input type="text" name="txtcompanyname" size="50" value=""> </td>
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
								<td>
								<input type="text" name="txtsector" size="50" value=""> </td>
								</tr>

								<tr><td >&nbsp;IPO Size(US $M)</td>
								<td >
								<input type="text" name="txtsize" size="10" value="">
								<input name="chkhidesize" type="checkbox" >

								</td>
								</tr>

								<tr><td >&nbsp;IPO Price(Rs.)</td>
								<td >
								<input type="text" name="txtprice" size="10" value="">
								</td>
								</tr>

								<tr><td >&nbsp;IPO Valuation(US $M)</td>
								<td >
								<input type="text" name="txtvaluation" size="10" value="">
								</td>
								</tr>

 								<tr>
									 <td>&nbsp;Period</td>
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
									<td>&nbsp;Investors </td>
										<Td>
										<input name="txtinvestors" type="text" size="50" value="" >
									</td>
								</tr>

								<tr>
									<td>&nbsp;Advisors </td>
										<Td>
										<input name="txtadvisors" type="text" size="50" value="" >
										</td>
								</tr>

								<tr>
								<td >&nbsp;City</td>
								<td >
								<input type="text" name="txtcity" size="50" value=""> </td>
								</tr>

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

								<tr>
								<td >&nbsp;Website</td>
								<td >
								<input type="text" name="txtwebsite" size="50" value=""> </td>
								</tr>

								<tr>
								<td >&nbsp;Comment</td>

								<td><textarea name="txtcomment" rows="3" cols="40"> </textarea> </td>
								</tr>


								<tr>
								<td >&nbsp;Inv Deals(Summary)</td>
								<td valign=top><textarea name="txtinvdealsummary" rows="3" cols="37"></textarea>
								</td>

								</tr>


								<tr>
								<td >&nbsp;More Information</td>
								<td valign=top><textarea name="txtmoreinfor" rows="3" cols="37"></textarea>
								<input name="chkhidemoreinfor" type="checkbox" ></td>

								</tr>

								<tr>
								<td >&nbsp;Validation</td>
								<td><textarea name="txtvalidation" rows="2" cols="40"> </textarea> </td>

								</tr>
								<tr>
								<td >Link</td>
								<td><textarea name="txtlink" rows="2" cols="40"> </textarea> </td>
								</tr>
								<tr>
								<td >&nbsp;Estimated IRR (%)</td>

								<Td><input type="text" name="txtestimatedirr" size="50" value=""> </td>
								</tr>

								<tr>
								<td >&nbsp;More Infor (Returns)</td>
								<td valign=top><textarea name="txtmoreinforeturns" rows="3" cols="37"></textarea>
								</td></tr>


<tr> <td colspan=2> &nbsp;</td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a> </td> <td align=right><a href="reipoadd.php">Add RE-PE-backed IPOs </a></td></tr>
</table>
<table align=center>
<tr> <Td> <input type="submit" value="Add REIPO Exit" name="REAddIPO" > </td></tr></table>



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