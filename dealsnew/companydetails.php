<?php include_once("../globalconfig.php"); ?>
<?php
        /*$drilldownflag=0;
        $companyId=632270771;
        $companyIdDel=1718772497;
        $companyIdSGR=390958295;//688981071;//
        $companyIdVA=38248720;
        $compId=0;*/
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
    include ('checklogin.php');
    $lgDealCompId = $_SESSION['DcompanyId'];
    $usrRgsql = "SELECT * FROM `dealcompanies` WHERE `DCompId`='".$lgDealCompId."'";
    $usrRgres = mysql_query($usrRgsql) or die(mysql_error());
    $usrRgs = mysql_fetch_array($usrRgres);
        $mailurl= curPageURL();
        $searchString="Undisclosed";
	$searchString=strtolower($searchString);

	$searchString1="Unknown";
	$searchString1=strtolower($searchString1);

    // T969
    $country_total_list_count_val = mysql_query("SELECT COUNT(DISTINCT peinvestors.countryid) as country_count from peinvestors JOIN country on country.countryid=peinvestors.countryid WHERE peinvestors.countryid NOT IN ('IN', 10, 11) and country.country != '' and country.country != '--'
    ORDER BY `country`.`country`  DESC");
    $cnty_count = mysql_fetch_array($country_total_list_count_val);
    $country_count_total = $cnty_count['country_count'];
    // - T969

	$searchString2="Others";
	$searchString2=strtolower($searchString2);
    $resetfield=$_POST['resetfield'];
    if ($resetfield == "country") {
        $_POST['country']    = "";
        $countrytxt          = "";
        $_POST['city']       = "";
        $cityname            = "";
        $_POST['countryNIN'] = "";
        $countryNINtxt       = "";
    } else {
        $countrytxt = $_POST['country'];
    }
    
    // For City 
    if ($resetfield == "city") {
        $_POST['city'] = "";
        $cityid        = "";
    } else {
        $cityid = $_POST['city'];
        $cityid1=implode(",",$cityid);
    }
    
    // For countryNIN 
    if ($resetfield == "countryNIN") {
        $_POST['countryNIN'] = "";
        $countryNINtxt       = "";
    } else {
        $countryNINtxt = $_POST['countryNIN'];
        $countryNINtxt1=implode(",",$countryNINtxt);
    }
     if ($resetfield == "tagsearch") {
        $_POST['tagsearch'] = "";
        $tagsearch = "";
    } else {
        $tagsearch = $_POST['tagsearch'];
    }
    //T-969
if(gettype($cityid)!="string"){
    $cityid = $cityid;
    
    }else{
        $cityid = explode(",", $cityid);
       
    }
    if(count($cityid) > 0){
        $cityflag=$_POST['cityflag'];
        if($cityflag == 0){
    
            $cityname = "All City";
            // exit();
        } else {
            $cityidClause = implode(",",$cityid);
            $citysql= "select city_id, city_name from city where city_id IN ($cityidClause)";
            if ($citytype = mysql_query($citysql))
            {
                While($myrow = mysql_fetch_array($citytype, MYSQL_BOTH))
                {
                    $cityname = $myrow["city_name"] ;
                    $cityname_list[] = "'".$myrow["city_name"]."'" ;
                    
                }
                $cityname_list = implode(',', $cityname_list);
                
            }
        }
    }
    if(gettype($countryNINtxt)!="string"){
        $countryNINtxt = $countryNINtxt;
        
        }else{
            $countryNINtxt = explode(",", $countryNINtxt);
           
        }
    if(count($countryNINtxt) > 0){
        
        $countryNINval=$_POST['countryNINflag'];
       
         $countryNINtxtClause = implode(",", $countryNINtxt);
            $result_string = "'" . str_replace(",", "','", $countryNINtxtClause) . "'";
            $countrysql= "select countryid, country from country where countryid IN ($result_string)";
        if ($countrytype = mysql_query($countrysql))
        {
            
            While($myrow = mysql_fetch_array($countrytype, MYSQL_BOTH))
            {
                if($countryNINval !=0 && count($countryNINtxt) != $country_count_total ){
                $countryNINname = $myrow["country"];
                $countryname_list[] = "'".$myrow["country"]."'" ;
                }else if($countryNINval ==0 && count($countryNINtxt) == $country_count_total  ){
                    $countryNINname = "All Countries";
                }else{
                    $countryNINname = ""; 
                }
               
                    
                $countryNINid[] = $myrow["countryid"];
                
            }
            if($countryNINname == 'All Countries'){
                $countryname_list = $countryNINname;
            }else{
                $countryname_list = implode(',', $countryname_list);
            }
            
            $countryid_list[] = implode(',', $countryNINid);
            $countryid_code_v = implode(',', $countryNINid);
            $countryid_code = "'" . str_replace(",", "','", $countryid_code_v) . "'";
            $countryNINidList = $countryNINid;
         
        }
    
        
    }
    
     if($countrytxt != ""){
         if($countrytxt == "IN"){
            $countryname = "India";
         } else if($countrytxt == "NIN"){
            $countryname = "Non-India";
         }
     } 
            
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        //echo "<br>*".$value;
        $strvalue = explode("/", $value);
        $SelCompRef=$strvalue[0];
        $SelCompRef2=$strvalue[2];
        $dealvalue=$strvalue[2];

       	$pe_re=$strvalue[1];
        if(sizeof($strvalue)>1)
        {   
            $vcflagValue=$strvalue[1];
            $VCFlagValue=$strvalue[1];
            $flagvalue=$strvalue[1];
        }
        else
        {
            $vcflagValue=0;
            $VCFlagValue=0;
            $flagvalue="0-1";
        }
        if($pe_re=="0-0")
        {
                $pe_re=7;
        }
        else if($pe_re=="1-0")
        {
                $pe_re=8;
        }
        else if($pe_re=="0-1")
        {
                $pe_re=9;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'GET')
        {   
           // echo "1";
            if($getyear!="")
            {
                $month1= 01;
                $year1 = $getyear;
                $month2= 12;
                $year2 = $getyear;
                $fixstart=$year1;
                $startyear =  $fixstart."-".$month1."-01";
                $fixend=$year2;
                $endyear =  $fixend."-".$month2."-31";
            }
            else if($getsy !='' && $getey !='')
            {
                $month1= 01;
                $year1 = $getsy;
                $month2= 12;
                $year2 = $getey;
                $fixstart=$year1;
                $startyear =  $fixstart."-".$month1."-01";
                $fixend=$year2;
                $endyear =  $fixend."-".$month2."-31";
                //$getdate=" dates between '" . $getdt1. "' and '" . $getdt2 . "'";
            }
            else
            {
                $month1= date('n', strtotime(date('Y-m')." -2   month")); 
                $year1 = date('Y');
                $month2= date('n');
                $year2 = date('Y'); 
            if($type==1)
            {
                $fixstart=1998;
                $startyear =  $fixstart."-01-01";
                $fixend=date("Y");
                $endyear = $endyear = date("Y-m-d");
            }
            else 
            {
                $fixstart=2009;
                $startyear =  $fixstart."-01-01";
                $fixend=date("Y");
                $endyear = date("Y-m-d");
             }
            }
            
            
            
        } elseif ($_SERVER['REQUEST_METHOD'] === 'POST')
        {
            
            if($resetfield=="period")
            {
             $month1= date('n', strtotime(date('Y-m')." -2   month")); 
             $year1 = date('Y');
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
            }elseif (($resetfield=="searchallfield")||($resetfield=="keywordsearch")||($resetfield=="companysearch")||($resetfield=="advisorsearch_legal")||($resetfield=="advisorsearch_trans"))
            {
             $month1= date('n', strtotime(date('Y-m')." -2   month")); 
             $year1 = date('Y');
             $month2= date('n');
             $year2 = date('Y');
             $_POST['month1']="";
             $_POST['year1']="";
             $_POST['month2']="";
             $_POST['year2']="";
             $_POST['searchallfield']="";
            }
            else if(trim($_POST['searchallfield'])!="" || trim($_POST['keywordsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!="" )
            {
            
             $month1=01; 
             $year1 = 1998;
             $month2= date('n');
             $year2 = date('Y');
            }
            else
            {
             $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2	 month"));
             $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y');
             $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
             $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
            }
            
            $fixstart=$year1;
            $startyear =  $fixstart."-".$month1."-01";
            $fixend=$year2;
            $endyear =  $fixend."-".$month2."-31";
            
        }
	 $TrialSql="select dm.DCompId as compid,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm	where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
        if($trialrs=mysql_query($TrialSql))
        {
                        while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                        {
                                $exportToExcel=$trialrow["TrialLogin"];
                                $compId=$trialrow["compid"];
                        }
        }
        if($compId==$companyId)
        { 
           $hideIndustry = " and display_in_page=1 "; 
        
        }
        elseif($compId==$companyIdDel)
        {
          $hideIndustry = " and display_in_page=2 ";
        }
        elseif($compId==$companyIdSGR)
        {
          $hideIndustry = " and (industryid=3 or industryid=24) ";
        }
        elseif($compId==$companyIdVA)
        {
          $hideIndustry = " and (industryid=1 or industryid=3) ";
        }
        else
        {
          $hideIndustry="";     
        }
	
        $prevNextArr = array();
	$prevNextArr = $_SESSION['resultCompanyId'];
	
	$currentKey = array_search($SelCompRef,$prevNextArr);
	$prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
	$nextKey = $currentKey+1;
        
           if($VCFlagValue==0)
            {
                    $getTotalQuery="SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                    FROM peinvestments AS pe, pecompanies AS pec
                    WHERE pe.Deleted =0  and pe.PECompanyId=pec.PECompanyId
                    AND pec.industry !=15 and pe.AggHide=0 and
                    pe.PEId NOT
                            IN (
                            SELECT PEId
                            FROM peinvestments_dbtypes AS db
                            WHERE DBTypeId ='SV'
                            AND hide_pevc_flag =1
                            )";
                    $pagetitle="PE Investments -> Search";
                    $stagesql_search = "select StageId,Stage from stage ";
                    $industrysql="select industryid,industry from industry where industryid IN (".$_SESSION['PE_industries'].")". $hideIndustry ." order by industry";
                // echo "<br>***".$industrysql;
            }
            elseif($VCFlagValue==1)
            {
               $getTotalQuery= "SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                    FROM peinvestments AS pe, stage AS s ,pecompanies as pec
                    WHERE s.VCview =1 and  pe.amount<=20 and pec.industry !=15 and pe.StageId=s.StageId and pe.PECompanyId=pec.PECompanyId
                    and pe.Deleted=0
                    and
                    pe.PEId NOT
                            IN (
                            SELECT PEId
                            FROM peinvestments_dbtypes AS db
                            WHERE DBTypeId =  'SV'
                            AND hide_pevc_flag =1
                            )  ";
                    $pagetitle="VC Investments -> Search";
                    $stagesql_search = "select StageId,Stage from stage where VCview=1 ";
                     $industrysql="select industryid,industry from industry where industryid IN (".$_SESSION['PE_industries'].")" . $hideIndustry ." order by industry";

                    //echo "<Br>---" .$getTotalQuery;
            }
            elseif($VCFlagValue==2)
            {
                    $getTotalQuery= " SELECT count( pe.PEId ) AS totaldeals, sum( pe.amount ) AS totalamount
                    FROM REinvestments AS pe, pecompanies AS pec
                    WHERE pec.Industry =15 and pe.Deleted=0
                    AND pe.PEcompanyID = pec.PECompanyId ";
                    $pagetitle="PE Investments - Real Estate -> Search";
                    $stagesql_search="";
                     $industrysql="select industryid,industry from industry where industryid IN (".$_SESSION['PE_industries'].")";

            }

                //$SelCompRef = $value;
		//$pe_re= 1;

            $exportToExcel=0;
            
            $TrialSql="select dm.DCompId,dc.DCompId,TrialLogin from dealcompanies as dc,dealmembers as dm
            where dm.EmailId='$emailid' and dc.DCompId=dm.DCompId";
            //echo "<br>---" .$TrialSql;
            if($trialrs=mysql_query($TrialSql))
            {
                    while($trialrow=mysql_fetch_array($trialrs,MYSQL_BOTH))
                    {
                            $exportToExcel=$trialrow["TrialLogin"];
                    }
            }

            $sql="SELECT pe.FinLink, pec.angelco_compID, pec.uploadfilename, pec.PECompanyId, pec.companyname, pec.industry as industryId, i.industry, pec.sector_business, website,linkedIn, stockcode, yearfounded,CINNo, pec.Address1, pec.Address2, pec.AdCity, pec.Zip, pec.OtherLocation, c.country, pec.Telephone, pec.Fax, pec.Email, pec.AdditionalInfor, linkedin_companyname,pec.filingfile,pec.tags
                FROM pecompanies pec
                LEFT JOIN peinvestments AS pe ON ( pe.PECompanyId = pec.PECompanyId ) 
                LEFT JOIN industry i ON ( pec.industry = i.industryid ) 
                LEFT JOIN country c ON ( c.countryid = pec.countryid ) 
                WHERE pec.PECompanyId =$SelCompRef";
        
            $company_link_Sql =mysql_query("select * from pecompanies_links where PECompanyId='$SelCompRef'"); 
		//echo "<br>".$SelCompRef;
		

		if(($pe_re==0) || ($pe_re==1) || ($pe_re==2) || ($pe_re==3) || ($pe_re==4) || ($pe_re==5) ||($pe_re==6)||($pe_re==10) || ($pe_re==11)|| ($pe_re==7) || ($pe_re==9) ||($pe_re==8))
		{
			$investorSql="select pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV,GROUP_CONCAT( inv.Investor,CASE WHEN peinv.leadinvestor = 1 THEN ' (L)' ELSE '' END,CASE WHEN peinv.newinvestor = 1 THEN ' (N)' ELSE '' END ORDER BY inv.InvestorId=9) as Investors,GROUP_CONCAT( inv.InvestorId ORDER BY inv.InvestorId=9) as InvestorIds  from
			peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,
			peinvestors as inv where pe.PECompanyId=$SelCompRef and
			peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0
			and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15  group by pe.PEId order by dates desc";

			$dealpage="dealinfo.php";
                        if($pe_re==2)
                        {
                            $invpage="angleinvdetails.php";
                        }
                        else
                        {
                            $invpage="dirdetails.php";
                        }
			//echo "<br>0 1 _________________".$investorSql;
		}

		/*elseif(($pe_re==10) || ($pe_re==11))// PE-ipo 3 , VCIPOs-4class="" target="_blank" href='dirdetails
		{
			$investorSql="select pe.IPOId as DealId,peinv.IPOId,peinv.InvestorId,inv.Investor,DATE_FORMAT( IPODate, '%b-%Y' ) as dt from
			ipos as pe, ipo_investors as peinv,pecompanies as pec,
			peinvestors as inv where pe.PECompanyId=$SelCompRef and
			peinv.IpoId=pe.IpoId and inv.InvestorId=peinv.InvestorId  and pe.Deleted=0
			and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15";

			$dealpage="ipodealinfo.php";
			$invpage="investordetails.php";
		//	echo "<Br>3 4 ---" .$investorSql;
		}

		elseif( ($pe_re==7) || ($pe_re==9) ||($pe_re==8)) // manda
		{
			$investorSql="select pe.MandAId as DealId,peinv.MandAId,peinv.InvestorId,inv.Investor,DATE_FORMAT( DealDate, '%b-%Y' ) as dt from
			manda as pe, manda_investors as peinv,pecompanies as pec,
			peinvestors as inv where pe.PECompanyId=$SelCompRef and
			peinv.MandAId=pe.MandAId and inv.InvestorId=peinv.InvestorId  and pe.Deleted=0
			and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15";

			$dealpage="mandadealdetails.php";
			$invpage="investordetails.php";
		//	echo "<br>5 6 ______________ ";$investorSql;
		}*/
        /*elseif(($pe_re==8) || ($pe_re==9) || ($pe_re==10))  //social venture investments ,  clenatech, infrastructure , query is same as peinvestor
		{

			$investorSql="select pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV from
			peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,
			peinvestors as inv where pe.PECompanyId=$SelCompRef and
			peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0
			and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15 order by dates desc";
			$dealpage="dealinfo.php";
			$invpage="investordetails.php";
		//        echo "<br>8  9 10 _________________".$investorSql;
		}*/
		//echo "<br>--" .$investorSql;
                //elseif($pe_re==2) // incubatees
		//{
                $incubatorSql="SELECT pe.IncDealId,pe.IncubatorId,inc.Incubator,DATE_FORMAT( date_month_year, '%M-%Y' ) as dt FROM
                `incubatordeals` as pe, incubators as inc WHERE IncubateeId =$SelCompRef
                and pe.IncubatorId= inc.IncubatorId ";

		  // echo "<bR>2 ---" .$investorSql;
		//}
		$onBoardSql="select pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId,
		exe.ExecutiveName,exe.Designation,exe.Company from
		pecompanies as pec,executives as exe,pecompanies_board as bd
		where pec.PECompanyId=$SelCompRef and bd.PECompanyId=pec.PECompanyId and exe.ExecutiveId=bd.ExecutiveId";
		//echo "<Br>Board-" .$onBoardSql;

		$onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,
				exe.ExecutiveName,exe.Designation,exe.Company from
				pecompanies as pec,executives as exe,pecompanies_management as mgmt
		where pec.PECompanyId=$SelCompRef and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";
		//echo "<Br>Board-" .$onMgmtSql;

		//$maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,
		//	DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId
		//	FROM manda AS pe, industry AS i, pecompanies AS pec WHERE  i.industryid=pec.industry
		//	AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=$SelCompRef order by dt desc";

                $maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, inv.Investor,
			DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId ,pe.ExitStatus, pe.DealTypeId, dt.DealType,GROUP_CONCAT( inv.Investor ORDER BY inv.InvestorId) as Investors
			FROM manda AS pe, industry AS i, pecompanies AS pec,manda_investors as mi ,peinvestors as inv, dealtypes AS dt
                         WHERE  i.industryid=pec.industry
			AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=$SelCompRef
			and inv.InvestorId=mi.InvestorId and mi.MandAId=pe.MandAId and pe.DealTypeId=dt.DealTypeId group by dt 
                        order by DealDate desc ";
                      //  echo "<br>-- ".$maexitsql;

		$ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,
				IPOAmount, DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId ,pe.ExitStatus,GROUP_CONCAT( inv.Investor ORDER BY inv.InvestorId) as Investors
				FROM ipos AS pe, industry AS i, pecompanies AS pec,ipo_investors as ipoi,peinvestors as inv
                                 WHERE  i.industryid=pec.industry
			AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=$SelCompRef
                        and inv.InvestorId=ipoi.InvestorId and ipoi.IPOId=pe.IPOId group by dt
                         order by IPODate desc";
                         //  echo "<br>-- ".$ipoexitsql;

		$angelinvsql="SELECT pe.InvesteeId, pe.AggHide, pec.companyname, pec.industry, i.industry, pec.sector_business,
				DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.AngelDealId ,peinv.InvestorId,inv.Investor,GROUP_CONCAT( inv.InvestorId ORDER BY inv.Investor ) as InvestorIds, GROUP_CONCAT( inv.Investor ORDER BY inv.Investor) as Investors
				FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,
   	                        angel_investors as peinv,peinvestors as inv
                                 WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.InvesteeId and 
                                 pe.Deleted=0 and pec.industry !=15 and pe.InvesteeId=$SelCompRef
                                 and  peinv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv.InvestorId and inv.InvestorId!=9 group by AngelDealId order by dt desc";
                                // echo "<Br>---" .$angelinvsql;
                // $company_link_Sql ="select * from pecompanies_links where PECompanyId=$SelCompRef";
        
        if($strvalue[3]=='Directory'){
            if($VCFlagValue==0){
            $listviewurl="pedirview.php?value=0";
            }else if($VCFlagValue==1){
               $listviewurl="pedirview.php?value=1"; 
            }else if($VCFlagValue==2){
               $listviewurl="pedirview.php?value=2"; 
            }
            else if($VCFlagValue==3){
               $listviewurl="pedirview.php?value=3"; 
            }
            else if($VCFlagValue==4){
               $listviewurl="pedirview.php?value=4"; 
            }
            else if($VCFlagValue==5){
               $listviewurl="pedirview.php?value=5"; 
            }
            else if($VCFlagValue==6){
                $listviewurl="pedirview.php?value=6"; 
            }
            else if($VCFlagValue==7){
               $listviewurl="pedirview.php?value=7"; 
            }
            else if($VCFlagValue==8){
               $listviewurl="pedirview.php?value=8"; 
            }
            else if($VCFlagValue==12){
               $listviewurl="pedirview.php?value=12"; 
            }
            else if($VCFlagValue==11){
               $listviewurl="pedirview.php?value=11"; 
            }
            else if($VCFlagValue==9){
               $listviewurl="pedirview.php?value=9"; 
            }
            else if($VCFlagValue==10){
               $listviewurl="pedirview.php?value=10"; 
            }
            
            //$listviewurl="pedirview.php?value=0";
            $headerurl="dirnew_header.php"; 
           
                $refineurl="newdirrefine1.php";
            
        }else{
            
            if($strvalue[1]=='0-1' || $strvalue[1]=='0-0' || $strvalue[1]=='1-0' )
            {
                
                 $listviewurl="mandaindex.php?value=".$strvalue[1];
                 $headerurl="mandaheader_search.php";
                 $refineurl="mandarefine.php";

            }elseif($strvalue[1]=='funds') {

                $sqltype = "select * from fundType where focus='Stage'"; 
                $sqltype2 = "select * from fundType where focus='Industry'";
                $sqlfundstatus = "select * from fundRaisingStatus";
                $sqlfundClosed = "select * from fundCloseStatus";
                $sqlcapitalsrc = "select * from fundCapitalSource";
                $listviewurl="funds.php";
                $headerurl="fundheader_search.php";
                $refineurl="funds_refine.php";
            }
            elseif($strvalue[1]==2) 
            {
                if(isset($_REQUEST['raisingcomp'])){
                    $listviewurl="angelcoindex.php";
                }else{
                    $listviewurl="angelindex.php";
                }
                $headerurl="angelheader_search.php";
                $refineurl="angelrefine.php";

            }
            else if($strvalue[1]==0 || $strvalue[1]==1) 
            {
                $listviewurl="index.php?value=".$strvalue[1];
                $headerurl="tvheader_search_detail.php";
                $refineurl="refine.php"; 

            }
            else if($strvalue[1]==3 || $strvalue[1]==4 || $strvalue[1]==5 )
            {
                $listviewurl="svindex.php?value=".$strvalue[1];
                $headerurl="tvheader_search_detail.php";
                $refineurl="refine.php"; 

            }
            else if($strvalue[1]==6 )
            {
                $listviewurl="incindex.php";
                $headerurl="incheader_search.php";
                $refineurl="increfine.php";

            }
            else if($strvalue[1]==10 ) {
                $_REQUEST['value']=0;
                $listviewurl="ipoindex.php?value=0";
                $headerurl="ipoheader_search.php";
                $refineurl="iporefine.php";
            } 

            else if($strvalue[1]==11 ) {
                $_REQUEST['value']=1;
                $listviewurl="ipoindex.php?value=1";
                $headerurl="ipoheader_search.php";
                $refineurl="iporefine.php";
            }
            else {
                $listviewurl="index.php?value=0";
                $headerurl="tvheader_search_details.php";
                $refineurl="refine.php"; 
            }
        }
            
	if($strvalue[3]=='Directory'){
            $topNav = 'Directory';
        }
        elseif($strvalue[1]=='funds')
        {
            $topNav = 'Funds';
        }
        else{
            $topNav = 'Deals';
        }
	include_once($headerurl);
?>
<style>
.invdealperiod{
    padding-left:25px !important;
}
td.investname span:last-child,td.angelinvestname span:last-child {
    display: none;
}

.tableInvest td, .tableInvest td a {
    font-size: 10pt;
    color: #666 !important;
    font-weight: 600;
}
.tableInvest tbody td:first-child, .tableInvest tbody td:first-child a {
    color: #000 !important;
    font-weight: 600;
    text-decoration: none;
    font-size: 10pt;
}
.relatedcompanies span a{
    margin:0px 15px;
}
.tagelements {
    float: left;
    padding: 12px 0px;
    padding-right: 12px;
    margin-bottom: 0px;
    width: 25%;
    box-sizing: border-box;
}
.tagelements a {
    color: #7b5e40;
    font-weight: bold;
    display: block;
    font-size: 14px;
    text-decoration: underline;
}
/* .tagelements{
    padding:5px;
}
.tagelements span{
    padding:5px;
    font-weight:600;
} */
.accordions_dealcontent p {
    color: #666666;
    margin: 0px !important;
}

@media only screen and (max-width: 1500px) and (min-width: 1281px){
.col-md-6 {
    width: 50%;
}
.exits{
    width:80%;
}
}
#incubation td a{
    font-weight:600;
}
.box_heading {
    background: #BDA074;
    border-radius: 4px;
    color: #fff;
    text-transform: capitalize !important;
}
.accordian-group tr {
    border-bottom: 1px solid #ccc;
    clear: both;
    margin: 0px;
    width: 100%;
}
.accordian-group tr:last-child {
    border-bottom: none;
}
.accordian-group table {
    background: #fff;
    padding: 0px !important;
    width: 100%;
    box-sizing: border-box;
    border-top: none;
}
.activetab {
    display: block !important;
}
.tab-items {
    display: none;
}
ul.tabView li.current {
    color: #fff;
    background-color: #c09f74;
}
ul.tabView li {
    list-style-type: none;
    display: inline-block;
    color: #c09f74;
    padding: 10px 10px 10px 10px;
    text-transform: uppercase;
    cursor: pointer;
    font-size: 18px;
    margin-right: 30px;
    margin-bottom: 10px;
}
 ul.tabView {
    border-bottom: none !important;
    width: 100%;
    overflow: hidden;
}
.accordions_dealcontent ul {
    color: #000;
}
.accordions_dealcontent {
    color: #000;
    /* transition: 0.8s linear; */
    box-shadow: 0px 3px #e3e4e4;
    border: 1px solid #afb0b3;
    border-top: 1px solid transparent;
    width: 100%;
    /* padding: 10px 20px; */
    padding: 0px 20px;
    padding-top: 8px;
    padding-bottom: 7px;
    box-sizing: border-box;
    border-top: none;
}
.accordian-group {
    background: #fff !important;
    border: none !important;
    margin-bottom: 15px !important;
}
.accordions {
    position: relative;
}
.accordions_dealtitle {
    width: 100%;
    display: grid;
    grid-template-columns: 50px 1fr;
    /* background-color: #c9c4b7; */
    background-color: #e0d8c3;
    cursor: pointer;
    /* transition: 0.8s linear; */
    border: 1px solid #a28669;
    /* margin-top: 2px; */
    box-sizing: border-box;
}
.accordions_dealtitle span {
    align-self: center;
    display: block;
    padding-left: 15px;
}
.accordions_dealtitle span:after {
    content: " ";
    background: url(images/sprites-icons.png) no-repeat -22px -59px;
    width: 24px;
    height: 24px;
    display: block;
    /* background-position: -5px -5px; */
    margin-right: 5px;
    border-radius: 50px;
}
.box_heading.content-box {
    border-radius: 5px 5px 0 0;
}
.box_heading.content-box {
    background: #e0d8c3 !important;
}
.accordions_dealtitle.active span:after {
    background: url(images/sprites-icons.png) no-repeat -72px -59px;
    width: 24px;
    height: 24px;
    display: block;
    /* background-position: -5px -5px; */
    margin-right: 5px;
    border-radius: 50px;
}
.accordions_dealtitle h2 {
    /* padding: 15px 0px !important; */
    /* padding: 10px 0px !important; */
    padding-top: 13px !important;
    padding-bottom: 12px !important;
    margin: 0;
    color: #333333 !important;
    /* font-weight: bold; */
    text-transform: uppercase;
    /* font-size: 22px !important; */
    font-size: 19px !important;
    background: #fff;
}
.box_heading.content-box {
    background: #C9C4B7;
    color: #000000;
    overflow: hidden;
}
.work-masonry-thumb1 h2 {
    padding: 10px;
    margin: 0;
    border-bottom: 1px solid #d4d4d4;
    color: #c09f74;
    text-transform: uppercase;
    font-size: 18px;
}
 .row.masonry .col-6{
    width: 100%;
    /* padding: 7px 0; */
    box-sizing: border-box;
    /* vertical-align: middle; */
    display: inline-block;
    float: none;column-fill: auto;
}
.accordions_dealcontent .com-address-cnt{
    padding: 20px 0px 0px !important
}
/*.view-detailed{
    padding: 10px 0;
}*/
.detailtitle{
    position: relative !important;left: 0px !important;
}
.detailtitle a{
    font-size: 21px !important;
    color: #333;
    font-weight: 600;
        text-decoration: none;
    text-transform: capitalize;
}
.inner-section .action-links{
        background-color: #fff;
}
.profile-view-left{
    position:relative;
}
.tablelistview .more-info p{
    font-size: 9pt;
    line-height: 18px !important;
    text-align: justify;
}
.companyinfo_table td a{
    color: #666 !important;text-decoration: none;
}
.companydealcontent{
    height: 205px;
    
}
.section1 .accordions_dealcontent{
    /*border: 1px solid #4e4e4e;*/
    border: 1px solid #afb0b3;
    border-top: none;
    box-shadow: 0px 3px #d9dada;
    padding-right: 10px;
}
.row.masonry .col-6 {
    width: 50%;
    padding: 0px 8px;
    box-sizing: border-box;
    display: block;
    float: left;
}
.row.masonry .col-6:first-child{
    padding-left: 0px;
}
.row.masonry .col-6:nth-child(2){
    padding-right: 0px;
}
 @-moz-document url-prefix() {
    .row.masonry .col-6 {
        width: 50%;
        padding: 0px 8px;
        box-sizing: border-box;
        display: block;
        float: left;
    }
} 
.companydealcontent{
    /*min-height:485px;*/
}
/*969 changes*/
.list-tab.mt-list-tab.tablist {
    margin-top: 120px;
}
 .result-title.resettag{
    height: 125px;
   }
 .result-select.resettaglist{
    overflow-y: scroll;
    height: 75px;
    width:65%;
}
    .result-title{width:95%;}
.page-dir .result-title.resettag{
    height: 125px;
   }
.page-dir .result-select.resettaglist{
    overflow-y: scroll;
    height: 75px;
    width:60%;
}
/*969 changes*/
    .page-dir .result-title {
        height: 75px;
    }
    .mt-list-tab {
    margin-top: 70px;
}
    .relatedCompany .com-add-li, .tags .com-add-li{  min-height: 1px; }
    .tags .com-add-li{  width:140px; }
    .tags .bor-top-cnt{
        border-top:none;
    }
    .relatedCompany .com-address-cnt, .tags .com-address-cnt{ 
        border-bottom:none;  
        padding:0 30px;
    }
    .com-investment-profile{
        width: 33%;
    }
    .bor-top-cnt{
        border-top: 1px solid #e4e4e4;
        clear: both;
        padding-top: 10px;
    }
    .mar-top {
        margin: 0px 15px 10px;
    }
    .inv-lf-li{
        min-height: 100px;
    }
    
</style>
<div id="container">
<form name="companyDisplay" method="post" action="exportcompanyprofile.php">
<table cellpadding="0" cellspacing="0" width="100%" >
<tr>
    
<?php  if (isset($_REQUEST['raisingcomp'])) { ?>  
    
    <script type="text/javascript" > 

        $(document).ready(function () {
            $("#pesearch").attr('action','angelcoindex.php');
        });
    </script>               
<td class="left-td-bg" >
    <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">

<?php include_once('angelcorefine.php');?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
</div>
      </div>
</td>
<?php } elseif($refineurl!='') { ?>    
<td class="left-td-bg" >
    <div class="acc_main">
    <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div>
    
    <div id="panel" style="display:block; overflow:visible; clear:both;">

<?php include_once($refineurl);?>
     <input type="hidden" name="resetfield" value="" id="resetfield"/>
</div>
      </div>
</td>
<?php } ?>



<td class="profile-view-left" style="width:100%;">
    
<div class="result-cnt" style="position: relative;margin-top:0;">
     <div class="result-title " style=""> 
         <?php if($countryname!="--" && $countryname!=null && ($cityname != '' || $countryNINname != '') || $tagsearch!='') {  ?>
        <ul class="result-select">
          <?php if($countryname!="--" && $countryname!=null && ($cityname != '' || $countryNINname != '')) { $drilldownflag=0; ?>
            <li> 
            <?php $cross_city = str_replace("'", " ", $cityname_list); ?>
            <?php 
                $cross_country = str_replace("'", " ", $countryname_list); 
                if($cross_country == ''){
                    $cross_country = $countryname;
                }
            ?>
            <?php
                if($countrytxt != "NIN"){
                    if($cityname =="All City"){
                        ?>
                        <?php echo $cross_country." - ".ucwords(strtolower($cityname)).$countryNINname;?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>        
                    <?php
                        }else{
                    ?>
                <?php echo $cross_country." - ".ucwords(strtolower($cross_city)).$countryNINname;?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                <?php }
                }else{ ?>
                    <?php if($countryNINname == "All Countries"){
                        ?>
                    <?php echo "Non-india - ".ucwords(strtolower($countryNINname));?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                    <?php }else{ ?>
                        <?php echo "Non India - ".$cross_country;?><a  onclick="resetinput('country');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                    <?php } ?>
                <?php } ?>
            </li>
         <?php }  ?>
           <?php if($tagsearch!='') { $drilldownflag=0; ?>
                <li> 
                    <?php echo $tagsearch;?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
          <?php }  ?>
        </ul>
        <?php }  ?>
    <div class="title-links" style="margin-right: 55px;">
                                
            <input class="senddeal" type="button" id="senddeal" value="Send this company profile to your colleague" name="senddeal">
            <?php 

            if(($exportToExcel==1) && (!isset($_REQUEST['angelco_only'])))
                 {
                 ?>
                     <span id="exportbtn"></span>
                 <?php
                 }
             ?>
    </div>
    </div>
    <?php 
   // echo $sql;
    if ($companyrs = mysql_query($sql))
    {
        if($companyrs)
        {
                            
            $myrow=mysql_fetch_array($companyrs,MYSQL_BOTH);
 
            if(isset($_REQUEST['angelco_only'])){
                
                $angelco_compID=$SelCompRef;
                $angelcompanyrs = mysql_query("SELECT * FROM  `angelco_fundraising_cos` WHERE  `angel_id` =$angelco_compID");
                $angelmyrow=mysql_fetch_array($angelcompanyrs,MYSQL_BOTH);
                $compname=$angelmyrow["company_name"];
            }    
            else if(mysql_num_rows($companyrs)>0){ 
//              / echo "adsasd";
                $angelco_compID=$myrow["angelco_compID"];
                $compname=$myrow["companyname"];
                $industryId = $myrow["industryId"];
                $industry=$myrow["industry"];
                $sector=$myrow["sector_business"];
                $website=$myrow["website"];
                $Address1=$myrow["Address1"];
                $Address2=$myrow["Address2"];
                $AdCity=$myrow["AdCity"];
                $Zip=$myrow["Zip"];
                $finlink=$myrow["FinLink"];
                $uploadname=$myrow["uploadfilename"];
                $filingfile=$myrow["filingfile"];
                $currentdir=getcwd();
                $target = $currentdir . "../uploadmamafiles/" . $uploadname;
                $file = "../../uploadmamafiles/" . $uploadname;
                $filinglink = $currentdir . "../uploadfilingfiles/" . $filingfile;

                $OtherLoc=$myrow["OtherLocation"];
                $Country=$myrow["country"];
                $Tel=$myrow["Telephone"];
                $Fax=$myrow["Fax"];
                $Email=$myrow["Email"];
                $AddInfo=$myrow["AdditionalInfor"];
                $stockcode=$myrow["stockcode"];
                $yearfounded=$myrow["yearfounded"];
                $CINNo=$myrow["CINNo"];
                $website=$myrow["website"];
                $linkedIn=$myrow["linkedIn"];
                $linkedin_compname=$myrow["linkedin_companyname"];
               // echo "<bR>^^^^^^^^*********^^^^^^^^^^^^^^^^" .$linkedin_compname;

                $companyName=trim($myrow["companyname"]);
                $companyName=strtolower($companyName);
                $compResult=substr_count($companyName,$searchString);
                $compResult1=substr_count($companyName,$searchString1);
                $compResult2=substr_count($companyName,$searchString2);
                $webdisplay="";
                $google_sitesearch="https://www.google.co.in/search?q=".$companyName."+site%3Alinkedin.com";
                        $companyurl=  urlencode($companyName);
                        $company_newssearch="https://www.google.co.in/search?q=".$companyurl."+site:ventureintelligence.com/ddw/";
			$google_sitesearch_mgmt="";
                        //$linkedin_url="http://www.linkedin.com/company/".$companyName; }

			//if($linkedin_compname!="")
			//{ 	$linkedin_url="http://www.linkedin.com/company/".$linkedin_compname; }


			//echo "<br>----" .$linkedin_url;
            }
                          
                        
            $pe_industries = explode(',', $_SESSION['PE_industries']);
            if(!in_array($industryId,$pe_industries)){
                
                echo '<div style="font-size:20px;padding:10px 10px 10px 10px;"><b> You dont have access to this information!</b></div>';
                exit;
            } 
                        
            if(($compResult==0) && ($compResult1==0))
            {
                    $webdisplay=$website;
    
    ?>
    <div class="list-tab mt-list-tab"><ul>
             <li><a class="postlink"  href="<?php echo $listviewurl; ?>"  id="icon-grid-view"><i></i> List View</a></li>
         
        <li class="active"><a id="icon-detailed-view" class="postlink" href="companydetails.php?value=<?php echo $_GET['value'];?>" ><i></i> Detail  View</a></li> 
        </ul></div> 
    <div class="lb" id="popup-box" style="z-index: 11111;top:100px;">
	<div class="title">Send this to your Colleague</div>
        <form>
            <div class="entry">
                    <label> To*</label>
                    <input type="text" name="toaddress" id="toaddress"  />
            </div>
            <div class="entry">
                    <h5>Subject*</h5>
                    <p>Checkout this profile - <?php echo $compname; ?> - in Venture Intelligence</p>
                    <input type="hidden" name="subject" id="subject" value="Checkout this profile - <?php echo $compname; ?> - in Venture Intelligence"  />
                    <input type="hidden" name="basesubject" id="basesubject" value="Company profile" />
            </div>
            <div class="entry">
                    <h5>Link</h5>
                    <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>"  />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
            </div>
            <div class="entry">
                <h5>Your Message</h5><span style='float:right;'>Words left: <span id="word_left">200</span></span>
                <textarea name="ymessage" id="ymessage" style="width: 374px; height: 57px;" placeholder="Enter your text here..." val=''></textarea>
            </div>
            <div class="entry">
                <input type="button" value="Submit" id="mailbtn" />
                <input type="button" value="Cancel" id="cancelbtn" />
            </div>

        </form>
    </div>
    
   <div class="view-detailed"> 
    <?php
   
    if(mysql_num_rows($companyrs)>0){  
        
    $value =$_GET['value'];
    $strvalue = explode("/", $value);
    if($strvalue[1]==10 || $strvalue[1]==11)
    {
    ?>
    <div class="detailed-title-links">

 <?php 
 
 if(!isset($_REQUEST['angelco_only'])){ ?> <h2><?php echo $compname; ?></h2> <?php } ?>
        
        
        
		<?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="companydetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $strvalue[1].'/'. $strvalue[2].'/'. $strvalue[3];?>">< Previous</a><?php } ?> 
            <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="companydetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $strvalue[1].'/'. $strvalue[2].'/'. $strvalue[3];?>"> Next > </a>  <?php } ?>
                    </div> 
    <?php
    }
    else
    {
    ?>
    
      <div class="detailed-title-links"> <?php if(!isset($_REQUEST['angelco_only'])){ ?> <h2><?php echo $compname; ?></h2> <?php } ?>
		<?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="companydetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $strvalue[1].'/'. $strvalue[2].'/'. $strvalue[3];?>">< Previous</a><?php } ?> 
            <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="companydetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $strvalue[1].'/'. $strvalue[2].'/'. $strvalue[3];?>"> Next > </a>  <?php } ?>
                    </div> 
    <?php
    }
    
    }
    ?>
       
       
    <!-- new -->
  <?php
    $profile=$roles=array();
    $companyurl = GLOBAL_BASE_URL."cron_job/angelcheckcomp.php?company_name=$compname";
    $compjson = file_get_contents($companyurl);
    $comp = json_decode($compjson);
    //print_r($comp);
    foreach($comp as $compdetails){
            
            if($angelco_compID!=''){
//                echo $compdetails->id."==".$angelco_compID;
//                echo strtolower($compdetails->name)."==".strtolower($compname);
//                echo "strrrr".substr_count( strtolower($compname),strtolower($compdetails->name));
                if($compdetails->id==$angelco_compID){
                    
                    $profileurl =GLOBAL_BASE_URL."/cron_job/angelfrominfo.php?name=profile&angelco_compID=$angelco_compID";
                    $profilejson = file_get_contents($profileurl);
                    $profile = json_decode($profilejson);
                    $roleurl = GLOBAL_BASE_URL."cron_job/angelfrominfo.php?name=role&angelco_compID=$angelco_compID";
                    $rolejson = file_get_contents($roleurl);
                    $roles = json_decode($rolejson);
                    $roles = $roles->startup_roles;
                    break;
                }
//                echo $compdetails->id."==".$angelco_compID;
//                echo strtolower($compdetails->name)."==".strtolower($compname);
//                echo "strrrr".substr_count( strtolower($compname),strtolower($compdetails->name));
                if(count($profile) > 0 || count($roles) > 0){
                    
                        if($compdetails->id==$angelco_compID && (strtolower($compdetails->name)==strtolower($compname) || substr_count( strtolower($compname),strtolower($compdetails->name)) != false)){
                       // echo "ddddddd1";
                            $profileurl =GLOBAL_BASE_URL."/cron_job/angelfrominfo.php?name=profile&angelco_compID=$angelco_compID";
                            $profilejson = file_get_contents($profileurl);
                            $profile = json_decode($profilejson);
                            $roleurl = GLOBAL_BASE_URL."cron_job/angelfrominfo.php?name=role&angelco_compID=$angelco_compID";
                            $rolejson = file_get_contents($roleurl);
                            $roles = json_decode($rolejson);
                            $roles = $roles->startup_roles;
                            break;
                        }
                        else if((strtolower($compdetails->name)==strtolower($compname) || substr_count( strtolower($compname),strtolower($compdetails->name)) != false) && $compdetails->id!=$angelco_compID){
                          // echo "ddddddd2";
                            $profileurl = GLOBAL_BASE_URL."cron_job/angelfrominfo.php?name=profile&angelco_compname=$compdetails->id";
                            $profilejson = file_get_contents($profileurl);
                            $profile = json_decode($profilejson);
                            $roleurl = GLOBAL_BASE_URL."cron_job/angelfrominfo.php?name=role&angelco_compname=$compdetails->id";
                            $rolejson = file_get_contents($roleurl);
                            $roles = json_decode($rolejson);
                            $roles = $roles->startup_roles;
                            break;

                        }
                }
                
                    
            }
            else{
//                echo "eeeeeeeeeee";
                if(strtolower($compdetails->name)==strtolower($compname) || substr_count( strtolower($compname),strtolower($compdetails->name)) != false){
                    
                    $angelco_compID = $compdetails->id;
                    $profileurl = GLOBAL_BASE_URL."cron_job/angelfrominfo.php?name=profile&angelco_compID=$compdetails->id";
                    $profilejson = file_get_contents($profileurl);
                    $profile = json_decode($profilejson);
                    $roleurl = GLOBAL_BASE_URL."cron_job/angelfrominfo.php?name=role&angelco_compID=$compdetails->id";
                    $rolejson = file_get_contents($roleurl);
                    $roles = json_decode($rolejson);
                    $roles = $roles->startup_roles;
                    break;
                }
            }
                
        }
  //if($angelco_compID !=''){
      
     // echo $angelco_compID; exit;
      
    /*$profileurl ="https://api.angel.co/1/startups/$angelco_compID/?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&type=startup";
      
    //role=founder&
    $roleurl ="https://api.angel.co/1/startups/$angelco_compID/roles?access_token=5688a487422775f0f973d1cfc636d74ceeeeac76fca1c534&token_type=bearer&type=startup";
   
   

                $profilejson = file_get_contents($profileurl);
    $profile = json_decode($profilejson);*/
       // $profileurl =GLOBAL_BASE_URL."/cron_job/angelfrominfo.php?name=profile&angelco_compID=$angelco_compID";
        //$profilejson = file_get_contents($profileurl);
       // $profile = json_decode($profilejson);
       // $roleurl = GLOBAL_BASE_URL."cron_job/angelfrominfo.php?name=role&angelco_compID=$angelco_compID";
        //$rolejson = file_get_contents($roleurl);
        //$roles = json_decode($rolejson);
        //$roles = $roles->startup_roles;
    
    
//   echo "<pre>";
//   print_r($roles);
//   echo "</pre>";
  //  exit;
    
     
  //}
  ?>
    
<div class="com-wrapper">
	<section class="com-cnt-sec">
    	<header>
    		<h3>Company Profile</h3>
         </header>
            
         <?php /* if($angelco_compID !='' && $profile->id > 0){ ?>
         <div class="com-col">
             <img src="img/angle-list.png" alt="angle-list" class="fr mar-top">
         <div class="com-sec-lg bor-top-cnt">
         	<div class="co-home-ground border-btm pad-top-no">
            	<img src="<?php echo $profile->logo_url ?>" alt="<?php echo $profile->name ?>">
                <address class="fl">
                	<strong> <?php echo $profile->name ?> </strong>
                    <span> <?php echo $profile->high_concept ?> </span>
                    <p>
<!--                        Mumbai · Specialty Foods · Food Processing · South East Asia-->
                        <?php
                        $places ='';
                        foreach ( $profile->locations as $locations){
                            $places .=$locations->display_name." - ";
                        }
                        
                        foreach ( $profile->markets as $markets){
                            $places .=$markets->display_name." - ";
                        }
                        
                        echo rtrim($places,'- ');
                        
                        ?>
                    
                    </p>
                </address>
            </div>
             
           <?php if($profile->product_desc) { ?>
            <div class="com-pro-cnt border-btm">
            	<h3 class="com-sub-title">Product</h3>
                <p> <?php echo $profile->product_desc ?> </p>
            </div>
           <?php } ?>  
             
             
            <?php 
            $rolescount=0;
            foreach ($roles as $ro) {  if($ro->role == 'founder') { $rolescount++; } }
            
            if($rolescount > 0) { ?> 
            <div class="com-founder-cnt border-btm no-bor">
            	<h3 class="com-sub-title">FOUNDER</h3>
                
                <?php foreach ($roles as $ro) {  
                    if($ro->role == 'founder') { 
//                            echo "<pre>";
//                            print_r($ro);
//                            echo "</pre>";
                ?>
                <div class="fonder-detail-com">
                	<img src="<?php echo $ro->tagged->image ?>" alt="<?php echo $ro->tagged->name ?>">
                    <div class="fon-det-sec fl">
                    	<h4 class="founder-name-com"><?php echo $ro->tagged->name ?></h4>
                        <span><?php echo $ro->title ?></span>
                        <p><?php echo $ro->tagged->bio ?></p>
                    </div>
                </div>
                <?php } } ?> 
                
            </div>
             <?php } ?> 
             
            </div>
            
         </div>
        <?php }*/ ?>
            
            
            <?php if(mysql_num_rows($companyrs)>0){ ?>
            
         <div class="com-col">
             <img src="img/co-sec-logo.png" alt="vi" class="fr mar-top">
         	<div class="com-address-cnt bor-top-cnt">



                    <?php 
                    if ($myrow["Investor"] != "") 
                    { ?>                                        

                          <div class="com-add-li">
                                          <h6>Investor</h6>
                                      <span><?php echo $myrow["Investor"]; ?></span>
                          </div>
                    <?php
                    }
                    if($industry!="")
                  {
                  ?>

                          <div class="com-add-li">
                              <h6>INDUSTRY</h6>
                          <span> <?php echo $industry;?></span>
                          </div>

                  <?php }
                  if($sector!="")
                  {
                  ?>
                          <div class="com-add-li">
                             <h6>SECTOR</h6>
                          <span><?php echo $sector;?></span>
                          </div>

                  <?php }
                 // if($stockcode!="")
                  //{
                  ?>
                          <!-- <div class="com-add-li">
                             <h6>STOCK CODE</h6>
                          <span><?php //echo $stockcode;?></span>
                          </div> -->
                  <?php //}
                   //if ($Address1 != "" || $Address2 != ""){ 
                       ?>
                                        <!-- <div class="com-add-li">
                                          <h6>ADDRESS</h6>
                                      <span> <?php //echo $Address1; ?><?php //if ($Address2 != "") echo "<br/>" . $Address2; ?></span>
                                  </div> -->


                     <?php
                  //}
                  if ($AdCity != "") 
                  { ?>
                                      <div class="com-add-li">
                                          <h6>CITY</h6>
                                      <span><?php echo $AdCity; ?></span>
                                  </div>


                      <?php
                      }
                      if(($Country!="")&&($Country!="--" ))
                      {
                    ?>
                                  <div class="com-add-li">
                                          <h6>COUNTRY</h6>
                                      <span> <?php echo $Country; ?></span>
                                  </div>

                     <?php
                     }
                    //if (($Zip != "") || ($Zip > 0)) 
                      //  { ?>
                                  <!-- <div class="com-add-li">
                                          <h6>ZIP</h6>
                                      <span><?php //echo $Zip; ?></span>
                                  </div> -->

                     <?php
                  //}
                   if (($Tel != "") || ($Tel > 0)) {
                     ?>
                                  <div class="com-add-li">
                                          <h6> TELEPHONE</h6>
                                      <span><?php echo $Tel ?></span>
                                  </div>
                  <?php
                   }
                   //if(($Fax!="")|| ($Fax>0)) 
                 // {
                  ?>
                                  <!-- <div class="com-add-li">
                                          <h6>FAX</h6>
                                      <span><?php //echo $Fax; ?></span>
                                  </div> -->
                  <?php // }
                  if (trim($Email) != "") {
                      ?>
                                  <div class="com-add-li">
                                          <h6>EMAIL</h6>
                                      <span><?php echo $Email; ?></span>
                                  </div>
                     <?php
                      }
                      if ($CINNo != "" ) {
                          ?>
                                  <div class="com-add-li">
                                          <h6>CIN Number </h6>
                                      <span><?php echo $CINNo; ?></span>
                                  </div>

                      <?php
                      }

                      if ($yearfounded != "" && $yearfounded >0) {
                          ?>
                                  <div class="com-add-li">
                                          <h6>YEAR FOUNDED </h6>
                                      <span><?php echo $yearfounded; ?></span>
                                  </div>

                      <?php
                      }
                  if(trim($OtherLoc)!="") 
                  {
                  ?>
                                  <div class="com-add-li">
                                          <h6>OTHER LOC</h6>
                                      <span><?php echo $OtherLoc; ?></span>
                                  </div>

                  <?php }
                  if (trim($website) != "") 
                    { ?>
                                  <div class="com-add-li">
                                          <h6>WEBSITE</h6>
                                      <span><a href="<?php echo $website; ?>" target="_blank"> Click Here  </a> </span>
                                  </div>

                     <?php
                      }

                      if ($company_newssearch != "") 
                    { 
                    ?>
                                  <div class="com-add-li">
                                          <h6>NEWS</h6>
                                      <span> <a href="<?php echo $company_newssearch; ?>"  target="_blank"> Click Here </a> </span>
                                  </div>

                     <?php
                      } if ($linkedIn != "") 
                    { ?>
                        <div class="com-add-li">
                                          <h6>LINKEDIN</h6>
                                      <span> <a href="<?php echo $linkedIn; ?>"  target="_blank"> Click Here </a> </span>
                                  </div>
                  <?php  }
                      ?> 


                    <?php 
                    
                     if($linkedIn!=''){          
                        $url = $linkedIn;
                        $keys = parse_url($url); // parse the url
                        $path = explode("/", $keys['path']); // splitting the path
                        $companyid = (int)end($path); // get the value of the last element  
                   //  }
                    
//                    if ($companyid != "") 
//                    {  
                        ?>
                                  <div class="com-add-li"  id="viewlinkedin_loginbtn" style="display: none">
                                          <h6>VIEW LINKEDIN PROFILE</h6>
                                      <span><script type="in/Login"></script></span>
                                  </div>

                  <!--  <li id="viewlinkedin_loginbtn" style="display: none"><h4>  </h4><p><script type="in/Login"></script></p></li>-->
                    <?php 
                   }
  
                    
                    if (trim($AddInfo) != "") 
                    { ?>
                                      <div class="com-add-li" >
                                          <h6>ADDITIONAL INFORMATION </h6>
                                      <span><?php echo $AddInfo; ?></span>
                                  </div>


                     <?php
                      } ?>
                    <div style="clear:both;"></div>
                    
        <?php
                    if($rsMgmt= mysql_query($onMgmtSql))
        {
             $mgmt_cnt = mysql_num_rows($rsMgmt);
        }
        if($mgmt_cnt>0)
        {   
        ?>

        <div  class="work-masonry-thumb  com-inv-sec   col-2" style="float:left" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Top Management</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <thead><tr><th>Name</th> <th>Designation</th></tr></thead>
        <tbody>
             <?php
                if($rsMgmt= mysql_query($onMgmtSql))
                //{
                While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                        {
                                $desig="";
                                $desig=$mymgmtrow["Designation"];
                                if(trim($desig)=="")
                                        $desig="";
                                else
                                        $desig=", ".$mymgmtrow["Designation"];
                ?>
                <tr><td style="alt"><?php echo $mymgmtrow["ExecutiveName"]; ?></td>
                    <td><?php echo $mymgmtrow["Designation"]; ?></td>
                <!--  <td>
                <?php 
                        $google_sitesearch_mgmt="https://www.google.co.in/search?q=".$companyName." ".$mymgmtrow["ExecutiveName"]."+site%3Alinkedin.com";
                        ?>
                        <a target="_blank" href="<?php echo $google_sitesearch_mgmt; ?>" ><img src="images/icon-in.png" width="25" height="24" alt="" /></a></td>-->
                </tr>
                <?php
                        }


                ?>
     </tbody>
        </table> 
        </div>   
        <?php
        } ?>
                    
    <?php if($rsBoard= mysql_query($onBoardSql))
    {
         $board_cnt = mysql_num_rows($rsBoard);
    }
    if($board_cnt>0)
    {
    ?>
      <div  class="work-masonry-thumb  com-inv-sec   col-2" style="float:left" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <h2>Investor Board Member</h2>
        <table width="100%" cellspacing="0" cellpadding="0" class="tableview">
        <thead><tr><th>Name</th> <th>Designation</th> <th>LinkedIn</th></tr></thead>
        <tbody>
            <?php

                While($myboardrow=mysql_fetch_array($rsBoard, MYSQL_BOTH))
                {
                        $desig="";
                        $desig=$myboardrow["Designation"];
                        if(strlen(trim($desig))==0)
                                $desig="";
                        else
                                $desig=", ".$myboardrow["Designation"];
                        $comp=$myboardrow["Company"];
                        if(strlen(trim($comp))==0)
                                $comp="";
                        else
                                $comp=", ".$myboardrow["Company"];

        ?>
        <tr><td style="alt"><?php echo $myboardrow["ExecutiveName"];?></td>
        <td>
           
            <?php 
            echo $myboardrow["Designation"];
             if($myboardrow["Designation"]!="" && $myboardrow["Company"]!=""){ echo ","; } ?>
            <?php echo $myboardrow["Company"]; ?></td>
        <td>
        <?php
                $google_sitesearch_board="https://www.google.co.in/search?q=".$myboardrow["ExecutiveName"].$desig.$comp. "+site%3Alinkedin.com";
                                                                ?>
                <a target="_blank" href="<?php echo $google_sitesearch_board; ?>" >
                <?php echo $myboardrow["ExecutiveName"];?></a>
        </td></tr>
        <?php
                }
                //}
                ?>  
     </tbody>
        </table> 
        </div>     
        <?php
        } ?>
                       
            </div>
            
         </div>
         
                 
                  <!-- LINKED IN START -->
                  
                     <?php 
                    //echo "dddddddddddddddd".$linkedIn;
                     if($linkedIn!=''){ 

                     $url = $linkedIn;
                     $keys = parse_url($url); // parse the url
                     $path = explode("/", $keys['path']); // splitting the path
                     $companyid = (int)end($path); // get the value of the last element  

                    ?>
                  <div class="com-col linkedindiv" style="display: none">
                      <div class="linked-com">
                    <div class="linkedin-bg">

                    <script type="text/javascript" > 

                        $(document).ready(function () {
                            $('#lframe,#lframe1').on('load', function () {
                    //            $('#loader').hide();

                            });
                        });

                        function autoResize(id){
                            var newheight;
                            var newwidth;

                            if(document.getElementById){
                                newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
                                newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
                            }

                            document.getElementById(id).height= (newheight) + "px";
                            document.getElementById(id).width= (newwidth) + "px";
                        }
                    </script>

                    <script type="text/javascript" src="//platform.linkedin.com/in.js"> 
                        api_key:65623uxbgn8l
                        authorize:true
                        onLoad: onLinkedInLoad
                        </script>
                        <script type="text/javascript" > 
                        var idvalue=<?php echo $companyid; ?>;

                        function onLinkedInLoad() {
                           $("#viewlinkedin_loginbtn").hide(); 
                           var profileDiv = document.getElementById("sample");

                                    if(idvalue)
                                    {                          
                                        $("#lframe").css({"height": "220px"});
                                        $("#lframe1").css({"height": "300px"});

                                        var inHTML='loadlinkedin.php?data_id='+idvalue;
                                        var inHTML2='linkedprofiles.php?data_id='+idvalue;
                                        $('#lframe').attr('src',inHTML);
                                        $('#lframe1').attr('src',inHTML2);
                                        $('.linkedindiv').hide();
                                    }
                                    else
                                    {
                                         $('#lframe').hide();
                                         $('#lframe1').hide();
                                         $('#loader').hide();
                                         $('.linkedindiv').hide();
                                    }

                          }

                    </script>

                    <div  id="sample" style="padding:10px 10px 0 0;">

                        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="0"></iframe>
                    </div>

                    <input type="hidden" name="dataId" id="dataId" >

                 </div>
                   <div class="fl" style="padding:10px 10px 0 0;">
                   <iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="0" ></iframe></div> 

                    </div>
                      </div>


                     <?php }
                     else{

                     $linkedinSearchDomain=  str_replace("http://www.", "", $webdisplay); 
                       $linkedinSearchDomain=  str_replace("http://", "", $linkedinSearchDomain); 
                        if(strrpos($linkedinSearchDomain, "/")!="")
                        {
                           $linkedinSearchDomain= substr($linkedinSearchDomain, 0, strpos($linkedinSearchDomain, "/"));
                        }
                    if($linkedinSearchDomain!=""){ ?>
                <!--     <img src="images/linked-in.gif" alt="Linked in loading..." id="loader" style="margin: 10px;position:absolute;left:50%;top:100px;">-->
                  <div class="com-col linkedindiv"  style="display: none">
                      <div class="linked-com">
                  <div class="linkedin-bg">

                    <script type="text/javascript" > 

                    $(document).ready(function () {
                        $('#lframe,#lframe1').on('load', function () {
                //            $('#loader').hide();

                        });
                    });

                function autoResize(id){
                    var newheight;
                    var newwidth;

                    if(document.getElementById){
                        newheight=document.getElementById(id).contentWindow.document .body.scrollHeight;
                        newwidth=document.getElementById(id).contentWindow.document .body.scrollWidth;
                    }

                    document.getElementById(id).height= (newheight) + "px";
                    document.getElementById(id).width= (newwidth) + "px";
                }
                 </script>



                        <script type="text/javascript" src="//platform.linkedin.com/in.js"> 
                        api_key:65623uxbgn8l
                        authorize:true
                        onLoad: LinkedAuth
                        </script>
                        <script type="text/javascript" > 
                        var idvalue;
                         //document.getElementById("sa").textContent='asdasdasd'; 

                        function LinkedAuth() {
                            if(IN.User.isAuthorized()==1){
                               $("#viewlinkedin_loginbtn").hide();      
                            }
                            else {
                                 $("#viewlinkedin_loginbtn").show();   
                            }

                            IN.Event.on(IN, "auth", onLinkedInLoad);

                          } 

                        function onLinkedInLoad() {
                           $("#viewlinkedin_loginbtn").hide(); 
                           var profileDiv = document.getElementById("sample");

                               //var url = "/companies?email-domain=<?php echo $linkedinSearchDomain ?>";
                               //var url ="/company-search:(companies:(id,website-url))?keywords=<?php echo $compname ?>";
                               var url ="/company-search:(companies:(id,website-url,name,logo_url))?keywords=<?php echo $linkedinSearchDomain ?>";

                                console.log(url);

                                IN.API.Raw(url).result(function(response) {   

                                    console.log(response);  
                                    //console.log(response['companies']['values'].length);                  
                                    //console.log(response['companies']['values'][0]['id']);
                                    //console.log(response['companies']['values'][0]['websiteUrl']);
                                    var searchlength = response['companies']['values'].length;

                                    var domain='';
                                    var website = '<?php echo $linkedinSearchDomain?>';

                                    for(var i=0; i<searchlength; i++){

                                        if(response['companies']['values'][i]['websiteUrl']){
                                            domain = response['companies']['values'][i]['websiteUrl'].replace('www.','');
                                            domain = domain.replace('http://','');
                                            domain = domain.replace('/','');
                                            if(domain == website){
                                                idvalue = response['companies']['values'][i]['id'];
                                                console.log(idvalue);
                                                break;
                                            }
                                        }
                                    }


                                    if(idvalue)
                                    {                          
                                        $("#lframe").css({"height": "220px"});
                                        $("#lframe1").css({"height": "300px"});

                                        var inHTML='loadlinkedin.php?data_id='+idvalue;
                                        var inHTML2='linkedprofiles.php?data_id='+idvalue;
                                        $('#lframe').attr('src',inHTML);
                                        $('#lframe1').attr('src',inHTML2);
                                         $('.linkedindiv').hide();
                                    }
                                    else
                                    {
                                         $('#lframe').hide();
                                         $('#lframe1').hide();
                                         $('#loader').hide();
                                         $('.linkedindiv').hide();
                                    }

                                    //  profileDiv.innerHtml=inHTML;
                                    //document.getElementById('sa').innerHTML='<script type="IN/CompanyProfile" data-id="'+idvalue+'" data-format="inline"></'+'script>';
                                }).error( function(error){
                                   console.log(error);
                                   $('#lframe').hide();
                                   $('#lframe1').hide();
                                   $('#loader').hide(); 
                                    $('.linkedindiv').hide();
                               });
                          }


                        </script>

                    <div  id="sample" style="padding:10px 10px 0 0;">

                        <iframe src="" id="lframe"  scrolling="no" frameborder="no" align="center" width="400" height="0"></iframe>
                    </div>

                    <input type="hidden" name="dataId" id="dataId" >

                 </div>
                   <div class="fl" style="padding:10px 10px 0 0;">
                   <iframe src="" id="lframe1"  scrolling="no" frameborder="no" align="center" width="674" height="0" ></iframe></div> 
                    </div>
                      </div>
                 <?php } 
                   
                    }
                   ?>
                  
                  <!-- LINKED IN END -->
                  
                 
            
            
            <?php } ?>
            
    </section>
    
    
    <div  class="work-masonry-thumb1 accordian-group" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                                     <div class="accordions">
                                        <div class="accordions_dealtitle "><span></span>
                                        <h2 id="companyinfo" class="box_heading content-box ">Investments and Exits Snapshot</h2>
                                        </div>
                                        <div class="accordions_dealcontent" style="padding-top: 20px;">
                                            <?php 
                                               
                                                if($getcompanyrs= mysql_query($investorSql))
                                                {
                                                    $investor_cnt = mysql_num_rows($getcompanyrs);
                                                }
                                                
                                                
                                                if($incrs= mysql_query($incubatorSql))
                                                {
                                                    $incubator_cnt = mysql_num_rows($incrs);
                                                }
                                                if($rsangel= mysql_query($angelinvsql))
                                                {
                                                    $angel_cnt = mysql_num_rows($rsangel);
                                                }
                                                if($rsipoexit= mysql_query($ipoexitsql))
                                                {
                                                    $ipoexit_cnt = mysql_num_rows($rsipoexit);
                                                }
                                                if($rsmandaexit= mysql_query($maexitsql))
                                                {
                                                    $mandaexit_cnt = mysql_num_rows($rsmandaexit);
                                                }
                                                if($incubator_cnt>0 || $investor_cnt>0 || $angel_cnt>0 || $ipoexit_cnt>0 || $mandaexit_cnt>0) {
                                            ?>
                                            <ul class="tabView">
                                                <?php
                                                if($incubator_cnt>0) { ?> 
                                                    <li href="#incubation">Incubation</li>
                                                <?php } ?>
                                                <?php
                                                if($angel_cnt>0) { ?> 
                                                    <li href="#angel">ANGEL INVESTMENTS</li>
                                                <?php } ?>
                                                <?php
                                                if($investor_cnt>0) { ?> 
                                                    <li href="#investments" class="current">PE/VC INVESTMENTS</li>
                                                <?php } ?>
                                                <?php
                                                if(($ipoexit_cnt>0)||($mandaexit_cnt>0 )) { ?> 
                                                    <li href="#exits">PE/VC Exits</li>
                                                <?php } ?>
                                                <div class="clearfix"></div>
                                            </ul>

                                            <div class="tab-content">
                                                <div id="investments" class="tab-items activetab">
                                                    <?php if($investor_cnt > 0){ ?>
                                                        <div class="col-md-6">
                                                        <table width="100%" cellspacing="0" cellpadding="0" class="tableview tableInvest">
                                                            <thead>

                                                                <tr>
                                                                    <th>Investor Name</th> 
                                                                    <th style="width: 20%;padding-left:25px;">Deal Period</th>
                                                                    
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                 <?php

                                                            $addTrancheWordtxt = "";
                                                            
                                                            While($myInvestorrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                                                    {
                                                                       
                                                                        $Investorname=trim($myInvestorrow["Investor"]);
                                                                $InvestorsName = explode(",",$myInvestorrow["Investors"]);
                                                                $InvestorIds = explode(",",$myInvestorrow["InvestorIds"]);
                                                                            
                                                                            $Investorname=strtolower($Investorname);
                                                                            $invResult=substr_count($Investorname,$searchString);
                                                                            $invResult1=substr_count($Investorname,$searchString1);
                                                                           // $invResult2=substr_count($Investorname,$searchString2);
                                                                            if(($invResult==0) && ($invResult1==0) )
                                                                            {
                                                                            $addTrancheWord="";
                                                                            $addDebtWord="";
                                                                                if(($pe_re==0) || ($pe_re==1) || ($pe_re==8) )
                                                                                {
                                                                                    if($myInvestorrow["AggHide"]==1) {
                                                                                        $addTrancheWord="; NIA";
                                                                                        $addTrancheWordtxt = $addTrancheWord;
                                                                                    }else
                                                                                        $addTrancheWord="";
                                                                                }
                                                                                else
                                                                                    $addTrancheWord="";
                                                                                    if($myInvestorrow["SPV"]==1)
                                                                                        $addDebtWord="; Debt";
                                                                                    else
                                                                                        $addDebtWord="";

                                                                                         ?>
                                                            <tr> 
                                                            <td class="investname" style="alt">
                                                                <?php for ($i=0; $i < sizeof($InvestorsName); $i++) {?>
                                                                <a target="_blank" href='<?php echo $invpage;?>?value=<?php echo $InvestorIds[$i].'/'.$strvalue[1].'/'.$strvalue[2].'/'.$strvalue[3];?>' title="Investor Details"><?php echo $InvestorsName[$i]; ?></a><span>,</span>
                                                                <?php } ?>
                                                            </td>
                                                            <?php if($usrRgs[PEInv] !=0){
                                                                ?>
                                                            <td class="invdealperiod"><a href="dealdetails.php?value=<?php echo $myInvestorrow["DealId"].'/'.$strvalue[1].'/'.$strvalue[2].'/'.$strvalue[3];?>" title="Deal Details"><?php echo $myInvestorrow["dt"];?></a>
                                                            <?php echo $addTrancheWord;?><?php echo $addDebtWord;  ?></td>   
                                                                            <?php }else{?>
                                                                                <td><?php echo $myInvestorrow["dt"];?>
                                                            <?php echo $addTrancheWord;?><?php echo $addDebtWord;?></td> 
                                                                            <?php }?></tr> 
                                                                            <?php 
                                                            }
                                                            } 
                                                        ?>  
                                                            </tbody>
                                                        </table>
                                                        <?php if($addTrancheWordtxt == "; NIA"){ ?>
                                               <div style="height:15px;">
                                                <p class="note-nia" >*NIA - Not Included for Aggregate</p>
                                                </div>
                                                <?php }?> 
                                                         </div>
                                                         <?php } ?>
                                                </div>
                                                <div id="exits" class="tab-items">
                                                    <?php 

                                                    if(($ipoexit_cnt>0)||($mandaexit_cnt>0 ))
                                                    {

                                                    ?>  
                                                    <div  class="col-md-6 exits">
                                                    <table width="100%" cellspacing="0" cellpadding="0" class="tableview tableInvest" >
                                                    <thead><tr><th>Deal Type</th><th style="width:28%">Investor(s)</th> <th>Deal Period</th> <th>Status</th></tr></thead>
                                                    <tbody>
                                                            <?php
                                                            //if($rsipoexit= mysql_query($ipoexitsql))
                                                            //{
                                                                While($ipoexitrow=mysql_fetch_array($rsipoexit, MYSQL_BOTH))
                                                                {
                                                                    
                                                                  $exitstatusvalueforIPO=$ipoexitrow["ExitStatus"];
                                                                  $InvestorsName = explode(",",$ipoexitrow["Investors"]);
                                                                  if($exitstatusvalueforIPO==0)
                                                                   {$exitstatusdisplayforIPO="Partial Exit";}
                                                                  elseif($exitstatusvalueforIPO==1)
                                                                  {  $exitstatusdisplayforIPO="Complete Exit";}
                                                                ?>
                                                               <tr><td style="alt">IPO</td>
                                                               <td class="angelinvestname">
                                                               <?php //echo $ipoexitrow["Investor"];?>
                                                               <?php 
                                                                    for ($i=0; $i < sizeof($InvestorsName); $i++) { ?>
                                                                        <?php echo $InvestorsName[$i]; ?><span>,</span>
                                                                   <?php } ?>
                                                               </td>
                                        
                                                                <td> <a href='ipodealdetails.php?value=<?php echo $ipoexitrow["IPOId"].'/'.$strvalue[1].'/'.$strvalue[2].'/'.$strvalue[3];?>' title="Deal Details"><?php echo $ipoexitrow["dt"];?></a></td>
                                        
                                                                <td><?php echo $exitstatusdisplayforIPO;?></td>
                                                                </tr>
                                        
                                        
                                                                <?php
                                                                        }
                                        
                                                                        if($rsmandaexit= mysql_query($maexitsql))
                                                                //{
                                                                While($mymandaexitrow=mysql_fetch_array($rsmandaexit, MYSQL_BOTH))
                                                                {
                                                                    $InvestorsName = explode(",",$mymandaexitrow["Investors"]);
                                                                    $exitstatusvalue=$mymandaexitrow["ExitStatus"];
                                                                  //$exitstatusvalue=$mymandaexitrow["ExitStatus"];
                                                                  if($exitstatusvalue==0)
                                                                   {$exitstatusdisplay="Partial Exit";}
                                                                  elseif($exitstatusvalue==1)
                                                                  {  $exitstatusdisplay="Complete Exit";}
                                                                ?>
                                        
                                                                <tr><tr><td style="alt"><!--M&A--> <?php echo $mymandaexitrow["DealType"] ?></td>
                                                                
                                                                 <td class="angelinvestname">
                                                                     <?php 
                                                                    for ($i=0; $i < sizeof($InvestorsName); $i++) { ?>
                                                                        <?php echo $InvestorsName[$i]; ?><span>,</span>
                                                                   <?php } ?>
                                                                </td> 
                                                                <!-- <td><?php echo $mymandaexitrow["Investor"];?></td> -->
                                        
                                                                <td> <a href='mandadealdetails.php?value=<?php echo $mymandaexitrow["MandAId"].'/'.$strvalue[1].'/'.$strvalue[2].'/'.$strvalue[3];?>' title="Deal Details"><?php echo $mymandaexitrow["dt"];?></a></td>
                                        
                                                                <td><?php echo $exitstatusdisplay;?></td>
                                                                </tr>
                                                                <?php
                                                                } 
                                                           ?>  
                                                </tbody>
                                                </table> 
                                                
                                                </div>
                                                <?php
                                                }
                                                ?>
                                                </div>
                                                

                                                <div id="angel" class="tab-items">
                                                   <?php
                                                        
                                                            if($angel_cnt>0)
                                                            {                   
                                                        ?>
                                                    
                                                        <div class="col-md-6" >
                                                            <table width="100%" cellspacing="0" cellpadding="0" class="tableview tableInvest" >
                                                            <thead><tr><th>Investor Name</th> <th>Deal Period</th></tr></thead>
                                                            <tbody>
                                                             <?php
                                                                While($angelrow=mysql_fetch_array($rsangel, MYSQL_BOTH))
                                                                {
                                                                $Investorname=trim($angelrow["Investor"]);
                                                                $InvestorsName = explode(",",$angelrow["Investors"]);
                                                                $InvestorIds = explode(",",$angelrow["InvestorIds"]);
                                                                $Investorname=strtolower($Investorname);
                                                                $hide_agg = $angelrow['AggHide'];
                                                                $invRes=substr_count($Investorname,$searchString);
                                                                        $invRes1=substr_count($Investorname,$searchString1);
                                                                        //$invRes2=substr_count($Investorname,$searchString2);


                                                                        if(($invRes==0) && ($invRes1==0) )
                                                                        {
                                                                            if($hide_agg==0) {

                                                                ?>
                                                                        <tr>
                                                                        <td style="alt" class="angelinvestname">
                                                                        <?php  for ($i=0; $i < sizeof($InvestorsName); $i++) { ?>
                                                                        <a href='angleinvdetails.php?value=<?php echo $InvestorIds[$i].'/'.$strvalue[1].'/'.$strvalue[2].'/'.$strvalue[3];?>' ><?php echo $InvestorsName[$i]; ?></a><span>,</span>
                                                                        <?php } ?>
                                                                        </td>

                                                                        <td> <a href="angeldealdetails.php?value=<?php echo $angelrow["AngelDealId"].'/'.$strvalue[1].'/'.$strvalue[2].'/'.$strvalue[3];?>">
                                                                                                <?php echo $angelrow["dt"];?></a></td></tr>

                                                                <?php
                                                                            } else { ?>
                                                                                <tr><td style="alt"><?php echo $angelrow["Investor"]; ?></td>

                                                                        <td> <a href="angeldealdetails.php?value=<?php echo $angelrow["AngelDealId"].'/'.$strvalue[1].'/'.$strvalue[2].'/'.$strvalue[3];?>">
                                                                                                <?php echo $angelrow["dt"];?></a></td></tr>
                                                                        <?php } }
                                                                        elseif(($invRes==1) || ($invRes1==1) || ($invRes2==1))
                                                                        {
                                                                        $AddUnknowUndisclosedAtLast=$angelrow["Investor"];
                                                                        $dealid=$angelrow["AngelDealId"];
                                                                                $dtdisplay=$angelrow["dt"];
                                                                        }
                                                                        elseif($invRes2==1)
                                                                        {
                                                                        $AddOtherAtLast=$angelrow["Investor"];
                                                                        $dealid=$angelrow["AngelDealId"];
                                                                        $dtdisplay1=$angelrow["dt"];
                                                                        }

                                                                }

                                                            // if($AddUnknowUndisclosedAtLast!="")
                                                            //{
                                                              ?>
                                                            </tbody>
                                                            </table> 
                                                           
                                                            </div>

                                               

                                                <?php } ?>
                                                </div>
                                                <div id="incubation" class="tab-items">
                                                <div  class="col-md-6">
                                                        <table width="100%" cellspacing="0" cellpadding="0" class="tableview tableInvest" >
                                                        <thead><tr><th>Incubators</th><th>Deal Period</th></tr></thead>
                                                            <tbody>
                                                    <?php
                                                         
                                                            if($incubator_cnt>0)
                                                            {   
                                                                While($incrow=mysql_fetch_array($incrs, MYSQL_BOTH))
                                                                {
                                                                    $incubator=$incrow["Incubator"];
                                                                    $incubatorId=$incrow["IncubatorId"];
                                                                    $incubatordate=$incrow["dt"];?>
                                                            <tr>
                                                            <td> <p><a href='incubatordetails.php?value=<?php echo $incubatorId.'/'.$strvalue[1].'/'.$strvalue[2].'/'.$strvalue[3];?>' title="Incubator Details"> <?php echo $incubator;?> </a></p> </td>
                                                            <td><a href='incubatordetails.php?value=<?php echo $incubatorId.'/'.$VCFlagValue;?>' target="_blank"> <?php echo $incubatordate;?></a></td>
                                                            
                                                            </tr>
                                                             <?php       
                                                                }
                                                        ?>   
                                                       
                                                       
   
                                                               

                                                     <?php } ?>
                                                        </tbody>
                                                        </table>
                                                        </div>  
                                                </div>

                                            </div>
                                                            <?php }else{ ?>
                                                                <p class="text-center" style="font-size:10pt;font-weight:600;padding: 10px;text-align:center;"> No data available. </p>
                                                            <?php } ?>

                                                

                                        </div>
                                            
                                             
                                                   
                                             
                                         
                    
                            <div style="clear: both;"></div>
                            
                                    </div>
        
        
        
        
    
                
       
            
        <!-- Angel Only Start -->
        <div class="row masonry " style="margin-top: 15px;">
            <div class="col-6">
                <div  class="work-masonry-thumb1 accordian-group">
                 
                        <div class="accordions" style="margin-bottom: 40px;">
                            <div class="accordions_dealtitle active"><span></span>
                                <h2 id="companyinfo" class="box_heading content-box ">Tags</h2>
                            </div>
                             <div class="accordions_dealcontent" style="display: none;">
                                 <?php 
                            if ($myrow["tags"] != "") 
                            { 
                                    ?>   
                    <div class="">
                     <?php $ex_tags = explode(',',$myrow["tags"]);
                     if(count($ex_tags) > 0){
                        for($k=0;$k<count($ex_tags);$k++){
                            if($ex_tags[$k] !=''){
                                $ex_tags_inner = explode(':',$ex_tags[$k]);
                                $inner_tag = trim($ex_tags_inner[1]);
                                if($inner_tag !='' && trim($ex_tags_inner[0]) != 'c') {  ?>
                                    <div class="tagelements" style="display:inline-block;margin: 8px 0px;">
                                        <span><a href="javascript:void(0)" class="tags_link"><?php echo $inner_tag; ?></a></span>
                                    </div>             
                            <?php }
                            }
                        }
                    } ?>       
                    <div style="clear:both"></div>              
                    </div>  

                    <!--Header-->
                    <?php if($vcflagValue=="0" || $vcflagValue=="1")
                    {
                        $actionlink1="index.php?value=".$vcflagValue;
                    }
                    else if($vcflagValue=="4" || $vcflagValue=="5" || $vcflagValue=="3")
                    {
                            $actionlink1="svindex.php?value=".$vcflagValue;
                    }
                    else if($vcflagValue=="6"){
                            $actionlink1="incindex.php";
                    }else if($vcflagValue=="2"){
                         $actionlink1="angelindex.php";
                    }
                    ?>
                    <?php
                            } else { 
                                echo '<p class="text-center" style="font-size:10pt;font-weight:600;padding: 10px;text-align:center;"> No data available. </p>';
                            }?>
                            <form action="<?php echo $actionlink1; ?>" name="tagForm" id="tagForm"  method="post">
                <input type="hidden" value="" name="searchTagsField" id="searchTagsField" />
              </form>
        </div> 
                    </div>
          

         </div>
            </div>
            <div class="col-6">
                <div  class="work-masonry-thumb1 accordian-group">
                 
                            
                  
                  <div class="accordions">
                    <div class="accordions_dealtitle active"><span></span>
                       <h2 id="companyinfo" class="box_heading content-box ">Related Companies</h2>
                    </div>
                    <div class="accordions_dealcontent" style="display: none;">
 <?php 
                                    if ($myrow["tags"] != "") 
                                    { 
                                            ?>  
                            <div >
                             <?php 
                                $company_id = array();$s=0; 
                                $ex_tags = explode(',',$myrow["tags"]);
                                $noCompanytags = false;
                                 if(count($ex_tags) > 0){
                                    for($k=0;$k<count($ex_tags);$k++){
                                        if($ex_tags[$k] !=''){
                                            $ex_tags_inner = explode(':',$ex_tags[$k]);
                                            $inner_tag = trim($ex_tags_inner[0]);
                                            $inner_tag_val = trim($ex_tags_inner[1]);
                                            if($inner_tag =='c') {
                                                $noCompanytags = true;
                                                $CompanyQuery = mysql_query("SELECT PECompanyId,companyname FROM pecompanies where (tags like '%c:$inner_tag_val%' or tags like '%c: $inner_tag_val%' or tags like '%c : $inner_tag_val%'     or tags like '%c : $inner_tag_val%') and PECompanyId != '$SelCompRef'");
                                                if(mysql_num_rows($CompanyQuery) >0){ ?>
                                <div class="relatedcompanies" <?php if($s != 0) { ?>style="border-top: 1px solid #d4d4d4;"<?php } ?>>
                                <?php
                                                    while($myrow1=mysql_fetch_array($CompanyQuery, MYSQL_BOTH))
                                                    { 
                                                        if(!in_array($myrow1["PECompanyId"], $company_id)){                                    
                                                            $company_id[] = $myrow1["PECompanyId"]; ?>
                                                            <div class="tagelementss" >
                                                            
                                                                <span><a href="companydetails.php?value=<?php echo $myrow1["PECompanyId"].'/'.$VCFlagValue.'/';?>"><?php echo $myrow1['companyname']; ?></a></span>
                </div>
                                                    <?php  }                                  
                                                    } ?>
                                    <div style="clear:both"></div>
                                </div>
                                <?php  $s++; 
                                                }
                                            }
                                        }
                                    }
                                } ?> 

                                <?php if(!$noCompanytags){
                                    echo '<p class="text-center" style="font-size:10pt;font-weight:600;padding: 10px;text-align:center;"> No data available. </p>';
                                }?>                    
                            </div>  
                            <?php
                                    } else {
                                        echo '<p class="text-center" style="font-size:10pt;font-weight:600;padding: 10px;text-align:center;"> No data available. </p>';
                                    }?>
                    </div>
                 </div>
                 
                 </div>
            </div>
        </div>
        <div class="clearfix"></div>
    
    
</div>
    
    
    
    
<!-- -->    
    
    
    
    

                                                        
      <?php
                        }
                    }
                }
                    ?>                       
  </div>
   
    <?php
    if(($exportToExcel==1) && (!isset($_REQUEST['angelco_only'])))
    {
    ?>
                    <!-- <span style="float:right" class="one">
                             <input class ="export_new exlexport" type="button" id="expshowdealsbtn"  value="Export" name="showdeals">
                    </span> -->
                <script type="text/javascript">
                    $('#exportbtn').html('<input style="margin-left: 5px;" class ="export_new exlexport"  type="button" id="expshowdeals"  value="Export" name="showdeals">');
                </script>
    <?php
    }
    ?>

</td></tr></table>
<!--T969 changes-->
<input class="postlink" type="hidden" name="country" value="<?php
    echo $countrytxt;
?>">
                           <input class="postlink" type="hidden" name="countryNIN" value="<?php if($countryNINtxt1 !=''){
    echo $countryNINtxt1;}else { if(gettype($countryNINtxt)=="array"){$countryNINtxt2=implode(",",$countryNINtxt); echo $countryNINtxt2;}else{echo $countryNINtxt;}}
?>">
                            <input class="postlink" type="hidden" name="cityflag" value="<?php
    echo $cityflag;
?>" >
                            <input class="postlink" type="hidden" name="countryNINflag" value="<?php
    echo $countryNINval;
?>" >
                                   <input class="postlink" type="hidden" name="city" value="<?php if($cityid1 !=''){
    echo $cityid1;}else { if(gettype($cityid)=="array"){$cityid2=implode(",",$cityid); echo $cityid2;}else{echo $cityid;} }
?>">
<!--T969 changes-->
</form></div>


<form name="companyDisplay"  id="companyDisplay" method="post" action="exportcompanyprofile.php">
 <input type="hidden" name="txthideCompanyId" value="<?php echo $SelCompRef;?>" >
			<input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
            <input type="hidden" name="comname" value="<?php echo $compname;?>" >
</form>                        
<div class=""></div>
</div>


<script type="text/javascript">
     
     
     $(document).ready(function() {
        var ventureInvestment =  $( "#ventureInvestment" ).has( "td" ).length ;
        if(ventureInvestment==0){ $( ".vicomp-cnt, #ventureInvestment" ).hide() ;   }
             
        
     });
     
     </script>
 <script type="text/javascript">
			
            $('.tags_link').click(function(){ 
                    $("#searchTagsField").val('tag:'+$(this).html());
                    $('#tagForm').submit();
                });
           /* $('#expshowdeals,.exlexport').click(function(){ 
                    hrefval= 'exportcompanyprofile.php';
            $("#companyDisplay").attr("action", hrefval);
            $("#companyDisplay").submit();
            return false;
            });*/
            $(document).ready(function() {
                $("#ymessage").on('keydown', function() {
                    var words = this.value.match(/\S+/g).length;
                    var character = this.value.length;

                    if (words == 201) {

                        $("#ymessage").attr('maxlength',character);
                    }
                    if(words > 200){
                         alert("Text reached above 200 words");
                    }
                    else {
                        $('#word_left').text(200-words);
                    }
                });
             });
     
           
            $(document).on('click','#expshowdeals',function(){

                $('#maskscreen').fadeIn(1000);
                $('#popup-box-copyrights').fadeIn();   
                    return false;
                });

                $('#expshowdealsbtn').click(function(){ 
                jQuery('#maskscreen').fadeIn(1000);
                jQuery('#popup-box-copyrights').fadeIn();   
                    return false;
                });
               
             $('#senddeal').click(function(){ 
                    jQuery('#maskscreen').fadeIn(1000);
                    jQuery('#popup-box').fadeIn();   
                    return false;
                });
                 $('#cancelbtn').click(function(){ 

                    jQuery('#popup-box').fadeOut();   
                     jQuery('#maskscreen').fadeOut(1000);
                    return false;
                });
                 function validateEmail(field) {
                    var regex = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return (regex.test(field)) ? true : false;
                }
                function checkEmail() {

                    var email = $("#toaddress").val();
                        if (email != '') {
                            var result = email.split(",");
                            for (var i = 0; i < result.length; i++) {
                                if (result[i] != '') {
                                    if (!validateEmail(result[i])) {

                                        alert('Please check, `' + result[i] + '` email addresses not valid!');
                                        email.focus();
                                        return false;
                                    }
                                }
                            }
                    }
                    else
                    {
                        alert('Please enter email address');
                        email.focus();
                        return false;
                    }
                    return true;
                }  
               
                function initExport(){
                        $.ajax({
                            url: 'ajxCheckDownload.php',
                            dataType: 'json',
                            success: function(data){
                                var downloaded = data['recDownloaded'];
                                var exportLimit = data.exportLimit;
                                var currentRec = 1;

                                //alert(currentRec + downloaded);
                                var remLimit = exportLimit-downloaded;

                                if (currentRec <= remLimit){
                                    //hrefval= 'exportinvdeals.php';
                                    //$("#pelisting").attr("action", hrefval);
                                    $("#companyDisplay").submit();
                                    jQuery('#preloading').fadeOut();
                                }else{
                                    jQuery('#preloading').fadeOut();
                                    //alert("You have downloaded "+ downloaded +" records of allowed "+ exportLimit +" records(within 48 hours). You can download "+ remLimit +" more records.");
                                    alert("Currently your export action is crossing the limit of "+ exportLimit +" records. You can download "+ remLimit +" more records. To increase the limit please contact info@ventureintelligence.com");
                                }
                            },
                            error:function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem exporting...");
                            }

                        });
                    }
              $('#mailbtn').click(function(){ 
                        
            if(checkEmail())
            {


            $.ajax({
                url: 'ajaxsendmail.php',
                 type: "POST",
                data: { to : $("#toaddress").val(),subject : $("#subject").val(), basesubject : $("#basesubject").val(), message : $("#message").val() , ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },
                success: function(data){
                        if(data=="1"){
                             alert("Mail Sent Successfully");
                            jQuery('#popup-box').fadeOut();   
                            jQuery('#maskscreen').fadeOut(1000);

                    }else{
                        jQuery('#popup-box').fadeOut();   
                        jQuery('#maskscreen').fadeOut(1000);
                        alert("Try Again");
                    }
                },
                error:function(){
                    jQuery('#preloading').fadeOut();
                    alert("There was some problem sending mail...");
                }

            });
            }

        });
</script>
<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
   <span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
    <div class="copyright-body" style="text-align: center;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
    </div>
    <div class="cr_entry" style="text-align:center;">
        
        <input type="button" value="I Agree" id="agreebtn" />
    </div>

</div>

<script>
    $("a.postlink").click(function () {

        hrefval = $(this).attr("href");

        $("#pesearch").attr("action", hrefval);
        $("#pesearch").submit();
        return false;

    });                                 
$(document).on('click','#agreebtn',function(){
         $('#popup-box-copyrights').fadeOut();   
        $('#maskscreen').fadeOut(1000);
        $('#preloading').fadeIn();   
        initExport();
        return false; 
     });
    
     $(document).on('click','#expcancelbtn',function(){

        jQuery('#popup-box-copyrights').fadeOut();   
        jQuery('#maskscreen').fadeOut(1000);
        return false;
    });
</script>
<?php mysql_close(); ?>
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
 function highlightWords($text, $words)
 {

         /*** loop of the array of words ***/
         foreach ($words as $worde)
         {

                 /*** quote the text for regex ***/
                 $word = preg_quote($worde);
                 /*** highlight the words ***/
                 $text = preg_replace("/\b($worde)\b/i", '<span class="highlight_word">\1</span>', $text);
         }
         /*** return the text ***/
         return $text;
 }

 	function return_insert_get_RegionIdName($regionidd)
	{
		$dbregionlink = new dbInvestments();
		$getRegionIdSql = "select Region from region where RegionId=$regionidd";

                if ($rsgetInvestorId = mysql_query($getRegionIdSql))
		{
			$regioncnt=mysql_num_rows($rsgetInvestorId);
			//echo "<br>Investor count-- " .$investor_cnt;

			if($regioncnt==1)
			{
				While($myrow=mysql_fetch_array($rsgetInvestorId, MYSQL_BOTH))
				{
					$regionIdname = $myrow[0];
					//echo "<br>Insert return investor id--" .$invId;
					return $regionIdname;
				}
			}
		}
		$dbregionlink.close();
	}
    function curPageURL() {
        $URL = 'http';
        $portArray = array( '80', '443' );
        if ($_SERVER["HTTPS"] == "on") {$URL .= "s";}
        $URL .= "://";
        if (!in_array( $_SERVER["SERVER_PORT"], $portArray)) {
         $URL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
        } else {
         $URL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
        }
        $pageURL=$URL."&scr=EMAIL";
        return $pageURL;
       }

?>

<?php if(count($cityid) > 0 ){ ?>
                <script type="text/javascript">
                    // $('#city').select2();
                </script>
            <?php } else if(count($countryNINtxt) > 0) { ?>
                <script type="text/javascript">
                    // $('#countryNIN').select2();
                    $(".city_country_filter_btn").show();
                </script>
            <?php } ?>
<script type="text/javascript" >
            $(document).ready(function() {
                // $('#country').select2({
                //     placeholder: "Select Options",
                //     minimumResultsForSearch: Infinity
                // });
            });
             // Multiple city edit
             var country_val = $('#country').val();
                if(country_val != ''){
                    $(".city_country_filter_btn").show();
                }
                // end multiple city
            // function openCity(country){
            //         var country = country.value;
            //         if(country == "IN"){
            //             $('#city').select2({
            //                 placeholder: "Select City"
            //             });
            //             $('#select2-countryNIN-container').closest('.select2').hide();
            //             jQuery('#countryNIN').val('---');
            //             $(".forCountry").hide();
            //             $(".forCity").show();
            //         } else if(country == "NIN"){
            //             $('#countryNIN').select2({
            //                 placeholder: "Select Country"
            //             });
            //             $('#select2-city-container').closest('.select2').hide();
            //             jQuery('#city').val('');
            //             $(".forCity").hide();
            //             $(".forCountry").show();
            //         } 
            //         if($(window).width() < 1600){
            //             if ($(".left-td-bg").css("min-width") == '264px') {
            //                 $('.tab-view-btn').css('margin-top','10px');
            //             }
            //         }
            //     }

            function openCity(country){
                    var country = country.value;
                    if(country == "IN"){
                        $('#city').multiselect({
                            noneSelectedText: 'Select City'
                        });
                        $('#city_div').show();
                        // $('#city').next().css('width': '250px !important;','height': '30px !important;');
                        $('#country_div').hide();
                        // $('#select2-countryNIN-container').closest('.select2').hide();
                        // $('#countryNIN').next().hide();
                        jQuery('#countryNIN').val('');
                        //$("#countryNINflag").val('1');
                        // $(".forCountry").hide();
                        // $(".forCity").show();
                        $(".city_country_filter_btn").show();
                    } else if(country == "NIN"){
                        // $('#countryNIN').select2({
                        //     placeholder: "Select Country"
                        // });
                        $('#countryNIN').multiselect({
                            noneSelectedText: 'Select Country'
                        });
                        // $('#select2-city-container').closest('.select2').hide();
                        // $('#city').next().hide();
                        jQuery('#city').val('');
                        //$("#countryNINflag").val('1');
                        // $(".forCity").hide();
                        $('#city_div').hide();
                        $('#country_div').show();
                        $(".city_country_filter_btn").show();
                        // $(".forCountry").show();
                    } 
                    if($(window).width() < 1600){
                        if ($(".left-td-bg").css("min-width") == '264px') {
                            $('.tab-view-btn').css('margin-top','10px');
                        }
                    }
                }
                function cascadingCountry(country){
                   var country = country.value;
                   if(country == "IN"){
                       $('#city').multiselect({
                           noneSelectedText: 'Select City'
                       });
                       $('.forCity').show();
                       $('#city option').prop('selected',true);
                       $('#city').multiselect("refresh");
                       $('.forCountry').hide();
                       jQuery('#countryNIN').val('');
                       $(".city_country_filter_btn").show();
                   } else if(country == "NIN"){
                       $('#countryNIN').multiselect({
                           noneSelectedText: 'Select Country'
                       });
                       jQuery('#city').val('');
                       $('.forCity').hide();
                       $('.forCountry').show();
                       $('#countryNIN option').prop('selected',true);
                       $('#countryNIN').multiselect("refresh");
                       $(".city_country_filter_btn").show();
                   } 
                   if($(window).width() < 1600){
                       if ($(".left-td-bg").css("min-width") == '264px') {
                           $('.tab-view-btn').css('margin-top','10px');
                       }
                   }
               }



                function resetinput(fieldname)
                {
                 
                //alert($('[name="'+fieldname+'"]').val());
                  $("#resetfield").val(fieldname);
                  //alert( $("#resetfield").val(fieldname));
                  $("#pesearch").submit();
                    return false;
                }


             $("#panel").animate({width: 'toggle'}, 200); 
             $(".btn-slide").toggleClass("active"); 

             if ($('.left-td-bg').css("min-width") == '264px') {
             $('.left-td-bg').css("min-width", '36px');
             $('.acc_main').css("width", '35px');
             }
             else {
             $('.left-td-bg').css("min-width", '264px');
             $('.acc_main').css("width", '264px');
             }                                        
</script> 
<style>
.tagelementss a {
    color: #7b5e40;
    font-weight: bold;
    display: block;
    font-size: 14px;
    text-decoration: underline;
}
.tagelementss {
    float: left;
    padding: 12px 0px;
    /* padding-right: 12px; */
    margin-bottom: 0px;
    width: 25%;
    min-height: 56px;
    box-sizing: border-box;

}

.select2-container{box-sizing:border-box;display:inline-block;margin:0;position:relative;vertical-align:middle}.select2-container .select2-selection--single{box-sizing:border-box;cursor:pointer;display:block;height:28px;user-select:none;-webkit-user-select:none}.select2-container .select2-selection--single .select2-selection__rendered{display:block;padding-left:8px;padding-right:20px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.select2-container .select2-selection--single .select2-selection__clear{position:relative}.select2-container[dir="rtl"] .select2-selection--single .select2-selection__rendered{padding-right:8px;padding-left:20px}.select2-container .select2-selection--multiple{box-sizing:border-box;cursor:pointer;display:block;min-height:32px;user-select:none;-webkit-user-select:none}.select2-container .select2-selection--multiple .select2-selection__rendered{display:inline-block;overflow:hidden;padding-left:8px;text-overflow:ellipsis;white-space:nowrap}.select2-container .select2-search--inline{float:left}.select2-container .select2-search--inline .select2-search__field{box-sizing:border-box;border:none;font-size:100%;margin-top:5px;padding:0}.select2-container .select2-search--inline .select2-search__field::-webkit-search-cancel-button{-webkit-appearance:none}.select2-dropdown{background-color:white;border:1px solid #aaa;border-radius:4px;box-sizing:border-box;display:block;position:absolute;left:-100000px;width:100%;z-index:1051}.select2-results{display:block}.select2-results__options{list-style:none;margin:0;padding:0}.select2-results__option{padding:6px;user-select:none;-webkit-user-select:none}.select2-results__option[aria-selected]{cursor:pointer}.select2-container--open .select2-dropdown{left:0}.select2-container--open .select2-dropdown--above{border-bottom:none;border-bottom-left-radius:0;border-bottom-right-radius:0}.select2-container--open .select2-dropdown--below{border-top:none;border-top-left-radius:0;border-top-right-radius:0}.select2-search--dropdown{display:block;padding:4px}.select2-search--dropdown .select2-search__field{padding:4px;width:100%;box-sizing:border-box}.select2-search--dropdown .select2-search__field::-webkit-search-cancel-button{-webkit-appearance:none}.select2-search--dropdown.select2-search--hide{display:none}.select2-close-mask{border:0;margin:0;padding:0;display:block;position:fixed;left:0;top:0;min-height:100%;min-width:100%;height:auto;width:auto;opacity:0;z-index:99;background-color:#fff;filter:alpha(opacity=0)}.select2-hidden-accessible{border:0 !important;clip:rect(0 0 0 0) !important;-webkit-clip-path:inset(50%) !important;clip-path:inset(50%) !important;height:1px !important;overflow:hidden !important;padding:0 !important;position:absolute !important;width:1px !important;white-space:nowrap !important}.select2-container--default .select2-selection--single{background-color:#fff;border:1px solid #aaa;border-radius:4px}.select2-container--default .select2-selection--single .select2-selection__rendered{color:#444;line-height:28px}.select2-container--default .select2-selection--single .select2-selection__clear{cursor:pointer;float:right;font-weight:bold}.select2-container--default .select2-selection--single .select2-selection__placeholder{color:#999}.select2-container--default .select2-selection--single .select2-selection__arrow{height:26px;position:absolute;top:1px;right:1px;width:20px}.select2-container--default .select2-selection--single .select2-selection__arrow b{border-color:#888 transparent transparent transparent;border-style:solid;border-width:5px 4px 0 4px;height:0;left:50%;margin-left:-4px;margin-top:-2px;position:absolute;top:50%;width:0}.select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__clear{float:left}.select2-container--default[dir="rtl"] .select2-selection--single .select2-selection__arrow{left:1px;right:auto}.select2-container--default.select2-container--disabled .select2-selection--single{background-color:#eee;cursor:default}.select2-container--default.select2-container--disabled .select2-selection--single .select2-selection__clear{display:none}.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{border-color:transparent transparent #888 transparent;border-width:0 4px 5px 4px}.select2-container--default .select2-selection--multiple{background-color:white;border:1px solid #aaa;border-radius:4px;cursor:text}.select2-container--default .select2-selection--multiple .select2-selection__rendered{box-sizing:border-box;list-style:none;margin:0;padding:0 5px;width:100%}.select2-container--default .select2-selection--multiple .select2-selection__rendered li{list-style:none}.select2-container--default .select2-selection--multiple .select2-selection__placeholder{color:#999;margin-top:5px;float:left}.select2-container--default .select2-selection--multiple .select2-selection__clear{cursor:pointer;float:right;font-weight:bold;margin-top:5px;margin-right:10px}.select2-container--default .select2-selection--multiple .select2-selection__choice{background-color:#e4e4e4;border:1px solid #aaa;border-radius:4px;cursor:default;float:left;margin-right:5px;margin-top:5px;padding:0 5px}.select2-container--default .select2-selection--multiple .select2-selection__choice__remove{color:#999;cursor:pointer;display:inline-block;font-weight:bold;margin-right:2px}.select2-container--default .select2-selection--multiple .select2-selection__choice__remove:hover{color:#333}.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice,.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__placeholder,.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-search--inline{float:right}.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice{margin-left:5px;margin-right:auto}.select2-container--default[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove{margin-left:2px;margin-right:auto}.select2-container--default.select2-container--focus .select2-selection--multiple{border:solid black 1px;outline:0}.select2-container--default.select2-container--disabled .select2-selection--multiple{background-color:#eee;cursor:default}.select2-container--default.select2-container--disabled .select2-selection__choice__remove{display:none}.select2-container--default.select2-container--open.select2-container--above .select2-selection--single,.select2-container--default.select2-container--open.select2-container--above .select2-selection--multiple{border-top-left-radius:0;border-top-right-radius:0}.select2-container--default.select2-container--open.select2-container--below .select2-selection--single,.select2-container--default.select2-container--open.select2-container--below .select2-selection--multiple{border-bottom-left-radius:0;border-bottom-right-radius:0}.select2-container--default .select2-search--dropdown .select2-search__field{border:1px solid #aaa}.select2-container--default .select2-search--inline .select2-search__field{background:transparent;border:none;outline:0;box-shadow:none;-webkit-appearance:textfield}.select2-container--default .select2-results>.select2-results__options{max-height:200px;overflow-y:auto}.select2-container--default .select2-results__option[role=group]{padding:0}.select2-container--default .select2-results__option[aria-disabled=true]{color:#999}.select2-container--default .select2-results__option[aria-selected=true]{background-color:#ddd}.select2-container--default .select2-results__option .select2-results__option{padding-left:1em}.select2-container--default .select2-results__option .select2-results__option .select2-results__group{padding-left:0}.select2-container--default .select2-results__option .select2-results__option .select2-results__option{margin-left:-1em;padding-left:2em}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-2em;padding-left:3em}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-3em;padding-left:4em}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-4em;padding-left:5em}.select2-container--default .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option .select2-results__option{margin-left:-5em;padding-left:6em}.select2-container--default .select2-results__option--highlighted[aria-selected]{background-color:#5897fb;color:white}.select2-container--default .select2-results__group{cursor:default;display:block;padding:6px}.select2-container--classic .select2-selection--single{background-color:#f7f7f7;border:1px solid #aaa;border-radius:4px;outline:0;background-image:-webkit-linear-gradient(top, #fff 50%, #eee 100%);background-image:-o-linear-gradient(top, #fff 50%, #eee 100%);background-image:linear-gradient(to bottom, #fff 50%, #eee 100%);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFFFFFFF', endColorstr='#FFEEEEEE', GradientType=0)}.select2-container--classic .select2-selection--single:focus{border:1px solid #5897fb}.select2-container--classic .select2-selection--single .select2-selection__rendered{color:#444;line-height:28px}.select2-container--classic .select2-selection--single .select2-selection__clear{cursor:pointer;float:right;font-weight:bold;margin-right:10px}.select2-container--classic .select2-selection--single .select2-selection__placeholder{color:#999}.select2-container--classic .select2-selection--single .select2-selection__arrow{background-color:#ddd;border:none;border-left:1px solid #aaa;border-top-right-radius:4px;border-bottom-right-radius:4px;height:26px;position:absolute;top:1px;right:1px;width:20px;background-image:-webkit-linear-gradient(top, #eee 50%, #ccc 100%);background-image:-o-linear-gradient(top, #eee 50%, #ccc 100%);background-image:linear-gradient(to bottom, #eee 50%, #ccc 100%);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFEEEEEE', endColorstr='#FFCCCCCC', GradientType=0)}.select2-container--classic .select2-selection--single .select2-selection__arrow b{border-color:#888 transparent transparent transparent;border-style:solid;border-width:5px 4px 0 4px;height:0;left:50%;margin-left:-4px;margin-top:-2px;position:absolute;top:50%;width:0}.select2-container--classic[dir="rtl"] .select2-selection--single .select2-selection__clear{float:left}.select2-container--classic[dir="rtl"] .select2-selection--single .select2-selection__arrow{border:none;border-right:1px solid #aaa;border-radius:0;border-top-left-radius:4px;border-bottom-left-radius:4px;left:1px;right:auto}.select2-container--classic.select2-container--open .select2-selection--single{border:1px solid #5897fb}.select2-container--classic.select2-container--open .select2-selection--single .select2-selection__arrow{background:transparent;border:none}.select2-container--classic.select2-container--open .select2-selection--single .select2-selection__arrow b{border-color:transparent transparent #888 transparent;border-width:0 4px 5px 4px}.select2-container--classic.select2-container--open.select2-container--above .select2-selection--single{border-top:none;border-top-left-radius:0;border-top-right-radius:0;background-image:-webkit-linear-gradient(top, #fff 0%, #eee 50%);background-image:-o-linear-gradient(top, #fff 0%, #eee 50%);background-image:linear-gradient(to bottom, #fff 0%, #eee 50%);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFFFFFFF', endColorstr='#FFEEEEEE', GradientType=0)}.select2-container--classic.select2-container--open.select2-container--below .select2-selection--single{border-bottom:none;border-bottom-left-radius:0;border-bottom-right-radius:0;background-image:-webkit-linear-gradient(top, #eee 50%, #fff 100%);background-image:-o-linear-gradient(top, #eee 50%, #fff 100%);background-image:linear-gradient(to bottom, #eee 50%, #fff 100%);background-repeat:repeat-x;filter:progid:DXImageTransform.Microsoft.gradient(startColorstr='#FFEEEEEE', endColorstr='#FFFFFFFF', GradientType=0)}.select2-container--classic .select2-selection--multiple{background-color:white;border:1px solid #aaa;border-radius:4px;cursor:text;outline:0}.select2-container--classic .select2-selection--multiple:focus{border:1px solid #5897fb}.select2-container--classic .select2-selection--multiple .select2-selection__rendered{list-style:none;margin:0;padding:0 5px}.select2-container--classic .select2-selection--multiple .select2-selection__clear{display:none}.select2-container--classic .select2-selection--multiple .select2-selection__choice{background-color:#e4e4e4;border:1px solid #aaa;border-radius:4px;cursor:default;float:left;margin-right:5px;margin-top:5px;padding:0 5px}.select2-container--classic .select2-selection--multiple .select2-selection__choice__remove{color:#888;cursor:pointer;display:inline-block;font-weight:bold;margin-right:2px}.select2-container--classic .select2-selection--multiple .select2-selection__choice__remove:hover{color:#555}.select2-container--classic[dir="rtl"] .select2-selection--multiple .select2-selection__choice{float:right}.select2-container--classic[dir="rtl"] .select2-selection--multiple .select2-selection__choice{margin-left:5px;margin-right:auto}.select2-container--classic[dir="rtl"] .select2-selection--multiple .select2-selection__choice__remove{margin-left:2px;margin-right:auto}.select2-container--classic.select2-container--open .select2-selection--multiple{border:1px solid #5897fb}.select2-container--classic.select2-container--open.select2-container--above .select2-selection--multiple{border-top:none;border-top-left-radius:0;border-top-right-radius:0}.select2-container--classic.select2-container--open.select2-container--below .select2-selection--multiple{border-bottom:none;border-bottom-left-radius:0;border-bottom-right-radius:0}.select2-container--classic .select2-search--dropdown .select2-search__field{border:1px solid #aaa;outline:0}.select2-container--classic .select2-search--inline .select2-search__field{outline:0;box-shadow:none}.select2-container--classic .select2-dropdown{background-color:#fff;border:1px solid transparent}.select2-container--classic .select2-dropdown--above{border-bottom:none}.select2-container--classic .select2-dropdown--below{border-top:none}.select2-container--classic .select2-results>.select2-results__options{max-height:200px;overflow-y:auto}.select2-container--classic .select2-results__option[role=group]{padding:0}.select2-container--classic .select2-results__option[aria-disabled=true]{color:grey}.select2-container--classic .select2-results__option--highlighted[aria-selected]{background-color:#3875d7;color:#fff}.select2-container--classic .select2-results__group{cursor:default;display:block;padding:6px}.select2-container--classic.select2-container--open .select2-dropdown{border-color:#5897fb}
.select2-dropdown{
    border-radius: 0px;
}
.search-area input[type="text"] {
    width: 290px !important;
    margin-right: -1px;
}
.search-area input[type="button"], .search-area input[type="submit"]{
    height: 27px;
}
.select2-container--default .select2-results__option[aria-selected=true] {
    background-color: #e0d9c4;
}
.select2-container--default .select2-results__option--highlighted[aria-selected] {
    background-color: #a2743a;
    color: white;
}
.select2-container--default .select2-selection--single{
    border: 1px solid #a2743a;
    border-radius: 0px;
}
.select2-container--default.select2-container--open .select2-selection--single .select2-selection__arrow b{
    border-color: #a2743a transparent transparent transparent;
}
.select2-container--default .select2-selection--single .select2-selection__arrow b{
    border-color: #a2743a transparent transparent transparent;
}
.select2-container--default .select2-selection--single .select2-selection__placeholder {
    color: #999;
    font-size: 13px;
}
.select2-container--default .select2-results__option--highlighted[aria-selected]:first-letter, .select2-results__option::first-letter, .select2-selection__rendered::first-letter {
    text-transform: uppercase;
}
#select2-city-results .select2-results__option{
    padding: 6px;
    user-select: none;
    -webkit-user-select: none;
    text-transform: lowercase !important;
}
span#select2-city-container {
    text-transform: lowercase;
}
    .com-investment-profile{
        width: 33%
    }
    .bor-top-cnt{
        border-top: 1px solid #e4e4e4;
        clear: both;
        padding-top: 10px;
    }
    .mar-top {
        margin: 0px 15px 10px;
    }
    .inv-lf-li{
        min-height: 100px;
    }
    .note-nia {
        position: absolute;
        font-size: 13px;
        margin-bottom: 0px;
    }
    .for-nai{
        margin-bottom: 30px;
    }
</style>
<?php
	mysql_close();
    mysql_close($cnx);
?>
<script>
 $(document).ready(function() {
    //alert(  $('.tabView li').length);
    var tabView = [];
    var flag=0;
    $('.tabView li').each(function() {
            var heading =$(this).text();
            tabView.push(heading);
        })
        for(i=0;i<tabView.length;i++)
        {
            if(tabView[i] != "PE/VC INVESTMENTS")
            {
                flag =1;
            }
            else{
                flag =0;
            }
        }
        if(flag == 1)
        {
            var selectedtab = $('.tabView li:first').attr('href');
                 $('.tabView li:first').addClass('current'); 
                $(selectedtab).addClass('activetab');
        }
    // if($('.tabView li').length == 1)
    // {
    //     var selectedtab = $('.tabView li:first').attr('href');
    //     $('.tabView li:first').addClass('current'); 
    //     $(selectedtab).addClass('activetab');

    // }
         $('.tabView li').click(function(){
            var selectedtab = $(this).attr('href');
            $('.tab-items').removeClass('activetab');
            $('.tabView li').removeClass('current');
            $(this).addClass('current');
            $(selectedtab).addClass('activetab');
         });

         
         $(".newslinktooltip a").mouseover(function(){
            $($(this).attr('data-target')).css("display","block");
        });  
        $(".newslinktooltip a").mouseout(function(){
            $($(this).attr('data-target')).css("display","none");
        });
      });
$(".accordions_dealtitle").on("click", function() {
    
    $(this).toggleClass("active").next().slideToggle();
});
$resulttag = $('.result-title').height();
$resulttagwidth = $('.result-select').width();
            $resulttaglist = $('.result-select').height();
            if($resulttaglist > 45)
            {
            $('.result-title').addClass('resettag');
            $('.result-select').addClass('resettaglist');
            $('.mt-list-tab').addClass('tablist');
            }else
            {
            $('.result-title').removeClass('resettag');
            $('.result-select').removeClass('resettaglist');
            $('.mt-list-tab').removeClass('tablist');
            //$('.list-tab').css('margin-top',$('.result-title').height()+30);
            }
</script>