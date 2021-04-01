<?php include_once("../globalconfig.php"); ?>
<?php
//session_save_path("/tmp");
//session_start();

require("../dbconnectvi.php");
$Db = new dbInvestments();
if(!isset($_SESSION['UserNames']))
	{
	header('Location:../pelogin.php');
	}
	else
	{
//Check Session Id 
$sesID=session_id();
$emailid=$_SESSION['UserEmail'];
$sqlUserLogSel = "SELECT `sessionId` FROM `user_log` WHERE `emailId`='".$emailid."' AND `dbTYpe`='PE'";
$resUserLogSel = mysql_query($sqlUserLogSel);
$cntUserLogSel = mysql_num_rows($resUserLogSel);
if ($cntUserLogSel > 0){
    $resUserLogSel = mysql_fetch_array($resUserLogSel);
    $logSessionId = $resUserLogSel['sessionId'];
    if ($logSessionId != $sesID){
        header( 'Location: logoff.php?value=caccess' ) ;
    }
}

// Start T960
$exportvalue=$_POST['resultarray'];
if($exportvalue == "Select-All"){
    $exportvalue = "PortfolioCompany,YearFounded,PEFirm,InvestorType,ExitStatus,InvestorSale,Industry,SectorBusinessDescription,Website,Date,IPOSize,Price,IPOValuation,SellingInvestors,AddlnInfo,InvestmentDetails,ReturnMultiple,IRR,MoreInfoReturns,CompanyValuation,RevenueMultiple,EBITDAMultiple,PATMultiple,PricetoBook,ValuationMoreInfo,Revenue,EBITDA,PAT,BookValuePerShare,PricePerShare,LinkforFinancials";    
}
$expval=explode(",",$exportvalue);
// end T960

function updateDownload($res){
    //Added By JFR-KUTUNG - Download Limit
    $recCount = mysql_num_rows($res);
    $dlogUserEmail = $_SESSION['UserEmail'];
    $today = date('Y-m-d');

    //Check Existing Entry
   $sqlSelCount = "SELECT `recDownloaded`  FROM `user_downloads` WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
   $sqlSelResult = mysql_query($sqlSelCount) or die(mysql_error());
   $rowSelCount = mysql_num_rows($sqlSelResult);
   $rowSel = mysql_fetch_object($sqlSelResult);
   $downloads = $rowSel->recDownloaded;

   if ($rowSelCount > 0){
       $upDownloads = $recCount + $downloads;
       $sqlUdt = "UPDATE `user_downloads` SET `recDownloaded`='".$upDownloads."' WHERE `emailId` = '".$dlogUserEmail."' AND `dbType`='PE' AND `downloadDate` = CURRENT_DATE";
       $resUdt = mysql_query($sqlUdt) or die(mysql_error());
   }else{
       $sqlIns = "INSERT INTO `user_downloads` (`user_id`,`emailId`,`downloadDate`,`dbType`,`recDownloaded`) VALUES ('0','".$dlogUserEmail."','".$today."','PE','".$recCount."')";
       mysql_query($sqlIns) or die(mysql_error());
   }
}        
      

//	include('onlineaccount.php');
		$displayMessage="";
		$mailmessage="";

//Removed advisor search display in the mail.PLEASE ADD when its added in the ipoinput.php
//	Advisor$advisorsearch

				//global $LoginAccess;
				//global $LoginMessage;
				$TrialExpired="Your email login has expired. Please contact info@ventureintelligence.com";

                                $companyIdDel=1718772497;
                                $companyIdSGR=390958295;
                                $companyIdVA=38248720;
                                $companyIdGlobal=730002984;
                                $addDelind="";

                                $submitemail=$_POST['txthideemail'];
                                //variable that differentiates, PE/VC/RealEstate
                                $searchtitle=$_POST['txttitle'];
                                

                                //VCFLAG VALUE
                                $hidesearchon=$_POST['txtsearchon'];

                                $industry=$_POST['txthideindustryid'];
                                $hideindustrytext=$_POST['txthideindustry'];
                                $invtypevalue=$_POST['txthideinvtype'];
                                $invType=$_POST['txthideinvtypeid'];
                                $investor_head=$_POST['invhead'];
                                $exitstatusvalue=$_POST['txthideexitstatusvalue'];
                                $investorsale=$_POST['txthideinvestorSale'];
                                //echo "<br>**".$investorsale;
                                $keyword=$_POST['txthideinvestor'];
                                $yearafter=$_POST['yearafter'];
                                $yearbefore=$_POST['yearbefore'];
                                $tagsearch      = $_POST['tagsearch'];
                                $tagandor       = $_POST['tagandor'];
                
                                if($keyword!="")
                                    $keyword =ereg_replace("-"," ",$keyword);
                                else 
                                    $keyword =" ";

                                $companysearch=$_POST['txthidecompany'];
                                $companysearch=ereg_replace("-"," ",$companysearch);

                                $searchallfield=$_POST['txthidesearchallfield'];
                                $searchallfield =ereg_replace("-"," ",$searchallfield);

                                $hidedateStartValue=$_POST['txthidedateStartValue'];
                                $hidedateEndValue=$_POST['txthidedateEndValue'];
                              
                                if(($hidedateStartValue != "--") && ($hidedateEndValue != "--"))
                                {
                                        $wheredates1= " and IPODate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'";
                                }
                                $dateValue=$_POST['txthidedate'];

                                $hidetxtfrm=$_POST['txthideReturnMultipleFrm'];
                                $hidetxtto=$_POST['txthideReturnMultipleTo'];


                                $whereexitstatus="";
                                $submitemail=$_POST['txthideemail'];
                                $txthidepe=$_POST['txthidepe'];
                                $hideWhere = '';
                                $tsjtitle="&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.";
                                $GetCompId="select dm.DCompId,dc.DCompId from dealcompanies as dc,dealmembers as dm
										where dm.EmailId='$submitemail' and dc.DCompId=dm.DCompId";
                                if($trialrs=mysql_query($GetCompId))
                                {
                                        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                                        {
                                                $compId=$trialrow["DCompId"];
                                        }
                                }
                                if($searchtitle==0)
                                {
                                    if($compId==$companyIdDel)
                                    {
                                      $addDelind = " and (pec.industry=9 or pec.industry=24)";
                                    }
                                    if($compId==$companyIdSGR)
                                    {
                                      $addDelind = " and (pec.industry=3 or pec.industry=24)";
                                    }
                                    if($compId==$companyIdVA)
                                    {
                                      $addDelind = " and (pec.industry=1 or pec.industry=3)";
                                    }
                                     if($compId==$companyIdGlobal)
                                              {
                                                $addDelind = " and (pec.industry=24)";
                                              }
                                }
                                else{
                                  if($compId==$companyIdGlobal)
                                  {
                                    $addDelind = " and (pec.industry=24)";
                                  }
                              }
                                    if($searchtitle==0)
                                    {
                                            $addVCFlagqry = "" ;
                                            $searchTitle = "List of PE-backed IPOs ";
                                    }
                                    elseif($searchtitle==1)
                                    {
                                            $addVCFlagqry = " and VCFlag=1 ";
                                            $searchTitle = "List of VC-backed IPOs ";
                                    }
                                
				/*echo "<br>Industry Id-----------------**".$hideindustryid;
				echo "<br>Inv type id-----------------**".$invtypevalueid;
				echo "<br>Start Range Value-----------------**".$hiderangeStartValue;
				echo "<br>End Range value-----------------**".$hiderangeEndValue;
				*/
				//echo "<br>start Date-----------------**".$hidedateStartValue;
				//echo "<br>End Date-----------------**".$hidedateEndValue;
				//echo "<br>Date text-----------------**".$dateValue;
				//echo "<br>Deal Type---**". $dealtype;

                        if($_SESSION['PE_industries']!=''){

                                $comp_industry_id_where = ' AND pec.industry IN ('.$_SESSION['PE_industries'].') ';
                        }
			if (($keyword == "") && ($companysearch=="") &&  ($searchallfield=="") && ($advisorsearch=="") && ($industry =="--")  && ($invType == "--") && ($exitstatusvalue=="--") && ($investorsale=="--") && ($hidedateStartValue == "------01") && ($hidedateEndValue == "------01"))
                        {
                            if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                                $hideWhere = " and pe.IPOId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                            }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                                 $hideWhere = " and pe.IPOId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                            }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                               $hideWhere = " and pe.IPOId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                            }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                                 $hideWhere = " and pe.IPOId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                            }else{
                                 $hideWhere = " ";
                            }

                            $companysql = "SELECT  pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,
                            pe.PECompanyId,pec.industry,pec.companyname, i.industry, pec.sector_business,
                            DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate ,pe.IPOSize,pe.IPOAmount, pe.IPOValuation,
                            pec.website, MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,
                            it.InvestorTypeName,
                            Company_Valuation,Sales_Multiple,EBITDA_Multiple,Netprofit_Multiple,InvestorSale,SellingInvestors,
                            Valuation,FinLink,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pec.yearfounded
                            FROM ipos AS pe, industry AS i, pecompanies AS pec ,investortype as it
                             WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID  and it.InvestorType=pe.InvestorType " .$wheredates1. "
                            and pe.Deleted=0" .$addVCFlagqry.$addDelind.$hideWhere.$comp_industry_id_where.
                           " order by companyname";

				//echo "<br>3 Query for All records" .$companysql;
                        }
                        elseif ($companysearch != "")
                        {
                            if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                                $hideWhere = " and pe.IPOId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                            }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                                 $hideWhere = " and pe.IPOId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                            }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                               $hideWhere = " and pe.IPOId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                            }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                                 $hideWhere = " and pe.IPOId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                            }else{
                                 $hideWhere = " ";
                            }

                            $companysql="SELECT  pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,pe.PECompanyId,pec.industry, pec.companyname, i.industry, pec.sector_business,
                             DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate,pe.IPOSize,pe.IPOAmount, pe.IPOValuation,
                            pec.website,MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns ,
                            it.InvestorTypeName,
                            Company_Valuation,Sales_Multiple,EBITDA_Multiple,Netprofit_Multiple,InvestorSale,SellingInvestors,
                            Valuation,FinLink ,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pec.yearfounded
                            FROM ipos AS pe, industry AS i,	pecompanies AS pec ,investortype as it
                            WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and it.InvestorType=pe.InvestorType " .$wheredates1. " 
                            AND pe.Deleted =0 " .$addVCFlagqry.$addDelind.$hideWhere.$comp_industry_id_where. " AND ( pec.PECompanyId IN ($companysearch))
                            order by companyname";
                                //	echo "<br>Query for company search";
                                //	 echo "<br> Company search--" .$companysql;
                        }
                        elseif($keyword != " ")
                        {
                            if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                                $hideWhere = " and pe.IPOId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                            }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                                 $hideWhere = " and pe.IPOId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                            }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                               $hideWhere = " and pe.IPOId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                            }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                                 $hideWhere = " and pe.IPOId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                            }else{
                                 $hideWhere = " ";
                            }

                                $companysql="select peinv.IPOId,peinv.IPOId, peinv.PECompanyId,c.industry,peinv_inv.InvestorId,peinv_inv.IPOId,
                                inv.Investor,
                                c.companyname,i.industry,sector_business,
                                DATE_FORMAT( peinv.IPODate, '%M-%Y' )as IPODate,peinv.IPOSize,peinv.IPOAmount,peinv.IPOValuation,
                                c.website,MoreInfor,hideamount,hidemoreinfor,peinv.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns ,
                                it.InvestorTypeName,
                                Company_Valuation,Sales_Multiple,EBITDA_Multiple,Netprofit_Multiple,InvestorSale,SellingInvestors,
                                Valuation,FinLink,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,c.yearfounded
                                from ipo_investors as peinv_inv,peinvestors as inv, ipos as peinv,pecompanies as c,industry as i,investortype as it
                                where inv.InvestorId=peinv_inv.InvestorId " .$wheredates1. "  and c.industry = i.industryid
                                and peinv.IPOId=peinv_inv.IPOId and c.PECompanyId=peinv.PECompanyId and it.InvestorType=peinv.InvestorType " .$addVCFlagqry.$addDelind.$hideWhere.
                                $comp_industry_id_where." and inv.InvestorId IN($keyword) order by companyname";

//                			echo "<br> Investor search- ".$companysql;
//                                        exit();
                        }
                        elseif($advisorssearch!="")
                        {
                            if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                                $hideWhere = " and pe.IPOId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                            }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                                 $hideWhere = " and pe.IPOId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                            }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                               $hideWhere = " and pe.IPOId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                            }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                                 $hideWhere = " and pe.IPOId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                            }else{
                                 $hideWhere = " ";
                            }
                                $companysql="(SELECT peinv.IPOId, adcomp.CIAId,peinv.PECompanyId,
                                cia.CIAId, cia.cianame,	adcomp.PEId AS CompPEId, adcomp.CIAId AS CompCIAId,
                                c.companyname, i.industry,
                                c.sector_business,DATE_FORMAT( peinv.IPODate, '%M-%Y' )as IPODate,peinv.IPOSize,peinv.IPOAmount,peinv.IPOValuation,
                                peinv.website,MoreInfor,hideamount,hidemoreinfor,peinv.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns ,it.InvestorTypeName,
                                Company_Valuation,Sales_Multiple,EBITDA_Multiple,Netprofit_Multiple,InvestorSale,SellingInvestors,
                                Valuation,FinLink,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,c.yearfounded
                                FROM advisor_cias AS cia, IPOs AS peinv, pecompanies AS c, industry AS i,
                                peinvestments_advisorcompanies AS adcomp ,investortype as it
                                WHERE c.industry = i.industryid and cia.CIAId=adcomp.CIAId  and it.InvestorType=peinv.InvestorType " .$wheredates1. " 
                                AND c.PECompanyId = peinv.PECompanyId " .$addVCFlagqry.$addDelind.$hideWhere.$comp_industry_id_where.
                                " AND cia.cianame LIKE '%$advisorsearch%' and adcomp.PEId=peinv.IPOId)";
                        //	echo "<Br>Advisor search--" .$advisorsearch;
                        }
                        elseif ($tagsearch != "")
                {
                    $iftest=5;
                    $yourquery=1;
                    $datevalueDisplay1="";
                    $datevalueCheck1="";

                    $tags = '';
                    $ex_tags = explode(',',$tagsearch);
                    if(count($ex_tags) > 0){
                        for($l=0;$l<count($ex_tags);$l++){
                            if($ex_tags[$l] !=''){
                                $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                $value = str_replace(" ","",$value);
                                //$tags .= "pec.tags like '%:$value%' or ";
                                //$tags .= " pec.tags REGEXP '[[.colon.]]$value$' or pec.tags REGEXP '[[.colon.]]$value,'"; //or pec.tags REGEXP 
                               /* $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]".$value."[[:>:]]'"." or";*/
                                if($tagandor==0){
                                            $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]".$value."[[:>:]]'"." and";
                                        }else{
                                              $tags .= " REPLACE(trim(pec.tags), ' ','') REGEXP '[[:<:]]".$value."[[:>:]]'"." or";
                                        }
                            }
                        }
                    }
                    /*$tagsval = trim($tags,' or ');*/
                     if($tagandor==0){
                                            $tagsval = trim($tags,' and ');
                                        }else{
                                             $tagsval = trim($tags,' or ');
                                        }


                    $companysql="SELECT  pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,pe.PECompanyId,pec.industry, pec.companyname, i.industry, pec.sector_business,
                             DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate,pe.IPOSize,pe.IPOAmount, pe.IPOValuation,
                            pec.website,MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns ,
                            it.InvestorTypeName,
                            Company_Valuation,Sales_Multiple,EBITDA_Multiple,Netprofit_Multiple,InvestorSale,SellingInvestors,
                            Valuation,FinLink ,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pec.yearfounded
                            FROM ipos AS pe, industry AS i, pecompanies AS pec ,investortype as it
                            WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and it.InvestorType=pe.InvestorType " .$wheredates1. " 
                            AND pe.Deleted =0 and (". $tagsval." )" .$addVCFlagqry.$addDelind.$comp_industry_id_where. " order by companyname";     //  echo
                    //  echo "<br>Query for company search";
                    //  echo "<br> Company search--" .$companysql;
                }
                        elseif ($searchallfield != "")
                        {
                            if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                                $hideWhere = " and pe.IPOId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                            }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                                 $hideWhere = " and pe.IPOId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                            }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                               $hideWhere = " and pe.IPOId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                            }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                                 $hideWhere = " and pe.IPOId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                            }else{
                                 $hideWhere = " ";
                            }
                                        $findTag = strpos($searchallfield,'tag:');
                                        $findTags = "$findTag";
                                        if($findTags == ''){
                                            $tagsval = "city LIKE '$searchallfield%' or pec.companyname LIKE '%$searchallfield%'
                                OR sector_business LIKE '%$searchallfield%'  or  MoreInfor LIKE '%$searchallfield%' or  InvestmentDeals LIKE '%$searchallfield%'";                                    
                                        }else{
                                            $tags = '';
                                            $ex_tags = explode(',',$searchallfield);
                                            if(count($ex_tags) > 0){
                                                for($l=0;$l<count($ex_tags);$l++){
                                                    if($ex_tags[$l] !=''){
                                                        $value = trim(str_replace('tag:','',$ex_tags[$l]));
                                                        $tags .= "pec.tags like '%:$value%' or ";
                                                    }
                                                }
                                            }
                                            $tagsval = trim($tags,' or ');
                                        }

                                $companysql="SELECT  pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,pe.PECompanyId,pec.industry, pec.companyname, i.industry, pec.sector_business,
                                 DATE_FORMAT( IPODate, '%M-%Y' ) as IPODate,pe.IPOSize,pe.IPOAmount, pe.IPOValuation,
                                pec.website,MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns ,it.InvestorTypeName,
                                Company_Valuation,Sales_Multiple,EBITDA_Multiple,Netprofit_Multiple,InvestorSale,SellingInvestors,
                                Valuation,FinLink,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pec.yearfounded
                                FROM ipos AS pe, industry AS i,	pecompanies AS pec,investortype as it
                                WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID   and it.InvestorType=pe.InvestorType " .$wheredates1. " 
                                AND pe.Deleted =0 " .$addVCFlagqry.$addDelind.$hideWhere.$comp_industry_id_where. " AND ( $tagsval )
                                order by companyname";
                                //	echo "<br>Query for company search";
                                //	 echo "<br> Company search--" .$companysql;
                        }

                        elseif (($industry > 0) || ($exitstatusvalue!="--") || ($invType != "--") || ($investorsale!="--")|| (($datevalue!="---to---")) || (($hidetxtfrm>=0) && ($hidetxtto>0) )|| ($yearafter!="") || ($yearbefore!="") || ($investor_head != "--"))
                        {
                            if(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==1){

                                $hideWhere = " and pe.IPOId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                            }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != '' && isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != '' && $_POST['export_full_uncheck_flag']==''){

                                 $hideWhere = " and pe.IPOId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                            }elseif(isset($_POST['txthidepe']) && $_POST['txthidepe'] != ''){

                               $hideWhere = " and pe.IPOId NOT IN ( " . $_POST[ 'txthidepe' ] . " ) ";

                            }elseif(isset($_POST['export_checkbox_enable']) && $_POST['export_checkbox_enable'] != ''){

                                 $hideWhere = " and pe.IPOId IN ( " . $_POST[ 'export_checkbox_enable' ] . " ) ";

                            }else{
                                 $hideWhere = " ";
                            }
                            
                                $companysql = "select Distinct pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,pe.IPOId,
                                pe.PECompanyID,pec.industry,pec.companyname,i.industry,
                                pec.sector_business,DATE_FORMAT(IPODate,'%M-%Y') as IPODate,pe.IPOSize,IPOAmount,IPOValuation,
                                pec.website,MoreInfor,hideamount,hidemoreinfor,pe.InvestmentDeals,Link,EstimatedIRR,MoreInfoReturns,it.InvestorTypeName,
                                Company_Valuation,Sales_Multiple,EBITDA_Multiple,Netprofit_Multiple,InvestorSale,SellingInvestors,
                                Valuation,FinLink,ExitStatus,Revenue,EBITDA,PAT, price_to_book, book_value_per_share, price_per_share,pec.yearfounded
                                from ipos as pe, industry as i,pecompanies as pec,investortype as it,ipo_investors as ipoinv,peinvestors as inv where";
                                $whereind="";
                                $wheredates="";
                                if ($industry != '' && $industry != '--') {
                                    $inSql = '';
                                    $industry1 = explode(',',$industry);
                                    foreach($industry1 as $industrys)
                                    {
                                        $inSql .= " pec.industry= '".$industrys."' or ";
                                    }
                                    $inSql = trim($inSql,' or ');
                                    if($inSql !=''){
                                        $whereind=  ' ( '.$inSql.' ) ';
                                    }
                                }
                                if ($invType!= "--")
                                {
                                               $whereInvType = " pe.InvestorType = '".$invType."'";
                                }
                                if ($investor_head != "--" && $investor_head != '') {
                                       $whereInvhead = "inv.InvestorId=ipoinv.InvestorId and inv.countryid = '" . $investor_head . "'";
                                }
                                if($exitstatusvalue!="--")
                                 {   if($exitstatusvalue !="") {
                                  $whereexitstatus=" pe.ExitStatus=".$exitstatusvalue;  }
                                }
                                if($investorsale!="--")
                                 {    
                                  if($investorsale !="") {$whereinvestorSale="  pe.InvestorSale=".$investorsale;}
                                }

                                if($datevalue!="---to---")
                               {	$wheredates= " IPODate between '" . $hidedateStartValue. "' and '" . $hidedateEndValue . "'"; }

                                if(trim($hidetxtfrm=="") && trim($hidetxtto>0))
                                {
                                  $qryReturnMultiple="Return Multiple - ";
                                  $whereReturnMultiple=" ipoinv.MultipleReturn < ".$hidetxtto;
                                }
                                elseif(trim($hidetxtfrm >0) && trim($hidetxtto==""))
                                {
                                  $qryReturnMultiple="Return Multiple - ";
                                  $whereReturnMultiple=" ipoinv.MultipleReturn > ".$hidetxtfrm;
                                }
                                elseif(($hidetxtfrm>0) &&($hidetxtto > 0))
                                {
                                              $qryReturnMultiple="Return Multiple - ";
                                              $whereReturnMultiple=" ipoinv.MultipleReturn > " .$hidetxtfrm . " and  ipoinv.MultipleReturn <".$hidetxtto;
                                }
                                 if ($yearafter != '' && $yearbefore == '') {
                                    $whereyearaftersql = " pec.yearfounded >= $yearafter";
                                }

                                if ($yearbefore != '' && $yearafter == '') {
                                    $whereyearbeforesql = " pec.yearfounded <= $yearbefore";
                                }

                                if ($yearbefore != '' && $yearafter != '') {
                                    $whereyearfoundedesql = " pec.yearfounded >= $yearafter and pec.yearfounded <= $yearbefore";
                                }
                                 if ($whereyearaftersql != "") {
                                    $companysql = $companysql . $whereyearaftersql . " and ";
                                }
                                if ($whereyearbeforesql != "") {
                                    $companysql = $companysql . $whereyearbeforesql . " and ";
                                }
                                if ($whereyearfoundedesql != "") {
                                    $companysql = $companysql . $whereyearfoundedesql . " and ";
                                }   

					if ($whereind != "")
							$companysql=$companysql . $whereind ." and ";

					if (($whereInvType != "") )
								{
									$companysql=$companysql .$whereInvType . " and ";
								}
					if($whereexitstatus!="")
                                                {
                                                  $companysql=$companysql .$whereexitstatus . " and ";
                                                }
					if($whereinvestorSale!="")
                                            $companysql=$companysql .$whereinvestorSale . " and ";
					if($whereinvestorSale!="")
                                            $companysql=$companysql .$whereinvestorSale . " and ";
                                        if(($wheredates !== "") )
						$companysql = $companysql . $wheredates ." and ";
                                        if($whereReturnMultiple!= "")
                                        {
                                         $companysql = $companysql . $whereReturnMultiple ." and ";
                                        }
                                        if (($whereInvhead != "")) {
                                            $companysql = $companysql . $whereInvhead . " and ";
                                            $aggsql = $aggsql . $whereInvhead . " and ";
                                            $bool = true;
                                        }
					$companysql = $companysql . "  i.industryid=pec.industry and
					pec.PEcompanyID = pe.PECompanyID  and   pe.InvestorType=it.InvestorType and  ipoinv.IPOId=pe.IPOId and
					pe.Deleted=0 " .$addVCFlagqry.$addDelind.$hideWhere.$comp_industry_id_where. " order by companyname ";
			//		echo "<br><br>WHERE CLAUSE SQL---" .$companysql;
				}
				else
				{
					echo "<br> INVALID DATES GIVEN ";
					$fetchRecords=false;
				}

//mail sending

//if((trim($submitemail)!= "") && (trim($submitpassword)!=""))
//		{
			$checkUserSql= "SELECT dm.EmailId, dm.Passwrd,dm.Name, dm.DCompId,dc.ExpiryDate FROM dealmembers AS dm,
                        dealcompanies AS dc WHERE dm.DCompId = dc.DCompId AND dm.EmailId='$submitemail' AND dc.Deleted =0";

			if ($totalrs = mysql_query($checkUserSql))
			{

				$cnt= mysql_num_rows($totalrs);
				//echo "<Br>mail count------------------" .$hidesearchon;
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
								$filetitle="";
								if($searchtitle==0)
								{
									$searchdisplay="PE-backed";
									$filetitle="PE-backed-IPOs";
								}
								elseif($searchtitle==1)
								{
									$searchdisplay="VC-backed";
									$filetitle="VC-backed-IPOs";
								}
								elseif($searchtitle==2)
								{
									$searchdisplay="Real Estate";
									$filetitle="";
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
									<tr><td width=1%>Industry </td><td width=99%>$hideindustrytext</td></tr>

									<tr><td width=1%>Stage</td><td width=99%>$hidestagetext</td></tr>
									<tr><td width=1%>Investment Type</td><td width=99%>$invtypevalue</td></tr>


									<tr><td width=1%>Range</td><td width=99%>$rangeText</td></tr>
									<tr><td width=1%>Period</td><td width=99%>$dateValue</td></tr>
									<tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
									<tr><td width=1%>Company/Sector</td><td width=99%>$companysearch</td></tr>
									<td width=29%> $CloseTableTag</td></tr>
									</table>
									</body>
									</html>";
								}
								elseif($hidesearchon==2)
								{
									$subject="Send Excel Data: IPO Exits - $searchdisplay";
									$message="<html><center><b><u> Send IPO Data: $searchdisplay to - $submitemail</u></b></center><br>
									<head>
									</head>
									<body >
									<table border=1 cellpadding=0 cellspacing=0  width=74% >
									<tr><td width=1%>Email</td><td width=99%>$submitemail</td></tr>
									<tr><td width=1%>Industry </td><td width=99%>$hideindustrytext</td></tr>
									<tr><td width=1%>Investment Type</td><td width=99%>$invtypevalue</td></tr>
									<tr><td width=1%>Investor Sale</td><td width=99%>$investorsale</td></tr>
                                                                        <tr><td width=1%>Period</td><td width=99%>$dateValue</td></tr>
									<tr><td width=1%>Investor</td><td width=99%>$keyword</td></tr>
									<tr><td width=1%>Company</td><td width=99%>$companysearch</td></tr>

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
									<tr><td width=1%>Industry </td><td width=99%>$hideindustry</td></tr>
									<tr><td width=1%>Deal Type </td><td width=99%>$dealtype</td></tr>
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
									<tr><td width=1%>Industry </td><td width=99%>$hideindustry</td></tr>
									<tr><td width=1%>Deal Type </td><td width=99%>$dealtype</td></tr>
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
								//header( 'Location: http://www.ventureintelligence.com/deals/cthankyou.php' ) ;


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


 $sql=$companysql;
//echo "<br>---" .$sql;exit();
 //execute query
 $result = @mysql_query($sql)
     or die("Couldn't execute query:<br>" . mysql_error(). "<br>" . mysql_errno());
 
 updateDownload($result);

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
 header("Content-Disposition: attachment; filename=$filetitle.$file_ending");
 header("Pragma: no-cache");
 header("Expires: 0");

 /*    Start of Formatting for Word or Excel    */



 /*    FORMATTING FOR EXCEL DOCUMENTS ('.xls')   */

 	//create title with timestamp:
 	if ($Use_Title == 1)
 	{
 		echo("$title\n");
 	}

 	/*echo ("$tsjtitle");
 	 print("\n");
 	  print("\n");*/

 //define separator (defines columns in excel & tabs in word)
 $sep = "\t"; //tabbed character

 //start of printing column names as names of MySQL fields
 //-1 to avoid printing of coulmn heading country
// for ($i =9; $i < mysql_num_fields($result)-4; $i++)
// {
// 	echo mysql_field_name($result,$i) . "\t";
// }
// 	echo "Portfolio Company"."\t";
//   echo "Year Founded"."\t";
// 	echo "PE Firm(s)"."\t";
// 	echo "Investor Type"."\t";
// 	 echo "Exit Status"."\t";
// 	echo "Investor Sale ?"."\t";
//         echo "Industry"."\t";
// 	echo "Sector_Business Description"."\t";
// 	echo "Website"."\t";
// 	echo "Date "."\t";
// 	echo "IPO Size (US\$M)"."\t";
// 	echo "Price (Rs.)"."\t";
// 	echo "IPO Valuation (US\$M)"."\t";
// //	echo "Advisors"."\t";
//          echo "Selling Investors"."\t";
// 	echo "Addln Info (Overall IPO)"."\t";
// 	echo "Investment Details"."\t";
//         //echo "Link"."\t";
//     	echo "Return Multiple"."\t";
//       echo "IRR (%)"."\t";
//         //echo "Estimated Returns"."\t";

// 	echo "More Info(Returns)"."\t";
// 	 echo "Company Valuation (INR Cr)"."\t";
//         echo "Revenue Multiple"."\t";
//           echo "EBITDA Multiple"."\t";
//           echo "PAT Multiple"."\t";
		  
// 		// New Feature 08-08-2016 start
	
// 			echo "Price to Book"."\t";
		
// 		//New Feature 08-08-2016 end
		  
//         echo "Valuation (More Info)"."\t";
//         echo "Revenue"."\t";
//         echo "EBITDA"."\t";
//         echo "PAT"."\t";
// 			echo "Book Value Per Share"."\t";
// 			echo "Price Per Share"."\t";
// 	echo "Link for Financials"."\t";

if(in_array("PortfolioCompany", $expval))
    {
        echo "Portfolio Company"."\t";
    }
    if(in_array("YearFounded", $expval))
    {
        echo "Year Founded"."\t";
    }
    if(in_array("PEFirm", $expval))
    {    
        echo "PE Firm(s)"."\t";
    }
    if(in_array("InvestorType", $expval))
    {
        echo "Investor Type"."\t";
    }
    if(in_array("ExitStatus", $expval))
    {
        echo "Exit Status"."\t";
    }
    if(in_array("InvestorSale", $expval))
    {
        echo "Investor Sale ?"."\t";
    }
    if(in_array("Industry", $expval))
    {
        echo "Industry"."\t";
    }
    if(in_array("SectorBusinessDescription", $expval))
    {
        echo "Sector_Business Description"."\t";
    }
    if(in_array("Website", $expval))
    {
        echo "Website"."\t";
    }
    if(in_array("Date", $expval))
    { 
        echo "Date "."\t";
    }
    if(in_array("IPOSize", $expval))
    {
        echo "IPO Size (US\$M)"."\t";
    }
    if(in_array("Price", $expval))
    {
        echo "Price (Rs.)"."\t";
    }
    if(in_array("IPOValuation", $expval))
    {
        echo "IPO Valuation (US\$M)"."\t";
    }
    if(in_array("SellingInvestors", $expval))
    {
        echo "Selling Investors"."\t";
    }
    if(in_array("AddlnInfo", $expval))
    {
        echo "Addln Info (Overall IPO)"."\t";
    }
    if(in_array("InvestmentDetails", $expval))
    {
        echo "Investment Details"."\t";
    }
    if(in_array("ReturnMultiple", $expval))
    {
        echo "Return Multiple"."\t";
    }
    if(in_array("IRR", $expval))
    {   
        echo "IRR (%)"."\t";
    }
    if(in_array("MoreInfoReturns", $expval))
    {
        echo "More Info(Returns)"."\t";
    }
    if(in_array("CompanyValuation", $expval))
    {
        echo "Company Valuation (INR Cr)"."\t";
    }
    if(in_array("RevenueMultiple", $expval))
    {    
        echo "Revenue Multiple"."\t";
    }
    if(in_array("EBITDAMultiple", $expval))
    {
        echo "EBITDA Multiple"."\t";
    }
    if(in_array("PATMultiple", $expval))
    {
        echo "PAT Multiple"."\t";
    }
    if(in_array("PricetoBook", $expval))
    {
        echo "Price to Book"."\t";
    }
    if(in_array("ValuationMoreInfo", $expval))
    {
        echo "Valuation (More Info)"."\t";
    }
    if(in_array("Revenue", $expval))
    {
        echo "Revenue"."\t";
    }
    if(in_array("EBITDA", $expval))
    {
        echo "EBITDA"."\t";
    }
    if(in_array("PAT", $expval))
    {
        echo "PAT"."\t";
    }
    if(in_array("BookValuePerShare", $expval))
    {
        echo "Book Value Per Share"."\t";
    }
    if(in_array("PricePerShare", $expval))
    {
        echo "Price Per Share"."\t";
    }
    if(in_array("LinkforFinancials", $expval))
    {
        echo "Link for Financials"."\t";
    }

 print("\n");

 /*print("\n");*/
 //end of printing column names

 //start while loop to get data
 /*
 note: the following while-loop was taken from phpMyAdmin 2.1.0. --from the file "lib.inc.php".
 */
 $searchString="Undisclosed";
  $searchString=strtolower($searchString);
   $searchStringDisplay="Undisclosed";

  $searchString1="Unknown";
  $searchString1=strtolower($searchString1);

  $searchString2="Others";
  $searchString2=strtolower($searchString2);


     while($row = mysql_fetch_row($result))
     {

         //set_time_limit(60); // HaRa
         $schema_insert = "";
         $IPOId=$row[0];
	$companyName = $row[3];
	$companyName=strtolower($companyName);
	$compResult=substr_count($companyName,$searchString);

    if(in_array("PortfolioCompany", $expval))
    {
        if($compResult==0)
        {
        $schema_insert .= $row[7].$sep;
            $webdisplay=$row[14];
        }
        else
        {
            $schema_insert .= $searchStringDisplay.$sep;
            $webdisplay="";
        }
    }
    if(in_array("YearFounded", $expval))
    {
        $schema_insert .= $row[38].$sep;//year founded
    }
		//New Feature 08-08-2016 start
								 
		  $price_to_book=$row[35]; 
		  if($price_to_book<=0)
			 $price_to_book="";
		  
			 
		  $book_value_per_share=$row[36]; 
		  if($book_value_per_share<=0)
			$book_value_per_share="";
		  
		  
		 $price_per_share=$row[37]; 
		  if($price_per_share<=0)
			 $price_per_share="";
			 
		//New Feature 08-08-2016 end
	
       $investor_sale_value=$row[27];

                        if($investor_sale_value==1)
                           $investor_sale_display="Yes";
                        else
                           $investor_sale_display="No";
                        if($row[23]<=0)
                        {   $dec_company_valuation="";}
                        else
                        {   $dec_company_valuation=$row[23];}
                        if($row[24]<=0)
                        {    $dec_sales_multiple="";}
                        else
                        {    $dec_sales_multiple=$row[24];}
        
                       	if($row[25]<=0)
                        {    $dec_ebitda_multiple="";}
                        else
                        {    $dec_ebitda_multiple=$row[25];}
                       	if($row[26]<=0)
                        {    $dec_netprofit_multiple="";}
                        else
                        {    $dec_netprofit_multiple=$row[26];}

                        if($row[31]==0)
                              $exitstatusdisplay="Partial";
                        elseif($row[31]==1)
                              $exitstatusdisplay="Complete";
                        
	$investorSql="select peinv.IPOId,peinv.InvestorId,i.Investor,MultipleReturn,InvMoreInfo,IRR from ipo_investors as peinv,
	peinvestors as i where peinv.IPOId=$IPOId and i.InvestorId=peinv.InvestorId";
//echo "<Br>Investor".$investorSql;

	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame from peinvestments_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.PEId=$IPOId and advcomp.CIAId=cia.CIAId";
//	echo "<Br>".$advcompanysql;

		if($investorrs = mysql_query($investorSql))
				 {
					 $investorString="";
					 $AddOtherAtLast="";
					 $investorStringMoreInfo="";
					$AddUnknowUndisclosedAtLast="";
          $invIRRString = "";
				   while($rowInvestor = mysql_fetch_array($investorrs))
					{

                                                $Investorname=$rowInvestor[2];
						$multiplereturn=$rowInvestor[3];
						$invmoreinfo=$rowInvestor[4];
						/*if($multiplereturn>0)
						{   $addreturnstring= ",".$multiplereturn."x";
                                                    if(($invmoreinfo!="") && ($invmoreinfo!= " "))
                                                    {  $addreturnstring= $addreturnstring .",".$invmoreinfo;}
                                                }
                                                else
                                                {   $addreturnstring=" ";}
                                                */
						$Investorname=strtolower($Investorname);
             if($rowInvestor[5] > 0.00 || $rowInvestor[5] > 0){
              $invIRRString.=$rowInvestor[2].",".$rowInvestor[5]."; ";  
            }    
						$invResult=substr_count($Investorname,$searchString);
						$invResult1=substr_count($Investorname,$searchString1);
						$invResult2=substr_count($Investorname,$searchString2);

						if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
						{	$investorString=$investorString .", ".$rowInvestor[2];
        						if($multiplereturn>0)
        						{   $addreturnstring= ",".$multiplereturn."x";
                                                            if(($invmoreinfo!="") && ($invmoreinfo!= " "))
                                                            {  $addreturnstring= $addreturnstring .",".$invmoreinfo;}
                                                            $investorStringMoreInfo=$investorStringMoreInfo ."; ".$rowInvestor[2].$addreturnstring;
                                                        }
                                                        else
                                                        {   $addreturnstring=" ";}
						}
						elseif(($invResult==1) || ($invResult1==1))
							$AddUnknowUndisclosedAtLast=$rowInvestor[2];
						elseif($invResult2==1)
							$AddOtherAtLast=$rowInvestor[2];

					}
          $invIRRString = rtrim(trim($invIRRString),';');
						$investorString =substr_replace($investorString, '', 0,1);
                                                $investorStringMoreInfo=substr_replace($investorStringMoreInfo, '', 0,1);
						if($AddUnknowUndisclosedAtLast!=="")
							$investorString=$investorString ."; ".$AddUnknowUndisclosedAtLast;

						if($AddOtherAtLast!="")
				  			$investorString=$investorString ."; ".$AddOtherAtLast;
				}
				if(in_array("PEFirm", $expval))
                {  
                    $schema_insert .= $investorString.$sep;
                }
                if(in_array("InvestorType", $expval))
                {
                    //investor type
                    $schema_insert .= $row[22].$sep;
                }
                if(in_array("ExitStatus", $expval))
                {
                    $schema_insert .= $exitstatusdisplay.$sep;     //exit status.
                }
                if(in_array("InvestorSale", $expval))
                {
                    //investor sale
                    $schema_insert .= $investor_sale_display.$sep;
                }
                if(in_array("Industry", $expval))
                {
                    //industry
                    $schema_insert .= $row[8].$sep;
                }
                if(in_array("SectorBusinessDescription", $expval))
                {
                    //sector
                    $schema_insert .= $row[9].$sep;
                }
                if(in_array("Website", $expval))
                {
                    $schema_insert .= $webdisplay.$sep;
                }
                if(in_array("Date", $expval))
                {    
                    //date
                    $schema_insert .= $row[10].$sep;
                }
                if(in_array("IPOSize", $expval))
                {
                    //ipo size
                    if(($row[16]==1) || ($row[11]<=0))
                        $hideamount="";
                    else
                        $hideamount=$row[11];
                    $schema_insert .= $hideamount.$sep;
                }
                if(in_array("Price", $expval))
                {
                    //price
                    if($row[12]>0)
                        $price=$row[12];
                    else
                        $price="";
                    $schema_insert .= $price.$sep;
                }
                if(in_array("IPOValuation", $expval))
                {
                    //valuation
                    if($row[13]>0)
                        $valuation=$row[13];
                    else
                        $valuation="";
                    $schema_insert .= $valuation.$sep;
                }
                if(in_array("SellingInvestors", $expval))
                {
                    $schema_insert .= $row[28].$sep; // Selling investors
                }
                if(in_array("AddlnInfo", $expval))
                {
                    //additional info
                    if($row[17]==1)
                            $hidemoreinfor="";
                    else
                            $hidemoreinfor=$row[15];
                    $schema_insert .= $hidemoreinfor.$sep;
                }
                if(in_array("InvestmentDetails", $expval))
                {
                    $schema_insert .= $row[18].$sep; //Investment deals
                }
                if(in_array("ReturnMultiple", $expval))
                {
                    //$schema_insert .= $row[19].$sep; // Link
                    $schema_insert .= $investorStringMoreInfo.$sep;
                }
	        
	        if($row[20]!="")
			{
				$estimatedirrvalue=$row[20];
				$moreinforeturnsvalue=$row[21];
			}
			else
			{
				$estimatedirrvalue="";
				$moreinforeturnsvalue="";
			}
			//$schema_insert .= $estimatedirrvalue.$sep; //EstimatedIRR
            if(in_array("IRR", $expval))
            { 
                $schema_insert .= $invIRRString.$sep; // IRR
            }
            if(in_array("MoreInfoReturns", $expval))
            {
                $schema_insert .= $moreinforeturnsvalue.$sep; // MoreInfo Returns
            }
            if(in_array("CompanyValuation", $expval))
            {
                $schema_insert .= $dec_company_valuation.$sep; //
            }
            if(in_array("RevenueMultiple", $expval))
            {  
                $schema_insert .= $dec_sales_multiple.$sep; //
            }
            if(in_array("EBITDAMultiple", $expval))
            {     
                $schema_insert .= $dec_ebitda_multiple.$sep; //
            }   
            if(in_array("PATMultiple", $expval))
            {   
                $schema_insert .= $dec_netprofit_multiple.$sep; //
            }	   
            if(in_array("PricetoBook", $expval))
            {
                $schema_insert .= $price_to_book.$sep;  //price_to_book
            }		 
            if(in_array("ValuationMoreInfo", $expval))
            {
                $schema_insert .= $row[29].$sep; //Valuation (in table)
            }       
            if(in_array("Revenue", $expval))
            {
                $dec_revenue=$row[32];
                if($dec_revenue < 0 || $dec_revenue > 0){
                    $schema_insert .= $dec_revenue.$sep;  //Revenue 
                }else{
                    if($dec_company_valuation >0 && $dec_sales_multiple >0){
                
                        $schema_insert .= number_format($dec_company_valuation/$dec_sales_multiple, 2, '.', '').$sep;
                    }
                    else{
                        $schema_insert .= ''.$sep;
                    }
                }
            }
            if(in_array("EBITDA", $expval))
            {
                $dec_ebitda=$row[33];
                if($dec_ebitda < 0 || $dec_ebitda > 0){
                    $schema_insert .= $dec_ebitda.$sep;  //EBITDA 
                }else{
                    if($dec_company_valuation >0 && $dec_ebitda_multiple >0){
        
                        $schema_insert .= number_format($dec_company_valuation/$dec_ebitda_multiple, 2, '.', '').$sep;
                    }
                    else{
                        $schema_insert .= ''.$sep;
                    }
                }
            }
            if(in_array("PAT", $expval))
            {
                $dec_pat=$row[34];
                if($dec_pat < 0 || $dec_pat > 0){
                    $schema_insert .= $dec_pat.$sep;  //PAT 
                }else{
                    if($dec_company_valuation >0 && $dec_netprofit_multiple >0){
        
                        $schema_insert .= number_format($dec_company_valuation/$dec_netprofit_multiple, 2, '.', '').$sep;
                    }
                    else{
                        $schema_insert .= ''.$sep;
                    }
                }
            }
            if(in_array("BookValuePerShare", $expval))
            {
                $schema_insert .= $book_value_per_share.$sep;  //book_value_per_share
            }
            if(in_array("PricePerShare", $expval))
            {
                $schema_insert .= $price_per_share.$sep;  //price_per_share
            }
            if(in_array("LinkforFinancials", $expval))
            {    
                $schema_insert .= $row[30].$sep; //finlink
            }
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

    print "\n";
    print "\n";
    print "\n";
    print "\n";
    print "\n";
    echo ( html_entity_decode( $tsjtitle, ENT_COMPAT, 'ISO-8859-1' ) );
    print("\n");
    print("\n");
    }
   mysql_close();
    mysql_close($cnx);
    ?>


