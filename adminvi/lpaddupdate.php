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

							$institution = $_POST['txtinstitutionname'];
							$contactperson = $_POST['txtcontactperson'];
                            $designation = $_POST['txtdesignation'];
							$email= $_POST['txtemail'];  //industry id directly
							$address1=$_POST['txtaddress1'];
							$address2=$_POST['txtaddress2'];
							$city=ucfirst($_POST['citysearch']);
							$pincode= $_POST['txtpincode'];
							$countryIdtoUpdate= $_POST['txtstate'];
							$country='';
							$countrySql = "select countryid,country from country where countryid='".$countryIdtoUpdate."'";
							//echo $countrySql;

                                if ($staters = mysql_query($countrySql))
                                                        {
                                                          $state_cnt = mysql_num_rows($staters);
                                                        }
                                                        if($state_cnt > 0)
                                                        {
                                                            $myrow=mysql_fetch_row($staters, MYSQL_BOTH);
                                                            {
                                                            	$id = $myrow[0];
                                                                $name = $myrow[1];
                                                                $country = $name;
                                                            }
                                                        } 
							$phone=$_POST['txtphone'];
							$fax=$_POST['txtfax'];
							$website=$_POST['txtwebsite'];
							$typeofinstitution=$_POST['txttypeofinstitution'];
                                                       
							$institution=trim($institution);
                            $contactperson =trim($contactperson);
                            $address1 =trim($address1);  
                            $address2 = trim($address2);
							


							
							
							//echo "<br>**" .$fulldate ."--".$fullDateAfter;

							/*if (trim($portfoliocompany) !="")
							{*/
								
								/*$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$region,$RegionIdtoUpdate,$StateIdtoUpdate,$state);
								if($companyId==0)
								{
									$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$region,$RegionIdtoUpdate,$StateIdtoUpdate,$state);
								}
								
								if ($companyId >0)
								{*/
									/*$mainsectorid=insert_mainsector($mainsector,$indid);
									if($mainsectorid==0)
									{
										$mainsectorid=insert_mainsector($mainsector,$indid);
									}
									$subsectorid=insert_subsector($mainsectorid,$companyId,$subsector,$addsubsector);
*/
									/*$pegetInvestmentsql = "select c.PECompanyId,ma.PECompanyId,dates from pecompanies as c,
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
									{*/
                                                                               /* if($_POST['hideIPOId']!='' && $_POST['hideIPOId']>0 ){
                                                                                    $PEId   = $_POST['hideIPOId'];
                                                                                   }else{
											$PEId= rand();
                                                                                   }
											
											$insertcompanysql="";*/
                                                                                        
											$insertcompanysql= "INSERT INTO limited_partners (InstitutionName,ContactPerson,Designation,Email,Address1,Address2,City,PinCode,Country,Phone,Fax,Website,TypeOfInstitution)
											VALUES ('".addslashes($institution)."','".addslashes($contactperson)."','$designation','$email','".addslashes($address1)."','".addslashes($address2)."','$city', '$pincode','$country','$phone','$fax','$website','$typeofinstitution')";
                                                                                        
											//echo "<br>@@@@ :".$insertcompanysql;
											if ($rsinsert = mysql_query($insertcompanysql))
											{
												echo "<br>LP Directory inserted successfully" ;
											?>
											<Br>
											<tr bgcolor="#00CC66"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $institution; ?>&nbsp; --> Inserted</td> </tr>
											<tr > <td width=20% style="font-family: Verdana; font-size: 8pt"><a href="lpadd.php">Back to add LP</a></td> </tr>
											<?php
											}
											else
											{
											?>
											<tr bgcolor="red"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $institution; ?>&nbsp; --> Insert failed</td> </tr>
											<tr > <td width=20% style="font-family: Verdana; font-size: 8pt"><a href="lpadd.php">Back to add LP</a></td> </tr>
											<?php
											}
									//	echo "<br> insert-".$insertcompanysql;
									//}
									/*elseif($investment_cnt>= 1)
									{*/
									?>
									<!-- <tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; --><!--PE Deal already exists</td> </tr> -->
									<?php
									//}
								//}//if companyid >0 loop ends
							//} //if $portfoliocompany !=null loop ends

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