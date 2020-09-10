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
							$listingstatusvalue = $_POST['listingstatus'];
                                                        $exitstatusvalue = $_POST['exitstatus'];
							//echo "<br>company. ".$portfoliocompany;
							$indid= $_POST['txtindustry'];  //industry id directly
							$sector=$_POST['txtsector'];
							$mainsector=$_POST['txtmainsector'];
							$subsector=$_POST['txtsubsector'];
							$addsubsector=$_POST['txtaddsubsector'];
							$DealAmount=$_POST['txtamount'];
                                                        $amounttoUpdate_INR=$_POST['txtamount_INR'];
							if($DealAmount<=0)
								$DealAmount=0;
							$Round=$_POST['txtround'];
							$StageId=$_POST['txtstage'];  // txtstage gives directly the stageid

							$col6=$_POST['txtinvestors'];//die;
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
							$city=ucfirst($_POST['citysearch']); //15
							$StateIdtoUpdate= $_POST['txtstate'];
							$state='';
							$stateSql = "select state_id,state_name from state where state_id=".$StateIdtoUpdate;
                                if ($staters = mysql_query($stateSql))
                                                        {
                                                          $state_cnt = mysql_num_rows($staters);
                                                        }
                                                        if($state_cnt > 0)
                                                        {
                                                            $myrow=mysql_fetch_row($staters, MYSQL_BOTH);
                                                            {
                                                                $id = $myrow[0];
                                                                $name = $myrow[1];

                                                                $state = $name;
                                                            }
                                                        } 
					
                                                        $RegionIdtoUpdate=$_POST['txtregion']; //16
                                                        $region='';
                                                        $regionSql = "select RegionId,Region from region where RegionId=".$RegionIdtoUpdate;
                                                        if ($regionrs = mysql_query($regionSql))
                                                        {
                                                          $region_cnt = mysql_num_rows($regionrs);
                                                        }
                                                        if($region_cnt > 0)
                                                        {
                                                            $myrow=mysql_fetch_row($regionrs, MYSQL_BOTH);
                                                            {
                                                                $id = $myrow[0];
                                                                $name = $myrow[1];

                                                                $region = $name;
                                                            }
                                                        } 
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
							
							$moreinfor=$_POST['txtmoreinfor'];
							//$comment=str_replace('"','',$comment);
							//$moreinfor=str_replace('"','',$moreinfor); // special characters
							$comment=str_replace("'","''",$comment);
							$moreinfor=str_replace("'","''",$moreinfor);
                                                        
                                                        $financial_year=$_POST['txtyear'];
                                                        
							$validation=$_POST['txtvalidation'];
							$link=$_POST['txtlink'];
							$flagdeletion=0;
							$company_valuation=0;
							$revenue_multiple=0;
							$ebitda_multiple=0;
                                                        $pat_multiple=0;

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
                                                        $company_valuation1=$_POST['txtcompanyvaluation1'];
							if($company_valuation1=="")
							  $company_valuation1=0;
                                                        $company_valuation2=$_POST['txtcompanyvaluation2'];
							if($company_valuation2=="")
							  $company_valuation2=0;

							$revenue_multiple=$_POST['txtrevenuemultiple'];
							if($revenue_multiple=="")
							   $revenue_multiple=0;

							$revenue_multiple1=$_POST['txtrevenuemultiple1'];
							if($revenue_multiple1=="")
							   $revenue_multiple1=0;

							$revenue_multiple2=$_POST['txtrevenuemultiple2'];
							if($revenue_multiple2=="")
							   $revenue_multiple2=0;

							$ebitda_multiple=$_POST['txtEBITDAmultiple'];
							if($ebitda_multiple=="")
							   $ebitda_multiple=0;

							$ebitda_multiple1=$_POST['txtEBITDAmultiple1'];
							if($ebitda_multiple1=="")
							   $ebitda_multiple1=0;
							   
							$ebitda_multiple2=$_POST['txtEBITDAmultiple2'];
							if($ebitda_multiple2=="")
							   $ebitda_multiple2=0;
                                                        
							$pat_multiple=$_POST['txtpatmultiple'];
							if($pat_multiple=="")
							  $pat_multiple=0;

							$pat_multiple1=$_POST['txtpatmultiple1'];
							if($pat_multiple1=="")
							  $pat_multiple1=0;

							$pat_multiple2=$_POST['txtpatmultiple2'];
							if($pat_multiple2=="")
							  $pat_multiple2=0;
							   
							// New feature 08-08-2016 start
							
								$price_to_book=$_POST['txtpricetobook'];
								if($price_to_book=="")
								   $price_to_book=0;
								   
								   
								
								$book_value_per_share=$_POST['txtbookvaluepershare'];
								if($book_value_per_share=="")
								   $book_value_per_share=0;
								   
								   
								
								$price_per_share=$_POST['txtpricepershare'];
								   
							
							// New feature 08-08-2016 end
                                                            $txttot_debt=$_POST['txttot_debt'];
                                                            $txtcashequ=$_POST['txtcashequ'];

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
                                                       // $showpevcdeal=$_POST['showaspevc'];
                                                        if($_POST['dbtype'])
                                                        {
                                                          foreach($dbtypedeal as $dbtype)
                                                        {
                                                          $dbtypearray[]=$dbtype;
                                                          //echo "<Br>!!".$dbtype;
                                                        }
                                                        }
                                                        //echo "<Br>^^^ ".$showpevcdeal;
                                                       	/*if($_POST['showaspevc'])
                                                       	{
                                                         foreach($showpevcdeal as $showpevc)
							{
                                                           $showaspevcarray[]=$showpevc;
                                                           //echo "<br>*** ".$showpevc;
                                                         //echo "<br>****----" .$showpevc;
							//	$stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
							//	$stageidvalue=$stageidvalue.",".$stage;
							}
                                                        }*/

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
								$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$region,$RegionIdtoUpdate,$state,$StateIdtoUpdate);
								if($companyId==0)
								{
									$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$region,$RegionIdtoUpdate,$state,$StateIdtoUpdate);
								}
								//$companyId=0;
								//echo "<br>Company id--" .$companyId;
								if ($companyId >0)
								{
									$mainsectorid=insert_mainsector($mainsector,$indid);
									if($mainsectorid==0)
									{
										$mainsectorid=insert_mainsector($mainsector,$indid);
									}
									$subsectorid=insert_subsector($mainsectorid,$companyId,$subsector,$addsubsector);

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
									if($investment_cnt>=0)
									{
                                                                                if($_POST['hideIPOId']!='' && $_POST['hideIPOId']>0 ){
                                                                                    $PEId   = $_POST['hideIPOId'];
                                                                                   }else{
											$PEId= rand();
                                                                                   }
											//echo "<br>random MandAId--" .$PEId;
											$insertcompanysql="";
                                                                                        
											$insertcompanysql= "INSERT INTO peinvestments (PEId,PECompanyId,dates,amount,Amount_INR,round,StageId,stakepercentage,comment,MoreInfor,Validation,InvestorType,Deleted,hideamount,hidestake,SPV,Link,uploadfilename,source,Valuation,FinLink,AggHide,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,listing_status,Exit_Status,Revenue,EBITDA,PAT,price_to_book,book_value_per_share,price_per_share,Company_Valuation_pre,Company_Valuation_EV,Revenue_Multiple_pre,Revenue_Multiple_EV,EBITDA_Multiple_pre,EBITDA_Multiple_EV,PAT_Multiple_pre,PAT_Multiple_EV,Total_Debt,Cash_Equ,financial_year)
											VALUES ($PEId,$companyId,'$fullDateAfter','$DealAmount','$amounttoUpdate_INR','$Round',$StageId,$stakepercentage,'$comment','$moreinfor', '$validation','$investortype',$flagdeletion,$hideamount,$hidestakevalue,$spvdebt,'$link','','$sourcename','$valuation','$finlink',$hideAggregatetoUpdate,$company_valuation1,$revenue_multiple1,$ebitda_multiple1,$pat_multiple1,'$listingstatusvalue',$exitstatusvalue,$revenue,$ebitda,$pat,$price_to_book,$book_value_per_share,$price_per_share,'$company_valuation','$company_valuation2','$revenue_multiple','$revenue_multiple2','$ebitda_multiple','$ebitda_multiple2','$pat_multiple','$pat_multiple2','$txttot_debt','$txtcashequ','$financial_year')";
                                                                                        
											//echo "<br>@@@@ :".$insertcompanysql;
											if ($rsinsert = mysql_query($insertcompanysql))
											{
												echo "<br>Insert PE-" .$insertcompanysql;
												/* foreach ($investorString as $inv)
													{
														if(trim($inv)!="")
														{
															$investorIdtoInsert=return_insert_get_Investor(trim($inv));
															if($investorIdtoInsert==0)
															{
																$investorIdtoInsert= return_insert_get_Investor(trim($inv));
															}
																$insDeal_investors= insert_Investment_Investors($PEId,$investorIdtoInsert);

														}
													}*/

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

                                                   /* for ( $i =0; $i < count($dbtypearray); $i +=1)
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
                                                        }*/
                                                    for ( $i =0; $i < count($dbtypearray); $i++){
														$insertTypesql1="insert into peinvestments_dbtypes values($PEId,'$dbtypearray[$i]',0)";
														 echo "<bR>***".$insertTypesql1;
                                                		if($rsupdateType = mysql_query($insertTypesql1))
                                                		{
                                                		}
                                                   }
                                                   for ( $i =0; $i < count($showaspevcarray); $i++){
                                                   		if($showaspevcarray[$i]!="")
                                                   		{
                                                   			$showvalue=1;
                                                   		}
                                                   		else{
                                                   			$showvalue=0;
                                                   		}
														$insertTypesql2="insert into peinvestments_dbtypes values($PEId,'$showaspevcarray[$i]','$showvalue')";
														 echo "<bR>***".$insertTypesql2;
                                                		if($rsupdateType = mysql_query($insertTypesql2))
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
									/*elseif($investment_cnt>= 1)
									{*/
									?>
									<!-- <tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; --><!--PE Deal already exists</td> </tr> -->
									<?php
									//}
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
	function insert_company($companyname,$industryId,$sector,$web,$city,$region,$regionId,$state,$stateId)
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
					$insPECompanySql="insert into pecompanies(companyname,industry,sector_business,website,city,AdCity,region,RegionId,state,stateid)
					values('$companyname','$industryId','$sector','$web','$city','$city','$region',$regionId,'$state','$stateId')";
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
		echo "<br>select--" .$getInvestorIdSql;
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
				$insDealInvSql="insert into peinvestments_investors (PEId,InvestorId) values($dealId,$investorId)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
                                  echo "<br> Insert into investments_investors ";
					return true;
				}
			}
		}
		$DbInvestInv.closeDB();
}

function insert_mainsector($mainsector,$indid)
	{
		$dbpemainsector = new dbInvestments();
		$peMainSectorSql= "select sector_id from pe_sectors where sector_name = '$mainsector' AND industry=$indid";
		if($getPEMainSector = mysql_query($peMainSectorSql))
		{
			$mainsector_count=mysql_num_rows($getPEMainSector);
			if($mainsector_count==0)
			{
				$insMainSectorSql="insert into pe_sectors(sector_name,industry) values('$mainsector',$indid)";
				if($rsinsdealmainsector = mysql_query($insMainSectorSql))
				{
					$mainsectorid=0;
					return $mainsectorid;
                   
					
				}
			}
			elseif($mainsector_count>=1)
			{
				While($myrow=mysql_fetch_array($getPEMainSector, MYSQL_BOTH))
				{
					$mainsectorid = $myrow[0];
					return $mainsectorid;
				}
			}

		}
		$dbpemainsector.closeDB();

	}
	// function insert_subsector($mainsectorid,$companyId,$subsector,$addsubsector)
	// {
	// 	$dbpesubsector = new dbInvestments();
	// 	$peSubSectorSql= "select subsector_id from pe_subsectors where sector_id = '$mainsectorid' and PECompanyId='$companyId'";
	// 	if($getPESubSector = mysql_query($peSubSectorSql))
	// 	{
	// 		$subsector_count=mysql_num_rows($getPESubSector);
	// 		if($subsector_count==0)
	// 		{
	// 			$insSubSectorSql="insert into pe_subsectors(sector_id,PECompanyId,subsector_name,Additional_subsector) values('$mainsectorid','$companyId','$subsector','$addsubsector')";
	// 			if($rsinsdealsubsector = mysql_query($insSubSectorSql))
	// 			{
                                  
 //                    $subsectorid=0;
	// 				return $subsectorid;
					
	// 			}
	// 		}
	// 		elseif($subsector_count>=1)
	// 		{
	// 			While($myrow=mysql_fetch_array($getPESubSector, MYSQL_BOTH))
	// 			{
	// 				$subsectorid = $myrow[0];
	// 				return $subsectorid;
	// 			}
	// 		}
	// 	}
	// 	$dbpesubsector.closeDB();

	// }

	function insert_subsector($sectorId,$companyId,$subsectorname,$addsubsectorname){
            
            $subsectorname=trim($subsectorname);
            $dbslinkss = new dbInvestments();
            $getsectorIdSql="select subsector_id from pe_subsectors where subsector_name='$subsectorname' AND sector_id=$sectorId AND PECompanyId=$companyId";
            
            if($rsgetsector=mysql_query($getsectorIdSql))
            {
                $sector_cnt=mysql_num_rows($rsgetsector);
               
                if($sector_cnt==0)
                {
                    //insert deal ..mostly it wont get inserted as new..only standard 9 stages already exists
                    $inssectorIdSql ="insert into pe_subsectors(sector_id,PECompanyId,subsector_name,Additional_subsector) values($sectorId,$companyId,'$subsectorname','$addsubsectorname')";
                    if($rsInsSector = mysql_query($inssectorIdSql))
                    {
                        return true;
                    }
                }
                elseif($sector_cnt==1)
                {
                    While($myrow=mysql_fetch_array($rsgetsector, MYSQL_BOTH))
                    {
                        return true;
                    }
                }
            }
            $dbslinkss.close();
        
        }

?>