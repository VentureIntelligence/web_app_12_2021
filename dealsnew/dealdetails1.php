<?php include_once("../globalconfig.php"); ?>
<?php
    /*echo '<pre>';
   print_r($_POST);
   echo '</pre>';*/
	require_once("../dbconnectvi.php");
	$Db = new dbInvestments();
        $value = isset($_REQUEST['value']) ? $_REQUEST['value'] : '';
        $strvalue = explode("/", $value);
        
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

        if( isset( $_POST[ 'pe_checkbox_amount' ] ) ) {
            $pe_amount = $_POST[ 'pe_checkbox_amount' ];
        } else {
            $pe_amount = '';
        }

        if( isset( $_POST[ 'pe_checkbox_company' ] ) ) {
            $pe_company = $_POST[ 'pe_checkbox_company' ];
        } else {
            $pe_company = 0;
        }

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
        { $videalPageName="REInv";
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
                                      WHERE pedb.PEId = pe.PEId
                                      AND pe.Deleted =0
                                      AND pedb.DBTypeId = '$dbtype'
                                      AND s.StageId = pe.StageId
                                      ORDER BY DisplayOrder";
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
        $stageval=$_POST['stage'];
        if($_POST['stage'])
        {
                $boolStage=true;
                //foreach($stageval as $stage)
                //	echo "<br>----" .$stage;
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
                //	echo "<br>----" .$stage;
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
{	$datevalueDisplay1 = returnMonthname($month1) ." ".$splityear1;
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
			//	echo "<br>**".$stagesql;
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
            
            $dealvalue=$strvalue[2];
            $topNav = 'Directory'; 
            include_once('dirnew_header.php');
        }else{
            $topNav = 'Deals'; 
            include_once('tvheader_search_detail.php');
        }
?>
<style>

#deal_info table, #valuation_info table, #financials_info table, #investor_info table, #company_info table, #advisor_info table {
    padding: 0px !important;
    width: 100%;
    border-top: none;
    box-sizing: border-box;
}
#deal_info tbody, #valuation_info tbody, #financials_info tbody , #investor_info tbody, #company_info tbody, #advisor_info tbody {
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
.moreinfo.more-content, .com-cnt-sec header h3, .work-masonry-thumb h2 {
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

</style>
<div id="container" >
    <table cellpadding="0" cellspacing="0" width="100%" style="margin-top:-10px" >  
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
	     amount, round, s.Stage, stakepercentage, DATE_FORMAT( dates, '%b-%y' ) as dt, pec.website, pec.city,
	     pec.region,pe.PEId,comment,MoreInfor,hideamount,hidestake,
	    pe.InvestorType, its.InvestorTypeName,pe.StageId,pe.Link,pe.uploadfilename,pe.source,
            pe.Valuation,pe.FinLink,pec.RegionId, pe.AggHide, pe.Company_Valuation,pe.Revenue_Multiple,pe.EBITDA_Multiple,pe.PAT_Multiple,pe.listing_status,Exit_Status,
            pe.SPV,pe.Revenue,pe.EBITDA,pe.PAT,pe.Amount_INR, pe.Company_Valuation_pre,pe.Revenue_Multiple_pre,pe.EBITDA_Multiple_pre,pe.PAT_Multiple_pre, 
            pe.Company_Valuation_EV,pe.Revenue_Multiple_EV,pe.EBITDA_Multiple_EV,pe.PAT_Multiple_EV,pe.Total_Debt,pe.Cash_Equ,pe.financial_year,pec.CINNo
            FROM peinvestments AS pe, industry AS i, pecompanies AS pec,investortype as its,stage as s
	     WHERE pec.industry = i.industryid
	     AND pec.PEcompanyID = pe.PECompanyID and pe.Deleted=0 and pec.industry !=15
            and pe.PEId=$SelCompRef and s.StageId=pe.StageId and its.InvestorType=pe.InvestorType ";
	//echo "<br>********".$sql;

	$investorSql="select peinv.PEId,peinv.InvestorId,inv.Investor,peinv.Amount_M,peinv.Amount_INR,hide_amount from peinvestments_investors as peinv,
		peinvestors as inv where peinv.PEId=$SelCompRef and inv.InvestorId=peinv.InvestorId ORDER BY Investor='others',InvestorId desc";
	//echo "<Br>Investor".$investorSql;

	$advcompanysql="select advcomp.PEId,advcomp.CIAId,cia.cianame,AdvisorType from peinvestments_advisorcompanies as advcomp,
	advisor_cias as cia where advcomp.PEId=$SelCompRef and advcomp.CIAId=cia.CIAId";
	//echo "<Br>".$advcompanysql;

	$advinvestorssql="select advinv.PEId,advinv.CIAId,cia.cianame,AdvisorType from peinvestments_advisorinvestors as advinv,
	advisor_cias as cia where advinv.PEId=$SelCompRef and advinv.CIAId=cia.CIAId";
        
        $global_hideamount=0;
            if ($companyrs = mysql_query($sql)){  
                       
                if($myrow=mysql_fetch_array($companyrs,MYSQL_BOTH)){

                    $industryId = $myrow["industryId"];
                    $regionid=$myrow["RegionId"];
                    if($regionid>0)
                    { $regionname=return_insert_get_RegionIdName($regionid); }
                    else
                    { $regionname=$myrow["region"]; }
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
        padding:3px 0px 0px 0px;
        font-size:22px;
    }
    .inner-section  .action-links{
        margin:0px;
    }
    .action-links img{
        margin-top: 4px;
        margin-right:5px;
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
                        <div class="alert-note"><b>You are not subscribed to this database. To subscribe <a href="<?php echo GLOBAL_BASE_URL; ?>dd-subscribe.php" target="_blank">Click here</a></b></div>
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

                                                         <a class="export" id="expshowdeals" name="showdeal">Export</a>


                                     <?php
                                     }else { ?>
                                                         <a class ="export" id="expshowdeals" target="_blank" href="../Sample_Sheet_Investments.xls"  style="float:right">Sample Export</a>
                                 <?php } ?>
                             </div>
        
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
                                   <!-- <h2>
                                   <?php
                                 /*if($studentOption==1 || $exportToExcel==1)
                                        {*/
                                     ?>
                                          <span class="result-no"><?php echo $totalcount; //count($prevNextArr); ?> Results Found (across <?php echo $coscount; ?> cos) </span> 
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

                                                         <a class="export" id="expshowdeals" name="showdeal">Export</a>


                                     <?php
                                     }else { ?>
                                                         <a class ="export" id="expshowdeals" target="_blank" href="../Sample_Sheet_Investments.xls" style="float:right">Sample Export</a>
                                 <?php } ?>
                                 
                             </div>
                                <ul class="result-select" style="max-width:1440;">
                                <?php
                                 //echo $queryDisplayTitle;
                                if($industry >0 && $industry!=null){ ?>
                                <li>
                                    <?php echo $industryvalue; ?><a  onclick="resetinput('industry');"><img src="images/icon-close.png" width="9" height="8" border="0"></a>
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
    <div class="list-tab mt-list-tab detail-view-header">
    <ul class="inner-list inner-list_width1">
            <li><a class="postlink list-view"  href="<?php echo $actionlink; ?>"  id="icon-grid-view"><!--<img src="images/list-icon.png" />--><i></i> List View</a></li>
            <li class="active"><a id="icon-detailed-view" class="postlink detail-view"  href="dealdetails.php?value=<?php echo $_GET['value'];?>" ><!--<img src="images/bar-icon.png" />--><i></i> Detail View</a></li> 
            </ul>
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
                               <h2> <a class="postlink companyProfileBox" href='javascript:void(0)'><?php echo stripslashes($string);?>
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
                              <h2> <?php echo rtrim($searchString);?></h2>
                      <?php
                           }
                      
            if($strvalue[3]!='Directory'){ ?>
                <div class="inner-section inner-section-width1">
                    <div class="action-links">
                    <?php if ($prevKey!='-1') {?> <a  class="postlink" id="previous" href="dealdetails.php?value=<?php echo $prevNextArr[$prevKey]; ?>/<?php echo $VCFlagValue;?>/"> <img src="images/back_black.png" title="Previous" alt="Previous" /></a><?php }else{ ?><img src="images/back_grey.png" style="cursor:no-drop; margin-right:10px;" /> <?php } ?>
                    <?php if ($nextKey < count($prevNextArr)) { ?><a class="postlink" id="next" href="dealdetails.php?value=<?php echo $prevNextArr[$nextKey]; ?>/<?php echo $VCFlagValue;?>/"><img src="images/forward_black.png" title="Next" alt="Next" />   </a>  <?php }else{ ?><img src="images/forward_grey.png" style="cursor:no-drop;" /> <?php } ?>
                    </div>
                </div>
            <?php } ?>
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
                    <h5>Your Message</h5><span style='float:right;'>Words left: <span id="word_left">200</span></span>
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
                    <input type="text" name="toaddress_fc" id="toaddress_fc"  value="database@ventureintelligence.com"/>
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
                <input type="button" value="Submit" id="mailfnbtn" />
                <input type="button" value="Cancel" id="cancelfnbtn" />
            </div>

        </form>
    </div>                   
    <div class="view-detailed"> 
         <!--div class="detailed-title-links"> <h2>  <?php echo $myrow["companyname"]; ?></h2-->
           <!--  <div class="detailed-title-links">
                    </div> -->
            
            
    
        <div class="postContainer postContent masonry-container">
            <div class="deal_outerbox"> 
            <div  class="work-masonry-thumb1 col-p-7" id="deal_info" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
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
        </div>
      <style>
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
    <div  class="work-masonry-thumb1 col-p-12" id="valuation_info" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
      <h2 id="investmentinfo" class="box_heading content-box ">Valuation Info </h2>  
      <table cellpadding="0" cellspacing="0" class="tablelistview">
        <tbody>
        <?php
          /*  if($dec_company_valuation <= 0 && $dec_company_valuation2 <= 0 &&  $dec_revenue_multiple <= 0 && $dec_revenue_multiple2 <= 0 && $dec_ebitda_multiple <= 0 && $dec_ebitda_multiple2 <= 0 && $dec_pat_multiple <= 0 && $dec_pat_multiple2 <= 0)
            {
          
                
                ?>  
            <tr>
                <td><h4>&nbsp;</h4></td> 
                <td><h4 class="title_ctr" <?php if($fields_class == "display_none"){ echo 'style=""'; } ?>>Post-Money</h4></td>
            </tr>
            <tr>
                <td id="tourinvestor" class="<?php echo $valuation_label; ?>">
                    <h4>Valuation (&#8377; Cr)</h4>
                </td>
                
                <td class=""><p class="content-align">
                 <?php
                    if($dec_company_valuation1 >0 && $dec_company_valuation1 !='')
                        { ?>
                      <?php  echo $dec_company_valuation1; 
                      }else{ ?>
                            <?php   echo '-';
                        }  ?></p></td> 
                
            </tr>
            <tr>
                <td id="tourinvestor" class="<?php echo $valuation_label; ?>">
                    <h4>Revenue Multiple </h4>
                </td>
                
                <td class=""><p class="content-align">
                 <?php
                        if($dec_revenue_multiple1 >0 && $dec_revenue_multiple1 !='')
                            { ?>
                          <?php  echo $dec_revenue_multiple1; 
                          }else{ ?>
                                <?php   echo '-';
                            }  ?></p></td> 
               
            </tr>
            <tr>
                <td id="tourinvestor" class="<?php echo $valuation_label; ?>" >
                    <h4>EBITDA Multiple</h4>
                </td>
                
                <td class=""><p class="content-align">
                 <?php
                        if($dec_ebitda_multiple1 >0 && $dec_ebitda_multiple1 !='')
                            { ?>
                          <?php  echo $dec_ebitda_multiple1; 
                          }else{ ?>
                                <?php   echo '-';
                            }  ?></p></td> 
                
            </tr>
            <tr>
                <td id="tourinvestor" class="<?php echo $valuation_label; ?>">
                    <h4>PAT Multiple</h4>
                </td>
                
                <td class=""><p class="content-align">
                 <?php
                        if($dec_pat_multiple1 >0 && $dec_pat_multiple1 !='')
                            { ?>
                          <?php  echo $dec_pat_multiple1; 
                          }else{ ?>
                                <?php   echo '-';
                            }  ?></p></td> 
                
            </tr>
          <?php  }else if(($dec_company_valuation > 0 || $dec_revenue_multiple > 0 || $dec_ebitda_multiple > 0 || $dec_pat_multiple > 0)){ */
                 
               /* if(($dec_company_valuation2 > 0 || $dec_revenue_multiple2 > 0 || $dec_ebitda_multiple2 > 0 || $dec_pat_multiple2 > 0)){
                    $fields_class_post= "display_none";
                }elseif(($dec_company_valuation1 > 0 || $dec_revenue_multiple1 > 0 || $dec_ebitda_multiple1 > 0 || $dec_pat_multiple1 > 0)){
                    $fields_class_ev= "display_none";
                }else{
                    $fields_class_both= "display_none";
                }*/
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
                    <td class="<?php echo $fields_class_both; ?>"><h4 class="title_ctr">Post-Money</h4></td>
              <?php if($field_class_ev !=0){ ?>
                    <td class="<?php echo $fields_class_ev; echo $fields_class_both;?>"><h4 class="title_ctr">EV</h4></td>
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
        </div>  
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
            <div  class="work-masonry-thumb1  <?php if($financial_label == "financial_label1") { echo "col-p-11_1"; }else{ echo "col-p-11"; echo " fullBox"; } ?>" id="financials_info" href="http://erikjohanssonphoto.com/work/aishti-ss13/">
            <div class="box_heading content-box ">
            <h2 style="padding-right:5px; width:95%;">Financials&nbsp;<span id="allfinancial">(Latest P&amp;L)</span></h2>

        <?php /*if($Cash_Equ !='' && $Total_Debt !='' && $file !='') { ?>
        <a href="<?php echo $file;?>" class="download-link download-link-size1">Download excel</a>
        <?php }*/ ?>
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
               <!-- <?php
               /* if($exportToExcel==1)
                 {
                 ?>
                
                    <?php                 
                    if($myrow["uploadfilename"]!="")
                    {
                        $uploadname=$myrow["uploadfilename"];
                        $currentdir=getcwd();
                        $target = $currentdir . "../uploadmamafiles/" . $uploadname;
                        $file = "../../uploadmamafiles/" . $uploadname;
                            ?>
                        <tr>
                            <td class="txtBold" colspan="3">
                                <h4><a href="<?php echo $file;?>" target="_blank" > Download Excel File </a></h4>
                            </td>
                        </tr>
                    <?php } ?>
                 <?php
                 }
                else
                 {
                 ?>
                <tr>
                             <td>&nbsp;Paid Subscribers can view a link to the co. financials here </td> </tr>
                 <?php
                  }*/
                 ?>-->
        
        
        
        <!-- pecompany links -->
        <!-- <?php if(mysql_num_rows($company_link_Sql)>0){ ?>
        <tr> <td><h4> Links & Comments </h4></td><td>
  
         <?php while($com_links_com = mysql_fetch_array($company_link_Sql)) { ?>
         <p style="font-weight: normal;margin:2px  0 8px;line-height: 20px;"><a href='<?php echo $com_links_com['Link']?> ' target="_blank" style="font-weight: bold;"> <?php echo $com_links_com['Link']?>  </a> <br> <?php echo $com_links_com['Comment']?>  </p> 
        <?php } ?>
         </td></tr>
        <?php } ?>-->
        <!-- end pecompany links -->
        <?php /*if(($Cash_Equ =='' || $Total_Debt =='') && $file !='') { ?>
        <tr>
        <td colspan="2" class="download-file">
        <a href="<?php echo $file;?>" class="download-link">Download excel</a>
        </td>
        </tr>
        <?php }*/ ?>
     </tbody>
        </table> 
        </div>  
                        
    <div style="clear:both"></div>
    <div  class="work-masonry-thumb1 col-p-9" id="investor_info" href="http://erikjohanssonphoto.com/work/aizone-ss13/" style=" margin-bottom: 20px;">
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
                                    While($myInvrow=mysql_fetch_array($getcompanyrs, MYSQL_BOTH))
                                    {
                                        
                                        $Investorname=trim($myInvrow["Investor"]);
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
                                             $Investorname=strtolower($Investorname);

                                             $invResult=substr_count($Investorname,$searchString);
                                             $invResult1=substr_count($Investorname,$searchString1);
                                             $invResult2=substr_count($Investorname,$searchString2);
                                             if(($invResult==0) && ($invResult1==0) && ($invResult2==0))
                                             {
                                                 $_SESSION['investId'][$invcount++] = $investor_ID[$l];
                                                 $deal=0; ?><a id="investor<?php echo $investor_ID[$l]; ?>" class="postlink  tourinvestor<?php echo $investor_ID[$l]; ?>" href='investordetails.php?value=<?php echo $investor_ID[$l].'/'.$strvalue[1].'/'.$strvalue[2].'/'.$strvalue[3];?>' ><?php echo $investor_Name[$l]; ?></a>
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
                    </div>  
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
                            include_once 'advisor_box.php';
                    }
        ?>
                    <div  class="work-masonry-thumb1 col-p-10" id="company_info" href="http://erikjohanssonphoto.com/work/aizone-ss13/">
                    <h2 id="companyinfo" class="box_heading content-box ">Company Info</h2>
                    <table cellpadding="0" cellspacing="0" class="tablelistview3">
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
                            $string = strip_tags($string);
                            if (strlen($string) > 29) { 
                                $string = substr($string,0,29);
                                $string = trim($string).'...';
                                $display = 'yes';
				}
                            ?>
                        <div class="tooltip-4"><p> <?php echo $openDebtBracket;?><?php echo $openBracket;?><A class="postlink" href='companydetails.php?value=<?php echo $myrow["PECompanyId"].'/'.$strvalue[1].'/'.$strvalue[2].'/'.$strvalue[3];?>' >
				<?php echo $string;?></a><?php echo $closeBracket;?><?php echo $closeDebtBracket;?>
                            </p></div>
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
                                        <td style=""><h4>Company</h4> <p><b>&nbsp;<?php echo ucfirst("$searchString") ;?></b></p></td>
		<?php
				}
		?>
                                        <?php if($myrow["city"]!="") { ?><td style=""><h4>City</h4></td>
                                        <td class="" style=""><p><?php echo  $myrow["city"];?></p></td> <?php } ?>
                      </tr>
                        <tr>  
                            <?php if($myrow["industry"]!="") { ?>  <td><h4>Industry</h4> </td>
                            <td class=""><p><?php echo $myrow["industry"];?></p></td>  <?php } ?>
                             <?php if($regionname!="") { ?><td><h4>Region</h4></td><td class=""> <p><?php echo $regionname;?></p> </td> <?php } ?>
                      </tr>
                        <tr>  
                           <td>
                                <h4>Sector </h4>
                           </td>
                            <?php 
                            $display = 'no';
                            $string =trim($myrow["sector_business"]);
                            $string = strip_tags($string);
                            if (strlen($string) > 27) { 
                                $string = substr($string,0,27);
                                $string = trim($string).'...';
                                $display = 'yes';
				}
                            ?>
                            <td class="tooltip5"> 
                              <p>
                                <?php echo $string;?>
                              <?php   if($display == 'yes'){ ?>
                                  <div class="tooltip-box5"><?php echo $myrow["sector_business"];?></div>
                              <?php } ?>
                              </p>
                            </td>
                        <td>
                            <h4>Website</h4>
                    <div style="display:none"><?php echo $webdisplay; ?></div>
                        </td>
                      <?php 
                            $display = 'no';
                            $string =$webdisplay;
                            $string = strip_tags($string);
                            if (strlen($string) > 24) { 
                                $string = substr($string,0,24);
                                $string = trim($string).'...';
                                $display = 'yes';
				}
                            ?>
                        <td class="toolbox6"> 
                            <a href=<?php echo $webdisplay; ?> target="_blank"><p><?php echo $string; ?></p>
                              <?php   if($display == 'yes'){ ?>
                                    <div class="tooltip-box6"><?php echo $webdisplay; ?></div>
                              <?php } ?>
                                </a>
                        </td>
                        
                        </tr>
                      <tr>
                     <td><h4>Type</h4></td>
                    <td class=""> <p><?php echo $listing_stauts_display;?></p></td>
                    <td><h4>News Link</h4></td>
                    <td class="no-btn-padding">
                        <div class="tooltip-3">
                        <p style="word-break: break-all;">
                                <?php
                            $display = 'no'; $news_link='';
                            if(count($linkstring)>0 && $col6 !='') { 
                                $string = $stortlink = '';
                                foreach ($linkstring as $linkstr) {
                                    if(trim($linkstr)!=="") {
                                        if($string == '' && $display == 'no'){
                                            // strip tags to avoid breaking any html
                                            $string = strip_tags($linkstr);

                                            if (strlen($string) > 24) {
                                                $string = substr($string,0,24);  
                                                $string = trim($string).'...';
						}
                                            $stortlink = "<a href='".$linkstr."' target='_blank'>".$string."</a>";
					}
                                        if($news_link != ''){
                                            //$news_link .= "<br/>";
                                            $display = 'yes';
                                        }
                                        $news_link .= "<a href='".$linkstr."' target='_blank'>".$linkstr."</a>";  
                                    }
                                }
                                echo $stortlink;
                            }else{ echo '&nbsp;'; } ?>
                        </p>	</div>
                        <?php if($display == 'yes'){ ?>
                         <div class="tooltip-box3">
                    <?php echo $news_link; ?>
                        </div> <?php } ?>
                    </td>
                     </tr>
                    </table>
            </div>   
                  <?php 
                        if($totalInvestor <= 2 || $totalAdvisor <=4){
                            include_once 'advisor_box.php';
                        }
                  ?>    
        </div>
          	
                        <div style="clear:both"></div>
                        <div  class="work-masonry-thumb1 col-p-4" href="http://erikjohanssonphoto.com/work/tac-3/" style="float:left;">
                 <h2 id="moreinfo" class="moreinfo more-content">More Info</h2>
                                                               
                 <table class="tablelistview" cellpadding="0" cellspacing="0" style="background:#fff;">
                      <tr>  <td class="more-info"><p><?php print nl2br($moreinfor); ?></p>
                              <p><a id="clickhere" href="mailto:database@ventureintelligence.com?subject=Request for more deal data-<?php echo $pageTitle;?>&body=<?php echo $mailurl;?> ">
                                      Click Here</a> to request more details for this deal. Please specify what details you would like - financials, valuations, etc. - and we will revert with the data points as available. Note: For recent transactions (say within last 6 months), additional information availablity is typically less than for older ones.
                              </p></td></tr></table>
           </div></div></div>
                        
                        <div style="clear:both"></div>
                        
                        
<?php include('dealcompanydetails.php'); ?>
                        
            <?php if(($exportToExcel==1))
             {
             ?>
                             <div class="title-links">
                                             <a class="export" id="expshowdealsbtn" name="showdeal">Export</a>
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
<input type="hidden" name="pe_checkbox" id="pe_checkbox" value="<?php echo $pe_checkbox; ?>" />
<input type="hidden" name="pe_amount" id="pe_amount" value="<?php echo $pe_amount; ?>" />
<input type="hidden" name="pe_company" id="pe_company" value="<?php echo $pe_company; ?>" />
</form>
 <form name="companyDisplay" method="post" id="exportform" action="exportdealinfo.php">
 <input type="hidden" name="txthidePEId" value="<?php echo $SelCompRef;?>" >
 <input type="hidden" name="txthideemail" value="<?php echo $emailid;?>" >
</form>
 <script type="text/javascript">
     
     $(document).ready(function() {
         
     $('.list-tab').css('margin-top',$('.result-title').innerHeight());
     
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
                <?php if(($exportToExcel==1))    {  ?> 
                $('#expshowdeals').click(function(){ 
                    jQuery('#preloading').fadeIn();   
                    initExport();
                    return false;
                });
                <?php } ?>
                    
                $('#expshowdealsbtn').click(function(){ 
                    jQuery('#preloading').fadeIn();   
                    initExport();
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
                                data: { to : $("#toaddress_fc").val(), subject : $("#subject_fc").val(), message : $("#message_fc").val() , userMail : $("#useremail_fc").val() , toventure : 1 },
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
div.token-input-dropdown-facebook{
    z-index: 999;
}
.popup_content ul.token-input-list-facebook{
    height: 39px !important;
    width: 537px !important;
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
.popup_content
{
	background: #ececec;
        border:3px solid #211B15;
        max-height:750px;
        overflow:scroll;
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
.detail-table-div td:first-child {    max-width: 240px; text-align:left !important;min-width: 240px; background:#E0D8C3;}
.detail-table-div td { padding:8px;}
    
.tab-res{ display:block; overflow-y:hidden !important; overflow:auto; border:1px solid #B3B3B3; margin:10px 0 !important;}
.tab-res table{ border-top:0 !important; border-bottom:1px solid #B3B3B3; border-right:1px solid #B3B3B3; width:auto !important; margin:0 !important;  }
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

@media (min-width:1366px) and (max-width: 2559px) {
    #allfinancial {
        margin-right: 5px;
    }
}

@media (max-width:1500px){
    .popup_content {
        background: #ececec;
        height: 500px;
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
    $(document).on('click','#allfinancial',function(){
             
            $(".popup_main").show();
            $('body').css('overflow', 'hidden');
    });
</script>
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
 if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
 $URL .= "://";
 if ($_SERVER["SERVER_PORT"] != "80") {
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
	  <?php
	  mysql_close();
    mysql_close($cnx);
    ?>