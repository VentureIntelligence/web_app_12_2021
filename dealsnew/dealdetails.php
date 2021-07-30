


<?php

/*echo '<pre>';
print_r($_POST);
echo '</pre>';*/
require_once("../dbconnectvi.php");
$Db = new dbInvestments();
$tagandor=$_POST['tagandor'];
$tagradio=$_POST['tagradio'];
    $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
    $strvalue = explode("/", $value);
    $IPO_MandAId = $strvalue[0];
    $indexflagvalue = $strvalue[1];
   
    
    $_SESSION['usebackaction2']=$value; 
    setcookie("usebackaction2",$value);
    
    if( isset( $_POST[ 'period_flag' ] ) ) {
        $period_flag = $_POST[ 'period_flag' ];
    } else {
        $period_flag = 1;
    }

    if( isset( $_POST[ 'pe_checkbox_disbale' ] ) ) {
        $pe_checkbox = $_POST[ 'pe_checkbox_disbale' ];
    } else {
        $pe_checkbox = '';
    }
    $listallcompany = $_POST['listallcompanies'];
    if( isset( $_POST[ 'pe_checkbox_amount' ] ) ) {
        $pe_amount = $_POST[ 'pe_checkbox_amount' ];
    } else {
        $pe_amount = '';
    }
//==================================junaid================================================
    if( isset( $_POST[ 'pe_checkbox_company' ] ) ) {
        $pe_company = $_POST[ 'pe_checkbox_company' ];
    } else {
        $pe_company = 0;
    }

    
    if( isset( $_POST[ 'hide_company_array' ] ) ) {
        $hideCompanyFlag = $_POST[ 'hide_company_array' ];
    } else {
        $hideCompanyFlag = '';
    }
//==================================================================================
    if(sizeof($strvalue)>1)
    {   
        $vcflagValue=$strvalue[1];
        $VCFlagValue=$strvalue[1];
    }
    else
    {
        $vcflagValue=0;
        $VCFlagValue=0;
    }
    if($VCFlagValue==0)
    {
      $videalPageName="PEInv";     
    }
    elseif($VCFlagValue==1)
    { $videalPageName="VCInv";
    }
    elseif($VCFlagValue==2)
    { $videalPageName="AngelInv";
    }
    elseif($VCFlagValue==3)
    { $videalPageName="SVInv";
    }
    elseif($VCFlagValue==4)
    { $videalPageName="CTech";
    }
    elseif($VCFlagValue==5)
    { $videalPageName="IfTech";
    }
include ('checklogin.php');
$mailurl= curPageURL();
        
    $notable=false;
    if($_POST['filtersector'] != ''){
        $filtersector = $_POST['filtersector'];
    } else {
        $filtersector = '';
    }
    
    if($_POST['filtersubsector'] != ''){
        $filtersubsector = $_POST['filtersubsector'];
    } else {
        $filtersubsector = '';
    }
    
    if($_POST['filtersector'] != ''){
        $sectorsql = "select sector_id,sector_name from pe_sectors where sector_id IN ($filtersector) order by sector_name ";
    }
    if($_POST['filtersubsector'] != ''){
        $subsectorsql = "select DISTINCT(subsector_name) from pe_subsectors where subsector_id IN ($filtersubsector) AND subsector_name != '' order by subsector_name";
    }
   // print_r($_POST);
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
        $industrysql_search="select industryid,industry from industry where industryid IN (".$_SESSION['PE_industries'].")" . $hideIndustry ." order by industry";
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
        $industrysql_search="select industryid,industry from industry where industryid IN (".$_SESSION['PE_industries'].")" . $hideIndustry ." order by industry";
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
        $industrysql_search="select industryid,industry from industry where  industryid IN (".$_SESSION['PE_industries'].") ";

    }
            elseif($VCFlagValue==3)
            {
              $dbtype='SV';
              $pagetitle="Social Venture Investments -> Search";
              $showallcompInvFlag=8;
              $stagesql_search =  "SELECT DISTINCT pe.StageId, Stage
                                  FROM peinvestments AS pe, peinvestments_dbtypes AS pedb, stage AS s
        WHERE pedb.PEId = pe.PEId AND pe.Deleted =0 AND pedb.DBTypeId = '$dbtype'
        AND s.StageId = pe.StageId ORDER BY DisplayOrder";
              $industrysql_search="select distinct pec.industry,i.Industry from industry as i ,pecompanies as pec,
        peinvestments as pe,peinvestments_dbtypes as pedb
        where i. industryid IN (".$_SESSION['PE_industries'].") and pedb.PEId=pe.PEId and pec.PECompanyId=pe.PECompanyId and pe.Deleted=0
        and i.IndustryId=pec.Industry and pedb.DBTypeId='$dbtype' order by i.Industry";
            }
            elseif($VCFlagValue==4)
            {
              $dbtype='CT';
              $showallcompInvFlag=9;
              $pagetitle="Cleantech Investments -> Search";
              $stagesql_search="select StageId,Stage from stage order by DisplayOrder";
              $industrysql_search="select distinct pec.industry,i.Industry from industry as i ,pecompanies as pec,
        peinvestments as pe,peinvestments_dbtypes as pedb
        where i.industryid IN (".$_SESSION['PE_industries'].") and pedb.PEId=pe.PEId and pec.PECompanyId=pe.PECompanyId and pe.Deleted=0
        and i.IndustryId=pec.Industry and pedb.DBTypeId='$dbtype' order by i.Industry";
            }
            elseif($VCFlagValue==5)
            {
              $dbtype='IF';
              $showallcompInvFlag=10;
              $pagetitle="Infrastructure Investments -> Search";
              $stagesql_search="select StageId,Stage from stage order by DisplayOrder";
              $industrysql_search="select distinct pec.industry,i.Industry from industry as i ,pecompanies as pec,
                                    peinvestments as pe,peinvestments_dbtypes as pedb
        where i.industryid IN (".$_SESSION['PE_industries'].") and pedb.PEId=pe.PEId and pec.PECompanyId=pe.PECompanyId and pe.Deleted=0
                                    and i.IndustryId=pec.Industry and pedb.DBTypeId='$dbtype' order by i.Industry";
            }

    
    $dbTypeSV="SV";
    $dbTypeIF="IF";
    $dbTypeCT="CT";

    $searchString="Undisclosed";
    $searchString=strtolower($searchString);

    $searchString1="Unknown";
    $searchString1=strtolower($searchString1);

    $buttonClicked=$_POST['hiddenbutton'];
    $fetchRecords=true;
    $totalDisplay="";
    //$keyword=trim($_POST['keywordsearch']);
    $investorauto=$_POST['investorauto_sug'];
    $keyword= trim($investorauto);
    $sql_investorauto_sug = "select InvestorId as id,Investor as name from peinvestors where InvestorId IN($keyword) order by InvestorId";
        
    $sql_investorauto_sug_Exe=mysql_query($sql_investorauto_sug);
    // print_r($getInvestorSql_Exe);
    $response =array(); 
    $invester_filter="";
    $i = 0;
    While($myrow = mysql_fetch_array($sql_investorauto_sug_Exe,MYSQL_BOTH)){

    $response[$i]['id']= $myrow['id'];
    $response[$i]['name']= $myrow['name'];
    if($i!=0){

     $invester_filter.=",";
    }
    $invester_filter.=$myrow['name'];
    $i++;

    }
            if($response != '')
            {
                $investorsug_response= json_encode($response);
            }
            else{
                $investorsug_response= 'null';
            }
     echo "<div style='display:none' class='tesssttt1'>".$_POST['keywordsearch']."</div>";

    $keywordhidden=trim($_POST['keywordsearch']);
    //echo "<Br>--" .$keywordhidden;
    $keywordhidden =preg_replace('/\s+/', '_', $keywordhidden);

    //echo "<br>--" .$keywordhidden;

    $companysearch=trim($_POST['companysearch']);
    $companysearchhidden=preg_replace('/\s+/', '_', $companysearch);
    $companyauto=$_POST['companyauto'];
    $companyauto_sug=$_POST['companyauto_sug'];
    $sectorsearch=stripslashes(trim($_POST['sectorsearch']));
    $sectorauto=trim($_POST['sectorauto']);
    $sectorsearchhidden=preg_replace('/\s+/', '_', $sectorsearch);
    $advisorsearchstring_legal=trim($_POST['advisorsearch_legal']);
    $advisorsearchhidden_legal=preg_replace('/\s+/', '_', $advisorsearchstring_legal);
    $advisorsearchstring_trans=trim($_POST['advisorsearch_trans']);
    $advisorsearchhidden_trans=preg_replace('/\s+/', '_', $advisorsearchstring_trans);
    $searchallfield=$_POST['searchallfield'];
    $searchallfieldhidden=preg_replace('/\s+/', '_', $searchallfield);

    if( !empty( $companyauto_sug ) ) {
        $sql_company_new = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($companyauto_sug)";
        $sql_company_Exe=mysql_query($sql_company_new);
        $company_filter="";
        $i = 0;
        While( $myrow_new = mysql_fetch_array($sql_company_Exe,MYSQL_BOTH)){
            $response_new[$i]['id']= $myrow_new['id'];
            $response_new[$i]['name']= $myrow_new['name'];
            if($i!=0){
                $company_filter.=",";
            }
            $company_filter.=$myrow_new['name'];
            $i++;
        }
        if( $response_new != '' ) {
            $companysug_response= json_encode($response_new);
        } else{
            $companysug_response= 'null';
        }
    }

    //echo "<br>Key word ---" .$keyword;
    //$region=$_POST['region'];
    $industry=$_POST['industry'];
    $state=$_POST['state'];
    $filtersector = $_POST['filtersector'];
    $filtersubsector = $_POST['filtersubsector'];
    $sector=$_POST['sector'];
    $subsector=$_POST['subsector'];

    $yearafter=trim($_POST['yearafter']);
    $yearbefore=trim($_POST['yearbefore']);
    $investor_head=$_POST['invhead'];
    if($resetfield=="tagsearch") {

        /*$_POST['tagsearch']="";
        $_POST['tagsearch_auto'] = "";
        $tagsearch = "";
        $tagkeyword = "";*/
        $arrayval=explode(",",$_POST['tagsearch']);
        $pos = array_search($_POST['resetfieldid'], $arrayval);
        $tagsearch = $arrayval;
        unset($tagsearch[$pos]);
        $tagsearch = implode(",",$tagsearch);
        /*$_POST['tagsearch'] = "";
        $_POST['tagsearch_auto'] = "";
        $tagsearch = "";*/
        if($tagsearch == ""){
        $tagandor = 0;
        }else{
             $tagsearcharray = explode(',', $tagsearch);
        $response = array();
        $tag_filter = "";
        $i = 0;

        foreach ($tagsearcharray as $tagsearchnames) {
            $response[$i]['name'] = $tagsearchnames;
            $response[$i]['id'] = $tagsearchnames;
            $i++;
        }

        if ($response != '') {
            $tag_response = json_encode($response);
        } else {
            $tag_response = 'null';
        }
        }
        
    } else if($_POST['tagsearch']  && $_POST['tagsearch'] !='') {
        
        
        $tagsearch = $_POST['tagsearch'];
        $tagkeyword = $_POST['tagsearch'];
        $tagsearcharray = explode(',',$tagsearch);
        $response =array(); 
        $tag_filter="";
        $i = 0;

        foreach ($tagsearcharray as $tagsearchnames){ 
            $response[$i]['name']= $tagsearchnames;
            $i++;
        } 

        if($response != '')
        {
            $tag_response = json_encode($response);
        }
        else{
            $tag_response = 'null';
        }
    }

    $stageval=$_POST['stage'];
    if($_POST['stage'])
    {
            $boolStage=true;
            //foreach($stageval as $stage)
            //  echo "<br>----" .$stage;
    }
    else
    {
            $stage="--";
            $boolStage=false;
    }
    $round=$_POST['round'];
    // $cityid=$_POST['city'];
    // if($cityid != ''){
       
    //         if($cityid == '--'){
    //             $cityname = "All City";
    //         } else {
    //             $citysql= "select city_name from city where city_id = $cityid";
           
    //             if ($citytype = mysql_query($citysql))
    //             {
    //                 While($myrow = mysql_fetch_array($citytype, MYSQL_BOTH))
    //                 {
    //                     $cityname = ucwords(strtolower($myrow["city_name"] ));
    //                     //echo $cityname;
    //                 }
    //             }
    //         }
    //     }
      // Edited for multi select city
if ($resetfield == "city") {
    $pos = array_search($_POST['resetfieldid'], $_POST['city']);
    $city = $_POST['city'];
    unset($city[$pos]);
     emptyhiddendata();
    } else {
    $city = $_POST['city'];
   
    if ($city[0] != '--' && count($city) > 0) {
    $searchallfield = '';
    
    }
}

if ( (count($city) > 0)) {
   // print_r($city);
    $cityindusSql = $cityvalue = '';$cityvalueid = '';
    foreach ($city as $cities) {
        if($cities != '--'){
        $cityindusSql .= " city_id='".$cities."' or ";
        }
    }
    $cityindusSql = trim($cityindusSql, ' or ');
    $citysql = "select city_id,city_name from city where $cityindusSql";
//echo $citysql;
    if ($citys = mysql_query($citysql)) {
        while ($myrow = mysql_fetch_array($citys, MYSQL_BOTH)) {
            $cityvalue .= $myrow["city_name"] . ',';
            $cityvalueid .= $myrow["city_id"] . ',';
        }
    }
    $cityvalue = trim($cityvalue, ',');
    $cityvalueid = trim($cityvalueid, ',');
    $city_hide = implode($city, ',');
}

// End Multi selected city

    if($resetfield=="exitstatus")
    { 
       /* $_POST['exitstatus']="";
        $exitstatusValue="";*/
         $pos = array_search($_POST['resetfieldid'], $_POST['exitstatus']);

        $exitstatusValue = $_POST['exitstatus'];

        unset($exitstatusValue[$pos]);
    }
    else 
    {
        $exitstatusValue = $_POST['exitstatus'];
        if($exitstatusValue != NULL && $exitstatusValue != '--'){
            $searchallfield='';
        }
    }
    if ($resetfield == "dealsinvolving") {
        if (count($_POST['dealsinvolving']) > 0) {
             
           foreach ($_POST['dealsinvolving'] as $dealsinvolvingvaltag) {
               
               if ($dealsinvolvingvaltag == 1) {
   
                   $dealsinvolvingfiltertag .= 'New Investor, ';
   
               } else if ($dealsinvolvingvaltag == 2) {
   
                   $dealsinvolvingfiltertag .= 'Existing Investor, ';
   
               } else {
                   $dealsinvolvingfiltertag = '';
               }
           }
           $dealsinvolvingfiltertag = trim($dealsinvolvingfiltertag, ', ');
       }
       $dealsarraytag = explode(",",$dealsinvolvingfiltertag); 
       $pos = array_search($_POST['resetfieldid'],$dealsarraytag);
       $dealsinvolvingvalue = $_POST['dealsinvolving'];
       unset($dealsinvolvingvalue[$pos]);
       emptyhiddendata();
    } else {
       $dealsinvolvingvalue = $_POST['dealsinvolving'];
       if (count($dealsinvolvingvalue) > 0) {
           $searchallfield = '';
       }
    }
    if ($resetfield == "sector") {
             $pos = array_search($_POST['resetfieldid'], $_POST['sector']);
            $sector = $_POST['sector'];
            unset($sector[$pos]);
           // $_POST['sector'] = "";
            $_POST['subsector'] = "";
            $_POST['filtersubsector'] = "";
            $filtersubsector = '';
            emptyhiddendata();
        } else {
            $sector = $_POST['sector'];
            if ($sector != '--' && count($sector) > 0) {
                $searchallfield = '';
            }
        }

        if ($resetfield == "subsector") {
             $pos = array_search($_POST['resetfieldid'], $_POST['subsector']);
             $subsector = $_POST['subsector'];
             unset($subsector[$pos]);
            //$_POST['subsector'] = "";
            emptyhiddendata();
        } else {
            $subsector = $_POST['subsector'];
            if ($subsector != '--' && count($subsector) > 0) {
                $searchallfield = '';
            }
        }
    if ($resetfield == "companysearch") {
            $arrayval=explode(",",$_POST['companyauto_sug']);
            $pos = array_search($_POST['resetfieldid'], $arrayval);
            $companysearch = $arrayval;
            unset($companysearch[$pos]);
            $companysearch=implode(",",$companysearch);
            $_POST['companysearch'] = $companysearch;
           
            /*$_POST['companysearch'] = "";
            $_POST['popup_keyword'] = "";
            $_POST['companyauto_sug'] = "";
            $companysearch = "";
            $companyauto = '';*/
            //echo $companysearch;

            $sql_company = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($companysearch)";
            $sql_company_Exe = mysql_query($sql_company);
            $company_filter = "";
            $response = array();
            $i = 0;
            while ($myrow = mysql_fetch_array($sql_company_Exe, MYSQL_BOTH)) {

                $response[$i]['id'] = $myrow['id'];
                $response[$i]['name'] = $myrow['name'];
                if ($i != 0) {

                    $company_filter .= ",";
                    $company_id .= ",";
                }
                $company_filter .= $myrow['name'];
                $company_id .=$myrow['id'];
                $i++;

            }
            if ($response != '') {
                $companysug_response = json_encode($response);
            } else {
                $companysug_response = 'null';
            }
            if ($companysearch != '') {
                $searchallfield = '';
                $month1 = 01;
                $year1 = 1998;
                $month2 = date('n');
                $year2 = date('Y');
                $dt1 = $startyear = $year1 . "-" . $month1 . "-01";
            }

            //$companysearchhidden = preg_replace('/\s+/', '_', $companysearch);
        } else {
            $companysearch = trim($_POST['companysearch']);
            $companyauto = $_POST['companyauto_sug'];
            if (isset($_POST['popup_select']) && $_POST['popup_select'] == 'company') {
                //$companysearch=trim($_POST['popup_keyword']);
                $companyauto = $companysearch = trim(implode(',', $_POST['search_multi']));

                $sql_company = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($companysearch)";

                $sql_company_Exe = mysql_query($sql_company);
                $company_filter = "";
                $response = array();
                $i = 0;
                while ($myrow = mysql_fetch_array($sql_company_Exe, MYSQL_BOTH)) {

                    $response[$i]['id'] = $myrow['id'];
                    $response[$i]['name'] = $myrow['name'];
                    if ($i != 0) {

                        $company_filter .= ",";
                        $company_id .= ",";
                    }
                    $company_filter .= $myrow['name'];
                    $company_id .=$myrow['id'];
                    $i++;

                }
            } else if (isset($_POST['companyauto_sug_other']) && $_POST['companyauto_sug_other'] != '') {
                $companyauto = $_POST['companyauto_sug_other'];
                $companysearch = trim($_POST['companyauto_sug_other']);
                $companysearchhidden = preg_replace('/\s+/', '_', $companysearch);
                $month1 = 01;
                $year1 = 1998;
                $month2 = date('n');
                $year2 = date('Y');
                $dt1 = $startyear = $year1 . "-" . $month1 . "-01";
            } else if ($_POST['searchallfieldHide'] == 'remove' || $_POST['searchallfieldHide'] != 'content_exit') {
                if (isset($_POST['companyauto_sug'])) {
                    $companyauto = $companysearch = trim($_POST['companyauto_sug']);
                    $companysearchhidden = trim($_POST['companyauto_sug']);
                } /*else {
                    $companyauto = $companysearch = $companysearchhidden = '';
                }*/
            } else if ($_POST['searchallfieldHide'] == '' && isset($_POST['companyauto_sug'])) {
                $companyauto = $companysearch = trim($_POST['companyauto_sug']);
                $companysearchhidden = trim($_POST['companyauto_sug']);
            }
            $sql_company = "select  PECompanyId as id,companyname as name from pecompanies where PECompanyId IN($companysearch)";
            $sql_company_Exe = mysql_query($sql_company);
            $company_filter = "";
            $response = array();
            $i = 0;
            while ($myrow = mysql_fetch_array($sql_company_Exe, MYSQL_BOTH)) {

                $response[$i]['id'] = $myrow['id'];
                $response[$i]['name'] = $myrow['name'];
                if ($i != 0) {

                    $company_filter .= ",";
                    $company_id .= ",";
                }
                $company_filter .= $myrow['name'];
                $company_id .=$myrow['id'];
                $i++;

            }
            if ($response != '') {
                $companysug_response = json_encode($response);
            } else {
                $companysug_response = 'null';
            }
            if ($companysearch != '') {
                $searchallfield = '';
            }

           
        }
         $companysearchhidden = preg_replace('/\s+/', '_', $companysearch);

     //valuation 
    $valuations=$_POST['valuations'];
    /*if($_POST['valuations'])
    {
            $boolvaluations=true;
            
              $c=1;
        foreach($valuations as $v)
        {
            if($c > 1) { $coa=','; }
            $valuationstxt.= "$coa $v";
            $c++;
        }
            //foreach($stageval as $stage)
            //  echo "<br>----" .$stage;
    }
    else
    {
            $valuations="--";
            $boolvaluations=false;
    }*/
    if ($resetfield == "valuations") {

        $pos = array_search($_POST['resetfieldid'], $_POST['valuations']);
        $valuations = $_POST['valuations'];
        
         if($_POST['valuations'] == ""){

             $valuations = "--";
         }

        unset($valuations[$pos]);
     
       emptyhiddendata();
    } else {

         
    $valuations = $_POST['valuations'];
       if($valuations != '') {
            $searchallfield = '';
        }
    }

    if ($_POST['valuations'] && $valuations != "" && $valuations != "--") {
        $boolvaluations = true;
         $c = 1;
        foreach ($valuations as $v) {
            if ($c > 1) {$coa = ',';}
            $valuationstxt .= "$coa $v";
            $c++;
        }
        
    } else {
        $valuations = "--";
        $boolvaluations = false;
    }

    
    
    
    //echo "<br>**" .$stage;
    $companyType=$_POST['comptype'];
    //echo "<BR>---" .$companyType;
    $debt_equity=$_POST['dealtype_debtequity'];
    if($resetfield=="syndication")
    { 
        
        $_POST['Syndication']="";
        $syndication="--";
    }
    else 
    {
        $syndication=trim($_POST['Syndication']);
        if($syndication!='--' && $syndication!=''){
            $searchallfield='';
    }
    }
    if ($resetfield == "txtregion") {
    /*$_POST['txtregion'] = "";
    $regionId = array();*/
         $pos = array_search($_POST['resetfieldid'], $_POST['txtregion']);
        
        $regionId = $_POST['txtregion'];
        unset($regionId[$pos]);
        emptyhiddendata();
    } else {
        $regionId = $_POST['txtregion'];
        if (count($regionId) > 0) {
            $searchallfield = '';
        }
    }
    if($syndication == 0)
        $syndication_Display="Yes";
    elseif($syndication == 1)
        $syndication_Display="No";
    elseif($syndication == "--")
        $syndication_Display="Both";
    $investorType=$_POST['invType'];

    $regionId=$_POST['txtregion'];

    //$range=$_POST['invrange'];
    $startRangeValue=$_POST['invrangestart'];
    $endRangeValue=$_POST['invrangeend'];
    $endRangeValueDisplay =$endRangeValue;
    //echo "<br>Stge**" .$range;
    $whereind="";
    $whereregion="";
    $whereinvType="";
    $wherestage="";
    $wheredates="";
    $whererange="";
    $wherelisting_status="";
     $resetfield=$_POST['resetfield'];
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
            // $month1= date('n', strtotime(date('Y-m')." -2   month")); 
            // $year1 = date('Y');
            // $month2= date('n');
            // $year2 = date('Y'); 
            // if($type==1)
            // {
            //     $fixstart=1998;
            //     $startyear =  $fixstart."-01-01";
            //     $fixend=date("Y");
            //     $endyear = $endyear = date("Y-m-d");
            // }
            // else 
            // {
            //     $fixstart=2009;
            //     $startyear =  $fixstart."-01-01";
            //     $fixend=date("Y");
            //     $endyear = date("Y-m-d");
            //  }

            if($type == 1)
            {
                $month1= date('n', strtotime(date('Y-m')." - 1   month")); 
                $year1 = date('Y');
                $month2= date('n');
                $year2 = date('Y'); 
                $fixstart=1998;
                $startyear =  $fixstart."-01-01";
                $fixend=date("Y");
                $endyear = date("Y-m-d");
            }
            else 
            {
                $month1= date('n');
                $year1 = date('Y', strtotime(date('Y')." -1  Year"));
                $month2= date('n');
                $year2 = date('Y');
                $fixstart=date('Y', strtotime(date('Y')." -1  Year"));
                $startyear =  $fixstart."-".$month1."-01";
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
        
         if(trim($_POST['searchallfield'])!=""){
            if(($_POST['month1']==date('n')) && $_POST['year1']==date('Y', strtotime(date('Y')." -1  Year")) && $_POST['month2']==date('n') && $_POST['year2']==date('Y')){
                if( $period_flag == 1 ) {
                    $month1=01; 
                    $year1 = 1998;
                    $month2= date('n');
                    $year2 = date('Y');    
                } else {
                    $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                   $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                   $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                   $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
                }
                
                       }else{
                           $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n');
                           $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y', strtotime(date('Y')." -1  Year"));
                           $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
                           $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
               }
            }
            if(trim($_POST['keywordsearch'])!="" || trim($_POST['sectorsearch'])!="" || trim($_POST['companysearch'])!="" || trim($_POST['advisorsearch_legal'])!="" ||  trim($_POST['advisorsearch_trans'])!=""){
                $month1=01; 
                $year1 = 1998;
                $month2= date('n');
                $year2 = date('Y');
            }
        }
        else
        {
         $month1=($_POST['month1'] || ($_POST['month1']!="")) ?  $_POST['month1'] : date('n', strtotime(date('Y-m')." -2     month"));
         $year1 = ($_POST['year1'] || ($_POST['year1']!="")) ?  $_POST['year1'] : date('Y');
         $month2=($_POST['month2'] || ($_POST['month2']!="")) ?  $_POST['month2'] : date('n');
         $year2 = ($_POST['year2'] || ($_POST['year2']!="")) ?  $_POST['year2'] : date('Y');
        }
        
        $fixstart=$year1;
        $startyear =  $fixstart."-".$month1."-01";
        $fixend=$year2;
        $endyear =  $fixend."-".$month2."-31";
        
    }

    /*if (!$_POST){
            $_POST['month1'] = $month1;
            $_POST['year1']  = $year1;
            $_POST['month2'] = $month2;
            $_POST['year2']  = $year2;
    }*/

$notable=false;
// $vcflagValue=$_POST['txtvcFlagValue'];
//echo "<br>FLAG VALIE--" .$vcflagValue;
$datevalue = returnMonthname($month1) ."-".$year1 ."to". returnMonthname($month2) ."-" .$year2;
$splityear1=(substr($year1,2));
$splityear2=(substr($year2,2));

if(($month1!="--") && ($month2!=="--") && ($year1!="--") &&($year2!="--"))
{   $datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
$datevalueDisplay2 = returnMonthname($month2) ."  ".$splityear2;
$wheredates1= "";
}
$whereaddHideamount="";

     if($industry !='' && (count($industry) > 0))
                    {
        $indusSql = $industryvalue = '';
        foreach($industry as $industrys)
        {
            $indusSql .= " IndustryId=$industrys or ";
        }
        $indusSql = trim($indusSql,' or ');
        $industrysql= "select industry from industry where $indusSql"; 
                                                    
                        if ($industryrs = mysql_query($industrysql))
                        {
                            While($myrow=mysql_fetch_array($industryrs, MYSQL_BOTH))
                            {
                                $industryvalue.=$myrow["industry"].',';
                            }
                        }
        $industryvalue=  trim($industryvalue,',');
        $industry_hide = implode($industry,',');
                }
        if ($state != '' && (count($state) > 0)) {
            $indusSql = $statevalue = '';$statevalueid = '';
            foreach ($state as $states) {
                $indusSql .= " state_id=$states or ";
            }
            $indusSql = trim($indusSql, ' or ');
            $statesql = "select state_name,state_id from state where $indusSql";

            if ($staters = mysql_query($statesql)) {
                while ($myrow = mysql_fetch_array($staters, MYSQL_BOTH)) {
                    $statevalue .= $myrow["state_name"] . ',';
                    $statevalueid .= $myrow["state_id"] . ',';
                }
            }
            $statevalue = trim($statevalue, ',');
            $statevalueid = trim($statevalueid, ',');
            $state_hide = implode($state, ',');
        }


                if ($sector != '' && (count($sector) > 0)) {
                    $sectorvalue = '';
                    $sectorstr = implode(',',$sector); 
                    $sectorssql = "select sector_name,sector_id from pe_sectors where sector_id IN ($sectorstr)";
                   
                    if ($sectors = mysql_query($sectorssql)) {
                        while ($myrow = mysql_fetch_array($sectors, MYSQL_BOTH)) {
                            $sectorvalue .= $myrow["sector_name"] . ',';
                            $sectorvalueid .= $myrow["sector_id"] . ',';
                        }
                    }
                   
                    $sectorvalue = trim($sectorvalue, ',');
                    // $industry_hide = implode($industry, ',');
                }
                
                if ($subsector != '' && (count($subsector) > 0)) {
                    $subsectorvalue = '';
                    $subsectorvalue = implode(',',$subsector); 
                }


    // Round Value
    if($round!="--" || $round != null)
    {
        $roundSql = $roundTxtVal = '';
        foreach($round as $rounds)
        {
            $roundSql .= " `round` like '".$rounds."' or `round` like '".$rounds."-%' or ";
            $roundTxtVal .= $rounds.',';
        }
        $roundTxtVal=  trim($roundTxtVal,',');
        $roundSqlStr = trim($roundSql,' or ');
        $roundSql="SELECT * FROM `peinvestments` where $roundSqlStr group by `round`";
        if ($roundQuery = mysql_query($roundSql))
        {   
            $roundtxt='';
            While($myrow=mysql_fetch_array($roundQuery, MYSQL_BOTH))
            {
                    $roundtxt.=$myrow["round"].",";
            }
            $roundtxt=  trim($roundtxt,',');
        }
    }
    //
    
    $stageCnt=0;
            $cnt=0;
            $stageCntSql="select count(StageId) as cnt from stage";
            if($rsStageCnt=mysql_query($stageCntSql))
            {
              while($mystagecntrow=mysql_fetch_array($rsStageCnt,MYSQL_BOTH))
               {
                 $stageCnt=$mystagecntrow["cnt"];
               }
            }
             if($boolStage==true)
    {
        foreach($stageval as $stageid)
        {
            $stagesql= "select Stage,StageId from stage where StageId=$stageid";
        //  echo "<br>**".$stagesql;
            if ($stagers = mysql_query($stagesql))
            {
                While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
                {
                                            $cnt=$cnt+1;
                    $stagevaluetext= $stagevaluetext. ",".$myrow["Stage"] ;
                    $stagevalueid .= $myrow["StageId"] . ',';
                }
            }
        }
        $stagevaluetext =substr_replace($stagevaluetext, '', 0,1);
        if($cnt==$stageCnt)
        {      $stagevaluetext="All Stages";}
        }
    else
        $stagevaluetext="";
    //echo "<br>*************".$stagevaluetext;
            
             //valuations
                if($boolvaluations==true)
                {
                   $valuationsql='';

                   $count = count($valuations);



                    if($count==1) { $valuationsql= "pe.$valuations[0]!=0 AND "; }
                    else if ($count==2) { $valuationsql= "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0   AND "; }
                    else if ($count==3) { $valuationsql= "pe.$valuations[0]!=0  AND  pe.$valuations[1]!=0  AND  pe.$valuations[2]!=0  AND "; }   

        //            $valuattext =substr_replace($valuattext, '', 0,1);
                    //echo $valuationsql; exit();
               }
               else { $valuationsql='';}
            //valuations
               
               
               
    if($companyType=="L")
            $companyTypeDisplay="Listed";
    elseif($companyType=="U")
                    $companyTypeDisplay="UnListed";
        elseif($companyType=="--")
                    $companyTypeDisplay="";

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
    if ($investor_head != "--") {
        $invheadSql = "select country from country where countryid='$investor_head'";
        if ($invrs = mysql_query($invheadSql)) {
            while ($myrow = mysql_fetch_array($invrs, MYSQL_BOTH)) {
                $invheadvalue = $myrow["country"];
            }
        }
    }

    if(count($regionId) >0)
        {
                $region_Sql = $regionvalue = '';
                foreach($regionId as $regionIds)
                {
                    $region_Sql .= " RegionId=$regionIds or ";
                }
                $roundSqlStr = trim($region_Sql,' or ');
                
                $regionSql= "select Region,RegionId from region where $roundSqlStr";
                if ($regionrs = mysql_query($regionSql))
                {
                    While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
                    {
                                $regionvalue .= $myregionrow["Region"].', ';
                                $regionvalueId .= $myregionrow["RegionId"] . ', ';
                    }
                }
                $regionvalue = trim($regionvalue,', ');
                $region_hide = implode($regionId, ',');
    }

    $searchString="Undisclosed";
$searchString=strtolower($searchString);

$searchString1="Unknown";
$searchString1=strtolower($searchString1);

$searchString2="Others";
$searchString2=strtolower($searchString2);                        
                           
    
?>

<?php
$tour='Allow';
    $defpage=$vcflagValue;
    $investdef=1;
    $stagedef=1;
   
    if($strvalue[3]=='Directory'){
        if($VCFlagValue == 10 && $usrRgs['PEMa'] == 0){
            $accesserror = 1;
        } else if($VCFlagValue == 11 && $usrRgs['VCMa'] == 0){
            $accesserror = 1;
        } else if($VCFlagValue == 7 && $usrRgs['PEIpo'] == 0){
            $accesserror = 1;
        } else if($VCFlagValue == 8 && $usrRgs['VCIpo'] == 0){
            $accesserror = 1;
        }
        $dealvalue=$strvalue[2];
        $topNav = 'Directory'; 
        include_once('dirnew_header.php');
    }else{
        $topNav = 'Deals'; 
        include_once('tvheader_search_detail.php');
    }

// SHP 

// Main Table Values For Percentage
$getMainTablesSql="select * from pe_shp where PEId=$IPO_MandAId limit 1";
$mainTableValidate = mysql_query($getMainTablesSql);
$Maintable_Valid_Count = mysql_num_rows($mainTableValidate);

if($Maintable_Valid_Count != 0){
$mainTable = mysql_fetch_array($mainTableValidate);
$mainTable_ESOP = $mainTable['ESOP'];
$mainTable_Others = $mainTable['Others'];
$mainTable_investor_total = $mainTable['pe_shp_investor_total'];
$mainTable_promoters_total = $mainTable['pe_shp_promoters_total'];
}else{
$mainTable_ESOP = "";
$mainTable_Others = "";
$mainTable_investor_total = "";
$mainTable_promoters_total = "";
}
?>
<style>

/*
== malihu jquery custom scrollbar plugin ==
Plugin URI: http://manos.malihu.gr/jquery-custom-content-scroller
*/



/*
CONTENTS: 
1. BASIC STYLE - Plugin's basic/essential CSS properties (normally, should not be edited). 
2. VERTICAL SCROLLBAR - Positioning and dimensions of vertical scrollbar. 
3. HORIZONTAL SCROLLBAR - Positioning and dimensions of horizontal scrollbar.
4. VERTICAL AND HORIZONTAL SCROLLBARS - Positioning and dimensions of 2-axis scrollbars. 
5. TRANSITIONS - CSS3 transitions for hover events, auto-expanded and auto-hidden scrollbars. 
6. SCROLLBAR COLORS, OPACITY AND BACKGROUNDS 
    6.1 THEMES - Scrollbar colors, opacity, dimensions, backgrounds etc. via ready-to-use themes.
*/



/* 
------------------------------------------------------------------------------------------------------------------------
1. BASIC STYLE  
------------------------------------------------------------------------------------------------------------------------
*/

.mCustomScrollbar{ -ms-touch-action: pinch-zoom; touch-action: pinch-zoom; /* direct pointer events to js */ }
.mCustomScrollbar.mCS_no_scrollbar, .mCustomScrollbar.mCS_touch_action{ -ms-touch-action: auto; touch-action: auto; }

.mCustomScrollBox{ /* contains plugin's markup */
    position: relative;
    overflow: hidden;
    height: 100%;
    max-width: 100%;
    outline: none;
    direction: ltr;
}

.mCSB_container{ /* contains the original content */
    overflow: hidden;
    width: auto;
    height: auto;
}



/* 
------------------------------------------------------------------------------------------------------------------------
2. VERTICAL SCROLLBAR 
y-axis
------------------------------------------------------------------------------------------------------------------------
*/

.mCSB_inside > .mCSB_container{ margin-right: 30px; }

.mCSB_container.mCS_no_scrollbar_y.mCS_y_hidden{ margin-right: 0; } /* non-visible scrollbar */

.mCS-dir-rtl > .mCSB_inside > .mCSB_container{ /* RTL direction/left-side scrollbar */
    margin-right: 0;
    margin-left: 30px;
}

.mCS-dir-rtl > .mCSB_inside > .mCSB_container.mCS_no_scrollbar_y.mCS_y_hidden{ margin-left: 0; } /* RTL direction/left-side scrollbar */

.mCSB_scrollTools{ /* contains scrollbar markup (draggable element, dragger rail, buttons etc.) */
    position: absolute;
    width: 16px;
    height: auto;
    left: auto;
    top: 0;
    right: 0;
    bottom: 0;
}

.mCSB_outside + .mCSB_scrollTools{ right: -26px; } /* scrollbar position: outside */

.mCS-dir-rtl > .mCSB_inside > .mCSB_scrollTools, 
.mCS-dir-rtl > .mCSB_outside + .mCSB_scrollTools{ /* RTL direction/left-side scrollbar */
    right: auto;
    left: 0;
}

.mCS-dir-rtl > .mCSB_outside + .mCSB_scrollTools{ left: -26px; } /* RTL direction/left-side scrollbar (scrollbar position: outside) */

.mCSB_scrollTools .mCSB_draggerContainer{ /* contains the draggable element and dragger rail markup */
    position: absolute;
    top: 0;
    left: 0;
    bottom: 0;
    right: 0; 
    height: auto;
}

.mCSB_scrollTools a + .mCSB_draggerContainer{ margin: 20px 0; }

.mCSB_scrollTools .mCSB_draggerRail{
    width: 2px;
    height: 100%;
    margin: 0 auto;
    -webkit-border-radius: 16px; -moz-border-radius: 16px; border-radius: 16px;
}

.mCSB_scrollTools .mCSB_dragger{ /* the draggable element */
    cursor: pointer;
    width: 100%;
    height: 30px; /* minimum dragger height */
    z-index: 1;
}

.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ /* the dragger element */
    position: relative;
    width: 4px;
    height: 100%;
    margin: 0 auto;
    -webkit-border-radius: 16px; -moz-border-radius: 16px; border-radius: 16px;
    text-align: center;
}

.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded .mCSB_dragger_bar, 
.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_dragger .mCSB_dragger_bar{ width: 12px; /* auto-expanded scrollbar */ }

.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail{ width: 8px; /* auto-expanded scrollbar */ }

.mCSB_scrollTools .mCSB_buttonUp,
.mCSB_scrollTools .mCSB_buttonDown{
    display: block;
    position: absolute;
    height: 20px;
    width: 100%;
    overflow: hidden;
    margin: 0 auto;
    cursor: pointer;
}

.mCSB_scrollTools .mCSB_buttonDown{ bottom: 0; }



/* 
------------------------------------------------------------------------------------------------------------------------
3. HORIZONTAL SCROLLBAR 
x-axis
------------------------------------------------------------------------------------------------------------------------
*/

.mCSB_horizontal.mCSB_inside > .mCSB_container{
    margin-right: 0;
    margin-bottom: 30px;
}

.mCSB_horizontal.mCSB_outside > .mCSB_container{ min-height: 100%; }

.mCSB_horizontal > .mCSB_container.mCS_no_scrollbar_x.mCS_x_hidden{ margin-bottom: 0; } /* non-visible scrollbar */

.mCSB_scrollTools.mCSB_scrollTools_horizontal{
    width: auto;
    height: 16px;
    top: auto;
    right: 0;
    bottom: 0;
    left: 0;
}

.mCustomScrollBox + .mCSB_scrollTools.mCSB_scrollTools_horizontal,
.mCustomScrollBox + .mCSB_scrollTools + .mCSB_scrollTools.mCSB_scrollTools_horizontal{ bottom: -26px; } /* scrollbar position: outside */

.mCSB_scrollTools.mCSB_scrollTools_horizontal a + .mCSB_draggerContainer{ margin: 0 20px; }

.mCSB_scrollTools.mCSB_scrollTools_horizontal .mCSB_draggerRail{
    width: 100%;
    height: 2px;
    margin: 7px 0;
}

.mCSB_scrollTools.mCSB_scrollTools_horizontal .mCSB_dragger{
    width: 30px; /* minimum dragger width */
    height: 100%;
    left: 0;
}

.mCSB_scrollTools.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
    width: 100%;
    height: 4px;
    margin: 6px auto;
}

.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded .mCSB_dragger_bar, 
.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_dragger .mCSB_dragger_bar{
    height: 12px; /* auto-expanded scrollbar */
    margin: 2px auto;
}

.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail{
    height: 8px; /* auto-expanded scrollbar */
    margin: 4px 0;
}

.mCSB_scrollTools.mCSB_scrollTools_horizontal .mCSB_buttonLeft,
.mCSB_scrollTools.mCSB_scrollTools_horizontal .mCSB_buttonRight{
    display: block;
    position: absolute;
    width: 20px;
    height: 100%;
    overflow: hidden;
    margin: 0 auto;
    cursor: pointer;
}

.mCSB_scrollTools.mCSB_scrollTools_horizontal .mCSB_buttonLeft{ left: 0; }

.mCSB_scrollTools.mCSB_scrollTools_horizontal .mCSB_buttonRight{ right: 0; }



/* 
------------------------------------------------------------------------------------------------------------------------
4. VERTICAL AND HORIZONTAL SCROLLBARS 
yx-axis 
------------------------------------------------------------------------------------------------------------------------
*/

.mCSB_container_wrapper{
    position: absolute;
    height: auto;
    width: auto;
    overflow: hidden;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    margin-right: 30px;
    margin-bottom: 30px;
}

.mCSB_container_wrapper > .mCSB_container{
    padding-right: 30px;
    padding-bottom: 30px;
    -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;
}

.mCSB_vertical_horizontal > .mCSB_scrollTools.mCSB_scrollTools_vertical{ bottom: 20px; }

.mCSB_vertical_horizontal > .mCSB_scrollTools.mCSB_scrollTools_horizontal{ right: 20px; }

/* non-visible horizontal scrollbar */
.mCSB_container_wrapper.mCS_no_scrollbar_x.mCS_x_hidden + .mCSB_scrollTools.mCSB_scrollTools_vertical{ bottom: 0; }

/* non-visible vertical scrollbar/RTL direction/left-side scrollbar */
.mCSB_container_wrapper.mCS_no_scrollbar_y.mCS_y_hidden + .mCSB_scrollTools ~ .mCSB_scrollTools.mCSB_scrollTools_horizontal, 
.mCS-dir-rtl > .mCustomScrollBox.mCSB_vertical_horizontal.mCSB_inside > .mCSB_scrollTools.mCSB_scrollTools_horizontal{ right: 0; }

/* RTL direction/left-side scrollbar */
.mCS-dir-rtl > .mCustomScrollBox.mCSB_vertical_horizontal.mCSB_inside > .mCSB_scrollTools.mCSB_scrollTools_horizontal{ left: 20px; }

/* non-visible scrollbar/RTL direction/left-side scrollbar */
.mCS-dir-rtl > .mCustomScrollBox.mCSB_vertical_horizontal.mCSB_inside > .mCSB_container_wrapper.mCS_no_scrollbar_y.mCS_y_hidden + .mCSB_scrollTools ~ .mCSB_scrollTools.mCSB_scrollTools_horizontal{ left: 0; }

.mCS-dir-rtl > .mCSB_inside > .mCSB_container_wrapper{ /* RTL direction/left-side scrollbar */
    margin-right: 0;
    margin-left: 30px;
}

.mCSB_container_wrapper.mCS_no_scrollbar_y.mCS_y_hidden > .mCSB_container{ padding-right: 0; }

.mCSB_container_wrapper.mCS_no_scrollbar_x.mCS_x_hidden > .mCSB_container{ padding-bottom: 0; }

.mCustomScrollBox.mCSB_vertical_horizontal.mCSB_inside > .mCSB_container_wrapper.mCS_no_scrollbar_y.mCS_y_hidden{
    margin-right: 0; /* non-visible scrollbar */
    margin-left: 0;
}

/* non-visible horizontal scrollbar */
.mCustomScrollBox.mCSB_vertical_horizontal.mCSB_inside > .mCSB_container_wrapper.mCS_no_scrollbar_x.mCS_x_hidden{ margin-bottom: 0; }



/* 
------------------------------------------------------------------------------------------------------------------------
5. TRANSITIONS  
------------------------------------------------------------------------------------------------------------------------
*/

.mCSB_scrollTools, 
.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCSB_scrollTools .mCSB_buttonUp,
.mCSB_scrollTools .mCSB_buttonDown,
.mCSB_scrollTools .mCSB_buttonLeft,
.mCSB_scrollTools .mCSB_buttonRight{
    -webkit-transition: opacity .2s ease-in-out, background-color .2s ease-in-out;
    -moz-transition: opacity .2s ease-in-out, background-color .2s ease-in-out;
    -o-transition: opacity .2s ease-in-out, background-color .2s ease-in-out;
    transition: opacity .2s ease-in-out, background-color .2s ease-in-out;
}

.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger_bar, /* auto-expanded scrollbar */
.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerRail, 
.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger_bar, 
.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerRail{
    -webkit-transition: width .2s ease-out .2s, height .2s ease-out .2s, 
                margin-left .2s ease-out .2s, margin-right .2s ease-out .2s, 
                margin-top .2s ease-out .2s, margin-bottom .2s ease-out .2s,
                opacity .2s ease-in-out, background-color .2s ease-in-out; 
    -moz-transition: width .2s ease-out .2s, height .2s ease-out .2s, 
                margin-left .2s ease-out .2s, margin-right .2s ease-out .2s, 
                margin-top .2s ease-out .2s, margin-bottom .2s ease-out .2s,
                opacity .2s ease-in-out, background-color .2s ease-in-out; 
    -o-transition: width .2s ease-out .2s, height .2s ease-out .2s, 
                margin-left .2s ease-out .2s, margin-right .2s ease-out .2s, 
                margin-top .2s ease-out .2s, margin-bottom .2s ease-out .2s,
                opacity .2s ease-in-out, background-color .2s ease-in-out; 
    transition: width .2s ease-out .2s, height .2s ease-out .2s, 
                margin-left .2s ease-out .2s, margin-right .2s ease-out .2s, 
                margin-top .2s ease-out .2s, margin-bottom .2s ease-out .2s,
                opacity .2s ease-in-out, background-color .2s ease-in-out; 
}



/* 
------------------------------------------------------------------------------------------------------------------------
6. SCROLLBAR COLORS, OPACITY AND BACKGROUNDS  
------------------------------------------------------------------------------------------------------------------------
*/

/* 
----------------------------------------
6.1 THEMES 
----------------------------------------
*/

/* default theme ("light") */

.mCSB_scrollTools{ opacity: 0.75; filter: "alpha(opacity=75)"; -ms-filter: "alpha(opacity=75)"; }

.mCS-autoHide > .mCustomScrollBox > .mCSB_scrollTools,
.mCS-autoHide > .mCustomScrollBox ~ .mCSB_scrollTools{ opacity: 0; filter: "alpha(opacity=0)"; -ms-filter: "alpha(opacity=0)"; }

.mCustomScrollbar > .mCustomScrollBox > .mCSB_scrollTools.mCSB_scrollTools_onDrag,
.mCustomScrollbar > .mCustomScrollBox ~ .mCSB_scrollTools.mCSB_scrollTools_onDrag,
.mCustomScrollBox:hover > .mCSB_scrollTools,
.mCustomScrollBox:hover ~ .mCSB_scrollTools,
.mCS-autoHide:hover > .mCustomScrollBox > .mCSB_scrollTools,
.mCS-autoHide:hover > .mCustomScrollBox ~ .mCSB_scrollTools{ opacity: 1; filter: "alpha(opacity=100)"; -ms-filter: "alpha(opacity=100)"; }

.mCSB_scrollTools .mCSB_draggerRail{
    background-color: #000; background-color: rgba(0,0,0,0.4);
    filter: "alpha(opacity=40)"; -ms-filter: "alpha(opacity=40)"; 
}

.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
    background-color: #fff; background-color: rgba(255,255,255,0.75);
    filter: "alpha(opacity=75)"; -ms-filter: "alpha(opacity=75)"; 
}

.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{
    background-color: #fff; background-color: rgba(255,255,255,0.85);
    filter: "alpha(opacity=85)"; -ms-filter: "alpha(opacity=85)"; 
}
.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{
    background-color: #fff; background-color: rgba(255,255,255,0.9);
    filter: "alpha(opacity=90)"; -ms-filter: "alpha(opacity=90)"; 
}

.mCSB_scrollTools .mCSB_buttonUp,
.mCSB_scrollTools .mCSB_buttonDown,
.mCSB_scrollTools .mCSB_buttonLeft,
.mCSB_scrollTools .mCSB_buttonRight{
    background-image: url(mCSB_buttons.png); /* css sprites */
    background-repeat: no-repeat;
    opacity: 0.4; filter: "alpha(opacity=40)"; -ms-filter: "alpha(opacity=40)"; 
}

.mCSB_scrollTools .mCSB_buttonUp{
    background-position: 0 0;
    /* 
    sprites locations 
    light: 0 0, -16px 0, -32px 0, -48px 0, 0 -72px, -16px -72px, -32px -72px
    dark: -80px 0, -96px 0, -112px 0, -128px 0, -80px -72px, -96px -72px, -112px -72px
    */
}

.mCSB_scrollTools .mCSB_buttonDown{
    background-position: 0 -20px;
    /* 
    sprites locations
    light: 0 -20px, -16px -20px, -32px -20px, -48px -20px, 0 -92px, -16px -92px, -32px -92px
    dark: -80px -20px, -96px -20px, -112px -20px, -128px -20px, -80px -92px, -96px -92px, -112 -92px
    */
}

.mCSB_scrollTools .mCSB_buttonLeft{
    background-position: 0 -40px;
    /* 
    sprites locations 
    light: 0 -40px, -20px -40px, -40px -40px, -60px -40px, 0 -112px, -20px -112px, -40px -112px
    dark: -80px -40px, -100px -40px, -120px -40px, -140px -40px, -80px -112px, -100px -112px, -120px -112px
    */
}

.mCSB_scrollTools .mCSB_buttonRight{
    background-position: 0 -56px;
    /* 
    sprites locations 
    light: 0 -56px, -20px -56px, -40px -56px, -60px -56px, 0 -128px, -20px -128px, -40px -128px
    dark: -80px -56px, -100px -56px, -120px -56px, -140px -56px, -80px -128px, -100px -128px, -120px -128px
    */
}

.mCSB_scrollTools .mCSB_buttonUp:hover,
.mCSB_scrollTools .mCSB_buttonDown:hover,
.mCSB_scrollTools .mCSB_buttonLeft:hover,
.mCSB_scrollTools .mCSB_buttonRight:hover{ opacity: 0.75; filter: "alpha(opacity=75)"; -ms-filter: "alpha(opacity=75)"; }

.mCSB_scrollTools .mCSB_buttonUp:active,
.mCSB_scrollTools .mCSB_buttonDown:active,
.mCSB_scrollTools .mCSB_buttonLeft:active,
.mCSB_scrollTools .mCSB_buttonRight:active{ opacity: 0.9; filter: "alpha(opacity=90)"; -ms-filter: "alpha(opacity=90)"; }


/* theme: "dark" */

.mCS-dark.mCSB_scrollTools .mCSB_draggerRail{ background-color: #000; background-color: rgba(0,0,0,0.15); }

.mCS-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.75); }

.mCS-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: rgba(0,0,0,0.85); }

.mCS-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: rgba(0,0,0,0.9); }

.mCS-dark.mCSB_scrollTools .mCSB_buttonUp{ background-position: -80px 0; }

.mCS-dark.mCSB_scrollTools .mCSB_buttonDown{ background-position: -80px -20px; }

.mCS-dark.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -80px -40px; }

.mCS-dark.mCSB_scrollTools .mCSB_buttonRight{ background-position: -80px -56px; }

/* ---------------------------------------- */



/* theme: "light-2", "dark-2" */

.mCS-light-2.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-dark-2.mCSB_scrollTools .mCSB_draggerRail{
    width: 4px;
    background-color: #fff; background-color: rgba(255,255,255,0.1);
    -webkit-border-radius: 1px; -moz-border-radius: 1px; border-radius: 1px;
}

.mCS-light-2.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-dark-2.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
    width: 4px;
    background-color: #fff; background-color: rgba(255,255,255,0.75);
    -webkit-border-radius: 1px; -moz-border-radius: 1px; border-radius: 1px;
}

.mCS-light-2.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
.mCS-dark-2.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
.mCS-light-2.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-dark-2.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
    width: 100%;
    height: 4px;
    margin: 6px auto;
}

.mCS-light-2.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #fff; background-color: rgba(255,255,255,0.85); }

.mCS-light-2.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-light-2.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #fff; background-color: rgba(255,255,255,0.9); }

.mCS-light-2.mCSB_scrollTools .mCSB_buttonUp{ background-position: -32px 0; }

.mCS-light-2.mCSB_scrollTools .mCSB_buttonDown{ background-position: -32px -20px; }

.mCS-light-2.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -40px -40px; }

.mCS-light-2.mCSB_scrollTools .mCSB_buttonRight{ background-position: -40px -56px; }


/* theme: "dark-2" */

.mCS-dark-2.mCSB_scrollTools .mCSB_draggerRail{
    background-color: #000; background-color: rgba(0,0,0,0.1);
    -webkit-border-radius: 1px; -moz-border-radius: 1px; border-radius: 1px;
}

.mCS-dark-2.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
    background-color: #000; background-color: rgba(0,0,0,0.75);
    -webkit-border-radius: 1px; -moz-border-radius: 1px; border-radius: 1px;
}

.mCS-dark-2.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.85); }

.mCS-dark-2.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-dark-2.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.9); }

.mCS-dark-2.mCSB_scrollTools .mCSB_buttonUp{ background-position: -112px 0; }

.mCS-dark-2.mCSB_scrollTools .mCSB_buttonDown{ background-position: -112px -20px; }

.mCS-dark-2.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -120px -40px; }

.mCS-dark-2.mCSB_scrollTools .mCSB_buttonRight{ background-position: -120px -56px; }

/* ---------------------------------------- */



/* theme: "light-thick", "dark-thick" */

.mCS-light-thick.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-dark-thick.mCSB_scrollTools .mCSB_draggerRail{
    width: 4px;
    background-color: #fff; background-color: rgba(255,255,255,0.1);
    -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px;
}

.mCS-light-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-dark-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
    width: 6px;
    background-color: #fff; background-color: rgba(255,255,255,0.75);
    -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px;
}

.mCS-light-thick.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
.mCS-dark-thick.mCSB_scrollTools_horizontal .mCSB_draggerRail{
    width: 100%;
    height: 4px;
    margin: 6px 0;
}

.mCS-light-thick.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-dark-thick.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
    width: 100%;
    height: 6px;
    margin: 5px auto;
}

.mCS-light-thick.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #fff; background-color: rgba(255,255,255,0.85); }

.mCS-light-thick.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-light-thick.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #fff; background-color: rgba(255,255,255,0.9); }

.mCS-light-thick.mCSB_scrollTools .mCSB_buttonUp{ background-position: -16px 0; }

.mCS-light-thick.mCSB_scrollTools .mCSB_buttonDown{ background-position: -16px -20px; }

.mCS-light-thick.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -20px -40px; }

.mCS-light-thick.mCSB_scrollTools .mCSB_buttonRight{ background-position: -20px -56px; }


/* theme: "dark-thick" */

.mCS-dark-thick.mCSB_scrollTools .mCSB_draggerRail{
    background-color: #000; background-color: rgba(0,0,0,0.1);
    -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px;
}

.mCS-dark-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
    background-color: #000; background-color: rgba(0,0,0,0.75);
    -webkit-border-radius: 2px; -moz-border-radius: 2px; border-radius: 2px;
}

.mCS-dark-thick.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.85); }

.mCS-dark-thick.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-dark-thick.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.9); }

.mCS-dark-thick.mCSB_scrollTools .mCSB_buttonUp{ background-position: -96px 0; }

.mCS-dark-thick.mCSB_scrollTools .mCSB_buttonDown{ background-position: -96px -20px; }

.mCS-dark-thick.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -100px -40px; }

.mCS-dark-thick.mCSB_scrollTools .mCSB_buttonRight{ background-position: -100px -56px; }

/* ---------------------------------------- */



/* theme: "light-thin", "dark-thin" */

.mCS-light-thin.mCSB_scrollTools .mCSB_draggerRail{ background-color: #fff; background-color: rgba(255,255,255,0.1); }

.mCS-light-thin.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-dark-thin.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ width: 2px; }

.mCS-light-thin.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
.mCS-dark-thin.mCSB_scrollTools_horizontal .mCSB_draggerRail{ width: 100%; }

.mCS-light-thin.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-dark-thin.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
    width: 100%;
    height: 2px;
    margin: 7px auto;
}


/* theme "dark-thin" */

.mCS-dark-thin.mCSB_scrollTools .mCSB_draggerRail{ background-color: #000; background-color: rgba(0,0,0,0.15); }

.mCS-dark-thin.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.75); }

.mCS-dark-thin.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.85); }

.mCS-dark-thin.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-dark-thin.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.9); }

.mCS-dark-thin.mCSB_scrollTools .mCSB_buttonUp{ background-position: -80px 0; }

.mCS-dark-thin.mCSB_scrollTools .mCSB_buttonDown{ background-position: -80px -20px; }

.mCS-dark-thin.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -80px -40px; }

.mCS-dark-thin.mCSB_scrollTools .mCSB_buttonRight{ background-position: -80px -56px; }

/* ---------------------------------------- */



/* theme "rounded", "rounded-dark", "rounded-dots", "rounded-dots-dark" */

.mCS-rounded.mCSB_scrollTools .mCSB_draggerRail{ background-color: #fff; background-color: rgba(255,255,255,0.15); }

.mCS-rounded.mCSB_scrollTools .mCSB_dragger, 
.mCS-rounded-dark.mCSB_scrollTools .mCSB_dragger, 
.mCS-rounded-dots.mCSB_scrollTools .mCSB_dragger, 
.mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_dragger{ height: 14px; }

.mCS-rounded.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-rounded-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-rounded-dots.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
    width: 14px;
    margin: 0 1px;
}

.mCS-rounded.mCSB_scrollTools_horizontal .mCSB_dragger, 
.mCS-rounded-dark.mCSB_scrollTools_horizontal .mCSB_dragger, 
.mCS-rounded-dots.mCSB_scrollTools_horizontal .mCSB_dragger, 
.mCS-rounded-dots-dark.mCSB_scrollTools_horizontal .mCSB_dragger{ width: 14px; }

.mCS-rounded.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-rounded-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-rounded-dots.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-rounded-dots-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
    height: 14px;
    margin: 1px 0;
}

.mCS-rounded.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded .mCSB_dragger_bar, 
.mCS-rounded.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_dragger .mCSB_dragger_bar, 
.mCS-rounded-dark.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded .mCSB_dragger_bar, 
.mCS-rounded-dark.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_dragger .mCSB_dragger_bar{
    width: 16px; /* auto-expanded scrollbar */
    height: 16px;
    margin: -1px 0;
}

.mCS-rounded.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
.mCS-rounded.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail, 
.mCS-rounded-dark.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
.mCS-rounded-dark.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail{ width: 4px; /* auto-expanded scrollbar */ }

.mCS-rounded.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded .mCSB_dragger_bar, 
.mCS-rounded.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_dragger .mCSB_dragger_bar, 
.mCS-rounded-dark.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded .mCSB_dragger_bar, 
.mCS-rounded-dark.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_dragger .mCSB_dragger_bar{
    height: 16px; /* auto-expanded scrollbar */
    width: 16px;
    margin: 0 -1px;
}

.mCS-rounded.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
.mCS-rounded.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail, 
.mCS-rounded-dark.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
.mCS-rounded-dark.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail{
    height: 4px; /* auto-expanded scrollbar */
    margin: 6px 0;
}

.mCS-rounded.mCSB_scrollTools .mCSB_buttonUp{ background-position: 0 -72px; }

.mCS-rounded.mCSB_scrollTools .mCSB_buttonDown{ background-position: 0 -92px; }

.mCS-rounded.mCSB_scrollTools .mCSB_buttonLeft{ background-position: 0 -112px; }

.mCS-rounded.mCSB_scrollTools .mCSB_buttonRight{ background-position: 0 -128px; }


/* theme "rounded-dark", "rounded-dots-dark" */

.mCS-rounded-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.75); }

.mCS-rounded-dark.mCSB_scrollTools .mCSB_draggerRail{ background-color: #000; background-color: rgba(0,0,0,0.15); }

.mCS-rounded-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, 
.mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.85); }

.mCS-rounded-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-rounded-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar, 
.mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.9); }

.mCS-rounded-dark.mCSB_scrollTools .mCSB_buttonUp{ background-position: -80px -72px; }

.mCS-rounded-dark.mCSB_scrollTools .mCSB_buttonDown{ background-position: -80px -92px; }

.mCS-rounded-dark.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -80px -112px; }

.mCS-rounded-dark.mCSB_scrollTools .mCSB_buttonRight{ background-position: -80px -128px; }


/* theme "rounded-dots", "rounded-dots-dark" */

.mCS-rounded-dots.mCSB_scrollTools_vertical .mCSB_draggerRail, 
.mCS-rounded-dots-dark.mCSB_scrollTools_vertical .mCSB_draggerRail{ width: 4px; }

.mCS-rounded-dots.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-rounded-dots.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
.mCS-rounded-dots-dark.mCSB_scrollTools_horizontal .mCSB_draggerRail{
    background-color: transparent;
    background-position: center;
}

.mCS-rounded-dots.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_draggerRail{
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAICAYAAADED76LAAAANElEQVQYV2NkIAAYiVbw//9/Y6DiM1ANJoyMjGdBbLgJQAX/kU0DKgDLkaQAvxW4HEvQFwCRcxIJK1XznAAAAABJRU5ErkJggg==");
    background-repeat: repeat-y;
    opacity: 0.3;
    filter: "alpha(opacity=30)"; -ms-filter: "alpha(opacity=30)"; 
}

.mCS-rounded-dots.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
.mCS-rounded-dots-dark.mCSB_scrollTools_horizontal .mCSB_draggerRail{
    height: 4px;
    margin: 6px 0;
    background-repeat: repeat-x;
}

.mCS-rounded-dots.mCSB_scrollTools .mCSB_buttonUp{ background-position: -16px -72px; }

.mCS-rounded-dots.mCSB_scrollTools .mCSB_buttonDown{ background-position: -16px -92px; }

.mCS-rounded-dots.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -20px -112px; }

.mCS-rounded-dots.mCSB_scrollTools .mCSB_buttonRight{ background-position: -20px -128px; }


/* theme "rounded-dots-dark" */

.mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_draggerRail{
    background-image: url("data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAgAAAAICAYAAADED76LAAAALElEQVQYV2NkIAAYSVFgDFR8BqrBBEifBbGRTfiPZhpYjiQFBK3A6l6CvgAAE9kGCd1mvgEAAAAASUVORK5CYII=");
}

.mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_buttonUp{ background-position: -96px -72px; }

.mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_buttonDown{ background-position: -96px -92px; }

.mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -100px -112px; }

.mCS-rounded-dots-dark.mCSB_scrollTools .mCSB_buttonRight{ background-position: -100px -128px; }

/* ---------------------------------------- */



/* theme "3d", "3d-dark", "3d-thick", "3d-thick-dark" */

.mCS-3d.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-3d-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-3d-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
    background-repeat: repeat-y;
    background-image: -moz-linear-gradient(left, rgba(255,255,255,0.5) 0%, rgba(255,255,255,0) 100%);
    background-image: -webkit-gradient(linear, left top, right top, color-stop(0%,rgba(255,255,255,0.5)), color-stop(100%,rgba(255,255,255,0)));
    background-image: -webkit-linear-gradient(left, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
    background-image: -o-linear-gradient(left, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
    background-image: -ms-linear-gradient(left, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
    background-image: linear-gradient(to right, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
}

.mCS-3d.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-3d-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-3d-thick.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-3d-thick-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
    background-repeat: repeat-x;
    background-image: -moz-linear-gradient(top, rgba(255,255,255,0.5) 0%, rgba(255,255,255,0) 100%);
    background-image: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0.5)), color-stop(100%,rgba(255,255,255,0)));
    background-image: -webkit-linear-gradient(top, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
    background-image: -o-linear-gradient(top, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
    background-image: -ms-linear-gradient(top, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
    background-image: linear-gradient(to bottom, rgba(255,255,255,0.5) 0%,rgba(255,255,255,0) 100%);
}


/* theme "3d", "3d-dark" */

.mCS-3d.mCSB_scrollTools_vertical .mCSB_dragger, 
.mCS-3d-dark.mCSB_scrollTools_vertical .mCSB_dragger{ height: 70px; }

.mCS-3d.mCSB_scrollTools_horizontal .mCSB_dragger, 
.mCS-3d-dark.mCSB_scrollTools_horizontal .mCSB_dragger{ width: 70px; }

.mCS-3d.mCSB_scrollTools, 
.mCS-3d-dark.mCSB_scrollTools{
    opacity: 1;
    filter: "alpha(opacity=30)"; -ms-filter: "alpha(opacity=30)"; 
}

.mCS-3d.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-3d.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-3d-dark.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-3d-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ -webkit-border-radius: 16px; -moz-border-radius: 16px; border-radius: 16px; }

.mCS-3d.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-3d-dark.mCSB_scrollTools .mCSB_draggerRail{
    width: 8px;
    background-color: #000; background-color: rgba(0,0,0,0.2);
    box-shadow: inset 1px 0 1px rgba(0,0,0,0.5), inset -1px 0 1px rgba(255,255,255,0.2);
}

.mCS-3d.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,    
.mCS-3d.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, 
.mCS-3d.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-3d.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar, 
.mCS-3d-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-3d-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, 
.mCS-3d-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-3d-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #555; }

.mCS-3d.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-3d-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ width: 8px; }

.mCS-3d.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
.mCS-3d-dark.mCSB_scrollTools_horizontal .mCSB_draggerRail{
    width: 100%;
    height: 8px;
    margin: 4px 0;
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.5), inset 0 -1px 1px rgba(255,255,255,0.2);
}

.mCS-3d.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-3d-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
    width: 100%;
    height: 8px;
    margin: 4px auto;
}

.mCS-3d.mCSB_scrollTools .mCSB_buttonUp{ background-position: -32px -72px; }

.mCS-3d.mCSB_scrollTools .mCSB_buttonDown{ background-position: -32px -92px; }

.mCS-3d.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -40px -112px; }

.mCS-3d.mCSB_scrollTools .mCSB_buttonRight{ background-position: -40px -128px; }


/* theme "3d-dark" */

.mCS-3d-dark.mCSB_scrollTools .mCSB_draggerRail{
    background-color: #000; background-color: rgba(0,0,0,0.1);
    box-shadow: inset 1px 0 1px rgba(0,0,0,0.1);
}

.mCS-3d-dark.mCSB_scrollTools_horizontal .mCSB_draggerRail{ box-shadow: inset 0 1px 1px rgba(0,0,0,0.1); }

.mCS-3d-dark.mCSB_scrollTools .mCSB_buttonUp{ background-position: -112px -72px; }

.mCS-3d-dark.mCSB_scrollTools .mCSB_buttonDown{ background-position: -112px -92px; }

.mCS-3d-dark.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -120px -112px; }

.mCS-3d-dark.mCSB_scrollTools .mCSB_buttonRight{    background-position: -120px -128px; }

/* ---------------------------------------- */



/* theme: "3d-thick", "3d-thick-dark" */

.mCS-3d-thick.mCSB_scrollTools, 
.mCS-3d-thick-dark.mCSB_scrollTools{
    opacity: 1;
    filter: "alpha(opacity=30)"; -ms-filter: "alpha(opacity=30)"; 
}

.mCS-3d-thick.mCSB_scrollTools, 
.mCS-3d-thick-dark.mCSB_scrollTools, 
.mCS-3d-thick.mCSB_scrollTools .mCSB_draggerContainer, 
.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_draggerContainer{ -webkit-border-radius: 7px; -moz-border-radius: 7px; border-radius: 7px; }

.mCS-3d-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ -webkit-border-radius: 5px; -moz-border-radius: 5px; border-radius: 5px; }

.mCSB_inside + .mCS-3d-thick.mCSB_scrollTools_vertical, 
.mCSB_inside + .mCS-3d-thick-dark.mCSB_scrollTools_vertical{ right: 1px; }

.mCS-3d-thick.mCSB_scrollTools_vertical, 
.mCS-3d-thick-dark.mCSB_scrollTools_vertical{ box-shadow: inset 1px 0 1px rgba(0,0,0,0.1), inset 0 0 14px rgba(0,0,0,0.5); }

.mCS-3d-thick.mCSB_scrollTools_horizontal, 
.mCS-3d-thick-dark.mCSB_scrollTools_horizontal{
    bottom: 1px;
    box-shadow: inset 0 1px 1px rgba(0,0,0,0.1), inset 0 0 14px rgba(0,0,0,0.5);
}

.mCS-3d-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
    box-shadow: inset 1px 0 0 rgba(255,255,255,0.4);
    width: 12px;
    margin: 2px;
    position: absolute;
    height: auto;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}

.mCS-3d-thick.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-3d-thick-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{ box-shadow: inset 0 1px 0 rgba(255,255,255,0.4); }

.mCS-3d-thick.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,  
.mCS-3d-thick.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, 
.mCS-3d-thick.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-3d-thick.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #555; }

.mCS-3d-thick.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-3d-thick-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
    height: 12px;
    width: auto;
}

.mCS-3d-thick.mCSB_scrollTools .mCSB_draggerContainer{
    background-color: #000; background-color: rgba(0,0,0,0.05);
    box-shadow: inset 1px 1px 16px rgba(0,0,0,0.1);
}

.mCS-3d-thick.mCSB_scrollTools .mCSB_draggerRail{ background-color: transparent; }

.mCS-3d-thick.mCSB_scrollTools .mCSB_buttonUp{ background-position: -32px -72px; }

.mCS-3d-thick.mCSB_scrollTools .mCSB_buttonDown{ background-position: -32px -92px; }

.mCS-3d-thick.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -40px -112px; }

.mCS-3d-thick.mCSB_scrollTools .mCSB_buttonRight{   background-position: -40px -128px; }


/* theme: "3d-thick-dark" */

.mCS-3d-thick-dark.mCSB_scrollTools{ box-shadow: inset 0 0 14px rgba(0,0,0,0.2); }

.mCS-3d-thick-dark.mCSB_scrollTools_horizontal{ box-shadow: inset 0 1px 1px rgba(0,0,0,0.1), inset 0 0 14px rgba(0,0,0,0.2); }

.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ box-shadow: inset 1px 0 0 rgba(255,255,255,0.4), inset -1px 0 0 rgba(0,0,0,0.2); }
 
.mCS-3d-thick-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{ box-shadow: inset 0 1px 0 rgba(255,255,255,0.4), inset 0 -1px 0 rgba(0,0,0,0.2); }

.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar,  
.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, 
.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #777; }

.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_draggerContainer{
    background-color: #fff; background-color: rgba(0,0,0,0.05);
    box-shadow: inset 1px 1px 16px rgba(0,0,0,0.1);
}

.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_draggerRail{ background-color: transparent; }

.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_buttonUp{ background-position: -112px -72px; }

.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_buttonDown{ background-position: -112px -92px; }

.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -120px -112px; }

.mCS-3d-thick-dark.mCSB_scrollTools .mCSB_buttonRight{  background-position: -120px -128px; }

/* ---------------------------------------- */



/* theme: "minimal", "minimal-dark" */

.mCSB_outside + .mCS-minimal.mCSB_scrollTools_vertical, 
.mCSB_outside + .mCS-minimal-dark.mCSB_scrollTools_vertical{
    right: 0; 
    margin: 12px 0; 
}

.mCustomScrollBox.mCS-minimal + .mCSB_scrollTools.mCSB_scrollTools_horizontal, 
.mCustomScrollBox.mCS-minimal + .mCSB_scrollTools + .mCSB_scrollTools.mCSB_scrollTools_horizontal, 
.mCustomScrollBox.mCS-minimal-dark + .mCSB_scrollTools.mCSB_scrollTools_horizontal, 
.mCustomScrollBox.mCS-minimal-dark + .mCSB_scrollTools + .mCSB_scrollTools.mCSB_scrollTools_horizontal{
    bottom: 0; 
    margin: 0 12px; 
}

/* RTL direction/left-side scrollbar */
.mCS-dir-rtl > .mCSB_outside + .mCS-minimal.mCSB_scrollTools_vertical, 
.mCS-dir-rtl > .mCSB_outside + .mCS-minimal-dark.mCSB_scrollTools_vertical{
    left: 0; 
    right: auto;
}

.mCS-minimal.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-minimal-dark.mCSB_scrollTools .mCSB_draggerRail{ background-color: transparent; }

.mCS-minimal.mCSB_scrollTools_vertical .mCSB_dragger, 
.mCS-minimal-dark.mCSB_scrollTools_vertical .mCSB_dragger{ height: 50px; }

.mCS-minimal.mCSB_scrollTools_horizontal .mCSB_dragger, 
.mCS-minimal-dark.mCSB_scrollTools_horizontal .mCSB_dragger{ width: 50px; }

.mCS-minimal.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
    background-color: #fff; background-color: rgba(255,255,255,0.2);
    filter: "alpha(opacity=20)"; -ms-filter: "alpha(opacity=20)"; 
}

.mCS-minimal.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-minimal.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{
    background-color: #fff; background-color: rgba(255,255,255,0.5);
    filter: "alpha(opacity=50)"; -ms-filter: "alpha(opacity=50)"; 
}


/* theme: "minimal-dark" */

.mCS-minimal-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{
    background-color: #000; background-color: rgba(0,0,0,0.2);
    filter: "alpha(opacity=20)"; -ms-filter: "alpha(opacity=20)"; 
}

.mCS-minimal-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-minimal-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{
    background-color: #000; background-color: rgba(0,0,0,0.5);
    filter: "alpha(opacity=50)"; -ms-filter: "alpha(opacity=50)"; 
}

/* ---------------------------------------- */



/* theme "light-3", "dark-3" */

.mCS-light-3.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-dark-3.mCSB_scrollTools .mCSB_draggerRail{
    width: 6px;
    background-color: #000; background-color: rgba(0,0,0,0.2);
}

.mCS-light-3.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-dark-3.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ width: 6px; }

.mCS-light-3.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-dark-3.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-light-3.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
.mCS-dark-3.mCSB_scrollTools_horizontal .mCSB_draggerRail{
    width: 100%;
    height: 6px;
    margin: 5px 0;
}

.mCS-light-3.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
.mCS-light-3.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail, 
.mCS-dark-3.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
.mCS-dark-3.mCSB_scrollTools_vertical.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail{
    width: 12px;
}

.mCS-light-3.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
.mCS-light-3.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail, 
.mCS-dark-3.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_dragger.mCSB_dragger_onDrag_expanded + .mCSB_draggerRail, 
.mCS-dark-3.mCSB_scrollTools_horizontal.mCSB_scrollTools_onDrag_expand .mCSB_draggerContainer:hover .mCSB_draggerRail{
    height: 12px;
    margin: 2px 0;
}

.mCS-light-3.mCSB_scrollTools .mCSB_buttonUp{ background-position: -32px -72px; }

.mCS-light-3.mCSB_scrollTools .mCSB_buttonDown{ background-position: -32px -92px; }

.mCS-light-3.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -40px -112px; }

.mCS-light-3.mCSB_scrollTools .mCSB_buttonRight{ background-position: -40px -128px; }


/* theme "dark-3" */

.mCS-dark-3.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.75); }

.mCS-dark-3.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.85); }

.mCS-dark-3.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-dark-3.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.9); }

.mCS-dark-3.mCSB_scrollTools .mCSB_draggerRail{ background-color: #000; background-color: rgba(0,0,0,0.1); }

.mCS-dark-3.mCSB_scrollTools .mCSB_buttonUp{ background-position: -112px -72px; }

.mCS-dark-3.mCSB_scrollTools .mCSB_buttonDown{ background-position: -112px -92px; }

.mCS-dark-3.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -120px -112px; }

.mCS-dark-3.mCSB_scrollTools .mCSB_buttonRight{ background-position: -120px -128px; }

/* ---------------------------------------- */



/* theme "inset", "inset-dark", "inset-2", "inset-2-dark", "inset-3", "inset-3-dark" */

.mCS-inset.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-inset-dark.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-inset-2.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-inset-2-dark.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-inset-3.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-inset-3-dark.mCSB_scrollTools .mCSB_draggerRail{
    width: 12px;
    background-color: #000; background-color: rgba(0,0,0,0.2);
}

.mCS-inset.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-inset-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-inset-2.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-inset-2-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-inset-3.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ 
    width: 6px;
    margin: 3px 5px;
    position: absolute;
    height: auto;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}

.mCS-inset.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-inset-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-inset-2.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-inset-2-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-inset-3.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar, 
.mCS-inset-3-dark.mCSB_scrollTools_horizontal .mCSB_dragger .mCSB_dragger_bar{
    height: 6px;
    margin: 5px 3px;
    position: absolute;
    width: auto;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
}

.mCS-inset.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
.mCS-inset-dark.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
.mCS-inset-2.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
.mCS-inset-2-dark.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
.mCS-inset-3.mCSB_scrollTools_horizontal .mCSB_draggerRail, 
.mCS-inset-3-dark.mCSB_scrollTools_horizontal .mCSB_draggerRail{
    width: 100%;
    height: 12px;
    margin: 2px 0;
}

.mCS-inset.mCSB_scrollTools .mCSB_buttonUp, 
.mCS-inset-2.mCSB_scrollTools .mCSB_buttonUp, 
.mCS-inset-3.mCSB_scrollTools .mCSB_buttonUp{ background-position: -32px -72px; }

.mCS-inset.mCSB_scrollTools .mCSB_buttonDown, 
.mCS-inset-2.mCSB_scrollTools .mCSB_buttonDown, 
.mCS-inset-3.mCSB_scrollTools .mCSB_buttonDown{ background-position: -32px -92px; }

.mCS-inset.mCSB_scrollTools .mCSB_buttonLeft, 
.mCS-inset-2.mCSB_scrollTools .mCSB_buttonLeft, 
.mCS-inset-3.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -40px -112px; }

.mCS-inset.mCSB_scrollTools .mCSB_buttonRight, 
.mCS-inset-2.mCSB_scrollTools .mCSB_buttonRight, 
.mCS-inset-3.mCSB_scrollTools .mCSB_buttonRight{ background-position: -40px -128px; }


/* theme "inset-dark", "inset-2-dark", "inset-3-dark" */

.mCS-inset-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-inset-2-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar, 
.mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.75); }

.mCS-inset-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, 
.mCS-inset-2-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar, 
.mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.85); }

.mCS-inset-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-inset-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar, 
.mCS-inset-2-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-inset-2-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar, 
.mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.9); }

.mCS-inset-dark.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-inset-2-dark.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-inset-3-dark.mCSB_scrollTools .mCSB_draggerRail{ background-color: #000; background-color: rgba(0,0,0,0.1); }

.mCS-inset-dark.mCSB_scrollTools .mCSB_buttonUp, 
.mCS-inset-2-dark.mCSB_scrollTools .mCSB_buttonUp, 
.mCS-inset-3-dark.mCSB_scrollTools .mCSB_buttonUp{ background-position: -112px -72px; }

.mCS-inset-dark.mCSB_scrollTools .mCSB_buttonDown, 
.mCS-inset-2-dark.mCSB_scrollTools .mCSB_buttonDown, 
.mCS-inset-3-dark.mCSB_scrollTools .mCSB_buttonDown{ background-position: -112px -92px; }

.mCS-inset-dark.mCSB_scrollTools .mCSB_buttonLeft, 
.mCS-inset-2-dark.mCSB_scrollTools .mCSB_buttonLeft, 
.mCS-inset-3-dark.mCSB_scrollTools .mCSB_buttonLeft{ background-position: -120px -112px; }

.mCS-inset-dark.mCSB_scrollTools .mCSB_buttonRight, 
.mCS-inset-2-dark.mCSB_scrollTools .mCSB_buttonRight, 
.mCS-inset-3-dark.mCSB_scrollTools .mCSB_buttonRight{   background-position: -120px -128px; }


/* theme "inset-2", "inset-2-dark" */

.mCS-inset-2.mCSB_scrollTools .mCSB_draggerRail, 
.mCS-inset-2-dark.mCSB_scrollTools .mCSB_draggerRail{
    background-color: transparent;
    border-width: 1px;
    border-style: solid;
    border-color: #fff;
    border-color: rgba(255,255,255,0.2);
    -webkit-box-sizing: border-box; -moz-box-sizing: border-box; box-sizing: border-box;
}

.mCS-inset-2-dark.mCSB_scrollTools .mCSB_draggerRail{ border-color: #000; border-color: rgba(0,0,0,0.2); }


/* theme "inset-3", "inset-3-dark" */

.mCS-inset-3.mCSB_scrollTools .mCSB_draggerRail{ background-color: #fff; background-color: rgba(255,255,255,0.6); }

.mCS-inset-3-dark.mCSB_scrollTools .mCSB_draggerRail{ background-color: #000; background-color: rgba(0,0,0,0.6); }

.mCS-inset-3.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.75); }

.mCS-inset-3.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.85); }

.mCS-inset-3.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-inset-3.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #000; background-color: rgba(0,0,0,0.9); }

.mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar{ background-color: #fff; background-color: rgba(255,255,255,0.75); }

.mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger:hover .mCSB_dragger_bar{ background-color: #fff; background-color: rgba(255,255,255,0.85); }

.mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger:active .mCSB_dragger_bar,
.mCS-inset-3-dark.mCSB_scrollTools .mCSB_dragger.mCSB_dragger_onDrag .mCSB_dragger_bar{ background-color: #fff; background-color: rgba(255,255,255,0.9); }

/* ---------------------------------------- */

.clearfix{
clear:both;
}
.row.masonry {
clear: both;
}   
.note-nia{
color: #6c6c6c !important;
font-weight: 600;
font-size: 10pt;padding-top: 10px;padding-bottom: 10px;

}
/*.investname span,.angelinvestname span{
margin-left: -3px;
}*/
/*.row.masonry
{
    -webkit-column-count: 2;
-moz-column-count: 2;
column-count: 2;
margin-top: -10px;    column-gap: 15px;
}*/
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
/*.redirection-icon{
    margin-left: 15px;
}*/
.m-15{
    margin-top: 15px;
}
    
.download-icon{
    background: url('images/sprites-icons.png') no-repeat -24px -17px;
    width: 19px;
    height: 21px;
    display:inline-block;
    vertical-align: middle;
    padding-right: 5px;
 }
 .title-links a{
    background-color: #a27539  !important;
}
.title-links a.export{
       font-weight: 700 !important;
    margin-top: 0px !important;
}
.list-tab li a i{
    background: url('images/sprites-icons.png') no-repeat !important;
    width: 22px !important;
    height: 22px !important;
}
#icon_grid-view i{
    background-position: -23px -147px !important;
    margin-right: 5px;
}
#icon_grid-view i:hover{
    background-position: -23px -105px !important;
    margin-right: 5px;
}
.active #icon_detailed-view i, #icon_detailed-view:hover i {
    background-position: -73px -105px !important;
}
#previous,#next{
     display: inline-block;
}
#previous .previous-icon{
     background: url('images/sprites-icons.png') no-repeat ;
     width: 24px !important;
     height: 22px !important;
     display: inline-block;
}
.previous-icon{
    background-position: -23px -230px !important;
}
.previous-icon:hover{
    background-position: -22px -189px !important;
}
#next .next-icon{
     background: url('images/sprites-icons.png') no-repeat ;
     width: 24px !important;
     height: 22px !important;
     display: inline-block;
}
.next-icon{
    background-position: -73px -230px !important;
}
.next-icon:hover{
    background-position: -73px -189px !important;
}
.inner-section  .action-links{
    margin-top:1px !important;
}


.accordions_dealtitle,.matrans {
    width: 100%;
    display: grid;
    grid-template-columns: 50px 1fr ;
    /*background-color:#c9c4b7;*/
    background-color: #e0d8c3;
    cursor: pointer;
  /*  transition: 0.8s linear;*/
    border: 1px solid #a28669;
    margin-top: 2px;
    box-sizing: border-box;
}
.box_heading.content-box {
    background: #e0d8c3 !important;
}
.accordions_dealtitle h2,.matrans h2 {
  font-size: 24px;
  font-weight: 400 !important;
  color: #1D1D29;
 /* transition: 0.8s linear;*/
  margin-bottom: 0;
  margin-top: 0;
  font-size: 24px;
  font-weight: 700;
}
.accordions_dealtitle span,.matrans span {
  align-self: center;
  display: block;
  padding-left: 15px;
}

.accordions_dealtitle span:after,.matrans span:after {
    content: " ";
    background: url(images/sprites-icons.png) no-repeat -22px -59px;
    /*width: 28px;
    height: 28px;*/
    width: 24px;
    height: 24px;
    display: block;
    /*background-position: -5px -5px;*/
    margin-right: 5px;
    border-radius: 50px;
}



.accordions_dealtitle.active span:after,.matrans.active span:after {
    background: url(images/sprites-icons.png) no-repeat -72px -59px;
    /*width: 28px;
    height: 28px;*/
    width: 24px;
    height: 24px;
    display: block;
    /*background-position: -5px -5px;*/
    margin-right: 5px;
    border-radius: 50px;
}
.bor-top-cnt{
    border-top: 1px solid #e4e4e4;
    clear: both;
    padding-top: 10px !important;
}
.mar-top {
margin: 0px 15px 10px !important;
}
.accordions{
position: relative;
}
.accordions_dealcontent {
  color:#000;
 /* transition: 0.8s linear;*/
  box-shadow: 0px 3px #e3e4e4;
  border: 1px solid #afb0b3;
  border-top: 1px solid transparent;
  width: 100%;
  /*padding: 10px 20px;*/
  padding: 0px 20px;
  padding-top:  8px ;
  padding-bottom: 7px;
  box-sizing: border-box;
  border-top: none;
}
.dealinfocontent{
    padding-bottom: 6px !important;
}
/*.linkedindiv {
    color: #000;
    box-shadow: 0px 3px #e3e4e4;
    border: 1px solid #afb0b3;
    width: 100%;
    padding: 20px;
    box-sizing: border-box;
    margin-top: 20px;
}*/
.accordions_dealcontent p {
  color: #666666;
  margin:0px !important;
  
}
.accordions_dealcontent ul {
  color: #000;
}
.accordions_dealtitle h2,.matrans h2{
    /*padding: 15px 0px !important;*/
    padding: 10px 0px !important;
    margin: 0;
    color: #333333 !important;
    font-weight: bold;
    text-transform: uppercase;
    /*font-size: 22px !important;*/
    font-size: 19px !important;
    background: #fff;
}
.accordions_dealcontent .work-masonry-thumb
{
    width: 100% !important;
}
.accordions_dealtitle ul.tabs,.matrans ul.tabs{
    border-bottom:none !important;
}
#company_info ,#deal_info{
    background-color: #f4f4f4 !important;
}
.companyinfo h2,.dealinfo h2{
    /*padding: 15px 0px !important;*/
    padding: 10px 0px !important;
    /*font-size: 22px !important;*/
    font-size: 19px !important;
    border-bottom: 1px solid transparent !important;
    color: #333 !important;
}
.companyinfo h4,.dealinfo h4{
    font-size: 10pt !important;
    font-weight: 600 !important;
    color: #000 !important;
}
.companyinfo p,.dealinfo p{
    font-size: 10pt !important;
    font-weight: 600 !important;
    color: #666 !important;
}
/*.companyinfo_table{
    padding-left: 10px !important;
    padding-right: 10px !important;
    padding-bottom: 25px !important;
}
.dealinfo_table{
    padding-left: 25px !important;
    padding-right: 20px !important;
    padding-top: 20px !important;
}*/
.
.dealinfo{
    margin-left: 15px !important;
    margin-right: 15px !important;
}
.tooltip-1.round p{
       white-space: nowrap;
       width: 100%;
       overflow: hidden;
       text-overflow: ellipsis;

}


.mCS-dark-3.mCSB_scrollTools .mCSB_dragger .mCSB_dragger_bar {
    width: 3px !important;
}
.mCS-dark-3.mCSB_scrollTools .mCSB_draggerRail {
    width: 3px !important;
    }
.moreinfo_1,.moreinfo_1 td
{
    background-color: transparent !important;
}
.moreinfo_1{
    height: 195px;
}
.result-title {
    margin-left:-18px;
}
.result-select{
    border:none !important;
    padding: 12px 6px 0px 20px !important;

}
.result-title li{
    background:transparent !important;
    border: 1px solid #ccc;
}
.result-title li a{
    border-left:1px solid transparent !important;
}
.title-links{
        margin-top: 10px;
}
input.senddeal:hover, input.senddeal:focus, input.senddeal:active {
    background: #fff url(images/deal-icon.png) no-repeat 10px 5px !important;
}
input.senddeal{
    padding: 4px 10px 4px 35px !important;
    background: #fff url(images/deal-icon.png) no-repeat 10px 5px !important;
    text-transform: uppercase !important;
    font-weight: 700;
    font-size: 12px !important;
    border: 1px solid #e2e2e2 !important;
}

.detail-view-header i {
    margin-right: 0px;
}
.detail-view-header,.detail-view-header .inner-section,.list-tab ul,.list-tab li.active a{
    background:#fff !important;
}

.detail-view-header h2 a{
    float:left;
}
/*view icon adjusted inline style*/
.inner-section-width1{
    
    margin-right: 0px !important;
    margin-top: 0px !important;
}
/*.inner-list{
    border-right:1px solid #ccc;
    padding-right: 10px;
}*/
.inner-list{
   
    padding-right: 10px;
     margin-top: 2px;
}
.redirection-icon{
    padding-left: 15px;
    background: #fff !important;
    padding-top: 2px;
    padding-bottom: 0px;
margin-top: -25px !important;
}
.list-tab li a{
    padding: 1px 2px !important;
}
.inner-list_width1{
  /* margin-top: 2px;*/
}
.inner-list_width1 img{
   margin-right: 0px !important;
}
.action-links img{
    margin-top: 0px !important;
    margin-right: 2px !important;
}

.companyinfo td:nth-child(2){
     border-right: 1px solid transparent !important; 
     width: 65% !important;
     position: relative;
}
.dealinfo td:nth-child(2){
     border-right: 1px solid transparent !important; 
     width: 50% !important;
}
.companyinfo td:first-child{
    width: 35% !important;
}
.dealinfo td:first-child{
    width: 50% !important;
}
.companyinfo tbody{
    display: block !important;
   /* width: 92% !important;
    padding:10px 21px;  */
}
/*.dealinfo table {
    display: block !important;
    width: 85% !important;
    padding:10px 21px;
}*/
.companyinfo h2,.dealinfo h2{
    border-radius: 0px !important;
}
.row.section1{
    width: 100%;
   /* background-color: #f4f4f4;*/
   background-color: #fff;
    margin-left: -18px;
    margin-right: -18px;
    padding-left: 18px;
    padding-right: 18px;
    padding-top: 18px;
    padding-bottom: 10px;
}
.companyinfo td,.dealinfo td{
    padding: 5px 2px !important;
}
.dealinfo_table,.companyinfo_table{
    border:none !important;
    width:100% !important;
}
.dealinfo_table tr{
    margin:0px !important;
}
.moreinfo{
    color:#333 !important;
    /*font-size:22px !important;*/
    font-size:19px !important;
    padding: 12px 13px !important;
    font-weight: 500;
}
span.investorlable{
    padding: 2px 5px;
    background-color: #c9c4b7;
    color: #fff;
}
.accordian-group {
    background: #fff !important;
    border:none !important;
    margin-bottom: 15px !important;
}
.tagelements {
    float: left;
    padding: 12px 0px;
    padding-right: 12px;
    margin-bottom: 0px;
    width: 25%;
    box-sizing: border-box;
}
.advisor_innerTable tr td{
    width: 100% !important;
}
.advisor_innerTable{
    border-collapse: collapse;
    border-left: 1px solid #ccc !important;
    border-right: none !important;
    border-top: none !important;
    border-bottom: none !important;
}
#advisor_info .tablelistview4 td:last-child{
    padding: 0px;
}
.advisor_innerTable tr:last-child{
    border-bottom: none;
}
.advisor_innerTable td{
    padding: 5px 5px 5px 5px !important;
}
.advisor_innerTable td p{
    padding: 4px 0px 4px 0px !important;
}
.accordions_dealcontent .col-md-6 h2 {
    padding: 8px 0px;
}
.tableInvest th{
    font-size: 10pt;
    padding: 8px 0px !important;
}
.tableview td, .work-masonry-thumb1 .tableview th {
    text-align: left;
    padding: 10px 0px !important;
    padding-right: 15px !important;
}
.tableInvest td, .tableInvest td a{
    font-size: 10pt;
    color: #666 !important;
    font-weight: 600;
}
.advisor_Table td{
    padding: 0px !important;
}
.advisor_innerTable td {
    padding: 5px 5px 5px 5px !important;
}
.advisor_Table .advisor_innerTable{
    border-left: none !important;
}
.advisor_Table .advisor_innerTable tr td:first-child{
    width: 20% !important;vertical-align: middle;
}
.tableInvest tbody td:first-child, .tableInvest tbody td:first-child a {
    color: #000 !important;
    font-weight: 600;
    text-decoration: none;
    font-size: 10pt;
}
td.investname {
    width: 45%;
}
.tableValuation td{
    padding: 10px 0px;
}
.tableValuation .tableValuationwidth td{
    width: 25% !important;
}

.tagelements a {
    color: #7b5e40;
    font-weight: bold;
    display: block;
    font-size: 14px;
    text-decoration: underline;
}
.batchtag{
    padding: 6px 12px;
    background-color: #a27539;
    color: #fff;
    border-radius: 6px;
    display: inline-block;
}
/*.tagelements a:hover{
    color: #fff;
}*/
.accordian-group table {
    background: #fff;
    padding: 0px !important;
    width: 100%;
    box-sizing: border-box;
    border-top: none;
}
.accordian-group tr {
    border-bottom: 1px solid #ccc;
    clear: both;
    margin: 0px;
    width: 100%;
}
.accordian-group tr:last-child{
    border-bottom: none;
}

.accordian-group td{
height: auto;
}
.accordian-group tbody td {
    border-bottom: 1px solid #e6e5e5 !important;
}
.accordian-group tbody td:last-child{
    border-bottom: none;
}
.accordian-group .innertable td{
    border-bottom: none !important;
    padding: 6px 0px;
    width: 50%;
}
.accordian-group tbody tr:last-child td{
    border-bottom: none !important;
}

/**/


.com-address-cnt {
     border-bottom: none !important; 
}
.col-6{
    width: 50%;
    float: left;
}
td.investname span:last-child {
    display: none;
}
td.angelinvestname span:last-child {
    display: none;
}
#deal_info table, #company_info table{
    float: none !important;
        padding: 0px 10px 0px 10px !important;
}
.section1 .work-masonry-thumb1 {
    margin-right: 15px;    height: 252px;
}

.linkpecfs{
    float: right;
    font-size: 10pt !important;
    font-weight: 600 !important;
    color: #000 !important;
    text-decoration: underline;
    margin-right: 15px !important;
    /*margin-top: 6px;*/
   
    position: absolute;
    top: 16px;
    right: 57px;
}
.text-center{
    text-align: center;
}
.tablefin td {
    width: 50%;
}
.inner-section .tooltip-box, .postlink .tooltip-box, .tooltip-box1, .tooltip-box2, .tooltip-box3, .tooltip-box4, .tooltip-box5, .tooltip-box6{
    text-transform: unset !important;
    width: 96%;
word-break: break-all;
}

.col-md-6 {
    /*width: 50%;*/
    width: 75%;
    float: left;
    padding-right: 15px;
    box-sizing: border-box;
}
/*.advisor_Table .advisor_innerTable tr:first-child td p {
    padding-top: 0px !important;
}*/
.topmanagement div {
color: #4e4e4e !important;
font-size: 12px !important;
font-weight: 500 !important;
padding: 4px 0px 2px 0px;
}
.companyinfo .mCSB_inside>.mCSB_container{
margin-right: 15px !important;
}
.companyinfo .mCSB_container.mCS_no_scrollbar_y.mCS_y_hidden{
margin-right: 0px !important;
}

.companyinfo .mCSB_scrollTools{
   right: -6px !important;
}
.dealinfo .mCSB_inside>.mCSB_container{
margin-right: 15px !important;
}
.dealinfo .mCSB_container.mCS_no_scrollbar_y.mCS_y_hidden{
margin-right: 0px !important;
}
.dealinfo .mCSB_scrollTools{
   right: -6px !important;
}
/*#deal_info table, #valuation_info table, #financials_info table, #investor_info table, #company_info table, #advisor_info table {
padding: 0px !important;
width: 100%;
border-top: none;
box-sizing: border-box;
}*/
#valuation_info table, #financials_info table, #investor_info table,  #advisor_info table {
padding: 0px !important;
width: 100%;
border-top: none;
box-sizing: border-box;
}
#deal_info tbody, #valuation_info tbody, #financials_info tbody , #investor_info tbody,  #advisor_info tbody {
display: block !important;
width: 100% !important;
}
#deal_info td, #valuation_info td, #financials_info td, #investor_info td, #company_info td, #advisor_info td {
width: 25%;
display: inline-block;
float: left;
height: auto;
}
#deal_info td:nth-child(1), #deal_info td:nth-child(3), #valuation_info td:first-child, #financials_info td:first-child, #investor_info td:first-child, #company_info td:first-child, #company_info td:nth-child(3), #advisor_info td:first-child {
padding-left: 15px;
} 
#deal_info td:nth-child(1) {
width: 26%;
}
#deal_info td:nth-child(2) {
width: 24%;
}
#deal_info td:nth-child(3) {
width: 27%;
}
#deal_info td:last-child {
width: 23%;
}
.box_heading.content-box {
border-radius: 5px 5px 0 0;
}
#financials_info td, #advisor_info td {
width: 50%;
}
#financials_info td:first-child {
width: 59%;
}
#financials_info td {
width: 41%;
}
#investor_info td:first-child {
width: 50%;
}
#investor_info td:first-child {
width: 52%;
}
#investor_info td {
width: 24%;
}
#company_info td:first-child {
width: 13%;
}
#company_info td:nth-child(3) {
width: 15%;
}
#company_info td:nth-child(4) {
width: 34%;
}
#company_info td:nth-child(2) {
width: 38%;
}
#company_info td:first-child {
width: 13%;
}
#investor_info tr, #company_info tr {
margin: 0px;
}
#deal_info tr, #valuation_info tr, #financials_info tr, #investor_info tr, #company_info tr , #advisor_info tr {
border-bottom: 1px solid #ccc;
/* overflow: hidden; */
clear: both;
width: 100%;
float: left;
}
#deal_info tr:last-child, #valuation_info tr:last-child, #financials_info tr:last-child, #investor_info tr:last-child, #company_info tr:last-child , #advisor_info tr:last-child {
border-bottom: none;
}
#valuation_info td:first-child {
width: 33%;
}
#valuation_info td {
width: 20%;
}
#valuation_info td:nth-child(2), #valuation_info td:nth-child(3), #valuation_info td:nth-child(4) {
width: 22%;
}
#valuation_info td.last-child {
width: 60%;
}
#advisor_info td:first-child {
width: 39%;
}
#advisor_info td:last-child {
width: 61%;
}
.tablelistview table tbody, .tablelistview tr  {
width: 100% !important;
display: block !important;
}
.com-wrapper header {
background: #C9C4B7 ;
}
.com-cnt-sec header span {
margin: 5px 5px 0 0 !important;
}
.com-cnt-sec {
background: #fff;
border: 1px solid #ccc;
}
.com-inv-sec {
padding: 0px;
}
.tableview tbody td {
border-bottom: 1px solid #999;
color: #6c6c6c;
}
.tableview tbody td:first-child, .tableview tbody td:first-child a {
color: #BDA074;
}
/*.moreinfo.more-content, .com-cnt-sec header h3, .work-masonry-thumb h2 {
background: #C9C4B7 ;
color: #000 ;
text-transform: capitalize ;
}*/
.com-cnt-sec header h3, .work-masonry-thumb h2 {
background: #C9C4B7 ;
color: #000 ;
text-transform: capitalize ;
}
.list-tab {
overflow: inherit;
}
.tablelistview, .tablelistview2, .tablelistview3, .tablelistview4{
        background: #F2EDE1;
}
.tablelistview h4, .tablelistview2 h4, .tablelistview3 h4, .tablelistview4 h4{
    text-transform: capitalize !important;
    /*padding:1px 0;*/

}
.tablelistview p, .tablelistview2 p, .tablelistview3 p, .tablelistview4 p{
    padding:4px 0px 2px 0px;
 
}
.box_heading{
    background:#BDA074;
    border-radius:4px;
    color: #fff ;
    text-transform: capitalize !important;
}
#deal_info tr:first-child td, #valuation_info tr:first-child td, #financials_info tr:first-child td {
    padding: 2px 5px;
}
/*#financials_info tr:first-child td {
    width: 140px;
}
#financials_info tr td {
    width: 110px;
}*/
#financials_info .financial_label{
    width:110px;
}
#financials_info .financial_label1{
    width:86px;
}
/* #company_info tr:first-child td {
    padding-top: 5px;
}*/
#advisor_info table{
    padding-top: 3px;
    padding-bottom: 7px;
}
/* #investor_info tr:first-child td{
    padding: 6px 5px;
}*/
#deal_info table, #valuation_info table, #financials_info table, #investor_info table, #company_info table, #advisor_info table {
    background: #fff;
}
 #deal_info, #valuation_info , #financials_info , #investor_info , #company_info , #advisor_info   {
    border: none;
 }
.tablelistview tr {

}
.tablelistview td, .tablelistview2 td, .tablelistview3 td, .tablelistview4 td {
    height: 40px;
    box-sizing: border-box;
    background: #fff;
    padding: 5px 5px 5px 5px;
    border-collapse: collapse;
}
#deal_info td:nth-child(2), #company_info td:nth-child(2) {
border-right: 1px solid #ccc;
}
.content-align {
text-align: center;
}
.last-child{
width:67% !important;
}
#valuation_info tr:first-child td, #financials_info tr:first-child td{
color: #000;
}
#deal_info, #valuation_info {
margin-right: 0.8px;
}
.tooltip-box3 a{
color: #fff;
}
.view-detailed {
/*padding: 17px 0;*/
padding: 0px 0;
}

.col-12 .tableInvest .table-width1{
width: 170px;padding-right: 20px !important;    text-align: right;
}
.col-12 .tableInvest .table-width2{
text-align: center;
width: 85px;
}
.col-12 .tableInvest .table-width3{
text-align: right;
width: 140px;
}
.batchwidth{
width: 16%;
}
/*.advisor_Table tr, .advisor_Table tbody td, .advisor_innerTable tr
{
border-bottom: none !important;
}*/
/*.acc_container, .acc_main {
background: #ffffff !important;
}*/
.acc_container, .acc_main {
background: #e0d8c3 !important;
}
/*#allfinancial{
color: #fff !important;
}*/
.linkanchor{
width: 93%;    top: 24px;
}

ul.tabView {
border-bottom: none !important;
width: 100%;
overflow: hidden;
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
.tab-items{
display: none;
}
.activetab{
display: block;
}
ul.tabView li:hover{
color: #fff;
background-color: #c09f74;
}
ul.tabView li.current {
color: #fff;
background-color: #c09f74;
}
.contacttooltip .tooltip-box6{
top: -21px;
}


.linkanchor {
position: absolute;
background: #fff;
color: #4e4e4e !important;
text-transform: capitalize;
font-size: 12px;
padding: 5px;
display: none;
z-index: 1000;
top: 50px;
/* min-width: 364px; */
border: 1px solid;
line-height: 12px;
box-shadow: 5px 4px 5px #969393;
}
.linkanchor {
text-transform: unset !important;
width: 89%;
word-break: break-all;
top: 22px;
}
.newslinktooltip a{
font-size: 10pt !important;
font-weight: 600 !important;
}
.linkanchor a{
display: block;
font-weight: 500 !important;
}
.advisor_Table tbody td{
border-color: #ccc !important;
}

.linkfillings{
float: right;
font-size: 10pt !important;
font-weight: 600 !important;
color: #000 !important;
margin-right: 15px !important;
position: absolute;
top: 16px;
right: 0px;
}
.linkfillings span{
margin-right: 5px;
display: inline-block;
}
.linkfillings a{
color: #000 !important;
text-decoration: underline;
}

</style>
<div id="container" >
<table cellpadding="0" cellspacing="0" width="100%">  
<tr>

<td class="left-td-bg">
  <div class="acc_main">
      <div class="slide" style="z-index:9999; position:relative;"><a href="#" class="btn-slide active">Slide Panel</a></div> 
<div id="panel" style="display:block; overflow:visible; clear:both;">

<?php
if($VCFlagValue==0)
{
       $pageUrl="index.php?value=0";
       $pageTitle="PE Investment";
       $refineUrl="refine.php";
}
elseif($VCFlagValue==1)
{
       $pageTitle="VC Investment";
       $pageUrl="index.php?value=1";
       $refineUrl="refine.php";
}
elseif($VCFlagValue==3)
{
         $pageTitle="Social Venture Investment";
       $pageUrl="svindex.php?value=3";
        $refineUrl="svrefine.php";
}
elseif($VCFlagValue==4)
{
       $pageUrl="CleanTech Investment";
       $pageUrl="svindex.php?value=4";
        $refineUrl="svrefine.php";
}
elseif($VCFlagValue==5)
{
       $pageTitle="Infrastructure Investment";
       $pageUrl="svindex.php?value=5";
        $refineUrl="svrefine.php";
}
include_once($refineUrl); ?>
 <input type="hidden" name="resetfield" value="" id="resetfield"/>
 <input type="hidden" name="resetfieldid" value="" id="resetfieldid"/>
</div>
</div>
</td>

<?php
    $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
    $strvalue = explode("/", $value);
    $SelCompRef=$strvalue[0];
    
    //GET PREV NEXT ID
    $prevNextArr = array();
    $prevNextArr = $_SESSION['resultId'];
            $coscount = $_SESSION['coscount'];
            $totalcount = $_SESSION['totalcount'];

    $currentKey = array_search($SelCompRef,$prevNextArr);
    $prevKey = ($currentKey == 0) ?  '-1' : $currentKey-1; 
    $nextKey = $currentKey+1;
    
    $flagvalue=$strvalue[1];
    $searchstring=$strvalue[2];
   
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
                //$SelCompRef=$value;
        $sql="SELECT pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, pec.industry as industryId, i.industry, pec.sector_business,
     amount, round, s.Stage, stakepercentage, DATE_FORMAT( dates, '%b-%y' ) as dt,pe.dates, pec.website, pec.linkedIn, pec.city,
     pec.region,pe.PEId,comment,MoreInfor,hideamount,hidestake,pec.countryid,pec.CINNo,
    pe.InvestorType, its.InvestorTypeName,pe.StageId,pe.Link,pe.uploadfilename,pe.source,
        pe.Valuation,pe.crossBorder,pe.FinLink,pec.RegionId, pe.AggHide, pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple,pe.listing_status,Exit_Status,
        pe.SPV,pe.Revenue,pe.EBITDA,pe.PAT,pe.Amount_INR, pe.Company_Valuation_pre,pe.Revenue_Multiple_pre,pe.EBITDA_Multiple_pre,pe.PAT_Multiple_pre, 
        pe.Company_Valuation_EV,pe.Revenue_Multiple_EV,pe.EBITDA_Multiple_EV,pe.PAT_Multiple_EV,pe.Total_Debt,pe.Cash_Equ,pe.financial_year,pec.CINNo, pec.Address1, pec.Address2, pec.Telephone,pec.Email,pec.tags,pec.state
     FROM peinvestments AS pe, industry AS i, pecompanies AS pec,
    investortype as its,stage as s
     WHERE pec.industry = i.industryid
     AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15
     and pe.PEId=$SelCompRef and s.StageId=pe.StageId
     and its.InvestorType=pe.InvestorType ";
//echo "<br>********".$sql;

/*$investorSql="select peinv.PEId,peinv.InvestorId,inv.Investor,peinv.Amount_M,peinv.Amount_INR,hide_amount from peinvestments_investors as peinv,
    peinvestors as inv where peinv.PEId=$SelCompRef and inv.InvestorId=peinv.InvestorId ORDER BY Investor='others',InvestorId desc";*/
    $investorSql="select peinv.PEId,peinv.InvestorId,inv.Investor,peinv.Amount_M,peinv.Amount_INR,peinv.InvMoreInfo,peinv.hide_amount,peinv.exclude_dp,peinv.investorOrder,peinv.leadinvestor,peinv.newinvestor,peinv.existinvestor from peinvestments_investors as peinv,peinvestors as inv where peinv.PEId=$SelCompRef and inv.InvestorId=peinv.InvestorId ORDER BY peinv.investorOrder ASC";


//echo "<Br>Investor".$investorSql;

$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,AdvisorType from peinvestments_advisorcompanies as advcomp,
advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
//echo "<Br>".$advcompanysql;

$advinvestorssql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from peinvestments_advisorinvestors as advinv,
advisor_cias as cia where advinv.PEId=$SelCompRef and advinv.CIAId=cia.CIAId";

 $onMgmtSql="select pec.PECompanyId,mgmt.PECompanyId,mgmt.ExecutiveId,
                    exe.ExecutiveName,exe.Designation,exe.Company from
                    pecompanies as pec,executives as exe,pecompanies_management as mgmt,peinvestments AS pe
    where pe.PEId=$SelCompRef and  pec.PEcompanyID = pe.PECompanyID and mgmt.PECompanyId=pec.PECompanyId and exe.ExecutiveId=mgmt.ExecutiveId";



    $global_hideamount=0;
    if ($companyrs = mysql_query($sql))
    {  ?>
                   
        <?php if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
        {
                $industryId = $myrow["industryId"];
                $regionid=$myrow["RegionId"];
                $crossBorder=$myrow["crossBorder"];
                $countryid=$myrow["countryid"];
                $Address1=$myrow["Address1"];
                $Address2=$myrow["Address2"];
                $PECompanyId = $myrow["PECompanyId"];
                $linkedIn=$myrow["linkedIn"];
                $Tel=$myrow["Telephone"];
                $Email=$myrow["Email"];
                $CIN=$myrow["CINNo"];
                if($regionid>0)
                { $regionname=return_insert_get_RegionIdName($regionid); }
                else
                { $regionname=$myrow["region"]; }
            //echo $countryid;
                $countryname=return_insert_get_CountryName($countryid);
                // if($countryid != '')
                // { $countryname=return_insert_get_CountryName($countryid); }
                // else
                // { $countryname=$myrow["countryid"]; }

                if($myrow["SPV"]==1)
                {
                    $openDebtBracket="[";
                    $closeDebtBracket="]";
                }
                else
                {
                    $openDebtBracket="";
                    $closeDebtBracket="";
                
                }
                if($myrow["AggHide"]==1)
                {
                    $openBracket="(";
                    $closeBracket=")";
                }
                else
                {
                    $openBracket="";
                    $closeBracket="";
                }

                if($myrow["hideamount"]==1)
                {
                    $hideamount="--";
                    $hideamount_INR="--";
                    $global_hideamount = 1;
                }
                else
                {
                    $hideamount=$myrow["amount"];
                    $hideamount_INR=$myrow["Amount_INR"];
                }

                if($myrow["hidestake"]==1)
                {
                    $hidestake="--";
                }
                else
                {
                    $hidestake=$myrow["stakepercentage"];
                    if($myrow["stakepercentage"]>0)
                        $hidestake=$myrow["stakepercentage"];
                    else
                        $hidestake="&nbsp;";
                }
                
                $valuation=$myrow["Valuation"];
                if($valuation!="")
                {
                    $valuationdata = explode("\n", $valuation);
                }
                                    
//                                        if($myrow["Revenue"]<=0)
//                                            $dec_revenue=0.00;
//                                        else
                                        $dec_revenue=$myrow["Revenue"];

//                                        if($myrow["EBITDA"]<=0)
//                                            $dec_ebitda=0.00;
//                                        else
                                        $dec_ebitda=$myrow["EBITDA"];
//                                        if($myrow["PAT"]<=0)
//                                            $dec_pat=0.00;
//                                        else
                                        $dec_pat=$myrow["PAT"];
                                    
                                    if($myrow["CINNo"] != ''){
                                        $cinno = $myrow["CINNo"];
                                    }else{
                                        $cinno = 0;
                                    }
    /*if($myrow["Company_Valuation"]<=0)
                $dec_company_valuation=0.00;
            else
                $dec_company_valuation=$myrow["Company_Valuation"];*/
           $dec_company_valuation=$myrow["Company_Valuation_pre"];
           $dec_company_valuation1=$myrow["Company_Valuation"];
           $dec_company_valuation2=$myrow["Company_Valuation_EV"];
                                        
            /*if($myrow["Revenue_Multiple"]<=0)
                $dec_revenue_multiple=0.00;
            else
                $dec_revenue_multiple=$myrow["Revenue_Multiple"];*/
            $dec_revenue_multiple=$myrow["Revenue_Multiple_pre"];
            $dec_revenue_multiple1=$myrow["Revenue_Multiple"];
            $dec_revenue_multiple2=$myrow["Revenue_Multiple_EV"];

            /*if($myrow["EBITDA_Multiple"]<=0)
                $dec_ebitda_multiple=0.00;
            else
                $dec_ebitda_multiple=$myrow["EBITDA_Multiple"];*/
            $dec_ebitda_multiple=$myrow["EBITDA_Multiple_pre"];
            $dec_ebitda_multiple1=$myrow["EBITDA_Multiple"];
            $dec_ebitda_multiple2=$myrow["EBITDA_Multiple_EV"];
            
    /*if($myrow["PAT_Multiple"]<=0)
                $dec_pat_multiple=0.00;
            else
                $dec_pat_multiple=$myrow["PAT_Multiple"];*/
            $dec_pat_multiple=$myrow["PAT_Multiple_pre"];
            $dec_pat_multiple1=$myrow["PAT_Multiple"];
            $dec_pat_multiple2=$myrow["PAT_Multiple_EV"];
                
            $Total_Debt=$myrow["Total_Debt"];
            $Cash_Equ=$myrow["Cash_Equ"];
            $financial_year=$myrow["financial_year"];

        // New Feature 08-08-2016 start 

                if($myrow["price_to_book"]<=0)
                        $price_to_book=0.00;
                else
                        $price_to_book=$myrow["price_to_book"];


                if($myrow["book_value_per_share"]<=0)
                        $book_value_per_share=0.00;
                else
                        $book_value_per_share=$myrow["book_value_per_share"];


               if($myrow["price_per_share"]!='' && $myrow["price_per_share"] > 0){
                    
                    $price_per_share=$myrow["price_per_share"];
                }else{
                    $price_per_share='';
                }

        // New Feature 08-08-2016 end

                if($myrow["listing_status"]=="L")
                    $listing_stauts_display="Listed";
                elseif($myrow["listing_status"]=="U")
                    $listing_stauts_display="Unlisted";
    //echo "<bR>---".$valuationdata;


        $moreinfor=$myrow["MoreInfor"];
      //$moreinfor=nl2br($moreinfor);
           //echo "<bR>".$moreinfor;
        $string = $moreinfor;
        /*** an array of words to highlight ***/
        $words = array($searchstring);
        //$words="warrants convertible";
        /*** highlight the words ***/
        $moreinfor =  highlightWords($string, $words);

        $col6=trim($myrow["Link"]);
        $linkstring=str_replace('"','',$col6);
        $linkstring=explode(";",$linkstring);
        $uploadname=$myrow["uploadfilename"];
        $currentdir=getcwd();
        $target = $currentdir . "../uploadmamafiles/" . $uploadname;

        $file = "../uploadmamafiles/" . $uploadname;
    }
    
    }
            
            if($debt_equity == 0)
        $debt_equityDisplay="Equity only";
    elseif($debt_equity == 1)
        $debt_equityDisplay="Debt only";
    elseif($debt_equity == "--")
        $debt_equityDisplay="Both";
 ?>
<style>
/*1034*/
.details_linkma:hover{
    cursor:pointer;
}
.mt-list-tab{
    height:34px;
}
.mt-list-tab h2{
    padding:10px 0px 0px 0px;
    font-size:22px;
    margin-bottom: -1px;
}
.inner-section  .action-links{
    margin:0px;
}
.action-links img{
    margin-top: 4px;
    margin-right:5px;
}
.list-tab .inner-list{
    margin-top: -24px;
}
#deal_info table, #valuation_info table, #financials_info table {
<?php if($uploadname == ''){ ?>
    padding-bottom: 20px;
<?php }else{ ?>
    padding-bottom: 15px;    
<?php } ?>
}</style>

<?php 

require_once('aws.php');    // load logins
require_once('aws.phar');

use Aws\S3\S3Client;

$client = S3Client::factory(array(
    'key'    => $GLOBALS['key'],
    'secret' => $GLOBALS['secret']
));

$bucket = $GLOBALS['bucket'];

$iterator = $client->getIterator('ListObjects', array(
    'Bucket' => $bucket,
    'Prefix' => $GLOBALS['root'] . $myrow["companyname"]
));

$c1=0;$c2=0;

    $items = $object1 = array();
    $foldername = '';
    $items1 = array();
    $filesarr = array();

try {
        $valCount = iterator_count($iterator);
    } catch(Exception $e){}

    if($valCount > 0){

    foreach($iterator as $object){
         $fileName =  $object['Key'];

        if($object['Size'] == 0){
            $foldername = explode("/", $object['Key']);
        } 
        //condition check in same company
        if($foldername[1] == $myrow["companyname"])
        {
        $signedUrl = $client->getObjectUrl($bucket, $fileName, '+60 minutes');

        $pieces = explode("/", $fileName);
        $pieces = $pieces[ sizeof($pieces) - 1 ];

        $fileNameExt = $pieces;
        $ex_ext = explode(".", $fileName);
        $ext = $ex_ext[count($ex_ext)-1];
       
        if ( strpos($fileNameExt, $ext) + strlen($ext) != strlen($fileNameExt) ){
            continue;
        }

        $c1 = $c1 + 1;

        $c2 = $c2 + 1;
        
        $items1[$foldername[sizeof($foldername) - 2]][$pieces] = $signedUrl;    

        array_push($items, array('name'=>$str) );

    }   // foreach

    $result = $c2. " of ". $c1;
}
}
?>

<td class="profile-view-left" style="width:100%;">
<div class="result-cnt"> 
    
        <?php if ($accesserror==1){?>
                    <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
        <?php
                exit; 
                } 
        
        $pe_industries = explode(',', $_SESSION['PE_industries']);
        if(!in_array($industryId,$pe_industries)){
            
            echo '<div style="font-size:20px;padding:10px 10px 10px 10px;"><b> You dont have access to this information!</b></div>';
            exit;
        } ?>
                    
<div class="result-title"> 
   
    <?php if(!$_POST){ ?> 
                        <!-- <h2>
                            <?php
                             /*if($studentOption==1 || $exportToExcel==1)
                                    {*/
                                 ?>
                                      <span class="result-no"><?php echo count($prevNextArr); ?> Results Found (across <?php echo $coscount; ?> cos) </span> 
                            <?php   /*} 
                                    else 
                                    {
                                  ?>
                                         <span class="result-no"> XXX Results Found</span> 
                               <?php
                                    }*/
                           if( $vcflagValue ==0)
                               {
                                 ?>
                                      <span class="result-for">  for PE Investment</span>  
                                     
                            <?php } 
                                else if( $vcflagValue ==1)
                                {?>
                                      <span class="result-for">  for VC Investment</span>  
                                       
                          <?php }
                           else if( $vcflagValue ==3){ ?>
                                <span class="result-for">  for Social Venture Investments</span>  
                               
                          <?php  } 
                          else if( $vcflagValue ==4){ ?>
                                <span class="result-for">  for Cleantech Investments</span>  
                               
                          <?php  }
                          else if( $vcflagValue ==5){ ?>
                                <span class="result-for">  for Infrastructure Investments</span>  
                               
                          <?php  }?>
                         </h2> -->
                           
                        <div class="title-links">
                            
                            <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                            <?php 

                            if(($exportToExcel==1))
                                 {
                                 ?>

                                                     <a class="export" id="expshowdeals" name="showdeal" style=" padding: 7px 10px !important;"><!-- <span class="download-icon"></span> -->Export</a>


                                 <?php
                                 }else { ?>
                                                     <a class ="export" id="expshowdeals" target="_blank" href="../xls/Sample_Sheet_Investments.xls"  style="float:right;padding: 7px 10px !important;"><!-- <span class="download-icon"></span> -->Sample Export</a>
                             <?php } ?>
                         </div>
    
                          <?php if($datevalueDisplay1!=""){  ?>
                                      <ul class="result-select" style="max-width: 54%;">
                                          <li> 
                                            <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                          </li>
                                      </ul>
                            <?php } 
                            
                               }
                               else 
                               { ?> 
                             
                        <div class="title-links">
                            
                            <input class="senddeal" type="button" id="senddeal" value="Send this deal to your colleague" name="senddeal">
                            <?php 

                            if(($exportToExcel==1))
                                 {
                                 ?>

                                                     <a class="export" id="expshowdeals" name="showdeal" style="padding: 7px 10px !important;"><!-- <span class="download-icon"></span> -->Export</a>


                                 <?php
                                 }else { ?>
                                                     <a class ="export" id="expshowdeals" target="_blank" href="../xls/Sample_Sheet_Investments.xls" style="float:right;padding: 7px 10px !important;"><!-- <span class="download-icon"></span> -->Sample Export</a>
                             <?php } ?>
                             
                         </div>
                            <ul class="result-select" style="    max-width: 54%;">
                            <?php
                             //echo $queryDisplayTitle;
                             if($datevalueDisplay1!=""){ ?>
                                <li> 
                                    <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                             //echo $queryDisplayTitle;
                            if($industry >0 && $industry!=null){ ?>
                            <?php $industryarray = explode(",",$industryvalue); 
                            $industryidarray = explode(",",$industryvalueid); 
                                foreach ($industryarray as $key=>$value){  ?>
                                  <li>
                                      <?php echo $value; ?><a  onclick="resetmultipleinput('industry',<?php echo $industryidarray[$key]; ?>,<?php echo $indexflagvalue;?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                  </li>
                                <?php } ?>
                            <?php } 
                            if ($state > 0 && $state != null) {$drilldownflag = 0;?>
                               <?php $statearray = explode(",",$statevalue); 
                            $stateidarray = explode(",",$statevalueid); 
                                foreach ($statearray as $key=>$value){  ?>
                                  <li>
                                      <?php echo $value; ?><a  onclick="resetmultipleinput('state',<?php echo $stateidarray[$key]; ?>,<?php echo $indexflagvalue;?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                  </li>
                                <?php } ?>
                              <?php }
                            if ($sector > 0 && $sector != null) {$drilldownflag = 0;?>
                                <!-- <li>
                                    <?php echo $sectorvalue; ?><a  onclick="resetinput('sector');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li> -->
                                 <?php
                                   $sectorarray = explode(",",$sectorvalue); 
                                                   $sectoridarray = explode(",",$sectorvalueid); 
                                                        foreach ($sectorarray as $key=>$value){  ?>
                                                          <li>
                                                             <?php echo $value; ?><a  onclick="resetmultipleinput('sector',<?php echo $sectoridarray[$key]; ?>,<?php echo $indexflagvalue;?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                                          </li>
                                                        <?php } ?>
                              <?php }
                                if (count($dealsinvolvingvalue) > 0) {
      
                                    foreach ($dealsinvolvingvalue as $dealsinvolvingval) {
                                        
                                        if ($dealsinvolvingval == 1) {
                        
                                            $dealsinvolvingfilter .= 'New Investor, ';
                        
                                        } else if ($dealsinvolvingval == 2) {
                        
                                            $dealsinvolvingfilter .= 'Existing Investor, ';
                        
                                        } else {
                                            $dealsinvolvingfilter = '';
                                        }
                                    }
                                    $dealsinvolvingfilter = trim($dealsinvolvingfilter, ', ');
                                }
                                  if ($dealsinvolvingfilter != '') {?>
                                      
                                      
                                       <?php $dealsarray = explode(",",$dealsinvolvingfilter); 
                        
                                   
                                        foreach ($dealsarray as $key=>$value){ ?>
                                          <li>
                                              <?php echo $value; ?><a  onclick="resetmultipleinput('dealsinvolving','<?php echo $dealsarray[$key]; ?>',<?php echo $indexflagvalue;?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                          </li>
                                        <?php } ?>
                                     
                                      <?php }
                                if ($subsector > 0 && $subsector != null) {$drilldownflag = 0;?>
                              <!--   <li>
                                    <?php echo $subsectorvalue; ?><a  onclick="resetinput('subsector');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li> -->
                                 <?php
                                foreach ($subsector as $key=>$value){  ?>
                                  <li>
                                     <?php echo $value; ?><a  onclick="resetmultipleinput('subsector','<?php echo $subsector[$key]; ?>',<?php echo $indexflagvalue;?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                 </li>
                                <?php } ?>
                              
                                <?php }
                                
                            if($stagevaluetext!="" && $stagevaluetext!=null) { ?>
                            <!-- <li> 
                                <?php echo $stagevaluetext ?><a  onclick="resetinput('stage');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li> -->
                            <?php $stagearray = explode(",",$stagevaluetext); 
                           $stageidarray = explode(",",$stagevalueid); 
                                foreach ($stagearray as $key=>$value){  ?>
                                  <li>
                                     <?php echo $value; ?><a  onclick="resetmultipleinput('stage',<?php echo $stageidarray[$key]; ?>,<?php echo $indexflagvalue;?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
         </li>
                                <?php } ?>
            
                            <!-- Round -->
                            <?php } 
          if($round!="--" && $round!=null && $roundTxtVal !=''){ $drilldownflag=0; ?>
                            <!-- <li> 
              <?php echo $roundTxtVal; ?><a  onclick="resetinput('round');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li> -->
                             <?php $roundarray = explode(",",$roundTxtVal); 
                           
                                foreach ($roundarray as $key=>$value){  ?>
                                  <li>
                                     <?php echo $value; ?><a  onclick="resetmultipleinput('round','<?php echo $roundarray[$key]; ?>',<?php echo $indexflagvalue;?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
         </li>
                                <?php } ?>
                            <!-- -->
                            <?php }
                            if($companyType!="--" && $companyType!=null){ ?>
                            <li> 
                                <?php echo $companyTypeDisplay; ?><a  onclick="resetinput('comptype');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php } 
                            if($investorType !="--" && $investorType!=null){ ?>
                            <li> 
                                <?php echo $invtypevalue; ?><a  onclick="resetinput('invType');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php }  
                            if ($investor_head != "--" && $investor_head != null) {$drilldownflag = 0;?>
                              <li>
                                  <?php echo $invheadvalue; ?><a  onclick="resetinput('invhead');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                              </li>
                              <?php }
                            if($regionId>0){ ?>
                            <!-- <li> 
                                <?php echo $regionvalue; ?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li> -->
                            <?php $regionarray = explode(",",$regionvalue); 
                            $regionidarray = explode(",",$regionvalueId);
                                foreach ($regionarray as $key=>$value){  ?>
                                  <li>
                                     <?php echo $value; ?><a  onclick="resetmultipleinput('txtregion','<?php echo $regionidarray[$key]; ?>',<?php echo $indexflagvalue;?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                  </li>
                                <?php } ?>
                            <!-- City -->
                            <?php }  
                            /*if($city!=""){ $drilldownflag=0; ?>
                            <li> 
                                <?php echo $city; ?><a  onclick="resetinput('city');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <!-- -->
                            <?php }  */
                            /*if ($cityid != "--" && $cityname !=""){$drilldownflag = 0;?>
                              <li>
                                  <?php echo $cityname; ?><a  onclick="resetinput('city');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                              </li>
                              <?php }*/
                               //city multiselect
                            $cityflag=$_POST['cityflag'];
                            if ($city > 0 && $city != null  && $cityflag !=0) {$drilldownflag = 0;?>
                                <?php $cityarray = explode(",",$cityvalue); 
                            $cityidarray = explode(",",$cityvalueid); 
                              foreach ($cityarray as $key=>$value){?>
                                <li>
                                    <?php echo ucwords(strtolower($value)); ?><a  onclick="resetmultipleinput('city','<?php echo $cityidarray[$key]; ?>',<?php echo $indexflagvalue;?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } ?>
                            
                            <?php }
                            if (($startRangeValue!= "--") && ($endRangeValue != "")){ ?>
                            <li> 
                                <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?><a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php } 
                            if (($yearafter!= "" || $yearbefore != "")){$drilldownflag=0; ?>
                                <li> 
                                    <?php echo $yearafter ."-" .$yearbefore ?><a  onclick="resetinput('yearfounded');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                            <?php }  
                             if($valuationstxt!=""){  ?>
                              <!-- <li> 
                                <?php echo str_replace('_', ' ', $valuationstxt);?><a  onclick="resetinput('valuations');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                              </li> -->
                              <?php $valuationarray = explode(",",$valuationstxt); 
                            //print_r($valuations);
                                foreach ($valuationarray as $key=>$value){  ?>
                                  <li>
                                     <?php echo str_replace('_', ' ', $value); ?><a  onclick="resetmultipleinput('valuations','<?php echo $valuations[$key]; ?>',<?php echo $indexflagvalue;?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } ?>
                            <?php } 
                            
                           // if($datevalueDisplay1!=""){ ?>
                            <!-- <li> 
                                <?php //echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li> -->
                            <?php //} 
                            if($debt_equity!="--" && $debt_equity!=null) { ?>
                            <li> 
                                <?php echo  $debt_equityDisplay;?><a  onclick="resetinput('dealtype_debtequity');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php } 
                            if($keyword!="") { $drilldownflag=0; ?>
                            <?php $investerarray = explode(",",$invester_filter); 

                            $investeridarray = explode(",",$invester_filter_id); 
                            foreach ($investerarray as $key=>$value){  ?>
                              <li>
                                  <?php echo $value; ?><a  onclick="resetmultipleinput('keywordsearch',<?php echo $investeridarray[$key]; ?>,<?php echo $indexflagvalue;?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                              </li>
                            <?php } ?>
                            <?php } 
            if($syndication!="--" && $syndication!=null) { $drilldownflag=0; ?>
          <li> 
              <?php echo  $syndication_Display;?><a  onclick="resetinput('syndication');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
          </li>
          <?php } 
                            if($companysearch!=""){ $drilldownflag=0; ?>
                            <!-- <li> 
                                <?php echo trim($company_filter);?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li> -->
                            <?php $companyarray = explode(",",$company_filter); 

                        $companyidarray = explode(",",$company_id); 
                            foreach ($companyarray as $key=>$value){  ?>
                              <li>
                                  <?php echo $value; ?><a  onclick="resetmultipleinput('companysearch',<?php echo $companyidarray[$key]; ?>,<?php echo $indexflagvalue;?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                              </li>
                            <?php } ?> 
                            <?php } 
                            if($sectorsearch!=""){ $drilldownflag=0; ?>
                            <li> 
                                <?php echo  trim($sectorauto);?><a  onclick="resetinput('sectorsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php } 
                            if($advisorsearchstring_legal!="") { $drilldownflag=0; ?>
                            <li> 
                                <?php echo trim($advisorsearchstring_legal);?><a  onclick="resetinput('advisorsearch_legal');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php } 
                            if($advisorsearchstring_trans!=""){ $drilldownflag=0; ?>
                            <li> 
                                <?php echo trim($advisorsearchstring_trans);?><a  onclick="resetinput('advisorsearch_trans');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                            <?php }  if($searchallfield!=""){ $drilldownflag=0; ?>
                            <li> 
                                <?php echo trim($searchallfield)?><a  onclick="resetinput('searchallfield');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                            </li>
                             <?php }
    
            if(count($exitstatusValue) > 0){
                foreach($exitstatusValue as $exitstatusValues)
                {
                    if($exitstatusValues==1){

                        $exitstatusfilter .= 'Unexited, ';

                }
                    else if($exitstatusValues==2){

                        $exitstatusfilter .= 'Partially Exited, ';

                }
                    else if($exitstatusValues==3){

                        $exitstatusfilter .= 'Fully Exited, ';

                }else {
                        $exitstatusfilter = '';
                }
            }
                $exitstatusfilter = trim($exitstatusfilter,', ');
            }
           if($exitstatusfilter!=''){ ?>
            <!-- <li> 
               <?php echo $exitstatusfilter; ?><a  onclick="resetinput('exitstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
            </li> -->
             <?php $exitarray = explode(",",$exitstatusfilter); 

        //$exitidarray = explode(",",$exitstatusValue); 
            foreach ($exitarray as $key=>$value){  ?>
              <li>
                  <?php echo $value; ?><a  onclick="resetmultipleinput('exitstatus','<?php echo $exitstatusValue[$key]; ?>',<?php echo $indexflagvalue;?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
            <?php } ?>
         
          <?php }?>
          <?php   if($tagsearch!=''){ ?>
            <!-- <li> 
               <?php echo "tag:".$tagsearch; ?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
            </li> -->
              <?php $tagarray = explode(",",$tagsearch); 
              foreach ($tagarray as $key=>$value){  ?>
              <li>
                  <?php echo "tag:".$value; ?><a  onclick="resetmultipleinput('tagsearch','<?php echo $tagarray[$key]; ?>',<?php echo $indexflagvalue;?>);"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
            <?php } ?>
          <?php  }
                            ?>
                         </ul>
    
    
    
                               <?php }?>
    
</div>
    <?php
        $companyName=trim($myrow["companyname"]);
        $companyName=strtolower($companyName);
        $compResult=substr_count($companyName,$searchString);
        $compResult1=substr_count($companyName,$searchString1);
        
        
    ?>
<!--  <div class="list-tab mt-list-tab " style="max-width:1440;background: #fff !important;"> -->
<div class="list-tab mt-list-tab " style="background: #fff !important;">
            <?php
                       if(($compResult==0) && ($compResult1==0))
                       {
                           $display = 'no';
                           $string =rtrim($myrow["companyname"]);
                           $string = strip_tags($string);
                           if (strlen($string) > 40) { 
                               $pos=strpos($string, ' ', 40);
                               if($pos != ''){
                                   $string = substr($string,0,$pos );
                               }else{
                                   $string = substr($string,0,40 );                            
                               }
                               $string = trim($string).'...';
                               $display = 'yes';
                           }
                   ?>
                   <!--companydetails.php?value=<?php echo $myrow["PECompanyId"].'/'.$VCFlagValue.'/';?>-->
                           <h2 class="detailtitle text-center"> <a class="postlink companyProfileBox" href='javascript:void(0)'><?php echo stripslashes($string);?>
                               <?php if($display == 'yes'){ ?>
                                    <div class="tooltip-box">
                                         <?php echo trim($myrow["companyname"]);?>
                                    </div>
                               <?php } ?>                                   
                            </a>

                          </h2>
                  <?php
                       }else{
                  ?>
                          <h2 class="detailtitle text-center">  <?php echo rtrim($searchString);?></h2>
                  <?php
                       }
                       ?>
                       <div>
                  <ul class="inner-list inner-list_width1">
                    <li><a class="postlink list-view"  href="<?php echo $actionlink; ?>"  id="icon_grid-view"><!--<img src="images/list-icon.png" />--><i></i> <!-- List View --></a></li>
                    <li class="active"><a id="icon_detailed-view" class="postlink detail-view"  href="dealdetails.php?value=<?php echo $_GET['value'];?>" ><!--<img src="images/bar-icon.png" />--><i></i> <!-- Detail View --></a></li> 
                    </ul> 
  
        <?php
        //if($strvalue[3]!='Directory'){ ?>
            
                <div class="inner-section inner-section-width1 redirection-icon">
                    <div class="action-links">
                    <?php if ($prevKey!='-1') {?> 
                        <a  class="postlink" id="previous" href="dealdetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $VCFlagValue;?>/"> 
                        <!-- <img src="images/back_black.png" title="Previous" alt="Previous" /> -->
                        <span class="previous-icon"></span>
                        </a>
                    <?php }else{ ?>
                        <!-- <img src="images/back_grey.png" style="cursor:no-drop; margin-right:10px;" /> -->
                         <?php } ?>
                    <?php if ($nextKey < count($prevNextArr)) { ?>
                        <a class="postlink" id="next" href="dealdetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $VCFlagValue;?>/">
                           <!--  <img src="images/forward_black.png" title="Next" alt="Next" />    -->
                           <span class="next-icon"></span>
                        </a>  
                        <?php }else{ ?><!-- <img src="images/forward_grey.png" style="cursor:no-drop;" />  -->
                    <?php } ?>
                    </div>
                </div>
           
       
        <?php //} ?>
        </div> 
         </div>
<div class="lb" id="popup-box">
<div class="title">Send this to your Colleague</div>
    <form>
        <div class="entry">
                <label> To*</label>
                <input type="text" name="toaddress" id="toaddress"  />
        </div>
        <div class="entry">
                <h5>Subject*</h5>
                <p>Checkout this deal- <?php echo $myrow["companyname"]; ?> - in Venture Intelligence</p>
                <input type="hidden" name="subject" id="subject" value="Checkout this deal- <?php echo $myrow["companyname"]; ?> - in Venture Intelligence"  />
                <input type="hidden" name="basesubject" id="basesubject" value="Deal" />
        </div>
        <div class="entry">
                <h5>Link</h5>
                <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message" id="message" value="<?php  echo curPageURL(); ?>"  />   <input type="hidden" name="useremail" id="useremail" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
        </div>
        <div class="entry">
                <h5>Your Message</h5><span style='float:right;display: block;margin-top: -20px;'>Words left: <span id="word_left">200</span></span>
                <textarea name="ymessage" id="ymessage" style="width: 374px; height: 57px;" placeholder="Enter your text here..." val=''></textarea>
        </div>
        <div class="entry">
            <input type="button" value="Submit" id="mailbtn" />
            <input type="button" value="Cancel" id="cancelbtn" />
        </div>

    </form>
</div>
<div class="lb" id="popup-box-financial">
<div class="title">Send this to Venture</div>
    <form>
        <div class="entry">
                <label> To*</label>
                <input type="text" name="toaddress_fc" id="toaddress_fc"  value="research@ventureintelligence.com"/>
        </div>
        <div class="entry">
                <h5>Subject*</h5>
                <p>Request for financials linking</p>
                <input type="hidden" name="subject_fc" id="subject_fc" value="Request for financials linking"  />
        </div>
        <div class="entry">
                <h5>Link</h5>
                <p><?php  echo curPageURL(); ?>   <input type="hidden" name="message_fc" id="message_fc" value="<?php  echo curPageURL(); ?>"  />   <input type="hidden" name="useremail_fc" id="useremail_fc" value="<?php echo $_SESSION['UserEmail']; ?>"  /> </p>
        </div>
         <div class="entry">
                <label> Comments </label>
                <textarea name="comments" id="comments" style="width:100%;"></textarea>
        </div>
        <div class="entry">
            <input type="button" value="Submit" id="mailfnbtn" />
            <input type="button" value="Cancel" id="cancelfnbtn" />
        </div>

    </form>
</div>                   
<div class="view-detailed"> 
     <!--div class="detailed-title-links"> <h2>  <?php echo $myrow["companyname"]; ?></h2-->
       <!--  <div class="detailed-title-links">
                </div> -->
        
   <div class="row section1" style="    display: inline-flex;">
       
         <div  class="work-masonry-thumb1 col-p-12 companyinfo" id="company_info" style="background: #f4f4f4 !important">
             <div class="accordions">

                <!-- <?php if(sizeof($items1) > 0){ ?>
                    <div class="linkpecfs" id="allfinancial">Financials</div>
                    <div class="linkfillings"><span> | </span><a href="pefillings.php?cname=<?php echo $myrow['companyname'];?>&value=<?php echo $value;?>" class="postlink">Filings</a></div>
                <?php } else { ?>
                    <div class="linkpecfs" id="allfinancial" style="right: 0px;">Financials</div>
               <?php }?> -->
               <div class="linkpecfs" id="allfinancial" style="right: 0px;">Financials</div>

                <div class="accordions_dealtitle"><span></span>
                <h2 id="companyinfo" class="box_heading content-box ">Company Profile </h2>
                </div>
                 <div class="accordions_dealcontent companydealcontent" style="    background: rgb(255, 255, 255);">
                <table cellpadding="0" cellspacing="0" class="tablelistview3 companyinfo_table">
                <tbody> 
                  <tr>  
                 <?php
                    $companyName=trim($myrow["companyname"]);
                    $companyName=strtolower($companyName);
                    $compResult=substr_count($companyName,$searchString);
                    $compResult1=substr_count($companyName,$searchString1);
                    $webdisplay="";
                    $finlink=$myrow["FinLink"];
                        if(($compResult==0) && ($compResult1==0))
                        {
                            $webdisplay=$myrow["website"];
                ?>
                      <td style=""><h4>Company</h4></td>
                      
                      <td class="" style=""> 
                 <?php
                        $display = 'no';
                        $string =trim($myrow["companyname"]);
                     //    $string = strip_tags($string);
                     //    if (strlen($string) > 29) { 
                     //        $string = substr($string,0,29);
                     //        $string = trim($string).'...';
                     //        $display = 'no';
                     // }
                  ?>
                    <div class="tooltip-4" style="float:left;"><p> <?php echo $openDebtBracket;?><?php echo $openBracket;?>
                    <?php /* 
                    <a class="postlink" href='companydetails.php?value=<?php echo $myrow["PECompanyId"].'/'.$strvalue[1].'/'.$strvalue[2].'/'.$strvalue[3];?>' >
                    <?php echo $string;?></a>
                    */ 
                    ?>
                    
                    
                    <?php /* <a class="postlink"  href='companydetails.php?value=<?php echo $myrow["PECompanyId"].'/'.$strvalue[1].'/'.$strvalue[2].'/'.$strvalue[3].'/0/102/Directory';?>' >
                    <?php echo $string;?></a>
                    */ ?>
                    
                    <a  href='companydetails.php?value=<?php echo $myrow["PECompanyId"].'/'.$strvalue[1].'/'.'102/Directory';?>' target="_blank" >
                    <?php echo trim($string);?></a>
                    
                    
            <?php echo $closeBracket;?><?php echo $closeDebtBracket;?>
                        </p>
                    </div>
                    <p style="float:right;">
                        <span><a  onclick="window.open ('<?php echo BASE_URL; ?>malogin.php?search=<?php echo $string;?>', ''); return false" href="javascript:void(0);" target="_blank" style="    text-decoration: none;">
                            M&A Search</a></span>
                    </p>
                          <?php 
                          if($display == 'yes'){ ?>
                      <div class="tooltip-box4">
                <?php echo trim($myrow["companyname"]);?>
                    </div>
                          <?php } ?>
                      </td>
    <?php
            }
            else
            {
                $webdisplay="";
    ?>
                                    <td style=""><h4>Company</h4> </td><td><p><b>&nbsp;<?php echo ucfirst("$searchString") ;?></b></p></td>
    <?php
            }
    ?>
                                    
                  </tr>
                    <tr>  
                        <?php if($myrow["industry"]!="") { ?>  <td><h4>Industry</h4> </td>
                        <td class=""><p><?php echo $myrow["industry"];?></p></td>  <?php } ?>
                        
                  </tr>
                    <tr>  
                       <td>
                            <h4>Sector </h4>
                       </td>
                        <?php 
                        $display = 'no';
                        $string =trim($myrow["sector_business"]);
                        $string = strip_tags($string);
                        if (strlen($string) > $_COOKIE['hidestringval']) { 
                            $string = substr($string,0,$_COOKIE['hidestringval']);
                            $string = trim($string).'...';
                            $display = 'no';
            }
                        ?>
                        <td class="tooltip5"> 
                          <p><?php echo $myrow["sector_business"];?></p>
                          <?php   if($display == 'yes'){ ?>
                              <div class="tooltip-box5"><?php echo $myrow["sector_business"];?></div>
                          <?php } ?>
                          
                        </td>
                   
                  
                    
                    </tr>
                    <tr>
                         <td><h4>CIN</h4></td>
                         <td><p><?php echo $CIN; ?></p></td>
                    </tr>
                  
                 <tr>
                     <td style=""><h4>Location</h4></td>
                     <td class="" style="">
                       <!--  <p>
                            <?php echo  $myrow["city"];?>,<?php echo $myrow["state"];?>, 
                            <?php echo $regionname;?><?php if($countryname != '--' ) { echo ', '.$countryname;}
                            ?>                    
                        </p> -->
                         <p>
                             <?php echo $myrow["city"]; 
                             if($myrow["city"]!="" && $myrow["state"] !=""){ echo ', '; } 
                             echo $myrow["state"]; 
                             if($regionname!="" && $myrow["state"] !=""){ echo ', '; } 
                             else if($myrow["city"]!="" && $myrow["state"] == "" && $regionname !=''){ echo ', ';}
                             echo $regionname; 
                             if($countryname != '--' && $countryname!="" ) { echo ', '.$countryname;}else{echo "";}
                            ?>                   
                        </p>
                     </td>
                 </tr>
                 <!-- <tr>
                     <?php if($regionname!="") { ?><td><h4>Region</h4></td><td class=""> <p><?php echo $regionname;?></p> </td> <?php } ?> 
                 </tr> -->
                 <tr>
                      <td>
                        <h4>Website</h4>
                <div style="display:none"><?php echo $webdisplay; ?></div>
                    </td>
                    <?php 
                        $display = 'no';
                        $string =$webdisplay;
                        $string = strip_tags($string);
                        if (strlen($string) > $_COOKIE['hidestringval']) { 
                            $string = substr($string,0,$_COOKIE['hidestringval']);
                            $string = trim($string).'...';
                            $display = 'no';
                        }
                    ?>
                     <td class="toolbox6"> 
                        <p class="linktooltip"><a href=<?php echo $webdisplay; ?> target="_blank"><?php echo $webdisplay; ?></a></p> 
                          <?php   if($display == 'yes'){ ?>
                                <div class="tooltip-box6"><a href=<?php echo $webdisplay; ?> target="_blank"><?php echo $webdisplay; ?></a></div>
                          <?php } ?>
                           
                    </td>
                 </tr>
                 <tr>
                     <td><h4>Type</h4></td>
                    <td class=""> <p><?php echo $listing_stauts_display;?></p></td>
               
                 </tr>
                 <!-- <tr>
                      <td><h4>News Link</h4></td>
                      
                <td class="toolbox6">
                    
                    <p class="linktooltip">
                            <?php 
                        $display = 'no'; $news_link='';
                        if(count($linkstring)>0 && $col6 !='') { 
                            $string = $stortlink = '';
                            foreach ($linkstring as $linkstr) {
                                if(trim($linkstr)!=="") {
                                    if($string == '' && $display == 'no'){
                                        // strip tags to avoid breaking any html
                                        $string = strip_tags($linkstr);

                                        if (strlen($string) > $_COOKIE['hidestringval']) {
                                            $string = substr($string,0,$_COOKIE['hidestringval']);  
                                            $string = trim($string).'...';
                                            $display = 'no';
                                         }
                                        $stortlink = "<a href='".$linkstr."' target='_blank'>".$string."</a>";
                                    }

                                    if($news_link != ''){
                                        //$news_link .= "<br/>";
                                        $display = 'no';
                                    }
                                    $news_link .= "<a href='".$linkstr."' target='_blank'>".$linkstr."</a>";  
                                }
                            }
                            echo $news_link;
                        }else{ echo '&nbsp;'; } ?>
                    </p>    
                    <?php if($display == 'yes'){ ?>
                     <div class="tooltip-box6">
                <?php echo $news_link; ?>
                    </div> <?php } ?>
                </td>
                 </tr> -->
                 <?php if ($Address1 != "" || $Address2 != "") 
               { ?>
                 <!-- <tr>
                     <td style=""><h4>Address</h4></td>
                     <?php 
                        $display = 'no';
                        $string =$Address1."<br/>". $Address2;
                        $string = strip_tags($string);
                        if (strlen($string) > 24) { 
                            $string = substr($string,0,24);
                            $string = trim($string).'...';
                            $display = 'yes';
                        }
                    ?>
                                    <td class="toolbox6">
                                        <p><?php echo $string;?></p>
                                        <?php if($display == 'yes'){ ?>
                                             <div class="tooltip-box6">
                                       <?php echo $Address1; ?><?php //if ($Address2 != "") echo "<br/>" . $Address2; ?>
                                            </div> <?php } ?>
                                    </td>
                 </tr> -->
                 <?php
              }?>
              
                 

                  
                 
                <?php if($rsMgmt= mysql_query($onMgmtSql)) { 
                    
                    $rowcount=mysql_num_rows($rsMgmt);
                     
                    //if($rowcount > 0){ ?>  
                        <tr>
                             <td style=""><h4>Top Management</h4></td>
                                <td class="toolbox6">
                                
                            <?php 
                              /* While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                                {
                                    $executivename=$mymgmtrow["ExecutiveName"];
                                    $desig="";
                                    $desig=$mymgmtrow["Designation"]; ?>
                                    <p><?php echo $executivename; ?><?php if ($executivename != "" && $desig!="") echo ", " . $desig; ?></p>
                              <?php } */
                              $string = '';$display = 'no';$toottipString = '';
                                While($mymgmtrow=mysql_fetch_array($rsMgmt, MYSQL_BOTH))
                                {
                                    $executivename=$mymgmtrow["ExecutiveName"];
                                    $desig="";
                                    $desig=$mymgmtrow["Designation"]; 
                                    
                                    if ($executivename != "" && $desig!="") {
                                        $string .=$executivename.", " .$desig.", ";
                                        $toottipString .= '<div>'.$executivename.", " .$desig.'</div>';
                                    } else {
                                        $string .=$executivename.", ";
                                        $toottipString .= '<div>'.$executivename.'</div>';
                                    }
                                } 

                                // $string = strip_tags($string);
                                // if (strlen($string) > $_COOKIE['hidestringval']) { 
                                //     $string = substr($string,0,$_COOKIE['hidestringval']);
                                //     $string = trim($string).'...';
                                //     $display = 'yes';
                                // } 
                                ?>
                                <p class="topmanagementtooltip"><?php echo rtrim($string, ', ');?></p>
                                <?php if($string != ''){  ?>
                                     <div class="tooltip-box6 topmanagement">
                                        <?php echo $toottipString; ?>
                                     </div>
                                <?php } ?>
                         
                                            
                               </td>            
                          </tr>
                    
                    <?php// }?>  
                
                 
                  <?php }?>  

                  <tr>
                     <td style=""><h4>Contact</h4></td>
                     <?php 
                        $display = 'no';
                        if ($Tel != "" && $Email!="") {
                            $string =$Email.", " .$Tel;
                        } else {
                            $string =$Email;
                        }
                        $string = strip_tags($string);
                        if (strlen($string) > $_COOKIE['hidestringval']) { 
                            $string = substr($string,0,$_COOKIE['hidestringval']);
                            $string = trim($string).'...';
                            $display = 'no';
                        }
                    ?>
                                    <!-- <td class="" style=""><p><?php echo $string; ?></p></td> -->
                                    <td class="toolbox6 contacttooltip">
                                        <p ><?php echo $Email; ?><?php if ($Tel != "" && $Email!="") echo ", " . $Tel; ?></p>
                                        <?php if($display == 'yes'){ ?>
                                             <div class="tooltip-box6">
                                       
                                            </div> <?php } ?>
                                    </td>
                                   
                  </tr>

                  <?php 
                        $onBoardSql="select pec.PECompanyId,bd.PECompanyId,bd.ExecutiveId,exe.ExecutiveName,exe.Designation,exe.Company 
                        from pecompanies as pec,executives as exe,pecompanies_board as bd
                        where pec.PECompanyId='$PECompanyId' and bd.PECompanyId=pec.PECompanyId and exe.ExecutiveId=bd.ExecutiveId";
                       // echo "<Br>Investor".$onBoardSql;

                        if($rsBoard= mysql_query($onBoardSql))
                        {
                             $board_cnt = mysql_num_rows($rsBoard);
                        }
                        //if($board_cnt>0) { ?>
                            <tr>
                                 <td style=""><h4>Investor Board Member</h4></td>
                                    <td class="" style="">
                                
                               <?php  While($myboardrow=mysql_fetch_array($rsBoard, MYSQL_BOTH))
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
                                    <p>
                                        <?php $google_sitesearch_board="https://www.google.co.in/search?q=".$myboardrow["ExecutiveName"].$desig.$comp. "+site%3Alinkedin.com"; ?>
                                        <a target="_blank" href="<?php echo $google_sitesearch_board; ?>" style="text-decoration: underline;color: #624C34 !important;">
                                         <?php echo $myboardrow["ExecutiveName"];?></a>, <?php echo $myboardrow["Designation"];
                                         if($myboardrow["Designation"]!="" && $myboardrow["Company"]!=""){ echo ","; } ?>
                                        <?php echo $myboardrow["Company"]; ?>
                                    </p>
                        <?php } ?>
                        
                               </td>
                            </tr>
                    <?php //} ?>
                 </tbody>
                </table>

            </div>

        </div>  
    </div>  
    <div  class="work-masonry-thumb1 col-p-8 dealinfo" id="deal_info" style="background: #f4f4f4 !important">
             <div class="accordions">
             <!-- <div class="linkpecfs" id="allshp" style="right: 0px; cursor:pointer;">SHP</div> -->
            <!--  <div class="linkfillings"><a href="pefillings_shp.php?cname=<?php echo $myrow['companyname'];?>&value=<?php echo $value;?>" class="postlink">Filings/SHP</a></div> -->
            <!-- SHP Valid -->
                <?php
                $shp_valid = mysql_query("select count(*) as total from pe_shp where PEId=".$IPO_MandAId);
                $shp_data=mysql_fetch_assoc($shp_valid);
                $shp_count = $shp_data['total'];
                if(sizeof($items1) > 0 || $shp_count > 0){
                ?>
                <div class="linkfillings"><a href="pefillings_shp.php?cname=<?php echo $myrow['companyname'];?>&value=<?php echo $IPO_MandAId;?>" class="postlink">Filings / SHP</a></div>
                <?php } ?>
                <!-- End SHP Valid -->
                <div class="accordions_dealtitle"><span></span>
                <h2 id="companyinfo" class="box_heading content-box ">Deal info</h2>
                </div>
                 <div class="accordions_dealcontent companydealcontent dealinfocontent" style="    background: rgb(255, 255, 255);">
                     <table cellpadding="0" cellspacing="0" class="tablelistview3 dealinfo_table">
                        <tbody> 

        <tr>
            <td id="tourinvestor">
                <h4>Amount ($ M) </h4>
            </td>
            <td id="tourinvestor" class="">
                <p>
                 <?php if($myrow["hideamount"]==1){   ?>
                      <?php echo $hideamount;?> 
                 <?php } else { ?>
                     <?php if($hideamount !='' && $hideamount !='0.00' ){?><?php echo $hideamount;?> <?php } else{ ?> <?php echo '&nbsp;'; } ?>
                 <?php } ?>
                </p>
          </td>
      </tr>
     
      <tr>
          <td><h4>Amount (&#8377; Cr) </h4></td>
          <td class="rgt"><p>
                 <?php if($myrow["hideamount"]!=1 && $hideamount_INR !='' && $hideamount_INR !='0.00'){   ?>
                 <?php echo $hideamount_INR; }else{
                    echo "&nbsp;"; }?></p>
        </td>
    </tr>
     <tr>
          <td><h4>Exit Status</h4></td>
          <td class=""><?php
             $exitstatusis='';
            $exitstatusSql = "select id,status from exit_status where id=".$myrow["Exit_Status"];
            if ($exitstatusrs = mysql_query($exitstatusSql))
            {
              $exitstatus_cnt = mysql_num_rows($exitstatusrs);
            }
            if($exitstatus_cnt > 0)
            {
                    While($Exit_myrow=mysql_fetch_array($exitstatusrs, MYSQL_BOTH))
                    {
                            $exitstatusis = $Exit_myrow[1];
                    }?>
                    <p><?php echo $exitstatusis;?></p>
            <?php } ?> </td> 
        </tr>
      <tr>
                        <?php  $dealdate123 =  $myrow['dates']; ?>

          <td><h4>Date</h4></td>
          <input type="hidden" name="dealdate" value="<?php echo $myrow['dates']; ?>">
            <td class=""><p><?php echo  $myrow["dt"];?></p></td>
     </tr>
      <?php //if($book_value_per_share > 0 || $book_value_per_share > 0) { ?>
        
     <tr>
            <td><h4>Stake</h4></td> 
            <td class=""><p>
            <?php if($hidestake!="" && $hidestake!="&nbsp;" && $hidestake !='--'){ 
                    echo $hidestake.' %';
                }else{
                    echo "&nbsp;";
                }?> </p></td> 
        </tr>
    <tr>
          <td><h4>Stage</h4></td>
  <td class=""><p><?php echo $myrow["Stage"];?></p></td>
      </tr>
     
        <tr>
            <td><h4>Round</h4></td>
            <td class="tooltip-1 round"><p>
                <?php // strip tags to avoid breaking any html
                $string = strip_tags($myrow["round"]);
                if (strlen($string) > 12) { 
                    $pos=strpos($string, ' ', 12);
                    if($pos != ''){
                        $string = substr($string,0,$pos);
                    }else{
                        $string = substr($string,0,12);                            
                    }
                    $string = trim($string).'...';
                    //$display = 'yes';
                } echo $myrow["round"]; ?></p>
                <?php if($display == 'yes') { ?>
            <div class="tooltip-box1">
                <?php echo $myrow["round"];?>
           </div>
            <?php } ?>  
                    </td>
      </tr>
     <tr>
                      <td><h4>News Link</h4></td>
                      
                <td class="newslinktooltip">
                    
                    
                            <?php 
                        $display = 'no'; $news_link='';$count = 0;$showlinktext = false;
                        if(count($linkstring)>0 && $col6 !='') { 
                            $string = $stortlink = '';
                            foreach ($linkstring as $linkstr) {
                                if(trim($linkstr)!=="") {
                                    $count = $count + 1;
                                    if($count > 1){
                                        $showlinktext = true;
                                    } else {
                                        $showlinktext = false;
                                    }
                                    if($string == '' && $display == 'no'){
                                        $string = strip_tags($linkstr);
                                        if (strlen($string) > 15) {
                                            $string = substr($string,0,15);  
                                            $string = trim($string).'...';
                                            $display = 'yes';
                                         }
                                        $stortlink = "<a href='".$linkstr."' target='_blank' data-target='#Link".$count."'>".$string."</a>";
                                    }

                                    // if($news_link != ''){
                                    //     $display = 'yes';
                                    // }
                                    $linktext .= "<a href='".$linkstr."' target='_blank' data-target='#Link".$count."'>Link ".$count."</a>".", ";
                                    $news_link = "<a href='".$linkstr."' target='_blank'>".$linkstr."</a>";   
                                    ?>
                                    <div class="linkanchor" id='Link<?php echo $count;?>'>
                                        <?php echo $news_link;?>
                                    </div>
                             <?php        

                                }
                            }
                            if($showlinktext){
                                echo rtrim(trim($linktext), ',');
                            } else {
                                echo $stortlink;
                            }
                        }else{ echo '&nbsp;'; } ?>
                    <?php if($display == ''){ ?>
                     <div class="tooltip-box6 linkanchor">
                <?php echo $news_link; ?>
                    </div> <?php } ?>
                </td>
                 </tr>
        <tr>
        <td>
            <h4> Price Per Share </h4></td>

        <td class="rgt">
                            <p> <?php echo $price_per_share; ?> </p>
                    </td>
                </tr>
         <tr>
          <?php //if($book_value_per_share > 0) { ?>
            <td>
                <h4> BV Per Share </h4>
            </td>
            <td class="">
                <p> <?php echo (!empty($book_value_per_share)) ? $book_value_per_share : '&nbsp;'; ?> </p>
            </td>
                <?php //} ?>
          <?php //if($price_to_book > 0) { ?>
     </tr>
          <tr>
        <td>
            <h4> Price to Book </h4></td>
        <td class="">                
                              <p> <?php echo (!empty($price_to_book)) ? $price_to_book : '&nbsp;'; ?> </p>
                      </td>
              <?php //} ?>
                </tr>
            <?php //} ?>
                        </tbody>
                    </table>
                 </div>
             </div>
         </div>
         <div class="clear-sm"></div>
    <div  class="work-masonry-thumb1 col-p-12_1 more_info"  style="   border: 1px solid transparent;    border-bottom: 1px solid transparent;margin-right:0px !important;">
            <h3 id="moreinfo" class="moreinfo more-content"  style="border-bottom: 1px solid transparent;">More Info</h3>
                                                           
             <table class="tablelistview moreinfo_1" cellpadding="0" cellspacing="0" >
                  <tr>  <td class="more-info"><p><?php print nl2br($moreinfor); ?></p>
                            <?php if(trim($moreinfor) != ''){
                                echo '<br><br><br>';
                            }?>
                          <p><a id="clickhere" href="mailto:research@ventureintelligence.com?subject=Request for more deal data-<?php echo $pageTitle;?>&body=<?php echo $mailurl;?> ">
                                  Request more information</a> specifying what details you would like. Note: For recent transactions, regulatory filing based information is typically less than that for older ones.
                          </p></td></tr></table>
         </div>
     </div>  
     

    

      <div style="clear:both"></div>  
                  
    </div> 
    <div style="clear:both"></div>
    
    <div class="row masonry ">
<div class="col-6">
     <?php
                                    if(($dec_company_valuation <= 0 && $dec_revenue_multiple <= 0 && $dec_ebitda_multiple <= 0 && $dec_pat_multiple <= 0)){
                                        $field_class_pre = 0;
                                    }else{
                                        $field_class_pre = 1;
                                    }
                                    if($dec_company_valuation1 <= 0 && $dec_revenue_multiple1 <= 0 && $dec_ebitda_multiple1 <= 0 && $dec_pat_multiple1 <= 0){
                                         $field_class_post = 0;
                                    }else{
                                        $field_class_post = 1;
                                    }
                                    if($dec_company_valuation2 <= 0 && $dec_revenue_multiple2 <= 0 && $dec_ebitda_multiple2 <= 0 && $dec_pat_multiple2 <= 0){
                                         $field_class_ev = 0;
                                    }else{
                                        $field_class_ev = 1;
                                    }
                                ?>
    <div  class="work-masonry-thumb1 accordian-group">
                 <div class="accordions">
                    
                    <?php if($field_class_pre !=0 || $field_class_post !=0 || $field_class_ev !=0 ){ ?>
                        <div class="accordions_dealtitle"><span></span>
                            <h2 id="companyinfo" class="box_heading content-box ">Valuation Info</h2>
                        </div>
                        <div class="accordions_dealcontent" >
                     <?php } else { ?>
                        <div class="accordions_dealtitle active"><span></span>
                            <h2 id="companyinfo" class="box_heading content-box ">Valuation Info</h2>
                        </div>
                        <div class="accordions_dealcontent" style="display: none;">
                     <?php } ?>

                     
                        <table cellpadding="0" cellspacing="0" class="tableInvest tableValuation">
                            <tbody>
                         

                                <?php if($field_class_pre !=0 || $field_class_post !=0 || $field_class_ev !=0 ){ ?>

                                
                                    
                                <tr class="tableValuationwidth">
                                  <td style="width: 25%;"><h4>&nbsp;</h4></td>
                                  <?php if($field_class_pre !=0){ ?>
                                        <td style="width: 25%;"><h4 class="<?php echo $field_class_pre; ?> ">Pre-Money</h4></td>
                                  <?php } ?>
                                        <td class="<?php echo $fields_class_both; ?>" style="width: 25%;"><h4 class="">Post-Money</h4></td>
                                  <?php if($field_class_ev !=0){ ?>
                                        <td class="<?php echo $fields_class_ev; echo $fields_class_both;?>" style="width: 25%;"><h4 class="">Enterprise Value</h4></td>
                                  <?php } ?>
                                </tr>
                                <tr class="tableValuationwidth">
                                    <td id="tourinvestor" class="<?php echo $valuation_label; ?>">
                                        <h4>Valuation (&#8377; Cr)</h4>
                                    </td>
                                    <?php if($field_class_pre !=0){ ?>
                                        
                                            <td><p class="<?php echo $field_class_pre; ?>">
                                                <?php
                                                   if($dec_company_valuation > 0)
                                                   { ?>
                                                     <?php  echo $dec_company_valuation; 
                                                   }else{ ?>
                                                           <?php   echo '&nbsp;';
                                                   }  
                                                ?></p>
                                           </td> 
                                   <?php } ?>
                                    
                                    <td class=""><p>
                                     <?php
                                     
                                            if($dec_company_valuation1 > 0 && $dec_company_valuation1 !='')
                                            { 
                                                
                                                ?>
                                              <?php  echo $dec_company_valuation1; 
                                            }else{ 
                                                  
                                                  ?>
                                                    <?php   echo '&nbsp;';
                                            }  ?></p>
                                    </td> 
                                    <?php if($field_class_ev !=0){ ?>
                                    <td class=" <?php echo $field_class_ev; ?>"><p>
                                     <?php
                                            if($dec_company_valuation2 >0 && $dec_company_valuation2 !='')
                                                { ?>
                                              <?php  echo $dec_company_valuation2; 
                                              }else{ ?>
                                                    <?php   echo '&nbsp;';
                                                }  ?></p>
                                    </td> 
                                    <?php } ?>
                                </tr>
                                <tr class="tableValuationwidth">
                                    <td id="tourinvestor" class="<?php echo $valuation_label; ?>">
                                        <h4>Revenue Multiple </h4>
                                    </td>
                                    <?php if($field_class_pre !=0){ ?>
                                    <td class="<?php echo $field_class_pre; ?>"><p>
                                     <?php
                                            if($dec_revenue_multiple > 0)
                                                { ?>
                                              <?php  echo $dec_revenue_multiple; 
                                              }else{ ?>
                                                    <?php   echo '&nbsp;';
                                                }  ?></p>
                                    </td> 
                                    <?php } ?>
                                    <td class=""><p>
                                     <?php
                                            if($dec_revenue_multiple1 >0 && $dec_revenue_multiple1 !='')
                                                { ?>
                                              <?php  echo $dec_revenue_multiple1; 
                                              }else{ ?>
                                                    <?php   echo '&nbsp;';
                                                }  ?></p>
                                    </td>
                                     <?php if($field_class_ev !=0){ ?>
                                    <td class=" <?php echo $field_class_ev; ?>"><p>
                                     <?php
                                            if($dec_revenue_multiple2 >0 && $dec_revenue_multiple2 !='')
                                                { ?>
                                              <?php  echo $dec_revenue_multiple2; 
                                              }else{ ?>
                                                    <?php   echo '&nbsp;';
                                                }  ?></p>
                                    </td> 
                                     <?php } ?>
                                    
                                </tr>
                                <tr class="tableValuationwidth">
                                    <td id="tourinvestor" class="<?php echo $valuation_label; ?>" >
                                        <h4>EBITDA Multiple</h4>
                                    </td>
                                     <?php if($field_class_pre !=0){ ?>
                                        <td class="<?php echo $field_class_pre; ?>"><p>
                                         <?php
                                                if($dec_ebitda_multiple >0 && $dec_ebitda_multiple !='')
                                                    { ?>
                                                  <?php  echo $dec_ebitda_multiple; 
                                                  }else{ ?>
                                                        <?php   echo '&nbsp;';
                                                    }  ?></p>
                                        </td>
                                     <?php } ?>
                                    <td class=""><p class="">
                                     <?php
                                            if($dec_ebitda_multiple1 >0 && $dec_ebitda_multiple1 !='' )
                                                { ?>
                                              <?php  echo $dec_ebitda_multiple1; 
                                              }else{ ?>
                                                    <?php   echo '&nbsp;';
                                                }  ?></p>
                                    </td> 
                                     <?php if($field_class_ev !=0){ ?>
                                        <td class="<?php echo $field_class_ev; ?>"><p>
                                         <?php
                                                if($dec_ebitda_multiple2 >0 && $dec_ebitda_multiple2 !='')
                                                    { ?>
                                                  <?php  echo $dec_ebitda_multiple2; 
                                                  }else{ ?>
                                                        <?php   echo '&nbsp;';
                                                    }  ?></p>
                                        </td>
                                     <?php } ?>
                                   
                                </tr>
                                <tr class="tableValuationwidth">
                                    <td id="tourinvestor" class="<?php echo $valuation_label; ?>">
                                        <h4>PAT Multiple</h4>
                                    </td>
                                     <?php if($field_class_pre !=0){ ?>
                                        <td class="<?php echo $field_class_pre; ?>"><p>
                                         <?php
                                                if($dec_pat_multiple >0 && $dec_pat_multiple !='')
                                                    { ?>
                                                  <?php  echo $dec_pat_multiple; 
                                                  }else{ ?>
                                                        <?php   echo '&nbsp;';
                                                    }  ?></p>
                                        </td> 
                                     <?php } ?>
                                    <td class=""><p>
                                     <?php
                                            if($dec_pat_multiple1 >0 && $dec_pat_multiple1 !='')
                                                { ?>
                                              <?php  echo $dec_pat_multiple1; 
                                              }else{ ?>
                                                    <?php   echo '&nbsp;';
                                                }  ?></p>
                                    </td> 
                                     <?php if($field_class_ev !=0){ ?>
                                    <td class=" <?php echo $field_class_ev; ?>"><p>
                                     <?php
                                            if($dec_pat_multiple2 > 0 && $dec_pat_multiple2 !='')
                                            { ?>
                                                <?php  echo $dec_pat_multiple2; 
                                            }else{ ?>
                                                <?php   echo '&nbsp;';
                                            }  ?></p>
                                    </td> 
                                     <?php } ?>
                                </tr>
                            <?php    //}
                             
                                    $display = 'no'; $string ='';
                                    if(trim($myrow["Valuation"])!="")
                                    {
                                    ?>
                                        <?php
                                       /* foreach($valuationdata as $valdata)
                                        {
                                            if($valdata!="")
                                            { 
                                                print nl2br($valdata);?><?php
                                            }
                                        }*/
                                        $string =trim($myrow["Valuation"]);
                                        $string = strip_tags($string);
                                        if (strlen($string) > 60) { 
                                            $string = substr($string,0,60);
                                            $string = trim($string).'...';
                                            $display = 'yes';
                                        }
                                    }
                                    //if($string !=''){
                                    ?>
                              <tr>
                                  <td class="<?php echo $valuation_label; ?>"><h4>More Info </h4></td>
                                  <td  class="text-child" colspan="3">
                                      <div class="tooltip-2"><p><?php echo $string; ?></p>
                                   </div>
                                      <?php if($display == 'yes'){ ?>
                                    <div class="tooltip-box2">
                                        <?php echo trim($myrow["Valuation"]);?>
                                   </div>
                                      <?php } ?>
                                  </td>
                              </tr>
                                    <?php //} ?>
                                <?php } else { 
                                    if($crossBorder == 1) {
                                    ?>
                                     <tr>
                                        <td style="border-bottom: none !important;padding:0px !important;">
                                            <p  style="padding: 10px;font-size:12px;">Cross border deal - The valuation details are not available since the investment is routed via foreign registered entity. Please proceed to
                                                <!-- <a id="clickhere" href="mailto:database@ventureintelligence.com?subject=Request for more deal data-VC Investment&amp;body=http://localhost/ventureintelligence/dealsnew/dealdetails.php?value=144184063/0/&amp;scr=EMAIL " style="color: #624C34 !important;text-decoration: underline;">Click Here</a> -->
                                                <a id="clickhere" href="mailto:research@ventureintelligence.com?subject=Request for more deal data-<?php echo $pageTitle;?>&body=<?php echo $mailurl;?> " style="color: #624C34 !important;text-decoration: underline;">mail</a> if you are looking for details other than valuation.  
                                           </p>
                                        </td>
                                    </tr>
                                    <?php } else {?>

                                    <tr>
                                        <td style="border-bottom: none !important;padding:0px !important;">
                                            <p class="text-center" style="padding: 10px;"> No data available. 
                                                <!-- <a id="clickhere" href="mailto:database@ventureintelligence.com?subject=Request for more deal data-VC Investment&amp;body=http://localhost/ventureintelligence/dealsnew/dealdetails.php?value=144184063/0/&amp;scr=EMAIL " style="color: #624C34 !important;text-decoration: underline;">Click Here</a> -->
                                                <a id="clickhere" href="mailto:research@ventureintelligence.com?subject=Request for more deal data-<?php echo $pageTitle;?>&body=<?php echo $mailurl;?> " style="color: #624C34 !important;text-decoration: underline;">Click Here</a>  
                                            to request.</p>
                                        </td>
                                    </tr>
                               <?php }}?>
                            </tbody>
                            </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            <div  class="work-masonry-thumb1 accordian-group" >
                 <div class="accordions">
                    
                     <?php if($field_class_pre !=0 || $field_class_post !=0 || $field_class_ev !=0 ){ ?>
                        <div class="accordions_dealtitle"><span></span>
                            <h2 id="companyinfo" class="box_heading content-box ">Investor Info</h2>
                        </div>
                        <div class="accordions_dealcontent" >
                     <?php } else { ?>
                        <div class="accordions_dealtitle active"><span></span>
                            <h2 id="companyinfo" class="box_heading content-box ">Investor Info</h2>
                        </div>
                        <div class="accordions_dealcontent" style="display: none;">
                     <?php } ?>
                     <!-- <div class="accordions_dealcontent"> -->

                        <table cellpadding="0" cellspacing="0" class="tableview tableInvest">             
            <?php
                    $invcount = 0;
                    $amount_val ='empty';
                    if ($_SESSION['investId']) 
                    unset($_SESSION['investId']); 
                    $AddOtherAtLast="";
                    $AddUnknowUndisclosedAtLast="";
                    if ($getcompanyrs = mysql_query($investorSql))
                    {
                       
                        if(mysql_num_rows($getcompanyrs) > 0){ 
                                $investor_ID = $investor_Name = $Amount_INR = $Amount_M = $invID = $invName = $invAmount_INR = $invAmount_M = $investor_ID_A = $investor_Name_A = $Amount_INR_A = $Amount_M_A = $invhideamount=$invhideamount_A = array();
                                $no_amount ='';
                                $leadinvestor = array();
                                $newinvestor = array();
                                $existinvestor = array();
                                While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                {
                                    
                                    $Investorname=trim($myInvrow["Investor"]);
                                    if($myInvrow["InvestorId"] != 9 ){
                                        $leadinvestor[] = $myInvrow["leadinvestor"];
                                        $newinvestor[] = $myInvrow["newinvestor"];
                                        $existinvestor[] = $myInvrow["existinvestor"];
                                    }
                                    /*print_r($leadinvestor);
                                      print_r($newinvestor);*/
                                    $Investorname=strtolower($Investorname);

                                    $invResult=substr_count($Investorname,$searchString);
                                    $invResult1=substr_count($Investorname,$searchString1);
                                    $invResult2=substr_count($Investorname,$searchString2);
                                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                    {
                                         $invID[] = trim($myInvrow["InvestorId"]);
                                         $invName[] = trim($myInvrow["Investor"]);
                                         $invAmount_INR[] = trim($myInvrow["Amount_INR"]);
                                         $invAmount_M[] = trim($myInvrow["Amount_M"]);            
                                         $invhideamount[] = trim($myInvrow["hide_amount"]);
                                    }else{
                                         $investor_ID_A[] = trim($myInvrow["InvestorId"]);
                                         $investor_Name_A[] = trim($myInvrow["Investor"]);
                                         $Amount_INR_A[] = trim($myInvrow["Amount_INR"]);
                                         $Amount_M_A[] = trim($myInvrow["Amount_M"]);      
                                         $invhideamount_A[] = trim($myInvrow["hide_amount"]);
                                    }
                                    if(($myInvrow["Amount_INR"] !='' && $myInvrow["Amount_INR"] != '0.00') || ($myInvrow["Amount_M"] !='' && $myInvrow["Amount_M"] != '0.00')){
                                       $no_amount ='yes';                                                 
                                    }
                                   
                                 }
                                 $investor_ID = array_merge($invID,$investor_ID_A);
                                 $investor_Name = array_merge($invName,$investor_Name_A);
                                 $Amount_INR = array_merge($invAmount_INR,$Amount_INR_A);
                                 $Amount_M = array_merge($invAmount_M,$Amount_M_A);
                                 $hide_amount = array_merge($invhideamount,$invhideamount_A);
                                
                            ?> 
                            <tr>
                                <th style="width: 8%;"></th>
                                <th><h4>Name</h4></th>
                                <th><?php if($global_hideamount==0){ ?><h4 class="title_ctr" style="text-transform: capitalize;">&#8377; Cr</h4> <?php } ?></th>
                                <th><?php if( $global_hideamount==0){ ?><h4 class="title_ctr">$ M</h4> <?php } ?></th>
                                <!-- <?php //if($no_amount =='yes' && $global_hideamount==0){ ?>
                                <th><h4 class="title_ctr" style="text-transform: capitalize;">&#8377; Cr</h4></th>
                                <th><h4 class="title_ctr">$ M</h4></th>
                                <?php //} ?> -->
  </tr>                        
                            <?php for($l=0;$l<count($investor_ID);$l++){ ?>
                                <tr class="accordions_dealtitle1 active" rowspan="2">

                                    <td style="text-align: right;" class="tooltip7">
                                        <div style="text-align: center;display: inline-flex;">
                                        <?php 
                                        $InvestornameNew = '';
                                       /* if($leadinvestor[$l] == 1) {
                                            //$InvestornameNew = trim($investor_Name[$l]). " (L)";
                                            echo "<span class='investorlable'>L</span>";
                                         } else if($newinvestor[$l] == 1) {
                                            //$InvestornameNew = trim($investor_Name[$l]). " (N)";
                                            echo "<span class='investorlable'>N</span>";
                                         } else {
                                            $InvestornameNew = trim($investor_Name[$l]);
                                         }*/
                                         

                                        

                                         if($leadinvestor[$l] == 1) {

                                            //$InvestornameNew = trim($investor_Name[$l]). " (L)";
                                            echo "<span class='investorlable lead' style='margin-right: 8px;'>L</span>";
                                            $leadinvestorvalue="Lead investor";
                                            ?>
                                            <div class="tooltip-box7 leadtip" ><?php echo $leadinvestorvalue;?></div>
                                            <?php
                                         }else {
                                            $InvestornameNew = trim($investor_Name[$l]);
                                         } 
                                         if($existinvestor[$l] == 1) {

                                            //$InvestornameNew = trim($investor_Name[$l]). " (L)";
                                            echo "<span class='investorlable lead'>E</span>";
                                            $existinvestorvalue="Existing investor";
                                            ?>
                                            <div class="tooltip-box7 leadtip" ><?php echo $existinvestorvalue;?></div>
                                            <?php
                                         }else {
                                            $InvestornameNew = trim($investor_Name[$l]);
                                         } 
                                         if($newinvestor[$l] == 1) {
                                            //$InvestornameNew = trim($investor_Name[$l]). " (N)";
                                            echo "<span class='investorlable new'>N</span>";
                                            $newinvestorvalue="New investor";
                                            ?>
                                            <div class="tooltip-box7 newtip" ><?php echo $newinvestorvalue;?></div>
                                            <?php
                                         } else {
                                            $InvestornameNew = trim($investor_Name[$l]);
                                         }

                                        ?>
                                    </div>
                                    </td>
                                    <td <?php if($no_amount !='yes'){ ?>  <?php }?> style="text-transform: capitalize; " class="investoricon">  <h4>    
                                        <?php
                                        $deal=0;
                                         //$AddOtherAtLast="";
                                         $Investorname=trim($investor_Name[$l]);
                                         $InvestornameNew = '';

                                         if($leadinvestor[$l] == 1) {
                                            $InvestornameNew = trim($investor_Name[$l]). " (L)";
                                         } else if($newinvestor[$l] == 1) {
                                            $InvestornameNew = trim($investor_Name[$l]). " (N)";
                                         } else {
                                            $InvestornameNew = trim($investor_Name[$l]);
                                         }
                                         $Investorname=strtolower($Investorname);

                                         $invResult=substr_count($Investorname,$searchString);
                                         $invResult1=substr_count($Investorname,$searchString1);
                                         $invResult2=substr_count($Investorname,$searchString2);
                                         $getfundSql ='SELECT peinv.PEId,peinv.InvestorId,fn.fundName,peinv.fundId,peinv.Amount_M,peinv.Amount_INR FROM fundNames AS fn,peinvestment_funddetail as peinv,peinvestors as inv where fn.fundId= peinv.fundId and  inv.InvestorId=peinv.InvestorId and peinv.PEId='.$IPO_MandAId.' and peinv.InvestorId='.$investor_ID[$l];  
                                         $abcd=mysql_query($getfundSql);
                                         $fundname_cnt=mysql_num_rows($abcd);
                                         if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                         {
                                             $_SESSION['investId'][$invcount++] = $investor_ID[$l];
                                         $deal=0; ?><a id="investor<?php echo $investor_ID[$l]; ?>" class="tourinvestor<?php echo $investor_ID[$l]; ?>" style="color:#000 !important;text-decoration:none;" href='dirdetails.php?value=<?php echo $investor_ID[$l].'/'.$VCFlagValue.'/'.$deal.'/'.$strvalue[3];?>'  target="_blank"><?php echo $investor_Name[$l]; ?></a><?php if($fundname_cnt>=1){?><i class="fa fa-plus"></i><?php } ?>
                                        <?php
                                         }
                                          elseif(($invResult==1) || ($invResult1==1)){
                                                  echo $Investorname;
                                          }
                                          elseif($invResult2==1)
                                          {
                                                  echo $Investorname;
                                                  } ?></h4>
                                    </td>
                                    <td class="">
                                    <?php if($no_amount =='yes' ){ ?>
                                        <p class="content-align"><?php if($hide_amount[$l]==0 && $global_hideamount==0 && $Amount_INR[$l]!='0.00') { echo $Amount_INR[$l]; }else{ echo '';} ?></p>
                                        <?php } ?>
                                    </td>
                                    <td class="">
                                    <?php if($no_amount =='yes' ){ ?>
                                        <p class="content-align"><?php if($hide_amount[$l]==0 && $global_hideamount==0 && $Amount_M[$l]!='0.00') { echo $Amount_M[$l]; }else{ echo '';} ?></p>
                                        <?php } ?>
                                    </td>
                                </tr><?php 
                                   // if ($getcompanyrs = mysql_query($investorSql))
                                    // {
                                    //  While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                    //  {
                                        $_SESSION['investId'][$invcount++] = $investor_ID[$l];
                                   
                                    //echo $getfundSql;
                                    $no_amountfund='';
                                    
                                      ?>
                                      
                                      
                                      <?php if($rsfund = mysql_query($getfundSql))
                                    {
                                        
                                       while($myfundrow=mysql_fetch_array($rsfund, MYSQL_BOTH))
                                       { 
                                          
                                           ?>
                                       <tr class="childaccordions" style="display: none;">
                                        <td style="text-align: center;" class="tooltip7">
                                        </td>
                                        <td>    
                                            <p id="investor<?php echo $investor_ID[$l]; ?>" class="tourinvestor<?php echo $investor_ID[$l]; ?>" style="color:#000 !important;text-decoration:none;" ><?php echo $myfundrow['fundName']; ?></p>
                                        </td>
                                       <?php if(($myfundrow["Amount_INR"] !='' && $myfundrow["Amount_INR"] != '0.00' && $myfundrow["Amount_INR"] != 0.00) || ($myfundrow["Amount_M"] !='' && $myfundrow["Amount_M"] != '0.00' && $myfundrow["Amount_M"] != 0.00)){
                                       $no_amountfund ='yes';
                                                                            
                                    }?>
                                        <td class="">
                                        <?php if($no_amountfund =="yes" ){ ?>
                                            <p class="content-align"><?php if($hide_amount[$l]==0 && $global_hideamount==0 && $myfundrow['Amount_INR'] !='0.00') { echo $myfundrow['Amount_INR']; }else{ echo '';} ?></p>
                                        <?php } else{?><p></p><?php } ?>
                                        </td>
                                        <td class="">
                                        <?php if($no_amountfund =="yes" ){ ?>
                                            <p class="content-align"><?php if($hide_amount[$l]==0 && $global_hideamount==0 && $myfundrow['Amount_M'] !='0.00') { echo $myfundrow['Amount_M']; }else{ echo '';} ?></p>
                                            <?php } else{?><p></p><?php } ?>
                                        </td>
                                       
                                        </tr>
                                        <?php 
                                    } 
                                   }?>
                                       
                                        
                                            
                                    
                                       

                                <?php } ?> 
                             <?php   } ?>
                                    <?php if($no_amount =='yes'){ ?>
                            <!-- <tr>
                                 <td><h4>Investor Type</h4></td>
                                <td colspan="4" ><?php echo $myrow["InvestorTypeName"] ;?></td> 
                            </tr>  -->
                                    <?php } else{ ?>
                           <!--  <td colspan="2"><h4>Investor Type: <?php echo $myrow["InvestorTypeName"] ;?></h4></td> -->
                          <!--  <tr>
                                 <td><h4>Investor Type</h4></td>
                                <td colspan="2"><?php echo $myrow["InvestorTypeName"] ;?></td> 
                          </tr>  -->
                                    <?php }
                    }?>
                </table>

                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="row masonry ">
        <div class="col-6">
            <div  class="work-masonry-thumb1 accordian-group">
                 <div class="accordions">
                    <div class="accordions_dealtitle active"><span></span>
                    <h2 id="companyinfo" class="box_heading content-box ">Financials</h2>
                    </div>
                     <div class="accordions_dealcontent" style="display: none;">
                        <table cellspacing="0" cellpadding="0" class="tableInvest tablefin">
                            <tbody>

                                <?php if($dec_revenue == 0 && $Total_Debt == 0 && $dec_ebitda == 0 && $Cash_Equ == 0 && $dec_pat == 0){ ?>
                                    <tr>
                                        <td style="border-bottom: none !important;">
                                            <p class="text-center" style="padding: 10px;"> No data available.</p>
                                        </td>
                                    </tr>
                                <?php } else { ?>
                                <tr>
                                    <td>
                                        <table class="innertable">
                                            <tbody>

                                                <tr>
                                                    <td></td>
                                                    <td>
                                                        <h4><?php echo $financial_year; ?> (&#8377; Cr)</h4>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <table class="innertable">
                                            <tbody>
                                                <tr>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="innertable">
                                            <tbody>
                                                <tr>
                                                    <td>Revenue</td>
                                                    <td>
                                                        <p>
                                                            <?php if($dec_revenue < 0 || $dec_revenue > 0) { 
                                                                 echo $dec_revenue;
                                                            } else{
                                                                if($dec_company_valuation >0 && $dec_revenue_multiple >0){ ?>
                                                                    <?php echo  number_format($dec_company_valuation/$dec_revenue_multiple, 2, '.', '');      
                                                                }else{ ?>
                                                                    <?php echo "&nbsp;";
                                                                }
                                                            }?>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <table class="innertable">
                                            <tbody>
                                                <tr>
                                                    <td>Total Debt</td>
                                                    <td><p><?php echo (!empty($Total_Debt)) ? $Total_Debt : '&nbsp;'; ?></p></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="innertable">
                                            <tbody>
                                                <tr>
                                                    <td>EBITDA</td>
                                                    <td>
                                                        <p>
                                                             <?php 
                                                            if($dec_ebitda < 0 || $dec_ebitda > 0)
                                                            { ?>
                                                                 <?php echo $dec_ebitda;
                                                            }else{
                                                                if($dec_company_valuation >0 && $dec_ebitda_multiple >0){ ?>
                                                                 <?php 
                                                                    echo  number_format($dec_company_valuation/$dec_ebitda_multiple, 2, '.', '');
                                                                }else{ ?>
                                                                <?php 
                                                                    echo "&nbsp;";
                                                                }            
                                                            }?>  
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <table class="innertable">
                                            <tbody>
                                                <tr>
                                                    <td>Cash & Cash Equ.</td>
                                                    <td><p><?php echo (!empty($Cash_Equ)) ? $Cash_Equ : '&nbsp;'; ?></p></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <table class="innertable">
                                            <tbody>
                                                <tr>
                                                    <td>PAT</td>
                                                    <td>
                                                        <p>
                                                           <?php
                                                            if($dec_pat < 0 || $dec_pat > 0)
                                                            { ?>
                                                                <?php
                                                                    echo $dec_pat;                
                                                                } 
                                                                else{ ?>
                                                                <?php
                                                                    if($dec_company_valuation >0 && $dec_pat_multiple >0){
                                                                        echo number_format($dec_company_valuation/$dec_pat_multiple, 2, '.', '');
                                                                    }else{ ?>
                                                                <?php
                                                                        echo "&nbsp;";                    
                                                                    }
                                                            } ?>
                                                        </p>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td>
                                        <?php echo "&nbsp;"; ?>  
                                    </td>
                                </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6">
            
           <?php 
            if($getcompanyrs= mysql_query($advcompanysql))
            {
                $comp_cnt = mysql_num_rows($getcompanyrs);
            }
            if($rsinvcomp= mysql_query($advinvestorssql)) {
                $compinv_cnt = mysql_num_rows($rsinvcomp);
            }
            $totalInvestor = count($investor_ID);
            $totalAdvisor = $comp_cnt + $compinv_cnt;
            ?> 
        <div  class="work-masonry-thumb1 accordian-group" >
                 <div class="accordions">
                    <div class="accordions_dealtitle active"><span></span>
                    <h2 id="companyinfo" class="box_heading content-box ">Advisor Info</h2>
                    </div>
                     <div class="accordions_dealcontent" style="display: none;">
                        
                        <table cellspacing="0" cellpadding="0" class="tableInvest advisor_Table">
                            <tbody>
                           <?php if($comp_cnt>0 || $compinv_cnt>0){ ?>  
                            <?php if($comp_cnt>0) { ?>
                                    <tr>
                                        <td style="width: 20%;">
                                                                          <h4 style="padding-top: 8px;">To Company</h4></td>
                                        <td style="">
                                            <table cellspacing="0" cellpadding="0" class="tableInvest" style="border-left: 1px solid #ccc;">
                                                <tbody>
                                                    
                                                    <tr>
                                                        
                                                        <td>
                                                            <table class="advisor_innerTable">
                                                                <?php $firstChild = 0; While($myadcomprow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH)) { ?>
                                                                    <tr>
                                                                                                                                   
                                                                        <td class="">
                                                                            <p><a href='advisor.php?value=<?php echo $myadcomprow["CIAId"];?>/1/<?php echo $flagvalue?>' target="_blank" style="color: #666 !important;">
                                                                            <?php echo $myadcomprow["cianame"]; ?></a> (<?php echo $myadcomprow["AdvisorType"];?>)
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                <?php } ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </td>
                                        
                                    </tr>
                                <?php } ?>
                                <?php if($compinv_cnt>0) { ?>
                                    <tr>
                                         <td style="width: 20%;">
                                                                            <h4 style="padding-top: 8px;">To Investor</h4>
                                                                           </td>
                                        <td>
                                            <table cellspacing="0" cellpadding="0" class="tableInvest" style="border-left: 1px solid #ccc;">
                                                <tbody>
                                                    
                                                    <tr>
                                                        
                                                        <td>
                                                            <table class="advisor_innerTable advisor_innerTable1">
                                                               <?php if ($getinvestorrs = mysql_query($advinvestorssql)) { ?>
                                                                    <?php $firstChild = 0; While($myadinvrow=mysql_fetch_array($getinvestorrs, MYSQL_BOTH)) {  ?>
                                                                        <tr>
                                                                           
                                                                            <td class="">
                                                                                <p>
                                                                                    <a href='advisor.php?value=<?php echo  $myadinvrow["CIAId"];?>/1/<?php echo $flagvalue?>' target="_blank" style="color: #666 !important;">
                                                                                    <?php echo $myadinvrow["cianame"]; ?> </a> (<?php echo $myadinvrow["AdvisorType"];?>)
                                                                                </p>
                                                                            </td>
                                                                        </tr>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                <?php } ?>
                                 <?php } else { ?>
                                        <tr>
                                            <td style="border-bottom: none !important;">
                                                <p class="text-center" style="padding: 10px;"> No data available. </p>
                                            </td>
                                        </tr>
                                 <?php } ?>
                            </tbody>
                        </table>
                        
                        
                    </div>
                </div>
            </div>
        </div>

    </div>

   <div class="row masonry ">
        <div class="col-6">
            <div  class="work-masonry-thumb1 accordian-group">
             
                    <div class="accordions" style="margin-bottom: 15px;">
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
                                <div class="tagelements">
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
                            echo '<p class="text-center" style="font-size:10pt;font-weight:600;padding: 10px;"> No data available. </p>';
                        }?>
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
                        <div class="">
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
                            <div <?php if($s != 0) { ?>style="border-top: 1px solid #d4d4d4;"<?php } ?>>
                            <?php
                                                while($myrow1=mysql_fetch_array($CompanyQuery, MYSQL_BOTH))
                                                { 
                                                    if(!in_array($myrow1["PECompanyId"], $company_id)){                                    
                                                        $company_id[] = $myrow1["PECompanyId"]; ?>
                                                        <div class="tagelements">
                                                            <span><a href="companydetails.php?value=<?php echo $myrow1["PECompanyId"].'/'.$VCFlagValue.'/';?>" target="_blank"><?php echo $myrow1['companyname']; ?></a></span>
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
                                echo '<p class="text-center" style="font-size:10pt;font-weight:600;padding: 10px;"> No data available. </p>';
                            }?>                    
                        </div>  
                        <?php
                                } else {
                                    echo '<p class="text-center" style="font-size:10pt;font-weight:600;padding: 10px;"> No data available. </p>';
                                }?>
                </div>
             </div>
             
             </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-12" style="margin-top: -7px;">
                <?php 

                        $investor_cnt=0;
                        
                        $investorGroupSql="select pe.PEId as DealId,peinv.PEId,peinv.InvestorId,inv.Investor,DATE_FORMAT( dates, '%b-%Y' ) as dt,AggHide,SPV,pe.stakepercentage,pe.hidestake,pe.Amount_INR,pe.hideamount,pe.Company_Valuation,
                    GROUP_CONCAT( inv.Investor,CASE WHEN peinv.leadinvestor = 1 THEN ' (L)' ELSE '' END,CASE WHEN peinv.newinvestor = 1 THEN ' (N)' ELSE '' END ORDER BY inv.InvestorId) as Investors,GROUP_CONCAT( inv.InvestorId ORDER BY inv.InvestorId) as InvestorIds from
                            peinvestments as pe, peinvestments_investors as peinv,pecompanies as pec,
                            peinvestors as inv where pe.PECompanyId='$PECompanyId' and
                            peinv.PEId=pe.PEId and inv.InvestorId=peinv.InvestorId and pe.Deleted=0
                            and pec.PEcompanyId=pe.PECompanyId and pec.industry!=15 and peinv.InvestorId!=9 group by DealId order by dates desc";
                            
                                //echo $investorGroupSql;
                      
                         $maexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business, inv.Investor,
                                        DealAmount, DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.MandAId ,pe.ExitStatus, pe.DealTypeId, dt.DealType,GROUP_CONCAT( inv.Investor ORDER BY inv.InvestorId) as Investors
                                        FROM manda AS pe, industry AS i, pecompanies AS pec,manda_investors as mi ,peinvestors as inv, dealtypes AS dt
                                         WHERE  i.industryid=pec.industry
                                        AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId='$PECompanyId'
                                        and inv.InvestorId=mi.InvestorId and mi.MandAId=pe.MandAId and pe.DealTypeId=dt.DealTypeId 
                                        group by dt order by DealDate desc";

                                      //  echo "<br>-- ".$maexitsql;

                        $ipoexitsql="SELECT pe.PECompanyId, pec.companyname, pec.industry, i.industry, pec.sector_business,inv.Investor,
                                    IPOAmount, DATE_FORMAT( IPODate, '%b-%Y' ) as dt, pe.IPOId ,pe.ExitStatus,GROUP_CONCAT( inv.Investor ORDER BY inv.InvestorId) as Investors
                                    FROM ipos AS pe, industry AS i, pecompanies AS pec,ipo_investors as ipoi,peinvestors as inv
                                     WHERE  i.industryid=pec.industry
                            AND pec.PEcompanyId = pe.PECompanyId and pe.Deleted=0 and pec.industry !=15 and pe.PECompanyId='$PECompanyId'
                            and inv.InvestorId=ipoi.InvestorId and ipoi.IPOId=pe.IPOId
                             group by dt order by IPODate desc";
                             // echo "<br>".$ipoexitsql;

                      
                                 $angelinvsql=   " SELECT pe.InvesteeId, pe.AggHide, pec.companyname, pec.industry, i.industry, pec.sector_business,
                                    DATE_FORMAT( DealDate, '%b-%Y' ) as dt, pe.AngelDealId ,peinv.InvestorId,inv.Investor,GROUP_CONCAT( inv.InvestorId ORDER BY inv.Investor ) as InvestorIds, GROUP_CONCAT( inv.Investor ORDER BY inv.Investor) as Investors
                                    FROM angelinvdeals AS pe, industry AS i, pecompanies AS pec,
                                    angel_investors as peinv,peinvestors as inv
                                     WHERE  i.industryid=pec.industry AND pec.PEcompanyId = pe.InvesteeId and 
                                     pe.Deleted=0 and pec.industry !=15 and pe.InvesteeId='$PECompanyId'
                                     and  peinv.AngelDealId=pe.AngelDealId and inv.InvestorId=peinv.InvestorId and peinv.InvestorId!=9 group by AngelDealId order by dt desc ";
                                  //   echo "<br> ".$angelinvsql;
                                     $incubatorSql="SELECT pe.IncDealId,pe.IncubatorId,inc.Incubator,DATE_FORMAT( date_month_year, '%M-%Y' ) as dt FROM
                            `incubatordeals` as pe, incubators as inc WHERE IncubateeId =$PECompanyId
                            and pe.IncubatorId= inc.IncubatorId ";

                        if($investorGroupSql!="")
                        {
                          if($getcompanyrs= mysql_query($investorGroupSql))
                          {
                              $investor_cnt = mysql_num_rows($getcompanyrs);
                          }
                        }

                       ?>
                            <div  class="work-masonry-thumb1 accordian-group" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                                 <div class="accordions">
                                    <div class="accordions_dealtitle active"><span></span>
                                    <h2 id="companyinfo" class="box_heading content-box ">Investments and Exits Snapshot</h2>
                                    </div>
                                     <div class="accordions_dealcontent" style="display: none;padding-top: 20px;">
                                        <?php 

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

                                        ?>
                                        <ul class="tabView">
                                            <?php
                                            if($incubator_cnt>0) { ?> 
                                                <li href="#incubation">INCUBATION</li>
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

                                            <div id="incubation" class="tab-items">
                                                <?php
                                                     
                                                        if($incubator_cnt>0)
                                                        {
                                                    ?>   
                                                   
                                                   <div  class="col-md-6">
                                                    <table width="100%" cellspacing="0" cellpadding="0" class="tableview tableInvest" >
                                                         <thead><tr><th>Incubator Name</th><th>Deal Period</th></tr></thead>
                                                        <tbody>
                                                            <?php  
                                                                While($incrow=mysql_fetch_array($incrs, MYSQL_BOTH))
                                                                {
                                                                    $incubator=$incrow["Incubator"];
                                                                    $incubatorId=$incrow["IncubatorId"];
                                                                    $incubatordate=$incrow["dt"];?>
                                                            <tr><td><a href='incubatordetails.php?value=<?php echo $incubatorId.'/'.$VCFlagValue;?>' title="Incubator Details" target="_blank"> <?php echo $incubator;?> </a> </td>
                                                                <td><a href='incubatordetails.php?value=<?php echo $incubatorId.'/'.$VCFlagValue;?>' target="_blank"> <?php echo $incubatordate;?></a></td>
                                                            </tr>
                                                             <?php  }?>
                                                              </tbody>
                                                    </table>
                                                    </div>  

                                                 <?php } ?>
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
                                                            //$Investorname=strtolower($Investorname);

                                                            $InvestorsName = explode(",",$angelrow["Investors"]);
                                                            $InvestorIds = explode(",",$angelrow["InvestorIds"]);
                                                            $hide_agg = $angelrow['AggHide'];
                                                            $invRes=substr_count($Investorname,$searchString);
                                                                    $invRes1=substr_count($Investorname,$searchString1);
                                                                    $invRes2=substr_count($Investorname,$searchString2);


                                                                    if(($invRes==0) && ($invRes1==0) && ($invRes2==0))
                                                                    {
                                                                        if($hide_agg==0) {

                                            ?>
                                                                    <tr>
                                                                       <!--  <td class="investname">
                                                                                        <?php 
                                                                                        for ($i=0; $i < sizeof($InvestorsName); $i++) { ?>
                                                                                            <a href='<?php echo $invpage;?>?value=<?php echo $InvestorIds[$i].'/'.$VCFlagValue.'/'.$deal;?>' title="Investor Details"><?php echo $InvestorsName[$i]; ?></a>
                                                                                            <span>,</span>
                                                                                       <?php } ?>
                                                                                    </td> -->
                                                                        <td style="alt" class="angelinvestname">
                                                                             <?php 
                                                                                        for ($i=0; $i < sizeof($InvestorsName); $i++) { ?>
                                                                             <a href='angleinvdetails.php?value=<?php echo $InvestorIds[$i].'/'.$VCFlagValue;?>' ><?php echo $InvestorsName[$i];  ?></a><span>,</span>
                                                                                       <?php } ?>
                                                                                    </td>

                                                                    <td> <a href="angeldealdetails.php?value=<?php echo $angelrow["AngelDealId"].'/'.$VCFlagValue;?>" >
                                                                                            <?php echo $angelrow["dt"];?></a></td>
                                                                                        </tr>

                                            <?php
                                                                        } else { ?>
                                                                            <tr><td style="alt" class="angelinvestname"> 
                                                                                <?php 
                                                                                        for ($i=0; $i < sizeof($InvestorsName); $i++) { ?>
                                                                             <a href='angleinvdetails.php?value=<?php echo $InvestorIds[$i].'/'.$VCFlagValue;?>' ><?php echo $InvestorsName[$i]; ?></a><span>,</span>
                                                                                       <?php } ?></td>

                                                                    <td> <a href="angeldealdetails.php?value=<?php echo $angelrow["AngelDealId"].'/'.$VCFlagValue;?>" >
                                                                                            <?php echo $angelrow["dt"];?></a></td>
                                                                                        </tr>
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

                                            <div id="investments" class="tab-items activetab">
                                                <?php if($investor_cnt > 0){ ?>
                                                    <div class="col-md-6">
                                                    <table width="100%" cellspacing="0" cellpadding="0" class="tableview tableInvest">
                                                        <thead>

                                                            <tr>
                                                                <th style="display: inline-flex;width: 100%;"><p style="color:#000;">Investor Name</p> <a style="margin-top: 0px !important;cursor: pointer;  float: right !important;" class="help-icon tooltip"><img width="15" height="15" border="0" src="images/help.png" alt="" style="vertical-align:middle">
                                                                <span style="width: 23%;left: 137px;top: 155px;text-transform: capitalize;">
                                                                <img class="showtextlarge" src="images/callout.gif" style="left: 5px;">
                                                                L = Lead Investor; N = New Investor

                                                                </span>
                            </a></th> 
                                                                <th>Deal Period</th>
                                                                <th class="table-width1">Deal Amount (&#8377; <span style="text-transform: capitalize;">Cr</span>)</th>
                                                                <th class="table-width2">Stake</th>
                                                                <th class="table-width3">Valuation (&#8377; <span style="text-transform: capitalize;">Cr</span>)</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                             <?php

                                                                $addTrancheWord ="";
                                                                $addDebtWord="";
                                                                $addTrancheWordtxt = "";
                                                                While($myInvestorrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                                                        {
                                                                          
                                                                                $Investorname=trim($myInvestorrow["Investor"]);

                                                                                $InvestorsName = explode(",",$myInvestorrow["Investors"]);
                                                                                $InvestorIds = explode(",",$myInvestorrow["InvestorIds"]);
                                                                                if($myInvestorrow["hidestake"]!=1)
                                                                                {
                                                                                if($myInvestorrow["stakepercentage"]>0) {
                                                                                    $hidestake=$myInvestorrow["stakepercentage"]." %";
                                                                                } else {
                                                                                    $hidestake="&nbsp;";
                                                                                }
                                                                                }
                                                                                else
                                                                                {
                                                                                    $hidestake="&nbsp;";  
                                                                                }
                                                                                if($myInvestorrow["Company_Valuation"]>0) {
                                                                                    $companyValuation=$myInvestorrow["Company_Valuation"];
                                                                                } else {
                                                                                    $companyValuation="&nbsp;";
                                                                                }
                                                                                // if($myInvestorrow["hideamount"] ==1 ) {
                                                                                //     $Amount_INR=$myInvestorrow["Amount_INR"];
                                                                                // } else {
                                                                                //     $Amount_INR="--";
                                                                                // }
                                                                                ///$Amount_INR=$myInvestorrow["Amount_INR"];
                                                                                if($myInvestorrow["hideamount"]!=1 && $myInvestorrow["Amount_INR"] !='' && $myInvestorrow["Amount_INR"] !='0.00'){  
                                                                                  $Amount_INR=$myInvestorrow["Amount_INR"]; 
                                                                                }else{
                                                                                    $Amount_INR="&nbsp;";    
                                                                                }
                                                                                $Investorname=strtolower($Investorname);
                                                                                $invResult=substr_count($Investorname,$searchString);
                                                                                $invResult1=substr_count($Investorname,$searchString1);
                                                                                $invResult2=substr_count($Investorname,$searchString2);

                                                                                if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                                                                {
                                                                                   $addTrancheWord="";
                                                                                   $addDebtWord="";
                                                                                    if(($pe_re==0) || ($pe_re==1) || ($pe_re==8) )
                                                                                    {
                                                                                        if($myInvestorrow["AggHide"]==1){
                                                                                            $addTrancheWord = "; NIA";
                                                                                            $addTrancheWordtxt = $addTrancheWord;
                                                                                        }
                                                                                        else{
                                                                                            $addTrancheWord="";
                                                                                        }
                                                                                    }
                                                                                    else
                                                                                        $addTrancheWord="";
                                                                                        if($myInvestorrow["SPV"]==1)
                                                                                            $addDebtWord="; Debt";
                                                                                        else
                                                                                            $addDebtWord="";

                                                                ?>
                                                            <?php $deal=0; ?>
                                                            <tr>
                                                                <td class="investname">
                                                                    <?php 
                                                                    for ($i=0; $i < sizeof($InvestorsName); $i++) { ?>
                                                                        <a href='dirdetails.php?value=<?php echo $InvestorIds[$i].'/'.$VCFlagValue.'/'.$deal;?>' title="<?php echo $InvestorsName[$i]; ?>" target="_blank"><?php echo $InvestorsName[$i]; ?></a><span>,</span>
                                                                   <?php } ?>
                                                                </td>
                                                                <td><a class="postlink" href="dealdetails.php?value=<?php echo $myInvestorrow["DealId"].'/'.$VCFlagValue;?>" title="Deal Details"><?php echo $myInvestorrow["dt"];?></a><?php echo $addTrancheWord;?><?php echo $addDebtWord;?></td>                                                          
                                                                <td class="table-width1"><?php echo $Amount_INR; ?></td>   
                                                                <td class="table-width2"><?php echo $hidestake; ?></td> 
                                                                <td class="table-width3"><?php echo $companyValuation; ?></td> 
                                                            </tr>                                                         
                                                     <?php 
                                                          }
                                                           } 
                                                    ?>  
                                                        </tbody>
                                                    </table> 
                                                     </div>
                                                     <?php } ?>
                                            </div>

                                            <div id="exits" class="tab-items">
                                                <?php 

                                                if(($ipoexit_cnt>0)||($mandaexit_cnt>0 ))
                                                {

                                                ?>  
                                                <div  class="col-md-6">
                                                <table width="100%" cellspacing="0" cellpadding="0" class="tableview tableInvest" >
                                                <thead><tr><th>Deal Type</th><th style="width: 28%;">Investor(s)</th> <th>Deal Period</th> <th>Status</th></tr></thead>
                                                <tbody>
                                                        <?php
                                                        //if($rsipoexit= mysql_query($ipoexitsql))
                                                        //{
                                                        While($ipoexitrow=mysql_fetch_array($rsipoexit, MYSQL_BOTH))
                                                        {
                                                            $InvestorsName = explode(",",$ipoexitrow["Investors"]);
                                                          $exitstatusvalueforIPO=$ipoexitrow["ExitStatus"];
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

                                                        <td> <a href='ipodealdetails.php?value=<?php echo $ipoexitrow["IPOId"].'/'.$VCFlagValue;?>' target="_blank"><?php echo $ipoexitrow["dt"];?></a></td>

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
                                                          if($exitstatusvalue==0)
                                                           {$exitstatusdisplay="Partial Exit";}
                                                          elseif($exitstatusvalue==1)
                                                          {  $exitstatusdisplay="Complete Exit";}
                                                        ?>

                                                        <tr><td style="alt" ><!--M&A--> <?php echo $mymandaexitrow["DealType"] ?></td>
                                                            <td class="angelinvestname">
                                                                 <?php 
                                                                for ($i=0; $i < sizeof($InvestorsName); $i++) { ?>
                                                                    <?php echo $InvestorsName[$i]; ?><span>,</span>
                                                               <?php } ?>
                                                            </td>

                                                            <!-- <td><?php echo $mymandaexitrow["Investor"];?></td> -->

                                                        <td> <a href='mandadealdetails.php?value=<?php echo $mymandaexitrow["MandAId"].'/'.$VCFlagValue;?>' target="_blank"><?php echo $mymandaexitrow["dt"];?></a></td>

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

                                        </div>
                                        
                                         
                                               
                                         
                                     
                
                        <div style="clear: both;"></div>
                         <?php if($addTrancheWordtxt == "; NIA"){ ?>
                                           <p class="note-nia" >*NIA - Not Included for Aggregate</p>
                                       <?php }?>
                               </div>
                               
                              
                       
                               
                                    </div>
                                </div>
                                <div class="col-12" >
    <div class="accordions">
   
    <?php 
    $acquirersql ="SELECT AcquirerId FROM acquirers WHERE Acquirer LIKE '".trim($myrow['companyname'])."%'";
    $acquirer= mysql_query($acquirersql);
    while($myacq=mysql_fetch_array($acquirer)){
    $acqarr[]=$myacq['AcquirerId'];
    }
    
    $acqval=implode(",",$acqarr);
    $cinno = $cinno;
    $orderby=$_POST['orderby'];

    // Order by code
    if($orderby=='companyname')
    {
        $order_query = 'companyname';
        if($_POST['order'] == 'asc'){
            
            $order_status = $order_company = 'desc';
        }else{
            $order_status = $order_company ='asc';
        }
        
    }else{
        $order_company = 'asc';
    }
    
    if($orderby=='sector_business'){
        
       $order_query = 'sector_business';
        if($_POST['order']=='asc'){
            
            $order_status = $order_sector = 'desc';
       }else{
            $order_status = $order_sector = 'asc';
        }
    }else{
        $order_sector = 'asc';
    }
    
    if($orderby=='acquirer'){
        
        $order_query = 'acquirer';
        if($_POST['order']=='asc'){
            
            $order_status = $order_acquirer = 'desc';
        }else{
            $order_status = $order_acquirer = 'asc';
        }
    }else{
        $order_acquirer = 'asc';
    }
    
    if($orderby=='dates'){
        
        $order_query = 'dates';
        if($_POST['order'] =='desc'){
            $order_status = $order_dates = 'asc';
            
        }else{
            $order_status = $order_dates = 'desc';
        }
    }else{
        $order_dates = 'desc';
    }
    
   
    
    if($orderby=='amount'){
        
        $order_query = 'amount';
        if($_POST['order'] == 'asc'){
            
            $order_status = $order_amount = 'desc';
        }else{
            $order_status = $order_amount = 'asc';
        }
    }else{
        $order_amount =  'asc';
    }
    $order = $order_status ? $order_status:'asc';
    $query_orderby = $order_query?$order_query : 'companyname';
            
    if(count($myrow) > 0 && $myrow['PECompanyId']!=''){
        if($order_query == "acquirer" || $order_query == "companyname" || $order_query == "sector_business"  || $order_query =="amount" ){
            $order1 ='ORDER  BY CASE WHEN c.pecompanyid = '.$myrow['PECompanyId'].' THEN 1 ELSE 2 END, '.$query_orderby.' '. $order .',dealdate DESC';
        }elseif($order_query == "dates" ){
            $order1 ='ORDER  BY CASE WHEN c.pecompanyid = '.$myrow['PECompanyId'].' THEN 1 ELSE 2 END, dealdate '.$order;
        }else{
            $order1 ='ORDER  BY CASE WHEN c.pecompanyid = '.$myrow['PECompanyId'].' THEN 1 ELSE 2 END, dealdate DESC,'.$query_orderby.' '.$order;
        }
        if($acqval !=""){
            $acqvar=" ac.acquirerid IN ( ".$acqval." )";
        }else{
            $acqvar="";
        }
        if($acqval !="" && $myrow['PECompanyId'] !=''){
            $orcond=" or ";
        }else{
            $orcond="";
        }
        if($myrow['PECompanyId'] !=''){
        $companyvar="  c.pecompanyid =".$myrow['PECompanyId'];
        }else{
            $companyvar="";
        }
        $sql = "SELECT peinv.pecompanyid, 
        peinv.mamaid, 
        c.companyname, 
        c.industry, 
        i.industry, 
        sector_business                AS sector_business, 
        peinv.amount, 
        peinv.acquirerid, 
        ac.acquirer, 
        peinv.asset, 
        peinv.hideamount, 
        agghide, 
        Date_format(dealdate, '%b-%Y') AS dates, 
        dealdate                       AS DealDate 
 FROM   acquirers AS ac, 
        mama AS peinv, 
        pecompanies AS c, 
        industry AS i 
 WHERE  dealdate BETWEEN '2004-1-01' AND '2020-10-31' 
        AND ac.acquirerid = peinv.acquirerid 
        AND c.industry = i.industryid 
        AND c.pecompanyid = peinv.pecompanyid 
        AND peinv.deleted = 0 
        AND c.industry != 15 
        AND ( $acqvar $orcond $companyvar ) 
        AND c.industry IN ( 49, 14, 9, 25, 
                            24, 7, 4, 16, 
                            17, 23, 3, 21, 
                            1, 2, 10, 54, 
                            18, 11, 66, 106, 
                            8, 12, 22 ) ".$order1;
        ///*AND pe.PEId NOT IN ( SELECT PEId FROM peinvestments_dbtypes AS db WHERE DBTypeId = 'SV' AND hide_pevc_flag =1 ) */
        
        $pers = mysql_query($sql);   
           //echo $sql;    
        //$FinanceAnnual = mysql_fetch_array($financialrs);
        $cont=0;$pedata = array();$totalInv=0;$totalAmount=0;$totalINRAmount=0;$hidecount=0;$hideinrcount=0;
        While($myrow=mysql_fetch_array($pers, MYSQL_BOTH)) // while process to count total deals and amount and data save in array
        {
            
            $amtTobeDeductedforAggHide=0;
            $inramtTobeDeductedforAggHide=0;
            $NoofDealsCntTobeDeducted=0;
            
            if($myrow["AggHide"]==1 && $myrow["SPV"]==0)
            {
                $NoofDealsCntTobeDeducted=1;
                $amtTobeDeductedforAggHide=$myrow["amount"];
                $inramtTobeDeductedforAggHide=$myrow["Amount_INR"];
                
            }elseif($myrow["SPV"]==1 && $myrow["AggHide"]==0){

                $NoofDealsCntTobeDeducted=1;
                $amtTobeDeductedforAggHide=$myrow["amount"];
                $inramtTobeDeductedforAggHide=$myrow["Amount_INR"];
            }elseif($myrow["SPV"]==1 && $myrow["AggHide"]==1){
                $NoofDealsCntTobeDeducted=1;
                $amtTobeDeductedforAggHide=$myrow["amount"];
                $inramtTobeDeductedforAggHide=$myrow["Amount_INR"];
            }
            if($myrow["hideamount"] == 1){
                $hidecount=$hidecount+1;
            }
            
            $totalInv=$totalInv+1-$NoofDealsCntTobeDeducted;
            $totalAmount=$totalAmount+ $myrow["amount"]-$amtTobeDeductedforAggHide;
            $totalINRAmount=$totalINRAmount+ $myrow["Amount_INR"]-$inramtTobeDeductedforAggHide;

            $pedata[$cont]=$myrow;
            $cont++;
            
        }
        if($hidecount==1){
            $totalAmount = "--";
            $totalINRAmount = "--";
        }

      
        $inrvalue = "SELECT value FROM configuration WHERE purpose='USD_INR'";
                    $inramount = mysql_query($inrvalue);
                    while($inrAmountRow = mysql_fetch_array($inramount,MYSQL_BOTH))
                    {
                        $usdtoinramount = $inrAmountRow['value'];
                    }
        if($hideinrcount > 0){
            $totalINRAmount = $totalAmount * 1000000 * $usdtoinramount / 10000000;
        } 
    ?>
                                    <div class=" active matrans"><span></span>
                                    <h2 id="companyinfo" class="box_heading content-box ">M&A Transactions</h2>
                                    </div>
                                    <div id="ma_popup" style=""></div>
                                     <div class="accordions_dealcontent ma-ajax " style="display: none;padding-top: 20px;">
                                    
                                     <div class="malb" >
                                    
                                    <span class="maclose"><a href="javascript: void(0);">X</a></span>
<p class="matext">For more details regarding the M&A Transactions, login / sign up for the <a href="../malogin.php" target="_blank">M&A Deals database.</a> </p>

</div>      
                                     <?php 
                                    
                                      
                                         // Table to show the companies with count at the top
                                         if(count($pedata) > 0){
                                             $testingvariable=1;
                                             ?>
                                                 
                                     
                                                 
                                                 <div class="view-table view-table-list ">
                                                 <table width="100%" cellspacing="0" cellpadding="0" id="myTable">
                                                     <thead><tr>
                                                         <th style="width: 530px;" class="headertbma" data-cin="<?php echo $cinno;?>" data-order="<?php echo $order_company; ?>" id="companyname">Company</th>
                                                         <th style="width: 850px;" class="headertbma" data-cin="<?php echo $cinno;?>" data-order="<?php echo $order_sector; ?>" id="sector_business">Sector</th>
                                                         <th style="width: 260px;" class="headertbma" data-cin="<?php echo $cinno;?>" data-order="<?php echo $order_acquirer; ?>" id="acquirer">Acquirer</th>
                                                         <th style="width: 200px;" class="headertbma" data-cin="<?php echo $cinno;?>" data-order="<?php echo $order_dates; ?>" id="dates">Date</th>
                                                         <th style="width: 200px;" class="headertbma" data-cin="<?php echo $cinno;?>" data-order="<?php echo $order_amount; ?>" id="amount">Amount</th>
                                                     </tr></thead>
                                                     <tbody id="movies">
                                                     <?php
                                                     
                                                 foreach($pedata as $ped){ 
                                                    $searchString4="PE Firm(s)";
                                                    $searchString4=strtolower($searchString4);
                                                    $searchString4ForDisplay="PE Firm(s)";
                                                    $searchString="Undisclosed";
                                                    $searchString=strtolower($searchString);
                                                    $searchString3="Individual";
                                                    $searchString3=strtolower($searchString3);
                                                    $companyName=trim($ped["companyname"]);
                                                    $companyName=strtolower($companyName);
                                                    $compResult=substr_count($companyName,$searchString);
                                                    $compResult4=substr_count($companyName,$searchString4);
                                
                                                    $acquirerName=$ped["acquirer"];
                                                    $acquirerName=strtolower($acquirerName);
                                
                                                    $compResultAcquirer=substr_count($acquirerName,$searchString4);
                                                    $compResultAcquirerUndisclosed=substr_count($acquirerName,$searchString);
                                                    $compResultAcquirerIndividual=substr_count($acquirerName,$searchString3);
                                
                                                    if($compResult==0)
                                                            $displaycomp=$ped["companyname"];
                                                    elseif($compResult4==1)
                                                            $displaycomp=ucfirst("$searchString4");
                                                    elseif($compResult==1)
                                                            $displaycomp=ucfirst("$searchString");
                                
                                                    if(($compResultAcquirer==0) && ($compResultAcquirerUndisclosed==0) && ($compResultAcquirerIndividual==0))
                                                            $displayAcquirer=$ped["acquirer"];
                                                    elseif($compResultAcquirer==1)
                                                            $displayAcquirer=ucfirst("$searchString4ForDisplay");
                                                    elseif($compResultAcquirerUndisclosed==1)
                                                            $displayAcquirer=ucfirst("$searchString");
                                                    elseif($compResultAcquirerIndividual==1)
                                                            $displayAcquirer=ucfirst("$searchString3");
                                
                                                          if(trim($ped["sector_business"])==""){
                                 
                                                             $showindsec=$ped["industry"];
                                                          }else{
                                                             $showindsec=$ped["sector_business"];
                                                          }
                                 
                                                         if($ped["Exit_Status"]==1){
                                                             $exitstatus_name = 'Unexited';
                                                         }
                                                         else if($ped["Exit_Status"]==2){
                                                              $exitstatus_name = 'Partially Exited';
                                                         }
                                                         else if($ped["Exit_Status"]==3){
                                                              $exitstatus_name = 'Fully Exited';
                                                         }
                                                         else{
                                                             $exitstatus_name = '--';
                                                         }
                                 
                                                        //  if($ped["hideamount"]==1)
                                                        //  {
                                                        //          $hideamount="--";
                                                        //  }
                                                        //  else
                                                        //  {
                                                        //          $hideamount=$ped["amount"];
                                                        //  }
                                                        if($ped["amount"]==0)
                                                        {
                                                                $hideamount="-";
                                                                $amountobeAdded=0;
                                                        }
                                                        elseif($ped["hideamount"]==1)
                                                        {
                                                                $hideamount="-";
                                                                $amountobeAdded=0;

                                                        }
                                                        else
                                                        {
                                                                $hideamount=$ped["amount"];
                                                                // $acrossDealsCnt=$acrossDealsCnt+1;
                                                                $amountobeAdded=$ped["Amount"];
                                                        }
                                                          if($ped["asset"]==1)
                                                         {
                                                                $openBracket="(";
                                                                $closeBracket=")";
                                                         }
                                                         else
                                                         {
                                                                $openBracket="";
                                                                $closeBracket="";
                                                          }
                                                          if($ped["agghide"]==1)
                                                        {
                                                                $opensquareBracket="{";
                                                                $closesquareBracket="}";
                                                                $hideFlagset = 1;
                                                                $amtTobeDeductedforAggHide=$ped["amount"];
                                                                $NoofDealsCntTobeDeducted=1;

                                                                //$acrossDealsCnt=$acrossDealsCnt-1;
                                                         }
                                                        else
                                                        {
                                                                $opensquareBracket="";
                                                                $closesquareBracket="";
                                                                $amtTobeDeductedforAggHide=0;
                                                                $NoofDealsCntTobeDeducted=0;
                                                                $cos_array = $cos_withdebt_array;
                                                        }
                                                          if($ped["SPV"]==1)
                                                         {
                                                                $openDebtBracket="[";
                                                                $closeDebtBracket="]";
                                                         }
                                                         else
                                                         {
                                                                $openDebtBracket="";
                                                                $closeDebtBracket="";
                                                         }
                                                         ?>
                                                         <tr class="details_linkma" data-row="<?php echo $ped["mamaid"];?>" >
                                 
                                                                 <td style="width: 530px;"><b><?php echo $openBracket.$openDebtBracket.$opensquareBracket.trim($ped["companyname"]).$closesquareBracket.$closeDebtBracket.$closeBracket;?></b></td>
                                                                 <td style="width: 850px;"><b><?php echo trim($ped["sector_business"]);?></b></td>
                                                                 <td style="width: 260px;"><b><?php echo $displayAcquirer;?></b></td>
                                                                 <td style="width: 200px;"><b><?php echo $ped["dates"];?></b></td>
                                                                 <td style="width: 200px;"><b><?php echo $hideamount;?></b></td>
                                 
                                                         </a></tr>
                                                         <?php
                                                     }
                                 ?>
                                                     </tbody></table></div>
                                 <?php
                                         
                                         }else{ 
                                            $pageTitle="Request for more deal data- Investment";
                                              echo '<p class="text-center" style="font-size:10pt;font-weight:600;padding: 10px;"> No M&A activity found for this company <a id="deals_data" href="mailto:research@ventureintelligence.com?subject=Check for M&A Activity&body=<?php echo $mailurl;?> " style="font-weight:bold;cursor:pointer;">Click Here</a> to double check with Venture Intelligence on this. </p>';
                                        
                                            
                                         }
                                     }else{ echo '<p class="text-center" style="font-size:10pt;font-weight:600;padding: 10px;"> No M&A activity found for this company <a id="deals_data" style="font-weight:bold;cursor:pointer;" href="mailto:research@ventureintelligence.com?subject=Check for M&A Activity&body=<?php echo $mailurl;?> " >Click Here</a> to double check with Venture Intelligence on this. </p>';
                                           
                                     }
                                 
                                     ?>
                                     </div>
                                     </div>
                                     </div>
                
    </div>
     </div>
                            </div>
          
            </div>

            
    </div>
    <div class="postContainer postContent masonry-container">
        <div class="deal_outerbox"> 
       <!--  <div  class="work-masonry-thumb1 col-p-7" id="deal_info" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
            <h2 id="investmentinfo" class="box_heading content-box">Deal Info </h2>
  <table cellpadding="0" cellspacing="0" class="tablelistview">
  <tbody>
      <tr>
          <td colspan="4" style="width: 100%"><h4>&nbsp;</h4></td>
      </tr>
        <tr>
            <td id="tourinvestor">
                <h4>Amount ($ M) </h4>
            </td>
            <td id="tourinvestor" class="">
                <p>
                 <?php if($myrow["hideamount"]==1){   ?>
                      <?php echo $hideamount;?> 
                 <?php } else { ?>
                     <?php if($hideamount !='' && $hideamount !='0.00' ){?><?php echo $hideamount;?> <?php } else{ ?> <?php echo '&nbsp;'; } ?>
                 <?php } ?>
                </p>
          </td>
            <td><h4>Stake</h4></td> 
            <td class=""><p>
            <?php if($hidestake!="" && $hidestake!="&nbsp;" && $hidestake !='--'){ 
                    echo $hidestake.' %';
                }else{
                    echo "&nbsp;";
                }?> </p></td> 
        </tr>
      <tr>
          <td><h4>Amount (&#8377; Cr) </h4></td>
          <td class="rgt"><p>
                 <?php if($myrow["hideamount"]!=1 && $hideamount_INR !='' && $hideamount_INR !='0.00'){   ?>
                 <?php echo $hideamount_INR; }else{
                    echo "&nbsp;"; }?></p>
        </td>
          <td><h4>Stage</h4></td>
  <td class=""><p><?php echo $myrow["Stage"];?></p></td>
      </tr>
      <tr>
          <td><h4>Exit Status</h4></td>
          <td class=""><?php
             $exitstatusis='';
            $exitstatusSql = "select id,status from exit_status where id=".$myrow["Exit_Status"];
            if ($exitstatusrs = mysql_query($exitstatusSql))
            {
              $exitstatus_cnt = mysql_num_rows($exitstatusrs);
            }
            if($exitstatus_cnt > 0)
            {
                    While($Exit_myrow=mysql_fetch_array($exitstatusrs, MYSQL_BOTH))
                    {
                            $exitstatusis = $Exit_myrow[1];
                    }?>
                    <p><?php echo $exitstatusis;?></p>
            <?php } ?> </td> 
            <td><h4>Round</h4></td>
            <td class="tooltip-1"><p>
                <?php // strip tags to avoid breaking any html
                $string = strip_tags($myrow["round"]);
                if (strlen($string) > 12) { 
                    $pos=strpos($string, ' ', 12);
                    if($pos != ''){
                        $string = substr($string,0,$pos);
                    }else{
                        $string = substr($string,0,12);                            
                    }
                    $string = trim($string).'...';
                    $display = 'yes';
                } echo $string; ?></p>
                <?php if($display == 'yes') { ?>
            <div class="tooltip-box1">
                <?php echo $myrow["round"];?>
           </div>
            <?php } ?>  
                    </td>
      </tr>
      <tr>
          <td><h4>Date</h4></td>
            <td class=""><p><?php echo  $myrow["dt"];?></p></td>
        <td>
            <h4> Price Per Share </h4></td>
        <td class="rgt">
                            <p> <?php echo $price_per_share; ?> </p>
                    </td>
                </tr>
          <?php //if($book_value_per_share > 0 || $book_value_per_share > 0) { ?>
                <tr>
          <?php //if($book_value_per_share > 0) { ?>
            <td>
                <h4> BV Per Share </h4>
            </td>
            <td class="">
                <p> <?php echo (!empty($book_value_per_share)) ? $book_value_per_share : '&nbsp;'; ?> </p>
            </td>
                <?php //} ?>
          <?php //if($price_to_book > 0) { ?>
        <td>
            <h4> Price to Book </h4></td>
        <td class="">                
                              <p> <?php echo (!empty($price_to_book)) ? $price_to_book : '&nbsp;'; ?> </p>
                      </td>
              <?php //} ?>
                </tr>
            <?php //} ?>
    </tbody>
    </table>
    </div> -->
 <style>
  #myTable th.headertbma {
    background: url(img/icon-sort-black.png) no-repeat left center;
    border-top: 1px solid #999;
    border-bottom: 1px solid #999;
    padding: 10px 10px 14px 15px;
    font-size: 16px;
    color: #000;
    font-weight: bold;
    text-transform: uppercase;
    border-right: 0 !important;
}
.ma-ajax{
    display: flex;
  justify-content: center;
 
}
.malb{
    /* width: 600px; */
    /* border: 1px solid #ccc; */
    /* box-shadow: 0 0 2px #eaeaea; */
    /* overflow: hidden; */
    /* margin: 0 auto; */
    /* z-index: 9000;  */
    /* left: 23%;
    top: 30%; */
    align-self: center;
    position: absolute;
    background-color: #fff;
     display: none;
}
#ma_popup{
    background: #fff;
    /* z-index: 8000; */
    overflow: hidden;
    opacity: 0.5;
    position: absolute;
    display: none;
    width: 100%;
   

}
.matext{
    padding: 23px 30px;
    font-size: 15px;
    background-color: #e0d8c3;
    color:#333 !important;
    border: 1px solid;
}
  span.investorlable {
    /* font-size: 10px;
    padding: 1px 3px;
    background-color: #c9c4b7;
    color: #fff; */
    font-size: 10px;
    padding: 2px 3px;
    background-color: #beb49a;
    color: #fff;
}
  .investoricon i{
    height: 13px;
    float: none;
    background-image: none;
    background-repeat: no-repeat;
    margin-left: 10px;
    font-size: 10px;
    cursor:pointer;
  }
  tr.childaccordions td {
    /* padding: 3px !important; */
    border-top:1px solid #fff !important;
    font-weight: 500;
    color: #000 !important;
    padding: 3px 10px 3px 3px !important;
}

.childaccordions a,.childaccordions td p {
        font-size: 13px !important;
        font-weight: 200 !important;
        margin-left: 20px;
        color: #000 !important;
    }
    tr.childaccordions td {
        border-bottom: 1px solid transparent ;
    }

/* .accordions_dealtitle1 td{
    border-bottom: 1px solid #fff !important;
    border-top: 1px solid #e6e5e5 !important;
} */
      .display_block{
          display:block !important;
      }
      .display_none{
          display:none !important;
      } 
.valuation_label{
width:40%;
}
.valuation_label1{
width:28%;
}



  </style>
    <?php
    
    
  /*if($dec_company_valuation > 0 || $dec_revenue_multiple > 0  || $dec_ebitda_multiple > 0 || $dec_company_valuation2 > 0 || $dec_revenue_multiple2 > 0  || $dec_ebitda_multiple2 > 0)
    {
       $fields_class = "display_block";
       $valuation_label = "valuation_label";
   }else{
       $fields_class = "display_none";
       $valuation_label = "valuation_label1";
   } 
   
   if(!$dec_company_valuation2 > 0 && !$dec_revenue_multiple2 > 0 && !$dec_ebitda_multiple2 > 0 && !$dec_pat_multiple2 > 0 ){
       
       $pre = 0;
       $pre_block = "display_block";
   }
   
   if(!$dec_company_valuation > 0 && !$dec_revenue_multiple > 0 && !$dec_ebitda_multiple1 > 0 && !$dec_pat_multiple2 > 0){
       
       $ev = 0;
       $ev_block = "display_block";
   }
   
   if(!$dec_company_valuation2 > 0 && !$dec_revenue_multiple2 > 0 && !$dec_ebitda_multiple2 > 0 && !$dec_pat_multiple2 > 0 ){
       
       $pre = 0;
       $post_block = "display_block";
   }*/
  
   
    
        echo '<div style="display:none">'.$dec_company_valuation.'</div>';//pre
        echo  '<div style="display:none">'.$dec_company_valuation1.'</div>';//Post
        echo  '<div style="display:none">'.$dec_company_valuation2.'</div>';//EV

        echo  '<div style="display:none">'.$dec_revenue_multiple.'</div>';//pre
        echo  '<div style="display:none">'.$dec_revenue_multiple1.'</div>';//Post
        echo  '<div style="display:none">'.$dec_revenue_multiple2.'</div>';//EV

        echo '<div style="display:none">'. $dec_ebitda_multiple.'</div>';//pre
        echo  '<div style="display:none">'.$dec_ebitda_multiple1.'</div>';//POST
        echo '<div style="display:none">'. $dec_ebitda_multiple2.'</div>';//EV

        echo'<div style="display:none">'. $dec_pat_multiple.'</div>';//pre
        echo '<div style="display:none">'.$dec_pat_multiple1.'</div>';//Post
        echo '<div style="display:none">'. $dec_pat_multiple2.'</div>';//EV
    
   
   
   ?>
<!--  <div  class="work-masonry-thumb1 col-p-12" id="valuation_info" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
  <h2 id="investmentinfo" class="box_heading content-box ">Valuation Info </h2>  
  <table cellpadding="0" cellspacing="0" class="tablelistview">
    <tbody>
    <?php
      
            if(($dec_company_valuation <= 0 && $dec_revenue_multiple <= 0 && $dec_ebitda_multiple <= 0 && $dec_pat_multiple <= 0)){
                $field_class_pre = 0;
            }else{
                $field_class_pre = 1;
            }
            if($dec_company_valuation2 <= 0 && $dec_revenue_multiple2 <= 0 && $dec_ebitda_multiple2 <= 0 && $dec_pat_multiple2 <= 0){
                 $field_class_ev = 0;
            }else{
                $field_class_ev = 1;
            }
        ?>
            
        <tr>
          <td><h4>&nbsp;</h4></td>
          <?php if($field_class_pre !=0){ ?>
                <td><h4 class="<?php echo $field_class_pre; ?>">Pre-Money</h4></td>
          <?php } ?>
                <td class="<?php echo $fields_class_both; ?>"><h4>Post-Money</h4></td>
          <?php if($field_class_ev !=0){ ?>
                <td class="<?php echo $fields_class_ev; echo $fields_class_both;?>"><h4>EV</h4></td>
          <?php } ?>
        </tr>
        <tr>
            <td id="tourinvestor" class="<?php echo $valuation_label; ?>">
                <h4>Valuation (&#8377; Cr)</h4>
            </td>
            <?php if($field_class_pre !=0){ ?>
                
                    <td><p class="<?php echo $field_class_pre; ?> content-align">
                        <?php
                           if($dec_company_valuation > 0)
                           { ?>
                             <?php  echo $dec_company_valuation; 
                           }else{ ?>
                                   <?php   echo '&nbsp;';
                           }  
                        ?></p>
                   </td> 
           <?php } ?>
            
            <td class=""><p class="content-align">
             <?php
             
                    if($dec_company_valuation1 > 0 && $dec_company_valuation1 !='')
                    { 
                        
                        ?>
                      <?php  echo $dec_company_valuation1; 
                    }else{ 
                          
                          ?>
                            <?php   echo '&nbsp;';
                    }  ?></p>
            </td> 
            <?php if($field_class_ev !=0){ ?>
            <td class=" <?php echo $field_class_ev; ?>"><p class="content-align">
             <?php
                    if($dec_company_valuation2 >0 && $dec_company_valuation2 !='')
                        { ?>
                      <?php  echo $dec_company_valuation2; 
                      }else{ ?>
                            <?php   echo '&nbsp;';
                        }  ?></p>
            </td> 
            <?php } ?>
        </tr>
        <tr>
            <td id="tourinvestor" class="<?php echo $valuation_label; ?>">
                <h4>Revenue Multiple </h4>
            </td>
            <?php if($field_class_pre !=0){ ?>
            <td class="<?php echo $field_class_pre; ?>"><p class="content-align">
             <?php
                    if($dec_revenue_multiple > 0)
                        { ?>
                      <?php  echo $dec_revenue_multiple; 
                      }else{ ?>
                            <?php   echo '&nbsp;';
                        }  ?></p>
            </td> 
            <?php } ?>
            <td class=""><p class="content-align">
             <?php
                    if($dec_revenue_multiple1 >0 && $dec_revenue_multiple1 !='')
                        { ?>
                      <?php  echo $dec_revenue_multiple1; 
                      }else{ ?>
                            <?php   echo '&nbsp;';
                        }  ?></p>
            </td>
             <?php if($field_class_ev !=0){ ?>
            <td class=" <?php echo $field_class_ev; ?>"><p class="content-align">
             <?php
                    if($dec_revenue_multiple2 >0 && $dec_revenue_multiple2 !='')
                        { ?>
                      <?php  echo $dec_revenue_multiple2; 
                      }else{ ?>
                            <?php   echo '&nbsp;';
                        }  ?></p>
            </td> 
             <?php } ?>
            
        </tr>
        <tr>
            <td id="tourinvestor" class="<?php echo $valuation_label; ?>" >
                <h4>EBITDA Multiple</h4>
            </td>
             <?php if($field_class_pre !=0){ ?>
                <td class="<?php echo $field_class_pre; ?>"><p class="content-align">
                 <?php
                        if($dec_ebitda_multiple >0 && $dec_ebitda_multiple !='')
                            { ?>
                          <?php  echo $dec_ebitda_multiple; 
                          }else{ ?>
                                <?php   echo '&nbsp;';
                            }  ?></p>
                </td>
             <?php } ?>
            <td class=""><p class="content-align">
             <?php
                    if($dec_ebitda_multiple1 >0 && $dec_ebitda_multiple1 !='' )
                        { ?>
                      <?php  echo $dec_ebitda_multiple1; 
                      }else{ ?>
                            <?php   echo '&nbsp;';
                        }  ?></p>
            </td> 
             <?php if($field_class_ev !=0){ ?>
                <td class="<?php echo $field_class_ev; ?>"><p class="content-align">
                 <?php
                        if($dec_ebitda_multiple2 >0 && $dec_ebitda_multiple2 !='')
                            { ?>
                          <?php  echo $dec_ebitda_multiple2; 
                          }else{ ?>
                                <?php   echo '&nbsp;';
                            }  ?></p>
                </td>
             <?php } ?>
           
        </tr>
        <tr>
            <td id="tourinvestor" class="<?php echo $valuation_label; ?>">
                <h4>PAT Multiple</h4>
            </td>
             <?php if($field_class_pre !=0){ ?>
                <td class="<?php echo $field_class_pre; ?>"><p class="content-align">
                 <?php
                        if($dec_pat_multiple >0 && $dec_pat_multiple !='')
                            { ?>
                          <?php  echo $dec_pat_multiple; 
                          }else{ ?>
                                <?php   echo '&nbsp;';
                            }  ?></p>
                </td> 
             <?php } ?>
            <td class=""><p class="content-align">
             <?php
                    if($dec_pat_multiple1 >0 && $dec_pat_multiple1 !='')
                        { ?>
                      <?php  echo $dec_pat_multiple1; 
                      }else{ ?>
                            <?php   echo '&nbsp;';
                        }  ?></p>
            </td> 
             <?php if($field_class_ev !=0){ ?>
            <td class=" <?php echo $field_class_ev; ?>"><p class="content-align">
             <?php
                    if($dec_pat_multiple2 > 0 && $dec_pat_multiple2 !='')
                    { ?>
                        <?php  echo $dec_pat_multiple2; 
                    }else{ ?>
                        <?php   echo '&nbsp;';
                    }  ?></p>
            </td> 
             <?php } ?>
        </tr>
    <?php    //}
     
            $display = 'no'; $string ='';
            if(trim($myrow["Valuation"])!="")
            {
            ?>
                <?php
               /* foreach($valuationdata as $valdata)
                {
                    if($valdata!="")
                    { 
                        print nl2br($valdata);?><?php
                    }
                }*/
                $string =trim($myrow["Valuation"]);
                $string = strip_tags($string);
                if (strlen($string) > 40) { 
                    $string = substr($string,0,40);
                    $string = trim($string).'...';
                    $display = 'yes';
                }
            }
            //if($string !=''){
            ?>
      <tr>
          <td class="<?php echo $valuation_label; ?>"><h4>More Info </h4></td>
          <td  class="last-child">
              <div class="tooltip-2"><p><?php echo $string; ?></p>
           </div>
              <?php if($display == 'yes'){ ?>
            <div class="tooltip-box2">
                <?php echo trim($myrow["Valuation"]);?>
           </div>
              <?php } ?>
          </td>
      </tr>
            <?php //} ?>
    </tbody>
    </table>
    </div>  --> 
            <?php
    if($Cash_Equ !=''){
        $financial_label = "financial_label";
    }else{
        $financial_label = "financial_label1";
    }?>  
  <?php
  $file = '';
        if($exportToExcel==1)
         {          
            $uploadfilename = $myrow["uploadfilename"];
            if($uploadfilename!="")
            {
                $uploadname=$uploadfilename;
                $currentdir=getcwd();
                $target = $currentdir . "../uploadmamafiles/" . $uploadname;
                $file = "../../uploadmamafiles/" . $uploadname;
            }
         } ?>
  <input type="hidden" name="financial_label_hide" id="financial_label_hide" value="<?php echo $financial_label; ?>" />
        <!-- <div  class="work-masonry-thumb1  <?php if($financial_label == "financial_label1") { echo "col-p-11_1"; }else{ echo "col-p-11"; echo " fullBox"; } ?>" id="financials_info" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
        <div class="box_heading content-box ">
        <h2 style="padding-right:5px; width:95%;">Financials&nbsp;<span id="allfinancial">(Latest P&amp;L)</span></h2>

  
    </div>
    <table cellspacing="0" cellpadding="0" class="tablelistview">
    <tbody>
            <tr>
            <td><h4>&nbsp;</h4></td>
            <td ><h4 class="title_ctr">
                <?php echo $financial_year; ?> (&#8377; Cr)</h4></td>
        </tr>
            <tr>
                    
                <td class="<?php //echo $financial_label; ?>"><h4>Revenue
                    </h4></td>
                    <td class="">
        <p class="content-align">
                <?php
               if($dec_revenue < 0 || $dec_revenue > 0)
                { ?><?php
                   echo $dec_revenue;
                }
                else{
                    if($dec_company_valuation >0 && $dec_revenue_multiple >0){ ?>
        <?php
                        echo  number_format($dec_company_valuation/$dec_revenue_multiple, 2, '.', '');      
                    }else{ ?>
        <?php
                        echo "&nbsp;";
                    }
                }?>
                </p></td>
            </tr>
            <tr>
                <td class="<?php //echo $financial_label; ?>"><h4>EBITDA</h4></td>
                <td class=""><p class="content-align">
                 <?php 
                if($dec_ebitda < 0 || $dec_ebitda > 0)
                { ?>
                     <?php echo $dec_ebitda;
                }else{
                    if($dec_company_valuation >0 && $dec_ebitda_multiple >0){ ?>
                     <?php 
                        echo  number_format($dec_company_valuation/$dec_ebitda_multiple, 2, '.', '');
                    }else{ ?>
                    <?php 
                        echo "&nbsp;";
                    }            
                }?>  
                </p></td>
            </tr>
            <tr>
                <td class="<?php //echo $financial_label; ?>"><h4>PAT</h4></td>
                <td class="">
            <p class="content-align">
           <?php
        if($dec_pat < 0 || $dec_pat > 0)
        { ?>
        <?php
            echo $dec_pat;                
        } 
        else{ ?>
        <?php
            if($dec_company_valuation >0 && $dec_pat_multiple >0){
                echo number_format($dec_company_valuation/$dec_pat_multiple, 2, '.', '');
            }else{ ?>
        <?php
                echo "&nbsp;";                    
            }
        } ?>
        </p>
        </td>
        </tr>
        <?php //if($Total_Debt !=''){ ?>
        <tr>
            <td class="<?php //echo $financial_label; ?>"> <h4>Total Debt</h4></td>
            <td class=""><p class="content-align"><?php echo (!empty($Total_Debt)) ? $Total_Debt : '&nbsp;'; ?></p></td>
        </tr>
            <?php //} ?>
        <?php //if($Cash_Equ !=''){ ?>
        <tr>
            <td class="<?php //echo $financial_label; ?>"> <h4>Cash & Cash Equ.</h4></td>
            <td class=""><p class="content-align"><?php echo (!empty($Cash_Equ)) ? $Cash_Equ : '&nbsp;'; ?></p></td>
        </tr>
            <?php //} ?>
          
 </tbody>
    </table> 
    </div>  --> 
                    
<div style="clear:both"></div>
<!--   <div  class="work-masonry-thumb1 col-p-9" id="investor_info" href="http://erikjohanssonphoto.com/work/aizone-ss13/" style=" margin-bottom: 20px;">
  <h2 id="investmentinfo" class="box_heading content-box ">Investor Info</h2> 
  <table cellpadding="0" cellspacing="0" class="tablelistview2">             
            <?php
                    $invcount = 0;
                    $amount_val ='empty';
                    if ($_SESSION['investId']) 
                    unset($_SESSION['investId']); 
                    $AddOtherAtLast="";
                    $AddUnknowUndisclosedAtLast="";
                    if ($getcompanyrs = mysql_query($investorSql))
                    {
                       
                        if(mysql_num_rows($getcompanyrs) > 0){ 
                                $investor_ID = $investor_Name = $Amount_INR = $Amount_M = $invID = $invName = $invAmount_INR = $invAmount_M = $investor_ID_A = $investor_Name_A = $Amount_INR_A = $Amount_M_A = $invhideamount=$invhideamount_A = array();
                                $no_amount ='';
                                $leadinvestor = array();
                                $newinvestor = array();
                                While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                {
                                    
                                    $Investorname=trim($myInvrow["Investor"]);
                                    $leadinvestor[] = $myInvrow["leadinvestor"];
                                    $newinvestor[] = $myInvrow["newinvestor"];

                                    $Investorname=strtolower($Investorname);

                                    $invResult=substr_count($Investorname,$searchString);
                                    $invResult1=substr_count($Investorname,$searchString1);
                                    $invResult2=substr_count($Investorname,$searchString2);
                                    if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                    {
                                         $invID[] = trim($myInvrow["InvestorId"]);
                                         $invName[] = trim($myInvrow["Investor"]);
                                         $invAmount_INR[] = trim($myInvrow["Amount_INR"]);
                                         $invAmount_M[] = trim($myInvrow["Amount_M"]);            
                                         $invhideamount[] = trim($myInvrow["hide_amount"]);
                                    }else{
                                         $investor_ID_A[] = trim($myInvrow["InvestorId"]);
                                         $investor_Name_A[] = trim($myInvrow["Investor"]);
                                         $Amount_INR_A[] = trim($myInvrow["Amount_INR"]);
                                         $Amount_M_A[] = trim($myInvrow["Amount_M"]);      
                                         $invhideamount_A[] = trim($myInvrow["hide_amount"]);
                                    }
                                    if(($myInvrow["Amount_INR"] !='' && $myInvrow["Amount_INR"] != '0.00') || ($myInvrow["Amount_M"] !='' && $myInvrow["Amount_M"] != '0.00')){
                                       $no_amount ='yes';                                                 
                                    }
                                   
                                 }
                                 $investor_ID = array_merge($invID,$investor_ID_A);
                                 $investor_Name = array_merge($invName,$investor_Name_A);
                                 $Amount_INR = array_merge($invAmount_INR,$Amount_INR_A);
                                 $Amount_M = array_merge($invAmount_M,$Amount_M_A);
                                 $hide_amount = array_merge($invhideamount,$invhideamount_A);
                            ?> 
                            <tr>
                                <td><h4>Name</h4></td>
                                <?php if($no_amount =='yes' && $global_hideamount==0){ ?>
                                <td><h4 class="title_ctr">&#8377; Cr</h4></td>
                                <td><h4 class="title_ctr">$ Mn</h4></td>
                                <?php } ?>
  </tr>                        
                            <?php for($l=0;$l<count($investor_ID);$l++){ ?>
                                <tr>
                                    <td <?php if($no_amount !='yes'){ ?> style="padding-top:5px; padding-bottom: 5px; " <?php }?>>  <h4>    
                                        <?php
                                         //$AddOtherAtLast="";
                                         $Investorname=trim($investor_Name[$l]);
                                         $InvestornameNew = '';

                                         if($leadinvestor[$l] == 1) {
                                            $InvestornameNew = trim($investor_Name[$l]). " (L)";
                                         } else if($newinvestor[$l] == 1) {
                                            $InvestornameNew = trim($investor_Name[$l]). " (N)";
                                         } else {
                                            $InvestornameNew = trim($investor_Name[$l]);
                                         }
                                         $Investorname=strtolower($Investorname);

                                         $invResult=substr_count($Investorname,$searchString);
                                         $invResult1=substr_count($Investorname,$searchString1);
                                         $invResult2=substr_count($Investorname,$searchString2);
                                         if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                         {
                                             $_SESSION['investId'][$invcount++] = $investor_ID[$l];
                                             $deal=0; ?><a id="investor<?php echo $investor_ID[$l]; ?>" class="postlink  tourinvestor<?php echo $investor_ID[$l]; ?>" href='investordetails.php?value=<?php echo $investor_ID[$l].'/'.$strvalue[1].'/'.$strvalue[2].'/'.$strvalue[3];?>' ><?php echo $InvestornameNew; ?></a>
                                        <?php
                                         }
                                          elseif(($invResult==1) || ($invResult1==1)){
                                                  echo $Investorname;
                                          }
                                          elseif($invResult2==1)
                                          {
                                                  echo $Investorname;
                                                  } ?></h4>
                                    </td>
                                    <?php if($no_amount =='yes' ){ ?>
                                    <td class="">
                                        <p class="content-align"><?php if($hide_amount[$l]==0 && $global_hideamount==0 ) { echo $Amount_INR[$l]; }else{ echo '';} ?></p>
                                    </td>
                                    <td class="">
                                        <p class="content-align"><?php if($hide_amount[$l]==0 && $global_hideamount==0 ) { echo $Amount_M[$l]; }else{ echo '';} ?></p>
                                    </td>
                                        <?php } ?>
                                </tr>
                            <?php }?> 
                        <?php   } ?>
                                    <?php if($no_amount =='yes'){ ?>
  <tr>
                                <td><h4>Investor Type</h4></td>
                                <td colspan="2" style="width:48%;" class="<?php if(mysql_num_rows($getcompanyrs) > 0) echo "ammountStyle"; ?>"><p class="content-align"><?php echo $myrow["InvestorTypeName"] ;?></p></td>
                          </tr>
                                    <?php } else{ ?>
                        <tr>
                            <td style="width:100%;"><h4>Investor Type: <?php echo $myrow["InvestorTypeName"] ;?></h4></td>
                      </tr>
                                    <?php }
                    }?>
                </table>
                </div>  --> 
<?php
                    if($getcompanyrs= mysql_query($advcompanysql))
    {
                        $comp_cnt = mysql_num_rows($getcompanyrs);
    }
    if($rsinvcomp= mysql_query($advinvestorssql)) {
              $compinv_cnt = mysql_num_rows($rsinvcomp);
    }
                    $totalInvestor = count($investor_ID);
                    $totalAdvisor = $comp_cnt + $compinv_cnt;
                    if($totalInvestor > 2 && $totalAdvisor >4){
                     //   include_once 'advisor_box.php';
                }
    ?>
               
                  <!--   <div  class="work-masonry-thumb1 col-p-4" href="http://erikjohanssonphoto.com/work/tac-3/" style="float:left;">
             <h2 id="moreinfo" class="moreinfo more-content">More Info</h2>
                                                           
             <table class="tablelistview" cellpadding="0" cellspacing="0" style="background:#fff;">
                  <tr>  <td class="more-info"><p><?php print nl2br($moreinfor); ?></p>
                          <p><a id="clickhere" href="mailto:database@ventureintelligence.com?subject=Request for more deal data-<?php echo $pageTitle;?>&body=<?php echo $mailurl;?> ">
                                  Click Here</a> to request more details for this deal. Please specify what details you would like - financials, valuations, etc. - and we will revert with the data points as available. Note: For recent transactions (say within last 6 months), additional information availablity is typically less than for older ones.
                          </p></td></tr></table>
       </div> -->
   </div></div>
                    
                    <div style="clear:both"></div>
                    
                    
<?php //include('dealcompanydetails.php'); ?> 
                    
        <?php if(($exportToExcel==1))
         {
         ?>
                         <div class="title-links">
                                         <a class="export" id="expshowdealsbtn" name="showdeal" style="padding: 5px 10px !important;"><!-- <span class="download-icon"></span> -->Export</a>
                         </div>

         <?php
         }
     ?>
    </div>
</td>
</tr>
</table>
</div>
<input type="hidden" name="period_flag" id="period_flag" value="<?php echo $period_flag; ?>" />
<!--<input type="hidden" name="pe_checkbox" id="pe_checkbox" value="<?php echo $pe_checkbox; ?>" />-->
<input type="hidden" name="pe_amount" id="pe_amount" value="<?php echo $pe_amount; ?>" />
<input type="hidden" name="pe_hide_companies" id="pe_hide_companies" value="<?php echo $hideCompanyFlag; ?>" />
<?php if($_POST['all_checkbox_search']==1){ ?>
<input type="hidden" name="pe_company" id="pe_company" value="" />

<?php }else{ ?>

<input type="hidden" name="pe_company" id="pe_company" value="<?php if($pe_company!=''){ echo $pe_company; }else{ echo ""; } ?>" />
<?php } ?>
<input type="hidden" name="hide_pe_company" id="hide_pe_company" value="<?php if($pe_company!=''){ echo $pe_company; }else{ echo ""; } ?>" />
<input type="hidden" name="uncheckRows" id="uncheckRows" value="<?php echo $_POST['pe_checkbox_disbale']; ?>" /> 
<input type="hidden" name="full_uncheck_flag" id="full_uncheck_flag" value="<?php echo $_POST['all_checkbox_search']; ?>" />

<?php if($_POST['real_total_inv_deal']!=''){ ?>
<input type="hidden" name="real_total_inv_deal" id="real_total_inv_deal" value="<?php echo $_POST['real_total_inv_deal']; ?>" />
<?php }
if($_POST['real_total_inv_amount']!='') { ?>
<input type="hidden" name="real_total_inv_amount" id="real_total_inv_amount" value="<?php echo $_POST['real_total_inv_amount']; ?>" />
<?php } 
if($_POST['real_total_inv_inr_amount']!='') { ?>
<input type="hidden" name="real_total_inv_inr_amount" id="real_total_inv_inr_amount" value="<?php echo $_POST['real_total_inv_inr_amount']; ?>" />
<?php } 
if($_POST['real_total_inv_company']!='') { ?>
<input type="hidden" name="real_total_inv_company" id="real_total_inv_company" value="<?php echo $_POST['real_total_inv_company']; ?>" />
<?php }

/*if($_POST['all_checkbox_search']==1){ */?>

<input type="hidden" name="total_inv_deal" id="total_inv_deal" value="<?php echo $_POST['total_inv_deal']; ?>">
<input type="hidden" name="total_inv_amount" id="total_inv_amount" value="<?php echo $_POST['total_inv_amount']; ?>">
<input type="hidden" name="total_inv_inr_amount" id="total_inv_inr_amount" value="<?php echo $_POST['total_inv_inr_amount']; ?>">
<input type="hidden" name="total_inv_company" id="total_inv_company" value="<?php echo $_POST['total_inv_company']; ?>">

<?php //} 

if($_POST['pe_checkbox_enable']!=''){ ?>
<input type="hidden" name="pe_checkbox_enable" id="pe_checkbox_enable" value="<?php echo $_POST['pe_checkbox_enable']; ?>">
<?php }
?>
</form>
<form action="<?php echo $actionlink1; ?>" name="tagForm" id="tagForm"  method="post">
            <input type="hidden" value="" name="searchTagsField" id="searchTagsField" />
   </form>
<!-- <form name="companyDisplay" method="post" id="exportform" action="exportdealinfo.php"> -->
<form name="companyDisplay" method="post" id="exportform" action="dealdetailexport.php">
<input type="hidden" name="txthidePEId" value="<?php echo $SelCompRef;?>" >
<input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
<input type="hidden" name="company_name" value="<?php echo $companyName; ?>" >
<input type="hidden" name="deal_date" value="<?php echo $dealdate123; ?>" > 
</form>
<script type="text/javascript">

   

$(document).on( 'click','.headertbma', function() {

var formData = new Array();
var formData = new Array();

formData.push({ name: 'cin', value: $(this).data('cin') },{ name: 'orderby', value: this.id },{ name: 'order', value: $(this).data('order') });

$.ajax({
   type: 'POST',
   url: 'ajax_ma.php',
   data: formData,
   success: function(data) {
       
       
           clickflagma = 1;
           var dataResp = $.parseJSON(data);
           if( dataResp.count == 0 ) {
               $('#ma-ajax').addClass( 'empty-container' );   
           } else {
               $('#ma-ajax').removeClass( 'empty-container' );
           }
            $('.ma-ajax').html(dataResp.html);
           $('.ma-ajax').show();
            $('.ma-ajaxhidden').html(dataResp.sql);
       
   }
});

});
  $('.tags_link').click(function(){ 
                $("#searchTagsField").val('tag:'+$(this).html());
                $('#tagForm').submit();
            }); 


  
  $(document).ready(function() {
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
 $(document).ready(function() {
     var hidestring = '';
      var hidestring1 = '';              
                    
                    if($(window).width()<1025)
                    {
                        hidestring=40;
                        hidestring1=20;
                    }
                    else if($(window).width()<1300){
                        hidestring=27;
                        hidestring1 = 20;
                    }
                    else if($(window).width()<1400)
                    {
                            hidestring=27;
                            hidestring1 = 20;
                    }
                    else
                        {
                        hidestring=40;
                        hidestring1=29;
                    }

                  

                   $(function(){
            $(".tooltip-4 p").each(function(i){
                
              len=$(this).find('a').text().trim().length;
              if(len>hidestring1)
              {
                var string = $(this).find('a').text().trim();
               $(this).parent().append('<div class="tooltip-box4" >'+$(this).find('a').text().trim()+'</div>');
                    $(this).find('a').text($(this).find('a').text().trim().substr(0,hidestring1)+'...');
                $(".tooltip-4").mouseover(function(){
                    $(".tooltip-box4").css("display","block");
                });  
                $(".tooltip-4").mouseout(function(){
                    $(".tooltip-box4").css("display","none");
                });

              }
            });
            $(".tooltip-4").mouseover(function(){
                $(".tooltip-box4").css("display","block");
            });  

            $(".tooltip5 p").each(function(i){
              len=$(this).text().length;
              if(len>hidestring)
              {
                var string = $(this).text();
               $(this).parent().append('<div class="tooltip-box5">'+string+'</div>');
                $(this).text($(this).text().substr(0,hidestring)+'...');
              }
            }); 
           /* $(".tooltip7 span.lead").mouseover(function(){
                $(this).next().css("display","block");
            });
           $(".tooltip7 span.lead").mouseout(function(){
                    $(this).next().css("display","none");
                }); 

           $(".tooltip7 span.new").mouseover(function(){
                $(this).next().css("display","block");
            });
           $(".tooltip7 span.new").mouseout(function(){
                    $(this).next().css("display","none");
                }); */

            $(".toolbox6 p").each(function(i){

              if($(this).hasClass('linktooltip')){
                    
                    len=$(this).find('a').text().length;

                  if(len>hidestring)
                  {
                    
                    $(this).parent().append('<div class="tooltip-box6" ><a class="postlink" href="'+$(this).find('a').text()+'" target="_blank">'+$(this).text()+'</a></div>');
                    $(this).find('a').text($(this).find('a').text().substr(0,hidestring)+'...');
                  }
              } else if($(this).hasClass('topmanagementtooltip')){
              
                    len=$(this).text().length;
                    if(len>hidestring)
                      {
                        
                        //var string = $(this).text();
                       //$(this).parent().append('<div class="tooltip-box6">'+string+'</div>');
                        $(this).text($(this).text().substr(0,hidestring)+'...');
                      }

              } else if($(this).hasClass('newslinktooltip')){
              
                    

              }  else{
              
                    len=$(this).text().length;
                    if(len>hidestring)
                      {
                        
                        var string = $(this).text();
                       $(this).parent().append('<div class="tooltip-box6">'+string+'</div>');
                        $(this).text($(this).text().substr(0,hidestring)+'...');
                      }

              }
              
            });  


          }); 
     
 $('.list-tab').css('margin-top',$('.result-title').height()+23);
 
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
             $("a.postlink").click(function(){
              
                $('<input>').attr({
                type: 'hidden',
                id: 'foo',
                name: 'searchallfield',
                value:'<?php echo $searchallfield; ?>'
                }).appendTo('#pesearch');
                hrefval= $(this).attr("href");
                $("#pesearch").attr("action", hrefval);
                if($(this).attr("target")=='_blank') 
                { 
                    $("#pesearch").attr("target", "_blank");
                }  else {
                    $("#pesearch").attr("target", "_self");
                }
                /* if(($(this).find("target"))=='_blank') 
                { 
                    $("#pesearch").attr("target", "_blank");
                }   */ 
                $("#pesearch").submit();
                return false;
                
            });
            function resetinput(fieldname)
            {
           // alert($('[name="'+fieldname+'"]').val());
              $("#resetfield").val(fieldname);
              hrefval= 'index.php';
              $("#pesearch").attr("action", hrefval);
              $("#pesearch").submit();
                return false;
            }
            function resetmultipleinput(fieldname,fieldid,indexflagvalueid)
            {
              $("#resetfield").val(fieldname);
              $("#resetfieldid").val(fieldid);
              if(indexflagvalueid == 0 || indexflagvalueid == 1){
                  hrefval= 'index.php?value='+indexflagvalueid;
              }else if(indexflagvalueid == 3 || indexflagvalueid == 4 || indexflagvalueid == 5 ){
                  hrefval= 'svindex.php?value='+indexflagvalueid;
              }
              $("#pesearch").attr("action", hrefval);
              $("#pesearch").submit();
                return false;
            }
            /*$(".export").click(function(){
                $("#exportform").submit();
                return false;
            });*/
            <?php if(($exportToExcel==1))    {  ?> 
            
            $('#expshowdeals').click(function(){ 
            
                jQuery('#maskscreen').fadeIn();
                jQuery('#popup-box-copyrights').fadeIn();   
                return false;
            });
            <?php } ?>
               
            $('#expshowdealsbtn').click(function(){ 
               
                jQuery('#maskscreen').fadeIn();
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

                            if (currentRec < remLimit){
                                //hrefval= 'exportinvdeals.php';
                                //$("#pelisting").attr("action", hrefval);
                                $("#exportform").submit();
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
                
                 $('#mailbtn').click(function(e){ 
                    e.preventDefault();
                    if(checkEmail())
                    {
                    $.ajax({
                        url: 'ajaxsendmail.php',
                         type: "POST",
                        data: { to : $("#toaddress").val(), subject : $("#subject").val(), basesubject : $("#basesubject").val(), message : $("#message").val() , ymessage : $("#ymessage").val() , userMail : $("#useremail").val() },
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
                    return false;
                });
                $('#mailfnbtn').click(function(e){ 
                    e.preventDefault();
                    
                        $.ajax({
                            url: 'ajaxsendmail.php',
                             type: "POST",
                            data: { to : $("#toaddress_fc").val(), subject : $("#subject_fc").val(), message : $("#message_fc").val() , userMail : $("#useremail_fc").val() , comments:$("#comments").val(),toventure : 1 },
                            success: function(data){
                                    if(data=="1"){
                                         alert("Mail Sent Successfully");
                                        jQuery('#popup-box-financial').fadeOut();   
                                        jQuery('#maskscreen').fadeOut(1000);

                                }else{
                                    jQuery('#popup-box-financial').fadeOut();   
                                    jQuery('#maskscreen').fadeOut(1000);
                                    alert("Try Again");
                                }
                            },
                            error:function(){
                                jQuery('#preloading').fadeOut();
                                alert("There was some problem sending mail...");
                            }

                });

                    return false;
                });
        </script>

<div id="dialog-confirm" title="Guided tour Alert" style="display: none;">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="alertSpan"></span></p>
</div>
<script>    
        

</script>
<style>
.maclose a
{
color: #fff;
text-decoration: none;
cursor: pointer;
font-size:12px;
}
.maclose:hover,.maclose a:hover{
    color:#fff;
}
.maclose
{
    color: #fff;
    right: 0px;
   font-size: 20px;
    position: absolute;
    /* top: 1px; */
    height: auto;
    padding: 3px 1px 2px 1px;
    width: 15px;
    background: #413529;
    text-align: center;
}
div.token-input-dropdown-facebook{
z-index: 999;
}
.popup_content ul.token-input-list-facebook{
height: 39px !important;
width: 537px !important;
}
#popup-box{
top: 10%;
}
.entry p{
margin: 0px;
}
.popup_main
{
    position: fixed;
    left:0;
    top:0px;
    bottom:0px;
    right:0px;
    background: rgba(2,2,2,0.5);
    z-index: 999;
}
.popup_shp
{
    position: fixed;
    left:0;
    top:0px;
    bottom:0px;
    right:0px;
    background: rgba(2,2,2,0.5);
    z-index: 999;
}
.popup_box
{
width:70%;
height: 0;
position: relative;
left:0px;
right:0px;
bottom:0px;
top:35px;
margin: auto;

}

.pop_menu ul li {
margin-right: 0;
background: #413529;
margin-bottom: 10px;
width: 10%;
cursor: pointer;
text-align: center;
color: rgba(255,255,255,1);
display: table-cell;
vertical-align: middle;
height: 60px;
font-size: 14px;
}

.pop_menu ul li:first-child {
margin-right: 0;
background: #ffffff;
margin-bottom: 10px;
width: 10%;
cursor: pointer;
text-align: center;
color: #413529;
display: table-cell;
vertical-align: middle;
height: 60px;
font-size: 14px;
border:1px solid #413529;
}
.table-view{
max-height: 600px!important;
overflow-y: scroll;
width: 100%;
}
.popup_content {
background: #ececec;
border: 3px solid #211B15;
margin: auto;
}
.popup_form
{
width:700px;
border:1px solid #d5d5d5;
background: #fff;
height: 40px;
}
.popup_dropdown
{
 width: 155px;
 margin:0px;
 border: none;
 height: 40px;
 -webkit-appearance: none;
 -moz-appearance: none;
 appearance: none;
 background: url("images/polygon1.png") no-repeat 95% center;
 padding-left: 17px;
 cursor: pointer;
 font-size: 14px;
}
.popup_text
{
width:538px;
border: none;
border-left:1px solid #d5d5d5;
padding-left: 17px;
box-sizing: border-box;
height: 40px;
font-size: 16px;
float: right;
}
.auto_keywords
{
position: absolute;
top: 106px;
width:537px;
background: #fff;
    border:1px solid #d5d5d5;
    border-top: none;
    display: none;
}
.auto_keywords ul
{
line-height: 25px;
font-size: 16px;
}

.auto_keywords ul li
{
padding-left: 20px; 
cursor:pointer;
}
.auto_keywords ul li a
{
text-decoration: none;
color: #414141;
}
.auto_keywords ul li:hover
{
background: #f2f2f2;                                 
}
.popup_btn
{
text-align: center;
padding: 33px 0 50px;

}
.popup_cancel
{
background: #d5d5d5;
cursor: pointer;
padding:10px 27px;
text-align: center;
color: #767676;
text-decoration: none;
margin-right: 16px;
font-size: 16px;
display: none;

}
.popup_btn input[type="button"]
{
background: #a27639;
cursor: pointer;
padding:10px 27px;
text-align: center;
color: #fff;
text-decoration: none;
font-size: 16px;
float: right;

}
.popup_close
{
color: #fff;
right: 0px;
font-size: 20px;
position: absolute;
top: 1px;
width: 15px;
background: #413529;
text-align: center;
}
.popup_close a
{
color: #fff;
text-decoration: none;
cursor: pointer;
}

.popup_shp_close
{
color: #fff;
right: 0px;
font-size: 20px;
position: absolute;
top: 1px;
width: 15px;
background: #413529;
text-align: center;
}
.popup_shp_close a
{
color: #fff;
text-decoration: none;
cursor: pointer;
}

.popup_searching
{
width:538px;
float: right;
    position: relative;
}
div.token-input-dropdown{
    z-index: 999 !important;
}

.detail-table-div { display:block; float:left; overflow:hidden;border:1px solid #B3B3B3;}
.detail-table-div table{ border-top:0 !important; border-bottom:0 !important; width:auto !important; margin:0 !important;  }
.detail-table-div th{background:#E5E5E5; text-align:right !important;}
.detail-table-div td{ background:#fff; min-width:130px; text-align:right !important;}
/*.detail-table-div th:first-child {    max-width: 280px; text-align:left !important;
min-width: 280px;  background:#C9C2AF;}*/
.detail-table-div th:first-child {    max-width: 240px; text-align:left !important;min-width: 240px;  background:#C9C2AF;padding:8px;}
.detail-table-div.cfs-head th:first-child {    max-width: 330px; text-align:left !important;min-width: 330px;  background:#C9C2AF;padding:8px;}
.detail-table-div td:first-child {    max-width: 260px; text-align:left !important;min-width: 260px; background:#E0D8C3;}
.detail-table-div td { padding:8px;}

.tab-res {
display: block;
overflow-x: visible !important;
border: 1px solid #B3B3B3;
margin-left: 280px !important;
}
.tab-res.cfs-value{
display: block;
overflow-x: visible !important;
border: 1px solid #B3B3B3;
margin-left: 350px !important;
}
.tab-res table {
border-top: 0 !important;
border-right: 1px solid #B3B3B3;
width: auto !important;
margin: 0 !important;
}
.tab-res th{background:#E5E5E5; text-align:right !important;}
.tab-res td{ background:#fff; min-width:150px; text-align:right !important;padding:8px; border-right: 1px solid #b3b3b3;}
.tab-res table thead th {
border-bottom: 1px solid #b3b3b3;
border-right: 1px solid #b3b3b3;
text-align: left;
padding: 8px;
font-weight: bold;
}

.tab-res th {
background: #E5E5E5;
text-align: right !important;
}
detail-table-div table thead th:last-child {
border-right: 0 !important;
}

.tab-res table thead th {
border-bottom: 1px solid #b3b3b3;
}

#allfinancial {
display: inline-block; 
font-size: 17px;
color:#804040;
font-weight: bolder;
cursor:pointer;
float:right;
}
#allshp {
display: inline-block; 
font-size: 17px;
color:#804040;
font-weight: bolder;
cursor:pointer;
float:right;
}
.companyinfo .toolbox6 p, .dealinfo .toolbox6 p, .companyinfo .tooltip5 p, .dealinfo .tooltip5 p {
white-space: nowrap;
width: 100%;
overflow: hidden;
text-overflow: ellipsis;
}
/*.col-12 .tableInvest th:first-child {
width: 45% !important;
}*/
p.linktooltip a {
display: none;
}
p.linktooltip a:first-child{
display: block;
}
@media (min-width:1366px) and (max-width: 2559px) {
#allfinancial {
    margin-right: 5px;
}
}

@media (min-width:1366px) and (max-width: 2559px) {
#allshp {
    margin-right: 5px;
}
}

@media (max-width:1500px){
.popup_content {
    background: #ececec;
   /* height: 500px;*/
   height: calc(100% - -511px) !important;
}
.table-view{
    height: 400px;
    overflow-y: auto;
}
.popup_main {
    top: 45px;
}
.popup_shp {
    top: 45px;
}

}

@media (max-width:1025px){
   .popup_content {
        height: 500px;
    }
    .table-view{
        height: 400px;
    }
    .popup_main {
        top: 80px;
    }
    .popup_shp {
        top: 80px;
    }

    
}
@media (min-width:780px){
   
.list_companyname{
    margin-left:160px !important;
}
}
@media (min-width:1280px){
   
.list_companyname{
    margin-left:250px !important;
}
 #deal_info table, #company_info table{
    float: none !important;
        padding: 0px !important;
}
}
@media (max-width:1280px){
#deal_info table, #company_info table{
    float: none !important;
        padding: 0px !important;
}
td.investname {
    width: 38%;
}
}
@media (min-width:1439px){
   
.list_companyname{
    margin-left:340px !important;
}
}
@media (min-width:1639px){
   
.list_companyname{
    margin-left:520px !important;
}
}

@media (min-width:1921px){

.popup_content
{
    background: #ececec;
    height: 600px;
    overflow-y: auto;
}

}
.popup-button{

text-decoration: none;
font-size: 14px;
cursor: pointer;
text-transform: uppercase;
padding: 5px 0px 6px 5px;
color: #fff;
background-color: #A2753A;
width: 85px;
float: right;
text-align: center;

}
.popup-export{
width: 100%;
float: right;
padding: 0px 5px 5px 0px;
}


.more_info .mCSB_container
{
    margin-right: 10px !important; 
    margin-left: 10px !important;
}
.more_info .moreinfo_1{
padding-right:0px !important;
}
.col-p-12_1 {
width: 38.5%;
}
.more_info .mCSB_dragger_bar,.more_info .mCSB_draggerRail{
    margin-right: 0px !important;
}
/*Responsive CSS*/

@media (max-width:1280px){
.col-p-8 {
    width: 27.5%;
}
.col-md-6 {
   
    width: 100%;
}
.batchwidth{
    width: 20%;
}
}
@media (max-width: 1245px)
{
#container {
    margin-top: 90px !important;
}
.sec-header-fix {
    top: 48px !important;
}
.more_info{
    width: 30% !important;
}
.dealinfo{
    width: 30% !important;
}
.companyinfo{
    width: 40% !important;
}
}
@media only screen and (max-width: 1500px) and (min-width: 1281px){
/*.col-12 .tableInvest th:first-child {
    width: 35% !important;
}
td.investname {
    width: 35%;
}*/
.col-p-12 {
    width: 38.5%;
}
.col-p-8 {
    width: 27.5%;
}
.col-md-6 {
    width: 80%;
}
.batchwidth {
    width: 20%;
}
}
@media (max-width:1280px){
.companyinfo{
    width: 40%;
}
.dealinfo{
    width: 32%;
}
.more_info{
    width: 28%;
}
}
@media only screen and (max-width: 1079px) and (min-width: 920px){
.sec-header-fix {
    top: 48px !important;
}
#container {
    margin-top: 103px !important;
}

}
@media only screen and (max-width: 1024px) {
 .col-md-6 {
   
    width: 100%;
}
.batchwidth {
    width: 12%;
}
/*.col-12 .tableInvest th:first-child{
    width: 35% !important;
}*/
td.investname {
    width: 35%;
}
/*.companydealcontent, .section1 .work-masonry-thumb1{
    height: auto;
}*/
.companyinfo h4, .dealinfo h4, .companyinfo p, .dealinfo p, .tableInvest th, .tableInvest td, .tableInvest td a, .note-nia{
    font-size: 9pt !important;
}
#company_info{
    margin-right: 15px !important;
}
#deal_info{
    margin-right: 0px !important;
    width: 35% !important;
}
#container {
    margin-top: 144px !important;
}
.moreinfo_1{
    height: 220px;
}
.period-date+.search-btn{
    margin-top: 0px;
}
.sec-header-fix {
    top: 51px !important;border-bottom: 1px solid #fff;height: auto;
}
.clear-sm{
    clear: both;
}
#company_info{
    width: 62% !important;
}
.section1 .work-masonry-thumb1.more_info{
    height: auto;
}
.more_info{
    width: 100% !important;
}
.row.section1{
    display: block !important;
}
.col-md-6 {
    width: 100%;
    float: none;    padding-right: 0px;
}
.col-p-12 table, .col-p-8 table {
     padding: 0px; 
}
.moreinfo{
    padding: 6px 0px !important;
}
.row.masonry .col-6{
    width: 100%;
    padding: 0px;
}
.more_info .mCSB_container{
    margin-left:0px !important;
}
}
@media only screen and (max-width: 768px) {
#container {
    margin-top: 168px !important;
}
.batchwidth {
    width: 15%;
}
.sec-header-fix {
    top: 75px !important;
}
.col-12 .tableInvest .table-width1{
    width: 140px;
}
.col-12 .tableInvest .table-width2{
    width: 60px;
}
.col-12 .tableInvest .table-width3{
    width: 120px;
}
.row.masonry .col-6{
    width: 100%;
    padding: 0px;
}
/*.col-12 .tableInvest th:first-child{
    width: 30% !important;
}*/
td.investname {
    width: 30%;
}
.col-12 .tableInvest .table-width1{
    padding-right: 10px !important;
}
#deal_info, #company_info{
    width: 100% !important;margin-bottom: 15px;
}
}
/* Styles */


</style>
<div class="popup_main" id="popup_main" style="display:none;">

<div class="popup_box">
<!--  <h1 class="popup_header">Financial Details</h1>-->
<span class="popup_close"><a href="javascript: void(0);">X</a></span>
<div class="popup_content" id="popup_content">

</div>

</div>  
</div>

<div class="popup_shp" id="popup_shp" style="display:none;">

<div class="popup_box">
<!--  <h1 class="popup_header">Financial Details</h1>-->
<span class="popup_shp_close"><a href="javascript: void(0);">X</a></span>
<div class="popup_content" id="popup_content">
    <!-- Table -->
    <table align=left id="mutiple_investor" style="width: 90%;
            padding: 0px;
            margin: 25px 0px 0px 25px;" border=1 cellpadding=1 cellspacing=0>
            <thead>
                <tr>
                    <th colspan="2">Post Deal Shareholding Pattern (as if converted basis)</th>
                </tr>
                <tr>
                    <th style="width: 50%;">Shareholders</th>
                    <th> Stake held</th>
                </tr>
            </thead>
            <tbody id="mutirow_investor">
                <tr>
                    <td valign=top style="width: 50%;">PE-VC Investors</td>
                    <td valign=top><span style="float:right;" id="investor_total"><?php echo $mainTable_investor_total; ?></span></td>
                </tr>
                <!-- Edit Investor -->
                <?php
                    $getInvestorsSql="select * from pe_shp_investor where PEId=$IPO_MandAId ORDER BY id ASC";
                    if ($rsinvestors = mysql_query($getInvestorsSql))
                    {
                        $validate_investor = mysql_num_rows($rsinvestors);
                        if($validate_investor != 0){
                        $i=0;
                        While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                        {
                ?>
            <tr>
                <td valign=top> <input type="text" style="width:100%;" name="txtinvestor[]" value="<?php echo $myInvrow["investor_name"]; ?>"> </td>
                <td valign=top> <input type="text" name="txtinvestoramount[]" value="<?php echo $myInvrow["stake_held"]; ?>" style="width:100%;"> </td>
            </tr>

            <?php
                $i++;
                        }
                }
                }
            ?>
            <!-- End edit Investor -->
                <!-- <tr>
                    <td valign=top> <input type="text" style="width:100%;" name="txtinvestor[]"> </td>
                    <td valign=top> <input type="text" name="txtinvestoramount[]" value="0.00" style="width:100%;"> </td>
                    <input type="hidden" name="rowInvestorscount" id="rowInvestorscount" value="0" />
                </tr> -->
                </tbody>
        </table>
        <table align=left id="mutiple_investor" border=1 cellpadding=1 cellspacing=0 style="width: 90%;
            padding: 0px;
            margin: 0px 0px 0px 25px;">
            <thead>
                <tr>
                    <td valign=top style="width: 50%;">Promoters</td>
                    <td valign=top><span style="float:right;" id="promoters_total"><?php echo $mainTable_promoters_total; ?></span></td>
                </tr>
            </thead>
            <tbody id="mutirow_promoters">
            <?php
                    $getPromotorsSql="select * from pe_shp_promoters where PEId=$IPO_MandAId ORDER BY id ASC";
                    if ($rspromotors = mysql_query($getPromotorsSql))
                    {
                        $validate_promoters = mysql_num_rows($rspromotors);
                        if($validate_promoters != 0){
                        $i=0;
                        While($myProrow=mysql_fetch_array($rspromotors, MYSQL_BOTH))
                        {
                ?>
            <tr>
                    <td valign=top> <input type="text" name="txtpromoters[]" style="width:100%;" value="<?php echo $myProrow["promoters_name"]; ?>"> </td>
                    <td valign=top> <input type="text" name="txtpromotersamount[]" value="<?php echo $myProrow["stake_held"]; ?>" style="width:100%;"> </td>
                </tr>

            <?php
                $i++;
                        }
                }
                }
            ?>
            
                <!-- <tr>
                    <td valign=top> <input type="text" name="txtpromoters[]" style="width:100%;"> </td>
                    <td valign=top> <input type="text" name="txtpromotersamount[]" value="0.00" style="width:100%;"> </td>
                    <input type="hidden" name="rowPromoterscount" id="rowPromoterscount" value="0" />
                </tr> -->
            </tbody>
            
        </table>
        <table align=left id="mutiple_investor" border=1 cellpadding=1 cellspacing=0 style="width: 90%;
            padding: 0px;
            margin: 0px 0px 0px 25px;">
            <tr>
                <td valign=top style="width: 50%;"> ESOP </td>
                <td valign=top> <input type="text" name="txtesopamount" style="width:100%;" value="<?php echo $mainTable_ESOP; ?>"> </td>
            </tr>
            <tr>
                <td valign=top> Others </td>
                <td valign=top> <input type="text" name="txtothersamount" style="width:100%;" value="<?php echo $mainTable_Others; ?>"> </td>
            </tr>
        </table>
        
    <!-- Table -->
</div>
</div>  
</div>
<script>    

$(document).ready(function(){
    
    $('.popup_close a').click(function(){
        $(".popup_main").hide();
        $('body').css('overflow', 'scroll');
     });

     $('.popup_shp_close a').click(function(){
        $(".popup_shp").hide();
        $('body').css('overflow', 'scroll');
     });
     
     
     var cin = '<?php echo $cinno; ?>';
     $.ajax({
        url: 'pecfs_financial.php',
         type: "POST",
        data: { cin : cin,queryString:'INR' },
        success: function(data){
            $('#popup_content').html($.parseJSON(data))
                    
        },
        error:function(){
            jQuery('#preloading').fadeOut();
            alert("There was some problem sending mail...");
        }

    });
    
     
});
$(document).on('click','#pop_menu li',function(){
       window.open('<?php echo BASE_URL;?>cfsnew/details.php?vcid='+$(this).attr("data-row")+'&pe=1', '_blank');
});
$(document).on('click','.details_linkma',function(){
       window.open('<?php echo BASE_URL;?>ma/madealdetails.php?value='+$(this).attr("data-row")+'&pe=1', '_blank');
});
/* $(document).on('click','#popup_main',function(e) {

    var subject = $("#popup_content"); 
    //alert(e.target.id);
    
    if(e.target.id !== null || e.target.id !== '')
    {
        
        $(".popup_main").hide();
    }
});*/

</script>

<div id="maskscreen" style="opacity: 0.7; width: 1920px; height: 632px; display: none;"></div>
<div class="lb" id="popup-box-copyrights" style="width:650px !important;">
<span id="expcancelbtn" class="expcancelbtn" style="position: relative;background: #ec4444;font-size: 18px;padding: 0px 4px 2px 5px;z-index: 9022;color: #fff;cursor: pointer;float: right;">x</span>
<div class="copyright-body" style="text-align: center;font-size: 12px !important;">&copy; TSJ Media Pvt. Ltd. This data is meant for the internal and non-commercial use of the purchaser and cannot be resold, rented, licensed or otherwise transmitted without the prior permission of TSJ Media. Any unauthorized redistribution will constitute a violation of copyright law.
</div>
<div class="cr_entry" style="text-align:center;">
    
    <input type="button" value="I Agree" id="agreebtn" />
</div>

</div>


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
    $getRegionIdSql = "select Region,RegionId from region where RegionId=$regionidd";

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

function return_insert_get_CountryName($countryid)
{
    $dbregionlink = new dbInvestments();
    $getRegionIdSql = "select country from country where countryid='$countryid'";

     /*       if ($rsgetInvestorId = mysql_query($getRegionIdSql))
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
    }*/

    
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
        }else{
           // echo "<br>Investor count-- " .$investor_cnt;

        return $investor_cnt.$countryid;
    }
    }
    else{
        return "";
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
mysql_close();
?>
<script type="text/javascript" >
$(document).ready(function(){
 var $mapopheight=$('.ma-ajax').height();
 $('#ma_popup').height($mapopheight);
});
<?php // if(!$_POST)   { ?>
        /* $("#panel").animate({width: 'toggle'}, 200); 
         $(".btn-slide").toggleClass("active"); 
         if ($('.left-td-bg').css("min-width") == '264px') {
         $('.left-td-bg').css("min-width", '36px');
         $('.acc_main').css("width", '35px');
         }
         else {
         $('.left-td-bg').css("min-width", '264px');
         $('.acc_main').css("width", '264px');
         } */
                                    
    <?php // } ?>
                                    
</script> 





<script src="hopscotch.js"></script>


<?php if($_SESSION['vconly']==1){ ?>
<script src="demo_vconly.js"></script>
<?php } else { ?>
   <script src="demo_new.js"></script>
<?php } ?>

  <script type="text/javascript" > 
          
   $(document).ready(function(){
      var window_width = $(document).width();//alert(window_width); 
   <?php if(isset($_SESSION["demoTour"]) && $_SESSION["demoTour"]=='1') { ?>  
         demotour=1;     
         hopscotch.startTour(tour, 7); 
           
             
               //// multi select checkbox hide
        $('.ui-multiselect').attr('id','uimultiselect');    

       $("#uimultiselect, #uimultiselect span").click(function() {
            if(demotour==1)
                    {  showErrorDialog(warmsg); $('.ui-multiselect-menu').hide(); }     
        });
        
  <?php  } else if(isset($_SESSION["VCdemoTour"]) && $_SESSION["VCdemoTour"]=='1') { ?>  
          vcdemotour=1; 
          hopscotch.startTour(tour, 27);    

             
               //// multi select checkbox hide
        $('.ui-multiselect').attr('id','uimultiselect');    

       $("#uimultiselect, #uimultiselect span").click(function() {
            if(vcdemotour==1)
                    {  showErrorDialog(warmsg); $('.ui-multiselect-menu').hide(); }     
        });
        
  <?php  } ?>
     
     
     
        $('.companyProfileBox').on('click',function(){
            var box_position = $("#companyProfileBox").position().top - 220;
         $("html, body").animate({ scrollTop: box_position }, "slow");
     });
        
    });
    $(document).on('click','#financial_data',function(){
        jQuery('#maskscreen').fadeIn(1000);
        jQuery('#popup-box-financial').fadeIn();   
        return false;
    });
    $('#cancelfnbtn').click(function(){ 
                 
        jQuery('#popup-box-financial').fadeOut();   
        jQuery('#maskscreen').fadeOut(1000);
        return false;
    });
    </script>
    <script>
                                
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
  <?php
  mysql_close();
mysql_close($cnx);
?>
<script>
function BseLinkLoop(DealDate) {
    var CheckDate = new Date(DealDate);
    var Tday = new Date();
    if (((Tday - CheckDate) / (60 * 60 * 1000 * 24)) > 90) {
        var BseLinks = document.getElementsByTagName('a');
        for (var i = 0; i < BseLinks.length; i++) {
            if (BseLinks[i].href.includes('/AttachLive/')) {
                var newLink = BseLinks[i].href.replace('/AttachLive/', '/AttachHis/');
                BseLinks[i].href = newLink;
            }
        }
    }
}


function BseLinkUpdate() {
    var PageURL = window.location.pathname;

    if (PageURL == "/ma/madealdetails.php") {
        var DealDate = document.getElementsByClassName('tablelistview3')[0].getElementsByTagName('td')[7].textContent;
    }
    else if (PageURL == "/dealsnew/dealdetails.php"){
	var DealDate = document.getElementsByClassName('tablelistview3')[1].getElementsByTagName('td')[7].textContent;
    }
    else if (PageURL == "/dealsnew/mandadealdetails.php"){
	var DealDate = document.getElementsByClassName('tablelistview3')[1].getElementsByTagName('td')[5].textContent;
    }
    else if (PageURL == "/dealsnew/ipodealdetails.php" || PageURL == "/dealsnew/angeldealdetails.php"){
	var DealDate = document.getElementsByClassName('profiletable')[0].getElementsByTagName('li')[4].getElementsByTagName('p')[0].textContent
    }

    BseLinkLoop(DealDate);

}


window.onload = BseLinkUpdate()
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
           $(".btn-slide").click(function(){
            if($(window).width()<1300){
                        hidestring=27;
                        hidestring1 = 20;
                    }


            if ($('.left-td-bg').css("min-width") == '264px') {
                if($(window).width()<1500 && $(window).width() > 1280){
                    $('.col-md-6').css("width", '82%');
                } else if($(window).width() > 1500){
                    $('.col-md-6').css("width", '75%');
                } else if($(window).width() < 1280){
                    $('.col-md-6').css("width", '100%');
                }
             }
             else {
               // if($(window).width()<1500 && $(window).width() > 1280){
                    $('.col-md-6').css("width", '100%');
               // }
             } 
           });                         
$(document).ready(function(){
     
    var companytableoverall=$(".companyinfo_table").outerHeight()+50;
    var companytable=$(".companyinfo_table").outerHeight()+30;
    //alert(companytable);
    //$(".moreinfo_1").css("height",companytable);
    var tablecontent=$(".companyinfo").height();
    var topmanagement = '-'+$(".topmanagement").outerHeight();
    $(".topmanagement").css("top",topmanagement);

    // var linkanchor = '-'+$(".linkanchor").outerHeight();
    // $(".linkanchor").css("top",topmanagement);
    
    //$(".companydealcontent").css("height",companytableoverall);
    $('.moreinfo_1').mCustomScrollbar({ 
            theme:"dark-3",
        });
});
/* $(".accordions_dealtitle span").on("click", function() {

$(this).parent().toggleClass("active").next().slideToggle();
});*/

$(document).on('click','#allfinancial',function(event){
        event.stopPropagation();
        $(".popup_main").show();
        $('body').css('overflow', 'hidden');
});

$(document).on('click','#allshp',function(event){
        event.stopPropagation();
        $(".popup_shp").show();
        $('body').css('overflow', 'hidden');
});

$(".accordions_dealtitle").on("click", function() {

    $(this).toggleClass("active").next().slideToggle();
});
$(".accordions_dealtitle1 i").on("click", function() {
        $(this).parent().parent().parent().toggleClass("active").nextUntil('.accordions_dealtitle1').slideToggle();
        $(this).toggleClass('fa-plus fa-minus');

 }); 
 $(".matrans").on("click", function() {
    $(this).toggleClass("active").next().next().slideToggle();
    //alert($(this).hasClass("active"));
    <?php if($testingvariable==1){?>
    if($(this).hasClass("active")== true)
    {
        jQuery('.malb').fadeOut();
        jQuery('#ma_popup').fadeOut(500);
    
    }else{
        openPopUp();
    }
<?php } ?>
});
function openPopUp() {
  setTimeout(function(){
    popup();
  }, 4000);
}
function popup() {
    jQuery('#ma_popup').fadeIn();
    $('.malb').fadeIn();
    // $hrefval=$(this).attr("data-href");
    // $('#expcancelbtn-filter').attr('href',$hrefval);        
}
    $('.maclose').click(function(){

jQuery('.malb').fadeOut();
jQuery('#ma_popup').fadeOut(1000);

});
(function($){
    $(window).on("load",function(){

        $(".moreinfo_1").mCustomScrollbar('update');
         
    });
})(jQuery); 
</script>

<?php //if($board_cnt > 0) { ?>
 <script>
    $('.companydealcontent').mCustomScrollbar({ 
            theme:"dark-3"        
        }); 
        $(".tooltip7 span.lead").mouseover(function(){
           
                $(this).next().css("display","block");
            });
           $(".tooltip7 span.lead").mouseout(function(){
                    $(this).next().css("display","none");
                }); 

           $(".tooltip7 span.new").mouseover(function(){
            
                $(this).next().css("display","block");
            });
           $(".tooltip7 span.new").mouseout(function(){
          
                    $(this).next().css("display","none");
                });    
 </script>
<?php //}?>
<style>
/* .row.masonry{


-webkit-column-count: 2;
-moz-column-count: 2; 
column-count: 2;
  

}   
.accordian-group{ width: 100%;}*/
/*.row.masonry{
    display: flex;
flex-direction: column;
flex-wrap: wrap;
padding: 10px;
height: 100vw;
}*/
/*.accordian-group {
display: inline-block;

margin: 0 0 1.5em
width: 100%;
-webkit-transition:1s ease all;
box-sizing: border-box;
-moz-box-sizing: border-box;
-webkit-box-sizing: border-box;

}*/
</style>