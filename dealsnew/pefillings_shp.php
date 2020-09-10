<?php include_once("../globalconfig.php"); ?>



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
        $PEId = $strvalue[0];
        
        $_SESSION['usebackaction2']=$value; 
        setcookie("usebackaction2",$value);
        
        $dealdate = $_POST['dealdate'];
        $dealdate=date_create($dealdate);
        $dealdate=date_format($dealdate,"M Y");
        //echo ;
        
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
        $sql_investorauto_sug = "select  InvestorId as id,Investor as name from peinvestors where InvestorId IN($keyword) order by InvestorId";
            
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
        $filtersector = $_POST['filtersector'];
        $filtersubsector = $_POST['filtersubsector'];
        $sector=$_POST['sector'];
        $subsector=$_POST['subsector'];

        if($resetfield=="tagsearch") {

            $_POST['tagsearch']="";
            $_POST['tagsearch_auto'] = "";
            $tagsearch = "";
            $tagkeyword = "";
            
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
        $city=$_POST['citysearch'];
        if($resetfield=="exitstatus")
        { 
            $_POST['exitstatus']="";
            $exitstatusValue="";
        }
        else 
        {
            $exitstatusValue = $_POST['exitstatus'];
            if($exitstatusValue != NULL && $exitstatusValue != '--'){
                $searchallfield='';
            }
        }
         //valuation 
        $valuations=$_POST['valuations'];
        if($_POST['valuations'])
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


                    if ($sector != '' && (count($sector) > 0)) {
                        $sectorvalue = '';
                        $sectorstr = implode(',',$sector); 
                        $sectorssql = "select sector_name from pe_sectors where sector_id IN ($sectorstr)";
                       
                        if ($sectors = mysql_query($sectorssql)) {
                            while ($myrow = mysql_fetch_array($sectors, MYSQL_BOTH)) {
                                $sectorvalue .= $myrow["sector_name"] . ',';
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
                $stagesql= "select Stage from stage where StageId=$stageid";
            //  echo "<br>**".$stagesql;
                if ($stagers = mysql_query($stagesql))
                {
                    While($myrow=mysql_fetch_array($stagers, MYSQL_BOTH))
                    {
                                                $cnt=$cnt+1;
                        $stagevaluetext= $stagevaluetext. ",".$myrow["Stage"] ;
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

        if(count($regionId) >0)
            {
                    $region_Sql = $regionvalue = '';
                    foreach($regionId as $regionIds)
                    {
                        $region_Sql .= " RegionId=$regionIds or ";
                    }
                    $roundSqlStr = trim($region_Sql,' or ');
                    
                    $regionSql= "select Region from region where $roundSqlStr";
                    if ($regionrs = mysql_query($regionSql))
                    {
                        While($myregionrow=mysql_fetch_array($regionrs, MYSQL_BOTH))
                        {
                                    $regionvalue .= $myregionrow["Region"].', ';
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
            'Prefix' => $GLOBALS['root'] . $_GET['cname']
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
            //echo $object['Key'] . "<br>";
             $fileName =  $object['Key'];

            if($object['Size'] == 0){
                $foldername = explode("/", $object['Key']);
                //echo sizeof($foldername) . "<br>";print_r($foldername);
            } 
            

            // Get a pre-signed URL for an Amazon S3 object
            $signedUrl = $client->getObjectUrl($bucket, $fileName, '+60 minutes');
            // > https://my-bucket.s3.amazonaws.com/data.txt?AWSAccessKeyId=[...]&Expires=[...]&Signature=[...]

            $pieces = explode("/", $fileName);
            $pieces = $pieces[ sizeof($pieces) - 1 ];

            //foreach ($pieces as $it)
            //  echo $it ."<br>";

            $fileNameExt = $pieces;
            $ex_ext = explode(".", $fileName);
                $ext = $ex_ext[count($ex_ext)-1];
            //$ext = ".pdf";
                
            // ----------------------------------
            // test if the word ends with '.pdf'
            if ( strpos($fileNameExt, $ext) + strlen($ext) != strlen($fileNameExt) ){
                //echo "<BR>EXT";
                continue;
                }
            // ----------------------------------

            $c1 = $c1 + 1;

            if($object['form_date'] !=''){
                $uploaddate = date('d-m-Y',strtotime($object['form_date']));
            }else{
                $uploaddate = '';
            }
            

            $c2 = $c2 + 1;

            $str = "<li> <a href='". $signedUrl ."' target='_blank' >".  $pieces ."</a></li><BR>";

            $str = "<tr><td><a href='". $signedUrl ."' target='_blank'  >".  $pieces ."</a></td></tr>";
            $list .= "<tr><td><a href='". $signedUrl ."' target='_blank'  >".  $pieces ."</a></td></tr>";
            //if($foldername[2] != ''){
                $items1[$foldername[sizeof($foldername) - 2]][$pieces] = $signedUrl;    
            //}

            array_push($items, array('name'=>$str) );

        }   // foreach

        //Echo '</OL>';

        //print_r($items);

        //Echo $c2. " of ". $c1;

        $result = $c2. " of ". $c1;

    }


// Main Table Values For Percentage
$getMainTablesSql="select * from pe_shp where PEId=$PEId limit 1";
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
<style type="text/css">
    esop{
        float: right;
    }
    .detailtitle a {
        font-size: 21px !important;
        color: #333;
        font-weight: 600;
        text-decoration: none;
        text-transform: capitalize;
    }
    .text-center {
    text-align: center;
}
.detailtitle {
    position: relative !important;
    left: 0px !important;
}
.result-title {
    margin-left: -18px;
}
.result-select {
    border: none !important;
    padding: 12px 6px 0px 20px !important;
}
.result-title li {
    background: transparent !important;
    border: 1px solid #ccc;
}
.result-title li a {
    border-left: 1px solid transparent !important;
}

.pagetitle {
        font-size: 21px !important;
    color: #333;
    font-weight: 600;
    text-decoration: none;
    text-transform: capitalize;
    text-align: center;
    }
    .view-table table{
        border: 1px solid #b3b3b3;
    }
    .filing-cnt td a {
        color: #c0a172;
        text-decoration: underline;
        font-weight: normal;
        font-size: 14px;
    }

    ul .inner {
    /*border: 1px solid #afb0b3;*/
  overflow: hidden;
  display: none;
      border-top: none;
          text-indent: 40px;
}
ul .inner.show {
  /*display: block;*/
}
ul .inner li {
    padding: 10px 12px;
    margin: 0px !important;
    border-bottom: 1px solid #ccc;
}
ul .inner li:last-child{
    border-bottom: none;
}
ul .inner li a{
    color: #000000;
    font-size: 14px;
}
/*ul.accordionlist li {
  margin: 0.5em 0;
}*/
.filing-cnt {
    margin-top: 20px;
    border: 1px solid #b3b3b3;
    padding: 0px;
}
.filing-cnt h3 {
    color: #c0a172;
    font-weight: bold;
    font-size: 18px;
    padding: 10px;
}
ul li a.toggle {
    display: block;
    color: #000;
    padding: 10px 32px !important;
    border-radius: 0px;
    transition: background 0.3s ease;
    font-size: 16px;
    text-decoration: none;
    border-top: 1px solid #ccc;
    min-height: 16px;
    font-weight: 700;
}
.accordionlist a span{
     align-self: center;
    display: inline-block;
    /* vertical-align: sub; */
    position: absolute;
    left: 10px;
    font-family: "Font Awesome 5 Free";
    -webkit-font-smoothing: antialiased;
    display: inline-block;
    font-style: normal;
    font-variant: normal;
    text-rendering: auto;
    line-height: 1;
    font-weight: 700;
    color: #a37535;
}
.accordionlist a span:after {
    content: "\f07b";
    display: block;
}
.accordionlist a.active span:after {
    content: "\f07c";
    display: block;
}
.view-detailed{
        margin-top: 50px;position: relative;
}
.detailed-title-links a#previous{
    margin-top: -26px;
}
.shp_table {
  border-collapse: collapse !important;
}

/* .shp_table, th, td {
  border: 1px solid black !important;
} */
th.table_shareholder, .table_heading_tr, .table_stake_held {
border-top: 1px solid #000 !important;
border-bottom: 1px solid #000!important;
}
.shp_table th, .shp_table td {
border-right: 1px solid black !important;
border-left: 1px solid #000 !important;
}
.shp_table td{
    border-bottom:none !important;
}

.dynamic_table_val{
    padding-left: 30px !important;
}

.table_shareholder{
    background-color: #e0d8c3 !important;
    width: 70% !important;
}
.table_stake_held{
    background-color: #e0d8c3 !important;
}
.table_h3{
    text-align: center !important;
    background-color: #413529 !important;
    color: #fff !important;
    margin-bottom: 4px !important;
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
           $pageTitle="VC Investment";
           $refineUrl="refine.php";
}
elseif($VCFlagValue==1)
{
           $pageTitle="PE Investment";
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
        
                    //$SelCompRef=$value;
            $sql="SELECT pe.PECompanyId, pe.price_to_book, pe.book_value_per_share, pe.price_per_share, pec.companyname, pec.industry as industryId, i.industry, pec.sector_business,
         amount, round, s.Stage, stakepercentage, DATE_FORMAT( dates, '%b-%y' ) as dt, pec.website, pec.linkedIn, pec.city,
         pec.region,pe.PEId,comment,MoreInfor,hideamount,hidestake,pec.countryid,pec.CINNo,
        pe.InvestorType, its.InvestorTypeName,pe.StageId,pe.Link,pe.uploadfilename,pe.source,
            pe.Valuation,pe.FinLink,pec.RegionId, pe.AggHide, pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple,pe.listing_status,Exit_Status,
            pe.SPV,pe.Revenue,pe.EBITDA,pe.PAT,pe.Amount_INR, pe.Company_Valuation_pre,pe.Revenue_Multiple_pre,pe.EBITDA_Multiple_pre,pe.PAT_Multiple_pre, 
            pe.Company_Valuation_EV,pe.Revenue_Multiple_EV,pe.EBITDA_Multiple_EV,pe.PAT_Multiple_EV,pe.Total_Debt,pe.Cash_Equ,pe.financial_year,pec.CINNo, pec.Address1, pec.Address2, pec.Telephone,pec.Email,pec.tags
         FROM peinvestments AS pe, industry AS i, pecompanies AS pec,
        investortype as its,stage as s
         WHERE pec.industry = i.industryid
         AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15
         and pe.PEId=$SelCompRef and s.StageId=pe.StageId
         and its.InvestorType=pe.InvestorType ";
    //echo "<br>********".$sql;

    

    
        $global_hideamount=0;
        if ($companyrs = mysql_query($sql))
        {  ?>
                       
            <?php if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH))
            {
                    $industryId = $myrow["industryId"];
                    $regionid=$myrow["RegionId"];
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
<td class="profile-view-left" style="width:100%;">
    <div class="result-cnt"> 
        
            <?php if ($accesserror==1){?>
                        <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo BASE_URL; ?>contactus.htm" target="_blank">Click here</a></b></div>
            <?php
                    exit; 
                    } 
            
            ?>
                        
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
                            
        
                              <?php if($datevalueDisplay1!=""){  ?>
                                          <ul class="result-select" style="max-width:1440;">
                                              <li> 
                                                <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                              </li>
                                          </ul>
                                <?php } 
                                
                                   }
                                   else 
                                   { ?> 
                                 
                            
                                <ul class="result-select" style="max-width:1440;">
                                <?php
                                 //echo $queryDisplayTitle;
                                if($industry >0 && $industry!=null){ ?>
                                <li>
                                    <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 

                                if ($sector > 0 && $sector != null) {$drilldownflag = 0;?>
                                    <li>
                                        <?php echo $sectorvalue; ?><a  onclick="resetinput('sector');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php }
                                    
                                    if ($subsector > 0 && $subsector != null) {$drilldownflag = 0;?>
                                    <li>
                                        <?php echo $subsectorvalue; ?><a  onclick="resetinput('subsector');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                    </li>
                                    <?php }
                                    
                                if($stagevaluetext!="" && $stagevaluetext!=null) { ?>
                                <li> 
                                    <?php echo $stagevaluetext ?><a  onclick="resetinput('stage');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <!-- Round -->
                                <?php } 
              if($round!="--" && $round!=null && $roundTxtVal !=''){ $drilldownflag=0; ?>
                                <li> 
                  <?php echo $roundTxtVal; ?><a  onclick="resetinput('round');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
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
                                if($regionId>0){ ?>
                                <li> 
                                    <?php echo $regionvalue; ?><a  onclick="resetinput('txtregion');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <!-- City -->
                                <?php }  
                                if($city!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo $city; ?><a  onclick="resetinput('city');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <!-- -->
                                <?php }  
                                if (($startRangeValue!= "--") && ($endRangeValue != "")){ ?>
                                <li> 
                                    <?php echo "(USM)".$startRangeValue ."-" .$endRangeValueDisplay ?><a  onclick="resetinput('range');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                
                                 if($valuationstxt!=""){  ?>
                                  <li> 
                                    <?php echo str_replace('_', ' ', $valuationstxt);?><a  onclick="resetinput('valuations');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                  </li>
                                <?php } 
                                
                                if($datevalueDisplay1!=""){ ?>
                                <li> 
                                    <?php echo $datevalueDisplay1. "-" .$datevalueDisplay2;?><a  onclick="resetinput('period');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($debt_equity!="--" && $debt_equity!=null) { ?>
                                <li> 
                                    <?php echo  $debt_equityDisplay;?><a  onclick="resetinput('dealtype_debtequity');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                                if($keyword!="") { $drilldownflag=0; ?>
                                <li> 
                                    <?php echo trim($invester_filter);?><a  onclick="resetinput('keywordsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
                                <?php } 
                if($syndication!="--" && $syndication!=null) { $drilldownflag=0; ?>
              <li> 
                  <?php echo  $syndication_Display;?><a  onclick="resetinput('syndication');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
              </li>
              <?php } 
                                if($companysearch!=""){ $drilldownflag=0; ?>
                                <li> 
                                    <?php echo trim($company_filter);?><a  onclick="resetinput('companysearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                                </li>
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
                <li> 
                   <?php echo $exitstatusfilter; ?><a  onclick="resetinput('exitstatus');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
              <?php  } if($tagsearch!=''){ ?>
                <li> 
                   <?php echo "tag:".$tagsearch; ?><a  onclick="resetinput('tagsearch');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
                </li>
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
   
    
 <div class="view-detailed">
                            <div class="detailed-title-links" style="padding-bottom:0px !important;">
                                <div class="pagetitle"><?php echo $_GET['cname'];?></div>
                                <!-- test -->
                                <?php
                                    $url_cont = explode('/', $_GET['location_cont']);
                                    $location_cont = $url_cont[1];
                                    if($location_cont == '0-0' || $location_cont == '0-1' || $location_cont == '0-2' || $location_cont == '1-0' || $location_cont == '1-1'){ 
                                ?>
                                <a class="postlink" id="previous" href="mandadealdetails.php?value=<?php echo $_GET['location_cont'];?>">&lt; Back</a>
                                    <?php }else{ ?>
                                <a class="postlink" id="previous" href="dealdetails.php?value=<?php echo $_GET['value'];?>">&lt; Back</a>

                                    <?php } ?>
                                <!-- // end -->
                            </div>  
                            <input type="hidden"  id="currentdealdate" value="<?php echo $dealdate ?>">
                            <!-- Filings -->
                            <div class="view-table view-table-list filing-cnt" style="padding-top: 3px !important;width: 48%;float:left;">
                            <h3 class="table_h3" style="margin: 2px 5px;text-align: left !important;">Filings</h3>
                                <ul class="accordionlist">
                                    <?php 
                                    $pe_industries = explode(',', $_SESSION['PE_industries']);
           // print_r($pe_industries);
           // $industryId =56;
                                        if(sizeof($items1) > 0){
                                            foreach ($items1 as $folder => $innerArray) {
                                                if (is_array($innerArray)){
                                                    $liststr .= "<li><a class='toggle' data-dealdate='$folder' href='javascript:void(0);'> <span></span> $folder</a><ul class='inner'>";
                                                    foreach ($innerArray as $key => $value) {
                                                        $liststr .= "<li><a href='$value' target='_blank'  >$key</a></li>";
                                                    }
                                                    $liststr .= "</ul></li>";
                                                }
                                            }
                                            echo $liststr;
                                        } else if(!in_array($industryId,$pe_industries)){
                
                /*echo '<div style="font-size:20px;padding:10px 10px 10px 10px;"><b> You dont have access to this information!</b></div>';*/
                echo '<li style="font-size: 16px;padding: 10px;border-top: 1px solid #ccc;color: #c0a172;"><b> The filings section is currently not accessible. Please try after some time</b></li>';
               // exit;
            } 
                                        else {
                                            echo "<li style='font-size: 16px;padding: 10px;border-top: 1px solid #ccc;color: #c0a172;'>No Records Found</li>";
                                        }

                                    ?>
                                </ul>
                            </div>
                            <!-- SHP -->
                            
                                <?php
                                    if($Maintable_Valid_Count != 0){
                                ?>
                                <div class="view-table view-table-list filing-cnt" style="padding:10px !important;border: 2px solid #413529 !important;width: 46%;float:left;margin-left:25px;">
                                <h3 class="table_h3">Post Deal Shareholding Pattern (as if converted basis)</h3>
                                <table class="shp_table">
                                        <tr>
                                            <th class="table_shareholder">Shareholders</th>
                                            <th class="table_stake_held">Stake held</th>
                                        </tr>
                                        <tr class="table_heading_tr">
                                            <td>PE-VC Investor</td>
                                            <td>
                                                <investor_percentage style="float:right;font-weight: 100;">
                                                    <?php
                                                        if($mainTable_investor_total != ""){
                                                            echo $mainTable_investor_total."%";
                                                        } 
                                                    ?>
                                                </investor_percentage>
                                            </td>
                                        </tr>
                                        <?php
                                        $getInvestorsSql="select * from pe_shp_investor where PEId=$PEId ORDER BY id ASC";
                                        if ($rsinvestors = mysql_query($getInvestorsSql))
                                        {
                                            $validate_investor = mysql_num_rows($rsinvestors);
                                            if($validate_investor != 0){
                                                $i=0;
                                                While($myInvrow=mysql_fetch_array($rsinvestors, MYSQL_BOTH))
                                                {
                                                ?>
                                                <tr>
                                                    <td>
                                                    <sqlval style="padding-left: 50px;"><?php echo $myInvrow["investor_name"]; ?> </sqlval>
                                                    </td>
                                                    <td>
                                                        <?php echo $myInvrow["stake_held"]; ?>%
                                                    </td>
                                                </tr>
                                              
                                                <?php
                                                    $i++;
                                                }
                                            }else{
                                            ?>
                                                <td colspan="2">Investor Records Not Found</td>        
                                            <?php
                                            }
                                        }
                                    ?>
                                        <tr class="table_heading_tr">
                                            <td>Promoters</td>
                                            <td>
                                            <promoters_percentage style="float:right;font-weight: 100;">
                                                <?php
                                                    if($mainTable_promoters_total != ""){
                                                        echo $mainTable_promoters_total."%";
                                                    } 
                                                ?>
                                            </promoters_percentage>
                                            </td>
                                        </tr>
                                        
                                        <?php
                                            $getPromotorsSql="select * from pe_shp_promoters where PEId=$PEId ORDER BY id ASC";
                                            if ($rspromotors = mysql_query($getPromotorsSql))
                                            {
                                                $validate_promoters = mysql_num_rows($rspromotors);
                                                if($validate_promoters != 0){
                                                $i=0;
                                                While($myProrow=mysql_fetch_array($rspromotors, MYSQL_BOTH))
                                                {
                                                ?>
                                                <tr>
                                                    <td>
                                                    <sqlval style="padding-left: 50px;"><?php echo $myProrow["promoters_name"]; ?></sqlval> 
                                                    </td>
                                                    <td>
                                                    <?php echo $myProrow["stake_held"]; ?>%
                                                    </td>
                                                </tr>
                                                <?php
                                                    $i++;
                                                }
                                            }else{
                                            ?>
                                                
                                                <td colspan="2">Promoter Records Not Found</td>        
                                            <?php
                                            }
                                        }
                                    ?>
                                        
                                        <tr class="table_heading_tr">
                                            <td>ESOP</td>
                                            <td>
                                            <?php if($mainTable_ESOP != "--"){ ?>  
                                                    <esop><?php echo $mainTable_ESOP; ?>%</esop>
                                                <?php }else{ ?>
                                                    <esop>--</esop>        
                                            <?php }?> 
                                            </td>
                                        </tr>
                                        <tr class="table_heading_tr">
                                            <td>Others</td>
                                            <td>
                                            <?php if($mainTable_Others != "--"){ ?>  
                                                    <esop><?php echo $mainTable_Others; ?>%</esop>
                                                <?php }else{ ?>
                                                    <esop>--</esop>        
                                            <?php }?>  
                                            </td>
                                        </tr>
                                        </table>
                                        <?php }else { ?>
                                            <div class="view-table view-table-list filing-cnt" style="padding-top: 3px !important;width: 48%;float:left;margin-left:25px;">
                                            <h3 class="table_h3" style="margin: 2px 5px;text-align: left !important;">SHP</h3>
                                    <ul class="accordionlist">  
                                    <li style='font-size: 16px;padding: 10px;border-top: 1px solid #ccc;color: #c0a172;'>No Records Found</li>
                                    </ul>
                                
                                
                            </div>
                            <?php } ?>
                            
                        </div> 
                
<?php //include('dealcompanydetails.php'); ?> 
                        
            <?php if(($exportToExcel==1))
             {
             ?>
                             

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
 <form name="companyDisplay" method="post" id="exportform" action="exportdealinfo.php">
 <input type="hidden" name="txthidePEId" value="<?php echo $SelCompRef;?>" >
 <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
</form>
 <script type="text/javascript">
      
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
                /*$(".export").click(function(){
                    $("#exportform").submit();
                    return false;
                });*/
                
            </script>
    
<div id="dialog-confirm" title="Guided tour Alert" style="display: none;">
<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span><span id="alertSpan"></span></p>
</div>
<script>    
            
  
</script>
<style>
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
<script>    
   
    $(document).ready(function(){
        
        $('.popup_close a').click(function(){
            $(".popup_main").hide();
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
           window.open('<?php echo GLOBAL_BASE_URL; ?>cfsnew/details.php?vcid='+$(this).attr("data-row")+'&pe=1', '_blank');
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
<script type="text/javascript">

$(document).ready(function(){ 
    $('.toggle').click(function(e) {
        e.preventDefault();
      
        var $this = $(this);
      $('.toggle').removeClass('active');
        if ($this.next().hasClass('show')) {
            $this.next().removeClass('show');
            
            $this.next().slideUp(350);
        } else {
            $this.parent().parent().find('li .inner').removeClass('show');

            $this.parent().parent().find('li .inner').slideUp(350);
            $this.next().toggleClass('show');
            $(this).toggleClass('active');
            $this.next().slideToggle(350);
        }
    });
    //$("#currentdealdate").val();
    var currentdealdate = $("#currentdealdate").val();
    $("[data-dealdate='"+currentdealdate+"']").trigger("click");
    //$(".accordionlist li:first-child .toggle").trigger("click");
});
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

    function return_insert_get_CountryName($countryid)
    {
        $dbregionlink = new dbInvestments();
        $getRegionIdSql = "select country from country where countryid='$countryid'";

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
mysql_close();
?>
<script type="text/javascript" >
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
         
         
         
            
        </script>
       
      <?php
      mysql_close();
    mysql_close($cnx);
    ?>
    <script>
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
     
</script>
<?php //if($board_cnt > 0) { ?>
     <script>
        $('.companydealcontent').mCustomScrollbar({ 
                theme:"dark-3"        
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