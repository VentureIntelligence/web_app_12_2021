<?php include_once("../../globalconfig.php"); ?>
<?php
/*
created: Nov-5-2009
Invoked from: reipoadd.php in the admin
Stores RE Ipo deal. City and RegionId are part of the IPODeal thereby stored in the REipos table itself
but for recompanies, region id set to 1
Advisor stored in REinvestments_advisorcompanies, investors in REipos_investors table resp.
formName : reipoaddupdate
filename : reipoaddupdate.php
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
<form name="reipoaddupdate"  method="post" action="reipoaddupdate.php" >
<table align=center border="1" cellpadding="2" cellspacing="0" width="80%"  >
<?php
	require("../dbconnectvi.php");
     $Db = new dbInvestments();
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
     	session_start();

	 if (session_is_registered("SessLoggedAdminPwd"))
	 	{
                 			// and session_is_registered("SessLoggedIpAdd"))

						$portfoliocompany = $_POST['txtcompanyname'];
							//echo "<br>company. ".$portfoliocompany;
							$indid= $_POST['txtindustry'];  //industry id directly
							$sector=$_POST['txtsector'];
							$IPOSize=$_POST['txtsize'];
							$IPOPrice=$_POST['txtprice'];
							$IPOValuation=$_POST['txtvaluation'];

							$col6=$_POST['txtinvestors'];
							/*
								$col6 is investors
								read the investor column in loop and insert invidual investors into peinvestors table
								taking the InvestorId and insert in the table
							*/
							$investorString=str_replace('"','',$col6);
							$investorString=explode(",",$investorString);

							$adv=$_POST['txtadvisors'];
							$advisorString=str_replace('"','',$adv);
							$advisorString=explode(",",$advisorString);
							$monthtoAdd=$_POST['month1'];
							$yeartoAdd=$_POST['year1'];
							$IPODate=returnDate($monthtoAdd,$yeartoAdd);

							$citytoUpdate=$_POST['txtcity'];
							$regionIdtoUpdate=$_POST['txtregion'];

						        $website=$_POST['txtwebsite'];
							$comment=$_POST['txtcomment'];
							$comment=str_replace('"','',$comment);

                                                        $moreinfor=$_POST['txtmoreinfor'];
							$moreinfor=str_replace('"','',$moreinfor);

							$invdealsummary=$_POST['txtinvdealsummary'];
							$invdealsummary=str_replace('"','',$invdealsummary);

							$validation=$_POST['txtvalidation'];

							$estimatedirr=$_POST['txtestimatedirr'];
							$moreinforeturns=$_POST['txtmoreinforeturns'];

							$flagdeletion=0;
							if($_POST['chkhidesize'])
							{
								$hideamount=1;
							}
							else
							{$hideamount=0;
							}
							if($_POST['chkhidemoreinfor'])
							{
								$hidemoreinfor=1;
							}
							else
							{
								$hidemoreinfor=0;
							}
							$link=$_POST['txtlink'];

							$fullDateAfter=$IPODate;

                                                        if (trim($portfoliocompany) !="")
						        {
							$companyId=insert_company($portfoliocompany,$indid,$sector,$website,1);

							if($companyId==0)
							{
								$companyId=insert_company($portfoliocompany,$indid,$sector,$website,1);
								echo "<br>CompanyID After Insert=".$companyId;
							}
							echo "<br>CompanyID=".$companyId;

                                                        if ($companyId >0)
							{
								$pegetInvestmentsql = "select c.PECompanyId,ma.PECompanyId,IPODate from REcompanies as c,
								REipos as ma where ma.PECompanyId = c.PECompanyId and
								ma.IPODate = '$fullDateAfter' and c.PECompanyId = $companyId and ma.Deleted=0";

								//echo "<br>checking pe record***" .$pegetInvestmentsql;
								if ($rsInvestment = mysql_query($pegetInvestmentsql))
								{
									$investment_cnt = mysql_num_rows($rsInvestment);
								// echo "<br>Count**********-- " .$investment_cnt ;
								}
                                                                       if($investment_cnt==0)
									{
											$IPOId= rand();
											//echo "<br>random MandAId--" .$IPOId;
											$insertcompanysql="";
											$insertcompanysql= "INSERT INTO REipos (IPOId,PECompanyId,IPODate,IPOSize,IPOAmount,IPOValuation,Comment,MoreInfor,Validation,Deleted,hideamount,hidemoreinfor,city,RegionId,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns)
											VALUES ($IPOId,$companyId,'$fullDateAfter',$IPOSize,$IPOPrice,$IPOValuation,'$comment','$moreinfor', '$validation',$flagdeletion,$hideamount,$hidemoreinfor,'$citytoUpdate','$regionIdtoUpdate','$invdealsummary','$link','$estimatedirr','$moreinforeturns')";
											echo "<br>@@@@ :".$insertcompanysql;
											if ($rsinsert = mysql_query($insertcompanysql1))
											{
												//echo "<br>Insert PE-" .$insertcompanysql;
												 foreach ($investorString as $inv)
													{
														if(trim($inv)!="")
														{
															echo "<br>Inside function--" .$inv;

															$investorIdtoInsert=return_insert_get_Investor(trim($inv));
															if($investorIdtoInsert==0)
															{
																$investorIdtoInsert= return_insert_get_Investor(trim($inv));
															}
																$insDeal_investors= insert_Investment_Investors($IPOId,$investorIdtoInsert);
														}
													}
												foreach ($advisorString as $advisor)
													{
														if(trim($advisor)!="")
														{
															echo "<br>--" .$advisor;
															$advisorIdtoInsert=insert_get_CIAs(trim($advisor));
															if($advisorIdtoInsert==0)
															{
																$advisorIdtoInsert=insert_get_CIAs(trim($advisor));
															}

																$insadvcompany=insert_Investment_AdvisorCompany($IPOId,$advisorIdtoInsert);
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
									<tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; -->RE - IPO Deal already exists</td> </tr>
									<?php
								        }
							} //company id


			                               }//portfolio company null



	} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;


//End of peinvestments insert
?>
	</table>

	<tr> <td> &nbsp;</td></tr>
	<tr> <td> &nbsp;</td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a> </td> <td align=right><a href="reipoadd.php">Add RE IPO Deal </a></td></tr>
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


// function to insert the companies and return the company id if exists
	function insert_company($companyname,$industryId,$sector,$web,$regionId)
	{
		$dbpecomp = new dbInvestments();
		$getPECompanySql = "select PECompanyId from REcompanies where companyname= '$companyname'";
		echo "<br>select--" .$getPECompanySql;
		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
				{
					$pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
					if ($pecomp_cnt==0)
					{
							//insert pecompanies
							$insPECompanySql="insert into REcompanies(companyname,industryId,sector_business,website,RegionId)
							values('$companyname',$industryId,'$sector','$web',$regionId)";
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

// function to insert the advisor_cias table
function insert_get_CIAs($cianame)
{
	$dblink = new dbInvestments();
	$cianame=trim($cianame);
	$getInvestorIdSql = "select CIAId from REadvisor_cias where cianame= '$cianame%'";
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

// inserts and return the investor id
	function return_insert_get_Investor($investor)
	{
		$dblink= new dbInvestments();
		$investor=trim($investor);
		$getInvestorIdSql = "select InvestorId from REinvestors where Investor= '$investor'";
		echo "<br>select--" .$getInvestorIdSql;
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
					echo "<br>Return investor id--" .$InvestorId;
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
		$getDealInvSql="Select IPOId,InvestorId from REipo_investors where IPOId=$dealId and InvestorId=$investorId";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into REipo_investors values($dealId,$investorId)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
					return true;
				}
			}
		}
		$DbInvestInv.close();
}
?>