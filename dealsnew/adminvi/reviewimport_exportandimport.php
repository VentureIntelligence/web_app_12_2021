<?php include_once("../../globalconfig.php"); ?>
<?php
/* city and RegionI are added as part of the deal in RE */
/* Aseparate city and region is added for company in profile */
	require("../dbconnectvi.php");
     $Db = new dbInvestments();
     	session_start();
     	//$file="";
	 	//if (session_is_registered("SessLoggedAdminPwd") )
	 	// 	{
	 	 		//&& session_is_registered("SessLoggedIpAdd"))

					//$file ="importfiles/peinvestmentsexport.txt";
					$currentdir=getcwd();
					$target = $currentdir . "/importfiles/" . basename($_FILES['txtredealsfilepath']['name']);
					$file = "importfiles/" . basename($_FILES['txtredealsfilepath']['name']);
					//echo "<br>~~~~~~~~~~~" .$file;
					if (!(file_exists($file)))
					{
						if(move_uploaded_file($_FILES['txtredealsfilepath']['tmp_name'], $target))
						{
							//echo "<Br>The file ". basename( $_FILES['txtredealsfilepath']['name']). " has been uploaded";
							echo "<br>File is getting uploaded . Please wait..";
							$file = "importfiles/" . basename($_FILES['txtredealsfilepath']['name']);
							//echo "<br>----------------" .$file;
						}
						else
						{
							echo "<br>Sorry, there was a problem uploading the file.";
						}
					}
					$importTotal=0;
					if (file_exists($file))
					{
					if ($file !="")
					{
						echo "<Br>File is being read. It will take time to import all data. Please wait....";
						$fp = fopen($file, "r") or die("Couldn't open file");
						//$data = fread($fp, filesize($fp));
						while(!feof($fp))
						{		$data .= fgets($fp, 1024);
						}
						fclose($fp);
						$values = explode("\n", $data);
					foreach ($values as $i)
							{
 								if($i != "")
								{
									$createddate=date("Y-m-d")." ".date("H:i:s");
									$modifieddate=$createddate;

									//echo "<br>full string- " .$i;
									$fstring = explode("+", $i);
									$portfoliocompany = trim($fstring[0]);
									echo "<br>company. ".$portfoliocompany;
									$industryname = trim($fstring[1]);
									echo "<br>*************" .$industryname;

									$sector_focus=$fstring[2];
									$DealAmount=$fstring[3];
									//col 4 round will always be empty
									$Round=$fstring[4];
									$ReEstateType=$fstring[5];

										$RETypeId=returnRealEstateTypeId(trim($ReEstateType));
										if($RETypeId==0)
										{
											$RETypeId=returnRealEstateTypeId(trim($ReEstateType));
										}
									//echo "<br>--" .$RETypeId;
									$col6=$fstring[6];
									/*
										$col6 is investors
										read the investor column in loop and insert invidual investors into peinvestors table
										taking the InvestorId and insert in the manda_investors table
									*/
									$investorString=str_replace('"','',$col6);
									$investorString=explode(",",$investorString);
									$investortype=$fstring[7];
									$stakepercentage=$fstring[8];
									if(trim($stakepercentage)<=0)
									{
										$stakepercentage=0;
									}
									$IPODate=$fstring[9];
									$fullDateAfter=$IPODate;
									$website=$fstring[10];
									$city=trim($fstring[11]);
									$region=trim($fstring[12]);
									if(trim($region!=""))
									{
										$RegionId=returnRegionId($region);
										if($RegionId==0)
											$RegionId=returnRegionId($region);
									}
									$Advisor_company=trim($fstring[13]);
									$advisor_companyString=str_replace('"','',$Advisor_company);
									$advisor_companyString =explode(",",$Advisor_company);

									$Advisor_investor=trim($fstring[14]);
									$advisor_investorString=str_replace('"','',$Advisor_investor);
									$advisor_investorString =explode(",",$advisor_investorString);

									$comment=trim($fstring[15]);
									$comment=str_replace('"','',$comment);
									$moreinfor=trim($fstring[16]);
									$moreinfor=str_replace('"','',$moreinfor);

									$validation=trim($fstring[17]);	//validation text
									$flagdeletion=trim($fstring[18]);

									$hideamount=$fstring[19]; //if =1, hide from the view
									$hidestake=$fstring[20]; //hide amount from the view
									$flagSPV=$fstring[21]; // hide stake percentage from the view


									//echo "<br>**" .$fulldate ."--".$fullDateAfter;
								//	echo "<br>-----------------------";
									if (trim($portfoliocompany) !="")
									{
										$indid=insert_industry(trim($industryname));
										if($indid==0)
										{
											$indid= insert_industry(trim($industryname));
											echo "<br>AFter insert Industryid-".$indid;
										}
										$companyId=insert_company($portfoliocompany,$indid,$website,'IN',1);
										if($companyId==0)
										{
											$companyId=insert_company($portfoliocompany,$indid,$website,'IN',1);
										}
									echo "<Br>COMPANYID===========".$companyId;
										if ($companyId >0)
										{
											$pegetInvestmentsql = "select c.PECompanyId,ma.PECompanyId,DealDate from REcompanies as c,
											REinvestments as ma where ma.PECompanyId = c.PECompanyId and
											ma.dates = '$fullDateAfter' and c.PECompanyId = $companyId ";

											//echo "<br>checking pe record***" .$pegetInvestmentsql;
											//echo "<br>Company id--" .$companyId;
											if ($rsInvestment = mysql_query($pegetInvestmentsql))
											{
											$investment_cnt = mysql_num_rows($rsInvestment);
											// echo "<br>Count**********-- " .$investment_cnt ;
											}
											if($investment_cnt==0)
											{
													$PEId= rand();
													$insertcompanysql="";

													$insertcompanysql= "INSERT INTO REinvestments (PEId,PECompanyId,dates,amount,round,StageId,stakepercentage,comment,MoreInfor,Validation,InvestorType,Deleted,hideamount,hidestake,SPV,CreatedDate,ModifiedDate,city,RegionId,sector)
													VALUES ($PEId,$companyId,'$fullDateAfter',$DealAmount,'$Round',$RETypeId,$stakepercentage,'$comment','$moreinfor', '$validation','$investortype',$flagdeletion,$hideamount,$hidestake,$flagSPV,'$createddate','$modifieddate','$city',$RegionId,'$sector_focus')";
													echo "<br><br> ______>".$insertcompanysql;
													if ($rsinsert = mysql_query($insertcompanysql))
													{
														//echo "<br>Insert PE-" .$insertcompanysql;
														 foreach ($investorString as $inv)
															{
																if(trim($inv)!=="")
																{
																	$investorIdtoInsert=return_insert_get_Investor(trim($inv));
																	if($investorIdtoInsert==0)
																	{
																		$investorIdtoInsert= return_insert_get_Investor(trim($inv));
																	}
																		$insDeal_investors= insert_Investment_Investors($PEId,$investorIdtoInsert);
																}
															}

															foreach($advisor_companyString as $advisorcompany)
																{
																	if(trim($advisorcompany)!="")
																	{
																		$CIAIdtoInsert=insert_get_CIAs(trim($advisorcompany));
																		if($CIAIdtoInsert==0)
																		{
																			$CIAIdtoInsert= insert_get_CIAs(trim($advisorcompany));
																		}
																			$insDeal_Advisorcompany= insert_Investment_AdvisorCompany($PEId,$CIAIdtoInsert);
																	}
																}

															foreach($advisor_investorString as $advisorinvestor)
															{
																if(trim($advisorinvestor)!="")
																{
																	$CIAIdtoInsert=insert_get_CIAs(trim($advisorinvestor));
																	if($CIAIdtoInsert==0)
																	{
																		$CIAIdtoInsert= insert_get_CIAs(trim($advisorinvestor));
																	}
																		$insDeal_Advisorcompany= insert_Investment_AdvisorInvestors($PEId,$CIAIdtoInsert);
																}
															}


														$importTotal=$importTotal+1;
														$datedisplay =  $fullDateAfter; //(date("Y F", $fullDateAfter));
													?>
													<Br>
													<tr bgcolor="#00CC66"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $datedisplay . " - " .$portfoliocompany ; ?>&nbsp; --> Imported</td> </tr>
													<?php
													}
													else
													{
													?>
													<br><tr bgcolor="red"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; --> Import failed</td> </tr>
													<?php
													}
											//	echo "<br> insert-".$insertcompanysql;
											}
											elseif($investment_cnt>= 1)
											{
											?>
											<br><tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; -->M&A Deal already exists</td> </tr>
											<?php
											}
										}//if companyid >0 loop ends
									} //if $portfoliocompany !=null loop ends
								} //if $i loop ends
							} //for each loop ends


						} // if $file loop ends
					}// file exists loop ends
					else
					{
					?>

					<table align="center" border="1" cellpadding="0" cellspacing="0" width="765">
					<tr> <Td><b> File dont exists to read </b> </td></tR>
					</table>

					<?
					}



//		} // if resgistered loop ends
//		else
//			header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;

		//End of peinvestments insert
		?>

		<table align="center" border="1" cellpadding="0" cellspacing="0" width="765">
		<tr> <Td><b> Import count - <?php echo $importTotal; ?> </b> </td></tR>
		</table>
		<?php


		/* inserts and returns the StageId  */
			function returnRealEstateTypeId($RealEstateType)
			{
				$RealEstateType=trim($RealEstateType);
				$dbslinkss = new dbInvestments();
				$getDealIdSql="select RETypeId from realestatetypes where REType like '$RealEstateType'";
				//echo "<Br>DealSql--" .$getDealIdSql;
				if($rsgetRETypeId=mysql_query($getDealIdSql))
				{
					$dealtype_cnt=mysql_num_rows($rsgetRETypeId);
					if($dealtype_cnt==0)
					{
						//insert deal ..mostly it wont get inserted as new..only standard 6 realestatetype already exists
						$insAcquirerSql="insert into realestatetypes(REType) values('$RealEstateType')";
						if($rsInsAcquirer = mysql_query($insAcquirerSql))
						{
							$ReEstateTypeId=0;
							return ReEstateTypeId;
						}
					}
					elseif($dealtype_cnt==1)
					{
						While($myrow=mysql_fetch_array($rsgetRETypeId, MYSQL_BOTH))
						{
							$ReEstateTypeId = $myrow[0];
						//	echo "<br>Insert return investor id--" .$ReEstateTypeId;
							return $ReEstateTypeId;
						}
					}
				}
				$dbslinkss.close();
			}

		function returnRegionId($region)
			{
				$region=trim($region);
				$dbslinkss = new dbInvestments();
				$getDealIdSql="select RegionId from region where Region like '$region'";
			//	echo "<Br>DealSql--" .$getDealIdSql;
				if($rsgetRegionId=mysql_query($getDealIdSql))
				{
					$dealtype_cnt=mysql_num_rows($rsgetRegionId);
					if($dealtype_cnt==0)
					{
						//insert deal ..mostly it wont get inserted as new..standard 9 region already exists
						$insAcquirerSql="insert into region(Region) values('$region')";
						if($rsInsAcquirer = mysql_query($insAcquirerSql))
						{
							$regionId=0;
							return regionId;
						}
					}
					elseif($dealtype_cnt>=1)
					{
						While($myrow=mysql_fetch_array($rsgetRegionId, MYSQL_BOTH))
						{
							$regionId = $myrow[0];
							//echo "<br>Insert return investor id--" .$invId;
							return $regionId;
						}
					}
				}
				$dbslinkss.close();
			}


		/* function to insert the companies and return the company id if exists */
			function insert_company($companyname,$industryId,$web,$countryid,$regionId)
			{
				$dbpecomp = new dbInvestments();
				$getPECompanySql = "select PECompanyId from REcompanies where companyname= '$companyname'";
				//echo "<br>select--" .$getPECompanySql;
				if ($rsgetPECompanyId = mysql_query($getPECompanySql))
				{
					$pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
					if ($pecomp_cnt==0)
					{
							//insert pecompanies
							$insPECompanySql="insert into REcompanies(companyname,industry,website,countryid,RegionId)
							values('$companyname',$industryId,'$web','$countryid',$regionId)";
						//	echo "<br>Ins company sql=" .$insPECompanySql;
							if($rsInsPECompany = mysql_query($insPECompanySql))
							{
								$companyId=0;
								return $companyId;
							}
					}
					elseif($pecomp_cnt==1)
					{
						While($myrow=mysql_fetch_array($rsgetPECompanyId, MYSQL_BOTH))
						{
							$companyId = $myrow[0];
						//	echo "<br>Insert return industry id--" .$companyId;
							return $companyId;
						}
					}
				}
				$dbpecomp.close();
			}

		/* function to insert the industry and return the industry id if exists */
			function insert_industry($industry)
			{
				$dbindustrylink = new dbInvestments();
				$getIndustrySql = "select industryId from reindustry where industry like '$industry%'";
				echo "<br>select--" .$getIndustrySql;
				if ($rsgetIndustryId = mysql_query($getIndustrySql))
				{
					$ind_cnt=mysql_num_rows($rsgetIndustryId);
					//echo "<br>Investor count-- " .$ind_cnt;
					if ($ind_cnt==0)
					{
							//insert industry
							$insIndustrySql="insert into reindustry(industry) values('$industry')";
							if($rsInsIndustry = mysql_query($insIndustrySql))
							{
								$IndustryId=0;
								return $IndustryId ;
							}
					}
					elseif($ind_cnt==1)
					{
						While($myrow=mysql_fetch_array($rsgetIndustryId, MYSQL_BOTH))
						{
							$IndustryId = $myrow[0];
						//	echo "<br>Insert return industry id--" .$IndustryId;
							return $IndustryId;
						}
					}
				}
				$dbindustrylink.closeDB();
			}


		/* function to insert the advisor_cias table */
		function insert_get_CIAs($cianame)
		{
			$dblink = new dbInvestments();
			$cianame=trim($cianame);
			$getInvestorIdSql = "select CIAId from advisor_cias where cianame= '$cianame'";
			//echo "<br>select--" .$getInvestorIdSql;
			if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
			{
				$investor_cnt=mysql_num_rows($rsgetInvestorId);
				//echo "<br>Investor count-- " .$investor_cnt;
				if ($investor_cnt==0)
				{
						//insert acquirer
						$insAcquirerSql="insert into advisor_cias(cianame) values('$cianame')";
						if($rsInsAcquirer = mysql_query($insAcquirerSql))
						{
							$ciaInvestorId=0;
							return $ciaInvestorId;
						}
				}
				elseif($investor_cnt>=1)
				{
					While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
					{
						$ciaInvestorId = $myrow[0];
					//	echo "<br>Insert return investor id--" .$invId;
						return $ciaInvestorId;
					}
				}
			}
			$dblink.close();

		}

		// the following function inserts advisor_PEIds in the peinvestments_advisor table
			function insert_Investment_AdvisorInvestors($dealId,$ciaid)
			{
				$DbAdvInv = new dbInvestments();
				$getDealInvSql="Select PEId,CIAId from REinvestments_advisorinvestors where PEId=$dealId and CIAId=$ciaid";

				//echo "<br>@@@@@@--" .$getDealInvSql;
				if($rsgetdealinvestor = mysql_query($getDealInvSql))
				{
					$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
					if($deal_invcnt==0)
					{
						$insDealInvSql="insert into REinvestments_advisorinvestors values($dealId,$ciaid)";
						if($rsinsdealinvestor = mysql_query($insDealInvSql))
						{
							return true;
						}
					}
				}
				$DbAdvInv.close();
		}

		// the following function inserts advisor_PEIds in the peinvestments_advisor table
			function insert_Investment_AdvisorCompany($dealId,$ciaid)
			{
				$DbAdvComp= new dbInvestments();
				$getDealInvSql="Select PEId,CIAId from REinvestments_advisorcompanies where PEId=$dealId and CIAId=$ciaid";

				//echo "<br>@@@@@@--" .$getDealInvSql;
				if($rsgetdealinvestor = mysql_query($getDealInvSql))
				{
					$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
					if($deal_invcnt==0)
					{
						$insDealInvSql="insert into REinvestments_advisorcompanies values($dealId,$ciaid)";
						if($rsinsdealinvestor = mysql_query($insDealInvSql))
						{
							return true;
						}
					}
				}
				$DbAdvComp.close();
		}


		/* inserts and return the investor id */
			function return_insert_get_Investor($investor)
			{
				$dblink= new dbInvestments();
				$investor=trim($investor);
				$getInvestorIdSql = "select InvestorId from REinvestors where Investor= '$investor'";
				//echo "<br>select--" .$getInvestorIdSql;
				if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
				{
					$investor_cnt=mysql_num_rows($rsgetInvestorId);
					//echo "<br>Investor count-- " .$investor_cnt;
					if ($investor_cnt==0)
					{
							//insert acquirer
							$insAcquirerSql="insert into REinvestors(Investor) values('$investor')";
							if($rsInsAcquirer = mysql_query($insAcquirerSql))
							{
								$InvestorId=0;
								return $InvestorId;
							}
					}
					elseif($investor_cnt>=1)
					{
						While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
						{
							$InvestorId = $myrow[0];
						//	echo "<br>Insert return investor id--" .$InvestorId;
							return $InvestorId;
						}
					}
				}
				$dblink.close();
			}


			// the following function inserts investor and the peid in the peinvestments_investors table
			function insert_Investment_Investors($dealId,$investorId)
			{
				$DbInvestInv = new dbInvestments();
				//$dbslink = mysqli_connect("localhost", "root",  "", "peinvestmentdeals");
				$getDealInvSql="Select PEId,InvestorId from REinvestments_investors where PEId=$dealId and InvestorId=$investorId";

				//echo "<br>@@@@@@--" .$getDealInvSql;
				if($rsgetdealinvestor = mysql_query($getDealInvSql))
				{
					$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
					if($deal_invcnt==0)
					{
						$insDealInvSql="insert into REinvestments_investors values($dealId,$investorId)";
						if($rsinsdealinvestor = mysql_query($insDealInvSql))
						{
							return true;
						}
					}
				}
				$DbInvestInv.close();
		}

?>