<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{
		$currentyear = date("Y");
?>
<html><head>
<title>Add PE Investment Deal Info</title>
<SCRIPT LANGUAGE="JavaScript">
function checkCompany()
{
	//alert(document.adddeal.txtregion.selectedIndex)
	missinginfo = "";
	var compname="Undisclosed";
	var usercompname;
	usercompname=document.adddeal.txtcompanyname.value;
	//alert(usercompname);

	if(usercompname.toLowerCase() == compname.toLowerCase())
		missinginfo += "\n     -  Please use Undisclosed followed by some string delimted by "-" for the Company Name";
	if(document.adddeal.txtstage.selectedIndex ==0)
		missinginfo += "\n     -  Please select Stage from the list";

	if(document.adddeal.txtregion.selectedIndex==0)
		missinginfo += "\n     -  Please select Region";
	if (missinginfo != "")
	{
		alert(missinginfo);
		return true
	}
	else
		return true;
}
</SCRIPT>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=adddeal enctype="multipart/form-data" onSubmit="return checkCompany();" method=post action="angeladdupdate.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=55%
	        style="font-family: Arial; font-size: 9pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();
?>

   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Add Angel Investment Deal</b></td></tr>

								<tr style="font-family: Verdana; font-size: 8pt">
								<td >Company</td>
								<td><input type="text" name="txtcompanyname" size="50" value="<?php echo $mycomprow["companyname"]; ?>"> </td>
								</tr>

							<tr><td >Industry</td><td>
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


								<tr><td >Sector</td>
								<td>
								<input type="text" name="txtsector" size="50" value=""> </td>
								</tr>

								

								<tr>
									<td>Investors </td>
										<Td>
										<input name="txtinvestors" type="text" size="50" value="" >
										</td>
								</tr>

								
							 <tr>
								 <td>Date (First Investment)</td>
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
								<td >Mutliple Rounds</td>
								<td ><input name="chkmultipleround" type="checkbox" ></td>
								</tr>
								<tr>
								<td >Follow on VC Funding</td>
								<td ><input name="chkfollowonfund" type="checkbox" ></td>
								</tr>
								<tr>
								<td >Exited ?</td>
								<td ><input name="chkexited" type="checkbox" ></td>
								</tr>
								
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
								<td >Comment</td>

								<td><textarea name="txtcomment" rows="3" cols="40"> </textarea> </td>
								</tr>

								<tr>
								<td >More Information</td>
								<td><textarea name="txtmoreinfor" rows="3" cols="40"></textarea> </td>
								</tr>

								<tr>
								<td >Validation</td>
								<td><textarea name="txtvalidation" rows="2" cols="40"> </textarea> </td>
								</tr>

								<tr>
								<td >Link</td>
								<td><textarea name="txtlink" rows="3" cols="40"></textarea> </td>
								</tr>
												

	<tr> <td colspan=2> &nbsp;</td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a> </td> <td align=right><a href="angeladd.php">Add Angel Inv Deal </a></td></tr>
</table>

<table align=center>
<tr> <Td> <input type="submit" value="Add" name="AddDeal" > </td></tr></table>




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