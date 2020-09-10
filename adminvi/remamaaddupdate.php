<?php include_once("../globalconfig.php"); ?>
<?php
/* created :Nov-16-09
formname:remamaaddupdate
filename: remamaaddupdate.php
invoked from: remamaaddupdate.php
Target country is default set to India IN RECOMPANIES TABLE
and the CITY AND REGIONID is STORED AS PART OF THE DEAL IN REMAMA TABLE
*/
?>
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
<form name="remamaaddupdate"  method="post" action="" >
<table align=center border="1" cellpadding="2" cellspacing="0" width="60%"  >


<?php

	require("../dbconnectvi.php");
     $Db = new dbInvestments();
 		session_save_path("/tmp");
     	session_start();

if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	 	{
	 				$portfoliocompany = $_POST['txtcompanyname'];
				//echo "<br>company. ".$portfoliocompany;
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
				echo "<Br>Advisor String- ".$TargetAdvisorString;
				$TargetAdvisorString=explode(",",$TargetAdvisorString);

				$targetcity=$_POST['txtTargetCity'];
				$regionId=$_POST['txtregion'];

				$targetCountryId=$_POST['txtTargetCountry'];
				//echo "<bR>Target country id-" .$targetCountryId;
				$website=$_POST['txtTargetwebsite'];

				$monthtoAdd=$_POST['month1'];
				$yeartoAdd=$_POST['year1'];
				$MandADate=returnDate($monthtoAdd,$yeartoAdd);

				$dealTypeId=$_POST['txtdealtype'];

				$Acquirorcity=$_POST['txtAcquirorCity'];

				$AcquirorCountryId=$_POST['txtAcquirorCountry'];

				$acquirer=$_POST['txtacquirer'];
				//echo "<br>++--".$acquirer;
				$acquirer=str_replace('"','',$acquirer);
				$AcquirerId=0;
				if(trim($acquirer)!="")
				{
					$AcquirerId=returnAcquirerId($acquirer,$Acquirorcity,$AcquirorCountryId);
					//echo "<br>Acquirer Id if not zero- ".$AcquirerId;
					if($AcquirerId==0)
					{
						$AcquirerId=returnAcquirerId($acquirer,$Acquirorcity,$AcquirorCountryId);
					//	echo "<br>Acquirer Id-".$AcquirerId ."-" .$acquirer;
					}
				}

				$col7=$_POST['txtAdvAcquiror'];
				$AcquirorString=str_replace('"','',$col7);
				echo "<bR>Acquiror String-" .$AcquirorString;
				$AcquirorString=explode(",",$AcquirorString);


				$comment=$_POST['txtcomment'];
				$comment=str_replace('"','',$comment);

				$moreinfor=$_POST['txtmoreinfor'];
				$moreinfor=str_replace('"','',$moreinfor);

				$validation=$_POST['txtvalidation'];
				$link=$_POST['txtlink'];

				if($_POST['chkAssetFlag'])
				{
					//echo"<br>***************";
					$assetFlag=1;
				}
				else
				{$assetFlag=0;
				}
				$flagdeletion=0;

				$valuation=$_POST['txtvaluation'];
				$finlink=$POST['txtfinlink'];
				
				$uploadname=$_POST['txtfilepath'];
				$sourcename=$_POST['txtsource'];

				$currentdir=getcwd();
				//echo "<br>Current Diretory=" .$currentdir;
				$curdir =  str_replace("adminvi","",$currentdir);
				//echo "<br>*****************".$curdir;
				$target = $curdir . "/uploadrefiles/" . basename($_FILES['txtfilepath']['name']);
				$file = "uploadrefiles/" . basename($_FILES['txtfilepath']['name']);
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
						$file = "uploadrefiles/" . basename($_FILES['txtfilepath']['name']);
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


				$fullDateAfter=$MandADate;

				//echo $portfoliocompany;
				if (trim($portfoliocompany) !="")
				{

					$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$targetCountryId);
					if($companyId==0)
					{
						$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$targetCountryId);
					}

					if ($companyId >0)
					{
						$pegetInvestmentsql = "select c.PECompanyId,ma.PECompanyId,DealDate from REcompanies as c,
						REmama as ma where ma.PECompanyId = c.PECompanyId and
						ma.DealDate = '$fullDateAfter' and c.PECompanyId = $companyId and ma.Deleted=0";

						//echo "<br>checking pe record***" .$pegetInvestmentsql;
						//echo "<br>Company id--" .$companyId;
						if ($rsInvestment = mysql_query($pegetInvestmentsql))
						{
							$investment_cnt = mysql_num_rows($rsInvestment);
						 //echo "<br>Count**********-- " .$investment_cnt ;
						}
						if($investment_cnt==0)
						{
								$MAMAId= rand();
								//echo "<br>random MandAId--" .$MAMAId;
								$insertcompanysql="";
								$createddate=date("Y-m-d")." ".date("H:i:s");
								$modifieddate=$createddate;

								$insertcompanysql= "INSERT INTO REmama (MAMAId,PECompanyId,Amount,Stake,DealDate,MADealTypeId,AcquirerId,Comment,MoreInfor,Validation,Asset,Deleted,city,RegionId,CreatedDate,ModifiedDate,Link,uploadfilename,source,Valuation,FinLink)
								VALUES ($MAMAId,$companyId,$amount,$stake,'$fullDateAfter',$dealTypeId,$AcquirerId,'$comment','$moreinfor', '$validation',$assetFlag,$flagdeletion,'$targetcity',$regionId,'$createddate','$modifieddate','$link','$filename','$sourcename','$valuation','$finlink')";
								echo "<br>@@@@ :".$insertcompanysql;
								if ($rsinsert = mysql_query($insertcompanysql))
								{
									echo "<br>Advisor String-" .$TargetAdvisorString;
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
								}
								else
								{
								?>
								<tr bgcolor="red"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; --> Insert failed</td> </tr>
								<?php
								}
						//	echo "<br> insert-".$insertcompanysql;
						}
						elseif($investment_cnt>= 1)
						{
						?>
						<tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; -->MA_MA Deal already exists</td> </tr>
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
	<tr><td align=left> <a href="admin.php">Admin Home</a> </td> <td align=right><a href="remamaadd.php">Add MA_MA Deal </a></td></tr>
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

function returnAcquirerId($acquirername,$cityid,$countryid)
{
	$acquirername=trim($acquirername);
	//echo "<br>Acquirer- " .$acquirername;
	$dbaclinkss = new dbInvestments();
	$getAcquirerSql="select * from REacquirers where Acquirer like '$acquirername'";
	if($rsgetAcquirer=mysql_query($getAcquirerSql))
	{
		$acquirer_cnt=mysql_num_rows($rsgetAcquirer);
		//echo "<br>-- ".$acquirer_cnt;
		if($acquirer_cnt==0)
		{
			//insert acquirer
			$insAcquirerSql="insert into REacquirers(Acquirer,CityId,countryid) values('$acquirername','$cityid','$countryid')";
			//echo "<br>Insert Acquirer--" .$insAcquirerSql;
			if($rsInsAcquirer = mysql_query($insAcquirerSql))
			{
				$acquirerId=0;
				return acquirerId;
			}
		}
		elseif($acquirer_cnt>=1)
		{
			While($myrow=mysql_fetch_array($rsgetAcquirer, MYSQL_BOTH))
			{
				$acquirerId = $myrow["AcquirerId"];
				$updateAcqCityCountrySql="Update REacquirers set CityId='$cityid',countryid='$countryid' where AcquirerId=$acquirerId";
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

/* function to insert the companies and return the company id if exists */
	function insert_company($companyname,$industryId,$sector,$web,$countryid)
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
					$insPECompanySql="insert into REcompanies(companyname,industry,sector_business,website,countryid)
					values('$companyname',$industryId,'$sector','$web','$countryid')";
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
					//$updateCityCountrySql="Update REcompanies set companyname='$companyname',countryid='$countryid' where PECompanyId=$companyId";
					//if($rscityCountrySql=mysql_query($updateCityCountrySql))
					//{
				//		echo "<br>Update Company- " .$updateCityCountrySql;
					//}
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
		$getDealInvSql="Select MAMAId,CIAId from REmama_advisorcompanies where MAMAId=$dealId and CIAId=$ciaid";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into REmama_advisorcompanies values($dealId,$ciaid)";
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
		$getDealInvSql="Select MAMAId,CIAId from REmama_advisoracquirer where MAMAId=$dealId and CIAId=$ciaid";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into REmama_advisoracquirer values($dealId,$ciaid)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
					return true;
				}
			}
		}
		$DbAdvComp.close();
}



?>