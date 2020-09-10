<?php include_once("../../globalconfig.php"); ?>
<?php
	require("../dbconnectvi.php");
     $Db = new dbInvestments();
 session_save_path("/tmp");
     	session_start();
	 	if (session_is_registered("SessLoggedAdminPwd"))
	 	{
// && session_is_registered("SessLoggedIpAdd"))

							//echo "<br>full string- " .$i;

							$portfoliocompany = $_POST['txtcompanyname'];
							$listingstatusvalue = $_POST['listingstatus'];
                                                        $exitstatusvalue = $_POST['exitstatus'];
							//echo "<br>company. ".$portfoliocompany;
							$indid= $_POST['txtindustry'];  //industry id directly
							$sector=$_POST['txtsector'];
							$DealAmount=$_POST['txtamount'];
							if($DealAmount<=0)
								$DealAmount=0;
							$Round=$_POST['txtround'];
							$StageId=$_POST['txtstage'];  // txtstage gives directly the stageid

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
							$city=$_POST['txtcity'];
							//$region=$_POST['txtregion'];
							$RegionIdtoUpdate=$_POST['txtregion'];
						//	echo "<br>---" .$RegionIdtoUpdate;

						 //	$region=return_insert_get_RegionId($RegionIdtoUpdate);
						 //	echo "<Br-----" .$region;

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
							$flagdeletion=0;
							$company_valuation=0;
							$revenue_multiple=0;
							$ebitda_multiple=0;
                                                        $pat_mutliple=0;

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
							{
								$hidestakevalue=1;
							}
							else
							{
								$hidestakevalue=0;
							}
							$valuation=$_POST['txtvaluation'];
							$company_valuation=$_POST['txtcompanyvaluation'];
							if($company_valuation=="")
							  $company_valuation=0;

							$revenue_multiple=$_POST['txtrevenuemultiple'];
							if($revenue_multiple=="")
							   $revenue_multiple=0;

							$ebitda_mutliple=$_POST['txtEBITDAmultiple'];
							if($ebitda_mutliple=="")
							   $ebitda_mutliple=0;

							$pat_mutliple=$_POST['txtpatmultiple'];
							if($pat_mutliple=="")
							   $pat_mutliple=0;
							   
							
							// New feature 08-08-2016 start
							
								$price_to_book=$_POST['txtpricetobook'];
								if($price_to_book=="")
								   $price_to_book=0;
								   
								   
								
								$book_value_per_share=$_POST['txtbookvaluepershare'];
								if($book_value_per_share=="")
								   $book_value_per_share=0;
								   
								   
								
								$price_per_share=$_POST['txtpricepershare'];
								if($price_per_share=="")
								   $price_per_share=0;
								   
							
							// New feature 08-08-2016 end
							

                            $revenue=$_POST['txtrevenue'];
							if($revenue=="")
							   $revenue=0;

							$ebitda=$_POST['txtEBITDA'];
							if($ebitda=="")
							   $ebitda=0;

							$pat=$_POST['txtpat'];
							if($pat=="")
							   $pat=0;
                                                        
							$finlink=$POST['txtfinlink'];			
							$uploadname=$_POST['txtfilepath'];
							$sourcename=$_POST['txtsource'];
							 if($_POST['chkhideAgg'])
                                                	 { $hideAggregatetoUpdate=1;
                                                	 }
                                                	 else
                                                	 { $hideAggregatetoUpdate=0;
                                                	 }
                                                         if($_POST['chkSPVdebt'])
                                                	 { $spvdebt=1;
                                                	 }
                                                	 else
                                                	 { $spvdebt=0;
                                                	 }
							$dbtypedeal=$_POST['dbtype'];
                                                        $showpevcdeal=$_POST['showaspevc'];
                                                        if($_POST['dbtype'])
                                                        {
                                                          foreach($dbtypedeal as $dbtype)
                                                        {
                                                          $dbtypearray[]=$dbtype;
                                                          //echo "<Br>!!".$dbtype;
                                                        }
                                                        }
                                                        //echo "<Br>^^^ ".$showpevcdeal;
                                                       	if($_POST['showaspevc'])
                                                       	{
                                                         foreach($showpevcdeal as $showpevc)
							{
                                                           $showaspevcarray[]=$showpevc;
                                                           //echo "<br>*** ".$showpevc;
                                                         //echo "<br>****----" .$showpevc;
							//	$stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
							//	$stageidvalue=$stageidvalue.",".$stage;
							}
                                                        }

						/*	$currentdir=getcwd();
							//echo "<br>Current Diretory=" .$currentdir;
							$curdir =  str_replace("adminvi","",$currentdir);
							//echo "<br>*****************".$curdir;
							$target = $curdir . "/uploadmamafiles/" . basename($_FILES['txtfilepath']['name']);
							$file = "uploadmamafiles/" . basename($_FILES['txtfilepath']['name']);
							$filename= basename($_FILES['txtfilepath']['name']);
							//echo "<Br>Target Directory=" .$target;
							//echo "<bR>---" .$filename;
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

                                                       */

							$fullDateAfter=$IPODate;
							//echo "<br>**" .$fulldate ."--".$fullDateAfter;

							if (trim($portfoliocompany) !="")
							{
								//echo "<br>-------------------------";
								/*$indid=insert_industry(trim($industryname));

								if($indid==0)
								{
									$indid= insert_industry(trim($industryname));

								} */
								//echo "<br>Industryid-".$indid;
								$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$region,$RegionIdtoUpdate);
								if($companyId==0)
								{
									$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$region,$RegionIdtoUpdate);
								}
								//$companyId=0;
								//echo "<br>Company id--" .$companyId;
								if ($companyId >0)
								{
									$pegetInvestmentsql = "select c.PECompanyId,ma.PECompanyId,dates from pecompanies as c,
									peinvestments as ma where ma.PECompanyId = c.PECompanyId and   Deleted=0 and
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
											//echo "<br>random MandAId--" .$PEId;
											$insertcompanysql="";
											$insertcompanysql= "INSERT INTO peinvestments (PEId,PECompanyId,dates,amount,round,StageId,stakepercentage,comment,MoreInfor,Validation,InvestorType,Deleted,hideamount,hidestake,SPV,Link,uploadfilename,source,Valuation,FinLink,AggHide,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,Revenue,EBITDA,PAT,price_to_book,book_value_per_share,price_per_share)
											VALUES ('$PEId','$companyId','$fullDateAfter','$DealAmount','$Round','$StageId','$stakepercentage','$comment','$moreinfor', '$validation','$investortype','$flagdeletion','$hideamount','$hidestakevalue','$spvdebt','$link','','$sourcename','$valuation','$finlink','$hideAggregatetoUpdate','$company_valuation','$revenue_multiple','$ebitda_mutliple','$pat_mutliple','$listingstatusvalue','$exitstatusvalue','$revenue','$ebitda','$pat','$price_to_book','$book_value_per_share','$price_per_share')";
											echo "<br>@@@@ :".$insertcompanysql;
											if ($rsinsert = mysql_query($insertcompanysql))
											{
												echo "<br>Insert PE-" .$insertcompanysql;
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

                                                                                                        	for ( $i =0; $i < count($dbtypearray); $i +=1)
                                                                                                                {
                                                                                                                    if(in_array($dbtypearray[$i],$showaspevcarray)==true)
                                                                                                                   {  // echo "<Br>1 " .$dbtypearray[$i];
                                                                                                                     $insertTypesql="insert into peinvestments_dbtypes values($PEId,'$dbtypearray[$i]',1)";
                                                                                                                   }
                                                                                                                    else
                                                                                                                     {  
                                                                                                                       //echo "<br>0 " .$dbtypearray[$i];    }
                                                                                                                      $insertTypesql="insert into peinvestments_dbtypes values($PEId,'$dbtypearray[$i]',0)";
                                                                                                                     }
                                                                                                                     echo "<bR>***".$insertTypesql;
                                                									if($rsupdateType = mysql_query($insertTypesql))
                                                									{
                                                									}
                                                                                                                }

												$datedisplay =  $fullDateAfter; //(date("Y F", $fullDateAfter));
											?>
											<Br>
											<tr bgcolor="#00CC66"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $PEId. " : " .$datedisplay . " - " .$portfoliocompany ; ?>&nbsp; --> Inserted</td> </tr>
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
	function insert_company($companyname,$industryId,$sector,$web,$city,$region,$regionId)
	{
		$dbpecomp = new dbInvestments();
		$getPECompanySql = "select PECompanyId from pecompanies where companyname= '$companyname'";
		//echo "<br>select--" .$getPECompanySql;
		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
		{
			$pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
			//echo "<br>%%%%%".$pecomp_cnt;
			if ($pecomp_cnt==0)
			{
					//insert pecompanies
					$insPECompanySql="insert into pecompanies(companyname,industry,sector_business,website,city,region,RegionId)
					values('$companyname','$industryId','$sector','$web','$city','$region',$regionId)";
					//echo "<br>Ins company sql=" .$insPECompanySql;
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
		$dbpecomp.closeDB();
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
	$getInvestorIdSql = "select CIAId from advisor_cias where cianame like '$cianame'";
	echo "<br>select--" .$getInvestorIdSql;
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
	$dblink.closeDB();

}

// the following function inserts advisor_PEIds in the peinvestments_advisor table
	function insert_Investment_AdvisorInvestors($dealId,$ciaid)
	{
		$DbAdvInv = new dbInvestments();
		$getDealInvSql="Select PEId,CIAId from peinvestments_advisorinvestors where PEId=$dealId and CIAId=$ciaid";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into peinvestments_advisorinvestors values($dealId,$ciaid)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
				//	echo "<bR>---Advisor Investors ";
                                        return true;
				}
			}
		}
		$DbAdvInv.closeDB();
}

// the following function inserts advisor_PEIds in the peinvestments_advisor table
	function insert_Investment_AdvisorCompany($dealId,$ciaid)
	{
		$DbAdvComp= new dbInvestments();
		$getDealInvSql="Select PEId,CIAId from peinvestments_advisorcompanies where PEId=$dealId and CIAId=$ciaid";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into peinvestments_advisorcompanies values($dealId,$ciaid)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
				//	echo "<br>---Advisor Companies ";
					return true;
				}
			}
		}
		$DbAdvComp.closeDB();
}


/* inserts and return the investor id */
	function return_insert_get_Investor($investor)
	{
		$dblink= new dbInvestments();
		$investor=trim($investor);
		$getInvestorIdSql = "select InvestorId from peinvestors where Investor like '$investor%'";
		//echo "<br>select--" .$getInvestorIdSql;
		if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
		{
			$investor_cnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;
			if ($investor_cnt==0)
			{
					//insert acquirer
					$insAcquirerSql="insert into peinvestors(Investor) values('$investor')";
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
		//$dblink.close();
		$dblink.closeDB();
		//mysql_close($dblink);
	}


	// the following function inserts investor and the peid in the peinvestments_investors table
	function insert_Investment_Investors($dealId,$investorId)
	{
		$DbInvestInv = new dbInvestments();
		//$dbslink = mysqli_connect("ventureintelligence.ipowermysql.com", "root",  "", "peinvestmentdeals");
		$getDealInvSql="Select PEId,InvestorId from peinvestments_investors where PEId=$dealId and InvestorId=$investorId";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into peinvestments_investors values($dealId,$investorId)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
                                  echo "<br> Insert into investments_investors ";
					return true;
				}
			}
		}
		$DbInvestInv.closeDB();
}

?>