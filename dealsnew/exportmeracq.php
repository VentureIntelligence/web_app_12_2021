<?php include_once("../globalconfig.php"); ?>
<?php
 session_save_path("/home/users/web/b1284/ipw.ventureintelligence/phpsessions");
	session_start();

	require("../dbconnectvi.php");
	$Db = new dbInvestments();
		//include('onlineaccount.php');
		$displayMessage="";
		$mailmessage="";


			//	global $LoginAccess;
			//	global $LoginMessage;
			$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";

					$submitemail=$_POST['txthideemail'];
					$hidesearchon=$_POST['txtsearchon'];
					$hideindustry=$_POST['txthideindustry'];
					$hideindustryvalue=$_POST['txthideindustryvalue'];
					$rangeText=$_POST['txthiderange'];
					$datevalue=$_POST['txthidedate'];
					//echo "<Br>****".$datevalue;

					$targetcompanysearch=$_POST['txthidecompany'];
					//echo "<Br>***".$targetcompanysearch;
					if(($targetcompanysearch!=="+") && ($targetcompanysearch!==""))
					{	$splitString=explode("+", $targetcompanysearch);
						$splitString1=$splitString[0];
						$splitString2=$splitString[1];
						if($splitString2!="")
							$targetcompanysearch=$splitString1. " " .$splitString2;
						else
						 	$targetcompanysearch=$splitString1;
					}
					//echo "<br>--".$targetcompanysearch;
					$advisorsearch_legal=$_POST['txthideadvisor_legal'];
					$advisorsearch_legal =ereg_replace("-"," ",$advisorsearch_legal);

                                        $advisorsearch_trans=$_POST['txthideadvisor_trans'];
					$advisorsearch_trans =ereg_replace("-"," ",$advisorsearch_trans);

					$acquirersearch=$_POST['txthideacquirer'];
					if(($acquirersearch!=="+") && ($acquirersearch!==""))
					{	$splitStringAcquirer=explode("+", $acquirersearch);
						$splitString1Acquirer=$splitStringAcquirer[0];
						$splitString2Acquirer=$splitStringAcquirer[1];
						if($splitString2Acquirer!="")
							$acquirersearch=$splitString1Acquirer. " " .$splitString2Acquirer;
						else
							$acquirersearch=$splitString1Acquirer;
					}
					$searchallfield=$_POST['txthidesearchallfield'];
					$searchallfield =ereg_replace("-"," ",$searchallfield);

					$dealtype=$_POST['txthidedealtype'];
					$dealtypevalue=$_POST['txthidedealtypevalue'];
					$SPVvalue=$_POST['txthideSPV'];
					if($SPVvalue ==1)
                                		$projecttypename="Entity";
					elseif($SPVvalue ==2)
                                                $projecttypename="Project / Asset";
                                        else
                                                $projecttypename="";

                                         //       echo "<br>^^^^".$SPVvalue;
					$hiderangeStartValue=$_POST['txthiderangeStartValue'];
					$hiderangeEndValue=$_POST['txthiderangeEndValue'];
					$hidedateStartValue=$_POST['txthidedateStartValue'];
					$hidedateEndValue=$_POST['txthidedateEndValue'];
					$dateValue=$_POST['txthidedate'];

					//$submitemail=$_POST['txtemailid'];
					$submitpassword=$_POST['txtemailpassword'];
					//echo "<br>--".$hidesearchon;
					//echo "<Br>--**__" .$acquirersearch;

					//meracq view values
					$targetCountryId=$_POST['txttargetcountry'];
					$acquirerCountryId=$_POST['txtacquirercountry'];

                                        $target_comptype=$_POST['txthidetargetcomptype'];
                                        $acquirer_comptype=$_POST['txthideacquirercomptype'];

					$tsjtitle="© TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";


				/*echo "<br>Industry Id-----------------**".$hideindustryid;
				echo "<br>Inv type id-----------------**".$invtypevalueid;
				echo "<br>Start Range Value-----------------**".$hiderangeStartValue;
				echo "<br>End Range value-----------------**".$hiderangeEndValue;
				*/
				//echo "<br>start Date-----------------**".$hidedateStartValue;
				//echo "<br>End Date-----------------**".$dateValue;
				//echo "<br>Deal Type---**". $dealtype;


					if($acquirersearch!="")
					{
					    $companysqlFinal="SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
					    ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
					    pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
					    sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
					    DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
					    pec.website,pe.MoreInfor,md.MADealType as Type,
					    pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
					    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status
					    FROM
					    mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md
					    WHERE md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
					    AND pec.PEcompanyID = pe.PECompanyID
					    and ac.AcquirerId = pe.AcquirerId
					    and c.CountryId=pec.countryid AND pe.Deleted =0
					    AND pec.industry !=15  AND ac.Acquirer LIKE '%$acquirersearch%'
					    order by companyname ";
						//echo "<br> Acquirer search- ".$companysqlFinal;
					}
					elseif($advisorsearch_legal!="")
					{

					    $companysqlFinal="(SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
					    ac.countryid,pe.Asset,pe.MADealTypeId,pec.PEcompanyId,
					    pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
					    pec.sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
					    DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
					    pec.website,pe.MoreInfor,
					    cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.hideamount,Link,Valuation,FinLink,
					    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status
					    FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md,
					    advisor_cias AS cia,mama_advisoracquirer AS adac
					    where md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
					    AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15 and
					    c.CountryId=pec.countryId
					     and ac.AcquirerId=pe.AcquirerId and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and cia.cianame LIKE '%$advisorsearch_legal%')
					    UNION
					    (SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
					    ac.countryid,pe.Asset,pe.MADealTypeId,pec.PEcompanyId,
					    pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
					    pec.sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
					    DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
					    pec.website,pe.MoreInfor,
					    cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.hideamount,Link,Valuation,FinLink,
					    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status
					    FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md,
					    advisor_cias AS cia,mama_advisorcompanies AS adac
					    where md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
					    AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15 and
					    c.CountryId=pec.countryId
					     and ac.AcquirerId=pe.AcquirerId and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and cia.cianame LIKE '%$advisorsearch_legal%')
					    order by Target_Company";
				//	echo "<br> Advisor  search- ".$companysqlFinal;
					}
                                        elseif($advisorsearch_trans!="")
					{

					    $companysqlFinal="(SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
					    ac.countryid,pe.Asset,pe.MADealTypeId,pec.PEcompanyId,
					    pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
					    pec.sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
					    DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
					    pec.website,pe.MoreInfor,
					    cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.hideamount,Link,Valuation,FinLink,
					    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status
					    FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md,
					    advisor_cias AS cia,mama_advisoracquirer AS adac
					    where md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
					    AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15 and
					    c.CountryId=pec.countryId
					     and ac.AcquirerId=pe.AcquirerId and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and cia.cianame LIKE '%$advisorsearch_trans%')
					    UNION
					    (SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
					    ac.countryid,pe.Asset,pe.MADealTypeId,pec.PEcompanyId,
					    pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
					    pec.sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
					    DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
					    pec.website,pe.MoreInfor,
					    cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.hideamount,Link,Valuation,FinLink,
					    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status
					    FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md,
					    advisor_cias AS cia,mama_advisorcompanies AS adac
					    where md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
					    AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15 and
					    c.CountryId=pec.countryId
					     and ac.AcquirerId=pe.AcquirerId and adac.CIAId=cia.CIAID and adac.MAMAId=pe.MAMAId and cia.cianame LIKE '%$advisorsearch_trans%')
					    order by Target_Company";
				//	echo "<br> Advisor  search- ".$companysqlFinal;
					}
					elseif (($acquirersearch == "") && ($targetcompanysearch == "") &&  ($searchallfield=="")  && ($advisorsearch=="") && ($hideindustry =="--") && ($dealtype == "--") && ($target_comptype=="--") && ($acquirer_comptype=="--") && ($SPVvalue=="--") && ($hiderangeStartValue == "") && ($hiderangeEndValue == "")  && ($dateValue="---to---") && ($acquirerCountryId=="--") && ($targetCountryId=="--"))
					{

					     $companysqlFinal="SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
					    ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
					    pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
					    sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
					    DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
					    pec.website,pe.MoreInfor,md.MADealType as Type,
					    pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
					    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status
					    FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md,
					    WHERE md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
					    AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15 and
					    c.CountryId=pec.countryId
					     and ac.AcquirerId=pe.AcquirerId order by companyname";


				//echo "<br>3 Query for All records" .$companysqlFinal;
					}
					elseif (trim($targetcompanysearch != ""))
					{
					    $companysqlFinal="SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
					    ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
					    pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
					    sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
					    DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
					    pec.website,pe.MoreInfor,md.MADealType as Type,
					    pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
					    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status
					    FROM
					    mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md
					    WHERE md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
					    AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
					    and c.CountryId=pec.countryid
					    AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry.
					    " AND (pec.companyname LIKE '%$targetcompanysearch%' or  sector_business LIKE '%$targetcompanysearch%')
					    order by companyname";

					    $fetchRecords=true;
					    $fetchAggregate==false;
					//	echo "<br>Query for company search";
				//	echo "<Br>***".$targetcompanysearch;
				// echo "<br> Company search--" .$companysqlFinal;
					}
					elseif (trim($searchallfield != ""))
					{
					    $companysqlFinal="SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
					    ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
					    pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
					    sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
					    DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
					    pec.website,pe.MoreInfor,md.MADealType as Type,
					    pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
					    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status
					    FROM
					    mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md
					    WHERE md.MADealTypeId=pe.MADealTypeId and pec.industry = i.industryid
					    AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
					    and c.CountryId=pec.countryid
					    AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry.
					    " AND (pec.companyname LIKE '%$searchallfield%' or  sector_business LIKE '%$searchallfield%' or MoreInfor LIKE '%$searchallfield%')
					    order by companyname";

					    $fetchRecords=true;
					    $fetchAggregate==false;
					    //	echo "<br>Query for company search";
				    //	echo "<Br>***".$targetcompanysearch;
					// echo "<br> Company search--" .$companysqlFinal;
					}

					elseif (($hideindustry > 0) || ($dealtype != "--") ||  ($target_comptype!="--") || ($acquirer_comptype!="--") ||($SPVvalue > 0) || ($hiderangeStartValue !="--") || ($hiderangeEndValue != "--") || (($hidedateStartValue != "--") && ($hidedateEndValue!="--")) || ($targetCountryId!="--") || ($acquirerCountryId!="--"))
					{
						//echo "<br>-________________";
					    $companysql = "SELECT pe.PECompanyId,pec.industry,pe.MAMAId, pec.countryId,pe.AcquirerId,
					    ac.countryid,pe.Asset,pe.MADealTypeId,pec.PECompanyId,
					    pec.companyname as Target_Company,ac.Acquirer as Acquirer, i.industry as Industry_Target ,
					    sector_business as Sector_Target,pe.Amount as Amount,pe.Stake as Stake,
					    DATE_FORMAT( DealDate, '%M-%Y' ) as DealDate,md.MADealType as Type,
					    pec.website,pe.MoreInfor,md.MADealType as Type,
					    pec.website,pe.MoreInfor,pe.hideamount,Link,Valuation,FinLink,
					    Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status
					    FROM mama AS pe, industry AS i, pecompanies AS pec,country as c,acquirers as ac,madealtypes as md
					    where md.MADealTypeId=pe.MADealTypeId and ";

                                            $wheretargetcomptype="";
                                            $whereacquirercomptype="";
                                            $whereSPVCompanies="";
					    if ($hideindustry > 0)
					    {
						    $whereind = " pec.industry=" .$hideindustry ;
					    }
					    if ($dealtype!= "--")
					    {
						    $wheredealtype = " pe.MADealTypeId =" .$dealtype;
					    }

					    if($target_comptype!="--")
                                                    $wheretargetcomptype= " pe.target_listing_status='$target_comptype'";
                                            if($acquirer_comptype!="--")
                                                    $whereacquirercomptype= " pe.acquirer_listing_status='$acquirer_comptype'";


					     if($SPVvalue==1)
							       $whereSPVCompanies=" pe.Asset=0";
						        elseif($SPVvalue==2)
                                                               $whereSPVCompanies=" pe.Asset=1";
                                           // echo "<br>********" .$whereSPVCompanies;
					    $whererange ="";

					    if (($hiderangeStartValue!= "--") && ($hiderangeEndValue != ""))
					    {

						    if($hiderangeStartValue == $hiderangeEndValue)
						    {
							    $whererange = " pe.Amount = ".$hiderangeStartValue ."";
						    }
						    elseif($hiderangeStartValue < $hiderangeEndValue)
						    {
							    $whererange = " pe.Amount between  ".$hiderangeStartValue ." and ". $hiderangeEndValue ."";
						    }

						    //echo "<br>-- ".$whererange;

					    }
					    if($targetCountryId !="--")
					    {
						    $wheretargetCountry=" pec.countryId='" .$targetCountryId. "' ";
					    }
					    if($acquirerCountryId!="--")
					    {
						    $whereacquirerCountry=" ac.countryId='" .$acquirerCountryId. "' and c.countryid=ac.countryid";
					    }

					    //if( ($hidedateStartValue !="------01") && ($hidedateEndValue != "------01"))
					    if($datevalue!="---to---")
					    {
						    $wheredates= " DealDate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
					    }
					    else
					    {
						    $wheredates="";
					    }

					    if ($whereind != "")
					    {
						    $companysql=$companysql . $whereind ." and ";
						    $bool=true;
					    }
					    if (($wheredealtype != ""))
					    {
						    $companysql=$companysql . $wheredealtype . " and " ;
						    $bool=true;
					    }
					    if($wheretargetcomptype!="")
                                                     $companysql=$companysql .$wheretargetcomptype . " and ";

                                            if($whereacquirercomptype!="")
                                                     $companysql=$companysql .$whereacquirercomptype . " and ";
					     if (($whereSPVCompanies != "") )
						        {
							        $companysql=$companysql .$whereSPVCompanies . " and ";
								$bool=true;
					        	}
					    if (($whererange != "") )
					    {
						    $companysql=$companysql .$whererange . " and ";
						    $bool=true;
					    }
					    if($wheretargetCountry!="")
					    {
						    $companysql=$companysql .$wheretargetCountry . " and ";
					    }
				    //	echo "<br>-###" .$wheredates;
					    if($wheredates !== "")
					    {
					    //	echo "<bR>----------".$wheredates;
						    $companysql = $companysql . $wheredates ." and ";
						    $bool=true;
					    }
					    $companysqlFinal = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
					    and  c.countryid=pec.countryid and ac.AcquirerId = pe.AcquirerId
					    and pec.industry != 15 and pe.Deleted=0  order by companyname ";
					    if($whereacquirerCountry!="")
					    {
						    $companysql=$companysql .$whereacquirerCountry. " and ";
					    //	echo "<br>".$companysql;
						    $companysqlFinal = $companysql . " i.industryid=pec.industry
						    and  pec.PEcompanyID = pe.PECompanyID
						    and  ac.AcquirerId = pe.AcquirerId
						    and pec.industry != 15 and pe.Deleted=0  order by companyname ";
					    }


					    $fetchRecords=true;
					    $fetchAggregate==false;
				    //	echo "<br><br>WHERE CLAUSE SQL---" .$companysqlFinal;
				    }
				    else
				    {
					    //echo "<br> INVALID DATES GIVEN ";
					    $fetchRecords=false;
					    $fetchAggregate==false;
			}

//mail sending

//if((trim($submitemail)!= "") && (trim($submitpassword)!=""))
//		{
  $insert_downloadlog_sql="insert into downloads_log(EmailId,dbcategory,dbtype,industry,dealtype,period,dealrange,companysearch,advisorsearch_legal,advisorsearch_trans,acquirersearch,targetcountry,acquirercountry,target_listing_status,acquirer_listing_status)
 values('$submitemail','MA','MAMA','$hideindustryvalue','$dealtypevalue','$datevalue','$rangeText','$companysearch','$advisorsearch_legal','$advisorsearch_trans','$acquirersearch','$targetCountryId','$acquirerCountryId','$target_comptype','$acquirer_comptype')";

      if ($rsinsert_download = mysql_query($insert_downloadlog_sql))
      {
        //echo "<br>***".$insert_downloadlog_sql;
      }

			$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM malogin_members AS dm,
													dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND
													dm.EmailId='$submitemail' AND dc.Deleted =0";

			if ($totalrs = mysql_query($checkUserSql))
			{
				$cnt= mysql_num_rows($totalrs);

				if ($cnt==1)
				{
       					While($myrow=mysql_fetch_array($totalrs, MYSQL_BOTH))
					{
						if( date('Y-m-d')<=$myrow["ExpiryDate"])
						{

								$OpenTableTag="<table border=1 cellpadding=1 cellspacing=0 ><td>";
								$CloseTableTag="</table>";


								$headers  = "MIME-Version: 1.0\n";
								$headers .= "Content-type: text/html;
								charset=iso-8859-1;Content-Transfer-Encoding: 7bit\n";

								/* additional headers
								$headers .= "Cc: sow_ram@yahoo.com\r\n"; */

								$RegDate=date("M-d-Y");
								$to="arun.natarajan@gmail.com,arun@ventureintelligence.com";
								//$to="sowmyakvn@gmail.com";
								if($searchtitle==0)
								{
									$searchdisplay="PE Deals";
								}
								elseif($searchtitle==1)
								{
									$searchdisplay="VC Deals";
								}
								elseif($searchtitle==2)
								{
									$searchdisplay="Real Estate";
								}
								else
									$searchdisplay="";
								if($hidesearchon==1)
								{
									$subject="Send Excel Data: Investments - $searchdisplay";
									$message="<html><center><b><u> Send Investment : $searchdisplay - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustryvalue</td></tr>
									<tr><td width=1%>Stage</td><td width=99%>$hidestage</td></tr>
									<tr><td width=1%>Investment Type</td><td width=99%>$invtypevalue</td></tr>
									<tr><td width=1%>Range</td><td width=99%>$rangeText</td></tr>
									<tr><td width=1%>Period</td><td width=99%>$datevalue</td></tr>
									<tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
									<tr><td width=1%>Company/Sector</td><td width=99%>$companysearch</td></tr>
									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";
								}
								elseif($hidesearchon==2)
								{
									$subject="Send Excel Data: IPO - $searchdisplay";
									$message="<html><center><b><u> Send IPO Data: $searchdisplay to - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustryvalue</td></tr>
									<tr><td width=1%>Period</td><td width=99%>$datevalue</td></tr>
									<tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
									<tr><td width=1%>Company</td><td width=99%>$companysearch</td></tr>
									<tr><td width=1%>Advisor</td><td width=99%>$advisorsearch</td></tr>

									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";
								}
								elseif($hidesearchon==3)
								{
									$subject="Send Excel Data : M&A - $searchdisplay ";
									$message="<html><center><b><u> Send M&A Data :$searchdisplay to - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustryvalue</td></tr>
									<tr><td width=1%>Deal Type </td><td width=99%>$dealtype</td></tr>
									<tr><td width=1%>Project Type </td><td width=99%>$projecttypename</td></tr>
									<tr><td width=1%>Period</td><td width=99%>$datevalue</td></tr>
									<tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
									<tr><td width=1%>Company</td><td width=99%>$companysearch</td></tr>
									<tr><td width=1%>Advisor</td><td width=99%>$advisorsearch</td></tr>
									<tr><td width=1%>Acquirer</td><td width=99%>$acquirersearch</td></tr>
									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";
								}
								elseif($hidesearchon==4)
								{
									$searchdisplay="";
									$subject="Send Excel Data : Mergers & Acquistion - $searchdisplay ";
									$message="<html><center><b><u> Send Mergers & Acquistion Data :$searchdisplay to - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustryvalue</td></tr>
									<tr><td width=1%>Deal Type </td><td width=99%>$dealtypevalue</td></tr>
									<tr><td width=1%>Period</td><td width=99%>$datevalue</td></tr>
									<tr><td width=1%>Target Company</td><td width=99%>$companysearch</td></tr>
									<tr><td width=1%>Advisor</td><td width=99%>$advisorsearch</td></tr>
									<tr><td width=1%>Acquirer</td><td width=99%>$acquirersearch</td></tr>
									<tr><td width=1%>Target Country</td><td width=99%>$targetCountry</td></tr>
									<tr><td width=1%>Acquirer Country</td><td width=99%>$acquirerCountry</td></tr>
									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";
								}
								mail($to,$subject,$message,$headers);
								//header( 'Location: https://www.ventureintelligence.com/deals/cthankyou.php' ) ;


						}
						elseif($myrow["ExpiryDate"] >= date('y-m-d'))
						{
							$displayMessage= $TrialExpired;
							$submitemail="";
							$submitpassword="";

						}
					}
				}
				elseif ($cnt==0)
				{
					$displayMessage= "Invalid Login / Password";
					$submitemail="";
							$submitpassword="";

				}
			}
	//	}


 $sql=$companysqlFinal;
//echo "<br>---" .$sql;
 //execute query
 $result = @mysql_query($sql)
     or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());

 //if this parameter is included ($w=1), file returned will be in word format ('.doc')
 //if parameter is not included, file returned will be in excel format ('.xls')
 	if (isset($w) && ($w==1))
 	{
 		$file_type = "msword";
 		$file_ending = "doc";
 	}
 	else
 	{
 		$file_type = "vnd.ms-excel";
 		$file_ending = "xls";
	}
 //header info for browser: determines file type ('.doc' or '.xls')
 header("Content-Type: application/$file_type");
 header("Content-Disposition: attachment; filename=merger_acq_data.$file_ending");
 header("Pragma: no-cache");
 header("Expires: 0");

 /*    Start of Formatting for Word or Excel    */



 /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */

 	//create title with timestamp:
 	if ($Use_Title == 1)
 	{
 		echo("$title\n");
 	}
 	 	echo ("$tsjtitle");

 print("\n");
 	  print("\n");

 //define separator (defines columns in excel & tabs in word)
 $sep = "\t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-9; $i++)
 //{
// 	echo mysql_field_name($result,$i) . "\t";
 //}
	//echo "Deal Date"."\t";
	//echo "Type"."\t";
	echo "Target_Company"."\t";
	echo "Target_Company Type"."\t";
 	echo "Acquirer"."\t";
 	echo "Acquirer_Company Type"."\t";
 	echo "Industry_Target"."\t";
 	echo "Sector_Target"."\t";
 	echo "Amount (US\$M)"."\t";
 	echo "Stake (%)"."\t";
	echo "Deal Date"."\t";
	echo "Type"."\t";

	echo "Advisor_Target"."\t";
    echo "Advisor_Acquirer"."\t";
	echo "City_Target"."\t";
	echo "Country_Target"."\t";
	echo "City_Acquirer"."\t";
	echo "Country_Acquirer"."\t";
	echo "Website_Target"."\t";
	echo "More Information"."\t";
 	echo "Link"."\t";

	echo "Company Valuation-Enterprise Value(INR Cr)"."\t";
       echo "Revenue Multiple(based on EV)"."\t";
       echo "EBITDA Multiple(based on EV)"."\t";
       echo "PAT Multiple(based on EV)"."\t";
          echo "Valuation (More Info)"."\t";
	echo "Link for Financials"."\t";
 print("\n");
 print("\n");
 //end of printing column names

 //start while loop to get data
 /*
 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
 */
     while($row = mysql_fetch_row($result))
     {

     	$searchString="Undisclosed";
		$searchString=strtolower($searchString);
		$searchStringDisplay="Undisclosed";

		$searchString1="Unknown";
		$searchString1=strtolower($searchString1);
		$searchString1Display="Unknown";

		$searchString2="Others";
		$searchString2=strtolower($searchString2);
		$searchString2Display="Others";

		$searchString3="Individual";
		$searchString3=strtolower($searchString3);
		$searchString3ForDisplay="Individual";


		$searchString4="PE Firm(s)";
		$searchString4ForDisplay="PE Firm(s)";
		$searchString4=strtolower($searchString4);

         //set_time_limit(60); // HaRa
         $schema_insert = "";
         $MAMAId=$row[2];
        $AcquirerId=$row[4];
        $PECompanyId=$row[0];

		$companyName=$row[9];
		$companyName=strtolower($companyName);
		$compResult=substr_count($companyName,$searchString);
		$compResult1=substr_count($companyName,$searchString1);

		$acquirerName=$row[10];
		$acquirerName=strtolower($acquirerName);
		$compResultAcquirer=substr_count($acquirerName,$searchString4);
		$compResultAcquirer1=substr_count($acquirerName,$searchString);
		$compResultAcquirer3=substr_count($acquirerName,$searchString3);

                $target_listing_status_display="";
                $acquirer_listing_status_display="";
               if($row[30]=="L")
                     $target_listing_status_display="Listed";
                elseif($row[30]=="U")
                     $target_listing_status_display="Unlisted";

                if($row[31]=="L")
                     $acquirer_listing_status_display="Listed";
                elseif($row[31]=="U")
                     $acquirer_listing_status_display="Unlisted";

		if(($compResult==0) && ($compResult1==0))
			$comp=$row[9];
		else
			$comp=$searchStringDisplay;

         if($row[6]==1)
         	$schema_insert .= "("."$comp".")".$sep;
         else
         	$schema_insert .= "$comp".$sep;
                $schema_insert .= $target_listing_status_display.$sep;

		if(($compResultAcquirer==0) && ($compResultAcquirer1==0) && ($compResultAcquirer3==0) )
			$acquirerDisplay=$row[10];
		elseif($compResultAcquirer==1)
			$acquirerDisplay=$searchString4ForDisplay;
		elseif($compResultAcquirer1==1)
			$acquirerDisplay=$searchStringDisplay;
		elseif($compResultAcquirer3==1)
			$acquirerDisplay=$searchString3ForDisplay;

		$schema_insert .= $acquirerDisplay.$sep;
                $schema_insert .= $acquirer_listing_status_display.$sep;
        for($j=11; $j<mysql_num_fields($result)-15;$j++)
		 {
			 if(!isset($row[$j]))
				 $schema_insert .= "NULL".$sep;
			 if($row[$j] != "")
			 {
				if(($j==13))
				 {
					if($row[$j]<=0)
						{$schema_insert .= "".$sep;}
					elseif(($row[$j]>0) && ($row[22]==1))
						{$schema_insert .= "".$sep;}
					else
						{$schema_insert .= "$row[$j]".$sep;}
				 }
				 elseif(($j==14))
				 {
					if($row[$j]<=0)
						{$schema_insert .= "".$sep;}
				else
						{$schema_insert .= "$row[$j]".$sep;}
				 }
				 else
					$schema_insert .= "$row[$j]".$sep;

			  }
			 else
				 $schema_insert .= "".$sep;
         }
      //   $schema_insert .= "AAAA".$sep;
       //    $schema_insert = str_replace($sep."$", "", $schema_insert);

       //Deal Date
                  // $schema_insert .= $row[15].$sep;
                 //dealType
	        // $schema_insert .= $row[16].$sep;

             $mama_advisorTargetSql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame,AdvisorType from mama_advisorcompanies as advcomp,
		advisor_cias as cia where advcomp.MAMAId=$MAMAId and advcomp.CIAId=cia.CIAId";
		if($resultTarget = mysql_query($mama_advisorTargetSql))
				 {
					 $targetString="";
				   while($rowTarget = mysql_fetch_array($resultTarget))
					{
						$targetString=$targetString.",".$rowTarget[2]."(".$rowTarget[3].")";
					}
						$targetString=substr_replace($targetString, '', 0,1);
				}
				$schema_insert .= $targetString.$sep;

         $mama_advisoracquirerSql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame,AdvisorType from mama_advisoracquirer as advcomp,
		advisor_cias as cia where advcomp.MAMAId=$MAMAId and advcomp.CIAId=cia.CIAId";
		 if($result1 = mysql_query($mama_advisoracquirerSql))
		 {
			 $acquirerString="";
		   while($row1 = mysql_fetch_array($result1))
			{
				$acquirerString=$acquirerString.",".$row1[2]."(".$row1[3].")";
			}
				$acquirerString=substr_replace($acquirerString, '', 0,1);
		}
			$schema_insert .= $acquirerString.$sep;


  		 $targetCityCountrySql="select pe.city,pe.CountryId,co.Country from
	      pecompanies as pe,country as co where pe.PECompanyId=$PECompanyId and co.CountryId=pe.CountryId";
	     // echo "<bR>---" .$targetCityCountrySql;
	      if($targetrs=mysql_query($targetCityCountrySql))
		  {
			while($targetrow=mysql_fetch_array($targetrs))
			{
				$targetCity=$targetrow[0];
				$targetCountry=$targetrow[2];
			}
	      }
	        $schema_insert .= $targetCity.$sep;
			$schema_insert .= $targetCountry.$sep;

	      $acquirerCityCountrySql="select ac.CityId,ac.CountryId,co.Country from
	      acquirers as ac,country as co where ac.AcquirerId=$AcquirerId and co.CountryId=ac.CountryId";
	      if($acquirerrs=mysql_query($acquirerCityCountrySql))
	      {
	      	while($acquirerrow=mysql_fetch_array($acquirerrs))
	      	{
	      		$acquirerCity=$acquirerrow[0];
	      		$acquirerCountry=$acquirerrow[2];
	      	}
	      }
		$schema_insert .= $acquirerCity.$sep;
		$schema_insert .= $acquirerCountry.$sep;
	         $schema_insert .= $row[17].$sep; //website
	         $schema_insert .= $row[18].$sep; //moreinfor
                  $schema_insert .= $row[23].$sep;    //Link

		

//	pls check the header and hardcode the headers instead of fetching the column name
		$dec_company_valuation=$row[26];
             if ($dec_company_valuation <=0)
                $dec_company_valuation="";

            $dec_revenue_multiple=$row[27];
            if($dec_revenue_multiple<=0)
                $dec_revenue_multiple="";

            $dec_ebitda_multiple=$row[28];
            if($dec_ebitda_multiple<=0)
                $dec_ebitda_multiple="";

            $dec_pat_multiple=$row[29];
            if($dec_pat_multiple<=0)
               $dec_pat_multiple="";

       $schema_insert .= $dec_company_valuation.$sep;  //company valuation
       $schema_insert .= $dec_revenue_multiple.$sep;  //Revenue Multiple
       $schema_insert .= $dec_ebitda_multiple.$sep;  //EBITDA Multiple
       $schema_insert .= $dec_pat_multiple.$sep;  //PAT Multiple
        	$schema_insert .= $row[24].$sep;    //Valuation
		$schema_insert .= $row[25].$sep;    //Lin for Financial
	       // 	$schema_insert .= $row[22].$sep;  //hideamount column in sqlquery

	 		$schema_insert = str_replace($sep."$", "", $schema_insert);
            $schema_insert .= ""."\n";
 		//following fix suggested by Josue (thanks, Josue!)
 		//this corrects output in excel when table fields contain \n or \r
 		//these two characters are now replaced with a space
 		$schema_insert = preg_replace("/\r\n|\n\r|\n|\r/", " ", $schema_insert);
         $schema_insert .= "\t";
         print(trim($schema_insert));
         print "\n";
     }

mysql_close();
    mysql_close($cnx);
    ?>