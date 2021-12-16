<?php include_once("../globalconfig.php"); ?>
<?php error_reporting(E_ALL); ?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN"
"http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<title>Venture Intelligence</title>
<SCRIPT LANGUAGE="JavaScript">

</SCRIPT>

<link href="../css/style_root.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="mamaaddupdate"  method="post" action="" >
<table align=center border="1" cellpadding="2" cellspacing="0" width="60%"  >


<?php

	require("../dbconnectvi.php");
     $Db = new dbInvestments();
 	session_save_path("/tmp");
     	session_start();

if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	 	{


					// echo '<pre>'; print_r($_POST); echo '</pre>';


					// exit;


			$user=$_SESSION['UserNames'];

	 				$portfoliocompany = $_POST['txtcompanyname'];
					 $companygroup = $_POST['txtcompanygroup'];

				//echo "<br>company. ".$portfoliocompany;

				$target_listingstatusvalue=$_POST['target_listingstatus'];
				$indid= $_POST['txtindustry'];  //industry id directly
				$sector=$_POST['txtsector'];

				$amount=$_POST['txtsize'];
				if($amount<=0)
				{	$amount=0;
				}
				$stake=$_POST['txtstake'];
				if($stake<=0)
				{	$stake=0;
				}

				$col6=$_POST['txtAdvTargetCompany'];
				$TargetAdvisorString=str_replace('"','',$col6);
				//echo "<Br>Advisor String- ".$TargetAdvisorString;
				$TargetAdvisorString=explode(",",$TargetAdvisorString);

				$targetcity=$_POST['txtTargetCity'];
			//	$targetcityId=insert_city($targetcity);

				$regionId=$_POST['txtregion'];

				$targetCountryId=$_POST['txtTargetCountry'];
				//echo "<bR>Target country id-" .$targetCountryId;
				$website=$_POST['txtTargetwebsite'];

				$monthtoAdd=$_POST['month1'];
				$yeartoAdd=$_POST['year1'];
				$MandADate=returnDate($monthtoAdd,$yeartoAdd);

				$dealTypeId=$_POST['txtdealtype'];

				$Acquirorcity=$_POST['txtAcquirorCity'];
				//$AcquirorcityId=insert_city($Acquirorcity);
				//echo "<br>~~".$AcquirorcityId;

				$AcquirorCountryId=$_POST['txtAcquirorCountry'];

				$acquirer=$_POST['txtacquirer'];
                                $AcquirerGroup = $_POST['txtacquirergroup'];
                                $AcquirerIndustryId = $_POST['txtacqindustry'];
				//echo "<br>++--".$acquirer;
				$acquirer=str_replace('"','',$acquirer);
				$AcquirerId=0;
				if(trim($acquirer)!="")
				{
                                    $AcquirerId=returnAcquirerId($acquirer,$Acquirorcity,$AcquirorCountryId,$AcquirerIndustryId,$AcquirerGroup);
                                   // echo "<br>Acquirer Id if not zero- ".$AcquirerId;
                                    /*if($AcquirerId==0)
                                    {
                                        $AcquirerId=returnAcquirerId($acquirer,$Acquirorcity,$AcquirorCountryId);
                                        //	echo "<br>Acquirer Id-".$AcquirerId ."-" .$acquirer;
                                    }*/
				}
                                
                               // exit();

                                $acquirer_listingstatusvalue = $_POST['acquirer_listingstatus'];

				$col7=$_POST['txtAdvAcquiror'];
				$AcquirorString=str_replace('"','',$col7);
				//echo "<bR>Acquiror String-" .$AcquirorString;
				$AcquirorString=explode(",",$AcquirorString);

                         	$comment=$_POST['txtcomment'];
				$comment=str_replace('"','',$comment);

				$moreinfor=$_POST['txtmoreinfor'];
				$moreinfor=str_replace('"','',$moreinfor);

				$validation=$_POST['txtvalidation'];
				$link=$_POST['txtlink'];
                                $company_valuation=0;
				$revenue_multiple=0;
				$ebitda_multiple=0;
                                $pat_mutliple=0;

				if($_POST['chkAssetFlag'])
				{
					//echo"<br>***************";
					$assetFlag=1;
				}
				else
				{$assetFlag=0;
				}
				if($_POST['chkhideamount'])
				{
					//echo"<br>***************";
					$hideamountFlag=1;
				}
				else
				{
					$hideamountFlag=0;
				}
				$flagdeletion=0;

				$fullDateAfter=$MandADate;
				$valuation=$_POST['txtvaluation'];
				

								$company_valuation=$_POST['txtcompanyvaluation'];
                                if($company_valuation=="")
                                  $company_valuation=0;

                                $revenue_multiple=$_POST['txtrevenuemultiple'];
                                if($revenue_multiple=="")
                                   $revenue_multiple=0;

                                $ebitda_multiple=$_POST['txtEBITDAmultiple'];
                                if($ebitda_multiple=="")
                                   $ebitda_multiple=0;

                                $pat_multiple=$_POST['txtpatmultiple'];
                                if($pat_multiple=="")
                                   $pat_mutliple=0;


								$company_valuation1=$_POST['txtcompanyvaluation1'];
                                if($company_valuation1=="")
                                  $company_valuation1=0;

                                $revenue_multiple1=$_POST['txtrevenuemultiple1'];
                                if($revenue_multiple1=="")
                                   $revenue_multiple1=0;

                                $ebitda_multiple1=$_POST['txtEBITDAmultiple1'];
                                if($ebitda_multiple1=="")
                                   $ebitda_multiple1=0;

                                $pat_multiple1=$_POST['txtpatmultiple1'];
                                if($pat_multiple1=="")
                                   $pat_multiple1=0;


								$company_valuation2=$_POST['txtcompanyvaluation2'];
                                if($company_valuation2=="")
                                  $company_valuation2=0;

                                $revenue_multiple2=$_POST['txtrevenuemultiple2'];
                                if($revenue_multiple2=="")
                                   $revenue_multiple2=0;

                                $ebitda_multiple2=$_POST['txtEBITDAmultiple2'];
                                if($ebitda_multiple2=="")
                                   $ebitda_multiple2=0;

                                $pat_multiple2=$_POST['txtpatmultiple2'];
                                if($pat_multiple2=="")
                                   $pat_multiple2=0;


								   $txtyear  = $_POST['txtyear'];


								   $txttot_debt=$_POST['txttot_debt'];
								   $txtcashequ=$_POST['txtcashequ'];


								   
                                // New feature 08-08-2016 start
							
                                $price_to_book=$_POST['txtpricetobook'];
                                if($price_to_book=="")
                                {
                                   $price_to_book=0;
                                }



                                $book_value_per_share=$_POST['txtbookvaluepershare'];
                                if($book_value_per_share=="")
                                {
                                   $book_value_per_share=0;
                                }


                                $price_per_share=$_POST['txtpricepershare'];
                                if($price_per_share=="")
                                {
                                   $price_per_share=0;
                                }
								   
							
                                // New feature 08-08-2016 end
                                
                                $revenue=$_POST['txtrevenue'];
                                if($revenue==""){
                                    $revenue=0;
                                }

                                $ebitda=$_POST['txtEBITDA'];
                                if($ebitda==""){
                                    $ebitda=0;
                                }

                                $pat=$_POST['txtpat'];
                                if($pat==""){
                                    $pat=0;
                                }

				$finlink=$POST['txtfinlink'];
				$uploadname=$_POST['txtfilepath'];
				$sourcename=$_POST['txtsource'];
				 if($_POST['chkhideAgg'])
                              	 { $hideAggregatetoUpdate=1;
                              	 }
                              	 else
                              	 { $hideAggregatetoUpdate=0;
                              	 }

				$currentdir=getcwd();
				//echo "<br>Current Diretory=" .$currentdir;
				$curdir =  str_replace("adminvi","",$currentdir);
				//echo "<br>*****************".$curdir;
				$target = $curdir . "/uploadmamafiles/" . basename($_FILES['txtfilepath']['name']);
				$file = "uploadmamafiles/" . basename($_FILES['txtfilepath']['name']);
				$filename= basename($_FILES['txtfilepath']['name']);
				//echo "<Br>Target Directory=" .$target;
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



				if (trim($portfoliocompany) !="")
				{

					$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$targetCountryId,$targetcity,$regionId,$region,$user);
					if($companyId==0)
					{
						$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$targetCountryId,$targetcity,$regionId,$region,$user);
					}

					if ($companyId >0)
					{
						$pegetInvestmentsql = "select c.PECompanyId,ma.PECompanyId,DealDate from pecompanies as c,
						mama as ma where ma.PECompanyId = c.PECompanyId and
						ma.DealDate = '$fullDateAfter' and c.PECompanyId = $companyId and Deleted=0 ";

					       //	echo "<br>checking pe record***" .$pegetInvestmentsql;
						//echo "<br>Company id--" .$companyId;
						if ($rsInvestment = mysql_query($pegetInvestmentsql))
						{
							$investment_cnt = mysql_num_rows($rsInvestment);
						 //echo "<br>Count**********-- " .$investment_cnt ;
						}
						// if($investment_cnt==0)
						// {
								$MAMAId= rand();
								//echo "<br>random MandAId--" .$MAMAId;
								$insertcompanysql="";
								$createddate=date("Y-m-d")." ".date("H:i:s");
								$modifieddate=$createddate;

								$insertcompanysql= "INSERT INTO mama (MAMAId,PECompanyId,Amount,Stake,DealDate,MADealTypeId,AcquirerId,Comment,MoreInfor,Validation,Asset,Deleted,CreatedDate,ModifiedDate,hideamount,Link,uploadfilename,source,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,
								Company_Valuation_Pre,Revenue_Multiple_Pre,EBITDA_Multiple_Pre,PAT_Multiple_Pre,
								Company_Valuation_Post,Revenue_Multiple_Post,EBITDA_Multiple_Post,PAT_Multiple_Post,
								target_listing_status,acquirer_listing_status,AggHide,Revenue,EBITDA,PAT,Total_Debt,Cash_Equ,price_to_book,book_value_per_share,price_per_share,company_group,financial_year)
								VALUES ('$MAMAId','$companyId','$amount','$stake','$fullDateAfter','$dealTypeId','$AcquirerId','$comment','$moreinfor','$validation','$assetFlag','$flagdeletion','$createddate','$modifieddate','$hideamountFlag','$link','$filename','$sourcename','$valuation','$finlink','$company_valuation','$revenue_multiple','$ebitda_multiple','$pat_multiple',
								'$company_valuation1','$revenue_multiple1','$ebitda_multiple1','$pat_multiple1',
								'$company_valuation2','$revenue_multiple2','$ebitda_multiple2','$pat_multiple2',
								'$target_listingstatusvalue','$acquirer_listingstatusvalue','$hideAggregatetoUpdate','$revenue','$ebitda','$pat','$txttot_debt','$txtcashequ','$price_to_book','$book_value_per_share','$price_per_share','$companygroup','$txtyear')";

								// echo "<br>@@@@ :".$insertcompanysql; exit;

								if ($rsinsert = mysql_query($insertcompanysql))
								{
									//echo "<br>Advisor String-" .$TargetAdvisorString;
									 foreach ($TargetAdvisorString as $targetadvisor)
									{
										if(trim($targetadvisor)!="")
										{
											echo "<br>)))--" .$targetadvisor;
											$TargetAdvisorIdtoInsert=insert_get_CIAs(trim($targetadvisor));
											if($TargetAdvisorIdtoInsert==0)
											{
												$TargetAdvisorIdtoInsert=insert_get_CIAs(trim($targetadvisor));
											}
                                                                                        $insadvcompany=insert_Investment_AdvisorCompany($MAMAId,$TargetAdvisorIdtoInsert);
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

										}
									}


									$datedisplay =  $fullDateAfter; //(date("Y F", $fullDateAfter));
								?>
								<Br>
								<tr bgcolor="#00CC66"> <td colspan=2width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $datedisplay . " - " .$portfoliocompany ; ?>&nbsp; --> Inserted</td> </tr>
								<?php
								//}
								
						//	echo "<br> insert-".$insertcompanysql;
						}
						else
								{
								?>
								<tr bgcolor="red"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; --> Insert failed</td> </tr>
								<?php
								}
				}//if companyid >0 loop ends
		} //if $portfoliocompany !=null loop ends

} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;


//End of peinvestments insert
?>


</table>

	<table align=center border="0" cellpadding="2" cellspacing="0" width="60%"  >
	<tr><td colspan=2>&nbsp;</td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a> </td> <td align=right><a href="mamaadd.php">Add MA_MA Deal </a></td></tr>
	</table>
	</body>
</html>

<?php
function returnDate($mth,$yr)
{
	//this function returns the date

	$fulldate= $yr ."-" .$mth ."-01";
	if (checkdate (01,$mth, $yr))
	{
		return $fulldate;
	}
}

function returnAcquirerId($acquirername,$cityid,$countryid,$industryid,$group)
{
	$acquirername=trim($acquirername);
	//echo "<br>Acquirer- " .$acquirername;
	$dbaclinkss = new dbInvestments();
        
	$getAcquirerSql="select * from acquirers where Acquirer like '$acquirername' and CityId like '$cityid' and countryid like '$countryid'";
        
	if($rsgetAcquirer=mysql_query($getAcquirerSql))
	{
            $acquirer_cnt=mysql_num_rows($rsgetAcquirer);
            //echo "<br>-- ".$acquirer_cnt;
            if($acquirer_cnt==0)
            {
                //insert acquirer
                $insAcquirerSql="insert into acquirers(Acquirer,CityId,countryid,IndustryId,Acqgroup) values('$acquirername','$cityid','$countryid','$industryid','$group')";
                //echo "<br>Insert Acquirer--" .$insAcquirerSql;
                if($rsInsAcquirer = mysql_query($insAcquirerSql))
                {
                    $acquirerId=0;
                    return mysql_insert_id();
                }
            }
            elseif($acquirer_cnt >= 1)
            {
                While($myrow=mysql_fetch_array($rsgetAcquirer, MYSQL_BOTH))
                {
                    $acquirerId = $myrow["AcquirerId"];
                   /* $updateAcqCityCountrySql="Update acquirers set CityId='$cityid',countryid='$countryid' where AcquirerId=$acquirerId";
                    if($rsAcqcityCountrySql = mysql_query($updateAcqCityCountrySql))
                    {
                    //	/echo "<br>Acquirer Update-- ".$updateAcqCityCountrySql;
                    }*/
                    return $acquirerId;
                }
            }
	}
	$dbaclinkss.close();
}

/* function to insert the companies and return the company id if exists */
	function insert_company($companyname,$industryId,$sector,$web,$countryid,$cityid,$regionId,$region,$user)
	{
		$dbpecomp = new dbInvestments();
		$getPECompanySql = "select PECompanyId from pecompanies where companyname= '$companyname'";
		//echo "<br>select--" .$getPECompanySql;
		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
		{
			$pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
			if ($pecomp_cnt==0)
			{
					//insert pecompanies
                        $insPECompanySql="insert into pecompanies(companyname,industry,sector_business,website,countryid,city,RegionId,region,created_by)
                            values('$companyname','$industryId','$sector','$web','$countryid','$cityid',$regionId,'$region','$user')";

					// echo "<br>Ins company sql=" .$insPECompanySql;

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
                            $updateCityCountrySql="Update pecompanies set industry='$industryId',sector_business='$sector',website='$web',city='$cityid',countryid='$countryid',RegionId=$regionId,region='$region' where PECompanyId=$companyId";
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


function insert_city($cityname)
{
	$dbcity = new dbInvestments();
	$getCitySql="select CityId from city where city like '$cityname'";
	if($rscity=mysql_query($getCitySql))
	{
		$city_cnt=mysql_num_rows($rscity);
		//echo "<br>Count---" .$city_cnt;
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
			//	echo "<br>Insert return industry id--" .$companyId;
				return $cityId;
			}
		}
	//	echo "<br>Return CityId----" .$cityId;

	}

	$dbcity.close();
}

?>