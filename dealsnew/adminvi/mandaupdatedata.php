<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
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
<form name="ipoupdatedata" method=post action="ipoupdatedata.php">

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">M&A Exit deal update</font> </b></center></p>
<p></p><p></p>
<table width=60% align=center border=1 cellpadding=2>

<?php
    require("../dbconnectvi.php");
	$Db = new dbInvestments();

		$hideamouttoUpdate=0;

         $MandAIdtoUpdate = $_POST['txtMandAId'];
         $industryIdtoUpdate =$_POST['txtindustryId'];
    	 $companyIdtoUpdate = $_POST['txtcompanyid'];
    	//echo "<Br>--CompanyIdtoUpdate- ".$MandAIdtoUpdate;
    	 $companyNametoUpdate =  $_POST['txtname'];
    	 $industrytoUpdate=$_POST['industry'];
    	 $sectortoUpdate=$_POST['txtsector'];
    	 $websiteToUpdate=$_POST['txtwebsite'];
    	 $dealSizetoUpadte=$_POST['txtdealSize'];
    	 $dealtypetoUpdate=$_POST['dealtype'];
    	 $exitstatusvalue=$_POST['exitstatus'];
    	// echo "<BR>****".$exitstatusvalue;
          if($exitstatusvalue=="--")
          {   $exitstatusvalue=0;}
    	 $acquirerIdtoUpdate=$_POST['txtAcquirerId'];
    	 $acquirertoUpdate=$_POST['txtacquirer'];
    	// echo "<Br>****".$acquirertoUpdate;

    	 if(($_POST['chkhideamount']))
    	 {
    	 	$hideamouttoUpdate=1;
	    	}
	    else
	    { $hideamouttoUpdate=0;}

       	 $investorsidtoUpdate=$_POST['txtinvestorid'];
    	 $investoridarray= count($investorsidtoUpdate);
    	 $investorstoReturn=$_POST['txtinvestorsReturn'];
    	  $invmoreinfo=$_POST['txtinvmoreinfo'];
	//		echo "<br>Inv array count- " .$investoridarray;
    	 
         //$newinvestortoUpdate=$_POST['txtnewinvestor'];
         //$newinvestorString=explode(",",$newinvestortoUpdate);
         //$newinvestor=$newinvestorString[0];
         //$mutliplereturn=$newinvestorString[1];
         //if($mutliplereturn=="")
         //    $mutliplereturn=0;

         $invTypeId=$_POST['invType'];

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

		$invdealsummary=$_POST['txtinvdealsummary'];

		 $validationtoUpdate=$_POST['txtvalidation'];
		 $linktoUpdate=$_POST['txtlink'];

		   if(($_POST['chkvcflag']))
		 {
			$vcflagtoUpdate=1;
			}
		else
		{ $vcflagtoUpdate=0;}

		$estimatedirr=$_POST['txtestimatedirr'];
		$moreinforeturns=$_POST['txtmoreinforeturns'];

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
							if($pat_multiple=="")
							  $pat_multiple=0;

		$finlink=$_POST['txtfinlink'];
 		 $uploadname=$_POST['txtfilepath'];
                 //echo "<br>Upload file-".$uploadname;
			$sourcename=$_POST['txtsource'];
			$existingfile=$_POST['txtfile'];
  
  	$currentdir=getcwd();
			//echo "<br>Current Diretory=" .$currentdir;
			$curdir =  str_replace("adminvi","",$currentdir);
			//echo "<br>*****************".basename($_FILES['txtfilepath']['name']);;
			$target = $curdir . "/uploadmamafiles/".basename($_FILES['txtfilepath']['name']);
			$file = "uploadmamafiles/".basename($_FILES['txtfilepath']['name']);
			$filename= basename($_FILES['txtfilepath']['name']);
		//	echo "<Br>Target Directory=" .$target;
	//	echo "<Br>File " .$existingfile;
		if($filename!="")
		{
			if (!(file_exists($file)))
			{
				if( move_uploaded_file($_FILES['txtfilepath']['tmp_name'], $target))
				{
					echo "<br>File is getting uploaded . Please wait..";

					$file = "uploadmamafiles/" . basename($_FILES['txtfilepath']['name']);
					echo "<Br><br>The file ". basename( $_FILES['txtfilepath']['name']). " has been uploaded";
                                        //echo "<br>File uploaded-" .$file;
				}
				else
				{
					echo "<br>Sorry, there was a problem in uploading the file.";
				}
			}
			else
			    echo "<br>FILE ALREADY EXISTS  IN THAT NAME";
		}


    	 $UpdatecompanySql="update pecompanies set companyname='$companyNametoUpdate',industry=$industrytoUpdate,sector_business='$sectortoUpdate',website='$websiteToUpdate' where PECompanyId=$companyIdtoUpdate";

			//echo "<br>company update Query-- " .$UpdatecompanySql;
			if($updaters=mysql_query($UpdatecompanySql))
			{

				$UpdateInvestmentSql="update manda set DealDate='$fulldate',DealAmount=$dealSizetoUpadte,DealTypeID=$dealtypetoUpdate,
				comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',
				Validation='$validationtoUpdate',InvestorType='$invTypeId',hideamount=$hideamouttoUpdate, hidemoreinfor=$hidemoreinfortoUpdate,VcFlag=$vcflagtoUpdate,
				InvestmentDeals='$invdealsummary',Link='$linktoUpdate',EstimatedIRR='$estimatedirr',MoreInfoReturns='$moreinforeturns',
				Valuation='$valuation',FinLink='$finlink', uploadfilename='$filename',
                                	Company_Valuation=$company_valuation,Revenue_Multiple=$revenue_multiple,
                                        EBITDA_Multiple=$ebitda_mutliple,PAT_Multiple=$pat_mutliple,ExitStatus=$exitstatusvalue
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
								$updateAcquirerSql="Update manda set AcquirerId=$newacquirerIdtoUpdate where MandAId=$MandAIdtoUpdate";
								echo "<br>Update Acquirer -" .$updateAcquirerSql;
								if($rsupdatePEInvestors = mysql_query($updateAcquirerSql))
								{
								}
							}
						}
						if ($investoridarray>0)
							{
                                                          //echo "<Br>&&&&&&&" .$investoridarray;
								for ($i=0;$i<=$investoridarray-1;$i++)
								{
  								 $investorIdtoUpdate=$investorsidtoUpdate[$i];
  								 $investorswithMultipletoUpdate=$investorstoReturn[$i];
                                                                 //  echo "<bR>--".$investorswithMultipletoUpdate;
  								 $investorString=explode(",",$investorswithMultipletoUpdate);
                                                                $investortoUpdate=$investorString[0];
                                                                $returntoUpdate=$investorString[1];
                                                               // echo "<br>--- " .$returntoUpdate;

                                                                $invmoreinfostring=$invmoreinfo[$i];

                                                                  $investortoUpdate=$investorString[0];
                                                                  $returntoUpdate=$investorString[1];
                                                                  if(($returntoUpdate=="") && ($returntoUpdate==" " ))
                                                                    $returntoUpdate=0;
								 if($investortoUpdate!="")
                                                                {
                                                                  $updateInvReturnSql= "Update manda_investors set MultipleReturn=$returntoUpdate,InvMoreInfo='$invmoreinfostring' where MandAId=$MandAIdtoUpdate and InvestorId=$investorIdtoUpdate";
                                                                    echo "<Br>Update - ".$updateInvReturnSql;
                                                                  if($rsupdtaeInvReturn=mysql_query($updateInvReturnSql))
                                                                  {
                                                                    }
								}
								elseif($investortoUpdate=="")
								{
                                                                 $delInvestorSql="delete from manda_investors where MandAId=$MandAIdtoUpdate and InvestorId=$investorIdtoUpdate";

										if($rsupdatePEInv_Investors = mysql_query($delInvestorSql))
										{
                                                                                  echo "<br>Delete-" .$delInvestorSql;
										}
                                                                }
                                                              } // end of for i loop
         	                                        }
         	                                        /* if($newinvestortoUpdate!="")
                                                        {
                                                         // echo "<br>~~~~~~";
                                                            $invIdtoInsert=return_insert_get_Investor($newinvestor);
                                                         //   echo "<br>1~~~~~~~~~~~" .$invIdtoInsert;
							    if($invIdtoInsert==0)
							    {   $invIdtoInsert=return_insert_get_Investor($newinvestor);}

                                                          $insmandaInvestorSql="insert into manda_investors values($MandAIdtoUpdate,$invIdtoInsert,$mutliplereturn)";
                                                          //echo "<BR>--" .$insmandaInvestorSql;
                                                          if($rsinsert=mysql_query($insmandaInvestorSql))
                                                          {
                                                             echo "<br>****Insert - ".$insmandaInvestorSql;
                                                          }
                                                        } */


                                   //advisor company

							If(trim($AdvCompanytoUpdate!=""))
							{
								$newadvCompany=explode(",",$AdvCompanytoUpdate);
								foreach($newadvCompany as $inv)
								{
									if(trim($inv)!="")
									{
										//echo "<br>---" .$inv;
										$companyString=explode("/",$inv);
                                                                                $newadcom=$companyString[0];
                                                                                $adTypeStr=$companyString[1];
										$invIdtoInsert=insert_get_CIAs($newadcom,$adTypeStr);
									//	echo "<br>-" .$invIdtoInsert;
										if($invIdtoInsert==0)
											$invIdtoInsert=insert_get_CIAs($newadcom,$adTypeStr);
										if(in_array($invIdtoInsert,$AdvCompanyidarray)==false)
										{
											$checkSql="select * from peinvestments_advisorcompanies where PEId=$MandAIdtoUpdate and CIAId=$invIdtoInsert";
											if($rsCheckSql=mysql_query($checkSql))
											{
												$check_cnt = mysql_num_rows($rsCheckSql);
											}
											if($check_cnt==0)
											{
												$updatePEInvestorsSql="insert into peinvestments_advisorcompanies values($MandAIdtoUpdate,$invIdtoInsert)";
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
										$updatePEInv_InvestorSql="delete from peinvestments_advisorcompanies where PEId=$MandAIdtoUpdate and CIAId=$delId";
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
										foreach($newacquirerString as $newacquirer)
										{
											if(trim($newacquirer)!="")
											{
												$advisorString=explode("/",$newacquirer);
										               $newadinv=$advisorString[0];
										               $adtype=$advisorString[1];
												$acqIdtoInsert=insert_get_CIAs($newadinv,$adtype);
												//echo "<br>-" .$acqIdtoInsert;
												if($acqIdtoInsert==0)
													$acqIdtoInsert=insert_get_CIAs($newadinv,$adtype);
												if(in_array($acqIdtoInsert,$AdvAcquireridarray)==false)
												{
														$updateMAMAAcquirerSql="insert into peinvestments_advisoracquirer values($MandAIdtoUpdate,$acqIdtoInsert)";
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
												$updateMAMA_AcquirerSql="delete from peinvestments_advisoracquirer where PEID=$MandAIdtoUpdate and CIAId=$delAcId";
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
	$getAcquirerSql="select * from acquirers where Acquirer like '$acquirername%'";
	if($rsgetAcquirer=mysql_query($getAcquirerSql))
	{
		$acquirer_cnt=mysql_num_rows($rsgetAcquirer);
		//echo "<br>-- ".$acquirer_cnt;
		if($acquirer_cnt==0)
		{
			//insert acquirer
			$insAcquirerSql="insert into acquirers(Acquirer,CityId,countryid) values('$acquirername','$cityid','$countryid')";
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



/* function to insert the advisor_cias table */
function insert_get_CIAs($cianame,$adType)
{
	$cianame=trim($cianame);
	$dbcialink = new dbInvestments();
	$getInvestorIdSql = "select CIAId,AdvisorType from advisor_cias where cianame like '$cianame%'";
	echo "<br>select--" .$getInvestorIdSql;
	if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
	{
		$investor_cnt=mysql_num_rows($rsgetInvestorId);

		//echo "<br>Advisor cia table count-- " .$investor_cnt;
		if ($investor_cnt==0)
		{
				//insert acquirer
				$insAcquirerSql="insert into advisor_cias(cianame,AdvisorType) values('$cianame','$adType')";
				if($rsInsAcquirer = mysql_query($insAcquirerSql))
				{
					$AdInvestorId=0;
					return $InvestorId;
				}
		}
		elseif($investor_cnt>=1)
		{
			While($myAcrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
			{
				$AdInvestorId = $myAcrow["CIAId"];
				$adtypestr=$myAcrow[1];
					if($adtypestr!=$adType)
				{
    				    $updateAdTypeSql="Update advisor_cias set AdvisorType='$adType' where CIAId=$AdInvestorId";
    				    //echo "<Br>^^^".$updatAdTypeSql;
    				    if($rsupdate=mysql_query($updateAdTypeSql))
    				    {
                                    }
                                }
		//		echo "<br>Insert return investor id--" .$myAcrow[0];
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
		$getInvestorIdSql = "select InvestorId from peinvestors where Investor like '$investor%'";
		//echo "<br>select--" .$getInvestorIdSql;
		if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
		{
			$investor_cnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;
			if ($investor_cnt==0)
			{
					//echo "<br>----insert Investor ";
					$insAcquirerSql="insert into peinvestors(Investor) values('$investor')";
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
					//echo "<br>Insert return investor id--" .$invId;
					return $InvestorId;
				}
			}
		}
		$dblink.close();
	}
?>