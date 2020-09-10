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
<title>Update Investment data : : Contact TSJ Media : :</title>

<SCRIPT LANGUAGE="JavaScript">

</script>
</head>
<body topmargin="0" leftmargin="0" rightmargin="0">
<form name="ipoupdatedata" method=post action="ipoupdatedata.php">

<p > <b><center> <font style="font-family: Verdana; font-size: 10pt">IPO Exit deal update</font> </b></center></p>
<p></p><p></p>
<table width=60% align=center border=1 cellpadding=2>

<?php
    require("../dbconnectvi.php");
	$Db = new dbInvestments();

		$hideamouttoUpdate=0;

         $IPOIdtoUpdate = $_POST['txtIPOId'];
         $industryIdtoUpdate =$_POST['txtindustryId'];
    	 $companyIdtoUpdate = $_POST['txtcompanyid'];
    	//echo "<Br>--CompanyIdtoUpdate- ".$companyIdtoUpdate;
    	 $companyNametoUpdate =  $_POST['txtname'];
    	 $industrytoUpdate=$_POST['industry'];
    	 $sectortoUpdate=$_POST['txtsector'];
    	  $dealSizetoUpadte=$_POST['txtdealSize'];
    	 $amounttoUpdate=$_POST['txtamount'];
    	  $valuationtoUpdate=$_POST['txtvaluation'];

    	 if(($_POST['chkhideamount']))
    	 {
    	 	$hideamouttoUpdate=1;
	    	}
	    else
	    { $hideamouttoUpdate=0;}

         if($_POST['chkinvestorsale'])   //if its checked ,investorsale db value is set to 1
          {  $investorsale=1;}
          else
          {  $investorsale=0;}

         $exitstatusvalue=$_POST['exitstatus'];
        // echo "<Br>-- ".$exitstatusvalue;
          if(($exitstatusvalue=="--") || ($exitstatusvalue==""))
         {   $exitstatusvalue=0;}
         // echo "<Br>^^^^^^^^^^^^^^^".$investorsale;
    	 $investorsidtoUpdate=$_POST['txtinvestorid'];
    	 $investoridarray= count($investorsidtoUpdate);
    	 $investorstoReturn=$_POST['txtinvestorsReturn'];
    	 $invmoreinfo=$_POST['txtinvmoreinfo'];

         //$newinvestortoUpdate=$_POST['txtinvestor'];
         //$newinvestorString=explode(",",$newinvestortoUpdate);
         //$newinvestor=$newinvestorString[0];
         //$mutliplereturn=$newinvestorString[1];
         //if($mutliplereturn=="")
         //    $mutliplereturn=0;


         $invTypeId=$_POST['invType'];

    	 $mthtoUpdate=$_POST['month1'];
    	 $YrtoUpdate=$_POST['year1'];
    	 $fulldate= $YrtoUpdate."-".$mthtoUpdate."-01";

    	 $advisorCompanyIdtoUpdate=$_POST['CIAId'];
    	 $advisorCompanyArray= count($advisorCompanyIdtoUpdate);
    	// 	echo "<br>Advisor company array count- " .$advisorCompanyArray;
	 $advisorCompanytoUpdate= $_POST['txtadvisors'];
		//	echo "<br>Advisor company text array count- " .count($advisorCompanytoUpdate);

    	 $commenttoUpdate=$_POST['txtcomment'];
    	 $moreInfortoUpdate=$_POST['txtmoreinfor'];
    	  if(($_POST['chkhidemoreinfor']))
		 {
			$hidemoreinfortoUpdate=1;
			}
		else
		{ $hidemoreinfortoUpdate=0;}

		$invdealsummary=$_POST['txtinvdealsummary'];
		$linktoUpdate=$_POST['txtlink'];

		 $websitetoUpdate=$_POST["txtwebsite"];
		 $validationtoUpdate=$_POST['txtvalidation'];
		   if(($_POST['chkvcflag']))
		 {
			$vcflagtoUpdate=1;
			}
		else
		{ $vcflagtoUpdate=0;}

		$estimatedirr=$_POST['txtestimatedirr'];
		$moreinforeturns=$_POST['txtmoreinforeturns'];
                $valuation=$_POST['txtvaluationmoreinfo'];
                $finlink=$_POST['txtfinlink'];
                $company_valuation=$_POST['txtcompanyvaluation'];
                $sales_multiple =$_POST['txtsalesmultiple'];
                $EBITDA_multiple=$_POST['txtEBITDAmultiple'];
                $netprofit_multiple=$_POST['txtnetprofitmultiple'];
                $selling_investors=$_POST['txtsellinginvestors'];
                $valutaion_working_fiile=$_POST['txtvaluationworkingfilepath'];
                $valuation_working_existingfile=$_POST['txtvaluationworkingfile'];

                	$currentdir=getcwd();
			//echo "<br>Current Diretory=" .$currentdir;
			$curdir =  str_replace("adminvi","",$currentdir);
			//echo "<br>*****************".$curdir;
			$target = $curdir . "/uploadmamafiles/valuation_workings/" . basename($_FILES['txtvaluationworkingfilepath']['name']);
			$file = "uploadmamafiles/valuation_workings" . basename($_FILES['txtvaluationworkingfilepath']['name']);
			$filename= basename($_FILES['txtvaluationworkingfilepath']['name']);
			//echo "<Br>Target Directory=" .$target;
	//	echo "<Br>File " .$existingfile;
		if($filename!="")
		{
			if (!(file_exists($file)))
			{
				if( move_uploaded_file($_FILES['txtvaluationworkingfilepath']['tmp_name'], $target))
				{
					echo "<br>File is getting uploaded . Please wait..";
					echo "<Br><br>The file ". basename( $_FILES['txtvaluationworkingfilepath']['name']). " has been uploaded";

					$file = "uploadmamafiles/valuation_workings" . basename($_FILES['txtvaluationworkingfilepath']['name']);
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

    	 $UpdatecompanySql="update pecompanies set companyname='$companyNametoUpdate',industry=$industrytoUpdate,sector_business='$sectortoUpdate',
    	 website='$websitetoUpdate' where PECompanyId=$companyIdtoUpdate";
		//		echo "<br>company update Query-- " .$UpdatecompanySql;
			if($updaters=mysql_query($UpdatecompanySql))
			{
				
                                if($valuation_working_existingfile!="")
                                {
                                    $UpdateInvestmentSql="update ipos set IPODate='$fulldate',IPOSize=$dealSizetoUpadte,IPOAmount=$amounttoUpdate,
    				IPOValuation=$valuationtoUpdate,Comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',
    				Validation='$validationtoUpdate',InvestorType='$invTypeId',hideamount=$hideamouttoUpdate, hidemoreinfor=$hidemoreinfortoUpdate,VcFlag=$vcflagtoUpdate,
    				InvestmentDeals='$invdealsummary',Link='$linktoUpdate',EstimatedIRR='$estimatedirr',MoreInfoReturns='$moreinforeturns',
    				Company_Valuation=$company_valuation,Sales_Multiple=$sales_multiple,EBITDA_Multiple=$EBITDA_multiple,
                                    Netprofit_Multiple=$netprofit_multiple,InvestorSale=$investorsale,SellingInvestors='$selling_investors',
                                    Valuation='$valuation',FinLink='$finlink',ExitStatus=$exitstatusvalue
                                    where IPOId=$IPOIdtoUpdate";
                                }
                                else
                                {
                                  $UpdateInvestmentSql="update ipos set IPODate='$fulldate',IPOSize=$dealSizetoUpadte,IPOAmount=$amounttoUpdate,
    				IPOValuation=$valuationtoUpdate,Comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',
    				Validation='$validationtoUpdate',InvestorType='$invTypeId',hideamount=$hideamouttoUpdate, hidemoreinfor=$hidemoreinfortoUpdate,VcFlag=$vcflagtoUpdate,
    				InvestmentDeals='$invdealsummary',Link='$linktoUpdate',EstimatedIRR='$estimatedirr',MoreInfoReturns='$moreinforeturns',
    				Company_Valuation=$company_valuation,Sales_Multiple=$sales_multiple,EBITDA_Multiple=$EBITDA_multiple,
                                    Netprofit_Multiple=$netprofit_multiple,InvestorSale=$investorsale,SellingInvestors='$selling_investors',
                                    Valuation='$valuation',FinLink='$finlink',ExitStatus=$exitstatusvalue,Valuation_Working_fname='$filename'
                                    where IPOId=$IPOIdtoUpdate";
                                }
                                // echo "<br>%%%". $UpdateInvestmentSql;
				if($updatersinvestment=mysql_query($UpdateInvestmentSql))
				{
						//echo "<br>Query--**-- " .$UpdateInvestmentSql;
					$idarray = array();
					$advcomparray=array();
					$advinvarray=array();

                                                        if($investoridarray > 0)
                                                        {
                                                           //echo "<Br>-- ".$investoridarray;
                                                              for($i=0;$i<$investoridarray;$i++)
                                                              {
                                                                //echo "<Br>~~~~".$investoridtoUpdate[$i];
								$investorIdtoUpdate=$investorsidtoUpdate[$i];
								$investorswithMultipletoUpdate=$investorstoReturn[$i];
								$investorString=explode(",",$investorswithMultipletoUpdate);
                                                                $investortoUpdate=$investorString[0];
                                                                $returntoUpdate=$investorString[1];
                                                                $invmoreinfostring=$invmoreinfo[$i];
                                                                //echo "<BR>--" .$invmoreinfostring;
                                                                if($returntoUpdate=="")
                                                                    $returntoUpdate=0;
                                                                if($investortoUpdate!="")
                                                                {
                                                                  $updateInvReturnSql= "Update ipo_investors set MultipleReturn=$returntoUpdate,InvMoreInfo='$invmoreinfostring' where IPOId=$IPOIdtoUpdate and InvestorId=$investorIdtoUpdate";
                                                                    //echo "<Br>Update - ".$updateInvReturnSql;
                                                                  if($rsupdtaeInvReturn=mysql_query($updateInvReturnSql))
                                                                  {
                                                                    echo "<Br>Update - ".$updateInvReturnSql;
                                                                  }
								}
								elseif($investortoUpdate=="")
								{
                                                                 $delInvestorSql="delete from ipo_investors where IPOId=$IPOIdtoUpdate and InvestorId=$investorIdtoUpdate";
										echo "<br>Delete-" .$delInvestorSql;
										if($rsupdatePEInv_Investors = mysql_query($delInvestorSql))
										{
										}
                                                                }
                                                              } // end of for i loop
         	                                        }
         	                                        //add new investor.this is not an array.allowing only one ivestor to add at a time

//advisor_companies
					If(trim($advisorCompanytoUpdate!=""))
					{
						$newinvestor=explode(",",$advisorCompanytoUpdate);
						foreach($newinvestor as $newadcomString)
						{

							if(trim($newadcomString)!="")
							{
                                                                $adcomString=explode("/",$newadcomString);
                                                                $newadcom=$adcomString[0];
                                                                $adtype=$adcomString[1];
								$adCompIdtoInsert=insert_get_CIAs($newadcom,$adtype);

								if($adCompIdtoInsert==0)
								{	$adCompIdtoInsert=insert_get_CIAs($newadcom,$adtype);
								}

								if(in_array($adCompIdtoInsert,$advisorCompanyIdtoUpdate)==false)
								{
									$updatePEInvestorsSql="insert into peinvestments_advisorcompanies values($IPOIdtoUpdate,$adCompIdtoInsert)";
									if($rsupdatePEInvestors = mysql_query($updatePEInvestorsSql))
									{
										echo "<br>Isnert Adv Company query-" .newadcom. ">" .$updatePEInvestorsSql;

									}
								}
								//else
									//echo "<br>***** FALSE";
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
								$updatePEInv_InvestorSql="delete from peinvestments_advisorcompanies where IPOId=$IPOIdtoUpdate and CIAId=$delCompId";
								echo "<br>Delete Adv Company Query-" .$updatePEInv_InvestorSql;
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
	//echo "<br>select--" .$getInvestorIdSql;
	if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
	{
		$investor_cnt=mysql_num_rows($rsgetInvestorId);
		//echo "<br>Advisor cia table count-- " .$investor_cnt;
		if ($investor_cnt==0)
		{
				//insert acquirer
				$insAcquirerSql="insert into advisor_cias(cianame,AdvisorType) values('$cianame','$advtype')";
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
				$adtypestr=$myrow[1];
				if($adtypestr!=$advtype)
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

//function to insert investors
	function return_insert_get_Investor($investor)
	{
		$investor=trim($investor);
		$investor=ltrim($investor);
		$investor=rtrim($investor);
		$dblink = new dbInvestments();
		$getInvestorIdSql = "select InvestorId from peinvestors where Investor = '$investor'";
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
					//echo "<br>Insert return investor id--" .$InvestorId;
					return $InvestorId;
				}
			}
		}
		$dblink.close();
	}
?>