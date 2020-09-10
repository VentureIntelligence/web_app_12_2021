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
<form name="ipoupdatedata" method=post action="ipoupdatedata_Return.php">

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


    	 $UpdatecompanySql="update pecompanies set companyname='$companyNametoUpdate',industry=$industrytoUpdate,sector_business='$sectortoUpdate',
    	 website='$websitetoUpdate' where PECompanyId=$companyIdtoUpdate";
		//		echo "<br>company update Query-- " .$UpdatecompanySql;
			if($updaters=mysql_query($UpdatecompanySql))
			{
				$UpdateInvestmentSql="update ipos set IPODate='$fulldate',IPOSize=$dealSizetoUpadte,IPOAmount=$amounttoUpdate,
				IPOValuation=$valuationtoUpdate,Comment='$commenttoUpdate',MoreInfor='$moreInfortoUpdate',
				Validation='$validationtoUpdate',InvestorType='$invTypeId',hideamount=$hideamouttoUpdate, hidemoreinfor=$hidemoreinfortoUpdate,VcFlag=$vcflagtoUpdate,
				InvestmentDeals='$invdealsummary',Link='$linktoUpdate',EstimatedIRR='$estimatedirr',MoreInfoReturns='$moreinforeturns'
				where IPOId=$IPOIdtoUpdate";
                                
				if($updatersinvestment=mysql_query($UpdateInvestmentSql))
				{
					//	echo "<br>Query--**-- " .$UpdateInvestmentSql;
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
                                                                    echo "<Br>Update - ".$updateInvReturnSql;
                                                                  if($rsupdtaeInvReturn=mysql_query($updateInvReturnSql))
                                                                  {
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
                                                        /*if($newinvestortoUpdate!="")
                                                        {
                                                            $invIdtoInsert=return_insert_get_Investor($newinvestor);
							    if($invIdtoInsert==0)
							       $invIdtoInsert=return_insert_get_Investor($newinvestor);

                                                          $insipoInvestorSql="insert into ipo_investors values($IPOIdtoUpdate,$invIdtoInsert,$mutliplereturn)";
                                                          echo "<br>****Insert - ".$insipoInvestorSql;
                                                          if($rsinsert=mysql($insipoInvestorSql))
                                                          {
                                                          }
                                                        }  */
//advisor_companies
					If(trim($advisorCompanytoUpdate!=""))
					{
						$newinvestor=explode(",",$advisorCompanytoUpdate);
						foreach($newinvestor as $newadcom)
						{

							if(trim($newadcom)!="")
							{
								$adCompIdtoInsert=insert_get_CIAs($newadcom);

								if($adCompIdtoInsert==0)
								{	$adCompIdtoInsert=insert_get_CIAs($newadcom);
								}

								if(in_array($adCompIdtoInsert,$advisorCompanyIdtoUpdate)==false)
								{
									$updatePEInvestorsSql="insert into peinvestments_advisorcompanies values($IPOIdtoUpdate,$adCompIdtoInsert)";
									if($rsupdatePEInvestors = mysql_query($updatePEInvestorsSql))
									{
										echo "<br>Isnert Adv Company query-" .newadcom. ">" .$updatePEInvestorsSql;

									}
								}
								else
									echo "<br>***** FALSE";
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
function insert_get_CIAs($cianame)
{
	$cianame=trim($cianame);
	$dbcialink = new dbInvestments();
	$getInvestorIdSql = "select CIAId,cianame from advisor_cias where cianame = '$cianame'";
	echo "<br>select--" .$getInvestorIdSql;
	if ($rsgetInvestorId = mysql_query($getInvestorIdSql))
	{
		$investor_cnt=mysql_num_rows($rsgetInvestorId);
		//echo "<br>Advisor cia table count-- " .$investor_cnt;
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
				///echo "<br>Insert return investor id--" .$invId;
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