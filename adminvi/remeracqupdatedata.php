<?php include_once("../globalconfig.php"); ?>
<?php
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
<form name="remeracqupdatedata" method=post action="remeracqupdatedata.php">

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">RE M&A Exit deal update</font> </b></center></p>
<p></p><p></p>
<table width=60% align=center border=1 cellpadding=2>

<?php
    

		$hideamouttoUpdate=0;

         $MandAIdtoUpdate = $_POST['txtMAMAId'];
     //    echo "<br>--------" .$MandAIdtoUpdate;

         $industryIdtoUpdate =$_POST['txtindustryId'];
    	 $companyIdtoUpdate = $_POST['txtcompanyid'];
    	//echo "<Br>--CompanyIdtoUpdate- ".$MandAIdtoUpdate;
    	 $companyNametoUpdate =  $_POST['txtname'];
    	 $industrytoUpdate=$_POST['industry'];
    	 $sectortoUpdate=$_POST['txtsector'];
    	 $dealSizetoUpadte=$_POST['txtdealSize'];
    	 $staketoUpdate=$_POST['txtstake'];
    	  $mthtoUpdate=$_POST['month1'];
		  $YrtoUpdate=$_POST['year1'];
    	 $fulldate= $YrtoUpdate."-".$mthtoUpdate."-01";

    	 $dealtypetoUpdate=$_POST['dealtype'];
    	 //$projectIdtoUpdate=$_POST['txttargettype'];


    	 if(($_POST['chkhideamount']))
    	 {
    	 	$hideamouttoUpdate=1;
	    	}
	    else
	    { $hideamouttoUpdate=0;}


    	 $AdvCompanyIdToUpdate=$_POST['txtAdvcompId'];
    	 $AdvCompanyidarray= count($AdvCompanyIdToUpdate);

	//echo "<br>Inv Company array count- " .$AdvCompanyidarray;
    	 $AdvCompanytoUpdate=$_POST['txtAdvCompany'];

		$targetCityName=$_POST['txtTargetCityName'];
		$regionIdtoUpdate=$_POST['txtregion'];

		$targetCountryIdtoUpdate=$_POST['targetcountry'];
    	 $websiteToUpdate=$_POST['txtwebsite'];

	 	$acquirerIdtoUpdate=$_POST['txtAcquirerId'];
    	 $acquirertoUpdate=$_POST['txtacquirer'];

		$acquirerCityName=$_POST['txtAcquirerCityName'];

		$acquirerCountryIdtoUpdate=$_POST['acquirercountry'];


		$NewacquirerIdtoUpdate=returnAcquirerId($acquirertoUpdate,$acquirerCityName,$acquirerCountryIdtoUpdate);
		if($NewacquirerIdtoUpdate==0)
			{
				$NewacquirerIdtoUpdate=returnAcquirerId($acquirertoUpdate,$acquirerCityName,$acquirerCountryIdtoUpdate);
			//	echo "<br>Acquirer Id-".$AcquirerId ."-" .$acquirer;
			}

//		echo "<br>7--";

		 $AdvAcquirerIdToUpdate=$_POST['txtAdvAcqId'];
		 $AdvAcquireridarray= count($AdvAcquirerIdToUpdate);
		//	echo "<br>Inv array count- " .$AdvAcquireridarray;
    	 $AdvAcquirertoUpdate=$_POST['txtAdvAcquirer'];

    	 $commenttoUpdate=$_POST['txtcomment'];
    	 $moreInfortoUpdate=$_POST['txtmoreinfor'];

		 $validationtoUpdate=$_POST['txtvalidation'];
		 $linktoUpdate=$_POST['txtlink'];
		    if(($_POST['chkAssetFlag']))
		   		 {
		   			$assetflag=1;
		   			}
		   		else
		{ $assetflag=0;}
		$valuation=$_POST['txtvaluation'];
		$finlink=$_POST['txtfinlink'];
		$uploadname=$_POST['txtfilepath'];
		$sourcename=$_POST['txtsource'];
		$existingfile=$_POST['txtfile'];

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
				echo "<br>File is getting uploaded . Please wait..";
				echo "<Br>The file ". basename( $_FILES['txtfilepath']['name']). " has been uploaded";

				$file = "uploadrefiles/" . basename($_FILES['txtfilepath']['name']);
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

//echo "<br>8--";
	$UpdatecompanySql="update REcompanies set companyname='$companyNametoUpdate',industry=$industrytoUpdate,
	    	 sector_business='$sectortoUpdate',website='$websiteToUpdate', countryid='$targetCountryIdtoUpdate' where PECompanyId=$companyIdtoUpdate";

			//	echo "<br>company update Query-- " .$UpdatecompanySql;
			if($updaters=mysql_query($UpdatecompanySql))
				{
						$modifieddate=date("Y-m-d")." ".date("H:i:s");
						if($existingfile!="")
						{
							$UpdateInvestmentSql="update REmama set DealDate='$fulldate',Amount=$dealSizetoUpadte,Stake=$staketoUpdate,AcquirerId=$NewacquirerIdtoUpdate,MADealTypeID=$dealtypetoUpdate,
							Comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',Asset=$assetflag,ModifiedDate='$modifieddate',
							Validation='$validationtoUpdate',city='$targetCityName',RegionId=$regionIdtoUpdate,Valuation='$valuation',FinLink='$finlink'

							where MAMAId=$MandAIdtoUpdate";
						}
						else
						{
							$UpdateInvestmentSql="update REmama set DealDate='$fulldate',Amount=$dealSizetoUpadte,Stake=$staketoUpdate,AcquirerId=$NewacquirerIdtoUpdate,MADealTypeID=$dealtypetoUpdate,
							Comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',Asset=$assetflag,ModifiedDate='$modifieddate',
							Validation='$validationtoUpdate',city='$targetCityName',RegionId=$regionIdtoUpdate,uploadfilename='$filename',source='$sourcename',
							Valuation='$valuation',FinLink='$finlink'
							where MAMAId=$MandAIdtoUpdate";
						}

					if($updatersinvestment=mysql_query($UpdateInvestmentSql))
					{
						$idarray = array();
						$advcomparray=array();
						$advinvarray=array();

						//adviosor target
								//echo "<br>Inv Company array count- " .$AdvCompanyidarray;

								If(trim($AdvCompanytoUpdate!=""))
								{
									$newinvestor=explode(",",$AdvCompanytoUpdate);
									foreach($newinvestor as $invstring)
									{

										if(trim($invstring)!="")
										{
											$advisorString=explode("/",$invstring);
											$inv=$advisorString[0];
										        $adtype=$advisorString[1];
											$invIdtoInsert=insert_get_CIAs($inv,$adtype);
										//	echo "<br>-" .$invIdtoInsert;
											if($invIdtoInsert==0)
												$invIdtoInsert=insert_get_CIAs($inv,$adtype);
											if(in_array($invIdtoInsert,$AdvCompanyidarray)==false)
											{
												$updatePEInvestorsSql="insert into REmama_advisorcompanies values($MandAIdtoUpdate,$invIdtoInsert)";
												echo "<br>Insert RE Advisor Company query-" .$updatePEInvestorsSql;
												if($rsupdatePEInvestors = mysql_query($updatePEInvestorsSql))
												{
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
										$delId=$AdvCompanyIdToUpdate[$i];
										//echo "<br>!!!!!!!!" .$delId;
										if(in_array($delId,$idarray)==false)
										{
											$updatePEInv_InvestorSql="delete from REmama_advisorcompanies where MAMAId=$MandAIdtoUpdate and CIAId=$delId";
											echo "<br>Delete RE Investor Query-" .$updatePEInv_InvestorSql;
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
									foreach($newacquirerString as $newacquirerInvString)
									{
										if(trim($newacquirerInvString)!="")
										{
											$acquirerString=explode("/",$newacquirerInvString);
      										        $newacquirer=$acquirerString[0];
						                                        $adatype=$acquirerString[1];
											$acqIdtoInsert=insert_get_CIAs($newacquirer,$adatype);
											//echo "<br>-" .$acqIdtoInsert;
											if($acqIdtoInsert==0)
												$acqIdtoInsert=insert_get_CIAs($newacquirer,$adatype);
											if(in_array($acqIdtoInsert,$AdvAcquireridarray)==false)
											{
												$updateMAMAAcquirerSql="insert into REmama_advisoracquirer values($MandAIdtoUpdate,$acqIdtoInsert)";
												echo "<br>Insert RE Advisor Company query-" .$updateMAMAAcquirerSql;
												if($rsupdateAcqInvestors = mysql_query($updateMAMAAcquirerSql))
												{
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
										$delId=$AdvAcquirerIdToUpdate[$i];
										if(in_array($delId,$acqidarray)==false)
										{
											$updateMAMA_AcquirerSql="delete from REmama_advisoracquirer where MAMAId=$MandAIdtoUpdate and CIAId=$delId";
											echo "<br>Delete RE Investor Query-" .$updateMAMA_AcquirerSql;
											if($rsupdatePEInv_Investors = mysql_query($updateMAMA_AcquirerSql))
											{
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
/* function to insert the advisor_cias table */
function insert_get_CIAs($cianame,$advtype)
{
	$cianame=trim($cianame);
	$dbcialink = new dbInvestments();
	$getInvestorIdSql = "select CIAId from REadvisor_cias where cianame like '$cianame'";
	//echo "<br>select--" .$getInvestorIdSql;
	if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
	{
		$investor_cnt=mysql_num_rows($rsgetInvestorId);
	//	echo "<br>Advisor cia table count-- " .$investor_cnt;
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

			While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
			{
                           $AdInvestorId = $myrow[0];
                           $adtypestr=$myrow[1];
                           	if($adtypestr!=$advtype)
				{
                                   $updateAdTypeSql="Update REadvisor_cias set AdvisorType='$advtype' where CIAId=$AdInvestorId";
                                      if($rsupdate=mysql_query($updateAdTypeSql))
    				    {
                                        echo "<br>** RE Advisor Type Udpated ";
                                    }
                                 }
				return $AdInvestorId;
			}
		}
	}
	$dbcialink.close();
}




function returnAcquirerId($acquirername,$cityid,$countryid)
{
	//echo "<br>***********************";

	$acquirername=trim($acquirername);
	//echo "<br>Acquirer- " .$acquirername;
	$dbaclinkss = new dbInvestments();
	$getAcquirerSql="select AcquirerId from REacquirers where Acquirer like '$acquirername'";
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
				$updateSql = "Update REacquirers set Acquirer='$acquirername',CityId='$cityid',countryid='$countryid' where AcquirerId=$acquirerId";
				echo "<Br>---" .$updateSql;
				if($updateAcquirerrs=mysql_query($updateSql))
				{
				//		echo "<br>Acquirer Update - ".$updateSql;
				}
				//echo "<br>!! return Acquirer  id--" .$acquirerId;
				return $acquirerId;
			}
		}
	}

	$dbaclinkss.close();

}

?>