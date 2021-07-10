<?php include_once("../globalconfig.php"); ?>
<?php
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
<form name="ipoupdatedata" method=post action="meracqupdatedata.php">

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">M&A Exit deal update</font> </b></center></p>
<p></p><p></p>
<table width=60% align=center border=1 cellpadding=2>

<?php
    require("../dbconnectvi.php");
	$Db = new dbInvestments();
	$user=$_SESSION['UserNames'];

		$hideamouttoUpdate=0;

         $MandAIdtoUpdate = $_POST['txtMAMAId'];
     //    echo "<br>--------" .$MandAIdtoUpdate;

         $industryIdtoUpdate =$_POST['txtindustryId'];
    	 $companyIdtoUpdate = $_POST['txtcompanyid'];
    	//echo "<Br>--CompanyIdtoUpdate- ".$MandAIdtoUpdate;
    	 $companyNametoUpdate =  $_POST['txtname'];
    	 $target_listingstatusvalue=$_POST['target_listingstatus'];
    	 if($target_listingstatusvalue=="--")
    	     $target_listingstatusvalue="U";

    	 $industrytoUpdate=$_POST['industry'];
    	 $sectortoUpdate=$_POST['txtsector'];
    	 $dealSizetoUpadte=$_POST['txtdealSize'];
    	 if(($dealSizetoUpadte=="") || ($dealSizetoUpadte<=0))
    	     $dealSizetoUpadte=0;

    	 $staketoUpdate=$_POST['txtstake'];
    	  $mthtoUpdate=$_POST['month1'];
		  $YrtoUpdate=$_POST['year1'];
    	 $fulldate= $YrtoUpdate."-".$mthtoUpdate."-01";

    	 $dealtypetoUpdate=$_POST['dealtype'];


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

		//$targetOldCityID=$_POST['txtTargetCityId'];
		$targetCityName=$_POST['txtTargetCityName'];
		//$targetCityIdtoUpdate=insert_city($targetCityName);

		$regionIdtoUpdate=$_POST['txtregion'];
		//$regionIdtoUpdate=8;

		$targetCountryIdtoUpdate=$_POST['targetcountry'];
    	        $websiteToUpdate=$_POST['txtwebsite'];

	 	$acquirerIdtoUpdate=$_POST['txtAcquirerId'];
    	        $acquirertoUpdate=$_POST['txtacquirer'];

                $acquirer_listingstatusvalue=$_POST['acquirer_listingstatus'];
                if($acquirer_listingstatusvalue=="--")
    	               $acquirer_listingstatusvalue="U";
		$acquirerCityName=$_POST['txtAcquirerCityName'];
		$acquirerCountryIdtoUpdate=$_POST['acquirercountry'];
                $AcquirerGroup = $_POST['txtacquirergroup'];
                $AcquirerIndustryId = $_POST['txtacqindustry'];
              
		$NewacquirerIdtoUpdate=returnAcquirerId($acquirertoUpdate,$acquirerCityName,$acquirerCountryIdtoUpdate,$AcquirerIndustryId,$AcquirerGroup);
		if($NewacquirerIdtoUpdate==0)
			{
                        $NewacquirerIdtoUpdate=returnAcquirerId($acquirertoUpdate,$acquirerCityName,$acquirerCountryIdtoUpdate,$AcquirerIndustryId,$AcquirerGroup);
			//	echo "<br>Acquirer Id-".$AcquirerId ."-" .$acquirer;
			}

//		echo "<br>7--";

		 $AdvAcquirerIdToUpdate=$_POST['txtAdvAcqId'];
		 $AdvAcquireridarray= count($AdvAcquirerIdToUpdate);
		//	echo "<br>Inv array count- " .$AdvAcquireridarray;
    	 $AdvAcquirertoUpdate=$_POST['txtAdvAcquirer'];

    	 $commenttoUpdate=$_POST['txtcomment'];
    	 $moreInfortoUpdate = addslashes($_POST['txtmoreinfor']);

		 $validationtoUpdate=$_POST['txtvalidation'];
		 $linktoUpdate=$_POST['txtlink'];
		    if(($_POST['chkAssetFlag']))
		   		 {
		   			$assetflag=1;
		   			}
		   		else
		{ $assetflag=0;}
		if(($_POST['chkhideamountFlag']))
		 {
			$hideamountflag=1;
			}
		else
		{ $hideamountflag=0;}

		$valuation=addslashes($_POST['txtvaluation']);
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
		$company_valuation=$_POST['txtcompanyvaluation'];
                if($company_valuation=="")
                  $company_valuation=0;

                $revenue_multiple=$_POST['txtrevenuemultiple'];
                if($revenue_multiple=="")
                {
                   $revenue_multiple=0;
                }

                $ebitda_mutliple=$_POST['txtEBITDAmultiple'];
                if($ebitda_mutliple=="")
                   $ebitda_mutliple=0;

                $pat_mutliple=$_POST['txtpatmultiple'];
                if($pat_multiple=="")
                  $pat_multiple=0;
				  
				
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

		$finlink=$_POST['txtfinlink'];
		$uploadname=$_POST['txtfilepath'];
		$sourcename=$_POST['txtsource'];
		if($_POST['chkhideAgg'])
    	        { $hideAggregatetoUpdate=1;
    	        }
    	         else
    	         { $hideAggregatetoUpdate=0;
    	         }

		$existingfile=$_POST['txtfile'];

		$currentdir=getcwd();
		//echo "<br>Current Diretory=" .$currentdir;
		$curdir =  str_replace("adminvi","",$currentdir);
		//echo "<br>*****************".$curdir;
		$target = $curdir . "/uploadmamafiles/" . basename($_FILES['txtfilepath']['name']);
		$file = "uploadmamafiles/" . basename($_FILES['txtfilepath']['name']);
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

				    $file = "uploadmamafiles/" . basename($_FILES['txtfilepath']['name']);
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
                for($i = 0; $i < count($_FILES["txtfilingpath"]["name"]); $i++){

           if($_FILES['txtfilingpath']['name'][$i]!=''){ 

                $currentdir=getcwd();
                //echo "<br>Current Diretory=" .$currentdir;
                $curdir =  str_replace("adminvi","",$currentdir);
                //echo "<br>*****************".$curdir;
                $target = $curdir . "/ma_uploadfilingfiles/" . basename($_FILES['txtfilingpath']['name'][$i]);
                $file = "../ma_uploadfilingfiles/" . basename($_FILES['txtfilingpath']['name'][$i]);
                $filingfilename= basename($_FILES['txtfilingpath']['name'][$i]);
                //echo "<Br>Target Directory=" .$target;
                //echo "<bR>FILE NAME---" .$filename;
                if($filingfilename!="")
                {
                      if( move_uploaded_file($_FILES['txtfilingpath']['tmp_name'][$i], $target))
                      {

                        //echo "<Br>The file ". basename( $_FILES['txtfilepath']['name']). " has been uploaded";
                        echo "<br>File is getting uploaded . Please wait..";
                        $file = "../ma_uploadfilingfiles/" . basename($_FILES['txtfilingpath']['name'][$i]);
                        if($filingfilename!=NULL)
                        {
                            mysql_query("insert into ma_companies_filing_files (company_id,file_name) values(".$MandAIdtoUpdate." ,'".$filingfilename."')");
                        }
                      }
                      else
                      {
                         echo "<br>Sorry, there was a problem in uploading the file.";
                      }
                }
           }
       }



//echo "<br>8--";
	$UpdatecompanySql="update pecompanies set companyname='$companyNametoUpdate',industry=$industrytoUpdate,
	    	 sector_business='$sectortoUpdate',website='$websiteToUpdate',city='$targetCityName',
	    	 countryid='$targetCountryIdtoUpdate',RegionId=$regionIdtoUpdate,modefied_by='$user' where PECompanyId=$companyIdtoUpdate";

			//	echo "<br>company update Query-- " .$UpdatecompanySql;
			if($updaters=mysql_query($UpdatecompanySql))
			{
			    $modifieddate=date("Y-m-d")." ".date("H:i:s");
			    if($existingfile!="")
			    {
				$UpdateInvestmentSql="update mama set DealDate='$fulldate',Amount=$dealSizetoUpadte,Stake=$staketoUpdate,AcquirerId=$NewacquirerIdtoUpdate,MADealTypeID=$dealtypetoUpdate,
				Comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',Asset=$assetflag,ModifiedDate='$modifieddate',
				Validation='$validationtoUpdate',hideamount=$hideamountflag,Link='$linktoUpdate',Valuation='$valuation',FinLink='$finlink',
				Company_Valuation=$company_valuation,Revenue_Multiple=$revenue_multiple,
                                        EBITDA_Multiple=$ebitda_mutliple,PAT_Multiple=$pat_mutliple , price_to_book=$price_to_book, book_value_per_share=$book_value_per_share, price_per_share=$price_per_share, target_listing_status='$target_listingstatusvalue',acquirer_listing_status='$acquirer_listingstatusvalue',AggHide=$hideAggregatetoUpdate,Revenue=$revenue,EBITDA=$ebitda,PAT=$pat
				where MAMAId=$MandAIdtoUpdate";
			    }
			    else
			    {
				$UpdateInvestmentSql="update mama set DealDate='$fulldate',Amount=$dealSizetoUpadte,Stake=$staketoUpdate,AcquirerId=$NewacquirerIdtoUpdate,MADealTypeID=$dealtypetoUpdate,
				Comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',Asset=$assetflag,ModifiedDate='$modifieddate',
				Validation='$validationtoUpdate',hideamount=$hideamountflag,Link='$linktoUpdate',uploadfilename='$filename',source='$sourcename',
				Valuation='$valuation',FinLink='$finlink',
				Company_Valuation=$company_valuation,Revenue_Multiple=$revenue_multiple,
                                        EBITDA_Multiple=$ebitda_mutliple,PAT_Multiple=$pat_mutliple, price_to_book=$price_to_book, book_value_per_share=$book_value_per_share, price_per_share=$price_per_share, target_listing_status='$target_listingstatusvalue',acquirer_listing_status='$acquirer_listingstatusvalue',AggHide=$hideAggregatetoUpdate,Revenue=$revenue,EBITDA=$ebitda,PAT=$pat
                                 where MAMAId=$MandAIdtoUpdate";
			    }
					if($updatersinvestment=mysql_query($UpdateInvestmentSql))
					{

						//echo "<br>----" .$UpdateInvestmentSql;
						echo "<br><br>DEAL UPDATED";

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
											//echo "<br>---" .$inv;
											$advisorString=explode("/",$invstring);
										$inv=$advisorString[0];
										$adtype=$advisorString[1];
											$invIdtoInsert=insert_get_CIAs($inv,$adtype);
										//	echo "<br>-" .$invIdtoInsert;
											if($invIdtoInsert==0)
												$invIdtoInsert=insert_get_CIAs($inv,$adtype);
                                                                                        
											if(in_array($invIdtoInsert,$AdvCompanyIdToUpdate)==false)
											{
												$updatePEInvestorsSql="insert into mama_advisorcompanies values($MandAIdtoUpdate,$invIdtoInsert)";
												echo "<br>Insert Advisor Company query-" .$updatePEInvestorsSql;
												if($rsupdatePEInvestors = mysql_query($updatePEInvestorsSql));
												//{
												//}
											}
											$idarray[]=$invIdtoInsert;
										}
									}
								}
								if ($AdvCompanyidarray>0)
								{
                                                         		for ($i=0;$i<=$AdvCompanyidarray-1;$i++)
									{
										$delId=$AdvCompanyIdToUpdate[$i];
                                                                   		if(in_array($delId,$idarray)==false)
										{
											$updatePEInv_InvestorSql="delete from mama_advisorcompanies where MAMAId=$MandAIdtoUpdate and CIAId=$delId";
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
									foreach($newacquirerString as $acquirerInvString)
									{
										if(trim($acquirerInvString)!="")
										{
                                                                                  $acquirerString=explode("/",$acquirerInvString);
										$newacquirer=$acquirerString[0];
										$adatype=$acquirerString[1];

											//echo "<br>&&&".$newacquirer;
											$acqIdtoInsert=insert_get_CIAs($newacquirer,$adatype);
											//echo "<br>-" .$acqIdtoInsert;
											if($acqIdtoInsert==0)
												$acqIdtoInsert=insert_get_CIAs($newacquirer,$adatype);
											if(in_array($acqIdtoInsert,$AdvAcquirerIdToUpdate)==false)
											{
												$updateMAMAAcquirerSql="insert into mama_advisoracquirer values($MandAIdtoUpdate,$acqIdtoInsert)";
												echo "<br>Insert Advisor Company query-" .$updateMAMAAcquirerSql;
												if($rsupdateAcqInvestors = mysql_query($updateMAMAAcquirerSql));
												//{
												//}
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
											$updateMAMA_AcquirerSql="delete from mama_advisoracquirer where MAMAId=$MandAIdtoUpdate and CIAId=$delId";
											echo "<br>Delete Advisor Acquirer-" .$updateMAMA_AcquirerSql;
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
	$getInvestorIdSql = "select CIAId,AdvisorType from advisor_cias where cianame like '$cianame%'";
	//echo "<br>select--" .$advtype;
	if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
	{
		$investor_cnt=mysql_num_rows($rsgetInvestorId);
	//	echo "<br>Advisor cia table count-- " .$investor_cnt;
		if ($investor_cnt==0)
		{
				//insert acquirer
				$insAcquirerSql="insert into advisor_cias(cianame,AdvisorType) values('$cianame','$advtype')";
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
				//echo "<br>Id - ".$AdInvestorId ." - " .$adtypestr;
				if($adtypestr!=$advtype)
				{
			//	echo "<br>Insert return investor id--" .$invId;
			             $updateAdTypeSql="Update advisor_cias set AdvisorType='$advtype' where CIAId=$AdInvestorId";
                                    //echo "<Br>Update ^^^".$updateAdTypeSql;
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

function insert_city($cityname)
{
	$dbcity = new dbInvestments();
	$getCitySql="select CityId from city where city like '$cityname'";
	if($rscity=mysql_query($getCitySql))
	{
		$city_cnt=mysql_num_rows($rscity);
		//echo "<br>Count---" .$city_cnt;
		if($city_cnt==0)
		{
			//insert city
			$idcity=rand();
			$insCitySql="insert into city(CityId,City) values($idcity,'$cityname')";
			if($rsinsCity=mysql_query($insCitySql))
			{
				$cityId=$idcity;
				return $cityId;
			}
		}
		elseif($city_cnt>=1)
		{
			While($myrow=mysql_fetch_array($rscity, MYSQL_BOTH))
			{
				$cityId = $myrow[0];
			//	echo "<br>Insert return industry id--" .$companyId;
				return $cityId;
			}
		}
	//	echo "<br>Return CityId----" .$cityId;

	}

	$dbcity.close();
}


function returnAcquirerId($acquirername,$cityid,$countryid,$industryid,$group)
{
	//echo "<br>***********************";

	$acquirername=trim($acquirername);
	//echo "<br>Acquirer- " .$acquirername;
	$dbaclinkss = new dbInvestments();
	//$getAcquirerSql="select AcquirerId from acquirers where Acquirer like '$acquirername'";
        $getAcquirerSql="select * from acquirers where Acquirer like '$acquirername' and CityId like '$cityid' and countryid like '$countryid'";
	if($rsgetAcquirer=mysql_query($getAcquirerSql))
	{
		$acquirer_cnt=mysql_num_rows($rsgetAcquirer);
		//echo "<br>-- ".$acquirer_cnt;
		if($acquirer_cnt==0)
		{
			//insert acquirer
                $insAcquirerSql="insert into acquirers(Acquirer,CityId,countryid,IndustryId,Acqgroup) values('$acquirername','$cityid','$countryid','$industryid','$group')";
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
                    $updateSql = "Update acquirers set Acquirer='$acquirername',CityId='$cityid',countryid='$countryid',IndustryId='$industryid', Acqgroup='$group' where AcquirerId=$acquirerId";
				//echo "<Br>---" .$updateSql;
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