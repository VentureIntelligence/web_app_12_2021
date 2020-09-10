<?php include_once("../globalconfig.php"); ?>
<?php
/* created date:Nov-6-09

Filename: reipoeditdata.php
formname: reipoeditdata

Invoked from: admin page
Invoked to: reipoupdatedata.php
*/
require("../dbconnectvi.php");
	$Db = new dbInvestments();
 session_save_path("/tmp");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{

?>
<html><head>
<title>RE Investment Deal Info</title>

<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=reipoeditdata method=post action="reipoupdatedata.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=30%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

	$SelCompRef=$value;
   	$getDatasql = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,pec.website,
      	 pe.IPOSize, pe.IPOAmount,IPOValuation, DATE_FORMAT( IPODate, '%M' )  as dates,
      	 pec.website, pe.city,pe.RegionId, r.Region, IPOId,DATE_FORMAT( IPODate, '%Y' ) as dtyear, Comment,MoreInfor,
      	 Validation,hideamount,hidemoreinfor,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,pe.ExitStatus
  			FROM REipos AS pe, reindustry AS i, REcompanies AS pec,region as r
  			WHERE pe.IPOId =" .$SelCompRef.
  			" AND i.industryid = pec.industry and r.RegionId=pe.RegionId
			AND pec.PEcompanyID = pe.PECompanyID ";
	//echo "<br>-------------".$getDatasql;
// $getAdvCompanySql="select advcomp.PEId,advcomp.CIAId,cia.cianame from REinvestments_advisorcompanies as advcomp,
//										advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
//	echo "<Br>".$getAdvCompanySql;



	if ($companyrs = mysql_query($getDatasql))
	{
		$company_cnt = mysql_num_rows($companyrs);
	}
	  if($company_cnt > 0)
	{
		While($mycomprow=mysql_fetch_array($companyrs, MYSQL_BOTH))
		{
				if($mycomprow["hideamount"]==1)
					$hideamount="checked";
				if($mycomprow["hidemoreinfor"]==1)
					$hidemoreinfor="checked";
				if($mycomprow["VCFlag"]==1)
					$vcflag="checked";


					//echo "<br>checked- ".$hideamount;
					//echo "<br>checked stake- ".$hidestake;
			  $strAdvComp="";
			  $advcompanysql="select advcomp.PEId,advcomp.ACIAId,cia.Advisor_cianame from REinvestments_advisorcompanies as advcomp,
				REadvisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.ACIAId=cia.ACIAId";
			  //echo "<Br>".$advcompanysql;
			  if ($rsAdvisorCompany = mysql_query( $advcompanysql))
			  {
				While($myInvrow=mysql_fetch_array($rsAdvisorCompany, MYSQL_BOTH))
				{
					$strAdvComp=$strAdvComp .", ".$myInvrow["Advisor_cianame"];
				}
				  $strAdvComp =substr_replace($strAdvComp, '', 0,1);
			  }

			?>

		   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b> Edit Deal</b></td></tr>
				<tr>

								<!-- industry id -->
								<td  style="font-family: Verdana; font-size: 87pt" align=left>
								<input type="hidden" name="txtindustryId" size="10" value="<?php echo $mycomprow[2]; ?>"> </td>

								<!-- PE id -->
								<td  style="font-family: Verdana; font-size: 8pt" align=left>
								<input type="hidden" name="txtIPOId" size="10" value="<?php echo $mycomprow["IPOId"]; ?>"> </td>

								<!-- PECompanyid -->
								<td  style="font-family: Verdana; font-size: 8pt" align=left>
								<input type="hidden" name="txtcompanyid" size="10" value="<?php echo $mycomprow["PECompanyId"]; ?>"> </td>
								</tr>

								<tr style="font-family: Verdana; font-size: 8pt">
								<td >&nbsp;Company</td>
								<td><input type="text" name="txtname" size="50" value="<?php echo $mycomprow["companyname"]; ?>"> </td>
								</tr>

								<tr>
								<td>&nbsp;Industry</td>
								<td > <SELECT name="industry">

								<?php

								 	$industrysql = "select industryid,industry  from reindustry";
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

								<tr><td >&nbsp;Sector (Rs)</td>
								<td >
								<input type="text" name="txtsector" size="50" value="<?php echo $mycomprow["sector_business"]; ?>">
                                                                </td>
                                                                </tr>

                                                                <tr>
                                                                <td>&nbsp;Exit Status</td>
                                                                <td> <select name="exitstatus"> 
                                                                <option value="--" selected=""> Choose </option>
                                                                <option value="0" <?php if($mycomprow["ExitStatus"]==0){ echo 'selected="selected"'; } ?> >Partial</option>
                                                                <option value="1" <?php if($mycomprow["ExitStatus"]==1){ echo 'selected="selected"'; } ?> >Complete</option>
                                                               </select></td>
								</tr>

								<tr><td >&nbsp;Deal Size (US $M)</td>
								<td>
								<input type="text" name="txtdealSize" size="10" value="<?php echo $mycomprow["IPOSize"]; ?>">
								<input name="chkhideamount" type="checkbox" value=" <?php echo $mycomprow["hideamount"]; ?>" <?php echo $hideamount; ?>></td>
								</tr>

								<tr><td >&nbsp;Deal Amount (Rs)</td>
								<td >
								<input type="text" name="txtamount" size="10" value="<?php echo $mycomprow["IPOAmount"]; ?>">


								</td>
								</tr>

								<tr><td >&nbsp;Deal Valuation (US $M)</td>
								<td>
								<input type="text" name="txtvaluation" size="10" value="<?php echo $mycomprow["IPOValuation"]; ?>"> </td>
								</tr>

								<tr>
									<td>&nbsp;Investors
									<td valign=topstyle="font-family: Verdana; font-size: 8pt" align=left>
									<table border=1 width=100% cellpadding=1 cellspacing=0>

									<?php
									$strInvestor="";
									  $getInvestorsSql="select peinv.IPOId,peinv.InvestorId,inv.Investor from REipo_investors as peinv,
									  REinvestors as inv where inv.InvestorId=peinv.InvestorId and peinv.IPOId=$SelCompRef";

									  if ($rsinvestors = mysql_query($getInvestorsSql))
									  {
										While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
										{
											$strInvestor=$strInvestor .", ".$myInvrow["Investor"];
										?>
									<tr><td valign=top width="100" style="font-family: Verdana; font-size: 8pt" >
									<input name="txtinvestorid[]" type="hidden" value=" <?php echo $myInvrow["InvestorId"]; ?>"  >
									</td></tr>

									<?php
										}
										  $strInvestor =substr_replace($strInvestor, '', 0,1);

									?>
										<tr><td valign=top >
										<input name="txtinvestors" type="text" size="49" value=" <?php echo trim($strInvestor); ?>"  >
										</td></tr>

									<?php
									}
									?>
									</table>
									</td>
								</tr>

						<?php
						$period = substr($mycomprow["dates"],0,3);

					?>
								 <tr>
										 			 <td>&nbsp;Period</td>
										     		 <Td width=5% align=left> <SELECT NAME=month1>

													<?php
													if($period=="Jan")
													{
													?>
													 <OPTION VALUE=1 SELECTED>Jan</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=1>Jan</OPTION>
													<?php
													}

													if($period=="Feb")
													{
													?>
													 <OPTION VALUE=2 SELECTED>Feb</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=2>Feb</OPTION>
													<?php
													}

													if($period=="Mar")
													{
													?>
													 <OPTION VALUE=3 selected>Mar</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=3>Mar</OPTION>
													<?php
													}

													if($period=="Apr")
													{
													?>
													 <OPTION VALUE=4 selected>Apr</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=4>Apr</OPTION>
													<?php
													}

													if($period=="May")
													{
													?>
													 <OPTION VALUE=5 SEELCTED>May</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=5>May</OPTION>
													<?php
													}
													if($period=="Jun")
													{
													?>
													 <OPTION VALUE=6 SELECTED>Jun</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=6>Jun</OPTION>
													<?php
													}
													if($period=="Jul")
													{
													?>
													 <OPTION VALUE=7 SELECTED>Jul</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=7>Jul</OPTION>
													<?php
													}
													if($period=="Aug")
													{
													?>
													 <OPTION VALUE=8 SELECTED>Aug</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=8>Aug</OPTION>
													<?php
													}
													if($period=="Sep")
													{
													?>
													 <OPTION VALUE=9 SELECTED>Sep</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=9>Sep</OPTION>
													<?php
													}
													if($period=="Oct")
													{
													?>
													 <OPTION VALUE=10 SELECTED>Oct</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=10>Oct</OPTION>
													<?php
													}
													if($period=="Nov")
													{
													?>
													 <OPTION VALUE=11 SELECTED>Nov</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=11>Nov</OPTION>
													<?php
													}
													if($period=="Dec")
													{
													?>
													 <OPTION VALUE=12 SELECTED>Dec</OPTION>
													<?php
													}
													else
													{
													?>
													<OPTION VALUE=12>Dec</OPTION>
													<?php
													}

											?>
										  			</SELECT>
										 			<SELECT NAME=year1>
										 			<OPTION id=2 value="--" selected> Year </option>
										 			<?php


										 			$i=2002;
										 			While($i<=2020)
										 			{
										 			$id = $i;
										 			$name = $i;
										 			if($id == $mycomprow["dtyear"])
										 			{
										 				echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."</OPTION>\n";
										 			}
										 			else
										 			{
										 				echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION>\n";
										 			}
										 			$i++;
										 			}
										 			?>
						 			</td></tr>

								<tr>
								<td >&nbsp;Advisors-Company</td>
								<td >
									<table border=1 width=100% cellpadding=1 cellspacing=0>
									<?php
									$strAdvComp="";
									 $getAdvCompanySql="select advcomp.PEId,advcomp.CIAId,cia.cianame from REinvestments_advisorcompanies as advcomp,
										REadvisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
									  //echo "<Br>".$advcompanysql;
									  if ($rsadvisors = mysql_query($getAdvCompanySql))
										  {
											While($myadvrow=mysql_fetch_array($rsadvisors, MYSQL_BOTH))
											{
												$strAdvComp=$strAdvComp.", ".$myadvrow[2];
										?>
										<tr><td valign=top width="100" style="font-family: Verdana; font-size: 8pt" >
										<input name="CIAId[]" type="hidden" value=" <?php echo $myadvrow["CIAId"]; ?>"  >
										</td></tr>

										<?php
											}
											  $strAdvComp =substr_replace($strAdvComp, '', 0,1);
										?>
											<tr><td valign=top >
											<input name="txtadvisors" type="text" size="49" value="<?php echo trim($strAdvComp );?>">
											</td></tr>
										<?php
										}
										?>
										</table>
										</td>
									</tr>


								<tr>
								<td >&nbsp;Comment</td>
								<td><textarea name="txtcomment" rows="2" cols="40"><?php echo $mycomprow["Comment"]; ?> </textarea> </td>
								</tr>

								<tr>
								<td >&nbsp;More Information</td>
								<td><textarea name="txtmoreinfor" rows="3" cols="40"><?php echo $mycomprow["MoreInfor"]; ?> </textarea>
								<input name="chkhidemoreinfor" type="checkbox" value=" <?php echo $mycomprow["hidemoreinfor"]; ?>" <?php echo $hidemoreinfor; ?>></td>
								</td>
								</tr>


								<tr>
								<td >&nbsp;Inv Deal(Summary)</td>
								<td><textarea name="txtinvdealsummary" rows="3" cols="40"><?php echo $mycomprow["InvestmentDeals"]; ?> </textarea>
								</td>
								</tr>

								<tr style="font-family: Verdana; font-size: 8pt">
								<td >&nbsp;City</td>
								<td><input type="text" name="txtcity" size="50" value="<?php echo $mycomprow["city"]; ?>"> </td>
								</tr>

								<tr style="font-family: Verdana; font-size: 8pt">
								<td >&nbsp;Region</td>
								<Td> <SELECT NAME=txtregion>

								<?php

								$regionSql = "select RegionId,Region from region";
								if ($regionrs = mysql_query($regionSql))
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
									mysql_free_result($regionrs);
								}

								?> </SELECT>
									</td>
								</tr>


								<tr style="font-family: Verdana; font-size: 8pt">
								<td >&nbsp;Website</td>
								<td><input type="text" name="txtwebsite" size="50" value="<?php echo $mycomprow["website"]; ?>"> </td>
								</tr>

								<tr>
								<td >&nbsp;Validation</td>
								<td><textarea name="txtvalidation" rows="1" cols="40"><?php echo $mycomprow["Validation"]; ?> </textarea> </td>
								</tr>

								<tr>
								<td >Link</td>
								<td><textarea name="txtlink" rows="2" cols="40"><?php echo $mycomprow["Link"]; ?> </textarea> </td>
								</tr>

									<tr style="font-family: Verdana; font-size: 8pt">
									<td >&nbsp;Estimated IRR (%)</td>
									<td><input type="text" name="txtestimatedirr" size="10" value="<?php echo $mycomprow["EstimatedIRR"]; ?>"> </td>
									</tr>


									<tr>
									<td >&nbsp;More Infor (Returns)</td>
									<td><textarea name="txtmoreinforeturns" rows="3" cols="40"><?php echo $mycomprow["MoreInfoReturns"]; ?> </textarea>
									</td>
								</tr>

						<?php
								}
							mysql_free_result($companyrs);
							}

 ?>

</table>
<table align=center>
<tr> <Td> <input type="submit" value="Update IPO Exit" name="updateDeal" > </td></tr></table>




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