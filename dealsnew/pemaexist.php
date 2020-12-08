
<?php
        $emailid="team@kutung.com";
         $companyId=632270771;
                 $compId=0;
	$currentyear = date("Y");
	$VCFlagValueString = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
	$VCFlagValue_exit = explode("-", $VCFlagValueString);
	 $vcflagValue=$VCFlagValue_exit[0];
        $hide_pms=$VCFlagValue_exit[1];
         echo $_POST['dealtype'];
        require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
          $notable=false;
        $vcflagValue=$_POST['txtvcFlagValue'];
        $hide_pms=$_POST['txthide_pms'];
        //echo "<bR>--" .$vcflagValue;

        if($vcflagValue==1)
        {
                $addVCFlagqry = " and VCFlag=1 ";
                $searchTitle = "List of VC Exits - M&A";
                $searchAggTitle = "Aggregate Data - VC Exits - M&A";
        }
        else
        {
                $addVCFlagqry = "";
                $searchTitle = "List of PE Exits - M&A";
                $searchAggTitle = "Aggregate Data - PE Exits - M&A";
        }

        if($hide_pms==0)
        { $var_hideforexit=0;
          $samplexls="../xls/sample-exits-via-m&a.xls";
        }
        elseif($hide_pms==1)
        { $var_hideforexit=1;
          $searchTitle = "List of Public Market Sales - Exits";
          $samplexls="../xls/sample-exits-via-m&a(publicmarketsales).xls";
        }

        $addhide_pms_qry=" and pe.DealTypeId= dt.DealTypeId and dt.hide_for_exit=".$var_hideforexit;
        //echo "<br>1 --". $addhide_pms_qry;
                                        $buttonClicked=$_POST['hiddenbutton'];
                                        //echo "<br>--" .$buttonClicked;
                                        //$fetchRecords=true;
                                        
                                       // echo $_POST['txtmultipleReturnFrom'];
                                        //echo $_POST['txtmultipleReturnTo'];
                                       // echo $_POST['invType'];
                                        //echo $_POST['exitstatus'];
                                       
                                        //echo $_POST['dealtype'];
                                        //echo $_POST['pmonth1'];
                                        //echo $_POST['pyear1'];
                                        //echo $_POST['pmonth2'];
                                        //echo $_POST['pyear2'];
                                                
                                                
                                                
                                                
                                                
                                                
                                                $aggsql="";
                                                $totalDisplay="";
                                                $acquirersearch= $_POST['acquirersearch'];
                                                $companysearch=$_POST['companysearch'];
                                                if($companysearch!=="")
                                                {
                                                        $splitStringCompany=explode(" ", $companysearch);
                                                        $splitString1Company=$splitStringCompany[0];
                                                        $splitString2Company=$splitStringCompany[1];
                                                        $stringToHideCompany=$splitString1Company. "+" .$splitString2Company;
                                                }


                                                $investorsearch=$_POST['investorsearch'];
                                                if($investorsearch!=="")
                                                {
                                                        $splitStringInvestor=explode(" ", $investorsearch);
                                                        $splitString1Investor=$splitStringInvestor[0];
                                                        $splitString2Investor=$splitStringInvestor[1];
                                                        $stringToHideInvestor=$splitString1Investor. "+" .$splitString2Investor;
                                                }
                                                //$adcompanyacquirer=$_POST['adcompanyacquirersearch'];

                                                $searchallfield=$_POST['searchallfield'];
                                                $searchallfieldhidden=ereg_replace(" ","-",$searchallfield);

                                                $advisorsearchstring_legal=$_POST['advisorsearch_legal'];
                                                $advisorsearchhidden_legal=ereg_replace(" ","_",$advisorsearchstring_legal);

                                                $advisorsearchstring_trans=$_POST['advisorsearch_trans'];
                                                $advisorsearchhidden_trans=ereg_replace(" ","_",$advisorsearchstring_trans);

                                        //	echo "<br>Key word ---" .$keyword;
                                                $industry=$_POST['industry'];
                                                if($_POST['dealtype'])
                                                        $dealtype=$_POST['dealtype'];
                                                else
                                                        $dealtype="--";
                                                //echo "<bR>--- ".$dealtype."***";

                                                $investorType=$_POST['invType'];
                                                $exitstatusvalue=$_POST['exitstatus'];
                                                //echo "<br >--**".$exitstatusvalue;
                                                //$range=$_POST['invrangestart'];
                                                //$range1=$_POST['invrangeend'];
                                                //$startRangeValue=$_POST['invrangestart'];
                                                //$endRangeValue=$_POST['invrangeend'];
                                                $startRangeValue="--";
                                                $endRangeValue="--";
                                                //echo "<br>*****";
                                                $month1=$_POST['pmonth1'];
                                                $year1 = $_POST['pyear1'];
                                                $month2=$_POST['pmonth2'];
                                                //echo "<Br>---" .$month2;
                                                $year2 = $_POST['pyear2'];

                                                $txtfrm=$_POST['txtmultipleReturnFrom'];
                                                $txtto=$_POST['txtmultipleReturnTo'];
                                                $whereind="";
                                                $wheredealtype="";
                                                $wheredates="";
                                                $whererange="";
                                                $whereReturnMultiple="";
$datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
$splityear1=(substr($year1,2));
$splityear2=(substr($year2,2));

if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
{	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
        $datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
}
if($industry >0)
                {
                        $industrysql= "select industry from industry where IndustryId=$industry";
                        if ($industryrs = mysql_query($industrysql))
                        {
                                While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                                {
                                        $industryvalue=$myrow["industry"];
                                }
                        }
                }
                if($dealtype >0)
                        $dealtypesql= "select DealType from dealtypes where DealTypeId=$dealtype";
                elseif(($dealtype=="--") && ($hide_pms==1))
                        $dealtypesql= "select DealType from dealtypes where hide_for_exit=".$hide_pms;
                //echo "<Br>***** ".$dealtypesql;
                        if ($dealtypers = mysql_query($dealtypesql))
                        {
                                While($myrow=mysql_fetch_array($dealtypers, MYSQL_BOTH))
                                {
                                        $dealtypevalue=$myrow["DealType"];
                                }
                        }

        //echo "<bR>%%%%%%".$dealtypevalue;
        if($investorType !="--")
        {
               $invTypeSql= "select InvestorTypeName from investortype where InvestorType='$investorType'";
               if ($invrs = mysql_query($invTypeSql))
               {
                  While($myrow=mysql_fetch_array($invrs, MYSQL_BOTH))
                  {
                     $invtypevalue=$myrow["InvestorTypeName"];
                  }
               }
        }
        //echo "<br>**".$exitstatusvalue;
        if($exitstatusvalue=="0")
        {$exitstatusdisplay="Partial Exit"; }
        //echo "<bR>111";}
        elseif($exitstatusvalue=="1")
        {$exitstatusdisplay="Complete Exit";}
        //echo "<bR>222";}
        elseif($exitstatusvalue=="--")
        {$exitstatusdisplay=""; }
        //echo "<bR>333";}
        if(($startRangeValue != "--")&& ($endRangeValue != ""))
        {
         $startRangeValue=$startRangeValue;
        $endRangeValue=$endRangeValue-0.01;
        }

                        $aggsql= "select count(pe.MandAId) as totaldeals,sum(pe.DealAmount)
                                as totalamount from manda as pe,industry as i,pecompanies as pec where";
                        if (($acquirersearch == "") && ($companysearch=="") && ($searchallfield=="") && ($investorsearch=="") && ($advisorsearchstring_legal=="")  && ($advisorsearchstring_trans=="")&& ($industry =="--") &&  ($dealtype == "--")  && ($invType == "--")  && ($exitstatusvalue=="--") &&  ($range == "--") && ($month1 == "--")  && ($year1 == "--") && ($month2 == "--") && ($year2 == "--"))
                        {
                                //echo "<br>Query for all records";
                                $yourquery=0;

                                 $companysql = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
                                 DealAmount, website, MandAId,Comment,MoreInfor,hideamount,hidemoreinfor,DATE_FORMAT(DealDate,'%b-%Y') as period
                                                 FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt
                                                 WHERE pec.industry = i.industryid
                                                 AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and
                                                  pec.industry !=15" .$addVCFlagqry .$addhide_pms_qry.
                                                 " order by companyname";
                                                 $fetchRecords=true;
                                                $fetchAggregate==false;
                                //echo "<br>all records" .$companysql;
                        }
                        elseif ($companysearch != "")
                        {
                                $yourquery=1;
                                $datevalueDisplay1="";
                                $companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business,
                                pe.DealAmount,website, MandAId,Comment,MoreInfor,hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period FROM
                                manda AS pe, industry AS i, pecompanies AS pec ,dealtypes dt
                                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID
                                AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry . $addhide_pms_qry .
                                " AND ( pec.companyname LIKE '%$companysearch%'
                                OR sector_business LIKE '%$companysearch%')
                                order by companyname";
                                $fetchRecords=true;
                                $fetchAggregate==false;
                        //	echo "<br>Query for company search";
                        // echo "<br> Company search--" .$companysql;
                        }
                        elseif ($searchallfield != "")
                        {
                                $yourquery=1;
                                $datevalueDisplay1="";
                                $companysql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business,
                                pe.DealAmount,website, MandAId,Comment,MoreInfoReturns,hideamount,InvestmentDeals,DATE_FORMAT(DealDate,'%b-%Y') as period FROM
                                manda AS pe, industry AS i, pecompanies AS pec ,dealtypes as dt
                                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID
                                AND pe.Deleted =0 and pec.industry != 15 " .$addVCFlagqry . $addhide_pms_qry.
                                " AND ( pec.companyname LIKE '%$searchallfield%'
                                OR sector_business LIKE '%$searchallfield%' or  MoreInfoReturns LIKE '%$searchallfield%' or  InvestmentDeals LIKE '%$searchallfield%')
                                order by companyname";
                                $fetchRecords=true;
                                $fetchAggregate==false;
                        //	echo "<br>Query for company search";
                        // echo "<br> Company search--" .$companysql;
                        }

                        elseif($investorsearch!="")
                        {
                                $yourquery=1;
                                $datevalueDisplay1="";
                                $companysql="select pe.PECompanyId,c.companyname,c.industry,i.industry,
                                pe.DealAmount,pe.MandAId,peinv_inv.InvestorId,
                                inv.Investor,hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period from
                                manda_investors as peinv_inv,
                                peinvestors as inv,
                                manda as pe,
                                pecompanies as c,industry as i,dealtypes as dt where
                                pe.MandAId=peinv_inv.MandAId and Deleted =0 and
                                inv.InvestorId=peinv_inv.InvestorId and c.industry = i.industryid and
                                 c.PECompanyId=pe.PECompanyId and c.industry != 15 " .$addVCFlagqry . $addhide_pms_qry.
                                " AND inv.investor like '%$investorsearch%' order by companyname";
                                $fetchRecords=true;
                                $fetchAggregate==false;
                                //echo "<br> Investor search- ".$companysql;


                        }
                        elseif($acquirersearch!="")
                        {
                                $yourquery=1;
                                $datevalueDisplay1="";
                                $companysql="SELECT pe.MandAId,pe.PECompanyId, c.companyname, c.industry, i.industry, sector_business,
                                pe.DealAmount, hideamount, pe.AcquirerId, ac.Acquirer,DATE_FORMAT(DealDate,'%b-%Y') as period
                                FROM acquirers AS ac, manda AS pe, pecompanies AS c, industry AS i ,dealtypes as dt
                                WHERE ac.AcquirerId = pe.AcquirerId
                                AND c.industry = i.industryid
                                AND c.PECompanyId = pe.PECompanyId and Deleted=0
                                AND c.industry !=15 " .$addVCFlagqry . $addhide_pms_qry.
                                " AND ac.Acquirer LIKE '%$acquirersearch%'
                                order by companyname ";
                                $fetchRecords=true;
                                $fetchAggregate==false;
                                //echo "<br> Acquirer search- ".$companysql;
                        }
                        elseif($advisorsearchstring_legal!="")
                        {

                                $yourquery=1;
                                $datevalueDisplay1="";
                                $companysql="(select pe.MandAId,pe.PECompanyId,c.companyname,i.industry,c.sector_business,pe.DealAmount,
                                cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.AcquirerId, ac.Acquirer,hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period
                                from manda AS pe, pecompanies AS c, industry AS i,advisor_cias AS cia,peinvestments_advisoracquirer AS adac,acquirers as ac,
                                dealtypes as dt
                                where
                                Deleted=0 and c.industry=i.industryid and ac.AcquirerId=pe.AcquirerId  " .$addVCFlagqry . $addhide_pms_qry.
                                " and c.PECompanyId=pe.PECompanyId and adac.CIAId=cia.CIAID and  AdvisorType='L' and 
                                adac.PEId=pe.MandAId and cia.cianame LIKE '%$advisorsearchstring_legal%')
                                UNION
                                (SELECT pe.MandAId, pe.PECompanyId, c.companyname, i.industry, c.sector_business, pe.DealAmount, cia.CIAId,
                                cia.cianame, adcomp.CIAId AS CompCIAId, pe.AcquirerId, ac.Acquirer,hideamount ,DATE_FORMAT(DealDate,'%b-%Y') as period
                                FROM manda AS pe, pecompanies AS c, industry AS i, advisor_cias AS cia,
                                peinvestments_advisorcompanies AS adcomp, acquirers AS ac ,dealtypes as dt
                                WHERE Deleted=0 and c.industry = i.industryid
                                AND ac.AcquirerId = pe.AcquirerId " .$addVCFlagqry . $addhide_pms_qry .
                                " AND c.PECompanyId = pe.PECompanyId
                                AND adcomp.CIAId = cia.CIAID  and AdvisorType='L'
                                AND adcomp.PEId = pe.MandAId
                                AND cianame LIKE '%$advisorsearchstring_legal%')
                                ORDER BY companyname";
                                $fetchRecords=true;
                                $fetchAggregate==false;
                        //echo "<br> Advisor Acquirer search- ".$companysql;
                        }
                        elseif($advisorsearchstring_trans!="")
                        {

                                $yourquery=1;
                                $datevalueDisplay1="";
                                $companysql="(select pe.MandAId,pe.PECompanyId,c.companyname,i.industry,c.sector_business,pe.DealAmount,
                                cia.CIAId,cia.Cianame,adac.CIAId AS AcqCIAId,pe.AcquirerId, ac.Acquirer,hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period
                                from manda AS pe, pecompanies AS c, industry AS i,advisor_cias AS cia,peinvestments_advisoracquirer AS adac,acquirers as ac,
                                dealtypes as dt
                                where
                                Deleted=0 and c.industry=i.industryid and ac.AcquirerId=pe.AcquirerId  " .$addVCFlagqry  .$addhide_pms_qry.
                                " and c.PECompanyId=pe.PECompanyId and adac.CIAId=cia.CIAID and  AdvisorType='T' and
                                adac.PEId=pe.MandAId and cia.cianame LIKE '%$advisorsearchstring_trans%')
                                UNION
                                (SELECT pe.MandAId, pe.PECompanyId, c.companyname, i.industry, c.sector_business, pe.DealAmount, cia.CIAId,
                                cia.cianame, adcomp.CIAId AS CompCIAId, pe.AcquirerId, ac.Acquirer,hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period
                                FROM manda AS pe, pecompanies AS c, industry AS i, advisor_cias AS cia,
                                peinvestments_advisorcompanies AS adcomp, acquirers AS ac,dealtypes as dt
                                WHERE Deleted=0 and c.industry = i.industryid
                                AND ac.AcquirerId = pe.AcquirerId " .$addVCFlagqry . $addhide_pms_qry.
                                " AND c.PECompanyId = pe.PECompanyId
                                AND adcomp.CIAId = cia.CIAID  and AdvisorType='T'
                                AND adcomp.PEId = pe.MandAId
                                AND cianame LIKE '%$advisorsearchstring_trans%')
                                ORDER BY companyname";
                                $fetchRecords=true;
                                $fetchAggregate==false;
                        //echo "<br> Advisor Acquirer search- ".$companysql;
                        }

                        elseif (($industry > 0) || ($dealtype != "--") || ($invType != "--") || ($exitstatusvalue!="--") || ($range != "--") || (($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--")) ||(($txtfrm>=0) && ($txtto>0)) )
                        {
                                $yourquery=1;

                                $dt1 = $year1."-".$month1."-01";
                                $dt2 = $year2."-".$month2."-01";

                                $companysql = "SELECT DISTINCT pe.MandAId,pe.PECompanyId, pec.companyname, pec.industry, i.industry,
                                sector_business, pe.DealAmount, i.industry, hideamount,DATE_FORMAT(DealDate,'%b-%Y') as period
                                FROM manda AS pe, industry AS i, pecompanies AS pec,dealtypes as dt,manda_investors as mandainv where";

                                if ($industry > 0)
                                {
                                        $whereind = " pec.industry=" .$industry ;
                                        $qryIndTitle="Industry - ";
                                }
                                if ($dealtype!= "--")
                                {
                                        $wheredealtype = " pe.DealTypeId =" .$dealtype;
                                        $qryDealTypeTitle="Deal Type - ";
                                }
                                 if ($invType!= "--")
                                {
                                    $qryInvType="Investor Type - " ;
                                    $whereInvType = " pe.InvestorType = '".$investorType."'";
                                }
                                if($exitstatusvalue!="--")
                                {    $whereexitstatus=" pe.ExitStatus=".$exitstatusvalue;  }
                                if ($range!= "--")
                                {
                                        $qryRangeTitle="Deal Range (US $M)- ";
                                        //if($startRangeValue < $endRangeValue)
                                        //{
                                        //	$whererange = " pe.DealAmount between  ".$startRangeValue ." and ". $endRangeValue ."";
                                        //}
                                        //elseif($startRangeValue = $endRangeValue)
                                        //{
                                        //	$whererange = " pe.DealAmount >= ".$startRangeValue ."";
                                        //}

                                }

                                if(($month1 != "--") && ($year1 != "--")  && ($month2 !="--") && ($year2 != "--"))
                                {
                                        $qryDateTitle ="Period - ";
                                        $wheredates= " DealDate between '" . $dt1. "' and '" . $dt2 . "'";
                                }
                                //echo "<bR>--" .$wheredates;
                                if(trim($txtfrm>0) && trim($txtto==""))
                        {
                               $qryReturnMultiple="Return Multiple - ";
                               $whereReturnMultiple=" ipoinv.MultipleReturn > " .$txtfrm  ;
                        }
                        elseif(trim($txtfrm=="") && trim($txtto>0))
                        {
                               $qryReturnMultiple="Return Multiple - ";
                               $whereReturnMultiple=" ipoinv.MultipleReturn < " .$txtto  ;
                        }
                        elseif(trim($txtfrm>  0) && trim($txtto >0))
                        {
                               $qryReturnMultiple="Return Multiple - ";
                               $whereReturnMultiple=" ipoinv.MultipleReturn > " .$txtfrm . " and  ipoinv.MultipleReturn <".$txtto;
                        }


                                if ($whereind != "")
                                {
                                        $companysql=$companysql . $whereind ." and ";
                                        $aggsql=$aggsql . $whereind ." and ";
                                        $bool=true;
                                }
                                if (($wheredealtype != ""))
                                {
                                        $companysql=$companysql . $wheredealtype . " and " ;
                                        $aggsql=$aggsql . $wheredealtype . " and " ;
                                        $bool=true;
                                }
                                if (($whereInvType != "") )
                                {
                                                   $companysql=$companysql .$whereInvType . " and ";
                                                   $aggsql = $aggsql . $whereInvType ." and ";
                                                   $bool=true;
                                }
                                 if($whereexitstatus!="")
                              {
                                $companysql=$companysql .$whereexitstatus . " and ";
                              }
                                if (($whererange != "") )
                                {
                                        $companysql=$companysql .$whererange . " and ";
                                        $aggsql=$aggsql .$whererange . " and ";
                                        $bool=true;
                                }
                                if(($wheredates !== "") )
                                {
                                        $companysql = $companysql . $wheredates ." and ";
                                        $aggsql = $aggsql . $wheredates ." and ";
                                        $bool=true;
                                }
                                if($whereReturnMultiple!= "")
                                 {
                                 $companysql = $companysql . $whereReturnMultiple ." and ";
                                 }

                                $companysql = $companysql . "  i.industryid=pec.industry and  pec.PEcompanyID = pe.PECompanyID
                                and  mandainv.MandAId=pe.MandAId
                                and pec.industry != 15 and pe.Deleted=0 " .$addVCFlagqry . $addhide_pms_qry.
                                                 " order by companyname ";
                                $fetchRecords=true;
                                $fetchAggregate==false;
                                //echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
                        }
                        else
                        {
                                echo "<br> INVALID DATES GIVEN ";
                                $fetchRecords=false;
                                $fetchAggregate==false;
                        }

?>

<?php 
	$topNav = 'Deals';
	include_once('header_search.php');
?>




<div id="container">
<table cellpadding="0" cellspacing="0" width="100%">
<tr>
<td class="left-box">

<?php include_once('pema_refine.php');?>

</td>
 <?php

				$exportToExcel=0;
			 $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin,Student from dealcompanies as dc,dealmembers as dm
										where dm.EmailId='$UserEmail' and dc.DCompId=dm.DCompId";
			//echo "<br>---" .$TrialSql;
			if($trialrs=mysql_query($TrialSql))
			{
				while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
				{
					$exportToExcel=$trialrow["TrialLogin"];
					$studentOption=$trialrow["Student"];
				}
			}

			if($yourquery==1)
				$queryDisplayTitle="Query:";
			elseif($yourquery==0)
				$queryDisplayTitle="";
					if(trim($buttonClicked==""))
					{
						$totalDisplay="Total";
				    	$industryAdded ="";
				    	$totalAmount=0.0;
				    	$totalInv=0;
						$compDisplayOboldTag="";
						$compDisplayEboldTag="";
				 	  //echo "<br> query final-----" .$companysql;
				 	      /* Select queries return a resultset */
						 if ($companyrs = mysql_query($companysql))
						 {
						    $company_cnt = mysql_num_rows($companyrs);
						 }

				           if($company_cnt > 0)
				           {
				           		//$searchTitle=" List of Deals";
				           }
				           else
				           {
				              	$searchTitle= $searchTitle ." -- No Deal(s) found for this search ";
				              	$notable=true;
				              	writeSql_for_no_records($companysql,$emailid);
				           }


		           ?>


<td>
<div style="float:right;padding: 20px"><b>See More Info :</b> <input type=text name="searchallfield"></div>
<div class="result-cnt">
					<div class="result-title">
                                            
                        	<?php if(!$_POST){
                                   // echo $VCFlagValue;
                                   if($VCFlagValue==0)
                                   {
                                     ?>
                                           <h2><?php echo @mysql_num_rows($companyrs); ?> results for PE Investments </h2>
                              <?php }
                                    else
                                    {?>
                                           <h2><?php echo @mysql_num_rows($companyrs); ?> results for VC Investments </h2>
                              <?php } 
                             
                                   }
                                   else 
                                   {
                                   if($VCFlagValue==0)
                                   { ?>
                                            <h2><?php echo @mysql_num_rows($companyrs); ?> results for PE Investments</h2>
                             <?php }
                                else
                                   {?>
                                            <h2><?php echo @mysql_num_rows($companyrs); ?> results for VC Investments</h2>
                             <?php } ?>
                            <ul>
                                <?php
                                 //echo $queryDisplayTitle;
                                if($industry >0 )
                                    echo "<li>".$industryvalue."</li>";
                                if($stagevaluetext!="")
                                    echo "<li>".$stagevaluetext."</li>";
                                if($companyType!="--")
                                    echo "<li>".$companyTypeDisplay."</li>";
                                if($investorType !="--")
                                    echo "<li>".$invtypevalue."</li>";
                                if($regionId>0)
                                    echo "<li>".$regionvalue."</li>";
                                
                                if (($startRangeValue!= "--") && ($endRangeValue != ""))
                                    echo "<li>(USM)".$startRangeValue ."-" .$endRangeValueDisplay."</li>";
                                if($datevalueDisplay1!="")
                                    echo "<li>".$datevalueDisplay1. "-" .$datevalueDisplay2."</li>";
                                if($keyword!="")
                                    echo "<li>".$keyword."</li>";
                                if($companysearch!="")
                                    echo "<li>".$companysearch."</li>";
										if($sectorsearch!="")
                                    echo "<li>".$sectorsearch."</li>";
                                if($advisorsearchstring_legal!="")
                                    echo "<li>".$advisorsearchstring_legal."</li>";
                                if($advisorsearchstring_trans!="")
                                    echo "<li>".$advisorsearchstring_trans."</li>";
                                if($searchallfield!="")
                                    echo "<li>".$searchallfield."</li>";
                                ?>
                             </ul>
                             <?php } ?>
                        </div>

					
					<?php
						if($notable==false)
						{ 
					?>
                        <div class="veiw-tab"><ul>
                        <li class="active"><a href="index.php"><i class="i-list-view"></i>List View</a></li>
                        <?php
						$count=0;
						 While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
						{
							if($count == 0)
							{
								 $comid = $myrow["PEId"];
								$count++;
							}
						}
						?>
                        <li><a href="dealdetails.php?value=<?php echo $comid;?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>"><i class="i-profile-view"></i>Deal Details View</a></li>
                        <li><a href="trendview.php?type=1"><i class="i-trend-view"></i>Trend View</a></li>
                        </ul></div>	





						<!--<div id="headingtextproboldfontcolor"> <?php echo $searchTitle; ?> <br />  </div>
						<div id="headingtextprosmallfont">Note: Target/Company in () indicates tranche rather than a new round. </div>
						<div id="headingtextprosmallfont"> Target/Company in [] indicates a debt investment. Not included in aggregate data. </div>-->

										
						<div class="view-table">
                            <table width="100%" border="0" cellspacing="0" cellpadding="0" id="myTable">
                              <thead><tr>
                                <th>&nbsp;</th>
                                <th>Company</th>
                                <!--<th>Industry</th>-->
                                <th>Sector</th>
                                <th>Date</th>
                                <th>Amount</th>
                                <!--<th>Deal Info</th>-->
                                <!--<th>Round</th>
                                <th class="stage-col">Stage</th>
                                <th class="investors-col">Investors</th>
                                <th class="investor-type-col">Investor Type</th>
                                <th class="stake-col">Stake (%)</th>-->
                              </tr></thead>
                              <tbody id="movies">
							<!--	</thead>  -->
						<?php
						if ($company_cnt>0)
						  {
						  	$hidecount=0;
							mysql_data_seek($companyrs,0);
						   While($myrow=mysql_fetch_array($companyrs, MYSQL_BOTH))
							{
                                                               //SPV changed to AggHide
                                                               $amtTobeDeductedforAggHide=0;
                                                               $prd=$myrow["period"];
								if($myrow["AggHide"]==1)
								{
									$openBracket="(";
									$closeBracket=")";
									$amtTobeDeductedforAggHide=$myrow["amount"];
									$NoofDealsCntTobeDeducted=1;
								}
								else
								{
									$openBracket="";
									$closeBracket="";
									$amtTobeDeductedforAggHide=0;
									$NoofDealsCntTobeDeducted=0;
								}
                                                                if($myrow["SPV"]==1)          //Debt
								{
									$openDebtBracket="[";
									$closeDebtBracket="]";
									$amtTobeDeductedforDebt=$myrow["amount"];
									$amtTobeDeductedforAggHide= $myrow["amount"];
									$NoofDealsCntTobeDeductedDebt=1;
									$NoofDealsCntTobeDeducted=1;
								}
								else
								{
									$openDebtBracket="";
									$closeDebtBracket="";
									$amtTobeDeductedforDebt=0;
									$NoofDealsCntTobeDeductedDebt=0;
								}

								if(trim($myrow[17])=="")
								{
									$compDisplayOboldTag="";
									$compDisplayEboldTag="";
								}
								else
								{
									$compDisplayOboldTag="<b><i>";
									$compDisplayEboldTag="</b></i>";
								}
								if($myrow["hideamount"]==1)
								{
									$hideamount="--";
									$hidecount=$hidecount+1;
								}
								else
								{
									$hideamount=$myrow["DealAmount"];
								}
								if($myrow["amount"]==0)
								{
								   $NoofDealsCntTobeDeducted=1;
								}
								if(($vcflagValue==0)||($vcflagValue==1))
								{
									if(trim($myrow["sector_business"])=="")
										$showindsec=$myrow["industry"];
									else
										$showindsec=$myrow["sector_business"];
								}

								$companyName=trim($myrow["companyname"]);
								$companyName=strtolower($companyName);
								$compResult=substr_count($companyName,$searchString);
								$compResult1=substr_count($companyName,$searchString1);

					   ?>
								<!--<tbody class="scrollContent">-->
                                  
									<tr>
                                    <td>&nbsp;</td>
						<?php
								if(($compResult==0) && ($compResult1==0))
								{
								
						?>
								<td ><?php echo $openDebtBracket;?><?php echo $openBracket ; ?><a href="dealdetails.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "><?php echo trim($myrow["companyname"]);?> </a> <?php echo $closeBracket ; ?><?php echo $closeDebtBracket;?></td>
						<?php
								}
								else
								{
						?>
								<td><?php echo ucfirst("$searchString");?></td>
						<?php
								}
						?>

										<td><?php echo trim($showindsec); ?></td>
										<td><?php echo $prd; ?></td>
										<td><?php echo $hideamount; ?>&nbsp;</td>
										<!--<td>
						<?php
						if(($vcflagValue==0)||($vcflagValue==1))
						{
						?>
										<A href="dealinfo.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?> "
									   target="popup" onClick="MyWindow=window.open('dealinfo.php?value=<?php echo $myrow["PEId"];?>/<?php echo $vcflagValue;?>/<?php echo $searchallfield;?>','popup','scrollbars=1,width=580,height=400,status=0,toolbar=no,menubar=no,location=0');MyWindow.focus(top);return false">
									   click here


						<?php
						}

						elseif($vcflagValue==2)
						{
						?>
								<A href="redealinfo.php?value=<?php echo $myrow["PEId"];?> "
								target="popup" onclick="MyWindow=window.open('redealinfo.php?value=<?php echo $myrow["PEId"];?>', 'popup', 'scrollbars=1,width=500,height=400,status=no');MyWindow.focus(top);return false">
								click here

						<?php
						}
						?>
								 	</A>   </td>-->
									</tr>
								<!--</tbody>-->
							<?php
								$industryAdded = $myrow[2];
								$totalInv=$totalInv+1-$NoofDealsCntTobeDeducted;
								$totalAmount=$totalAmount+ $myrow["amount"]-$amtTobeDeductedforAggHide;

							}
						}
						?>
                        </tbody>
                  </table>
                       
                </div>			
			<?php
					}
				} 
			?>
             <div class="holder"></div>
            <div>&nbsp;</div>
            <div>&nbsp;</div>
            <?php

				if($studentOption==1)

				{

			?>

					

					<div id="headingtextproboldbcolor">&nbsp; No. of Deals  - <?php echo $totalInv; ?> 	Amount (US$ M)

					<?php echo $totalAmount; ?>  <br /></div>

			<?php



			if($exportToExcel==1)

			{

                        ?>

                          <span>

			        To Export the above deals into a Spreadsheet,&nbsp;<input type="submit"  value="Click Here" name="showdeals">

			        </span>

			<?php

			}

		}

		else

		{



				if($exportToExcel==1)

				{

				?>

					<div id="headingtextproboldbcolor">&nbsp; No. of Deals  - <?php echo $totalInv; ?> Amount (US$ M)

				<?php echo $totalAmount; ?> <br /></div>



				<?php

				}



				else

				{

				?>

					<div id="headingtextproboldbcolor">&nbsp;No. of Deals - XX &nbsp;&nbsp;&nbsp;&nbsp;Value (US$ M) - YYY <br />Aggregate data for each search result is displayed here for Paid Subscribers <br /></div>



				<?php

				}



					if(($totalInv>0) &&  ($exportToExcel==1))

					{

				?>

						<span>

								To Export the above deals into a Spreadsheet,&nbsp;<input type="submit"  value="Click Here" name="showdeals">

						</span>

				<?php

					}

					elseif(($totalInv<=0) &&  ($exportToExcel==1))

					{

					}

					elseif(($totalInv>0) && ($exportToExcel==0))

					{

				?>
                		<div>

						<span>

						<b>Note:</b> Only paid subscribers will be able to export data on to Excel.

						<a target="_blank" href="<?php echo $samplexls;?> "><u>Click Here</u> </a> for a sample spreadsheet containing PE investments

						</span>
                        </div>



				<?php



					}

		}

				?>

			
            
            
     
    </div>

</td>

</tr>
</table>
 
</div>
<div class=""></div>

</div>
</form>
</body>
</html>

<?php
	function returnMonthname($mth)
		{
			if($mth==1)
				return "Jan";
			elseif($mth==2)
				return "Feb";
			elseif($mth==3)
				return "Mar";
			elseif($mth==4)
				return "Apr";
			elseif($mth==5)
				return "May";
			elseif($mth==6)
				return "Jun";
			elseif($mth==7)
				return "Jul";
			elseif($mth==8)
				return "Aug";
			elseif($mth==9)
				return "Sep";
			elseif($mth==10)
				return "Oct";
			elseif($mth==11)
				return "Nov";
			elseif($mth==12)
				return "Dec";
	}
function writeSql_for_no_records($sqlqry,$mailid)
 {
 $write_filename="pe_query_no_records.txt";
 //echo "<Br>***".$sqlqry;
					$schema_insert="";
					//TRYING TO WRIRE IN EXCEL
								 //define separator (defines columns in excel & tabs in word)
									 $sep = "\t"; //tabbed character
									 $cr = "\n"; //new line

									 //start of printing column names as names of MySQL fields

										print("\n");
										 print("\n");
									 //end of printing column names
									 		$schema_insert .=$cr;
									 		$schema_insert .=$mailid.$sep;
											$schema_insert .=$sqlqry.$sep;
										        $schema_insert = str_replace($sep."$", "", $schema_insert);
									    $schema_insert .= ""."\n";

									 		if (file_exists($write_filename))
											{
												//echo "<br>break 1--" .$file;
												 $fp = fopen($write_filename,"a+"); // $fp is now the file pointer to file
													 if($fp)
													 {//echo "<Br>-- ".$schema_insert;
														fwrite($fp,$schema_insert);    //    Write information to the file
														  fclose($fp);  //    Close the file
														// echo "File saved successfully";
													 }
													 else
														{
														echo "Error saving file!"; }
											}

							         print "\n";

 }

?>
