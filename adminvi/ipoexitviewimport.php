<?php include_once("../globalconfig.php"); ?>
<?php
	require("../dbconnectvi.php");
     $Db = new dbInvestments();
 session_save_path("/tmp");
     	session_start();
	 	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	 	{

			//$file ="importfiles/peinvestmentsexport.txt";

			$currentdir=getcwd();
			$target = $currentdir . "/importfiles/" . basename($_FILES['txtipoexitfilepath']['name']);
			$file = "importfiles/" . basename($_FILES['txtipoexitfilepath']['name']);
			if (!(file_exists($file)))
			{

				if(move_uploaded_file($_FILES['txtipoexitfilepath']['tmp_name'], $target))
				{
					//echo "<Br>The file ". basename( $_FILES['txtipoexitfilepath']['name']). " has been uploaded";
					echo "<br>File is getting uploaded . Please wait..";
					$file = "importfiles/" . basename($_FILES['txtipoexitfilepath']['name']);
					//echo "<br>----------------" .$file;
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
<title>Import M&A data : : Contact TSJ Media : :</title>
<SCRIPT LANGUAGE="JavaScript">
</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<form name="ipoexitviewimport">
<table border=1 cellpadding=3  cellspacing=0 bordercolor=blue  align=center width="50%">
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
							//echo "<br>full string- " .$i;
							$fstring = explode("+", $i);
							$portfoliocompany = trim($fstring[0]);
							//echo "<br>company. ".$portfoliocompany;
							$col6=$fstring[1];
							/*
								$col6 is investors
								read the investor column in loop and insert invidual investors into peinvestors table
								taking the InvestorId and insert in the manda_investors table
							*/
							$investorString=str_replace('"','',$col6);
							//	echo "<Br>investor string--" .$investorString;

							$industryname = trim($fstring[2]);
							$sector=trim($fstring[3]);
							$IPODate=$fstring[4];
							$IPOSize=$fstring[5];
							if(trim($IPOSize)<=0)
							{
								$IPOSize=0;
							}
							$IPOAmount=$fstring[6];
							if(trim($IPOAmount)<=0)
							{
								$IPOAmount=0;
							}
							$IPOValuation=$fstring[7];
							if(trim($IPOValuation)<=0)
							{
								$IPOValuation=0;
							}

							$Advisor_company=trim($fstring[8]);
							$advisor_companyString=str_replace('"','',$Advisor_company);
							$advisor_companyString =explode(",",$Advisor_company);

							$website=$fstring[9];
							$city="";
							$region="";

							$comment=trim($fstring[10]);
							$comment=str_replace('"','',$comment);
							$moreinfor=trim($fstring[11]);
							$moreinfor=str_replace('"','',$moreinfor);

							$validation=trim($fstring[12]);	//valiation text
							$flagdeletion=$fstring[13]; //if =1, hide from the view
							$hidemoreinfor=$fstring[15]; // hide more information from the view
							$hideamount=$fstring[14]; //hide amount from the view
							$vcflag=$fstring[16]; //vc flag


							$fullDateAfter=$IPODate;
							//echo "<br>**" .$fulldate ."--".$fullDateAfter;

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
								$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$region);
								if($companyId==0)
								{
									$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$region);
								}
								//$companyId=0;
								if ($companyId >0)
								{
									$pegetInvestmentsql = "select c.PECompanyId,ma.PECompanyId,DealDate from pecompanies as c,
									ipos as ma where ma.PECompanyId = c.PECompanyId and
									ma.DealDate ='$fullDateAfter' and c.PECompanyId = $companyId";

									//echo "<br>checking pe record***" .$pegetInvestmentsql;
									//echo "<br>Company id--" .$companyId;
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
											$insertcompanysql= "INSERT INTO ipos (IPOId,PECompanyId,IPODate,IPOSize,IPOAmount,IPOValuation,Comment,MoreInfor,Validation,Deleted,hideamount,hidemoreinfor,VCFlag)
											VALUES ($IPOId,$companyId,'$fullDateAfter',$IPOSize,$IPOAmount,$IPOValuation,'$comment','$moreinfor','$validation',$flagdeletion,$hideamount,$hidemoreinfor,$vcflag)";
											//echo "<br>Insert M&A  :".$insertcompanysql;
											if ($rsinsert = mysql_query($insertcompanysql))
											{
												$investorString=explode(",",$investorString);
												foreach ($investorString as $inv)
												{
													//echo "<br>Array-- " .$inv;
													if(trim($inv)!="")
													{
														$investorIdtoInsert=return_insert_get_Investor(trim($inv));
														//echo "<br>InvestorID-" .$investorIdtoInsert;
														if($investorIdtoInsert==0)
														{
															$investorIdtoInsert= return_insert_get_Investor(trim($inv));
														//	echo "<br>**InvestorId- ".$investorIdtoInsert;
														}
														$insDeal_investors= insert_IPO_Investors($IPOId,$investorIdtoInsert);
													}
													//echo "<br> InvestorId--" .$investorIdtoInsert;
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
																	$insDeal_Advisorcompany= insert_Investment_AdvisorCompany($IPOId,$CIAIdtoInsert);
															}
														}


												$importTotal=$importTotal+1;
												$datedisplay =  $fullDateAfter; //(date("Y F", $fullDateAfter));
											?>
											<Br>
											<tr bgcolor="#00CC66"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $datedisplay . " - " .$portfoliocompany ; ?>&nbsp; --> Imported</td> </tr>
											<?php
											}
											else
											{
											?>
											<tr bgcolor="red"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; --> Import failed</td> </tr>
											<?php
											}
									//	echo "<br> insert-".$insertcompanysql;
									}
									elseif($investment_cnt>= 1)
									{
									?>
									<tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; -->M&A Deal already exists</td> </tr>
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
			<tr> <Td><b> File dont exists to read </b> </td></tR>
			</table>

			<?
			}



} // if resgistered loop ends
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

/* function to insert the companies and return the company id if exists */
	function insert_company($companyname,$industryId,$sector,$web,$city,$region)
	{
		$dbpecomp = new dbInvestments();
		$getPECompanySql = "select PECompanyId from pecompanies where companyname='$companyname'";
		//echo "<br>select--" .$getPECompanySql;
		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
		{
			$pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
			if ($pecomp_cnt==0)
			{
					//insert pecompanies
					$insPECompanySql="insert into pecompanies(companyname,industry,sector_business,website,city,region)
					values('$companyname',$industryId,'$sector','$web','$city','$region')";
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

/* function to insert the industry and return the industry id if exists */
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
		elseif($investor_cnt==1)
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


// the following function inserts advisor_IPOIds in the peinvestments_companies table
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
		$getInvestorIdSql = "select InvestorId from peinvestors where Investor='$investor'";
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


	function insert_IPO_Investors($dealId,$investorId)
	{
		$dbslink = new dbInvestments();
		$getDealInvSql="Select IPOId,InvestorId from ipo_investors where IPOId=$dealId and InvestorId=$investorId";
	//	echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into ipo_investors values($dealId,$investorId)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
					return true;
				}
			}
		}
		$dbslink.close();
	}
?>