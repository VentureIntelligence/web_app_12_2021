<?php include_once("../globalconfig.php"); ?>
<?php
/*
	created : Nov-13-09
	file name: remandaupdatedata.php
	form name: remandaupdatedata
	invoked from:remandaeditdata.php
*/
   require("../dbconnectvi.php");
	$Db = new dbInvestments();
 session_save_path("/tmp");
	session_start();
	//if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	//{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Update M&A Exit data : : Contact TSJ Media : :</title>

<SCRIPT LANGUAGE="JavaScript">

</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<form name="remandaupdatedata" method="post">

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">RE - M&A Exit deal update</font> </b></center></p>
<p></p><p></p>
<table width=60% align=center border=1 cellpadding=2>

<?php
 

		$hideamouttoUpdate=0;

         $MandAIdtoUpdate = $_POST['txtMandAId'];
         $industryIdtoUpdate =$_POST['txtindustryId'];
    	 $companyIdtoUpdate = $_POST['txtcompanyid'];
    	//echo "<Br>--CompanyIdtoUpdate- ".$MandAIdtoUpdate;
    	 $companyNametoUpdate =  $_POST['txtname'];
    	 $industrytoUpdate=$_POST['industry'];
    	 $sectortoUpdate=$_POST['txtsector'];
    	 $citytoUpdate=$_POST['txtcity'];
    	 $regionIdtoUpdate=$_POST['txtregion'];
    	 $websiteToUpdate=$_POST['txtwebsite'];
    	 $dealSizetoUpadte=$_POST['txtdealSize'];
    	 $dealtypetoUpdate=$_POST['dealtype'];
    	 $acquirerIdtoUpdate=$_POST['txtAcquirerId'];
    	 $acquirertoUpdate=$_POST['txtacquirer'];
    	// echo "<Br>****".$acquirertoUpdate;

          $exitstatusvalue=$_POST['exitstatus'];
            if($exitstatusvalue=="--")
            {   $exitstatusvalue=0;}

    	 if(($_POST['chkhideamount']))
    	 {
    	 	$hideamouttoUpdate=1;
	    	}
	    else
	    { $hideamouttoUpdate=0;}

         $stagetoUpdate=$_POST['stage'];
    	 $investorsidtoUpdate=$_POST['txtinvestorid'];
    	 $investoridarray= count($investorsidtoUpdate);
		//	echo "<br>Inv array count- " .$investoridarray;
    	 $investorstoUpdate=$_POST['txtinvestors'];

    	  $AdvCompanyIdToUpdate=$_POST['txtAdvcompId'];
    	 $AdvCompanyidarray= count($AdvCompanyIdToUpdate);
    	   $AdvCompanytoUpdate=$_POST['txtAdvCompany'];


		 $AdvAcquirerIdToUpdate=$_POST['txtAdvAcqId'];
		 $AdvAcquireridarray= count($AdvAcquirerIdToUpdate);
    	 $AdvAcquirertoUpdate=$_POST['txtAdvAcquirer'];


    	 $mthtoUpdate=$_POST['month1'];
    	 $YrtoUpdate=$_POST['year1'];
    	 $fulldate= $YrtoUpdate."-".$mthtoUpdate."-01";

    	 $commenttoUpdate=$_POST['txtcomment'];
    	 $moreInfortoUpdate=$_POST['txtmoreinfor'];
    	  if(($_POST['chkhidemoreinfor']))
		 {
			$hidemoreinfortoUpdate=1;
			}
		else
		{ $hidemoreinfortoUpdate=0;}

		 $validationtoUpdate=$_POST['txtvalidation'];
		 $invdealsummary=$_POST['txtinvdealsummary'];
		 	$invdealsummary=str_replace('"','',$invdealsummary);

		 $linktoUpdate=$_POST['txtlink'];
		 $estimatedirr=$_POST['txtestimatedirr'];
		$moreinforeturns=$_POST['txtmoreinforeturns'];
           if(($_POST['chkspv']))
           	$spvtoUpdate=1;
	   else
                 $spvtoUpdate=0;
	     $projectname=$_POST['txtprojectname'];

    	 $UpdatecompanySql="update REcompanies set companyname='$companyNametoUpdate',industry=$industrytoUpdate,sector_business='$sectortoUpdate',website='$websiteToUpdate' where PECompanyId=$companyIdtoUpdate";

			//echo "<br>company update Query-- " .$UpdatecompanySql;
			if($updaters=mysql_query($UpdatecompanySql))
			{

				$UpdateInvestmentSql="update REmanda set DealDate='$fulldate',DealAmount=$dealSizetoUpadte,DealTypeID=$dealtypetoUpdate,
				comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',
				Validation='$validationtoUpdate',hideamount=$hideamouttoUpdate, hidemoreinfor=$hidemoreinfortoUpdate,
				city='$citytoUpdate',RegionId=$regionIdtoUpdate,InvestmentDeals='$invdealsummary',Link='$linktoUpdate',
                                EstimatedIRR='$estimatedirr',MoreInfoReturns='$moreinforeturns',
                                StageId=$stagetoUpdate,SPV=$spvtoUpdate,ProjectName='$projectname',ExitStatus='$exitstatusvalue'
				where MandAId=$MandAIdtoUpdate";
				echo "<br>Query--**-- " .$UpdateInvestmentSql;
				if($updatersinvestment=mysql_query($UpdateInvestmentSql))
				{
					//echo "<bR>********";
					$idarray = array();
					$advcomparray=array();
					$advinvarray=array();

					//Acquirer
						If(trim($acquirertoUpdate!=""))
						{

							$newacquirerIdtoUpdate=returnAcquirerId($acquirertoUpdate,"","IN");
							//echo "<Br>1 ^^^".$newacquirerIdtoUpdate;
							if($newacquirerIdtoUpdate==0)
							{	$newacquirerIdtoUpdate=returnAcquirerId($acquirertoUpdate,"","IN");
							//	echo "<Br>2 ^^^".$newacquirerIdtoUpdate;
							}

							if($acquirerIdtoUpdate!=$newacquirerIdtoUpdate)
							{
								$updateAcquirerSql="Update REmanda set AcquirerId=$newacquirerIdtoUpdate where MandAId=$MandAIdtoUpdate";
								echo "<br>Update Acquirer -" .$updateAcquirerSql;
								if($rsupdatePEInvestors = mysql_query($updateAcquirerSql))
								{
								}
							}
						}



							If(trim($investorstoUpdate!=""))
							{
								$newinvestor=explode(",",$investorstoUpdate);
								foreach($newinvestor as $inv)
								{
									if(trim($inv)!="")
									{
										$invIdtoInsert=return_insert_get_Investor($inv);
										//echo "<br>-" .$invIdtoInsert;
										if($invIdtoInsert==0)
											$invIdtoInsert=return_insert_get_Investor($inv);
										if(in_array($invIdtoInsert,$investorsidtoUpdate)==false)
										{
											$updatePEInvestorsSql="insert into REmanda_investors values($MandAIdtoUpdate,$invIdtoInsert)";
											echo "<br>Insert Invesotor query-" .$updatePEInvestorsSql;
											if($rsupdatePEInvestors = mysql_query($updatePEInvestorsSql))
											{
											}
										}
										$idarray[]=$invIdtoInsert;
									}
								}
							}
							if ($investoridarray>0)
							{
								for ($i=0;$i<=$investoridarray-1;$i++)
								{
									$delId=$investorsidtoUpdate[$i];
									if(in_array($delId,$idarray)==false)
									{
										$updatePEInv_InvestorSql="delete from REmanda_investors where MandAId=$MandAIdtoUpdate and InvestorId=$delId";
										echo "<br>Delete Investor Query-" .$updatePEInv_InvestorSql;
										if($rsupdatePEInv_Investors = mysql_query($updatePEInv_InvestorSql))
										{
										}
									}
								}
							}
//advisor company

							If(trim($AdvCompanytoUpdate!=""))
							{
								$newadvCompany=explode(",",$AdvCompanytoUpdate);
								foreach($newadvCompany as $invstring)
								{
									if(trim($invstring)!="")
									{
                                                                            
                                                                            
                                                                            $advisorString=explode("/",$invstring);
                                                                            $inv=$advisorString[0];
                                                                            $adtype=$advisorString[1];
                                                                                            
                                                                                            
										//echo "<br>---" .$inv;
										$invIdtoInsert=insert_get_CIAs($inv,$adtype);
									//	echo "<br>-" .$invIdtoInsert;
										if($invIdtoInsert==0)
											$invIdtoInsert=insert_get_CIAs($inv,$adtype);
										if(in_array($invIdtoInsert,$AdvCompanyidarray)==false)
										{
											$checkSql="select * from REinvestments_advisorcompanies where PEId=$MandAIdtoUpdate and CIAId=$invIdtoInsert";
											if($rsCheckSql=mysql_query($checkSql))
											{
												$check_cnt = mysql_num_rows($rsCheckSql);
											}
											if($check_cnt==0)
											{
												$updatePEInvestorsSql="insert into REinvestments_advisorcompanies values($MandAIdtoUpdate,$invIdtoInsert)";
												echo "<br>Insert Advisor Company query-" .$updatePEInvestorsSql;
												if($rsupdatePEInvestors = mysql_query($updatePEInvestorsSql))
												{
												}
											}
										}
										$idarray[]=$invIdtoInsert;
									}
								}
							}
							if ($AdvCompanyidarray>0)
							{
								//echo "<br>```````````";
								for ($i=0;$i<=$AdvCompanyidarray-1;$i++)
								{
									$delId=trim($AdvCompanyIdToUpdate[$i]);
									//echo "<br>!!!!!!!!" .$delId;
									if(in_array($delId,$idarray)==false)
									{
										$updatePEInv_InvestorSql="delete from REinvestments_advisorcompanies where PEId=$MandAIdtoUpdate and CIAId=$delId";
										echo "<br>Delete Investor Query-" .$updatePEInv_InvestorSql;
										if($rsupdatePEInv_Investors = mysql_query($updatePEInv_InvestorSql))
										{
										}
									}
								}
							}


	//advisor acquirer

								//echo "<br>Advisor Acquirer**************" .$AdvAcquirertoUpdate;
									If(trim($AdvAcquirertoUpdate!=""))
									{
										$newacquirerString=explode(",",$AdvAcquirertoUpdate);
										foreach($newacquirerString as $invstring)
										{
											if(trim($invstring)!="")
											{
                                                                                            
                                                                                            
                                                                                            $advisorString=explode("/",$invstring);
                                                                                            $newacquirer=$advisorString[0];
                                                                                            $adtype=$advisorString[1];
                                                                                
                                                                                
												//echo "<br>&&&".$newacquirer;
												$acqIdtoInsert=insert_get_CIAs($newacquirer,$adtype);
												//echo "<br>-" .$acqIdtoInsert;
												if($acqIdtoInsert==0)
													$acqIdtoInsert=insert_get_CIAs($newacquirer,$adtype);
                                                                                                
												if(in_array($acqIdtoInsert,$AdvAcquireridarray)==false)
												{
														$updateMAMAAcquirerSql="insert into REinvestments_advisoracquirer values($MandAIdtoUpdate,$acqIdtoInsert)";
														if($rsupdateAcqInvestors = mysql_query($updateMAMAAcquirerSql))
														{
															echo "<br>Insert Advisor Company query-" .$updateMAMAAcquirerSql;
														}

												}
												$acqidarray[]=$acqIdtoInsert;
											}
										}
									}

									if ($AdvAcquireridarray>0)
									{
										for ($i=0;$i<=$AdvAcquireridarray-1;$i++)
										{
											//echo "<Br>2 To delete - " .$AdvAcquirerIdToUpdate[$i];
											//echo "<br>3 -- ".$acqidarray[$i];
											$delAcId=trim($AdvAcquirerIdToUpdate[$i]);
											if(in_array(trim($delAcId),$acqidarray)==false)
											{
												//echo "<Br>false";
												$updateMAMA_AcquirerSql="delete from REinvestments_advisoracquirer where PEID=$MandAIdtoUpdate and CIAId=$delAcId";
												if($rsupdatePEInv_Investors = mysql_query($updateMAMA_AcquirerSql))
												{
													echo "<br>Delete Acquirer-" .$updateMAMA_AcquirerSql;
												}
											}
										}
								}


				?>
				<tr><td>
				 <font style="font-family: Verdana; font-size: 8pt"> Deal has been updated</font>

				</td></tr>
<?php

			}
		}
	?>


</table>



<?php

//} // if resgistered loop ends
//else
//	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>
</form>
</body></html>
<?php

function returnAcquirerId($acquirername,$cityid,$countryid)
{
	$acquirername=trim($acquirername);
	//echo "<br>Acquirer- " .$acquirername;
	$dbaclinkss = new dbInvestments();
	$getAcquirerSql="select * from REacquirers where Acquirer = '$acquirername'";
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



/* function to insert the advisor_cias table */
function insert_get_CIAs($cianame, $advtype)
{
	$cianame=trim($cianame);
	$dbcialink = new dbInvestments();
	$getInvestorIdSql = "select CIAId,AdvisorType from REadvisor_cias where cianame like '$cianame%'";
	echo "<br>select--" .$getInvestorIdSql;
	if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
	{
		$investor_cnt=mysql_num_rows($rsgetInvestorId);

		//echo "<br>Advisor cia table count-- " .$investor_cnt;
		if ($investor_cnt==0)
		{
				//insert acquirer
				$insAcquirerSql="insert into REadvisor_cias(cianame,AdvisorType) values('$cianame','$advtype')";
				if($rsInsAcquirer = mysql_query($insAcquirerSql))
				{
					$AdInvestorId=0;
					return $InvestorId;
				}
		}
		elseif($investor_cnt>=1)
		{
//			While($myAcrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
//			{
//				$AdInvestorId = $myAcrow["CIAId"];
//		//		echo "<br>Insert return investor id--" .$myAcrow[0];
//				return $AdInvestorId;
//			}
                        
                        
                        While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
			{
				$AdInvestorId = $myrow[0];
                                $adtypestr=$myrow[1];
				echo "<br>Id - ".$AdInvestorId ." - " .$adtypestr;
				if($adtypestr!=$advtype)
				{
				echo "<br>Insert return investor id--" .$invId;
			             $updateAdTypeSql="Update REadvisor_cias set AdvisorType='$advtype' where CIAId=$AdInvestorId";
                                    echo "<Br>Update ^^^".$updateAdTypeSql;
    				    if($rsupdate=mysql_query($updateAdTypeSql))
    				    {
                                        echo "<br>** Advisor Type Udpated ";
                                    }
                                 }
				return $AdInvestorId;
			}
		}
	}
	$dbcialink.close();
}

//function to insert investors
	function return_insert_get_Investor($investor)
	{
		$investor=trim($investor);
		$investor=ltrim($investor);
		$investor=rtrim($investor);
		$dblink = new dbInvestments();
		$getInvestorIdSql = "select InvestorId from REinvestors where Investor='$investor'";
		//echo "<br>select--" .$getInvestorIdSql;
		if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
		{
			$investor_cnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;
			if ($investor_cnt==0)
			{
					//echo "<br>----insert Investor ";
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
					//echo "<br>Insert return investor id--" .$invId;
					return $InvestorId;
				}
			}
		}
		$dblink.close();
	}
?>
