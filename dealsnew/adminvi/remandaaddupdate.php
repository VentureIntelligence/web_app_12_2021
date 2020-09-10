<?php include_once("../../globalconfig.php"); ?>
<?php
/*
Created : Nov-13-09
invoked from : remandaadd.php (on submit of the page)
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

<link href="../style.css" rel="stylesheet" type="text/css">
</head>
<body>
<form name="mandaaddupdate"  method="post" action="remandaaddupdate.php" >
<table align=center border="1" cellpadding="2" cellspacing="0" width="60%"  >
<?php
	require("../dbconnectvi.php");
     $Db = new dbInvestments();
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
     	session_start();
	 if(session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	 	{
			$portfoliocompany = $_POST['txtcompanyname'];
			//	echo "<br>company. ".$portfoliocompany;
				$indid= $_POST['txtindustry'];
				$sector=$_POST['txtsector'];
				$city=$_POST['txtcity'];
				$regionId=$_POST['txtregion'];
				$website=$POST['txtwebsite'];
				$MandASize=$_POST['txtsize'];
				if($MandASize=="")
				  $MandASize=0;
				$StageId=$_POST['txtstage'];
				$acquirer=$_POST['txtacquirer'];
				$dealtypeId=$_POST['txtdealtype'];
				$acquirer=$_POST['txtacquirer'];
				$acquirer=str_replace('"','',$acquirer);
				$AcquirerId=0;
				if(trim($acquirer)!="")
				{
                                        $AcquirerId=returnAcquirerId(trim($acquirer));
					if($AcquirerId==0)
					{
						$AcquirerId=returnAcquirerId(trim($acquirer));
						//echo "<br>Acquirer Id-".$AcquirerId ."-" .$acquirer;
					}
				}

				$col6=$_POST['txtinvestors'];
				/*
					$col6 is investors
					read the investor column in loop and insert invidual investors into reinvestors table
					taking the InvestorId and insert in the table
				*/
				$investorString=str_replace('"','',$col6);
				$investorString=explode(",",$investorString);

				$advisorCompany=$_POST['txtadvisorCompany'];
				$advisorCompanyString=str_replace('"','',$advisorCompany);
				$advisorCompanyString=explode(",",$advisorCompanyString);

				$advisorAcquirer=$_POST['txtadvisorAcquirer'];
				$advisorAcquirerString=str_replace('"','',$advisorAcquirer);
				$advisorAcquirerString=explode(",",$advisorAcquirerString);


				$monthtoAdd=$_POST['month1'];
				$yeartoAdd=$_POST['year1'];
				$MandADate=returnDate($monthtoAdd,$yeartoAdd);

				$comment=$_POST['txtcomment'];
				$comment=str_replace('"','',$comment);

				$moreinfor=$_POST['txtmoreinfor'];
				$moreinfor=str_replace('"','',$moreinfor);

				$validation=$_POST['txtvalidation'];
				$invdealsummary=$_POST['txtinvdealsummary'];
				$invdealsummary=str_replace('"','',$invdealsummary);

				$flagdeletion=0;
				if($_POST['chkhidesize'])
				{
				//	echo"<br>***************";
					$hideamount=1;
				}
				else
				{
					$hideamount=0;
				}
				//echo "<br>----------------" .$hideamount;
				if($_POST['chkhidemoreinfor'])
				{
					$hidemoreinfor=1;
				}
				else
				{
					$hidemoreinfor=0;
				}
				if($_POST['SPV'])
                                    $SPVtoAdd=1;
				else
				    $SPVtoAdd=0;

				$projectname=$_POST['txtprojectname'];
				if($projectname=="" )
				   $projectname="";
                                $link=$_POST['txtlink'];

				$estimatedirr=$_POST['txtestimatedirr'];
				$moreinforeturns=$_POST['txtmoreinforeturns'];

				$fullDateAfter=$MandADate;
				//$portfoliocompany="";
				if (trim($portfoliocompany) !="")
				{

					//echo "<br>Industryid-".$indid;
					$companyId=insert_company($portfoliocompany,$indid,$sector,$website);
					if($companyId==0)
					{
						$companyId=insert_company($portfoliocompany,$indid,$sector,$website);
					}


					if ($companyId >0)
					{
						$pegetInvestmentsql = "select c.PECompanyId,ma.PECompanyId,DealDate from REcompanies as c,
						REmanda as ma where ma.PECompanyId = c.PECompanyId and
						ma.DealDate = '$fullDateAfter' and c.PECompanyId = $companyId ";

						//echo "<br>checking pe record***" .$pegetInvestmentsql;
						//echo "<br>Company id--" .$companyId;
						if ($rsInvestment = mysql_query($pegetInvestmentsql))
						{
							$investment_cnt = mysql_num_rows($rsInvestment);
						 //echo "<br>Count**********-- " .$investment_cnt ;
						}
						if($investment_cnt==0)
						{
								$MandAId= rand();
								//echo "<br>random MandAId--" .$MandAId;
								$insertcompanysql="";
								$insertcompanysql= "INSERT INTO REmanda (MandAId,PECompanyId,AcquirerId,DealTypeId,DealDate,DealAmount,Comment,MoreInfor,Validation,Deleted,hidemoreinfor,hideamount,city,RegionId,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,StageId,SPV,ProjectName)
								VALUES ($MandAId,$companyId,$AcquirerId,$dealtypeId,'$fullDateAfter',$MandASize,'$comment','$moreinfor', '$validation',$flagdeletion,$hidemoreinfor,$hideamount,'$city',$regionId,'$invdealsummary','$link','$estimatedirr','$moreinforeturns',$StageId,$SPVtoAdd,'$projectname')";
								echo "<br>@@@@ :".$insertcompanysql;
								if ($rsinsert = mysql_query($insertcompanysql))
								{
									//echo "<br>Insert PE-" .$insertcompanysql;
									 foreach ($investorString as $inv)
										{
											if(trim($inv)!="")
											{
												$investorIdtoInsert=return_insert_get_Investor(trim($inv));
												if($investorIdtoInsert==0)
													$investorIdtoInsert= return_insert_get_Investor(trim($inv));

												$insDeal_investors= insert_Investment_Investors($MandAId,$investorIdtoInsert);
											}
										}

									 /*foreach($advisorCompanyString as $advCompany)
									 {
										if($trim($advCompany)!="")
										{
											$advCompanyIdtoInsert=insert_get_CIAs($advCompany);
											if($advCompanyIdtoInsert==0)
												$advCompanyIdtoInsert=insert_get_CIAs($advCompany);

											$insAdvCompanySql="insert into REinvestments_advisorcompanies values($MandAId,$advCompanyIdtoInsert)";
											if($rsInsertAdvCompany = mysql_query($insAdvCompanySql))
											{
											}
										}
									}

									 foreach($advisorAcquirerString as $advAcquirer)
									{
										if($trim($advAcquirer)!="")
										{
											$advAcquirerIdtoInsert=insert_get_CIAs($advAcquirer);
											if($advAcquirerIdtoInsert==0)
												$advAcquirerIdtoInsert=insert_get_CIAs($advAcquirer);

											$insAdvAcquirerSql="insert into REinvestments_advisoracquirer values($MandAId,$advAcquirerIdtoInsert)";
											if($rsInsertAcqCompany = mysql_query($insAdvAcquirerSql))
											{
											}
										}
									}  */
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
						<tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; -->RE - M&A Deal already exists</td> </tr>
						<?php
						}
				}//if companyid >0 loop ends
	} //if $portfoliocompany !=null loop ends


		} // if resgistered loop ends
	else
	{

	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
	}

//End of reinvestments insert
?>
	</table>

	<table align=center border="0" cellpadding="2" cellspacing="0" width="60%"  >
	<tr><td colspan=2>&nbsp;</td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a> </td> <td align=right><a href="mandaadd.php">Add M&A Deal </a></td></tr>
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

//function to insert the companies and return the company id if exists
	function insert_company($companyname,$industryId,$sector,$web)
	{
		$dbpecomp = new dbInvestments();
		$getPECompanySql = "select PECompanyId from REcompanies where companyname like '$companyname%'";
		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
		{
			$pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
			if ($pecomp_cnt==0)
			{
					//insert pecompanies
					$insPECompanySql="insert into REcompanies(companyname,industry,sector_business,website)
					values('$companyname',$industryId,'$sector','$web')";

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
				//	echo "<br>Insert return industry id--" .$companyId;
					return $companyId;
				}
			}
		}
		$dbpecomp.close();
	}

function returnAcquirerId($acquirername)
{
	$acquirername=trim($acquirername);
	//echo "<br>Acquirer- " .$acquirername;
	$dbaclinkss = new dbInvestments();
	$getAcquirerSql="select AcquirerId from REacquirers where Acquirer like '$acquirername%'";
	if($rsgetAcquirer=mysql_query($getAcquirerSql))
	{
		$acquirer_cnt=mysql_num_rows($rsgetAcquirer);
		//echo "<br>-- ".$acquirer_cnt;
		if($acquirer_cnt==0)
		{
			//insert acquirer
			$insAcquirerSql="insert into REacquirers(Acquirer) values('$acquirername')";

			if($rsInsAcquirer = mysql_query($insAcquirerSql))
			{
                                echo "<br>Insert Acquirer--" .$insAcquirerSql;
				$acquirerId=0;
				return $acquirerId;
			}
		}
		elseif($acquirer_cnt>=1)
		{
			While($myrow=mysql_fetch_array($rsgetAcquirer, MYSQL_BOTH))
			{
				$acquirerId = $myrow["AcquirerId"];
				echo "<br>!! return acquirer id--" .$acquirerId;
				return $acquirerId;
			}
		}
	}
	$dbaclinkss.close();
}

// inserts and return the investor id
	function return_insert_get_Investor($investor)
	{
		$dblink= new dbInvestments();
		$investor=trim($investor);
		$getInvestorIdSql = "select InvestorId from REinvestors where Investor like  '$investor%'";
	       // echo "<br>select--" .$getInvestorIdSql;
		if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
		{
			$investor_cnt=mysql_num_rows($rsgetInvestorId);
		//	echo "<br>Investor count-- " .$investor_cnt;
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
					echo "<br> return investor id--" .$InvestorId;
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
		$getDealInvSql="Select MandAId,InvestorId from REmanda_investors where MandAId=$dealId and InvestorId=$investorId";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into REmanda_investors values($dealId,$investorId)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
					return true;
				}
			}
		}
		$DbInvestInv.close();
}


//function to insert the advisor_cias table
function insert_get_CIAs($cianame)
{
	$cianame=trim($cianame);
	$dbcialink = new dbInvestments();
	$getInvestorIdSql = "select CIAId from REadvisor_cias where cianame like '$cianame%'";
	//echo "<br>select--" .$getInvestorIdSql;
	if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
	{
		$investor_cnt=mysql_num_rows($rsgetInvestorId);
	//	echo "<br>Advisor cia table count-- " .$investor_cnt;
		if ($investor_cnt==0)
		{
				//insert acquirer
				$insAcquirerSql="insert into REadvisor_cias(cianame) values('$cianame')";
				if($rsInsAcquirer = mysql_query($insAcquirerSql))
				{
					$AdInvestorId=0;
					return $InvestorId;
				}
		}
		elseif($investor_cnt>=1)
		{
			While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
			{
				$AdInvestorId = $myrow[0];
			//	echo "<br>Insert return investor id--" .$invId;
				return $AdInvestorId;
			}
		}
	}
	$dbcialink.close();
}

?>