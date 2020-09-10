<?php include_once("../../globalconfig.php"); ?>
<?php
	require("../dbconnectvi.php");
     $Db = new dbInvestments();
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
     	session_start();
	 	if (session_is_registered("SessLoggedAdminPwd")  && session_is_registered("SessLoggedIpAdd"))
	 	{

			//$file ="importfiles/peinvestmentsexport.txt";
			$currentdir=getcwd();
			$target = $currentdir . "/importfiles/" . basename($_FILES['txtmamafilepath']['name']);
			$file = "importfiles/" . basename($_FILES['txtmamafilepath']['name']);
			if (!(file_exists($file)))
			{

				if(move_uploaded_file($_FILES['txtmamafilepath']['tmp_name'], $target))
				{
					//echo "<Br>The file ". basename( $_FILES['txtmamafilepath']['name']). " has been uploaded";
					echo "<br>File is getting uploaded . Please wait..";
					$file = "importfiles/" . basename($_FILES['txtmamafilepath']['name']);
				//	echo "<br>----------------" .$file;
				}
				else
				{
					echo "<br>Sorry, there was a problem uploading the file.";
				}
			}
			$importTotal=0;

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Import MA_MA data : : Contact TSJ Media : :</title>
<SCRIPT LANGUAGE="JavaScript">
</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<form name="mamaexitviewimport" >
<table border=1 cellpadding=3  cellspacing=0 bordercolor=blue  align=center width="50%" style="font-family: Verdana; font-size: 8pt">
<?php

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
							//echo "<br>full string- " .$i;
								if($i != "")
								{
								//	echo "<br>full string- " .$i;
									$fstring = explode("\t", $i);
									$portfoliocompany = trim($fstring[0]);
									//echo "<br>1. company. ".$portfoliocompany;

									$acquirer=trim($fstring[1]);
									$acquirer=str_replace('"','',$acquirer);
									//echo "<br>2--";

									$industryname = trim($fstring[2]);
									$sector=trim($fstring[3]);
									$DealAmount=$fstring[4];
									if($DealAmount<=0)
									{	$DealAmount=0; }
									//echo "<br>3--";
									$stakepercentage=$fstring[5];
									if($stakepercentage<=0)
									{	$stakepercentage=0;	}
									//echo "<br>4--";
									$MandADate=$fstring[6];


									$mthSplit=explode("-",$MandADate);
									$mthtopass=trim($mthSplit[0]);
									$yrtopass=trim($mthSplit[1]);
									$mthname= returnMonth($mthtopass);
									//echo "<br>Yr passed**".$mthname."-".$yrtopass;
									$fullDateAfter = returnDate(trim($mthname),trim($yrtopass));
									//echo "<bR>5. date-".$fullDateAfter;

									$dealType=$fstring[7];
									//echo "<br>6 Deal Type --".$dealType;
									$MADealTypeId=getMAMADealTypeId($dealType);
									//echo "<br>7. Deal Type Id- ".$MADealTypeId;


									$col6=$fstring[8];
									$TargetAdvisorString=str_replace('"','',$col6);
									$TargetAdvisorString=explode(",",$TargetAdvisorString);
									//echo "<br>8--";
									$col7=$fstring[9];
									$AcquirorString=str_replace('"','',$col7);
									$AcquirorString=explode(",",$AcquirorString);

									//echo "<br>9--";

									$targetcity=$fstring[10];
								//	if((trim($targetcity)==" ") || (trim($targetcity=="")))
								//		$targetcityId=11;  // otherwise assign city to "--" so that 11 id will be retrieved
								//	elseif($targetcity!="")
								//		$targetcityId=insert_city($targetcity);

									//echo "<BR>10- City id- ".$targetcityId;

									$targetcountry=$fstring[11];
									if(trim($targetcountry)=="")
										$targetCountryId=11;  // otherwise assign countryname to "--" so that 11 id will be retrieved
									elseif($targetcountry!="")
										$targetCountryId=insert_country($targetcountry);
									//echo "<BR>11- Country id- ".$targetCountryId;

									$acquirercity=$fstring[12];
								//	if(trim($acquirercity)=="")
								//		$acquirercityId=11;  // otherwise assign city to "--" so that 11 id will be retrieved
								//	elseif($acquirercity!="")
								//		$acquirercityId=insert_city($acquirercity);
									//echo "<br>12 Acquirer CityId--".$acquirercityId;

									$acquirercountry=$fstring[13];
									if(trim($acquirercountry)=="")
										$acquirerCountryId=11;  // otherwise assign countryname to "--" so that 11 id will be retrieved
									elseif($acquirercountry!="")
										$acquirerCountryId=insert_country($acquirercountry);
									//echo "<br>13- Acquirer countrtyid--".$acquirerCountryId;


									$AcquirerId=0;
									if(trim($acquirer)!="")
									{
									//	echo "<br>14 --" ;
										$AcquirerId=returnAcquirerId($acquirer,$acquirercity,$acquirerCountryId);
										if($AcquirerId==0)
										{
											$AcquirerId=returnAcquirerId($acquirer,$acquirercity,$acquirerCountryId);

										}
										//echo "<br>15- Acquirer Id-".$AcquirerId ."-" .$acquirer;
									}


									$targetwebsite=$fstring[14];

									$comment=trim($fstring[15]);
									$comment=str_replace('"','',$comment);
									$moreinfor=trim($fstring[16]);
									$moreinfor=str_replace('"','',$moreinfor);

									$validation=trim($fstring[17]);	//valiation text
									$bracketflag=$fstring[18];
									if($bracketflag!=1)
										$bracketflag=0;


									$flagdeletion=0; //if =1, hide from the view

									$region="";

									//echo "<br>$$$$$$$$$$$$$$$$$$$$$$$$$$$";
								//echo "<br>-*-" .$portfoliocompany;
if (trim($portfoliocompany) !="")
								{

									$indid=insert_industry(trim($industryname));
									//echo "<br>First Industryid-".$indid;
									if($indid==0)
									{
										$indid= insert_industry(trim($industryname));
										//echo "<br>AFter insert Industryid-".$indid;
									}
									//echo "<br>Industryid-".$indid;
									$companyId=insert_company($portfoliocompany,$indid,$sector,$targetwebsite,$region,$targetCountryId,$targetcity);
									if($companyId==0)
									{
										$companyId=insert_company($portfoliocompany,$indid,$sector,$targetwebsite,$region,$targetCountryId,$targetcity);
									}
								//	echo "<Br>companyId--" .$companyId;
								//	$companyId=0;
									if ($companyId >0)
									{
										$pegetInvestmentsql = "select c.PECompanyId,ma.PECompanyId,DealDate from pecompanies as c,
										mama as ma where ma.PECompanyId = c.PECompanyId and
										ma.DealDate = '$fullDateAfter' and c.PECompanyId = $companyId ";
										//echo "<br>checking pe record***" .$pegetInvestmentsql;
										if ($rsInvestment = mysql_query($pegetInvestmentsql))
										{	$investment_cnt = mysql_num_rows($rsInvestment);
										}
										if($investment_cnt==0)
										{
											$MAMAId= rand();
											//echo "<br>random MandAId--" .$MAMAId;
											$insertcompanysql="";
											$createddate=date("Y-m-d")." ".date("H:i:s");
											$modifieddate=$createddate;

											$insertcompanysql= "INSERT INTO mama (MAMAId,PECompanyId,Amount,Stake,DealDate,MADealTypeId,AcquirerId,Comment,MoreInfor,Validation,Asset,Deleted,CreatedDate,ModifiedDate)
											VALUES ($MAMAId,$companyId,$DealAmount,$stakepercentage,'$fullDateAfter',$MADealTypeId,$AcquirerId,'$comment','$moreinfor','$validation',$bracketflag,$flagdeletion,'$createddate','$modifieddate')";
										//	echo "<br>Insert MAMA Query- ".$insertcompanysql;
											if ($rsinsert = mysql_query($insertcompanysql))
											{

												foreach ($TargetAdvisorString as $targetadvisor)
												{
													if(trim($targetadvisor)!="")
													{
														//echo "<br>Advisor--" .$targetadvisor;
														$TargetAdvisorIdtoInsert=insert_get_CIAs(trim($targetadvisor));
														if($advisorIdtoInsert==0)
														{
															$TargetAdvisorIdtoInsert=insert_get_CIAs(trim($targetadvisor));
														}
															$insadvcompany=insert_Investment_AdvisorCompany($MAMAId,$TargetAdvisorIdtoInsert);
															echo "<br>-TargetAdvisor Id-".$TargetAdvisorIdtoInsert;
													}
												}
												foreach ($AcquirorString as $acquiroradvisor)
												{
													if(trim($acquiroradvisor)!="")
													{
														$AcquirorAdvisorIdtoInsert=insert_get_CIAs(trim($acquiroradvisor));
														if($AcquirorAdvisorIdtoInsert==0)
														{
															$AcquirorAdvisorIdtoInsert=insert_get_CIAs(trim($acquiroradvisor));
														}
														$insadvcompany=insert_Investment_AdvisorAcquiror($MAMAId,$AcquirorAdvisorIdtoInsert);
														//echo "<br>-Acquiror Advisor Id-".$AcquirorAdvisorIdtoInsert;
													}
												}
												$importTotal=$importTotal+1;
												$datedisplay =  $fullDateAfter;

												 echo "<br>" .$portfoliocompany. "-" .$datedisplay . " - Imported  --> Inserted";
												 echo "<br>";
											}
											else
											{
											?>
												<tr bgcolor="red"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; --> Import failed</td> </tr>
											<?php
											}

										} //count=0 loop ends
										elseif($investment_cnt>= 1)
										{
										?>
											<tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; -->MA_MA Deal already exists</td> </tr>

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
			<tr> <Td><b> File dont exist to read </b> </td></tR>
			</table>

			<?php
			}

}  //if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;

//End of peinvestments insert
?>



</table>
<table align="center" border="1" cellpadding="0" cellspacing="0" width="765">
<tr> <Td><b> Import count - <?php echo $importTotal; ?> </b> </td></tR>
</table>


</form></body></html>

<?php
function returnDate($mth,$yr)
{
	//this function returns the date
  //  echo "<Br>".trim($yr)."-".trim($mth);

	$fulldate=trim($yr)."-".trim($mth)."-01";

//	echo "<br>Inside function-- ".$fulldate;
	if (checkdate(01,trim($mth),trim($yr)))
	{
		return $fulldate;
	}
}

function returnMonth($mthname)
{
	$retValue =0;
//	echo "<br>Name" .$mthname;
	if($mthname =="Jan")
		//retValue = 01;
		return 1;
	elseif($mthname =="Feb")
		return 2;
	elseif($mthname =="Mar")
		return 3;
	elseif($mthname =="Apr")
		return 4;
	elseif($mthname =="May")
		return 5;
	elseif($mthname =="Jun")
		return 6;
	elseif($mthname =="Jul")
		return 7;
	elseif($mthname =="Aug")
		return 8;
	elseif($mthname =="Sep")
		return 9;
	elseif($mthname =="Oct")
		return 10;
	elseif($mthname =="Nov")
		return 11;
	elseif($mthname =="Dec")
		return 12;
}

function getMAMADealTypeId($dealtype)
{

	$dbmamadealtype = new dbInvestments();
	$getmamadealtypeSql="select MADealTypeId from madealtypes where MADealType like '$dealtype'";
	if($rscity=mysql_query($getmamadealtypeSql))
	{
		//echo "<br>Inside dealtype functon";
		$city_cnt=mysql_num_rows($rscity);
		//echo "<Br>Deal type count-" .$city_cnt;
		if($city_cnt==1)
		{
			While($myrow=mysql_fetch_array($rscity, MYSQL_BOTH))
			{
				$MADealTypeId = $myrow[0];
				//echo "<br>Insert return DealType id--" .$MADealTypeId;
				return $MADealTypeId;
			}
		}
	}
	$dbmamadealtype.close();
}

function insert_city($cityname)
	{
		$dbcity = new dbInvestments();
		$getCitySql="select CityId from city where city like '$cityname'";
		//echo "<Br>--" .$getCitySql;
		if($rscity=mysql_query($getCitySql))
		{
			$city_cnt=mysql_num_rows($rscity);
			//echo "<br>City Count---" .$city_cnt;
			if($city_cnt==0)
			{
				//insert city
				$idcity=rand();
				$insCitySql="insert into city(CityId,City) values($idcity,'$cityname')";
				if($rsinsCity=mysql_query($insCitySql))
				{
					$cityId=$idcity;
					return $cityId;
				}
			}
			elseif($city_cnt>=1)
			{
				While($myrow=mysql_fetch_array($rscity, MYSQL_BOTH))
				{
					$cityId = $myrow[0];
				//	echo "<br>Insert return industry id--" .$cityId;
					return $cityId;
				}
			}
		//	echo "<br>Return CityId----" .$cityId;

		}

		$dbcity.close();
	}

	function insert_country($countryname)
			{
				$dbcountry = new dbInvestments();
				$getcountrySql="select countryid from country where country like '$countryname'";
				//echo "<br>-" .$getcountrySql;
				if($rscountry=mysql_query($getcountrySql))
				{
					$country_cnt=mysql_num_rows($rscountry);
					//echo "<br>Country Count---" .$country_cnt;
					if($country_cnt==0)
					{
						//insert country
						$idcountry=rand();
						$inscountrySql="insert into country(countryId,country) values($idcountry,'$countryname')";
						if($rsinscountry=mysql_query($inscountrySql))
						{
							$countryId=$idcountry;
							return $countryId;
						}
					}
					elseif($country_cnt>=1)
					{
						While($myrow=mysql_fetch_array($rscountry, MYSQL_BOTH))
						{
							$countryId = $myrow[0];
						//	echo "<br>Insert return industry id--" .$companyId;
							return $countryId;
						}
					}
				//	echo "<br>Return countryId----" .$countryId;

				}

				$dbcountry.close();
	}

	 function returnAcquirerId($acquirername,$cityid,$countryid)
	{
		//echo "<br>Inside funciton 1 ";
		$acquirername=trim($acquirername);
		//echo "<br>Acquirer- " .$acquirername;
		$dbaclinkss = new dbInvestments();
		$getAcquirerSql="select *  from acquirers where Acquirer like '$acquirername'";
		//echo "<bR>2 --" .$getAcquirerSql;
		if($rsgetAcquirer=mysql_query($getAcquirerSql))
		{
		//	echo "<br>3---";
			$acquirer_cnt=mysql_num_rows($rsgetAcquirer);
		//	echo "<br>Acquiere Coutn-- ".$acquirer_cnt;
			if($acquirer_cnt==0)
			{
				//insert acquirer
				$insAcquirerSql="insert into acquirers(Acquirer,CityId,countryid) values('$acquirername','$cityid','$countryid')";
				if($rsInsAcquirer = mysql_query($insAcquirerSql))
				{
					echo "<br>Insert Acquirer--" .$insAcquirerSql;
					$acquirerId=0;
				}
				return acquirerId;
			}
			elseif($acquirer_cnt>=1)
			{
			//	echo "<br>Inside function 2- ";
				While($myrow=mysql_fetch_array($rsgetAcquirer, MYSQL_BOTH))
				{
					$acquirerId = $myrow[0];
			//		echo "<br>--".$acquirerId;
					$updateAcqCityCountrySql="Update acquirers set CityId='$cityid',countryid='$countryid' where AcquirerId=$acquirerId";
					if($rsAcqcityCountrySql = mysql_query($updateAcqCityCountrySql))
					{
					//	echo "<br>Acquirer Update-- ".$updateAcqCityCountrySql;
					}
					return $acquirerId;
				}
			}
		}
		$dbaclinkss.close();
	}





// function to insert the industry and return the industry id if exists
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
			elseif($ind_cnt>=1)
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



// function to insert the companies and return the company id if exists
	function insert_company($companyname,$industryId,$sector,$web,$region,$CountryId,$CityId)
	{

		$dbpecomp = new dbInvestments();
		$getPECompanySql = "select PECompanyId from pecompanies where companyname like '$companyname'";
		//echo "<br>select--" .$getPECompanySql;
		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
		{
			$pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
			//echo "<bR>companycount--".$pecomp_cnt;
			if ($pecomp_cnt==0)
			{
					//insert pecompanies
					$insPECompanySql="insert into pecompanies(companyname,industry,sector_business,website,region,countryId,city)
					values('$companyname',$industryId,'$sector','$web','$region','$CountryId','$CityId')";

					if($rsInsPECompany = mysql_query($insPECompanySql))
					{
						echo "<br>Ins company sql=" .$insPECompanySql;
						$companyId=0;
						return $companyId;
					}
			}
			elseif($pecomp_cnt>=1)
			{
				While($myrow=mysql_fetch_array($rsgetPECompanyId, MYSQL_BOTH))
				{
					$companyId = $myrow[0];
					$updateCityCountrySql="Update pecompanies set city='$CityId',countryid='$CountryId' where PECompanyId=$companyId";
					if($rscityCountrySql=mysql_query($updateCityCountrySql))
					{
				//		echo "<br>Update Company- " .$updateCityCountrySql;
					}
				//	echo "<br>Insert return industry id--" .$companyId;
					return $companyId;
				}
			}
		}
		$dbpecomp.close();
	}



function insert_get_CIAs($cianame)
{
	$dblink = new dbInvestments();
	$cianame=trim($cianame);
	$getInvestorIdSql = "select CIAId from advisor_cias where cianame like '$cianame'";
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
				//echo "<br>Insert return investor id--" .$ciaInvestorId;
				return $ciaInvestorId;
			}
		}
	}
	$dblink.close();

}

// the following function inserts advisor_PEIds in the peinvestments_advisor table
	function insert_Investment_AdvisorCompany($dealId,$ciaid)
	{
		$DbAdvComp= new dbInvestments();
		$getDealInvSql="Select MAMAId,CIAId from mama_advisorcompanies where MAMAId=$dealId and CIAId=$ciaid";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into mama_advisorcompanies values($dealId,$ciaid)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
					return true;
				}
			}
		}
		$DbAdvComp.close();
}
// the following function inserts advisor_PEIds in the peinvestments_advisor table
	function insert_Investment_AdvisorAcquiror($dealId,$ciaid)
	{
		$DbAdvComp= new dbInvestments();
		$getDealInvSql="Select MAMAId,CIAId from mama_advisoracquirer where MAMAId=$dealId and CIAId=$ciaid";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into mama_advisoracquirer values($dealId,$ciaid)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
					return true;
				}
			}
		}
		$DbAdvComp.close();
}



		?>