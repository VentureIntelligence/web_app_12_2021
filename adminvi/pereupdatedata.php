<?php include_once("../globalconfig.php"); ?>
<?php
 require("../dbconnectvi.php");
	$Db = new dbInvestments();
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
<form name="peupdatedata" method=post action="pereupdatedata.php">

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">Investment deal list</font> </b></center></p>
<p></p><p></p>
<table width=60% align=center border=1 cellpadding=2>

<?php
   

		$hideamouttoUpdate=0;
$exitstatusvalue = $_POST['exitstatus'];

         $PEIdtoUpdate = $_POST['txtPEId'];
         $pe_re_update=$_POST['txtpe_re'];
		$CompanyIndustryId=15;
         $industryIdtoUpdate =$_POST['industry'];
         $listing_statusvalue=$_POST['listingstatus'];
         //echo "<br>***" .$industryIdtoUpdate;
    	 $companyIdtoUpdate = $_POST['txtcompanyid'];
    	//echo "<Br>--CompanyIdtoUpdate- ".$companyIdtoUpdate;
    	 $companyNametoUpdate =  $_POST['txtname'];
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
    	// 	echo "<br>Investors to Update--" .$investorstoUpdate;
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
    	 //if($hidstaketoUpdate<=0)
    	 //	$hidstaketoUpdate=0;
    	 //echo "<Br>-Hide stake-" .$hidstaketoUpdate;


    	 //$datestoUpdate=$_POST['txtperiod'];
    	 $mthtoUpdate=$_POST['month1'];
    	 $YrtoUpdate=$_POST['year1'];
    	 $fulldate= $YrtoUpdate."-".$mthtoUpdate."-01";
    	 $urltoUpdate=$_POST['txtwebsite'];
         
    	 if($_POST['citysearch']!=''){
             
             $citytoUpdate=  ucfirst($_POST['citysearch']);
         }else{
            $citytoUpdate=  ucfirst($_POST['txtcity']);
         }
         
    	 $regiontoUpdate=$_POST['txtregion'];


		 $spvtoUpdate=0;
		 if($pe_re_update=="RE")
		 {
			if(($_POST['chkspv']))
				$spvtoUpdate=1;
	     }
	     $projectname=$_POST['txtprojectname'];

		$valuation=trim($_POST['txtvaluation']);
		$finlink=$POST['txtfinlink'];
		if($_POST['chkhideAgg'])
        	 { $hideAggregatetoUpdate=1;
        	 }
        	 else
        	 { $hideAggregatetoUpdate=0;
        	 }
	        $uploadname=$_POST['txtfilepath'];
		$sourcename=$_POST['txtsource'];
		$existingfile=$_POST['txtfile'];
                $Projectuploadname=$_POST['txtprojectfilepath'];
		$Projectexistingfile=$_POST['txtprojectfile'];

		$currentdir=getcwd();
		//echo "<br>Current Diretory=" .$currentdir;
		$curdir =  str_replace("adminvi","",$currentdir);
		//echo "<br>*****************".$curdir;
		$target = $curdir . "/uploadrefiles/" . basename($_FILES['txtfilepath']['name']);
		$file = "uploadrefiles/" . basename($_FILES['txtfilepath']['name']);
		$filename= basename($_FILES['txtfilepath']['name']);
	       // echo "<Br>Target file=" .$filename;


                if($filename!="")
                {

             	if (!(file_exists($file)))
		{
			if( move_uploaded_file($_FILES['txtfilepath']['tmp_name'], $target))
			{
				echo "<br>File is getting uploaded . Please wait..";
				echo "<br>The file ". basename( $_FILES['txtfilepath']['name']). " has been uploaded";

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

                $target1 = $curdir . "/uploadrefiles/" . basename($_FILES['txtprojectfilepath']['name']);
		$file1 = "uploadrefiles/" . basename($_FILES['txtprojectfilepath']['name']);
		$filename1= basename($_FILES['txtprojectfilepath']['name']);
		//echo "<Br>~~~~".$file1;
                //echo "<Br>----" .$filename1;

              if($filename1!="")
               {
                // echo "<br>1.." ;
              	if (!(file_exists($file1)))
		{
                 // echo "<br>2.." ;
               if( move_uploaded_file($_FILES['txtprojectfilepath']['tmp_name'], $target1))
    		      {
                    //  echo "<BR>3..";

                   //echo "<Br>The file ". basename( $_FILES['txtprojectfilepath']['name']). " has been uploaded";
                    echo "<br>Project File is getting uploaded . Please wait..";
		    $file = "uploadrefiles/" . basename($_FILES['txtprojectfilepath']['name']);
		    //echo "<br>----------------" .$file1;
		    }
		    else
		    {
		        echo "<br>Sorry, there was a problem in uploading the Project Details file.";
	         	}
		  }
                 else
                      echo "<br>Project Detail FILE ALREADY EXISTS IN THE SAME NAME";
               }

    	 $advisorCompanyIdtoUpdate=$_POST['txtAdvcompId'];
    	 $advisorCompanyArray= count($advisorCompanyIdtoUpdate);
    	// 	echo "<br>Advisor company array count- " .$advisorCompanyArray;
		 $advisorCompanytoUpdate= $_POST['txtAdvCompany'];
		//	echo "<br>Advisor company text array count- " .count($advisorCompanytoUpdate);

    	 $advisorInvestorIdtoUpdate=$_POST['txtAdvInvId'];
		 $advisorInvestorArray= count($advisorInvestorIdtoUpdate);
		//    echo "<br>Advisor Investors array count- " .$advisorInvestorArray;

		 $advisorInvestortoUpdate= $_POST['txtAdvInvestor'];
		// echo "<Br>Investor String---------- ".$advisorInvestortoUpdate;

    	 $commenttoUpdate=$_POST['txtcomment'];
    	 $moreInfortoUpdate=$_POST['txtmoreinfor'];
		 $validationtoUpdate=$_POST['txtvalidation'];

		 $linktoUpdate=$_POST['txtlink'];
    	 $UpdatecompanySql="update REcompanies set companyname='$companyNametoUpdate',industry=$CompanyIndustryId,website='$urltoUpdate',city='$citytoUpdate',AdCity='$citytoUpdate'
    	 where PECompanyId=$companyIdtoUpdate";
			//	echo "<br>company update Query-- " .$UpdatecompanySql;
			if($updaters=mysql_query($UpdatecompanySql))
			{
				//echo "<br>*****************" .$existingfile;
				if($existingfile!="")
				{
					$UpdateInvestmentSql="update REinvestments set dates='$fulldate',amount=$amounttoUpdate,
					round='$roundtoUpdate',StageId=$stagetoUpdate, stakepercentage=$staketoUpdate,
					comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',
					Validation='$validationtoUpdate',InvestorType='$invTypeId',hideamount=$hideamouttoUpdate,
					hidestake=$hidstaketoUpdate,SPV=$spvtoUpdate,city='$citytoUpdate',RegionId='$regiontoUpdate',sector='$sectortoUpdate',
					IndustryId=$industryIdtoUpdate,Link='$linktoUpdate',Valuation='$valuation',FinLink='$finlink',
                                        AggHide=$hideAggregatetoUpdate,ProjectName='$projectname',
					listing_status='$listing_statusvalue', Exit_Status='$exitstatusvalue'
					where PEId=$PEIdtoUpdate";

				}
				elseif($existingfile=="")
				{
					$UpdateInvestmentSql="update REinvestments set dates='$fulldate',amount=$amounttoUpdate,
					round='$roundtoUpdate',StageId=$stagetoUpdate, stakepercentage=$staketoUpdate,
					comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',
					Validation='$validationtoUpdate',InvestorType='$invTypeId',hideamount=$hideamouttoUpdate,
					hidestake=$hidstaketoUpdate,SPV=$spvtoUpdate,city='$citytoUpdate',RegionId='$regiontoUpdate',sector='$sectortoUpdate',
					IndustryId=$industryIdtoUpdate,Link='$linktoUpdate',uploadfilename='$filename',source='$sourcename',
					Valuation='$valuation',FinLink='$finlink',
                                        AggHide=$hideAggregatetoUpdate,ProjectName='$projectname',listing_status='$listing_statusvalue', Exit_Status='$exitstatusvalue'
					where PEId=$PEIdtoUpdate";
				}
			/*	if($Projectexistingfile!="")
				{    //leaving the query blank will break .so checking for equal to empty that filename in the following
                                } */
                                if($Projectexistingfile=="")
                                {
                                  $UpdateInvestmentSql1="update REinvestments set ProjectDetailsFileName ='$filename1'
				where PEId=$PEIdtoUpdate";
				}
                                //    echo "<br>---- ".$UpdateInvestmentSql1;
                                if($updatersinvestment1=mysql_query($UpdateInvestmentSql1))
					{
						//echo "<br>DEAL updated";
					}

				if($updatersinvestment=mysql_query($UpdateInvestmentSql))
					{
						//echo "<br>DEAL UPDATED";
				   //	echo "<br>Query--**-- " .$UpdateInvestmentSql;
						$idarray = array();
						$advcomparray=array();
						$advinvarray=array();
							If(trim($investorstoUpdate!=""))
							{
								$newinvestor=explode(",",$investorstoUpdate);

								foreach($newinvestor as $inv)
								{
									if(trim($inv)!="")
									{
										//echo "<br>--**--";
										$invIdtoInsert=return_insert_get_Investor($inv);
										//echo "<br>-" .$invIdtoInsert;
										if($invIdtoInsert==0)
											$invIdtoInsert=return_insert_get_Investor($inv);
										if(in_array($invIdtoInsert,$investorsidtoUpdate)==false)
										{
											$updatePEInvestorsSql="insert into REinvestments_investors values($PEIdtoUpdate,$invIdtoInsert)";
											if($rsupdatePEInvestors = mysql_query($updatePEInvestorsSql))
											{
												//echo "<br>Insert Investor query-" .$updatePEInvestorsSql;
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
										$updatePEInv_InvestorSql="delete from REinvestments_investors where PEId=$PEIdtoUpdate and InvestorId=$delId";
										if($rsupdatePEInv_Investors = mysql_query($updatePEInv_InvestorSql))
										{
											//echo "<br>Delete Investor Query-" .$updatePEInv_InvestorSql;
										}
									}
								}
							}
//advisor_companies
					If(trim($advisorCompanytoUpdate!=""))
					{
						$newinvestor=explode(",",$advisorCompanytoUpdate);
						foreach($newinvestor as $newadcomString)
						{
							//echo "<br>--".$newadcom;
							if(trim($newadcomString)!="")
							{
                                                          
                                                                $advcompanyString=explode("/",$newadcomString);
                                                                $newadcom=$advcompanyString[0];
                                                                $adTypeStr=$advcompanyString[1];

								$adCompIdtoInsert=insert_get_CIAs($newadcom,$adTypeStr);
								//echo "<br>---" .$adCompIdtoInsert;
								if($adCompIdtoInsert==0)
								{	$adCompIdtoInsert=insert_get_CIAs($newadcom,$adTypeStr);
								}
								if(in_array($adCompIdtoInsert,$advisorCompanyIdtoUpdate)==false)
								{
									$updatePEInvestorsSql="insert into REinvestments_advisorcompanies values($PEIdtoUpdate,$adCompIdtoInsert)";
									//echo "<br>Insert Adv Company query-" .$updatePEInvestorsSql;
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
								$updatePEInv_InvestorSql="delete from REinvestments_advisorcompanies where PEId=$PEIdtoUpdate and CIAId=$delCompId";
								//echo "<br>Delete Adv Company Query-" .$updatePEInv_InvestorSql;
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
								foreach($newinvestor as $newadinvString)
								{
									if(trim($newadinvString)!="")
									{
                                                                          $advinvestorString=explode("/",$newadinvString);
                                                                          $newadinv=$advinvestorString[0];
                                                                          $adTypeStr=$advinvestorString[1];
										$adInvIdtoInsert=insert_get_CIAs($newadinv,$adTypeStr);
										if($adInvIdtoInsert==0)
										{	$adInvIdtoInsert=insert_get_CIAs($newadinv,$adTypeStr);
										}
										if(in_array($adInvIdtoInsert,$advisorInvestorIdtoUpdate)==false)
										{
											$updatePEInvestorsSql="insert into REinvestments_advisorinvestors values($PEIdtoUpdate,$adInvIdtoInsert)";
											//echo "<br>Insert Adv Investor query-" .$updatePEInvestorsSql;
											if($rsupdatePEInvestors = mysql_query($updatePEInvestorsSql))
											{
											}
										}
										//echo "<br>Advisor Id that has been added-".$adInvIdtoInsert;
										$advinvarray[]=$adInvIdtoInsert;
									}
								}
							}
							if($advisorInvestorArray >0 )
							{
								for ($k=0;$k<=$advisorInvestorArray-1;$k++)
								{
									$delInvId=trim($advisorInvestorIdtoUpdate[$k]);
									//echo "<br>DelInvID Variable -".$delInvId;
									if(in_array(trim($delInvId),$advinvarray)==false)
									{
										$updatePEInv_InvestorSql="delete from REinvestments_advisorinvestors where PEId=$PEIdtoUpdate and
										CIAId=$delInvId";
										//echo "<br><br>Delete Adv Investor Query-" .$updatePEInv_InvestorSql;
										if($rsupdatePEInv_Investors = mysql_query($updatePEInv_InvestorSql))
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

} // if resgistered loop ends
else
	header( 'Location: '. GLOBAL_BASE_URL .'admin.php' ) ;
?>
</form>
</body></html>
<?php
/* function to insert the advisor_cias table */
function insert_get_CIAs($cianame,$adtype)
{
	$cianame=trim($cianame);
	$dbcialink = new dbInvestments();
	$getInvestorIdSql = "select CIAId from advisor_cias where cianame like '$cianame'";
	//echo "<br>select--" .$getInvestorIdSql;
	if ($rsgetInvestorId=mysql_query($getInvestorIdSql))
	{

		$investor_cnt=mysql_num_rows($rsgetInvestorId);
		//echo "<br>Advisor cia table count-- " .$investor_cnt;
		if ($investor_cnt==0)
		{
				//insert acquirer
				$insAcquirerSql="insert into advisor_cias(cianame,AdvisorType) values('$cianame','$adtype')";
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
			//	echo "<br>Insert return investor id--" .$invId;
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