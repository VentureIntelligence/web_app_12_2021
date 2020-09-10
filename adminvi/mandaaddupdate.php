<?php include_once("../globalconfig.php"); ?>
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
<form name="mandaaddupdate"  method="post" action="" >
<table align=center border="1" cellpadding="2" cellspacing="0" width="60%"  >
<?php
	require("../dbconnectvi.php");
     $Db = new dbInvestments();
 		session_save_path("/tmp");
     	session_start();

	 //if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	 //	{
			$portfoliocompany = $_POST['txtcompanyname'];
			//echo "<Br>--1";
			//	echo "<br>company. ".$portfoliocompany;
				$indid= $_POST['txtindustry'];  //industry id directly
				$sector=$_POST['txtsector'];
				$website=$_POST['txtwebsite'];
				$MandASize=$_POST['txtsize']; 
				$stakesold=$_POST['txtstakesold'];

                                $hideIPO_MandAId=$_POST['hideIPOId'];
                $mainsector=$_POST['txtmainsector'];
				$subsector=$_POST['txtsubsector'];
				$acquirer=$_POST['txtacquirer'];
				$exitstatusvalue=$_POST['exitstatus'];

                                if($exitstatusvalue=="--")
                                {   $exitstatusvalue=0;}

				$dealtypeId=$_POST['txtdealtype'];
                                $acquirer=$_POST['txtacquirer'];
				$acquirer=str_replace('"','',$acquirer);
				$AcquirerId=0;
				if(trim($acquirer) != "")
				{
					$AcquirerId=returnAcquirerId(trim($acquirer));
					if($AcquirerId==0)
					{
						$AcquirerId=returnAcquirerId(trim($acquirer));
						echo "<br>Acquirer Id-".$AcquirerId ."-" .$acquirer;
					}
				}
                               //echo "<Br>--2-" .$AcquirerId;
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
								$intype=$_POST['inType'];
				$advisorCompany=$_POST['txtadvisorCompany'];
				$advisorCompanyString=str_replace('"','',$advisorCompany);
				$advisorCompanyString=explode(",",$advisorCompanyString);
                                
                                ///
                                
                                 foreach($advisorCompanyString as $advCompany)
                                {
                                       if(trim($advCompany)!="")
                                       {
                                               $advCompanyIdtoInsert=insert_get_CIAs($advCompany);
                                               if($advCompanyIdtoInsert==0)
                                                       $advCompanyIdtoInsert=insert_get_CIAs($advCompany);

                                               $insAdvCompanySql=" insert into peinvestments_advisorcompanies values($MandAId,$advCompanyIdtoInsert) ";
                                               echo "<br>Advisor Companies - ".$insAdvCompanySql;
//                                               if($rsInsertAdvCompany = mysql_query($insAdvCompanySql))
//                                               {
//                                               }
                                       }
                                     
                               }
                                                                                
                              // exit;                                               
                                                                                

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

				$invdealsummary=$_POST['txtinvdealsummary'];
				$invdealsummary=str_replace('"','',$invdealsummary);

				$validation=$_POST['txtvalidation'];
				$link=$_POST['txtlink'];
                                $company_valuation=0;
				$revenue_multiple=0;
				$ebitda_multiple=0;
                                $pat_mutliple=0;

				$estimatedirr=$_POST['txtestimatedirr'];
				$moreinforeturns=$_POST['txtmoreinforeturns'];

				$flagdeletion=0;
				if($_POST['chkhidesize'])
				{
                           		$hideamount=1;
				}
				else
				{
					$hideamount=0;
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
				$fullDateAfter=$MandADate;
                                $valuation=$_POST['txtvaluation'];
				$company_valuation=$_POST['txtcompanyvaluation'];
				if($company_valuation=="")
		                      $company_valuation=0;
                                $revenue_multiple=$_POST['txtrevenuemultiple'];
				if($revenue_multiple=="")
	                              $revenue_multiple=0;

                               $ebitda_mutliple=$_POST['txtEBITDAmultiple'];
                               if($ebitda_mutliple=="")
                                      $ebitda_mutliple=0;

                               $pat_mutliple=$_POST['txtpatmultiple'];
                               if($pat_mutliple=="")
                                       $pat_mutliple=0;
									   
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

                                $finlink=$POST['txtfinlink'];
                                $uploadname=$_POST['txtfilepath'];
                                $sourcename=$_POST['txtsource'];

                                $currentdir=getcwd();
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
										//echo "<br>----------------" .$file;
									}
									else
									{
										echo "<br>Sorry, there was a problem in uploading the file.";
									}
								}
								else
									echo "<br>FILE ALREADY EXISTS IN THE SAME NAME";
							}

				$city="";
				$region="";
				//echo "<br>3- ";
				//$portfoliocompany="";
					if (trim($portfoliocompany) !="")
					{
						/*$indid=insert_industry(trim($industryname));

						if($indid==0)
						{
							$indid= insert_industry(trim($industryname));

						} */
						//echo "<br>Industryid-".$indid;
						$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$region);
						//echo "<bR>5-" .$companyId;
						if($companyId==0)
						{
							$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$region);
						}
                                                //echo "<bR>6-" .$companyId;

						if ($companyId >0)
						{

							$mainsectorid=insert_mainsector($mainsector,$indid);
							if($mainsectorid==0)
							{
								$mainsectorid=insert_mainsector($mainsector,$indid);
							}
							$subsectorid=insert_subsector($mainsectorid,$companyId,$subsector,$addsubsector);

							$pegetInvestmentsql = "select c.PECompanyId,ma.PECompanyId,DealDate from pecompanies as c,
							manda as ma where ma.PECompanyId = c.PECompanyId and
							ma.DealDate = '$fullDateAfter' and c.PECompanyId = $companyId ";

							//echo "<br>checking pe record***" .$pegetInvestmentsql;
							//echo "<br>Company id--" .$companyId;
							if ($rsInvestment = mysql_query($pegetInvestmentsql))
							{
								$investment_cnt = mysql_num_rows($rsInvestment);
					        	//echo "<br>Count**********-- " .$investment_cnt ;
							}
							if($investment_cnt>=0)
							{
                                                            //echo "<br>------- ".$hideIPO_MandAId;
									if($hideIPO_MandAId > 0)
									  $MandAId=$hideIPO_MandAId;
									else
                                                                          $MandAId= rand();
									//echo "<br>random MandAId--" .$MandAId;
									$insertcompanysql="";
									$insertcompanysql= "INSERT INTO manda (MandAId,PECompanyId,AcquirerId,DealTypeId,DealDate,DealAmount,Comment,MoreInfor,Validation,Deleted,InvestorType,type,hidemoreinfor,hideamount,VCFlag,InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,uploadfilename,source,Valuation,FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,price_to_book,book_value_per_share,price_per_share,ExitStatus,stakeSold)
									VALUES ('$MandAId','$companyId','$AcquirerId','$dealtypeId','$fullDateAfter','$MandASize','$comment','$moreinfor', '$validation',$flagdeletion,'$investortype','$intype','$hidemoreinfor','$hideamount','$Vcflag','$invdealsummary','$link','$estimatedirr','$moreinforeturns','$filename','$sourcename','$valuation','$finlink','$company_valuation','$revenue_multiple','$ebitda_mutliple','$pat_mutliple','$price_to_book','$book_value_per_share','$price_per_share','$exitstatusvalue','$stakesold')";
									echo "<br>@@@@ :".$insertcompanysql;
									if ($rsinsert = mysql_query($insertcompanysql))
									{
										//echo "<br>Insert PE-" .$insertcompanysql;
										/*for ($j=0;$j<$investorStringArrayCount;$j++)
			                                                        {
                                                                                  $inv=$investorString[$j];
                                                                                  $multiplereturnValue=$multiplereturnString[$j];
												if(trim($inv)!="")
												{
													$investorIdtoInsert=return_insert_get_Investor(trim($inv));
													if($investorIdtoInsert==0)
													{	$investorIdtoInsert= return_insert_get_Investor(trim($inv));}

														$insDeal_investors= insert_Investment_Investors($MandAId,$investorIdtoInsert,$multiplereturnValue);
												}
											}   */

										 foreach($advisorCompanyString as $advCompany)
										 {
										 	if(trim($advCompany)!="")
										 	{
										 		$advCompanyIdtoInsert=insert_get_CIAs($advCompany);
												if($advCompanyIdtoInsert==0)
													$advCompanyIdtoInsert=insert_get_CIAs($advCompany);

												$insAdvCompanySql=" insert into peinvestments_advisorcompanies values($MandAId,$advCompanyIdtoInsert) ";
												echo "<br>Advisor Companies - ".$insAdvCompanySql;
												if($rsInsertAdvCompany = mysql_query($insAdvCompanySql))
												{
												}
											}
										}

										 foreach($advisorAcquirerString as $advAcquirer)
										{
											if(trim($advAcquirer)!="")
											{

												$advAcquirerIdtoInsert=insert_get_CIAs($advAcquirer);
												//echo "<BR>~~~~~~~~~~~~~~~" .$advAcquirerIdtoInsert;
												if($advAcquirerIdtoInsert==0)
													$advAcquirerIdtoInsert=insert_get_CIAs($advAcquirer);

												$insAdvAcquirerSql="insert into peinvestments_advisoracquirer values($MandAId,$advAcquirerIdtoInsert)";
												echo "<bR>Advisor Acquirer - " .$insAdvAcquirerSql;
												if($rsInsertAcqCompany = mysql_query($insAdvAcquirerSql))
												{
												}
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
							// elseif($investment_cnt>= 1)
							// {
							?>
							<!-- <tr bgcolor="C0C0C0"> <td colspan=2 width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; M&A Deal already exists</td> </tr> -->
							<?php
							//}
					}//if companyid >0 loop ends
		} //if $portfoliocompany !=null loop ends

//} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;

//End of peinvestments insert
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

function returnAcquirerId($acquirername)
{
	$acquirername=trim($acquirername);
	//echo "<br>Acquirer- " .$acquirername;
	$dbaclinkss = new dbInvestments();
	$getAcquirerSql="select AcquirerId from acquirers where Acquirer like '$acquirername%'";
	//echo "<br>-- ".$getAcquirerSql;
	if($rsgetAcquirer=mysql_query($getAcquirerSql))
	{
		$acquirer_cnt=mysql_num_rows($rsgetAcquirer);
	//	echo "<br>-- ".$acquirer_cnt;
		if($acquirer_cnt==0)
		{
			//insert acquirer
			$insAcquirerSql="insert into acquirers(Acquirer) values('$acquirername')";
			//echo "<br>Insert Acquirer--" .$insAcquirerSql;
			if($rsInsAcquirer = mysql_query($insAcquirerSql))
			{
				$acquirerId=0;
				return $acquirerId;
			}
		}
		elseif($acquirer_cnt>=1)
		{
			While($myrow=mysql_fetch_array($rsgetAcquirer, MYSQL_BOTH))
			{
				$acquirerId = $myrow["AcquirerId"];
				//echo "<br>!!Insert return investor id--" .$acquirerId;
				return $acquirerId;
			}
		}
	}
	$dbaclinkss.close();
}

/* function to insert the companies and return the company id if exists */
	function insert_company($companyname,$industryId,$sector,$web,$city,$region)
	{
		$dbpecomp = new dbInvestments();
		$getPECompanySql = "select PECompanyId from pecompanies where companyname like '$companyname'";
		//echo "<br>select--" .$getPECompanySql;
		if ($rsgetPECompanyId = mysql_query($getPECompanySql))
		{
			$pecomp_cnt=mysql_num_rows($rsgetPECompanyId);
			//echo "<BR>INSIDE- " .$pecomp_cnt;
			if ($pecomp_cnt==0)
			{
					//insert pecompanies
					$insPECompanySql="insert into pecompanies(companyname,industry,sector_business,website,city,region)
					values('$companyname','$industryId','$sector','$web','$city','$region')";
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


/* inserts and return the investor id */
/*	function return_insert_get_Investor($investor)
	{
		$dblink= new dbInvestments();
		$investor=trim($investor);
		$getInvestorIdSql = "select InvestorId from peinvestors where Investor like '$investor%'";
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
						$AdvisorId=0;
						return $AdvisorId;
					}
			}
			elseif($investor_cnt>=1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$AdvisorId = $myrow[0];
					echo "<br>Return investor id--" .$AdvisorId;
					return $AdvisorId;
				}
			}
		}
		$dblink.close();
	}


	// the following function inserts investor and the peid in the peinvestments_investors table
	function insert_Investment_Investors($dealId,$investorId,$returnvalue)
	{
		$DbInvestInv = new dbInvestments();
		//$dbslink = mysqli_connect("ventureintelligence.ipowermysql.com", "root",  "", "peinvestmentdeals");
		$getDealInvSql="Select MandAId,InvestorId from manda_investors where MandAId=$dealId and InvestorId=$investorId";

		//echo "<br>@@@@@@--" .$getDealInvSql;
		if($rsgetdealinvestor = mysql_query($getDealInvSql))
		{
			$deal_invcnt=mysql_num_rows($rsgetdealinvestor);
			//echo "<br>****".$deal_invcnt;
			if($deal_invcnt==0)
			{
				$insDealInvSql="insert into manda_investors(MandAId,InvestorId,MultipleReturn) values($dealId,$investorId,$returnvalue)";
				if($rsinsdealinvestor = mysql_query($insDealInvSql))
				{
					//echo "<Br>******" .$insDealInvSql;
                                        return true;
				}
			}
		}
		$DbInvestInv.close();
}
  */

/* function to insert the advisor_cias table */
function insert_get_CIAs($cianame)
{
	$cianame=trim($cianame);
	$dbcialink = new dbInvestments();
	$getInvestorIdSql = "select CIAId from advisor_cias where cianame like '$cianame%'";
	//echo "<br>select--" .$getInvestorIdSql;
	if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
	{
		$investor_cnt=mysql_num_rows($rsgetInvestorId);
	//	echo "<br>Advisor cia table count-- " .$investor_cnt;
		if ($investor_cnt==0)
		{
				//insert acquirer
				$insAcquirerSql="insert into advisor_cias(cianame) values('$cianame')";
				if($rsInsAcquirer = mysql_query($insAcquirerSql))
				{
					$AdInvestorId=0;
					return $AdInvestorId;
				}
		}
		elseif($investor_cnt>=1)
		{
			While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
			{
				$AdInvestorId = $myrow[0];
		     	echo "<br>Return Advisor Id--" .$AdInvestorId;
				return $AdInvestorId;
			}
		}
	}
	$dbcialink.close();
}
		function insert_mainsector($mainsector,$indid)
		{
            
            $mainsector=trim($mainsector);
            $dbslinkss = new dbInvestments();
            $getsectorIdSql="select sector_id from pe_sectors where sector_name='$mainsector' AND industry=$indid";
            
            if($rsgetsector=mysql_query($getsectorIdSql))
            {
                $sector_cnt=mysql_num_rows($rsgetsector);
               
                if($sector_cnt==0)
                {
                    //insert deal ..mostly it wont get inserted as new..only standard 9 stages already exists
                    $inssectorIdSql ="insert into pe_sectors(sector_name,industry) values('$mainsector',$indid)";
                    if($rsInsSector = mysql_query($inssectorIdSql))
                    {
                        $sectorId=0;
                        return $sectorId;
                    }
                }
                elseif($sector_cnt==1)
                {
                    While($myrow=mysql_fetch_array($rsgetsector, MYSQL_BOTH))
                    {
                        $sectorId = $myrow[0];
                        //echo "<br>Insert return investor id--" .$invId;
                        return $sectorId;
                    }
                }
            }
            $dbslinkss.close();
        
        }

       


	 function insert_subsector($mainsectorid,$companyId,$subsector,$addsubsectorname){
            
            $subsector=trim($subsector);
            $dbslinkss = new dbInvestments();
            $getsectorIdSql="select subsector_id from pe_subsectors where subsector_name='$subsector' AND sector_id=$mainsectorid AND PECompanyId=$companyId";
            
            if($rsgetsector=mysql_query($getsectorIdSql))
            {
                $sector_cnt=mysql_num_rows($rsgetsector);
               
                if($sector_cnt==0)
                {
                    //insert deal ..mostly it wont get inserted as new..only standard 9 stages already exists
                    $inssectorIdSql ="insert into pe_subsectors(sector_id,PECompanyId,subsector_name,Additional_subsector) values($mainsectorid,$companyId,'$subsector','$addsubsectorname')";
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