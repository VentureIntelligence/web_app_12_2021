<?php include_once("../globalconfig.php"); ?>
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
							//echo "<br>company. ".$portfoliocompany;
							$indid= $_POST['txtindustry'];  //industry id directly
							$sector=$_POST['txtsector'];
							$col6=$_POST['txtinvestors'];
							/*
								$col6 is investors
								read the investor column in loop and insert invidual investors into peinvestors table
								taking the InvestorId and insert in the table
							*/
							$investorString=str_replace('"','',$col6);
							$investorString=explode(",",$investorString);
							//echo "<br>%%%%%%".$investorString;

							if($_POST['chkmultipleround'])
							{
								//echo"<br>***************";
								$multipleround=1;
							}
							else
							{$multipleround=0;
							}
							if($_POST['chkfollowonfund'])
							{
								//echo"<br>***************";
								$followonfund=1;
							}
							else
							{$followonfund=0;
							}
							if($_POST['chkexited'])
							{
								//echo"<br>***************";
								$exitedvalue=1;
							}
							else
							{$exitedvalue=0;
							}
							
							$monthtoAdd=$_POST['month1'];
							$yeartoAdd=$_POST['year1'];
							$IPODate=returnDate($monthtoAdd,$yeartoAdd);
							$website=$_POST['txtwebsite'];
							$city=$_POST['txtcity'];
							//$region=$_POST['txtregion'];
							$RegionIdtoUpdate=$_POST['txtregion'];
                                                        if($_POST['chkhideAgg'])
                                                	 { $hideAggregatetoUpdate=1;
                                                	 }
                                                	 else
                                                	 { $hideAggregatetoUpdate=0;
                                                	 }
						//	echo "<br>---" .$RegionIdtoUpdate;

						 	//$region=return_insert_get_RegionId($RegionIdtoUpdate);
						 //	echo "<Br-----" .$region;

							$comment=$_POST['txtcomment'];
							$comment=str_replace('"','',$comment);
							$moreinfor=$_POST['txtmoreinfor'];
							$moreinfor=str_replace('"','',$moreinfor);

							$validation=$_POST['txtvalidation'];
							$link=$_POST['txtlink'];
							$flagdeletion=0;
							
							$fullDateAfter=$IPODate;
							//echo "<br>**" .$fulldate ."--".$fullDateAfter;

							if (trim($portfoliocompany) !="")
							{
								
								$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$RegionIdtoUpdate);
								//echo "<bR>####---------------------";
								if($companyId==0)
								{
									$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$RegionIdtoUpdate);
									echo "<bR>CompanyInserted";
								}

								if ($companyId >0)
								{
									$pegetInvestmentsql = "select c.PECompanyId,ma.InvesteeId,DealDate from pecompanies as c,
									angelinvdeals as ma where ma.PECompanyId = c.PECompanyId and
									ma.DealDate = '$fullDateAfter' and c.PECompanyId = $companyId ";

									//echo "<br>checking pe record***" .$pegetInvestmentsql;
									//echo "<br>Company id--" .$companyId;
									if ($rsInvestment = mysql_query($pegetInvestmentsql))
									{
									$investment_cnt = mysql_num_rows($rsInvestment);
									// echo "<br>Count**********-- " .$investment_cnt ;
									}
									if($investment_cnt>=0)
									{
											$PEId= rand();
											//echo "<br>random MandAId--" .$PEId;
											$insertcompanysql="";
											$insertcompanysql= "INSERT INTO angelinvdeals (AngelDealId,InvesteeId,DealDate,MultipleRound,FollowonVCFund,Exited,Comment,MoreInfor,Validation,Link,Deleted,AggHide)
											VALUES ($PEId,$companyId,'$fullDateAfter',$multipleround,$followonfund,$exitedvalue,'$comment','$moreinfor', '$validation','$link',$flagdeletion,$hideAggregatetoUpdate)";
										

											if ($rsinsert = mysql_query($insertcompanysql))
											{
											    //echo "<br>Insert angel Inv-" .$insertcompanysql;
											     foreach ($investorString as $inv)
												{
                                                                                                  //echo "<br>~~~~~~~~~~~~~~~~~~~~".$inv;
												    if(trim($inv)!=="")
												    {
													$investorIdtoInsert=return_insert_get_Investor(trim($inv));
												//	echo "<br>***".$investorIdtoInsert;
													if($investorIdtoInsert==0)
													{
													    $investorIdtoInsert= return_insert_get_Investor(trim($inv));
													}
													    $insDeal_investors= insert_Investment_Investors($PEId,$investorIdtoInsert);
												    }
												}
												
												$datedisplay =  $fullDateAfter; //(date("Y F", $fullDateAfter));
											?>
											<Br>
											<tr bgcolor="#00CC66"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $datedisplay . " - " .$portfoliocompany ; ?>&nbsp; --> Angel Deal Inserted</td> </tr>
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
									// elseif($investment_cnt>= 1)
									// {
									?>
									<!-- <tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; Angel Deal already exists</td> </tr> -->
									<?php
									// }
								}//if companyid >0 loop ends
							} //if $portfoliocompany !=null loop ends

} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;

//End of peinvestments insert


//function to get RegionId
	function return_insert_get_RegionId($regionid)
	{
		$dbregionlink = new dbInvestments();
		$getRegionIdSql = "select Region from region where RegionId=$regionid";
		if ($rsgetInvestorId = mysql_query($getRegionIdSql))
		{
			$regioncnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;

			if($regioncnt==1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$regionId = $myrow[0];
					//echo "<br>Insert return investor id--" .$invId;
					return $regionId;
				}
			}
		}
		$dbregionlink.close();
	}

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
	function insert_company($companyname,$industryId,$sector,$web,$city,$regionId)
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
					$insPECompanySql="insert into pecompanies(companyname,industry,sector_business,website,city,RegionId)
					values('$companyname',$industryId,'$sector','$web','$city',$regionId)";
				//	echo "<br>Ins company sql=" .$insPECompanySql;
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
		$getInvestorIdSql = "select InvestorId from peinvestors where Investor= '$investor'";
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


	// the following function inserts investor and the peid in the peinvestments_investors table
	function insert_Investment_Investors($dealId,$investorId)
	{
		$DbInvestInv = new dbInvestments();
		//$dbslink = mysqli_connect("ventureintelligence.ipowermysql.com", "root",  "", "peinvestmentdeals");
		$getDealInvSql="Select AngelDealId,InvestorId from angel_investors where AngelDealId=$dealId and InvestorId=$investorId";

		//echo "<br>@@^^^^@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into angel_investors values($dealId,$investorId)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
					return true;
				}
			}
		}
		$DbInvestInv.close();
}

?>