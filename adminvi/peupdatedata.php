<?php include_once("../../globalconfig.php"); ?>
<?php
 session_save_path("/tmp");
	session_start();
	if (session_is_registered("SessLoggedAdminPwd") && session_is_registered("SessLoggedIpAdd"))
	{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=windows-1252">
<meta name="GENERATOR" content="Microsoft FrontPage 5.0">
<meta name="ProgId" content="FrontPage.Editor.Document">
<title>Update Investment data : : Contact TSJ Media : :</title>

<SCRIPT LANGUAGE="JavaScript">

</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<form name="peupdatedata" method=post action="peupdatedata.php">

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">Investement deal list</font> </b></center></p>
<p></p><p></p>
<table width=60% align=center border=1 cellpadding=2>

<?php
    require("../dbconnectvi.php");
	$Db = new dbInvestments();

		$hideamouttoUpdate=0;

         $PEIdtoUpdate = $_POST['txtPEId'];
         $pe_re_update=$_POST['txtpe_re'];

         $industryIdtoUpdate =$_POST['txtindustryId'];
    	 $companyIdtoUpdate = $_POST['txtcompanyid'];
    	//echo "<Br>--CompanyIdtoUpdate- ".$companyIdtoUpdate;
    	 $companyNametoUpdate =  $_POST['txtname'];
    	 $listing_statusvalue=$_POST['listingstatus'];
         $exit_statusvalue=$_POST['exitstatus'];
         
    	 $industrytoUpdate=$_POST['industry'];
    	 $sectortoUpdate=$_POST['txtsector'];
    	 $amounttoUpdate=$_POST['txtamount'];
    	// $hideamouttoUpdate=$_POST['chkhideamount'];

    	 if(($_POST['chkhideamount']))
    	 {
    	 	$hideamouttoUpdate=1;
	    	}
	    else
	    { $hideamouttoUpdate=0;}
    	// if($hideamouttoUpdate<=0)
    	 //	$hideamouttoUpdate=0;
    	// echo "<Br>Hide amount- ".$hideamouttoUpdate;

        $roundtoUpdate=$_POST['txtround'];
    	 $stagetoUpdate=$_POST['stage'];
    	// echo "<Br>Stage Id--" .$stagetoUpdate;

    	 $investorsidtoUpdate=$_POST['txtinvestorid'];
    	 $investoridarray= count($investorsidtoUpdate);
		//	echo "<br>Inv array count- " .$investoridarray;
    	 $investorstoUpdate=$_POST['txtinvestors'];
    //	 	echo "<br>Investors to Update--" .$investorstoUpdate;
    	 $invTypeId=$_POST['invType'];

    	 $staketoUpdate=$_POST['txtstake'];
    	 if(trim($staketoUpdate)<=0)
    	 {
    	 	$staketoUpdate=0.0;
    	 }
    	 //$hidstaketoUpdate=$_POST['chkhidestake'];
    	 if($_POST['chkhidestake'])
    	 { $hidstaketoUpdate=1;
    	 }
    	 else
    	 { $hidstaketoUpdate=0;
    	 }
    	 if($_POST['chkhideAgg'])
    	 { $hideAggregatetoUpdate=1;
    	 }
    	 else
    	 { $hideAggregatetoUpdate=0;
    	 }

       	 //$datestoUpdate=$_POST['txtperiod'];
    	 $mthtoUpdate=$_POST['month1'];
    	 $YrtoUpdate=$_POST['year1'];
    	 $fulldate= $YrtoUpdate."-".$mthtoUpdate."-01";
    	 $urltoUpdate=$_POST['txtwebsite'];
    	 $citytoUpdate=$_POST['txtcity'];
    	 $RegionIdtoUpdate=$_POST['txtregion'];
    	 $countryidtoUpdate=$_POST['txtcountry'];


		 $spvtoUpdate=0;
		/* if($pe_re_update=="RE")
		 {
			if(($_POST['chkspv']))
				$spvtoUpdate=1;
	       }*/

    	 $advisorCompanyIdtoUpdate=$_POST['txtAdvcompId'];
    	 $advisorCompanyArray= count($advisorCompanyIdtoUpdate);
    	// 	echo "<br>Advisor company array count- " .$advisorCompanyArray;
	 $advisorCompanytoUpdate= $_POST['txtAdvCompany'];
		//	echo "<br>Advisor company text array count- " .count($advisorCompanytoUpdate);

    	 $advisorInvestorIdtoUpdate=$_POST['txtAdvInvId'];
	 $advisorInvestorArray= count($advisorInvestorIdtoUpdate);
		//    echo "<br>Advisor Investors array count- " .$advisorInvestorArray;

	 $advisorInvestortoUpdate= $_POST['txtAdvInvestor'];

    	 $commenttoUpdate=$_POST['txtcomment'];
    	 $moreInfortoUpdate=$_POST['txtmoreinfor'];
		 $validationtoUpdate=$_POST['txtvalidation'];
		 $linktoUpdate=$_POST['txtlink'];

		// $RegionIdtoUpdate=return_insert_get_RegionId($regiontoUpdate);
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
				  
			    
				// New feature 08-08-2016 start
							
					$price_to_book=$_POST['txtpricetobook'];
					if($price_to_book=="")
					   $price_to_book=0;
					   
					   
					
					$book_value_per_share=$_POST['txtbookvaluepershare'];
					if($book_value_per_share=="")
					   $book_value_per_share=0;
					   
					   
					
					$price_per_share=$_POST['txtpricepershare'];
					if($price_per_share=="")
					   $price_per_share=0;
					   
				
				// New feature 08-08-2016 end
                
                $txtrevenue=$_POST['txtrevenue'];
                if($txtrevenue=="")
                   $txtrevenue=0;

                $txtEBITDA=$_POST['txtEBITDA'];
                if($txtEBITDA=="")
                   $txtEBITDA=0;

                $txtpat=$_POST['txtpat'];
                if($txtpat=="")
                  $txtpat=0;
                

		$finlink=$_POST['txtfinlink'];

		 $uploadname=$_POST['txtfilepath'];
			$sourcename=$_POST['txtsource'];
			$existingfile=$_POST['txtfile'];
       // echo "<Br>^^^^^^^^^^^";
       
       
       $dbtypedeal=$_POST['dbtype'];
        $showpevcdeal=$_POST['showaspevc'];
        foreach($dbtypedeal as $dbtype)
        {
       	 $dbtype1=str_replace(' ','',$dbtype);
          $dbtypearray[]=$dbtype1;
          //echo "<Br>*".$dbtype1;
        }
        //echo "<Br>^^^ ".$showpevcdeal;
       	foreach($showpevcdeal as $showpevc)
        {
           $showaspevcarray[]=$showpevc;
         //echo "<br>*** ".$showpevc;
         //echo "<br>****----" .$showpevc;
         //	$stagevalue= $stagevalue. " pe.StageId=" .$stage." or ";
         //	$stageidvalue=$stageidvalue.",".$stage;
       }
       //$spvdebtvalue=$_POST['chkSPVdebt'];
        if($_POST['chkSPVdebt'])
      	 { $spvdebt=1;
      	 }
      	 else
      	 { $spvdebt=0;
      	 }

       $dbtypesql = "select DBTypeId from peinvestments_dbtypes where PEId=$PEIdtoUpdate";

       if ($debtypers = mysql_query($dbtypesql))
       {
          $db_cnt = mysql_num_rows($debtypers);
       }

      if($db_cnt>0)
       {
		While($mydbrow=mysql_fetch_array($debtypers, MYSQL_BOTH))
		{
                  $databasearray[]=$mydbrow["DBTypeId"];
                }
        }


      	for ( $i =0; $i < count($dbtypearray); $i +=1)
         {
          //echo "<br><br>db-".$dbtypearray[$i] ."sh-" .$showaspevcarray[$i]."tb-" .$databasearray[$i];
          //echo "<BR>-".$databasearray[$i];

                if(in_array($dbtypearray[$i],$showaspevcarray))

                 {  $hidevalue=1;     }
                 else
                  {   $hidevalue=0;   }
                 // echo "<Br>H-" .$hidevalue;

              if(in_array($dbtypearray[$i],$databasearray)==true)
               {  // echo "<Br>1 " .$databasearray[$i];
                 $insertTypesql="update  peinvestments_dbtypes set hide_pevc_flag=$hidevalue  where PEId=$PEIdtoUpdate and DBTypeId='$dbtypearray[$i]'";
               }
                else
                 {  
                   //echo "<br>0 " .$databasearray[$i];
                  $insertTypesql="insert into peinvestments_dbtypes values($PEIdtoUpdate,'$dbtypearray[$i]',$hidevalue)";
                 }
                //  echo "<br>***".$insertTypesql;
                 if($rsupdateType = mysql_query($insertTypesql))
                 {    }

           }
           //for an already existing db, if its not in the TO BE updated array, it has to be deleted
            for ( $j =0; $j < count($databasearray); $j +=1)
             {
                   if(in_array($databasearray[$j],$dbtypearray)==false)
                   {
                     $DelTypesql="delete from peinvestments_dbtypes where PEId=$PEIdtoUpdate and DBTypeId='$databasearray[$j]'";
                     if($rsDelUpdate = mysql_query($DelTypesql))
                      { echo "<br> Deleting the " .$databasearray[$j] ." from the database";
                      }
                   }
             }


      			$currentdir=getcwd();
			//echo "<br>Current Diretory=" .$currentdir;
			$curdir =  str_replace("adminvi","",$currentdir);
			//echo "<br>*****************".$curdir;
			$target = $curdir . "/uploadmamafiles/" . basename($_FILES['txtfilepath']['name']);
			$file = "uploadmamafiles/" . basename($_FILES['txtfilepath']['name']);
			$filename= basename($_FILES['txtfilepath']['name']);
			//echo "<Br>Target Directory=" .$target;
	//	echo "<Br>File " .$existingfile;
		if($filename!="")
		{
			if (!(file_exists($file)))
			{
				if( move_uploaded_file($_FILES['txtfilepath']['tmp_name'], $target))
				{
					echo "<br>File is getting uploaded . Please wait..";
					echo "<Br><br>The file ". basename( $_FILES['txtfilepath']['name']). " has been uploaded";

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


    	 $UpdatecompanySql="update pecompanies set companyname='$companyNametoUpdate',industry='$industrytoUpdate',
    	 sector_business='$sectortoUpdate',website='$urltoUpdate',city='$citytoUpdate',
    	 RegionId='$RegionIdtoUpdate',countryid='$countryidtoUpdate' where PECompanyId=$companyIdtoUpdate";

			//echo "<br>company update Query-- " .$UpdatecompanySql;
			if($updaters=mysql_query($UpdatecompanySql))
			{
			//	echo "<br>*****************";
				if($existingfile!="")
				{
					$UpdateInvestmentSql="update peinvestments set dates='$fulldate',amount=$amounttoUpdate,
					round='$roundtoUpdate',StageId=$stagetoUpdate, stakepercentage=$staketoUpdate,
					comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',
					Validation='$validationtoUpdate',InvestorType='$invTypeId',hideamount=$hideamouttoUpdate,
					hidestake=$hidstaketoUpdate,Link='$linktoUpdate',SPV=$spvdebt,Valuation='$valuation',FinLink='$finlink',
					AggHide=$hideAggregatetoUpdate,
					Company_Valuation=$company_valuation,Revenue_Multiple=$revenue_multiple,
                                        EBITDA_Multiple=$ebitda_mutliple,PAT_Multiple=$pat_mutliple,price_to_book=$price_to_book,book_value_per_share=$book_value_per_share,price_per_share=$price_per_share,listing_status='$listing_statusvalue',Exit_Status='$exit_statusvalue',Revenue='$txtrevenue',EBITDA='$txtEBITDA',PAT='$txtpat'
                                         where PEId=$PEIdtoUpdate";
				   // echo "<br>Existing file--**-- " .$UpdateInvestmentSql;
				}
				else
				{
					$UpdateInvestmentSql="update peinvestments set dates='$fulldate',amount=$amounttoUpdate,
					round='$roundtoUpdate',StageId=$stagetoUpdate, stakepercentage=$staketoUpdate,
					comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',
					Validation='$validationtoUpdate',InvestorType='$invTypeId',hideamount=$hideamouttoUpdate,
					hidestake=$hidstaketoUpdate,Link='$linktoUpdate',SPV=$spvdebt,uploadfilename='$filename',source='$sourcename',
					Valuation='$valuation',FinLink='$finlink',AggHide=$hideAggregatetoUpdate,
					Company_Valuation=$company_valuation,Revenue_Multiple=$revenue_multiple,
                                        EBITDA_Multiple=$ebitda_mutliple,PAT_Multiple=$pat_mutliple,price_to_book=$price_to_book,book_value_per_share=$book_value_per_share,price_per_share=$price_per_share,listing_status='$listing_statusvalue',Exit_Status='$exit_statusvalue',Revenue='$txtrevenue',EBITDA='$txtEBITDA',PAT='$txtpat'
					where PEId=$PEIdtoUpdate";
					//echo "<br>NO Existing file--**-- " .$UpdateInvestmentSql;
				}


				if($updatersinvestment=mysql_query($UpdateInvestmentSql))
					{
						echo "<br>DEAL UPDATED";
						$idarray = array();
						$advcomparray=array();
						$advinvarray=array();
							If(trim($investorstoUpdate!=""))
							{
								$newinvestor=explode(",",$investorstoUpdate);
								//echo " <br>1---";
								foreach($newinvestor as $inv)
								{
									//echo "<br>2--------";
									if(trim($inv)!="")
									{
										//echo "<br>3 *--";
										$invIdtoInsert=return_insert_get_Investor($inv);
										//echo "<br>4----" .$invIdtoInsert;
										if($invIdtoInsert==0)
											$invIdtoInsert=return_insert_get_Investor($inv);
										if(in_array($invIdtoInsert,$investorsidtoUpdate)==false)
										{

											$updatePEInvestorsSql="insert into peinvestments_investors values($PEIdtoUpdate,$invIdtoInsert)";
											if($rsupdatePEInvestors = mysql_query($updatePEInvestorsSql))
											{
												echo "<br>Inserted Investor -" .$updatePEInvestorsSql;
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
										$updatePEInv_InvestorSql="delete from peinvestments_investors where PEId=$PEIdtoUpdate and InvestorId=$delId";
										echo "<br>Delete Investor Query-" .$updatePEInv_InvestorSql;
										if($rsupdatePEInv_Investors = mysql_query($updatePEInv_InvestorSql))
										{
										}
									}
								}
							}
//advisor_companies
					If(trim($advisorCompanytoUpdate!=""))
					{
						$newinvestor=explode(",",$advisorCompanytoUpdate);
						foreach($newinvestor as $newadcomStr)
						{
							//echo "<br>--".$newadcom;
							if(trim($newadcomStr)!="")
							{       
                                                          //echo "<br>***".$newadcomStr;
                                                                $companyString=explode("/",$newadcomStr);
                                                                $newadcom=$companyString[0];
                                                                $adTypeStr=$companyString[1];
								$adCompIdtoInsert=insert_get_CIAs($newadcom,$adTypeStr);
								//echo "<br>---" .$adCompIdtoInsert;
								if($adCompIdtoInsert==0)
								{	$adCompIdtoInsert=insert_get_CIAs($newadcom,$adTypeStr);
								}
								if(in_array($adCompIdtoInsert,$advisorCompanyIdtoUpdate)==false)
								{
									$updatePEInvestorsSql="insert into peinvestments_advisorcompanies values($PEIdtoUpdate,$adCompIdtoInsert)";
									echo "<br>Isnert Adv Company query-" .$updatePEInvestorsSql;
									if($rsupdatePEInvestors = mysql_query($updatePEInvestorsSql))
									{
									}
								}
								$advcomparray[]=$adCompIdtoInsert;
							}
						}
					}
					if($advisorCompanyArray >0 )
					{
						for ($i=0;$i<=$advisorCompanyArray-1;$i++)
						{
							$delCompId=$advisorCompanyIdtoUpdate[$i];
							if(in_array($delCompId,$advcomparray)==false)
							{
								$updatePEInv_InvestorSql="delete from peinvestments_advisorcompanies where PEId=$PEIdtoUpdate and CIAId=$delCompId";
								echo "<br>Delete Adv Company Query-" .$updatePEInv_InvestorSql;
								if($rsupdatePEInv_Investors = mysql_query($updatePEInv_InvestorSql))
								{
								}
							}
				  		}
					}

//advisor_investors
				  			If(trim($advisorInvestortoUpdate!=""))
							{
								$newinvestor=explode(",",$advisorInvestortoUpdate);
								foreach($newinvestor as $newadinvStr)
								{
									if(trim($newadinvStr)!="")
									{
										$advisorString=explode("/",$newadinvStr);
										$newadinv=$advisorString[0];
										$adtype=$advisorString[1];
                                                                                $adInvIdtoInsert=insert_get_CIAs($newadinv,$adtype);
										if($adInvIdtoInsert==0)
										{	$adInvIdtoInsert=insert_get_CIAs($newadinv,$adtype);
										}
										if(in_array($adInvIdtoInsert,$advisorInvestorIdtoUpdate)==false)
										{
											$updatePEInvestorsSql="insert into peinvestments_advisorinvestors values($PEIdtoUpdate,$adInvIdtoInsert)";
											echo "<br>Insert Adv Investor query-" .$updatePEInvestorsSql;
											if($rsupdatePEInvestors = mysql_query($updatePEInvestorsSql))
											{

											}
										}
										$advinvarray[]=$adInvIdtoInsert;
									}
								}
							}
							//echo "<Br>---" .count($advinvarray);
							if($advisorInvestorArray >0 )
							{
								for ($k=0;$k<=$advisorInvestorArray-1;$k++)
								{
									//echo "<Br>2 To delete advisor investor- " .$advisorInvestorIdtoUpdate[$k];
									$delInvId=$advisorInvestorIdtoUpdate[$k];
									//echo "<Br>3--".trim($delInvId);
									//echo "<Br>4--".$advinvarray[$k];
									if(in_array(trim($delInvId),$advinvarray)==false)
									{
										//echo "<Br>3333------";
										$updatePEInv_InvestorSql="delete from peinvestments_advisorinvestors where PEId=$PEIdtoUpdate and
										CIAId=$delInvId";
										if($rsupdatePEInv_Investors = mysql_query($updatePEInv_InvestorSql))
										{
											echo "<br><br>Delete Adv Investor Query-" .$updatePEInv_InvestorSql;
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

} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>
</form>
</body></html>
<?php
/* function to insert the advisor_cias table */
function insert_get_CIAs($cianame,$adType)
{
	$cianame=trim($cianame);
	$dbcialink = new dbInvestments();
	$getInvestorIdSql = "select CIAId,AdvisorType from advisor_cias where cianame like '$cianame%'";
	echo "<br>select--" .$getInvestorIdSql;
	if ($rsgetInvestorId=mysql_query($getInvestorIdSql))
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
					return $AdInvestorId;
				}
		}
		elseif($investor_cnt>=1)
		{
                  	While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
			{
				$AdInvestorId = $myrow[0];
				//echo "<bR>&&&&".$AdInvestorId;
				$adtypestr=$myrow[1];
				echo "<br>Id - ".$AdInvestorId ." - " .$adtypestr;
				if($adtypestr!=$adType)
				{
    				    $updateAdTypeSql="Update advisor_cias set AdvisorType='$adType' where CIAId=$AdInvestorId";
    				    //echo "<Br>^^^".$updatAdTypeSql;
    				    if($rsupdate=mysql_query($updateAdTypeSql))
    				    {
                                    }
                                }
				return $AdInvestorId;
			}
		}
	}
	$dbcialink.close();
}


//function to get RegionId
	function return_insert_get_RegionId($region)
	{
		$dbregionlink = new dbInvestments();
		$getRegionIdSql = "select RegionId from region where region like '$region%'";
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
					//echo "<br>Return investor id--" .$invId;
					return $InvestorId;
				}
			}
		}
		$dblink.close();
	}
?>