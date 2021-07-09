<?php include_once("../globalconfig.php"); ?>
<?php

//echo "<br>_______________________";
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
<form name="ipoaddupdate"  method="post" action="" >
<table align=center border="1" cellpadding="2" cellspacing="0" width="80%"  >
<?php
	require("../dbconnectvi.php");
     $Db = new dbInvestments();
 	session_save_path("/tmp");
     	session_start();
	 if (session_is_registered("SessLoggedAdminPwd"))
	 	{
			$user=$_SESSION['UserNames'];

			// and session_is_registered("SessLoggedIpAdd"))

			$portfoliocompany = $_POST['txtcompanyname'];
				//echo "<br>company. ".$portfoliocompany;
				$indid= $_POST['txtindustry'];  //industry id directly
				$sector=$_POST['txtsector'];
				$IPOSize=$_POST['txtsize'];
				$IPOPrice=$_POST['txtprice'];
				$IPOValuation=$_POST['txtvaluation'];
				$stakesold=$_POST['txtstakesold'];

				//$col6=$_POST['txtinvestors'];
				/*
					$col6 is investors
					read the investor column in loop and insert invidual investors into peinvestors table
					taking the InvestorId and insert in the table
				*/
				//$investorString=str_replace('"','',$col6);
				//$investorString=explode(",",$investorString);
                                //$investorStringArrayCount=count($investorString);

        			//$multiplereturn=$_POST['txtmultiplereturn'];
				//$multiplereturnString=str_replace('"','',$multiplereturn);
                                //$multiplereturnString = explode(",", $multiplereturnString);

                                $investortype=$_POST['invType'];
                                if($_POST['chkinvestorsale'])   //if its checked ,investorsale db value is set to 1
                                {  $investorsale=1;}
                                else
                                {  $investorsale=0;}
                                $exitstatusvalue=$_POST['exitstatus'];
                                if($exitstatusvalue="--")
                                {   $exitstatusvalue=0;}

                                $adv=$_POST['txtadvisors'];
				$advisorString=str_replace('"','',$adv);
				$advisorString=explode(",",$advisorString);
				$monthtoAdd=$_POST['month1'];
				$yeartoAdd=$_POST['year1'];
				$IPODate=returnDate($monthtoAdd,$yeartoAdd);
				$website=$_POST['txtwebsite'];

				$comment=$_POST['txtcomment'];
				$comment=str_replace('"','',$comment);

				$moreinfor=$_POST['txtmoreinfor'];
				$moreinfor=str_replace('"','',$moreinfor);

				$invdealsummary=$_POST['txtinvdealsummary'];
				$invdealsummary=str_replace('"','',$invdealsummary);

				$validation=$_POST['txtvalidation'];
				$link=$_POST['txtlink'];
                                $valuation=$_POST['txtvaluationmoreinfo'] ;
                                $finlink=$POST['txtfinlink'];
                                $company_valuation=$_POST['txtcompanyvaluation'];
                                $sales_multiple =$_POST['txtsalesmultiple'];
                                $EBITDA_multiple=$_POST['txtEBITDAmultiple'];
                                $netprofit_multiple=$_POST['txtnetprofitmultiple'];
								
								$price_to_book=$_POST['txtpricetobook'];
								$book_value_per_share=$_POST['txtbookvaluepershare'];
								$price_per_share=$_POST['txtpricepershare'];
								
                                $selling_investors=$_POST['txtsellinginvestors'];
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
                                $valuation_working=$_POST['txtvaluationworkingpath'];

				$flagdeletion=0;
				if($_POST['chkhidesize'])
				{
					//echo"<br>***************";
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
				if($_POST['chkvcflag'])
				{
					$Vcflag=1;
				}
				else
				{
					$Vcflag=0;
				}
				$fullDateAfter=$IPODate;
				//$portfoliocompany="";
			
				$currentdir=getcwd();
							//echo "<br>Current Diretory=" .$currentdir;
							$curdir =  str_replace("adminvi","",$currentdir);
							//echo "<br>*****************".$curdir;
							$target = $curdir . "/uploadmamafiles/valuation_workings/" . basename($_FILES['txtvaluationworkingpath']['name']);
							$file = "uploadmamafiles/valuation_workings/" . basename($_FILES['txtvaluationworkingpath']['name']);
							$filename= basename($_FILES['txtvaluationworkingpath']['name']);
							//echo "<Br>Target Directory=" .$target;
							//echo "<bR>---" .$filename;
				if($filename!="")
				{
				   if (!(file_exists($file)))
				   {
                       		      if( move_uploaded_file($_FILES['txtvaluationworkingpath']['tmp_name'], $target))
				      {
                                                //echo "<Br>The file ". basename( $_FILES['txtfilepath']['name']). " has been uploaded";
				                echo "<br>File is getting uploaded . Please wait..";
			                        $file = "uploadmamafiles/valuation_workings" . basename($_FILES['txtvaluationworkingpath']['name']);
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
					$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$region,$user);
					echo "<br>CompanyID=".$companyId;
					if($companyId==0)
					{
						$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$region,$user);
						echo "<br>CompanyID After Insert=".$companyId;
					}
					if ($companyId >0)
					{
						$pegetInvestmentsql = "select c.PECompanyId,ma.PECompanyId,IPODate from pecompanies as c,
						ipos as ma where ma.PECompanyId = c.PECompanyId and
						ma.IPODate = '$fullDateAfter' and c.PECompanyId = $companyId ";

						//echo "<br>checking pe record***" .$pegetInvestmentsql;
						if ($rsInvestment = mysql_query($pegetInvestmentsql))
						{
							$investment_cnt = mysql_num_rows($rsInvestment);
						 //echo "<br>Count**********-- " .$investment_cnt ;
						}
						if($investment_cnt==0)
						{
								 if($_POST['hideIPOId']!='' && $_POST['hideIPOId']>0 ){
                                                                 $IPOId   = $_POST['hideIPOId'];
                                                                }else{
                                                                $IPOId= rand();
                                                                }
                                                                
								//echo "<br>random MandAId--" .$IPOId;
								$insertcompanysql="";
								$insertcompanysql= "INSERT INTO ipos (IPOId,PECompanyId,IPODate,IPOSize,IPOAmount,IPOValuation,Comment,MoreInfor,Validation,Deleted,InvestorType,hideamount,hidemoreinfor,VCFlag,InvestmentDeals,Link,Valuation,FinLink,Company_Valuation,Sales_Multiple,EBITDA_Multiple,Netprofit_Multiple,InvestorSale,SellingInvestors,ExitStatus,Valuation_Working_fname,Revenue,EBITDA,PAT,price_to_book,book_value_per_share,price_per_share,stakeSold)
								VALUES ($IPOId,$companyId,'$fullDateAfter','$IPOSize','$IPOPrice','$IPOValuation','$comment','$moreinfor', '$validation','$flagdeletion','$investortype','$hideamount','$hidemoreinfor','$Vcflag','$invdealsummary','$link','$valuation','$finlink','$company_valuation','$sales_multiple','$EBITDA_multiple','$netprofit_multiple','$investorsale','$selling_investors','$exitstatusvalue','$filename','$revenue','$ebitda','$pat','$price_to_book','$book_value_per_share','$price_per_share','$stakesold')";
								echo "<br>@@@@ :".$insertcompanysql;
								if ($rsinsert = mysql_query($insertcompanysql))
								{
									//echo "<br>Insert PE-" .$insertcompanysql;
									//echo "<Br>Investor array ".$investorStringArrayCount;
									/*for ($j=0;$j<$investorStringArrayCount;$j++)
			                                                {
                                                                             // echo "<br>&&&&&".$j;
                                                                              $inv=$investorString[$j];
                                                                              $multiplereturnValue=$multiplereturnString[$j];
                                                                             // echo "<br>-----" .$inv;
                                                                             // echo "<Br>****" .$multiplereturnValue;
											if(trim($inv)!="")
											{
												$investorIdtoInsert=return_insert_get_Investor(trim($inv));
												if($investorIdtoInsert==0)
												{
													$investorIdtoInsert= return_insert_get_Investor(trim($inv));
												}
													$insDeal_investors= insert_Investment_Investors($IPOId,$investorIdtoInsert,$multiplereturnValue);
											}

                                                                       } */
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
						<tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; -->IPO Deal already exists</td> </tr>
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

	<tr> <td>&nbsp; </td></tr>
	<tr> <td>&nbsp; </td></tr>
	<tr><td align=left> <a href="admin.php">Admin Home</a> </td> <td align=right><a href="ipoadd.php">Add IPO Deal </a></td></tr>
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


/* function to insert the companies and return the company id if exists */
	function insert_company($companyname,$industryId,$sector,$web,$city,$region,$user)
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
					$insPECompanySql="insert into pecompanies(companyname,industry,sector_business,website,city,region,created_by)
					values('$companyname','$industryId','$sector','$web','$city','$region','$user')";
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

/* function to insert the advisor_cias table */
function insert_get_CIAs($cianame)
{
	$dblink = new dbInvestments();
	$cianame=trim($cianame);
	$getInvestorIdSql = "select CIAId from advisor_cias where cianame= '$cianame%'";
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
/*	function return_insert_get_Investor($investor)
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
	function insert_Investment_Investors($dealId,$investorId,$returnValue)
	{
		$DbInvestInv = new dbInvestments();
		//$dbslink = mysqli_connect("ventureintelligence.ipowermysql.com", "root",  "", "peinvestmentdeals");
		$getDealInvSql="Select IPOId,InvestorId from ipo_investors where IPOId=$dealId and InvestorId=$investorId";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into ipo_investors(IPOId,InvestorId,MultipleReturn,InvMoreInfo) values($dealId,$investorId,$returnValue)";
				//echo "<br>*************".$insDealInvSql;
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
					return true;
				}
			}
		}
		$DbInvestInv.close();
}
*/
?>