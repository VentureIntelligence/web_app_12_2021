<?php include_once("../../globalconfig.php"); ?>
<?php
	require("../dbconnectvi.php");
     $Db = new dbInvestments();
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
     	session_start();
	 	if (session_is_registered("SessLoggedAdminPwd"))
	 	{
// && session_is_registered("SessLoggedIpAdd"))

							//echo "<br>full string- " .$i;

							$portfoliocompany = $_POST['txtcompanyname'];
							//echo "<br>company. ".$portfoliocompany;
							$indid= $_POST['txtindustry'];  //industry id directly
							$sector=$_POST['txtsector'];

      						$col6=$_POST['txtinvestors'];
      						$investorString=str_replace('"','',$col6);
                                          $incubatorId=return_insert_get_incubator($investorString);
                                          if($incubatorId==0)
                                          { $incubatorId= return_insert_get_incubator($investorString); }
                                          //echo "<bR>--- " .$incubatorId;
                                            if($_POST['chkfollowonfund'])
  							{
  							$followonfund=1;
  							}
  							else
  							{$followonfund=0;
  							}

                           	//$yearfounded=$_POST['txtyearfounded'];
                           	//if($yearfounded=="")
                              $yearfounded=0;
                              $mthtoUpdate=$_POST['month1'];
                	 $YrtoUpdate=$_POST['year1'];
                	     if(($mthtoUpdate=="--") && ($YrtoUpdate=="--"))
                	      $fulldate="0000-00-00";
                	     else
                          $fulldate= $YrtoUpdate."-".$mthtoUpdate."-01";
                  			$website=$_POST['txtwebsite'];
							$city=$_POST['txtcity'];
							$regionId=$_POST['txtregion'];
							$txtregion=return_insert_get_RegionId($regionId);

                 			$comment=$_POST['txtcomment'];
							$comment=str_replace('"','',$comment);
							$moreinfor=$_POST['txtmoreinfor'];
							$moreinfor=str_replace('"','',$moreinfor);
							$statusid=$_POST['txtstatus'];

							$validation=$_POST['txtvalidation'];

							if($_POST['chkindividual'])
							{
								//echo"<br>***************";
								$indiflag=1;
							}
							else
							{$indiflag=0;
							}
                                                         if($_POST['chkDefunct'])
							{
								//echo"<br>***************";
								$defunctflag=1;
							}
							else
							{$defunctflag=0;
							}
							if (trim($portfoliocompany) !="")
							{
       							$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$txtregion,$regionId);
								//echo "<bR>####---------------------";
								if($companyId==0)
								{
									$companyId=insert_company($portfoliocompany,$indid,$sector,$website,$city,$region,$RegionIdtoUpdate);
								}
								//$companyId=0;
							//	echo "<br>Company id--" .$companyId;
								if ($companyId >0)
								{
									$pegetInvestmentsql= "select IncubateeId from incubatordeals
							      where IncubateeId=$companyId  and Deleted=0";;

									//echo "<br>checking pe record***" .$pegetInvestmentsql;
									//echo "<br>Company id--" .$companyId;
									if ($rsInvestment = mysql_query($pegetInvestmentsql))
									{
									   $investment_cnt = mysql_num_rows($rsInvestment);
									// echo "<br>Count**********-- " .$investment_cnt ;
									}
									if($investment_cnt==0)
									{
											$IncDealId= rand();
											//echo "<br>random MandAId--" .$PEId;
											$insertcompanysql="INSERT INTO incubatordeals (IncDealId,IncubateeId,IncubatorId,Comment,MoreInfor,StatusId,Deleted,Individual,FollowonFund,Defunct,date_month_year)
							                            VALUES ($IncDealId,$companyId,$incubatorId,'$comment','$moreinfor',$statusid,0,$indiflag,$followonfund,$defunctflag,'$fulldate')";

											if ($rsinsert = mysql_query($insertcompanysql))
											{
												echo "<br>@@@@ :".$insertcompanysql;
											?>
											<Br>
											<tr bgcolor="#00CC66"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $datedisplay . " - " .$portfoliocompany ; ?>&nbsp; --> Inserted</td> </tr>
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
									elseif($investment_cnt>= 1)
									{
									?>
									<tr bgcolor="C0C0C0"> <td width=20% style="font-family: Verdana; font-size: 8pt"><?php echo $portfoliocompany; ?>&nbsp; -->Incubator Deal already exists</td> </tr>
									<?php
									}
								}//if companyid >0 loop ends
							} //if $portfoliocompany !=null loop ends

} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;

//End of peinvestments insert

/* function to insert the companies and return the company id if exists */
	function insert_company($companyname,$industryId,$sector,$web,$city,$region,$regionId)
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
					$insPECompanySql="insert into pecompanies(companyname,industry,sector_business,website,AdCity,region,RegionId)
					values('$companyname',$industryId,'$sector','$web','$city','$region',$regionId)";
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
		$dbpecomp.close();
	}
   //function to get RegionId
	function return_insert_get_RegionId($regionId)
	{
		$dbregionlink = new dbInvestments();
		$getRegionIdSql = "select Region from region where RegionId=$regionId";
		if ($rsgetInvestorId = mysql_query($getRegionIdSql))
		{
			$regioncnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;

			if($regioncnt>=1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$regionId = $myrow[0];
					//echo "<br>Insert return investor id--" .$invId;
					return $regionId;
				}
			}
		}
		$dbregionlink.close();
	}

    //function to insert investors
	function return_insert_get_incubator($incubatorname)
	{
		$incubator=trim($incubatorname);
		$incubator=ltrim($incubatorname);
		$incubator=rtrim($incubatorname);
		$dblink = new dbInvestments();
		$getInvestorIdSql = "select IncubatorId from incubators where Incubator like '$incubator'";
	//	echo "<br>select--" .$getInvestorIdSql;
		if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
		{
			$investor_cnt=mysql_num_rows($rsgetInvestorId);
 			if ($investor_cnt==0)
			{
					//echo "<br>----insert Investor ";
					$insAcquirerSql="insert into incubators(Incubator) values('$incubatorname')";
					if($rsInsAcquirer = mysql_query($insAcquirerSql))
					{
						$IncubatorId=0;
						return $IncubatorId;
					}
			}
			elseif($investor_cnt>=1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$IncubatorId = $myrow[0];
					echo "<br>Insert return investor id--" .$IncubatorId;
					return $IncubatorId;
				}
			}
		}
		$dblink.close();
	}

?>



