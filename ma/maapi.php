<?php
    require_once("../dbconnectvi.php");
    $Db = new dbInvestments();
    include ('machecklogin.php'); 
    $section = isset($_POST['section']) ? $_POST['section'] : 1; // For Deals 1, for Directory 2.
     
    if($section==1){
        
        $dealType = isset($_POST['dealtype']) ? $_POST['dealtype'] : '1,2,3';//  DealType (Inbound 1, Outbound 2, Domestic 3)
        $dealtype_exp = explode(',',$dealType);
        foreach($dealtype_exp as $dealtypeId)
        {
            
            $madealtype = $madealtype. " pe.MADealTypeId=" .$dealtypeId." or ";

            $wheredealtype = $madealtype ;							
            $strlength=strlen($wheredealtype);
            $strlength=$strlength-3;
            //echo "<Br>----------------" .$wherestage;
            $wheredealtype= substr ($wheredealtype , 0,$strlength);

            if($wheredealtype){   $wheredealtype ="(".$wheredealtype.")";  }
            else{    $wheredealtype ="";     }
        }
        
        $company = isset($_POST['company']) ? $_POST['company'] : ''; // For company
        
        if($company!=''){

            $companysearch = $timeexp = explode('/',$company);

            if($companysearch[0] != ''){

                $comsql = "SELECT GROUP_CONCAT(PECompanyId) as companyId FROM  `pecompanies` WHERE  `companyname` LIKE  '$companysearch[0]'";
                $comrs = mysql_query($comsql);
                $comres = mysql_fetch_array($comrs);
                
                $companysearch_type = isset($companysearch[1]) ? $companysearch[1] : 1;
                $company_search = " AND pec.PECompanyId IN (".$comres['companyId'].")";
                if($companysearch_type==2){

                    $select_acq = ", ac.Acquirer";
                    $acquirer = ", acquirers as ac";
                    $acquiere_where = " and ac.AcquirerId=pe.AcquirerId";
                }else if($companysearch_type==1){
                    
                    $acquirer = "";
                    $acquiere_where = "";
                }
            }
             
        }else{
            $company_search = '';
        }

       //  From - to date 
        
        if($company_search!=''){
           
            $from_date = "2004-01-01";
            $to_date =  date('Y')."-12-31";
        }else{
            
            $time = $_POST['time']; // For month 01/2016, for quater 1Q/2016, for year only 2016, default current year.
            if($time != ''){

                $timeexp = explode('/',$time);

                if(count($timeexp)>1)
                {
                    if(preg_match("/[a-zA-Z]/i", $timeexp[0])){

                        if($timeexp[0] == '1Q'){

                            $from_date = $timeexp[1]."-01-01";
                            $to_date = $timeexp[1]."-03-31";
                        }elseif($timeexp[0] == '2Q'){

                            $from_date = $timeexp[1]."-04-01";
                            $to_date = $timeexp[1]."-06-30";
                        }elseif($timeexp[0] == '3Q'){

                            $from_date = $timeexp[1]."-07-01";
                            $to_date = $timeexp[1]."-09-30";
                        }elseif($timeexp[0] == '4Q'){

                            $from_date = $timeexp[1]."-10-01";
                            $to_date = $timeexp[1]."-12-31";
                        }else{

                            echo 'Invalid input.Please provide proper input e.g. 1Q for First Quater/ 2Q for Second Quater/ 3Q for Third Quater/ 4Q for Fourth Quater.';
                        }
                    }else{

                        $from_date = $timeexp[1]."-".$timeexp[0]."-01";
                        $to_date = $timeexp[1]."-".$timeexp[0]."-31";
                    }
                }else{
                    
                    $from_date = $timeexp[0]."-01-01";
                    $to_date = $timeexp[0]."-12-31";
                }

            }else{

                $from_date = "2004-01-01";
                $to_date = date('Y')."-12-31";
            }
        }
        $datatype = isset($_POST['datatype']) ? $_POST['datatype'] : 1; // For Detail 1, for aggregate 2.
        
        if($company_search==""){
            
            $sql = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business,
            pe.Amount,MAMAId,Asset,hideamount,pe.AcquirerId,ac.Acquirer,AggHide,DATE_FORMAT( DealDate, '%M-%Y' ) as dates,DealDate as DealDate 
            FROM mama AS pe, industry AS i, pecompanies AS pec,acquirers as ac
            WHERE DealDate between '" . $from_date . "' and '" . $to_date . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID and ac.AcquirerId=pe.AcquirerId
            AND pe.Deleted =0 and pec.industry != 15 and ".$wheredealtype;
        }else{
            
            $sql = "SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, sector_business as sector_business,
            pe.Amount,MAMAId,Asset,hideamount,pe.AcquirerId".$select_acq.",AggHide,DATE_FORMAT( DealDate, '%M-%Y' ) as dates,DealDate as DealDate 
            FROM mama AS pe, industry AS i, pecompanies AS pec ".$acquirer."
            WHERE DealDate between '" . $from_date . "' and '" . $to_date . "' and  pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyID ".$acquiere_where."
            AND pe.Deleted =0 and pec.industry != 15 " .$company_search." and ".$wheredealtype;
        }
        
        $results = mysql_query($sql);
        
        if($datatype==1){

            if(mysql_num_rows($results) > 0){

                while($data_res = mysql_fetch_array($results)) {

                    $res1 = array();
                    $data_inner = array();
                    $dealsql ="SELECT pe.PECompanyId, pec.companyname,pec.CINNo,pe.Stake, pec.industry, i.industry, pec.sector_business,pec.countryid as TargetCountryId,pec.city as TargetCity,
                    Amount, DATE_FORMAT( DealDate, '%M-%Y' ) as dt,DATE_FORMAT(ModifiedDate,'%m/%d/%Y %H:%i:%s') as modifieddate,
                    pec.website,c.country as TargetCountry, pe.MAMAId,pe.Comment,MoreInfor,pe.MADealTypeId,dt.MADealType,pe.AcquirerId,ac.Acquirer,pe.Asset,pe.hideamount,pe.Link,
                    pe.uploadfilename,pe.source,pe.Valuation,pe.FinLink,Company_Valuation,Revenue_Multiple,EBITDA_Multiple,PAT_Multiple,target_listing_status,acquirer_listing_status
                    FROM mama AS pe, industry AS i, pecompanies AS pec,madealtypes as dt,acquirers as ac,country as c
                    WHERE  i.industryid=pec.industry and c.countryid=pec.countryid AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.MAMAId=".$data_res['MAMAId']."
                    and dt.MADealTypeId=pe.MADealTypeId and ac.AcquirerId=pe.AcquirerId";

                    if ($companyrs = mysql_query($dealsql))
                    {  
                        if($myrow = mysql_fetch_array($companyrs,MYSQL_BOTH))
                        {
                            $data_inner['CompanyName'] = trim($myrow["companyname"]);
                            if($myrow["CINNo"]!='' && $myrow["CINNo"]!='NULL'){
                    
                                $data_inner['CIN'] = trim($myrow["CINNo"]);
                            }else{
                                $data_inner['CIN'] = "";
                            }
                            
                            if($myrow["Amount"]==0)
                                $hideamount=0;
                            elseif($myrow["hideamount"]==1)
                                $hideamount=0;
                            else
                                $hideamount=trim($myrow["Amount"]);

                            $res1['Deal_Amount'] = $hideamount;

                            if($myrow["Stake"]!=''){

                                $res1['stack'] = trim($myrow["Stake"]);
                            }else{
                                
                                $res1['stack'] = 0;
                            }
                            if($myrow["MADealType"]!=''){

                                $res1['DealType'] = trim($myrow["MADealType"]);
                            }else{
                                
                                $res1['DealType'] = "";
                            }
                            if($myrow["dt"]!=''){
                                
                                $res1['date'] = trim($myrow["dt"]);
                            }else{
                                
                                $res1['date'] = "-";
                            }

                        }
                        $data_inner['Deal_Info'][] = $res1;
                    }

                    $res4 =  array();
                    if($myrow["companyname"] != ''){

                        $res4['companyname'] = trim($myrow["companyname"]);
                    }else{
                        
                        $res4['companyname'] = "";
                    }

                    if($myrow["listing_status"] == "L"){

                       $res4['companyType'] = "Listed";
                    }
                    elseif($myrow["listing_status"] == "U"){

                        $res4['companyType'] = "Unlisted"; 
                    }else{
                        
                        $res4['companyType'] = ""; 
                    }

                    if($myrow["industry"] != "") {

                        $res4['industry'] = $myrow["industry"]; 
                    }else{

                        $res4['industry'] = ""; 
                    }

                    if($myrow["sector_business"] != "") {

                        $res4['sector_business'] = trim($myrow["sector_business"]); 
                    }else{

                        $res4['sector_business'] = ""; 
                    }

                    if($myrow["city"] != "" || $myrow["city"] != 'null') {

                        $res4['city'] = trim($myrow["city"]);
                    }else{

                        $res4['city'] = ""; 
                    }

                    $regionid=$myrow["RegionId"];
                    if($regionid > 0)
                    { 

                        $res4['region'] = return_insert_get_RegionIdName($regionid);  
                    }
                    else
                    {

                        $res4['region'] = trim($myrow["region"]);  
                    }

                    if($myrow["website"] != ''){

                        $res4['website'] = trim($myrow["website"]);
                    }else{

                        $res4['website'] = '';
                    }

                    $linkrow = $myrow["Link"];
                    $linkstring = str_replace('"','',$linkrow);
                    $linkstring = explode(";",$linkstring);
                    if(count($linkstring) > 0) {

                        foreach ($linkstring as $linkstr)
                        {
                            
                            if(trim($linkstr) != "")
                            {

                                $res4['Link'] = trim(str_replace("\r\n",' ', $linkstr));
                            }
                        }
                    }
                    $data_inner['Company_Info'][] = $res4;

                    $res2 = array();
                    if($myrow["Acquirer"]!=''){

                        $res2['Acquirer'] = trim($myrow["Acquirer"]);
                    }else{
                        
                        $res2['Acquirer'] = "";
                    }

                   if($myrow["acquirer_listing_status"]=="L")
                       $res2['acquirer_listing_stauts'] = "Listed";
                   elseif($myrow["acquirer_listing_status"]=="U")
                       $res2['acquirer_listing_stauts'] = "Unlisted";
                   else
                       $res2['acquirer_listing_stauts'] = '';

                    $getAcquirerCityCountrySql = "select ac.CityId,ac.countryid,co.country from acquirers as ac,
                    country as co where ac.AcquirerId=".$myrow["AcquirerId"]." and co.countryid=ac.countryid";

                    if($cityrs=mysql_query($getAcquirerCityCountrySql))
                    {
                        
                        if($mycityrow=mysql_fetch_array($cityrs,MYSQL_BOTH))
                        {
                            
                            $Acquirercityname=$mycityrow["CityId"];
                            $Acquirercountryname=$mycityrow["country"];
                        }
                    }
                    if($Acquirercityname!=''){

                        $res2['Acquirercityname'] = trim($Acquirercityname);
                    }else{
                        $res2['Acquirercityname'] = "";
                    }
                   if($Acquirercountryname!=''){

                        $res2['Acquirercountryname'] = trim($Acquirercountryname);
                    }else{

                        $res2['Acquirercountryname'] = "";
                    }
                    $data_inner['Acquirer_Info'][] = $res2;

                    $res5 = array();

                    $moreinfor=$myrow["MoreInfor"];
                    if($moreinfor != '' || trim($moreinfor) != 'null'){

                        $res5['Moreinfo'] = $text = str_replace("\r\n",'', $moreinfor);
                    }else{

                         $res5['Moreinfo'] = "";
                    }
                    $data_inner['More_Info'][] = $res5;

                    $advcompanysql="select advcomp.MAMAId,advcomp.CIAId,cia.cianame,AdvisorType from mama_advisorcompanies as advcomp,
                    advisor_cias as cia where advcomp.MAMAId=".$data_res['MAMAId']." and advcomp.CIAId=cia.CIAId";

                    $adacquirersql="select advinv.MAMAId,advinv.CIAId,cia.cianame,AdvisorType from mama_advisoracquirer as advinv,
                    advisor_cias as cia where advinv.MAMAId=".$data_res['MAMAId']." and advinv.CIAId=cia.CIAId";

                    $res6 = array();
                    if ($getcompanyrs = mysql_query($advcompanysql))
                    {
                        While($myadcomprow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                        {

                            $res6['Advisor_Target'][] = $myadcomprow["cianame"]." ( ".$myadcomprow["AdvisorType"].")";
                        }
                    }
                    if ($getinvestorrs = mysql_query($adacquirersql))
                    {
                        While($myadinvrow=mysql_fetch_array($getinvestorrs, MYSQL_BOTH))
                        {

                            $res6['Advisor-Acquirer'][] =$myadinvrow["cianame"]." ( ".$myadinvrow[3]." ) ";
                        }
                    }
                    $data_inner['Advisor_Info'][] = $res6;
    //------------------------------------------------------ Acquirer Details starts----------------------------------------------------------

                    $acqsql="select ac.*,c.country from acquirers as ac,country as c where AcquirerId=".$myrow["AcquirerId"]." and ac.CountryId=c.countryid ";

                    $mandasql="select peinv.MAMAId,DATE_FORMAT( peinv.DealDate, '%b-%Y' )as dealperiod,peinv.AcquirerId,
                    peinv.PECompanyId,c.companyname,c.industry,i.industry as indname,inv.*
                    from acquirers as inv,mama as peinv,pecompanies as c,industry as i
                    where inv.AcquirerId=".$myrow["AcquirerId"]." and peinv.AcquirerId=inv.AcquirerId
                    and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0 and i.industryid=c.industry
                    and c.industry AND i.industryid !=15 order by DealDate desc";

                    $indSql= " SELECT DISTINCT i.industry AS ind, c.industry FROM pecompanies AS c, mama AS peinv, industry AS i
                    WHERE peinv.AcquirerId =".$myrow["AcquirerId"]." AND c.PECompanyId = peinv.PECompanyId AND i.industryid !=15
                    AND i.industryid = c.industry ORDER BY i.industry";

                    $acqres = array();  $res4 = array();$res5 = array();

                    if ($companyrs2 = mysql_query($acqsql))
                    {  

                        if($acmyrow = mysql_fetch_array($companyrs2,MYSQL_BOTH))
                        {

                            $res4['AcquirerName'] = $acmyrow["Acquirer"];
                            $acqIndustrySql="select industry from industry where industryid=".$acmyrow["IndustryId"];
                            if ($rsindrow = mysql_query($acqIndustrySql))
                            {
                                if($myindrow=mysql_fetch_array($rsindrow,MYSQL_BOTH))
                                {
                                    
                                    $acquirerIndustry=trim($myindrow["industry"]);
                                }
                            }

                            if($acquirerIndustry!='')
                                $res4['Industry'] = trim($acquirerIndustry);
                            else
                               $res4['Industry'] = ""; 

                            if($acmyrow["website"]!='')
                                $res4['website'] = trim($acmyrow["website"]);
                            else
                               $res4['website'] = ""; 
                        }

                        $strIndustry="";
                        if($rsInd= mysql_query($indSql))
                        {
                            While($myIndrow=mysql_fetch_array($rsInd, MYSQL_BOTH))
                            {
                                
                                $strIndustry=$strIndustry.", ".$myIndrow["ind"];
                            }
                            $strIndustry =substr_replace($strIndustry, '', 0,1);
                        }

                        if($strIndustry!=''){
                            
                            $res4['Industry (Existing Targets)'] = trim($strIndustry);
                        }else{
                            
                            $res4['Industry (Existing Targets)'] = '';
                        }

                        if ($getcompanyinvrs = mysql_query($mandasql))
                        {
                            $i=0;
                            While($myInvestrow=mysql_fetch_array($getcompanyinvrs, MYSQL_BOTH))
                            {

                                $res5['Acquirer Details'][$i] = $myInvestrow["companyname"].",".$myInvestrow["indname"].",".$myInvestrow["dealperiod"];
                                $i++;
                            }
                        }
                        
                        $data_inner['Acquirer_Profile'] = $res5;
                        $data_inner['Acquirer_Profile']['Acquirer Info'] = $res4;
                    }

                    $data['Deal_Details'][] = $data_inner;
                }   
            }
        }else{

            $res = array(); $data_inner = array();$cos_array = array();$res1 = array();

            while($data_res = mysql_fetch_array($results)) {
                
                if($data_res["Amount"]==0)
                {
                    $hideamount="";
                    $amountobeAdded=0;
                }
                elseif($data_res["hideamount"]==1)
                {
                    $hideamount="";
                    $amountobeAdded=0;
                }
                else
                {
                    $hideamount=$data_res["Amount"];
                    $acrossDealsCnt=$acrossDealsCnt+1;
                    $amountobeAdded=$data_res["Amount"];
                }
                if($data_res["AggHide"]==1)
                {
                    $opensquareBracket="{";
                    $closesquareBracket="}";
                    $amtTobeDeductedforAggHide=$data_res["Amount"];
                    $NoofDealsCntTobeDeducted=1;
                    $acrossDealsCnt=$acrossDealsCnt-1;
                }
                else
                {
                    $opensquareBracket="";
                    $closesquareBracket="";
                    $amtTobeDeductedforAggHide=0;
                    $NoofDealsCntTobeDeducted=0;
                }
                $_SESSION['resultId'][$icount++] = $data_res["MAMAId"];
                $industryAdded = $data_res["industry"];
        
                $totalInv=$totalInv+1- $NoofDealsCntTobeDeducted;
                $totalAmount=$totalAmount+ $data_res["Amount"]- $amtTobeDeductedforAggHide;
            }
            $res1['total Deals'] = $totalInv;
            $res1['total_amount'] = round($totalAmount);
            $res1['Across_Deals'] = $acrossDealsCnt;

            if($res1['total Deals'] > 0 && $res1['total_amount'] > 0){
                $data_inner['aggregate_details']= $res1;
            }

            mysql_data_seek($results,0);

            while($data_res = mysql_fetch_array($results)) {

                if($data_res["Asset"]==1)
                {
                    $openBracket="(";
                    $closeBracket=")";
                }
                else
                {
                    $openBracket="";
                    $closeBracket="";
                }
                if($data_res["dates"]!="")
                {

                    $displaydate=$data_res["dates"];
                }
                else
                {
                    $displaydate="-";
                }
                if($data_res["Amount"]==0)
                {
                    $hideamount="";
                    $amountobeAdded=0;
                }
                elseif($data_res["hideamount"]==1)
                {
                    $hideamount="";
                    $amountobeAdded=0;
                }
                else
                {
                    $hideamount=$data_res["Amount"];
                    $amountobeAdded=$data_res["Amount"];
                }
                if($data_res["AggHide"]==1)
                {
                    $opensquareBracket="{";
                    $closesquareBracket="}";
                    $amtTobeDeductedforAggHide=$data_res["Amount"];
                    $NoofDealsCntTobeDeducted=1;
                 }
                else
                {
                    $opensquareBracket="";
                    $closesquareBracket="";
                    $amtTobeDeductedforAggHide=0;
                    $NoofDealsCntTobeDeducted=0;
                }
                $res['companyname'] = $openBracket.$opensquareBracket.$data_res['companyname'].$closeBracket.$closesquareBracket;

                if(trim($data_res["Acquirer"]) == ""){

                    $res['Acquirer'] = '';
                }
                else{

                    $res['Acquirer'] = $data_res["Acquirer"];
                }

                if($data_res["dates"] != ''){

                    $res['dealperiod'] = $data_res["dates"];
                }else{

                     $res['dealperiod'] = '';
                }

                $res['Amount']=$hideamount;

                $data_inner['Deals'][]= $res;

            }

            if(count($data_inner) > 0){
                $data['Deals_Aggregate'] = $data_inner;
            }
        }
    }else{
        
        $category = isset($_POST['category']) ? $_POST['category'] : 1; // For Target Company 1, for Acquirer Company 2, for Legal Advisor 3, for Transaction Advisor 4.
        
        $search = isset($_POST['search']) ? $_POST['search'] : '';
        
        if($category ==1 && $search!='')
        {
            $search=" and  RTRIM(pec.companyname) like '%$search%'";
        }
        else if($category ==2 && $search!='')
        {
             $search=" and  RTRIM(ac.Acquirer) like '%$search%'";
        }
        else if(($category ==3 || $category ==4) && $search!='')
        {
            $search=" and  RTRIM(cia.Cianame) like '%$search%'";
        }
        
        if($category==1)
        {   
            
            $showallsql="SELECT DISTINCT pe.PECompanyId, pec.companyname, pec.CINNo, pec.industry, i.industry, sector_business FROM
            mama AS pe, industry AS i, pecompanies AS pec WHERE pec.industry = i.industryid AND pec.PEcompanyID = pe.PECompanyId 
            AND pe.Deleted =0 " .$search." and pec.industry != 15  order by pec.companyname";
            
            $data_inner = array();
           
            $sqlrs = mysql_query($showallsql);
            While($myrow=mysql_fetch_array($sqlrs, MYSQL_BOTH))
            {
               
                $data_inner['CompanyName'] = trim($myrow["companyname"]);
                
                if($myrow["CINNo"]!='' && $myrow["CINNo"]!='NULL'){
                    
                    $data_inner['CIN'] = trim($myrow["CINNo"]);
                }else{
                    $data_inner['CIN'] = "";
                }
                
                $company_sql="SELECT pe.FinLink, pec.angelco_compID, pec.uploadfilename, pec.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, 
                website, stockcode, yearfounded, pec.Address1, pec.Address2, pec.AdCity, pec.Zip, pec.OtherLocation, c.country, pec.Telephone, pec.Fax, pec.Email,
                pec.AdditionalInfor, linkedin_companyname
                FROM pecompanies pec LEFT JOIN peinvestments AS pe ON ( pe.PECompanyId = pec.PECompanyId ) LEFT JOIN industry i ON ( pec.industry = i.industryid ) 
                LEFT JOIN country c ON ( c.countryid = pec.countryid ) WHERE pec.PECompanyId =".$myrow["PECompanyId"]."  limit 1";
                
               $investorSql="select pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV from
                peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,peinvestors as inv where pe.PECompanyId=".$myrow["PECompanyId"]." and
                peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0 and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15 order by dates desc";
                
                $incubatorSql="SELECT pe.IncDealId,pe.IncubatorId,inc.Incubator FROM `incubatordeals` as pe, incubators as inc WHERE IncubateeId =".$myrow["MAMAId"]."
                and pe.IncubatorId= inc.IncubatorId ";
                
		$onBoardSql="select pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId,exe.ExecutiveName,exe.Designation,exe.Company from
		pecompanies as pec,executives as exe,pecompanies_board as bd where pec.PECompanyId=".$myrow["PECompanyId"]." and bd.PECompanyId=pec.PECompanyId 
                and exe.ExecutiveId=bd.ExecutiveId";

		$onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,exe.ExecutiveName,exe.Designation,exe.Company from
		pecompanies as pec,executives as exe,pecompanies_management as mgmt where pec.PECompanyId=".$myrow["PECompanyId"]." and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";
	
                $maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, inv.Investor,
                DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId ,pe.ExitStatus
                FROM manda AS pe, industry AS i, pecompanies AS pec,manda_investors as mi ,peinvestors as inv WHERE  i.industryid=pec.industry
                AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=".$myrow["PECompanyId"]."
                and inv.InvestorId=mi.InvestorId and mi.MandAId=pe.MandAId order by DealDate desc ";

		$ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,
                IPOAmount, DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId ,pe.ExitStatus FROM ipos AS pe, industry AS i, pecompanies AS pec,ipo_investors as ipoi,peinvestors as inv
                WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId=".$myrow["PECompanyId"]."
                and inv.InvestorId=ipoi.InvestorId and ipoi.IPOId=pe.IPOId order by IPODate desc";
                
		$angelinvsql="SELECT pe.InvesteeId, pec.companyname, pec.industry, i.industry, pec.sector_business,
                DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.AngelDealId ,peinv.InvestorId,inv.Investor FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,
                angel_investors as peinv,peinvestors as inv WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.InvesteeId and 
                pe.Deleted=0 and pec.industry !=15 and pe.InvesteeId=".$myrow["PECompanyId"]." and  peinv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv.InvestorId order by dt desc";
                
                $company_link_Sql ="select * from pecompanies_links where PECompanyId=".$myrow["PECompanyId"];
                
                $companyrs = mysql_query($company_sql);
                if(mysql_num_rows($companyrs) > 0){ 
                
                    $res1 = array();
                    While($myrow1=mysql_fetch_array($companyrs, MYSQL_BOTH))
                    {
                        if($myrow1["companyname"]!='' && $myrow1["companyname"]!='NULL'){

                            $res1['companyname'] = trim($myrow1["companyname"]);
                        }else{
                            
                            $res1['companyname'] = "";
                        }
                        if($myrow1["industry"]!='' && $myrow1["industry"]!='NULL'){

                            $res1['industry'] = trim($myrow1["industry"]);
                        }else{
                            
                            $res1['industry'] = "";
                        }
                        if($myrow1["stockcode"]!=''  && $myrow1["stockcode"]!='NULL'){

                            $res1['stockcode'] = trim($myrow1["stockcode"]);
                        }else{
                            
                            $res1['stockcode'] = "";
                        }
                        if($myrow1["sector_business"]!='' && $myrow1["sector_business"]!='NULL'){
                            $res1['sector_business'] = trim($myrow1["sector_business"]);
                        }else{
                            
                            $res1['sector_business'] = "";
                        }
			if($myrow1["website"]!='' && $myrow1["website"]!='NULL'){

                            $res1['website'] = trim($myrow1["website"]);
                        }else{
                            
                            $res1['website'] = "";
                        }
                        if($myrow1["Address1"]!='' && $myrow1["Address1"]!='NULL'){

                            $res1['Address1'] = trim($myrow1["Address1"]);
                        }else{
                            
                            $res1['Address1'] = "";
                        }
                        if($myrow1["Address2"]!='' && $myrow1["Address2"]!='NULL'){
                            
                            $res1['Address2'] = trim($myrow1["Address2"]);
                        }else{
                            
                            $res1['Address2'] = "";
                        }
                        if($myrow1["AdCity"]!='' && $myrow1["AdCity"]!='NULL'){

                            $res1['AdCity'] = trim($myrow1["AdCity"]);
                        }else{
                            
                            $res1['AdCity'] = "";
                        }
                        if($myrow1["OtherLocation"]!='' && $myrow1["OtherLocation"]!='NULL'){

                            $res1['OtherLocation'] = trim($myrow1["OtherLocation"]);
                        }else{
                            
                            $res1['OtherLocation'] = "";
                        }
                        if($myrow1["country"]!='' && $myrow1["country"]!='NULL'){
                            
                            $res1['country'] = trim($myrow1["country"]);
                        }else{
                            
                            $res1['country'] = "";
                        }
                        if($myrow1["Zip"]!='' && $myrow1["Zip"]!='NULL'){
                            
                            $res1['Zip'] = trim($myrow1["Zip"]);
                        }else{
                            
                            $res1['Zip'] = "";
                        }
                        if($myrow1["Telephone"]!='' && $myrow1["Telephone"]!='NULL'){
                            
                            $res1['Telephone'] = trim($myrow1["Telephone"]);
                        }else{
                            
                            $res1['Telephone'] = "";
                        }
                        if($myrow1["Fax"]!='' && $myrow1["Fax"]!='NULL'){
                            
                            $res1['Fax'] = trim($myrow1["Fax"]);
                        }else{
                            
                            $res1['Fax'] = "";
                        }
			if($myrow1["Email"]!='' && $myrow1["Email"]!='NULL'){
                            
                            $res1['Email'] = trim($myrow1["Email"]);
                        }else{
                            
                            $res1['Email'] = "";
                        }
                        if($myrow1["yearfounded"]!='' && $myrow1["yearfounded"]!='NULL'){
                            
                            $res1['yearfounded'] = trim($myrow1["yearfounded"]);
                        }else{
                            
                            $res1['yearfounded'] = "";
                        }
                        if($myrow1["website"]!='' && $myrow1["website"]!='NULL'){
                            
                            $res1['website'] = trim($myrow1["website"]);
                        }else{
                            
                            $res1['website'] = "";
                        }
                        if($myrow1["linkedin_companyname"]!='' && $myrow1["linkedin_companyname"]!='NULL'){
                            
                            $res1['linkedin_companyname'] = trim($myrow1["linkedin_companyname"]);
                        }else{
                            
                            $res1['linkedin_companyname'] = "";
                        }
                        if($myrow1["FinLink"]!='' && $myrow1["FinLink"]!='NULL'){
                            
                            $res1['FinLink'] = trim($myrow1["FinLink"]);
                        }else{
                            
                            $res1['FinLink'] = "";
                        }
                        if($myrow1["AdditionalInfor"]!='' && $myrow1["AdditionalInfor"]!='NULL'){
                            
                            $res1['AdditionalInfor'] = trim($myrow1["AdditionalInfor"]);
                        }else{
                            
                            $res1['AdditionalInfor'] = "";
                        }
                        if($myrow1["uploadfilename"]!='' && $myrow1["uploadfilename"]!='NULL'){
                            
                            $res1['uploadfilename'] = trim($myrow1["uploadfilename"]);
                        }else{
                            
                            $res1['uploadfilename'] = "";
                        }
                        if($myrow1["companyname"]!='' && $myrow1["companyname"]!='NULL'){
                            
                            $companyName=trim($myrow1["companyname"]);
                            $companyName=strtolower($companyName);
                            $res1['google_sitesearch'] = "https://www.google.co.in/search?q=".$companyName."+site%3Alinkedin.com";
                        }else{
                            
                            $res1['google_sitesearch'] = "";
                        }
                        if($myrow1["companyname"]!='' && $myrow1["companyname"]!='NULL'){
                            
                            $companyName=trim($myrow1["companyname"]);
                            $companyurl=  urlencode($companyName);
                            $res1['company_newssearch'] ="https://www.google.co.in/search?q=".$companyurl."+site:ventureintelligence.com/ddw/";
                        }else{
                            
                            $res1['company_newssearch'] = "";
                        }
                        
                       $data_inner['Company_Profile'] = $res1;
                    }

                }else{
                    $data_inner['Company_Profile'] = "";
                }
                
                if($rsMgmt = mysql_query($onMgmtSql))
                {
                    $res2 = array();
                    if(mysql_num_rows($rsMgmt)>0)
                    {
                        While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                        {
                            if($mymgmtrow["ExecutiveName"]!='' && $mymgmtrow["ExecutiveName"]!='NULL'){

                                $res2['ExecutiveName'] = trim($mymgmtrow["ExecutiveName"]);
                            }else{
                                
                                $res2['ExecutiveName'] = "";
                            }
                            if($mymgmtrow["Designation"]!='' && $mymgmtrow["Designation"]!='NULL'){

                                $res2['Designation'] = trim($mymgmtrow["Designation"]);
                            }else{
                                
                                $res2['Designation'] = "";
                            }
                        }
                    }else{
                        $res2 = "";
                    }
                    
                    $data_inner['Top_Management'] = $res2;
                }
                else{
                    $data_inner['Top_Management'] = "";
                }
                
                $res3 = array();
                if($rsBoard= mysql_query($onBoardSql))
                {
                    if(mysql_num_rows($rsBoard)>0)
                    {
                        While($myboardrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                        {
                            if(strlen(trim($desig))==0){
                                $desig="";
                            }
                            else{
                                $desig=", ".$myboardrow["Designation"];
                            }
                            $comp=$myboardrow["Company"];
                            if(strlen(trim($comp))==0){
                                
                                $comp="";
                            }
                            else{
                                $comp=", ".$myboardrow["Company"];
                            }
                            if($myboardrow["ExecutiveName"]!='' && $myboardrow["ExecutiveName"]!='NULL'){

                                $res2['ExecutiveName'] = trim($myboardrow["ExecutiveName"]);
                            }else{
                                
                                $res2['ExecutiveName'] = "";
                            }
                            if($myboardrow["Designation"]!='' && $myboardrow["Designation"]!='NULL'){

                                $res2['Designation'] = trim($myboardrow["Designation"]);
                            }else{
                                
                                $res2['Designation'] = "";
                            }
                            if($myboardrow["ExecutiveName"]!='' && $myboardrow["ExecutiveName"]!='NULL'){

                                $res2['Member_Link'] = "https://www.google.co.in/search?q=".$myboardrow["ExecutiveName"].$desig.$comp."+site%3Alinkedin.com";
                            }else{
                                
                                $res2['Member_Link'] = "";
                            }

                        }
                    }else{
                        $res3 = "";
                    }
                    $data_inner['Investor_Board_Member'] = $res3;
                }
                else{
                    $data_inner['Investor_Board_Member'] = "";
                }
                
                $res4 = array();
                if($rsinvestor= mysql_query($investorSql))
                {
                    if(mysql_num_rows($rsinvestor)>0)
                    {
                        While($myInvestorrow=mysql_fetch_array($rsinvestor, MYSQL_BOTH))
                        {
                            if($myInvestorrow["Investor"]!='' & $myInvestorrow["Investor"]!='null'){

                                $res4['Investor_Name'] = trim($myInvestorrow["Investor"]);
                            }else{
                                
                                $res4['Investor_Name'] = "";
                            }
                            if($myInvestorrow["dt"]!='' && $myInvestorrow["dt"]!='null'){

                                $res4['Deal_Period'] = trim($myInvestorrow["dt"]);
                            }else{
                                
                                $res4['Deal_Period'] = "";
                            }

                        }
                    }else{
                        $res4 = "";
                    }
                    
                    $data_inner['PE_VC_Investors'] = $res4;
                }
                else{
                    $data_inner['PE_VC_Investors'] = "";
                }
                
                $res5 = array();
                if($incrs= mysql_query($incubatorSql))
                {
                    if(mysql_num_rows($incrs)>0)
                    {
                        While($incrow=mysql_fetch_array($incrs, MYSQL_BOTH))
                        {
                            if($incrow["Incubator"]!='' && $incrow["Incubator"]!='null'){

                                $res5['Incubator'] = trim($incrow["Incubator"]);
                            }else{
                                
                                $res5['Incubator'] = "";
                            }

                        }
                    }else{
                        $res5 = "";
                    }
                    
                    $data_inner['Incubators'] = $res5;
                }
                else{
                    $data_inner['Incubators'] = "";
                }
                
                $res6 = array();
                if($rsipoexit= mysql_query($ipoexitsql))
                {
                    
                     $ipoexit_cnt = mysql_num_rows($rsipoexit);
                }
                if($rsmandaexit= mysql_query($maexitsql))
                {
                    
                     $mandaexit_cnt = mysql_num_rows($rsmandaexit);
                }
                if(($ipoexit_cnt>0)||($mandaexit_cnt>0 ))
                {
                    While($ipoexitrow=mysql_fetch_array($rsipoexit, MYSQL_BOTH))
                    {
                        $exitstatusvalueforIPO=$ipoexitrow["ExitStatus"];
                        if($exitstatusvalueforIPO==0)
                        {$exitstatusdisplayforIPO="Partial Exit";}
                        elseif($exitstatusvalueforIPO==1)
                        {  $exitstatusdisplayforIPO="Complete Exit";}

                        $res6['DealType'] = "IPO";
                           
                        if($ipoexitrow["Investor"]!='' &&  $ipoexitrow["Investor"]!='null'){

                            $res6['Company_name'] = trim($ipoexitrow["Investor"]);
                        }else{
                            
                            $res6['Company_name'] = "";
                        }
                        if($ipoexitrow["dt"]!='' && $ipoexitrow["dt"]!='null'){

                            $res6['Deal_Period'] = trim($ipoexitrow["dt"]);
                        }else{
                            
                            $res6['Deal_Period'] = "";
                        }
                        if($exitstatusdisplayforIPO!=''){

                            $res6['Status'] = $exitstatusdisplayforIPO;
                        }else{
                            
                            $res6['Status'] = "";
                        }
                    }
                    While($mymandaexitrow=mysql_fetch_array($rsmandaexit, MYSQL_BOTH))
                    {
                        $exitstatusvalueforIPO=$mymandaexitrow["ExitStatus"];
                        if($exitstatusvalueforIPO==0)
                        {$exitstatusdisplayforIPO="Partial Exit";}
                        elseif($exitstatusvalueforIPO==1)
                        {  $exitstatusdisplayforIPO="Complete Exit";}

                        $res6['DealType'] = "M&A";
                           
                        if($mymandaexitrow["Investor"]!='' && $mymandaexitrow["Investor"]!='null'){

                            $res6['Company_name'] = trim($mymandaexitrow["Investor"]);
                        }else{
                            
                            $res6['Company_name'] = "";
                        }
                        if($mymandaexitrow["dt"]!='' && $mymandaexitrow["dt"]!='null'){

                            $res6['Deal_Period'] = trim($mymandaexitrow["dt"]);
                        }else{
                            
                            $res6['Deal_Period'] = "";
                        }
                        if($exitstatusdisplayforIPO!=''){

                            $res6['Status'] = $exitstatusdisplayforIPO;
                        }else{
                            
                            $res6['Status'] = "";
                        }
                    }
                    
                    $data_inner['PE_VC_Exits'] = $res5;
                }else{
                    
                    $data_inner['PE_VC_Exits'] = "";
                }
                
                $res7 = array();
                if($rsangel= mysql_query($angelinvsql))
                {
                    if(mysql_num_rows($rsangel) > 0)
                    {
                        While($angelrow=mysql_fetch_array($rsangel, MYSQL_BOTH))
                        {
                            if($angelrow["Investor"]!='' && $angelrow["Investor"]!='null'){

                                $res7['Investor_Name'] = trim($angelrow["Investor"]);
                            }else{
                                
                                $res7['Investor_Name'] = "";
                            }
                            if($angelrow["dt"]!='' && $angelrow["dt"]!='null'){

                                $res7['Deal_Period'] = trim($angelrow["dt"]);
                            }else{
                                
                                $res7['Deal_Period'] = "";
                            }

                        }
                    }else{
                        
                        $res7 = "";
                    }
                    $data_inner['Angel_Investments'] = $res7;
                    
                }
                else{
                    $data_inner['Angel_Investments'] = "";
                }
                
                $res8 = array();
                if($rscompany_link= mysql_query($company_link_Sql))
                {
                    if(mysql_num_rows($rscompany_link) > 0)
                    {
                        While($com_links_com=mysql_fetch_array($rscompany_link, MYSQL_BOTH))
                        {
                            if($com_links_com['Link']!='' && $com_links_com['Link']!='NULL'){

                                $res8['LinkComment'] = trim($com_links_com['Link']);
                            }else{
                                
                                $res8['LinkComment'] = "";
                            }
                        }
                    }else{
                        
                        $res8 = "";
                    }
                    
                    $data_inner['Link_Comment']= $res8;
                }
                else{
                    
                    $data_inner['Link_Comment'] = "";
                }
                
                $data['Targeted_Companies'][] = $data_inner;
                
            }
            
        }elseif($category==2)
        {
            $showallsql="SELECT distinct peinv.AcquirerId, ac.Acquirer,pec.CINNo FROM acquirers AS ac, mama AS peinv, pecompanies AS pec
            WHERE ac.AcquirerId = peinv.AcquirerId AND pec.PEcompanyID = peinv.PECompanyId  and peinv.Deleted=0 " .$search." order by Acquirer";
           
            
            $sqlrs = mysql_query($showallsql);
            
            While($myrow1=mysql_fetch_array($sqlrs, MYSQL_BOTH))
            {
                $data_inner = array();
                $data_inner['Acquirer'] = trim($myrow2["Acquirer"]);
                if($myrow1["CINNo"]!='' && $myrow1["CINNo"]!='NULL'){
                    
                    $data_inner['CIN'] = trim($myrow1["CINNo"]);
                }else{
                    $data_inner['CIN'] = "";
                }
                $sql="select ac.*,c.country from acquirers as ac,country as c where AcquirerId=".$myrow1['AcquirerId']." and ac.CountryId=c.countryid ";

                $mandasql="select peinv.MAMAId,DATE_FORMAT( peinv.DealDate, '%b-%Y' )as dealperiod,peinv.AcquirerId,
                peinv.PECompanyId,c.companyname,c.industry,i.industry as indname,inv.* from acquirers as inv,mama as peinv,pecompanies as c,industry as i
                where inv.AcquirerId=".$myrow1['AcquirerId']." and peinv.AcquirerId=inv.AcquirerId and c.PECompanyId=peinv.PECompanyId and peinv.Deleted=0 and i.industryid=c.industry
                and c.industry $industryvalue order by DealDate desc";

                $indSql= " SELECT DISTINCT i.industry AS ind, c.industry FROM pecompanies AS c, mama AS peinv, industry AS i
                WHERE peinv.AcquirerId =".$myrow1['AcquirerId']." AND c.PECompanyId = peinv.PECompanyId AND i.industryid !=15 AND i.industryid = c.industry ORDER BY i.industry";
                
                if($rsInd= mysql_query($indSql))
                {
                    While($myIndrow=mysql_fetch_array($rsInd, MYSQL_BOTH))
                    {
                            $strIndustry=$strIndustry.", ".$myIndrow["ind"];
                    }
                    $strIndustry =substr_replace($strIndustry, '', 0,1);
                }
                
                $res1 = array();
                if ($companyrs = mysql_query($sql))
		{  
                    if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
                    {
                        
                        if($myrow["Acquirer"]!=''){
                            
                            $res1['Acquirer'] = trim($myrow["Acquirer"]);
                        }else{
                            $res1['Acquirer']="";
                        }
                        if($myrow["Address"]!=''){
                            
                            $res1['Address'] = trim($myrow["Address"]);
                        }else{
                            $res1['Address']="";
                        }
                        if($myrow["Address1"]!=''){
                            
                            $res1['Address1']= trim($myrow["Address1"]);
                        }else{
                            $res1['Address1']="";
                        }
                        if($myrow["Sector"]!=''){
                            
                            $res1["Sector"]= trim($myrow["Sector"]);
                        }else{
                            $res1["Sector"]="";
                        }
                        if($myrow["CityId"]!=''){
                            
                            $res1["CityId"] = trim($myrow["CityId"]);
                        }else{
                            $res1["CityId"] = "";
                        }
                        if($myrow["StockCode"]!=''){
                            
                            $res1["StockCode"] = trim($myrow["StockCode"]);
                        }else{
                            $res1["StockCode"] = "";
                        }
                        if($myrow["Zip"]!=''){
                            
                            $res1["Zip"]= trim($myrow["Zip"]);
                        }else{
                            $res1["Zip"]="";
                        }
                        if($myrow["Telephone"]!=''){
                            
                            $res1["Telephone"] = trim($myrow["Telephone"]);
                        }else{
                            $res1["Telephone"]="";
                        }
                        if($myrow["Fax"]!=''){
                            
                            $res1["Fax"] = trim($myrow["Fax"]);
                        }else{
                            $res1["Fax"] = "";
                        }
                        if($myrow["Email"]!=''){
                            
                            $res1["Email"] = trim($myrow["Email"]);
                        }else{
                            $res1["Email"] = "";
                        }
                        if($myrow["Website"]!=''){
                            
                            $res1["Website"] = trim($myrow["Website"]);
                        }else{
                            $res1["Website"] = "";
                        }
                        if($myrow["country"]!=''){
                            
                            $res1["country"] = trim($myrow["country"]);
                        }else{
                            $res1["country"] = "";
                        }
                        if($myrow["OtherLocations"]!=''){
                            
                            $res1["OtherLocations"] = trim($myrow["OtherLocations"]);
                        }else{
                            $res1["OtherLocations"] = "";
                        }
                        if($myrow["AdditionalInfor"]!=''){
                            
                            $res1["AdditionalInfor"] = trim($myrow["AdditionalInfor"]);
                        }else{
                            $res1["AdditionalInfor"] ="";
                        }
                        
                        $data_inner['AcquirerInfo']= $res1;
                    }
                }
                
                if ($getcompanyinvrs = mysql_query($mandasql))
                {
                   
                    if(mysql_num_rows($getcompanyinvrs) > 0)
                    {  
                        $res2 = array();
                        While($myInvestrow = mysql_fetch_array($getcompanyinvrs, MYSQL_BOTH))
                        {
                            if($myInvestrow["companyname"]!=''){
                            
                                $res2["companyname"] = trim($myInvestrow["companyname"]);
                            }else{
                                $res2["companyname"] = "";
                            }
                            if($myInvestrow["indname"]!=''){
                            
                                $res2["industry"] = trim($myInvestrow["indname"]);
                            }else{
                                $res2["industry"] = "";
                            }
                            if($myInvestrow["dealperiod"]!='' && $myInvestrow["dealperiod"]!='null'){
                            
                                $res2["dealperiod"] = trim($myInvestrow["dealperiod"]);
                            }else{
                                $res2["dealperiod"] = "";
                            }
                            
                            $data_inner['Acquirer_Details'][] = $res2; 
                        }
                        
                    }else{
                        $data_inner['Acquirer_Details']= ""; 
                    }
                    
                }
                
                $data['Acquirer_Companies'][] = $data_inner; 
            }
        }
        else if($category==3 || $category==4)
        {
            
            if($category == 3)
            {
                $adtype = "L";
            }
            else
            {
                $adtype = "T";
            }
           $showallsql="(SELECT DISTINCT adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId, c.CINNo
            FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisoracquirer AS adac
            WHERE Deleted =0
            AND c.PECompanyId = peinv.PECompanyId
            AND adac.CIAId = cia.CIAID and AdvisorType='".$adtype ."' " .$search."
            AND adac.MAMAId = peinv.MAMAId " .$addVCFlagqry." )
            UNION (
            SELECT DISTINCT adcomp.CIAId, cia.cianame, adcomp.CIAId AS CompCIAId, c.CINNo
            FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia, mama_advisorcompanies AS adcomp, acquirers AS ac
            WHERE Deleted =0
            AND c.PECompanyId = peinv.PECompanyId
            AND adcomp.CIAId = cia.CIAID  and AdvisorType='".$adtype ."' " .$search." 
            AND adcomp.MAMAId = peinv.MAMAId " .$addVCFlagqry." ) ORDER BY Cianame";
            
            
            $sqlrs = mysql_query($showallsql);
            
            While($myrow2=mysql_fetch_array($sqlrs, MYSQL_BOTH))
            {
                $data_inner = array();
                
                $data_inner['Cianame'] = trim($myrow2["Cianame"]);
                if($myrow2["CINNo"]!='' && $myrow2["CINNo"]!='NULL'){
                    
                    $data_inner['CIN'] = trim($myrow2["CINNo"]);
                }else{
                    $data_inner['CIN'] = "";
                }
                $AdvisorSql="select * from advisor_cias where CIAId=".$myrow2["CIAId"];

                $advisor_to_companysql="SELECT  distinct adac.CIAId, cia.Cianame, adac.CIAId AS AcqCIAId,peinv.PECompanyId,c.Companyname,
                DATE_FORMAT( DealDate, '%M-%Y' ) AS dt,peinv.MAMAId
                FROM mama AS peinv, pecompanies AS c,  advisor_cias AS cia,mama_advisorcompanies AS adac
                WHERE peinv.Deleted=0 AND c.PECompanyId = peinv.PECompanyId AND adac.CIAId = cia.CIAID
                AND adac.MAMAId = peinv.MAMAId and adac.CIAId=".$myrow2["CIAId"]." order by DealDate";

                $advisor_to_investorsql="SELECT distinct peinv.PECompanyId,adac.CIAId AS AcqCIAId,peinv.MAMAId  ,c.Companyname,DATE_FORMAT( DealDate, '%M-%Y' ) AS dt
                FROM mama AS peinv, pecompanies AS c, advisor_cias AS cia,mama_advisoracquirer AS adac
                WHERE peinv.Deleted=0  AND c.PECompanyId = peinv.PECompanyId
                AND adac.CIAId = cia.CIAID AND adac.MAMAId = peinv.MAMAId and adac.CIAId=".$myrow2["CIAId"]." order by DealDate";
                
                if($advisorrs=mysql_query($AdvisorSql))
                {
                    if(mysql_num_rows($advisorrs) > 0)
                    { 
                        $res1= array();
                        while($advisorrow=mysql_fetch_array($advisorrs,MYSQL_BOTH))
                        {
                            if($advisorrow["cianame"]!='' && $advisorrow["cianame"]!='null'){
                                
                                $res1['cianame']= trim($advisorrow["cianame"]);
                            }else{
                                
                                 $res1['cianame']='';
                            }
                            if($advisorrow["website"]!='' && $advisorrow["website"]!='null'){
                                
                                $res1['website']= preg_replace('/\\\\/', '', trim($advisorrow["website"]));
                            }else{
                                 
                                $res1['website']='';
                            }
                            if($advisorrow["address"]!='' && $advisorrow["address"]!='null'){
                                
                                $res1['address']= trim($advisorrow["address"]);
                            }else{
                                
                                 $res1['address']='';
                            }
                            if($advisorrow["city"]!='' && $advisorrow["city"]!='null'){
                                
                                $res1['city']= trim($advisorrow["city"]);
                            }else{
                                
                                 $res1['city']='';
                            }
                            if($advisorrow["country"]!='' && $advisorrow["country"]!='null'){
                                
                                $res1['country']= trim($advisorrow["country"]);
                            }else{
                                
                                 $res1['country']='';
                            }
                            if($advisorrow["phoneno"]!='' && $advisorrow["phoneno"]!='null'){
                                
                                $res1['phone']= trim($advisorrow["phoneno"]);
                            }else{
                                
                                 $res1['phone']='';
                            }
                            if($advisorrow["contactperson"]!='' && $advisorrow["contactperson"]!='null'){
                                
                                $res1['contactperson']= trim($advisorrow["contactperson"]);
                            }else{
                                
                                 $res1['contactperson']='';
                            }
                            if($advisorrow["designation"]!='' && $advisorrow["designation"]!='null'){
                                
                                $res1['designation']= trim($advisorrow["designation"]);
                            }else{
                                
                                 $res1['designation']='';
                            }
                            if($advisorrow["email"]!='' && $advisorrow["email"]!='null'){
                                
                                $res1['email']= trim($advisorrow["email"]);
                            }else{
                                
                                 $res1['email']='';
                            }
                            if($advisorrow["linkedin"]!='' && $advisorrow["linkedin"]!='null'){
                                
                                $res1['linkedin']= str_replace('\\', '', trim($advisorrow["linkedin"]));
                            }else{
                                
                                 $res1['linkedin']='';
                            }
                            
                            $data_inner['Advisor_Info'] = $res1; 
                        }
                    }
                    else{
                        $data_inner['Advisor_Info']= ""; 
                    }
                }
                
                if ($getinvrs = mysql_query($advisor_to_companysql))
                {
                    if(mysql_num_rows($getinvrs) > 0){
                        
                       $res3 = array();
                       while($myInvestrow=mysql_fetch_array($getinvrs, MYSQL_BOTH))
                       {
                           
                           if($myInvestrow['Companyname']!='' && $myInvestrow['Companyname']!='null'){
                               
                               $res3['Companyname']= trim($myInvestrow['Companyname']);
                           }else{
                               
                               $res3['Companyname']= "";
                           }
                           if($myInvestrow['dt']!='' && $myInvestrow['dt']!='null'){
                               
                               $res3['date']= trim($myInvestrow['dt']);
                           }else{
                               
                               $res3['date']="";
                           }
                           
                           $data_inner['Advisor_to_Targets'][] = $res3; 
                       }
                    }else{
                        
                        $data_inner['Advisor_to_Targets'] = ""; 
                    }
                }
                
                if ($getcompanyrs = mysql_query($advisor_to_investorsql))
                {
                    if(mysql_num_rows($getcompanyrs) > 0){
                        
                       $res2 = array();
                       
                       while($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                       {
                           
                           if($myInvrow['Companyname']!='' && $myInvrow['Companyname']!='null'){
                               $res2['Companyname']= trim($myInvrow['Companyname']);
                           }else{
                               
                               $res2['Companyname']= "";
                           }
                           if($myInvrow['dt']!='' && $myInvrow['dt']!='null'){
                               $res2['date']= trim($myInvrow['dt']);
                           }else{
                               
                               $res2['date']="";
                           }
                           $data_inner['Advisor_to_Acquirer'][] = $res2; 
                           
                       }
                    }else{
                        $data_inner['Advisor_to_Acquirer'] = ""; 
                    }
                }
                
               
               if($category ==3){
                    
                     $data['Legal_Advisor'][] = $data_inner; 
                }else{
                    
                     $data['Transaction_Advisor'][] = $data_inner; 
                } 
                
            }
        }
    }
    
    if(count($data) > 0){
        
        $datas['Status'] = "Success";
        $datas['Results'] = $data;
    }else{
        
        $datas['Status'] = "Failure";
        $datas['Results'] = "No Data Found.";
    }    
    
   echo json_encode(str_replace('\\', '',$datas));
   mysql_close();
?>