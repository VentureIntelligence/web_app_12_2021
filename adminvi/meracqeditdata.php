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
	

$value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';

	$SelCompRef=$value;
	//echo "<br>--".$SelCompRef;
   	$getDatasql = "SELECT pe.PECompanyId, pec.companyname,pe.Stake, pec.industry as TargetIndustry, pec.sector_business,
		pec.countryid as TargetCountryId,pec.city as TargetCity,
		Amount,DATE_FORMAT( DealDate, '%M' )  as dates, DATE_FORMAT( DealDate, '%Y' ) as dtyear,DATE_FORMAT(ModifiedDate,'%m/%d/%Y %H:%i:%s') as modifieddate,
		pec.website,c.country as TargetCountry,
		 pe.MAMAId,pe.Comment,MoreInfor,Validation,pe.MADealTypeId,pe.Asset,dt.MADealType,pe.AcquirerId,ac.Acquirer,ac.IndustryId as AcquirerIndustryId,ac.countryId as AcquirerCountryId,
		 ac.CityId as AcquirerCityId,ac.Acqgroup as AcquirerGroup,pe.hideamount,Link,pec.RegionId,pe.uploadfilename,pe.source,pe.Valuation,pe.FinLink,
		 Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status ,AggHide,Revenue,EBITDA,PAT,pe.price_to_book,pe.book_value_per_share,pe.price_per_share
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

        $getfilingDatasql = "SELECT * from ma_companies_filing_files WHERE company_id=$SelCompRef";
        $companyrs = mysql_query($getDatasql) or die(mysql_error());
	if ($companyrs = mysql_query($getDatasql))
			$company_cnt = mysql_num_rows($companyrs);
	if($company_cnt > 0)
	{
		While($mycomprow=mysql_fetch_array($companyrs, MYSQL_BOTH))
		{
                  $hideaggregate=0;
                  if($mycomprow["AggHide"]==1)
   	                                $hideaggregate="checked";

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
								<input type="hidden" name="txtindustryId" size="10" value="<?php echo $mycomprow["industry"]; ?>"> </td>

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

								 	$industrysql = "select distinct i.industryid,i.industry  from industry as i order by i.industry";
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
											if ($id==$mycomprow["TargetIndustry"])
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
										 			While($i<=date('Y'))
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
                                 <tr>

					 <td> &nbsp;Region (Target)</td>

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

                                                    if ($id==$mycomprow["RegionId"])

                                                    {

                                                            echo "<OPTION id='". $id. "' value=". $id." SELECTED>".$name."  </OPTION>\n";

                                                    }

                                                    else

                                                    {

                                                            echo "<OPTION id='". $id. "' value=". $id.">".$name."</OPTION> \n";

                                                    }

						}

					}

				?>

				</SELECT></td></tr>


						<tr><td> Country (Target) </td>
				<td > <SELECT name="targetcountry">	<?php

								 	$countrySql = "select countryid,country from country where countryid NOT IN('','--','10','11') order by country asc";
									if ($countryrs = mysql_query( $countrySql))
									{
									  $country_cnt = mysql_num_rows($countryrs);
									}
								  	if($country_cnt > 0)
									{
										 if($mycomprow["AcquirerCountryId"] == 11)
                                            {
                                                echo "<OPTION id=". $mycomprow["AcquirerCountryId"]. " value='11' SELECTED>Choose Country</OPTION> \n";
                                            }else{
                                                echo "<OPTION id=". $mycomprow["AcquirerCountryId"]. " value='11' >Choose Country</OPTION> \n";
                                            }
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

                                                                <tr>
								<td>&nbsp;Industry (Acquirer)</td>
								<td > <SELECT name="txtacqindustry">

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
                                                                        if ($id==$mycomprow["AcquirerIndustryId"])
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
                                                                <tr><td >&nbsp; Group (Acquirer)</td>
								<td>
                                                                    <input type="text" name="txtacquirergroup" size="49" value="<?php echo $mycomprow["AcquirerGroup"]; ?>">
								</td>
								</tr>
<tr><td> City (Acquirer) </td>
				<td>
				<input type="text" name="txtAcquirerCityName" size="49" value="<?php echo $Acquirercityname; ?>">

				</td> </tR>

						<tr><td> Country (Acquirer) </td>
							<td > <SELECT name="acquirercountry">	<?php

								 	$countrySql = "select countryid,country from country where countryid NOT IN('','--','10','11') order by country asc";
									if ($countryrs = mysql_query( $countrySql))
									{
									  $country_cnt = mysql_num_rows($countryrs);
									}
								  	if($country_cnt > 0)
									{
										 if($mycomprow["AcquirerCountryId"] == 11)
                                            {
                                                echo "<OPTION id=". $mycomprow["AcquirerCountryId"]. " value='11' SELECTED>Choose Country</OPTION> \n";
                                            }else{
                                                echo "<OPTION id=". $mycomprow["AcquirerCountryId"]. " value='11' >Choose Country</OPTION> \n";
                                            }
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
								<td><textarea name="txtmoreinfor" rows="3" cols="40"><?php echo stripslashes($mycomprow["MoreInfor"]); ?> </textarea>

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
								<input name="txtcompanyvaluation" id="txtcompanyvaluation" type="text" size="10" value=<?php echo $mycomprow["Company_Valuation"]; ?> > </td>
								</tr>
								<tr>
								<td >Revenue Multiple</td>
								<td ><input name="txtrevenuemultiple" id="txtrevenuemultiple" type="text" size="10" value=<?php echo $mycomprow["Revenue_Multiple"];?> ></td>
							        </tr>
								<tr>
								<td >EBITDA Multiple</td>
								<td ><input name="txtEBITDAmultiple" id="txtEBITDAmultiple" type="text" size="10" value=<?php echo $mycomprow["EBITDA_Multiple"];?> ></td>
								</tr>
								<tr>
									<td >PAT Multiple</td>
									<td ><input name="txtpatmultiple" id="txtpatmultiple" type="text" size="10" value=<?php echo $mycomprow["PAT_Multiple"];?> ></td>
								</tr>
								
								
								<!-- New feature 08-08-2016 start 
								
									<tr>
										<td >Price to Book</td>
										<td ><input name="txtpricetobook" id="txtpricetobook" type="text" size="10" value="<?php echo $mycomprow["price_to_book"];?>"> </td>
									</tr>
									
									<tr>
										<td >Book Value Per Share</td>
										<td ><input name="txtbookvaluepershare" id="txtbookvaluepershare" type="text" size="10" value="<?php echo $mycomprow["book_value_per_share"];?>"> </td>
									</tr>
									
									<tr>
										<td >Price Per Share</td>
										<td ><input name="txtpricepershare" id="txtpricepershare" type="text" size="10" value="<?php echo $mycomprow["price_per_share"];?>"> </td>
									</tr>
								
								 New feature 08-08-2016 end -->

                                                                 <tr>
								<td >Valuation (More Info)</td>
								<td><textarea name="txtvaluation" rows="2" cols="40"><?php echo $mycomprow["Valuation"]; ?> </textarea>
								</td></tr>
                                                                 <?php
                                                                            
                                                                    if($mycomprow["Revenue"] >0 || $mycomprow["EBITDA"] >0 || $mycomprow["PAT"] >0){

                                                                        $checked='Checked';
                                                                    }
                                                                ?>
                                                                <tr>
                                                                    <td ><b>Autofill Revenues (INR Cr), EBITDA (INR Cr), PAT (INR Cr) Values</b></td>
                                                                <td ><label> <input name="getrevenue_value" id="getrevenue_value" type="checkbox" <?php echo $checked; ?>></label> </td>
							        </tr>
                                                                 <tr>
								<td >Revenues (INR Cr)</td>
								<td ><input name="txtrevenue" id="txtrevenue" type="text" size="10" value=<?php echo $mycomprow["Revenue"];?> ></td>
							        </tr>
								<tr>
								<td >EBITDA (INR Cr)</td>
								<td ><input name="txtEBITDA" id="txtEBITDA" type="text" size="10" value=<?php echo $mycomprow["EBITDA"];?> ></td>
								</tr>
								<tr>
								<td >PAT (INR Cr)</td>
								<td ><input name="txtpat" id="txtpat" type="text" size="10" value=<?php echo $mycomprow["PAT"];?> ></td>
								</tr>
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
                                                                    <td >&nbsp;Upload Working/Filings <br></td>
                                                                    <td id="addmorebtn">
                                                                        <br>


                                                                    <?php

                                                                    if ($filingrs = mysql_query($getfilingDatasql))
                                                                    {
                                                                            $filing_cnt = mysql_num_rows($filingrs);
                                                                    }
                                                                    if($filing_cnt > 0)
                                                                    {
                                                                            ?>
                                                                        <table border="1">
                                                                            <?php
                                                                            While($myfilingrow=mysql_fetch_array($filingrs, MYSQL_BOTH))
                                                                            {
                                                                                 if($myfilingrow["file_name"]!=''){ ?>

								<tr>
                                                                                        <?php 
                                                                                            $file = "../../ma_uploadfilingfiles/".str_replace(" ", "%20",$myfilingrow["file_name"]);

                                                                                            $info = new SplFileInfo($myfilingrow["file_name"]); ?>

                                                                                            <td><span style="font-weight: 20px;pointer-events: none;"><?php echo $myfilingrow["file_name"]; ?></span></td>
                                                                                            <?php
                                                                                            if($info->getExtension()!='pdf'){
                                                                                                ?>
                                                                                                    <td><a href=<?php echo $file;?> target="_blank" > <input type="button" value="Download"></a></td>

                                                                                                <?php }else{ ?>
                                                                                                       <td> <a href="downloadpdf.php?file=<?php echo $myfilingrow["file_name"]; ?>" > <input type="button" value="Download"></a></td>

                                                                                                <?php } ?>   
                                                                                                       <td><a href="ma_deletefiling.php?delete=<?php echo $myfilingrow["id"]; ?>" > <input type="button" value="Delete File"></a><br></td>
                                                                                        </tr>
                                                                                    <?php } 

                                                                            }?>
                                                                                        </table><br>
                                                                    <?php } ?>
                                                                        <input NAME="txtfilingpath[]" TYPE="file" value="" size=50><br><br></input>
                                                                        <button type="button" name="addfile" id="addbtn">Click to Add file <br></button>

                                                                    </td>
                                                                </tr>

								<tr>
								<td >&nbsp;Source</td>

								<td><input name="txtsource" type="text" size="50" value="<?php echo $mycomprow["source"]; ?>" ></td>
								</tr>
								
								 <tr><td >Hide for Aggregate (Tranche)</td>
								<td >
								<input name="chkhideAgg" type="checkbox" value=" <?php echo $mycomprow["AggHide"]; ?>" <?php echo $hideaggregate; ?>>

								</td>
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
   
   <script src="js/jquery-1.8.3.min.js" type="text/javascript"></script>
   <script>
    $("#addbtn").live("click",function() {
        $(this).remove();
        $('#addmorebtn').append($('<input/>',{type:"file",name:"txtfilingpath[]"}));
        $('#addmorebtn').append($('<br/><br/>')); 
        $('#addmorebtn').append($('<button/>',{type:"button",name:"addfile",id:"addbtn",text:"Click to Add file"}));   
                
    });
    $("input:file").live('change',function (){
  
                var fileName = $(this).val();
                var ext = fileName.split('.').pop();
                
                if(ext === 'pdf' || ext === 'xls' || ext === 'doc'){
                   return true;
                } else{
                    
                   $(this).remove();
                   $('#addbtn').remove();
                    $('#addmorebtn').append($('<input/>',{type:"file",name:"txtfilingpath[]"}));
                    $('#addmorebtn').append($('<br/><br/>')); 
                    $('#addmorebtn').append($('<button/>',{type:"button",name:"addfile",id:"addbtn",text:"Click to Add file"}));   
                   alert("Please select Excel or PDF or doc files");
                   return false;
                }

         });
    $( document ).ready(function() {
        
        $('#getrevenue_value').change(function() {
        if($(this).is(":checked")) {
           //alert('sssssssssssssssss');
           
          
           
           var txtcompanyvaluation = $("#txtcompanyvaluation").val();
           
           var txtrevenuemultiple = $("#txtrevenuemultiple").val();
           var txtEBITDAmultiple = $("#txtEBITDAmultiple").val();
           var txtpatmultiple = $("#txtpatmultiple").val();
           
           
           if($.isNumeric(txtcompanyvaluation)==0 || txtcompanyvaluation=="0.00" || txtcompanyvaluation=="0"){
                alert('Please enter company valution');
                $('#getrevenue_value').removeAttr('checked');
               return false;
           }
           
           /*
           var txtrevenue = txtcompanyvaluation/txtrevenuemultiple;
           var txtEBITDA = txtcompanyvaluation/txtEBITDAmultiple;
           var txtpat = txtcompanyvaluation/txtpatmultiple;
           
                $("#txtrevenue").val(txtrevenue.toFixed(1));                
                $("#txtEBITDA").val(txtEBITDA.toFixed(1));
                $("#txtpat").val(txtpat.toFixed(1));
           */     
           
          
           
           // revenue
           if($.isNumeric(txtrevenuemultiple)==0 || txtrevenuemultiple=="0.00" || txtrevenuemultiple=="0"){
               $("#txtrevenue").val('0.00');
               // alert('Please enter revenue multiple');
              // return false;
           }else{
               var txtrevenue = txtcompanyvaluation/txtrevenuemultiple;
                $("#txtrevenue").val(txtrevenue.toFixed(1));
           }
           
           
           // ebita
           if($.isNumeric(txtEBITDAmultiple)==0 || txtEBITDAmultiple=="0.00" || txtEBITDAmultiple=="0"){
               $("#txtEBITDA").val('0.00');
               // alert('Please enter EBITDA multiple');
               //return false;
           }else{
               var txtEBITDA = txtcompanyvaluation/txtEBITDAmultiple;
               $("#txtEBITDA").val(txtEBITDA.toFixed(1));
           }
           
           
           // pat
           if($.isNumeric(txtpatmultiple)==0 || txtpatmultiple=="0.00" || txtpatmultiple=="0"){
               $("#txtpat").val('0.00');
               // alert('Please enter pat multiple');
               //return false;
           }else{
               var txtpat = txtcompanyvaluation/txtpatmultiple;
               $("#txtpat").val(txtpat.toFixed(1));
           }
           
            
           
            
           
           
            
            
           
        }else{
            $("#txtrevenue, #txtEBITDA, #txtpat").val('0.00');
        }
        
        });
    });
 
    
    </script>
 </body>
 </html>
 <?php

 } // if resgistered loop ends
 else
 	header( 'Location: ' . BASE_URL . 'admin.php' ) ;
?>