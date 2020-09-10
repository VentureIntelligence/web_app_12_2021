<?php include_once("../../globalconfig.php"); ?>
<?php
	require("../dbconnectvi.php");
     $Db = new dbInvestments();
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
     	session_start();
	 	if (session_is_registered("SessLoggedAdminPwd"))
	 	{
// && session_is_registered("SessLoggedIpAdd"))

							//echo "<br>full string- " .$i;

							$CompanyIndustryId=15;

							$portfoliocompany = $_POST['txtcompanyname'];
							//echo "<br>company. ".$portfoliocompany;
							$indid= $_POST['txtindustry'];  //industry id directly
							$listingstatusvalue = $_POST['listingstatus'];
							$sector=$_POST['txtsector'];
							$DealAmount=$_POST['txtamount'];
							$Round=$_POST['txtround'];
							$StageId=$_POST['txtstage'];
							// txtstage gives directly the stageid
							// iF  RealEstate Add , txtstage gives the RETypeId

							$col6=$_POST['txtinvestors'];
							/*
								$col6 is investors
								read the investor column in loop and insert invidual investors into peinvestors table
								taking the InvestorId and insert in the table
							*/
							$investorString=str_replace('"','',$col6);
							$investorString=explode(",",$investorString);


							$investortype=$_POST['invType'];
							$stakepercentage=$_POST['txtstake'];
							if(trim($stakepercentage)<=0)
							{
								$stakepercentage=0;
							}
							$monthtoAdd=$_POST['month1'];
							$yeartoAdd=$_POST['year1'];
							$IPODate=returnDate($monthtoAdd,$yeartoAdd);
							$website=$_POST['txtwebsite'];
							$city=$_POST['txtcity'];;
							$region=$_POST['txtregion'];;
							$Advisor_company=$_POST['txtAdvCompany'];
							$advisor_companyString=str_replace('"','',$Advisor_company);
							$advisor_companyString =explode(",",$advisor_companyString);

							$Advisor_investor=$_POST['txtAdvInvestor'];
							$advisor_investorString=str_replace('"','',$Advisor_investor);
							$advisor_investorString =explode(",",$advisor_investorString);

							$comment=$_POST['txtcomment'];
							$comment=str_replace('"','',$comment);
							$moreinfor=$_POST['txtmoreinfor'];
							$moreinfor=str_replace('"','',$moreinfor);

							$validation=$_POST['txtvalidation'];
							$link=$_POST['txtlink'];
							$valuation=$_POST['txtvaluation'];
							$finlink=$POST['txtfinlink'];
							$uploadname=$_POST['txtfilepath'];
							//echo "<BR>***".$uploadname;
							$sourcename=$_POST['txtsource'];
							$projectname=$_POST['txtprojectname'];
							$projectuploadname=$_POST['txtprojectfilepath'];


							$currentdir=getcwd();
							//echo "<br>Current Diretory=" .$currentdir;
							$curdir =  str_replace("adminvi","",$currentdir);
							//echo "<br>*****************".$curdir;
							$target = $curdir . "/uploadrefiles/" . basename($_FILES['txtfilepath']['name']);
							//echo "<Br>Target Directory****" .$target;
                                                 	$file = "uploadrefiles/" . basename($_FILES['txtfilepath']['name']);
                                                    	$filename= basename($_FILES['txtfilepath']['name']);


                                                        $target1 = $curdir . "/uploadrefiles/" . basename($_FILES['txtprojectfilepath']['name']);
							$file1 = "uploadrefiles/" .basename($_FILES['txtprojectfilepath']['name']);
							$filename1= basename($_FILES['txtprojectfilepath']['name']);
							//echo "<BR><Br>Project Details file Target Directory=" .$target1;

							if($filename!="")
							{
								if (!(file_exists($file)))
								{

									if( move_uploaded_file($_FILES['txtfilepath']['tmp_name'], $target))
									{

										//echo "<Br>The file ". basename( $_FILES['txtfilepath']['name']). " has been uploaded";
										echo "<br>File is getting uploaded . Please wait..";
										$file = "uploadmamafiles/" . basename($_FILES['txtfilepath']['name']);
										echo "<br>----------------" .$file;
									}
									else
									{
										echo "<br>Sorry, there was a problem in uploading the file.";
									}
								}
								else
									echo "<br>FILE ALREADY EXISTS IN THE SAME NAME";
							}

                                                        if($filename1!="")
							{
								if (!(file_exists($file1)))
								{

									if( move_uploaded_file($_FILES['txtprojectfilepath']['tmp_name'], $target))
									{

										//echo "<Br>The file ". basename( $_FILES['txtfilepath']['name']). " has been uploaded";
										echo "<br>Project File is getting uploaded . Please wait..";
										$file = "uploadmamafiles/" . basename($_FILES['txtprojectfilepath']['name']);
										echo "<br>----------------" .$file1;
									}
									else
									{
										echo "<br>Sorry, there was a problem in uploading the file.";
									}
								}
								else
									echo "<br>Project Detail FILE ALREADY EXISTS IN THE SAME NAME";
							}


							$flagdeletion=0;

							if($_POST['SPV'])
								$SPVtoAdd=1;
							else
								$SPVtoAdd=0;

							if($_POST['chkhideamount'])
							{
								//echo"<br>***************";
								$hideamount=1;
							}
							else
							{$hideamount=0;
							}
							//echo "<br>Hide amount- ".$hideamount;

							if($_POST['chkhidestake'])
							{$hidestake=1;
							}
							else
							{$hidestake=0;
							}
							$fullDateAfter=$IPODate;
							//echo "<br>**" .$fulldate ."--".$fullDateAfter;

							if (trim($portfoliocompany) !="")
							{
								//echo "<br>-------------------------";

								$companyId=insert_company($portfoliocompany,$CompanyIndustryId,$website,1);
								//echo "<bR>####---------------------";
								if($companyId==0)
								{
									$companyId=insert_company($portfoliocompany,$CompanyIndustryId,$website,1);
								}
								//$companyId=0;
								//echo "<br>Company id--" .$companyId;
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
											$createddate=date("Y-m-d")." ".date("H:i:s");
											$modifieddate=$createddate;
											//echo "<br>random MandAId--" .$PEId;
											$insertcompanysql="";
											$insertcompanysql= "INSERT INTO REinvestments (PEId,PECompanyId,dates,amount,round,StageId,stakepercentage,comment,MoreInfor,Validation,InvestorType,Deleted,hideamount,hidestake,SPV,CreatedDate,ModifiedDate,city,RegionId,sector,IndustryId,Link,uploadfilename,source,valuation,FinLink,ProjectName,ProjectDetailsFileName,listing_status)
											VALUES ($PEId,$companyId,'$fullDateAfter',$DealAmount,'$Round',$StageId,$stakepercentage,'$comment','$moreinfor', '$validation','$investortype',$flagdeletion,$hideamount,$hidestake,$SPVtoAdd,'$createddate','$modifieddate','$city','$region','$sector',$indid,'$link','$filename','$sourcename','$valuation','$finlink','$projectname','$filename1','$listingstatusvalue')";
											echo "<br>Insert RE investment :".$insertcompanysql;
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

												$datedisplay =  $fullDateAfter; //(date("Y F", $fullDateAfter));
											?>
											<Br>
											<tr bgcolor="#00CC66"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $datedisplay . " - " .$portfoliocompany ; ?>&nbsp; --> Inserted</td> </tr>
											<?php
											}
											else
											{
											?>
											<tr bgcolor="red"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; --> Insert failed</td> </tr>
											<?php
											}
									//	echo "<br> insert-".$insertcompanysql;
									}
									elseif($investment_cnt>= 1)
									{
									?>
									<tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; -->PE Deal already exists</td> </tr>
									<?php
									}
								}//if companyid >0 loop ends
							} //if $portfoliocompany !=null loop ends

} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;

//End of peinvestments insert


function returnDate($mth,$yr)
{
	//this function returns the date

	$fulldate= $yr ."-" .$mth ."-01";
	if (checkdate (01,$mth, $yr))
	{
		return $fulldate;
	}
}
/* inserts and returns the StageId  */
	function returnStageId($stage)
	{
		$stage=trim($stage);
		$dbslinkss = new dbInvestments();
		$getDealIdSql="select StageId from stage where Stage='$stage'";
	//	echo "<Br>DealSql--" .$getDealIdSql;
		if($rsgetAcquirer=mysql_query($getDealIdSql))
		{
			$dealtype_cnt=mysql_num_rows($rsgetAcquirer);
			if($dealtype_cnt==0)
			{
				//insert deal ..mostly it wont get inserted as new..only standard 9 stages already exists
				$insAcquirerSql="insert into stage(Stage) values('$stage')";
				if($rsInsAcquirer = mysql_query($insAcquirerSql))
				{
					$stageId=0;
					return stageId;
				}
			}
			elseif($dealtype_cnt==1)
			{
				While($myrow=mysql_fetch_array($rsgetAcquirer, MYSQL_BOTH))
				{
					$stageId = $myrow[0];
					//echo "<br>Insert return investor id--" .$invId;
					return $stageId;
				}
			}
		}
		$dbslinkss.close();
	}


/* function to insert the companies and return the company id if exists */
	function insert_company($companyname,$industryId,$web,$regionId)
	{
		$dbpecomp = new dbInvestments();
		$getPECompanySql = "select PECompanyId from REcompanies where companyname= '$companyname'";
		//echo "<br>select--" .$getPECompanySql;
		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
		{
			$pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
			//echo "<br>%%%%%".$pecomp_cnt;
			if ($pecomp_cnt==0)
			{
					//insert pecompanies
					$insPECompanySql="insert into REcompanies(companyname,industry,website,RegionId)
					values('$companyname',$industryId,'$web',$regionId)";
					echo "<br>Ins company sql=" .$insPECompanySql;
					if($rsInsPECompany = mysql_query($insPECompanySql))
					{
						$companyId=0;
						return $companyId;
					}
			}
			elseif($pecomp_cnt>=1)
			{
				While($myrow=mysql_fetch_array($rsgetPECompanyId, MYSQL_BOTH))
				{
					$companyId = $myrow[0];
					//echo "<br>Insert return industry id--" .$companyId;
					return $companyId;
				}
			}
			//echo "<br>----****".$companyId;
		}
		$dbpecomp.close();
	}

/* function to insert the industry and return the industry id if exists
	function insert_industry($industryname)
	{
		$dbindustrylink = new dbInvestments();
		$getIndustrySql = "select IndustryId from industry where industry like '$industryname%'";
		//echo "<br>select--" .$getIndustrySql;
		if ($rsgetIndustryId = mysql_query($getIndustrySql))
		{
			$ind_cnt=mysql_num_rows($rsgetIndustryId);
			//echo "<br>Investor count-- " .$ind_cnt;
			if ($ind_cnt==0)
			{
					//insert industry
					$insIndustrySql="insert into industry(industry) values('$industryname')";
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
*/

/* function to insert the advisor_cias table */
function insert_get_CIAs($cianame)
{
	$dblink = new dbInvestments();
	$cianame=trim($cianame);
	$getInvestorIdSql = "select CIAId from REadvisor_cias where cianame like '$cianame'";
	//echo "<br>select--" .$getInvestorIdSql;
	if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
	{
		$investor_cnt=mysql_num_rows($rsgetInvestorId);
		//echo "<br>Investor count-- " .$investor_cnt;
		if ($investor_cnt==0)
		{
				//insert acquirer
				$insAcquirerSql="insert into REadvisor_cias(cianame) values('$cianame')";
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

// the following function inserts advisor_PEIds in the reinvestments_advisor table
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
					//echo "<br>---".$insDealInvSql;
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
			elseif($investor_cnt==1)
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


	// the following function inserts investor and the peid in the reinvestments_investors table
	function insert_Investment_Investors($dealId,$investorId)
	{
		$DbInvestInv = new dbInvestments();
		//$dbslink = mysqli_connect("ventureintelligence.ipowermysql.com", "root",  "", "peinvestmentdeals");
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