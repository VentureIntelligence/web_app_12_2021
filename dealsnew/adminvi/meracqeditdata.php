<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{

?>
<html><head>
<title>M & A  Deal Info</title>
<SCRIPT LANGUAGE="JavaScript">
function checkFields()
{
	if(document.editdeal.txtfile.value!="")
	{
		if(document.editdeal.txtsource.value=="")
		{
			alert("Please enter the Source for the attached file");
			return false;
			}

	}

}
function delUploadFile()
{
	document.editdeal.action="delmauploadfile.php";
	document.editdeal.submit();
}
</SCRIPT>
<!--<link href="../style.css" rel="stylesheet" type="text/css">-->
</head>

<body>
 <form name=editdeal enctype="multipart/form-data" onSubmit="return checkFields();" method=post action="meracqupdatedata.php">
 <table border=1 align=center cellpadding=0 cellspacing=0 width=30%
	        style="font-family: Arial; font-size: 8pt; border-collapse: collapse" bordercolor="#111111" cellspacing="0" bgcolor="#F5F0E4">
<?php
	require("../dbconnectvi.php");
	$Db = new dbInvestments();

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

	$SelCompRef=$value;
	//echo "<br>--".$SelCompRef;
   	$getDatasql = "SELECT pe.PECompanyId, pec.companyname,pe.Stake, pec.industry, i.industry, pec.sector_business,
		pec.countryid as TargetCountryId,pec.city as TargetCity,
		Amount,DATE_FORMAT( DealDate, '%M' )  as dates, DATE_FORMAT( DealDate, '%Y' ) as dtyear,DATE_FORMAT(ModifiedDate,'%m/%d/%Y %H:%i:%s') as modifieddate,
		pec.website,c.country as TargetCountry,
		 pe.MAMAId,pe.Comment,MoreInfor,Validation,pe.MADealTypeId,pe.Asset,dt.MADealType,pe.AcquirerId,ac.Acquirer,ac.countryId as AcquirerCountryId,
		 ac.CityId as AcquirerCityId,pe.hideamount,Link,pec.RegionId,pe.uploadfilename,pe.source,pe.Valuation,pe.FinLink,
		 Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status
		 FROM mama AS pe, industry AS i, pecompanies AS pec,
		 madealtypes as dt,acquirers as ac,country as c
		 WHERE  i.industryid=pec.industry and c.countryid=pec.countryid
		 AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.MAMAId=$SelCompRef
		 and dt.MADealTypeId=pe.MADealTypeId and ac.AcquirerId=pe.AcquirerId";
	//echo "<br>-------------".$getDatasql;


	$advcompanysql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame,AdvisorType from mama_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.MAMAId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;

	$adacquirersql="select advinv.MAMAId,advinv.CIAId,cia.cianame,AdvisorType from mama_advisoracquirer as advinv,
	advisor_cias as cia where advinv.MAMAId=$SelCompRef and advinv.CIAId=cia.CIAId";
	//echo "<Br>".$adacquirersql;;

	if ($companyrs = mysql_query($getDatasql))
			$company_cnt = mysql_num_rows($companyrs);
	if($company_cnt > 0)
	{
		While($mycomprow=mysql_fetch_array($companyrs, MYSQL_BOTH))
		{
			$TargetCityfrmDB=$mycomprow["TargetCity"];
				if($mycomprow["Asset"]==1)
					$AssetFlag="checked";
				if($mycomprow["hideamount"]==1)
					$hideamountFlag="checked";

			$acquirerId=$mycomprow["AcquirerId"];
			$getAcquirerCityCountrySql = "select ac.CityId,ac.countryid,co.country from acquirers as ac,
		country as co where ac.AcquirerId=$acquirerId and co.countryid=ac.CountryId";
			//echo "<br>^^^^^^^^^^". $getAcquirerCityCountrySql;
						if($cityrs=mysql_query($getAcquirerCityCountrySql))
						{
							if($mycityrow=mysql_fetch_array($cityrs,MYSQL_BOTH))
							{
								$Acquirercityname=$mycityrow["CityId"];
								//$Acquirercountryname=$mycityrow["country"];
							}
						}
					//	echo "<br>$$$".$Acquirercityname;

					//echo "<br>checked- ".$hideamount;
					//echo "<br>checked stake- ".$hidestake;



			?>

		   		<tr bgcolor="#808000"><td colspan=2 align=center style="color: #FFFFFF" ><b>  Edit M A Deal</b></td></tr>
				<tr>

								<!-- industry id -->
								<td  style="font-family: Verdana; font-size: 87pt" align=left>
								<input type="hidden" name="txtindustryId" size="10" value="<?php echo $mycomprow[3]; ?>"> </td>

								<!-- PE id -->
								<td  style="font-family: Verdana; font-size: 8pt" align=left>
								<input type="hidden" name="txtMAMAId" size="10" value="<?php echo $mycomprow["MAMAId"]; ?>"> </td>

								<!-- PECompanyid -->
								<td  style="font-family: Verdana; font-size: 8pt" align=left>
								<input type="hidden" name="txtcompanyid" size="10" value="<?php echo $mycomprow["PECompanyId"]; ?>"> </td>
								</tr>
								<!--TargetCityId
								<td  style="font-family: Verdana; font-size: 8pt" align=left>
								<input type="hidden" name="txtTargetCityId" size="10" value="<?php echo $mycomprow["TargetCityId"]; ?>"> </td>
								</tr>-->

								<!--AcquirerCityId
								<td  style="font-family: Verdana; font-size: 8pt" align=left>
								<input type="hidden" name="txtAcquirerCityId" size="10" value="<?php echo $mycomprow["AcquirerCityId"]; ?>"> </td>
								</tr>-->

								<tr style="font-family: Verdana; font-size: 8pt">
								<td >&nbsp;Target Company</td>
								<td><input type="text" name="txtname" size="50" value="<?php echo $mycomprow["companyname"]; ?>"> </td>
								</tr>
								<tr>
								<td>Target Company Type</td>
								<td > <SELECT name="target_listingstatus">
                                                                 	<OPTION value="--" SELECTED> Choose  </option>
                                                                <?php
								$listing_statusvalue=$mycomprow["target_listing_status"];
                        					if ($listing_statusvalue=="L")
                                                                {   
                                                                  echo "<OPTION  value='L' SELECTED>Listed  </OPTION>\n";
                                                                  echo "<OPTION value='U' >Unlisted  </OPTION>\n";
                                                                }
                        				         elseif($listing_statusvalue=="U")
                        				         {
                                                                    echo "<OPTION  value='L'>Listed  </OPTION>\n";
                                                                    echo "<OPTION value='U' SELECTED>Unlisted  </OPTION>\n";
                                                                  }
                                                                  else
                                                                  {
                                                                   echo "<OPTION  value='L'>Listed  </OPTION>\n";
                                                                   echo "<OPTION value='U'>Unlisted  </OPTION>\n";
                                                                  }
                                                                  ?>
                                                                  	</select> </td> </tR>

								<tr>
								<td>&nbsp;Industry</td>
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

								<tr><td >&nbsp;Sector</td>
								<td>
								<input type="text" name="txtsector" size="49" value="<?php echo $mycomprow["sector_business"]; ?>">
								</tr>


								<tr><td >&nbsp; Amount (US $M)</td>
								<td>
								<input type="text" name="txtdealSize" size="10" value="<?php echo $mycomprow["Amount"]; ?>">
								<input name="chkhideamountFlag" type="checkbox" value=" <?php echo $mycomprow["hideamount"]; ?>" <?php echo $hideamountFlag; ?>></td>

								</tr>
								<tr><td >&nbsp; Stake (%)</td>
								<td>
								<input type="text" name="txtstake" size="10" value="<?php echo $mycomprow["Stake"]; ?>">
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
													 <OPTION VALUE=5 selected>May</OPTION>
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
													 <OPTION VALUE=6 selected>Jun</OPTION>
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
													 <OPTION VALUE=7 selected>Jul</OPTION>
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
													 <OPTION VALUE=8 selected>Aug</OPTION>
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
													 <OPTION VALUE=9 selected>Sep</OPTION>
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
													 <OPTION VALUE=10 selected>Oct</OPTION>
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
													 <OPTION VALUE=11 selected>Nov</OPTION>
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
													 <OPTION VALUE=12 selected>Dec</OPTION>
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
								<td>&nbsp;Deal Type</td>
								<td > <SELECT name="dealtype">

								<?php

									$dealtypesql = "select MADealTypeId, MADealType from madealtypes order by MADealTypeId";
									if ($dealtypers = mysql_query( $dealtypesql))
									{
									  $dealtype_cnt = mysql_num_rows($dealtypers);
									}
									if($dealtype_cnt > 0)
									{
										While($mydealrow=mysql_fetch_array($dealtypers, MYSQL_BOTH))
										{
											$id = $mydealrow[0];
											$name = $mydealrow[1];
											if ($id==$mycomprow["MADealTypeId"])
											{
												echo "<OPTION id=". $id. " value=". $id." SELECTED>".$name."  </OPTION>\n";
											}
											else
											{
												echo "<OPTION id=". $id. " value=". $id.">".$name."</OPTION> \n";
											}
										}
										mysql_free_result($dealtypers);
									}

								?>
								</select> </td> </tR>



								<tr>
									<td >Advisors (Target)
									<input type="button" value="Add Advisor (Target)" name="btnaddadvcompany"
										onClick="window.open('addAdvisors_meracq.php?value=<?php echo $SelCompRef;?>','mywindow','width=600,height=600')">
									</td>
									<td >
										<table border=1 width=100% cellpadding=1 cellspacing=0>

										<?php
										$strAdvComp="";
										 $advcompanysql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame,AdvisorType from mama_advisorcompanies as advcomp,
											advisor_cias as cia where advcomp.MAMAId=$SelCompRef and advcomp.CIAId=cia.CIAId";
										  //echo "<Br>".$advcompanysql;
										  if ($rsAdvisorCompany = mysql_query($advcompanysql))
										  {
											While($myInvrow=mysql_fetch_array($rsAdvisorCompany, MYSQL_BOTH))
											{
												$strAdvComp=$strAdvComp.",".$myInvrow["cianame"]."/" .$myInvrow["AdvisorType"];
											?>
										<tr><td >
										<input name="txtAdvcompId[]" type="hidden" value=" <?php echo $myInvrow["CIAId"]; ?>"  >
											</td></tr>
										<?php
											}
											  $strAdvComp =substr_replace($strAdvComp, '', 0,1);

										?>
											<tr><td >
											<input name="txtAdvCompany" type="text" size="49" value=" <?php echo trim($strAdvComp); ?>"  >
											</td></tr>
										<?php
										}
										?>
										</table>
										</td>
								</tr>


				<tr><td> City (Target) </td>
				<td>
				<input type="text" name="txtTargetCityName" size="49" value="<?php echo $TargetCityfrmDB; ?>">

				</td> </tR>



						<tr><td> Country (Target) </td>
				<td > <SELECT name="targetcountry">	<?php

								 	$countrySql = "select countryid,country from country";
									if ($countryrs = mysql_query( $countrySql))
									{
									  $country_cnt = mysql_num_rows($countryrs);
									}
								  	if($country_cnt > 0)
									{
								 		While($myrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
										{
											$id = $myrow[0];
											$name = $myrow[1];
											if ($id==$mycomprow["TargetCountryId"])
											{
												echo "<OPTION id='". $id. "' value=". $id." SELECTED>".$name."  </OPTION>\n";
											}
											else
											{
												echo "<OPTION id='". $id. "' value=". $id.">".$name."</OPTION> \n";
											}
										}
							 			mysql_free_result($countryrs);
									}

								?>
								</select> </td> </tR>




									<tr>
								<td >&nbsp;Website (Target)</td>
								<td><input type=text name="txtwebsite" size="49"  value="<?php echo $mycomprow["website"]; ?>" > </td>
								</tr>

								<tr><td >&nbsp;Acquirer</td>
								<td>
								<input name="txtAcquirerId" type="hidden" value=" <?php echo $myInvrow["AcquirerId"]; ?>"  >
								<input type="text" name="txtacquirer" size="49" value="<?php echo $mycomprow["Acquirer"]; ?>">
								</td>
								</tr>
								<tr>
								<td>Acquirer Company Type</td>
								<td > <SELECT name="acquirer_listingstatus">
                                                                 	<OPTION value="--" SELECTED> Choose  </option>
                                                                <?php
								$acqlisting_statusvalue=$mycomprow["acquirer_listing_status"];
                        					if ($acqlisting_statusvalue=="L")
                                                                {   
                                                                  echo "<OPTION  value='L' SELECTED>Listed  </OPTION>\n";
                                                                  echo "<OPTION value='U' >Unlisted  </OPTION>\n";
                                                                }
                        				         elseif($acqlisting_statusvalue=="U")
                        				         {
                                                                    echo "<OPTION  value='L'>Listed  </OPTION>\n";
                                                                    echo "<OPTION value='U' SELECTED>Unlisted  </OPTION>\n";
                                                                  }
                                                                  else
                                                                  {
                                                                   echo "<OPTION  value='L'>Listed  </OPTION>\n";
                                                                   echo "<OPTION value='U'>Unlisted  </OPTION>\n";
                                                                  }
                                                                  ?>
                                                                  	</select> </td> </tR>

<tr><td> City (Acquirer) </td>
				<td>
				<input type="text" name="txtAcquirerCityName" size="49" value="<?php echo $Acquirercityname; ?>">

				</td> </tR>

						<tr><td> Country (Acquirer) </td>
							<td > <SELECT name="acquirercountry">	<?php

								 	$countrySql = "select countryid,country from country";
									if ($countryrs = mysql_query( $countrySql))
									{
									  $country_cnt = mysql_num_rows($countryrs);
									}
								  	if($country_cnt > 0)
									{
								 		While($myrow=mysql_fetch_array($countryrs, MYSQL_BOTH))
										{
											$id = $myrow[0];
											$name = $myrow[1];
											if ($id==$mycomprow["AcquirerCountryId"])
											{
												echo "<OPTION id='". $id. "' value=". $id." SELECTED>".$name."  </OPTION>\n";
											}
											else
											{
												echo "<OPTION id='". $id. "' value=". $id.">".$name."</OPTION> \n";
											}
										}
							 			mysql_free_result($countryrs);
									}

								?>
								</select> </td> </tR>

						<tr>
						<td >Advisors (Acquirer)

						<input type="button" value="Add Advisor (Acquirer)" name="btnaddadvinv"
							onClick="window.open('addAdvisors_meracq.php?value=<?php echo $SelCompRef;?>','mywindow','width=600,height=600')">
						</td>

						<td >
							<table border=1 width=100% cellpadding=1 cellspacing=0>

							<?php
							$strAdvInv="";
								$adacquirersql="select advinv.MAMAId,advinv.CIAId,cia.cianame,AdvisorType from mama_advisoracquirer as advinv,
								advisor_cias as cia where advinv.MAMAId=$SelCompRef and advinv.CIAId=cia.CIAId";
							//echo "<Br>".$advinvestorsql;
							if ($rsAdvisorAcquirer = mysql_query($adacquirersql))
							  {
								While($myAcqrow=mysql_fetch_array($rsAdvisorAcquirer, MYSQL_BOTH))
								{
									$strAdvAcq=$strAdvAcq .", ".$myAcqrow["cianame"]."/" .$myAcqrow["AdvisorType"];

								?>
							<tr><td >
							<input name="txtAdvAcqId[]" type="hidden" value=" <?php echo $myAcqrow["CIAId"]; ?>"  >
							</td></tr>
							<?php
								}
								 $strAdvAcq =substr_replace($strAdvAcq, '', 0,1);
							?>
							<tr><td>
							<input name="txtAdvAcquirer" type="text" size="49" value=" <?php echo trim($strAdvAcq); ?>"  >
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

								</td>
								</tr>

								<tr>
								<td >&nbsp;Validation</td>
								<td><textarea name="txtvalidation" rows="1" cols="40"><?php echo $mycomprow["Validation"]; ?> </textarea> </td>

								</tr>

								<tr>
								<td>&nbsp;Asset </td><td>
								<input name="chkAssetFlag" type="checkbox" value=" <?php echo $mycomprow["Asset"]; ?>" <?php echo $AssetFlag; ?>></td>
							</tr>

							<tr>
								<td >&nbsp;Link</td>
								<td><textarea name="txtlink" rows="3" cols="40"><?php echo $mycomprow["Link"]; ?> </textarea>
								</td>
								</tr>

								 <tr>
								<td >Company Valuation (INR Cr)</td>
								<td >
								<input name="txtcompanyvaluation" type="text" size="10" value=<?php echo $mycomprow["Company_Valuation"]; ?> > </td>
								</tr>
								<tr>
								<td >Revenue Multiple</td>
								<td ><input name="txtrevenuemultiple" type="text" size="10" value=<?php echo $mycomprow["Revenue_Multiple"];?> ></td>
							        </tr>
								<tr>
								<td >EBITDA Multiple</td>
								<td ><input name="txtEBITDAmultiple" type="text" size="10" value=<?php echo $mycomprow["EBITDA_Multiple"];?> ></td>
								</tr>
								<tr>
								<td >PAT Multiple</td>
								<td ><input name="txtpatmultiple" type="text" size="10" value=<?php echo $mycomprow["PAT_Multiple"];?> ></td>
								</tr>

                                                                 <tr>
								<td >Valuation (More Info)</td>
								<td><textarea name="txtvaluation" rows="2" cols="40"><?php echo $mycomprow["Valuation"]; ?> </textarea>
								</td></tr>

								<tr>
								<td >Link for Financials (LISTED FIRM ONLY)</td>
								<td><textarea name="txtfinlink" rows="3" cols="40"><?php echo $mycomprow["FinLink"]; ?></textarea> </td>
								</tr>
								
								<tr>
								<td >&nbsp;Financial <br>

								</td>
								<td valign=top><INPUT NAME="txtfilepath" TYPE="file" value="<?php echo $mycomprow["uploadfilename"]; ?>" size=50>

								<input name="txtfile" type="text" size="22" value="<?php echo $mycomprow["uploadfilename"]; ?>" >
								<input type="button" value="Delete File" name="deleteuploadfile" onClick="delUploadFile();"  >

								</td> </tr>


								<tr>
								<td >&nbsp;Source</td>

								<td><input name="txtsource" type="text" size="50" value="<?php echo $mycomprow["source"]; ?>" ></td>
								</tr>

						<?php
								}
							mysql_free_result($companyrs);
							}

 ?>

</table>
<table align=center>
<tr> <Td> <input type="submit" value="Update M & A " name="updateDeal" > </td></tr></table>




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